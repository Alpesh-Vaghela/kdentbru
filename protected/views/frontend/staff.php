
<?php
$current_tab=$_COOKIE['current_tab'];
if ($current_tab!="details" && $current_tab!="services" && $current_tab!="working_hours" 
    && $current_tab!="breaks" && $current_tab!="timeoff" && $current_tab!="login_details"){$current_tab="details";}
    if (isset($_REQUEST['sid']) && $_REQUEST['sid']!="")
    {
        $edit_staff_id=$_REQUEST['sid'];
        $staff_detail=$db->get_row('users',array('user_id'=>$edit_staff_id));
        
        if ($staff_detail['working_day']!="" && $staff_detail['working_on_off']!="" 
           && $staff_detail['working_start_time']!="" 
           && $staff_detail['working_end_time']!="")
        {
            $working_day=unserialize($staff_detail['working_day']);
            $working_on_off=unserialize($staff_detail['working_on_off']);
            $working_start_time=unserialize($staff_detail['working_start_time']); 
            $working_end_time=unserialize($staff_detail['working_end_time']);
            
       // print_r($working_start_time);
      //  echo "--------------";
      //  print_r($working_end_time);
        }
        else{
            $working_day=unserialize($common_data_company_setting['working_day']);
            $working_on_off=unserialize($common_data_company_setting['working_on_off']);
            $working_start_time=unserialize($common_data_company_setting['working_start_time']);
            $working_end_time=unserialize($common_data_company_setting['working_end_time']);
        }
        
        
        
        /****************************************************Update staff  details***********************/    
        if(isset($_POST['update_staff_details_form_submit']))
        {
            
            $staff_fname=$_POST['staff_fname'];
            $staff_lname=$_POST['staff_lname'];
            $staff_description=$_POST['staff_description'];
            $colour=$_POST['colour'];
            $staff_mobile=$_POST['staff_mobile'];
            $staff_email=$_POST['staff_email'];
            $profilepic=$_FILES['profilepic'];
            $cid=CURRENT_LOGIN_COMPANY_ID;

            $sql=" SELECT `email` FROM `users` WHERE `email`='$staff_email' AND `user_id`!='$edit_staff_id'";
            $exist_staff_email_check=$db->run($sql)->fetchAll();
            
            if ($fv->emptyfields(array('Staff First Name'=>$staff_fname),NULL))
            {
                
                $display_msg='<div class="alert alert-danger text-danger">
                <i class="fa fa-frown-o text-danger"></i>
                <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
                Staff first name can not be Blank.
                </div>';
                
                
            }
            elseif (!$fv->check_email($staff_email)) 
            {
                $display_msg='<div class="alert alert-danger text-danger text-danger">
                <i class="fa fa-frown-o text-danger"></i>
                <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
                Wrong Email Format!.
                </div>';
                
            }
            elseif ($exist_staff_email_check)
            {
                $display_msg='<div class="alert alert-danger text-danger text-danger">
                <i class="fa fa-frown-o text-danger"></i>
                <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
                Staff email already exist!.
                </div>';
                
            }
            elseif ($profilepic['name']!='')
            {
                
                $handle= new upload($_FILES['profilepic']);
                $path = SERVER_ROOT.'/uploads/company/'.CURRENT_LOGIN_COMPANY_ID.'/users/'.$edit_staff_id.'/';
                if(!is_dir($path))
                {
                    if(!file_exists($path)){
                        mkdir($path);
                    }
                }
                
                if(file_exists(SERVER_ROOT.'/uploads/company/'.CURRENT_LOGIN_COMPANY_ID.'/users/'.$edit_staff_id.'/'.$staff_detail['user_photo_file']) && (($staff_detail['user_photo_file'])!=''))
                {
                    unlink(SERVER_ROOT.'/uploads/company/'.CURRENT_LOGIN_COMPANY_ID.'/users/'.$edit_staff_id.'/'.$staff_detail['user_photo_file']);
                }
                $newfilename = $handle->file_new_name_body=time();
                $ext = $handle->image_src_type;
                $filename = $newfilename.'.'.$ext;
            //$file_size = $_FILES ['file'] ['size'] / 1024;
                
                if ($handle->image_src_type == 'jpg' || $handle->image_src_type == 'jpeg' || $handle->image_src_type == 'png' )
                {
                    if ($handle->uploaded) {
                        $handle->Process($path);
                        if ($handle->processed)
                        {
                            $update=$db->update('users',array('firstname'=>$staff_fname,
                              'lastname'=>$staff_lname,
                              'email'=>$staff_email,
                              'mobile'=>$staff_mobile,
                              'description'=>$staff_description,
                              'colour' => $colour,
                              'user_photo_file'=>$filename,
                                                            //'address'=>$address
                          ),array('user_id'=>$edit_staff_id));
                            
                            $event="Update Staff (".$staff_fname." ".$staff_lname.") and Change staff image";
                            $db->insert('activity_logs',array('user_id'=>$_SESSION['user_id'],
                              'event'=>$event,
                              'company_id'=>CURRENT_LOGIN_COMPANY_ID,
                              'created_date'=>date('Y-m-d'),
                              'ip_address'=>$_SERVER['REMOTE_ADDR']));
                        }
                    }
                }
                
                
                if($update)
                {
                    $display_msg='<div class="alert alert-success text-success">
                    <i class="fa fa-smile-o"></i>
                    <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
                    Success! Data Updated.
                    </div>';
                    
                    echo "<script>
                    setTimeout(function(){
                       window.location = '".$link->link("staff",frontend,'&sid='.$edit_staff_id)."'
                   },3000);</script>";
               }
               
               
           }
           else
           {
               $update=$db->update('users',array('firstname'=>$staff_fname,
                'lastname'=>$staff_lname,
                'mobile'=>$staff_mobile,
                'email'=>$staff_email,
                'description'=>$staff_description,
                'colour'=>$colour,
            ),array('user_id'=>$edit_staff_id));
               
               $event="Update Staff (".$staff_fname." ".$staff_lname.") and Change staff image";
               $db->insert('activity_logs',array('user_id'=>$_SESSION['user_id'],
                  'event'=>$event,
                  'company_id'=>CURRENT_LOGIN_COMPANY_ID,
                  'created_date'=>date('Y-m-d'),
                  'ip_address'=>$_SERVER['REMOTE_ADDR']));
               
               
               if($update)
               {
                $display_msg='<div class="alert alert-success text-success">
                <i class="fa fa-smile-o"></i>
                <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>Success! Data Updated.
                </div>';
                
                echo "<script>
                setTimeout(function(){
                   window.location = '".$link->link("staff",frontend,'&sid='.$edit_staff_id)."'
               },3000);</script>";
           }
           
       }
       
       
       
       
   }
   /****************************************************Update staff Working hours details***********************/    
   elseif (isset($_POST['update_staff_working_form_submit']))
   {
    //print_r($_POST);
    $day=serialize($_POST['day']);
    $on_or_off=serialize($_POST['on_or_off']);
    $starttime=serialize($_POST['starttime']);
    $endtime=serialize($_POST['endtime']);
    
    $update=$db->update('users',array('working_day'=>$day,
        'working_on_off'=>$on_or_off,
        'working_start_time'=>$starttime,
        'working_end_time'=>$endtime)
    ,array('user_id'=>$edit_staff_id));
    
    if ($update)
    {
        $display_msg='<div class="alert alert-success text-success">
        <i class="fa fa-smile-o"></i>
        <button class="close" data-dismiss="alert" type="button">
        <i class="fa fa-times-circle-o"></i></button>
        Success! Data Updated.
        </div>';
        
        echo "<script>
        setTimeout(function(){
           window.location = '".$link->link("staff",frontend,'&sid='.$edit_staff_id)."'
       },1000);</script>";
   }
}
/****************************************************Update staff login details*******************************/
elseif (isset($_POST['update_staff_login_details_form_submit']))
{
    $staff_login=$_POST['staff_login'];
    $access_controls=$_POST['access_controls'];
    
    
    
    if ($staff_login!="")
    {
        $staff_login="yes";
        $empty=$fv->emptyfields(array('Access Controls'=>$access_controls),NULL);
        
    }else{
        $staff_login="no";
    }
    
    if ($empty)
    {
        
        $display_msg='<div class="alert alert-danger text-danger">
        <i class="fa fa-frown-o text-danger"></i>
        <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
        Following Fields are empty!<br>'.$empty.'</div>';
        
        
    }else{
        $enc=$feature->encrypt(time());
        $db->update ('users',array('random'=>$enc,'user_type'=>$access_controls,'staff_login'=>$staff_login),array('user_id'=>$edit_staff_id));
        
        $email_body = '<table cellspacing="0" cellpadding="0" style="padding:30px 10px;background-color:rgb(238,238,238);width:100%;font-family:arial;background-repeat:initial initial">
        <tbody>
        <tr>
        <td>
        <table align="center" cellspacing="0" style="max-width:650px;min-width:320px">
        <tbody>
        <tr>
        <td align="center" style="background:#fff;border:1px solid #e4e4e4;padding:50px 30px">
        <table align="center">
        <tbody>
        <tr>
        <td style="border-bottom:1px solid #dfdfd0;color:#666;text-align:center">
        <table align="left" width="100%" style="margin:auto">
        <tbody>
        <tr>
        <td style="text-align:left;padding-bottom:14px">
        <img align="left" alt="'.SITE_NAME.'" src="'.SITE_LOGO.'" width="150px"></td>
        </tr>
        
        </table>
        <table align="left" style="margin:auto">
        <tbody>
        <tr>
        <td style="color:rgb(102,102,102);font-size:16px;padding-bottom:30px;text-align:left;font-family:arial">
        Hello, '.ucwords($staff_detail[firstname].' '.$staff_detail[lastname]).'
        You have requested to set password. Please click on the link or copy and paste the link in browser to proceed.<br><br>
        
        Password Link : '. SITE_URL . '/index.php?user=forgot_password&random='.$enc.'<br>
        
        <br /><br><br>Regards<br><br>
        '. COMPANY_NAME .'<br>
        </td>				</tr>
        </tbody>
        </table>
        </td>
        </tr>
        </tbody>
        </table>
        </td>
        </tr>
        </tbody>
        </table>
        </td>
        </tr>
        </tbody>
        </table>';
        
        
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: '.COMPANY_NAME .'<'.COMPANY_EMAIL . ">\r\n" .
        'Reply-To: '.COMPANY_EMAIL . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
        
        if ($staff_detail['password']==''){
            $confirm    =  mail($staff_detail['email'], 'Set Password Request',$email_body,$headers);
        }
        
        
        if($confirm=='1')
        {
            $display_msg = '<div class="alert alert-success text-success">
            <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle"></i></button>
            Login details update successfully and Mail sent to Staff EmailId .
            </div>';
            echo "<script>
            setTimeout(function(){
               window.location = '".$link->link("staff",frontend,'&sid='.$edit_staff_id)."'
           },3000);</script>";
       }
       else
       {
           $display_msg = '<div class="alert alert-success text-success">
           <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle"></i></button>
           Login details update successfully .
           </div>';
           echo "<script>
           setTimeout(function(){
               window.location = '".$link->link("staff",frontend,'&sid='.$edit_staff_id)."'
           },3000);</script>";
       }
       
       
   }
   
   
   
   
   
   
}

/****************************************************Remove service to staff***********************/
if (isset($_REQUEST['remove_from']) && $_REQUEST['sid']!="")
{
    $remove_from=$db->delete('assign_services',array('staff_id'=>$edit_staff_id,
       'service_id'=>$_REQUEST['remove_from']));
    $session->redirect('staff&sid='.$edit_staff_id,frontend);
}
/****************************************************Assign service to staff***********************/
if (isset($_REQUEST['assign_to']) && $_REQUEST['sid']!=""){
    $db->insert('assign_services',array('staff_id'=>$edit_staff_id,
        'service_id'=>$_REQUEST['assign_to'],
        'company_id'=>CURRENT_LOGIN_COMPANY_ID,
        'created_date'=>date('Y-m-d'),
        'ip_address'=>$_SERVER['REMOTE_ADDR']));
    $session->redirect('staff&sid='.$edit_staff_id,frontend);
}
/****************************************************delete time off*******************************/
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
        $delete=$db->delete('timeoff',array('id'=>$_POST['del_id']));
        if($delete)
        {

            $display_msg= '<div class="alert alert-success text-success">
            <i class="fa fa-smile-o"></i>
            <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
            Timeoff Delete Successfully.
            </div>';
            echo "<script>
            setTimeout(function(){
               window.location = '".$link->link("staff",user,'&sid='.$edit_staff_id)."'
           },3000);</script>";
       }
   }
   elseif(isset($_POST['no']))
   {
    $session->redirect('staff&sid='.$edit_staff_id,user);
}

}
/**********************************************delete staff*****************************/
if(isset($_REQUEST['action_delete_staff']))
{
    $delete_id=$edit_staff_id;

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
        $delete=$db->delete('users',array('user_id'=>$_POST['del_id']));
        if($delete)
        {
            $ccid_new=CURRENT_LOGIN_COMPANY_ID;
            $query="SELECT `user_id` FROM `users` WHERE `company_id`='$ccid_new' ORDER BY user_id DESC LIMIT 0, 1";
            $ds1=$db->run($query)->fetch();
            $sid_new=$ds1['user_id'];

            $display_msg= '<div class="alert alert-success text-success">
            <i class="fa fa-smile-o"></i>
            <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
            Staff Delete Successfully.
            </div>';
            echo "<script>
            setTimeout(function(){
               window.location = '".$link->link("staff",user,'&sid='.$sid_new)."'
           },3000);</script>";
       }
   }
   elseif(isset($_POST['no']))
   {
    $session->redirect('staff&sid='.$edit_staff_id,user);
}

}
/**********************************************delete staff end*****************************/


}else
{
    $session->redirect('home',frontend);
}
?>


<!--===================================================-->
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.3.6/css/bootstrap-colorpicker.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.3.6/js/bootstrap-colorpicker.js"></script>
<div id="page-content">
 
    <div class="row">
        <?php echo $display_msg;?>
        <div class="col-sm-4">
            <div class="panel">
                <!--Panel heading-->
                <div class="panel-heading ui-sortable-handle">
                    <h3 class="panel-title">Staff 
                        <button style="margin-top: 8px;"  type="button" class="btn btn-info pull-right" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Add Staff</button>
                    </h3>
                </div>
                <!--Default panel contents-->
                <div class="panel-body">
                 <div class="nano has-scrollbar" style="height:320px">
                    <div class="nano-content pad-all" tabindex="0" style="right: -17px;">
                        <table class="table">
                          
                            <tbody> 
                                <?php 
                                $db->order_by='user_id DESC';
                                $allstaff=$db->get_all('users',array('visibility_status'=>'active','company_id'=>CURRENT_LOGIN_COMPANY_ID));
                                if (is_array($allstaff)){
                                    foreach ($allstaff as $alls){?>
                                        <tr>
                                            <td class="text-center">
                                              <?php
                                              if(file_exists(SERVER_ROOT.'/uploads/company/'.CURRENT_LOGIN_COMPANY_ID.'/users/'.$alls['user_id'].'/'.$alls['user_photo_file']) && (($alls['user_photo_file'])!=''))
                                                {?>
                                                   <img class="img-circle img-sm" class="img-md" src="<?php echo SITE_URL.'/uploads/company/'.CURRENT_LOGIN_COMPANY_ID.'/users/'.$alls['user_id'].'/'.$alls['user_photo_file'];?>">
                                               <?php } else{?>
                                                  <img class="img-circle img-sm" src="<?php echo SITE_URL.'/assets/frontend/default_image/default_user_image.png';?>" alt="Profile Picture">
                                              <?php }?> 
                                          </td>
                                          <td><a href="<?php echo $link->link('staff',frontend,'&sid='.$alls['user_id']);?>">
                                              <h4><?php echo ucwords($alls['firstname'])." ".$alls['lastname']."<span class='text-primary'>(".ucfirst($alls['user_type']).")</span>";?></h4>
                                          </a></td>
                                          
                                          <td>
                                            <!-- <a class="pull-right" href="<?php echo $link->link('staff',frontend,'&sid='.$edit_staff_id.'&action_delete_staff');?>"><i class="fa fa-trash  text-danger"></i></a> -->
                                        </td>
                                    </tr>
                                    
                                <?php }}?>
                                
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--Table-->
            
        </div>
    </div>
    <div class="col-lg-8" readonly="">
        <!--Default Tabs (Left Aligned)-->
        <!--===================================================-->
        <div class="tab-base">
            <!--Nav Tabs-->
            <ul class="nav nav-tabs">
              <li tab="details"  class="set_cookie <?php if ($current_tab=='' || $current_tab=='details'){echo 'active';}?>">
               <a  href="#">Anagrafica</a>
           </li>
           <li tab="services"  class="set_cookie <?php if ($current_tab=='services'){echo 'active';}?>">
               <a  href="#">Prestazioni</a>
           </li>
           <li tab="working_hours"  class="set_cookie <?php if ($current_tab=='working_hours'){echo 'active';}?>">
               <a  href="#">Turni di lavoro</a>
           </li>
                                     <!--  <li tab="breaks"  class="set_cookie <?php if ($current_tab=='breaks'){echo 'active';}?>">
                                         <a  href="#">Breaks</a>
                                     </li> -->
                                     <li tab="timeoff"  class="set_cookie <?php if ($current_tab=='timeoff'){echo 'active';}?>">
                                       <a  href="#">Permessi/Ferie</a>
                                   </li>
                                   <li tab="login_details"  class="set_cookie <?php if ($current_tab=='login_details'){echo 'active';}?>">
                                       <a  href="#">Dettagli accesso</a>
                                   </li>
                                   
                               </ul>
                               <!--Tabs Content-->
                               <div class="tab-content">
                                <?php if ($current_tab=="details"){?> 
                                    
                                   <form method="post" class="form-horizontal" action="" enctype="multipart/form-data">
                                       <div class="row">
                                         <div class="col-md-3">
                                            <div class="form-group">
                                             <label class="control-label col-md-3"></label>
                                             <div class="col-md-9 show_image_input">
                                                 
                                                 <?php
                                                 if(file_exists(SERVER_ROOT.'/uploads/company/'.CURRENT_LOGIN_COMPANY_ID.'/users/'.$edit_staff_id.'/'.$staff_detail['user_photo_file']) && (($staff_detail['user_photo_file'])!=''))
                                                    {?>
                                                       <img class="img-circle img-lg" class="img-md" src="<?php echo SITE_URL.'/uploads/company/'.CURRENT_LOGIN_COMPANY_ID.'/users/'.$edit_staff_id.'/'.$staff_detail['user_photo_file'];?>">
                                                   <?php } else{?>
                                                      <img class="img-circle img-lg" src="<?php echo SITE_URL.'/assets/frontend/default_image/default_user_image.png';?>" alt="Profile Picture">
                                                  <?php }?> 
                                                  
                                                  
                                                  
                                                  
                                              </div>
                                          </div>
                                          <div class="form-group">
                                             <label class="control-label col-md-3"></label>
                                             <div class="col-md-9 file_input" style="display:none;">
                                              <input type="file" name="profilepic" placeholder="Upload Image" class="form-control">
                                          </div>
                                      </div>
                                  </div>
                                  <div class="col-md-9">
                                    <h3>Dettagli di <?php echo ucwords($staff_detail['firstname']." ".$staff_detail['lastname']);?></h3>
                                    <div class="form-group">
                                     <label class="control-label col-md-3">Nome e Cognome<font color="red">*</font></label>
                                     <div class="col-md-5">
                                      <input class="form-control" placeholder="Nome e Cognome" type="text" name="staff_fname" value="<?php echo $staff_detail['firstname'];?>">
                                  </div>
                                  <div class="col-md-4">
                                      <input class="form-control" placeholder="" type="text" name="staff_lname" value="<?php echo $staff_detail['lastname'];?>">
                                  </div>
                              </div>
                              
                              <div class="form-group">
                                 <label class="control-label col-md-3">Descrizione</label>
                                 <div class="col-md-9">
                                  <textarea placeholder="Staff description" class="form-control"name="staff_description"><?php echo $staff_detail['description'];?></textarea>
                              </div>
                          </div>
                          <div class="form-group">
                             <label class="control-label col-md-3">Telefono mobile</label>
                             <div class="col-md-9">
                              <input placeholder="Mobile" class="form-control" type="text" name="staff_mobile" value="<?php echo $staff_detail['mobile'];?>">
                          </div>
                      </div>
                      <div class="form-group">
                         <label class="control-label col-md-3">Email<font color="red">*</font></label>
                         <div class="col-md-9">
                          <input placeholder="Email" class="form-control" type="text" name="staff_email" value="<?php echo $staff_detail['email'];?>">
                      </div>
                  </div>
                  <div class="form-group">
                     <label class="control-label col-md-3">Colore<font color="red">*</font></label>
                     <div class="col-md-9"  >
                      <input class="form-control" type="text" id="colorpickeme" name="colour" value="<?php echo ($staff_detail['colour'] != '') ? $staff_detail['colour']:'#fff';?>" style="background-color:<?php echo ($staff_detail['colour'] != '') ? $staff_detail['colour']:'#fff';?>">
                      
                      
                  </div>
              </div>
              <div class="form-group">
                 <label class="control-label col-md-3"></label>
                 <div class="col-md-9">
                  <button class="btn btn-block btn-info" name="update_staff_details_form_submit" type="submit"><i class="fa fa-save"></i> Aggiorna</button>
              </div>
          </div>
          
      </div>
      
      
  </div>
  
  
  
</form>
<script type="text/javascript">
   $('#cp2').colorpicker();
</script>
<?php }elseif ($current_tab=="services"){?>
  <form method="post" class="form-horizontal" action="" enctype="multipart/form-data">
   <div class="row">
    <div class="col-md-3">
       <div class="col-md-9 show_image_input">
         
         <?php
         if(file_exists(SERVER_ROOT.'/uploads/company/'.CURRENT_LOGIN_COMPANY_ID.'/users/'.$edit_staff_id.'/'.$staff_detail['user_photo_file']) && (($staff_detail['user_photo_file'])!=''))
            {?>
               <img class="img-circle img-lg" class="img-md" src="<?php echo SITE_URL.'/uploads/company/'.CURRENT_LOGIN_COMPANY_ID.'/users/'.$edit_staff_id.'/'.$staff_detail['user_photo_file'];?>">
           <?php } else{?>
              <img class="img-circle img-lg" src="<?php echo SITE_URL.'/assets/frontend/default_image/default_user_image.png';?>" alt="Profile Picture">
          <?php }?> 
      </div>
  </div>
  <div class="col-md-9">
    <h3><?php echo ucwords($staff_detail['firstname']." ".$staff_detail['lastname']);?> eroga le seguenti prestazioni</h3>
    <table class="table table-hover table-vcenter">
        <thead>
            <tr>
                <th>&nbsp;</th>
                <th>Prestazioni</th>
                <th>Durata</th>
                <th>Costo</th>
            </tr>
        </thead>
        <tbody>
            <?php $services=$db->get_all('services',array('visibility_status'=>'active','company_id'=>CURRENT_LOGIN_COMPANY_ID));
            if (is_array($services)){
                foreach ($services as $als){
                    
                    if (!$db->exists('assign_services',array('staff_id'=>$edit_staff_id,'service_id'=>$als['id'])))
                    {
                        ?>
                        
                        <tr>
                           
                            <td>
                             <a href="<?php echo $link->link('staff',frontend,'&sid='.$edit_staff_id).'&assign_to='.$als['id']?>"><i class="fa fa-plus-circle fa-2x text-danger"></i></a>
                         </td>
                         <td><?php echo ucwords($als['service_name']);?></td>
                         <td><?php echo $als['service_time'];?>mins</td>
                         <td>
                            <?php if ($als['service_cost']!=""){ echo CURRENCY." ".number_format($als['service_cost'],'2');}?>
                        </td>
                        
                    </tr>
                    
                <?php }else{?>
                 
                   <tr>
                    <td>
                     <a href="<?php echo $link->link('staff',frontend,'&sid='.$edit_staff_id).'&remove_from='.$als['id']?>"><i class="fa fa-check-circle fa-2x text-success"></i></a>
                 </td>
                 <td><?php echo ucwords($als['service_name']);?></td>
                 <td><?php echo $als['service_time'];?>mins</td>
                 <td>
                    <?php if ($als['service_cost']!=""){ echo CURRENCY." ".number_format($als['service_cost'],'2');}?>
                </td>
                
            </tr>
            
            
        <?php }?>
        
    <?php }
}?>

</tbody>
</table>







</div>
</div>
</form>
<?php }elseif ($current_tab=="working_hours"){?>
   <form method="post" class="form-horizontal" action="" enctype="multipart/form-data">
       <div class="row">
        <div class="col-md-3">
           <div class="col-md-9 show_image_input">
            <?php
            if(file_exists(SERVER_ROOT.'/uploads/company/'.CURRENT_LOGIN_COMPANY_ID.'/users/'.$edit_staff_id.'/'.$staff_detail['user_photo_file']) && (($staff_detail['user_photo_file'])!=''))
                {?>
                   <img class="img-circle img-lg" class="img-md" src="<?php echo SITE_URL.'/uploads/company/'.CURRENT_LOGIN_COMPANY_ID.'/users/'.$edit_staff_id.'/'.$staff_detail['user_photo_file'];?>">
               <?php } else{?>
                  <img class="img-circle img-lg" src="<?php echo SITE_URL.'/assets/frontend/default_image/default_user_image.png';?>" alt="Profile Picture">
              <?php }?> 
          </div>
      </div>
      <div class="col-md-9">
        <h3>Turni di lavoro di  <?php echo ucwords($staff_detail['firstname']." ".$staff_detail['lastname']);?></h3>
        <table class="table table-hover table-vcenter">
            <thead>
                <tr>
                   <th width="25%">&nbsp;</th>
                   <th width="15%">&nbsp;</th>
                   <th width="30%">&nbsp;</th>
                   <th width="30%">&nbsp;</th>
               </tr>
           </thead>
           <tbody>
              
            <?php 
            if (is_array($working_day)){
                foreach ($working_day as $key=>$value){
                    $day_name=$value;
                    $on_off=$working_on_off[$key];
                    $starttime=$working_start_time[$key];
                    $endtime=$working_end_time[$key];
                    ?>
                    <tr>
                        <td><span style="border-radius:50px;" class="<?php if ($on_off=="on"){echo "btn btn-mint";}else{echo "btn btn-default";}?>"><?php echo ucfirst($day_name);?></span>
                            <input type="hidden" name="day[]" value="<?php echo $day_name;?>"></td>
                            <td>
                             <select name="on_or_off[]" class="form-control" >
                                 <option <?php if ($on_off=="on"){echo "selected";}?> value="on">On</option>
                                 <option <?php if ($on_off=="off"){echo "selected";}?> value="off">Off</option>
                             </select>
                             
                         </td>
                         
                         <td >
                            <input  class="form-control"  <?php if ($on_off=="off"){echo "readonly=''";}?> type="time" name="starttime[]" value="<?php echo $starttime;?>" required="">
                            
                        </td>
                        <td >
                         
                            <input class="form-control"  <?php if ($on_off=="off"){echo "readonly=''";}?> type="time" name="endtime[]" value="<?php echo $endtime;?>" required="">
                        </td>
                    </tr>
                    
                <?php }
            }?>
            
        </tbody>
    </table>
</div>
</div>
<div class="row">
    <div class="col-md-7">
       <div class="form-group">
         <label class="control-label col-md-3"></label>
         <div class="col-md-9">
          <button class="btn btn-info pull-right" name="update_staff_working_form_submit" type="submit">Aggiorna</button>
      </div>
  </div>
  
</div>
</div>

</form>
<?php }elseif ($current_tab=="breaks"){?>
 <form method="post" class="form-horizontal" action="" enctype="multipart/form-data">
   <div class="row">
    <div class="col-md-3">
       <div class="col-md-9 show_image_input">
         
         <?php
         if(file_exists(SERVER_ROOT.'/uploads/company/'.CURRENT_LOGIN_COMPANY_ID.'/users/'.$edit_staff_id.'/'.$staff_detail['user_photo_file']) && (($staff_detail['user_photo_file'])!=''))
            {?>
               <img class="img-circle img-lg" class="img-md" src="<?php echo SITE_URL.'/uploads/company/'.CURRENT_LOGIN_COMPANY_ID.'/users/'.$edit_staff_id.'/'.$staff_detail['user_photo_file'];?>">
           <?php } else{?>
              <img class="img-circle img-lg" src="<?php echo SITE_URL.'/assets/frontend/default_image/default_user_image.png';?>" alt="Profile Picture">
          <?php }?> 
      </div>
  </div>
  <div class="col-md-9">
    <h3>Breaks For <?php echo ucwords($staff_detail['firstname']." ".$staff_detail['lastname']);?></h3>
    <table class="table table-hover table-vcenter">
        <thead>
            <tr>
               <th width="25%">&nbsp;</th>
               <th width="15%">&nbsp;</th>
               <th width="30%">&nbsp;</th>
               <th width="30%">&nbsp;</th>
           </tr>
       </thead>
       <tbody>
          
        <?php $day_array=array('monday','tuesday','wednesday','thursday','friday','saturday','sunday');
        if (is_array($day_array)){
            foreach ($day_array as $als){
                $exist=$db->exists('staff_working_hours',array('staff_id'=>$edit_staff_id,'day'=>$als,'on_or_off'=>'on'));
                ?>
                <tr>
                    <td>
                        <span style="border-radius:50px;" class="<?php if ($exist){echo "btn btn-mint";}else{echo "btn btn-default";}?>"><?php echo ucfirst($als);?></span>
                    </td>
                    <td>
                      <?php if ($exist){?>
                          <button class="btn btn-success">Add Break</button>
                      <?php }else{?>
                          <button class="btn btn-default" disabled="disabled">Chiudi</button>
                      <?php }?>
                      
                  </td>
                  
                  <td >
                    
                   
                  </td>
                  <td >
                     
                     
                  </td>
              </tr>
              
          <?php }
      }?>
      
  </tbody>
</table>
</div>
</div>
<div class="row">
    <div class="col-md-7">
       <div class="form-group">
         <label class="control-label col-md-3"></label>
         <div class="col-md-9">
          <button class="btn btn-info btn-block pull-right" name="update_staff_working_form_submit" type="submit"><i class="fa fa-save"></i> Aggiorna</button>
      </div>
  </div>
  
</div>
</div>

</form>
<?php }elseif ($current_tab=="timeoff"){?>
 <form method="post" class="form-horizontal" action="" enctype="multipart/form-data">
   <div class="row">
    <div class="col-md-3">
       <div class="col-md-12 show_image_input">
         
         <?php
         if(file_exists(SERVER_ROOT.'/uploads/company/'.CURRENT_LOGIN_COMPANY_ID.'/users/'.$edit_staff_id.'/'.$staff_detail['user_photo_file']) && (($staff_detail['user_photo_file'])!=''))
            {?>
               <img class="img-circle img-lg" class="img-md" src="<?php echo SITE_URL.'/uploads/company/'.CURRENT_LOGIN_COMPANY_ID.'/users/'.$edit_staff_id.'/'.$staff_detail['user_photo_file'];?>">
           <?php } else{?>
              <img class="img-circle img-lg" src="<?php echo SITE_URL.'/assets/frontend/default_image/default_user_image.png';?>" alt="Profile Picture">
          <?php }?> 
      </div>
  </div>
  <div class="col-md-9">
    <h3>Permessi/Ferie per <?php echo ucwords($staff_detail['firstname']." ".$staff_detail['lastname']);?>
    <button   type="button" class="btn btn-info pull-right" data-toggle="modal" data-target="#myModal_timeoff"><i class="fa fa-plus"></i></button>
</h3>
<table class="table table-hover table-vcenter">
    <thead><tr>
        <th width="10%">&nbsp;</th>
        <th width="40%">&nbsp;</th>
        <th width="20%">&nbsp;</th>
        <th width="20%">&nbsp;</th>
        <th width="30%">&nbsp;</th>
    </tr>
</thead>
<tbody>
    <?php $timeoff=$db->get_all('timeoff',array('staff_id'=>$edit_staff_id));
    if (is_array($timeoff) && !empty($timeoff)){
        foreach ($timeoff as $tf){
         
            ?>
            <tr>
                <td><a class="btn btn-default btn-icon btn-circle icon-lg fa fa-calendar" ></a></td>
                <td><?php echo date('D M d,Y',strtotime($tf['start_date']));?> To 
                   <?php echo date('D M d,Y',strtotime($tf['end_date']));?><br>
                   <?php 
                   if ($tf['notes']!="")
                   {
                       echo ucwords($tf['notes']);
                   }
                   else{echo "No Description";}?></td>
                   <td>Nessuna ripetizione</td>
                   <td>Ogni giorno</td>
                   <td><a href="<?php echo $link->link("staff",user,'&sid='.$edit_staff_id.'&action_delete='.$tf['id']);?>"><i class="fa fa-trash  text-danger"></i></a></td>
               </tr>
           <?php }}else{?>
               <tr>
                <td colspan="5">Nessun permesso/ferie</td>
            </tr>
        <?php }?>
    </tbody>
</table>








</div>
</div>
</form>
<?php }elseif ($current_tab=="login_details"){?>
   <form method="post" class="form-horizontal" action="" enctype="multipart/form-data">
       <div class="row">
         <div class="col-md-3">
            <div class="form-group">
             <label class="control-label col-md-3"></label>
             <div class="col-md-9 show_image_input">
                 
                 <?php
                 if(file_exists(SERVER_ROOT.'/uploads/company/'.CURRENT_LOGIN_COMPANY_ID.'/users/'.$edit_staff_id.'/'.$staff_detail['user_photo_file']) && (($staff_detail['user_photo_file'])!=''))
                    {?>
                       <img class="img-circle img-lg" class="img-md" src="<?php echo SITE_URL.'/uploads/company/'.CURRENT_LOGIN_COMPANY_ID.'/users/'.$edit_staff_id.'/'.$staff_detail['user_photo_file'];?>">
                   <?php } else{?>
                      <img class="img-circle img-lg" src="<?php echo SITE_URL.'/assets/frontend/default_image/default_user_image.png';?>" alt="Profile Picture">
                  <?php }?> 
              </div>
          </div>
          
      </div>
      <div class="col-md-9">
        <h3>Dettagli di login di <?php echo ucwords($staff_detail['firstname']." ".$staff_detail['lastname']);?></h3>
        <div class="form-group">
         <label class="control-label col-md-3">Staff Login<font color="red">*</font></label>
         <div class="col-md-9">
           
            <div class="box-inline mar-rgt">
               
                <input <?php if ($staff_detail['staff_login']=="yes"){echo "checked";}?> class="show_related_fields" id="demo-sw-checkstate" type="checkbox"  name="staff_login" value="yes">
                
            </div>
        </div>
        
    </div> 
    
    <div class="form-group show_on_staff_login_yes" <?php if ($staff_detail['staff_login']=="no"){?>style="display:none;"<?php }?>>
     <label class="control-label col-md-3">Tipi di Accesso</label>
     <div class="col-md-9">
        <select class="form-control"name="access_controls" id="demo-sw-checkstate12">
          <option value="">Seleziona</option>
          <option <?php if ($staff_detail['user_type']=="staff"){echo "selected='selected'";}?>value="staff">Accesso Staff</option>
          <option <?php if ($staff_detail['user_type']=="receptionist"){echo "selected='selected'";}?> value="receptionist">Accesso Segretaria</option>
          <option <?php if ($staff_detail['staff_login']=="admin"){echo "selected='selected'";} ?> value="admin">Accesso Amministratore</option>
      </select>
      <p class="text-danger">Definisci il ruolo dello Staff</p>
  </div>
</div>



<div class="form-group">
 <label class="control-label col-md-3"></label>
 <div class="col-md-9">
  <button class="btn btn-block btn-info" name="update_staff_login_details_form_submit" type="submit"><i class="fa fa-save"></i> Aggiorna</button>
</div>
</div>

</div>


</div>



</form>
<?php }?>

</div>
</div>

</div>
</div>
</div>

