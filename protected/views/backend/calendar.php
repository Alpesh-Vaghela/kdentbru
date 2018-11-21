<style type="text/css">
  .fc-popover.fc-more-popover{
        overflow-y: scroll;
    height: 212px;
  }
</style>
<?php
if ($_SESSION['user_type']=="staff")
{
  $loadfor=$_SESSION['user_id'];
  $service_provider_firstname=$db->get_var('users',array('user_id'=>$loadfor),'firstname');
  $service_provider_lastname=$db->get_var('users',array('user_id'=>$loadfor),'lastname');
  $service_provider_user_type=$db->get_var('users',array('user_id'=>$loadfor),'user_type');
  $service_provider_image=$db->get_var('users',array('user_id'=>$loadfor),'user_photo_file');

}else{
  $loadfor=$_REQUEST['loadfor'];
  $service_provider_firstname=$db->get_var('users',array('user_id'=>$loadfor),'firstname');
  $service_provider_lastname=$db->get_var('users',array('user_id'=>$loadfor),'lastname');
  $service_provider_user_type=$db->get_var('users',array('user_id'=>$loadfor),'user_type');
  $service_provider_image=$db->get_var('users',array('user_id'=>$loadfor),'user_photo_file');

}
?>
<div id="page-content">
  <?php if ($_SESSION['user_type']=="admin" || $_SESSION['user_type']=="receptionist"){?>
    <div class="row">
      <div class="col-md-12">

        <div class="btn-group btn-group-sm">
         <span class="btn btn-default dropdown-toggle" data-toggle="dropdown" type="button" aria-expanded="false">
           <?php  if ($loadfor!="")
           {?>
            <i class="fa fa-user"></i>
            <?php echo ucfirst($service_provider_firstname)." ".$service_provider_lastname."(".ucfirst($service_provider_user_type).")";?>
          <?php }else{?>
           <i class="fa fa-users"></i> Tutto lo STAFF
         <?php }?>


         <i class="dropdown-caret fa fa-chevron-down"></i>
       </span>
       <ul class="dropdown-menu">

        <li>

          <a href="<?php echo $link->link('calendar',frontend);?>"><span><i class="fa fa-users"></i> Tutto lo STAFF</span></a>
        </li>
        <?php
        $com_id=CURRENT_LOGIN_COMPANY_ID;
        $sf=$db->get_all('users',array('visibility_status'=>'active','user_type'=>'staff','company_id'=>CURRENT_LOGIN_COMPANY_ID));
             //   $sf=$db->run("SELECT* FROM `users` WHERE `visibility_status`='active' AND `company_id`='$com_id' AND `user_type`!='admin'")->fetchAll();
        if (is_array($sf)){
          foreach ($sf as $alls)
            {?>
              <li><a href="<?php echo $link->link('calendar',frontend,'&loadfor='.$alls[user_id]);?>">
                <span><i class="fa fa-user"></i> <?php echo $alls['firstname']." ".$alls['lastname']."";?></span></a></li>
              <?php }}?>
              <?php if ($_SESSION['user_type']=="admin"){?>
                <li class="text-info"><a href="" data-toggle="modal" data-target="#myModal"> <i class="fa fa-plus-circle"></i> Aggiungi DOTTORE </a></li>
              <?php }?>
            </ul>

          </div>
          <?php if ($_SESSION['user_type']=="admin"){?>
            <ul class="nav navbar-top-links pull-right">
                               <!-- <li>
                                 <a href="#" data-toggle="modal" data-target="#myModal_notification"><i class="fa fa-pencil-square-o fa-2x text-primary" title="Add Notes of memo"></i></a>
                               </li> -->
                              <!-- <li>
                                 <a href="#" data-toggle="modal" data-target="#myModal_notes"><i class="fa fa-clipboard fa-2x text-primary" title="Add Notes"></i></a>
                               </li>  -->
                               <li id="dropdown-user" class="dropdown">

                                <a href="#" data-toggle="dropdown" class="dropdown-toggle text-right"><i class="fa fa-plus-circle fa-2x text-danger"></i></a>


                                <div class="dropdown-menu dropdown-menu-right with-arrow">
                                  <ul class="head-list">
                                    <li><a href="" data-toggle="modal" data-target="#myModal"> <i class="fa fa-user"></i> Aggiungi nuovo DOTTORE </a></li>
                                    <li><a  href="" data-toggle="modal" data-target="#myModal_add_sevice">  <i class="fa fa-truck fa-fw"></i> Aggiungi nuova PRESTAZIONE </a></li>
                                    <li><a href="" data-toggle="modal" data-target="#myModal_add_customer">  <i class="fa fa-user-secret fa-fw"></i> Aggiungi nuovo PAZIENTE</a></li>
                                  </ul>
                                </div>
                              </li>

                              <?php if (SHOW_CALENDAR_STATS=="yes"){?>

                               <li id="dropdown-user" class="dropdown">

                                <a href="#" data-toggle="dropdown" class="dropdown-toggle text-right"><i class="fa fa-signal fa-2x text-danger" id="get_current_month_from_full_calendar"></i></a>


                                <div class="dropdown-menu dropdown-menu-right with-arrow">
                                  <ul class="head-list">
                                    <li id="load_stat_on_calendar">
                                     <span class="Loader">
                                      <img src="<?php echo SITE_URL.'/assets/frontend/Loader.gif';?>">
                                    </span>
                                  </li>
                                </ul>
                              </div>
                            </li>
                          <?php }?>

                        </ul>
                      <?php }?>




                    </div>
                  </div>
                  <br>
                <?php }?>
                <div class="row">
                  <div class="col-md-12 col-lg-12">
                    <div class="text-right form-group">
                      <button class="fc-button fc-state-default fc-corner-left fc-corner-right" type="button" onClick="reload_calender()">Refresh</button>
                    </div>
                    <div class="panel">
                      <div class="panel-body">

                        <!-- Calendar placeholder-->
                        <!-- ============================================ -->
                        <div id='demo-calendar12'></div>
                        <!-- ============================================ -->
                      </div>
                    </div>
                  </div>
                </div>


              </div>
              <div id="fullCalModal" class="modal fade">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                     <h4 id="modalTitle" class="modal-title"></h4>
                     <div id="calendar_modal_message"></div>
                   </div>
                   <div class="modal-body">
                    <h4 id="company_name" style=" color:red;"></h4>
                    <h5 id="timing_details" style="font-size: 14px;"></h5>
                    <h5 id="provider" style="font-size: 14px;"></h5>
                    <h5 id="service" style="font-size: 14px;"></h5>
                    <h5 id="cost" style="font-size: 14px;"></h5>
                    <h5 id="customer" style="font-size: 14px;"></h5>
                    <h5 id="mobile" style="font-size: 14px;"></h5>
                    <h5 id="note" style="font-size: 14px;"></h5>
                    <h5 id="status" style="font-size: 14px;"></h5>

                  </div>
                  <div class="modal-footer">
                   <input type="hidden" id="appointment_id">
                   <button class="btn btn-danger change-text-app" id="update_arrival_appointment_calendar"><i class="fa fa-edit"></i> Paziente ARRIVATO</button>
                   <button class="btn btn-info" id="load_edit_appoint_form" data-toggle="modal" data-target="#myModal_edit_appointment"><i class="fa fa-edit"></i> Modifica</button>
                   <button data-toggle="modal" data-target="#myModal_cancel_appointment" class="btn btn-danger cancel_modal_cancel_customer cancel-calender"><i class="fa fa-trash"></i> Cancella</button>
                   <button class="btn btn-default" type="button" class="close" data-dismiss="modal">Chiudi</button>


                 </div>

               </div>
             </div>
           </div>

           <div id="fullCalModal_add_appointment" class="modal fade">
            <div class="modal-dialog">
             <div class="modal-content">
              <div id="after_post_message_appointment"></div>
              <form id="add_appointment_form" method="post" class="form-horizontal" action="" enctype="multipart/form-data">
                <input type="hidden" name="add_appointment_submit" value="add_appointment_submit">
                <input type="hidden" name="booking_from" value="<?php echo $query1ans;?>">
                <input type="hidden" name="private" value="no">

                <div class="modal-header">
                 <h4 class="modal-title">Aggiungi APPUNTAMENTO</h4>
               </div>
               <div class="modal-body">
                 <div class="form-group">
                   <label class="control-label col-md-3">Paziente<font color="red">*</font></label>
                   <div class="col-md-8">
                    <select class="form-control"name="customer_id" id="loadnewcus">
                      <option value="">---Seleziona--- </option>
                      <?php
                      $db->order_by='id ASC';
                      $allcustomers=$db->get_all('customers',array('visibility_status'=>'active','company_id'=>CURRENT_LOGIN_COMPANY_ID));
                      if (is_array($allcustomers))
                      {
                        foreach ($allcustomers as $cus)
                          {?>
                           <option <?php if ($_REQUEST['bookig_for_customer']==$cus['id']){echo "selected='selected'";}?>  value="<?php echo $cus['id']?>"><?php echo $cus['first_name']." ".$cus['last_name'];?>)</option>
<?php }
}?>

</select>
</div>
<div class="col-md-1"><button type="button" class="btn btn-info pull-right" data-toggle="modal" data-target="#myModal_add_customer"><i class="fa fa-plus"></i></button></div>

</div>
<div class="form-group">
 <label class="control-label col-md-3">Provider<font color="red">*</font></label>
 <div class="col-md-8">
  <select class="form-control" name="service_provider" id="load_services_by_provider" <?php if ($loadfor!=""){echo "readonly";}?>>
    <?php if ($_SESSION['user_type']=="staff")
    {?>
      <option  value="<?php echo $_SESSION['user_id']?>"><?php echo $service_provider_firstname." ".$service_provider_lastname;?></option>
    <?php }else{?>


      <option value="">---Seleziona--- </option>
      <?php $provider=$db->get_all('users',array('visibility_status'=>'active','user_type'=>'staff','company_id'=>CURRENT_LOGIN_COMPANY_ID));
      if (is_array($provider))
      {
        foreach ($provider as $pro)
          {?>
           <option <?php if ($loadfor==$pro['user_id']){echo "selected='selected'";}?>  value="<?php echo $pro['user_id']?>"><?php echo $pro['firstname']." ".$pro['lastname'];?></option>
         <?php }
       }?>
     <?php }?>
   </select>
 </div>
</div>
<div class="form-group">
 <label class="control-label col-md-3">Service<font color="red">*</font></label>
 <div class="col-md-8">
  <select class="form-control load_services" name="appointment_service" id="load_cost_time_by_service">
    <option value=''>---Seleziona---</option>
    <?php if (isset($loadfor)){
      $all_services_by_provider=$db->get_all('assign_services',array('staff_id'=>$loadfor));

      if (is_array($all_services_by_provider))
      {

        foreach ($all_services_by_provider as $alps)
        {
          $service_name=$db->get_var('services',array('id'=>$alps['service_id']),'service_name');
          ?>
          <option value="<?php echo $alps['service_id']?>"><?php echo $service_name;?></option>
        <?php }}}else{?>
          <option value=''>---Seleziona---</option>
        <?php }?>

      </select>
    </div>
  </div>
  <div class="form-group load_costandtime">

  </div>
  <div class="form-group">
   <label class="control-label col-md-3">Day/Time</label>
   <div class="col-md-5">
    <input class="form-control datepicker" type="text" name="appointment_date" value="" id="get_date_calender" readonly="">
    <p> Appointment should be in Future dates
    </p>
  </div>
  <div class="col-md-3 ">
    <!--   <input class="form-control" type="time" name="appointment_time" value=""> -->
    <?php

    $company_id = $db->get('users',array('user_id'=>$_SESSION['user_id']),'company_id');

    $time_slots = $db->get('preferences_settings',array('company_id'=>$company_id[0]['company_id']),'custom_time_slot');

    $times = $feature->create_time_range('08:00', '20:00', $time_slots[0]['custom_time_slot'].' min', $format = '24');

    $booked_date = $db->get_all('appointments',array('staff_id'=>$service_provider,'appointment_date'=> $appointment_date),'appointment_date,appointment_time,appointment_end_time');

    foreach ($booked_date as $key => $date) {

      $booked_slot[] = $feature->create_time_range($date['appointment_time'], $date['   zappointment_end_time'], $time_slots[0]['custom_time_slot'].' min', $format = '24');
    }
    $booked_slots = array_reduce($booked_slot, 'array_merge', array());
    ?>
    <select class="form-control" name="appointment_time" id="load_time_slot">
      <option value="">--Select--</option>
      <?php


      if (is_array($times)){
        foreach ($times as $t) { ?>
          <option value="<?php echo $t;?>" <?php echo (in_array($t, $booked_slots)) ? "disabled": ''?> ><?php echo date('h:i A',strtotime($t));?></option>
        <?php }}
        ?>

      </select>
    </div>
  </div>
  <div class="form-group">
   <label class="control-label col-md-3">Notes</label>
   <div class="col-md-8">
    <input class="form-control" type="text" name="appointment_notes" value="">
  </div>
</div>
<?php if ($_SESSION['user_type']=="admin" || $_SESSION['user_type']=="receptionist" ){?>
 <div class="form-group">
   <label class="control-label col-md-3">Private</label>
   <div class="col-md-8">
    <select class="form-control" name="private">
      <option  value="no">No</option>
      <option  value="yes">Yes</option>
    </select>
  </div>
</div>
<?php }?>

</div>
<div class="modal-footer">
  <button class="btn btn-info" name="add_time_form_submit" type="submit"><i class="fa fa-save"></i> Submit</button>
  <button type="reset" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
</div>
</form>
</div>
</div>
</div>
<!--===================================================-->
<!--End page content-->



