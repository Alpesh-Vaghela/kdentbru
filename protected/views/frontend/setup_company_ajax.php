<?php
//echo "bhangi";

if(isset($_POST['submit']))
{
    
    $user_id=$_POST['user_id'];
    $user_details=$db->get_row('users',array('user_id'=>$user_id));
    $default_plan_details=$db->get_row('plans',array('default'=>'1'));
    

    $company_name=$_POST['company_name'];
    $company_industry=$_POST['company_industry'];
    $company_phone=$_POST['company_phone'];
    $company_currencysymbol=$_POST['company_currencysymbol'];
    $company_date_format=$_POST['company_date_format'];
    $company_email=$_POST['company_email'];
    $day=serialize($_POST['day']);
    $on_or_off=serialize($_POST['on_or_off']);
    $starttime=serialize($_POST['starttime']);
    $company_timezone=$_POST['timezone'];
    $endtime=serialize($_POST['endtime']);
    $service_name=$_POST['service_name'];
    $service_cost=$_POST['service_cost'];
    $service_time=$_POST['service_time'];
    
    if ($company_email=='')
    {
        $company_email = $user_details['email'];
    }
    
    if ($company_date_format=='')
    {
        $company_date_format = SITE_DATE_FORMAT;
    }
    
    if ($company_currencysymbol=='')
    {
        $company_currencysymbol = SITE_CURRENCY;
    }
    if ($company_timezone=="")
    {
        $company_timezone= SITE_TIMEZONE;
    }
    
    
    
    if ($company_name=="")
    {
       $return['msg']='<div class="alert alert-danger text-danger ">
       <i class="fa fa-frown-o"></i>
       <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
       Oops! Enter business name.
       </div>';
       $return['error']=true;
       echo json_encode($return);
   }
   elseif ($company_phone=="")
   {
       $return['msg']='<div class="alert alert-danger text-danger ">
       <i class="fa fa-frown-o"></i>
       <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
       Oops! Enter phone no.
       </div>';
       $return['error']=true;
       echo json_encode($return);
   }
   elseif ($db->exists('company',array('company_name'=>$company_name)))
   {
    $return['msg']='<div class="alert alert-danger text-danger ">
    <i class="fa fa-frown-o"></i>
    <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
    Oops! Company name already exist!.
    </div>';
    $return['error']=true;
    echo json_encode($return);
}
elseif (!is_numeric($company_phone))
{
    $return['msg']='<div class="alert alert-danger text-danger ">
    <i class="fa fa-frown-o"></i>
    <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>
    Oops! Phone no should be numeric.
    </div>';
    $return['error']=true;
    echo json_encode($return);
}
else{
    $company_insert=$db->insert('company',array('unique_account_number'=>time(),
        'company_name'=>$company_name,
        'company_industry'=>$company_industry,
        'company_phone'=>$company_phone,
        'company_currencysymbol'=>$company_currencysymbol,
        'company_date_format'=>$company_date_format,
        'company_email'=>$company_email,
        'working_day'=>$day,
        'company_timezone'=>$company_timezone,
        'working_on_off'=>$on_or_off,
        'working_start_time'=>$starttime,
        'working_end_time'=>$endtime,
        'created_date'=>date('Y-m-d'),
        'ip_address'=>$_SERVER['REMOTE_ADDR']));
    

    $last_company_insert_id=$db->insert_id;


    $plan_insert=$db->insert("plans_company",array('company_id'=>$last_company_insert_id,
        'plan_id'=>$default_plan_details['id'],
        'plan_name'=>$default_plan_details['plan_name'],
        'allow_staff'=>$default_plan_details['allow_staff'],
        'created_date'=>date('Y-m-d'),
        'price'=>$default_plan_details['price'],
        'ip_address'=>$_SERVER['REMOTE_ADDR']));

    
    $plan_insert=$db->insert("plans_all",array('company_id'=>$last_company_insert_id,
        'plan_id'=>$default_plan_details['id'],
        'plan_name'=>$default_plan_details['plan_name'],
        'allow_staff'=>$default_plan_details['allow_staff'],
        'created_date'=>date('Y-m-d'),
        'price'=>$default_plan_details['price'],
        'ip_address'=>$_SERVER['REMOTE_ADDR']));


    $service_insert=$db->insert("services",array('company_id'=>$last_company_insert_id,
        'service_name'=>$service_name,
        'service_cost'=>$service_cost,
        'service_time'=>$service_time,
        'created_date'=>date('Y-m-d'),
        'visibility_status'=>'active',
        'private_service'=>'no',
        'service_color'=>'danger',
        'ip_address'=>$_SERVER['REMOTE_ADDR']));

    $last_service_insert_id=$db->insert_id;

    $assign_service_insert=$db->insert("assign_services",array('company_id'=>$last_company_insert_id,
        'staff_id'=>$user_id,
        'service_id'=>$last_service_insert_id,
        'created_date'=>date('Y-m-d'),
        'ip_address'=>$_SERVER['REMOTE_ADDR']));

    if ($company_insert){

     $update_insert=$db->update('users',array('company_id'=>$last_company_insert_id,
        'working_day'=>$day,
        'working_on_off'=>$on_or_off,
        'working_start_time'=>$starttime,
        'working_end_time'=>$endtime,
        'visibility_status'=>'active',),array('user_id'=>$user_id));
     
     $notification_settings_insert=$db->insert('notification_settings',array('company_id'=>$last_company_insert_id));
     $preferences_settings_insert=$db->insert('preferences_settings',array('company_id'=>$last_company_insert_id));
     /*********Create a folder with company id to hold company logo, users/staff images**********/
     $path = SERVER_ROOT.'/uploads/company/'.$last_company_insert_id.'/';
     if(!is_dir($path))
     {
        if(!file_exists($path)){
            mkdir($path);
        }
    }
    /*********Create a folder logo**********/
    $path = SERVER_ROOT.'/uploads/company/'.$last_company_insert_id.'/logo';
    if(!is_dir($path))
    {
        if(!file_exists($path)){
            mkdir($path);
        }
    }
    /*********Create a folder users**********/
    $path = SERVER_ROOT.'/uploads/company/'.$last_company_insert_id.'/users';
    if(!is_dir($path))
    {
        if(!file_exists($path)){
            mkdir($path);
        }
    }
    if ($update_insert)
    {
        $return['msg']='<div class="alert alert-success text-success">
        <i class="fa fa-smile-o"></i> <button class="close" data-dismiss="alert" type="button">
        <i class="fa fa-times-circle-o"></i></button> Company setup completed successfully.
        </div>';
        $return['error']=false;
        echo json_encode($return);
    }
}
}}



?>