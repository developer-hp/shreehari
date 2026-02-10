<?php
/* @var $this IssueEntryController */
/* @var $model IssueEntry */

$this->breadcrumbs=array(
	'Issue Entry'=>array('admin'),
);
?>

<div class="row">
	<div class="col-md-12">
		<div class="block">
			<div class="block-title">
				<h2>Issue / Credit Entries</h2>
			</div>
			<div class="block-content">
				<div class="pull-right">
					<?php echo CHtml::link('Create Issue Entry', array('create'), array('class'=>'btn btn-primary')); ?>
				</div>

				<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'issue-entry-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'itemsCssClass'=>'table table-bordered table-striped',
	'columns'=>array(
		'id',
		'sr_no',
		'issue_date',
		array(
			'name'=>'account_id',
			'value'=>'$data->account ? $data->account->name : ""',
			'filter'=>CHtml::listData(LedgerAccount::model()->findAllByAttributes(array("is_deleted"=>0), array("order"=>"type asc, name asc")),"id","name"),
		),
		array('name'=>'fine_wt','value'=>'$data->fine_wt'),
		array('name'=>'amount','value'=>'$data->amount'),
		array(
			'class'=>'CButtonColumn',
			'template'=>'{view} {update} {delete}',
		),
	),
)); ?>
			</div>
		</div>
	</div>
</div>

