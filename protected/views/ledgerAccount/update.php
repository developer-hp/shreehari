<?php
/* @var $this LedgerAccountController */
/* @var $model LedgerAccount */

$this->breadcrumbs=array(
	'Ledger Accounts'=>array('admin'),
	$model->name => array('view','id'=>$model->id),
	'Update',
);
?>

<div class="row">
	<div class="col-md-12">
		<div class="block">
			<div class="block-title">
				<h2>Ledger Account - Update</h2>
			</div>
			<div class="block-content">
				<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
			</div>
		</div>
	</div>
</div>

