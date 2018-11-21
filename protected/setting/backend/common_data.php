<?php

 if(!$session->Check()){
    if(!isset($_COOKIE['remember_me']) || $_COOKIE['remember_me']=='')
        $session->redirect('login',admin);
 else
    {
        $cookie=explode('___',$_COOKIE['remember_me']);
        $session->Open();
        if(isset($_SESSION) )
        {
            $_SESSION ['email'] = $cookie['0'];
            $_SESSION['user_type'] = $cookie['1'];
         
        }

    }
}
?>
<?php 

if ($_SESSION['user_type']=="site_admin")
{
define(CURRENT_LOGIN_USER_FNAME, $settings['admin_first_name']);
define(CURRENT_LOGIN_USER_LNAME, $settings['admin_last_name']);
define(CURRENT_LOGIN_USER_EMAIL, $_SESSION ['email']);
define(CURRENT_LOGIN_USER_TYPE, $_SESSION['user_type']);


if(file_exists(SERVER_ROOT.'/uploads/admin/'.$settings['admin_image']) && (($settings['admin_image'])!=''))
   {
       $admin_image=SITE_URL.'/uploads/admin/'.$settings['admin_image'];
   }else{
       $admin_image= SITE_URL.'/assets/frontend/default_image/default_user_image.png';
   }


}else{
    setcookie('remember_me', "", time() - 3600);
    $session->destroy('login',admin);
}
?>