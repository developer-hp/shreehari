<?php

class RepairController extends Controller
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
				'actions'=>array('index','view'),
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','pdf','sticker'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
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

	public function actionPdf($id)
	{
		$m1  = Repairing::model()->findByPk($id);
		$m2  = RepairingItems::model()->findAll('order_book_id='.$m1->id);

		PdfHelper::render(
			    'pdf',
			    array('m1'=>$m1,'m2'=>$m2),
			    'REPAIRING FORM-'.$m1->ref_no.'.pdf',
			    'I',
			    'A4',              // standard page size
			    [5, 5, 5, 5, 5, 5], // margins [left,right,top,bottom,header,footer]
			    'P',               // landscape
			    'gothic'       // custom font
			);

		
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Repairing;

		$c =Repairing::model()->find(array('condition'=>'type="REPAIR"','order'=>'id desc'));
		$model->ref_no = "1";
		if($c){
			$model->ref_no =$c->id+1;	
		}
		$model->date =date('d-m-Y');
		$model->delivery_date =date('d-m-Y',strtotime('+18 days'));
		$model->type ="REPAIR";

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);

		if(isset($_POST['Repairing']))
		{
			$model->attributes=$_POST['Repairing'];
			$model->user_id = Yii::app()->user->id;

			// $o =  Repairing::model()->findByAttributes(array('ref_no'=>$model->ref_no));
			// if($o){
			// 	if(isset($_POST['print']) && $_POST['print'])
			// 		$this->redirect(array('pdf','id'=>$o->id));
			// 	else 
			// 	$this->redirect(array('index'));
			// }
			
			$c =Repairing::model()->find(array('condition'=>'type="REPAIR"','order'=>'id desc'));
				$model->ref_no = "1";
				if($c){
					$model->ref_no =$c->id+1;	
				}


			if(isset($_FILES['Repairing']['name']['photo']) && $_FILES['Repairing']['name']['photo'] )
	        {
	            $ext = pathinfo($_FILES['Repairing']['name']['photo'], PATHINFO_EXTENSION);
	            $fileName = md5(time() . rand()) . "." . $ext;
	            $ext = strtolower($ext);
	            if($ext=="jpg" || $ext=="png" || $ext=="jpeg" || $ext=="gif" || $ext=="bmp"){
	                if (move_uploaded_file($_FILES['Repairing']['tmp_name']['photo'], Yii::app()->basePath . "/../" . Yii::app()->params['orderbook'] . $fileName)) {

	                    $model->photo = Yii::app()->params['orderbook'] . $fileName;
	                }
	            }
	        }
	        if(isset($_POST['image']) && $_POST['image'])
	        {
	        	$model->photo = Yii::app()->params['orderbook'] . $_POST['image'];
	        }
			if($model->save()){



				
				if(isset($_POST['description']) && $_POST['description'])
				{
					$c=1;
					foreach ($_POST['description'] as $key => $value) {
						if($value || isset($_POST['description'][$key]) && $_POST['description'][$key])
						{
							$item = new RepairingItems;
							$item->order_book_id = $model->id;
							// $item->code = $value;
							$item->item_code = $model->ref_no.'-'.($c);
							
							$item->i_code = $model->ref_no.'-'.($c);
							if($c==1)
								$item->i_code = $model->ref_no;
							$item->description = $_POST['description'][$key];
							$item->nw = $_POST['nw'][$key];
							$item->pcs = $_POST['pcs'][$key];
							// $item->size = $_POST['size'][$key];
							// $item->rate = $_POST['rate'][$key];
							// $item->lc = $_POST['lc'][$key];
							// $item->oc = $_POST['oc'][$key];
							$item->save();
							$c++;
						}
					}	
				}
				if(isset($_POST['print']) && $_POST['print'])
					$this->redirect(array('pdf','id'=>$model->id));
				else
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
		$old = $model->photo;
		$this->performAjaxValidation($model);

		if(isset($_POST['Repairing']))
		{
			$model->attributes=$_POST['Repairing'];

			if(isset($_FILES['Repairing']['name']['photo']) && $_FILES['Repairing']['name']['photo'] )
	        {
	        	if($old && file_exists(Yii::app()->basePath . "/../" . $old))
	        	{
	        		unlink(Yii::app()->basePath . "/../" . $old);
	        	}

	            $ext = pathinfo($_FILES['Repairing']['name']['photo'], PATHINFO_EXTENSION);
	            $fileName = md5(time() . rand()) . "." . $ext;
	            $ext = strtolower($ext);
	            if($ext=="jpg" || $ext=="png" || $ext=="jpeg" || $ext=="gif" || $ext=="bmp"){
	                if (move_uploaded_file($_FILES['Repairing']['tmp_name']['photo'], Yii::app()->basePath . "/../" . Yii::app()->params['orderbook'] . $fileName)) {

	                    $model->photo = Yii::app()->params['orderbook'] . $fileName;
	                }
	            }
	        }
	        else
	        	$model->photo = $old;

	        if(isset($_POST['image']) && $_POST['image'])
	        {
	        	$model->photo = Yii::app()->params['orderbook'] . $_POST['image'];
	        }

			if($model->save())
			{
				RepairingItems::model()->deleteAll(
				    "order_book_id=:order_book_id",
				    array(':order_book_id' => $model->id)
				);
				if(isset($_POST['description']) && $_POST['description'])
				{
					$c=1;
					foreach ($_POST['description'] as $key => $value) {
						if($value || isset($_POST['description'][$key]) && $_POST['description'][$key])
						{
							$item = new RepairingItems;
							$item->order_book_id = $model->id;
							// $item->code = $value;
							$item->item_code = $model->ref_no.'-'.($c);
							$item->i_code = $model->ref_no.'-'.($c);
							if($c==1)
								$item->i_code = $model->ref_no;
							$item->description = $_POST['description'][$key];
							$item->nw = $_POST['nw'][$key];
							$item->pcs = $_POST['pcs'][$key];
							// $item->rate = $_POST['rate'][$key];
							// $item->lc = $_POST['lc'][$key];
							// $item->oc = $_POST['oc'][$key];
							$item->save();
							$c++;
						}
					}	
				}
				if(isset($_POST['print']) && $_POST['print'])
					$this->redirect(array('pdf','id'=>$model->id));
				else
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
		$variable = RepairingItems::model()->findAll("order_book_id=".$id);
		foreach ($variable as $key => $value) {
			$value->delete();
		}
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new Repairing('rsearch');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Repairing']))
			$model->attributes=$_GET['Repairing'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Repairing the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Repairing::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Repairing $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='orderbooks-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
