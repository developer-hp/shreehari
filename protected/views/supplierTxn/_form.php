<?php
/* @var $this SupplierTxnController */
/* @var $model SupplierTxn */
/* @var $form CActiveForm */

$supplierOptions = CHtml::listData(
	LedgerAccount::model()->findAllByAttributes(array('type'=>LedgerAccount::TYPE_SUPPLIER,'is_deleted'=>0), array('order'=>'name asc')),
	'id',
	'name'
);

$existingItems = array();
if (!$model->isNewRecord) {
	$existingItems = SupplierTxnItem::model()->findAllByAttributes(array('supplier_txn_id'=>$model->id), array('order'=>'sort_order asc, id asc'));
}
?>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'supplier-txn-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('class' => 'form-horizontal'),
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<div class="col-md-3">
			<?php echo $form->labelEx($model,'txn_date'); ?>
			<?php echo $form->textField($model,'txn_date',array('class'=>'form-control','placeholder'=>'YYYY-MM-DD')); ?>
			<?php echo $form->error($model,'txn_date'); ?>
		</div>
		<div class="col-md-5">
			<?php echo $form->labelEx($model,'supplier_account_id'); ?>
			<?php echo $form->dropDownList($model,'supplier_account_id',$supplierOptions,array('class'=>'form-control','prompt'=>'-- Select Supplier --')); ?>
			<?php echo $form->error($model,'supplier_account_id'); ?>
		</div>
		<div class="col-md-4">
			<?php echo $form->labelEx($model,'sr_no'); ?>
			<?php echo $form->textField($model,'sr_no',array('class'=>'form-control','placeholder'=>'Auto')); ?>
			<div class="help-block">Leave empty to auto-generate.</div>
		</div>
	</div>

	<div class="row" style="margin-top:10px;">
		<div class="col-md-12">
			<?php echo $form->labelEx($model,'remarks'); ?>
			<?php echo $form->textArea($model,'remarks',array('class'=>'form-control','rows'=>2)); ?>
			<?php echo $form->error($model,'remarks'); ?>
		</div>
	</div>

	<hr>
	<h4>Items</h4>

	<table class="table table-bordered" id="items-table">
		<thead>
			<tr>
				<th style="width:18%;">Item</th>
				<th style="width:8%;">Ct</th>
				<th style="width:10%;">Gross</th>
				<th style="width:10%;">Net</th>
				<th style="width:10%;">Touch %</th>
				<th style="width:10%;">Fine Wt</th>
				<th>Charges</th>
				<th style="width:8%;">Action</th>
			</tr>
		</thead>
		<tbody>
		<?php
		$idx = 0;
		if (!empty($existingItems)) {
			foreach ($existingItems as $it) {
				$charges = SupplierTxnCharge::model()->findAllByAttributes(array('supplier_txn_item_id'=>$it->id), array('order'=>'sort_order asc, id asc'));
				?>
				<tr class="item-row" data-idx="<?php echo (int)$idx; ?>">
					<td><input class="form-control" name="items[<?php echo (int)$idx; ?>][item_name]" value="<?php echo CHtml::encode($it->item_name); ?>"></td>
					<td><input class="form-control num" name="items[<?php echo (int)$idx; ?>][ct]" value="<?php echo CHtml::encode($it->ct); ?>"></td>
					<td><input class="form-control num" name="items[<?php echo (int)$idx; ?>][gross_wt]" value="<?php echo CHtml::encode($it->gross_wt); ?>"></td>
					<td><input class="form-control num net-wt" name="items[<?php echo (int)$idx; ?>][net_wt]" value="<?php echo CHtml::encode($it->net_wt); ?>"></td>
					<td><input class="form-control num touch-pct" name="items[<?php echo (int)$idx; ?>][touch_pct]" value="<?php echo CHtml::encode($it->touch_pct); ?>"></td>
					<td><input class="form-control fine-wt" name="items[<?php echo (int)$idx; ?>][fine_wt]" value="<?php echo CHtml::encode($it->fine_wt); ?>" readonly></td>
					<td>
						<table class="table table-condensed charges-table" style="margin-bottom:0;">
							<thead>
								<tr>
									<th>Type</th><th>Name</th><th style="width:10%;">Qty</th><th style="width:10%;">Rate</th><th style="width:12%;">Amt</th><th style="width:10%;">Unit</th><th style="width:8%;">+</th>
								</tr>
							</thead>
							<tbody>
							<?php
							$cj = 0;
							if (!empty($charges)) {
								foreach ($charges as $ch) {
									?>
									<tr class="charge-row">
										<td><input class="form-control" name="charges[<?php echo (int)$idx; ?>][<?php echo (int)$cj; ?>][charge_type]" value="<?php echo CHtml::encode($ch->charge_type); ?>"></td>
										<td><input class="form-control" name="charges[<?php echo (int)$idx; ?>][<?php echo (int)$cj; ?>][name]" value="<?php echo CHtml::encode($ch->name); ?>"></td>
										<td><input class="form-control num qty" name="charges[<?php echo (int)$idx; ?>][<?php echo (int)$cj; ?>][qty]" value="<?php echo CHtml::encode($ch->qty); ?>"></td>
										<td><input class="form-control num rate" name="charges[<?php echo (int)$idx; ?>][<?php echo (int)$cj; ?>][rate]" value="<?php echo CHtml::encode($ch->rate); ?>"></td>
										<td><input class="form-control num amount" name="charges[<?php echo (int)$idx; ?>][<?php echo (int)$cj; ?>][amount]" value="<?php echo CHtml::encode($ch->amount); ?>"></td>
										<td><input class="form-control" name="charges[<?php echo (int)$idx; ?>][<?php echo (int)$cj; ?>][unit]" value="<?php echo CHtml::encode($ch->unit); ?>"></td>
										<td><button type="button" class="btn btn-xs btn-danger remove-charge">x</button></td>
									</tr>
									<?php
									$cj++;
								}
							} else {
								?>
								<tr class="charge-row">
									<td><input class="form-control" name="charges[<?php echo (int)$idx; ?>][0][charge_type]"></td>
									<td><input class="form-control" name="charges[<?php echo (int)$idx; ?>][0][name]"></td>
									<td><input class="form-control num qty" name="charges[<?php echo (int)$idx; ?>][0][qty]"></td>
									<td><input class="form-control num rate" name="charges[<?php echo (int)$idx; ?>][0][rate]"></td>
									<td><input class="form-control num amount" name="charges[<?php echo (int)$idx; ?>][0][amount]"></td>
									<td><input class="form-control" name="charges[<?php echo (int)$idx; ?>][0][unit]"></td>
									<td><button type="button" class="btn btn-xs btn-danger remove-charge">x</button></td>
								</tr>
								<?php
							}
							?>
							</tbody>
						</table>
						<button type="button" class="btn btn-xs btn-default add-charge" style="margin-top:5px;">Add charge</button>
					</td>
					<td>
						<button type="button" class="btn btn-sm btn-danger remove-item">Remove</button>
					</td>
				</tr>
				<?php
				$idx++;
			}
		} else {
			?>
			<tr class="item-row" data-idx="0">
				<td><input class="form-control" name="items[0][item_name]"></td>
				<td><input class="form-control num" name="items[0][ct]"></td>
				<td><input class="form-control num" name="items[0][gross_wt]"></td>
				<td><input class="form-control num net-wt" name="items[0][net_wt]"></td>
				<td><input class="form-control num touch-pct" name="items[0][touch_pct]"></td>
				<td><input class="form-control fine-wt" name="items[0][fine_wt]" readonly></td>
				<td>
					<table class="table table-condensed charges-table" style="margin-bottom:0;">
						<thead>
							<tr>
								<th>Type</th><th>Name</th><th style="width:10%;">Qty</th><th style="width:10%;">Rate</th><th style="width:12%;">Amt</th><th style="width:10%;">Unit</th><th style="width:8%;">+</th>
							</tr>
						</thead>
						<tbody>
							<tr class="charge-row">
								<td><input class="form-control" name="charges[0][0][charge_type]"></td>
								<td><input class="form-control" name="charges[0][0][name]"></td>
								<td><input class="form-control num qty" name="charges[0][0][qty]"></td>
								<td><input class="form-control num rate" name="charges[0][0][rate]"></td>
								<td><input class="form-control num amount" name="charges[0][0][amount]"></td>
								<td><input class="form-control" name="charges[0][0][unit]"></td>
								<td><button type="button" class="btn btn-xs btn-danger remove-charge">x</button></td>
							</tr>
						</tbody>
					</table>
					<button type="button" class="btn btn-xs btn-default add-charge" style="margin-top:5px;">Add charge</button>
				</td>
				<td><button type="button" class="btn btn-sm btn-danger remove-item">Remove</button></td>
			</tr>
			<?php
		}
		?>
		</tbody>
	</table>

	<button type="button" class="btn btn-default" id="add-item">Add item</button>

	<div class="form-group form-actions">
		<div class="col-md-9 col-md-offset-3">
			<?php echo CHtml::submitButton($model->isNewRecord ? 'Save' : 'Update', array('class'=>'btn btn-effect-ripple btn-primary')); ?>
			<?php echo CHtml::link('Back', array('admin'), array('class'=>'btn btn-effect-ripple btn-danger')); ?>
		</div>
	</div>

<?php $this->endWidget(); ?>

<script>
(function($){
	function toNum(v){ v = (v||'').toString().trim(); if(!v) return null; var n = parseFloat(v); return isNaN(n) ? null : n; }
	function calcFine($row){
		var net = toNum($row.find('.net-wt').val());
		var touch = toNum($row.find('.touch-pct').val());
		if(net === null || touch === null){ $row.find('.fine-wt').val(''); return; }
		var fine = net * (touch/100.0);
		$row.find('.fine-wt').val(fine.toFixed(3));
	}
	function nextChargeIndex($chargesTable){
		var max = -1;
		$chargesTable.find('tbody tr.charge-row').each(function(){
			var name = $(this).find('input[name*="[amount]"]').attr('name') || '';
			var m = name.match(/\[(\d+)\]\[(\d+)\]\[amount\]/);
			if(m){ max = Math.max(max, parseInt(m[2],10)); }
		});
		return max+1;
	}
	function bindRow($row){
		$row.off('keyup change', '.net-wt,.touch-pct').on('keyup change', '.net-wt,.touch-pct', function(){ calcFine($row); });
		$row.off('click', '.remove-item').on('click', '.remove-item', function(){
			$row.remove();
		});
		var $tbl = $row.find('table.charges-table');
		if ($tbl.length === 0) return; // Safety check
		$tbl.off('click', '.remove-charge').on('click', '.remove-charge', function(e){
			e.preventDefault();
			$(this).closest('tr.charge-row').remove();
		});
		$row.off('click', '.add-charge').on('click', '.add-charge', function(e){
			e.preventDefault();
			var idx = $row.data('idx');
			var $tblCurrent = $row.find('table.charges-table');
			if ($tblCurrent.length === 0) return; // Safety check
			var $tbody = $tblCurrent.find('tbody');
			if ($tbody.length === 0) return; // Safety check
			var cidx = nextChargeIndex($tblCurrent);
			
			// Create charge row using jQuery DOM methods
			var $chargeRow = $('<tr>').addClass('charge-row');
			$chargeRow.append($('<td>').append($('<input>').addClass('form-control').attr('name', 'charges['+idx+']['+cidx+'][charge_type]')));
			$chargeRow.append($('<td>').append($('<input>').addClass('form-control').attr('name', 'charges['+idx+']['+cidx+'][name]')));
			$chargeRow.append($('<td>').append($('<input>').addClass('form-control num qty').attr('name', 'charges['+idx+']['+cidx+'][qty]')));
			$chargeRow.append($('<td>').append($('<input>').addClass('form-control num rate').attr('name', 'charges['+idx+']['+cidx+'][rate]')));
			$chargeRow.append($('<td>').append($('<input>').addClass('form-control num amount').attr('name', 'charges['+idx+']['+cidx+'][amount]')));
			$chargeRow.append($('<td>').append($('<input>').addClass('form-control').attr('name', 'charges['+idx+']['+cidx+'][unit]')));
			$chargeRow.append($('<td>').append($('<button>').attr('type', 'button').addClass('btn btn-xs btn-danger remove-charge').text('x')));
			
			$tbody.append($chargeRow);
		});
	}

	$('#items-table tbody tr.item-row').each(function(){ bindRow($(this)); calcFine($(this)); });

	$('#add-item').on('click', function(e){
		e.preventDefault();
		var $tbody = $('#items-table tbody');
		var idx = $tbody.find('tr.item-row').length;
		
		// Find first existing row to use as template, or use the empty template row
		var $templateRow = $tbody.find('tr.item-row').first();
		if ($templateRow.length === 0) {
			alert('Error: No template row found');
			return;
		}
		
		// Clone the template row (without event handlers)
		var $row = $templateRow.clone(false);
		$row.attr('data-idx', idx);
		
		// Update all input names with new index
		$row.find('input[name*="items["]').each(function(){
			var $input = $(this);
			var name = $input.attr('name');
			if (name) {
				name = name.replace(/items\[\d+\]/, 'items['+idx+']');
				$input.attr('name', name);
				$input.val(''); // Clear values
			}
		});
		
		// Update charge input names
		$row.find('input[name*="charges["]').each(function(){
			var $input = $(this);
			var name = $input.attr('name');
			if (name) {
				name = name.replace(/charges\[\d+\]/, 'charges['+idx+']');
				name = name.replace(/charges\[\d+\]\[\d+\]/, 'charges['+idx+'][0]');
				$input.attr('name', name);
				$input.val(''); // Clear values
			}
		});
		
		// Clear fine weight (readonly field)
		$row.find('.fine-wt').val('');
		
		// Remove all charge rows except the first one
		var $chargesTable = $row.find('table.charges-table');
		var $chargesTbody = $chargesTable.find('tbody');
		$chargesTbody.find('tr.charge-row').not(':first').remove();
		
		// Append row to tbody
		$tbody.append($row);
		
		// Bind events
		bindRow($row);
		calcFine($row);
	});
})(jQuery);
</script>

