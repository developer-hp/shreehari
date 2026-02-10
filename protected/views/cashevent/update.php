<?php
/* @var $this CasheventController */
/* @var $model Cashevent */

$this->breadcrumbs=array(
	'Cashevents'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Cashevent', 'url'=>array('index')),
	array('label'=>'Create Cashevent', 'url'=>array('create')),
	array('label'=>'View Cashevent', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Cashevent', 'url'=>array('admin')),
);
?>

<!-- <h1>Update Cashevent <?php // echo $model->id; ?></h1> -->

<?php $this->renderPartial('_form', array('model'=>$model,'cash_log_type'=>$cash_log_type)); ?>