<style>
.valueToDateContent{
    color: #555555;
    float: left;
    margin-top: 5px;
    width: 78%;
    height: 98px;
    border: 1px solid #C0C0C0;
    position: relative;
    line-height: 1;
    text-align: center;
    padding-top: 15px;
    overflow: hidden;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}</style>
<?php


if (isset($_REQUEST['action_id']))
{
    $company_id=$_REQUEST['action_id'];
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
   
}

$current_tab=$_COOKIE['current_tab'];


if ($current_tab!="appointment" && $current_tab!="notes" && $current_tab!="stats")
{$current_tab="appointment";}

if (isset($_REQUEST['action_edit']))
{
    $edit_id=$_REQUEST['action_edit'];
    $customer_detail=$db->get_row('customers',array('id'=>$edit_id));
}
if (isset($_REQUEST['action_paid']))
{
    $action_id=$_REQUEST['action_paid'];
    
    $display_msg='<form method="POST" action="">
    <div class="alert alert-danger">
    <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
	Are you sure ? You want to Paid this .
	<input type="hidden" name="del_id" value="'.$action_id.'" >
	<button name="yes" type="submit" class="btn btn-success btn-xs"  aria-hidden="true"><i class="fa fa-check-circle-o fa-2x"></i></button>
	<button name="no" type="submit" class="btn btn-danger btn-xs" aria-hidden="true"><i class="fa fa-times-circle-o fa-2x"></i></button>
	</div>
	</form>';
    if(isset($_POST['yes']))
    {
       $update_paid=$db->update('appointments',array('status'=>'paid'),array('id'=>$action_id)); 
       if ($update_paid)
       {
           $display_msg= '<div class="alert alert-success text-success">
                		<i class="fa fa-smile-o"></i>
                    <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
                    Appointment Status Change to Paid Successfully.
                		</div>';
           echo "<script>
                         setTimeout(function(){
        	    		  window.location = '".$link->link("edit_customer",admin,'&action_id='.$company_id.'&action_edit='.$edit_id)."'
        	                },3000);</script>";
       }
    }
    elseif(isset($_POST['no']))
    {
        $session->redirect('edit_customer&action_id='.$company_id.'&action_edit='.$edit_id,admin);
    }
}

if(isset($_REQUEST['action_delete']))
{
    $delete_id=$_REQUEST['action_delete'];

    $display_msg='<form method="POST" action="">
    <div class="alert alert-danger">
    <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
	Are you sure ? You want to delete this .
	<input type="hidden" name="del_id" value="'.$delete_id.'" >
	<button name="yes" type="submit" class="btn btn-success btn-xs"  aria-hidden="true"><i class="fa fa-check-circle-o fa-2x"></i></button>
	<button name="no" type="submit" class="btn btn-danger btn-xs" aria-hidden="true"><i class="fa fa-times-circle-o fa-2x"></i></button>
	</div>
	</form>';
    if(isset($_POST['yes']))
    {
        $appont_details=$db->get_row('appointments',array('id'=>$_POST['del_id']));
         
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
      //  $company_id=$appont_details['company_id'];
        
        $delete=$db->delete('appointments',array('id'=>$_POST['del_id']));
        if($delete)
        {
            $event="<b>Canceled appt.</b>  ".$first_name." ".$last_name." for a " . $service_name . "<br>
     on " . date('d M Y',strtotime($appointment_date)) . "@".date('h:i:s a',strtotime($appointment_time)). " w/ " . $staff_first_name . " " . $staff_last_name;
            $db->insert('activity_logs',array('user_id'=>$_SESSION['user_id'],
                                              'event_type'=>'appointment_deleted',
                                              'event'=>$event,
                                              'company_id'=>$company_id,
                                              'event_type_id'=>$_POST['del_id'],
                                              'created_date'=>date('Y-m-d'),
                                              'ip_address'=>$_SERVER['REMOTE_ADDR']
                
            
            ));
         //   $db->debug();
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
                        'Reply-To: '.$$company_email . "\r\n" .
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
if ($confirm==1){
            $display_msg= '<div class="alert alert-success text-success">
                		<i class="fa fa-smile-o"></i>
                    <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
                    Appointment Delete Successfully and mail send.
                		</div>';
            echo "<script>
                         setTimeout(function(){
        	    		  window.location = '".$link->link("edit_customer",admin,'&action_id='.$company_id.'&action_edit='.$edit_id)."'
        	                },3000);</script>";
        }else{
            $display_msg= '<div class="alert alert-success text-success">
                		<i class="fa fa-smile-o"></i>
                    <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
                    Appointment Delete Successfully.
                		</div>';
            echo "<script>
                         setTimeout(function(){
        	    		  window.location = '".$link->link("edit_customer",admin,'&action_id='.$company_id.'&action_edit='.$edit_id)."'
        	                },3000);</script>";
        }
        }
    }
    elseif(isset($_POST['no']))
    {
        $session->redirect('edit_customer&action_id='.$company_id.'&action_edit='.$edit_id,admin);
    }

}
if (isset($_POST[notes_submit]))
{
   
    $notes_description=htmlentities($_POST['notes_description']);
    $notes_update=$db->update('customers',array('notes'=>$notes_description),array('id'=>$edit_id));
    if ($notes_update)
    {
        $event="<b>Customer</b>  ".ucfirst($customer_detail['first_name'])." ".ucfirst($customer_detail['last_name'])."'s contact info has been edited";
        $db->insert('activity_logs',array('user_id'=>$_SESSION['user_id'],
            'event_type'=>'customer_updated',
            'event'=>$event,
            'event_type_id'=>$edit_id,
            'created_date'=>date('Y-m-d'),
            'ip_address'=>$_SERVER['REMOTE_ADDR']
        
        ));
        $display_msg='<div class="alert alert-success text-success">
                    <i class="fa fa-smile-o"></i>
                     <button class="close" data-dismiss="alert" type="button">
                       <i class="fa fa-times-circle-o"></i></button>
                     Success! Data Updated.
                      </div>';
        
        echo "<script>
                         setTimeout(function(){
        	    		  window.location = '".$link->link("edit_customer",admin,'&action_id='.$company_id.'&action_edit='.$edit_id)."'
        	                },3000);</script>";
    }
}

if (isset($_POST['add_contact_form_submit']))
{
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
  $cid=$company_id;
  //  $visibility_status=$_POST['visibility_status'];
  $created_date=date('Y-m-d');
    $ip_address=$_SERVER['REMOTE_ADDR'];

    $sql=" SELECT email FROM `customers` WHERE `email`='$email' AND `company_id`='$cid' AND `id`!='$edit_id'";
    $exist_email_check=$db->run($sql)->fetchAll();
    
    
$empt_fields = $fv->emptyfields(array('Email Address'=>$email,
                                      'First Name'=>$first_name,
                                      'Mobile'=>$mobile_number));

if ($empt_fields)
{
      $display_msg= '<div class="alert alert-danger text-danger">
		<i class="fa fa-frown-o"></i> 
          <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
          Oops! Following fields are empty<br>'.$empt_fields.'</div>';
}

elseif (!$fv->check_email($email))
{
        $display_msg= '<div class="alert alert-danger text-danger ">
		<i class="fa fa-frown-o"></i> 
            <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
            Oops! Wrong Email Format.
		</div>';
}
elseif ($exist_email_check)
{
    $display_msg= '<div class="alert alert-danger text-danger">
		<i class="fa fa-frown-o"></i> 
        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
            This email is already exist.
		</div>';
}
else
{
 
   $insert=$db->update("customers",array('email'=>$email,
                                        'first_name'=>$first_name,
                                        'last_name'=>$last_name,
                                        'mobile_number'=>$mobile_number,
                                        'office_phone_number'=>$office_phone_number,
                                        'home_phone_number'=>$home_phone_number,
                                        'address'=>$address,
                                        'city'=>$city,
                                        'state'=>$state,
                                        'zip'=>$zip,
                                    //    'visibility_status'=>$visibility_status,
                                        'ip_address'=>$ip_address),array('id'=>$edit_id));
   //$db->debug();
    if ($insert){
        $event="<b>Customer</b>  ".ucfirst($first_name)." ".ucfirst($last_name)."'s contact info has been edited";
        $db->insert('activity_logs',array('user_id'=>$_SESSION['user_id'],
                                          'event_type'=>'customer_updated',
                                          'event'=>$event,
                                          'company_id'=>$company_id,
                                          'event_type_id'=>$edit_id,
                                          'created_date'=>date('Y-m-d'),
                                          'ip_address'=>$_SERVER['REMOTE_ADDR']

        ));
                $display_msg='<div class="alert alert-success text-success">
                    <i class="fa fa-smile-o"></i>
                     <button class="close" data-dismiss="alert" type="button">
                       <i class="fa fa-times-circle-o"></i></button>
                     Success! Data Updated.
                      </div>';

          echo "<script>
                         setTimeout(function(){
        	    		  window.location = '".$link->link("edit_customer",admin,'&action_id='.$company_id.'&action_edit='.$edit_id)."'
        	                },3000);</script>";



    }
}
}?>
 <div id="page-content">  
                         <div class="row">
                         <?php echo $display_msg;?>
                             <div class="col-md-6"> 
                                 <div class="panel">
                                        <div class="panel-heading">
                                            <div class="panel-control">
                                                <a href="<?php echo $link->link('customers',admin,'&action_id='.$company_id);?>" class="btn btn-default" data-click="panel-expand"><i class="fa fa-users"></i> Customers</a>
                                            </div>
                                            <h3 class="panel-title">Customer Details</h3>
                                        </div>
                                     
                                     <form id="add_contact_form12" method="post" class="form-horizontal" action="<?php $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
                                        <div class="panel-body">
                                          <div class="row">
                         
                               
                                <div class="col-md-12">    
                       
                     
                       <div class="form-group">
                           <label class="control-label col-md-3">Email<font color="red">*</font></label>
                           <div class="col-md-9">
                              <input class="form-control" placeholder="name@address.com" type="text" name="email" value="<?php echo $customer_detail['email'];?>">
                           </div>
                        </div>
                        <div class="form-group">
                           <label class="control-label col-md-3">Name<font color="red">*</font></label>
                           <div class="col-md-5">
                              <input class="form-control" placeholder="First Name" type="text" name="first_name" value="<?php echo $customer_detail['first_name'];?>">
                           </div>
                           <div class="col-md-4">
                           <input class="form-control" placeholder="Last Name" type="text" name="last_name" value="<?php echo $customer_detail['last_name'];?>">
                           </div>
                        </div>
                        
                           <div class="form-group">
                           <label class="control-label col-md-3">Contacts</label>
     
                           <div class="col-md-3">
                              <input class="form-control" placeholder="Mobile" type="text" name="mobile_number" value="<?php echo $customer_detail['mobile_number'];?>">
                           </div>
                           <div class="col-md-3">
                              <input class="form-control" placeholder="Office Phone" type="text" name="office_phone_number" value="<?php echo $customer_detail['office_phone_number'];?>">
                           </div>
                           <div class="col-md-3">
                              <input class="form-control" placeholder="Home Phone" type="text" name="home_phone_number" value="<?php echo $customer_detail['home_phone_number'];?>">
                           </div>
                        </div>
                     <div class="form-group">
                           <label class="control-label col-md-3">Address</label>
                           <div class="col-md-9">
                              <textarea class="form-control" placeholder="address" rows="5" name="address"><?php echo $customer_detail['address'];?></textarea>
                           </div>
                        </div>
                          <div class="form-group">
                           <label class="control-label col-md-3"></label>
                           <div class="col-md-3">
                              <input class="form-control" placeholder="city" type="text" name="city" value="<?php echo $customer_detail['city'];?>">
                           </div>
                            <div class="col-md-3">
                              <input class="form-control" placeholder="state" type="text" name="state" value="<?php echo $customer_detail['state'];?>">
                           </div>
                            <div class="col-md-3">
                              <input class="form-control" placeholder="zip" type="text" name="zip" value="<?php echo $customer_detail['zip'];?>">
                           </div>
                        </div>
                   
                          </div>
					        </div>
					        </div>
                            <div class="panel-footer text-right">
                                  <button class="btn btn-info" name="add_contact_form_submit"  id="add_contact_form_submit_id12121" type="submit">Submit</button>  
                             </div>
                                        
                                         </form>

                                    </div>
                                </div>
                                <div class="col-lg-6">
                         
                                <div class="tab-base">
                                    <!--Nav Tabs-->
                                    <ul class="nav nav-tabs">
                                        <li tab="appointment"  class="set_cookie <?php if ($current_tab=='appointment'){echo 'active';}?>">
                                            <a data-toggle="tab" href="#demo-lft-tab-1"> APPOINTMENTS</a>
                                        </li>
                                        <li tab="notes"  class="set_cookie <?php if ($current_tab=='notes'){echo 'active';}?>">
                                            <a data-toggle="tab" href="#demo-lft-tab-2">NOTES</a>
                                        </li>
                                      <li tab="stats"  class="set_cookie <?php if ($current_tab=='stats'){echo 'active';}?>">
                                            <a data-toggle="tab" href="#demo-lft-tab-3">STATS</a>
                                        </li>
                                       
                                    </ul>
                               
                                    <div class="tab-content">
                                    <?php if ($current_tab=='appointment'){
                                       $appointment_count= $db->get_count('appointments',array('customer_id'=>$edit_id));
                                       $sql="SELECT SUM(service_cost) FROM `appointments` WHERE `customer_id`='$edit_id'";
                                       $appointment_cost=$db->run($sql)->fetchColumn();
                                        ?>
                                     <h4 class="text-thin">
                                     <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal_add_appointment"><i class="fa fa-plus"></i></button>
                                      &nbsp;&nbsp;&nbsp;<?php echo $appointment_count;?> appointments. <?php echo $company_currency."".$appointment_cost;?></h4>
                                            
                                            <div id="delete_appointment_modal_message"></div>
                                            <table class="table table-hover table-vcenter"> 
                                                <thead><tr>
                                                        <th>&nbsp;</th> 
                                                        <th>&nbsp;</th>
                                                        <th>&nbsp;</th>
                                                        </tr>
                                                </thead>
                                                <tbody>
                                                <?php 
                                                $db->order_by='id DESC';
                                                $appointments=$db->get_all('appointments',array('customer_id'=>$edit_id));
                                                if (is_array($appointments)){
                                                    foreach ($appointments as $appoint){
                                                    $service_provider_firstname=$db->get_var('users',array('user_id'=>$appoint['staff_id']),'firstname');
                                                    $service_provider_lastname=$db->get_var('users',array('user_id'=>$appoint['staff_id']),'lastname');
                                                    $service_name=$db->get_var('services',array('id'=>$appoint['service_id']),'service_name');
                                                        ?>
                                                    <tr>
                                                    <td>
                                                     <?php if($appoint['status']!="paid"){?>
                                                    <button data-toggle="modal" data-target="#myModal_edit_appointment" data="<?php echo $appoint['id'];?>" class="edit_modal_edit_customer btn btn-default btn-icon btn-circle icon-lg fa fa-calendar" ></button>
                                                    <?php }else{?>
                                                    <button data-toggle="modal" class=" btn btn-default btn-icon btn-circle icon-lg fa fa-calendar" ></button>
                                                    <?php }?>
                                                    
                                                    
                                                    </td>
                                                     <td><?php echo date('D M d,Y',strtotime($appoint['appointment_date']));?> (<?php echo date('h:i  A', strtotime($appoint['appointment_time']))."-".date('h:i  A', strtotime($appoint['appointment_end_time']));?>)<br>
                                                     <?php echo ucwords($service_provider_firstname." ".$service_provider_lastname);?> . <?php echo ucfirst($service_name);?> . <?php echo $appoint['service_time']?> min . <?php echo $company_currency."".$appoint['service_cost']?>
                                                     </td>
                                                      <td>
                                                  
                                                      <?php if($appoint['status']=="pending"){
                                                      if (strtotime($appoint['appointment_date']." ".$appoint['appointment_time']) > strtotime(date('Y-m-d H:i:s')))
                                                      {?>
                                                       <button data-toggle="modal" data-target="#myModal_assign_room" data="<?php echo $appoint['id'];?>" class="assign_room_button btn  btn-xs btn-warning pull-right" type="button"><i class="fa fa-check-circle-o"></i>Assign Room</button>   
                                                      <?php }else{?><span class="label label-danger">Running late</span><br>
                                                      <a data-toggle="modal" data-target="#myModal_edit_appointment" data="<?php echo $appoint['id'];?>" class="edit_modal_edit_customer" >
                                                      
                                                      (Click to Reschedule)
                                                      </a><?php }
                                                      ?>
                                                   
                                                   <?php }
                                                   else{?>
                                                   <span class="label label-<?php if ($appoint['status']=="paid"){echo"success";}else{echo "warning";} ?>"><?php echo ucfirst($appoint['status']);?></span><br>
                                                   <?php if ($appoint['status']=="confirmed"){?>
                                                   <span class="label label-info">Assigned Room: <?php echo ucwords($db->get_var('rooms',array('id'=>$appoint['assigned_room']),'name'));?></span>
                                                   <a href="<?php echo $link->link("edit_customer",admin,'&action_id='.$company_id.'&action_edit='.$edit_id.'&action_paid='.$appoint['id']);?>">(Click to Paid)</a>
                                                   <?php }?>
                                                   <?php }?> </td>
                                                     <td>
                                                    
                                                    <a href="<?php echo $link->link("edit_customer",admin,'&action_id='.$company_id.'&action_edit='.$edit_id.'&action_delete='.$appoint['id']);?>"><i class="fa fa-trash  text-danger"></i></a>
                                                     </td>
                                                    </tr>
                                                   <?php }}?>
                                                   </tbody>
                                           </table>
                                    <?php }elseif ($current_tab=='notes'){?>
                                    <h4 class="text-thin">Notes</h4>
                                           <form action="" method="post">
                                           <div class="row">
                                           <div class="col-md-12">
                                           <textarea id="demo-summernote" name="notes_description"><?php echo html_entity_decode($customer_detail['notes']);?></textarea>
                                           </div>
                                           <div class="col-md-12">
                                           <button class="btn btn-info pull-right" type="submit" name="notes_submit">submit</button></div>
                                           </div>
                                               
                                            
                                                
                                                 
                                            </form>
                                    <?php }elseif ($current_tab=='stats'){?>
                                      
                              <div class="row">
                               <div class="col-md-6">
                                <div class="widgetbox widgetbox-default widgetbox-item-icon valueToDateContent" >
                                   <div class="widgetbox-data-left" style="padding-right: 21px;">
                                     <?php    $appointment_count= $db->get_count('appointments',array('customer_id'=>$edit_id));
                                       $sql="SELECT SUM(service_cost) FROM `appointments` WHERE `customer_id`='$edit_id'";
                                       $appointment_cost=$db->run($sql)->fetchColumn();
                                       $average_purchase=$appointment_cost/$appointment_count;
                                       ?>
                                    <p>Value to Date</p>
                                        <div class="widgetbox-int" style="text-align: center;">
                                        <?php echo $company_currency."".number_format($$company_currency."".cost,2,'.',',');?></div>
                                        
                                    </div>
                                 </div>
                                <br>
                                 <div class="widgetbox widgetbox-default widgetbox-item-icon valueToDateContent" >
                                   <div class="widgetbox-data-left" style="padding-right: 21px;">
                                     <?php   $appointment_count= $db->get_count('appointments',array('customer_id'=>$edit_id));
                                       $sql="SELECT SUM(service_cost) FROM `appointments` WHERE `customer_id`='$edit_id'";
                                       $appointment_cost=$db->run($sql)->fetchColumn();
                                       $average_purchase=$appointment_cost/$appointment_count;
                                       ?>
                                    <p>Average Purchase</p>
                                        <div class="widgetbox-int" style="text-align: center;">
                                        <?php echo $company_currency."".number_format($average_purchase,2,'.',',');?></div>
                                         
                                     </div>
                                </div>
                            </div>
                         </div>
                                    <?php }?>
                                    </div>
                                </div>
                       
                            </div>
                        
                        </div>
                    </div>

                    
<!--******************************** Modal box to Add Appointment ***********************************///--> 
                                       
<div id="myModal_add_appointment" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    <div id="after_post_message_appointment"></div>
    <form id="add_appointment_form" method="post" class="form-horizontal" action="" enctype="multipart/form-data">
    <input type="hidden" name="add_appointment_submit" value="add_appointment_submit">
    <input type="hidden" name="customer_id" value="<?php echo $edit_id;?>">
    <input type="hidden" name="booking_from" value="admin_edit_customer_page">
    <input type="hidden" name="company_id" value="<?php echo $company_id;?>">
      <div class="modal-header">
       <h4 class="modal-title">Add Appointment</h4>
      </div>
      <div class="modal-body">
               <div class="form-group">
                           <label class="control-label col-md-3">Provider<font color="red">*</font></label>
                           <div class="col-md-8">
                              <select class="form-control"name="service_provider" id="load_services_by_provider">
                              <option value="">---Seleziona--- </option>
                              <?php $provider=$db->get_all('users',array('visibility_status'=>'active','company_id'=>$company_id));
                              if (is_array($provider))
                              {
                                  foreach ($provider as $pro)
                                  {?>
                                     <option  value="<?php echo $pro['user_id']?>"><?php echo $pro['firstname']." ".$pro['lastname'];?></option> 
                                  <?php }
                              }?>
                              
                              </select>
                           </div>
                        </div>
             <div class="form-group">
               <label class="control-label col-md-3">Service<font color="red">*</font></label>
               <div class="col-md-8">
                  <select class="form-control load_services" name="appointment_service" id="load_cost_time_by_service">
                
                  </select>
               </div>
            </div>
            <div class="form-group load_costandtime">
              
            </div>
              <div class="form-group">
               <label class="control-label col-md-3">Day/Time</label>
               <div class="col-md-5">
                  <input class="form-control datepicker" type="text" name="appointment_date" value="<?php echo date('Y-m-d');?>" id="get_date_calender">
                  <p> Appointment should be in Future dates
                  </p>
               </div>
               <div class="col-md-3">
                <!--   <input class="form-control" type="time" name="appointment_time" value=""> -->
                  <select class="form-control" name="appointment_time" id="load_time_slot">
                
                      </select>
                      
                      
               </div>
            </div>
             <div class="form-group">
               <label class="control-label col-md-3">Notes</label>
               <div class="col-md-8">
                  <input class="form-control" type="text" name="appointment_notes" value="">
               </div>
            </div>
             
          </div>
      <div class="modal-footer">
        <button class="btn btn-info" name="add_time_form_submit" type="submit"><i class="fa fa-save"></i> Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times-circle"></i> Close</button>
      </div>
      </form>
    </div>

  </div>
</div>







