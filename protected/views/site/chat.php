<?php
$admin = User::model()->findByAttributes(array('user_type'=>1));
?>
<form id="chat">
<div class="col-sm-6">
<textarea class="form-control chat1" readonly="true" rows="5"><?php echo $admin->message_data;?></textarea>
</div>
<div class="col-sm-6">
<textarea class="form-control chat2" name="message" rows="5"></textarea>
</div>
</form>

<script type="text/javascript">
$(document).ready(function() {
	$('.chat2').change(function(){				
        $.ajax("<?php echo Yii::app()->request->baseUrl.'/site/savechat'?>", {
            method: "POST",
            data: $('#chat').serialize(),
            success: function (data) {

            },
         });
	});

	setInterval(function(){ 
		    $.ajax("<?php echo Yii::app()->request->baseUrl.'/site/savechat'?>", {
	            method: "GET",
	            success: function (data) {
	            	$('.chat1').val(data);
	            },
	         });
		
	 }, 5000);
});			
</script>