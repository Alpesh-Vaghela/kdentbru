<?php
$com_id = CURRENT_LOGIN_COMPANY_ID;
if ($_POST['previous_submit']) {
    $appointment_date = $_POST['previous_submit'];
} elseif ($_POST['appointment_date']) {
    $appointment_date = $_POST['appointment_date'];
} else {
    $appointment_date = date('Y-m-d');
}
$dayName = date("l", strtotime($appointment_date));

$working_day = unserialize($db->get_var('company', array('id' => $com_id), 'working_day'));
$working_on_off = unserialize($db->get_var('company', array('id' => $com_id), 'working_on_off'));
$working_start_time = unserialize($db->get_var('company', array('id' => $com_id), 'working_start_time'));
$working_end_time = unserialize($db->get_var('company', array('id' => $com_id), 'working_end_time'));
$time_slots = $db->get('preferences_settings', array('company_id' => $com_id), 'custom_time_slot');


$receiptnistAccess = $_SESSION['user_id'] == 121 ? array('114', '115') : array();
$mul_doctor_condition = !empty($receiptnistAccess) ? " AND FIND_IN_SET(user_id,'" . implode(",", $receiptnistAccess) . "')" : "";


//$provider=$db->get_all('users',array('visibility_status'=>'active','user_type'=>'staff','company_id'=>CURRENT_LOGIN_COMPANY_ID));
$provider = $db->run("SELECT* FROM `users` WHERE `visibility_status`='active' AND `company_id`='$com_id' AND `user_type`!='admin' $mul_doctor_condition")->fetchAll();
$ecount = count($provider);

$w = (100 / $ecount) - 5;
$testing_array = array();
$staring_time = array();
?>
<style>
    .img-sm {
        width: 25px;
        height: 25px;
    }
</style>
<div id="page-content">

    <div class="row">

        <div class="col-md-12 col-lg-12">
            <div class="panel">
                <div class="panel-body">
                    <div class="row hidden-print">
                        <div class="col-md-12 col-lg-12" style="text-align: center">
                            <form method="post" action="">
                                <div class="row">
                                    <div class="col-xs-12 col-lg-6 col-lg-6 input-btn-input-box">
                                        <button type="submit" name="submit" value="" class="btn btn-info">Today</button>
                                        <input class="form-control datepicker" type="text" name="appointment_date"
                                               value="<?php echo ($appointment_date != '') ? date('d-m-Y', strtotime($appointment_date)) : date('d-m-Y'); ?>"
                                               id="get_date_calender">
                                        <button type="submit" name="next_submit" class="btn btn-info">Submit</button>
                                    </div>
                                    <div class="col-xs-12 col-lg-6 col-lg-6 text-right">
                                        <a class="btn btn-default pull-right"
                                           onclick="window.print();return fetchAllse;" href="#;"
                                           style="margin-left: 5px;">
                                            <i class="fa fa-print"></i> Print
                                        </a>
                                        <a class="btn btn-default pull-right"
                                           href="<?php echo $link->link('calendar', frontend); ?>"><i
                                                    class="fa fa-calendar"></i> Calendar</a>

                                    </div>
                                </div>
                            </form>
                            <br>
                            <h4><?php setlocale(LC_TIME, 'ita', 'it_IT');
                                echo ucFirst(utf8_encode(strftime('%A', strtotime($appointment_date))));
                                setlocale(LC_TIME, 0); ?></h4>
                        </div>
                    </div>
                    <div class="table-responsive">

                        <tbody>
                        <table class="table table-bordered" id="example">
                            <thead>
                            <tr>
                                <th width="5%"></th>
                                <?php
                                // checking starting times of appointments...........

                                foreach ($provider as $p) {

                                    if ($p['user_type'] == "staff") {

                                        $user_id = $p['user_id'];

                                        $appointment_date_change = date('Y-m-d', strtotime($appointment_date));

                                        $sql = "SELECT* FROM `appointments` WHERE  `staff_id`='$user_id'  AND `appointment_date`='$appointment_date_change'";
                                        $p_apponiments = $db->run($sql)->fetchAll();
                                        foreach ($p_apponiments as $p_a) {
                                            array_push($staring_time, $p_a['appointment_time']);
                                        }

                                    }
                                }
                                $staring_time = array_unique($staring_time);
                                // end checking


                                foreach ($provider as $p) {
                                    ?>
                                    <?php

                                    $work_day_user = unserialize($p['working_day']);
                                    $work_day_on_off_user = unserialize($p['working_on_off']);
                                    $holiday = array();

                                    foreach ($work_day_on_off_user as $wor => $workday) {

                                        // print_r($workday);
                                        if ($workday == "off") {
                                            $holiday[] = $work_day_user[$wor];
                                        }
                                    }

                                    ?>
                                    <?php if ($p['user_type'] == "staff"): ?>
                                        <?php if (!in_array(strtolower($dayName), $holiday)): ?>
                                            <th width="<?php echo $w; ?>%" style="text-align:center;">
                                                <?php

                                                if (file_exists(SERVER_ROOT . '/uploads/company/' . CURRENT_LOGIN_COMPANY_ID . '/users/' . $p['user_id'] . '/' . $p['user_photo_file']) && (($p['user_photo_file']) != '')) {
                                                    ?>
                                                    <img class="img-circle img-sm add-tooltip"
                                                         src="<?php echo SITE_URL . '/uploads/company/' . CURRENT_LOGIN_COMPANY_ID . '/users/' . $p['user_id'] . '/' . $p['user_photo_file']; ?>">
                                                <?php } else { ?>
                                                    <img class="img-circle img-sm add-tooltip"
                                                         src="<?php echo SITE_URL . '/assets/frontend/default_image/default_user_image.png'; ?>"
                                                         alt="Profile Picture">
                                                <?php } ?> <br>
                                                <a class="add-tooltip" data-placement="bottom" data-toggle="tooltip"
                                                   data-original-title="<?php echo ucfirst($p['firstname'] . " " . $p['lastname']); ?>"><?php echo ucfirst($p['firstname']); ?></a>
                                            </th>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php } ?>
                            </tr>

                            </thead>

                            <?php
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
                                // ..........sorting time...........
                                foreach ($staring_time as $key => $val) {
                                    $time[$key] = $val;
                                }

                                array_multisort($time, SORT_ASC, $points);
                                array_multisort($time, SORT_ASC, $staring_time);
                                // print_r($staring_time);
                                // echo "</pre>";

                                if (is_array($staring_time)) {


                                    foreach ($staring_time as $t) {
                                        // $appointment_time= date('H:i:s',strtotime($t));
                                        $appointment_time = date('H:i', strtotime($t));

                                        ?>
                                        <tr id="table_row<?php echo $appointment_time; ?>">

                                            <td width="5%"><?php echo date('h:i a', strtotime($t)); ?></td>
                                            <?php
                                            $sn = 1;
                                            foreach ($provider as $p) {

                                                if ($p['user_type'] == "staff"):
                                                    $user_id = $p['user_id'];

                                                    $appointment_date_change = date('Y-m-d', strtotime($appointment_date));
                                                    $sql = "SELECT* FROM `appointments` WHERE `staff_id`='$user_id' AND `appointment_date`='$appointment_date_change' AND `appointment_time`='$appointment_time'";
                                                    $p_apponiments = $db->run($sql)->fetch();
                                                    if ($p_apponiments['appointment_time'] == "") {
                                                        $sql = "SELECT* FROM `appointments` WHERE `staff_id`='$user_id' AND `appointment_date`='$appointment_date_change' AND `appointment_time`<='$appointment_time' AND `appointment_end_time`>='$appointment_time'";
                                                        $p_apponiments = $db->run($sql)->fetch();

                                                    }
                                                    ?>

                                                    <?php

                                                    $work_day_user2 = unserialize($p['working_day']);
                                                    $work_day_on_off_user2 = unserialize($p['working_on_off']);
                                                    $holiday2 = array();


                                                    foreach ($work_day_on_off_user2 as $wor2 => $workday2) {
                                                        if ($workday2 == "off") {
                                                            // print_r($workday2);
                                                            $holiday2[] = $work_day_user2[$wor2];
                                                        }
                                                    }

                                                    ?>
                                                    <?php if (!in_array(strtolower($dayName), $holiday2)): ?>
                                                    <td width="<?php echo $w; ?>%" style="text-align:center;">
                                                        <?php if ($p_apponiments['appointment_time'] != "") {
                                                            $service_name = $db->get_var('services', array('id' => $p_apponiments['service_id']), 'service_name');
                                                            $services_color = $db->get_var('services', array('id' => $p_apponiments['service_id']), 'service_color');
                                                            $cfirst_name = $db->get_var('customers', array('id' => $p_apponiments['customer_id']), 'first_name');
                                                            $clast_name = $db->get_var('customers', array('id' => $p_apponiments['customer_id']), 'last_name');
                                                            ?>
                                                            <?php if (in_array($p_apponiments['id'], $testing_array)) {
                                                            } else { ?>
                                                                <div class="alert alert-<?php echo $services_color; ?>">
                                                                    <?php
                                                                    echo $p_apponiments['customer_name'];
                                                                    ?>
                                                                    <br />
                                                                    <strong>
                                                                        <?php
                                                                        echo $p_apponiments['service_time'] + $p_apponiments['service_buffer_time']
                                                                        ?>
                                                                        minutes
                                                                    </strong>
                                                                    <br>
                                                                    <?php echo $p_apponiments['notes']; ?>
                                                                    <?php
                                                                    //echo CURRENCY . "" . $p_apponiments['service_cost'];
                                                                    array_push($testing_array, $p_apponiments['id']);
                                                                    ?>
                                                                </div>


                                                            <?php }
                                                        } ?>
                                                    </td>
                                                <?php endif; ?>
                                                <?php endif;
                                            } ?>

                                        </tr>

                                        <?php

                                    }
                                }
                            }
                            // echo "<pre>";
                            // print_r($testing_array);
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>