<div class="content-header">
    <div class="row">
        <div class="col-sm-6">
            <div class="header-section">
                <h1>Ledger Report</h1>
            </div>
        </div>
        <div class="col-sm-6 hidden-xs">
            <ul class="breadcrumb breadcrumb-top">
                <li><?php echo CHtml::link('Dashboard', array('site/index')); ?></li>
                <li><?php echo CHtml::link('Ledger Report', array('ledgerReport/index')); ?></li>
                <li>Report</li>
            </ul>
        </div>
    </div>
</div>

<?php
$ledgerTotals = isset($ledger_totals) ? $ledger_totals : array('total_closing_fine' => 0, 'total_closing_amount' => 0, 'ledger_count' => 0);
$fineBalanceBg = ($ledgerTotals['total_closing_fine'] >= 0) ? 'background-color: #5cb85c;' : 'background-color: #d9534f;';
$amountBalanceBg = ($ledgerTotals['total_closing_amount'] >= 0) ? 'background-color: #5cb85c;' : 'background-color: #d9534f;';

if (!function_exists('ledgerReportBalanceLabel')) {
    function ledgerReportBalanceLabel($value)
    {
        return ((float) $value) < 0 ? 'Baki' : 'Jama';
    }
}

if (!function_exists('ledgerReportFormatBalance')) {
    function ledgerReportFormatBalance($value, $precision = 2)
    {
        return number_format(abs((float) $value), (int) $precision) . ' ' . ledgerReportBalanceLabel($value);
    }
}

if (!function_exists('ledgerReportNumberToWords')) {
    function ledgerReportNumberToWords($number, $precision = 2)
    {
        $number = (float) $number;
        $precision = (int) $precision;
        if ($precision < 0) {
            $precision = 0;
        }
        if ($number == 0) {
            return 'Zero';
        }

        $integerPart = (int) floor(abs($number));
        $factor = pow(10, $precision);
        $decimalPart = (int) round((abs($number) - $integerPart) * $factor);
        if ($decimalPart >= $factor) {
            $integerPart += 1;
            $decimalPart = 0;
        }
        $words = array(
            0 => '', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four', 5 => 'Five',
            6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine', 10 => 'Ten',
            11 => 'Eleven', 12 => 'Twelve', 13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
            16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen', 19 => 'Nineteen',
            20 => 'Twenty', 30 => 'Thirty', 40 => 'Forty', 50 => 'Fifty',
            60 => 'Sixty', 70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety'
        );
        $digitWords = array('Zero', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine');

        $belowThousand = function ($num) use (&$words) {
            $text = '';
            if ($num >= 100) {
                $text .= $words[(int) floor($num / 100)] . ' Hundred ';
                $num = $num % 100;
            }
            if ($num > 0) {
                if ($num < 21) {
                    $text .= $words[$num] . ' ';
                } else {
                    $text .= $words[(int) (floor($num / 10) * 10)] . ' ';
                    if (($num % 10) > 0) {
                        $text .= $words[$num % 10] . ' ';
                    }
                }
            }
            return trim($text);
        };

        $parts = array(10000000 => 'Crore', 100000 => 'Lakh', 1000 => 'Thousand');
        $text = '';
        foreach ($parts as $value => $label) {
            if ($integerPart >= $value) {
                $chunk = (int) floor($integerPart / $value);
                $integerPart = $integerPart % $value;
                $text .= $belowThousand($chunk) . ' ' . $label . ' ';
            }
        }
        if ($integerPart > 0) {
            $text .= $belowThousand($integerPart) . ' ';
        }
        $text = trim(preg_replace('/\s+/', ' ', $text));
        if ($precision > 0 && $decimalPart > 0) {
            $decimalText = str_pad((string) $decimalPart, $precision, '0', STR_PAD_LEFT);
            $decimalWords = array();
            foreach (str_split($decimalText) as $digit) {
                $decimalWords[] = $digitWords[(int) $digit];
            }
            $text .= ' Point ' . implode(' ', $decimalWords);
        }
        return trim($text);
    }
}

if (!function_exists('ledgerReportBalanceWords')) {
    function ledgerReportBalanceWords($value, $precision = 2)
    {
        return ledgerReportNumberToWords(abs((float) $value), (int) $precision) . ' ' . ledgerReportBalanceLabel($value);
    }
}
?>
<?php if (!empty($customers) && !empty($ledgerTotals)): ?>
<!-- Ledger totals widget block -->
<div class="row" style="margin-bottom: 20px;">
    <div class="col-sm-6 col-lg-4">
        <div class="widget" style="<?php echo $fineBalanceBg; ?>">
            <div class="widget-content widget-content-mini text-right clearfix" style="color: #fff;">
                <div class="widget-icon pull-left" style="background-color: rgba(255,255,255,0.2);">
                    <i class="fa fa-balance-scale" style="color: #fff;"></i>
                </div>
                <h2 class="widget-heading h3" style="color: #fff;">
                    <strong><?php echo ledgerReportFormatBalance($ledgerTotals['total_closing_fine'], 3); ?></strong>
                </h2>
                <span style="color: rgba(255,255,255,0.9);">Total Fine Balance (all ledgers)</span>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-4">
        <div class="widget" style="<?php echo $amountBalanceBg; ?>">
            <div class="widget-content widget-content-mini text-right clearfix" style="color: #fff;">
                <div class="widget-icon pull-left" style="background-color: rgba(255,255,255,0.2);">
                    <i class="fa fa-money" style="color: #fff;"></i>
                </div>
                <h2 class="widget-heading h3" style="color: #fff;">
                    <strong><?php echo ledgerReportFormatBalance($ledgerTotals['total_closing_amount'], 2); ?></strong>
                </h2>
                <span style="color: rgba(255,255,255,0.9);">Total Amount Balance (all ledgers)</span>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-4">
        <div class="widget">
            <div class="widget-content widget-content-mini text-right clearfix">
                <div class="widget-icon pull-left themed-background">
                    <i class="fa fa-book text-light-op"></i>
                </div>
                <h2 class="widget-heading h3 text">
                    <strong><?php echo (int) $ledgerTotals['ledger_count']; ?></strong>
                </h2>
                <span class="text-muted">No. of Ledgers</span>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <div class="block-title">
                <h2>Ledger Report (Opening Balance + Issue Entry)</h2>
            </div>
            <p>
                <?php echo CHtml::link('<i class="fa fa-file-pdf-o"></i> Download PDF', array('ledgerReport/pdf', 'customer_id' => $filter_customer_id, 'customer_type' => isset($filter_customer_type) ? $filter_customer_type : '', 'entry_type' => isset($filter_entry_type) ? $filter_entry_type : '', 'from_date' => $from_date, 'to_date' => $to_date), array('class' => 'btn btn-primary', 'target' => '_blank')); ?>
                <?php if (!empty($filter_customer_id) && count($customers) === 1): ?>
                <?php echo CHtml::link('<i class="fa fa-refresh"></i> Update opening from closing', array('ledgerReport/updateOpeningFromClosing', 'customer_id' => $filter_customer_id, 'customer_type' => isset($filter_customer_type) ? $filter_customer_type : '', 'entry_type' => isset($filter_entry_type) ? $filter_entry_type : '', 'from_date' => $from_date, 'to_date' => $to_date), array('class' => 'btn btn-info', 'confirm' => 'Set opening balance to current closing and delete all issue entries for this customer? This cannot be undone.')); ?>
                <?php endif; ?>
            </p>
            <?php
            $typeLabels = array(1 => 'Supplier', 2 => 'Customer', 3 => 'Karigar');
            $entryTypeLabels = array('issue' => 'Issue Entry', 'supplier' => 'Supplier Voucher', 'karigar' => 'Karigar Voucher');
            $filterParts = array();
            if (!empty($filter_customer_type) && isset($typeLabels[$filter_customer_type])) $filterParts[] = 'Type: ' . $typeLabels[$filter_customer_type];
            if (!empty($filter_entry_type) && isset($entryTypeLabels[$filter_entry_type])) $filterParts[] = 'Voucher Type: ' . $entryTypeLabels[$filter_entry_type];
            if (!empty($from_date) || !empty($to_date)) $filterParts[] = 'Issue entries from: <strong>' . ($from_date ? CHtml::encode($from_date) : '—') . '</strong> to <strong>' . ($to_date ? CHtml::encode($to_date) : '—') . '</strong>';
            if (!empty($filterParts)): ?>
            <p class="text-muted"><?php echo implode(' &nbsp;|&nbsp; ', $filterParts); ?></p>
            <?php endif; ?>

<?php if (empty($customers)): ?>
    <p>No data found for the selected filters.</p>
<?php else: ?>
    <?php foreach ($customers as $row): ?>
        <?php
        $customer = $row['customer'];
        $opening = $row['opening'];
        $issues = $row['issues'];
        ?>
        <h4 style="margin-top:18px; margin-bottom:8px;"><?php echo CHtml::encode($customer->name); ?> (<?php echo CHtml::encode($customer->mobile); ?>)</h4>
        <table class="table table-striped table-bordered table-vcenter">
            <?php 
            $drcrOptions = IssueEntry::getDrcrOptions();
            $drLabel = $drcrOptions[IssueEntry::DRCR_DEBIT];
            $crLabel = $drcrOptions[IssueEntry::DRCR_CREDIT];
            ?>
            <thead>
                <tr>
                    <th width="10%">Date</th>
                    <th width="13%">Particulars</th>
                    <th width="10%" class="text-right">Fine Wt (<?php echo $drLabel; ?>)</th>
                    <th width="10%" class="text-right">Fine Wt (<?php echo $crLabel; ?>)</th>
                    <th width="12%" class="text-right">Amount (<?php echo $drLabel; ?>)</th>
                    <th width="12%" class="text-right">Amount (<?php echo $crLabel; ?>)</th>
                    <th width="11%" class="text-right">Fine Balance</th>
                    <th width="12%" class="text-right">Amount Balance</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $totalFineDr = $totalFineCr = $totalAmtDr = $totalAmtCr = 0;
                $runningFineBalance = 0;
                $runningAmountBalance = 0;
                if ($opening):
                    $fw = (float)$opening->opening_fine_wt;
                    $am = (float)$opening->opening_amount;
                    if ($opening->opening_fine_wt_drcr == 1) { $totalFineDr += $fw; $runningFineBalance += $fw; } else { $totalFineCr += $fw; $runningFineBalance -= $fw; }
                    if ($opening->opening_amount_drcr == 1) { $totalAmtDr += $am; $runningAmountBalance += $am; } else { $totalAmtCr += $am; $runningAmountBalance -= $am; }
                ?>
                <tr>
                    <td>—</td>
                    <td>Opening Balance</td>
                    <td class="text-right"><?php echo $opening->opening_fine_wt_drcr == 1 ? number_format($fw, 3) : '—'; ?></td>
                    <td class="text-right"><?php echo $opening->opening_fine_wt_drcr == 2 ? number_format($fw, 3) : '—'; ?></td>
                    <td class="text-right"><?php echo $opening->opening_amount_drcr == 1 ? number_format($am, 2) : '—'; ?></td>
                    <td class="text-right"><?php echo $opening->opening_amount_drcr == 2 ? number_format($am, 2) : '—'; ?></td>
                    <td class="text-right"><strong><?php echo ledgerReportFormatBalance($runningFineBalance, 3); ?></strong></td>
                    <td class="text-right"><strong><?php echo ledgerReportFormatBalance($runningAmountBalance, 2); ?></strong></td>
                </tr>
                <?php endif; ?>
                <?php foreach ($issues as $iss):
                    $fw = (float)$iss->fine_wt;
                    $am = (float)$iss->amount;
                    if ($iss->drcr == 1) { 
                        $totalFineDr += $fw; 
                        $totalAmtDr += $am;
                        $runningFineBalance += $fw;
                        $runningAmountBalance += $am;
                    } else { 
                        $totalFineCr += $fw; 
                        $totalAmtCr += $am;
                        $runningFineBalance -= $fw;
                        $runningAmountBalance -= $am;
                    }
                    $dateStr = !empty($iss->issue_date) ? date('d-m-Y', strtotime($iss->issue_date)) : '—';
                    $particularsText = $iss->sr_no . ' - ' . (string)$iss->remarks;
                    $sl = isset($supplier_ledger_by_issue_id[$iss->id]) ? $supplier_ledger_by_issue_id[$iss->id] : null;
                    $kj = isset($karigar_jama_by_issue_id[$iss->id]) ? $karigar_jama_by_issue_id[$iss->id] : null;
                    if ($sl) {
                        $particularsCell = CHtml::link(CHtml::encode($particularsText), array('supplierLedger/view', 'id' => $sl->id));
                    } elseif ($kj) {
                        $particularsCell = CHtml::link(CHtml::encode($particularsText), array('karigarJama/view', 'id' => $kj->id));
                    } else {
                        $particularsCell = CHtml::encode($particularsText);
                    }
                ?>
                <tr>
                    <td><?php echo $dateStr; ?></td>
                    <td><?php echo $particularsCell; ?></td>
                    <td class="text-right"><?php echo $iss->drcr == 1 ? number_format($fw, 3) : '—'; ?></td>
                    <td class="text-right"><?php echo $iss->drcr == 2 ? number_format($fw, 3) : '—'; ?></td>
                    <td class="text-right"><?php echo $iss->drcr == 1 ? number_format($am, 2) : '—'; ?></td>
                    <td class="text-right"><?php echo $iss->drcr == 2 ? number_format($am, 2) : '—'; ?></td>
                    <td class="text-right"><strong><?php echo ledgerReportFormatBalance($runningFineBalance, 3); ?></strong></td>
                    <td class="text-right"><strong><?php echo ledgerReportFormatBalance($runningAmountBalance, 2); ?></strong></td>
                </tr>
                <?php endforeach;
                $netFine = $totalFineDr - $totalFineCr;
                $netAmt = $totalAmtDr - $totalAmtCr;
                $closingFineDr = $netFine >= 0 ? $netFine : 0;
                $closingFineCr = $netFine < 0 ? -$netFine : 0;
                $closingAmtDr = $netAmt >= 0 ? $netAmt : 0;
                $closingAmtCr = $netAmt < 0 ? -$netAmt : 0;
                ?>
                <tr class="active">
                    <td colspan="2" class="text-right"><strong>Closing</strong></td>
                    <td class="text-right"><?php echo $closingFineDr > 0 ? number_format($closingFineDr, 3) : '—'; ?></td>
                    <td class="text-right"><?php echo $closingFineCr > 0 ? number_format($closingFineCr, 3) : '—'; ?></td>
                    <td class="text-right"><?php echo $closingAmtDr > 0 ? number_format($closingAmtDr, 2) : '—'; ?></td>
                    <td class="text-right"><?php echo $closingAmtCr > 0 ? number_format($closingAmtCr, 2) : '—'; ?></td>
                    <td class="text-right"><strong><?php echo ledgerReportFormatBalance($runningFineBalance, 3); ?></strong></td>
                    <td class="text-right"><strong><?php echo ledgerReportFormatBalance($runningAmountBalance, 2); ?></strong></td>
                </tr>
            </tbody>
        </table>
        <p class="text-muted" style="margin-top:-6px; margin-bottom:16px;">
            <strong>Fine Wt in words:</strong> <?php echo CHtml::encode(ledgerReportBalanceWords($runningFineBalance, 3)); ?> &nbsp;|&nbsp;
            <strong>Amount in words:</strong> <?php echo CHtml::encode(ledgerReportBalanceWords($runningAmountBalance, 2)); ?>
        </p>
    <?php endforeach; ?>
<?php endif; ?>

        </div>
    </div>
</div>
