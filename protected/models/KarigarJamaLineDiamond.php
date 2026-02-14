<?php

class KarigarJamaLineDiamond extends CActiveRecord
{
	public function tableName()
	{
		return 'cp_karigar_jama_line_diamond';
	}

	public function rules()
	{
		return array(
			array('line_id', 'required'),
			array('line_id', 'numerical', 'integerOnly' => true),
			array('diamond_wt, diamond_amount', 'numerical'),
		);
	}

	public function relations()
	{
		return array(
			'line' => array(self::BELONGS_TO, 'KarigarJamaVoucherLine', 'line_id'),
		);
	}

	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
}
