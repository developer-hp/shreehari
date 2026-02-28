<div class="content-header">
    <div class="row">
        <div class="col-sm-6">
            <div class="header-section">
                <h1>Karigar Voucher</h1>
            </div>
        </div>
        <div class="col-sm-6 hidden-xs">
            <ul class="breadcrumb breadcrumb-top">
                <li><?php echo CHtml::link('Dashboard', array('site/index')); ?></li>
                <li><?php echo CHtml::link('Karigar Voucher', array('karigarJama/index')); ?></li>
            </ul>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <div class="block-title"><h2>Karigar Vouchers</h2></div>
            <?php echo CHtml::link('Add Karigar Voucher', array('create'), array('class' => 'btn btn-effect-ripple btn-info')); ?>
            <?php
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'karigar-jama-grid',
                'dataProvider' => $model->search(),
                'filter' => $model,
                'itemsCssClass' => 'table table-striped table-bordered table-vcenter',
                'columns' => array(
                    array('name' => 'voucher_number', 'value' => 'CHtml::encode($data->voucher_number)'),
                    array('name' => 'voucher_date', 'value' => '!empty($data->voucher_date) ? date("d-m-Y", strtotime($data->voucher_date)) : ""'),
                    array('name' => 'sr_no', 'value' => 'CHtml::encode($data->sr_no)'),
                    array('name' => 'karigar_name', 'value' => 'isset($data->karigar) ? $data->karigar->name : ""'),
                    array('name' => 'total_fine_wt', 'value' => 'number_format((float)$data->total_fine_wt, 3)', 'htmlOptions' => array('class' => 'text-right')),
                    array('name' => 'total_amount', 'value' => 'number_format((float)$data->total_amount, 2)', 'htmlOptions' => array('class' => 'text-right')),
                    array(
                        'name' => 'is_locked',
                        'value' => '$data->is_locked == 1 ? "<span class=\"label label-warning\"><i class=\"fa fa-lock\"></i> Locked</span>" : ""',
                        'type' => 'raw',
                        'htmlOptions' => array('style' => 'text-align: center;'),
                    ),
                    array(
                        'class' => 'ButtonColumn',
                        'htmlOptions' => array('style' => 'width: 200px;text-align: center;'),
                        'template' => '{view} {pdf} {update} {delete}',
                        'buttons' => array(
                            'view' => array('label' => '<i class="fa fa-eye"></i>', 'imageUrl' => false, 'url' => 'Yii::app()->createUrl("karigarJama/view", array("id"=>$data->id))', 'options' => array('class' => 'btn btn-sm btn-warning')),
                            'pdf' => array('label' => '<i class="fa fa-file-pdf-o"></i>', 'imageUrl' => false, 'url' => 'Yii::app()->createUrl("karigarJama/pdf", array("id"=>$data->id))', 'options' => array('class' => 'btn btn-sm btn-primary', 'title' => 'Download PDF')),
                            'update' => array(
                                'label' => '<i class="fa fa-pencil"></i>', 
                                'imageUrl' => false, 
                                'url' => 'Yii::app()->createUrl("karigarJama/update", array("id"=>$data->id))', 
                                'options' => array('class' => 'btn btn-sm btn-success'),
                                'visible' => '$data->is_locked != 1',
                            ),
                            'delete' => array(
                                'label' => '<i class="fa fa-trash"></i>', 
                                'imageUrl' => false, 
                                'options' => array('class' => 'btn btn-sm btn-danger'),
                                'visible' => '$data->is_locked != 1',
                            ),
                        ),
                    ),
                ),
            ));
            ?>
        </div>
    </div>
</div>
