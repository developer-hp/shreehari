<?php
/* @var $this InwardController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Inwards',
);

$this->menu=array(
	array('label'=>'Create Inward', 'url'=>array('create')),
	array('label'=>'Manage Inward', 'url'=>array('admin')),
);
?>

<h1>Inwards</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
