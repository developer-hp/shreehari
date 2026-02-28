<?php

/**
 * Model for table "cp_issue_entry".
 *
 * @property integer $id
 * @property string $sr_no
 * @property string $issue_date
 * @property integer $customer_id
 * @property string $carat
 * @property string $weight
 * @property string $fine_wt
 * @property string $amount
 * @property integer $drcr 1=DR, 2=CR
 * @property string $remarks
 * @property integer $created_by
 * @property string $created_at
 * @property string $updated_at
 * @property integer $is_deleted
 * @property integer $is_voucher 0=manual, 1=from Jama/Supplier Ledger
 */
class IssueEntry extends CActiveRecord
{
	const DRCR_DEBIT = 1;
	const DRCR_CREDIT = 2;

	/** Virtual attribute for grid search by customer name */
	public $customer_name;

	public function tableName()
	{
		return 'cp_issue_entry';
	}

	public function rules()
	{
		return array(
			array('issue_date, customer_id, drcr', 'required'),
			array('customer_id, drcr, created_by, is_deleted, is_voucher', 'numerical', 'integerOnly' => true),
			array('weight, fine_wt, amount', 'numerical'),
			array('carat', 'length', 'max' => 10),
			array('carat', 'in', 'range' => array_keys(KarigarJamaVoucherLine::getCaratOptions()), 'allowEmpty' => true),
			array('drcr', 'in', 'range' => array(self::DRCR_DEBIT, self::DRCR_CREDIT)),
			array('sr_no', 'length', 'max' => 30),
			array('remarks, created_at, updated_at, carat', 'safe'),
			array('remarks', 'required'),
			array('id, sr_no, issue_date, customer_id, carat, weight, fine_wt, amount, drcr, remarks, created_by, created_at, updated_at, is_deleted, is_voucher, customer_name', 'safe', 'on' => 'search'),
		);
	}

	public function relations()
	{
		return array(
			'customer' => array(self::BELONGS_TO, 'Customer', 'customer_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'sr_no' => 'SR No',
			'issue_date' => 'Issue Date',
			'customer_id' => 'Account',
			'customer_name' => 'Account',
			'carat' => 'Carat',
			'weight' => 'Weight',
			'fine_wt' => 'Fine Wt',
			'amount' => 'Amount',
			'drcr' => implode('/', Yii::app()->params['drcrOptions']),
			'remarks' => 'Remarks',
			'created_by' => 'Created By',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
			'is_deleted' => 'Deleted',
			'is_voucher' => 'From Voucher',
		);
	}

	public static function getDrcrOptions()
	{
		return Yii::app()->params['drcrOptions'];
	}

	/** @var int|null customer_id before save (for afterSave to update old customer closing) */
	private $_oldCustomerId;

	protected function beforeSave()
	{
		if (parent::beforeSave()) {
			if (!$this->isNewRecord) {
				$old = self::model()->findByPk($this->id);
				$this->_oldCustomerId = $old ? (int) $old->customer_id : null;
			}
			$now = date('Y-m-d H:i:s');
			if (!empty($this->issue_date)) {
				$ts = strtotime($this->issue_date);
				if ($ts !== false) $this->issue_date = date('Y-m-d', $ts);
			}
			if ($this->isNewRecord) {
				if (empty($this->sr_no)) {
					try {
						$this->sr_no = DocumentNumberService::nextSrNo(DocumentNumberService::DOC_ISSUE);
					} catch (Exception $e) {
						$this->sr_no = 'ISS' . date('YmdHis');
					}
				}
				if (empty($this->created_at)) $this->created_at = $now;
				if (Yii::app()->user->id) $this->created_by = (int) Yii::app()->user->id;


			}
			$this->updated_at = $now;
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

	public function delete()
	{
		if ($this->getIsNewRecord())
			throw new CDbException(Yii::t('yii', 'The active record cannot be deleted because it is new.'));
		$this->is_deleted = 1;
		return $this->save(false);
	}

	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->with = array('customer');
		$criteria->compare('t.id', $this->id);
		if ($this->is_deleted === null || $this->is_deleted === '')
			$criteria->compare('t.is_deleted', 0);
		$criteria->compare('t.sr_no', $this->sr_no, true);
		$criteria->compare('t.customer_id', $this->customer_id);
		if (!empty($this->customer_name))
			$criteria->compare('customer.name', $this->customer_name, true);
		if (!empty($this->issue_date)) {
			$ts = strtotime($this->issue_date);
			if ($ts !== false)
				$criteria->compare('t.issue_date', date('Y-m-d', $ts));
			else
				$criteria->compare('t.issue_date', $this->issue_date, true);
		}
		$criteria->compare('t.fine_wt', $this->fine_wt, true);
		$criteria->compare('t.carat', $this->carat, true);
		$criteria->compare('t.weight', $this->weight, true);
		$criteria->compare('t.amount', $this->amount, true);
		$criteria->compare('t.drcr', $this->drcr);
		$criteria->compare('t.remarks', $this->remarks, true);
		$criteria->compare('t.is_deleted', $this->is_deleted);
		$criteria->compare('t.is_voucher', $this->is_voucher);
		$criteria->compare('t.created_by', $this->created_by);
		if (!empty($this->created_at)) {
			$ts = strtotime($this->created_at);
			if ($ts !== false)
				$criteria->compare('DATE(t.created_at)', date('Y-m-d', $ts));
			else
				$criteria->compare('t.created_at', $this->created_at, true);
		}

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort' => array(
				'defaultOrder' => 't.id DESC',
				'attributes' => array(
					'customer_name' => array('asc' => 'customer.name', 'desc' => 'customer.name DESC'),
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
