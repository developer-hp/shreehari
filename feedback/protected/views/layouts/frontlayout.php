<!DOCTYPE html>
<!--[if IE 9]>         <html class="no-js lt-ie10" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">

        <title>Customer</title>

        <meta name="description" content="AppUI Frontend is a Responsive Bootstrap Site Template created by pixelcave and added as a bonus in AppUI Admin Template package">
        <meta name="author" content="pixelcave">
        <meta name="robots" content="noindex, nofollow">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0">

        <!-- Icons -->
        <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
        <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl;?>/img/favicon.png">
        <link rel="apple-touch-icon" href="<?php echo Yii::app()->request->baseUrl;?>/img/icon57.png" sizes="57x57">
        <link rel="apple-touch-icon" href="<?php echo Yii::app()->request->baseUrl;?>/img/icon72.png" sizes="72x72">
        <link rel="apple-touch-icon" href="<?php echo Yii::app()->request->baseUrl;?>/img/icon76.png" sizes="76x76">
        <link rel="apple-touch-icon" href="<?php echo Yii::app()->request->baseUrl;?>/img/icon114.png" sizes="114x114">
        <link rel="apple-touch-icon" href="<?php echo Yii::app()->request->baseUrl;?>/img/icon120.png" sizes="120x120">
        <link rel="apple-touch-icon" href="<?php echo Yii::app()->request->baseUrl;?>/img/icon144.png" sizes="144x144">
        <link rel="apple-touch-icon" href="<?php echo Yii::app()->request->baseUrl;?>/img/icon152.png" sizes="152x152">
        <link rel="apple-touch-icon" href="<?php echo Yii::app()->request->baseUrl;?>/img/icon180.png" sizes="180x180">
        <!-- END Icons -->

        <!-- Stylesheets -->
        <!-- Bootstrap is included in its original form, unaltered -->
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl;?>/css/bootstrap.min.css">

        <!-- Related styles of various icon packs and plugins -->
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl;?>/css/plugins.css">

        <!-- The main stylesheet of this template. All Bootstrap overwrites are defined in here -->
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl;?>/css/main.css">

        <!-- The themes stylesheet of this template (for using specific theme color in individual elements - must included last) -->
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl;?>/css/themes.css">
        <!-- END Stylesheets -->

        <!-- Modernizr (browser feature detection library) -->
        <script src="<?php echo Yii::app()->request->baseUrl;?>/js/vendor/modernizr-3.3.1.min.js"></script>
    </head>
    <body>
        <!-- Page Container -->
        <!-- In the PHP version you can set the following options from inc/config file -->
        <!-- 'boxed' class for a boxed layout -->
        <div id="page-container" class="boxed">
            <!-- Site Header -->
            <header>
                <div class="container">
                    <!-- Site Logo -->
                    <?php 
                        echo CHtml::link("Customer", array('site/index'), array('class'=>'site-logo'));
                        ?>
                  <!--   <a href="" class="site-logo">
                        <i class="fa fa-cube"></i> App<strong>UI</strong>
                    </a> -->
                    <!-- END Site Logo -->

                    <!-- Site Navigation -->
                    <nav>
                        <!-- Menu Toggle -->
                        <!-- Toggles menu on small screens -->
                        <a href="javascript:void(0)" class="btn btn-default site-menu-toggle visible-xs visible-sm">Menu</a>
                        <!-- END Menu Toggle -->

                        <!-- Main Menu -->
                        <?php 
                            $action = strtolower(Yii::app()->controller->action->id);
                            $li_main=$li_feedback="";
                            if($action == 'index')
                            {
                                $li_main = 'active';
                            }
                            else if($action == 'feedback')
                            {
                                $li_feedback ='active';
                            }
                        ?>
                        <ul class="site-nav">
                            <li>
                                <?php
                                  //  echo CHtml::link("Welcome", array('site/index'), array('class'=>$li_main));
                                ?>
                                <!-- <a href="" class="<?php // echo $li_main; ?>">Welcome</a> -->
                            </li>
                           <!--  <li>
                                <a href="">Features</a>
                            </li>
                            <li>
                                <a href="">Pricing</a>
                            </li>
                            <li>
                                <a href="">Contact</a>
                            </li> -->
                            <!--  <li>
                                <a href="javascript:void(0)" class="site-nav-sub"><i class="fa fa-angle-down site-nav-arrow"></i>Pages</a>
                                <ul>
                                    <li>
                                        <a href="">Blog</a>
                                    </li>
                                    <li>
                                        <a href="">Blog Post</a>
                                    </li>
                                    <li>
                                        <a href="">Portfolio</a>
                                    </li>
                                    <li>
                                        <a href="">Project</a>
                                    </li>
                                    <li>
                                        <a href="">Team</a>
                                    </li>
                                    <li>
                                        <a href="">FAQ</a>
                                    </li>
                                    <li>
                                        <a href="">Jobs</a>
                                    </li>
                                    <li>
                                        <a href="">Search Results</a>
                                    </li>
                                    <li>
                                        <a href="">Page Scroller</a>
                                    </li>
                                </ul>
                            </li> -->
                            <!-- <li>
                                <a href="http://demo.pixelcave.com/appui" class="featured">Get Started <i class="fa fa-arrow-right"></i></a>
                            </li> -->
                        </ul>
                        <!-- END Main Menu -->
                    </nav>
                    <!-- END Site Navigation -->
                </div>
            </header>
            <!-- END Site Header -->

            <!-- Intro + Action -->
            <section class="site-section site-section-top site-section-light themed-background-dark-default">
                <div class="container">
                    
                    <?php 
                        echo $content;
                    ?>

                    

            
        </div>
        </section>
        <!-- END Page Container -->

        <!-- Scroll to top link, initialized in js/app.js - scrollToTop() -->
        <a href="#" id="to-top"><i class="fa fa-arrow-up"></i></a>

        <!-- jQuery, Bootstrap, jQuery plugins and Custom JS code -->

         <script type="text/javascript">
            if (typeof jQuery == 'undefined') {
                document.write('<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/vendor/jquery-2.2.4.min.js">"></' + 'script>');
            }
        </script>
        <!-- <script src="<?php // echo Yii::app()->request->baseUrl;?>/js/vendor/jquery-2.2.4.min.js"></script> -->
        <script src="<?php echo Yii::app()->request->baseUrl;?>/js/vendor/bootstrap.min.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl;?>/js/plugins.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl;?>/js/app.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.mask.min.js"></script>
    </body>
</html>

<script type="text/javascript">
    
    $(document).ready(function()
    {
        $("#Feedback_birthdate").mask("99-99-9999");
        $("#Feedback_anniversary_date").mask("99-99-9999");
    }); 
</script>

<script type="text/javascript">
      $('.info_success').addClass('alert alert-success');
        // $('.info').show();
             window.setTimeout(function () {
             $(".alert-success").fadeTo(500, 10).slideUp(1000, function () {
         $(this).hide();
           $(this).css('opacity','100');
             });
             }, 5000);
 </script>