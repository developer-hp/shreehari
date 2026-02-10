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
                <h1>Manage Cash</h1>
            </div>
        </div>
        <div class="col-sm-6 hidden-xs">
            <div class="header-section">
                <ul class="breadcrumb breadcrumb-top">
                    <li><?php echo CHtml::link('Manage Cash', array('admin')) ?></li>
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
                <h2>Cash Listing 
                  <?php
                    $id = 0;
                    if(isset($_GET['id']))
                    {
                        $id = $_GET['id'];
                        $cust_name = Customer::model()->findByPk($_GET['id']);
                        echo '&nbsp;&nbsp;&nbsp;&nbsp;'.$cust_name->name;
                    }
                  ?>

                </h2>
            </div>
            <!-- END Partial Responsive Title -->
            <div id="errorMsg1" class="errorMsg1" style="border-radius: 10px; line-height: 1px;" ></div>
            
            <?php if (Yii::app()->user->hasFlash('success')): ?>
                <div class="alert alert-success alert-dismissable">
                    <p><?php echo Yii::app()->user->getFlash('success'); ?></p>
                </div>
            <?php endif; ?>
            <?php if (Yii::app()->user->hasFlash('danger')): ?>
                <div class="alert alert-danger alert-dismissable">
                    <p><?php echo Yii::app()->user->getFlash('danger'); ?></p>
                </div>
            <?php endif; ?>
            <?php // echo CHtml::button('Delete', array('id' => 'btnDelete', 'class' => 'btn btn-effect-ripple btn-danger')); ?>
            <?php 
            $loginuser = User::model()->findByPk(Yii::app()->user->id);
            $action = strtolower(Yii::app()->controller->action->id);
            if($action == "list_supplier_bill")
            {
              $update_action = "update_cash_supplier";
              echo CHtml::link('Add', array('add_cash_supplier'), array('class' => 'btn btn-effect-ripple btn-info')); 
              echo CHtml::link('Print', array('printbill','id'=>$id), array('class' => 'btn btn-effect-ripple btn-success','style'=>'margin-left:5px;')); 
            }
             if($action == "list_customer_bill")
            {
              $update_action = "update_cash_customer";
              echo CHtml::link('Add', array('add_cash_customer'), array('class' => 'btn btn-effect-ripple btn-info')); 
              echo CHtml::link('Print', array('printbill','id'=>$id), array('class' => 'btn btn-effect-ripple btn-success','style'=>'margin-left:5px;')); 
            }
             if($action == "list_karigar_bill")
            {
              $update_action = "update_cash_karigar";
              echo CHtml::link('Add', array('add_cash_karigar'), array('class' => 'btn btn-effect-ripple btn-info')); 
              echo CHtml::link('Print', array('printbill','id'=>$id), array('class' => 'btn btn-effect-ripple btn-success','style'=>'margin-left:5px;')); 
            }

            echo "&nbsp;";
            if($loginuser->user_type==1)
            echo CHtml::link('Clear Account', array('add_cash_karigar'), array('class' => 'btn btn-effect-ripple btn-danger clear_accont','data-id'=>$_GET['id']) ); 
          ?>

			<?php $this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'cashevent-grid',
				'dataProvider'=>$model->search_bill(),
				'filter'=>$model,
				'pager' => array(
                    'header' => '',
                    'selectedPageCssClass'=>'active',
                    // 'cssFile' => Yii::app()->baseurl . '/css/bootstrap.min.css',
                ),
				'itemsCssClass' => 'table table-striped table-bordered table-vcenter table-responsive',
				'columns'=>array(
           
           array(
            'name'=>'created_date',
            'headerHtmlOptions'=>array('style'=>'text-align: center;','class'=>'text_upper'),
            'htmlOptions'=>array('style'=>'text-align: center;', 'class'=>'zzz'),
            'value'=>function($data)
            {
              echo $new_date = date('d-m-Y',strtotime($data->created_date));
              // echo $new_date = date('d-m-Y H:i:s',strtotime($data->created_date)); 
            }
          ), 
					
					/* array(
	         		 'name'=>'customer_id',
               'headerHtmlOptions'=>array('class'=>'text_upper'),
	         		 'value'=>function($data){
	         		 	if(isset($data->getcust->name))
	         		 	{
	         		 		echo $data->getcust->name;
	         		 	}
	         		 }
         		), */
					
					
					array(
						'name'=>'referral_code',
            'headerHtmlOptions'=>array('style'=>'text-align: center;','class'=>'text_upper'),
						 'htmlOptions'=>array('style'=>'text-align: center;', 'class'=>'zzz'),
						'value'=>function($data)
						{
							echo $data->referral_code;
						}
					),

           array(
               'header'=>'Amount',
               'headerHtmlOptions'=>array('style'=>'text-align: right;','class'=>'text_upper'),
               'htmlOptions'=>array('style'=>'text-align: right;', 'class'=>'right_amount'),
               'footer'=>'<span class="footer_amount">'.$model->amount_total($model->search_bill()->getData()).'</span>',
               'value'=>function($data){
                if(isset($data->id))
                {
                    $condition = "1=1";
                    $criteria=new CDbCriteria;
                    $criteria->select =' sum(amount) as amount ';
                    // $condition .= ' AND amount > 0 ' ;
                    $condition .= ' AND cashevent_id ='.$data->id;
                    $criteria->condition = $condition;
                     // print_r($criteria);
                    $cash_amount=Cashlogs::model()->find($criteria);
                    if($cash_amount->amount)
                    {
                      // echo number_format((float)$cash_amount->amount, 2, '.', '');
                      echo $cash_amount->amount;
                    }
                }
               }
            ), 

           array(
               'header'=>'Metal',
               'headerHtmlOptions'=>array('style'=>'text-align: right;' , 'class'=>'text_upper'),
               'htmlOptions'=>array('style'=>'text-align: right;', 'class'=>'right_amount'),
              'footer'=>'<span class="footer_amount">'.$model->metal_total($model->search()->getData()).'</span>',
               'value'=>function($data){
                if(isset($data->id))
                {
                    $condition = "1=1";
                    $criteria = new CDbCriteria;
                    $criteria->select ='SUM(IF((t.amount = "0" OR t.amount is null OR t.amount = "") and   t.item_id = "0" ,(t.weight),0)) AS weight  ';
                    $condition .= ' AND cashevent_id ='.$data->id;
                    $criteria->condition = $condition;
                    $cash_amount=Cashlogs::model()->find($criteria);
                    if($cash_amount->weight != 0)
                    {
                      echo number_format((float)$cash_amount->weight, 3, '.', '');
                    }

                  /* $condition = "1=1";
                    $criteria=new CDbCriteria;
                    $criteria->select =' sum(weight) as weight ';
                    $condition .= ' AND cashevent_id ='.$data->id;
                    $criteria->condition = $condition;
                    $cash_amount=Cashlogs::model()->find($criteria);
                    if($cash_amount->weight)
                    {
                      $condition = "1=1";
                      $criteria=new CDbCriteria;
                      $criteria->select =' sum(weight) as weight ';
                      $condition .= ' AND amount != 0 ' ;
                      $condition .= ' AND type = 2 ' ;
                      $condition .= ' AND cashevent_id ='.$data->id;
                      $criteria->condition = $condition;
                      $cash_amount_type = Cashlogs::model()->find($criteria);
                      $main_total =$cash_amount->weight - $cash_amount_type->weight ;
                     echo number_format((float)$main_total, 3, '.', '');
                    }  */


                }
               }
            ), 


	        /* array(
                'name' => 'narration',
                'type' => 'html',
                'value' => function($data){
                    if (strlen($data->narration) > 30) {
                        return substr($data->narration, 0, 30).' ... ';
                    }else{
                        return $data->narration;
                    }
                }
            ), */

					
					// 'created_date',
					// 'is_deleted',
					
					/*array(
						'class'=>'CButtonColumn',
					),*/
        
       
					array(
                        'class' => 'ButtonColumn',
                        'htmlOptions' => array('style' => 'width: 160px;text-align: center;'),
                        'template' => '{cash} {view} {update} {delete}',
                        'buttons' => array(

                             'cash' => array(
                                'label' => '<i class="fa fa-money"></i>',
                                'imageUrl' => false,
                                'options' => array('class' => 'btn btn-effect-ripple btn-sm btn-primary tech_popup', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Cash Event'),"data-id"=>'$data->id','evaluateOptions' => array('data-id'),'disabled'=>''),
                                'type' => 'raw',
                               
                                 //'url'=>'Yii::app()->createUrl("Customer/update_supllier",array("id"=>$data->id))'
                            ),

                            'update' => array(
                                'label' => '<i class="fa fa-pencil"></i>',
                                'imageUrl' => false,
                                'options' => array('class' => 'btn btn-effect-ripple btn-sm btn-success', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Update')),
                                'type' => 'raw',
                                'visible'=>($loginuser->user_type==2)?'($data->check_date=="'.date('Y-m-d').'")?true:false':'true',
                                 'url'=>'Yii::app()->createUrl("cashevent/'.$update_action.'",array("id"=>$data->id))'
                            ),
                            'view' => array(
                                'label' => '<i class="fa fa-eye"></i>',
                                'imageUrl' => false,
                                'options' => array('class' => 'btn btn-effect-ripple btn-sm btn-warning', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'View Details')),
                                'type' => 'raw',
                                 'url'=>'Yii::app()->createUrl("cashevent/view_event",array("id"=>$data->id))'

                            ),
                            'delete' => array(
                            'options' => array('class' => 'btn btn-effect-ripple btn-sm btn-danger', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Delete')),
                            'label' => '<i class="fa fa-trash"></i>',
                            'imageUrl' => false,
                             'visible'=>($loginuser->user_type==2)?'($data->check_date=="'.date('Y-m-d').'")?true:false':'true'
                        	),
                        ),
                    ),
				),
			)); ?>
	</div>
    </div>
</div>


<div class="modal fade" id="empModal" role="dialog">
    <div class="modal-dialog" style="width:1000px;">
      <div class="modal-content">
         <div class="modal-header">
           <!--  <h4 class="modal-title">Cash Event</h4> -->
             <button type="button" class="close" data-dismiss="modal">&times;</button>
             <h4 class="modal-title"><b>Add Cash</b></h4>
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

    $('body').on('click','.clear_accont',function()
    {
      var clear_accont_id = $(this).attr("data-id");
      
      if (confirm('Are you sure want to clear this account? This action can not be roll back')) 
      {
        // alert(clear_accont_id);
          $.ajax({
                 url:'<?php echo Yii::app()->createUrl("cashevent/clear_account");?>',
                 method:"POST",  
                 data:{clear_accont_id:clear_accont_id},
                  success: function(data)
                  { 
                      $("#cashevent-grid").yiiGridView("update",{}); 
                  }
            });

      }

    });



    $(document).ready(function()
    {
      $("#Cashevent_created_date").mask("99-99-9999");
    }); 

     $(document).ready(function()
     {
        // Cash Add more
         $('body').on('click','.add_cash_button',function()
        {
          var h = $('.add-more-cash').html().replace('item-ele','item');
          $('.items_cash').append(h);
        });

        $('body').on('click','.cash_remove',function(){
            $(this).closest('.blocks').remove();
        });

        // Gold Add more
         $('body').on('click','.add_gold_button',function()
        {
          var h = $('.add-more-gold').html().replace('item-ele','item');
          $('.items_gold').append(h);
        });

        $('body').on('click','.gold_remove',function(){
            $(this).closest('.blocks').remove();
        });


         $('body').on('click','.add_diamond_button',function()
        {
          var h = $('.add-more-diamond').html().replace('item-ele','item');
          $('.items_diamond').append(h);
        });

        $('body').on('click','.diamond_remove',function(){
            $(this).closest('.blocks').remove();
        });


        // Bank Add more
         $('body').on('click','.add_bank_button',function()
        {
          var h = $('.add-more-bank').html().replace('item-ele','item');
          $('.items_bank').append(h);
        });

        $('body').on('click','.bank_remove',function(){
            $(this).closest('.blocks').remove();
        });


         // Card Add more
         $('body').on('click','.add_card_button',function()
        {
          var h = $('.add-more-card').html().replace('item-ele','item');
          $('.items_card').append(h);
        });

        $('body').on('click','.card_remove',function(){
            $(this).closest('.blocks').remove();
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

       /* function validation(e)
          {
            alert("FFF");
          }
      */

        $('body').on('click','.tech_popup',function(){
           var cust_id = $(this).data('id');
          //alert(order_id);
          //AJAX request
           $.ajax({
             url:'<?php echo Yii::app()->createUrl("cashevent/openpopup");?>',
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

          $('body').on('click','.add_button,.add_cash_button,.add_gold_button,.add_diamond_button,.add_bank_button,.add_card_button,.remove ,.delete_record,.clear_accont',function(event)
        {
           event.preventDefault();
        });


         $('body').on('submit','#cashevent-form',function(event)
         {
          event.preventDefault();
           // validation();
           var form_data = $('#cashevent-form').serialize();
          /* var cust_id = $('.customer_id').val();
            var gold_amount = $('.gold_amount').val();
            var amount = $('.amount').val();
            var gold_type = $('.gold_type').val();
            var cash_type = $('.cash_type').val();
            var create_date = $('.create_date').val();
            var note = $('.note').val();*/

          // var select_tech_class = $('.select_tech_class').val();
            // alert(cust_id);
            /* if(cust_id)
            { */
               $.ajax({
                 url:'<?php echo Yii::app()->createUrl("cashevent/add_new_cash");?>',
                 method:"POST",  
                 data:form_data,
                 /*{cust_id:cust_id,
                    gold_amount:gold_amount,
                        amount:amount,
                        gold_type:gold_type,
                        cash_type:cash_type,
                        create_date:create_date,
                        note:note
                        form_data
                        }, */
                success: function(data)
                { 
                    $('#empModal').modal('hide');
                    $('.save_tech').prop('disabled', false);
                        var obj=$.parseJSON(data);
                        // alert(data['msg']);
                        // $('#errorMsg1').html(obj.msg);
                        // alert(obj.msg);
                              if(obj.msg == 0)
                              {
                                $('#errorMsg1').html('Record not inserted Successfully......');
                                  $('#errorMsg1').addClass('alert alert-danger');
                                  $('#errorMsg1').show();
                                    window.setTimeout(function () {
                                      $(".alert-danger").fadeTo(500, 0).slideUp(500, function () {
                                          $(this).hide();
                                          $(this).css('opacity','100');
                                      });
                                  }, 5000);
                              }
                              else
                              {
                                 $('#errorMsg1').html('Cash Add Successfully......');
                                  $('#errorMsg1').addClass('alert alert-success');
                                  $('#errorMsg1').show();
                                    window.setTimeout(function () {
                                      $(".alert-success").fadeTo(500, 0).slideUp(500, function () {
                                          $(this).hide();
                                          $(this).css('opacity','100');
                                      });
                                  }, 5000);
                              }
                              $("#cashevent-grid").yiiGridView("update",{}); 
                              // setTimeout(function(){ alert("Hello"); }, 3000); 
                      }
              });
           // }
        });

    });

</script>

      <script type="text/javascript">
            
            $('body').on('keydown', '#cashevent-form input , #cashevent-form select', function(e) {
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