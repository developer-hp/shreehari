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
                <h2><?php echo $model->isNewRecord ? 'Add Form' : 'Update '.$model->title; ?> </h2>
            </div>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'setting-form',
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
		<?php echo $form->labelEx($model, 'title', array('class' => 'col-md-3  control-label')); ?>
		<div class="col-md-6">
		<?php echo $form->textField($model,'title',array('readOnly'=>true,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'title'); ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model, 'content', array('class' => 'col-md-3  control-label')); ?>
		<div class="col-md-9">
		<?php 
		if($model->title=="REGISTER_MAIL_CONTENT" || $model->title=="DASHBOARD_PAGE"){
			echo $form->textArea($model,'content',array('class'=>'form-control ckeditor')); 
			if($model->title=="REGISTER_MAIL_CONTENT")
			echo  "<p> Tags : {{name}}, {{username}}, {{password}}, {{link}}</p>";
		}
		else if($model->title=="LOGO" || $model->title=="LOGIN_BACKGROUND" || $model->title=="FAV_ICON"){
			// echo $form->fileField($model,'content',array('class'=>'form-control')); 
			echo "<input type='file' name='content'>";
		}
		else
			echo $form->textField($model,'content',array('class'=>'form-control')); 

	?>
		<?php echo $form->error($model,'content'); ?>
		</div>
	</div>

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

