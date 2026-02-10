<?php
/* @var $this LedgerAccountController */
/* @var $model LedgerAccount */

$this->breadcrumbs=array(
	'Ledger Accounts'=>array('admin'),
);
?>

<div class="row">
	<div class="col-md-12">
		<div class="block">
			<div class="block-title">
				<h2>Ledger Accounts</h2>
			</div>
			<div class="block-content">
				<div class="pull-right">
					<?php echo CHtml::link('Create Ledger Account', array('create'), array('class'=>'btn btn-primary')); ?>
				</div>

				<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'ledger-account-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'itemsCssClass'=>'table table-bordered table-striped',
	'columns'=>array(
		'id',
		'name',
		array(
			'name'=>'type',
			'value'=>'isset(LedgerAccount::typeOptions()[$data->type]) ? LedgerAccount::typeOptions()[$data->type] : $data->type',
			'filter'=>LedgerAccount::typeOptions(),
		),
		array(
			'name'=>'opening_fine_wt',
			'value'=>'number_format((float)$data->opening_fine_wt, 3, ".", "")',
		),
		array(
			'name'=>'opening_amount',
			'value'=>'number_format((float)$data->opening_amount, 2, ".", "")',
		),
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

