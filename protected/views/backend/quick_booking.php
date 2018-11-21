<?php if (isset($_REQUEST['action_paid']))
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
           window.location = '".$link->link("quick_booking",user)."'
       },3000);</script>";
        }
    }
    elseif(isset($_POST['no']))
    {
        $session->redirect('quick_booking');
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
        $company_id=$appont_details['company_id'];

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
                    <td style="color:rgb(102,102,102);font-size:10px;padding-bottom:30px;text-align:left;font-family:arial">
                    <div style="border-bottom:1px solid #e5e5e5;padding-bottom:5px;margin-bottom:20px">
                    <h1 style="color:#4e5b63;font-size:28px;margin:15px 0px 0px;font-weight:500">Cancelled</h1>
                    <h6 style="color:#4e5b63;font-size:15px;margin:25px 0px 10px;font-weight:500">Hi '.$first_name.' '.$last_name.',</h6>
                    <p style="color:#788a95;font-size:15px;margin:10px 0px 15px">Your appointment has been Cancelled with '.COMPANY_NAME.'</p>
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
                    $headers .= 'From: '.$common_data_sendar_name .'<'.COMPANY_EMAIL . ">\r\n" .
                        'Reply-To: '.COMPANY_EMAIL . "\r\n" .
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
                    $headers .= 'From: '.$common_data_sendar_name .'<'.COMPANY_EMAIL . ">\r\n" .
                        'Reply-To: '.COMPANY_EMAIL . "\r\n" .
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
                           window.location = '".$link->link("quick_booking",user)."'
                       },3000);</script>";
            }else{
                $display_msg= '<div class="alert alert-success text-success">
                    <i class="fa fa-smile-o"></i>
                    <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
                    Appointment Delete Successfully.
                    </div>';
                echo "<script>
                    setTimeout(function(){
                       window.location = '".$link->link("quick_booking",user)."'
                   },3000);</script>";
            }
        }
    }
    elseif(isset($_POST['no']))
    {
        $session->redirect("quick_booking",user);
    }

}?>
<div id="page-content">

    <div class="row">
        <?php echo $display_msg;?>
        <div class="col-md-7">
            <div class="panel">
                <!--Panel heading-->
                <div class="panel-heading ui-sortable-handle">
                    <h3 class="panel-title">

                        <?php
                        // $appointment_count= $db->get_count('appointments',array('company_id'=>CURRENT_LOGIN_COMPANY_ID));
                        $comid=CURRENT_LOGIN_COMPANY_ID;


                        $sql2="SELECT COUNT(*) FROM `appointments` WHERE `company_id`='$comid' and `appointment_date` >= CURDATE()";
                        $appointment_count=$db->run($sql2)->fetchColumn();

                        $sql="SELECT SUM(service_cost) FROM `appointments` WHERE `company_id`= '$comid' and `appointment_date` >= CURDATE()";
                        $appointment_cost=$db->run($sql)->fetchColumn();

                        echo $appointment_count;?> Appointments. <?php echo CURRENCY."".$appointment_cost;?>
                        </h4>
                </div>
                <!--Default panel contents-->
                <div class="panel-body">

                    <div id="demo-chat-body" class="collapse in">
                        <div class="nano has-scrollbar" style="height:380px">
                            <div class="nano-content pad-all" tabindex="0" style="right: -17px;">

                                <table class="table table-hover table-vcenter">
                                    <thead><tr>
                                        <th width="10%">&nbsp;</th>
                                        <th width="45%">&nbsp;</th>
                                        <th width="30%">&nbsp;</th>
                                        <th width="15%">&nbsp;</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $db->order_by='id DESC';

                                    // $appointments=$db->get_all('appointments',array('company_id'=>CURRENT_LOGIN_COMPANY_ID));

                                    $appointments = $db->run("SELECT * FROM `appointments` WHERE `company_id`= '$comid' and `appointment_date` >= CURDATE() ORDER BY id DESC")->fetchAll();

                                    if (is_array($appointments)){
                                        foreach ($appointments as $appoint){

                                            $service_provider_firstname=$db->get_var('users',array('user_id'=>$appoint['staff_id']),'firstname');
                                            $service_provider_lastname=$db->get_var('users',array('user_id'=>$appoint['staff_id']),'lastname');
                                            $service_name=$db->get_var('services',array('id'=>$appoint['service_id']),'service_name');
                                            $appointment_id=$appoint['id'];
                                            $sql="SELECT SUM(payment_amount) FROM `payments` WHERE `appointment_id`='$appointment_id'";
                                            $payment_sum_advance=$db->run($sql)->fetchColumn();
                                            if ($payment_sum_advance==NULL)
                                            {
                                                $payment_sum_advance=0;
                                            }

                                            $customer_name=$appoint['customer_name'];
                                            ?>
                                            <tr>
                                                <td>
                                                    <?php if($appoint['status']=="pending"){?>
                                                        <button data-toggle="modal" data-target="#myModal_edit_appointment" data="<?php echo $appoint['id'];?>" class="edit_modal_edit_customer btn btn-default btn-icon btn-circle icon-lg fa fa-calendar" ></button>
                                                    <?php }else{?>
                                                        <button data-toggle="modal" class=" btn btn-default btn-icon btn-circle icon-lg fa fa-calendar" ></button>
                                                    <?php }?>
                                                    <?php if($appoint['private']=="yes"){?>
                                                        <span class="label label-danger">Private</span>
                                                    <?php }?>
                                                </td>
                                                <td><?php echo date('D d M, Y',strtotime($appoint['appointment_date']));?>(<?php echo date('h:i  A', strtotime($appoint['appointment_time']))."-".date('h:i  A', strtotime($appoint['appointment_end_time']));?>)
                                                    <br><?php echo ucwords($service_provider_firstname." ".$service_provider_lastname);?> . <?php echo ucfirst($service_name);?> . <?php echo $appoint['service_time']+$appoint['service_buffer_time']?> min . <?php echo CURRENCY."".$appoint['service_cost']?>
                                                </td>
                                                <td>
                                                    <?php if($appoint['status'] == 'deleted'): ?>
                                                        <p style="font-size: 12px;"><b>Cancel Reason: </b><?php echo $appoint['cancel_reason']; ?></p>
                                                    <?php endif; ?>

                                                    <?php if($appoint['status'] != VISIT_IN_PRECESS && $appoint['status'] != VISIT_DONE && $appoint['status']!='deleted') { ?>
                                                        <a class="label label-info" href="<?php echo $link->link("home",user,'&action_update='.$appointment_id);?>"><i class="fa fa-edit">Paziente ARRIVATO</i></a>
                                                    <?php }?>
                                                    <?php if($appoint['status']=="pending"){
                                                        if (strtotime($appoint['appointment_date']." ".$appoint['appointment_time']) > strtotime(date('Y-m-d H:i')))
                                                        {?>
                                                            <!-- <a href="#" data-toggle="modal" data-target="#myModal_assign_room" data="<?php echo $appoint['id'];?>" class="assign_room_button label label-warning pull-right"     ><i class="fa fa-check-circle-o"></i>Assign Room</a>    -->
                                                        <?php }else{?><span class="label label-danger">Running late</span><br>
                                                        <?php }
                                                        ?>

                                                    <?php }
                                                    else if ($appoint['status']=="deleted"){ ?>

                                                        <a data-toggle="modal" data-target="#myModal_edit_appointment" data="<?php echo $appoint['id'];?>" class="label label-primary edit_modal_edit_customer" style="margin-top: 10px;margin-bottom: 10px"><i class="fa fa-refresh"> Riprendi Appuntamento</i></a>
                                                        <?php
                                                        if ($appoint['payment_status']=="unpaid"){?>
                                                            <br>
                                                            <a href="#" data-toggle="modal" data-target="#myModal_payment" class="load_payment_details" id="load_payment_details"
                                                               data_id="<?php echo $appoint['id'];?>"
                                                               data_booking_id="<?php echo $appoint['booking_id'];?>"
                                                               data_booking_date="<?php echo date(COMMON_DATE_FORMAT,strtotime($appoint['appointment_date']));?>"
                                                               data_customer="<?php echo ucwords($customer_name);?>"
                                                               data_service_name="<?php echo ucwords($service_name);?>"
                                                               data_payment_sum_advance="<?php echo ucwords($payment_sum_advance);?>"
                                                               data_service_cost="<?php echo $appoint['service_cost']?>"
                                                               data_balance="<?php echo $appoint['balance']?>">(Aggiungi PAGAMENTO</a>



                                                        <?php }else{?>
                                                            <span class="label label-success"><i class="fa fa-check "></i> SALDATO</span>

                                                        <?php }
                                                    }
                                                    else{
                                                        ?>
                                                        <span class="label label-<?php if ($appoint['status']=="pending"){echo"warning";}else{echo "success";} ?> class-<?php echo $appoint['id']; ?>">
                                                <i class="fa fa-tag"></i>
                                                            <?php
                                                            if($appoint['status'] == VISIT_DONE)
                                                                echo "Visita ESEGUITA";
                                                            else
                                                                echo "Visita in CORSO";
                                                            ?>
                                            </span>
                                                        <br>
                                                        <?php if ($appoint['status']=="confirmed"){?>
                                                            <!-- <span class="label label-info">Assigned Room: <?php echo ucwords($db->get_var('rooms',array('id'=>$appoint['assigned_room']),'name'));?></span>
                                                      <a href="#" data-toggle="modal" data-target="#myModal_assign_room" data="<?php echo $appoint['id'];?>" class="assign_room_button  pull-right"   >(Click to Re-assign Room)</a> -->
                                                        <?php }?>


                                                        <?php if ($appoint['payment_status']=="unpaid"){?>

                                                            <a href="#" data-toggle="modal" data-target="#myModal_payment" class="load_payment_details" id="load_payment_details"
                                                               data_id="<?php echo $appoint['id'];?>"
                                                               data_booking_id="<?php echo $appoint['booking_id'];?>"
                                                               data_booking_date="<?php echo date(COMMON_DATE_FORMAT,strtotime($appoint['appointment_date']));?>"
                                                               data_customer="<?php echo ucwords($customer_name);?>"
                                                               data_service_name="<?php echo ucwords($service_name);?>"
                                                               data_payment_sum_advance="<?php echo ucwords($payment_sum_advance);?>"
                                                               data_service_cost="<?php echo $appoint['service_cost']?>"
                                                               data_balance="<?php echo $appoint['balance']?>">(Aggiungi PAGAMENTO</a>



                                                        <?php }else{?>
                                                            <span class="label label-success"><i class="fa fa-check "></i> SALDATO</span>

                                                        <?php }?>
                                                    <?php }?> </td>
                                                <?php if($appoint['status']!='deleted'){ ?>
                                                    <td>
                                                        <a data-toggle="modal" data-target="#myModal_edit_appointment" data="<?php echo $appoint['id'];?>" class="edit_modal_edit_customer" ><i class="fa fa-edit fa-2x text-info"></i></a>
                                                        <a data-toggle="modal" data-target="#myModal_cancel_appointment"  data="<?php echo $appoint['id'];?>" class="cancel_modal_cancel_customer"><i class="fa fa-trash fa-2x text-danger"></i></a>
                                                    </td>
                                                <?php } ?>
                                            </tr>
                                        <?php }}?>
                                    </tbody>
                                </table>
                            </div></div></div>
                </div>
                <!--Table-->

            </div>
        </div>
        <div class="col-md-5">
            <div class="panel">
                <div class="panel-heading">
                    <div class="panel-control">

                    </div>
                    <h3 class="panel-title">Dettagli della Prenotazione</h3>
                </div>
                <!--Horizontal Form-->
                <!--===================================================-->
                <form id="add_appointment_form_quick" method="post" class="form-horizontal" action="" enctype="multipart/form-data">
                    <input type="hidden" name="add_appointment_submit" value="add_appointment_submit">
                    <input type="hidden" name="booking_from" value="<?php echo $query1ans;?>">

                    <div class="panel-body">
                        <div class="row">


                            <div class="col-md-12">
                                <div id="after_post_message_appointment_quick"></div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Paziente<font color="red">*</font></label>
                                    <div class="col-md-8">
                                        <select class="form-control" name="customer_id" id="loadnewcus">
                                            <option value="">---Seleziona--- </option>
                                            <?php
                                            $db->order_by='first_name ASC';
                                            $allcustomers=$db->get_all('customers',array('visibility_status'=>'active','company_id'=>CURRENT_LOGIN_COMPANY_ID));
                                            if (is_array($allcustomers))
                                            {
                                                foreach ($allcustomers as $cus)
                                                {?>
                                                    <option <?php if ($_REQUEST['bookig_for_customer']==$cus['id']){echo "selected='selected'";}?>  value="<?php echo $cus['id']?>"><?php echo $cus['first_name']." ".$cus['last_name'];?></option>
                                                <?php }
                                            }?>

                                        </select>
                                    </div>
                                    <div class="col-md-1"><button type="button" class="btn btn-custom pull-right" data-toggle="modal" data-target="#myModal_add_customer"><i class="fa fa-plus"></i></button></div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Dottore<font color="red">*</font></label>
                                    <div class="col-md-8">
                                        <select class="form-control"name="service_provider" id="load_services_by_provider">
                                            <option value="">---Seleziona--- </option>
                                            <?php
                                            $db->order_by='user_id DESC';
                                            $provider=$db->get_all('users',array('visibility_status'=>'active','user_type'=>'staff','company_id'=>CURRENT_LOGIN_COMPANY_ID));
                                            // $com_id=CURRENT_LOGIN_COMPANY_ID;
                                            //  $provider=$db->run("SELECT* FROM `users` WHERE `visibility_status`='active' AND `company_id`='$com_id' AND `user_type`!='admin'")->fetchAll();
                                            if (is_array($provider))
                                            {
                                                foreach ($provider as $pro)
                                                {?>
                                                    <option  value="<?php echo $pro['user_id']?>"><?php echo $pro['firstname']." ".$pro['lastname'];?></option>
                                                <?php }
                                            }?>

                                        </select>
                                    </div>
                                    <!--    <div class="col-md-1"><button style="margin-top: 8px;"  type="button" class="btn btn-custom pull-right" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i></button></div> -->
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Prestazione<font color="red">*</font></label>
                                    <div class="col-md-8">
                                        <select class="form-control load_services" name="appointment_service" id="load_cost_time_by_service">
                                            <option value=''>---Seleziona---</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group load_costandtime">

                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Data/Ora</label>
                                    <div class="col-md-4">
                                        <input class="form-control datepicker" type="text" name="appointment_date" value="<?php echo date('Y-m-d');?>" id="get_date_calender">

                                    </div>
                                    <div class="col-md-4">
                                        <!--   <input class="form-control" type="time" name="appointment_time" value=""> -->
                                        <select class="form-control" name="appointment_time" id="load_time_slot">

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Note</label>
                                    <div class="col-md-8">
                                        <input class="form-control" type="text" name="appointment_notes" value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">CATEGORIA</label>
                                    <div class="col-md-8">
                                        <select class="form-control" name="private">
                                            <option <?php if ($_POST['private']=="no"){echo "selected";};?> value="no">BLU</option>
                                            <option <?php if ($_POST['private']=="yes"){echo "selected";};?> value="yes">ROSSO</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer text-center">

                        <button class="btn btn-custom" name="add_time_form_submit" type="submit"><i class="fa fa-save"></i> Invia</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

