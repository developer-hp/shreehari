<?php

/**
 * This is the model class for table "cp_cash_event".
 *
 * The followings are the available columns in table 'cp_cash_event':
 * @property integer $id
 * @property string $user_id
 * @property string $customer_id
 * @property integer $cash_type
 * @property string $amount
 * @property string $gold_type
 * @property string $gold_amount
 * @property string $created_date
 * @property integer $is_deleted
 */
class Cashevent extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cp_cash_event';
	}
	public $days , $transaction , $metal;
	public $start,$end;
    
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('customer_id , created_date, referral_code', 'required'),

			array('created_date', 'match', 'pattern'=>'/(0[1-9]|[12][0-9]|3[01])[ \.-](0[1-9]|1[012])[ \.-](19|20|)\d\d/'),
			array('cash_type','chack_validation', 'on' => 'createrecord'),
			// array('bank_type','chack_validation_bank'),
			array('cash_type, is_deleted', 'numerical', 'integerOnly'=>true),
			array('amount, gold_amount,bank_amount,card_amount,discount_amount', 'numerical'),
			array('user_id, customer_id, amount, gold_amount', 'length', 'max'=>255),
			array('gold_type', 'length', 'max'=>50),
			array('created_date , card_type , narration , referral_code ,discount_type, bank_type ,bank_amount , card_amount,transaction, metal , check_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, customer_id, cash_type, amount, gold_type, gold_amount, created_date, is_deleted , referral_code , bank_type , bank_amount , card_type , card_amount ,narration' , 'safe', 'on'=>'search'),
		);
	}

	/* public function chack_validation()
	{
		if(isset($_POST['Cashevent']['cash_type']) && $_POST['Cashevent']['cash_type'] != "" )
		{
			if(isset($_POST['Cashevent']['amount']) && $_POST['Cashevent']['amount'] == "" )
			{
     			$this->addError('amount','Cash amount cannot be blank');
     		}
		}
	} */


	public function chack_validation()
	{
		if(isset($_POST['Cashevent']['cash_type']) && $_POST['Cashevent']['cash_type'] != "" )
		{
			if(isset($_POST['Cashevent']['amount']) && $_POST['Cashevent']['amount'] == "" )
			{
     			$this->addError('amount','Cash amount cannot be blank');
     		}
		}
		if(isset($_POST['Cashevent']['gold_type']) && $_POST['Cashevent']['gold_type'] != "")
		{	
			if(isset($_POST['Cashevent']['gold_amount']) && $_POST['Cashevent']['gold_amount'] == "")
			{
				$this->addError('gold_amount', 'Gold amount cannot be blank');
			}
		}

		if(isset($_POST['Cashevent']['bank_type']) && $_POST['Cashevent']['bank_type'] != "" )
		{
			if(isset($_POST['Cashevent']['bank_amount']) && $_POST['Cashevent']['bank_amount'] == "" )
			{
     			$this->addError('bank_amount','Banck amount cannot be blank');
     		}
		}

		if(isset($_POST['Cashevent']['card_type']) && $_POST['Cashevent']['card_type'] != "")
		{	
			if(isset($_POST['Cashevent']['card_amount']) && $_POST['Cashevent']['card_amount'] == "")
			{
				$this->addError('card_amount', 'Card amount cannot be blank');
			}
		}


		if(isset($_POST['Cashevent']['discount_type']) && $_POST['Cashevent']['discount_type'] != "")
		{	
			if(isset($_POST['Cashevent']['discount_amount']) && $_POST['Cashevent']['discount_amount'] == "")
			{
				$this->addError('discount_amount', 'Discount amount cannot be blank');
			}
		}

		/* if(($_POST['Cashevent']['cash_type'] == "") && ($_POST['Cashevent']['gold_type'] == "") && ($_POST['Cashevent']['bank_type'] == "") && ($_POST['Cashevent']['card_type'] == "") && ($_POST['Cashevent']['discount_type'] == ""))
		{
			$this->addError('discount_type', 'Please select an event');
		} */


	}

	/*public function chack_validation_bank()
	{
		if(isset($_POST['Cashevent']['bank_type']) && $_POST['Cashevent']['bank_type'] != "" )
		{
			if(isset($_POST['Cashevent']['bank_amount']) && $_POST['Cashevent']['bank_amount'] == "" )
			{
     			$this->addError('bank_amount','Banck amount cannot be blank');
     		}
		}
		if(isset($_POST['Cashevent']['card_type']) && $_POST['Cashevent']['card_type'] != "")
		{	
			if(isset($_POST['Cashevent']['card_amount']) && $_POST['Cashevent']['card_amount'] == "")
			{
				$this->addError('card_amount', 'card amount cannot be blank');
			}
		}
		if(($_POST['Cashevent']['bank_type'] == "") && ($_POST['Cashevent']['card_type'] == ""))
		{
			$this->addError('card_amount', 'Please select an event');
		}

	}*/




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
			'user_id' => 'User',
			'customer_id' => 'Customer',
			'cash_type' => 'Cash ',
			'amount' => 'Cash Amount',
			'gold_type' => 'Gold ',
			'gold_amount' => 'Gold Amount',
			'bank_type'=>'Bank ',
			'bank_amount'=>'Bank Amount',
			'card_type'=>'Card ',
			'card_amount'=>'Card Amount',
			'discount_type'=>'Discount',
			'discount_amount'=>'Discount Amount',
			'created_date' => 'Created Date',
			'narration' => "Related Person",
			'referral_code'=>'Bill No',
			'is_deleted' => 'Is Deleted',
			'transaction'=>'Transaction'
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

		$criteria->with = array('getcust');

		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.user_id',$this->user_id,true);

		$criteria->compare('getcust.name',$this->customer_id,true);
		// $criteria->compare('customer_id',$this->customer_id,true);
		$criteria->compare('cash_type',$this->cash_type);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('gold_type',$this->gold_type,true);
		$criteria->compare('gold_amount',$this->gold_amount,true);

		$criteria->compare('bank_type',$this->bank_type,true);
		$criteria->compare('bank_amount',$this->bank_amount,true);
		$criteria->compare('card_type',$this->card_type,true);
		$criteria->compare('card_amount',$this->card_amount,true);
		$criteria->compare('narration',$this->narration,true);

		$criteria->compare('referral_code',$this->referral_code,true);
		if(isset($this->created_date) && $this->created_date)
		{
		    $this->created_date=$this->created_date;
		    $date = date('Y-m-d',strtotime($this->created_date));
			$criteria->compare('t.created_date',$date,true);
		}
		if(isset($_REQUEST['start']) && $_REQUEST['start'])
        {
            $this->start = $_REQUEST['start'];
            $this->start = date('Y-m-d',strtotime(str_replace('-', '-', $this->start)));            
            $criteria->compare('t.created_date','>='.$this->start.' 00:00:00' );
        }
        if(isset($_REQUEST['end']) && $_REQUEST['end'])
        {
            $this->end = $_REQUEST['end'];
            $this->end = date('Y-m-d',strtotime(str_replace('-', '-', $this->end)));            
            $criteria->compare('t.created_date','<='.$this->end.' 23:59:59' );
        }
		
		$criteria->compare('t.is_deleted',0);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			 'sort' => array(
                'defaultOrder' => 'getcust.name asc',
            ), 
		));
	}



	public function amount_total($pdf=0)
	{

		if(isset($_GET['id']) && $_GET['id'] !="")
		{
			$id = $_GET['id'];
		}
		// die();
		$condition = "1=1";
	    $criteria=new CDbCriteria;
	    $criteria->select =' sum(amount) as amount ';
	    $condition .= ' AND amount > 0 ' ;
	    if(isset($id) && $id != "")
	    {
	    	$condition .= ' AND customer_id ='.$id;
	    }
	    $criteria->condition = $condition;
	     // print_r($criteria);
	    $cash_amount1 = Cashlogs::model()->find($criteria);
	    $a1 = 0;
	    if($cash_amount1)
	    	$a1 = $cash_amount1->amount;


	    $condition = "1=1";
	    $criteria=new CDbCriteria;
	    $criteria->select =' sum(amount) as amount ';
	    $condition .= ' AND amount < 0 ' ;
	    if(isset($id) && $id != "")
	    {
	    	$condition .= ' AND customer_id ='.$id;
	    }
	    $criteria->condition = $condition;
	     // print_r($criteria);
	    $cash_amount2 = Cashlogs::model()->find($criteria);

	    $a2 = 0;
	    if($cash_amount2)
	    	$a2 = $cash_amount2->amount;

	    if($pdf==1)
	    	return "Credit : $a1 <br>Debit : $a2 <br>Final Total : ".($a1+$a2);

	     return "Credit : $a1 <br>Debit : $a2 <br> Final Total: &nbsp &nbsp".($a1+$a2);
    	// $new_total = number_format((float)$cash_amount->amount, 2, '.', '');
	    // return "Amount Total: &nbsp &nbsp".$new_total;
	}



	public function amountArray()
	{

		$id = $this->customer_id;
		// die();
		$condition = "1=1";
	    $criteria=new CDbCriteria;
	    $criteria->select =' sum(amount) as amount ';
	    $condition .= ' AND amount > 0 ' ;
	    if(isset($id) && $id != "")
	    {
	    	$condition .= ' AND customer_id ='.$id;
	    }
	    $criteria->condition = $condition;
	     // print_r($criteria);
	    $cash_amount1 = Cashlogs::model()->find($criteria);
	    $a1 = 0;
	    if($cash_amount1)
	    	$a1 = $cash_amount1->amount;


	    $condition = "1=1";
	    $criteria=new CDbCriteria;
	    $criteria->select =' sum(amount) as amount ';
	    $condition .= ' AND amount < 0 ' ;
	    if(isset($id) && $id != "")
	    {
	    	$condition .= ' AND customer_id ='.$id;
	    }
	    $criteria->condition = $condition;
	     // print_r($criteria);
	    $cash_amount2 = Cashlogs::model()->find($criteria);

	    $a2 = 0;
	    if($cash_amount2)
	    	$a2 = $cash_amount2->amount;

	    $arr['final_total'] = $a1+$a2;
	    $arr['paid'] = $a1;
	    $arr['outstanding'] = $a2;

	    return $arr;


	    if($pdf==1)
	    	return "Paid : $a1 <br>Outstand : $a2 <br>Final Total : ".($a1+$a2);

	     return 

	     "Paid : $a1 <br>Outstand : $a2 <br> Final Total: &nbsp &nbsp".($a1+$a2);
    	// $new_total = number_format((float)$cash_amount->amount, 2, '.', '');
	    // return "Amount Total: &nbsp &nbsp".$new_total;
	}

	public function metal_total($pdf=0)
	{
		if(isset($_GET['id']) && $_GET['id'] !="")
		{
			$id = $_GET['id'];
		}
		$condition = "1=1";
	    $criteria=new CDbCriteria; 
	    $criteria->select ='SUM(IF((t.amount = "0" OR t.amount is null OR t.amount = "") and   t.item_id = "0" ,(t.weight),0)) AS weight ';
	    $condition .= ' AND weight >= 0 ' ;
	    if(isset($id) && $id != "")
	    {
	    	$condition .= ' AND customer_id ='.$id;
	    }
	    $criteria->condition = $condition;
	    $cash_amount = Cashlogs::model()->find($criteria);
    	// $a1 = number_format((float)$cash_amount->weight, 3, '.', '');
    	$a1 = 0;
    	if($cash_amount && $cash_amount->weight)
    	$a1 = $cash_amount->weight;

    	$condition = "1=1";
	    $criteria=new CDbCriteria; 
	    $criteria->select ='SUM(IF((t.amount = "0" OR t.amount is null OR t.amount = "") and   t.item_id = "0" ,(t.weight),0)) AS weight ';
	    $condition .= ' AND weight < 0 ' ;
	    if(isset($id) && $id != "")
	    {
	    	$condition .= ' AND customer_id ='.$id;
	    }
	    $criteria->condition = $condition;
	    $cash_amount = Cashlogs::model()->find($criteria);
    	// $a1 = number_format((float)$cash_amount->weight, 3, '.', '');
    	$a2 = 0;
    	if($cash_amount && $cash_amount->weight)
    	$a2 = $cash_amount->weight;

    	$final = $a1 + $a2;

    	if($pdf==1)
	    	return number_format($final, 3, '.', '');


	    return "Credit : ".number_format($a1, 3, '.', '')." <br>Debit : ".number_format($a2, 3, '.', '')." <br> Final Total: &nbsp &nbsp".number_format($final, 3, '.', '');



    	return "Metal Total: &nbsp &nbsp".number_format($final, 3, '.', '');
    	
	    /*if($cash_amount)
	    {
	    	$condition = "1=1";
		    $criteria=new CDbCriteria;
		    $criteria->select =' sum(weight) as weight ';
		    $condition .= ' AND amount != 0 ' ;
		    $condition .= ' AND type = 2 ' ;
		    if(isset($id) && $id != "")
		    {
		    	$condition .= ' AND customer_id ='.$id;
		    }
		    $criteria->condition = $condition;
		    $cash_amount_type = Cashlogs::model()->find($criteria);
		    $main_total =$cash_amount->weight - $cash_amount_type->weight ;
	  		$new_total = number_format((float)$main_total, 3, '.', '');
	    	return "Metal Total: &nbsp &nbsp".$new_total;
	    }*/


	}

	public function search_event()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
		if(isset($_GET['id']))
		{
		   $id=$_GET['id'];
		}
		$criteria=new CDbCriteria;
		$criteria->with = array('getcust');
		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.user_id',$this->user_id);
		// $criteria->compare('getcust.name',$this->customer_id,true);
		$criteria->compare('customer_id',$id);
		$criteria->compare('cash_type',$this->cash_type);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('gold_type',$this->gold_type,true);
		$criteria->compare('gold_amount',$this->gold_amount,true);

		$criteria->compare('bank_type',$this->bank_type,true);
		$criteria->compare('bank_amount',$this->bank_amount,true);
		$criteria->compare('card_type',$this->card_type,true);
		$criteria->compare('card_amount',$this->card_amount,true);

		$criteria->compare('referral_code',$this->referral_code,true);
		// $criteria->compare('t.created_date',$this->created_date,true);
		if(isset($this->created_date) && $this->created_date)
		{
		    $this->created_date=$this->created_date;
		    $date=date('Y-m-d',strtotime($this->created_date));
			$criteria->compare('t.created_date',$date,true);
		}
		$criteria->compare('t.is_deleted',0);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			/* 'sort' => array(
                'defaultOrder' => 't.id desc',
            ), */
		));
	}

	public function search_bill()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
		if(isset($_GET['id']))
		{
		   $id=$_GET['id'];
		}
		// echo $id;die;
		$criteria=new CDbCriteria;
		$criteria->with = array('getcust');
		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.user_id',$this->user_id,true);
		// $criteria->compare('getcust.name',$this->customer_id,true);
		$criteria->compare('customer_id',$id);
		$criteria->compare('cash_type',$this->cash_type);
		$criteria->compare('t.amount',$this->amount,true);
		$criteria->compare('gold_type',$this->gold_type,true);
		$criteria->compare('gold_amount',$this->gold_amount,true);

		$criteria->compare('bank_type',$this->bank_type,true);
		$criteria->compare('bank_amount',$this->bank_amount,true);
		$criteria->compare('card_type',$this->card_type,true);
		$criteria->compare('card_amount',$this->card_amount,true);

		$criteria->compare('referral_code',$this->referral_code,true);
		// $criteria->compare('t.created_date',$this->created_date,true);
		if(isset($this->created_date) && $this->created_date)
		{
		    $this->created_date=$this->created_date;
		    $date=date('Y-m-d',strtotime($this->created_date));
			$criteria->compare('t.created_date',$date,true);
		}
		$criteria->compare('t.is_deleted',0);
		$criteria->order = 'created_date asc,referral_code asc';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			/* 'sort' => array(
                'defaultOrder' => 't.id desc',
            ), */
		));
	}

	public function cashTotal($data)
	{
		// pr($data);die;		
		if(isset($_GET['id']))
		{
		   $id=$_GET['id'];
		   // die();
		}
		// $wages=Cashevent::model()->findAllByPk($id);
		$wages=Cashlogs::model()->findAllByAttributes(array('customer_id'=>$id));
		// print_r($wages);
		$total_amount=0;
		foreach($wages as $wage)
		{
			$total_amount+=$wage->amount;
			/*echo $days;
			echo "<br>";*/
		}

		if($total_amount == 0)
		{
			return "Amount: &nbsp &nbsp".$total_amount = "";
		}
		if($total_amount < 0)
		{
			return "Outstanding: &nbsp &nbsp".$total_amount;	
		}
		if($total_amount > 0)
		{
			return "Advance: &nbsp &nbsp".$total_amount;	
		}
		// return $days;
	}	

	public function goldTotal()
	{
		if(isset($_GET['id']))
		{
		   $id=$_GET['id'];
		}
		$wages=Cashevent::model()->findAllByAttributes(array('customer_id'=>$id,'is_deleted'=>0));
		$days=0;
		foreach($wages as $wage)
		{
			if($wage->gold_amount)
			$days+=$wage->gold_amount;
		}
			return number_format((float)$days, 3, '.', '');
		// return $days;
	}


	public function bankTotal()
	{
		if(isset($_GET['id']))
		{
		   $id=$_GET['id'];
		}
		$wages=Cashevent::model()->findAllByAttributes(array('customer_id'=>$id,'is_deleted'=>0));
		$days=0;
		foreach($wages as $wage)
		{
			$days+=$wage->bank_amount;
		}
			return number_format((float)$days, 3, '.', '');
		// return $days;
	}	

	public function cardTotal()
	{
		if(isset($_GET['id']))
		{
		   $id=$_GET['id'];
		}
		$wages=Cashevent::model()->findAllByAttributes(array('customer_id'=>$id,'is_deleted'=>0));
		$days=0;
		foreach($wages as $wage)
		{
			$days+=$wage->card_amount;
		}
			return number_format((float)$days, 3, '.', '');
		// return $days;
	}	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Cashevent the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
