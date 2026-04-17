<div class="content-header">
    <div class="row">
        <div class="col-sm-6">
            <div class="header-section">
                <h1>Issue Entry <?php echo CHtml::encode($model->sr_no); ?></h1>
            </div>
        </div>
        <div class="col-sm-6 hidden-xs">
            <ul class="breadcrumb breadcrumb-top">
                <li><?php echo CHtml::link('Dashboard', array('site/index')); ?></li>
                <li><?php echo CHtml::link('Issue Entry', array('index')); ?></li>
                <li>View</li>
            </ul>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <div class="block-title"><h2>Entry Details</h2></div>
            <p>
                <?php if (LedgerAccess::canEditIssueEntry($model)): ?>
                    <?php echo CHtml::link('<i class="fa fa-pencil"></i> Edit', array('update', 'id' => $model->id), array('class' => 'btn btn-success')); ?>
                <?php endif; ?>
                <?php echo CHtml::link('<i class="fa fa-file-pdf-o"></i> Download PDF', array('pdf', 'id' => $model->id), array('class' => 'btn btn-primary', 'target' => '_blank')); ?>
                <?php echo CHtml::link('<i class="fa fa-print"></i> Print', array('print', 'id' => $model->id), array('class' => 'btn btn-default', 'target' => '_blank')); ?>
                <?php echo CHtml::link('Back to list', array('index'), array('class' => 'btn btn-default')); ?>
            </p>

            <?php
            $drcrOptions = IssueEntry::getDrcrOptions();
            $createdByName = '';
            if (!empty($model->created_by)) {
                $createdByModel = User::model()->findByPk((int) $model->created_by);
                $createdByName = $createdByModel ? $createdByModel->name : $model->created_by;
            }
            ?>

            <?php $this->widget('zii.widgets.CDetailView', array(
                'data' => $model,
                'htmlOptions' => array('class' => 'table table-striped table-bordered table-vcenter'),
                'attributes' => array(
                    array('name' => 'sr_no', 'label' => 'Voucher No'),
                    array('name' => 'issue_date', 'value' => !empty($model->issue_date) ? date('d-m-Y', strtotime($model->issue_date)) : '—'),
                    array('name' => 'customer_id', 'label' => 'Account', 'type' => 'raw', 'value' => isset($model->customer) ? CHtml::link(CHtml::encode($model->customer->name), array('ledgerReport/report', 'customer_id' => $model->customer_id), array('target' => '_blank')) : '—'),
                    array('name' => 'carat', 'value' => $model->carat !== '' ? $model->carat : '—'),
                    array('name' => 'weight', 'value' => $model->weight !== null && $model->weight !== '' ? number_format((float) $model->weight, 3) : '—'),
                    array('name' => 'fine_wt', 'label' => 'Fine Wt', 'value' => $model->fine_wt !== null && $model->fine_wt !== '' ? number_format((float) $model->fine_wt, 3) : '—'),
                    array('name' => 'amount', 'value' => $model->amount !== null && $model->amount !== '' ? number_format((float) $model->amount, 2) : '—'),
                    array('name' => 'drcr', 'label' => 'Entry Type', 'value' => isset($drcrOptions[$model->drcr]) ? $drcrOptions[$model->drcr] : '—'),
                    array('name' => 'remarks', 'value' => $model->remarks !== '' ? $model->remarks : '—'),
                    array('name' => 'created_at', 'label' => 'Created At', 'value' => !empty($model->created_at) ? date('d-m-Y H:i', strtotime($model->created_at)) : '—'),
                    array('name' => 'created_by', 'label' => 'Created By', 'value' => $createdByName !== '' ? $createdByName : '—'),
                ),
            )); ?>
        </div>
    </div>
</div>
