<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$cbcart_testresponse = "";
$cbcart_account_status_flag="";
$cbcart_test_code="";
$cbcart_data = get_option('cbcart_usersettings');
$cbcart_data = json_decode($cbcart_data);
$cbcart_data= sanitize_option("cbcart_usersettings",$cbcart_data);
if ($cbcart_data != "") {
    $cbcart_checkplan = $cbcart_data->cbcart_planid;
} else {
    $cbcart_checkplan = "";
}
$cbcart_language_code = esc_html_e("en_US",'cartbox-messaging-widgets');
$cbcart_template_id = esc_html_e("hello_world",'cartbox-messaging-widgets');
$cbcart_data = get_option('cbcart_adminsettings');
$cbcart_data = json_decode($cbcart_data);
$cbcart_data= sanitize_option(  "cbcart_adminsettings",$cbcart_data);
if ($cbcart_data != "") {
    $cbcart_email = $cbcart_data->cbcart_email;
    $cbcart_username = $cbcart_data->cbcart_username;
    $cbcart_password = $cbcart_data->cbcart_password;
    $cbcart_cron_time = $cbcart_data->cbcart_cron_time;
} else {
    $cbcart_email = "";
    $cbcart_username = "";
    $cbcart_password = "";
    $cbcart_cron_time = "";
}
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
        $cbcart_error_mobileno .= '<p>' . esc_html_e('Please Enter Mobile Number.','cartbox-messaging-widgets') . '</p>';
        $cbcart_error_mobileno .= '</div>';
        echo wp_kses_post($cbcart_error_mobileno);
    } elseif (strlen($cbcart_to_number) < 7) {
        $cbcart_flag = 0;
        $cbcart_error_mobileno = '';
        $cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible">';
        $cbcart_error_mobileno .= '<p>' . esc_html_e('Please enter minimum 7 digits number.','cartbox-messaging-widgets') . '</p>';
        $cbcart_error_mobileno .= '</div>';
        echo wp_kses_post($cbcart_error_mobileno);
    }
    if ($cbcart_flag == 1) {
        $cbcart_update_arr = array(
            'cbcart_tonumber' => $cbcart_to_number,
            'cbcart_message' => $cbcart_message,
            'cbcart_testmessageid' => $cbcart_template_id,
            'cbcart_langcode' => $cbcart_language_code,
            'cbcart_checktest' => "",
        );
        $cbcart_result = update_option('cbcart_testmessagesetup', wp_json_encode($cbcart_update_arr));
        $cbcart_testresponse = cbcart::cbcart_sendtestmessage();
        $cbcart_test_code = $cbcart_testresponse['cbcart_response_code'];
        $cbcart_test_response = $cbcart_testresponse['cbcart_response_json'];

        if ($cbcart_test_code === 200) {
            $cbcart_account_status_flag="1";
            $cbcart_account_status_message='<label class="fa fa-check-square-o text-success"></label><label class="text-success"> &nbsp;'.esc_html("Message Sent Successfully",'cartbox-messaging-widgets').'</label>';
        } else if ($cbcart_test_code != 200) {
            $cbcart_account_status_flag="0";
            $cbcart_account_status_message='<label class="fa fa-warning text-danger"></label><label class="text-danger "> &nbsp;'.esc_html("Message Sending Failed",'cartbox-messaging-widgets').'</label>';
        } else {
            $cbcart_account_status_flag="0";
            $cbcart_account_status_message='<label class="fa fa-warning text-danger"></label><label class="text-danger "> &nbsp;'.esc_html("Message Sending Failed",'cartbox-messaging-widgets').'</label>';
        }
    }
}

if (isset($_POST['cbcart_continuebtn'])) {

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
    $cbcart_message = esc_html_e("Hi, thank you for opt-in to receive notifications from us on WhatsApp. We will send you regular updates on the progress of your order. If you wish to unsubscribe, please reply with STOP. Have a good day",'cartbox-messaging-widgets');

    $cbcart_update_arr = array(
        'cbcart_tonumber' => $cbcart_to_number,
        'cbcart_message' => $cbcart_message,
        'cbcart_testmessageid' => $cbcart_template_id,
        'cbcart_langcode' => $cbcart_language_code,
        'cbcart_checktest' => "done",
    );
    $cbcart_result1 = update_option('cbcart_testmessagesetup', wp_json_encode($cbcart_update_arr));

    $cbcart_default_link=cbcart_site;
    if($cbcart_checkplan==="1"){
        $cbcart_result1 = cbcart::cbcart_createtemplates($cbcart_default_link);
    }
    $cbcart_page = isset($_REQUEST['page']) ? sanitize_text_field(wp_unslash($_REQUEST['page'])) : '';
    wp_redirect('admin.php?page=' . $cbcart_page);
}
if (isset($_POST['cbcart_startagainbtn'])) {
    $cbcart_legit = true;
    if (!isset($_POST['cbcart_start_nonce'])) {
        $cbcart_legit = false;
    }
    $nonce = isset($_POST['cbcart_start_nonce']) ? sanitize_text_field(wp_unslash($_POST['cbcart_start_nonce'])) : '';
    if (!wp_verify_nonce($nonce, 'cbcart_start')) {
        $cbcart_legit = false;
    }
    if (!$cbcart_legit) {
        wp_safe_redirect(add_query_arg());
        exit();
    }
    $cbcart_update_option_arr = array(
        'cbcart_username' => $cbcart_username,
        'cbcart_password' => $cbcart_password,
        'cbcart_email' => $cbcart_email,
        'cbcart_cron_time' => $cbcart_cron_time,
        'cbcart_from_number' => "",
        'cbcart_default_country' => "",
    );
    $cbcart_result1 = update_option('cbcart_adminsettings', wp_json_encode($cbcart_update_option_arr));
    delete_option('cbcart_testmessagesetup');
    delete_option('cbcart_premiumsettings');
    $cbcart_page = isset($_REQUEST['page']) ? sanitize_text_field(wp_unslash($_REQUEST['page'])) : '';
    wp_redirect('admin.php?page=' . $cbcart_page);
}
$cbcart_logo1 = cbcart_logonew_black;
$cbcart_logo2 = cbcart_chat_icon;
$cbcart_logo = cbcart_globicon;
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-2 text-center">
            <img src="<?php echo esc_url($cbcart_logo1,'cartbox-messaging-widgets'); ?>" class="cbcart_imgclass">
        </div>
    </div>
    <?php if ($cbcart_checkplan === "4") { ?>
        <div class="w-50 m-auto mt-4 mb-2">
            <div class="cbcart_header text-center d-flex flex-row flex-nowrap align-items-center justify-content-center">
                <div class="p-2">
                    <form method="post" name="cbcart_form2" action="">
                        <?php wp_nonce_field('cbcart_start', 'cbcart_start_nonce'); ?>
                        <button type="submit" class="btn" id="cbcart_back_btn" name="cbcart_startagainbtn"><i class="fa fa-angle-left cbcart_arrow_left"></i></button>
                    </form>
                </div>
                <div class="cbcart_header_number cbcart_header_done"><i class="fa fa-check cbcart_icolor"></i></div>
                <div class="cbcart_header_label cbcart_selected">
                    <label><?php esc_html_e('Setup Account','cartbox-messaging-widgets'); ?></label></div>
                <hr>
                <div class="cbcart_header_number cbcart_selected_number"><?php esc_html_e('2','cartbox-messaging-widgets'); ?></div>
                <div class="cbcart_header_label">
                    <label><?php esc_html_e('Send a Test Message','cartbox-messaging-widgets'); ?></label></div>
            </div>
        </div>

    <?php } else { ?>
        <div class="w-75 m-auto mt-4 mb-2">
            <div class="cbcart_header text-center d-flex flex-row flex-nowrap align-items-center">
                <div class="p-2">
                    <form method="post" name="cbcart_form2" action="">
                        <?php wp_nonce_field('cbcart_start', 'cbcart_start_nonce'); ?>
                        <button type="submit" class="btn" id="cbcart_back_btn" name="cbcart_startagainbtn"><i class="fa fa-angle-left cbcart_arrow_left"></i></button>
                    </form>
                </div>
                <div class="cbcart_header_number cbcart_header_done"><i class="fa fa-check cbcart_icolor"></i></div>
                <div class="cbcart_header_label cbcart_selected">
                    <label><?php esc_html_e('Verify Email','cartbox-messaging-widgets'); ?></label></div>
                <hr>
                <div class="cbcart_header_number cbcart_header_done"><i class="fa fa-check cbcart_icolor"></i></div>
                <div class="cbcart_header_label cbcart_selected">
                    <label><?php esc_html_e('Set Mobile Number','cartbox-messaging-widgets'); ?></label></div>
                <hr>
                <div class="cbcart_header_number cbcart_selected_number"><?php esc_html_e('3','cartbox-messaging-widgets'); ?></div>
                <div class="cbcart_header_label">
                    <label><?php esc_html_e('Send a Test Message','cartbox-messaging-widgets'); ?></label></div>
            </div>
        </div>
    <?php } ?>
    <form class="cbcart_scren1_body" method="post" name="form3" id="cbcart_form3">
        <div class="container-fluid cbcart_max-width-600">
            <div class="row text-center">
                <label class="cbcart_label"><?php esc_html_e('Send WhatsApp Test Message','cartbox-messaging-widgets'); ?></label>
            </div>
            <?php if($cbcart_account_status_flag!="") {?>
                <form method="post" action="">
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="cbcart_account_status w-100">
                                <button type="button" class="w-100 d-flex justify-content-between border-bottom-0 rounded-top" id="cbcart_collapse">
                                    <label><?php echo wp_kses_post($cbcart_account_status_message); ?></label>
                                    <i class="fa fa-angle-down"></i>
                                </button>
                                <div class="d-none p-3 bg-white border border-top-0" id="whaso_expand">
                                    <label class="cbcart_temp_text1 fw-bold text-black"><?php esc_html_e("Response from Facebook",'cartbox-messaging-widgets') ?></label>
                                    <label class="cbcart_temp_text1 text-break text-wrap"><?php
                                        printf(
                                            esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                            esc_html($cbcart_test_response)
                                        );
                                        ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            <?php } ?>
            <div class="row mb-2 mt-4">
                <div class="col-12 mb-2">
                    <label class="cbcart_label3"><?php esc_html_e('Enter any  WhatsApp number to receive test message','cartbox-messaging-widgets'); ?>
                        <sup class="cbcart_required_star"> *</sup></label>
                    <input type="hidden" name="cbcart_template1">
                </div>
                <div class="col-11">
                    <input type="text" name="cbcart_tonumber" onClick="this.setSelectionRange(0, this.value.length)" autocomplete="off" class='cbcart_text_input mt-0' maxlength="15" onpaste="return false" onkeypress="return isNumber(event)" id="cbcart_tonumber" placeholder="<?php esc_attr_e('Do Not Prefix number with 0 or + .','cartbox-messaging-widgets'); ?>" required/>
                    <label id="cbcart_error_mobileno" class="cbcart_error"><?php esc_html_e('Please enter correct Mobile number.','cartbox-messaging-widgets'); ?></label>
                    <label id="cbcart_phonemsg1" class="cbcart_test_lbl"><?php esc_html_e('Please enter minimum 7 digits number.','cartbox-messaging-widgets'); ?></label><br/>
                </div>
            </div>
            <?php if ($cbcart_checkplan === "2" || $cbcart_checkplan === "3" || $cbcart_checkplan === "4") { ?>
                <div class="row mb-2">
                    <div class="col-12 mb-2">
                        <label class="cbcart_label3 text-black"><a class="cbcart_label3" href="https://business.facebook.com/wa/manage/message-templates/" target="_blank"><?php esc_html_e('Template name','cartbox-messaging-widgets'); ?></a><sup class="cbcart_required_star"> *</sup></label>
                        <input type="hidden" name="cbcart_template1">
                    </div>
                    <div class="col-11">
                        <input type="text" name="cbcart_template" id="cbcart_template" value="<?php

                        printf(
                            esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                            esc_html($cbcart_template_id)
                        );
                         ?>" autocomplete="off" maxlength="32" class="cbcart_text_input mt-0" required>
                    </div>
                    <div class="col-1"><i class="fa fa-info-circle" title="<?php esc_html_e('A sample massage is usually available for testing.','cartbox-messaging-widgets'); ?>" data-toggle="tooltip"></i></div>
                    <label id="cbcart_error_username" class="cbcart_error"><?php esc_html_e('Please enter template name properly.','cartbox-messaging-widgets'); ?></label>
                </div>
                <div class="row mb-2">
                    <div class="col-12 mb-2">
                        <label class="cbcart_label3 text-black"><a class="cbcart_label3" href="https://business.facebook.com/wa/manage/message-templates/" target="_blank"><?php esc_html_e('Language code','cartbox-messaging-widgets'); ?> </a><sup class="cbcart_required_star"> *</sup></label>
                        <input type="hidden" name="cbcart_password1">
                    </div>
                    <div class="col-11">
                        <input type="text" name="cbcart_langcode" id="cbcart_langcode" value="<?php
                        printf(
                            esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                            esc_html($cbcart_language_code)
                        );
                        ?>" autocomplete="off" maxlength="32" class="cbcart_text_input mt-0" required>
                    </div>
                    <div class="col-1"><i class="fa fa-info-circle" title="<?php esc_html_e('Sample massage in English language.','cartbox-messaging-widgets'); ?>" data-toggle="tooltip"></i>
                    </div>
                    <label id="cbcart_error_password" class="cbcart_error"><?php esc_html_e('Please enter language code.','cartbox-messaging-widgets'); ?></label>
                </div>
            <?php } ?>
            <?php if ($cbcart_checkplan == "2" || $cbcart_checkplan === "3" || $cbcart_checkplan === "4") { ?>
                <label class="cbcart_lbl1 mt-5"><?php esc_html_e("NOTE : To send a test message please ensure you have an approved template by Facebook. ",'cartbox-messaging-widgets'); ?>
                    <a href="https://business.facebook.com/wa/manage/message-templates/" target="_blank"><?php esc_html_e("Click Here",'cartbox-messaging-widgets'); ?></a><?php esc_html_e("  to view all your templates.",'cartbox-messaging-widgets') ?>
                </label>
            <?php } ?>
            <?php wp_nonce_field('cbcart_send_test_msg', 'cbcart_send_test_msg_nonce'); ?>
            <div class="col-12 text-center mt-4">
                <button type="submit" class="btn cbcart_btn-theme" name="cbcart_test1"><?php esc_html_e('Send Test Message','cartbox-messaging-widgets'); ?></button>
            </div>
        </div>
    </form>
    <?php
    if ($cbcart_test_code === 200) {
        $cbcart_notice_message = esc_html_e('If you have recieved a message','cartbox-messaging-widgets'); ?>
        <form method="post" name="form" id="cbcart_form" class="cbcart_scren1_body cbcart_notice_div">
            <div class="text-center mt-5">
                <?php wp_nonce_field('cbcart_send_test_msg', 'cbcart_send_test_msg_nonce'); ?>
                <label class="cbcart_sub_label"><?php
                    printf(
                        esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                        esc_html($cbcart_notice_message)
                    );
                    ?></label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <button name="cbcart_continuebtn" class="btn cbcart_btn_theme_border_2 cbcart_test_submit" type="submit"><?php esc_html_e('Continue','cartbox-messaging-widgets'); ?></button>
            </div>
        </form>
    <?php } ?>
    <form method="post" name="cbcart_form" id="cbcart_form" class="cbcart_scren1_body text-center">
        <?php wp_nonce_field('cbcart_start', 'cbcart_start_nonce'); ?>
        <button class="cbcart_btn_blank mt-3" name="cbcart_startagainbtn"><?php esc_html_e('Restart onboarding if any error','cartbox-messaging-widgets'); ?></button>
    </form>
</div>
<div class="card cbcart_card cbcart_support_card">
    <img src="<?php echo esc_url($cbcart_logo2); ?>" class="cbcart_chatimg"></img>
    <div class="card-body">
        <div><label class="cbcart_lbl"><?php esc_html_e('Need Support: ','cartbox-messaging-widgets'); ?></label><br></div>
        <div class="mt-3"><i class="fa fa-video-camera"></i><a href="<?php echo esc_url(cbcart_video_url); ?>" target="_blank" class="cbcart_supportlabel"><?php esc_html_e('Video Tutorial','cartbox-messaging-widgets'); ?></a><br>
        </div>
        <div class="mt-3"><img src="<?php echo esc_url($cbcart_logo); ?>" class="cbcart_globeimg"><a href="<?php echo esc_url(cbcart_product_page_url); ?>" target="_blank" class="cbcart_supportlabel"><?php esc_html_e('Website','cartbox-messaging-widgets'); ?></a><br></div>
        <div class="mt-3"><i class="fa  fa-comment-o"></i><a href="<?php echo esc_url(cbcart_site); ?>" target="_blank" class="cbcart_supportlabel"><?php esc_html_e('Chat','cartbox-messaging-widgets'); ?></a><br>
        </div>
        <div class="mt-3 "><i class="fa  fa-whatsapp"></i><a href="<?php echo esc_url(cbcart_whatsapp_link); ?>" target="_blank" class="cbcart_supportlabel"><?php esc_html_e('WhatsApp','cartbox-messaging-widgets'); ?></a>
        </div>
        <div class="mt-3"><i class="fa  fa-envelope-o"></i><a href="mailto:hi@cartbox.net" target="_blank" class="cbcart_supportlabel"><?php esc_html_e('Email','cartbox-messaging-widgets'); ?></a><br>
        </div>
    </div>
</div>
