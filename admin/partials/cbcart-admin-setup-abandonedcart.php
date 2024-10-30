<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $wpdb;
$cbcart_table             = $wpdb->prefix . "posts";
$cbcart_table1            = $wpdb->prefix . "wc_order_stats";
$cbcart_order_id          = $wpdb->get_results( " SELECT ID FROM " . $cbcart_table . " WHERE post_status IN ('wc-processing', 'wc-completed') " ); // db call ok; no-cache ok
$cbcart_order_id          = json_decode( json_encode( $cbcart_order_id ), true );
$cbcart_order_suc_amount  = $wpdb->get_results( " SELECT SUM(net_total) FROM " . $cbcart_table1 . " WHERE status IN ('wc-processing', 'wc-completed') AND date_created > now() - INTERVAL 45 day " ); // db call ok; no-cache ok
$cbcart_order_suc_amount1 = json_decode( json_encode( $cbcart_order_suc_amount ), true );
$cbcart_array             = json_decode( json_encode( $cbcart_order_suc_amount1 ), true );
foreach ( $cbcart_array as $cbcart_arr2 ) {
	foreach ( $cbcart_arr2 as $cbcart_aid => $cbcart_order_suc_amt ) {
		$cbcart_order_suc_amt;
		if ( $cbcart_order_suc_amt == "" ) {
			$cbcart_order_suc_amt = 0;
		}
	}
}

$cbcart_order_failed_amount  = $wpdb->get_results( " SELECT SUM(net_total) FROM " . $wpdb->prefix . "wc_order_stats WHERE status = 'wc-on-hold' AND date_created > current_date - INTERVAL 45 day" ); // db call ok; no-cache ok
$cbcart_order_failed_amount1 = json_decode( json_encode( $cbcart_order_failed_amount ), true );
$cbcart_array                = json_decode( json_encode( $cbcart_order_failed_amount1 ), true );
foreach ( $cbcart_array as $cbcart_arr2 ) {
	foreach ( $cbcart_arr2 as $cbcart_aid => $cbcart_order_failed_amt ) {
		$cbcart_order_failed_amt;
		if ( $cbcart_order_failed_amt == "" ) {
			$cbcart_order_failed_amt = 0;
		}
	}
}

$cbcart_order_failed1_amount  = $wpdb->get_results( " SELECT SUM(net_total) FROM " . $wpdb->prefix . "wc_order_stats WHERE status = 'wc-failed' AND date_created > current_date - INTERVAL 45 day " ); // db call ok; no-cache ok
$cbcart_order_failed1_amount1 = json_decode( json_encode( $cbcart_order_failed1_amount ), true );
$cbcart_array                 = json_decode( json_encode( $cbcart_order_failed1_amount1 ), true );
foreach ( $cbcart_array as $cbcart_arr2 ) {
	foreach ( $cbcart_arr2 as $cbcart_aid => $cbcart_order_failed1_amt ) {
		$cbcart_order_failed1_amt;
		if ( $cbcart_order_failed1_amt == "" ) {
			$cbcart_order_failed1_amt = 0;
		}
	}
}

$cbcart_total_failed_amt = $cbcart_order_failed_amt + $cbcart_order_failed1_amt;
$cbcart_order_success    = $wpdb->get_results( " SELECT COUNT(*) FROM " . $wpdb->prefix . "posts WHERE post_status IN ('wc-processing', 'wc-completed') AND post_date > current_date - INTERVAL 45 day  " ) ; // db call ok; no-cache ok
$cbcart_array            = json_decode( json_encode( $cbcart_order_success ), true );
foreach ( $cbcart_array as $cbcart_arr2 ) {
	foreach ( $cbcart_arr2 as $cbcart_aid => $cbcart_order_suc ) {
		$cbcart_order_suc;
	}
}

$cbcart_order_cancelled = $wpdb->get_results(  " SELECT COUNT(*) FROM  " . $wpdb->prefix . "posts WHERE post_status = 'wc-on-hold' AND post_date > current_date - INTERVAL 45 day" ) ; // db call ok; no-cache ok
$cbcart_array1          = json_decode( json_encode( $cbcart_order_cancelled ), true );
foreach ( $cbcart_array1 as $cbcart_arr2 ) {
	foreach ( $cbcart_arr2 as $cbcart_aid => $cbcart_order_can ) {
		$cbcart_order_can;
	}
}

$cbcart_order_failed = $wpdb->get_results( " SELECT COUNT(*) FROM  " . $wpdb->prefix . "posts WHERE post_status = 'wc-failed' AND post_date > current_date - INTERVAL 45 day" ); // db call ok; no-cache ok
$cbcart_array2       = json_decode( json_encode( $cbcart_order_failed ), true );
foreach ( $cbcart_array2 as $cbcart_arr2 ) {
	foreach ( $cbcart_arr2 as $cbcart_aid => $cbcart_order_fail ) {
		$cbcart_order_fail;
	}
}
$cbcart_total_failed = $cbcart_order_can + $cbcart_order_fail;
$cbcart_logo         = cbcart_logonew_black;
$cbcart_vector       = CBCART_DIR . CBCART_DOMAIN . esc_url( '/admin/images/cbcart-VectorArrow.png' );
?>
<div class="container position-relative">
    <div class="text-center">
        <h1><img src="<?php echo esc_url( $cbcart_logo ); ?>" height="100" class="cbcart_imgclass" alt="<?php esc_attr( 'logo','cartbox-messaging-widgets' ) ?>"></h1>
        <h2 class="mb-0 cbcart-head-title"><?php esc_html_e( 'Abandoned Cart Recovery','cartbox-messaging-widgets' ); ?></h2>
        <p class="cbcart_lbl"><?php esc_html_e( 'Cartbox Abandoned Cart is the easiest way to recover all your Orders!','cartbox-messaging-widgets' ); ?></p>
        <?php if ( class_exists( 'WooCommerce' ) ) { ?>
        <div class="mt-4">
            <p class="cbcart_subtitle"><?php esc_html_e( 'A Summary of last ','cartbox-messaging-widgets' ); ?><strong class="text-black"><?php esc_html_e( '45 days','cartbox-messaging-widgets' ); ?></strong><?php esc_html_e( ' Orders','cartbox-messaging-widgets' ); ?>
            </p>
        </div>
        <div class="row justify-content-center">
            <div class="col-4 text-center">
                <div class="card cbcart_card px-3">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                                <p class="card-text cbcart_card-text text-success"><?php
                                    printf(
                                        esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                        esc_html($cbcart_order_suc)
                                    );
                                   ?></p>
                                <label class="cbcart_lbl"><?php esc_html_e( 'Successfull Orders','cartbox-messaging-widgets' ); ?></label>
                            </div>
                            <div class="cbcart_vl"></div>
                            <div class="col">
                                <p class="card-text cbcart_card-text text-success"><?php
                                    printf(
                                        esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                        esc_html($cbcart_order_suc_amt)
                                    );
                                     ?></p>
                                <label class="cbcart_lbl"><?php esc_html_e( 'Amount','cartbox-messaging-widgets' ); ?></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4 text-center">
                <div class="card cbcart_card px-3">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                                <p class="card-text1 cbcart_card-text text-danger"><?php
                                    printf(
                                        esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                        esc_html($cbcart_total_failed)
                                    );
                                  ?></p>
                                <label class="cbcart_lbl"><?php esc_html_e( 'Failed Orders','cartbox-messaging-widgets' ); ?></label>
                            </div>
                            <div class="cbcart_vl"></div>
                            <div class="col">
                                <p class="card-text1 cbcart_card-text1 text-danger"><?php
                                    printf(
                                        esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                                        esc_html($cbcart_total_failed_amt)
                                    );
                                    ?></p>
                                <label class="cbcart_lbl"><?php esc_html_e( 'Amount to recover','cartbox-messaging-widgets' ); ?></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6 offset-4">
                <img src="<?php echo esc_url( $cbcart_vector ,'cartbox-messaging-widgets'); ?>" class="cbcart_imgRow" alt="<?php esc_attr( 'vector','cartbox-messaging-widgets' ) ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-4 offset-7">
                <p class="row-content m-0 mb-2 text-center">
                    <?php esc_html_e( 'We can help you to','cartbox-messaging-widgets' ); ?>
                    <br/> <?php esc_html_e( 'recover this.','cartbox-messaging-widgets' ); ?>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-4 offset-7">
                <p class="row-content m-0 mb-2 text-center">
                    <a href="admin.php?page=cbcart_admin_settings_display" onclick="FormValidation()" class="btn cbcart_btn-theme"> <?php esc_html_e( 'Lets Get Started!','cartbox-messaging-widgets' ); ?></a>
                </p>
            </div>
        </div>
	    <?php } else { ?>
            <div class="cbcart_rowCol">
                <div>
                    <h1 class="cbcart_alt-heading"><?php esc_html_e( 'WooCommerce is required','cartbox-messaging-widgets' ); ?>
                        <br><?php esc_html_e( ' for our abandoned cart plugin!','cartbox-messaging-widgets' ); ?></h1>
                </div>
                <div>
                    <a href="<?php echo esc_url( get_site_url() ); ?>/wp-admin/plugin-install.php?s=woocomerce&tab=search&type=term" class="btn cbcart_btn-theme"><?php esc_html_e( 'Install Plugin','cartbox-messaging-widgets' ); ?></a>
                </div>
            </div>
	    <?php } ?>
    </div>
</div>