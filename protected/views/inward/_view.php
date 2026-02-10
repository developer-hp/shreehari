<?php
/* @var $this InwardController */
/* @var $data Inward */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('customer_id')); ?>:</b>
	<?php echo CHtml::encode($data->customer_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('bill_no')); ?>:</b>
	<?php echo CHtml::encode($data->bill_no); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('bill_date')); ?>:</b>
	<?php echo CHtml::encode($data->bill_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('gross_wt')); ?>:</b>
	<?php echo CHtml::encode($data->gross_wt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('net_wt')); ?>:</b>
	<?php echo CHtml::encode($data->net_wt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fine_wt')); ?>:</b>
	<?php echo CHtml::encode($data->fine_wt); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('other_wt')); ?>:</b>
	<?php echo CHtml::encode($data->other_wt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('gold_amount')); ?>:</b>
	<?php echo CHtml::encode($data->gold_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('other_amount')); ?>:</b>
	<?php echo CHtml::encode($data->other_amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('note')); ?>:</b>
	<?php echo CHtml::encode($data->note); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_date')); ?>:</b>
	<?php echo CHtml::encode($data->created_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_date')); ?>:</b>
	<?php echo CHtml::encode($data->updated_date); ?>
	<br />

	*/ ?>

</div>