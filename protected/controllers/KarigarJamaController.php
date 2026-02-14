<?php

/**
 * Karigar Jama Voucher - connected to Issue Entry.
 */
class KarigarJamaController extends Controller
{
	public $layout = '//layouts/main';

	public function filters()
	{
		return array('accessControl', 'postOnly + delete');
	}

	public function accessRules()
	{
		return array(
			array('allow', 'actions' => array('index', 'admin', 'view', 'create', 'update', 'delete', 'linkIssueEntry', 'pdf'), 'users' => array('@')),
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
		$this->loadModel($id)->delete();
		Yii::app()->user->setFlash('success', 'Jama voucher deleted.');
		$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
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
		$totalFineWt = 0;
		$totalAmount = 0;
		foreach ($voucher->lines as $line) {
			$totalFineWt += (float) $line->fine_wt;
			foreach ($line->stones as $s) $totalAmount += (float) $s->stone_amount;
		}
		if ($voucher->issue_entry_id) {
			$entry = IssueEntry::model()->findByPk($voucher->issue_entry_id);
			if ($entry) {
				$entry->issue_date = $voucher->voucher_date;
				$entry->fine_wt = $totalFineWt;
				$entry->sr_no = $voucher->voucher_number;
				$entry->amount = $totalAmount;
				$entry->drcr = IssueEntry::DRCR_CREDIT;
				$entry->remarks = $voucher->voucher_number ? ('Jama ' . $voucher->voucher_number) : ('Jama voucher #' . $voucher->id);
				$entry->is_voucher = 1;
				$entry->save(false);
			}
		} else {
			$entry = new IssueEntry;
			$entry->issue_date = $voucher->voucher_date;
			$entry->sr_no = $voucher->voucher_number;
			$entry->customer_id = $voucher->karigar_id;
			$entry->fine_wt = $totalFineWt;
			$entry->amount = $totalAmount;
			$entry->drcr = IssueEntry::DRCR_CREDIT;
			$entry->remarks = $voucher->voucher_number ? ('Jama ' . $voucher->voucher_number) : ('Jama voucher #' . $voucher->id);
			$entry->is_voucher = 1;
			if ($entry->save(false)) {
				$voucher->issue_entry_id = $entry->id;
				$voucher->save(false);
			}
		}
	}

	/**
	 * Download voucher as PDF.
	 */
	public function actionPdf($id)
	{
		$model = $this->loadModel($id);
		$filename = 'Jama-Voucher-' . $model->id . '-' . date('Y-m-d') . '.pdf';
		// A5, portrait (vertical) layout
		PdfHelper::render('viewPdf', array('model' => $model), $filename, 'D', 'A5', array(8, 8, 10, 8, 0, 0), 'P', 'gothic', false, '', false);
	}

	protected function saveVoucherWithLines(KarigarJamaVoucher $model, array $linesData)
	{
		$db = Yii::app()->db;
		$tx = $db->beginTransaction();
		$committed = false;
		try {
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
				if (empty($row['item_name']) && empty($row['net_wt'])) continue;
				$line = new KarigarJamaVoucherLine;
				$line->voucher_id = $voucherId;
				$line->sr_no = isset($row['sr_no']) ? $row['sr_no'] : '';
				$line->order_no = isset($row['order_no']) ? $row['order_no'] : '';
				$line->customer_name = isset($row['customer_name']) ? $row['customer_name'] : '';
				$line->item_name = isset($row['item_name']) ? $row['item_name'] : '';
				$line->psc = isset($row['psc']) ? $row['psc'] : null;
				$line->gross_wt = isset($row['gross_wt']) ? $row['gross_wt'] : null;
				$line->net_wt = isset($row['net_wt']) ? $row['net_wt'] : null;
				$line->touch_pct = isset($row['touch_pct']) ? $row['touch_pct'] : null;
				$line->remark = isset($row['remark']) ? $row['remark'] : '';
				$line->sort_order = $sortOrder++;
				$line->save(false);
				$totalFineWt += (float) $line->fine_wt;
				$stones = isset($row['stones']) ? $row['stones'] : array();
				foreach ($stones as $s) {
					$item = isset($s['item']) ? trim($s['item']) : '';
					$wt = isset($s['stone_wt']) ? $s['stone_wt'] : 0;
					$amt = isset($s['stone_amount']) ? $s['stone_amount'] : 0;
					if ($item === '' && $wt === '' && $amt === '') continue;
					$st = new KarigarJamaLineStone;
					$st->line_id = $line->id;
					$st->item = $item !== '' ? $item : null;
					$st->stone_wt = $wt !== '' ? $wt : 0;
					$st->stone_amount = $amt !== '' ? $amt : 0;
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
