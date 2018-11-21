<?php 


/****************************************************************************************/
/*****************************Add new customer code*************************************/
/**************************************************************************************/
if (isset($_POST['add_customer_submit']))/*****************add Staff modal box submit****************/
{
    $company_id=$_POST['company_id'];
   	$customer_fname=$_POST['customer_fname'];
   	$customer_lname=$_POST['customer_lname'];
   	$customer_email=$_POST['customer_email'];
   	
   	$mobile_number=$_POST['mobile_number'];
   	$office_phone_number=$_POST['office_phone_number'];
   	$home_phone_number=$_POST['home_phone_number'];
   	$address=$_POST['address'];
   	$city=$_POST['city'];
   	$state=$_POST['state'];
   	$zip=$_POST['zip'];
   	
   	$visibility_status='active';
   	$created_date=date('Y-m-d');
   	$ip_address=$_SERVER['REMOTE_ADDR'];
  

    if ($fv->emptyfields(array('Customer First Name'=>$customer_fname),NULL))
    {

        $return['msg']='<div class="alert alert-danger text-danger">
                		<i class="fa fa-frown-o text-danger"></i>
            <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
            Customer first name can not be Blank.
                		</div>';
        $return['error']=true;
        echo json_encode($return);

    }
    elseif (!$fv->check_email($customer_email))
    {
        $return['msg']='<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
                        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
                        Wrong Email Format!.
    					</div>';
        $return['error']=true;
        echo json_encode($return);
    }
    elseif ($mobile_number=="")
    {
        $return['msg']='<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
                        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
                        Enter Mobile no!.
    					</div>';
        $return['error']=true;
        echo json_encode($return);
    }
    elseif ($db->exists('customers',array('email'=>$customer_email,'company_id'=>$company_id)))
    {
        $return['msg']='<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
                        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
                        Customer email already exist!.
    					</div>';
        $return['error']=true;
        echo json_encode($return);
    }
    else
    {
         $insert=$db->insert('customers',array('company_id'=>$company_id,
                                                'first_name'=>$customer_fname,
                                                'last_name'=>$customer_lname,
                                                'email'=>$customer_email,
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
     
$last_cusid=$db->insert_id;
        if ($insert){
          
            $return['msg']='<div class="alert alert-success text-success">
                    		<i class="fa fa-smile-o"></i> <button class="close" data-dismiss="alert" type="button">
                    <i class="fa fa-times-circle-o"></i></button> Customer Add successfully.
                    		</div>';
            $return['error']=false;
            $return['cid']=$last_cusid;
            echo json_encode($return);





        }
    }
}
/****************************************************************************************/
/*****************************Add new Staff code*************************************/
/**************************************************************************************/
if (isset($_POST['add_staff_submit']))/*****************add Staff modal box submit****************/
{
    $company_id=$_POST['company_id'];
   	$staff_fname=$_POST['staff_fname'];
	$staff_lname=$_POST['staff_lname'];
	$staff_email=$_POST['staff_email'];
	$visibility_status='active';
	$created_date=date('Y-m-d');
	$ip_address=$_SERVER['REMOTE_ADDR'];
	
	/*default working hours of staff company********************/
	$company_details=$db->get_row('company',array('id'=>$company_id));
	
	$day=$company_details['working_day'];
	$on_or_off=$company_details['working_on_off'];
    $starttime=$company_details['working_start_time'];
	$endtime=$company_details['working_end_time'];

 if ($fv->emptyfields(array('Staff First Name'=>$staff_fname),NULL))
    {

        $return['msg']='<div class="alert alert-danger text-danger">
                		<i class="fa fa-frown-o text-danger"></i>
            <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
            Staff first name can not be Blank.
                		</div>';
        $return['error']=true;
        echo json_encode($return);

    }
    elseif (!$fv->check_email($staff_email)) 
    {
       $return['msg']='<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
                        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
                        Wrong Email Format!.
    					</div>';
        $return['error']=true;
        echo json_encode($return);
    }
    elseif ($db->exists('users',array('email'=>$staff_email)))
    {
$return['msg']='<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
                        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
                        Staff email already exist!.
    					</div>';
        $return['error']=true;
        echo json_encode($return);
    }
else
{



	$insert=$db->insert('users',array('company_id'=>$company_id,
	                                  'firstname'=>$staff_fname,
                                      'lastname'=>$staff_lname,
                                      'email'=>$staff_email,
	                                  'user_type'=>'staff',
                                      'visibility_status'=>$visibility_status,
                            	      'create_date'=>$created_date,
                                      'ip_address'=>$ip_address,
	                                  'working_day'=>$day,
                                      'working_on_off'=>$on_or_off,
                                      'working_start_time'=>$starttime,
                                      'working_end_time'=>$endtime,

	));

  //  $db->debug();
    if ($insert){
     
              $return['msg']='<div class="alert alert-success text-success">
                    		<i class="fa fa-smile-o"></i> <button class="close" data-dismiss="alert" type="button">
                    <i class="fa fa-times-circle-o"></i></button> Save successfully.
                    		</div>';
               $return['error']=false;
              echo json_encode($return);





    }
}
}
/****************************************************************************************/
/*****************************Appointment Add code*************************************/
/**************************************************************************************/
if (isset($_POST['add_appointment_submit']))
{ 
    $company_id=$_POST['company_id'];
    $customer_id=$_POST['customer_id'];
    $service_provider=$_POST['service_provider'];
    $appointment_service=$_POST['appointment_service'];
    $appointment_service_cost=$_POST['appointment_service_cost'];
    $appointment_service_time=$_POST['appointment_service_time'];
    $appointment_date=$_POST['appointment_date'];
    $appointment_time=$_POST['appointment_time'];
    $appointment_notes=$_POST['appointment_notes'];
    $appointment_month=date('m',strtotime($appointment_date));
    $appointment_year=date('Y',strtotime($appointment_date));
    $created_date=date('Y-m-d');
    $ip_address=$_SERVER['REMOTE_ADDR'];
    $booking_from=$_POST['booking_from'];
/**********************check staff on leave or not**************************************/    
    $t=true;
    $alloff=$db->get_all('timeoff',array('staff_id'=>$service_provider,'company_id'=>$company_id));
    if (is_array($alloff))
    {
        foreach ($alloff as $altoff)
        {
            $strDateFrom=$altoff['start_date'];
            $strDateTo=$altoff['end_date'];
            $leave_date_array=$feature->createDateRangeArray($strDateFrom, $strDateTo);
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
    $appointment_buffer_time=$db->get_var('services',array('id'=>$appointment_service),'service_buffer_time');
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
    

          
     
          
  /************************************************************************************************************/  
    $check_empty=$fv->emptyfields(array('Select Customer'=>$customer_id,
                                       'Select Service provider'=>$service_provider,
                                       'Select Service'=>$appointment_service,
                                       'Service Cost'=>$appointment_service_cost,
                                       'Service Time'=>$appointment_service_time,
                                       'Appointment Date'=>$appointment_date,
                                       'Appointment Time'=>$appointment_time),NULL);
   
   


   if ($check_empty)
    {

        $return['msg']='<div class="alert alert-danger text-danger">
                		<i class="fa fa-frown-o text-danger"></i>
            <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
            Following Fields Are Empty!'.$company_id.'<br>'.$check_empty.'--<br></div>';
        $return['error']=true;
        echo json_encode($return);

    }
    
    elseif (!$fv->check_numeric($appointment_service_cost))
    {
        $return['msg']='<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
                        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
                        Service Cost Should be Numeric!.
    					</div>';
        $return['error']=true;
        echo json_encode($return);
    }
    elseif (!$fv->check_numeric($appointment_service_time))
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
        
        
        $first_name=$db->get_var('customers',array('id'=>$customer_id),'first_name');
        $last_name=$db->get_var('customers',array('id'=>$customer_id),'last_name');
        $customer_email=$db->get_var('customers',array('id'=>$customer_id),'email');
        $customer_phone=$db->get_var('customers',array('id'=>$customer_id),'mobile_number');
        
        $insert=$db->insert('appointments',array('company_id'=>$company_id,
                                                'customer_id'=>$customer_id,
                                                'customer_name'=>$first_name." ".$last_name,
                                                'staff_id'=>$service_provider,
                                                'service_id'=>$appointment_service,
                                                'service_time'=>$appointment_service_time,
                                                'service_cost'=>$appointment_service_cost,
                                                'service_buffer_time'=>$appointment_buffer_time,
                                                'appointment_date'=>$appointment_date,
                                                'appointment_time'=>date('H:i:s',strtotime($appointment_time)),
                                                'appointment_end_time'=>$check_time_new,
                                                'notes'=>$appointment_notes,
                                                'booking_id'=>time(),
                                                'appointment_month'=>$appointment_month,
                                                'appointment_year'=>$appointment_year,
                                                'status'=>'pending',
                                                'booking_from'=>'admin_edit_customer_page',
                                                'created_date'=>$created_date,
                                                'ip_address'=>$ip_address));
       $last_insert_id=$db->insert_id;
         if ($insert){
             $first_name=$db->get_var('customers',array('id'=>$customer_id),'first_name');
             $last_name=$db->get_var('customers',array('id'=>$customer_id),'last_name');
             $customer_email=$db->get_var('customers',array('id'=>$customer_id),'email');
             $customer_phone=$db->get_var('customers',array('id'=>$customer_id),'mobile_number');
             $service_name=$db->get_var('services',array('id'=>$appointment_service),'service_name');
             $staff_first_name=$db->get_var('users',array('user_id'=>$service_provider),'firstname');
             $staff_last_name=$db->get_var('users',array('user_id'=>$service_provider),'lastname');
             $staff_email=$db->get_var('users',array('user_id'=>$service_provider),'email');
           
        $event="<b>New Appt.</b>  ".$first_name." ".$last_name." for a " . $service_name . "<br>
     on " . date('d M Y',strtotime($appointment_date)) . "@".date('h:i:s a',strtotime($appointment_time)). " w/ " . $staff_first_name . " " . $staff_last_name;
                      $db->insert('activity_logs',array('user_id'=>$_SESSION['user_id'],
                                                          'event_type'=>'appointment_created',
                                                          'event'=>$event,
                                                          'company_id'=>$company_id,
                                                          'event_type_id'=>$last_insert_id,
                                                          'created_date'=>date('Y-m-d'),
                                                          'ip_address'=>$_SERVER['REMOTE_ADDR']
                
                        ));
                      
                      $company_details=$db->get_row('company',array('id'=>$company_id));
                      $company_name=$company_details['company_name'];
                      $company_email=$company_details['company_email'];
                      $company_currency=$company_details['company_currencysymbol'];
                      $clogo=SITE_URL.'/uploads/company/'.$company_id.'/logo/'.$company_details[company_logo];
                    
                      
                      $allnotifications=$db->get_row('notification_settings',array('company_id'=>$company_id));
                      
                      $common_data_customer_notification=unserialize($allnotifications['customer_notification']);
                      $common_data_staff_notification=unserialize($allnotifications['staff_notification']);
                      $common_data_activity_alert=unserialize($allnotifications['activity_notifications']);
                      
                      if ($allnotifications['sendar_name']!="")
                      {
                          $common_data_sendar_name=$allnotifications['sendar_name'];
                      }
                      else
                      {
                          $common_data_sendar_name=$company_name;
                      }
                      if ($allnotifications['email_signature']!="")
                      {
                          $common_data_email_signature=html_entity_decode($allnotifications['email_signature']);
                      }
                      else
                      {
                          $common_data_email_signature="Thanks,<br>".$company_name;
                      }                     
                      
                      
/**************email sent to customer*************************/
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
								    Your appointment request has been booked with '.$company_name.' and current status is pending.<br>
								        Please wait for admin approval.  </p>
					   </div>
				      <div style="border-bottom:1px solid #e5e5e5;margin-bottom:20px;padding-bottom:15px">
								<div style="display:inline-block;width:100%">
									<label style="color:#788a95;font-size:15px">When:&nbsp;</label>
									<p style="display:inline-block;margin:0;color:#637374;font-size:15px">'.date("d M Y",strtotime($appointment_date)).' '.date('h:i:s a',strtotime($appointment_time)).'</p>
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
                    $headers .= 'From: '.$common_data_sendar_name .'<'.$company_email . ">\r\n" .
                        'Reply-To: '.$company_email . "\r\n" .
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
									<p style="display:inline-block;margin:0;color:#637374;font-size:15px">'.date("d M Y",strtotime($appointment_date)).' '.date('h:i:s a',strtotime($appointment_time)).'</p>
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
         $headers .= 'From: '.$common_data_sendar_name .'<'.$company_email . ">\r\n" .
             'Reply-To: '.$company_email . "\r\n" .
             'X-Mailer: PHP/' . phpversion();
 
         $subject="Appointment Scheduled for ". date('d M Y',strtotime($appointment_date))." ".date('h:i:s a',strtotime($appointment_time))." with ".$first_name . " " . $last_name;
          
         $confirm    =  mail($staff_email, $subject,$staff_add_appointment_email_body,$headers);
     } }                 
                    
                    
                    if($confirm=='1')
                    {
                           $return['msg']='<div class="alert alert-success text-success">
                            		<i class="fa fa-smile-o"></i> <button class="close" data-dismiss="alert" type="button">
                            <i class="fa fa-times-circle-o"></i></button> Appointment Scheduled successfully and mail sent.
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
/****************************************************************************************/ 
/*****************************Appointment Edit code*************************************/
/**************************************************************************************/
if (isset($_POST['edit_appointment_submit']))
{
    $company_id=$_POST['company_id'];
    $appointment_id=$_POST['appointment_id'];
    $customer_id=$_POST['customer_id'];
    $service_provider=$_POST['service_provider'];
    $appointment_service=$_POST['appointment_service'];
    $appointment_service_cost=$_POST['appointment_service_cost'];
    $appointment_service_time=$_POST['appointment_service_time'];
    $appointment_date=$_POST['appointment_date'];
    $appointment_time=$_POST['appointment_time'];
    $appointment_notes=$_POST['appointment_notes'];
    $appointment_month=date('m',strtotime($appointment_date));
    $appointment_year=date('Y',strtotime($appointment_date));
    $created_date=date('Y-m-d');
    $ip_address=$_SERVER['REMOTE_ADDR'];
    
    
 
    /**********************check staff on leave or not**************************************/
    $t=true;
    $alloff=$db->get_all('timeoff',array('staff_id'=>$service_provider,'company_id'=>$company_id));
    if (is_array($alloff))
    {
        foreach ($alloff as $altoff)
        {
            $strDateFrom=$altoff['start_date'];
            $strDateTo=$altoff['end_date'];
            $leave_date_array=$feature->createDateRangeArray($strDateFrom, $strDateTo);
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
    
    
    
    /************************************************************************************************************/
$check_empty=$fv->emptyfields(array('Select Customer'=>$customer_id,
                                       'Select Service provider'=>$service_provider,
                                       'Select Service'=>$appointment_service,
                                        'Service Cost'=>$appointment_service_cost,
                                        'Service Time'=>$appointment_service_time,
                                        'Appointment Date'=>$appointment_date,
                                        'Appointment Time'=>$appointment_time
                                    ),NULL);
   if ($check_empty)
    {

        $return['msg']='<div class="alert alert-danger text-danger">
                		<i class="fa fa-frown-o text-danger"></i>
            <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
            Following Fields Are Empty!<br>'.$check_empty.'</div>';
        $return['error']=true;
        echo json_encode($return);

    }
    elseif ($db->get_var('appointments',array('id'=>$appointment_id),'status')=="paid")
    {
        $return['msg']='<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
                        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
                        Appointment paid and completed already!. So it is not editable.
    					</div>';
        $return['error']=true;
        echo json_encode($return);
    }
    elseif (!$fv->check_numeric($appointment_service_cost))
    {
        $return['msg']='<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
                        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
                        Service Cost Should be Numeric!.
    					</div>';
        $return['error']=true;
        echo json_encode($return);
    }
    elseif (!$fv->check_numeric($appointment_service_cost))
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
                        Service Provider is on off!
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
    else
    { 
        
        $appointment_buffer_time=$db->get_var('services',array('id'=>$appointment_service),'service_buffer_time');
        
        $first_name=$db->get_var('customers',array('id'=>$customer_id),'first_name');
        $last_name=$db->get_var('customers',array('id'=>$customer_id),'last_name');
        $customer_email=$db->get_var('customers',array('id'=>$customer_id),'email');
        $customer_phone=$db->get_var('customers',array('id'=>$customer_id),'mobile_number');
        
        
        
        
        
        $check_service_duration=$appointment_service_time+$appointment_buffer_time;
        $check_time=$appointment_time;
        $check_service_duration="+".$check_service_duration." minutes";
        $check_time_new = strtotime($check_service_duration, strtotime($check_time));
        $check_time_new=date('H:i:s', $check_time_new);
        
       $update=$db->update('appointments',array('customer_id'=>$customer_id, 
                                                'customer_name'=>$first_name." ".$last_name,
                                                'staff_id'=>$service_provider,
                                                'service_id'=>$appointment_service, 
                                                'service_time'=>$appointment_service_time,
                                                'service_cost'=>$appointment_service_cost,
                                                'appointment_date'=>$appointment_date,
                                                'appointment_time'=>date('H:i:s',strtotime($appointment_time)),
                                                'appointment_end_time'=>$check_time_new,
                                                'notes'=>$appointment_notes,
                                                'appointment_month'=>$appointment_month,
                                                'appointment_year'=>$appointment_year,
                                                'status'=>'pending',
                                                'created_date'=>$created_date,
                                                'ip_address'=>$ip_address),array('id'=>$appointment_id));
         if ($update){
            
             $customer_email=$db->get_var('customers',array('id'=>$customer_id),'email');
             $customer_phone=$db->get_var('customers',array('id'=>$customer_id),'mobile_number');
             $service_name=$db->get_var('services',array('id'=>$appointment_service),'service_name');
             $staff_first_name=$db->get_var('users',array('user_id'=>$service_provider),'firstname');
             $staff_last_name=$db->get_var('users',array('user_id'=>$service_provider),'lastname');
             $staff_email=$db->get_var('users',array('user_id'=>$service_provider),'email');
           
$event="<b>Rescheduled appt.</b>  ".$first_name." ".$last_name." for a " . $service_name . "<br>
     on " . date('d M Y',strtotime($appointment_date)) . "@".date('h:i:s a',strtotime($appointment_time)). " w/ " . $staff_first_name . " " . $staff_last_name;
                      $db->insert('activity_logs',array('user_id'=>$_SESSION['user_id'],
                                                          'event_type'=>'appointment_updated',
                                                          'event'=>$event,
                                                          'company_id'=>$company_id,
                                                          'event_type_id'=>$appointment_id,
                                                          'created_date'=>date('Y-m-d'),
                                                          'ip_address'=>$_SERVER['REMOTE_ADDR']
                
                        ));
                      
                      

                      $company_details=$db->get_row('company',array('id'=>$company_id));
                      $company_name=$company_details['company_name'];
                      $company_email=$company_details['company_email'];
                      $company_currency=$company_details['company_currencysymbol'];
                      $clogo=SITE_URL.'/uploads/company/'.$company_id.'/logo/'.$company_details[company_logo];
                      
                      $allnotifications=$db->get_row('notification_settings',array('company_id'=>$company_id));
                      
                      $common_data_customer_notification=unserialize($allnotifications['customer_notification']);
                      $common_data_staff_notification=unserialize($allnotifications['staff_notification']);
                      $common_data_activity_alert=unserialize($allnotifications['activity_notifications']);
                      
                      if ($allnotifications['sendar_name']!="")
                      {
                          $common_data_sendar_name=$allnotifications['sendar_name'];
                      }
                      else
                      {
                          $common_data_sendar_name=$company_name;
                      }
                      if ($allnotifications['email_signature']!="")
                      {
                          $common_data_email_signature=html_entity_decode($allnotifications['email_signature']);
                      }
                      else
                      {
                          $common_data_email_signature="Thanks,<br>".$company_name;
                      }                    
                      
/********************************Apponitment Rescheduled email to customer*****************/
if (is_array($common_data_customer_notification)){                      
if (in_array('appointment_edited', $common_data_customer_notification)){
$customer_edit_appointment_email_body = '<table cellspacing="0" cellpadding="0" style="padding:30px 10px;background-color:rgb(238,238,238);width:100%;font-family:arial;background-repeat:initial initial">
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
                        	<h1 style="color:#4e5b63;font-size:28px;margin:15px 0px 0px;font-weight:500">Appointment Rescheduled</h1>
								<h6 style="color:#4e5b63;font-size:15px;margin:25px 0px 10px;font-weight:500">Hi '.$first_name.' '.$last_name.',</h6>
								<p style="color:#788a95;font-size:15px;margin:10px 0px 15px">Your appointment has been rescheduled with '.$company_name.'</p>
					   </div>
				      <div style="border-bottom:1px solid #e5e5e5;margin-bottom:20px;padding-bottom:15px">
								<div style="display:inline-block;width:100%">
									<label style="color:#788a95;font-size:15px">When:&nbsp;</label>
									<p style="display:inline-block;margin:0;color:#637374;font-size:15px">'.date("d M Y",strtotime($appointment_date)).' '.date('h:i:s a',strtotime($appointment_time)).'</p>
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
                    $headers .= 'From: '.$common_data_sendar_name .'<'.$company_email . ">\r\n" .
                        'Reply-To: '.$company_email . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();
                    
                    $subject="Appointment Rescheduled for ". date('d M Y',strtotime($appointment_date))." ".date('h:i:s a',strtotime($appointment_time))." with ".$staff_first_name . " " . $staff_last_name;
                   
                    $confirm    =  mail($customer_email, $subject,$customer_edit_appointment_email_body,$headers);
}} 
/***************************Appointment Rescheduled email to staff*************************/                   

if (is_array($common_data_staff_notification)){
    if (in_array('appointment_edited', $common_data_staff_notification)){
        $staff_edit_appointment_email_body = '<table cellspacing="0" cellpadding="0" style="padding:30px 10px;background-color:rgb(238,238,238);width:100%;font-family:arial;background-repeat:initial initial">
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
                        	<h1 style="color:#4e5b63;font-size:28px;margin:15px 0px 0px;font-weight:500">Appointment Rescheduled</h1>
								<h6 style="color:#4e5b63;font-size:15px;margin:25px 0px 10px;font-weight:500">Hi '.$staff_first_name.' '.$staff_last_name.',</h6>
								<p style="color:#788a95;font-size:15px;margin:10px 0px 15px">One of your appointments was rescheduled.</p>
					   </div>
				      <div style="border-bottom:1px solid #e5e5e5;margin-bottom:20px;padding-bottom:15px">
								<div style="display:inline-block;width:100%">
									<label style="color:#788a95;font-size:15px">When:&nbsp;</label>
									<p style="display:inline-block;margin:0;color:#637374;font-size:15px">'.date("d M Y",strtotime($appointment_date)).' '.date('h:i:s a',strtotime($appointment_time)).'</p>
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
            $staff_edit_appointment_email_body .='
                
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
	$staff_edit_appointment_email_body .= '<div style="border-bottom122:1px solid #e5e5e5;padding-bottom:5px;margin-bottom:20px">
							<p style="color:#788a95;font-size:15px;margin:10px 0px 15px">'.$common_data_email_signature.'</p>
							</div></td>
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
        $headers .= 'From: '.$common_data_sendar_name .'<'.$company_email . ">\r\n" .
            'Reply-To: '.$company_email . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        $subject="Appointment Scheduled for ". date('d M Y',strtotime($appointment_date))." ".date('h:i:s a',strtotime($appointment_time))." with ".$first_name . " " . $last_name;

        $confirm    =  mail($staff_email, $subject,$staff_edit_appointment_email_body,$headers);
    } } 
/******************success message************************************/                  
                    
                    if($confirm=='1')
                    {
                           $return['msg']='<div class="alert alert-success text-success">
                            		<i class="fa fa-smile-o"></i> <button class="close" data-dismiss="alert" type="button">
                            <i class="fa fa-times-circle-o"></i></button>Appointment Rescheduled successfully mail sent.
                            		</div>';
                    $return['error']=false;
                    echo json_encode($return);
                    }
                    else
                    {
                 $return['msg']='<div class="alert alert-success text-success">
                            		<i class="fa fa-smile-o"></i> <button class="close" data-dismiss="alert" type="button">
                            <i class="fa fa-times-circle-o"></i></button>Appointment Rescheduled successfully! 
                            		</div>';
                    $return['error']=false;
                    echo json_encode($return);
                    } 
                   }
        
        
    }
    
}
/****************************************************************************************/
/*****************************load Appointment Edit form to modal box code*************************************/
/**************************************************************************************/
if (isset($_REQUEST['edit_appointment']))
{
$appointment_detail=$db->get_row('appointments',array('id'=>$_REQUEST['edit_appointment']));
$company_id=$appointment_detail['company_id'];
$company_details=$db->get_row('company',array('id'=>$company_id));
$company_currency=$company_details['company_currencysymbol'];  
    
    ?>
<link href="<?php echo SITE_URL.'/assets/frontend/plugins/bootstrap-datepicker/bootstrap-datepicker.css';?>" rel="stylesheet">
      <div class="form-group">
                           <label class="control-label col-md-3">Provider<font color="red">*</font></label>
                           <div class="col-md-8">
                            <input type="hidden" name="edit_appointment_submit" value="edit_appointment_submit">
                            <input type="hidden" name="customer_id" value="<?php echo $appointment_detail['customer_id'];?>">
                            <input type="hidden" name="appointment_id" value="<?php echo $appointment_detail['id'];?>">
                            <input type="hidden" name="company_id" value="<?php echo $appointment_detail['company_id'];?>">
                              <select class="form-control"name="service_provider" id="load_services_by_provider_edit">
                              <option value="">---Seleziona---</option>
                              <?php $provider=$db->get_all('users',array('visibility_status'=>'active','company_id'=>$company_id));
                              if (is_array($provider))
                              {
                                  foreach ($provider as $pro)
                                  {?>
                                     <option <?php if ($appointment_detail['staff_id']==$pro['user_id']){echo "selected";}?> value="<?php echo $pro['user_id']?>"><?php echo $pro['firstname']." ".$pro['lastname'];?></option> 
                                  <?php }
                              }?> 
                              
                              </select>   
                           </div>
                        </div>
             <div class="form-group">
               <label class="control-label col-md-3">Service</label> 
               <div class="col-md-8">
                  <select class="form-control load_services_edit" name="appointment_service" id="load_cost_time_by_service_edit">
                      <?php  $services=$db->get_all('assign_services',array('company_id'=>$company_id,'staff_id'=>$appointment_detail['staff_id']));
                              if (is_array($services))
                              {
                                  foreach ($services as $ser)
                                  {?>
                                     <option <?php if ($appointment_detail['service_id']==$ser['service_id']){echo "selected";}?> value="<?php echo $ser['service_id']?>"><?php echo $db->get_var('services',array('id'=>$ser['service_id']),'service_name  ');?></option> 
                                  <?php }
                              }?>
              
                  </select>
               </div>
            </div> 
             <div class="form-group load_costandtime_edit">
               <label class="control-label col-md-3"></label> 
               <div class="col-md-5">
               <div class="input-group mar-btm">
                    <span class="input-group-btn">
                    <button class="btn btn-default" type="button"><?php echo $company_currency;?></button> 
                    </span>
                    <input class="form-control" type="text" name="appointment_service_cost" value="<?php echo $appointment_detail['service_cost'];?>" placeholder="cost">
                </div>
               </div>
               <div class="col-md-3">
                  <div class="input-group mar-btm">
                     <input class="form-control" type="number" name="appointment_service_time" value="<?php echo $appointment_detail['service_time'];?>" placeholder="Mins">
                        <span class="input-group-btn">
                        <button class="btn btn-default" type="button">Mins</button>
                        </span>
                    </div>
               </div>
            </div>
              <div class="form-group">
               <label class="control-label col-md-3">Day/Time <?php echo date('H:i',strtotime($appointment_detail['appointment_time']))?></label>
               <div class="col-md-5">
                  <input class="form-control datepicker" type="text" name="appointment_date" value="<?php echo $appointment_detail['appointment_date'];?>" id="get_date_calender_edit">
               </div>
               <div class="col-md-3">
                  <!-- <input class="form-control" type="time" name="appointment_time" value="<?php echo date('h:i',strtotime($appointment_detail['appointment_time']));?>"> -->
                   <select class="form-control" name="appointment_time" id="load_time_slot_edit">
                   <?php 
                   $service_provider=$appointment_detail['staff_id'];
                   $appointment_date=$appointment_detail['appointment_date'];
                   
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
                               break;
                           }
                            
                       }
                        
                       $times = $feature->create_time_range($startt, $endt, '30 mins', $format = '24');
                       if (is_array($times)){
                           foreach ($times as $t)
                                                {?>
                     <option <?php if($appointment_detail['appointment_time']==date('H:i:s',strtotime($t))){echo "selected='selected'";} ;?> value="<?php echo $t;?>"><?php echo date('h:i A',strtotime($t));?></option>   
                                                <?php }}
                      }
                   
                   
                   
                   ?>

                      </select>
               </div>
            </div>
             <div class="form-group">
               <label class="control-label col-md-3">Notes</label>
               <div class="col-md-8">
                  <input class="form-control" type="text" name="appointment_notes" value="<?php echo $appointment_detail['notes'];?>">
               </div>
            </div>
            <script src="<?php echo SITE_URL.'/assets/frontend/plugins/bootstrap-datepicker/bootstrap-datepicker.js';?>"></script>
             <script>
                    $('.datepicker').datepicker({
                  	  format: "dd-mm-yyyy",
                      todayBtn: "linked",
                      autoclose: true,
                      todayHighlight: true,
                      startDate: new Date()});  
        </script>
<script>
                      
$('#load_services_by_provider_edit').change(function(){
	var pid=$(this).val();
	 $.ajax({
	      type: 'post',
	      url: '<?php echo $link->link('ajax',frontend);?>',
	      data:'&load_service='+pid,
	     success: function (data) {
	    
	    $(".load_services_edit").html(data);
	    
      }
	    });
});



$('#load_cost_time_by_service_edit').change(function(){
	var sid=$(this).val();
	 $.ajax({
	      type: 'post',
	      url: '<?php echo $link->link('ajax',frontend);?>',
	      data:'&load_cost_time='+sid,
	     success: function (data) {
	    
	    $(".load_costandtime_edit").html(data);
	    
      }
	    });
});


$('#load_services_by_provider_edit').change(function(){
	var pid=$(this).val();
	var date=$("#get_date_calender_edit").val();
	//alert(pid+"=="+date);  
	 $.ajax({
	      type: 'post',
	      url: '<?php echo $link->link('ajax',frontend);?>',
	      data:'&load_time_range='+pid+'&adate='+date,
	     success: function (data) {
	   $("#load_time_slot_edit").html(data);
		 }
	    });
});

$('#get_date_calender_edit').change(function(){
	var date=$(this).val();
	var pid=$("#load_services_by_provider_edit").val();
	//alert(pid+"=="+date);  
	 $.ajax({
	      type: 'post',
	      url: '<?php echo $link->link('ajax',frontend);?>',
	      data:'&load_time_range='+pid+'&adate='+date,
	     success: function (data) {
	   $("#load_time_slot_edit").html(data); 
		 }
	    });
});
</script>
 
<?php } 
/****************************************************************************************/
/*****************************Appointment Edit code*************************************/
/**************************************************************************************/

if (isset($_REQUEST['delete_appointment']))
{
    $appont_details=$db->get_row('appointments',array('id'=>$_REQUEST['delete_appointment']));
   
             $first_name=$db->get_var('customers',array('id'=>$appont_details['customer_id']),'first_name');
             $last_name=$db->get_var('customers',array('id'=>$appont_details['customer_id']),'last_name');
             $customer_email=$db->get_var('customers',array('id'=>$appont_details['customer_id']),'email');
             $customer_phone=$db->get_var('customers',array('id'=>$appont_details['customer_id']),'mobile_number');
             $service_name=$db->get_var('services',array('id'=>$appont_details['service_id']),'service_name');
             $staff_first_name=$db->get_var('users',array('user_id'=>$appont_details['staff_id']),'firstname');
             $staff_last_name=$db->get_var('users',array('user_id'=>$appont_details['staff_id']),'lastname');
             $staff_email=$db->get_var('users',array('user_id'=>$appont_details['staff_id']),'email');
             $appointment_date=$appont_details['appointment_date'];
             $appointment_time=$appont_details['appointment_time'];
             $appointment_company_id=$appont_details['company_id'];
             
               $company_details=$db->get_row('company',array('id'=>$appointment_company_id));
                    $company_currency=$company_details['company_currencysymbol'];
                    $company_name=$company_details['company_name'];
                    $company_email=$company_details['company_email'];
                    $clogo=SITE_URL.'/uploads/company/'.$company_id.'/logo/'.$company_details[company_logo];
           
$event="<b>Canceled appt.</b>  ".$first_name." ".$last_name." for a " . $service_name . "<br>
     on " . date('d M Y',strtotime($appointment_date)) . "@".date('h:i:s a',strtotime($appointment_time)). " w/ " . $staff_first_name . " " . $staff_last_name;
                      $db->insert('activity_logs',array('user_id'=>$_SESSION['user_id'],
                                                          'event_type'=>'appointment_deleted',
                                                          'event'=>$event,
                                                          'company_id'=>$appointment_company_id,
                                                          'event_type_id'=>$_REQUEST['delete_appointment'],
                                                          'created_date'=>date('Y-m-d'),
                                                          'ip_address'=>$_SERVER['REMOTE_ADDR']
                
                        ));
                      $delete=$db->delete('appointments',array('id'=>$_REQUEST['delete_appointment']));
                      if ($delete)
                      {
if (is_array($common_data_customer_notification)){
if (in_array('appointment_canceled', $common_data_customer_notification)){
$customer_delete_appointment_email_body = '<table cellspacing="0" cellpadding="0" style="padding:30px 10px;background-color:rgb(238,238,238);width:100%;font-family:arial;background-repeat:initial initial">
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
                        	<h1 style="color:#4e5b63;font-size:28px;margin:15px 0px 0px;font-weight:500">Cancelled</h1>
								<h6 style="color:#4e5b63;font-size:15px;margin:25px 0px 10px;font-weight:500">Hi '.$first_name.' '.$last_name.',</h6>
								<p style="color:#788a95;font-size:15px;margin:10px 0px 15px">Your appointment has been Cancelled with '.$company_name.'</p>
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
                    $headers .= 'From: '.$common_data_sendar_name .'<'.$company_email . ">\r\n" .
                        'Reply-To: '.$company_email . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();
                    
                    $subject="Appointment Scheduled for ". date('d M Y',strtotime($appointment_date))." ".date('h:i:s a',strtotime($appointment_time))." with ".$staff_first_name . " " . $staff_last_name. " is Cancelled";
                   
                    $confirm    =  mail($customer_email, $subject,$customer_delete_appointment_email_body,$headers);
                    
} }
/***************************Appointment scheduled cancle email to staff*************************/

if (is_array($common_data_staff_notification)){
    if (in_array('appointment_canceled', $common_data_staff_notification)){
        $staff_delete_appointment_email_body = '<table cellspacing="0" cellpadding="0" style="padding:30px 10px;background-color:rgb(238,238,238);width:100%;font-family:arial;background-repeat:initial initial">
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
                        	<h1 style="color:#4e5b63;font-size:28px;margin:15px 0px 0px;font-weight:500">Cancelled</h1>
								<h6 style="color:#4e5b63;font-size:15px;margin:25px 0px 10px;font-weight:500">Hi '.$staff_first_name.' '.$staff_last_name.',</h6>
								<p style="color:#788a95;font-size:15px;margin:10px 0px 15px">Your appointment has been cancelled.</p>
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
            $staff_delete_appointment_email_body .='
                
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
	$staff_delete_appointment_email_body .= '<div style="border-bottom12:1px solid #e5e5e5;padding-bottom:5px;margin-bottom:20px">
							<p style="color:#788a95;font-size:15px;margin:10px 0px 15px">'.$common_data_email_signature.'</p>
							</div></td>
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
        $headers .= 'From: '.$common_data_sendar_name .'<'.$company_email . ">\r\n" .
            'Reply-To: '.$company_email . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        $subject="Appointment Scheduled on ". date('d M Y',strtotime($appointment_date))." ".date('h:i:s a',strtotime($appointment_time))." with ".$first_name . " " . $last_name."  is Cancelled";

        $confirm    =  mail($staff_email, $subject,$staff_delete_appointment_email_body,$headers);
    } }                   
                    
                    if($confirm=='1')
                    {
                           $return['msg']='<div class="alert alert-success text-success">
                            		<i class="fa fa-smile-o"></i> <button class="close" data-dismiss="alert" type="button">
                            <i class="fa fa-times-circle-o"></i></button> Appointment Cancel successfully and mail sent.
                            		</div>';
                    $return['error']=false;
                    echo json_encode($return);
                    }
                    else
                    {
              $return['msg']='<div class="alert alert-success text-success">
                            		<i class="fa fa-smile-o"></i> <button class="close" data-dismiss="alert" type="button">
                            <i class="fa fa-times-circle-o"></i></button> Appointment Cancel successfully!. 
                            		</div>';
                    $return['error']=false;
                    echo json_encode($return);
                    } 
    }
}?>
<?php if (isset($_REQUEST['load_service'])){
$all_services_by_provider=$db->get_all('assign_services',array('staff_id'=>$_REQUEST['load_service']));

if (is_array($all_services_by_provider))
{
    echo"<option value=''>---Select---</option>";  
foreach ($all_services_by_provider as $alps)
    {
        $service_name=$db->get_var('services',array('id'=>$alps['service_id']),'service_name');
    ?>
  <option value="<?php echo $alps['service_id']?>"><?php echo $service_name;?></option>
<?php }}}?>


<?php if (isset($_REQUEST['load_cost_time'])){
    $service_cost=$db->get_var('services',array('id'=>$_REQUEST['load_cost_time']),'service_cost');
    $service_time=$db->get_var('services',array('id'=>$_REQUEST['load_cost_time']),'service_time');
    $company_id=$db->get_var('services',array('id'=>$_REQUEST['load_cost_time']),'company_id');
    
 

    $company_currency=$db->get_var('company',array('id'=>$company_id),'company_currencysymbol');
    
    ?>
     <label class="control-label col-md-3"></label> 
               <div class="col-md-4">
               <div class="input-group mar-btm">
                    <span class="input-group-btn">
                    <button class="btn btn-default" type="button"><?php echo $company_currency;?></button>
                    </span>
                    <input class="form-control" type="text" name="appointment_service_cost" value="<?php echo $service_cost;?>" placeholder="cost">
                </div>
               </div>
               <div class="col-md-4">
                  <div class="input-group mar-btm">
                     <input class="form-control" type="number" name="appointment_service_time" value="<?php echo $service_time;?>" placeholder="Mins">
                        <span class="input-group-btn">
                        <button class="btn btn-default" type="button">Mins</button>
                        </span>
                    </div>
               </div>

<?php }?>
<?php if (isset($_POST['add_timeoff_submit']))/*****************add Staff modal box submit****************/
{ 
    $company_id=$_POST['company_id'];
    $staff_id=$_POST['staff_id'];
    $timeoff_start_date=$_POST['timeoff_start_date'];
    $timeoff_end_date=$_POST['timeoff_end_date'];
    $timeoff_notes=$_POST['timeoff_notes'];
 
    $created_date=date('Y-m-d');
    $ip_address=$_SERVER['REMOTE_ADDR'];
 
    
   $check_empty=$fv->emptyfields(array('Select Start Date'=>$timeoff_start_date,
                                        'Select End Date'=>$timeoff_end_date,
                                        'Enter Notes'=>$timeoff_notes,
                                      ),NULL);
   if ($check_empty)
    {

        $return['msg']='<div class="alert alert-danger text-danger">
                		<i class="fa fa-frown-o text-danger"></i>
            <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
            Following Fields Are Empty!<br>'.$check_empty.'</div>';
        $return['error']=true;
        echo json_encode($return);

    }
    elseif (strtotime($timeoff_start_date)>strtotime($timeoff_end_date))
    {
        $return['msg']='<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
                        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
                        Start date should be less than end date!.
    					</div>';
        $return['error']=true;
        echo json_encode($return);
    }
    elseif (strtotime(date('Y-m-d'))>strtotime($timeoff_start_date))
    {
        $return['msg']='<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
                        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
                        Start date should be greater than or equal to today!.
    					</div>';
        $return['error']=true;
        echo json_encode($return);
    }
   elseif (strtotime($timeoff_start_date) < strtotime(date('Y-m-d')))
    {
        $return['msg']='<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
                        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
                        Timeoff start date should be greater than today date!
    					</div>';
        $return['error']=true;
        echo json_encode($return);
    }
  
    else 
    {
       $insert=$db->insert('timeoff',array('company_id'=>$company_id,
                                           'staff_id'=>$staff_id,
                                           'start_date'=>$timeoff_start_date,
                                           'end_date'=>$timeoff_end_date,
                                           'notes'=>$timeoff_notes,
                                           'created_date'=>date('Y-m-d'),
                                           'ip_address'=>$_SERVER['REMOTE_ADDR']));
       
         if ($insert){
        
                    
                    
                    $return['msg']='<div class="alert alert-success text-success">
                            		<i class="fa fa-smile-o"></i>
                                 <button class="close" data-dismiss="alert" type="button">
                            <i class="fa fa-times-circle-o"></i></button> Time Off add successfully!.
                            		</div>';
                    $return['error']=false;
                    echo json_encode($return);
                   }
        
        
    }
}?>
<?php
/*********************************************************************************************************/
/*************************************** Close Company Account (delete company or all related data) *******/
/*********************************************************************************************************/
 
 
 if (isset($_POST['close_account_submit']))
{ 
    $company_id=$_POST['company_id'];
    $company_name=$_POST['company_name'];
    $company_email=$_POST['company_email'];
    $close_reason=$_POST['close_reason'];
  
 if ($close_reason=="")
    {
        $return['msg']='<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
                        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
                        Please Enter A Reason!.
    					</div>';
        $return['error']=true;
        echo json_encode($return);
    }
else
    {
       $insert=$db->insert('account_close_reason',array('company_name'=>$company_name,
                                                        'company_email'=>$company_email,
                                                        'reason'=>$close_reason,
                                                        'created_date'=>date('Y-m-d'),
                                                        'ip_address'=>$_SERVER['REMOTE_ADDR']));
       
         if ($insert){
        
                    $delete_activity_logs=$db->delete('activity_logs',array('company_id'=>$company_id));
                    $delete_appointments=$db->delete('appointments',array('company_id'=>$company_id));
                    $delete_assign_services=$db->delete('assign_services',array('company_id'=>$company_id));
                    $delete_services=$db->delete('services',array('company_id'=>$company_id));
                    $delete_service_category=$db->delete('service_category',array('company_id'=>$company_id));
                    $delete_customers=$db->delete('customers',array('company_id'=>$company_id));
                    $delete_timeoff=$db->delete('timeoff',array('company_id'=>$company_id));
                    $delete_notification_settings=$db->delete('notification_settings',array('company_id'=>$company_id));
                    $delete_preferences_settings=$db->delete('preferences_settings',array('company_id'=>$company_id));
                    $delete_users=$db->delete('users',array('company_id'=>$company_id));
                    $delete_plans_company=$db->delete('plans_company',array('company_id'=>$company_id));
                    $delete_plans_all=$db->delete('plans_all',array('company_id'=>$company_id));
                    $delete_users=$db->delete('rooms',array('company_id'=>$company_id));
                    $delete_users=$db->delete('review',array('company_id'=>$company_id));
                    $delete_company=$db->delete('company',array('id'=>$company_id));
                    
                  $path = SITE_ROOT."/uploads/company/".$company_id;
                    if (file_exists($path)){
                    rmdir($path);
                 
                    }
                    $return['msg']='<div class="alert alert-success text-success">
                            		<i class="fa fa-smile-o"></i>
                                 <button class="close" data-dismiss="alert" type="button">
                            <i class="fa fa-times-circle-o"></i></button> Company Account Close Successfully!.
                            		</div>';
                    $return['error']=false;
                    echo json_encode($return);
                   }
        
        
    }
}?>

<?php 
/*********************************************************************************************************/
/*************************************** Assign Room or Seats to Appointments *****************************/
/*********************************************************************************************************/
if (isset($_POST['assign_room_submit'])){
    $company_id=$_POST['company_id'];
    $appointment_id=$_POST['appointment_id'];
    $room_id=$_POST['room_id'];
    if($room_id=="")
    {
        $return['msg']='<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
                        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
                        Please Select Room/Seat!.
    					</div>';
        $return['error']=true;
        echo json_encode($return);
    }
    else{
    $check_appont_details=$db->get_row('appointments',array('id'=>$appointment_id));
    $customer_id=$check_appont_details['customer_id'];
    $service_provider=$check_appont_details['staff_id'];
    $appointment_service=$check_appont_details['service_id'];
    $appointment_booking_id=$check_appont_details['booking_id'];
    $first_name=$db->get_var('customers',array('id'=>$customer_id),'first_name');
    $last_name=$db->get_var('customers',array('id'=>$customer_id),'last_name');
    $customer_email=$db->get_var('customers',array('id'=>$customer_id),'email');
    $customer_phone=$db->get_var('customers',array('id'=>$customer_id),'mobile_number');
    $service_name=$db->get_var('services',array('id'=>$appointment_service),'service_name');
    $staff_first_name=$db->get_var('users',array('user_id'=>$service_provider),'firstname');
    $staff_last_name=$db->get_var('users',array('user_id'=>$service_provider),'lastname');
    $staff_email=$db->get_var('users',array('user_id'=>$service_provider),'email');
    
    $appointment_date=$check_appont_details['appointment_date'];
    $appointment_start_time=$check_appont_details['appointment_time'];
    $appointment_end_time=$check_appont_details['appointment_end_time'];
    
 $query="SELECT* FROM `appointments` 
            WHERE `appointment_date`='$appointment_date' 
            AND `appointment_time` BETWEEN '$appointment_start_time' AND '$appointment_end_time'  
            AND `assigned_room`='$room_id'
            AND `status`='confirmed'
            AND `id`!='$appointment_id'";
 $fetchall_appointments_of_the_day=$db->run($query)->fetchAll();
   
   
 

if (!empty($fetchall_appointments_of_the_day))
    {
        
        $return['msg']='<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
                                <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
                                Room is alredy booked for this time!
            					</div>';
        $return['error']=true;
        echo json_encode($return);
        
    }
    else
    {
        $assign_r_e="room ready to block";
       $update=$db->update('appointments',array('assigned_room'=>$room_id,'status'=>'confirmed'),array('id'=>$appointment_id));
        if ($update)
        { 
        
             
          
            $company_details=$db->get_row('company',array('id'=>$company_id));
            $company_currency=$company_details['company_currencysymbol'];
            $company_name=$company_details['company_name'];
            $company_email=$company_details['company_email'];
            $clogo=SITE_URL.'/uploads/company/'.$company_id.'/logo/'.$company_details[company_logo];
             
            $allnotifications=$db->get_row('notification_settings',array('company_id'=>$company_id));
             
            $common_data_customer_notification=unserialize($allnotifications['customer_notification']);
            $common_data_staff_notification=unserialize($allnotifications['staff_notification']);
            $common_data_activity_alert=unserialize($allnotifications['activity_notifications']);
             
            if ($allnotifications['sendar_name']!="")
            {
                $common_data_sendar_name=$allnotifications['sendar_name'];
            }
            else
            {
                $common_data_sendar_name=$company_name;
            }
            if ($allnotifications['email_signature']!="")
            {
                $common_data_email_signature=html_entity_decode($allnotifications['email_signature']);
            }
            else
            {
                $common_data_email_signature="Thanks,<br>".$company_name;
            }  
/**************email sent to customer*************************/
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
								    Your appointment request has been booked and approved with '.$company_name.'.<br>
								        Your Booking no-'.$appointment_booking_id.' .  </p>
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
                    $headers .= 'From: '.$common_data_sendar_name .'<'.$company_email . ">\r\n" .
                        'Reply-To: '.$company_email . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();
        
                    $subject="Appointment Schedule Approved for ". date('d M Y',strtotime($appointment_date))." ".date('h:i:s a',strtotime($appointment_time))." with ".$staff_first_name . " " . $staff_last_name;
                     
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
								    You have an appointment scheduled with ' . ucfirst($first_name . ' ' . $last_name) . '. is approved now.<br>
								        Booking no-'.$appointment_booking_id.'.</p>
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
									<p style="display:inline-block;margin:0;color:#637374;font-size:15px">'.ucfirst($first_name.' '.$last_name).'</p>
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
                        $headers .= 'From: '.$common_data_sendar_name .'<'.$company_email . ">\r\n" .
                            'Reply-To: '.$company_email . "\r\n" .
                            'X-Mailer: PHP/' . phpversion();
        
                        $subject="Appointment Schedule Approved for ". date('d M Y',strtotime($appointment_date))." ".date('h:i:s a',strtotime($appointment_time))." with ".$first_name . " " . $last_name;
        
                        $confirm    =  mail($staff_email, $subject,$staff_add_appointment_email_body,$headers);
                    } }
        
        
                    if($confirm=='1')
                    {
                        $return['msg']='<div class="alert alert-success text-success">
                            		<i class="fa fa-smile-o"></i> <button class="close" data-dismiss="alert" type="button">
                            <i class="fa fa-times-circle-o"></i></button> Room Block Successfully and mail sent.
                            		</div>';
                        $return['error']=false;
                        echo json_encode($return);
                    }
                    else
                    {
                        $return['msg']='<div class="alert alert-success text-success">
                            		<i class="fa fa-smile-o"></i> <button class="close" data-dismiss="alert" type="button">
                            <i class="fa fa-times-circle-o"></i></button> Room Block Successfully.
                            		</div>';
                        $return['error']=false;
                        echo json_encode($return);
                    }
        
                     
        }
    }    
    
} 
}?> 

<?php
/*********************************************************************************************************/
/*************************************** Load Working hours of staff***************************************/
/*********************************************************************************************************/
 
 
 if (isset($_POST['load_time_range'])){
    
    $service_provider=$_POST['load_time_range'];
    $appointment_date=$_POST['adate'];
    
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
           break;
           }
   
       }
       
        $times = $feature->create_time_range($startt, $endt, '30 mins', $format = '24');
       if (is_array($times)){
           foreach ($times as $t)
                             {?>
                              <option value="<?php echo $t;?>"><?php echo date('h:i A',strtotime($t));?></option>   
                             <?php }}
   }
    
    
    
}?>


<?php
/**********************************************************************************************************/
/*****************************************  Add service code ***********************************************/
/**********************************************************************************************************/
if (isset($_POST['add_service_submit']))
{
    //print_r($_POST);
    $company_id=$_POST['company_id'];
    $service_name=$_POST['service_name'];
    $service_description=$_POST['service_description'];
    $service_cost=$_POST['service_cost'];
    $service_time=$_POST['service_time'];
    $service_color=$_POST['service_color'];
    $service_buffer_time=$_POST['service_buffer_time'];
    $service_category=$_POST['service_category'];
    $assign_to=$_POST['assign_to'];
    $private_service=$_POST['private_service'];
    $visibility_status=$_POST['visibility_status'];
    $created_date=date('Y-m-d');
    $ip_address=$_SERVER['REMOTE_ADDR'];


$empt_fields = $fv->emptyfields(array('service Name'=>$service_name,
                                      'Sevice Cost'=>$service_cost,
                                      'Service Time'=>$service_time));

if ($empt_fields)
{
      $display_msg= '<div class="alert alert-danger">
		<i class="lnr lnr-sad"></i> <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
          Oops! Following fields are empty<br>'.$empt_fields.'</div>';
      
      
      $return['msg']='<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
                                <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
                                Oops! Following fields are empty<br>'.$empt_fields.'</div>';
      $return['error']=true;
      echo json_encode($return);
      
      
}

elseif ($db->exists('services',array('service_name'=>$service_name,'company_id'=>$company_id)))
{
   
    
    
    $return['msg']='<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
                                <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
                                Service Name is already exist.
            					</div>';
    $return['error']=true;
    echo json_encode($return);
    
    
    
}
else
{
 
   $insert=$db->insert("services",array('company_id'=>$company_id,
                                        'service_name'=>$service_name,
                                        'service_cost'=>$service_cost,
                                        'service_description'=>$service_description,
                                        'service_time'=>$service_time,
                                        'service_buffer_time'=>$service_buffer_time,
                                        'service_category'=>$service_category,
                                        'service_color'=>$service_color,
                                        'private_service'=>$private_service,
                                        'visibility_status'=>'active',
                                        'created_date'=>$created_date,
                                        'ip_address'=>$ip_address));
   $last_inserted_service=$db->insert_id;
 //  $db->debug();
    if ($insert){
        if (is_array($assign_to))
        {
            foreach ($assign_to as $ato)
            {
                $assign=$db->insert("assign_services",array('company_id'=>$company_id,
                                                            'staff_id'=>$ato,
                                                            'service_id'=>$last_inserted_service,
                                                            'created_date'=>$created_date,
                                                            'ip_address'=>$ip_address));
            }
        }
$return['msg']='<div class="alert alert-success text-success">
                            		<i class="fa fa-smile-o"></i> <button class="close" data-dismiss="alert" type="button">
                            <i class="fa fa-times-circle-o"></i></button> service add Successfully.
                            		</div>';
                        $return['error']=false;
                        echo json_encode($return);



    }
}
}?>
<?php
/***********************************************************************************************************/
 /****************************** load status on calendar****************************************************/
 /***********************************************************************************************************/
 
 
 if (isset($_POST['load_stat_on_calendar']))
{
   $pi=$_POST['load_stat_on_calendar'];
   $adate=$_POST['adate'];
   $ci=$_POST['company_id'];
   
  
  $start_date=date("Y-m-01", strtotime($adate));
  $end_date=date("Y-m-t", strtotime($adate));
   
   if ($pi!=""){
       
       
   /**********************************find Confirmed Revenue*************************/
   $query2="SELECT SUM(`service_cost`)
   FROM `appointments`
   WHERE `company_id`='$ci' AND `staff_id`='$pi' AND `appointment_date` BETWEEN '$start_date' AND '$end_date' AND `status`='paid'";
   $confirmed_revenue=$db->run($query2)->fetchColumn();
   /**********************************find Projected Revenue*************************/
   $query2="SELECT SUM(`service_cost`)
   FROM `appointments`
   WHERE `company_id`='$ci' AND `staff_id`='$pi' AND `appointment_date` BETWEEN '$start_date' AND '$end_date' AND `status`='confirmed'";
   $projected_revenue=$db->run($query2)->fetchColumn();
   
   /**********************************find Total Revenue*************************/
   $total_estimate=$confirmed_revenue+$projected_revenue;
   
   
   /**********************************find all Appointment of the week*************************/
   $query1="SELECT*
   FROM `appointments`
   WHERE `company_id`='$ci' AND `staff_id`='$pi' AND `appointment_date` BETWEEN '$start_date' AND '$end_date'
   ORDER BY id DESC";
   $this_week_appointments=$db->run($query1)->fetchAll();
   $appointment_count=count($this_week_appointments);
    
   }else{
       
       /**********************************find Confirmed Revenue*************************/
       $query2="SELECT SUM(`service_cost`)
       FROM `appointments`
       WHERE `company_id`='$ci'  AND `appointment_date` BETWEEN '$start_date' AND '$end_date' AND `status`='paid'";
       $confirmed_revenue=$db->run($query2)->fetchColumn();
       /**********************************find Projected Revenue*************************/
       $query2="SELECT SUM(`service_cost`)
       FROM `appointments`
       WHERE `company_id`='$ci' AND `appointment_date` BETWEEN '$start_date' AND '$end_date' AND `status`='confirmed'";
       $projected_revenue=$db->run($query2)->fetchColumn();
        
       /**********************************find Total Revenue*************************/
       $total_estimate=$confirmed_revenue+$projected_revenue;
        
        
       /**********************************find all Appointment of the week*************************/
       $query1="SELECT*
       FROM `appointments`
       WHERE `company_id`='$ci' AND `appointment_date` BETWEEN '$start_date' AND '$end_date'
       ORDER BY id DESC";
       $this_week_appointments=$db->run($query1)->fetchAll();
       $appointment_count=count($this_week_appointments);
        
       
       
       
   }?>
<table style="margin:20px;">
<thead>

</thead>
<tbody>
<tr style="text-align:center; border-bottom:1px solid red;">
<td colspan="3" text-align="center">
<?php if ($pi!="")
{
    $service_provider_firstname=$db->get_var('users',array('user_id'=>$pi),'firstname');
    $service_provider_lastname=$db->get_var('users',array('user_id'=>$pi),'lastname');
    echo ucwords($service_provider_firstname." ".$service_provider_lastname)."&#39;s Monthly Stats";
}else
{
echo "Monthly Stats ".$pi;
}


?></td> 
</tr>
<tr>
<td style="text-align:center;padding:10px;"><h4><?php echo $appointment_count;?></h4>Appts</td>
<td style="text-align:center;padding:10px;"><h4><?php echo CURRENCY.number_format($confirmed_revenue,2);?></h4>Confirmed</td>
<td style="text-align:center;padding:10px;"><h4><?php echo CURRENCY.number_format($projected_revenue,2);?></h4>Projected</td>

</tr>

</tbody>

</table>
<?php }?>

<?php
/**********************************************************************************************************/
/*****************************************  Add service categoty code ***********************************************/
/**********************************************************************************************************/
if (isset($_POST['add_service_category_submit']))
{
    //print_r($_POST);
    $company_id=$_POST['company_id'];
    $category_name=$_POST['category_name'];
    $visibility_status='active';
    $created_date=date('Y-m-d');
    $ip_address=$_SERVER['REMOTE_ADDR'];


$empt_fields = $fv->emptyfields(array('Category Name'=>$category_name));

if ($empt_fields)
{
      $display_msg= '<div class="alert alert-danger">
		<i class="lnr lnr-sad"></i> <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
          Oops! Following fields are empty<br>'.$empt_fields.'</div>';
      
      
      $return['msg']='<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
                                <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
                                Oops! Following fields are empty<br>'.$empt_fields.'</div>';
      $return['error']=true;
      echo json_encode($return);
      
      
}

else
{
 
    $insert=$db->insert("service_category",array('category_name'=>$category_name,
                                                 'company_id'=>$company_id,
                                                 'visibility_status'=>$visibility_status,
                                                 'created_date'=>$created_date,
                                                 'ip_address'=>$ip_address));

    if ($insert){
       
$return['msg']='<div class="alert alert-success text-success">
                            		<i class="fa fa-smile-o"></i> <button class="close" data-dismiss="alert" type="button">
                            <i class="fa fa-times-circle-o"></i></button> Service category add Successfully.
                            		</div>';
                        $return['error']=false;
                        echo json_encode($return);



    }
}
}?>


<?php if (isset($_POST['load_assign_room_form']))
{
    $apointment_id=$_POST['load_assign_room_form'];
    $apintment_details=$db->get_row('appointments',array('id'=>$apointment_id));
    ?>
    <div class="modal-content">
    <div id="after_post_message_assign_room_form"></div>
    <form id="assign_room_form" method="post" class="form-horizontal" action="" enctype="multipart/form-data">
    <input type="hidden" name="assign_room_submit" value="assign_room_submit">
    <input type="hidden" name="company_id" value="<?php echo $apintment_details['company_id'];?>">
     <div class="modal-header">
       <h4 class="modal-title">Add Room/Seat</h4>
      </div>
      <div class="modal-body">
       <div class="form-group">
           <label class="control-label col-md-4">Room/Seat</label>
           <div class="col-md-7">
             <input class="form-control" type="hidden" name="appointment_id" value="<?php echo $apointment_id;?>" id="appoint_assign_room">
            
             <select class="form-control" name="room_id">
             <option value="">Select Room</option>
            <?php  $all_room=$db->get_all('rooms',array('visibility_status'=>'active','company_id'=>$apintment_details['company_id']));
                                            if (is_array($all_room)){
                                             foreach ($all_room as $allr)
                                             {?>
                      <option value="<?php echo$allr['id'];?>"><?php echo ucwords($allr['name']);?></option>                       
             <?php }}?>
             
             
             </select>
           </div>
          </div>
         
             
          </div>
      <div class="modal-footer">
        <button class="btn btn-info" name="edit_appointment_form_submit" type="submit"><i class="fa fa-save"></i> Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times-circle"></i> Close</button>
      </div>
      </form>
    </div>
    
    
    
<script>
/************************Assign rooms**********************************************/
$(function () {

	  $('#assign_room_form').on('submit', function (e) {
		  
		  e.preventDefault();
	    $.ajax({
	      type: 'post',
	      url: '<?php echo $link->link('ajax',admin);?>',
	      data: $('#assign_room_form').serialize(),
	  dataType: 'json',
	      success: function (data) {
	    	  
	     $("#after_post_message_assign_room_form").html(data.msg);

         if(data.error==false){
	    	  setTimeout(function(){
	    		  window.location = '';
	                },3000);
               }
          }
	    });

	  }); 

	});
</script>   
<?php }?>

