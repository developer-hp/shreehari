<?php

/**
 * This is the model class for table "cp_supplier_txn_item".
 *
 * @property integer $id
 * @property integer $supplier_txn_id
 * @property integer $sr_no_line
 * @property string $item_name
 * @property string $ct
 * @property string $gross_wt
 * @property string $net_wt
 * @property string $touch_pct
 * @property string $fine_wt
 * @property integer $sort_order
 */
class SupplierTxnItem extends CActiveRecord
{
	public function tableName()
	{
		return 'cp_supplier_txn_item';
	}

	public function rules()
	{
		return array(
			array('supplier_txn_id, item_name', 'required'),
			array('supplier_txn_id, sr_no_line, sort_order', 'numerical', 'integerOnly' => true),
			array('ct, gross_wt, net_wt, touch_pct, fine_wt', 'numerical'),
			array('item_name', 'length', 'max' => 255),
			array('id, supplier_txn_id, item_name', 'safe', 'on' => 'search'),
		);
	}

	public function relations()
	{
		return array(
			'txn' => array(self::BELONGS_TO, 'SupplierTxn', 'supplier_txn_id'),
			'charges' => array(self::HAS_MANY, 'SupplierTxnCharge', 'supplier_txn_item_id', 'order' => 'charges.sort_order asc, charges.id asc'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'supplier_txn_id' => 'Supplier Txn',
			'sr_no_line' => 'Line No',
			'item_name' => 'Item',
			'ct' => 'Ct',
			'gross_wt' => 'Gross Wt',
			'net_wt' => 'Net Wt',
			'touch_pct' => 'Touch %',
			'fine_wt' => 'Fine Wt',
			'sort_order' => 'Sort Order',
		);
	}

	protected function beforeValidate()
	{
		if (parent::beforeValidate()) {
			$this->fine_wt = LedgerCalc::fineWt($this->net_wt, $this->touch_pct);
			return true;
		}
		return false;
	}

	public function getChargeAmountTotal()
	{
		$criteria = new CDbCriteria;
		$criteria->select = 'SUM(amount) AS amount';
		$criteria->compare('supplier_txn_item_id', (int)$this->id);
		$row = SupplierTxnCharge::model()->find($criteria);
		return $row && $row->amount !== null ? (float)$row->amount : 0.0;
	}

	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
}

