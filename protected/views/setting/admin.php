<div class="content-header">
    <div class="row">
        <div class="col-sm-6">
            <div class="header-section">
                <h1>Settings</h1>
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
                <h2>Settings</h2>
            </div>
            <?php
            	// echo CHtml::link('NEU',array('create'),array('class'=>'btn btn-effect-ripple btn-success'));

            	// echo CHtml::link('Add New Form',array('create'),array('class'=>'btn btn-effect-ripple btn-info'));
            	
                
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
		'title',
		// 'content',
		array('name'=>'content','type'=>'raw',
			'value'=>function($m){
				if(($m->title=="LOGO" || $m->title=="LOGIN_BACKGROUND" || $m->title=="FAV_ICON") && $m->content)
					return CHtml::image(Yii::app()->baseUrl.'/'.$m->content,'',array('height'=>'100px'));
				return $m->content;
			}
		),
		array(
                        'class' => 'CButtonColumn',
                        'htmlOptions' => array('style' => 'width: 120px;text-align:center'),
                        'template' => '{update} ',
                        'buttons' => array(
                            'view' => array(
                                'label' => '<i class="fa fa-eye"></i>',
                                'imageUrl' => false,
                                'options' => array('class' => 'btn btn-effect-ripple btn-sm btn-success', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Details')),
                                'type' => 'raw',
                            ),
                            'update' => array(
                                'label' => '<i class="fa fa-pencil"></i>',
                                'imageUrl' => false,
                                'options' => array('class' => 'btn btn-effect-ripple btn-sm btn-primary', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'EDIT')),
                                'type' => 'raw',
                            ),
                            'addoutput' => array(
                                'label' => '<i class="fa fa-plus"></i>',
                                'imageUrl' => false,
                                'options' => array('class' => 'btn btn-effect-ripple btn-sm btn-info', 'rel' => 'tooltip', 'data-toggle' => 'tooltip', 'title' => Yii::t('app', 'Add Output Text')),
                                'type' => 'raw',
                                'url' => function($data) {
                                    return Yii::app()->createUrl("forms/addoutput", array("id" => $data->id));
                                }
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
