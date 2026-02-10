<div class="content-header">
    <div class="row">
        <div class="col-sm-6">
            <div class="header-section">
                <h1>Manage Orderbooks</h1>
            </div>
        </div>
        <div class="col-sm-6 hidden-xs">
            <div class="header-section">
                <ul class="breadcrumb breadcrumb-top">
                    <li><?php echo CHtml::link('Orderbooks', array('index')) ?></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <!-- Partial Responsive Block -->
        <div class="block">
            <!-- Partial Responsive Title -->
            <div class="block-title">
                <h2>Manage Order books</h2>
            </div>
            <!-- END Partial Responsive Title -->
            <?php if (Yii::app()->user->hasFlash('success')): ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><strong>Success</strong></h4>
                    <p><?php echo Yii::app()->user->getFlash('success'); ?></p>
                </div>
            <?php endif; ?>
            <?php
                echo CHtml::link('+Add',array('create'),array('class'=>'btn btn-effect-ripple btn-success'));

                // echo CHtml::link('Reference',array('estimate/pay'),array('class'=>'btn btn-effect-ripple btn-primary'));
            ?>
            <div class="table-responsive">
<?php 

$loginuser = User::model()->findByPk(Yii::app()->user->id);
 $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'orderbooks-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'pager' => array(
                    'header' => '',
                ),
    'itemsCssClass' => 'table table-striped table-bordered table-vcenter',
	'columns'=>array(
		// 'id',
		'ref_no',
		'name',
		'mobile',
		'date',
		'delivery_date',
        'remarks',
		array(
                        'class' => 'CButtonColumn',
                        'htmlOptions' => array('style' => 'width: 120px;text-align:center;'),
                        'template' => '{pdf} {update} {delete} ',
                        'buttons' => array(
                            'pdf' => array(
                                'label' => '<i class="fa fa-print"></i>',
                                'imageUrl' => false,
                                'options' => array('class' => 'btn btn-effect-ripple btn-sm btn-default', 'rel' => 'tooltip', 'data-toggle' => 'tooltip','target'=>'_blank', 'title' => Yii::t('app', 'Print')),
                                'type' => 'raw',
                                'url' => function($data) {
                                    return Yii::app()->createUrl("orderbooks/pdf", array("id" => $data->id));
                                }
                                // 'visible' => function($data) use($loginuser){
                                //         return ($loginuser->user_type==1) ? true : false;
                                // },
                            ),
                            'update' => array(
                                'label' => '<i class="fa fa-pencil"></i>',
                                'imageUrl' => false,
                                'options' => array('class' => 'btn btn-effect-ripple btn-sm btn-success', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Update')),
                                'type' => 'raw',
                                // 'visible' => function($data) use($loginuser){
                                //         return ($loginuser->user_type==1) ? true : false;
                                // },
                            ),
                            'delete' => array(
                                'label' => '<i class="fa fa-trash-o"></i>',
                                'imageUrl' => false,
                                'options' => array('class' => 'btn btn-effect-ripple btn-sm btn-danger', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Delete')),
                                'type' => 'raw',
                                'visible' => function($data) use($loginuser){
                                        return ($loginuser->user_type==1) ? true : false;
                                },
                            ),
                        ),
                    ),
	),
)); ?>
</div>
</div>
</div>
</div>