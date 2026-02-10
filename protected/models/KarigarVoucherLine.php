<?php

/**
 * This is the model class for table "cp_karigar_voucher_line".
 *
 * @property integer $id
 * @property integer $karigar_voucher_id
 * @property string $order_no
 * @property integer $customer_account_id
 * @property string $item_name
 * @property integer $psc
 * @property string $gross_wt
 * @property string $net_wt
 * @property string $touch_pct
 * @property string $fine_wt
 * @property string $remark
 * @property integer $sort_order
 */
class KarigarVoucherLine extends CActiveRecord
{
	public function tableName()
	{
		return 'cp_karigar_voucher_line';
	}

	public function rules()
	{
		return array(
			array('karigar_voucher_id, item_name', 'required'),
			array('karigar_voucher_id, customer_account_id, psc, sort_order', 'numerical', 'integerOnly' => true),
			array('gross_wt, net_wt, touch_pct, fine_wt', 'numerical'),
			array('order_no', 'length', 'max' => 50),
			array('item_name, remark', 'length', 'max' => 255),
			array('id, karigar_voucher_id, item_name', 'safe', 'on' => 'search'),
		);
	}

	public function relations()
	{
		return array(
			'voucher' => array(self::BELONGS_TO, 'KarigarVoucher', 'karigar_voucher_id'),
			'customer' => array(self::BELONGS_TO, 'Customer', 'customer_account_id'),
			'components' => array(self::HAS_MANY, 'KarigarVoucherComponent', 'karigar_voucher_line_id', 'order' => 'components.sort_order asc, components.id asc'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'karigar_voucher_id' => 'Voucher',
			'order_no' => 'Order No',
			'customer_account_id' => 'Customer',
			'item_name' => 'Item',
			'psc' => 'Pcs',
			'gross_wt' => 'Gross Wt',
			'net_wt' => 'Net Wt',
			'touch_pct' => 'Touch %',
			'fine_wt' => 'Fine Wt',
			'remark' => 'Remark',
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

	public function getComponentAmountTotal()
	{
		$criteria = new CDbCriteria;
		$criteria->select = 'SUM(amount) AS amount';
		$criteria->compare('karigar_voucher_line_id', (int)$this->id);
		$row = KarigarVoucherComponent::model()->find($criteria);
		return $row && $row->amount !== null ? (float)$row->amount : 0.0;
	}

	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
}

