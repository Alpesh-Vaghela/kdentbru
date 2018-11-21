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

//require(SERVER_ROOT . '/protected/setting/router.php');

$db = new db("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);

// this is for date function
function createDateRangeArray($strDateFrom,$strDateTo)
{
    // takes two dates formatted as YYYY-MM-DD and creates an
    // inclusive array of the dates between the from and to dates.

    // could test validity of dates here but I'm already doing
    // that in the main script

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
///
$comid=1;
$allservices=$db->get_all('services',array('visibility_status'=>'active','company_id'=>$comid));
$common_data_company_setting=$db->get_row('company',array('id'=>$comid));
$reviews=$db->get_all('review',array('company_id'=>$comid,'status'=>'publish'));
$count_review=count($reviews);


$settings=$db->get_row('settings');
define(SITE_NAME,$settings['name']);

$common_data_company_setting=$db->get_row('company',array('id'=>1));
define(CURRENCY, $common_data_company_setting['company_currencysymbol']);

/*****************add Staff modal box submit****************/

if (isset($_POST['add_appointment_form_submit']))
{
   $service_id=$_POST['service_id'];
   $service_provider=$_POST['staff_id'];

   $appointment_date=$_POST['appointment_date'];
   $appointment_time=$_POST['appointment_time'];
   $appointment_month=date('m',strtotime($appointment_date));
   $appointment_year=date('Y',strtotime($appointment_date));
   
   $email=$_POST['email'];
   $first_name=$_POST['first_name'];
   $last_name=$_POST['last_name'];
   $mobile_pre_code=$_POST['mobile_pre_code'];
   $mobile_number=$_POST['mobile_number'];
   $office_phone_number=$_POST['office_phone_number'];
   $home_phone_number=$_POST['home_phone_number'];
   $address=$_POST['address'];
   $city=$_POST['city'];
   $state=$_POST['state'];
   $zip=$_POST['zip'];
   $appointment_notes=$_POST['appointment_notes'];
   $visibility_status='active';
   
   $created_date=date('Y-m-d');
   $ip_address=$_SERVER['REMOTE_ADDR'];
   
   $appointment_service_cost=$db->get_var('services',array('id'=>$service_id),'service_cost');
   $appointment_service_time=$db->get_var('services',array('id'=>$service_id),'service_time');
    
    
   /**********************check staff on leave or not**************************************/
   $t=true;
   $alloff=$db->get_all('timeoff',array('staff_id'=>$service_provider,'company_id'=>$comid));
 
   if (is_array($alloff))
   {
       foreach ($alloff as $altoff)
       {
         $strDateFrom=$altoff['start_date'];
         $strDateTo=$altoff['end_date'];
          $leave_date_array=createDateRangeArray($strDateFrom, $strDateTo);
           
           if (is_array($leave_date_array) && in_array($appointment_date, $leave_date_array))
           {
               $t=false;
           }
       }
   }
   /*******************Check Appontment time exist in working  time or not on working day  ************/
   $dayName=date("l", strtotime($appointment_date));
   $working_day=unserialize($db->get_var('users',array('user_id'=>$service_provider),'working_day'));
   $working_on_off=unserialize($db->get_var('users',array('user_id'=>$service_provider),'working_on_off'));
   $working_start_time=unserialize($db->get_var('users',array('user_id'=>$service_provider),'working_start_time'));
   $working_end_time=unserialize($db->get_var('users',array('user_id'=>$service_provider),'working_end_time'));
   
   $w=true;
   if (is_array($working_day))
   {
       foreach ($working_day as $key=>$value)
       {
           if (ucfirst($value)==$dayName)
           {
   
               $on_off=$working_on_off[$key];
               $startt=$working_start_time[$key];
               $endt=$working_end_time[$key];
               if ($on_off!="on")
               {
                   $w=false;
               }
               else
               {
   
                   $sunrise=$startt;
                   $sunset=$endt;
                   $date1 = DateTime::createFromFormat('H:i', $appointment_time);
                   $date2 = DateTime::createFromFormat('H:i', $sunrise);
                   $date3 = DateTime::createFromFormat('H:i', $sunset);
                   if ($date1 > $date2 && $date1 < $date3)
                   {
                       $w=true;
                   }else
                   {
                       $w=false;
                   }
               }
           }
   
       }
   }
   $empt_fields = emptyfields(array('Email Address'=>$email,
       'Service Name'=>$service_id,
      //'Service Provider Name'=>$service_provider,
       'First Name'=>$first_name,
       'Mobile Number'=>$mobile_number,
       'Appointment Date'=>$appointment_date,
       'Appointment Time'=>$appointment_time,
   
   ));
   if ($empt_fields)
   {
       $display_msg= '<div class="alert alert-danger text-danger">
		<i class="fa fa-frown-o"></i> <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
          Oops! Following fields are empty<br>'.$empt_fields.'</div>';
   }
   
   elseif (!filter_var ( $email, FILTER_VALIDATE_EMAIL ))
   {
       $display_msg= '<div class="alert alert-danger text-danger ">
		<i class="fa fa-frown-o"></i>
            <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
            Oops! Wrong Email Format.
		</div>';
   }
    elseif ($db->exists('customers',array('email'=>$email,'company_id'=>$comid)))
    {
        $display_msg= '<div class="alert alert-danger text-danger">
    		<i class="fa fa-frown-o"></i> <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
                This contact is already exist.
    		</div>';
    }   
    elseif (!preg_match ( '/^[0-9][0-9\s]*$/', $appointment_service_cost ))
    {
        $display_msg= '<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
                        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
                        Service Cost Should be Numeric!.
    					</div>';
      
    }
    elseif (!preg_match ( '/^[0-9][0-9\s]*$/', $appointment_service_time ))
    {
        $display_msg= '<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
                        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
                        Service Time Should be Numeric!.
    					</div>';
       
    }
    elseif ($t==false)
    {
        $display_msg= '<div class="alert alert-danger text-danger">
            <i class="fa fa-frown-o text-danger"></i>
                        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
                        Service provider on leave. Please select other service provider
    					</div>';
       
    }
    elseif ($w==false)
    {
       $display_msg= '<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
                        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
                        Service Provider is not available at this time!
    					</div>';
       
    }
       elseif (strtotime($appointment_date." ".$appointment_time) < strtotime(date('Y-m-d H:i ')))
    {
        $display_msg= '<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
                        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
                        Appointment date should be greater than today date!
    	 </div>';
    }
   else
   {
   
       $insert=$db->insert("customers",array('company_id'=>$comid,
           'email'=>$email,
           'first_name'=>$first_name,
           'last_name'=>$last_name,
           'mobile_number'=>$mobile_number,
           'office_phone_number'=>$office_phone_number,
           'home_phone_number'=>$home_phone_number,
           'address'=>$address,
           'city'=>$city,
           'state'=>$state,
           'zip'=>$zip,
           'visibility_status'=>$visibility_status,
           'created_date'=>$created_date,
           'ip_address'=>$ip_address));

       $last_insert_id=$db->insert_id;
       
      $insert=$db->insert('appointments',array('company_id'=>$comid,
           'customer_id'=>$last_insert_id,
           'staff_id'=>$service_provider,
           'service_id'=>$service_id,
           'service_time'=>$appointment_service_time,
           'service_cost'=>$appointment_service_cost,
           'appointment_date'=>$appointment_date,
           'appointment_time'=>date('H:i:s',strtotime($appointment_time)),
           //     'appointment_time'=>$appointment_time,
           'notes'=>$appointment_notes,
           'booking_id'=>time(),
           'appointment_month'=>$appointment_month,
           'appointment_year'=>$appointment_year,
           'status'=>'pending',
           'created_date'=>$created_date,
           'ip_address'=>$ip_address));
   
        if ($insert){
        $event="<b>Customer</b>  ".ucfirst($first_name)." ".ucfirst($last_name). " was added";
        $db->insert('activity_logs',array('user_id'=>$_SESSION['user_id'],
                                          'event_type'=>'customer_created',
                                          'event'=>$event,
                                          'company_id'=>CURRENT_LOGIN_COMPANY_ID,
                                          'event_type_id'=>$last_insert_id,
                                          'created_date'=>date('Y-m-d'),
                                          'ip_address'=>$_SERVER['REMOTE_ADDR']

        ));
                 $display_msg= '<div class="alert alert-success text-success">
                    		<i class="fa fa-smile-o"></i>
                      <button class="close" data-dismiss="alert" type="button">
                      <i class="fa fa-times-circle-o"></i></button> Appointment save successfully.
                    		</div>';

          echo "<script>
                         setTimeout(function(){
        	    		  window.location = 'company_booking_page.php?bookingfor=1&tab=book_appointment'
        	                },3000);</script>";



    }
   }
}
/*****************add Staff modal box submit****************/

if (isset($_POST['add_review_form_submit']))
{
    $review_provider_name=$_POST['review_provider_name'];
    $review_email=$_POST['review_email'];
    $review_detail=$_POST['review_detail'];
    $status='pending';
    $visibility_status='active';
    $created_date=date('Y-m-d');
    $ip_address=$_SERVER['REMOTE_ADDR'];



    $insert=$db->insert('review',array('company_id'=>$comid,
        'review_provider_name'=>$review_provider_name,
        'review_email'=>$review_email,
        'review_detail'=>$review_detail,
        'status'=>$status,
        'created_date'=>$created_date,
        'ip_address'=>$ip_address,
    ));
   // $db->debug();
    if ($insert){

        $display_msg= '<div class="alert alert-success text-success">
                    	<i class="fa fa-smile-o"></i>
                        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
                         Review Added Successfully.!
                        </div>';

        echo "<script>
                         setTimeout(function(){
        	    		  window.location = 'company_booking_page.php?bookingfor=1&tab=reviews'
        	                },3000);</script>";

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

</style>


<!DOCTYPE html>
<html lang="en">
    <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title> <?php echo SITE_NAME;?></title>
        <link rel="shortcut icon" href="<?php echo SITE_URL.'/assets/frontend/img/favicon.ico';?>">
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:300,400,700|Roboto:300,400,700" rel="stylesheet"> <!--Roboto Slab Font [ OPTIONAL ] -->
        <link href="<?php echo SITE_URL.'/assets/frontend/css/bootstrap.min.css';?>" rel="stylesheet"><!--Bootstrap Stylesheet [ REQUIRED ]-->
        <link href="<?php echo SITE_URL.'/assets/frontend/css/style.css';?>" rel="stylesheet"><!--Jasmine Stylesheet [ REQUIRED ]-->
        <link href="<?php echo SITE_URL.'/assets/frontend/plugins/font-awesome/css/font-awesome.min.css';?>" rel="stylesheet"><!--Font Awesome [ OPTIONAL ]-->
        <link href="<?php echo SITE_URL.'/assets/frontend/plugins/switchery/switchery.min.css';?>" rel="stylesheet"><!--Switchery [ OPTIONAL ]-->
        <!--Demo [ DEMONSTRATION ]-->
        <link href="<?php echo SITE_URL.'/assets/frontend/css/demo/jquery-steps.min.css';?>" rel="stylesheet">
       <!--Bootstrap Timepicker [ OPTIONAL ]-->
        <link href="<?php echo SITE_URL.'/assets/frontend/plugins/bootstrap-timepicker/bootstrap-timepicker.min.css';?>" rel="stylesheet">
        <!--Bootstrap Datepicker [ OPTIONAL ]-->
        <link href="<?php echo SITE_URL.'/assets/frontend/plugins/bootstrap-datepicker/bootstrap-datepicker.css';?>" rel="stylesheet">
        
      </head>
    <!--TIPS-->
    <!--You may remove all ID or Class names which contain "demo-", they are only used for demonstration. -->
    <body>
        <div id="container" class="">
            
            <div class="boxed">
                <!--CONTENT CONTAINER-->
                <!--===================================================-->
                <div id="content-container">
                   <div id="page-content">
                     <div class="row">
                   
                          <?php echo $display_msg;?>
                              <div class="col-md-3">
                                <div class="panel">
                                    <h3 class="panel-title"> 
                                     <?php if(file_exists(SERVER_ROOT.'/uploads/company/'.$comid.'/logo/'.$common_data_company_setting['company_logo']) && (($common_data_company_setting['company_logo'])!=''))
                                  { ?>
                                    <img src="<?php echo SITE_URL.'/uploads/company/'.$comid.'/logo/'.$common_data_company_setting['company_logo'];?>" width="40%" style="margin-bottom: -33px;">
                                   <?php } else{?>
                                  	<img src="//www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image"  width="50%">
                                 <?php } ?>
                                 </h3>
                                    <div class="panel-body">
                                        <div class="list-group">
                                            <a href="company_booking_page.php?bookingfor=1&tab=book_appointment" class="list-group-item <?php if($_REQUEST['tab']=='book_appointment' || $_REQUEST['tab']==''){echo "active";}?>"> <i class="btn btn-default btn-icon btn-circle icon-lg fa fa-calendar"></i> Book Appointment </a>
                                            <a href="company_booking_page.php?bookingfor=1&tab=staff_member" class="list-group-item <?php if($_REQUEST['tab']=='staff_member'){echo "active";}?>"><i class="btn btn-default btn-icon btn-circle icon-lg fa fa-users"></i> Staff Members</a>
                                            <a href="company_booking_page.php?bookingfor=1&tab=services" class="list-group-item <?php if($_REQUEST['tab']=='services'){echo "active";}?>"> <i class="btn btn-default btn-icon btn-circle icon-lg fa fa-pencil-square-o"></i> Services</a>
                                          <?php  $review_company=$db->get_var('preferences_settings',array('company_id'=>$comid),'enable_review');
                                           if ($review_company=='yes'){?>
                                           <a href="company_booking_page.php?bookingfor=1&tab=reviews" class="list-group-item <?php if($_REQUEST['tab']=='reviews'){echo "active";}?>"> <i class="btn btn-default btn-icon btn-circle icon-lg fa fa-star"></i> Reviews</a>
                                      <?php }?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          
                            <div class="col-md-9">
                            <div class="panel">
                                    <div class="panel-body">
                                     <h2>Massage Center Test durgesh</h2>
                                       <div class="row">
                                    <?php if($_REQUEST['tab']=='book_appointment'  || $_REQUEST['tab']==''){?>
                                    <div class="col-md-9">
                                   <!-- START Form Wizard -->
                                        <form class="form-horizontal form-bordered" method="POST">
                                        <div id="wizard"> 
                                            <!-- Wizard Container 1 -->
                                            <div class="wizard-title"> Service </div>
                                            <div class="wizard-container">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                    <h4>Choose Service</h4>
					                     <h5>All Service</h5>
                                                    </div>
                                                </div>
                                             <?php 
                                    if (is_array($allservices)){
                                    foreach ($allservices as $llser){?>
                                        <div class="media fade in">
                                            <div class="media-body">
                                            <a>
                                            <div class="row">
                                            
                                          <div class="col-lg-4">
                                               <h4 class="alert-title">
                                               <input type="radio" name="service_id" onClick="reply_click(this.id)" id="<?php echo $llser['id'];?>" value="<?php echo $llser['id'];?>">&nbsp;&nbsp;&nbsp;&nbsp; <?php echo ucwords($llser['service_name']);?></h4>
                                               </div>
                                            <div class="col-lg-2 text-center"><?php echo $llser['service_time'];?> mins</div>
                                            <div class="col-lg-2 text-center"><?php echo CURRENCY." ".number_format($llser['service_cost'],'2');?></div>
                                            <div class="col-lg-4 text-center"><?php if ($llser['service_buffer_time']!=""){ echo $llser['service_buffer_time']." mins";}else{echo "No Buffer";}?></div>
                                            </div>
                                            </a>
                                            </div>
                                            
                                       </div>
                                    <?php }}?>
                                       </div>
                                            <!--/ Wizard Container 1 --> 
                                            <!-- Wizard Container 2 -->
                                            <div class="wizard-title"> Providers </div>
                                            <div class="wizard-container">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                    <input type="hidden" id="service_provider_id" name="service_provider_id" value="">
                                                    </div>
                                                </div>
                                                <h3>
								                  <span id="no_provider"></span>
							                              </h3>
                                               <div class="row" id="show_provider"></div>
                                         </div>
                                       <!--/ Wizard Container 2 -->
                                            <!-- Wizard Container 3 -->
                                            <div class="wizard-title"> Date </div>
                                            <div class="wizard-container">
                                                <div class="form-group">
                                                  <div class="col-md-12">
                                                  <h4 class="semibold text-primary"> 
                                                  <i class="fa fa-book"></i> Choose a Date and Time (SGT)</h4>
                                                  </div>
                                             
                                             <div class="row">
                                            <div class="col-md-12">
                                              <div class="form-group">
                                           <label class="control-label col-md-3">Day/Time</label>
                                           <div class="col-md-5">
                                              <input class="form-control datepicker" type="text" name="appointment_date" value="">
                                           </div>
                                           <div class="col-md-3">
                                              <select class="form-control" name="appointment_time">
                  <?php  $times = create_time_range('8:00', '16:00', '15 mins', $format = '24');
                  if (is_array($times)){
                      foreach ($times as $t)
                      {?>
                       <option value="<?php echo $t;?>"><?php echo date('g:iA',strtotime($t));?></option>   
                      <?php }}?>
                      </select>
                                           </div>
                                        </div>
                                           </div>
                                            </div>
                                            
                                           </div>
                                         
                                            </div>
                                            <!--/ Wizard Container 3 -->
                                            <!-- Wizard Container 4 -->
                                            <div class="wizard-title"> Your INFO</div>
                                            <div class="wizard-container">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                         <p class="text-muted"> Enter Your Information</p>
                                                    </div>
                                                </div>
                                                   <div class="col-md-12"> 
                       
                     
                        <div class="form-group">
                           <label class="control-label col-md-3">Email<font color="red">*</font></label>
                           <div class="col-md-9">
                              <input class="form-control" placeholder="name@address.com" type="text" name="email">
                           </div>
                        </div>
                        <div class="form-group">
                           <label class="control-label col-md-3">Name<font color="red">*</font></label>
                           <div class="col-md-5">
                              <input class="form-control" placeholder="First Name" type="text" name="first_name" >
                           </div>
                           <div class="col-md-4">
                           <input class="form-control" placeholder="Last Name" type="text" name="last_name" >
                           </div>
                        </div>
                        
                           <div class="form-group">
                           <label class="control-label col-md-3">Contacts</label>
     
                           <div class="col-md-3">
                              <input class="form-control" placeholder="Mobile" type="text" name="mobile_number">
                           </div>
                           <div class="col-md-3">
                              <input class="form-control" placeholder="Office Phone" type="text" name="office_phone_number">
                           </div>
                           <div class="col-md-3">
                              <input class="form-control" placeholder="Home Phone" type="text" name="home_phone_number">
                           </div>
                        </div>
                     <div class="form-group">
                           <label class="control-label col-md-3">Address</label>
                           <div class="col-md-9">
                              <textarea class="form-control" placeholder="address" rows="5" name="address"></textarea>
                           </div>
                        </div>
                          <div class="form-group">
                           <label class="control-label col-md-3"></label>
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
                         <div class="form-group">
                 <label class="control-label col-md-3">Notes</label>
                <div class="col-md-9">
                  <input class="form-control"  type="text" name="appointment_notes" value="">
                </div>
             </div>
                        
                          </div>
                                            </div>
                                             <!-- Wizard Container 3 -->
                                            <div class="wizard-title"> Confirm </div>
                                            <div class="wizard-container">
                                                <div class="form-group">
                                                    <div class="col-md-12">
                                                        <h4 class="semibold text-primary">
                                                         <i class="fa fa-book"></i> Confirm Your Information</h4>
                                                      
                                                          <button name="add_appointment_form_submit"  type="submit" class="btn btn-info submit_btn" >Book My Appointment</button>
                                                     </div>
                                                </div>
                                         
                                            </div>
                                            <!--/ Wizard Container 3 -->
						                  </div>  
                         <!-- Wizard Container 4 -->
                         
                         
                                        </form>
                                      <!--/ END Form Wizard -->
                               </div>
                               <?php }elseif($_REQUEST['tab']=='staff_member'){?>
                                 <div class="col-md-9">
                                    <table class="table">
                                    <h4>Provider</h4>
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
                                            foreach ($allstaff as $alls){?>
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
                                                <td ><a class="b1" cdata="<?php echo $comid;?>" data="<?php echo $alls['user_id'];?>"><?php echo ucwords($alls['firstname']." ".$alls['lastname']);?></a></td>
                                             </tr>
                                                
                                            <?php }}?>
                                                                                     
                                         
                                        </tbody>
                                    </table>
                               </div>
                                 <?php }elseif($_REQUEST['tab']=='services'){?>
                                 <div class="col-md-9">
                                  <h4>All Services</h4>
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
                                            <a>
                                            <div class="row">
                                            <div class="col-lg-4">
                                                <h4 class="alert-title"><?php echo ucwords($llser['service_name']);?></h4>
                                                <p class="alert-message"><?php echo ucwords($llser['service_description']);?></p></div>
                                            <div class="col-lg-2 text-center"><?php echo $llser['service_time'];?>mins</div>
                                            <div class="col-lg-2 text-center"><?php echo CURRENCY.number_format($llser['service_cost'],'2');?></div>
                                            <div class="col-lg-4 text-center"><?php if ($llser['service_buffer_time']!=""){ echo $llser['service_buffer_time']."mins";}else{echo "No Buffer";}?></div>
                                            
                                            
                                            </div>
                                            </a>
                                              
                                            </div>
                                            
                                       </div>
                                    <?php }                                        
                                    }?>
                               </div>   <?php }elseif($_REQUEST['tab']=='reviews'){?>
                                 <div class="col-md-9">
                                  <h4><?php  echo $count_review;?> Reviews</h4>
                                  <button type="button" class="btn btn-info pull-right" data-toggle="modal" data-target="#myModal_add_appointment">Write Review</button>
                                     
                                        <table class="table table-hover table-vcenter"> 
                                                <thead><tr>
                                                        <th>&nbsp;</th> 
                                                        <th>&nbsp;</th>
                                                        <th>&nbsp;</th>
                                                        </tr>
                                                </thead>
                                                <tbody>
                                                  <?php 
                                                if (is_array($reviews)){
                                                    foreach ($reviews as $review_detail){
                                                    ?>
                                                   <tr>
                                                    <td><?php echo ucwords($review_detail['review_provider_name']);?> at <?php echo date('D M d,Y',strtotime($review_detail['created_date']));?><br> <?php echo ucfirst($review_detail['review_detail']);?> 
                                                     </td>
                                                    </tr>
                                                    <?php }}?>
                                                  
                                                   </tbody>
                                           </table>
                                </div><?php }?>
                               
                               
                            <div class="col-md-3" id="show_provider_detail">
                             <strong>Business Hours</strong>  
                                        <table class="table">
                                            <tbody>
                                             <?php 
                                             $common_data_company_setting=$db->get_row('company',array('id'=>$comid));
                                            $working_day=unserialize($common_data_company_setting['working_day']);
                                            $working_on_off=unserialize($common_data_company_setting['working_on_off']);
                                            $working_start_time=unserialize($common_data_company_setting['working_start_time']);
                                            $working_end_time=unserialize($common_data_company_setting['working_end_time']);
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
                    </div>
                    <!--===================================================-->
                    <!--End page content-->
                </div>
              </div>
          
        </div>
        <!--===================================================-->
        <!-- END OF CONTAINER -->
        <!--JAVASCRIPT-->
        <!--=================================================-->
       <script src="<?php echo SITE_URL.'/assets/frontend/js/jquery-2.1.1.min.js';?>"></script> 
       <script src="<?php echo SITE_URL.'/assets/frontend/js/jquery-ui.min.js';?>"></script>
        <script src="<?php echo SITE_URL.'/assets/frontend/js/bootstrap.min.js';?>"></script>
       
    
       <!--Switchery [ OPTIONAL ]-->
        <script src="<?php echo SITE_URL.'/assets/frontend/plugins/switchery/switchery.min.js';?>"></script>
       <!--Jquery Steps [ OPTIONAL ]-->
        <script src="<?php echo SITE_URL.'/assets/frontend/plugins/jquery-steps/jquery-steps.min.js';?>"></script>
         <!--Bootstrap Wizard [ OPTIONAL ]-->
        <script src="<?php echo SITE_URL.'/assets/frontend/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js';?>"></script>
       
        <!--Form Wizard [ SAMPLE ]-->
        <script src="<?php echo SITE_URL.'/assets/frontend/js/demo/wizard.js';?>"></script>
        <!--Form Wizard [ SAMPLE ]-->
        <script src="<?php echo SITE_URL.'/assets/frontend/js/demo/form-wizard.js';?>"></script>
         <script src="<?php echo SITE_URL.'/assets/frontend/plugins/bootstrap-datepicker/bootstrap-datepicker.js';?>"></script>
    
    <script>
    
        $('.datepicker').datepicker({
      	  format: "dd-mm-yyyy",
          todayBtn: "linked",
          autoclose: true,
          todayHighlight: true});
        </script>
       
       <script type="text/javascript">
        function reply_click(clicked_id)
        {
        	var id = clicked_id;
        	var comid ='1';
             
    		$.ajax({
    	  	  type: "POST",
    	  	  url: "company_booking_ajax.php",
    	  	  data:'service_id='+id + '&company_id='+comid, 
    	   	  success: function (data) {
                 $("#show_provider").html(data);
                 $("#no_provider").hide();
        	   	}
    	  	});
        }
     </script>
     
     <script>
     if (!$("input[name=service_id]:checked").val()) {
    	 $("#no_provider").text("You have not selected any service name.");
 	   }</script>
   
   <script> 
     $(".b1").click(function () {
      var idnew=$(this).attr("data");
      var cidnew=$(this).attr("cdata");

     $("#service_provider_id").val(idnew);
      
      // alert(idnew);
      	$.ajax({
  	  	  type: "POST",
  	  	  url: "company_booking_ajax.php",
  	  	  data:'provider_id='+idnew + '&company_id='+cidnew, 
  	   	  success: function (data) {
  	  	   	 $("#show_provider_detail").html(data);
  	  	  	
    	   	}
  	  	});
 	});
   </script>

    </body>
</html>
<!-- Modal box to Add Appointment --> 
  <div id="myModal_add_appointment" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    <div id="after_post_message_review"></div>
    <form method="post" class="form-horizontal" action="" enctype="multipart/form-data">
    <div class="modal-header">
       <h4 class="modal-title">Add Review</h4>
      </div>
      <div class="modal-body">
             <div class="form-group">
               <label class="control-label col-md-3">Name <font color="red">*</font></label>
               <div class="col-md-8">
                   <input class="form-control" type="text" name="review_provider_name" value=""> 
               </div>
            </div>
            <div class="form-group">
               <label class="control-label col-md-3">Email <font color="red">*</font></label>
               <div class="col-md-8">
                   <input class="form-control" type="email" name="review_email" value=""> 
               </div>
            </div>
             
             <div class="form-group">
               <label class="control-label col-md-3">Notes</label>
               <div class="col-md-8">
                   <textarea class="form-control" rows="5" name="review_detail"></textarea>
               </div>
            </div>
          </div>
      <div class="modal-footer">
        <button class="btn btn-info" name="add_review_form_submit" type="submit">Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>

  </div>
</div>
<!-- Modal box to Edit Appointment --> 

