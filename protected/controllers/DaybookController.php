<?php

/**
 * Day Book: one-page daily inventory (Jama/Baki split) from Issue Entry.
 */
class DaybookController extends Controller
{
    public $layout = '//layouts/main';

    public function filters()
    {
        return array('accessControl');
    }

    public function accessRules()
    {
        return array(
            array('allow', 'actions' => array('index', 'print'), 'users' => array('@')),
            array('deny', 'users' => array('*')),
        );
    }

    public function actionIndex()
    {
        $data = $this->buildDaybookData();
        $this->render('index', $data);
    }

    public function actionPrint()
    {
        $data = $this->buildDaybookData();
        $this->renderPartial('print', $data, false, true);
    }

    protected function buildDaybookData()
    {
        $selectedDate = date('Y-m-d');
        if (isset($_GET['date']) && trim($_GET['date']) !== '') {
            $ts = strtotime(trim($_GET['date']));
            if ($ts !== false) {
                $selectedDate = date('Y-m-d', $ts);
            }
        }

        $entries = IssueEntry::model()->with('customer')->findAll(array(
            'condition' => 't.is_deleted = 0 AND t.issue_date = :d',
            'params' => array(':d' => $selectedDate),
            'order' => 't.id ASC',
        ));

        $issueIds = array();
        foreach ($entries as $entry) {
            $issueIds[] = (int) $entry->id;
        }

        $supplierLedgerByIssueId = array();
        $karigarJamaByIssueId = array();
        $diamondVoucherByIssueId = array();
        if (!empty($issueIds)) {
            $placeholders = implode(',', $issueIds);
            $supplierRows = SupplierLedgerTxn::model()->findAll(array(
                'condition' => 'issue_entry_id IN (' . $placeholders . ') AND (is_deleted = 0 OR is_deleted IS NULL)',
            ));
            foreach ($supplierRows as $row) {
                $supplierLedgerByIssueId[(int) $row->issue_entry_id] = $row;
            }

            $karigarRows = KarigarJamaVoucher::model()->findAll(array(
                'condition' => 'issue_entry_id IN (' . $placeholders . ') AND (is_deleted = 0 OR is_deleted IS NULL)',
            ));
            foreach ($karigarRows as $row) {
                $karigarJamaByIssueId[(int) $row->issue_entry_id] = $row;
            }

            $diamondRows = DiamondVoucher::model()->findAll(array(
                'condition' => 'issue_entry_id IN (' . $placeholders . ') AND (is_deleted = 0 OR is_deleted IS NULL)',
            ));
            foreach ($diamondRows as $row) {
                $diamondVoucherByIssueId[(int) $row->issue_entry_id] = $row;
            }
        }

        $jamaRows = array();
        $bakiRows = array();

        $totals = array(
            'jama_metal' => 0.0,
            'jama_amount' => 0.0,
            'baki_metal' => 0.0,
            'baki_amount' => 0.0,
        );

        foreach ($entries as $e) {
            $fineWt = (float) $e->fine_wt;
            $amount = (float) $e->amount;
            $sourceLabel = 'Issue Entry';
            if (isset($supplierLedgerByIssueId[(int) $e->id])) {
                $sourceLabel = 'Supplier Voucher';
            } elseif (isset($karigarJamaByIssueId[(int) $e->id])) {
                $sourceLabel = 'Karigar Voucher';
            } elseif (isset($diamondVoucherByIssueId[(int) $e->id])) {
                $sourceLabel = 'Diamond Voucher';
            }
            $row = array(
                'name' => isset($e->customer) ? (string) $e->customer->name : '',
                'source' => $sourceLabel,
                'voucher_no' => trim((string) $e->sr_no),
                'metal' => $fineWt,
                'amount' => $amount,
            );
            if ((int) $e->drcr === IssueEntry::DRCR_DEBIT) {
                $jamaRows[] = $row;
                $totals['jama_metal'] += $fineWt;
                $totals['jama_amount'] += $amount;
            } else {
                $bakiRows[] = $row;
                $totals['baki_metal'] += $fineWt;
                $totals['baki_amount'] += $amount;
            }
        }

        $rowCount = max(count($jamaRows), count($bakiRows), 1);
        $rows = array();
        for ($i = 0; $i < $rowCount; $i++) {
            $rows[] = array(
                'jama' => isset($jamaRows[$i]) ? $jamaRows[$i] : null,
                'baki' => isset($bakiRows[$i]) ? $bakiRows[$i] : null,
            );
        }

        $amountWords = array(
            'jama' => Words::amountWordsForVoucher($totals['jama_amount']),
            'baki' => Words::amountWordsForVoucher($totals['baki_amount']),
        );

        return array(
            'rows' => $rows,
            'selectedDate' => $selectedDate,
            'selectedDateDisplay' => date('d.m.Y', strtotime($selectedDate)),
            'totals' => $totals,
            'amountWords' => $amountWords,
        );
    }
}
