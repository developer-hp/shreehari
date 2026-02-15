<?php

/**
 * Charge line for a supplier ledger item (quantity, rate, amount).
 */
class SupplierLedgerTxnItemCharge extends CActiveRecord
{
	public function tableName()
	{
		return 'cp_supplier_ledger_txn_item_charge';
	}

	public function rules()
	{
		return array(
			array('txn_item_id, charge_type', 'required'),
			array('txn_item_id, charge_type', 'numerical', 'integerOnly' => true),
			array('charge_name', 'length', 'max' => 255),
			array('quantity, rate, amount', 'numerical'),
		);
	}

	public function relations()
	{
		return array(
			'txnItem' => array(self::BELONGS_TO, 'SupplierLedgerTxnItem', 'txn_item_id'),
			'subitemType' => array(self::BELONGS_TO, 'SubitemType', 'charge_type'),
		);
	}

	public function beforeSave()
	{
		if (parent::beforeSave()) {
			$q = $this->quantity === null || $this->quantity === '' ? 0 : (float) $this->quantity;
			$r = $this->rate === null || $this->rate === '' ? 0 : (float) $this->rate;
			if ($q == 0 && $r == 0) {
				return false;
			}
			$this->amount = round($q * $r, 2);
			return true;
		}
		return false;
	}

	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
}
