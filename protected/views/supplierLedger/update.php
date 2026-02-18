<div class="content-header">
    <div class="row">
        <div class="col-sm-6">
            <div class="header-section">
                <h1>Edit Supplier Voucher</h1>
            </div>
        </div>
        <div class="col-sm-6 hidden-xs">
            <ul class="breadcrumb breadcrumb-top">
                <li><?php echo CHtml::link('Supplier Voucher', array('supplierLedger/index')); ?></li>
                <li>Update</li>
            </ul>
        </div>
    </div>
</div>
<div class="block block-fullwidth">
    <div class="block-title"><h2>Voucher #<?php echo $model->id; ?></h2></div>
    <?php $this->renderPartial('_form', array('model' => $model)); ?>
</div>
