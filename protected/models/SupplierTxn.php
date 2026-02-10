<?php

/**
 * This is the model class for table "cp_supplier_txn".
 *
 * @property integer $id
 * @property string $sr_no
 * @property string $txn_date
 * @property integer $supplier_account_id
 * @property string $remarks
 * @property integer $created_by
 * @property string $created_at
 * @property string $updated_at
 * @property integer $is_deleted
 */
class SupplierTxn extends CActiveRecord
{
	public $start;
	public $end;

	public function tableName()
	{
		return 'cp_supplier_txn';
	}

	public function rules()
	{
		return array(
			array('txn_date, supplier_account_id', 'required'),
			array('supplier_account_id, created_by, is_deleted', 'numerical', 'integerOnly' => true),
			array('sr_no', 'length', 'max' => 30),
			array('remarks, created_at, updated_at', 'safe'),
			array('id, sr_no, txn_date, supplier_account_id, is_deleted', 'safe', 'on' => 'search'),
		);
	}

	public function relations()
	{
		return array(
			'supplierAccount' => array(self::BELONGS_TO, 'LedgerAccount', 'supplier_account_id'),
			'items' => array(self::HAS_MANY, 'SupplierTxnItem', 'supplier_txn_id', 'order' => 'items.sort_order asc, items.id asc'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'sr_no' => 'Sr No',
			'txn_date' => 'Date',
			'supplier_account_id' => 'Supplier',
			'remarks' => 'Remarks',
			'created_by' => 'Created By',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
			'is_deleted' => 'Is Deleted',
		);
	}

	protected function beforeSave()
	{
		if (parent::beforeSave()) {
			$now = date('Y-m-d H:i:s');
			if ($this->isNewRecord) {
				if (empty($this->created_at)) $this->created_at = $now;
				if (empty($this->created_by) && !Yii::app()->user->isGuest) {
					$this->created_by = (int)Yii::app()->user->id;
				}
			}
			$this->updated_at = $now;
			return true;
		}
		return false;
	}

	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->with = array('supplierAccount');

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.sr_no', $this->sr_no, true);
		$criteria->compare('t.supplier_account_id', $this->supplier_account_id);
		if (!empty($this->txn_date)) {
			$criteria->compare('t.txn_date', date('Y-m-d', strtotime($this->txn_date)), true);
		}
		if (!empty($_REQUEST['start'])) {
			$this->start = $_REQUEST['start'];
			$start = date('Y-m-d', strtotime($this->start));
			$criteria->addCondition("t.txn_date >= '{$start}'");
		}
		if (!empty($_REQUEST['end'])) {
			$this->end = $_REQUEST['end'];
			$end = date('Y-m-d', strtotime($this->end));
			$criteria->addCondition("t.txn_date <= '{$end}'");
		}
		$criteria->compare('t.is_deleted', 0);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort' => array('defaultOrder' => 't.txn_date desc, t.id desc'),
		));
	}

	public function getTotalFineWt()
	{
		$criteria = new CDbCriteria;
		$criteria->select = 'SUM(fine_wt) AS fine_wt';
		$criteria->compare('supplier_txn_id', (int)$this->id);
		$row = SupplierTxnItem::model()->find($criteria);
		return $row && $row->fine_wt !== null ? (float)$row->fine_wt : 0.0;
	}

	public function getTotalChargeAmount()
	{
		$sql = "SELECT SUM(c.amount) AS amt
		        FROM cp_supplier_txn_charge c
		        INNER JOIN cp_supplier_txn_item i ON i.id = c.supplier_txn_item_id
		        WHERE i.supplier_txn_id = :txn_id";
		$amt = Yii::app()->db->createCommand($sql)->queryScalar(array(':txn_id' => (int)$this->id));
		return $amt !== null ? (float)$amt : 0.0;
	}

	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
}

