
<?php $title="View Cash Event";?>
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
                    <li><?php echo CHtml::link($title, array('admin')) ?></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <!-- Partial Responsive Block -->
        <div class="block">
            <!-- Partial Responsive Title -->
            <div class="block-title">
                <h2>View <?php echo $title;?></h2>	                     
            </div>

            <!-- END Partial Responsive Title -->
            <?php if (Yii::app()->user->hasFlash('success')): ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><strong>Success</strong></h4>
                    <p><?php echo Yii::app()->user->getFlash('success'); ?></p>
                </div>
            <?php endif; ?>

				<?php 
				$cust_id = $_GET['id'];
				/*$this->widget('zii.widgets.CDetailView', array(
						
					'data'=>$model,
					'htmlOptions'=>array('class'=>'table table-striped'),
					'attributes'=>array(
						'name',
						'mobile',
						'address',
						array(
							'name'=>'type',
							'value'=>function($data){
								if($data->type == 1)
								{
									return "Supplier";
								}
								if($data->type == 2)
								{
									return "Customer";
								}
								if($data->type == 3)
								{
									return "Karigar";
								}
							}
						),
						
					),
				));*/ ?>

				<div class="row">
        <div class="col-xs-12">           
                <!-- <div class="block-title">
                    <h2> User All Trasaction Details</h2>
                </div> -->
                 <?php
                  $all_trasaction = Cashevent::model()->findAllByattributes(array("customer_id"=>"$cust_id","is_deleted"=>0));
                  // print_r($all_trasaction);
                    ?>
                   <div class="row">
                     <?php 
                        $i = 0;
                         foreach ($all_trasaction as $key => $value) {
                            ?>

                            <div class="col-md-4 block">
                            		    
                           		<div class="col-md-6" style="margin-top: 10px;">
                          			 <b>Customer Name</b>
	                            </div>
	                            <div class="col-md-6" style="margin-top: 10px;" >
	                                <?php 
	                                    $user_main = Customer::model()->findByPk($value->customer_id);
	                                    echo $user_main->name;
	                                ?>
	                            </div>

	                            <div class="col-md-6" style="margin-top: 10px;">
	                               <b>Cash Event</b>
	                            </div>
	                            <div class="col-md-6" style="margin-top: 10px;">
	                                <?php  
	                                	if($value['cash_type'] == 1)
	                                	{
	                                		echo "IN";
	                                	}
	                                	if($value['cash_type'] == 2)
	                                	{
	                                		echo "OUT";
	                                	}
	                             ?>
	                            </div>

	                            <div class="col-md-6" style="margin-top: 10px; ">
	                               <b>Cash Amount</b>
	                            </div>
	                            <div class="col-md-6" style="margin-top: 10px;">
	                                <?php  
	                                	$cash_amount=ltrim($value->amount, '-');
	                                	echo $cash_amount;
	                                // echo $new_date = date('d-m-Y',strtotime($value['transaction_date'])); ?>
	                            </div>

	                            <div class="col-md-6" style="margin-top: 10px; ">
	                               <b>Gold  Event</b>
	                            </div>
	                            <div class="col-md-6" style="margin-top: 10px;">
	                                <?php  
	                                	if($value['gold_type'] == 1)
	                                	{
	                                		echo "IN";
	                                	}
	                                	if($value['gold_type'] == 2)
	                                	{
	                                		echo "OUT";
	                                	}
	                             ?>
	                            </div>

	                            <div class="col-md-6" style="margin-top: 10px; ">
	                               <b>Gold Amount</b>
	                            </div>
	                            <div class="col-md-6" style="margin-top: 10px; ">
	                                <?php  
	                                	$gold_amount=ltrim($value->gold_amount, '-');
	                                	echo $gold_amount;
	                                // echo $new_date = date('d-m-Y',strtotime($value['transaction_date'])); ?>
	                            </div>
	                             <div class="col-md-6" style="margin-top: 10px; margin-bottom: 10px;">
	                               <b>Created Date</b>
	                            </div>
	                            <div class="col-md-6" style="margin-top: 10px; margin-bottom: 10px;">
	                                <?php  
	                                 echo $new_date = date('d-m-Y',strtotime($value['created_date'])); ?>
	                            </div>

                            </div>
                         <?php
                         }
                        ?>
                   </div>  

        
        </div>
    </div>
			</div>
		</div>
	</div>