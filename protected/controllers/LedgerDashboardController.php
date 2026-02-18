<?php

/**
 * Separate dashboard for Issue Entry, Supplier Voucher, and Karigar Voucher.
 */
class LedgerDashboardController extends Controller
{
	public $layout = '//layouts/main';

	public function filters()
	{
		return array('accessControl');
	}

	public function accessRules()
	{
		return array(
			array('allow', 'actions' => array('index'), 'users' => array('@')),
			array('deny', 'users' => array('*')),
		);
	}

	/**
	 * Ledger dashboard: stats + recent entries. Use ?date=Y-m-d or date=d-m-Y to filter by date.
	 */
	public function actionIndex()
	{
		$today = date('Y-m-d');
		$filterDate = $today;
		if (isset($_GET['date']) && trim($_GET['date']) !== '') {
			$input = trim($_GET['date']);
			$ts = strtotime($input);
			if ($ts !== false) {
				$filterDate = date('Y-m-d', $ts);
			}
		}

		// --- Issue Entry: selected date's count & total amount ---
		$issueEntryToday = IssueEntry::model()->findAll(
			't.is_deleted = 0 and is_voucher=0 AND t.issue_date = :d',
			array(':d' => $filterDate)
		);
		$issueEntryCount = count($issueEntryToday);
		$issueEntryTotalAmount = 0;
		$issueEntryTotalFineWt = 0;
		foreach ($issueEntryToday as $e) {
			$issueEntryTotalAmount += (float) $e->amount;
			$issueEntryTotalFineWt += (float) $e->fine_wt;
		}

		// --- Supplier Voucher: selected date's count & total amount & fine wt ---
		$supplierLedgerToday = SupplierLedgerTxn::model()->findAll(
			't.is_deleted = 0 AND t.txn_date = :d',
			array(':d' => $filterDate)
		);
		$supplierLedgerCount = count($supplierLedgerToday);
		$supplierLedgerTotalAmount = 0;
		$supplierLedgerTotalFineWt = 0;
		foreach ($supplierLedgerToday as $t) {
			$supplierLedgerTotalAmount += (float) $t->total_amount;
			$supplierLedgerTotalFineWt += (float) $t->total_fine_wt;
		}

		// --- Karigar Jama: selected date's count & total amount & fine wt ---
		$karigarJamaToday = KarigarJamaVoucher::model()->findAll(
			't.is_deleted = 0 AND t.voucher_date = :d',
			array(':d' => $filterDate)
		);
		$karigarJamaCount = count($karigarJamaToday);
		$karigarJamaTotalAmount = 0;
		$karigarJamaTotalFineWt = 0;
		foreach ($karigarJamaToday as $v) {
			$karigarJamaTotalAmount += (float) $v->total_amount;
			$karigarJamaTotalFineWt += (float) $v->total_fine_wt;
		}

		// --- Recent 10 records (with relations for names) ---
		$recentIssueEntries = IssueEntry::model()->with('customer')->findAll(array(
			'condition' => 't.is_deleted = 0 and is_voucher=0',
			'order' => 't.id DESC',
			'limit' => 10,
		));

		$recentSupplierLedger = SupplierLedgerTxn::model()->with('supplier')->findAll(array(
			'condition' => 't.is_deleted = 0',
			'order' => 't.id DESC',
			'limit' => 10,
		));

		$recentKarigarJama = KarigarJamaVoucher::model()->with('karigar')->findAll(array(
			'condition' => 't.is_deleted = 0',
			'order' => 't.id DESC',
			'limit' => 10,
		));

		// --- Chart: last 7 days daily totals (amount + fine wt) ---
		$chartDays = 7;
		$chartLabels = array();
		$chartIssueEntry = array();
		$chartSupplierLedger = array();
		$chartKarigarJama = array();
		$chartIssueEntryFineWt = array();
		$chartSupplierLedgerFineWt = array();
		$chartKarigarJamaFineWt = array();
		for ($i = $chartDays - 1; $i >= 0; $i--) {
			$d = date('Y-m-d', strtotime("-$i days"));
			$chartLabels[] = date('d M', strtotime($d));
			$dayIssue = 0;
			$dayIssueFw = 0;
			foreach (IssueEntry::model()->findAll('t.is_deleted = 0 AND t.issue_date = :d and is_voucher=0', array(':d' => $d)) as $e) {
				$dayIssue += (float) $e->amount;
				$dayIssueFw += (float) $e->fine_wt;
			}
			$chartIssueEntry[] = (float) $dayIssue;
			$chartIssueEntryFineWt[] = (float) $dayIssueFw;
			$daySup = 0;
			$daySupFw = 0;
			foreach (SupplierLedgerTxn::model()->findAll('t.is_deleted = 0 AND t.txn_date = :d', array(':d' => $d)) as $t) {
				$daySup += (float) $t->total_amount;
				$daySupFw += (float) $t->total_fine_wt;
			}
			$chartSupplierLedger[] = (float) $daySup;
			$chartSupplierLedgerFineWt[] = (float) $daySupFw;
			$dayJama = 0;
			$dayJamaFw = 0;
			foreach (KarigarJamaVoucher::model()->findAll('t.is_deleted = 0 AND t.voucher_date = :d', array(':d' => $d)) as $v) {
				$dayJama += (float) $v->total_amount;
				$dayJamaFw += (float) $v->total_fine_wt;
			}
			$chartKarigarJama[] = (float) $dayJama;
			$chartKarigarJamaFineWt[] = (float) $dayJamaFw;
		}

		// --- Chart: today's pie (Issue Entry / Supplier Voucher / Karigar Voucher amounts) ---
		$chartTodayPie = array(
			array('label' => 'Issue Entry', 'amount' => $issueEntryTotalAmount),
			array('label' => 'Supplier Voucher', 'amount' => $supplierLedgerTotalAmount),
			array('label' => 'Karigar Voucher', 'amount' => $karigarJamaTotalAmount),
		);

		// --- Ledger In / Out / Balance (from Issue Entry: CR = In, DR = Out) ---
		$db = Yii::app()->db;
		$cr = (int) IssueEntry::DRCR_CREDIT;
		$dr = (int) IssueEntry::DRCR_DEBIT;
		$totalInAmount = (float) $db->createCommand(
			'SELECT COALESCE(SUM(amount),0) FROM cp_issue_entry WHERE is_deleted = 0 AND drcr = ' . $cr
		)->queryScalar();
		$totalOutAmount = (float) $db->createCommand(
			'SELECT COALESCE(SUM(amount),0) FROM cp_issue_entry WHERE is_deleted = 0 AND drcr = ' . $dr
		)->queryScalar();
		$totalInFineWt = (float) $db->createCommand(
			'SELECT COALESCE(SUM(fine_wt),0) FROM cp_issue_entry WHERE is_deleted = 0 AND drcr = ' . $cr
		)->queryScalar();
		$totalOutFineWt = (float) $db->createCommand(
			'SELECT COALESCE(SUM(fine_wt),0) FROM cp_issue_entry WHERE is_deleted = 0 AND drcr = ' . $dr
		)->queryScalar();
		$todayInAmount = (float) $db->createCommand(
			'SELECT COALESCE(SUM(amount),0) FROM cp_issue_entry WHERE is_deleted = 0 AND drcr = :cr AND issue_date = :d'
		)->queryScalar(array(':cr' => $cr, ':d' => $filterDate));
		$todayOutAmount = (float) $db->createCommand(
			'SELECT COALESCE(SUM(amount),0) FROM cp_issue_entry WHERE is_deleted = 0 AND drcr = :dr AND issue_date = :d'
		)->queryScalar(array(':dr' => $dr, ':d' => $filterDate));
		$todayInFineWt = (float) $db->createCommand(
			'SELECT COALESCE(SUM(fine_wt),0) FROM cp_issue_entry WHERE is_deleted = 0 AND drcr = :cr AND issue_date = :d'
		)->queryScalar(array(':cr' => $cr, ':d' => $filterDate));
		$todayOutFineWt = (float) $db->createCommand(
			'SELECT COALESCE(SUM(fine_wt),0) FROM cp_issue_entry WHERE is_deleted = 0 AND drcr = :dr AND issue_date = :d'
		)->queryScalar(array(':dr' => $dr, ':d' => $filterDate));
		$ledgerBalanceAmount = $totalInAmount - $totalOutAmount;
		$ledgerBalanceFineWt = $totalInFineWt - $totalOutFineWt;
		$todayBalanceAmount = $todayInAmount - $todayOutAmount;
		$todayBalanceFineWt = $todayInFineWt - $todayOutFineWt;

		$this->render('index', array(
			'issueEntryCount' => $issueEntryCount,
			'issueEntryTotalAmount' => $issueEntryTotalAmount,
			'issueEntryTotalFineWt' => $issueEntryTotalFineWt,
			'supplierLedgerCount' => $supplierLedgerCount,
			'supplierLedgerTotalAmount' => $supplierLedgerTotalAmount,
			'supplierLedgerTotalFineWt' => $supplierLedgerTotalFineWt,
			'karigarJamaCount' => $karigarJamaCount,
			'karigarJamaTotalAmount' => $karigarJamaTotalAmount,
			'karigarJamaTotalFineWt' => $karigarJamaTotalFineWt,
			'recentIssueEntries' => $recentIssueEntries,
			'recentSupplierLedger' => $recentSupplierLedger,
			'recentKarigarJama' => $recentKarigarJama,
			'today' => $today,
			'chartLabels' => $chartLabels,
			'chartIssueEntry' => $chartIssueEntry,
			'chartSupplierLedger' => $chartSupplierLedger,
			'chartKarigarJama' => $chartKarigarJama,
			'chartIssueEntryFineWt' => $chartIssueEntryFineWt,
			'chartSupplierLedgerFineWt' => $chartSupplierLedgerFineWt,
			'chartKarigarJamaFineWt' => $chartKarigarJamaFineWt,
			'chartTodayPie' => $chartTodayPie,
			'filterDate' => $filterDate,
			'filterDateDisplay' => date('d-m-Y', strtotime($filterDate)),
			'totalInAmount' => $totalInAmount,
			'totalOutAmount' => $totalOutAmount,
			'ledgerBalanceAmount' => $ledgerBalanceAmount,
			'totalInFineWt' => $totalInFineWt,
			'totalOutFineWt' => $totalOutFineWt,
			'ledgerBalanceFineWt' => $ledgerBalanceFineWt,
			'todayInAmount' => $todayInAmount,
			'todayOutAmount' => $todayOutAmount,
			'todayBalanceAmount' => $todayBalanceAmount,
			'todayInFineWt' => $todayInFineWt,
			'todayOutFineWt' => $todayOutFineWt,
			'todayBalanceFineWt' => $todayBalanceFineWt,
		));
	}
}
