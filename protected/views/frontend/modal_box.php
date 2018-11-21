<?php
$receiptnistAccess = $_SESSION['user_id'] == 121 ? array('114', '115') : array();
$mul_doctor_id_array = !empty($_GET['mul_doctor_id']) ? explode(",", $_GET['mul_doctor_id']) : array();
$mul_doctor_condition = !empty($receiptnistAccess) ? " AND FIND_IN_SET(user_id,'" . implode(",", $receiptnistAccess) . "')" : "";
?>
<!-- Modal box to Add New Customer -->
<div id="myModal_add_customer" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div id="after_post_message_customer"></div>
            <form id="add_customer_form" method="post" class="form-horizontal" action="" enctype="multipart/form-data">
                <input type="hidden" name="add_customer_submit" value="add_customer_submit">
                <div class="modal-header">

                    <h4 class="modal-title">Aggiungi nuovo Paziente</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label col-md-4">Nome e Cognome<font color="red">*</font></label>
                        <div class="col-md-7">
                            <input class="form-control" type="text" name="customer_fname" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4"></label>
                        <div class="col-md-7">
                            <input class="form-control" type="text" name="customer_lname" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Email</label>
                        <div class="col-md-7">
                            <input class="form-control" type="text" name="customer_email" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Tel. mobile</label>
                        <div class="col-md-7">
                            <input class="form-control" type="text" name="customer_mphone" value="">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-info" name="add_customer_form_submit" type="submit"><i
                                class="fa fa-save"></i> Invia
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i
                                class="fa fa-times-circle"></i> Chiudi
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
<!-- Modal box to Add New staff -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div id="after_post_message"></div>
            <form id="add_staff_form" method="post" class="form-horizontal" action="" enctype="multipart/form-data">
                <input type="hidden" name="add_staff_submit" value="add_staff_submit">
                <div class="modal-header">

                    <h4 class="modal-title">Aggiungi nuovo membro Staff</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label col-md-4">Nome e Cognome<font color="red">*</font></label>
                        <div class="col-md-7">
                            <input class="form-control" type="text" name="staff_fname" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4"></label>
                        <div class="col-md-7">
                            <input class="form-control" type="text" name="staff_lname" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Email<font color="red">*</font></label>
                        <div class="col-md-7">
                            <input class="form-control" type="text" name="staff_email" value="">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-info" name="add_staff_form_submit" type="submit"><i class="fa fa-save"></i>
                        Invia
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i
                                class="fa fa-times-circle"></i> Chiudi
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
<!-- Modal box to delete Account-->
<div id="delete_account" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div id="after_post_message_close_account_form"></div>
            <form id="close_account_form" method="post" class="form-horizontal" action="" enctype="multipart/form-data">
                <input type="hidden" name="close_account_submit" value="close_account_submit">
                <input type="hidden" name="company_id" value="<?php echo CURRENT_LOGIN_COMPANY_ID; ?>">
                <input type="hidden" name="company_name" value="<?php echo COMPANY_NAME; ?>">
                <input type="hidden" name="company_email" value="<?php echo COMPANY_EMAIL; ?>">
                <div class="modal-header">

                    <h4 class="modal-title">Thanks for giving us a try.</h4>
                    <p>Before you leave please let us know why we didn't meet your needs.</p>
                </div>
                <div class="modal-body">
                    <div class="form-group">

                        <div class="col-md-12">
                            <textarea placeholder="I'm closing my account because..." class="form-control"
                                      name="close_reason"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" name="close_account_form_submit" type="submit">Close My Account
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i
                                class="fa fa-times-circle"></i> Close
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
<!-- Modal box to Add New Time off -->
<div id="myModal_timeoff" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div id="after_post_message_timeoff"></div>
            <form id="add_timeoff_form" method="post" class="form-horizontal" action="" enctype="multipart/form-data">
                <input type="hidden" name="add_timeoff_submit" value="add_timeoff_submit">
                <input type="hidden" name="staff_id" value="<?php echo $edit_staff_id; ?>">
                <input type="hidden" name="company_id" value="<?php echo CURRENT_LOGIN_COMPANY_ID; ?>">
                <div class="modal-header">

                    <h4 class="modal-title">Add New Time Off</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label col-md-4">Start Date</label>
                        <div class="col-md-7">
                            <input class="form-control datepicker" type="text" name="timeoff_start_date" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">End Date</label>
                        <div class="col-md-7">
                            <input class="form-control datepicker" type="text" name="timeoff_end_date" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Note</label>
                        <div class="col-md-7">
                            <input class="form-control " type="text" name="timeoff_notes" value="">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-info" name="add_time_form_submit" type="submit"><i class="fa fa-save"></i>
                        Invia
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i
                                class="fa fa-times-circle"></i> Chiudi
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
<!-- Modal box to Add Appointment -->
<?php if ($query1ans == "edit_customer") { ?>
    <div id="myModal_add_appointment" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div id="after_post_message_appointment"></div>
                <form id="add_appointment_form" method="post" class="form-horizontal" action=""
                      enctype="multipart/form-data">
                    <input type="hidden" name="add_appointment_submit" value="add_appointment_submit">
                    <input type="hidden" name="customer_id" value="<?php echo $edit_id; ?>">
                    <input type="hidden" name="booking_from" value="<?php echo $query1ans; ?>">
                    <input type="hidden" name="private" value="no">
                    <input type="hidden" name="care_id" class="hidden_care_id">
                    <div class="modal-header">
                        <h4 class="modal-title">Aggiungi appuntamento</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Dottore<font color="red">*</font></label>
                            <div class="col-md-8">
                                <select class="form-control" name="service_provider" id="load_services_by_provider">
                                    <option value="">---Seleziona---</option>
                                    <?php
                                    //$provider = $db->get_all('users', array('visibility_status' => 'active', 'user_type' => 'staff', 'company_id' => CURRENT_LOGIN_COMPANY_ID));
                                    $com_id = CURRENT_LOGIN_COMPANY_ID;
                                    $provider = $db->run("SELECT* FROM `users` WHERE `visibility_status`='active' AND `company_id`='$com_id' AND `user_type`='staff' $mul_doctor_condition")->fetchAll();
                                    if (is_array($provider)) {
                                        foreach ($provider as $pro) {
                                            ?>
                                            <option value="<?php echo $pro['user_id'] ?>"><?php echo $pro['firstname'] . " " . $pro['lastname']; ?></option>
                                        <?php }
                                    } ?>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Prestazione<font color="red">*</font></label>
                            <div class="col-md-8">
                                <select class="form-control load_services" name="appointment_service"
                                        id="load_cost_time_by_service">

                                </select>
                            </div>
                        </div>
                        <div class="form-group load_costandtime">

                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Giorno/Ora</label>
                            <div class="col-md-5">
                                <input class="form-control care_plan_date datepicker" type="text"
                                       name="appointment_date" value="<?php echo date('d-m-Y'); ?>"
                                       id="get_date_calender">

                            </div>
                            <div class="col-md-3">
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

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-info" name="add_time_form_submit" type="submit"><i
                                    class="fa fa-save"></i> Invia
                        </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal"><i
                                    class="fa fa-times-circle"></i> Chiudi
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
<?php } ?>
<!-- Modal box to Edit Appointment -->
<div id="myModal_edit_appointment" class="modal fade myModal_edit_appointment" role="dialog">
    <div class="modal-dialog">

        <form id="edit_appointment_form" method="post" class="form-horizontal" action="" enctype="multipart/form-data">
            <div class="modal-content">
                <div id="after_post_message_appointment_edit"></div>
                <div class="modal-header">
                    <h4 class="modal-title">Modifica appuntamento</h4>
                </div>
                <div class="modal-body" id="load_edit_appointmentform">


                </div>
            </div>
        </form>
    </div>
</div>
<!-- Modal box to Update Memo notice -->
<div id="myModal_edit_memo" class="modal fade myModal_edit_memo" role="dialog">
    <div class="modal-dialog">

        <form id="edit_memo_form" method="post" class="form-horizontal" action="" enctype="multipart/form-data">
            <div class="modal-content">
                <div id="after_post_message_memo_edit"></div>
                <div class="modal-header">
                    <h4 class="modal-title">Modifica Memo</h4>
                </div>
                <div class="modal-body" id="load_edit_memoform">


                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal box to Cancel Appointment -->
<div id="myModal_cancel_appointment" class="modal fade myModal_cancel_appointment" role="dialog">
    <div class="modal-dialog">

        <form id="cancel_appointment_form" method="post" class="form-horizontal" action=""
              enctype="multipart/form-data">
            <div class="modal-content">
                <div id="after_post_message_appointment_cancel"></div>
                <div class="modal-header">
                    <h4 class="modal-title">Cancella Appuntamento</h4>
                </div>
                <div class="modal-body" id="load_cancel_appointmentform">


                </div>
            </div>
        </form>
    </div>
</div>
<!-- Modal box to edit Booking from care plan -->
<div id="myModal_edit_booking" class="modal fade myModal_edit_booking" role="dialog">
    <div class="modal-dialog">

        <form id="edit_booking_form" method="post" class="form-horizontal" action="" enctype="multipart/form-data">
            <div class="modal-content">
                <div id="after_post_message_edit_booking"></div>
                <div class="modal-header">
                    <h4 class="modal-title">Aggiorna prenotazione</h4>
                </div>
                <div class="modal-body" id="load_edit_booking_form">


                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal box to assign rooms -->
<div id="myModal_assign_room" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div id="after_post_message_assign_room_form"></div>
            <form id="assign_room_form" method="post" class="form-horizontal" action="" enctype="multipart/form-data">
                <input type="hidden" name="assign_room_submit" value="assign_room_submit">
                <div class="modal-header">
                    <h4 class="modal-title">Add Room/Seat</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label col-md-4">Room/Seat</label>
                        <div class="col-md-7">
                            <input class="form-control" type="hidden" name="appointment_id" value=""
                                   id="appoint_assign_room">

                            <select class="form-control" name="room_id">
                                <option value="">Select Room</option>
                                <?php $all_room = $db->get_all('rooms', array('visibility_status' => 'active', 'company_id' => CURRENT_LOGIN_COMPANY_ID,));
                                if (is_array($all_room)) {
                                    foreach ($all_room as $allr) {
                                        ?>
                                        <option value="<?php echo $allr['id']; ?>"><?php echo ucwords($allr['name']); ?></option>
                                    <?php }
                                } ?>


                            </select>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button class="btn btn-info" name="edit_appointment_form_submit" type="submit"><i
                                class="fa fa-save"></i> Invia
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i
                                class="fa fa-times-circle"></i> Chiudi
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>


<!-- Modal box to filter dashboard content -->
<div id="myModal_dashboard_filter" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">

            <form method="post" class="form-horizontal" action="" enctype="multipart/form-data">
                <input type="hidden" name="add_staff_submit" value="add_staff_submit">
                <div class="modal-header">

                    <h4 class="modal-title">Filter By</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label col-md-4">Select<font color="red">*</font></label>
                        <div class="col-md-7">
                            <select class="form-control" name="filter_by_dashboard">
                                <option value="today">Today</option>
                                <option value="thisweek">This Week</option>
                                <option value="nextweek">Next Week</option>
                                <option value="thismonth">This Month</option>
                                <option value="nextmonth">Next Month</option>
                            </select>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button class="btn btn-info" name="dashboard_filter_submit" type="submit"><i
                                class="fa fa-filter"></i> Filter
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i
                                class="fa fa-times-circle"></i> Close
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>


<!-- modal box to add services -->
<div id="myModal_add_sevice" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form id="add_service_form" method="post" class="form-horizontal" action="<?php $_SERVER['PHP_SELF']; ?>"
              enctype="multipart/form-data">
            <input type="hidden" name="add_service_submit" value="add_service_submit">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add service</h4>
                </div>
                <div id="after_post_message_add_service"></div>
                <div class="modal-body">


                    <div class="form-group">
                        <label class="control-label col-md-4">Service Name<font color="red">*</font></label>
                        <div class="col-md-3">
                            <!-- <input class="form-control"  type="color" name="service_color" value="<?php echo $_POST['service_color']; ?>"> -->
                            <select id="scolor" class="form-control" name="service_color">
                                <option value="danger" class="text-danger">Red</option>
                                <option value="success" class="text-success">Green</option>
                                <option value="primary" class="text-primary">Blue</option>
                                <option value="info" class="text-info">Sky Blue</option>
                                <option value="warning" class="text-warning">Orange</option>
                                <option value="mint" class="text-mint">Mint Green</option>
                                <option value="pink" class="text-pink">pink</option>
                                <option value="purple" class="text-purple">purple</option>
                                <option value="dark" class="text-dark">Black</option>
                                <option value="default" class="text-default">Gray</option>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <input class="form-control" type="text" name="service_name"
                                   value="<?php echo $_POST['service_name']; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-4">Service description</label>
                        <div class="col-md-8">
                            <textarea class="form-control"
                                      name="service_description"><?php echo $_POST['service_description']; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group" id="business_name_id">
                        <label class="control-label col-md-4">Service Cost<font color="red">*</font></label>
                        <div class="col-md-8">
                            <input class="form-control" placeholder="" type="text" name="service_cost"
                                   value="<?php echo $_POST['service_cost']; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Service Time(Mins)<font color="red">*</font></label>
                        <div class="col-md-8">
                            <input class="form-control" placeholder="" type="number" name="service_time"
                                   value="<?php echo $_POST['service_time']; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Service Buffer Time(Mins)</label>

                        <div class="col-md-8">
                            <input class="form-control" placeholder="" type="number" name="service_buffer_time"
                                   value="<?php echo $_POST['service_buffer_time']; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Category</label>
                        <div class="col-md-8">
                            <select class="form-control" name="service_category">
                                <option value="">Select Category</option>
                                <?php $all_service_categoy = $db->get_all('service_category', array('visibility_status' => 'active', 'company_id' => CURRENT_LOGIN_COMPANY_ID,));
                                if (is_array($all_service_categoy)) {
                                    foreach ($all_service_categoy as $allcs) {
                                        ?>
                                        <option <?php if ($_POST['service_category'] == $allcs['id']) {
                                            echo "selected";
                                        }; ?> value="<?php echo $allcs['id']; ?>"><?php echo $allcs['category_name']; ?></option>
                                    <?php }
                                } ?>

                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Private Service</label>
                        <div class="col-md-8">
                            <select class="form-control" name="private_service">
                                <option <?php if ($_POST['private_service'] == "no") {
                                    echo "selected";
                                }; ?> value="no">No
                                </option>
                                <option <?php if ($_POST['private_service'] == "yes") {
                                    echo "selected";
                                }; ?> value="yes">Yes
                                </option>
                            </select>
                        </div>
                    </div>
                    <!--  <div class="form-group">
                           <label class="control-label col-md-4">Status</label>
                           <div class="col-md-8">
                              <select class="form-control" name="visibility_status">
                                 <option value="active" <?php if ($_POST['visibility_status'] == 'active') {
                        echo 'selected';
                    } ?>>Active</option>
                                 <option value="inactive" <?php if ($_POST['visibility_status'] == 'inactive') {
                        echo 'selected';
                    } ?>>Inactive</option>
                              </select>
                           </div>
                         </div> -->

                    <div class="form-group">
                        <label class="col-md-4 control-label">Who can provide the service</label>
                        <div class="col-md-8">
                            <?php $all_staff = $db->get_all('users', array('visibility_status' => 'active', 'company_id' => CURRENT_LOGIN_COMPANY_ID,));
                            if (is_array($all_staff)) {
                                foreach ($all_staff as $as) {
                                    ?>
                                    <div class="checkbox12">
                                        <label class="form-checkbox form-icon form-text">
                                            <input type="checkbox" name="assign_to[]"
                                                   value="<?php echo $as['user_id'] ?>"><?php echo $as['firstname'] . " " . $as['lastname']; ?>
                                        </label>
                                    </div>

                                <?php }
                            } ?>


                        </div>

                    </div>


                </div>
                <div class="modal-footer">
                    <button class="btn btn-block btn-info" name="add_service_form_submit" type="submit"><i
                                class="fa fa-save"></i> Submit
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>


<!-- Modal box to Add Payment -->
<div id="myModal_payment" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div id="after_post_message_payment"></div>
            <br>
            <form id="add_payment_form" method="post" class="form-horizontal" action="" enctype="multipart/form-data">
                <input type="hidden" name="add_payment_submit" value="add_payment_submit">
                <input type="hidden" name="appointment_id" value="" id="payment_data_appointment_id">
                <input type="hidden" name="company_id" value="<?php echo CURRENT_LOGIN_COMPANY_ID; ?>">
                <div class="modal-header">

                    <h4 class="modal-title">Aggiungi Pagamento</h4>
                </div>
                <div class="modal-body">
                    <div class="invoice-wrapper">
                        <section class="invoice-container">
                            <div class="invoice-inner">

                                <div class="row">
                                    <div class="col-xs-6">
                                        <h3>Appuntamento</h3>
                                        <address id="payment_data_customer"></address>
                                    </div>
                                    <div class="col-xs-6 text-right">
                                        <h3 id="payment_data_booking_id"></h3>
                                        <strong>Data prenotazione:</strong>
                                        <br>
                                        <p id="payment_data_booking_date"></p>
                                        <br>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 pad-top">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Riepilogo Prenotazione</h3>
                                            </div>
                                            <div class="panel-body">
                                                <div class="table-responsive">
                                                    <table class="table table-condensed">
                                                        <thead>
                                                        <tr>
                                                            <td><strong>Prestazione</strong></td>
                                                            <td class="text-center"><strong>Costo</strong></td>
                                                            <td class="text-center"><strong>Quantita'</strong></td>
                                                            <td class="text-right"><strong>Totale</strong></td>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td id="payment_data_service_name"></td>
                                                            <td class="text-center" id="payment_data_service_cost"></td>
                                                            <td class="text-center">1</td>
                                                            <td class="text-right"
                                                                id="payment_data_service_cost_total"></td>
                                                        </tr>


                                                        <tr>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="no-line text-center"><strong>Totale</strong></td>
                                                            <td class="no-line text-right"
                                                                id="payment_data_service_cost_total_final">$685.99
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="no-line text-center"><strong>Acconto</strong>
                                                            </td>
                                                            <td class="no-line text-right"
                                                                id="data_payment_sum_advance"></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <strong>Modalita' pagamento</strong>
                                        <br> <select class="form-control" name="payment_type">
                                            <option value="cash">Contanti</option>
                                            <option value="cheque">Assegno</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-6">
                                        <strong>Importo</strong> <input class="form-control" name="payment_amount"
                                                                        value="" id="payment">


                                    </div>

                                </div>

                            </div>
                        </section>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-info" name="add_payment_submit" type="submit"><i class="fa fa-save"></i>
                        Invia
                    </button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i
                                class="fa fa-times-circle"></i> Chiudi
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

<!-- Modal box to Add myModal_notification -->
<div id="myModal_notification" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div id="after_post_message_notification"></div>
            <br>
            <form id="add_notification_form" method="post" class="form-horizontal" action=""
                  enctype="multipart/form-data">
                <input type="hidden" name="add_notification_submit" value="add_notification_submit">
                <input type="hidden" name="company_id" value="<?php echo CURRENT_LOGIN_COMPANY_ID; ?>">
                <div class="modal-header">

                    <h4 class="modal-title">Aggiungi MEMO del GIORNO</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label col-md-4"> Data</label>
                        <div class="col-md-8">
                            <input class="form-control datepicker" type="text" name="notification_date" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Descrizione<font color="red">*</font></label>
                        <div class="col-md-8">
                            <textarea class="form-control" name="notification"></textarea>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-info" name="submit" type="submit"><i class="fa fa-save"></i> Invia</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i
                                class="fa fa-times-circle"></i> Chiudi
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>


<div id="myModal_notes" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div id="after_post_message_notification"></div>
            <br>
            <form id="add_notes_form" method="post" class="form-horizontal" action="" enctype="multipart/form-data">
                <input type="hidden" name="add_notes_submit" value="add_notification_submit">
                <input type="hidden" name="note_id" value="">
                <div class="modal-header">

                    <h4 class="modal-title">Aggiungi NOTA</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label col-md-4">Mostra dal giorno</label>
                        <div class="col-md-8">
                            <input class="form-control datepicker" type="text" name="start_date" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">fino al giorno</label>
                        <div class="col-md-8">
                            <input class="form-control datepicker" type="text" name="end_date" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Descrizione<font color="red">*</font></label>
                        <div class="col-md-8">
                            <textarea class="form-control" name="notification"></textarea>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-info" name="submit" type="submit"><i class="fa fa-save"></i> Invia</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i
                                class="fa fa-times-circle"></i> Chiudi
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>