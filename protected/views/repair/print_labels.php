<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>
<div class="row">
    <div class="col-md-12">
        <!-- Horizontal Form Block -->
        <div class="block">
            <!-- Horizontal Form Title -->
            <div class="block-title">
                <h2><?php echo $model->isNewRecord ? 'Print Sticker' : 'Print Sticker'; ?> </h2>
            </div>
            <?php
            $form = $this->beginWidget('CActiveForm', array(
                'id' => 'diamond-form',
                // 'enableAjaxValidation' => true,
                'htmlOptions' => array('class' => 'form-horizontal','enctype'=>'multipart/form-data'),
                'clientOptions' => array(
                    'validateOnSubmit' => true,
                ),
                'errorMessageCssClass' => 'help-block animation-slideUp form-error',
                    // Please note: When you enable ajax validation, make sure the corresponding
                    // controller action is handling ajax validation correctly.
                    // There is a call to performAjaxValidation() commented in generated controller code.
                    // See class documentation of CActiveForm for details on this.
            ));
            ?>
            <div class="row">
            	<div class="col-md-12">
		            <div class="form-group">
		                <?php echo $form->labelEx($model, 'ref_no', array('class' => 'col-md-2 control-label')); ?>
		                <div class="col-md-6">
		                    <?php 
		                    echo $form->dropDownList($model, 'ref_no',array(), array('class' => 'form-control','prompt'=>'Select Code','multiple'=>true)); 
		                	?>
		                    <?php echo $form->error($model, 'ref_no'); ?>
		                </div>

		                

		            </div>
		        </div>
		    </div>
		    
	<div class="form-group form-actions">
                <div class="col-md-9 col-md-offset-3">
                    <?php echo CHtml::link('Cancel', array('index'), array('class' => 'btn btn-effect-ripple btn-danger')) ?>
                    <?php echo CHtml::submitButton('Print', array('class' => 'btn btn-effect-ripple btn-default','name'=>'print')); ?>
                </div>
            </div>

            <?php $this->endWidget(); ?>

        </div><!-- form -->
    </div>
</div>



<script type="text/javascript">
	
	$(document).ready(function(){

		$('body').on('click','.add-button',function(){
			var h = $('.add-more').html().replace('item-ele','item');
			$('.items').append(h);
		})

		$('body').on('click','.remove',function(){
			$(this).closest('.block').remove();
		})

		 $('input,select').on("keypress", function(e) {
            /* ENTER PRESSED*/
            if (e.keyCode == 13) {
                /* FOCUS ELEMENT */
                var inputs = $(this).parents("form").eq(0).find(":input");
                var idx = inputs.index(this);

                if (idx == inputs.length - 1) {
                    inputs[0].select()
                } else {
                    inputs[idx + 1].focus(); //  handles submit buttons
                    inputs[idx + 1].select();
                }
                return false;
            }
        });
		// $('.change-text').mask('##0.00', {reverse: true});
	})




</script>

<script type="text/javascript">
  $(function() {
    
    $("#Orderbooks_ref_no").select2({
	    minimumInputLength: 2,
	    language: {
	        inputTooShort: function () {
	            return "<?php echo 'Please enter 2 or more characters'; ?>"
	        }
	    },
	    tags: false,
	    ajax: {
	        url: '<?php echo Yii::app()->createUrl('orderbooks/list'); ?>',
	        dataType: 'json',
	        type: 'POST',
	        data: function (term) {
	            return {
	                term: term
	            };
	        },
	        processResults: function (data) {
	            console.log(data);
	            return {
	                results: $.map(data, function (item) {
	                    return {
	                        text: item.code,
	                        slug: item.slug,
	                        id: item.id
	                    }
	                })
	            };
	        }
	    }
	});
});
</script>

