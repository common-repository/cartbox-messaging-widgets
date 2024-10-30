<?php
/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    cartbox
 * @subpackage cartbox/includes
 * @author     cartbox <hi@cartbox.net>
 */
if ( ! class_exists('cbcart_Activator') ) {
	class cbcart_Activator {

		/**
		 * Fired during plugin activation.
		 *
		 * Create Tables and options while activating plugin.
		 *
		 * @since    1.0.0
		 */
		public static function activate() {
			global $wpdb;
			$table_prefix           = $wpdb->prefix;
            $cbcart_table           = 'cbcart_orderdetails';
			$cbcart_order_table     = $table_prefix . "$cbcart_table";
			$cbcart_charset_collate = $wpdb->get_charset_collate();
			$cbcart_db_result1      = $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $cbcart_order_table ) );
			if ( strtolower( $cbcart_db_result1 ) !== strtolower( $cbcart_order_table ) ) {
				$cbcart_tbl1 = "CREATE TABLE $cbcart_order_table (
				`cbcart_id`              		BIGINT(20) NOT NULL auto_increment,
				`cbcart_user_type`       		VARCHAR(50) NULL DEFAULT NULL,
				`cbcart_create_date_time`  	DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
				`cbcart_message_api_request`	LONGTEXT NULL DEFAULT NULL,
				`cbcart_message_api_response`  LONGTEXT NULL DEFAULT NULL,
				PRIMARY KEY (`cbcart_id`)
				)$cbcart_charset_collate;";

                $wpdb->query($wpdb->prepare($cbcart_tbl1));
			}

            $cbcart_table1            = 'cbcart_contactformdetails';
			$cbcart_message_cf7_table = $table_prefix . "$cbcart_table1";
			$cbcart_charset_collate   = $wpdb->get_charset_collate();
			$cbcart_db_result1        = $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $cbcart_message_cf7_table ) );
			if ( strtolower( $cbcart_db_result1 ) !== strtolower( $cbcart_message_cf7_table ) ) {
				$cbcart_tbl3 = "CREATE TABLE $cbcart_message_cf7_table (
				`cbcart_id`              		BIGINT(20) NOT NULL auto_increment,
				`cbcart_user_type`       		VARCHAR(50) NULL DEFAULT NULL,
				`cbcart_create_date_time`  	DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
				`cbcart_message_api_request`	LONGTEXT NULL DEFAULT NULL,
				`cbcart_message_api_response`  LONGTEXT NULL DEFAULT NULL,
				PRIMARY KEY (`cbcart_id`)
				)$cbcart_charset_collate;";

                $wpdb->query($wpdb->prepare($cbcart_tbl3));
			}


			$cbcart_table2              = 'cbcart_abandoneddetails';
			$cbcart_abandonedcart_table = $table_prefix . "$cbcart_table2";
			$cbcart_charset_collate     = $wpdb->get_charset_collate();
			$cbcart_db_result1          = $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $cbcart_abandonedcart_table ) );
			if ( strtolower( $cbcart_db_result1 ) !== strtolower( $cbcart_abandonedcart_table ) ) {
				$cbcart_tbl = "CREATE TABLE $cbcart_abandonedcart_table (
			`cbcart_id`                  BIGINT(20) NOT NULL auto_increment,
			`cbcart_customer_id`         VARCHAR(100) NULL DEFAULT NULL,
			`cbcart_customer_email`      VARCHAR(100) NULL DEFAULT NULL,
			`cbcart_customer_mobile_no`  VARCHAR(100) NULL DEFAULT NULL,
			`cbcart_customer_first_name` VARCHAR(100) NULL DEFAULT NULL,
			`cbcart_customer_last_name`  VARCHAR(100) NULL DEFAULT NULL,
			`cbcart_customer_type`       VARCHAR(50) NULL DEFAULT NULL,
			`cbcart_create_date_time`    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
			`cbcart_cart_json`           LONGTEXT NULL DEFAULT NULL,
			`cbcart_cart_total_json`     LONGTEXT NULL DEFAULT NULL,
			`cbcart_cart_total`          FLOAT NOT NULL,
			`cbcart_cart_currency`       VARCHAR(50) NOT NULL,
			`cbcart_abandoned_date_time` DATETIME NOT NULL default '0000-00-00 00:00:00',
			`cbcart_message_sent`        INT NOT NULL DEFAULT '0',
			`cbcart_status`              INT NOT NULL DEFAULT '0',
			`cbcart_last_access_time`    DATETIME NOT NULL default '0000-00-00 00:00:00',
			`cbcart_message_api_request`	LONGTEXT NULL DEFAULT NULL,
			`cbcart_message_api_response` LONGTEXT NULL DEFAULT NULL,
			PRIMARY KEY (`cbcart_id`)
			)$cbcart_charset_collate;";

                $wpdb->query($wpdb->prepare($cbcart_tbl));
			}

            $cbcart_table_name           = 'cbcart_template';
            $cbcart_template_table  = $table_prefix . "$cbcart_table_name";
            $cbcart_charset_collate = $wpdb->get_charset_collate();
            $cbcart_db_result1      = $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $cbcart_template_table ) );
            if ( strtolower( $cbcart_db_result1 ) !== strtolower( $cbcart_template_table ) ) {
                $cbcart_tbl1 = "CREATE TABLE $cbcart_template_table (
				`cbcart_id`               BIGINT(20) NOT NULL auto_increment,
				`cbcart_template_id`  	  VARCHAR(50) NULL DEFAULT NULL,
				`cbcart_template_name`    VARCHAR(50) NULL DEFAULT NULL,
				`cbcart_template_language`LONGTEXT NULL DEFAULT NULL,
				`cbcart_template_status`  LONGTEXT NULL DEFAULT NULL,
				`cbcart_template_category`  LONGTEXT NULL DEFAULT NULL,
				`cbcart_template_components`  LONGTEXT NULL DEFAULT NULL,
				PRIMARY KEY (`cbcart_id`)
				)$cbcart_charset_collate;";

                $wpdb->query($wpdb->prepare($cbcart_tbl1));
            }

            $cbcart_data = get_option('cbcart_ordernotificationsettings');
            if ($cbcart_data) {
                //do nothing
            }else{
                $cbcart_update_notifications_arr = array(
                    'cbcart_is_order_completed' => "0",
                    'cbcart_is_order_processing' => "1",
                    'cbcart_is_order_payment_done' => "0",
                );
                $cbcart_result3 = update_option('cbcart_ordernotificationsettings', wp_json_encode($cbcart_update_notifications_arr));
            }

            if(cbcart_iscc==="true") {
                // get user plan from credentials
                $cbcart_update_user_settings = array(
                    'cbcart_isOrderNotificationToAdmin' => "true",
                    'cbcart_isCustomizeMessageToAdmin' => "true",
                    'cbcart_isOrderNotificationToCustomer' => "true",
                    'cbcart_isCustomizMessageToCustomer' => "true",
                    'cbcart_isCustomizMessageOfAbandoned' => "true",
                    'cbcart_multiple_messages' => '5',
                    'cbcart_isMessageFromAdminNumber' => "true",
                    'cbcart_official_number' => '9016243183',
                    'cbcart_isDisplayReport' => "true",
                    'cbcart_planid' => '4'
                );
                $cbcart_result = update_option('cbcart_usersettings', wp_json_encode($cbcart_update_user_settings));
            }

            $cbcart_update_arr = array(
                'cbcart_widget_text' => "Hi ! How Can I Help You",
                'cbcart_predefine_text'=>"Hi!",
                'cbcart_tooltiptext' => "Chat With Us",
                'cbcart_widget_type' => "onlyicon",
                'cbcart_widget_position' => "right",
                'cbcart_icon_type' => "cbcart_default",
                'cbcart_icon' => "cbcart-icon-1",
                'cbcart_icon_url' => "",
                'cbcart_ispublish' => "0",
                'cbcart_is_ac_1'=>"",
                'cbcart_is_ac_2'=>"",
                'cbcart_is_ac_3'=>"",
                'cbcart_chat_account1_name'=>"",
                'cbcart_chat_account2_name'=>"",
                'cbcart_chat_account3_name'=>"",
                'cbcart_chat_account1_role'=>"",
                'cbcart_chat_account2_role'=>"",
                'cbcart_chat_account3_role'=>"",
                'cbcart_chat_account1_number'=>"",
                'cbcart_chat_account2_number'=>"",
                'cbcart_chat_account3_number'=>"",
                'cbcart_chat_account1_avtar_url'=>"",
                'cbcart_chat_account2_avtar_url'=>"",
                'cbcart_chat_account3_avtar_url'=>"",
            );
            $cbcart_result = update_option('cbcart_chat_setting', wp_json_encode($cbcart_update_arr));

            $cbcart_abandonedcart_table_field = $wpdb->get_row("SELECT * FROM $cbcart_abandonedcart_table");
            //Add column if not present.
            if(!isset($cbcart_abandonedcart_table_field->cbcart_message_api_request)){
               $cbcart_update= $wpdb->query("ALTER TABLE $cbcart_abandonedcart_table ADD cbcart_message_api_request LONGTEXT NULL DEFAULT NULL AFTER `cbcart_last_access_time`");
            }else{
                //do nothing
            }
        }
	}
}