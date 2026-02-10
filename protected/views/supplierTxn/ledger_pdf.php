<?php
/* @var $account LedgerAccount */
/* @var $txns SupplierTxn[] */

$openingFine = (float)$account->opening_fine_wt;
$openingAmt = (float)$account->opening_amount;
if ((int)$account->opening_fine_wt_drcr === LedgerAccount::DRCR_DR) $openingFine = -$openingFine;
if ((int)$account->opening_amount_drcr === LedgerAccount::DRCR_DR) $openingAmt = -$openingAmt;

$runFine = $openingFine;
$runAmt = $openingAmt;

$totalFine = 0.0;
$totalAmt = 0.0;
?>

<h3 style="text-align:center;margin:0;">Supplier Ledger</h3>
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
			<th width="28%">Remarks</th>
			<th width="10%">Fine Wt</th>
			<th width="10%">Amt</th>
			<th width="10%">Run Fine</th>
			<th width="10%">Run Amt</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="3"><strong>Opening</strong></td>
			<td align="right"><?php echo number_format($openingFine, 3, '.', ''); ?></td>
			<td align="right"><?php echo number_format($openingAmt, 2, '.', ''); ?></td>
			<td align="right"><?php echo number_format($runFine, 3, '.', ''); ?></td>
			<td align="right"><?php echo number_format($runAmt, 2, '.', ''); ?></td>
		</tr>
		<?php foreach ($txns as $t): ?>
			<?php
			$fine = (float)$t->getTotalFineWt();
			$amt = (float)$t->getTotalChargeAmount();
			$totalFine += $fine;
			$totalAmt += $amt;
			$runFine += $fine;
			$runAmt += $amt;
			?>
			<tr>
				<td><?php echo CHtml::encode($t->txn_date); ?></td>
				<td><?php echo CHtml::encode($t->sr_no); ?></td>
				<td><?php echo CHtml::encode($t->remarks); ?></td>
				<td align="right"><?php echo number_format($fine, 3, '.', ''); ?></td>
				<td align="right"><?php echo number_format($amt, 2, '.', ''); ?></td>
				<td align="right"><?php echo number_format($runFine, 3, '.', ''); ?></td>
				<td align="right"><?php echo number_format($runAmt, 2, '.', ''); ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
	<tfoot>
		<tr>
			<th colspan="3" align="right">Totals</th>
			<th align="right"><?php echo number_format($totalFine, 3, '.', ''); ?></th>
			<th align="right"><?php echo number_format($totalAmt, 2, '.', ''); ?></th>
			<th align="right"><?php echo number_format($runFine, 3, '.', ''); ?></th>
			<th align="right"><?php echo number_format($runAmt, 2, '.', ''); ?></th>
		</tr>
		<tr>
			<td colspan="7">
				Amount in words: <strong><?php echo CHtml::encode(Words::inr($runAmt)); ?></strong><br>
				Fine wt in words: <strong><?php echo CHtml::encode(Words::weight($runFine)); ?></strong>
			</td>
		</tr>
	</tfoot>
</table>

