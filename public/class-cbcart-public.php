<?php

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *  @link       https://www.cartbox.net/
 * @since      1.0.0
 * @package    cartbox
 * @subpackage cartbox/public
 * @author     cartbox <hi@cartbox.net>
 */
class cbcart_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @version 3.0.4
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @version 3.0.4
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;


	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @version 3.0.4
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}
    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     * @version 3.0.4
     */
    public function enqueue_styles() {
    wp_enqueue_style( $this->plugin_name, plugin_dir_url(__FILE__) . 'css/cbcart-public.css', array(), 'all' );
       // wp_enqueue_style( 'bootstrap-modal-css', CBCART_PLUGIN_BOOTSTRAP_FILE_STYLE, array() );
    }

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 * @version 3.0.4
	 */
	public function enqueue_scripts() {
        wp_enqueue_script( array( 'jquery') );
		wp_localize_script('cbcart-admin', 'cbcart_ajax_object', array( 'ajax_url' => admin_url('admin-ajax.php') ));
        //click to chat
        wp_enqueue_script( 'cbcart_admin_chat', plugin_dir_url(__FILE__) . 'js/cbcart-public-chat.js', array( 'jquery' ), false );
        $cbcart_data = get_option('cbcart_chat_setting');
        $cbcart_data                  = json_decode($cbcart_data);
        $cbcart_data           = sanitize_option(  "cbcart_chat_setting",$cbcart_data );
        // Add PHP plugin variables to the $params[] array to pass to jQuery
        $cbcart_data_array = array (
            'cbcart_widget_text' => $cbcart_data->cbcart_widget_text,
        'cbcart_predefine_text'=> $cbcart_data->cbcart_predefine_text,
        'cbcart_tooltiptext' => $cbcart_data->cbcart_tooltiptext,
        'cbcart_widget_type' => $cbcart_data->cbcart_widget_type,
        'cbcart_widget_position' => $cbcart_data->cbcart_widget_position,
        'cbcart_icon_type' => $cbcart_data->cbcart_icon_type, 'cbcart_icon' => CBCART_DIR . CBCART_DOMAIN . '/admin/images/'.$cbcart_data->cbcart_icon,
        'cbcart_icon_url' => $cbcart_data->cbcart_icon_url,
        'cbcart_ispublish' => $cbcart_data->cbcart_ispublish,
        'cbcart_is_ac_1'=>$cbcart_data->cbcart_is_ac_1,
        'cbcart_is_ac_2'=>$cbcart_data->cbcart_is_ac_2,
        'cbcart_is_ac_3'=>$cbcart_data->cbcart_is_ac_3,
        'cbcart_chat_account1_name'=>$cbcart_data->cbcart_chat_account1_name,
        'cbcart_chat_account2_name'=>$cbcart_data->cbcart_chat_account2_name,
        'cbcart_chat_account3_name'=>$cbcart_data->cbcart_chat_account3_name,
        'cbcart_chat_account1_role'=>$cbcart_data->cbcart_chat_account1_role,
        'cbcart_chat_account2_role'=>$cbcart_data->cbcart_chat_account2_role,
        'cbcart_chat_account3_role'=>$cbcart_data->cbcart_chat_account3_role,
        'cbcart_chat_account1_number'=>$cbcart_data->cbcart_chat_account1_number,
        'cbcart_chat_account2_number'=>$cbcart_data->cbcart_chat_account2_number,
        'cbcart_chat_account3_number'=>$cbcart_data->cbcart_chat_account3_number,
        'cbcart_chat_account1_avtar_url'=>$cbcart_data->cbcart_chat_account1_avtar_url,
        'cbcart_chat_account2_avtar_url'=>$cbcart_data->cbcart_chat_account2_avtar_url,
        'cbcart_chat_account3_avtar_url'=>$cbcart_data->cbcart_chat_account3_avtar_url,
            'cbcart_profile_img_url'=> CBCART_DIR . CBCART_DOMAIN . '/admin/images/cbcart-profile2.png',
        );
        // Pass PHP variables to jQuery script
        wp_localize_script( 'cbcart_admin_chat', 'cbcart_chat_object', $cbcart_data_array );

        $cbcart_data = get_option('cbcart_popup_setting');
        if ($cbcart_data) {
            //for early capture
            $cbcart_check_mobile_number = $this->cbcart_check_mobile_number();
            if ($cbcart_check_mobile_number == "false") {

                wp_enqueue_script('cbcart_popup', plugin_dir_url(__FILE__) . 'js/cbcart-public-earlycapture.js', array('jquery'), true);

                $cbcart_data = get_option('cbcart_popup_setting');
                $cbcart_data = json_decode($cbcart_data);
                $cbcart_data = sanitize_option("cbcart_popup_setting", $cbcart_data);
                $cbcart_update_arr = array(
                    'cbcart_enable_popup' => $cbcart_data->cbcart_enable_popup,
                    'cbcart_modalheading_text' => $cbcart_data->cbcart_modalheading_text,
                    'cbcart_modalheading_color' => $cbcart_data->cbcart_modalheading_color,
                    'cbcart_modal_text' => $cbcart_data->cbcart_modal_text,
                    'cbcart_modal_text_color' => $cbcart_data->cbcart_modal_text_color,
                    'cbcart_modal_placeholder' => $cbcart_data->cbcart_modal_placeholder,
                    'cbcart_button_text' => $cbcart_data->cbcart_button_text,
                    'cbcart_button_text_color' => $cbcart_data->cbcart_button_text_color,
                    'cbcart_button_color' => $cbcart_data->cbcart_button_color,
                    'cbcart_consent_text' => $cbcart_data->cbcart_consent_text,
                    'ajax_url' => admin_url('admin-ajax.php'),
                );
                // Pass PHP variables to jQuery script
                wp_localize_script('cbcart_popup', 'cbcart_popup_object', $cbcart_update_arr);
            }
        }
    }
	/**
	 * add session key into session table
	 *
	 * @since     1.0.0
	 * @version 3.0.4
	 */
	public function cbcart_add_session_key() {
		global $wpdb;
		global $woocommerce;
		if (!WC()->cart) { //Exit if Woocommerce cart has not been initialized
			return false;
		}
		$cbcart_current_time = current_time('mysql', false); //Retrieving current time
		WC()->session->set('cbcart_cart_last_access_timestamp', $cbcart_current_time); //Storing session_id in WooCommerce session

        $cbcart_customer_id = WC()->session->get_customer_id();
		$cbcart_cart_table = $wpdb->prefix . 'cbcart_abandoneddetails';
		$cbcart_get_sql = $wpdb->prepare("SELECT COUNT(cbcart_id) FROM $cbcart_cart_table WHERE cbcart_customer_id = %s AND cbcart_status IN (0,1)", $cbcart_customer_id);
		$cbcart_result_count = $wpdb->get_var($cbcart_get_sql);

		if ($cbcart_result_count > 0) {
			$wpdb->update($cbcart_cart_table, array('cbcart_last_access_time' => $cbcart_current_time), array('cbcart_customer_id' => $cbcart_customer_id, 'cbcart_status' => 1));
		}
	}

	/**
	 * Function to add js file to check out form
	 *
	 * @since     1.0.0
	 * @version 3.0.4
	 */
	public function cbcart_enqueue_checkout_script() {
		$plugin_data = get_file_data(CBCART_PLUGIN_BOOTSTRAP_FILE, array('version'));
		$plugin_version = isset($plugin_data[0]) ? $plugin_data[0] : false;
		wp_enqueue_script('cbcart-public-abandoned-js', plugin_dir_url( __FILE__ ) . '/js/cbcart-public-cart.js', array( 'jquery' ), $this->version, true );
		wp_localize_script('cbcart-public-abandoned-js', 'cbcart_public_data', array('ajax_url' => admin_url('admin-ajax.php'), 'nonce' => wp_create_nonce('cbcart-ajax-nonce')));
	}

	/**
	 * save abandoned cart data
	 *
	 * @since     1.0.0
	 * @version 3.0.4
	 *
	 */
	public function cbcart_abandoned_save() {

		// Check for nonce security
		if (isset($_POST) && isset($_POST['nonce'])) {
			if (!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'cbcart-ajax-nonce')) {
				wp_die('Busted!');
			}
		}
		if (isset($_POST) && isset($_POST['action']) && $_POST['action'] == 'cbcart_abandoned_save') {

			if (!WC()->cart) { // Exit if Woocommerce cart has not been initialized
				return false;
			}
			$cbcart_abandoned_email = '';
			$cbcart_abandoned_name = '';
			$cbcart_abandoned_surname = '';
			$cbcart_abandoned_phone = '';
			$cbcart_abandoned_country = '';

			// get customer data from field
			if (isset($_POST['cbcart_abandoned_name'])) {
				$cbcart_abandoned_name = sanitize_text_field(wp_unslash($_POST['cbcart_abandoned_name']));
			}
			if (isset($_POST['cbcart_abandoned_surname'])) {
				$cbcart_abandoned_surname = sanitize_text_field(wp_unslash($_POST['cbcart_abandoned_surname']));
			}
			if (isset($_POST['cbcart_abandoned_phone'])) {
				$cbcart_abandoned_phone = sanitize_text_field(wp_unslash($_POST['cbcart_abandoned_phone']));
			}
			if (isset($_POST['cbcart_abandoned_email'])) {
				$cbcart_abandoned_email = sanitize_text_field(wp_unslash($_POST['cbcart_abandoned_email']));
			}
			if (isset($_POST['cbcart_abandoned_country'])) {
				$cbcart_abandoned_country = sanitize_text_field(wp_unslash($_POST['cbcart_abandoned_country']));
			}
			if (!empty($cbcart_abandoned_name)) {
				WC()->session->set('cbcart_first_name', $cbcart_abandoned_name);
			}
			if (!empty($cbcart_abandoned_surname)) {
				WC()->session->set('cbcart_last_name', $cbcart_abandoned_surname);
			}
			if (!empty($cbcart_abandoned_phone)) {
				WC()->session->set('cbcart_customer_phone', $cbcart_abandoned_phone);
			}
			if (!empty($cbcart_abandoned_email)) {
				WC()->session->set('cbcart_customer_email', $cbcart_abandoned_email);
			}
			if (!empty($cbcart_abandoned_country)) {
				WC()->session->set('cbcart_customer_country', $cbcart_abandoned_country);
			}
		}
		wp_die();
	}

    /**
     * save early mobile data
     *
     * @since     2.0.0
     * @version 3.0.4
     *
     */
    public function cbcart_early_modal_data(){
        $cbcart_modal_mobileno="";
        if (isset($_POST['cbcart_number'])) {
            $cbcart_modal_mobileno = sanitize_text_field(wp_unslash($_POST['cbcart_number']));
        }
        WC()->session->set('cbcart_customer_phone', $cbcart_modal_mobileno);
        $cbcart_update_arr = array(
            'cbcart_modal_mobileno' => $cbcart_modal_mobileno,
        );
        $cbcart_result = update_option('cbcart_popup_testing', wp_json_encode($cbcart_update_arr));
    }


    /**
     * Function to check mobile number exist in session
     *
     * @since     2.0.0
     * @version 3.0.4
     */
    public function cbcart_check_mobile_number() {
        global $wpdb;
        // to get product title
        $cbcart_table1                    = $wpdb->prefix . "posts";
        $cbcart_woocommerce_session_table = $wpdb->prefix . 'woocommerce_sessions';
        $cbcart_customer_mobile_no="";

        $cbcart_get_all_sessions = $wpdb->get_results( "SELECT * FROM $cbcart_woocommerce_session_table" );
        foreach ( $cbcart_get_all_sessions as $cbcart_row ) {
            $cbcart_session_id = $cbcart_row->session_key;
            $cbcart_session_content = unserialize($cbcart_row->session_value);
            $cbcart_customer = unserialize($cbcart_session_content['customer']);

            if (is_array($cbcart_customer) and isset($cbcart_customer['phone'])) {
                $cbcart_customer_mobile_no = $cbcart_customer['phone'];
            }

            // If nothing found check for billing fields

            if (empty($cbcart_customer_mobile_no)) {
                if (isset($cbcart_session_content['billing_phone'])) {
                    $cbcart_customer_mobile_no = $cbcart_session_content['billing_phone'];
                }
            }
            // If nothing found check for billing fields

            if (empty($cbcart_customer_mobile_no)) {
                if (isset($cbcart_session_content['shipping_phone'])) {
                    $cbcart_customer_mobile_no = $cbcart_session_content['billing_phone'];
                }
            }

            // If nothing found check for cartbox fields
            if (empty($cbcart_customer_mobile_no)) {
                if (isset($cbcart_session_content['cbcart_customer_phone'])) {
                    $cbcart_customer_mobile_no = $cbcart_session_content['cbcart_customer_phone'];
                }
            }
            if (empty($cbcart_customer_mobile_no)) {
                return "false";
            }else{
                return "true";
            }

        }

    }
    /**
     * Function to populate mobile number in checkout page
     *
     * @since     2.0.0
     * @version 3.0.4
     */
    public function populate_phone_field( $cbcart_fields ) {

        $cbcart_custom_field = WC()->session->get( 'cbcart_customer_phone' );
        WC()->session->set('billing_phone', $cbcart_custom_field); //Storing mobile number in WooCommerce session
        WC()->session->save_data();
        if ( $cbcart_custom_field ) {
            $cbcart_fields['billing']['billing_phone']['default'] = $cbcart_custom_field;
        }
        return $cbcart_fields;
    }

    function cbcart_updatefooteradmin ( $default ) {
		global $pagenow;
        $setting_pages = array(
            "cbcart_dashboard", "cbcart_ordernotification", "cbcart_messages_cf","cbcart_admin_settings_display","cbcart_abandoned_Cart","cbcart_tutorial","cbcart_clicktochat","cbcart_incoming_message", "cbcart_early_capture"
        );
        $post_type = filter_input(INPUT_GET, 'post_type', FILTER_SANITIZE_STRING);
        $post_type = isset($post_type) ? sanitize_text_field($post_type) : '';
		if ( ! $post_type ) {
            $post_id = filter_input(INPUT_GET, 'post', FILTER_SANITIZE_NUMBER_INT);
            $post_type = get_post_type($post_id);
		}
        $cbcart_url= esc_url("https://www.cartbox.net/");
;		if ( 'admin.php' === $pagenow && isset( $_GET['page'] ) && in_array( sanitize_text_field($_GET['page']), $setting_pages )) {
            echo ' ' . esc_attr( 'by' ) . ' <a href="' . esc_url($cbcart_url) . '" target="_blank">Cartbox</a>' . esc_attr(CBCART_VERSION);

        }
	}


}




