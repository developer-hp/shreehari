<?php $drcrOptions = IssueEntry::getDrcrOptions(); ?>
<?php $subitems = SubitemType::getList(); ?>

<?php
$accountType = '';
if (!$model->isNewRecord && $model->customer_id) {
	$account = Customer::model()->findByPk($model->customer_id);
	$accountType = $account ? $account->type : '';
}

$voucherDisplay = trim((string) $model->voucher_number);
if ($voucherDisplay === '' && $model->isNewRecord) {
	try {
		$voucherDisplay = DocumentNumberService::peekNextSrNo(DocumentNumberService::DOC_DIAMOND_VOUCHER);
	} catch (Exception $e) {
		$voucherDisplay = 'AUTO';
	}
}
?>

<div class="form">
<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'diamond-voucher-form',
	'enableAjaxValidation' => true,
	'htmlOptions' => array('class' => 'form-horizontal'),
	'clientOptions' => array('validateOnSubmit' => true),
	'errorMessageCssClass' => 'help-block animation-slideUp form-error',
)); ?>

	<div class="form-group">
		<label class="col-sm-2 control-label">Date</label>
		<div class="col-sm-4">
			<?php
			$voucherDate = $model->voucher_date;
			if (!empty($voucherDate) && preg_match('/^\d{4}-\d{2}-\d{2}/', $voucherDate)) {
				$voucherDate = date('d-m-Y', strtotime($voucherDate));
			}
			if (!$voucherDate) {
				$voucherDate = date('d-m-Y');
			}
			echo $form->textField($model, 'voucher_date', array(
				'class' => 'form-control input-datepicker',
				'data-date-format' => 'dd-mm-yyyy',
				'value' => $voucherDate,
				'placeholder' => 'dd-mm-yyyy',
				'autocomplete' => 'off',
			)); ?>
			<?php echo $form->error($model, 'voucher_date'); ?>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">Voucher No</label>
		<div class="col-sm-4">
			<input type="text" class="form-control" value="<?php echo CHtml::encode($voucherDisplay); ?>" readonly="readonly" style="background:#f7f7f7;" />
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model, 'drcr', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-4">
			<?php echo $form->dropDownList($model, 'drcr', $drcrOptions, array('class' => 'form-control', 'prompt' => '---Select Entry Type---')); ?>
			<?php echo $form->error($model, 'drcr'); ?>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">Account Type</label>
		<div class="col-sm-4">
			<select name="customer_type" class="form-control diamond-customer-type">
				<option value="">---Select Account Type---</option>
				<option value="1" <?php if ($accountType == 1) echo 'selected'; ?>>Supplier</option>
				<option value="3" <?php if ($accountType == 3) echo 'selected'; ?>>Karigar</option>
			</select>
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model, 'customer_id', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-4">
			<?php
			if (!$model->isNewRecord && $accountType !== '') {
				$customerList = CHtml::listData(Customer::model()->findAll(array('condition' => 'is_deleted = 0 AND type = ' . (int) $accountType, 'order' => 'name')), 'id', 'name');
			} else {
				$customerList = CHtml::listData(Customer::model()->findAll(array('condition' => 'is_deleted = 0 AND type IN (1,3)', 'order' => 'name')), 'id', 'name');
			}
			echo $form->dropDownList($model, 'customer_id', $customerList, array('class' => 'form-control diamond-customer-list select2-diamond-customer', 'prompt' => '----Select Account----'));
			?>
			<?php echo $form->error($model, 'customer_id'); ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model, 'subitem_type_id', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-4">
			<?php echo $form->dropDownList($model, 'subitem_type_id', $subitems, array('class' => 'form-control', 'prompt' => '----Select Subitem----')); ?>
			<?php echo $form->error($model, 'subitem_type_id'); ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model, 'qty', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-2">
			<?php echo $form->textField($model, 'qty', array('class' => 'form-control diamond-qty', 'placeholder' => 'Qty')); ?>
			<?php echo $form->error($model, 'qty'); ?>
		</div>
		<?php echo $form->labelEx($model, 'rate', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-2">
			<?php echo $form->textField($model, 'rate', array('class' => 'form-control diamond-rate', 'placeholder' => 'Rate')); ?>
			<?php echo $form->error($model, 'rate'); ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model, 'amount', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-4">
			<?php echo $form->textField($model, 'amount', array('class' => 'form-control diamond-amount', 'readonly' => 'readonly', 'style' => 'background:#f7f7f7;')); ?>
			<p class="help-block">Amount is automatically calculated as Qty x Rate.</p>
			<?php echo $form->error($model, 'amount'); ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model, 'remarks', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-4">
			<?php echo $form->textArea($model, 'remarks', array('class' => 'form-control', 'rows' => 3)); ?>
			<?php echo $form->error($model, 'remarks'); ?>
		</div>
	</div>

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-primary')); ?>
			<?php echo CHtml::submitButton('Save & Print', array('class' => 'btn btn-info', 'name' => 'save_print')); ?>
			<?php echo CHtml::link('Cancel', array('index'), array('class' => 'btn btn-default')); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>
</div>

<script type="text/javascript">
$(function() {
	var $customerSelect = $('.select2-diamond-customer');

	function initSelect2() {
		if ($customerSelect.data('select2')) {
			$customerSelect.select2('destroy');
		}
		$customerSelect.select2({ placeholder: '----Select Account----', allowClear: true, width: '100%' });
	}

	function parseNum(val) {
		var n = parseFloat(String(val).replace(/,/g, ''));
		return isNaN(n) ? 0 : n;
	}

	function updateAmount() {
		var qty = parseNum($('.diamond-qty').val());
		var rate = parseNum($('.diamond-rate').val());
		$('.diamond-amount').val((qty * rate).toFixed(2));
	}

	initSelect2();
	$('.diamond-customer-type').on('change', function() {
		$.ajax({
			url: '<?php echo Yii::app()->createUrl("customer/get_type_customer"); ?>',
			method: 'POST',
			data: { customer_type: $(this).val() },
			success: function(data) {
				$customerSelect.empty().append(data);
				initSelect2();
			}
		});
	});

	$('.diamond-qty, .diamond-rate').on('input change', updateAmount);
	updateAmount();
});
</script>