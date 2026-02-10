<table>
	<tbody>
		<tr>
		<th>Customer Name</th>
		<td><?php 
				if(isset($customer->name))
					echo $customer->name;
		?></td>
		<th style="text-align: right;">Date</th>
		<td style="text-align: right;"><?php 
			echo date('d-m-Y');
		?></td>
		</tr>
	</tbody>
</table>
<br>
<br>
<table border="1" cellpadding="6">
<thead>		
	<tr>
		<th class="text-center" style="">BILL NO</th>
		<th class="text-center" style="">CREATED DATE</th>
		<th class="text-center" style="">AMOUNT</th>
		<th class="text-center" style="">METAL</th>
	</tr>
</thead>
<tbody>
	<?php 
		$bill_array = CHtml::listData($cash_event,'id','referral_code');
		

		foreach($cash_event as $list):
		?>
		<tr>
			<td class="text-center"><?php echo $list->referral_code; ?></td>
			<td class="text-center"><?php echo date('d-m-Y',strtotime($list->created_date)); ?></td>
			<td class="text-right"><?php 
					$condition = "1=1";
                    $criteria=new CDbCriteria;
                    $criteria->select =' sum(amount) as amount ';
                    $condition .= ' AND cashevent_id ='.$list->id;
                    $criteria->condition = $condition;
                    $cash_amount=Cashlogs::model()->find($criteria);
                    if($cash_amount->amount)
                    {
                      echo $cash_amount->amount;
                    }

			 ?></td>
			<td class="text-right"><?php 
					$condition = "1=1";
                    $criteria = new CDbCriteria;
                    $criteria->select ='SUM(IF((t.amount = "0" OR t.amount is null OR t.amount = "") and   t.item_id = "0" ,(t.weight),0)) AS weight  ';
                    $condition .= ' AND cashevent_id ='.$list->id;
                    $criteria->condition = $condition;
                    $cash_amount=Cashlogs::model()->find($criteria);
                    if($cash_amount->weight != 0)
                    {
                      echo number_format((float)$cash_amount->weight, 3, '.', '');
                    } ?></td>
		</tr>
	<?php endforeach;?>
</tbody>
<tfoot>
	<tr>
		<th class="text-right" colspan="2">Total</th>
		<td class="text-right"><?php echo $list->amount_total(1);?></td>
		<td class="text-right"><?php echo $list->metal_total(1);?></td>
	</tr>
</tfoot>
</table>


<br>
<br>
<br>
<h3>Details:</h3>
<table border="1" cellpadding="6" class="smallfont">
<thead>		
	<tr>
		<th class="text-center" style="width: 8%;">BILL NO</th>
		<th class="text-center" style="width: 20%;">ITEM NAME</th>
		<th class="text-center" style="width: 8%;">TYPE</th>
		<th class="text-center" style="width: 9%;">AMOUNT</th>
		<th class="text-center" style="width: 9%;">METAL</th>
		<th class="text-center" style="width: 9%;">GROSS</th>
		<th class="text-center" style="width: 11%;">DATE</th>
		<th class="text-center" style="width: 25%;">NOTE</th>
	</tr>
</thead>
<tbody>
	<?php 
		foreach($cash_logs as $list):
		?>
		<tr>
			<td class="text-center" style="width: 8%;"><?php echo $bill_array[$list->cashevent_id]; ?></td>
			<td style="width: 20%;"><?php echo $list->note; ?></td>
			
			<td class="text-center" style="width: 8%;"><?php 
					if($list->type == 1)
						echo "Cash";
					if($list->type == 2)
						echo "Gold";
					if($list->type == 3)
						echo "Bank";
					if($list->type == 4)
						echo "Card";
					if($list->type == 5)
						echo "Discount";
					if($list->type == 7)
						echo "Diamond";
			 ?></td>
			 
			<td class="text-right" style="width: 9%;"><?php 
			if($list->type == 6)
			{
				$condition = "1=1";
                $criteria = new CDbCriteria;
                $criteria->select =' SUM(IF(t.type = "8" ,(t.amount),0)) AS amount ';
                $condition .= ' AND item_id ='.$list->id;
                $criteria->condition = $condition;
                $sub_amount=Cashlogs::model()->find($criteria);
                echo $all_item_amount = $list->amount + $sub_amount->amount;
			}
			else
			{
				if($list->amount != "" && $list->amount != 0)
				{
					echo $list->amount;
				}
			}
			?></td>
			<td class="text-right" style="width: 9%;">
				<?php 
				if($list->amount == 0 && $list->type == 2)
				{

					if($list->weight != 0)
					{
						echo number_format((float)$list->weight, 3, '.', '');
					}
				}

				if($list->type != 2)
				{
					if($list->weight != 0)
					{
						echo number_format((float)$list->weight, 3, '.', '');
					}

				}
				?>
			</td>
			<td class="text-right" style="width: 9%;"><?php echo $list->gross_weight; ?></td>
			<td class="text-center" style="width: 11%;"><?php echo date('d-m-Y',strtotime($list->date)); ?></td>
			<td class="" style="width: 25%;"><?php echo $list->description; ?></td>
		</tr>
	<?php endforeach;?>
</tbody>
</table>


