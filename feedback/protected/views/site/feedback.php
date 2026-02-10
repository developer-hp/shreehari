<style type="text/css">
    .change_color{color:black;}
    /*.change_error_color{color: red;}*/
</style>

<section class="site-content site-section">
    <!-- <div class="container"> -->
        <!-- Forms Row -->
         <?php if (Yii::app()->user->hasFlash('success')): ?>
                <div class="info_success alert alert-success alert-dismissable">
                    <p><?php echo Yii::app()->user->getFlash('success'); ?></p>
                </div>
            <?php endif; ?>

            <div class="row">

            <div class="col-md-8 col-md-offset-2">
                
                 <?php $form=$this->beginWidget('CActiveForm', array(
                        'id'=>'user-form',
                        
                        'htmlOptions' => array('enctype' => 'multipart/form-data','class' => 'form form-horizontal form-bordered'),
                        'enableAjaxValidation'=>true,
                                'clientOptions' => array(
                                           'validateOnSubmit' => true,
                                        ),
                                         'errorMessageCssClass' => 'help-block animation-slideUp form-error'
                    )); ?>


                    <div class="form-group">
                        <?php echo $form->labelEx($model,'name',array('class'=>'col-md-3 control-label change_color') ); ?>
                          <div class="col-md-9">
                                <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
                                <?php echo $form->error($model,'name', array('style'=>'color:#de815c;')); ?>
                        </div>
                    </div>

                     <div class="form-group">
                        <?php echo $form->labelEx($model,'mobile_1',array('class'=>'col-md-3 control-label change_color') ); ?>
                          <div class="col-md-9">
                                <?php echo $form->textField($model,'mobile_1',array('size'=>60,'maxlength'=>13,'class'=>'form-control')); ?>
                                <?php echo $form->error($model,'mobile_1' , array('style'=>'color:#de815c;')); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo $form->labelEx($model,'mobile_2',array('class'=>'col-md-3 control-label change_color') ); ?>
                          <div class="col-md-9">
                                <?php echo $form->textField($model,'mobile_2',array('size'=>60,'maxlength'=>13,'class'=>'form-control')); ?>
                                <?php echo $form->error($model,'mobile_2' , array('style'=>'color:#de815c;')); ?>
                        </div>
                    </div>

                     <div class="form-group">
                        <?php echo $form->labelEx($model,'email',array('class'=>'col-md-3 control-label change_color') ); ?>
                          <div class="col-md-9">
                                <?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
                                <?php echo $form->error($model,'email',array('style'=>'color:#de815c;')); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo $form->labelEx($model,'address',array('class'=>'col-md-3 control-label change_color') ); ?>
                          <div class="col-md-9">
                                <?php echo $form->textArea($model,'address',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
                                <?php echo $form->error($model,'address', array('style'=>'color:#de815c;')); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo $form->labelEx($model,'birthdate',array('class'=>'col-md-3 control-label change_color') ); ?>
                          <div class="col-md-9">
                                <?php echo $form->textField($model,'birthdate',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
                                <?php echo $form->error($model,'birthdate', array('style'=>'color:#de815c;')); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo $form->labelEx($model,'anniversary_date',array('class'=>'col-md-3 control-label change_color') ); ?>
                          <div class="col-md-9">
                                <?php echo $form->textField($model,'anniversary_date',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
                                <?php echo $form->error($model,'anniversary_date', array('style'=>'color:#de815c;')); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php echo $form->labelEx($model,'suggestion',array('class'=>'col-md-3 control-label change_color') ); ?>
                          <div class="col-md-9">
                                <?php echo $form->textArea($model,'suggestion',array('size'=>60,'maxlength'=>255,'class'=>'form-control')); ?>
                                <?php echo $form->error($model,'suggestion', array('style'=>'color:#de815c;')); ?>
                        </div>
                    </div>


                     

                <div class="form-group" style="margin-left: 250px; margin-bottom:30px; ">
                        <?php echo CHtml::submitButton($model->isNewRecord ? 'Submit' : 'Save',['id' => 'submit','class'=>'btn btn-effect-ripple btn-primary']); ?>
                </div>                  
    
                     <?php $this->endWidget(); ?>

                 </div>

            </div>
        </div>
        <!-- END Forms Row -->
    <!-- </div> -->
</section>