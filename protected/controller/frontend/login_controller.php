<?php
if($session->Check()){
    $session->redirect('home',user);
}
else {

    $setting = $db->get_row('settings');
if(isset($_COOKIE['remember_me']) && ($_COOKIE['remember_me']!=''))
{
    $cookie=explode('___',$_COOKIE['remember_me']);
    $session->Open();
   if(isset($_SESSION) )
   {
   $_SESSION ['email'] = $cookie['0'];
   $_SESSION['user_id'] = $cookie['1'];
   $_SESSION['user_type'] = $cookie['2'];
   $session->redirect('home',user);
    }
}
if(isset($_POST['submit_login']))
{
	$email=$_POST['email'];
	$pass=$_POST['password'];
    $cookie_set=$_POST['cookie_set'];
 
	if($email=='')
	{
		$display_msg='<div class="alert alert-danger text-danger">
		<i class="fa fa-frown-o"></i> <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>Goshh! Email Cannot Be Empty.
		</div>';
	}
	elseif(!filter_var($email,FILTER_VALIDATE_EMAIL))
	{
		$display_msg='<div class="alert alert-danger text-danger">
		<i class="fa fa-frown-o"></i> <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>Oopes! Enter a valid email.
		</div>';
	}
	elseif($pass=='' )
	{
		$display_msg='<div class="alert alert-danger text-danger">
		<i class="fa fa-frown-o"></i> 
		    <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle-o"></i></button>Oopes! Password Cannot be empty.
		</div>';
	}

	else
    {
		$query=$db->get_row('users',array('email'=>$email));
	if(is_array($query))
	{
		$verify_pass=$password->verify($pass,$query['password'],PASSWORD_DEFAULT);
		if(!$verify_pass)
		{
			$display_msg='<div class="alert alert-danger text-danger">
		<i class="fa fa-frown-o"></i> <button class="close fa fa-times-circle" data-dismiss="alert" type="button"></button>
			    Oh! Wrong Password.
		</div>';
		}
		else
		{
		    if ($query['staff_login']=="yes")
		    {
                		    if ($query['company_id']!=0 && $query['company_id']!="")
                		     {
                            			$session->Open();
                            			if(isset($_SESSION))
                            			{
                            				$_SESSION ['email'] = $query['email'];
                            				$_SESSION['user_id'] = $query['user_id'];
                            				$_SESSION['user_type'] = $query['user_type'];
                            
                            				if($cookie_set=='true' && $setting['cookie_expire']!=0)
                            				{
                            				$expire=time()+ 60*60*24*$setting['cookie_expire'];
                            				setcookie('remember_me',$query['email']."___".$query['user_id']."___".$query['user_type'],$expire);
                            				}
                            
                            			 // entry in activity log table
                            				$event="<b>Login</b> " . ucfirst($query['firstname']) . " " . ucfirst($query['lastname'])." login successfully ";
                            				$db->insert('activity_logs',array('user_id'=>$_SESSION['user_id'],
                            				                                  'event'=>$event,
                            				                                  'event_type'=>'login',
                            				                                  'company_id'=>$query['company_id'],
                            				                                  'created_date'=>date('Y-m-d'),
                            				                                  'ip_address'=>$_SERVER['REMOTE_ADDR']));
                                           if ($_SESSION['user_type']=="admin")
                                           {
                            				$session->redirect('home',frontend);
                                           }
                                           else{
                                               $session->redirect('calendar',frontend);
                                           }  
                            			}
                		}
                		else
                		{
                		  $session->redirect('setup_company&new_company='.$query['user_id'],frontend);  
                		}
		    }else{
		        $display_msg='<div class="alert alert-danger text-danger">
                        		<i class="fa fa-frown-o"></i> <button class="close fa fa-times-circle" data-dismiss="alert" type="button"></button>
                        			    Oh! You do not have permission to login.
                        		</div>';
		    }
}

	}
	else
	{
	    $display_msg='<div class="alert alert-danger text-danger">
		<i class="fa fa-frown-o"></i> <button class="close fa fa-times-circle" data-dismiss="alert" type="button"></button>
	        No Record Found !
		</div>';
	    
	    
	}

}
}
}
?>