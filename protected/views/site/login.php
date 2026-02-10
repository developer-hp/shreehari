<div class="block animation-fadeInQuick">
    <!-- Login Title -->
    <div class="block-title">
        <h2>Please Login</h2>
    </div>

    <?php
        foreach(Yii::app()->user->getFlashes() as $key => $message) {
            echo '<div class="info alert alert-' . $key . '">' . $message . "</div>\n";
        }
    ?>
    <!-- END Login Title -->

    <?php
    /* @var $this SiteController */
    /* @var $model LoginForm */
    /* @var $form CActiveForm  */

    $this->pageTitle = Yii::app()->name . ' - Login';
    $this->breadcrumbs = array(
        'Login',
    );
    ?>

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'form-login',
        // 'enableClientValidation' => true,
        'htmlOptions' => array('class' => 'form-horizontal'),
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),
        'errorMessageCssClass'=>'help-block animation-slideUp form-error',
    ));
    ?>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'username', array('class' => 'col-xs-12')); ?>
        <div class="col-xs-12">
            <?php echo $form->textField($model, 'username', array('class' => 'form-control')); ?>
            <?php // echo $form->error($model, 'username'); ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'password', array('class' => 'col-xs-12')); ?>
        <div class="col-xs-12">
            <?php echo $form->passwordField($model, 'password', array('class' => 'form-control')); ?>
            <?php echo $form->error($model, 'password'); ?>
        </div>
    </div>

    
    <div class="form-group form-actions">
        <div class="col-xs-7" style="margin-top: 10px; ">
            <?php  echo CHtml::link('Forgot Password?',array('forgot'),array('class'=>'')); ?>
            <!-- <label class="csscheckbox csscheckbox-primary">
                <?php // echo $form->checkBox($model, 'rememberMe'); ?><span></span> <?php // echo $form->label($model, 'rememberMe'); ?>
            </label> -->
        </div>
        <div class="col-xs-5 text-right">
                <div class="col-xs-12" style="margin-bottom: 3px;">
                    <?php echo CHtml::submitButton('Log-in',array('class'=>'btn btn-effect-ripple btn-sm btn-success')); ?>
                </div>
                     <?php // echo CHtml::link('Forgot Password?',array('forgot'),array('class'=>'')); ?>
                    <?php // echo CHtml::submitButton('Log-in',array('class'=>'btn btn-effect-ripple btn-sm btn-success')); ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>

      <!--   <script type="text/javascript">
             $('.info').addClass('alert alert-success');
               // $('.info').show();
                    window.setTimeout(function () {
                    $(".alert-success").fadeTo(500, 10).slideUp(500, function () {
                $(this).hide();
                  $(this).css('opacity','100');
                    });
                    }, 5000);
        </script>

         <script type="text/javascript">
             $('.info').addClass('alert alert-danger');
               // $('.info').show();
                    window.setTimeout(function () {
                    $(".alert-danger").fadeTo(500, 10).slideUp(500, function () {
                $(this).hide();
                  $(this).css('opacity','100');
                    });
                    }, 5000);
        </script> -->