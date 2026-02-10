 <div class="content-header">
    <div class="row">
        <div class="col-sm-6">
            <div class="header-section">
                <h1>Home</h1>
            </div>
        </div>
        
    </div>
</div>

<div class="row">
  <div class="col-lg-12">
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

        <!-- Database Backup code -->

   <!--  <form name="clear" action="<?php // echo Yii::app()->createUrl('customer/database_export');?>" >
       <button type="submit" name="clear_all_data" class="btn btn-danger clear_all_data" onclick="return confirm('Are sure clear all data in database..?');"><i class="fa fa-trash"> Clear Data</i></button>
   </form> -->

   <?php 
    $loginuser = User::model()->findByPk(Yii::app()->user->id);
        if($loginuser->user_type == 1)
        {
   ?>

          <button type="button" name="clear_all_data" class="btn btn-danger tech_popup" data-id='1'><i class="fa fa-trash"> Clear Data</i></button>  &nbsp;&nbsp;&nbsp;

          <button type="button" name="clear_all_data_with _backup" class="btn btn-danger tech_popup_backup" data-id='2'><i class="fa fa-trash"> Backup Database</i></button> 
                    &nbsp;&nbsp;&nbsp;
          <button type="button" name="import_data" class="btn btn-info import_data" data-id='3'><i class="fa fa-upload"> Import Data</i></button>  

          <!--  <a href="javascript:void(0)" class = 'btn btn-effect-ripple btn-danger btn-lg tech_popup_without fa fa-trash'> Clear Data</a>  &nbsp;&nbsp;&nbsp;
          <a href="javascript:void(0)" class = 'btn btn-effect-ripple btn-danger btn-lg tech_popup fa fa-trash'> Clear Data With Backup</a> -->
      <?php
      }
      ?>

  </div>
</div>
<div class="row" style="margin-top: 10px;">
    <div class="col-sm-6 col-lg-4">
        <a href="<?php echo Yii::app()->request->baseUrl.'/cashevent/today_cash/';?>" class="widget">
        <!-- <a href="<?php // echo Yii::app()->request->baseUrl.'/account/applicants/'.$account_id.'?tab=applicants'; ?>" class="widget"> -->
            <div class="widget-content widget-content-mini text-right clearfix">
                <div class="widget-icon pull-left themed-background">
                    <i class="fa fa-money text-light-op"></i>
                </div>
                <h2 class="widget-heading h3 text">
                    <strong><span data-toggle="counter" data-to="2862">
                             <?php   
                                    /* $model = Cashevent::model()->findAll('DATE(created_date) ="'. $date.'" and is_deleted=0 and cash_type=1');
                                    $total_cash_in = "";
                                    foreach ($model as $key => $value)
                                    {
                                        $total_cash_in = $total_cash_in+$value->amount;
                                      
                                    }
                                     echo $total_cash_in; */

                                      $date = date("Y-m-d");
                                      $deleted = 0;
// SELECT sum(amount) as amount FROM cp_cash_logs WHERE 1=1 and type ="1" and date BETWEEN "2020-02-08 00:00:00" AND "2020-02-08 23:59:59"
                                      $condition = "1=1";
                                      $criteria=new CDbCriteria;
                                      $criteria->select=' sum(amount) as amount';
                                      $condition .= ' AND type ="1" ';
                                      $condition .= ' AND date BETWEEN "'.$date.' 00:00:00" AND "'.$date.' 23:59:59 "';
                                      $criteria->condition = $condition;
                                      // print_r($criteria);die();
                                      $cash_amount=Cashlogs::model()->find($criteria);
                                       echo "₹ ".$cash_amount->amount;
                                      // $new_cash = number_format((float)$cash_amount->amount, 2, '.', '');
                                      // echo "₹ ".$new_cash;


                                    ?>
                    </span></strong>
                </h2>
                <span class="text-muted">Today Cash Amount</span>
            </div>
        </a>
    </div>

    <div class="col-sm-6 col-lg-4">
        <a href="<?php echo Yii::app()->request->baseUrl.'/cashevent/today_gold/';?>" class="widget">
            <div class="widget-content widget-content-mini text-right clearfix">
                <div class="widget-icon pull-left themed-background">
                    <i class="fa fa-money text-light-op"></i>
                </div>
                <h2 class="widget-heading h3 text">
                    <strong> <span data-toggle="counter" data-to="2862">
                          <?php
                           /* $date = date("Y-m-d");
                         
                            $model = Cashevent::model()->findAll('DATE(created_date) ="'. $date.'" and is_deleted=0 and cash_type=2');
                            $total_cash_out = "";
                            foreach ($model as $key => $value)
                            {
                                $cash_amount = ltrim($value->amount, '-'); 
                                $total_cash_out = $total_cash_out+$cash_amount;
                            }
                           echo $total_cash_out;*/

                           // $deleted = 0;
                           //            $condition = "1=1";
                           //            $criteria=new CDbCriteria;
                           //            $criteria->select=' * ,sum(amount) as amount';
                           //            $condition .= ' and is_deleted ="'. $deleted.'" and cash_type ="2"  ';
                           //            $condition .= ' and created_date BETWEEN "'.$date.' 00:00:00" AND "'.$date.' 23:59:59 "';
                           //            $criteria->condition = $condition;
                           //            $model_out=Cashevent::model()->find($criteria);
                           //             $cash_amount_out = ltrim($model_out->amount, '-'); 
                           //            echo "₹ ".$cash_amount_out;
                                  $condition = "1=1";
                                      $criteria=new CDbCriteria;
                                      $criteria->select=' sum(amount) as amount';
                                      $condition .= ' AND type ="2" ';
                                      $condition .= ' AND date BETWEEN "'.$date.' 00:00:00" AND "'.$date.' 23:59:59 "';
                                      $criteria->condition = $condition;
                                      // print_r($criteria);die();
                                      $model_gold=Cashlogs::model()->find($criteria);
                                      echo "₹ ".$model_gold->amount;
                                      // $new_gold = number_format((float)$model_gold->amount, 2, '.', '');
                                      // echo "₹ ".$new_gold;

                        ?>

                    </span></strong>
                </h2>
                <span class="text-muted">Today Gold Amount</span>
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-lg-4">
        <a href="<?php echo Yii::app()->request->baseUrl.'/cashevent/today_bank/';?>" class="widget">
            <div class="widget-content widget-content-mini text-right clearfix">
                <div class="widget-icon pull-left themed-background">
                    <i class="fa fa-money text-light-op"></i>
                    <!-- <i class="fas fa-coins"></i> -->
                </div>
                <h2 class="widget-heading h3 text">
                    <strong> <span data-toggle="counter" data-to="2862">
                        
                    <?php
                      /*  $date = date("Y-m-d");
                        $model = Cashevent::model()->findAll('DATE(created_date) ="'. $date.'" and is_deleted=0 and gold_type=1');
                        $total_gold_in = "";
                        foreach ($model as $key => $value)
                        {
                            $total_gold_in = $total_gold_in+$value->gold_amount;
                          
                        }
                         echo $total_gold_in; */

                                 $condition = "1=1";
                                      $criteria=new CDbCriteria;
                                      $criteria->select=' sum(amount) as amount';
                                      $condition .= ' AND type ="3" ';
                                      $condition .= ' AND date BETWEEN "'.$date.' 00:00:00" AND "'.$date.' 23:59:59 "';
                                      $criteria->condition = $condition;
                                      // print_r($criteria);die();
                                      $model_bank=Cashlogs::model()->find($criteria);
                                       echo "₹ ".$model_bank->amount;
                                       // $new_bank = number_format((float)$model_bank->amount, 2, '.', '');
                                      // echo "₹ ".$new_bank;

                    ?>

                    </span></strong>
                </h2>
                <span class="text-muted">Today Bank Amount</span>
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-lg-4" >
        <a href="<?php echo Yii::app()->request->baseUrl.'/cashevent/today_card/';?>" class="widget">
            <div class="widget-content widget-content-mini text-right clearfix">
                <div class="widget-icon pull-left themed-background">
                    <i class="fa fa-money text-light-op"></i>
                </div>
                <h2 class="widget-heading h3 text">
                    <strong><span data-toggle="counter" data-to="2862">
                        
                         <?php
                          /*  $date = date("Y-m-d");
                            $model = Cashevent::model()->findAll('DATE(created_date) ="'. $date.'" and is_deleted=0 and gold_type=2');
                            $total_gold_out = "";
                            foreach ($model as $key => $value)
                            {
                                $gold_amount_change = ltrim($value->gold_amount, '-'); 
                                $total_gold_out = $total_gold_out+$gold_amount_change;
                            }
                           echo $total_gold_out; */

                                   $condition = "1=1";
                                      $criteria=new CDbCriteria;
                                      $criteria->select=' sum(amount) as amount';
                                      $condition .= ' AND type ="4" ';
                                      $condition .= ' AND date BETWEEN "'.$date.' 00:00:00" AND "'.$date.' 23:59:59 "';
                                      $criteria->condition = $condition;
                                      // print_r($criteria);die();
                                      $model_card=Cashlogs::model()->find($criteria);
                                      echo "₹ ".$model_card->amount;
                                      // $new_card = number_format((float)$model_card->amount, 2, '.', '');
                                      // echo "₹ ".$new_card;


                        ?>


                    </span></strong>
                </h2>
                <span class="text-muted">Today Card Amount</span>
            </div>
        </a>
    </div>


    <div class="col-sm-6 col-lg-4">
        <a href="<?php echo Yii::app()->request->baseUrl.'/cashevent/today_discount/';?>" class="widget">
            <div class="widget-content widget-content-mini text-right clearfix">
                <div class="widget-icon pull-left themed-background">
                    <i class="fa fa-money text-light-op"></i>
                </div>
                <h2 class="widget-heading h3 text">
                    <strong><span data-toggle="counter" data-to="2862">
                             <?php
                                   
                                    /* $model = Cashevent::model()->findAll('DATE(created_date) ="'. $date.'" and is_deleted=0 and cash_type=1');
                                    $total_cash_in = "";
                                    foreach ($model as $key => $value)
                                    {
                                        $total_cash_in = $total_cash_in+$value->amount;
                                      
                                    }
                                     echo $total_cash_in; */

                                      $condition = "1=1";
                                      $criteria=new CDbCriteria;
                                      $criteria->select=' sum(amount) as amount';
                                      $condition .= ' AND type ="5" ';
                                      $condition .= ' AND date BETWEEN "'.$date.' 00:00:00" AND "'.$date.' 23:59:59 "';
                                      $criteria->condition = $condition;
                                      // print_r($criteria);die();
                                      $model_dis=Cashlogs::model()->find($criteria);
                                      echo "₹ ".$model_dis->amount;
                                      // $new_dis = number_format((float)$model_dis->amount, 2, '.', '');
                                      // echo "₹ ".$new_dis;

                                    ?>
                    </span></strong>
                </h2>
                <span class="text-muted">Today Discount Amount</span>
            </div>
        </a>
    </div>


     <div class="col-sm-6 col-lg-4">
        <a href="<?php echo Yii::app()->request->baseUrl.'/cashevent/today_item/';?>" class="widget">
            <div class="widget-content widget-content-mini text-right clearfix">
                <div class="widget-icon pull-left themed-background">
                    <i class="fa fa-money text-light-op"></i>
                </div>
                <h2 class="widget-heading h3 text">
                    <strong> <span data-toggle="counter" data-to="2862">
                          <?php
                           /* $date = date("Y-m-d");
                         
                            $model = Cashevent::model()->findAll('DATE(created_date) ="'. $date.'" and is_deleted=0 and cash_type=2');
                            $total_cash_out = "";
                            foreach ($model as $key => $value)
                            {
                                $cash_amount = ltrim($value->amount, '-'); 
                                $total_cash_out = $total_cash_out+$cash_amount;
                            }
                           echo $total_cash_out;*/

                                     $condition = "1=1";
                                      $criteria=new CDbCriteria;
                                      $criteria->select=' sum(amount) as amount';
                                      $condition .= ' AND type ="6" ';
                                      $condition .= ' AND date BETWEEN "'.$date.' 00:00:00" AND "'.$date.' 23:59:59 "';
                                      $criteria->condition = $condition;
                                      // print_r($criteria);die();
                                      $model_item=Cashlogs::model()->find($criteria);
                                      echo "₹ ".$model_item->amount;
                                      // $new_item = number_format((float)$model_item->amount, 2, '.', '');
                                      // echo "₹ ".$new_item;
                        ?>

                    </span></strong>
                </h2>
                <span class="text-muted">Today Item Amount</span>
            </div>
        </a>
    </div>


                       <div class="row">

                           <div class="col-lg-12">  

                             <div class="col-lg-6">
                                <!-- Partial Responsive Block -->
                                <div class="block" style="height: 357px;">
                                    <!-- Partial Responsive Title -->
                                    <div class="block-title">
                                        <h2>Recent Cash Amount Entry</h2>
                                    </div>
                                    <!-- END Partial Responsive Title -->
                                    <?php
                                    //SELECT * FROM `cp_cash_logs` WHERE `type`= 1 order by id LIMIT 10
                                    $record_cash =  Cashlogs::model()->findAll('check_date="'.date('Y-m-d').'" and type = 1 order by id desc limit 10');
                                      /*  print_r($record_back);
                                        die;  */   
                                     ?>  
                                   
                                    <table class="table table-striped table-borderless table-vcenter">
                                        

                                        <thead>
                                            <tr>
                                                <th>Customer Name</th>
                                                <th class="hidden-xs">Amount</th>
                                                <th class="hidden-sm hidden-xs">Date</th>
                                               
                                            </tr>
                                        </thead>
                                        <tbody>

                                          <!--   <tr>
                                                <td>
                                                    <?php
                                                    /* if($record_cash == "")
                                                        {
                                                            echo "No result found";
                                                        }*/
                                                    ?>
                                                </td>
                                            </tr> -->

                                                   <?php
                                                    // print_r($record_gold);
                                                     if(empty($record_cash))
                                                        {

                                                            ?>
                                                        <tr>
                                                            <td>
                                                                <?php
                                                                    echo "No result found";
                                                                ?>
                                                             </td>
                                                        </tr>
                                                            <?php
                                                        }
                                                        else
                                                        {
                                                    ?>

                                                <?php

                                                      foreach ($record_cash as $key => $value) {
                                                ?>
                                                <tr>
                                                    <td><strong>
                                                        <?php
                                                        $cust_name = Customer::model()->findByPk($value->customer_id);
                                                        if (isset($cust_name->name)) {
                                                            echo $cust_name->name;
                                                        }
                                                        ?>
                                                    </strong></td>
                                                    <td class="hidden-xs">
                                                        <?php
                                                            if(isset($value->amount))
                                                            {
                                                                echo $value->amount;
                                                            }
                                                           
                                                        ?>
                                                    </td>
                                                    <td class="hidden-xs" >
                                                            
                                                        <?php
                                                            if(isset($value->date))
                                                            {
                                                                $new_date = date('d-m-Y',strtotime($value->date));
                                                                echo $new_date;
                                                            }
                                                          
                                                        ?>
                                                    </td>
                                                  
                                            </tr>   
                                             <?php
                                                   }
                                               }
                                                   ?> 
                                        </tbody>
                                    </table>
                                    <!-- END Partial Responsive Content -->
                                </div>
                                <!-- END Partial Responsive Block -->
                            </div>



                             <div class="col-lg-6">
                                <!-- Partial Responsive Block -->
                                <div class="block" style="height: 357px;">
                                    <!-- Partial Responsive Title -->
                                    <div class="block-title">
                                        <h2>Recent Gold Amount Entry</h2>
                                    </div>
                                    <!-- END Partial Responsive Title -->
                                    <?php
                                    $record_gold =  Cashlogs::model()->findAll('check_date="'.date('Y-m-d').'" and type = 2  order by id desc limit 10');
       
                                     ?>  
                                   
                                    <table class="table table-striped table-borderless table-vcenter">
                                        

                                        <thead>
                                            <tr>
                                                <th>Customer Name</th>
                                                <th class="hidden-xs">Amount</th>
                                                <th class="hidden-sm hidden-xs">Date</th>
                                               
                                            </tr>
                                        </thead>
                                        <tbody>


                                                   <?php
                                                    // print_r($record_gold);
                                                     if(empty($record_gold))
                                                        {

                                                            ?>
                                                        <tr>
                                                            <td>
                                                                <?php
                                                                    echo "No result found";
                                                                ?>
                                                             </td>
                                                        </tr>
                                                            <?php
                                                        }
                                                        else
                                                        {
                                                    ?>

                                                <?php

                                                      foreach ($record_gold as $key => $value) {
                                                ?>
                                                <tr>
                                                    <td><strong>
                                                        <?php
                                                        $cust_name = Customer::model()->findByPk($value->customer_id);
                                                        if (isset($cust_name->name)) {
                                                            echo $cust_name->name;
                                                        }
                                                        ?>
                                                    </strong></td>
                                                    <td class="hidden-xs">
                                                        <?php
                                                            if(isset($value->amount))
                                                            {
                                                              echo $value->amount;
                                                            }
                                                        ?>
                                                    </td>
                                                    <td class="hidden-xs">
                                                            
                                                        <?php
                                                            if(isset($value->date))
                                                            {
                                                                $new_date = date('d-m-Y',strtotime($value->date));
                                                                echo $new_date;
                                                            }
                                                          
                                                        ?>
                                                    </td>
                                                  
                                            </tr>   
                                             <?php
                                                   }
                                               }
                                                   ?> 
                                        </tbody>
                                    </table>
                                    
                                </div>
                            </div>
                        </div>
                          
                      </div>

                        <div class="row hidden">
                           <div class="col-lg-12">
                             <div class="col-lg-6">
                                <!-- Partial Responsive Block -->
                                <div class="block" style="height: 357px;">
                                    <!-- Partial Responsive Title -->
                                    <div class="block-title">
                                        <h2>Recent Bank Amount Entry</h2>
                                    </div>
                                    <!-- END Partial Responsive Title -->
                                    <?php
                                    //SELECT * FROM `cp_cash_logs` WHERE `type`= 1 order by id LIMIT 10
                                    $record_bank =  Cashlogs::model()->findAll('type = 3 order by id desc limit 10');
                                      /*  print_r($record_back);
                                        die;  */   
                                     ?>  
                                   
                                    <table class="table table-striped table-borderless table-vcenter">
                                        

                                        <thead>
                                            <tr>
                                                <th>Customer Name</th>
                                                <th class="hidden-xs">Amount</th>
                                                <th class="hidden-sm hidden-xs">Date</th>
                                               
                                            </tr>
                                        </thead>
                                        <tbody>

                                          <!--   <tr>
                                                <td>
                                                    <?php
                                                    /* if($record_cash == "")
                                                        {
                                                            echo "No result found";
                                                        }*/
                                                    ?>
                                                </td>
                                            </tr> -->

                                                   <?php
                                                    // print_r($record_gold);
                                                     if(empty($record_bank))
                                                        {

                                                            ?>
                                                        <tr>
                                                            <td>
                                                                <?php
                                                                    echo "No result found";
                                                                ?>
                                                             </td>
                                                        </tr>
                                                            <?php
                                                        }
                                                        else
                                                        {
                                                    ?>

                                                <?php

                                                      foreach ($record_bank as $key => $value) {
                                                ?>
                                                <tr>
                                                    <td><strong>
                                                        <?php
                                                        $cust_name = Customer::model()->findByPk($value->customer_id);
                                                        if (isset($cust_name->name)) {
                                                            echo $cust_name->name;
                                                        }
                                                        ?>
                                                    </strong></td>
                                                    <td class="hidden-xs">
                                                        <?php
                                                            if(isset($value->amount))
                                                            {
                                                                echo $value->amount;
                                                            }
                                                           
                                                        ?>
                                                    </td>
                                                    <td class="hidden-xs" >
                                                            
                                                        <?php
                                                            if(isset($value->date))
                                                            {
                                                                $new_date = date('d-m-Y',strtotime($value->date));
                                                                echo $new_date;
                                                            }
                                                          
                                                        ?>
                                                    </td>
                                                  
                                            </tr>   
                                             <?php
                                                   }
                                               }
                                                   ?> 
                                        </tbody>
                                    </table>
                                    <!-- END Partial Responsive Content -->
                                </div>
                                <!-- END Partial Responsive Block -->
                            </div>



                             <div class="col-lg-6">
                                <!-- Partial Responsive Block -->
                                <div class="block" style="height: 357px;">
                                    <!-- Partial Responsive Title -->
                                    <div class="block-title">
                                        <h2>Recent Card Amount Entry</h2>
                                    </div>
                                    <!-- END Partial Responsive Title -->
                                    <?php
                                    $record_card =  Cashlogs::model()->findAll('type = 4  order by id desc limit 10');
       
                                     ?>  
                                   
                                    <table class="table table-striped table-borderless table-vcenter">
                                        

                                        <thead>
                                            <tr>
                                                <th>Customer Name</th>
                                                <th class="hidden-xs">Amount</th>
                                                <th class="hidden-sm hidden-xs">Date</th>
                                               
                                            </tr>
                                        </thead>
                                        <tbody>


                                                   <?php
                                                    // print_r($record_gold);
                                                     if(empty($record_card))
                                                        {

                                                            ?>
                                                        <tr>
                                                            <td>
                                                                <?php
                                                                    echo "No result found";
                                                                ?>
                                                             </td>
                                                        </tr>
                                                            <?php
                                                        }
                                                        else
                                                        {
                                                    ?>

                                                <?php

                                                      foreach ($record_card as $key => $value) {
                                                ?>
                                                <tr>
                                                    <td><strong>
                                                        <?php
                                                        $cust_name = Customer::model()->findByPk($value->customer_id);
                                                        if (isset($cust_name->name)) {
                                                            echo $cust_name->name;
                                                        }
                                                        ?>
                                                    </strong></td>
                                                    <td class="hidden-xs">
                                                        <?php
                                                            if(isset($value->amount))
                                                            {
                                                                echo $value->amount;
                                                            }
                                                            
                                                        ?>
                                                    </td>
                                                    <td class="hidden-xs" >
                                                            
                                                        <?php
                                                            if(isset($value->date))
                                                            {
                                                                $new_date = date('d-m-Y',strtotime($value->date));
                                                                echo $new_date;
                                                            }
                                                          
                                                        ?>
                                                    </td>
                                                  
                                            </tr>   
                                             <?php
                                                   }
                                               }
                                                   ?> 
                                        </tbody>
                                    </table>
                                    
                                </div>
                            </div>
                        </div>
                      </div>


                      <div class="row hidden">
                         <div class="col-lg-12">
                             <div class="col-lg-6">
                                <!-- Partial Responsive Block -->
                                <div class="block" style="height: 357px;">
                                    <!-- Partial Responsive Title -->
                                    <div class="block-title">
                                        <h2>Recent Discount Amount Entry</h2>
                                    </div>
                                    <!-- END Partial Responsive Title -->
                                    <?php
                                    //SELECT * FROM `cp_cash_logs` WHERE `type`= 1 order by id LIMIT 10
                                    $record_dis =  Cashlogs::model()->findAll('type = 5 order by id desc limit 10');
                                      /*  print_r($record_back);
                                        die;  */   
                                     ?>  
                                   
                                    <table class="table table-striped table-borderless table-vcenter">
                                        

                                        <thead>
                                            <tr>
                                                <th>Customer Name</th>
                                                <th class="hidden-xs">Amount</th>
                                                <th class="hidden-sm hidden-xs">Date</th>
                                               
                                            </tr>
                                        </thead>
                                        <tbody>

                                          <!--   <tr>
                                                <td>
                                                    <?php
                                                    /* if($record_cash == "")
                                                        {
                                                            echo "No result found";
                                                        }*/
                                                    ?>
                                                </td>
                                            </tr> -->

                                                   <?php
                                                    // print_r($record_gold);
                                                     if(empty($record_dis))
                                                        {

                                                            ?>
                                                        <tr>
                                                            <td>
                                                                <?php
                                                                    echo "No result found";
                                                                ?>
                                                             </td>
                                                        </tr>
                                                            <?php
                                                        }
                                                        else
                                                        {
                                                    ?>

                                                <?php

                                                      foreach ($record_dis as $key => $value) {
                                                ?>
                                                <tr>
                                                    <td><strong>
                                                        <?php
                                                        $cust_name = Customer::model()->findByPk($value->customer_id);
                                                        if (isset($cust_name->name)) {
                                                            echo $cust_name->name;
                                                        }
                                                        ?>
                                                    </strong></td>
                                                    <td class="hidden-xs">
                                                        <?php
                                                            if(isset($value->amount))
                                                            {
                                                                echo $value->amount;
                                                            }
                                                           
                                                        ?>
                                                    </td>
                                                    <td class="hidden-xs">
                                                            
                                                        <?php
                                                            if(isset($value->date))
                                                            {
                                                                $new_date = date('d-m-Y',strtotime($value->date));
                                                                echo $new_date;
                                                            }
                                                          
                                                        ?>
                                                    </td>
                                                  
                                            </tr>   
                                             <?php
                                                   }
                                               }
                                                   ?> 
                                        </tbody>
                                    </table>
                                    <!-- END Partial Responsive Content -->
                                </div>
                                <!-- END Partial Responsive Block -->
                            </div>



                             <div class="col-lg-6">
                                <!-- Partial Responsive Block -->
                                <div class="block" style="height: 357px;">
                                    <!-- Partial Responsive Title -->
                                    <div class="block-title">
                                        <h2>Recent Item Amount Entry</h2>
                                    </div>
                                    <!-- END Partial Responsive Title -->
                                    <?php
                                    $record_item =  Cashlogs::model()->findAll('type = 6  order by id desc limit 10');
       
                                     ?>  
                                   
                                    <table class="table table-striped table-borderless table-vcenter">
                                        

                                        <thead>
                                            <tr>
                                                <th>Customer Name</th>
                                                <th class="hidden-xs">Amount</th>
                                                <th class="hidden-sm hidden-xs">Date</th>
                                               
                                            </tr>
                                        </thead>
                                        <tbody>


                                                   <?php
                                                    // print_r($record_gold);
                                                     if(empty($record_item))
                                                        {

                                                            ?>
                                                        <tr>
                                                            <td>
                                                                <?php
                                                                    echo "No result found";
                                                                ?>
                                                             </td>
                                                        </tr>
                                                            <?php
                                                        }
                                                        else
                                                        {
                                                    ?>
                                                <?php

                                                      foreach ($record_item as $key => $value) {
                                                ?>
                                                <tr>
                                                    <td><strong>
                                                        <?php
                                                        $cust_name = Customer::model()->findByPk($value->customer_id);
                                                        if (isset($cust_name->name)) {
                                                            echo $cust_name->name;
                                                        }
                                                        ?>
                                                    </strong></td>
                                                    <td class="hidden-xs">
                                                        <?php
                                                            if(isset($value->amount))
                                                            {
                                                                echo $value->amount;
                                                            }
                                                            
                                                        ?>
                                                    </td>
                                                    <td class="hidden-xs" >
                                                        <?php
                                                            if(isset($value->date))
                                                            {
                                                                $new_date = date('d-m-Y',strtotime($value->date));
                                                                echo $new_date;
                                                            }
                                                        ?>
                                                    </td>
                                            </tr>   
                                             <?php
                                                  }
                                                }
                                                   ?> 
                                        </tbody>
                                    </table>
                                    
                                </div>
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
                         <?php // echo $hidden_id; ?>
                         <h4 class="modal-title"><b>Clear Data</b></h4>
                     </div>
                      <div class="modal-body">

                     <div class="row">
                      <div class="col-md-12">
                       <!-- Horizontal Form Block -->
                          <div class="">
                          
                              <form name="clear" method="post" action="<?php echo Yii::app()->createUrl('customer/clear_without_backup');?>" >
                           
                                 <div class="form-group">
                                    <label class="col-md-4 control-label" style="margin-right: -50px;">Enter Password::</label>
                                    <input type="hidden" name="hidden_id" value="1">
                                       <div class="col-md-7">
                                          <input type="Password" name="user_password" id="user_password" class="form-control">
                                           <span id="passwordValidation" class="help-block" style="color:#de815c;"></span>
                                       </div>
                                    </div>

                                    <div class="form-group form-actions" >
                                      <div class="col-md-9 col-md-offset-3" style="margin-top: 20px !important;">
                                       <input type="submit" name="submit" value="Clear Data" class="btn btn-effect-ripple btn-primary form_submit">
                                          <button type="button" class="btn btn-danger" data-dismiss="modal" style="margin-left: 5px;">Close</button>           
                                      </div>
                                  </div>
                              </form>
                        </div>
                     </div>
                  </div>


                      </div>
                      <div class="modal-footer">
                         <!--    <button type="button" class="btn btn-success save_tech">Save</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> -->
                      </div>
                  </div>
                </div>
            </div>


                    <!-- open Popup add customer -->
            <div class="modal fade" id="empModal_new" role="dialog">
                <div class="modal-dialog" style="width:650px;">
                  <div class="modal-content">
                     <div class="modal-header">
                       <!--  <h4 class="modal-title">Cash Event</h4> -->
                         <button type="button" class="close" data-dismiss="modal">&times;</button>
                         <?php // echo $hidden_id; ?>
                         <h4 class="modal-title"><b>Database Backup</b></h4>
                     </div>
                      <div class="modal-body-new">

                        <div class="row">
                      <div class="col-md-12">
                       <!-- Horizontal Form Block -->
                          <div class="">
                              <form name="clear" method="post" action="<?php echo Yii::app()->createUrl('customer/database_export');?>" >
                                 <div class="form-group">
                                    <label class="col-md-4 control-label" style="margin-right: -50px;">Enter Password::</label>
                                    <input type="hidden" name="hidden_id" value="2">
                                       <div class="col-md-7">
                                          <input type="Password" name="user_password" id="user_password_new" class="form-control ">
                                           <span id="passwordValidation_new" class="help-block" style="color:#de815c;"></span>
                                       </div>
                                    </div>

                                    <div class="form-group form-actions" >
                                      <div class="col-md-9 col-md-offset-3" style="margin-top: 15px !important; margin-bottom: 10px;">
                                       <input type="submit" name="submit" value="Backup" class="btn btn-effect-ripple btn-primary form_submit_backup">
                                          <button type="button" class="btn btn-danger" data-dismiss="modal" style="margin-left: 5px;">Close</button>           
                                      </div>
                                  </div>
                              </form>
                        </div>
                     </div>
                  </div>
                      </div>
                      <div class="modal-footer">
                         <!--    <button type="button" class="btn btn-success save_tech">Save</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> -->
                      </div>
                  </div>
                </div>
            </div>




            <div class="modal fade" id="import_show" role="dialog">
                <div class="modal-dialog" style="width:650px;">
                  <div class="modal-content">
                     <div class="modal-header">
                       <!--  <h4 class="modal-title">Cash Event</h4> -->
                         <button type="button" class="close" data-dismiss="modal">&times;</button>
                         <h4 class="modal-title"><b>Import Data</b></h4>
                     </div>
                      <div class="modal-body">

                        <div class="row">
                            <div class="col-md-12">
                             <!-- Horizontal Form Block -->
                                <div class="">
                                <form name="import_form" id="import_form" method="post" action="<?php echo Yii::app()->createUrl('customer/database_import');?>" enctype='multipart/form-data' >
                            
                                        <div class="form-group">
                                      <label class="col-md-4 control-label" style="margin-right: -70px;">Select File ::</label>
                                      <input type="hidden" name="hidden_id" value="3">
                                      <div class="col-md-7">

                                        <input type="file" name="import_file" id="import_file"  class="form-control import_file" value=""/>
                                      </div>
                                    </div>

                                    <div class="form-group form-actions" >
                                        <div class="col-md-9 col-md-offset-3" style="margin-top: 20px !important;">
                                          <input type="submit" name="submit_import" value="Import Data" class="btn btn-effect-ripple btn-primary form_submit_import">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal" style="margin-left: 5px;">Close</button>           
                                        </div>
                                    </div>
                                  </form>
                              </div>
                          </div>
                        </div>


                      </div>
                      <div class="modal-footer">
                         <!--    <button type="button" class="btn btn-success save_tech">Save</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button> -->
                      </div>
                  </div>
                </div>
            </div>



<script type="text/javascript">

  $('body').on('click','.tech_popup',function(){
         var data_id = $(this).attr('data-id');
           $('#empModal').modal('show');
           /*$.ajax({
             url:'<?php // echo Yii::app()->createUrl("customer/clear_popup");?>',
             method:"POST",  
             data:{data_id:data_id}, 
            success: function(response){ 
              $('.modal-body').html(response);
              $('#empModal').modal('show'); 
            }
          });*/
        });


   $('body').on('click','.tech_popup_backup',function(){
         var data_id = $(this).attr('data-id');
         $('#empModal_new').modal('show'); 
         
         /*  $.ajax({
             url:'<?php // echo Yii::app()->createUrl("customer/clear_popup_with_backup");?>',
             method:"POST",  
             data:{data_id:data_id}, 
            success: function(response){ 
              $('.modal-body-new').html(response);
              $('#empModal_new').modal('show'); 
            }
          });*/
        });



       $('body').on('click','.import_data',function(){
         var data_id = $(this).attr('data-id');
          $('#import_show').modal('show');
          /* $.ajax({
             url:'<?php // echo Yii::app()->createUrl("customer/import_popup");?>',
             method:"POST",  
             data:{data_id:data_id}, 
            success: function(response){ 
              
              $('.modal-body').html(response);
              
              $('#import_show').modal('show'); 
            }
          });*/
        });




     $('body').on('click','.form_submit',function(e)
     {
        var user_password = $('#user_password').val();
       var passwordValidation = 0;

       if($.trim(user_password).length > 0)
       {
           //$('#passwordValidation').removeClass('not-valid');
           $('#passwordValidation').removeClass('animation-slideUp');
           $('#passwordValidation').html("");
           passwordValidation = 0;
       }       
       else
       {
         //$('#nameValidation').addClass('not-valid');
          $('#passwordValidation').addClass('animation-slideUp');
          $('#passwordValidation').html("Password is required"); 
           passwordValidation = 1; 
       }

       if(passwordValidation == 0)  
       {
           return true;
       }
       else
       {
           e.preventDefault();         
           return false;
       }

     });





      $('body').on('click','.form_submit_backup',function(e)
     {
        var user_password = $('#user_password_new').val();
       var passwordValidation = 0;
      // alert(user_password);

       if($.trim(user_password).length > 0)
       {
           //$('#passwordValidation').removeClass('not-valid');
           $('#passwordValidation_new').removeClass('animation-slideUp');
           $('#passwordValidation_new').html("");
           passwordValidation = 0;
       }       
       else
       {
         //$('#nameValidation').addClass('not-valid');
          $('#passwordValidation_new').addClass('animation-slideUp');
          $('#passwordValidation_new').html("Password is required"); 
           passwordValidation = 1; 
       }

       if(passwordValidation == 0)  
       {
           return true;
       }
       else
       {
           e.preventDefault();         
           return false;
       }

     });





    $('body').on('click','.form_submit_import',function()
     {
      var erorr = 0;
      $('.help-block1').remove();
       // var value = $('.import_file')[0].files[0].name; 
      var value = $('.import_file').val();
        
      // alert(value);
      regex = new RegExp("(.*?)\.(sql)$");
      
      if(value)
      {
          if(!(regex.test(value)))
          {
              erorr++;
              $("#import_file").after('<div class="help-block animation-slideUp form-error help-block1">FIle only allows file types of .sql extention</div>');
          }
      }
      else
      {
            erorr++;
              $(".import_file").after('<div class="help-block animation-slideUp form-error help-block1">File is required</div>');
      }

      if (erorr == 0)
      {
        // return true;
      }else {
          return false;
      }
     });
      
     
</script>

