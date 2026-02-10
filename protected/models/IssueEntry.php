<?php

/**
 * This is the model class for table "cp_issue_entry".
 *
 * @property integer $id
 * @property string $sr_no
 * @property string $issue_date
 * @property integer $account_id
 * @property string $fine_wt
 * @property string $amount
 * @property string $remarks
 * @property integer $created_by
 * @property string $created_at
 * @property string $updated_at
 * @property integer $is_deleted
 */
class IssueEntry extends CActiveRecord
{
	public $start;
	public $end;

	public function tableName()
	{
		return 'cp_issue_entry';
	}

	public function rules()
	{
		return array(
			array('issue_date, account_id', 'required'),
			array('account_id, created_by, is_deleted', 'numerical', 'integerOnly' => true),
			array('fine_wt, amount', 'numerical'),
			array('sr_no', 'length', 'max' => 30),
			array('remarks, created_at, updated_at', 'safe'),
			array('id, sr_no, issue_date, account_id, is_deleted', 'safe', 'on' => 'search'),
		);
	}

	public function relations()
	{
		return array(
			'account' => array(self::BELONGS_TO, 'LedgerAccount', 'account_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'sr_no' => 'Sr No',
			'issue_date' => 'Date',
			'account_id' => 'Account',
			'fine_wt' => 'Fine Wt',
			'amount' => 'Amount',
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
		$criteria->with = array('account');

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.sr_no', $this->sr_no, true);
		$criteria->compare('t.account_id', $this->account_id);
		if (!empty($this->issue_date)) {
			$criteria->compare('t.issue_date', date('Y-m-d', strtotime($this->issue_date)), true);
		}
		if (!empty($_REQUEST['start'])) {
			$this->start = $_REQUEST['start'];
			$start = date('Y-m-d', strtotime($this->start));
			$criteria->addCondition("t.issue_date >= '{$start}'");
		}
		if (!empty($_REQUEST['end'])) {
			$this->end = $_REQUEST['end'];
			$end = date('Y-m-d', strtotime($this->end));
			$criteria->addCondition("t.issue_date <= '{$end}'");
		}
		$criteria->compare('t.is_deleted', 0);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort' => array('defaultOrder' => 't.issue_date desc, t.id desc'),
		));
	}

	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
}

