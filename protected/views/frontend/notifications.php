<?php


$current_tab=$_COOKIE['current_tab'];
if ($current_tab!="activity_alert_notification" && $current_tab!="customer_notification" && $current_tab!="staff_notification" && $current_tab!="customization_notification")
  {$current_tab="customer_notification";}

?>
<?php
if (isset($_POST['update_customer_alert_form_submit']))
{ 
  
 $customer_appointment_alert=serialize($_POST['customer_appointment_alert']);
 $update=$db->update('notification_settings',array('customer_notification'=>$customer_appointment_alert)
  ,array('company_id'=>CURRENT_LOGIN_COMPANY_ID));
 if ($update)
 {
  $display_msg='<div class="alert alert-success text-success">
  <i class="fa fa-smile-o"></i>
  <button class="close" data-dismiss="alert" type="button">
  <i class="fa fa-times-circle-o"></i></button>
  Success! Data Updated.
  </div>';

  echo "<script>
  setTimeout(function(){
   window.location = '".$link->link("notifications",frontend)."'
 },3000);</script>";
}
}
elseif (isset($_POST['update_staff_alert_form_submit']))
{

  $staff_appointment_alert=serialize($_POST['staff_appointment_alert']);
  $update=$db->update('notification_settings',array('staff_notification'=>$staff_appointment_alert)
    ,array('company_id'=>CURRENT_LOGIN_COMPANY_ID));
  if ($update)
  {
    $display_msg='<div class="alert alert-success text-success">
    <i class="fa fa-smile-o"></i>
    <button class="close" data-dismiss="alert" type="button">
    <i class="fa fa-times-circle-o"></i></button>
    Success! Data Updated.
    </div>';

    echo "<script>
    setTimeout(function(){
     window.location = '".$link->link("notifications",frontend)."'
   },3000);</script>";
 }
}
elseif (isset($_POST['update_activity_alert_form_submit']))
{
 
  $activity_alert=serialize($_POST['activity_alert']);
  $update=$db->update('notification_settings',array('activity_notifications'=>$activity_alert)
    ,array('company_id'=>CURRENT_LOGIN_COMPANY_ID));
  if ($update)
  {
    $display_msg='<div class="alert alert-success text-success">
    <i class="fa fa-smile-o"></i>
    <button class="close" data-dismiss="alert" type="button">
    <i class="fa fa-times-circle-o"></i></button>
    Success! Data Updated.
    </div>';
    
    echo "<script>
    setTimeout(function(){
     window.location = '".$link->link("notifications",frontend)."'
   },3000);</script>";
 }
}elseif (isset($_POST['notification_customize_form_submit']))
{
  
  $sender_name=$_POST['sender_name'];
  $email_signature=htmlentities($_POST['email_signature']);
  $update=$db->update('notification_settings',array('sendar_name'=>$sender_name,
    'email_signature'=>$email_signature)
  ,array('company_id'=>CURRENT_LOGIN_COMPANY_ID));
  
  
  if ($update)
  {
    $display_msg='<div class="alert alert-success text-success">
    <i class="fa fa-smile-o"></i>
    <button class="close" data-dismiss="alert" type="button">
    <i class="fa fa-times-circle-o"></i></button>
    Success! Data Updated.
    </div>';
    
    echo "<script>
    setTimeout(function(){
     window.location = '".$link->link("notifications",frontend)."'
   },3000);</script>";
 }
}?>



<div id="page-content">
  <div class="row">
    <div class="col-lg-12">
      <?php echo $display_msg;?>
      <!--Stacked Tabs Left-->
      <!--===================================================-->
      <div class="tab-base tab-stacked-left">
        <!--Nav tabs-->
        <ul class="nav nav-tabs" style="font-size:14px;">
          <li tab="customer_notification"  class="set_cookie <?php if ($current_tab=='customer_notification'){echo 'active';}?>">
            <a data-toggle="tab" href="#demo-stk-lft-tab-1" aria-expanded="false"><i class="fa fa-user-secret"></i> Customer</a>
          </li>
          <li tab="staff_notification"  class="set_cookie <?php if ($current_tab=='staff_notification'){echo 'active';}?>">
            <a data-toggle="tab" href="#demo-stk-lft-tab-2" aria-expanded="false"><i class="fa fa-user"></i> Staff</a>
          </li>
          <li tab="customization_notification"  class="set_cookie <?php if ($current_tab=='customization_notification'){echo 'active';}?>">
            <a data-toggle="tab" href="#demo-stk-lft-tab-3" aria-expanded="true"><i class="fa fa-edit"></i> Customization</a>
          </li>
          <li tab="activity_alert_notification"  class="set_cookie <?php if ($current_tab=='activity_alert_notification'){echo 'active';}?>">
            <a data-toggle="tab" href="#demo-stk-lft-tab-4" aria-expanded="true"><i class="fa fa-bell"></i> Activity Alerts</a>
          </li>
        </ul>
        <!--Tabs Content-->
        <div class="tab-content">
          <?php if ($current_tab=='customer_notification'){?>
            <h4 class="text-thin">Notifications Sent to Customers</h4>
            <form  method="post" class="form-horizontal" action="<?php $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
              <div class="panel-body">
                <div class="row">
                 <div class="col-md-12">Send an Email</div>
                 <div class="col-md-12">
                   <div class="form-group">
                     
                    <label class="col-md-4 control-label"><h4>Appointment</h4></label>
                    
                    <div class="col-md-8">
                     <div class="checkbox12">
                      <label class="form-checkbox form-icon form-text">
                        <input <?php if (is_array($common_data_customer_notification) && in_array('appointment_booked', $common_data_customer_notification)){echo "checked";}?> type="checkbox" name="customer_appointment_alert[]"  value="appointment_booked">Booked</label><br>
                        
                        <label class="form-checkbox form-icon form-text">
                          <input <?php if (is_array($common_data_customer_notification) && in_array('appointment_edited', $common_data_customer_notification)){echo "checked";}?> type="checkbox" name="customer_appointment_alert[]" value="appointment_edited">Edited</label><br>
                          
                          <label class="form-checkbox form-icon form-text">
                            <input <?php if (is_array($common_data_customer_notification) && in_array('appointment_canceled', $common_data_customer_notification)){echo "checked";}?> type="checkbox" name="customer_appointment_alert[]" value="appointment_canceled">Canceled</label><br>
                            
                            
                          </div>
                        </div>
                        
                      </div>
                      <hr>
                      <div class="form-group">
                       
                        <label class="col-md-4 control-label"><h4>Other</h4></label>
                        
                        <div class="col-md-8">
                         <div class="checkbox12">
                          <label class="form-checkbox form-icon form-text">
                            <input <?php if (is_array($common_data_customer_notification) && in_array('show_timezone', $common_data_customer_notification)){echo "checked";}?> type="checkbox" name="customer_appointment_alert[]"  value="show_timezone"> Show timezone in emails.</label><br>
                            
                            <label class="form-checkbox form-icon form-text">
                              <input <?php if (is_array($common_data_customer_notification) && in_array('thankyou_email_for_review', $common_data_customer_notification)){echo "checked";}?> type="checkbox" name="customer_appointment_alert[]" value="thankyou_email_for_review">Send a "thank you" email to customers for submitting a review.</label><br>
                              
                              <label class="form-checkbox form-icon form-text">
                                <input <?php if (is_array($common_data_customer_notification) && in_array('email_appointment_reschedule_link', $common_data_customer_notification)){echo "checked";}?> type="checkbox" name="customer_appointment_alert[]" value="email_appointment_reschedule_link">Send appointment reschedule  link to the customer.</label><br>
                                
                                <label class="form-checkbox form-icon form-text">
                                  <input <?php if (is_array($common_data_customer_notification) && in_array('email_appointment_cancellation_link', $common_data_customer_notification)){echo "checked";}?> type="checkbox" name="customer_appointment_alert[]" value="email_appointment_cancellation_link">Send appointment cancellation link to the customer.</label><br>
                                  
                                  
                                </div>
                              </div>
                              
                            </div>
                        <!--        <hr>
                              <div class="form-group">
					        
                                <label class="col-md-4 control-label"><h4>Appointment Reminders</h4></label>
                                
                                    <div class="col-md-8">
                                    <p>How would you like to notify customers of upcoming appointments?</p>
                                     <div class="checkbox12">
                                            <label class="form-checkbox form-icon form-text">Email
                                            <input <?php if (is_array($common_data_customer_notification) && in_array('show_timezone', $common_data_customer_notification)){echo "checked";}?> type="checkbox" name="customer_appointment_alert[]"  value="show_timezone"> </label><br>
                                            
                                            <label class="form-checkbox form-icon form-text">Text
                                            <input <?php if (is_array($common_data_customer_notification) && in_array('thankyou_email_for_review', $common_data_customer_notification)){echo "checked";}?> type="checkbox" name="customer_appointment_alert[]" value="thankyou_email_for_review"></label><br>
                                       
                                            
                                        </div>
                                    </div>
                               
                                  </div>--> 
                                  
                                </div>
                              </div>
                            </div>
                            <div class="panel-footer text-center">
                             
                             <button class="btn btn-info" name="update_customer_alert_form_submit"   type="submit"><i class='fa fa-save'></i> Submit</button>  
                           </div>
                           
                         </form>
                       <?php }elseif ($current_tab=='staff_notification'){?>
                         
                        <h4 class="text-thin">Notifications Sent to Staff</h4>
                        <form  method="post" class="form-horizontal" action="<?php $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
                          <div class="panel-body">
                            <div class="row">
                             <div class="col-md-12">Send an Email</div>
                             <div class="col-md-12">
                               <div class="form-group">
                                 
                                <label class="col-md-4 control-label"><h4>Appointment</h4></label>
                                
                                <div class="col-md-8">
                                 <div class="checkbox12">
                                  <label class="form-checkbox form-icon form-text">
                                    <input <?php if (is_array($common_data_staff_notification) && in_array('appointment_booked', $common_data_staff_notification)){echo "checked";}?> type="checkbox" name="staff_appointment_alert[]"  value="appointment_booked">Booked</label><br>
                                    
                                    <label class="form-checkbox form-icon form-text">
                                      <input <?php if (is_array($common_data_staff_notification) && in_array('appointment_edited', $common_data_staff_notification)){echo "checked";}?> type="checkbox" name="staff_appointment_alert[]" value="appointment_edited">Edited</label><br>
                                      
                                      <label class="form-checkbox form-icon form-text">
                                        <input <?php if (is_array($common_data_staff_notification) && in_array('appointment_canceled', $common_data_staff_notification)){echo "checked";}?> type="checkbox" name="staff_appointment_alert[]" value="appointment_canceled">Canceled</label><br>
                                        
                                        
                                      </div>
                                    </div>
                                    
                                  </div>
                                  <hr>
                                  <div class="form-group">
                                   
                                    <label class="col-md-4 control-label"><h4>Other</h4></label>
                                    
                                    <div class="col-md-8">
                                     <div class="checkbox12">
                                      <label class="form-checkbox form-icon form-text">
                                        <input <?php if (is_array($common_data_staff_notification) && in_array('show_timezone', $common_data_staff_notification)){echo "checked";}?> type="checkbox" name="staff_appointment_alert[]"  value="show_timezone"> Show timezone in emails.</label><br>
                                        
                                        <label class="form-checkbox form-icon form-text">
                                          <input <?php if (is_array($common_data_staff_notification) && in_array('include_customer_info', $common_data_staff_notification)){echo "checked";}?> type="checkbox" name="staff_appointment_alert[]" value="include_customer_info">Include customer contact information in emails.</label><br>
                                          
                                        </div>
                                      </div>
                                      
                                    </div>
                                    
                                  </div>
                                </div>
                              </div>
                              <div class="panel-footer text-center">
                               
                               <button class="btn btn-info" name="update_staff_alert_form_submit"   type="submit"><i class='fa fa-save'></i> Submit</button>  
                             </div>
                             
                           </form>
                           
                         <?php }elseif ($current_tab=='customization_notification'){?>
                           
                          <h4 class="text-thin">Customize Your Notifications</h4>
                          <form  method="post" class="form-horizontal" action="<?php $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
                            <div class="panel-body">
                              <div class="row">
                               
                               <div class="col-md-12">
                                 <div class="form-group">
                                  <label class="col-md-4 control-label">Sender Name</label>
                                  
                                  <div class="col-md-8">
                                    
                                    <input type="text" name="sender_name" class="form-control" placeholder="Sender Name" value="<?php echo $common_data_sendar_name;?>">
                                    Notification emails sent to customers will have the following sender name:
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-md-4 control-label">Email Signature</label>
                                  <div class="col-md-8">
                                   <textarea name="email_signature" class="form-control" placeholder="Email Signature"><?php echo html_entity_decode($common_data_email_signature);?></textarea>
                                 </div> 
                               </div>
                               
                             </div>
                           </div>
                         </div>
                         <div class="panel-footer text-center">
                           
                           <button class="btn btn-info" name="notification_customize_form_submit"   type="submit"><i class='fa fa-save'></i> Submit</button>  
                         </div>
                         
                       </form>
                       
                     <?php }elseif ($current_tab=='activity_alert_notification'){
                      
                       ?>
                       <h4 class="text-thin">Customize Your Activity Alerts</h4>
                       <hr>
                       <form  method="post" class="form-horizontal" action="<?php $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
                        <div class="panel-body">
                          <div class="row">
                           
                           <div class="col-md-12">
                             <div class="form-group">
                              <label class="col-md-4 control-label"><h3>Alert When</h3></label>
                              
                              <div class="col-md-8">
                               <div class="checkbox12">
                                <label class="form-checkbox form-icon form-text">
                                  <input <?php if (is_array($common_data_activity_alert) && in_array('appointment_created', $common_data_activity_alert)){echo "checked";}?> type="checkbox" name="activity_alert[]"  value="appointment_created">Appointment is created</label><br>
                                  
                                  <label class="form-checkbox form-icon form-text">
                                    <input <?php if (is_array($common_data_activity_alert) && in_array('appointment_updated', $common_data_activity_alert)){echo "checked";}?> type="checkbox" name="activity_alert[]" value="appointment_updated">Appointment is updated</label><br>
                                    
                                    <label class="form-checkbox form-icon form-text">
                                      <input <?php if (is_array($common_data_activity_alert) && in_array('appointment_deleted', $common_data_activity_alert)){echo "checked";}?> type="checkbox" name="activity_alert[]" value="appointment_deleted">Appointment is deleted</label><br>
                                      
                                      <label class="form-checkbox form-icon form-text">
                                        <input <?php if (is_array($common_data_activity_alert) && in_array('customer_created', $common_data_activity_alert)){echo "checked";}?> type="checkbox" name="activity_alert[]" value="customer_created">Customer is created</label><br>
                                        
                                        <label class="form-checkbox form-icon form-text">
                                          <input <?php if (is_array($common_data_activity_alert) && in_array('customer_updated', $common_data_activity_alert)){echo "checked";}?> type="checkbox" name="activity_alert[]" value="customer_updated">Customer is updated</label><br>
                                          
                                          <label class="form-checkbox form-icon form-text">
                                            <input <?php if (is_array($common_data_activity_alert) && in_array('customer_deleted', $common_data_activity_alert)){echo "checked";}?> type="checkbox" name="activity_alert[]" value="customer_deleted">Customer is deleted</label><br>
                                            
                                          </div>
                                        </div>
                                        
                                      </div>
                                      
                                    </div>
                                  </div>
                                </div>
                                <div class="panel-footer text-center">
                                 
                                 <button class="btn btn-info" name="update_activity_alert_form_submit"   type="submit"><i class='fa fa-save'></i> Submit</button>  
                               </div>
                               
                             </form>
                             
                           <?php }?>
                         </div>
                       </div>
                       <!--===================================================-->
                       <!--End Stacked Tabs Left-->
                     </div>
                     
                   </div>
                 </div>