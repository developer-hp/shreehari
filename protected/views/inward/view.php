<?php
/* @var $this InwardController */
/* @var $model Inward */

$this->breadcrumbs=array(
	'Inwards'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Inward', 'url'=>array('index')),
	array('label'=>'Create Inward', 'url'=>array('create')),
	array('label'=>'Update Inward', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Inward', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Inward', 'url'=>array('admin')),
);
?>

<h1>View Inward #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'customer_id',
		'bill_no',
		'bill_date',
		'gross_wt',
		'net_wt',
		'fine_wt',
		'other_wt',
		'gold_amount',
		'other_amount',
		'note',
		'created_date',
		'updated_date',
	),
)); ?>
