<?php
/* @var $this LedgerAccountController */
/* @var $model LedgerAccount */

$this->breadcrumbs=array(
	'Ledger Accounts'=>array('admin'),
	$model->name,
);
?>

<div class="row">
	<div class="col-md-12">
		<div class="block">
			<div class="block-title">
				<h2>Ledger Account: <?php echo CHtml::encode($model->name); ?></h2>
			</div>
			<div class="block-content">
				<div class="pull-right">
					<?php echo CHtml::link('Update', array('update','id'=>$model->id), array('class'=>'btn btn-default')); ?>
					<?php echo CHtml::link('Back', array('admin'), array('class'=>'btn btn-default')); ?>
				</div>

				<table class="table table-bordered">
	<tr><th style="width:25%;">Type</th><td><?php echo CHtml::encode(isset(LedgerAccount::typeOptions()[$model->type]) ? LedgerAccount::typeOptions()[$model->type] : $model->type); ?></td></tr>
	<tr><th>Linked Party</th><td><?php echo CHtml::encode($model->partyCustomer ? $model->partyCustomer->name : ''); ?></td></tr>
	<tr><th>Opening Fine Wt</th><td><?php echo number_format((float)$model->opening_fine_wt, 3, '.', ''); ?> <?php echo CHtml::encode(isset(LedgerAccount::drcrOptions()[$model->opening_fine_wt_drcr]) ? LedgerAccount::drcrOptions()[$model->opening_fine_wt_drcr] : ''); ?></td></tr>
	<tr><th>Opening Amount</th><td><?php echo number_format((float)$model->opening_amount, 2, '.', ''); ?> <?php echo CHtml::encode(isset(LedgerAccount::drcrOptions()[$model->opening_amount_drcr]) ? LedgerAccount::drcrOptions()[$model->opening_amount_drcr] : ''); ?></td></tr>
</table>
			</div>
		</div>
	</div>
</div>

