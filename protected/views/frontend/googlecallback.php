<?php 

require_once(SERVER_ROOT . '/protected/setting/google_login_config.php');
require_once(SERVER_ROOT . '/protected/library/lib/Google_Client.php');
require_once(SERVER_ROOT . '/protected/library/lib/Google_Oauth2Service.php');

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

	


	echo '<script type="text/javascript">window.close();</script>';
	exit;
}

if (isset($_SESSION['token'])) {
	$client->setAccessToken($_SESSION['token']);
}

if (isset($_REQUEST['error'])) {
	
	echo '<script type="text/javascript">window.close();</script>'; exit;
}



?>