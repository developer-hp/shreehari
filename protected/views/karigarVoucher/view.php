<?php
/* @var $this KarigarVoucherController */
/* @var $model KarigarVoucher */

$this->breadcrumbs=array(
	'Karigar Voucher'=>array('admin'),
	$model->sr_no,
);

$lines = KarigarVoucherLine::model()->with('components','customer')->findAllByAttributes(
	array('karigar_voucher_id'=>$model->id),
	array('order'=>'t.sort_order asc, t.id asc')
);
?>

<div class="pull-right">
	<?php echo CHtml::link('Print (A5)', array('print','id'=>$model->id), array('class'=>'btn btn-primary','target'=>'_blank')); ?>
	<?php echo CHtml::link('Update', array('update','id'=>$model->id), array('class'=>'btn btn-default')); ?>
	<?php echo CHtml::link('Back', array('admin'), array('class'=>'btn btn-default')); ?>
</div>

<h3>Karigar Voucher: <?php echo CHtml::encode($model->sr_no); ?></h3>

<table class="table table-bordered">
	<tr><th style="width:20%;">Date</th><td><?php echo CHtml::encode($model->voucher_date); ?></td></tr>
	<tr><th>Karigar</th><td><?php echo CHtml::encode($model->karigarAccount ? $model->karigarAccount->name : ''); ?></td></tr>
	<tr><th>Remarks</th><td><?php echo nl2br(CHtml::encode($model->remarks)); ?></td></tr>
	<tr><th>Total Fine Wt</th><td><?php echo number_format($model->getTotalFineWt(), 3, '.', ''); ?></td></tr>
</table>

<h4>Lines</h4>
<?php foreach ($lines as $ln): ?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<strong><?php echo CHtml::encode($ln->item_name); ?></strong>
			<span class="pull-right">Fine: <?php echo number_format((float)$ln->fine_wt, 3, '.', ''); ?></span>
		</div>
		<div class="panel-body">
			<table class="table table-condensed">
				<tr>
					<th style="width:12%;">Order</th><td><?php echo CHtml::encode($ln->order_no); ?></td>
					<th style="width:12%;">Customer</th><td><?php echo CHtml::encode($ln->customer ? $ln->customer->name : ''); ?></td>
					<th style="width:12%;">Pcs</th><td><?php echo CHtml::encode($ln->psc); ?></td>
					<th style="width:12%;">Gross</th><td><?php echo CHtml::encode($ln->gross_wt); ?></td>
					<th style="width:12%;">Net</th><td><?php echo CHtml::encode($ln->net_wt); ?></td>
					<th style="width:12%;">Touch %</th><td><?php echo CHtml::encode($ln->touch_pct); ?></td>
				</tr>
			</table>
			<?php if (!empty($ln->components)): ?>
				<table class="table table-bordered table-condensed">
					<thead><tr><th>Type</th><th>Name</th><th>Wt</th><th>Amount</th></tr></thead>
					<tbody>
					<?php foreach ($ln->components as $c): ?>
						<tr>
							<td><?php echo CHtml::encode($c->component_type); ?></td>
							<td><?php echo CHtml::encode($c->name); ?></td>
							<td><?php echo CHtml::encode($c->wt); ?></td>
							<td><?php echo CHtml::encode($c->amount); ?></td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			<?php else: ?>
				<em>No components</em>
			<?php endif; ?>
	</div>
</div>
<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>

