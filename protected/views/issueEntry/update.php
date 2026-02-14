<div class="content-header">
    <div class="row">
        <div class="col-sm-6">
            <div class="header-section">
                <h1>Update Issue Entry</h1>
            </div>
        </div>
        <div class="col-sm-6 hidden-xs">
            <ul class="breadcrumb breadcrumb-top">
                <li><?php echo CHtml::link('Issue Entry', array('index')); ?></li>
                <li><?php echo CHtml::link($model->sr_no, array('view', 'id' => $model->id)); ?></li>
                <li>Update</li>
            </ul>
        </div>
    </div>
</div>
<div class="block">
    <div class="block-title"><h2>Edit Issue Entry <?php echo CHtml::encode($model->sr_no); ?></h2></div>
    <?php $this->renderPartial('_form', array('model' => $model)); ?>
</div>
