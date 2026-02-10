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

					     <!-- <div class="form-group blocks">
				            	<div class="col-md-12">
				            		<label class="col-md-2 control-label"></label>
				            		<div class="col-md-5">
				            			<label>Item</label>
				            			<input type="text" placeholder="Enter Item Name" name="note[]" id="item" class="form-control nameclass">
				            		</div>
				            		<div class="col-md-3">
				            			<label>Amount</label>
				            			
				            			<input type="text" placeholder="Amount" name="amount[]" id="amount" class="form-control nameclass numeric_amount gold_amount_js"  autocomplete="off">
				            		</div>
				            		<div class="col-md-1" style="margin-top: 25px;">
				                            <a class="btn btn-primary add_button"><i class="fa fa-plus"></i></a>
				                    </div>
				            	</div>
						<div class="items"></div>
				        </div> -->

								<!-- <div class="form-group">
									<div class="col-md-12">
										<?php // echo $form->labelEx($model,'cash_type', array('class' => 'col-md-2 control-label')); ?>
									<div class="col-md-5">
									<?php // echo $form->textArea($model,'type', array('class' => 'form-control')); 
								/*	$cash_type=array(1=>'IN',2=>'OUT');
									echo $form->dropDownList($model,'cash_type',$cash_type,
													array(
														'prompt'=>'----Select Cash----',
														'class'=>'form-control cash_type',
													)); */
									?>
									<?php // echo $form->error($model,'cash_type'); ?>
								</div>
								<input type="hidden" name="isAjaxRequest" value="1">
									<?php // echo $form->labelEx($model,'amount', array('class' => 'col-md-3 control-label')); ?>
									<div class="col-md-4">
									<?php // echo $form->textField($model,'amount', array('class' => 'form-control amount','maxlength'=>13,'placeholder'=>"Cash Amount")); ?>
									<?php // echo $form->error($model,'amount'); ?>
									</div>
								</div>
							</div> -->
				            		<input type="hidden" name="isAjaxRequest" value="1">	

							<div class="form-group blocks">
				            	<div class="col-md-12">
				            		<label class="col-md-1 control-label">Cash</label>
				            			<div class="col-md-3">
					            			<select name="cash_type[]" class="form-control">
					            				<!-- <option value="">----Select Cash----</option> -->
					            				<option value="1">IN</option>
					            				<option value="2">OUT</option>
						            			</select>
					            		</div>
				            		<div class="col-md-3">
				            			<input type="text" placeholder="Enter Cash Amount" name="cash_amount[]" class="form-control gold_amount_js">
				            		</div>
				            		<div class="col-md-3">
			            				<input type="text" name="cash_description[]"  class="form-control" placeholder="Enter Note">
			            			</div>
				            		<div class="col-md-1">
			                            <a class="btn btn-primary btn-sm add_cash_button"><i class="fa fa-plus"></i></a>
				                    </div>
				            	</div>
							<div class="items_cash"></div>
				       		</div>




					<!-- <div class="form-group">
							<div class="col-md-12">
								<?php // echo $form->labelEx($model,'gold_type', array('class' => 'col-md-2 control-label')); ?>
							<div class="col-md-5">
							<?php 
							/*$gold_type=array(1=>'IN',2=>'OUT');
							echo $form->dropDownList($model,'gold_type',$gold_type,
											array(
												'prompt'=>'----Select Gold----',
												'class'=>'form-control gold_type',
											)); */
							?>
							<?php // echo $form->error($model,'gold_type'); ?>
						</div>
						
							<div class="col-md-4">
							<?php // echo $form->textField($model,'gold_amount', array('class' => 'form-control gold_amount','maxlength'=>13,'placeholder'=>"Gold Amount")); ?>
							<?php // echo $form->error($model,'gold_amount'); ?>
							</div>
						</div>
					</div> -->
					

						<div class="form-group blocks">
			            	<div class="col-md-12">
			            		<label class="col-md-1 control-label">Gold</label>
			            			<div class="col-md-2">
				            			<select name="gold_type[]" class="form-control">
				            				<!-- <option value="">--Select Gold--</option> -->
				            				<option value="1">IN</option>
				            				<option value="2">OUT</option>
					            			</select>
				            		</div>
				            	<div class="col-md-2">
				            			<input type="text" placeholder="Gross Weight" name="gross_gold_weight[]" class="form-control">
				            	</div>
			            		<div class="col-md-2">
				            			<input type="text" placeholder="Enter Weight" name="gold_weight[]" class="form-control gold_amount_js">
				            	</div>
			            		<div class="col-md-2">
			            			<input type="text" placeholder="Enter Amount" name="gold_amount[]" class="form-control gold_amount_js">
			            		</div>
			            		<div class="col-md-2">
		            				<input type="text" name="gold_description[]"  class="form-control" placeholder="Enter Note">
		            			</div>
			            		<div class="col-md-1">
		                            <button class="btn btn-primary btn-sm add_gold_button"><i class="fa fa-plus"></i></button>
			                    </div>
			            	</div>
						<div class="items_gold"></div>
			       		</div>


			       		<div class="form-group blocks">
			            	<div class="col-md-12">
			            		<label class="col-md-1 control-label">Diamond</label>
			            			<div class="col-md-2">
				            			<select name="diamond_type[]" class="form-control">
				            				<!-- <option value="">--Select Diamond--</option> -->
				            				<option value="1">IN</option>
				            				<option value="2">OUT</option>
					            			</select>
				            		</div>
			            		<div class="col-md-2">
				            			<input type="text" placeholder="Enter Weight" name="diamond_weight[]" class="form-control gold_amount_js">
				            	</div>
			            		<div class="col-md-2">
			            			<input type="text" placeholder="Enter Amount" name="diamond_amount[]" class="form-control gold_amount_js">
			            		</div>
			            		<div class="col-md-3">
		            				<input type="text" name="diamond_description[]"  class="form-control" placeholder="Enter Note">
		            			</div>
			            		<div class="col-md-1">
		                            <button class="btn btn-primary btn-sm add_diamond_button"><i class="fa fa-plus"></i></button>
			                    </div>
			            	</div>
						<div class="items_diamond"></div>
			       		</div>




					<!-- <div class="form-group">
							<div class="col-md-12">
								<?php // echo $form->labelEx($model,'bank_type', array('class' => 'col-md-2 control-label')); ?>
							<div class="col-md-5">
							<?php 
						/*	$bank_type=array(1=>'IN',2=>'OUT');
							echo $form->dropDownList($model,'bank_type',$bank_type,
											array(
												'prompt'=>'----Select Bank----',
												'class'=>'form-control bank_type',
											)); */
							?>
							<?php // echo $form->error($model,'bank_type'); ?>
						</div>
					
							<div class="col-md-4">
							<?php // echo $form->textField($model,'bank_amount', array('class' => 'form-control bank_amount','maxlength'=>13,'placeholder'=>"Bank Amount")); ?>
							<?php // echo $form->error($model,'bank_amount'); ?>
							</div>
						</div>
					</div> -->

						<div class="form-group blocks">
			            	<div class="col-md-12">
			            		<label class="col-md-1 control-label">Bank</label>
			            			<div class="col-md-3">
				            			<select name="bank_type[]" class="form-control">
				            				<!-- <option value="">----Select Bank----</option> -->
				            				<option value="1">IN</option>
				            				<option value="2">OUT</option>
					            			</select>
				            		</div>
			            		<div class="col-md-3">
			            			<input type="text" placeholder="Enter Bank Amount" name="bank_amount[]" class="form-control gold_amount_js">
			            		</div>
			            		<div class="col-md-3">
		            				<input type="text" name="bank_description[]"  class="form-control" placeholder="Enter Note">
		            			</div>
			            		<div class="col-md-1">
		                            <button class="btn btn-primary btn-sm add_bank_button"><i class="fa fa-plus"></i></button>
			                    </div>
			            	</div>
						<div class="items_bank"></div>
			       		</div>



				<!-- 	<div class="form-group">
							<div class="col-md-12">
								<?php // echo $form->labelEx($model,'card_type', array('class' => 'col-md-2 control-label')); ?>
							<div class="col-md-5">
							<?php 
							/*$card_type=array(1=>'IN',2=>'OUT');
							echo $form->dropDownList($model,'card_type',$card_type,
											array(
												'prompt'=>'----Select Card----',
												'class'=>'form-control card_type',
											)); */
							?>
							<?php // echo $form->error($model,'card_type'); ?>
						
						</div>
						
							<div class="col-md-4">
							<?php // echo $form->textField($model,'card_amount', array('class' => 'form-control card_amount','maxlength'=>13,'placeholder'=>"Card Amount")); ?>
							<?php // echo $form->error($model,'card_amount'); ?>
							</div>
						</div>
					</div> -->

					<div class="form-group blocks">
			            	<div class="col-md-12">
			            		<label class="col-md-1 control-label">Card</label>
			            			<div class="col-md-3">
				            			<select name="card_type[]" class="form-control">
				            				<!-- <option value="">----Select Card----</option> -->
				            				<option value="1">IN</option>
				            				<option value="2">OUT</option>
					            			</select>
				            		</div>
			            		<div class="col-md-3">
			            			<input type="text" placeholder="Enter Card Amount" name="card_amount[]" class="form-control gold_amount_js">
			            		</div>
			            		<div class="col-md-3">
		            				<input type="text" name="card_description[]"  class="form-control" placeholder="Enter Note">
		            			</div>
			            		<div class="col-md-1">
		                            <button class="btn btn-primary btn-sm add_card_button"><i class="fa fa-plus"></i></button>
			                    </div>
			            	</div>
						<div class="items_card"></div>
			       		</div>


						<!-- <div class="form-group">
							<div class="col-md-12">
								<?php // echo $form->labelEx($model,'discount_type', array('class' => 'col-md-2 control-label')); ?>
							<div class="col-md-5">
							<?php 
						/*	$discount_type=array(1=>'IN',2=>'OUT');
							echo $form->dropDownList($model,'discount_type',$discount_type,
											array(
												'prompt'=>'----Select Discount----',
												'class'=>'form-control discount_type',
											)); */
							?>
							<?php // echo $form->error($model,'discount_type'); ?>
						</div>
						
							<div class="col-md-4">
							<?php // echo $form->textField($model,'discount_amount', array('class' => 'form-control discount_amount','maxlength'=>13,'placeholder'=>"Discount Amount")); ?>
							<?php // echo $form->error($model,'discount_amount'); ?>
							</div>
						</div>
					</div> -->

					<div class="form-group blocks">
			            	<div class="col-md-12">
			            		<label class="col-md-1 control-label">Discount</label>
			            			<div class="col-md-3">
				            			<select name="discount_type[]" class="form-control">
				            				<!-- <option value="">----Select Discount----</option> -->
				            				<option value="1">IN</option>
				            				<option value="2">OUT</option>
					            			</select>
				            		</div>
			            		<div class="col-md-3">
			            			<input type="text" placeholder="Enter Discount Amount" name="discount_amount[]" class="form-control gold_amount_js">
			            		</div>
			            		<div class="col-md-3">
		            				<input type="text" name="discount_description[]"  class="form-control" placeholder="Enter Note">
		            			</div>
			            		<div class="col-md-1">
		                    <!--         <a class="btn btn-primary btn-sm add_discount_button"><i class="fa fa-plus"></i></a> -->
			                    </div>
			            	</div>
						<div class="items_discount"></div>
			       		</div>


						<!-- </div> -->
					<!-- </div> -->
				<!-- 	<div class="col-md-12" style="margin-left:150px; "><h4><b>OR</b></h4></div> -->
						


				<!-- 	<div class="form-group">
							<div class="col-md-12">
								<?php // echo $form->labelEx($model,'narration', array('class' => 'col-md-2 control-label')); ?>
							<div class="col-md-9">
							<?php // echo $form->textArea($model,'type', array('class' => 'form-control')); 
							// echo $form->textArea($model,'narration', array('class' => 'form-control note')); 
							?>
							<?php // echo $form->error($model,'narration'); ?>
							</div>
						</div>
					</div> -->

					<div class="form-group">
							<div class="col-md-12">
								<?php
									// $selected_date = date("Y-m-d");
									// $model->created_date = date('d-m-Y',strtotime($selected_date));
								?>
								<?php echo $form->labelEx($model,'created_date', array('class' => 'col-md-1 control-label')); ?>
							<div class="col-md-3">
							<?php // echo $form->textArea($model,'type', array('class' => 'form-control')); 
							echo $form->textField($model,'created_date', array('class' => 'form-control','autocomplete'=>'off','placeholder'=>'dd-mm-yyyy'));
							// echo $form->textField($model,'created_date', array('class' => 'form-control input-datepicker create_date','data-date-format'=>"dd-mm-yyyy",'readonly'=>"readonly",'autocomplete'=>'off'));
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

					<div class="form-group hidden add-more-cash">
			            	<div class="blocks col-md-12" style="margin-top: 10px;">
			            		<label class="col-md-1 control-label">Cash</label>
				            			<div class="col-md-3">
					            			<select name="cash_type[]" class="form-control">
					            				<!-- <option value="">----Select Cash----</option> -->
					            				<option value="1">IN</option>
					            				<option value="2">OUT</option>
						            			</select>
					            		</div>
				            		<div class="col-md-3">
				            			<input type="text" placeholder="Enter Cash Amount" name="cash_amount[]" class="form-control gold_amount_js">
				            		</div>
				            		<div class="col-md-3">
			            				<input type="text" name="cash_description[]"  class="form-control" placeholder="Enter Note">
			            			</div>
			            		<div class="col-md-2" style="padding-right: 0px;">
			                            <button class="btn btn-primary btn-sm add_cash_button" style="margin-bottom:2px; "><i class="fa fa-plus"></i></button>
						            <button class="btn btn-danger btn-sm cash_remove"><i class="fa fa-times"></i></button>
			                    </div>
			                    <div class="col-md-1">
						        </div>
			            	</div>
			        </div>



			        <div class="form-group hidden add-more-gold">
			            	<div class="blocks col-md-12" style="margin-top: 10px;">
			            		<label class="col-md-1 control-label">Gold</label>
				            			<div class="col-md-2">
					            			<select name="gold_type[]" class="form-control">
					            				<!-- <option value="">--Select Gold--</option> -->
					            				<option value="1">IN</option>
					            				<option value="2">OUT</option>
						            			</select>
					            		</div>
				            		<div class="col-md-2">
				            			<input type="text" placeholder="Gross Weight" name="gross_gold_weight[]" class="form-control">
				            		</div>
				            		<div class="col-md-2">
				            			<input type="text" placeholder="Enter Weight" name="gold_weight[]" class="form-control gold_amount_js">
				            		</div>
				            		<div class="col-md-2">
				            			<input type="text" placeholder="Enter Amount" name="gold_amount[]" class="form-control gold_amount_js">
				            		</div>
				            		<div class="col-md-2">
			            				<input type="text" name="gold_description[]"  class="form-control" placeholder="Enter Note">
			            			</div>
			            		<div class="col-md-1" style="padding-right: 0px;">
			                            <button class="btn btn-primary btn-sm add_gold_button" style="margin-bottom:2px; "><i class="fa fa-plus"></i></button>
						            <button  style="margin-left: 0px;" class="btn btn-danger btn-sm gold_remove"><i class="fa fa-times"></i></button>
			                    </div>
			                    <div class="col-md-1">
						        </div>
			            	</div>
			        </div>




			         <div class="form-group hidden add-more-diamond">
			            	<div class="blocks col-md-12" style="margin-top: 10px;">
			            		<label class="col-md-1 control-label">Diamond</label>
				            			<div class="col-md-2">
					            			<select name="diamond_type[]" class="form-control">
					            				<!-- <option value="">--Select Diamond--</option> -->
					            				<option value="1">IN</option>
					            				<option value="2">OUT</option>
						            			</select>
					            		</div>
				            		<div class="col-md-2">
				            			<input type="text" placeholder="Enter Weight" name="diamond_weight[]" class="form-control gold_amount_js">
				            		</div>
				            		<div class="col-md-2">
				            			<input type="text" placeholder="Enter Amount" name="diamond_amount[]" class="form-control gold_amount_js">
				            		</div>
				            		<div class="col-md-3">
			            				<input type="text" name="diamond_description[]"  class="form-control" placeholder="Enter Note">
			            			</div>
			            		<div class="col-md-2" style="padding-right: 0px;">
			                            <button class="btn btn-primary btn-sm add_diamond_button" style="margin-bottom:2px; "><i class="fa fa-plus"></i></button>
						            <button  style="margin-left: 10px;" class="btn btn-danger btn-sm diamond_remove"><i class="fa fa-times"></i></button>
			                    </div>
			                    <div class="col-md-1">
						        </div>
			            	</div>
			        </div>



			         <div class="form-group hidden add-more-bank">
			            	<div class="blocks col-md-12" style="margin-top: 10px;">
			            		<label class="col-md-1 control-label">Bank</label>
				            			<div class="col-md-3">
					            			<select name="bank_type[]" class="form-control">
					            				<!-- <option value="">----Select Bank----</option> -->
					            				<option value="1">IN</option>
					            				<option value="2">OUT</option>
						            			</select>
					            		</div>
				            		<div class="col-md-3">
				            			<input type="text" placeholder="Enter Bank Amount" name="bank_amount[]" class="form-control gold_amount_js">
				            		</div>
				            		<div class="col-md-3">
			            				<input type="text" name="bank_description[]"  class="form-control" placeholder="Enter Note">
			            			</div>
			            		<div class="col-md-2">
			                            <button class="btn btn-primary btn-sm add_bank_button" style="margin-bottom:2px; "><i class="fa fa-plus"></i></button>
						            <button   style="margin-left: 10px;" class="btn btn-danger btn-sm bank_remove"><i class="fa fa-times"></i></button>
			                    </div>
			                    <div class="col-md-1">
						        </div>
			            	</div>
			        </div>


			        	<div class="form-group hidden add-more-card">
			            	<div class="blocks col-md-12" style="margin-top: 10px;">
			            		<label class="col-md-1 control-label">Card</label>
				            			<div class="col-md-3">
					            			<select name="card_type[]" class="form-control">
					            				<!-- <option value="">----Select Card----</option> -->
					            				<option value="1">IN</option>
					            				<option value="2">OUT</option>
						            			</select>
					            		</div>
				            		<div class="col-md-3">
				            			<input type="text" placeholder="Enter Card Amount" name="card_amount[]" class="form-control gold_amount_js">
				            		</div>
				            		<div class="col-md-3">
			            				<input type="text" name="card_description[]"  class="form-control" placeholder="Enter Note">
			            			</div>
			            		<div class="col-md-2">
			                            <button class="btn btn-primary btn-sm add_card_button" style="margin-bottom:2px; "><i class="fa fa-plus"></i></button>
						            <button   style="margin-left: 10px;" class="btn btn-danger btn-sm card_remove"><i class="fa fa-times"></i></button>
			                    </div>
			                    <div class="col-md-1">
						        </div>
			            	</div>
			        </div>


			        <div class="form-group hidden add-more-discount">
			            	<div class="blocks col-md-12" style="margin-top: 10px;">
			            		<label class="col-md-1 control-label">Discount</label>
				            			<div class="col-md-3">
					            			<select name="discount_type[]" class="form-control">
					            				<!-- <option value="">----Select Discount----</option> -->
					            				<option value="1">IN</option>
					            				<option value="2">OUT</option>
						            			</select>
					            		</div>
				            		<div class="col-md-3">
				            			<input type="text" placeholder="Enter Discount Amount" name="discount_amount[]" class="form-control gold_amount_js">
				            		</div>
				            		<div class="col-md-3">
			            				<input type="text" name="discount_description[]"  class="form-control" placeholder="Enter Note">
			            			</div>
			            		<div class="col-md-2">
			                            <button class="btn btn-primary btn-sm add_discount_button" style="margin-bottom:2px; "><i class="fa fa-plus"></i></button>
						            <button   style="margin-left: 10px;" class="btn btn-danger btn-sm discount_remove"><i class="fa fa-times"></i></button>
			                    </div>
			                    <div class="col-md-1">
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


/*
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
              
            }
        });
	});*/

</script>

<script type="text/javascript">
	$('body').on('keyup', '.gold_amount_js', function(e) {
		var goldAmount = $(this).val();
		//console.log(goldAmount);
		var regex = /^[0-9]+$/;
	 
	    //Validate TextBox value against the Regex.
	   /* var isValid = regex.test(String.fromCharCode(goldAmount));
	    if (!isValid) {
	        alert(goldAmount);
	    }*/
	});

	$('body').on('keypress','.gold_amount_js',function(event)
	{
	 // $(".gold_amount_js").on("keypress keyup blur",function (event) {
	            //this.value = this.value.replace(/[^0-9\.]/g,'');
	     $(this).val($(this).val().replace(/[^0-9\.]/g,''));
	            if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
	                event.preventDefault();
	            }
	        });




	$('body').on('change','.gold_amount_js',function(event)
	{
	    $(this).val($(this).val().replace(/[^0-9\.]/g,''));
            if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57))
            {
		        // alert("only number allowed !");
			    $(this).val('');
		        $(this).focus();
                event.preventDefault();
            }
    });

	$('body').on('mousedown','.gold_amount_js',function(e)
	{ 
	    if( e.button == 2 ) { 
	      alert('Copy Past not allowed !'); 
	      return false; 
	    } 
	    return true; 
    });

</script>