<!-- for dashboard tab -->
<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    $cbcart_data                  = get_option('cbcart_abandonedsettings');
    $cbcart_data                  = json_decode($cbcart_data);
    $cbcart_data= sanitize_option(  "cbcart_abandonedsettings",$cbcart_data );

if ($cbcart_data!="") {
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
    $cbcart_trigger = "";
    $cbcart_time1 ="";
    $cbcart_trigger2 = "";
    $cbcart_time2 ="";
    $cbcart_trigger3 = "";
    $cbcart_time3 ="";
    $cbcart_trigger4 = "";
    $cbcart_time4 = "";
    $cbcart_trigger5 = "";
    $cbcart_time5 = "";
    $cbcart_ac_enable ="";
    $cbcart_message1_enable = "";
    $cbcart_message2_enable = "";
    $cbcart_message3_enable = "";
    $cbcart_message4_enable ="";
    $cbcart_message5_enable ="";
    $cbcart_ac_message ="";
    $cbcart_ac_template_name = "";
    $cbcart_ac_template_lang = "";
    $cbcart_ac_template_varcount = "";
    $cbcart_ac_message2 = "";
    $cbcart_ac_template2_name ="";
    $cbcart_ac_template2_lang = "";
    $cbcart_ac_template2_varcount = "";
    $cbcart_ac_message3 = "";
    $cbcart_ac_template3_name = "";
    $cbcart_ac_template3_lang = "";
    $cbcart_ac_template3_varcount = "";
    $cbcart_ac_message4 ="";
    $cbcart_ac_template4_name = "";
    $cbcart_ac_template4_lang = "";
    $cbcart_ac_template4_varcount = "";
    $cbcart_ac_message5 = "";
    $cbcart_ac_template5_name ="";
    $cbcart_ac_template5_lang = "";
    $cbcart_ac_template5_varcount = "";
    $cbcart_abandoned_image ="";
}

if (array_key_exists('cbcart_fromdatepickerbtn', $_POST) ) {
    $cbcart_legit = true;
    if (! isset($_POST['cbcart_dashboard_display_nonce']) ) {
        $cbcart_legit = false;
    }
    $cbcart_nonce = isset($_POST['cbcart_dashboard_display_nonce']) ? sanitize_text_field(wp_unslash($_POST['cbcart_dashboard_display_nonce'])) : '';
    if (! wp_verify_nonce($cbcart_nonce, 'cbcart_dashboard_display') ) {
        $cbcart_legit = false;
    }
    if (! $cbcart_legit ) {
        wp_safe_redirect(add_query_arg());
        exit();
    }
    $cbcart_fromdatepicker = isset($_POST['cbcart_fromdatepicker']) ? sanitize_text_field(wp_unslash($_POST['cbcart_fromdatepicker'])) : '';
    $cbcart_todatepicker   = isset($_POST['cbcart_todatepicker']) ? sanitize_text_field(wp_unslash($_POST['cbcart_todatepicker'])) : '';
}
global $wpdb;
$cbcart_table  = $wpdb->prefix . "cbcart_abandoneddetails";
$cbcart_table1 = $wpdb->prefix . "posts";
if (! isset($cbcart_fromdatepicker) && ! isset($cbcart_todatepicker) ) {
    $cbcart_fromdatepicker = isset($_POST['cbcart_fromdatepicker']) ? sanitize_text_field(wp_unslash($_POST['cbcart_fromdatepicker'])) : '';
    $cbcart_todatepicker   = isset($_POST['cbcart_todatepicker']) ? sanitize_text_field(wp_unslash($_POST['cbcart_todatepicker'])) : '';
    $cbcart_fromdatepicker = date("Y-m-d", time() - ( 86400 * 45 ));
    $cbcart_todatepicker   = date("Y-m-d", time() + ( 86400 * 1 ));
}
$cbcart_abandoned_cart_count  = $wpdb->get_results($wpdb->prepare(" SELECT COUNT(*) FROM " . $wpdb->prefix . "cbcart_abandoneddetails WHERE cbcart_status = '1' AND cbcart_last_access_time BETWEEN  %s AND %s ", $cbcart_fromdatepicker, $cbcart_todatepicker)); // db call ok; no-cache ok
$cbcart_abandoned_cart_count1 = json_decode(json_encode($cbcart_abandoned_cart_count), true);
$cbcart_array                 = json_decode(json_encode($cbcart_abandoned_cart_count1), true);
foreach ( $cbcart_array as $cbcart_arr2 ) {
    foreach ( $cbcart_arr2 as $cbcart_id => $cbcart_abandoned_cart_count1 ) {
        $cbcart_abandoned_cart_count1;
        if ($cbcart_abandoned_cart_count1 == "" ) {
            $cbcart_abandoned_cart_count1 = 0;
        }
    }
}
// query for recover count and amount
$cbcart_recovered_cart_count  = $wpdb->get_results($wpdb->prepare(" SELECT COUNT(*) FROM " . $wpdb->prefix . "cbcart_abandoneddetails WHERE cbcart_status = '2' AND cbcart_last_access_time BETWEEN  %s AND %s ", $cbcart_fromdatepicker, $cbcart_todatepicker)); // db call ok; no-cache ok
$cbcart_recovered_cart_count1 = json_decode(json_encode($cbcart_recovered_cart_count), true);
$cbcart_array                 = json_decode(json_encode($cbcart_recovered_cart_count1), true);
foreach ( $cbcart_array as $cbcart_arr2 ) {
    foreach ( $cbcart_arr2 as $cbcart_id => $cbcart_recovered_cart_count1 ) {
        $cbcart_recovered_cart_count1;
        if ($cbcart_recovered_cart_count1 == "" ) {
            $cbcart_recovered_cart_count1 = 0;
        }
    }
}
// Query for abandoned cart total amount
$cbcart_abandoned_cart_amount  = $wpdb->get_results($wpdb->prepare(" SELECT SUM(cbcart_cart_total) FROM " . $wpdb->prefix . "cbcart_abandoneddetails WHERE cbcart_status = '1' AND cbcart_last_access_time BETWEEN  %s AND %s ", $cbcart_fromdatepicker, $cbcart_todatepicker)); // db call ok; no-cache ok
$cbcart_abandoned_cart_amount1 = json_decode(json_encode($cbcart_abandoned_cart_amount), true);
$cbcart_array                  = json_decode(json_encode($cbcart_abandoned_cart_amount1), true);
foreach ( $cbcart_array as $cbcart_arr2 ) {
    foreach ( $cbcart_arr2 as $cbcart_id => $cbcart_abandoned_cart_amount1 ) {
        $cbcart_abandoned_cart_amount1;
        if ($cbcart_abandoned_cart_amount1 == "" ) {
            $cbcart_abandoned_cart_amount1 = 0;
        }
    }
}
// Query for recover cart total amount
$cbcart_recovered_cart_amount  = $wpdb->get_results($wpdb->prepare(" SELECT SUM(cbcart_cart_total) FROM " . $wpdb->prefix . "cbcart_abandoneddetails WHERE cbcart_status = '2' AND cbcart_last_access_time BETWEEN  %s AND %s ", $cbcart_fromdatepicker, $cbcart_todatepicker)); // db call ok; no-cache ok
$cbcart_recovered_cart_amount1 = json_decode(json_encode($cbcart_recovered_cart_amount), true);
$cbcart_array                  = json_decode(json_encode($cbcart_recovered_cart_amount1), true);
foreach ( $cbcart_array as $cbcart_arr2 ) {
    foreach ( $cbcart_arr2 as $cbcart_id => $cbcart_recovered_cart_amount1 ) {
        $cbcart_recovered_cart_amount1;
        if ($cbcart_recovered_cart_amount1 == "" ) {
            $cbcart_recovered_cart_amount1 = 0;
        }
    }
}
$cbcart_currency          = get_option('woocommerce_currency');
$cbcart_currency= sanitize_option(  "woocommerce_currency",$cbcart_currency );
if ($cbcart_currency==="") {
    $cbcart_currency="";
}
$cbcart_display_dashboard = $wpdb->get_results( $wpdb->prepare( " SELECT cbcart_id,cbcart_customer_first_name,cbcart_customer_last_name,cbcart_customer_mobile_no,cbcart_cart_total,cbcart_create_date_time,cbcart_status, cbcart_cart_json  FROM " . $wpdb->prefix . "cbcart_abandoneddetails WHERE cbcart_last_access_time BETWEEN  %s AND %s ORDER BY cbcart_id DESC ", $cbcart_fromdatepicker, $cbcart_todatepicker ) ); // db call ok; no-cache ok
$cbcart_smiley            = CBCART_DIR . CBCART_DOMAIN . '/admin/images/cbcart-SmileyImgs.png';
?>
<!--for message tab-->
<?php
$cbcart_ac_message_template1         = esc_html("Hi We noticed you didn't finish your order on {storename}.\n\nVisit {siteurl} to complete your order.  \n\nThanks, {storename}.",'cartbox-messaging-widgets');
$cbcart_ac_message_template2         = esc_html("{customername}, You left some items in your cart!\n\nWe wanted to make sure you had the chance to get what you need. \n\nContinue shopping: {storename}",'cartbox-messaging-widgets');
$cbcart_ac_message_template3         = esc_html("Hi we see you left few items in the cart at {siteurl}. Your items are waiting for you! Grab your favorites before they go out of stock. \n\nYour friends from {storename}",'cartbox-messaging-widgets');
$cbcart_ac_message_template4         = esc_html("{customername}, Your cart is waiting for you at {siteurl}\n\nComplete your purchase before someone else buys them! Click {siteurl} to finish your order now.\n \nThanks!\n {storename}",'cartbox-messaging-widgets');
$cbcart_ac_message_template5         = esc_html("Hello Did you forget to complete your order on {siteurl}. \nJust click the link to finish the order!\n\nYour friends at {storename}",'cartbox-messaging-widgets');
$cbcart_data                         = get_option('cbcart_usersettings');
$cbcart_data                         = json_decode($cbcart_data);
if ($cbcart_data!="") {
    $cbcart_isCustomizMessageOfAbandoned = $cbcart_data->cbcart_isCustomizMessageOfAbandoned;
    $cbcart_multiple_messages = $cbcart_data->cbcart_multiple_messages;
    $cbcart_isDisplayReport = $cbcart_data->cbcart_isDisplayReport;
    $cbcart_plan = $cbcart_data->cbcart_planid;
} else {
    $cbcart_isCustomizMessageOfAbandoned = "";
    $cbcart_multiple_messages = "";
    $cbcart_isDisplayReport = "";
    $cbcart_plan = "";
}
if (isset($_POST['cbcart_messagesave_premium']) ) {
    $cbcart_legit = true;
    if (! isset($_POST['cbcart_message_send_nonce']) ) {
        $cbcart_legit = false;
    }
    $cbcart_nonce = isset($_POST['cbcart_message_send_nonce']) ? sanitize_text_field(wp_unslash($_POST['cbcart_message_send_nonce'])) : '';
    if (! wp_verify_nonce($cbcart_nonce, 'cbcart_message_send') ) {
        $cbcart_legit = false;
    }
    if (! $cbcart_legit ) {
        wp_safe_redirect(add_query_arg());
        exit();
    }
    $cbcart_a_message        = isset($_POST['cbcart_message']) ? sanitize_textarea_field(wp_unslash($_POST['cbcart_message'])) : '';
    $cbcart_a_message2       = isset($_POST['cbcart_message2']) ? sanitize_textarea_field(wp_unslash($_POST['cbcart_message2'])) : '';
    $cbcart_a_message3       = isset($_POST['cbcart_message3']) ? sanitize_textarea_field(wp_unslash($_POST['cbcart_message3'])) : '';
    $cbcart_a_message4       = isset($_POST['cbcart_message4']) ? sanitize_textarea_field(wp_unslash($_POST['cbcart_message4'])) : '';
    $cbcart_a_message5       = isset($_POST['cbcart_message5']) ? sanitize_textarea_field(wp_unslash($_POST['cbcart_message5'])) : '';
    $cbcart_trigger          = isset($_POST['cbcart_trigger_1']) ? sanitize_textarea_field(wp_unslash($_POST['cbcart_trigger_1'])) : '';
    $cbcart_trigger2         = isset($_POST['cbcart_trigger_2']) ? sanitize_textarea_field(wp_unslash($_POST['cbcart_trigger_2'])) : '';
    $cbcart_trigger3         = isset($_POST['cbcart_trigger_3']) ? sanitize_textarea_field(wp_unslash($_POST['cbcart_trigger_3'])) : '';
    $cbcart_trigger4         = isset($_POST['cbcart_trigger_4']) ? sanitize_textarea_field(wp_unslash($_POST['cbcart_trigger_4'])) : '';
    $cbcart_trigger5         = isset($_POST['cbcart_trigger_5']) ? sanitize_textarea_field(wp_unslash($_POST['cbcart_trigger_5'])) : '';
    $cbcart_time1            = isset($_POST['cbcart_select_time1']) ? sanitize_textarea_field(wp_unslash($_POST['cbcart_select_time1'])) : '';
    $cbcart_time2            = isset($_POST['cbcart_select_time2']) ? sanitize_textarea_field(wp_unslash($_POST['cbcart_select_time2'])) : '';
    $cbcart_time3            = isset($_POST['cbcart_select_time3']) ? sanitize_textarea_field(wp_unslash($_POST['cbcart_select_time3'])) : '';
    $cbcart_time4            = isset($_POST['cbcart_select_time4']) ? sanitize_textarea_field(wp_unslash($_POST['cbcart_select_time4'])) : '';
    $cbcart_time5            = isset($_POST['cbcart_select_time5']) ? sanitize_textarea_field(wp_unslash($_POST['cbcart_select_time5'])) : '';
    $cbcart_a_template_name  = isset($_POST['cbcart_ac_template_name']) ? sanitize_text_field(wp_unslash($_POST['cbcart_ac_template_name'])) : '';
    $cbcart_a_template_lang  = isset($_POST['cbcart_ac_template_lang']) ? sanitize_text_field(wp_unslash($_POST['cbcart_ac_template_lang'])) : '';
    $cbcart_a_template2_name = isset($_POST['cbcart_ac_template2_name']) ? sanitize_text_field(wp_unslash($_POST['cbcart_ac_template2_name'])) : '';
    $cbcart_a_template2_lang = isset($_POST['cbcart_ac_template2_lang']) ? sanitize_text_field(wp_unslash($_POST['cbcart_ac_template2_lang'])) : '';
    $cbcart_a_template3_name = isset($_POST['cbcart_ac_template3_name']) ? sanitize_text_field(wp_unslash($_POST['cbcart_ac_template3_name'])) : '';
    $cbcart_a_template3_lang = isset($_POST['cbcart_ac_template3_lang']) ? sanitize_text_field(wp_unslash($_POST['cbcart_ac_template3_lang'])) : '';
    $cbcart_a_template4_name = isset($_POST['cbcart_ac_template4_name']) ? sanitize_text_field(wp_unslash($_POST['cbcart_ac_template4_name'])) : '';
    $cbcart_a_template4_lang = isset($_POST['cbcart_ac_template4_lang']) ? sanitize_text_field(wp_unslash($_POST['cbcart_ac_template4_lang'])) : '';
    $cbcart_a_template5_name = isset($_POST['cbcart_ac_template5_name']) ? sanitize_text_field(wp_unslash($_POST['cbcart_ac_template5_name'])) : '';
    $cbcart_a_template5_lang = isset($_POST['cbcart_ac_template5_lang']) ? sanitize_text_field(wp_unslash($_POST['cbcart_ac_template5_lang'])) : '';
    $cbcart_image            = isset($_POST['cbcart_image']) ? sanitize_textarea_field(wp_unslash($_POST['cbcart_image'])) : '';

    if ($cbcart_time1 == 'cbcart_select_hour' ) {
        $cbcart_trigger = cbcart_converthourtominutes($cbcart_trigger);
    }
    if ($cbcart_time2 == 'cbcart_select_hour' ) {
        $cbcart_trigger2 = cbcart_converthourtominutes($cbcart_trigger2);
    }
    if ($cbcart_time3 == 'cbcart_select_hour' ) {
        $cbcart_trigger3 = cbcart_converthourtominutes($cbcart_trigger3);
    }
    if ($cbcart_time4 == 'cbcart_select_hour' ) {
        $cbcart_trigger4 = cbcart_converthourtominutes($cbcart_trigger4);
    }
    if ($cbcart_time5 == 'cbcart_select_hour' ) {
        $cbcart_trigger5 = cbcart_converthourtominutes($cbcart_trigger5);
    }
    if ($cbcart_time1 == 'cbcart_select_day' ) {
        $cbcart_trigger = cbcart_convertdaytominutes($cbcart_trigger);
    }
    if ($cbcart_time2 == 'cbcart_select_day' ) {
        $cbcart_trigger2 = cbcart_convertdaytominutes($cbcart_trigger2);
    }
    if ($cbcart_time3 == 'cbcart_select_day' ) {
        $cbcart_trigger3 = cbcart_convertdaytominutes($cbcart_trigger3);
    }
    if ($cbcart_time4 == 'cbcart_select_day' ) {
        $cbcart_trigger4 = cbcart_convertdaytominutes($cbcart_trigger4);
    }
    if ($cbcart_time5 == 'cbcart_select_day' ) {
        $cbcart_trigger5 = cbcart_convertdaytominutes($cbcart_trigger5);
    }
    $cbcart_message1_enable = "";
    $cbcart_message2_enable = "";
    $cbcart_message3_enable = "";
    $cbcart_message4_enable = "";
    $cbcart_message5_enable = "";
    if (isset($_POST['cbcart_message1_enable']) ) {
        $cbcart_message1_enable = "checked";
    } else {
        $cbcart_message1_enable = "";
    }
    if (isset($_POST['cbcart_message2_enable']) ) {
        $cbcart_message2_enable = "checked";
    } else {
        $cbcart_message2_enable = "";
    }
    if (isset($_POST['cbcart_message3_enable']) ) {
        $cbcart_message3_enable = "checked";
    } else {
        $cbcart_message3_enable = "";
    }
    if (isset($_POST['cbcart_message4_enable']) ) {
        $cbcart_message4_enable = "checked";
    } else {
        $cbcart_message4_enable = "";
    }
    if (isset($_POST['cbcart_message5_enable']) ) {
        $cbcart_message5_enable = "checked";
    } else {
        $cbcart_message5_enable = "";
    }
    if (empty($cbcart_a_message) ) {
        $cbcart_a_message = $cbcart_ac_message;
    }
    if (empty($cbcart_a_message2) ) {
        $cbcart_a_message2 = $cbcart_ac_message2;
    }
    if (empty($cbcart_a_message3) ) {
        $cbcart_a_message3 = $cbcart_ac_message3;
    }
    if (empty($cbcart_a_message4) ) {
        $cbcart_a_message4 = $cbcart_ac_message4;
    }
    if (empty($cbcart_a_message5) ) {
        $cbcart_a_message5 = $cbcart_ac_message5;
    }
    if (empty($cbcart_a_template_name) ) {
        $cbcart_a_template_name = $cbcart_ac_template_name;
    }
    if (empty($cbcart_a_template2_name) ) {
        $cbcart_a_template2_name = $cbcart_ac_template2_name;
    }
    if (empty($cbcart_a_template3_name) ) {
        $cbcart_a_template3_name = $cbcart_ac_template3_name;
    }
    if (empty($cbcart_a_template4_name) ) {
        $cbcart_a_template4_name = $cbcart_ac_template4_name;
    }
    if (empty($cbcart_a_template5_name) ) {
        $cbcart_a_template5_name = $cbcart_ac_template5_name;
    }
    if (empty($cbcart_a_template_lang) ) {
        $cbcart_a_template_lang = $cbcart_ac_template_lang;
    }
    if (empty($cbcart_a_template2_lang) ) {
        $cbcart_a_template2_lang = $cbcart_ac_template2_lang;
    }
    if (empty($cbcart_a_template3_lang) ) {
        $cbcart_a_template3_lang = $cbcart_ac_template3_lang;
    }
    if (empty($cbcart_a_template4_lang) ) {
        $cbcart_a_template4_lang = $cbcart_ac_template4_lang;
    }
    if (empty($cbcart_a_template5_lang) ) {
        $cbcart_a_template5_lang = $cbcart_ac_template5_lang;
    }
    if (empty($cbcart_image) ) {
        $cbcart_image = $cbcart_abandoned_image;
    }
    $cbcart_update_option_arr = array(
    'cbcart_trigger_time'          => $cbcart_trigger,
    'cbcart_time1'                 => $cbcart_time1,
    'cbcart_trigger_time2'         => $cbcart_trigger2,
    'cbcart_time2'                 => $cbcart_time2,
    'cbcart_trigger_time3'         => $cbcart_trigger3,
    'cbcart_time3'                 => $cbcart_time3,
    'cbcart_trigger_time4'         => $cbcart_trigger4,
    'cbcart_time4'                 => $cbcart_time4,
    'cbcart_trigger_time5'         => $cbcart_trigger5,
    'cbcart_time5'                 => $cbcart_time5,
    'cbcart_ac_enable'             => $cbcart_ac_enable,
    'cbcart_message1_enable'       => $cbcart_message1_enable,
    'cbcart_message2_enable'       => $cbcart_message2_enable,
    'cbcart_message3_enable'       => $cbcart_message3_enable,
    'cbcart_message4_enable'       => $cbcart_message4_enable,
    'cbcart_message5_enable'       => $cbcart_message5_enable,
    'cbcart_ac_message'            => $cbcart_a_message,
    'cbcart_ac_template_name'      => $cbcart_a_template_name,
    'cbcart_ac_template_lang'      => $cbcart_a_template_lang,
    'cbcart_ac_template_varcount'  => $cbcart_ac_template_varcount,
    'cbcart_ac_message2'           => $cbcart_a_message2,
    'cbcart_ac_template2_name'     => $cbcart_a_template2_name,
    'cbcart_ac_template2_lang'     => $cbcart_a_template2_lang,
    'cbcart_ac_template2_varcount' => $cbcart_ac_template2_varcount,
    'cbcart_ac_message3'           => $cbcart_a_message3,
    'cbcart_ac_template3_name'     => $cbcart_a_template3_name,
    'cbcart_ac_template3_lang'     => $cbcart_a_template3_lang,
    'cbcart_ac_template3_varcount' => $cbcart_ac_template3_varcount,
    'cbcart_ac_message4'           => $cbcart_a_message4,
    'cbcart_ac_template4_name'     => $cbcart_a_template4_name,
    'cbcart_ac_template4_lang'     => $cbcart_a_template4_lang,
    'cbcart_ac_template4_varcount' => $cbcart_ac_template4_varcount,
    'cbcart_ac_message5'           => $cbcart_a_message5,
    'cbcart_ac_template5_name'     => $cbcart_a_template5_name,
    'cbcart_ac_template5_lang'     => $cbcart_a_template5_lang,
    'cbcart_ac_template5_varcount' => $cbcart_ac_template5_varcount,
    'cbcart_abandoned_image'       => $cbcart_image,
    );
    $result                   = update_option('cbcart_abandonedsettings', wp_json_encode($cbcart_update_option_arr));
    $cbcart_success           = '';
    $cbcart_success           .= '<div class="notice notice-success is-dismissible">';
    $cbcart_success           .= '<p>' . esc_html('Messages updated successfully!','cartbox-messaging-widgets') . '</p>';
    $cbcart_success           .= '</div>';
    echo wp_kses_post($cbcart_success);
}
function cbcart_reditect(){
    $cbcart_page = isset( $_REQUEST['page'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['page'] ) ) : '';
    wp_redirect( 'admin.php?page=' . $cbcart_page );
}
if(isset($_POST['cbcart_customise_btn1'])){
    $cbcart_legit   = true;
    if ( ! isset( $_POST['cbcart_customise_btn1_nounce'] ) ) {
        $cbcart_legit = false;
    }
    $nonce = isset( $_POST['cbcart_customise_btn1_nounce'] ) ? sanitize_text_field( wp_unslash( $_POST['cbcart_customise_btn1_nounce'] ) ) : '';
    if ( ! wp_verify_nonce( $nonce, 'cbcart_customise_btn1' ) ) {
        $cbcart_legit = false;
    }
    if ( ! $cbcart_legit ) {
        wp_safe_redirect( add_query_arg() );
        exit();
    }
    $cbcart_update_option_arr = array(
        'cbcart_template_num' => "ac_1",
        'cbcart_template_name' => $cbcart_ac_template_name,
        'cbcart_template_lang' => $cbcart_ac_template_lang,

    );
    $cbcart_result1 = update_option('cbcart_customisetemplate', wp_json_encode($cbcart_update_option_arr));
    cbcart_reditect();
}
if(isset($_POST['cbcart_customise_btn2'])){
    $cbcart_legit   = true;
    if ( ! isset( $_POST['cbcart_customise_btn2_nounce'] ) ) {
        $cbcart_legit = false;
    }
    $nonce = isset( $_POST['cbcart_customise_btn2_nounce'] ) ? sanitize_text_field( wp_unslash( $_POST['cbcart_customise_btn2_nounce'] ) ) : '';
    if ( ! wp_verify_nonce( $nonce, 'cbcart_customise_btn2' ) ) {
        $cbcart_legit = false;
    }
    if ( ! $cbcart_legit ) {
        wp_safe_redirect( add_query_arg() );
        exit();
    }
    $cbcart_update_option_arr = array(
        'cbcart_template_num' => "ac_2",
        'cbcart_template_name' => $cbcart_ac_template2_name,
        'cbcart_template_lang' => $cbcart_ac_template2_lang,

    );
    $cbcart_result1 = update_option('cbcart_customisetemplate', wp_json_encode($cbcart_update_option_arr));
    cbcart_reditect();

}
if(isset($_POST['cbcart_customise_btn3'])){
    $cbcart_legit   = true;
    if ( ! isset( $_POST['cbcart_customise_btn3_nounce'] ) ) {
        $cbcart_legit = false;
    }
    $nonce = isset( $_POST['cbcart_customise_btn3_nounce'] ) ? sanitize_text_field( wp_unslash( $_POST['cbcart_customise_btn3_nounce'] ) ) : '';
    if ( ! wp_verify_nonce( $nonce, 'cbcart_customise_btn3' ) ) {
        $cbcart_legit = false;
    }
    if ( ! $cbcart_legit ) {
        wp_safe_redirect( add_query_arg() );
        exit();
    }
    $cbcart_update_option_arr = array(
        'cbcart_template_num' => "ac_3",
        'cbcart_template_name' => $cbcart_ac_template3_name,
        'cbcart_template_lang' => $cbcart_ac_template3_lang,

    );
    $cbcart_result1 = update_option('cbcart_customisetemplate', wp_json_encode($cbcart_update_option_arr));
    cbcart_reditect();

}
if(isset($_POST['cbcart_customise_btn4'])){
    $cbcart_legit   = true;
    if ( ! isset( $_POST['cbcart_customise_btn4_nounce'] ) ) {
        $cbcart_legit = false;
    }
    $nonce = isset( $_POST['cbcart_customise_btn4_nounce'] ) ? sanitize_text_field( wp_unslash( $_POST['cbcart_customise_btn4_nounce'] ) ) : '';
    if ( ! wp_verify_nonce( $nonce, 'cbcart_customise_btn4' ) ) {
        $cbcart_legit = false;
    }
    if ( ! $cbcart_legit ) {
        wp_safe_redirect( add_query_arg() );
        exit();
    }
    $cbcart_update_option_arr = array(
        'cbcart_template_num' => "ac_4",
        'cbcart_template_name' => $cbcart_ac_template4_name,
        'cbcart_template_lang' => $cbcart_ac_template4_lang,

    );
    $cbcart_result1 = update_option('cbcart_customisetemplate', wp_json_encode($cbcart_update_option_arr));
    cbcart_reditect();

}
if(isset($_POST['cbcart_customise_btn5'])){
    $cbcart_legit   = true;
    if ( ! isset( $_POST['cbcart_customise_btn5_nounce'] ) ) {
        $cbcart_legit = false;
    }
    $nonce = isset( $_POST['cbcart_customise_btn5_nounce'] ) ? sanitize_text_field( wp_unslash( $_POST['cbcart_customise_btn5_nounce'] ) ) : '';
    if ( ! wp_verify_nonce( $nonce, 'cbcart_customise_btn5' ) ) {
        $cbcart_legit = false;
    }
    if ( ! $cbcart_legit ) {
        wp_safe_redirect( add_query_arg() );
        exit();
    }
    $cbcart_update_option_arr = array(
        'cbcart_template_num' => "ac_5",
        'cbcart_template_name' => $cbcart_ac_template5_name,
        'cbcart_template_lang' => $cbcart_ac_template5_lang,

    );
    $cbcart_result1 = update_option('cbcart_customisetemplate', wp_json_encode($cbcart_update_option_arr));
    cbcart_reditect();

}

$cbcart_data                  = get_option('cbcart_abandonedsettings');
$cbcart_data                  = json_decode($cbcart_data);
$cbcart_data= sanitize_option(  "cbcart_abandonedsettings",$cbcart_data);
if ($cbcart_data!="") {
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
    $cbcart_trigger = "";
    $cbcart_time1 ="";
    $cbcart_trigger2 = "";
    $cbcart_time2 ="";
    $cbcart_trigger3 = "";
    $cbcart_time3 ="";
    $cbcart_trigger4 = "";
    $cbcart_time4 = "";
    $cbcart_trigger5 = "";
    $cbcart_time5 = "";
    $cbcart_ac_enable ="";
    $cbcart_message1_enable = "";
    $cbcart_message2_enable = "";
    $cbcart_message3_enable = "";
    $cbcart_message4_enable ="";
    $cbcart_message5_enable ="";
    $cbcart_ac_message ="";
    $cbcart_ac_template_name = "";
    $cbcart_ac_template_lang = "";
    $cbcart_ac_template_varcount = "";
    $cbcart_ac_message2 = "";
    $cbcart_ac_template2_name ="";
    $cbcart_ac_template2_lang = "";
    $cbcart_ac_template2_varcount = "";
    $cbcart_ac_message3 = "";
    $cbcart_ac_template3_name = "";
    $cbcart_ac_template3_lang = "";
    $cbcart_ac_template3_varcount = "";
    $cbcart_ac_message4 ="";
    $cbcart_ac_template4_name = "";
    $cbcart_ac_template4_lang = "";
    $cbcart_ac_template4_varcount = "";
    $cbcart_ac_message5 = "";
    $cbcart_ac_template5_name ="";
    $cbcart_ac_template5_lang = "";
    $cbcart_ac_template5_varcount = "";
    $cbcart_abandoned_image ="";
}

if ( $cbcart_time1 == 'cbcart_select_hour' ) {
	$cbcart_trigger = cbcart_convertminutestohour( $cbcart_trigger );
}
if ( $cbcart_time2 == 'cbcart_select_hour' ) {
	$cbcart_trigger2 = cbcart_convertminutestohour( $cbcart_trigger2 );
}
if ( $cbcart_time3 == 'cbcart_select_hour' ) {
	$cbcart_trigger3 = cbcart_convertminutestohour( $cbcart_trigger3 );
}
if ( $cbcart_time4 == 'cbcart_select_hour' ) {
	$cbcart_trigger4 = cbcart_convertminutestohour( $cbcart_trigger4 );
}
if ( $cbcart_time5 == 'cbcart_select_hour' ) {
	$cbcart_trigger5 = cbcart_convertminutestohour( $cbcart_trigger5 );
}
if ( $cbcart_time1 == 'cbcart_select_day' ) {
	$cbcart_trigger = cbcart_convertminutestoday( $cbcart_trigger );
}
if ( $cbcart_time2 == 'cbcart_select_day' ) {
	$cbcart_trigger2 = cbcart_convertminutestoday( $cbcart_trigger2 );
}
if ( $cbcart_time3 == 'cbcart_select_day' ) {
	$cbcart_trigger3 = cbcart_convertminutestoday( $cbcart_trigger3 );
}
if ( $cbcart_time4 == 'cbcart_select_day' ) {
	$cbcart_trigger4 = cbcart_convertminutestoday( $cbcart_trigger4 );
}
if ( $cbcart_time5 == 'cbcart_select_day' ) {
	$cbcart_trigger5 = cbcart_convertminutestoday( $cbcart_trigger5 );
}

/**
 * Convert hours into minutes.
 *
 * @param cbcart_hour
 *
 * @return    string   Time into minutes
 * @version   3.0.4
 * @since     1.0.0
 */
function cbcart_converthourtominutes( $cbcart_hour )
{
    return $cbcart_minutes = $cbcart_hour * 60;
}

/**
 * Convert minutes into hours.
 *
 * @param cbcart_hour
 *
 * @return    string   Time into hours
 * @version   3.0.4
 * @since     1.0.0
 */
function cbcart_convertminutestohour( $cbcart_hour )
{
    return $cbcart_hour = $cbcart_hour / 60;
}

/**
 * Convert day into minutes.
 *
 * @param cbcart_day
 *
 * @return    string   Time into minutes
 * @version   3.0.4
 * @since     1.0.0
 */
function cbcart_convertdaytominutes( $cbcart_day )
{
    return $cbcart_minutes = $cbcart_day * 1440;
}

/**
 * Convert minutes into day.
 *
 * @param cbcart_minutes
 *
 * @return    string   Time into day
 * @version   3.0.4
 * @since     1.0.0
 */
function cbcart_convertminutestoday( $cbcart_minutes )
{
    return $cbcart_day = $cbcart_minutes / 1440;
}

if ( empty( $cbcart_ac_message ) ) {
	$cbcart_ac_message = $cbcart_ac_message_template1;
}
if ( empty( $cbcart_ac_message2 ) ) {
	$cbcart_ac_message2 = $cbcart_ac_message_template2;
}
if ( empty( $cbcart_ac_message3 ) ) {
	$cbcart_ac_message3 = $cbcart_ac_message_template3;
}
if ( empty( $cbcart_ac_message4 ) ) {
	$cbcart_ac_message4 = $cbcart_ac_message_template4;
}
if ( empty( $cbcart_ac_message5 ) ) {
	$cbcart_ac_message5 = $cbcart_ac_message_template5;
}
if ( empty( $cbcart_trigger ) ) {
	$cbcart_trigger = esc_html( "10",'cartbox-messaging-widgets' );
	$cbcart_time1   = esc_html( "cbcart_select_minute",'cartbox-messaging-widgets' );
}
if ( empty( $cbcart_trigger2 ) ) {
	$cbcart_trigger2 = esc_html( "12",'cartbox-messaging-widgets' );
	$cbcart_time2    = esc_html( "cbcart_select_hour",'cartbox-messaging-widgets' );
}
if ( empty( $cbcart_trigger3 ) ) {
	$cbcart_trigger3 = esc_html( "1",'cartbox-messaging-widgets' );
	$cbcart_time3    = esc_html( "cbcart_select_day",'cartbox-messaging-widgets' );
}
if ( empty( $cbcart_trigger4 ) ) {
	$cbcart_trigger4 = esc_html( "2",'cartbox-messaging-widgets' );
	$cbcart_time4    = esc_html( "cbcart_select_day",'cartbox-messaging-widgets' );
}
if ( empty( $cbcart_trigger5 ) ) {
	$cbcart_trigger5 = esc_html( "3",'cartbox-messaging-widgets' );
	$cbcart_time5    = esc_html( "cbcart_select_day",'cartbox-messaging-widgets' );
}
?>
<!--for report tab-->
<?php
global $wpdb;
$cbcart_table                 = $wpdb->prefix . "cbcart_abandoneddetails";
$cbcart_Response_string                 = $wpdb->get_results( "SELECT cbcart_id,cbcart_customer_first_name,cbcart_create_date_time,cbcart_customer_mobile_no,cbcart_customer_mobile_no,cbcart_status,cbcart_customer_mobile_no,cbcart_message_api_request, cbcart_message_api_response FROM $cbcart_table" );
$cbcart_reports_array         = array();
$cbcart_reports_array_premium = array();
foreach ( $cbcart_Response_string as $cbcart_key => $cbcart_value ) {

	$cbcart_single_record    = array();
	$cbcart_id               = $cbcart_value->cbcart_id;
	$cbcart_create_date_time = $cbcart_value->cbcart_create_date_time;
	$cbcart_date                = date_create( $cbcart_create_date_time );
	$cbcart_customer_mobile_no  = $cbcart_value->cbcart_customer_mobile_no;
	$cbcart_create_date_time    = date_format( $cbcart_date, 'd-M-Y H:i:s' );
	$cbcart_status              = $cbcart_value->cbcart_status;
	$cbcart_customer_first_name = $cbcart_value->cbcart_customer_first_name;
    $cbcart_json_data_request       = json_decode( $cbcart_value->cbcart_message_api_request );
    $cbcart_json_data_response           = json_decode( $cbcart_value->cbcart_message_api_response );
if($cbcart_json_data_request!="" && $cbcart_json_data_response!="") {
    if (is_array($cbcart_json_data_response)) {
        $cbcart_array_length = count($cbcart_json_data_response);
        if ($cbcart_array_length > 0) {
            $cbcart_json_data_response = array_reverse($cbcart_json_data_response);
            for ($cbcart_i = 0; $cbcart_i < $cbcart_array_length; $cbcart_i++) {
                $cbcart_single_record = array();
                $cbcart_single_record['cbcart_status'] = $cbcart_status;
                $cbcart_single_record['cbcart_id'] = $cbcart_id;
                $cbcart_single_record['cbcart_create_date_time'] = $cbcart_create_date_time;
                $cbcart_single_record['cbcart_mobile_numbers'] = $cbcart_customer_mobile_no;
                $cbcart_single_record['cbcart_customer_first_name'] = $cbcart_customer_first_name;
                $cbcart_single_record['cbcart_response'] = json_decode(json_encode($cbcart_json_data_response));
                array_push($cbcart_reports_array_premium, $cbcart_single_record);
            }
        }
    } else {

        $cbcart_bind_response="";
        $cbcart_response = $cbcart_json_data_response->response;
        $cbcart_response_code=$cbcart_response->code;
        if($cbcart_response_code===200){
            $cbcart_response_status="Sent";
            $cbcart_bind_response=true;
        }else{
            $cbcart_response_status="Not Sent";
            $cbcart_bind_response=false;
        }
        $cbcart_single_record['cbcart_status'] = $cbcart_status;
        $cbcart_single_record['cbcart_id'] = $cbcart_id;
        $cbcart_single_record['cbcart_create_date_time'] = $cbcart_create_date_time;
        $cbcart_single_record['cbcart_mobile_numbers'] = $cbcart_customer_mobile_no;
        $cbcart_single_record['cbcart_customer_first_name'] = $cbcart_customer_first_name;
        $cbcart_single_record['cbcart_response'] = json_decode(json_encode($cbcart_json_data_response));
        if($cbcart_bind_response===true) {
            $cbcart_para = array();

            $cbcart_template_send_data = $cbcart_json_data_request->template;
            $cbcart_request_temp_name = $cbcart_template_send_data->name;
            $cbcart_request_temp_lang = $cbcart_template_send_data->language;
            $cbcart_request_temp_lang = $cbcart_request_temp_lang->code;
            $cbcart_request_temp_component = $cbcart_template_send_data->components;
            $cbcart_request_temp_component2 = $cbcart_request_temp_component['0'];
            $cbcart_get_template_text = cbcart::cbcart_get_template_type($cbcart_request_temp_name, $cbcart_request_temp_lang);
            if (is_array($cbcart_get_template_text) && $cbcart_get_template_text != "") {
                $cbcart_request_temp_text = $cbcart_get_template_text['cbcart_body_text'];
            } else {
                $cbcart_request_temp_text = "";
            }
            if (property_exists($cbcart_request_temp_component2, 'parameters')) {
                $cbcart_request_temp_component3 = $cbcart_request_temp_component2->parameters;
                $cbcart_request_temp_component3 = json_decode(json_encode($cbcart_request_temp_component3), true);
                foreach ($cbcart_request_temp_component3 as $item) {
                    $cbcart_para[] = $item['text'];
                }
                $cbcart_request_temp_text = cbcart_replace_parameters($cbcart_request_temp_text, $cbcart_para);
            } else {
                $cbcart_request_temp_component3 = "";
            }
            $cbcart_single_record['cbcart_template_send'] = '<b>'.esc_html( 'Template Name : ','cartbox-messaging-widgets' ).'</b>' .$cbcart_request_temp_name.'<br>'.'<b>'.esc_html( 'Message : ','cartbox-messaging-widgets' ).'</b>' .$cbcart_request_temp_text;
        }
        else{
            $cbcart_single_record['cbcart_template_send'] = json_decode( json_encode($cbcart_json_data_response));
        }
        $cbcart_single_record['cbcart_message_sent_code'] =$cbcart_bind_response;
        $cbcart_single_record['cbcart_message_sent'] =$cbcart_response_status;
        array_push($cbcart_reports_array_premium, $cbcart_single_record);
    }
}
}
function cbcart_replace_parameters($cbcart_temp_text,$cbcart_temp_para_array){
    $cbcart_new_string = preg_replace_callback('/{{\d+}}/', function ($cbcart_matches) use ($cbcart_temp_para_array) {
        $index = intval(str_replace(array("{","}"), "", $cbcart_matches[0]));
        return $cbcart_temp_para_array[$index-1];
    }, $cbcart_temp_text);
    return $cbcart_new_string;
}
?>
<!--for premium tab-->
<?php

$cbcart_template_status="";
$cbcart_template_status2="";
$cbcart_template_status3="";
$cbcart_template_status4="";
$cbcart_template_status5="";
$cbcart_template_status=cbcart::cbcart_get_templates_status($cbcart_ac_template_name);
$cbcart_template_status2=cbcart::cbcart_get_templates_status($cbcart_ac_template2_name);
$cbcart_template_status3=cbcart::cbcart_get_templates_status($cbcart_ac_template3_name);
$cbcart_template_status4=cbcart::cbcart_get_templates_status($cbcart_ac_template4_name);
$cbcart_template_status5=cbcart::cbcart_get_templates_status($cbcart_ac_template5_name);
$cbcart_logo = cbcart_logonew_black;
?>
<div class="container">
    <div>
        <img src="<?php echo esc_url( $cbcart_logo); ?>" class="cbcart_imgclass" alt="<?php esc_attr( 'logo','cartbox-messaging-widgets' ); ?>">
    </div>
    <label class="text-capitalize cbcart-label3">
        <b><?php esc_html_e( 'cartbox abandoned cart','cartbox-messaging-widgets' ); ?></b>
    </label>
    <div class="tabbable boxed parentTabs">
        <div id="cbcart_setting_dashboard" class="cbcart_nav">
            <ul class="nav nav-tabs">
                <li><a href="#cbcart_set1" class="active"><?php esc_html_e( 'Dashboard','cartbox-messaging-widgets' ); ?></a>
                </li>
                <li><a href="#cbcart_set2"><?php esc_html_e( 'Messages','cartbox-messaging-widgets' ); ?></a>
                </li>
                <li><a href="#cbcart_set3"><?php esc_html_e( 'Report','cartbox-messaging-widgets' ); ?></a>
                </li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane fade active in show" id="cbcart_set1">
                <div class="row">
                    <div class="col-12">

                        <?php
                        if ($cbcart_ac_enable == "" ) { ?>
                            <label class="cbcart_setting_label text-capitalize" ><?php esc_html_e('Please enable abandoned cart from  ','cartbox-messaging-widgets'); ?>
                                <a href="admin.php?page=cbcart_admin_settings_display" class="cbcart_uline_label" ><?php esc_html_e('settings','cartbox-messaging-widgets'); ?></a> <?php esc_html_e('to activate abandoned cart.','cartbox-messaging-widgets'); ?>
                            </label>
                            <?php
                        } else {
                        }
                        ?>
                        <form id="cbcart_form1" name="cbcart_form1" method="POST" action="#" class="cbcart_form_abandoned">
                            <p>
                                <label class="me-2"><?php esc_html_e(  'From Date:','cartbox-messaging-widgets' ); ?></label> <input type="date" id="cbcart_fromdatepicker" name="cbcart_fromdatepicker" placeholder=" " value="<?php if ( $cbcart_fromdatepicker != "" ) {
                                    printf(
                                        esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                        esc_html($cbcart_fromdatepicker)
                                    );

								} ?>"/>
                                <label class="me-2 ms-2"><?php esc_html_e(  'To Date:','cartbox-messaging-widgets' ); ?></label> <input type="date" id="cbcart_todatepicker" name="cbcart_todatepicker" placeholder=" " value="<?php if ( $cbcart_todatepicker != "" ) {
                                    printf(
                                        esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                        esc_html($cbcart_todatepicker)
                                    );
                                 } ?>"/>
								<?php wp_nonce_field( 'cbcart_dashboard_display', 'cbcart_dashboard_display_nonce' ); ?>
                                <button type="submit" name="cbcart_fromdatepickerbtn" class="btn btn-secondary cbcart_search_btn shadow" ><i class="fa fa-search"></i> </button>
                            </p>
                        </form>
                    </div>
                </div>
                <div class="row cbcart_abandoned_dashoard" >
                    <div class="col-4">
                        <div class="card cbcart_card mb-3">
                            <img src="<?php echo esc_url( $cbcart_smiley ); ?>" class="cbcart_smile" alt="<?php esc_attr( 'smile','cartbox-messaging-widgets' ) ?>"/>
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col text-center">
                                        <p class="cbcart_card-text3">
											<?php
                                            printf(
                                                esc_html__( ' %d ', 'cartbox-messaging-widgets' ),
                                                esc_html($cbcart_recovered_cart_count1)
                                            );
                                             ?>
                                        </p>
                                        <label class="w-100 m-auto"><b><?php esc_html_e( 'Recovered Orders','cartbox-messaging-widgets' ); ?></b></label>
                                    </div>
                                    <div class="col-auto cbcart_vl"></div>
                                    <div class="col text-center">
                                        <p class="cbcart_card-text3">
											<?php
                                            printf(
                                                esc_html__( '%d', 'plugin-slug' ),
                                                intval( $cbcart_recovered_cart_amount1 )
                                            ); ?>
                                        </p>
                                        <label class="w-100 m-auto"><b><?php esc_html_e( 'Amount','cartbox-messaging-widgets' ); ?></b></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card cbcart_card">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col text-center">
                                        <p class="cbcart_card-text1">
											<?php
                                            printf(
                                                esc_html__( ' %d ', 'cartbox-messaging-widgets' ),
                                                esc_html($cbcart_abandoned_cart_count1)
                                            );
                                            ?>
                                        </p>
                                        <label class="w-100 m-auto"><b><?php esc_html_e( 'Abandoned Orders','cartbox-messaging-widgets' ); ?></b></label>
                                    </div>
                                    <div class="col-auto cbcart_vl"></div>
                                    <div class="col text-center">
                                        <p class="cbcart_card-text1">
											<?php
                                            printf(
                                                esc_html__( '%d', 'plugin-slug' ),
                                                intval( $cbcart_abandoned_cart_amount1 )
                                            );
                                           ?>
                                        </p>
                                        <label class="w-100 m-auto"><b><?php esc_html_e( 'Lost Amount','cartbox-messaging-widgets' ); ?></b></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<?php if ( $cbcart_display_dashboard == null ) {
					echo '</br>'; ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card cbcart_card mw-100">
                                <div class="row card-body">
                                    <h5 class="dashboardmsg">
                                        <?php esc_html_e( 'Looks like you do not have any abandoned carts yet.','cartbox-messaging-widgets' ); ?><br><br> <b> <?php esc_html_e( 'After 20 minutes','cartbox-messaging-widgets' ); ?> </b><?php esc_html_e( 'of someone abandoning the cart by filling the Name & Phone number fields of your WooCommerce Checkout form, the message will be sended and the entry will appear here.','cartbox-messaging-widgets' ); ?>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
				<?php } else { ?>
                <table id="cbcart_dashboardtable" data-order='[[ 4, "desc" ]]' class="table display table-striped">
                    <thead>
                    <tr>
                        <th><?php esc_html_e(  'ID','cartbox-messaging-widgets' ); ?></th>
                        <th><?php esc_html_e(  'Name','cartbox-messaging-widgets' ); ?></th>
                        <th><?php esc_html_e(  'Contact No.','cartbox-messaging-widgets' ); ?></th>
                        <th><?php esc_html_e(  'Cart Item','cartbox-messaging-widgets' ); ?></th>
                        <th><?php esc_html_e(  'Time','cartbox-messaging-widgets' ); ?></th>
                        <th><?php esc_html_e(  'Price','cartbox-messaging-widgets' ); ?>(<?php
                            printf(
                                esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                esc_html( $cbcart_currency)
                            );
                          ?>)</th>
                        <th><?php esc_html_e(  'Status','cartbox-messaging-widgets' ); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
						<?php
						foreach ( $cbcart_display_dashboard as $cbcart_row ) { ?>
                        <td>
							<?php
                            printf(
                                esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                esc_html($cbcart_row->cbcart_id)
                            );

                             ?>
                        </td>
                        <td>
							<?php
                            printf(
                                esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                esc_html($cbcart_row->cbcart_customer_first_name)
                            );

							echo "\n";

                            printf(
                                esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                esc_html($cbcart_row->cbcart_customer_last_name)
                            );
							 ?>
                        </td>
                        <td>
                            <?php
                            $cbcart_store_name            = get_bloginfo( 'name' );
                            $cbcart_base_url     = site_url( $path = '', $scheme = null );
                            $cbcart_status = $cbcart_row->cbcart_status;
                            if ( $cbcart_status == '1' ) {
                                $cbcart_message_text = "Hi ".$cbcart_row->cbcart_customer_first_name.",%0AWe noticed you didn't finish your order on ".$cbcart_store_name.".%0AVisit now to complete your order. %0A".$cbcart_base_url."%0AThanks.";
                            } else {
                                $cbcart_message_text = "Hi!";
                            }
                            $cbcart_url = esc_url('https://wa.me/').$cbcart_row->cbcart_customer_mobile_no.'?text='.$cbcart_message_text; ?>
                                <a href= "<?php echo esc_url($cbcart_url);?>" target="_blank">
                                 <?php
                                 printf(
                                     esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                     esc_html($cbcart_row->cbcart_customer_mobile_no)
                                 ); ?></a>

                        </td>
                        <td>
							<?php
							$cbcart_cart_id = unserialize( $cbcart_row->cbcart_cart_json );
							$cbcart_array   = json_decode( json_encode( $cbcart_cart_id ), true );
							foreach ( $cbcart_array as $cbcart_arr2 ) {

								$cbcart_product_id     = $cbcart_arr2['product_id'];
								$cbcart_cart_content   = $wpdb->get_results( $wpdb->prepare( "SELECT post_title FROM " . $wpdb->prefix . "posts WHERE ID = %d ORDER BY ID DESC", $cbcart_product_id ) ); // db call ok; no-cache ok
								$cbcart_array1         = json_decode( json_encode( $cbcart_cart_content ), true );
								$cbcart_cart_data      = json_encode( $cbcart_array1 );
								$cbcart_var            = explode( ",", $cbcart_array1['0']['post_title'] );
								$cbcart_cart           = $cbcart_var['0'];
								$cbcart_products_array = array();
								array_push( $cbcart_products_array, $cbcart_cart );
                                $cbcart_exploded_names = implode( ",", $cbcart_products_array);
                                printf(
                                    esc_html_e( '%s', 'plugin-slug' ),
                                    esc_html( $cbcart_exploded_names )
                                );
								;
								echo '<br>';
							} ?>
                        </td>
                        <td>
							<?php
							$cbcart_date = date_create( $cbcart_row->cbcart_create_date_time );
                            $cbcart_create_date_time = date_format( $cbcart_date, 'd-M-Y H:i');
                            printf(
                                esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                esc_html_e(  $cbcart_create_date_time )
                            );

                           ?>
                        </td>
                        <td>
							<?php
                            printf(
                                esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                esc_html_e(   $cbcart_row->cbcart_cart_total )
                            );
                             ?>
                        </td>
                        <td>
							<?php
							$cbcart_status = $cbcart_row->cbcart_status;
							if ( $cbcart_status == '1' ) {
                                ?>
                                <h6 class=" text-black fw-bold cbcart_status_label"  onclick="activeTab('cbcart_set3')">
                                <?php esc_html_e( 'Abandoned','cartbox-messaging-widgets' )?> </h6>
                                <?php
							} else { ?>
                                <h6 class=" text-success fw-bold cbcart_status_label "  onclick="activeTab('cbcart_set3')">
                                    <?php esc_html_e( 'Recovered','cartbox-messaging-widgets' ); ?></h6>
							<?php }
							?>
                        </td>
                    </tr>
					<?php
					}
					} ?>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="cbcart_set2">
                <div class="d-flex">
                    <label class="cbcart-label3 w-75 m-0 mt-3 mb-3">
                        <b> <?php esc_html_e('Note :','cartbox-messaging-widgets' ); ?></b>
                        <?php esc_html_e('You can send up to 5 cart abandonment messages and customize the message timings below. To send a message, do "enable" it by selecting it below.','cartbox-messaging-widgets' ); ?>
                    </label>
                    <div class="m-auto">
                        <a href="https://developers.facebook.com/" target="_blank"><button type="button" class="btn btn-secondary shadow"><?php esc_html_e('Add New Template') ?></button></a>
                    </div>
                </div>
                <form method="post" name="cbcart_form1_premium" class="form-content w-75" action="">
                        <div class="">
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label> <?php esc_html_e(  'Enter Image URL which you want to send with message :','cartbox-messaging-widgets' ) ?></label>
                                    <input type="url" name="cbcart_image" id="cbcart_image" class="cbcart_message  form-control w-100"  value="<?php
                                    printf(
                                            esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                        esc_html($cbcart_abandoned_image)
                                    ); ?>"/>

                                </div>
                                <div class="cbcart_messages-box mb-3">
                                    <div class="card cbcart_card mx-0 w-100 pt-0 cbcart_settings_card ">
                                        <div class="row">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <label class="cbcart_sub_label my-3 text-capitalize"><?php esc_html_e( 'Message 1','cartbox-messaging-widgets' ); ?></label>
                                                <label class="cbcart_switch">
                                                    <input type="checkbox" name="cbcart_message1_enable" id="cbcart_message1_enable" value="cbcart_admin_checkbox" <?php if ( $cbcart_multiple_messages >= '1' ) { ?> checked="checked" <?php } else { ?> disabled="disable" title="<?php esc_html_e( 'update to paid plan','cartbox-messaging-widgets' ); ?>" data-toggle="tooltip" <?php } ?>readonly />
                                                    <span class="cbcart_slider cbcart_round"></span>
                                                </label>
                                            </div>
                                            <hr/>
                                            <div class="container-fluid cbcart-card-body <?php if ( $cbcart_multiple_messages >= "1" ) { if ( $cbcart_message1_enable == "" ) { ?> d-none <?php } } ?>">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <label for="" class="cbcart_label3 text-capitalize"><?php esc_html_e( 'Template name','cartbox-messaging-widgets' ); ?> </label>
                                                        <span class="cbcart_required_star">*</span><br/>
                                                        <label class="cbcart_temp_text2 mx-0 mt-2"><?php
                                                            printf(
                                                                esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                                                esc_html($cbcart_ac_template_name)
                                                            );
                                                             ?></label>
                                                        <label id="cbcart_error_templatename" class="cbcart_error"><?php esc_html_e( 'Please enter template name properly.','cartbox-messaging-widgets' ); ?></label>
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="" class="cbcart_label3 text-capitalize"><?php esc_html_e( 'Template language','cartbox-messaging-widgets' ); ?> </label>
                                                        <span class="cbcart_required_star">*</span><br/>
                                                        <label class="cbcart_temp_text2 mx-0 mt-2"><?php
                                                            printf(
                                                                esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                                                esc_html($cbcart_ac_template_lang)
                                                            );
                                                             ?></label>
                                                        <label id="cbcart_error_language" class="cbcart_error"><?php esc_html_e( 'Please enter template language properly.','cartbox-messaging-widgets' ); ?></label>
                                                    </div>
                                                    <div class="col-4">
                                                        <label class="cbcart_label3 text-capitalize"><?php esc_html_e( 'Schedule Time','cartbox-messaging-widgets' ); ?></label><br>
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <input type="text" name="cbcart_trigger_1" id="cbcart_trigger_1" required class="form-control cbcart_message" value="<?php
                                                                printf(
                                                                    esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                                                    esc_html($cbcart_trigger)
                                                                );
                                                               ?>"/>
                                                            </div>
                                                            <div class="col-6">
                                                                <select class="form-control cbcart_select_time cbcart_message" name="cbcart_select_time1" value="cbcart_select_time1" required>
                                                                    <option value="cbcart_select_minute" name="cbcart_select_time1" id="cbcart_select_minute" <?php
                                                                    printf(
                                                                        esc_html( '%s' ),
                                                                        'cbcart_select_minute' === esc_attr( $cbcart_time1 ) ? 'selected' : ''
                                                                    ); ?>><?php esc_html_e( 'Minute','cartbox-messaging-widgets' ); ?></option>
                                                                    <option value="cbcart_select_hour" name="cbcart_select_time1" id="cbcart_select_hour" <?php
                                                                    printf(
                                                                        esc_html( '%s' ),
                                                                        'cbcart_select_day' === esc_attr( $cbcart_time1 ) ? 'selected' : ''
                                                                    );
                                                                    ?>><?php esc_html_e( 'Hour','cartbox-messaging-widgets' ); ?></option>
                                                                    <option value="cbcart_select_day" name="cbcart_select_time1" id="cbcart_select_day" <?php printf(
                                                                        esc_html( '%s' ),
                                                                        'cbcart_select_day' === esc_attr( $cbcart_time1 ) ? 'selected' : ''
                                                                    ); ?>><?php esc_html_e( 'Day','cartbox-messaging-widgets' ); ?></option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div <?php if ( $cbcart_isCustomizMessageOfAbandoned != "true" ) { ?> title="<?php esc_html_e( 'update to paid plan','cartbox-messaging-widgets' ); ?>" data-toggle="tooltip" <?php } ?>>
                                                            <textarea required class="form-control cbcart_message" readonly name="cbcart_message" id="cbcart_message" rows="3" <?php if ( $cbcart_isCustomizMessageOfAbandoned != "true" ) { ?> title="<?php esc_html_e( 'update to paid plan','cartbox-messaging-widgets' ); ?> data-toggle=" tooltip" disabled="disable" <?php } ?>><?php
                                                            printf(
                                                                esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                                                esc_html( $cbcart_ac_message)
                                                            );
                                                        ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="row mt-3 justify-content-between">
                                                            <?php if($cbcart_plan==="2"|| $cbcart_plan==="3"|| $cbcart_plan==="4"){?>
                                                                <div class="col-auto">
                                                                    <?php wp_nonce_field( 'cbcart_customise_btn1', 'cbcart_customise_btn1_nounce' ); ?>
                                                                    <button class="btn btn-success cbcart_btn_theme_secondary" name="cbcart_customise_btn1" type="submit"><?php esc_html_e( 'Change Template','cartbox-messaging-widgets' ); ?></button>
                                                                </div>
                                                            <?php } ?>
                                                            <div class="col-auto">
                                                                <button class="btn btn-success cbcart_btn_theme_secondary" name="cbcart_check_status" type="button" onclick="cbcart_show_status()"><?php esc_html_e( 'check template status','cartbox-messaging-widgets' ); ?></button>
                                                                <div id="cbcart_status1"><?php echo wp_kses_post($cbcart_template_status)?></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="cbcart_messages-box mb-3">
                                    <div class="card cbcart_card mx-0 w-100 pt-0 cbcart_settings_card ">
                                        <div class="row">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <label class="cbcart_sub_label my-3 text-capitalize"><?php esc_html_e( 'Message 2','cartbox-messaging-widgets' ); ?></label>
                                                <label class="cbcart_switch">
                                                    <input type="checkbox" name="cbcart_message2_enable" id="cbcart_message2_enable" value="checked" <?php if ( $cbcart_multiple_messages >= '2' ) {
                                                        if ( $cbcart_message2_enable == "checked" ) { ?> checked="checked" <?php }
                                                    } else { ?> disabled="disable" title="<?php esc_html_e( 'update to paid plan','cartbox-messaging-widgets' ); ?>" data-toggle="tooltip" <?php } ?> />
                                                    <span class="cbcart_slider cbcart_round"></span>
                                                </label>
                                            </div>
                                            <hr/>
                                            <div class="container-fluid cbcart-card-body  <?php if ( $cbcart_multiple_messages >= "2" ) { if ( $cbcart_message2_enable == "" ) { ?> d-none <?php } } ?>" >
                                                <div class="row">
                                                    <div class="col-4">
                                                        <label for="" class="cbcart_label3 text-capitalize"><?php esc_html_e( 'Template name','cartbox-messaging-widgets' ); ?> </label>
                                                        <span class="cbcart_required_star">*</span><br/>
                                                        <label class="cbcart_temp_text2 mx-0 mt-2"><?php
                                                            printf(
                                                                esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                                                esc_html($cbcart_ac_template2_name)
                                                            );
                                                            ?></label>
                                                        <label id="cbcart_error_templatename" class="cbcart_error"><?php esc_html_e( 'Please enter template name properly.','cartbox-messaging-widgets' ); ?></label>
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="" class="cbcart_label3 text-capitalize"><?php esc_html_e( 'Template language','cartbox-messaging-widgets' ); ?> </label>
                                                        <span class="cbcart_required_star">*</span><br/>
                                                        <label class="cbcart_temp_text2 mx-0 mt-2"><?php
                                                            printf(
                                                                esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                                                esc_html($cbcart_ac_template2_lang)
                                                            );
                                                             ?></label>
                                                        <label id="cbcart_error_language" class="cbcart_error"><?php esc_html_e( 'Please enter template language properly.','cartbox-messaging-widgets' ); ?></label>
                                                    </div>
                                                    <div class="col-4">
                                                        <label class="cbcart_label3 text-capitalize"><?php esc_html_e( 'Schedule Time','cartbox-messaging-widgets' ); ?></label><br>
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <input type="text" name="cbcart_trigger_2" id="cbcart_trigger_2" required class="form-control cbcart_message" onkeypress="return isNumber(event)" value="<?php
                                                                printf(
                                                                    esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                                                    esc_html($cbcart_trigger2)
                                                                ); ?>" <?php if ( $cbcart_message2_enable != "checked" ) { ?> readonly="readonly" <?php } ?> />
                                                            </div>
                                                            <div class="col-6">
                                                                <select class="form-control cbcart_select_time cbcart_message" name="cbcart_select_time2" value="cbcart_select_time2" required <?php if ( $cbcart_message2_enable != "checked" ) { ?> readonly="readonly" <?php } ?>>
                                                                    <option value="cbcart_select_minute" name="cbcart_select_time2" id="cbcart_select_minute" <?php printf(
                                                                        esc_html( '%s' ),
                                                                        'cbcart_select_minute' === esc_attr( $cbcart_time2 ) ? 'selected' : ''
                                                                    ); ?></option>
                                                                    <option value="cbcart_select_hour" name="cbcart_select_time2" id="cbcart_select_hour" <?php printf(
                                                                        esc_html( '%s' ),
                                                                        'cbcart_select_hour' === esc_attr( $cbcart_time2 ) ? 'selected' : ''
                                                                    );?></option>
                                                                    <option value="cbcart_select_day" name="cbcart_select_time2" id="cbcart_select_day" <?php printf(
                                                                        esc_html( '%s' ),
                                                                        'cbcart_select_day' === esc_attr( $cbcart_time2 ) ? 'selected' : ''
                                                                    ); ?>><?php esc_html_e( 'Day','cartbox-messaging-widgets' ); ?></option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div <?php if ( $cbcart_isCustomizMessageOfAbandoned != "true" ) { ?> title="<?php esc_html_e( 'update to paid plan','cartbox-messaging-widgets' ); ?>" data-toggle="tooltip" <?php } ?>>
                                                            <textarea disabled class="form-control cbcart_message" name="cbcart_message2" id="cbcart_message2" rows="3" <?php if ( $cbcart_message2_enable != "checked" ) { ?> readonly="readonly" <?php } ?> <?php if ( $cbcart_isCustomizMessageOfAbandoned != "true" ) { ?>disabled="disable" title="<?php esc_attr_e( 'update to paid plan','cartbox-messaging-widgets' ); ?>" data-toggle="tooltip" <?php } ?>><?php
                                                                printf(
                                                                    esc_html__( ' %s ','cartbox-messaging-widget' ),
                                                                    esc_html( $cbcart_ac_message2 )
                                                                );
                                                                ?></textarea></div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="row mt-3 justify-content-between">
                                                            <?php if($cbcart_plan==="2"|| $cbcart_plan==="3"|| $cbcart_plan==="4"){?>
                                                                <div class="col-auto">
                                                                    <?php wp_nonce_field( 'cbcart_customise_btn2', 'cbcart_customise_btn2_nounce' ); ?>
                                                                    <button class="btn btn-success cbcart_btn_theme_secondary" name="cbcart_customise_btn2" type="submit"><?php esc_html_e( 'Change Template','cartbox-messaging-widgets' ); ?></button>
                                                                </div>
                                                            <?php } ?>
                                                            <div class="col-auto">
                                                                <button class="btn btn-success cbcart_btn_theme_secondary" name="cbcart_check_status2" type="button" onclick="cbcart_show_status2()"><?php esc_html_e( 'check template status','cartbox-messaging-widgets' ); ?></button>
                                                                <div id="cbcart_status2"><?php echo wp_kses_post($cbcart_template_status2); ?></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="cbcart_messages-box mb-3">
                                    <div class="card cbcart_card mx-0 w-100 pt-0 cbcart_settings_card ">
                                        <div class="row">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <label class="cbcart_sub_label my-3 text-capitalize"><?php esc_html_e( 'Message 3','cartbox-messaging-widgets' ); ?></label>
                                                <label class="cbcart_switch">
                                                    <input type="checkbox" name="cbcart_message3_enable" id="cbcart_message3_enable" value="checked" <?php if ( $cbcart_multiple_messages >= '2' ) {
                                                        if ( $cbcart_message3_enable == "checked" ) { ?> checked="checked" <?php }
                                                    } else { ?> disabled="disable" title="<?php esc_attr_e( 'update to paid plan','cartbox-messaging-widgets' ); ?>" data-toggle="tooltip" <?php } ?> />
                                                    <span class="cbcart_slider cbcart_round"></span>
                                                </label>
                                            </div>
                                            <hr/>
                                            <div class="container-fluid cbcart-card-body  <?php if ( $cbcart_multiple_messages >= "3" ) { if ( $cbcart_message3_enable == "" ) { ?> d-none <?php } } ?>">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <label for="" class="cbcart_label3 text-capitalize"><?php esc_html_e( 'Template name','cartbox-messaging-widgets' ); ?> </label>
                                                        <span class="cbcart_required_star">*</span><br/>
                                                        <label class="cbcart_temp_text2 mx-0 mt-2"><?php
                                                            printf(
                                                                esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                                                esc_html($cbcart_ac_template3_name)
                                                            );
                                                            ?></label>
                                                        <label id="cbcart_error_templatename" class="cbcart_error"><?php esc_html_e( 'Please enter template name properly.','cartbox-messaging-widgets' ); ?></label>
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="" class="cbcart_label3 text-capitalize"><?php esc_html_e( 'Template language','cartbox-messaging-widgets' ); ?> </label>
                                                        <span class="cbcart_required_star">*</span><br/>
                                                        <label class="cbcart_temp_text2 mx-0 mt-2"><?php
                                                            printf(
                                                                esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                                                esc_html($cbcart_ac_template3_lang)
                                                            ); ?></label>
                                                        <label id="cbcart_error_language" class="cbcart_error"><?php esc_html_e( 'Please enter template language properly.','cartbox-messaging-widgets' ); ?></label>
                                                    </div>
                                                    <div class="col-4">
                                                        <label class="cbcart_label3 text-capitalize"><?php esc_html_e( 'Schedule Time','cartbox-messaging-widgets' ); ?></label><br>
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <input type="text" name="cbcart_trigger_3" id="cbcart_trigger_3" required class="form-control cbcart_message" onkeypress="return isNumber(event)" value="<?php
                                                                printf(
                                                                    esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                                                    esc_html($cbcart_trigger3)
                                                                );  ?>" <?php if ( $cbcart_message3_enable != "checked" ) { ?> readonly="readonly" <?php } ?> />
                                                            </div>
                                                            <div class="col-6">
                                                                <select class="form-control cbcart_select_time cbcart_message" name="cbcart_select_time3" value="cbcart_select_time3" required <?php if ( $cbcart_message3_enable != "checked" ) { ?> readonly="readonly" <?php } ?>>
                                                                    <option value="cbcart_select_minute" name="cbcart_select_time3" id="cbcart_select_minute" <?php
                                                                    printf(
                                                                        esc_html( '%s' ),
                                                                        'cbcart_select_minute' === esc_attr( $cbcart_time3 ) ? 'selected' : ''
                                                                    ); ?>><?php esc_html_e( 'Minute','cartbox-messaging-widgets' ); ?></option>
                                                                    <option value="cbcart_select_hour" name="cbcart_select_time3" id="cbcart_select_hour" <?php
                                                                    printf(
                                                                        esc_html( '%s' ),
                                                                        'cbcart_select_hour' === esc_attr( $cbcart_time3 ) ? 'selected' : ''
                                                                    );?>><?php esc_html_e( 'Hour','cartbox-messaging-widgets' ); ?></option>
                                                                    <option value="cbcart_select_day" name="cbcart_select_time3" id="cbcart_select_day" <?php printf(
                                                                        esc_html( '%s' ),
                                                                        'cbcart_select_day' === esc_attr( $cbcart_time3 ) ? 'selected' : ''
                                                                    ); ?><?php esc_html_e( 'Day','cartbox-messaging-widgets' ); ?></option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div <?php if ( $cbcart_isCustomizMessageOfAbandoned != "true" ) { ?> title="<?php esc_html_e( 'update to paid plan','cartbox-messaging-widgets' ); ?>" data-toggle="tooltip" <?php } ?>>
                                                            <textarea required class="form-control cbcart_message" disabled name="cbcart_message3" id="cbcart_message3" rows="3" <?php if ( $cbcart_message3_enable != "checked" ) { ?> readonly="readonly" <?php } ?> <?php if ( $cbcart_isCustomizMessageOfAbandoned != "true" ) { ?>disabled="disable" title="<?php esc_attr_e( 'update to paid plan','cartbox-messaging-widgets' ); ?>" data-toggle="tooltip" <?php } ?>><?php
                                                                printf(
                                                                        esc_html__( ' %s ','cartbox-messaging-widget' ),
                                                                    esc_html( $cbcart_ac_message3 )
                                                                );
                                                                 ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="row mt-3 justify-content-between">
                                                            <?php if($cbcart_plan==="2"|| $cbcart_plan==="3"|| $cbcart_plan==="4"){?>

                                                                <div class="col-auto">
                                                                    <?php wp_nonce_field( 'cbcart_customise_btn3', 'cbcart_customise_btn3_nounce' ); ?>

                                                                    <button class="btn btn-success cbcart_btn_theme_secondary" name="cbcart_customise_btn3" type="submit"><?php esc_html_e( 'Change Template','cartbox-messaging-widgets' ); ?></button>
                                                                </div>
                                                            <?php } ?>
                                                            <div class="col-auto">
                                                                <button class="btn btn-success cbcart_btn_theme_secondary" name="cbcart_check_status3" type="button" onclick="cbcart_show_status3()"><?php esc_html_e( 'check template status','cartbox-messaging-widgets' ); ?></button>
                                                                <div id="cbcart_status3"><?php echo wp_kses_post($cbcart_template_status3) ?></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="cbcart_messages-box mb-3">
                                    <div class="card cbcart_card mx-0 w-100 pt-0 cbcart_settings_card ">
                                        <div class="row">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <label class="cbcart_sub_label my-3 text-capitalize"><?php esc_html_e( 'Message 4','cartbox-messaging-widgets' ); ?></label>
                                                <label class="cbcart_switch">
                                                    <input type="checkbox" name="cbcart_message4_enable" id="cbcart_message4_enable" value="checked" <?php if ( $cbcart_multiple_messages >= '2' ) {
                                                        if ( $cbcart_message4_enable == "checked" ) { ?> checked="checked" <?php }
                                                    } else { ?> disabled="disable" title="<?php esc_attr_e( 'update to paid plan','cartbox-messaging-widgets' ); ?>" data-toggle="tooltip" <?php } ?> />
                                                    <span class="cbcart_slider cbcart_round"></span>
                                                </label>
                                            </div>
                                            <hr/>
                                            <div class="container-fluid cbcart-card-body  <?php if ( $cbcart_multiple_messages >= "4" ) { if ( $cbcart_message4_enable == "" ) { ?> d-none <?php } } ?>">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <label for="" class="cbcart_label3 text-capitalize"><?php esc_html_e( 'Template name','cartbox-messaging-widgets' ); ?> </label>
                                                        <span class="cbcart_required_star">*</span><br/>
                                                        <label class="cbcart_temp_text2 mx-0 mt-2"><?php
                                                            printf(
                                                                esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                                                esc_html($cbcart_ac_template4_name)
                                                            );
                                                          ?></label>
                                                        <label id="cbcart_error_templatename" class="cbcart_error"><?php esc_html_e( 'Please enter template name properly.','cartbox-messaging-widgets' ); ?></label>
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="" class="cbcart_label3 text-capitalize"><?php esc_html_e( 'Template language','cartbox-messaging-widgets' ); ?> </label>
                                                        <span class="cbcart_required_star">*</span><br/>
                                                        <label class="cbcart_temp_text2 mx-0 mt-2"><?php
                                                            printf(
                                                                esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                                                esc_html($cbcart_ac_template4_lang)
                                                            );
                                                          ?></label>
                                                        <label id="cbcart_error_language" class="cbcart_error"><?php esc_html_e( 'Please enter template language properly.','cartbox-messaging-widgets' ); ?></label>
                                                    </div>
                                                    <div class="col-4">
                                                        <label class="cbcart_label3 text-capitalize"><?php esc_html_e( 'Schedule Time','cartbox-messaging-widgets' ); ?></label><br>
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <input type="text" name="cbcart_trigger_4" id="cbcart_trigger_4" required class="form-control cbcart_message" value="<?php
                                                                printf(
                                                                    esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                                                    esc_html($cbcart_trigger4)
                                                                );
                                                                 ?>" <?php if ( $cbcart_message4_enable != "checked" ) { ?> readonly="readonly" <?php } ?> />
                                                            </div>
                                                            <div class="col-6">
                                                                <select class="form-control cbcart_select_time cbcart_message" name="cbcart_select_time4" value="cbcart_select_time4" required <?php if ( $cbcart_message4_enable != "checked" ) { ?> readonly="readonly" <?php } ?>>
                                                                    <option value="cbcart_select_minute" name="cbcart_select_time4" id="cbcart_select_minute" <?php printf(
                                                                        esc_html( '%s' ),
                                                                        'cbcart_select_minute' === esc_attr( $cbcart_time4 ) ? 'selected' : ''
                                                                    );?>><?php esc_html_e( 'Minute','cartbox-messaging-widgets' ); ?></option>
                                                                    <option value="cbcart_select_hour" name="cbcart_select_time4" id="cbcart_select_hour" <?php printf(
                                                                        esc_html( '%s' ),
                                                                        'cbcart_select_hour' === esc_attr( $cbcart_time4 ) ? 'selected' : ''
                                                                    ); ?>><?php esc_html_e( 'Hour','cartbox-messaging-widgets' ); ?></option>
                                                                    <option value="cbcart_select_day" name="cbcart_select_time4" id="cbcart_select_day" <?php printf(
                                                                        esc_html( '%s' ),
                                                                        'cbcart_select_day' === esc_attr( $cbcart_time4 ) ? 'selected' : ''
                                                                    );?>><?php esc_html_e( 'Day','cartbox-messaging-widgets' ); ?></option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div <?php if ( $cbcart_isCustomizMessageOfAbandoned != "true" ) { ?> title="<?php esc_html_e( 'update to paid plan','cartbox-messaging-widgets' ); ?>" data-toggle="tooltip" <?php } ?>>
                                                            <textarea required class="form-control cbcart_message" disabled name="cbcart_message4" id="cbcart_message4" rows="3" <?php if ( $cbcart_message4_enable != "checked" ) { ?> readonly="readonly" <?php } ?> <?php if ( $cbcart_isCustomizMessageOfAbandoned != "true" ) { ?>disabled="disable" title="<?php esc_attr_e( 'update to paid plan','cartbox-messaging-widgets' ); ?>" data-toggle="tooltip" <?php } ?>><?php
                                                                printf(
                                                                    esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                                                    esc_html( $cbcart_ac_message4)
                                                                );
                                                               ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="row mt-3 justify-content-between">
                                                            <?php if($cbcart_plan==="2"|| $cbcart_plan==="3"|| $cbcart_plan==="4"){?>

                                                                <div class="col-auto">
                                                                    <?php wp_nonce_field( 'cbcart_customise_btn4', 'cbcart_customise_btn4_nounce' ); ?>

                                                                    <button class="btn btn-success cbcart_btn_theme_secondary" name="cbcart_customise_btn4" type="submit"><?php esc_html_e( 'Change Template','cartbox-messaging-widgets' ); ?></button>
                                                                </div>
                                                            <?php } ?>
                                                            <div class="col-auto">
                                                                <button class="btn btn-success cbcart_btn_theme_secondary" name="cbcart_check_status4" type="button" onclick="cbcart_show_status4()"><?php esc_html_e( 'check template status','cartbox-messaging-widgets' ); ?></button>
                                                                <div id="cbcart_status4"><?php echo  wp_kses_post($cbcart_template_status4) ?></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="cbcart_messages-box mb-3">
                                    <div class="card cbcart_card mx-0 w-100 pt-0 cbcart_settings_card ">
                                        <div class="row">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <label class="cbcart_sub_label my-3 text-capitalize"><?php esc_html_e( 'Message 5','cartbox-messaging-widgets' ); ?></label>
                                                <label class="cbcart_switch">
                                                    <input type="checkbox" name="cbcart_message5_enable" id="cbcart_message5_enable" value="checked" <?php if ( $cbcart_multiple_messages >= '2' ) {
                                                        if ( $cbcart_message5_enable == "checked" ) { ?> checked="checked" <?php }
                                                    } else { ?> disabled="disable" title="<?php esc_attr_e( 'update to paid plan','cartbox-messaging-widgets' ); ?>" data-toggle="tooltip" <?php } ?> />
                                                    <span class="cbcart_slider cbcart_round"></span>
                                                </label>
                                            </div>
                                            <hr/>
                                            <div class="container-fluid cbcart-card-body <?php if ( $cbcart_multiple_messages >= "5" ) { if ( $cbcart_message5_enable == "" ) { ?> d-none <?php } } ?>">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <label for="" class="cbcart_label3 text-capitalize"><?php esc_html_e( 'Template name','cartbox-messaging-widgets' ); ?> </label>
                                                        <span class="cbcart_required_star">*</span><br/>
                                                        <label class="cbcart_temp_text2 mx-0 mt-2"><?php
                                                            printf(
                                                                esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                                                esc_html($cbcart_ac_template5_name)
                                                            );
                                                           ?></label>
                                                        <label id="cbcart_error_templatename" class="cbcart_error"><?php esc_html_e( 'Please enter template name properly.','cartbox-messaging-widgets' ); ?></label>
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="" class="cbcart_label3 text-capitalize"><?php esc_html_e( 'Template language','cartbox-messaging-widgets' ); ?> </label>
                                                        <span class="cbcart_required_star">*</span><br/>
                                                        <label class="cbcart_temp_text2 mx-0 mt-2"><?php
                                                            printf(
                                                                esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                                                esc_html($cbcart_ac_template5_lang)
                                                            );
                                                            ?></label>
                                                        <label id="cbcart_error_language" class="cbcart_error"><?php esc_html_e( 'Please enter template language properly.','cartbox-messaging-widgets' ); ?></label>
                                                    </div>
                                                    <div class="col-4">
                                                        <label class="cbcart_label3 text-capitalize"><?php esc_html_e( 'Schedule Time','cartbox-messaging-widgets' ); ?></label><br>
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <input type="text" name="cbcart_trigger_5" id="cbcart_trigger_5" required class="form-control cbcart_message" onkeypress="return isNumber(event)" value="<?php
                                                                printf(
                                                                    esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                                                    esc_html($cbcart_trigger5)
                                                                );
                                                             ?>" <?php if ( $cbcart_message5_enable != "checked" ) { ?> readonly="readonly" <?php } ?> />
                                                            </div>
                                                            <div class="col-6">
                                                                <select class="form-control cbcart_select_time cbcart_message" name="cbcart_select_time5" value="cbcart_select_time5" required <?php if ( $cbcart_message5_enable != "checked" ) { ?> readonly="readonly" <?php } ?>>
                                                                    <option value="cbcart_select_minute" name="cbcart_select_time5" id="cbcart_select_minute" <?php printf(
                                                                        esc_html( '%s' ),
                                                                        'cbcart_select_minute' === esc_attr( $cbcart_time5 ) ? 'selected' : ''
                                                                    ); ?>><?php esc_html_e( 'Minute','cartbox-messaging-widgets' ); ?></option>
                                                                    <option value="cbcart_select_hour" name="cbcart_select_time5" id="cbcart_select_hour" <?php printf(
                                                                        esc_html( '%s' ),
                                                                        'cbcart_select_hour' === esc_attr( $cbcart_time5 ) ? 'selected' : ''
                                                                    ); ?>><?php esc_html_e( 'Hour','cartbox-messaging-widgets' ); ?></option>
                                                                    <option value="cbcart_select_day" name="cbcart_select_time5" id="cbcart_select_day" <?php printf(
                                                                        esc_html( '%s' ),
                                                                        'cbcart_select_day' === esc_attr( $cbcart_time5 ) ? 'selected' : ''
                                                                    ); ?>><?php esc_html_e( 'Day','cartbox-messaging-widgets' ); ?></option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div <?php if ( $cbcart_isCustomizMessageOfAbandoned != "true" ) { ?> title="<?php esc_html_e( 'update to paid plan','cartbox-messaging-widgets' ); ?>" data-toggle="tooltip" <?php } ?>>
                                                            <textarea required class="form-control cbcart_message" disabled name="cbcart_message5" id="cbcart_message5" rows="3" <?php if ( $cbcart_message5_enable != "checked" ) { ?> readonly="readonly" <?php } ?> <?php if ( $cbcart_isCustomizMessageOfAbandoned != "true" ) { ?>disabled="disable" title="<?php esc_html_e( 'update to paid plan','cartbox-messaging-widgets' ); ?>" data-toggle="tooltip" <?php } ?>><?php
                                                                printf(
                                                                    esc_html__( ' %s ','cartbox-messaging-widget' ),
                                                                    esc_html( $cbcart_ac_message5 )
                                                                ); ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="row mt-3 justify-content-between">
                                                            <?php if($cbcart_plan==="2"|| $cbcart_plan==="3"|| $cbcart_plan==="4"){?>
                                                            <div class="col-auto">
                                                                <?php wp_nonce_field( 'cbcart_customise_btn5', 'cbcart_customise_btn5_nounce' ); ?>

                                                                <button class="btn btn-success cbcart_btn_theme_secondary" name="cbcart_customise_btn5" type="submit"><?php esc_html_e( 'Change Template','cartbox-messaging-widgets' ); ?></button>
                                                            </div>
                                                            <?php } ?>
                                                            <div class="col-auto">
                                                                <button class="btn btn-success cbcart_btn_theme_secondary" name="cbcart_check_status5" type="button" onclick="cbcart_show_status5()"><?php esc_html_e( 'check template status','cartbox-messaging-widgets' ); ?></button>
                                                                <div id="cbcart_status5"><?php echo wp_kses_post($cbcart_template_status5)?></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
								<?php wp_nonce_field( 'cbcart_message_send', 'cbcart_message_send_nonce' ); ?>
                                <div class="col-md-12 text-center mt-4">
                                    <button type="submit" class="btn cbcart_btn-theme2" name="cbcart_messagesave_premium"><?php esc_html_e( 'Save','cartbox-messaging-widgets' ); ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                </form>
            </div>
            <div class="tab-pane fade mt-4" id="cbcart_set3">
				<?php
				if ( $cbcart_isDisplayReport != "false" ) {
                    if ( $cbcart_Response_string == null || empty( $cbcart_reports_array_premium ) ) { ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card cbcart_card">
                                        <div class="row card-body cbcart_card-body">
                                            <h5 class="dashboardmsg">
                                                <?php esc_html_e( 'Looks like you do not have any abandoned carts yet.','cartbox-messaging-widgets' ); ?><br><br> <b> <?php esc_html_e( 'After 20 minutes','cartbox-messaging-widgets' ); ?> </b><?php esc_html_e( 'of someone abandoning the cart by filling the Name & Phone number fields of your WooCommerce Checkout form, the message will be sended and the entry will appear here.','cartbox-messaging-widgets' ); ?>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
						<?php } else { ?>
                        <div class="card cbcart_card  w-100">
                            <div class="table-responsive">
                                <table id="cbcart_reporttable" class="table display table-striped w-100" >
                                    <thead>
                                        <tr>
                                            <th><?php  esc_attr_e( 'S.No.' ); ?></th>
                                            <th><?php  esc_attr_e( 'Name' ); ?></th>
                                            <th class="text-nowrap"><?php echo esc_attr_e( 'Contact No.' ); ?></th>
                                            <th><?php  esc_attr_e( 'Time' ); ?></th>
                                            <th><?php  esc_attr_e( 'Status' ); ?></th>
                                            <th class="text-nowrap"><?php  esc_attr_e( 'Message Sent','cartbox-messaging-widgets' ); ?></th>
                                            <th><?php  esc_attr_e( 'Response','cartbox-messaging-widgets' ); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sno = 0;
                                        foreach ( $cbcart_reports_array_premium as $cbcart_key => $cbcart_value ) {
                                            $sno ++; ?>
                                            <tr>
                                                <td><?php
                                                    printf(
                                                        esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                                        esc_html($cbcart_value['cbcart_id'])
                                                    );
                                                     ?></td>
                                                <td><?php
                                                    printf(
                                                        esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                                        esc_html($cbcart_value['cbcart_customer_first_name'])
                                                    ); ?></td>
                                                <td><?php
                                                    printf(
                                                        esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                                        esc_html($cbcart_value['cbcart_mobile_numbers'])
                                                    );
                                                     ?></td>
                                                <td><?php printf(
                                                        esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                                        esc_html($cbcart_value['cbcart_create_date_time'])
                                                    );?></td>
                                                <td><?php

                                                     esc_attr_e( ( $cbcart_value['cbcart_status'] == '2' ) ? 'Recovered' : 'Abandoned' ); ?></td>
                                                <td><?php
                                                    printf(
                                                        esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                                        esc_html( $cbcart_value['cbcart_message_sent'])
                                                    );
                                                     ?></td>
                                                <?php if($cbcart_value['cbcart_message_sent_code']===true){
                                                    $cbcart_response_text= $cbcart_value['cbcart_template_send'];
                                                }
                                                else{
                                                    $cbcart_response_text= stripslashes(json_encode($cbcart_value['cbcart_template_send']));
                                                }?>
                                                <td><?php
                                                    printf(
                                                        esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                                        esc_html( $cbcart_response_text)
                                                    );

                                                    $cbcart_response_text=""; ?></td>
                                            </tr>
                                        <?php } ?>
                                    <tbody>
                                </table>
                            </div>
                        </div>
                    <?php }
                } else { ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card cbcart_card">
                                <div class="row card-body cbcart_card-body">
                                    <h5 class="cbcart_dashboardmsg">
										<?php esc_html_e( 'Looks like your current plan does not support this feature.','cartbox-messaging-widgets' ); ?>
                                        <br/><?php esc_html_e( ' If you want to access this feature please update your plan from','cartbox-messaging-widgets' ); ?> <a href="<?php echo esc_url( cbcart_product_page_url,'cartbox-messaging-widgets' ) ?>" target="_blank"><?php esc_html_e( 'Cartbox.net','cartbox-messaging-widgets' ); ?></a>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
				<?php } ?>
            </div>
        </div>
    </div>
</div>