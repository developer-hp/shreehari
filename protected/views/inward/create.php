<?php
/* @var $this InwardController */
/* @var $model Inward */

$this->breadcrumbs=array(
	'Inwards'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Inward', 'url'=>array('index')),
	array('label'=>'Manage Inward', 'url'=>array('admin')),
);
?>

<h1>Create Inward</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>