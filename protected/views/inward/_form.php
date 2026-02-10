<?php
/* @var $this InwardController */
/* @var $model Inward */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'inward-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'customer_id'); ?>
		<?php echo $form->textField($model,'customer_id'); ?>
		<?php echo $form->error($model,'customer_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'bill_no'); ?>
		<?php echo $form->textField($model,'bill_no',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'bill_no'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'bill_date'); ?>
		<?php echo $form->textField($model,'bill_date'); ?>
		<?php echo $form->error($model,'bill_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'gross_wt'); ?>
		<?php echo $form->textField($model,'gross_wt'); ?>
		<?php echo $form->error($model,'gross_wt'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'net_wt'); ?>
		<?php echo $form->textField($model,'net_wt'); ?>
		<?php echo $form->error($model,'net_wt'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fine_wt'); ?>
		<?php echo $form->textField($model,'fine_wt'); ?>
		<?php echo $form->error($model,'fine_wt'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'other_wt'); ?>
		<?php echo $form->textField($model,'other_wt'); ?>
		<?php echo $form->error($model,'other_wt'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'gold_amount'); ?>
		<?php echo $form->textField($model,'gold_amount'); ?>
		<?php echo $form->error($model,'gold_amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'other_amount'); ?>
		<?php echo $form->textField($model,'other_amount'); ?>
		<?php echo $form->error($model,'other_amount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'note'); ?>
		<?php echo $form->textArea($model,'note',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'note'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created_date'); ?>
		<?php echo $form->textField($model,'created_date'); ?>
		<?php echo $form->error($model,'created_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'updated_date'); ?>
		<?php echo $form->textField($model,'updated_date'); ?>
		<?php echo $form->error($model,'updated_date'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->