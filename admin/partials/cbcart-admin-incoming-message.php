<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$cbcart_logo = cbcart_logonew_black;
$cbcart_logo1 = cbcart_globicon;
$cbcart_logo2 = cbcart_chat_icon;

$cbcart_data = get_option('cbcart_usersettings');
$cbcart_data = json_decode($cbcart_data);
$cbcart_data             =  sanitize_option(  "cbcart_usersettings",$cbcart_data);
if ($cbcart_data != "") {
    $cbcart_checkplan = $cbcart_data->cbcart_planid;
} else {
    $cbcart_checkplan = "";
}
$cbcart_data=get_option('cbcart_inboxmessage');
$cbcart_data = json_decode($cbcart_data);
$cbcart_data             =  sanitize_option(  "cbcart_inboxmessage",$cbcart_data);
if ($cbcart_data != "") {
    $cbcart_email_1 = $cbcart_data->cbcart_email;
    $cbcart_forwarded = $cbcart_data->cbcart_forwardnumber;
}
else{
    $cbcart_email_1 = "";
    $cbcart_forwarded = "";
}

if($cbcart_checkplan==="1"||$cbcart_checkplan==="3"){
    $cbcart_data = get_option('cbcart_adminsettings');
    $cbcart_data = json_decode($cbcart_data);
    $cbcart_data             =  sanitize_option(  "cbcart_adminsettings",$cbcart_data);
    if ($cbcart_data != "") {
        $cbcart_email = $cbcart_data->cbcart_email;
    }
    else{
        $cbcart_email = "";
    }
}else{
    $cbcart_email = "";
}
if($cbcart_email_1===""){
    $cbcart_email_1=$cbcart_email;
}
if (isset($_POST['cbcart_submit'])) {
    $cbcart_legit = true;
    if (!isset($_POST['cbcart_update_form2_nonce']) ) {
        $cbcart_legit = false;
    }
    $cbcart_nonce = isset($_POST['cbcart_update_form2_nonce']) ? sanitize_text_field(wp_unslash($_POST['cbcart_update_form2_nonce'])) : '';
    if (!wp_verify_nonce($cbcart_nonce, 'cbcart_update_form2')) {
        $cbcart_legit = false;
    }
    if (!$cbcart_legit) {
        wp_safe_redirect(add_query_arg());
        exit();
    }
    $cbcart_email = isset($_POST['cbcart_email']) ? sanitize_text_field(wp_unslash($_POST['cbcart_email'])) : '';
    $cbcart_forwarded = isset($_POST['cbcart_forwardnumber']) ? sanitize_text_field(wp_unslash($_POST['cbcart_forwardnumber'])) : '';
    $cbcart_flag=1;
    if($cbcart_email===""){
        $cbcart_flag=0;
        $cbcart_error = '';
        $cbcart_error .= '<div class="notice notice-error is-dismissible">';
        $cbcart_error .= '<p>' . esc_html( 'Please Enter Valid Email Id.','cartbox-messaging-widgets' ) . '</p>';
        $cbcart_error .= '</div>';
        echo wp_kses_post( $cbcart_error );
    }
    if (empty($cbcart_forwarded)) {
        $cbcart_flag = 0;
        $cbcart_error_mobileno = '';
        $cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible">';
        $cbcart_error_mobileno .= '<p>' . esc_html('Please Enter Mobile Number.','cartbox-messaging-widgets') . '</p>';
        $cbcart_error_mobileno .= '</div>';
        echo wp_kses_post($cbcart_error_mobileno);
    }elseif (preg_match('#[^0-9]#', $cbcart_forwarded)) {
        $cbcart_flag = 0;
        $cbcart_error_mobileno = '';
        $cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible">';
        $cbcart_error_mobileno .= '<p>' . esc_html('Please Enter Only Numbers in Mobile Number.','cartbox-messaging-widgets') . '</p>';
        $cbcart_error_mobileno .= '</div>';
        echo wp_kses_post($cbcart_error_mobileno);
    }
    if($cbcart_flag===1){
        $cbcart_update_arr = array(
            'cbcart_email' => $cbcart_email,
            'cbcart_forwardnumber' => $cbcart_forwarded,
        );
        $cbcart_result = update_option('cbcart_inboxmessage', wp_json_encode($cbcart_update_arr));

        $cbcart_response=cbcart::cbcart_set_webhook_for_inbox();

        if($cbcart_response===200||$cbcart_response==="200"){
            $cbcart_success = '';
            $cbcart_success .= '<div class="notice notice-success is-dismissible text-capitalize">';
            $cbcart_success .= '<p>' . esc_html('Your incoming message setting is updated successfully.','cartbox-messaging-widgets') . '</p>';
            $cbcart_success .= '</div>';
            echo wp_kses_post($cbcart_success);
        }
        else{
            $cbcart_error_mobileno = '';
            $cbcart_error_mobileno .= '<div class="notice notice-error is-dismissible text-capitalize">';
            $cbcart_error_mobileno .= '<p>' . esc_html('Something went wrong! try again.','cartbox-messaging-widgets') . '</p>';
            $cbcart_error_mobileno .= '</div>';
            echo wp_kses_post($cbcart_error_mobileno);
        }
    }
 }
?>
<div class="container">
    <div>
        <img src="<?php echo esc_url( $cbcart_logo ); ?>" class="cbcart_imgclass">
    </div>
    <label class="cbcart-label3 text-capitalize m-0"><b><?php esc_html_e( 'Incoming Message','cartbox-messaging-widgets' ); ?></b>
    </label>
    <form method="post">
        <div class="d-flex justify-content-end">
        <div class="card cbcart_card p-5 w-75 mx-auto ">
            <div class="form-group mb-3">
                <label class="cbcart_sub_label text-capitalize"><?php esc_html_e('Email','cartbox-messaging-widgets')?></label>
                <input type="email" name="cbcart_email" placeholder="Enter Email" class="form-control cbcart_message w-75" value="<?php
                printf(
                    esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                    esc_html($cbcart_email_1)
                );
               ?>" />


            </div>
            <div class="form-group mb-3">
                <label class="cbcart_sub_label"><?php esc_html_e('Forward Number','cartbox-messaging-widgets')?></label>
                <input type="text" name="cbcart_forwardnumber" placeholder="Enter Mobile Number with country code. Do not prefix with a 0 or +" class="form-control cbcart_message w-75" value="<?php
                printf(
                    esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                    esc_html($cbcart_forwarded)
                );
              ?>" />
            </div>
            <div class="form-group mb-3">
                <label class="cbcart_sub_label"><?php esc_html_e('Webhook URL','cartbox-messaging-widgets')?></label>
                <div class="d-flex align-items-center ">
                <input type="text" name="cbcart_webhook" id="cbcart_webhook" value="https://gu2fhpvka7.execute-api.us-west-2.amazonaws.com/Prod" readonly class="form-control cbcart_message w-75" />
                    <button type="button" onclick="cbcart_copy()" class="border-0 bg-transparent cbcart-tooltip" onmouseout="cbcart_outFunc()"><span class="cbcart-tooltiptext" id="cbcart-Tooltip"><?php esc_html_e("Copy to clipboard",'cartbox-messaging-widgets'); ?></span><i class="fa fa-copy mx-2"></i></button>

                </div>
            </div>
            <div class="form-group text-center">
                <?php wp_nonce_field('cbcart_update_form2', 'cbcart_update_form2_nonce'); ?>

                <input type="submit" name="cbcart_submit" class="btn cbcart_btn-theme2" value="Save"/>
            </div>
        </div>
        <div class="w-25 mt-4">
            <div class="card cbcart_card cbcart_support_card">
                <img src="<?php echo esc_url($cbcart_logo2); ?>" class="cbcart_chatimg"></img>
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
                    <div class="mt-3"><i class="fa  fa-comment-o"></i><a href="<?php echo esc_url(cbcart_site); ?>"
                                                                         target="_blank"
                                                                         class="cbcart_supportlabel"><?php esc_html_e('Chat','cartbox-messaging-widgets'); ?></a><br>
                    </div>
                    <div class="mt-3 "><i class="fa  fa-whatsapp"></i><a
                                href="<?php echo esc_url(cbcart_whatsapp_link); ?>" target="_blank"
                                class="cbcart_supportlabel"><?php esc_html_e('WhatsApp','cartbox-messaging-widgets'); ?></a></div>
                    <div class="mt-3"><i class="fa  fa-envelope-o"></i><a href="mailto:hi@cartbox.net" target="_blank"
                                                                          class="cbcart_supportlabel"><?php esc_html_e('Email','cartbox-messaging-widgets'); ?></a><br>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>

    <div class="card cbcart_card w-75 cbcart-webhookBox mt-5 ">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="my-4"><?php esc_html_e('How to set webhook to receive incoming messages','cartbox-messaging-widgets')?></h2>
                        <img src="<?php echo esc_url(CBCART_URL) ?>/admin/images/cbcart-maxresdefault.jpg" class="img-fluid mb-3" />
                        <p class="mb-3"><?php esc_html_e('Incoming webhooks provide developers with the ability to post a message or a card to a specific chat via a dedicated URL. Incoming webhooks are special in that no authentication credentials are required to post a message via this URL. Incoming webhooks are therefore commonly used to integrate with third-party systems that need the ability to post content to a chat without a lot of overhead.','cartbox-messaging-widgets')?></p>
                        <p class="mb-3"> <?php esc_html_e('Video Tutorial on How to set webhook to receive incoming messages (Step by Step).','cartbox-messaging-widgets')?></p>
                        <h4 class="mb-3"><?php esc_html_e('Step 1:','cartbox-messaging-widgets')?></h4>
                        <p><?php esc_html_e('To access the template management page, click on ','cartbox-messaging-widgets')?><b><?php esc_html_e('“Configuration under the WhatsApp Tab“','cartbox-messaging-widgets')?></b>. <?php esc_html_e('After this, you will be landed up on this screen.','cartbox-messaging-widgets')?></p>
                        <img src="<?php echo esc_url(CBCART_URL) ?>/admin/images/cbcart-blog-1.1.jpg" class="img-fluid mb-3" />
                        <h4 class="mb-3"><?php esc_html_e('Step 2:','cartbox-messaging-widgets')?></h4>
                        <p><?php esc_html_e('Once you click on the ','cartbox-messaging-widgets')?><b><?php esc_html_e('“Configuration tab”','cartbox-messaging-widgets')?></b> <?php esc_html_e('this screen will appear. Now you can','cartbox-messaging-widgets')?> <b><?php esc_html_e('“Edit”','cartbox-messaging-widgets')?> </b> <?php esc_html_e('Webhook.','cartbox-messaging-widgets')?> </p>
                        <img src="<?php echo esc_url(CBCART_URL) ?>/admin/images/cbcart-blog-1-2.jpg" class="img-fluid mb-3" />
                        <h4 class="mb-3"><?php esc_html_e('Step 3:','cartbox-messaging-widgets')?> </h4>
                        <p><?php esc_html_e('Here You have to FIll ','cartbox-messaging-widgets')?> <b><?php esc_html_e('“Callback URL”','cartbox-messaging-widgets')?></b><?php esc_html_e(' and ','cartbox-messaging-widgets')?><b><?php esc_html_e('“Verify Token“','cartbox-messaging-widgets')?></b>. <?php esc_html_e('Now you have to click on ','cartbox-messaging-widgets')?><b><?php esc_html_e('Verify and save','cartbox-messaging-widgets')?></b> <?php esc_html_e('button.','cartbox-messaging-widgets')?></p>
                        <ul>
                            <li><?php esc_html_e('Callback URL:- ','cartbox-messaging-widgets')?><b><?php esc_html_e('https://gu2fhpvka7.execute-api.us-west-2.amazonaws.com/Prod','cartbox-messaging-widgets')?></b></li>
                            <li><?php esc_html_e('Verify Token:- ','cartbox-messaging-widgets')?><b><?php esc_html_e('webhook','cartbox-messaging-widgets')?></b></li>
                        </ul>
                        <img src="<?php echo esc_url(CBCART_URL) ?>/admin/images/cbcart-blog-1.3.jpg" class="img-fluid mb-3" />
                        <h4 class="mb-3"><?php esc_html_e('Step 4:','cartbox-messaging-widgets')?></h4>
                        <p> <?php esc_html_e('After the click on the save button. The callback URL and Verify Token will display.','cartbox-messaging-widgets')?></p>
                        <img src="<?php echo esc_url(CBCART_URL) ?>/admin/images/cbcart-Blog-1.4.jpg" class="img-fluid mb-3" />
                        <h4 class="mb-3"><?php esc_html_e('Step 5:','cartbox-messaging-widgets')?></h4>
                        <p><?php esc_html_e('Now You can go to the ','cartbox-messaging-widgets')?><b><?php esc_html_e('“Webhooks”','cartbox-messaging-widgets')?></b>.<?php esc_html_e('Tab and find the','cartbox-messaging-widgets')?> <b><?php esc_html_e('message’s','cartbox-messaging-widgets')?></b> <?php esc_html_e('name and tap on the ','cartbox-messaging-widgets')?><b><?php esc_html_e('“Subscribe”','cartbox-messaging-widgets')?></b><?php esc_html_e(' button.','cartbox-messaging-widgets')?></p>
                        <img src="<?php echo esc_url(CBCART_URL) ?>/admin/images/cbcart-blog-1.5.jpg" class="img-fluid mb-3" />
                        <h4 class="mb-3"><?php esc_html_e('Step 6:','cartbox-messaging-widgets')?></h4>
                        <p><?php esc_html_e('After the Tap on','cartbox-messaging-widgets')?> <b><?php esc_html_e('Subscribe button','cartbox-messaging-widgets')?></b>. <?php esc_html_e('the below message will show on your screen.','cartbox-messaging-widgets')?></p>
                        <img src="<?php echo esc_url(CBCART_URL) ?>/admin/images/cbcart-Blog-1.6.jpg" class="img-fluid mb-3" />
                        <p><?php esc_html_e('Now, You complete the set webhook to receive incoming messages.','cartbox-messaging-widgets')?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

