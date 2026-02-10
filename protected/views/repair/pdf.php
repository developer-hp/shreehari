<?php 
$font_color = '#54303E';
?>
<div class="repair" style="float: left;width: 100%; border: 2px solid #000;padding-bottom:5px;padding: 10px;">
<div style="float: left;width: 20%; margin-top: 10px;">
	<p class="text-left font15 text-bold">Bharat Bhai<br>98250 37143</p>
</div>
<div style="float: right;width: 20%;">
<p class="text-right font15 text-bold">Anurag Bhai<br>98250 58175</p>
</div>
<div style="float:left;width: 60%; margin-top: -20px;">
<h1 style="color: #C4BC62;" class="text-center">BHARAT <b style="font-weight:bold;">JEWELS</b></h1>
<p class="text-center font20 text-bold" style="padding:5px;">
<span  style="background: #C4BC62;color:<?php echo $font_color;?>;">REPAIRING/APPROVAL VOUCHER</span>
</p>
</div>





<?php 
$name = $mobile = $address = "";
if(isset($m1->rel_customer->name)){
	$name = $m1->rel_customer->name;
	$address = $m1->rel_customer->address;
}
?>

<div style="float: left;width: 65%; padding: 10px;">
	<h2 class="font15" style="font-weight:bold;padding: 0;margin: 0;color:<?php echo $font_color;?>;"><b>M/S.: </b> <?php echo $name;?></h2>
	<h2 class="font15" style="font-weight:bold;padding: 0;margin: 0;color:<?php echo $font_color;?>;"><b>Address: </b> <?php echo $address;?></h2>
	<h2 class="font15" style="font-weight:bold;padding: 0;margin: 0;color:<?php echo $font_color;?>;"><b>Mobile: </b> <?php echo $m1->mobile;?></h2>
</div>
<div style="float:right;border: 2px solid <?php echo $font_color;?>;width: 30%;padding: 5px;">
	<h2 class="font20" style="font-weight:bold;padding: 0;margin: 0;color:<?php echo $font_color;?>;"><b>Ref. No.: </b> <?php echo $m1->ref_no;?></h2>
	<h2 class="font15" style="font-weight:bold;padding: 0;margin: 0;color:<?php echo $font_color;?>;"><b>Date: </b><?php echo $m1->date;?></h2>
	<h2 class="font15" style="font-weight:bold;padding: 0;margin: 0;color:<?php echo $font_color;?>;"><b>Delivery Date: </b> <?php echo $m1->delivery_date;?></h2>
</div>

<table class="pdf-table repairing-form" width="100%" style="margin-top: 20px; text-align: center;">
	<thead>
		<tr>
			<th width="10%">No.</th>
			<th width="60%">DESCRIPTION</th>
			<th width="15%">WEIGHT</th>
			<th width="15%">PCS</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($m2 as $k=>$list): ?>
		<tr>
			<td><?php echo $k+1?></td>
			<td class="text-left"><?php 
			echo $list->description;?></td>
			<td><?php echo $list->nw?></td>
			<td><?php echo $list->pcs?></td>
		</tr>
		<?php endforeach;?>
		
		<?php for ($i=0; $i < 13-count($m2); $i++) { ?> 
			<tr>
				<td>&nbsp;</td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		<?php }?>
		<tr>
			<td class="text-left" colspan="4"><b>Remarks : </b><?php echo $m1->remarks?></td>
		</tr>
	</tbody>
</table>

<?php
		if($m1->extra_charge):
		?>
<div style="float:right;border: 2px solid #000;width: 21%; padding: 10px;margin: 20px;height: 30px;">
	<h2 class="text-center font17" style="font-weight:bold;padding: 0;margin: 0;color: <?php echo $font_color;?>;"><b>Approx Charge</b></h2>
	<p class="text-center font17" style="color: <?php echo $font_color;?>;"><?php echo $m1->extra_charge;?></p>
</div>
<?php endif;?>
<div style="float:right;border: 2px solid #000;width: 21%; padding: 10px;height: 30px;">
	<p class="text-center font17" style="color: <?php echo $font_color;?>;">&nbsp;</p>
	<h2 class="text-center font17" style="font-weight:bold;padding: 0;margin: 0;color: <?php echo $font_color;?>;"><b>Customer's Sign</b></h2>
</div>

<p style="font-weight:bold;padding: 0;margin: 0; padding-left:5px;" class="font12"><b>Note:</b><br>Once order is placed with us cannot be cancelled.<br>
Rate will be confirmed only when advanced is Received.</p>
</div>



<div class="repair" style="float: left;width: 100%; border: 2px solid #000;padding-bottom:5px;padding: 10px;page-break-before: always;">
<span class="font17 text-right">Office Copy</span>
<div style="float: left;width: 20%; margin-top: 10px;">
	<p class="text-left font15 text-bold">Bharat Bhai<br>98250 37143</p>
</div>
<div style="float: right;width: 20%;padding-top:-5px ;">
<p class="text-right font15 text-bold">Anurag Bhai<br>98250 58175</p>
</div>
<div style="float:left;width: 60%;margin-top: -45px;">
<h1 style="color: #C4BC62;" class="text-center">BHARAT <b style="font-weight:bold;">JEWELS</b></h1>
<p class="text-center font20 text-bold" style="padding:5px;">
<span  style="background: #C4BC62;color:<?php echo $font_color;?>;">REPAIRING/APPROVAL VOUCHER</span>
</p>
</div>


<?php 
$name = $mobile = $address = "";
if(isset($m1->rel_customer->name)){
	$name = $m1->rel_customer->name;
	$address = $m1->rel_customer->address;
}
?>

<div style="float: left;width: 65%; padding: 10px;">
	<h2 class="font15" style="font-weight:bold;padding: 0;margin: 0;color:<?php echo $font_color;?>;"><b>M/S.: </b> <?php echo $name;?></h2>
	<h2 class="font15" style="font-weight:bold;padding: 0;margin: 0;color:<?php echo $font_color;?>;"><b>Address: </b> <?php echo $address;?></h2>
	<h2 class="font15" style="font-weight:bold;padding: 0;margin: 0;color:<?php echo $font_color;?>;"><b>Mobile: </b> <?php echo $m1->mobile;?></h2>
</div>
<div style="float:right;border: 2px solid <?php echo $font_color;?>;width: 30%;padding: 5px;">
	<h2 class="font20" style="font-weight:bold;padding: 0;margin: 0;color:<?php echo $font_color;?>;"><b>Ref. No.: </b> <?php echo $m1->ref_no;?></h2>
	<h2 class="font15" style="font-weight:bold;padding: 0;margin: 0;color:<?php echo $font_color;?>;"><b>Date: </b><?php echo $m1->date;?></h2>
	<h2 class="font15" style="font-weight:bold;padding: 0;margin: 0;color:<?php echo $font_color;?>;"><b>Delivery Date: </b> <?php echo $m1->delivery_date;?></h2>
</div>

<table class="pdf-table repairing-form" width="100%" style="margin-top: 20px; text-align: center;">
	<thead>
		<tr>
			<th width="10%">No.</th>
			<th width="60%">DESCRIPTION</th>
			<th width="15%">WEIGHT</th>
			<th width="15%">PCS</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($m2 as $k=>$list): ?>
		<tr>
			<td><?php echo $k+1?></td>
			<td class="text-left"><?php 
			echo $list->description;?></td>
			<td><?php echo $list->nw?></td>
			<td><?php echo $list->pcs?></td>
		</tr>
		<?php endforeach;?>
		
		<?php for ($i=0; $i < 13-count($m2); $i++) { ?> 
			<tr>
				<td>&nbsp;</td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		<?php }?>
		<tr>
			<td class="text-left" colspan="4"><b>Remarks : </b><?php echo $m1->remarks?></td>
		</tr>
	</tbody>
</table>

<?php
		if($m1->extra_charge):
		?>
<div style="float:right;border: 2px solid #000;width: 21%; padding: 10px;margin: 20px;height: 30px;">
	<h2 class="text-center font17" style="font-weight:bold;padding: 0;margin: 0;color: <?php echo $font_color;?>;"><b>Approx Charge</b></h2>
	<p class="text-center font17" style="color: <?php echo $font_color;?>;"><?php echo $m1->extra_charge;?></p>
</div>
<?php endif;?>
<div style="float:right;border: 2px solid #000;width: 21%; padding: 10px;height: 30px;">
	<p class="text-center font17" style="color: <?php echo $font_color;?>;">&nbsp;</p>
	<h2 class="text-center font17" style="font-weight:bold;padding: 0;margin: 0;color: <?php echo $font_color;?>;"><b>Customer's Sign</b></h2>
</div>

<p style="font-weight:bold;padding: 0;margin: 0; padding-left:5px;" class="font12"><b>Note:</b><br>Once order is placed with us cannot be cancelled.<br>
Rate will be confirmed only when advanced is Received.</p>
</div>

