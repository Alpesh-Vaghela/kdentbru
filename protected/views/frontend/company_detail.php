<?php


$current_tab=$_COOKIE['current_tab'];
if ($current_tab!="company_details" && $current_tab!="business_hours")
  {$current_tab="company_details";}

?>
<?php if (isset($_POST['update_company_detail_form_submit']))
{
    //print_r($_POST);
  $company_name=$_POST['company_name'];
  $company_email=$_POST['comapny_email'];
  $company_phone=$_POST['company_phone'];
  $company_website=$_POST['company_website'];
  $company_address=$_POST['company_address'];
  $company_state=$_POST['company_state'];
  $company_city=$_POST['company_city'];
  $company_zip=$_POST['company_zip'];
  $company_currencysymbol=$_POST['company_currencysymbol'];
   // $date_format=$_POST['dateformat'];
  $company_description=$_POST['company_description'];
  $logo = $_FILES['img'];
  $handle = new upload($_FILES['img']);
  $path = SERVER_ROOT.'/uploads/company/'.CURRENT_LOGIN_COMPANY_ID.'/logo';
  
  if (! is_dir($path)) {
    if (! file_exists($path)) {
      mkdir($path);
    }
  }
  
  $empt_fields = $fv->emptyfields(array('Company Name'=>$company_name,
    'Company Email'=>$company_email,
    'Company Phone'=>$company_phone,
    'Company Currency'=>$company_currencysymbol
    
  ));
  
  if ($empt_fields)
  {
    $display_msg= '<div class="alert alert-danger text-danger">
    <i class="fa fa-frown-o"></i> <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
    Oops! Following fields are empty<br>'.$empt_fields.'</div>';
  }

  elseif (!$fv->check_email($company_email))
  {
    $display_msg= '<div class="alert alert-danger text-danger">
    <i class="fa fa-frown-o"></i> <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
    Oops! Wrong Email Format.
    </div>';
  }
  elseif(($logo['name']) != '')
  {
    if(file_exists(SERVER_ROOT.'/uploads/company/'.CURRENT_LOGIN_COMPANY_ID.'/logo/'.COMPANY_LOGO) && ((COMPANY_LOGO)!=''))
    {
      unlink(SERVER_ROOT.'/uploads/company/'.CURRENT_LOGIN_COMPANY_ID.'/logo/'.COMPANY_LOGO);
      
    }
    $newfilename = $handle->file_new_name_body=time();
    $ext = $handle->image_src_type;
    $filename = $newfilename.'.'.$ext;
    
    
    if ($handle->image_src_type == 'jpg' || $handle->image_src_type == 'jpeg' || $handle->image_src_type == 'JPEG' || $handle->image_src_type == 'png' || $handle->image_src_type == 'JPG')
    {
      
      
      if ($handle->uploaded)
      {
        
        $handle->Process($path);
        if ($handle->processed)
        {
          $update=$db->update('company',array('company_name'=>ucwords(trim($company_name)),
            'company_email'=>$company_email,
            'company_phone'=>$company_phone,
            'company_website'=>$company_website,
            'company_address'=>htmlentities($company_address),
            'company_state'=>$company_state,
            'company_city'=>$company_city,
            'company_zip'=>$company_zip,
            'company_logo'=>$filename,
            'company_currencysymbol'=>$company_currencysymbol,
                                                   // 'company_date_format'=>$date_format,
            'company_description'=>htmlentities($company_description))
          ,array('id'=>CURRENT_LOGIN_COMPANY_ID));
        }
      }
    }
  }
  else {
    $update=$db->update('company',array('company_name'=>ucwords(trim($company_name)),
      'company_email'=>$company_email,
      'company_phone'=>$company_phone,
      'company_website'=>$company_website,
      'company_address'=>htmlentities($company_address),
      'company_state'=>$company_state,
      'company_city'=>$company_city,
      'company_zip'=>$company_zip,
      'company_currencysymbol'=>$company_currencysymbol,
                                           // 'company_date_format'=>$date_format,
      'company_description'=>htmlentities($company_description))
    ,array('id'=>CURRENT_LOGIN_COMPANY_ID));
  }
  
  
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
     window.location = '".$link->link("company_detail",frontend)."'
   },3000);</script>";
 }
 
 
}
elseif (isset($_POST['update_company_working_form_submit']))
{
    //print_r($_POST);
  $day=serialize($_POST['day']);
  $on_or_off=serialize($_POST['on_or_off']);
  $starttime=serialize($_POST['starttime']);
  $company_timezone=$_POST['timezone'];
  $endtime=serialize($_POST['endtime']);
  
  $update=$db->update('company',array('working_day'=>$day,
    'working_on_off'=>$on_or_off,
    'working_start_time'=>$starttime,'company_timezone'=>$company_timezone,
    'working_end_time'=>$endtime)
  ,array('id'=>CURRENT_LOGIN_COMPANY_ID));
  
  
  
  if ($update)
  {
    $update=$db->update('users',array('working_day'=>$day,
      'working_on_off'=>$on_or_off,
      'working_start_time'=>$starttime,
      'working_end_time'=>$endtime)
    ,array('company_id'=>CURRENT_LOGIN_COMPANY_ID));
    $display_msg='<div class="alert alert-success text-success">
    <i class="fa fa-smile-o"></i>
    <button class="close" data-dismiss="alert" type="button">
    <i class="fa fa-times-circle-o"></i></button>
    Success! Data Updated.
    </div>';
    
    echo "<script>
    setTimeout(function(){
     window.location = '".$link->link("company_detail",frontend)."'
   },3000);</script>";
 }
}?>



<div id="page-content">
  <div class="row">
    <div class="col-lg-12">
      <?php echo $display_msg;?>
      <!--Stacked Tabs Left-->
      <!--===================================================-->
      <div class="tab-base tab-stacked-left">
        <!--Nav tabs-->
        <ul class="nav nav-tabs">
          <li tab="company_details"  class="set_cookie <?php if ($current_tab=='company_details'){echo 'active';}?>">
            <a data-toggle="tab" href="#demo-stk-lft-tab-1" aria-expanded="false"><i class="fa fa-building-o"></i> Company details</a>
          </li>
          <li tab="business_hours"  class="set_cookie <?php if ($current_tab=='business_hours'){echo 'active';}?>">
            <a data-toggle="tab" href="#demo-stk-lft-tab-2" aria-expanded="false"><i class="fa fa-clock-o"></i> Business hours</a>
          </li>
                                       <!--  <li tab="customization_notification"  class="set_cookie <?php if ($current_tab=='customization_notification'){echo 'active';}?>">
                                            <a data-toggle="tab" href="#demo-stk-lft-tab-3" aria-expanded="true">Customization</a>
                                        </li>
                                        <li tab="activity_alert_notification"  class="set_cookie <?php if ($current_tab=='activity_alert_notification'){echo 'active';}?>">
                                            <a data-toggle="tab" href="#demo-stk-lft-tab-4" aria-expanded="true">Activity Alerts</a>
                                          </li> -->
                                        </ul>
                                        <!--Tabs Content-->
                                        <div class="tab-content">
                                          <?php if ($current_tab=='company_details'){?>
                                            <h4 class="text-thin">Configure Your Setmore Booking Page</h4>
                                            <form method="post" class="form-horizontal" action="<?php $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
                                              <div class="panel-body">
 <!-- <div class="row">

 <div class="col-md-12">
  <div class="form-group">
            <label class="control-label col-md-4">Your Booking Page URL</label>
            <div class="col-md-8">
              <?php echo $link->link('company_booking_page',frontend,'&bookingfor='.$feature->encryptIt( CURRENT_LOGIN_COMPANY_ID ));?>
            </div>
          </div>
 </div> 
</div> --> 
<div class="row">

 <div class="col-md-12">
  <div class="form-group">
    <label class="control-label col-md-4">Your Booking Page URL</label>
    <div class="col-md-8">
      <?php echo SITE_URL.'/company_booking_page_calendar.php?bookingfor='.base64_encode(CURRENT_LOGIN_COMPANY_ID.'_'.COMPANY_NAME ).'';?>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-md-4"></label>
    <div class="col-md-8">OR
    </div>
  </div>
  
  <div class="form-group"> 
    <label class="control-label col-md-4"></label>
    <div class="col-md-8">
      <textarea rows="10" cols="" class="form-control">
        <script id="setmore_script" type="text/javascript" src="<?php echo SITE_URL.'/assets/frontend/iframe/booking_iframe.js'?>"></script>
        <a id="Setmore_button_iframe" style="float:none" href="<?php echo SITE_URL.'/company_booking_page_calendar.php?bookingfor='.base64_encode(CURRENT_LOGIN_COMPANY_ID.'_'.COMPANY_NAME ).'';?>">
          <img border="none" src="<?php echo SITE_URL.'/assets/frontend/img/appointment-book-button.png'?>" alt="Book an appointment with <?php echo COMPANY_NAME;?>" />
        </a> 
      </textarea>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-md-4">Company-Name</label>
    <div class="col-md-8">
      <input class="form-control" placeholder="Company Name"  name="company_name" type="text" value="<?php echo COMPANY_NAME;?>">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-md-4">Company-Email</label>
    <div class="col-md-8">
      <input class="form-control" placeholder="Email"  name="comapny_email" type="text" value="<?php echo COMPANY_EMAIL;?>">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-md-4">Company Logo</label>
    <div class="col-md-4">
      <?php if(file_exists(SERVER_ROOT.'/uploads/company/'.CURRENT_LOGIN_COMPANY_ID.'/logo/'.COMPANY_LOGO) && ((COMPANY_LOGO)!=''))
      { ?>
        <img src="<?php echo SITE_URL.'/uploads/company/'.CURRENT_LOGIN_COMPANY_ID.'/logo/'.COMPANY_LOGO;?>" width="50%">
      <?php } else{?>
       <img src="//www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image"  width="50%">
     <?php } ?>
     <br>
     <br>
     <input type="file" name="img">
     <small>Only jpg , png & jpeg  (Max : <?php echo $upload_max_size;?>)</small>
   </div>
 </div>
 <div class="form-group">
   <label class="control-label col-md-4">Phone</label>
   <div class="col-md-8">
    <input class="form-control" placeholder="Phone"  name="company_phone" type="text" value="<?php echo COMPANY_PHONE;?>">
  </div>
</div>
<div class="form-group">
 <label class="control-label col-md-4">Company-Website</label>
 <div class="col-md-8">
  <input class="form-control" placeholder="Website" type="text" name="company_website" value="<?php echo COMPANY_WEBSITE;?>">
</div></div>
<div class="form-group">
 <label class="control-label col-md-4">Address</label>
 <div class="col-md-8">
  <textarea class="form-control" placeholder="Address" name="company_address"><?php echo html_entity_decode(COMPANY_ADDRESS);?>
</textarea>
</div>
</div>


<div class="form-group">
 <label class="control-label col-md-4"></label>
 <div class="col-md-3">
  <input class="form-control" placeholder="state" name="company_state" type="text" value="<?php echo COMPANY_STATE;?>">
</div>
<div class="col-md-3">
 <input class="form-control" placeholder="city" name="company_city" type="text" value="<?php echo COMPANY_CITY;?>">
</div>
<div class="col-md-2">
  <input class="form-control" placeholder="Zip"  name="company_zip" type="text" value="<?php echo COMPANY_ZIP;?>">
</div>
</div>


<div class="form-group">
  <label class="control-label col-md-4">Currency symbol</label>
  <div class="col-md-8">
    <input class="form-control" name="company_currencysymbol" type="text" value="<?php echo CURRENCY;?>" >
  </div>
</div>
           <!--    <div class="form-group">
              <input type="hidden" name="date_format" id="date_format" value="<?php echo DATE_FORMAT;?>">
                   <label class="control-label col-md-4">Date Format</label>
                  <div class="col-md-8">
             <select class="form-control" name="dateformat" id="dateformat">
                     <option <?php if (DATE_FORMAT=="d/m/Y")echo 'selected="selected"';?> value="d-m-Y">dd/mm/yyyy</option>
                     <option <?php if (DATE_FORMAT=="Y/m/d")echo 'selected="selected"';?> value="Y-m-d">yyyy/mm/dd</option>
                     <option <?php if (DATE_FORMAT=="m/d/Y")echo 'selected="selected"';?> value="m-d-Y">mm/dd/yyyy</option>
                     <option <?php if (DATE_FORMAT=="d-m-Y")echo 'selected="selected"';?> value="d-m-Y">dd-mm-yyyy</option>
                     <option <?php if (DATE_FORMAT=="Y-m-d")echo 'selected="selected"';?> value="Y-m-d">yyyy-mm-dd</option>
                     <option <?php if (DATE_FORMAT=="m-d-Y")echo 'selected="selected"';?> value="m-d-Y">mm-dd-yyyy</option>
                     <option <?php if (DATE_FORMAT=="d-M-Y")echo 'selected="selected"';?> value="d-M-Y">dd-MM-yyyy  (Ex.<?php echo date('d-M-Y');?>)</option>
              </select></div>
            </div>--> 
            <div class="form-group">
             <label class="control-label col-md-4">About You</label>
             <div class="col-md-8">
              <textarea class="form-control" placeholder="Company Description" name="company_description"><?php echo html_entity_decode($common_data_company_setting['company_description']);?>
            </textarea>
          </div>
        </div>
        
      </div>
    </div></div>
    
    <div class="panel-footer text-right">
      
      <div class="form-group">
        <label class="control-label col-md-4"> </label>
        <div class="col-md-8">
          <button class="btn btn-block btn-info" type="submit" name="update_company_detail_form_submit"><i class="fa fa-save"></i> Update</button>
        </div>
      </div>
      
      
    </div>
    
  </form>
  
  
<?php }elseif ($current_tab=='business_hours'){?>
 
  <h4 class="text-thin">Business Operating Hours</h4>
  
  <form method="post" class="form-horizontal" action="" enctype="multipart/form-data">
   <div class="form-group">
    <input type="hidden" name="db_timezone" id="db_timezone" value="<?php echo $settings['timezone'];?>">
    <label class="control-label col-md-3">Time Zone</label>
    <div class="col-md-4">
      <select class="form-control" name="timezone" id="timezone">
        <?php
        $timezones=$feature->get_timezones();
        if(is_array($timezones)) foreach ($timezones as $key=>$value){?>
          <option value="<?php echo $value['zone'];?>" <?php if(TIMEZONE==$value['zone'])echo "selected";?>><?php echo $value['zone']." ( ".$value['diff_from_GMT']." )";?></option>
        <?php }?>
      </select>
    </div>
  </div> 
  <div class="row">
   
    <div class="col-md-12">
      
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
      $working_day=unserialize($common_data_company_setting['working_day']);
      $working_on_off=unserialize($common_data_company_setting['working_on_off']);
      $working_start_time=unserialize($common_data_company_setting['working_start_time']);
      $working_end_time=unserialize($common_data_company_setting['working_end_time']);
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
              <input  class="form-control"  <?php if ($on_off=="off"){echo "readonly1=''";}?> type="time" name="starttime[]" value="<?php echo $starttime;?>" required="">
              
            </td>
            <td >
             
              <input class="form-control border-danger"  <?php if ($on_off=="off"){echo "readonly1=''";}?> type="time" name="endtime[]" value="<?php echo $endtime;?>" required="">
            </td>
          </tr>
          
        <?php }
      }?>
      
    </tbody>
  </table>
</div>
</div>

<div class="form-group">
 <label class="control-label col-md-3"></label>
 <div class="col-md-9">
  <button class="btn btn-info btn-block pull-right" name="update_company_working_form_submit" type="submit"><i class="fa fa-save"></i> Update</button>
</div>
</div>


</form>

<?php }elseif ($current_tab=='activity_alert_notification'){
  
 ?>
 <h4 class="text-thin">Customize Your Activity Alerts</h4>
 <hr>
 
 
<?php }?>
</div>
</div>
<!--===================================================-->
<!--End Stacked Tabs Left-->
</div>

</div>
</div>