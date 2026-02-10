<?php

/**
 * This is the model class for table "cp_ledger_account".
 *
 * @property integer $id
 * @property string $name
 * @property integer $type
 * @property integer $party_customer_id
 * @property string $opening_fine_wt
 * @property integer $opening_fine_wt_drcr
 * @property string $opening_amount
 * @property integer $opening_amount_drcr
 * @property integer $is_deleted
 * @property string $created_at
 * @property integer $created_by
 */
class LedgerAccount extends CActiveRecord
{
	const TYPE_SUPPLIER = 1;
	const TYPE_KARIGAR = 2;

	const DRCR_DR = 1;
	const DRCR_CR = 2;

	public function tableName()
	{
		return 'cp_ledger_account';
	}

	public function rules()
	{
		return array(
			array('name, type', 'required'),
			array('type, party_customer_id, opening_fine_wt_drcr, opening_amount_drcr, is_deleted, created_by', 'numerical', 'integerOnly' => true),
			array('opening_fine_wt', 'numerical'),
			array('opening_amount', 'numerical'),
			array('name', 'length', 'max' => 255),
			array('created_at', 'safe'),
			array('id, name, type, party_customer_id, opening_fine_wt, opening_fine_wt_drcr, opening_amount, opening_amount_drcr, is_deleted', 'safe', 'on' => 'search'),
		);
	}

	public function relations()
	{
		return array(
			'partyCustomer' => array(self::BELONGS_TO, 'Customer', 'party_customer_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'type' => 'Type',
			'party_customer_id' => 'Linked Party',
			'opening_fine_wt' => 'Opening Fine Wt',
			'opening_fine_wt_drcr' => 'Opening Fine Wt Dr/Cr',
			'opening_amount' => 'Opening Amount',
			'opening_amount_drcr' => 'Opening Amount Dr/Cr',
			'is_deleted' => 'Is Deleted',
			'created_at' => 'Created At',
			'created_by' => 'Created By',
		);
	}

	protected function beforeSave()
	{
		if (parent::beforeSave()) {
			$now = date('Y-m-d H:i:s');
			if ($this->isNewRecord && empty($this->created_at)) {
				$this->created_at = $now;
			}
			return true;
		}
		return false;
	}

	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.name', $this->name, true);
		$criteria->compare('t.type', $this->type);
		$criteria->compare('t.party_customer_id', $this->party_customer_id);
		$criteria->compare('t.is_deleted', 0);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort' => array('defaultOrder' => 't.name asc'),
		));
	}

	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public static function typeOptions()
	{
		return array(
			self::TYPE_SUPPLIER => 'Supplier',
			self::TYPE_KARIGAR => 'Karigar',
		);
	}

	public static function drcrOptions()
	{
		return array(
			self::DRCR_DR => 'Dr',
			self::DRCR_CR => 'Cr',
		);
	}
}

