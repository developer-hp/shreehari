<?php
/* @var $this KarigarVoucherController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Karigar Voucher'=>array('admin'),
	'Ledger Report',
);
?>

<div class="row">
	<div class="col-md-12">
		<div class="block">
			<div class="block-title">
				<h2>Karigar Ledger Report</h2>
			</div>
			<div class="block-content">
				<form method="get" class="form-inline" style="margin-bottom:10px;">
					<input type="hidden" name="r" value="karigarVoucher/ledger">
					<div class="form-group">
						<label>Karigar</label>
						<?php echo CHtml::dropDownList('karigar_account_id', $karigarId, $karigarOptions, array('class'=>'form-control','prompt'=>'-- All --')); ?>
					</div>
					<div class="form-group">
						<label>Start</label>
						<input class="form-control" name="start" value="<?php echo CHtml::encode($start); ?>" placeholder="YYYY-MM-DD">
					</div>
					<div class="form-group">
						<label>End</label>
						<input class="form-control" name="end" value="<?php echo CHtml::encode($end); ?>" placeholder="YYYY-MM-DD">
					</div>
					<button class="btn btn-primary" type="submit">Search</button>
					<?php if (!empty($karigarId)): ?>
						<?php echo CHtml::link('Print A4', array('printLedger','karigar_account_id'=>$karigarId,'start'=>$start,'end'=>$end), array('class'=>'btn btn-default','target'=>'_blank')); ?>
					<?php endif; ?>
					<?php echo CHtml::link('Back', array('admin'), array('class'=>'btn btn-default')); ?>
				</form>

				<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'karigar-ledger-grid',
	'dataProvider'=>$dataProvider,
	'itemsCssClass'=>'table table-bordered table-striped',
	'columns'=>array(
		array('header'=>'Date','value'=>'$data->voucher_date'),
		array('header'=>'Sr No','value'=>'$data->sr_no'),
		array('header'=>'Karigar','value'=>'$data->karigarAccount ? $data->karigarAccount->name : ""'),
		array('header'=>'Fine Wt','value'=>'number_format($data->getTotalFineWt(), 3, ".", "")'),
		array(
			'class'=>'CButtonColumn',
			'template'=>'{view}',
		),
	),
)); ?>
			</div>
		</div>
	</div>
</div>

