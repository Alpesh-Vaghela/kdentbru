<?php
$ci = CURRENT_LOGIN_COMPANY_ID;
if (isset($_POST['dashboard_filter_submit'])) {
    $filter_by_dashboard = $_POST['filter_by_dashboard'];

    if ($filter_by_dashboard == "today") {
        $week_start_date = date('Y-m-d');
        $week_end_date = date('Y-m-d');
        $filter = "OGGI";
    } elseif ($filter_by_dashboard == "thisweek") {
        $week_start_date = date('Y-m-d', strtotime('last Monday'));
        $week_end_date = date('Y-m-d', strtotime('next Sunday'));
        $filter = "QUESTA SETTIMANA";
    } elseif ($filter_by_dashboard == "nextweek") {
        $monday = strtotime("next monday");
        $monday = date('W', $monday) == date('W') ? $monday - 7 * 86400 : $monday;

        $sunday = strtotime(date("Y-m-d", $monday) . " +6 days");
        $week_start_date = date("Y-m-d", $monday);
        $week_end_date = date("Y-m-d", $sunday);
        $filter = "PROSSIMA SETTIMANA";

    } elseif ($filter_by_dashboard == "thismonth") {

        $week_start_date = date('Y-m-01');
        $week_end_date = date('Y-m-t', strtotime($week_start_date));
        $filter = "QUESTO MESE";

    } elseif ($filter_by_dashboard == "nextmonth") {
        $date = date('Y-m-d', strtotime('first day of +1 month'));

        $week_start_date = date('Y-m-01', strtotime($date));
        $week_end_date = date('Y-m-t', strtotime($week_start_date));
        $filter = "PROSSIMO MESE";

    }

} else {
    $week_start_date = date('Y-m-d', strtotime('last Monday'));
    $week_end_date = date('Y-m-d', strtotime('next Sunday'));
    $filter = "QUESTA SETTIMANA";
}

//echo $week_start_date;
//echo $week_end_date;
$customer_count = $db->get_count('customers', array('company_id' => CURRENT_LOGIN_COMPANY_ID));
//$appointment_count=$db->get_count('appointments',array('company_id'=>CURRENT_LOGIN_COMPANY_ID));
//$services_count=$db->get_count('services',array('company_id'=>CURRENT_LOGIN_COMPANY_ID));
/**********************************find Confirmed Revenue*************************/
$query2 = "SELECT SUM(`service_cost`)
FROM `appointments`
WHERE `company_id`='$ci' AND `appointment_date` BETWEEN '$week_start_date' AND '$week_end_date' AND `status`='paid'";
$confirmed_revenue = $db->run($query2)->fetchColumn();
/**********************************find Projected Revenue*************************/
$query2 = "SELECT SUM(`service_cost`)
FROM `appointments`
WHERE `company_id`='$ci' AND `appointment_date` BETWEEN '$week_start_date' AND '$week_end_date' AND `status`='confirmed'";
$projected_revenue = $db->run($query2)->fetchColumn();

/**********************************find Total Revenue*************************/
$total_estimate = $confirmed_revenue + $projected_revenue;

/**********************************find all Activity of the week*************************/
$query = "SELECT* 
FROM `activity_logs` 
WHERE `company_id`='$ci' AND `created_date` BETWEEN '$week_start_date' AND '$week_end_date' 
AND (`event_type`='customer_created' OR `event_type`='customer_deleted' OR `event_type`='customer_updated' OR `event_type`='appointment_created' OR `event_type`='appointment_deleted' OR `event_type`='appointment_updated')
ORDER BY id DESC
LIMIT 0, 7";
$this_week_activity = $db->run($query)->fetchAll();


/**********************************find all Appointment of the week*************************/
$query1 = "SELECT*
FROM `appointments`
WHERE `company_id`='$ci' AND `appointment_date` BETWEEN '$week_start_date' AND '$week_end_date'
ORDER BY id DESC";
$this_week_appointments = $db->run($query1)->fetchAll();
$appointment_count = count($this_week_appointments);

/**********************************find all Users*************************/
//$db->limit='0,7';
$db->order_by = 'user_id DESC';
$allstaff = $db->get_all('users', array('company_id' => $ci));


if (isset($_REQUEST['action_paid'])) {
    $action_id = $_REQUEST['action_paid'];

    $display_msg = '<form method="POST" action="">
    <div class="alert alert-danger">
    <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
    Are you sure ? You want to Paid this .
    <input type="hidden" name="del_id" value="' . $action_id . '" >
    <button name="yes" type="submit" class="btn btn-success btn-xs"  aria-hidden="true"><i class="fa fa-check-circle-o fa-2x"></i></button>
    <button name="no" type="submit" class="btn btn-danger btn-xs" aria-hidden="true"><i class="fa fa-times-circle-o fa-2x"></i></button>
    </div>
    </form>';
    if (isset($_POST['yes'])) {
        $update_paid = $db->update('appointments', array('status' => 'paid'), array('id' => $action_id));
        if ($update_paid) {
            $display_msg = '<div class="alert alert-success text-success">
            <i class="fa fa-smile-o"></i>
            <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
            Appointment Status Change to Paid Successfully.
            </div>';
            echo "<script>
            setTimeout(function(){
             window.location = '" . $link->link("home", user) . "'s
         },3000);</script>";
        }
    } elseif (isset($_POST['no'])) {
        $session->redirect("home", user);
    }
}

?>
<?php
if (isset($_REQUEST['action_update'])) {

    $appointment_id = $_REQUEST['action_update'];
    $visit_in_process = VISIT_IN_PRECESS;
    $update = $db->update('appointments', array('status' => "$visit_in_process", 'ip_address' => $_SERVER['REMOTE_ADDR']), array('id' => $appointment_id));

    $display_msg = '<div class="alert alert-success text-success">
    <i class="fa fa-smile-o"></i>
    <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
    Updated Successfully.
    </div>';
    echo "<script>
    setTimeout(function(){
     window.location = '" . $link->link("home", user) . "'
 },3000);</script>";


} ?>

<?php
if (isset($_REQUEST['action_complete'])) {
    $notice_id = $_REQUEST['action_complete'];
    $update = $db->update('memo_notice', array('status' => '1', 'ip_address' => $_SERVER['REMOTE_ADDR']), array('id' => $notice_id));

    $display_msg = '<div class="alert alert-success text-success">
    <i class="fa fa-smile-o"></i>
    <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
    Updated Successfully.
    </div>';
    echo "<script>
    setTimeout(function(){
     window.location = '" . $link->link("home", user) . "'
 },3000);</script>";


} ?>


<style>
    .media-left, .media > .pull-left {
        padding-right: 7px;
    }

</style>
<div id="page-content">
    <div class="row">
        <?php echo $display_msg; ?>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xm-12">
            <!--Registered User-->
            <div class="panel media pad-all">
                <div class="media-left">
                <span class="icon-wrap icon-wrap-sm  bg-primary">
                    <i class="fa fa-arrow-right fa-2x"></i>
                </span>
                </div>
                <div class="media-body">
                    <h4 class="text-center"><?php echo $filter; ?></h4>
                    <p class="h5 mar-no text-center"><?php echo date(COMMON_DATE_FORMAT, strtotime($week_start_date)); ?>
                        / <?php echo date(COMMON_DATE_FORMAT, strtotime($week_end_date)); ?></p>
                </div>
                <div class="media-right">
                    <!--   <i class="fa fa-caret-square-o-down" data-toggle="modal" data-target="#myModal_dashboard_filter" title="Click to filter"></i>-->


                    <form id="filter_form_id" method="post" action="">
                        <input type="hidden" name="dashboard_filter_submit" value="dashboard_filter_submit">

                        <div class="form-group">
                            <div class="col-md-6">

                                <select class="form-control12" name="filter_by_dashboard" id="filter_by_dashboard">
                                    <option <?php if ($filter_by_dashboard == "thisweek") {
                                        echo "selected='selected'";
                                    } ?> value="thisweek">Questa settimana
                                    </option>
                                    <option <?php if ($filter_by_dashboard == "today") {
                                        echo "selected='selected'";
                                    } ?> value="today">Oggi
                                    </option>
                                    <option <?php if ($filter_by_dashboard == "nextweek") {
                                        echo "selected='selected'";
                                    } ?> value="nextweek">Prossima settimana
                                    </option>
                                    <option <?php if ($filter_by_dashboard == "thismonth") {
                                        echo "selected='selected'";
                                    } ?> value="thismonth">Questo mese
                                    </option>
                                    <option <?php if ($filter_by_dashboard == "nextmonth") {
                                        echo "selected='selected'";
                                    } ?> value="nextmonth">Prossimo mese
                                    </option>
                                </select>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-6 col-xm-12">
            <!--New Order-->
            <div class="panel media pad-all">
                <div class="media-left">
            <span class="icon-wrap icon-wrap-sm icon-circle bg-info">
                <i class="fa fa-calendar fa-2x"></i>
            </span>
                </div>
                <div class="media-body">
                    <p class="text-2x mar-no text-thin text-right"><?php echo $appointment_count; ?></p>
                    <p class="h5 mar-no text-right">Appuntamenti</p>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-6 col-xm-12">
            <!--Comments-->
            <!--<div class="panel media pad-all">
                                    <div class="media-left">
                                        <span class="icon-wrap icon-wrap-sm icon-circle bg-success">
                                        <i class="fa fa-dollar fa-2x"></i>
                                        </span>
                                    </div>
                                    <div class="media-body">
                                        <p class="text-2x mar-no text-thin text-right"><?php echo CURRENCY . "" . number_format($confirmed_revenue); ?></p>
                                        <p class="h5 mar-no text-right">Confirmed Revenue</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-6 col-xm-12">-->
            <!--Sales-->
            <!--<div class="panel media pad-all">
                                    <div class="media-left">
                                        <span class="icon-wrap icon-wrap-sm icon-circle bg-warning">
                                        <i class="fa fa-dollar fa-2x"></i>
                                        </span>
                                    </div>
                                    <div class="media-body">
                                        <p class="text-2x mar-no text-thin text-right"><?php echo CURRENCY . "" . number_format($projected_revenue); ?></p>
                                        <p class="h5 mar-no text-right">Projected Revenue</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-6 col-xm-12">-->
            <!--Sales-->
            <div class="">
                <div class="media-left">

                    </span>
                </div>
                <div class="media-body">
                </div>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-md-6">
            <div class="panel">
                <div class="panel-heading">
                </div>
                <div class="panel-body np">
                    <!--Chat widget-->
                    <!--===================================================-->
                    <!--Widget body-->
                    <div id="demo-chat-body" class="collapse in">
                        <div class="nano has-scrollbar" style="height:380px">
                            <div class="nano-content pad-all" tabindex="0" style="right: -17px;">
                                <table class="table table-bordered">
                                    <thead>
                                    <!--   <tr>
                                    <th width="10%">&nbsp;</th>
                                    <th width="25%">&nbsp;</th>
                                    <th width="45%">&nbsp;</th>
                                    <th width="20%">&nbsp;</th>
                                </tr> -->
                                    </thead>
                                    <tbody>
                                    <?php if (!empty($this_week_appointments)) {
                                        foreach ($this_week_appointments as $appoint) {
                                            $customer_details = $db->get_all('customers', array('id' => $appoint['customer_id']));
                                            $appointment_id = $appoint['id'];
                                            $service_provider_firstname = $db->get_var('users', array('user_id' => $appoint['staff_id']), 'firstname');
                                            $service_provider_lastname = $db->get_var('users', array('user_id' => $appoint['staff_id']), 'lastname');
                                            $service_name = $db->get_var('services', array('id' => $appoint['service_id']), 'service_name');
                                            $service_color = $db->get_var('services', array('id' => $appoint['service_id']), 'service_color');
                                            $pathology = ($customer_details[0]['pathology'] == 'yes') ? '***' : '';
                                            $sql = "SELECT SUM(payment_amount) FROM `payments` WHERE `appointment_id`='$appointment_id'";
                                            $payment_sum_advance = $db->run($sql)->fetchColumn();
                                            if ($payment_sum_advance == NULL) {
                                                $payment_sum_advance = 0;
                                            }


                                            //  $customer_firstname=$db->get_var('customers',array('id'=>$appoint['customer_id']),'first_name');
                                            //  $customer_lastname=$db->get_var('users',array('user_id'=>$appoint['customer_id']),'last_name');
                                            $customer_name = $appoint['customer_name']
                                            ?>
                                            <tr>
                                                <td width="10%">
                                                    <?php if ($appoint['status'] == "pending") { ?>
                                                        <button data-toggle="modal"
                                                                data-target="#myModal_edit_appointment"
                                                                data="<?php echo $appoint['id']; ?>"
                                                                class="edit_modal_edit_customer btn btn-default btn-icon btn-circle icon-lg fa fa-calendar"></button>
                                                    <?php } else { ?>
                                                        <button data-toggle="modal"
                                                                class=" btn btn-default btn-icon btn-circle icon-lg fa fa-calendar"></button>
                                                    <?php } ?>
                                                    <?php if ($appoint['private'] == "yes") { ?>
                                                        <span class="label label-danger">Privato</span>
                                                    <?php } ?>

                                                </td>
                                                <td width="45%">
                                                    <?php echo date(COMMON_DATE_FORMAT, strtotime($appoint['appointment_date'])); ?>
                                                    (<?php echo date('h:i  A', strtotime($appoint['appointment_time'])) . "-" . date('h:i  A', strtotime($appoint['appointment_end_time'])); ?>
                                                    )
                                                    <br><?php echo ucwords($service_provider_firstname . " " . $service_provider_lastname); ?>
                                                    .Customer Name: <?php echo $customer_name . $pathology; ?>
                                                    . <?php echo ucfirst($service_name); ?>
                                                    . <?php echo $appoint['service_time'] + $appoint['service_buffer_time'] ?>
                                                    min . <?php echo CURRENCY . "" . $appoint['service_cost'] ?>
                                                </td>
                                                <td width="30%">
                                                    <?php if ($appoint['status'] == 'deleted'): ?>
                                                        <p style="font-size: 12px;"><b>Motivo
                                                                cancellazione: </b><?php echo $appoint['cancel_reason']; ?>
                                                        </p>
                                                        <?php if ($appoint['status'] != 'deleted'): ?>
                                                            <a data-toggle="modal"
                                                               data-target="#myModal_edit_appointment"
                                                               data="<?php echo $appoint['id']; ?>"
                                                               class="label label-primary edit_modal_edit_customer"
                                                               style="margin-top: 10px;margin-bottom: 10px"><i
                                                                        class="fa fa-refresh"> Riprendi Appuntamento</i></a>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                    <?php if ($appoint['status'] != VISIT_IN_PRECESS && $appoint['status'] != VISIT_DONE && $appoint['status'] != 'deleted') { ?>
                                                        <a class="label label-info"
                                                           href="<?php echo $link->link("home", user, '&action_update=' . $appointment_id); ?>"><i
                                                                    class="fa fa-edit">Visita Eseguita</i></a>
                                                    <?php }
                                                    if ($appoint['status'] == "pending") {
                                                        if (strtotime($appoint['appointment_date'] . " " . $appoint['appointment_time']) > strtotime(date('Y-m-d H:i'))) {
                                                            ?>
                                                            <!--<a href="#" data-toggle="modal" data-target="#myModal_assign_room" data="<?php echo $appoint['id']; ?>" class="assign_room_button label label-warning pull-right"     ><i class="fa fa-check-circle-o"></i>Assign Room</a>   -->
                                                        <?php } else {
                                                            ?>
                                                            <span class="label label-danger">in Ritardo/non Presentato</span>
                                                            <br>
                                                            <a data-toggle="modal"
                                                               data-target="#myModal_edit_appointment"
                                                               data="<?php echo $appoint['id']; ?>"
                                                               class="label label-primary edit_modal_edit_customer"
                                                               style="margin-top: 10px;margin-bottom: 10px"><i
                                                                        class="fa fa-refresh">Reschedule
                                                                    Appointment</i></a>
                                                        <?php }
                                                    } else if ($appoint['status'] == "deleted") {
                                                        if ($appoint['payment_status'] == "unpaid") {
                                                            ?>
                                                            <br>
                                                            <a href="#" data-toggle="modal"
                                                               data-target="#myModal_payment"
                                                               class="load_payment_details" id="load_payment_details"
                                                               data_id="<?php echo $appoint['id']; ?>"
                                                               data_booking_id="<?php echo $appoint['booking_id']; ?>"
                                                               data_booking_date="<?php echo date(COMMON_DATE_FORMAT, strtotime($appoint['appointment_date'])); ?>"
                                                               data_customer="<?php echo ucwords($customer_name); ?>"
                                                               data_service_name="<?php echo ucwords($service_name); ?>"
                                                               data_payment_sum_advance="<?php echo ucwords($payment_sum_advance); ?>"
                                                               data_service_cost="<?php echo $appoint['service_cost'] ?>"
                                                               data_balance="<?php echo $appoint['balance'] ?>">(Aggiungi
                                                                PAGAMENTO)</a>


                                                        <?php } else {
                                                            ?>
                                                            <span class="label label-success"><i
                                                                        class="fa fa-check "></i> SALDATO</span>

                                                        <?php }
                                                    } else {
                                                        ?>
                                                        <span class="label class-<?php echo $appoint['id']; ?> label-<?php if ($appoint['status'] == "pending") {
                                                            echo "warning";
                                                        } else {
                                                            echo "success";
                                                        } ?>"><i class="fa fa-tag"></i>
                                                            <?php
                                                            if ($appoint['status'] == VISIT_DONE)
                                                                echo "Visit Done";
                                                            else
                                                                echo "Visit in Process";
                                                            ?>
                </span>
                                                        <br>
                                                        <?php if ($appoint['status'] == "confirmed") { ?>
                                                            <!--                                           <span class="label label-info">Assigned Room: <?php //echo ucwords($db->get_var('rooms',array('id'=>$appoint['assigned_room']),'name'));?></span>
  <a href="#" data-toggle="modal" data-target="#myModal_assign_room" data="<?php echo $appoint['id']; ?>" class="assign_room_button  pull-right"   >(Click to Re-assign Room)</a>-->
                                                        <?php }

                                                        if ($appoint['payment_status'] == "unpaid") {
                                                            ?>

                                                            <a href="#" data-toggle="modal"
                                                               data-target="#myModal_payment" id="load_payment_details"
                                                               class="load_payment_details"
                                                               data_id="<?php echo $appoint['id']; ?>"
                                                               data_booking_id="<?php echo $appoint['booking_id']; ?>"
                                                               data_booking_date="<?php echo date(COMMON_DATE_FORMAT, strtotime($appoint['appointment_date'])); ?>"
                                                               data_customer="<?php echo ucwords($customer_name); ?>"
                                                               data_service_name="<?php echo ucwords($service_name); ?>"
                                                               data_payment_sum_advance="<?php echo ucwords($payment_sum_advance); ?>"
                                                               data_service_cost="<?php echo $appoint['service_cost'] ?>"
                                                               data_balance="<?php echo $appoint['balance'] ?>">(Aggiungi
                                                                pagamento)</a>


                                                        <?php } else {
                                                            ?>
                                                            <span class="label label-success"><i
                                                                        class="fa fa-check"></i> Paid</span>

                                                        <?php } ?>
                                                    <?php }


                                                    ?>


                                                </td>

                                                <?php if ($appoint['status'] != 'deleted') { ?>
                                                    <td width="15%">
                                                        <a data-toggle="modal" data-target="#myModal_edit_appointment"
                                                           data="<?php echo $appoint['id']; ?>"
                                                           class="edit_modal_edit_customer"><i
                                                                    class="fa fa-edit fa-2x text-info"></i></a>

                                                        <a data-toggle="modal" data-target="#myModal_cancel_appointment"
                                                           data="<?php echo $appoint['id']; ?>"
                                                           class="cancel_modal_cancel_customer"><i
                                                                    class="fa fa-trash fa-2x text-danger"></i></a>

                                                    </td>
                                                <?php } ?>
                                            </tr>
                                        <?php }
                                    } else { ?>
                                        <tr>
                                            <td colspan="4">No Result Found!</td>

                                        </tr>
                                    <?php } ?>

                                    </tbody>
                                </table>
                            </div>
                            <div class="nano-pane">
                                <div class="nano-slider" style="height: 92px; transform: translate(0px, 0px);"></div>
                            </div>
                        </div>

                    </div>
                    <!--===================================================-->
                    <!--Chat widget-->
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="panel">
                <div class="panel-heading">
                    <h4 class="panel-title">ATTIVITA'
                        <small>(<a class="text-danger"
                                   href="<?php echo $link->link('activity', frontend); ?>">Dettagli</a>)
                        </small>
                    </h4>
                </div>
                <div class="panel-body np">
                    <!--Chat widget-->
                    <!--===================================================-->
                    <!--Widget body-->
                    <div id="demo-chat-body" class="collapse in">
                        <div class="nano has-scrollbar" style="height:380px">
                            <div class="nano-content pad-all" tabindex="0" style="right: -17px;">
                                <ul class="list-group bg-trans">
                                    <?php
                                    //$all_activity_log=$db->get_all('activity_logs',array('company_id'=>CURRENT_LOGIN_COMPANY_ID));
                                    if (!empty($this_week_activity)) {
                                        foreach ($this_week_activity as $alla) {
                                            ?>
                                            <li class="list-group-item">
                                                <a href="javascript:void(0)" class="conversation-toggle">
                                                    <div class="pull-left avatar mar-rgt">
                                                        <button class="btn btn-icon icon-lg <?php if ($alla['event_type'] == "customer_created" || $alla['event_type'] == "appointment_created") {
                                                            echo 'btn-success';
                                                        } elseif ($alla['event_type'] == "customer_updated" || $alla['event_type'] == "appointment_updated") {
                                                            echo 'btn-warning';
                                                        } elseif ($alla['event_type'] == "customer_deleted" || $alla['event_type'] == "appointment_deleted") {
                                                            echo 'btn-danger';
                                                        } elseif ($alla['event_type'] == "login") {
                                                            echo 'btn-pink';
                                                        } elseif ($alla['event_type'] == "logout") {
                                                            echo 'btn-purple';
                                                        }

                                                        ?> <?php if ($alla['event_type'] == "customer_created" || $alla['event_type'] == "customer_updated" || $alla['event_type'] == "customer_deleted") {
                                                            echo 'fa fa-user fa-lg';
                                                        } elseif ($alla['event_type'] == "login") {
                                                            echo 'fa fa-sign-in fa-lg';
                                                        } elseif ($alla['event_type'] == "logout") {
                                                            echo 'fa fa-sign-out fa-lg';
                                                        } elseif ($alla['event_type'] == "appointment_created" || $alla['event_type'] == "appointment_updated" || $alla['event_type'] == "appointment_deleted") {
                                                            echo 'fa fa-calendar fa-lg';
                                                        }
                                                        ?>

                                       ?>">


                                                        </button>
                                                    </div>
                                                    <div class="inline-block">
                                                        <div class="text-small"><?php echo $alla['event']; ?></div>
                                                        <small class="text-muted">
                                                            <?php
                                                            /*  $date1timestamp=time();
                                                              $date2timestamp=strtotime($alla['timestamp']);
                                                              $result = $feature->date_difference($date1timestamp, $date2timestamp);
                                                              if($result['day']!=0 || $result['day']>0){echo $result['day'].' day(s)&nbsp;';}
                                                              if($result['hours']!=0 || $result['hours']>0){echo $result['hours'].' hour(s)&nbsp;';}
                                                              if($result['hours']!=0 || $result['hours']>0){echo $result['mins'].' min(s)&nbsp;';}
                                                              echo " ago";*/
                                                            echo date('d-m-Y h:i:s', strtotime($alla['timestamp']));

                                                            ?>
                                                        </small>
                                                        By
                                                        <b><?php echo $staff_first_name = $db->get_var('users', array('user_id' => $alla['user_id']), 'firstname');
                                                            echo " ";
                                                            echo $staff_last_name = $db->get_var('users', array('user_id' => $alla['user_id']), 'lastname');
                                                            ?></b>
                                                    </div>
                                                </a>
                                            </li>

                                        <?php }
                                    } else {
                                        ?>
                                        <li class="list-group-item">
                                            NESSUN RISULTATO

                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <div class="nano-pane">
                                <div class="nano-slider" style="height: 92px; transform: translate(0px, 0px);"></div>
                            </div>
                        </div>
                        <!--Widget footer-->

                    </div>
                    <!--===================================================-->
                    <!--Chat widget-->
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">Note</h3>
                </div>
                <div class="panel-body">
                    <div id="demo-chat-body" class="collapse in">
                        <div class="nano has-scrollbar" style="height:350px">
                            <div class="nano-content pad-all" tabindex="0">


                                <table class="table table-hover table-vcenter memo-notice">

                                    <tbody>
                                    <?php
                                    $memo_notification = $db->get_all('memo_notice', array('company_id' => CURRENT_LOGIN_COMPANY_ID));
                                    if (is_array($memo_notification)) {
                                        foreach ($memo_notification as $allmn) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <strong class="text-primary"><?php echo date(COMMON_DATE_FORMAT, strtotime($allmn['date'])); ?> </strong><a
                                                            data-toggle="modal" data-target="#myModal_edit_memo"
                                                            data="<?php echo $allmn['id']; ?>" class="edit_memo"><i
                                                                class="fa fa-edit fa-2x text-info"></i></a>
                                                    <?php if ($allmn['status'] == "0") { ?>
                                                        <a class="label label-info"
                                                           href="<?php echo $link->link("home", user, '&action_complete=' . $allmn['id']); ?>">Archivia</a>
                                                    <?php } ?>
                                                    <br>
                                                    <p class="<?php echo ($allmn['status'] == "1") ? 'completed-memo' : '' ?>"><?php echo $allmn['notification'] ?></p>
                                                </td>

                                            </tr>

                                        <?php }
                                    } ?>


                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- <div class="row">
                         <div class="col-lg-4">
                                <div class="panel">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">STAFF</h3>
                                    </div>
                                    <div class="panel-body">
                                        <div id="demo-chat-body" class="collapse in">
                            <div class="nano has-scrollbar" style="height:350px">
                    <div class="nano-content pad-all" tabindex="0">
                                        <table class="table table-hover table-vcenter">
                                            <thead>
                                                <tr>

                                                    <th>&nbsp;</th>
                                                    <th>Name</th>


                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php

    if (is_array($allstaff)) {
        foreach ($allstaff as $alls) {
            ?>
                                                <tr>
                                                <td class="text-center">
                                                 	<?php
            if (file_exists(SERVER_ROOT . '/uploads/company/' . CURRENT_LOGIN_COMPANY_ID . '/users/' . $alls['user_id'] . '/' . $alls['user_photo_file']) && (($alls['user_photo_file']) != '')) {
                ?>
                                                    	<img class="img-circle img-sm" class="img-md" src="<?php echo SITE_URL . '/uploads/company/' . CURRENT_LOGIN_COMPANY_ID . '/users/' . $alls['user_id'] . '/' . $alls['user_photo_file']; ?>">
                                                         <?php } else { ?>
                                                          <img class="img-circle img-sm" src="<?php echo SITE_URL . '/assets/frontend/default_image/default_user_image.png'; ?>" alt="Profile Picture">
                                                                    <?php } ?>
                                                </td>
                                                <td><a href="<?php echo $link->link('staff', frontend, '&sid=' . $alls['user_id']); ?>"><?php echo ucwords($alls['firstname'] . " " . $alls['lastname']); ?></a>
                                                <span class='text-primary'>(<?php echo ucfirst($alls['user_type']) ?>)</span>
                                                </td>

                                             </tr>

                                            <?php }
    } ?>




                                            </tbody>
                                        </table>
                                        </div>
                                        </div>
                                        </div>

                                    </div>
                                </div>
                            </div>






                            </div>



                        </div> -->
