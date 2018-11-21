<?php
   session_start ();
   
   /**
    * *** define document path**********
    */
   define ( 'SERVER_ROOT', dirname ( __FILE__ ) );
   define ( 'SITE_ROOT', $_SERVER ['HTTP_HOST'] );
   $protocol = (! empty ( $_SERVER ['HTTPS'] ) && $_SERVER ['HTTPS'] !== 'off' || $_SERVER ['SERVER_PORT'] == 443) ? "https://" : "http://";
   $get_script_path = pathinfo ( $_SERVER ['SCRIPT_NAME'] );
   define ( 'SCRIPT_DIR_PATH', $get_script_path ['dirname'] );
   define ( 'SCRIPT_BASE_NAME', $get_script_path ['basename'] );
   define ( 'SCRIPT_FILE_NAME', $get_script_path ['filename'] );
   unset ( $get_script_path );
   if(SCRIPT_DIR_PATH==='/')
       define ( 'SITE_URL', $protocol . SITE_ROOT);
   else
       define ( 'SITE_URL', $protocol . SITE_ROOT . SCRIPT_DIR_PATH );
   
   ini_set ( 'error_reporting', E_ALL );
   ini_set ( 'display_errors', '1' );
   ini_set ( 'start_up_errors', '1' );
   error_reporting ( E_ALL ^ E_NOTICE );
   
   require(SERVER_ROOT . '/protected/setting/database.php');
   require(SERVER_ROOT . '/protected/library/db_class.php');
   
  $db = new db("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
   
  
   function createDateRangeArray($strDateFrom,$strDateTo)
   {
   
       $aryRange=array();
       $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
       $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));
   
       if ($iDateTo>=$iDateFrom)
       {
           array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
           while ($iDateFrom<$iDateTo)
           {
               $iDateFrom+=86400; // add 24 hours
               array_push($aryRange,date('Y-m-d',$iDateFrom));
           }
       }
       return $aryRange;
   }
   // this is for empty function
   function emptyfields($value, $display = NULL) {
       $newarray = array ();
       if(is_array($value)){
           foreach ( $value as $key => $val ) {
               if ($val=='')
   
                   $newarray [] = $key;
   
           }
       }
       if ($display != NULL && count($newarray)!=0)
           echo $this->form_warning ( $newarray, 'Following fields are empty ! <br>please correct them', 'array' );
       if (count ( $newarray ) != 0)
       {
           foreach ($newarray as $e) {
               $empt_fields .= $e . '<br>';
           }
           return $empt_fields;
       }
       else
       {
           return false;
       }
   }
   // this is for time function
   function create_time_range($start, $end, $interval = '15 mins', $format = '12') {
       $startTime = strtotime($start);
       $endTime   = strtotime($end);
       // $returnTimeFormat = ($format == '12')?'g:iA':'G:i';
       $returnTimeFormat = ($format == '12')?'g:i A':'G:i';
   
       $current   = time();
       $addTime   = strtotime('+'.$interval, $current);
       $diff      = $addTime - $current;
   
       $times = array();
       while ($startTime < $endTime) {
           $times[] = date($returnTimeFormat, $startTime);
           $startTime += $diff;
       }
       $times[] = date($returnTimeFormat, $startTime);
       return $times;
   }
   
   function decryptIt( $q ) {
       $cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
       $qDecoded      = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
       return( $qDecoded );
   }
   ///
   
   
   
   
   
   
   
   
   
   
   
   
   
if(isset($_REQUEST['bookingfor']))
   {
       
       $settings=$db->get_row('settings');
       define(SITE_NAME,$settings['name']);
       
       
       
       $comid_data=explode("_", base64_decode($_REQUEST['bookingfor']));
       $comid=$comid_data['0'];
       $com_base64=$_REQUEST['bookingfor'];
       
 
   
   $allservices=$db->get_all('services',array('visibility_status'=>'active','company_id'=>$comid,'private_service'=>'no'));
   $reviews=$db->get_all('review',array('company_id'=>$comid,'status'=>'publish'));
   $count_review=count($reviews);
   $company_details=$db->get_row('company',array('id'=>$comid));
   
   
   /******************************************Preference Setting Information details************************************/
   $preferences_settings=$db->get_row('preferences_settings',array('company_id'=>$comid));
   define(DEFAULT_CALENDAR, $preferences_settings['default_calendar']);
   define(WEEK_START_DAY, $preferences_settings['week_start_day']);
   define(CUSTOM_TIME_SLOT, $preferences_settings['custom_time_slot']);
   define(CALENDAR_START_HOUR, $preferences_settings['calendar_start_hour']);
   define(SHOW_CALENDAR_STATS, $preferences_settings['show_calendar_stats']);
   define(PREFERRED_LANGUAGE, 'it');
   define(ENABLE_REVIEW, $preferences_settings['enable_review']);
   
   
   
if(file_exists(SERVER_ROOT.'/uploads/company/'.$comid.'/logo/'.$company_details['company_logo']) && (($company_details['company_logo'])!=''))
        { 
     $company_logo=SITE_URL.'/uploads/company/'.$comid.'/logo/'.$company_details['company_logo'];                 
        } 
      else
       {
      $company_logo="//www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image";
       } 
       
       $working_day=unserialize($db->get_var('company',array('id'=>$comid),'working_day'));
       $working_on_off=unserialize($db->get_var('company',array('id'=>$comid),'working_on_off'));
       $working_start_time=unserialize($db->get_var('company',array('id'=>$comid),'working_start_time'));
       $working_end_time=unserialize($db->get_var('company',array('id'=>$comid),'working_end_time'));
       
       
       if (is_array($working_day))
       {
           $business_day="";
           $offday=array();
           foreach ($working_day as $key=>$value)
           {
               $start=$working_start_time[$key];
               $end=$working_end_time[$key];
               
               $day_array=array('sunday','monday','tuesday','wednesday','thursday','friday','saturday');
               $day_array_key = array_search ($value, $day_array);
               $on_off=$working_on_off[$key];
               if ($on_off=="off")
               {
                   array_push($offday, $day_array_key);
               }
               
               $business_day.="{
                       dow: [".$day_array_key."],
                       start: '".$start."',
                       end: '".$end."'
                              }, ";
               
               
               
           }
       }
       if(!empty($offday))
       {
       $offday=array_reverse($offday);
       $offday_new=implode(",", $offday);
       }
      
}     
       
       ?> 
   
   
<style>.col1 {
   width: 220px;
   padding: 0;
   float: left;
   position: absolute;
   border: 1px solid #bbb;
   border-bottom-color: #999;
   min-height: 400px;
   box-shadow: 0 2px 5px rgba(0,0,0,.07);
   }
   .submit_btn {
   margin-left: 235px;
   margin-top: 25px;
   }
   
   
.navbar-brand {
     float: left;
     height: 50px; 
     padding: 15px 15px; 
     font-size: 18px; 
    line-height: 20px; 
}
</style>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>iwcn setmore</title>
      
      <link rel="shortcut icon" href="<?php echo SITE_URL;?>/assets/frontend/img/favicon.ico">
      <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:300,400,700|Roboto:300,400,700" rel="stylesheet">
      <link href="<?php echo SITE_URL;?>/assets/frontend/css/bootstrap.min.css" rel="stylesheet">
      <link href="<?php echo SITE_URL;?>/assets/frontend/css/style.css" rel="stylesheet">
      <link href="<?php echo SITE_URL;?>/assets/frontend/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
      <link href="<?php echo SITE_URL;?>/assets/frontend/plugins/switchery/switchery.min.css" rel="stylesheet">
      <link href="<?php echo SITE_URL;?>/assets/frontend/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet">
      <link href="<?php echo SITE_URL;?>/assets/frontend/css/custom.css" rel="stylesheet">
      <link href="<?php echo SITE_URL;?>/assets/frontend/plugins/dropzone/dropzone.css" rel="stylesheet">
      <link href="<?php echo SITE_URL;?>/assets/frontend/plugins/datatables/media/css/dataTables.bootstrap.css" rel="stylesheet">
      <link href="<?php echo SITE_URL;?>/assets/frontend/plugins/datatables/extensions/Responsive/css/dataTables.responsive.css" rel="stylesheet">
     
      <link href="<?php echo SITE_URL;?>/assets/frontend/plugins/dropzone/dropzone.css" rel="stylesheet">
      <link href="<?php echo SITE_URL;?>/assets/frontend/css/demo/jasmine.css" rel="stylesheet">
      <link href="<?php echo SITE_URL;?>/assets/frontend/plugins/summernote/summernote.min.css" rel="stylesheet">
 
      <link href="<?php echo SITE_URL;?>/assets/frontend/plugins/bootstrap-timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
      <link href="<?php echo SITE_URL;?>/assets/frontend/plugins/bootstrap-datepicker/bootstrap-datepicker.css" rel="stylesheet">
      <link href="<?php echo SITE_URL;?>/assets/frontend/plugins/pace/pace.min.css" rel="stylesheet">
  
      <script src="<?php echo SITE_URL;?>/assets/frontend/plugins/pace/pace.min.js"></script>
      <link href="<?php echo SITE_URL;?>/assets/frontend/rating/star-rating.min.css" rel="stylesheet">
      <script src="<?php echo SITE_URL;?>/assets/frontend/rating/jquery.min.js"></script>
      <script src="<?php echo SITE_URL;?>/assets/frontend/rating/star-rating.min.js"></script>
      <script src="<?php echo SITE_URL;?>/assets/frontend/iframe/booking_iframe.js"></script>
      
      <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.5.0/fullcalendar.min.css" rel="stylesheet">
      
      

   </head>
   <body>
      <div id="container" class="effect mainnav-out navbar-fixed mainnav-fixed">
         <header id="navbar" style="background-color: #54abd9;">
            <div id="navbar-container">
               <div class="navbar-header">
                  <a href="#" class="navbar-brand" style="width: auto !important;">
                     <img src="<?php echo $company_logo;?>" width="auto" height="60px">
                  </a>
               </div>
               <ul class="nav navbar-top-links pull-left hidden-xs  hidden-sm">
                   <li id="profilebtn" class="hidden-xs">
                                <a href="JavaScript:void(0);">
                                  <?php if ($company_details['company_name']!=""){ echo '<i class="fa fa-university text-primary"></i> '. ucwords($company_details['company_name']);}?>
                                   <br> 
                                 <?php if ($company_details['company_phone']!=""){ echo '<i class="fa fa-phone text-primary"></i> '. $company_details['company_phone'];}?><?php if ($company_details['company_email']!=""){ echo ',  <i class="fa fa-envelope text-primary"></i> '. $company_details['company_email'];}?>
                                    <br> 
                                 <?php if ($company_details['company_phone']!="" && $company_details['company_address']!=''){ echo '<i class="fa fa-map-marker text-primary add-popover" data-toggle="popover" data-placement="bottom" data-original-title="Bootstrap Popover" ></i> '.substr($company_details['company_address'].' '.$company_details['company_city'].' '.$company_details['company_state'],0,50);}?>
                                
                                 </a>
                         </li>
                   </ul>
               <div class="navbar-content clearfix">
                  <ul class="nav navbar-top-links pull-right">
                    <li class="dropdown hidden-md hidden-lg">
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle" aria-expanded="true"> <i class="fa fa-map-marker fa-2x"></i> </a>
                                <!--Notification dropdown menu-->
                                <div class="dropdown-menu dropdown-menu-md with-arrow">
                                    <div class="pad-all bord-btm">
                                       <div class="h4 text-muted text-thin mar-no"> Contact Details </div>
                                    </div>
                                    <div class="nano scrollable has-scrollbar" style="height: 245px;">
                                        <div class="nano-content" tabindex="0" style="padding:5px;">
                                            <ul class="head-list">
                                                <!-- Dropdown list-->
                                                <li>
                                                    
                                                       
                                                        <div class="media-body" style="color:black;">
                                                            <div class="text-nowrap"><?php if ($company_details['company_email']!=""){ echo '<i class="fa fa-globe text-primary"></i> '. $company_details['company_email'];}?></div>
                                                            <div class="text-nowrap"><?php if ($company_details['company_phone']!=""){ echo '<i class="fa fa-phone text-primary"></i> '. $company_details['company_phone'];}?></div>
                                                            <div class="text-nowrap"><?php
                                                            if ($company_details['company_address']!=""){
                                                              echo '<i class="fa fa-map-marker text-primary"></i> '.$company_details['company_address'].'<br> '.$company_details['company_city'].' '.$company_details['company_state'];}?></div>
                                                           
                                                        </div>
                                                    
                                                </li>
                                                <!-- Dropdown list-->
                                                
                                            </ul>
                                        </div>
                                  
                                </div>
                                </div>
                            </li>
                        <li>
                           <a data-toggle="tooltip"  data-original-title="Another tooltip"  href="<?php echo SITE_URL.'/company_booking_page_calendar.php?bookingfor='.$com_base64.'&tab=book_appointment';?>" class="add-tooltip <?php if($_REQUEST['tab']=='book_appointment' || $_REQUEST['tab']==''){echo "active";}?>">
                                 <i class="fa fa-calendar fa-2x"></i>
                                 </a>
                              </li>
                              <li>
                       <a data-toggle="tooltip"  data-original-title="Another tooltip" href="<?php echo SITE_URL.'/company_booking_page_calendar.php?bookingfor='.$com_base64.'&tab=staff_member';?>" class="add-tooltip <?php if($_REQUEST['tab']=='staff_member'){echo "active";}?>">
                                 <i class="fa fa-users fa-2x"></i>
                           </a>
                              </li>
                              <li>
                  <a data-toggle="tooltip"  data-original-title="Another tooltip" href="<?php echo SITE_URL.'/company_booking_page_calendar.php?bookingfor='.$com_base64.'&tab=services';?>" class="add-tooltip <?php if($_REQUEST['tab']=='services'){echo "active";}?>">
                                 <i class="fa fa-pencil-square-o fa-2x"></i>
                            </a>
                              </li>
                              <li>
                                 <?php  $review_company=$db->get_var('preferences_settings',array('company_id'=>$comid),'enable_review');
                                    if ($review_company=='yes'){?>
                <a data-toggle="tooltip" data-original-title="Another tooltip" href="<?php echo SITE_URL.'/company_booking_page_calendar.php?bookingfor='.$com_base64.'&tab=reviews';?>" class="add-tooltip <?php if($_REQUEST['tab']=='reviews'){echo "active";}?>">
                                 <i class="fa fa-star fa-2x"></i>
                                </a>
                                 <?php }?>
                              </li>
                     
                  </ul>
               </div>
            </div>
         </header>
         <div class="boxed">
        
            <section id="content-container">
           <?php echo $display_msg;?>
               
               <div id="page-content">
                  <div class="panel">
                     <div class="panel-body">
                    
                        <hr>
                        <div class="row">
                           <?php if($_REQUEST['tab']=='book_appointment'  || $_REQUEST['tab']==''){?>
                           <div class="col-md-8">
                            
                              <div id='demo-calendar12'></div>
                           </div>
                           <?php }elseif($_REQUEST['tab']=='staff_member'){?>
                           <div class="col-md-8">
                              <h4><i class="fa fa-user"></i> Service Provider</h4>
                              <table class="table">
                                 <thead>
                                    <tr>
                                       <th class="text-center"></th>
                                       <th></th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php 
                                       $db->order_by='user_id DESC';
                                       $allstaff=$db->get_all('users',array('visibility_status'=>'active','company_id'=>$comid));
                                       if (is_array($allstaff)){
                                           foreach ($allstaff as $alls){
                                               if ($db->exists('assign_services',array('staff_id'=>$alls['user_id'])))
                                               {  
                                               ?>
                                    <tr>
                                       <td class="text-center">
                                          <?php
                                             if(file_exists(SERVER_ROOT.'/uploads/company/'.$comid.'/users/'.$alls['user_id'].'/'.$alls['user_photo_file']) && (($alls['user_photo_file'])!=''))
                                             {?>
                                          <img class="img-circle img-sm" class="img-md" src="<?php echo SITE_URL.'/uploads/company/'.$comid.'/users/'.$alls['user_id'].'/'.$alls['user_photo_file'];?>">
                                          <?php } else{?>
                                          <img class="img-circle img-sm" src="<?php echo SITE_URL.'/assets/frontend/default_image/default_user_image.png';?>" alt="Profile Picture">
                                          <?php }?> 
                                       </td>
                                       <td ><a style="cursor:hand;" class="b1" cdata="<?php echo $comid;?>" data="<?php echo $alls['user_id'];?>"><?php echo ucwords($alls['firstname']." ".$alls['lastname']);?></a></td>
                                    </tr>
                                    <?php }}}?>
                                 </tbody>
                              </table>
                           </div>
                           <?php }elseif($_REQUEST['tab']=='services'){?>
                           <div class="col-md-8">
                              <h4><i class="fa fa-headphones"></i> All Services</h4>
                              <?php 
                                 if (is_array($allservices)){
                                 foreach ($allservices as $llser){?>
                              <div class="alert alert-success media fade in">
                                 <div class="media-left">
                                    <span class="icon-wrap icon-wrap-xs icon-circle alert-icon">
                                    <i class="fa fa-bolt fa-lg"></i>
                                    </span>
                                 </div>
                                 <div class="media-body">
                                    <div class="row">
                                       <div class="col-lg-6">
                                          <h4 class="alert-title"><?php echo ucwords($llser['service_name']);?></h4>
                                          <p class="alert-message"><?php echo ucwords($llser['service_description']);?></p>
                                       </div>
                                       <div class="col-lg-2 text-center"><?php echo $llser['service_time'];?>mins</div>
                                       <div class="col-lg-2 text-center"><?php echo $company_details['company_currencysymbol'].number_format($llser['service_cost'],'2');?></div>
                                       <div class="col-lg-2 text-center"><?php if ($llser['service_buffer_time']!=""){ echo $llser['service_buffer_time']."mins";}else{echo "No Buffer";}?></div>
                                    </div>
                                 </div>
                              </div>
                              <?php }                                        
                                 }?>
                           </div>
                           <?php }elseif($_REQUEST['tab']=='reviews'){?>
                           <div class="col-md-8">
                              <h4><?php  echo $count_review;?> Reviews <button type="button" class="btn btn-info pull-right" data-toggle="modal" data-target="#myModal_add_review"><i class="fa fa-edit"></i> Write Review</button></h4>
                              <table class="table table-hover table-vcenter">
                                 <thead>
                                    <tr>
                                       <th width="20%">&nbsp;</th>
                                       <th width="40%">&nbsp;</th>
                                       <th width="40%">&nbsp;</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                    <?php 
                                       if (is_array($reviews)){
                                           foreach ($reviews as $review_detail){
                                           ?>
                                    <tr>
                                       <td><?php echo date('D M d,Y',strtotime($review_detail['created_date']));?></td>
                                       <td><?php echo ucwords($review_detail['review_provider_name']);?><br> <?php echo ucfirst($review_detail['review_detail']);?> 
                                       </td>
                                       <td> <?php 
                                          $rating= $review_detail['rating'];
                                          for ($x = 1; $x <= 5; $x++) {?>
                                          <?php if($x<=$rating){?><i style="color:#ed8323;" class="fa fa-star"></i><?php }else{?>
                                          <i class="fa fa-star-o"></i>
                                          <?php }}?>  
                                       </td>
                                    </tr>
                                    <?php }}?>
                                 </tbody>
                              </table>
                           </div>
                           <?php }?>
                           <div class="col-md-4" id="show_provider_detail" style="border-left: 1px solid #ccc;">
                           
                           <?php if($_REQUEST['tab']!='services'){?>
                           
                            <div class="panel">
                                <div class="panel-heading">
                                        <h4><strong class="text-danger"><i class="fa fa-headphones"></i> Company&#39;s  Services</strong></h4>
                                       
                                    </div>
                                    <div class="panel-body np">
                                      <div id="demo-chat-body" class="collapse in">
                                            <div class="nano has-scrollbar" style="height:200px">
                                                <div class="nano-content pad-all" tabindex="0">
                                             <table class="table has-scrollbar" >  
                                            
                                            <tbody>
                                            <?php $services=$db->get_all('services',array('visibility_status'=>'active',
                                                                                          'company_id'=>$comid,
                                                                                          'private_service'=>'no'
                                            ));
                                            if (is_array($services)){
                                                foreach ($services as $als){
                                                   
                                                    ?>
                                                 <tr>
                                                  <td title="service Name"><?php echo ucwords($als['service_name']);?></td>
                                                  <td title="service cost"><?php echo $company_details['company_currencysymbol'].number_format($als['service_cost'],'2');?></td>
                                                  <td title="service + buffer time"><?php echo $als['service_time']+$als['service_buffer_time'];?> Min</td>
                                                   </tr>
                                                <?php }}?>
                                                
                                               </tbody>
                                        </table> 
                                                </div>
                                            <div class="nano-pane">
                                            <div class="nano-slider" style="height: 92px; transform: translate(0px, 0px);"></div>
                                            </div>
                                            </div>
                                          
                                        </div>
                                        <!--===================================================-->
                                        <!--Chat widget-->
                                    </div>
                                </div>
                           
                                    <?php }?> 
                              <h4><strong class="text-danger"><i class="fa fa-clock-o"></i> Company&#39;s Weekly Schedule</strong></h4>
                              <hr>
                              <table class="table">
                                 <tbody>
                                    <?php 
                                       $company_details=$db->get_row('company',array('id'=>$comid));
                                       $working_day=unserialize($company_details['working_day']);
                                       $working_on_off=unserialize($company_details['working_on_off']);
                                       $working_start_time=unserialize($company_details['working_start_time']);
                                       $working_end_time=unserialize($company_details['working_end_time']);
                                       if (is_array($working_day)){
                                           foreach ($working_day as $key=>$value){
                                               $day_name=$value;
                                               $on_off=$working_on_off[$key];
                                               $starttime=$working_start_time[$key];
                                               $endtime=$working_end_time[$key];
                                           ?>
                                    <tr>
                                       <td><?php echo ucfirst($day_name);?></td>
                                       <?php if ($on_off=="on"){?> 
                                       <td><?php echo $starttime;?> - <?php echo $endtime;?></td>
                                       <?php }else{?>
                                       <td>Closed</td>
                                       <?php }?>
                                    </tr>
                                    <?php }}?>
                                 </tbody>
                              </table>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </section>
            
            

         </div>
      </div>
      <!-- Modal box to Add Appointment --> 
      <div id="myModal_add_review" class="modal fade" role="dialog">
         <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
               <div id="after_post_message_review"></div>
               <form method="post" class="form-horizontal form-bordered" action="" enctype="multipart/form-data" id="add_review_form">
                  <input type="hidden" name="add_review_submit" value="add_review_submit" >
                  <input type="hidden" name="company_id" value="<?php echo $comid;?>" >
                  <div class="modal-header">
                     <h4 class="modal-title">Add Review</h4>
                  </div>
                  <div class="modal-body">
                     <div class="form-group">
                        <label class="control-label col-md-3 col-sm-4 col-xs-4">Rating</label>
                        <div class="col-md-8 col-sm-8 col-xs-8">
                           <input autocomplete="off" name="rating_stars" min ="1" max="5" type="number" class="rating" data-size="lg">
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="control-label col-md-3 col-sm-4 col-xs-4">Name <font color="red">*</font></label>
                        <div class="col-md-8 col-sm-8 col-xs-8">
                           <input class="form-control" type="text" name="review_provider_name" value=""> 
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="control-label col-md-3 col-sm-4 col-xs-4">Email <font color="red">*</font></label>
                        <div class="col-md-8 col-sm-8 col-xs-8">
                           <input class="form-control" type="text" name="review_email" value=""> 
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="control-label col-md-3 col-sm-4 col-xs-4">Notes</label>
                        <div class="col-md-8 col-sm-8 col-xs-8">
                           <textarea class="form-control" rows="5" name="review_detail"></textarea>
                           <p>Only 250 characters allow</p>
                        </div>
                     </div>
                  </div>
                  <div class="modal-footer">
                     <button class="btn btn-info" name="submit" type="submit">Submit</button>
                     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
               </form>
            </div>
         </div>
      </div>
      <!-- Modal box to Edit Appointment --> 
      

  <div id="fullCalModal_add_appointment" class="modal fade">
                        <div class="modal-dialog">
                        <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="js-title-step"></h4>
                                    <div id="after_post_message"></div>
                                </div>
                                <div class="modal-body">
                                
                                
              <form class="form-horizontal form-bordered" method="POST" id="wizard_form">
                  <input type="hidden" name="add_appointment_form_submit" value="add_appointment_form_submit">
                  <input type="hidden" name="company_id" value="<?php echo $comid;?>" id="get_company_id">
                  <input type="hidden" name="booking_from" value="company_booking_page">
                                 
           <div class="row hide" data-step="1" data-title="Appointment details (Click next please)">
             <div class="col-md-12">
            
                         <div class="form-group">
                           <label class="control-label col-md-3 col-sm-4 col-xs-4">Service<font color="red">*</font></label>
                           <div class="col-md-8 col-sm-8 col-xs-8">
                               <select class="form-control" name="service_id" id="load_provider">
                               <option value="">---Seleziona------ </option>
                            <?php if (is_array($allservices)){
                                                foreach ($allservices as $llser){?>
                                                 <option value="<?php echo $llser['id'];?>"><?php echo ucwords($llser['service_name']);?></option>
                               <?php }}?>
                            
                              </select>
                           </div>
                        </div>                 
                         <div class="form-group">
                           <label class="control-label col-md-3 col-sm-4 col-xs-4">Provider<font color="red">*</font></label>
                           <div class="col-md-8 col-sm-8 col-xs-8">
                              <select class="form-control" name="staff_id"  id="show_provider">
                              <option value="">---Seleziona--- </option>
                             </select>
                           </div>
                        </div>
 
           
              <div class="form-group">
               <label class="control-label col-md-3 col-sm-4 col-xs-4">Time</label>
               
               <div class="col-md-8 col-sm-8 col-xs-8"> 
               <input class="form-control datepicker" type="hidden" name="appointment_date" value="" id="get_date_calender" readonly>
                     <select class="form-control" name="appointment_time" id="load_time_slot">
                     </select>
                     <p>Selected date: <span class="get_date_calender_format text-danger"></span></p>
               </div>
            </div> 
             <div class="form-group">
               <label class="control-label col-md-3 col-sm-4 col-xs-4">Notes</label>
               <div class="col-md-8 col-sm-8 col-xs-8">
                  <input class="form-control" type="text" name="appointment_notes" value="">
                   
               </div>
            </div>
                                            
                                          
                                        </div>
                                    </div>
                                    <div class="row hide" data-step="2" data-title="Customer details (Click finish to complete booking)">
                                        <div class="col-md-12">
                                        
                                         
                                             <div class="form-group">
                           <label class="control-label col-md-3 col-sm-4 col-xs-4">Email<font color="red">*</font></label>
                           <div class="col-md-9 col-sm-8 col-xs-8">
                              <input class="form-control" placeholder="name@address.com" type="text" name="email"> 
                           </div>
                        </div>
                        <div class="form-group">
                           <label class="control-label col-md-3 col-sm-4 col-xs-4">Name<font color="red">*</font></label>
                           <div class="col-md-5 col-sm-4 col-xs-4">
                              <input class="form-control" placeholder="First Name" type="text" name="first_name" >
                           </div>
                           <div class="col-md-4 col-sm-4 col-xs-4">
                           <input class="form-control" placeholder="Last Name" type="text" name="last_name" >
                           </div>
                        </div>
                        
                           <div class="form-group">
                           <label class="control-label col-md-3 col-sm-4 col-xs-4">Contacts<font color="red">*</font></label>
     
                           <div class="col-md-3 col-sm-8 col-xs-8">
                              <input class="form-control" placeholder="Mobile" type="text" name="mobile_number">
                           </div>
                           <div class="col-md-3 hidden-sm hidden-xs">
                              <input class="form-control" placeholder="Office Phone" type="text" name="office_phone_number">
                           </div>
                           <div class="col-md-3 hidden-sm hidden-xs">
                              <input class="form-control" placeholder="Home Phone" type="text" name="home_phone_number">
                           </div>
                        </div>
                     <div class="form-group">
                           <label class="control-label col-md-3 col-sm-4 col-xs-4">Address</label>
                           <div class="col-md-9 col-sm-8 col-xs-8">
                              <textarea class="form-control" placeholder="address" rows="5" name="address"></textarea>
                           </div>
                        </div>
                          <div class="form-group hidden-sm hidden-xs">
                           <label class="control-label col-md-3 col-sm-4 col-xs-4"></label>
                           <div class="col-md-3">
                              <input class="form-control" placeholder="city" type="text" name="city">
                           </div>
                            <div class="col-md-3">
                              <input class="form-control" placeholder="state" type="text" name="state">
                           </div>
                            <div class="col-md-3">
                              <input class="form-control" placeholder="zip" type="text" name="zip" >
                           </div>
                        </div>
           
                                        </div>
                                    </div>
                                    
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default js-btn-step pull-left" data-orientation="cancel" data-dismiss="modal"></button>
                                    <button type="button" class="btn btn-warning js-btn-step" data-orientation="previous"></button>
                                    <button type="button" class="btn btn-success js-btn-step" data-orientation="next" id="complete"></button>
                                </div>
                            </div>
                            
                        </div>
                    </div>
      <script src="<?php echo SITE_URL;?>/assets/frontend/js/jquery-2.1.1.min.js"></script> 
      <script src="<?php echo SITE_URL;?>/assets/frontend/js/jquery-ui.min.js"></script>
      <script src="<?php echo SITE_URL;?>/assets/frontend/js/bootstrap.min.js"></script>
      <script src="<?php echo SITE_URL;?>/assets/frontend/plugins/fast-click/fastclick.min.js"></script>
      <script src="<?php echo SITE_URL;?>/assets/frontend/js/scripts.js"></script>
      <script src="<?php echo SITE_URL;?>/assets/frontend/plugins/nanoscrollerjs/jquery.nanoscroller.min.js"></script>
      <script src="<?php echo SITE_URL;?>/assets/frontend/plugins/metismenu/metismenu.min.js"></script>
      <script src="<?php echo SITE_URL;?>/assets/frontend/plugins/switchery/switchery.min.js"></script>
      <script src="<?php echo SITE_URL;?>/assets/frontend/plugins/bootstrap-select/bootstrap-select.min.js"></script> 
      <script src="<?php echo SITE_URL;?>/assets/frontend/plugins/screenfull/screenfull.js"></script>
      
     

        
      <!--DataTables [ OPTIONAL ]--> 
      <script src="<?php echo SITE_URL;?>/assets/frontend/plugins/datatables/media/js/jquery.dataTables.js"></script>
      <script src="<?php echo SITE_URL;?>/assets/frontend/plugins/datatables/media/js/dataTables.bootstrap.js"></script>
      <script src="<?php echo SITE_URL;?>/assets/frontend/plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
      <script src="<?php echo SITE_URL;?>/assets/frontend/js/demo/tables-datatables.js"></script>
      <script src="<?php echo SITE_URL;?>/assets/frontend/plugins/summernote/summernote.min.js"></script>
      <!--Full Calendar [ OPTIONAL ]--> 
      <script src="<?php echo SITE_URL;?>/assets/frontend/plugins/fullcalendar/lib/moment.min.js"></script> 
      <script src="<?php echo SITE_URL;?>/assets/frontend/plugins/fullcalendar/lib/jquery-ui.custom.min.js"></script> 
      <script type="text/javascript" src="https://fullcalendar.io/releases/fullcalendar/3.9.0/lib/moment.min.js"></script>
      <script src="<?php echo SITE_URL;?>/assets/frontend/plugins/fullcalendar/fullcalendar.min.js"></script>
      <script type="text/javascript" src="https://fullcalendar.io/releases/fullcalendar/3.9.0/locale-all.js"></script>
      <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.5.0/fullcalendar.min.js"></script> --> 
      
      
      <script src="<?php echo SITE_URL;?>/assets/frontend/js/jquery-bootstrap-modal-steps.min.js"></script> 
      

 <script>

$(document).ready(function() {
var lang = 'it';
$('#demo-calendar13').fullCalendar({
	header: { 
       left: 'myCustomButton', 
       center: 'today, prev, title, next',
       right: 'month,agendaWeek,agendaDay'
   },
   timeFormat: 'hh:mm',//'hh:mm:ss a',
  editable: false,
  locale: lang,
  droppable: true, // this allows things to be dropped onto the calendar
  defaultView: '<?php if (DEFAULT_CALENDAR=="daily"){echo 'agendaDay';}elseif (DEFAULT_CALENDAR=='weekly'){echo 'agendaWeek';}else{echo 'month';}?>',
  defaultDate: '<?php echo date('Y-m-d');?>',
  firstDay:'<?php echo WEEK_START_DAY;?>',
  slotDuration:'<?php if (CUSTOM_TIME_SLOT=="5"){echo '00:05:00';}elseif (CUSTOM_TIME_SLOT=="15"){echo '00:15:00';}elseif (CUSTOM_TIME_SLOT=='30'){echo '00:30:00';}elseif(CUSTOM_TIME_SLOT=='60'){echo '01:00:00';}?>',
  locale:'<?php echo PREFERRED_LANGUAGE; ?>',
  scrollTime :"<?php echo CALENDAR_START_HOUR; ?>", //3pm
 //  minTime:'09:00:00',
 //  maxTime:'19:30:00',  
   selectable: true,  
   selectHelper: true,
   select: function(start, end)
    {
    var allDay = !start.hasTime() && !end.hasTime();
       $("#get_date_calender").val(moment(start).format('YYYY-MM-DD')); 
       $(".get_date_calender_format").html(moment(start).format('DD-MM-YYYY'));
       $('#fullCalModal_add_appointment').modal();   
       $('#demo-calendar12').fullCalendar('unselect');
    },
  
  eventLimit: true, // allow "more" link when too many events
  businessHours: [<?php echo $business_day;?> ],
   hiddenDays: [<?php echo $offday_new;?>],

});

});

</script>

<script>
/*******************************************add appoint ment******************************/
$("button#complete").click(function(e){
        	e.preventDefault();
        	e.stopPropagation();
    		var step=$(this).attr('data-step');
        	
        	if(step=='complete')
            	{
        	   $.ajax({
                	type: "POST",
                	url: "wizardpost.php",
                	data: $('#wizard_form').serialize(),
                	dataType: 'json',
                	success: function(data){
                    $("#after_post_message").html(data.msg);
                 if(data.error==false){
            	    	  setTimeout(function(){
            	    		  window.location = '<?php echo SITE_URL?>/company_booking_page_calendar.php?bookingfor=<?php echo $_REQUEST[bookingfor]?>';
            	                },3000);
                           }
                	}
                	});
            	}
    	});
</script>  



<script>
/*******************************************Load provider by service id******************************/
$("#load_provider").change(function(){
var service_id=$(this).val();
var get_company_id=$("#get_company_id").val();
$.ajax({
            type: 'post',
            url: 'company_booking_calendar_ajax.php',
            data:'&load_provider_by_service='+service_id+'&company_id='+get_company_id,
            success: function (data) {
            	$("#show_provider").html(data);
                                     }
     });


	
	});



</script>
<script> 
/*******************************************Load provider details by provider id******************************/
     $(".b1").click(function () {
      var idnew=$(this).attr("data");
      var cidnew=$(this).attr("cdata");

     $("#service_provider_id").val(idnew);
      
    // alert(idnew);
      	$.ajax({
  	  	  type: "POST",
  	  	  url: "company_booking_calendar_ajax.php",
  	  	  data:'load_provider_detail='+idnew + '&company_id='+cidnew, 
  	   	  success: function (data) {
  	  	   	 $("#show_provider_detail").html(data);
  	  	  	
    	   	}
  	  	});
 	});
   </script>
   <script>
/************************Add review***********************************************/
$(function () {

	  $('#add_review_form').on('submit', function (e) {
		e.preventDefault();
	    $.ajax({
	      type: 'post',
	      url: 'company_booking_calendar_ajax.php',
	      data: $('#add_review_form').serialize(),
	      dataType: 'json',
	      success: function (data) {
	     	//alert(data);
	      $("#after_post_message_review").html(data.msg);
	   /*   if(data.error==false){
	    	  setTimeout(function(){
	    		  window.location = '';
	                },3000);
               }
	  */
          }
	    }); 

	  });

	});
</script>     

         
     
<script>
         
          $('.datepicker').datepicker({
          	  format: "dd-mm-yyyy",
              todayBtn: "linked",
              autoclose: true,
              todayHighlight: true,
              startDate: new Date()});   
 
</script>
        
        <script>
        $('#fullCalModal_add_appointment').modalSteps({
        	btnLastStepHtml: 'Finish'}); 
</script>
    
<script>
/********************************************load time sloat by staff id***********************/
    $('#show_provider').change(function(){
    	var pid=$(this).val();
    	var date=$("#get_date_calender").val();
     
    	 $.ajax({
    	      type: 'post',
    	      url: 'company_booking_calendar_ajax.php',
    	      data:'&load_time_range='+pid+'&adate='+date,
    	      success: function (data) {
        	$("#load_time_slot").html(data);   
    		 }
    	    });     
    });
</script>     
      
        
        
   </body>
</html>