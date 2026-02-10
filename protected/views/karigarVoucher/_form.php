<?php
/* @var $this KarigarVoucherController */
/* @var $model KarigarVoucher */
/* @var $form CActiveForm */

$karigarOptions = CHtml::listData(
	LedgerAccount::model()->findAllByAttributes(array('type'=>LedgerAccount::TYPE_KARIGAR,'is_deleted'=>0), array('order'=>'name asc')),
	'id',
	'name'
);

$customerOptions = CHtml::listData(
	Customer::model()->findAllByAttributes(array('type'=>2,'is_deleted'=>0), array('order'=>'name asc')),
	'id',
	'name'
);

$existingLines = array();
if (!$model->isNewRecord) {
	$existingLines = KarigarVoucherLine::model()->findAllByAttributes(array('karigar_voucher_id'=>$model->id), array('order'=>'sort_order asc, id asc'));
}
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'karigar-voucher-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'voucher_date', array('class' => 'col-md-3 control-label')); ?>
		<div class="col-md-3">
			<?php echo $form->textField($model,'voucher_date',array('class'=>'form-control','placeholder'=>'YYYY-MM-DD')); ?>
			<?php echo $form->error($model,'voucher_date'); ?>
		</div>
		<?php echo $form->labelEx($model,'karigar_account_id', array('class' => 'col-md-2 control-label')); ?>
		<div class="col-md-4">
			<?php echo $form->dropDownList($model,'karigar_account_id',$karigarOptions,array('class'=>'form-control','prompt'=>'-- Select Karigar --')); ?>
			<?php echo $form->error($model,'karigar_account_id'); ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'sr_no', array('class' => 'col-md-3 control-label')); ?>
		<div class="col-md-3">
			<?php echo $form->textField($model,'sr_no',array('class'=>'form-control','placeholder'=>'Auto')); ?>
			<div class="help-block">Leave empty to auto-generate.</div>
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'remarks', array('class' => 'col-md-3 control-label')); ?>
		<div class="col-md-9">
			<?php echo $form->textArea($model,'remarks',array('class'=>'form-control','rows'=>2)); ?>
			<?php echo $form->error($model,'remarks'); ?>
		</div>
	</div>

	<hr>
	<h4>Lines</h4>

	<table class="table table-bordered" id="lines-table">
		<thead>
			<tr>
				<th style="width:10%;">Order</th>
				<th style="width:14%;">Customer</th>
				<th style="width:18%;">Item</th>
				<th style="width:6%;">Pcs</th>
				<th style="width:9%;">Gross</th>
				<th style="width:9%;">Net</th>
				<th style="width:8%;">Touch %</th>
				<th style="width:9%;">Fine</th>
				<th>Components</th>
				<th style="width:8%;">Action</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$idx = 0;
		if (!empty($existingLines)) {
			foreach ($existingLines as $ln) {
				$comps = KarigarVoucherComponent::model()->findAllByAttributes(array('karigar_voucher_line_id'=>$ln->id), array('order'=>'sort_order asc, id asc'));
				?>
				<tr class="line-row" data-idx="<?php echo (int)$idx; ?>">
					<td><input class="form-control" name="lines[<?php echo (int)$idx; ?>][order_no]" value="<?php echo CHtml::encode($ln->order_no); ?>"></td>
					<td><?php echo CHtml::dropDownList("lines[$idx][customer_account_id]", $ln->customer_account_id, $customerOptions, array('class'=>'form-control','prompt'=>'--')); ?></td>
					<td><input class="form-control" name="lines[<?php echo (int)$idx; ?>][item_name]" value="<?php echo CHtml::encode($ln->item_name); ?>"></td>
					<td><input class="form-control num" name="lines[<?php echo (int)$idx; ?>][psc]" value="<?php echo CHtml::encode($ln->psc); ?>"></td>
					<td><input class="form-control num" name="lines[<?php echo (int)$idx; ?>][gross_wt]" value="<?php echo CHtml::encode($ln->gross_wt); ?>"></td>
					<td><input class="form-control num net-wt" name="lines[<?php echo (int)$idx; ?>][net_wt]" value="<?php echo CHtml::encode($ln->net_wt); ?>"></td>
					<td><input class="form-control num touch-pct" name="lines[<?php echo (int)$idx; ?>][touch_pct]" value="<?php echo CHtml::encode($ln->touch_pct); ?>"></td>
					<td><input class="form-control fine-wt" name="lines[<?php echo (int)$idx; ?>][fine_wt]" value="<?php echo CHtml::encode($ln->fine_wt); ?>" readonly></td>
					<td>
						<table class="table table-condensed comp-table" style="margin-bottom:0;">
							<thead>
								<tr><th>Type</th><th>Name</th><th style="width:12%;">Wt</th><th style="width:14%;">Amt</th><th style="width:8%;">+</th></tr>
							</thead>
							<tbody>
							<?php
							$cj = 0;
							if (!empty($comps)) {
								foreach ($comps as $c) {
									?>
									<tr class="comp-row">
										<td><input class="form-control" name="components[<?php echo (int)$idx; ?>][<?php echo (int)$cj; ?>][component_type]" value="<?php echo CHtml::encode($c->component_type); ?>"></td>
										<td><input class="form-control" name="components[<?php echo (int)$idx; ?>][<?php echo (int)$cj; ?>][name]" value="<?php echo CHtml::encode($c->name); ?>"></td>
										<td><input class="form-control num" name="components[<?php echo (int)$idx; ?>][<?php echo (int)$cj; ?>][wt]" value="<?php echo CHtml::encode($c->wt); ?>"></td>
										<td><input class="form-control num" name="components[<?php echo (int)$idx; ?>][<?php echo (int)$cj; ?>][amount]" value="<?php echo CHtml::encode($c->amount); ?>"></td>
										<td><button type="button" class="btn btn-xs btn-danger remove-comp">x</button></td>
									</tr>
									<?php
									$cj++;
								}
							} else {
								?>
								<tr class="comp-row">
									<td><input class="form-control" name="components[<?php echo (int)$idx; ?>][0][component_type]"></td>
									<td><input class="form-control" name="components[<?php echo (int)$idx; ?>][0][name]"></td>
									<td><input class="form-control num" name="components[<?php echo (int)$idx; ?>][0][wt]"></td>
									<td><input class="form-control num" name="components[<?php echo (int)$idx; ?>][0][amount]"></td>
									<td><button type="button" class="btn btn-xs btn-danger remove-comp">x</button></td>
								</tr>
								<?php
							}
							?>
							</tbody>
						</table>
						<button type="button" class="btn btn-xs btn-default add-comp" style="margin-top:5px;">Add component</button>
					</td>
					<td><button type="button" class="btn btn-sm btn-danger remove-line">Remove</button></td>
				</tr>
				<?php
				$idx++;
			}
		} else {
			?>
			<tr class="line-row" data-idx="0">
				<td><input class="form-control" name="lines[0][order_no]"></td>
				<td><?php echo CHtml::dropDownList('lines[0][customer_account_id]','',$customerOptions,array('class'=>'form-control','prompt'=>'--')); ?></td>
				<td><input class="form-control" name="lines[0][item_name]"></td>
				<td><input class="form-control num" name="lines[0][psc]"></td>
				<td><input class="form-control num" name="lines[0][gross_wt]"></td>
				<td><input class="form-control num net-wt" name="lines[0][net_wt]"></td>
				<td><input class="form-control num touch-pct" name="lines[0][touch_pct]"></td>
				<td><input class="form-control fine-wt" name="lines[0][fine_wt]" readonly></td>
				<td>
					<table class="table table-condensed comp-table" style="margin-bottom:0;">
						<thead><tr><th>Type</th><th>Name</th><th style="width:12%;">Wt</th><th style="width:14%;">Amt</th><th style="width:8%;">+</th></tr></thead>
						<tbody>
							<tr class="comp-row">
								<td><input class="form-control" name="components[0][0][component_type]"></td>
								<td><input class="form-control" name="components[0][0][name]"></td>
								<td><input class="form-control num" name="components[0][0][wt]"></td>
								<td><input class="form-control num" name="components[0][0][amount]"></td>
								<td><button type="button" class="btn btn-xs btn-danger remove-comp">x</button></td>
							</tr>
						</tbody>
					</table>
					<button type="button" class="btn btn-xs btn-default add-comp" style="margin-top:5px;">Add component</button>
				</td>
				<td><button type="button" class="btn btn-sm btn-danger remove-line">Remove</button></td>
			</tr>
			<?php
		}
		?>
		</tbody>
	</table>

	<button type="button" class="btn btn-default" id="add-line">Add line</button>

	<div class="row" style="margin-top:15px;">
		<div class="col-md-12">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Save' : 'Update', array('class'=>'btn btn-primary')); ?>
			<?php echo CHtml::link('Back', array('admin'), array('class'=>'btn btn-default')); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

</div>

<script>
(function($){
	function toNum(v){ v=(v||'').toString().trim(); if(!v) return null; var n=parseFloat(v); return isNaN(n)?null:n; }
	function calcFine($row){
		var net = toNum($row.find('.net-wt').val());
		var touch = toNum($row.find('.touch-pct').val());
		if(net===null || touch===null){ $row.find('.fine-wt').val(''); return; }
		$row.find('.fine-wt').val((net*(touch/100.0)).toFixed(3));
	}
	function nextCompIndex($tbl){
		var max=-1;
		$tbl.find('tbody tr.comp-row').each(function(){
			var name = $(this).find('input[name*="[amount]"]').attr('name') || '';
			var m = name.match(/\[(\d+)\]\[(\d+)\]\[amount\]/);
			if(m){ max=Math.max(max, parseInt(m[2],10)); }
		});
		return max+1;
	}
	function bindLine($row){
		$row.off('keyup change','.net-wt,.touch-pct').on('keyup change','.net-wt,.touch-pct',function(){ calcFine($row); });
		$row.off('click','.remove-line').on('click','.remove-line',function(){ $row.remove(); });
		var $tbl = $row.find('table.comp-table');
		$tbl.off('click','.remove-comp').on('click','.remove-comp',function(){ $(this).closest('tr.comp-row').remove(); });
		$row.off('click','.add-comp').on('click','.add-comp',function(){
			var idx = $row.data('idx');
			var cidx = nextCompIndex($tbl);
			var tr = '<tr class="comp-row">'
				+ '<td><input class="form-control" name="components['+idx+']['+cidx+'][component_type]"></td>'
				+ '<td><input class="form-control" name="components['+idx+']['+cidx+'][name]"></td>'
				+ '<td><input class="form-control num" name="components['+idx+']['+cidx+'][wt]"></td>'
				+ '<td><input class="form-control num" name="components['+idx+']['+cidx+'][amount]"></td>'
				+ '<td><button type="button" class="btn btn-xs btn-danger remove-comp">x</button></td>'
				+ '</tr>';
			$tbl.find('tbody').append(tr);
		});
	}

	$('#lines-table tbody tr.line-row').each(function(){ bindLine($(this)); calcFine($(this)); });

	$('#add-line').on('click', function(){
		var $tbody = $('#lines-table tbody');
		var idx = $tbody.find('tr.line-row').length;
		var customerOptionsHtml = <?php echo CJSON::encode(CHtml::dropDownList('x','',$customerOptions,array('class'=>'form-control','prompt'=>'--'))); ?>;
		customerOptionsHtml = customerOptionsHtml.replace('name="x"', 'name="lines['+idx+'][customer_account_id]"');
		var row = ''
			+ '<tr class="line-row" data-idx="'+idx+'">'
			+ '<td><input class="form-control" name="lines['+idx+'][order_no]"></td>'
			+ '<td>'+customerOptionsHtml+'</td>'
			+ '<td><input class="form-control" name="lines['+idx+'][item_name]"></td>'
			+ '<td><input class="form-control num" name="lines['+idx+'][psc]"></td>'
			+ '<td><input class="form-control num" name="lines['+idx+'][gross_wt]"></td>'
			+ '<td><input class="form-control num net-wt" name="lines['+idx+'][net_wt]"></td>'
			+ '<td><input class="form-control num touch-pct" name="lines['+idx+'][touch_pct]"></td>'
			+ '<td><input class="form-control fine-wt" name="lines['+idx+'][fine_wt]" readonly></td>'
			+ '<td>'
			+   '<table class="table table-condensed comp-table" style="margin-bottom:0;">'
			+     '<thead><tr><th>Type</th><th>Name</th><th style="width:12%;">Wt</th><th style="width:14%;">Amt</th><th style="width:8%;">+</th></tr></thead>'
			+     '<tbody>'
			+       '<tr class="comp-row">'
			+         '<td><input class="form-control" name="components['+idx+'][0][component_type]"></td>'
			+         '<td><input class="form-control" name="components['+idx+'][0][name]"></td>'
			+         '<td><input class="form-control num" name="components['+idx+'][0][wt]"></td>'
			+         '<td><input class="form-control num" name="components['+idx+'][0][amount]"></td>'
			+         '<td><button type="button" class="btn btn-xs btn-danger remove-comp">x</button></td>'
			+       '</tr>'
			+     '</tbody>'
			+   '</table>'
			+   '<button type="button" class="btn btn-xs btn-default add-comp" style="margin-top:5px;">Add component</button>'
			+ '</td>'
			+ '<td><button type="button" class="btn btn-sm btn-danger remove-line">Remove</button></td>'
			+ '</tr>';
		var $row = $(row);
		$tbody.append($row);
		bindLine($row);
	});
})(jQuery);
</script>

