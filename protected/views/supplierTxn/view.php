<?php
/* @var $this SupplierTxnController */
/* @var $model SupplierTxn */

$this->breadcrumbs=array(
	'Supplier Txn'=>array('admin'),
	$model->sr_no,
);
?>

<div class="pull-right">
	<?php echo CHtml::link('Update', array('update','id'=>$model->id), array('class'=>'btn btn-default')); ?>
	<?php if ($model->supplier_account_id): ?>
		<?php echo CHtml::link('Print Ledger (A4)', array('printLedger','supplier_account_id'=>$model->supplier_account_id), array('class'=>'btn btn-primary','target'=>'_blank')); ?>
	<?php endif; ?>
	<?php echo CHtml::link('Back', array('admin'), array('class'=>'btn btn-default')); ?>
</div>

<h3>Supplier Txn: <?php echo CHtml::encode($model->sr_no); ?></h3>

<table class="table table-bordered">
	<tr><th style="width:20%;">Date</th><td><?php echo CHtml::encode($model->txn_date); ?></td></tr>
	<tr><th>Supplier</th><td><?php echo CHtml::encode($model->supplierAccount ? $model->supplierAccount->name : ''); ?></td></tr>
	<tr><th>Remarks</th><td><?php echo nl2br(CHtml::encode($model->remarks)); ?></td></tr>
	<tr><th>Total Fine Wt</th><td><?php echo number_format($model->getTotalFineWt(), 3, '.', ''); ?></td></tr>
	<tr><th>Total Charges</th><td><?php echo number_format($model->getTotalChargeAmount(), 2, '.', ''); ?></td></tr>
</table>

<h4>Items</h4>
<?php foreach ($model->items as $it): ?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<strong><?php echo CHtml::encode($it->item_name); ?></strong>
			<span class="pull-right">Fine: <?php echo number_format((float)$it->fine_wt, 3, '.', ''); ?></span>
		</div>
		<div class="panel-body">
			<table class="table table-condensed">
				<tr>
					<th style="width:12%;">Ct</th><td><?php echo CHtml::encode($it->ct); ?></td>
					<th style="width:12%;">Gross</th><td><?php echo CHtml::encode($it->gross_wt); ?></td>
					<th style="width:12%;">Net</th><td><?php echo CHtml::encode($it->net_wt); ?></td>
					<th style="width:12%;">Touch %</th><td><?php echo CHtml::encode($it->touch_pct); ?></td>
				</tr>
			</table>
			<?php if (!empty($it->charges)): ?>
				<table class="table table-bordered table-condensed">
					<thead>
						<tr><th>Type</th><th>Name</th><th>Qty</th><th>Rate</th><th>Amt</th><th>Unit</th></tr>
					</thead>
					<tbody>
						<?php foreach ($it->charges as $ch): ?>
							<tr>
								<td><?php echo CHtml::encode($ch->charge_type); ?></td>
								<td><?php echo CHtml::encode($ch->name); ?></td>
								<td><?php echo CHtml::encode($ch->qty); ?></td>
								<td><?php echo CHtml::encode($ch->rate); ?></td>
								<td><?php echo CHtml::encode($ch->amount); ?></td>
								<td><?php echo CHtml::encode($ch->unit); ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php else: ?>
				<em>No charges</em>
			<?php endif; ?>
	</div>
</div>
<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>

