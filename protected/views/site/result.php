<?php
    $appsetting = $this->getsettings();
?>
<div class="content-header">
    <div class="row">
        <div class="col-sm-6">
            <div class="header-section">
                <h1>Output:</h1>
            </div>
        </div>
    </div>
</div>
<div class="block">
    <!-- Alert Messages Title -->
    <div class="block-title">
        <h2>Output</h2>
    </div>
    <div id="copy-div">
    <?php echo $text; ?>
	</div>

	<div class="row">
	<div class="col-md-7 col-md-offset-4">
    <button type="button" class="btn btn-primary copy-content">Copy to Clipboard</button>
    <?php echo CHtml::link($appsetting['SHOW_MORE_OPTION_BUTTON_TEXT'],array('site/result','aid'=>$aid,'t'=>$t),array('class'=>'btn btn-primary')); ?>
	</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$(".copy-content").click(function() {
			var el = document.getElementById('copy-div');
			var range = document.createRange();
			range.selectNodeContents(el);
			var sel = window.getSelection();
			sel.removeAllRanges();
			sel.addRange(range);
			document.execCommand('copy');
			alert("Contents copied to clipboard.");
			return false;
		});
	});
</script>
