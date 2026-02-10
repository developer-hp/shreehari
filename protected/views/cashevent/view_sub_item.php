	<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <!-- Partial Responsive Block -->
        <div class="block">
            <!-- Partial Responsive Title -->
            <div class="block-title">
                <h2>Sub Item Listing</h2>
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
				'dataProvider'=>$model->search_sub_item(),
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
						'name'=>'note',
						'headerHtmlOptions'=>array('class'=>'text_upper'),
						'filter'=>false,
						'sortable'=>false,
						'value'=>function($data)
						{
							if($data->note != "")
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
						'name'=>'amount',
						'filter'=>false,
						'sortable'=>false,
						 'htmlOptions'=>array('style'=>'text-align: right;', 'class'=>'zzz'),
						 'headerHtmlOptions'=>array('style'=>'text-align: right;' , 'class'=>'text_upper'),
						'value'=>function($data)
						{
							if(isset($data->amount))
							{
								echo $data->amount;
							}
						}
					),


					array(
						'name'=>'weight',
						'filter'=>false,
						'sortable'=>false,
						'headerHtmlOptions'=>array('style'=>'text-align: right;' , 'class'=>'text_upper'),
						'htmlOptions'=>array('style'=>'text-align: right;', 'class'=>'zzz'),
						'value'=>function($data)
						{
							if(isset($data->weight))
							{
								echo $data->weight;
							}
							
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
					/* array(
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
					), */
					
					// 'created_date',
					// 'is_deleted',
					
					/*array(
						'class'=>'CButtonColumn',
					),*/
				/*	array(
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
                                 //'url'=>'Yii::app()->createUrl("Customer/update_supllier",array("id"=>$data->id))'
                            ),


                        ),
                    ),*/
				),
			)); ?>
	</div>
    </div>
</div>