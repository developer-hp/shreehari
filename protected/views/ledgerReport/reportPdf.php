<?php
$cellStyle = 'border:1px solid #333; padding:5px 8px;';
$thStyle = 'border:1px solid #333; padding:6px 8px; background:#f0f0f0; font-weight:bold;';
$numStyle = 'text-align:right;';
?>
<div style="margin-bottom:10px;"><strong>Ledger Report (Opening Balance + Issue Entry)</strong></div>
<?php if (!empty($from_date) || !empty($to_date)): ?>
<div style="margin-bottom:8px;">Issue entries from: <?php echo $from_date ? CHtml::encode($from_date) : '—'; ?> to <?php echo $to_date ? CHtml::encode($to_date) : '—'; ?></div>
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
    <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse; margin-bottom:20px;">
        <thead>
            <tr>
                <th width="12%" style="<?php echo $thStyle; ?>">Date</th>
                <th width="15%" style="<?php echo $thStyle; ?>">Particulars</th>
                <th width="12%" style="<?php echo $thStyle . $numStyle; ?>">Fine Wt (DR)</th>
                <th width="12%" style="<?php echo $thStyle . $numStyle; ?>">Fine Wt (CR)</th>
                <th width="15%" style="<?php echo $thStyle . $numStyle; ?>">Amount (DR)</th>
                <th width="15%" style="<?php echo $thStyle . $numStyle; ?>">Amount (CR)</th>
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
                <td style="<?php echo $cellStyle; ?>">—</td>
                <td style="<?php echo $cellStyle; ?>">Opening Balance</td>
                <td style="<?php echo $cellStyle . $numStyle; ?>"><?php echo $opening->opening_fine_wt_drcr == 1 ? number_format($fw, 3) : '—'; ?></td>
                <td style="<?php echo $cellStyle . $numStyle; ?>"><?php echo $opening->opening_fine_wt_drcr == 2 ? number_format($fw, 3) : '—'; ?></td>
                <td style="<?php echo $cellStyle . $numStyle; ?>"><?php echo $opening->opening_amount_drcr == 1 ? number_format($am, 2) : '—'; ?></td>
                <td style="<?php echo $cellStyle . $numStyle; ?>"><?php echo $opening->opening_amount_drcr == 2 ? number_format($am, 2) : '—'; ?></td>
            </tr>
            <?php endif; ?>
            <?php foreach ($issues as $iss):
                $fw = (float)$iss->fine_wt;
                $am = (float)$iss->amount;
                if ($iss->drcr == 1) { $totalFineDr += $fw; $totalAmtDr += $am; } else { $totalFineCr += $fw; $totalAmtCr += $am; }
                $dateStr = !empty($iss->issue_date) ? date('d-m-Y', strtotime($iss->issue_date)) : '—';
                $particularsText = $iss->sr_no . ' - ' . (string)$iss->remarks;
            ?>
            <tr>
                <td style="<?php echo $cellStyle; ?>"><?php echo $dateStr; ?></td>
                <td style="<?php echo $cellStyle; ?>"><?php echo CHtml::encode($particularsText); ?></td>
                <td style="<?php echo $cellStyle . $numStyle; ?>"><?php echo $iss->drcr == 1 ? number_format($fw, 3) : '—'; ?></td>
                <td style="<?php echo $cellStyle . $numStyle; ?>"><?php echo $iss->drcr == 2 ? number_format($fw, 3) : '—'; ?></td>
                <td style="<?php echo $cellStyle . $numStyle; ?>"><?php echo $iss->drcr == 1 ? number_format($am, 2) : '—'; ?></td>
                <td style="<?php echo $cellStyle . $numStyle; ?>"><?php echo $iss->drcr == 2 ? number_format($am, 2) : '—'; ?></td>
            </tr>
            <?php endforeach;
            $netFine = $totalFineDr - $totalFineCr;
            $netAmt = $totalAmtDr - $totalAmtCr;
            $closingFineDr = $netFine >= 0 ? $netFine : 0;
            $closingFineCr = $netFine < 0 ? -$netFine : 0;
            $closingAmtDr = $netAmt >= 0 ? $netAmt : 0;
            $closingAmtCr = $netAmt < 0 ? -$netAmt : 0;
            ?>
            <tr style="font-weight:bold; background:#f5f5f5;">
                <td colspan="2" style="<?php echo $cellStyle . $numStyle; ?>"><strong>Closing</strong></td>
                <td style="<?php echo $cellStyle . $numStyle; ?>"><?php echo $closingFineDr > 0 ? number_format($closingFineDr, 3) : '—'; ?></td>
                <td style="<?php echo $cellStyle . $numStyle; ?>"><?php echo $closingFineCr > 0 ? number_format($closingFineCr, 3) : '—'; ?></td>
                <td style="<?php echo $cellStyle . $numStyle; ?>"><?php echo $closingAmtDr > 0 ? number_format($closingAmtDr, 2) : '—'; ?></td>
                <td style="<?php echo $cellStyle . $numStyle; ?>"><?php echo $closingAmtCr > 0 ? number_format($closingAmtCr, 2) : '—'; ?></td>
            </tr>
        </tbody>
    </table>
<?php endforeach; ?>
<?php endif; ?>
