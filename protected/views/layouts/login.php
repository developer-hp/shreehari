<?php
    $appsetting = $this->getsettings();
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- blueprint CSS framework -->
	<!-- <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection"> -->
	<!-- <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print"> -->
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection">
	<![endif]-->

	<!-- <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css"> -->
	<!-- <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css"> -->

         <!-- Icons -->
        <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
        <?php
        $img = "img/favicon.png";
        if(isset($appsetting['FAV_ICON']) && $appsetting['FAV_ICON'])
            $img = $appsetting['FAV_ICON'];

        ?>



        <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl.'/'.$img; ?>">
        <link rel="apple-touch-icon" href="<?php echo Yii::app()->request->baseUrl; ?>/img/icon57.png" sizes="57x57">
        <link rel="apple-touch-icon" href="<?php echo Yii::app()->request->baseUrl; ?>/img/icon72.png" sizes="72x72">
        <link rel="apple-touch-icon" href="<?php echo Yii::app()->request->baseUrl; ?>/img/icon76.png" sizes="76x76">
        <link rel="apple-touch-icon" href="<?php echo Yii::app()->request->baseUrl; ?>/img/icon114.png" sizes="114x114">
        <link rel="apple-touch-icon" href="<?php echo Yii::app()->request->baseUrl; ?>/img/icon120.png" sizes="120x120">
        <link rel="apple-touch-icon" href="<?php echo Yii::app()->request->baseUrl; ?>/img/icon144.png" sizes="144x144">
        <link rel="apple-touch-icon" href="<?php echo Yii::app()->request->baseUrl; ?>/img/icon152.png" sizes="152x152">
        <link rel="apple-touch-icon" href="<?php echo Yii::app()->request->baseUrl; ?>/img/icon180.png" sizes="180x180">
        <!-- END Icons -->

        <!-- Stylesheets -->
        <!-- Bootstrap is included in its original form, unaltered -->
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.min.css">

        <!-- Related styles of various icon packs and plugins -->
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/plugins.css">

        <!-- The main stylesheet of this template. All Bootstrap overwrites are defined in here -->
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css">

        <!-- Include a specific file here from css/themes/ folder to alter the default theme of the template -->

        <!-- The themes stylesheet of this template (for using specific theme color in individual elements - must included last) -->
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/themes.css">

        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/custom.css">
        <!-- END Stylesheets -->

        <!-- Modernizr (browser feature detection library) -->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/vendor/modernizr-3.3.1.min.js"></script>
	<title><?php echo CHtml::encode($appsetting['APP_NAME']); ?></title>
</head>

<body>

<?php
$img = "img/placeholders/layout/login2_full_bg.jpg";
if(isset($appsetting['LOGIN_BACKGROUND']) && $appsetting['LOGIN_BACKGROUND'])
    $img = $appsetting['LOGIN_BACKGROUND'];

?>
<img src="<?php echo Yii::app()->request->baseUrl.'/'.$img; ?>" alt="Full Background" class="full-bg animation-pulseSlow">

<div id="login-container">

	
    <h1 class="h2 text-light text-center push-top-bottom animation-pullDown">

                <?php
                $i = '<i class="fa fa-cube text-light-op"></i>';
                if($appsetting['LOGO'])
                $i = CHtml::image(Yii::app()->baseUrl.'/'.$appsetting['LOGO'],'',array('height'=>'45px'));
                ?>

                <?php echo $i; ?> <strong><?php echo CHtml::encode($appsetting['APP_NAME']); ?></strong>
            </h1>
            <script type="text/javascript">
                if (typeof jQuery == 'undefined') {
                document.write('<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/vendor/jquery-2.2.4.min.js">"></' + 'script>');
                }
            </script>

	<?php echo $content; ?>

        <!-- <script src="<?php // echo Yii::app()->request->baseUrl; ?>/js/vendor/jquery-2.2.4.min.js"></script> -->

        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/vendor/bootstrap.min.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/plugins.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/app.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/pages/readyLogin.js"></script>
        <script>$(function(){ ReadyLogin.init(); });</script>


</div><!-- page -->

</body>
</html>
