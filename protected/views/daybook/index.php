<div class="content-header">
    <div class="row">
        <div class="col-sm-6">
            <div class="header-section">
                <h1>Day Book</h1>
            </div>
        </div>
        <div class="col-sm-6 hidden-xs">
            <ul class="breadcrumb breadcrumb-top">
                <li><?php echo CHtml::link('Dashboard', array('site/index')); ?></li>
                <li>Day Book</li>
            </ul>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="block block-condensed">
            <div class="block-content">
                <form method="get" action="<?php echo Yii::app()->createUrl('daybook/index'); ?>" class="form-inline">
                    <label for="daybook-date" class="control-label">Date :</label>
                    <input type="date" id="daybook-date" name="date" value="<?php echo CHtml::encode($selectedDate); ?>" class="form-control" style="width:170px; margin: 0 8px;" />
                    <button type="submit" class="btn btn-primary">Show</button>
                    <a href="<?php echo Yii::app()->createUrl('daybook/print', array('date' => $selectedDate)); ?>" class="btn btn-default" target="_blank" style="margin-left: 8px;">
                        <i class="fa fa-print"></i> Print
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="block">
            <div class="block-title">
                <h2>Date : <?php echo CHtml::encode($selectedDateDisplay); ?></h2>
            </div>
            <?php $this->renderPartial('_table', get_defined_vars()); ?>
        </div>
    </div>
</div>
