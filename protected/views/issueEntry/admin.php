<div class="content-header">
    <div class="row">
        <div class="col-sm-6">
            <div class="header-section">
                <h1>Issue Entry</h1>
            </div>
        </div>
        <div class="col-sm-6 hidden-xs">
            <div class="header-section">
                <ul class="breadcrumb breadcrumb-top">
                    <li><?php echo CHtml::link('Dashboard', array('site/index')); ?></li>
                    <li>Issue Entry</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <div class="block-title">
                <h2>Manage Issue Entry</h2>
            </div>
            <?php if (Yii::app()->user->hasFlash('success')): ?>
                <div class="alert alert-success alert-dismissable">
                    <p><?php echo Yii::app()->user->getFlash('success'); ?></p>
                </div>
            <?php endif; ?>
            <?php echo CHtml::link('Add Issue Entry', array('create'), array('class' => 'btn btn-effect-ripple btn-info')); ?>

            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'issue-entry-grid',
                'dataProvider' => $model->search(),
                'itemsCssClass' => 'table table-striped table-bordered table-vcenter table-responsive',
                'filter' => $model,
                'columns' => array(
                    'sr_no',
                    array(
                        'name' => 'issue_date',
                        'value' => '!empty($data->issue_date) ? date("d-m-Y", strtotime($data->issue_date)) : ""',
                    ),
                    array(
                        'name' => 'customer_name',
                        'type' => 'raw',
                        'value' => 'isset($data->customer) ? CHtml::link(CHtml::encode($data->customer->name), array("ledgerReport/report", "customer_id" => $data->customer_id), array("class" => "link_blue")) : ""',
                    ),
                    'carat',
                    'weight',
                    'fine_wt',
                    'amount',
                    array(
                        'name' => 'created_at',
                        'value' => '!empty($data->created_at) ? date("d-m-Y", strtotime($data->created_at)) : ""',
                    ),
                    array(
                        'class' => 'ButtonColumn',
                        'header' => 'Actions',
                        'htmlOptions' => array('style' => 'width: 120px; text-align: center;'),
                        'template' => '{pdf} {update} {delete}',
                        'deleteConfirmation' => 'Are you sure you want to delete this issue entry?',
                        'buttons' => array(
                            'pdf' => array(
                                'label' => '<i class="fa fa-file-pdf-o"></i>',
                                'imageUrl' => false,
                                'options' => array('class' => 'btn btn-effect-ripple btn-sm btn-primary', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => 'Download PDF', 'target' => '_blank'),
                                'type' => 'raw',
                                'url' => 'Yii::app()->createUrl("issueEntry/pdf", array("id" => $data->id))',
                            ),
                            'update' => array(
                                'label' => '<i class="fa fa-pencil"></i>',
                                'imageUrl' => false,
                                'options' => array('class' => 'btn btn-effect-ripple btn-sm btn-success', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Edit')),
                                'type' => 'raw',
                                'url' => 'Yii::app()->createUrl("issueEntry/update", array("id" => $data->id))',
                                'visible' => 'LedgerAccess::canEditIssueEntry($data)',
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
