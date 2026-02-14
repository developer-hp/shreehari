<style type="text/css">
    /*.tech_popup{
        margin-top: 15px;
    }*/
    .link_blue{
     text-decoration: underline;
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
                <h1>Manage Karigar</h1>
            </div>
        </div>
        <div class="col-sm-6 hidden-xs">
            <div class="header-section">
                <ul class="breadcrumb breadcrumb-top">
                    <li><?php echo CHtml::link('Manage Karigar', array('list_karigar')) ?></li>
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
                <h2>Karigar Listing </h2>
            </div>
            <div id="errorMsg1" class="errorMsg1" style="border-radius: 10px; line-height: 1px;" ></div>
            <!-- END Partial Responsive Title -->
            <?php if (Yii::app()->user->hasFlash('success')): ?>
                <div class="alert alert-success alert-dismissable">
                    <p><?php echo Yii::app()->user->getFlash('success'); ?></p>
                </div>
            <?php endif; ?>
            <?php // echo CHtml::button('Delete', array('id' => 'btnDelete', 'class' => 'btn btn-effect-ripple btn-danger')); ?>
            <?php echo CHtml::link('Add', array('create_karigar'), array('class' => 'btn btn-effect-ripple btn-info')); ?>

			<?php $this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'customer-grid',
				'dataProvider'=>$model->search_karigar(),
				'filter'=>$model,
				'pager' => array(
                    'header' => '',
                    'selectedPageCssClass'=>'active',
                    // 'cssFile' => Yii::app()->baseurl . '/css/bootstrap.min.css',
                ),
				'itemsCssClass' => 'table table-striped table-bordered table-vcenter table-responsive',
				'columns'=>array(
					
					// 'id',
					// 'name',
          array(
            'name'=>'name',
             'headerHtmlOptions'=>array('class'=>'text_upper'),
            'value'=>function($data)
            {
              echo CHtml::link($data->name, array('cashevent/list_karigar_bill',"id"=>$data->id), array('class'=>'link_blue'));
                // echo $data->name;
            }
          ),
					// 'mobile',
					// 'address',
           array(
            'name'=>'mobile',
             'headerHtmlOptions'=>array('class'=>'text_upper'),
            'value'=>function($data)
            {
           
                echo $data->mobile;
            }
          ),
          array(
            'name'=>'address',
             'headerHtmlOptions'=>array('class'=>'text_upper'),
            'value'=>function($data)
            {
             
                echo $data->address;
            }
          ),
          array(
               'header'=>'Closing Wt',
               'headerHtmlOptions'=>array('style'=>'text-align: right;', 'class'=>'text_upper'),
               'htmlOptions'=>array('style'=>'text-align: right;'),
               'value'=>function($data){
                $wt = $data->closing_wt !== null && $data->closing_wt !== '' ? (float)$data->closing_wt : null;
                if ($wt === null) { echo '—'; return; }
                if ($wt >= 0) echo number_format($wt, 3, '.', '') . ' DR';
                else echo number_format(-$wt, 3, '.', '') . ' CR';
               }
          ),
          array(
               'header'=>'Closing Amount',
               'headerHtmlOptions'=>array('style'=>'text-align: right;', 'class'=>'text_upper'),
               'htmlOptions'=>array('style'=>'text-align: right;'),
               'value'=>function($data){
                $amt = $data->closing_amount !== null && $data->closing_amount !== '' ? (float)$data->closing_amount : null;
                if ($amt === null) { echo '—'; return; }
                if ($amt >= 0) echo number_format($amt, 2, '.', '') . ' DR';
                else echo number_format(-$amt, 2, '.', '') . ' CR';
               }
          ),
            array(
               // 'name'=>'Amount',
               'header'=>'Amount',
               'headerHtmlOptions'=>array('style'=>'text-align: right;', 'class'=>'text_upper'),
               'htmlOptions'=>array('style'=>'text-align: right;', 'class'=>'right_amount'),
               'footer'=>'<span class="footer_amount pull-right">'.$model->amount_Total_For_User_Type($model->search()->getData()).'</span>',
               'value'=>function($data){
                if(isset($data->id))
                {
                   $condition = "1=1";
                    $criteria=new CDbCriteria;
                    $criteria->select =' sum(amount) as amount ';
                    // $condition .= ' AND amount > 0 ' ;
                    $condition .= ' AND customer_id ='.$data->id;
                    $criteria->condition = $condition;
                     // print_r($criteria);
                    $cash_amount=Cashlogs::model()->find($criteria);
                    echo $cash_amount->amount;
                  /*  if($cash_amount->amount > 0)
                    {
                     // echo number_format((float)$cash_amount->amount, 2, '.', '');
                      echo $cash_amount->amount;
                    }*/
                }
               }
            ),

          array(
               // 'name'=>'Amount',
               'header'=>'Metal',
               'headerHtmlOptions'=>array('style'=>'text-align: right;','class'=>'text_upper'),
               'htmlOptions'=>array('style'=>'text-align: right;', 'class'=>'right_amount'),
               'footer'=>'<span class="footer_amount pull-right">'.$model->metal_Total_For_User_Type($model->search()->getData()).'</span>',
               'value'=>function($data){
                if(isset($data->id))
                {

                    $condition = "1=1";
                    $criteria = new CDbCriteria;
                    $criteria->select ='SUM(IF((t.amount = "0" OR t.amount is null OR t.amount = "") and   t.item_id = "0" ,(t.weight),0)) AS weight ';
                    $condition .= ' AND customer_id ='.$data->id;
                    $criteria->condition = $condition;
                    $cash_amount=Cashlogs::model()->find($criteria);
                    if($cash_amount->weight != 0)
                    {
                      echo number_format((float) $cash_amount->weight, 3, '.', '');
                    }

                    /* $condition = "1=1";
                    $criteria = new CDbCriteria;
                    $criteria->select =' sum(weight) as weight ';
                    $condition .= ' AND customer_id ='.$data->id;
                    $criteria->condition = $condition;
                    $cash_amount=Cashlogs::model()->find($criteria);
                    if($cash_amount->weight != "")
                    {

                      $condition = "1=1";
                      $criteria = new CDbCriteria;
                      $criteria->select =' sum(weight) as weight ';
                      $condition .= ' AND amount != 0 ' ;
                      $condition .= ' AND type = 2 ' ;
                      $condition .= ' AND customer_id ='.$data->id;
                      $criteria->condition = $condition;
                      $cash_amount_type=Cashlogs::model()->find($criteria);
                      $main_total =  $cash_amount->weight - $cash_amount_type->weight;
                      echo number_format((float)$main_total, 3, '.', '');
                    } */
                }
               }
            ),
					// 'type',
						/*array(
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
						),*/
					// 'id_deleted',
					/*array(
						'class'=>'CButtonColumn',
					),*/

                       /*array(
                           'htmlOptions' => array('style' => 'width: 30px;'),
                            'name'=>'Cash Event',
                            'type'=>'raw',
                            'filter'=>false,
                            'value'=>function($data)
                            { 
                                echo CHtml::tag('button',array("data-id"=>$data->id, "class"=>'btn btn-primary btn-sm tech_popup','style'=>'width:70px;'), '<i class="fa fa-money"></i>');
                            },
                            //'visible'=>($login_user->user_type==2)?false:true,
                        ),*/
						  array(
                        'class' => 'ButtonColumn',
                        'htmlOptions' => array('style' => 'width: 190px;text-align: center;'),
                        'template' => '{ledger} {bill} {update} {delete}',
                        'buttons' => array(
                            'ledger' => array(
                                'label' => '<i class="fa fa-book"></i>',
                                'imageUrl' => false,
                                'options' => array('class' => 'btn btn-effect-ripple btn-sm btn-info', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Ledger Report')),
                                'type' => 'raw',
                                'url' => 'Yii::app()->createUrl("ledgerReport/report", array("customer_id"=>$data->id))'
                            ),
                             'bill' => array(
                                'label' => '<i class="fa fa-eye"></i>',
                                'imageUrl' => false,
                                'options' => array('class' => 'btn btn-effect-ripple btn-sm btn-warning', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'View Bill Details')),
                                'type' => 'raw',
                                 'url'=>'Yii::app()->createUrl("cashevent/list_karigar_bill",array("id"=>$data->id))'
                            ),
                            'cash' => array(
                                'label' => '<i class="fa fa-money"></i>',
                                'imageUrl' => false,
                                'options' => array('class' => 'btn btn-effect-ripple btn-sm btn-primary tech_popup', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Cash Event'),"data-id"=>'$data->id','evaluateOptions' => array('data-id'),),
                                'type' => 'raw',
                                 //'url'=>'Yii::app()->createUrl("Customer/update_supllier",array("id"=>$data->id))'
                            ),
                            'update' => array(
                                'label' => '<i class="fa fa-pencil"></i>',
                                'imageUrl' => false,
                                'options' => array('class' => 'btn btn-effect-ripple btn-sm btn-success', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Update')),
                                'type' => 'raw',
                                'url'=>'Yii::app()->createUrl("Customer/update_karigar",array("id"=>$data->id))'
                            ),
                            /*'view' => array(
                                'label' => '<i class="fa fa-eye"></i>',
                                'imageUrl' => false,
                                'options' => array('class' => 'btn btn-effect-ripple btn-sm btn-warning', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'View Details')),
                                'type' => 'raw',
                                'url'=>'Yii::app()->createUrl("Customer/view_karigar",array("id"=>$data->id))'
                            ),*/
                             'view' => array(
                                'label' => '<i class="fa fa-eye"></i>',
                                'imageUrl' => false,
                                'options' => array('class' => 'btn btn-effect-ripple btn-sm btn-warning', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'View Cash Details')),
                                'type' => 'raw',
                                 'url'=>'Yii::app()->createUrl("cashevent/list_karigar_event",array("id"=>$data->id))'
                            ),
                            'delete' => array(
                            'options' => array('class' => 'btn btn-effect-ripple btn-sm btn-danger', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Delete')),
                            'label' => '<i class="fa fa-trash"></i>',
                            'imageUrl' => false,
                            ),
                        ),
                    ),
				),
			)); ?>

		</div>
    </div>
</div>



<div class="modal fade" id="empModal" role="dialog">
    <div class="modal-dialog" style="width:700px;">
      <div class="modal-content">
         <div class="modal-header">
            <!-- < h4 class="modal-title">Cash Event</h4> -->
             <button type="button" class="close" data-dismiss="modal">&times;</button>
             <h4 class="modal-title"><b>Cash Event</b></h4>
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
    
     $(document).ready(function()
     {
       $('body').on('click','.add_button',function()
       {
          var h = $('.add-more').html().replace('item-ele','item');
          $('.items').append(h);
        });

        $('body').on('click','.remove',function(){
          $(this).closest('.blocks').remove();
        });


        $('body').on('click','.tech_popup',function(){
           var cust_id = $(this).data('id');
          //alert(order_id);
          //AJAX request
           $.ajax({
             url:'<?php echo Yii::app()->createUrl("customer/openpopup");?>',
             method:"POST",  
             data:{cust_id:cust_id}, 
            success: function(response){ 
              // Add response in Modal body
              $('.modal-body').html(response);
              // Display Modal
               $('.input-datepicker').datepicker({});
              $('#empModal').modal('show'); 
            }
          });
        });

         // $('body').on('click','.save_tech',function(){
          $('body').on('submit','#cashevent-form',function(event)
         {
          event.preventDefault();
           // validation();
           var form_data = $('#cashevent-form').serialize();
         
               $.ajax({
                 url:'<?php echo Yii::app()->createUrl("cashevent/create");?>',
                 method:"POST",  
                 data:form_data,
                success: function(data)
                { 
                    $('#empModal').modal('hide');
                    $('.save_tech').prop('disabled', false);
                        var obj=$.parseJSON(data);
                        // alert(obj);
                        $('#errorMsg1').html(obj.msg);
                        //alert(obj.msg);
                              $('#errorMsg1').addClass('alert alert-success');
                              $('#errorMsg1').show();
                                window.setTimeout(function () {
                                  $(".alert-success").fadeTo(500, 0).slideUp(500, function () {
                                      $(this).hide();
                                      $(this).css('opacity','100');
                                  });
                              }, 5000); 
                              // setTimeout(function(){ alert("Hello"); }, 3000); 
                      }
              });
        });
    });

</script>

        <script type="text/javascript">
            $('body').on('keydown', '#cashevent-form input,#cashevent-form select', function(e) {
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