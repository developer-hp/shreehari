<?php
/* @var $this CasheventController */
/* @var $model Cashevent */
/* @var $form CActiveForm */
?>
<?php 
Yii::app()->clientScript->scriptMap['jquery.js'] = false;
Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
?>
<?php $title="Cash";?>

<!-- <div class="content-header">
    <div class="row">
     
        <div class="col-sm-6 hidden-xs">
            <div class="header-section">
                <ul class="breadcrumb breadcrumb-top">
             
                    <input type="hidden" class="test" value="<?php // echo $model->isNewRecord ? 'Create' : 'Edit'; ?>">
                </ul>
            </div>
        </div>
    </div>
</div> -->

<div class="row">
    <div class="col-md-12">
     <!-- Horizontal Form Block -->
        <div class="block">
             
            <!-- Horizontal Form Title -->
           <!--  <div class="block-title">
                <h2><?php // echo $model->isNewRecord ? Yii::t('yii','Create') : Yii::t('yii','Edit'); ?> <?php // echo $title;?></h2>
            </div> -->

              <?php if (Yii::app()->user->hasFlash('success')): ?>
                <div class="alert alert-success alert-dismissable">
                    <p><?php echo Yii::app()->user->getFlash('success'); ?></p>
                </div>
                <?php endif; ?> 

					<?php $form=$this->beginWidget('CActiveForm', array(
						'id'=>'customer-form',
						'enableAjaxValidation' => true,
						    'htmlOptions' => array('class' => 'form-horizontal form-bordered', 'enctype' => 'multipart/form-data'),
						    'clientOptions' => array(
						        'validateOnSubmit' => true,
						    ),
						    'errorMessageCssClass' => 'help-block animation-slideUp form-error',
						// 'enableAjaxValidation'=>false,
					)); ?>
					
						<div class="form-group">
							<?php echo $form->labelEx($model,'name', array('class' => 'col-md-3 control-label')); ?>
							<div class="col-md-7">
							<?php echo $form->textField($model,'name', array('class' => 'form-control','autocomplete'=>'off')); ?>
							<?php echo $form->error($model,'name'); ?>
							</div>
						</div>


					<div class="form-group">
							<?php echo $form->labelEx($model,'mobile', array('class' => 'col-md-3 control-label')); ?>
							<div class="col-md-7">
							<?php echo $form->textField($model,'mobile', array('class' => 'form-control','maxlength'=>13,'autocomplete'=>'off')); ?>
							<?php echo $form->error($model,'mobile'); ?>
							</div>
						</div>
				
						<div class="form-group">
							<?php echo $form->labelEx($model,'address', array('class' => 'col-md-3 control-label')); ?>
							<div class="col-md-7">
							<?php echo $form->textField($model,'address', array('class' => 'form-control','autocomplete'=>'off')); ?>
							<?php echo $form->error($model,'address'); ?>
							</div>
						</div>

						<div class="form-group">
							<?php echo $form->labelEx($model,'type', array('class' => 'col-md-3 control-label')); ?>
							<div class="col-md-7">
							<?php // echo $form->textArea($model,'type', array('class' => 'form-control')); 
							$cust_type=array(1=>'Supplier',2=>'Customer',3=>'Karigar');
							echo $form->dropDownList($model,'type',$cust_type,
											array(
												'prompt'=>'----Select Type----',
												'class'=>'form-control',
											)); 
							?>
							<?php echo $form->error($model,'type'); ?>
							</div>
						</div>
					

					<div class="form-group form-actions">
				        <div class="col-md-9 col-md-offset-3">
				            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('yii','Save') : Yii::t('yii','Save'), array('class' => 'btn btn-effect-ripple btn-primary submit save_tech')); ?>
				            <button type="button" class="btn btn-danger" data-dismiss="modal" style="margin-left: 5px;">Close</button>
				            <?php // echo CHtml::link(Yii::t('yii','Cancel'), array('admin'), array('class' => 'btn btn-effect-ripple btn-danger')) ?>
				        </div>
				    </div>
				<?php $this->endWidget(); ?>
			</div>
	</div>
</div>


		
				
					
