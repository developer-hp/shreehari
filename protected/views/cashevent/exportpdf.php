<?php
    // print_r($model);
$total_weight = 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
    <!-- <div style="border: 1px solid; margin-left: 30px; width: 620px;">
        <div style="background-color: black">
            <p style="height: 30px; font-size: 25px; color:white;">Invoice</p>
        </div>
    </div> -->

    <!-- <table style="border: 1px solid; margin-left: 30px; width: 620px;">
        <thead>
            <tr colspan="3" style="background-color: black">
                <th style="height: 30px; font-size: 25px; color:white;">Invoice</th>
            </tr>
        </thead> 
         <tr>
            <td>1</td>
            <td>John Carter</td>
            <td>johncarter@mail.com</td>
        </tr>   
        
        
    </table>
 -->

    <table border="0" cellpadding="0" cellspacing="0" style="border-top: 1px solid;border-left: 1px solid;border-right: 1px solid; margin-left: 30px; width: 700px;">
        <tr colspan="3" style="background-color: rgb(82, 86, 89)">
            <th colspan="2" style="height: 35px; font-size: 25px; color:white; padding: 5px;">Invoice</th>
        </tr>
        <tr>
            <td style="width: 200px; padding: 5px;"><b>Bill NO ::</b></td>
            <td style="padding: 5px;"><?php echo $model->referral_code;?></td>
        </tr>
        <tr>
            <td style="padding: 5px;"><b>Customer Name ::</b></td>
            <td style="padding: 5px;"> <?php
                    $cust_name = Customer::model()->findByPK($model->customer_id);
                    echo $cust_name->name;
                ?> 
            </td>
        </tr>
        <tr>
           <td style="padding: 5px;"><b>Date ::</b></td>
            <td style="padding: 5px;">
                <?php
                    $convert_date =  $model->created_date;
                    echo $new_date = date('d-m-Y',strtotime($convert_date));
                ?>  
            </td>
        </tr>
        <tr>
            <td colspan="2"><br></td>
        </tr>
         <tr rowspan="4" style="background-color: rgb(82, 86, 89);">
            <th colspan="2" style="height: 30px; font-size: 25px; color:white;  padding: 5px;">Detail</th>
        </tr>       
         <tr>
            <td colspan="2">
                <table cellpadding="0" cellspacing="0" style="border: 0px solid; width: 720px;">
                    <tr>
                        <td style="padding-left:4px; border-top: 1px solid;border-bottom: 1px solid; border-right: 1px solid; text-align: left; font-weight: bold;  width: 200px; height: 35px;">
                            Item Name
                        </td>
                        <td style="padding: 0px; border-top: 1px solid;border-bottom: 1px solid; border-right: 1px solid; text-align: center; font-weight: bold; width: 100px;">
                            Cash Type
                        </td>
                        <td style="padding-right: 3px; border-top: 1px solid;border-bottom: 1px solid; border-right: 1px solid; text-align: right; font-weight: bold; width: 80px;">
                            Amount
                          
                        </td>
                        <td style="padding-right: 3px; border-top: 1px solid;border-bottom: 1px solid; border-right: 1px solid; text-align: right; font-weight: bold; width: 80px;">
                             Metal
                            
                        </td>
                        <td style="padding-right: 3px; border-top: 1px solid;border-bottom: 1px solid; border-right: 1px solid; text-align: right; font-weight: bold; width: 80px;">
                             Gross weight
                            
                        </td>
                        <td style="padding: 0px; border-top: 1px solid;border-bottom: 1px solid; text-align: center; font-weight: bold; width: 150px;" >
                            Transaction Date
                        </td>
                    </tr>
                
                        <?php
                            $total = 0;
                            foreach ($cash_lods as $key => $value) 
                            {
                                ?>
                                <tr>
                                    <td style="padding-left:5px; border-bottom: 1px solid; border-right: 1px solid; text-align: left; ">
                                        <?php
                                            echo $value->note;
                                        ?>
                                    </td>
                                    <td style="padding: 3px;  border-bottom: 1px solid; border-right: 1px solid; text-align: center; ">
                                        <?php
                                            if($value->type == 1)
                                            {
                                                echo "Cash";
                                            }
                                            if($value->type == 2)
                                            {
                                                echo "Gold";
                                            }
                                            if($value->type == 3)
                                            {
                                                echo "Bank";
                                            }
                                            if($value->type == 4)
                                            {
                                                echo "Card";
                                            }
                                            if($value->type == 5)
                                            {
                                                echo "Discount";
                                            }
                                            if($value->type == 7)
                                            {
                                                echo "Diamond";
                                            }
                                            // echo $value->note;
                                        ?>
                                    </td>
                                    <td style="padding: 3px;  border-bottom: 1px solid; border-right: 1px solid; text-align: right; ">
                                        <?php
                                            if($value->amount != 0)
                                            {
                                                echo $value->amount;
                                             $total = $total+$value->amount;
                                            }

                                        ?>
                                    </td>
                                    <td style="padding: 3px; border-bottom: 1px solid; border-right: 1px solid; text-align: right; ">
                                        <?php
                                            if($value->weight != "")
                                            {
                                                if($value->amount == 0 && $value->type == 2)
                                                {
                                                    echo number_format((float)$value->weight, 3, '.', '');
                                                    $total_weight = $total_weight+$value->weight;
                                                }
                                                if($value->type != 2)
                                                {
                                                    echo number_format((float)$value->weight, 3, '.', '');
                                                    $total_weight = $total_weight+$value->weight;   
                                                }
                                            }
                                            // echo $value->weight;
                                        ?>  
                                    </td>

                                    <td style="padding: 3px; border-bottom: 1px solid; border-right: 1px solid; text-align: right; ">
                                        <?php
                                            if($value->gross_weight != "")
                                            {
                                                
                                            echo $value->gross_weight;
                                            }
                                        ?>  
                                    </td>

                                    <td style="padding: 3px; border-bottom: 1px solid; text-align: center; ">
                                        <?php
                                            $trasectioin_date =  $value->date;
                                            echo $new_trasection_date = date('d-m-Y',strtotime($trasectioin_date));
                                        ?>
                                    </td>   
                                </tr>
                                <?php
                            }

                        ?>
                    </tr>
                    <tr>  
                        <td  colspan="0" style=" padding: 8px;border-bottom: 1px solid; border-right: 0px solid; text-align: right; ">
                     
                        </td> 
                        <td  colspan="0" style=" padding: 8px;border-bottom: 1px solid; border-right: 0px solid; text-align: right; ">
                      
                        </td> 
                        <td  colspan="0" style=" padding: 5px;border-bottom: 1px solid; border-right: 1px solid; text-align: right; ">
                           <?php  
                                    if($total < 0)
                                    {
                                        echo "<b>Outstanding :: </b>";
                                    }
                                    if($total == 0)
                                    {
                                        echo "<b>Outstanding:: </b>";
                                    }
                                    if($total > 0)
                                    {
                                        echo "<b>Advance :: </b>";
                                    }
                                  echo $total;
                            ?>
                        </td> 
                    <td  colspan="0" style=" padding: 5px; border-bottom: 1px solid; border-right: 1px solid; text-align: right;">
                       <!--  Weight Total::  -->
                       <?php  
                         $new_total = number_format((float)$total_weight, 3, '.', '');
                         echo '<b>Metal Total :: </b>'.$new_total; ?>
                     </td>      
                    
                           <td colspan="0" style="border-bottom: 1px solid; padding: 3px; text-align: right;">
                            
                        </td>
                         </td>      
                    
                           <td colspan="0" style="border-bottom: 1px solid; padding: 3px; text-align: right;">
                            
                        </td>   
                        <!-- <td>AA</td>
                        <td>AA</td> -->
                    </tr>

                </table>
            </td>          
        </tr>

    </table>

</body>
</html>