<?php

class IssueEntryController extends Controller
{
	public $layout='//layouts/main';

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
				'actions' => array('index','view','admin'),
				'users' => array('@'),
			),
			array('allow',
				'actions' => array('create','update','delete'),
				'users' => array('@'),
			),
			array('deny',
				'users' => array('*'),
			),
		);
	}

	public function actionIndex()
	{
		$this->redirect(array('admin'));
	}

	public function actionAdmin()
	{
		$model = new IssueEntry('search');
		$model->unsetAttributes();
		if (isset($_GET['IssueEntry'])) {
			$model->attributes = $_GET['IssueEntry'];
		}
		$this->render('admin', array('model' => $model));
	}

	public function actionView($id)
	{
		$model = $this->loadModel($id);
		$this->render('view', array('model' => $model));
	}

	public function actionCreate()
	{
		$model = new IssueEntry;
		if (isset($_POST['IssueEntry'])) {
			$model->attributes = $_POST['IssueEntry'];
			if (empty($model->sr_no)) {
				$model->sr_no = DocumentNumberService::nextSrNo(DocumentNumberService::DOC_ISSUE);
			}
			if ($model->save()) {
				Yii::app()->user->setFlash('success', 'Issue entry saved.');
				$this->redirect(array('view', 'id' => $model->id));
			}
		}
		$this->render('create', array('model' => $model));
	}

	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
		if (!LedgerAccess::canModifyLedgerDoc($model, 'cp_issue_entry', 'issue_date', 'account_id')) {
			throw new CHttpException(403, 'You are not allowed to modify this record.');
		}
		if (isset($_POST['IssueEntry'])) {
			$model->attributes = $_POST['IssueEntry'];
			if ($model->save()) {
				Yii::app()->user->setFlash('success', 'Issue entry updated.');
				$this->redirect(array('view', 'id' => $model->id));
			}
		}
		$this->render('update', array('model' => $model));
	}

	public function actionDelete($id)
	{
		$model = $this->loadModel($id);
		if (!LedgerAccess::canModifyLedgerDoc($model, 'cp_issue_entry', 'issue_date', 'account_id')) {
			throw new CHttpException(403, 'You are not allowed to delete this record.');
		}
		$model->is_deleted = 1;
		$model->save(false);

		if (!isset($_GET['ajax'])) {
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
	}

	protected function loadModel($id)
	{
		$model = IssueEntry::model()->findByPk($id);
		if ($model === null || (int)$model->is_deleted === 1) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}
		return $model;
	}
}

