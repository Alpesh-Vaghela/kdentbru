<?php 

//google
require_once SERVER_ROOT . '/protected/setting/google_login_config.php';
require_once SERVER_ROOT . '/protected/library/lib/Google_Client.php';
require_once SERVER_ROOT . '/protected/library/lib/Google_Oauth2Service.php';
//facebook
require_once SERVER_ROOT.'/protected/library/src/Facebook/autoload.php'; // change path as needed


$fb = new \Facebook\Facebook([
   // 'app_id' => '1976824092551501',
  //  'app_secret' => 'b1c59ec7b88cfce4e6bd4bc3c3593116',
  'app_id' => FACEBOOK_API_ID,
  'app_secret' => FACEBOOK_API_SECRET,
  'default_graph_version' => 'v2.10',
    //'default_access_token' => '{access-token}', // optional
]);



$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // Optional permissions
$loginUrl = $helper->getLoginUrl($link->link('facebookcallback',frontend), $permissions);


$client = new Google_Client();
$client->setApplicationName("Google UserInfo PHP Starter Application");

$client->setClientId(CLIENT_ID);
$client->setClientSecret(CLIENT_SECRET);
$client->setRedirectUri(REDIRECT_URI);
$client->setApprovalPrompt(APPROVAL_PROMPT);
$client->setAccessType(ACCESS_TYPE);

$oauth2 = new Google_Oauth2Service($client);

if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
  $_SESSION['token'] = $client->getAccessToken(); 
 //echo '<script type="text/javascript">window.close();</script>'; exit;
} 

if (isset($_SESSION['token'])) {
 $client->setAccessToken($_SESSION['token']);
}

if (isset($_REQUEST['error'])) {
 
 //echo '<script type="text/javascript">window.close();</script>'; exit;
}

if ($client->getAccessToken()) {
  


  $user = $oauth2->userinfo->get();

  $email = filter_var($user['email'], FILTER_SANITIZE_EMAIL);
  $first_name = filter_var($user['given_name']);
  $last_name = filter_var($user['family_name']);
  
  $img = filter_var($user['picture'], FILTER_VALIDATE_URL);
  $personMarkup = "$email<div><img src='$img?sz=50'></div>";

  $_SESSION['token'] = $client->getAccessToken();

  
  $query=$db->get_row('users',array('email'=>$email));
  if(is_array($query))
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
          
          
              // entry in activity log table
          $event="<b>Google Login</b> " . ucfirst($query['firstname']) . " " . ucfirst($query['lastname'])." login successfully ";
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
    }
    
    
    
  }
  else
  {
   $insert=$db->insert('users',array('firstname'=>trim($first_name),
     'lastname'=>trim($last_name),
     'email'=>trim($email),
     'password'=>'',
     'user_type'=>'admin',
     'staff_login'=>'yes',
     'visibility_status'=>'inactive',
     'create_date'=>date('Y-m-d'),
     'ip_address'=>$_SERVER['REMOTE_ADDR']
   ));
   $last_insert_id=$db->insert_id;
   if ($insert)
   {
     $session->redirect('setup_company&new_company='.$last_insert_id,frontend);
   }
 }
 
 
 
} else {
  $authUrl = $client->createAuthUrl();
}





//end google





?>

<!DOCTYPE html> 
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> <?php echo SITE_NAME;?></title>
  <link rel="shortcut icon" href="<?php echo SITE_URL.'/assets/frontend/img/favicon.ico';?>">
  <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:300,400,700|Roboto:300,400,700" rel="stylesheet">
  <link href="<?php echo SITE_URL.'/assets/frontend/css/bootstrap.min.css';?>" rel="stylesheet">
  <link href="<?php echo SITE_URL.'/assets/frontend/css/style.css';?>" rel="stylesheet">
  <link href="<?php echo SITE_URL.'/assets/frontend/plugins/font-awesome/css/font-awesome.min.css';?>" rel="stylesheet">
  <link href="<?php echo SITE_URL.'/assets/frontend/plugins/switchery/switchery.min.css';?>" rel="stylesheet">
  <link href="<?php echo SITE_URL.'/assets/frontend/plugins/bootstrap-select/bootstrap-select.min.css';?>" rel="stylesheet">
  <link href="<?php echo SITE_URL.'/assets/frontend/css/demo/jasmine.css';?>" rel="stylesheet">
  <link href="<?php echo SITE_URL.'/assets/frontend/plugins/pace/pace.min.css';?>" rel="stylesheet">
  <link href="<?php echo SITE_URL.'/assets/frontend/css/custom.css';?>" rel="stylesheet">
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
              <a style="color:black;"  href="<?php echo $link->link('forgot_password',user);?>">Forgot password?</a>
            </div> 
            <button type="submit" value="Log in" name="submit_login" class="btn btn-block btn-success">
              <i class="fa  fa-sign-in fa-lg"></i>  Sign In
            </button>
            <br>
            <a class='btn btn-danger login' href='javascript:void(0);'><i class="fa  fa-google fa-lg"></i> Google Login</a>
            <a class='btn btn-primary' href="<?php echo htmlspecialchars($loginUrl);?>"><i class="fa  fa-facebook-f fa-lg"></i> Facebook Login</a>

          </div>
        </form>
      </div>
    </div>
    
    <div class="registration"> Don't have an account ! <a href="<?php echo $link->link('signup',frontend);?>"> <span class="text-primary"> Sign Up </span> </a> </div>
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


<script type="text/javascript" src="<?php echo SITE_URL.'/assets/frontend/google_login/oauthpopup.js'?>"></script>
<script type="text/javascript">

//alert($authUrl);
$(document).ready(function(){
	
  $('a.login').oauthpopup({
   path: '<?php if(isset($authUrl)){echo $authUrl;}else{ echo '';}?>',
   
   
 });
  
});
</script>
</body>
</html>