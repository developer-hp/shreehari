<?php

/**
 * This is the model class for table "cp_customer".
 *
 * The followings are the available columns in table 'cp_customer':
 * @property integer $id
 * @property string $name
 * @property string $mobile
 * @property string $address
 * @property integer $type
 * @property integer $is_deleted
 * @property string $closing_wt Net closing fine wt (DR−CR), updated from Opening + Issue
 * @property string $closing_amount Net closing amount (DR−CR), updated from Opening + Issue
 */
class Customer extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cp_customer';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name,mobile,type', 'required'),
			array('type, mobile, is_deleted', 'numerical', 'integerOnly'=>true),
			array('name, address', 'length', 'max'=>255),
			array('mobile', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, mobile, address, type, is_deleted', 'safe', 'on'=>'search'),
			array('closing_wt, closing_amount', 'numerical'),
			array('closing_wt, closing_amount', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'mobile' => 'Mobile',
			'address' => 'Address',
			'type' => 'Type',
			'is_deleted' => 'Id Deleted',
			'closing_wt' => 'Closing Wt',
			'closing_amount' => 'Closing Amount',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('type',1);
		$criteria->compare('is_deleted',0);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,

			'sort' => array(
				  'defaultOrder' => 't.name asc',
                // 'defaultOrder' => 't.id desc',
            ),
		));
	}


	public function search_customer()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('type',2);
		$criteria->compare('is_deleted',0);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,

			'sort' => array(
              	  'defaultOrder' => 't.name asc',
                // 'defaultOrder' => 't.id desc',
            ),
		));
	}

	public function search_karigar()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('type',3);
		$criteria->compare('is_deleted',0);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,

			'sort' => array(
                 'defaultOrder' => 't.name asc',
                // 'defaultOrder' => 't.id desc',
            ),
		));
	}



	public function amount_Total_For_User_Type()
	{

		$customer_type = 2;
		$action1 = strtolower(Yii::app()->controller->action->id);
		if($action1 == "list_supplier")
		{
			$customer_type = 1;
		}
		if($action1 == "list_customer")
		{
			$customer_type = 2;
		}
		if($action1 == "list_karigar")
		{
			$customer_type = 3;
		}

        $criteria=new CDbCriteria;
		$condition = "1=1";
		$criteria->join = 'JOIN cp_cash_event ON t.cashevent_id=cp_cash_event.id JOIN cp_customer ON t.customer_id=cp_customer.id';
        $criteria->select =' sum(t.amount) as amount ';
        $condition .= ' AND cp_customer.is_deleted = 0 AND cp_cash_event.is_deleted=0 AND cp_customer.type='.$customer_type;
        $condition .= ' AND t.amount >0';
        $criteria->condition = $condition;
         // print_r($criteria);
        $cash_amount=Cashlogs::model()->find($criteria);
        $str =  "Credit:&nbsp;&nbsp;&nbsp; ".$cash_amount->amount;

        $a1 = 0;
        if($cash_amount && $cash_amount->amount)
        	$a1 = $cash_amount->amount;


        $criteria=new CDbCriteria;
		$condition = "1=1";
		$criteria->join = 'JOIN cp_cash_event ON t.cashevent_id=cp_cash_event.id JOIN cp_customer ON t.customer_id=cp_customer.id';
        $criteria->select =' sum(t.amount) as amount ';
        $condition .= ' AND cp_customer.is_deleted = 0 AND cp_cash_event.is_deleted=0 AND cp_customer.type='.$customer_type;
        $condition .= ' AND t.amount<0';
        $criteria->condition = $condition;
         // print_r($criteria);
        $cash_amount=Cashlogs::model()->find($criteria);
        $str .=  "<br>Debit:&nbsp;&nbsp;&nbsp; ".$cash_amount->amount;

        $a2 = 0;
        if($cash_amount && $cash_amount->amount)
        	$a2 = $cash_amount->amount;


        $str .=  "<br>Final:&nbsp;&nbsp;&nbsp; ".($a1+$a2);

        return $str;
	}	

	public function metal_Total_For_User_Type()
	{
		$customer_type = 2;
		$action1 = strtolower(Yii::app()->controller->action->id);
		if($action1 == "list_supplier")
		{
			$customer_type = 1;
		}
		if($action1 == "list_customer")
		{
			$customer_type = 2;
		}
		if($action1 == "list_karigar")
		{
			$customer_type = 3;
		}
        $criteria=new CDbCriteria;
		$condition = "1=1";
		$criteria->join = 'JOIN cp_cash_event ON t.cashevent_id=cp_cash_event.id JOIN cp_customer ON t.customer_id=cp_customer.id';
        // $criteria->select =' SUM(IF(t.amount = "0" OR t.amount is null OR t.amount = "" OR t.type = "6" OR t.type = "7" OR t.type = "8" ,(t.weight),0)) AS weight  ';
        $criteria->select ='SUM(IF((t.amount = "0" OR t.amount is null OR t.amount = "") and   t.item_id = "0" ,(t.weight),0)) AS weight ';
        $condition .= ' AND weight>0 and cp_customer.is_deleted = 0 AND cp_cash_event.is_deleted=0 AND cp_customer.type='.$customer_type;
        // $condition .= ' AND customer_id ='.$data->id;
        $criteria->condition = $condition;
         // print_r($criteria);
        $cash_weight=Cashlogs::model()->find($criteria);
        $str =  "Credit Metal:&nbsp;&nbsp;&nbsp; ".number_format((float) $cash_weight->weight, 3, '.', '');

        $a1 = 0;
        if($cash_weight && $cash_weight->weight)
        	$a1 = $cash_weight->weight;


        $criteria=new CDbCriteria;
		$condition = "1=1";
		$criteria->join = 'JOIN cp_cash_event ON t.cashevent_id=cp_cash_event.id JOIN cp_customer ON t.customer_id=cp_customer.id';
        // $criteria->select =' SUM(IF(t.amount = "0" OR t.amount is null OR t.amount = "" OR t.type = "6" OR t.type = "7" OR t.type = "8" ,(t.weight),0)) AS weight  ';
        $criteria->select ='SUM(IF((t.amount = "0" OR t.amount is null OR t.amount = "") and   t.item_id = "0" ,(t.weight),0)) AS weight ';
        $condition .= ' AND weight<0 and cp_customer.is_deleted = 0 AND cp_cash_event.is_deleted=0 AND cp_customer.type='.$customer_type;
        // $condition .= ' AND customer_id ='.$data->id;
        $criteria->condition = $condition;
         // print_r($criteria);
        $cash_weight=Cashlogs::model()->find($criteria);
        $str .=  "<br>Debit Metal:&nbsp;&nbsp;&nbsp; ".number_format((float) $cash_weight->weight, 3, '.', '');

        $a2 = 0;
        if($cash_weight && $cash_weight->weight)
        	$a2 = $cash_weight->weight;

        $str .=  "<br>Final Metal:&nbsp;&nbsp;&nbsp; ".number_format((float) $a1+$a2, 3, '.', '');

        return $str;
        
	}

	/**
	 * Closing balance from Opening Balance + Issue Entry (net: DR - CR).
	 * @param int $customerId
	 * @return array ['wt' => float, 'amount' => float] net closing (positive = DR, negative = CR)
	 */
	public static function getClosingBalance($customerId)
	{
		$totalFineDr = $totalFineCr = $totalAmtDr = $totalAmtCr = 0.0;
		$opening = AccountOpeningBalance::model()->findByAttributes(
			array('customer_id' => (int)$customerId, 'is_deleted' => 0)
		);
		if ($opening) {
			$fw = (float)$opening->opening_fine_wt;
			$am = (float)$opening->opening_amount;
			if ($opening->opening_fine_wt_drcr == 1) $totalFineDr += $fw; else $totalFineCr += $fw;
			if ($opening->opening_amount_drcr == 1) $totalAmtDr += $am; else $totalAmtCr += $am;
		}
		$issues = IssueEntry::model()->findAllByAttributes(
			array('customer_id' => (int)$customerId, 'is_deleted' => 0)
		);
		foreach ($issues as $iss) {
			$fw = (float)$iss->fine_wt;
			$am = (float)$iss->amount;
			if ($iss->drcr == 1) {
				$totalFineDr += $fw;
				$totalAmtDr += $am;
			} else {
				$totalFineCr += $fw;
				$totalAmtCr += $am;
			}
		}
		return array(
			'wt' => $totalFineDr - $totalFineCr,
			'amount' => $totalAmtDr - $totalAmtCr,
		);
	}

	/**
	 * Recalculate closing from Opening Balance + Issue Entry and update customer row.
	 * Call this when opening balance or issue entry is saved/deleted.
	 * @param int $customerId
	 */
	public static function updateClosingBalance($customerId)
	{
		$customerId = (int) $customerId;
		if ($customerId <= 0) return;
		$bal = self::getClosingBalance($customerId);
		Yii::app()->db->createCommand()->update(
			'cp_customer',
			array(
				'closing_wt' => $bal['wt'],
				'closing_amount' => $bal['amount'],
			),
			'id = :id',
			array(':id' => $customerId)
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Customer the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
