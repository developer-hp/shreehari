<?php
$table = 'border:1px solid #222; border-collapse:collapse;';
$cell = 'border:1px solid #222; padding:3px 4px; font-size:11px;';
$head = 'border:1px solid #222; padding:3px 4px; font-size:11px; font-weight:bold;';

$issueDate = !empty($model->issue_date) ? date('d-m-Y', strtotime($model->issue_date)) : '';
$customerName = isset($model->customer) ? trim((string) $model->customer->name) : '';
$voucherNo = trim((string) $model->sr_no);
$lineSrNo = $voucherNo !== '' ? $voucherNo : 'AUTO TAKEN';
$carat = trim((string) $model->carat);
$fineWt = (float) $model->fine_wt;
$amount = (float) $model->amount;
$remarkText = trim((string) $model->remarks);

$particulars = 'AUTO TAKEN';
if ($remarkText !== '') {
    $remarkLines = preg_split('/\r\n|\r|\n/', $remarkText);
    if (!empty($remarkLines[0])) {
        $particulars = trim($remarkLines[0]);
    }
}

if (!function_exists('issueVoucherFmtNumber')) {
    function issueVoucherFmtNumber($value, $decimals = 3)
    {
        $txt = number_format((float) $value, (int) $decimals, '.', '');
        return rtrim(rtrim($txt, '0'), '.');
    }
}

$fineWtNum = issueVoucherFmtNumber($fineWt, 3);
$amountNum = issueVoucherFmtNumber($amount, 2);
$fineWtWords = Words::weightWordsForVoucher($fineWt, true);
$amountWords = Words::amountWordsForVoucher($amount);
?>

<table width="100%" cellpadding="0" cellspacing="0" style="<?php echo $table; ?> margin-bottom:16px;">
    <tr>
        <td colspan="4" style="<?php echo $head; ?> text-align:center; font-style:italic; font-size:13px;">ISSUE VOUCHER</td>
    </tr>
    <tr>
        <td style="<?php echo $head; ?> width:11%;">DATE</td>
        <td style="<?php echo $cell; ?> width:47%;"><?php echo CHtml::encode($issueDate); ?></td>
        <td style="<?php echo $head; ?> width:15%;">VOUCHER NO</td>
        <td style="<?php echo $cell; ?> width:30%;"><?php echo CHtml::encode($voucherNo); ?></td>
    </tr>
    <tr>
        <td style="<?php echo $head; ?>">NAME</td>
        <td colspan="3" style="<?php echo $cell; ?>"><?php echo CHtml::encode($customerName); ?></td>
    </tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" style="<?php echo $table; ?> margin-bottom:16px;">
    <tr>
        <td style="<?php echo $head; ?> width:23%;">PARTICULARS</td>
        <td style="<?php echo $head; ?> width:8%;">CARAT</td>
        <td style="<?php echo $head; ?> width:16%;">FINE WT GMS</td>
        <td style="<?php echo $head; ?> width:17%;">AMOUNT INR</td>
    </tr>
    <tr>
        <td style="<?php echo $cell; ?>"><?php echo CHtml::encode($particulars); ?></td>
        <td style="<?php echo $cell; ?> text-align:right;"><?php echo CHtml::encode($carat); ?></td>
        <td style="<?php echo $cell; ?> text-align:right;"><?php echo CHtml::encode($fineWtNum); ?></td>
        <td style="<?php echo $cell; ?> text-align:right;"><?php echo CHtml::encode($amountNum); ?></td>
    </tr>
    <tr>
        <td style="<?php echo $head; ?> text-align:left;">REMARK</td>
        <td colspan="3" style="<?php echo $cell; ?>"><?php echo CHtml::encode($remarkText); ?></td>
    </tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" style="<?php echo $table; ?> margin-bottom:22px;">
    <tr>
        <td rowspan="2" style="<?php echo $head; ?> width:15%;">TOTAL FINE WT</td>
        <td style="<?php echo $cell; ?> width:89%;"><strong>IN NUMBERS :</strong> <?php echo CHtml::encode($fineWtNum); ?> GMS</td>
    </tr>
    <tr>
        <td style="<?php echo $cell; ?>"><strong>IN WORDS :</strong> <?php echo CHtml::encode($fineWtWords); ?></td>
    </tr>
    <tr>
        <td rowspan="2" style="<?php echo $head; ?>">TOTAL AMOUNT</td>
        <td style="<?php echo $cell; ?>"><strong>IN NUMBERS :</strong> <?php echo CHtml::encode($amountNum); ?> INR</td>
    </tr>
    <tr>
        <td style="<?php echo $cell; ?>"><strong>IN WORDS :</strong> <?php echo CHtml::encode($amountWords); ?></td>
    </tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
    <tr>
        <td style="font-size:10px; padding:8px 2px;"><strong>SIGNATURE:</strong></td>
    </tr>
    <tr>
        <td style="font-size:10px; padding:8px 2px;"><strong>DATE : <?php echo date('d-m-Y'); ?></strong></td>
    </tr>
</table>
