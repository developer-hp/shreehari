<?php

class IssueEntryController extends Controller
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
			array('allow', 'actions' => array('index', 'view', 'admin', 'create', 'update', 'delete', 'pdf'), 'users' => array('@')),
			array('deny', 'users' => array('*')),
		);
	}

	public function actionView($id)
	{
		$this->render('view', array('model' => $this->loadModel($id)));
	}

	public function actionPdf($id)
	{
		$model = $this->loadModel($id);
		$filename = 'Issue-Entry-' . ($model->sr_no ? $model->sr_no : $model->id) . '.pdf';
		PdfHelper::render('viewPdf', array('model' => $model), $filename, 'I', 'A4', array(10, 10, 12, 10, 0, 0), 'P', 'gothic', false, '', false);
	}

	public function actionCreate()
	{
		$model = new IssueEntry;
		$this->performAjaxValidation($model);
		if (isset($_POST['IssueEntry'])) {
			$model->attributes = $_POST['IssueEntry'];
			$model->drcr = IssueEntry::DRCR_CREDIT;
			if ($model->save()) {
				Yii::app()->user->setFlash('success', 'Issue entry has been added.');
				$this->redirect(array('index'));
			}
		}
		$this->render('create', array('model' => $model));
	}

	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
		if (!LedgerAccess::canEditIssueEntry($model)) {
			Yii::app()->user->setFlash('error', 'You do not have permission to edit this entry. Staff can edit same-day entries only.');
			$this->redirect(array('index'));
			return;
		}
		$this->performAjaxValidation($model);
		if (isset($_POST['IssueEntry'])) {
			$model->attributes = $_POST['IssueEntry'];
			$model->drcr = IssueEntry::DRCR_CREDIT;
			if ($model->save()) {
				Yii::app()->user->setFlash('success', 'Issue entry has been updated.');
				$this->redirect(array('index'));
			}
		}
		$this->render('update', array('model' => $model));
	}

	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();
		Yii::app()->user->setFlash('success', 'Issue entry has been deleted.');
		if (!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	public function actionIndex()
	{
		$this->actionAdmin();
	}

	public function actionAdmin()
	{
		$model = new IssueEntry('search');
		$model->unsetAttributes();
		if (isset($_GET['IssueEntry']))
			$model->attributes = $_GET['IssueEntry'];
		// Exclude voucher-origin entries (from Jama / Supplier Ledger) in grid
		$model->is_voucher = 0;
		$this->render('admin', array('model' => $model));
	}

	public function loadModel($id)
	{
		$model = IssueEntry::model()->findByPk($id, 't.is_deleted = 0');
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'issue-entry-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
