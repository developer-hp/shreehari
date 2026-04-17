<?php

class DiamondVoucher extends CActiveRecord
{
	public $account_name;
	public $subitem_name;

	public function tableName()
	{
		return 'cp_diamond_voucher';
	}

	public function rules()
	{
		return array(
			array('voucher_date, customer_id, subitem_type_id, drcr', 'required'),
			array('voucher_date', 'validateNotFutureDate'),
			array('customer_id, subitem_type_id, issue_entry_id, drcr, created_by, is_deleted, is_locked', 'numerical', 'integerOnly' => true),
			array('qty, rate, amount', 'numerical'),
			array('voucher_number', 'length', 'max' => 30),
			array('drcr', 'in', 'range' => array(IssueEntry::DRCR_DEBIT, IssueEntry::DRCR_CREDIT)),
			array('remarks, created_at, account_name, subitem_name', 'safe'),
			array('id, voucher_date, voucher_number, customer_id, subitem_type_id, qty, rate, amount, drcr, issue_entry_id, remarks, created_at, created_by, is_deleted, is_locked, account_name, subitem_name', 'safe', 'on' => 'search'),
		);
	}

	public function validateNotFutureDate($attribute, $params)
	{
		if (!empty($this->$attribute)) {
			$inputDate = strtotime($this->$attribute);
			$today = strtotime(date('Y-m-d'));
			if ($inputDate > $today) {
				$this->addError($attribute, 'Future date is not allowed.');
			}
		}
	}

	public function relations()
	{
		return array(
			'account' => array(self::BELONGS_TO, 'Customer', 'customer_id'),
			'subitemType' => array(self::BELONGS_TO, 'SubitemType', 'subitem_type_id'),
			'issueEntry' => array(self::BELONGS_TO, 'IssueEntry', 'issue_entry_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'voucher_date' => 'Date',
			'voucher_number' => 'Voucher No',
			'customer_id' => 'Account',
			'account_name' => 'Account',
			'subitem_type_id' => 'Subitem',
			'subitem_name' => 'Subitem',
			'qty' => 'Qty',
			'rate' => 'Rate',
			'amount' => 'Amount',
			'drcr' => implode('/', IssueEntry::getDrcrOptions()),
			'issue_entry_id' => 'Issue Entry',
			'remarks' => 'Remarks',
			'created_at' => 'Created At',
			'created_by' => 'Created By',
			'is_deleted' => 'Deleted',
			'is_locked' => 'Locked',
		);
	}

	protected function beforeSave()
	{
		if (parent::beforeSave()) {
			$this->amount = round((float) $this->qty * (float) $this->rate, 2);
			if ($this->isNewRecord) {
				if (empty($this->voucher_number)) {
					try {
						$this->voucher_number = DocumentNumberService::nextSrNo(DocumentNumberService::DOC_DIAMOND_VOUCHER);
					} catch (Exception $e) {
						$prefix = DocumentNumberService::getVoucherPrefix(DocumentNumberService::DOC_DIAMOND_VOUCHER);
						$this->voucher_number = $prefix . date('YmdHis');
					}
				}
				$this->created_at = date('Y-m-d H:i:s');
				if (Yii::app()->user->id) {
					$this->created_by = (int) Yii::app()->user->id;
				}
			}
			if (!empty($this->voucher_date)) {
				$ts = strtotime($this->voucher_date);
				if ($ts !== false) {
					$this->voucher_date = date('Y-m-d', $ts);
				}
			}
			return true;
		}
		return false;
	}

	public function delete()
	{
		if ($this->getIsNewRecord()) {
			throw new CDbException('Cannot delete new record.');
		}
		if ($this->issue_entry_id) {
			$entry = IssueEntry::model()->findByPk($this->issue_entry_id);
			if ($entry) {
				$entry->delete();
			}
		}
		$this->is_deleted = 1;
		return $this->save(false);
	}

	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->with = array('account', 'subitemType');
		$criteria->compare('t.id', $this->id);
		if ($this->is_deleted === null || $this->is_deleted === '') {
			$criteria->compare('t.is_deleted', 0);
		}
		$criteria->compare('t.voucher_number', $this->voucher_number, true);
		if (!empty($this->voucher_date)) {
			$ts = strtotime($this->voucher_date);
			if ($ts !== false) {
				$criteria->compare('t.voucher_date', date('Y-m-d', $ts));
			} else {
				$criteria->compare('t.voucher_date', $this->voucher_date, true);
			}
		}
		$criteria->compare('t.customer_id', $this->customer_id);
		$criteria->compare('t.subitem_type_id', $this->subitem_type_id);
		$criteria->compare('t.qty', $this->qty);
		$criteria->compare('t.rate', $this->rate);
		$criteria->compare('t.amount', $this->amount);
		$criteria->compare('t.drcr', $this->drcr);
		$criteria->compare('t.is_locked', $this->is_locked);
		if (!empty($this->account_name)) {
			$criteria->compare('account.name', $this->account_name, true);
		}
		if (!empty($this->subitem_name)) {
			$criteria->compare('subitemType.name', $this->subitem_name, true);
		}

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort' => array(
				'defaultOrder' => 't.voucher_date DESC, t.id DESC',
				'attributes' => array(
					'account_name' => array('asc' => 'account.name', 'desc' => 'account.name DESC'),
					'subitem_name' => array('asc' => 'subitemType.name', 'desc' => 'subitemType.name DESC'),
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