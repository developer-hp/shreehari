<?php
$borderColor = '#111';
$cellStyle = 'border:1px solid ' . $borderColor . '; padding:3px 5px; font-size:11px;';
$headStyle = 'border:1px solid ' . $borderColor . '; padding:4px 5px; font-size:11px; font-weight:bold;';
$numStyle = 'text-align:right;';

$dateText = $model->txn_date ? date('d-m-Y', strtotime($model->txn_date)) : '';
$nameText = isset($model->supplier) ? CHtml::encode($model->supplier->name) : '';
$voucherNo = !empty($model->voucher_number) ? $model->voucher_number : $model->id;
$printDate = date('d-m-Y');

$totalFineWt = (float) $model->total_fine_wt;
$totalAmount = (float) $model->total_amount;
?>

<table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse; margin-bottom:8px;">
    <tr>
        <td colspan="6" style="<?php echo $headStyle; ?> text-align:center; font-size:14px; font-style:italic;">Supplier Voucher</td>
    </tr>
    <tr>
        <td style="<?php echo $headStyle; ?> width:10%;">DATE</td>
        <td colspan="3" style="<?php echo $cellStyle; ?> width:52%;"><?php echo $dateText; ?></td>
        <td style="<?php echo $headStyle; ?> width:16%;">VOUCHER NO</td>
        <td style="<?php echo $cellStyle; ?> width:22%;"><?php echo CHtml::encode($voucherNo); ?></td>
    </tr>
    <tr>
        <td style="<?php echo $headStyle; ?>">NAME</td>
        <td colspan="5" style="<?php echo $cellStyle; ?>"><?php echo $nameText; ?></td>
    </tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse; margin-bottom:10px;">
    <tr>
        <td style="<?php echo $headStyle; ?> width:10%;">SR. NO</td>
        <td style="<?php echo $headStyle; ?> width:42%;">PARTICULARS</td>
        <td style="<?php echo $headStyle; ?> width:14%;">CARAT</td>
        <td style="<?php echo $headStyle . $numStyle; ?> width:16%;">FINE WT GM</td>
        <td style="<?php echo $headStyle . $numStyle; ?> width:18%;">AMOUNT INR</td>
    </tr>
    <?php if (!empty($model->items)): ?>
        <?php foreach ($model->items as $index => $item): ?>
        <tr>
            <td style="<?php echo $cellStyle; ?>"><?php echo $index + 1; ?></td>
            <td style="<?php echo $cellStyle; ?>"><?php echo CHtml::encode($item->item_name); ?></td>
            <td style="<?php echo $cellStyle; ?>"><?php echo CHtml::encode($item->ct); ?></td>
            <td style="<?php echo $cellStyle . $numStyle; ?>"><?php echo number_format((float) $item->fine_wt, 3); ?></td>
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
        </tr>
    <?php endif; ?>
    <tr>
        <td style="<?php echo $headStyle; ?> text-align:center;">REMARK</td>
        <td colspan="4" style="<?php echo $cellStyle; ?>"><?php echo !empty($model->remark) ? nl2br(CHtml::encode($model->remark)) : '&nbsp;'; ?></td>
    </tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse; margin-bottom:16px;">
    <tr>
        <td rowspan="2" style="<?php echo $headStyle; ?> width:18%;">TOTAL FINE WT</td>
        <td style="<?php echo $headStyle; ?> width:22%;">IN NUMBERS :</td>
        <td style="<?php echo $cellStyle; ?> width:60%;"><?php echo number_format($totalFineWt, 3); ?> GMS</td>
    </tr>
    <tr>
        <td style="<?php echo $headStyle; ?>">IN WORDS :</td>
        <td style="<?php echo $cellStyle; ?>"><?php echo strtoupper(Words::weight($totalFineWt)); ?> GRAMS ONLY</td>
    </tr>
    <tr>
        <td rowspan="2" style="<?php echo $headStyle; ?>">TOTAL AMOUNT</td>
        <td style="<?php echo $headStyle; ?>">IN NUMBERS :</td>
        <td style="<?php echo $cellStyle; ?>"><?php echo number_format($totalAmount, 2); ?> INR</td>
    </tr>
    <tr>
        <td style="<?php echo $headStyle; ?>">IN WORDS :</td>
        <td style="<?php echo $cellStyle; ?>"><?php echo strtoupper(Words::amountToWords($totalAmount)); ?></td>
    </tr>
</table>

<div style="margin-top:28px; font-size:10px;">
    <div style="margin-bottom:36px;"><strong>SIGNATURE:</strong></div>
    <div><strong>DATE :</strong> <?php echo $printDate; ?></div>
</div>
