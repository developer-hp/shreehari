<?php

class KarigarVoucherController extends Controller
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
				'actions' => array('index','view','admin','ledger','print','printLedger'),
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
		$model = new KarigarVoucher('search');
		$model->unsetAttributes();
		if (isset($_GET['KarigarVoucher'])) {
			$model->attributes = $_GET['KarigarVoucher'];
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
		$model = new KarigarVoucher;

		if (isset($_POST['KarigarVoucher'])) {
			$model->attributes = $_POST['KarigarVoucher'];
			if (empty($model->sr_no)) {
				$model->sr_no = DocumentNumberService::nextSrNo(DocumentNumberService::DOC_KARIGAR);
			}

			$db = Yii::app()->db;
			$tx = $db->beginTransaction();
			try {
				if ($model->save()) {
					$this->saveLinesAndComponents($model->id);
					$tx->commit();
					Yii::app()->user->setFlash('success', 'Karigar voucher saved.');
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
		if (!LedgerAccess::canModifyLedgerDoc($model, 'cp_karigar_voucher', 'voucher_date', 'karigar_account_id')) {
			throw new CHttpException(403, 'You are not allowed to modify this record.');
		}

		if (isset($_POST['KarigarVoucher'])) {
			$model->attributes = $_POST['KarigarVoucher'];

			$db = Yii::app()->db;
			$tx = $db->beginTransaction();
			try {
				if ($model->save()) {
					$this->deleteLinesAndComponents($model->id);
					$this->saveLinesAndComponents($model->id);
					$tx->commit();
					Yii::app()->user->setFlash('success', 'Karigar voucher updated.');
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
		if (!LedgerAccess::canModifyLedgerDoc($model, 'cp_karigar_voucher', 'voucher_date', 'karigar_account_id')) {
			throw new CHttpException(403, 'You are not allowed to delete this record.');
		}
		$model->is_deleted = 1;
		$model->save(false);

		if (!isset($_GET['ajax'])) {
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
	}

	/**
	 * Simple Karigar ledger report: lists vouchers (date-wise) with total fine_wt and total component amount.
	 */
	public function actionLedger()
	{
		$karigarId = isset($_GET['karigar_account_id']) ? (int)$_GET['karigar_account_id'] : 0;
		$start = isset($_GET['start']) ? $_GET['start'] : '';
		$end = isset($_GET['end']) ? $_GET['end'] : '';

		$karigarOptions = CHtml::listData(
			LedgerAccount::model()->findAllByAttributes(array('type'=>LedgerAccount::TYPE_KARIGAR,'is_deleted'=>0), array('order'=>'name asc')),
			'id',
			'name'
		);

		$criteria = new CDbCriteria;
		$criteria->compare('t.is_deleted', 0);
		if ($karigarId) $criteria->compare('t.karigar_account_id', $karigarId);
		if ($start) $criteria->addCondition("t.voucher_date >= '".date('Y-m-d', strtotime($start))."'");
		if ($end) $criteria->addCondition("t.voucher_date <= '".date('Y-m-d', strtotime($end))."'");
		$criteria->order = 't.voucher_date asc, t.id asc';

		$dataProvider = new CActiveDataProvider('KarigarVoucher', array(
			'criteria' => $criteria,
			'pagination' => array('pageSize' => 50),
		));

		$this->render('ledger', array(
			'dataProvider' => $dataProvider,
			'karigarId' => $karigarId,
			'start' => $start,
			'end' => $end,
			'karigarOptions' => $karigarOptions,
		));
	}

	public function actionPrint($id)
	{
		$model = $this->loadModel($id);
		$lines = KarigarVoucherLine::model()->with('components','customer')->findAllByAttributes(
			array('karigar_voucher_id'=>$model->id),
			array('order'=>'t.sort_order asc, t.id asc')
		);

		$fileName = 'JamaVoucher_'.$model->sr_no.'.pdf';
		PdfHelper::render(
			'karigarVoucher/print_pdf',
			array('model'=>$model,'lines'=>$lines),
			$fileName,
			'I',
			'A5',
			array(6,6,6,6,0,0),
			'P',
			'gothic'
		);
	}

	public function actionPrintLedger()
	{
		$karigarId = isset($_GET['karigar_account_id']) ? (int)$_GET['karigar_account_id'] : 0;
		$start = isset($_GET['start']) ? $_GET['start'] : '';
		$end = isset($_GET['end']) ? $_GET['end'] : '';

		$account = $karigarId ? LedgerAccount::model()->findByPk($karigarId) : null;
		if (!$account) {
			throw new CHttpException(400, 'karigar_account_id is required.');
		}

		$criteria = new CDbCriteria;
		$criteria->compare('t.is_deleted', 0);
		$criteria->compare('t.karigar_account_id', $karigarId);
		if ($start) $criteria->addCondition("t.voucher_date >= '".date('Y-m-d', strtotime($start))."'");
		if ($end) $criteria->addCondition("t.voucher_date <= '".date('Y-m-d', strtotime($end))."'");
		$criteria->order = 't.voucher_date asc, t.id asc';
		$vouchers = KarigarVoucher::model()->findAll($criteria);

		$fileName = 'KarigarLedger_'.$account->name.'.pdf';
		PdfHelper::render(
			'karigarVoucher/ledger_pdf',
			array('account'=>$account,'vouchers'=>$vouchers,'start'=>$start,'end'=>$end),
			$fileName,
			'I',
			'A4',
			array(8,8,8,8,0,0),
			'P',
			'gothic'
		);
	}

	protected function saveLinesAndComponents($voucherId)
	{
		$lines = isset($_POST['lines']) && is_array($_POST['lines']) ? $_POST['lines'] : array();
		$components = isset($_POST['components']) && is_array($_POST['components']) ? $_POST['components'] : array();

		$sort = 1;
		foreach ($lines as $idx => $row) {
			$itemName = isset($row['item_name']) ? trim($row['item_name']) : '';
			if ($itemName === '') continue;

			$line = new KarigarVoucherLine;
			$line->karigar_voucher_id = (int)$voucherId;
			$line->order_no = isset($row['order_no']) ? $row['order_no'] : null;
			$line->customer_account_id = isset($row['customer_account_id']) && $row['customer_account_id'] !== '' ? (int)$row['customer_account_id'] : null;
			$line->item_name = $itemName;
			$line->psc = isset($row['psc']) && $row['psc'] !== '' ? (int)$row['psc'] : null;
			$line->gross_wt = isset($row['gross_wt']) ? $row['gross_wt'] : null;
			$line->net_wt = isset($row['net_wt']) ? $row['net_wt'] : null;
			$line->touch_pct = isset($row['touch_pct']) ? $row['touch_pct'] : null;
			$line->remark = isset($row['remark']) ? $row['remark'] : null;
			$line->sort_order = $sort++;

			if (!$line->save()) {
				throw new CException('Failed to save line: ' . CHtml::errorSummary($line));
			}

			$compRows = isset($components[$idx]) && is_array($components[$idx]) ? $components[$idx] : array();
			$cSort = 1;
			foreach ($compRows as $cRow) {
				$hasAny = false;
				foreach (array('component_type','name','wt','amount') as $k) {
					if (isset($cRow[$k]) && trim((string)$cRow[$k]) !== '') { $hasAny = true; break; }
				}
				if (!$hasAny) continue;

				$c = new KarigarVoucherComponent;
				$c->karigar_voucher_line_id = (int)$line->id;
				$c->component_type = isset($cRow['component_type']) ? $cRow['component_type'] : null;
				$c->name = isset($cRow['name']) ? $cRow['name'] : null;
				$c->wt = isset($cRow['wt']) ? $cRow['wt'] : null;
				$c->amount = isset($cRow['amount']) ? $cRow['amount'] : null;
				$c->sort_order = $cSort++;
				if (!$c->save()) {
					throw new CException('Failed to save component: ' . CHtml::errorSummary($c));
				}
			}
		}
	}

	protected function deleteLinesAndComponents($voucherId)
	{
		$lineIds = Yii::app()->db->createCommand('SELECT id FROM cp_karigar_voucher_line WHERE karigar_voucher_id = :id')
			->queryColumn(array(':id' => (int)$voucherId));
		if (!empty($lineIds)) {
			$criteria = new CDbCriteria;
			$criteria->addInCondition('karigar_voucher_line_id', array_map('intval', $lineIds));
			KarigarVoucherComponent::model()->deleteAll($criteria);
		}
		KarigarVoucherLine::model()->deleteAll('karigar_voucher_id=:id', array(':id' => (int)$voucherId));
	}

	protected function loadModel($id)
	{
		$model = KarigarVoucher::model()->findByPk($id);
		if ($model === null || (int)$model->is_deleted === 1) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}
		return $model;
}
}

