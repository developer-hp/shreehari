<?php
/* @var $this InwardController */
/* @var $model Inward */

$this->breadcrumbs=array(
	'Inwards'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Inward', 'url'=>array('index')),
	array('label'=>'Create Inward', 'url'=>array('create')),
	array('label'=>'View Inward', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Inward', 'url'=>array('admin')),
);
?>

<h1>Update Inward <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>