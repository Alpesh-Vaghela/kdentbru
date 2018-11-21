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

$db = new db("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);?>

<?php 

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

function decryptIt( $q ) {
    $cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
    $qDecoded      = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
    return( $qDecoded );
}
?>





<?php 
/****************************add Appointment coding**********************************/
if (isset($_POST['add_appointment_form_submit']))
{
  // print_r($_POST);
   $comid=$_POST['company_id'];
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
   
   
   
   
   
   
   
   
    $common_data_company_setting=$db->get_row('company',array('id'=>$comid));
    
    $clogo=SITE_URL.'/uploads/company/'.$comid.'/logo/'.$common_data_company_setting[company_logo];
    
    
    
    $common_data_sendar_name=$common_data_company_setting['company_email'];
     $settings=$db->get_row('settings');
     define(SITE_NAME,$settings['name']);
     
     $allnotifications=$db->get_row('notification_settings',array('company_id'=>$comid));
     
     $common_data_customer_notification=unserialize($allnotifications['customer_notification']);
     $common_data_staff_notification=unserialize($allnotifications['staff_notification']);
     $common_data_activity_alert=unserialize($allnotifications['activity_notifications']);

     if ($allnotifications['sendar_name']!="")
     {
         $common_data_sendar_name=$allnotifications['sendar_name'];
     }
     else
     {
         $common_data_sendar_name=$common_data_company_setting['company_name'];
     }
     if ($allnotifications['email_signature']!="")
     {
         $common_data_email_signature=html_entity_decode($allnotifications['email_signature']);
     }
     else
     {
         $common_data_email_signature="Thanks,<br>".$common_data_company_setting['company_name'];
     }
     
 /*    if(in_array('show_timezone', $common_data_customer_notification))
     {
         $customer_timezone=$common_data_company_setting['company_timezone'];
     }
     else
     {
         $customer_timezone="";
     }
     if(in_array('show_timezone', $common_data_staff_notification))
     {
         $staff_timezone=$common_data_company_setting['company_timezone'];
     }
         else
         {
             $staff_timezone="";
         }
  */    
    
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
  
    
    if (is_array($working_day))
    {
        foreach ($working_day as $key=>$value)
        {
            if (ucfirst($value)==$dayName)
            {
    
                $on_off=$working_on_off[$key];
                break;
            }
    
        }
    }
 /**************************************************************************************************************/
    $appointment_buffer_time=$db->get_var('services',array('id'=>$service_id),'service_buffer_time');
    $check_service_duration=$appointment_service_time+$appointment_buffer_time;
    $check_time=$appointment_time;
    $check_service_duration="+".$check_service_duration." minutes";
    $check_time_new = strtotime($check_service_duration, strtotime($check_time));
    $check_time_new=date('H:i:s', $check_time_new);
    
    $appointment_start_timee=date('H:i:s',strtotime($appointment_time));
    $appointment_end_time=$check_time_new;
    $query12="SELECT* FROM `appointments`
    WHERE `staff_id`='$service_provider'
    AND `appointment_date`='$appointment_date'
    AND ((`appointment_time` BETWEEN '$appointment_start_timee' AND '$appointment_end_time') OR (`appointment_end_time` >  '$appointment_start_timee' AND `appointment_time` < '$appointment_end_time')) ";
    $fetchall_appointments_of_the_dayl=$db->run($query12)->fetchAll();
    
 /********************************************************************/   
   $empt_fields = emptyfields(array('Service Name'=>$service_id,
                                    'Service Provider Name'=>$service_provider,
                                    'Appointment Date'=>$appointment_date,
                                    'Appointment Time'=>$appointment_time,
                                    'Email Address'=>$email,
                                    'First Name'=>$first_name,
                                    'Mobile Number'=>$mobile_number,
                                    ));
   if ($empt_fields)
   {
      $return['msg']='<div class="alert alert-danger text-danger">
                		<i class="fa fa-frown-o text-danger"></i>
            <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
            Following Fields Are Empty!<hr>'.$empt_fields.'</div>';
       $return['error']=true;
       echo json_encode($return);
   }
   
   elseif (!filter_var ( $email, FILTER_VALIDATE_EMAIL ))
   {
       
       
       $return['msg']='<div class="alert alert-danger text-danger ">
                		<i class="fa fa-frown-o"></i>
                            <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
                            Oops! Wrong Email Format.
                		</div>';
       $return['error']=true;
       echo json_encode($return);
       
       
       
   }
      
    elseif (!preg_match ( '/^[0-9][0-9\s]*$/', $appointment_service_cost ))
    {
        $return['msg']='<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
                        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
                        Service Cost Should be Numeric!.
    					</div>';
        $return['error']=true;
        echo json_encode($return);
      
    }
    elseif (!preg_match ( '/^[0-9][0-9\s]*$/', $appointment_service_time ))
    {
        
        $return['msg']='<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
                        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
                        Service Time Should be Numeric!.
    					</div>';
        $return['error']=true;
        echo json_encode($return);
       
    }
    elseif ($t==false)
    {
        
        $return['msg']='<div class="alert alert-danger text-danger">
            <i class="fa fa-frown-o text-danger"></i>
                        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
                        Service provider on leave. Please select other service provider
    					</div>';
        $return['error']=true;
        echo json_encode($return);
       
    }
 elseif ($on_off=="off")
    {
        $return['msg']='<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
                        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
                        Service Provider is on off(leave)!
    					</div>';
        $return['error']=true;
        echo json_encode($return);
    }
       elseif (strtotime($appointment_date." ".$appointment_time) < strtotime(date('Y-m-d H:i ')))
    {
        
        $return['msg']='<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
                        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
                        Appointment date should be greater than today date!
    	 </div>';
        $return['error']=true;
        echo json_encode($return);
        
    }
    elseif (!empty($fetchall_appointments_of_the_dayl))
    {
        $return['msg']='<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
                        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
                        Staff have already an Appointment for this date  and time!
    					</div>';
        $return['error']=true;
        echo json_encode($return);
    }
   else
   {
       if ($db->exists('customers',array('email'=>$email,'company_id'=>$comid)))
       {
           $cust_id=$db->get_var('customers',array('email'=>$email),'id');
       }
       else
       {
           $insert_customer=$db->insert("customers",array('company_id'=>$comid,
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
                                            
                                           $cust_id=$db->insert_id;
            if ($insert_customer){
                           $event="<b>Customer</b>  ".ucfirst($first_name)." ".ucfirst($last_name). " was added";
                             $db->insert('activity_logs',array('user_id'=>0,
                                                               'event_type'=>'customer_created',
                                                               'event'=>$event,
                                                               'company_id'=>$comid,
                                                               'event_type_id'=>$cust_id,
                                                               'created_date'=>date('Y-m-d'),
                                                               'ip_address'=>$_SERVER['REMOTE_ADDR']));
                                }
                        }
        
       
        
               $insert_appointments=$db->insert('appointments',array('company_id'=>$comid,
                                                'customer_id'=>$cust_id,
                                                'customer_name'=>$first_name." ".$last_name,
                                                'service_buffer_time'=>$appointment_buffer_time,
                                                'staff_id'=>$service_provider,
                                                'service_id'=>$service_id,
                                                'service_time'=>$appointment_service_time,
                                                'service_cost'=>$appointment_service_cost,
                                                'appointment_date'=>$appointment_date,
                                                'appointment_time'=>date('H:i:s',strtotime($appointment_time)),
                                                'appointment_end_time'=>$check_time_new,
                                                'notes'=>$appointment_notes,
                                                'booking_id'=>time(),
                                                'appointment_month'=>$appointment_month,
                                                'appointment_year'=>$appointment_year,
                                                'status'=>'pending',
                                                'booking_from'=>'company_booking_page',
                                                'created_date'=>$created_date,
                                                'ip_address'=>$ip_address));
             $appointment_id=$db->insert_id; 
       
        
       if ($insert_appointments){
           
           ////*****************************//////////////////this is for email to send
           $first_name=$db->get_var('customers',array('id'=>$cust_id),'first_name');
           $last_name=$db->get_var('customers',array('id'=>$cust_id),'last_name');
           $customer_email=$db->get_var('customers',array('id'=>$cust_id),'email');
           $customer_phone=$db->get_var('customers',array('id'=>$cust_id),'mobile_number');
           $service_name=$db->get_var('services',array('id'=>$service_id),'service_name');
           $staff_first_name=$db->get_var('users',array('user_id'=>$service_provider),'firstname');
           $staff_last_name=$db->get_var('users',array('user_id'=>$service_provider),'lastname');
           $staff_email=$db->get_var('users',array('user_id'=>$service_provider),'email');
           
            
           $event="<b>New Appt.</b>  ".$first_name." ".$last_name." for a " . $service_name . "<br>
     on " . date('d M Y',strtotime($appointment_date)) . "@".date('h:i:s a',strtotime($appointment_time)). " w/ " . $staff_first_name . " " . $staff_last_name;
           $db->insert('activity_logs',array('user_id'=>0,
                                             'event_type'=>'appointment_created',
                                             'event'=>$event,
                                             'company_id'=>$comid,
                                             'event_type_id'=>$appointment_id,
                                             'created_date'=>date('Y-m-d'),
                                             'ip_address'=>$_SERVER['REMOTE_ADDR']));
           
           
/**************email sent to customer coding  start*************************/
           
           if (is_array($common_data_customer_notification)){
               if (in_array('appointment_booked', $common_data_customer_notification)){
                   $customer_add_appointment_email_body = '<table cellspacing="0" cellpadding="0" style="padding:30px 10px;background-color:rgb(238,238,238);width:100%;font-family:arial;background-repeat:initial initial">
<tbody>
<tr>
	<td>
		<table align="center" cellspacing="0" style="max-width:650px;min-width:320px">
			<tbody>
				<tr>
					<td align="center" style="background:#fff;border:1px solid #e4e4e4;padding:50px 30px">
						<table align="center">
							<tbody>
								<tr>
									<td style="border-bottom:1px solid #dfdfd0;color:#666;text-align:center">
									<table align="left" style="margin:auto">
										<tbody>
                       <tr>
											<td style="text-align:left;padding-bottom:14px">
    <img align="left" alt="'.$company_name.'" src="'.$clogo.'" width="150px"></td> 
											</tr>
											<tr>
												<td style="color:rgb(102,102,102);font-size:10px;padding-bottom:30px;text-align:left;font-family:arial">
                        <div style="border-bottom:1px solid #e5e5e5;padding-bottom:5px;margin-bottom:20px">
                        	<h1 style="color:#4e5b63;font-size:28px;margin:15px 0px 0px;font-weight:500">Thank You</h1>
								<h6 style="color:#4e5b63;font-size:15px;margin:25px 0px 10px;font-weight:500">Hi '.$first_name.' '.$last_name.',</h6>
								<p style="color:#788a95;font-size:15px;margin:10px 0px 15px">
								    Your appointment request has been booked with '.$common_data_company_setting['company_name'].' and current status is pending.<br>
								        Please wait for admin approval.  </p>
					   </div>
				      <div style="border-bottom:1px solid #e5e5e5;margin-bottom:20px;padding-bottom:15px">
								<div style="display:inline-block;width:100%">
									<label style="color:#788a95;font-size:15px">When:&nbsp;</label>
									<p style="display:inline-block;margin:0;color:#637374;font-size:15px">'.date("d M Y",strtotime($appointment_date)).' '.date('h:i:s a',strtotime($appointment_time)).' '.$customer_timezone.'</p>
								</div>
								<div style="display:inline-block;width:100%">
									<label style="color:#788a95;font-size:15px">Service:&nbsp;</label>
									<p style="display:inline-block;margin:0;color:#637374;font-size:15px">'.$service_name.'</p>
								</div>
								<div style="display:inline-block;width:100%">
									<label style="color:#788a95;font-size:15px">Provider:&nbsp;</label>
									<p style="display:inline-block;margin:0;color:#637374;font-size:15px">'.$staff_first_name.' '.$staff_last_name.'</p>
								</div>
                        </div>
						<div style="border-bottom12:1px solid #e5e5e5;padding-bottom:5px;margin-bottom:20px">
							<p style="color:#788a95;font-size:15px;margin:10px 0px 15px">'.$common_data_email_signature.'</p>
							</div>
           
											</td>
							    </tr>
										</tbody>
										</table>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
	</td>
</tr>
</tbody>
</table>';
           
           
                   $headers  = 'MIME-Version: 1.0' . "\r\n";
                   $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                   $headers .= 'From: '.$common_data_sendar_name .'<'.$common_data_company_setting['company_email'] . ">\r\n" .
                       'Reply-To: '.$common_data_company_setting['company_email'] . "\r\n" .
                       'X-Mailer: PHP/' . phpversion();
           
                   $subject="Appointment Scheduled for ". date('d M Y',strtotime($appointment_date))." ".date('h:i:s a',strtotime($appointment_time))." with ".$staff_first_name . " " . $staff_last_name;
                    
                   $confirm    =  mail($customer_email, $subject,$customer_add_appointment_email_body,$headers);
               } }
               /****************************email sent to staff************************************/
               if (is_array($common_data_staff_notification)){
                   if (in_array('appointment_booked', $common_data_staff_notification)){
                       $staff_add_appointment_email_body = '<table cellspacing="0" cellpadding="0" style="padding:30px 10px;background-color:rgb(238,238,238);width:100%;font-family:arial;background-repeat:initial initial">
<tbody>
<tr>
	<td>
		<table align="center" cellspacing="0" style="max-width:650px;min-width:320px">
			<tbody>
				<tr>
					<td align="center" style="background:#fff;border:1px solid #e4e4e4;padding:50px 30px">
						<table align="center">
							<tbody>
								<tr>
									<td style="border-bottom:1px solid #dfdfd0;color:#666;text-align:center">
									<table align="left" style="margin:auto">
										<tbody>
									        <tr>
											<td style="text-align:left;padding-bottom:14px">
    <img align="left" alt="'.$company_name.'" src="'.$clogo.'" width="150px"></td> 
											</tr>
											<tr>
												<td style="color:rgb(102,102,102);font-size:10px;padding-bottom:30px;text-align:left;font-family:arial">
                        <div style="border-bottom:1px solid #e5e5e5;padding-bottom:5px;margin-bottom:20px">
                        	<h1 style="color:#4e5b63;font-size:28px;margin:15px 0px 0px;font-weight:500">New Appointment</h1>
								<h6 style="color:#4e5b63;font-size:15px;margin:25px 0px 10px;font-weight:500">Hi '.$staff_first_name.' '.$staff_last_name.',</h6>
								<p style="color:#788a95;font-size:15px;margin:10px 0px 15px">
								    You have an appointment scheduled.<br>and current status is pending.<br>
								        Please wait for admin approval.</p>
					   </div>
				      <div style="border-bottom:1px solid #e5e5e5;margin-bottom:20px;padding-bottom:15px">
								<div style="display:inline-block;width:100%">
									<label style="color:#788a95;font-size:15px">When:&nbsp;</label>
									<p style="display:inline-block;margin:0;color:#637374;font-size:15px">'.date("d M Y",strtotime($appointment_date)).' '.date('h:i:s a',strtotime($appointment_time)).' '.$staff_timezone.'</p>
								</div>
								<div style="display:inline-block;width:100%">
									<label style="color:#788a95;font-size:15px">Service:&nbsp;</label>
									<p style="display:inline-block;margin:0;color:#637374;font-size:15px">'.$service_name.'</p>
								</div>
								<div style="display:inline-block;width:100%">
									<label style="color:#788a95;font-size:15px">Provider:&nbsp;</label>
									<p style="display:inline-block;margin:0;color:#637374;font-size:15px">'.$staff_first_name.' '.$staff_last_name.'</p>
								</div>
           
                        </div>';
                       if(in_array('include_customer_info',$common_data_staff_notification))
                       {
                           $staff_add_appointment_email_body .='
           
					<div style="border-bottom:1px solid #e5e5e5;margin-bottom:20px;padding-bottom:15px">
									    <div style="display:inline-block;width:100%">
									<label style="color:#788a95;font-size:15px">customer:&nbsp;</label>
									<p style="display:inline-block;margin:0;color:#637374;font-size:15px">'.$first_name.' '.$last_name.'</p>
								</div><div style="display:inline-block;width:100%">
									<label style="color:#788a95;font-size:15px">Phone:&nbsp;</label>
									<p style="display:inline-block;margin:0;color:#637374;font-size:15px">'.$customer_phone.'</p>
								</div>
								<div style="display:inline-block;width:100%">
									<label style="color:#788a95;font-size:15px">Email:&nbsp;</label>
									<p style="display:inline-block;margin:0;color:#637374;font-size:15px">'.$customer_email.'</p>
								</div>
								<div style="display:inline-block;width:100%">
									<label style="color:#788a95;font-size:15px">Booked From :&nbsp;</label>
									<p style="display:inline-block;margin:0;color:#637374;font-size:15px">Customer Page</p>
								</div></div>';
                       }
                       $staff_add_appointment_email_body .= '<div style="border-bottom12:1px solid #e5e5e5;padding-bottom:5px;margin-bottom:20px">
							<p style="color:#788a95;font-size:15px;margin:10px 0px 15px">'.$common_data_email_signature.'</p>
							</div>
           
											</td>
							    </tr>
										</tbody>
										</table>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
	</td>
</tr>
</tbody>
</table>';
           
           
                       $headers  = 'MIME-Version: 1.0' . "\r\n";
                       $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                       $headers .= 'From: '.$common_data_sendar_name .'<'.$common_data_company_setting['company_email'] . ">\r\n" .
                           'Reply-To: '.$common_data_company_setting['company_email'] . "\r\n" .
                           'X-Mailer: PHP/' . phpversion();
           
                       $subject="Appointment Scheduled for ". date('d M Y',strtotime($appointment_date))." ".date('h:i:s a',strtotime($appointment_time))." with ".$first_name . " " . $last_name;
           
                       $confirm    =  mail($staff_email, $subject,$staff_add_appointment_email_body,$headers);
                   } }  
           
/*********************email sent coding end********************************************/     
                   if($confirm=='1')
                   {
                         $return['msg']='<div class="alert alert-success text-success">
                            		<i class="fa fa-smile-o"></i> <button class="close" data-dismiss="alert" type="button">
                            <i class="fa fa-times-circle-o"></i></button> Appointment Scheduled successfully and mail send.
                            		</div>';
       $return['error']=false;
       echo json_encode($return);
                   
                   }
                   else
                   {
                          $return['msg']='<div class="alert alert-success text-success">
                            		<i class="fa fa-smile-o"></i> <button class="close" data-dismiss="alert" type="button">
                            <i class="fa fa-times-circle-o"></i></button> Appointment Scheduled successfully.
                            		</div>';
       $return['error']=false;
       echo json_encode($return);
                   
                   }
           
           
    
       }
   }
}

?>