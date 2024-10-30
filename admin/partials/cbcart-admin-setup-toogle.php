<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$cbcart_account_status_flag = "";
$cbcart_data = get_option('cbcart_usersettings');
$cbcart_data = json_decode($cbcart_data);
$cbcart_data= sanitize_option(  "cbcart_usersettings",$cbcart_data);

if ($cbcart_data != "") {
    $cbcart_isMessageFromAdminNumber = $cbcart_data->cbcart_isMessageFromAdminNumber;
    $cbcart_official_number = $cbcart_data->cbcart_official_number;
    $cbcart_check_plan = $cbcart_data->cbcart_planid;
} else {
    $cbcart_isMessageFromAdminNumber = "";
    $cbcart_official_number = "";
    $cbcart_check_plan = $cbcart_data->cbcart_planid;
}
if (!empty(get_option('cbcart_userplan'))) {
    $cbcart_data = get_option('cbcart_userplan');
    $cbcart_data = json_decode($cbcart_data);
    $cbcart_data= sanitize_option(  "cbcart_userplan",$cbcart_data);

    if ($cbcart_data != "") {
        $cbcart_loginLink = $cbcart_data->loginLink;
    } else {
        $cbcart_loginLink = "";
    }
}
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
// Set mobile number for admin
if (isset($_POST['cbcart_test1'])) {
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
    $cbcart_default_country = isset($_POST['cbcart_default_country']) ? sanitize_text_field(wp_unslash($_POST['cbcart_default_country'])) : '';
    $cbcart_from_number = isset($_POST['cbcart_from_number']) ? sanitize_text_field(wp_unslash($_POST['cbcart_from_number'])) : '';
    $cbcart_wabaid = isset($_POST['cbcart_wabaid']) ? sanitize_text_field(wp_unslash($_POST['cbcart_wabaid'])) : '';
    $cbcart_phoneid = isset($_POST['cbcart_phoneid']) ? sanitize_text_field(wp_unslash($_POST['cbcart_phoneid'])) : '';
    $cbcart_token = isset($_POST['cbcart_token']) ? sanitize_text_field(wp_unslash($_POST['cbcart_token'])) : '';
    $cbcart_flag = 1;

    if ($cbcart_default_country == "") {
        $cbcart_default_country = '91';
    }
    if (empty($cbcart_from_number)) {
        $cbcart_flag = 0;
        $cbcart_error_mobileno = '';
        $cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible">';
        $cbcart_error_mobileno .= '<p>' . esc_html('Please Enter Mobile Number.','cartbox-messaging-widgets') . '</p>';
        $cbcart_error_mobileno .= '</div>';
        echo wp_kses_post($cbcart_error_mobileno);
    } elseif (strlen($cbcart_from_number) <= 7) {
        $cbcart_flag = 0;
        $cbcart_error_mobileno = '';
        $cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible">';
        $cbcart_error_mobileno .= '<p>' . esc_html('Please enter correct digit number.','cartbox-messaging-widgets') . '</p>';
        $cbcart_error_mobileno .= '</div>';
        echo wp_kses_post($cbcart_error_mobileno);
    } elseif (preg_match('#[^0-9]#', $cbcart_from_number)) {
        $cbcart_flag = 0;
        $cbcart_error_mobileno = '';
        $cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible">';
        $cbcart_error_mobileno .= '<p>' . esc_html('Please Enter only numbers.','cartbox-messaging-widgets') . '</p>';
        $cbcart_error_mobileno .= '</div>';
        echo wp_kses_post($cbcart_error_mobileno);
    } else {
        $cbcart_from_number = $cbcart_default_country . $cbcart_from_number;
    }
    if (empty($cbcart_wabaid)) {
        $cbcart_flag = 0;
        $cbcart_error_mobileno = '';
        $cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible">';
        $cbcart_error_mobileno .= '<p>' . esc_html('Please Enter WhatsApp Business Account ID.','cartbox-messaging-widgets') . '</p>';
        $cbcart_error_mobileno .= '</div>';
        echo wp_kses_post($cbcart_error_mobileno);
    } elseif (strlen($cbcart_wabaid) < 15 || strlen($cbcart_phoneid) > 15) {
        $cbcart_flag = 0;
        $cbcart_error_mobileno = '';
        $cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible">';
        $cbcart_error_mobileno .= '<p>' . esc_html('Please Enter atleast 15 digit WhatsApp Business Account ID.','cartbox-messaging-widgets') . '</p>';
        $cbcart_error_mobileno .= '</div>';
        echo wp_kses_post($cbcart_error_mobileno);
    } elseif (preg_match('#[^0-9]#', $cbcart_wabaid)) {
        $cbcart_flag = 0;
        $cbcart_error_mobileno = '';
        $cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible">';
        $cbcart_error_mobileno .= '<p>' . esc_html('Please Enter only numbers in WhatsApp Business Account ID.','cartbox-messaging-widgets') . '</p>';
        $cbcart_error_mobileno .= '</div>';
        echo wp_kses_post($cbcart_error_mobileno);
    }
    if (empty($cbcart_phoneid)) {
        $cbcart_flag = 0;
        $cbcart_error_mobileno = '';
        $cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible">';
        $cbcart_error_mobileno .= '<p>' . esc_html('Please Enter Facebook cloud Phone number ID.','cartbox-messaging-widgets') . '</p>';
        $cbcart_error_mobileno .= '</div>';
        echo wp_kses_post($cbcart_error_mobileno);
    } elseif (strlen($cbcart_phoneid) < 15 || strlen($cbcart_phoneid) > 15) {
        $cbcart_flag = 0;
        $cbcart_error_mobileno = '';
        $cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible">';
        $cbcart_error_mobileno .= '<p>' . esc_html('Please Enter atleast 15 digit Facebook cloud Phone number ID .','cartbox-messaging-widgets') . '</p>';
        $cbcart_error_mobileno .= '</div>';
        echo wp_kses_post($cbcart_error_mobileno);
    } elseif (preg_match('#[^0-9]#', $cbcart_phoneid)) {
        $cbcart_flag = 0;
        $cbcart_error_mobileno = '';
        $cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible">';
        $cbcart_error_mobileno .= '<p>' . esc_html('Please Enter only numbers in Facebook cloud Phone number ID.','cartbox-messaging-widgets') . '</p>';
        $cbcart_error_mobileno .= '</div>';
        echo wp_kses_post($cbcart_error_mobileno);
    }
    if (empty($cbcart_token)) {
        $cbcart_flag = 0;
        $cbcart_error_mobileno = '';
        $cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible">';
        $cbcart_error_mobileno .= '<p>' . esc_html('Please Enter Facebook cloud Permanent Token.','cartbox-messaging-widgets') . '</p>';
        $cbcart_error_mobileno .= '</div>';
        echo wp_kses_post($cbcart_error_mobileno);
    }
    if ($cbcart_flag == 1) {
        $cbcart_account_status_flag = "";
        $cbcart_api_status = cbcart::cbcart_check_account_status($cbcart_wabaid, $cbcart_token);
        $cbcart_api_status = json_decode($cbcart_api_status);
        if (property_exists($cbcart_api_status, 'account_review_status')) {
            $cbcart_account_review_status = $cbcart_api_status->account_review_status;
            if (str_contains($cbcart_account_review_status, "APPROVED")) {
                $cbcart_account_status_flag = "1";
                $cbcart_account_status_message="";
            } elseif (str_contains($cbcart_account_review_status, "REJECTED")) {
                $cbcart_account_status_flag = "0";
                $cbcart_account_status_message="Your Facebook Cloud API Account Is Rejected by Facebook!!";
            } else {
                $cbcart_account_status_flag = "3";
                $cbcart_account_status_message="Something Is Wrong With Your Facebook Cloud API Account.";
            }
        } elseif (property_exists($cbcart_api_status, 'error')) {
            $cbcart_account_status_flag = "2";
            $cbcart_account_status_message="Your Below Credentials Are Wrong";
        } else {
            $cbcart_account_status_flag = "3";
            $cbcart_account_status_message="Something Is Wrong With Your Facebook Cloud API Account.";
        }
        if ($cbcart_account_status_flag === "1") {
            $cbcart_update_option_arr = array('cbcart_username' => $cbcart_username, 'cbcart_password' => $cbcart_password, 'cbcart_email' => $cbcart_email, 'cbcart_from_number' => $cbcart_from_number, 'cbcart_default_country' => $cbcart_default_country, 'cbcart_cron_time' => $cbcart_cron_time,);
            $cbcart_result = update_option('cbcart_adminsettings', wp_json_encode($cbcart_update_option_arr));

            $cbcart_update_arr = array('cbcart_wabaid' => $cbcart_wabaid, 'cbcart_phoneid' => $cbcart_phoneid, 'cbcart_token' => $cbcart_token,);
            $cbcart_result = update_option('cbcart_premiumsettings', wp_json_encode($cbcart_update_arr));
            $cbcart_page = isset($_REQUEST['page']) ? sanitize_text_field(wp_unslash($_REQUEST['page'])) : '';
            wp_redirect('admin.php?page=' . $cbcart_page);
        }
    }
}
if (isset($_POST['cbcart_restart_btn'])) {
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
    if ($cbcart_check_plan === "4") {
        delete_option('cbcart_startup');
    } else {
        delete_option('cbcart_adminsettings');
        delete_option('cbcart_userplan');
        delete_option('cbcart_usersettings');
    }
    $cbcart_page = isset($_REQUEST['page']) ? sanitize_text_field(wp_unslash($_REQUEST['page'])) : '';
    wp_redirect('admin.php?page=' . $cbcart_page);
}
if ($cbcart_check_plan === "2") {
    $cbcart_planname = "The plugin needs the below information to send WhatsApp messages.";
} else if ($cbcart_check_plan === "3") {
    $cbcart_planname = "You are using Ultimate Plan.";
} else if ($cbcart_check_plan === "4") {
    $cbcart_planname = "The plugin needs the below information to send WhatsApp messages.";
} else {
    $cbcart_planname = "";
}
$cbcart_logo = cbcart_logonew_black;
$cbcart_logo1 = cbcart_globicon;
$cbcart_logo2 = cbcart_chat_icon;
$cbcart_cloud_setup = cbcart_cloudsetup_img;
$cbcart_ptoken = cbcart_p_token_img;
$cbcart_create_template=cbcart_template_img;

$cbcart_blogurl ="https://www.cartbox.net/blog/how-to-setup-whatsapp-cloud-api/";
$cbcart_whatsapp_link = esc_url('https://www.cartbox.net/blog/how-to-setup-whatsapp-cloud-api/#step18');
$cbcart_phone_id_link = esc_url('https://www.cartbox.net/blog/how-to-setup-whatsapp-cloud-api/#step18');
$cbcart_token_link = esc_url('https://www.cartbox.net/blog/how-to-generate-the-permanent-token-in-cloud-api/');


?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-2 text-center">
            <img src="<?php echo esc_url($cbcart_logo); ?>" class="cbcart_imgclass">
        </div>
    </div>
    <?php if ($cbcart_check_plan === "4") { ?>
        <div class="w-50 m-auto mt-4">
            <div class="cbcart_header text-center d-flex flex-row flex-nowrap align-items-center justify-content-center">
                <div class="p-2">
                    <form method="post" name="cbcart_form3" action="">
                        <?php wp_nonce_field('cbcart_setup_mobile', 'cbcart_setup_mobile_nonce'); ?>
                        <button type="submit" class="btn" id="cbcart_back_btn2" name="cbcart_restart_btn"><i class="fa fa-angle-left cbcart_arrow_left"></i></button>
                    </form>
                </div>
                <div class="cbcart_header_number cbcart_selected_number"><?php esc_html_e('1','cartbox-messaging-widgets') ?></div>
                <div class="cbcart_header_label cbcart_selected">
                    <label><?php esc_html_e('Setup Account','cartbox-messaging-widgets') ?></label></div>
                <hr>
                <div class="cbcart_header_number"><?php esc_html_e('2','cartbox-messaging-widgets') ?></div>
                <div class="cbcart_header_label">
                    <label><?php esc_html_e('Send a Test Message','cartbox-messaging-widgets') ?></label></div>
            </div>
        </div>
    <?php } else { ?>
        <div class="w-75 m-auto mt-4">
            <div class="cbcart_header text-center d-flex flex-row flex-nowrap align-items-center">
                <div class="p-2">
                    <form method="post" name="cbcart_form3" action="">
                        <?php wp_nonce_field('cbcart_setup_mobile', 'cbcart_setup_mobile_nonce'); ?>
                        <button type="submit" class="btn" id="cbcart_back_btn" name="cbcart_restart_btn"><i class="fa fa-angle-left cbcart_arrow_left"></i></button>
                    </form>
                </div>
                <div class="cbcart_header_number cbcart_header_done"><i class="fa fa-check cbcart_icolor"></i></div>
                <div class="cbcart_header_label cbcart_selected">
                    <label><?php esc_html_e('Verify Email','cartbox-messaging-widgets') ?></label></div>
                <hr>
                <div class="cbcart_header_number cbcart_selected_number"><?php esc_html_e('2','cartbox-messaging-widgets') ?></div>
                <div class="cbcart_header_label cbcart_selected">
                    <label><?php esc_html_e('Set Mobile Number','cartbox-messaging-widgets') ?></label></div>
                <hr>
                <div class="cbcart_header_number"><?php esc_html_e('3','cartbox-messaging-widgets') ?></div>
                <div class="cbcart_header_label">
                    <label><?php esc_html_e('Send a Test Message','cartbox-messaging-widgets') ?></label></div>
            </div>
        </div>
    <?php } ?>
    <div class="d-flex justify-content-end">
        <div class="mr-auto w-50">
            <form method="post" name="cbcart_form1" action="">
                <div class="cbcart_scren1_body">
                    <div class="row text-center cbcart_scren1_body">
                        <div class="text-center m-2 cbcart_scren1_body">
                            <label class="cbcart_label"><?php esc_html_e('Enter your WhatsApp cloud API details','cartbox-messaging-widgets') ?></label>
                        </div>
                        <div class="row text-center">
                            <label class="cbcart-lbl"> <?php
                                printf(
                                    esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                    esc_html($cbcart_planname)
                                );
                               ?><br><?php esc_html_e("Visit the",'cartbox-messaging-widgets'); ?>
                                <a href="admin.php?page=cbcart_tutorial" target="_blank">
                                    <?php esc_html_e("Tutorial",'cartbox-messaging-widgets');?></a><?php esc_html_e("  screen for more information.",'cartbox-messaging-widgets'); ?></label>
                        </div>
                    </div>
                    <?php if($cbcart_account_status_flag!="") {?>
                        <form method="post" action="">
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <div class="cbcart_account_status w-100">
                                            <button type="button" class="w-100 d-flex justify-content-between border-bottom-0 rounded-top" id="cbcart_collapse">
                                                <label class="text-danger fw-bolder fa fa-warning">&nbsp;<?php
                                                    printf(
                                                        esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                                        esc_html($cbcart_account_status_message)
                                                    );
                                                     ?></label>
                                                <i class="fa fa-angle-down"></i>
                                            </button>
                                            <div class="d-none p-3 bg-white border border-top-0" id="whaso_expand">
                                            <label class="cbcart_temp_text1 fw-bold text-black"><?php esc_html_e("Response from Facebook",'cartbox-messaging-widgets') ?></label>
                                                <label class="cbcart_temp_text1 text-break text-wrap"><?php
                                                    printf(
                                                        esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                                        esc_html($cbcart_api_status)
                                                    );
                                                     ?></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </form>
                    <?php } ?>

                    <div class="cbcart_set_display2">
                        <div class="row mt-4">
                            <label class="cbcart_label3 mb-2"><?php esc_html_e('Your WhatsApp number approved by ','cartbox-messaging-widgets'); ?>
                                <a class="cbcart_label3" href="<?php esc_url ($cbcart_blogurl);?>>" target="_blank"><u><?php esc_html_e('Facebook Cloud API','cartbox-messaging-widgets'); ?></u></a><span class="cbcart_required_star">*</span></label>
                            <div class="col-12">
                                <div class="d-flex flex-nowrap flex-row cbcart">
                                    <div class="col-3 cbcart_country_div">
                                        <select id="cbcart_default_country" name="cbcart_default_country" class="input-line cbcart_text_input mt-0 cbcart_counrty_text" ><?php
                                            printf(
                                                esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                                esc_html(cbcart_country_code)
                                            );
                                           ?> </select>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" name="cbcart_from_number" id="cbcart_from_number" onClick="this.setSelectionRange(0, this.value.length)" autocomplete="off" class="cbcart_text_input mt-0" maxlength="15" onpaste="return false" onkeyup="return isNumber()">
                                        <span id="cbcart_phonemsg d-none"></span>
                                    </div>
                                </div>
                                <div class="col-12 mt-4 mb-2">
                                    <label class="cbcart_label3" id="cbcart_waba_idlabel"> <a href="<?php
                                        printf(
                                            esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                            esc_html($cbcart_whatsapp_link)
                                        );
                                      ?>" class="cbcart_label3" target ="_blank"><u><?php esc_html_e('Enter your WhatsApp Business Account ID','cartbox-messaging-widgets'); ?></u><span class="cbcart_required_star"><?php esc_html_e('*','cartbox-messaging-widgets') ?></span> <span class="cbcart_text_primary"><?php esc_html_e('(?)','cartbox-messaging-widgets')?></span></a></label>
                                </div>
                                <div class="col-12">
                                    <input type="number" name="cbcart_wabaid" id="cbcart_wabaid" placeholder="<?php esc_attr_e('Enter Your WhatsApp Business Account ID ','cartbox-messaging-widgets'); ?>" autocomplete="off" class="cbcart_text_input mt-0" >
                                    <span id="cbcart_phoneid_error" class="cbcart_error"><?php esc_html_e('Please enter Valid WhatsApp Business Account ID.','cartbox-messaging-widgets'); ?></span>
                                </div>
                                <div class="col-12 mt-4 mb-2">
                                    <label class="cbcart_label3" id="cbcart_phonenumb_idlabel"><a href="<?php echo esc_url($cbcart_phone_id_link); ?>" class="cbcart_label3" target="_blank"><u><?php esc_html_e('Enter your Facebook Cloud Phone No. ID ','cartbox-messaging-widgets'); ?></u><span class="cbcart_required_star"><?php esc_html_e('*','cartbox-messaging-widgets') ?></span> <span class="cbcart_text_primary"><?php esc_html_e('(?)','cartbox-messaging-widgets')?></span></a></label>
                                </div>
                                <div class="col-12">
                                    <input type="number" name="cbcart_phoneid" id="cbcart_phoneid" autocomplete="off" class="cbcart_text_input mt-0" placeholder="<?php esc_attr_e('Enter Your Facebook Cloud Phone No. Id','cartbox-messaging-widgets'); ?>">
                                    <span id="cbcart_phoneid_error" class="cbcart_error"><?php esc_html_e('Please enter Valid Phone ID.','cartbox-messaging-widgets'); ?></span>
                                </div>
                                <div class="col-12 mt-4 mb-2">
                                    <label class="cbcart_label3" id="cbcart_tokenlabel"><a href="<?php echo esc_url($cbcart_token_link); ?>" class="cbcart_label3" target="_blank"><u><?php esc_html_e('Enter your Facebook Cloud Permanent Token ID ','cartbox-messaging-widgets'); ?></u><span class="cbcart_required_star"><?php esc_html_e('*','cartbox-messaging-widgets') ?></span> <span class="cbcart_text_primary"><?php esc_html_e('(?)','cartbox-messaging-widgets')?></span></a></label>
                                </div>
                                <div class="col-12">
                                    <textarea name="cbcart_token" id="cbcart_token" class="cbcart_text_input mt-0 h-auto" rows="4"></textarea>
                                    <span id="cbcart_phoneid_error" class="cbcart_error"><?php esc_html_e('Please enter Valid Token.','cartbox-messaging-widgets'); ?></span>
                                </div>
                            </div>
                        </div>
                        <?php wp_nonce_field('cbcart_setup_mobile', 'cbcart_setup_mobile_nonce'); ?>
                    </div>
                    <div class="row mb-2 justify-content-center">
                        <div class="col-md-12 text-center">
                            <?php wp_nonce_field('cbcart_setup_mobile', 'cbcart_setup_mobile_nonce'); ?>
                            <button type="submit" class="btn cbcart_btn-theme"
                                    name="cbcart_test1"><?php esc_html_e('Save & Continue','cartbox-messaging-widgets'); ?></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="w-25 mt-4">
            <div class="card cbcart_card cbcart_support_card">
                <img src="<?php echo esc_url($cbcart_logo2); ?>" class="cbcart_chatimg"/>
                <div class="card-body">
                    <div>
                        <label class="cbcart_lbl"><?php esc_html_e('Need Support: ','cartbox-messaging-widgets'); ?></label><br>
                    </div>
                    <div class="mt-3"><i class="fa fa-video-camera"></i><a
                                href="<?php echo esc_url(cbcart_video_url); ?>" target="_blank"
                                class="cbcart_supportlabel"><?php esc_html_e('Video Tutorial','cartbox-messaging-widgets'); ?></a><br>
                    </div>
                    <div class="mt-3"><img src="<?php echo esc_url($cbcart_logo1); ?>" class="cbcart_globeimg"><a
                                href="<?php echo esc_url(cbcart_product_page_url); ?>" target="_blank"
                                class="cbcart_supportlabel"><?php esc_html_e('Website','cartbox-messaging-widgets'); ?></a><br></div>
                    <div class="mt-3"><i class="fa  fa-comment-o"></i><a href="<?php echo esc_url(cbcart_site); ?>" target="_blank" class="cbcart_supportlabel"><?php esc_html_e('Chat','cartbox-messaging-widgets'); ?></a><br>
                    </div>
                    <div class="mt-3 "><i class="fa  fa-whatsapp"></i><a
                                href="<?php echo esc_url(cbcart_whatsapp_link); ?>" target="_blank"
                                class="cbcart_supportlabel"><?php esc_html_e('WhatsApp','cartbox-messaging-widgets'); ?></a></div>
                    <div class="mt-3"><i class="fa  fa-envelope-o"></i><a href="mailto:hi@cartbox.net" target="_blank" class="cbcart_supportlabel"><?php esc_html_e('Email','cartbox-messaging-widgets'); ?></a><br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="bg-white cbcart_steps_box cbcart_blog_div position-absolute">
    <div class="row m-0 p-3">
        <div class="col-12">
            <label class="cbcart_startup_heading cbcart_fw-700 text-black"><?php esc_html_e('Cloud API Setup Tutorials','cartbox-messaging-widgets'); ?></label>
        </div>
        <div class=" cbcart_startup_hr">
            <hr>
        </div>
        <div class="row m-0">
            <div class="col-md-3">
                <div class="card cbcart_steps_card h-75 p-0 rounded-4 cbcart_blog_card">
                    <div class="p-3 pb-2 pt-3">
                        <h4><?php esc_html_e('Step 1','cartbox-messaging-widgets'); ?></h4>
                    </div>
                    <div class="card-body pt-0">
                        <a class="stretched-link " href="https://www.cartbox.net/blog/how-to-setup-whatsapp-cloud-api/" target="_blank"><img class="w-100 rounded-3" src="<?php echo esc_url($cbcart_cloud_setup); ?>"></a>
                        <label class="text-black  mt-2"><?php esc_html_e('How to setup WhatsApp cloud API?','cartbox-messaging-widgets'); ?></label>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card cbcart_steps_card h-75 p-0 rounded-4 cbcart_blog_card">
                    <div class="p-3 pb-2 pt-3">
                        <h4><?php esc_html_e('Step 2','cartbox-messaging-widgets'); ?></h4>
                    </div>
                    <div class="card-body pt-0">
                        <a class="stretched-link " href="<?php echo esc_url($cbcart_token_link); ?>" target="_blank"><img class="w-100 rounded-3" src="<?php echo esc_url($cbcart_ptoken); ?>"></a>
                        <label class="text-black  mt-2"><?php esc_html_e('How to generate the permanent token in cloud API?','cartbox-messaging-widgets') ?></label>
                    </div>
                </div>
            </div><div class="col-md-3">
                <div class="card cbcart_steps_card h-75 p-0 rounded-4 cbcart_blog_card">
                    <div class="p-3 pb-2 pt-3">
                        <h4><?php esc_html_e('Step 3','cartbox-messaging-widgets'); ?></h4>
                    </div>
                    <div class="card-body pt-0">
                        <a class="stretched-link " href="https://www.cartbox.net/blog/how-to-create-templates-on-whatsapp-cloud-api/" target="_blank"><img class="w-100 rounded-3" src="<?php echo esc_url($cbcart_create_template); ?>"></a>
                        <label class="text-black  mt-2"><?php esc_html_e('How to create templates on WhatsApp cloud API?','cartbox-messaging-widgets'); ?></label>
                    </div>
                </div>
            </div><div class="col-md-3">
                <div class="card cbcart_steps_card h-75 p-0 rounded-4 cbcart_blog_card">
                    <div class="p-3 pb-2 pt-3">
                        <h4><?php esc_html_e('Step 4','cartbox-messaging-widgets'); ?></h4>
                    </div>
                    <div class="card-body pt-0">
                        <a class="stretched-link " href="https://www.cartbox.net/blog/how-to-set-webhook-to-receive-incoming-messages/" target="_blank"><img class="w-100 rounded-3" src="<?php echo esc_url(CBCART_URL ) ?>/admin/images/cbcart-maxresdefault.jpg"></a>
                        <label class="text-black  mt-2"><?php esc_html_e('How to setup WhatsApp cloud API?','cartbox-messaging-widgets'); ?></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
