<?php

/**
 * Supplier Voucher Item (one product line).
 * fine_wt = (touch_pct/100) * net_wt
 * Charge type comes from cp_subitem_types (SubitemType).
 */
class SupplierLedgerTxnItem extends CActiveRecord
{
	public function tableName()
	{
		return 'cp_supplier_ledger_txn_item';
	}

	public function rules()
	{
		return array(
			array('txn_id', 'required'),
			array('txn_id, sort_order', 'numerical', 'integerOnly' => true),
			array('sr_no', 'length', 'max' => 20),
			array('item_name', 'length', 'max' => 255),
			array('ct', 'length', 'max' => 10),
			array('ct', 'in', 'range' => array_keys(self::getCaratOptions()), 'allowEmpty' => true),
			array('gross_wt, net_wt, touch_pct, fine_wt, item_total', 'numerical'),
			array('id, txn_id, sr_no, item_name, ct, gross_wt, net_wt, touch_pct, fine_wt, item_total, sort_order', 'safe', 'on' => 'search'),
		);
	}

	public function relations()
	{
		return array(
			'txn' => array(self::BELONGS_TO, 'SupplierLedgerTxn', 'txn_id'),
			'charges' => array(self::HAS_MANY, 'SupplierLedgerTxnItemCharge', 'txn_item_id'),
		);
	}

	public function beforeSave()
	{
		if (parent::beforeSave()) {
			$net = (float) $this->net_wt;
			$touch = (float) $this->touch_pct;
			$this->fine_wt = round(($touch / 100) * $net, 3);
			return true;
		}
		return false;
	}

	/** @return array id => name for charge type dropdown (from cp_subitem_types) */
	public static function getChargeTypeLabels()
	{
		return SubitemType::getList();
	}

	/** @return array carat options for item line */
	public static function getCaratOptions()
	{
		return KarigarJamaVoucherLine::getCaratOptions();
	}

	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
}
