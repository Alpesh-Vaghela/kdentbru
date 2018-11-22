<?php
if (file_exists(SERVER_ROOT . '/protected/views/frontend/modal_box.php')) {
    require SERVER_ROOT . '/protected/views/frontend/modal_box.php';
}
?>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/js-cookie/2.2.0/js.cookie.min.js"></script>
<aside id="aside-container">
    <div id="aside">
        <div class="nano closed">
            <div class="nano-content">
                <div class="fade in active">
                    <h4 class="pad-hor text-thin"> Activity </h4>
                    <ul class="list-group bg-trans">
                        <?php
                        $db->order_by = 'id DESC';
                        if ($_SESSION['user_type'] == "staff") {
                            $all_activity_log = $db->get_all('activity_logs', array('company_id' => CURRENT_LOGIN_COMPANY_ID, 'user_id' => $_SESSION['user_id']));
                        } else {
                            $all_activity_log = $db->get_all('activity_logs', array('company_id' => CURRENT_LOGIN_COMPANY_ID));
                        }

                        if (is_array($all_activity_log)) {
                            foreach ($all_activity_log as $alla) {
                                if (is_array($common_data_activity_alert) && in_array($alla['event_type'], $common_data_activity_alert)) {
                                    ?>


                                    <li class="list-group-item">

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

                                            ?>">


                                            </button>
                                        </div>
                                        <div class="inline-block">
                                            <div class="text-small">
                                                <?php
                                                if ($alla['event_type'] == "customer_created" || $alla['event_type'] == "customer_updated" || $alla['event_type'] == "customer_deleted") {
                                                    if ($db->exists('customers', array('id' => $alla['event_type_id']))) {
                                                        ?>
                                                        <a href="<?php echo $link->link('edit_customer', frontend, '&action_edit=' . $alla['event_type_id']); ?>"><?php echo $alla['event']; ?></a>

                                                    <?php } else {
                                                        ?>
                                                        <a href="<?php echo $link->link('customers', frontend); ?>"><?php echo $alla['event']; ?></a>
                                                    <?php }
                                                } elseif ($alla['event_type'] == "appointment_created" || $alla['event_type'] == "appointment_updated" || $alla['event_type'] == "appointment_deleted") {
                                                    if ($db->exists('appointments', array('id' => $alla['event_type_id']))) {

                                                        $appointment_status = $db->get_var('appointments', array('id' => $alla['event_type_id']), 'status');
                                                        if ($appointment_status != "paid") {

                                                            ?>
                                                            <a data-toggle="modal"
                                                               data-target="#myModal_edit_appointment"
                                                               data="<?php echo $alla['event_type_id']; ?>"
                                                               class="edit_modal_edit_customer"><?php echo $alla['event']; ?></a>
                                                        <?php } else {
                                                            ?>
                                                            <a href="<?php echo $link->link('quick_booking', frontend); ?>"><?php echo $alla['event']; ?></a>
                                                        <?php }
                                                    } else {
                                                        ?>
                                                        <a href="<?php echo $link->link('quick_booking', frontend); ?>"><?php echo $alla['event']; ?></a>

                                                    <?php }
                                                } ?>


                                            </div>
                                            <small class="text-muted"><?php echo date('d, M Y h:i:s', strtotime($alla['timestamp'])); ?></small>
                                        </div>

                                    </li>

                                <?php } else {
                                    ?>
                                    <?php if ($_SESSION['user_type'] == "admin") { ?>
                                        <h5>Click here for<a tab="activity_alert_notification" class="set_cookie"
                                                             href="<?php echo $link->link('notifications') ?>"
                                                             style="color:red;"> Notification </a> settings!</h5>
                                    <?php } ?>
                                    <?php
                                    break;
                                }
                            }
                        } else {
                            echo "No Activity Perform Yet!";
                        } ?>

                    </ul>
                </div>
            </div>
        </div>
    </div>
</aside>

</div>
<!-- FOOTER -->
<!--===================================================-->
<footer id="footer">
    <!-- Visible when footer positions are fixed -->
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <div class="show-fixed pull-right">
        <ul class="footer-list list-inline">
            <li>
                <p class="text-sm">SEO Proggres</p>
                <div class="progress progress-sm progress-light-base">
                    <div style="width: 80%" class="progress-bar progress-bar-danger"></div>
                </div>
            </li>
            <li>
                <p class="text-sm">Online Tutorial</p>
                <div class="progress progress-sm progress-light-base">
                    <div style="width: 80%" class="progress-bar progress-bar-primary"></div>
                </div>
            </li>
            <li>
                <button class="btn btn-sm btn-dark btn-active-success">Checkout</button>
            </li>
        </ul>
    </div>
    <!-- Visible when footer positions are static -->
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <!--   <div class="hide-fixed pull-right pad-rgt">Currently v2.2</div> -->
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <!-- Remove the class name "show-fixed" and "hide-fixed" to make the content always appears. -->
    <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
    <!--    <p class="pad-lft">&#0169; 2015 Your Company</p> -->
</footer>
<!--===================================================-->
<!-- END FOOTER -->
<!-- SCROLL TOP BUTTON -->
<!--===================================================-->
<button id="scroll-top" class="btn"><i class="fa fa-chevron-up"></i></button>
<!--===================================================-->
</div>


<!--===================================================-->
<!-- END OF CONTAINER -->
<!--JAVASCRIPT-->
<!--=================================================-->
<!--jQuery [ REQUIRED ]-->
<script src="<?php echo SITE_URL . '/assets/frontend/js/jquery-2.1.1.min.js'; ?>"></script>
<script src="<?php echo SITE_URL . '/assets/frontend/js/jquery-ui.min.js'; ?>"></script>
<script src="<?php echo SITE_URL . '/assets/frontend/js/bootstrap.min.js'; ?>"></script>
<script src="<?php echo SITE_URL . '/assets/frontend/plugins/fast-click/fastclick.min.js'; ?>"></script>
<script src="<?php echo SITE_URL . '/assets/frontend/js/scripts.js'; ?>"></script>
<script src="<?php echo SITE_URL . '/assets/frontend/plugins/nanoscrollerjs/jquery.nanoscroller.min.js'; ?>"></script>
<script src="<?php echo SITE_URL . '/assets/frontend/plugins/metismenu/metismenu.min.js'; ?>"></script>
<script src="<?php echo SITE_URL . '/assets/frontend/plugins/switchery/switchery.min.js'; ?>"></script>
<script src="<?php echo SITE_URL . '/assets/frontend/plugins/bootstrap-select/bootstrap-select.min.js'; ?>"></script>
<!--<script src="<?php echo SITE_URL . '/assets/frontend/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js'; ?>"></script>
        <script src="<?php echo SITE_URL . '/assets/frontend/plugins/tag-it/tag-it.min.js'; ?>"></script>
        <script src="<?php echo SITE_URL . '/assets/frontend/plugins/chosen/chosen.jquery.min.js'; ?>"></script>
      -->

<script src="<?php echo SITE_URL . '/assets/frontend/plugins/screenfull/screenfull.js'; ?>"></script>


<!--DataTables [ OPTIONAL ]-->
<script src="<?php echo SITE_URL . '/assets/frontend/plugins/datatables/media/js/jquery.dataTables.js'; ?>"></script>
<script src="<?php echo SITE_URL . '/assets/frontend/plugins/datatables/media/js/dataTables.bootstrap.js'; ?>"></script>
<script src="<?php echo SITE_URL . '/assets/frontend/plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js'; ?>"></script>
<script src="<?php echo SITE_URL . '/assets/frontend/js/demo/tables-datatables.js'; ?>"></script>
<script src="<?php echo SITE_URL . '/assets/frontend/plugins/summernote/summernote.min.js'; ?>"></script>


<?php if ($query1ans == "staff" || $query1ans == "account_preferences"
    || $query1ans == "edit_customer"
    || $query1ans == "edit_customer"
    || $query1ans == "add_service"
    || $query1ans == "home"
    || $query1ans == "quick_booking" || $query1ans == "calendar" || $query1ans == "calendar_day") { ?>
    <!--    <script src="<?php echo SITE_URL . '/assets/frontend/plugins/dropzone/dropzone.min.js'; ?>"></script> -->
    <!--   <script src="<?php echo SITE_URL . '/assets/frontend/plugins/bootstrap-timepicker/bootstrap-timepicker.min.js'; ?>"></script> -->
    <script src="<?php echo SITE_URL . '/assets/frontend/plugins/bootstrap-datepicker/moment.js'; ?>"></script>
    <script src="<?php echo SITE_URL . '/assets/frontend/plugins/bootstrap-datepicker/bootstrap-datepicker.it.min.js'; ?>"></script>
    <script src="<?php echo SITE_URL . '/assets/frontend/plugins/bootstrap-datepicker/bootstrap-datepicker.js'; ?>"></script>
    <script src="<?php echo SITE_URL . '/assets/frontend/plugins/bootstrap-datepicker/bootstrap-datepicker.it.min.js'; ?>"></script>
    <script src="<?php echo SITE_URL . '/assets/frontend/js/demo/form-switchery.js12'; ?>"></script>
    <!--     <script src="<?php echo SITE_URL . '/assets/frontend/js/demo/form-component.js'; ?>"></script> -->
    <script>
        $('.datepicker').datepicker({

            format: "dd-mm-yyyy",
            todayBtn: "linked",
            autoclose: true,
            todayHighlight: true,
            startDate: new Date(),
            language: 'it'
        });
        $('.datepicker_account_preferences').datepicker({

            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true,
            language: 'it'

        });
        $('.datepicker_account_preferences2').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true,
            language: 'it'

        });
    </script>
<?php } ?>

<?php if ($query1ans == "calendar") { ?>
    <!--Full Calendar [ OPTIONAL ]-->

    <script src="<?php echo SITE_URL . '/assets/frontend/plugins/chosen/chosen.jquery.min.js'; ?>"></script>
    <link rel="stylesheet" href="<?php echo SITE_URL . '/assets/frontend/plugins/chosen/chosen.min.css'; ?>"/>

    <script src="<?php echo SITE_URL . '/assets/frontend/plugins/fullcalendar/lib/moment.min.js'; ?>"></script>
    <script src="<?php echo SITE_URL . '/assets/frontend/plugins/fullcalendar/lib/jquery-ui.custom.min.js'; ?>"></script>


    <script src="<?php echo SITE_URL . '/assets/frontend/plugins/fullcalendar/fullcalendar.min.js'; ?>"></script>
    <script type="text/javascript"
            src="<?php echo SITE_URL . '/assets/frontend/plugins/fullcalendar/locale-all.js' ?>"></script>

    <script>
        $("#mul_doctor_id").chosen({width: '100%'});

        function reload_calender() {
            var d = $('#demo-calendar12').fullCalendar('getDate');
            var new_d = moment(d).format('DD-MM-YYYY');
            var cal_view = $('#demo-calendar12').fullCalendar('getView');
            var mul_doctor_id = $("#mul_doctor_id").val();
            if (mul_doctor_id === null) {
                mul_doctor_id = "";
            }
            var new_url = "index.php?user=calendar&c_date=" + new_d + "&cal_view=" + cal_view.name + '&mul_doctor_id=' + mul_doctor_id;
            window.location.href = new_url;
            $('#demo-calendar12').fullCalendar('refetchEvents');
        }

        var getUrlParameter = function getUrlParameter(sParam) {
            var sPageURL = decodeURIComponent(window.location.search.substring(1)),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;

            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');

                if (sParameterName[0] === sParam) {
                    return sParameterName[1] === undefined ? true : sParameterName[1];
                }
            }
        }

        function load_calender(c_date) {
            // alert(c_date);
            $('#demo-calendar12').fullCalendar({

                customButtons: {
                    EventButton: {
                        text: 'Appuntamenti DOTTORI',
                        click: function (event, jsEvent, view) {
                            window.location.href = '<?php echo $link->link('calendar_day', frontend);?>';
                        }
                    }
                },
                header: {
                    left: 'myCustomButton ',
                    center: 'today, prev, title, next',
                    right: 'month, agendaWeek, agendaDay<?php if ($_SESSION['user_type'] == "admin"){?>, EventButton<?php }?>'
                },
                timeFormat: 'hh:mm',//'hh:mm:ss a',
                editable: true,
                droppable: true, // this allows things to be dropped onto the calendar
                eventDrop: function (event, delta, revertFunc) {
                    $(".popover").remove();
                    $.post('<?php echo $link->link('ajax', frontend);?>&edit=appointment_date&id=' + event.id + '&appointment_start_date_time=' + event.start.format() + '&appointment_end_date_time=' + event.end.format());
                },
                defaultView: '<?php
                    if (DEFAULT_CALENDAR == "daily") {
                        echo 'agendaDay';
                    } elseif (DEFAULT_CALENDAR == 'weekly') {
                        echo 'agendaWeek';
                    } else {
                        echo 'month';
                    }?>',
                defaultDate: c_date,
                firstDay: '<?php echo WEEK_START_DAY;?>',
                slotDuration: '<?php
                    if (!empty($receiptnistAccess)) {
                        echo '00:05:00';
                    } else {
                        if (CUSTOM_TIME_SLOT == "5") {
                            echo '00:05:00';
                        } elseif (CUSTOM_TIME_SLOT == "15") {
                            echo '00:15:00';
                        } elseif (CUSTOM_TIME_SLOT == '30') {
                            echo '00:30:00';
                        } elseif (CUSTOM_TIME_SLOT == '60') {
                            echo '01:00:00';
                        }
                    }
                    ?>',
                locale: '<?php echo PREFERRED_LANGUAGE; ?>',
                scrollTime: "<?php echo CALENDAR_START_HOUR; ?>", //3pm
                minTime: '08:00:00',
                maxTime: '20:00:00',
                selectable: true,
                selectHelper: true,
                select: function (start, end) {
                    var allDay = !start.hasTime() && !end.hasTime();
                    $("#get_date_calender").val(moment(start).format('DD-MM-YYYY'));
                    $("#get_date_calender").val(moment(start).format('DD-MM-YYYY'));
                    $('#fullCalModal_add_appointment').modal();
                    $('#demo-calendar12').fullCalendar('unselect');
                },
                eventLimit: true, // allow "more" link when too many events
                businessHours: [<?php echo $business_day;?> ],
                hiddenDays: [<?php echo $offday_new;?>],
                events: [
                    <?php
                    $mul_doctor_id_array = !empty($_GET['mul_doctor_id']) ? explode(",", $_GET['mul_doctor_id']) : $receiptnistAccess;
                    $mul_doctor_condition = !empty($mul_doctor_id_array) ? " AND FIND_IN_SET(staff_id,'" . implode(",", $mul_doctor_id_array) . "')" : "";
                    if ($_SESSION['user_type'] == "staff") {
                        $alla = $db->run("SELECT * FROM `appointments` WHERE `company_id`= " . CURRENT_LOGIN_COMPANY_ID . " AND `staff_id`='" . $_REQUEST['loadfor'] . "' AND `private`='no' AND `status` != 'deleted' $mul_doctor_condition")->fetchAll();
                    } elseif ($_SESSION['user_type'] == "receptionist") {
                        if (isset($_REQUEST['loadfor'])) {
                            $alla = $db->run("SELECT * FROM `appointments` WHERE `company_id`= " . CURRENT_LOGIN_COMPANY_ID . " AND `staff_id`='" . $_REQUEST['loadfor'] . "' AND `status` != 'deleted' $mul_doctor_condition ")->fetchAll();
                        } else {
                            $alla = $db->run("SELECT * FROM `appointments` WHERE `company_id`= " . CURRENT_LOGIN_COMPANY_ID . " AND `status` != 'deleted' $mul_doctor_condition ")->fetchAll();
                        }
                    } else {
                        if (isset($_REQUEST['loadfor'])) {
                            $alla = $db->run("SELECT * FROM `appointments` WHERE `company_id`= " . CURRENT_LOGIN_COMPANY_ID . " AND `staff_id` = '" . $_REQUEST['loadfor'] . "' AND `status` != 'deleted' $mul_doctor_condition ")->fetchAll();
                        } else {
                            $alla = $db->run("SELECT * FROM `appointments` WHERE `company_id`= " . CURRENT_LOGIN_COMPANY_ID . " AND `appointment_date` >= CURDATE() AND `status` != 'deleted' $mul_doctor_condition ")->fetchAll();
                        }
                    }
                    if (is_array($alla))
                    {
                    foreach ($alla as $aa){
                    $staff_details = $db->get_all('users', array('user_id' => $aa['staff_id']));
                    $customer_details = $db->get_all('customers', array('id' => $aa['customer_id']));
                    $customer_firstname = $db->get_var('customers', array('id' => $aa['customer_id']), 'first_name');
                    $customer_lastname = $db->get_var('customers', array('id' => $aa['customer_id']), 'last_name');
                    $customer_phone = $db->get_var('customers', array('id' => $aa['customer_id']), 'mobile_number');
                    $company_name = $db->get_var('company', array('id' => $aa['company_id']), 'company_name');
                    $customer_fullname = $aa['customer_name'];
                    $service_name = $db->get_var('services', array('id' => $aa['service_id']), 'service_name');
                    $service_color = $db->get_var('services', array('id' => $aa['service_id']), 'service_color');
                    $service_provider_firstname = $db->get_var('users', array('user_id' => $aa['staff_id']), 'firstname');
                    $service_provider_lastname = $db->get_var('users', array('user_id' => $aa['staff_id']), 'lastname');
                    $service_cost = $aa['service_cost'];
                    $appointment_date = $aa['appointment_date'];
                    $appointment_time = $aa['appointment_time'];
                    $type = $aa['private'];
                    $appointment_note = $aa['notes'];
                    $appointment_status = $aa['status'];
                    $color = $staff_details[0]['colour'];
                    $pathology = ($customer_details[0]['pathology'] == 'yes') ? '***' : '';
                    $selectedTime = $appointment_time;
                    $st = $aa['service_time'] + $aa['service_buffer_time'];
                    $service_time = "+" . $st . " minutes";
                    $endTime = strtotime($service_time, strtotime($selectedTime));
                    $service_end_time = date('H:i:s', $endTime);
                    $appointment_end_time = $aa['appointment_end_time'];
                    $customer_regular = !empty($customer_details['customer_regular']) ? true : false;
                    $customer_regular_class = $customer_details ? "text-bold" : "";
                    ?>
                    {
                        title: "<?php echo ucfirst($service_provider_firstname);?> <?php echo $service_provider_lastname;?> Customer:<?php echo $customer_fullname;?> <?php echo $pathology; ?> Notes: <?php echo $appointment_note?>",
                        start: "<?php echo date("Y-m-d", strtotime($appointment_date)) ?>T<?php echo date('H:i:s', strtotime($appointment_time));?>",
                        end: "<?php echo date("Y-m-d", strtotime($appointment_date))?>T<?php echo date('H:i:s', strtotime($service_end_time));?>",
                        type: "<?php echo ($type == 'yes') ? 'private' : 'no-private'; ?>",
                        appointmentColor: '<?php echo $color; ?>',
                        service_provider: '<?php echo $service_provider_firstname;?>_<?php echo $service_provider_lastname?>',
                        description: 'long description3',
                        id:<?php echo $aa['id'];?>,
                        className: '<?php echo $service_color;?>',
                        modal: '#events-modal',
                        modalTitle: 'Dettagli appuntamento',
                        appointment_id: '<?php echo $aa['id'];?>',
                        appointment_date_service_time: '<?php
                            setlocale(LC_TIME, 'ita', 'it_IT');
                            $AppDateTime = ucFirst(utf8_encode(strftime('%a %d %b %Y', strtotime($appointment_date))));
                            setlocale(LC_TIME, 0);
                            echo $AppDateTime;?> <?php echo date('h:i:s', strtotime($appointment_time));?> - <?php echo date('h:i:s', strtotime($appointment_end_time));?>',
                        provider: "Dottore: <?php echo $service_provider_firstname?> <?php echo $service_provider_lastname?>",
                        service: "Prestazione: <?php echo $service_name?>",
                        cost: "Costo: <?php echo CURRENCY . "" . $service_cost?>",
                        customer: "<b>Paziente: <?php echo $customer_fullname?></b>",
                        mobile: "Mobile No: <?php echo $customer_phone; ?>",
                        notes: "Note: <?php echo $appointment_note?>",
                        status: "Stato: <?php echo $appointment_status?>"
                    },
                    <?php } ?>
                    <?php } ?>
                    <?php
                    $festivals = file_get_contents(SITE_URL . '/festivals.php');
                    $festivals = json_decode($festivals);
                    ?>


                    <?php foreach ($festivals as $festival){ ?>
                    {
                        title: "<?php echo $festival->name?>",
                        start: "<?php echo $festival->date?>",
                        description: "<?php echo $festival->date?>",
                        className: "festival-color",
                        appointmentColor: "rgba(0,0,0,0.6)",
                        backgroundColor: "black",
                        type: "Public Holiday"
                    },
                    <?php } ?>
                    <?php

                    $notes = $db->get_all('notes');


                    if (is_array($notes))
                    {
                    foreach ($notes as $note) { ?>
                    {
                        title: "<?php echo $note['notes'] ?>",
                        start: "<?php echo date("Y-m-d", strtotime($note['start'])) ?>",
                        end: "<?php echo date("Y-m-d", strtotime($note['end'])) ?>",
                        className: "notes-color",
                        note_start: "<?php echo $note['start'] ?>",
                        note_end: "<?php echo $note['end'] ?>",
                        note_id: "<?php echo $note['id'] ?>",
                        appointmentColor: "rgba(0,0,0,0.6)",
                        backgroundColor: "green",
                        type: "notes"
                    },
                    <?php
                    }
                    }

                    ?>
                ],
                eventClick: function (event, jsEvent, view) {

                    if (event.type != "Public Holiday" && event.type != "notes") {
                        var status = "";
                        if (event.status === "Stato: Visit done") {
                            status = "Stato: Visit done";
                        } else if (event.status === "Stato: visit in process") {
                            status = "Stato: Visit in Process"
                        } else if (event.status === "Stato: pending") {
                            status = "Stato: Pending";
                        } else {
                            status = event.status;
                        }
                        $('#fullCalModal').find('.change-text-app').show().text('Paziente ARRIVATO');

                        $('#appointment_id').val(event.appointment_id);
                        $('#modalTitle').html(event.modalTitle);
                        $('#timing_details').html(event.appointment_date_service_time);
                        $('#provider').html(event.provider);
                        $('#service').html(event.service);
                        $('#cost').html(event.cost);
                        $('#customer').html(event.customer);
                        $('#mobile').html(event.mobile);
                        $('#company_name').html(event.company_name);
                        $('#note').html(event.notes);
                        $('#status').html(status);
                        $('#fullCalModal').modal();

                        if (event.status === "Stato: Visit done") {
                            $('#fullCalModal').find('.change-text-app').hide();
                        } else if (event.status === "Stato: visit in process") {
                            $('#fullCalModal').find('.change-text-app').text('Visit in Process');
                        }

                    } else if (event.type === "notes") {
                        $('#add_notes_form input[name="start_date"]').val(event.note_start);
                        $('#add_notes_form input[name="end_date"]').val(event.note_end);
                        $('#add_notes_form input[name="note_id"]').val(event.note_id);
                        $('#add_notes_form textarea[name="notification"]').val(event.title);
                        $('#myModal_notes').modal('show');
                    } else {
                    }

                },
                eventRender: function (event, $el) {
                    if (window.eventScrolling) return;
                    if (event.type !== "notes" && event.title != "Public Holiday") {
                        if (event.modalTitle !== undefined && event.appointment_date_service_time !== undefined && !$("body").hasClass(".fc-unselectable")) {
                            $el.popover({
                                title: event.modalTitle,
                                content: event.appointment_date_service_time + "<br>" + event.provider + "<br>" + event.service + "<br>" + event.notes + "<br>" + event.customer + "<?php echo $pathology ?>" + "<br>" + event.mobile,
                                trigger: 'hover',
                                placement: 'top',
                                container: 'body',
                                html: true,
                            });
                            $(".popover").remove();
                        }
                    }
                },
            });
        }

        $('#demo-calendar12').on("dragstart", function () {
            window.eventScrolling = true;
        });
        $('#demo-calendar12').on("dragend", function () {
            window.eventScrolling = false;
        });

        $(document).ready(function () {
            if (getUrlParameter('c_date') != undefined && getUrlParameter('c_date') != "") {

                var new_d = "<?php echo date('Y-m-d', strtotime($_GET['c_date'])) ?>";
                load_calender(new_d);
            } else {
                load_calender('<?php echo date('Y-m-d');?>');
            }
        });

    </script>
    <script>
        $("#load_edit_appoint_form").click(function () {
            var color = $('#appointment_id').val();
            $("#fullCalModal").modal('hide');
            $.ajax({
                type: 'post',
                url: '<?php echo $link->link('ajax', frontend);?>',
                data: '&edit_appointment=' + color,
                success: function (data) {
                    $("#load_edit_appointmentform").html(data);

                }
            });

        });

        $("#load_cancel_appoint_form").click(function () {
            var color = $('#appointment_id').val();
            $("#fullCalModal").modal('hide');
            $.ajax({
                type: 'post',
                url: '<?php echo $link->link('ajax', frontend);?>',
                data: '&cancel_appointment=' + color,
                success: function (data) {
                    $("#load_cancel_appointmentform").html(data);

                }
            });

        });

        $('#delete_appointment_calendar').click(function () {
            var apid = $('#appointment_id').val();
            //alert(apid);
            $.ajax({
                type: 'post',
                url: '<?php echo $link->link('ajax', frontend);?>',
                data: '&delete_appointment=' + apid,
                dataType: 'json',
                success: function (data) {
                    $("#calendar_modal_message").html(data.msg);
                    if (data.error == false) {
                        setTimeout(function () {
                            window.location = '<?php echo $link->link('calendar', frontend);?>';
                        }, 3000);
                    }

                }
            });
        });

        $('.cancel-calender').on('click', function () {
            var apid = $('#appointment_id').val();
            $(this).attr('data', apid);
        })

        $('#update_arrival_appointment_calendar').click(function () {
            var apid = $('#appointment_id').val();
            //alert(apid);
            $.ajax({
                type: 'post',
                url: '<?php echo $link->link('ajax', frontend);?>',
                data: '&update_appointment=' + apid,
                dataType: 'json',
                success: function (data) {
                    $("#calendar_modal_message").html(data.msg);
                    if (data.error == false) {
                        setTimeout(function () {
                            window.location = '<?php echo $link->link('calendar', frontend);?>';
                        }, 3000);
                    }

                }
            });
        });

        $('#update_arrival_appointment').click(function () {
            alert();
            var apid = $('#appointment_id').val();
            //alert(apid);
            $.ajax({
                type: 'post',
                url: '<?php echo $link->link('ajax', frontend);?>',
                data: '&update_appointment=' + apid,
                dataType: 'json',
                success: function (data) {

                }
            });
        });

    </script>
<?php } ?>
<script>
    /*************************edit appointment***********************************/
    $('#edit_appointment_form').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: '<?php echo $link->link('ajax', frontend);?>',
            data: $('#edit_appointment_form').serialize(),
            dataType: 'json',
            success: function (data) {
                $("#after_post_message_appointment_edit").html(data.msg);

                if (data.error == false) {
                    setTimeout(function () {
                        $("#myModal_edit_appointment").modal('hide');
                        window.location = '';

                    }, 3000);
                }

            }
        });

    });
</script>
<script>
    /************************Edit Appointment***********************************************/
    $(function () {

        $('#edit_memo_form').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                type: 'post',
                url: '<?php echo $link->link('ajax', frontend);?>',
                data: $('#edit_memo_form').serialize(),
                dataType: 'json',
                success: function (data) {
                    $("#after_post_message_memo_edit").html(data.msg);
                    if (data.error == false) {
                        if (data.error == false) {
                            setTimeout(function () {
                                $("#myModal_edit_appointment").modal('hide');
                                window.location = '';

                            }, 3000);
                        }
                    }
                }
            });

        });

    });
</script>
<script>
    /*************************cancel appointment***********************************/
    $('#cancel_appointment_form').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: '<?php echo $link->link('ajax', frontend);?>',
            data: $('#cancel_appointment_form').serialize(),
            dataType: 'json',
            success: function (data) {
                $("#after_post_message_appointment_cancel").html(data.msg);

                if (data.error == false) {
                    setTimeout(function () {
                        $("#myModal_cancel_appointment").modal('hide');
                        window.location = '';

                    }, 3000);
                }

            }
        });

    });
</script>
<script>
    /************************Add Customer***********************************************/
    $(function () {

        $('#add_customer_form').on('submit', function (e) {

            e.preventDefault();
            $.ajax({
                type: 'post',
                url: '<?php echo $link->link('ajax', frontend);?>',
                data: $('#add_customer_form').serialize(),
                dataType: 'json',
                success: function (data) {
                    // alert(data);
                    $("#after_post_message_customer").html(data.msg);
                    if (data.error == false) {
                        var cusid = data.cid;
                        var cname = data.cname;

                        var page = '<?php echo $query1ans;?>';
                        if (page == 'calendar') {

                            $('#loadnewcus').prepend($("<option selected='selected'></option>").attr("value", cusid).text(cname));
                            setTimeout(function () {
                                $('#myModal_add_customer').modal('hide');


                            }, 3000);

                        }
                        else {


                            $('#loadnewcus').prepend($("<option selected='selected'></option>").attr("value", cusid).text(cname));
                            setTimeout(function () {
                                $('#myModal_add_customer').modal('hide');


                            }, 3000);


                            // window.location = '<?php echo $link->link('quick_booking', frontend, '&bookig_for_customer=');?>'+cusid;
                        }

                    }
                }
            });

        });

    });
</script>


<script>
    /************************Add Staff***********************************************/
    $(function () {

        $('#add_staff_form').on('submit', function (e) {

            e.preventDefault();
            $.ajax({
                type: 'post',
                url: '<?php echo $link->link('ajax', frontend);?>',
                data: $('#add_staff_form').serialize(),
                dataType: 'json',
                success: function (data) {
                    // alert(data);
                    $("#after_post_message").html(data.msg);
                    if (data.error == false) {
                        setTimeout(function () {
                            window.location = '<?php if ($query1ans == 'staff') {
                                echo $link->link('staff', frontend, '&sid=' . $edit_staff_id);
                            } else {
                                echo $link->link($query1ans, frontend);
                            }?>';
                        }, 3000);
                    }
                }
            });

        });

    });
</script>
<script>
    /************************Add Appointment***********************************************/
    $(function () {

        $('#add_appointment_form').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                type: 'post',
                url: '<?php echo $link->link('ajax', frontend);?>',
                data: $('#add_appointment_form').serialize(),
                dataType: 'json',
                success: function (data) {
                    $("#after_post_message_appointment").html(data.msg);
                    if (data.error == false) {
                        setTimeout(function () {
                            window.location = '<?php if ($query1ans == "calendar") {
                                echo $link->link('calendar', frontend);
                            } else {
                                echo $link->link('edit_customer', frontend, '&action_edit=' . $edit_id);
                            }?>';
                        }, 3000);
                    }
                }
            });

        });

    });
</script>
<script>
    /************************Add Appointment***********************************************/
    $(function () {

        $('#add_appointment_form_quick').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                type: 'post',
                url: '<?php echo $link->link('ajax', frontend);?>',
                data: $('#add_appointment_form_quick').serialize(),
                dataType: 'json',
                success: function (data) {
                    $("#after_post_message_appointment_quick").html(data.msg);
                    if (data.error == false) {
                        setTimeout(function () {
                            window.location = '<?php echo $link->link('quick_booking', frontend);?>';
                        }, 1000);
                    }
                }
            });

        });

    });
</script>
<script>
    /************************Add timeoff***********************************************/
    $(function () {

        $('#add_timeoff_form').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                type: 'post',
                url: '<?php echo $link->link('ajax', frontend);?>',
                data: $('#add_timeoff_form').serialize(),
                dataType: 'json',
                success: function (data) {
                    $("#after_post_message_timeoff").html(data.msg);
                    if (data.error == false) {
                        setTimeout(function () {
                            window.location = '<?php echo $link->link('staff', frontend, '&sid=' . $edit_staff_id);?>';
                        }, 3000);
                    }
                }
            });

        });

    });
</script>
<script>
    /************************Edit Appointment***********************************************/
    $(function () {

        $('#edit_appointment_form').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                type: 'post',
                url: '<?php echo $link->link('ajax', frontend);?>',
                data: $('#edit_appointment_form').serialize(),
                dataType: 'json',
                success: function (data) {
                    $("#after_post_message_appointment_edit").html(data.msg);
                    if (data.error == false) {
                        if (data.error == false) {
                            setTimeout(function () {
                                window.location = '<?php if ($query1ans == 'edit_customer') {
                                    echo $link->link('edit_customer', frontend, '&action_edit=' . $edit_id);
                                } else {
                                    echo $link->link($query1ans, frontend);
                                }?>';
                            }, 3000);
                        }
                    }
                }
            });

        });

    });
</script>

<script>
    /************************Edit Booking***********************************************/
    $(function () {

        $('#edit_booking_form').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                type: 'post',
                url: '<?php echo $link->link('ajax', frontend);?>',
                data: $('#edit_booking_form').serialize(),
                dataType: 'json',
                success: function (data) {
                    $("#after_post_message_edit_booking").html(data.msg);
                    if (data.error == false) {
                        if (data.error == false) {
                            setTimeout(function () {
                                window.location = '<?php if ($query1ans == 'edit_customer') {
                                    echo $link->link('edit_customer', frontend, '&action_edit=' . $edit_id);
                                } else {
                                    echo $link->link($query1ans, frontend);
                                }?>';
                            }, 3000);
                        }
                    }
                }
            });

        });

    });
</script>
<script>
    $('.show_image_input').click(function () {
        $('.file_input').toggle();


    });
</script>
<script>
    /*
    # =============================================================================
    #   WYSIWYG Editor
    # =============================================================================
    */

    if ($('#demo-summernote').length) {
        $('#demo-summernote').summernote({
            height: 300,
            focus: true,
            toolbar: [['style', ['style']], ['style', ['bold', 'italic', 'underline', 'clear']], ['fontsize', ['fontsize']], ['color', ['color']], ['para', ['ul', 'ol', 'paragraph']], ['height', ['height']], ['insert', ['picture', 'link']], ['table', ['table']], ['fullscreen', ['fullscreen']]]
        });
    }
    /*
    # =============================================================================
    #   Date Picker
    # =============================================================================
    */


</script>
<script>
    $("#scolor").change(function () {
        var color = $(this).val();
        $("#scolor").removeAttr('class');
        $("#scolor").addClass("form-control text-" + color);

    });


</script>

<script>
    $('#load_services_by_provider').change(function () {
        var pid = $(this).val();
        $.ajax({
            type: 'post',
            url: '<?php echo $link->link('ajax', frontend);?>',
            data: '&load_service=' + pid,
            success: function (data) {
                $(".load_services").html(data);
                $(".load_services_edit").html(data);

            }
        });
    });


    $('#load_cost_time_by_service').change(function () {
        var sid = $(this).val();
        $.ajax({
            type: 'post',
            url: '<?php echo $link->link('ajax', frontend);?>',
            data: '&load_cost_time=' + sid,
            success: function (data) {
                $(".load_costandtime").html(data);
                $(".load_costandtime_edit").html(data);

            }
        });
    });

    $('#load_services_by_provider').change(function () {
        var pid = $(this).val();
        var date = $("#get_date_calender").val();
        //alert(pid+"=="+date);
        $.ajax({
            type: 'post',
            url: '<?php echo $link->link('ajax', frontend);?>',
            data: '&load_time_range=' + pid + '&adate=' + date,
            success: function (data) {
                $("#load_time_slot").html(data);
            }
        });
    });

    $('#get_date_calender').change(function () {
        var date = $(this).val();
        var pid = $("#load_services_by_provider").val();
        //alert(pid+"=="+date);
        $.ajax({
            type: 'post',
            url: '<?php echo $link->link('ajax', frontend);?>',
            data: '&load_time_range=' + pid + '&adate=' + date,
            success: function (data) {
                $("#load_time_slot").html(data);
            }
        });
    });

    $('#load_cost_time_by_service').change(function () {
        var date = $("#get_date_calender").val();
        var pid = $("#load_services_by_provider").val();
        //alert(pid+"=="+date);
        $.ajax({
            type: 'post',
            url: '<?php echo $link->link('ajax', frontend);?>',
            data: '&load_time_range=' + pid + '&adate=' + date,
            success: function (data) {
                $("#load_time_slot").html(data);
            }
        });
    });

</script>
<script>
    $('.edit_modal_edit_customer').click(function () {
        var aid = $(this).attr('data');
        $.ajax({
            type: 'post',
            url: '<?php echo $link->link('ajax', frontend);?>',
            data: '&edit_appointment=' + aid,
            success: function (data) {
                $("#load_edit_appointmentform").html(data);

            }
        });


    })
</script>
<script>
    $('.edit_memo').click(function () {
        var aid = $(this).attr('data');
        $.ajax({
            type: 'post',
            url: '<?php echo $link->link('ajax', frontend);?>',
            data: '&edit_memo=' + aid,
            success: function (data) {
                $("#load_edit_memoform").html(data);

            }
        });


    })
</script>
<script>
    $('.cancel_modal_cancel_customer').click(function () {
        var aid = $(this).attr('data');
        $.ajax({
            type: 'post',
            url: '<?php echo $link->link('ajax', frontend);?>',
            data: '&cancel_appointment=' + aid,
            success: function (data) {
                $("#load_cancel_appointmentform").html(data);

            }
        });


    })
</script>
<script>
    $('.care_plan_edit_booking').click(function () {
        var aid = $(this).attr('data');
        $.ajax({
            type: 'post',
            url: '<?php echo $link->link('ajax', frontend);?>',
            data: '&edit_booking=' + aid,
            success: function (data) {
                $("#load_edit_booking_form").html(data);

            }
        });


    });
    $('.add-app-carenote').on('click', function () {
        var date1 = $(this).parents('.add-app-wrapper').find('input.dynamic-date').val();
        $('.hidden_care_id').val($(this).data('care_id'));
        // $('.care_plan_date').val(date1);
    })
</script>
<script>
    $('.assign_room_button').click(function () {
        //alert('dsgsdg');
        var appontid = $(this).attr('data');
        $('#appoint_assign_room').val(appontid);


    })
</script>
<script>
    /************************Close Account**********************************************/
    $(function () {

        $('#close_account_form').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                type: 'post',
                url: '<?php echo $link->link('ajax', frontend);?>',
                data: $('#close_account_form').serialize(),
                dataType: 'json',
                success: function (data) {
                    $("#after_post_message_close_account_form").html(data.msg);
                    if (data.error == false) {
                        setTimeout(function () {
                            window.location = '<?php echo $link->link('logout', frontend);?>';
                        }, 3000);
                    }
                }
            });

        });

    });
</script>
<script>
    /************************Close Account**********************************************/
    $(function () {

        $('#assign_room_form').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                type: 'post',
                url: '<?php echo $link->link('ajax', frontend);?>',
                data: $('#assign_room_form').serialize(),
                dataType: 'json',
                success: function (data) {
                    $("#after_post_message_assign_room_form").html(data.msg);
                    if (data.error == false) {
                        setTimeout(function () {
                            window.location = '<?php if ($query1ans == 'edit_customer') {
                                echo $link->link('edit_customer', frontend, '&action_edit=' . $edit_id);
                            } else {
                                echo $link->link($query1ans, frontend);
                            }?>';
                        }, 3000);
                    }
                }
            });

        });

    });
</script>
<script>
    $(".set_cookie").click(function () {
        var tab = $(this).attr('tab');
        var ct = document.cookie = "current_tab=" + tab;
        window.location.href = "";

    });
</script>

<script>
    /************************Add Staff***********************************************/
    $(function () {

        $('#add_service_form').on('submit', function (e) {

            e.preventDefault();
            $.ajax({
                type: 'post',
                url: '<?php echo $link->link('ajax', frontend);?>',
                data: $('#add_service_form').serialize(),
                dataType: 'json',
                success: function (data) {
                    // alert(data);
                    $("#after_post_message_add_service").html(data.msg);
                    if (data.error == false) {
                        setTimeout(function () {
                            window.location = '';
                        }, 3000);
                    }
                }
            });

        });

    });
</script>
<script>
    $('#get_current_month_from_full_calendar').click(function () {
        var moment = $('#demo-calendar12').fullCalendar('getDate');
        //  alert("The current date of the calendar is " + moment.format());
        var date = moment.format();
        var pid = '<?php echo $_REQUEST['loadfor'];?>';
        var cid = '<?php echo CURRENT_LOGIN_COMPANY_ID;?>';
        $.ajax({
            type: 'post',
            url: '<?php echo $link->link('ajax', frontend);?>',
            data: '&load_stat_on_calendar=' + pid + '&adate=' + date + '&company_id=' + cid,
            success: function (data) {
                $("#load_stat_on_calendar").html(data);
            }
        });
    });
</script>
<script>


    $(".show_related_fields").change(function () {
        if (this.checked) {
            $(".show_on_staff_login_yes").show();
        }
        else {
            $(".show_on_staff_login_yes").hide();
        }
    });

</script>
<script>
    $("#filter_by_dashboard").change(function () {

        $("#filter_form_id").submit();
    });


</script>
<script>

    $(".load_payment_details").click(function () {
        var data_appointment_id = $(this).attr("data_id");
        var data_booking_id = $(this).attr("data_booking_id");
        var data_booking_date = $(this).attr("data_booking_date");
        var data_customer = $(this).attr("data_customer");
        var data_service_name = $(this).attr("data_service_name");
        var data_service_cost = $(this).attr("data_service_cost");
        var data_payment_sum_advance = $(this).attr("data_payment_sum_advance");
        var data_balance = $(this).attr("data_balance");

        $("#payment_data_appointment_id").val(data_appointment_id);
        $("#payment_data_booking_id").html('Prenotazione NR:#' + data_booking_id);
        $("#payment_data_customer").html('<strong>Paziente:</strong><br>' + data_customer);
        $("#payment_data_booking_date").html(data_booking_date);
        $("#payment_data_service_name").html(data_service_name);
        $("#payment_data_service_cost").html('<?php echo CURRENCY;?>' + data_service_cost);
        $("#payment_data_service_cost_total").html('<?php echo CURRENCY;?>' + data_service_cost);
        $("#payment_data_service_cost_total_final").html('<?php echo CURRENCY;?>' + data_service_cost);
        $("#payment").val(data_balance);
        $("#data_payment_sum_advance").html('<?php echo CURRENCY;?>' + data_payment_sum_advance);

    });
    /************************Add payment***********************************************/
    $(function () {

        $('#add_payment_form').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                type: 'post',
                url: '<?php echo $link->link('ajax', frontend);?>',
                data: $('#add_payment_form').serialize(),
                dataType: 'json',
                success: function (data) {
                    $("#after_post_message_payment").html(data.msg);
                    if (data.error == false) {
                        setTimeout(function () {
                            window.location = '';
                        }, 3000);
                    }
                }
            });

        });

    });

</script>
<script>
    /************************Add Notification***********************************************/
    $(function () {

        $('#add_notification_form').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                type: 'post',
                url: '<?php echo $link->link('ajax', frontend);?>',
                data: $('#add_notification_form').serialize(),
                dataType: 'json',
                success: function (data) {
                    $("#after_post_message_notification").html(data.msg);
                    if (data.error == false) {
                        setTimeout(function () {
                            window.location = '';
                        }, 3000);
                    }
                }
            });

        });

    });

</script>


<script>
    /************************Add Notes in Calendar***********************************************/
    $(function () {

        $('#add_notes_form').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                type: 'post',
                url: '<?php echo $link->link('ajax', frontend);?>',
                data: $('#add_notes_form').serialize(),
                dataType: 'json',
                success: function (data) {
                    //$("#after_post_message_notification").html(data.msg);
                    if (data.error == false) {
                        location.reload();
                    }
                    // console.log(data.msg);
                }
            });

        });


    });

    function appointmentComplete() {
        // alert();
        $.ajax({
            type: 'post',
            url: '<?php echo $link->link('ajax', frontend);?>',
            data: {update_appointment_auto: "Yes"},
            dataType: 'json',
            success: function (data) {
                if (data.error == false) {
                    var cla = String(data.id);
                    $(cla).html(data.msg);
                }
            }
        });
    }
</script>
<script>
    setInterval(function () {
        appointmentComplete();
    }, 5000);
    setTimeout(function () {
        $(".se-pre-con").fadeOut("slow");
    }, 1000);

</script>
<script src="<?php echo SITE_URL; ?>/assets/frontend/js/bootstrap-colorpicker.min.js"></script>
<script src="<?php echo SITE_URL; ?>/assets/frontend/js/bootstrap-colorpicker-plus.min.js"></script>
<script type="text/javascript">
    $(function () {
        var colorpickeme = $('#colorpickeme');
        colorpickeme.colorpickerplus();
        colorpickeme.on('changeColor', function (e, color) {
            if (color == null)
                $(this).val('transparent').css('background-color', '#fff');//tranparent
            else
                $(this).val(color).css('background-color', color);
        });
    });
</script>
<style>
    .text-bold {
        font-weight: bold;
    }
</style>
</body>

</html>