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

    
    public function actionFeedback()
    {
       
       // die("AAA");
      $this->layout="frontlayout";
      $model=new Feedback;

    // Uncomment the following line if AJAX validation is needed
    $this->performAjaxValidation($model);
      if(isset($_POST['Feedback']))
      {
        $model->attributes=$_POST['Feedback'];
       
         if(isset($_POST['Feedback']['birthdate']) && $_POST['Feedback']['birthdate'] != "")
        {
            $model->birthdate = date('Y-m-d',strtotime($_POST['Feedback']['birthdate']));
        }

        if(isset($_POST['Feedback']['anniversary_date']) && $_POST['Feedback']['anniversary_date'] != "")
        {
            $model->anniversary_date = date('Y-m-d',strtotime($_POST['Feedback']['anniversary_date']));
        }

        $model->date = date('Y-m-d H:i:s');
       /* echo "<pre>";
        print_r($_POST);
        die();*/
        if($model->save())
        {
          Yii::app()->user->setFlash('success', 'Thank you for your feedback');
          $this->redirect(array('feedback'));
        }
      }

      $this->render('feedback',array('model'=>$model));


    }


    public function actionIndex()
    {

        $this->actionFeedback();
       /* $this->layout="frontlayout";

        $id = Yii::app()->user->id;

       
        $model = new ContactForm;

        

        $this->render('index',array('model'=>$model));*/

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



    public function actionLogout() 
    {

        Yii::app()->user->logout();

        $this->redirect(array('login'));

    }

    protected function performAjaxValidation($model) {

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'user-form') {

            echo CActiveForm::validate($model);

            Yii::app()->end();

        }

    }



}

