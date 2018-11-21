<?php
echo"";
if(isset($_POST[submit_changepassword]))
{
	$oldpassword=$_POST['oldpassword'];
	$pass=$_POST['newpassword'];
	$confirmpassword=$_POST['confirmpassword'];
    $verify_pass=$password->verify($oldpassword,$user_details['password'],PASSWORD_DEFAULT);
   if(!$verify_pass)
    {
	$display_msg='<div class="alert alert-danger  text-danger">
	<i class="fa fa-frown-o"></i> <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle"></i></button>Alert! Wrong Old Password.
	</div>';
    }
   elseif($fv->emptyfields(array(password=>$oldpassword),NULL))
	{
		$display_msg= '<div class="alert alert-danger  text-danger">
		<i class="fa fa-frown-o"></i> <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle"></i></button>Oops! OldPassword Field Is Empty.
		</div>';
	}
	elseif($fv->emptyfields(array(password=>$pass),NULL))
	{
		$display_msg= '<div class="alert alert-danger  text-danger">
		<i class="fa fa-frown-o"></i> <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle"></i></button>Oops! NewPassword Field Is Empty.
		</div>';
	}
	elseif($pass!=$confirmpassword)
	{
		$display_msg= '<div class="alert alert-danger  text-danger">
		<i class="fa fa-frown-o"></i> <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle"></i></button>Oops! Password Not Match.
		</div>';
	}
	else
	{
		$encrypt_password = $password->hashBcrypt( $pass, '10', PASSWORD_DEFAULT) ;
		$update=$db->update('users',array('password'=>$encrypt_password),array('user_id'=>$_SESSION['user_id']));
		/*entry in activity log table*/
	/*	$event="Change password";
		$db->insert('activity_logs',array('user_id'=>$_SESSION['user_id'],
		    'event'=>$event,
		    'created_date'=>date('Y-m-d'),
		    'ip_address'=>$_SERVER['REMOTE_ADDR']

		));*/
	}
	if($update)
	{ 
		$display_msg='<div class="alert alert-success text-success">
                		<i class="fa fa-smile-o"></i> <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle"></i></button>
                		    Success! Password Has Changed.
                		</div>';
	}
}
?>