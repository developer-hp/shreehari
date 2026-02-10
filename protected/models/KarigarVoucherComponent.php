<?php

/**
 * This is the model class for table "cp_karigar_voucher_component".
 *
 * @property integer $id
 * @property integer $karigar_voucher_line_id
 * @property string $component_type
 * @property string $name
 * @property string $wt
 * @property string $amount
 * @property integer $sort_order
 */
class KarigarVoucherComponent extends CActiveRecord
{
	public function tableName()
	{
		return 'cp_karigar_voucher_component';
	}

	public function rules()
	{
		return array(
			array('karigar_voucher_line_id', 'required'),
			array('karigar_voucher_line_id, sort_order', 'numerical', 'integerOnly' => true),
			array('wt, amount', 'numerical'),
			array('component_type', 'length', 'max' => 30),
			array('name', 'length', 'max' => 255),
			array('id, karigar_voucher_line_id, component_type, name', 'safe', 'on' => 'search'),
		);
	}

	public function relations()
	{
		return array(
			'line' => array(self::BELONGS_TO, 'KarigarVoucherLine', 'karigar_voucher_line_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'karigar_voucher_line_id' => 'Line',
			'component_type' => 'Component Type',
			'name' => 'Name',
			'wt' => 'Wt',
			'amount' => 'Amount',
			'sort_order' => 'Sort Order',
		);
	}

	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
}

