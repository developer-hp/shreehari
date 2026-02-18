<div class="content-header">
    <div class="row">
        <div class="col-sm-6">
            <div class="header-section">
                <h1>View Account Opening Balance #<?php echo $model->id; ?></h1>
            </div>
        </div>
        <div class="col-sm-6 hidden-xs">
            <ul class="breadcrumb breadcrumb-top">
                <li><?php echo CHtml::link('Account Opening Balance', array('index')); ?></li>
                <li>View</li>
            </ul>
        </div>
    </div>
</div>
<div class="block">
    <div class="block-title"><h2>Details</h2></div>
    <?php echo CHtml::link('Update', array('update', 'id' => $model->id), array('class' => 'btn btn-info')); ?>
    <?php echo CHtml::link('Back to list', array('index'), array('class' => 'btn btn-default')); ?>

    <?php $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'attributes' => array(
            'id',
            array(
                'name' => 'customer_id',
                'value' => isset($model->customer) ? $model->customer->name : $model->customer_id,
            ),
            'opening_fine_wt',
            array(
                'name' => 'opening_fine_wt_drcr',
                'value' => function($model) {
                    $drcrOptions = AccountOpeningBalance::getDrcrOptions();
                    return isset($drcrOptions[$model->opening_fine_wt_drcr]) ? $drcrOptions[$model->opening_fine_wt_drcr] : '';
                },
            ),
            'opening_amount',
            array(
                'name' => 'opening_amount_drcr',
                'value' => function($model) {
                    $drcrOptions = AccountOpeningBalance::getDrcrOptions();
                    return isset($drcrOptions[$model->opening_amount_drcr]) ? $drcrOptions[$model->opening_amount_drcr] : '';
                },
            ),
            array(
                'name' => 'is_deleted',
                'value' => $model->is_deleted ? 'Yes' : 'No',
            ),
            'created_at',
            'created_by',
        ),
    )); ?>
</div>
