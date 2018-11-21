<?php

if (! isset($query1ans) || $query1 == '' || $query1ans == '') {
    $query1 = user;
    $query1ans = 'home';
}
if (file_exists(SERVER_ROOT . '/protected/setting/frontend/frontend_common_data.php')) {

    require SERVER_ROOT . '/protected/setting/frontend/frontend_common_data.php';
}

$fcontroller = SERVER_ROOT . '/protected/controller/frontend/' . $query1ans . '_controller.php';
$fview = SERVER_ROOT . '/protected/views/frontend/' . $query1ans . ".php";
if ($query1ans == "login" || $query1ans == "slogin" ||  $query1ans == 'signup' || $query1ans == 'setup_company' || $query1ans == 'setup_company_ajax' || $query1ans == 'sociallogin' ||
    $query1ans == 'forgot_password'  || $query1ans == 'ajax' || $query1ans == 'installation_final' || $query1ans == 'paypal' ||
    $query1ans == 'pdfgenerate' || $query1ans == 'modal_box' || $query1ans == 'test' || $query1ans == 'googlecallback' || $query1ans == 'facebookcallback' ) {
    if (file_exists($fview)) {
  if (file_exists($fcontroller))

            require $fcontroller;
        require $fview;
    }
}


elseif ($query1ans == "logout") {

    /*entry in activity log table*/
    $event="<b>Logout</b> ". ucfirst(CURRENT_LOGIN_USER_FNAME) . " " . ucfirst(CURRENT_LOGIN_USER_LNAME)." logout successfully ";
    $db->insert('activity_logs',array('user_id'=>$_SESSION['user_id'],
                                      'event'=>$event,
                                      'event_type'=>'logout',
                                      'company_id'=>CURRENT_LOGIN_COMPANY_ID,
                                      'created_date'=>date('Y-m-d'),
                                      'ip_address'=>$_SERVER['REMOTE_ADDR']));
    setcookie('remember_me', "", time() - 3600);

    //google

    require_once SERVER_ROOT . '/protected/setting/google_login_config.php';
    require_once SERVER_ROOT . '/protected/library/lib/Google_Client.php';

    $client = new Google_Client();

    unset($_SESSION['token']);
    $client->revokeToken();



    //end google



    $session->destroy('login',frontend);
}
elseif (!file_exists($fview) || $query1ans == 'installation_final' || $query1ans == 'installation') {

    header("HTTP/1.0 404 Not Found");
    require SERVER_ROOT . '/protected/views/frontend/404.php';
}
else {
   /* if (file_exists(SERVER_ROOT . '/protected/setting/frontend/assign_roles.php')) {

        require SERVER_ROOT . '/protected/setting/frontend/assign_roles.php';
    }*/
    if (file_exists(SERVER_ROOT . '/protected/setting/frontend/common_data.php')) {

        require SERVER_ROOT . '/protected/setting/frontend/common_data.php';
    }

    if (file_exists(SERVER_ROOT . '/protected/setting/frontend/header.php')) {
        if($query1ans!='pdfgenerate')
        require SERVER_ROOT . '/protected/setting/frontend/header.php';
    }

    if (file_exists($fview)) {
        if (file_exists($fcontroller))
            require $fcontroller;
        require $fview;
    }
    if (file_exists(SERVER_ROOT . '/protected/setting/frontend/leftsidebar.php')) {
        require SERVER_ROOT . '/protected/setting/frontend/leftsidebar.php';
    }

    if (file_exists(SERVER_ROOT . '/protected/setting/frontend/footer.php')) {
        require SERVER_ROOT . '/protected/setting/frontend/footer.php';
    }

}
?>