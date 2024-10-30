<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$cbcart_redirect_url     = site_url( $path = '', $scheme = null );
$cbcart_contactform7_text_customer="Thank you for submitting the form!\n\nWe have received your information and will process it shortly.\n\nIf you have any further questions or concerns, please don't hesitate to contact us.\n\nHave a great day!";
$cbcart_contactform7_text="A new contact form inquiry is received.\n\nName: {{customername}}\n\nSubject: {{subject}}\n\nEmail: {{customeremail}}\n\nMessage: {{message}}\n\nWebsite: {{websiteurl}}\n\nThanks.";
$cbcart_abandoned_1="Hi {{customername}},\n\n📢 We noticed you didnt finish your order on {{storename}}.\n\nVisit now to complete your order.\n\n{{storename}}\n\nThanks.\n\n{{checkoutlink}}";
$cbcart_abandoned_2="Hey {{customername}},\n\nYou left some items in your cart!🛒\n\nWe wanted to make sure you had the chance to get what you needed.\n\n{{checkoutlink}}";
$cbcart_abandoned_3="Hey {{customername}},\n\nWe see you left a few items in the cart at {{storename}}\n\nYour items are waiting for you! Grab your favorites before they go out of stock.\n\nYour friends from {{storename}}.\n\nThanks.\n\n{{checkoutlink}}";
$cbcart_abandoned_4="Hi {{customername}},\n\nYour cart is waiti`    qe3ng for you at {{storename}}\n\nComplete your purchase before someone else buys them!\n\nClick {{siteurl}} to finish your order now.\n\n{{storename}}\n\nThanks.\n\n{{checkoutlink}}";
$cbcart_abandoned_5="Hello {{customername}},\n\nDid you forget to complete your order on {{storename}}?\n\nClick the link to finish the order now!\n\nYour friends from {{storename}}.\n\nThanks.\n\n{{checkoutlink}}";
$cbcart_order_admin="Hi,\n\nAn order is placed on {{storename}} at {{siteurl}}\n\nThe order is for {{productname}}\n\nand the order amount is {{orderamount}}\n\nCustomer details are: {{customeremail}}\n\nThanks.";
$cbcart_order_customer="Hi {{customername}},\n\nYour {{productname}} order of {{amount}} is placed.\n\nWe will keep you updated about your order status.\n\n{siteurl}";
$cbcart_data                          = get_option('cbcart_usersettings');
$cbcart_data                          = json_decode( $cbcart_data );
$cbcart_data                          = sanitize_option(  "cbcart_usersettings",$cbcart_data);

if ($cbcart_data!="") {
    $cbcart_check_plan=$cbcart_data->cbcart_planid;
} else{
    $cbcart_check_plan="";
}
$cbcart_data             = get_option( 'cbcart_ordernotificationsettings' );
$cbcart_data             = json_decode($cbcart_data);
$cbcart_data             =  sanitize_option(  "cbcart_ordernotificationsettings",$cbcart_data);
if($cbcart_data!="") {
    if(property_exists($cbcart_data,'cbcart_admin_message')) {
        $cbcart_admin_message = $cbcart_data->cbcart_admin_message;
    }else{
        $cbcart_admin_message=$cbcart_order_admin;
    }
    if(property_exists($cbcart_data,'cbcart_customer_message')) {
        $cbcart_customer_message = $cbcart_data->cbcart_customer_message;
    }else{
        $cbcart_customer_message=$cbcart_order_customer;
    }
}
else{
    $cbcart_admin_message=$cbcart_order_admin;
    $cbcart_customer_message=$cbcart_order_customer;
}
$cbcart_data        = get_option( 'cbcart_abandonedsettings' );
$cbcart_data        = json_decode( $cbcart_data );
$cbcart_data        = sanitize_option("cbcart_abandonedsettings",$cbcart_data);

if($cbcart_data!="") {
    $cbcart_ac_message = $cbcart_data->cbcart_ac_message;
    $cbcart_ac_message2 = $cbcart_data->cbcart_ac_message2;
    $cbcart_ac_message3 = $cbcart_data->cbcart_ac_message3;
    $cbcart_ac_message4 = $cbcart_data->cbcart_ac_message4;
    $cbcart_ac_message5 = $cbcart_data->cbcart_ac_message5;
}
else{
    $cbcart_ac_message = $cbcart_abandoned_1;
    $cbcart_ac_message2 = $cbcart_abandoned_2;
    $cbcart_ac_message3 = $cbcart_abandoned_3;
    $cbcart_ac_message4 = $cbcart_abandoned_4;
    $cbcart_ac_message5 = $cbcart_abandoned_5;
}
$cbcart_data             = get_option( 'cbcart_contactformsettings' );
$cbcart_data             = json_decode( $cbcart_data );
$cbcart_data             =  sanitize_option(  "cbcart_contactformsettings",$cbcart_data);
if($cbcart_data!="") {
    $cbcart_admincf7_admin_message = $cbcart_data->cbcart_cf7admin_message;
    $cbcart_admincf7_customer_message = $cbcart_data->cbcart_cf7customer_message;

}
else{
    $cbcart_admincf7_admin_message=$cbcart_contactform7_text;
    $cbcart_admincf7_customer_message=$cbcart_contactform7_text_customer;

}

if ( isset( $_POST['cbcart_continue'] )  ) {
    $cbcart_flag="1";
	$cbcart_legit = true;
	if ( ! isset( $_POST['cbcart_message_send_nonce'] ) ) {
		$cbcart_legit = false;
	}
	$cbcart_nonce = isset( $_POST['cbcart_message_send_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['cbcart_message_send_nonce'] ) ) : '';
	if ( ! wp_verify_nonce( $cbcart_nonce, 'cbcart_message_send' ) ) {
		$cbcart_legit = false;
	}
	if ( ! $cbcart_legit ) {
		wp_safe_redirect( add_query_arg() );
		exit();
	}
    $cbcart_default_link = isset( $_POST['cbcart_redirect_url'] ) ? sanitize_text_field( wp_unslash( $_POST['cbcart_redirect_url'] ) ) : '';
    if ( empty( $cbcart_default_link ) ) {
        $cbcart_flag           = 0;
        $cbcart_error_mobileno = '';
        $cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible">';
        $cbcart_error_mobileno .= '<p>' . esc_html( 'Please Enter Production URL.','cartbox-messaging-widgets' ) . '</p>';
        $cbcart_error_mobileno .= '</div>';
        echo wp_kses_post( $cbcart_error_mobileno );
    }
    if(!filter_var($cbcart_default_link, FILTER_VALIDATE_URL)){
        $cbcart_flag           = 0;
        $cbcart_error_mobileno = '';
        $cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible">';
        $cbcart_error_mobileno .= '<p>' . esc_html( 'The given URL is incorrect','cartbox-messaging-widgets' ) . '</p>';
        $cbcart_error_mobileno .= '</div>';
        echo wp_kses_post( $cbcart_error_mobileno );
    }
    if(!(strpos($cbcart_default_link, 'https') === 0)) {
        $cbcart_flag           = 0;
        $cbcart_error_mobileno = '';
        $cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible">';
        $cbcart_error_mobileno .= '<p>' . esc_html( 'The given URL is not HTTPS. Please Enter secure URL','cartbox-messaging-widgets' ) . '</p>';
        $cbcart_error_mobileno .= '</div>';
        echo wp_kses_post( $cbcart_error_mobileno );
    }
    if((strpos($cbcart_default_link, 'localhost'))!=""){
        $cbcart_flag           = 0;
        $cbcart_error_mobileno = '';
        $cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible">';
        $cbcart_error_mobileno .= '<p>' . esc_html( 'The given URL contains Localhost. Please Enter correct URL','cartbox-messaging-widgets' ) . '</p>';
        $cbcart_error_mobileno .= '</div>';
        echo wp_kses_post( $cbcart_error_mobileno );
    }

    if ($cbcart_flag == 1) {
        $cbcart_update_option_arr = array(
            'cbcart_Isscreendone' => "true",
        );
        $cbcart_result1 = update_option('cbcart_templatescreen', wp_json_encode($cbcart_update_option_arr));
        try {
            if ($cbcart_check_plan === "2" || $cbcart_check_plan === "3" || $cbcart_check_plan === "4") {
                $cbcart_result1 = cbcart::cbcart_createtemplates($cbcart_default_link);
            }
            if ($cbcart_result1 == "false") {
                throw new Exception("Something went wrong!");
            }
        } catch (Exception $exception) {
                  printf(
                esc_html__( 'Exception message: %s', 'plugin-slug' ),
                esc_html( $exception->getMessage() )
                );
        }
        $cbcart_page = isset($_REQUEST['page']) ? sanitize_text_field(wp_unslash($_REQUEST['page'])) : '';
        wp_redirect('admin.php?page=' . $cbcart_page);
    }
}

if ( isset( $_POST['cbcart_restart_btn'] ) ) {
    $cbcart_legit   = true;
    if ( ! isset( $_POST['cbcart_restart_btn_nounce'] ) ) {
        $cbcart_legit = false;
    }
    $nonce = isset( $_POST['cbcart_restart_btn_nounce'] ) ? sanitize_text_field( wp_unslash( $_POST['cbcart_restart_btn_nounce'] ) ) : '';
    if ( ! wp_verify_nonce( $nonce, 'cbcart_restart_btn' ) ) {
        $cbcart_legit = false;
    }
    if ( ! $cbcart_legit ) {
        wp_safe_redirect( add_query_arg() );
        exit();
    }
    delete_option('cbcart_testmessagesetup');
    $cbcart_page = isset( $_REQUEST['page'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['page'] ) ) : '';
    wp_redirect( 'admin.php?page=' . $cbcart_page );
}
$cbcart_logo1     = cbcart_logonew_black;
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-2 text-center">
            <img src="<?php echo esc_url( $cbcart_logo1 ); ?>" class="cbcart_imgclass">
        </div>
    </div>
    <?php if($cbcart_check_plan==="4"){ ?>
        <div class="w-50 m-auto mt-2 mb-2">
            <div class="cbcart_header text-center d-flex flex-row flex-nowrap align-items-center justify-content-center">
                <div class="p-2">
                    <form method="post" name="cbcart_form3" action="" >
                        <?php wp_nonce_field( 'cbcart_restart_btn', 'cbcart_restart_btn_nounce' ); ?>

                        <button type="submit" class="btn" id="cbcart_back_btn" name="cbcart_restart_btn"><i class="fa fa-angle-left cbcart_arrow_left"></i></button>
                    </form>
                </div>
                <div class="cbcart_header_number cbcart_header_done"><i class="fa fa-check cbcart_icolor" ></i></div>
                <div class="cbcart_header_label cbcart_selected"><label><?php esc_html_e(  'Setup Account','cartbox-messaging-widgets' ); ?></label></div>
                <hr>
                <div class="cbcart_header_number cbcart_header_done"><i class="fa fa-check cbcart_icolor"></i></div>
                <div class="cbcart_header_label cbcart_selected"><label><?php esc_html_e(  'Send a Test Message','cartbox-messaging-widgets' ); ?></label></div>
            </div>
        </div>
    <?php }else{ ?>
    <div class="w-75 m-auto mt-2 mb-2">
        <div class="cbcart_header text-center d-flex flex-row flex-nowrap align-items-center">
            <div class="p-2">
                <form method="post" name="cbcart_form3" action="" >
                    <?php wp_nonce_field( 'cbcart_restart_btn', 'cbcart_restart_btn_nounce' ); ?>

                    <button type="submit" class="btn" id="cbcart_back_btn" name="cbcart_restart_btn"><i class="fa fa-angle-left cbcart_arrow_left"></i></button>
                </form>
            </div>
            <div class="cbcart_header_number cbcart_header_done"><i class="fa fa-check cbcart_icolor" ></i></div>
            <div class="cbcart_header_label cbcart_selected"><label><?php esc_html_e(  'Verify Email' ,'cartbox-messaging-widgets' ); ?></label></div>
            <hr>
            <div class="cbcart_header_number cbcart_header_done"><i class="fa fa-check cbcart_icolor" ></i></div>
            <div class="cbcart_header_label cbcart_selected"><label><?php esc_html_e(  'Set Mobile Number','cartbox-messaging-widgets' ); ?></label></div>
            <hr>
            <div class="cbcart_header_number cbcart_header_done"><i class="fa fa-check cbcart_icolor"></i></div>
            <div class="cbcart_header_label cbcart_selected"><label><?php esc_html_e(  'Send a Test Message','cartbox-messaging-widgets' ); ?></label></div>
        </div>
    </div>
   <?php } ?>
    <div class="text-center m-auto cbcart_scren1_body w-75" >
        <label class="cbcart_label"><?php esc_html_e('Default Templates','cartbox-messaging-widgets' ); ?></label>
        <br>
        <label class="cbcart_sub_label mt-4"><?php esc_html_e(' Please ensure the URL is correct and of your final production website. The same URL will be used in the action button of below WhatsApp messages.') ?>
        </label>
    </div>
    <form method="post" name="cbcart_form1" class="cbcart_scren1_body" action="">
        <?php wp_nonce_field( 'cbcart_message_send', 'cbcart_message_send_nonce' ); ?>
        <button type="submit" class="btn cbcart-btn-theme-static m-0" name="cbcart_continue"><?php esc_html_e('Continue','cartbox-messaging-widgets' ); ?></button>
       <div class="">
           <div class="row m-0 mt-3 p-0">
               <div class="col-3">
                   <label class="cbcart_lbl1 m-3 mt-4 "><?php esc_html_e('Your Production Website URL :') ?></label>
               </div>
               <div class="col-9"><input type="url" name="cbcart_redirect_url" value="<?php echo esc_url( $cbcart_redirect_url); ?>" class="cbcart_text_input mt-2">


               </div>
           </div>
       </div>
        <div class="text-center m-3 mt-4">
        <label class="cbcart_sub_label"><?php  esc_html_e( 'We will create below default WhatsApp templates. Template messages shall be used for abandoned cart and order notification. Click continue to create the templates. You can, later on, change the templates as well.','cartbox-messaging-widgets' ); ?></label>
        </div>
        <div class="row ">
            <div class="col-4 card-group">
                <div class="card cbcart_card_template text-start">
                    <label class="cbcart_lbl1 mt-3"><?php esc_html_e(  'Order Notification For Admin','cartbox-messaging-widgets'); ?>
                    </label>
                    <br>
                    <label class="cbcart_sub_label"><?php esc_html_e( $cbcart_admin_message,'cartbox-messaging-widgets' ) ?></label>
                </div>
            </div>
            <div class="col-4">
                <div class="card cbcart_card_template text-start">
                    <label class="cbcart_lbl1 mt-3"><?php esc_html_e( 'Order Notification For Customer','cartbox-messaging-widgets' ); ?>
                    </label>
                    <br>
                    <label class="cbcart_sub_label"><?php esc_html_e( $cbcart_customer_message,'cartbox-messaging-widgets' ) ?></label>
                </div>
            </div>

            <div class="col-4">
                <div class="card cbcart_card_template text-start">
                    <label class="cbcart_lbl1 mt-3"><?php esc_html_e(  'Abandoned-Cart Notification 1','cartbox-messaging-widgets' ); ?>
                    </label>
                    <br>
                    <label class="cbcart_sub_label"><?php esc_html_e( $cbcart_ac_message ,'cartbox-messaging-widgets') ?></label>
                </div>
            </div>
            <div class="col-4">
                <div class="card cbcart_card_template text-start">
                    <label class="cbcart_lbl1 mt-3"><?php esc_html_e(  'Abandoned-Cart Notification 2','cartbox-messaging-widgets' ); ?>
                    </label>
                    <br>
                    <label class="cbcart_sub_label"><?php esc_html_e( $cbcart_ac_message2 ,'cartbox-messaging-widgets') ?></label>
                </div>
            </div>

            <div class="col-4">
                <div class="card cbcart_card_template text-start">
                    <label class="cbcart_lbl1 mt-3"><?php esc_html_e(  'Abandoned-Cart Notification 3','cartbox-messaging-widgets' ); ?>
                    </label>
                    <br>
                    <label class="cbcart_sub_label"><?php esc_html_e( $cbcart_ac_message3 ,'cartbox-messaging-widgets') ?></label>
                </div>
            </div>
            <div class="col-4">
                <div class="card cbcart_card_template text-start">
                    <label class="cbcart_lbl1 mt-3"><?php esc_html_e(  'Abandoned-Cart Notification 4','cartbox-messaging-widgets' ); ?>
                    </label>
                    <br>
                    <label class="cbcart_sub_label"><?php esc_html_e( $cbcart_ac_message4 ,'cartbox-messaging-widgets') ?></label>
                </div>
            </div>

            <div class="col-4">
                <div class="card cbcart_card_template text-start">
                    <label class="cbcart_lbl1 mt-3"><?php esc_html_e(  'Abandoned-Cart Notification 5','cartbox-messaging-widgets'); ?>
                    </label>
                    <br>
                    <label class="cbcart_sub_label"><?php esc_html_e( $cbcart_ac_message5,'cartbox-messaging-widgets' ) ?></label>
                </div>
            </div>
            <div class="col-4">
                <div class="card cbcart_card_template text-start">
                    <label class="cbcart_lbl1 mt-3"><?php esc_html_e(  'Contact-Form 7 Notification for Admin','cartbox-messaging-widgets' ); ?>
                    </label>
                    <br>
                    <label class="cbcart_sub_label"><?php echo wp_kses_post( $cbcart_admincf7_admin_message,'cartbox-messaging-widgets')  ?></label>
                </div>
            </div>

            <div class="col-4">
                <div class="card cbcart_card_template text-start">
                    <label class="cbcart_lbl1 mt-3"><?php esc_html_e(  'Contact-Form 7 Notification for Customer','cartbox-messaging-widgets'); ?>
                    </label>
                    <br>
                    <label class="cbcart_sub_label"><?php esc_html_e( $cbcart_admincf7_customer_message ,'cartbox-messaging-widgets') ?></label>
                </div>
            </div>
        </div>
			<?php wp_nonce_field( 'cbcart_message_send', 'cbcart_message_send_nonce' ); ?>
            <div class="text-center mt-4">
                <button type="submit" class="btn cbcart_btn-theme mb-4" name="cbcart_continue"><?php esc_html_e(  'Continue','cartbox-messaging-widgets' ); ?></button>
            </div>
    </form>

</div>