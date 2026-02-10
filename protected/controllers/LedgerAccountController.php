<?php

class LedgerAccountController extends Controller
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
				'actions' => array('index','admin','view'),
				'users' => array('@'),
			),
			array('allow',
				'actions' => array('create','update','delete'),
				'users' => array('@'),
			),
			array('deny', 'users' => array('*')),
		);
	}

	public function actionIndex()
	{
		$this->redirect(array('admin'));
	}

	public function actionAdmin()
	{
		$model = new LedgerAccount('search');
		$model->unsetAttributes();
		if (isset($_GET['LedgerAccount'])) {
			$model->attributes = $_GET['LedgerAccount'];
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
		$model = new LedgerAccount;
		if (isset($_POST['LedgerAccount'])) {
			$model->attributes = $_POST['LedgerAccount'];
			// Only main user can set opening balances on create
			if (!LedgerAccess::isMainUser()) {
				$model->opening_fine_wt = 0;
				$model->opening_fine_wt_drcr = LedgerAccount::DRCR_CR;
				$model->opening_amount = 0;
				$model->opening_amount_drcr = LedgerAccount::DRCR_CR;
			}
			if ($model->save()) {
				Yii::app()->user->setFlash('success', 'Ledger account created.');
				$this->redirect(array('view','id'=>$model->id));
			}
		}
		$this->render('create', array('model' => $model));
	}

	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
		$oldOpeningFine = $model->opening_fine_wt;
		$oldOpeningFineDrCr = $model->opening_fine_wt_drcr;
		$oldOpeningAmount = $model->opening_amount;
		$oldOpeningAmountDrCr = $model->opening_amount_drcr;
		if (isset($_POST['LedgerAccount'])) {
			$model->attributes = $_POST['LedgerAccount'];
			// Only main user can change opening balances
			if (!LedgerAccess::isMainUser()) {
				$model->opening_fine_wt = $oldOpeningFine;
				$model->opening_fine_wt_drcr = $oldOpeningFineDrCr;
				$model->opening_amount = $oldOpeningAmount;
				$model->opening_amount_drcr = $oldOpeningAmountDrCr;
			}
			if ($model->save()) {
				Yii::app()->user->setFlash('success', 'Ledger account updated.');
				$this->redirect(array('view','id'=>$model->id));
			}
		}
		$this->render('update', array('model' => $model));
	}

	public function actionDelete($id)
	{
		$model = $this->loadModel($id);
		$model->is_deleted = 1;
		$model->save(false);
		if (!isset($_GET['ajax'])) {
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
	}

	protected function loadModel($id)
	{
		$model = LedgerAccount::model()->findByPk($id);
		if ($model === null || (int)$model->is_deleted === 1) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}
		return $model;
	}
}

