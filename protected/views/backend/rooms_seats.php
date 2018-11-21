
<?php
if (isset($_REQUEST['action_id']))
{
    $company_id=$_REQUEST['action_id'];
    $company_details=$db->get_row('company',array('id'=>$company_id));
    $company_currency=$company_details['company_currencysymbol'];
    $company_name=$company_details['company_name'];
    $company_email=$company_details['company_email'];
     
    $allnotifications=$db->get_row('notification_settings',array('company_id'=>$company_id));
     
    $common_data_customer_notification=unserialize($allnotifications['customer_notification']);
    $common_data_staff_notification=unserialize($allnotifications['staff_notification']);
    $common_data_activity_alert=unserialize($allnotifications['activity_notifications']);
     
    if ($allnotifications['sendar_name']!="")
    {
        $common_data_sendar_name=$allnotifications['sendar_name'];
    }
    else
    {
        $common_data_sendar_name=$company_name;
    }
    if ($allnotifications['email_signature']!="")
    {
        $common_data_email_signature=html_entity_decode($allnotifications['email_signature']);
    }
    else
    {
        $common_data_email_signature="Thanks,<br>".$company_name;
    }
     
}













if (isset($_REQUEST['action_view_status']))
{
    $room_id=$_REQUEST['action_view_status'];
    $room_name=$db->get_var('rooms',array('id'=>$room_id),'name');
   // $allappointments=$db->get_all('appointments',array('assigned_room'=>$room_id));

    $bedquery="SELECT * FROM `appointments` WHERE `assigned_room`='$room_id'";
   
    
}
else
{
    $room_name="All Rooms";
    $c_id=$company_id;
    $bedquery="SELECT * FROM `appointments` WHERE `company_id`='$company_id' AND `assigned_room`!='0'";
   
}
if (isset($_POST['filter_by_submit']))
{
    if ($_POST['filter_by']!=""){
        $filterby=$_POST['filter_by'];
        if ($filterby=="today"){
            $DateFrom=date('Y-m-d');
            $DateTo=date('Y-m-d');
            }
            elseif ($filterby=="yesterday"){
                $DateFrom=date('Y-m-d',strtotime("-1 days"));
                $DateTo=date('Y-m-d',strtotime("-1 days"));
            }
            elseif ($filterby=="week"){
                $DateFrom=date('Y-m-d',strtotime("-7 days"));
                $DateTo=date('Y-m-d',strtotime("-1 days"));
            }
            elseif ($filterby=="month"){
                $DateFrom=date('Y-m-d', strtotime('last month'));
                $DateTo=date('Y-m-d');
            }
            elseif ($filterby=="upcoming"){
                $DateFrom=date('Y-m-d');
                $DateTo=date('Y-m-d', strtotime('+1 month', strtotime($DateFrom)));
            }
        
    if ($DateFrom!="" || $DateTo!="")
    {
        $bedquery.=" AND `appointment_date` between '$DateFrom' And '$DateTo'";
    }
    }
}
else
{
    $DateFrom=date('Y-m-d');
    $DateTo=date('Y-m-d');
    $bedquery.=" AND `appointment_date` between '$DateFrom' And '$DateTo'";
}
$allappointments=$db->run($bedquery)->fetchAll();



if (isset($_REQUEST['action_edit']))
{
    $room_details=$db->get_row('rooms',array('id'=>$_REQUEST['action_edit']));
   // print_r($room_details);
}
    

if (isset($_POST['add_room_submit']))
{
    $name=$_POST['name'];
    if ($name=="")
    {
         $display_msg= '<div class="alert alert-danger text-danger ">
		<i class="fa fa-frown-o"></i> 
            <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
            Enter Room/Seat Name.
		</div>';
    }
    else{
        if (isset($_REQUEST['action_edit'])){
            $insert=$db->update('rooms',array('name'=>$name),array('id'=>$_REQUEST['action_edit']));
        }
        else{
        $insert=$db->insert('rooms',array('name'=>$name,
                            'company_id'=>$company_id,
                            'created_date'=>date('Y-m-d'),
                            'ip_address'=>$_SERVER['REMOTE_ADDR'],
                            'visibility_status'=>'active'
        
        ));
        }
        if ($insert)
        {
            echo "<script>
                         setTimeout(function(){
        	    		  window.location = '".$link->link("rooms_seats",admin,'&action_id='.$company_id)."'
        	                },1000);</script>";
        }
      }
}
if(isset($_REQUEST['action_delete']))
{
    $delete_id=$_REQUEST['action_delete'];

    $display_msg='<form method="POST" action="">
    <div class="alert alert-danger">
    <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
	Are you sure ? You want to delete this .
	<input type="hidden" name="del_id" value="'.$delete_id.'" >
	<button name="yes" type="submit" class="btn btn-success btn-xs"  aria-hidden="true"><i class="fa fa-check-circle-o fa-2x"></i></button>
	<button name="no" type="submit" class="btn btn-danger btn-xs" aria-hidden="true"><i class="fa fa-times-circle-o fa-2x"></i></button>
	</div>
	</form>';
    if(isset($_POST['yes']))  
    { 
       
        $delete=$db->delete('rooms',array('id'=>$_POST['del_id']));
        if($delete)
        {

            $display_msg= '<div class="alert alert-success text-success">
                		<i class="fa fa-smile-o"></i>
                    <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
                    Room/Seat Delete Successfully.
                		</div>';
            echo "<script>
                         setTimeout(function(){
        	    		  window.location = '".$link->link("rooms_seats",admin,'&action_id='.$company_id)."'
        	                },3000);</script>";
        }
    }
    elseif(isset($_POST['no']))
    {
        $session->redirect('rooms_seats&action_id='.$company_id,admin);
    }

}




?>

                    <div id="page-content">
                       <div class="row">
                       <div class="col-sm-12"><?php echo $display_msg;?></div>
                            <div class="col-sm-4">
                            <div class="panel">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Rooms/Seats</h3>
                                    </div>
                                    <div class="panel-body"> 
                                    <form action="" method="post">
                                     <div class="input-group mar-btm">  
                                             <input type="text" placeholder="Room/Seat Name" name="name" class="form-control" value="<?php if (isset($_REQUEST['action_edit'])){echo $room_details['name'];}?>">
                                                 <span class="input-group-btn">
                                                  <button class="btn btn-info" type="submit" name="add_room_submit"><?php if (isset($_REQUEST['action_edit'])){echo "Edit";}else{echo "Add";}?></button>
                                                </span>
                                            </div>
                                            </form>
                                        <table class="table table-bordered">
                                            <thead>
                                              
                                            </thead>
                                            <tbody>
                                            
                                            <?php 
                                            $all_category=$db->get_all('rooms',array('visibility_status'=>'active','company_id'=>$company_id,));
                                            if (is_array($all_category)){
                                             foreach ($all_category as $allc)
                                             {
                                            ?>
                                                 <tr>
                                                    <td><h4><a  href="<?php echo $link->link('rooms_seats',admin,'&action_id='.$company_id.'&action_view_status='.$allc['id']);?>"><?php echo ucwords($allc['name']);?>&nbsp;&nbsp;<span class="badge badge-info"><?php echo $count_service;?></span></a></h4></td>
                                                    <td></td>
                                                    <td>
                                                    <a class="text-info" href="<?php echo $link->link('rooms_seats',admin,'&action_id='.$company_id.'&action_edit='.$allc['id']);?>"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;
                                                    <a class="text-danger" href="<?php echo $link->link('rooms_seats',admin,'&action_id='.$company_id.'&action_delete='.$allc['id']);?>"><i class="fa fa-trash"></i></a></td>
                                                </tr>
                                             <?php }}?>
                                          </tbody>
                                        </table>
                                    </div>
                                </div>
                               
                            </div>
                            <div class="col-lg-8">
                             <div class="panel">
                                    <div class="panel-heading">
                                    <div class="row">
                                    <div class="col-md-4">
                                     <h3 class="panel-title"> Room/Seat status 
                                        <button class="btn btn-danger " style="text-align: center; border-radius:50px;"><?php echo ucfirst($room_name);?></button>
                                        
                                        </h3>
                                    </div>
                                    <div class="col-md-8" >
                                    <form class="form-inline" style="margin-top: 6px;" action="" method="post">
                                   <div class="input-group mar-btm">
                                           <select class="form-control" name="filter_by">
                                             <option <?php if ($filterby=="today"){echo "selected='selected'";}?> value="today">Today</option>
                                             <option <?php if ($filterby=="upcoming"){echo "selected='selected'";}?> value="upcoming">Upcoming</option>
                                             <option <?php if ($filterby=="yesterday"){echo "selected='selected'";}?> value="yesterday">Yesterday</option>
                                             <option <?php if ($filterby=="week"){echo "selected='selected'";}?> value="week">Last Week</option>
                                             <option <?php if ($filterby=="month"){echo "selected='selected'";}?> value="month">Last Month</option>
                                             
                                             </select>
                                                  <span class="input-group-btn">
                                                <button class="btn btn-primary" type="submit" name="filter_by_submit"><i class="fa fa-filter"></i> Filter</button>
                                                </span>
                                            </div>
                                </form>
                                                </div></div>
                                       
                                       
                                    </div>
                                    <div class="panel-body">
                                   <table class="table table-striped table-bordered" id="demo-dt-basic">
                                 <thead>
					                   <tr row="">
					                   <th class="check-header hidden-xs">Room</th>
					                   <th>Date</th>
					                   <th>Booking Duration</th>
					                   <th>Occupied By</th>
					                  
					                     </tr>
					                  </thead>
					                  <tbody>
					                   <?php
                                            if (is_array($allappointments)){
                                                $sn=1;

                                            foreach ($allappointments as $value){
                                                $service_provider_firstname=$db->get_var('users',array('user_id'=>$value['staff_id']),'firstname');
                                                $service_provider_lastname=$db->get_var('users',array('user_id'=>$value['staff_id']),'lastname');
                                                $service_name=$db->get_var('services',array('id'=>$value['service_id']),'service_name');
                                                $room_name=$db->get_var('rooms',array('id'=>$value['assigned_room']),'name');
                                                
                                                $appointment_date=$value['appointment_date'];
                                                $appointment_time=$value['appointment_time'];
                                               
                                                $selectedTime = $appointment_time;
                                                $total_servicetime=$value['service_time']+$value['service_buffer_time'];
                                                $service_time="+".$total_servicetime." minutes";
                                                $endTime = strtotime($service_time, strtotime($selectedTime));
                                                $service_end_time=date('H:i:s', $endTime);
                                                
                                                $customer_firstname=$db->get_var('customers',array('id'=>$value['customer_id']),'first_name');
                                                $customer_lastname=$db->get_var('customers',array('id'=>$value['customer_id']),'last_name');
                                                ?>
					                    <tr>
					                      <td><?php echo ucwords($room_name);?></td>
                                          <td>
                                          <button class="btn btn-warning" style="text-align: center; border-radius:50px;"><?php echo date('D',strtotime($value['appointment_date']));?></button>
                                          
                                          <?php echo date('d M ,Y',strtotime($value['appointment_date']));?>
                                          <br><?php echo ucwords($service_provider_firstname." ".$service_provider_lastname);?> 
                                          . <?php echo ucfirst($service_name);?> . <?php echo $value['service_time']?> min . 
                                            <?php echo $company_currency."".$value['service_cost']?></td>
                                          
					                      <td><h4><button class="btn btn-warning" style="text-align: center; border-radius:50px;"><?php echo date('h:i a', strtotime($appointment_time));?>-<?php echo date('h:i a', strtotime($service_end_time));?></button></h4></td>
					                      <td><?php echo ucwords($customer_firstname." ".$customer_lastname);?></td>
					                     


					                    </tr>
					                   <?php $sn++;}}?>
					                  </tbody>
                           </table>
                                    </div>
                                </div>
                              
                            </div>
                       
                        </div>
                                </div>
