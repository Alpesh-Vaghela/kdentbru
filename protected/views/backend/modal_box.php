
<!-- Modal box to Add New staff --> 
  <div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    <div id="after_post_message"></div>
    <form id="add_staff_form" method="post" class="form-horizontal" action="" enctype="multipart/form-data">
    <input type="hidden" name="add_staff_submit" value="add_staff_submit">
    <input type="hidden" name="company_id" value="<?php echo $company_id;?>">
      <div class="modal-header">
        
        <h4 class="modal-title">Add New Staff</h4>
      </div>
      <div class="modal-body">
            <div class="form-group">
                           <label class="control-label col-md-4">First Name<font color="red">*</font></label>
                           <div class="col-md-7">
                              <input class="form-control" type="text" name="staff_fname" value="">
                           </div>
                        </div>
             <div class="form-group">
               <label class="control-label col-md-4">Last Name</label>
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
        <button class="btn btn-info" name="add_staff_form_submit" type="submit"> <i class="fa fa-save"></i> Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times-circle"></i> Close</button>
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
    <input type="hidden" name="company_id" value="<?php echo $_REQUEST['action_id'];?>">
    <input type="hidden" name="company_name" value="<?php echo $company_name;?>">
    <input type="hidden" name="company_email" value="<?php echo $company_email;?>">
      <div class="modal-header">
        
        <h4 class="modal-title">Close Account.</h4>
        <p>After this all related data to this comany will delete permanently. Before you close it please enter the reason  .</p>
      </div>
      <div class="modal-body">
            <div class="form-group">
                           
                           <div class="col-md-12">
                           <textarea placeholder="I'm closing my account because..." class="form-control" name="close_reason"></textarea>
                            </div>
                        </div>
          </div>
      <div class="modal-footer">
        <button class="btn btn-danger" name="close_account_form_submit" type="submit">Close Company Account</button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times-circle"></i> Close</button>
      </div>
      </form>
    </div>

  </div>
</div>
<!-- Modal box to Add New Time off --> 
 


<!-- Modal box to Edit Appointment --> 
  <div id="myModal_edit_appointment" class="modal fade myModal_edit_appointment" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
    <div id="after_post_message_appointment_edit"></div>
    <form id="edit_appointment_form" method="post" class="form-horizontal" action="" enctype="multipart/form-data">
     <div class="modal-header">
       <h4 class="modal-title">Edit Appointment</h4>
      </div>
      <div class="modal-body">
      <div id="load_edit_appointmentform"></div> 
         
             
          </div>
      <div class="modal-footer">
        <button class="btn btn-info" name="edit_appointment_form_submit" type="submit"><i class="fa fa-save"></i> Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times-circle"></i> Close</button>
      </div>
      </form>
    </div>

  </div>
</div>

<!-- Modal box to assign rooms --> 
  <div id="myModal_assign_room" class="modal fade" role="dialog">
  <div class="modal-dialog" id="load_assign_room_form">

  </div>
</div>




<!-- Modal box to filter dashboard content --> 
  <div id="myModal_dashboard_filter" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content">
   
    <form  method="post" class="form-horizontal" action="" enctype="multipart/form-data">
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
        <button class="btn btn-info" name="dashboard_filter_submit" type="submit"><i class="fa fa-filter"></i> Filter</button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times-circle"></i> Close</button>
      </div>
      </form>
    </div>

  </div>
</div>


<!-- modal box to add services -->
<div id="myModal_add_sevice" class="modal fade" role="dialog">
  <div class="modal-dialog">
     <form id="add_service_form"  method="post" class="form-horizontal" action="<?php $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
     <input type="hidden" name="add_service_submit" value="add_service_submit">  
     <input type="hidden" name="company_id" value="<?php echo $company_id;?>">
    <div class="modal-content">
     <div class="modal-header">
        <h4 class="modal-title">Add service</h4>
      </div>
    <div id="after_post_message_add_service"></div>
  <div class="modal-body">
                       
                     
                       <div class="form-group">
                           <label class="control-label col-md-4">Service Name<font color="red">*</font></label>
                           <div class="col-md-3">
                            <!-- <input class="form-control"  type="color" name="service_color" value="<?php echo $_POST['service_color'];?>"> -->
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
                             <input class="form-control"  type="text" name="service_name" value="<?php echo $_POST['service_name'];?>">
                           </div>
                        </div>
                        
                        <div class="form-group">
                           <label class="control-label col-md-4">Service description</label>
                           <div class="col-md-8">
                              <textarea class="form-control" name="service_description"><?php echo $_POST['service_description'];?></textarea>
                           </div>
                        </div>
                        <div class="form-group" id="business_name_id">
                           <label class="control-label col-md-4">Service Cost<font color="red">*</font></label>
                           <div class="col-md-8">
                              <input class="form-control" placeholder="" type="text" name="service_cost" value="<?php echo $_POST['service_cost'];?>">
                           </div>
                        </div>
                        <div class="form-group">
                           <label class="control-label col-md-4">Service Time(Mins)<font color="red">*</font></label>
                           <div class="col-md-8">
                              <input class="form-control" placeholder="" type="number" name="service_time" value="<?php echo $_POST['service_time'];?>">
                           </div>
                        </div>
                           <div class="form-group">
                           <label class="control-label col-md-4">Service Buffer Time(Mins)</label> 
                         
                           <div class="col-md-8">
                              <input class="form-control" placeholder="" type="number" name="service_buffer_time" value="<?php echo $_POST['service_buffer_time'];?>">
                           </div>
                        </div>
                      <div class="form-group">
                           <label class="control-label col-md-4">Category</label>
                           <div class="col-md-8">
                              <select class="form-control" name="service_category">
                              <option value="">Select Category</option>
                              <?php $all_service_categoy=$db->get_all('service_category',array('visibility_status'=>'active','company_id'=>$company_id,));
                              if (is_array($all_service_categoy)){
                                  foreach ($all_service_categoy as $allcs){?>
                                      <option <?php if ($_POST['service_category']==$allcs['id']){echo "selected";};?> value="<?php echo $allcs['id'];?>"><?php echo $allcs['category_name'];?></option>
                                  <?php }}?>
                              
                              </select>
                           </div>
                        </div>
                       <div class="form-group">
                           <label class="control-label col-md-4">Private Service</label>
                           <div class="col-md-8">
                              <select class="form-control" name="private_service">
                              <option <?php if ($_POST['private_service']=="no"){echo "selected";};?> value="no">No</option>
                              <option <?php if ($_POST['private_service']=="yes"){echo "selected";};?> value="yes">Yes</option>
                           </select>
                           </div>
                        </div>
                 
					        <div class="form-group">  
                                <label class="col-md-4 control-label">Who can provide the service</label>
                                <div class="col-md-8">
                                        <?php $all_staff=$db->get_all('users',array('visibility_status'=>'active','company_id'=>$company_id,));
                                        if (is_array($all_staff)){
                                            foreach ($all_staff as $as){?>
                                              <div class="checkbox12">
                                            <label class="form-checkbox form-icon form-text">
                                            <input type="checkbox" name="assign_to[]" value="<?php echo $as['user_id']?>"><?php echo $as['firstname']." ".$as['lastname'];?></label>
                                        </div>
                                                
                                            <?php }}?>
                                      
                                       
                                      
                                    </div>
                               
                              </div>
                        
                        
                                        
                                         
    </div>
     <div class="modal-footer">
       <button class="btn btn-block btn-info" name="add_service_form_submit"   type="submit"><i class="fa fa-save"></i> Submit</button>
      </div>
      </div>
</form>
  </div>
</div>




<!-- modal box to add services category -->
<div id="myModal_add_sevice_category" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
     <div class="modal-header">
        <h4 class="modal-title">Add Service Category</h4>
      </div>
    <div id="after_post_message_add_service_category"></div>
     
  <div class="panel-body">
   <form id="add_service_category_form"  method="post" class="form-horizontal" action="<?php $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
          <input type="hidden" name="add_service_category_submit" value="add_service_category_submit">  
         <input type="hidden" name="company_id" value="<?php echo $company_id;?>">
                  
                    <div class="modal-body">             
                       
                     
                       <div class="form-group">
                           <label class="control-label col-md-4">Category Name<font color="red">*</font></label>
                           <div class="col-md-7">
                              <input class="form-control"  type="text" name="category_name" value="<?php echo $_POST['service_name'];?>">
                           </div>
                        </div>
             
					        </div>
                                                    
                                        <div class="panel-footer text-right">
                                         
                                         <button class="btn btn-info" name="add_service_category_form_submit"   type="submit">Submit</button>  
                                        </div>
                                        
                                         </form>
  </div>
  </div>
</div>
</div>