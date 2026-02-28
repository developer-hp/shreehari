<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'karigar-jama-form',
    'enableAjaxValidation' => true,
    'errorMessageCssClass' => 'help-block animation-slideUp form-error',
    'htmlOptions' => array('class' => 'form-horizontal'),
));
$voucherDate = $model->voucher_date;
if (!empty($voucherDate) && preg_match('/^\d{4}-\d{2}-\d{2}/', $voucherDate)) $voucherDate = date('d-m-Y', strtotime($voucherDate));
if (!$voucherDate) $voucherDate = date('d-m-Y');
$lines = $model->isNewRecord ? array(array()) : $model->lines;
if (empty($lines)) $lines = array(array());
$caratOptions = KarigarJamaVoucherLine::getCaratOptions();
$drcrOptions = IssueEntry::getDrcrOptions();
?>
<?php echo $form->hiddenField($model, 'drcr', array('value' => IssueEntry::DRCR_DEBIT)); ?>
<div class="form-group">
    <?php echo $form->labelEx($model, 'voucher_date', array('class' => 'col-sm-2 control-label')); ?>
    <div class="col-sm-4">
        <?php echo $form->textField($model, 'voucher_date', array('class' => 'form-control input-datepicker', 'data-date-format' => 'dd-mm-yyyy', 'value' => $voucherDate, 'placeholder' => 'dd-mm-yyyy', 'autocomplete' => 'off')); ?>
        <?php echo $form->error($model, 'voucher_date'); ?>
    </div>
</div>
<div class="form-group">
    <?php echo $form->labelEx($model, 'karigar_id', array('class' => 'col-sm-2 control-label')); ?>
    <div class="col-sm-4">
        <?php
        $karigars = CHtml::listData(Customer::model()->findAll(array('condition' => 'is_deleted = 0 AND type = 3', 'order' => 'name')), 'id', 'name');
        echo $form->dropDownList($model, 'karigar_id', $karigars, array('class' => 'form-control select2-karigar', 'prompt' => '----Select Karigar----'));
        ?>
        <?php echo $form->error($model, 'karigar_id'); ?>
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
<div id="lines-container">
<?php foreach ($lines as $idx => $line): ?>
<?php
$ln = is_object($line) ? $line : array();
$stones = is_object($line) && isset($line->stones) ? $line->stones : array(array());
if (empty($stones)) $stones = array(array());
?>
<div class="line-block panel panel-default" data-idx="<?php echo $idx; ?>">
    <div class="panel-body">
        <div class="row form-group">
            <div class="col-sm-1"><?php echo CHtml::textField("lines[{$idx}][sr_no]", is_object($ln) ? (isset($ln->sr_no) ? $ln->sr_no : '') : (isset($ln['sr_no']) ? $ln['sr_no'] : ''), array('class' => 'form-control input-sm kj-numeric', 'placeholder' => 'Sr')); ?></div>
            <div class="col-sm-1"><?php echo CHtml::textField("lines[{$idx}][order_no]", is_object($ln)?$ln->order_no:'', array('class' => 'form-control input-sm kj-numeric', 'placeholder' => 'Order No')); ?></div>
            <div class="col-sm-1"><?php echo CHtml::textField("lines[{$idx}][customer_name]", is_object($ln)?$ln->customer_name:'', array('class' => 'form-control input-sm', 'placeholder' => 'Customer')); ?></div>
            <div class="col-sm-2"><?php echo CHtml::textField("lines[{$idx}][item_name]", is_object($ln)?$ln->item_name:'', array('class' => 'form-control input-sm', 'placeholder' => 'Item')); ?></div>
            <div class="col-sm-1"><?php echo CHtml::dropDownList("lines[{$idx}][carat]", is_object($ln) ? (isset($ln->carat) ? $ln->carat : '') : (isset($ln['carat']) ? $ln['carat'] : ''), $caratOptions, array('class' => 'form-control input-sm', 'prompt' => 'Carat')); ?></div>
            <div class="col-sm-1"><?php echo CHtml::textField("lines[{$idx}][psc]", is_object($ln)?$ln->psc:'', array('class' => 'form-control input-sm kj-numeric', 'placeholder' => 'Psc')); ?></div>
            <div class="col-sm-1"><?php echo CHtml::textField("lines[{$idx}][gross_wt]", is_object($ln)?$ln->gross_wt:'', array('class' => 'form-control input-sm kj-numeric', 'placeholder' => 'Gross')); ?></div>
            <div class="col-sm-1"><?php echo CHtml::textField("lines[{$idx}][net_wt]", is_object($ln)?$ln->net_wt:'', array('class' => 'form-control input-sm kj-numeric', 'placeholder' => 'Net')); ?></div>
            <div class="col-sm-1"><?php echo CHtml::textField("lines[{$idx}][touch_pct]", is_object($ln)?$ln->touch_pct:'', array('class' => 'form-control input-sm kj-numeric', 'placeholder' => 'Touch%')); ?></div>
            <div class="col-sm-1"><?php echo CHtml::textField("lines[{$idx}][remark]", is_object($ln)?$ln->remark:'', array('class' => 'form-control input-sm', 'placeholder' => 'Remark')); ?></div>
            <div class="col-sm-1"><button type="button" class="btn btn-danger btn-sm btn-remove-line">Remove</button></div>
        </div>
        <div class="small mt-2">
            <div class="row margin-bottom-5">
                <div class="col-sm-2"><strong>Stone/Diamond/Other:</strong></div>
                <div class="col-sm-2"><strong>Item</strong></div>
                <div class="col-sm-2"><strong>Weight</strong></div>
                <div class="col-sm-2"><strong>Amount</strong></div>
                <div class="col-sm-2"><button type="button" class="btn btn-xs btn-primary btn-add-stone">+ Add stone</button></div>
            </div>
            <div class="stone-rows" data-line-idx="<?php echo $idx; ?>">
            <?php foreach ($stones as $sj => $st): ?>
            <?php
            $sItem = is_object($st) ? (isset($st->item) ? $st->item : '') : (isset($st['item']) ? $st['item'] : '');
            $sWt   = is_object($st) ? (isset($st->stone_wt) ? $st->stone_wt : '') : (isset($st['stone_wt']) ? $st['stone_wt'] : '');
            $sAmt  = is_object($st) ? (isset($st->stone_amount) ? $st->stone_amount : '') : (isset($st['stone_amount']) ? $st['stone_amount'] : '');
            ?>
            <div class="row stone-row margin-bottom-5">
                <div class="col-sm-2"></div>
                <div class="col-sm-2"><?php echo CHtml::textField("lines[{$idx}][stones][{$sj}][item]", $sItem, array('class'=>'form-control input-sm','placeholder'=>'Item')); ?></div>
                <div class="col-sm-2"><?php echo CHtml::textField("lines[{$idx}][stones][{$sj}][stone_wt]", $sWt, array('class'=>'form-control input-sm kj-numeric','placeholder'=>'Wt')); ?></div>
                <div class="col-sm-2"><?php echo CHtml::textField("lines[{$idx}][stones][{$sj}][stone_amount]", $sAmt, array('class'=>'form-control input-sm kj-numeric','placeholder'=>'Amt')); ?></div>
                <div class="col-sm-2"><button type="button" class="btn btn-xs btn-danger btn-remove-stone">Remove</button></div>
            </div>
            <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
</div>
<p><button type="button" id="add-line-btn" class="btn btn-default">Add Item</button></p>

<div class="panel panel-default margin-top-15">
    <div class="panel-body">
        <strong>Total Fine Wt:</strong> <span id="jama-total-fine-wt">0.000</span> &nbsp;&nbsp;|&nbsp;&nbsp; <strong>Total Amount:</strong> <span id="jama-total-amount">0.00</span>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-primary')); ?>
        <?php echo CHtml::link('Cancel', array('karigarJama/admin'), array('class' => 'btn btn-default')); ?>
    </div>
</div>
<?php $this->endWidget(); ?>

<script type="text/javascript">
$(function() {
    var $karigarSelect = $('.select2-karigar');
    if ($karigarSelect.length && (!$karigarSelect.data('select2'))) {
        $karigarSelect.select2({ placeholder: '----Select Karigar----', allowClear: true, width: '100%' });
    }

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
    $(document).on('keypress', '#karigar-jama-form .kj-numeric', function(ev) {
        var k = ev.which || ev.keyCode;
        if (k <= 0 || ev.ctrlKey || ev.metaKey || ev.altKey) return;
        if (k === 8 || k === 9 || k === 46) return;
        if (k === 45) { if (this.value.length > 0 || this.selectionStart > 0) ev.preventDefault(); return; }
        if (k === 46) { if (this.value.indexOf('.') >= 0) ev.preventDefault(); return; }
        if (k < 48 || k > 57) ev.preventDefault();
    });
    $(document).on('input paste', '#karigar-jama-form .kj-numeric', function() { sanitizeNumericInput(this); });
});
</script>
<script>
(function(){
    function parseNum(val) {
        var n = parseFloat(String(val).replace(/,/g, ''));
        return isNaN(n) ? 0 : n;
    }
    function updateJamaTotals() {
        var totalFine = 0, totalAmt = 0;
        $('#lines-container .line-block').each(function(){
            var $block = $(this);
            var net = parseNum($block.find('input[placeholder="Net"]').val());
            var touch = parseNum($block.find('input[placeholder="Touch%"]').val());
            totalFine += (touch / 100) * net;
            $block.find('input[name*="[stone_amount]"]').each(function(){ totalAmt += parseNum($(this).val()); });
        });
        $('#jama-total-fine-wt').text(totalFine.toFixed(3));
        $('#jama-total-amount').text(totalAmt.toFixed(2));
    }
    var lineIdx = <?php echo count($lines); ?>;
    $('#add-line-btn').on('click', function(){
        var html = '<div class="line-block panel panel-default" data-idx="'+lineIdx+'"><div class="panel-body">';
        html += '<div class="row form-group"><div class="col-sm-1"><input type="text" name="lines['+lineIdx+'][sr_no]" class="form-control input-sm kj-numeric" placeholder="Sr" /></div>';
        html += '<div class="col-sm-1"><input type="text" name="lines['+lineIdx+'][order_no]" class="form-control input-sm kj-numeric" placeholder="Order No" /></div>';
        html += '<div class="col-sm-1"><input type="text" name="lines['+lineIdx+'][customer_name]" class="form-control input-sm" placeholder="Customer" /></div>';
        html += '<div class="col-sm-2"><input type="text" name="lines['+lineIdx+'][item_name]" class="form-control input-sm" placeholder="Item" /></div>';
        html += '<div class="col-sm-1"><select name="lines['+lineIdx+'][carat]" class="form-control input-sm"><option value="">Carat</option><option value="22K">22K</option><option value="18K">18K</option><option value="14K">14K</option></select></div>';
        html += '<div class="col-sm-1"><input type="text" name="lines['+lineIdx+'][psc]" class="form-control input-sm kj-numeric" placeholder="Psc" /></div>';
        html += '<div class="col-sm-1"><input type="text" name="lines['+lineIdx+'][gross_wt]" class="form-control input-sm kj-numeric" placeholder="Gross" /></div>';
        html += '<div class="col-sm-1"><input type="text" name="lines['+lineIdx+'][net_wt]" class="form-control input-sm kj-numeric" placeholder="Net" /></div>';
        html += '<div class="col-sm-1"><input type="text" name="lines['+lineIdx+'][touch_pct]" class="form-control input-sm kj-numeric" placeholder="Touch%" /></div>';
        html += '<div class="col-sm-1"><input type="text" name="lines['+lineIdx+'][remark]" class="form-control input-sm" placeholder="Remark" /></div>';
        html += '<div class="col-sm-1"><button type="button" class="btn btn-danger btn-sm btn-remove-line">Remove</button></div></div>';
        html += '<div class="small mt-2"><div class="row margin-bottom-5"><div class="col-sm-2"><strong>Stone/Diamond/Other:</strong></div><div class="col-sm-2"><strong>Item</strong></div><div class="col-sm-2"><strong>Weight</strong></div><div class="col-sm-2"><strong>Amount</strong></div><div class="col-sm-2"><button type="button" class="btn btn-xs btn-primary btn-add-stone">+ Add stone</button></div></div>';
        html += '<div class="stone-rows" data-line-idx="'+lineIdx+'"><div class="row stone-row margin-bottom-5"><div class="col-sm-2"></div><div class="col-sm-2"><input type="text" name="lines['+lineIdx+'][stones][0][item]" class="form-control input-sm" placeholder="Item" /></div><div class="col-sm-2"><input type="text" name="lines['+lineIdx+'][stones][0][stone_wt]" class="form-control input-sm kj-numeric" placeholder="Wt" /></div><div class="col-sm-2"><input type="text" name="lines['+lineIdx+'][stones][0][stone_amount]" class="form-control input-sm kj-numeric" placeholder="Amt" /></div><div class="col-sm-2"><button type="button" class="btn btn-xs btn-danger btn-remove-stone">Remove</button></div></div></div></div></div></div></div></div></div></div></div>';
        $('#lines-container').append(html);
        lineIdx++;
        updateJamaTotals();
    });
    $(document).on('click', '.btn-remove-line', function(){ $(this).closest('.line-block').remove(); updateJamaTotals(); });
    $(document).on('click', '.btn-add-stone', function(){
        var $wrap = $(this).closest('.line-block').find('.stone-rows');
        var idx = $wrap.attr('data-line-idx');
        var stoneIdx = $wrap.find('.stone-row').length;
        var row = '<div class="row stone-row margin-bottom-5"><div class="col-sm-2"></div>';
        row += '<div class="col-sm-2"><input type="text" name="lines['+idx+'][stones]['+stoneIdx+'][item]" class="form-control input-sm" placeholder="Item" /></div>';
        row += '<div class="col-sm-2"><input type="text" name="lines['+idx+'][stones]['+stoneIdx+'][stone_wt]" class="form-control input-sm kj-numeric" placeholder="Wt" /></div>';
        row += '<div class="col-sm-2"><input type="text" name="lines['+idx+'][stones]['+stoneIdx+'][stone_amount]" class="form-control input-sm kj-numeric" placeholder="Amt" /></div>';
        row += '<div class="col-sm-2"><button type="button" class="btn btn-xs btn-danger btn-remove-stone">Remove</button></div></div>';
        $wrap.append(row);
        updateJamaTotals();
    });
    $(document).on('click', '.btn-remove-stone', function(){
        var $rows = $(this).closest('.stone-rows').find('.stone-row');
        if ($rows.length > 1) { $(this).closest('.stone-row').remove(); updateJamaTotals(); }
    });
    $('#lines-container').on('input change', 'input[placeholder="Net"], input[placeholder="Touch%"], input[name*="[stone_amount]"]', updateJamaTotals);
    updateJamaTotals();
})();
</script>
