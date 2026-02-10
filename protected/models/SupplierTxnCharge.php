<?php

/**
 * This is the model class for table "cp_supplier_txn_charge".
 *
 * @property integer $id
 * @property integer $supplier_txn_item_id
 * @property string $charge_type
 * @property string $name
 * @property string $qty
 * @property string $rate
 * @property string $amount
 * @property string $unit
 * @property integer $sort_order
 */
class SupplierTxnCharge extends CActiveRecord
{
	public function tableName()
	{
		return 'cp_supplier_txn_charge';
	}

	public function rules()
	{
		return array(
			array('supplier_txn_item_id', 'required'),
			array('supplier_txn_item_id, sort_order', 'numerical', 'integerOnly' => true),
			array('qty, rate, amount', 'numerical'),
			array('charge_type', 'length', 'max' => 30),
			array('unit', 'length', 'max' => 10),
			array('name', 'length', 'max' => 255),
			array('id, supplier_txn_item_id, charge_type, name', 'safe', 'on' => 'search'),
		);
	}

	public function relations()
	{
		return array(
			'item' => array(self::BELONGS_TO, 'SupplierTxnItem', 'supplier_txn_item_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'supplier_txn_item_id' => 'Item',
			'charge_type' => 'Charge Type',
			'name' => 'Name',
			'qty' => 'Qty',
			'rate' => 'Rate',
			'amount' => 'Amount',
			'unit' => 'Unit',
			'sort_order' => 'Sort Order',
		);
	}

	protected function beforeValidate()
	{
		if (parent::beforeValidate()) {
			// Auto-calc amount when qty & rate are provided and amount is empty.
			if (($this->amount === null || $this->amount === '') && $this->qty !== null && $this->qty !== '' && $this->rate !== null && $this->rate !== '') {
				$this->amount = round(((float)$this->qty) * ((float)$this->rate), 2);
			}
			return true;
		}
		return false;
	}

	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
}

