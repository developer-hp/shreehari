<?php
/* @var $this LedgerAccountController */
/* @var $model LedgerAccount */

$this->breadcrumbs=array(
	'Ledger Accounts'=>array('admin'),
	'Create',
);
?>

<div class="row">
	<div class="col-md-12">
		<div class="block">
			<div class="block-title">
				<h2>Ledger Account - Create</h2>
			</div>
			<div class="block-content">
				<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
			</div>
		</div>
	</div>
</div>

