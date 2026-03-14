<?php
$borderColor = '#111';
$cellStyle = 'border:1px solid ' . $borderColor . '; padding:3px 4px; font-size:9px; vertical-align:top;';
$headStyle = 'border:1px solid ' . $borderColor . '; padding:4px; font-size:9px; font-weight:bold;';
$numStyle = 'text-align:right;';

$dateText = $model->txn_date ? date('d-m-Y', strtotime($model->txn_date)) : '';
$supplierName = isset($model->supplier) ? $model->supplier->name : '';
$voucherNo = !empty($model->voucher_number) ? $model->voucher_number : $model->id;
$printDate = date('d-m-Y');

$totalFineWt = (float) $model->total_fine_wt;
$totalAmount = (float) $model->total_amount;
?>

<table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse; margin-bottom:8px;">
    <tr>
        <td colspan="10" style="text-align:center; font-size:9px; padding-bottom:2px;">shree hari</td>
    </tr>
    <tr>
        <td colspan="10" style="<?php echo $headStyle; ?> text-align:center; font-size:13px; font-style:italic;">Supplier Voucher</td>
    </tr>
    <tr>
        <td style="<?php echo $headStyle; ?> width:10%;">Date</td>
        <td style="<?php echo $cellStyle; ?> width:22%;"><?php echo CHtml::encode($dateText); ?></td>
        <td style="<?php echo $headStyle; ?> width:10%;">Supplier</td>
        <td colspan="3" style="<?php echo $cellStyle; ?> width:38%;"><?php echo CHtml::encode($supplierName); ?></td>
        <td style="<?php echo $headStyle; ?> width:10%;">Voucher No</td>
        <td colspan="3" style="<?php echo $cellStyle; ?> width:20%;"><?php echo CHtml::encode($voucherNo); ?></td>
    </tr>
    <tr>
        <td style="<?php echo $headStyle; ?>">Remark</td>
        <td colspan="9" style="<?php echo $cellStyle; ?>"><?php echo !empty($model->remark) ? nl2br(CHtml::encode($model->remark)) : '&nbsp;'; ?></td>
    </tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse; margin-bottom:10px;">
    <tr>
        <td style="<?php echo $headStyle; ?> width:4%;">Sr</td>
        <td style="<?php echo $headStyle; ?> width:12%;">Item</td>
        <td style="<?php echo $headStyle; ?> width:12%;">Customer Name</td>
        <td style="<?php echo $headStyle; ?> width:6%;">Carat</td>
        <td style="<?php echo $headStyle . $numStyle; ?> width:8%;">Gross Wt</td>
        <td style="<?php echo $headStyle . $numStyle; ?> width:8%;">Net Wt</td>
        <td style="<?php echo $headStyle . $numStyle; ?> width:7%;">Touch %</td>
        <td style="<?php echo $headStyle . $numStyle; ?> width:7%;">Wst</td>
        <td style="<?php echo $headStyle . $numStyle; ?> width:8%;">Fine Wt</td>
        <td style="<?php echo $headStyle; ?> width:28%;">Other Items</td>
        <td style="<?php echo $headStyle . $numStyle; ?> width:10%;">Item Total</td>
    </tr>
    <?php if (!empty($model->items)): ?>
        <?php foreach ($model->items as $index => $item): ?>
            <tr>
                <td style="<?php echo $cellStyle; ?> text-align:center;"><?php echo $index + 1; ?></td>
                <td style="<?php echo $cellStyle; ?>"><?php echo CHtml::encode($item->item_name); ?></td>
                <td style="<?php echo $cellStyle; ?>"><?php echo CHtml::encode($item->customer_name); ?></td>
                <td style="<?php echo $cellStyle; ?>"><?php echo CHtml::encode($item->ct); ?></td>
                <td style="<?php echo $cellStyle . $numStyle; ?>"><?php echo number_format((float) $item->gross_wt, 3); ?></td>
                <td style="<?php echo $cellStyle . $numStyle; ?>"><?php echo number_format((float) $item->net_wt, 3); ?></td>
                <td style="<?php echo $cellStyle . $numStyle; ?>"><?php echo number_format((float) $item->touch_pct, 2); ?></td>
                <td style="<?php echo $cellStyle . $numStyle; ?>"><?php echo number_format((float) $item->wastage, 2); ?></td>
                <td style="<?php echo $cellStyle . $numStyle; ?>"><?php echo number_format((float) $item->fine_wt, 3); ?></td>
                <td style="<?php echo $cellStyle; ?> padding:0;">
                    <?php if (!empty($item->charges)): ?>
                        <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
                            <tr>
                                <td style="<?php echo $headStyle; ?> border-top:none; border-left:none; width:28%;">Type</td>
                                <td style="<?php echo $headStyle; ?> border-top:none; width:26%;">Name</td>
                                <td style="<?php echo $headStyle . $numStyle; ?> border-top:none; width:14%;">Qty</td>
                                <td style="<?php echo $headStyle . $numStyle; ?> border-top:none; width:14%;">Rate</td>
                                <td style="<?php echo $headStyle . $numStyle; ?> border-top:none; border-right:none; width:18%;">Amount</td>
                            </tr>
                            <?php foreach ($item->charges as $ch): ?>
                                <?php
                                $typeName = isset($ch->subitemType) ? $ch->subitemType->name : $ch->charge_type;
                                $chargeName = $ch->charge_name ? $ch->charge_name : '-';
                                ?>
                                <tr>
                                    <td style="<?php echo $cellStyle; ?> border-left:none;"><?php echo CHtml::encode($typeName); ?></td>
                                    <td style="<?php echo $cellStyle; ?>"><?php echo CHtml::encode($chargeName); ?></td>
                                    <td style="<?php echo $cellStyle . $numStyle; ?>"><?php echo number_format((float) $ch->quantity, 3); ?></td>
                                    <td style="<?php echo $cellStyle . $numStyle; ?>"><?php echo number_format((float) $ch->rate, 2); ?></td>
                                    <td style="<?php echo $cellStyle . $numStyle; ?> border-right:none;"><?php echo number_format((float) $ch->amount, 2); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php else: ?>
                        &nbsp;
                    <?php endif; ?>
                </td>
                <td style="<?php echo $cellStyle . $numStyle; ?>"><?php echo number_format((float) $item->item_total, 2); ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td style="<?php echo $cellStyle; ?>">&nbsp;</td>
            <td style="<?php echo $cellStyle; ?>">&nbsp;</td>
            <td style="<?php echo $cellStyle; ?>">&nbsp;</td>
            <td style="<?php echo $cellStyle; ?>">&nbsp;</td>
            <td style="<?php echo $cellStyle; ?>">&nbsp;</td>
            <td style="<?php echo $cellStyle; ?>">&nbsp;</td>
            <td style="<?php echo $cellStyle; ?>">&nbsp;</td>
            <td style="<?php echo $cellStyle; ?>">&nbsp;</td>
            <td style="<?php echo $cellStyle; ?>">&nbsp;</td>
            <td style="<?php echo $cellStyle; ?>">&nbsp;</td>
            <td style="<?php echo $cellStyle; ?>">&nbsp;</td>
        </tr>
    <?php endif; ?>
</table>

<table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse; margin-bottom:16px;">
    <tr>
        <td rowspan="2" style="<?php echo $headStyle; ?> width:18%;">Total Fine Wt</td>
        <td style="<?php echo $headStyle; ?> width:22%;">In Numbers</td>
        <td style="<?php echo $cellStyle; ?> width:60%;"><?php echo number_format($totalFineWt, 3); ?> GMS</td>
    </tr>
    <tr>
        <td style="<?php echo $headStyle; ?>">In Words</td>
        <td style="<?php echo $cellStyle; ?>"><?php echo strtoupper(Words::weightWordsForVoucher($totalFineWt)); ?> ONLY</td>
    </tr>
    <tr>
        <td rowspan="2" style="<?php echo $headStyle; ?>">Total Amount</td>
        <td style="<?php echo $headStyle; ?>">In Numbers</td>
        <td style="<?php echo $cellStyle; ?>"><?php echo number_format($totalAmount, 2); ?> INR</td>
    </tr>
    <tr>
        <td style="<?php echo $headStyle; ?>">In Words</td>
        <td style="<?php echo $cellStyle; ?>"><?php echo strtoupper(Words::amountWordsForVoucher($totalAmount)); ?></td>
    </tr>
</table>

<div style="margin-top:20px; font-size:10px;">
    <div style="margin-bottom:32px;"><strong>Signature:</strong></div>
    <div><strong>Date:</strong> <?php echo $printDate; ?></div>
</div>
