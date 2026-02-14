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
<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <div class="block-title">
                <h2>Ledger Report (Opening Balance + Issue Entry)</h2>
            </div>
            <p>
                <?php echo CHtml::link('<i class="fa fa-file-pdf-o"></i> Download PDF', array('ledgerReport/pdf', 'customer_id' => $filter_customer_id, 'from_date' => $from_date, 'to_date' => $to_date), array('class' => 'btn btn-primary')); ?>
                <?php if (!empty($filter_customer_id) && count($customers) === 1): ?>
                <?php echo CHtml::link('<i class="fa fa-refresh"></i> Update opening from closing', array('ledgerReport/updateOpeningFromClosing', 'customer_id' => $filter_customer_id, 'from_date' => $from_date, 'to_date' => $to_date), array('class' => 'btn btn-info', 'confirm' => 'Set opening balance to current closing and delete all issue entries for this customer? This cannot be undone.')); ?>
                <?php endif; ?>
            </p>
            <?php if (!empty($from_date) || !empty($to_date)): ?>
            <p class="text-muted">
                Issue entries from: <strong><?php echo $from_date ? CHtml::encode($from_date) : '—'; ?></strong>
                to <strong><?php echo $to_date ? CHtml::encode($to_date) : '—'; ?></strong>
            </p>
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
            <thead>
                <tr>
                    <th width="12%">Date</th>
                    <th width="15%">Particulars</th>
                    <th width="12%" class="text-right">Fine Wt (DR)</th>
                    <th width="12%" class="text-right">Fine Wt (CR)</th>
                    <th width="15%" class="text-right">Amount (DR)</th>
                    <th width="15%" class="text-right">Amount (CR)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $totalFineDr = $totalFineCr = $totalAmtDr = $totalAmtCr = 0;
                if ($opening):
                    $fw = (float)$opening->opening_fine_wt;
                    $am = (float)$opening->opening_amount;
                    if ($opening->opening_fine_wt_drcr == 1) { $totalFineDr += $fw; } else { $totalFineCr += $fw; }
                    if ($opening->opening_amount_drcr == 1) { $totalAmtDr += $am; } else { $totalAmtCr += $am; }
                ?>
                <tr>
                    <td>—</td>
                    <td>Opening Balance</td>
                    <td class="text-right"><?php echo $opening->opening_fine_wt_drcr == 1 ? number_format($fw, 3) : '—'; ?></td>
                    <td class="text-right"><?php echo $opening->opening_fine_wt_drcr == 2 ? number_format($fw, 3) : '—'; ?></td>
                    <td class="text-right"><?php echo $opening->opening_amount_drcr == 1 ? number_format($am, 2) : '—'; ?></td>
                    <td class="text-right"><?php echo $opening->opening_amount_drcr == 2 ? number_format($am, 2) : '—'; ?></td>
                </tr>
                <?php endif; ?>
                <?php foreach ($issues as $iss):
                    $fw = (float)$iss->fine_wt;
                    $am = (float)$iss->amount;
                    if ($iss->drcr == 1) { $totalFineDr += $fw; $totalAmtDr += $am; } else { $totalFineCr += $fw; $totalAmtCr += $am; }
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
                </tr>
            </tbody>
        </table>
    <?php endforeach; ?>
<?php endif; ?>

        </div>
    </div>
</div>
