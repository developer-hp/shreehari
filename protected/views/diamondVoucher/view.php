<div class="content-header">
	<div class="row">
		<div class="col-sm-6">
			<div class="header-section">
				<h1>Diamond Voucher <?php echo CHtml::encode($model->voucher_number); ?></h1>
			</div>
		</div>
		<div class="col-sm-6 hidden-xs">
			<ul class="breadcrumb breadcrumb-top">
				<li><?php echo CHtml::link('Dashboard', array('site/index')); ?></li>
				<li><?php echo CHtml::link('Diamond Voucher', array('index')); ?></li>
				<li>View</li>
			</ul>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="block">
			<div class="block-title"><h2>Voucher Details</h2></div>
			<p>
				<?php if (LedgerAccess::canEditVoucher($model, 'voucher_date')): ?>
					<?php echo CHtml::link('<i class="fa fa-pencil"></i> Edit', array('update', 'id' => $model->id), array('class' => 'btn btn-success')); ?>
				<?php endif; ?>
				<?php echo CHtml::link('<i class="fa fa-file-pdf-o"></i> Download PDF', array('pdf', 'id' => $model->id), array('class' => 'btn btn-primary', 'target' => '_blank')); ?>
				<?php echo CHtml::link('<i class="fa fa-print"></i> Print', array('print', 'id' => $model->id), array('class' => 'btn btn-default', 'target' => '_blank')); ?>
				<?php echo CHtml::link('Back to list', array('index'), array('class' => 'btn btn-default')); ?>
			</p>

			<?php
			$drcrOptions = IssueEntry::getDrcrOptions();
			$createdByName = '—';
			if (!empty($model->created_by)) {
				$createdByModel = User::model()->findByPk((int) $model->created_by);
				if ($createdByModel && !empty($createdByModel->name)) {
					$createdByName = $createdByModel->name;
				} else {
					$createdByName = $model->created_by;
				}
			}
			?>

			<?php $this->widget('zii.widgets.CDetailView', array(
				'data' => $model,
				'htmlOptions' => array('class' => 'table table-striped table-bordered table-vcenter'),
				'attributes' => array(
					array('name' => 'voucher_number', 'label' => 'Voucher No'),
					array('name' => 'voucher_date', 'value' => !empty($model->voucher_date) ? date('d-m-Y', strtotime($model->voucher_date)) : '—'),
					array('name' => 'drcr', 'label' => 'Entry Type', 'value' => isset($drcrOptions[$model->drcr]) ? $drcrOptions[$model->drcr] : '—'),
					array('name' => 'customer_id', 'label' => 'Account', 'type' => 'raw', 'value' => isset($model->account) ? CHtml::link(CHtml::encode($model->account->name), array('ledgerReport/report', 'customer_id' => $model->customer_id), array('target' => '_blank')) : '—'),
					array('name' => 'subitem_type_id', 'label' => 'Subitem', 'value' => isset($model->subitemType) ? $model->subitemType->name : '—'),
					array('name' => 'qty', 'value' => number_format((float) $model->qty, 3)),
					array('name' => 'rate', 'value' => number_format((float) $model->rate, 2)),
					array('name' => 'amount', 'value' => number_format((float) $model->amount, 2)),
					array('name' => 'remarks', 'value' => trim((string) $model->remarks) !== '' ? $model->remarks : '—'),
					array('name' => 'created_at', 'label' => 'Created At', 'value' => !empty($model->created_at) ? date('d-m-Y H:i', strtotime($model->created_at)) : '—'),
					array('name' => 'created_by', 'label' => 'Created By', 'value' => $createdByName),
					array('name' => 'is_locked', 'label' => 'Status', 'value' => (int) $model->is_locked === 1 ? 'Locked' : 'Unlocked'),
				),
			)); ?>
		</div>
	</div>
</div>