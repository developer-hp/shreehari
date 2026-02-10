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
						'id'=>'cashevent-form',
						'enableAjaxValidation' => true,
						    'htmlOptions' => array('class' => 'form-horizontal form-bordered', 'enctype' => 'multipart/form-data'),
						    'clientOptions' => array(
						        'validateOnSubmit' => true,
						    ),
						    'errorMessageCssClass' => 'help-block animation-slideUp form-error',
						// 'enableAjaxValidation'=>false,
					)); ?>
					
							<?php 
							if(isset($_POST['cust_id']))
							{
								$model->customer_id=$_POST['cust_id'];
							} 
							?>

					        <?php echo $form->hiddenField($model,'customer_id', array('class' => 'form-control customer_id','maxlength'=>13)); ?>

					     <div class="form-group blocks">
				            	<div class="col-md-12">
				            		<label class="col-md-2 control-label"></label>
				            		<div class="col-md-5">
				            			<label>Item</label>
				            			<?php //  echo $form->textField($cash_log,'note[]', array('class' => 'form-control','placeholder'=>"Enter Item Name")); ?>
				            			<?php // echo $form->error($cash_log,'note'); ?>
				            			<input type="text" placeholder="Enter Item Name" name="note[]" id="item" class="form-control nameclass">
				            		</div>
				            		<div class="col-md-3">
				            			<label>Amount</label>
				            			<?php // echo $form->textField($cash_log,'amount[]', array('class' => 'form-control','placeholder'=>"Enter Amount")); ?>
				            			<?php //  echo $form->error($cash_log,'amount'); ?>
				            			<input type="text" placeholder="Amount" name="amount[]" id="amount" class="form-control nameclass numeric_amount"  autocomplete="off">
				            			<!-- <span id="errmsg"></span> -->
				            		</div>
				            		<div class="col-md-1" style="margin-top: 25px;">
				                            <a class="btn btn-primary add_button"><i class="gi gi-plus"></i></a>
				                    </div>
				            	</div>
						<div class="items"></div>
				        </div>

						<div class="form-group">
							<div class="col-md-12">
								<?php echo $form->labelEx($model,'cash_type', array('class' => 'col-md-2 control-label')); ?>
							<div class="col-md-5">
							<?php // echo $form->textArea($model,'type', array('class' => 'form-control')); 
							$cash_type=array(1=>'IN',2=>'OUT');
							echo $form->dropDownList($model,'cash_type',$cash_type,
											array(
												'prompt'=>'----Select Cash Event----',
												'class'=>'form-control cash_type',
											)); 
							?>
							<?php echo $form->error($model,'cash_type'); ?>
						</div>
						<input type="hidden" name="isAjaxRequest" value="1">
					<!-- 	<div class="col-md-12"> -->
						<!-- <div class="form-group"> -->
							<?php // echo $form->labelEx($model,'amount', array('class' => 'col-md-3 control-label')); ?>
							<div class="col-md-4">
							<?php echo $form->textField($model,'amount', array('class' => 'form-control amount','maxlength'=>13,'placeholder'=>"Cash Amount")); ?>
							<?php echo $form->error($model,'amount'); ?>
							</div>
						</div>
					</div>


					<div class="form-group">
							<div class="col-md-12">
								<?php echo $form->labelEx($model,'gold_type', array('class' => 'col-md-2 control-label')); ?>
							<div class="col-md-5">
							<?php // echo $form->textArea($model,'type', array('class' => 'form-control')); 
							$gold_type=array(1=>'IN',2=>'OUT');
							echo $form->dropDownList($model,'gold_type',$gold_type,
											array(
												'prompt'=>'----Select Gold Event----',
												'class'=>'form-control gold_type',
											)); 
							?>
							<?php echo $form->error($model,'gold_type'); ?>
						</div>
						
					<!-- 	<div class="col-md-12"> -->
						<!-- <div class="form-group"> -->
							<?php // echo $form->labelEx($model,'amount', array('class' => 'col-md-3 control-label')); ?>
							<div class="col-md-4">
							<?php echo $form->textField($model,'gold_amount', array('class' => 'form-control gold_amount','maxlength'=>13,'placeholder'=>"Gold Amount")); ?>
							<?php echo $form->error($model,'gold_amount'); ?>
							</div>
						</div>
					</div>




					<div class="form-group">
							<div class="col-md-12">
								<?php echo $form->labelEx($model,'bank_type', array('class' => 'col-md-2 control-label')); ?>
							<div class="col-md-5">
							<?php // echo $form->textArea($model,'type', array('class' => 'form-control')); 
							$bank_type=array(1=>'IN',2=>'OUT');
							echo $form->dropDownList($model,'bank_type',$bank_type,
											array(
												'prompt'=>'----Select Bank Event----',
												'class'=>'form-control bank_type',
											)); 
							?>
							<?php echo $form->error($model,'bank_type'); ?>
						</div>
					
					<!-- 	<div class="col-md-12"> -->
						<!-- <div class="form-group"> -->
							<?php // echo $form->labelEx($model,'amount', array('class' => 'col-md-3 control-label')); ?>
							<div class="col-md-4">
							<?php echo $form->textField($model,'bank_amount', array('class' => 'form-control bank_amount','maxlength'=>13,'placeholder'=>"Bank Amount")); ?>
							<?php echo $form->error($model,'bank_amount'); ?>
							</div>
						</div>
					</div>



					<div class="form-group">
							<div class="col-md-12">
								<?php echo $form->labelEx($model,'card_type', array('class' => 'col-md-2 control-label')); ?>
							<div class="col-md-5">
							<?php // echo $form->textArea($model,'type', array('class' => 'form-control')); 
							$card_type=array(1=>'IN',2=>'OUT');
							echo $form->dropDownList($model,'card_type',$card_type,
											array(
												'prompt'=>'----Select Card Event----',
												'class'=>'form-control card_type',
											)); 
							?>
							<?php echo $form->error($model,'card_type'); ?>
						
						</div>
						
					<!-- 	<div class="col-md-12"> -->
						<!-- <div class="form-group"> -->
							<?php // echo $form->labelEx($model,'amount', array('class' => 'col-md-3 control-label')); ?>
							<div class="col-md-4">
							<?php echo $form->textField($model,'card_amount', array('class' => 'form-control card_amount','maxlength'=>13,'placeholder'=>"Card Amount")); ?>
							<?php echo $form->error($model,'card_amount'); ?>
							</div>
						</div>
					</div>


					<div class="form-group">
							<div class="col-md-12">
								<?php echo $form->labelEx($model,'discount_type', array('class' => 'col-md-2 control-label')); ?>
							<div class="col-md-5">
							<?php // echo $form->textArea($model,'type', array('class' => 'form-control')); 
							$discount_type=array(1=>'IN',2=>'OUT');
							echo $form->dropDownList($model,'discount_type',$discount_type,
											array(
												'prompt'=>'----Select Discount Event----',
												'class'=>'form-control discount_type',
											)); 
							?>
							<?php echo $form->error($model,'discount_type'); ?>
							<?php // echo $form->error($model,'discount_amount'); ?>
						</div>
						
					<!-- 	<div class="col-md-12"> -->
						<!-- <div class="form-group"> -->
							<?php // echo $form->labelEx($model,'amount', array('class' => 'col-md-3 control-label')); ?>
							<div class="col-md-4">
							<?php echo $form->textField($model,'discount_amount', array('class' => 'form-control discount_amount','maxlength'=>13,'placeholder'=>"Discount Amount")); ?>
							<?php echo $form->error($model,'discount_amount'); ?>
							</div>
						</div>
					</div>


						<!-- </div> -->
					<!-- </div> -->
				<!-- 	<div class="col-md-12" style="margin-left:150px; "><h4><b>OR</b></h4></div> -->
						


					<div class="form-group">
							<div class="col-md-12">
								<?php echo $form->labelEx($model,'narration', array('class' => 'col-md-2 control-label')); ?>
							<div class="col-md-9">
							<?php // echo $form->textArea($model,'type', array('class' => 'form-control')); 
							echo $form->textArea($model,'narration', array('class' => 'form-control note')); 
							?>
							<?php echo $form->error($model,'narration'); ?>
							</div>
						</div>
					</div>

					<div class="form-group">
							<div class="col-md-12">
								<?php echo $form->labelEx($model,'created_date', array('class' => 'col-md-2 control-label')); ?>
							<div class="col-md-5">
							<?php // echo $form->textArea($model,'type', array('class' => 'form-control')); 
							echo $form->textField($model,'created_date', array('class' => 'form-control input-datepicker create_date','data-date-format'=>"dd-mm-yyyy",'readonly'=>"readonly",'autocomplete'=>'off'));
							?>
							<?php echo $form->error($model,'created_date'); ?>
							</div>
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

					<div class="form-group hidden add-more">
 						 <!-- <div class="blocks row">  -->
			            	<div class="blocks col-md-12" style="margin-top: 10px;">
			            		<label class="col-md-2 control-label"></label>
			            		<div class="col-md-5">
			            				<input type="text" placeholder="Enter Item Name" name="note[]" id="item" class="form-control nameclass">
			            		</div>
			            		<div class="col-md-3">
			            				<input type="text" placeholder="Amount" name="amount[]" id="amount" class="form-control nameclass numeric_amount" autocomplete="off">
			            		</div>
			            		<div class="col-md-1">
			                            <a class="btn btn-primary add_button"><i class="gi gi-plus"></i></a>
			                    </div>
			                     <div class="col-md-1">
						            <a class="btn btn-danger remove"><i class="fa fa-times"></i></a>
						        </div>
			            	</div>
			        </div>

<script type="text/javascript">
	


	 $("#cashevent-form").submit(function(event)
        {            
          // alert("AAA");
            var valid = true;
            $('.errormsg').remove();
            $("#cashevent-form .nameclass").each(function() 
            {
                if( ! $(this).val() ){
                    $(this).after('<span class="text-danger errormsg errorMessage  help-block animation-slideUp form-error">'+$(this).attr('id')+' cannot be blank.</span>');
                    valid = false;
                }
            });
            
            if (!valid){
                return false;
            }
            else
            {
                return true;
            }
            event.preventDefault();
        });



	 $(document).ready(function () 
	 {
		   var numchk = new RegExp("^[0-9]*$");     

        $('body').on('change','.numeric_amount',function()
        {
        	if( numchk.test( $(this).val() ) )
        	{
                // console.log("Numeric value");
            }
            else
            {	
        		$(this).after('<span class="text-danger errormsg errorMessage  help-block animation-slideUp form-error">'+$(this).attr('id')+' numeric only.</span>');
                // return false;
           		// console.log("Value not numeric");
            }
        });
	});

</script>