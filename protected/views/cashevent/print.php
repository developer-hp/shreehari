<?php $title="Cash";?>
<?php 
$item_count = 0;
	$update_name = 0;
	for ($i=0; $i <10 ; $i++) { 
		$type_array[$i] = 0;
		$note_array[$i] = "";
	}
	$i = 1;
	$isog = 0;
	$total1 = 0;
	foreach ($cash_log_type as $key => $value_item)
	{
		if($value_item->amount)
		{
			if(!isset($type_array[$value_item->type]))
				$type_array[$value_item->type] = 0;
			$type_array[$value_item->type] += abs($value_item->amount);
		}

		if($value_item->description)
		{
			$note_array[$value_item->type] = $value_item->description;
		}


		if($value_item->type == 2)
			$isog = 1;
		
		if($value_item->type == 6)
		{
			$item_count += 1;
			
		}
	}
?>
<table>
	<tbody>
		<tr>
		<th>Customer Name</th>
		<td><?php 
				if(isset($model->getcust->name))
					echo $model->getcust->name;
		?></td>
		<th style="text-align: right;">Date</th>
		<td style="text-align: right;"><?php 
			echo date('d-m-Y',strtotime($model->created_date));
		?></td>
		</tr>
		<tr>
		<th>Ref Name</th>
		<td><?php 
			echo $model->narration;
		?></td>
		<th style="text-align: right;">Bill No</th>
		<td style="text-align: right;"><?php 
			echo $model->referral_code;
		?></td>
		</tr>
	</tbody>
</table>
<br>
<?php if($item_count): ?>
<div>&nbsp;</div>
<table border="1" cellpadding="6">
<thead>		
	<tr>
		<th style="width: 5%;">#</th>
		<th class="text-center" style="width: 48%;">Item</th>
		<th class="text-center" style="width: 12%;">Gross Wt</th>
		<th class="text-center" style="width: 10%;">Net Wt</th>
		<th class="text-center" style="width: 25%;">Amount</th>
	</tr>
</thead>
<tbody>
<?php
	$item_count = 0;
	$update_name = 0;
	for ($i=0; $i <10 ; $i++) { 
		$type_array[$i] = 0;
	}
	$i = 1;
	$isog = 0;
	$total1 = 0;
	foreach ($cash_log_type as $key => $value_item)
	{
		$subtotal = 0;
		if($value_item->amount)
		{
			if(!isset($type_array[$value_item->type]))
				$type_array[$value_item->type] = 0;
			$type_array[$value_item->type] += abs($value_item->amount);
		}
		if($value_item->type == 2)
			$isog = 1;
		if($value_item->type == 6)
		{
			$item_count += 1;
			$total1 += abs($value_item->amount);
			$subtotal += abs($value_item->amount);

		?>
		<tr>
			<td style="width: 5%;"><?php echo $i; $i+=1;?></td>
			<td style="width: 48%;"><?php echo $value_item->note;?></td>
			<td style="width: 12%;" class="text-right"><?php echo $value_item->gross_weight;?></td>
			<td style="width: 10%;" class="text-right"><?php echo $value_item->weight;?></td>
			<td style="width: 25%;"class="text-right"><?php echo abs($value_item->amount);?></td>
		</tr>
		<?php
        	// echo $value_item->id;
        	$sub_item=Cashlogs::model()->findAllByAttributes(array('item_id'=>$value_item->id));
        	// print_r($sub_item); die;
        	foreach ($sub_item as $key => $value_sub) 
        	{
        		// echo $value_sub->weight;
        		if(!empty($value_sub->id))
        		{
        			$item_count += 1;
					$total1 += abs($value_sub->amount);

					$subtotal += abs($value_sub->amount);	
        ?>
        	<tr>
        	<td></td>
			<td class="font10"><?php echo $value_sub->note;?></td>
			<td class="text-right font10"></td>
			<td class="text-right font10"><?php echo $value_sub->weight;?></td>
			<td class="text-right font10"><?php echo abs($value_sub->amount);?></td>
			</tr>
        <?php
				}
    		}			                		
		?>
		<tr>
        	<td></td>
			<td colspan="3" class="text-right text-bold">SubTotal</td>
			<td class="text-right"><?php echo abs($subtotal);?></td>
		</tr>


<?php } } ?>
<?php for($itemcount=0;$itemcount<=10-$item_count;$itemcount++):?>
<tr>
	<td style="width: 5%;"></td>
	<td style="width: 48%;"></td>
	<td style="width: 12%;" class="text-right"></td>
	<td style="width: 10%;" class="text-right"></td>
	<td style="width: 25%;"class="text-right"></td>
</tr>
<?php endfor; ?>
<tr>
	<th class="text-right" colspan="4">Total</th>
	<th class="text-right"><?php echo $total1;?></th>
</tr>
</tbody>
</table>
<?php else: ?>
<p>RECEIVED BY THANKSBILL</p>
<?php endif; ?>
<div>&nbsp;</div>
<?php
	$item_count = 0;
	$update_name = 0;
	$total2 = 0;
	$i = 1;
	foreach ($cash_log_type as $key => $value_item)
	{
		if($value_item->type == 2)
		{
			$item_count = 1;
			$total2 += abs($value_item->amount)
		?>
<?php } } ?>
<div>&nbsp;</div>
<h4>Receipt Details:</h4>
<table border="1" cellpadding="3px">
	<tbody>
		<tr>
			<th>Cash</th>
			<td><?php echo @$type_array[1]; ?></td>
			<td><?php echo @$note_array[1]; ?></td>
			<th class="text-right">Total Amount</th>
			<td class="text-right"><?php echo $total1?></td>
		</tr>
		<?php 
		$discount = $type_array[5];
		?>
		
		<tr>
			<th>Bank</th>
			<td><?php echo @$type_array[3]; ?></td>
			<td><?php echo @$note_array[3]; ?></td>
			<th class="text-right">Receipt Total</th>
			<td class="text-right"><?php echo $received = $type_array[1]+$type_array[3]+$type_array[4]+$total2+$discount;?></td>
		</tr>
		<tr>
			<th>Card</th>
			<td><?php echo @$type_array[4]; ?></td>
			<td><?php echo @$note_array[4]; ?></td>
			<th class="text-right">Final Total</th>
			<td class="text-right"><?php echo $total1-$received;?></td>
		</tr>
		<tr>
			<th>OG Total</th>
			<td><?php echo $og = $total2?></td>
			<th colspan="2" class="text-right">Current Outstanding</th>
			<td class="text-right"><?php $outArray = $model->amountArray();

			 echo $outArray['final_total']; ?></td>
		</tr>
		<tr>
			<th>Discount</th>
			<td><?php echo $discount = $type_array[5]?></td>
			<td><?php echo @$note_array[5]; ?></td>
			<td colspan="2"><?php echo getIndianCurrency(abs($total1-$received));?></td>
		</tr>
		
	</tbody>
</table>
<?php if($isog):?>
<div></div>
<h4>OLD GOLD:</h4>
<table border="1" cellpadding="6" width="50%">
<thead>		
	<tr>
		<th>#</th>
		<th class="text-center">Item</th>
		<th class="text-center">G. Wt</th>
		<th class="text-center">Nt Wt</th>
		<th class="text-center">Amount</th>
	</tr>
</thead>
<tbody>
<?php
	$item_count = 0;
	$update_name = 0;
	$total2 = 0;
	$i = 1;
	foreach ($cash_log_type as $key => $value_item)
	{
		if($value_item->type == 2)
		{
			$item_count = 1;
			$total2 += abs($value_item->amount)
		?>
		<tr>
			<td><?php echo $i; $i+=1;?></td>
			<td><?php echo $value_item->description;?></td>
			<td class="text-right"><?php echo $value_item->gross_weight;?></td>
			<td class="text-right"><?php echo $value_item->weight;?></td>
			<td class="text-right"><?php echo abs($value_item->amount);?></td>
		</tr>
		<?php
        	// echo $value_item->id;
        	$sub_item=Cashlogs::model()->findAllByAttributes(array('item_id'=>$value_item->id));
        	// print_r($sub_item); die;
        	foreach ($sub_item as $key => $value_sub) 
        	{
        		// echo $value_sub->weight;
        		if(!empty($value_sub->id))
        		{
        ?>
        	<tr>
        	<td></td>
			<td><?php echo $value_sub->note;?></td>
			<td class="text-right"></td>
			<td class="text-right"><?php echo $value_sub->weight;?></td>
			<td class="text-right"><?php echo abs($value_sub->amount);?></td>
			</tr>
        <?php
				}
    		}			                		
		?>
<?php } } ?>
</tbody>
<tr>
	<th class="text-right" colspan="4">Total</th>
	<th class="text-right"><?php echo $total2;?></th>
</tr>
</table>
<?php endif; ?>