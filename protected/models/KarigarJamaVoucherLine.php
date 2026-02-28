<?php

class KarigarJamaVoucherLine extends CActiveRecord
{
	public function tableName()
	{
		return 'cp_karigar_jama_voucher_line';
	}

	public function rules()
	{
		return array(
			array('voucher_id', 'required'),
			array('voucher_id, sort_order', 'numerical', 'integerOnly' => true),
			array('sr_no', 'length', 'max' => 20),
			array('order_no, customer_name, item_name', 'length', 'max' => 255),
			array('carat', 'length', 'max' => 10),
			array('carat', 'in', 'range' => array_keys(self::getCaratOptions()), 'allowEmpty' => true),
			array('remark', 'length', 'max' => 500),
			array('psc, gross_wt, net_wt, touch_pct, fine_wt', 'numerical'),
			array('id, voucher_id, sr_no, order_no, customer_name, item_name, carat, psc, gross_wt, net_wt, touch_pct, fine_wt, remark, sort_order', 'safe', 'on' => 'search'),
		);
	}

	public static function getCaratOptions()
	{
		return array(
			'24K' => '24K',
			'22K' => '22K',
			'18K' => '18K',
			'14K' => '14K',
		);
	}

	public function relations()
	{
		return array(
			'voucher' => array(self::BELONGS_TO, 'KarigarJamaVoucher', 'voucher_id'),
			'stones' => array(self::HAS_MANY, 'KarigarJamaLineStone', 'line_id'),
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

	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
}
