<?php /* @var $this Controller */ ?>
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
    <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/img/favicon.png">
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

    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/toaster.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/custom.css">
    <!-- END Stylesheets -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/vendor/jquery-2.2.4.min.js"></script>
    <!-- Modernizr (browser feature detection library) -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/vendor/modernizr-3.3.1.min.js"></script>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
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
                        <?php echo CHtml::link('<i class="fa fa-cube"></i><span class="sidebar-nav-mini-hide"><strong>' . Yii::app()->name . '</strong></span>', array("site/index"), array('class' => 'sidebar-title')) ?>
                    </div>
                    <!-- END Sidebar Brand -->

                    <!-- Wrapper for scrolling functionality -->
                    <div id="sidebar-scroll">
                        <!-- Sidebar Content -->
                        <div class="sidebar-content">
                            <!-- Sidebar Navigation -->

                            <?php
                            $li1 = $li2 = $li3 = $li4 = $li5 = $li6 = $li7 = $li8 = $li9 = $fl=$sample=$dailystock=$deleteditems=$photolist=$orderbooks =$repair=$pending=$cs=$exportgroup=$diamond=$deletedlist=$goldevent=$demandestimate=$visitor='';
                            $sl1 = $sl2 = $sl3 = $sl4 = $sl5 = $sl6 = $sl7 = $sl8 = $sl9 = $sl10 = '';
                            $arr1 = [];
                            $action = strtolower(Yii::app()->controller->id);
                            $action1 = strtolower(Yii::app()->controller->action->id);



                            // $modal = User::model()->findByPk(Yii::app()->user->id);


                            if ($action == 'user')
                                $li1 = 'active';
                            else if($action1=="followup")
                                $fl = 'active';
                            else if($action1=="sample")
                                $sample  = 'active';
                            else if ($action == 'site')
                                $li2 = 'active';
                            else if ($action == 'photos')
                                $li3 = 'active';
                            else if ($action == 'customer')
                                $cs = 'active';
                            else if ($action == 'cashevent')
                                $li5 = 'active';
                            else if ($action == 'orderbooks')
                                $orderbooks = 'active';
                            else if ($action == 'demandestimate')
                                $demandestimate = 'active';
                            else if ($action == 'orderbookitems' && $action1=="deletedlist")
                                $deletedlist = 'active';
                            else if ($action == 'orderbookitems')
                                $pending = 'active';
                            else if ($action == 'repair')
                                $repair = 'active';
                            else if ($action == 'visitor')
                                $visitor = 'active';
                            
                            else if ($action == 'goldevent')
                                $goldevent = 'active';
                            else if ($action == 'item' && $action1=="index")
                                $li6 = 'active';
                            else if ($action == 'item' && $action1=="exportgroup")
                                $exportgroup = 'active';
                            else if ($action == 'dailystock' && ($action1 == 'deleteditems' || $action1 == 'create') )
                                $deleteditems = 'active';
                            else if ($action == 'dailystock' || $action == 'item' )
                                $dailystock = 'active';
                            else if ($action == 'estimate' && ($action1=="create" || $action1=="update"))
                                $li8 = 'active';
                            else if ($action == 'estimate')
                                $li7 = 'active';
                            else if ($action == 'diamond')
                                $diamond = 'active';
                            else if ($action1 == 'cancelorder')
                                $li4 = 'active';
                            else if ($action == "order" && $action1=="list")
                                $photolist = "active";
                            else if ($action == "order")
                                $sl1 = "active";

                            $setting = $itemcode = $making = $rates = $itemgroup=$goldmaster = "";

                            $arr1 = ['itemcode','making','rates','itemgroup','goldmaster'];

                            if (in_array($action, $arr1)) {
                                $setting = 'active';
                                if ($action == "itemcode")
                                    $itemcode = "active";
                                if ($action == "making")
                                    $making = "active";
                                if ($action == "rates")
                                    $rates = "active";
                                if ($action == "itemgroup")
                                    $itemgroup = "active";
                                if ($action == "goldmaster")
                                    $goldmaster = "active";
                            }
                            



                            ?>


                            
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

                            $(document).on('submit','form',function(){
                                if($(this).attr('id')!="upload-image")
                                $('#LoadingImage').show();
                            });
                        </script>

                        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/vendor/bootstrap.min.js"></script>
                        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/plugins.js"></script>
                        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/app.js"></script>
                        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/plugins/ckeditor/ckeditor.js"></script>
                        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/toaster.js"></script>
                        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.mask.min.js"></script>

                    </div>
                </div>
            </div>

            <form id="upload-image" method="post" enctype="multipart/form-data" onsubmit="return false;">
<div class="modal" id="modal" role="dialog" aria-labelledby="modalLabel" tabindex="-1">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalLabel">Upload Image</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <button type="submit" class="btn btn-success" id="crop-btn" >Crop and Upload</button>
            <input type="file" name="image" id="file-image">

            <input type="hidden" name="json" id="cropjson">
            <div class="img-container">
              <img id="image" src=""  width="500">
            </div>
            
            
          </div>
          <div class="modal-footer">
            <!-- <button type="button" class="btn btn-primary" id="zoomin" ><i class="fa fa-search-plus"></i></button> -->
            <!-- <button type="button" class="btn btn-primary" id="zoomout" ><i class="fa fa-search-minus"></i></button> -->
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            
            <!-- <button type="submit" class="btn btn-success" id="crop-btn" >Crop and Upload</button> -->
          </div>
        </div>
      </div>
    </div>
</form>

        </body>
        </html>
