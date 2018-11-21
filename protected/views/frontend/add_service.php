<?php
if (isset($_POST['add_service_form_submit']))
{
    //print_r($_POST);
  $service_name=$_POST['service_name'];
  $service_description=$_POST['service_description'];
  $service_cost=$_POST['service_cost'];
  $service_time=$_POST['service_time'];
  $service_color=$_POST['service_color'];
  $service_buffer_time=$_POST['service_buffer_time'];
  $service_category=$_POST['service_category'];
  $assign_to=$_POST['assign_to'];
  $private_service=$_POST['private_service'];
  $visibility_status=$_POST['visibility_status'];
  $created_date=date('Y-m-d');
  $ip_address=$_SERVER['REMOTE_ADDR'];


  $empt_fields = $fv->emptyfields(array('service Name'=>$service_name,
    'Sevice Cost'=>$service_cost,
    'Service Time'=>$service_time));

  if ($empt_fields)
  {
    $display_msg= '<div class="alert alert-danger">
    <i class="lnr lnr-sad"></i> <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
    Oops! Following fields are empty<br>'.$empt_fields.'</div>';
  }

  elseif ($db->exists('services',array('service_name'=>$service_name,'company_id'=>CURRENT_LOGIN_COMPANY_ID)))
  {
    $display_msg= '<div class="alert alert-danger">
    <i class="lnr lnr-sad"></i> <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
    Service Name is already exist.
    </div>';
  }
  else
  {
   
   $insert=$db->insert("services",array('company_id'=>CURRENT_LOGIN_COMPANY_ID,
    'service_name'=>$service_name,
    'service_cost'=>$service_cost,
    'service_description'=>$service_description,
    'service_time'=>$service_time,
    'service_buffer_time'=>$service_buffer_time,
    'service_category'=>$service_category,
    'service_color'=>$service_color,
    'private_service'=>$private_service,
    'visibility_status'=>'active',
    'created_date'=>$created_date,
    'ip_address'=>$ip_address));
   $last_inserted_service=$db->insert_id;
 //  $db->debug();
   if ($insert){
    if (is_array($assign_to))
    {
      foreach ($assign_to as $ato)
      {
        $assign=$db->insert("assign_services",array('company_id'=>CURRENT_LOGIN_COMPANY_ID,
          'staff_id'=>$ato,
          'service_id'=>$last_inserted_service,
          'created_date'=>$created_date,
          'ip_address'=>$ip_address));
      }
    }
    /*  $event="Create a new Service  (" . $service_name . ")";
        $db->insert('activity_logs',array('user_id'=>$_SESSION['user_id'],
                                          'event'=>$event,
                                          'company_id'=>CURRENT_LOGIN_COMPANY_ID,
                                          'created_date'=>date('Y-m-d'),
                                          'ip_address'=>$_SERVER['REMOTE_ADDR']

                                        ));*/
                                        $display_msg= '<div class="alert alert-success">
                                        <i class="lnr lnr-smile"></i> <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
                                        Service Add Successfully.
                                        </div>';

                                        echo "<script>
                                        setTimeout(function(){
                                         window.location = '".$link->link("services",frontend)."'
                                       },3000);</script>";



                                     }
                                   }
                                 }?>

                                 <!--Page content-->
                                 <!--===================================================-->
                                 <div id="page-content">
                                   <div class="row">
                                    <div class="col-md-12 "> 
                                      <?php echo $display_msg;?>
                                      <div class="panel">
                                        <div class="panel-heading">
                                          <div class="panel-control">
                                            <a href="<?php echo $link->link('services',user);?>" class="btn btn-default" data-click="panel-expand"><i class="fa fa-tag"></i> Services</a>
                                            
                                          </div>
                                          <h3 class="panel-title">Add Service</h3>
                                        </div>
                                        <!--Horizontal Form-->
                                        <!--===================================================-->
                                        <form  method="post" class="form-horizontal" action="<?php $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
                                          <div class="panel-body">
                                            <div class="row">
                                             
                                              
                                              <div class="col-md-6"> 
                                               
                                               
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
                                          <?php $all_service_categoy=$db->get_all('service_category',array('visibility_status'=>'active','company_id'=>CURRENT_LOGIN_COMPANY_ID,));
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
                        <!--  <div class="form-group">
                           <label class="control-label col-md-4">Status</label>
                           <div class="col-md-8">
                              <select class="form-control" name="visibility_status">
                                 <option value="active" <?php if ($_POST['visibility_status']=='active'){echo 'selected';}?>>Active</option>
                                 <option value="inactive" <?php if ($_POST['visibility_status']=='inactive'){echo 'selected';}?>>Inactive</option>
                              </select>
                           </div>
                         </div> -->
                       </div>
                       <div class="col-md-6">
                         <div class="form-group">  
                          <label class="col-md-4 control-label">Who can provide the service</label>
                          <div class="col-md-8">
                            <?php $all_staff=$db->get_all('users',array('visibility_status'=>'active','company_id'=>CURRENT_LOGIN_COMPANY_ID,));
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
                        </div>
                      </div>
                      
                      <div class="panel-footer text-center">
                       
                       <button class="btn btn-block btn-info" name="add_service_form_submit"   type="submit"><i class="fa fa-save"></i> Submit</button>  
                     </div>
                     
                   </form>

                 </div>
               </div>
               
             </div>
           </div>








