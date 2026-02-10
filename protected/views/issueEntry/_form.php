<?php
/* @var $this IssueEntryController */
/* @var $model IssueEntry */
/* @var $form CActiveForm */

$accountOptions = CHtml::listData(
	LedgerAccount::model()->findAllByAttributes(array('is_deleted'=>0), array('order'=>'type asc, name asc')),
	'id',
	'name'
);
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'issue-entry-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'issue_date', array('class' => 'col-md-3 control-label')); ?>
		<div class="col-md-3">
			<?php echo $form->textField($model,'issue_date',array('class'=>'form-control','placeholder'=>'YYYY-MM-DD')); ?>
			<?php echo $form->error($model,'issue_date'); ?>
		</div>
		<?php echo $form->labelEx($model,'account_id', array('class' => 'col-md-2 control-label')); ?>
		<div class="col-md-4">
			<?php echo $form->dropDownList($model,'account_id',$accountOptions,array('class'=>'form-control','prompt'=>'-- Select Account --')); ?>
			<?php echo $form->error($model,'account_id'); ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'sr_no', array('class' => 'col-md-3 control-label')); ?>
		<div class="col-md-3">
			<?php echo $form->textField($model,'sr_no',array('class'=>'form-control','placeholder'=>'Auto')); ?>
			<div class="help-block">Leave empty to auto-generate.</div>
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'fine_wt', array('class' => 'col-md-3 control-label')); ?>
		<div class="col-md-3">
			<?php echo $form->textField($model,'fine_wt',array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'fine_wt'); ?>
		</div>
		<?php echo $form->labelEx($model,'amount', array('class' => 'col-md-2 control-label')); ?>
		<div class="col-md-4">
			<?php echo $form->textField($model,'amount',array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'amount'); ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'remarks', array('class' => 'col-md-3 control-label')); ?>
		<div class="col-md-9">
			<?php echo $form->textArea($model,'remarks',array('class'=>'form-control','rows'=>2)); ?>
			<?php echo $form->error($model,'remarks'); ?>
		</div>
	</div>

	<div class="form-group form-actions">
		<div class="col-md-9 col-md-offset-3">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Save' : 'Update', array('class'=>'btn btn-effect-ripple btn-primary')); ?>
			<?php echo CHtml::link('Back', array('admin'), array('class'=>'btn btn-effect-ripple btn-danger')); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

