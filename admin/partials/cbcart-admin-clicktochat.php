<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$cbcart_predefine_text ="";
$cbcart_logo = cbcart_logonew_black;
$cbcart_onlyicon = CBCART_DIR . 'cartbox-messaging-widgets' . '/admin/images/cbcart-icon-1.png';
$cbcart_onlyicon2 = CBCART_DIR . 'cartbox-messaging-widgets' . '/admin/images/cbcart-icon-2.png';
$cbcart_onlyicon3 = CBCART_DIR . 'cartbox-messaging-widgets' . '/admin/images/cbcart-icon-3.png';
$cbcart_onlyicon4 = CBCART_DIR . CBCART_DOMAIN . '/admin/images/cbcart-icon-4.png';
$cbcart_onlyicon5 = CBCART_DIR . CBCART_DOMAIN . '/admin/images/cbcart-icon-5.png';
$cbcart_onlyicon6 = CBCART_DIR . CBCART_DOMAIN . '/admin/images/cbcart-icon-6.png';
$cbcart_onlyicon7 = CBCART_DIR . CBCART_DOMAIN . '/admin/images/cbcart-icon-7.png';
$cbcart_onlyicon8 = CBCART_DIR . CBCART_DOMAIN . '/admin/images/cbcart-icon-8.png';
$cbcart_icon_text = CBCART_DIR . CBCART_DOMAIN . '/admin/images/cbcart-icon-text.png';
$cbcart_data = get_option('cbcart_chat_setting');
$cbcart_data = json_decode($cbcart_data);
$cbcart_data= sanitize_option(  "cbcart_chat_setting",$cbcart_data);
if ($cbcart_data != "") {
    $cbcart_widget_text = $cbcart_data->cbcart_widget_text;
    $cbcart_predefine_text = $cbcart_data->cbcart_predefine_text;
    $cbcart_tooltiptext = $cbcart_data->cbcart_tooltiptext;
    $cbcart_widget_type = $cbcart_data->cbcart_widget_type;
    $cbcart_widget_position = $cbcart_data->cbcart_widget_position;
    $cbcart_icon_type = $cbcart_data->cbcart_icon_type;
    $cbcart_icon = $cbcart_data->cbcart_icon;
    $cbcart_icon_url = $cbcart_data->cbcart_icon_url;
    $cbcart_ispublish = $cbcart_data->cbcart_ispublish;
    $cbcart_is_ac_1=$cbcart_data->cbcart_is_ac_1;
    $cbcart_is_ac_2=$cbcart_data->cbcart_is_ac_2;
    $cbcart_is_ac_3=$cbcart_data->cbcart_is_ac_3;
    $cbcart_chat_account1_name=$cbcart_data->cbcart_chat_account1_name;
    $cbcart_chat_account2_name=$cbcart_data->cbcart_chat_account2_name;
    $cbcart_chat_account3_name=$cbcart_data->cbcart_chat_account3_name;
    $cbcart_chat_account1_role=$cbcart_data->cbcart_chat_account1_role;
    $cbcart_chat_account2_role=$cbcart_data->cbcart_chat_account2_role;
    $cbcart_chat_account3_role=$cbcart_data->cbcart_chat_account3_role;
    $cbcart_chat_account1_number=$cbcart_data->cbcart_chat_account1_number;
    $cbcart_chat_account2_number=$cbcart_data->cbcart_chat_account2_number;
    $cbcart_chat_account3_number=$cbcart_data->cbcart_chat_account3_number;
    $cbcart_chat_account1_avtar_url=$cbcart_data->cbcart_chat_account1_avtar_url;
    $cbcart_chat_account2_avtar_url=$cbcart_data->cbcart_chat_account2_avtar_url;
    $cbcart_chat_account3_avtar_url=$cbcart_data->cbcart_chat_account3_avtar_url;


} else {
    $cbcart_widget_text = "Hi ! How Can I Help You";
    $cbcart_predefine_text= "Hi!";
    $cbcart_tooltiptext = "Chat With Us";
    $cbcart_widget_type = "onlyicon";
    $cbcart_widget_position = "right";
    $cbcart_icon_type = "cbcart_default";
    $cbcart_icon = "cbcart-icon-1";
    $cbcart_icon_url = "";
    $cbcart_ispublish = "1";
    $cbcart_is_ac_1="";
    $cbcart_is_ac_2="";
    $cbcart_is_ac_3="";
    $cbcart_chat_account1_name="";
    $cbcart_chat_account2_name="";
    $cbcart_chat_account3_name="";
    $cbcart_chat_account1_role="";
    $cbcart_chat_account2_role="";
    $cbcart_chat_account3_role="";
    $cbcart_chat_account1_number="";
    $cbcart_chat_account2_number="";
    $cbcart_chat_account3_number="";
    $cbcart_chat_account1_avtar_url="";
    $cbcart_chat_account2_avtar_url="";
    $cbcart_chat_account3_avtar_url="";

}
if($cbcart_predefine_text===""){
    $cbcart_predefine_text= "Hi!";
}
if (isset($_POST['cbcart_chat_submit'])? sanitize_text_field(wp_unslash($_POST['cbcart_chat_submit'])) : '' ) {
    $cbcart_legit = true;
    if (!isset($_POST['cbcart_setup_mobile_nonce'])) {
        $cbcart_legit = false;
    }
    $cbcart_nonce = isset($_POST['cbcart_setup_mobile_nonce']) ? sanitize_text_field(wp_unslash($_POST['cbcart_setup_mobile_nonce'])) : '';
    if (!wp_verify_nonce($cbcart_nonce, 'cbcart_setup_mobile')) {
        $cbcart_legit = false;
    }
    if (!$cbcart_legit) {
        wp_safe_redirect(add_query_arg());
        exit();
    }
    $cbcart_widget_text = isset($_POST['cbcart_widget_text']) ? sanitize_text_field(wp_unslash($_POST['cbcart_widget_text'])) : '';
    $cbcart_predefine_text= isset($_POST['cbcart_predefine_text']) ? sanitize_text_field(wp_unslash($_POST['cbcart_predefine_text'])) : '';
    $cbcart_tooltiptext = isset($_POST['cbcart_tooltiptext']) ? sanitize_text_field(wp_unslash($_POST['cbcart_tooltiptext'])) : '';
    $cbcart_icon_url = isset($_POST['cbcart_icon_url']) ? sanitize_text_field(wp_unslash($_POST['cbcart_icon_url'])) : '';

    if (isset($_POST['cbcart_only_icon'])? sanitize_text_field( $_POST['cbcart_only_icon'] ) : '') {
        $cbcart_widget_type = isset($_POST['cbcart_only_icon']) ? sanitize_text_field($_POST['cbcart_only_icon']) : '';
    } else {
        $cbcart_widget_type = "onlyicon";
    }

    if (isset( $_POST['cbcart_position_radio'] ) ? sanitize_text_field( $_POST['cbcart_position_radio'] ) : '') {
        $cbcart_widget_position = isset($_POST['cbcart_position_radio']) ? sanitize_text_field($_POST['cbcart_position_radio']) : '';
    } else {
        $cbcart_widget_position = "left";
    }
    if (isset($_POST['cbcart_icon_type_radio'])? sanitize_text_field( $_POST['cbcart_icon_type_radio'] ) : '') {
        $cbcart_icon_type = isset($_POST['cbcart_icon_type_radio']) ? sanitize_text_field($_POST['cbcart_icon_type_radio']) : '';
    } else {
        $cbcart_icon_type = "cbcart_default";
    }
    if (isset($_POST['cbcart_icon_set'])? sanitize_text_field( $_POST['cbcart_icon_set'] ) : '') {
        $cbcart_icon = isset($_POST['cbcart_icon_set']) ? sanitize_text_field($_POST['cbcart_icon_set']) : '';
    } else {
        $cbcart_icon = "cbcart-icon-1";
    }
    if (isset($_POST['cbcart_ispublish'])? sanitize_text_field(wp_unslash($_POST['cbcart_ispublish'])) : '') {
        $cbcart_ispublish = "1";
    } else {
        $cbcart_ispublish = "0";
    }
    $cbcart_flag = 1;
    if ($cbcart_tooltiptext === "") {
        $cbcart_flag = 0;
        $cbcart_error_mobileno = '';
        $cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible">';
        $cbcart_error_mobileno .= '<p>' . esc_html('Please Enter tooltip text.','cartbox-messaging-widgets') . '</p>';
        $cbcart_error_mobileno .= '</div>';
        echo wp_kses_post($cbcart_error_mobileno);
    }
    if ($cbcart_widget_text === "") {
        $cbcart_flag = 0;
        $cbcart_error_mobileno = '';
        $cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible">';
        $cbcart_error_mobileno .= '<p>' . esc_html('Please Enter Widget Text.','cartbox-messaging-widgets') . '</p>';
        $cbcart_error_mobileno .= '</div>';
        echo wp_kses_post($cbcart_error_mobileno);
    }
    if ($cbcart_predefine_text === "") {
        $cbcart_flag = 0;
        $cbcart_error_mobileno = '';
        $cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible">';
        $cbcart_error_mobileno .= '<p>' . esc_html('Please Enter Predefine Text.','cartbox-messaging-widgets') . '</p>';
        $cbcart_error_mobileno .= '</div>';
        echo wp_kses_post($cbcart_error_mobileno);
    }

    if ($cbcart_icon_type === "cbcart_custom") {
        if ($cbcart_icon_url === "") {
            $cbcart_flag = 0;
            $cbcart_error_mobileno = '';
            $cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible">';
            $cbcart_error_mobileno .= '<p>' . esc_html('Please Enter Icon URL.','cartbox-messaging-widgets') . '</p>';
            $cbcart_error_mobileno .= '</div>';
            echo wp_kses_post($cbcart_error_mobileno);
        }
        if (!filter_var($cbcart_icon_url, FILTER_VALIDATE_URL)) {
            $cbcart_flag = 0;
            $cbcart_error_mobileno = '';
            $cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible">';
            $cbcart_error_mobileno .= '<p>' . esc_html('Please Enter valid Icon URL.','cartbox-messaging-widgets') . '</p>';
            $cbcart_error_mobileno .= '</div>';
            echo wp_kses_post($cbcart_error_mobileno);
        }
        if ((strpos($cbcart_icon_url, 'localhost')) != "") {
            $cbcart_flag = 0;
            $cbcart_error_mobileno = '';
            $cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible">';
            $cbcart_error_mobileno .= '<p>' . esc_html('The given URL contains Localhost. Please Enter correct URL','cartbox-messaging-widgets') . '</p>';
            $cbcart_error_mobileno .= '</div>';
            echo wp_kses_post($cbcart_error_mobileno);
        }
    }
    if ($cbcart_flag === 1) {
        $cbcart_update_arr = array(
            'cbcart_widget_text' => $cbcart_widget_text,
            'cbcart_predefine_text' => $cbcart_predefine_text,
            'cbcart_tooltiptext' => $cbcart_tooltiptext,
            'cbcart_widget_type' => $cbcart_widget_type,
            'cbcart_widget_position' => $cbcart_widget_position,
            'cbcart_icon_type' => $cbcart_icon_type,
            'cbcart_icon' => $cbcart_icon,
            'cbcart_icon_url' => $cbcart_icon_url,
            'cbcart_ispublish' => $cbcart_ispublish,
            'cbcart_is_ac_1'=>$cbcart_is_ac_1,
            'cbcart_is_ac_2'=>$cbcart_is_ac_2,
            'cbcart_is_ac_3'=>$cbcart_is_ac_3,
            'cbcart_chat_account1_name'=>$cbcart_chat_account1_name,
            'cbcart_chat_account2_name'=>$cbcart_chat_account2_name,
            'cbcart_chat_account3_name'=>$cbcart_chat_account3_name,
            'cbcart_chat_account1_role'=>$cbcart_chat_account1_role,
            'cbcart_chat_account2_role'=>$cbcart_chat_account2_role,
            'cbcart_chat_account3_role'=>$cbcart_chat_account3_role,
            'cbcart_chat_account1_number'=>$cbcart_chat_account1_number,
            'cbcart_chat_account2_number'=>$cbcart_chat_account2_number,
            'cbcart_chat_account3_number'=>$cbcart_chat_account3_number,
            'cbcart_chat_account1_avtar_url'=>$cbcart_chat_account1_avtar_url,
            'cbcart_chat_account2_avtar_url'=>$cbcart_chat_account2_avtar_url,
            'cbcart_chat_account3_avtar_url'=>$cbcart_chat_account3_avtar_url,

        );
        $cbcart_result = update_option('cbcart_chat_setting', wp_json_encode($cbcart_update_arr));

        $cbcart_success = '';
        $cbcart_success .= '<div class="notice notice-success is-dismissible">';
        $cbcart_success .= '<p>' . esc_html('Details update successfully.','cartbox-messaging-widgets') . '</p>';
        $cbcart_success .= '</div>';
        echo wp_kses_post($cbcart_success);
    }
}
if (isset($_POST['cbcart_chat_aacount_submit'])? sanitize_text_field(wp_unslash($_POST['cbcart_chat_aacount_submit'])) : ''){
    $cbcart_legit = true;
    if (!isset($_POST['cbcart_setup_nonce'])) {
        $cbcart_legit = false;
    }
    $cbcart_nonce = isset($_POST['cbcart_setup_nonce']) ? sanitize_text_field(wp_unslash($_POST['cbcart_setup_nonce'])) : '';
    if (!wp_verify_nonce($cbcart_nonce, 'cbcart_setup')) {
        $cbcart_legit = false;
    }
    if (!$cbcart_legit) {
        wp_safe_redirect(add_query_arg());
        exit();
    }

    if (isset($_POST['cbcart_is_ac_1'])? sanitize_text_field(wp_unslash($_POST['cbcart_is_ac_1'])) : '') {
        $cbcart_is_ac_1 = '1';
        $cbcart_ispublish="1";
    } else {
        $cbcart_is_ac_1 = '0';
    }
    if (isset($_POST['cbcart_is_ac_2'])? sanitize_text_field(wp_unslash($_POST['cbcart_is_ac_2'])) : '') {
        $cbcart_is_ac_2 = '1';
        $cbcart_ispublish="1";
    } else {
        $cbcart_is_ac_2 = '0';
    }
    if (isset($_POST['cbcart_is_ac_3'])? sanitize_text_field(wp_unslash($_POST['cbcart_is_ac_3'])) : '') {
        $cbcart_is_ac_3 = '1';
        $cbcart_ispublish="1";
    } else {
        $cbcart_is_ac_3 = '0';
    }
    if($cbcart_is_ac_1 === '0' && $cbcart_is_ac_2 === '0' && $cbcart_is_ac_3 === '0') {
        $cbcart_ispublish="0";
    }
    $cbcart_chat_account1_name = isset($_POST['cbcart_chat_account1_name']) ? sanitize_text_field(wp_unslash($_POST['cbcart_chat_account1_name'])) : '';
    $cbcart_chat_account2_name = isset($_POST['cbcart_chat_account2_name']) ? sanitize_text_field(wp_unslash($_POST['cbcart_chat_account2_name'])) : '';
    $cbcart_chat_account3_name = isset($_POST['cbcart_chat_account3_name']) ? sanitize_text_field(wp_unslash($_POST['cbcart_chat_account3_name'])) : '';
    $cbcart_chat_account1_role = isset($_POST['cbcart_chat_account1_role']) ? sanitize_text_field(wp_unslash($_POST['cbcart_chat_account1_role'])) : '';
    $cbcart_chat_account2_role = isset($_POST['cbcart_chat_account2_role']) ? sanitize_text_field(wp_unslash($_POST['cbcart_chat_account2_role'])) : '';
    $cbcart_chat_account3_role = isset($_POST['cbcart_chat_account3_role']) ? sanitize_text_field(wp_unslash($_POST['cbcart_chat_account3_role'])) : '';
    $cbcart_chat_account1_number = isset($_POST['cbcart_chat_account1_number']) ? sanitize_text_field(wp_unslash($_POST['cbcart_chat_account1_number'])) : '';
    $cbcart_chat_account2_number = isset($_POST['cbcart_chat_account2_number']) ? sanitize_text_field(wp_unslash($_POST['cbcart_chat_account2_number'])) : '';
    $cbcart_chat_account3_number = isset($_POST['cbcart_chat_account3_number']) ? sanitize_text_field(wp_unslash($_POST['cbcart_chat_account3_number'])) : '';
    $cbcart_chat_account1_avtar_url = isset($_POST['cbcart_chat_account1_avtar_url']) ? sanitize_text_field(wp_unslash($_POST['cbcart_chat_account1_avtar_url'])) : '';
    $cbcart_chat_account2_avtar_url = isset($_POST['cbcart_chat_account2_avtar_url']) ? sanitize_text_field(wp_unslash($_POST['cbcart_chat_account2_avtar_url'])) : '';
    $cbcart_chat_account3_avtar_url = isset($_POST['cbcart_chat_account3_avtar_url']) ? sanitize_text_field(wp_unslash($_POST['cbcart_chat_account3_avtar_url'])) : '';
    $cbcart_flag=1;
    if($cbcart_is_ac_1=== '1'){
            if (empty($cbcart_chat_account1_number)) {
                $cbcart_flag = 0;
                $cbcart_error_mobileno = '';
                $cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible">';
                $cbcart_error_mobileno .= '<p>' . esc_html('Please Enter Mobile Number In Account1.','cartbox-messaging-widgets') . '</p>';
                $cbcart_error_mobileno .= '</div>';
                echo wp_kses_post($cbcart_error_mobileno);
            }elseif (preg_match('#[^0-9]#', $cbcart_chat_account1_number)) {
                $cbcart_flag = 0;
                $cbcart_error_mobileno = '';
                $cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible">';
                $cbcart_error_mobileno .= '<p>' . esc_html('Please Enter Only Numbers In Account1.','cartbox-messaging-widgets') . '</p>';
                $cbcart_error_mobileno .= '</div>';
                echo wp_kses_post($cbcart_error_mobileno);
            }
            if (empty($cbcart_chat_account1_name)) {
                $cbcart_flag = 0;
                $cbcart_error_mobileno = '';
                $cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible">';
                $cbcart_error_mobileno .= '<p>' . esc_html('Please Enter Name In Account1.','cartbox-messaging-widgets') . '</p>';
                $cbcart_error_mobileno .= '</div>';
                echo wp_kses_post($cbcart_error_mobileno);
            }
            if (empty($cbcart_chat_account1_role)) {
                $cbcart_flag = 0;
                $cbcart_error_mobileno = '';
                $cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible">';
                $cbcart_error_mobileno .= '<p>' . esc_html('Please Enter Role / Designation In Account1.','cartbox-messaging-widgets') . '</p>';
                $cbcart_error_mobileno .= '</div>';
                echo wp_kses_post($cbcart_error_mobileno);
            }

        }
    if($cbcart_is_ac_2=== '1'){
        if (empty($cbcart_chat_account2_number)) {
            $cbcart_flag = 0;
            $cbcart_error_mobileno = '';
            $cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible">';
            $cbcart_error_mobileno .= '<p>' . esc_html('Please Enter Mobile Number In Account2.','cartbox-messaging-widgets') . '</p>';
            $cbcart_error_mobileno .= '</div>';
            echo wp_kses_post($cbcart_error_mobileno);
        }elseif (preg_match('#[^0-9]#', $cbcart_chat_account2_number)) {
            $cbcart_flag = 0;
            $cbcart_error_mobileno = '';
            $cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible">';
            $cbcart_error_mobileno .= '<p>' . esc_html('Please Enter Only Numbers In Account2.','cartbox-messaging-widgets') . '</p>';
            $cbcart_error_mobileno .= '</div>';
            echo wp_kses_post($cbcart_error_mobileno);
        }
        if (empty($cbcart_chat_account2_name)) {
            $cbcart_flag = 0;
            $cbcart_error_mobileno = '';
            $cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible">';
            $cbcart_error_mobileno .= '<p>' . esc_html('Please Enter Name In Account2.','cartbox-messaging-widgets') . '</p>';
            $cbcart_error_mobileno .= '</div>';
            echo wp_kses_post($cbcart_error_mobileno);
        }
        if (empty($cbcart_chat_account2_role)) {
            $cbcart_flag = 0;
            $cbcart_error_mobileno = '';
            $cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible">';
            $cbcart_error_mobileno .= '<p>' . esc_html('Please Enter Role / Designation In Account2.','cartbox-messaging-widgets') . '</p>';
            $cbcart_error_mobileno .= '</div>';
            echo wp_kses_post($cbcart_error_mobileno);
        }
    }
    if($cbcart_is_ac_3=== '1'){
        if (empty($cbcart_chat_account3_number)) {
            $cbcart_flag = 0;
            $cbcart_error_mobileno = '';
            $cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible">';
            $cbcart_error_mobileno .= '<p>' . esc_html('Please Enter Mobile Number In Account3.','cartbox-messaging-widgets') . '</p>';
            $cbcart_error_mobileno .= '</div>';
            echo wp_kses_post($cbcart_error_mobileno);
        }elseif (preg_match('#[^0-9]#', $cbcart_chat_account3_number)) {
            $cbcart_flag = 0;
            $cbcart_error_mobileno = '';
            $cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible">';
            $cbcart_error_mobileno .= '<p>' . esc_html('Please Enter Only Numbers In Account3.','cartbox-messaging-widgets') . '</p>';
            $cbcart_error_mobileno .= '</div>';
            echo wp_kses_post($cbcart_error_mobileno);
        }
        if (empty($cbcart_chat_account3_name)) {
            $cbcart_flag = 0;
            $cbcart_error_mobileno = '';
            $cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible">';
            $cbcart_error_mobileno .= '<p>' . esc_html('Please Enter Name In Account3.','cartbox-messaging-widgets') . '</p>';
            $cbcart_error_mobileno .= '</div>';
            echo wp_kses_post($cbcart_error_mobileno);
        }
        if (empty($cbcart_chat_account3_role)) {
            $cbcart_flag = 0;
            $cbcart_error_mobileno = '';
            $cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible">';
            $cbcart_error_mobileno .= '<p>' . esc_html('Please Enter Role / Designation In Account3.','cartbox-messaging-widgets') . '</p>';
            $cbcart_error_mobileno .= '</div>';
            echo wp_kses_post($cbcart_error_mobileno);
        }
    }

    if($cbcart_flag ===1){
        $cbcart_update_arr = array(
            'cbcart_widget_text' => $cbcart_widget_text,
            'cbcart_predefine_text'=>$cbcart_predefine_text,
            'cbcart_tooltiptext' => $cbcart_tooltiptext,
            'cbcart_widget_type' => $cbcart_widget_type,
            'cbcart_widget_position' => $cbcart_widget_position,
            'cbcart_icon_type' => $cbcart_icon_type,
            'cbcart_icon' => $cbcart_icon,
            'cbcart_icon_url' => $cbcart_icon_url,
            'cbcart_ispublish' => $cbcart_ispublish,
            'cbcart_is_ac_1'=>$cbcart_is_ac_1,
            'cbcart_is_ac_2'=>$cbcart_is_ac_2,
            'cbcart_is_ac_3'=>$cbcart_is_ac_3,
            'cbcart_chat_account1_name'=>$cbcart_chat_account1_name,
            'cbcart_chat_account2_name'=>$cbcart_chat_account2_name,
            'cbcart_chat_account3_name'=>$cbcart_chat_account3_name,
            'cbcart_chat_account1_role'=>$cbcart_chat_account1_role,
            'cbcart_chat_account2_role'=>$cbcart_chat_account2_role,
            'cbcart_chat_account3_role'=>$cbcart_chat_account3_role,
            'cbcart_chat_account1_number'=>$cbcart_chat_account1_number,
            'cbcart_chat_account2_number'=>$cbcart_chat_account2_number,
            'cbcart_chat_account3_number'=>$cbcart_chat_account3_number,
            'cbcart_chat_account1_avtar_url'=>$cbcart_chat_account1_avtar_url,
            'cbcart_chat_account2_avtar_url'=>$cbcart_chat_account2_avtar_url,
            'cbcart_chat_account3_avtar_url'=>$cbcart_chat_account3_avtar_url,
        );
        $cbcart_result = update_option('cbcart_chat_setting', wp_json_encode($cbcart_update_arr));

        $cbcart_success = '';
        $cbcart_success .= '<div class="notice notice-success is-dismissible">';
        $cbcart_success .= '<p>' . esc_html('Details update successfully.','cartbox-messaging-widgets') . '</p>';
        $cbcart_success .= '</div>';
        echo wp_kses_post($cbcart_success);
    }

}


?>
<div class="container">
    <div>
        <img src="<?php
        printf(
            esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
            esc_html($cbcart_logo)
        );
        ?>" class="cbcart_imgclass"
             alt="<?php esc_attr('logo','cartbox-messaging-widgets'); ?>">
    </div>
    <label class="text-capitalize cbcart-label3">
        <b><?php esc_html_e('Cartbox click to chat','cartbox-messaging-widgets'); ?></b>
    </label>
</div>

<div class="container">
    <div class="tabbable boxed parentTabs m-2">
        <div id="cbcart_setting_tabs" class="cbcart_nav cbcart_nav_settings">
            <ul class="nav nav-tabs cbcart_nav_tabs">
                <li><label class="active cbcart_nav_text"><?php esc_html_e('WhatsApp','cartbox-messaging-widgets'); ?></label>
                </li>
            </ul>
        </div>
    </div>
    <div class="card cbcart_card w-75 cbcart_settings_card">
        <div class="tabbable boxed parentTabs m-2">
            <div id="cbcart_setting_tabs" class="cbcart_nav cbcart_nav_settings">
                <ul class="nav nav-tabs cbcart_nav_tabs">
                    <li><a href="#cbcart_set1" class="active cbcart_nav_text bg-transparent">
                                <?php esc_html_e('Account Settings','cartbox-messaging-widgets') ?>
                        </a>
                    </li>
                    <li><a href="#cbcart_set2" class="cbcart_nav_text bg-transparent">
                            <?php esc_html_e('Appearance Settings','cartbox-messaging-widgets') ?>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade active in show" id="cbcart_set1">
                    <form name="cbcart_form_1" method="post">
                        <div class="card cbcart_card w-100">
                            <div class="d-flex align-items-center justify-content-between">
                                <label class="cbcart_sub_label my-3"> <?php esc_html_e('WhatsApp Account 1','cartbox-messaging-widgets'); ?></label>
                                <?php if ($cbcart_is_ac_1 == '1') { ?>
                                    <label class="cbcart_switch">
                                        <input type="checkbox" checked id="cbcart_is_ac_1" name="cbcart_is_ac_1"/>
                                        <span class="cbcart_slider cbcart_round"></span>
                                    </label>
                                <?php } else { ?>
                                    <label class="cbcart_switch">
                                        <input type="checkbox" id="cbcart_is_ac_1" name="cbcart_is_ac_1"/>
                                        <span class="cbcart_slider cbcart_round"></span>
                                    </label>
                                <?php } ?>
                            </div>
                            <hr class="my-1">
                            <div id="cbcart_display_ac_1" class="d-none form-group">
                                <div class="mb-3">
                                    <div class="row mt-2 justify-content-between align-items-center">
                                        <div class="col-4">
                                            <label class="text-capitalize cbcart-label3">
                                                <?php esc_html_e('Name','cartbox-messaging-widgets') ?>
                                            </label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" name="cbcart_chat_account1_name" class="form-control" value="<?php
                                            printf(
                                                esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                                esc_html($cbcart_chat_account1_name)
                                            );
                                             ?>">
                                        </div>
                                    </div>
                                    <div class="row mt-2 justify-content-between align-items-center">
                                        <div class="col-4">
                                            <label class="text-capitalize cbcart-label3"><?php esc_html_e('WhatsApp number','cartbox-messaging-widgets'); ?>
                                                <span class="cbcart_required_star">*</span>
                                            </label>
                                        </div>
                                        <div class="col-8 d-flex">
                                            <input type="number" name="cbcart_chat_account1_number" value="<?php
                                            printf(
                                                esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                                esc_html($cbcart_chat_account1_number)
                                            );

                                            ?>" id="" autocomplete="off" maxlength="200" placeholder="<?php esc_attr_e('Enter Number With Country Code','cartbox-messaging-widgets') ?>" class="form-control"/>
                                        </div>
                                    </div>
                                    <div class="row mt-2 justify-content-between align-items-center">
                                        <div class="col-4">
                                            <label class="text-capitalize cbcart-label3"><?php esc_html_e('Role / Designation','cartbox-messaging-widgets'); ?>
                                            </label>
                                        </div>
                                        <div class="col-8 d-flex">
                                            <input type="text" name="cbcart_chat_account1_role" id="" value="<?php
                                            printf(
                                                esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                                esc_html($cbcart_chat_account1_role)
                                            );
                                            ?>" class="form-control"/>
                                        </div>
                                    </div>
                                    <div class="row mt-2 justify-content-between align-items-center">
                                        <div class="col-4">
                                            <label class="text-capitalize cbcart-label3"><?php esc_attr_e('Profile Avtar URL','cartbox-messaging-widgets'); ?>
                                            </label>
                                        </div>
                                        <div class="col-8 d-flex">
                                            <input type="url" name="cbcart_chat_account1_avtar_url" id="" value="<?php
                                            printf(
                                                esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                                esc_html($cbcart_chat_account1_avtar_url)
                                            );
                                            ?>" class="form-control"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card cbcart_card w-100">
                            <div class="d-flex align-items-center justify-content-between">
                                <label class="cbcart_sub_label my-3"> <?php esc_html_e('WhatsApp Account 2','cartbox-messaging-widgets'); ?></label>
                                <?php if ($cbcart_is_ac_2 == '1') { ?>
                                    <label class="cbcart_switch">
                                        <input type="checkbox" checked id="cbcart_is_ac_2" name="cbcart_is_ac_2"/>
                                        <span class="cbcart_slider cbcart_round"></span>
                                    </label>
                                <?php } else { ?>
                                    <label class="cbcart_switch">
                                        <input type="checkbox" id="cbcart_is_ac_2" name="cbcart_is_ac_2"/>
                                        <span class="cbcart_slider cbcart_round"></span>
                                    </label>
                                <?php } ?>
                            </div>
                            <hr class="my-1">
                            <div id="cbcart_display_ac_2" class="d-none form-group">
                            <div class="mb-3">
                                <div class="row mt-2 justify-content-between align-items-center">
                                    <div class="col-4">
                                        <label class="text-capitalize cbcart-label3">
                                            <?php esc_html_e('Name' ,'cartbox-messaging-widgets') ?>
                                        </label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" name="cbcart_chat_account2_name" class="form-control" value="<?php
                                        printf(
                                            esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                            esc_html($cbcart_chat_account2_name)
                                        );
                                         ?>">
                                    </div>
                                </div>
                                <div class="row mt-2 justify-content-between align-items-center">
                                    <div class="col-4">
                                        <label class="text-capitalize cbcart-label3"><?php esc_html_e('WhatsApp number','cartbox-messaging-widgets'); ?>
                                            <span class="cbcart_required_star">*</span>
                                        </label>
                                    </div>
                                    <div class="col-8 d-flex">

                                        <input type="number" name="cbcart_chat_account2_number" placeholder="<?php esc_html_e('Enter Number With Country Code','cartbox-messaging-widgets') ?>"
                                               id="cbcart_cf7admin_mobileno" value="<?php
                                        printf(
                                            esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                            esc_html($cbcart_chat_account2_number)
                                        );
                                        ?>"
                                               autocomplete="off" maxlength="200" class="form-control"/>
                                    </div>
                                </div>
                                <div class="row mt-2 justify-content-between align-items-center">
                                    <div class="col-4">
                                        <label class="text-capitalize cbcart-label3"><?php esc_html_e('Role / Designation','cartbox-messaging-widgets'); ?>
                                        </label>
                                    </div>
                                    <div class="col-8 d-flex">
                                        <input type="text" name="cbcart_chat_account2_role" value="<?php
                                        printf(
                                            esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                            esc_html($cbcart_chat_account2_role)
                                        );
                                        ?>" id="" class="form-control"/>
                                    </div>
                                </div>
                                <div class="row mt-2 justify-content-between align-items-center">
                                    <div class="col-4">
                                        <label class="text-capitalize cbcart-label3"><?php esc_html_e('Profile Avtar URL','cartbox-messaging-widgets'); ?>
                                        </label>
                                    </div>
                                    <div class="col-8 d-flex">
                                        <input type="url" name="cbcart_chat_account2_avtar_url" id=""
                                               value="<?php
                                               printf(
                                                   esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                                   esc_html($cbcart_chat_account2_avtar_url)
                                               );
                                             ?>"    class="form-control"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                        <div class="card cbcart_card  w-100">
                    <div class="d-flex align-items-center justify-content-between">
                        <label class="cbcart_sub_label my-3"> <?php esc_html_e('WhatsApp Account 3','cartbox-messaging-widgets'); ?></label>
                        <?php if ($cbcart_is_ac_3 == '1') { ?>
                            <label class="cbcart_switch">
                                <input type="checkbox" checked id="cbcart_is_ac_3" name="cbcart_is_ac_3"/>
                                <span class="cbcart_slider cbcart_round"></span>
                            </label>
                        <?php } else { ?>
                            <label class="cbcart_switch">
                                <input type="checkbox" id="cbcart_is_ac_3" name="cbcart_is_ac_3"/>
                                <span class="cbcart_slider cbcart_round"></span>
                            </label>
                        <?php } ?>
                    </div>
                    <hr class="my-1">
                    <div id="cbcart_display_ac_3" class="d-none form-group">
                        <div class="mb-3">
                            <div class="row mt-2 justify-content-between align-items-center">
                                <div class="col-4">
                                    <label class="text-capitalize cbcart-label3">
                                        <?php esc_html_e('Name' ,'cartbox-messaging-widgets'); ?>
                                    </label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="cbcart_chat_account3_name" value="<?php
                                    printf(
                                        esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                        esc_html($cbcart_chat_account3_name)
                                    );
                                    ?>" class="form-control">
                                </div>
                            </div>
                            <div class="row mt-2 justify-content-between align-items-center">
                                <div class="col-4">
                                    <label class="text-capitalize cbcart-label3"><?php esc_html_e('WhatsApp number','cartbox-messaging-widgets'); ?>
                                        <span class="cbcart_required_star">*</span>
                                    </label>
                                </div>
                                <div class="col-8 d-flex">

                                    <input type="number" name="cbcart_chat_account3_number" id="cbcart_cf7admin_mobileno"
                                           placeholder="<?php esc_attr_e('Enter Number With Country Code','cartbox-messaging-widgets') ?>"  autocomplete="off" maxlength="200" value="<?php
                                    printf(
                                        esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                        esc_html($cbcart_chat_account3_number)
                                    );
                                   ?>" class="form-control"/>
                                </div>
                            </div>
                            <div class="row mt-2 justify-content-between align-items-center">
                                <div class="col-4">
                                    <label class="text-capitalize cbcart-label3"><?php esc_html_e('Role / Designation','cartbox-messaging-widgets'); ?>
                                    </label>
                                </div>
                                <div class="col-8 d-flex">
                                    <input type="text" name="cbcart_chat_account3_role" value="<?php
                                    printf(
                                        esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                        esc_html($cbcart_chat_account3_role)
                                    );
                                     ?>" id="" class="form-control"/>
                                </div>
                            </div>
                            <div class="row mt-2 justify-content-between align-items-center">
                                <div class="col-4">
                                    <label class="text-capitalize cbcart-label3"><?php esc_html_e('Profile Avtar URL','cartbox-messaging-widgets'); ?>
                                    </label>
                                </div>
                                <div class="col-8 d-flex">
                                    <input type="url" name="cbcart_chat_account3_avtar_url" value="<?php
                                    printf(
                                        esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                        esc_html($cbcart_chat_account3_avtar_url)
                                    );
                                    ?>" id="" class="form-control"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                        <div class="row mt-4">
                            <div class="col-12 text-center">
                                <?php  wp_nonce_field( 'cbcart_setup', 'cbcart_setup_nonce' ); ?>
                                <input type="submit" name="cbcart_chat_aacount_submit" value="Save" class="btn cbcart_btn-theme">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="cbcart_set2">
                <form name="cbcart_form" method="post">
                    <div class="row  mt-4">
                        <div class="col-3">
                            <label class="text-capitalize cbcart-label3 p-0">
                                <?php esc_html_e("select one layout :",'cartbox-messaging-widgets') ?>
                            </label>
                        </div>
                        <div class="col-4 mt-0 text-center">
                            <label class="cbcart-label3"><?php esc_html_e('Only Icon','cartbox-messaging-widgets') ?></label>
                            <label class="card mt-0 bg-light align-items-center cbcart_chat_card"
                                   class=" <?php if (($cbcart_widget_type === "onlyicon") || ($cbcart_widget_type === "")) {
                                       esc_html_e('cbcart_border shadow');
                                   } ?> " id="cbcart_chat_card1">
                                <input type="radio" name="cbcart_only_icon"
                                       class="card-input-element d-none" <?php if (($cbcart_widget_type === "onlyicon") || ($cbcart_widget_type === "")) {
                                    esc_html_e(' checked');
                                } ?> value="onlyicon">
                                <div class="">
                                    <img class="cbcart_icon_img mt-2" src="<?php echo esc_url($cbcart_onlyicon) ?>">
                                </div>
                            </label>
                        </div>
                        <div class="col-4 mt-0 text-center">
                            <label class="cbcart-label3"><?php esc_html_e('Text with Icon','cartbox-messaging-widgets') ?></label>
                            <label class="card mt-0 bg-light align-items-center cbcart_chat_card <?php if (($cbcart_widget_type === "icontext")) {
                                esc_html_e('cbcart_border shadow');
                            } ?>" id="cbcart_chat_card2">
                                <input type="radio" name="cbcart_only_icon"
                                       class="card-input-element d-none" <?php if (($cbcart_widget_type === "icontext")) {
                                    esc_html_e('checked');
                                } ?> value="icontext">
                                <div class="">
                                    <img class="cbcart_icon_text mt-2"
                                         src="<?php
                                         printf(
                                             esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                             esc_html($cbcart_icon_text)
                                         );
                                         ?>">
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="row  mt-4">
                        <div class="col-3">
                            <label class="text-capitalize cbcart-label3 p-0">
                                <?php esc_html_e("Message Text :",'cartbox-messaging-widgets') ?>
                            </label>
                        </div>
                        <div class="col-4">
                            <input type="text" id="cbcart_predefine_text" name="cbcart_predefine_text" class="cbcart_message w-100"
                                   value="<?php esc_attr_e($cbcart_predefine_text,'cartbox-messaging-widgets'  ) ?>">
                        </div>
                    </div>
                    <div class="row  mt-4">
                        <div class="col-3">
                            <label class="text-capitalize cbcart-label3 p-0">
                                <?php esc_html_e("Widget text :",'cartbox-messaging-widgets') ?>
                            </label>
                        </div>
                        <div class="col-5" id="cbcart_widget_text_div">
                            <input id="cbcart_widget_text" type="text" name="cbcart_widget_text"
                                   class="cbcart_message w-75" value="<?php esc_attr_e($cbcart_widget_text,'cartbox-messaging-widgets'); ?>"
                                   readonly>
                            <i class='fa fa-info-circle px-1' id="cbcart_widget_tooltip"
                               title='Enable Icon With Text' data-toggle='tooltip'></i>
                        </div>
                    </div>
                    <div class="row  mt-4">
                        <div class="col-3">
                            <label class="text-capitalize cbcart-label3 p-0">
                                <?php esc_html_e("Widget Tooltip Text :",'cartbox-messaging-widgets') ?>
                            </label>
                        </div>
                        <div class="col-4">
                            <input type="text" name="cbcart_tooltiptext" class="cbcart_message w-100"
                                   value="<?php esc_attr_e($cbcart_tooltiptext ,'cartbox-messaging-widgets' ) ?>">
                        </div>
                    </div>
                    <div class="row  mt-4">
                        <div class="col-3">
                            <label class="text-capitalize cbcart-label3 p-0">
                                <?php esc_html_e("Widget Position :",'cartbox-messaging-widgets') ?>
                            </label>
                        </div>
                        <div class="col-3 ">
                            <label class="cbcart-label3"><input type="radio" name="cbcart_position_radio"
                                                                class="form-control "
                                                                value="left" <?php if ($cbcart_widget_position === "left") {
                                    esc_html_e('checked');
                                } ?> >&nbsp;&nbsp;&nbsp;<?php esc_html_e('Left Bottom','cartbox-messaging-widgets') ?></label>
                        </div>
                        <div class="col-3">
                            <label class="cbcart-label3"><input type="radio" name="cbcart_position_radio"
                                                                class="form-control "
                                                                value="right" <?php if ($cbcart_widget_position === "right" || $cbcart_widget_position === "") {
                                    esc_html_e('checked');
                                } ?> >&nbsp;&nbsp;&nbsp;<?php esc_html_e('Right Bottom','cartbox-messaging-widgets') ?></label>
                        </div>
                    </div>
                    <div class="row  mt-4">
                        <div class="col-3">
                            <label class="text-capitalize cbcart-label3 p-0">
                                <?php esc_html_e("Widget Icon Type :",'cartbox-messaging-widgets') ?>
                            </label>
                        </div>
                        <div class="col-3">
                            <label class="cbcart-label3 cbcart_icon_type_div"><input type="radio"
                                                                                     name="cbcart_icon_type_radio"
                                                                                     class="form-control "
                                                                                     value="cbcart_default" <?php if ($cbcart_icon_type === "cbcart_default" || $cbcart_icon_type === "") {
                                    esc_html_e('checked');
                                } ?> >&nbsp;&nbsp;&nbsp;<?php esc_html_e('Default Icon','cartbox-messaging-widgets') ?></label>
                        </div>
                        <div class="col-3">
                            <label class="cbcart-label3 cbcart_icon_type_div"><input type="radio"
                                                                                     name="cbcart_icon_type_radio"
                                                                                     class="form-control "
                                                                                     value="cbcart_custom" <?php if ($cbcart_icon_type === "cbcart_custom") {
                                    esc_html_e('checked');
                                } ?>>&nbsp;&nbsp;&nbsp;<?php esc_html_e('Custom Icon','cartbox-messaging-widgets') ?></label>
                        </div>
                    </div>
                    <div class="row  mt-4">
                        <div class="col-3">
                            <label class="text-capitalize cbcart-label3 p-0">
                                <?php esc_html_e("select any one Icon   :",'cartbox-messaging-widgets') ?>
                            </label>
                        </div>
                        <div class="col-1 mt-0">
                            <label class="card mt-0 bg-light align-items-center cbcart_chat_icon_card <?php if ($cbcart_icon === "cbcart-icon-1" || $cbcart_icon === "") {
                                esc_html_e('cbcart_border shadow');
                            } ?> " id="cbcart_chat_card1">
                                <input type="radio" name="cbcart_icon_set"
                                       class="card-input-element d-none" <?php if ($cbcart_icon === "cbcart-icon-1" || $cbcart_icon === "") {
                                    esc_html_e('checked');
                                } ?> value="cbcart-icon-1">
                                <img class="cbcart_icon_img " src="<?php

                                echo esc_url($cbcart_onlyicon) ?>">
                            </label>
                        </div>
                        <div class="col-1 mt-0">
                            <label class="card mt-0 bg-light align-items-center cbcart_chat_icon_card <?php if ($cbcart_icon === "cbcart-icon-2") {
                                esc_html_e('cbcart_border shadow' ,'cartbox-messaging-widgets' );
                            } ?> " id="cbcart_chat_card2">
                                <input type="radio" name="cbcart_icon_set"
                                       class="card-input-element d-none" <?php if ($cbcart_icon === "cbcart-icon-2") {
                                    esc_html_e('checked');
                                } ?> value="cbcart-icon-2">
                                <img class="cbcart_icon_img" src="<?php echo esc_url($cbcart_onlyicon2) ?>">
                            </label>
                        </div>
                        <div class="col-1 mt-0">
                            <label class="card mt-0 bg-light align-items-center cbcart_chat_icon_card <?php if ($cbcart_icon === "cbcart-icon-3") {
                                esc_html_e('cbcart_border shadow');
                            } ?> " id="cbcart_chat_card3">
                                <input type="radio" name="cbcart_icon_set"
                                       class="card-input-element d-none" <?php if ($cbcart_icon === "cbcart-icon-3") {
                                    esc_html_e('checked');
                                } ?> value="cbcart-icon-3">
                                <img class="cbcart_icon_img" src="<?php echo esc_url($cbcart_onlyicon3) ?>">
                            </label>
                        </div>
                        <div class="col-1 mt-0">
                            <label class="card mt-0 bg-light align-items-center cbcart_chat_icon_card <?php if ($cbcart_icon === "cbcart-icon-4") {
                                esc_html_e('cbcart_border shadow');
                            } ?> " id="cbcart_chat_card4">
                                <input type="radio" name="cbcart_icon_set"
                                       class="card-input-element d-none" <?php if ($cbcart_icon_type === "cbcart-icon-4") {
                                    esc_html_e('checked');
                                } ?> value="cbcart-icon-4">
                                <img class="cbcart_icon_img" src="<?php echo esc_url($cbcart_onlyicon4) ?>">
                            </label>
                        </div>
                        <div class="col-1 mt-0">
                            <label class="card mt-0 bg-light align-items-center cbcart_chat_icon_card <?php if ($cbcart_icon === "cbcart-icon-5") {
                                esc_html_e('cbcart_border shadow');
                            } ?> " id="cbcart_chat_card5">
                                <input type="radio" name="cbcart_icon_set"
                                       class="card-input-element d-none" <?php if ($cbcart_icon === "cbcart-icon-5") {
                                    esc_html_e('checked');
                                } ?> value="cbcart-icon-5">
                                <img class="cbcart_icon_img" src="<?php echo esc_url($cbcart_onlyicon5) ?>">
                            </label>
                        </div>
                        <div class="col-1 mt-0">
                            <label class="card mt-0 bg-light align-items-center cbcart_chat_icon_card <?php if ($cbcart_icon === "cbcart-icon-6") {
                                esc_html_e('cbcart_border shadow');
                            } ?> " id="cbcart_chat_card6">
                                <input type="radio" name="cbcart_icon_set"
                                       class="card-input-element d-none" <?php if ($cbcart_icon === "cbcart-icon-6") {
                                    esc_html_e('checked');
                                } ?> value="cbcart-icon-6">
                                <img class="cbcart_icon_img" src="<?php echo esc_url($cbcart_onlyicon6) ?>">
                            </label>
                        </div>
                        <div class="col-1 mt-0">
                            <label class="card mt-0 bg-light align-items-center cbcart_chat_icon_card <?php if ($cbcart_icon === "cbcart-icon-7") {
                                esc_html_e('cbcart_border shadow');
                            } ?> " id="cbcart_chat_card7">
                                <input type="radio" name="cbcart_icon_set"
                                       class="card-input-element d-none" <?php if ($cbcart_icon === "cbcart-icon-7") {
                                    esc_html_e('checked');
                                } ?> value="cbcart-icon-7">
                                <img class="cbcart_icon_img" src="<?php echo esc_url($cbcart_onlyicon7) ?>">
                            </label>
                        </div>
                        <div class="col-1 mt-0">
                            <label class="card mt-0 bg-light align-items-center cbcart_chat_icon_card <?php if ($cbcart_icon === "cbcart-icon-8") {
                                esc_html_e('cbcart_border shadow');
                            } ?> " id="cbcart_chat_card8">
                                <input type="radio" name="cbcart_icon_set"
                                       class="card-input-element d-none" <?php if ($cbcart_icon === "cbcart-icon-8") {
                                    esc_html_e('checked');
                                } ?> value="cbcart-icon-8">
                                <img class="cbcart_icon_img" src="<?php echo esc_url($cbcart_onlyicon8) ?>">
                            </label>
                        </div>
                    </div>
                    <div class="row  mt-4">
                        <div class="col-3">
                            <label class="text-capitalize cbcart-label3 p-0">
                                <?php esc_html_e("Custom Icon Link :",'cartbox-messaging-widgets') ?>
                            </label>
                        </div>
                        <div class="col-5">
                            <input type="url" name="cbcart_icon_url" class="cbcart_message w-75"
                                   id="cbcart_icon_link" value="<?php esc_html_e($cbcart_icon_url,'cartbox-messaging-widgets') ?>" readonly>
                            <i class='fa fa-info-circle px-1' id="cbcart_icon_type_tooltip"
                               title='Enable Custom Icon' data-toggle='tooltip'></i>
                        </div>
                    </div>
                    <div class="row  mt-4">
                        <div class="col-3">
                            <label class="text-capitalize cbcart-label3 p-0">
                                <?php esc_html_e("Publish :",'cartbox-messaging-widgets') ?>
                            </label>
                        </div>
                        <div class="col-4">
                            <label class="cbcart-label3">
                                <input type="checkbox" class="form-control"
                                       name="cbcart_ispublish" <?php  if ($cbcart_ispublish === "1") {?> checked <?php } ?>>
                            </label>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12 text-center">
                            <?php wp_nonce_field( 'cbcart_setup_mobile', 'cbcart_setup_mobile_nonce' ); ?>
                            <input type="submit" name="cbcart_chat_submit" value="Save"
                                   class="btn cbcart_btn-theme">
                        </div>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
</div>
