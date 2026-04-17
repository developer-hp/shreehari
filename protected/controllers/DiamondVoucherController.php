<?php

class DiamondVoucherController extends Controller
{
	public $layout = '//layouts/main';

	public function filters()
	{
		return array('accessControl', 'postOnly + delete, deleteLockedSelected, deleteAllLocked');
	}

	public function accessRules()
	{
		return array(
			array('allow', 'actions' => array('index', 'admin', 'view', 'create', 'update', 'delete', 'deleteLockedSelected', 'deleteAllLocked', 'pdf', 'print', 'linkIssueEntry'), 'users' => array('@')),
			array('deny', 'users' => array('*')),
		);
	}

	public function actionIndex()
	{
		$this->actionAdmin();
	}

	public function actionAdmin()
	{
		$model = new DiamondVoucher('search');
		$model->unsetAttributes();
		if (isset($_GET['DiamondVoucher'])) {
			$model->attributes = $_GET['DiamondVoucher'];
		}
		$this->render('admin', array('model' => $model));
	}

	public function actionView($id)
	{
		$this->render('view', array('model' => $this->loadModel($id)));
	}

	public function actionCreate()
	{
		$model = new DiamondVoucher;
		$this->performAjaxValidation($model);
		if (isset($_POST['DiamondVoucher'])) {
			$saveAndPrint = isset($_POST['save_print']);
			$model->attributes = $_POST['DiamondVoucher'];
			if ($this->saveVoucher($model)) {
				Yii::app()->user->setFlash('success', 'Diamond voucher has been added.');
				if ($saveAndPrint) {
					$this->redirect(array('print', 'id' => $model->id));
				}
				$this->redirect(array('view', 'id' => $model->id));
			}
		}
		$this->render('create', array('model' => $model));
	}

	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
		if (!LedgerAccess::canEditVoucher($model, 'voucher_date')) {
			Yii::app()->user->setFlash('error', 'You do not have permission to edit this voucher. Staff can edit same-day unlocked vouchers, and Head can edit until voucher is locked.');
			$this->redirect(array('view', 'id' => $model->id));
			return;
		}
		$this->performAjaxValidation($model);
		if (isset($_POST['DiamondVoucher'])) {
			$saveAndPrint = isset($_POST['save_print']);
			$model->attributes = $_POST['DiamondVoucher'];
			if ($this->saveVoucher($model)) {
				Yii::app()->user->setFlash('success', 'Diamond voucher has been updated.');
				if ($saveAndPrint) {
					$this->redirect(array('print', 'id' => $model->id));
				}
				$this->redirect(array('view', 'id' => $model->id));
			}
		}
		$this->render('update', array('model' => $model));
	}

	public function actionDelete($id)
	{
		$model = $this->loadModel($id);
		if (!LedgerAccess::canDeleteVoucher($model, 'voucher_date')) {
			Yii::app()->user->setFlash('error', 'You do not have permission to delete this voucher. Staff can delete same-day vouchers only, Head can delete unlocked vouchers, and locked vouchers are Admin only.');
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
			return;
		}
		$model->delete();
		Yii::app()->user->setFlash('success', 'Diamond voucher has been deleted.');
		if (!isset($_GET['ajax'])) {
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
	}

	public function actionDeleteLockedSelected()
	{
		if (!LedgerAccess::isAdmin()) {
			throw new CHttpException(403, 'Only Admin can delete locked vouchers.');
		}
		$ids = isset($_POST['ids']) ? $_POST['ids'] : array();
		if (!is_array($ids)) {
			$ids = array($ids);
		}
		$deletedCount = 0;
		foreach ($ids as $id) {
			$id = (int) $id;
			if ($id <= 0) {
				continue;
			}
			$model = DiamondVoucher::model()->findByPk($id, 't.is_deleted = 0');
			if ($model && (int) $model->is_locked === 1) {
				if ($model->delete()) {
					$deletedCount++;
				}
			}
		}
		if ($deletedCount > 0) {
			Yii::app()->user->setFlash('success', $deletedCount . ' locked voucher(s) deleted successfully.');
		} else {
			Yii::app()->user->setFlash('info', 'No locked vouchers were deleted.');
		}
		$this->redirect(array('admin'));
	}

	public function actionDeleteAllLocked()
	{
		if (!LedgerAccess::isAdmin()) {
			throw new CHttpException(403, 'Only Admin can delete locked vouchers.');
		}
		$lockedRows = DiamondVoucher::model()->findAll('t.is_deleted = 0 AND t.is_locked = 1');
		$deletedCount = 0;
		foreach ($lockedRows as $row) {
			if ($row->delete()) {
				$deletedCount++;
			}
		}
		Yii::app()->user->setFlash('success', $deletedCount . ' locked voucher(s) deleted successfully.');
		$this->redirect(array('admin'));
	}

	public function actionLinkIssueEntry($id)
	{
		$model = $this->loadModel($id);
		$this->ensureIssueEntry($model);
		Yii::app()->user->setFlash('success', 'Issue entry linked.');
		$this->redirect(array('view', 'id' => $model->id));
	}

	public function actionPdf($id)
	{
		$model = $this->loadModel($id);
		$filename = 'Diamond-Voucher-' . ($model->voucher_number ? $model->voucher_number : $model->id) . '.pdf';
		PdfHelper::render('viewPdf', array('model' => $model), $filename, 'I', 'A4', array(10, 10, 12, 10, 0, 0), 'P', 'gothic', false, '', false);
	}

	public function actionPrint($id)
	{
		$model = $this->loadModel($id);
		$this->renderPartial('print', array('model' => $model), false, true);
	}

	protected function saveVoucher(DiamondVoucher $model)
	{
		$db = Yii::app()->db;
		$tx = $db->beginTransaction();
		$committed = false;
		try {
			if (!$model->save()) {
				$tx->rollBack();
				return false;
			}
			$tx->commit();
			$committed = true;
			$this->ensureIssueEntry($model);
			return true;
		} catch (Exception $e) {
			if (!$committed) {
				$tx->rollBack();
			}
			$model->addError('voucher_date', $e->getMessage());
			return false;
		}
	}

	protected function ensureIssueEntry(DiamondVoucher $model)
	{
		$voucherNo = ($model->voucher_number !== null && $model->voucher_number !== '') ? $model->voucher_number : (DocumentNumberService::getVoucherPrefix(DocumentNumberService::DOC_DIAMOND_VOUCHER) . $model->id);
		if ($model->issue_entry_id) {
			$entry = IssueEntry::model()->findByPk($model->issue_entry_id);
			if ($entry) {
				$entry->issue_date = $model->voucher_date;
				$entry->customer_id = $model->customer_id;
				$entry->carat = null;
				$entry->weight = null;
				$entry->fine_wt = 0;
				$entry->amount = (float) $model->amount;
				$entry->sr_no = $voucherNo;
				$entry->drcr = $model->drcr;
				$entry->remarks = $model->remarks;
				$entry->is_voucher = 1;
				$entry->save(false);
			}
		} else {
			$entry = new IssueEntry;
			$entry->issue_date = $model->voucher_date;
			$entry->sr_no = $voucherNo;
			$entry->customer_id = $model->customer_id;
			$entry->carat = null;
			$entry->weight = null;
			$entry->fine_wt = 0;
			$entry->amount = (float) $model->amount;
			$entry->drcr = $model->drcr;
			$entry->remarks = $model->remarks;
			$entry->is_voucher = 1;
			if ($entry->save(false)) {
				$model->issue_entry_id = $entry->id;
				$model->save(false);
			}
		}
	}

	public function loadModel($id)
	{
		$model = DiamondVoucher::model()->findByPk($id, 't.is_deleted = 0');
		if ($model === null) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'diamond-voucher-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}