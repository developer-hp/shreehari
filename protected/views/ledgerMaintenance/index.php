<?php
$this->breadcrumbs=array(
	'Ledger Maintenance',
);

$accountOptions = CHtml::listData(
	LedgerAccount::model()->findAllByAttributes(array('is_deleted'=>0), array('order'=>'type asc, name asc')),
	'id',
	'name'
);
?>

<div class="row">
	<div class="col-md-12">
		<div class="block">
			<div class="block-title">
				<h2>Ledger Maintenance</h2>
			</div>
			<div class="block-content">
				<?php if (!LedgerAccess::isMainUser()): ?>
					<div class="alert alert-warning">Bulk delete is available only for main user.</div>
				<?php endif; ?>

				<div class="panel panel-default">
					<div class="panel-heading"><strong>Bulk Delete (Soft delete)</strong></div>
					<div class="panel-body">
						<form method="post" action="<?php echo $this->createUrl('ledgerMaintenance/bulkDelete'); ?>" class="form-inline">
							<div class="form-group">
								<label>Doc</label>
								<select class="form-control" name="doc_type">
									<option value="SUP">Supplier Txn</option>
									<option value="KAR">Karigar Voucher</option>
									<option value="ISS">Issue Entry</option>
								</select>
							</div>
							<div class="form-group">
								<label>Start</label>
								<input class="form-control" name="start" placeholder="YYYY-MM-DD" required>
							</div>
							<div class="form-group">
								<label>End</label>
								<input class="form-control" name="end" placeholder="YYYY-MM-DD" required>
							</div>
							<div class="form-group">
								<label>Account (optional)</label>
								<?php echo CHtml::dropDownList('account_id','',$accountOptions,array('class'=>'form-control','prompt'=>'-- All --')); ?>
							</div>
							<button type="submit" class="btn btn-danger" <?php echo LedgerAccess::isMainUser() ? '' : 'disabled'; ?>>Bulk Delete</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

