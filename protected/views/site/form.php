<?php
/* @var $this EventsController */
/* @var $model Event */
/* @var $form CActiveForm */
    $appsetting = $this->getsettings();
?>
<div class="row">
    <div class="col-md-12">
        <!-- Horizontal Form Block -->
        <div class="block">
            <!-- Horizontal Form Title -->
            <div class="block-title">
                <h2><?php echo $model->title; ?> </h2>
            </div>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'forms-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'htmlOptions' => array('class' => 'form-horizontal','enctype'=>'multipart/form-data'),
    'errorMessageCssClass' => 'help-block animation-slideUp form-error',
)); ?>

	<?php
		foreach ($questions as $key => $value) {
	?>

	<div class="form-group">
		<label class="col-md-4  control-label"><?php echo $value->question_text;?></label>		
		<div class="col-md-6">
		<input name="answer[<?php echo $value->id; ?>]" class="form-control">
		<span class="help-block"><?php 
		if($value->answer_hint)
		echo '(FOR EXAMPLE: '.$value->answer_hint.')';?></span>
		</div>
	</div>
	<?php } ?>

	<div class="form-group form-actions">
        <div class="col-md-7 col-md-offset-4">
        <?php echo CHtml::submitButton($appsetting['GENERATE_BUTTON_TEXT'], array('class' => 'btn btn-effect-ripple btn-primary')); ?>
        </div>
    </div>

	<?php $this->endWidget(); ?>

</div>
</div>
</div>