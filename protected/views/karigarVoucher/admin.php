<?php
/* @var $this KarigarVoucherController */
/* @var $model KarigarVoucher */

$this->breadcrumbs=array(
	'Karigar Voucher'=>array('admin'),
);
?>

<div class="row">
	<div class="col-md-12">
		<div class="block">
			<div class="block-title">
				<h2>Karigar Jama Vouchers</h2>
			</div>
			<div class="block-content">
				<div class="pull-right">
					<?php echo CHtml::link('Ledger Report', array('ledger'), array('class'=>'btn btn-default')); ?>
					<?php echo CHtml::link('Create Voucher', array('create'), array('class'=>'btn btn-primary')); ?>
				</div>

				<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'karigar-voucher-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'itemsCssClass'=>'table table-bordered table-striped',
	'columns'=>array(
		'id',
		'sr_no',
		'voucher_date',
		array(
			'name'=>'karigar_account_id',
			'value'=>'$data->karigarAccount ? $data->karigarAccount->name : ""',
			'filter'=>CHtml::listData(LedgerAccount::model()->findAllByAttributes(array("type"=>LedgerAccount::TYPE_KARIGAR,"is_deleted"=>0), array("order"=>"name asc")),"id","name"),
		),
		array(
			'header'=>'Fine Wt',
			'value'=>'number_format($data->getTotalFineWt(), 3, ".", "")',
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

