<?php

/**
 * Supplier Voucher: transaction entry (date, supplier, items with charges).
 */
class SupplierLedgerController extends Controller
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
		$model = new SupplierLedgerTxn('search');
		$model->unsetAttributes();
		if (isset($_GET['SupplierLedgerTxn']))
			$model->attributes = $_GET['SupplierLedgerTxn'];
		$this->render('admin', array('model' => $model));
	}

	public function actionView($id)
	{
		$this->render('view', array('model' => $this->loadModel($id)));
	}

	public function actionCreate()
	{
		$model = new SupplierLedgerTxn;
		$this->performAjaxValidation($model);
		if (isset($_POST['SupplierLedgerTxn'])) {
			$model->attributes = $_POST['SupplierLedgerTxn'];
			if ($this->saveTxnWithItems($model, isset($_POST['items']) ? $_POST['items'] : array())) {
				Yii::app()->user->setFlash('success', 'Transaction saved.');
				$this->redirect(array('view', 'id' => $model->id));
			}
		}
		$this->render('create', array('model' => $model));
	}

	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
		if ($model->is_locked == 1) {
			Yii::app()->user->setFlash('error', 'This voucher is locked and cannot be edited. It was locked after opening balance was updated from closing.');
			$this->redirect(array('view', 'id' => $model->id));
			return;
		}
		$this->performAjaxValidation($model);
		if (isset($_POST['SupplierLedgerTxn'])) {
			$model->attributes = $_POST['SupplierLedgerTxn'];
			$items = isset($_POST['items']) ? $_POST['items'] : array();
			if ($this->saveTxnWithItems($model, $items)) {
				Yii::app()->user->setFlash('success', 'Transaction updated.');
				$this->redirect(array('view', 'id' => $model->id));
			}
		}
		$this->render('update', array('model' => $model));
	}

	public function actionDelete($id)
	{
		$model = $this->loadModel($id);
		if ($model->is_locked == 1) {
			Yii::app()->user->setFlash('error', 'This voucher is locked and cannot be deleted. It was locked after opening balance was updated from closing.');
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
			return;
		}
		$model->delete();
		Yii::app()->user->setFlash('success', 'Transaction deleted.');
		$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Create or update Issue Entry from this transaction (total_fine_wt, total_amount). Supplier = customer, DR.
	 * Called automatically after save; also exposed for manual link.
	 */
	public function actionLinkIssueEntry($id)
	{
		$model = $this->loadModel($id);
		$this->ensureIssueEntry($model);
		Yii::app()->user->setFlash('success', 'Issue entry linked.');
		$this->redirect(array('view', 'id' => $model->id));
	}

	/**
	 * Ensure an issue entry exists for this supplier ledger txn (create or update).
	 */
	protected function ensureIssueEntry(SupplierLedgerTxn $model)
	{
		$totalFineWt = (float) $model->total_fine_wt;
		$totalAmount = (float) $model->total_amount;
		$prefix = DocumentNumberService::getVoucherPrefix(DocumentNumberService::DOC_SUPPLIER_LEDGER_VOUCHER);
		$voucherNo = ($model->voucher_number !== null && $model->voucher_number !== '') ? $model->voucher_number : ($prefix . $model->id);
		// Use the selected drcr value, default to DR if not set
		$drcr = isset($model->drcr) && $model->drcr ? $model->drcr : IssueEntry::DRCR_DEBIT;
		if ($model->issue_entry_id) {
			$entry = IssueEntry::model()->findByPk($model->issue_entry_id);
			if ($entry) {
				$entry->issue_date = $model->txn_date;
				$entry->fine_wt = $totalFineWt;
				$entry->amount = $totalAmount;
				$entry->sr_no = $voucherNo;
				$entry->drcr = $drcr;
				$entry->remarks = 'Supplier Voucher ' . $voucherNo;
				$entry->is_voucher = 1;
				$entry->save(false);
			}
		} else {
			$entry = new IssueEntry;
			$entry->issue_date = $model->txn_date;
			$entry->sr_no = $voucherNo;
			$entry->customer_id = $model->supplier_id;
			$entry->fine_wt = $totalFineWt;
			$entry->amount = $totalAmount;
			$entry->drcr = $drcr;
			$entry->remarks = 'Supplier Ledger ' . $voucherNo;
			$entry->is_voucher = 1;
			if ($entry->save(false)) {
				$model->issue_entry_id = $entry->id;
				$model->save(false);
			}
		}
	}

	/**
	 * Download transaction as PDF.
	 */
	public function actionPdf($id)
	{
		$model = $this->loadModel($id);
		$filename = 'Supplier-Ledger-Txn-' . $model->id . '-' . date('Y-m-d') . '.pdf';
		PdfHelper::render('viewPdf', array('model' => $model), $filename, 'D', 'A4', array(10, 10, 12, 10, 0, 0), 'P', 'gothic', false, '', false);
	}

	/**
	 * Save txn header, items and charges; set total_fine_wt, total_amount.
	 */
	protected function saveTxnWithItems(SupplierLedgerTxn $model, array $itemsData)
	{
		$db = Yii::app()->db;
		$tx = $db->beginTransaction();
		$committed = false;
		try {
			if (!$model->save()) {
				$tx->rollBack();
				return false;
			}
			$txnId = $model->id;
			// Remove existing items (cascade will remove charges)
			SupplierLedgerTxnItem::model()->deleteAll('txn_id = :tid', array(':tid' => $txnId));
			$totalFineWt = 0;
			$totalAmount = 0;
			$sortOrder = 0;
			foreach ($itemsData as $row) {
				if (empty($row['item_name']) && empty($row['net_wt'])) continue;
				$item = new SupplierLedgerTxnItem;
				$item->txn_id = $txnId;
				$item->item_name = isset($row['item_name']) ? $row['item_name'] : '';
				$item->ct = isset($row['ct']) ? $row['ct'] : null;
				$item->gross_wt = isset($row['gross_wt']) ? $row['gross_wt'] : null;
				$item->net_wt = isset($row['net_wt']) ? $row['net_wt'] : null;
				$item->touch_pct = isset($row['touch_pct']) ? $row['touch_pct'] : null;
				$item->sort_order = $sortOrder++;
				$item->save(false);
				$itemTotal = 0;
				$charges = isset($row['charges']) ? $row['charges'] : array();
				foreach ($charges as $c) {
					if (!isset($c['charge_type']) || ($c['charge_type'] == 5 && empty($c['charge_name']) && empty($c['quantity']))) continue;
					$ch = new SupplierLedgerTxnItemCharge;
					$ch->txn_item_id = $item->id;
					$ch->charge_type = (int) $c['charge_type'];
					$ch->charge_name = isset($c['charge_name']) ? $c['charge_name'] : null;
					$ch->quantity = isset($c['quantity']) ? $c['quantity'] : 0;
					$ch->rate = isset($c['rate']) ? $c['rate'] : 0;
					$ch->save(false);
					$itemTotal += (float) $ch->amount;
				}
				$item->item_total = $itemTotal;
				$item->save(false);
				$totalFineWt += (float) $item->fine_wt;
				$totalAmount += $itemTotal;
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
			$model->addError('txn_date', $e->getMessage());
			return false;
		}
	}

	public function loadModel($id)
	{
		$model = SupplierLedgerTxn::model()->findByPk($id, 't.is_deleted = 0');
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'supplier-ledger-txn-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
