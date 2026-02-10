<?php

/**
 * This is the model class for table "customer_orders_orderbookitems".
 *
 * The followings are the available columns in table 'customer_orders_orderbookitems':
 * @property integer $id
 * @property integer $order_book_id
 * @property string $code
 * @property string $description
 * @property string $nw
 * @property string $rate
 * @property string $lc
 * @property string $oc
 */
class RepairingItems extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cp_repairing_items';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public $ref_no;
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('order_book_id', 'numerical', 'integerOnly'=>true),
			array('code', 'length', 'max'=>15),
			array('description', 'length', 'max'=>255),
			array('nw, rate, lc, oc,pcs', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id,ref_no,hide,item_code, order_book_id, code, description, nw, rate, lc, oc', 'safe', 'on'=>'search'),
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
			'id' => 'Ref No',
			'order_book_id' => 'Order Book',
			'code' => 'Code',
			'description' => 'Description',
			'nw' => 'Nw',
			'rate' => 'Rate',
			'lc' => 'Lc',
			'oc' => 'Oc',
			'hide'=>'Action'
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

		// $checks = Order::model()->findAll('code is not null and deleted=0');
		// $codes = CHtml::listData($checks,'code','code');
		// $criteria->addNotInCondition('item_code',array_values($codes));		

		$criteria->join = "JOIN customer_orders_orderbooks ob on ob.id=t.order_book_id";
		$criteria->compare('t.id',$this->id);
		$criteria->compare('order_book_id',$this->order_book_id);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('item_code',$this->item_code,true);
		$criteria->compare('ref_no',$this->ref_no,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('nw',$this->nw,true);
		$criteria->compare('rate',$this->rate,true);
		$criteria->compare('lc',$this->lc,true);
		$criteria->compare('oc',$this->oc,true);
		$criteria->compare('hide',0);
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
               'pageSize'=>100,
            ),
            'sort' => array(
                'defaultOrder' => 'item_code',
            )
		));
	}



	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Orderbookitems the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
