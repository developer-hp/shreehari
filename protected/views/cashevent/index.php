<?php
/* @var $this CasheventController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Cashevents',
);

$this->menu=array(
	array('label'=>'Create Cashevent', 'url'=>array('create')),
	array('label'=>'Manage Cashevent', 'url'=>array('admin')),
);
?>

<h1>Cashevents</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
