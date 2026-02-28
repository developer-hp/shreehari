<?php

/**
 * Supplier Voucher (header).
 */
class SupplierLedgerTxn extends CActiveRecord
{
	public $supplier_name;

	public function tableName()
	{
		return 'cp_supplier_ledger_txn';
	}

	public function rules()
	{
		return array(
			array('txn_date, supplier_id,sr_no', 'required'),
			array('supplier_id, issue_entry_id, created_by, is_deleted, is_locked, drcr', 'numerical', 'integerOnly' => true),
			array('total_fine_wt, total_amount', 'numerical'),
			array('sr_no, voucher_number', 'length', 'max' => 30),
			array('drcr', 'in', 'range' => array(IssueEntry::DRCR_DEBIT, IssueEntry::DRCR_CREDIT)),
			array('remark, created_at, supplier_name', 'safe'),
			array('id, txn_date, supplier_id, sr_no, voucher_number, issue_entry_id, drcr, remark, total_fine_wt, total_amount, created_at, created_by, is_deleted, is_locked, supplier_name', 'safe', 'on' => 'search'),
		);
	}

	public function relations()
	{
		return array(
			'supplier' => array(self::BELONGS_TO, 'Customer', 'supplier_id'),
			'issueEntry' => array(self::BELONGS_TO, 'IssueEntry', 'issue_entry_id'),
			'items' => array(self::HAS_MANY, 'SupplierLedgerTxnItem', 'txn_id', 'order' => 'items.sort_order ASC, items.id ASC'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'txn_date' => 'Date',
			'supplier_id' => 'Supplier',
			'supplier_name' => 'Supplier',
			'sr_no' => 'SR No',
			'voucher_number' => 'Voucher No',
			'issue_entry_id' => 'Issue Entry',
			'drcr' => 'DR/CR',
			'remark' => 'Remark',
			'total_fine_wt' => 'Total Fine Wt',
			'total_amount' => 'Total Amount',
			'created_at' => 'Created At',
			'created_by' => 'Created By',
			'is_deleted' => 'Deleted',
			'is_locked' => 'Locked',
		);
	}

	protected function beforeSave()
	{
		if (parent::beforeSave()) {
			$this->drcr = IssueEntry::DRCR_DEBIT;
			if ($this->isNewRecord) {
				if (empty($this->sr_no)) {
					try {
						$this->sr_no = DocumentNumberService::nextSrNo(DocumentNumberService::DOC_SUPPLIER_LEDGER);
					} catch (Exception $e) { }
				}
				$this->created_at = date('Y-m-d H:i:s');
				if (Yii::app()->user->id) $this->created_by = (int) Yii::app()->user->id;
				// Supplier Voucher is always Jama
			}
			if ($this->voucher_number === null || $this->voucher_number === '') {
				try {
					$this->voucher_number = DocumentNumberService::nextSrNo(DocumentNumberService::DOC_SUPPLIER_LEDGER_VOUCHER);
				} catch (Exception $e) {
					Yii::log('SupplierLedgerTxn voucher_number: ' . $e->getMessage(), 'error', 'application');
					$prefix = DocumentNumberService::getVoucherPrefix(DocumentNumberService::DOC_SUPPLIER_LEDGER_VOUCHER);
					$this->voucher_number = $prefix . ($this->id ?: date('YmdHis'));
				}
			}
			if (!empty($this->txn_date)) {
				$ts = strtotime($this->txn_date);
				if ($ts !== false) $this->txn_date = date('Y-m-d', $ts);
			}
			return true;
		}
		return false;
	}

	public function delete()
	{
		if ($this->getIsNewRecord()) throw new CDbException('Cannot delete new record.');
		if ($this->issue_entry_id) {
			$entry = IssueEntry::model()->findByPk($this->issue_entry_id);
			if ($entry) $entry->delete();
		}
		$this->is_deleted = 1;
		return $this->save(false);
	}

	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->with = array('supplier');
		$criteria->compare('t.id', $this->id);
		if ($this->is_deleted === null || $this->is_deleted === '') $criteria->compare('t.is_deleted', 0);
		$criteria->compare('t.supplier_id', $this->supplier_id);
		$criteria->compare('t.sr_no', $this->sr_no, true);
		$criteria->compare('t.voucher_number', $this->voucher_number, true);
		$criteria->compare('t.txn_date', $this->txn_date, true);
		$criteria->compare('t.is_locked', $this->is_locked);
		if (!empty($this->supplier_name))
			$criteria->compare('supplier.name', $this->supplier_name, true);
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort' => array('defaultOrder' => 't.txn_date DESC, t.id DESC'),
		));
	}

	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
}
