<?php $title="Generate Report";?>

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
                    ?>
                    <li><?php echo $title ?></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
     <!-- Horizontal Form Block -->
        <div class="block">
            <!-- Horizontal Form Title -->
            <div class="block-title">
                <h2><?php echo $title;?></h2>
            </div>
              <?php if (Yii::app()->user->hasFlash('success')): ?>
                <div class="alert alert-success alert-dismissable">
                    <p><?php echo Yii::app()->user->getFlash('success'); ?></p>
                </div><?php endif;
                    $form = "";
                    $model = "";
                  ?> 
                  <form method="post" action="<?php echo yii::app()->createUrl('cashevent/generate_excel_new')?>">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                    <label  class="pull-right">User Type ::</label>
                                </div>
                                <div class="col-md-7">
                                    <select class="form-control user_type" name="user_type">
                                        <option value="">---Select User Type---</option>
                                        <option value="1">Supllier</option>
                                        <option value="2">Customer</option>
                                        <option value="3">Karigar</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row" style="margin-top: 10px;">
                                <div class="col-md-3">
                                    <label  class="pull-right">Customer Name ::</label>
                                </div>
                                <div class="col-md-7">
                                    <select class="form-control customer_id " name="customer_id">
                                       <!--  <option value="">---Select Customer---</option> -->
                                        <!-- <option value="all_cust">All</option> -->
                                        <?php 
                                            /*$model = Customer::model()->findAll();
                                            foreach ($model as $key => $value)
                                            {*/
                                                ?>
                                                   <!--  <option value="<?php // echo $value->id; ?>"><?php // echo $value->name; ?></option> -->
                                                <?php
                                          //  }
                                        ?>
                                    </select>
                                </div>
                                     <a href="javascript:void(0)" id="bt" class="btn btn-warning">Unselect</a>
                            </div>

                            <!-- <div class="row" style="margin-top: 10px;">
                                <div class="col-md-3">
                                    <label class="pull-right">Event Type ::</label>
                                </div>
                                <div class="col-md-7">
                                    <select class="form-control evevt_type" name="event_type">
                                        <option value="all_type">All</option>
                                        <option value="1">Cash</option>
                                        <option value="2">Gold</option>
                                        <option value="3">Bank</option>
                                        <option value="4">Card</option>
                                         <option value="5">Discount</option>
                                          <option value="6">Item</option>
                                    </select>
                                </div>
                            </div> -->
                            
                            <!--  <select class="js-data-example-ajax"></select> -->

                    <div class="row" style="margin-top: 10px;">
                           <div class="col-md-3">
                                <label  class="pull-right">Select Date ::</label>
                            </div>
                       <!--  <div class="col-md-7">
                            <div class="input-group" >
                              <input type="text" id="example-datepicker3" name="example-datepicker3" class="form-control input-datepicker start_date" data-date-format="dd-mm-yyyy" placeholder="Start Date">
                                <span class="input-group-addon"><i class="fa fa-chevron-right"></i></span>
                               <input type="text" id="example-datepicker" name="example-datepicker" class="form-control input-datepicker end_date" data-date-format="dd-mm-yyyy" placeholder="End Date">
                            </div>
                        </div>
                    </div> -->

                <div class="col-md-7">
                    <div class="input-group input-daterange" data-date-format="dd-mm-yyyy">
                        <input type="text" id="example-daterange1" name="start_date" class="form-control start_date" placeholder="Start Date" readonly="">
                        <span class="input-group-addon"><i class="fa fa-chevron-right"></i></span>
                        <input type="text" id="example-daterange2" name="end_date" class="form-control end_date" placeholder="End Date" readonly="">
                    </div>
                </div>
            </div>
                  <!--  <select id='selUser' style='width: 200px;'>
                         <option value='0'>-- Search user --</option>
                    </select> -->     

                        <div class="row" style=" margin-left:225px;  margin-top: 15px;">
                      <!--       <input type="submit" name="generate_excel" class="btn btn-info generate_excel" value="Generate Report"> -->
                         <button class="btn btn-info generate_excel" type="submit"><i class="fa fa-file-excel-o"></i> Generate Report</button>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
               <!--  <button id="bt">Unselect</button> -->

            </form>

            <script type="text/javascript">                
                $(document).ready(function() {
                         // $('.customer_id').html("<option value='All'>All</option>"); 
                    //  $(".customer_type").select2();
                     /* $('.js-data-example-ajax').select2({
                          ajax: {
                            url: 'https://api.github.com/search/repositories',
                            dataType: 'json'
                          }
                        });*/
                        $('#bt').click(function () {
                            $('.customer_id').val('').trigger("change");
                        });
                               $(".customer_id").select2({
                                  ajax: { 
                                   url:'<?php echo Yii::app()->createUrl("cashevent/findcustomer");?>',
                                   type: "post",
                                   dataType: 'json',
                                   delay: 250,
                                   data: function (params) {
                                    return {
                                      searchTerm: params.term // search term
                                    };
                                   },
                                   processResults: function (response) {
                                      return {
                                        results: response
                                     };
                                   },
                                   cache: true
                                  }
                                });

                        $('body').on('click','.generate_excel',function()
                        {
                                var user_type = $('.user_type').val();
                                var customer_id = $('.customer_id').val();
                                var evevt_type = $('.evevt_type').val();
                                var start_date = $('.start_date').val();
                                var end_date = $('.end_date').val();
                                // alert(end_date);
                              //AJAX request
                               $.ajax({
                                url:'<?php // echo Yii::app()->createUrl("cashevent/generate_excel");?>',
                                 method:"POST",  
                                 data:{user_type:user_type,
                                    customer_id:customer_id,
                                    evevt_type:evevt_type,
                                    start_date:start_date,
                                    end_date:end_date
                                    }, 
                                success: function(response){ 
                                 
                                 /* $('.modal-body').html(response);
                                  $('#empModal').modal('show'); */

                                }
                            });
                        });


                       /* $('body').on('click','.user_type',function()
                        {
                                var user_data = $('.user_type').val();
                                if(user_data !== "")
                                {
                              
                               $.ajax({
                                url:'<?php // echo Yii::app()->createUrl("cashevent/findcustomer");?>',
                                 method:"POST",  
                                 data:{user_data:user_data}, 
                                success: function(response){ 
                                 
                                   $('.customer_type').html(response); 
                               

                                }
                            });
                           }
                        });*/


                    });
            </script>


          <script type="text/javascript">
            
            $('body').on('keydown', 'input, select', function(e) {
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
