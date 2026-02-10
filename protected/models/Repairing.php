<?php

/**
 * This is the model class for table "customer_orders_orderbooks".
 *
 * The followings are the available columns in table 'customer_orders_orderbooks':
 * @property integer $id
 * @property string $ref_no
 * @property string $name
 * @property string $mobile
 * @property string $date
 * @property string $type
 */
class Repairing extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cp_repairing_form';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mobile,delivery_date,customer_id','required'),
			array('ref_no', 'length', 'max'=>10),
			array('extra_charge','numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>100),
			array('date, type, c_rate', 'length', 'max'=>20),
			array('mobile, mobile2', 'length', 'max'=>12),
			array('customer_id,remarks,delivery_date', 'safe'),
			array('delivery_date','checkvaliddate'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id,order_status, ref_no,remarks, name, mobile, delivery_date,date, type', 'safe', 'on'=>'search'),
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
			'rel_customer' => array(self::BELONGS_TO, 'Customer', 'customer_id'),
		);
	}

	public function checkvaliddate()
	{
		if($this->delivery_date && strtotime($this->delivery_date)< strtotime($this->date))
		{
			$this->addError('delivery_date','Delivery date can not before order date!');
		}
	}
	public function getcolorclass()
	{
		return "";
			// $check = Advanceamount::model()->findByAttributes(array('order_form'=>$this->id));
			// if(!$check)
				// return "bg-purple";
			// if($this->order_status==1)
				// return 'bg-success';
			$ready_item = 0;
			$allitems = RepairingItems::model()->findAllByAttributes(array('order_book_id'=>$this->id));
			$arr = [];
			if($allitems)
			{
				foreach ($allitems as $key => $value) {
					$arr[] = $value->i_code;
				}
			}
			else 
				return 'bg-success';

			if($arr)
			{
				$criteria=new CDbCriteria;
				$criteria->addInCondition('code',$arr);		
				$ready_item += Item::model()->count($criteria);
			}

			if($ready_item==count($allitems))
				return $ready_item.' bg-success';	
			elseif($ready_item>0)
				return $ready_item.' bg-warning';
			else	
				return $ready_item.' bg-danger';		
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'ref_no' => 'Ref No',
			'user_id'=>'Sales Person',
			'customer_id'=>'Customer',
			'name' => 'Name',
			'mobile' => 'Contact No',
			'date' => 'Date',
			'type' => 'Type',
			'extra_charge'=>'Approx Extra Charge',
			'c_rate'=>'24KT Rate'

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

		// $checks = RepairingItems::model()->findAll('hide=0');
		// $codes = CHtml::listData($checks,'order_book_id','order_book_id');
		// $criteria->addInCondition('id',array_values($codes));

		//$criteria->join = "JOIN customer_orders_RepairingItems ob on t.id=ob.order_book_id";	

		$criteria->with = array('rel_customer');
		$criteria->compare('rel_customer.name',$this->customer_id,true);	
	

		// $criteria->compare('id',$this->id);
		$criteria->compare('ref_no',$this->ref_no,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('delivery_date',$this->delivery_date,true);
		$criteria->compare('remarks',$this->remarks,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
                        'pageSize'=>50,
            ),
            'sort' => array(
                'defaultOrder' => 't.id desc',
            )
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Orderbooks the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	/*public function afterSave(){

		$check = Customer::model()->findByAttributes(array('phone'=>$this->mobile));

		if($check)
		{
			$check->name = $this->name;
			$check->order_number = $this->ref_no;
			$check->save();
		}
		else{
			$check = new Customer;
			$check->name = $this->name;
			$check->phone = $this->mobile;
			$check->order_number = $this->ref_no;
			$check->save();
		}

		if($this->mobile2){
			$check = Customer::model()->findByAttributes(array('phone'=>$this->mobile2));

			if($check)
			{
				$check->name = $this->name;
				$check->order_number = $this->ref_no;
				$check->save();
			}
			else{
				$check = new Customer;
				$check->name = $this->name;
				$check->phone = $this->mobile2;
				$check->order_number = $this->ref_no;
				$check->save();
			}	
		}

	}*/
}
