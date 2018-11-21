<?php
if (isset($_REQUEST['action_id']))
{
    $company_id=$_REQUEST['action_id'];
    $company_details=$db->get_row('company',array('id'=>$company_id));
    $company_currency=$company_details['company_currencysymbol'];
    $company_name=$company_details['company_name'];
    $company_email=$company_details['company_email'];
     
  
     
}
if (isset($_REQUEST['action_edit']))
{
    $edit_service_id=$_REQUEST['action_edit'];
    $service_detail=$db->get_row('services',array('id'=>$edit_service_id));
    
 if (isset($_REQUEST['remove_from']) && $_REQUEST['action_edit']!="")
    {
       $remove_from=$db->delete('assign_services',array('staff_id'=>$_REQUEST['remove_from'],
                                                        'service_id'=>$edit_service_id));
       $session->redirect('edit_service&action_id='.$company_id.'&action_edit='.$edit_service_id,admin); 
    }
    elseif (isset($_REQUEST['assign_to']) && $_REQUEST['action_edit']!=""){

        $db->insert('assign_services',array('company_id'=>$company_id,
                                            'staff_id'=>$_REQUEST['assign_to'],
                                            'service_id'=>$edit_service_id,
                                            'created_date'=>date('Y-m-d'),
                                            'ip_address'=>$_SERVER['REMOTE_ADDR']
                                            ));
        $session->redirect('edit_service&action_id='.$company_id.'&action_edit='.$edit_service_id,admin);
    }
}
if (isset($_POST['add_service_form_submit']) && $_REQUEST['action_edit']!="")
{
    //print_r($_POST);
    $service_name=$_POST['service_name'];
    $service_description=$_POST['service_description'];
    $service_cost=$_POST['service_cost'];
    $service_time=$_POST['service_time'];
    $service_buffer_time=$_POST['service_buffer_time'];
    $service_category=$_POST['service_category'];
    $assign_to=$_POST['assign_to'];
    $private_service=$_POST['private_service'];
    $visibility_status=$_POST['visibility_status'];
    $created_date=date('Y-m-d');
    $ip_address=$_SERVER['REMOTE_ADDR'];
    $cid=$company_id;
    
    $sql=" SELECT service_name FROM `services` WHERE `service_name`='$service_name' AND `company_id`='$cid'  AND `id`!='$edit_service_id'";
    $exist_service_name_check=$db->run($sql)->fetchAll();

$empt_fields = $fv->emptyfields(array('service Name'=>$service_name,
                                      'Sevice Cost'=>$service_cost,
                                      'Service Time'=>$service_time));

if ($empt_fields)
{ 
      $display_msg= '<div class="alert alert-danger text-danger">
		<i class="fa fa-frown-o"></i> 
          <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
          Oops! Following fields are empty<br>'.$empt_fields.'</div>';
}

elseif ($exist_service_name_check)
{
    $display_msg= '<div class="alert alert-danger text-danger">
		<i class="fa fa-frown-o"></i> 
        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
            Service Name is already exist.
		</div>';
}
else
{
 
   $insert=$db->update("services",array('service_name'=>$service_name,
                                        'service_cost'=>$service_cost,
                                        'service_description'=>$service_description,
                                        'service_time'=>$service_time,
                                        'service_buffer_time'=>$service_buffer_time,
                                        'service_category'=>$service_category,
                                         'private_service'=>$private_service,
                                      //  'visibility_status'=>$visibility_status,
                                        'ip_address'=>$ip_address),array('id'=>$edit_service_id));
 //  $db->debug();
    if ($insert){
     
                 $display_msg= '<div class="alert alert-success text-success">
                    		<i class="fa fa-smile-o"></i> <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
                     Service Update Successfully.
                    		</div>';

          echo "<script>
                         setTimeout(function(){
        	    		  window.location = '".$link->link("edit_service",admin,'&action_id='.$company_id.'&action_edit='.$edit_service_id)."'
        	                },3000);</script>";



    }
}
}?>

   <div class="pageheader">
                        <h3><i class="fa fa-edit"></i> Configure <small>(<?php echo ucwords(str_replace("_", " ", $query1ans));?>)</small></h3>
                        <div class="breadcrumb-wrapper">
                        
                            <ol class="breadcrumb">
                                <li> <a href="<?php echo $link->link('services',admin,'&action_id='.$company_id);?>"><i class="fa fa-arrow-left">Back</i></a> </li>
                               
                            </ol>
                        </div>
                   </div>
                    <div id="page-content">
                         <div class="row">
                          <div class="col-md-12 "> 
                                <?php echo $display_msg;?>
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <div class="panel-control">
                                                <a href="<?php echo $link->link('services',admin,'&action_id='.$company_id);?>" class="btn btn-default" data-click="panel-expand"><i class="fa fa-tag"></i> Services</a>
                                              
                                            </div>
                                            <h3 class="panel-title">Edit Service</h3>
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
                            <!-- <input class="form-control"  type="color" name="service_color" value="<?php echo $service_detail['service_color'];?>"> -->
                            <select id="scolor" class="form-control text-<?php echo $service_detail['service_color'];?>" name="service_color">
                            <option <?php  if($service_detail['service_color']=="danger"){echo "selected='selected'";}?> value="danger" class="text-danger">Red</option>
                            <option <?php  if($service_detail['service_color']=="success"){echo "selected='selected'";}?> value="success" class="text-success">Green</option>
                            <option <?php  if($service_detail['service_color']=="primary"){echo "selected='selected'";}?> value="primary" class="text-primary">Blue</option>
                            <option <?php  if($service_detail['service_color']=="info"){echo "selected='selected'";}?> value="info" class="text-info">Sky Blue</option>
                            <option <?php  if($service_detail['service_color']=="warning"){echo "selected='selected'";}?> value="warning" class="text-warning">Orange</option>
                            <option <?php  if($service_detail['service_color']=="mint"){echo "selected='selected'";}?> value="mint" class="text-mint">Mint Green</option>
                            <option <?php  if($service_detail['service_color']=="pink"){echo "selected='selected'";}?> value="pink" class="text-pink">pink</option>
                            <option <?php  if($service_detail['service_color']=="purple"){echo "selected='selected'";}?> value="purple" class="text-purple">purple</option>
                            <option <?php  if($service_detail['service_color']=="dark"){echo "selected='selected'";}?> value="dark" class="text-dark">Black</option>
                            <option <?php  if($service_detail['service_color']=="default"){echo "selected='selected'";}?> value="default" class="text-default">Gray</option> 
                            </select>   
                           </div> 
                           <div class="col-md-5">
                              <input class="form-control"  type="text" name="service_name" value="<?php echo $service_detail['service_name'];?>">
                           </div>
                        </div>
                        <div class="form-group">
                           <label class="control-label col-md-4">Service description</label>
                           <div class="col-md-8">
                              <textarea class="form-control" name="service_description"><?php echo $service_detail['service_description'];?></textarea>
                           </div>
                        </div>
                        <div class="form-group" id="business_name_id">
                           <label class="control-label col-md-4">Service Cost<font color="red">*</font></label>
                           <div class="col-md-8">
                              <input class="form-control" placeholder="" type="text" name="service_cost" value="<?php echo $service_detail['service_cost'];?>">
                           </div>
                        </div>
                        <div class="form-group">
                           <label class="control-label col-md-4">Service Time(Mins)<font color="red">*</font></label>
                           <div class="col-md-8">
                              <input class="form-control" placeholder="" type="number" name="service_time" value="<?php echo $service_detail['service_time'];?>">
                           </div>
                        </div>
                           <div class="form-group">
                           <label class="control-label col-md-4">Service Buffer Time(Mins)</label>
                         
                           <div class="col-md-8">
                              <input class="form-control" placeholder="" type="number" name="service_buffer_time" value="<?php echo $service_detail['service_buffer_time'];?>">
                           </div>
                        </div>
                      <div class="form-group">
                           <label class="control-label col-md-4">Category</label>
                           <div class="col-md-8">
                              <select class="form-control" name="service_category">
                              <option value="">Select Category</option>
                              <?php $all_service_categoy=$db->get_all('service_category',array('visibility_status'=>'active','company_id'=>$company_id));
                              if (is_array($all_service_categoy)){
                                  foreach ($all_service_categoy as $allcs){?>
                                      <option <?php if ($service_detail['service_category']==$allcs['id']){echo "selected";};?> value="<?php echo $allcs['id'];?>"><?php echo $allcs['category_name'];?></option>
                                  <?php }}?>
                              
                              </select>
                           </div>
                        </div>
                       <div class="form-group">
                           <label class="control-label col-md-4">Private Service</label>
                           <div class="col-md-8">
                              <select class="form-control" name="private_service">
                              <option <?php if ($service_detail['private_service']=="no"){echo "selected";};?> value="no">No</option>
                              <option <?php if ($service_detail['private_service']=="yes"){echo "selected";};?> value="yes">Yes</option>
                           </select>
                           </div>
                        </div>
                        
                          <div class="form-group">
                           <label class="control-label col-md-4"></label>
                           <div class="col-md-8">
                            <button class="btn btn-block btn-info" name="add_service_form_submit"   type="submit"><i class="fa fa-save"></i> Submit</button>
                           </div>
                        </div>
                  
                       </div>
                       
                       <div class="col-md-6" style="border-left:1px solid red;">
                                    <div class="form-group">
                           <label class="control-label col-md-4"></label>
                           <div class="col-md-8">
                           <h4>Who can provide the service(Staff)</h4>
                           
                                    <table class="table table-hover table-vcenter"> 
                                            <thead>
                                                <tr>
                                                    <th>&nbsp;</th>
                                                    <th>&nbsp;</th>
                                                   
                                                </tr>
                                            </thead>
                                            <tbody>
                                                   <?php $all_staff=$db->get_all('users',array('visibility_status'=>'active','company_id'=>$company_id));
                                        if (is_array($all_staff)){
                                            foreach ($all_staff as $as){
                                           if (!$db->exists('assign_services',array('staff_id'=>$as['user_id'],'service_id'=>$edit_service_id)))
                                           {?>
                                            <tr>
                                             <td>
                                             <a href="<?php echo $link->link('edit_service',admin,'&action_id='.$company_id.'&action_edit='.$edit_service_id).'&assign_to='.$as['user_id']?>"><i class="fa fa-plus-circle fa-2x text-danger"></i></a>
                                             </td>
                                             <td><?php echo ucwords($as['firstname']." ".$as['lastname']);?></td>
                                            </tr>
                                              
                                           <?php }
                                           else
                                           {?>
                                           <tr>
                                             <td>
                                                       <a   href="<?php echo $link->link('edit_service',admin,'&action_id='.$company_id.'&action_edit='.$edit_service_id).'&remove_from='.$as['user_id']?>"><i class="fa fa-check-circle fa-2x text-success"></i></a>
                                                    </td>
                                                   <td><?php echo ucwords($as['firstname']." ".$as['lastname']);?></td>
                                                   
                                                     
                                                </tr>
                                               
                                          <?php }
                                                
                                           }
                                        }?>

                                                                               
                                               </tbody>
                                        </table>
                           </div>
                        </div>
                                    
                                    
                                    
                                    
                                   
                                    </div>
                              
                         
					        </div>
					        </div>
                                                    
                                        <div class="panel-footer text-right">
                                         
                                           
                                        </div>
                                        
                                         </form>

                                    </div>
                                </div>
                         
                        </div>
                    </div>








