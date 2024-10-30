<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
//call function cbcart_set_message_option
cbcart::cbcart_set_message_option();
function cbcart_reditect(){
    $cbcart_page = isset( $_REQUEST['page'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['page'] ) ) : '';
    wp_redirect( 'admin.php?page=' . $cbcart_page );
}
$cbcart_cf7customer_notification="";
$cbcart_cf7customer_template_varcount="";
$cbcart_cf7customer_message="";
$cbcart_cf7customer_template_language="";
$cbcart_cf7customer_template_name="";
$cbcart_cf7enable_notification="";
//Contact Form 7
if ( class_exists( 'WPCF7' ) ) {
    $cbacrt_iscf7="true";
}else{
    $cbacrt_iscf7="false";
}
$cbcart_cf7admin_message_template  = esc_html( "A new contact form inquiry is received from \r\n\r\nName: {{customername}}.\r\n\r\nThe details of message are: {{customerdetails}}\r\n\r\n{{StoreName}}.",'cartbox-messaging-widgets' );
$cbcart_contactform7_text_customer=esc_html( "Thank you for submitting the form!\n\nWe have received your information and will process it shortly.\n\nIf you have any further questions or concerns, please don't hesitate to contact us.\n\nHave a great day!",'cartbox-messaging-widgets' );

$cbcart_data                       = get_option( 'cbcart_contactformsettings' );
$cbcart_data                       = json_decode( $cbcart_data );
$cbcart_data                       = sanitize_option(  "cbcart_contactformsettings",$cbcart_data);
if(property_exists($cbcart_data,'cbcart_cf7admin_mobileno')) {
    $cbcart_cf7admin_mobileno = $cbcart_data->cbcart_cf7admin_mobileno;
}
if(property_exists($cbcart_data,'cbcart_cf7admin_template_name')) {
    $cbcart_cf7admin_template_name = $cbcart_data->cbcart_cf7admin_template_name;
}
if(property_exists($cbcart_data,'cbcart_cf7admin_template_language')) {
    $cbcart_cf7admin_template_language = $cbcart_data->cbcart_cf7admin_template_language;
}
if(property_exists($cbcart_data,'cbcart_cf7admin_message')) {
    $cbcart_cf7admin_message = $cbcart_data->cbcart_cf7admin_message;
}
if(property_exists($cbcart_data,'cbcart_cf7admin_template_varcount')) {
    $cbcart_cf7admin_template_varcount = $cbcart_data->cbcart_cf7admin_template_varcount;
}
if(property_exists($cbcart_data,'cbcart_cf7enable_notification')) {
    $cbcart_cf7enable_notification = $cbcart_data->cbcart_cf7enable_notification;
}
if(property_exists($cbcart_data,'cbcart_cf7customer_template_name')) {
    $cbcart_cf7customer_template_name = $cbcart_data->cbcart_cf7customer_template_name;
}
if(property_exists($cbcart_data,'cbcart_cf7customer_template_language')) {
    $cbcart_cf7customer_template_language = $cbcart_data->cbcart_cf7customer_template_language;
}
if(property_exists($cbcart_data,'cbcart_cf7customer_message')) {
    $cbcart_cf7customer_message = $cbcart_data->cbcart_cf7customer_message;
}
if(property_exists($cbcart_data,'cbcart_cf7customer_template_varcount')) {
    $cbcart_cf7customer_template_varcount = $cbcart_data->cbcart_cf7customer_template_varcount;
}
if(property_exists($cbcart_data,'cbcart_cf7customer_notification')) {
    $cbcart_cf7customer_notification = $cbcart_data->cbcart_cf7customer_notification;
}

//  Set contact details for admin when submit form
if ( isset( $_POST['cbcart_contact_submit_premium'] )  ) {

	if ( ! isset( $_POST['cbcart_save_admin_details'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['cbcart_save_admin_details'] ) ), 'cbcart_save_details' ) ) {
		return;
	}
	$cbcart_cf7admin_mobileno = isset( $_POST['cbcart_cf7admin_mobileno'] ) ? sanitize_text_field( wp_unslash( $_POST['cbcart_cf7admin_mobileno'] ) ) : '';
	$cbcart_cf7admin_mobileno = preg_replace( '/[^0-9,]/u', '', $cbcart_cf7admin_mobileno );

	// Set 1 if customer checkbox is checked and 0 if not checked
	if ( isset( $_POST['cbcart_customer_checkbox'] ) ) {
		$cbcart_cf7enable_notification = "1";
	} else {
		$cbcart_cf7enable_notification = "0";
	}
    if ( isset( $_POST['cbcart_customer_checkbox2'] ) ) {
        $cbcart_cf7customer_notification = "1";
    } else {
        $cbcart_cf7customer_notification = "0";
    }
	$cbcart_update_notifications_arr = array();
	$cbcart_flag                     = 1;

    if($cbcart_cf7enable_notification==="1") {
        // show error message if mobile number is not validate
        if (empty($cbcart_cf7admin_mobileno)) {
            $cbcart_flag = 0;
            $cbcart_error_mobileno = '';
            $cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible">';
            $cbcart_error_mobileno .= '<p>' . esc_html('Please Enter Mobile Number.','cartbox-messaging-widgets') . '</p>';
            $cbcart_error_mobileno .= '</div>';
            echo wp_kses_post($cbcart_error_mobileno);
        } elseif (strlen($cbcart_cf7admin_mobileno) <= 7) {
            $cbcart_flag = 0;
            $cbcart_error_mobileno = '';
            $cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible">';
            $cbcart_error_mobileno .= '<p>' . esc_html('Please enter at least 7 digit number.','cartbox-messaging-widgets') . '</p>';
            $cbcart_error_mobileno .= '</div>';
            echo wp_kses_post($cbcart_error_mobileno);
        }

    }
	// cbcart_flag  is set get mobile numbers
	if ( $cbcart_flag === 1 ) {
        // if message is empty
		if ( empty( $cbcart_cf7admin_message ) ) {
			$cbcart_cf7admin_message = $cbcart_cf7admin_message_template;
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
		$cbcart_result1                  = update_option( 'cbcart_contactformsettings', wp_json_encode( $cbcart_update_notifications_arr ) );
		if ( isset($cbcart_result) ) {
			$cbcart_success = '';
			$cbcart_success .= '<div class="notice notice-success is-dismissible">';
			$cbcart_success .= '<p>' . esc_html( 'Details updated successfully.','cartbox-messaging-widgets' ) . '</p>';
			$cbcart_success .= '</div>';
			echo wp_kses_post( $cbcart_success );
		} else {
            $cbcart_success = '';
            $cbcart_success .= '<div class="notice notice-success is-dismissible">';
            $cbcart_success .= '<p>' . esc_html( 'Details updated successfully.','cartbox-messaging-widgets') . '</p>';
            $cbcart_success .= '</div>';
            echo wp_kses_post( $cbcart_success );
        }
	}
}
$cbcart_template_status="";
$cbcart_template_status2="";
$cbcart_template_status=cbcart::cbcart_get_templates_status($cbcart_cf7admin_template_name);
$cbcart_template_status2=cbcart::cbcart_get_templates_status($cbcart_cf7customer_template_name);
// if admin message is emptier than get it from template variable
if ( empty( $cbcart_cf7admin_message ) ) {
	$cbcart_cf7admin_message = $cbcart_cf7admin_message_template;
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
        'cbcart_template_num' => "cf7_admin",
        'cbcart_template_name' => $cbcart_cf7admin_template_name,
        'cbcart_template_lang' => $cbcart_cf7admin_template_language,
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
        'cbcart_template_num' => "cf7_customer",
        'cbcart_template_name' => $cbcart_cf7customer_template_name,
        'cbcart_template_lang' => $cbcart_cf7customer_template_language,
    );
    $cbcart_result1 = update_option('cbcart_customisetemplate', wp_json_encode($cbcart_update_option_arr));
    cbcart_reditect();
}
$cbcart_logo = cbcart_logonew_black;
?>
<div class="container">
    <div>
        <img src="<?php echo esc_url( $cbcart_logo ); ?>" class="cbcart_imgclass">
    </div>
    <label class="cbcart-label3 text-capitalize m-0"><b><?php esc_html_e( 'cartbox Message Notification via Contact Form 7','cartbox-messaging-widgets' ); ?></b>
    </label>

    <?php
    if($cbacrt_iscf7==="false"){?>
            <div class="py-3 text-danger"><h5><label class=" fa fa-warning"></label>
                    <?php esc_html_e(" Contact Form 7 is required for this plugin.",'cartbox-messaging-widgets') ?>
                    <a href="<?php echo esc_url( get_site_url() ); ?>/wp-admin/plugin-install.php?s=contact%2520form%25207&tab=search&type=term"><?php esc_html_e( 'Install Plugin Now','cartbox-messaging-widgets' ); ?></a>
                </h5>
            </div>
        <?php
    }
    ?>
    <div class="">
        <form class="form_div_premium" method="post">
            <div class="card cbcart_card w-75">
                <div class="d-flex align-items-center justify-content-between">
                    <label class="cbcart_sub_label mt-3"> <?php esc_html_e( 'WhatsApp message to admin on new Contact Form 7 submission','cartbox-messaging-widgets' ); ?></label>
                    <?php if ( $cbcart_cf7enable_notification == '1' ) { ?>
                        <label class="cbcart_switch">
                            <input type="checkbox" checked id="cbcart_cf7_checkbox" name="cbcart_customer_checkbox" value="customer_checkbox" />
                            <span class="cbcart_slider cbcart_round"></span>
                        </label>
                    <?php } else { ?>
                        <label class="cbcart_switch">
                            <input type="checkbox" id="cbcart_cf7_checkbox" name="cbcart_customer_checkbox" value="customer_checkbox"/>
                            <span class="cbcart_slider cbcart_round"></span>
                        </label>
                    <?php } ?>
                </div>
                <hr  class="my-1">
                <div id="cbcart_displayCf7Div" class="d-none">
                    <div class="mb-3">
                        <label class="cbcart_lbl1 mt-4 text-capitalize"><?php esc_html_e( 'WhatsApp number with country code.  ','cartbox-messaging-widgets' ); ?>
                            <span class="cbcart_required_star">*</span><?php  esc_html_e( '(You will receive notifications on this number.)','cartbox-messaging-widgets' ); ?>
                        </label>
                        <input type="text" name="cbcart_cf7admin_mobileno" id="cbcart_cf7admin_mobileno" autocomplete="off" maxlength="200" placeholder="<?php  esc_attr_e( 'Enter Mobile Number with country code. Do not prefix with a 0 or +','cartbox-messaging-widgets' ); ?>" class="cbcart_message form-control " value="<?php
                        printf(
                            esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                            esc_html($cbcart_cf7admin_mobileno)
                        );
                        ?>"/>
                        <label class="cbcart_error" id="cbcart_mobile_number_error"><?php esc_html_e( 'Please Enter only Number.','cartbox-messaging-widgets' ); ?></label>
                    </div>
                    <div class="row mb-3">
                        <div class="col-8">
                            <label class="cbcart_label3 text-capitalize"> <?php esc_html_e(  'Template Name :','cartbox-messaging-widgets' ) ?></label>
                            <label class="cbcart_temp_text2 m-0"><?php
                                printf(
                                    esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                    esc_html($cbcart_cf7admin_template_name)
                                );
                                ?></label>                                      </div>
                        <div class="col-4">
                            <label class="cbcart_label3 text-capitalize"> <?php esc_html_e(  'Template Language :','cartbox-messaging-widgets' ) ?></label>
                            <label class="cbcart_temp_text2"><?php
                                printf(
                                    esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                    esc_html($cbcart_cf7admin_template_language)
                                );
                               ?></label>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="cbcart_lbl1"><?php esc_html_e( 'Message','cartbox-messaging-widgets','cartbox-messaging-widgets' ); ?></label><span class="cbcart_required_star">*</span>
                        <div class="row">
                            <div class="col-12">
                                <textarea class="form-control cbcart_message" name="cbcart_cf7admin_message" id="cbcart_cf7admin_message" autocomplete="off" placeholder="<?php  esc_attr_e( 'Enter message that you want to be sent when the order is placed.','cartbox-messaging-widgets' ); ?>" readonly rows="5"><?php
                                    printf(
                                        esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                        esc_html($cbcart_cf7admin_message)
                                    );
                                   ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3 justify-content-between">
                        <div class="col-auto">
                            <?php wp_nonce_field( 'cbcart_customise_btn1', 'cbcart_customise_btn1_nounce' ); ?>
                            <button class="btn btn-success cbcart_btn_theme_secondary" name="cbcart_customise_btn1" type="submit"><?php esc_html_e( 'Change Template','cartbox-messaging-widgets' ); ?></button>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-success cbcart_btn_theme_secondary" name="cbcart_check_status" type="button" onclick="cbcart_show_status_cf7_1()"><?php esc_html_e( 'check template status','cartbox-messaging-widgets' ); ?></button>
                            <div id="cbcart_status1_cf7_1"><?php echo wp_kses_post($cbcart_template_status)?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card cbcart_card w-75">
                <div class="d-flex align-items-center justify-content-between">
                    <label class="cbcart_sub_label mt-3"> <?php esc_html_e( 'WhatsApp message to customer on new Contact Form 7 submission','cartbox-messaging-widgets' ); ?></label>
                    <?php if ( $cbcart_cf7customer_notification== '1' ) { ?>
                        <label class="cbcart_switch">
                            <input type="checkbox" checked id="cbcart_cf7customer_checkbox" name="cbcart_customer_checkbox2" value="customer_checkbox" />
                            <span class="cbcart_slider cbcart_round"></span>
                        </label>
                    <?php } else { ?>
                        <label class="cbcart_switch">
                            <input type="checkbox" id="cbcart_cf7customer_checkbox" name="cbcart_customer_checkbox2" value="customer_checkbox"/>
                            <span class="cbcart_slider cbcart_round"></span>
                        </label>
                    <?php } ?>
                </div>
                <hr  class="my-1">
                <div id="cbcart_displayCf7Div2" class="d-none">
                    <div class="row mb-3">
                        <div class="col-8">
                            <label class="cbcart_label3 text-capitalize"> <?php esc_html_e(  'Template Name :','cartbox-messaging-widgets' ) ?></label>
                            <label class="cbcart_temp_text2 m-0"><?php
                                printf(
                                    esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                    esc_html($cbcart_cf7customer_template_name)
                                );
                                ?></label>                              </div>
                        <div class="col-4">
                            <label class="cbcart_label3 text-capitalize"> <?php esc_html_e(  'Template Language :','cartbox-messaging-widgets' ) ?></label>
                            <label class="cbcart_temp_text2"><?php
                                printf(
                                    esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                    esc_html($cbcart_cf7customer_template_language)
                                );
                               ?></label>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="cbcart_lbl1"><?php esc_html_e( 'Message','cartbox-messaging-widgets' ); ?></label><span class="cbcart_required_star">*</span>
                        <div class="row">
                            <div class="col-12">
                                <textarea class="form-control cbcart_message" name="cbcart_cf7admin_message" id="cbcart_cf7admin_message" autocomplete="off" placeholder="<?php  esc_attr_e( 'Enter message that you want to be sent when the order is placed.','cartbox-messaging-widgets' ); ?>" readonly rows="5"><?php
                                    printf(
                                        esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                        esc_html($cbcart_cf7customer_message)
                                    );
                                     ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3 justify-content-between">
                        <div class="col-auto">
                            <?php wp_nonce_field( 'cbcart_customise_btn2', 'cbcart_customise_btn2_nounce' ); ?>
                            <button class="btn btn-success cbcart_btn_theme_secondary" name="cbcart_customise_btn2" type="submit"><?php esc_html_e( 'Change Template','cartbox-messaging-widgets' ); ?></button>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-success cbcart_btn_theme_secondary" name="cbcart_check_status" type="button" onclick="cbcart_show_status_cf7_2()"><?php esc_html_e( 'check template status','cartbox-messaging-widgets' ); ?></button>
                            <div id="cbcart_status1_cf7_2"><?php
                                printf(
                                    esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                    esc_html($cbcart_template_status2)
                                );
                               ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="submit" class="btn cbcart-btn-theme-static" name="cbcart_contact_submit_premium" value="Submit"/>
            <div class="mb-3 text-center">
                <?php wp_nonce_field( 'cbcart_save_details', 'cbcart_save_admin_details' ); ?>
                <input type="submit" class="btn cbcart_btn-theme2" name="cbcart_contact_submit_premium" value="Submit"/>
                </div>
                <div class="mb-2">
                    <h6><?php esc_html_e( 'Note : This plugin will not send any WhatsApp if the contact-form 7 submission has any URL link in it to avoid spamming','cartbox-messaging-widgets' ); ?></h6>
                </div>
            </form>
    </div>
</div>