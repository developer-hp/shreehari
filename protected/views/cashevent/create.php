<?php
/* @var $this CasheventController */
/* @var $model Cashevent */

$this->breadcrumbs=array(
	'Cashevents'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Cashevent', 'url'=>array('index')),
	array('label'=>'Manage Cashevent', 'url'=>array('admin')),
);
?>

<!-- <h1>Create Cashevent</h1> -->

<?php $this->renderPartial('_form', array('model'=>$model,'cash_log'=>$cash_log)); ?>