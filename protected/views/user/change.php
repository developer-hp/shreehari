<div class="content-header">
    <div class="row">
        <div class="col-sm-6">
            <div class="header-section">
                <h1>Profile</h1>
            </div>
        </div>
        <div class="col-sm-6 hidden-xs">
            <div class="header-section">
                <ul class="breadcrumb breadcrumb-top">
                    <li>Dashboard</li>
                    <li><a href="#">Profile</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="row">
    <div class="col-md-12">
        <!-- Horizontal Form Block -->
        <div class="block">
            <!-- Horizontal Form Title -->
            <div class="block-title">
                <h2>Profile</h2>
            </div>
            <!-- END Horizontal Form Title -->
            <?php if (Yii::app()->user->hasFlash('success')): ?>
            <div class="alert alert-success alert-dismissable animation-fadeIn">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><strong>Success</strong></h4>
                <p><?php echo Yii::app()->user->getFlash('success'); ?></p>
            </div>
            <?php endif; ?>

            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'user-form',
                'enableAjaxValidation' => true,
                'htmlOptions' => array('class' => 'form-horizontal form-bordered'),
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'errorMessageCssClass' => 'help-block animation-slideUp form-error',
                    // Please note: When you enable ajax validation, make sure the corresponding
                    // controller action is handling ajax validation correctly.
                    // There is a call to performAjaxValidation() commented in generated controller code.
                    // See class documentation of CActiveForm for details on this.
            ));
            ?>

            <div class="form-group">
                <?php echo $form->labelEx($model, 'name', array('class' => 'col-md-3 control-label')); ?>
                <div class="col-md-6">
                    <?php echo $form->textField($model, 'name', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'name'); ?>
                </div>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model, 'email', array('class' => 'col-md-3 control-label')); ?>
                <div class="col-md-6">
                    <?php echo $form->textField($model, 'email', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'email'); ?>
                </div>
            </div>

            <div class="form-group">
                <?php echo $form->labelEx($model, 'password', array('class' => 'col-md-3 control-label')); ?>
                <div class="col-md-6">
                    <?php echo $form->passwordField($model, 'password', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'password'); ?>
                </div>
            </div>
            <div class="form-group">
                <?php echo $form->labelEx($model, 'confirmPassword', array('class' => 'col-md-3 control-label')); ?>
                <div class="col-md-6">
                    <?php echo $form->passwordField($model, 'confirmPassword', array('class' => 'form-control', 'size' => 60, 'maxlength' => 255)); ?>
                    <?php echo $form->error($model, 'confirmPassword'); ?>
                </div>
            </div>
            <div class="form-group form-actions">
                <div class="col-md-9 col-md-offset-3">
                    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-effect-ripple btn-primary')); ?>
                </div>
            </div>
            <?php $this->endWidget(); ?>

        </div><!-- form -->
    </div>
</div>

 <script type="text/javascript">
            
            $('body').on('keydown', '#user-form input , #user-form select', function(e) {
                if (e.key === "Enter") {
                    var self = $(this), form = self.parents('form:eq(0)'), focusable, next;
                    focusable = form.find('input,a,select,button,textarea').filter(':visible');
                    next = focusable.eq(focusable.index(this)+1);
                    if (next.length) {
                        next.focus();
                    } else {
                        form.submit();
                    }
                    return false;
                }
            });
        </script>