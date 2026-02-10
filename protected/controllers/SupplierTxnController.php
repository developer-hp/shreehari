<?php

class SupplierTxnController extends Controller
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
				'actions' => array('index','view','admin','printLedger'),
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
		$model = new SupplierTxn('search');
		$model->unsetAttributes();
		if (isset($_GET['SupplierTxn'])) {
			$model->attributes = $_GET['SupplierTxn'];
		}

		$this->render('admin', array('model' => $model));
	}

	public function actionView($id)
	{
		$model = $this->loadModel($id);
		$model->with = array('items', 'items.charges', 'supplierAccount');
		$this->render('view', array('model' => $model));
	}

	/**
	 * Supplier ledger print (A4).
	 * GET: supplier_account_id, start, end
	 */
	public function actionPrintLedger()
	{
		$supplierId = isset($_GET['supplier_account_id']) ? (int)$_GET['supplier_account_id'] : 0;
		$start = isset($_GET['start']) ? $_GET['start'] : '';
		$end = isset($_GET['end']) ? $_GET['end'] : '';

		$account = $supplierId ? LedgerAccount::model()->findByPk($supplierId) : null;
		if (!$account) {
			throw new CHttpException(400, 'supplier_account_id is required.');
		}

		$criteria = new CDbCriteria;
		$criteria->compare('t.is_deleted', 0);
		$criteria->compare('t.supplier_account_id', $supplierId);
		if ($start) $criteria->addCondition("t.txn_date >= '".date('Y-m-d', strtotime($start))."'");
		if ($end) $criteria->addCondition("t.txn_date <= '".date('Y-m-d', strtotime($end))."'");
		$criteria->order = 't.txn_date asc, t.id asc';
		$txns = SupplierTxn::model()->findAll($criteria);

		$fileName = 'SupplierLedger_'.$account->name.'.pdf';
		PdfHelper::render(
			'supplierTxn/ledger_pdf',
			array('account'=>$account,'txns'=>$txns,'start'=>$start,'end'=>$end),
			$fileName,
			'I',
			'A4',
			array(8,8,8,8,0,0),
			'P',
			'gothic'
		);
	}

	public function actionCreate()
	{
		$model = new SupplierTxn;

		if (isset($_POST['SupplierTxn'])) {
			$model->attributes = $_POST['SupplierTxn'];

			if (empty($model->sr_no)) {
				$model->sr_no = DocumentNumberService::nextSrNo(DocumentNumberService::DOC_SUPPLIER);
			}

			$db = Yii::app()->db;
			$tx = $db->beginTransaction();
			try {
				if ($model->save()) {
					$this->saveItemsAndCharges($model->id);
					$tx->commit();
					Yii::app()->user->setFlash('success', 'Supplier transaction saved.');
					$this->redirect(array('view', 'id' => $model->id));
				}
			} catch (Exception $e) {
				if ($tx->active) $tx->rollback();
				Yii::app()->user->setFlash('danger', $e->getMessage());
			}
		}

		$this->render('create', array('model' => $model));
	}

	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
		if (!LedgerAccess::canModifyLedgerDoc($model, 'cp_supplier_txn', 'txn_date', 'supplier_account_id')) {
			throw new CHttpException(403, 'You are not allowed to modify this record.');
		}

		if (isset($_POST['SupplierTxn'])) {
			$model->attributes = $_POST['SupplierTxn'];

			$db = Yii::app()->db;
			$tx = $db->beginTransaction();
			try {
				if ($model->save()) {
					$this->deleteItemsAndCharges($model->id);
					$this->saveItemsAndCharges($model->id);
					$tx->commit();
					Yii::app()->user->setFlash('success', 'Supplier transaction updated.');
					$this->redirect(array('view', 'id' => $model->id));
				}
			} catch (Exception $e) {
				if ($tx->active) $tx->rollback();
				Yii::app()->user->setFlash('danger', $e->getMessage());
			}
		}

		$this->render('update', array('model' => $model));
	}

	public function actionDelete($id)
	{
		$model = $this->loadModel($id);
		if (!LedgerAccess::canModifyLedgerDoc($model, 'cp_supplier_txn', 'txn_date', 'supplier_account_id')) {
			throw new CHttpException(403, 'You are not allowed to delete this record.');
		}
		$model->is_deleted = 1;
		$model->save(false);

		if (!isset($_GET['ajax'])) {
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
	}

	protected function saveItemsAndCharges($txnId)
	{
		$items = isset($_POST['items']) && is_array($_POST['items']) ? $_POST['items'] : array();
		$charges = isset($_POST['charges']) && is_array($_POST['charges']) ? $_POST['charges'] : array();

		$lineNo = 1;
		foreach ($items as $idx => $row) {
			$itemName = isset($row['item_name']) ? trim($row['item_name']) : '';
			if ($itemName === '') continue;

			$item = new SupplierTxnItem;
			$item->supplier_txn_id = (int)$txnId;
			$item->sr_no_line = $lineNo++;
			$item->item_name = $itemName;
			$item->ct = isset($row['ct']) ? $row['ct'] : null;
			$item->gross_wt = isset($row['gross_wt']) ? $row['gross_wt'] : null;
			$item->net_wt = isset($row['net_wt']) ? $row['net_wt'] : null;
			$item->touch_pct = isset($row['touch_pct']) ? $row['touch_pct'] : null;
			$item->sort_order = isset($row['sort_order']) ? (int)$row['sort_order'] : 0;
			if (!$item->save()) {
				throw new CException('Failed to save item: ' . CHtml::errorSummary($item));
			}

			$chargeRows = isset($charges[$idx]) && is_array($charges[$idx]) ? $charges[$idx] : array();
			$cSort = 1;
			foreach ($chargeRows as $cRow) {
				$hasAny = false;
				foreach (array('charge_type','name','qty','rate','amount','unit') as $k) {
					if (isset($cRow[$k]) && trim((string)$cRow[$k]) !== '') { $hasAny = true; break; }
				}
				if (!$hasAny) continue;

				$ch = new SupplierTxnCharge;
				$ch->supplier_txn_item_id = (int)$item->id;
				$ch->charge_type = isset($cRow['charge_type']) ? $cRow['charge_type'] : null;
				$ch->name = isset($cRow['name']) ? $cRow['name'] : null;
				$ch->qty = isset($cRow['qty']) ? $cRow['qty'] : null;
				$ch->rate = isset($cRow['rate']) ? $cRow['rate'] : null;
				$ch->amount = isset($cRow['amount']) ? $cRow['amount'] : null;
				$ch->unit = isset($cRow['unit']) ? $cRow['unit'] : null;
				$ch->sort_order = $cSort++;
				if (!$ch->save()) {
					throw new CException('Failed to save charge: ' . CHtml::errorSummary($ch));
				}
			}
		}
	}

	protected function deleteItemsAndCharges($txnId)
	{
		$itemIds = Yii::app()->db->createCommand('SELECT id FROM cp_supplier_txn_item WHERE supplier_txn_id = :id')
			->queryColumn(array(':id' => (int)$txnId));

		if (!empty($itemIds)) {
			$criteria = new CDbCriteria;
			$criteria->addInCondition('supplier_txn_item_id', array_map('intval', $itemIds));
			SupplierTxnCharge::model()->deleteAll($criteria);
		}
		SupplierTxnItem::model()->deleteAll('supplier_txn_id=:id', array(':id' => (int)$txnId));
	}

	protected function loadModel($id)
	{
		$model = SupplierTxn::model()->findByPk($id);
		if ($model === null || (int)$model->is_deleted === 1) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}
		return $model;
	}
}

