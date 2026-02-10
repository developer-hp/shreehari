<?php

class SiteController extends Controller {

    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }


    /* public function actionSetlanguage()
    {

        if (isset($_GET['type']))
        {
            $lang = substr($_GET['type'],0,2);
         Yii::app()->session['lang'] = $lang;
        }
        if (isset(Yii::app()->session['lang']))
        {
            Yii::app()->language = Yii::app()->session['lang'];
        }    
        $this->redirect(Yii::app()->request->urlReferrer);
    } */



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
        $this->redirect(array('user/index'));
    }

    public function actionForm($id)
    {
        $questions = Questions::model()->findAll('form_id='.$id);

        $model=Forms::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');

        // Answer
        if(isset($_POST['answer']))
        {
            $answer_id = md5(time().'-'.Yii::app()->user->id);
            foreach ($_POST['answer'] as $key => $value) {
                $q = new Answer;
                $q->form_id = $model->id;
                $q->user_id = Yii::app()->user->id;
                $q->question_id = $key;
                $q->answer_id = $answer_id;
                $q->answer = $value;
                $q->save();
            }
            $this->redirect(array('result','aid'=>$answer_id,'t'=>0));
        }


        $this->render('form',array(
            'model'=>$model,
            'questions'=>$questions,
        ));
    }

    public function actionResult($aid,$t)
    {
        $a = Answer::model()->findAll(array('condition'=>'answer_id="'.$aid.'"'));
        $fid = $a[0]['form_id'];

        $output = Output::model()->find(array('condition'=>'form_id='.$fid.' and id<>'.$t,'order'=>'rand()'));
        $text = "";
        if($output){
            $text = $output->outputs;
            $t = $output->id;
        }

        foreach ($a as $key => $value) {
            $text = str_replace('{{question'.($key+1).'}}', $value->answer, $text);
            $text = str_replace('{{question'.($key+1).'}}', "", $text);
        }
        $this->render('result',array(
            't'=>$t,
            'aid'=>$aid,
            'text'=>$text,
        ));
    }
    public function actionIndex() {
        $id = Yii::app()->user->id;
        if (!$id) {
            $this->redirect(array('login'));
        }
        $this->render('index');
    }
    
    
    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact() {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $name = '=?UTF-8?B?' . base64_encode($model->name) . '?=';
                $subject = '=?UTF-8?B?' . base64_encode($model->subject) . '?=';
                $headers = "From: $name <{$model->email}>\r\n" .
                        "Reply-To: {$model->email}\r\n" .
                        "MIME-Version: 1.0\r\n" .
                        "Content-Type: text/plain; charset=UTF-8";

                mail(Yii::app()->params['adminEmail'], $subject, $model->body, $headers);
                Yii::app()->user->setFlash('contact', 'Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact', array('model' => $model));
    }

    /**
     * Displays the login page
     */
    
    public function actionLogin() {
        $model = new LoginForm;
        $this->layout = 'login';

        $id = Yii::app()->user->id;
        if ($id) {
            $this->redirect(Yii::app()->user->returnUrl);
        }

        // if it is ajax validation request
        // if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
        // {
        // 	echo CActiveForm::validate($model);
        // 	Yii::app()->end();
        // }
        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login()){
                $this->redirect(Yii::app()->user->returnUrl);
            }
        }
        // display the login form
        $this->render('login', array('model' => $model));
    }


    public function actionForgot()
    {
        //die("Login");
        $this->layout='login';
        $model = new User;
        // $model->scenario ='changepasswrd_email';
        // $model->setScenario('changepasswrd_email');
        //if it is ajax validation request
        if(isset($_POST['ajax']) && $_POST['ajax'] === 'login-form')
        {
            // die("helloo");
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // $this->performAjaxValidation($model);
        // collect user input date_add()
             if (isset($_POST['User'])) 
             {
                $appsetting = $this->getsettings();
                $model->attributes = $_POST['User'];

                $check = User::model()->findByAttributes(array('email' => $model->email, 'deleted' => 0));
                if(!$check) {
                    $model->addError('email', 'Email does not exists!');
                    $this->render('forgot', array('model' => $model));
                    Yii::app()->end();
                }
                $model = $check;
                $token = md5(time().'-'.$model->id);
                $model->forgot_password_token = $token;
                $model->forgot_token_expire = time()+3600;
                $model->save(false);

                $url = Yii::app()->createAbsoluteUrl('site/changepassword?id=' . $check->forgot_password_token);
                $subject= CHtml::encode($appsetting['APP_NAME']) . " : Reset Password";
                $login_user_name='';
                $firstname='';
                if(isset($check->name) && $check->name!='')
                {
                    $firstname=$check->name;
                }
               /* if(isset($check->lastname) && $check->lastname!=''){
                    $lastname=$check->lastname;
                }*/
               $login_user_name=$firstname;
                $message = 'Hello '.$login_user_name.'<br/><br/> 

                Click below link for reset your password. Link will be expire in 1 hr<br/>

                <a href="' . $url . '">' . $url . '</a> ';
                    $mail = new YiiMailer();
                    $mail->setFrom(Yii::app()->params['adminEmail'], CHtml::encode($appsetting['APP_NAME']) . ' : Reset Password');
                    $mail->setTo($check->email);
                    $mail->setSubject($subject);
                    $mail->setBody($message);
                    if ($mail->send()) {
                         Yii::app()->user->setFlash('success', 'Please check mail for resetting password! Link will be expire in 1 hour!');
                    }
                    else
                    {
                        echo '<pre>';
                        var_dump($mail->getError());
                        echo '</pre>';
                        exit;
                    }
                
        }
   
        $this->render('forgot',array('model'=>$model));
    }



    public function actionChangepassword()
    {
        //die("Login");

        $this->layout='login';
        $model = new User;
        $model->scenario = 'changePwdSet';
        //if it is ajax validation request
        if(isset($_POST['ajax']) && $_POST['ajax'] === 'login-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        /*print_r($token_id);
        die();*/
        // collect user input data
        if(isset($_POST['User']))
        {
            /*pr($_POST);
            die();*/
            $token_id = $_REQUEST['id'];
            $hidden_token_id = $_POST['url_token'];
            if($token_id == $hidden_token_id)
            {
                $model_token = User::model()->findByAttributes(array('forgot_password_token' => $token_id ,'deleted'=>0));
                /*  print_r($_POST);
                  die();  */
                if($model_token)
                {
                    if ($model_token->forgot_password_token == $token_id && $model_token->forgot_token_expire > time())
                    {
                        $model_token->password = md5($_POST['User']['new_password']);
                        $model_token->forgot_password_token = "";
                        
                        if ($model_token->save(false))
                        {
                            Yii::app()->user->setFlash('success', "Your password has been changed successfully. you may login with your new passwprd");
                               $this->redirect(array('login'));
                        }
                    }
                    else
                    {
                        Yii::app()->user->setFlash('danger', "Your token has been expired try again.");
                        $this->redirect(array('login'));
                    }    
                }
                else
                {
                    Yii::app()->user->setFlash('danger', "Something went wrong..");
                    $this->redirect(array('login'));
                }
            }
            else
            {
                Yii::app()->user->setFlash('danger', "Something went wrong..");
                $this->redirect(array('login'));
            }   
        }
        // display the login form
        $this->render('changepassword',array('model'=>$model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='event-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
