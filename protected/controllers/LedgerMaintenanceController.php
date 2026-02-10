<?php

class LedgerMaintenanceController extends Controller
{
	public $layout='//layouts/main';

	public function filters()
	{
		return array(
			'accessControl',
			'postOnly + bulkDelete',
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',
				'actions' => array('index'),
				'users' => array('@'),
			),
			array('allow',
				'actions' => array('bulkDelete'),
				'users' => array('@'),
			),
			array('deny', 'users' => array('*')),
		);
	}

	public function actionIndex()
	{
		$this->render('index');
	}

	/**
	 * Main user only: bulk soft-delete by date range for SUP/KAR/ISS.
	 * POST: doc_type (SUP/KAR/ISS), start, end, account_id (optional)
	 */
	public function actionBulkDelete()
	{
		if (!LedgerAccess::isMainUser()) {
			throw new CHttpException(403, 'Only main user can bulk delete.');
		}

		$docType = strtoupper(trim((string)$_POST['doc_type']));
		$start = trim((string)$_POST['start']);
		$end = trim((string)$_POST['end']);
		$accountId = isset($_POST['account_id']) ? (int)$_POST['account_id'] : 0;

		if (!$docType || !$start || !$end) {
			throw new CHttpException(400, 'doc_type, start, end are required.');
		}
		$start = date('Y-m-d', strtotime($start));
		$end = date('Y-m-d', strtotime($end));

		$table = '';
		$dateField = '';
		$accountField = '';
		if ($docType === 'SUP') {
			$table = 'cp_supplier_txn';
			$dateField = 'txn_date';
			$accountField = 'supplier_account_id';
		} elseif ($docType === 'KAR') {
			$table = 'cp_karigar_voucher';
			$dateField = 'voucher_date';
			$accountField = 'karigar_account_id';
		} elseif ($docType === 'ISS') {
			$table = 'cp_issue_entry';
			$dateField = 'issue_date';
			$accountField = 'account_id';
		} else {
			throw new CHttpException(400, 'Invalid doc_type.');
		}

		$sql = "UPDATE $table SET is_deleted = 1 WHERE is_deleted = 0 AND $dateField >= :s AND $dateField <= :e";
		$params = array(':s' => $start, ':e' => $end);
		if ($accountId > 0) {
			$sql .= " AND $accountField = :aid";
			$params[':aid'] = $accountId;
		}

		$affected = Yii::app()->db->createCommand($sql)->execute($params);
		Yii::app()->user->setFlash('success', "Bulk deleted $affected record(s).");
		$this->redirect(array('index'));
	}
}

