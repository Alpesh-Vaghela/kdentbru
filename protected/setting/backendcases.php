<?php

$bcontroller = SERVER_ROOT . '/protected/controller/backend/' . $query1ans . '_controller.php';
$bview = SERVER_ROOT . '/protected/views/backend/' . $query1ans . ".php";
if ($query1ans == "login" || $query1ans == 'signup' || $query1ans == 'forgot_password'
	|| $query1ans == 'home11' || $query1ans == 'ajax' || $query1ans == 'pdfgenerate') {
    if (file_exists($bview)) {
        if (file_exists($bcontroller))
            require $bcontroller;
        require $bview;
    }
}


elseif ($query1ans == "logout") {
    setcookie('remember_me', "", time() - 3600);
    $session->destroy('login',admin);
}
elseif (!file_exists($bview) || $query1ans == 'installation_final' || $query1ans == 'installation') {
   // echo $query2ans;
    header("HTTP/1.0 404 Not Found");
    require SERVER_ROOT . '/protected/views/backend/404.php';
}
else {

    if (file_exists(SERVER_ROOT . '/protected/setting/backend/common_data.php')) {

        require SERVER_ROOT . '/protected/setting/backend/common_data.php';
    }
    if (file_exists(SERVER_ROOT . '/protected/setting/backend/header.php')) {
        if($query1ans!='pdfgenerate')
        require SERVER_ROOT . '/protected/setting/backend/header.php';
    }

    if (file_exists($bview)) {
        if (file_exists($bcontroller))
            require $bcontroller;
        require $bview;
    }

    if (file_exists(SERVER_ROOT . '/protected/setting/backend/footer.php')) {
        require SERVER_ROOT . '/protected/setting/backend/footer.php';
    }
}
?>