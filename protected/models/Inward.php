<?php

/**
 * This is the model class for table "cp_inwards".
 *
 * The followings are the available columns in table 'cp_inwards':
 * @property integer $id
 * @property integer $customer_id
 * @property string $bill_no
 * @property string $bill_date
 * @property double $gross_wt
 * @property double $net_wt
 * @property double $fine_wt
 * @property double $other_wt
 * @property double $gold_amount
 * @property double $other_amount
 * @property string $note
 * @property string $created_date
 * @property string $updated_date
 */
class Inward extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cp_inwards';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('customer_id', 'required'),
			array('customer_id', 'numerical', 'integerOnly'=>true),
			array('gross_wt, net_wt, fine_wt, other_wt, gold_amount, other_amount', 'numerical'),
			array('bill_no', 'length', 'max'=>100),
			array('bill_date, note, created_date, updated_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, customer_id, bill_no, bill_date, gross_wt, net_wt, fine_wt, other_wt, gold_amount, other_amount, note, created_date, updated_date', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'customer_id' => 'Customer',
			'bill_no' => 'Bill No',
			'bill_date' => 'Bill Date',
			'gross_wt' => 'Gross Wt',
			'net_wt' => 'Net Wt',
			'fine_wt' => 'Fine Wt',
			'other_wt' => 'Other Wt',
			'gold_amount' => 'Gold Amount',
			'other_amount' => 'Other Amount',
			'note' => 'Note',
			'created_date' => 'Created Date',
			'updated_date' => 'Updated Date',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('bill_no',$this->bill_no,true);
		$criteria->compare('bill_date',$this->bill_date,true);
		$criteria->compare('gross_wt',$this->gross_wt);
		$criteria->compare('net_wt',$this->net_wt);
		$criteria->compare('fine_wt',$this->fine_wt);
		$criteria->compare('other_wt',$this->other_wt);
		$criteria->compare('gold_amount',$this->gold_amount);
		$criteria->compare('other_amount',$this->other_amount);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('updated_date',$this->updated_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Inward the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
