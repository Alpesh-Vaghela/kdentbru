<?php
/* directory that contain classes */
$classesDir = array(
    SERVER_ROOT . '/protected/library/'
);
/* loading all library components in everywhere */
spl_autoload_register(function ($class) {
    global $classesDir;
    foreach ($classesDir as $directory) {
        if (file_exists($directory . $class . '_class.php')) {
            require($directory . $class . '_class.php');

            return;
        }
    }
});
/* loading all library end */
/* Connect to an ODBC database using driver invocation */
// $db = new db("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
if (file_exists(SERVER_ROOT . "/protected/setting/" . Appname . "lock")) {
    $db = new db("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
}
$fv = new form_validations();
$feature = new feature();
$password = new password();
$link = new links();
$session = new session();
$acc_object = new account();


/**
 * This controller routes all incoming requests to the appropriate controller and page
 */

$request = explode('?', $_SERVER['REQUEST_URI']);
$parsed = explode('=', $request['1']);
$query3ans = $parsed['3'];

$query1 = $parsed['0'];
$getParsed = explode('&', $parsed['1']);

$query1ans = $getParsed['0'];
$query2 = $getParsed['1'];
$query2ans = $parsed['2'];
$query2ans_extended = explode('&', $query2ans);
$query2ans = $query2ans_extended['0'];
$query3 = $query2ans_extended['1'];

if (!file_exists(SERVER_ROOT . "/protected/setting/" . Package . "lock")) {

    setcookie('remember_me', "", time() - 3600);
    session_unset();
    session_destroy();
    $query1 = user;
    if ($query1ans != 'installation' && $query1ans != 'installation_final')
        $query1ans = 'installation';
    $query1 = "installation";
    require SERVER_ROOT . '/protected/setting/installationcases.php';
} else {

    $settings = $db->get_row('settings');
    //date_default_timezone_set($settings['timezone']);//datetime zone setting
    define(SITE_CURRENCY, $settings['currency_symbol']);
    define(SITE_NAME, $settings['name']);
    define(SITE_EMAIL, $settings['email']);
    define(SITE_ADDRESS, $settings['address']);
    define(SITE_PHONE1, $settings['telephone1']);
    define(SITE_DATE_FORMAT, $settings['date_format']);
    define(SITE_TIMEZONE, $settings['timezone']);
    define(COMMON_DATE_FORMAT, 'd-m-Y');
    define(VISIT_IN_PRECESS, 'visit in process');
    define(VISIT_DONE, 'Visit done');
    if (file_exists(SERVER_ROOT . '/uploads/logo/' . $settings['logo']) && (($settings['logo']) != '')) {
        $site_logo = SITE_URL . '/uploads/logo/' . $settings['logo'];
    } else {
        $site_logo = "//www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image";
    }

    define(SITE_LOGO, $site_logo);

    define(stripe_publishkey_test, 'pk_test_RYEwLLjceoYo7I2fYZPJH3Ct');//pk_test_RYEwLLjceoYo7I2fYZPJH3Ct
    define(stripe_secretkey_test, 'sk_test_KXph2B1DZXtvrG26qi9gTkf3');//sk_test_KXph2B1DZXtvrG26qi9gTkf3
    define(FACEBOOK_API_ID, $settings['facebook_api_id']);
    define(FACEBOOK_API_SECRET, $settings['facebook_api_secret']);
    define(GOOGLE_CLIENT_ID, $settings['google_client_id']);
    define(GOOGLE_CLIENT_SECRET, $settings['google_client_secret']);

    if ($query1 == 'admin') {
        require SERVER_ROOT . '/protected/setting/backendcases.php';
    } else {
        require SERVER_ROOT . '/protected/setting/frontendcases.php';
    }

}
?>