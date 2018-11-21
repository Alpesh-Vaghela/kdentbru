<?php

if (!$session->Check()) {
    if (!isset($_COOKIE['remember_me']) || $_COOKIE['remember_me'] == '')
        $session->redirect('login', user);
    else {
        $cookie = explode('___', $_COOKIE['remember_me']);
        $session->Open();
        if (isset($_SESSION)) {
            $_SESSION ['email'] = $cookie['0'];
            $_SESSION['user_id'] = $cookie['1'];
            $_SESSION['user_type'] = $cookie['2'];
        }

    }
}

if ($_SESSION['user_type'] != 'admin' && $_SESSION['user_type'] != 'staff' && $_SESSION['user_type'] != 'receptionist') {
    $session->redirect('logout', user);
}
?>


