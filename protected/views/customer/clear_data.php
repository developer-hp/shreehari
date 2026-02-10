
<?php
	// print_r($_POST['data_id']);
$hidden_id = $_POST['data_id'];
?>

<div class="row">
    <div class="col-md-12">
     <!-- Horizontal Form Block -->
        <div class="">
    		<?php
    		if($hidden_id == 1)
			{
    		?>
				<form name="clear" method="post" action="<?php echo Yii::app()->createUrl('customer/clear_without_backup');?>" >
    	  	<?php
    	    }
			else if($hidden_id == 2)
			{
			?>
    	  		<form name="clear" method="post" action="<?php echo Yii::app()->createUrl('customer/database_export');?>" >
			<?php
			}
			else
			{
			?>
				<form name="clear" method="post" action="<?php echo Yii::app()->createUrl('customer/database_export');?>" >
			<?php
			}
        	  	?>
	        	  	<div class="form-group">
		  				<label class="col-md-4 control-label" style="margin-right: -50px;">Enter Password::</label>
		  				<input type="hidden" name="hidden_id" value="<?php echo $hidden_id; ?>">
							<div class="col-md-7">
								<input type="Password" name="user_password" id="user_password" class="form-control">
								 <span id="passwordValidation" class="help-block" style="color:#de815c;"></span>
							</div>
						</div>

						<div class="form-group form-actions" >
				        <div class="col-md-9 col-md-offset-3" style="margin-top: 20px !important;">
				        	<input type="submit" name="submit" value="Clear Data" class="btn btn-effect-ripple btn-primary form_submit">
				            <button type="button" class="btn btn-danger" data-dismiss="modal" style="margin-left: 5px;">Close</button>           
				        </div>
				    </div>
		      </form>
     	</div>
 	</div>
</div>