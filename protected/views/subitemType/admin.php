<div class="content-header">
    <div class="row">
        <div class="col-sm-6">
            <div class="header-section">
                <h1>Subitem Types (Charge Types)</h1>
            </div>
        </div>
        <div class="col-sm-6 hidden-xs">
            <ul class="breadcrumb breadcrumb-top">
                <li><?php echo CHtml::link('Dashboard', array('site/index')); ?></li>
                <li>Subitem Types</li>
            </ul>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <div class="block-title"><h2>Manage Charge Types</h2></div>
            <?php if (Yii::app()->user->hasFlash('success')): ?>
                <div class="alert alert-success alert-dismissable"><p><?php echo Yii::app()->user->getFlash('success'); ?></p></div>
            <?php endif; ?>
            <?php echo CHtml::link('Add Subitem Type', array('create'), array('class' => 'btn btn-effect-ripple btn-info')); ?>
            <?php
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'subitem-type-grid',
                'dataProvider' => $model->search(),
                'filter' => $model,
                'itemsCssClass' => 'table table-striped table-bordered table-vcenter',
                'columns' => array(
                    'id',
                    'name',
                    'sort_order',
                    array(
                        'class' => 'ButtonColumn',
                        'template' => '{update} {delete}',
                        'buttons' => array(
                            'update' => array('label' => '<i class="fa fa-pencil"></i>', 'imageUrl' => false, 'url' => 'Yii::app()->createUrl("subitemType/update", array("id"=>$data->id))', 'options' => array('class' => 'btn btn-sm btn-success')),
                            'delete' => array('label' => '<i class="fa fa-trash"></i>', 'imageUrl' => false, 'options' => array('class' => 'btn btn-sm btn-danger')),
                        ),
                    ),
                ),
            ));
            ?>
        </div>
    </div>
</div>
