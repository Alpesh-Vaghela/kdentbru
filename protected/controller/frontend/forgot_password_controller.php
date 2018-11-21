<?php
$exists=0;
if($session->Check()){
    $session->redirect('home',user);
}
$setting = $db->get_row('settings');
if(isset($_POST['change_pass']))
{
    $exists=1;
    $enc=$_POST['token'];
    $pass=$_POST['password'];
    $retypepassword=$_POST['retypepassword'];
    if($pass=='')
    {
        $display_msg = '<div class="alert alert-danger text-danger">
	                      <i class="fa  fa-frown-o"></i> <button class="close" data-dismiss="alert" type="button">
        <i class="fa fa-times-circle"></i></button>
					     <b>Alert ! </b>Please Enter Password.
		               </div>';
    }
    elseif ($retypepassword=='')
    {
        $display_msg = '<div class="alert alert-danger text-danger">
	                      <i class="fa  fa-frown-o"></i> <button class="close" data-dismiss="alert" type="button">
        <i class="fa fa-times-circle"></i></button>
					     <b>Alert ! </b>Please Enter Retype Password.
		               </div>';
    }
    elseif ($pass!=$retypepassword)
    {
        $display_msg = '<div class="alert alert-danger text-danger">
	                      <i class="fa  fa-frown-o"></i> <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle"></i></button>
					     <b>Oops ! </b>Passwords do not match.
		               </div>';
    }
    else{
    $encrypt_password = $password->hashBcrypt( $pass, '10', PASSWORD_DEFAULT) ;
    $update=$db->update('users',array('password'=>$encrypt_password,'random'=>0),array('random'=>$enc));

    }
    if($update)
    {
        $display_msg = '<div class="alert alert-success text-success">
	                      <i class="lnr lnr-smile"></i> <button class="close" data-dismiss="alert" type="button">
        <i class="fa fa-times-circle"></i></button>
					     Password Changed Successfully ! Try Login Now
		               </div>';
    }


}
elseif(isset($_REQUEST['random']) && $_REQUEST['random']!='')
{

    $enc=$_REQUEST['random'];
    if(!$db->exists('users',array('random'=>$_REQUEST['random'])))
    {

    $exists = 0;
    $display_msg = '<div class="alert alert-danger text-danger">
	                      <i class="fa  fa-frown-o"></i> <button class="close" data-dismiss="alert" type="button">
        <i class="fa fa-times-circle"></i></button>
					     <b>Alert ! </b>Token Invalid
		               </div>';

    }
    else
    {
        $exists=1;
    }

}

elseif(isset($_POST['forgot_pass']))
{
  
	$forgot_email = $fv->removespace($_POST['email']);
	if($fv->emptyfields(array('email'=>$forgot_email)))
	{
		$display_msg = '<div class="alert alert-danger text-danger">
	                      <i class="fa  fa-frown-o"></i> <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle"></i></button>
					     <b>Alert ! </b>Email cannot empty.
		               </div>';
	}
	elseif (!$fv->check_email($forgot_email))
	{
		$display_msg = '<div class="alert alert-danger text-danger">
	                      <i class="fa  fa-frown-o"></i> <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle"></i></button>
					     <b>Alert ! </b>Enter valid email.
		               </div>';
	}
	elseif(!$db->exists('users', array ('email' => $forgot_email)))
	{


			$display_msg = '<div class="alert alert-danger text-danger">
	                      <i class="fa  fa-frown-o"></i> <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle"></i></button>
					      <b>Alert ! </b>Email does not exist.
		               </div>';
	     }
		else
		{

		    /*$pass="admin";
		    $encrypt_password = $password->hashBcrypt( $pass, '10', PASSWORD_DEFAULT) ;
		    $db->update ('users',array('password'=>$encrypt_password),array('email'=>$forgot_email));
            */
		$enc=$feature->encrypt(time()); 
		$db->update ('users',array('random'=>$enc),array('email'=>$forgot_email));

		/*entry in activity log table*/
	/*	$event="Apply for new password by forgot password";
		$db->insert('activity_logs',array('user_id'=>$_SESSION['user_id'],
		    'event'=>$event,
		    'created_date'=>date('Y-m-d'),
		    'ip_address'=>$_SERVER['REMOTE_ADDR']

		));*/


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
    You have requested for a password reset. Please click on the link or copy and paste the link in browser to proceed.<br><br>

											Password Reset Link : '. SITE_URL . '/index.php?user=forgot_password&random='.$enc.'<br>

											<br /><br><br>Regards<br><br>
											'. $setting[name] .'<br>
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
$headers .= 'From: '.$setting[name] .'<'.$setting[email] . ">\r\n" .
'Reply-To: '.$setting[email] . "\r\n" .
'X-Mailer: PHP/' . phpversion();

		$confirm    =  mail($forgot_email, 'Forgot Password Request',$email_body,$headers);



		if($confirm=='1')
		 {
		 $display_msg = '<div class="alert alert-success text-success">
		 <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle"></i></button>
		 Mail sent to your email.
		 </div>';
		 }
		 else
		 {
		 $display_msg = '<div class="alert alert-danger text-danger">
		 <button class="close" data-dismiss="alert" type="button"><i class="fa fa-times-circle"></i></button>
		 <i class="fa  fa-frown-o"></i> Ooops! Something went wrong .
		 </div>';
		 }

			}

	}
?>
