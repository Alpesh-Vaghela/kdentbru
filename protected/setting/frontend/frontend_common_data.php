<?php

/******************************************System Information details***************************************/

//define(DATE_FORMAT,$settings['date_format']);
//define(TIMEZONE,$settings['timezone']);
/******************************************Current Login user details**********************************************************/
$user_details = $db->get_row('users', array('user_id' => $_SESSION['user_id']));
define(CURRENT_LOGIN_USER_FNAME, $user_details['firstname']);
define(CURRENT_LOGIN_USER_LNAME, $user_details['lastname']);
define(CURRENT_LOGIN_USER_EMAIL, $user_details['email']);
define(CURRENT_LOGIN_COMPANY_ID, $user_details['company_id']);
define(CURRENT_LOGIN_USER_TYPE, $user_details['user_type']);
//echo CURRENT_LOGIN_COMPANY_ID;
jump:


/**************************************company information**************************************************/
$common_data_company_setting = $db->get_row('company', array('id' => CURRENT_LOGIN_COMPANY_ID));
define(COMPANY_NAME, $common_data_company_setting['company_name']);
define(COMPANY_EMAIL, $common_data_company_setting['company_email']);
define(COMPANY_PHONE, $common_data_company_setting['company_phone']);
define(COMPANY_ADDRESS, $common_data_company_setting['company_address']);
define(COMPANY_WEBSITE, $common_data_company_setting['company_website']);
define(COMPANY_STATE, $common_data_company_setting['company_state']);
define(COMPANY_CITY, $common_data_company_setting['company_city']);
define(COMPANY_ZIP, $common_data_company_setting['company_zip']);
define(COMPANY_LOGO, $common_data_company_setting['company_logo']);
define(COMPANY_DESCRIPTION, $common_data_company_setting['company_description']);
define(CURRENCY, $common_data_company_setting['company_currencysymbol']);
define(DATE_FORMAT, $common_data_company_setting['company_date_format']);
define(TIMEZONE, $common_data_company_setting['company_timezone']);
date_default_timezone_set(TIMEZONE);//datetime zone setting


$clogo = SITE_URL . '/uploads/company/' . CURRENT_LOGIN_COMPANY_ID . '/logo/' . COMPANY_LOGO;
define(COMPANY_LOGO_PATH, $clogo);

/*****************************************************************************************************/

//$dayName=date("l", strtotime($appointment_date));
$working_day = unserialize($db->get_var('company', array('id' => CURRENT_LOGIN_COMPANY_ID), 'working_day'));
$working_on_off = unserialize($db->get_var('company', array('id' => CURRENT_LOGIN_COMPANY_ID), 'working_on_off'));
$working_start_time = unserialize($db->get_var('company', array('id' => CURRENT_LOGIN_COMPANY_ID), 'working_start_time'));
$working_end_time = unserialize($db->get_var('company', array('id' => CURRENT_LOGIN_COMPANY_ID), 'working_end_time'));


if (is_array($working_day)) {
    $offday = array();
    foreach ($working_day as $key => $value) {
        $start = $working_start_time[$key];
        $end = $working_end_time[$key];

        $day_array = array('sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday');
        $day_array_key = array_search($value, $day_array);
        $on_off = $working_on_off[$key];
        if ($on_off == "off") {
            array_push($offday, $day_array_key);
        }

        $business_day .= "{
     dow: [ " . $day_array_key . " ],
     start: '" . $start . "',
     end: '" . $end . "'
   },";
    }
}
if (is_array($offday)) {
    $offday = array_reverse($offday);
    $offday_new = implode(",", $offday);
}


/******************************************Company plan details************************************/
$plan_settings = $db->get_row('plans_company', array('company_id' => CURRENT_LOGIN_COMPANY_ID));
define(COMPANY_PLAN_ID, $plan_settings['plan_id']);
define(COMPANY_PLAN_NAME, $plan_settings['plan_name']);
define(COMPANY_PLAN_ALLOW_STAFF, $plan_settings['allow_staff']);
define(COMPANY_PLAN_PRICE, $plan_settings['price']);


/******************************************Plan1  details************************************/
$plan1_settings = $db->get_row('plans', array('id' => 1));
//print_r($plan1_settings);
define(PLAN1_ID, $plan1_settings['id']);
define(PLAN1_NAME, $plan1_settings['plan_name']);
define(PLAN1_ALLOW_STAFF, $plan1_settings['allow_staff']);
define(PLAN1_PRICE, $plan1_settings['price']);
/******************************************plan1 details************************************/
$plan2_settings = $db->get_row('plans', array('id' => 2));
define(PLAN2_ID, $plan2_settings['id']);
define(PLAN2_NAME, $plan2_settings['plan_name']);
define(PLAN2_ALLOW_STAFF, $plan2_settings['allow_staff']);
define(PLAN2_PRICE, $plan2_settings['price']);


define(PAYPAL_MODE, "sandbox");
define(PAYPAL_LIVE_EMAIL, "subodhjha@iwcnetwork.com");
define(PAYPAL_SANDBOX_EMAIL, "subodhjha@iwcnetwork.com");


/******************************************Preference Setting Information details************************************/
$preferences_settings = $db->get_row('preferences_settings', array('company_id' => CURRENT_LOGIN_COMPANY_ID));

if (isset($_GET['cal_view']) && !empty($_GET['cal_view'])) {
    switch ($_GET['cal_view']) {
        case 'agendaDay':
            $calView = "daily";
            break;

        case 'agendaWeek':
            $calView = "weekly";
            break;
        default:
            $calView = "month";
            break;
    }
} else {
    $calView = $preferences_settings['default_calendar'];
}

define(DEFAULT_CALENDAR, $calView);
define(WEEK_START_DAY, $preferences_settings['week_start_day']);
define(CUSTOM_TIME_SLOT, $preferences_settings['custom_time_slot']);
define(CALENDAR_START_HOUR, $preferences_settings['calendar_start_hour']);
define(SHOW_CALENDAR_STATS, $preferences_settings['show_calendar_stats']);
define(PREFERRED_LANGUAGE, 'it');
define(ENABLE_REVIEW, $preferences_settings['enable_review']);


$allnotifications = $db->get_row('notification_settings', array('company_id' => CURRENT_LOGIN_COMPANY_ID));

$common_data_customer_notification = unserialize($allnotifications['customer_notification']);
$common_data_staff_notification = unserialize($allnotifications['staff_notification']);
$common_data_activity_alert = unserialize($allnotifications['activity_notifications']);

if ($allnotifications['sendar_name'] != "") {
    $common_data_sendar_name = $allnotifications['sendar_name'];
} else {
    $common_data_sendar_name = COMPANY_NAME;
}
if ($allnotifications['email_signature'] != "") {
    $common_data_email_signature = html_entity_decode($allnotifications['email_signature']);
} else {
    $common_data_email_signature = "Thanks,<br>" . COMPANY_NAME;
}
if (is_array($common_data_customer_notification)) {
    if (in_array('show_timezone', $common_data_customer_notification)) {
        $customer_timezone = TIMEZONE;
    } else {
        $customer_timezone = "";
    }
    if (in_array('show_timezone', $common_data_staff_notification)) {
        $staff_timezone = TIMEZONE;
    } else {
        $staff_timezone = "";
    }
}
?>