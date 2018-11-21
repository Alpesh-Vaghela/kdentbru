<?php 
if(file_exists(SERVER_ROOT."/protected/setting/".Package."lock")){
    $session->redirect('home',user);
}
if(isset($_POST['submit_login']))
{
    $host_name=$_POST['host_name'];


    $db_name=$_POST['db_name'];
    $db_username=$_POST['db_username'];
    $db_pass=$_POST['db_pass'];
     if($host_name=='')
    {
        $display_msg='Host name cannot be empty.
		';
    }
    elseif($db_name=='')
    {
        $display_msg='Database Name cannot be empty.
		';
    }
    elseif($db_username=='')
    {
        $display_msg='Database Username cannot be empty.
		';
    }
    elseif($db_pass=='')
    {
        $display_msg='Database Password cannot be empty.
		';
    }

    /*elseif(! $feature->verifyPurchase('iwcn', '6logg8hm0tr4b2pzapyhdfz1hsluxcd4',
        $code,'7231211'))
        {
            $display_msg='Purchase Code Invalid
		';
        }*/
    else {
        $dbi = new db("mysql:host=" . $host_name . ";dbname=" . $db_name, $db_username, $db_pass);
        $dbdetails=array('hostname'=>$host_name,'dbname'=>$db_name,'dbuser'=>$db_username,'dbpass'=>$db_pass,'code'=>$code);


       $dbfile=file_get_contents(SERVER_ROOT.'/protected/setting/'.Package.'db.sql');
       $status=$dbi->run($dbfile);
           }
  if($status)
  {

      if(file_exists(SERVER_ROOT.'/protected/setting/tempdbdetails.txt'))
      {
          unlink(SERVER_ROOT.'/protected/setting/tempdbdetails.txt');

      }
      $filedb=fopen(SERVER_ROOT.'/protected/setting/tempdbdetails.txt', 'w');
      fwrite($filedb,serialize($dbdetails));
      fclose($filedb);
  $session->redirect('installation_final',user);
  }
}?>