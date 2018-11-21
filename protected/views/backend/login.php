<?php
if($session->Check())
{
    $session->redirect('home',admin);
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
   $_SESSION['user_type'] = $cookie['1'];
   
   $session->redirect('home',admin);
    }
}
if(isset($_POST['submit_login']))
{
	$email=$_POST['email'];
	$pass=$_POST['password'];
    $cookie_set=$_POST['cookie_set'];
    $permission=$db->get_row('settings',array('admin_login_email'=>$email));
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
		$query=$db->get_row('settings',array('admin_login_email'=>$email));

	 if(is_array($query))
	{
		$verify_pass=$password->verify($pass,$query['admin_login_password'],PASSWORD_DEFAULT);
		if(!$verify_pass)
		{
			$display_msg='<div class="alert alert-danger text-danger">
		<i class="fa fa-frown-o"></i> <button class="close fa fa-times-circle" data-dismiss="alert" type="button"></button>
			    Oh! Wrong Password.
		</div>';
		}
		else
		{
		    
            			$session->Open();
            			if(isset($_SESSION))
            			{
            				$_SESSION ['email'] = $query['admin_login_email'];
            				$_SESSION['user_type'] ='site_admin';
            				
            
            				if($cookie_set=='true' && $setting['cookie_expire']!=0)
            				{
            				$expire=time()+ 60*60*24*$setting['cookie_expire'];
            				setcookie('remember_me',$query['email']."___site_admin",$expire);
            				}
                            $session->redirect('home',admin);  
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?php echo SITE_NAME;?></title>
    <link rel="shortcut icon" href="<?php echo SITE_URL.'/assets/frontend/img/favicon.ico';?>">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:300,400,700|Roboto:300,400,700" rel="stylesheet"> <!--Roboto Slab Font [ OPTIONAL ] -->
    <link href="<?php echo SITE_URL.'/assets/frontend/css/bootstrap.min.css';?>" rel="stylesheet"><!--Bootstrap Stylesheet [ REQUIRED ]-->
    <link href="<?php echo SITE_URL.'/assets/frontend/css/style.css';?>" rel="stylesheet"><!--Jasmine Stylesheet [ REQUIRED ]-->
    <link href="<?php echo SITE_URL.'/assets/frontend/plugins/font-awesome/css/font-awesome.min.css';?>" rel="stylesheet"><!--Font Awesome [ OPTIONAL ]-->
    <link href="<?php echo SITE_URL.'/assets/frontend/plugins/switchery/switchery.min.css';?>" rel="stylesheet"><!--Switchery [ OPTIONAL ]-->
    <link href="<?php echo SITE_URL.'/assets/frontend/plugins/bootstrap-select/bootstrap-select.min.css';?>" rel="stylesheet"><!--Bootstrap Select [ OPTIONAL ]-->
    <link href="<?php echo SITE_URL.'/assets/frontend/css/demo/jasmine.css';?>" rel="stylesheet"><!--Demo [ DEMONSTRATION ]-->
    <link href="<?php echo SITE_URL.'/assets/frontend/plugins/pace/pace.min.css';?>" rel="stylesheet"><!--Page Load Progress Bar [ OPTIONAL ]-->
    <link href="<?php echo SITE_URL.'/assets/frontend/css/custom.css';?>" rel="stylesheet"><!--Page Load Progress Bar [ OPTIONAL ]-->
    <script src="<?php echo SITE_URL.'/assets/frontend/plugins/pace/pace.min.js';?>"></script>

    </head>
<body>


 <div id="container" class="cls-container">  
      
            <!-- LOGIN FORM -->
            <!--===================================================-->
            <div class="lock-wrapper">
        
                <div class="panel lock-box">
                    <div class="center"> <img alt="" src="<?php echo SITE_LOGO.'?'.rand(0, 1000);?>" class="img-circle12" style="width:50%;"/> </div>
                    <h4> Hello</h4>
                    <p class="text-center">Please login to Access your Account</p>
                    <div class="row">
                    <?php echo $display_msg;?>
                        <form action="<?php $_SERVER['PHP_SELF'];?>" class="form-inline" method="post">
                            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                <div class="text-left">
                                    <label class="text-muted">Email ID</label>
                                    <input name="email" type="email" placeholder="Enter Email ID" class="form-control" required />
                                </div>
                                <div class="text-left">
                                    <label for="signupInputPassword" class="text-muted">Password</label>
                                    <input name="password" type="password" placeholder="Password" class="form-control lock-input" required />
                                </div>
                                <div class="pull-left pad-btm">
                                    <label class="form-checkbox form-icon form-text">
                                    <input type="checkbox" name="cookie_set" value="true" checked=""> Remember Me
                                    </label>
                                </div> 
                                	<div class="pull-right pad-btm">
                    				<a style="color:black;"  href="<?php echo $link->link('forgot_password',admin);?>">Forgot password?</a>
                    				</div>
                                <button type="submit" value="Log in" name="submit_login" class="btn btn-block btn-primary">
                                <i class="fa  fa-sign-in fa-lg"></i>  Sign In
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
        </div>
        </div>
        <!--===================================================--> 
        <!-- END OF CONTAINER -->
        <!--JAVASCRIPT-->
        <!--=================================================-->
           <script src="<?php echo SITE_URL.'/assets/frontend/js/jquery-2.1.1.min.js';?>"></script> 
          <script src="<?php echo SITE_URL.'/assets/frontend/js/jquery-ui.min.js';?>"></script>
        <script src="<?php echo SITE_URL.'/assets/frontend/js/bootstrap.min.js';?>"></script>
        <script src="<?php echo SITE_URL.'/assets/frontend/plugins/fast-click/fastclick.min.js';?>"></script>
        <script src="<?php echo SITE_URL.'/assets/frontend/js/scripts.js';?>"></script>
        <script src="<?php echo SITE_URL.'/assets/frontend/plugins/nanoscrollerjs/jquery.nanoscroller.min.js';?>"></script>
         <script src="<?php echo SITE_URL.'/assets/frontend/plugins/metismenu/metismenu.min.js';?>"></script>
        <script src="<?php echo SITE_URL.'/assets/frontend/plugins/switchery/switchery.min.js';?>"></script>
        <script src="<?php echo SITE_URL.'/assets/frontend/plugins/bootstrap-select/bootstrap-select.min.js';?>"></script> 
    
          <script src="<?php echo SITE_URL.'/assets/frontend/plugins/screenfull/screenfull.js';?>"></script>
       </body>
</html>