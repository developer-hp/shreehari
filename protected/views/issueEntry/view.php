<div class="content-header">
    <div class="row">
        <div class="col-sm-6">
            <div class="header-section">
                <h1>Issue Entry <?php echo CHtml::encode($model->sr_no); ?></h1>
            </div>
        </div>
        <div class="col-sm-6 hidden-xs">
            <ul class="breadcrumb breadcrumb-top">
                <li><?php echo CHtml::link('Issue Entry', array('index')); ?></li>
                <li>View</li>
            </ul>
        </div>
    </div>
</div>
<div class="block">
    <div class="block-title"><h2>Details</h2></div>
    <?php echo CHtml::link('Edit', array('update', 'id' => $model->id), array('class' => 'btn btn-info')); ?>
    <?php echo CHtml::link('Back to list', array('index'), array('class' => 'btn btn-default')); ?>

    <?php $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'attributes' => array(
            'id',
            'sr_no',
            array('name' => 'issue_date', 'value' => !empty($model->issue_date) ? date('d-m-Y', strtotime($model->issue_date)) : ''),
            array('name' => 'customer_id', 'value' => isset($model->customer) ? $model->customer->name : $model->customer_id),
            'fine_wt',
            'amount',
            array('name' => 'drcr', 'value' => function($model) {
                $drcrOptions = IssueEntry::getDrcrOptions();
                return isset($drcrOptions[$model->drcr]) ? $drcrOptions[$model->drcr] : '';
            }),
            'remarks',
            array('name' => 'created_at', 'value' => !empty($model->created_at) ? date('d-m-Y H:i', strtotime($model->created_at)) : ''),
            'created_by',
            array('name' => 'is_deleted', 'value' => $model->is_deleted ? 'Yes' : 'No'),
        ),
    )); ?>
</div>
