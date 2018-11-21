<?php
/*
$current_tab=$_COOKIE['current_tab'];

if ($current_tab=='active'){
    $db->order_by="id DESC";
    $customers=$db->get_all('customers',array('visibility_status'=>'active','company_id'=>CURRENT_LOGIN_COMPANY_ID));
}
elseif ($current_tab=='inactive'){
    $db->order_by="id DESC";
    $customers=$db->get_all('customers',array('visibility_status'=>'inactive','company_id'=>CURRENT_LOGIN_COMPANY_ID));
}
else {
    $db->order_by="id DESC";
    $customers=$db->get_all('customers',array('company_id'=>CURRENT_LOGIN_COMPANY_ID));
   
}*/
$db->order_by="id DESC";
$customers=$db->get_all('customers',array('company_id'=>CURRENT_LOGIN_COMPANY_ID));

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
       $first_name=$db->get_var('customers',array('id'=>$_POST['del_id']),'first_name');
       $last_name=$db->get_var('customers',array('id'=>$_POST['del_id']),'last_name');
      
        $event="<b>Customer</b>  ".ucfirst($first_name)." ".ucfirst($last_name)." was deleted";
        $db->insert('activity_logs',array('user_id'=>$_SESSION['user_id'],
                                          'event_type'=>'customer_deleted',
                                          'event'=>$event,
                                          'company_id'=>CURRENT_LOGIN_COMPANY_ID,
                                          'event_type_id'=>$_POST['del_id'],
                                          'created_date'=>date('Y-m-d'),
                                          'ip_address'=>$_SERVER['REMOTE_ADDR']

        ));
        $delete=$db->delete('customers',array('id'=>$_POST['del_id']));
       
        
        $d="DELETE FROM `appointments` WHERE `customer_id` = '$delete_id' AND `status`!='paid'";
        $db->run($d);
        if($delete)
        {

            $display_msg= '<div class="alert alert-success text-success">
                		<i class="fa fa-smile-o"></i>
                    <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
                    Customer Delete Successfully.
                		</div>';
            echo "<script>
                         setTimeout(function(){
        	    		  window.location = '".$link->link("customers",user)."'
        	                },3000);</script>";
        }
    }
    elseif(isset($_POST['no']))
    {
        $session->redirect('customers',user);
    }

}
elseif (isset($_REQUEST['action_active']))
{
    $action_id=$_REQUEST['action_active'];
    $update=$db->update('customers',array('visibility_status'=>'active'),array('id'=>$action_id));
    if ($update)
    {
        $display_name=$db->get_var('customers',array('id'=>$action_id),'first_name');
        $event="Status change to active of customer  (" . $display_name . ")";
        $db->insert('activity_logs',array('user_id'=>$_SESSION['user_id'],
                                            'event'=>$event,
                                            'company_id'=>CURRENT_LOGIN_COMPANY_ID,
                                            'created_date'=>date('Y-m-d'),
                                            'ip_address'=>$_SERVER['REMOTE_ADDR']
                                
                                        ));
        $display_msg= '<div class="alert alert-success text-success">
                		<i class="fa fa-smile-o"></i>
                    <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
                    Customer Active Successfully.
                		</div>';
        echo "<script>
                         setTimeout(function(){
        	    		  window.location = '".$link->link("customers",user)."'
        	                },3000);</script>";
    }
}
elseif (isset($_REQUEST['action_inactive']))
{
    $action_id=$_REQUEST['action_inactive'];
    $update=$db->update('customers',array('visibility_status'=>'inactive'),array('id'=>$action_id));
    if ($update)
    {
        $display_name=$db->get_var('customers',array('id'=>$action_id),'first_name');
        $event="Status change to inactive of Customer  (" . $display_name . ")";
        $db->insert('activity_logs',array('user_id'=>$_SESSION['user_id'],
                                            'event'=>$event,
                                            'company_id'=>CURRENT_LOGIN_COMPANY_ID,
                                            'created_date'=>date('Y-m-d'),
                                            'ip_address'=>$_SERVER['REMOTE_ADDR']
                                
                                        ));
        $display_msg= '<div class="alert alert-success text-success">
                		<i class="fa fa-smile-o"></i>
                    <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
                    Customer Inactive Successfully.
                		</div>';
        echo "<script>
                         setTimeout(function(){
        	    		  window.location = '".$link->link("customers",user)."'
        	                },3000);</script>";
    }
}
?>