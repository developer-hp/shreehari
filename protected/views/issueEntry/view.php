<?php
/* @var $this IssueEntryController */
/* @var $model IssueEntry */

$this->breadcrumbs=array(
	'Issue Entry'=>array('admin'),
	$model->sr_no,
);
?>

<div class="row">
	<div class="col-md-12">
		<div class="block">
			<div class="block-title">
				<h2>Issue Entry: <?php echo CHtml::encode($model->sr_no); ?></h2>
			</div>
			<div class="block-content">
				<div class="pull-right">
					<?php echo CHtml::link('Update', array('update','id'=>$model->id), array('class'=>'btn btn-default')); ?>
					<?php echo CHtml::link('Back', array('admin'), array('class'=>'btn btn-default')); ?>
				</div>

				<table class="table table-bordered">
	<tr><th style="width:20%;">Date</th><td><?php echo CHtml::encode($model->issue_date); ?></td></tr>
	<tr><th>Account</th><td><?php echo CHtml::encode($model->account ? $model->account->name : ''); ?></td></tr>
	<tr><th>Fine Wt</th><td><?php echo CHtml::encode($model->fine_wt); ?></td></tr>
	<tr><th>Amount</th><td><?php echo CHtml::encode($model->amount); ?></td></tr>
	<tr><th>Remarks</th><td><?php echo nl2br(CHtml::encode($model->remarks)); ?></td></tr>
</table>
			</div>
		</div>
	</div>
</div>

