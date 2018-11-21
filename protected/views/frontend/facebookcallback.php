<?php
require_once SERVER_ROOT.'/protected/library/src/Facebook/autoload.php'; // change path as needed

$fb = new \Facebook\Facebook([
  'app_id' => FACEBOOK_API_ID,
  'app_secret' => FACEBOOK_API_SECRET,
  'default_graph_version' => 'v2.10',
  //'default_access_token' => '{access-token}', // optional
]);


$helper = $fb->getRedirectLoginHelper();

try {
  $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

if (! isset($accessToken)) {
  if ($helper->getError()) {
    header('HTTP/1.0 401 Unauthorized');
    echo "Error: " . $helper->getError() . "\n";
    echo "Error Code: " . $helper->getErrorCode() . "\n";
    echo "Error Reason: " . $helper->getErrorReason() . "\n";
    echo "Error Description: " . $helper->getErrorDescription() . "\n";
  } else {
    header('HTTP/1.0 400 Bad Request');
    echo 'Bad request';
  }
  exit;
}

// Logged in
//echo '<h3>Access Token</h3>';
//var_dump($accessToken->getValue());

// The OAuth 2.0 client handler helps us manage access tokens
$oAuth2Client = $fb->getOAuth2Client();

// Get the access token metadata from /debug_token
$tokenMetadata = $oAuth2Client->debugToken($accessToken);
//echo '<h3>Metadata</h3>';
//var_dump($tokenMetadata);

// Validation (these will throw FacebookSDKException's when they fail)
$tokenMetadata->validateAppId(FACEBOOK_API_ID); // Replace {app-id} with your app id
// If you know the user ID this access token belongs to, you can validate it here
//$tokenMetadata->validateUserId('123');
$tokenMetadata->validateExpiration();

if (! $accessToken->isLongLived()) {
  // Exchanges a short-lived access token for a long-lived one
  try {
    $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
  } catch (Facebook\Exceptions\FacebookSDKException $e) {
    echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
    exit;
  }

//  echo '<h3>Long-lived</h3>';
//  var_dump($accessToken->getValue());
}

$_SESSION['fb_access_token'] = $accessToken->getValue();

// User is logged in with a long-lived access token.
// You can redirect them to a members-only page.
//header('Location: https://example.com/members.php');
try {
  // Returns a `Facebook\FacebookResponse` object
  $response = $fb->get('/me?fields=id,name,email', $accessToken->getValue());
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

$user = $response->getGraphUser();
$email=$user['email'];
$name=$user['name'];
$n=explode(' ',$name);
$first_name=$n[0];
$last_name=$n[1];
//echo "<br>";
//echo 'Name: ' . $user['name'];
//echo "<br>";
//echo 'Email: ' . $user['email'];
// OR

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



?>