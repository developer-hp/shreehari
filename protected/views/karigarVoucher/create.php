<?php
/* @var $this KarigarVoucherController */
/* @var $model KarigarVoucher */

$this->breadcrumbs=array(
	'Karigar Voucher'=>array('admin'),
	'Create',
);
?>

<div class="row">
	<div class="col-md-12">
		<div class="block">
			<div class="block-title">
				<h2>Karigar Jama Voucher - Create</h2>
			</div>
			<div class="block-content">
				<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
			</div>
		</div>
	</div>
</div>

