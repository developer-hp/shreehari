<?php

/**
 * Ledger Report: Opening Balance + Issue Entry, with PDF download.
 */
class LedgerReportController extends Controller
{
    public $layout = '//layouts/main';

    public function filters()
    {
        return array('accessControl');
    }

    public function accessRules()
    {
        return array(
            array('allow', 'actions' => array('index', 'report', 'pdf', 'updateOpeningFromClosing'), 'users' => array('@')),
            array('deny', 'users' => array('*')),
        );
    }

    /**
     * Form: customer (optional), date from, date to for issue entries.
     */
    public function actionIndex()
    {
        $this->render('index');
    }

    /**
     * Report view (HTML). GET: customer_id (optional), from_date, to_date (d-m-Y).
     */
    public function actionReport()
    {
        $data = $this->buildReportData();
        $data['show_download_link'] = true;
        $this->render('report', $data);
    }

    /**
     * Update opening balance from current closing for a customer, then redirect to report.
     * GET: customer_id (required).
     */
    public function actionUpdateOpeningFromClosing()
    {
        $customerId = isset($_GET['customer_id']) ? (int) $_GET['customer_id'] : 0;
        if ($customerId <= 0) {
            Yii::app()->user->setFlash('error', 'Please select a customer.');
            $this->redirect(array('ledgerReport/index'));
            return;
        }
        $model = OpeningBalanceService::updateOpeningFromClosing($customerId);
        if ($model !== null) {
            Yii::app()->user->setFlash('success', 'Opening balance has been updated from closing.');
        } else {
            Yii::app()->user->setFlash('error', 'Failed to update opening balance from closing.');
        }
        $this->redirect(array(
            'ledgerReport/report',
            'customer_id' => $customerId,
            'from_date' => isset($_GET['from_date']) ? $_GET['from_date'] : '',
            'to_date' => isset($_GET['to_date']) ? $_GET['to_date'] : '',
        ));
    }

    /**
     * PDF download. Same params as report.
     */
    public function actionPdf()
    {
        $data = $this->buildReportData();
        $filename = 'Ledger-Report-' . date('Y-m-d-His') . '.pdf';
        PdfHelper::render('reportPdf', $data, $filename, 'D', 'A4', [10, 10, 15, 10, 0, 0], 'P', 'gothic', false, '', false);
    }

    /**
     * Build ledger data: opening balance + issue entries per customer.
     * @return array ['customers' => [...], 'from_date' => ..., 'to_date' => ..., 'filter_customer_id' => ...]
     */
    protected function buildReportData()
    {
        $customerId = isset($_GET['customer_id']) ? (int) $_GET['customer_id'] : null;
        $fromDate = isset($_GET['from_date']) ? trim($_GET['from_date']) : null;
        $toDate = isset($_GET['to_date']) ? trim($_GET['to_date']) : null;

        $openingCondition = 't.is_deleted = 0';
        $issueCondition = 't.is_deleted = 0';
        $openingParams = array();
        $issueParams = array();

        if ($customerId > 0) {
            $openingCondition .= ' AND t.customer_id = :cid';
            $issueCondition .= ' AND t.customer_id = :cid';
            $openingParams[':cid'] = $customerId;
            $issueParams[':cid'] = $customerId;
        }

        $openings = AccountOpeningBalance::model()->with('customer')->findAll(array(
            'condition' => $openingCondition,
            'params' => $openingParams,
            'order' => 'customer.name',
        ));

        if ($fromDate) {
            $ts = strtotime($fromDate);
            if ($ts !== false) {
                $issueCondition .= ' AND t.issue_date >= :from';
                $issueParams[':from'] = date('Y-m-d', $ts);
            }
        }
        if ($toDate) {
            $ts = strtotime($toDate);
            if ($ts !== false) {
                $issueCondition .= ' AND t.issue_date <= :to';
                $issueParams[':to'] = date('Y-m-d', $ts);
            }
        }

        $issues = IssueEntry::model()->with('customer')->findAll(array(
            'condition' => $issueCondition,
            'params' => $issueParams,
            'order' => 't.issue_date ASC, t.id ASC',
        ));

        $issueIds = array_map(function ($i) { return (int) $i->id; }, $issues);
        $supplierLedgerByIssueId = array();
        $karigarJamaByIssueId = array();
        if (!empty($issueIds)) {
            $placeholders = implode(',', $issueIds);
            $slTxns = SupplierLedgerTxn::model()->findAll(array('condition' => 'issue_entry_id IN (' . $placeholders . ') AND (is_deleted = 0 OR is_deleted IS NULL)'));
            foreach ($slTxns as $t) { $supplierLedgerByIssueId[(int)$t->issue_entry_id] = $t; }
            $kjVouchers = KarigarJamaVoucher::model()->findAll(array('condition' => 'issue_entry_id IN (' . $placeholders . ') AND (is_deleted = 0 OR is_deleted IS NULL)'));
            foreach ($kjVouchers as $v) { $karigarJamaByIssueId[(int)$v->issue_entry_id] = $v; }
        }

        $customerIds = array();
        foreach ($openings as $o) $customerIds[$o->customer_id] = true;
        foreach ($issues as $i) $customerIds[$i->customer_id] = true;
        $customerIds = array_keys($customerIds);
        if (empty($customerIds)) {
            return array(
                'customers' => array(),
                'from_date' => $fromDate,
                'to_date' => $toDate,
                'filter_customer_id' => $customerId,
            );
        }

        $customers = Customer::model()->findAllByPk($customerIds);
        $openingsByCustomer = array();
        foreach ($openings as $o) $openingsByCustomer[$o->customer_id] = $o;
        $issuesByCustomer = array();
        foreach ($issues as $i) {
            if (!isset($issuesByCustomer[$i->customer_id])) $issuesByCustomer[$i->customer_id] = array();
            $issuesByCustomer[$i->customer_id][] = $i;
        }

        $reportCustomers = array();
        foreach ($customers as $c) {
            $reportCustomers[] = array(
                'customer' => $c,
                'opening' => isset($openingsByCustomer[$c->id]) ? $openingsByCustomer[$c->id] : null,
                'issues' => isset($issuesByCustomer[$c->id]) ? $issuesByCustomer[$c->id] : array(),
            );
        }
        usort($reportCustomers, function ($a, $b) {
            return strcasecmp($a['customer']->name, $b['customer']->name);
        });

        return array(
            'customers' => $reportCustomers,
            'from_date' => $fromDate,
            'to_date' => $toDate,
            'filter_customer_id' => $customerId,
            'supplier_ledger_by_issue_id' => $supplierLedgerByIssueId,
            'karigar_jama_by_issue_id' => $karigarJamaByIssueId,
        );
    }
}
