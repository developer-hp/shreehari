<?php
/* @var $this SupplierTxnController */
/* @var $model SupplierTxn */

$this->breadcrumbs=array(
	'Supplier Txn'=>array('admin'),
);
?>

<div class="row">
	<div class="col-md-12">
		<div class="block">
			<div class="block-title">
				<h2>Supplier Transactions</h2>
			</div>
			<div class="block-content">
				<div class="pull-right">
					<?php echo CHtml::link('Create Supplier Txn', array('create'), array('class'=>'btn btn-primary')); ?>
				</div>

				<div class="alert alert-info" style="margin-top:10px;">
					<strong>Print ledger:</strong>
					Use `supplierTxn/printLedger?supplier_account_id=...&start=YYYY-MM-DD&end=YYYY-MM-DD`
				</div>

				<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'supplier-txn-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'itemsCssClass'=>'table table-bordered table-striped',
	'columns'=>array(
		'id',
		'sr_no',
		array(
			'name'=>'txn_date',
			'value'=>'$data->txn_date',
		),
		array(
			'name'=>'supplier_account_id',
			'value'=>'$data->supplierAccount ? $data->supplierAccount->name : ""',
			'filter'=>CHtml::listData(LedgerAccount::model()->findAllByAttributes(array("type"=>LedgerAccount::TYPE_SUPPLIER,"is_deleted"=>0), array("order"=>"name asc")),"id","name"),
		),
		array(
			'header'=>'Fine Wt',
			'value'=>'number_format($data->getTotalFineWt(), 3, ".", "")',
		),
		array(
			'header'=>'Charge Amt',
			'value'=>'number_format($data->getTotalChargeAmount(), 2, ".", "")',
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

