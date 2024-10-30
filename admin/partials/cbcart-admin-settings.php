<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$cbcart_data = get_option('cbcart_usersettings');
$cbcart_data = json_decode($cbcart_data);
$cbcart_data= sanitize_option("cbcart_usersettings",$cbcart_data);
if ($cbcart_data != "") {
    $cbcart_isMessageFromAdminNumber = $cbcart_data->cbcart_isMessageFromAdminNumber;
    $cbcart_official_number = $cbcart_data->cbcart_official_number;
    $cbcart_checkplan = $cbcart_data->cbcart_planid;
} else {
    $cbcart_isMessageFromAdminNumber = "";
    $cbcart_official_number = "";
    $cbcart_checkplan = "";
}
$cbcart_data = get_option('cbcart_adminsettings');
$cbcart_data = json_decode($cbcart_data);
$cbcart_data= sanitize_option(  "cbcart_adminsettings",$cbcart_data);
if ($cbcart_data != "") {
    $cbcart_email = $cbcart_data->cbcart_email;
    $cbcart_username = $cbcart_data->cbcart_username;
    $cbcart_password = $cbcart_data->cbcart_password;
    $cbcart_from_number = $cbcart_data->cbcart_from_number;
    $cbcart_default_country = $cbcart_data->cbcart_default_country;
    $cbcart_cron_time = $cbcart_data->cbcart_cron_time;
} else {
    $cbcart_email = "";
    $cbcart_username = "";
    $cbcart_password = "";
    $cbcart_from_number = "";
    $cbcart_default_country ="";
    $cbcart_cron_time = "";
}
$cbcart_data = get_option('cbcart_abandonedsettings');
$cbcart_data = json_decode($cbcart_data);
$cbcart_data= sanitize_option(  "cbcart_abandonedsettings",$cbcart_data);

if ($cbcart_data != "") {
    $cbcart_trigger = $cbcart_data->cbcart_trigger_time;
    $cbcart_time1 = $cbcart_data->cbcart_time1;
    $cbcart_trigger2 = $cbcart_data->cbcart_trigger_time2;
    $cbcart_time2 = $cbcart_data->cbcart_time2;
    $cbcart_trigger3 = $cbcart_data->cbcart_trigger_time3;
    $cbcart_time3 = $cbcart_data->cbcart_time3;
    $cbcart_trigger4 = $cbcart_data->cbcart_trigger_time4;
    $cbcart_time4 = $cbcart_data->cbcart_time4;
    $cbcart_trigger5 = $cbcart_data->cbcart_trigger_time5;
    $cbcart_time5 = $cbcart_data->cbcart_time5;
    $cbcart_ac_enable = $cbcart_data->cbcart_ac_enable;
    $cbcart_message1_enable = $cbcart_data->cbcart_message1_enable;
    $cbcart_message2_enable = $cbcart_data->cbcart_message2_enable;
    $cbcart_message3_enable = $cbcart_data->cbcart_message3_enable;
    $cbcart_message4_enable = $cbcart_data->cbcart_message4_enable;
    $cbcart_message5_enable = $cbcart_data->cbcart_message5_enable;
    $cbcart_ac_message = $cbcart_data->cbcart_ac_message;
    $cbcart_ac_template_name = $cbcart_data->cbcart_ac_template_name;
    $cbcart_ac_template_lang = $cbcart_data->cbcart_ac_template_lang;
    $cbcart_ac_template_varcount = $cbcart_data->cbcart_ac_template_varcount;
    $cbcart_ac_message2 = $cbcart_data->cbcart_ac_message2;
    $cbcart_ac_template2_name = $cbcart_data->cbcart_ac_template2_name;
    $cbcart_ac_template2_lang = $cbcart_data->cbcart_ac_template2_lang;
    $cbcart_ac_template2_varcount = $cbcart_data->cbcart_ac_template2_varcount;
    $cbcart_ac_message3 = $cbcart_data->cbcart_ac_message3;
    $cbcart_ac_template3_name = $cbcart_data->cbcart_ac_template3_name;
    $cbcart_ac_template3_lang = $cbcart_data->cbcart_ac_template3_lang;
    $cbcart_ac_template3_varcount = $cbcart_data->cbcart_ac_template3_varcount;
    $cbcart_ac_message4 = $cbcart_data->cbcart_ac_message4;
    $cbcart_ac_template4_name = $cbcart_data->cbcart_ac_template4_name;
    $cbcart_ac_template4_lang = $cbcart_data->cbcart_ac_template4_lang;
    $cbcart_ac_template4_varcount = $cbcart_data->cbcart_ac_template4_varcount;
    $cbcart_ac_message5 = $cbcart_data->cbcart_ac_message5;
    $cbcart_ac_template5_name = $cbcart_data->cbcart_ac_template5_name;
    $cbcart_ac_template5_lang = $cbcart_data->cbcart_ac_template5_lang;
    $cbcart_ac_template5_varcount = $cbcart_data->cbcart_ac_template5_varcount;
    $cbcart_abandoned_image = $cbcart_data->cbcart_abandoned_image;
} else {
    $cbcart_data="";
    $cbcart_trigger = "";
    $cbcart_time1 = "";
    $cbcart_trigger2 = "";
    $cbcart_time2 = "";
    $cbcart_trigger3 = "";
    $cbcart_time3 = "";
    $cbcart_trigger4 = "";
    $cbcart_time4 = "";
    $cbcart_trigger5 = "";
    $cbcart_time5 = "";
    $cbcart_ac_enable = "";
    $cbcart_message1_enable = "";
    $cbcart_message2_enable = "";
    $cbcart_message3_enable = "";
    $cbcart_message4_enable = "";
    $cbcart_message5_enable = "";
    $cbcart_ac_message = "";
    $cbcart_ac_template_name = "";
    $cbcart_ac_template_lang = "";
    $cbcart_ac_template_varcount = "";
    $cbcart_ac_message2 = "";
    $cbcart_ac_template2_name = "";
    $cbcart_ac_template2_lang = "";
    $cbcart_ac_template2_varcount = "";
    $cbcart_ac_message3 = "";
    $cbcart_ac_template3_name = "";
    $cbcart_ac_template3_lang ="";
    $cbcart_ac_template3_varcount = "";
    $cbcart_ac_message4 = "";
    $cbcart_ac_template4_name = "";
    $cbcart_ac_template4_lang = "";
    $cbcart_ac_template4_varcount = "";
    $cbcart_ac_message5 = "";
    $cbcart_ac_template5_name = "";
    $cbcart_ac_template5_lang = "";
    $cbcart_ac_template5_varcount = "";
    $cbcart_abandoned_image = "";
}
if ($cbcart_cron_time == "") {
    $cbcart_cron_time = "1200";
}

if (empty($cbcart_ac_message)) {
    $cbcart_ac_message = esc_html('Hi We noticed you didnt finish your order on {storename}.\n\nVisit {siteurl} to complete your order.  \n\nThanks, {storename}.','cartbox-messaging-widgets');
}
if (property_exists( $cbcart_data , 'cbcart_trigger_time')) {
    if ($cbcart_trigger == "") {
        $cbcart_trigger = "20";
    }
}
// on update button click
if (!empty($_POST['cbcart_updatebutton']) ) {
    $cbcart_legit = true;
    if (!isset($_POST['cbcart_update_form_nonce'])) {
        $cbcart_legit = false;
    }
    $cbcart_nonce = isset($_POST['cbcart_update_form_nonce']) ? sanitize_text_field(wp_unslash($_POST['cbcart_update_form_nonce'])) : '';
    if (!wp_verify_nonce($cbcart_nonce, 'cbcart_update_form')) {
        $cbcart_legit = false;
    }
    if (!$cbcart_legit) {
        wp_safe_redirect(add_query_arg());
        exit();
    }

    $cbcart_trigger = isset($_POST['cbcart_trigger_1']) ? sanitize_textarea_field(wp_unslash($_POST['cbcart_trigger_1'])) : '';
    $cbcart_time1 = isset($_POST['cbcart_select_time1']) ? sanitize_textarea_field(wp_unslash($_POST['cbcart_select_time1'])) : '';
    $cbcart_dnd_from = isset($_POST['cbcart_dnd_from']) ? sanitize_text_field(wp_unslash($_POST['cbcart_dnd_from'])) : '';
    $cbcart_dnd_to = isset($_POST['cbcart_dnd_to']) ? sanitize_text_field(wp_unslash($_POST['cbcart_dnd_to'])) : '';
    // if abandoned cart enable than set it as checked
    if (isset($_POST['cbcart_ac_enable'])) {
        $cbcart_ac_enable = esc_html("checked",'cartbox-messaging-widgets');
        $cbcart_ac_flag="1";
    } else {
        $cbcart_ac_enable = "";
        $cbcart_ac_flag="0";
    }
    // if dnd enable than set it as checked
    if (isset($_POST['cbcart_dnd_enable'])) {
        $cbcart_is_dnd_enable = esc_html("checked",'cartbox-messaging-widgets');
    } else {
        $cbcart_is_dnd_enable = "";
    }
    $cbcart_update_option_arr = array();
    $cbcart_flag = 1;
    if ($cbcart_ac_flag === "1") {
        if (empty($cbcart_trigger)) {
            $cbcart_flag = 0;
            $cbcart_error_trigger = '';
            $cbcart_error_trigger .= '<div class="notice notice-error is-dismissible">';
            $cbcart_error_trigger .= '<p>' . esc_html('Please Enter valid time.','cartbox-messaging-widgets') . '</p>';
            $cbcart_error_trigger .= '</div>';
            echo wp_kses_post($cbcart_error_trigger);
        }
    } else {
        $cbcart_trigger="30";
    }
    if ($cbcart_time1 == 'cbcart_select_hour') {
        $cbcart_trigger = cbcart_converthourtominutes($cbcart_trigger);
    }
    if ($cbcart_time1 == 'cbcart_select_day') {
        $cbcart_trigger = cbcart_convertdaytominutes($cbcart_trigger);
    }
    if ($cbcart_flag == 1) {
        $cbcart_update_dnd_array = array(
            'cbcart_is_dnd_enable' => $cbcart_is_dnd_enable,
            'cbcart_dnd_from' => $cbcart_dnd_from,
            'cbcart_dnd_to' => $cbcart_dnd_to,
        );
        $cbcart_result2 = update_option('cbcart_dndsettings', wp_json_encode($cbcart_update_dnd_array));
        $cbcart_update_option_arr = array(
            'cbcart_trigger_time' => $cbcart_trigger,
            'cbcart_time1' => $cbcart_time1,
            'cbcart_trigger_time2' => $cbcart_trigger2,
            'cbcart_time2' => $cbcart_time2,
            'cbcart_trigger_time3' => $cbcart_trigger3,
            'cbcart_time3' => $cbcart_time3,
            'cbcart_trigger_time4' => $cbcart_trigger4,
            'cbcart_time4' => $cbcart_time4,
            'cbcart_trigger_time5' => $cbcart_trigger5,
            'cbcart_time5' => $cbcart_time5,
            'cbcart_ac_enable' => $cbcart_ac_enable,
            'cbcart_message1_enable' => $cbcart_message1_enable,
            'cbcart_message2_enable' => $cbcart_message2_enable,
            'cbcart_message3_enable' => $cbcart_message3_enable,
            'cbcart_message4_enable' => $cbcart_message4_enable,
            'cbcart_message5_enable' => $cbcart_message5_enable,
            'cbcart_ac_message' => $cbcart_ac_message,
            'cbcart_ac_template_name' => $cbcart_ac_template_name,
            'cbcart_ac_template_lang' => $cbcart_ac_template_lang,
            'cbcart_ac_template_varcount' => $cbcart_ac_template_varcount,
            'cbcart_ac_message2' => $cbcart_ac_message2,
            'cbcart_ac_template2_name' => $cbcart_ac_template2_name,
            'cbcart_ac_template2_lang' => $cbcart_ac_template2_lang,
            'cbcart_ac_template2_varcount' => $cbcart_ac_template2_varcount,
            'cbcart_ac_message3' => $cbcart_ac_message3,
            'cbcart_ac_template3_name' => $cbcart_ac_template3_name,
            'cbcart_ac_template3_lang' => $cbcart_ac_template3_lang,
            'cbcart_ac_template3_varcount' => $cbcart_ac_template3_varcount,
            'cbcart_ac_message4' => $cbcart_ac_message4,
            'cbcart_ac_template4_name' => $cbcart_ac_template4_name,
            'cbcart_ac_template4_lang' => $cbcart_ac_template4_lang,
            'cbcart_ac_template4_varcount' => $cbcart_ac_template4_varcount,
            'cbcart_ac_message5' => $cbcart_ac_message5,
            'cbcart_ac_template5_name' => $cbcart_ac_template5_name,
            'cbcart_ac_template5_lang' => $cbcart_ac_template5_lang,
            'cbcart_ac_template5_varcount' => $cbcart_ac_template5_varcount,
            'cbcart_abandoned_image' => $cbcart_abandoned_image,
        );
        $cbcart_result = update_option('cbcart_abandonedsettings', wp_json_encode($cbcart_update_option_arr));
        $cbcart_success = '';
        $cbcart_success .= '<div class="notice notice-success is-dismissible">';
        $cbcart_success .= '<p>' . esc_html('Details update successfully . Setup more in','cartbox-messaging-widgets') . '<a href="admin.php?page=cbcart_ordernotification" >' . esc_html(' Order Notification ','cartbox-messaging-widgets') . '</a>' . esc_html(' and in ','cartbox-messaging-widgets') . '<a href="admin.php?page=cbcart_abandoned_Cart">' . esc_html(' Abandoned Cart','cartbox-messaging-widgets') . '</a>' . '</p>';
        $cbcart_success .= '</div>';
        echo wp_kses_post($cbcart_success);

        //call check userplan and update settings accordingly
        $cbcart_data = get_option('cbcart_otp');
        $cbcart_data = json_decode($cbcart_data);
        $cbcart_data= sanitize_option(  "cbcart_otp",$cbcart_data);
        if ($cbcart_data != "") {
            $cbcart_otp = $cbcart_data->cbcart_otp;
        }
        if ($cbcart_checkplan === "2" || $cbcart_checkplan === "3" || $cbcart_checkplan==="4") {
            if (empty(get_option('cbcart_premiumsettings'))) {
                $cbcart_update_option_arr = array(
                    'cbcart_username' => $cbcart_username,
                    'cbcart_password' => $cbcart_password,
                    'cbcart_email' => $cbcart_email,
                );
                $cbcart_result1 = update_option('cbcart_adminsettings', wp_json_encode($cbcart_update_option_arr));
            }
        }
    }
}
if (!empty($_POST['cbcart_updatesettings'])) {
    $cbcart_legit = true;
    if (!isset($_POST['cbcart_update_form_nonce'])) {
        $cbcart_legit = false;
    }
    $cbcart_nonce = isset($_POST['cbcart_update_form_nonce']) ? sanitize_text_field(wp_unslash($_POST['cbcart_update_form_nonce'])) : '';
    if (!wp_verify_nonce($cbcart_nonce, 'cbcart_update_form')) {
        $cbcart_legit = false;
    }
    if (!$cbcart_legit) {
        wp_safe_redirect(add_query_arg());
        exit();
    }
    $cbcart_from_number = isset($_POST['cbcart_mobileno']) ? sanitize_text_field(wp_unslash($_POST['cbcart_mobileno'])) : '';
    $cbcart_email = isset($_POST['cbcart_email']) ? sanitize_email(wp_unslash($_POST['cbcart_email'])) : '';

    $cbcart_update_option_arr = array();
    $cbcart_flag = 1;
    if (empty($cbcart_from_number)) {
        $cbcart_flag = 0;
        $cbcart_error_mobileno = '';
        $cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible">';
        $cbcart_error_mobileno .= '<p>' . esc_html('Please Enter Mobile Number.','cartbox-messaging-widgets') . '</p>';
        $cbcart_error_mobileno .= '</div>';
        echo wp_kses_post($cbcart_error_mobileno);
    } elseif (strlen($cbcart_from_number) < 7) {
        $cbcart_flag = 0;
        $cbcart_error_mobileno = '';
        $cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible">';
        $cbcart_error_mobileno .= '<p>' . esc_html('Please enter minimum 7 digits number.','cartbox-messaging-widgets') . '</p>';
        $cbcart_error_mobileno .= '</div>';
        echo wp_kses_post($cbcart_error_mobileno);
    }
    if (!filter_var($cbcart_email, FILTER_VALIDATE_EMAIL)) {
        $cbcart_flag = 0;
        $cbcart_error_emailid = '';
        $cbcart_error_emailid .= '<div class="notice notice-error is-dismissible">';
        $cbcart_error_emailid .= '<p>' . esc_html('Please Enter valid Email Address.','cartbox-messaging-widgets') . '</p>';
        $cbcart_error_emailid .= '</div>';
        echo wp_kses_post($cbcart_error_emailid);
    }
    if ($cbcart_flag == 1) {
        $cbcart_update_option_arr = array(
            'cbcart_username' => $cbcart_username,
            'cbcart_password' => $cbcart_password,
            'cbcart_email' => $cbcart_email,
            'cbcart_from_number' => $cbcart_from_number,
            'cbcart_default_country' => $cbcart_default_country,
            'cbcart_cron_time' => $cbcart_cron_time,
        );
        $cbcart_result1 = update_option('cbcart_adminsettings', wp_json_encode($cbcart_update_option_arr));

        $cbcart_success = '';
        $cbcart_success .= '<div class="notice notice-success is-dismissible">';
        $cbcart_success .= '<p>' . esc_html('Details update successfully . Setup more in','cartbox-messaging-widgets') . '<a href="admin.php?page=cbcart_ordernotification" >' . esc_html(' Order Notification ','cartbox-messaging-widgets') . '</a>' . esc_html(' and in ','cartbox-messaging-widgets') . '<a href="admin.php?page=cbcart_abandoned_Cart">' . esc_html(' Abandoned Cart','cartbox-messaging-widgets') . '</a>' . '</p>';
        $cbcart_success .= '</div>';
        echo wp_kses_post($cbcart_success);
    }
}

if (array_key_exists('cbcart_reset', $_POST)) {
    $cbcart_legit   = true;
    if ( ! isset( $_POST['cbcart_reset_nonce'] ) ) {
        $cbcart_legit = false;
    }
    $nonce = isset( $_POST['cbcart_reset_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['cbcart_reset_nonce'] ) ) : '';
    if ( ! wp_verify_nonce( $nonce, 'cbcart_reset' ) ) {
        $cbcart_legit = false;
    }
    if ( ! $cbcart_legit ) {
        wp_safe_redirect( add_query_arg() );
        exit();
    }
    if($cbcart_checkplan!="4"){
        delete_option('cbcart_usersettings');
    }
    delete_option('cbcart_userplan');
    delete_option('cbcart_ordernotificationsettings');
    $cbcart_update_ordernotifications_arr = array(
        'cbcart_is_order_completed'=>"0",
        'cbcart_is_order_processing'=>"1",
        'cbcart_is_order_payment_done'=>"0",
    );
    update_option('cbcart_ordernotificationsettings', wp_json_encode( $cbcart_update_ordernotifications_arr ) );
    delete_option('cbcart_contactformsettings');
    delete_option('cbcart_adminsettings');
    delete_option('cbcart_abandonedsettings');
    delete_option('cbcart_dndsettings');
    delete_option('cbcart_createtemplates');
    delete_option('cbcart_testmessagesetup');
    delete_option('cbcart_test_cloudapi');
    delete_option('cbcart_templatescreen');
    delete_option('cbcart_success');
    delete_option('cbcart_premiumsettings');
    delete_option('cbcart_otp');
    delete_option('cbcart_startup');
    delete_option('cbcart_getotp');
    delete_option('cbcart_freepremium');
    $cbcart_page = isset($_REQUEST['page']) ? sanitize_text_field(wp_unslash($_REQUEST['page'])) : '';
    wp_redirect('admin.php?page=' . $cbcart_page);
}
/**
 * convert minutes to seconds
 *
 * @since    1.0.0
 * @version 3.0.4
 */
function cbcart_convertminutestoseconds($cbcart_minutes) {
    $cbcart_seconds = $cbcart_minutes * 60;
    return $cbcart_seconds;
}

/**
 * convert minutes to seconds
 *
 * @since    1.0.0
 * @version 3.0.4
 */
function cbcart_convertsecondstominute($cbcart_seconds) {
    $cbcart_minute = $cbcart_seconds / 60;
    return $cbcart_minute;
}

/**
 * convert hour to minutes
 *
 * @since    1.0.0
 * @version 3.0.4
 */
function cbcart_converthourtominutes($cbcart_hour) {
    $cbcart_minutes = $cbcart_hour * 60;
    return $cbcart_minutes;
}

/**
 * convert minutes to hour
 *
 * @since    1.0.0
 * @version 3.0.4
 */
function cbcart_convertminutestohour($cbcart_hour) {
    $cbcart_hour = $cbcart_hour / 60;
    return $cbcart_hour;
}

/**
 * convert day to minutes
 *
 * @since    1.0.0
 * @version 3.0.4
 */
function cbcart_convertdaytominutes($cbcart_day) {
    $cbcart_minutes = $cbcart_day * 1440;
    return $cbcart_minutes;
}

/**
 * convert minutes to day
 *
 * @since    1.0.0
 * @version 3.0.4
 */
function cbcart_convertminutestoday($cbcart_minutes) {
    $cbcart_day = $cbcart_minutes / 1440;

    return $cbcart_day;
}

// if msg for admin number
if ($cbcart_isMessageFromAdminNumber != "true") {
    $cbcart_admin_mobile = $cbcart_official_number;
}

$cbcart_language_code = esc_html("en_US",'cartbox-messaging-widgets');
$cbcart_template_id = esc_html("hello_world",'cartbox-messaging-widgets');
if (isset($_POST['cbcart_test1'])) {
    $cbcart_legit = true;
    if (!isset($_POST['cbcart_send_test_msg_nonce'])) {
        $cbcart_legit = false;
    }
    $cbcart_nonce = isset($_POST['cbcart_send_test_msg_nonce']) ? sanitize_text_field(wp_unslash($_POST['cbcart_send_test_msg_nonce'])) : '';
    if (!wp_verify_nonce($cbcart_nonce, 'cbcart_send_test_msg')) {
        $cbcart_legit = false;
    }
    if (!$cbcart_legit) {
        wp_safe_redirect(add_query_arg());
        exit();
    }
    $cbcart_to_number = isset($_POST['cbcart_tonumber']) ? sanitize_text_field(wp_unslash($_POST['cbcart_tonumber'])) : '';
    $cbcart_template_id = isset($_POST['cbcart_template']) ? sanitize_text_field(wp_unslash($_POST['cbcart_template'])) : '';
    $cbcart_language_code = isset($_POST['cbcart_langcode']) ? sanitize_text_field(wp_unslash($_POST['cbcart_langcode'])) : '';
    $cbcart_message = esc_html("Hi, thank you for opt-in to receive notifications from us on WhatsApp. We will send you regular updates on the progress of your order. If you wish to unsubscribe, please reply with STOP. Have a good day",'cartbox-messaging-widgets');
    $cbcart_flag = 1;

    if (empty($cbcart_to_number)) {
        $cbcart_flag = 0;
        $cbcart_error_mobileno = '';
        $cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible">';
        $cbcart_error_mobileno .= '<p>' . esc_html('Please Enter Mobile Number.','cartbox-messaging-widgets') . '</p>';
        $cbcart_error_mobileno .= '</div>';
        echo wp_kses_post($cbcart_error_mobileno);
    } elseif (strlen($cbcart_to_number) < 7) {
        $cbcart_flag = 0;
        $cbcart_error_mobileno = '';
        $cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible">';
        $cbcart_error_mobileno .= '<p>' . esc_html('Please enter minimum 7 digits number.','cartbox-messaging-widgets') . '</p>';
        $cbcart_error_mobileno .= '</div>';
        echo wp_kses_post($cbcart_error_mobileno);
    }
    if ($cbcart_flag == 1) {
        if (!empty(get_option('cbcart_testmessagesetup')) || empty(get_option('cbcart_testmessagesetup'))) {
            $cbcart_update_arr = array(
                'cbcart_tonumber' => $cbcart_to_number,
                'cbcart_message' => $cbcart_message,
                'cbcart_testmessageid' => $cbcart_template_id,
                'cbcart_langcode' => $cbcart_language_code,
                'cbcart_checktest' => "done",
            );
            $cbcart_result = update_option('cbcart_testmessagesetup', wp_json_encode($cbcart_update_arr));
            $cbcart_testresponse = cbcart::cbcart_sendtestmessage();
            if ($cbcart_testresponse == "true") {
                $cbcart_success = '';
                $cbcart_success .= '<div class="notice notice-success is-dismissible">';
                $cbcart_success .= '<p>' . esc_html('Test Message send successfully!','cartbox-messaging-widgets') . '</p>';
                $cbcart_success .= '</div>';
                echo wp_kses_post($cbcart_success);
            } else if ($cbcart_testresponse == "200") {
                $cbcart_success = '';
                $cbcart_success .= '<div class="notice notice-success is-dismissible">';
                $cbcart_success .= '<p>' . esc_html('Test Message send successfully!','cartbox-messaging-widgets') . '</p>';
                $cbcart_success .= '</div>';
                echo wp_kses_post($cbcart_success);
            } else if ($cbcart_testresponse == "notsent") {
                $cbcart_error_message = '';
                $cbcart_error_message .= '<div class="notice notice-error is-dismissible">';
                $cbcart_error_message .= '<p>' . esc_html('Message Sending failed. Either your WhatsApp phone number ID and Token was wrong or the Template name and language you selected is wrong.','cartbox-messaging-widgets') . '</p>';
                $cbcart_error_message .= '</div>';
                echo wp_kses_post($cbcart_error_message);
            } else {
                $cbcart_error_message = '';
                $cbcart_error_message .= '<div class="notice notice-error is-dismissible">';
                $cbcart_error_message .= '<p>' . esc_html('Message Sending failed.','cartbox-messaging-widgets') . '</p>';
                $cbcart_error_message .= '</div>';
                echo wp_kses_post($cbcart_error_message);
            }
        }
    }
}
$cbcart_abandoned_message = esc_html("Hi TestName, We noticed you didn't finish your order on {storename}.\n\nVisit {siteurl} to complete your order.  \n\nThanks, {storename}.",'cartbox-messaging-widgets');
$cbcart_order_admin_message = esc_html("Hi TestName, an order is placed on {storename} at {orderdate}.\n\nThe order is for TestProduct and order amount is $10.\n\nCustomer details are: Test Customer\n\nTestcustomer@gmail.com",'cartbox-messaging-widgets');
$cbcart_order_customer_message = esc_html("Hi TestName, your TestProduct order of $10 has been placed. \n\nWe will keep you updated about your order status.\n\n{storename}",'cartbox-messaging-widgets');
$cbcart_data1 = get_option('cbcart_dndsettings');
$cbcart_data1 = json_decode($cbcart_data1);
$cbcart_data1= sanitize_option("cbcart_dndsettings",$cbcart_data1);
if ($cbcart_data1 != "") {
    $cbcart_is_dnd_enable = $cbcart_data1->cbcart_is_dnd_enable;
    $cbcart_dnd_from = $cbcart_data1->cbcart_dnd_from;
    $cbcart_dnd_to = $cbcart_data1->cbcart_dnd_to;
} else {
    $cbcart_is_dnd_enable = "";
    $cbcart_dnd_from = "";
    $cbcart_dnd_to = "";
}
if (isset($cbcart_time1)) {
    if ($cbcart_time1 == 'cbcart_select_hour') {
        $cbcart_trigger = cbcart_convertminutestohour($cbcart_trigger);
    }

    if ($cbcart_time1 == 'cbcart_select_day') {
        $cbcart_trigger = cbcart_convertminutestoday($cbcart_trigger);
    }
}
$cbcart_login = esc_url("<?php echo esc_url( cbcart_product_page_url); ?>");

//on whatsapp configuratin upate
$cbcart_data = get_option('cbcart_premiumsettings');
$cbcart_data = json_decode($cbcart_data);
$cbcart_data= sanitize_option("cbcart_premiumsettings",$cbcart_data);

if ($cbcart_data != "") {
    $cbcart_wabaid = $cbcart_data->cbcart_wabaid;
    $cbcart_phoneid = $cbcart_data->cbcart_phoneid;
    $cbcart_token = $cbcart_data->cbcart_token;
}
if (!empty($_POST['cbcart_updatecloudbutton'])) {
    $cbcart_legit = true;
    if (!isset($_POST['cbcart_update_form2_nonce'])) {
        $cbcart_legit = false;
    }
    $cbcart_nonce = isset($_POST['cbcart_update_form2_nonce']) ? sanitize_text_field(wp_unslash($_POST['cbcart_update_form2_nonce'])) : '';
    if (!wp_verify_nonce($cbcart_nonce, 'cbcart_update_form2')) {
        $cbcart_legit = false;
    }
    if (!$cbcart_legit) {
        wp_safe_redirect(add_query_arg());
        exit();
    }
    $cbcart_wabaid = isset($_POST['cbcart_wabaid']) ? sanitize_text_field(wp_unslash($_POST['cbcart_wabaid'])) : '';
    $cbcart_phoneid = isset($_POST['cbcart_phoneid']) ? sanitize_text_field(wp_unslash($_POST['cbcart_phoneid'])) : '';
    $cbcart_token = isset($_POST['cbcart_token']) ? sanitize_text_field(wp_unslash($_POST['cbcart_token'])) : '';
    $cbcart_flag = 1;
    if (empty($cbcart_wabaid)) {
        $cbcart_flag = 0;
        $cbcart_error_mobileno = '';
        $cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible">';
        $cbcart_error_mobileno .= '<p>' . esc_html('Please Enter WhatsApp Business Account ID.','cartbox-messaging-widgets') . '</p>';
        $cbcart_error_mobileno .= '</div>';
        echo wp_kses_post($cbcart_error_mobileno);
    } elseif (strlen($cbcart_wabaid) < 15 || strlen($cbcart_wabaid) > 15) {
        $cbcart_flag = 0;
        $cbcart_error_mobileno = '';
        $cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible">';
        $cbcart_error_mobileno .= '<p>' . esc_html('Please Enter atleast 15 digit WhatsApp Business Account ID.','cartbox-messaging-widgets') . '</p>';
        $cbcart_error_mobileno .= '</div>';
        echo wp_kses_post($cbcart_error_mobileno);
    } elseif (preg_match('#[^0-9]#', $cbcart_wabaid)) {
        $cbcart_flag = 0;
        $cbcart_error_mobileno = '';
        $cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible">';
        $cbcart_error_mobileno .= '<p>' . esc_html('Please Enter only numbers in WhatsApp Business Account ID.','cartbox-messaging-widgets') . '</p>';
        $cbcart_error_mobileno .= '</div>';
        echo wp_kses_post($cbcart_error_mobileno);
    }
    if (empty($cbcart_phoneid)) {
        $cbcart_flag = 0;
        $cbcart_error_mobileno = '';
        $cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible">';
        $cbcart_error_mobileno .= '<p>' . esc_html('Please Enter Facebook cloud Phone number ID.','cartbox-messaging-widgets') . '</p>';
        $cbcart_error_mobileno .= '</div>';
        echo wp_kses_post($cbcart_error_mobileno);
    } elseif (strlen($cbcart_phoneid) < 15 || strlen($cbcart_phoneid) > 15) {
        $cbcart_flag = 0;
        $cbcart_error_mobileno = '';
        $cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible">';
        $cbcart_error_mobileno .= '<p>' . esc_html('Please Enter atleast 15 digit Facebook cloud Phone number ID .','cartbox-messaging-widgets') . '</p>';
        $cbcart_error_mobileno .= '</div>';
        echo wp_kses_post($cbcart_error_mobileno);
    } elseif (preg_match('#[^0-9]#', $cbcart_phoneid)) {
        $cbcart_flag = 0;
        $cbcart_error_mobileno = '';
        $cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible">';
        $cbcart_error_mobileno .= '<p>' . esc_html('Please Enter only numbers in Facebook cloud Phone number ID.','cartbox-messaging-widgets') . '</p>';
        $cbcart_error_mobileno .= '</div>';
        echo wp_kses_post($cbcart_error_mobileno);
    }
    if (empty($cbcart_token)) {
        $cbcart_flag = 0;
        $cbcart_error_mobileno = '';
        $cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible">';
        $cbcart_error_mobileno .= '<p>' . esc_html('Please Enter Facebook cloud Permanent Token.','cartbox-messaging-widgets') . '</p>';
        $cbcart_error_mobileno .= '</div>';
        echo wp_kses_post($cbcart_error_mobileno);
    }
    if ($cbcart_flag == 1) {
        $cbcart_update_arr = array(
            'cbcart_wabaid' => $cbcart_wabaid,
            'cbcart_phoneid' => $cbcart_phoneid,
            'cbcart_token' => $cbcart_token,
        );
        $cbcart_result = update_option('cbcart_premiumsettings', wp_json_encode($cbcart_update_arr));
        $cbcart_success = '';
        $cbcart_success .= '<div class="notice notice-success is-dismissible">';
        $cbcart_success .= '<p>' . esc_html('Details update successfully .','cartbox-messaging-widgets') . '</p>';
        $cbcart_success .= '</div>';
        echo wp_kses_post($cbcart_success);
    }
}
$cbcart_logo = CBCART_DIR . CBCART_DOMAIN . esc_url('/admin/images/cbcart-LogoNew-black.png');
$cbcart_whatsapp_link = esc_url('https://www.cartbox.net/blog/how-to-setup-whatsapp-cloud-api/#step18');
$cbcart_token_link = esc_url('https://www.cartbox.net/blog/how-to-generate-the-permanent-token-in-cloud-api/')
?>
<div class="container">
    <div>
    <img src="<?php echo esc_url($cbcart_logo,'cartbox-messaging-widgets'); ?>" class="cbcart_imgclass">
        <br>
        <label class="cbcart-label3 text-capitalize m-0"><b><?php esc_html_e('cartbox Settings','cartbox-messaging-widgets') ?></b></label>
    </div>
    <div class="tabbable boxed parentTabs m-2">
        <div id="cbcart_setting_tabs" class="cbcart_nav cbcart_nav_settings">
            <ul class="nav nav-tabs cbcart_nav_tabs">
                <li><a href="#cbcart_set1" class="active cbcart_nav_text"><?php esc_html_e('Abandoned Cart Settings','cartbox-messaging-widgets'); ?></a>
                </li>
                <?php if ($cbcart_checkplan === "2" || $cbcart_checkplan === "3" || $cbcart_checkplan==="4") { ?>
                    <li><a href="#cbcart_set3" class="cbcart_nav_text"><?php esc_html_e('WhatsApp Configuration','cartbox-messaging-widgets'); ?></a>
                    </li>
                <?php } ?>
                <li><a href="#cbcart_set2" class="cbcart_nav_text"><?php esc_html_e('Test Message','cartbox-messaging-widgets'); ?></a>
                </li>
                <?php if ($cbcart_checkplan!="4") { ?>
                <li><a href="#cbcart_set4" class="cbcart_nav_text"><?php esc_html_e('View Profile','cartbox-messaging-widgets'); ?></a>
                </li>
                <?php } ?>
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane fade active in show" id="cbcart_set1">
                <form class="form_div" method="post" name="form1">
                    <div class="card cbcart_card w-75 cbcart_settings_card">
                        <div class="d-flex justify-content-between ">
                            <label class="cbcart_sub_label text-capitalize"> <?php esc_html_e('Enable abandoned cart','cartbox-messaging-widgets'); ?></label>
                            <label class="cbcart_switch">
                                <input type="checkbox" name="cbcart_ac_enable" id="cbcart_ac_enable" value="checked" <?php if ($cbcart_ac_enable == "checked") { ?> checked="checked" <?php } ?>>
                                <span class="cbcart_slider cbcart_round"></span>
                            </label>
                        </div>
                        <hr>
                        <div>
                            <label class="cbcart-label3 m-0"><?php esc_html_e('Check for new abandoned cart','cartbox-messaging-widgets'); ?></label>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <input type="number" name="cbcart_trigger_1" id="cbcart_trigger_setting_1" required value="<?php
                                printf(
                                    esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                    esc_html($cbcart_trigger)
                                );
                                ?>" class="cbcart_input_field">
                                <label id="cbcart_error_trigger" class="cbcart_error"><?php esc_html_e('Please enter the abandoned time.','cartbox-messaging-widgets'); ?></label>
                            </div>
                            <div class="col-6">
                                <select class="cbcart_input_field" name="cbcart_select_time1" value="cbcart_select_time1" id="cbcart_trigger_time1" required>
                                    <option value="cbcart_select_minute" name="cbcart_select_time1" id="cbcart_select_minute" <?php printf(
                                        esc_attr('selected="selected" %s', 'cartbox-messaging-widgets'),
                                        'cbcart_select_minute' === esc_attr($cbcart_time1, 'cartbox-messaging-widgets') ? '' : 'disabled'
                                    ); ?>>
                                        <?php esc_html_e('Minute', 'cartbox-messaging-widgets'); ?>
                                    </option>

                                    <option value="cbcart_select_hour" name="cbcart_select_time1" id="cbcart_select_hour" <?php printf(
                                        esc_attr('selected="selected" %s', 'cartbox-messaging-widgets'),
                                        'cbcart_select_hour' === esc_attr($cbcart_time1, 'cartbox-messaging-widgets') ? '' : 'disabled'
                                    ); ?>>
                                        <?php esc_html_e('Hour', 'cartbox-messaging-widgets'); ?>
                                    </option>

                                    <option value="cbcart_select_day" name="cbcart_select_time1" id="cbcart_select_day" <?php printf(
                                        esc_attr('selected="selected" %s', 'cartbox-messaging-widgets'),
                                        'cbcart_select_day' === esc_attr($cbcart_time1, 'cartbox-messaging-widgets') ? '' : 'disabled'
                                    ); ?>>
                                        <?php esc_html_e('Day', 'cartbox-messaging-widgets'); ?>
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card cbcart_card w-75 cbcart_settings_card">
                        <div class="d-flex justify-content-between ">
                            <label class="cbcart_sub_label text-capitalize"> <?php esc_html_e('Enable do not send messages','cartbox-messaging-widgets'); ?></label>
                            <label class="cbcart_switch">
                                <input type="checkbox" name="cbcart_dnd_enable" class="cbcart_check-ac" id="cbcart_dnd_enable" value="checked" <?php if ($cbcart_is_dnd_enable == "checked") { ?> checked="checked" <?php } ?>>
                                <span class="cbcart_slider cbcart_round"></span>
                            </label>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-6">
                                <div>
                                    <label class="cbcart-label3 m-0"><?php esc_html_e('Start Time','cartbox-messaging-widgets'); ?></label>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <input type="time" name="cbcart_dnd_from" id="cbcart_dnd_from" required step="2" value="<?php
                                        printf(
                                            esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                            esc_html($cbcart_dnd_from)
                                        );
                                        ?>">
                                    </div>
                                    <div class="col-6">
                                        <div class=" cbcart_hourslabel"> <?php esc_html_e('Hour','cartbox-messaging-widgets'); ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div>
                                    <label class="cbcart-label3 m-0"><?php esc_html_e('End Time','cartbox-messaging-widgets'); ?></label>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <input type="time" name="cbcart_dnd_to" id="cbcart_dnd_to" required step="2" value="<?php
                                        printf(
                                            esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                            esc_html($cbcart_dnd_to)
                                        );
                                     ?>">
                                    </div>
                                    <div class="col-6">
                                        <div class="cbcart_hourslabel"> <?php esc_html_e('Hour','cartbox-messaging-widgets'); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <label><?php esc_html_e('The message will not go between the selected hours to comply with certain countries rules.','cartbox-messaging-widgets'); ?></label>

                            <h6 class="cbcart_godndMsg"><?php if($cbcart_dnd_from===""){ esc_html_e('* The Do not Send Message is enable','cartbox-messaging-widgets');}
                                else{ esc_html_e('* Abandoned messages will not go from ','cartbox-messaging-widgets'); ?>
                                <?php
                                    printf(
                                        esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                        esc_html($cbcart_dnd_from)
                                    );
                                     ?><?php esc_html_e(' to ','cartbox-messaging-widgets'); ?><?php
                                    printf(
                                        esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                        esc_html($cbcart_dnd_to)
                                    );
                                } ?></h6>
                            <h6 class="cbcart_notdndMsg"><?php esc_html_e('* The Do not Send Message is disable','cartbox-messaging-widgets'); ?></h6>
                        </div>
                    </div>
                    <div class="row">
                        <?php wp_nonce_field('cbcart_update_form', 'cbcart_update_form_nonce'); ?>
                        <div class="col-md-12 mt-5 text-center">
                            <div class="w-100 m-auto">
                                <input type="submit" class="btn cbcart_btn-theme2" name="cbcart_updatebutton" value="<?php esc_attr_e('Submit','cartbox-messaging-widgets')?>" onclick="cbcart_FormValidation()"/>
                            </div>
                        </div>
                        <div class="col-md-12  mt-5 text-center">
                            <h5><?php esc_html_e('If you have already purchased the plan, just click on the button and refresh.','cartbox-messaging-widgets'); ?>
                            </h5>
                        </div>
                    </div>
                </form>
            </div>
            <div class="tab-pane fade" id="cbcart_set3">
                <div class="card cbcart_card w-75">
                <form class="form_div" method="post" name="form2">
                    <div>
                        <label class="cbcart_sub_label mt-3"> <?php esc_html_e( 'Your Facebook Cloud API Details','cartbox-messaging-widgets' ); ?></label>
                    </div>
                    <hr  class="my-4">
                    <div class="row">
                        <div class="col-6">
                            <label class="cbcart_label3 text-capitalize mb-1" id="cbcart_waba_idlabel"><a href="<?php
                                printf(
                                    esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                    esc_html($cbcart_whatsapp_link)
                                );
                                ?>" class="text-black" target="_blank"><?php esc_html_e('Enter your WhatsApp Business Account ID','cartbox-messaging-widgets'); ?></a>
                                <sup class="cbcart_required_star"> *</sup><br>
                            </label>
                            <input type="number" name="cbcart_wabaid" id="cbcart_wabaid" placeholder="<?php esc_html_e('WhatsApp Business Account ID ','cartbox-messaging-widgets'); ?>" autocomplete="off" class="cbcart_input_field" value="<?php
                            printf(
                                esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                esc_html($cbcart_wabaid)
                            );
                            ?>" readonly="readonly" required>
                            <label id="cbcart_wabaid_error" class="cbcart_error"><?php esc_html_e('Please enter Valid WhatsApp Business Account ID.','cartbox-messaging-widgets'); ?></label>
                        </div>
                        <div class="col-6">
                            <label class="cbcart_label3 mb-1 text-capitalize" id="cbcart_phonenumb_idlabel"><a href="<?php
                                printf(
                                    esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                    esc_html($cbcart_whatsapp_link)
                                );
                                 ?>" class="text-black" target="_blank"><?php esc_html_e('Enter your Facebook Cloud Phone No. ID ','cartbox-messaging-widgets'); ?></a>
                                <sup class="cbcart_required_star"> *</sup><br>
                            </label>
                            <input type="number" name="cbcart_phoneid" id="cbcart_phoneid" value="<?php
                            printf(
                                esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                esc_html($cbcart_phoneid)
                            );
                            ?>" autocomplete="off" class="cbcart_input_field" placeholder="<?php esc_html_e('Enter Your Facebook Cloud Phone No. Id','cartbox-messaging-widgets'); ?>" readonly="readonly" required>
                            <label id="cbcart_phonenoid_error" class="cbcart_error"><?php esc_html_e('Please enter Valid Phone ID.','cartbox-messaging-widgets'); ?></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mt-5">
                            <label class="cbcart_label3 mb-1 text-capitalize" id="cbcart_tokenlabel"><a href="<?php
                                printf(
                                    esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                    esc_html($cbcart_token_link)
                                );
                                 ?>" class="text-black " target="_blank"><?php esc_html_e('Enter your Facebook Cloud Permanent Token ID ','cartbox-messaging-widgets'); ?></a>
                                <sup class="cbcart_required_star"> *</sup><br>
                            </label>
                            <textarea name="cbcart_token" id="cbcart_token" class="cbcart_input_field cbcart_input_area" rows="4" placeholder="<?php esc_html_e('Enter Your Permanent Token','cartbox-messaging-widgets'); ?>" readonly="readonly" required><?php
                                printf(
                                    esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                    esc_html($cbcart_token)
                                );
                             ?></textarea>
                            <label id="cbcart_phoneid_error" class="cbcart_error"><?php esc_html_e('Please enter Valid Token.','cartbox-messaging-widgets'); ?></label>
                        </div>
                    </div>
                    <?php if($cbcart_checkplan==="4"){ ?>
                    <div class="row">
                        <div class="col-12">
                            <?php wp_nonce_field( 'cbcart_reset', 'cbcart_reset_nonce' ); ?>
                            <button type="submit" name="cbcart_reset" class="cbcart_btn_blank bg-white" onclick="return cbcart_reset_alert()"><?php esc_html_e('Change your number.','cartbox-messaging-widgets') ?></button>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="row">
                        <?php wp_nonce_field('cbcart_update_form2', 'cbcart_update_form2_nonce'); ?>
                        <div class="col-md-12 mt-5 text-center">
                            <div class="w-100 m-auto">
                                <input type="submit" class="btn cbcart_btn-theme2" name="cbcart_updatecloudbutton" value="<?php esc_attr_e("Submit",'cartbox-messaging-widgets') ?>" onclick="cbcart_FormValidation()"/>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
            </div>
            <div class="tab-pane fade" id="cbcart_set2">
                <div class="card w-75 cbcart_card" id="cbcart_testing_tab">
                    <form class="cbcart_form_div" method="post" name="form3" id="cbcart_form3">
                        <div class="container-fluid cbcart_max-width-600 mt-4">
                            <div class="row text-center">
                                <h3 class="cbcart_sub-title"><?php esc_html_e('Try Out Sending Test Message','cartbox-messaging-widgets'); ?></h3>
                            </div>
                            <div class="row mb-3 mt-4">
                                <div class="col-12">
                                    <label class="cbcart-lbl"><?php esc_html_e('Enter the number where we will send test message to try out','cartbox-messaging-widgets'); ?>
                                        <sup class="cbcart_required_star"> *</sup></label>
                                    <input type="hidden" name="cbcart_template1">
                                </div>
                                <div class="col-12">
                                    <input type="text" name="cbcart_tonumber" onClick="this.setSelectionRange(0, this.value.length)" autocomplete="off" class=' cbcart_input_field mb-2' maxlength="15" onpaste="return false" onkeypress="return isNumber(event)" id="cbcart_tonumber" placeholder="<?php esc_html_e('Enter Mobile Number with country code.Do not use 0 or +.','cartbox-messaging-widgets'); ?>" required/>
                                    <label id="cbcart_error_mobileno" class="cbcart_error"><?php esc_html_e('Please enter correct Mobile number.','cartbox-messaging-widgets'); ?></label>
                                    <label id="cbcart_phonemsg1" class="cbcart_test_lbl"><?php esc_html_e('Please enter minimum 7 digits number.','cartbox-messaging-widgets'); ?></><br/>
                                </div>
                            </div>
                            <?php if ($cbcart_checkplan === "2" || $cbcart_checkplan === "3" || $cbcart_checkplan==="4") { ?>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label class="cbcart-lbl"><?php esc_html_e('Enter Template Name','cartbox-messaging-widgets'); ?>
                                            <sup class="cbcart_required_star"> *</sup></label>
                                        <input type="hidden" name="cbcart_template1">
                                    </div>
                                    <div class="col-12">
                                        <input type="text" name="cbcart_template" id="cbcart_template" value="<?php
                                        printf(
                                            esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                            esc_html($cbcart_template_id)
                                        );
                                       ?>" autocomplete="off" maxlength="32" class="cbcart_input_field"  required>
                                        <label id="cbcart_error_username" class="cbcart_error"><?php esc_html_e('Please enter template name properly.','cartbox-messaging-widgets'); ?></label>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label class="cbcart-lbl"><?php esc_html_e('Enter Language Code','cartbox-messaging-widgets'); ?><sup class="cbcart_required_star"> *</sup></label>
                                        <input type="hidden" name="cbcart_password1">
                                    </div>
                                    <div class="col-12">
                                        <input type="text" name="cbcart_langcode" id="cbcart_langcode" value="<?php
                                        printf(
                                            esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                            esc_html($cbcart_language_code)
                                        );
                                         ?>" autocomplete="off" maxlength="32" class="cbcart_input_field" required>
                                        <label id="cbcart_error_password" class="cbcart_error"><?php esc_html_e('Please enter language code.','cartbox-messaging-widgets'); ?></label>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php wp_nonce_field('cbcart_send_test_msg', 'cbcart_send_test_msg_nonce'); ?>
                            <div class="col-12 text-center mt-4">
                                <button type="submit" class="btn cbcart_btn-theme2" name="cbcart_test1"><?php esc_html_e('Send Test Message','cartbox-messaging-widgets'); ?></button>
                            </div>
                            <?php if ($cbcart_checkplan === "2" || $cbcart_checkplan === "3" || $cbcart_checkplan==="4") { ?>
                                <div class="col-12 text-center mt-4">
                                    <?php esc_html_e('A test message will be sent with our template as “Hello_World” in “en_us” language. If you wish to try a different template with a different name and language, you can check our options. To get your template name and code,','cartbox-messaging-widgets') ?>
                                    <br>
                                    <a href="https://business.facebook.com/wa/manage/message-templates/" target="_blank"><?php esc_html_e(' Click here','cartbox-messaging-widgets') ?></a><?php esc_html_e(' to get your template name and code','cartbox-messaging-widgets') ?>
                                </div>
                            <?php } ?>
                        </div>
                    </form>
                </div>
            </div>
            <div class="tab-pane fade" id="cbcart_set4">
                <form class="cbcart_form_div cbcart_wabasetting_tab mt-4" method="post" name="form4" id="cbcart_form4">
                    <div class="row mb-5">
                        <div class="col-6">
                            <label for="" class="cbcart_sub_label mb-3"><?php esc_html_e('E-mail address','cartbox-messaging-widgets'); ?> </label>
                            <span class="cbcart_required_star">*</span><br/>
                            <input type="text" name="cbcart_email" id="cbcart_email" value="<?php
                            printf(
                                esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                esc_html($cbcart_email)
                            );
                             ?>" class="cbcart_input_field" required>
                            <label id="cbcart_error_email" class="cbcart_error"><?php esc_html_e('Please enter Valid E-mail ID.','cartbox-messaging-widgets'); ?></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <label class="cbcart_sub_label mb-3"><?php esc_html_e('Mobile Number (from which you want to send message) ','cartbox-messaging-widgets');?></label><span class="cbcart_required_star">*</span>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-6">
                            <input type="text" name="cbcart_mobileno" id="cbcart_mobileno" onClick="this.setSelectionRange(0, this.value.length)" autocomplete="off" class="input-line cbcart_input_field" maxlength="15" onpaste="return false" onkeypress="return isNumber(event)" required readonly="readonly" value="<?php
                            printf(
                                esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                esc_html($cbcart_from_number)
                            );
                            ?>">
                            <label id="cbcart_phonemsg" class="cbcart_test_lbl"></label><br/>
                            <label id="cbcart_mobile_error" class="cbcart_error"><?php esc_html_e('Please enter correct Mobile number.','cartbox-messaging-widgets'); ?></label></div>
                        <div class="col-6">
                            <?php if ($cbcart_checkplan != "1") { ?>
                                <?php wp_nonce_field( 'cbcart_reset', 'cbcart_reset_nonce' ); ?>
                                <button type="submit" name="cbcart_reset" class="cbcart_btn_blank" onclick="return cbcart_reset_alert()"><?php esc_html_e('Change your number.','cartbox-messaging-widgets') ?></button>
                            <?php } else { ?>
                                <label class="cbcart_pensil_icon "><?php esc_html_e('You are using free version of plugin.you can not change number.','cartbox-messaging-widgets') ?>
                                    <br><?php esc_html_e(' if you have already paid to upgrade the plugin,','cartbox-messaging-widgets') ?>
                                    <?php wp_nonce_field( 'cbcart_reset', 'cbcart_reset_nonce' ); ?>
                                    <button type="submit" name="cbcart_reset" class="cbcart_btn_blank" onclick="return cbcart_reset_alert()"><?php esc_html_e('setup your new number now.','cartbox-messaging-widgets') ?></button>
                                </label>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="row">
                        <?php wp_nonce_field('cbcart_update_form', 'cbcart_update_form_nonce'); ?>
                        <div class="col-md-12 mt-5 text-center">
                            <div class="w-100 m-auto">
                                <input type="submit" class="btn cbcart_btn-theme2" name="cbcart_updatesettings" value="<?php esc_attr_e("Submit",'cartbox-messaging-widgets') ?>" onclick="cbcart_FormValidation()"/>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
