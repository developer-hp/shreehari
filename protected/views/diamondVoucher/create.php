<div class="content-header">
	<div class="row">
		<div class="col-sm-6">
			<div class="header-section">
				<h1>Add Diamond Voucher</h1>
			</div>
		</div>
		<div class="col-sm-6 hidden-xs">
			<ul class="breadcrumb breadcrumb-top">
				<li><?php echo CHtml::link('Diamond Voucher', array('index')); ?></li>
				<li>Create</li>
			</ul>
		</div>
	</div>
</div>
<div class="block">
	<div class="block-title"><h2>New Diamond Voucher</h2></div>
	<?php $this->renderPartial('_form', array('model' => $model)); ?>
</div>