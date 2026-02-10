<style type="text/css">
	.pdf_generate{
		margin-top: 5px;
		margin-right:10px; 
	}
	.footer_amount
	{
		float: right;
	}	
	.text_upper
 	{
    	text-transform: uppercase;
  	}
  	.sub_popup
  	{
  		text-decoration: underline;
  	}
</style>
<?php
/*	print_r($model);
	die("AAAAA");*/
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
    <div class="col-md-10 col-md-offset-1">
        <!-- Partial Responsive Block -->
        <div class="block">
            <!-- Partial Responsive Title -->
            <div class="block-title">
                <h2><?php echo $title;?></h2>	
                  <?php	
         echo CHtml::link(' Generate PDF',array('cashevent/pdfexport','id'=>$_GET['id']),array('class'=>'pull-right pdf-link btn btn-rounded btn-primary fa fa-file-pdf-o pdf_generate','target'=>'_blanck'));
         ?>                     
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

						// 'created_date',
								'referral_code',
					
								array(
			                        'name' => 'narration',
			                        'type' => 'html',
			                        'value' => function($data){
			                            if (strlen($data->narration) > 80) {
			                                return substr($data->narration, 0, 80).' ... ';
			                            }else{
			                                return $data->narration;
			                            }
			                        }
			                    ),
								array(
			                        'name' => 'main_note',
			                        'type' => 'html',
			                        'value' => function($data){
			                            if (strlen($data->main_note) > 80) {
			                                return substr($data->main_note, 0, 80).' ... ';
			                            }else{
			                                return $data->main_note;
			                            }
			                        }
			                    ),

			                    array(
									'name'=>'created_date',
									'htmlOptions'=>array('style'=>'text-align: center;', 'class'=>'zzz'),
									'value'=>function($data)
									{
										return $new_date = date('d-m-Y',strtotime($data->created_date));
										// echo $new_date = date('d-m-Y H:i:s',strtotime($data->created_date)); 
									}
								),

					),
				)); ?>
			</div>
		</div>
	</div>

	<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <!-- Partial Responsive Block -->
        <div class="block">
            <!-- Partial Responsive Title -->
            <div class="block-title">
                <h2>Cash Listing</h2>
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
				'dataProvider'=>$model_log->search_cash(),
				'filter'=>$model_log,
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
						'name'=>'note',
						'headerHtmlOptions'=>array('class'=>'text_upper'),
						'filter'=>false,
						'sortable'=>false,
						'value'=>function($data)
						{
							?>
							<a href="javascript:void(0)" class="sub_popup" data-id="<?php echo $data->id; ?>"><?php echo $data->note; ?></a>
							<?php
							// echo CHtml::link($data->note, array('class'=>'link_blue'));
							/*if($data->note != "")
							{
								echo $data->note;
							}
							else
							{
								echo "-";
							}*/
						}
					),
					array(
						'name'=>'type',
						'filter'=>false,
						'sortable'=>false,
						'headerHtmlOptions'=>array('style'=>'text-align: center;' , 'class'=>'text_upper'),
						'htmlOptions'=>array('style'=>'text-align: center;', 'class'=>'zzz'),
						'value'=>function($data)
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
							if($data->type == 7)
							{
								echo "Diamond";
							}
							
						}
					),
					

					array(
						'name'=>'amount',
						'filter'=>false,
						'sortable'=>false,
						 'htmlOptions'=>array('style'=>'text-align: right;', 'class'=>'zzz'),
						 'headerHtmlOptions'=>array('style'=>'text-align: right;' , 'class'=>'text_upper'),
						 'footer'=>'<span class="footer_amount">'.$model_log->cashTotal($model_log->search_cash()->getData()).'</span>',
						'value'=>function($data)
						{
							if($data->type == 6)
							{
								$condition = "1=1";
			                    $criteria = new CDbCriteria;
			                    $criteria->select =' SUM(IF(t.type = "8" ,(t.amount),0)) AS amount ';
			                    $condition .= ' AND item_id ='.$data->id;
			                    $criteria->condition = $condition;
			                    $sub_amount=Cashlogs::model()->find($criteria);
			                    // echo  $data->amount ." = ". $sub_amount->amount;
			                    echo $all_item_amount = $data->amount + $sub_amount->amount;
							}
							else
							{
								if($data->amount != "" && $data->amount != 0)
								{
									echo $data->amount;
								}
							}
							/*else
							{
								echo "-";
							}*/
						}
					),


					array(
						'name'=>'weight',
						'filter'=>false,
						'sortable'=>false,
						'footer'=>'<span class="footer_amount">'.$model_log->metalTotal($model_log->search_cash()->getData()).'</span>',
						'headerHtmlOptions'=>array('style'=>'text-align: right;' , 'class'=>'text_upper'),
						'htmlOptions'=>array('style'=>'text-align: right;', 'class'=>'zzz'),
						'value'=>function($data)
						{
							if($data->amount == 0 && $data->type == 2)
							{

								if($data->weight != 0)
								{
									echo number_format((float)$data->weight, 3, '.', '');
								}
							}

							if($data->type != 2)
							{
								// echo "AA";
								   /* $condition = "1=1";
				                    $criteria = new CDbCriteria;
				                    $criteria->select =' SUM(IF(t.type = "8" ,(t.weight),0)) AS weight ';
				                    $condition .= ' AND item_id ='.$data->id;
				                    $criteria->condition = $condition;
				                    $sub_weight=Cashlogs::model()->find($criteria);
				                    $mail_weight_total = $data->weight+$sub_weight->weight;
								if($mail_weight_total != 0)
								{
									echo number_format((float)$mail_weight_total, 3, '.', '');
								}*/
								if($data->weight != 0)
								{
									echo number_format((float)$data->weight, 3, '.', '');
								}

							}
							
							// echo $data->weight;
						}
					),
					array(
						'name'=>'gross_weight',
						'filter'=>false,
						'sortable'=>false,
						 'headerHtmlOptions'=>array('style'=>'text-align: right;' , 'class'=>'text_upper'),
						'htmlOptions'=>array('style'=>'text-align: right;', 'class'=>'zzz'),
						'value'=>function($data)
						{
							echo $data->gross_weight; 
						}
					),
					array(
						'name'=>'date',
						'filter'=>false,
						'sortable'=>false,
						 'headerHtmlOptions'=>array('style'=>'text-align: center;' , 'class'=>'text_upper'),
						'htmlOptions'=>array('style'=>'text-align: center;', 'class'=>'zzz'),
						'value'=>function($data)
						{
							echo $new_date = date('d-m-Y',strtotime($data->date));
							// echo $new_date = date('d-m-Y H:i:s',strtotime($data->created_date)); 
						}
					),
					array(
						'name'=>'description',
						'filter'=>false,
						'sortable'=>false,
						 'htmlOptions'=>array('style'=>'text-align: left;', 'class'=>'zzz'),
						 'headerHtmlOptions'=>array('style'=>'text-align: left;', 'class'=>'text_upper'),
						'value'=>function($data)
						{
							if($data->description != "")
							{
								echo $data->description;
							}
							else
							{
								echo "-";
							}
						}
					),
					
					// 'created_date',
					// 'is_deleted',
					
					/*array(
						'class'=>'CButtonColumn',
					),*/
					/*array(
                        'class' => 'ButtonColumn',
                        'htmlOptions' => array('style' => 'width: 40px;text-align: center;'),
                        'template' => '{all_item}',
                        'buttons' => array(
                            'all_item' => array(
                                'label' => '<i class="fa fa-eye"></i>',
                                'imageUrl' => false,
                                'options' => array('class' => 'btn btn-effect-ripple btn-sm btn-warning sub_popup', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Cash Event'),"data-id"=>'$data->id','evaluateOptions' => array('data-id'),'disabled'=>''),
                                'type' => 'raw',
                                'visible'=>'($data->type == 6)?true:false',
                            ),
                        ),
                    ),*/
				),
			)); ?>
	</div>
    </div>
</div>


<div class="modal fade" id="empModal" role="dialog">
    <div class="modal-dialog" style="width:800px;">
      <div class="modal-content">
         <div class="modal-header">
           <!--  <h4 class="modal-title">Cash Event</h4> -->
             <button type="button" class="close" data-dismiss="modal">&times;</button>
             <h4 class="modal-title"><b>View Sub Item Detail</b></h4>
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


<script type="text/javascript">
	

	$('body').on('click','.sub_popup',function(){
           var item_id = $(this).data('id');
          //alert(order_id);
          //AJAX request
           $.ajax({
             url:'<?php echo Yii::app()->createUrl("cashevent/open_sub_popup");?>',
             method:"POST",  
             data:{item_id:item_id}, 
            success: function(response){ 
              // Add response in Modal body
              $('.modal-body').html(response);
              // Display Modal
              $('#empModal').modal('show'); 
              // $('.input-datepicker').datepicker({});
            }
          });
        });



</script>