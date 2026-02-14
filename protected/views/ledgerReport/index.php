<?php $title = 'Ledger Report'; ?>
<div class="content-header">
    <div class="row">
        <div class="col-sm-6">
            <div class="header-section">
                <h1><?php echo $title; ?></h1>
            </div>
        </div>
        <div class="col-sm-6 hidden-xs">
            <ul class="breadcrumb breadcrumb-top">
                <li><?php echo CHtml::link('Dashboard', array('site/index')); ?></li>
                <li><?php echo $title; ?></li>
            </ul>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="block">
            <div class="block-title">
                <h2><?php echo $title; ?> (Opening Balance + Issue Entry)</h2>
            </div>
            <form method="get" action="<?php echo Yii::app()->createUrl('ledgerReport/report'); ?>" id="ledger-report-form" class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-3 control-label">Customer</label>
                    <div class="col-sm-6">
                        <select name="customer_id" class="form-control select2-ledger-customer">
                            <option value="">-- All customers --</option>
                            <?php
                            $customers = Customer::model()->findAll(array('condition' => 'is_deleted = 0 AND type IN (1, 3)', 'order' => 'name'));
                            foreach ($customers as $c) {
                                echo '<option value="' . (int)$c->id . '">' . CHtml::encode($c->name) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Issue Date From</label>
                    <div class="col-sm-6">
                        <input type="text" name="from_date" class="form-control input-datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" autocomplete="off">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Issue Date To</label>
                    <div class="col-sm-6">
                        <input type="text" name="to_date" class="form-control input-datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" autocomplete="off">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-6">
                        <button type="submit" class="btn btn-info"><i class="fa fa-eye"></i> View Report</button>
                        <a href="javascript:void(0)" id="ledger-download-pdf" class="btn btn-primary"><i class="fa fa-file-pdf-o"></i> Download PDF</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
$(function() {
    $('.select2-ledger-customer').select2({ placeholder: '-- All customers --', allowClear: true, width: '100%' });
    $('#ledger-download-pdf').on('click', function() {
        var form = $('#ledger-report-form');
        var action = form.attr('action');
        var pdfUrl = '<?php echo Yii::app()->createUrl("ledgerReport/pdf"); ?>?' + form.serialize();
        window.location.href = pdfUrl;
    });
});
</script>
