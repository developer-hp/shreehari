<?php
$cellStyle = 'border:1px solid #333; padding:3px 5px; font-size:9px;';
$thStyle = 'border:1px solid #333; padding:4px 5px; background:#e8e8e8; font-weight:bold; font-size:9px;';
$numStyle = 'text-align:right;';
$totalFineWt = 0;
$totalAmount = 0;
foreach ($model->lines as $line) {
    $totalFineWt += (float) $line->fine_wt;
    foreach ($line->stones as $s) $totalAmount += (float) $s->stone_amount;
}
?>
<div style="margin-bottom:8px; font-size:11px;"><strong>Jama Voucher #<?php echo CHtml::encode($model->id); ?></strong></div>
<table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse; margin-bottom:8px; font-size:9px;">
    <tr>
        <td style="<?php echo $cellStyle; ?> width:22%;"><strong>Date</strong></td>
        <td style="<?php echo $cellStyle; ?>"><?php echo $model->voucher_date ? date('d-m-Y', strtotime($model->voucher_date)) : '—'; ?></td>
    </tr>
    <tr>
        <td style="<?php echo $cellStyle; ?>"><strong>Karigar</strong></td>
        <td style="<?php echo $cellStyle; ?>"><?php echo isset($model->karigar) ? CHtml::encode($model->karigar->name) : '—'; ?></td>
    </tr>
    <?php if (!empty($model->sr_no)): ?>
    <tr>
        <td style="<?php echo $cellStyle; ?>"><strong>SR No</strong></td>
        <td style="<?php echo $cellStyle; ?>"><?php echo CHtml::encode($model->sr_no); ?></td>
    </tr>
    <?php endif; ?>
    <?php if (!empty($model->voucher_number)): ?>
    <tr>
        <td style="<?php echo $cellStyle; ?>"><strong>Voucher No</strong></td>
        <td style="<?php echo $cellStyle; ?>"><?php echo CHtml::encode($model->voucher_number); ?></td>
    </tr>
    <?php endif; ?>
    <tr>
        <td style="<?php echo $cellStyle; ?>"><strong>Total Fine Wt</strong></td>
        <td style="<?php echo $cellStyle . $numStyle; ?>"><?php echo number_format($totalFineWt, 3); ?></td>
    </tr>
    <tr>
        <td style="<?php echo $cellStyle; ?>"><strong>Total Amount</strong></td>
        <td style="<?php echo $cellStyle . $numStyle; ?>"><?php echo number_format($totalAmount, 2); ?></td>
    </tr>
</table>

<div style="margin-bottom:6px; font-size:10px;"><strong>Lines</strong></div>
<table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse; margin-bottom:0; font-size:8px;">
    <thead>
        <tr>
            <th width="6%" style="<?php echo $thStyle; ?>">Sr</th>
            <th width="10%" style="<?php echo $thStyle; ?>">Order</th>
            <th width="12%" style="<?php echo $thStyle; ?>">Customer</th>
            <th width="10%" style="<?php echo $thStyle; ?>">Item</th>
            <th width="6%" style="<?php echo $thStyle; ?>">Psc</th>
            <th width="9%" style="<?php echo $thStyle . $numStyle; ?>">Gross</th>
            <th width="9%" style="<?php echo $thStyle . $numStyle; ?>">Net</th>
            <th width="7%" style="<?php echo $thStyle; ?>">Touch%</th>
            <th width="9%" style="<?php echo $thStyle . $numStyle; ?>">Fine Wt</th>
            <th width="14%" style="<?php echo $thStyle; ?>">Stone</th>
            <th width="8%" style="<?php echo $thStyle; ?>">Remark</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($model->lines as $line): ?>
        <tr>
            <td style="<?php echo $cellStyle; ?>"><?php echo CHtml::encode($line->sr_no); ?></td>
            <td style="<?php echo $cellStyle; ?>"><?php echo CHtml::encode($line->order_no); ?></td>
            <td style="<?php echo $cellStyle; ?>"><?php echo CHtml::encode($line->customer_name); ?></td>
            <td style="<?php echo $cellStyle; ?>"><?php echo CHtml::encode($line->item_name); ?></td>
            <td style="<?php echo $cellStyle; ?>"><?php echo CHtml::encode($line->psc); ?></td>
            <td style="<?php echo $cellStyle . $numStyle; ?>"><?php echo number_format((float)$line->gross_wt, 3); ?></td>
            <td style="<?php echo $cellStyle . $numStyle; ?>"><?php echo number_format((float)$line->net_wt, 3); ?></td>
            <td style="<?php echo $cellStyle; ?>"><?php echo CHtml::encode($line->touch_pct); ?></td>
            <td style="<?php echo $cellStyle . $numStyle; ?>"><?php echo number_format((float)$line->fine_wt, 3); ?></td>
            <td style="<?php echo $cellStyle; ?>">
                <?php if (!empty($line->stones)): ?>
                <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse; margin:0; font-size:7px;">
                    <tr><th style="<?php echo $thStyle; ?>">Item</th><th style="<?php echo $thStyle . $numStyle; ?>">Wt</th><th style="<?php echo $thStyle . $numStyle; ?>">Amt</th></tr>
                    <?php foreach ($line->stones as $s): ?>
                    <tr>
                        <td style="<?php echo $cellStyle; ?>"><?php echo CHtml::encode(isset($s->item) ? $s->item : '—'); ?></td>
                        <td style="<?php echo $cellStyle . $numStyle; ?>"><?php echo number_format((float)$s->stone_wt, 3); ?></td>
                        <td style="<?php echo $cellStyle . $numStyle; ?>"><?php echo number_format((float)$s->stone_amount, 2); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <?php endif; ?>
            </td>
            <td style="<?php echo $cellStyle; ?>"><?php echo CHtml::encode($line->remark); ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
