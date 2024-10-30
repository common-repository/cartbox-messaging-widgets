<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$cbcart_data                          = get_option( 'cbcart_usersettings' );
$cbcart_data                          = json_decode( $cbcart_data );
$cbcart_data= sanitize_option(  "cbcart_usersettings",$cbcart_data);
if ($cbcart_data!="") {
    $cbcart_isMessageFromAdminNumber = $cbcart_data->cbcart_isMessageFromAdminNumber;
    $cbcart_official_number = $cbcart_data->cbcart_official_number;
} else{
    $cbcart_isMessageFromAdminNumber="";
    $cbcart_official_number="";
}
$cbcart_from_number                   = $cbcart_official_number;
$cbcart_data     = get_option( 'cbcart_adminsettings' );
$cbcart_data     = json_decode( $cbcart_data );
$cbcart_data= sanitize_option(  "cbcart_adminsettings",$cbcart_data);

if ($cbcart_data!="") {
    $cbcart_email = $cbcart_data->cbcart_email;
    $cbcart_username = $cbcart_data->cbcart_username;
    $cbcart_password = $cbcart_data->cbcart_password;
    $cbcart_cron_time = $cbcart_data->cbcart_cron_time;
} else {
    $cbcart_email="";
    $cbcart_username="";
    $cbcart_password="";
    $cbcart_cron_time="";
}
// Set mobile number for admin
if ( isset( $_POST['cbcart_submitbtn'] ) ) {
	$cbcart_legit = true;
	if ( ! isset( $_POST['cbcart_setup_mobile_nonce'] ) ) {
		$cbcart_legit = false;
	}
	$cbcart_nonce = isset( $_POST['cbcart_setup_mobile_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['cbcart_setup_mobile_nonce'] ) ) : '';
	if ( ! wp_verify_nonce( $cbcart_nonce, 'cbcart_setup_mobile' ) ) {
		$cbcart_legit = false;
	}
	if ( ! $cbcart_legit ) {
		wp_safe_redirect( add_query_arg() );
		exit();
	}
	$cbcart_default_country = isset( $_POST['cbcart_default_country'] ) ? sanitize_text_field( wp_unslash( $_POST['cbcart_default_country'] ) ) : '';
	$cbcart_from_number     = isset( $_POST['cbcart_from_number'] ) ? sanitize_text_field( wp_unslash( $_POST['cbcart_from_number'] ) ) : '';

	if ( $cbcart_isMessageFromAdminNumber != "true" ) {
		$cbcart_from_number = $cbcart_official_number;
	}
    if ($cbcart_default_country=="") {
	    $cbcart_default_country='91';
    }
	// if mobile number is not valid display error message
	if ( empty( $cbcart_from_number ) ) {
		$cbcart_flag            = 0;
		$cbcart_error_mobileno  = '';
		$cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible">';
		$cbcart_error_mobileno .= '<p>' . esc_html( 'Please Enter Mobile Number.','cartbox-messaging-widgets' ) . '</p>';
		$cbcart_error_mobileno .= '</div>';
		echo wp_kses_post( $cbcart_error_mobileno );
	} elseif ( strlen( $cbcart_from_number ) <= 7 ) {
		$cbcart_flag            = 0;
		$cbcart_error_mobileno  = '';
		$cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible">';
		$cbcart_error_mobileno .= '<p>' . esc_html( 'Please enter atleast 7 digit number.','cartbox-messaging-widgets' ) . '</p>';
		$cbcart_error_mobileno .= '</div>';
		echo wp_kses_post( $cbcart_error_mobileno );
	} elseif ( preg_match( '#[^0-9]#', $cbcart_from_number ) ) {
		$cbcart_flag            = 0;
		$cbcart_error_mobileno  = '';
		$cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible">';
		$cbcart_error_mobileno .= '<p>' . esc_html( 'Please enter only numbers.','cartbox-messaging-widgets' ) . '</p>';
		$cbcart_error_mobileno .= '</div>';
		echo wp_kses_post( $cbcart_error_mobileno );
	} else {
		$cbcart_from_number = $cbcart_default_country . $cbcart_from_number;
	}
	$cbcart_update_option_arr = array(
		'cbcart_username'        => $cbcart_username,
		'cbcart_password'        => $cbcart_password,
		'cbcart_email'           => $cbcart_email,
		'cbcart_from_number'     => $cbcart_from_number,
		'cbcart_default_country' => $cbcart_default_country,
        'cbcart_cron_time'=>$cbcart_cron_time,
	);
	$cbcart_result            = update_option( 'cbcart_adminsettings', wp_json_encode( $cbcart_update_option_arr ) );
	$cbcart_page = isset( $_REQUEST['page'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['page'] ) ) : '';
	wp_redirect( 'admin.php?page=' . $cbcart_page );}

if ( isset( $_POST['cbcart_restart_btn'] ) ) {
	$cbcart_legit = true;
	if ( ! isset( $_POST['cbcart_setup_mobile_nonce'] ) ) {
		$cbcart_legit = false;
	}
	$cbcart_nonce = isset( $_POST['cbcart_setup_mobile_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['cbcart_setup_mobile_nonce'] ) ) : '';
	if ( ! wp_verify_nonce( $cbcart_nonce, 'cbcart_setup_mobile' ) ) {
		$cbcart_legit = false;
	}
	if ( ! $cbcart_legit ) {
		wp_safe_redirect( add_query_arg() );
		exit();
	}

	delete_option('cbcart_adminsettings');
	delete_option('cbcart_userplan');
	delete_option('cbcart_usersettings');
	$cbcart_page = isset( $_REQUEST['page'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['page'] ) ) : '';
	wp_redirect( 'admin.php?page=' . $cbcart_page );
}

$cbcart_logo = CBCART_DIR . CBCART_DOMAIN . esc_url( '/admin/images/cbcart_Mobilecharts.png','cartbox-messaging-widgets' );
$cbcart_logo1     = cbcart_logonew_black;

?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-2">
            <img src="<?php echo esc_url( $cbcart_logo1 ); ?>" class="cbcart_imgclass">
        </div>
    </div>
    <div class="w-75 m-auto mt-4">
        <div class="cbcart_header text-center d-flex flex-row flex-nowrap align-items-center">
            <div class="p-2">
                <form method="post" name="cbcart_form3" action="" >
                    <?php wp_nonce_field( 'cbcart_setup_mobile', 'cbcart_setup_mobile_nonce' ); ?>
                    <button type="submit" class="btn" id="cbcart_back_btn" name="cbcart_restart_btn"><i class="fa fa-angle-left cbcart_arrow_left"></i></button>
                </form>
            </div>
            <div class="cbcart_header_number cbcart_header_done"><i class="fa fa-check cbcart_icolor"></i></div>
            <div class="cbcart_header_label cbcart_selected"><label><?php esc_html_e('Verify Email','cartbox-messaging-widgets') ?></label></div>
            <hr>
            <div class="cbcart_header_number cbcart_selected_number"><?php esc_html_e('2','cartbox-messaging-widgets') ?></div>
            <div class="cbcart_header_label cbcart_selected"><label><?php esc_html_e('Set Mobile Number','cartbox-messaging-widgets') ?></label></div>
            <hr>
            <div class="cbcart_header_number"><?php esc_html_e('3','cartbox-messaging-widgets') ?></div>
            <div class="cbcart_header_label"><label><?php esc_html_e('Send a Test Message','cartbox-messaging-widgets') ?></label></div>
        </div>
    </div>
    <div class="text-center m-2 cbcart_scren1_body" >
        <label class="cbcart_label"><?php esc_html_e( "Free Plan",'cartbox-messaging-widgets') ?></label>
    </div>
    <form method="post" name="cbcart_form1" action="" class="cbcart_scren1_body">
        <div class="container-fluid cbcart_max-width-600 mt-2">
            <div class="row text-center">
                <label class="cbcart-lbl"><?php esc_html_e( 'All the messsages you want to send will go from the below number','cartbox-messaging-widgets' ); ?></label>
            </div>
                <div class="row mb-2 mt-3">
                    <label class="cbcart_lbl text-black"><?php esc_html_e( 'Enter your Mobile number','cartbox-messaging-widgets' ); ?>
                    </label>
                </div>
                <div class="row mb-2">
                    <div class="col-12">
                        <div class="d-flex flex-nowrap flex-row cbcart ">
                            <div class="col-3 cbcart_select_div" >
                                <select id="cbcart_default_country" name="cbcart_default_country" class="input-line cbcart_message mt-0 cbcart_counrty_text disabled" disabled readonly><?php
                                    printf(
                                        esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                        esc_html(cbcart_country_code)
                                    );
                                     ?> </select>
                            </div>
                            <div class="col-9">
                            <input type="text" name="cbcart_from_number" disabled id="cbcart_from_number" onClick="this.setSelectionRange(0, this.value.length)" class="cbcart_message mt-0 w-100" value="<?php esc_attr_e( $cbcart_from_number); ?>">
                            <span id="cbcart_phonemsg d-none"></span>
                            </div>
                        </div>
                    </div>
                </div>
				<?php wp_nonce_field( 'cbcart_setup_mobile', 'cbcart_setup_mobile_nonce' ); ?>
                <div class="row mb-2 justify-content-center">
                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn cbcart_btn-theme" name="cbcart_submitbtn"><?php  esc_html_e( 'Continue','cartbox-messaging-widgets' ); ?></button>
                    </div>
                </div>
            <div class="d-flex flex-nowrap flex-row row cbcart_plan_box">
                <div class="col-6 cbcart_plan_div_p">
                    <a href="<?php echo esc_url( cbcart_site_pricing); ?>" target="_blank" class="text-decoration-none">
                    <div class="card cbcart_card">
                        <div class="cbcart_card-body">
                            <div class="row cbcart_plan_color_div1" >
                                <div class="col-12"><p class="cbcart_cardplan_heading"><?php esc_html_e( 'Ultimate Plan','cartbox-messaging-widgets' ); ?></p></div>
                                <div class="col-2 "><p><i class="fa fa-check-square-o"></i></p></div><div class="col-10"><p class="cbcart_lbl1"><?php esc_html_e( 'Recover Abandoned Cart Via WhatsApp','cartbox-messaging-widgets' ); ?></p></div>
                                <div class="col-2 "><p><i class="fa fa-check-square-o"></i></p></div><div class="col-10"><p class="cbcart_lbl1"> <?php esc_html_e( 'Customized Messages','cartbox-messaging-widgets' ); ?></p></div>
                                <div class="col-12 text-center cbcart_mt-40" ><button class="btn cbcart_btn_secondary" type="button"><?php esc_html_e( 'Upgrade Now','cartbox-messaging-widgets' ); ?></button></div>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-6 cbcart_plan_div_p">
                    <a href="<?php echo esc_url( cbcart_site_pricing); ?>" target="_blank" class="text-decoration-none">
                    <div class="card cbcart_card">
                        <div class="cbcart_card-body">
                            <div class="row cbcart_plan_color_div2" >
                                <div class="col-12"><p class="cbcart_cardplan_heading"><?php esc_html_e( 'Premium Plan','cartbox-messaging-widgets' ); ?></p></div>
                                <div class="col-2 cbcart_p_0"><p><i class="fa fa-check-square-o"></i></p></div><div class="col-10 cbcart_p_0" ><p class="cbcart_lbl1"><?php esc_html_e( 'Abandoned Cart Mobile Number Report','cartbox-messaging-widgets' ); ?></p></div>
                                <div class="col-2 cbcart_p_0" ><p><i class="fa fa-check-square-o"></i></p></div><div class="col-10 cbcart_p_0" ><p class="cbcart_lbl1"> <?php esc_html_e( 'Unlimited Messages','cartbox-messaging-widgets' ); ?></p></div>
                                <div class="col-2 cbcart_p_0" ><p><i class="fa fa-check-square-o"></i></p></div><div class="col-10 cbcart_p_0"><p class="cbcart_lbl1"><b><?php esc_html_e( 'Installation Support','cartbox-messaging-widgets' ); ?></b></p></div>
                                <div class="col-12 text-center"><button class="btn cbcart_btn_secondary2" type="button"><?php esc_html_e( 'Upgrade Now','cartbox-messaging-widgets' ); ?></button></div>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
            </div>
        </div>
    </form>

    <form method="post" name="cbcart_form3" action="">
        <div class="text-center mt-4">
	        <?php wp_nonce_field( 'cbcart_setup_mobile', 'cbcart_setup_mobile_nonce' ); ?>
            <button type="submit" class="cbcart_btn_blank" name="cbcart_restart_btn"><?php esc_html_e( 'Restart If you have already upgraded the plan','cartbox-messaging-widgets' ); ?>
            </button>
        </div>
    </form>
</div>
