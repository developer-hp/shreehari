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

    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/themes/amethyst.css">

    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-datetimepicker.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery.datetimepicker.min.css">

    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/toaster.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/custom.css">
    <!-- END Stylesheets -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/vendor/jquery-2.2.4.min.js"></script>
    <!-- Modernizr (browser feature detection library) -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/vendor/modernizr-3.3.1.min.js"></script>
    <title><?php  echo CHtml::encode($appsetting['APP_NAME']); ?></title>
    <style type="text/css">
    .pagination > li.selected > a{
        background-color: #5b6d75;
        color: #ffffff;
    }

</style>
<style>
#LoadingImage {background: rgba(255,255,255,0.5); width: 100%; height: 100%; position: fixed; z-index: 99999999;}
#LoadingImage img { width: 100px; left: 50%; margin-left: -16px; top: 50%; margin-top: -16px; position: absolute;}
</style>
</head>

<body>
    
    <!-- Page Wrapper -->
    <!-- In the PHP version you can set the following options from inc/config file -->
        <!--
            Available classes:

            'page-loading'      enables page preloader
        -->

        <div id="LoadingImage" style="display: none;" >
            <img src="<?php echo Yii::app()->request->baseUrl.'/img/loading.gif'?>" />
        </div>

        <div id="page-wrapper" class="page-loading">
            <!-- Preloader -->
            <!-- Preloader functionality (initialized in js/app.js) - pageLoading() -->
            <!-- Used only if page preloader enabled from inc/config (PHP version) or the class 'page-loading' is added in #page-wrapper element (HTML version) -->
            <div class="preloader" >
                <div class="inner">
                    <!-- Animation spinner for all modern browsers -->
                    <div class="preloader-spinner themed-background hidden-lt-ie10"></div>

                    <!-- Text for IE9 -->
                    <h3 class="text-primary visible-lt-ie10"><strong>Loading..</strong></h3>
                </div>
            </div>
            <!-- END Preloader -->

            <!-- Page Container -->
            <!-- In the PHP version you can set the following options from inc/config file -->
            <!--
                Available #page-container classes:

                'sidebar-light'                                 for a light main sidebar (You can add it along with any other class)

                'sidebar-visible-lg-mini'                       main sidebar condensed - Mini Navigation (> 991px)
                'sidebar-visible-lg-full'                       main sidebar full - Full Navigation (> 991px)

                'sidebar-alt-visible-lg'                        alternative sidebar visible by default (> 991px) (You can add it along with any other class)

                'header-fixed-top'                              has to be added only if the class 'navbar-fixed-top' was added on header.navbar
                'header-fixed-bottom'                           has to be added only if the class 'navbar-fixed-bottom' was added on header.navbar

                'fixed-width'                                   for a fixed width layout (can only be used with a static header/main sidebar layout)

                'enable-cookies'                                enables cookies for remembering active color theme when changed from the sidebar links (You can add it along with any other class)
            -->
            <div id="page-container" class="header-fixed-top sidebar-visible-lg-full">

                <!-- Main Sidebar -->
                <div id="sidebar">
                    <!-- Sidebar Brand -->
                    <div id="sidebar-brand" class="themed-background">
                        <?php 

                        $i = '<i class="fa fa-cube"></i>';
                        if($appsetting['LOGO'])
                        $i = CHtml::image(Yii::app()->baseUrl.'/'.$appsetting['LOGO'],'',array('height'=>'45px'));


                        echo CHtml::link($i.'<span class="sidebar-nav-mini-hide"><strong>' . $appsetting['APP_NAME'] . '</strong></span>', array("site/index"), array('class' => 'sidebar-title')) ?>
                    </div>
                    <!-- END Sidebar Brand -->

                    <!-- Wrapper for scrolling functionality -->
                    <div id="sidebar-scroll">
                        <!-- Sidebar Content -->
                        <div class="sidebar-content">
                            <!-- Sidebar Navigation -->

                            <?php


                            $user = $li2 =$item= $events=$forms=$settings=$item2=$item3=$cash=$report=$repair=$openingBalance=$ledgerDashboard=$issueEntry=$ledgerReport=$supplierLedger=$karigarJama=$subitemType='';
                            $ledger_tab = $ledgerAcc = $ledgerSup = $ledgerKar = $ledgerIss = $ledgerMaint = '';
                            $action = strtolower(Yii::app()->controller->id);
                            $action1 = strtolower(Yii::app()->controller->action->id);

                            $modal = User::model()->findByPk(Yii::app()->user->id);

                            $custome_tab='';
                            $cus = 0;

                            if ($action == 'user')
                                $user = 'active';                            
                            else if ($action == 'site')
                            {
                                $li2 = 'active';
                            }
                            else if ($action == 'ledgerdashboard')
                            {
                                $ledgerDashboard = 'active';
                            }
                            else if($action1 == 'today_cash' || $action1 == 'today_gold' || $action1 == 'today_bank' || $action1 == 'today_card' || $action1 == 'today_discount' || $action1 == 'today_item')
                            {
                                $li2 = 'active';   
                            }
                            else if ($action == 'setting')
                            {
                                $settings = 'active';
                            }
                            else if($action=="forms" && $action1=="answers")
                            {
                                $answers = 'active';                            
                            }
                            else if($action=="customer" && $action1=="list_supplier")
                            {
                                $item = 'active';
                                $custome_tab='active';
                            }
                            else if($action=="customer" && $action1=="list_customer")
                            {
                                $item2 = 'active';
                                $custome_tab='active';
                            }  
                             else if($action=="customer" && $action1=="index")
                            {
                                $item2 = 'active';
                                $custome_tab='active';
                            }                                
                            else if($action=="customer" && $action1=="list_karigar")
                            {
                                $item3 = 'active';
                                $custome_tab='active';
                            }
                          
                            else if($action=="customer" && $action1=="create_supplier")
                            {
                                $item = 'active';
                                $custome_tab='active';
                            }
                            else if($action=="customer" && $action1=="create_customer")
                            {
                                $item2 = 'active';
                                $custome_tab='active';
                            }
                            else if($action=="customer" && $action1=="create_karigar")
                            {
                                $item3 = 'active';
                                $custome_tab='active';
                            }
                            else if($action=="customer" && $action1=="update_supplier")
                            {
                                $item = 'active';
                                $custome_tab='active';
                            }
                            else if($action=="customer" && $action1=="update_customer")
                            {
                                $item2 = 'active';
                                $custome_tab='active';
                            }
                            else if($action=="ledgeraccount")
                            {
                                $ledger_tab = 'active';
                                $ledgerAcc = 'active';
                            }
                            else if($action=="suppliertxn")
                            {
                                $ledger_tab = 'active';
                                $ledgerSup = 'active';
                            }
                            else if($action=="karigarvoucher")
                            {
                                $ledger_tab = 'active';
                                $ledgerKar = 'active';
                            }
                            else if($action=="issueentry")
                            {
                                $ledger_tab = 'active';
                                $ledgerIss = 'active';
                            }
                            else if($action=="ledgermaintenance")
                            {
                                $ledger_tab = 'active';
                                $ledgerMaint = 'active';
                            }
                            else if($action=="customer" && $action1=="update_karigar")
                            {
                                $item3 = 'active';
                                $custome_tab='active';
                            }
                            else if($action=="cashevent" && $action1=="list_supplier_event")
                            {
                                $item = 'active';
                                $custome_tab='active';
                            }
                             else if($action=="cashevent" && $action1=="list_customer_event")
                            {
                                $item2 = 'active';
                                $custome_tab='active';
                            }
                             else if($action=="cashevent" && $action1=="list_karigar_event")
                            {
                                $item3 = 'active';
                                $custome_tab='active';
                            }
                            else if($action=="cashevent" && $action1=="list_supplier_bill")
                            {
                                $item = 'active';
                                $custome_tab='active';
                            }
                            else if($action=="cashevent" && $action1=="add_cash_supplier")
                            {
                                $item = 'active';
                                $custome_tab='active';
                            }
                            else if($action=="cashevent" && $action1=="update_cash_supplier")
                            {
                                $item = 'active';
                                $custome_tab='active';
                            }
                             else if($action=="cashevent" && $action1=="list_customer_bill")
                            {
                                $item2 = 'active';
                                $custome_tab='active';
                            }
                            else if($action=="cashevent" && $action1=="add_cash_customer")
                            {
                                $item2 = 'active';
                                $custome_tab='active';
                            }
                            else if($action=="cashevent" && $action1=="update_cash_customer")
                            {
                                $item2 = 'active';
                                $custome_tab='active';
                            }
                            else if($action=="cashevent" && $action1=="list_karigar_bill")
                            {
                                $item3 = 'active';
                                $custome_tab='active';
                            }
                            else if($action=="cashevent" && $action1=="add_cash_karigar")
                            {
                                $item3 = 'active';
                                $custome_tab='active';
                            }
                            else if($action=="cashevent" && $action1=="update_cash_karigar")
                            {
                                $item3 = 'active';
                                $custome_tab='active';
                            }
                            else if($action=="cashevent" && $action1=="admin")
                            {
                                $cash = 'active';
                                //$custome_tab='active';
                            }
                            else if($action=="cashevent" && $action1=="index")
                            {
                                $cash = 'active';
                                //$custome_tab='active';
                            }
                            else if($action=="cashevent" && $action1=="create")
                            {
                                $cash = 'active';
                                //$custome_tab='active';
                            }
                            else if($action=="cashevent" && $action1=="update")
                            {
                                $cash = 'active';
                                //$custome_tab='active';
                            }
                            else if($action=="cashevent" && $action1=="view")
                            {
                                $cash = 'active';
                                //$custome_tab='active';
                            }
                            else if($action=="cashevent" && $action1=="view_event")
                            {
                                $cash = 'active';
                                //$custome_tab='active';
                            }

                            else if($action=="cashevent" && $action1=="report")
                            {
                                $report = 'active';
                                //$custome_tab='active';
                            }
                            else if($action=="repair")
                                $repair  = 'active';
                            else if($action=="accountopeningbalance")
                                $openingBalance = 'active';
                            else if($action=="issueentry")
                                $issueEntry = 'active';
                            else if($action=="ledgerreport")
                                $ledgerReport = 'active';
                            else if($action=="supplierledger")
                                $supplierLedger = 'active';
                            else if($action=="karigarjama")
                                $karigarJama = 'active';
                            else if($action=="subitemtype")
                                $subitemType = 'active';
                            ?>


                            <ul class="sidebar-nav">

                                    <li>
                                    <?php echo CHtml::link('<i class="gi gi-compass sidebar-nav-icon"></i> <span class="sidebar-nav-mini-hide">Dashboard</span>', array("site/index"), array('class' => $li2)) ?>
                                    </li>
                                    <li>
                                    <?php echo CHtml::link('<i class="fa fa-bar-chart sidebar-nav-icon"></i> <span class="sidebar-nav-mini-hide">Ledger Dashboard</span>', array("ledgerDashboard/index"), array('class' => $ledgerDashboard)) ?>
                                    </li>
                                    <li class="sidebar-separator">
                                        <i class="fa fa-ellipsis-h"></i>
                                    </li>
                                    <?php if(false && $modal->user_type==1): ?>
                                    <li>
                                    <?php echo CHtml::link('<i class="fa fa-group sidebar-nav-icon"></i> <span class="sidebar-nav-mini-hide">Manage Users</span>', array("user/index"), array('class' => $user)) ?>
                                        
                                    </li>
                                    <li>
                                    <?php echo CHtml::link('<i class="fa fa-list-alt sidebar-nav-icon"></i> <span class="sidebar-nav-mini-hide">Manage Forms</span>', array("forms/index"), array('class' => $forms)) ?>
                                        
                                    </li>
                                    <li>
                                    <?php echo CHtml::link('<i class="fa fa-pencil-square-o sidebar-nav-icon"></i> <span class="sidebar-nav-mini-hide">Manage Answers</span>', array("forms/answers"), array('class' => $answers)) ?>
                                        
                                    </li>
                                    <li>
                                    <?php echo CHtml::link('<i class="fa fa-cogs sidebar-nav-icon"></i> <span class="sidebar-nav-mini-hide">Manage Settings</span>', array("setting/index"), array('class' => $settings)) ?>
                                        
                                    </li>
                                    <li class="sidebar-separator">
                                        <i class="fa fa-ellipsis-h"></i>
                                    </li>
                                    <?php endif;?>
                                   <!--  <li>
                                    <?php // echo CHtml::link('<i class="fa fa-list sidebar-nav-icon"></i> <span class="sidebar-nav-mini-hide">Manage Items</span>', array("item/index"), array('class' => $item)) ?>
                                        
                                    </li> -->

                                    <li>
                                    <?php // echo CHtml::link('<i class="fa fa-users sidebar-nav-icon"></i> <span class="sidebar-nav-mini-hide">Manage Customer</span>', array("customer/admin"), array('class' => $item)) ?>
                                        
                                    </li>

                                     <li class="<?php  echo $custome_tab;?>">
                                        <a href="#" class="sidebar-nav-menu"><span class="sidebar-nav-ripple animate"></span><i class="fa fa-chevron-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-user-circle-o sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Customer</span></a>
                                        <ul>
                                            <li>
                                                <?php 
                                                 echo CHtml::link('<i class="fa fa-users sidebar-nav-icon"></i> <span class="sidebar-nav-mini-hide">Supplier</span>', array("customer/list_supplier"), array('class' => $item)) ?>
                                            </li> 
                                            <li>
                                                <?php 
                                                 echo CHtml::link('<i class="fa fa-users sidebar-nav-icon"></i> <span class="sidebar-nav-mini-hide">Customer</span>', array("customer/list_customer"), array('class' => $item2)) ?>
                                            </li> 
                                            <li>
                                                <?php 
                                                 echo CHtml::link('<i class="fa fa-users sidebar-nav-icon"></i> <span class="sidebar-nav-mini-hide">Karigar</span>', array("customer/list_karigar"), array('class' => $item3)) ?>
                                            </li>      
                                                                              
                                        </ul>
                                    </li>

                                    <li>
                                    <?php  echo CHtml::link('<i class="fa fa-money sidebar-nav-icon"></i> <span class="sidebar-nav-mini-hide">Manage Cash</span>', array("cashevent/admin"), array('class' => $cash)) ?>
                                    </li>

                                     
                                    <li>
                                    <?php  echo CHtml::link('<i class="fa fa-list sidebar-nav-icon"></i> <span class="sidebar-nav-mini-hide">Manage Repairing</span>', array("repair/index"), array('class' => $repair)) ?>
                                    </li>

                                    <li>
                                        <?php echo CHtml::link('<i class="fa fa-file sidebar-nav-icon"></i> <span class="sidebar-nav-mini-hide">Report</span>', array("cashevent/report"), array('class' => $report)) ?>
                                    </li>

                                    <li>
                                        <?php echo CHtml::link('<i class="fa fa-balance-scale sidebar-nav-icon"></i> <span class="sidebar-nav-mini-hide">Opening Balance</span>', array("accountOpeningBalance/index"), array('class' => $openingBalance)) ?>
                                    </li>

                                    <li>
                                        <?php echo CHtml::link('<i class="fa fa-arrow-circle-right sidebar-nav-icon"></i> <span class="sidebar-nav-mini-hide">Issue Entry</span>', array("issueEntry/index"), array('class' => $issueEntry)) ?>
                                    </li>

                                    <li>
                                        <?php echo CHtml::link('<i class="fa fa-book sidebar-nav-icon"></i> <span class="sidebar-nav-mini-hide">Ledger Report</span>', array("ledgerReport/index"), array('class' => $ledgerReport)) ?>
                                    </li>
                                    <li>
                                        <?php echo CHtml::link('<i class="fa fa-book sidebar-nav-icon"></i> <span class="sidebar-nav-mini-hide">Supplier Ledger</span>', array("supplierLedger/index"), array('class' => $supplierLedger)) ?>
                                    </li>
                                    <li>
                                        <?php echo CHtml::link('<i class="fa fa-file-text-o sidebar-nav-icon"></i> <span class="sidebar-nav-mini-hide">Karigar Jama</span>', array("karigarJama/index"), array('class' => $karigarJama)) ?>
                                    </li>
                                    <li>
                                        <?php echo CHtml::link('<i class="fa fa-tags sidebar-nav-icon"></i> <span class="sidebar-nav-mini-hide">Subitem Types</span>', array("subitemType/index"), array('class' => $subitemType)) ?>
                                    </li>

                                </ul>
                                <!-- END Sidebar Navigation -->
                            </div>
                            <!-- END Sidebar Content -->
                        </div>
                        <!-- END Wrapper for scrolling functionality -->
                    </div>
                    <!-- END Main Sidebar -->

                    <!-- Main Container -->
                    <div id="main-container">
                        <!-- Header -->
                        <!-- In the PHP version you can set the following options from inc/config file -->
                    <!--
                        Available header.navbar classes:

                        'navbar-default'            for the default light header
                        'navbar-inverse'            for an alternative dark header

                        'navbar-fixed-top'          for a top fixed header (fixed main sidebar with scroll will be auto initialized, functionality can be found in js/app.js - handleSidebar())
                            'header-fixed-top'      has to be added on #page-container only if the class 'navbar-fixed-top' was added

                        'navbar-fixed-bottom'       for a bottom fixed header (fixed main sidebar with scroll will be auto initialized, functionality can be found in js/app.js - handleSidebar()))
                            'header-fixed-bottom'   has to be added on #page-container only if the class 'navbar-fixed-bottom' was added
                        -->
                        <header class="navbar navbar-inverse navbar-fixed-top">
                            <!-- Left Header Navigation -->
                            <ul class="nav navbar-nav-custom">
                                <!-- Main Sidebar Toggle Button -->
                                <li>
                                    <a href="javascript:void(0)" onclick="App.sidebar('toggle-sidebar');this.blur();">
                                        <i class="fa fa-ellipsis-v fa-fw animation-fadeInRight" id="sidebar-toggle-mini"></i>
                                        <i class="fa fa-bars fa-fw animation-fadeInRight" id="sidebar-toggle-full"></i>
                                    </a>
                                </li>
                                <!-- END Main Sidebar Toggle Button -->

                                <!-- Header Link -->
                                <li class="hidden-xs animation-fadeInQuick">
                                    <a href=""><strong>WELCOME</strong></a>
                                </li>
                                <!-- END Header Link -->
                            </ul>
                            <!-- END Left Header Navigation -->

                            <!-- Right Header Navigation -->
                            <ul class="nav navbar-nav-custom pull-right">

                                <!-- User Dropdown -->
                                <li class="dropdown">
                                    <?php
                                    $modal = User::model()->findByPk(Yii::app()->user->id);
                                    ?>
                                    <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                                        <!--<img src="img/placeholders/avatars/avatar9.jpg" alt="avatar">-->
                                        <?php 
                                        if($modal)
                                            echo $modal->name; ?>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li class="dropdown-header">
                                            <strong>ADMINISTRATOR</strong>
                                        </li>
                                        <?php // if($modal->user_type==1): ?>
                                    
                                        <li>
                                            <?php echo CHtml::link('<i class="fa fa-user fa-fw pull-right"></i> Profile', array('user/change')); ?>
                                        </li>
                                        <?php // endif; ?>
                                        <li>
                                            <?php echo CHtml::link('<i class="fa fa-power-off fa-fw pull-right"></i> Log out', array('site/logout')); ?>
                                        </li>
                                    </ul>
                                </li>
                                <!-- END User Dropdown -->
                            </ul>
                            <!-- END Right Header Navigation -->
                        </header>
                        <!-- END Header -->

                        <!-- Page content -->
                        <div id="page-content">
                            <?php echo $content; ?>
                        </div>
                        <!-- End Page content -->
                        <script>
                            $(document).ready(function () {
                                $(".alert").fadeTo(2000, 500).slideUp(500, function () {
                                    $(".alert").slideUp(500);
                                });
                            });

                            
                        </script>

                        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/vendor/bootstrap.min.js"></script>
                        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/plugins.js"></script>
                        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/app.js"></script>
                        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/plugins/ckeditor/ckeditor.js"></script>
                        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/toaster.js"></script>
                        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.mask.min.js"></script>

                        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/moment-with-locales.js"></script>
                        <!-- <script src="<?php // echo Yii::app()->request->baseUrl; ?>/js/bootstrap-datetimepicker.js"></script> -->

                        <!-- <script src="<?php // echo Yii::app()->request->baseUrl ?>/js/jquery.mask.js"></script> -->

                        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.datetimepicker.js"></script>

                        <script type="text/javascript">
                             $(function () {
                                $('.input-datetimepicker').datetimepicker({
                                    format:'m/d/Y H:i',
                                });
                            });
                        </script>

                    </div>
                </div>
            </div>
            <?php
            $bgcolor = base64_encode($appsetting['BG_COLOR']);
            $bgcolor1 = base64_encode($appsetting['BUTTON_HOVER_COLOR']);
            $bgcolor2 = base64_encode($appsetting['BUTTON_COLOR']);
            ?>
            <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/themes/custom.php?bgcolor=<?php echo $bgcolor; ?>&bgcolor1=<?php echo $bgcolor1; ?>&bgcolor2=<?php echo $bgcolor2; ?>">

            

        </body>
        </html>

      <!--   <script type="text/javascript">
            
            $('body').on('keydown', 'input, select', function(e) {
                if (e.key === "Enter") {
                    var self = $(this), form = self.parents('form:eq(0)'), focusable, next;
                    focusable = form.find('input,a,select,button,textarea').filter(':visible');
                    next = focusable.eq(focusable.index(this)+1);
                    if (next.length) {
                        next.focus();
                    } else {
                        form.submit();
                    }
                    return false;
                }
            });
        </script>
 -->