<div class="content-header">
    <div class="row">
        <div class="col-sm-6">
            <div class="header-section">
                <h1>Users</h1>
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
                <h2>Users</h2>
            </div>
            <?php
            	// echo CHtml::link('NEU',array('create'),array('class'=>'btn btn-effect-ripple btn-success'));

            	echo CHtml::link('Add New User',array('user/create'),array('class'=>'btn btn-effect-ripple btn-primary'));
            	
                echo CHtml::link('Send Register Mail',array('site/send'),array('class'=>'btn btn-effect-ripple btn-primary'));
                
            ?>
            <?php if (Yii::app()->user->hasFlash('success')): ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><strong>Success</strong></h4>
                    <p><?php echo Yii::app()->user->getFlash('success'); ?></p>
                </div>
            <?php endif; ?>


            <div class="table-responsive">

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'member-grid',
	'itemsCssClass' => 'table table-striped table-bordered table-vcenter',
	'dataProvider'=>$model->search(),
	'pager' => array(
                    'header' => '',
                ),
	'filter'=>$model,
	'columns'=>array(
		// 'id',
		'name',
		'email',
		// 'password',
		// 'user_type',
		'created_at',
		/*
		'deleted',
		*/
		array(
                        'class' => 'CButtonColumn',
                        'htmlOptions' => array('style' => 'width: 85px;text-align:center'),
                        'template' => '{update} {delete} ',
                        'buttons' => array(
                            'update' => array(
                                'label' => '<i class="fa fa-pencil"></i>',
                                'imageUrl' => false,
                                'options' => array('class' => 'btn btn-effect-ripple btn-sm btn-primary', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'EDIT')),
                                'type' => 'raw',
                            ),
                            'delete' => array(
                                'label' => '<i class="fa fa-trash-o"></i>',
                                'imageUrl' => false,
                                'options' => array('class' => 'btn btn-effect-ripple btn-sm btn-danger', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'DEL')),
                                'type' => 'raw',
                            ),
                        ),
                    ),
	),
)); ?>
</div>
</div>
</div>
