<?php
$current_login_comopany_id = CURRENT_LOGIN_COMPANY_ID;
$currency = CURRENCY;
$receiptnistAccess = $_SESSION['user_id'] == 121 ? true : false;
$receiptnistAccessArr = array('114', '115');
$mul_doctor_condition = $receiptnistAccess ? " AND FIND_IN_SET(user_id,'" . implode(",", $receiptnistAccessArr) . "')" : "";
$receiptnistTimeSlot = array(array('custom_time_slot' => 5));
?>
<?php

if (isset($_REQUEST['edit']) && $_REQUEST['edit'] == "appointment_date") {
    $db->update('appointments', array('appointment_date' => $_REQUEST['appointment_date']), array('id' => $_REQUEST['id']));
    die("OK");
}

/****************************************************************************************/
/*****************************Add new customer code*************************************/
/**************************************************************************************/
if (isset($_POST['add_customer_submit'])) /*****************add Staff modal box submit****************/ {
    $customer_fname = $_POST['customer_fname'];
    $customer_lname = $_POST['customer_lname'];
    $customer_email = $_POST['customer_email'];
    $customer_mphone = $_POST['customer_mphone'];
    $visibility_status = 'active';
    $created_date = date('Y-m-d');
    $ip_address = $_SERVER['REMOTE_ADDR'];


    if ($fv->emptyfields(array('Customer First Name' => $customer_fname,
    ), NULL)) {

        $return['msg'] = '<div class="alert alert-danger text-danger">
        <i class="fa fa-frown-o text-danger"></i>
        <button class="close" data-dismiss="alert" type="button"><i clasAggiungi appuntamento
s="fa fa-times-circle-o"></i></button>
        Customer first name can not be Blank.
        </div>';
        $return['error'] = true;
        echo json_encode($return);

    } elseif ($fv->check_email($customer_email) != true && $customer_email != "") {
        $return['msg'] = '<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
        Wrong Email Format!.
        </div>';
        $return['error'] = true;
        echo json_encode($return);
    } elseif ($db->exists('customers', array('email' => $customer_email, 'company_id' => $current_login_comopany_id))) {
        $return['msg'] = '<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
        Customer email already exist!.
        </div>';
        $return['error'] = true;
        echo json_encode($return);
    } else {
        $insert = $db->insert('customers', array('company_id' => $current_login_comopany_id,
            'first_name' => $customer_fname,
            'last_name' => $customer_lname,
            'email' => $customer_email,
            'mobile_number' => $customer_mphone,
            'visibility_status' => $visibility_status,
            'created_date' => $created_date,
            'ip_address' => $ip_address));

        $last_cusid = $db->insert_id;
        if ($insert) {

            $return['msg'] = '<div class="alert alert-success text-success">
        <i class="fa fa-smile-o"></i> <button class="close" data-dismiss="alert" type="button">
        <i class="fa fa-times-circle-o"></i></button> Customer Add successfully.
        </div>';
            $return['error'] = false;
            $return['cid'] = $last_cusid;
            $return['cname'] = $customer_fname . ' ' . $customer_lname . '(' . $customer_email . ')';
            echo json_encode($return);


        }
    }
} ?>
<?php
/****************************************************************************************/
/*****************************Add new Staff code*************************************/
/**************************************************************************************/
if (isset($_POST['add_staff_submit'])) {
    $staff_fname = $_POST['staff_fname'];
    $staff_lname = $_POST['staff_lname'];
    $staff_email = $_POST['staff_email'];
    $visibility_status = 'active';
    $created_date = date('Y-m-d');
    $ip_address = $_SERVER['REMOTE_ADDR'];
    /*default working hours of staff company********************/
    $day = $common_data_company_setting['working_day'];
    $on_or_off = $common_data_company_setting['working_on_off'];
    $starttime = $common_data_company_setting['working_start_time'];
    $endtime = $common_data_company_setting['working_end_time'];

    if ($fv->emptyfields(array('Staff First Name' => $staff_fname), NULL)) {

        $return['msg'] = '<div class="alert alert-danger text-danger">
        <i class="fa fa-frown-o text-danger"></i>
        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
        Inserisci il Nome.
        </div>';
        $return['error'] = true;
        echo json_encode($return);

    } elseif (!$fv->check_email($staff_email)) {
        $return['msg'] = '<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
     <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
     Formato email non valido!.
     </div>';
        $return['error'] = true;
        echo json_encode($return);
    } elseif ($db->exists('users', array('email' => $staff_email))) {
        $return['msg'] = '<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
    <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
    Indirizzo email già esistente!.
    </div>';
        $return['error'] = true;
        echo json_encode($return);
    } else {


        $insert = $db->insert('users', array('company_id' => $current_login_comopany_id,
            'firstname' => $staff_fname,
            'lastname' => $staff_lname,
            'email' => $staff_email,
            'user_type' => 'staff',
            'visibility_status' => $visibility_status,
            'create_date' => $created_date,
            'ip_address' => $ip_address,
            'working_day' => $day,
            'working_on_off' => $on_or_off,
            'working_start_time' => $starttime,
            'working_end_time' => $endtime,

        ));

        //  $db->debug();
        if ($insert) {

            $return['msg'] = '<div class="alert alert-success text-success">
      <i class="fa fa-smile-o"></i> <button class="close" data-dismiss="alert" type="button">
      <i class="fa fa-times-circle-o"></i></button> Salvato correttamente.
      </div>';
            $return['error'] = false;
            echo json_encode($return);


        }
    }
} ?>
<?php
/****************************************************************************************/
/*****************************Add Appointment code*************************************/
/**************************************************************************************/
if (isset($_POST['add_appointment_submit'])) {
    $customer_id = $_POST['customer_id'];
    $service_provider = $_POST['service_provider'];
    $appointment_service = $_POST['appointment_service'];
    $appointment_service_cost = $_POST['appointment_service_cost'];
    $appointment_service_time = $_POST['appointment_service_time'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $appointment_notes = $_POST['appointment_notes'];
    $appointment_month = date('m', strtotime($appointment_date));
    $appointment_year = date('Y', strtotime($appointment_date));
    $created_date = date('Y-m-d');
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $booking_from = $_POST['booking_from'];
    $private = $_POST['private'];
    /**********************check staff on leave or not**************************************/
    $t = true;
    $alloff = $db->get_all('timeoff', array('staff_id' => $service_provider, 'company_id' => $current_login_comopany_id));
    if (is_array($alloff)) {
        foreach ($alloff as $altoff) {
            $strDateFrom = $altoff['start_date'];
            $strDateTo = $altoff['end_date'];
            $leave_date_array = $feature->createDateRangeArray($strDateFrom, $strDateTo);
            if (is_array($leave_date_array) && in_array($appointment_date, $leave_date_array)) {
                $t = false;
            }
        }
    }
    /*******************Check Appontment time exist in working  time or not on working day  ************/


    $dayName = date("l", strtotime($appointment_date));
    $working_day = unserialize($db->get_var('users', array('user_id' => $service_provider), 'working_day'));
    $working_on_off = unserialize($db->get_var('users', array('user_id' => $service_provider), 'working_on_off'));
    $working_start_time = unserialize($db->get_var('users', array('user_id' => $service_provider), 'working_start_time'));
    $working_end_time = unserialize($db->get_var('users', array('user_id' => $service_provider), 'working_end_time'));


    if (is_array($working_day)) {
        foreach ($working_day as $key => $value) {
            if (ucfirst($value) == $dayName) {

                $on_off = $working_on_off[$key];
                break;
            }

        }
    }
    /**************************************************************************************************************/
    $appointment_buffer_time = $db->get_var('services', array('id' => $appointment_service), 'service_buffer_time');
    $check_service_duration = $appointment_service_time + $appointment_buffer_time;
    $check_time = $appointment_time;
    $check_service_duration = "+" . $check_service_duration . " minutes";
    $check_time_new = strtotime($check_service_duration, strtotime($check_time));
    $check_time_new = date('H:i:s', $check_time_new);

    $appointment_start_timee = date('H:i:s', strtotime($appointment_time));
    $appointment_end_time = $check_time_new;
    $appointment_date_changed = date('Y-m-d', strtotime($appointment_date));

    $query12 = "SELECT* FROM `appointments`
WHERE `staff_id`='$service_provider'
AND `appointment_date`='$appointment_date_changed'
AND ((`appointment_time` BETWEEN '$appointment_start_timee' AND '$appointment_end_time') OR (`appointment_end_time` >  '$appointment_start_timee' AND `appointment_time` < '$appointment_end_time')) ";


    $fetchall_appointments_of_the_dayl = $db->run($query12)->fetchAll();


    /************************************************************************************************************/
    $check_empty = $fv->emptyfields(array('Select Customer' => $customer_id,
        'Select Service provider' => $service_provider,
        'Select Service' => $appointment_service,
        'Service Cost' => $appointment_service_cost,
        'Service Time' => $appointment_service_time,
        'Appointment Date' => $appointment_date,
        'Appointment Time' => $appointment_time), NULL);


    if ($check_empty) {

        $return['msg'] = '<div class="alert alert-danger text-danger">
    <i class="fa fa-frown-o text-danger"></i>
    <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
    I seguenti campi sono vuoti!<br>' . $check_empty . '<br></div>';
        $return['error'] = true;
        echo json_encode($return);

    } elseif (!$fv->check_numeric($appointment_service_cost)) {
        $return['msg'] = '<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
    <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
    Il costo e\' un campo numerico!.
    </div>';
        $return['error'] = true;
        echo json_encode($return);
    } elseif (!$fv->check_numeric($appointment_service_time)) {
        $return['msg'] = '<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
    <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
    L\'orario e\' un campo numerico!.
    </div>';
        $return['error'] = true;
        echo json_encode($return);
    } elseif ($t == false) {
        $return['msg'] = '<div class="alert alert-danger text-danger">
    <i class="fa fa-frown-o text-danger"></i>
    <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
    Il Dottore e\' in ferie/riposo. Selezionare un altro Dottore o altra data.
    </div>';
        $return['error'] = true;
        echo json_encode($return);
    } elseif ($on_off == "off") {
        $return['msg'] = '<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
    <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
    Il Dottore non c\'e\' in questo giorno!
    </div>';
        $return['error'] = true;
        echo json_encode($return);
    } elseif (strtotime($appointment_date) < strtotime(date('Y-m-d'))) {
        $return['msg'] = '<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
    <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
    L/appuntamento deve essere in una data futura!
    </div>';
        $return['error'] = true;
        echo json_encode($return);
    } elseif (!empty($fetchall_appointments_of_the_dayl)) {
        $return['msg'] = '<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
    <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
    Il Dottore ha già un appuntamento in questo giorno/orario!
    </div>';
        $return['error'] = true;
        echo json_encode($return);
    } else {


        $first_name = $db->get_var('customers', array('id' => $customer_id), 'first_name');
        $last_name = $db->get_var('customers', array('id' => $customer_id), 'last_name');
        $customer_email = $db->get_var('customers', array('id' => $customer_id), 'email');
        $customer_phone = $db->get_var('customers', array('id' => $customer_id), 'mobile_number');

        $insert = $db->insert('appointments', array('company_id' => $current_login_comopany_id,
            'customer_id' => $customer_id,
            'customer_name' => $first_name . " " . $last_name,
            'staff_id' => $service_provider,
            'service_id' => $appointment_service,
            'service_time' => $appointment_service_time,
            'service_cost' => $appointment_service_cost,
            'service_buffer_time' => $appointment_buffer_time,
            'appointment_date' => date('Y-m-d', strtotime($appointment_date)),
            'appointment_time' => date('H:i:s', strtotime($appointment_time)),
            'appointment_end_time' => $check_time_new,
            'notes' => $appointment_notes,
            'booking_id' => time(),
            'appointment_month' => $appointment_month,
            'appointment_year' => $appointment_year,
            'status' => 'pending',
            'assigned_room' => 0,
            'payment_status' => 'unpaid',
            'created_date' => $created_date,
            'ip_address' => $ip_address,
            'booking_from' => $booking_from,
            'private' => $private,
            'balance' => $appointment_service_cost
        ));
        $last_insert_id = $db->insert_id;
        if ($insert) {
            if (isset($_POST['care_id']) && !empty($_POST['care_id'])) {
                $db->update('care_plan', array('appointment_id' => $last_insert_id), array('id' => $_POST['care_id']));
            }
            $service_name = $db->get_var('services', array('id' => $appointment_service), 'service_name');
            $staff_first_name = $db->get_var('users', array('user_id' => $service_provider), 'firstname');
            $staff_last_name = $db->get_var('users', array('user_id' => $service_provider), 'lastname');
            $staff_email = $db->get_var('users', array('user_id' => $service_provider), 'email');

            $event = "<b>Nuovo Appuntamento</b>  " . $first_name . " " . $last_name . " per " . $service_name . "<br>
        il " . date(COMMON_DATE_FORMAT, strtotime($appointment_date)) . " alle " . date('h:i:s a', strtotime($appointment_time)) . " con " . $staff_first_name . " " . $staff_last_name;
            $db->insert('activity_logs', array('user_id' => $_SESSION['user_id'],
                'event_type' => 'appointment_created',
                'event' => $event,
                'company_id' => $current_login_comopany_id,
                'event_type_id' => $last_insert_id,
                'created_date' => date('Y-m-d'),
                'ip_address' => $_SERVER['REMOTE_ADDR']

            ));
            /**************email sent to customer*************************/
            if (is_array($common_data_customer_notification)) {
                if (in_array('appointment_booked', $common_data_customer_notification)) {
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
            <img align="left" alt="' . COMPANY_NAME . '" src="' . COMPANY_LOGO_PATH . '" width="150px"></td> 
            </tr>
            <tr>
            <td style="color:rgb(102,102,102);font-size:10px;padding-bottom:30px;text-align:left;font-family:arial">
            <div style="border-bottom:1px solid #e5e5e5;padding-bottom:5px;margin-bottom:20px">
            <h1 style="color:#4e5b63;font-size:28px;margin:15px 0px 0px;font-weight:500">Thank You</h1>
            <h6 style="color:#4e5b63;font-size:15px;margin:25px 0px 10px;font-weight:500">Hi ' . $first_name . ' ' . $last_name . ',</h6>
            <p style="color:#788a95;font-size:15px;margin:10px 0px 15px">
            Your appointment request has been booked with ' . COMPANY_NAME . ' and current status is pending.<br>
            Please wait for admin approval.  </p>
            </div>
            <div style="border-bottom:1px solid #e5e5e5;margin-bottom:20px;padding-bottom:15px">
            <div style="display:inline-block;width:100%">
            <label style="color:#788a95;font-size:15px">When:&nbsp;</label>
            <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . date("d M Y", strtotime($appointment_date)) . ' ' . date('h:i:s a', strtotime($appointment_time)) . ' ' . $customer_timezone . '</p>
            </div>
            <div style="display:inline-block;width:100%">
            <label style="color:#788a95;font-size:15px">Service:&nbsp;</label>
            <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . $service_name . '</p>
            </div>
            <div style="display:inline-block;width:100%">
            <label style="color:#788a95;font-size:15px">Provider:&nbsp;</label>
            <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . $staff_first_name . ' ' . $staff_last_name . '</p>
            </div>
            </div>
            <div style="border-bottom12:1px solid #e5e5e5;padding-bottom:5px;margin-bottom:20px">
            <p style="color:#788a95;font-size:15px;margin:10px 0px 15px">' . $common_data_email_signature . '</p>
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


                    $headers = 'MIME-Version: 1.0' . "\r\n";
                    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                    $headers .= 'From: ' . $common_data_sendar_name . '<' . COMPANY_EMAIL . ">\r\n" .
                        'Reply-To: ' . COMPANY_EMAIL . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();

                    $subject = "Appuntamento prenotato il " . date(COMMON_DATE_FORMAT, strtotime($appointment_date)) . " " . date('h:i:s a', strtotime($appointment_time)) . " con " . $staff_first_name . " " . $staff_last_name;

                    $confirm = mail($customer_email, $subject, $customer_add_appointment_email_body, $headers);
                }
            }
            /****************************email sent to staff************************************/
            if (is_array($common_data_staff_notification)) {
                if (in_array('appointment_booked', $common_data_staff_notification)) {
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
               <img align="left" alt="' . COMPANY_NAME . '" src="' . COMPANY_LOGO_PATH . '" width="150px"></td> 
               </tr>
               <tr>
               <td style="color:rgb(102,102,102);font-size:10px;padding-bottom:30px;text-align:left;font-family:arial">
               <div style="border-bottom:1px solid #e5e5e5;padding-bottom:5px;margin-bottom:20px">
               <h1 style="color:#4e5b63;font-size:28px;margin:15px 0px 0px;font-weight:500">New Appointment</h1>
               <h6 style="color:#4e5b63;font-size:15px;margin:25px 0px 10px;font-weight:500">Hi ' . $staff_first_name . ' ' . $staff_last_name . ',</h6>
               <p style="color:#788a95;font-size:15px;margin:10px 0px 15px">
               You have an appointment scheduled.<br>and current status is pending.<br>
               Please wait for admin approval.</p>
               </div>
               <div style="border-bottom:1px solid #e5e5e5;margin-bottom:20px;padding-bottom:15px">
               <div style="display:inline-block;width:100%">
               <label style="color:#788a95;font-size:15px">When:&nbsp;</label>
               <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . date("d M Y", strtotime($appointment_date)) . ' ' . date('h:i:s a', strtotime($appointment_time)) . ' ' . $staff_timezone . '</p>
               </div>
               <div style="display:inline-block;width:100%">
               <label style="color:#788a95;font-size:15px">Service:&nbsp;</label>
               <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . $service_name . '</p>
               </div>
               <div style="display:inline-block;width:100%">
               <label style="color:#788a95;font-size:15px">Provider:&nbsp;</label>
               <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . $staff_first_name . ' ' . $staff_last_name . '</p>
               </div>
               
               </div>';
                    if (in_array('include_customer_info', $common_data_staff_notification)) {
                        $staff_add_appointment_email_body .= '
                
                <div style="border-bottom:1px solid #e5e5e5;margin-bottom:20px;padding-bottom:15px">
                <div style="display:inline-block;width:100%">
                <label style="color:#788a95;font-size:15px">customer:&nbsp;</label>
                <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . $first_name . ' ' . $last_name . '</p>
                </div><div style="display:inline-block;width:100%">
                <label style="color:#788a95;font-size:15px">Phone:&nbsp;</label>
                <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . $customer_phone . '</p>
                </div>
                <div style="display:inline-block;width:100%">
                <label style="color:#788a95;font-size:15px">Email:&nbsp;</label>
                <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . $customer_email . '</p>
                </div>
                <div style="display:inline-block;width:100%">
                <label style="color:#788a95;font-size:15px">Booked From :&nbsp;</label>
                <p style="display:inline-block;margin:0;color:#637374;font-size:15px">Customer Page</p>
                </div></div>';
                    }
                    $staff_add_appointment_email_body .= '<div style="border-bottom12:1px solid #e5e5e5;padding-bottom:5px;margin-bottom:20px">
            <p style="color:#788a95;font-size:15px;margin:10px 0px 15px">' . $common_data_email_signature . '</p>
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


                    $headers = 'MIME-Version: 1.0' . "\r\n";
                    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                    $headers .= 'From: ' . $common_data_sendar_name . '<' . COMPANY_EMAIL . ">\r\n" .
                        'Reply-To: ' . COMPANY_EMAIL . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();

                    $subject = "Appuntamento prenotato il " . date(COMMON_DATE_FORMAT, strtotime($appointment_date)) . " " . date('h:i:s a', strtotime($appointment_time)) . " con " . $first_name . " " . $last_name;

                    $confirm = mail($staff_email, $subject, $staff_add_appointment_email_body, $headers);
                }
            }


            if ($confirm == '1') {
                $return['msg'] = '<div class="alert alert-success text-success">
         <i class="fa fa-smile-o"></i> <button class="close" data-dismiss="alert" type="button">
         <i class="fa fa-times-circle-o"></i></button> Appointment Scheduled successfully and mail sent.
         </div>';
                $return['error'] = false;
                echo json_encode($return);
            } else {
                $return['msg'] = '<div class="alert alert-success text-success">
      <i class="fa fa-smile-o"></i> <button class="close" data-dismiss="alert" type="button">
      <i class="fa fa-times-circle-o"></i></button> Appointment Scheduled successfully. 
      </div>';
                $return['error'] = false;
                echo json_encode($return);
            }


        }


    }
} ?>
<?php
/****************************************************************************************/
/*****************************Appointment Edit code*************************************/
/**************************************************************************************/
if (isset($_POST['edit_appointment_submit'])) {
    // print_r($_POST);exit;
    $appointment_id = $_POST['appointment_id'];
    $customer_id = $_POST['customer_id'];
    $service_provider = $_POST['service_provider'];
    $appointment_service = $_POST['appointment_service'];
    $appointment_service_cost = $_POST['appointment_service_cost'];
    $appointment_service_time = $_POST['appointment_service_time'];
    $appointment_date = date('Y-m-d', strtotime($_POST['appointment_date']));
    $appointment_time = $_POST['appointment_time'];
    $appointment_notes = $_POST['appointment_notes'];
    $appointment_private = $_POST['appointment_private'];
    $appointment_month = date('m', strtotime($appointment_date));
    $appointment_year = date('Y', strtotime($appointment_date));
    $created_date = date('Y-m-d');
    $ip_address = $_SERVER['REMOTE_ADDR'];

    /**********************check staff on leave or not**************************************/
    $t = true;
    $alloff = $db->get_all('timeoff', array('staff_id' => $service_provider, 'company_id' => $current_login_comopany_id));
    if (is_array($alloff)) {
        foreach ($alloff as $altoff) {
            $strDateFrom = $altoff['start_date'];
            $strDateTo = $altoff['end_date'];
            $leave_date_array = $feature->createDateRangeArray($strDateFrom, $strDateTo);
            if (is_array($leave_date_array) && in_array($appointment_date, $leave_date_array)) {
                $t = false;
            }
        }
    }
    /*******************Check Appontment time exist in working  time or not on working day  ************/

    $dayName = date("l", strtotime($appointment_date));
    $working_day = unserialize($db->get_var('users', array('user_id' => $service_provider), 'working_day'));
    $working_on_off = unserialize($db->get_var('users', array('user_id' => $service_provider), 'working_on_off'));
    $working_start_time = unserialize($db->get_var('users', array('user_id' => $service_provider), 'working_start_time'));
    $working_end_time = unserialize($db->get_var('users', array('user_id' => $service_provider), 'working_end_time'));


    if (is_array($working_day)) {
        foreach ($working_day as $key => $value) {
            if (ucfirst($value) == $dayName) {

                $on_off = $working_on_off[$key];
                break;
            }

        }
    }


    /************************************************************************************************************/
    $check_empty = $fv->emptyfields(array('Select Customer' => $customer_id,
        'Select Service provider' => $service_provider,
        'Select Service' => $appointment_service,
        'Service Cost' => $appointment_service_cost,
        'Service Time' => $appointment_service_time,
        'Appointment Date' => $appointment_date,
        'Appointment Time' => $appointment_time
    ), NULL);
    if ($check_empty) {

        $return['msg'] = '<div class="alert alert-danger text-danger">
        <i class="fa fa-frown-o text-danger"></i>
        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
        Following Fields Are Empty!<br>' . $check_empty . '</div>';
        $return['error'] = true;
        echo json_encode($return);

    } elseif ($db->get_var('appointments', array('id' => $appointment_id), 'status') == "paid") {
        $return['msg'] = '<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
        Appointment paid and completed already!. So it is not editable.
        </div>';
        $return['error'] = true;
        echo json_encode($return);
    } elseif (!$fv->check_numeric($appointment_service_cost)) {
        $return['msg'] = '<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
        Service Cost Should be Numeric!.
        </div>';
        $return['error'] = true;
        echo json_encode($return);
    } elseif (!$fv->check_numeric($appointment_service_cost)) {
        $return['msg'] = '<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
        Service Time Should be Numeric!.
        </div>';
        $return['error'] = true;
        echo json_encode($return);
    } elseif ($t == false) {
        $return['msg'] = '<div class="alert alert-danger text-danger">
        <i class="fa fa-frown-o text-danger"></i>
        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
        Service provider on leave. Please select other service provider
        </div>';
        $return['error'] = true;
        echo json_encode($return);
    } elseif ($on_off == "off") {
        $return['msg'] = '<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
        Service Provider is on off!
        </div>';
        $return['error'] = true;
        echo json_encode($return);
    } elseif (strtotime($appointment_date . " " . $appointment_time) < strtotime(date('Y-m-d H:i '))) {
        $return['msg'] = '<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
        Appointment date should be greater than today date!
        </div>';
        $return['error'] = true;
        echo json_encode($return);
    } else {

        $appointment_buffer_time = $db->get_var('services', array('id' => $appointment_service), 'service_buffer_time');

        $first_name = $db->get_var('customers', array('id' => $customer_id), 'first_name');
        $last_name = $db->get_var('customers', array('id' => $customer_id), 'last_name');
        $customer_email = $db->get_var('customers', array('id' => $customer_id), 'email');
        $customer_phone = $db->get_var('customers', array('id' => $customer_id), 'mobile_number');


        $check_service_duration = $appointment_service_time + $appointment_buffer_time;
        $check_time = $appointment_time;
        $check_service_duration = "+" . $check_service_duration . " minutes";
        $check_time_new = strtotime($check_service_duration, strtotime($check_time));
        $check_time_new = date('H:i:s', $check_time_new);

        $insert_new = $db->insert('appointments', array('customer_id' => $customer_id,
            'customer_name' => $first_name . " " . $last_name,
            'staff_id' => $service_provider,
            'service_id' => $appointment_service,
            'service_time' => $appointment_service_time,
            'service_cost' => $appointment_service_cost,
            'appointment_date' => date('Y-m-d', strtotime($appointment_date)),
            'appointment_time' => date('H:i:s', strtotime($appointment_time)),
            'appointment_end_time' => $check_time_new,
            'notes' => $appointment_notes,
            'appointment_month' => $appointment_month,
            'appointment_year' => $appointment_year,
            'status' => 'pending',
            'assigned_room' => 0,
            'balance' => $appointment_service_cost,
            'private' => $appointment_private,
            'created_date' => $created_date,
            'ip_address' => $ip_address));
        if ($insert_new) {

            $customer_email = $db->get_var('customers', array('id' => $customer_id), 'email');
            $customer_phone = $db->get_var('customers', array('id' => $customer_id), 'mobile_number');
            $service_name = $db->get_var('services', array('id' => $appointment_service), 'service_name');
            $staff_first_name = $db->get_var('users', array('user_id' => $service_provider), 'firstname');
            $staff_last_name = $db->get_var('users', array('user_id' => $service_provider), 'lastname');
            $staff_email = $db->get_var('users', array('user_id' => $service_provider), 'email');

            $event = "<b>Rescheduled appt.</b>  " . $first_name . " " . $last_name . " for a " . $service_name . "<br>
           on " . date(COMMON_DATE_FORMAT, strtotime($appointment_date)) . "@" . date('h:i:s a', strtotime($appointment_time)) . " w/ " . $staff_first_name . " " . $staff_last_name;
            $db->insert('activity_logs', array('user_id' => $_SESSION['user_id'],
                'event_type' => 'appointment_updated',
                'event' => $event,
                'company_id' => $current_login_comopany_id,
                'event_type_id' => $appointment_id,
                'created_date' => date('Y-m-d'),
                'ip_address' => $_SERVER['REMOTE_ADDR']

            ));
            /********************************Apponitment Rescheduled email to customer*****************/
            if (is_array($common_data_customer_notification)) {
                if (in_array('appointment_edited', $common_data_customer_notification)) {
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
                <img align="left" alt="' . COMPANY_NAME . '" src="' . COMPANY_LOGO_PATH . '" width="150px"></td> 
                </tr>
                <tr>
                <td style="color:rgb(102,102,102);font-size:10px;padding-bottom:30px;text-align:left;font-family:arial">
                <div style="border-bottom:1px solid #e5e5e5;padding-bottom:5px;margin-bottom:20px">
                <h1 style="color:#4e5b63;font-size:28px;margin:15px 0px 0px;font-weight:500">Appointment Rescheduled</h1>
                <h6 style="color:#4e5b63;font-size:15px;margin:25px 0px 10px;font-weight:500">Hi ' . $first_name . ' ' . $last_name . ',</h6>
                <p style="color:#788a95;font-size:15px;margin:10px 0px 15px">Your appointment has been rescheduled with ' . COMPANY_NAME . '</p>
                </div>
                <div style="border-bottom:1px solid #e5e5e5;margin-bottom:20px;padding-bottom:15px">
                <div style="display:inline-block;width:100%">
                <label style="color:#788a95;font-size:15px">When:&nbsp;</label>
                <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . date("d M Y", strtotime($appointment_date)) . ' ' . date('h:i:s a', strtotime($appointment_time)) . ' ' . $customer_timezone . '</p>
                </div>
                <div style="display:inline-block;width:100%">
                <label style="color:#788a95;font-size:15px">Service:&nbsp;</label>
                <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . $service_name . '</p>
                </div>
                <div style="display:inline-block;width:100%">
                <label style="color:#788a95;font-size:15px">Provider:&nbsp;</label>
                <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . $staff_first_name . ' ' . $staff_last_name . '</p>
                </div>
                </div>
                <div style="border-bottom12:1px solid #e5e5e5;padding-bottom:5px;margin-bottom:20px">
                <p style="color:#788a95;font-size:15px;margin:10px 0px 15px">' . $common_data_email_signature . '</p>
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


                    $headers = 'MIME-Version: 1.0' . "\r\n";
                    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                    $headers .= 'From: ' . $common_data_sendar_name . '<' . COMPANY_EMAIL . ">\r\n" .
                        'Reply-To: ' . COMPANY_EMAIL . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();

                    $subject = "Appointment Rescheduled for " . date(COMMON_DATE_FORMAT, strtotime($appointment_date)) . " " . date('h:i:s a', strtotime($appointment_time)) . " with " . $staff_first_name . " " . $staff_last_name;

                    $confirm = mail($customer_email, $subject, $customer_edit_appointment_email_body, $headers);
                }
            }
            /***************************Appointment Rescheduled email to staff*************************/

            if (is_array($common_data_staff_notification)) {
                if (in_array('appointment_edited', $common_data_staff_notification)) {
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
                    <img align="left" alt="' . COMPANY_NAME . '" src="' . COMPANY_LOGO_PATH . '" width="150px"></td> 
                    </tr>
                    <tr>
                    <td style="color:rgb(102,102,102);font-size:10px;padding-bottom:30px;text-align:left;font-family:arial">
                    <div style="border-bottom:1px solid #e5e5e5;padding-bottom:5px;margin-bottom:20px">
                    <h1 style="color:#4e5b63;font-size:28px;margin:15px 0px 0px;font-weight:500">Appointment Rescheduled</h1>
                    <h6 style="color:#4e5b63;font-size:15px;margin:25px 0px 10px;font-weight:500">Hi ' . $staff_first_name . ' ' . $staff_last_name . ',</h6>
                    <p style="color:#788a95;font-size:15px;margin:10px 0px 15px">One of your appointments was rescheduled.</p>
                    </div>
                    <div style="border-bottom:1px solid #e5e5e5;margin-bottom:20px;padding-bottom:15px">
                    <div style="display:inline-block;width:100%">
                    <label style="color:#788a95;font-size:15px">When:&nbsp;</label>
                    <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . date("d M Y", strtotime($appointment_date)) . ' ' . date('h:i:s a', strtotime($appointment_time)) . ' ' . $staff_timezone . '</p>
                    </div>
                    <div style="display:inline-block;width:100%">
                    <label style="color:#788a95;font-size:15px">Service:&nbsp;</label>
                    <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . $service_name . '</p>
                    </div>
                    <div style="display:inline-block;width:100%">
                    <label style="color:#788a95;font-size:15px">Provider:&nbsp;</label>
                    <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . $staff_first_name . ' ' . $staff_last_name . '</p>
                    </div>
                    
                    </div>';
                    if (in_array('include_customer_info', $common_data_staff_notification)) {
                        $staff_edit_appointment_email_body .= '
                        
                        <div style="border-bottom:1px solid #e5e5e5;margin-bottom:20px;padding-bottom:15px">
                        <div style="display:inline-block;width:100%">
                        <label style="color:#788a95;font-size:15px">customer:&nbsp;</label>
                        <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . $first_name . ' ' . $last_name . '</p>
                        </div><div style="display:inline-block;width:100%">
                        <label style="color:#788a95;font-size:15px">Phone:&nbsp;</label>
                        <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . $customer_phone . '</p>
                        </div>
                        <div style="display:inline-block;width:100%">
                        <label style="color:#788a95;font-size:15px">Email:&nbsp;</label>
                        <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . $customer_email . '</p>
                        </div>
                        <div style="display:inline-block;width:100%">
                        <label style="color:#788a95;font-size:15px">Booked From :&nbsp;</label>
                        <p style="display:inline-block;margin:0;color:#637374;font-size:15px">Customer Page</p>
                        </div></div>';
                    }
                    $staff_edit_appointment_email_body .= '<div style="border-bottom122:1px solid #e5e5e5;padding-bottom:5px;margin-bottom:20px">
                    <p style="color:#788a95;font-size:15px;margin:10px 0px 15px">' . $common_data_email_signature . '</p>
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


                    $headers = 'MIME-Version: 1.0' . "\r\n";
                    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                    $headers .= 'From: ' . $common_data_sendar_name . '<' . COMPANY_EMAIL . ">\r\n" .
                        'Reply-To: ' . COMPANY_EMAIL . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();

                    $subject = "Appointment Scheduled for " . date(COMMON_DATE_FORMAT, strtotime($appointment_date)) . " " . date('h:i:s a', strtotime($appointment_time)) . " with " . $first_name . " " . $last_name;

                    $confirm = mail($staff_email, $subject, $staff_edit_appointment_email_body, $headers);
                }
            }
            /******************success message************************************/

            if ($confirm == '1') {
                $return['msg'] = '<div class="alert alert-success text-success">
                 <i class="fa fa-smile-o"></i> <button class="close" data-dismiss="alert" type="button">
                 <i class="fa fa-times-circle-o"></i></button>Appointment Rescheduled successfully mail sent.
                 </div>';
                $return['error'] = false;
                echo json_encode($return);
            } else {
                $return['msg'] = '<div class="alert alert-success text-success">
               <i class="fa fa-smile-o"></i> <button class="close" data-dismiss="alert" type="button">
               <i class="fa fa-times-circle-o"></i></button>Appointment Rescheduled successfully! 
               </div>';
                $return['error'] = false;
                echo json_encode($return);
            }
        }


    }

} ?>
<?php
/****************************************************************************************/
/*****************************load Appointment Edit form to modal box code*************************************/
/**************************************************************************************/
if (isset($_REQUEST['edit_appointment'])) {
    $appointment_detail = $db->get_row('appointments', array('id' => $_REQUEST['edit_appointment']));
    $staff_fname = $db->get_var('users', array('user_id' => $appointment_detail['staff_id']), 'firstname');
    $staff_lname = $db->get_var('users', array('user_id' => $appointment_detail['staff_id']), 'lastname');
    $status = $appointment_detail['status'];
    $payment_status = $appointment_detail['payment_status'];
// strtotime($appointment_detail['appointment_date']." ".$appointment_detail['appointment_time']) < strtotime(date('Y-m-d H:i'))
    if ($status == "confirmed" && $payment_status == "paid") {
        echo "<h4 style='color:red;'>Appointment is Confirmed and Paid  so you can not edit it.</h4>";

    } else {
        ?>


        <link href="<?php echo SITE_URL . '/assets/frontend/plugins/bootstrap-datepicker/bootstrap-datepicker.css'; ?>"
              rel="stylesheet">
        <div class="form-group">
            <label class="control-label col-md-3">Dottore<font color="red">*</font></label>
            <div class="col-md-8">
                <input type="hidden" name="edit_appointment_submit" value="edit_appointment_submit">
                <input type="hidden" name="customer_id" value="<?php echo $appointment_detail['customer_id']; ?>">
                <input type="hidden" name="appointment_id" value="<?php echo $appointment_detail['id']; ?>">
                <select class="form-control" name="service_provider" id="load_services_by_provider_edit">
                    <?php if ($_SESSION['user_type'] == 'staff') { ?>
                        <option value="<?php echo $appointment_detail['staff_id']; ?>"><?php echo $staff_fname . ' ' . $staff_lname; ?></option>
                    <?php } else { ?>
                        <option value="">---Seleziona---</option>
                        <?php
                        //$provider = $db->get_all('users', array('visibility_status' => 'active', 'user_type' => 'staff', 'company_id' => $current_login_comopany_id));
                        // $com_id=CURRENT_LOGIN_COMPANY_ID;
                        $provider = $db->run("SELECT* FROM `users` WHERE `visibility_status`='active' AND `company_id`='$com_id' AND `user_type`='staff' $mul_doctor_condition")->fetchAll();
                        if (is_array($provider)) {
                            foreach ($provider as $pro) {
                                ?>
                                <option <?php if ($appointment_detail['staff_id'] == $pro['user_id']) {
                                    echo "selected";
                                } ?> value="<?php echo $pro['user_id'] ?>"><?php echo $pro['firstname'] . " " . $pro['lastname']; ?></option>
                            <?php }
                        } ?>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">Prestazione</label>
            <div class="col-md-8">
                <select class="form-control load_services_edit" name="appointment_service"
                        id="load_cost_time_by_service_edit">
                    <?php $services = $db->get_all('assign_services', array('company_id' => $current_login_comopany_id, 'staff_id' => $appointment_detail['staff_id']));
                    if (is_array($services)) {
                        foreach ($services as $ser) {
                            ?>
                            <option <?php if ($appointment_detail['service_id'] == $ser['service_id']) {
                                echo "selected";
                            } ?> value="<?php echo $ser['service_id'] ?>"><?php echo $db->get_var('services', array('id' => $ser['service_id']), 'service_name  '); ?></option>
                        <?php }
                    } ?>

                </select>
            </div>
        </div>
        <div class="form-group load_costandtime_edit">
            <label class="control-label col-md-3"></label>
            <div class="col-md-5">
                <div class="input-group mar-btm">
            <span class="input-group-btn">
                <button class="btn btn-default" type="button"><?php echo $currency; ?></button>
            </span>
                    <input class="form-control" type="text" name="appointment_service_cost"
                           value="<?php echo $appointment_detail['service_cost']; ?>" placeholder="cost">
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group mar-btm">
                    <input class="form-control" type="number" name="appointment_service_time"
                           value="<?php echo $appointment_detail['service_time']; ?>" placeholder="Mins">
                    <span class="input-group-btn">
        <button class="btn btn-default" type="button">Min</button>
    </span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">Data/Orario <?php // echo date('H:i',strtotime($appointment_detail['appointment_time']))
                ?></label>
            <div class="col-md-5">
                <input class="form-control datepicker" type="text" name="appointment_date"
                       value="<?php echo date('d-m-Y', strtotime($appointment_detail['appointment_date'])); ?>"
                       id="get_date_calender_edit">
            </div>
            <div class="col-md-3">
                <!-- <input class="form-control" type="time" name="appointment_time" value="<?php echo date('h:i', strtotime($appointment_detail['appointment_time'])); ?>"> -->
                <select class="form-control" name="appointment_time" id="load_time_slot_edit">
                    <?php
                    $service_provider = $appointment_detail['staff_id'];
                    $appointment_date = $appointment_detail['appointment_date'];

                    /*******************Check Appontment time exist in working  time or not on working day  ************/
                    $dayName = date("l", strtotime($appointment_date));
                    $working_day = unserialize($db->get_var('users', array('user_id' => $service_provider), 'working_day'));
                    $working_on_off = unserialize($db->get_var('users', array('user_id' => $service_provider), 'working_on_off'));
                    $working_start_time = unserialize($db->get_var('users', array('user_id' => $service_provider), 'working_start_time'));
                    $working_end_time = unserialize($db->get_var('users', array('user_id' => $service_provider), 'working_end_time'));

                    $company_id = $db->get('users', array('user_id' => $service_provider), 'company_id');
                    if (!empty($receiptnistAccess)) {
                        $time_slots = $receiptnistTimeSlot;
                    } else {
                        $time_slots = $db->get('preferences_settings', array('company_id' => $company_id[0]['company_id']), 'custom_time_slot');
                    }
                    $booked_date = $db->get_all('appointments', array('staff_id' => $service_provider, 'appointment_date' => date('Y-m-d', strtotime($appointment_date))), 'appointment_date,appointment_time,appointment_end_time');

                    foreach ($booked_date as $key => $date) {

                        $booked_slot[] = $feature->create_time_range($date['appointment_time'], $date['appointment_end_time'], $time_slots[0]['custom_time_slot'] . ' min', $format = '24');
                    }

                    $booked_slots = array_reduce($booked_slot, 'array_merge', array());

                    $w = true;
                    if (is_array($working_day)) {
                        foreach ($working_day as $key => $value) {
                            if (ucfirst($value) == $dayName) {

                                $on_off = $working_on_off[$key];
                                $startt = $working_start_time[$key];
                                $endt = $working_end_time[$key];
                                break;
                            }

                        }

                        $times = $feature->create_time_range($startt, $endt, $time_slots[0]['custom_time_slot'] . ' mins', $format = '24');

                        if (is_array($times)) {
                            foreach ($times as $t) {
                                ?>
                                <option <?php if ($appointment_detail['appointment_time'] == date('H:i:s', strtotime($t))) {
                                    echo "selected='selected'";
                                }; ?> value="<?php echo $t; ?>"><?php echo date('h:i A', strtotime($t)); ?></option>
                            <?php }
                        }
                    }


                    ?>


                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">Note</label>
            <div class="col-md-8">
                <input class="form-control" type="text" name="appointment_notes"
                       value="<?php echo $appointment_detail['notes']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">CATEGORIA</label>
            <div class="col-md-8">
                <select class="form-control" id="appointment_private" name="appointment_private">
                    <option <?php if ($appointment_detail['private'] == "no") {
                        echo "selected='selected'";
                    }; ?> value="no">BLU
                    </option>
                    <option <?php if ($appointment_detail['private'] == "yes") {
                        echo "selected='selected'";
                    }; ?> value="yes">ROSSO
                    </option>
                </select>
            </div>
        </div>
        <hr>
        <div class="form-group">
            <label class="control-label col-md-3"></label>
            <div class="col-md-4">
                <button type="button" class="btn btn-default btn-block" data-dismiss="modal"><i
                            class="fa fa-times-circle"></i> Chiudi
                </button>
            </div>
            <div class="col-md-4">
                <button class="btn btn-info btn-block" name="edit_appointment_form_submit" type="submit"><i
                            class="fa fa-save"></i> Invia
                </button>
            </div>

        </div>


        <script src="<?php echo SITE_URL . '/assets/frontend/plugins/bootstrap-datepicker/bootstrap-datepicker.js'; ?>"></script>
        <script>
            $('.datepicker').datepicker({
                format: "dd-mm-yyyy",
                todayBtn: "linked",
                autoclose: true,
                todayHighlight: true,
                startDate: new Date()
            });
        </script>
        <script>

            $('#load_services_by_provider_edit').change(function () {
                var pid = $(this).val();

                $.ajax({
                    type: 'post',
                    url: '<?php echo $link->link('ajax', frontend);?>',
                    data: '&load_service=' + pid,
                    success: function (data) {

                        $(".load_services_edit").html(data);

                    }
                });
            });


            $('#load_cost_time_by_service_edit').change(function () {
                var sid = $(this).val();

                $.ajax({
                    type: 'post',
                    url: '<?php echo $link->link('ajax', frontend);?>',
                    data: '&load_cost_time=' + sid,
                    success: function (data) {

                        $(".load_costandtime_edit").html(data);

                    }
                });
            });


            $('#load_services_by_provider_edit').change(function () {
                var pid = $(this).val();
                var date = $("#get_date_calender_edit").val();
                //alert(pid+"=="+date);
                $.ajax({
                    type: 'post',
                    url: '<?php echo $link->link('ajax', frontend);?>',
                    data: '&load_time_range=' + pid + '&adate=' + date,
                    success: function (data) {
                        $("#load_time_slot_edit").html(data);
                    }
                });
            });

            $('#get_date_calender_edit').change(function () {
                var date = $(this).val();
                var pid = $("#load_services_by_provider_edit").val();
                //alert(pid+"=="+date);
                $.ajax({
                    type: 'post',
                    url: '<?php echo $link->link('ajax', frontend);?>',
                    data: '&load_time_range=' + pid + '&adate=' + date,
                    success: function (data) {
                        $("#load_time_slot_edit").html(data);
                    }
                });
            });
        </script>
    <?php } ?>


<?php } ?>
<?php
/****************************************************************************************/
/*****************************Appointment Edit code*************************************/
/**************************************************************************************/
if (isset($_POST['edit_booking_submit'])) {
    $appointment_id = $_POST['appointment_id'];
    $customer_id = $_POST['customer_id'];
    $service_provider = $_POST['service_provider'];
    $appointment_service = $_POST['appointment_service'];
    $appointment_service_cost = $_POST['appointment_service_cost'];
    $appointment_service_time = $_POST['appointment_service_time'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $appointment_notes = $_POST['appointment_notes'];
    $appointment_month = date('m', strtotime($appointment_date));
    $appointment_year = date('Y', strtotime($appointment_date));
    $created_date = date('Y-m-d');
    $ip_address = $_SERVER['REMOTE_ADDR'];

    /**********************check staff on leave or not**************************************/
    $t = true;
    $alloff = $db->get_all('timeoff', array('staff_id' => $service_provider, 'company_id' => $current_login_comopany_id));
    if (is_array($alloff)) {
        foreach ($alloff as $altoff) {
            $strDateFrom = $altoff['start_date'];
            $strDateTo = $altoff['end_date'];
            $leave_date_array = $feature->createDateRangeArray($strDateFrom, $strDateTo);
            if (is_array($leave_date_array) && in_array($appointment_date, $leave_date_array)) {
                $t = false;
            }
        }
    }
    /*******************Check Appontment time exist in working  time or not on working day  ************/

    $dayName = date("l", strtotime($appointment_date));
    $working_day = unserialize($db->get_var('users', array('user_id' => $service_provider), 'working_day'));
    $working_on_off = unserialize($db->get_var('users', array('user_id' => $service_provider), 'working_on_off'));
    $working_start_time = unserialize($db->get_var('users', array('user_id' => $service_provider), 'working_start_time'));
    $working_end_time = unserialize($db->get_var('users', array('user_id' => $service_provider), 'working_end_time'));


    if (is_array($working_day)) {
        foreach ($working_day as $key => $value) {
            if (ucfirst($value) == $dayName) {

                $on_off = $working_on_off[$key];
                break;
            }

        }
    }


    /************************************************************************************************************/
    $check_empty = $fv->emptyfields(array('Select Customer' => $customer_id,
        'Select Service provider' => $service_provider,
        'Select Service' => $appointment_service,
        'Service Cost' => $appointment_service_cost,
        'Service Time' => $appointment_service_time,
        'Appointment Date' => $appointment_date,
        'Appointment Time' => $appointment_time
    ), NULL);
    if ($check_empty) {

        $return['msg'] = '<div class="alert alert-danger text-danger">
        <i class="fa fa-frown-o text-danger"></i>
        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
        I seguenti campi sono vuoti!<br>' . $check_empty . '</div>';
        $return['error'] = true;
        echo json_encode($return);

    } elseif ($db->get_var('appointments', array('id' => $appointment_id), 'status') == "paid") {
        $return['msg'] = '<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
        Appuntamento pagato e già completato!. Non è modificabile.
        </div>';
        $return['error'] = true;
        echo json_encode($return);
    } elseif (!$fv->check_numeric($appointment_service_cost)) {
        $return['msg'] = '<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
        Il costo e\' un campo numerico!.
        </div>';
        $return['error'] = true;
        echo json_encode($return);
    } elseif (!$fv->check_numeric($appointment_service_cost)) {
        $return['msg'] = '<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
        L\' orario e\' un campo numerico!.
        </div>';
        $return['error'] = true;
        echo json_encode($return);
    } elseif ($t == false) {
        $return['msg'] = '<div class="alert alert-danger text-danger">
        <i class="fa fa-frown-o text-danger"></i>
        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
        Il Dottore e\' in ferie/riposo. Selezionare un altro Dottore o altra data.
        </div>';
        $return['error'] = true;
        echo json_encode($return);
    } elseif ($on_off == "off") {
        $return['msg'] = '<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
        Il Dottore non c\'e\' in questo giorno!
        </div>';
        $return['error'] = true;
        echo json_encode($return);
    } elseif (strtotime($appointment_date . " " . $appointment_time) < strtotime(date('Y-m-d H:i '))) {
        $return['msg'] = '<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
        L/appuntamento deve essere in una data futura!
        </div>';
        $return['error'] = true;
        echo json_encode($return);
    } else {

        $appointment_buffer_time = $db->get_var('services', array('id' => $appointment_service), 'service_buffer_time');

        $first_name = $db->get_var('customers', array('id' => $customer_id), 'first_name');
        $last_name = $db->get_var('customers', array('id' => $customer_id), 'last_name');
        $customer_email = $db->get_var('customers', array('id' => $customer_id), 'email');
        $customer_phone = $db->get_var('customers', array('id' => $customer_id), 'mobile_number');


        $check_service_duration = $appointment_service_time + $appointment_buffer_time;
        $check_time = $appointment_time;
        $check_service_duration = "+" . $check_service_duration . " minutes";
        $check_time_new = strtotime($check_service_duration, strtotime($check_time));
        $check_time_new = date('H:i:s', $check_time_new);

        $update = $db->update('appointments', array('customer_id' => $customer_id,
            'customer_name' => $first_name . " " . $last_name,
            'staff_id' => $service_provider,
            'service_id' => $appointment_service,
            'service_time' => $appointment_service_time,
            'service_cost' => $appointment_service_cost,
            'appointment_date' => $appointment_date,
            'appointment_time' => date('H:i:s', strtotime($appointment_time)),
            'appointment_end_time' => $check_time_new,
            'notes' => $appointment_notes,
            'appointment_month' => $appointment_month,
            'appointment_year' => $appointment_year,
            'status' => 'pending',
            'assigned_room' => 0,
            'balance' => $appointment_service_cost,
            'created_date' => $created_date,
            'ip_address' => $ip_address), array('id' => $appointment_id));
        if ($update) {

            $customer_email = $db->get_var('customers', array('id' => $customer_id), 'email');
            $customer_phone = $db->get_var('customers', array('id' => $customer_id), 'mobile_number');
            $service_name = $db->get_var('services', array('id' => $appointment_service), 'service_name');
            $staff_first_name = $db->get_var('users', array('user_id' => $service_provider), 'firstname');
            $staff_last_name = $db->get_var('users', array('user_id' => $service_provider), 'lastname');
            $staff_email = $db->get_var('users', array('user_id' => $service_provider), 'email');

            $event = "<b>Appuntamento riprogrammato.</b>  " . $first_name . " " . $last_name . " per " . $service_name . "<br>
           il " . date(COMMON_DATE_FORMAT, strtotime($appointment_date)) . "@" . date('h:i:s a', strtotime($appointment_time)) . " con " . $staff_first_name . " " . $staff_last_name;
            $db->insert('activity_logs', array('user_id' => $_SESSION['user_id'],
                'event_type' => 'appointment_updated',
                'event' => $event,
                'company_id' => $current_login_comopany_id,
                'event_type_id' => $appointment_id,
                'created_date' => date('Y-m-d'),
                'ip_address' => $_SERVER['REMOTE_ADDR']

            ));
            /********************************Apponitment Rescheduled email to customer*****************/
            if (is_array($common_data_customer_notification)) {
                if (in_array('appointment_edited', $common_data_customer_notification)) {
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
                <img align="left" alt="' . COMPANY_NAME . '" src="' . COMPANY_LOGO_PATH . '" width="150px"></td> 
                </tr>
                <tr>
                <td style="color:rgb(102,102,102);font-size:10px;padding-bottom:30px;text-align:left;font-family:arial">
                <div style="border-bottom:1px solid #e5e5e5;padding-bottom:5px;margin-bottom:20px">
                <h1 style="color:#4e5b63;font-size:28px;margin:15px 0px 0px;font-weight:500">Appointment Rescheduled</h1>
                <h6 style="color:#4e5b63;font-size:15px;margin:25px 0px 10px;font-weight:500">Hi ' . $first_name . ' ' . $last_name . ',</h6>
                <p style="color:#788a95;font-size:15px;margin:10px 0px 15px">Your appointment has been rescheduled with ' . COMPANY_NAME . '</p>
                </div>
                <div style="border-bottom:1px solid #e5e5e5;margin-bottom:20px;padding-bottom:15px">
                <div style="display:inline-block;width:100%">
                <label style="color:#788a95;font-size:15px">When:&nbsp;</label>
                <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . date("d M Y", strtotime($appointment_date)) . ' ' . date('h:i:s a', strtotime($appointment_time)) . ' ' . $customer_timezone . '</p>
                </div>
                <div style="display:inline-block;width:100%">
                <label style="color:#788a95;font-size:15px">Service:&nbsp;</label>
                <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . $service_name . '</p>
                </div>
                <div style="display:inline-block;width:100%">
                <label style="color:#788a95;font-size:15px">Provider:&nbsp;</label>
                <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . $staff_first_name . ' ' . $staff_last_name . '</p>
                </div>
                </div>
                <div style="border-bottom12:1px solid #e5e5e5;padding-bottom:5px;margin-bottom:20px">
                <p style="color:#788a95;font-size:15px;margin:10px 0px 15px">' . $common_data_email_signature . '</p>
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


                    $headers = 'MIME-Version: 1.0' . "\r\n";
                    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                    $headers .= 'From: ' . $common_data_sendar_name . '<' . COMPANY_EMAIL . ">\r\n" .
                        'Reply-To: ' . COMPANY_EMAIL . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();

                    $subject = "Appointment Rescheduled for " . date(COMMON_DATE_FORMAT, strtotime($appointment_date)) . " " . date('h:i:s a', strtotime($appointment_time)) . " with " . $staff_first_name . " " . $staff_last_name;

                    $confirm = mail($customer_email, $subject, $customer_edit_appointment_email_body, $headers);
                }
            }
            /***************************Appointment Rescheduled email to staff*************************/

            if (is_array($common_data_staff_notification)) {
                if (in_array('appointment_edited', $common_data_staff_notification)) {
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
                    <img align="left" alt="' . COMPANY_NAME . '" src="' . COMPANY_LOGO_PATH . '" width="150px"></td> 
                    </tr>
                    <tr>
                    <td style="color:rgb(102,102,102);font-size:10px;padding-bottom:30px;text-align:left;font-family:arial">
                    <div style="border-bottom:1px solid #e5e5e5;padding-bottom:5px;margin-bottom:20px">
                    <h1 style="color:#4e5b63;font-size:28px;margin:15px 0px 0px;font-weight:500">Appointment Rescheduled</h1>
                    <h6 style="color:#4e5b63;font-size:15px;margin:25px 0px 10px;font-weight:500">Hi ' . $staff_first_name . ' ' . $staff_last_name . ',</h6>
                    <p style="color:#788a95;font-size:15px;margin:10px 0px 15px">One of your appointments was rescheduled.</p>
                    </div>
                    <div style="border-bottom:1px solid #e5e5e5;margin-bottom:20px;padding-bottom:15px">
                    <div style="display:inline-block;width:100%">
                    <label style="color:#788a95;font-size:15px">When:&nbsp;</label>
                    <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . date("d M Y", strtotime($appointment_date)) . ' ' . date('h:i:s a', strtotime($appointment_time)) . ' ' . $staff_timezone . '</p>
                    </div>
                    <div style="display:inline-block;width:100%">
                    <label style="color:#788a95;font-size:15px">Service:&nbsp;</label>
                    <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . $service_name . '</p>
                    </div>
                    <div style="display:inline-block;width:100%">
                    <label style="color:#788a95;font-size:15px">Provider:&nbsp;</label>
                    <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . $staff_first_name . ' ' . $staff_last_name . '</p>
                    </div>
                    
                    </div>';
                    if (in_array('include_customer_info', $common_data_staff_notification)) {
                        $staff_edit_appointment_email_body .= '
                        
                        <div style="border-bottom:1px solid #e5e5e5;margin-bottom:20px;padding-bottom:15px">
                        <div style="display:inline-block;width:100%">
                        <label style="color:#788a95;font-size:15px">customer:&nbsp;</label>
                        <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . $first_name . ' ' . $last_name . '</p>
                        </div><div style="display:inline-block;width:100%">
                        <label style="color:#788a95;font-size:15px">Phone:&nbsp;</label>
                        <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . $customer_phone . '</p>
                        </div>
                        <div style="display:inline-block;width:100%">
                        <label style="color:#788a95;font-size:15px">Email:&nbsp;</label>
                        <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . $customer_email . '</p>
                        </div>
                        <div style="display:inline-block;width:100%">
                        <label style="color:#788a95;font-size:15px">Booked From :&nbsp;</label>
                        <p style="display:inline-block;margin:0;color:#637374;font-size:15px">Customer Page</p>
                        </div></div>';
                    }
                    $staff_edit_appointment_email_body .= '<div style="border-bottom122:1px solid #e5e5e5;padding-bottom:5px;margin-bottom:20px">
                    <p style="color:#788a95;font-size:15px;margin:10px 0px 15px">' . $common_data_email_signature . '</p>
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


                    $headers = 'MIME-Version: 1.0' . "\r\n";
                    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                    $headers .= 'From: ' . $common_data_sendar_name . '<' . COMPANY_EMAIL . ">\r\n" .
                        'Reply-To: ' . COMPANY_EMAIL . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();

                    $subject = "Appointment Scheduled for " . date(COMMON_DATE_FORMAT, strtotime($appointment_date)) . " " . date('h:i:s a', strtotime($appointment_time)) . " with " . $first_name . " " . $last_name;

                    $confirm = mail($staff_email, $subject, $staff_edit_appointment_email_body, $headers);
                }
            }
            /******************success message************************************/

            if ($confirm == '1') {
                $return['msg'] = '<div class="alert alert-success text-success">
                 <i class="fa fa-smile-o"></i> <button class="close" data-dismiss="alert" type="button">
                 <i class="fa fa-times-circle-o"></i></button>Appointment Rescheduled successfully mail sent.
                 </div>';
                $return['error'] = false;
                echo json_encode($return);
            } else {
                $return['msg'] = '<div class="alert alert-success text-success">
               <i class="fa fa-smile-o"></i> <button class="close" data-dismiss="alert" type="button">
               <i class="fa fa-times-circle-o"></i></button>Appointment Rescheduled successfully! 
               </div>';
                $return['error'] = false;
                echo json_encode($return);
            }
        }


    }

} ?>
<?php
/****************************************************************************************/
/*****************************load Booking Edit form fromcare plan*************************************/
/**************************************************************************************/
if (isset($_REQUEST['edit_booking'])) {
    $appointment_detail = $db->get_row('appointments', array('id' => $_REQUEST['edit_booking']));
    $staff_fname = $db->get_var('users', array('user_id' => $appointment_detail['staff_id']), 'firstname');
    $staff_lname = $db->get_var('users', array('user_id' => $appointment_detail['staff_id']), 'lastname');
    $status = $appointment_detail['status'];
    $payment_status = $appointment_detail['payment_status'];
// strtotime($appointment_detail['appointment_date']." ".$appointment_detail['appointment_time']) < strtotime(date('Y-m-d H:i'))
    if ($status == "confirmed" && $payment_status == "paid") {
        echo "<h4 style='color:red;'>Appointment is Confirmed and Paid  so you can not edit it.</h4>";

    } else {
        ?>


        <link href="<?php echo SITE_URL . '/assets/frontend/plugins/bootstrap-datepicker/bootstrap-datepicker.css'; ?>"
              rel="stylesheet">
        <div class="form-group">
            <label class="control-label col-md-3">Dottore<font color="red">*</font></label>
            <div class="col-md-8">
                <input type="hidden" name="edit_booking_submit" value="edit_booking_submit">
                <input type="hidden" name="customer_id" value="<?php echo $appointment_detail['customer_id']; ?>">
                <input type="hidden" name="appointment_id" value="<?php echo $appointment_detail['id']; ?>">
                <select class="form-control" name="service_provider" id="load_services_by_provider_edit">
                    <?php if ($_SESSION['user_type'] == 'staff') { ?>
                        <option value="<?php echo $appointment_detail['staff_id']; ?>"><?php echo $staff_fname . ' ' . $staff_lname; ?></option>
                    <?php } else { ?>
                        <option value="">---Seleziona---</option>
                        <?php
                        $provider = $db->get_all('users', array('visibility_status' => 'active', 'user_type' => 'staff', 'company_id' => $current_login_comopany_id));
                        // $com_id=CURRENT_LOGIN_COMPANY_ID;
                        // $provider=$db->run("SELECT* FROM `users` WHERE `visibility_status`='active' AND `company_id`='$com_id' AND `user_type`!='admin'")->fetchAll();

                        if (is_array($provider)) {
                            foreach ($provider as $pro) {
                                ?>
                                <option <?php if ($appointment_detail['staff_id'] == $pro['user_id']) {
                                    echo "selected";
                                } ?> value="<?php echo $pro['user_id'] ?>"><?php echo $pro['firstname'] . " " . $pro['lastname']; ?></option>
                            <?php }
                        } ?>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">Prestazione</label>
            <div class="col-md-8">
                <select class="form-control load_services_edit" name="appointment_service"
                        id="load_cost_time_by_service_edit">
                    <?php $services = $db->get_all('assign_services', array('company_id' => $current_login_comopany_id, 'staff_id' => $appointment_detail['staff_id']));
                    if (is_array($services)) {
                        foreach ($services as $ser) {
                            ?>
                            <option <?php if ($appointment_detail['service_id'] == $ser['service_id']) {
                                echo "selected";
                            } ?> value="<?php echo $ser['service_id'] ?>"><?php echo $db->get_var('services', array('id' => $ser['service_id']), 'service_name  '); ?></option>
                        <?php }
                    } ?>

                </select>
            </div>
        </div>
        <div class="form-group load_costandtime_edit">
            <label class="control-label col-md-3"></label>
            <div class="col-md-5">
                <div class="input-group mar-btm">
            <span class="input-group-btn">
                <button class="btn btn-default" type="button"><?php echo $currency; ?></button>
            </span>
                    <input class="form-control" type="text" name="appointment_service_cost"
                           value="<?php echo $appointment_detail['service_cost']; ?>" placeholder="cost">
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group mar-btm">
                    <input class="form-control" type="number" name="appointment_service_time"
                           value="<?php echo $appointment_detail['service_time']; ?>" placeholder="Mins">
                    <span class="input-group-btn">
        <button class="btn btn-default" type="button">min</button>
    </span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">Giorno/Ora <?php // echo date('H:i',strtotime($appointment_detail['appointment_time']))
                ?></label>
            <div class="col-md-5">
                <input class="form-control datepicker" type="text" name="appointment_date"
                       value="<?php echo $appointment_detail['appointment_date']; ?>" id="get_date_calender_edit">
            </div>
            <div class="col-md-3">
                <!-- <input class="form-control" type="time" name="appointment_time" value="<?php echo date('h:i', strtotime($appointment_detail['appointment_time'])); ?>"> -->
                <select class="form-control" name="appointment_time" id="load_time_slot_edit">
                    <?php
                    $service_provider = $appointment_detail['staff_id'];
                    $appointment_date = $appointment_detail['appointment_date'];

                    /*******************Check Appontment time exist in working  time or not on working day  ************/
                    $dayName = date("l", strtotime($appointment_date));
                    $working_day = unserialize($db->get_var('users', array('user_id' => $service_provider), 'working_day'));
                    $working_on_off = unserialize($db->get_var('users', array('user_id' => $service_provider), 'working_on_off'));
                    $working_start_time = unserialize($db->get_var('users', array('user_id' => $service_provider), 'working_start_time'));
                    $working_end_time = unserialize($db->get_var('users', array('user_id' => $service_provider), 'working_end_time'));

                    $w = true;
                    if (is_array($working_day)) {
                        foreach ($working_day as $key => $value) {
                            if (ucfirst($value) == $dayName) {

                                $on_off = $working_on_off[$key];
                                $startt = $working_start_time[$key];
                                $endt = $working_end_time[$key];
                                break;
                            }

                        }

                        $times = $feature->create_time_range($startt, $endt, '30 mins', $format = '24');
                        if (is_array($times)) {
                            foreach ($times as $t) {
                                ?>
                                <option <?php if ($appointment_detail['appointment_time'] == date('H:i:s', strtotime($t))) {
                                    echo "selected='selected'";
                                }; ?> value="<?php echo $t; ?>"><?php echo date('h:i A', strtotime($t)); ?></option>
                            <?php }
                        }
                    }


                    ?>


                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">Note</label>
            <div class="col-md-8">
                <input class="form-control" type="text" name="appointment_notes"
                       value="<?php echo $appointment_detail['notes']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">CATEGORIA</label>
            <div class="col-md-8">
                <select class="form-control" name="private">
                    <option value="no">BLU</option>
                    <option value="yes">ROSSO</option>

                </select>
            </div>
        </div>
        <hr>
        <div class="form-group">
            <label class="control-label col-md-3"></label>
            <div class="col-md-4">
                <button type="button" class="btn btn-default btn-block" data-dismiss="modal"><i
                            class="fa fa-times-circle"></i> Chiudi
                </button>
            </div>
            <div class="col-md-4">
                <button class="btn btn-info btn-block" name="edit_booking_form_submit" type="submit"><i
                            class="fa fa-save"></i> Invia
                </button>
            </div>

        </div>


        <script src="<?php echo SITE_URL . '/assets/frontend/plugins/bootstrap-datepicker/bootstrap-datepicker.js'; ?>"></script>
        <script>
            $('.datepicker').datepicker({
                format: "yyyy-mm-dd",
                todayBtn: "linked",
                autoclose: true,
                todayHighlight: true,
                startDate: new Date()
            });
        </script>
        <script>

            $('#load_services_by_provider_edit').change(function () {
                var pid = $(this).val();

                $.ajax({
                    type: 'post',
                    url: '<?php echo $link->link('ajax', frontend);?>',
                    data: '&load_service=' + pid,
                    success: function (data) {

                        $(".load_services_edit").html(data);

                    }
                });
            });


            $('#load_cost_time_by_service_edit').change(function () {
                var sid = $(this).val();

                $.ajax({
                    type: 'post',
                    url: '<?php echo $link->link('ajax', frontend);?>',
                    data: '&load_cost_time=' + sid,
                    success: function (data) {

                        $(".load_costandtime_edit").html(data);

                    }
                });
            });


            $('#load_services_by_provider_edit').change(function () {
                var pid = $(this).val();
                var date = $("#get_date_calender_edit").val();
                //alert(pid+"=="+date);
                $.ajax({
                    type: 'post',
                    url: '<?php echo $link->link('ajax', frontend);?>',
                    data: '&load_time_range=' + pid + '&adate=' + date,
                    success: function (data) {
                        $("#load_time_slot_edit").html(data);
                    }
                });
            });

            $('#get_date_calender_edit').change(function () {
                var date = $(this).val();
                var pid = $("#load_services_by_provider_edit").val();
                //alert(pid+"=="+date);
                $.ajax({
                    type: 'post',
                    url: '<?php echo $link->link('ajax', frontend);?>',
                    data: '&load_time_range=' + pid + '&adate=' + date,
                    success: function (data) {
                        $("#load_time_slot_edit").html(data);
                    }
                });
            });
        </script>
    <?php } ?>


<?php } ?>
<?php
/****************************************************************************************/
/*****************************Update Memo*************************************/
/**************************************************************************************/

if (isset($_POST['update_memo_submit'])) {
    $memo_id = $_POST['memo_id'];
    $update = $db->update('memo_notice', array('date' => $_POST['date'], 'notification' => $_POST['memo_notification'], 'created_date' => $_POST['date'], 'ip_address' => $_SERVER['REMOTE_ADDR']), array('id' => $memo_id));

    $return['msg'] = '<div class="alert alert-success text-success">
    <i class="fa fa-smile-o"></i> <button class="close" data-dismiss="alert" type="button">
    <i class="fa fa-times-circle-o"></i></button> Memo updated successfully.
    </div>';
    $return['error'] = false;
    echo json_encode($return);

}
?>
<?php
/****************************************************************************************/
/*****************************load Memo Edit form to modal box code*************************************/
/**************************************************************************************/
if (isset($_REQUEST['edit_memo'])) {
    $memo_detail = $db->get_row('memo_notice', array('id' => $_REQUEST['edit_memo']));
    ?>
    <div class="form-group">
        <label class="control-label col-md-3">data</label>
        <div class="col-md-8">
            <input type="hidden" name="update_memo_submit" value="update_memo_submit">
            <input type="hidden" name="memo_id" value="<?php echo $memo_detail['id']; ?>">
            <input type="date" name="date" value="<?php echo $memo_detail['date']; ?>"/>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3">Descrizione</label>
        <div class="col-md-8">
            <textarea class="form-control"
                      name="memo_notification"><?php echo $memo_detail['notification']; ?></textarea>
        </div>
    </div>
    <hr>
    <div class="form-group">
        <label class="control-label col-md-3"></label>
        <div class="col-md-4">
            <button type="button" class="btn btn-default btn-block" data-dismiss="modal"><i
                        class="fa fa-times-circle"></i> Chiudi
            </button>
        </div>
        <div class="col-md-4">
            <button class="btn btn-info btn-block" name="edit_memo_form_submit" type="submit"><i class="fa fa-save"></i>
                Invia
            </button>
        </div>

    </div>


<?php } ?>

<?php
/****************************************************************************************/
/*****************************Appointment cancel code*************************************/
/**************************************************************************************/
if (isset($_POST['cancel_appointment_submit'])) {
    $appointment_id = $_POST['appointment_id'];
    $customer_id = $_POST['customer_id'];

    $ip_address = $_SERVER['REMOTE_ADDR'];
    $ip_address = $_SERVER['REMOTE_ADDR'];
    if ($_POST['cancel_reason'] == 'cancellation, calling off, by the patient') {

        $cancel_reason = $_POST['reason_cancel_field'];
    } else {
        $cancel_reason = $_POST['cancel_reason'];
    }

    /************************************************************************************************************/
    $check_empty = $fv->emptyfields(array('Select Customer' => $customer_id,
        'Select Reason to cancel appointment' => $cancel_reason
    ), NULL);
    if ($check_empty) {

        $return['msg'] = '<div class="alert alert-danger text-danger">
        <i class="fa fa-frown-o text-danger"></i>
        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
        Following Fields Are Empty!<br>' . $check_empty . '</div>';
        $return['error'] = true;
        echo json_encode($return);

    } else {


        $appont_details = $db->get_row('appointments', array('id' => $appointment_id));

        $first_name = $db->get_var('customers', array('id' => $appont_details['customer_id']), 'first_name');
        $last_name = $db->get_var('customers', array('id' => $appont_details['customer_id']), 'last_name');
        $customer_email = $db->get_var('customers', array('id' => $appont_details['customer_id']), 'email');
        $customer_phone = $db->get_var('customers', array('id' => $appont_details['customer_id']), 'mobile_number');
        $service_name = $db->get_var('services', array('id' => $appont_details['service_id']), 'service_name');
        $staff_first_name = $db->get_var('users', array('user_id' => $appont_details['staff_id']), 'firstname');
        $staff_last_name = $db->get_var('users', array('user_id' => $appont_details['staff_id']), 'lastname');
        $staff_email = $db->get_var('users', array('user_id' => $appont_details['staff_id']), 'email');
        $appointment_date = $appont_details['appointment_date'];
        $appointment_time = $appont_details['appointment_time'];
        $appointment_company_id = $appont_details['company_id'];

        $event = "<b>Canceled appt.</b>  " . $first_name . " " . $last_name . " for a " . $service_name . " And Reason for cancellation is: " . $cancel_reason . " <br>
        on " . date(COMMON_DATE_FORMAT, strtotime($appointment_date)) . "@" . date('h:i:s a', strtotime($appointment_time)) . " w/ " . $staff_first_name . " " . $staff_last_name;

        $db->insert('activity_logs', array('user_id' => $_SESSION['user_id'],
            'event_type' => 'appointment_deleted',
            'event' => $event,
            'company_id' => $appointment_company_id,
            'event_type_id' => $appointment_id,
            'created_date' => date('Y-m-d'),
            'ip_address' => $ip_address

        ));

        if ($cancel_reason == "by mistake and therefore permanent cancellation") {
            $delete = $db->delete('appointments', array('id' => $appointment_id));

        } else {
            $delete = $db->update('appointments', array('status' => 'deleted', 'cancel_reason' => $cancel_reason), array('id' => $appointment_id));
        }


        if ($delete) {
            if (is_array($common_data_customer_notification)) {
                if (in_array('appointment_canceled', $common_data_customer_notification)) {
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
                <img align="left" alt="' . COMPANY_NAME . '" src="' . COMPANY_LOGO_PATH . '" width="150px"></td> 
                </tr>
                <tr>
                <td style="color:rgb(102,102,102);font-size:10px;padding-bottom:30px;text-align:left;font-family:arial">
                <div style="border-bottom:1px solid #e5e5e5;padding-bottom:5px;margin-bottom:20px">
                <h1 style="color:#4e5b63;font-size:28px;margin:15px 0px 0px;font-weight:500">Cancelled</h1>
                <h6 style="color:#4e5b63;font-size:15px;margin:25px 0px 10px;font-weight:500">Hi ' . $first_name . ' ' . $last_name . ',</h6>
                <p style="color:#788a95;font-size:15px;margin:10px 0px 15px">Your appointment has been Cancelled with ' . COMPANY_NAME . '</p>
                </div>
                <div style="border-bottom:1px solid #e5e5e5;margin-bottom:20px;padding-bottom:15px">
                <div style="display:inline-block;width:100%">
                <label style="color:#788a95;font-size:15px">When:&nbsp;</label>
                <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . date("d M Y", strtotime($appointment_date)) . ' ' . date('h:i:s a', strtotime($appointment_time)) . ' ' . $customer_timezone . '</p>
                </div>
                <div style="display:inline-block;width:100%">
                <label style="color:#788a95;font-size:15px">Service:&nbsp;</label>
                <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . $service_name . '</p>
                </div>
                <div style="display:inline-block;width:100%">
                <label style="color:#788a95;font-size:15px">Provider:&nbsp;</label>
                <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . $staff_first_name . ' ' . $staff_last_name . '</p>
                </div>
                </div>
                <div style="border-bottom12:1px solid #e5e5e5;padding-bottom:5px;margin-bottom:20px">
                <p style="color:#788a95;font-size:15px;margin:10px 0px 15px">' . $common_data_email_signature . '</p>
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


                    $headers = 'MIME-Version: 1.0' . "\r\n";
                    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                    $headers .= 'From: ' . $common_data_sendar_name . '<' . COMPANY_EMAIL . ">\r\n" .
                        'Reply-To: ' . COMPANY_EMAIL . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();

                    $subject = "Appointment Scheduled for " . date(COMMON_DATE_FORMAT, strtotime($appointment_date)) . " " . date('h:i:s a', strtotime($appointment_time)) . " with " . $staff_first_name . " " . $staff_last_name . " is Cancelled";

                    $confirm = mail($customer_email, $subject, $customer_delete_appointment_email_body, $headers);

                }
            }
            /***************************Appointment scheduled cancle email to staff*************************/

            if (is_array($common_data_staff_notification)) {
                if (in_array('appointment_canceled', $common_data_staff_notification)) {
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
                    <img align="left" alt="' . COMPANY_NAME . '" src="' . COMPANY_LOGO_PATH . '" width="150px"></td> 
                    </tr>
                    <tr>
                    <td style="color:rgb(102,102,102);font-size:10px;padding-bottom:30px;text-align:left;font-family:arial">
                    <div style="border-bottom:1px solid #e5e5e5;padding-bottom:5px;margin-bottom:20px">
                    <h1 style="color:#4e5b63;font-size:28px;margin:15px 0px 0px;font-weight:500">Cancelled</h1>
                    <h6 style="color:#4e5b63;font-size:15px;margin:25px 0px 10px;font-weight:500">Hi ' . $staff_first_name . ' ' . $staff_last_name . ',</h6>
                    <p style="color:#788a95;font-size:15px;margin:10px 0px 15px">Your appointment has been cancelled.</p>
                    </div>
                    <div style="border-bottom:1px solid #e5e5e5;margin-bottom:20px;padding-bottom:15px">
                    <div style="display:inline-block;width:100%">
                    <label style="color:#788a95;font-size:15px">When:&nbsp;</label>
                    <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . date("d M Y", strtotime($appointment_date)) . ' ' . date('h:i:s a', strtotime($appointment_time)) . ' ' . $staff_timezone . '</p>
                    </div>
                    <div style="display:inline-block;width:100%">
                    <label style="color:#788a95;font-size:15px">Service:&nbsp;</label>
                    <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . $service_name . '</p>
                    </div>
                    <div style="display:inline-block;width:100%">
                    <label style="color:#788a95;font-size:15px">Provider:&nbsp;</label>
                    <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . $staff_first_name . ' ' . $staff_last_name . '</p>
                    </div>
                    
                    </div>';
                    if (in_array('include_customer_info', $common_data_staff_notification)) {
                        $staff_delete_appointment_email_body .= '
                        
                        <div style="border-bottom:1px solid #e5e5e5;margin-bottom:20px;padding-bottom:15px">
                        <div style="display:inline-block;width:100%">
                        <label style="color:#788a95;font-size:15px">customer:&nbsp;</label>
                        <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . $first_name . ' ' . $last_name . '</p>
                        </div><div style="display:inline-block;width:100%">
                        <label style="color:#788a95;font-size:15px">Phone:&nbsp;</label>
                        <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . $customer_phone . '</p>
                        </div>
                        <div style="display:inline-block;width:100%">
                        <label style="color:#788a95;font-size:15px">Email:&nbsp;</label>
                        <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . $customer_email . '</p>
                        </div>
                        <div style="display:inline-block;width:100%">
                        <label style="color:#788a95;font-size:15px">Booked From :&nbsp;</label>
                        <p style="display:inline-block;margin:0;color:#637374;font-size:15px">Customer Page</p>
                        </div></div>';
                    }
                    $staff_delete_appointment_email_body .= '<div style="border-bottom12:1px solid #e5e5e5;padding-bottom:5px;margin-bottom:20px">
                    <p style="color:#788a95;font-size:15px;margin:10px 0px 15px">' . $common_data_email_signature . '</p>
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


                    $headers = 'MIME-Version: 1.0' . "\r\n";
                    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                    $headers .= 'From: ' . $common_data_sendar_name . '<' . COMPANY_EMAIL . ">\r\n" .
                        'Reply-To: ' . COMPANY_EMAIL . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();

                    $subject = "Appointment Scheduled on " . date(COMMON_DATE_FORMAT, strtotime($appointment_date)) . " " . date('h:i:s a', strtotime($appointment_time)) . " with " . $first_name . " " . $last_name . "  is Cancelled";

                    $confirm = mail($staff_email, $subject, $staff_delete_appointment_email_body, $headers);
                }
            }

            if ($confirm == '1') {
                $return['msg'] = '<div class="alert alert-success text-success">
                 <i class="fa fa-smile-o"></i> <button class="close" data-dismiss="alert" type="button">
                 <i class="fa fa-times-circle-o"></i></button> Appointment Cancel successfully and mail sent.
                 </div>';
                $return['error'] = false;
                echo json_encode($return);
            } else {
                $return['msg'] = '<div class="alert alert-success text-success">
              <i class="fa fa-smile-o"></i> <button class="close" data-dismiss="alert" type="button">
              <i class="fa fa-times-circle-o"></i></button> Appointment Cancel successfully!. 
              </div>';
                $return['error'] = false;
                echo json_encode($return);
            }
        }


    }

} ?>
<?php
/****************************************************************************************/
/*****************************Delete an Appointment*************************************/
/**************************************************************************************/

if (isset($_REQUEST['update_arrival_appointment'])) {
    $appont_details = $db->get_row('appointments', array('id' => $_REQUEST['delete_appointment']));

    $first_name = $db->get_var('customers', array('id' => $appont_details['customer_id']), 'first_name');
    $last_name = $db->get_var('customers', array('id' => $appont_details['customer_id']), 'last_name');
    $customer_email = $db->get_var('customers', array('id' => $appont_details['customer_id']), 'email');
    $customer_phone = $db->get_var('customers', array('id' => $appont_details['customer_id']), 'mobile_number');
    $service_name = $db->get_var('services', array('id' => $appont_details['service_id']), 'service_name');
    $staff_first_name = $db->get_var('users', array('user_id' => $appont_details['staff_id']), 'firstname');
    $staff_last_name = $db->get_var('users', array('user_id' => $appont_details['staff_id']), 'lastname');
    $staff_email = $db->get_var('users', array('user_id' => $appont_details['staff_id']), 'email');
    $appointment_date = $appont_details['appointment_date'];
    $appointment_time = $appont_details['appointment_time'];
    $appointment_company_id = $appont_details['company_id'];

    $event = "<b>Canceled appt.</b>  " . $first_name . " " . $last_name . " for a " . $service_name . "<br>
    on " . date(COMMON_DATE_FORMAT, strtotime($appointment_date)) . "@" . date('h:i:s a', strtotime($appointment_time)) . " w/ " . $staff_first_name . " " . $staff_last_name;
    $db->insert('activity_logs', array('user_id' => $_SESSION['user_id'],
        'event_type' => 'appointment_deleted',
        'event' => $event,
        'company_id' => $appointment_company_id,
        'event_type_id' => $_REQUEST['delete_appointment'],
        'created_date' => date('Y-m-d'),
        'ip_address' => $_SERVER['REMOTE_ADDR']

    ));
    $delete = $db->delete('appointments', array('id' => $_REQUEST['delete_appointment']));

} ?>
<?php
/****************************************************************************************/
/*****************************load Appointment cancel form to modal box code*************************************/
/**************************************************************************************/
if (isset($_REQUEST['cancel_appointment'])) {
    $appointment_detail = $db->get_row('appointments', array('id' => $_REQUEST['cancel_appointment']));
    $staff_fname = $db->get_var('users', array('user_id' => $appointment_detail['staff_id']), 'firstname');
    $staff_lname = $db->get_var('users', array('user_id' => $appointment_detail['staff_id']), 'lastname');
    $status = $appointment_detail['status'];
    $payment_status = $appointment_detail['payment_status'];
// strtotime($appointment_detail['appointment_date']." ".$appointment_detail['appointment_time']) < strtotime(date('Y-m-d H:i'))
    if ($status == "confirmed" && $payment_status == "paid") {
        echo "<h4 style='color:red;'>Appointment is Confirmed and Paid  so you can not cancel it.</h4>";

    } else {
        ?>


        <div class="form-group">
            <label class="control-label col-md-3">Motivo cancellazione<font color="red">*</font></label>
            <div class="col-md-8">
                <input type="hidden" name="cancel_appointment_submit" value="cancel_appointment_submit">
                <input type="hidden" name="customer_id" value="<?php echo $appointment_detail['customer_id']; ?>">
                <input type="hidden" name="appointment_id" value="<?php echo $appointment_detail['id']; ?>">
                <select class="form-control" name="cancel_reason" onclick='show_field(this.value);'>
                    <option value="">---Seleziona---</option>
                    <option value="by mistake and therefore permanent cancellation">Errore-Rimuovi tutto</option>

                    <!-- <option value ="appointment shift due to impossibility on the part of the dental office">Impossibilità dello STUDIO</option>
                 <option value ="appointment shift due to impossibility on the part of the patient">Impossibilità del PAZIENTE</option> -->
                    <option value="cancellation, calling off, by the patient">Cancellazione del PAZIENTE</option>

                </select>
                <br>
                <input class="form-control" type="text" id="cancel_field" placeholder="Enter Reason for Cancellation"
                       name="reason_cancel_field" style="display: none;" required>
            </div>
        </div>
        <hr>
        <div class="form-group">
            <label class="control-label col-md-3"></label>
            <div class="col-md-4">
                <button type="button" class="btn btn-default btn-block" data-dismiss="modal"><i
                            class="fa fa-times-circle"></i> Chiudi
                </button>
            </div>
            <div class="col-md-4">
                <button class="btn btn-info btn-block" name="cancel_appointment_form_submit" type="submit"><i
                            class="fa fa-save"></i> Invia
                </button>
            </div>

        </div>


    <?php } ?>


<?php } ?>
<?php
/****************************************************************************************/
/*****************************Update Patient arrival*************************************/
/**************************************************************************************/

if (isset($_REQUEST['update_appointment'])) {
    $appointment_id = $_REQUEST['update_appointment'];

    $update = $db->update('appointments', array('status' => 'visit in process', 'ip_address' => $_SERVER['REMOTE_ADDR']), array('id' => $appointment_id));

    if ($update) {
        $return['msg'] = '<div class="alert alert-success text-success">
            <i class="fa fa-smile-o"></i> <button class="close" data-dismiss="alert" type="button">
            <i class="fa fa-times-circle-o"></i></button> visit in process updated successfully.
            </div>';
        $return['error'] = false;
        echo json_encode($return);
    } else {
        $return['error'] = true;
        $return['msg'] = '';
        echo json_encode($return);
    }

}
?>

<?php
/****************************************************************************************/
/*****************************Update Patient arrival*************************************/
/**************************************************************************************/

if (isset($_REQUEST['update_appointment_auto'])) {
    $ipAddd = $_SERVER['REMOTE_ADDR'];
    $visit_in_process = VISIT_IN_PRECESS;
    $curDate = date("Y-m-d");
    $updateApp = $db->run("SELECT * FROM `appointments` WHERE `status`= '$visit_in_process' AND `ip_address`= '$ipAddd' AND `appointment_date` = '$curDate'")->fetchAll();

    // echo "<pre>";
    // print_r($updateApp);exit;
    $ids = "";
    if (!empty($updateApp) && count($updateApp) > 0) {
        foreach ($updateApp as $ua => $uApp) {
            $appTime = strtotime($uApp['appointment_end_time']);
            $curTime = time();

            if ($curTime > $appTime) {
                $visit_done = VISIT_DONE;
                $update = $db->update('appointments', array('status' => "$visit_done", 'ip_address' => $_SERVER['REMOTE_ADDR']), array('id' => $uApp['id']));
                $ids .= '.class-' . $uApp['id'] . ",";
            }
        }
        $return['msg'] = "Visita ESEGUITA";
        $return['error'] = false;
        $return['id'] = rtrim($ids, ',');
        echo json_encode($return);
    }

}
?>

<?php
/****************************************************************************************/
/*****************************Delete an Appointment*************************************/
/**************************************************************************************/

if (isset($_REQUEST['delete_appointment'])) {
    $appont_details = $db->get_row('appointments', array('id' => $_REQUEST['delete_appointment']));

    $first_name = $db->get_var('customers', array('id' => $appont_details['customer_id']), 'first_name');
    $last_name = $db->get_var('customers', array('id' => $appont_details['customer_id']), 'last_name');
    $customer_email = $db->get_var('customers', array('id' => $appont_details['customer_id']), 'email');
    $customer_phone = $db->get_var('customers', array('id' => $appont_details['customer_id']), 'mobile_number');
    $service_name = $db->get_var('services', array('id' => $appont_details['service_id']), 'service_name');
    $staff_first_name = $db->get_var('users', array('user_id' => $appont_details['staff_id']), 'firstname');
    $staff_last_name = $db->get_var('users', array('user_id' => $appont_details['staff_id']), 'lastname');
    $staff_email = $db->get_var('users', array('user_id' => $appont_details['staff_id']), 'email');
    $appointment_date = $appont_details['appointment_date'];
    $appointment_time = $appont_details['appointment_time'];
    $appointment_company_id = $appont_details['company_id'];

    $event = "<b>Canceled appt.</b>  " . $first_name . " " . $last_name . " for a " . $service_name . "<br>
    on " . date(COMMON_DATE_FORMAT, strtotime($appointment_date)) . "@" . date('h:i:s a', strtotime($appointment_time)) . " w/ " . $staff_first_name . " " . $staff_last_name;
    $db->insert('activity_logs', array('user_id' => $_SESSION['user_id'],
        'event_type' => 'appointment_deleted',
        'event' => $event,
        'company_id' => $appointment_company_id,
        'event_type_id' => $_REQUEST['delete_appointment'],
        'created_date' => date('Y-m-d'),
        'ip_address' => $_SERVER['REMOTE_ADDR']

    ));
    $delete = $db->delete('appointments', array('id' => $_REQUEST['delete_appointment']));
    if ($delete) {
        if (is_array($common_data_customer_notification)) {
            if (in_array('appointment_canceled', $common_data_customer_notification)) {
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
                <img align="left" alt="' . COMPANY_NAME . '" src="' . COMPANY_LOGO_PATH . '" width="150px"></td> 
                </tr>
                <tr>
                <td style="color:rgb(102,102,102);font-size:10px;padding-bottom:30px;text-align:left;font-family:arial">
                <div style="border-bottom:1px solid #e5e5e5;padding-bottom:5px;margin-bottom:20px">
                <h1 style="color:#4e5b63;font-size:28px;margin:15px 0px 0px;font-weight:500">Cancelled</h1>
                <h6 style="color:#4e5b63;font-size:15px;margin:25px 0px 10px;font-weight:500">Hi ' . $first_name . ' ' . $last_name . ',</h6>
                <p style="color:#788a95;font-size:15px;margin:10px 0px 15px">Your appointment has been Cancelled with ' . COMPANY_NAME . '</p>
                </div>
                <div style="border-bottom:1px solid #e5e5e5;margin-bottom:20px;padding-bottom:15px">
                <div style="display:inline-block;width:100%">
                <label style="color:#788a95;font-size:15px">When:&nbsp;</label>
                <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . date("d M Y", strtotime($appointment_date)) . ' ' . date('h:i:s a', strtotime($appointment_time)) . ' ' . $customer_timezone . '</p>
                </div>
                <div style="display:inline-block;width:100%">
                <label style="color:#788a95;font-size:15px">Service:&nbsp;</label>
                <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . $service_name . '</p>
                </div>
                <div style="display:inline-block;width:100%">
                <label style="color:#788a95;font-size:15px">Provider:&nbsp;</label>
                <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . $staff_first_name . ' ' . $staff_last_name . '</p>
                </div>
                </div>
                <div style="border-bottom12:1px solid #e5e5e5;padding-bottom:5px;margin-bottom:20px">
                <p style="color:#788a95;font-size:15px;margin:10px 0px 15px">' . $common_data_email_signature . '</p>
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


                $headers = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $headers .= 'From: ' . $common_data_sendar_name . '<' . COMPANY_EMAIL . ">\r\n" .
                    'Reply-To: ' . COMPANY_EMAIL . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

                $subject = "Appuntamento prenotato il " . date(COMMON_DATE_FORMAT, strtotime($appointment_date)) . " alle ore " . date('h:i:s a', strtotime($appointment_time)) . " con " . $staff_first_name . " " . $staff_last_name . " è stato cancellato";

                $confirm = mail($customer_email, $subject, $customer_delete_appointment_email_body, $headers);

            }
        }
        /***************************Appointment scheduled cancle email to staff*************************/

        if (is_array($common_data_staff_notification)) {
            if (in_array('appointment_canceled', $common_data_staff_notification)) {
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
                    <img align="left" alt="' . COMPANY_NAME . '" src="' . COMPANY_LOGO_PATH . '" width="150px"></td> 
                    </tr>
                    <tr>
                    <td style="color:rgb(102,102,102);font-size:10px;padding-bottom:30px;text-align:left;font-family:arial">
                    <div style="border-bottom:1px solid #e5e5e5;padding-bottom:5px;margin-bottom:20px">
                    <h1 style="color:#4e5b63;font-size:28px;margin:15px 0px 0px;font-weight:500">Cancelled</h1>
                    <h6 style="color:#4e5b63;font-size:15px;margin:25px 0px 10px;font-weight:500">Hi ' . $staff_first_name . ' ' . $staff_last_name . ',</h6>
                    <p style="color:#788a95;font-size:15px;margin:10px 0px 15px">Your appointment has been cancelled.</p>
                    </div>
                    <div style="border-bottom:1px solid #e5e5e5;margin-bottom:20px;padding-bottom:15px">
                    <div style="display:inline-block;width:100%">
                    <label style="color:#788a95;font-size:15px">When:&nbsp;</label>
                    <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . date("d M Y", strtotime($appointment_date)) . ' ' . date('h:i:s a', strtotime($appointment_time)) . ' ' . $staff_timezone . '</p>
                    </div>
                    <div style="display:inline-block;width:100%">
                    <label style="color:#788a95;font-size:15px">Service:&nbsp;</label>
                    <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . $service_name . '</p>
                    </div>
                    <div style="display:inline-block;width:100%">
                    <label style="color:#788a95;font-size:15px">Provider:&nbsp;</label>
                    <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . $staff_first_name . ' ' . $staff_last_name . '</p>
                    </div>
                    
                    </div>';
                if (in_array('include_customer_info', $common_data_staff_notification)) {
                    $staff_delete_appointment_email_body .= '
                        
                        <div style="border-bottom:1px solid #e5e5e5;margin-bottom:20px;padding-bottom:15px">
                        <div style="display:inline-block;width:100%">
                        <label style="color:#788a95;font-size:15px">customer:&nbsp;</label>
                        <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . $first_name . ' ' . $last_name . '</p>
                        </div><div style="display:inline-block;width:100%">
                        <label style="color:#788a95;font-size:15px">Phone:&nbsp;</label>
                        <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . $customer_phone . '</p>
                        </div>
                        <div style="display:inline-block;width:100%">
                        <label style="color:#788a95;font-size:15px">Email:&nbsp;</label>
                        <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . $customer_email . '</p>
                        </div>
                        <div style="display:inline-block;width:100%">
                        <label style="color:#788a95;font-size:15px">Booked From :&nbsp;</label>
                        <p style="display:inline-block;margin:0;color:#637374;font-size:15px">Customer Page</p>
                        </div></div>';
                }
                $staff_delete_appointment_email_body .= '<div style="border-bottom12:1px solid #e5e5e5;padding-bottom:5px;margin-bottom:20px">
                    <p style="color:#788a95;font-size:15px;margin:10px 0px 15px">' . $common_data_email_signature . '</p>
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


                $headers = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $headers .= 'From: ' . $common_data_sendar_name . '<' . COMPANY_EMAIL . ">\r\n" .
                    'Reply-To: ' . COMPANY_EMAIL . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();

                $subject = "Appointment Scheduled on " . date(COMMON_DATE_FORMAT, strtotime($appointment_date)) . " " . date('h:i:s a', strtotime($appointment_time)) . " with " . $first_name . " " . $last_name . "  is Cancelled";

                $confirm = mail($staff_email, $subject, $staff_delete_appointment_email_body, $headers);
            }
        }

        if ($confirm == '1') {
            $return['msg'] = '<div class="alert alert-success text-success">
                 <i class="fa fa-smile-o"></i> <button class="close" data-dismiss="alert" type="button">
                 <i class="fa fa-times-circle-o"></i></button> Appointment Cancel successfully and mail sent.
                 </div>';
            $return['error'] = false;
            echo json_encode($return);
        } else {
            $return['msg'] = '<div class="alert alert-success text-success">
              <i class="fa fa-smile-o"></i> <button class="close" data-dismiss="alert" type="button">
              <i class="fa fa-times-circle-o"></i></button> Appointment Cancel successfully!. 
              </div>';
            $return['error'] = false;
            echo json_encode($return);
        }
    }
} ?>
<?php
/***************************************************************************************************/
/*****************************Load service by provider*********************************************/
/**************************************************************************************************/

if (isset($_REQUEST['load_service'])) {
    $all_services_by_provider = $db->get_all('assign_services', array('staff_id' => $_REQUEST['load_service']));

    if (is_array($all_services_by_provider)) {
        echo "<option value=''>---Seleziona---</option>";
        foreach ($all_services_by_provider as $alps) {
            $service_name = $db->get_var('services', array('id' => $alps['service_id']), 'service_name');
            ?>
            <option value="<?php echo $alps['service_id'] ?>"><?php echo $service_name; ?></option>
        <?php }
    }
} ?>


<?php
/***************************************************************************************************/
/*****************************load cost and time of service****************************************/
/**************************************************************************************************/

if (isset($_REQUEST['load_cost_time'])) {
    $service_cost = $db->get_var('services', array('id' => $_REQUEST['load_cost_time']), 'service_cost');
    $service_time = $db->get_var('services', array('id' => $_REQUEST['load_cost_time']), 'service_time'); ?>
    <label class="control-label col-md-3"></label>
    <div class="col-md-4">
        <div class="input-group mar-btm">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button"><?php echo $currency; ?></button>
                </span>
            <input class="form-control" type="text" name="appointment_service_cost" value="<?php echo $service_cost; ?>"
                   placeholder="cost">
        </div>
    </div>
    <div class="col-md-4">
        <div class="input-group mar-btm">
            <input class="form-control" type="number" name="appointment_service_time"
                   value="<?php echo $service_time; ?>" placeholder="Mins">
            <span class="input-group-btn">
            <button class="btn btn-default" type="button">min</button>
        </span>
        </div>
    </div>

<?php } ?>
<?php
/***************************************************************************************************/
/*****************************Add timeoff or leave of an employee***********************************/
/**************************************************************************************************/
if (isset($_POST['add_timeoff_submit'])) {
    $company_id = $_POST['company_id'];
    $staff_id = $_POST['staff_id'];
    $timeoff_start_date = $_POST['timeoff_start_date'];
    $timeoff_end_date = $_POST['timeoff_end_date'];
    $timeoff_notes = $_POST['timeoff_notes'];

    $created_date = date('Y-m-d');
    $ip_address = $_SERVER['REMOTE_ADDR'];


    $check_empty = $fv->emptyfields(array('Select Start Date' => $timeoff_start_date,
        'Select End Date' => $timeoff_end_date,
        'Enter Notes' => $timeoff_notes,
    ), NULL);
    if ($check_empty) {

        $return['msg'] = '<div class="alert alert-danger text-danger">
        <i class="fa fa-frown-o text-danger"></i>
        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
        Following Fields Are Empty!<br>' . $check_empty . '</div>';
        $return['error'] = true;
        echo json_encode($return);

    } elseif (strtotime($timeoff_start_date) > strtotime($timeoff_end_date)) {
        $return['msg'] = '<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
        Start date should be less than end date!.
        </div>';
        $return['error'] = true;
        echo json_encode($return);
    } elseif (strtotime(date('Y-m-d')) > strtotime($timeoff_start_date)) {
        $return['msg'] = '<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
        Start date should be greater than or equal to today!.
        </div>';
        $return['error'] = true;
        echo json_encode($return);
    } elseif (strtotime($timeoff_start_date) < strtotime(date('Y-m-d'))) {
        $return['msg'] = '<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
        Timeoff start date should be greater than today date!
        </div>';
        $return['error'] = true;
        echo json_encode($return);
    } else {
        $insert = $db->insert('timeoff', array('company_id' => $company_id,
            'staff_id' => $staff_id,
            'start_date' => $timeoff_start_date,
            'end_date' => $timeoff_end_date,
            'notes' => $timeoff_notes,
            'created_date' => date('Y-m-d'),
            'ip_address' => $_SERVER['REMOTE_ADDR']));

        if ($insert) {


            $return['msg'] = '<div class="alert alert-success text-success">
        <i class="fa fa-smile-o"></i>
        <button class="close" data-dismiss="alert" type="button">
        <i class="fa fa-times-circle-o"></i></button> Time Off add successfully!.
        </div>';
            $return['error'] = false;
            echo json_encode($return);
        }


    }
} ?>
<?php
/************************************************************************************************/
/*****************************Close a company account and delete all related data **************/
/***********************************************************************************************/
if (isset($_POST['close_account_submit'])) {


    $company_id = $_POST['company_id'];
    $company_name = $_POST['company_name'];
    $company_email = $_POST['company_email'];
    $close_reason = $_POST['close_reason'];

    if ($close_reason == "") {
        $return['msg'] = '<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
        Please Enter A Reason!.
        </div>';
        $return['error'] = true;
        echo json_encode($return);
    } else {
        $insert = $db->insert('account_close_reason', array('company_name' => $company_name,
            'company_email' => $company_email,
            'reason' => $close_reason,
            'created_date' => date('Y-m-d'),
            'ip_address' => $_SERVER['REMOTE_ADDR']));

        if ($insert) {

            $delete_activity_logs = $db->delete('activity_logs', array('company_id' => $company_id));
            $delete_appointments = $db->delete('appointments', array('company_id' => $company_id));
            $delete_assign_services = $db->delete('assign_services', array('company_id' => $company_id));
            $delete_services = $db->delete('services', array('company_id' => $company_id));
            $delete_service_category = $db->delete('service_category', array('company_id' => $company_id));
            $delete_customers = $db->delete('customers', array('company_id' => $company_id));
            $delete_timeoff = $db->delete('timeoff', array('company_id' => $company_id));
            $delete_notification_settings = $db->delete('notification_settings', array('company_id' => $company_id));
            $delete_preferences_settings = $db->delete('preferences_settings', array('company_id' => $company_id));
            $delete_users = $db->delete('users', array('company_id' => $company_id));
            $delete_plans_company = $db->delete('plans_company', array('company_id' => $company_id));
            $delete_plans_all = $db->delete('plans_all', array('company_id' => $company_id));
            $delete_users = $db->delete('rooms', array('company_id' => $company_id));
            $delete_company = $db->delete('company', array('id' => $company_id));

            $path = SITE_ROOT . "/uploads/company/" . $company_id;
            if (file_exists($path)) {
                rmdir($path);

            }
            $return['msg'] = '<div class="alert alert-success text-success">
        <i class="fa fa-smile-o"></i>
        <button class="close" data-dismiss="alert" type="button">
        <i class="fa fa-times-circle-o"></i></button> Your Account Close successfully!.
        </div>';
            $return['error'] = false;
            echo json_encode($return);
        }


    }
} ?>
<?php
/****************************************************************************************/
/*****************************Assign room to an appointment holder**********************/
/**************************************************************************************/

if (isset($_POST['assign_room_submit'])) {
    $appointment_id = $_POST['appointment_id'];
    $room_id = $_POST['room_id'];
    if ($room_id == "") {
        $return['msg'] = '<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
        Please Select Room/Seat!.
        </div>';
        $return['error'] = true;
        echo json_encode($return);
    } else {
        $check_appont_details = $db->get_row('appointments', array('id' => $appointment_id));
        $customer_id = $check_appont_details['customer_id'];
        $service_provider = $check_appont_details['staff_id'];
        $appointment_service = $check_appont_details['service_id'];
        $appointment_booking_id = $check_appont_details['booking_id'];
        $first_name = $db->get_var('customers', array('id' => $customer_id), 'first_name');
        $last_name = $db->get_var('customers', array('id' => $customer_id), 'last_name');
        $customer_email = $db->get_var('customers', array('id' => $customer_id), 'email');
        $customer_phone = $db->get_var('customers', array('id' => $customer_id), 'mobile_number');
        $service_name = $db->get_var('services', array('id' => $appointment_service), 'service_name');
        $staff_first_name = $db->get_var('users', array('user_id' => $service_provider), 'firstname');
        $staff_last_name = $db->get_var('users', array('user_id' => $service_provider), 'lastname');
        $staff_email = $db->get_var('users', array('user_id' => $service_provider), 'email');

        $appointment_date = $check_appont_details['appointment_date'];
        $appointment_start_time = $check_appont_details['appointment_time'];
        $appointment_end_time = $check_appont_details['appointment_end_time'];


        $query = "SELECT* FROM `appointments` 
        WHERE `appointment_date`='$appointment_date' 
        AND `appointment_time` BETWEEN '$appointment_start_time' AND '$appointment_end_time'  
        AND `assigned_room`='$room_id'
        AND `status`='confirmed'
        AND `id`!='$appointment_id'";
        $fetchall_appointments_of_the_day = $db->run($query)->fetchAll();


        if (!empty($fetchall_appointments_of_the_day)) {

            $return['msg'] = '<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
            <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
            Room is alredy booked for this time!
            </div>';
            $return['error'] = true;
            echo json_encode($return);

        } else {
            $assign_r_e = "room ready to block";
            $update = $db->update('appointments', array('assigned_room' => $room_id, 'status' => 'confirmed'), array('id' => $appointment_id));
            if ($update) {


                /**************email sent to customer*************************/
                if (is_array($common_data_customer_notification)) {
                    if (in_array('appointment_booked', $common_data_customer_notification)) {
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
                        <img align="left" alt="' . COMPANY_NAME . '" src="' . COMPANY_LOGO_PATH . '" width="150px"></td> 
                        </tr>
                        <tr>
                        <td style="color:rgb(102,102,102);font-size:10px;padding-bottom:30px;text-align:left;font-family:arial">
                        <div style="border-bottom:1px solid #e5e5e5;padding-bottom:5px;margin-bottom:20px">
                        <h1 style="color:#4e5b63;font-size:28px;margin:15px 0px 0px;font-weight:500">Thank You</h1>
                        <h6 style="color:#4e5b63;font-size:15px;margin:25px 0px 10px;font-weight:500">Hi ' . $first_name . ' ' . $last_name . ',</h6>
                        <p style="color:#788a95;font-size:15px;margin:10px 0px 15px">
                        Your appointment request has been booked and approved with ' . COMPANY_NAME . '.<br>
                        Your Booking no-' . $appointment_booking_id . ' .  </p>
                        </div>
                        <div style="border-bottom:1px solid #e5e5e5;margin-bottom:20px;padding-bottom:15px">
                        <div style="display:inline-block;width:100%">
                        <label style="color:#788a95;font-size:15px">When:&nbsp;</label>
                        <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . date("d M Y", strtotime($appointment_date)) . ' ' . date('h:i:s a', strtotime($appointment_time)) . ' ' . $customer_timezone . '</p>
                        </div>
                        <div style="display:inline-block;width:100%">
                        <label style="color:#788a95;font-size:15px">Service:&nbsp;</label>
                        <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . $service_name . '</p>
                        </div>
                        <div style="display:inline-block;width:100%">
                        <label style="color:#788a95;font-size:15px">Provider:&nbsp;</label>
                        <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . $staff_first_name . ' ' . $staff_last_name . '</p>
                        </div>
                        </div>
                        <div style="border-bottom12:1px solid #e5e5e5;padding-bottom:5px;margin-bottom:20px">
                        <p style="color:#788a95;font-size:15px;margin:10px 0px 15px">' . $common_data_email_signature . '</p>
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


                        $headers = 'MIME-Version: 1.0' . "\r\n";
                        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                        $headers .= 'From: ' . $common_data_sendar_name . '<' . COMPANY_EMAIL . ">\r\n" .
                            'Reply-To: ' . COMPANY_EMAIL . "\r\n" .
                            'X-Mailer: PHP/' . phpversion();

                        $subject = "Appointment Schedule Approved for " . date(COMMON_DATE_FORMAT, strtotime($appointment_date)) . " " . date('h:i:s a', strtotime($appointment_time)) . " with " . $staff_first_name . " " . $staff_last_name;

                        $confirm = mail($customer_email, $subject, $customer_add_appointment_email_body, $headers);
                    }
                }
                /****************************email sent to staff************************************/
                if (is_array($common_data_staff_notification)) {
                    if (in_array('appointment_booked', $common_data_staff_notification)) {
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
                            <img align="left" alt="' . COMPANY_NAME . '" src="' . COMPANY_LOGO_PATH . '" width="150px"></td> 
                            </tr>
                            <tr>
                            <td style="color:rgb(102,102,102);font-size:10px;padding-bottom:30px;text-align:left;font-family:arial">
                            <div style="border-bottom:1px solid #e5e5e5;padding-bottom:5px;margin-bottom:20px">
                            <h1 style="color:#4e5b63;font-size:28px;margin:15px 0px 0px;font-weight:500">New Appointment</h1>
                            <h6 style="color:#4e5b63;font-size:15px;margin:25px 0px 10px;font-weight:500">Hi ' . $staff_first_name . ' ' . $staff_last_name . ',</h6>
                            <p style="color:#788a95;font-size:15px;margin:10px 0px 15px">
                            You have an appointment scheduled with ' . ucfirst($first_name . ' ' . $last_name) . '. is approved now.<br>
                            Booking no-' . $appointment_booking_id . '.</p>
                            </div>
                            <div style="border-bottom:1px solid #e5e5e5;margin-bottom:20px;padding-bottom:15px">
                            <div style="display:inline-block;width:100%">
                            <label style="color:#788a95;font-size:15px">When:&nbsp;</label>
                            <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . date("d M Y", strtotime($appointment_date)) . ' ' . date('h:i:s a', strtotime($appointment_time)) . ' ' . $staff_timezone . '</p>
                            </div>
                            <div style="display:inline-block;width:100%">
                            <label style="color:#788a95;font-size:15px">Service:&nbsp;</label>
                            <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . $service_name . '</p>
                            </div>
                            <div style="display:inline-block;width:100%">
                            <label style="color:#788a95;font-size:15px">Provider:&nbsp;</label>
                            <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . $staff_first_name . ' ' . $staff_last_name . '</p>
                            </div>
                            
                            </div>';
                        if (in_array('include_customer_info', $common_data_staff_notification)) {
                            $staff_add_appointment_email_body .= '
                                
                                <div style="border-bottom:1px solid #e5e5e5;margin-bottom:20px;padding-bottom:15px">
                                <div style="display:inline-block;width:100%">
                                <label style="color:#788a95;font-size:15px">customer:&nbsp;</label>
                                <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . ucfirst($first_name . ' ' . $last_name) . '</p>
                                </div><div style="display:inline-block;width:100%">
                                <label style="color:#788a95;font-size:15px">Phone:&nbsp;</label>
                                <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . $customer_phone . '</p>
                                </div>
                                <div style="display:inline-block;width:100%">
                                <label style="color:#788a95;font-size:15px">Email:&nbsp;</label>
                                <p style="display:inline-block;margin:0;color:#637374;font-size:15px">' . $customer_email . '</p>
                                </div>
                                <div style="display:inline-block;width:100%">
                                <label style="color:#788a95;font-size:15px">Booked From :&nbsp;</label>
                                <p style="display:inline-block;margin:0;color:#637374;font-size:15px">Customer Page</p>
                                </div></div>';
                        }
                        $staff_add_appointment_email_body .= '<div style="border-bottom12:1px solid #e5e5e5;padding-bottom:5px;margin-bottom:20px">
                            <p style="color:#788a95;font-size:15px;margin:10px 0px 15px">' . $common_data_email_signature . '</p>
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


                        $headers = 'MIME-Version: 1.0' . "\r\n";
                        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                        $headers .= 'From: ' . $common_data_sendar_name . '<' . COMPANY_EMAIL . ">\r\n" .
                            'Reply-To: ' . COMPANY_EMAIL . "\r\n" .
                            'X-Mailer: PHP/' . phpversion();

                        $subject = "Appointment Schedule Approved for " . date(COMMON_DATE_FORMAT, strtotime($appointment_date)) . " " . date('h:i:s a', strtotime($appointment_time)) . " with " . $first_name . " " . $last_name;

                        $confirm = mail($staff_email, $subject, $staff_add_appointment_email_body, $headers);
                    }
                }


                if ($confirm == '1') {
                    $return['msg'] = '<div class="alert alert-success text-success">
                            <i class="fa fa-smile-o"></i> <button class="close" data-dismiss="alert" type="button">
                            <i class="fa fa-times-circle-o"></i></button> Room Block Successfully and mail sent.
                            </div>';
                    $return['error'] = false;
                    echo json_encode($return);
                } else {
                    $return['msg'] = '<div class="alert alert-success text-success">
                            <i class="fa fa-smile-o"></i> <button class="close" data-dismiss="alert" type="button">
                            <i class="fa fa-times-circle-o"></i></button> Room Block Successfully.
                            </div>';
                    $return['error'] = false;
                    echo json_encode($return);
                }


            }
        }

    }
} ?>

<?php
/****************************************************************************************/
/*****************************load time slot of an employee*************************************/
/**************************************************************************************/
if (isset($_POST['load_time_range'])) {

    $service_provider = $_POST['load_time_range'];
    $appointment_date = $_POST['adate'];

    /*******************Check Appontment time exist in working  time or not on working day  ************/
    $dayName = date("l", strtotime($appointment_date));

    $working_day = unserialize($db->get_var('users', array('user_id' => $service_provider), 'working_day'));
    $working_on_off = unserialize($db->get_var('users', array('user_id' => $service_provider), 'working_on_off'));
    $working_start_time = unserialize($db->get_var('users', array('user_id' => $service_provider), 'working_start_time'));
    $working_end_time = unserialize($db->get_var('users', array('user_id' => $service_provider), 'working_end_time'));

    $company_id = $db->get('users', array('user_id' => $service_provider), 'company_id');

    if (!empty($receiptnistAccess)) {
        $time_slots = $receiptnistTimeSlot;
    } else {
        $time_slots = $db->get('preferences_settings', array('company_id' => $company_id[0]['company_id']), 'custom_time_slot');
    }

    $booked_date = $db->get_all('appointments', array('staff_id' => $service_provider, 'appointment_date' => date('Y-m-d', strtotime($appointment_date))), 'appointment_date,appointment_time,appointment_end_time');

    foreach ($booked_date as $key => $date) {

        $booked_slot[] = $feature->create_time_range($date['appointment_time'], $date['appointment_end_time'], $time_slots[0]['custom_time_slot'] . ' min', $format = '24');
    }

    $booked_slots = array_reduce($booked_slot, 'array_merge', array());

    $w = true;
    if (is_array($working_day)) {
        foreach ($working_day as $key => $value) {
            if (ucfirst($value) == $dayName) {

                $on_off = $working_on_off[$key];
                $startt = $working_start_time[$key];
                $endt = $working_end_time[$key];
                break;
            }

        }
        $times = $feature->create_time_range($startt, $endt, $time_slots[0]['custom_time_slot'] . ' min', $format = '24');
        if (is_array($times)) {
            foreach ($times as $t) {
                ?>
                <option value="<?php echo $t; ?>" <?php echo (in_array($t, $booked_slots)) ? "disabled" : '' ?> ><?php echo date('h:i A', strtotime($t)); ?></option>
            <?php }
        }
    }


} ?>


<?php
/****************************************************************************************/
/*****************************Add new Service code*************************************/
/**************************************************************************************/

if (isset($_POST['add_service_submit'])) {
    //print_r($_POST);
    $service_name = $_POST['service_name'];
    $service_description = $_POST['service_description'];
    $service_cost = $_POST['service_cost'];
    $service_time = $_POST['service_time'];
    $service_color = $_POST['service_color'];
    $service_buffer_time = $_POST['service_buffer_time'];
    $service_category = $_POST['service_category'];
    $assign_to = $_POST['assign_to'];
    $private_service = $_POST['private_service'];
    $visibility_status = $_POST['visibility_status'];
    $created_date = date('Y-m-d');
    $ip_address = $_SERVER['REMOTE_ADDR'];


    $empt_fields = $fv->emptyfields(array('service Name' => $service_name,
        'Sevice Cost' => $service_cost,
        'Service Time' => $service_time));

    if ($empt_fields) {
        $display_msg = '<div class="alert alert-danger">
          <i class="lnr lnr-sad"></i> <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
          Oops! Following fields are empty<br>' . $empt_fields . '</div>';


        $return['msg'] = '<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
          <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
          Oops! Following fields are empty<br>' . $empt_fields . '</div>';
        $return['error'] = true;
        echo json_encode($return);


    } elseif ($db->exists('services', array('service_name' => $service_name, 'company_id' => CURRENT_LOGIN_COMPANY_ID))) {


        $return['msg'] = '<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
        Service Name is already exist.
        </div>';
        $return['error'] = true;
        echo json_encode($return);


    } else {

        $insert = $db->insert("services", array('company_id' => CURRENT_LOGIN_COMPANY_ID,
            'service_name' => $service_name,
            'service_cost' => $service_cost,
            'service_description' => $service_description,
            'service_time' => $service_time,
            'service_buffer_time' => $service_buffer_time,
            'service_category' => $service_category,
            'service_color' => $service_color,
            'private_service' => $private_service,
            'visibility_status' => 'active',
            'created_date' => $created_date,
            'ip_address' => $ip_address));
        $last_inserted_service = $db->insert_id;
        //  $db->debug();
        if ($insert) {
            if (is_array($assign_to)) {
                foreach ($assign_to as $ato) {
                    $assign = $db->insert("assign_services", array('company_id' => CURRENT_LOGIN_COMPANY_ID,
                        'staff_id' => $ato,
                        'service_id' => $last_inserted_service,
                        'created_date' => $created_date,
                        'ip_address' => $ip_address));
                }
            }
            $return['msg'] = '<div class="alert alert-success text-success">
        <i class="fa fa-smile-o"></i> <button class="close" data-dismiss="alert" type="button">
        <i class="fa fa-times-circle-o"></i></button> service add Successfully.
        </div>';
            $return['error'] = false;
            echo json_encode($return);


        }
    }
} ?>
<?php
/****************************************************************************************/
/*****************************Load status on calendar page code*************************************/
/**************************************************************************************/
if (isset($_POST['load_stat_on_calendar'])) {
    $pi = $_POST['load_stat_on_calendar'];
    $adate = $_POST['adate'];
    $ci = $_POST['company_id'];

    $company_details = $db->get_row('company', array('id' => $ci));
    $company_currency = $company_details['company_currencysymbol'];


    $start_date = date("Y-m-01", strtotime($adate));
    $end_date = date("Y-m-t", strtotime($adate));

    if ($pi != "") {


        /**********************************find Confirmed Revenue*************************/
        $query2 = "SELECT SUM(`service_cost`)
     FROM `appointments`
     WHERE `company_id`='$ci' AND `staff_id`='$pi' AND `appointment_date` BETWEEN '$start_date' AND '$end_date' AND `status`='paid'";
        $confirmed_revenue = $db->run($query2)->fetchColumn();
        /**********************************find Projected Revenue*************************/
        $query2 = "SELECT SUM(`service_cost`)
     FROM `appointments`
     WHERE `company_id`='$ci' AND `staff_id`='$pi' AND `appointment_date` BETWEEN '$start_date' AND '$end_date' AND `status`='confirmed'";
        $projected_revenue = $db->run($query2)->fetchColumn();

        /**********************************find Total Revenue*************************/
        $total_estimate = $confirmed_revenue + $projected_revenue;


        /**********************************find all Appointment of the week*************************/
        $query1 = "SELECT*
     FROM `appointments`
     WHERE `company_id`='$ci' AND `staff_id`='$pi' AND `appointment_date` BETWEEN '$start_date' AND '$end_date'
     ORDER BY id DESC";
        $this_week_appointments = $db->run($query1)->fetchAll();
        $appointment_count = count($this_week_appointments);

    } else {

        /**********************************find Confirmed Revenue*************************/
        $query2 = "SELECT SUM(`service_cost`)
     FROM `appointments`
     WHERE `company_id`='$ci'  AND `appointment_date` BETWEEN '$start_date' AND '$end_date' AND `status`='paid'";
        $confirmed_revenue = $db->run($query2)->fetchColumn();
        /**********************************find Projected Revenue*************************/
        $query2 = "SELECT SUM(`service_cost`)
     FROM `appointments`
     WHERE `company_id`='$ci' AND `appointment_date` BETWEEN '$start_date' AND '$end_date' AND `status`='confirmed'";
        $projected_revenue = $db->run($query2)->fetchColumn();

        /**********************************find Total Revenue*************************/
        $total_estimate = $confirmed_revenue + $projected_revenue;


        /**********************************find all Appointment of the week*************************/
        $query1 = "SELECT*
     FROM `appointments`
     WHERE `company_id`='$ci' AND `appointment_date` BETWEEN '$start_date' AND '$end_date'
     ORDER BY id DESC";
        $this_week_appointments = $db->run($query1)->fetchAll();
        $appointment_count = count($this_week_appointments);


    } ?>
    <table style="margin:20px;">
        <thead>

        </thead>
        <tbody>
        <tr style="text-align:center; border-bottom:1px solid red;">
            <td colspan="3" text-align="center">
                <?php if ($pi != "") {
                    $service_provider_firstname = $db->get_var('users', array('user_id' => $pi), 'firstname');
                    $service_provider_lastname = $db->get_var('users', array('user_id' => $pi), 'lastname');
                    echo ucwords($service_provider_firstname . " " . $service_provider_lastname) . "&#39;s Monthly Stats";
                } else {
                    echo "Monthly Stats " . $pi;
                }


                ?></td>
        </tr>
        <tr>
            <td style="text-align:center;padding:10px;"><h4><?php echo $appointment_count; ?></h4>Appts</td>
            <td style="text-align:center;padding:10px;">
                <h4><?php echo $company_currency . number_format($confirmed_revenue, 2); ?></h4>Confirmed
            </td>
            <td style="text-align:center;padding:10px;">
                <h4><?php echo $company_currency . number_format($projected_revenue, 2); ?></h4>Projected
            </td>

        </tr>

        </tbody>

    </table>
<?php } ?>
<?php
/****************************************************************************************/
/*****************************Add new payment code*************************************/
/**************************************************************************************/
if (isset($_POST['add_payment_submit'])) {
    $appointment_id = $_POST['appointment_id'];
    $company_id = $_POST['company_id'];
    $payment_type = $_POST['payment_type'];
    $payment_amount = $_POST['payment_amount'];
    $payment_time = time();
    $created_date = date('Y-m-d');
    $ip_address = $_SERVER['REMOTE_ADDR'];


    $appoint_details = $db->get_row('appointments', array('id' => $appointment_id));
    $balance = $appoint_details['balance'];
    $service_cost = $appoint_details['service_cost'];

    $empt_fields = $fv->emptyfields(array('Select apointment' => $appointment_id,
        'Select company' => $company_id,
        'Select payment type' => $payment_type,
        'Enter Payment amount' => $payment_amount,
    ), NULL);
    if ($empt_fields) {

        $return['msg'] = '<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
     <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
     Oops! Following fields are empty<br>' . $empt_fields . '</div>';
        $return['error'] = true;
        echo json_encode($return);

    } elseif ($payment_amount > $balance) {
        $return['msg'] = '<div class="alert alert-danger text-danger"><i class="fa fa-frown-o text-danger"></i>
    <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
    Payment amount should be less than balance remaining.
    <br>Remaining balance is ' . CURRENCY . "" . $balance . '
    </div>';
        $return['error'] = true;
        echo json_encode($return);
    } else {
        $insert = $db->insert('payments', array('company_id' => $company_id,
            'appointment_id' => $appointment_id,
            'payment_amount' => $payment_amount,
            'payment_time' => $payment_time,
            'payment_type' => $payment_type,
            'created_date' => $created_date,
            'ip_address' => $ip_address));

        $last_cusid = $db->insert_id;


        if ($insert) {

            $new_balance = $balance - $payment_amount;
            $update = $db->update('appointments', array('balance' => $new_balance), array('id' => $appointment_id));


            $sql = "SELECT SUM(payment_amount) FROM `payments` WHERE `appointment_id`='$appointment_id'";
            $payment_sum = $db->run($sql)->fetchColumn();

            if ($payment_sum == $service_cost) {
                $update = $db->update('appointments', array('payment_status' => 'paid'), array('id' => $appointment_id));
            } else {
                $update = $db->update('appointments', array('payment_status' => 'half_paid'), array('id' => $appointment_id));
            }
            $return['msg'] = '<div class="alert alert-success text-success">
    <i class="fa fa-smile-o"></i> <button class="close" data-dismiss="alert" type="button">
    <i class="fa fa-times-circle-o"></i></button> Payment successfully.
    <br>Remaining balance is ' . CURRENCY . "" . $new_balance . '
    </div>';
            $return['error'] = false;
            echo json_encode($return);

        }
    }
}
?>
<?php
/****************************************************************************************/
/*****************************Add new Notification code*************************************/
/**************************************************************************************/
if (isset($_POST['add_notification_submit'])) {
    $notification_date = $_POST['notification_date'];
    $notification = $_POST['notification'];
    $company_id = $_POST['company_id'];
    $visibility_status = 'active';
    $created_date = date('Y-m-d');
    $ip_address = $_SERVER['REMOTE_ADDR'];


    $empty = $fv->emptyfields(array('Date' => $notification_date,
        'Notification Description' => $notification), NULL);
    if ($empty) {
        $return['msg'] = '<div class="alert alert-danger text-danger">
        <i class="fa fa-frown-o text-danger"></i>
        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
        ' . $empty . '
        </div>';
        $return['error'] = true;
        echo json_encode($return);

    } else {
        $insert = $db->insert('memo_notice', array('company_id' => $current_login_comopany_id,
            'date' => $notification_date,
            'notification' => $notification,
            'visibility_status' => $visibility_status,
            'created_date' => $created_date,
            'ip_address' => $ip_address));

        $last_cusid = $db->insert_id;
        if ($insert) {

            $return['msg'] = '<div class="alert alert-success text-success">
            <i class="fa fa-smile-o"></i> <button class="close" data-dismiss="alert" type="button">
            <i class="fa fa-times-circle-o"></i></button> Memo Notice Add Successfully.
            </div>';
            $return['error'] = false;
            echo json_encode($return);


        }
    }
}


if (isset($_POST['add_notes_submit'])) {
    $start_date = date("Y-m-d", strtotime($_POST['start_date']));
    $end_date = date("Y-m-d", strtotime($_POST['end_date']));
    $notification = $_POST['notification'];


    $empty = $fv->emptyfields(array('Select Start Date' => $start_date,
        'Select End Date' => $end_date,
        'Notification Description' => $notification), NULL);
    if ($empty) {

        $return['msg'] = '<div class="alert alert-danger text-danger">
        <i class="fa fa-frown-o text-danger"></i>
        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
        ' . $empty . '
        </div>';
        $return['error'] = true;
        echo json_encode($return);

    } else {

        if (isset($_POST['note_id']) && !empty($_POST['note_id'])) {

            $id = $_POST['note_id'];
            // print_r($end_date);
            // print_r($start_date);exit;
            // $update = $db->run("UPDATE `notes` SET `notes` = '".$notification."', `start` = '".$start_date."', `end` = '".$end_date."' WHERE `notes`.`id` = ".$_POST['note_id'].";")->fetch();

            $update = $db->update('notes', array('notes' => $notification,
                'start' => $start_date,
                'end' => $end_date),
                array('id' => $id));

            if ($update) {
                $return['msg'] = '<div class="alert alert-success text-success">
                <i class="fa fa-smile-o"></i> <button class="close" data-dismiss="alert" type="button">
                <i class="fa fa-times-circle-o"></i></button> Memo Notice Edited Successfully.
                </div>';
                $return['error'] = false;
                echo json_encode($return);
            }

        } else {
            $insert = $db->insert('notes', array('notes' => $notification,
                'start' => $start_date,
                'end' => $end_date));

            // $last_cusid=$db->insert_id;
            if ($insert) {

                $return['msg'] = '<div class="alert alert-success text-success">
                <i class="fa fa-smile-o"></i> <button class="close" data-dismiss="alert" type="button">
                <i class="fa fa-times-circle-o"></i></button> Memo Notice Add Successfully.
                </div>';
                $return['error'] = false;
                echo json_encode($return);
            }
        }
    }


}


if (isset($_POST['cal_note'])) {
    $id = $_POST['id'];

    // $delete=$db->delete('appointments',array('id'=>$appointment_id));

    $delete = $db->delete('notes', array('id' => $id));

    if ($delete) {
        $result['error'] = false;
        echo json_encode($result);
    }

}

if (isset($_POST['edit_note'])) {
    $id = $_POST['id'];

    // $delete=$db->delete('appointments',array('id'=>$appointment_id));

    $delete = $db->delete('notes', array('id' => $id));

    if ($delete) {
        $result['error'] = false;
        echo json_encode($result);
    }

}


?>

<?php
if (isset($_POST['razorpay_payment_id'])) {
    $transid = $_POST['razorpay_payment_id'];
    $plan_id = $_POST['plan_id'];
    $plan_price = $_POST['total_amount'];
    $company_id = $_POST['company_id'];
    $invoice_number = $_POST['invoice_number'];

    $plan_detail = $db->get_row('plans', array('id' => $plan_id));
    $plan_name = $plan_detail['plan_name'];
    $allow_staff = $plan_detail['allow_staff'];

    $company_details = $db->get_row('company', array('id' => $company_id));


    if (!$db->exists('plans_company', array('company_id' => $company_id))) {

        $plan_update = $db->insert('plans_company', array('plan_id' => $plan_id,
            'plan_name' => $plan_name,
            'price' => $plan_price,
            'company_id' => $company_id,
            'allow_staff' => $allow_staff,
            'created_date' => date('Y-m-d'),
            'ip_address' => $_SERVER['REMOTE_ADDR']));

        $insert_allplan_table = $db->insert('plans_all', array('plan_id' => $plan_id,
            'plan_name' => $plan_name,
            'price' => $plan_price,
            'company_id' => $company_id,
            'allow_staff' => $allow_staff,
            'created_date' => date('Y-m-d'),
            'payment_gateway' => 'razorpay',
            'txn_id' => $transid,
            'invoice_no' => $invoice_number,
            'ip_address' => $_SERVER['REMOTE_ADDR']));
    } else {
        $plan_update = $db->update('plans_company', array('plan_id' => $plan_id,
            'plan_name' => $plan_name,
            'price' => $plan_price,
            'allow_staff' => $allow_staff,
            'created_date' => date('Y-m-d'),
            'ip_address' => $_SERVER['REMOTE_ADDR']), array('company_id' => $company_id));

        $insert_allplan_table = $db->insert('plans_all', array('plan_id' => $plan_id,
            'plan_name' => $plan_name,
            'price' => $plan_price,
            'company_id' => $company_id,
            'allow_staff' => $allow_staff,
            'created_date' => date('Y-m-d'),
            'payment_gateway' => 'razorpay',
            'txn_id' => $transid,
            'invoice_no' => $invoice_number,
            'ip_address' => $_SERVER['REMOTE_ADDR']));


    }

    if ($plan_update) {

        echo '<div class="alert alert-mint media fade in">
      <button aria-hidden="true" data-dismiss="alert" class="close" type="button">�</button>
      <div class="media-left">
      <span class="icon-wrap icon-wrap-xs icon-circle alert-icon">
      <i class="fa fa-smile-o fa-lg"></i>
      </span>
      </div>
      <div class="media-body">
      <h4 class="alert-title">Payment with razorpay successfully and plan update!</h4>
      <p class="alert-message"> Your txn id is ' . $transid . '</p>
      </div>
      </div>';


    }


}
?>
