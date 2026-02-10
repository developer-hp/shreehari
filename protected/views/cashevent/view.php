


<?php
	// print_r($model);
	// die("AAAAA");
?>

<?php $title="View Details";?>
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
                <h2><?php echo $title;?></h2>	                     
            </div>

            <!-- END Partial Responsive Title -->
            <?php if (Yii::app()->user->hasFlash('success')): ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><strong>Success</strong></h4>
                    <p><?php echo Yii::app()->user->getFlash('success'); ?></p>
                </div>
            <?php endif; ?>

				<?php $this->widget('zii.widgets.CDetailView', array(
					'data'=>$model,
					'htmlOptions'=>array('class'=>'table table-striped'),
					'attributes'=>array(
						// 'id',
						// 'user_id',
						// 'customer_id',
						/*array(
								'name'=>'customer_id',
								'value'=>function($data)
								{
									$cust_name = Customer::model()->findByPk($data->customer_id);
									return 	$cust_name->name;
								}
							),*/
							array(
				         		 'name'=>'customer_id',
				         		 'value'=>function($data){
				         		 	if(isset($data->getcust->name))
				         		 	{
				         		 		return $data->getcust->name;
				         		 	}
				         		 }
			         		),
							array(
								'name'=>'note',
								// 'htmlOptions'=>array('style'=>'text-align: center;', 'class'=>'zzz'),
								'value'=>function($data)
								{
									if(!empty($data->note))
									{
										return $data->note;
									}
									else
									{
										return "-";
									}
								}
							),

							array(
				         		 'name'=>'event_type',
				         		 'value'=>function($data){
				         		 	if(isset($data->amount))
				         		 	{
				         		 		if($data->amount > 0)
				         		 		{
				         		 			return "IN";
				         		 		}
				         		 		if($data->amount < 0)
				         		 		{
				         		 			return "OUT";
				         		 		}
				         		 		/* $cash_amount = ltrim($data->amount, '-'); 
				         		 		echo $cash_amount; */
				         		 	}
				         		 	else
				         		 	{
				         		 		echo "-";
				         		 	}
				         		 }
			         		),

							array(
								'name'=>'description',
								// 'htmlOptions'=>array('style'=>'text-align: center;', 'class'=>'zzz'),
								'value'=>function($data)
								{
									if(!empty($data->description))
									{
										/* $cash_amount = ltrim($data->amount, '-'); 
										return $cash_amount; */
										return $data->description;
									}
									else
									{
										return "-";
									}
								}
							),

							array(
								'name'=>'amount',
								// 'htmlOptions'=>array('style'=>'text-align: center;', 'class'=>'zzz'),
								'value'=>function($data)
								{
									if(!empty($data->amount))
									{
										/* $cash_amount = ltrim($data->amount, '-'); 
										return $cash_amount; */
										return $data->amount;
									}
									else
									{
										return "-";
									}
								}
							),

							array(
								'name'=>'weight',
								// 'htmlOptions'=>array('style'=>'text-align: center;', 'class'=>'zzz'),
								'value'=>function($data)
								{
									if(!empty($data->weight))
									{
										/* $cash_amount = ltrim($data->amount, '-'); 
										return $cash_amount; */
									    return number_format((float)$data->weight, 3, '.', '');
										// return $data->weight;
									}
									else
									{
										return "-";
									}
								}
							),


			         		array(
								'name'=>'date',
								// 'htmlOptions'=>array('style'=>'text-align: center;', 'class'=>'zzz'),
								'value'=>function($data)
								{
									return $new_date = date('d-m-Y',strtotime($data->date)); 
								}
							),

						// 'is_deleted',
					),
				)); ?>
			</div>
		</div>
	</div>