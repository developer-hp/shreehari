<?php
/* @var $model KarigarVoucher */
/* @var $lines KarigarVoucherLine[] */

$totalFine = 0.0;
$totalCompAmt = 0.0;
foreach ($lines as $ln) {
	$totalFine += (float)$ln->fine_wt;
	foreach ($ln->components as $c) {
		$totalCompAmt += (float)$c->amount;
	}
}
?>

<h3 style="text-align:center;margin:0;">Jama Voucher</h3>
<div style="text-align:center;margin-bottom:6px;">
	<strong><?php echo CHtml::encode($model->sr_no); ?></strong>
</div>

<table width="100%" cellpadding="3" cellspacing="0" border="0" style="font-size:10px;">
	<tr>
		<td><strong>Date:</strong> <?php echo CHtml::encode($model->voucher_date); ?></td>
		<td align="right"><strong>Karigar:</strong> <?php echo CHtml::encode($model->karigarAccount ? $model->karigarAccount->name : ''); ?></td>
	</tr>
	<?php if (!empty($model->remarks)): ?>
	<tr><td colspan="2"><strong>Remarks:</strong> <?php echo CHtml::encode($model->remarks); ?></td></tr>
	<?php endif; ?>
</table>

<table width="100%" cellpadding="4" cellspacing="0" border="1" style="border-collapse:collapse;font-size:9px;">
	<thead>
		<tr>
			<th width="12%">Order</th>
			<th width="22%">Customer</th>
			<th width="26%">Item</th>
			<th width="8%">Pcs</th>
			<th width="10%">Net</th>
			<th width="10%">Touch</th>
			<th width="12%">Fine</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($lines as $ln): ?>
		<tr>
			<td><?php echo CHtml::encode($ln->order_no); ?></td>
			<td><?php echo CHtml::encode($ln->customer ? $ln->customer->name : ''); ?></td>
			<td><?php echo CHtml::encode($ln->item_name); ?></td>
			<td align="right"><?php echo CHtml::encode($ln->psc); ?></td>
			<td align="right"><?php echo CHtml::encode($ln->net_wt); ?></td>
			<td align="right"><?php echo CHtml::encode($ln->touch_pct); ?></td>
			<td align="right"><?php echo number_format((float)$ln->fine_wt, 3, '.', ''); ?></td>
		</tr>
		<?php if (!empty($ln->components)): ?>
			<tr>
				<td colspan="7">
					<strong>Components:</strong>
					<table width="100%" cellpadding="3" cellspacing="0" border="1" style="border-collapse:collapse;font-size:8px;margin-top:4px;">
						<tr><th width="18%">Type</th><th>Name</th><th width="12%">Wt</th><th width="15%">Amt</th></tr>
						<?php foreach ($ln->components as $c): ?>
							<tr>
								<td><?php echo CHtml::encode($c->component_type); ?></td>
								<td><?php echo CHtml::encode($c->name); ?></td>
								<td align="right"><?php echo CHtml::encode($c->wt); ?></td>
								<td align="right"><?php echo number_format((float)$c->amount, 2, '.', ''); ?></td>
							</tr>
						<?php endforeach; ?>
					</table>
				</td>
			</tr>
		<?php endif; ?>
	<?php endforeach; ?>
	</tbody>
	<tfoot>
		<tr>
			<th colspan="6" align="right">Total Fine</th>
			<th align="right"><?php echo number_format($totalFine, 3, '.', ''); ?></th>
		</tr>
	</tfoot>
</table>

<div style="margin-top:6px;font-size:10px;">
	<strong>Fine wt in words:</strong> <?php echo CHtml::encode(Words::weight($totalFine)); ?><br>
	<strong>Other amount in words:</strong> <?php echo CHtml::encode(Words::inr($totalCompAmt)); ?>
</div>

<div style="margin-top:18px;">
	<table width="100%" cellpadding="2" cellspacing="0" border="0" style="font-size:10px;">
		<tr>
			<td width="50%" align="center">Receiver Sign</td>
			<td width="50%" align="center">Authorised Sign</td>
		</tr>
	</table>
</div>

