<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$cbacrt_iswoo="";
if ( class_exists( 'WooCommerce' ) ) {
    $cbacrt_iswoo="true";
}else{
    $cbacrt_iswoo="false";
    $cbcart_flag = 0;
    $cbcart_error = '';
    $cbcart_error .= '<div class="notice notice-error is-dismissible">';
    $cbcart_error .= '<p>' . esc_html('WooCommerce is required for this plugin.','cartbox-messaging-widgets') . '</p>';
    $cbcart_error .= '</div>';
    echo wp_kses_post($cbcart_error);
}
?>
<!DOCTYPE html>
<html lang="en">
    <div class="pr-5 container">
        <div class="row">
            <div class="col-auto">
                <?php $cbcart_logo         = CBCART_DIR . CBCART_DOMAIN . esc_url('/admin/images/cbcart-LogoNew-black2.png');
                 ?>
                <img src="<?php echo esc_url( $cbcart_logo ); ?>" class="cbcart_imgclass cbcart_img_icon" alt="<?php esc_html( 'logo','cartbox-messaging-widgets' ); ?>">
            </div>
            <div class="col p-0">
                <h5 class="head-title my-3"><?php esc_html_e( 'Cartbox Widgets','cartbox-messaging-widgets' ); ?></h5>
            </div>
        </div>
        <?php
        if($cbacrt_iswoo==="false"){?>
            <div class="">
                <div class="py-3 px-5 text-danger"><h4><label class=" fa fa-warning"></label>
                        <?php esc_html_e(" WooCommerce is required for this plugin.",'cartbox-messaging-widgets') ?>
                        <a href="<?php echo esc_url( get_site_url() ); ?>/wp-admin/plugin-install.php?s=woocomerce&tab=search&type=term"><?php esc_html_e( 'Install Plugin Now','cartbox-messaging-widgets' ); ?></a>
                    </h4>
                </div>
            </div>
            <?php
        }
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card cbcart_card w-100">
                    <div class="row card-body cbcart_card-body">
                        <h5 class="cbcart_dashboardmsg ">
                            <b><?php esc_html_e( 'Are you facing any issue in setup?','cartbox-messaging-widgets' ); ?> </b>
                        </h5>
                        <h6><a href="<?php echo esc_url( cbcart_site); ?>" target="_blank"><?php esc_html_e( 'Click here','cartbox-messaging-widgets' ) ?></a>
                            <?php esc_html_e( '  for online chat support or Email us at ','cartbox-messaging-widgets' ) ?>
                            <a href="mailto: hi@cartbox.net" target="_blank"><?php esc_html_e( 'hi@cartbox.net','cartbox-messaging-widgets' ) ?></a>.
                            <?php esc_html_e( 'You can also WhatsApp us on','cartbox-messaging-widgets' ) ?>
                            <a href="<?php echo esc_url(cbcart_whatsapp_link); ?>" target="_blank">
                                <?php esc_html_e( '919106393472.','cartbox-messaging-widgets' ) ?>
                            </a>
                        </h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-3 g-4">

                <div class="col">
                    <div class="card h-100 cbcart_card">
                        <div class="row">
                            <div class="col">
                                <h2 class="card-title cbcart_card-title"><?php esc_html_e( 'Order Notification','cartbox-messaging-widgets' ); ?></h2>
                            </div>
                            <div class="col-auto">
                                <div class="cbcart_card_icon">
                                    <i class="fa fa-bell-o"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0">
                            <p class="cbcart_card-text2 mb-0"><?php esc_html_e( 'Admin and customer gets a WhatsApp message for every successful order.','cartbox-messaging-widgets' ); ?></p>
                        </div>
                        <div class="card-footer bg-transparent border-0 p-0">
                            <a href="admin.php?page=cbcart_ordernotification" class="cbcart_settings stretched-link">
                                    <?php esc_html_e( 'Manage','cartbox-messaging-widgets' ) ?>&nbsp;<i class="fa fa-chevron-circle-right"></i>
                            </a>
                        </div>
                        <div class="card-footer bg-transparent border-0 p-0">
                            <small class="text-muted">
                                <?php esc_html_e('Note : This widget requires free WhatsApp Cloud API setup.')?>
                            </small>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100 cbcart_card">
                        <div class="row">
                            <div class="col">
                                <h2 class="card-title cbcart_card-title"><?php esc_html_e( 'Abandoned Cart','cartbox-messaging-widgets' ); ?></h2>
                            </div>
                            <div class="col-auto">
                                <div class="cbcart_card_icon">
                                    <i class="fa fa-shopping-cart"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0">
                            <p class="cbcart_card-text2 mb-0"><?php esc_html_e( 'Recover failed orders in real cash by sending multiple WhatsApp messages.','cartbox-messaging-widgets' ); ?></p>
                        </div>
                        <div class="card-footer bg-transparent border-0 p-0">
                            <a href="admin.php?page=cbcart_abandoned_Cart" class="cbcart_settings stretched-link">
                                    <?php esc_html_e( 'Manage','cartbox-messaging-widgets' ) ?>&nbsp;<i class="fa fa-chevron-circle-right"></i>
                            </a>
                        </div>
                        <div class="card-footer bg-transparent border-0 p-0">
                            <small class="text-muted">
                                <?php esc_html_e('Note : This widget requires free WhatsApp Cloud API setup.')?>
                            </small>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100 cbcart_card">
                        <div class="row">
                            <div class="col">
                                <h2 class="cbcart_card-title text-capitalize"><?php esc_html_e( 'Message notification for contact form 7','cartbox-messaging-widgets' ); ?></h2>
                            </div>
                            <div class="col-auto">
                                <div class="cbcart_card_icon">
                                    <i class="fa fa-commenting-o"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0">
                            <p class="cbcart_card-text2 mb-0"><?php esc_html_e( 'Admin can receive a message notification for every inquiry made for Contact Form 7.','cartbox-messaging-widgets' ); ?></p>
                        </div>
                        <div class="card-footer bg-transparent border-0 p-0">
                            <a href="admin.php?page=cbcart_messages_cf" class="cbcart_settings stretched-link">
                                    <?php esc_html_e( 'Manage','cartbox-messaging-widgets' ) ?>&nbsp;<i class="fa fa-chevron-circle-right"></i>
                            </a>
                        </div>
                        <div class="card-footer bg-transparent border-0 p-0">
                            <small class="text-muted">
                                <?php esc_html_e('Note : This widget requires free WhatsApp Cloud API setup.')?>
                            </small>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card h-100 cbcart_card">
                        <div class="row">
                            <div class="col">
                                <h2 class="cbcart_card-title text-capitalize"><?php esc_html_e( 'Incoming Messages for Web-admin','cartbox-messaging-widgets' ); ?></h2>
                            </div>
                            <div class="col-auto">
                                <div class="cbcart_card_icon">
                                <i class="fa fa-arrow-down"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0">
                            <p class="cbcart_card-text2 mb-0"><?php esc_html_e( 'Website owner can receive an incoming message on forwarded number.','cartbox-messaging-widgets' ); ?></p>
                        </div>
                        <div class="card-footer bg-transparent border-0 p-0">
                            <a href="admin.php?page=cbcart_incoming_message" class="cbcart_settings stretched-link">
                                <?php esc_html_e( 'Manage','cartbox-messaging-widgets' ) ?>&nbsp;<i class="fa fa-chevron-circle-right"></i>
                            </a>
                        </div>
                        <div class="card-footer bg-transparent border-0 p-0">
                            <small class="text-muted ">
                                <?php esc_html_e('Note : This widget requires free WhatsApp Cloud API setup.')?>
                            </small>
                        </div>
                    </div>
                </div>
            <div class="col">
                <div class="card h-100 cbcart_card">
                    <div class="row">
                        <div class="col">
                            <h2 class="cbcart_card-title text-capitalize"><?php esc_html_e( 'click to chat','cartbox-messaging-widgets' ); ?></h2>
                        </div>
                        <div class="col-auto">
                            <div class="cbcart_card_icon">
                                <i class="fa fa-comments-o"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0">
                        <p class="cbcart_card-text2 mb-0"><?php esc_html_e( 'Click to chat feature allows you to begin a WhatsApp chat with visitors on your website.','cartbox-messaging-widgets' ); ?></p>
                    </div>
                    <div class="card-footer bg-transparent border-0 p-0">
                        <a href="admin.php?page=cbcart_clicktochat" class="cbcart_settings stretched-link"><?php esc_html_e( 'Manage','cartbox-messaging-widgets' ) ?> <i class="fa fa-chevron-circle-right"></i></a>
                    </div>
                    <div class="card-footer bg-transparent border-0 p-0">
                        <small class="text-muted"></small>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card h-100 cbcart_card">
                    <div class="row">
                        <div class="col">
                            <h2 class="card-title cbcart_card-title"><?php esc_html_e( 'Mobile Capture','cartbox-messaging-widgets' ); ?></h2>
                        </div>
                        <div class="col-auto">
                            <div class="cbcart_card_icon">
                                <i class="fa fa-window-maximize"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0">
                        <p class="cbcart_card-text2 mb-0"><?php esc_html_e( 'Display a popup to capture mobile number when user clicks add to cart','cartbox-messaging-widgets' ); ?></p>
                    </div>
                    <div class="card-footer bg-transparent border-0 p-0">
                        <a href="admin.php?page=cbcart_early_capture" class="cbcart_settings stretched-link">
                            <?php esc_html_e( 'Manage','cartbox-messaging-widgets' ) ?>&nbsp;<i class="fa fa-chevron-circle-right"></i>
                        </a>
                    </div>
                    <div class="card-footer bg-transparent border-0 p-0">
                        <small class="text-muted">
                        </small>
                    </div>
                </div>
            </div>
            </div>
    </div>
</html>