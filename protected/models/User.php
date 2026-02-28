<?php

/**
 * This is the model class for table "cp_user".
 *
 * The followings are the available columns in table 'cp_user':
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property integer $user_type
 * @property string $created_at
 * @property integer $deleted
 */
class User extends CActiveRecord
{
	const TYPE_ADMIN = 1;
	const TYPE_HEAD = 2;
	const TYPE_STAFF = 3;

	public static function getUserTypeOptions()
	{
		return array(
			self::TYPE_ADMIN => 'Admin',
			self::TYPE_HEAD => 'Head',
			self::TYPE_STAFF => 'Staff',
		);
	}

	public static function getUserTypeLabel($type)
	{
		$options = self::getUserTypeOptions();
		$type = (int) $type;
		return isset($options[$type]) ? $options[$type] : 'Unknown';
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cp_user';
	}
	public $confirmPassword;
	
	/**
	 * @return array validation rules for model attributes.
	 */

	public $new_password , $confirm_password;

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name,email,user_type', 'required'),
			array('user_type, deleted', 'numerical', 'integerOnly'=>true),
			array('user_type', 'in', 'range' => array(self::TYPE_ADMIN, self::TYPE_HEAD, self::TYPE_STAFF)),
			array('name', 'length', 'max'=>100),
			array('email, password', 'length', 'max'=>255),
			array('created_at', 'safe'),
			// array('password,confirmPassword', 'required', 'on' => 'changepassword'),

            array('confirmPassword', 'compare', 'compareAttribute' => 'password', 'on' => 'changepassword'),

            array('name, email', 'required', 'on' => 'updateprofile'),

            array('email', 'required', 'on' => 'changepasswrd_email'),

            array('new_password, confirm_password', 'required', 'on' => 'changePwdSet'),
            // array('new_password', 'message'=>'New password can not be blank','on'=>'changePwdSet'),
			array('confirm_password', 'compare', 'compareAttribute'=>'new_password', 'on'=>'changePwdSet'),
           
            array('confirmPassword', 'compare', 'compareAttribute' => 'password', 'on' => 'updateprofile'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, email, password, user_type, created_at, deleted', 'safe', 'on'=>'search'),
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
			'email' => 'Email',
			'password' => 'Password',
			'user_type' => 'User Type',
			'created_at' => 'Created At',
			'deleted' => 'Deleted',
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
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('user_type',$this->user_type);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('deleted',0);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
                        'pageSize'=>30,
            ),
			'sort' => array(
                'defaultOrder' => 'id desc',
            )
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function beforeSave() {
        if ($this->isNewRecord) {
            $this->created_at	 = new CDbExpression('now()');
        }
        return true;
    }
}
