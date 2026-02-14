<?php

class SubitemTypeController extends Controller
{
	public $layout = '//layouts/main';

	public function filters()
	{
		return array('accessControl', 'postOnly + delete');
	}

	public function accessRules()
	{
		return array(
			array('allow', 'actions' => array('index', 'admin', 'view', 'create', 'update', 'delete'), 'users' => array('@')),
			array('deny', 'users' => array('*')),
		);
	}

	public function actionIndex()
	{
		$this->actionAdmin();
	}

	public function actionAdmin()
	{
		$model = new SubitemType('search');
		$model->unsetAttributes();
		if (isset($_GET['SubitemType']))
			$model->attributes = $_GET['SubitemType'];
		$this->render('admin', array('model' => $model));
	}

	public function actionView($id)
	{
		$this->render('view', array('model' => $this->loadModel($id)));
	}

	public function actionCreate()
	{
		$model = new SubitemType;
		$this->performAjaxValidation($model);
		if (isset($_POST['SubitemType'])) {
			$model->attributes = $_POST['SubitemType'];
			if ($model->save()) {
				Yii::app()->user->setFlash('success', 'Subitem type has been added.');
				$this->redirect(array('admin'));
			}
		}
		$this->render('create', array('model' => $model));
	}

	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
		$this->performAjaxValidation($model);
		if (isset($_POST['SubitemType'])) {
			$model->attributes = $_POST['SubitemType'];
			if ($model->save()) {
				Yii::app()->user->setFlash('success', 'Subitem type has been updated.');
				$this->redirect(array('admin'));
			}
		}
		$this->render('update', array('model' => $model));
	}

	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();
		Yii::app()->user->setFlash('success', 'Subitem type has been deleted.');
		$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	public function loadModel($id)
	{
		$model = SubitemType::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'subitem-type-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
