<?php

/**
 * This is the model class for table "cp_cash_logs".
 *
 * The followings are the available columns in table 'cp_cash_logs':
 * @property string $id
 * @property integer $cashevent_id
 * @property integer $customer_id
 * @property string $note
 * @property integer $type
 * @property double $amount
 * @property string $date
 */
class Cashlogs extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cp_cash_logs';
	}
	public  $event_type , $metal;
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			// array('amount,note', 'required'),
			array('cashevent_id, customer_id, type', 'numerical', 'integerOnly'=>true),
			array('amount', 'numerical'),
			array('note, date , amount, status, type, description , metal , item_id ,weight', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, cashevent_id, customer_id, note, type, amount, event_type , date, check_date,status', 'safe', 'on'=>'search'),
			array('id, cashevent_id, customer_id, note, type, amount, date,status, weight', 'safe', 'on'=>'search_event'),
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

				'getcust' => array(self::BELONGS_TO, 'Customer', 'customer_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'cashevent_id' => 'Cashevent',
			'customer_id' => 'Customer',
			'note' => 'Item Name',
			'type' => 'Cash Type',
			'amount' => 'Amount',
			'date' => 'Date',
			'description'=>'Note',
			'weight'=>"Metal",
			'event_type'=>'Payment Type',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('cashevent_id',$this->cashevent_id);
		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('date',$this->date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}



	public function search_sub_item()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$item_id = $_POST['item_id'];
		$criteria->compare('cashevent_id',$this->cashevent_id);
		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('item_id',$item_id,false);
		// $criteria->compare('id',$item_id,false,'OR');
		// pr($criteria);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}




	public function search_cash_today()
	{
		$action = strtolower(Yii::app()->controller->action->id);
		if($action == 'today_cash')
		{
			$type = 1;
		}
		if($action == 'today_gold')
		{
			$type = 2;
		}
		if($action == 'today_bank')
		{
			$type = 3;
		}
		if($action == 'today_card')
		{
			$type = 4;
		}
		if($action == 'today_discount')
		{
			$type = 5;
		}
		if($action == 'today_item')
		{
			$type = 6;
		}
		
		$date = date('Y-m-d');
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('cashevent_id',$this->cashevent_id);
		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('type',$type);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('date',$date);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

public function search_event()
{
	// @todo Please modify the following code to remove attributes that should not be searched.


	if(isset($_GET['id']))
	{
	   $id=$_GET['id'];
	   // echo $id;die;
	}
	$criteria=new CDbCriteria;
	$criteria->with = array('getcust');
	$criteria->compare('t.id',$this->id,true);
	$criteria->compare('cashevent_id',$this->cashevent_id);
	$criteria->compare('getcust.name',$this->customer_id,true);
	$criteria->compare('customer_id',$id);
	$criteria->compare('note',$this->note,true);
	$criteria->compare('t.type',$this->type);
	$criteria->compare('amount',$this->amount);
	$criteria->compare('weight',$this->weight);
	// $criteria->compare('date',$this->date,true);

	if(isset($this->date) && $this->date)
	{
	    $this->date=$this->date;
	    $date = date('Y-m-d',strtotime($this->date));
		$criteria->compare('date',$date,true);

	}

	return new CActiveDataProvider($this, array(
		'criteria'=>$criteria,
		/* 'sort' => array(
            'defaultOrder' => 't.id desc',
        ), */
	));
}


public function search_cash()
{
	// @todo Please modify the following code to remove attributes that should not be searched.
	if(isset($_GET['id']))
	{
	   $id=$_GET['id'];
	   // echo $id;die;
	}
	$criteria=new CDbCriteria;
	$criteria->with = array('getcust');
	$criteria->compare('t.id',$this->id,true);
	$criteria->compare('item_id','0');
	$criteria->compare('cashevent_id',$id);
	$criteria->compare('getcust.name',$this->customer_id,true);
	// $criteria->compare('customer_id',$id);
	$criteria->compare('note',$this->note,true);
	$criteria->compare('t.type',$this->type);
	$criteria->compare('amount',$this->amount);
	// $criteria->compare('weight',$this->weight);
	// $criteria->compare('date',$this->date,true);

	if(isset($this->date) && $this->date)
	{
	    $this->date=$this->date;
	    $date = date('Y-m-d',strtotime($this->date));
		$criteria->compare('date',$date,true);

	}

	return new CActiveDataProvider($this, array(
		'criteria'=>$criteria,
		/* 'sort' => array(
            'defaultOrder' => 't.id desc',
        ), */
	));
}

	public function metalTotal()
	{
		if(isset($_GET['id']))
		{
		   $id=$_GET['id'];
		}
		// $wages=Cashevent::model()->findAllByPk($id);
		$metals=Cashlogs::model()->findAllByAttributes(array('cashevent_id'=>$id));
		// print_r($wages);
		$total_metal=0;
		foreach($metals as $metal)
		{
			if($metal->amount == 0 && $metal->type == 2)
			{
				$total_metal+=$metal->weight;
			}
			if($metal->type != 2)
			{
				$total_metal+=$metal->weight;
			}
		}
		$new_metal = number_format((float)$total_metal, 3, '.', '');
		// return "Metal Total: &nbsp &nbsp".$new_metal_total;
		return "Metal Total: &nbsp &nbsp".$new_metal;
	}	

	public function cashTotal()
	{
		if(isset($_GET['id']))
		{
		   $id=$_GET['id'];
		}
		// $wages=Cashevent::model()->findAllByPk($id);
		$wages=Cashlogs::model()->findAllByAttributes(array('cashevent_id'=>$id));
		 // print_r($wages);
		$total_amount=0;
		foreach($wages as $wage)
		{
			// echo $wage->amount;
			// echo "<br>";	
			$total_amount+=$wage->amount;
			/*echo $days;
			echo "<br>";*/
		}
		if($total_amount == 0)
		{
			return "Outstanding: &nbsp &nbsp".$total_amount;
		}
		if($total_amount < 0)
		{
			return "Outstanding: &nbsp &nbsp".$total_amount;	
		}
		if($total_amount > 0)
		{
			return "Advance: &nbsp &nbsp".$total_amount;	
		}
	}	

	public function cash_all_Total()
	{
		if(isset($_GET['id']))
		{
		   $id=$_GET['id'];
		}
		// $wages=Cashevent::model()->findAllByPk($id);
		$wages=Cashlogs::model()->findAllByAttributes(array('customer_id'=>$id));
		// print_r($wages);
		$total=0;
		foreach($wages as $wage)
		{
			if($wage->amount)
			{
				$total+=$wage->amount;
			}
			// print_r($wage);
		}
		// return $total;
		if($total == 0)
		{
			return "Outstanding: &nbsp &nbsp".$total;
		}
		if($total < 0)
		{
			return "Outstanding: &nbsp &nbsp".$total;	
		}
		if($total > 0)
		{
			return "Advance: &nbsp &nbsp".$total;	
		}

	}	


	public function metal_all_Total()
	{
		if(isset($_GET['id']))
		{
		   $id=$_GET['id'];
		}
		// $wages=Cashevent::model()->findAllByPk($id);
		$metals=Cashlogs::model()->findAllByAttributes(array('customer_id'=>$id));
		 // print_r($metals);
		$total=0;
		foreach($metals as $metal)
		{
			$total+=$metal->weight;
		}

		$new_metal_total = number_format((float)$total, 3, '.', '');

		return "Metal Total: &nbsp &nbsp".$new_metal_total;
		/* if($total == 0)
		{
			return "Outstanding: &nbsp &nbsp".$total;
		}
		if($total < 0)
		{
			return "Outstanding: &nbsp &nbsp".$total;	
		}
		if($total > 0)
		{
			return "Advance: &nbsp &nbsp".$total;	
		} */

	}


	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Cashlogs the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function beforeSave()
	{
		if($this->status==1)
		{
			$this->amount = abs($this->amount);
			$this->weight = abs($this->weight);
		}
		else
		{
			if($this->amount == 0)
			{
				$this->amount = abs($this->amount);
			}
			else
			{
				$this->amount = abs($this->amount)*(-1);
			}
			if($this->type == 6 || $this->type == 8)
			{
				$this->weight = abs($this->weight);		
			}
			else
			{
				$this->weight = abs($this->weight)*(-1);
			}
		}		
		return true;
	}

}
