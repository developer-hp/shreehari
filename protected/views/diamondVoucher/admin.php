<div class="content-header">
	<div class="row">
		<div class="col-sm-6">
			<div class="header-section">
				<h1>Diamond Voucher</h1>
			</div>
		</div>
		<div class="col-sm-6 hidden-xs">
			<ul class="breadcrumb breadcrumb-top">
				<li><?php echo CHtml::link('Dashboard', array('site/index')); ?></li>
				<li>Diamond Voucher</li>
			</ul>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="block">
			<div class="block-title"><h2>Manage Diamond Voucher</h2></div>
			<?php $isAdminUser = LedgerAccess::isAdmin(); ?>
			<?php if (Yii::app()->user->hasFlash('success')): ?>
				<div class="alert alert-success alert-dismissable"><p><?php echo Yii::app()->user->getFlash('success'); ?></p></div>
			<?php endif; ?>
			<?php if (Yii::app()->user->hasFlash('info')): ?>
				<div class="alert alert-info alert-dismissable"><p><?php echo Yii::app()->user->getFlash('info'); ?></p></div>
			<?php endif; ?>
			<?php echo CHtml::link('Add Diamond Voucher', array('create'), array('class' => 'btn btn-effect-ripple btn-info')); ?>
			<?php if ($isAdminUser): ?>
				<?php echo CHtml::button('Delete Selected Locked', array('id' => 'diamond-delete-selected-locked', 'class' => 'btn btn-effect-ripple btn-danger')); ?>
				<?php echo CHtml::button('Delete All Locked', array('id' => 'diamond-delete-all-locked', 'class' => 'btn btn-effect-ripple btn-danger')); ?>
			<?php endif; ?>

			<?php $this->widget('zii.widgets.grid.CGridView', array(
				'id' => 'diamond-voucher-grid',
				'pager' => array(
					'class' => 'CLinkPager',
					'header' => '',
					'htmlOptions' => array('class' => 'pagination'),
				),
				'dataProvider' => $model->search(),
				'filter' => $model,
				'itemsCssClass' => 'table table-striped table-bordered table-vcenter table-responsive',
				'columns' => array(
					array(
						'class' => 'CCheckBoxColumn',
						'id' => 'selectedIds',
						'selectableRows' => 2,
						'visible' => LedgerAccess::isAdmin(),
						'checkBoxHtmlOptions' => array('class' => 'diamond-lock-select'),
					),
					'voucher_number',
					array('name' => 'voucher_date', 'value' => '!empty($data->voucher_date) ? date("d-m-Y", strtotime($data->voucher_date)) : ""'),
					array('name' => 'account_name', 'value' => 'isset($data->account) ? $data->account->name : ""'),
					array('name' => 'subitem_name', 'value' => 'isset($data->subitemType) ? $data->subitemType->name : ""'),
					array('name' => 'drcr', 'value' => 'isset(IssueEntry::getDrcrOptions()[$data->drcr]) ? IssueEntry::getDrcrOptions()[$data->drcr] : ""'),
					array('name' => 'qty', 'value' => 'number_format((float)$data->qty, 3)', 'htmlOptions' => array('class' => 'text-right')),
					array('name' => 'rate', 'value' => 'number_format((float)$data->rate, 2)', 'htmlOptions' => array('class' => 'text-right')),
					array('name' => 'amount', 'value' => 'number_format((float)$data->amount, 2)', 'htmlOptions' => array('class' => 'text-right')),
					array(
						'name' => 'is_locked',
						'value' => '$data->is_locked == 1 ? "<span class=""label label-warning""><i class=""fa fa-lock""></i> Locked</span>" : ""',
						'type' => 'raw',
						'htmlOptions' => array('style' => 'text-align:center;'),
					),
					array(
						'class' => 'ButtonColumn',
						'htmlOptions' => array('style' => 'width: 240px; text-align: center;'),
						'template' => '{view} {pdf} {print} {update} {delete}',
						'buttons' => array(
							'view' => array('label' => '<i class="fa fa-eye"></i>', 'imageUrl' => false, 'url' => 'Yii::app()->createUrl("diamondVoucher/view", array("id"=>$data->id))', 'options' => array('class' => 'btn btn-sm btn-warning', 'title' => 'View')),
							'pdf' => array('label' => '<i class="fa fa-file-pdf-o"></i>', 'imageUrl' => false, 'url' => 'Yii::app()->createUrl("diamondVoucher/pdf", array("id"=>$data->id))', 'options' => array('class' => 'btn btn-sm btn-primary', 'title' => 'Download PDF', 'target' => '_blank')),
							'print' => array('label' => '<i class="fa fa-print"></i>', 'imageUrl' => false, 'url' => 'Yii::app()->createUrl("diamondVoucher/print", array("id"=>$data->id))', 'options' => array('class' => 'btn btn-sm btn-default', 'title' => 'Print', 'target' => '_blank')),
							'update' => array('label' => '<i class="fa fa-pencil"></i>', 'imageUrl' => false, 'url' => 'Yii::app()->createUrl("diamondVoucher/update", array("id"=>$data->id))', 'options' => array('class' => 'btn btn-sm btn-success'), 'visible' => 'LedgerAccess::canEditVoucher($data, "voucher_date")'),
							'delete' => array('label' => '<i class="fa fa-trash"></i>', 'imageUrl' => false, 'options' => array('class' => 'btn btn-sm btn-danger'), 'visible' => 'LedgerAccess::canDeleteVoucher($data, "voucher_date")'),
						),
					),
				),
			)); ?>
		</div>
	</div>
</div>

<?php if ($isAdminUser): ?>
<script type="text/javascript">
function diamondPostWithIds(actionUrl, ids) {
	var $form = $('<form method="post" style="display:none;"></form>').attr('action', actionUrl);
	for (var i = 0; i < ids.length; i++) {
		$form.append($('<input type="hidden" name="ids[]" />').val(ids[i]));
	}
	$('body').append($form);
	$form.submit();
}

$(function() {
	$('#diamond-delete-selected-locked').on('click', function() {
		var ids = $.fn.yiiGridView.getChecked('diamond-voucher-grid', 'selectedIds');
		if (!ids || ids.length === 0) {
			alert('Please select at least one row.');
			return;
		}
		if (!confirm('Delete selected locked vouchers?')) {
			return;
		}
		diamondPostWithIds('<?php echo Yii::app()->createUrl("diamondVoucher/deleteLockedSelected"); ?>', ids);
	});

	$('#diamond-delete-all-locked').on('click', function() {
		if (!confirm('Delete ALL locked vouchers? This cannot be undone.')) {
			return;
		}
		diamondPostWithIds('<?php echo Yii::app()->createUrl("diamondVoucher/deleteAllLocked"); ?>', []);
	});
});
</script>
<?php endif; ?>