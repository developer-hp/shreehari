<?php

/**
 * This is the model class for table "cp_karigar_voucher".
 *
 * @property integer $id
 * @property string $sr_no
 * @property string $voucher_date
 * @property integer $karigar_account_id
 * @property string $remarks
 * @property integer $created_by
 * @property string $created_at
 * @property string $updated_at
 * @property integer $is_deleted
 */
class KarigarVoucher extends CActiveRecord
{
	public $start;
	public $end;

	public function tableName()
	{
		return 'cp_karigar_voucher';
	}

	public function rules()
	{
		return array(
			array('voucher_date, karigar_account_id', 'required'),
			array('karigar_account_id, created_by, is_deleted', 'numerical', 'integerOnly' => true),
			array('sr_no', 'length', 'max' => 30),
			array('remarks, created_at, updated_at', 'safe'),
			array('id, sr_no, voucher_date, karigar_account_id, is_deleted', 'safe', 'on' => 'search'),
		);
	}

	public function relations()
	{
		return array(
			'karigarAccount' => array(self::BELONGS_TO, 'LedgerAccount', 'karigar_account_id'),
			'lines' => array(self::HAS_MANY, 'KarigarVoucherLine', 'karigar_voucher_id', 'order' => 'lines.sort_order asc, lines.id asc'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'sr_no' => 'Sr No',
			'voucher_date' => 'Date',
			'karigar_account_id' => 'Karigar',
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
		$criteria->with = array('karigarAccount');

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.sr_no', $this->sr_no, true);
		$criteria->compare('t.karigar_account_id', $this->karigar_account_id);
		if (!empty($this->voucher_date)) {
			$criteria->compare('t.voucher_date', date('Y-m-d', strtotime($this->voucher_date)), true);
		}
		if (!empty($_REQUEST['start'])) {
			$this->start = $_REQUEST['start'];
			$start = date('Y-m-d', strtotime($this->start));
			$criteria->addCondition("t.voucher_date >= '{$start}'");
		}
		if (!empty($_REQUEST['end'])) {
			$this->end = $_REQUEST['end'];
			$end = date('Y-m-d', strtotime($this->end));
			$criteria->addCondition("t.voucher_date <= '{$end}'");
		}
		$criteria->compare('t.is_deleted', 0);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort' => array('defaultOrder' => 't.voucher_date desc, t.id desc'),
		));
	}

	public function getTotalFineWt()
	{
		$criteria = new CDbCriteria;
		$criteria->select = 'SUM(fine_wt) AS fine_wt';
		$criteria->compare('karigar_voucher_id', (int)$this->id);
		$row = KarigarVoucherLine::model()->find($criteria);
		return $row && $row->fine_wt !== null ? (float)$row->fine_wt : 0.0;
	}

	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
}

