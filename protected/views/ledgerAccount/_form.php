<?php
/* @var $this LedgerAccountController */
/* @var $model LedgerAccount */
/* @var $form CActiveForm */

$typeOptions = LedgerAccount::typeOptions();
$drcrOptions = LedgerAccount::drcrOptions();
$partyOptions = CHtml::listData(Customer::model()->findAllByAttributes(array('is_deleted'=>0), array('order'=>'name asc')), 'id', 'name');
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ledger-account-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('class' => 'form-horizontal'),
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'name', array('class' => 'col-md-3 control-label')); ?>
		<div class="col-md-6">
			<?php echo $form->textField($model,'name',array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'name'); ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'type', array('class' => 'col-md-3 control-label')); ?>
		<div class="col-md-3">
			<?php echo $form->dropDownList($model,'type',$typeOptions,array('class'=>'form-control','prompt'=>'-- Select --')); ?>
			<?php echo $form->error($model,'type'); ?>
		</div>
		<?php echo $form->labelEx($model,'party_customer_id', array('class' => 'col-md-2 control-label')); ?>
		<div class="col-md-4">
			<?php echo $form->dropDownList($model,'party_customer_id',$partyOptions,array('class'=>'form-control','prompt'=>'-- Optional --')); ?>
			<?php echo $form->error($model,'party_customer_id'); ?>
		</div>
	</div>

	<hr>
	<h4>Opening Balance</h4>

	<div class="form-group">
		<?php echo $form->labelEx($model,'opening_fine_wt', array('class' => 'col-md-3 control-label')); ?>
		<div class="col-md-3">
			<?php echo $form->textField($model,'opening_fine_wt',array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'opening_fine_wt'); ?>
		</div>
		<?php echo $form->labelEx($model,'opening_fine_wt_drcr', array('class' => 'col-md-2 control-label')); ?>
		<div class="col-md-2">
			<?php echo $form->dropDownList($model,'opening_fine_wt_drcr',$drcrOptions,array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'opening_fine_wt_drcr'); ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'opening_amount', array('class' => 'col-md-3 control-label')); ?>
		<div class="col-md-3">
			<?php echo $form->textField($model,'opening_amount',array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'opening_amount'); ?>
		</div>
		<?php echo $form->labelEx($model,'opening_amount_drcr', array('class' => 'col-md-2 control-label')); ?>
		<div class="col-md-2">
			<?php echo $form->dropDownList($model,'opening_amount_drcr',$drcrOptions,array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'opening_amount_drcr'); ?>
		</div>
	</div>

	<div class="form-group form-actions">
		<div class="col-md-9 col-md-offset-3">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Save' : 'Update', array('class'=>'btn btn-effect-ripple btn-primary')); ?>
			<?php echo CHtml::link('Back', array('admin'), array('class'=>'btn btn-effect-ripple btn-danger')); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

