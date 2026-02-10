<?php

class UserController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/main';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','send'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','change'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionSend()
	{
		$user =  User::model()->findAll('(password is null OR password="") and deleted=0');

		// print_r($user); die;

		$appsetting = $this->getsettings();
		foreach ($user as $key => $model) {

			$password = $this->randomPassword();
			$model->password = md5($password);
			$model->save(false);
		
			$mailinfo = $appsetting['REGISTER_MAIL_CONTENT'];
			$link = Yii::app()->createAbsoluteUrl('site/login');
			$mailinfo = str_replace(array('{{name}}','{{$link}}','{{$username}}','{{$password}}'), array($model->name,$link,$model->email,$password), $mailinfo);
			$mailinfo = str_replace(array('{{name}}','{{$link}}','{{$username}}','{{$password}}'), array("","","",""), $mailinfo);
			$subject = $appsetting['REGISTER_MAIL_SUBJECT'];
			$mail = new YiiMailer('message', array('message' => $mailinfo));
	        $mail->setFrom(Yii::app()->params['adminEmail'], $appsetting['APP_NAME']);
	        $mail->setTo($model->email);
	        $mail->setBody($mailinfo);
	        $mail->setSubject($subject);
	        if($mail->send())
	        {

	        }
	    }
	    Yii::app()->user->setFlash('success', 'Sent successfully');
		$this->redirect(array('index'));
	}
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new User;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{

			$model->attributes=$_POST['User'];
			$user = User::model()->findByAttributes(array('email'=>$model->email,'deleted'=>0));

			if($user)
			{
				$model->addError('email','Email is already taken!');
				$this->render('create',array(
					'model'=>$model,
				));
				Yii::app()->end;

			}
			$password = $this->randomPassword();
			$model->password = md5($password);

			if($model->save()){

				$appsetting = $this->getsettings();

				$mailinfo = $appsetting['REGISTER_MAIL_CONTENT'];

				$link = Yii::app()->createAbsoluteUrl('site/login');

				$mailinfo = str_replace(array('{{name}}','{{link}}','{{username}}','{{password}}'), array($model->name,$link,$model->email,$password), $mailinfo);

				$mailinfo = str_replace(array('{{name}}','{{link}}','{{username}}','{{password}}'), array("","","",""), $mailinfo);

				// $mailinfo = "Hello ".$model->name.',';
				// $mailinfo .= "<br><br> Your account is created successfully!";

				// $mailinfo .= "<br><br>".;
				// $mailinfo .= "<br><br>You can login using following credentials";

				// $mailinfo .= "<br><br> Username: ".$model->email;
				// $mailinfo .= "<br><br> Password: ".$password;

				$subject = $appsetting['REGISTER_MAIL_SUBJECT'];


				$mail = new YiiMailer('message', array('message' => $mailinfo));
	            $mail->setFrom(Yii::app()->params['adminEmail'], $appsetting['APP_NAME']);
	            $mail->setTo($model->email);
	            $mail->setBody($mailinfo);
	            $mail->setSubject($subject);
	            if($mail->send())
	            {

	            }
	            Yii::app()->user->setFlash('success', 'User created successfully');
			
				$this->redirect(array('index'));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$oldpassword = $model->password;
		$model->password = "";
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			if($model->password)
			{	
				$model->password = md5($model->password);
			}
			else{
				$model->password = $oldpassword;
			}
			if($model->save()){
				Yii::app()->user->setFlash('success', 'User updated successfully');
				$this->redirect(array('index'));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$m  = $this->loadModel($id);
		$m->deleted = 1;
		$m->save();

		// ->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		// $dataProvider=new CActiveDataProvider('User');
		// $this->render('index',array(
		// 	'dataProvider'=>$dataProvider,
		// ));
		$this->actionAdmin();
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return User the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param User $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function actionChange() {
        $id = Yii::app()->user->id;
        if (!$id)
            $this->redirect(array('index'));
        $user = User::model()->findByPk($id);
        // print_r($user->password);
        $oldpassword = $user->password;
		// $model->scenario ='updateprofile';
        //$user->setScenario('changepassword');
        // 202cb962ac59075b964b07152d234b70
		$user->setScenario('updateprofile');
		//die;
        $this->performAjaxValidation($user);
        if ($user) {
        	// die;
            if (isset($_POST['User'])) {
                $user->attributes = $_POST['User'];
                if ($user->email) {
                    $check = User::model()->findByAttributes(array('email' => $user->email), 'id<>' . $id);
                    if ($check) {
                        $user->addError('email', 'Email already taken');
                        $this->render('change', array('model' => $user));
                        Yii::app()->end();
                    }
                }
                if ($user->validate()) {
                	
                	if($_POST['User']['password'] == "")
                	{
                		$user->password = $oldpassword;
                		// print_r($_POST);
                		// die("AAA");
                	}
                	else
                	{
                    	$user->password = md5($user->password);
                    	// die("BBB");
                	}
                    $user->save(false);
//                    die;
                    Yii::app()->user->setFlash('success', 'Profile has been update successfully');
                    $this->refresh();
                } else {
//                    print_r($user->getErrors());
                }
            }
            $user->password = "";
            $this->render('change', array(
                'model' => $user,
            ));
        } else {
            $this->redirect(array('index'));
        }
    }
}
