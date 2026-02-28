<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'supplier-ledger-txn-form',
    'enableAjaxValidation' => true,
    'htmlOptions' => array('class' => 'form-horizontal supplier-ledger-form-fullwidth'),
));
?>
<style type="text/css">
.supplier-ledger-form-fullwidth { width: 100%; max-width: 100%; }
.supplier-ledger-form-fullwidth #items-container { width: 100%; }
.supplier-ledger-form-fullwidth .item-block .panel-body { width: 100%; }
.block-fullwidth { max-width: 100%; width: 100%; }
.charges-wrap { margin-top: 1.25rem; }
.charge-header-row { margin-bottom: 0.75rem; padding-top: 0.25rem; }
.charge-header-row .btn-add-charge { margin-left: 0.5rem; }
</style>
<?php
$chargeLabels = SupplierLedgerTxnItem::getChargeTypeLabels();
$items = $model->isNewRecord ? array(array('item_name'=>'','ct'=>'','gross_wt'=>'','net_wt'=>'','touch_pct'=>'','charges'=>array(array('charge_type'=>1,'charge_name'=>'','quantity'=>'','rate'=>'')))) : $model->items;
if (empty($items)) $items = array(array('item_name'=>'','ct'=>'','gross_wt'=>'','net_wt'=>'','touch_pct'=>'','charges'=>array(array('charge_type'=>1,'charge_name'=>'','quantity'=>'','rate'=>''))));
$txnDate = $model->txn_date;
if (!empty($txnDate) && preg_match('/^\d{4}-\d{2}-\d{2}/', $txnDate)) $txnDate = date('d-m-Y', strtotime($txnDate));
if (!$txnDate) $txnDate = date('d-m-Y');
$drcrOptions = IssueEntry::getDrcrOptions();
?>
<?php echo $form->hiddenField($model, 'drcr', array('value' => IssueEntry::DRCR_DEBIT)); ?>
<div class="form-group">
    <?php echo $form->labelEx($model, 'txn_date', array('class' => 'col-sm-2 control-label')); ?>
    <div class="col-sm-4">
        <?php echo $form->textField($model, 'txn_date', array('class' => 'form-control input-datepicker', 'data-date-format' => 'dd-mm-yyyy', 'value' => $txnDate, 'placeholder' => 'dd-mm-yyyy', 'autocomplete' => 'off')); ?>
        <?php echo $form->error($model, 'txn_date'); ?>
    </div>
</div>
<div class="form-group">
    <?php echo $form->labelEx($model, 'supplier_id', array('class' => 'col-sm-2 control-label')); ?>
    <div class="col-sm-4">
        <?php
        $suppliers = CHtml::listData(Customer::model()->findAll(array('condition' => 'is_deleted = 0 AND type = 1', 'order' => 'name')), 'id', 'name');
        echo $form->dropDownList($model, 'supplier_id', $suppliers, array('class' => 'form-control select2-supplier', 'prompt' => '----Select Supplier----'));
        ?>
        <?php echo $form->error($model, 'supplier_id'); ?>
    </div>
</div>
<div class="form-group">
    <?php echo $form->labelEx($model, 'sr_no', array('class' => 'col-sm-2 control-label')); ?>
    <div class="col-sm-4">
        <?php echo $form->textField($model, 'sr_no', array('class' => 'form-control')); ?>
        <?php echo $form->error($model, 'sr_no'); ?>
    </div>
</div>
<div class="form-group">
    <?php echo $form->labelEx($model, 'remark', array('class' => 'col-sm-2 control-label')); ?>
    <div class="col-sm-8">
        <?php echo $form->textArea($model, 'remark', array('class' => 'form-control', 'rows' => 3, 'placeholder' => 'Enter remarks...')); ?>
        <?php echo $form->error($model, 'remark'); ?>
    </div>
</div>

<h4>Items</h4>
<div id="items-container">
<?php foreach ($items as $i => $item): ?>
<?php
$it = is_object($item) ? $item : (object) $item;
$charges = isset($it->charges) ? $it->charges : (isset($item['charges']) ? $item['charges'] : array());
if (empty($charges) && is_object($it) && isset($it->id)) $charges = $it->charges;
if (empty($charges)) $charges = array(array('charge_type'=>1,'charge_name'=>'','quantity'=>'','rate'=>''));
?>
<div class="item-block panel panel-default" data-index="<?php echo $i; ?>">
    <div class="panel-body">
        <div class="row item-main-row">
            <div class="col-sm-2"><?php echo CHtml::textField("items[{$i}][item_name]", is_object($it) ? $it->item_name : (isset($item['item_name'])?$item['item_name']:''), array('class' => 'form-control input-sm', 'placeholder' => 'Item name')); ?></div>
            <div class="col-sm-1"><?php echo CHtml::textField("items[{$i}][ct]", is_object($it) ? $it->ct : (isset($item['ct'])?$item['ct']:''), array('class' => 'form-control input-sm sl-numeric', 'placeholder' => 'Ct')); ?></div>
            <div class="col-sm-1"><?php echo CHtml::textField("items[{$i}][gross_wt]", is_object($it) ? $it->gross_wt : (isset($item['gross_wt'])?$item['gross_wt']:''), array('class' => 'form-control input-sm sl-numeric', 'placeholder' => 'Gross')); ?></div>
            <div class="col-sm-1"><?php echo CHtml::textField("items[{$i}][net_wt]", is_object($it) ? $it->net_wt : (isset($item['net_wt'])?$item['net_wt']:''), array('class' => 'form-control input-sm net-wt sl-numeric', 'placeholder' => 'Net wt')); ?></div>
            <div class="col-sm-1"><?php echo CHtml::textField("items[{$i}][touch_pct]", is_object($it) ? $it->touch_pct : (isset($item['touch_pct'])?$item['touch_pct']:''), array('class' => 'form-control input-sm touch-pct sl-numeric', 'placeholder' => 'Touch %')); ?></div>
            <div class="col-sm-1"><?php echo CHtml::textField('', (isset($it->fine_wt) && $it->fine_wt !== null && $it->fine_wt !== '') ? number_format((float)$it->fine_wt, 3) : '', array('class' => 'form-control input-sm item-fine-wt', 'readonly' => 'readonly', 'placeholder' => 'Fine wt', 'style' => 'background:#eee;')); ?></div>
            <div class="col-sm-1"><button type="button" class="btn btn-danger btn-sm btn-remove-item">Remove</button></div>
        </div>
        <div class="charges-wrap mt-3 mb-2">
            <div class="row charge-header-row mb-2">
                <div class="col-sm-2"><strong>Other details (charges):</strong></div>
                <div class="col-sm-2"></div>
                <div class="col-sm-1"></div>
                <div class="col-sm-1"></div>
                <div class="col-sm-1"><strong>Amount</strong></div>
                <div class="col-sm-1 text-right">
                    <button type="button" class="btn btn-xs btn-primary btn-add-charge"><i class="fa fa-plus"></i> Add charge</button>
                </div>
            </div>
            <div class="charge-rows">
            <?php foreach ($charges as $j => $ch): ?>
            <?php $c = is_object($ch) ? $ch : $ch;
            $qty = is_object($c) ? $c->quantity : (isset($c['quantity']) ? $c['quantity'] : '');
            $rate = is_object($c) ? $c->rate : (isset($c['rate']) ? $c['rate'] : '');
            $chargeAmt = (is_numeric($qty) && is_numeric($rate)) ? number_format((float)$qty * (float)$rate, 2) : '';
            ?>
            <div class="row charge-row mt-1">
                <div class="col-sm-2">
                    <?php echo CHtml::dropDownList("items[{$i}][charges][{$j}][charge_type]", is_object($c) ? $c->charge_type : (isset($c['charge_type'])?$c['charge_type']:1), $chargeLabels, array('class' => 'form-control input-sm')); ?>
                </div>
                <div class="col-sm-2">
                    <?php echo CHtml::textField("items[{$i}][charges][{$j}][charge_name]", is_object($c) ? $c->charge_name : (isset($c['charge_name'])?$c['charge_name']:''), array('class' => 'form-control input-sm', 'placeholder' => 'Name (other)')); ?>
                </div>
                <div class="col-sm-1"><?php echo CHtml::textField("items[{$i}][charges][{$j}][quantity]", $qty, array('class' => 'form-control input-sm charge-qty sl-numeric', 'placeholder' => 'Qty')); ?></div>
                <div class="col-sm-1"><?php echo CHtml::textField("items[{$i}][charges][{$j}][rate]", $rate, array('class' => 'form-control input-sm charge-rate sl-numeric', 'placeholder' => 'Rate')); ?></div>
                <div class="col-sm-1"><?php echo CHtml::textField('', $chargeAmt, array('class' => 'form-control input-sm charge-row-amount', 'readonly' => 'readonly', 'placeholder' => '0.00', 'style' => 'background:#eee;')); ?></div>
                <div class="col-sm-1"><button type="button" class="btn btn-xs btn-danger btn-remove-charge">Remove</button></div>
            </div>
            <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
</div>
<p><button type="button" id="add-item-btn" class="btn btn-default">Add Item</button></p>

<div class="panel panel-default margin-top-15">
    <div class="panel-body">
        <strong>Total Fine Wt:</strong> <span id="total-fine-wt">0.000</span> &nbsp;&nbsp;|&nbsp;&nbsp; <strong>Total Amount:</strong> <span id="total-amount">0.00</span>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-primary')); ?>
        <?php echo CHtml::link('Cancel', array('supplierLedger/admin'), array('class' => 'btn btn-default')); ?>
    </div>
</div>
<?php $this->endWidget(); ?>

<script type="text/javascript">
$(function() {
    var $supplierSelect = $('.select2-supplier');
    if ($supplierSelect.length && (!$supplierSelect.data('select2'))) {
        $supplierSelect.select2({ placeholder: '----Select Supplier----', allowClear: true, width: '100%' });
    }

    // Allow only numbers (digits, one decimal point, optional minus) in numeric fields — no alphabets
    function sanitizeNumericInput(el) {
        var v = el.value;
        var start = el.selectionStart, end = el.selectionEnd;
        v = v.replace(/[^0-9.\-]/g, '');
        var firstMinus = v.indexOf('-');
        if (firstMinus > 0) v = v.replace(/-/g, '');
        else if (firstMinus === 0 && v.indexOf('-', 1) >= 0) v = v.substring(0, 1) + v.substring(1).replace(/-/g, '');
        var dotCount = (v.match(/\./g) || []).length;
        if (dotCount > 1) {
            var idx = v.indexOf('.');
            v = v.substring(0, idx + 1) + v.substring(idx + 1).replace(/\./g, '');
        }
        el.value = v;
        el.setSelectionRange(Math.min(start, v.length), Math.min(end, v.length));
    }
    $(document).on('keypress', '#supplier-ledger-txn-form .sl-numeric', function(ev) {
        var k = ev.which || ev.keyCode;
        if (k <= 0 || ev.ctrlKey || ev.metaKey || ev.altKey) return;
        if (k === 8 || k === 9 || k === 46) return;
        if (k === 45) { if (this.value.length > 0 || this.selectionStart > 0) ev.preventDefault(); return; }
        if (k === 46) { if (this.value.indexOf('.') >= 0) ev.preventDefault(); return; }
        if (k < 48 || k > 57) ev.preventDefault();
    });
    $(document).on('input paste', '#supplier-ledger-txn-form .sl-numeric', function() { sanitizeNumericInput(this); });
});
</script>
<script>
(function(){
    var chargeLabels = <?php echo json_encode($chargeLabels); ?>;
    var chargeOpts = '';
    for (var k in chargeLabels) { chargeOpts += '<option value="'+k+'">'+chargeLabels[k]+'</option>'; }
    var itemIndex = <?php echo count($items); ?>;

    function addChargeRow($itemBlock) {
        var idx = $itemBlock.attr('data-index');
        var $rows = $itemBlock.find('.charge-rows');
        var chargeIdx = $rows.find('.charge-row').length;
        var html = '<div class="row charge-row mt-1">';
        html += '<div class="col-sm-2"><select name="items['+idx+'][charges]['+chargeIdx+'][charge_type]" class="form-control input-sm">'+chargeOpts+'</select></div>';
        html += '<div class="col-sm-2"><input type="text" name="items['+idx+'][charges]['+chargeIdx+'][charge_name]" class="form-control input-sm" placeholder="Name (other)" /></div>';
        html += '<div class="col-sm-1"><input type="text" name="items['+idx+'][charges]['+chargeIdx+'][quantity]" class="form-control input-sm charge-qty sl-numeric" placeholder="Qty" /></div>';
        html += '<div class="col-sm-1"><input type="text" name="items['+idx+'][charges]['+chargeIdx+'][rate]" class="form-control input-sm charge-rate sl-numeric" placeholder="Rate" /></div>';
        html += '<div class="col-sm-1"><input type="text" class="form-control input-sm charge-row-amount" readonly placeholder="0.00" style="background:#eee;" /></div>';
        html += '<div class="col-sm-1"><button type="button" class="btn btn-xs btn-danger btn-remove-charge">Remove</button></div></div>';
        $rows.append(html);
    }
    function updateChargeRowAmounts() {
        $('.charge-row').each(function(){
            var q = parseNum($(this).find('.charge-qty').val()) || parseNum($(this).find('input[placeholder="Qty"]').val());
            var r = parseNum($(this).find('.charge-rate').val()) || parseNum($(this).find('input[placeholder="Rate"]').val());
            var amt = (q * r).toFixed(2);
            $(this).find('.charge-row-amount').val(amt);
        });
    }

    function parseNum(val) {
        var n = parseFloat(String(val).replace(/,/g, ''));
        return isNaN(n) ? 0 : n;
    }
    function updateItemFineWt($block) {
        var net = parseNum($block.find('.net-wt').val());
        var touch = parseNum($block.find('.touch-pct').val());
        var fine = (touch / 100) * net;
        $block.find('.item-fine-wt').val(fine > 0 ? fine.toFixed(3) : '');
    }
    function updateTotals() {
        var totalFine = 0, totalAmt = 0;
        $('#items-container .item-block').each(function(){
            var $b = $(this);
            var net = parseNum($b.find('.net-wt').val());
            var touch = parseNum($b.find('.touch-pct').val());
            totalFine += (touch / 100) * net;
            $b.find('.charge-row').each(function(){
                var q = parseNum($(this).find('input[placeholder="Qty"]').val());
                var r = parseNum($(this).find('input[placeholder="Rate"]').val());
                totalAmt += q * r;
            });
        });
        $('#total-fine-wt').text(totalFine.toFixed(3));
        $('#total-amount').text(totalAmt.toFixed(2));
        updateChargeRowAmounts();
    }
    function onItemOrChargeChange() {
        var $block = $(this).closest('.item-block');
        if ($block.length) {
            updateItemFineWt($block);
        }
        updateTotals();
    }
    $('#items-container').on('input change', '.net-wt, .touch-pct', function(){ updateItemFineWt($(this).closest('.item-block')); updateTotals(); });
    $('#items-container').on('input change', '.charge-qty, .charge-rate, .charge-row input[placeholder="Qty"], .charge-row input[placeholder="Rate"]', function(){ updateChargeRowAmounts(); updateTotals(); });
    $(document).on('click', '.btn-remove-item', function(){ $(this).closest('.item-block').remove(); updateTotals(); });
    $(document).on('click', '.btn-add-charge', function(){ addChargeRow($(this).closest('.item-block')); });
    $(document).on('click', '.btn-remove-charge', function(){ $(this).closest('.charge-row').remove(); updateTotals(); });
    $('#add-item-btn').on('click', function(){
        var html = '<div class="item-block panel panel-default" data-index="'+itemIndex+'"><div class="panel-body">';
        html += '<div class="row item-main-row"><div class="col-sm-2"><input type="text" name="items['+itemIndex+'][item_name]" class="form-control input-sm" placeholder="Item name" /></div>';
        html += '<div class="col-sm-1"><input type="text" name="items['+itemIndex+'][ct]" class="form-control input-sm sl-numeric" placeholder="Ct" /></div>';
        html += '<div class="col-sm-1"><input type="text" name="items['+itemIndex+'][gross_wt]" class="form-control input-sm sl-numeric" placeholder="Gross" /></div>';
        html += '<div class="col-sm-1"><input type="text" name="items['+itemIndex+'][net_wt]" class="form-control input-sm net-wt sl-numeric" placeholder="Net wt" /></div>';
        html += '<div class="col-sm-1"><input type="text" name="items['+itemIndex+'][touch_pct]" class="form-control input-sm touch-pct sl-numeric" placeholder="Touch %" /></div>';
        html += '<div class="col-sm-1"><input type="text" class="form-control input-sm item-fine-wt" readonly placeholder="Fine wt" style="background:#eee;" /></div>';
        html += '<div class="col-sm-1"><button type="button" class="btn btn-danger btn-sm btn-remove-item">Remove</button></div></div>';
        html += '<div class="charges-wrap mt-3 mb-2"><div class="row charge-header-row mb-2"><div class="col-sm-2"><strong>Other details (charges):</strong></div><div class="col-sm-2"></div><div class="col-sm-1"></div><div class="col-sm-1"></div><div class="col-sm-1"><strong>Amount</strong></div><div class="col-sm-1 text-right"><button type="button" class="btn btn-xs btn-primary btn-add-charge"><i class="fa fa-plus"></i> Add charge</button></div></div>';
        html += '<div class="charge-rows"><div class="row charge-row mt-1">';
        html += '<div class="col-sm-2"><select name="items['+itemIndex+'][charges][0][charge_type]" class="form-control input-sm">'+chargeOpts+'</select></div>';
        html += '<div class="col-sm-2"><input type="text" name="items['+itemIndex+'][charges][0][charge_name]" class="form-control input-sm" placeholder="Name (other)" /></div>';
        html += '<div class="col-sm-1"><input type="text" name="items['+itemIndex+'][charges][0][quantity]" class="form-control input-sm charge-qty sl-numeric" placeholder="Qty" /></div>';
        html += '<div class="col-sm-1"><input type="text" name="items['+itemIndex+'][charges][0][rate]" class="form-control input-sm charge-rate sl-numeric" placeholder="Rate" /></div>';
        html += '<div class="col-sm-1"><input type="text" class="form-control input-sm charge-row-amount" readonly placeholder="0.00" style="background:#eee;" /></div>';
        html += '<div class="col-sm-1"><button type="button" class="btn btn-xs btn-danger btn-remove-charge">Remove</button></div></div></div></div></div></div>';
        $('#items-container').append(html);
        itemIndex++;
        updateTotals();
    });
    updateTotals();
})();
</script>
