<?php
/* @var $this CustomerController */
/* @var $model Customer */
/* @var $form CActiveForm */
?>



<?php 

 $action = strtolower(Yii::app()->controller->action->id);
	 if($action == 'create_supplier')
	 {
		$title="Supllier";
	 }
	 if($action == 'create_customer')
	 {
		$title="Customer";
	 }
	 if($action == 'create_karigar')
	 {
		$title="Karigar";
	 }
	 if($action == 'update_supplier')
	 {
		$title="Supllier";
	 }
	 if($action == 'update_customer')
	 {
		$title="Customer";
	 }
	 if($action == 'update_karigar')
	 {
		$title="Karigar";
	 }
	 
?>

<div class="content-header">
    <div class="row">
        <div class="col-sm-6">
            <div class="header-section">
                <h1><?php echo $title;?></h1>
            </div>
        </div>
        <div class="col-sm-6 hidden-xs">
            <div class="header-section">
                <ul class="breadcrumb breadcrumb-top">
                    <?php 
                     $action=Yii::app()->controller->action->id;
                      if($action!='add'):?>
                        <li><?php                    
                           echo CHtml::link($title, array());
                          ?></li>
                    <?php endif;?>
                    <li><?php echo $model->isNewRecord ? Yii::t('yii','Create') : Yii::t('yii','Edit'); ?></li>
                    <input type="hidden" class="test" value="<?php echo $model->isNewRecord ? 'Create' : 'Edit'; ?>">
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
     <!-- Horizontal Form Block -->
        <div class="block">
            
            <!-- Horizontal Form Title -->
            <div class="block-title">
                <h2><?php echo $model->isNewRecord ? Yii::t('yii','Create') : Yii::t('yii','Edit'); ?> <?php echo $title;?></h2>
            </div>

              <?php if (Yii::app()->user->hasFlash('success')): ?>
                <div class="alert alert-success alert-dismissable">
                    <p><?php echo Yii::app()->user->getFlash('success'); ?></p>
                </div>
                <?php endif; ?> 

<!-- <div class="form"> -->

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'customer-form',
	'enableAjaxValidation' => true,
			    'htmlOptions' => array('class' => 'form-horizontal form-bordered', 'enctype' => 'multipart/form-data'),
			    'clientOptions' => array(
			        'validateOnSubmit' => true,
			    ),
			    'errorMessageCssClass' => 'help-block animation-slideUp form-error',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	//'enableAjaxValidation'=>false,
)); ?>

<!-- 	<p class="note">Fields with <span class="required">*</span> are required.</p>
 -->
	<?php // echo $form->errorSummary($model); ?>

			<div class="form-group">
				<?php echo $form->labelEx($model,'name', array('class' => 'col-md-2 control-label')); ?>
				<div class="col-md-6">
				<?php echo $form->textField($model,'name', array('class' => 'form-control','autocomplete'=>'off')); ?>
				<?php echo $form->error($model,'name'); ?>
				</div>
			</div>


		<div class="form-group">
				<?php echo $form->labelEx($model,'mobile', array('class' => 'col-md-2 control-label')); ?>
				<div class="col-md-6">
				<?php echo $form->textField($model,'mobile', array('class' => 'form-control','maxlength'=>13,'autocomplete'=>'off')); ?>
				<?php echo $form->error($model,'mobile'); ?>
				</div>
			</div>
	
			<div class="form-group">
				<?php echo $form->labelEx($model,'address', array('class' => 'col-md-2 control-label')); ?>
				<div class="col-md-6">
				<?php echo $form->textArea($model,'address', array('class' => 'form-control','autocomplete'=>'off')); ?>
				<?php echo $form->error($model,'address'); ?>
				</div>
			</div>

			<?php
				if($model->isNewRecord)
				{
					$action = strtolower(Yii::app()->controller->action->id);
					if($action == 'create_supplier')
					{
						 //echo "create";
						$model->type=1;
						$redirect_action = "list_supplier";

					}
					if($action == 'create_customer')
					{
						// echo "create_customer";
						$model->type=2;
						$redirect_action = "list_customer";
					}
					if($action == 'create_karigar')
					{
						// echo "create_karigar";
						$model->type=3;
						$redirect_action = "list_karigar";
					}

				?>	
				<div class="form-group">
					<?php echo $form->labelEx($model,'type', array('class' => 'col-md-2 control-label')); ?>
					<div class="col-md-6">
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
				<?php
				}
				else
				{
				?>
					<div class="form-group">
				<?php echo $form->labelEx($model,'type', array('class' => 'col-md-2 control-label')); ?>
				<div class="col-md-6">
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
				<?php
				}
			?>
	
			<?php 
			$redirect_action = "";
				$action1 = strtolower(Yii::app()->controller->action->id);
					if($action1 == 'update_supplier')
					{
						$redirect_action = "list_supplier";
					}
					if($action1 == 'update_customer')
					{
						$redirect_action = "list_customer";
					}
					if($action1 == 'update_karigar')
					{
					    $redirect_action = "list_karigar";
					}
					if($action1 == 'create_supplier')
					{
						$redirect_action = "list_supplier";
					}
					if($action1 == 'create_customer')
					{
						$redirect_action = "list_customer";
					}
					if($action1 == 'create_karigar')
					{
						$redirect_action = "list_karigar";
					}

					?>

	<div class="form-group form-actions">
		        <div class="col-md-9 col-md-offset-3">
		            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('yii','Save') : Yii::t('yii','Save'), array('class' => 'btn btn-effect-ripple btn-primary submit')); ?>
		            <?php echo CHtml::link(Yii::t('yii','Cancel'), array($redirect_action), array('class' => 'btn btn-effect-ripple btn-danger')) ?>
		        </div>
		    </div>

<?php $this->endWidget(); ?>
			</div>
		</div>
	</div>

	  <script type="text/javascript">
            
            $('body').on('keydown', 'input, select', function(e) {
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
