<?php
/* @var $account LedgerAccount */
/* @var $vouchers KarigarVoucher[] */

$openingFine = (float)$account->opening_fine_wt;
$openingAmt = (float)$account->opening_amount;
if ((int)$account->opening_fine_wt_drcr === LedgerAccount::DRCR_DR) $openingFine = -$openingFine;
if ((int)$account->opening_amount_drcr === LedgerAccount::DRCR_DR) $openingAmt = -$openingAmt;

$runFine = $openingFine;
$runAmt = $openingAmt;
?>

<h3 style="text-align:center;margin:0;">Karigar Ledger</h3>
<div style="text-align:center;margin-bottom:8px;">
	<strong><?php echo CHtml::encode($account->name); ?></strong><br>
	<?php if (!empty($start) || !empty($end)): ?>
		Period: <?php echo CHtml::encode($start ?: '...'); ?> to <?php echo CHtml::encode($end ?: '...'); ?>
	<?php endif; ?>
</div>

<table width="100%" cellpadding="4" cellspacing="0" border="1" style="border-collapse:collapse;font-size:10px;">
	<thead>
	<tr>
		<th width="10%">Date</th>
		<th width="12%">Sr No</th>
		<th width="38%">Remarks</th>
		<th width="10%">Fine</th>
		<th width="10%">Run Fine</th>
		<th width="10%">Run Amt</th>
	</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="3"><strong>Opening</strong></td>
			<td align="right"><?php echo number_format($openingFine, 3, '.', ''); ?></td>
			<td align="right"><?php echo number_format($runFine, 3, '.', ''); ?></td>
			<td align="right"><?php echo number_format($runAmt, 2, '.', ''); ?></td>
		</tr>
		<?php
		$totalFine = 0.0;
		foreach ($vouchers as $v) {
			$f = (float)$v->getTotalFineWt();
			$totalFine += $f;
			$runFine += $f;
			?>
			<tr>
				<td><?php echo CHtml::encode($v->voucher_date); ?></td>
				<td><?php echo CHtml::encode($v->sr_no); ?></td>
				<td><?php echo CHtml::encode($v->remarks); ?></td>
				<td align="right"><?php echo number_format($f, 3, '.', ''); ?></td>
				<td align="right"><?php echo number_format($runFine, 3, '.', ''); ?></td>
				<td align="right"><?php echo number_format($runAmt, 2, '.', ''); ?></td>
			</tr>
			<?php
		}
		?>
	</tbody>
	<tfoot>
		<tr>
			<th colspan="3" align="right">Totals</th>
			<th align="right"><?php echo number_format($totalFine, 3, '.', ''); ?></th>
			<th align="right"><?php echo number_format($runFine, 3, '.', ''); ?></th>
			<th align="right"><?php echo number_format($runAmt, 2, '.', ''); ?></th>
		</tr>
		<tr>
			<td colspan="6">
				Fine wt in words: <strong><?php echo CHtml::encode(Words::weight($runFine)); ?></strong>
			</td>
		</tr>
	</tfoot>
</table>

