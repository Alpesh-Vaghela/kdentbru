<?php
if (file_exists(SERVER_ROOT . '/protected/views/backend/modal_box.php')) {

    require SERVER_ROOT . '/protected/views/backend/modal_box.php';
}
?>
</div>


</div>
<!-- FOOTER -->
<!--===================================================-->
<footer id="footer">

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

</footer>

<button id="scroll-top" class="btn"><i class="fa fa-chevron-up"></i></button>
<!--===================================================-->
</div>

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
    || $query1ans == "quick_booking") { ?>
    <!--    <script src="<?php echo SITE_URL . '/assets/frontend/plugins/dropzone/dropzone.min.js'; ?>"></script> -->
    <!--   <script src="<?php echo SITE_URL . '/assets/frontend/plugins/bootstrap-timepicker/bootstrap-timepicker.min.js'; ?>"></script> -->
    <script src="<?php echo SITE_URL . '/assets/frontend/plugins/bootstrap-datepicker/bootstrap-datepicker.js'; ?>"></script>
    <!--     <script src="<?php echo SITE_URL . '/assets/frontend/js/demo/form-component.js'; ?>"></script> -->
    <script>
        $('.datepicker').datepicker({

            format: "dd-mm-yyyy",
            todayBtn: "linked",
            autoclose: true,
            todayHighlight: true,
            startDate: new Date()
        });
        $('.datepicker_account_preferences').datepicker({

            format: "dd-mm-yyyy",
            todayBtn: "linked",
            autoclose: true,
            todayHighlight: true,

        });
    </script>
<?php } ?>

<?php if ($query1ans == "calendar") { ?>
    <!--Full Calendar [ OPTIONAL ]-->
    <script src="<?php echo SITE_URL . '/assets/frontend/plugins/fullcalendar/lib/moment.min.js'; ?>"></script>
    <script src="<?php echo SITE_URL . '/assets/frontend/plugins/fullcalendar/lib/jquery-ui.custom.min.js'; ?>"></script>
    <script src="<?php echo SITE_URL . '/assets/frontend/plugins/fullcalendar/fullcalendar.min.js12'; ?>"></script>
    <script type="text/javascript" src="https://fullcalendar.io/releases/fullcalendar/3.9.0/lib/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.5.0/fullcalendar.min.js"></script>
    <script type="text/javascript" src="https://fullcalendar.io/releases/fullcalendar/3.9.0/locale-all.js"></script>
    <script>
        $(document).ready(function () {
            var lang = 'it';
            $('#demo-calendar12').fullCalendar({
                header: {
                    left: 'myCustomButton',
                    center: 'today, prev, title, next',
                    right: 'month,agendaWeek,agendaDay'
                },
                locale: lang,
                timeFormat: 'hh:mm',//'hh:mm:ss a',
                //  minTime:'09:00:00',
                //  maxTime:'19:30:00',
                /*  selectable: true,
                  selectHelper: true,
                  select: function(start, end)
                   {
                   var allDay = !start.hasTime() && !end.hasTime();
                      $("#get_date_calender").val(moment(start).format('YYYY-MM-DD'));
                      $('#fullCalModal_add_appointment').modal();
                      $('#demo-calendar12').fullCalendar('unselect');
                   },*/
                eventLimit: true, // allow "more" link when too many events
                events: [
                    <?php
                    $alla = $db->get_all('appointments');
                    if (is_array($alla))
                    {
                    foreach ($alla as $aa){
                    $customer_firstname = $db->get_var('customers', array('id' => $aa['customer_id']), 'first_name');
                    $customer_lastname = $db->get_var('customers', array('id' => $aa['customer_id']), 'last_name');
                    $company_name = $db->get_var('company', array('id' => $aa['company_id']), 'company_name');
                    // $customer_fullname=$customer_firstname." ".$customer_lastname;
                    $customer_fullname = $aa['customer_name'];
                    $service_name = $db->get_var('services', array('id' => $aa['service_id']), 'service_name');
                    $service_color = $db->get_var('services', array('id' => $aa['service_id']), 'service_color');
                    $service_provider_firstname = $db->get_var('users', array('user_id' => $aa['staff_id']), 'firstname');
                    $service_provider_lastname = $db->get_var('users', array('user_id' => $aa['staff_id']), 'lastname');
                    $service_cost = $aa['service_cost'];
                    $appointment_date = $aa['appointment_date'];
                    $appointment_time = $aa['appointment_time'];
                    $appointment_note = $aa['notes'];
                    $appointment_status = $aa['status'];
                    $selectedTime = $appointment_time;
                    $st = $aa['service_time'] + $aa['service_buffer_time'];
                    $service_time = "+" . $st . " minutes";
                    $endTime = strtotime($service_time, strtotime($selectedTime));
                    $service_end_time = date('H:i:s', $endTime);
                    $appointment_end_time = $aa['appointment_end_time'];
                    ?>
                    {
                        title: '<?php echo ucwords($customer_fullname);?>',
                        start: '<?php echo $appointment_date;?>T<?php echo date('H:i:s', strtotime($appointment_time));?>',
                        end: '<?php echo $appointment_date;?>T<?php echo date('H:i:s', strtotime($service_end_time));?>',
                        description: 'long description3',
                        id:<?php echo $aa['id'];?>,
                        className: '<?php echo $service_color;?>',
                        modal: '#events-modal',
                        modalTitle: 'Appointment Details',
                        appointment_id: '<?php echo $aa['id'];?>',
                        appointment_date_service_time: '<?php echo date("D M d,Y", strtotime($appointment_date));?> <?php echo date('h:i a', strtotime($appointment_time));?>-<?php echo date('h:i a', strtotime($appointment_end_time));?>',
                        provider: 'Provider: <?php echo $service_provider_firstname?> <?php echo $service_provider_lastname?>',
                        service: 'Service: <?php echo $service_name?>',
                        cost: 'Cost: <?php echo SITE_CURRENCY . "" . $service_cost?>',
                        customer: 'Customer: <?php echo $customer_fullname?>',
                        notes: 'Notes: <?php echo $appointment_note?>',
                        status: 'Status: <?php echo $appointment_status?>',
                        company_name: 'Company: <?php echo $company_name?>'
                    },
                    <?php }}?>], eventClick: function (event, jsEvent, view) {
                    $('#appointment_id').val(event.appointment_id);
                    $('#modalTitle').html(event.modalTitle);
                    $('#timing_details').html(event.appointment_date_service_time);
                    $('#provider').html(event.provider);
                    $('#service').html(event.service);
                    $('#cost').html(event.cost);
                    $('#customer').html(event.customer);
                    $('#company_name').html(event.company_name);
                    $('#note').html(event.notes);
                    $('#status').html(event.status);
                    $('#fullCalModal').modal();
                }
            });
        });
    </script>
    <script>
        $("#load_edit_appoint_form").click(function () {
            var color = $('#appointment_id').val();
            $.ajax({
                type: 'post',
                url: '<?php echo $link->link('ajax', admin);?>',
                data: '&edit_appointment=' + color,
                success: function (data) {
                    $("#load_edit_appointmentform").html(data);
                }
            });
        });
        $("#load_cancel_appoint_form").click(function () {
            var color = $('#appointment_id').val();
            $.ajax({
                type: 'post',
                url: '<?php echo $link->link('ajax', admin);?>',
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
                url: '<?php echo $link->link('ajax', admin);?>',
                data: '&delete_appointment=' + apid,
                dataType: 'json',
                success: function (data) {
                    $("#calendar_modal_message").html(data.msg);
                    if (data.error == false) {
                        setTimeout(function () {
                            window.location = '<?php echo $link->link('calendar', admin);?>';
                        }, 3000);
                    }
                }
            });
        });
    </script>
<?php } ?>
<script>
    /************************Add Customer***********************************************/
    $(function () {

        $('#add_customer_form').on('submit', function (e) {

            e.preventDefault();
            $.ajax({
                type: 'post',
                url: '<?php echo $link->link('ajax', admin);?>',
                data: $('#add_customer_form').serialize(),
                dataType: 'json',
                success: function (data) {
                    // alert(data);
                    $("#after_post_message_customer").html(data.msg);
                    if (data.error == false) {
                        var cusid = data.cid;
                        setTimeout(function () {
                            var page = '<?php echo $query1ans;?>';
                            window.location = '';
                        }, 3000);
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
            // alert("tyrtytry");
            e.preventDefault();
            $.ajax({
                type: 'post',
                url: '<?php echo $link->link('ajax', admin);?>',
                data: $('#add_staff_form').serialize(),
                dataType: 'json',
                success: function (data) {
                    //  alert(data);
                    $("#after_post_message").html(data.msg);
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
    /************************Add Appointment***********************************************/
    $(function () {

        $('#add_appointment_form').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                type: 'post',
                url: '<?php echo $link->link('ajax', admin);?>',
                data: $('#add_appointment_form').serialize(),
                dataType: 'json',
                success: function (data) {
                    $("#after_post_message_appointment").html(data.msg);
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
    /************************Add Appointment***********************************************/
    $(function () {

        $('#add_appointment_form_quick').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                type: 'post',
                url: '<?php echo $link->link('ajax', admin);?>',
                data: $('#add_appointment_form_quick').serialize(),
                dataType: 'json',
                success: function (data) {
                    $("#after_post_message_appointment_quick").html(data.msg);
                    if (data.error == false) {
                        setTimeout(function () {
                            window.location = '';
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
                url: '<?php echo $link->link('ajax', admin);?>',
                data: $('#add_timeoff_form').serialize(),
                dataType: 'json',
                success: function (data) {

                    $("#after_post_message_timeoff").html(data.msg);
                    if (data.error == false) {
                        setTimeout(function () {
                            window.location = '<?php echo $link->link('staff', admin, '&action_id=' . $company_id . '&sid=' . $edit_staff_id);?>';
                        }, 3000);
                    }
                }
            });

        });

    });
</script>

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
            url: '<?php echo $link->link('ajax', admin);?>',
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
            url: '<?php echo $link->link('ajax', admin);?>',
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
            url: '<?php echo $link->link('ajax', admin);?>',
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
            url: '<?php echo $link->link('ajax', admin);?>',
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
            url: '<?php echo $link->link('ajax', admin);?>',
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
        //alert(aid);
        $.ajax({
            type: 'post',
            url: '<?php echo $link->link('ajax', admin);?>',
            data: '&edit_appointment=' + aid,
            success: function (data) {
                $("#load_edit_appointmentform").html(data);

            }
        });


    })
</script>
<script>
    $('.cancel_modal_cancel_customer').click(function () {


        var aid = $(this).attr('data');
        //alert(aid);
        $.ajax({
            type: 'post',
            url: '<?php echo $link->link('ajax', admin);?>',
            data: '&cancel_appointment=' + aid,
            success: function (data) {
                $("#load_cancel_appointmentform").html(data);

            }
        });


    })
</script>
<script>
    $('.assign_room_button').click(function () {
        // alert('dsgsdg');
        var appontid = $(this).attr('data');
        $.ajax({
            type: 'post',
            url: '<?php echo $link->link('ajax', admin);?>',
            data: '&load_assign_room_form=' + appontid,
            success: function (data) {
                $("#load_assign_room_form").html(data);

            }
        });


        //$('#appoint_assign_room').val(appontid);


    })
</script>
<script>
    /************************Close Account**********************************************/
    $(function () {

        $('#close_account_form').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                type: 'post',
                url: '<?php echo $link->link('ajax', admin);?>',
                data: $('#close_account_form').serialize(),
                dataType: 'json',
                success: function (data) {
                    $("#after_post_message_close_account_form").html(data.msg);
                    if (data.error == false) {
                        setTimeout(function () {
                            window.location = '<?php echo $link->link('company', admin);?>';
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
    /************************Add service_form***********************************************/
    $(function () {

        $('#add_service_form').on('submit', function (e) {

            e.preventDefault();
            $.ajax({
                type: 'post',
                url: '<?php echo $link->link('ajax', admin);?>',
                data: $('#add_service_form').serialize(),
                dataType: 'json',
                success: function (data) {
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
    /************************Add Service Category***********************************************/
    $(function () {

        $('#add_service_category_form').on('submit', function (e) {

            e.preventDefault();
            $.ajax({
                type: 'post',
                url: '<?php echo $link->link('ajax', admin);?>',
                data: $('#add_service_category_form').serialize(),
                dataType: 'json',
                success: function (data) {
                    // alert(data);
                    $("#after_post_message_add_service_category").html(data.msg);
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
            url: '<?php echo $link->link('ajax', admin);?>',
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
    setTimeout(function () {
        $(".se-pre-con").fadeOut("slow");
    }, 1000);

</script>

</body>
</html>