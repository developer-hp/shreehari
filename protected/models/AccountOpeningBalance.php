<?php

/**
 * This is the model class for table "cp_account_opening_balance".
 *
 * @property integer $id
 * @property integer $customer_id
 * @property string $opening_fine_wt
 * @property integer $opening_fine_wt_drcr 1=DR, 2=CR
 * @property string $opening_amount
 * @property integer $opening_amount_drcr 1=DR, 2=CR
 * @property integer $is_deleted
 * @property string $created_at
 * @property integer $created_by
 */
class AccountOpeningBalance extends CActiveRecord
{
	const DRCR_DEBIT = 1;
	const DRCR_CREDIT = 2;

	/** Virtual attribute for grid search by customer name (relation) */
	public $customer_name;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cp_account_opening_balance';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('customer_id', 'required'),
			array('customer_id', 'uniqueCustomer'),
			array('customer_id, opening_fine_wt_drcr, opening_amount_drcr, is_deleted, created_by', 'numerical', 'integerOnly'=>true),
			array('opening_fine_wt, opening_amount', 'numerical'),
			array('opening_fine_wt_drcr', 'in', 'range'=>array(self::DRCR_DEBIT, self::DRCR_CREDIT)),
			array('opening_amount_drcr', 'in', 'range'=>array(self::DRCR_DEBIT, self::DRCR_CREDIT)),
			array('created_at', 'safe'),
			array('id, customer_id, customer_name, opening_fine_wt, opening_fine_wt_drcr, opening_amount, opening_amount_drcr, is_deleted, created_at, created_by', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * Validates that customer_id is unique among non-deleted opening balances.
	 * On update, the current record is excluded from the check.
	 */
	public function uniqueCustomer($attribute, $params)
	{
		$criteria = new CDbCriteria();
		$criteria->condition = 'customer_id = :cid AND is_deleted = 0';
		$criteria->params = array(':cid' => (int) $this->customer_id);
		if (!$this->isNewRecord) {
			$criteria->addCondition('id != :id');
			$criteria->params[':id'] = $this->id;
		}
		if (self::model()->find($criteria) !== null) {
			$this->addError($attribute, 'Opening balance for this account already exists.');
		}
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'customer' => array(self::BELONGS_TO, 'Customer', 'customer_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'customer_id' => 'Account',
			'customer_name' => 'Account',
			'opening_fine_wt' => 'Opening Fine Wt',
			'opening_fine_wt_drcr' => 'Fine (DR/CR)',
			'opening_amount' => 'Opening Amount',
			'opening_amount_drcr' => 'Amount (DR/CR)',
			'is_deleted' => 'Deleted',
			'created_at' => 'Created At',
			'created_by' => 'Created By',
		);
	}

	/**
	 * @return array options for DR/CR dropdown
	 */
	public static function getDrcrOptions()
	{
		return array(
			self::DRCR_DEBIT => 'DR (Debit)',
			self::DRCR_CREDIT => 'CR (Credit)',
		);
	}

	/**
	 * Soft delete: set is_deleted = 1 instead of removing the row.
	 * @return bool
	 */
	public function delete()
	{
		if ($this->getIsNewRecord())
			throw new CDbException(Yii::t('yii', 'The active record cannot be deleted because it is new.'));
		$this->is_deleted = 1;
		return $this->save(false);
	}

	/**
	 * Whether this record is soft-deleted.
	 * @return bool
	 */
	public function getIsDeleted()
	{
		return (int) $this->is_deleted === 1;
	}

	/**
	 * Restore a soft-deleted record (set is_deleted = 0).
	 * @return bool
	 */
	public function restore()
	{
		$this->is_deleted = 0;
		return $this->save(false);
	}

	/** @var int|null customer_id before save (for afterSave to update old customer closing) */
	private $_oldCustomerId;

	/**
	 * Before save: set created_at and created_by for new records.
	 */
	protected function beforeSave()
	{
		if (parent::beforeSave()) {
			if (!$this->isNewRecord) {
				$old = self::model()->findByPk($this->id);
				$this->_oldCustomerId = $old ? (int) $old->customer_id : null;
			}
			if ($this->isNewRecord) {
				if (empty($this->created_at))
					$this->created_at = date('Y-m-d H:i:s');
				if (Yii::app()->user->id)
					$this->created_by = (int) Yii::app()->user->id;
			}
			return true;
		}
		return false;
	}

	/**
	 * After save: update customer closing balance (and old customer if customer_id changed).
	 */
	protected function afterSave()
	{
		parent::afterSave();
		$cid = (int) $this->customer_id;
		Customer::updateClosingBalance($cid);
		if ($this->_oldCustomerId !== null && $this->_oldCustomerId !== $cid)
			Customer::updateClosingBalance($this->_oldCustomerId);
	}

	/**
	 * @return CActiveDataProvider
	 */
	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->with = array('customer');
		$criteria->compare('t.id', $this->id);
		// Default: show only non-deleted unless filter is explicitly set
		if ($this->is_deleted === null || $this->is_deleted === '')
			$criteria->compare('t.is_deleted', 0);
		$criteria->compare('t.customer_id', $this->customer_id);
		// Search by customer name (relation)
		if (!empty($this->customer_name))
			$criteria->compare('customer.name', $this->customer_name, true);
		$criteria->compare('t.opening_fine_wt', $this->opening_fine_wt, true);
		$criteria->compare('t.opening_fine_wt_drcr', $this->opening_fine_wt_drcr);
		$criteria->compare('t.opening_amount', $this->opening_amount, true);
		$criteria->compare('t.opening_amount_drcr', $this->opening_amount_drcr);
		$criteria->compare('t.is_deleted', $this->is_deleted);
		// Date filter: accept d-m-Y or Y-m-d and compare by date
		if (!empty($this->created_at)) {
			$ts = strtotime($this->created_at);
			if ($ts !== false)
				$criteria->compare('DATE(t.created_at)', date('Y-m-d', $ts));
			else
				$criteria->compare('t.created_at', $this->created_at, true);
		}
		$criteria->compare('t.created_by', $this->created_by);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort' => array(
				'defaultOrder' => 't.id DESC',
				'attributes' => array(
					'customer_name' => array(
						'asc' => 'customer.name',
						'desc' => 'customer.name DESC',
					),
					'*',
				),
			),
		));
	}

	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
}
