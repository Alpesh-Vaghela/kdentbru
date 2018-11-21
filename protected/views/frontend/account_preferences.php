<?php $current_tab = $_COOKIE['current_tab'];
if ($current_tab != "preferences" && $current_tab != "export_schedule" && $current_tab != "export_revenue") {
    $current_tab = "preferences";
}
$preferences_settings_details = $db->get_row('preferences_settings', array('company_id' => CURRENT_LOGIN_COMPANY_ID));
$start_date = date('Y-m-d');
$end_date = date('Y-m-d');
?>
<?php if (isset($_POST['appointment_history_export_submit'])) {
    // print_r($_POST);
    $start_date = date('Y-m-d', strtotime($_POST['start_date']));
    $end_date = date('Y-m-d', strtotime($_POST['end_date']));;
    $service = $_POST['service'];
    $staff = $_POST['staff'];
    if ($start_date == "") {
        $display_msg = '<div class="alert alert-danger text-danger">
        <i class="fa fa-frown-o"></i>
        <button class="close" data-dismiss="alert" type="button">
        <i class="fa fa-times-circle-o"></i></button>
        Enter Start Date .
        </div>';
    } elseif (strtotime($start_date) > strtotime($end_date)) {
        $display_msg = '<div class="alert alert-danger text-danger">
        <i class="fa fa-frown-o"></i>
        <button class="close" data-dismiss="alert" type="button">
        <i class="fa fa-times-circle-o"></i></button>
        Start date Should be less than end date!.
        </div>';
    } elseif ($end_date == "") {
        $display_msg = '<div class="alert alert-danger text-danger">
        <i class="fa fa-frown-o"></i>
        <button class="close" data-dismiss="alert" type="button">
        <i class="fa fa-times-circle-o"></i></button>
        Enter End Date .
        </div>';
    } else {
        $cid = CURRENT_LOGIN_COMPANY_ID;
        $bedquery = "SELECT *
     FROM `appointments`
     WHERE `appointment_date` between '$start_date' And '$end_date' AND `company_id`='$cid'";
        if ($service != "") {
            $bedquery .= "AND service_id='$service'";
        }
        if ($staff != "") {
            $bedquery .= "AND `staff_id`='$staff'";
        }
        $bedquery .= "order by `id` DESC";
        $all_appointment_history = $db->run($bedquery)->fetchAll();


    }
    // $all_appointment_history=$db->get_all('appointments');
} ?>
<?php if (isset($_POST['revenue_export_submit'])) {
    $start_date = date('Y-m-d', strtotime($_POST['start_date']));
    $end_date = date('Y-m-d', strtotime($_POST['end_date']));;

    if ($start_date == "") {
        $display_msg = '<div class="alert alert-danger text-danger">
        <i class="fa fa-frown-o"></i>
        <button class="close" data-dismiss="alert" type="button">
        <i class="fa fa-times-circle-o"></i></button>
        Enter Start Date .
        </div>';
    } elseif (strtotime($start_date) > strtotime($end_date)) {
        $display_msg = '<div class="alert alert-danger text-danger">
        <i class="fa fa-frown-o"></i>
        <button class="close" data-dismiss="alert" type="button">
        <i class="fa fa-times-circle-o"></i></button>
        Start date Should be less than end date!.
        </div>';
    } elseif ($end_date == "") {
        $display_msg = '<div class="alert alert-danger text-danger">
        <i class="fa fa-frown-o"></i>
        <button class="close" data-dismiss="alert" type="button">
        <i class="fa fa-times-circle-o"></i></button>
        Enter End Date .
        </div>';
    } else {
        $cid = CURRENT_LOGIN_COMPANY_ID;
        $bedquery = "SELECT *
        FROM `appointments`
        WHERE `appointment_date` between '$start_date' And '$end_date' AND `company_id`='$cid' AND (`status`='visit in process' OR `status`='Visit done' OR `payment_status`='paid')";
        $bedquery .= "order by `id` DESC";
        $all_revenue = $db->run($bedquery)->fetchAll();

        $bedquery_pr = "SELECT SUM(`service_cost`)
        FROM `appointments`
        WHERE `appointment_date` between '$start_date' And '$end_date' AND `company_id`='$cid'";

        $projected_revenue_sum = $db->run($bedquery_pr)->fetchColumn();

        // $bedquery_pr="SELECT SUM(`service_cost`)
        // FROM `appointments`
        // WHERE `appointment_date` between '$start_date' And '$end_date' AND `company_id`='$cid' AND `payment_status`='unpaid' OR `payment_status`='paid'";

        $company_id = CURRENT_LOGIN_COMPANY_ID;
        $sql = "SELECT SUM(payment_amount) FROM `payments` LEFT JOIN `appointments` ON payments.appointment_id = appointments.id WHERE appointments.appointment_date between '$start_date' And '$end_date' AND payments.company_id='$cid'";

        // $payments_appointments=$db->run($sql)->fetchAll();

        $confirmed_revenue_sum = $db->run($sql)->fetchColumn();

    }
} ?>
<?php if (isset($_POST['update_preference_update_form_submit'])) {

    $default_calendar = $_POST['default_calendar'];
    $week_start_day = $_POST['week_start_day'];
    $custom_time_slot = $_POST['custom_time_slot'];
    $calendar_start_hour = $_POST['calendar_start_hour'];
    $show_calendar_stats = $_POST['show_calendar_stats'];
    $preferred_language = $_POST['preferred_language'];
    $update = $db->update('preferences_settings', array('default_calendar' => $default_calendar,
        'week_start_day' => $week_start_day,
        'custom_time_slot' => $custom_time_slot,
        'calendar_start_hour' => $calendar_start_hour,
        'show_calendar_stats' => $show_calendar_stats,
        'preferred_language' => $preferred_language
    ), array('company_id' => CURRENT_LOGIN_COMPANY_ID));
    if ($update) {
        $display_msg = '<div class="alert alert-success text-success">
        <i class="fa fa-smile-o"></i>
        <button class="close" data-dismiss="alert" type="button">
        <i class="fa fa-times-circle-o"></i></button>
        Success! Data Updated.
        </div>';

        echo "<script>
        setTimeout(function(){
         window.location = '" . $link->link("account_preferences", frontend) . "'
     },3000);</script>";
    }
} ?>
<div id="page-content">
    <div class="row">
        <div class="col-lg-12">
            <?php echo $display_msg; ?>
            <!--Stacked Tabs Left-->
            <!--===================================================-->
            <div class="tab-base tab-stacked-left">
                <!--Nav tabs-->
                <ul class="nav nav-tabs">
                    <li tab="preferences" class="set_cookie <?php if ($current_tab == 'preferences') {
                        echo 'active';
                    } ?>">
                        <a data-toggle="tab" href="#demo-stk-lft-tab-1" aria-expanded="false"> <i
                                    class="fa fa-list"></i> Preferenze</a>
                    </li>
                    <li tab="export_schedule" class="set_cookie <?php if ($current_tab == 'export_schedule') {
                        echo 'active';
                    } ?>">
                        <a data-toggle="tab" href="#demo-stk-lft-tab-2" aria-expanded="false"><i
                                    class="fa fa-download"></i> Report APPUNTAMENTI</a>
                    </li>
                    <li tab="export_revenue" class="set_cookie <?php if ($current_tab == 'export_revenue') {
                        echo 'active';
                    } ?>">
                        <a data-toggle="tab" href="#demo-stk-lft-tab-2" aria-expanded="false"><i
                                    class="fa fa-download"></i> Report INCASSI</a>
                    </li>

                </ul>
                <!--Tabs Content-->
                <div class="tab-content">
                    <?php if ($current_tab == 'preferences') { ?>

                        <h3 class="text-thin">Customize Account Appearances</h3>
                        <hr>
                        <form method="post" class="form-horizontal" action="" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Default Calendar</label>
                                        <div class="col-md-9">
                                            <select name="default_calendar" class="form-control">
                                                <option <?php if ($preferences_settings_details['default_calendar'] == "daily") {
                                                    echo "selected";
                                                } ?> value="daily"> Daily Calendar
                                                </option>
                                                <option <?php if ($preferences_settings_details['default_calendar'] == "weekly") {
                                                    echo "selected";
                                                } ?> value="weekly">Weekly Calendar
                                                </option>
                                                <option <?php if ($preferences_settings_details['default_calendar'] == "monthly") {
                                                    echo "selected";
                                                } ?> value="monthly">Monthly Calendar
                                                </option>
                                            </select>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3">Week Start Day</label>
                                        <div class="col-md-9">
                                            <select name="week_start_day" class="form-control">
                                                <option <?php if ($preferences_settings_details['week_start_day'] == "0") {
                                                    echo "selected";
                                                } ?> value="0">Sunday
                                                </option>
                                                <option <?php if ($preferences_settings_details['week_start_day'] == "1") {
                                                    echo "selected";
                                                } ?> value="1">Lunedi
                                                </option>
                                                <option <?php if ($preferences_settings_details['week_start_day'] == "2") {
                                                    echo "selected";
                                                } ?> value="2">Tuesday
                                                </option>
                                                <option <?php if ($preferences_settings_details['week_start_day'] == "3") {
                                                    echo "selected";
                                                } ?> value="3">Wednesday
                                                </option>
                                                <option <?php if ($preferences_settings_details['week_start_day'] == "4") {
                                                    echo "selected";
                                                } ?> value="4">Thursday
                                                </option>
                                                <option <?php if ($preferences_settings_details['week_start_day'] == "5") {
                                                    echo "selected";
                                                } ?> value="5">Friday
                                                </option>
                                                <option <?php if ($preferences_settings_details['week_start_day'] == "6") {
                                                    echo "selected";
                                                } ?> value="6">Saturday
                                                </option>


                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Custom Time Slot</label>
                                        <div class="col-md-9">
                                            <select name="custom_time_slot" class="form-control">
                                                <option <?php if ($preferences_settings_details['custom_time_slot'] == "5") {
                                                    echo "selected";
                                                } ?> value="5">5 Mins
                                                </option>
                                                <option <?php if ($preferences_settings_details['custom_time_slot'] == "15") {
                                                    echo "selected";
                                                } ?> value="15">15 Mins
                                                </option>
                                                <option <?php if ($preferences_settings_details['custom_time_slot'] == "30") {
                                                    echo "selected";
                                                } ?> value="30">30 Mins
                                                </option>
                                                <option <?php if ($preferences_settings_details['custom_time_slot'] == "60") {
                                                    echo "selected";
                                                } ?> value="60">60 Mins
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Calendar Start Hour</label>
                                        <div class="col-md-9">
                                            <select name="calendar_start_hour" class="form-control">

                                                <option <?php if ($preferences_settings_details['calendar_start_hour'] == "01:00:00") {
                                                    echo "selected";
                                                } ?> value="01:00:00">01:00:00 AM
                                                </option>
                                                <option <?php if ($preferences_settings_details['calendar_start_hour'] == "02:00:00") {
                                                    echo "selected";
                                                } ?> value="02:00:00">02:00:00 AM
                                                </option>
                                                <option <?php if ($preferences_settings_details['calendar_start_hour'] == "03:00:00") {
                                                    echo "selected";
                                                } ?> value="3:00:00">03:00:00 AM
                                                </option>
                                                <option <?php if ($preferences_settings_details['calendar_start_hour'] == "04:00:00") {
                                                    echo "selected";
                                                } ?> value="04:00:00">04:00:00 AM
                                                </option>
                                                <option <?php if ($preferences_settings_details['calendar_start_hour'] == "05:00:00") {
                                                    echo "selected";
                                                } ?> value="05:00:00">05:00:00 AM
                                                </option>
                                                <option <?php if ($preferences_settings_details['calendar_start_hour'] == "06:00:00") {
                                                    echo "selected";
                                                } ?> value="06:00:00">06:00:00 AM
                                                </option>
                                                <option <?php if ($preferences_settings_details['calendar_start_hour'] == "07:00:00") {
                                                    echo "selected";
                                                } ?> value="07:00:00">07:00:00 AM
                                                </option>
                                                <option <?php if ($preferences_settings_details['calendar_start_hour'] == "08:00:00") {
                                                    echo "selected";
                                                } ?> value="08:00:00">08:00:00 AM
                                                </option>
                                                <option <?php if ($preferences_settings_details['calendar_start_hour'] == "09:00:00") {
                                                    echo "selected";
                                                } ?> value="09:00:00">09:00:00 AM
                                                </option>
                                                <option <?php if ($preferences_settings_details['calendar_start_hour'] == "10:00:00") {
                                                    echo "selected";
                                                } ?> value="10:00:00">10:00:00 AM
                                                </option>
                                                <option <?php if ($preferences_settings_details['calendar_start_hour'] == "11:00:00") {
                                                    echo "selected";
                                                } ?> value="11:00:00">11:00:00 AM
                                                </option>
                                                <option <?php if ($preferences_settings_details['calendar_start_hour'] == "12:00:00") {
                                                    echo "selected";
                                                } ?> value="12:00:00">12:00:00 PM
                                                </option>
                                                <option <?php if ($preferences_settings_details['calendar_start_hour'] == "13:00:00") {
                                                    echo "selected";
                                                } ?> value="13:00:00">01:00:00 PM
                                                </option>
                                                <option <?php if ($preferences_settings_details['calendar_start_hour'] == "14:00:00") {
                                                    echo "selected";
                                                } ?> value="14:00:00">02:00:00 PM
                                                </option>
                                                <option <?php if ($preferences_settings_details['calendar_start_hour'] == "15:00:00") {
                                                    echo "selected";
                                                } ?> value="15:00:00">03:00:00 PM
                                                </option>
                                                <option <?php if ($preferences_settings_details['calendar_start_hour'] == "16:00:00") {
                                                    echo "selected";
                                                } ?> value="16:00:00">04:00:00 PM
                                                </option>
                                                <option <?php if ($preferences_settings_details['calendar_start_hour'] == "17:00:00") {
                                                    echo "selected";
                                                } ?> value="17:00:00">05:00:00 PM
                                                </option>
                                                <option <?php if ($preferences_settings_details['calendar_start_hour'] == "18:00:00") {
                                                    echo "selected";
                                                } ?> value="18:00:00">06:00:00 PM
                                                </option>
                                                <option <?php if ($preferences_settings_details['calendar_start_hour'] == "19:00:00") {
                                                    echo "selected";
                                                } ?> value="19:00:00">07:00:00 PM
                                                </option>
                                                <option <?php if ($preferences_settings_details['calendar_start_hour'] == "20:00:00") {
                                                    echo "selected";
                                                } ?> value="20:00:00">08:00:00 PM
                                                </option>
                                                <option <?php if ($preferences_settings_details['calendar_start_hour'] == "21:00:00") {
                                                    echo "selected";
                                                } ?> value="21:00:00">09:00:00 PM
                                                </option>
                                                <option <?php if ($preferences_settings_details['calendar_start_hour'] == "22:00:00") {
                                                    echo "selected";
                                                } ?> value="22:00:00">10:00:00 PM
                                                </option>
                                                <option <?php if ($preferences_settings_details['calendar_start_hour'] == "23:00:00") {
                                                    echo "selected";
                                                } ?> value="23:00:00">11:00:00 PM
                                                </option>
                                                <option <?php if ($preferences_settings_details['calendar_start_hour'] == "00:00:00") {
                                                    echo "selected";
                                                } ?> value="00:00:00">00:00:00 AM
                                                </option>


                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Show calendar stats</label>
                                        <div class="col-md-9">
                                            <select name="show_calendar_stats" class="form-control">
                                                <option <?php if ($preferences_settings_details['show_calendar_stats'] == "no") {
                                                    echo "selected";
                                                } ?> value="no">No
                                                </option>
                                                <option <?php if ($preferences_settings_details['show_calendar_stats'] == "yes") {
                                                    echo "selected";
                                                } ?> value="yes">Yes
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Preferred Language</label>
                                        <div class="col-md-9">
                                            <select name="preferred_language" class="form-control">
                                                <option <?php if ($preferences_settings_details['preferred_language'] == "en") {
                                                    echo "selected";
                                                } ?> value="en">English
                                                </option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3"></label>
                                        <div class="col-md-9">
                                            <button class="btn btn-info btn-block"
                                                    name="update_preference_update_form_submit" type="submit"><i
                                                        class="fa fa-save"></i> Update
                                            </button>
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </form>
                    <?php } elseif ($current_tab == 'export_schedule') { ?>
                        <h3 class="text-thin">Report Appuntamenti</h3>
                        <hr>
                        <form class="form-inline" action="" method="post">
                            <div class="form-group">
                                <label for="demo-inline-inputmail" class="sr-only">Dal giorno</label>
                                <input class="form-control datepicker_account_preferences" type="text"
                                       placeholder="data inizio ricerca" name="start_date" readonly="true"
                                       value="<?php echo date('d-m-Y', strtotime($start_date)); ?>">
                            </div>
                            <div class="form-group">
                                <label for="demo-inline-inputpass" class="sr-only">al giorno</label>
                                <input class="form-control datepicker_account_preferences2" type="text"
                                       placeholder="data fine ricerca" name="end_date" readonly="true"
                                       value="<?php echo date('d-m-Y', strtotime($end_date)); ?>">
                            </div>
                            <div class="form-group">
                                <label for="demo-inline-inputpass" class="sr-only">Prestazione</label>
                                <select class="form-control" name="service">
                                    <option value="">Tutte le prestazioni</option>
                                    <?php $alls = $db->get_all('services', array('visibility_status' => 'active', 'company_id' => CURRENT_LOGIN_COMPANY_ID));
                                    if (is_array($alls)) {
                                        foreach ($alls as $as) {
                                            ?>
                                            <option <?php if ($service == $as['id']) {
                                                echo 'selected';
                                            } ?> value="<?php echo $as['id'] ?>"><?php echo $as['service_name']; ?></option>
                                        <?php }
                                    } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="demo-inline-inputpass" class="sr-only">Dottori</label>

                                <select class="form-control" name="staff">
                                    <option value="">Tutti i dottori</option>
                                    <?php $alls = $db->get_all('users', array('visibility_status' => 'active', 'user_type' => 'staff', 'company_id' => CURRENT_LOGIN_COMPANY_ID));
                                    if (is_array($alls)) {
                                        foreach ($alls as $as) {
                                            ?>
                                            <option <?php if ($staff == $as['user_id']) {
                                                echo 'selected';
                                            } ?> value="<?php echo $as['user_id'] ?>"><?php echo $as['firstname'] . " " . $as['lastname']; ?></option>
                                        <?php }
                                    } ?>

                                </select>
                            </div>

                            <button class="btn btn-info" name="appointment_history_export_submit" type="submit"><i
                                        class="fa fa-file"></i> Genera risultati
                            </button>
                        </form>
                        <hr>
                        <?php if (isset($_POST['appointment_history_export_submit'])) {
                            if ($all_appointment_history != '') {
                                ?>
                                <a class="pdf btn btn-primary pull-right"
                                   href="<?php echo $link->link("pdfgenerate", user, '&report_type=appointment_history'); ?>"
                                >&nbsp;Genera PDF</a>
                                <!--        <a class="pdf btn btn-primary pull-right"  href="index.php?user=account_preferences">&nbsp;REPORT APPUNTAMENTI</a>-->

                            <?php }
                            $html = "<table style='width:100%;text-align:center;'>
           <tr><td><h3 style='text-align:center;'>Elenco Appuntamenti<br>
           <small>" . strtoupper(SITE_NAME) . "<br>
//           As at " . date(DATE_FORMAT) . "</small>
           </td></tr>
           </table>";


                            $html .= "<table class='table table-striped table-bordered' id='demo-dt-basic' style='width:100%'>
           <thead>
           <tr>
           <th>Data</th>
           <th >Ora</th>
           <th>Dottore</th>
           <th >Paziente</th>
           <th>Telefono</th>
           <th>Note</th>
           </tr>
           </thead>";


                            if (is_array($all_appointment_history)) {
                                $sn = 1;
                                foreach ($all_appointment_history as $aa) {
                                    $customer_firstname = $db->get_var('customers', array('id' => $aa['customer_id']), 'first_name');
                                    $customer_lastname = $db->get_var('customers', array('id' => $aa['customer_id']), 'last_name');
                                    $customer_phone = $db->get_var('customers', array('id' => $aa['customer_id']), 'mobile_number');
                                    $customer_fullname = ucwords($customer_firstname . " " . $customer_lastname);
                                    $service_name = $db->get_var('services', array('id' => $aa['service_id']), 'service_name');
                                    $service_color = $db->get_var('services', array('id' => $aa['service_id']), 'service_color');
                                    $service_provider_firstname = $db->get_var('users', array('user_id' => $aa['staff_id']), 'firstname');
                                    $service_provider_lastname = $db->get_var('users', array('user_id' => $aa['staff_id']), 'lastname');
                                    $service_provider_fullname = ucwords($service_provider_firstname . " " . $service_provider_lastname);
                                    $service_cost = $aa['service_cost'];
                                    $appointment_notes = $aa['notes'];

                                    $appointment_date = $aa['appointment_date'];
                                    $appointment_time = date('H:i:s', strtotime($aa['appointment_time']));

                                    $service_time = "+" . $aa['service_time'] . " minutes";
                                    $endTime = strtotime($service_time, strtotime($aa['appointment_time']));
                                    $service_end_time = date('H:i:s', $endTime);

                                    $html .= "<tbody>
                <tr style='border-top:1px solid #ccc;'>
                <td>" . $appointment_date . "</td>
                <td >" . $appointment_time . "-" . $service_end_time . "</td>
                <td >" . $service_provider_fullname . "</td>
                <td>" . $customer_fullname . "</td>
                <td> " . $customer_phone . "</td>
                <td> " . $appointment_notes . "</td>
                </tr> </tbody>";
                                }
                            }

                            $html .= "
            </table>";


                            $filename = SERVER_ROOT . '/uploads/pdf/appointment_history.html';
                            file_put_contents($filename, $html);
                            echo $html;


                            $sn++;
                        }
                    } elseif ($current_tab == 'export_revenue') { ?>
                        <h3 class="text-thin">Report Incassi</h3>
                        <hr>
                        <form class="form-inline" action="" method="post">
                            <div class="form-group">
                                <label for="demo-inline-inputmail" class="sr-only">Dal giorno</label>
                                <input class="form-control datepicker_account_preferences" type="text"
                                       placeholder="data inizio ricerca" name="start_date" readonly="readonly"
                                       value="<?php echo date('d-m-Y', strtotime($start_date)); ?>">
                            </div>
                            <div class="form-group">
                                <label for="demo-inline-inputpass" class="sr-only">al giorno</label>
                                <input class="form-control datepicker_account_preferences2" type="text"
                                       placeholder="data fine ricerca" name="end_date" readonly="readonly"
                                       value="<?php echo date('d-m-Y', strtotime($end_date)); ?>">
                            </div>
                            <button class="btn btn-info" name="revenue_export_submit" type="submit"><i
                                        class="fa fa-file"></i> Genera Report
                            </button>
                        </form>
                        <hr>
                        <?php if (isset($_POST['revenue_export_submit'])) {
                            if ($all_revenue != '') {
                                ?>
                                <a class="pdf btn btn-primary pull-right"
                                   href="<?php echo $link->link("pdfgenerate", user, '&report_type=revenue_report'); ?>"
                                >&nbsp;Genera PDF</a>

                            <?php }
                            $html = "<table style='width:100%;text-align:center;'>
                   <tr><td><h3 style='text-align:center;'>Revenue Report<br>
                   <small>" . strtoupper(SITE_NAME) . "<br>
                   For  " . date(DATE_FORMAT, strtotime($start_date)) . "-" . date(DATE_FORMAT, strtotime($end_date)) . "</small>
                   </td></tr>
                   </table>";


                            $html .= "<table class='table table-striped table-bordered' id='demo-dt-basic' style='width:100%'>
                   <thead>
                   <tr>
                   <th>Prestazione</th>
                   <th>Dottore</th>
                   <th >Paziente</th>
                   <th style='text-align:center'>Entrate previste</th>
                   <th style='text-align:center'>Entrate effettive</th>
                   
                   </tr>
                   </thead><tbody>";


                            if (is_array($all_revenue)) {
                                $sn = 1;
                                foreach ($all_revenue as $aa) {
                                    $customer_firstname = $db->get_var('customers', array('id' => $aa['customer_id']), 'first_name');
                                    $customer_lastname = $db->get_var('customers', array('id' => $aa['customer_id']), 'last_name');
                                    $customer_phone = $db->get_var('customers', array('id' => $aa['customer_id']), 'mobile_number');
                                    $customer_fullname = ucwords($customer_firstname . " " . $customer_lastname);
                                    $service_name = $db->get_var('services', array('id' => $aa['service_id']), 'service_name');
                                    $service_color = $db->get_var('services', array('id' => $aa['service_id']), 'service_color');
                                    $service_provider_firstname = $db->get_var('users', array('user_id' => $aa['staff_id']), 'firstname');
                                    $service_provider_lastname = $db->get_var('users', array('user_id' => $aa['staff_id']), 'lastname');
                                    $service_provider_fullname = ucwords($service_provider_firstname . " " . $service_provider_lastname);
                                    $service_cost = $aa['service_cost'];
                                    $service_status = $aa['status'];
                                    $balance = $aa['balance'];
                                    $appointment_date = $aa['appointment_date'];
                                    $appointment_time = date('h:i a', strtotime($aa['appointment_time']));

                                    $service_time = "+" . $aa['service_time'] . " minutes";
                                    $endTime = strtotime($service_time, strtotime($aa['appointment_time']));
                                    $service_end_time = date('h:i a', $endTime);
                                    $booking_id = $aa['booking_id'];
                                    $service_total = ($service_total + $service_cost);
                                    $confirm_rev = $service_cost - $balance;
                                    $total_show = $confirm_rev + $total_show;

                                    if ($service_status == "confirmed") {
                                        $projected_revenue = CURRENCY . '' . number_format($service_cost, 2);
                                    } else {
                                        $projected_revenue = "";
                                    }
                                    if ($service_status == "paid") {
                                        $confirmed_revenue = CURRENCY . '' . number_format($service_cost, 2);
                                    } else {
                                        $confirmed_revenue = "";
                                    }

                                    $html .= "
                    <tr style='border-top:1px solid #ccc;'>
                    
                    <td>" . $service_name . "</td>
                    <td>" . $service_provider_fullname . "</td>
                    <td>" . $customer_fullname . "</td>
                    <td style='color:orange; text-align:center'> " . $service_cost . "</td>
                    <td style='color:green; text-align:center'> " . ($service_cost - $balance) . "</td>
                    
                    </tr>";
                                }
                            }
                            $html .= "  </tbody><tfooter>
                <tr>
                
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                
                <th style='color:blue; font-size:12px;text-align:center;'><strong>Total Revenue(" . CURRENCY . "" . number_format($service_total + $total_show, 2) . ")</strong></th>
                <th style='color:orange; font-size:12px; text-align:center;'><strong>Projected Revenue(" . CURRENCY . "" . number_format($service_total, 2) . ")</strong></th>
                <th style='color:green; font-size:12px; text-align:center;'><strong>Confirmed Revenue(" . CURRENCY . "" . number_format($total_show, 2) . ")</strong></th>
                
                </tr>
                </tfooter>";

                            $html .= " </table>";


                            $filename = SERVER_ROOT . '/uploads/pdf/revenue_report.html';
                            file_put_contents($filename, $html);
                            echo $html;


                            $sn++;
                        }
                    } ?>

                </div>
            </div>
            <!--===================================================-->
            <!--End Stacked Tabs Left-->
        </div>

    </div>
</div>