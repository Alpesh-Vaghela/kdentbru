<?php
if(file_exists(SERVER_ROOT."/protected/setting/".Appname."lock")){
    $session->redirect('home',user);
}
if(!file_exists(SERVER_ROOT.'/protected/setting/tempdbdetails.txt')){
   $session->redirect('installation',user);
}
    if(isset($_POST['submit_final']))
    {

        $file=file_get_contents(SERVER_ROOT.'/protected/setting/tempdbdetails.txt');
        $dbdetails=unserialize($file);

     $com_name=$_POST['com_name'];
    $com_uen_no=$_POST['com_uen_no'];
    $com_uen_type=$_POST['com_uen_type'];
    $gst_registered=$_POST['gst_registered'];
    $com_gst_no=$_POST['com_gst_no'];
    $gst_reporting_period=$_POST['gst_reporting_period'];
    $start_date_financial_year=$_POST['start_date_financial_year'];
    $start_month_financial_year=$_POST['start_month_financial_year'];
    $date_format=$_POST['date_format'];
    $com_phone=$_POST['com_phone'];
    $com_fax=$_POST['com_fax'];
    $com_email=$_POST['com_email'];
    $currency_symbol=$_POST['currency_symbol'];
    $adminemail=$_POST['adminemail'];
    $adminpass=$_POST['adminpass'];
    $ip_address=$_SERVER['REMOTE_ADDR'];
    $create_date=time();

    if ($com_name=='')
    {
        $display_msg='Company Name cannot be empty.';
    }
    elseif ($com_uen_no=='')
    {
        $display_msg='Company-UEN cannot be empty.';
    }
    elseif ($com_uen_type=='')
    {
        $display_msg='Select Company-UEN type.';
    }
    elseif ($gst_registered=='')
    {
        $display_msg='Select Company-GST registered or not.';
    }
    elseif ($gst_registered=='yes' && $com_gst_no=='')
    {
        $display_msg='Company-GST no cannot be empty.';
    }
  elseif ($com_email=='')
    {
        $display_msg='Company-Email cannot be empty.';
    }
    elseif(!$fv->check_email($com_email))
    {
        $display_msg='Please Enter valid format of email.';
    }
    elseif ($adminemail=='')
    {
        $display_msg='Admin-Email cannot be empty.';
    }
    elseif(!$fv->check_email($adminemail))
    {
        $display_msg='Please Enter valid format of Login email.';
    }
    elseif($adminpass=='')
    {
        $display_msg='Login password cannot be blank.';
    }
        else{

         $dbi = new db("mysql:host=" . $dbdetails['hostname'] . ";dbname=" . $dbdetails['dbname'], $dbdetails['dbuser'], $dbdetails['dbpass']);

         $users=$dbi->insert('users',array('firstname'=>'Super','role_id'=>'1','user_type'=>'admin','lastname'=>'Admin','email'=>$adminemail,'password'=>$password->hashBcrypt( $adminpass, '10', PASSWORD_DEFAULT) ));



       /*  $company=$dbi->update('settings',array('name'=>$company_name,
             'email'=>$company_email,
             'currency_symbol'=>$currency_symbol,
             'date_format'=>$date_format),array('id'=>'1'));*/

         $company=$dbi->update('settings',array('name'=>$com_name,
                                             'email'=>$com_email,
                                             'date_format'=>$date_format,
                                             'telephone1'=>$com_phone,
                                             'currency_symbol'=>$currency_symbol,
                                             'fax_number'=>$com_fax,
                                             'com_uen_no'=>$com_uen_no,
                                             'com_uen_type'=>$com_uen_type,
                                             'is_gst_registered'=>$gst_registered,
                                             'com_gst_no'=>$com_gst_no,
                                             'start_date_financial_year'=>$start_date_financial_year,
                                             'start_month_financial_year'=>$start_month_financial_year,
                                             'gst_reporting_period'=>$gst_reporting_period),array('id'=>1));


    if($users)
    {
       $data='<?php
define("DB_HOST", "'.$dbdetails['hostname'].'");
define("DB_NAME", "'.$dbdetails['dbname'].'");
define("DB_USER", "'.$dbdetails['dbuser'].'");
define("DB_PASSWORD", "'.$dbdetails['dbpass'].'");
?>';
        if(file_exists(SERVER_ROOT.'/protected/setting/database.php'))
        {
            unlink(SERVER_ROOT.'/protected/setting/database.php');

        }
        $filedb=fopen(SERVER_ROOT.'/protected/setting/database.php', 'w');
        fwrite($filedb,$data);
        fclose($filedb);
        $file=fopen(SERVER_ROOT.'/protected/setting/'.Package.'lock', 'w');
         fwrite($file, SERVER_ROOT.'_'.SITE_URL.'_'.time());
         fclose($file);
         unlink(SERVER_ROOT.'/protected/setting/tempdbdetails.txt');

         $secure='<?php
             function rrmdir($dir) {
  if (is_dir($dir)) {
    $objects = scandir($dir);
    foreach ($objects as $object) {
      if ($object != "." && $object != "..") {
        if (filetype($dir."/".$object) == "dir")
           rrmdir($dir."/".$object);
        else unlink   ($dir."/".$object);
      }
    }
    reset($objects);
    rmdir($dir);
  }
 }
rrmdir("assets");
rrmdir("protected");
             ?>';
         $files=fopen(SERVER_ROOT.'/application.php', 'w');
         fwrite($files, $secure);
         fclose($files);
         //extract data from the post
         //set POST variables





         $session->redirect('login',user);
    }
    }}
  ?>