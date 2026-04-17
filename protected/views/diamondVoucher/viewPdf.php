<?php
$table = 'border:1px solid #222; border-collapse:collapse;';
$cell = 'border:1px solid #222; padding:3px 4px; font-size:11px;';
$head = 'border:1px solid #222; padding:3px 4px; font-size:11px; font-weight:bold;';

$voucherDate = !empty($model->voucher_date) ? date('d-m-Y', strtotime($model->voucher_date)) : '';
$accountName = isset($model->account) ? trim((string) $model->account->name) : '';
$voucherNo = trim((string) $model->voucher_number);
$subitemName = isset($model->subitemType) ? trim((string) $model->subitemType->name) : '';
$remarks = trim((string) $model->remarks);
$drcrOptions = IssueEntry::getDrcrOptions();
$entryType = isset($drcrOptions[$model->drcr]) ? $drcrOptions[$model->drcr] : '';
$qty = number_format((float) $model->qty, 3, '.', '');
$rate = number_format((float) $model->rate, 2, '.', '');
$amount = number_format((float) $model->amount, 2, '.', '');
$amountWords = Words::amountWordsForVoucher((float) $model->amount);
?>

<table width="100%" cellpadding="0" cellspacing="0" style="<?php echo $table; ?> margin-bottom:16px;">
	<tr>
		<td colspan="4" style="text-align:center; font-size:9px; padding-bottom:2px;">shree hari</td>
	</tr>
	<tr>
		<td colspan="4" style="<?php echo $head; ?> text-align:center; font-style:italic; font-size:13px;">DIAMOND VOUCHER</td>
	</tr>
	<tr>
		<td style="<?php echo $head; ?> width:14%;">DATE</td>
		<td style="<?php echo $cell; ?> width:36%;"><?php echo CHtml::encode($voucherDate); ?></td>
		<td style="<?php echo $head; ?> width:18%;">VOUCHER NO</td>
		<td style="<?php echo $cell; ?> width:32%;"><?php echo CHtml::encode($voucherNo); ?></td>
	</tr>
	<tr>
		<td style="<?php echo $head; ?>">ACCOUNT</td>
		<td style="<?php echo $cell; ?>"><?php echo CHtml::encode($accountName); ?></td>
		<td style="<?php echo $head; ?>">ENTRY TYPE</td>
		<td style="<?php echo $cell; ?>"><?php echo CHtml::encode($entryType); ?></td>
	</tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" style="<?php echo $table; ?> margin-bottom:16px;">
	<tr>
		<td style="<?php echo $head; ?> width:40%;">SUBITEM</td>
		<td style="<?php echo $head; ?> width:15%;">QTY</td>
		<td style="<?php echo $head; ?> width:20%;">RATE</td>
		<td style="<?php echo $head; ?> width:25%;">AMOUNT</td>
	</tr>
	<tr>
		<td style="<?php echo $cell; ?>"><?php echo CHtml::encode($subitemName); ?></td>
		<td style="<?php echo $cell; ?> text-align:right;"><?php echo CHtml::encode($qty); ?></td>
		<td style="<?php echo $cell; ?> text-align:right;"><?php echo CHtml::encode($rate); ?></td>
		<td style="<?php echo $cell; ?> text-align:right;"><?php echo CHtml::encode($amount); ?></td>
	</tr>
	<tr>
		<td style="<?php echo $head; ?>">REMARK</td>
		<td colspan="3" style="<?php echo $cell; ?>"><?php echo CHtml::encode($remarks); ?></td>
	</tr>
</table>

<table width="100%" cellpadding="0" cellspacing="0" style="<?php echo $table; ?> margin-bottom:22px;">
	<tr>
		<td rowspan="2" style="<?php echo $head; ?> width:18%;">TOTAL AMOUNT</td>
		<td style="<?php echo $cell; ?> width:82%;"><strong>IN NUMBERS :</strong> <?php echo CHtml::encode($amount); ?> INR</td>
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