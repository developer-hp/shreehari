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
            array('allow', 'actions' => array('index', 'report', 'pdf', 'print', 'updateOpeningFromClosing'), 'users' => array('@')),
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
     * Update opening balance from closing up to the selected date for a customer,
     * then redirect to report. GET: customer_id (required), to_date/from_date.
     */
    public function actionUpdateOpeningFromClosing()
    {
        if (!LedgerAccess::isAdmin()) {
            Yii::app()->user->setFlash('error', 'Only Admin can update opening from closing.');
            $this->redirect(array(
                'ledgerReport/report',
                'customer_id' => isset($_GET['customer_id']) ? $_GET['customer_id'] : '',
                'customer_type' => isset($_GET['customer_type']) ? $_GET['customer_type'] : '',
                'entry_type' => isset($_GET['entry_type']) ? $_GET['entry_type'] : '',
                'from_date' => isset($_GET['from_date']) ? $_GET['from_date'] : '',
                'to_date' => isset($_GET['to_date']) ? $_GET['to_date'] : '',
            ));
            return;
        }

        $customerId = isset($_GET['customer_id']) ? (int) $_GET['customer_id'] : 0;
        $cutoffDateInput = isset($_GET['to_date']) && trim($_GET['to_date']) !== ''
            ? trim($_GET['to_date'])
            : (isset($_GET['from_date']) ? trim($_GET['from_date']) : '');
        if ($customerId <= 0) {
            Yii::app()->user->setFlash('error', 'Please select a customer.');
            $this->redirect(array('ledgerReport/index'));
            return;
        }

        if ($cutoffDateInput === '') {
            Yii::app()->user->setFlash('error', 'Please select a date before updating opening from closing.');
            $this->redirect(array(
                'ledgerReport/report',
                'customer_id' => $customerId,
                'customer_type' => isset($_GET['customer_type']) ? $_GET['customer_type'] : '',
                'entry_type' => isset($_GET['entry_type']) ? $_GET['entry_type'] : '',
                'from_date' => isset($_GET['from_date']) ? $_GET['from_date'] : '',
                'to_date' => isset($_GET['to_date']) ? $_GET['to_date'] : '',
            ));
            return;
        }

        $model = OpeningBalanceService::updateOpeningFromClosing($customerId, $cutoffDateInput);
        if ($model !== null) {
            $cutoffTimestamp = strtotime($cutoffDateInput);
            $cutoffDisplay = $cutoffTimestamp !== false ? date('d-m-Y', $cutoffTimestamp) : $cutoffDateInput;
            Yii::app()->user->setFlash('success', 'Opening balance has been updated from closing up to ' . $cutoffDisplay . '.');
        } else {
            Yii::app()->user->setFlash('error', 'Failed to update opening balance from closing.');
        }
        $this->redirect(array(
            'ledgerReport/report',
            'customer_id' => $customerId,
            'customer_type' => isset($_GET['customer_type']) ? $_GET['customer_type'] : '',
            'entry_type' => isset($_GET['entry_type']) ? $_GET['entry_type'] : '',
            'from_date' => isset($_GET['from_date']) ? $_GET['from_date'] : '',
            'to_date' => isset($_GET['to_date']) ? $_GET['to_date'] : '',
        ));
    }

    /**
     * Open PDF in browser. Same params as report.
     */
    public function actionPdf()
    {
        $data = $this->buildReportData();
        $filename = 'Ledger-Report-' . date('Y-m-d-His') . '.pdf';
        PdfHelper::render('reportPdf', $data, $filename, 'I', 'A4', [10, 10, 15, 10, 0, 0], 'P', 'gothic', false, '', false);
    }

    public function actionPrint()
    {
        $data = $this->buildReportData();
        $this->renderPartial('print', $data, false, true);
    }

    /**
     * Build ledger data: opening balance + issue entries per customer.
     * @return array ['customers' => [...], 'from_date' => ..., 'to_date' => ..., 'filter_customer_id' => ..., 'filter_customer_type' => ...]
     */
    protected function buildReportData()
    {
        $customerId = isset($_GET['customer_id']) ? (int) $_GET['customer_id'] : null;
        $customerType = isset($_GET['customer_type']) ? (int) $_GET['customer_type'] : null;
        $entryType = isset($_GET['entry_type']) ? trim(strtolower($_GET['entry_type'])) : '';
        $fromDate = isset($_GET['from_date']) ? trim($_GET['from_date']) : null;
        $toDate = isset($_GET['to_date']) ? trim($_GET['to_date']) : null;
        $validEntryTypes = array('issue', 'supplier', 'karigar', 'diamond');
        if (!in_array($entryType, $validEntryTypes, true)) {
            $entryType = '';
        }

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

        if ($customerType > 0 && $customerType <= 3) {
            $openingCondition .= ' AND customer.type = :ctype';
            $issueCondition .= ' AND customer.type = :ctype';
            $openingParams[':ctype'] = $customerType;
            $issueParams[':ctype'] = $customerType;
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
        $diamondVoucherByIssueId = array();
        if (!empty($issueIds)) {
            $placeholders = implode(',', $issueIds);
            $slTxns = SupplierLedgerTxn::model()->findAll(array('condition' => 'issue_entry_id IN (' . $placeholders . ') AND (is_deleted = 0 OR is_deleted IS NULL)'));
            foreach ($slTxns as $t) { $supplierLedgerByIssueId[(int)$t->issue_entry_id] = $t; }
            $kjVouchers = KarigarJamaVoucher::model()->findAll(array('condition' => 'issue_entry_id IN (' . $placeholders . ') AND (is_deleted = 0 OR is_deleted IS NULL)'));
            foreach ($kjVouchers as $v) { $karigarJamaByIssueId[(int)$v->issue_entry_id] = $v; }
            $diamondVouchers = DiamondVoucher::model()->findAll(array('condition' => 'issue_entry_id IN (' . $placeholders . ') AND (is_deleted = 0 OR is_deleted IS NULL)'));
            foreach ($diamondVouchers as $v) { $diamondVoucherByIssueId[(int)$v->issue_entry_id] = $v; }
        }

        if ($entryType !== '') {
            $filteredIssues = array();
            foreach ($issues as $iss) {
                $issueId = (int) $iss->id;
                $hasSupplierVoucher = isset($supplierLedgerByIssueId[$issueId]);
                $hasKarigarVoucher = isset($karigarJamaByIssueId[$issueId]);
                $hasDiamondVoucher = isset($diamondVoucherByIssueId[$issueId]);

                if ($entryType === 'supplier' && $hasSupplierVoucher) {
                    $filteredIssues[] = $iss;
                } elseif ($entryType === 'karigar' && $hasKarigarVoucher) {
                    $filteredIssues[] = $iss;
                } elseif ($entryType === 'diamond' && $hasDiamondVoucher) {
                    $filteredIssues[] = $iss;
                } elseif ($entryType === 'issue' && !$hasSupplierVoucher && !$hasKarigarVoucher && !$hasDiamondVoucher) {
                    $filteredIssues[] = $iss;
                }
            }
            $issues = $filteredIssues;
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
                'filter_customer_type' => $customerType,
                'filter_entry_type' => $entryType,
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

        $ledgerTotals = $this->computeLedgerTotals($reportCustomers);

        return array(
            'customers' => $reportCustomers,
            'from_date' => $fromDate,
            'to_date' => $toDate,
            'filter_customer_id' => $customerId,
            'filter_customer_type' => $customerType,
            'filter_entry_type' => $entryType,
            'supplier_ledger_by_issue_id' => $supplierLedgerByIssueId,
            'karigar_jama_by_issue_id' => $karigarJamaByIssueId,
            'diamond_voucher_by_issue_id' => $diamondVoucherByIssueId,
            'ledger_totals' => $ledgerTotals,
        );
    }

    /**
     * Compute totals across all ledgers: sum of closing fine balance and closing amount balance.
     * @param array $reportCustomers same structure as buildReportData['customers']
     * @return array ['total_closing_fine' => float, 'total_closing_amount' => float, 'ledger_count' => int]
     */
    protected function computeLedgerTotals($reportCustomers)
    {
        $totalClosingFine = 0;
        $totalClosingAmount = 0;
        foreach ($reportCustomers as $row) {
            $opening = $row['opening'];
            $issues = $row['issues'];
            $runningFine = 0;
            $runningAmount = 0;
            if ($opening) {
                $fw = (float) $opening->opening_fine_wt;
                $am = (float) $opening->opening_amount;
                $runningFine += ($opening->opening_fine_wt_drcr == 1) ? $fw : -$fw;
                $runningAmount += ($opening->opening_amount_drcr == 1) ? $am : -$am;
            }
            foreach ($issues as $iss) {
                $fw = (float) $iss->fine_wt;
                $am = (float) $iss->amount;
                $runningFine += ($iss->drcr == 1) ? $fw : -$fw;
                $runningAmount += ($iss->drcr == 1) ? $am : -$am;
            }
            $totalClosingFine += $runningFine;
            $totalClosingAmount += $runningAmount;
        }
        return array(
            'total_closing_fine' => $totalClosingFine,
            'total_closing_amount' => $totalClosingAmount,
            'ledger_count' => count($reportCustomers),
        );
    }
}
