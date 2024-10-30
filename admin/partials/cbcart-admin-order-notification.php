<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$cbcart_admin_message_template        = esc_html( "hi, an order is placed on {storename} at {orderdate}.\n\nThe order is for {productname} and order amount is {amountwithcurrency}.\n\nCustomer details are: {customernumber}\n\n{customeremail}",'cartbox-messaging-widgets' );
$cbcart_customer_message_template     = esc_html( "{customername}, your {productname} order of {amountwithcurrency} has been placed. \n\nWe will keep you updated about your order status.\n\n{storename}",'cartbox-messaging-widgets' );
$cbcart_data                          = get_option( 'cbcart_usersettings' );
$cbcart_data                          = json_decode( $cbcart_data );
$cbcart_data             =  sanitize_option(  "cbcart_usersettings",$cbcart_data);
if ($cbcart_data!="") {
    $cbcart_isOrderNotificationToAdmin = $cbcart_data->cbcart_isOrderNotificationToAdmin;
    $cbcart_isCustomizeMessageToAdmin = $cbcart_data->cbcart_isCustomizeMessageToAdmin;
    $cbcart_isOrderNotificationToCustomer = $cbcart_data->cbcart_isOrderNotificationToCustomer;
    $cbcart_isCustomizMessageToCustomer = $cbcart_data->cbcart_isCustomizMessageToCustomer;
    $cbcart_isCustomizMessageOfAbandoned = $cbcart_data->cbcart_isCustomizMessageOfAbandoned;
    $cbcart_checkplan = $cbcart_data->cbcart_planid;
} else {
    $cbcart_isOrderNotificationToAdmin ="";
    $cbcart_isCustomizeMessageToAdmin = "";
    $cbcart_isOrderNotificationToCustomer = "";
    $cbcart_isCustomizMessageToCustomer ="";
    $cbcart_isCustomizMessageOfAbandoned = "";
    $cbcart_checkplan="";
}

$cbcart_data1 = get_option('cbcart_ordernotificationsettings');
$cbcart_data1 = json_decode($cbcart_data1);
$cbcart_data1             =  sanitize_option(  "cbcart_ordernotificationsettings",$cbcart_data1);
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
if ( isset( $_POST['cbcart_notification_submit_premium'] ) ) {
	$cbcart_numbers = array();
	$cbcart_legit   = true;
	if ( ! isset( $_POST['cbcart_notification_nonce'] ) ) {
		$cbcart_legit = false;
	}
	$nonce = isset( $_POST['cbcart_notification_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['cbcart_notification_nonce'] ) ) : '';
	if ( ! wp_verify_nonce( $nonce, 'cbcart_notification' ) ) {
		$cbcart_legit = false;
	}
	if ( ! $cbcart_legit ) {
		wp_safe_redirect( add_query_arg() );
		exit();
	}
	$cbcart_admin_mobileno         = isset( $_POST['cbcart_admin_mobileno'] ) ? sanitize_text_field( wp_unslash( $_POST['cbcart_admin_mobileno'] ) ) : '';
	$cbcart_admin_mobileno         = preg_replace( '/[^0-9,]/u', '', $cbcart_admin_mobileno );
	$cbcart_order_image            = isset( $_POST['cbcart_image'] ) ? sanitize_textarea_field( wp_unslash( $_POST['cbcart_image'] ) ) : '';

	// check if customer notification is enabled or not
	if ( isset ( $_POST['cbcart_customer_checkbox'] ) ) {
		$cbcart_customer_notification = "1";
	} else {
		$cbcart_customer_notification = "0";

	}
    if ( isset ( $_POST['cbcart_admin_checkbox'] ) ) {
        $cbcart_admin_notification = "1";
    } else {
        $cbcart_admin_notification = "0";
        $cbcart_admin_mobileno="";
    }
	$cbcart_update_arr = array();
	$cbcart_flag       = 1;

    if($cbcart_admin_notification==="1") {
        // validate mobile number and return error if not validated
        if (empty($cbcart_admin_mobileno)) {
            $cbcart_flag = 0;
            $cbcart_error_mobileno = '';
            $cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible">';
            $cbcart_error_mobileno .= '<p>' . esc_html('Please Enter Mobile Number.','cartbox-messaging-widgets') . '</p>';
            $cbcart_error_mobileno .= '</div>';
            echo wp_kses_post($cbcart_error_mobileno);
        } elseif (strlen($cbcart_admin_mobileno) <= 7) {
            $cbcart_flag = 0;
            $cbcart_error_mobileno = '';
            $cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible">';
            $cbcart_error_mobileno .= '<p>' . esc_html('Please enter atleast 7 digit number.','cartbox-messaging-widgets') . '</p>';
            $cbcart_error_mobileno .= '</div>';
            echo wp_kses_post($cbcart_error_mobileno);
        } else {
            $cbcart_numbers = explode(',', $cbcart_admin_mobileno);
            $cbcart_numbers = array_filter($cbcart_numbers);
            $cbcart_numbers = array_map('trim', $cbcart_numbers);
            $cbcart_error = 0;
            $cbcart_inValidNumbers = array();
            foreach ($cbcart_numbers as $cbcart_number) {
                if (is_numeric($cbcart_number)) {
                    if (strlen($cbcart_number) < 7) {
                        $cbcart_error++;
                        array_push($cbcart_inValidNumbers, $cbcart_number);
                    }
                } else {
                    $cbcart_error++;
                    array_push($cbcart_inValidNumbers, $cbcart_number);
                    $cbcart_flag = 0;
                    $cbcart_error_message = '';
                    $cbcart_error_message .= '<div class="notice notice-error is-dismissible">';
                    $cbcart_error_message .= '<p>' . esc_html('Please enter valid number','cartbox-messaging-widgets') . ' ' . implode(", ", $cbcart_inValidNumbers) . '</p>';
                    $cbcart_error_message .= '</div>';
                    echo wp_kses_post($cbcart_error_message);
                }
            }
            if ($cbcart_error != 0) {
                $cbcart_flag = 0;
                $cbcart_error_message = '';
                $cbcart_error_message .= '<div class="notice notice-error is-dismissible">';
                $cbcart_error_message .= '<p>' . esc_html('Please enter correct number of ','cartbox-messaging-widgets') . ' ' . implode(", ", $cbcart_inValidNumbers) . '</p>';
                $cbcart_error_message .= '</div>';
                echo wp_kses_post($cbcart_error_message);
            }
            if (count(array($cbcart_numbers)) > 10) {
                $cbcart_flag = 0;
                $cbcart_error_message = '';
                $cbcart_error_message .= '<div class="notice notice-error is-dismissible">';
                $cbcart_error_message .= '<p>' . esc_html('You cannot enter more then 10 numbers','cartbox-messaging-widgets') . '</p>';
                $cbcart_error_message .= '</div>';
                echo wp_kses_post($cbcart_error_message);
            }
        }
    }
    if($cbcart_customer_notification==="1") {
        if (empty($cbcart_order_image)) {
            $cbcart_flag = 0;
            $cbcart_error_message = '';
            $cbcart_error_message .= '<div class="notice notice-error is-dismissible">';
            $cbcart_error_message .= '<p>' . esc_html('Image path is empty.','cartbox-messaging-widgets') . '</p>';
            $cbcart_error_message .= '</div>';
            echo wp_kses_post($cbcart_error_message);
        }
        if (filter_var($cbcart_order_image, FILTER_VALIDATE_URL) === false) {
            $cbcart_flag = 0;
            $cbcart_error_message = '';
            $cbcart_error_message .= '<div class="notice notice-error is-dismissible">';
            $cbcart_error_message .= '<p>' . esc_html('Image path is wrong.','cartbox-messaging-widgets') . '</p>';
            $cbcart_error_message .= '</div>';
            echo wp_kses_post($cbcart_error_message);
        }
    }
	// if cbcart_flasg is set than get mobile number
	if ( $cbcart_flag === 1 ) {
		$cbcart_admin_mobileno = implode( ' , ', $cbcart_numbers );
		if ( empty( $cbcart_admin_message ) ) {
			$cbcart_admin_message = $cbcart_admin_message_template;
		}
		if ( empty( $cbcart_customer_message ) ) {
			$cbcart_customer_message = $cbcart_customer_message_template;
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
		$cbcart_result3                  = update_option( 'cbcart_ordernotificationsettings', wp_json_encode( $cbcart_update_notifications_arr ) );
		if ( $cbcart_result3 ) {
			$cbcart_success = '';
			$cbcart_success .= '<div class="notice notice-success is-dismissible">';
			$cbcart_success .= '<p>' . esc_html( 'Details update successfully.','cartbox-messaging-widgets' ) . '</p>';
			$cbcart_success .= '</div>';
			echo wp_kses_post( $cbcart_success );
		}
	}
}
if ( isset( $_POST['cbcart_notification_submit_premium2'] ) ) {
    $cbcart_numbers = array();
    $cbcart_legit = true;
    if (!isset($_POST['cbcart_notification_nonce2'])) {
        $cbcart_legit = false;
    }
    $nonce = isset($_POST['cbcart_notification_nonce2']) ? sanitize_text_field(wp_unslash($_POST['cbcart_notification_nonce2'])) : '';
    if (!wp_verify_nonce($nonce, 'cbcart_notification2')) {
        $cbcart_legit = false;
    }
    if (!$cbcart_legit) {
        wp_safe_redirect(add_query_arg());
        exit();
    }


    if (isset ($_POST['cbacrt_o_completed'])) {
        $cbcart_is_order_completed = "1";
    } else {
        $cbcart_is_order_completed = "0";
    }
    if (isset ($_POST['cbacrt_o_processing'])) {
        $cbcart_is_order_processing = "1";
    } else {
        $cbcart_is_order_processing = "0";
    }
    if (isset ($_POST['cbacrt_o_payment_done'])) {
        $cbcart_is_order_payment_done = "1";
    } else {
        $cbcart_is_order_payment_done = "0";
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
    $cbcart_result3                  = update_option( 'cbcart_ordernotificationsettings', wp_json_encode( $cbcart_update_notifications_arr ) );
    if ( $cbcart_result3 ) {
        $cbcart_success = '';
        $cbcart_success .= '<div class="notice notice-success is-dismissible">';
        $cbcart_success .= '<p>' . esc_html( 'Details update successfully.','cartbox-messaging-widgets' ) . '</p>';
        $cbcart_success .= '</div>';
        echo wp_kses_post( $cbcart_success );
    }
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
        'cbcart_template_num' => "order_a",
        'cbcart_template_name' => $cbcart_admin_template_name,
        'cbcart_template_lang' => $cbcart_admin_template_lang,
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
        'cbcart_template_num' => "order_c",
        'cbcart_template_name' => $cbcart_customer_template_name,
        'cbcart_template_lang' => $cbcart_customer_template_lang,
    );
    $cbcart_result1 = update_option('cbcart_customisetemplate', wp_json_encode($cbcart_update_option_arr));
    cbcart_reditect();
}

$cbcart_data                  = get_option( 'cbcart_ordernotificationsettings' );
$cbcart_data                  = json_decode( $cbcart_data );
$cbcart_data             =  sanitize_option(  "cbcart_ordernotificationsettings",$cbcart_data);
if($cbcart_data!="") {
    $cbcart_admin_mobileno = $cbcart_data->cbcart_admin_mobileno;
    $cbcart_admin_message = $cbcart_data->cbcart_admin_message;
    $cbcart_customer_notification = $cbcart_data->cbcart_customer_notification;
    $cbcart_customer_message = $cbcart_data->cbcart_customer_message;
}else{
    $cbcart_admin_mobileno = "";
    $cbcart_admin_message = "";
    $cbcart_customer_notification ="";
    $cbcart_customer_message = "";
}

if ( empty( $cbcart_admin_message ) ) {
	$cbcart_admin_message = $cbcart_admin_message_template;
}
if ( empty( $cbcart_customer_message ) ) {
	$cbcart_customer_message = $cbcart_customer_message_template;
}
//for display report
global $wpdb;
$cbcart_table                 = $wpdb->prefix . "cbcart_orderdetails";
$cbcart_Response_string       = $wpdb->get_results( "SELECT * FROM $cbcart_table" );
$cbcart_reports_array         = array();
$cbcart_reports_array_premium = array();
foreach ( $cbcart_Response_string as $cbcart_key => $cbcart_value ) {
	$cbcart_single_record    = array();
	$cbcart_user_type        = $cbcart_value->cbcart_user_type;
	$cbcart_create_date_time = $cbcart_value->cbcart_create_date_time;
	$cbcart_id               = $cbcart_value->cbcart_id;
	$cbcart_date             = date_create( $cbcart_create_date_time );
	$cbcart_create_date_time = date_format( $cbcart_date, 'd-M-Y H:i' );
	$cbcart_json_data        = json_decode( $cbcart_value->cbcart_message_api_response );
	$cbcart_json_data1       = json_decode( $cbcart_value->cbcart_message_api_request );

    if($cbcart_json_data1!="" && $cbcart_json_data!="") {

        if (is_array($cbcart_json_data)) {
            $cbcart_array_length = count($cbcart_json_data);
            if ($cbcart_array_length > 0) {
                $cbcart_json_data = array_reverse($cbcart_json_data);
                $cbcart_json_data1 = array_reverse($cbcart_json_data1);
                for ($cbcart_i = 0; $cbcart_i < $cbcart_array_length; $cbcart_i++) {
                    $cbcart_single_record = array();
                    $cbcart_single_record['cbcart_create_date_time'] = $cbcart_create_date_time;
                    $cbcart_single_record['cbcart_id'] = $cbcart_id;
                    $cbcart_single_record['cbcart_user_type'] = $cbcart_user_type;
                    $cbcart_mobile_numbers = '';
                    $cbcart_mobile_numbers = $cbcart_json_data1[$cbcart_i]->to;
                    $cbcart_single_record['cbcart_mobile_numbers'] = $cbcart_mobile_numbers;
                    $cbcart_single_record['cbcart_template_send'] = json_decode( json_encode($cbcart_json_data));;
                    $cbcart_single_record['cbcart_message_sent_code'] =true;
                    $cbcart_single_record['cbcart_message_sent'] ="";
                    array_push($cbcart_reports_array_premium, $cbcart_single_record);
                }
            }
        }
         else {
             $cbcart_bind_response="";
             $cbcart_response = $cbcart_json_data->response;
             $cbcart_response_code=$cbcart_response->code;
             if($cbcart_response_code===200){
                 $cbcart_response_status="Sent";
                 $cbcart_bind_response=true;
             }else{
                 $cbcart_response_status="Not Sent";
                 $cbcart_bind_response=false;
             }
             $cbcart_single_record['cbcart_create_date_time'] = $cbcart_create_date_time;
             $cbcart_single_record['cbcart_user_type'] = $cbcart_user_type;
             $cbcart_single_record['cbcart_id'] = $cbcart_id;
             if (property_exists($cbcart_json_data1, 'to')) {
                 $cbcart_mobile_numbers = $cbcart_json_data1->to;
             } else {
                 $cbcart_mobile_numbers = "";
             }
             $cbcart_single_record['cbcart_mobile_numbers'] = $cbcart_mobile_numbers;
             if($cbcart_bind_response===true) {
                 $cbcart_para = array();

                 $cbcart_template_send_data = $cbcart_json_data1->template;
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
                 $cbcart_single_record['cbcart_template_send'] = json_decode( json_encode($cbcart_json_data));
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
$cbcart_template_status="";
$cbcart_template_status2="";
if(array_key_exists('cbcart_check_status', $_POST)) {
    $cbcart_legit   = true;
    if ( ! isset( $_POST['cbcart_check_status_nonce'] ) ) {
        $cbcart_legit = false;
    }
    $nonce = isset( $_POST['cbcart_check_status_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['cbcart_check_status_nonce'] ) ) : '';
    if ( ! wp_verify_nonce( $nonce, 'cbcart_check_status' ) ) {
        $cbcart_legit = false;
    }
    if ( ! $cbcart_legit ) {
        wp_safe_redirect( add_query_arg() );
        exit();
    }
    $cbcart_template_status=cbcart::cbcart_get_templates_status($cbcart_admin_template_name);
}
if(array_key_exists('cbcart_check_status2', $_POST)) {
    $cbcart_legit   = true;
    if ( ! isset( $_POST['cbcart_check_status_nonce2'] ) ) {
        $cbcart_legit = false;
    }
    $nonce = isset( $_POST['cbcart_check_status_nonce2'] ) ? sanitize_text_field( wp_unslash( $_POST['cbcart_check_status_nonce2'] ) ) : '';
    if ( ! wp_verify_nonce( $nonce, 'cbcart_check_status2' ) ) {
        $cbcart_legit = false;
    }
    if ( ! $cbcart_legit ) {
        wp_safe_redirect( add_query_arg() );
        exit();
    }
    $cbcart_template_status2=cbcart::cbcart_get_templates_status($cbcart_customer_template_name);
}
$cbcart_logo = cbcart_logonew_black;
?>
<div class="container">
    <div>
        <img src="<?php echo esc_url( $cbcart_logo ,'cartbox-messaging-widgets'); ?>" class="cbcart_imgclass" alt="<?php esc_attr( 'logo','cartbox-messaging-widgets' ); ?>">
    </div>
    <label class="text-capitalize cbcart-label3">
    <b><?php esc_html_e( 'Cartbox Order notification','cartbox-messaging-widgets' ); ?></b>
    </label>
    <div class="tabbable boxed parentTabs">
        <div id="cbcart_setting_tabs" class="cbcart_nav cbcart_nav_settings">
            <ul class="nav nav-tabs cbcart_nav_tabs">
                <li><a href="#cbcart_set1 " class="active cbcart_nav_text"><?php esc_html_e( 'Settings','cartbox-messaging-widgets' ); ?></a></li>
                <li><a href="#cbcart_set2" class="cbcart_nav_text"><?php esc_html_e( 'Report','cartbox-messaging-widgets' ); ?></a></li>
                <li><a href="#cbcart_set3" class="cbcart_nav_text"><?php esc_html_e( 'Advance Settings','cartbox-messaging-widgets' ); ?></a></li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane fade active in show" id="cbcart_set1">
                    <form class="cbcart_form_div_premium" method="post">
                        <div class="card cbcart_card w-75">
                            <div class="d-flex align-items-center justify-content-between">
                            <label class="cbcart_sub_label mt-3"> <?php esc_html_e( 'WhatsApp Message To Admin On Order Success ','cartbox-messaging-widgets' ); ?></label>
                                <label class="cbcart_switch">
                                    <input type="checkbox" id="cbcart_admin_checkbox" name="cbcart_admin_checkbox" value="cbcart_admin_checkbox" <?php if($cbcart_admin_notification==="1"){ ?> checked<?php } ?> />
                                    <span class="cbcart_slider cbcart_round"></span>
                                </label>
                            </div>
                            <hr class="my-1">
                            <div id="cbcart_displayAdminMsgDiv" class="d-none">
                                <div class="mb-1 mt-4">
                                    <label class="cbcart_label3 text-capitalize"><?php esc_html_e( 'WhatsApp number with country code. ','cartbox-messaging-widgets' ); ?></label><span class="cbcart_required_star">*</span>
                                    <label class="cbcart_label3 text-capitalize"><?php esc_html_e( '(You will receive notifications on this number)','cartbox-messaging-widgets' ); ?></label>
                                </div>
                                <div class="mb-4">
                                    <div>
                                        <input type="text" name="cbcart_admin_mobileno" id="cbcart_mobileno" class="form-control cbcart_message w-100" autocomplete="off" maxlength="200" value="<?php
                                        printf(
                                            esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                            esc_html($cbcart_admin_mobileno)
                                        );
                                        ?>"  placeholder="<?php esc_attr_e( 'Enter Mobile Number with country code. Do not prefix with a 0 or +','cartbox-messaging-widgets' ); ?>"  <?php if ( $cbcart_isOrderNotificationToAdmin != "true" ) { ?> readonly title=" <?php esc_attr_e( 'update to paid plan','cartbox-messaging-widgets' ); ?>" data-toggle="tooltip" <?php } ?> />
                                    </div>
                                    <div>
                                        <label class="cbcart_error d-none" id="cbcart_mobile_error"><?php esc_html_e( 'Please enter a valid number.','cartbox-messaging-widgets' ); ?></label>
                                        <label class="cbcart_error" id="cbcart_mobile_number_error"><?php esc_html_e( 'Please Enter only Number.','cartbox-messaging-widgets' ); ?></label>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-8">
                                        <label class="cbcart_label3 text-capitalize"> <?php esc_html_e(  'Template Name :','cartbox-messaging-widgets' ) ?></label>
                                        <label class="cbcart_temp_text2 m-0"><?php
                                            printf(
                                                esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                                esc_html($cbcart_admin_template_name)
                                            );
                                             ?> </label>
                                    </div>
                                    <div class="col-4">
                                        <label class="cbcart_label3 text-capitalize"> <?php esc_html_e(  'Template Language :','cartbox-messaging-widgets' ) ?></label>
                                        <label class="cbcart_temp_text2"><?php
                                            printf(
                                                esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                                esc_html($cbcart_admin_template_lang)
                                            );
                                          ?> </label>
                                    </div>
                                </div>
                                <div class="mb-1">
                                    <label class="cbcart_label3 text-capitalize"><?php esc_html_e( 'Message','cartbox-messaging-widgets' ); ?></label>
                                </div>
                                <div class="mb-2">
                                    <div class="row">
                                        <div class="col-12">
                                    <textarea class="form-control cbcart_message" name="cbcart_message" rows="5" id="cbcart_message" autocomplete="off" maxlength="1500" readonly placeholder="<?php esc_attr_e( 'Enter message that you want to be sent when the order is placed.','cartbox-messaging-widgets' ); ?>" readonly <?php if ( $cbcart_isCustomizeMessageToAdmin != "true" ) { ?>title="<?php esc_html_e( 'update to paid plan','cartbox-messaging-widgets' ) ?> " data-toggle="tooltip" <?php
                                    } ?>><?php
                                        printf(
                                            esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                            esc_html($cbcart_admin_message)
                                        );
                                       ?></textarea>
                                            <label class="cbcart_error" id="cbcart_message_error"><?php esc_html_e( 'Your message must be atleast 2 characters.','cartbox-messaging-widgets' ); ?></label>
                                            <label class="cbcart_error" id="cbcart_message_variable_error"><?php esc_html_e( 'Replace {#var#} with your cbcart_data.','cartbox-messaging-widgets' ); ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-between">
                                    <?php if($cbcart_checkplan==="2"|| $cbcart_checkplan==="3"|| $cbcart_checkplan==="4"){?>
                                    <div class="col-auto">
                                        <?php wp_nonce_field( 'cbcart_customise_btn1', 'cbcart_customise_btn1_nounce' ); ?>
                                        <button class="btn btn-success cbcart_btn_theme_secondary" name="cbcart_customise_btn1" type="submit"><?php esc_html_e( 'Change template','cartbox-messaging-widgets' ); ?></button>
                                    </div>
                                    <?php } ?>
                                    <div class="col-auto">
                                        <?php wp_nonce_field( 'cbcart_check_status', 'cbcart_check_status_nonce' ); ?>
                                        <button class="btn btn-success cbcart_btn_theme_secondary" name="cbcart_check_status"><?php esc_html_e( 'check template status','cartbox-messaging-widgets' ); ?></button>
                                        <br><br>
                                    <?php echo wp_kses_post($cbcart_template_status) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card cbcart_card w-75">
                            <div class="d-flex align-items-center justify-content-between">
                                <label class="cbcart_sub_label mt-3 " <?php if ( $cbcart_isOrderNotificationToCustomer != "true" ) { ?>title="<?php esc_attr_e( 'update to paid plan','cartbox-messaging-widgets' ); ?>" data-toggle="tooltip" <?php } ?> > <?php esc_html_e( 'WhatsApp Message To Customer On Order Success','cartbox-messaging-widgets' ); ?></label>
                                    <?php if ( $cbcart_customer_notification == '1' ) { ?>
                                        <label class="cbcart_switch">
                                            <input type="checkbox" id="cbcart_customer_checkbox" name="cbcart_customer_checkbox" value="cbcart_customer_checkbox" checked <?php if ( $cbcart_isOrderNotificationToCustomer != "true" ) { ?> disabled="disabled" <?php } ?> />
                                            <span class="cbcart_slider cbcart_round"></span>
                                        </label>
                                    <?php } else { ?>
                                        <label class="cbcart_switch">
                                            <input type="checkbox" id="cbcart_customer_checkbox" name="cbcart_customer_checkbox" value="cbcart_customer_checkbox" <?php if ( $cbcart_isOrderNotificationToCustomer != "true" ) { ?> disabled="disabled" <?php } ?> />
                                            <span class="cbcart_slider cbcart_round"></span>
                                        </label>
                                    <?php } ?>
                                </div>
                            <hr  class="my-1">
                            <div id="cbcart_displayCustomerMsgDiv" class="d-none">
                                <div class="mb-1 mt-4">
                                    <label class="cbcart_label3 text-capitalize"> <?php esc_html_e(  'Enter Image URL which you want to send with message :','cartbox-messaging-widgets' ) ?></label>
                                </div>
                                <div class="mb-4">
                                    <input type="url" name="cbcart_image" id="cbcart_image" class="cbcart_message  focus form-control w-100" value="<?php
                                    printf(
                                        esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                        esc_html($cbcart_order_image)
                                    );
                                    ?>"/>
                                </div>
                                    <div class="row mb-3">
                                        <div class="col-8">
                                            <label class="cbcart_label3 text-capitalize"> <?php esc_html_e(  'Template Name :','cartbox-messaging-widgets' ) ?></label>
                                            <label class="cbcart_temp_text2 m-0"><?php
                                                printf(
                                                    esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                                    esc_html($cbcart_customer_template_name)
                                                );
                                                ?></label>                                      </div>
                                        <div class="col-4">
                                            <label class="cbcart_label3 text-capitalize"> <?php esc_html_e(  'Template Language :','cartbox-messaging-widgets' ) ?></label>
                                            <label class="cbcart_temp_text2"><?php
                                                printf(
                                                    esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                                    esc_html($cbcart_customer_template_lang)
                                                );
                                                ?></label>
                                        </div>
                                    </div>
                                    <div class="mb-1">
                                        <label class="cbcart_lbl1 text-capitalize"><?php esc_html_e( 'Message','cartbox-messaging-widgets' ); ?></label>
                                    </div>
                                    <div class="mb-2">
                                        <div class="row">
                                            <div class="col-12">
                                        <textarea class="form-control cbcart_message" name="cbcart_customer_message" id="cbcart_customer_message" autocomplete="off" maxlength="1500" readonly rows="5" <?php if ( $cbcart_isCustomizMessageToCustomer != "true" ) { ?>readonly title="<?php esc_attr_e( 'update to paid plan','cartbox-messaging-widgets' ); ?>" data-toggle="tooltip" <?php
                                        } ?>><?php
                                            printf(
                                                esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                                esc_html($cbcart_customer_message)
                                            );
                                            ?></textarea>
                                                <label class="cbcart_error" id="cbcart_message_error1"><?php esc_html_e( 'Your message must be atleast 2 characters.','cartbox-messaging-widgets' ); ?></label>
                                                <label class="cbcart_error" id="cbcart_variable_error"><?php esc_html_e( 'Replace {#var#} with your cbcart_data.','cartbox-messaging-widgets' ); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-between">
                                        <?php if($cbcart_checkplan==="2"|| $cbcart_checkplan==="3"|| $cbcart_checkplan==="4"){?>
                                        <div class="col-auto">
                                            <?php wp_nonce_field( 'cbcart_customise_btn2', 'cbcart_customise_btn2_nounce' ); ?>
                                            <button class="btn btn-success cbcart_btn_theme_secondary text-capitalize" name="cbcart_customise_btn2" type="submit"><?php esc_html_e( 'Change template','cartbox-messaging-widgets' ); ?></button>
                                        </div>
                                        <?php } ?>
                                        <div class="col-auto">
                                            <?php wp_nonce_field( 'cbcart_check_status2', 'cbcart_check_status_nonce2' ); ?>
                                            <button class="btn btn-success cbcart_btn_theme_secondary text-capitalize" name="cbcart_check_status2"><?php esc_html_e( 'check template status','cartbox-messaging-widgets' ); ?></button>
                                            <br><br>
                                            <?php echo wp_kses_post($cbcart_template_status2) ?>
                                        </div>
                                    </div>
                                </div>
                        </div>
							<?php wp_nonce_field( 'cbcart_notification', 'cbcart_notification_nonce' ); ?>
                        <input type="submit" class="btn cbcart-btn-theme-static" name="cbcart_notification_submit_premium" value="Submit" onclick="cbcart_submitfunction()"/>
                        <div class="mb-2 text-center mt-3">
                                <input type="submit" class="btn cbcart_btn-theme2" name="cbcart_notification_submit_premium" value="Submit" onclick="cbcart_submitfunction()"/>
                            </div>
                        </form>
                    <div class="mb-2">
                        <p class="cbcart_note"><?php esc_html_e( 'Note:','cartbox-messaging-widgets' ); ?></p>
                        <ol class="cbcart_list-items">
                            <li><?php esc_html_e( 'This form helps you to setup configuration for sending a WhatsApp message to the website-owner / adminstrator and the customer for every successful order.','cartbox-messaging-widgets' ); ?></li>
                            <li><?php esc_html_e( 'In the mobile number field, you need to enter the number of the web-administrator or the founder of the store. You can add upto 10 numbers separated by a comma.','cartbox-messaging-widgets' ); ?></li>
                        </ol>
                    </div>
            </div>
            <div class="tab-pane fade" id="cbcart_set2">

                <div class="card cbcart_card mx-0 w-100 pt-0 cbcart_settings_card">

                <?php
                if ( $cbcart_Response_string == null || empty( $cbcart_reports_array_premium ) ) { ?>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="card cbcart_card">
                                <div class="row card-body cbcart_card-body">
                                    <h5 class="cbcart_dashboardmsg">
                                        <?php esc_html_e( 'Looks like you do not have any orders yet.But do not worry, as soon as someone place order, the message will automatically appear here.','cartbox-messaging-widgets' ); ?>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } else { ?>
                        <div class="mt-4 table-responsive">
                            <table id="cbcart_ordertable" class="table table-striped table-bordered w-100">
                                <thead>
                                <tr>
                                    <th><?php esc_html_e( 'S.No.','cartbox-messaging-widgets' ) ?></th>
                                    <th><?php  esc_html_e( 'Name','cartbox-messaging-widgets' ); ?></th>
                                    <th class="text-nowrap"><?php  esc_html_e( 'Contact No.','cartbox-messaging-widgets' ); ?></th>
                                    <th><?php  esc_html_e( 'Date/Time','cartbox-messaging-widgets' ); ?></th>
                                    <th class="text-nowrap"><?php  esc_html_e( 'Message Sent','cartbox-messaging-widgets' ); ?></th>
                                    <th><?php  esc_html_e( 'Response','cartbox-messaging-widgets' ); ?></th>

                                </tr>
                                </thead>
                                <tbody>
								<?php
								$cbcart_sno = 0;
								foreach ( $cbcart_reports_array_premium as $cbcart_key => $cbcart_value ) {
									$cbcart_sno ++;
									?>
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
                                                esc_html($cbcart_value['cbcart_user_type'])
                                            );
                                         ?></td>
                                        <td><?php
                                            printf(
                                                esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                                esc_html($cbcart_value['cbcart_mobile_numbers'])
                                            );
                                          ?></td>
                                        <td><?php
                                            printf(
                                                esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                                esc_html($cbcart_value['cbcart_create_date_time'])
                                            );
                                            ?></td>
                                        <td><?php
                                            printf(
                                                esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                                esc_html($cbcart_value['cbcart_message_sent'])
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
                                                esc_html($cbcart_response_text)
                                            );
                                            $cbcart_response_text=""; ?></td>
                                    </tr>
								<?php } ?>
                                <tbody>
                            </table>
                        </div>
					<?php } ?>

                </div>
            </div>
            <div class="tab-pane fade" id="cbcart_set3">
                    <form class="cbcart_form_div_premium2" method="post">
                        <div class="card cbcart_card w-75">
                            <div class="d-flex align-items-center justify-content-between">
                                <label class="cbcart_sub_label mt-3 mb-2 "> <?php esc_html_e( 'In which event, should we consider an order to be placed successfully?','cartbox-messaging-widgets' ); ?></label>
                            </div>
                            <div class="m-2 mt-4 d-flex align-items-center">
                                <div class="m-3">
                                    <input type="checkbox" name="cbacrt_o_processing" <?php if($cbcart_is_order_processing==="1"){?> checked <?php } ?> >
                                </div>
                                <div class="">
                                    <label class=""> <?php esc_html_e('Processing (woocommerce_checkout_order_processed)','cartbox-messaging-widgets') ?></label>&nbsp;&nbsp;&nbsp;
                                    <label class="cbcart_sub_label"><?php esc_html_e('- This WooCommerce hook is recommended for only Cash on Delivery orders.','cartbox-messaging-widgets') ?></label>
                                </div>
                            </div>
                            <hr>
                            <div class="m-2 d-flex align-items-center">
                                <div class="m-3">
                                    <input type="checkbox" name="cbacrt_o_payment_done" <?php if($cbcart_is_order_payment_done==="1"){?> checked <?php } ?> >
                                </div>
                                <div class="">
                                    <label> <?php esc_html_e('Payment Completed (woocommerce_payment_complete)','cartbox-messaging-widgets') ?></label>&nbsp;&nbsp;&nbsp;
                                    <label class="cbcart_sub_label"><?php esc_html_e('- This WooCommerce hook is recommended for external payment gateways and Cash on Delivery orders.','cartbox-messaging-widgets') ?></label>
                                </div>
                            </div>
                            <hr>
                            <div class="m-2 d-flex align-items-center">
                                <div class="m-3">
                                    <input type="checkbox" name="cbacrt_o_completed" <?php if($cbcart_is_order_completed==="1"){?> checked <?php } ?>>
                                </div>
                                <div class="">
                                    <label > <?php esc_html_e('Completed (woocommerce_order_status_completed)','cartbox-messaging-widgets') ?></label>&nbsp; &nbsp;&nbsp;
                                    <label class="cbcart_sub_label"><?php esc_html_e('- This WooCommerce hook is recommended for order fulfillment state.','cartbox-messaging-widgets') ?></label>
                                </div>
                            </div>
                            <hr>
                            <label><?php esc_html_e('Note: If you are not getting order completion messages, try using the any above option and place a test order on your website to check.','cartbox-messaging-widgets') ?></label>
                        </div>
                        <?php wp_nonce_field( 'cbcart_notification2', 'cbcart_notification_nonce2' ); ?>
                        <div class="mb-2 text-center mt-3">
                            <input type="submit" class="btn cbcart_btn-theme2" name="cbcart_notification_submit_premium2" value="Submit" onclick="cbcart_submitfunction()"/>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>