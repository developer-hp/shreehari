<?php $title="Cash";?>
<style>
.items .notes .sub_items .custom_class  
{
	/* color:red; */
	width: 100%;
	position: relative;
    min-height: 1px;
    padding-left: 15px;
    padding-right: 15px;
}
</style>
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
                           echo CHtml::link($title, array('admin'));
                          ?></li>
                    <?php endif; ?>
                    <li><?php echo $model->isNewRecord ? Yii::t('yii','Create') : Yii::t('yii','Edit'); ?></li>
                    <input type="hidden" class="test" value="<?php echo $model->isNewRecord ? 'Create' : 'Edit'; ?>">
                </ul>
            </div>
        </div>
    </div>
</div>
<?php
// echo "<pre>";
	// print_r($cash_log_model);
?>
<div class="row">
    <div class="col-md-12">
     <!-- Horizontal Form Block -->
        <div class="block">          
            <!-- Horizontal Form Title -->
            <div class="block-title">
                <h2><?php echo $model->isNewRecord ? Yii::t('yii','Create') : Yii::t('yii','Edit'); ?> <?php echo $title;?></h2>
            </div>
 			
 			<div id="errorMsg1" class="errorMsg1" style="border-radius: 10px; line-height: 1px;" ></div>

              <?php if (Yii::app()->user->hasFlash('success')): ?>
                <div class="alert alert-success alert-dismissable">
                    <p><?php echo Yii::app()->user->getFlash('success'); ?></p>
                </div>
                <?php endif; ?> 

					<?php 
						$form=$this->beginWidget('CActiveForm', array(
							'id'=>'cashevent-form',
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
							// 'enableAjaxValidation'=>false,
						));
					
					 ?>

						<!-- <p class="note">Fields with <span class="required">*</span> are required.</p> -->

						<?php 

						if($model->isNewRecord)
						{
						 ?>

						<div class="form-group">
								<div class="col-md-12">
									<?php echo $form->labelEx($model,'Customer Type', array('class' => 'col-md-2 control-label')); ?>
									<div class="col-md-6">
										<select name="customer_type" class="form-control customer_type">
											<option value="">---Select Customer Type---</option>
											<option value="1">Supplier</option>
											<option value="2">Customer</option>
											<option value="3">Karigar</option>
										</select>
									</div>
									<a href="javascript:void(0)" class = 'btn btn-effect-ripple btn-info btn-lg tech_popup fa fa-user-plus'> Create Customer</a>
								</div>
						</div>


						<div class="form-group">
							<div class="col-md-12">
							<?php echo $form->labelEx($model,'customer_id', array('class' => 'col-md-2 control-label')); ?>
							<div class="col-md-6">
							<?php // echo $form->textField($model,'customer_id', array('class' => 'form-control')); 
								// $customer = Customer::model()->findAll();
								echo $form->dropDownList($model,'customer_id',CHtml::listData(Customer::model()->findAll(array("condition"=>"is_deleted = 0")),'id','name'),
									array(
										'prompt'=>'----Select Customer----',
										'class'=>'form-control customer_list',
									)); 
							?>
							<?php echo $form->error($model,'customer_id'); ?>
							</div>
								<!-- <a href="javascript:void(0)" class = 'btn btn-effect-ripple btn-info btn-lg tech_popup fa fa-user-plus'> Create Customer</a> -->
						</div>
					</div>
					
					<div class="form-group">
							<div class="col-md-12">
								<?php echo $form->labelEx($model,'narration', array('class' => 'col-md-2 control-label')); ?>
								<div class="col-md-6">
								<?php  echo $form->textField($model,'narration', array('class' => 'form-control','placeholder'=>'Enter Related Person')); 
									
								?>
								<?php echo $form->error($model,'narration'); ?>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-12">
								<?php echo $form->labelEx($model,'referral_code', array('class' => 'col-md-2 control-label')); ?>
								<div class="col-md-6">
								<?php  echo $form->textField($model,'referral_code', array('class' => 'form-control','placeholder'=>'Enter Bill Number')); 
								?>
								<?php echo $form->error($model,'referral_code'); ?>
								</div>
							</div>
						</div>		

						<div class="form-group">
							<div class="col-md-12">
								<?php if($model->isNewRecord)
								{
									// $selected_date = date("Y-m-d");
									// $model->created_date = date('d-m-Y',strtotime($selected_date));
								} 
								?>
							<?php echo $form->labelEx($model,'created_date', array('class' => 'col-md-2 control-label')); ?>
							<div class="col-md-3">
							<?php  echo $form->textField($model,'created_date', array('class' => 'form-control','autocomplete'=>'off' ,'placeholder'=>'dd-mm-yyyy'));

							// echo $form->textField($model,'created_date', array('class' => 'form-control input-datepicker','data-date-format'=>"dd-mm-yyyy",'readonly'=>"readonly" ,'autocomplete'=>'off')); 
								
							?>
							<?php echo $form->error($model,'created_date'); ?>
							</div>
						</div>
					</div>

						<div class="form-group blocks">
				            	<div class="col-md-12">
				            		<label class="col-md-2 control-label">Item</label>
				            		<div class="col-md-3">
				            			<!-- <label>Item</label> -->
				            			<input type="text" placeholder="Enter Item Name" name="note[0]" id="item" class="form-control nameclass item_note main_item_req">
				            		</div>
				            		<div class="col-md-2">
				            			<input type="text" placeholder="Gross Weight" name="gross_weight[0]" class="form-control  gross_weight">
				            		</div>
				            		<div class="col-md-2">
				            			<input type="text" placeholder="Enter Weight" name="weight[0]" class="form-control gold_amount_js item_weight">
				            		</div>
				            		<div class="col-md-2">
				            			<input type="text" placeholder="Enter Amount" name="amount[0]" id="amount" class="form-control nameclass numeric_amount gold_amount_js item_amount">
				            		</div>
				            		<!-- <div class="col-md-3">
			            				<textarea name="note_detail[]" id="note" class="form-control" placeholder="Enter Note"></textarea>
			            			</div> -->
				            		<div class="col-md-1" style="padding-right: 0px;">
				                            <button class="btn btn-primary add_button btn-sm"><i class="fa fa-plus"></i></button> 
				                            <!-- <button class="btn btn-primary add_button btn-sm"><i class="fa fa-plus"></i></button> -->
				                    </div>
				            	</div>
								
			            <!-- </div>	 -->

			            <!-- <div class="form-group blocks"> -->
			            	<span data-id="0" class="note2 notes">
				            	<div class="col-md-12" style="margin-top: 0px;">
				            		<label class="col-md-2 control-label">Sub Item</label>
				            		<div class="col-md-3">
				            			<!-- <label>Item</label> -->
				            			<input type="text" placeholder="Enter Sub Item Name" name="sub_note[0][]" id="" class="form-control nameclass sub_item_note">
				            		</div>
				            		<div class="col-md-3">
				            			<input type="text" placeholder="Enter Weight" name="sub_weight[0][]" class="form-control gold_amount_js sub_item_weight">
				            		</div>
				            		<div class="col-md-3">
				            			<input type="text" placeholder="Enter Amount" name="sub_amount[0][]" id="amount" class="form-control nameclass numeric_amount gold_amount_js sub_item_amount">
				            		</div>
				            		<!-- <div class="col-md-3">
			            				<textarea name="note_detail[]" id="note" class="form-control" placeholder="Enter Note"></textarea>
			            			</div> -->
				            		<div class="col-md-1" style="padding-right: 0px;">
				                            <button class="btn btn-primary add_sub_button btn-sm"><i class="fa fa-plus"></i></button> 
				                            <!-- <button class="btn btn-primary add_button btn-sm"><i class="fa fa-plus"></i></button> -->
				                    </div>
				            	</div>
								<div class="sub_items" ></div>
							</span>
								<div class="items"></div>
			            </div>






			            <div class="form-group blocks">
			            	<div class="col-md-12">

			            		<label class="col-md-2 control-label">Cash</label>
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
			            		<div class="col-md-1" style="padding-right: 0px;">
			                            <a class="btn btn-primary btn-sm add_cash_button"><i class="fa fa-plus"></i></a>
			                    </div>
			            	</div>
							<div class="items_cash"></div>
			            </div>

			            <div class="form-group blocks">
			            	<div class="col-md-12">

			            		<label class="col-md-2 control-label">Gold</label>
			            		<div class="col-md-1">
			            			<select name="gold_type[]" class="form-control">
			            				<!-- <option value="">----Select Gold----</option> -->
			            				<option value="1">IN</option>
			            				<option value="2">OUT</option>
			            			</select>
			            		</div>
			            		<div class="col-md-2">
			            			<input type="text" placeholder="Gross Weight" name="gross_gold_weight[]" class="form-control ">
			            		</div>
			            		<div class="col-md-2">
			            			<input type="text" placeholder="Enter Weight" name="gold_weight[]" class="form-control gold_amount_js">
			            		</div>
			            		<div class="col-md-2">
			            			<input type="text" placeholder="Enter Gold Amount" name="gold_amount[]" class="form-control gold_amount_js">
			            		</div>
			            		<div class="col-md-2">
		            				<input type="text" name="gold_description[]"  class="form-control" placeholder="Enter Note">
		            			</div>
			            		<div class="col-md-1" style="padding-right: 0px;">
			                            <button class="btn btn-primary btn-sm add_gold_button"><i class="fa fa-plus"></i></button>
			                    </div>
			            	</div>
							<div class="items_gold"></div>
			            </div>


			            <div class="form-group blocks">
			            	<div class="col-md-12">

			            		<label class="col-md-2 control-label">Diamond</label>
			            		<div class="col-md-2">
			            			<select name="diamond_type[]" class="form-control">
			            				<!-- <option value="">----Select Diamond----</option> -->
			            				<option value="1">IN</option>
			            				<option value="2">OUT</option>
			            			</select>
			            		</div>
			            		<div class="col-md-2">
			            			<input type="text" placeholder="Enter Weight" name="diamond_weight[]" class="form-control gold_amount_js">
			            		</div>
			            		<div class="col-md-2">
			            			<input type="text" placeholder="Enter Diamond Amount" name="diamond_amount[]" class="form-control gold_amount_js">
			            		</div>
			            		<div class="col-md-3">
		            				<input type="text" name="diamond_description[]"  class="form-control" placeholder="Enter Note">
		            			</div>
			            		<div class="col-md-1" style="padding-right: 0px;">
			                            <button class="btn btn-primary btn-sm add_diamond_button"><i class="fa fa-plus"></i></button>
			                    </div>
			            	</div>
							<div class="items_diamond"></div>
			            </div>

			            <div class="form-group blocks">
			            	<div class="col-md-12">

			            		<label class="col-md-2 control-label">Bank</label>
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
			            		<div class="col-md-1" style="padding-right: 0px;">
			                            <button class="btn btn-primary btn-sm add_bank_button"><i class="fa fa-plus"></i></button>
			                    </div>
			            	</div>
							<div class="items_bank"></div>
			            </div>


			            <div class="form-group blocks">
			            	<div class="col-md-12">

			            		<label class="col-md-2 control-label">Card</label>
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
			            		<div class="col-md-1" style="padding-right: 0px;">
		                            <button class="btn btn-primary btn-sm add_card_button"><i class="fa fa-plus"></i></button>
			                    </div>
			            	</div>
							<div class="items_card"></div>
			            </div>


			            <div class="form-group blocks">
			            	<div class="col-md-12">
			            		<label class="col-md-2 control-label">Discount</label>
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
		                          <!--   <a class="btn btn-primary btn-sm add_discount_button"><i class="fa fa-plus"></i></a> -->
			                    </div>
			            	</div>
							<div class="items_discount"></div>
			            </div>	



			            <div class="form-group">
							<div class="col-md-12">
								<?php echo $form->labelEx($model,'main_note', array('class' => 'col-md-2 control-label')); ?>
								<div class="col-md-6">
								<?php  echo $form->textArea($model,'main_note', array('class' => 'form-control','placeholder'=>'Enter note')); 
								?>
								<?php echo $form->error($model,'main_note'); ?>
								</div>
							</div>
						</div>
			          

						<?php
						}
						?>

						<?php 

						if(!$model->isNewRecord)
						{
							$select_user_type = Customer::model()->findByPk($model->customer_id);
							$c_type = 2;
							if($select_user_type)
								$c_type = $select_user_type->type;

							
						 ?>

						 <div class="form-group">
								<div class="col-md-12">
									<?php echo $form->labelEx($model,'Customer Type', array('class' => 'col-md-2 control-label')); ?>
									<div class="col-md-6">
										<select name="customer_type" class="form-control customer_type">
											<option value="">---Select Customer Type---</option>
											<option value="1" <?php if($c_type == 1){ echo 'selected'; }?> >Supplier</option>
											<option value="2" <?php if($c_type == 2){ echo 'selected'; }?> >Customer</option>
											<option value="3" <?php if($c_type == 3){ echo 'selected'; }?> >Karigar</option>
										</select>
									</div>
								<a href="javascript:void(0)" class = 'btn btn-effect-ripple btn-info btn-lg tech_popup fa fa-user-plus'> Create Customer</a>
								</div>
						</div>

						<div class="form-group">
							<div class="col-md-12">
							<?php echo $form->labelEx($model,'customer_id', array('class' => 'col-md-2 control-label')); ?>
							<div class="col-md-6">
							<?php 
								echo $form->dropDownList($model,'customer_id',CHtml::listData(Customer::model()->findAll(array("condition"=>"is_deleted = 0 AND type=$c_type")),'id','name'),
									array(
										'prompt'=>'----Select Customer----',
										'class'=>'form-control customer_list',
									)); 
							?>
							<?php echo $form->error($model,'customer_id'); ?>
							</div>
								<!-- <a href="javascript:void(0)" class = 'btn btn-effect-ripple btn-info btn-lg tech_popup fa fa-user-plus'> Create Customer</a> -->
						    </div>
			     		</div>


			     		<div class="form-group">
							<div class="col-md-12">
								<?php echo $form->labelEx($model,'narration', array('class' => 'col-md-2 control-label')); ?>
								<div class="col-md-6">
								<?php  echo $form->textField($model,'narration', array('class' => 'form-control','placeholder'=>'Enter Related Person')); 
									
								?>
								<?php echo $form->error($model,'narration'); ?>
								</div>
							</div>
						</div>
							<div class="form-group">
								<div class="col-md-12">
									<?php echo $form->labelEx($model,'referral_code', array('class' => 'col-md-2 control-label')); ?>
									<div class="col-md-6">
									<?php  echo $form->textField($model,'referral_code', array('class' => 'form-control','placeholder'=>'Enter Bill Number')); 
									?>
									<?php echo $form->error($model,'referral_code'); ?>
									</div>
								</div>
							</div>

						<div class="form-group">
							<div class="col-md-12">
							<?php echo $form->labelEx($model,'created_date', array('class' => 'col-md-2 control-label')); ?>
							<div class="col-md-3">

							<?php 
								echo $form->textField($model,'created_date', array('class' => 'form-control','autocomplete'=>'off','placeholder'=>'dd-mm-yyyy')); 
							// echo $form->textField($model,'created_date', array('class' => 'form-control input-datepicker','data-date-format'=>"dd-mm-yyyy",'readonly'=>"readonly" ,'autocomplete'=>'off')); 
							?>
							<?php echo $form->error($model,'created_date'); ?>
							</div>
						  </div>
					  </div>


					  <div class="form-group delete_main_item">
					  <?php
					  	$item_count = 0;
						$update_name = 0;
						foreach ($cash_log_type as $key => $value_item)
						{
							if($value_item->type == 6)
							{
								$item_count = 1;
								
						?>
							<div class="col-md-12 delete_span_sub" style="margin-top:10px;">
			            		<label class="col-md-2 control-label">Item</label>
			            		<div class="col-md-3">
			            			<input type="text" placeholder="Enter Item Name" name="note[<?php echo $update_name;?>]" id="item" class="form-control nameclass item_note main_item_req" value="<?php echo $value_item->note; ?>">
			            		</div>
			            		<div class="col-md-2">
			            			<input type="text" placeholder="Gross Weight" name="gross_weight[<?php echo $update_name;?>]" class="form-control gross_weight" value="<?php echo $value_item->gross_weight; ?>">
			            		</div>
			            		<div class="col-md-2">
			            			<input type="text" placeholder="Enter Weight" name="weight[<?php echo $update_name;?>]" class="form-control gold_amount_js item_weight" value="<?php echo abs($value_item->weight); ?>">
			            		</div>
			            		<div class="col-md-2">
			            			<input type="hidden" name="item_id[<?php echo $update_name;?>]" value="<?php echo $value_item->id; ?>">
			            			<input type="text" placeholder="Enter Amount" name="amount[<?php echo $update_name;?>]" id="amount" class="form-control nameclass numeric_amount gold_amount_js item_amount" value="<?php echo abs($value_item->amount); ?>">
			            		</div>
			            	
			            		<div class="col-md-1" style="padding-right: 0px;">
			                        <button class="btn btn-primary btn-sm add_button"><i class="fa fa-plus"></i></button>
					            	<button class="btn btn-danger btn-sm delete_record" data-item="1" data-id="<?php echo $value_item->id;?>" data-date="<?php echo $value_item->check_date;?>"><i class="fa fa-times"></i></button>
			                    </div>

			                    <?php
			                    	// echo $value_item->id;
			                    	$sub_item=Cashlogs::model()->findAllByAttributes(array('item_id'=>$value_item->id));
			                    	foreach ($sub_item as $key => $value_sub) 
			                    	{
			                    		// echo $value_sub->weight;
			                    		if(!empty($value_sub->id))
			                    		{
			                    ?>
				                    <span data-id="<?php echo $update_name;?>" class="note2 notes">

				                    	<span class="sub_item_delete">
						            	<!-- <div class="col-md-12" style="margin-top: 10px;"> -->
						            		<label class="col-md-2 control-label">Sub Item</label>
						            		<div class="col-md-3">
						            			<!-- <label>Item</label> -->
						            			<input type="text" placeholder="Enter Sub Item Name" name="sub_note[<?php echo $update_name;?>][]" id="" class="form-control nameclass sub_item_note" value="<?php echo $value_sub->note; ?>" >
						            		</div>
						            		<div class="col-md-3">
						            			<input type="text" placeholder="Enter Weight" name="sub_weight[<?php echo $update_name;?>][]" class="form-control gold_amount_js sub_item_weight" value="<?php echo abs($value_sub->weight); ?>">
						            		</div>
						            		<div class="col-md-3">
						            			<input type="hidden" name="sub_item_id[<?php echo $update_name;?>][]" value="<?php echo $value_sub->id; ?>">
						            			<input type="text" placeholder="Enter Amount" name="sub_amount[<?php echo $update_name;?>][]" id="amount" class="form-control nameclass numeric_amount gold_amount_js sub_item_amount" value="<?php echo abs($value_sub->amount); ?>">
						            		</div>
						            		<div class="col-md-1" style="padding-right: 0px;">
						                            <button class="btn btn-primary add_sub_button btn-sm" data-name="<?php echo $update_name;?>"><i class="fa fa-plus"></i></button> 
						                             <a class="btn btn-danger btn-sm delete_record" data-item="2" data-id="<?php echo $value_sub->id; ?>" data-date="<?php echo $value_sub->check_date;?>"><i class="fa fa-times"></i></a>
						                            <!--  <button class="btn btn-danger sub_remove btn-sm"><i class="fa fa-times"></i></button> -->
						                    </div>
					                    </span>
						            	<!-- </div> -->
										<div class="sub_items" ></div>
									</span>
								<?php
									}
		                		}	

		                		if(empty($sub_item))
		                		{
		                			?>
		                				<span data-id="<?php echo $update_name;?>" class="note2 notes">
						            	<!-- <div class="col-md-12" style="margin-top: 10px;"> -->
						            		<label class="col-md-2 control-label">Sub Item</label>
						            		<div class="col-md-3">
						            			<!-- <label>Item</label> -->
						            			<input type="text" placeholder="Enter Sub Item Name" name="sub_note[<?php echo $update_name;?>][]" id="" class="form-control nameclass sub_item_note">
						            		</div>
						            		<div class="col-md-3">
						            			<input type="text" placeholder="Enter Weight" name="sub_weight[<?php echo $update_name;?>][]" class="form-control gold_amount_js sub_item_weight">
						            		</div>
						            		<div class="col-md-3">
						            			<input type="text" placeholder="Enter Amount" name="sub_amount[<?php echo $update_name;?>][]" id="amount" class="form-control nameclass numeric_amount gold_amount_js sub_item_amount">
						            		</div>
						            		<div class="col-md-1" style="padding-right: 0px;">
						                            <button class="btn btn-primary add_sub_button btn-sm"><i class="fa fa-plus"></i></button> 
						                             <button class="btn btn-danger sub_remove btn-sm"><i class="fa fa-times"></i></button>
						                    </div>
						            	<!-- </div> -->
										<div class="sub_items" ></div>
									</span>
		                			<?php

		                		}

								?>
		        			</div>
							<?php
								$update_name++;
							}
						}
							if($item_count == 0)
							{
						?>

							<div class="col-md-12" style="margin-top:10px;">
				            		<label class="col-md-2 control-label">Item</label>
				            		<div class="col-md-3">
				            			<input type="text" placeholder="Enter Item Name" name="note[<?php echo $update_name;?>]" id="item" class="form-control nameclass item_note main_item_req" value="">
				            		</div>
				            		<div class="col-md-2">
				            			<input type="text" placeholder="Gross Weight" name="gross_weight[<?php echo $update_name;?>]" class="form-control gross_weight">
				            		</div>
				            		<div class="col-md-2">
				            			<input type="text" placeholder="Enter Weight" name="weight[<?php echo $update_name;?>]" class="form-control gold_amount_js item_weight">
				            		</div>
				            		<div class="col-md-2">
				            			<input type="text" placeholder="Enter Amount" name="amount[<?php echo $update_name;?>]" id="amount" class="form-control nameclass numeric_amount gold_amount_js item_amount" value="">
				            		</div>
				            		<!-- <div class="col-md-3">
			            				<textarea name="note_detail[]" id="note" class="form-control" placeholder="Enter Note"></textarea>
			            			</div> -->
				            		<div class="col-md-1" style="padding-right: 0px;">
				                        <button class="btn btn-primary btn-sm add_button"><i class="fa fa-plus"></i></button>
				                    </div>

				                     <span data-id="0" class="note2 notes">
						            	<!-- <div class="col-md-12" style="margin-top: 10px;"> -->
						            		<label class="col-md-2 control-label">Sub Item</label>
						            		<div class="col-md-3">
						            			<!-- <label>Item</label> -->
						            			<input type="text" placeholder="Enter Sub Item Name" name="sub_note[<?php echo $update_name;?>][]" id="" class="form-control nameclass sub_item_note">
						            		</div>
						            		<div class="col-md-3">
						            			<input type="text" placeholder="Enter Weight" name="sub_weight[<?php echo $update_name;?>][]" class="form-control gold_amount_js sub_item_weight">
						            		</div>
						            		<div class="col-md-3">
						            			<input type="text" placeholder="Enter Amount" name="sub_amount[<?php echo $update_name;?>][]" id="amount" class="form-control nameclass numeric_amount gold_amount_js sub_item_amount">
						            		</div>
						            		<div class="col-md-1" style="padding-right: 0px;">
						                            <button class="btn btn-primary add_sub_button btn-sm" data-name="<?php echo $update_name;?>"><i class="fa fa-plus"></i></button> 
						                             
						                            <!--  <a class="btn btn-danger btn-sm delete_record" data-id="<?php ?>" data-date="<?php ?>"><i class="fa fa-times"></i></a> -->

						                            <!--  <button class="btn btn-danger sub_remove btn-sm"><i class="fa fa-times"></i></button> -->
						                    </div>
						            	<!-- </div> -->
										<div class="sub_items" ></div>
									</span>
		        			</div>

						<?php		
							}
						?>
							<div class="items"></div>
			            </div>


			            <div class="form-group">
			            	<?php
			            		$cash_count = 0;
							foreach ($cash_log_type as $key => $value_cash)
							{
								if($value_cash->type == 1)
								{
									$cash_count = 1;
								?>
									<div class="col-md-12" style="margin-bottom: 10px;">
											<label class="col-md-2 control-label">Cash</label>
						            		<div class="col-md-3">
						            			<select name="cash_type[]" class="form-control">
						            				<!-- <option value="">----Select Cash----</option> -->
						            				<option value="1" <?php if($value_cash->status == 1){ echo 'selected'; }?> >IN</option>
						            				<option value="2" <?php if($value_cash->status == 2){ echo 'selected'; }?> >OUT</option>
						            			</select>
						            		</div>
						            		<div class="col-md-3">
						            			<input type="hidden" name="cash_id[]" value="<?php echo $value_cash->id; ?>">
						            			<input type="text" placeholder="Enter Cash Amount" name="cash_amount[]" class="form-control gold_amount_js" value="<?php echo abs($value_cash->amount); ?>">
						            		</div>
						            		<div class="col-md-3">
					            				<input type="text" name="cash_description[]"  class="form-control" placeholder="Enter Note" value="<?php echo $value_cash->description; ?>">
					            			</div>
						            		<div class="col-md-1" style="padding-right: 0px;">
						                            <a class="btn btn-primary btn-sm add_cash_button"><i class="fa fa-plus"></i></a>
						                            <a class="btn btn-danger btn-sm delete_record" data-id="<?php echo $value_cash->id;?>" data-date="<?php echo $value_cash->check_date;?>"><i class="fa fa-times"></i></a> 
						                    </div>
									</div>	

								<?php
								}
							}	
								if($cash_count == 0)
								{
								?>
						            	<div class="col-md-12">
						            		<label class="col-md-2 control-label">Cash</label>
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
								<?php
								}
							?>
								<div class="items_cash"></div>
				            </div>


			       	      <div class="form-group">
			            	<?php
			            		$gold_count = 0;
							foreach ($cash_log_type as $key => $value_gold)
							{
								if($value_gold->type == 2)
								{
									$gold_count = 1;
								?>
									<div class="col-md-12" style="margin-bottom: 10px;">
														
										<label class="col-md-2 control-label">Gold</label>
					            		<div class="col-md-1">
					            			<select name="gold_type[]" class="form-control">
					            				<option value="1" <?php if($value_gold->status == 1){ echo "selected"; } ?> >IN</option>
					            				<option value="2"  <?php if($value_gold->status == 2){ echo "selected"; } ?>>OUT</option>
					            			</select>
					            		</div>
						            	<div class="col-md-2">
						            			<input type="text" placeholder="Gross Weight" name="gross_gold_weight[]" class="form-control" value="<?php echo $value_gold->gross_weight; ?>">
						            	</div>
					            		<div class="col-md-2">
						            			<input type="text" placeholder="Enter Weight" name="gold_weight[]" class="form-control gold_amount_js" value="<?php echo abs($value_gold->weight); ?>">
						            	</div>
					            		<div class="col-md-2">
					            			<input type="hidden" name="gold_id[]" value="<?php echo $value_gold->id; ?>">
					            			<input type="text" placeholder="Enter Gold Amount" name="gold_amount[]" class="form-control gold_amount_js" value="<?php echo abs($value_gold->amount); ?>">
					            		</div>
					            		<div class="col-md-2">
				            				<input type="text" name="gold_description[]"  class="form-control" placeholder="Enter Note" value="<?php echo $value_gold->description; ?>">
				            			</div>
					            		<div class="col-md-1" style="padding-right: 0px;">
					                            <button class="btn btn-primary btn-sm add_gold_button"><i class="fa fa-plus"></i></button>
					                             <button class="btn btn-danger btn-sm delete_record" data-id="<?php echo $value_gold->id;?>" data-date="<?php echo $value_gold->check_date;?>"><i class="fa fa-times"></i></button>
					                    </div>

								</div>

								<?php
								}
							}	
								if($gold_count == 0)
								{
								?>

									<div class="col-md-12">
										<label class="col-md-2 control-label">Gold</label>
					            		<div class="col-md-1">
					            			<select name="gold_type[]" class="form-control">
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
					            			<input type="text" placeholder="Enter Gold Amount" name="gold_amount[]" class="form-control gold_amount_js">
					            		</div>
					            		<div class="col-md-2">
				            				<input type="text" name="gold_description[]"  class="form-control" placeholder="Enter Note">
				            			</div>
					            		<div class="col-md-1" style="padding-right: 0px;">
					                            <button class="btn btn-primary btn-sm add_gold_button"><i class="fa fa-plus"></i></button>
					                    </div>
					            	</div>
								<?php
								}
							?>
							<div class="items_gold"></div>
						</div>



						 <div class="form-group">
			            	<?php
			            		$diamond_count = 0;
							foreach ($cash_log_type as $key => $value_diamond)
							{
								if($value_diamond->type == 7)
								{
									$diamond_count = 1;
								?>

									<div class="col-md-12" style="margin-bottom: 10px;">
														
										<label class="col-md-2 control-label">Diamond</label>
					            		<div class="col-md-2">
					            			<select name="diamond_type[]" class="form-control">
					            				<!-- <option value="">----Select Diamond----</option> -->
					            				<option value="1" <?php if($value_diamond->status == 1){ echo "selected"; }?> >IN</option>
					            				<option value="2" <?php if($value_diamond->status == 2){ echo "selected"; }?> >OUT</option>
					            			</select>
					            		</div>
					            		<div class="col-md-2">
						            			<input type="text" placeholder="Enter Weight" name="diamond_weight[]" class="form-control gold_amount_js" value="<?php echo abs($value_diamond->weight); ?>">
						            	</div>
					            		<div class="col-md-2">

					            			<input type="hidden" name="diamond_id[]" value="<?php echo $value_diamond->id; ?>">

					            			<input type="text" placeholder="Enter Diamond Amount" name="diamond_amount[]" class="form-control gold_amount_js" value="<?php echo abs($value_diamond->amount); ?>">
					            		</div>
					            		<div class="col-md-3">
				            				<input type="text" name="diamond_description[]"  class="form-control" placeholder="Enter Note" value="<?php echo $value_diamond->description; ?>">
				            			</div>
					            		<div class="col-md-1" style="padding-right: 0px;">
					                            <button class="btn btn-primary btn-sm add_diamond_button"><i class="fa fa-plus"></i></button>
					                             <button class="btn btn-danger btn-sm delete_record" data-id="<?php echo $value_diamond->id;?>" data-date="<?php echo $value_diamond->check_date;?>"><i class="fa fa-times"></i></button>
					                    </div>

								</div>

								<?php
								}
							}	
								if($diamond_count == 0)
								{
								?>

									<div class="col-md-12">
												
										<label class="col-md-2 control-label">Diamond</label>
					            		<div class="col-md-2">
					            			<select name="diamond_type[]" class="form-control">
					            				<!-- <option value="">----Select Diamond----</option> -->
					            				<option value="1">IN</option>
					            				<option value="2">OUT</option>
					            			</select>
					            		</div>
					            		<div class="col-md-2">
					            			<input type="text" placeholder="Enter Weight" name="diamond_weight[]" class="form-control gold_amount_js">
					            		</div>
					            		<div class="col-md-2">
					            			<input type="text" placeholder="Enter Diamond Amount" name="diamond_amount[]" class="form-control gold_amount_js">
					            		</div>
					            		<div class="col-md-3">
				            				<input type="text" name="diamond_description[]"  class="form-control" placeholder="Enter Note">
				            			</div>
					            		<div class="col-md-1" style="padding-right: 0px;">
					                            <button class="btn btn-primary btn-sm add_diamond_button"><i class="fa fa-plus"></i></button>
					                    </div>
					            	</div>

								<?php
								}
							?>
							<div class="items_diamond"></div>
							</div>



							<div class="form-group">
			            	<?php
			            		$bank_count = 0;
							foreach ($cash_log_type as $key => $value_bank)
							{
								if($value_bank->type == 3)
								{
									$bank_count = 1;
								?>

									<div class="col-md-12"  style="margin-bottom: 10px;">
											
											<label class="col-md-2 control-label">Bank</label>
							            		<div class="col-md-3">
							            			<select name="bank_type[]" class="form-control">
							            				<!-- <option value="">----Select Bank----</option> -->
							            				<option value="1" <?php if($value_bank->status == 1){ echo "selected";}?> >IN</option>
							            				<option value="2" <?php if($value_bank->status == 2){ echo "selected";}?> >OUT</option>
							            			</select>
							            		</div>
							            		<div class="col-md-3">

						            				<input type="hidden" name="bank_id[]" value="<?php echo $value_bank->id; ?>">

							            			<input type="text" placeholder="Enter Bank Amount" name="bank_amount[]" class="form-control gold_amount_js" value="<?php echo abs($value_bank->amount); ?>">
							            		</div>
							            		<div class="col-md-3">
						            				<input type="text" name="bank_description[]"  class="form-control" placeholder="Enter Note" value="<?php echo $value_bank->description;?>">
						            			
						            			</div>
							            		<div class="col-md-1" style="padding-right: 0px;">
							                            <button class="btn btn-primary btn-sm add_bank_button"><i class="fa fa-plus"></i></button>
							            			  <button class="btn btn-danger btn-sm delete_record" data-id="<?php echo $value_bank->id;?>" data-date="<?php echo $value_bank->check_date;?>"><i class="fa fa-times"></i></button>
							                    </div>

										</div>

								<?php
								}
							}	
								if($bank_count == 0)
								{
								?>	

									<div class="col-md-12">
										<label class="col-md-2 control-label">Bank</label>
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
							            		<div class="col-md-1" style="padding-right: 0px;">
							                            <button class="btn btn-primary btn-sm add_bank_button"><i class="fa fa-plus"></i></button>
							                    </div>
						            	</div>
								<?php
								}
							?>
							<div class="items_bank"></div>
							</div>


							<div class="form-group">
			            	<?php
			            		$card_count = 0;
							foreach ($cash_log_type as $key => $value_card)
							{
								if($value_card->type == 4)
								{
									$card_count = 1;
								?>

									<div class="col-md-12"  style="margin-bottom: 10px;">
											<label class="col-md-2 control-label">Card</label>
							            		<div class="col-md-3">
							            			<select name="card_type[]" class="form-control">
							            				<!-- <option value="">----Select Card----</option> -->
							            				<option value="1" <?php if($value_card->status == 1){ echo "selected"; }?> >IN</option>
							            				<option value="2" <?php if($value_card->status == 2){ echo "selected"; }?> >OUT</option>
							            			</select>
							            		</div>
							            		<div class="col-md-3">
 													<input type="hidden" name="card_id[]" value="<?php echo $value_card->id; ?>">
							            			<input type="text" placeholder="Enter Card Amount" name="card_amount[]" class="form-control gold_amount_js" value="<?php echo abs($value_card->amount); ?>">
							            		</div>
							            		<div class="col-md-3">
						            				<input type="text" name="card_description[]"  class="form-control" placeholder="Enter Note" value="<?php echo $value_card->description; ?>">
						            			</div>
							            		<div class="col-md-1" style="padding-right: 0px;">
						                            <button class="btn btn-primary btn-sm add_card_button"><i class="fa fa-plus"></i></button>
						                             <button class="btn btn-danger btn-sm delete_record" data-id="<?php echo $value_card->id;?>" data-date="<?php echo $value_card->check_date;?>"><i class="fa fa-times"></i></button>
							                    </div>
											</div>
										
								<?php
								}
							}	
								if($card_count == 0)
								{
								?>
									<div class="col-md-12">
											<label class="col-md-2 control-label">Card</label>
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
							            		<div class="col-md-1" style="padding-right: 0px;">
						                            <button class="btn btn-primary btn-sm add_card_button"><i class="fa fa-plus"></i></button>
							                    </div>
										</div>
								<?php
								}
							?>
								<div class="items_card"></div>
							</div>


							<div class="form-group">
			            	<?php
			            		$dis_count = 0;
							foreach ($cash_log_type as $key => $value_dis)
							{
								if($value_dis->type == 5)
								{
									$dis_count = 1;
								?>
								
								<div class="col-md-12"  style="margin-bottom: 10px;">
									
										<label class="col-md-2 control-label">Discount</label>
						            		<div class="col-md-3">
						            			<select name="discount_type[]" class="form-control">
						            				<!-- <option value="">----Select Discount----</option> -->
						            				<option value="1" <?php if($value_dis->status == 1){ echo "selected";}?> >IN</option>
						            				<option value="2"  <?php if($value_dis->status == 2){ echo "selected";}?> >OUT</option>
						            			</select>
						            		</div>
						            		<div class="col-md-3">
						            			
						            			<input type="hidden" name="dis_id[]" value="<?php echo $value_dis->id; ?>">
						            			<input type="text" placeholder="Enter Discount Amount" name="discount_amount[]" class="form-control gold_amount_js" value="<?php echo abs($value_dis->amount); ?>">
						            		</div>
						            		<div class="col-md-3">
					            				<input type="text" name="discount_description[]"  class="form-control" placeholder="Enter Note" value="<?php echo $value_dis->description;?>">
					            			</div>
						            		<div class="col-md-1" style="padding-right: 0px;">
						                          <!--   <a class="btn btn-primary btn-sm add_discount_button"><i class="fa fa-plus"></i></a> -->
						                             <a class="btn btn-danger btn-sm delete_record all_delete_discount" data-id="<?php echo $value_dis->id;?>" data-date="<?php echo $value_dis->check_date;?>"><i class="fa fa-times"></i></a> 
						                    </div>
									</div>
									<div class="new_dicount"></div>
								<?php
								}
							}	
								if($dis_count == 0)
								{
								?>	
									<div class="col-md-12">
											<label class="col-md-2 control-label">Discount</label>
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
						            		<div class="col-md-1" style="padding-right: 0px;">
					                           <!--  <a class="btn btn-primary btn-sm add_discount_button"><i class="fa fa-plus"></i></a> -->
						                    </div>
										</div>
					                    

								<?php
								}
							?>
								<div class="items_discount"></div>
							</div>

						<div class="form-group">
							<div class="col-md-12">
								<?php echo $form->labelEx($model,'main_note', array('class' => 'col-md-2 control-label')); ?>
								<div class="col-md-6">
								<?php  echo $form->textArea($model,'main_note', array('class' => 'form-control','placeholder'=>'Enter note')); 
								?>
								<?php echo $form->error($model,'main_note'); ?>
								</div>
							</div>
						</div>
						<?php
						}
						?>

					<div class="form-group form-actions">
				        <div class="col-md-9 col-md-offset-3">
				            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('yii','Save') : Yii::t('yii','Save'), array('class' => 'btn btn-effect-ripple btn-primary submit')); ?>

				            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('yii','Print') : Yii::t('yii','Print'), array('class' => 'btn btn-effect-ripple btn-info submit','name'=>'print','value'=>'Print')); ?>
				            <?php echo CHtml::link(Yii::t('yii','Cancel'), array('admin'), array('class' => 'btn btn-effect-ripple btn-danger')) ?>
				        </div>
				    </div>	

				<?php $this->endWidget(); ?>
			</div>
	</div>
</div>

					<!-- open Popup add customer -->
						<div class="modal fade" id="empModal" role="dialog">
						    <div class="modal-dialog" style="width:650px;">
						      <div class="modal-content">
						         <div class="modal-header">
						           <!--  <h4 class="modal-title">Cash Event</h4> -->
						             <button type="button" class="close" data-dismiss="modal">&times;</button>
						             <h4 class="modal-title"><b>Add Customer</b></h4>
						         </div>
						          <div class="modal-body">
						          </div>
						          <div class="modal-footer">
						             <!--    <button type="button" class="btn btn-success save_tech">Save</button>
						                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> -->
						          </div>
						      </div>
						    </div>
						</div>



						<!-- Item Add more -->
 					


			        <!-- Item sub Add more -->
 					



			        <!-- Cash Add more -->

			        <div class="form-group hidden add-more-cash">
			            	<div class="blocks col-md-12" style="margin-top: 10px;">
			            		<label class="col-md-2 control-label">Cash</label>
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
				            		<div class="col-md-1 all_delete_cash" style="padding-right: 0px;">
				                            <button class="btn btn-primary btn-sm add_cash_button"><i class="fa fa-plus"></i></button>
						            <button class="btn btn-danger btn-sm cash_remove"><i class="fa fa-times"></i></button>
				                    </div>
			                     <div class="col-md-1">
						        </div>
			            	</div>
			        </div>

			        <!-- Gold Add more -->

			        <div class="form-group hidden add-more-gold">
			            	<div class="blocks col-md-12" style="margin-top: 10px;">
			            		<label class="col-md-2 control-label">Gold</label>
				            		<div class="col-md-1">
				            			<select name="gold_type[]" class="form-control">
				            				<!-- <option value="">----Select Gold----</option> -->
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
				            			<input type="text" placeholder="Enter Gold Amount" name="gold_amount[]" class="form-control gold_amount_js">
				            		</div>
				            		<div class="col-md-2">
			            				<input type="text" name="gold_description[]"  class="form-control" placeholder="Enter Note">
			            			</div>
				            		<div class="col-md-1" style="padding-right: 0px;">
				                            <button class="btn btn-primary btn-sm add_gold_button"><i class="fa fa-plus"></i></button>
						           			<button class="btn btn-danger btn-sm gold_remove"><i class="fa fa-times"></i></button>
				                    </div>
			            	</div>
			        </div>

			        <!-- Diamond Add more -->

        				<div class="form-group hidden add-more-diamond">
			            	<div class="blocks col-md-12" style="margin-top: 10px;">
			            		<label class="col-md-2 control-label">Diamond</label>
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
				            			<input type="text" placeholder="Enter Diamond Amount" name="diamond_amount[]" class="form-control gold_amount_js">
				            		</div>
				            		<div class="col-md-3">
			            				<input type="text" name="diamond_description[]"  class="form-control" placeholder="Enter Note">
			            			</div>
				            		<div class="col-md-1" style="padding-right: 0px;">
				                            <button class="btn btn-primary btn-sm add_diamond_button"><i class="fa fa-plus"></i></button>
						           			<button class="btn btn-danger btn-sm diamond_remove"><i class="fa fa-times"></i></button>
				                    </div>
			            	</div>
			        </div>

		        <!-- Bank Add more -->

			        <div class="form-group hidden add-more-bank">
			            	<div class="blocks col-md-12" style="margin-top: 10px;">
			            		<label class="col-md-2 control-label">Bank</label>
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
				            		<div class="col-md-1" style="padding-right: 0px;">
			                            <button class="btn btn-primary btn-sm add_bank_button"><i class="fa fa-plus"></i></button>
					            		<button class="btn btn-danger btn-sm bank_remove"><i class="fa fa-times"></i></button>
				                    </div>
			                     <div class="col-md-1">
						        </div>
			            	</div>
			        </div>

		        <!-- Card Add more -->

			        <div class="form-group hidden add-more-card">
		            	<div class="blocks col-md-12" style="margin-top: 10px;">
		            		<label class="col-md-2 control-label">Card</label>
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
			            		<div class="col-md-1" style="padding-right: 0px;">
		                            <button class="btn btn-primary btn-sm add_card_button"><i class="fa fa-plus"></i></button>
				            		<button class="btn btn-danger btn-sm card_remove"><i class="fa fa-times"></i></button>
			                    </div>
		                     <div class="col-md-1">
					        </div>
		            	</div>
			        </div>

		        <!-- Discount Add more -->

			         <div class="form-group hidden add-more-discount">
		            	<div class="blocks col-md-12" style="margin-top: 10px;">
		            		<label class="col-md-2 control-label">Discount</label>
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
			            		<div class="col-md-1" style="padding-right: 0px;">
		                           <!--  <button class="btn btn-primary btn-sm add_discount_button"><i class="fa fa-plus"></i></button>
				            		<button class="btn btn-danger btn-sm discount_remove"><i class="fa fa-times"></i></button> -->
			                    </div>
		                     <div class="col-md-1">
					        </div>
		            	</div>
			        </div>
			          


  <script type="text/javascript">

	 /*$(document).ready(function()
	{
        $("#cashevent-form").submit(function(event)
        {            
            var valid = true;
            $('.errormsg').remove();
            $("#cashevent-form .main_item_req").each(function() {
                if( ! $(this).val() ){
                    $(this).after('<span class="text-danger errormsg errorMessage  help-block animation-slideUp form-error">'+$(this).attr('id')+' cannot be blank.</span>');
                    valid = false;
                }
            });
            
            if (!valid)
            {
                return false;
            }
            else
            {
                return true;
                 
             }
            event.preventDefault();

        });
    }); */

		$(document).ready(function()
		{
			$("#Cashevent_created_date").mask("99-99-9999");
		}); 

  		$('body').on('change','.customer_type',function()
  		{
  			var customer_type = $('.customer_type option:selected').val();
  			// alert(customer_type);
  			// if(customer_type != "")
  			// {
  				 $.ajax({
                 url:'<?php echo Yii::app()->createUrl("customer/get_type_customer");?>',
                 method:"POST",  
                 data:{customer_type:customer_type},
              		success: function(data)
               		{ 
               			$('.customer_list').empty();
               			$('.customer_list').append(data);
             		}
              });
  			// }
			
		});

  		$('body').on('click','.tech_popup',function(){
           // var cust_id = $(this).data('id');
          //alert(order_id);
          //AJAX request
           $.ajax({
             url:'<?php echo Yii::app()->createUrl("customer/customer_popup");?>',
             method:"POST",  
             data:{}, 
            success: function(response){ 
              // Add response in Modal body
              $('.modal-body').html(response);
              // Display Modal
              $('.input-datepicker').datepicker({});
              $('#empModal').modal('show'); 
            }
          });
        });

        $('body').on('click','.add_button,.add_cash_button,.add_gold_button,.add_bank_button,.add_card_button,.remove ,.delete_record,.add_diamond_button ,.add_sub_button,.sub_remove',function(event)
        {
        	 event.preventDefault();
        });

  		$('body').on('submit','#customer-form',function(event)
        {
          event.preventDefault();
           var form_data = $('#customer-form').serialize();
           		// alert(form_data);
               $.ajax({
                 url:'<?php echo Yii::app()->createUrl("customer/create");?>',
                 method:"POST",  
                 data:form_data,
                success: function(data)
                { 
                    $('#empModal').modal('hide');
                    $('.save_tech').prop('disabled', false);
                    	update_select_customer();
                        var obj=$.parseJSON(data);
                        $('#errorMsg1').html(obj.msg);
                              $('#errorMsg1').addClass('alert alert-success');
                              $('#errorMsg1').show();
                                /* window.setTimeout(function () {
                                  $(".alert-success").fadeTo(500, 0).slideUp(500, function () {
                                      $(this).hide();
                                      $(this).css('opacity','100');
                                  });
                              }, 5000); */
                      }
              });
           // }
        });
		
  		function update_select_customer()
  		{
  			 $.ajax({
                 url:'<?php echo Yii::app()->createUrl("customer/get_customer");?>',
                 method:"POST",  
                 data:{},
              		success: function(data)
               		{ 
               			$('.customer_list').empty();
               			$('.customer_list').append(data);
	                    //var obj=$.parseJSON(data);
	                    //$('.items_cash').append(h);   
             		}
              });
  		}



  	   $(document).ready(function()
  	   {
  			// item Add more
	  	 	$('body').on('click','.add_button',function()
	  	 	{
	  	 		 var total_note=$('.item_note').length;
	  	 		 // alert(total_note);
	  	 		 // total_note++;
	  	 		 var name=total_note;
	            // var h = $('.add-more').html().replace('item-ele','item');
	            var h='<div class="blocks main_item col-md-12" style="margin-top: 30px;">\
			            		<label class="col-md-2 control-label">Item</label>\
			            		<div class="col-md-3">\
			            			<input type="text" placeholder="Enter Item Name" name="note['+name+']" id="item" class="form-control nameclass item_note main_item_req">\
			            		</div>\
			            		<div class="col-md-2">\
				            			<input type="text" placeholder="Gross Weight" name="gross_weight['+name+']" class="form-control gross_weight">\
			            		</div>\
			            		<div class="col-md-2">\
				            			<input type="text" placeholder="Enter Weight" name="weight['+name+']" class="form-control gold_amount_js item_weight">\
			            		</div>\
			            		<div class="col-md-2">\
			            			<input type="text" placeholder="Enter Amount" name="amount['+name+']" id="amount" class="form-control nameclass numeric_amount gold_amount_js item_amount">\
			            		</div>\
			            		<!-- <div class="col-md-3">\
			            			<input type="text" name="note_detail[]" id="note" class="form-control" placeholder="Enter Note">\
			            		</div> -->\
			            		<div class="col-md-1" style="padding-right: 0px;">\
		                            <button class="btn btn-primary add_button btn-sm"><i class="fa fa-plus"></i></button>\
						            <button class="btn btn-danger remove btn-sm"><i class="fa fa-times"></i></button>\
			                    </div>\
			                    <!--  <div class="col-md-1">\
						        </div> -->\
			            	</div>\
			            	<div class="blocks col-md-12" style="margin-top: 0px;">\
			            		<label class="col-md-2 control-label">Sub Item</label>\
			            		<div class="col-md-3">\
			            			<input type="text" placeholder="Enter Sub Item Name" name="sub_note['+name+'][]" id="item" class="form-control nameclass sub_item_note">\
			            		</div>\
			            		<div class="col-md-3">\
				            			<input type="text" placeholder="Enter Weight" name="sub_weight['+name+'][]" class="form-control gold_amount_js sub_item_weight">\
			            		</div>\
			            		<div class="col-md-3">\
			            			<input type="text" placeholder="Enter Amount" name="sub_amount['+name+'][]" id="amount" class="form-control nameclass numeric_amount gold_amount_js sub_item_amount">\
			            		</div>\
			            		<!-- <div class="col-md-3">\
			            			<input type="text" name="note_detail'+name+'[]" id="note" class="form-control" placeholder="Enter Note">\
			            		</div> -->\
			            		<div class="col-md-1" style="padding-right: 0px;">\
		                            <button class="btn btn-primary add_sub_button btn-sm"><i class="fa fa-plus"></i></button>\
						            <button class="btn btn-danger sub_remove btn-sm"><i class="fa fa-times"></i></button>\
			                    </div>\
			                    <!--  <div class="col-md-1">\
						        </div> -->\
			            	</div>\
			            	<span class="sub_items"></span>\
			        ';
	           
	            var html='<span data-id="'+total_note+'" class="note'+total_note+' notes">'+h+'</span>';
	            $('.items').append(html);
	        });

	  	   $('body').on('click','.remove',function(){

            	$(this).closest('.notes').remove();
            	 if($('.add_button:visible').length==0)
                {
                 	$(".add_button").trigger("click");
                }
                var i=0;
	  	   		$('.notes').each(function(key, index )
	  	   		{
	  	   			$(this).find('.item_note').attr('name','note['+i+']');
	  	   			$(this).find('.gross_weight').attr('name','gross_weight['+i+']');
	  	   			$(this).find('.item_weight').attr('name','weight['+i+']');
	  	   			$(this).find('.item_amount').attr('name','amount['+i+']');
	  	   			$(this).find('.sub_item_note').closest('.blocks').each(function(key1, index1 )
	  	   			{
	  	   				$(this).find('.sub_item_note').attr('name','sub_note['+i+'][]');
	  	   				$(this).find('.sub_item_weight').attr('name','sub_weight['+i+'][]');
	  	   				$(this).find('.sub_item_amount').attr('name','sub_amount['+i+'][]');
	  	   			});
	  	   			i++;
	  	   		});
        	});



	  	   $('body').on('click','.add_sub_button',function()
	  	 	{
	            // var h = $('.add-more-sub').html().replace('item-ele','item');
	            var name=$(this).closest('.notes').attr('data-id');
	            var h='<div class="blocks <?php if($model->isNewRecord){ ?> col-md-12 <?php }else {?> custom_class <?php } ?>" style="margin-top: 0px;">\
			            		<label class="col-md-2 control-label">Sub Item</label>\
			            		<div class="col-md-3">\
			            			<input type="text" placeholder="Enter Sub Item Name" name="sub_note['+name+'][]" id="item" class="form-control nameclass sub_item_note">\
			            		</div>\
			            		<div class="col-md-3">\
				            			<input type="text" placeholder="Enter Weight" name="sub_weight['+name+'][]" class="form-control gold_amount_js sub_item_weight">\
			            		</div>\
			            		<div class="col-md-3">\
			            			<input type="text" placeholder="Enter Amount" name="sub_amount['+name+'][]" id="amount" class="form-control nameclass numeric_amount gold_amount_js sub_item_amount">\
			            		</div>\
			            		<!-- <div class="col-md-3">\
			            			<input type="text" name="note_detail'+name+'[]" id="note" class="form-control" placeholder="Enter Note">\
			            		</div> -->\
			            		<div class="col-md-1" style="padding-right: 0px;">\
		                            <button class="btn btn-primary add_sub_button btn-sm"><i class="fa fa-plus"></i></button>\
						            <button class="btn btn-danger sub_remove btn-sm"><i class="fa fa-times"></i></button>\
			                    </div>\
			                    <!--  <div class="col-md-1">\
						        </div> -->\</div>\
';
	            $(this).closest('.notes').find('.sub_items').append(h);
	        });


	  	   $('body').on('click','.sub_remove',function(){
            	$(this).closest('.blocks').remove();
            	 if($('.add_sub_button:visible').length==0)
                {
                 	$(".add_sub_button").trigger("click");
                }

        	});


	  	  	// Cash Add more
	  	  $('body').on('click','.add_cash_button',function()
	  	 	{
	            var h = $('.add-more-cash').html().replace('item-ele','item');
	            $('.items_cash').append(h);
	        });

	  	  	$('body').on('click','.cash_remove',function()
	  	  	{
           		$(this).closest('.blocks').remove();
           		if($('.add_cash_button:visible').length==0)
                {
                 	$(".add_cash_button").trigger("click");
                }
        	});


	  	  // Gold Add more
	  	  $('body').on('click','.add_gold_button',function()
	  	 	{
	            var h = $('.add-more-gold').html().replace('item-ele','item');
	            $('.items_gold').append(h);
	        });

	  	  $('body').on('click','.gold_remove',function(){
           		 $(this).closest('.blocks').remove();
           		if($('.add_gold_button:visible').length==0)
                {
                 	$(".add_gold_button").trigger("click");
                }
        	});

	  	   // Diamond Add more
	  	  	$('body').on('click','.add_diamond_button',function()
	  	 	{
	            var h = $('.add-more-diamond').html().replace('item-ele','item');
	            $('.items_diamond').append(h);
	        });

	  	 	$('body').on('click','.diamond_remove',function(){
           		 $(this).closest('.blocks').remove();
           		 if($('.add_diamond_button:visible').length==0)
                {
                 	$(".add_diamond_button").trigger("click");
                }
        	});	


	  	   // Bank Add more
	  	  $('body').on('click','.add_bank_button',function()
	  	 	{
	            var h = $('.add-more-bank').html().replace('item-ele','item');
	            $('.items_bank').append(h);
	        });

	  	  $('body').on('click','.bank_remove',function(){
           		 $(this).closest('.blocks').remove();
           		if($('.add_bank_button:visible').length==0)
                {
                 	$(".add_bank_button").trigger("click");
                }
        	});


	  	   // Card Add more
	  	  $('body').on('click','.add_card_button',function()
	  	 	{
	            var h = $('.add-more-card').html().replace('item-ele','item');
	            $('.items_card').append(h);
	        });

	  	  $('body').on('click','.card_remove',function(){
           		 $(this).closest('.blocks').remove();
           		 if($('.add_card_button:visible').length==0)
                {
                 	$(".add_card_button").trigger("click");
                }
        	});


	  	   // Discount Add more
	  	  $('body').on('click','.add_discount_button',function()
	  	 	{
	            var h = $('.add-more-discount').html().replace('item-ele','item');
	            $('.items_discount').append(h);
	        });

	  	  $('body').on('click','.discount_remove',function(){
           		 $(this).closest('.blocks').remove();
        	});


	  	 /* $("#cashevent-form").submit(function(event)
	  	   {            
            var valid = true;
            $('.errormsg').remove();
            $("#cashevent-form .nameclass").each(function() {
                if( ! $(this).val() ){
                    $(this).after('<span class="text-danger errormsg errorMessage  help-block animation-slideUp form-error">'+$(this).attr('id')+' cannot be blank.</span>');
                    valid = false;
                }
            });
            
            if (!valid){
                return false;
            }else{
                    return true;
                 }
            event.preventDefault();

        }); */

	  	});


  	    $('body').on('click','.delete_record',function()
        {
            var delete_id = $(this).attr("data-id");
            var el=$(this);
            <?php
              $loginuser = User::model()->findByPk(Yii::app()->user->id);
              $date = date('Y-m-d');
              // echo $date;
              if($loginuser->user_type==2)
              {
           		?>
           		var record_date = $(this).attr("data-date"); 
           		// alert('<?php // echo date('Y-m-d');?>');         
	           	if(record_date == '<?php echo $date; ?>')
	           	{
	           		 var $row = $(this).parent().parent();
	           		 var el = $(this);
	             	// alert(delete_id);
		            if (confirm('Are you sure you want to delete this?')) 
		            {
		            if(delete_id != "")
		            {
		               $.ajax({
		                  type: "POST",
		                  url: '<?php  echo Yii::app()->createUrl("cashevent/remove_record");?>',
		                  data: {'delete_id':delete_id},
		                  cache: false,
		                  success: function(data)
		                  {
		                    if(data == 1)
		                    {
		                    	var total_subitem=el.closest('.delete_span_sub').find('.sub_item_delete').length;
		                    	var total_mainitem=el.closest('.delete_main_item').find('.delete_span_sub').length;
		                    	if(el.attr('data-item')==1)
		                    	{
			                    	if(total_mainitem == 1)
			                    	{
			                    		var name=0;
			                    			var h='<div class="blocks main_item col-md-12 delete_extrx_div" style="margin-top: 30px;">\
								            		<label class="col-md-2 control-label">Item</label>\
								            		<div class="col-md-3">\
								            			<input type="text" placeholder="Enter Item Name" name="note['+name+']" id="item" class="form-control nameclass item_note main_item_req">\
								            		</div>\
								            		<div class="col-md-2">\
									            			<input type="text" placeholder="Gross Weight" name="gross_weight['+name+']" class="form-control gross_weight">\
								            		</div>\
								            		<div class="col-md-2">\
									            			<input type="text" placeholder="Enter Weight" name="weight['+name+']" class="form-control gold_amount_js item_weight">\
								            		</div>\
								            		<div class="col-md-2">\
								            			<input type="text" placeholder="Enter Amount" name="amount['+name+']" id="amount" class="form-control nameclass numeric_amount gold_amount_js item_amount">\
								            		</div>\
								            		<!-- <div class="col-md-3">\
								            			<input type="text" name="note_detail[]" id="note" class="form-control" placeholder="Enter Note">\
								            		</div> -->\
								            		<div class="col-md-1" style="padding-right: 0px;">\
							                            <button class="btn btn-primary add_button btn-sm"><i class="fa fa-plus"></i></button>\
											            <!-- <button class="btn btn-danger remove btn-sm"><i class="fa fa-times"></i></button>-->\
								                    </div>\
								                    <!--  <div class="col-md-1">\
											        </div> -->\
								            	</div>\
								            	<div class="blocks col-md-12" style="margin-top: 0px;">\
								            		<label class="col-md-2 control-label">Sub Item</label>\
								            		<div class="col-md-3">\
								            			<input type="text" placeholder="Enter Sub Item Name" name="sub_note['+name+'][]" id="item" class="form-control nameclass sub_item_note">\
								            		</div>\
								            		<div class="col-md-3">\
									            			<input type="text" placeholder="Enter Weight" name="sub_weight['+name+'][]" class="form-control gold_amount_js sub_item_weight">\
								            		</div>\
								            		<div class="col-md-3">\
								            			<input type="text" placeholder="Enter Amount" name="sub_amount['+name+'][]" id="amount" class="form-control nameclass numeric_amount gold_amount_js sub_item_amount">\
								            		</div>\
								            		<!-- <div class="col-md-3">\
								            			<input type="text" name="note_detail'+name+'[]" id="note" class="form-control" placeholder="Enter Note">\
								            		</div> -->\
								            		<div class="col-md-1" style="padding-right: 0px;">\
							                            <button class="btn btn-primary add_sub_button btn-sm"><i class="fa fa-plus"></i></button>\
											           <!-- <button class="btn btn-danger sub_remove btn-sm"><i class="fa fa-times"></i></button>-->\
								                    </div>\
								                    <!--  <div class="col-md-1">\
											        </div> -->\
								            	</div>\
								            	<span class="sub_items"></span>\
								        ';
								         var html='<span data-id="0" class="note0 notes">'+h+'</span>';
								          el.closest('.delete_main_item').find('.items').append(html);
							            if(total_subitem != 1)
							            {
							             	$row.remove();
							            }
			                    	}
			                    }
			                    else
			                    {
			                        if(total_subitem==1)
			                        {
			                        	// alert('test11');
			                        	var name=el.closest('.notes').attr('data-id');
			                        	// alert(name);
							            var h='<div class="blocks <?php if($model->isNewRecord){ ?> col-md-12 <?php }else {?> custom_class <?php } ?>" style="margin-top: 10px;">\
									            		<label class="col-md-2 control-label">Sub Item</label>\
									            		<div class="col-md-3">\
									            			<input type="text" placeholder="Enter Sub Item Name" name="sub_note['+name+'][]" id="item" class="form-control nameclass sub_item_note">\
									            		</div>\
									            		<div class="col-md-3">\
										            			<input type="text" placeholder="Enter Weight" name="sub_weight['+name+'][]" class="form-control gold_amount_js sub_item_weight">\
									            		</div>\
									            		<div class="col-md-3">\
									            			<input type="text" placeholder="Enter Amount" name="sub_amount['+name+'][]" id="amount" class="form-control nameclass numeric_amount gold_amount_js sub_item_amount">\
									            		</div>\
									            		<!-- <div class="col-md-3">\
									            			<input type="text" name="note_detail'+name+'[]" id="note" class="form-control" placeholder="Enter Note">\
									            		</div> -->\
									            		<div class="col-md-1" style="padding-right: 0px;">\
								                            <button class="btn btn-primary add_sub_button btn-sm"><i class="fa fa-plus"></i></button>\
												            <button class="btn btn-danger btn-sm sub_remove"><i class="fa fa-times"></i></button>\
									                    </div>\
									                    <!--  <div class="col-md-1">\
												        </div> -->\</div>\
													';

							            el.closest('.notes').find('.sub_items').append(h);
			                        }
			                    }
			                    $row.remove();

		                        if($('.add_button:visible').length==0)
		                        {
		                         	$(".add_button").trigger("click");
		                        }	

		                        if($('.add_cash_button:visible').length==0)
		                        {
		                         	$(".add_cash_button").trigger("click");
		                        }

		                       /* if($('.all_delete_cash:visible').length==0)
		                        {		                         	
		                         	var new_cash = $('.add-more-cash').html();
	            					$('.new_cash').append(new_cash);
		                        } */

		                        if($('.add_gold_button:visible').length==0)
		                        {
		                         	$(".add_gold_button").trigger("click");
		                        }

		                        if($('.add_diamond_button:visible').length==0)
		                        {
		                         	$(".add_diamond_button").trigger("click");
		                        }

		                        if($('.add_bank_button:visible').length==0)
		                        {
		                         	$(".add_bank_button").trigger("click");
		                        }
		                        
		                        if($('.add_card_button:visible').length==0)
		                        {
		                         	$(".add_card_button").trigger("click");
		                        }		                        

		                        if($('.all_delete_discount:visible').length==0)
		                        {		                         	
		                         	var new_dicount = $('.add-more-discount').html();
	            					$('.new_dicount').append(new_dicount);
		                        }

		                        // $(this).closest('.blocks').remove();
		                        var i=0;
					  	   		$('.notes').each(function(key, index )
					  	   		{
					  	   			$(this).find('.item_note').attr('name','note['+i+']');
					  	   			$(this).find('.gross_weight').attr('name','gross_weight['+i+']');
					  	   			$(this).find('.item_weight').attr('name','weight['+i+']');
					  	   			$(this).find('.item_amount').attr('name','amount['+i+']');
					  	   			$(this).find('.sub_item_note').closest('.blocks').each(function(key1, index1 )
					  	   			{
					  	   				$(this).find('.sub_item_note').attr('name','sub_note['+i+'][]');
					  	   				$(this).find('.sub_item_weight').attr('name','sub_weight['+i+'][]');
					  	   				$(this).find('.sub_item_amount').attr('name','sub_amount['+i+'][]');
					  	   			});
				  	   			i++;
					  	   		});


		                    }

		                  }
		            	});
		       		 }
		            }
	           	}
	           	else
	           	{
	           		alert("you not allowd to delete this record");
	           	}
	        <?php 
    		}
    		 if($loginuser->user_type==1)
              {
              	?>
              	      var $row = $(this).parent().parent();
              	      var el = $(this);
              	      
	             	// alert(delete_id);
		            if (confirm('Are you sure you want to delete this?')) 
		            {
		            if(delete_id!= "")
		            {

		               $.ajax({
		                  type: "POST",
		                  url: '<?php  echo Yii::app()->createUrl("cashevent/remove_record");?>',
		                  data: {'delete_id':delete_id},
		                  cache: false,
		                  success: function(data)
		                  {
		                    if(data == 1)
		                    {	
		                    	var total_subitem=el.closest('.delete_span_sub').find('.sub_item_delete').length;
		                    	var total_mainitem=el.closest('.delete_main_item').find('.delete_span_sub').length;
		                    	if(el.attr('data-item')==1)
		                    	{
			                    	if(total_mainitem == 1)
			                    	{
			                    		var name=0;
			                    			var h='<div class="blocks main_item col-md-12 delete_extrx_div" style="margin-top: 30px;">\
								            		<label class="col-md-2 control-label">Item</label>\
								            		<div class="col-md-3">\
								            			<input type="text" placeholder="Enter Item Name" name="note['+name+']" id="item" class="form-control nameclass item_note main_item_req">\
								            		</div>\
								            		<div class="col-md-3">\
									            			<input type="text" placeholder="Enter Weight" name="weight['+name+']" class="form-control gold_amount_js item_weight">\
								            		</div>\
								            		<div class="col-md-3">\
								            			<input type="text" placeholder="Enter Amount" name="amount['+name+']" id="amount" class="form-control nameclass numeric_amount gold_amount_js item_amount">\
								            		</div>\
								            		<!-- <div class="col-md-3">\
								            			<input type="text" name="note_detail[]" id="note" class="form-control" placeholder="Enter Note">\
								            		</div> -->\
								            		<div class="col-md-1" style="padding-right: 0px;">\
							                            <button class="btn btn-primary add_button btn-sm"><i class="fa fa-plus"></i></button>\
											            <!-- <button class="btn btn-danger remove btn-sm"><i class="fa fa-times"></i></button>-->\
								                    </div>\
								                    <!--  <div class="col-md-1">\
											        </div> -->\
								            	</div>\
								            	<div class="blocks col-md-12" style="margin-top: 0px;">\
								            		<label class="col-md-2 control-label">Sub Item</label>\
								            		<div class="col-md-3">\
								            			<input type="text" placeholder="Enter Sub Item Name" name="sub_note['+name+'][]" id="item" class="form-control nameclass sub_item_note">\
								            		</div>\
								            		<div class="col-md-3">\
									            			<input type="text" placeholder="Enter Weight" name="sub_weight['+name+'][]" class="form-control gold_amount_js sub_item_weight">\
								            		</div>\
								            		<div class="col-md-3">\
								            			<input type="text" placeholder="Enter Amount" name="sub_amount['+name+'][]" id="amount" class="form-control nameclass numeric_amount gold_amount_js sub_item_amount">\
								            		</div>\
								            		<!-- <div class="col-md-3">\
								            			<input type="text" name="note_detail'+name+'[]" id="note" class="form-control" placeholder="Enter Note">\
								            		</div> -->\
								            		<div class="col-md-1" style="padding-right: 0px;">\
							                            <button class="btn btn-primary add_sub_button btn-sm"><i class="fa fa-plus"></i></button>\
											           <!-- <button class="btn btn-danger sub_remove btn-sm"><i class="fa fa-times"></i></button>-->\
								                    </div>\
								                    <!--  <div class="col-md-1">\
											        </div> -->\
								            	</div>\
								            	<span class="sub_items"></span>\
								        ';
								         var html='<span data-id="0" class="note0 notes">'+h+'</span>';
								          el.closest('.delete_main_item').find('.items').append(html);
							            if(total_subitem != 1)
							            {
							             	$row.remove();
							            }
								           /* else
								            {
								            	$( ".delete_extrx_div" ).remove();
								            }*/
							           
			                    	}
			                    }
			                    else
			                    {
			                        if(total_subitem==1)
			                        {
			                        	// alert('test11');
			                        	var name=el.closest('.notes').attr('data-id');
			                        	alert(name);
							            var h='<div class="blocks <?php if($model->isNewRecord){ ?> col-md-12 <?php }else {?> custom_class <?php } ?>" style="margin-top: 10px;">\
									            		<label class="col-md-2 control-label">Sub Item</label>\
									            		<div class="col-md-3">\
									            			<input type="text" placeholder="Enter Sub Item Name" name="sub_note['+name+'][]" id="item" class="form-control nameclass sub_item_note">\
									            		</div>\
									            		<div class="col-md-3">\
										            			<input type="text" placeholder="Enter Weight" name="sub_weight['+name+'][]" class="form-control gold_amount_js sub_item_weight">\
									            		</div>\
									            		<div class="col-md-3">\
									            			<input type="text" placeholder="Enter Amount" name="sub_amount['+name+'][]" id="amount" class="form-control nameclass numeric_amount gold_amount_js sub_item_amount">\
									            		</div>\
									            		<!-- <div class="col-md-3">\
									            			<input type="text" name="note_detail'+name+'[]" id="note" class="form-control" placeholder="Enter Note">\
									            		</div> -->\
									            		<div class="col-md-1" style="padding-right: 0px;">\
								                            <button class="btn btn-primary add_sub_button btn-sm"><i class="fa fa-plus"></i></button>\
												            <button class="btn btn-danger btn-sm sub_remove"><i class="fa fa-times"></i></button>\
									                    </div>\
									                    <!--  <div class="col-md-1">\
												        </div> -->\</div>\
													';

							            el.closest('.notes').find('.sub_items').append(h);

			                        }
			                        	
			                    }
			                    $row.remove();
		                         //alert($('.add_bank_button:visible').length)
		                        // $(this).closest('.blocks').remove();
		                        if($('.add_button:visible').length==0)
		                        {
		                         	$(".add_button").trigger("click");
		                        }	

		                        /* if($('.all_delete_cash:visible').length==0)
		                        {		                         	
		                         	var new_cash = $('.add-more-cash').html();
	            					$('.new_cash').append(new_cash);
		                        } */

		                        if($('.add_cash_button:visible').length==0)
		                        {
		                         	$(".add_cash_button").trigger("click");
		                        }

		                        if($('.add_gold_button:visible').length==0)
		                        {
		                         	$(".add_gold_button").trigger("click");
		                        }

		                        if($('.add_diamond_button:visible').length==0)
		                        {
		                         	$(".add_diamond_button").trigger("click");
		                        }

		                        if($('.add_bank_button:visible').length==0)
		                        {
		                         	$(".add_bank_button").trigger("click");
		                        }
		                        
		                        if($('.add_card_button:visible').length==0)
		                        {
		                         	$(".add_card_button").trigger("click");
		                        }		                        

		                        if($('.all_delete_discount:visible').length==0)
		                        {		                         	
		                         	var new_dicount = $('.add-more-discount').html();
	            					$('.new_dicount').append(new_dicount);
		                        }
		                        var i=0;
					  	   		$('.notes').each(function(key, index )
					  	   		{
					  	   			$(this).find('.item_note').attr('name','note['+i+']');
					  	   			$(this).find('.item_weight').attr('name','weight['+i+']');
					  	   			$(this).find('.item_amount').attr('name','amount['+i+']');
					  	   			$(this).find('.sub_item_note').closest('.blocks').each(function(key1, index1 )
					  	   			{
					  	   				$(this).find('.sub_item_note').attr('name','sub_note['+i+'][]');
					  	   				$(this).find('.sub_item_weight').attr('name','sub_weight['+i+'][]');
					  	   				$(this).find('.sub_item_amount').attr('name','sub_amount['+i+'][]');
					  	   			});	
					  	   			i++;
					  	   		});

		                    }
		                  }
		            	});
		       		 }
		            }
          	<?php
          }
    	?>
            
       });
            
            $('body').on('keydown', 'input, select ', function(e) {
                if (e.key === "Enter") {
                    var self = $(this), form = self.parents('form:eq(0)'), focusable, next;
                    focusable = form.find('input,a,select,button,textarea , add_button ,submit').filter(':visible');
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
        this.value = this.value.replace(/[^0-9\.]/g,'');
	     $(this).val($(this).val().replace(/[^0-9\.]/g,''));
            if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57))
            {
            	// lert("only number allowed !");
            	// $(this).val('');
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

	/*  $('body').on('mousedown','.gold_amount_js',function(e)
	{ 
	    if( e.button == 2 ) { 
	      alert('Copy Past not allowed !'); 
	      return false; 
	    } 
	    return true; 
    });  */


	/* $('body').on('keydown','.gold_amount_js',function(e)
	{
 	
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
      ((e.keyCode == 65 || e.keyCode == 86 || e.keyCode == 67) && (e.ctrlKey === true || e.metaKey === true)) ||
      (e.keyCode >= 35 && e.keyCode <= 40)) {
      e.preventDefault();
    }
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
      e.preventDefault();
    }
  }); */


</script>