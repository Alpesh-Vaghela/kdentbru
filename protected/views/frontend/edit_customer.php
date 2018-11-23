<style>
    .valueToDateContent {
        color: #555555;
        float: left;
        margin-top: 5px;
        width: 78%;
        height: 116px;
        border: 1px solid #C0C0C0;
        position: relative;
        line-height: 1;
        text-align: center;
        padding-top: 15px;
        overflow: hidden;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }

    .widgetbox-data-left > div {
        margin-bottom: 5px;
    }
</style>
<?php
//echo CURRENT_LOGIN_COMPANY_ID;
$current_tab = $_COOKIE['current_tab'];
if ($current_tab != "appointment" && $current_tab != "notes" && $current_tab != "stats" && $current_tab != "anamnesis" && $current_tab != "care_plan") {
    $current_tab = "appointment";
}
if (isset($_REQUEST['action_edit'])) {
    $edit_id = $_REQUEST['action_edit'];
    $customer_detail = $db->get_row('customers', array('id' => $edit_id));
}
if (isset($_REQUEST['action_update'])) {
    $appointment_id = $_REQUEST['action_update'];
    $visit_done = VISIT_DONE;
    $update = $db->update('appointments', array('status' => '$visit_done', 'ip_address' => $_SERVER['REMOTE_ADDR']), array('id' => $appointment_id));
    $customer_details = $db->get_all('appointments', array('id' => $appointment_id));
    $display_msg = '<div class="alert alert-success text-success">
    <i class="fa fa-smile-o"></i>
    <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
    Updated Successfully.
    </div>';
    echo "<script>
    setTimeout(function(){
        window.location = '" . $link->link("edit_customer", user, '&action_edit=' . $customer_details[0]['customer_id']) . "'
    },3000);</script>";
}

if (isset($_REQUEST['action_delete'])) {
    $delete_id = $_REQUEST['action_delete'];

    $display_msg = '<form method="POST" action="">
    <div class="alert alert-danger">
    <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
    Are you sure ? You want to delete this .
    <input type="hidden" name="del_id" value="' . $delete_id . '" >
    <button name="yes" type="submit" class="btn btn-success btn-xs"  aria-hidden="true"><i class="fa fa-check-circle-o fa-2x"></i></button>
    <button name="no" type="submit" class="btn btn-danger btn-xs" aria-hidden="true"><i class="fa fa-times-circle-o fa-2x"></i></button>
    </div>
    </form>';
    if (isset($_POST['yes'])) {
        $appont_details = $db->get_row('appointments', array('id' => $_POST['del_id']));

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
        $company_id = $appont_details['company_id'];

        $delete = $db->delete('appointments', array('id' => $_POST['del_id']));
        if ($delete) {
            $event = "<b>Canceled appt.</b>  " . $first_name . " " . $last_name . " for a " . $service_name . "<br>
            on " . date('d M Y', strtotime($appointment_date)) . "@" . date('h:i:s a', strtotime($appointment_time)) . " w/ " . $staff_first_name . " " . $staff_last_name;
            $db->insert('activity_logs', array('user_id' => $_SESSION['user_id'],
                'event_type' => 'appointment_deleted',
                'event' => $event,
                'company_id' => $company_id,
                'event_type_id' => $_POST['del_id'],
                'created_date' => date('Y-m-d'),
                'ip_address' => $_SERVER['REMOTE_ADDR']


            ));
//   $db->debug();
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

                    $subject = "Appointment Scheduled for " . date('d M Y', strtotime($appointment_date)) . " " . date('h:i:s a', strtotime($appointment_time)) . " with " . $staff_first_name . " " . $staff_last_name . " is Cancelled";

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

                    $subject = "Appointment Scheduled on " . date('d M Y', strtotime($appointment_date)) . " " . date('h:i:s a', strtotime($appointment_time)) . " with " . $first_name . " " . $last_name . "  is Cancelled";

                    $confirm = mail($staff_email, $subject, $staff_delete_appointment_email_body, $headers);
                }
            }
            if ($confirm == 1) {
                $display_msg = '<div class="alert alert-success text-success">
                        <i class="fa fa-smile-o"></i>
                        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
                        Appointment Delete Successfully and mail send.
                        </div>';
                echo "<script>
                        setTimeout(function(){
                         window.location = '" . $link->link("edit_customer", user, '&action_edit=' . $edit_id) . "'
                     },3000);</script>";
            } else {
                $display_msg = '<div class="alert alert-success text-success">
                    <i class="fa fa-smile-o"></i>
                    <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
                    Appointment Delete Successfully.
                    </div>';
                echo "<script>
                    setTimeout(function(){
                     window.location = '" . $link->link("edit_customer", user, '&action_edit=' . $edit_id) . "'
                 },3000);</script>";
            }
        }
    } elseif (isset($_POST['no'])) {
        $session->redirect('edit_customer&action_edit=' . $edit_id, user);
    }

}
if (isset($_POST['notes_submit'])) {

    $notes_description = htmlentities($_POST['notes_description']);
    $notes_update = $db->update('customers', array('notes' => $notes_description), array('id' => $edit_id));
    if ($notes_update) {
        $event = "<b>Paziente</b>  " . ucfirst($customer_detail['first_name']) . " " . ucfirst($customer_detail['last_name']) . "- informazioni di contatto modificate";
        $db->insert('activity_logs', array('user_id' => $_SESSION['user_id'],
            'event_type' => 'customer_updated',
            'event' => $event,
            'event_type_id' => $edit_id,
            'created_date' => date('Y-m-d'),
            'ip_address' => $_SERVER['REMOTE_ADDR']

        ));
        $display_msg = '<div class="alert alert-success text-success">
        <i class="fa fa-smile-o"></i>
        <button class="close" data-dismiss="alert" type="button">
        <i class="fa fa-times-circle-o"></i></button>
        Success! Data Updated.
        </div>';

        echo "<script>
        setTimeout(function(){
            window.location = '" . $link->link("edit_customer", user, '&action_edit=' . $edit_id) . "'
        },3000);</script>";
    }
}
if (isset($_POST['care_plan_submit'])) {

    $care_plan = $_POST['care_plan'];
    $date = $_POST['date'];
    $customer_id = $_POST['customer_id'];
    $note = $_POST['note'];
    $care_note_update = $db->insert('care_plan', array('care_plan' => $care_plan, 'date' => $date, 'customer_id' => $customer_id, 'created_at' => date("Y-m-d H:i:s"), 'note' => $note));
    if ($care_note_update) {
        $event = "<b>Customer</b>  " . ucfirst($customer_detail['first_name']) . " " . ucfirst($customer_detail['last_name']) . "'s care plan has been updated";
        $db->insert('activity_logs', array('user_id' => $_SESSION['user_id'],
            'event_type' => 'customer_care_plan added',
            'event' => $event,
            'event_type_id' => $edit_id,
            'created_date' => date('Y-m-d'),
            'ip_address' => $_SERVER['REMOTE_ADDR']

        ));
        $display_msg = '<div class="alert alert-success text-success">
        <i class="fa fa-smile-o"></i>
        <button class="close" data-dismiss="alert" type="button">
        <i class="fa fa-times-circle-o"></i></button>
        Success! Data Updated.
        </div>';

        echo "<script>
        setTimeout(function(){
            window.location = '" . $link->link("edit_customer", user, '&action_edit=' . $edit_id) . "'
        },3000);</script>";
    }
}

if (isset($_POST["care_plan_update"])) {

    $care_plan = $_POST['update_care_plan'];
    $date = $_POST['update_date'];
    $plan_id = $_POST['plan_id'];
    $note = $_POST['note'];

    $care_note_update = $db->update('care_plan', array('care_plan' => $care_plan, 'date' => $date, 'note' => $note), array('id' => $plan_id));
    if ($care_note_update) {
        $event = "<b>Customer</b>  " . ucfirst($customer_detail['first_name']) . " " . ucfirst($customer_detail['last_name']) . "'s care plan has been updated";
        $db->insert('activity_logs', array('user_id' => $_SESSION['user_id'],
            'event_type' => 'customer_care_plan updated',
            'event' => $event,
            'event_type_id' => $edit_id,
            'created_date' => date('Y-m-d'),
            'ip_address' => $_SERVER['REMOTE_ADDR']

        ));
        $display_msg = '<div class="alert alert-success text-success">
        <i class="fa fa-smile-o"></i>
        <button class="close" data-dismiss="alert" type="button">
        <i class="fa fa-times-circle-o"></i></button>
        Success! Data Updated.
        </div>';

        echo "<script>
        setTimeout(function(){
            window.location = '" . $link->link("edit_customer", user, '&action_edit=' . $edit_id) . "'
        },3000);</script>";
    }
}

if (isset($_POST['add_contact_form_submit'])) {
    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $mobile_pre_code = $_POST['mobile_pre_code'];
    $mobile_number = $_POST['mobile_number'];
    $office_phone_number = $_POST['office_phone_number'];
    $home_phone_number = $_POST['home_phone_number'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $pathology = $_POST['pathology'];

    $reg = $_POST['regular'];

// print_r($reg);

    $anamnesis = $_POST['anamnesis'];
    $customer_profilepic = $_FILES['customer_profilepic'];


    $cid = CURRENT_LOGIN_COMPANY_ID;
    $created_date = date('Y-m-d');
    $ip_address = $_SERVER['REMOTE_ADDR'];
//  $visibility_status=$_POST['visibility_status'];

    if ($customer_detail['email'] != "") {
        $sql = " SELECT email FROM `customers` WHERE `email`='$email' AND `company_id`='$cid' AND `id`!='$edit_id'";
        $exist_email_check = $db->run($sql)->fetchAll();
    } else {
        $exist_email_check = $db->exists('customers', array('email' => $email));
    }

    $empt_fields = $fv->emptyfields(array('First Name' => $first_name));

    if ($empt_fields) {
        $display_msg = '<div class="alert alert-danger text-danger">
    <i class="fa fa-frown-o"></i> <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
          Oops! Following fields are empty<br>' . $empt_fields . '</div>';
    } else if (!$fv->check_email($email) && $email != '') {
        $display_msg = '<div class="alert alert-danger text-danger ">
        <i class="fa fa-frown-o"></i> 
        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
        Oops! Wrong Email Format.
        </div>';
    } elseif ($exist_email_check && $email != '') {
        $display_msg = '<div class="alert alert-danger text-danger">
        <i class="fa fa-frown-o"></i> 
        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
        This email is already exist.
        </div>';
    } elseif ($customer_profilepic['name'] != '') {

        $handle = new upload($_FILES['customer_profilepic']);
        $path = SERVER_ROOT . '/uploads/company/' . CURRENT_LOGIN_COMPANY_ID . '/customers/';
        if (!is_dir($path)) {
            if (!file_exists($path)) {
                mkdir($path);
            }
        }

        if (file_exists(SERVER_ROOT . '/uploads/company/' . CURRENT_LOGIN_COMPANY_ID . '/customers/' . $customer_detail['profile_image']) && (($customer_detail['profile_image']) != '')) {
            unlink(SERVER_ROOT . '/uploads/company/' . CURRENT_LOGIN_COMPANY_ID . '/customers/' . $customer_detail['profile_image']);
        }
        $newfilename = $handle->file_new_name_body = time();
        $ext = $handle->file_src_name_ext;
        $filename = $newfilename . '.' . $ext;

        if ($handle->image_src_type == 'jpg' || $handle->image_src_type == 'jpeg' || $handle->image_src_type == 'png') {
            if ($handle->uploaded) {
                $handle->Process($path);
                if ($handle->processed) {
                    $insert = $db->update("customers", array('email' => $email,
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'mobile_number' => $mobile_number,
                        'office_phone_number' => $office_phone_number,
                        'home_phone_number' => $home_phone_number,
                        'address' => $address,
                        'city' => $city,
                        'state' => $state,
                        'zip' => $zip,
                        'pathology' => $pathology,
                        'anamnesis' => $anamnesis,
                        'profile_image' => $filename,
                        'ip_address' => $ip_address,
                        'customer_regular' => $reg), array('id' => $edit_id));
//$db->debug();
                    if ($insert) {
                        $event = "<b>Customer</b>  " . ucfirst($first_name) . " " . ucfirst($last_name) . "'s contact info has been edited";
                        $db->insert('activity_logs', array('user_id' => $_SESSION['user_id'],
                            'event_type' => 'customer_updated',
                            'event' => $event,
                            'company_id' => CURRENT_LOGIN_COMPANY_ID,
                            'event_type_id' => $edit_id,
                            'created_date' => date('Y-m-d'),
                            'ip_address' => $_SERVER['REMOTE_ADDR']

                        ));
                        $display_msg = '<div class="alert alert-success text-success">
                        <i class="fa fa-smile-o"></i>
                        <button class="close" data-dismiss="alert" type="button">
                        <i class="fa fa-times-circle-o"></i></button>
                        Success! Data Updated.
                        </div>';

                        echo "<script>
                        setTimeout(function(){
                         window.location = '" . $link->link("edit_customer", user, '&action_edit=' . $edit_id) . "'
                     },3000);</script>";


                    }
                }
            }
        }


    } elseif ($_POST['photo_webcam'] != '') {
        // ...if from photos.........
        $img = $_POST['photo_webcam'];
        $folderPath = SERVER_ROOT . '/uploads/company/' . CURRENT_LOGIN_COMPANY_ID . '/customers/';

        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);
        $fileName = uniqid() . '.png';

        $file = $folderPath . $fileName;
        file_put_contents($file, $image_base64);

        $insert = $db->update("customers", array('email' => $email,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'mobile_number' => $mobile_number,
            'office_phone_number' => $office_phone_number,
            'home_phone_number' => $home_phone_number,
            'address' => $address,
            'city' => $city,
            'state' => $state,
            'zip' => $zip,
            'pathology' => $pathology,
            'anamnesis' => $anamnesis,
            'profile_image' => $fileName,
            'ip_address' => $ip_address,
            'customer_regular' => $reg), array('id' => $edit_id));
//$db->debug();
        if ($insert) {
            $event = "<b>Customer</b>  " . ucfirst($first_name) . " " . ucfirst($last_name) . "'s contact info has been edited";
            $db->insert('activity_logs', array('user_id' => $_SESSION['user_id'],
                'event_type' => 'customer_updated',
                'event' => $event,
                'company_id' => CURRENT_LOGIN_COMPANY_ID,
                'event_type_id' => $edit_id,
                'created_date' => date('Y-m-d'),
                'ip_address' => $_SERVER['REMOTE_ADDR']

            ));
            $display_msg = '<div class="alert alert-success text-success">
                        <i class="fa fa-smile-o"></i>
                        <button class="close" data-dismiss="alert" type="button">
                        <i class="fa fa-times-circle-o"></i></button>
                        Success! Data Updated.
                        </div>';

            echo "<script>
                        setTimeout(function(){
                         window.location = '" . $link->link("edit_customer", user, '&action_edit=' . $edit_id) . "'
                     },3000);</script>";


        }

    } else {

        $insert = $db->update("customers", array('email' => $email,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'mobile_number' => $mobile_number,
            'office_phone_number' => $office_phone_number,
            'home_phone_number' => $home_phone_number,
            'address' => $address,
            'city' => $city,
            'state' => $state,
            'zip' => $zip,
            'pathology' => $pathology,
            'anamnesis' => $anamnesis,
            //    'visibility_status'=>$visibility_status,
            'ip_address' => $ip_address,
            'customer_regular' => $reg), array('id' => $edit_id));
//$db->debug();
        if ($insert) {
            $event = "<b>Customer</b>  " . ucfirst($first_name) . " " . ucfirst($last_name) . "'s contact info has been edited";
            $db->insert('activity_logs', array('user_id' => $_SESSION['user_id'],
                'event_type' => 'customer_updated',
                'event' => $event,
                'company_id' => CURRENT_LOGIN_COMPANY_ID,
                'event_type_id' => $edit_id,
                'created_date' => date('Y-m-d'),
                'ip_address' => $_SERVER['REMOTE_ADDR']

            ));
            $display_msg = '<div class="alert alert-success text-success">
        <i class="fa fa-smile-o"></i>
        <button class="close" data-dismiss="alert" type="button">
        <i class="fa fa-times-circle-o"></i></button>
        Success! Data Updated.
        </div>';

            echo "<script>
        setTimeout(function(){
            window.location = '" . $link->link("edit_customer", user, '&action_edit=' . $edit_id) . "'
        },3000);</script>";


        }
    }
} ?>


<!--Page content-->
<!--===================================================-->
<div id="page-content">
    <div class="row">
        <?php echo $display_msg; ?>
        <div class="col-md-6">
            <div class="panel">
                <div class="panel-heading">
                    <div class="panel-control">
                        <a href="<?php echo $link->link('customers', user); ?>" class="btn btn-default"
                           data-click="panel-expand"><i class="fa fa-users"></i> PAZIENTI</a>
                    </div>
                    <h3 class="panel-title">Dettagli Paziente</h3>
                </div>
                <!--Horizontal Form-->
                <!--===================================================-->
                <form id="add_contact_form12" method="post" class="form-horizontal"
                      action="<?php $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                    <div class="panel-body">
                        <div class="row">


                            <div class="col-md-12">


                                <div class="form-group">
                                    <label class="control-label col-md-3">Email</label>
                                    <div class="col-md-9">
                                        <input class="form-control" placeholder="name@address.com" type="text"
                                               name="email" value="<?php echo $customer_detail['email']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Nome<font color="red">*</font></label>
                                    <div class="col-md-5">
                                        <input class="form-control" placeholder="Nome" type="text" name="first_name"
                                               value="<?php echo $customer_detail['first_name']; ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <input class="form-control" placeholder="" type="text" name="last_name"
                                               value="<?php echo $customer_detail['last_name']; ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3">Contatti</label>

                                    <div class="col-md-3">
                                        <input class="form-control" placeholder="Cellulare" type="text"
                                               name="mobile_number"
                                               value="<?php echo $customer_detail['mobile_number']; ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control" placeholder="Telefono Ufficio" type="text"
                                               name="office_phone_number"
                                               value="<?php echo $customer_detail['office_phone_number']; ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control" placeholder="Telefono Casa" type="text"
                                               name="home_phone_number"
                                               value="<?php echo $customer_detail['home_phone_number']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Indirizzo</label>
                                    <div class="col-md-9">
                                        <textarea class="form-control" placeholder="address" rows="5"
                                                  name="address"><?php echo $customer_detail['address']; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3"></label>
                                    <div class="col-md-3">
                                        <input class="form-control" placeholder="cittò" type="text" name="city"
                                               value="<?php echo $customer_detail['city']; ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control" placeholder="stato" type="text" name="state"
                                               value="<?php echo $customer_detail['state']; ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <input class="form-control" placeholder="cap" type="text" name="zip"
                                               value="<?php echo $customer_detail['zip']; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Patologie</label>
                                    <div class="col-md-9">
                                        <select class="form-control" name="pathology">
                                            <option <?php echo ($customer_detail['pathology'] == 'no') ? 'selected' : ''; ?>
                                                    value="no">No
                                            </option>
                                            <option <?php echo ($customer_detail['pathology'] == 'yes') ? 'selected' : ''; ?>
                                                    value="yes">Si
                                            </option>

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Anamnesi</label>
                                    <div class="col-md-9">
                                        <textarea class="form-control" placeholder="Inserisci patologie" rows="5"
                                                  name="anamnesis"><?php echo $customer_detail['anamnesis']; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">NUOVO PAZIENTE</label>
                                    <div class="col-md-9">
                                        <select class="form-control" name="regular">
                                            <option value="">--Seleziona--</option>
                                            <option <?php echo ($customer_detail['customer_regular'] == '1') ? 'selected' : ''; ?>
                                                    value="1">Si
                                            </option>
                                            <option <?php echo ($customer_detail['customer_regular'] == '0') ? 'selected' : ''; ?>
                                                    value="0">No
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3">Your Uploaded Image.</label>
                                    <div class="col-md-9">
                                        <?php
                                        if (file_exists(SERVER_ROOT . '/uploads/company/' . CURRENT_LOGIN_COMPANY_ID . '/customers/' . $customer_detail['profile_image']) && (($customer_detail['profile_image']) != '')) {
                                            ?>
                                            <img class="img-circle img-sm" class="img-md"
                                                 src="<?php echo SITE_URL . '/uploads/company/' . CURRENT_LOGIN_COMPANY_ID . '/customers/' . $customer_detail['profile_image'] . "?" . rand(0, 100000); ?>">
                                        <?php } else { ?>
                                            <!-- <img class="img-circle img-sm" src="<?php //echo SITE_URL.'/assets/frontend/default_image/default_user_image.png';?>" alt="Foto Profilo">-->
                                        <?php } ?>

                                        &nbsp; <span><a href="#" style="font-size:15px;"><i
                                                        class="fa fa-camera"></i></a></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4">Add A New Photo</label>
                                    <div class="col-md-6 file_input">
                                        <select class="form-control" onclick="show_method(this.value)">
                                            <option>Select One..</option>
                                            <option value="1">Upload From Photos</option>
                                            <option value="2">Upload from WebCam</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group" id="photo_pc" style="display: none;">
                                    <label class="control-label col-md-4">Foto</label>
                                    <div class="col-md-6 file_input">
                                        <input type="file" name="customer_profilepic" id="customer_profilepic"
                                               placeholder="Upload Image" class="form-control">
                                    </div>
                                </div>
                                <div class="row" id="photo_cam" style="display: none;">
                                    <div class="col-md-6">
                                        <div id="my_camera"></div>
                                        <br/>
                                        <input type=button value="Take Snapshot" onClick="take_snapshot()">
                                        <input type="hidden" name="photo_webcam" class="image-tag">
                                    </div>
                                    <div class="col-md-6">
                                        <div id="results">Your captured image will appear here...</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel-footer text-center">

                        <button class="btn btn-custom" name="add_contact_form_submit"
                                id="add_contact_form_submit_id12121" type="submit"><i class="fa fa-save"></i> Salva
                        </button>
                    </div>

                </form>

            </div>
        </div>
        <div class="col-lg-6">
            <!--Default Tabs (Left Aligned)-->
            <!--===================================================-->
            <div class="tab-base">
                <!--Nav Tabs-->
                <ul class="nav nav-tabs">
                    <li tab="appointment" class="set_cookie <?php if ($current_tab == 'appointment') {
                        echo 'active';
                    } ?>">
                        <a data-toggle="tab" href="#demo-lft-tab-1"> APPUNTAMENTI</a>
                    </li>
                    <li tab="notes" class="set_cookie <?php if ($current_tab == 'notes') {
                        echo 'active';
                    } ?>">
                        <a data-toggle="tab" href="#demo-lft-tab-2">NOTE</a>
                    </li>
                    <li tab="stats" class="set_cookie <?php if ($current_tab == 'stats') {
                        echo 'active';
                    } ?>">
                        <a data-toggle="tab" href="#demo-lft-tab-3">STATISTICHE</a>
                    </li>
                    <li tab="anamnesis" class="set_cookie <?php if ($current_tab == 'anamnesis') {
                        echo 'active';
                    } ?>">
                        <a data-toggle="tab" href="#demo-lft-tab-4">ANAMNESI</a>
                    </li>
                    <li tab="care_plan" class="set_cookie <?php if ($current_tab == 'care_plan') {
                        echo 'active';
                    } ?>">
                        <a data-toggle="tab" href="#demo-lft-tab-5">PIANO di CURA</a>
                    </li>
                </ul>
                <!--Tabs Content-->
                <div class="tab-content">
                    <?php if ($current_tab == 'appointment') {
                        if ($_SESSION['user_type'] == "admin") {
                            $appointment_count = $db->get_count('appointments', array('customer_id' => $edit_id));
                            $sql = "SELECT SUM(service_cost) FROM `appointments` WHERE `customer_id`='$edit_id'";
                            $appointment_cost = $db->run($sql)->fetchColumn();
                            $db->order_by = 'id DESC';
                            $appointments = $db->get_all('appointments', array('customer_id' => $edit_id));
                        } else {
                            $appointment_count = $db->get_count('appointments', array('customer_id' => $edit_id, 'private' => 'no'));
                            $sql = "SELECT SUM(service_cost) FROM `appointments` WHERE `customer_id`='$edit_id' AND `private`='no'";
                            $appointment_cost = $db->run($sql)->fetchColumn();
                            $db->order_by = 'id DESC';
                            $appointments = $db->get_all('appointments', array('customer_id' => $edit_id, 'private' => 'no'));
                        }
                        //$appointments = $db->get_all('appointments'); // remove this
                        ?>
                        <h4 class="text-thin">
                            <button type="button" class="btn btn-custom" data-toggle="modal"
                                    data-target="#myModal_add_appointment"><i class="fa fa-plus"></i></button>
                            &nbsp;&nbsp;&nbsp;<?php echo $appointment_count; ?>
                            appointments. <?php if ($appointment_cost != NULL) {
                                echo CURRENCY . "" . $appointment_cost;
                            } ?></h4>

                        <div id="delete_appointment_modal_message"></div>
                        <table class="table table-hover table-vcenter">
                            <thead>
                            <tr>
                                <th width="10%">&nbsp;</th>
                                <th width="45%">&nbsp;</th>
                                <th width="30%">&nbsp;</th>
                                <th width="15%">&nbsp;</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if (is_array($appointments)) {
                                foreach ($appointments as $appoint) {
                                    $customer_details = $db->get_all('customers', array('id' => $appoint['customer_id']));
                                    $pathology = ($customer_details[0]['pathology'] == 'yes') ? '***' : '';
                                    $service_provider_firstname = $db->get_var('users', array('user_id' => $appoint['staff_id']), 'firstname');
                                    $service_provider_lastname = $db->get_var('users', array('user_id' => $appoint['staff_id']), 'lastname');
                                    $service_name = $db->get_var('services', array('id' => $appoint['service_id']), 'service_name');

                                    $appointment_id = $appoint['id'];
                                    $sql = "SELECT SUM(payment_amount) FROM `payments` WHERE `appointment_id`='$appointment_id'";
                                    $payment_sum_advance = $db->run($sql)->fetchColumn();
                                    if ($payment_sum_advance == NULL) {
                                        $payment_sum_advance = 0;
                                    }
                                    $customer_name = $appoint['customer_name'];
                                    ?>
                                    <tr>
                                        <td>
                                            <?php if ($appoint['status'] == "pending") { ?>
                                                <button data-toggle="modal" data-target="#myModal_edit_appointment"
                                                        data="<?php echo $appoint['id']; ?>"
                                                        class="edit_modal_edit_customer btn btn-default btn-icon btn-circle icon-lg fa fa-calendar"></button>
                                            <?php } else { ?>
                                                <button data-toggle="modal"
                                                        class=" btn btn-default btn-icon btn-circle icon-lg fa fa-calendar"></button>
                                            <?php } ?>
                                            <?php if ($appoint['private'] == "yes") { ?>
                                                <span class="label label-danger">Categoria ROSSO</span>
                                            <?php } ?>
                                        </td>
                                        <td><?php echo date('D d M, Y', strtotime($appoint['appointment_date'])); ?>
                                            (<?php echo date('H:i:s', strtotime($appoint['appointment_time'])) . "-" . date('H:i:s', strtotime($appoint['appointment_end_time'])); ?>
                                            )
                                            <br><?php echo ucwords($service_provider_firstname . " " . $service_provider_lastname); ?>
                                            .Nome Paziente: <?php echo $customer_name . $pathology; ?>
                                            . <?php echo ucfirst($service_name); ?>
                                            . <?php echo $appoint['service_time'] + $appoint['service_buffer_time'] ?>
                                            min . <?php echo CURRENCY . "" . $appoint['service_cost'] ?>
                                        </td>
                                        <td>
                                            <?php if ($appoint['status'] == 'deleted'): ?>
                                                <p style="font-size: 12px;"><b>Cancel
                                                        Reason: </b><?php echo $appoint['cancel_reason']; ?></p>
                                                <a data-toggle="modal" data-target="#myModal_edit_appointment"
                                                   data="<?php echo $appoint['id']; ?>"
                                                   class="label label-primary edit_modal_edit_customer"
                                                   style="margin-top: 10px;margin-bottom: 10px"><i
                                                            class="fa fa-refresh"> Reschedule Appointment</i></a>
                                            <?php endif; ?>

                                            <?php if ($appoint['status'] != VISIT_IN_PRECESS && $appoint['status'] != VISIT_DONE && $appoint['status'] != 'deleted') { ?>
                                                <a class="label label-info"
                                                   href="<?php echo $link->link("edit_customer", user, '&action_update=' . $appointment_id); ?>"><i
                                                            class="fa fa-edit">PAZIENTE ARRIVATO</i></a>
                                            <?php } ?>
                                            <?php if ($appoint['status'] == "pending") {
                                                if (strtotime($appoint['appointment_date'] . " " . $appoint['appointment_time']) > strtotime(date('Y-m-d H:i'))) {
                                                    ?>
                                                    <!--  <a href="#" data-toggle="modal" data-target="#myModal_assign_room" data="<?php echo $appoint['id']; ?>" class="assign_room_button label label-warning pull-right"     ><i class="fa fa-check-circle-o"></i>Assign Room</a>   -->
                                                <?php } else {
                                                    if ($appoint['status'] != 'deleted') {
                                                        ?>
                                                        <span class="label label-danger">Running late</span><br>
                                                        <a data-toggle="modal" data-target="#myModal_edit_appointment"
                                                           data="<?php echo $appoint['id']; ?>"
                                                           class="label label-primary edit_modal_edit_customer"
                                                           style="margin-top: 10px;margin-bottom: 10px"><i
                                                                    class="fa fa-refresh"> Reschedule
                                                                Appointment</i></a>
                                                    <?php }
                                                }
                                                ?>

                                            <?php } else {
                                                if ($appoint['status'] != 'deleted') {
                                                    ?>
                                                    <span class="label label-<?php if ($appoint['status'] == "pending") {
                                                        echo "warning";
                                                    } else {
                                                        echo "success";
                                                    } ?> class-<?php echo $appoint['id']; ?>"><i class="fa fa-tag"></i>
                                                        <?php
                                                        if ($appoint['status'] == VISIT_DONE)
                                                            echo "Visita ESEGUITA";
                                                        else
                                                            echo "Visita in CORSO";
                                                        ?>
                                                </span>
                                                <?php } ?>
                                                <br>
                                                <?php if ($appoint['status'] == "confirmed") { ?>
                                                    <!--                                                   <span class="label label-info">Assigned Room: <?php echo ucwords($db->get_var('rooms', array('id' => $appoint['assigned_room']), 'name')); ?></span>
    <a href="#" data-toggle="modal" data-target="#myModal_assign_room" data="<?php echo $appoint['id']; ?>" class="assign_room_button  pull-right"   >(Click to Re-assign Room)</a>-->
                                                <?php } ?>


                                                <?php if ($appoint['payment_status'] == "unpaid") {
                                                    if ($appoint['status'] != 'deleted') { ?>
                                                        <a href="#" data-toggle="modal" data-target="#myModal_payment"
                                                           class="load_payment_details" id="load_payment_details"
                                                           data_id="<?php echo $appoint['id']; ?>"
                                                           data_booking_id="<?php echo $appoint['booking_id']; ?>"
                                                           data_booking_date="<?php echo date(COMMON_DATE_FORMAT, strtotime($appoint['appointment_date'])); ?>"
                                                           data_customer="<?php echo ucwords($customer_name); ?>"
                                                           data_service_name="<?php echo ucwords($service_name); ?>"
                                                           data_payment_sum_advance="<?php echo ucwords($payment_sum_advance); ?>"
                                                           data_service_cost="<?php echo $appoint['service_cost'] ?>"
                                                           data_balance="<?php echo $appoint['balance'] ?>">(Aggiungi PAGAMENTO)</a>
                                                    <?php }
                                                } else { ?>
                                                    <span class="label label-success"><i class="fa fa-check"></i> SALDATO</span>

                                                <?php } ?>
                                            <?php } ?> </td>
                                        <td>
                                            <?php if ($appoint['status'] != 'deleted') { ?>
                                                <a data-toggle="modal" data-target="#myModal_edit_appointment"
                                                   data="<?php echo $appoint['id']; ?>"
                                                   class="edit_modal_edit_customer"><i
                                                            class="fa fa-edit fa-2x text-info"></i></a>
                                                <a data-toggle="modal" data-target="#myModal_cancel_appointment"
                                                   data="<?php echo $appoint['id']; ?>"
                                                   class="cancel_modal_cancel_customer"><i
                                                            class="fa fa-trash fa-2x text-danger"></i></a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php }
                            } ?>
                            </tbody>
                        </table>
                    <?php } elseif ($current_tab == 'notes') { ?>
                        <h4 class="text-thin">Note</h4>
                        <form action="" method="post">
                            <div class="row">
                                <div class="col-md-12">
                                    <textarea id="demo-summernote"
                                              name="notes_description"><?php echo html_entity_decode($customer_detail['notes']); ?></textarea>
                                </div>
                                <div class="col-md-12">
                                    <button class="btn btn-custom pull-right" type="submit" name="notes_submit">invia
                                    </button>
                                </div>
                            </div>


                        </form>
                    <?php } elseif ($current_tab == 'stats') { ?>
                        <div class="form-group">
                            <!--  <div class="row">
                             <div class="col-md-1"></div>
                               <div class="col-md-2">
                                   <h5>Choose Year</h5>
                                   <select class="form-control" name="year">
                                        <option value="2016">2016</option>
                                    </select>
                               </div>
                               <div class="col-md-2">
                                   <h5>Choose Month</h5>
                                   <select class="form-control" name="month">
                                        <option value="all">All</option>
                                        <option value="dec">DEC</option>
                                    </select>
                               </div>
                           </div> -->
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <?php if ($_SESSION['user_type'] == "admin") { ?>
                                    <h3>BLU</h3>
                                <?php } ?>
                                <div class="widgetbox widgetbox-default widgetbox-item-icon valueToDateContent">
                                    <div class="widgetbox-data-left text-left" style="padding-right: 21px;">
                                        <?php
                                        $sql = "SELECT SUM(`service_cost`) FROM `appointments` WHERE `customer_id`='$edit_id' AND `private`='no'";

                                        $sql2 = "SELECT SUM(`balance`) FROM `appointments` WHERE `customer_id`='$edit_id' AND `private`='no'";
                                        $appointment_cost = $db->run($sql)->fetchColumn();
                                        $bal = $db->run($sql2)->fetchColumn();

                                        ?>
                                        <p>Importo fino ad oggi</p>
                                        <div>
                                            <strong>Totale:</strong>
                                            <?php echo CURRENCY . "" . number_format($appointment_cost, 2, '.', ','); ?>
                                        </div>
                                        <div>
                                            <strong>Saldato: </strong>
                                            <?php echo CURRENCY . "" . number_format(($appointment_cost - $bal), 2, '.', ','); ?>
                                        </div>
                                        <div>
                                            <strong>Bilancio: </strong>
                                            <?php echo CURRENCY . "" . number_format($bal, 2, '.', ','); ?></div>

                                    </div>
                                </div>
                                <br>
                                <div class="widgetbox widgetbox-default widgetbox-item-icon valueToDateContent">
                                    <div class="widgetbox-data-left" style="padding-right: 21px;">
                                        <?php $appointment_count = $db->get_count('appointments', array('customer_id' => $edit_id, 'private' => 'no'));
                                        $sql = "SELECT SUM(service_cost) FROM `appointments` WHERE `customer_id`='$edit_id' AND `private`='no'";
                                        $appointment_cost = $db->run($sql)->fetchColumn();
                                        $average_purchase = $appointment_cost / $appointment_count;
                                        ?>
                                        <p>Spesa Media</p>
                                        <div class="widgetbox-int" style="text-align: center;">
                                            <?php echo CURRENCY . "" . number_format($average_purchase, 2, '.', ','); ?></div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <?php if ($_SESSION['user_type'] == "admin") { ?>
                                    <h3>ROSSO</h3>
                                    <div class="widgetbox widgetbox-default widgetbox-item-icon valueToDateContent">
                                        <div class="widgetbox-data-left text-left" style="padding-right: 21px;">
                                            <?php
                                            $sql = "SELECT SUM(`service_cost`) FROM `appointments` WHERE `customer_id`='$edit_id' AND `private`='yes'";

                                            $sql2 = "SELECT SUM(`balance`) FROM `appointments` WHERE `customer_id`='$edit_id' AND `private`='yes'";
                                            $appointment_cost = $db->run($sql)->fetchColumn();
                                            $bal = $db->run($sql2)->fetchColumn();
                                            ?>
                                            <p>Importo fino ad oggi</p>
                                            <div class="">
                                                <strong>Totale: </strong>
                                                <?php echo CURRENCY . "" . number_format($appointment_cost, 2, '.', ','); ?>
                                            </div>
                                            <div class="">
                                                <strong>Saldato: </strong>
                                                <?php echo CURRENCY . "" . number_format(($appointment_cost - $bal), 2, '.', ','); ?>
                                            </div>
                                            <div class="">
                                                <strong>Bilancio: </strong>
                                                <?php echo CURRENCY . "" . number_format($bal, 2, '.', ','); ?></div>

                                        </div>
                                    </div>
                                    <br>
                                    <div class="widgetbox widgetbox-default widgetbox-item-icon valueToDateContent">
                                        <div class="widgetbox-data-left" style="padding-right: 21px;">
                                            <?php $appointment_count = $db->get_count('appointments', array('customer_id' => $edit_id, 'private' => 'yes'));
                                            $sql = "SELECT SUM(service_cost) FROM `appointments` WHERE `customer_id`='$edit_id' AND `private`='yes'";
                                            $appointment_cost = $db->run($sql)->fetchColumn();
                                            $average_purchase = $appointment_cost / $appointment_count;
                                            ?>
                                            <p>Spesa Media</p>
                                            <div class="widgetbox-int" style="text-align: center;">
                                                <?php echo CURRENCY . "" . number_format($average_purchase, 2, '.', ','); ?></div>

                                        </div>
                                    </div>
                                <?php } ?>
                            </div>

                        </div>
                    <?php } elseif ($current_tab == 'anamnesis') { ?>

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-lg-12 pathology-ana-txt">
                                <h3>Patologie:
                                    <span>
                                                <?php echo ($customer_detail['pathology'] == "yes") ? "Yes" : "No"; ?>
                                            </span>
                                </h3>
                                <h4>Anamnesi</h4>
                                <p><?php echo $customer_detail['anamnesis']; ?></p>

                            </div>
                        </div>
                    <?php } elseif ($current_tab == 'care_plan') {
                        ?>
                        <div class="col-lg-12">
                            <h4 class="text-thin">Piano di CURA</h4></div>
                        <div class="row">
                            <div class="col-md-10 col-lg-10">
                                <form action="" method="post">
                                    <div class="col-xs-12 col-md-7 col-lg-7 form-group">
                                        <input type="hidden" name="customer_id" value="<?php echo $edit_id; ?>"/>
                                        <input class="form-control" type="text" placeholder="Piano di Cura"
                                               name="care_plan"/>
                                    </div>
                                    <div class="col-xs-12 col-md-3 col-lg-3 form-group">
                                        <input class="form-control" type="text" name="date"
                                               value="<?php echo ($date != '') ? date('d-m-Y', strtotime($date)) : date('d-m-Y'); ?>"
                                               id="get_date_calender">
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-custom pull-right" type="submit" name="care_plan_submit">
                                            Invia
                                        </button>
                                    </div>
                                    <div class="col-xs-12 col-md-10 col-lg-10 form-group">
                                        <textarea name="note" placeholder="Note di Cura"
                                                  class="form-control"></textarea>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-sm-12">
                                <?php
                                $all_care_plans = $db->get_all('care_plan', array('customer_id' => $edit_id));
                                foreach ($all_care_plans as $plan) { ?>
                                    <div class="row add-app-wrapper">
                                        <div class="col-md-10 col-lg-10">
                                            <form action="" method="post">
                                                <div class="col-xs-12 col-md-7 col-lg-7 form-group">
                                                    <input type="hidden" name="plan_id"
                                                           value="<?php echo $plan['id']; ?>"/>
                                                    <input class="form-control" type="text" placeholder="Care Plan"
                                                           name="update_care_plan"
                                                           value="<?php echo $plan['care_plan']; ?>"/>
                                                </div>
                                                <div class="col-xs-12 col-md-3 col-lg-3 form-group">
                                                    <input class="form-control dynamic-date" type="text"
                                                           name="update_date" value="<?php echo $plan['date']; ?>"
                                                           id="get_date_calender">
                                                </div>
                                                <div class="col-md-2">
                                                    <button class="btn btn-custom pull-right" type="submit"
                                                            name="care_plan_update">Invia
                                                    </button>
                                                </div>
                                                <div class="col-xs-12 col-md-10 col-lg-10 form-group">
                                                    <textarea name="note"
                                                              class="form-control"><?php echo $plan['note']; ?></textarea>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-md-2" style="padding-left:0px">
                                            <?php
                                            if (!empty($plan['appointment_id']) && $plan['appointment_id'] != '0') { ?>
                                                <a class="care_plan_edit_booking btn btn-info" style="font-size: 12px;"
                                                   data-toggle="modal" data-target="#myModal_edit_booking"
                                                   data="<?php echo $plan['appointment_id']; ?>">Prenotato</a>

                                            <?php } else { ?>
                                                <a data-care_id="<?= $plan['id'] ?>"
                                                   class="btn btn-info add-app-carenote" style="font-size: 12px;"
                                                   data-toggle="modal"
                                                   data-target="#myModal_add_appointment">Prenota</a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <!--===================================================-->
            <!--End Default Tabs (Left Aligned)-->
        </div>

    </div>
</div>


<script type="text/javascript">
    // ..................webcam setting.........
    function show_method(value) {

        if (value == '1') {
            $(".image-tag").val('');
            document.getElementById('results').innerHTML = 'Your captured image will appear here...';
            document.getElementById("photo_pc").style.display = 'block';
            document.getElementById("photo_cam").style.display = 'none';

        } else if (value == '2') {
            Webcam.set({
                width: 200,
                height: 200,
                image_format: 'jpeg',
                jpeg_quality: 90
            });
            Webcam.attach('#my_camera');
            $("#customer_profilepic").val('');
            document.getElementById("photo_cam").style.display = 'block';
            document.getElementById("photo_pc").style.display = 'none';

        } else {
            document.getElementById("photo_cam").style.display = 'none';
            document.getElementById("photo_pc").style.display = 'none';
        }
    }

    function take_snapshot() {
        Webcam.snap(function (data_uri) {
            $(".image-tag").val(data_uri);

            document.getElementById('results').innerHTML = '<img src="' + data_uri + '" style="width:200px;"/>';
        });
    }

</script>





