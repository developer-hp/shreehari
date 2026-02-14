<?php

/**
 * Master: subitem/charge types for supplier ledger item charges.
 */
class SubitemType extends CActiveRecord
{
	public function tableName()
	{
		return 'cp_subitem_types';
	}

	public function rules()
	{
		return array(
			array('name', 'required'),
			array('name', 'length', 'max' => 100),
			array('sort_order, is_deleted', 'numerical', 'integerOnly' => true),
			array('created_at', 'safe'),
			array('id, name, sort_order, is_deleted, created_at', 'safe', 'on' => 'search'),
		);
	}

	public function relations()
	{
		return array();
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'sort_order' => 'Sort Order',
			'is_deleted' => 'Deleted',
			'created_at' => 'Created At',
		);
	}

	protected function beforeSave()
	{
		if (parent::beforeSave()) {
			if ($this->isNewRecord && empty($this->created_at))
				$this->created_at = date('Y-m-d H:i:s');
			return true;
		}
		return false;
	}

	public function delete()
	{
		if ($this->getIsNewRecord()) throw new CDbException('Cannot delete new record.');
		$this->is_deleted = 1;
		return $this->save(false);
	}

	/**
	 * List for dropdown: id => name (non-deleted, by sort_order).
	 */
	public static function getList()
	{
		$rows = self::model()->findAll(array(
			'condition' => 'is_deleted = 0',
			'order' => 'sort_order ASC, id ASC',
		));
		return CHtml::listData($rows, 'id', 'name');
	}

	public function search()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.name', $this->name, true);
		$criteria->compare('t.sort_order', $this->sort_order);
		if ($this->is_deleted === null || $this->is_deleted === '')
			$criteria->compare('t.is_deleted', 0);
		else
			$criteria->compare('t.is_deleted', $this->is_deleted);
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort' => array('defaultOrder' => 't.sort_order ASC, t.id ASC'),
		));
	}

	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}
}
