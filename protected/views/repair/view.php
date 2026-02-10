<?php
/* @var $this OrderbooksController */
/* @var $model Orderbooks */

$this->breadcrumbs=array(
	'Orderbooks'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Orderbooks', 'url'=>array('index')),
	array('label'=>'Create Orderbooks', 'url'=>array('create')),
	array('label'=>'Update Orderbooks', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Orderbooks', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Orderbooks', 'url'=>array('admin')),
);
?>

<h1>View Orderbooks #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'ref_no',
		'name',
		'mobile',
		'date',
		'type',
	),
)); ?>
