<div class="content-header">
    <div class="row">
        <div class="col-sm-6">
            <div class="header-section">
                <h1>Subitem Type</h1>
            </div>
        </div>
        <div class="col-sm-6 hidden-xs">
            <ul class="breadcrumb breadcrumb-top">
                <li><?php echo CHtml::link('Subitem Types', array('subitemType/admin')); ?></li>
                <li>View</li>
            </ul>
        </div>
    </div>
</div>
<div class="block">
    <div class="block-title"><h2><?php echo CHtml::encode($model->name); ?></h2></div>
    <p><strong>ID:</strong> <?php echo $model->id; ?></p>
    <p><strong>Name:</strong> <?php echo CHtml::encode($model->name); ?></p>
    <p><strong>Sort order:</strong> <?php echo $model->sort_order; ?></p>
    <p><?php echo CHtml::link('Edit', array('update', 'id' => $model->id), array('class' => 'btn btn-success')); ?>
       <?php echo CHtml::link('Back', array('admin'), array('class' => 'btn btn-default')); ?></p>
</div>
