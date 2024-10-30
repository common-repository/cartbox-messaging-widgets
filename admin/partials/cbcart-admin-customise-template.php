<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$cbcart_selected_template = "";
global $wpdb;
$table_prefix = $wpdb->prefix;
$cbcart_table_name = 'cbcart_template';
$cbcart_template_table = $table_prefix . "$cbcart_table_name";
$cbcart_data = get_option('cbcart_customisetemplate');
$cbcart_data = json_decode($cbcart_data);
$cbcart_data             =  sanitize_option(  "cbcart_customisetemplate",$cbcart_data);
if ($cbcart_data != "") {
    $cbcart_ct_template_num = $cbcart_data->cbcart_template_num;
    $cbcart_ct_template_name = $cbcart_data->cbcart_template_name;
    $cbcart_ct_template_lang = $cbcart_data->cbcart_template_lang;
} else {
    $cbcart_ct_template_num = "";
    $cbcart_ct_template_name = "";
    $cbcart_ct_template_lang = "";
}
//set header text as per template type
$cbcart_template_type = "";
if (str_contains($cbcart_ct_template_num, 'ac_1')) {
    $cbcart_template_type = "You are editing the template for Abandoned Cart - Message Reminder 1.";
    $cbcart_temp_option_name="cbcart_abandoned_1";
} elseif (str_contains($cbcart_ct_template_num, 'ac_2')) {
    $cbcart_template_type = "You are editing the template for Abandoned Cart - Message Reminder 2.";
    $cbcart_temp_option_name="cbcart_abandoned_2";
} elseif (str_contains($cbcart_ct_template_num, 'ac_3')) {
    $cbcart_template_type = "You are editing the template for Abandoned Cart - Message Reminder 3.";
    $cbcart_temp_option_name="cbcart_abandoned_3";
} elseif (str_contains($cbcart_ct_template_num, 'ac_4')) {
    $cbcart_template_type = "You are editing the template for Abandoned Cart - Message Reminder 4.";
    $cbcart_temp_option_name="cbcart_abandoned_4";
} elseif (str_contains($cbcart_ct_template_num, 'ac_5')) {
    $cbcart_template_type = "You are editing the template for Abandoned Cart - Message Reminder 5.";
    $cbcart_temp_option_name="cbcart_abandoned_5";
} elseif (str_contains($cbcart_ct_template_num, 'order_a')) {
    $cbcart_template_type = "You are editing the template for Order Notification - for Admin Message.";
    $cbcart_temp_option_name="cbcart_order_admin";
} elseif (str_contains($cbcart_ct_template_num, 'order_c')) {
    $cbcart_template_type = "You are editing the template for Order Notification - for Customer Message.";
    $cbcart_temp_option_name="cbcart_order_customer";
}elseif (str_contains($cbcart_ct_template_num, 'cf7_admin')) {
    $cbcart_template_type = "You are editing the template for ContactForm 7 submisson - for Admin Message.";
    $cbcart_temp_option_name="cbcart_cf7_admin";
}elseif (str_contains($cbcart_ct_template_num, 'cf7_customer')) {
    $cbcart_template_type = "You are editing the template for ContactForm 7 submisson - for Customer Message.";
    $cbcart_temp_option_name="cbcart_cf7_customer";
} else {
    $cbcart_template_type = "";
    $cbcart_temp_option_name="";
}
//get current template
$cbcart_get_template_type = cbcart::cbcart_get_template_type($cbcart_ct_template_name, $cbcart_ct_template_lang);
$cbcart_ct_header_text = $cbcart_get_template_type['cbcart_header_text'];
$cbcart_ct_header_video = $cbcart_get_template_type['cbcart_header_video'];
$cbcart_ct_header_doc = $cbcart_get_template_type['cbcart_header_doc'];
$cbcart_ct_is_body = $cbcart_get_template_type['cbcart_is_body'];
$cbcart_ct_body_text = $cbcart_get_template_type['cbcart_body_text'];
$cbcart_ct_footer = $cbcart_get_template_type['cbcart_footer'];
$cbcart_ct_is_buttons = $cbcart_get_template_type['cbcart_is_buttons'];

//get all templates
$cbcart_template_status = "APPROVED";
$cbcart_temp_data = $wpdb->prepare("SELECT cbcart_template_name,cbcart_template_language FROM $cbcart_template_table WHERE cbcart_template_status= %s", $cbcart_template_status); //db call ok; no-cache ok
$cbcart_Response_string = $wpdb->get_results($cbcart_temp_data);
$cbcart_Response_string = json_decode(json_encode($cbcart_Response_string), true);
$cbcart_template = "";
$cbcart_template_language = "";

//get selected template
$cbcart_i = 0;
$cbcart_turnon_customise = "";
if ($cbcart_turnon_customise === "") {
    $cbcart_turnon_customise = 0;
}
foreach ($cbcart_Response_string as $cbcart_re_string) {
    $cbcart_i++;
    $cbcart_temp_s_name = 'cbcart_s_temp_name' . $cbcart_i;
    $cbcart_temp_s_btn = 'cbcart_s_temp_btn' . $cbcart_i;
    if (isset($_POST[$cbcart_temp_s_btn])) {
        $cbcart_selected_template = isset($_POST[$cbcart_temp_s_name]) ? sanitize_text_field(wp_unslash($_POST[$cbcart_temp_s_name])) : '';
        $cbcart_turnon_customise = 1;
    }
}
if (isset($_POST['cbcart_current_template_btn'])) {
    $cbcart_legit   = true;
    if ( ! isset( $_POST['cbcart_c_temp_nonce'] ) ) {
        $cbcart_legit = false;
    }
    $nonce = isset( $_POST['cbcart_c_temp_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['cbcart_c_temp_nonce'] ) ) : '';
    if ( ! wp_verify_nonce( $nonce, 'cbcart_c_temp' ) ) {
        $cbcart_legit = false;
    }
    if ( ! $cbcart_legit ) {
        wp_safe_redirect( add_query_arg() );
        exit();
    }
    $cbcart_selected_template = isset($_POST['cbcart_current_template_name']) ? sanitize_text_field(wp_unslash($_POST['cbcart_current_template_btn'])) : '';
    if ($cbcart_selected_template === "") {
        $cbcart_selected_template = $cbcart_ct_template_name;
    }
    $cbcart_turnon_customise = 1;
}

//back to template selection
if (isset($_POST['cbcart_scrn_back_btn'])) {
    $cbcart_legit   = true;
    if ( ! isset( $_POST['cbcart_back_nonce'] ) ) {
        $cbcart_legit = false;
    }
    $nonce = isset( $_POST['cbcart_back_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['cbcart_back_nonce'] ) ) : '';
    if ( ! wp_verify_nonce( $nonce, 'cbcart_back' ) ) {
        $cbcart_legit = false;
    }
    if ( ! $cbcart_legit ) {
        wp_safe_redirect( add_query_arg() );
        exit();
    }
    delete_option('cbcart_customisetemplate');
    $cbcart_page = isset( $_REQUEST['page'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['page'] ) ) : '';
    wp_redirect( 'admin.php?page=' . $cbcart_page );
}

if (isset($_POST['cbcart_temp_back_btn'])) {
    $cbcart_legit   = true;
    if ( ! isset( $_POST['cbcart_temp_back_nonce'] ) ) {
        $cbcart_legit = false;
    }
    $nonce = isset( $_POST['cbcart_temp_back_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['cbcart_temp_back_nonce'] ) ) : '';
    if ( ! wp_verify_nonce( $nonce, 'cbcart_temp_back' ) ) {
        $cbcart_legit = false;
    }
    if ( ! $cbcart_legit ) {
        wp_safe_redirect( add_query_arg() );
        exit();
    }
    $cbcart_turnon_customise = 0;
}
//save temp data
if(isset($_POST['cbcart_temp_save_btn'])){
    $cbcart_legit   = true;
    if ( ! isset( $_POST['cbcart_s_temp_nonce'] ) ) {
        $cbcart_legit = false;
    }
    $nonce = isset( $_POST['cbcart_s_temp_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['cbcart_s_temp_nonce'] ) ) : '';
    if ( ! wp_verify_nonce( $nonce, 'cbcart_s_temp' ) ) {
        $cbcart_legit = false;
    }
    if ( ! $cbcart_legit ) {
        wp_safe_redirect( add_query_arg() );
        exit();
    }

    $cbcart_final_template_name        = isset($_POST['cbcart_final_template_name']) ? sanitize_textarea_field(wp_unslash($_POST['cbcart_final_template_name'])) : '';
    $cbcart_final_template_lan       = isset($_POST['cbcart_final_template_lan']) ? sanitize_textarea_field(wp_unslash($_POST['cbcart_final_template_lan'])) : '';
    $cbcart_final_template_text       = isset($_POST['cbcart_final_template_text']) ? sanitize_textarea_field(wp_unslash($_POST['cbcart_final_template_text'])) : '';

    $cbcart_get_selected_template_type = cbcart::cbcart_get_template_type($cbcart_final_template_name, $cbcart_final_template_lan);
    $cbcart_st_is_header = $cbcart_get_selected_template_type['cbcart_is_header'];
    $cbcart_st_header_image = $cbcart_get_selected_template_type['cbcart_header_image'];
    $cbcart_st_header_text = $cbcart_get_selected_template_type['cbcart_header_text'];
    $cbcart_st_header_video = $cbcart_get_selected_template_type['cbcart_header_video'];
    $cbcart_st_header_doc = $cbcart_get_selected_template_type['cbcart_header_doc'];
    $cbcart_st_is_body = $cbcart_get_selected_template_type['cbcart_is_body'];
    $cbcart_st_body_text = $cbcart_get_selected_template_type['cbcart_body_text'];
    $cbcart_st_footer = $cbcart_get_selected_template_type['cbcart_footer'];
    $cbcart_st_is_buttons = $cbcart_get_selected_template_type['cbcart_is_buttons'];
    $cbcart_st_is_buttons_with_url = $cbcart_get_selected_template_type['cbcart_is_button_with_url'];

    $cbcart_i=0;
    $cbcart_turnon_customise = 1;
    $cbcart_para_count=0;
    for($cbcart_i=1;$cbcart_i<10;$cbcart_i++){
        $cbcart_d_name="cbcart_para".$cbcart_i;
        if(isset($_POST[$cbcart_d_name])){
            $cbcart_para_count++;
            $cbcart_d_name = sanitize_text_field(wp_unslash($_POST[$cbcart_d_name]));
            $cbcart_temp_para[] =$cbcart_d_name;
        }
        else{
            $cbcart_temp_para==="";
        }
    }
    if($cbcart_st_header_image==="true") {
        $cbcart_temp_image            = isset($_POST['cbcart_selected_img_url']) ? sanitize_textarea_field(wp_unslash($_POST['cbcart_selected_img_url'])) : '';
        if($cbcart_temp_image===""){
            $cbcart_flag          = 0;
            $cbcart_error_message = '';
            $cbcart_error_message .= '<div class="notice notice-error is-dismissible">';
            $cbcart_error_message .= '<p>' . esc_html( 'Image path is empty.','cartbox-messaging-widgets' ) . '</p>';
            $cbcart_error_message .= '</div>';
            echo wp_kses_post( $cbcart_error_message );
        }
    }else{
        $cbcart_temp_image="false";
    }
    if($cbcart_st_is_buttons==="true" && $cbcart_st_is_buttons_with_url!=""|| $cbcart_st_is_buttons_with_url==="false"){
        if(isset($_POST['cbcart_btn1_url'])){
            $cbcart_btn1_url = sanitize_text_field(wp_unslash($_POST['cbcart_btn1_url']));
            $cbcart_temp_btn_url=$cbcart_btn1_url;
            $cbcart_st_btn_count="1";        }
    }
    else{
        $cbcart_temp_btn_url="false";
        $cbcart_st_btn_count="0";
    }
    if($cbcart_st_is_header!="true"){
        $cbcart_st_is_header="false";
    }
    if($cbcart_st_header_text!="true"){
        $cbcart_st_header_text="false";
    }
    $cbcart_update_option_arr = array(
        'cbcart_temp_name' => $cbcart_final_template_name,
        'cbcart_temp_language'=>$cbcart_final_template_lan,
        'cbcart_is_header'=>$cbcart_st_is_header,
        'cbcart_is_header_text'=>$cbcart_st_header_text,
        'cbcart_is_header_image_url'=>$cbcart_temp_image,
        'cbcart_is_body'=>$cbcart_st_is_body,
        'cbcart_body_param_array'=>$cbcart_temp_para,
        'cbcart_body_param_count'=>$cbcart_para_count,
        'cbcart_is_button_count'=>$cbcart_st_btn_count,
        'cbcart_is_button_url_1'=>$cbcart_temp_btn_url,
    );
    $cbcart_result1 = update_option($cbcart_temp_option_name, wp_json_encode($cbcart_update_option_arr));
    $cbcart_selected_template=$cbcart_final_template_name;
    delete_option('cbcart_customisetemplate');
    //update abandoned or order option
    $cbcart_temp=0;
    for($cbcart_k=0;$cbcart_k<10;$cbcart_k++){
        $cbcart_j="{{".$cbcart_k."}}";
        if(str_contains($cbcart_final_template_text,$cbcart_j)){
            $cbcart_final_template_text=str_replace($cbcart_j,$cbcart_temp_para[$cbcart_temp] , $cbcart_final_template_text);
            $cbcart_temp++;
        }
    }
//function call update
    cbcart_update_option($cbcart_ct_template_num,$cbcart_final_template_name,$cbcart_final_template_lan,$cbcart_final_template_text);

    $cbcart_page = isset( $_REQUEST['page'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['page'] ) ) : '';
    wp_redirect( 'admin.php?page=' . $cbcart_page );
    $cbcart_turnon_customise = 1;
}

function cbcart_update_option($cbcart_t_type,$cbcart_t_name,$cbcart_t_lan,$cbcart_t_text){
    if (str_contains($cbcart_t_type, 'ac')) {

        $cbcart_data = get_option('cbcart_abandonedsettings');
        $cbcart_data = json_decode($cbcart_data);
        $cbcart_data             =  sanitize_option(  "cbcart_abandonedsettings",$cbcart_data);
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
            $cbcart_data = "";
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
            $cbcart_ac_template3_lang = "";
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

        if($cbcart_t_type==="ac_1"){
            $cbcart_ac_template_name=$cbcart_t_name;
            $cbcart_ac_template_lang=$cbcart_t_lan;
            $cbcart_ac_message=$cbcart_t_text;
        }
        if($cbcart_t_type==="ac_2"){
            $cbcart_ac_template2_name=$cbcart_t_name;
            $cbcart_ac_template2_lang=$cbcart_t_lan;
            $cbcart_ac_message2=$cbcart_t_text;
        }
        if($cbcart_t_type==="ac_3"){
            $cbcart_ac_template3_name=$cbcart_t_name;
            $cbcart_ac_template3_lang=$cbcart_t_lan;
            $cbcart_ac_message3=$cbcart_t_text;
        }
        if($cbcart_t_type==="ac_4"){
            $cbcart_ac_template4_name=$cbcart_t_name;
            $cbcart_ac_template4_lang=$cbcart_t_lan;
            $cbcart_ac_message4=$cbcart_t_text;
        }
        if($cbcart_t_type==="ac_5"){
            $cbcart_ac_template5_name=$cbcart_t_name;
            $cbcart_ac_template5_lang=$cbcart_t_lan;
            $cbcart_ac_message5=$cbcart_t_text;
        }

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
    }
    if (str_contains($cbcart_t_type, 'order')) {
        $cbcart_data1 = get_option('cbcart_ordernotificationsettings');
        $cbcart_data1 = json_decode($cbcart_data1);
        $cbcart_data1             =  sanitize_option(  "cbcart_ordernotificationsettings",$cbcart_data1);
        if($cbcart_data1!="") {
            $cbcart_admin_mobileno = $cbcart_data1->cbcart_admin_mobileno;
            $cbcart_admin_message = $cbcart_data1->cbcart_admin_message;
            $cbcart_admin_template_name = $cbcart_data1->cbcart_admin_template_name;
            $cbcart_admin_template_lang = $cbcart_data1->cbcart_admin_template_lang;
            $cbcart_admin_template_varcount = $cbcart_data1->cbcart_admin_template_varcount;
            $cbcart_customer_message = $cbcart_data1->cbcart_customer_message;
            $cbcart_customer_template_name = $cbcart_data1->cbcart_customer_template_name;
            $cbcart_customer_template_lang = $cbcart_data1->cbcart_customer_template_lang;
            $cbcart_customer_template_varcount = $cbcart_data1->cbcart_customer_template_varcount;
            $cbcart_customer_notification = $cbcart_data1->cbcart_customer_notification;
            $cbcart_admin_notification = $cbcart_data1->cbcart_admin_notification;
            $cbcart_order_image = $cbcart_data1->cbcart_order_image;
            $cbcart_is_order_completed=$cbcart_data1->cbcart_is_order_completed;
            $cbcart_is_order_processing=$cbcart_data1->cbcart_is_order_processing;
            $cbcart_is_order_payment_done=$cbcart_data1->cbcart_is_order_payment_done;
        }else{
            $cbcart_admin_message = "";
            $cbcart_admin_template_name ="";
            $cbcart_admin_template_lang = "";
            $cbcart_admin_template_varcount = "";
            $cbcart_customer_message = "";
            $cbcart_customer_template_name = "";
            $cbcart_customer_template_lang = "";
            $cbcart_customer_template_varcount = "";
            $cbcart_customer_notification = "";
            $cbcart_admin_notification="";
            $cbcart_order_image = "";
        }
        if($cbcart_t_type==="order_a"){
            $cbcart_admin_template_name = $cbcart_t_name;
            $cbcart_admin_template_lang = $cbcart_t_lan;
            $cbcart_admin_message = $cbcart_t_text;
        }
        if($cbcart_t_type==="order_c"){
            $cbcart_customer_template_name = $cbcart_t_name;
            $cbcart_customer_template_lang = $cbcart_t_lan;
            $cbcart_customer_message = $cbcart_t_text;
        }
        $cbcart_update_notifications_arr = array(
            'cbcart_admin_mobileno'             => $cbcart_admin_mobileno,
            'cbcart_admin_message'              => $cbcart_admin_message,
            'cbcart_admin_template_name'        => $cbcart_admin_template_name,
            'cbcart_admin_template_lang'        => $cbcart_admin_template_lang,
            'cbcart_admin_template_varcount'    => $cbcart_admin_template_varcount,
            'cbcart_customer_message'           => $cbcart_customer_message,
            'cbcart_customer_template_name'     => $cbcart_customer_template_name,
            'cbcart_customer_template_lang'     => $cbcart_customer_template_lang,
            'cbcart_customer_template_varcount' => $cbcart_customer_template_varcount,
            'cbcart_customer_notification'      => $cbcart_customer_notification,
            'cbcart_admin_notification'      => $cbcart_admin_notification,
            'cbcart_order_image'                => $cbcart_order_image,
            'cbcart_is_order_completed'         =>$cbcart_is_order_completed,
            'cbcart_is_order_processing'         =>$cbcart_is_order_processing,
            'cbcart_is_order_payment_done'         =>$cbcart_is_order_payment_done,
        );
        $cbcart_result3 = update_option('cbcart_ordernotificationsettings', wp_json_encode($cbcart_update_notifications_arr));
    }
    if (str_contains($cbcart_t_type, 'cf7')) {
        $cbcart_data1 = get_option('cbcart_contactformsettings');
        $cbcart_data1 = json_decode($cbcart_data1);
        $cbcart_data1             =  sanitize_option(  "cbcart_contactformsettings",$cbcart_data1);
        if($cbcart_data1!="") {
            $cbcart_cf7admin_mobileno = $cbcart_data1->cbcart_cf7admin_mobileno;
            $cbcart_cf7admin_template_name = $cbcart_data1->cbcart_cf7admin_template_name;
            $cbcart_cf7admin_template_language = $cbcart_data1->cbcart_cf7admin_template_language;
            $cbcart_cf7admin_message = $cbcart_data1->cbcart_cf7admin_message;
            $cbcart_cf7admin_template_varcount = $cbcart_data1->cbcart_cf7admin_template_varcount;
            $cbcart_cf7enable_notification = $cbcart_data1->cbcart_cf7enable_notification;
            $cbcart_cf7customer_template_name = $cbcart_data1->cbcart_cf7customer_template_name;
            $cbcart_cf7customer_template_language = $cbcart_data1->cbcart_cf7customer_template_language;
            $cbcart_cf7customer_message = $cbcart_data1->cbcart_cf7customer_message;
            $cbcart_cf7customer_template_varcount = $cbcart_data1->cbcart_cf7customer_template_varcount;
            $cbcart_cf7customer_notification = $cbcart_data1->cbcart_cf7customer_notification;
        }else{
            $cbcart_cf7admin_mobileno = "";
            $cbcart_cf7admin_template_name = "";
            $cbcart_cf7admin_template_language = "";
            $cbcart_cf7admin_message ="";
            $cbcart_cf7admin_template_varcount ="";
            $cbcart_cf7enable_notification = "";
            $cbcart_cf7customer_template_name ="";
            $cbcart_cf7customer_template_language = "";
            $cbcart_cf7customer_message = "";
            $cbcart_cf7customer_template_varcount = "";
            $cbcart_cf7customer_notification = "";
        }
        if($cbcart_t_type==="cf7_admin"){
            $cbcart_cf7admin_template_name = $cbcart_t_name;
            $cbcart_cf7admin_template_language = $cbcart_t_lan;
            $cbcart_cf7admin_message = $cbcart_t_text;
        }
        if($cbcart_t_type==="cf7_customer"){
            $cbcart_cf7customer_template_name = $cbcart_t_name;
            $cbcart_cf7customer_template_language = $cbcart_t_lan;
            $cbcart_cf7customer_message = $cbcart_t_text;
        }
        $cbcart_update_notifications_arr = array(
            'cbcart_cf7admin_mobileno'          => $cbcart_cf7admin_mobileno,
            'cbcart_cf7admin_template_name'     => $cbcart_cf7admin_template_name,
            'cbcart_cf7admin_template_language' => $cbcart_cf7admin_template_language,
            'cbcart_cf7admin_template_varcount' => $cbcart_cf7admin_template_varcount,
            'cbcart_cf7admin_message'           => $cbcart_cf7admin_message,
            'cbcart_cf7enable_notification'     => $cbcart_cf7enable_notification,
            'cbcart_cf7customer_template_name'   =>  $cbcart_cf7customer_template_name,
            'cbcart_cf7customer_template_language'   =>$cbcart_cf7customer_template_language,
            'cbcart_cf7customer_template_varcount'   =>$cbcart_cf7customer_template_varcount,
            'cbcart_cf7customer_message'    =>  $cbcart_cf7customer_message ,
            'cbcart_cf7customer_notification' => $cbcart_cf7customer_notification,
        );
        $cbcart_result3 = update_option('cbcart_contactformsettings', wp_json_encode($cbcart_update_notifications_arr));
    }

}

//image for support section
$cbcart_logo1 = CBCART_DIR . CBCART_DOMAIN . esc_url('/admin/images/cbcart-Globeicon.png');
$cbcart_logo2 = CBCART_DIR . CBCART_DOMAIN . esc_url('/admin/images/cbcart-chatsupport.png');

?>

<div class="container">
    <div id="cbcart_select_div">
        <form method="post">
            <?php wp_nonce_field( 'cbcart_back', 'cbcart_back_nonce' ); ?>
            <button class="btn cbcart_temp_green_btn cbcart_left_btn" type="submit" name="cbcart_scrn_back_btn">
                <?php esc_html_e('Back','cartbox-messaging-widgets') ?>
            </button>
            <?php wp_nonce_field( 'cbcart_c_temp', 'cbcart_c_temp_nonce' ); ?>
            <button class="btn cbcart_btn-theme cbcart_right_btn m-0" type="submit" name="cbcart_current_template_btn">
                <?php esc_html_e('Continue','cartbox-messaging-widgets') ?>
            </button>
        </form>
        <div class=" text-center cbcart_scren1_body">
            <label class="cbcart_label"><?php esc_html_e(' Customise Templates','cartbox-messaging-widgets'); ?></label>
            <br>
            <label class="cbcart_row-content mt-2">
                <?php echo
                printf(
                    esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                    esc_html($cbcart_template_type)
                );
                ?>
            </label>
        </div>

        <label class="cbcart_lbl3"><?php esc_html_e(' Current Template','cartbox-messaging-widgets'); ?></label>
        <div class="row">
            <div class="col-4 card-group p-2">
                <div class="cbcart_custome_temp cbcart_template_card p-3 shadow">
                    <div class="d-flex justify-content-between">
                        <label class="cbcart_temp_text2"><?php

                            printf(
                                esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                esc_html($cbcart_ct_template_name)
                            );
                            ?></label>
                        <form class="cbcart_ct_form" method="post">
                            <input type="hidden" value="<?php
                            printf(
                                esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                esc_html($cbcart_ct_template_name)
                            );
                           ?>" name="cbcart_current_template_name"/>
                            <?php wp_nonce_field( 'cbcart_c_temp', 'cbcart_c_temp_nonce' ); ?>
                            <button class="cbcart_temp_btn " type="submit" name="cbcart_current_template_btn"><?php esc_html_e(' Select','cartbox-messaging-widgets'); ?></button>
                        </form>
                    </div>
                    <label class="cbcart_temp_text1"><?php
                        printf(
                            esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                            esc_html($cbcart_ct_template_lang)
                        );

                         ?></label>
                    <div class="cbcart_temp_text3">
                        <?php printf(
                            esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                            esc_html($cbcart_ct_body_text)
                        );
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <label class="cbcart_lbl3 mb-2"><?php esc_html_e(' Available WhatsApp Templates','cartbox-messaging-widgets'); ?></label>
        <div class="row">
            <?php
            $cbcart_i = 0;
            foreach ($cbcart_Response_string as $cbcart_value) {
                $cbcart_i++;
                $cbcart_template = $cbcart_value['cbcart_template_name'];
                $cbcart_template_language = $cbcart_value['cbcart_template_language'];
                $cbcart_get_template_type = cbcart::cbcart_get_template_type($cbcart_template, $cbcart_template_language);
                $cbcart_header_image = $cbcart_get_template_type['cbcart_header_image'];
                $cbcart_header_text = $cbcart_get_template_type['cbcart_header_text'];
                $cbcart_header_video = $cbcart_get_template_type['cbcart_header_video'];
                $cbcart_header_doc = $cbcart_get_template_type['cbcart_header_doc'];
                $cbcart_is_buttons = $cbcart_get_template_type['cbcart_is_buttons'];
                $cbcart_is_button_with_url = $cbcart_get_template_type['cbcart_is_button_with_url'];

                if ($cbcart_header_video === "true" || $cbcart_header_doc === "true") {
                    continue;
                }
                if($cbcart_is_buttons==="true" && $cbcart_is_button_with_url==="false"){
                    continue;
                }
                $cbcart_body_text = $cbcart_get_template_type['cbcart_body_text'];
                ?>
                <div class="col-4 card-group p-2">
                    <div class="cbcart_custome_temp cbcart_template_card p-3 shadow">
                        <div class="d-flex justify-content-between">
                            <?php
                            $cbcart_temp_s_name = 'cbcart_s_temp_name' . $cbcart_i;
                            $cbcart_temp_s_btn = 'cbcart_s_temp_btn' . $cbcart_i;
                            ?>
                            <label class="cbcart_temp_text2"><?php
                                printf(
                                    esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                    esc_html($cbcart_template)
                                );
                                ?></label>
                            <form class="" method="post">
                                <input type="hidden" value="<?php
                                printf(
                                    esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                    esc_html($cbcart_template)
                                );
                                 ?>" name="<?php
                                printf(
                                    esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                    esc_html($cbcart_temp_s_name)
                                );
                                ?>">
                                <button class="cbcart_temp_btn" type="submit" name="<?php
                                printf(
                                    esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                    esc_html($cbcart_temp_s_btn)
                                );
                                ?>"><?php esc_html_e(' Select','cartbox-messaging-widgets'); ?></button>
                            </form>
                        </div>
                        <label class="cbcart_temp_text1"><?php
                            printf(
                                esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                esc_html($cbcart_template_language)
                            );
                           ?></label>

                <div class="cbcart_temp_text3">
                            <?php
                            printf(
                                esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                esc_html($cbcart_body_text)
                            );
                           ?>
                        </div>
                    </div>
                </div>
            <?php }
            ?>
        </div>
    </div>
    <label class="d-none" id="cbcart_check_customise_div"><?php
        printf(
            esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
            esc_html($cbcart_turnon_customise)
        );

        ?></label>
    <div class="m-3 d-none d-flex" id="cbcart_cutomise_div">
        <div class="w-75">
            <div class=" text-center cbcart_scren1_body">
                <label class="cbcart_label"><?php esc_html_e(' Customise Templates','cartbox-messaging-widgets'); ?></label>
                <br>
                <label class="cbcart_row-content mt-2">
                    <?php
                    printf(
                        esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                        esc_html($cbcart_template_type)
                    );
                   ?>
                </label>
            </div>
            <div class="card cbcart_card">
                <form class="cbcart_form w-100" method="post">
                    <?php
                    $cbcart_selected_temp_data = $wpdb->prepare("SELECT cbcart_template_name,cbcart_template_language FROM $cbcart_template_table WHERE cbcart_template_name= %s", $cbcart_selected_template); //db call ok; no-cache ok
                    $cbcart_selected_Response_string = $wpdb->get_results($cbcart_selected_temp_data);
                    $cbcart_selected_Response_string = json_decode(json_encode($cbcart_selected_Response_string), true);
                    foreach ($cbcart_selected_Response_string as $cbcart_value) {
                        $cbcart_selected_template_name = $cbcart_value['cbcart_template_name'];
                        $cbcart_selected_template_language = $cbcart_value['cbcart_template_language'];
                    }
                    $cbcart_get_selected_template_type = cbcart::cbcart_get_template_type($cbcart_selected_template_name, $cbcart_selected_template_language);
                    $cbcart_st_is_header = $cbcart_get_selected_template_type['cbcart_is_header'];
                    $cbcart_st_header_image = $cbcart_get_selected_template_type['cbcart_header_image'];
                    $cbcart_st_header_text = $cbcart_get_selected_template_type['cbcart_header_text'];
                    $cbcart_st_header_video = $cbcart_get_selected_template_type['cbcart_header_video'];
                    $cbcart_st_header_doc = $cbcart_get_selected_template_type['cbcart_header_doc'];
                    $cbcart_st_is_body = $cbcart_get_selected_template_type['cbcart_is_body'];
                    $cbcart_st_body_text = $cbcart_get_selected_template_type['cbcart_body_text'];
                    $cbcart_st_footer = $cbcart_get_selected_template_type['cbcart_footer'];
                    $cbcart_st_is_buttons = $cbcart_get_selected_template_type['cbcart_is_buttons'];
                    $cbcart_st_is_buttons_with_url = $cbcart_get_selected_template_type['cbcart_is_button_with_url'];

                    ?>
                    <div class="row p-0">
                        <div class="col-6">
                            <label class="cbcart_label3"><?php

                                esc_html_e('Name :','cartbox-messaging-widgets'); ?>
                            </label>
                            <label class="cbcart_temp_text2"> <?php
                                printf(
                                    esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                    esc_html($cbcart_selected_template_name)
                                );
                                 ?></label>
                            <input type="hidden" name="cbcart_final_template_name" value="<?php
                            printf(
                                esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                esc_html($cbcart_selected_template_name)
                            );
                            ?>">
                        </div>
                        <div class="col-6">
                            <label class="cbcart_label3"><?php  esc_html_e('Language :','cartbox-messaging-widgets'); ?>
                            </label>
                            <label class="cbcart_temp_text2"> <?php

                                printf(
                                    esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                    esc_html($cbcart_selected_template_language)
                                );
                                 ?></label>
                            <input type="hidden" name="cbcart_final_template_lan" value="<?php
                            printf(
                                esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                esc_html($cbcart_selected_template_language)
                            ); ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="cbcart_current_div">
                                <label id="cbcart_st_body_text" class="d-none"><?php
                                    printf(
                                        esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                        esc_html($cbcart_st_body_text)
                                    );
                                     ?></label>
                                <input type="hidden" name="cbcart_final_template_text" value="<?php
                                printf(
                                    esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                    esc_html($cbcart_st_body_text)
                                );
                               ?>">
                                <label id="cbcart_ct_template_num" class="d-none"><?php
                                    printf(
                                        esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                        esc_html($cbcart_ct_template_num)
                                    );
                                    ?></label>
                                <div class="cbcart_current_text" id="cbcart_current_text"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <?php if($cbcart_st_header_image==="true"){ ?>
                        <div class="col-6">
                            <label> <?php esc_html_e('Image URL ','cartbox-messaging-widgets') ?></label>
                            <input type="url" name="cbcart_selected_img_url" class="cbcart_message  form-control w-100"/>
                        </div>
                        <?php }
                        if($cbcart_st_is_buttons_with_url!="" && $cbcart_st_is_buttons==="true"){?>
                        <div class="col-6">
                            <label for="cbcart_btn1_url"> <?php esc_html_e('Button 1 Link','cartbox-messaging-widgets') ?></label>
                            <br>
                            <select name="cbcart_btn1_url" id="cbcart_btn1_url" class="cbcart_message cbcart_image_url_drop pt-1 pb-1 w-100 form-control">
                                <?php
                                if (str_contains($cbcart_ct_template_num, 'ac')) { ?>
                                    <option value="{{checkouturl}}"><?php esc_html_e('{{checkouturl}}','cartbox-messaging-widgets') ?></option>
                                <?php } ?>
                                <option value="{{storeurl}}" selected><?php esc_html_e('{{storeurl}}','cartbox-messaging-widgets') ?></option>
                            </select>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="d-flex justify-content-center mt-5">
                        <?php wp_nonce_field( 'cbcart_temp_back', 'cbcart_temp_back_nonce' ); ?>
                        <button class="btn cbcart_temp_green_btn m-2" type="submit" name="cbcart_temp_back_btn">
                            <?php esc_html_e('Back','cartbox-messaging-widgets') ?>
                        </button>
                        <?php wp_nonce_field( 'cbcart_s_temp', 'cbcart_s_temp_nonce' ); ?>
                        <button class="btn cbcart_btn-theme m-2" type="submit" name="cbcart_temp_save_btn">
                            <?php esc_html_e('Save and continue','cartbox-messaging-widgets') ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="w-25 mt-5">
            <div class="mt-5 card cbcart_card cbcart_support_card_static">
                <img src="<?php echo esc_url($cbcart_logo2); ?>" class="cbcart_chatimg"/>
                <div class="card-body p-1">
                    <div><label class="cbcart_lbl"><?php esc_html_e('Need Support: ','cartbox-messaging-widgets'); ?>
                        </label><br></div>
                    <div class="mt-3"><img src="<?php echo esc_url($cbcart_logo1); ?>" class="cbcart_globeimg"/><a href="<?php echo esc_url( cbcart_product_page_url); ?>" target="_blank" class="cbcart_supportlabel"><?php esc_html_e('Website','cartbox-messaging-widgets'); ?></a><br></div>
                    <div class="mt-3"><i class="fa  fa-comment-o"></i><a href="<?php echo esc_url( cbcart_site); ?>" target="_blank" class="cbcart_supportlabel"><?php esc_html_e('Chat','cartbox-messaging-widgets'); ?></a><br>
                    </div>
                    <div class="mt-3"><i class="fa  fa-whatsapp"></i><a href="<?php echo esc_url(cbcart_whatsapp_link); ?>" target="_blank" class="cbcart_supportlabel"><?php esc_html_e('WhatsApp','cartbox-messaging-widgets'); ?></a></div>
                    <div class="mt-3"><i class="fa  fa-envelope-o"></i><a href="mailto:hi@cartbox.net" target="_blank" class="cbcart_supportlabel"><?php esc_html_e('Email','cartbox-messaging-widgets'); ?></a><br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
