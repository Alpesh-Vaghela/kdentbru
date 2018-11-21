
<?php
if (isset($_REQUEST['action_id']))
{
    $company_id=$_REQUEST['action_id'];
    $company_details=$db->get_row('company',array('id'=>$company_id));
    $company_currency=$company_details['company_currencysymbol'];
    $company_name=$company_details['company_name'];
    $company_email=$company_details['company_email'];

}





$current_tab=$_COOKIE['current_tab'];
if (isset($_REQUEST['bycategory']))
{
    $allservices=$db->get_all('services',array('visibility_status'=>'active','service_category'=>$_REQUEST['bycategory'],'company_id'=>$company_id,));
  
}else
{
    $allservices=$db->get_all('services',array('visibility_status'=>'active','company_id'=>$company_id,));
}

if(isset($_REQUEST['action_delete_category']))
{
    $delete_id=$_REQUEST['action_delete_category'];

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
        $display_name=$db->get_var('service_category',array('id'=>$_POST['del_id']),'category_name');
        $event="Delete Servise Category   (" . $display_name . ") with id no " . $_POST['del_id'];
        $db->insert('activity_logs',array('user_id'=>$_SESSION['user_id'],
                                            'event'=>$event,
                                            'created_date'=>date('Y-m-d'),
                                            'ip_address'=>$_SERVER['REMOTE_ADDR']

        ));
        $delete=$db->delete('service_category',array('id'=>$_POST['del_id']));
        if($delete)
        {

            $display_msg= '<div class="alert alert-success text-success">
                		<i class="fa fa-smile-o"></i>
                    <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
                    Service Category Delete Successfully.
                		</div>';
            echo "<script>
                         setTimeout(function(){
        	    		  window.location = '".$link->link("services",admin,'&action_id='.$company_id)."'
        	                },3000);</script>";
        }
    }
    elseif(isset($_POST['no']))
    {
        $session->redirect('services&action_id='.$company_id,admin);
    }

}




?>

                    <div id="page-content">
                       <div class="row">
                       <div class="col-sm-12"><?php echo $display_msg;?></div>
                            <div class="col-sm-4">
                            <div class="panel">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Categories
                                         <button style="margin-top: 8px;"  type="button" class="btn btn-info pull-right" data-toggle="modal" data-target="#myModal_add_sevice_category"><i class="fa fa-plus"></i> Add Category</button>
                                       <!--   <a href="<?php echo $link->link('add_category',admin);?>" style="margin-top: 8px; color:white;"  class=" btn btn-info pull-right"><i class="fa fa-plus"></i> Add Category</a> -->
                                         
                                         </h3>
                                    </div>
                                    <div class="panel-body">
                                        <table class="table table-bordered">
                                            <thead>
                                              
                                            </thead>
                                            <tbody>
                                             <tr>
                                                    <td><a  href="<?php echo $link->link('services',admin,'&action_id='.$company_id);?>">All Services&nbsp;&nbsp;<span class="badge  badge-warning"><?php echo $db->get_count('services',array('visibility_status'=>'active','company_id'=>$company_id,));?></span></a></td>
                                                    <td></td>
                                                    <td></td>
                                              </tr>
                                            <?php 
                                            $all_category=$db->get_all('service_category',array('visibility_status'=>'active','company_id'=>$company_id,));
                                            if (is_array($all_category)){
                                             foreach ($all_category as $allc)
                                             {
                                                 $count_service=$db->get_count('services',array('service_category'=>$allc['id'],'company_id'=>$company_id,));
                                             ?>
                                                 <tr>
                                                    <td><a  href="<?php echo $link->link('services',admin,'&action_id='.$company_id.'&bycategory='.$allc['id']);?>"><?php echo $allc['category_name'];?>&nbsp;&nbsp;<span class="badge badge-info"><?php echo $count_service;?></span></a></td>
                                                    <td></td>
                                                    <td><a class="text-danger" href="<?php echo $link->link('services',admin,'&action_id='.$company_id.'&action_delete_category='.$allc['id']);?>"><i class="fa fa-trash"></i></a></td>
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
                                        <h3 class="panel-title"> All Services 
                                        <button style="margin-top: 8px;"  type="button" class="btn btn-info pull-right" data-toggle="modal" data-target="#myModal_add_sevice"><i class="fa fa-plus"></i> Add Service</button>
                                        </h3>
                                    </div>
                                    <div class="panel-body">
                                    <?php 
                                    if (is_array($allservices)){
                                    foreach ($allservices as $llser){?>
                                        <div class="alert alert-success media fade in">
                                             <div class="media-left">
                                                <span class="icon-wrap icon-wrap-xs icon-circle alert-icon">
                                                <i class="fa fa-bolt fa-lg"></i>
                                                </span>
                                            </div>
                                            <div class="media-body">
                                            <a href="<?php echo $link->link('edit_service',admin,'&action_id='.$company_id.'&action_edit='.$llser['id']);?>">
                                            <div class="row">
                                            <div class="col-lg-4">
                                                <h4 class="alert-title"><?php echo ucwords($llser['service_name']);?></h4>
                                                <p class="alert-message"><?php echo ucwords($llser['service_description']);?></p></div>
                                            <div class="col-lg-2 text-center"><?php echo $llser['service_time'];?>mins</div>
                                            <div class="col-lg-2 text-center"><?php echo $company_currency.number_format($llser['service_cost'],'2');?></div>
                                            <div class="col-lg-4 text-center"><?php if ($llser['service_buffer_time']!=""){ echo $llser['service_buffer_time']."mins";}else{echo "No Buffer";}?></div>
                                            
                                            
                                            </div>
                                            </a>
                                              
                                            </div>
                                            
                                       </div>
                                    <?php }                                        
                                    }?>
                                    
                                      
                                        <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
                                    </div>
                                </div>
                              
                            </div>
                       
                        </div>
                                </div>
