<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$cbcart_logo = cbcart_logonew_black;
$cbcart_data = get_option('cbcart_popup_setting');
$cbcart_data = json_decode($cbcart_data);
$cbcart_data = sanitize_option("cbcart_popup_setting", $cbcart_data);
if ($cbcart_data != "") {
    $cbcart_enable_popup = $cbcart_data->cbcart_enable_popup;
    $cbcart_modalheading_text = $cbcart_data->cbcart_modalheading_text;
    $cbcart_modalheading_color = $cbcart_data->cbcart_modalheading_color;
    $cbcart_modal_text = $cbcart_data->cbcart_modal_text;
    $cbcart_modal_text_color = $cbcart_data->cbcart_modal_text_color;
    $cbcart_modal_placeholder = $cbcart_data->cbcart_modal_placeholder;
    $cbcart_button_text = $cbcart_data->cbcart_button_text;
    $cbcart_button_text_color = $cbcart_data->cbcart_button_text_color;
    $cbcart_button_color = $cbcart_data->cbcart_button_color;
    $cbcart_consent_text = $cbcart_data->cbcart_consent_text;
} else {
    $cbcart_enable_popup = "1";
    $cbcart_modalheading_text = "Enter WhatsApp Mobile Number";
    $cbcart_modalheading_color = "#3939ac";
    $cbcart_modal_text = "We will save cart to make it easy for you to checkout.";
    $cbcart_modal_text_color = "#6666ff";
    $cbcart_modal_placeholder = "Enter your mobile number with country code";
    $cbcart_button_text = "Add to Cart";
    $cbcart_button_text_color = "#ffffff";
    $cbcart_button_color = "#f29b26";
    $cbcart_consent_text = "I allow the website to contact me on WhatsApp for order messages.";
}
if (isset($_POST['cbcart_chat_aacount_submit']) ? sanitize_text_field(wp_unslash($_POST['cbcart_chat_aacount_submit'])) : '') {
    $cbcart_legit = true;
    if (!isset($_POST['cbcart_setup_nonce'])) {
        $cbcart_legit = false;
    }
    $cbcart_nonce = isset($_POST['cbcart_setup_nonce']) ? sanitize_text_field(wp_unslash($_POST['cbcart_setup_nonce'])) : '';
    if (!wp_verify_nonce($cbcart_nonce, 'cbcart_setup')) {
        $cbcart_legit = false;
    }
    if (!$cbcart_legit) {
        wp_safe_redirect(add_query_arg());
        exit();
    }

    if (isset($_POST['cbcart_is_ac_1']) ? sanitize_text_field(wp_unslash($_POST['cbcart_is_ac_1'])) : '') {
        $cbcart_enable_popup = '1';
    } else {
        $cbcart_enable_popup = '0';
    }
    $cbcart_flag = 1;
    if ($cbcart_enable_popup === '1') {

        $cbcart_modalheading_text = isset($_POST['cbcart_capture_modalheading']) ? sanitize_text_field(wp_unslash($_POST['cbcart_capture_modalheading'])) : '';
        $cbcart_modalheading_color = isset($_POST['cbcart_modal_headingcolor']) ? sanitize_text_field(wp_unslash($_POST['cbcart_modal_headingcolor'])) : '';
        $cbcart_modal_text = isset($_POST['cbcart_capture_modal_text']) ? sanitize_text_field(wp_unslash($_POST['cbcart_capture_modal_text'])) : '';
        $cbcart_modal_text_color = isset($_POST['cbcart_modal_text_color']) ? sanitize_text_field(wp_unslash($_POST['cbcart_modal_text_color'])) : '';
        $cbcart_modal_placeholder = isset($_POST['cbcart_capture_placeholder']) ? sanitize_text_field(wp_unslash($_POST['cbcart_capture_placeholder'])) : '';
        $cbcart_button_text = isset($_POST['cbcart_capture_addtocart_text']) ? sanitize_text_field(wp_unslash($_POST['cbcart_capture_addtocart_text'])) : '';
        $cbcart_button_text_color = isset($_POST['cbcart_buttontext_color']) ? sanitize_text_field(wp_unslash($_POST['cbcart_buttontext_color'])) : '';
        $cbcart_button_color = isset($_POST['cbcart_button_color']) ? sanitize_text_field(wp_unslash($_POST['cbcart_button_color'])) : '';
        $cbcart_consent_text = isset($_POST['cbcart_consent_text']) ? sanitize_text_field(wp_unslash($_POST['cbcart_consent_text'])) : '';

        if (empty($cbcart_modalheading_text)) {
            $cbcart_flag = 0;
            $cbcart_error_modalheading_text = '';
            $cbcart_error_modalheading_text .= '<div class="notice notice-error is-dismissible">';
            $cbcart_error_modalheading_text .= '<p>' . esc_html('Please Enter Modal Heading.','cartbox-messaging-widgets') . '</p>';
            $cbcart_error_modalheading_text .= '</div>';
            echo wp_kses_post($cbcart_error_modalheading_text);
        }
        if (empty($cbcart_modal_text)) {
            $cbcart_flag = 0;
            $cbcart_error_modal_text = '';
            $cbcart_error_modal_text .= '<div class="notice notice-error is-dismissible">';
            $cbcart_error_modal_text .= '<p>' . esc_html('Please Enter Modal Text.','cartbox-messaging-widgets') . '</p>';
            $cbcart_error_modal_text .= '</div>';
            echo wp_kses_post($cbcart_error_modal_text);
        }
        if (empty($cbcart_modal_placeholder)) {
            $cbcart_flag = 0;
            $cbcart_error_modal_placeholder = '';
            $cbcart_error_modal_placeholder .= '<div class="notice notice-error is-dismissible">';
            $cbcart_error_modal_placeholder .= '<p>' . esc_html('Please Enter Placeholder.','cartbox-messaging-widgets') . '</p>';
            $cbcart_error_modal_placeholder .= '</div>';
            echo wp_kses_post($cbcart_error_modal_placeholder);
        }
        if (empty($cbcart_button_text)) {
            $cbcart_flag = 0;
            $cbcart_error_button_text = '';
            $cbcart_error_button_text .= '<div class="notice notice-error is-dismissible">';
            $cbcart_error_button_text .= '<p>' . esc_html('Please Enter Button Text.','cartbox-messaging-widgets') . '</p>';
            $cbcart_error_button_text .= '</div>';
            echo wp_kses_post($cbcart_error_button_text);
        }
        if (empty($cbcart_consent_text)) {
            $cbcart_flag = 0;
            $cbcart_error_consent_text = '';
            $cbcart_error_consent_text .= '<div class="notice notice-error is-dismissible">';
            $cbcart_error_consent_text .= '<p>' . esc_html('Please Enter Placeholder.','cartbox-messaging-widgets') . '</p>';
            $cbcart_error_consent_text .= '</div>';
            echo wp_kses_post($cbcart_error_consent_text);
        }
        if ($cbcart_flag === 1) {
            $cbcart_update_arr = array(
                'cbcart_enable_popup' => $cbcart_enable_popup,
                'cbcart_modalheading_text' => $cbcart_modalheading_text,
                'cbcart_modalheading_color' => $cbcart_modalheading_color,
                'cbcart_modal_text' => $cbcart_modal_text,
                'cbcart_modal_text_color' => $cbcart_modal_text_color,
                'cbcart_modal_placeholder' => $cbcart_modal_placeholder,
                'cbcart_button_text' => $cbcart_button_text,
                'cbcart_button_text_color' => $cbcart_button_text_color,
                'cbcart_button_color' => $cbcart_button_color,
                'cbcart_consent_text' => $cbcart_consent_text,
            );
            $cbcart_result = update_option('cbcart_popup_setting', wp_json_encode($cbcart_update_arr));
            $cbcart_success = '';
            $cbcart_success .= '<div class="notice notice-success is-dismissible">';
            $cbcart_success .= '<p>' . esc_html('Details update successfully.','cartbox-messaging-widgets') . '</p>';
            $cbcart_success .= '</div>';
            echo wp_kses_post($cbcart_success);
        }
    } else {
        if ($cbcart_flag === 1) {
            $cbcart_update_arr = array(
                'cbcart_enable_popup' => $cbcart_enable_popup,
                'cbcart_modalheading_text' => $cbcart_modalheading_text,
                'cbcart_modalheading_color' => $cbcart_modalheading_color,
                'cbcart_modal_text' => $cbcart_modal_text,
                'cbcart_modal_text_color' => $cbcart_modal_text_color,
                'cbcart_modal_placeholder' => $cbcart_modal_placeholder,
                'cbcart_button_text' => $cbcart_button_text,
                'cbcart_button_text_color' => $cbcart_button_text_color,
                'cbcart_button_color' => $cbcart_button_color,
                'cbcart_consent_text' => $cbcart_consent_text,
            );
            $cbcart_result = update_option('cbcart_popup_setting', wp_json_encode($cbcart_update_arr));
            $cbcart_success = '';
            $cbcart_success .= '<div class="notice notice-success is-dismissible">';
            $cbcart_success .= '<p>' . esc_html('Details update successfully.','cartbox-messaging-widgets') . '</p>';
            $cbcart_success .= '</div>';
            echo wp_kses_post($cbcart_success);
        }
    }
}
?>

<div class="container">
    <div>
        <img src="<?php echo esc_url($cbcart_logo); ?>" class="cbcart_imgclass" alt="<?php esc_attr('logo','cartbox-messaging-widgets'); ?>">
    </div>
    <label class="text-capitalize cbcart-label3">
        <b><?php esc_html_e('Cartbox Mobile Capture','cartbox-messaging-widgets'); ?></b>
    </label>
</div>

<div class="container d-flex">
    <div class="w-50 cbcart_settings_card mx-0">
        <div class="container">
            <div class="tabbable boxed parentTabs m-2">
                <div id="cbcart_setting_tabs" class="cbcart_nav cbcart_nav_settings">
                    <ul class="nav nav-tabs cbcart_nav_tabs">
                        <li><label class="active cbcart_nav_text"><?php esc_html_e('Popup Settings','cartbox-messaging-widgets'); ?></label>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="tabbable boxed parentTabs m-2">
            <div class="tab-content">
                <div class="tab-pane fade active in show" id="cbcart_set1">
                    <form name="cbcart_form_1" method="post">
                        <div class="card cbcart_card w-100">
                            <div class="d-flex align-items-center justify-content-between">
                                <label class="cbcart_sub_label my-3"> <?php esc_html_e('Enable Add to Cart Popup modal','cartbox-messaging-widgets'); ?></label>
                                <?php if ($cbcart_enable_popup == '1') { ?>
                                    <label class="cbcart_switch">
                                        <input type="checkbox" checked id="cbcart_is_ac_1" name="cbcart_is_ac_1"/>
                                        <span class="cbcart_slider cbcart_round"></span>
                                    </label>
                                <?php } else { ?>
                                    <label class="cbcart_switch">
                                        <input type="checkbox" id="cbcart_is_ac_1" name="cbcart_is_ac_1"/>
                                        <span class="cbcart_slider cbcart_round"></span>
                                    </label>
                                <?php } ?>
                            </div>
                            <hr class="my-1">
                            <div id="cbcart_display_ac_1" class="d-none form-group">
                                <div class="mb-3">
                                    <div class="row mt-2 justify-content-between align-items-center">
                                        <div class="col-4">
                                            <label class="text-capitalize cbcart-label3">
                                                <?php esc_html_e('Modal Heading:') ?>
                                            </label>
                                        </div>
                                        <div class="col-8 d-flex">
                                            <input type="text" name="cbcart_capture_modalheading" class="form-control mx-1" id="cbcart_capture_modalheading" value="<?php

                                            printf(
                                                esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                                esc_html($cbcart_modalheading_text)
                                            );
                                             ?>">

                                            <input type="color" class="form-control form-control-color" name="cbcart_modal_headingcolor" id="cbcart_modal_headingcolor" value="<?php
                                            printf(
                                                esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                                esc_html($cbcart_modalheading_color)
                                            );
                                             ?>">
                                        </div>
                                    </div>
                                    <div class="row mt-2 justify-content-between align-items-center">
                                        <div class="col-4">
                                            <label class="text-capitalize cbcart-label3"><?php esc_html_e('Modal Text:','cartbox-messaging-widgets'); ?></label>
                                        </div>
                                        <div class="col-8 d-flex">
                                            <input type="text" name="cbcart_capture_modal_text" id="cbcart_capture_modal_text" value="<?php
                                            printf(
                                                esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                                esc_html($cbcart_modal_text)
                                            );
                                           ?>" id="" autocomplete="off" maxlength="200" class="form-control mx-1"/>

                                            <input type="color" class="form-control form-control-color" name="cbcart_modal_text_color" id="cbcart_modal_modal_text_color" value="<?php
                                            printf(
                                                esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                                esc_html($cbcart_modal_text_color)
                                            );
                                            ?>">
                                        </div>
                                    </div>
                                    <div class="row mt-2 justify-content-between align-items-center">
                                        <div class="col-4">
                                            <label class="text-capitalize cbcart-label3 m-0"><?php esc_html_e('Mobile number Placeholder:','cartbox-messaging-widgets'); ?>
                                            </label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" name="cbcart_capture_placeholder" id="cbcart_capture_placeholder" value="<?php
                                            printf(
                                                esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                                esc_html($cbcart_modal_placeholder)
                                            );
                                             ?>" class="form-control mx-1"/>
                                        </div>
                                    </div>
                                    <div class="row mt-2 justify-content-between align-items-center">
                                        <div class="col-4">
                                            <label class="text-capitalize cbcart-label3 p-0 m-0">
                                                <?php esc_html_e("Customer consent Text :",'cartbox-messaging-widgets') ?>
                                            </label>
                                        </div>
                                        <div class="col-8 d-flex">
                                            <input type="text" name="cbcart_consent_text" class=" form-control mx-1" id="cbcart_consent_text" value="<?php esc_html_e($cbcart_consent_text) ?>">
                                        </div>
                                    </div>
                                    <div class="row mt-2 justify-content-between align-items-center">
                                        <div class="col-4">
                                            <label class="text-capitalize cbcart-label3 m-0"><?php esc_attr_e('Add to cart button text','cartbox-messaging-widgets'); ?>
                                            </label>
                                        </div>
                                        <div class="col-8 d-flex">
                                            <input type="text" name="cbcart_capture_addtocart_text" id="cbcart_capture_addtocart_text" value="<?php
                                            printf(
                                                esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                                esc_html($cbcart_button_text)
                                            );
                                             ?>" class="form-control mx-1"/>
                                        </div>
                                    </div>
                                    <div class="row justify-content-between align-items-center py-2">
                                        <div class="col-4">
                                            <label class="text-capitalize cbcart-label3"><?php esc_attr_e('Add to cart button:','cartbox-messaging-widgets'); ?>
                                            </label>
                                        </div>
                                        <div class="col-4">
                                            <label for="cbcart_buttontext_color ">&nbsp;<?php esc_html_e('Button Text Color','cartbox-messaging-widgets') ?></label>
                                            &nbsp;
                                            <input type="color" class="form-control form-control-color mx-1" name="cbcart_buttontext_color" id="cbcart_buttontext_color" value="<?php
                                            printf(
                                                esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                                esc_html($cbcart_button_text_color)
                                            );
                                           ?>"/>
                                        </div>
                                        <div class="col-4">
                                            <label for="cbcart_button_color"><?php esc_html_e('Button Color','cartbox-messaging-widgets') ?></label>
                                            <input type="color" class="form-control form-control-color" name="cbcart_button_color" id="cbcart_button_color" value="<?php
                                            printf(
                                                esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                                esc_html($cbcart_button_color)
                                            );
                                            ?>"/>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-12 text-center">
                                    <?php wp_nonce_field('cbcart_setup', 'cbcart_setup_nonce'); ?>
                                    <input type="submit" name="cbcart_chat_aacount_submit" value="Save" class="btn cbcart_btn-theme mt-0">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="w-50 cbcart_settings_card ">
        <div class="container">
            <div class="tabbable boxed parentTabs m-2">
                <div id="cbcart_setting_tabs" class="cbcart_nav cbcart_nav_settings">
                    <ul class="nav nav-tabs cbcart_nav_tabs">
                        <li><label class="active cbcart_nav_text"><?php esc_html_e('Popup Preview ','cartbox-messaging-widgets'); ?></label>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card cbcart_card cbcart_modal_preview">
            <div class="row">
                <div class="modal-header border-bottom-0">
                    <button type="button" class="btn close cbcart-modal-close-icon">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="row">
                    <div class="col-2 cbcart_icon_img_space">
                        <span class="cbcart-modal-heading-icon">&#128722;</span>
                    </div>
                    <div class="col">
                        <p class="cbcart_modalheading" id="cbcart_modal_heading"><?php
                            printf(
                                esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                esc_html($cbcart_modalheading_text)
                            );
                             ?></p>
                        <p class="cbcart_modal_text" id="cbcart_modal_text"><?php
                            printf(
                                esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                esc_html($cbcart_modal_text)
                            );
                            ?></p>
                    </div>
                </div>
                <div class="modal-body px-3 py-2">
                    <label class="text-danger fs-6 d-none" id="cbcart_error"></label>
                    <input type="" class="form-control cbcart_phnno_input " name="cbcart_modal_mobileno" id="cbcart_modal_mobileno" placeholder="<?php
                    printf(
                        esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                        esc_html($cbcart_modal_placeholder)
                    );
                     ?>" autocomplete="off" maxlength="200" class="cbcart_message form-control "/>
                    <div class="d-flex mt-1">
                        <input class="mt-1" type="checkbox" id="cbcart_modal_checkbox">
                        <p class="cbcart_modal_text" for="cbcart_modal_checkbox" id="cbcart_modal_checkbox_text" ><?php
                            printf(
                                esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                esc_html($cbcart_consent_text)
                            );
                            ?></p>
                    </div>
                    <button type="submit" name="cbcart_modal_submit" id="cbcart_modal_button" class="btn w-100 mt-3 fw-bolder"><?php
                        printf(
                            esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                            esc_html($cbcart_button_text)
                        );
                         ?></button>
                </div>
            </div>
        </div>
    </div>
</div>

