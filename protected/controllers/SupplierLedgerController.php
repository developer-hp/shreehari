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
		$drcr = IssueEntry::DRCR_DEBIT;
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
			$model->drcr = IssueEntry::DRCR_DEBIT;
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
				$itemName = $this->getTypedFieldValue($row, 'item_name', 'trimmed_string', '');
				$netWt = $this->getTypedFieldValue($row, 'net_wt', 'float', null);
				if ($itemName === '') continue;
				$item = new SupplierLedgerTxnItem;
				$item->txn_id = $txnId;
				$item->item_name = $itemName;
				$item->ct = $this->getTypedFieldValue($row, 'ct', 'float', null);
				$item->gross_wt = $this->getTypedFieldValue($row, 'gross_wt', 'float', null);
				$item->net_wt = $netWt;
				$item->touch_pct = $this->getTypedFieldValue($row, 'touch_pct', 'float', null);
				$item->sort_order = $sortOrder++;
				$item->save(false);
				$itemTotal = 0;
				$charges = $this->getTypedFieldValue($row, 'charges', 'array', array());
				foreach ($charges as $c) {
					$chargeType = $this->getTypedFieldValue($c, 'charge_type', 'int', null);
					$chargeName = $this->getTypedFieldValue($c, 'charge_name', 'trimmed_string', null);
					$quantity = $this->getTypedFieldValue($c, 'quantity', 'float', 0);
					$rate = $this->getTypedFieldValue($c, 'rate', 'float', 0);
					if ($chargeType === null || ($chargeType == 5 && empty($chargeName) && (float) $quantity == 0)) continue;
					$ch = new SupplierLedgerTxnItemCharge;
					$ch->txn_item_id = $item->id;
					$ch->charge_type = $chargeType;
					$ch->charge_name = $chargeName;
					$ch->quantity = $quantity;
					$ch->rate = $rate;
					$ch->save(false);
					if($ch->amount && is_numeric($ch->amount))
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
