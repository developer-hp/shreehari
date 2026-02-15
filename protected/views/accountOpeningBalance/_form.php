<?php
/* @var $this AccountOpeningBalanceController */
/* @var $model AccountOpeningBalance */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'account-opening-balance-form',
    'enableAjaxValidation' => true,
    'htmlOptions' => array('class' => 'form-horizontal'),
    'clientOptions' => array('validateOnSubmit' => true),
    'errorMessageCssClass' => 'help-block animation-slideUp form-error',
)); ?>


    <?php //echo $form->errorSummary($model); ?>

    <?php
    $c_type = '';
    if (!$model->isNewRecord && $model->customer_id) {
        $cust = Customer::model()->findByPk($model->customer_id);
        $c_type = $cust ? $cust->type : '';
    }
    ?>
    <div class="form-group">
        <label class="col-sm-2 control-label">Account Type</label>
        <div class="col-sm-4">
            <select name="customer_type" class="form-control customer_type">
                <option value="">---Select Account Type---</option>
                <option value="1" <?php if ($c_type == 1) echo 'selected'; ?>>Supplier</option>
                <option value="3" <?php if ($c_type == 3) echo 'selected'; ?>>Karigar</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <?php echo $form->labelEx($model, 'customer_id', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-4">
            <?php
            if (!$model->isNewRecord && $c_type !== '') {
                $customerList = CHtml::listData(
                    Customer::model()->findAll(array('condition' => "is_deleted = 0 AND type = " . (int)$c_type, 'order' => 'name')),
                    'id', 'name'
                );
            } else {
                $customerList = CHtml::listData(
                    Customer::model()->findAll(array('condition' => 'is_deleted = 0 and type in(1,3)', 'order' => 'name')),
                    'id', 'name'
                );
            }
            echo $form->dropDownList($model, 'customer_id', $customerList,
                array('class' => 'form-control customer_list select2-opening-customer', 'prompt' => '----Select Customer----')); ?>
            <?php echo $form->error($model, 'customer_id'); ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'opening_fine_wt', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-4">
            <?php echo $form->textField($model, 'opening_fine_wt', array('class' => 'form-control', 'size' => 20)); ?>
            <?php echo $form->error($model, 'opening_fine_wt'); ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'opening_fine_wt_drcr', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-4">
            <?php echo $form->dropDownList($model, 'opening_fine_wt_drcr', AccountOpeningBalance::getDrcrOptions(), array('class' => 'form-control', 'prompt' => '-- Select --')); ?>
            <?php echo $form->error($model, 'opening_fine_wt_drcr'); ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'opening_amount', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-4">
            <?php echo $form->textField($model, 'opening_amount', array('class' => 'form-control', 'size' => 20)); ?>
            <?php echo $form->error($model, 'opening_amount'); ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'opening_amount_drcr', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-4">
            <?php echo $form->dropDownList($model, 'opening_amount_drcr', AccountOpeningBalance::getDrcrOptions(), array('class' => 'form-control', 'prompt' => '-- Select --')); ?>
            <?php echo $form->error($model, 'opening_amount_drcr'); ?>
        </div>
    </div>

    
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-primary')); ?>
            <?php echo CHtml::link('Cancel', array('index'), array('class' => 'btn btn-default')); ?>
        </div>
    </div>

<?php $this->endWidget(); ?>

</div>

<script type="text/javascript">
$(function() {
    var $customerSelect = $('.select2-opening-customer');
    function initSelect2() {
        if ($customerSelect.data('select2')) $customerSelect.select2('destroy');
        $customerSelect.select2({ placeholder: '----Select Account----', allowClear: true, width: '100%' });
    }
    initSelect2();
    $('body').on('change', '.customer_type', function() {
        var customer_type = $('.customer_type option:selected').val();
        $.ajax({
            url: '<?php echo Yii::app()->createUrl("customer/get_type_customer"); ?>',
            method: 'POST',
            data: { customer_type: customer_type },
            success: function(data) {
                $customerSelect.empty().append(data);
                initSelect2();
            }
        });
    });
});
</script>
