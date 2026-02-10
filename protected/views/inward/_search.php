<?php
/* @var $this InwardController */
/* @var $model Inward */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'customer_id'); ?>
		<?php echo $form->textField($model,'customer_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'bill_no'); ?>
		<?php echo $form->textField($model,'bill_no',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'bill_date'); ?>
		<?php echo $form->textField($model,'bill_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'gross_wt'); ?>
		<?php echo $form->textField($model,'gross_wt'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'net_wt'); ?>
		<?php echo $form->textField($model,'net_wt'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fine_wt'); ?>
		<?php echo $form->textField($model,'fine_wt'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'other_wt'); ?>
		<?php echo $form->textField($model,'other_wt'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'gold_amount'); ?>
		<?php echo $form->textField($model,'gold_amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'other_amount'); ?>
		<?php echo $form->textField($model,'other_amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'note'); ?>
		<?php echo $form->textArea($model,'note',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created_date'); ?>
		<?php echo $form->textField($model,'created_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'updated_date'); ?>
		<?php echo $form->textField($model,'updated_date'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->