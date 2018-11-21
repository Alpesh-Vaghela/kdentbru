<!DOCTYPE html>
<html lang="en">
 <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME;?></title>
    <link rel="shortcut icon" href="<?php echo SITE_URL.'/assets/frontend/img/favicon.ico';?>">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:300,400,700|Roboto:300,400,700" rel="stylesheet"> <!--Roboto Slab Font [ OPTIONAL ] -->
    <link href="<?php echo SITE_URL.'/assets/frontend/css/bootstrap.min.css';?>" rel="stylesheet"><!--Bootstrap Stylesheet [ REQUIRED ]-->
    <link href="<?php echo SITE_URL.'/assets/frontend/css/style.css';?>" rel="stylesheet"><!--Jasmine Stylesheet [ REQUIRED ]-->
    <link href="<?php echo SITE_URL.'/assets/frontend/plugins/font-awesome/css/font-awesome.min.css';?>" rel="stylesheet"><!--Font Awesome [ OPTIONAL ]-->
    <link href="<?php echo SITE_URL.'/assets/frontend/plugins/switchery/switchery.min.css';?>" rel="stylesheet"><!--Switchery [ OPTIONAL ]-->
    <link href="<?php echo SITE_URL.'/assets/frontend/plugins/bootstrap-select/bootstrap-select.min.css';?>" rel="stylesheet"><!--Bootstrap Select [ OPTIONAL ]-->
   <link href="<?php echo SITE_URL.'/assets/frontend/css/custom.css';?>" rel="stylesheet"><!--Page Load Progress Bar [ OPTIONAL ]-->
    <link href="<?php echo SITE_URL.'/assets/frontend/plugins/dropzone/dropzone.css';?>" rel="stylesheet"><!--Dropzone [ OPTIONAL ]-->
    <link href="<?php echo SITE_URL.'/assets/frontend/plugins/datatables/media/css/dataTables.bootstrap.css';?>" rel="stylesheet">
    <link href="<?php echo SITE_URL.'/assets/frontend/plugins/datatables/extensions/Responsive/css/dataTables.responsive.css';?>" rel="stylesheet">
    
    <link href="<?php echo SITE_URL.'/assets/frontend/plugins/fullcalendar/fullcalendar.css';?>" rel="stylesheet">
    <link href="<?php echo SITE_URL.'/assets/frontend/plugins/dropzone/dropzone.css';?>" rel="stylesheet">
    <link href="<?php echo SITE_URL.'/assets/frontend/css/demo/jasmine.css';?>" rel="stylesheet">
    <link href="<?php echo SITE_URL.'/assets/frontend/plugins/summernote/summernote.min.css';?>" rel="stylesheet">
      <!--Bootstrap Timepicker [ OPTIONAL ]-->
        <link href="<?php echo SITE_URL.'/assets/frontend/plugins/bootstrap-timepicker/bootstrap-timepicker.min.css';?>" rel="stylesheet">
        <!--Bootstrap Datepicker [ OPTIONAL ]-->
        <link href="<?php echo SITE_URL.'/assets/frontend/plugins/bootstrap-datepicker/bootstrap-datepicker.css';?>" rel="stylesheet">
       <!--Page Load Progress Bar [ OPTIONAL ]-->
        <link href="<?php echo SITE_URL.'/assets/frontend/plugins/pace/pace.min.css';?>" rel="stylesheet"><!--Page Load Progress Bar [ OPTIONAL ]-->
        <script src="<?php echo SITE_URL.'/assets/frontend/plugins/pace/pace.min.js';?>"></script>
        
         <link href="<?php echo SITE_URL.'/assets/frontend/rating/star-rating.min.css';?>" rel="stylesheet">
         <script src="<?php echo SITE_URL.'/assets/frontend/rating/jquery.min.js';?>"></script>
         <script src="<?php echo SITE_URL.'/assets/frontend/rating/star-rating.min.js';?>"></script>
         <script src="<?php echo SITE_URL.'/assets/frontend/iframe/booking_iframe.js';?>"></script>
         
         <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.5.0/fullcalendar.min.css" rel="stylesheet">
<style>
.btn-group-vertical>.btn-group:after,.btn-group-vertical>.btn-group:before,.btn-toolbar:after,.btn-toolbar:before,.clearfix:after,.clearfix:before,.container-fluid:after,.container-fluid:before,.container:after,.container:before,.dl-horizontal dd:after,.dl-horizontal dd:before,.form-horizontal .form-group:after,.form-horizontal .form-group:before,.modal-footer:after,.modal-footer:before,.modal-header:after,.modal-header:before,.nav:after,.nav:before,.navbar-collapse:after,.navbar-collapse:before,.navbar-header:after,.navbar-header:before,.navbar:after,.navbar:before,.pager:after,.pager:before,.panel-body:after,.panel-body:before,.row:after,.row:before
	{
	display: table;
	content: " "
}



#navbar-container { 
   background-color:#54abd9;
    
}

.navbar-content {

    background-color: #54abd9;
}
.navbar-brand {
    background-color:#54abd9;}
#container.mainnav-full #page-content {
    padding: 20px 20px 0;
}
.pageheader {
    padding: 57px 14px 5px;
}
.pageheader .breadcrumb-wrapper {
  top: 61px;
}
.tab-stacked-left .nav-tabs {
    width: 15%;
   
}
.dropzone {
    min-height: 201px;}
	
.dropdown-menu-lg {
    min-width: 500px;
}
</style>

  <style>
	.no-js #loader { display: none;  }
	.js #loader { display: block; position: absolute; left: 100px; top: 0; }
	.se-pre-con {
            	position: fixed;
            	left: 0px;
            	top: 0px;
            	width: 100%;
            	height: 100%;
            	z-index: 9999;
            	background: url(<?php echo SITE_URL.'/assets/loader/loading_new.gif';?>) center no-repeat  rgba(255,255,255,0.8);
            	background-size: 150px 150px;
            	}
  </style>
    </head> 
    <body>
    <div class="se-pre-con"></div>
        <div id="container" class="effect mainnav-full">
            <!--NAVBAR-->
            <!--===================================================-->
            <header id="navbar">
                <div id="navbar-container" class="boxed">
                    <!--Brand logo & name-->
                    <!--================================-->
                    <div class="navbar-header">
                        <a href="" class="navbar-brand">
                            <i class="fa fa-cube brand-icon"></i>
                            <div class="brand-title">
                                <span class="brand-text"><?php echo SITE_NAME;?></span>
                            </div>
                        </a>
                    </div>
                 
                    <div class="navbar-content clearfix">
                       <ul class="nav navbar-top-links pull-right">
                         <li id="dropdown-user" class="dropdown">
                         <?php if ($_REQUEST['action_id']!=""){?>
                                      <a style="font-size: 20px" class="btn btn-pink btn-md" href="<?php echo $link->link('quick_booking',admin,'&action_id='.$_REQUEST['action_id']);?>"><i class="fa fa-edit"></i> Booking</a>
                                 
                                <?php }?>
                                
                               
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle text-right">
                                    <span class="pull-right">
                                         <img class="img-circle img-user media-object" src="<?php echo $admin_image;?>" alt="Profile Picture">
                                    </span>
                                    <div class="username hidden-xs"><?php echo CURRENT_LOGIN_USER_FNAME.' '.CURRENT_LOGIN_USER_LNAME;?></div>
                            
                                </a>
                                

                                <div class="dropdown-menu dropdown-menu-right with-arrow">
                             
                                    <ul class="head-list">
                                        <li>
                                            <a href="<?php echo $link->link('profile',admin)?>"> <i class="fa fa-user fa-fw"></i> Profile </a>
                                        </li>
                                        <li>
                                            <a href="<?php echo $link->link('changepassword',admin)?>">  <i class="fa fa-key fa-fw"></i> Change Password </a>
                                        </li>
                                     
                                        <li>
                                            <a href="<?php echo $link->link('site_setting',admin)?>">  <i class="fa fa-gear fa-fw"></i> Settings </a>
                                        </li> 
                                     
                                        <li>
                                            <a href="<?php echo $link->link('logout',admin);?>"> <i class="fa fa-sign-out fa-fw"></i> Logout </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                           <!--   <li class="hidden-xs">
                                <a id="demo-toggle-aside" href="#">
                                <i class="fa fa-navicon fa-lg"></i>
                                </a>
                            </li> -->
                        </ul>
                    </div>
                 
                    <nav class="navbar navbar-default megamenu">
                     <div class="navbar-header">
                                <button type="button" data-toggle="collapse" data-target="#defaultmenu" class="navbar-toggle">
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                 </button>
                        </div> 
                        <div id="defaultmenu" class="navbar-collapse collapse">
                            <ul class="nav navbar-nav">
                                      <li class="<?php if ($query1ans=="home"){echo "active";}?>">
                                            <a href="<?php echo $link->link('home',admin);?>"><i class="fa fa-home"></i> Home</a>
                                      </li>
                                      
                                       <li class="<?php if ($query1ans=="calendar" ){echo "active";}?>">
                                            <a href="<?php echo $link->link('calendar',admin);?>"><i class="fa fa-calendar"></i> Calendar</a>
                                      </li> 
                                     <li class="<?php if ($query1ans=="company" || $query1ans=="add_company" 
                                                                                || $query1ans=="edit_company"){echo "active";}?>">
                                            <a href="<?php echo $link->link('company',admin);?>"><i class="fa fa-university"></i> Companies</a>
                                      </li>
                                       <li class="<?php if ($query1ans=="activity" ){echo "active";}?>">
                                            <a href="<?php echo $link->link('activity',admin);?>"><i class="fa fa-history"></i> Activities</a>
                                      </li>
                                      
                                       <?php if ($_REQUEST['action_id']!=""){
                                $company_name=$db->get_var('company',array('id'=>$_REQUEST['action_id']),'company_name');
                                $company_email=$db->get_var('company',array('id'=>$_REQUEST['action_id']),'company_email');
                                
                                ?>
                                      
                                      	   <li class="dropdown <?php if ($query1ans=="staff" || $query1ans=="services" || $query1ans=="add_service" || $query1ans=="rooms_seats"
                                                                || $query1ans=="edit_services" || $query1ans=="add_category"
                                                                || $query1ans=="notifications" || $query1ans=="account_preferences"){echo "active";}?>">
                                    <a href="#" data-toggle="dropdown" class="dropdown-toggle btn-info"> Current Selected Company: <?php echo $company_name;?> <b class="caret"></b></a>
                                    <ul class="dropdown-menu" role="menu">
                                     	<li>
                                            <a href="<?php echo $link->link('company_detail',admin,'&action_id='.$_REQUEST['action_id']);?>"><i class="fa fa-edit text-info"></i> Company Details</a>
                                              </li>
                                              <li>
                                            <a href="<?php echo $link->link('quick_booking',admin,'&action_id='.$_REQUEST['action_id']);?>"><i class="fa fa-edit text-info"></i> Bookings</a>
                                              </li>
                                              	<li>
                                                 <a href="<?php echo $link->link('reviews',admin,'&action_id='.$_REQUEST['action_id']);?>"><i class="fa fa-star text-info"></i> Reviews</a>
                                              </li>
                                              	<li>
                                              	  <?php
                                    
                                      
                                         $query="SELECT `user_id` FROM `users` WHERE `company_id`='$_REQUEST[action_id]' ORDER BY user_id DESC LIMIT 0, 1";
                                            $ds=$db->run($query)->fetch();
                                            $sid=$ds['user_id'];
                                            ?>
                                            <a href="<?php echo $link->link('staff',admin,'&action_id='.$_REQUEST['action_id'].'&sid='.$sid);?>"><i class="fa fa-users text-info"></i> Staff</a>
                                              </li>
                                              	<li>
                                            <a href="<?php echo $link->link('customers',admin,'&action_id='.$_REQUEST['action_id']);?>"><i class="fa fa-user text-info"></i> Customers</a>
                                              </li>
                                              	<li>
                                            <a href="<?php echo $link->link('services',admin,'&action_id='.$_REQUEST['action_id']);?>"><i class="fa fa-truck text-info"></i> Services</a>
                                              </li>
                                              	<li>
                                            <a href="<?php echo $link->link('rooms_seats',admin,'&action_id='.$_REQUEST['action_id']);?>"><i class="fa fa-bed text-info"></i> Rooms/Seats</a>
                                              </li>
                                              	<li>
                                            <a href="<?php echo $link->link('notifications',admin,'&action_id='.$_REQUEST['action_id']);?>"><i class="fa fa-bell text-info"></i> Notifications</a>
                                              </li>
                                              	<li>
                                            <a href="<?php echo $link->link('account_preferences',admin,'&action_id='.$_REQUEST['action_id']);?>"><i class="fa fa-sliders text-info"></i> Account Preference</a>
                                              </li> 
                                             <!--   	<li>
                                           <a href=""  data-toggle="modal" data-target="#delete_account" ><i class="fa fa-times"></i> Close Account</a>
                                              </li>  -->
                                              </ul>
                              
                                      </li>
                                <?php }?>
                                </ul>
                          
                        
                        </div>
                   
                    </nav>
       
                </div>
            </header>
            <!--===================================================-->
            <!--END NAVBAR-->
            <div class="boxed">
                <!--CONTENT CONTAINER-->
                <!--===================================================-->
                <div id="content-container">
                 <?php if($query1ans=="calendar"){?>
                     <header class="pageheader">
                        <h3><i class="fa fa-calendar"></i> Calendar</h3>
                        <div class="breadcrumb-wrapper">
                            <span class="label">You are here:</span>
                            <ol class="breadcrumb">
                                <li> <a href="<?php echo SITE_URL;?>"> Home </a> </li>
                                <li class="active"><?php echo ucwords(str_replace("_", " ", $query1ans));?></li>
                            </ol>
                        </div>
                   </header>
                    <?php }elseif($query1ans=="add_service"
                                          || $query1ans=="add_category" 
                       ){?> 
                    <div class="pageheader">
                        <h3><i class="fa fa-cog"></i> Settings <small>(<?php echo ucwords(str_replace("_", " ", $query1ans));?>)</h3>
                        <div class="breadcrumb-wrapper">
                            <span class="label">You are here:</span>
                            <ol class="breadcrumb">
                                <li> <a href="<?php echo SITE_URL;?>"> Home </a> </li>
                                <li class="active"><?php echo ucwords(str_replace("_", " ", $query1ans));?></li>
                            </ol>
                        </div>
                   </div>
                 
                     <?php }elseif($query1ans=="home"){?> 
                    <div class="pageheader">
                        <h3><i class="fa fa-home" style="font-size: 15px;"></i> Dashboard</h3>
                        <div class="breadcrumb-wrapper">
                            
                          
                        </div>
                   </div>
                     <?php }elseif($query1ans=="activity"){?> 
                    <div class="pageheader">
                        <h3><i class="fa fa-history" style="font-size: 15px;"></i> Acivities</h3>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li> <a href="<?php echo $link->link('home',admin);?>"><i class="fa fa-arrow-left" style="font-size: 15px;">Back</i></a> </li>
                               
                            </ol>
                          
                        </div>
                   </div>
                     <?php }elseif($query1ans=="company"){?> 
                     <div class="pageheader">
                 
                        <h3><i class="fa fa-university" style="font-size: 15px;"></i> Companies </h3>
                       
                   </div>
                   <?php }elseif($query1ans=="changepassword"){?> 
                   <header class="pageheader">
                        <h3><i class="fa fa-key"></i> Change Password </h3>
                        <div class="breadcrumb-wrapper">
                          
                        </div>
                    </header> 
                    <?php }elseif($query1ans=="profile"){?>  
                    <header class="pageheader">
                        <h3><i class="fa fa-user"></i> Profile </h3>
                        <div class="breadcrumb-wrapper">
                          
                        </div>
                    </header>
                    <?php }elseif($query1ans=="site_setting"){?>  
                     <header class="pageheader">
                        <h3><i class="fa fa-cog"></i> Settings </h3>
                        <div class="breadcrumb-wrapper">
                        
                        </div>
                    </header>  
              <?php }else{?>
                <div class="pageheader">
                        <h3><i class="fa fa-edit"></i> Configure <small>(<?php echo ucwords(str_replace("_", " ", $query1ans));?>)</small></h3>
                        <div class="breadcrumb-wrapper">
                        
                            <ol class="breadcrumb">
                                <li> <a href="<?php echo $link->link('company',admin);?>"><i class="fa fa-arrow-left" style="font-size: 15px;">Back</i></a> </li>
                               
                            </ol>
                        </div>
                   </div>
                    <?php }?>    
                    