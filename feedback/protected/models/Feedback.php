<?php

/**
 * This is the model class for table "customer_feedbacks".
 *
 * The followings are the available columns in table 'customer_feedbacks':
 * @property integer $id
 * @property string $name
 * @property string $mobile_1
 * @property string $mobile_2
 * @property string $email
 * @property string $address
 * @property string $birthdate
 * @property string $anniversary_date
 * @property string $suggestion
 * @property string $date
 * @property string $category
 */
class Feedback extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cp_customer_feedbacks';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, email, address, category', 'length', 'max'=>255),
			array('email','email'),
			array('name,mobile_1,address', 'required'),
			array('mobile_1,mobile_2', 'numerical', 'integerOnly' => true),
			// array('birthdate', 'match', 'pattern'=>'/(0[1-9]|[12][0-9]|3[01])[ \.-](0[1-9]|1[012])[ \.-](19|20|)\d\d/'),
			// array('anniversary_date', 'match', 'pattern'=>'/(0[1-9]|[12][0-9]|3[01])[ \.-](0[1-9]|1[012])[ \.-](19|20|)\d\d/'),
			array('mobile_1, mobile_2', 'length', 'max'=>20),

			array('birthdate, anniversary_date, suggestion, date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, mobile_1, mobile_2, email, address, birthdate, anniversary_date, suggestion, date, category', 'safe', 'on'=>'search'),
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
			'mobile_1' => 'Mobile  No1(Whatsapp)',
			'mobile_2' => 'Mobile No2/Phone',
			'email' => 'Email',
			'address' => 'Address',
			'birthdate' => 'Birth Date',
			'anniversary_date' => 'Anniversary Date',
			'suggestion' => 'Suggestion',
			'date' => 'Date',
			'category' => 'Category',
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
		$criteria->compare('mobile_1',$this->mobile_1,true);
		$criteria->compare('mobile_2',$this->mobile_2,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('birthdate',$this->birthdate,true);
		$criteria->compare('anniversary_date',$this->anniversary_date,true);
		$criteria->compare('suggestion',$this->suggestion,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('category',$this->category,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Feedback the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function beforeSave()
	{
		if($this->birthdate == "")
		{
			$this->birthdate = null;
		}
		if($this->anniversary_date == "")
		{
			$this->anniversary_date = null;
		}
		
		return true;
	}

}
