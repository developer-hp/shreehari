<div class="content-header">
    <div class="row">
        <div class="col-sm-6">
            <div class="header-section">
                <h1>Manage Inwards</h1>
            </div>
        </div>
        <div class="col-sm-6 hidden-xs">
            <div class="header-section">
                <ul class="breadcrumb breadcrumb-top">
                    <li><?php echo CHtml::link('Manage Supllier', array('list_supplier')) ?></li>
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
                <h2>Manage Inwards</h2>
            </div>
             <div id="errorMsg1" class="errorMsg1" style="border-radius: 10px; line-height: 1px;" ></div>
            <!-- END Partial Responsive Title -->
            <?php if (Yii::app()->user->hasFlash('success')): ?>
                <div class="alert alert-success alert-dismissable">
                    <p><?php echo Yii::app()->user->getFlash('success'); ?></p>
                </div>
            <?php endif; ?>
            <?php // echo CHtml::button('Delete', array('id' => 'btnDelete', 'class' => 'btn btn-effect-ripple btn-danger')); ?>
            <?php 

            $loginuser = User::model()->findByPk(Yii::app()->user->id);
            echo CHtml::link('Add', array('create'), array('class' => 'btn btn-effect-ripple btn-info')); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'inward-grid',
	'dataProvider'=>$model->search(),
	'itemsCssClass' => 'table table-striped table-bordered table-vcenter table-responsive',
	'filter'=>$model,
	'columns'=>array(
		'id',
		'customer_id',
		'bill_no',
		'bill_date',
		'gross_wt',
		'net_wt',
		/*
		'fine_wt',
		'other_wt',
		'gold_amount',
		'other_amount',
		'note',
		'created_date',
		'updated_date',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
</div>
</div>
</div>

