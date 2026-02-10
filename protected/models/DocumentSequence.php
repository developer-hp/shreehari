<?php

/**
 * This is the model class for table "cp_document_sequence".
 *
 * @property string $doc_type
 * @property integer $next_no
 */
class DocumentSequence extends CActiveRecord
{
	public function tableName()
	{
		return 'cp_document_sequence';
	}

	public function primaryKey()
	{
		return 'doc_type';
	}

	public function rules()
	{
		return array(
			array('doc_type, next_no', 'required'),
			array('next_no', 'numerical', 'integerOnly' => true),
			array('doc_type', 'length', 'max' => 10),
			array('doc_type, next_no', 'safe', 'on' => 'search'),
		);
	}

	public function relations()
	{
		return array();
	}

	public function attributeLabels()
	{
		return array(
			'doc_type' => 'Doc Type',
			'next_no' => 'Next No',
		);
	}

	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('t.doc_type', $this->doc_type, true);
		$criteria->compare('t.next_no', $this->next_no);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
}

