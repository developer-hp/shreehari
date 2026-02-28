<?php
/* @var $this EventsController */
/* @var $model Event */
/* @var $form CActiveForm */
?>

<div class="row">
    <div class="col-md-12">
        <!-- Horizontal Form Block -->
        <div class="block">
            <!-- Horizontal Form Title -->
            <div class="block-title">
                <h2><?php echo $model->isNewRecord ? 'Add User' : 'Update '.$model->name; ?> </h2>
            </div>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
	'htmlOptions' => array('class' => 'form-horizontal','enctype'=>'multipart/form-data'),
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'errorMessageCssClass' => 'help-block animation-slideUp form-error',
)); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model, 'name', array('class' => 'col-md-3  control-label')); ?>
		<div class="col-md-6">
		<?php echo $form->textField($model,'name',array('maxlength'=>100,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'name'); ?>
		</div>
	</div>
	<div class="form-group">
		<?php echo $form->labelEx($model, 'email', array('class' => 'col-md-3  control-label')); ?>
		<div class="col-md-6">
		<?php echo $form->textField($model,'email',array('maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'email'); ?>
		</div>
	</div>
	<div class="form-group">
		<?php echo $form->labelEx($model, 'user_type', array('class' => 'col-md-3  control-label')); ?>
		<div class="col-md-6">
		<?php echo $form->dropDownList($model,'user_type',User::getUserTypeOptions(),array('class'=>'form-control','prompt'=>'Select User Type')); ?>
		<?php echo $form->error($model,'user_type'); ?>
		</div>
	</div>
	<?php
	if(!$model->isNewRecord):
	?>
	<div class="form-group">
		<?php echo $form->labelEx($model, 'password', array('class' => 'col-md-3  control-label')); ?>
		<div class="col-md-6">
		<?php echo $form->passwordField($model,'password',array('maxlength'=>255,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'password'); ?>
		</div>
	</div>
	<?php
	endif;
	?>

	<div class="form-group form-actions">
        <div class="col-md-9 col-md-offset-3">
        <?php echo CHtml::link('Cancel', array('index'), array('class' => 'btn btn-effect-ripple btn-danger')) ?>
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Save' : 'Save', array('class' => 'btn btn-effect-ripple btn-primary')); ?>
        </div>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->

</div>
</div>
