
<?php $current_tab=$_COOKIE['current_tab'];
if (isset($_REQUEST['bycategory']))
{
    $allservices=$db->get_all('services',array('visibility_status'=>'active','service_category'=>$_REQUEST['bycategory'],'company_id'=>CURRENT_LOGIN_COMPANY_ID,));
    
}else
{
    $allservices=$db->get_all('services',array('visibility_status'=>'active','company_id'=>CURRENT_LOGIN_COMPANY_ID,));
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
               window.location = '".$link->link("services",user)."'
           },3000);</script>";
       }
   }
   elseif(isset($_POST['no']))
   {
    $session->redirect('services',user);
}

}




?>

<!--===================================================-->
<div id="page-content">
 <div class="row">
     <div class="col-sm-12"><?php echo $display_msg;?></div>
     <div class="col-sm-4">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title"><h3 class="panel-title">Categories <a href="<?php echo $link->link('add_category',frontend);?>" style="margin-top: 8px; color:white;"  class=" btn btn-info pull-right"><i class="fa fa-plus"></i> Add Category</a></h3></h3>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                      
                    </thead>
                    <tbody>
                       <tr>
                        <td><a  href="<?php echo $link->link('services',frontend);?>">All Services&nbsp;&nbsp;<span class="badge  badge-warning"><?php echo $db->get_count('services',array('visibility_status'=>'active','company_id'=>CURRENT_LOGIN_COMPANY_ID,));?></span></a></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <?php 
                    $all_category=$db->get_all('service_category',array('visibility_status'=>'active','company_id'=>CURRENT_LOGIN_COMPANY_ID,));
                    if (is_array($all_category)){
                       foreach ($all_category as $allc)
                       {
                           $count_service=$db->get_count('services',array('service_category'=>$allc['id'],'company_id'=>CURRENT_LOGIN_COMPANY_ID,));
                           ?>
                           <tr>
                            <td><a  href="<?php echo $link->link('services',frontend,'&bycategory='.$allc['id']);?>"><?php echo $allc['category_name'];?>&nbsp;&nbsp;<span class="badge badge-info"><?php echo $count_service;?></span></a></td>
                            <td></td>
                            <td><a class="text-danger" href="<?php echo $link->link('services',frontend,'&action_delete_category='.$allc['id']);?>"><i class="fa fa-trash"></i></a></td>
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
        <h3 class="panel-title"> All Services <a href="<?php echo $link->link('add_service',frontend);?>" style="color:white;"  class=" btn btn-info pull-right"><i class="fa fa-plus"></i> Add Service</a></h3>
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
                    <a href="<?php echo $link->link('edit_service',frontend,'&action_edit='.$llser['id']);?>">
                        <div class="row">
                            <div class="col-lg-4">
                                <h4 class="alert-title"><?php echo ucwords($llser['service_name']);?></h4>
                                <p class="alert-message"><?php echo ucwords($llser['service_description']);?></p></div>
                                <div class="col-lg-2 text-center"><?php echo $llser['service_time'];?>mins</div>
                                <div class="col-lg-2 text-center"><?php echo CURRENCY.number_format($llser['service_cost'],'2');?></div>
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
