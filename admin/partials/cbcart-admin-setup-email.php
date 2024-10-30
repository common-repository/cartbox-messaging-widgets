<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$cbcart_data  = get_option( 'cbcart_adminsettings' );
$cbcart_data  = json_decode( $cbcart_data );
$cbcart_data= sanitize_option(  "cbcart_adminsettings",$cbcart_data);
if ($cbcart_data != "") {
    $cbcart_email = $cbcart_data->cbcart_email;
} else {
    $cbcart_email = "";
}

// Set email for admin on submit
if ( isset( $_POST['cbcart_getbutton'] ) ) {
	$cbcart_legit = true;
	if ( ! isset( $_POST['cbcart_user_email_nonce'] ) ) {
		$cbcart_legit = false;
	}
	$cbcart_nonce = isset( $_POST['cbcart_user_email_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['cbcart_user_email_nonce'] ) ) : '';
	if ( ! wp_verify_nonce( $cbcart_nonce, 'cbcart_user_email' ) ) {
		$cbcart_legit = false;
	}
	if ( ! $cbcart_legit ) {
		wp_safe_redirect( add_query_arg() );
		exit();
	}
	$cbcart_email             = isset( $_POST['cbcart_email'] ) ? sanitize_email( wp_unslash( $_POST['cbcart_email'] ) ) : '';
	$cbcart_update_option_arr = array(
		'cbcart_email' => $cbcart_email,
        'cbcart_username' => "",
        'cbcart_password' => "",
        'cbcart_from_number'     => "",
        'cbcart_default_country' => "",
        'cbcart_cron_time'       => "",
	);
	$cbcart_result            = update_option( 'cbcart_adminsettings', wp_json_encode( $cbcart_update_option_arr ) );
	try {
		$cbcart_result1 = cbcart::cbcart_get_user_credentials( "$cbcart_email" );
		if($cbcart_result1 == "false"){
			throw new Exception("Something went wrong!");
		}
	} catch(Exception $exception){
		       printf(
                esc_html__( 'Exception message: %s', 'plugin-slug' ),
                esc_html( $exception->getMessage() )
                );
	}
}

// Set credential of user on submit
if ( isset( $_POST['cbcart_submitbutton'] ) ) {
	$cbcart_legit = true;
	if ( ! isset( $_POST['cbcart_user_credentials_nonce'] ) ) {
		$cbcart_legit = false;
	}
	$cbcart_nonce = isset( $_POST['cbcart_user_credentials_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['cbcart_user_credentials_nonce'] ) ) : '';
	if ( ! wp_verify_nonce( $cbcart_nonce, 'cbcart_user_credentials' ) ) {
		$cbcart_legit = false;
	}
	if ( ! $cbcart_legit ) {
		wp_safe_redirect( add_query_arg() );
		exit();
	}

    if ( ! empty( $_POST ) ) {

        $cbcart_otp = isset( $_POST['cbcart_otp'] ) ? sanitize_text_field( wp_unslash( $_POST['cbcart_otp'] ) ) : '';
        $cbcart_flag = 1;
        if ( $cbcart_otp == "" ) {
            $cbcart_flag  = 0;
            $cbcart_error = '';
            $cbcart_error .= '<div class="notice notice-error is-dismissible">';
            $cbcart_error .= '<p>' . esc_html( 'Please Enter OTP.','cartbox-messaging-widgets' ) . '</p>';
            $cbcart_error .= '</div>';
            echo wp_kses_post( $cbcart_error );
        }
        if ( $cbcart_flag == 1 ) {
            $cbcart_create_account= cbcart::cbcart_check_free_account($cbcart_email);
            $cbcart_otp_response = cbcart::cbcart_get_user_plan( $cbcart_otp );
            if ( $cbcart_otp_response == "true" ) {

	            $cbcart_update_option_arr = array(
		            'cbcart_otp' => $cbcart_otp,
	            );
	            $cbcart_result            = update_option( 'cbcart_otp', wp_json_encode( $cbcart_update_option_arr ) );
	            try {
		            $cbcart_result1 = cbcart::cbcart_update_user_settings_plugin();
		            if ($cbcart_result1 == "false") {
			            throw new Exception("Something went wrong!");
		            }
	            } catch(Exception $exception){
		                  printf(
                esc_html__( 'Exception message: %s', 'plugin-slug' ),
                esc_html( $exception->getMessage() )
                );
	            }
                $cbcart_page = isset( $_REQUEST['page'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['page'] ) ) : '';
                wp_redirect( 'admin.php?page=' . $cbcart_page );
            } else {
	            $cbcart_error = '';
	            $cbcart_error .= '<div class="notice notice-error is-dismissible">';
	            $cbcart_error .= '<p>' . esc_html( 'Please Enter Valid OTP.','cartbox-messaging-widgets' ) . '</p>';
	            $cbcart_error .= '</div>';
	            echo wp_kses_post( $cbcart_error );
            }
        }
    }
}
if (isset( $_POST['cbcart_restart_btn'] )  ) {
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

    delete_option('cbcart_startup');
    $cbcart_page = isset( $_REQUEST['page'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['page'] ) ) : '';
    wp_redirect( 'admin.php?page=' . $cbcart_page );
}
$cbcart_data     = get_option( 'cbcart_adminsettings' );
$cbcart_data     = json_decode( $cbcart_data );
$cbcart_data= sanitize_option(  "cbcart_adminsettings",$cbcart_data);

if($cbcart_data != ""){
    $cbcart_email    = $cbcart_data->cbcart_email;
} else {
    $cbcart_email = "";
}
$cbcart_logo     = cbcart_logonew_black;
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-2">
            <img src="<?php echo esc_url( $cbcart_logo ); ?>" class="cbcart_imgclass">
        </div>
    </div>
    <div class="w-75 m-auto mt-4">
        <div class="cbcart_header text-center d-flex flex-row flex-nowrap align-items-center">
            <div class="p-2"><form method="post" name="cbcart_form3" action="" >
                    <?php wp_nonce_field( 'cbcart_setup_mobile', 'cbcart_setup_mobile_nonce' ); ?>
                    <button type="submit" class="btn" id="cbcart_back_btn2" name="cbcart_restart_btn"><i class="fa fa-angle-left cbcart_arrow_left"></i></button>
                </form></div>
            <div class="cbcart_header_number cbcart_selected_number"><?php esc_html_e(  '1','cartbox-messaging-widgets' ); ?></div>
            <div class="cbcart_header_label cbcart_selected"><label><?php esc_html_e(  'Verify Email','cartbox-messaging-widgets' ); ?></label></div>
            <hr>
            <div class="cbcart_header_number"><?php esc_html_e(  '2','cartbox-messaging-widgets' ); ?></div>
            <div class="cbcart_header_label"><label><?php esc_html_e(  'Set Mobile Number','cartbox-messaging-widgets' ); ?></label></div>
            <hr>
            <div class="cbcart_header_number"><?php esc_html_e(  '3','cartbox-messaging-widgets' ); ?></div>
            <div class="cbcart_header_label"><label><?php esc_html_e('Send a Test Message','cartbox-messaging-widgets' ); ?></label></div>
        </div>
    </div>
    <div class="row text-center cbcart_scren1_body">
        <div id="cbcart_emailform" class="d-none">
            <form method="post" name="cbcart_emailform"  action="" >
                <label class="cbcart_label mt-4"> <?php esc_html_e( 'Let’s get started with something amazing in 2 minutes!','cartbox-messaging-widgets' ); ?></label>
                <div class="row mb-3">
                    <div class="col-12">
                        <label class="cbcart-lbl mt-3" id="cbcart_emaillabel"><?php esc_html_e( 'Enter Your Email','cartbox-messaging-widgets' ); ?></label>
                    </div>
                    <div class="d-flex flex-nowrap flex-row w-50 m-auto align-items-center">
                        <input type="email" name="cbcart_email" id="cbcart_email" placeholder="<?php esc_attr_e( 'Enter E-mail','cartbox-messaging-widgets' ); ?>" autocomplete="off" maxlength="64" class="cbcart_text_input w-100" value="<?php
                        printf(
                            esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                            esc_html($cbcart_email)
                        );
                      ?>" required>
                        <i class="fa fa-info-circle" title="<?php esc_html_e( 'We need your email address to verify your order details.','cartbox-messaging-widgets' ); ?>" data-toggle="tooltip"></i>
                    </div>
                    <label id="cbcart_error_email" class="cbcart_error" ><?php esc_html_e( 'Please enter Valid E-mail ID.','cartbox-messaging-widgets' ); ?></label>
                </div>
                <?php wp_nonce_field( 'cbcart_user_email', 'cbcart_user_email_nonce' ); ?>
                <div class="row mb-3">
                    <div class="col-md-12 text-center cbcart_submit_div " >
                        <button type="submit" class="btn cbcart_btn-theme_border"  id="cbcart_getbutton" name="cbcart_getbutton"><?php


                             esc_html_e( 'Next','cartbox-messaging-widgets' ); ?></button>
                    </div>
                </div>
                <div class="">
                    <label class="cbcart-sublbl"><?php esc_html_e( 'We will send you One Time Password (OTP)','cartbox-messaging-widgets' ); ?></label>
                </div>
            </form>
        </div>
        <div>

        </div>

        <div id="cbcart_usernameform" class="d-none">
            <form method="post" id="cbcart_usernameform" name="cbcart_form1" action="" class="mb-3">
                <label class="cbcart_label"><?php esc_html_e(  'Let’s get started for something amazing!','cartbox-messaging-widgets' );?></label>
                <div class="row mb-3">
                    <div class="col-12">
                        <label class="cbcart-lbl"><?php esc_html_e( 'Enter OTP','cartbox-messaging-widgets' ); ?></label>
                    </div>
                    <div class="col-12">
                        <label class="cbcart-sublbl mt-3" id="cbcart_emaillabel"><?php esc_html_e(  'One Time Password (OTP) is sent on  ','cartbox-messaging-widgets' );
                            printf(
                                esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                esc_html($cbcart_email)
                            );
                         ?></label>
                    </div>
                    <div class="d-flex flex-nowrap flex-row w-25 m-auto align-items-center">
                        <input type="number" id="cbcart_otp1" class=" cbcart_otp_box" maxlength="1" oninput="this.value=this.value.replace(/[^0-9]/g,'');" required>
                        <input type="number" id="cbcart_otp2" class=" cbcart_otp_box" maxlength="1" oninput="this.value=this.value.replace(/[^0-9]/g,'');" required>
                        <input type="number"  id="cbcart_otp3" class=" cbcart_otp_box" maxlength="1"  oninput="this.value=this.value.replace(/[^0-9]/g,'');" required>
                        <input type="text" id="cbcart_otp4" class=" cbcart_otp_box" maxlength="1" oninput="this.value=this.value.replace(/[^0-9]/g,'');"  required>
                    </div>
                    <label id="cbcart_error_email" class="cbcart_error" ><?php esc_html_e( 'Please enter Valid E-mail ID.','cartbox-messaging-widgets' ); ?></label>
                </div>
                <input type="hidden" id="cbcart_otp" name="cbcart_otp">
                <?php wp_nonce_field( 'cbcart_user_credentials', 'cbcart_user_credentials_nonce' ); ?>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn cbcart_btn-theme" name="cbcart_submitbutton" id="cbcart_submitbutton" onclick="cbcart_otpvalidation()"><?php  esc_html_e( 'Verify','cartbox-messaging-widgets' ); ?>
                        </button>
                    </div>
                </div>
            </form>
            <form method="post" id="cbcart_usernameform" name="cbcart_form3" action="" class=" mt-3">
                <div class="row">
                    <div class="d-flex justify-content-center mt-3">
                        <p id="clock"></p>
                        <button type="button" id="cbcart_resend_btn" class="cbcart_resend_btn" onclick="cbcart_backbtn()"><?php esc_html_e(  'Resend OTP','cartbox-messaging-widgets' ); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
