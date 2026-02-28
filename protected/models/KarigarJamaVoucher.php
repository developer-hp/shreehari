<?php

class KarigarJamaVoucher extends CActiveRecord
{
	public $karigar_name;

	public function tableName()
	{
		return 'cp_karigar_jama_voucher';
	}

	public function rules()
	{
		return array(
			array('voucher_date, karigar_id', 'required'),
			array('karigar_id, issue_entry_id, created_by, is_deleted, is_locked, drcr', 'numerical', 'integerOnly' => true),
			array('total_fine_wt, total_amount', 'numerical'),
			array('sr_no, voucher_number', 'length', 'max' => 30),
			array('drcr', 'in', 'range' => array(IssueEntry::DRCR_DEBIT, IssueEntry::DRCR_CREDIT)),
			array('remark, created_at, karigar_name', 'safe'),
			array('id, voucher_date, karigar_id, issue_entry_id, drcr, remark, sr_no, voucher_number, total_fine_wt, total_amount, created_at, created_by, is_deleted, is_locked, karigar_name', 'safe', 'on' => 'search'),
		);
	}

	public function relations()
	{
		return array(
			'karigar' => array(self::BELONGS_TO, 'Customer', 'karigar_id'),
			'issueEntry' => array(self::BELONGS_TO, 'IssueEntry', 'issue_entry_id'),
			'lines' => array(self::HAS_MANY, 'KarigarJamaVoucherLine', 'voucher_id', 'order' => 'lines.sort_order ASC, lines.id ASC'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'voucher_date' => 'Date',
			'karigar_id' => 'Karigar',
			'karigar_name' => 'Karigar',
			'issue_entry_id' => 'Issue Entry',
			'drcr' => 'DR/CR',
			'remark' => 'Remark',
			'sr_no' => 'SR No',
			'voucher_number' => 'Voucher No',
			'total_fine_wt' => 'Total Fine Wt',
			'total_amount' => 'Total Amount',
			'created_at' => 'Created At',
			'created_by' => 'Created By',
			'is_deleted' => 'Deleted',
			'is_locked' => 'Locked',
		);
	}

	protected function beforeSave()
	{
		if (parent::beforeSave()) {
			$this->drcr = IssueEntry::DRCR_DEBIT;
			if ($this->isNewRecord) {
				$this->created_at = date('Y-m-d H:i:s');
				if (Yii::app()->user->id) $this->created_by = (int) Yii::app()->user->id;
				// Karigar Voucher is always Jama
			}
			if ($this->voucher_number === null || $this->voucher_number === '') {
				try {
					$this->voucher_number = DocumentNumberService::nextSrNo(DocumentNumberService::DOC_KARIGAR_JAMA_VOUCHER);
				} catch (Exception $e) {
					Yii::log('KarigarJamaVoucher voucher_number: ' . $e->getMessage(), 'error', 'application');
					$prefix = DocumentNumberService::getVoucherPrefix(DocumentNumberService::DOC_KARIGAR_JAMA_VOUCHER);
					$this->voucher_number = $prefix . ($this->id ?: date('YmdHis'));
				}
			}
			if (!empty($this->voucher_date)) {
				$ts = strtotime($this->voucher_date);
				if ($ts !== false) $this->voucher_date = date('Y-m-d', $ts);
			}
			return true;
		}
		return false;
	}

	public function delete()
	{
		if ($this->getIsNewRecord()) throw new CDbException('Cannot delete new record.');
		if ($this->issue_entry_id) {
			$entry = IssueEntry::model()->findByPk($this->issue_entry_id);
			if ($entry) $entry->delete();
		}
		$this->is_deleted = 1;
		return $this->save(false);
	}

	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->with = array('karigar');
		$criteria->compare('t.id', $this->id);
		if ($this->is_deleted === null || $this->is_deleted === '') $criteria->compare('t.is_deleted', 0);
		$criteria->compare('t.karigar_id', $this->karigar_id);
		$criteria->compare('t.voucher_date', $this->voucher_date, true);
		$criteria->compare('t.voucher_number', $this->voucher_number, true);
		$criteria->compare('t.total_fine_wt', $this->total_fine_wt);
		$criteria->compare('t.total_amount', $this->total_amount);
		$criteria->compare('t.is_locked', $this->is_locked);
		if (!empty($this->karigar_name))
			$criteria->compare('karigar.name', $this->karigar_name, true);
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort' => array('defaultOrder' => 't.voucher_date DESC, t.id DESC'),
		));
	}

	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
}
