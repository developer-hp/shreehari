<?php
	$user_data = array();
	if(!Yii::app()->user->isGuest){
		$user_id = Yii::app()->user->id;	
		$user_data = User::model()->findByPk($user_id);
	}
?>
<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>
<!-- <h3>Welcome to <?php echo Yii::app()->name; ?></h3> -->
<div class="content-header">
    <div class="row">
        <div class="col-sm-6">
            <div class="header-section">
                <h1>Welcome to your dashboard</h1>
            </div>
        </div>
        <div class="col-sm-6 hidden-xs">
            <div class="header-section">               
            </div>
        </div>
    </div>
</div>
<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="alert alert-' . $key . '">' . $message . "</div>\n";
    }
?>