<?php
$isPrint = isset($printMode) && $printMode;
$tbl = 'width:100%; border-collapse:collapse; table-layout:fixed;';
$th = 'border:1px solid #444; padding:6px 8px; font-size:18px; font-weight:700; text-align:center;';
$thSub = 'border:1px solid #444; padding:6px 8px; font-size:14px; font-weight:700; text-align:center;';
$thCol = 'border:1px solid #444; padding:6px 8px; font-size:13px; font-weight:700;';
$td = 'border:1px solid #444; padding:5px 8px; font-size:13px;';
$tdR = $td . ' text-align:right;';
$rowTotal = 'background:#f3f6fb;';
$rowNet = 'background:#fff7e0;';
if ($isPrint) {
    $th = 'border:1px solid #222; padding:5px 6px; font-size:16px; font-weight:700; text-align:center;';
    $thSub = 'border:1px solid #222; padding:5px 6px; font-size:13px; font-weight:700; text-align:center;';
    $thCol = 'border:1px solid #222; padding:5px 6px; font-size:12px; font-weight:700;';
    $td = 'border:1px solid #222; padding:4px 6px; font-size:12px;';
    $tdR = $td . ' text-align:right;';
}
?>

<div class="table-responsive daybook-table-wrap">
    <table class="daybook-table" style="<?php echo $tbl; ?>">
        <thead>
            <tr>
                <th colspan="6" style="<?php echo $th; ?>">DAYBOOK</th>
            </tr>
            <tr>
                <th colspan="3" style="<?php echo $thSub; ?>">JAMA</th>
                <th colspan="3" style="<?php echo $thSub; ?>">BAKI</th>
            </tr>
            <tr>
                <th style="<?php echo $thCol; ?>">Name</th>
                <th style="<?php echo $thCol; ?> text-align:right;">Metal</th>
                <th style="<?php echo $thCol; ?> text-align:right;">Amount</th>
                <th style="<?php echo $thCol; ?>">Name</th>
                <th style="<?php echo $thCol; ?> text-align:right;">Metal</th>
                <th style="<?php echo $thCol; ?> text-align:right;">Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $metalDiff = (float) $totals['jama_metal'] - (float) $totals['baki_metal'];
            $amountDiff = (float) $totals['jama_amount'] - (float) $totals['baki_amount'];
            ?>
            <?php foreach ($rows as $r): ?>
                <?php $j = isset($r['jama']) ? $r['jama'] : null; $b = isset($r['baki']) ? $r['baki'] : null; ?>
                <tr>
                    <td style="<?php echo $td; ?>"><?php echo $j ? CHtml::encode($j['name']) : ''; ?></td>
                    <td style="<?php echo $tdR; ?>"><?php echo $j ? number_format((float) $j['metal'], 3) : ''; ?></td>
                    <td style="<?php echo $tdR; ?>"><?php echo $j ? number_format((float) $j['amount'], 2) : ''; ?></td>
                    <td style="<?php echo $td; ?>"><?php echo $b ? CHtml::encode($b['name']) : ''; ?></td>
                    <td style="<?php echo $tdR; ?>"><?php echo $b ? number_format((float) $b['metal'], 3) : ''; ?></td>
                    <td style="<?php echo $tdR; ?>"><?php echo $b ? number_format((float) $b['amount'], 2) : ''; ?></td>
                </tr>
            <?php endforeach; ?>
            <tr style="<?php echo $rowTotal; ?>">
                <td style="<?php echo $td; ?>"><strong>TOTAL JAMA</strong></td>
                <td style="<?php echo $tdR; ?>"><strong><?php echo number_format((float) $totals['jama_metal'], 3); ?></strong></td>
                <td style="<?php echo $tdR; ?>"><strong><?php echo number_format((float) $totals['jama_amount'], 2); ?></strong></td>
                <td style="<?php echo $td; ?>"></td>
                <td style="<?php echo $tdR; ?>"></td>
                <td style="<?php echo $tdR; ?>"></td>
            </tr>
            <tr style="<?php echo $rowTotal; ?>">
                <td style="<?php echo $td; ?>"></td>
                <td style="<?php echo $tdR; ?>"></td>
                <td style="<?php echo $tdR; ?>"></td>
                <td style="<?php echo $td; ?>"><strong>TOTAL BAKI</strong></td>
                <td style="<?php echo $tdR; ?>"><strong><?php echo number_format((float) $totals['baki_metal'], 3); ?></strong></td>
                <td style="<?php echo $tdR; ?>"><strong><?php echo number_format((float) $totals['baki_amount'], 2); ?></strong></td>
            </tr>
            <tr style="<?php echo $rowNet; ?>">
                <td colspan="6" style="<?php echo $td; ?>">
                    <strong>NET TOTAL:</strong>
                    Metal <?php echo number_format(abs($metalDiff), 3); ?> (<?php echo $metalDiff >= 0 ? 'Jama' : 'Baki'; ?>)
                    &nbsp;|&nbsp;
                    Amount <?php echo number_format(abs($amountDiff), 2); ?> (<?php echo $amountDiff >= 0 ? 'Jama' : 'Baki'; ?>)
                </td>
            </tr>
        </tbody>
    </table>
</div>
