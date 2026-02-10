<div style="float: left;width: 100%; padding-bottom:5px;margin-top: 5px;">


<div style="float:left;width: 100%;padding-left:10px;">
	<h2 style="font-weight:bold;padding: 0;font-size: 45px;"><?php echo $m1->ref_no;?></h2>
	<h2 class="font18" style="font-weight:bold;padding-top: -30px;margin: 0"><b>M/S. :</b> <?php echo $m1->name;?></h2>
	<?php
	$fnt = "font18";
	if($m1->mobile2)
	$fnt = "font14";
	?>
	<h2 class="<?php echo $fnt;?>" style="font-weight:bold;padding: 0;margin: 0"><b>M No. :</b> <?php echo $m1->mobile;
	if($m1->mobile2)
		echo ",".$m1->mobile2;

	?></h2>
	<h2 class="font15" style="font-weight:bold;padding: 0;margin: 0"><b>Delivery Date :</b> <?php echo $m1->delivery_date;?></h2>
</div>

<table cellspacing="0" cellpadding="0" class="pdf-table order-form" width="100%" style="margin-top: 10px; text-align: center;" cellpadding="0">
	<thead>
		<tr>
			<th>Items</th>
			<th style="width:15%;">Ready</th>
			<th style="width:55%;">Remarks</th>
			
		</tr>
	</thead>
	<tbody>
		<?php 
		$citem = 1;
		$nettotal = 0;
		foreach($m2 as $k=>$list): 
			if($k==11):
				break;
			else:

		?>
		<tr>
			<td class="text-left"><?php 
			if($list->code){
				// $item = Item::model()->findByAttributes(array('code'=>$list->code));
				// // echo "asd";
				// if($item)
				// 	echo $list->code.' ('.$item->purity.")<br>";
				// else
				// 	echo $list->code."<br>";
				echo $list->code;
			}
			else{
				echo "Item ".$citem;
			 	$citem = $citem +1;
			}
			?></td>
			<td></td>
			<td></td>
		</tr>
		<?php endif; ?>
		<?php endforeach;?>
		<?php 
		if(count($m2)<=12) :
		?>
		<tr>
			<td class="text-left" colspan="3"><b>Remarks : </b></td>
		</tr>
		<?php endif; ?>
	</tbody>
</table>
<?php 
if(count($m2)>12) :
?>
<pagebreak />
<table cellspacing="0" cellpadding="0" class="pdf-table order-form" width="100%" style="margin-top: 10px; text-align: center;" cellpadding="0">
	<thead>
		<tr>
			<th>Items</th>
			<th style="width:15%;">Ready</th>
			<th style="width:55%;">Remarks</th>
			
		</tr>
	</thead>
	<tbody>
		<?php 
		foreach($m2 as $k=>$list): 
			if($k<11):
				continue;
			else:

		?>
		<tr>
			<td class="text-left"><?php 
			if($list->code){
				// $item = Item::model()->findByAttributes(array('code'=>$list->code));
				// // echo "asd";
				// if($item)
				// 	echo $list->code.' ('.$item->purity.")<br>";
				// else
				// 	echo $list->code."<br>";
				echo $list->code;
			}
			else{
				echo "Item ".$citem;
			 	$citem = $citem +1;
			}
			?></td>
			<td></td>
			<td></td>
		</tr>
		<?php endif; ?>
		<?php endforeach;?>
		<tr>
			<td class="text-left" colspan="3"><b>Remarks : </b></td>
		</tr>
	</tbody>
</table>

<?php 
endif;
?>
<div style="margin-top:5px;float: left;width: 50%;">
<?php
if($m1->photo)
		        	{
		        		echo CHtml::image(Yii::app()->request->baseUrl.'/'.$m1->photo,'',array('height'=>'100px'));
		        	} ?>

</div>
</div>



