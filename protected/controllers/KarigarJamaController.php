<?php

/**
 * Karigar Voucher - connected to Issue Entry.
 */
class KarigarJamaController extends Controller
{
	public $layout = '//layouts/main';

	public function filters()
	{
		return array('accessControl', 'postOnly + delete, deleteLockedSelected, deleteAllLocked');
	}

	public function accessRules()
	{
		return array(
			array('allow', 'actions' => array('index', 'admin', 'view', 'create', 'update', 'delete', 'deleteLockedSelected', 'deleteAllLocked', 'linkIssueEntry', 'pdf'), 'users' => array('@')),
			array('deny', 'users' => array('*')),
		);
	}

	public function actionIndex()
	{
		$this->actionAdmin();
	}

	public function actionAdmin()
	{
		$model = new KarigarJamaVoucher('search');
		$model->unsetAttributes();
		if (isset($_GET['KarigarJamaVoucher']))
			$model->attributes = $_GET['KarigarJamaVoucher'];
		$this->render('admin', array('model' => $model));
	}

	public function actionView($id)
	{
		$this->render('view', array('model' => $this->loadModel($id)));
	}

	public function actionCreate()
	{
		$model = new KarigarJamaVoucher;
		$this->performAjaxValidation($model);
		if (isset($_POST['KarigarJamaVoucher'])) {
			$model->attributes = $_POST['KarigarJamaVoucher'];
			$lines = isset($_POST['lines']) ? $_POST['lines'] : array();
			if ($this->saveVoucherWithLines($model, $lines)) {
				Yii::app()->user->setFlash('success', 'Jama voucher saved.');
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
		if (isset($_POST['KarigarJamaVoucher'])) {
			$model->attributes = $_POST['KarigarJamaVoucher'];
			$lines = isset($_POST['lines']) ? $_POST['lines'] : array();
			if ($this->saveVoucherWithLines($model, $lines)) {
				Yii::app()->user->setFlash('success', 'Jama voucher updated.');
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
		Yii::app()->user->setFlash('success', 'Jama voucher deleted.');
		$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
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
			if ($id <= 0) continue;
			$model = KarigarJamaVoucher::model()->findByPk($id, 't.is_deleted = 0');
			if ($model && (int)$model->is_locked === 1) {
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
		$lockedRows = KarigarJamaVoucher::model()->findAll('t.is_deleted = 0 AND t.is_locked = 1');
		$deletedCount = 0;
		foreach ($lockedRows as $row) {
			if ($row->delete()) {
				$deletedCount++;
			}
		}
		Yii::app()->user->setFlash('success', $deletedCount . ' locked voucher(s) deleted successfully.');
		$this->redirect(array('admin'));
	}

	/**
	 * Create or update Issue Entry from this voucher (total fine_wt, total amount). Called automatically on save.
	 */
	public function actionLinkIssueEntry($id)
	{
		$voucher = $this->loadModel($id);
		$this->ensureIssueEntry($voucher);
		Yii::app()->user->setFlash('success', 'Issue entry linked.');
		$this->redirect(array('view', 'id' => $voucher->id));
	}

	/**
	 * Ensure an issue entry exists for this voucher (create or update in cp_issue_entry).
	 */
	protected function ensureIssueEntry(KarigarJamaVoucher $voucher)
	{
		$voucher = KarigarJamaVoucher::model()->with(array('lines' => array('with' => 'stones')))->findByPk($voucher->id);
		if (!$voucher) return;
		$prefix = DocumentNumberService::getVoucherPrefix(DocumentNumberService::DOC_KARIGAR_JAMA_VOUCHER);
		$voucherNo = ($voucher->voucher_number !== null && $voucher->voucher_number !== '') ? $voucher->voucher_number : ($prefix . $voucher->id);
		$totalFineWt = 0;
		$totalAmount = 0;
		foreach ($voucher->lines as $line) {
			$totalFineWt += (float) $line->fine_wt;
			foreach ($line->stones as $s) $totalAmount += (float) $s->stone_amount;
		}
		$drcr = IssueEntry::DRCR_DEBIT;
		if ($voucher->issue_entry_id) {
			$entry = IssueEntry::model()->findByPk($voucher->issue_entry_id);
			if ($entry) {
				$entry->issue_date = $voucher->voucher_date;
				$entry->fine_wt = $totalFineWt;
				$entry->sr_no = $voucherNo;
				$entry->amount = $totalAmount;
				$entry->drcr = $drcr;
				$entry->remarks = NULL;
				$entry->is_voucher = 1;
				$entry->save(false);
			}
		} else {
			$entry = new IssueEntry;
			$entry->issue_date = $voucher->voucher_date;
			$entry->sr_no = $voucherNo;
			$entry->customer_id = $voucher->karigar_id;
			$entry->fine_wt = $totalFineWt;
			$entry->amount = $totalAmount;
			$entry->drcr = $drcr;
			$entry->remarks = NULL;
			$entry->is_voucher = 1;
			if ($entry->save(false)) {
				$voucher->issue_entry_id = $entry->id;
				$voucher->save(false);
			}
		}
	}

	/**
	 * Open voucher PDF in browser.
	 */
	public function actionPdf($id)
	{
		$model = $this->loadModel($id);
		$filename = 'Karigar-Voucher-' . $model->voucher_number. '.pdf';
		// A4, landscape layout to fit full voucher grid
		PdfHelper::render('viewPdf', array('model' => $model), $filename, 'I', 'A4', array(6, 6, 8, 6, 0, 0), 'L', 'gothic', false, '', false);
	}

	protected function saveVoucherWithLines(KarigarJamaVoucher $model, array $linesData)
	{
		$db = Yii::app()->db;
		$tx = $db->beginTransaction();
		$committed = false;
		try {
			$model->drcr = IssueEntry::DRCR_DEBIT;
			if (!$model->save()) {
				$tx->rollBack();
				return false;
			}
			$voucherId = $model->id;
			KarigarJamaVoucherLine::model()->deleteAll('voucher_id = :vid', array(':vid' => $voucherId));
			$sortOrder = 0;
			$totalFineWt = 0;
			$totalAmount = 0;
			foreach ($linesData as $row) {
				$line = new KarigarJamaVoucherLine;
				$caratOptions = KarigarJamaVoucherLine::getCaratOptions();
				$carat = $this->getTypedFieldValue($row, 'carat', 'trimmed_string', '');
				if ($carat !== '' && !isset($caratOptions[$carat])) {
					$carat = '';
				}
				$line->voucher_id = $voucherId;
				$line->sr_no = $this->getTypedFieldValue($row, 'sr_no', 'string', '');
				$line->order_no = $this->getTypedFieldValue($row, 'order_no', 'string', '');
				$line->customer_name = $this->getTypedFieldValue($row, 'customer_name', 'string', '');
				$line->item_name = $this->getTypedFieldValue($row, 'item_name', 'string', '');
				$line->carat = $carat;
				$line->psc = $this->getTypedFieldValue($row, 'psc', 'float', null);
				$line->gross_wt = $this->getTypedFieldValue($row, 'gross_wt', 'float', null);
				$line->net_wt = $this->getTypedFieldValue($row, 'net_wt', 'float', null);
				$line->touch_pct = $this->getTypedFieldValue($row, 'touch_pct', 'float', null);
				$line->remark = $this->getTypedFieldValue($row, 'remark', 'string', '');
				$line->sort_order = $sortOrder++;
				$line->save(false);
				if($line->fine_wt && is_numeric($line->fine_wt))
				$totalFineWt += (float) $line->fine_wt;
				$stones = $this->getTypedFieldValue($row, 'stones', 'array', array());
				foreach ($stones as $s) {
					$item = $this->getTypedFieldValue($s, 'item', 'trimmed_string', '');
					$wt = $this->getTypedFieldValue($s, 'stone_wt', 'float', 0);
					$amt = $this->getTypedFieldValue($s, 'stone_amount', 'float', 0);
					if ($item === '' && (float) $wt == 0 && (float) $amt == 0) continue;
					$st = new KarigarJamaLineStone;
					$st->line_id = $line->id;
					$st->item = $item !== '' ? $item : null;
					$st->stone_wt = $wt;
					$st->stone_amount = $amt;
					$st->save(false);
					$totalAmount += (float) $amt;
				}
			}
			$model->total_fine_wt = $totalFineWt;
			$model->total_amount = $totalAmount;
			$model->save(false);
			$tx->commit();
			$committed = true;
			$this->ensureIssueEntry($model);
			return true;
		} catch (Exception $e) {
			if (!$committed)
				$tx->rollBack();
			$model->addError('voucher_date', $e->getMessage());
			return false;
		}
	}

	

	public function loadModel($id)
	{
		$model = KarigarJamaVoucher::model()->findByPk($id, 't.is_deleted = 0');
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'karigar-jama-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
