<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?></title>
    <link rel="shortcut icon" href="<?php echo SITE_URL . '/assets/frontend/img/favicon.ico'; ?>">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:300,400,700|Roboto:300,400,700" rel="stylesheet">
    <!--Roboto Slab Font [ OPTIONAL ] -->
    <link href="<?php echo SITE_URL . '/assets/frontend/css/bootstrap.min.css'; ?>" rel="stylesheet">
    <!--Bootstrap Stylesheet [ REQUIRED ]-->
    <link href="<?php echo SITE_URL . '/assets/frontend/css/bootstrap-colorpicker.min.css'; ?>" rel="stylesheet">
    <!--Bootstrap Stylesheet [ REQUIRED ]-->
    <link href="<?php echo SITE_URL . '/assets/frontend/css/bootstrap-colorpicker-plus.css'; ?>" rel="stylesheet">
    <!--Bootstrap Stylesheet [ REQUIRED ]-->
    <link href="<?php echo SITE_URL . '/assets/frontend/css/style.css'; ?>" rel="stylesheet">
    <!--Jasmine Stylesheet [ REQUIRED ]-->
    <link href="<?php echo SITE_URL . '/assets/frontend/plugins/font-awesome/css/font-awesome.min.css'; ?>"
          rel="stylesheet"><!--Font Awesome [ OPTIONAL ]-->
    <link href="<?php echo SITE_URL . '/assets/frontend/plugins/switchery/switchery.min.css'; ?>" rel="stylesheet">
    <!--Switchery [ OPTIONAL ]-->
    <link href="<?php echo SITE_URL . '/assets/frontend/plugins/bootstrap-select/bootstrap-select.min.css'; ?>"
          rel="stylesheet"><!--Bootstrap Select [ OPTIONAL ]-->
    <link href="<?php echo SITE_URL . '/assets/frontend/css/custom.css'; ?>" rel="stylesheet">
    <!--Page Load Progress Bar [ OPTIONAL ]-->
    <link href="<?php echo SITE_URL . '/assets/frontend/plugins/dropzone/dropzone.css'; ?>" rel="stylesheet">
    <!--Dropzone [ OPTIONAL ]-->
    <link href="<?php echo SITE_URL . '/assets/frontend/plugins/datatables/media/css/dataTables.bootstrap.css'; ?>"
          rel="stylesheet">
    <link href="<?php echo SITE_URL . '/assets/frontend/plugins/datatables/extensions/Responsive/css/dataTables.responsive.css'; ?>"
          rel="stylesheet">

    <link href="<?php echo SITE_URL . '/assets/frontend/plugins/fullcalendar/fullcalendar.css'; ?>" rel="stylesheet">
    <link href="<?php echo SITE_URL . '/assets/frontend/plugins/dropzone/dropzone.css'; ?>" rel="stylesheet">
    <link href="<?php echo SITE_URL . '/assets/frontend/css/demo/jasmine.css'; ?>" rel="stylesheet">
    <link href="<?php echo SITE_URL . '/assets/frontend/plugins/summernote/summernote.min.css'; ?>" rel="stylesheet">
    <!--Bootstrap Timepicker [ OPTIONAL ]-->
    <link href="<?php echo SITE_URL . '/assets/frontend/plugins/bootstrap-timepicker/bootstrap-timepicker.min.css'; ?>"
          rel="stylesheet">
    <!--Bootstrap Datepicker [ OPTIONAL ]-->
    <link href="<?php echo SITE_URL . '/assets/frontend/plugins/bootstrap-datepicker/bootstrap-datepicker.css'; ?>"
          rel="stylesheet">
    <!--Page Load Progress Bar [ OPTIONAL ]-->
    <link href="<?php echo SITE_URL . '/assets/frontend/plugins/pace/pace.min.css'; ?>" rel="stylesheet">
    <!--Page Load Progress Bar [ OPTIONAL ]-->
    <script src="<?php echo SITE_URL . '/assets/frontend/plugins/pace/pace.min.js'; ?>"></script>

    <link href="<?php echo SITE_URL . '/assets/frontend/rating/star-rating.min.css'; ?>" rel="stylesheet">
    <script src="<?php echo SITE_URL . '/assets/frontend/rating/jquery.min.js'; ?>"></script>
    <script src="<?php echo SITE_URL . '/assets/frontend/rating/star-rating.min.js'; ?>"></script>
    <script src="<?php echo SITE_URL . '/assets/frontend/iframe/booking_iframe.js'; ?>"></script>
    <script src="<?php echo SITE_URL . '/assets/frontend/js/custom.js'; ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.5.0/fullcalendar.min.css" rel="stylesheet">
    <style>
        .btn-group-vertical > .btn-group:after, .btn-group-vertical > .btn-group:before, .btn-toolbar:after, .btn-toolbar:before, .clearfix:after, .clearfix:before, .container-fluid:after, .container-fluid:before, .container:after, .container:before, .dl-horizontal dd:after, .dl-horizontal dd:before, .form-horizontal .form-group:after, .form-horizontal .form-group:before, .modal-footer:after, .modal-footer:before, .modal-header:after, .modal-header:before, .nav:after, .nav:before, .navbar-collapse:after, .navbar-collapse:before, .navbar-header:after, .navbar-header:before, .navbar:after, .navbar:before, .pager:after, .pager:before, .panel-body:after, .panel-body:before, .row:after, .row:before {
            display: table;
            content: " "
        }

        .pageheader {
            padding: 57px 14px 5px;
        }

        #navbar-container {
            background-color: #54abd9;

        }

        .navbar-content {

            background-color: #54abd9;
        }

        .navbar-brand {
            background-color: #54abd9;
        }

        #container.mainnav-full #page-content {
            padding: 20px 20px 0;
        }

        .pageheader .breadcrumb-wrapper {
            top: 61px;
        }

        .tab-stacked-left .nav-tabs {
            width: 15%;

        }

        .dropzone {
            min-height: 201px;
        }

        .dropdown-menu-lg {
            min-width: 500px;
        }

        .form-horizontal .control-label {
            margin-bottom: 5px;
            font-size: 15px;
        }

    </style>

</head>
<body>
<div class="se-pre-con"></div>
<div id="container" class="effect mainnav-full">
    <!--NAVBAR-->
    <!--===================================================-->
    <header id="navbar" class="hidden-print">
        <div id="navbar-container" class="boxed">
            <div class="navbar-header">
                <a href="" class="navbar-brand">
                    <i class="fa fa-clock-o brand-icon"></i>
                    <div class="brand-title">
                        <span class="brand-text"><?php echo SITE_NAME; ?></span>
                    </div>
                </a>
            </div>

            <div class="navbar-content clearfix">

                <ul class="nav navbar-top-links pull-right">

                    <?php if ($_SESSION['user_type'] == "admin") { ?>

                        <li>
                            <a style="font-size: 20px" class="btn btn-pink btn-md hidden-xs hidden-sm"
                               href="<?php echo $link->link('quick_booking', frontend); ?>"><i class="fa fa-edit"></i>
                                PRENOTA</a>
                        </li>
                    <?php } ?>
                    <li>
                        <?php if ($_SESSION['email'] != 'contact@iwcnetwork.com') { ?>
                            <?php if ($_SESSION['user_type'] == "admin") { ?>
                            <?php } ?>
                        <?php } ?>
                    </li>
                    <li id="dropdown-user" class="dropdown">

                        <a href="#" data-toggle="dropdown" class="dropdown-toggle text-right">
            <span class="pull-right hidden-xs">
              <?php if (file_exists(SERVER_ROOT . '/uploads/company/' . CURRENT_LOGIN_COMPANY_ID . '/users/' . $_SESSION['user_id'] . '/' . $user_details['user_photo_file']) && (($user_details['user_photo_file']) != '')) {
                  ?>
                  <img class="img-circle img-user media-object"
                       src="<?php echo SITE_URL . '/uploads/company/' . CURRENT_LOGIN_COMPANY_ID . '/users/' . $_SESSION['user_id'] . '/' . $user_details['user_photo_file']; ?>"
                       alt="Profile Picture">
              <?php } else { ?>
                  <img class="img-circle img-user media-object"
                       src="<?php echo SITE_URL . '/assets/frontend/default_image/default_user_image.png'; ?>"
                       alt="Profile Picture">
              <?php } ?>
            </span>
                            <div class="username">
                                <?php echo ucwords(CURRENT_LOGIN_USER_FNAME . ' ' . CURRENT_LOGIN_USER_LNAME); ?>
                                (<?php echo ucfirst(CURRENT_LOGIN_USER_TYPE); ?>)
                            </div>

                        </a>


                        <div class="dropdown-menu dropdown-menu-right with-arrow">

                            <ul class="head-list">
                                <li>
                                    <a href="<?php echo $link->link('profile', user) ?>"> <i
                                                class="fa fa-user fa-fw"></i> Profilo </a>
                                </li>
                                <?php if ($_SESSION['email'] != 'contact@iwcnetwork.com') { ?>
                                    <li>
                                        <a href="<?php echo $link->link('changepassword', user) ?>"> <i
                                                    class="fa fa-key fa-fw"></i> Cambia Password </a>
                                    </li>
                                <?php } ?>
                                <?php if ($_SESSION['user_type'] == "admin") { ?>
                                    <!--  <li>
                                            <a href="<?php echo $link->link('upgrade_plan', user); ?>"> <i class="fa fa-trophy fa-fw"></i> Plan details</a>
                                          </li> -->
                                <?php } ?>
                                <li>
                                    <a href="<?php echo $link->link('logout', user); ?>"> <i
                                                class="fa fa-sign-out fa-fw"></i> ESCI </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="hidden-xs">
                        <a id="demo-toggle-aside" href="#">
                            <i class="fa fa-navicon fa-lg"></i>
                        </a>
                    </li>

                </ul>
            </div>

            <nav class="navbar navbar-default megamenu">
                <div class="navbar-header">
                    <button type="button" data-toggle="collapse" data-target="#defaultmenu" class="navbar-toggle">
                        <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
                    </button>
                </div>
                <!-- end navbar-header -->
                <div id="defaultmenu" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <?php if ($_SESSION['user_type'] == "admin") { ?>
                            <li class="<?php if ($query1ans == "home") {
                                echo "active";
                            } ?>">
                                <a href="<?php echo $link->link('home', frontend); ?>"><i class="fa fa-dashboard"></i>
                                    RIEPILOGO</a>
                            </li>
                        <?php } ?>



                        <?php if ($_SESSION['user_type'] == "admin" || $_SESSION['user_type'] == "staff" || $_SESSION['user_type'] == "receptionist") { ?>
                            <li class="<?php if ($query1ans == "calendar") {
                                echo "active";
                            } ?>">
                                <a href="<?php echo $link->link('calendar', frontend); ?>"><i
                                            class="fa fa-calendar"></i> CALENDARIO </a>
                            </li>
                        <?php } ?>



                        <?php if ($_SESSION['user_type'] == "admin" || $_SESSION['user_type'] == "receptionist") { ?>
                            <li class="<?php if ($query1ans == "customers" || $query1ans == "add_customer" || $query1ans == "edit_customer") {
                                echo "active";
                            } ?>">
                                <a href="<?php echo $link->link('customers', frontend); ?>"><i class="fa fa-users"></i>
                                    PAZIENTI</a>
                            </li>
                        <?php } ?>
                        <li class="<?php if ($query1ans == "account_preferences") {
                            echo "active";
                        } ?>">
                            <a href="<?php echo $link->link('account_preferences', frontend); ?>"><i
                                        class="fa fa-calendar"></i> REPORT APPUNTAMENTI</a>
                        </li>
                        <?php if ($_SESSION['user_type'] == "admin") { ?>
                            <!--<li class="dropdown <?php if ($query1ans == "company_detail" || $query1ans == "reviews") {
                                echo "active";
                            } ?>">
                                    <a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="fa fa-user"></i> Profilo <b class="caret"></b></a>
                                    <ul class="dropdown-menu" role="menu">

                                       <!-- <li><a href="<?php echo $link->link('company_detail', frontend); ?>"><i class="fa fa-edit"></i> Your Booking Page</a></li>
                                        <li><a href="<?php echo $link->link('reviews', frontend); ?>"><i class="fa fa-star-o"></i> Your Customer Reviews</a></li>

                                    </ul>
                                    <!-- end dropdown-menu -->
                            </li>
                            <li class="dropdown <?php if ($query1ans == "staff" || $query1ans == "services" || $query1ans == "add_service" || $query1ans == "rooms_seats"
                                || $query1ans == "edit_services" || $query1ans == "add_category"
                                || $query1ans == "notifications" || $query1ans == "account_preferences") {
                                echo "active";
                            } ?>">
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle"> <i class="fa fa-cog"></i>
                                    IMPOSTAZIONI <b class="caret"></b></a>
                                <ul class="dropdown-menu" role="menu">
                                    <?php
                                    $ccid = CURRENT_LOGIN_COMPANY_ID;
                                    $query = "SELECT `user_id` FROM `users` WHERE `company_id`='$ccid' ORDER BY user_id DESC LIMIT 0, 1";
                                    $ds = $db->run($query)->fetch();
                                    $sid = $ds['user_id'];
                                    ?>
                                    <li><a href="<?php echo $link->link('staff', frontend, '&sid=' . $sid); ?>"><i
                                                    class="fa fa-user"></i> Staff</a></li>
                                    <li><a href="<?php echo $link->link('services', frontend); ?>"> <i
                                                    class="fa fa-tag"></i> Prestazioni</a></li>
                                    <!-- <li><a href="<?php echo $link->link('rooms_seats', frontend); ?>"> <i class="fa fa-tag"></i> Rooms/Seats Management</a></li>-->
                                    <li><a href="<?php echo $link->link('notifications', frontend); ?>"><i
                                                    class="fa fa-bell"></i> Notifiche</a></li>
                                    <li><a href="<?php echo $link->link('account_preferences', frontend); ?>"><i
                                                    class="fa fa-cog"></i> Preferenze Account</a></li>
                                    <li><a href="<?php echo $link->link('payments', frontend); ?>"><i
                                                    class="fa fa-money"></i> Pagamenti</a></li>
                                </ul>
                                <!-- end dropdown-menu -->
                            </li>

                        <?php } ?>


                    </ul>
                    <ul class="nav navbar-top-links pull-right">
                        <li>
                            <?php if ($_GET['user'] == "calendar") : ?>

                        <li><a style="height: 50px;" href="#" data-toggle="modal" data-target="#myModal_notes"><i
                                        class="fa fa-clipboard fa-2x text-primary" title="Aggiungi NOTA"></i></a></li>
                        <?php endif; ?>
                        </li>
                    </ul>
                    <!-- end nav navbar-nav -->
                </div>
                <!-- end #navbar-collapse-1 -->
            </nav>
            <!-- end navbar navbar-default megamenu -->
        </div>
    </header>
    <!--===================================================-->
    <!--END NAVBAR-->
    <div class="boxed">
        <!--CONTENT CONTAINER-->
        <!--===================================================-->
        <div id="content-container">
            <?php if ($query1ans == "customers" || $query1ans == "add_customer" || $query1ans == "edit_customer") {
                ?>
                <header class="pageheader hidden-print">
                    <h3><i class="fa fa-user"></i> Pazienti</h3>
                    <div class="breadcrumb-wrapper">
                        <ul class="pull-left nav navbar-top-links">
                            <li>
                                <a href="#" data-toggle="modal" data-target="#myModal_notification"
                                   style="height: 27px;color: #266fb0;">
                                    <i style="color: #266fb0;" class="fa fa-pencil-square-o fa-2x text-primary"
                                       title="Aggiungi MEMO del Giorno"></i>
                                </a>
                            </li>
                        </ul>
                        <?php if ($_SESSION['user_type'] == "admin") { ?>
                            <ol class="breadcrumb">
                                <li><a href="<?php echo SITE_URL; ?>"> Home </a></li>
                                <li class="active"><?php echo ucwords(str_replace("_", " ", $query1ans)); ?></li>
                            </ol>
                        <?php } ?>
                    </div>
                </header>
            <?php } elseif ($query1ans == "calendar") {
                ?>
                <header class="pageheader hidden-print">
                    <h3><i class="fa fa-calendar"></i> Calendario Appuntamenti</h3>
                    <div class="breadcrumb-wrapper">
                        <ul class="pull-left nav navbar-top-links">
                            <li>
                                <a href="#" data-toggle="modal" data-target="#myModal_notification"
                                   style="height: 27px;color: #266fb0;">
                                    <i style="color: #266fb0;" class="fa fa-pencil-square-o fa-2x text-primary"
                                       title="Aggiungi MEMO del Giorno"></i>
                                </a>
                            </li>
                        </ul>
                        <?php if ($_SESSION['user_type'] == "admin") { ?>
                            <span class="label"></span>
                            <ol class="breadcrumb">
                                <li><a href="<?php echo SITE_URL; ?>"> Home </a></li>
                                <li class="active"><?php echo ucwords(str_replace("_", " ", $query1ans)); ?></li>
                            </ol>
                        <?php } ?>
                    </div>
                </header>
            <?php } elseif ($query1ans == "staff" || $query1ans == "services" || $query1ans == "add_service" || $query1ans == "rooms_seats"
                || $query1ans == "edit_service" || $query1ans == "add_category" || $query1ans == "notifications" || $query1ans == "account_preferences") { ?>
                <div class="pageheader hidden-print">
                    <h3><i class="fa fa-cog"></i> Impostazioni
                        <small>(<?php echo ucwords(str_replace("_", " ", $query1ans)); ?>)
                    </h3>
                    <div class="breadcrumb-wrapper">
                        <ul class="pull-left nav navbar-top-links">
                            <li>
                                <a href="#" data-toggle="modal" data-target="#myModal_notification"
                                   style="height: 27px;color: #266fb0;">
                                    <i style="color: #266fb0;" class="fa fa-pencil-square-o fa-2x text-primary"
                                       title="Aggiungi MEMO del Giorno"></i>
                                </a>
                            </li>
                        </ul>
                        <ol class="breadcrumb">
                            <li><a href="<?php echo SITE_URL; ?>"> Home </a></li>
                            <li class="active"><?php echo ucwords(str_replace("_", " ", $query1ans)); ?></li>
                        </ol>
                    </div>
                </div>
            <?php } elseif ($query1ans == "upgrade_plan") { ?>
                <div class="pageheader hidden-print">
                    <h3><i class="fa fa-cog"></i> Plan Details
                        <small>(<?php echo ucwords(str_replace("_", " ", $query1ans)); ?>)
                    </h3>
                    <div class="breadcrumb-wrapper">
                        <ul class="pull-left nav navbar-top-links">
                            <li>
                                <a href="#" data-toggle="modal" data-target="#myModal_notification"
                                   style="height: 27px;color: #266fb0;">
                                    <i style="color: #266fb0;" class="fa fa-pencil-square-o fa-2x text-primary"
                                       title="Aggiungi MEMO del Giorno"></i>
                                </a>
                            </li>
                        </ul>
                        <span class="label"></span>
                        <ol class="breadcrumb">
                            <li><a href="<?php echo SITE_URL; ?>"> Home </a></li>
                            <li class="active"><?php echo ucwords(str_replace("_", " ", $query1ans)); ?></li>
                        </ol>
                    </div>
                </div>
            <?php } elseif ($query1ans == "home") { ?>
                <div class="pageheader hidden-print">
                    <h3><i class="fa fa-home"></i> PANORAMICA</small></h3>
                    <div class="breadcrumb-wrapper">
                        <ul class="pull-left nav navbar-top-links">
                            <li>
                                <a href="#" data-toggle="modal" data-target="#myModal_notification"
                                   style="height: 27px;color: #266fb0;">
                                    <i style="color: #266fb0;" class="fa fa-pencil-square-o fa-2x text-primary"
                                       title="Aggiungi MEMO del Giorno"></i>
                                </a>
                            </li>
                        </ul>
                        <span class="label"></span>
                        <ol class="breadcrumb">
                            <li><a href="<?php echo SITE_URL; ?>"> Home </a></li>
                            <li class="active"><?php echo ucwords(str_replace("_", " ", $query1ans)); ?></li>
                        </ol>
                    </div>
                </div>
            <?php } elseif ($query1ans == "company_detail" || $query1ans == "reviews") { ?>
                <div class="pageheader hidden-print">
                    <h3><i class="fa fa-edit"></i> Configura
                        <small>(<?php echo ucwords(str_replace("_", " ", $query1ans)); ?>)</small>
                    </h3>
                    <div class="breadcrumb-wrapper">
                        <ul class="pull-left nav navbar-top-links">
                            <li>
                                <a href="#" data-toggle="modal" data-target="#myModal_notification"
                                   style="height: 27px;color: #266fb0;">
                                    <i style="color: #266fb0;" class="fa fa-pencil-square-o fa-2x text-primary"
                                       title="Aggiungi MEMO del Giorno"></i>
                                </a>
                            </li>
                        </ul>
                        <span class="label"></span>
                        <ol class="breadcrumb">
                            <li><a href="<?php echo SITE_URL; ?>"> Home </a></li>
                            <li class="active"><?php echo ucwords(str_replace("_", " ", $query1ans)); ?></li>
                        </ol>
                    </div>
                </div>

            <?php } elseif ($query1ans == "activity") { ?>
                <div class="pageheader hidden-print">
                    <h3><i class="fa fa-edit"></i> ATTIVITA'</h3>
                    <div class="breadcrumb-wrapper">
                        <ul class="pull-left nav navbar-top-links">
                            <li>
                                <a href="#" data-toggle="modal" data-target="#myModal_notification"
                                   style="height: 27px;color: #266fb0;">
                                    <i style="color: #266fb0;" class="fa fa-pencil-square-o fa-2x text-primary"
                                       title="Aggiungi MEMO del Giorno"></i>
                                </a>
                            </li>
                        </ul>
                        <span class="label"></span>
                        <ol class="breadcrumb">
                            <li><a href="<?php echo SITE_URL; ?>"> Home </a></li>
                            <li class="active"><?php echo ucwords(str_replace("_", " ", $query1ans)); ?></li>
                        </ol>
                    </div>
                </div>
            <?php } elseif ($query1ans == "quick_booking") { ?>
                <div class="pageheader hidden-print">
                    <h3><i class="fa fa-calendar"></i> PRENOTA</h3>
                    <div class="breadcrumb-wrapper">
                        <ul class="pull-left nav navbar-top-links">
                            <li>
                                <a href="#" data-toggle="modal" data-target="#myModal_notification"
                                   style="height: 27px;color: #266fb0;">
                                    <i style="color: #266fb0;" class="fa fa-pencil-square-o fa-2x text-primary"
                                       title="Aggiungi MEMO del Giorno"></i>
                                </a>
                            </li>
                        </ul>
                        <span class="label"></span>
                        <ol class="breadcrumb">
                            <li><a href="<?php echo SITE_URL; ?>"> Home </a></li>
                            <li class="active"><?php echo ucwords(str_replace("_", " ", $query1ans)); ?></li>
                        </ol>
                    </div>
                </div>
            <?php } elseif ($query1ans == "payments") { ?>
                <div class="pageheader hidden-print">
                    <h3><i class="fa fa-file"></i> PAGAMENTI</h3>
                    <div class="breadcrumb-wrapper">
                        <ul class="pull-left nav navbar-top-links">
                            <li>
                                <a href="#" data-toggle="modal" data-target="#myModal_notification"
                                   style="height: 27px;color: #266fb0;">
                                    <i style="color: #266fb0;" class="fa fa-pencil-square-o fa-2x text-primary"
                                       title="Aggiungi MEMO del Giorno"></i>
                                </a>
                            </li>
                        </ul>
                        <span class="label"></span>
                        <ol class="breadcrumb">
                            <li><a href="<?php echo SITE_URL; ?>"> Home </a></li>
                            <li class="active"><?php echo ucwords(str_replace("_", " ", $query1ans)); ?></li>
                        </ol>
                    </div>
                </div>
            <?php } elseif ($query1ans == "calendar_day") { ?>
                <div class="pageheader hidden-print">
                    <h3><i class="fa fa-file"></i> APPUNTAMENTI STAFF</h3>
                    <div class="breadcrumb-wrapper">
                        <ul class="pull-left nav navbar-top-links">
                            <li>
                                <a href="#" data-toggle="modal" data-target="#myModal_notification"
                                   style="height: 27px;color: #266fb0;">
                                    <i style="color: #266fb0;" class="fa fa-pencil-square-o fa-2x text-primary"
                                       title="Aggiungi MEMO del Giorno"></i>
                                </a>
                            </li>
                        </ul>
                        <span class="label"></span>
                        <ol class="breadcrumb">
                            <li><a href="<?php echo SITE_URL; ?>"> Home </a></li>
                            <li class="active"><?php echo ucwords(str_replace("_", " ", $query1ans)); ?></li>
                        </ol>
                    </div>
                </div>
            <?php } elseif ($query1ans == "subcsription_payment") { ?>
                <div class="pageheader hidden-print">
                    <h3><i class="fa fa-file"></i> Plan Subscription</h3>
                    <div class="breadcrumb-wrapper">
                        <ul class="pull-left nav navbar-top-links">
                            <li>
                                <a href="#" data-toggle="modal" data-target="#myModal_notification"
                                   style="height: 27px;color: #266fb0;">
                                    <i style="color: #266fb0;" class="fa fa-pencil-square-o fa-2x text-primary"
                                       title="Aggiungi MEMO del Giorno"></i>
                                </a>
                            </li>
                        </ul>
                        <span class="label"></span>
                        <ol class="breadcrumb">
                            <li><a href="<?php echo SITE_URL; ?>"> Home </a></li>
                            <li class="active"><?php echo ucwords(str_replace("_", " ", $query1ans)); ?></li>
                        </ol>
                    </div>
                </div>

            <?php } ?>

