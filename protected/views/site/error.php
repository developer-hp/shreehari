<?php
/* @var $this SiteController */
/* @var $error array */

/* $this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
); */
?>
<!-- 
<h2>Error <?php // echo $code; ?></h2>

<div class="error">
<?php // echo CHtml::encode($message); ?>
</div> -->


<div class="content-header">
    <div class="row">
        <div class="col-sm-6">
            <div class="header-section">
                <h1>Error Page</h1>
            </div>
        </div>
        <div class="col-sm-6 hidden-xs">
            <div class="header-section">
                <ul class="breadcrumb breadcrumb-top">
                    <li><a href="">Error</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="block">
    <!-- Alert Messages Title -->
    <div class="block-title">
        <h2>Error Page</h2>
    </div>
    <!-- END Alert Messages Title -->

    <!-- Alert Messages Content -->
    <div class="row" style="height: 350px">
    
        <div class="col-sm-12 col-lg-12">
            
   			<?php
/* @var $this SiteController */
/* @var $error array */

/* $this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
); */
?>

<h2> <b>Page Not Found</b> <?php echo $code; ?></h2>

<div class="error">
<?php echo CHtml::encode($message); ?>
</div>



        </div>
    </div>
    <!-- END Alert Messages Content -->
</div>

<style type="text/css"> 
.alert1 {
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid transparent;
    border-radius: 4px;
}
.alert1 {
    color: #ffffff;
    border-width: 0;
    border-radius: 3px;
}
</style>