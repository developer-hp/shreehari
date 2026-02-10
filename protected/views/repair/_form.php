

<?php
/* @var $this OrderbooksController */
/* @var $model Orderbooks */
/* @var $form CActiveForm */
$v = 0;
$arr1 = array();
$arr2 = array();
$d = $n = $r = $o =$l = $s=$pcs="";
if(!$model->isNewRecord){
	$arr1 = RepairingItems::model()->findByAttributes(array('order_book_id'=>$model->id));
	if($arr1){
		$arr2 = RepairingItems::model()->findAll(array('condition'=>'order_book_id='.$model->id.' and id<>'.$arr1->id));

		$d = $arr1->description;
		$n = $arr1->nw;
		$r = $arr1->rate;
		$l = $arr1->lc;
		$o = $arr1->oc;		
		$pcs = $arr1->pcs;		
		$s = $arr1->size;		
	}
}

?>
<style type="text/css">
	.form-horizontal .block .form-group{
		margin-right: 0px !important;
	}
</style>

<div class="row">
	<div class="col-md-12">
		<!-- Horizontal Form Block -->
		<div class="block">
			<!-- Horizontal Form Title -->
			<div class="block-title">
				<ul class="nav nav-tabs" data-toggle="tabs">
					<li class="<?php echo ($v==0) ? 'active' : ''?>"><a href="#block-tabs-home"><?php echo Yii::t('yii','REPAIR FORM');?></a></li>
					<!-- <li class="<?php echo ($v==1) ? 'active' : ''?>"><a href="#block-tabs-profile">REPARING FORM</a></li> -->

				</ul>
			</div>


			<div class="tab-content">
				<div class="tab-pane <?php echo ($v==0) ? 'active' : ''?>"" id="block-tabs-home">



					<?php $form=$this->beginWidget('CActiveForm', array(
						'id'=>'orderbooks-form',
						'htmlOptions' => array('class' => 'form-horizontal','enctype'=>'multipart/form-data'),
						'enableAjaxValidation'=>true,
						'clientOptions'=>array('validateOnSubmit'=>true),
						)); ?>


						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<?php echo $form->labelEx($model,'ref_no', array('class' => 'col-md-3 control-label')); ?>
									<div class="col-md-6">
										<?php echo $form->textField($model,'ref_no',array('class' => 'form-control','readOnly'=>true,'size'=>10,'maxlength'=>10)); ?>
										<?php echo $form->error($model,'ref_no'); ?>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<?php echo $form->labelEx($model,'date', array('class' => 'col-md-3 control-label')); ?>
									<div class="col-md-6">
										<?php echo $form->textField($model,'date',array('class' => 'form-control','readOnly'=>true,'size'=>10,'maxlength'=>10)); ?>
										<?php echo $form->error($model,'date'); ?>
									</div>
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="col-md-6">
								<div class="form-group">
									<?php echo $form->labelEx($model,'customer_id', array('class' => 'col-md-3 control-label')); ?>
									<div class="col-md-4">
										<?php echo $form->dropDownList($model,'customer_id',CHtml::listData(Customer::model()->findAll(array("condition"=>"type=2 and is_deleted = 0",'order'=>'name')),'id','name'),
									array(
										'prompt'=>'----Select Customer----',
										'class'=>'form-control',
									)); ?>
										<?php echo $form->error($model,'customer_id'); ?>
									</div>
									<div class="col-md-4">
										<?php echo $form->textField($model,'mobile',array('class' => 'form-control','maxlength'=>12,'placeHolder'=>'Contact Number')); ?>
										<?php echo $form->error($model,'mobile'); ?>
									</div>
								</div>
							</div>
							
							<div class="col-md-6">
								<div class="form-group">
									<?php echo $form->labelEx($model,'delivery_date', array('class' => 'col-md-3 control-label')); ?>
									<div class="col-md-6">
										<?php echo $form->textField($model,'delivery_date',array('class' => 'form-control input-datepicker','data-date-format'=>'dd-mm-yyyy', 'size' => 60, 'maxlength' => 255)); ?>
										<?php echo $form->error($model,'delivery_date'); ?>
									</div>
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="col-md-6">
								<div class="form-group">
									<?php echo $form->labelEx($model,'extra_charge', array('class' => 'col-md-3 control-label')); ?>
									<div class="col-md-6">
										<?php echo $form->textField($model,'extra_charge',array('class' => 'form-control', 'size' => 60)); ?>
										<?php echo $form->error($model,'extra_charge'); ?>
									</div>
								</div>
							</div>
							
						</div>

						<div class="items">
							<button type="button" class="add-button btn btn-primary pull-right">+</button>
							<div class="clearfix"></div>
							<div class="block">
								<div class="row">
									<button type="button" class="btn-sm btn-danger pull-right remove">X</button>
									<button style="margin-right: 5px;" type="button" class="add-button btn btn-primary pull-right">+</button>
									<div class="clearfix"></div>
									
									<div class="col-xs-6 col-lg-8">
										<div class="form-group">
											<label for="ds">Description</label>
											<input type="text" name="description[]" class="form-control" value="<?php echo $d;?>">
										</div>
									</div>
									<div class="col-xs-6 col-lg-2">
										<div class="form-group">
											<label for="nw-email">Net Weight</label>
											<input type="text" name="nw[]" class="form-control nw" value="<?php echo $n;?>">
										</div>
									</div>
									<div class="col-xs-6 col-lg-2">
										<div class="form-group">
											<label for="nw-email">PCS</label>
											<input type="text" name="pcs[]" class="form-control pcs" value="<?php echo $pcs;?>">
										</div>
									</div>
									
								</div>
							</div>

							<?php foreach($arr2 as $l):?>
								<div class="block">
								<div class="row">
									<button type="button" class="btn-sm btn-danger pull-right remove">X</button>
									<button style="margin-right: 5px;" type="button" class="add-button btn btn-primary pull-right">+</button>
									<div class="clearfix"></div>
									
									<div class="col-xs-6 col-lg-8">
										<div class="form-group">
											<label for="ds">Description</label>
											<input type="text" name="description[]" class="form-control" value="<?php echo $l->description;?>">
										</div>
									</div>
									<div class="col-xs-6 col-lg-2">
										<div class="form-group">
											<label for="nw-email">Net Weight</label>
											<input type="text" name="nw[]" class="form-control nw" value="<?php echo $l->nw;?>">
										</div>
									</div>
									<div class="col-xs-6 col-lg-2">
										<div class="form-group">
											<label for="nw-email">PCS</label>
											<input type="text" name="pcs[]" class="form-control pcs" value="<?php echo $l->pcs;?>">
										</div>
									</div>
								</div>

								</div>

							<?php endforeach; ?>
						</div>

						<div class="row">
						<div class="col-md-6">
								<div class="form-group">
									<?php echo $form->labelEx($model,'remarks', array('class' => 'col-md-3 control-label')); ?>
									<div class="col-md-9">
										<?php echo $form->textArea($model,'remarks',array('class' => 'form-control','row'=>8)); ?>
										<?php echo $form->error($model,'remarks'); ?>
									</div>
								</div>
							</div>
							
						</div>



						<div class="form-group form-actions">
							<div class="col-md-9 col-md-offset-3">
								<?php echo CHtml::link('Cancel', array('index'), array('class' => 'btn btn-effect-ripple btn-danger')) ?>
								<?php echo CHtml::submitButton($model->isNewRecord ? 'Save' : 'Save', array('class' => 'btn btn-effect-ripple btn-primary')); ?>
								<?php echo CHtml::submitButton($model->isNewRecord ? 'Print' : 'Print', array('class' => 'btn btn-effect-ripple btn-default','name'=>'print')); ?>
							</div>
						</div>

						<?php $this->endWidget(); ?>
					</div>

					

				</div><!-- form -->
			</div>
		</div>


<div class="hidden add-more">
<div class="block">
								<div class="row">
									<button type="button" class="btn-sm btn-danger pull-right remove">X</button>
									<button style="margin-right: 5px;" type="button" class="add-button btn btn-primary pull-right">+</button>
									<div class="clearfix"></div>
									<div class="col-xs-6 col-lg-8">
										<div class="form-group">
											<label for="ds">Description</label>
											<input type="text" name="description[]" class="form-control">
										</div>
									</div>
									<div class="col-xs-6 col-lg-2">
										<div class="form-group">
											<label for="nw-email">Net Weight</label>
											<input type="text" name="nw[]" class="form-control nw">
										</div>
									</div>
									<div class="col-xs-6 col-lg-2">
										<div class="form-group">
											<label for="nw-email">PCS</label>
											<input type="text" name="pcs[]" class="form-control pcs">
										</div>
									</div>
								</div>

</div>
</div>


<script type="text/javascript">


$('body').on('keypress','input,select',function(e){
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

$(document).ready(function(){





	$('body').on('click','.add-button',function(){
		var h = $('.add-more').html().replace('item-ele','item');
		$('.items').append(h);
		inititem();
	})

	$('body').on('click','.remove',function(){
		$(this).closest('.block').remove();
	})

});
</script>
