<style type="text/css">
	.footer_amount
	{
		float: right;
	}
	.text_upper
 	{
        text-transform: uppercase;
  	}
</style>

<div class="content-header">
    <div class="row">
        <div class="col-sm-6">
            <div class="header-section">
                <h1>
                	<?php
                		$action = strtolower(Yii::app()->controller->action->id);
                		if($action == 'today_cash')
                		{
                			$title = "Today Cash Amount";
                		}
                		if($action == 'today_gold')
                		{
                			$title = "Today Gold Amount";
                		}
                		if($action == 'today_bank')
                		{
                			$title = "Today Bank Amount";
                		}
                		if($action == 'today_card')
                		{
                			$title = "Today Card Amount";
                		}
                		if($action == 'today_discount')
                		{
                			$title = "Today Discount Amount";
                		}
                		if($action == 'today_item')
                		{
                			$title = "Today Bank Amount";
                		}
                		echo $title;
                	?>
                </h1>
            </div>
        </div>
        <div class="col-sm-6 hidden-xs">
            <div class="header-section">
                <ul class="breadcrumb breadcrumb-top">
                    <li><?php // echo CHtml::link('Manage Event', array('admin')) ?> <?php echo $title; ?></li>
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
                <h2> <?php echo $title;?> List<?php 
					 $loginuser = User::model()->findByPk(Yii::app()->user->id);			

                ?> </h2>
                <div id="errorMsg1" class="errorMsg1" style="border-radius: 10px; line-height: 1px;" ></div>
            </div>
            <!-- END Partial Responsive Title -->
            <?php if (Yii::app()->user->hasFlash('success')): ?>
                <div class="alert alert-success alert-dismissable">
                    <p><?php echo Yii::app()->user->getFlash('success'); ?></p>
                </div>
            <?php endif; ?>
            <?php // echo CHtml::button('Delete', array('id' => 'btnDelete', 'class' => 'btn btn-effect-ripple btn-danger')); ?>
            <?php // echo CHtml::link('Add', array('create'), array('class' => 'btn btn-effect-ripple btn-info')); ?>

			<?php $this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'cashevent-grid',
				'dataProvider'=>$model->search_cash_today(),
				'filter'=>$model,
				'pager' => array(
                    'header' => '',
                    'selectedPageCssClass'=>'active',
                    // 'cssFile' => Yii::app()->baseurl . '/css/bootstrap.min.css',
                ),
				'itemsCssClass' => 'table table-striped table-bordered table-vcenter table-responsive',
				'columns'=>array(
					// 'id',
					// 'user_id',
					// 'customer_id',
					array(
						'name'=>'customer_id',
						'filter'=>false,
						'sortable'=>false,
						'value'=>function($data)
						{
							$cust_name = Customer::model()->findByPk($data->customer_id);
							echo $cust_name->name;
						}
					),
					// 'customer_id',
					/*array(
		         		 'name'=>'customer_id',
		         		 // 'filter'=>false,
		         		 // 'sortable'=>false, 
		         		 'value'=>function($data){
		         		 	if(isset($data->getcust->name))
		         		 	{
		         		 		echo $data->getcust->name;
		         		 	}
		         		 }
	         		),*/

	         		array(
		         		 'name'=>'note',
		         		 'filter'=>false,
						'sortable'=>false,
		         		 'headerHtmlOptions'=>array('class'=>'text_upper'),
		         		 'value'=>function($data){
		         		 	if(isset($data->note))
		         		 	{
		         		 		echo $data->note;
		         		 	}
		         		 	else
		         		 	{
		         		 		echo "-";
		         		 	}
		         		 }
	         		),

	         		array(
		         		 'name'=>'type',
		         		 'filter'=>false,
						'sortable'=>false,
		         		 'htmlOptions'=>array('style'=>'text-align: center;', 'class'=>'zzz'),
		         		 'headerHtmlOptions'=>array('style'=>'text-align: center;' , 'class'=>'text_upper'),
		         		// 'filter'=>array('1'=>'CASH','2'=>'GOLD','3'=>'BANK','4'=>'CARD','5'=>'DISCOUNT','6'=>'ITEM'),
		         		 'value'=>function($data){
		         		 	if(isset($data->type))
		         		 	{
		         		 		if($data->type == 1)
		         		 		{
		         		 			echo "Cash";
		         		 		}
		         		 		if($data->type == 2)
		         		 		{
		         		 			echo "Gold";
		         		 		}
		         		 		if($data->type == 3)
		         		 		{
		         		 			echo "Bank";
		         		 		}
		         		 		if($data->type == 4)
		         		 		{
		         		 			echo "Card";
		         		 		}
		         		 		if($data->type == 5)
		         		 		{
		         		 			echo "Discount";
		         		 		}
		         		 		if($data->type == 6)
		         		 		{
		         		 			echo "Item";
		         		 		}
		         		 		// echo $data->type;
		         		 	}
		         		 	else
		         		 	{
		         		 		echo "-";
		         		 	}
		         		 }
	         		),

	         		array(
		         		 'name'=>'event_type',
		         		 // 'filter'=>false,
		         		 'filter'=>false,
						'sortable'=>false,
		         		 'headerHtmlOptions'=>array('style'=>'text-align: center;', 'class'=>'text_upper'),
		         		 'htmlOptions'=>array('style'=>'text-align: center;', 'class'=>'zzz'),
		         		 'value'=>function($data){
		         		 	if(isset($data->amount))
		         		 	{
		         		 		if($data->amount > 0)
		         		 		{
		         		 			echo "IN";
		         		 		}
		         		 		if($data->amount < 0)
		         		 		{
		         		 			echo "OUT";
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
		         		 'name'=>'amount',
		         		 'filter'=>false,
						'sortable'=>false,
		         		 // 'class'=>'right_amount',
		         		 // 'footer'=>'<span class="footer_amount">'.$model->cash_all_Total($model->search_event()->getData()).'</span>',
		         		 'htmlOptions'=>array('style'=>'text-align: right;', 'class'=>'right_amount'),
		         		 'headerHtmlOptions'=>array('style'=>'text-align: right;' , 'class'=>'text_upper'),
		         		 'value'=>function($data){
		         		 	if(isset($data->amount))
		         		 	{
		         		 		if($data->amount)
		         		 		{
		         		 			echo $data->amount;
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
		         		 'name'=>'weight',
		         		 'filter'=>false,
						'sortable'=>false,
		         		 // 'class'=>'right_amount',

		         		 // 'footer'=>'<span class="footer_amount">'.$model->metal_all_Total($model->search_event()->getData()).'</span>',
		         		 'htmlOptions'=>array('style'=>'text-align: right;', 'class'=>'right_amount'),
		         		 'headerHtmlOptions'=>array('style'=>'text-align: right;' , 'class'=>'text_upper'),
		         		 'value'=>function($data){
		         		 	if(isset($data->weight))
		         		 	{

		         		 		$action = strtolower(Yii::app()->controller->action->id);
		         		 		if($action == 'today_gold')
		         		 		{
		         		 			if($data->amount <= 0)
		         		 			{
		         		 				if($data->weight)
				         		 		{
			         		 			   echo number_format((float)$data->weight, 3, '.', '');
				         		 		}
		         		 			}
		         		 			
		         		 		}
		         		 		else
		         		 		{
		         		 			if($data->weight)
			         		 		{
		         		 			   echo number_format((float)$data->weight, 3, '.', '');
			         		 		}
		         		 		}
		         		 		
		         		 		/* $cash_amount = ltrim($data->amount, '-'); 
		         		 		echo $cash_amount; */
		         		 	}
		         		 	/* else
		         		 	{
		         		 		echo "-";
		         		 	} */
		         		 }
	         		),



	         		array(
						'name'=>'date',
						'filter'=>false,
						'sortable'=>false,
						'headerHtmlOptions'=>array('style'=>'text-align: center;', 'class'=>'text_upper'),
						'htmlOptions'=>array('style'=>'text-align: center;', 'class'=>'zzz'),
						'value'=>function($data)
						{
							echo $new_date = date('d-m-Y',strtotime($data->date));
							// echo $new_date = date('d-m-Y H:i:s',strtotime($data->created_date)); 
						}
					), 
					
					
					
					/*array(
						'class'=>'CButtonColumn',
					),*/
					/* array(
                        'class' => 'ButtonColumn',
                        'htmlOptions' => array('style' => 'width: 120px;text-align: center;'),
                        'template' => '{view} {delete}',
                        'buttons' => array(
                            'update' => array(
                                'label' => '<i class="fa fa-pencil"></i>',
                                'imageUrl' => false,
                                'options' => array('class' => 'btn btn-effect-ripple btn-sm btn-success', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Update')),
                                'type' => 'raw',
                            ),
                            'view' => array(
                                'label' => '<i class="fa fa-eye"></i>',
                                'imageUrl' => false,
                                'options' => array('class' => 'btn btn-effect-ripple btn-sm btn-warning', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'View Details')),
                                'type' => 'raw',
                            ),
                        	'delete' => array(
                                'label' => '<i class="fa fa-trash"></i>',
                                'imageUrl' => false,
                                'options' => array('class' => 'btn btn-effect-ripple btn-sm btn-danger delete_record', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Delete'),"data-id"=>'$data->id','evaluateOptions' => array('data-id'),),
                                'type' => 'raw',
                                'visible'=>($loginuser->user_type==2)?'($data->check_date=="'.date('Y-m-d').'")?true:false':'true'
                            ),
                        ),
                    ), */
				),
			)); 
			
				
				
			?>
			<?php // echo $cash_in_total; ?>
	</div>
    </div>
</div>


<script type="text/javascript">
		
		   $('body').on('click','.delete_record',function(){
           var cust_id = $(this).data('id');
          	// alert(cust_id);
          //AJAX request
           $.ajax({
              url:'<?php echo Yii::app()->createUrl("cashevent/delete_record");?>',
             method:"POST",  
             data:{cust_id:cust_id}, 
            success: function(response)
            { 
            	var obj=$.parseJSON(data);
                $('#errorMsg1').html(obj.msg);
                  $('#errorMsg1').addClass('alert alert-dander');
                  $('#errorMsg1').show();
            	$("#cashevent-grid").yiiGridView("update",{});
            }
          });
        });

</script>