<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$cbcart_data                          = get_option( 'cbcart_usersettings' );
$cbcart_data                          = json_decode( $cbcart_data );
$cbcart_data= sanitize_option(  "cbcart_usersettings",$cbcart_data);
$cbcart_abandond     = cbcart_cart_awaits;
$cbcart_order = cbcart_order_notify;
$cbcart_contact =cbcart_contact_form;
if ($cbcart_data!="") {
    $cbcart_checkplan = $cbcart_data->cbcart_planid;
}
else{
    $cbcart_checkplan="";
}
if (isset($_POST['cbcart_dashboard'])) {
	$cbcart_legit = true;
	if ( ! isset( $_POST['cbcart_setup_success_nonce'] ) ) {
		$cbcart_legit = false;
	}
	$cbcart_nonce = isset( $_POST['cbcart_setup_success_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['cbcart_setup_success_nonce'] ) ) : '';
	if ( ! wp_verify_nonce( $cbcart_nonce, 'cbcart_setup_success' ) ) {
		$cbcart_legit = false;
	}
	if ( ! $cbcart_legit ) {
		wp_safe_redirect( add_query_arg() );
		exit();
	}
	$cbcart_update_option_arr = array(
		'cbcart_isvisited' => "true",
	);

	$cbcart_result1           = update_option( 'cbcart_success', wp_json_encode( $cbcart_update_option_arr ) );
    if ($cbcart_checkplan!="2" && $cbcart_checkplan!="3" && $cbcart_checkplan!="4") {
        $cbcart_update_notifications_arr = array(
            'cbcart_trigger_time' => "30",
            'cbcart_time1' => "cbcart_select_minute",
            'cbcart_ac_enable' => "checked",
            'cbcart_ac_message' => "Hi {{customername}},\n\n📢 We noticed you didn't finish your order on {{storename}}.\n\nVisit now to complete your order.\n\n{{storename}}\n\nThanks.\n\n{{checkoutlink}}",
            'cbcart_ac_template_name' => "cbcart_wp_abandoned_cart_new_1",
            'cbcart_ac_template_lang' => "en_US",
            'cbcart_ac_template_varcount' => "3",
            'cbcart_ac_message2' => "Hey {{customername}},\n\nYou left some items in your cart!🛒\n\nWe wanted to make sure you had the chance to get what you needed.\n\n{{checkoutlink}}",
            'cbcart_ac_template2_name' => "cbcart_wp_abandoned_cart_new_2",
            'cbcart_ac_template2_lang' => "en_US",
            'cbcart_ac_template2_varcount' => "1",
            'cbcart_ac_message3' => "Hey {{customername}},\n\nWe see you left a few items in the cart at {{storename}}\n\nYour items are waiting for you! Grab your favorites before they go out of stock.\n\nYour friends from {{storename}}.\n\nThanks.\n\n{{checkoutlink}}",
            'cbcart_ac_template3_name' => "cbcart_wp_abandoned_cart_new_3",
            'cbcart_ac_template3_lang' => "en_US",
            'cbcart_ac_template3_varcount' => "3",
            'cbcart_ac_message4' => "Hi {{customername}},\n\nYour cart is waiting for you at {{storename}}\n\nComplete your purchase before someone else buys them!\n\nClick {{siteurl}} to finish your order now.\n\n{{storename}}\n\nThanks.\n\n{{checkoutlink}}",
            'cbcart_ac_template4_name' => "cbcart_wp_abandoned_cart_new_4",
            'cbcart_ac_template4_lang' => "en_US",
            'cbcart_ac_template4_varcount' => "4",
            'cbcart_ac_message5' => "Hello {{customername}},\n\nDid you forget to complete your order on {{storename}}?\n\nClick the link to finish the order now!\n\nYour friends from {{storename}}.\n\nThanks.\n\n{{checkoutlink}}",
            'cbcart_ac_template5_name' => "cbcart_wp_abandoned_cart_new_5",
            'cbcart_ac_template5_lang' => "en_US",
            'cbcart_ac_template5_varcount' => "3",
            'cbcart_abandoned_image' => $cbcart_abandond,
            'cbcart_trigger_time2' => "",
            'cbcart_time2' => "",
            'cbcart_trigger_time3' => "",
            'cbcart_time3' => "",
            'cbcart_trigger_time4' => "",
            'cbcart_time4' => "",
            'cbcart_trigger_time5' => "",
            'cbcart_time5' => "",
            'cbcart_message1_enable' => "",
            'cbcart_message2_enable' => "",
            'cbcart_message3_enable' => "",
            'cbcart_message4_enable' => "",
            'cbcart_message5_enable' => "",

        );
        $cbcart_result2 = update_option('cbcart_abandonedsettings', wp_json_encode($cbcart_update_notifications_arr));
        $cbcart_update_notifications_arr = array(
            'cbcart_cf7admin_mobileno'      => "",
            'cbcart_cf7admin_message'       => "A new contact form inquiry is received.\r\n\r\nName: {{customername}}\r\n\r\nSubject: {{subject}}\r\n\r\nEmail: {{customeremail}}\r\n\r\nMessage: {{message}}\r\n\r\nWebsite: {{websiteurl}}\r\n\r\nThanks.",
            'cbcart_cf7enable_notification' => "1",
            'cbcart_cf7admin_template_name' =>"cbcart_wp_cf7_new_1",
            'cbcart_cf7admin_template_language'=>"en_US",
            'cbcart_cf7admin_template_varcount'=>"5",
            'cbcart_cf7customer_mobileno'   =>  "",
            'cbcart_cf7customer_template_name'   =>  "cbcart_wp_cf7_customer",
            'cbcart_cf7customer_template_language'   =>"en_US",
            'cbcart_cf7customer_template_varcount'   =>"0",
            'cbcart_cf7customer_message'    =>  "Thank you for submitting the form!\n\nWe have received your information and will process it shortly.\n\nIf you have any further questions or concerns, please don't hesitate to contact us.\n\nHave a great day!" ,
            'cbcart_cf7customer_notification' => "0",
        );
        $cbcart_result                   = update_option( 'cbcart_contactformsettings', wp_json_encode( $cbcart_update_notifications_arr ) );
        $cbcart_update_notifications_arr = array(
            'cbcart_admin_mobileno'             => "",
            'cbcart_admin_message'              => "Hi,\n\nAn order is placed on {{storename}} at {{siteurl}}\n\nThe order is for {{productname}}\n\nand the order amount is {{orderamount}}\n\nCustomer details are: {{customeremail}}\n\nThanks.",
            'cbcart_admin_template_name'        => "cbcart_wp_order_notifs_admin_new_1",
            'cbcart_admin_template_lang'        => "en_US",
            'cbcart_admin_template_varcount'    => "5",
            'cbcart_customer_message'           => "Hi {{customername}},\r\n\r\nYour {{productname}} order of {{amount}} is placed.\r\n\r\nWe will keep you updated about your order status.\r\n\r\n{siteurl}",
            'cbcart_customer_template_name'     => "cbcart_wp_order_notifs_customer_new_1",
            'cbcart_customer_template_lang'     => "en_US",
            'cbcart_customer_template_varcount' => "3",
            'cbcart_customer_notification'      => "1",
            'cbcart_admin_notification'      => "1",
            'cbcart_order_image'                => $cbcart_order,
            'cbcart_is_order_completed'         =>"0",
            'cbcart_is_order_processing'         =>"1",
            'cbcart_is_order_payment_done'         =>"0",
        );
        $cbcart_result3                  = update_option( 'cbcart_ordernotificationsettings', wp_json_encode( $cbcart_update_notifications_arr ) );
    }
    wp_redirect( 'admin.php?page=cbcart_dashboard');
}
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
    if($cbcart_checkplan==="1"){
        delete_option('cbcart_testmessagesetup');
    }else{
        delete_option('cbcart_templatescreen');
    }
    $cbcart_page = isset( $_REQUEST['page'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['page'] ) ) : '';
    wp_redirect( 'admin.php?page=' . $cbcart_page );
}
//call function cbcart_set_message_option
cbcart::cbcart_set_message_option();

$cbcart_success       = CBCART_DIR . CBCART_DOMAIN . esc_url( '/admin/images/cbcart-success.png' ,'cartbox-messaging-widgets');
$cbcart_logo1     = cbcart_logonew_black;
$cbcart_check     = CBCART_DIR . CBCART_DOMAIN . esc_url( '/admin/images/cbcart-check.png' ,'cartbox-messaging-widgets');
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-2 text-center">
            <img src="<?php echo esc_url( $cbcart_logo1); ?>" class="cbcart_imgclass">
        </div>
    </div>
    <?php if($cbcart_checkplan==="4") {?>
        <div class="w-50 m-auto mt-4 mb-2">
            <div class="cbcart_header text-center d-flex flex-row flex-nowrap align-items-center justify-content-center">
                <div class="p-2">
                    <form method="post" name="cbcart_form3" action="" >
                        <?php wp_nonce_field( 'cbcart_setup_mobile', 'cbcart_setup_mobile_nonce' ); ?>
                        <button type="submit" class="btn" id="cbcart_back_btn" name="cbcart_restart_btn"><i class="fa fa-angle-left cbcart_arrow_left"></i></button>
                    </form>
                </div>
                <div class="cbcart_header_number cbcart_header_done"><i class="fa fa-check cbcart_icolor"></i></div>
                <div class="cbcart_header_label cbcart_selected"><label><?php esc_html_e('Setup Account','cartbox-messaging-widgets' ); ?></label></div>
                <hr>
                <div class="cbcart_header_number cbcart_header_done"><i class="fa fa-check cbcart_icolor"></i></div>
                <div class="cbcart_header_label cbcart_selected"><label><?php esc_html_e('Send a Test Message','cartbox-messaging-widgets' ); ?></label></div>
            </div>
        </div>
    <?php }else{ ?>
        <div class="w-75 m-auto mt-4 mb-2">
            <div class="cbcart_header text-center d-flex flex-row flex-nowrap align-items-center">
                <div class="p-2">
                    <form method="post" name="cbcart_form3" action="" >
                        <?php wp_nonce_field( 'cbcart_setup_mobile', 'cbcart_setup_mobile_nonce' ); ?>
                        <button type="submit" class="btn" id="cbcart_back_btn" name="cbcart_restart_btn"><i class="fa fa-angle-left cbcart_arrow_left"></i></button>
                    </form>
                </div>
                <div class="cbcart_header_number cbcart_header_done"><i class="fa fa-check cbcart_icolor"></i></div>
                <div class="cbcart_header_label cbcart_selected"><label><?php esc_html_e('Verify Email','cartbox-messaging-widgets' ); ?></label></div>
                <hr>
                <div class="cbcart_header_number cbcart_header_done"><i class="fa fa-check cbcart_icolor"></i></div>
                <div class="cbcart_header_label cbcart_selected"><label><?php esc_html_e('Set Mobile Number','cartbox-messaging-widgets' ); ?></label></div>
                <hr>
                <div class="cbcart_header_number cbcart_header_done"><i class="fa fa-check cbcart_icolor"></i></div>
                <div class="cbcart_header_label cbcart_selected"><label><?php esc_html_e('Send a Test Message','cartbox-messaging-widgets' ); ?></label></div>
            </div>
        </div>
    <?php } ?>
	<form class="cbcart_form_div text-center" method="post">
        <div>
		    <img src="<?php echo esc_url($cbcart_success) ?>" alt="<?php esc_attr_e('Congratulations image','cartbox-messaging-widgets'); ?>" />
        </div>
        <div class="row m-0 p-0">
<label class="cbcart_card-text3"><?php esc_html_e('Congratulations!','cartbox-messaging-widgets') ?></label>
            <label class="cbcart_supportlabel m-0 mt-2 mb-4"><?php esc_html_e('Your setup is completed and now messages will go automatically.','cartbox-messaging-widgets' ); ?></label>
        </div>
        <div>
	        <?php wp_nonce_field( 'cbcart_setup_success', 'cbcart_setup_success_nonce' ); ?>
            <button name="cbcart_dashboard" type="submit" class="btn cbcart_btn-theme mt-3"><?php esc_html_e('Dashboard','cartbox-messaging-widgets' ); ?></button>
       </div>
        <label class="cbcart_lbl3 mt-5 cbcart_enable_label" ><?php esc_html_e('The following services are enabled for your business.','cartbox-messaging-widgets' ); ?></label>
    </form>
    <div class="row justify-content-md-center mt-5">
        <div class="col col-lg-2 text-center">
            <div class="cbcart_check_round">
                <img src="<?php echo esc_url($cbcart_check) ?>" alt="<?php esc_attr_e('check image','cartbox-messaging-widgets') ?>"  >
            </div>
            <div class="mt-2">
                <label class="cbcart_supportlabel"><?php esc_html_e('5 Abandoned Cart Reminder Messages','cartbox-messaging-widgets' ); ?></label>
            </div>
        </div>
        <div class="col col-1 text-center cbcart_vertical_dotted_line p-0">
        </div>
        <div class="col-lg-2 text-center">
            <div class="cbcart_check_round">
                <img src="<?php echo esc_url($cbcart_check) ?>" alt="<?php esc_attr_e('check image','cartbox-messaging-widgets') ?>"  >
            </div>
            <div class="mt-2 ">
                <label class="cbcart_supportlabel m-0 mt-3"><?php esc_html_e('Successful order alert messages to customer and admin','cartbox-messaging-widgets' ); ?></label>
            </div>
        </div>
        <div class="col col-1 text-center cbcart_vertical_dotted_line">
        </div>
        <div class="col col-lg-2 text-center">
            <div class="cbcart_check_round">
                <img src="<?php echo esc_url( $cbcart_check) ?>" alt="<?php esc_attr_e('check image','cartbox-messaging-widgets') ?>"  >
            </div>
            <div class="mt-2">
                <label class="cbcart_supportlabel"><?php esc_html_e('Contact Form 7 inquiry message alerts to admin.','cartbox-messaging-widgets' ); ?></label>
            </div>
        </div>
    </div>
</div>
