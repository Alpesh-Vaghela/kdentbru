<?php
define('BASE_URL', filter_var(SITE_URL.'/', FILTER_SANITIZE_URL));
// Visit https://code.google.com/apis/console to generate your
// oauth2_client_id, oauth2_client_secret, and to register your oauth2_redirect_uri.
//define('CLIENT_ID','322771047662-dkfh6gskibsghrgdcj9tgi6n521s9qhs.apps.googleusercontent.com');
//define('CLIENT_SECRET','D_r7bt08b6fbArCpHYOJfh5J');
define('CLIENT_ID',GOOGLE_CLIENT_ID);
define('CLIENT_SECRET',GOOGLE_CLIENT_SECRET);
define('REDIRECT_URI',$link->link('googlecallback',frontend));//example:http://localhost/social/login.php?google,http://example/login.php?google
define('APPROVAL_PROMPT','auto');
define('ACCESS_TYPE','offline'); 
?>
