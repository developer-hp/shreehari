<div class="content-header">
    <div class="row">
        <div class="col-sm-6">
            <div class="header-section">
                <h1>Account Opening Balance</h1>
            </div>
        </div>
        <div class="col-sm-6 hidden-xs">
            <div class="header-section">
                <ul class="breadcrumb breadcrumb-top">
                    <li><?php echo CHtml::link('Dashboard', array('site/index')); ?></li>
                    <li>Account Opening Balance</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <div class="block-title">
                <h2>Manage Account Opening Balance</h2>
            </div>
            <?php if (Yii::app()->user->hasFlash('success')): ?>
                <div class="alert alert-success alert-dismissable">
                    <p><?php echo Yii::app()->user->getFlash('success'); ?></p>
                </div>
            <?php endif; ?>
            <?php echo CHtml::link('Add Opening Balance', array('create'), array('class' => 'btn btn-effect-ripple btn-info')); ?>

            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'account-opening-balance-grid',
                'dataProvider' => $model->search(),
                'itemsCssClass' => 'table table-striped table-bordered table-vcenter table-responsive',
                'filter' => $model,
                'columns' => array(
                    array(
                        'name' => 'customer_name',
                        'type' => 'raw',
                        'value' => 'isset($data->customer) ? CHtml::link(CHtml::encode($data->customer->name), array("ledgerReport/report", "customer_id" => $data->customer_id), array("class" => "link_blue")) : ""',
                    ),
                    'opening_fine_wt',
                    array(
                        'name' => 'opening_fine_wt_drcr',
                        'value' => '$data->opening_fine_wt_drcr == 1 ? "DR" : "CR"',
                        'filter' => array(1 => 'DR', 2 => 'CR'),
                    ),
                    'opening_amount',
                    array(
                        'name' => 'opening_amount_drcr',
                        'value' => '$data->opening_amount_drcr == 1 ? "DR" : "CR"',
                        'filter' => array(1 => 'DR', 2 => 'CR'),
                    ),
                    array(
                        'name' => 'created_at',
                        'value' => '!empty($data->created_at) ? date("d-m-Y", strtotime($data->created_at)) : ""',
                    ),
                    array(
                        'class' => 'ButtonColumn',
                        'header' => 'Actions',
                        'htmlOptions' => array('style' => 'width: 120px; text-align: center;'),
                        'template' => '{update} {delete}',
                        'deleteConfirmation' => 'Are you sure you want to delete this opening balance?',
                        'buttons' => array(
                            'update' => array(
                                'label' => '<i class="fa fa-pencil"></i>',
                                'imageUrl' => false,
                                'options' => array('class' => 'btn btn-effect-ripple btn-sm btn-success', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Edit')),
                                'type' => 'raw',
                                'url' => 'Yii::app()->createUrl("accountOpeningBalance/update", array("id" => $data->id))',
                            ),
                            'delete' => array(
                                'label' => '<i class="fa fa-trash"></i>',
                                'imageUrl' => false,
                                'options' => array('class' => 'btn btn-effect-ripple btn-sm btn-danger', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Delete')),
                            ),
                        ),
                    ),
                ),
            )); ?>
        </div>
    </div>
</div>
