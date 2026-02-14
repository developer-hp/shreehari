<?php

class AccountOpeningBalanceController extends Controller
{
	public $layout = '//layouts/main';

	public function filters()
	{
		return array(
			'accessControl',
			'postOnly + delete',
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',
				'actions' => array('index', 'view'),
				'users' => array('@'),
			),
			array('allow',
				'actions' => array('create', 'update'),
				'users' => array('@'),
			),
			array('allow',
				'actions' => array('admin', 'delete'),
				'users' => array('@'),
			),
			array('deny',
				'users' => array('*'),
			),
		);
	}

	public function actionView($id)
	{
		$this->render('view', array(
			'model' => $this->loadModel($id),
		));
	}

	public function actionCreate()
	{
		$model = new AccountOpeningBalance;
		$this->performAjaxValidation($model);

		if (isset($_POST['AccountOpeningBalance'])) {
			$model->attributes = $_POST['AccountOpeningBalance'];
			if ($model->save()) {
				Yii::app()->user->setFlash('success', 'Account opening balance has been added.');
				$this->redirect(array('index'));
			}
		}

		$this->render('create', array(
			'model' => $model,
		));
	}

	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
		$this->performAjaxValidation($model);

		if (isset($_POST['AccountOpeningBalance'])) {
			$model->attributes = $_POST['AccountOpeningBalance'];
			if ($model->save()) {
				Yii::app()->user->setFlash('success', 'Account opening balance has been updated.');
				$this->redirect(array('index'));
			}
		}

		$this->render('update', array(
			'model' => $model,
		));
	}

	public function actionDelete($id)
	{
		$this->loadModel($id)->delete(); // soft delete (sets is_deleted = 1)
		Yii::app()->user->setFlash('success', 'Opening balance has been deleted.');
		if (!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	public function actionIndex()
	{
		$this->actionAdmin();
	}

	public function actionAdmin()
	{
		$model = new AccountOpeningBalance('search');
		$model->unsetAttributes();
		if (isset($_GET['AccountOpeningBalance']))
			$model->attributes = $_GET['AccountOpeningBalance'];

		$this->render('admin', array(
			'model' => $model,
		));
	}

	/**
	 * Load model by id. Only non–soft-deleted records can be loaded (view/update/delete).
	 */
	public function loadModel($id)
	{
		$model = AccountOpeningBalance::model()->findByPk($id, 't.is_deleted = 0');
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'account-opening-balance-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
