<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'subitem-type-form',
    'enableAjaxValidation' => true,
    'htmlOptions' => array('class' => 'form-horizontal'),
)); ?>
<div class="form-group">
    <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-2 control-label')); ?>
    <div class="col-sm-4">
        <?php echo $form->textField($model, 'name', array('class' => 'form-control', 'size' => 60, 'maxlength' => 100)); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>
</div>
<div class="form-group">
    <?php echo $form->labelEx($model, 'sort_order', array('class' => 'col-sm-2 control-label')); ?>
    <div class="col-sm-4">
        <?php echo $form->numberField($model, 'sort_order', array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'sort_order'); ?>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-primary')); ?>
        <?php echo CHtml::link('Cancel', array('subitemType/admin'), array('class' => 'btn btn-default')); ?>
    </div>
</div>
<?php $this->endWidget(); ?>
