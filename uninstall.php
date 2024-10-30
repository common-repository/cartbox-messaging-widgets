<?php
/**
 * Fired when the plugin is uninstalled.
 *
 *
 * @link       https://www.cartbox.net/
 * @since      1.0.0
 *
 * @package    cartbox
 */
// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}
// remove plugin options
global $wpdb;
/*
 * @var $table_name
 * name of cbcart_table to be dropped
 * prefixed with $wpdb->prefix from the database
 */
$cbcart_table_name = $wpdb->prefix . 'cbcart_orderdetails';
$cbcart_table_name2 = $wpdb->prefix. 'cbcart_contactformdetails';
$cbcart_table_name3 = $wpdb->prefix. 'cbcart_abandoneddetails';
$cbcart_table_name4 = $wpdb->prefix. 'cbcart_template';

// drop the cbcart_table from the database.
$wpdb->get_results( $wpdb->prepare("DROP TABLE IF EXISTS $cbcart_table_name" )); // phpcs:ignore
$wpdb->get_results( $wpdb->prepare("DROP TABLE IF EXISTS $cbcart_table_name2" )); // phpcs:ignore
$wpdb->get_results( $wpdb->prepare("DROP TABLE IF EXISTS $cbcart_table_name3" )); // phpcs:ignore
$wpdb->get_results( $wpdb->prepare("DROP TABLE IF EXISTS $cbcart_table_name4" )); // phpcs:ignore


delete_option('cbcart_usersettings');
delete_option('cbcart_userplan');
delete_option('cbcart_ordernotificationsettings');
delete_option('cbcart_contactformsettings');
delete_option('cbcart_adminsettings');
delete_option('cbcart_abandonedsettings');
delete_option('cbcart_dndsettings');
delete_option('cbcart_createtemplates');
delete_option('cbcart_testmessagesetup');
delete_option('cbcart_test_cloudapi');
delete_option('cbcart_templatescreen');
delete_option('cbcart_success');
delete_option('cbcart_premiumsettings');
delete_option('cbcart_otp');
delete_option('cbcart_startup');
delete_option('cbcart_abandoned_1');
delete_option('cbcart_abandoned_2');
delete_option('cbcart_abandoned_3');
delete_option('cbcart_abandoned_4');
delete_option('cbcart_abandoned_5');
delete_option('cbcart_order_admin');
delete_option('cbcart_order_customer');
delete_option('cbcart_chat_setting');
delete_option('cbcart_compo_build');
delete_option('cbcart_inboxmessage');
delete_option('cbcart_popup_setting');
delete_option('cbcart_cf7_admin');
delete_option('cbcart_cf7_customer');
delete_option('cbcart_testing_cf7');






