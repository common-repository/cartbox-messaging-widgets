<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @version    3.0.4
 * @package    cartbox
 * @subpackage cartbox/includes
 * @author     CartBox <hi@cartbox.net>
 */
if ( ! class_exists('cbcart') ) {
    class cbcart {

        /**
         * The loader that's responsible for maintaining and registering all hooks that power
         * the plugin.
         *
         * @since    1.0.0
         * @version     3.0.4
         * @access   protected
         * @var      cbcart_Loader $loader Maintains and registers all hooks for the plugin.
         */
        protected $loader;

        /**
         * The unique identifier of this plugin.
         *
         * @since    1.0.0
         * @version    3.0.4
         * @access   protected
         * @var      string $plugin_name The string used to uniquely identify this plugin.
         */
        protected $plugin_name;

        /**
         * The current version of the plugin.
         *
         * @since    1.0.0
         * @access   protected
         * @version    3.0.4
         * @var string $version The current version of the plugin.
         */
        protected $version;

        /**
         * Define the core functionality of the plugin.
         *
         * Set the plugin name and the plugin version that can be used throughout the plugin.
         * Load the dependencies, define the locale, and set the hooks for the admin area side of the site.
         *
         * @since    1.0.0
         * @version 3.0.4
         */
        public function __construct() {
            if ( defined( 'CBCART_VERSION' ) ) {
                $this->version = CBCART_VERSION;
            } else {
                $this->version = '3.0.4';
            }
            $this->plugin_name = 'cartbox';
            $this->load_dependencies();
            $this->set_locale();
            $this->define_admin_hooks();
            $this->define_public_hooks();
        }

        /**
         * Load the required dependencies for this plugin.
         *
         * Include the following files that make up the plugin:
         *
         * - cbcart_Loader. Orchestrates the hooks of the plugin.
         * - cbcart_i18n. Defines internationalization functionality.
         * - cbcart_Admin. Defines all hooks for the admin area.
         *
         * Create an instance of the loader which will be used to register the hooks
         * with WordPress.
         *
         * @since    1.0.0
         * @version 3.0.4
         * @access   private
         */
        private function load_dependencies() {

            /**
             * The class responsible for orchestrating the actions and filters of the
             * core plugin.
             */
            require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-cbcart-loader.php';

            /**
             * The class responsible for defining internationalization functionality
             * of the plugin.
             */
            require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-cbcart-i18n.php';

            /**
             * The class responsible for defining all actions that occur in the admin area.
             */
            require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-cbcart-admin.php';
            /**
             * The class responsible for defining all actions that occur in the public-facing
             * side of the site.
             */
            require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-cbcart-public.php';
            $this->loader = new cbcart_Loader();
        }

        /**
         * Define the locale for this plugin for internationalization.
         *
         * Uses the cbcart_i18n class in order to set the domain and to register the hook
         * with WordPress.
         *
         * @since    1.0.0
         * @version    3.0.4
         * @access   private
         */
        private function set_locale() {
            $plugin_i18n = new cbcart_i18n();
            $this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
        }

        /**
         * Register all the hooks related to the admin area functionality
         * of the plugin.
         *
         * @since    1.0.0
         * @version    3.0.4
         * @access   private
         */
        private function define_admin_hooks() {
            if (!empty(get_option('cbcart_ordernotificationsettings'))) {
                $cbcart_data1 = get_option('cbcart_ordernotificationsettings');
                $cbcart_data1 = json_decode($cbcart_data1);
                $cbcart_data1 = sanitize_option(  "cbcart_ordernotificationsettings",$cbcart_data1 );
                if (empty($cbcart_data1)) {
                    $cbcart_is_order_completed = "";
                    $cbcart_is_order_processing = "";
                    $cbcart_is_order_payment_done = "";
                } else {
                $cbcart_is_order_completed = $cbcart_data1->cbcart_is_order_completed;
                $cbcart_is_order_processing = $cbcart_data1->cbcart_is_order_processing;
                $cbcart_is_order_payment_done = $cbcart_data1->cbcart_is_order_payment_done;
                }
            }
            else{
                $cbcart_is_order_completed = "";
                $cbcart_is_order_processing = "";
                $cbcart_is_order_payment_done = "";
            }
            $plugin_admin = new cbcart_Admin( $this->get_plugin_name(), $this->get_version() );

            add_action( 'init', array( $this, 'cbcart_schedulers' ) );
            add_action( 'admin_head', array( $this, 'cbcart_schedulers' ) );
            add_action( 'cron_schedules', array( $this, 'cbcart_cron_intervals' ) );
            add_action( 'cbcart_send_hook', array( $this, 'cbcart_move_sessions_to_cbcart_abandoned_table' ) );
            add_action( 'cbcart_send_hook', array( $this, 'cbcart_update_get_templates' ) );
            $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
            $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
            //woocommerce_order_processed
            if($cbcart_is_order_processing==="1") {
                add_action('woocommerce_checkout_order_processed', array($this, 'cbcart_order_processed'), 99, 4);
                add_action('woocommerce_checkout_order_processed', array($this, 'cbcart_recover_order'), 999, 4);
            }
            //woocommerce_payment_completed
            if($cbcart_is_order_payment_done==="1") {
                add_action('woocommerce_payment_complete', array($this, 'cbcart_payment_complete'));
                add_action('woocommerce_payment_complete', array($this, 'cbcart_recover_order'));
            }
            //woocommerce_order_status_completed
            if($cbcart_is_order_completed==="1") {
                add_action('woocommerce_order_status_completed', array($this, 'cbcart_payment_complete'));
                add_action('woocommerce_order_status_completed', array($this, 'cbcart_recover_order'));
            }
            $this->loader->add_action( 'admin_menu', $plugin_admin, 'cbcart_plugin_menu' );
            $this->loader->add_action( 'cbcart_user_credentials', $plugin_admin, 'cbcart_get_user_credentials' );
            $this->loader->add_action( 'cbcart_user_plan', $plugin_admin, 'cbcart_get_user_plan' );
            $this->loader->add_action( 'cbcart_user_settings_plugin', $plugin_admin, 'cbcart_update_user_settings_plugin' );
            $this->loader->add_action( 'cbcart_check_officalnumber', $plugin_admin, 'cbcart_checkfromnumber' );
        }

        /**
         * Register all of the hooks related to the public-facing functionality
         * of the plugin.
         *
         * @since    1.0.0
         * @access   private
         */
        private function define_public_hooks() {
            $plugin_public = new cbcart_Public( $this->get_plugin_name(), $this->get_version() );
            $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
            $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
            $this->loader->add_action( 'woocommerce_add_to_cart ', $plugin_public, 'cbcart_add_session_key' );
            add_action( 'woocommerce_add_to_cart', array( $plugin_public, 'cbcart_add_session_key' ), 10, 5 );
            $this->loader->add_action( 'woocommerce_after_add_to_cart_button ', $plugin_public, 'cbcart_add_session_key',10,5 );
            add_action( 'woocommerce_after_add_to_cart_button', array( $plugin_public, 'cbcart_add_session_key' ), 10, 5 );
            $this->loader->add_action( 'woocommerce_before_checkout_form ', $plugin_public, 'cbcart_add_session_key',10,5 );
            add_action( 'woocommerce_before_checkout_form', array( $plugin_public, 'cbcart_add_session_key' ), 10, 5 );
            $this->loader->add_action( 'woocommerce_order_status_failed ', $plugin_public, 'cbcart_add_session_key',10,5 );
            add_action( 'woocommerce_order_status_failed', array( $plugin_public, 'cbcart_add_session_key' ), 10, 5 );
            $this->loader->add_action( 'woocommerce_cart_actions', $plugin_public, 'cbcart_add_session_key' );
            $this->loader->add_action( 'woocommerce_cart_item_removed', $plugin_public, 'cbcart_add_session_key' );
            $this->loader->add_action( 'woocommerce_before_checkout_form', $plugin_public, 'cbcart_enqueue_checkout_script' );
            $this->loader->add_action( 'wp_ajax_nopriv_cbcart_abandoned_save', $plugin_public, 'cbcart_abandoned_save' );
            $this->loader->add_action( 'wp_ajax_cbcart_abandoned_save', $plugin_public, 'cbcart_abandoned_save' );

            //to save modal data
            $this->loader->add_action( 'wp_ajax_nopriv_cbcart_early_modal_data', $plugin_public, 'cbcart_early_modal_data' );
            $this->loader->add_action( 'wp_ajax_cbcart_early_modal_data', $plugin_public, 'cbcart_early_modal_data' );
            $this->loader->add_action('admin_footer_text', $plugin_public,'cbcart_updatefooteradmin');
            $this->loader-> add_action('woocommerce_checkout_fields',$plugin_public,'populate_phone_field');
        }

        /**
         * Run the loader to execute all the hooks with WordPress.
         *
         * @since    1.0.0
         * @version    3.0.4
         */
        public function run() {
            $this->loader->run();
        }

        /**
         * The name of the plugin used to uniquely identify it within the context of
         * WordPress and to define internationalization functionality.
         *
         * @return    string    The name of the plugin.
         * @version    3.0.4
         * @since     1.0.0
         */
        public function get_plugin_name() {
            return $this->plugin_name;
        }

        /**
         * The reference to the class that orchestrates the hooks with the plugin.
         *
         * @return    cbcart_Loader    Orchestrates the hooks of the plugin.
         * @version    3.0.4
         * @since     1.0.0
         */
        public function get_loader() {
            return $this->loader;
        }

        /**
         * Retrieve the version number of the plugin.
         *
         * @return    string    The version number of the plugin.
         * @version    3.0.4
         * @since     1.0.0
         */
        public function get_version() {
            return $this->version;
        }

        /**
         * move template data to cartbox get templates table
         *
         * @since     1.0.0
         * @version 3.0.4
         */
        public function cbcart_update_get_templates() {
            try {
                $cbcart_type = 'mysql';
                $cbcart_gmt  = false;
                if ( 'mysql' === $cbcart_type ) {
                    $cbcart_type = 'H:i:s';
                }
                $cbcart_timezone     = $cbcart_gmt ? new DateTimeZone( 'UTC' ) : wp_timezone();
                $cbcart_datetime     = new DateTime( 'now', $cbcart_timezone );
                $cbcart_current_time = $cbcart_datetime->format( $cbcart_type );
                $cbcart_begin = '00:00';
                $cbcart_end='00:30';

                if ($cbcart_current_time >= $cbcart_begin  && $cbcart_current_time <= $cbcart_end ) {
                    $cbcart = new cbcart();
                    $cbcart_get_template = $cbcart::cbcart_get_templates();
                } else {
                    return false;
                }

            } catch ( Exception $exception ) {
                //we are not adding any log files now.
            }
        }

        /**
         * Check the user data from of the plugin.
         *
         * @param Email_ID
         * @version   3.0.4
         * @since     1.0.0
         * @param     $cbcart_template_name ,$cbcart_template_lang
         * @return    array   The template type.
         */
        public static function cbcart_get_template_type( $cbcart_template_name ,$cbcart_template_lang) {
            try{
            global $wpdb;
            $table_prefix = $wpdb->prefix;
            $cbcart_table_name = 'cbcart_template';
            $cbcart_template_table = $table_prefix . "$cbcart_table_name";
            $cbcart_temp_data = $wpdb->prepare("SELECT cbcart_template_components FROM $cbcart_template_table WHERE cbcart_template_name= %s AND cbcart_template_language= %s ", $cbcart_template_name,$cbcart_template_lang); //db call ok; no-cache ok
            $cbcart_template_status = $wpdb->get_var($cbcart_temp_data);
            $cbcart_response_obj = unserialize($cbcart_template_status);
            $cbcart_response_obj = json_decode(json_encode($cbcart_response_obj), true);
            if($cbcart_response_obj === ""){
                return "invalid template";
            }
            $cbcart_is_header_image="";
            $cbcart_is_header_text="";
            $cbcart_is_text="";
            $cbcart_is_footer="";
            $cbcart_is_button="";
            $cbcart_is_header_video="";
            $cbcart_is_header_doc="";
            $cbcart_body_text="";
            $cbcart_is_header="";
            $cbcart_is_button_with_url="";

            foreach ($cbcart_response_obj as $cbcart_arr2) {
                $cbcart_template_type = $cbcart_arr2['type'];

                if ($cbcart_template_type === "HEADER") {
                    $cbcart_is_header = "true";
                    $cbcart_format_type = $cbcart_arr2['format'];

                    if ($cbcart_format_type === "IMAGE") {
                        $cbcart_is_header_image = "true";

                    } else {
                        $cbcart_is_header_image = "false";
                    }
                    if ($cbcart_format_type === "TEXT") {
                        $cbcart_is_header_text = "true";
                    } else {
                        $cbcart_is_header_text = "false";
                    }
                    if ($cbcart_format_type === "VIDEO") {
                        $cbcart_is_header_video = "true";
                    } else {
                        $cbcart_is_header_video = "false";
                    }
                    if ($cbcart_format_type === "DOCUMENT") {
                        $cbcart_is_header_doc = "true";
                    } else {
                        $cbcart_is_header_doc = "false";
                    }
                }

                if ($cbcart_template_type === "BODY") {
                    $cbcart_format_type = $cbcart_arr2['text'];
                    if(isset($cbcart_format_type)){
                        $cbcart_is_text = "true";
                        $cbcart_body_text =$cbcart_format_type;
                    } else {
                    $cbcart_is_text = "false";
                    }
                }

                if ($cbcart_template_type === "FOOTER") {
                    $cbcart_format_type = $cbcart_arr2['text'];
                    if (isset($cbcart_format_type)) {
                        $cbcart_is_footer = "true";
                    } else {
                        $cbcart_is_footer = "false";
                    }
                } else {
                    $cbcart_is_footer = "false";
                }

                if ($cbcart_template_type === "BUTTONS") {
                    $cbcart_format_type = $cbcart_arr2['buttons'];
                    foreach ($cbcart_format_type as $cbcart_f_type){
                        $cbcart_button_type = $cbcart_f_type['type'];
                        if($cbcart_button_type === "URL") {
                            $cbcart_button_url = $cbcart_f_type['url'];
                        }

                    }
                    $cbcart_variable = "{{";

                    if ($cbcart_button_type == "URL") {
                        if(strpos($cbcart_button_url, $cbcart_variable) !== false) {
                            $cbcart_is_button = "true";
                            $cbcart_is_button_with_url = $cbcart_button_url;
                        }
                    }  else if($cbcart_button_type == "QUICK_REPLY"){
                        $cbcart_is_button = "true";
                        $cbcart_is_button_with_url = "false";
                    } else {
                        $cbcart_is_button = "false";
                    }
                }
            }
          return  $cbcart_results_array = array(
                'cbcart_is_header' => $cbcart_is_header,
                'cbcart_header_image' => $cbcart_is_header_image,
                'cbcart_header_text' => $cbcart_is_header_text,
                'cbcart_header_video'=>$cbcart_is_header_video,
                'cbcart_header_doc'=>$cbcart_is_header_doc,
                'cbcart_is_body' => $cbcart_is_text,
                'cbcart_body_text' => $cbcart_body_text,
                'cbcart_footer' => $cbcart_is_footer,
                'cbcart_is_buttons' => $cbcart_is_button,
                'cbcart_is_button_with_url' => $cbcart_is_button_with_url
            );
            } catch ( Exception $exception ) {
                //we are not adding any log files now.
            }
        }

        /**
         * Check the user data from of the plugin.
         *
         * @param Email_ID
         *
         * @return    string   The response of API call.
         * @version   3.0.4
         * @since     1.0.0
         */
        public static function cbcart_get_user_credentials( $cbcart_emailid ) {

            // fetching user credentials
            $cbcart_data_decoded = array(
                "Email"  => $cbcart_emailid,
                "source" =>"1"
            );
            $cbcart_data         = json_encode( $cbcart_data_decoded );
            $cbcart_url          = esc_url( "https://whatso.net/svc.asmx/GetOtpDetails",'cartbox-messaging-widgets' );
            $cbcart_response     = wp_remote_post(
                $cbcart_url,
                array(
                    'method'  => 'POST',
                    'headers' => array(
                        'Content-Type' => 'application/json; charset=utf-8',
                        'WPRequest'    => 'abach34h4h2h11h3h'
                    ),
                    'body'    => $cbcart_data
                )
            );
			if ( is_array( $cbcart_response ) && isset( $cbcart_response['response'] ) ) {
				$cbcart_result  = update_option( 'cbcart_getotp', wp_json_encode( $cbcart_response ) );
			} else {
				return "database error";
			}
			return $cbcart_response;
        }

        /**
         * Check the user plan.
         *
         * @since     1.0.0
         * @version   3.0.4
         */
        public static function cbcart_get_user_plan($cbcart_otp) {

            // get admin settings
            if ( ! empty( get_option( 'cbcart_adminsettings' ) ) ) {
                $cbcart_data     = get_option( 'cbcart_adminsettings' );
                $cbcart_data     = json_decode( $cbcart_data );
                $cbcart_data = sanitize_option(  "cbcart_adminsettings",$cbcart_data );
                if($cbcart_data != ""){
                    $cbcart_username = $cbcart_data->cbcart_username;
                    $cbcart_password = $cbcart_data->cbcart_password;
                    $cbcart_emailid  = $cbcart_data->cbcart_email;
                    $cbcart_from_number = $cbcart_data->cbcart_from_number;
                    $cbcart_default_country = $cbcart_data->cbcart_default_country;
                    $cbcart_cron_time = $cbcart_data->cbcart_cron_time;
                } else {
                    $cbcart_username = "";
                    $cbcart_password = "";
                    $cbcart_emailid  = "";
                    $cbcart_from_number = "";
                    $cbcart_default_country = "";
                    $cbcart_cron_time = "";
                }

				if($cbcart_cron_time == ""){
					$cbcart_cron_time="1200";
				}

                $cbcart_base_url  = site_url( $path = '', $scheme = null );

                $cbcart_data_decoded = array(
                    "emailId"  => $cbcart_emailid,
                    "password" => "" ,
                    "username" => "",
	                "otp"=> $cbcart_otp,
                    "isExtension"=> true,
                    "isFromProduct"=> "ABNDCRT",
                    "siteURL"=> $cbcart_base_url
                );

                $cbcart_data         = json_encode( $cbcart_data_decoded );
				$cbcart_url          = esc_url( "https://webapi.whatso.net/api/UnAuthorized/get-plan",'cartbox-messaging-widgets' );
                $cbcart_response     = wp_remote_post(
                    $cbcart_url,
                    array(
                        'method'  => 'POST',
                        'headers' => array(
                            'Content-Type' => 'application/json; charset=utf-8',
                            'WPRequest'    => 'abach34h4h2h11h3h'
                        ),
                        'body'    => $cbcart_data
                    )
                );
                $cbcart_result       = update_option( 'cbcart_userplan', wp_json_encode( $cbcart_response ) );

                if ( is_array( $cbcart_response ) && isset( $cbcart_response['body'] ) ) {
					$cbcart_response_obj = json_decode( $cbcart_response['body'] );
	                $cbcart_result       = update_option( 'cbcart_userplan', wp_json_encode( $cbcart_response_obj ) );
	                if ( ! empty( get_option( 'cbcart_userplan' ) ) ) {
		                $cbcart_data           = get_option( 'cbcart_userplan' );
		                $cbcart_data           = json_decode( $cbcart_data );
                        $cbcart_data           = sanitize_option(  "cbcart_userplan",$cbcart_data );
                        if ($cbcart_data != "") {
                            $cbcart_username = $cbcart_data->userName;
                            $cbcart_password = $cbcart_data->password;
                            $cbcart_otpcheck = $cbcart_data->validateOtpMesaage;
                        } else {

                            $cbcart_username = "";
                            $cbcart_password = "";
                            $cbcart_otpcheck = "";
                        }
		                $cbcart_admin_settings = array(
			                "cbcart_username" => $cbcart_username,
			                "cbcart_password" => $cbcart_password,
			                "cbcart_email"    => $cbcart_emailid,
			                'cbcart_from_number'     => $cbcart_from_number,
			                'cbcart_default_country' => $cbcart_default_country,
			                'cbcart_cron_time'       => $cbcart_cron_time,
		                );

		                $cbcart_result1    = update_option( 'cbcart_adminsettings', wp_json_encode( $cbcart_admin_settings ) );
						if ( $cbcart_otpcheck == "OTP is valid" ) {
							return "true";
						} else {
							return "false";
						}
	                }
                }
            }
        }

        /**
         * Get templates status from table.
         *
         * @since     1.0.0
         * @version   3.0.4
         * @return string cbcart_template_status
         */
        public static function cbcart_get_templates_status($cbcart_template_name) {

            $cbcart_template_status = "";

            //get template to check if template already exist
            $cbcart = new cbcart();
            $cbcart_get_template = cbcart::cbcart_get_templates();

            if (!empty($cbcart_template_name)) {
                global $wpdb;
                $table_prefix = $wpdb->prefix;
                $cbcart_table_name = 'cbcart_template';
                $cbcart_template_table = $table_prefix . "$cbcart_table_name";
                $cbcart_temp_data = $wpdb->prepare("SELECT cbcart_template_status FROM $cbcart_template_table WHERE cbcart_template_name= %s", $cbcart_template_name); //db call ok; no-cache ok
                $cbcart_template_status = $wpdb->get_var($cbcart_temp_data);

                if (empty($cbcart_template_status)|| !isset($cbcart_template_status)) {
                    $cbcart_template_status="Template Not Found";
                }
            } else {
                $cbcart_template_status="Template Not Found";
            }
            if ($cbcart_template_status==="APPROVED") {
                $cbcart_template_status='<label class="cbcart_approved_label"><i class="fa fa-check "></i>Facebook has approved your Message</label>';
            } else {
                $cbcart_template_status="Not Approved";
                $cbcart_template_status='<label class="cbcart_status_label">'.$cbcart_template_status.'</label>'.'<label class="cbcart_sub_label text-break"> &nbsp;  Your Template is not approved. To Check Exact status <a href="https://business.facebook.com/wa/manage/message-templates/" target="_blank">Visit Here</a></label>';
            }

            $cbcart_data                          = get_option( 'cbcart_usersettings' );
            $cbcart_data                          = json_decode( $cbcart_data );
            $cbcart_data           = sanitize_option(  "cbcart_usersettings",$cbcart_data );
            if ($cbcart_data!="") {
                $cbcart_checkplan = $cbcart_data->cbcart_planid;
            }
            if($cbcart_checkplan==="1"){
                $cbcart_template_status='<label class="cbcart_approved_label"><i class="fa fa-check "></i>APPROVED</label>';
            }
            return $cbcart_template_status;
        }

	    /**
	     * Get templates from cloud.
	     *
	     * @since     1.0.0
	     * @version   3.0.4
         * @return null
	     */
        public static function cbcart_get_templates() {
            global $wpdb;
            $table_prefix           = $wpdb->prefix;
            $cbcart_table_name       = 'cbcart_template';
            $cbcart_template_table  = $table_prefix . "$cbcart_table_name";
            $cbcart_temp_data = $wpdb->get_results( "SELECT cbcart_id,cbcart_template_id,cbcart_template_name,cbcart_template_language,cbcart_template_status,cbcart_template_category,cbcart_template_components FROM $cbcart_template_table"); //db call ok; no-cache ok
            $cbcart_result_count  = $cbcart_temp_data;

            if (($cbcart_result_count > 0)|| ($cbcart_result_count != null)) {
                $cbcart_data = $wpdb->get_results("TRUNCATE TABLE $cbcart_template_table");
                $cbcart_result_count2  = $cbcart_data ;
            }
            $cbcart_data                          = get_option( 'cbcart_usersettings' );
            $cbcart_data                          = json_decode( $cbcart_data );
            $cbcart_data                          = sanitize_option(  "cbcart_usersettings",$cbcart_data );
            if ($cbcart_data!="") {
                $cbcart_checkplan = $cbcart_data->cbcart_planid;
            }
            else{
                $cbcart_checkplan="";
            }
            if($cbcart_checkplan==="2"||$cbcart_checkplan==="3"||$cbcart_checkplan==="4"){
                $cbcart_data = get_option('cbcart_premiumsettings');
                $cbcart_data = json_decode($cbcart_data);
                $cbcart_data = sanitize_option("cbcart_premiumsettings", $cbcart_data);
            }else{
                $cbcart_data = get_option('cbcart_freepremium');
                $cbcart_data = json_decode($cbcart_data);
                $cbcart_data = sanitize_option("cbcart_freepremium", $cbcart_data);
            }
            $cbcart_token     = $cbcart_data->cbcart_token;
            $cbcart_wabaid = $cbcart_data->cbcart_wabaid;
            $cbcart_url      = esc_url("https://graph.facebook.com/v14.0/$cbcart_wabaid/message_templates?limit=100&access_token=$cbcart_token");

            $cbcart_header = array(
                'headers' => array(
                    'Authorization' => 'Bearer '.$cbcart_token,
                )
            );
            $cbcart_response     = wp_remote_get( $cbcart_url,$cbcart_header);
            $cbcart_result       = update_option( 'cbcart_req', $cbcart_header );
            $cbcart_response=json_decode($cbcart_response['body']);
            $cbcart_result2       = update_option( 'cbcart_res',wp_json_encode($cbcart_response));
            $cbcart_data      = get_option( 'cbcart_res');
            $cbcart_data      = json_decode( $cbcart_data );
            $cbcart_data = sanitize_option("cbcart_res", $cbcart_data);
            $cbcart_template_list = $cbcart_data->data;
            $cbcart_template_list   = json_decode( json_encode( $cbcart_template_list ), true );
            $cbcart_template_name=array();
            foreach ( $cbcart_template_list as $cbcart_gettemplate ) {
                $cbcart_insert_array = array(
                    'cbcart_template_id'             => $cbcart_gettemplate['id'],
                    'cbcart_template_name'           => $cbcart_gettemplate['name'],
                    'cbcart_template_language'       => $cbcart_gettemplate['language'],
                    'cbcart_template_status'         => $cbcart_gettemplate['status'],
                    'cbcart_template_category'       => $cbcart_gettemplate['category'],
                    'cbcart_template_components'     => serialize( $cbcart_gettemplate['components'] )
                );
                $wpdb->insert( $cbcart_template_table, $cbcart_insert_array );
            }

        }

        /**
         * Get and set option for each message.
         *
         * @since     1.0.0
         * @version   3.0.4
         * @return null
         */
        public static function cbcart_set_message_option() {
            //calling templates
            cbcart::cbcart_get_templates();
            //create 9 arrays of messages
            $cbcart_data = get_option('cbcart_abandonedsettings');
            $cbcart_data = json_decode($cbcart_data);
            $cbcart_data= sanitize_option(  "cbcart_abandonedsettings",$cbcart_data);
            if ($cbcart_data != "") {
                $cbcart_ac_template_name = $cbcart_data->cbcart_ac_template_name;
                $cbcart_ac_template_lang = $cbcart_data->cbcart_ac_template_lang;
                $cbcart_ac_template_varcount = $cbcart_data->cbcart_ac_template_varcount;
                $cbcart_ac_message2 = $cbcart_data->cbcart_ac_message2;
                $cbcart_ac_template2_name = $cbcart_data->cbcart_ac_template2_name;
                $cbcart_ac_template2_lang = $cbcart_data->cbcart_ac_template2_lang;
                $cbcart_ac_template2_varcount = $cbcart_data->cbcart_ac_template2_varcount;
                $cbcart_ac_message3 = $cbcart_data->cbcart_ac_message3;
                $cbcart_ac_template3_name = $cbcart_data->cbcart_ac_template3_name;
                $cbcart_ac_template3_lang = $cbcart_data->cbcart_ac_template3_lang;
                $cbcart_ac_template3_varcount = $cbcart_data->cbcart_ac_template3_varcount;
                $cbcart_ac_message4 = $cbcart_data->cbcart_ac_message4;
                $cbcart_ac_template4_name = $cbcart_data->cbcart_ac_template4_name;
                $cbcart_ac_template4_lang = $cbcart_data->cbcart_ac_template4_lang;
                $cbcart_ac_template4_varcount = $cbcart_data->cbcart_ac_template4_varcount;
                $cbcart_ac_message5 = $cbcart_data->cbcart_ac_message5;
                $cbcart_ac_template5_name = $cbcart_data->cbcart_ac_template5_name;
                $cbcart_ac_template5_lang = $cbcart_data->cbcart_ac_template5_lang;
                $cbcart_ac_template5_varcount = $cbcart_data->cbcart_ac_template5_varcount;
            }
            $cbcart_data1 = get_option('cbcart_ordernotificationsettings');
            $cbcart_data1 = json_decode($cbcart_data1);
            $cbcart_data1= sanitize_option(  "cbcart_ordernotificationsettings",$cbcart_data1);
            if ($cbcart_data1 != "") {
                $cbcart_admin_message = $cbcart_data1->cbcart_admin_message;
                $cbcart_admin_template_name = $cbcart_data1->cbcart_admin_template_name;
                $cbcart_admin_template_lang = $cbcart_data1->cbcart_admin_template_lang;
                $cbcart_admin_template_varcount = $cbcart_data1->cbcart_admin_template_varcount;
                $cbcart_customer_message = $cbcart_data1->cbcart_customer_message;
                $cbcart_customer_template_name = $cbcart_data1->cbcart_customer_template_name;
                $cbcart_customer_template_lang = $cbcart_data1->cbcart_customer_template_lang;
                $cbcart_customer_template_varcount = $cbcart_data1->cbcart_customer_template_varcount;
                $cbcart_is_order_completed=$cbcart_data1->cbcart_is_order_completed;
                $cbcart_is_order_processing=$cbcart_data1->cbcart_is_order_processing;
                $cbcart_is_order_payment_done=$cbcart_data1->cbcart_is_order_payment_done;
            }
            $cbcart_data2 = get_option('cbcart_contactformsettings');
            $cbcart_data2 = json_decode($cbcart_data2);
            $cbcart_data2= sanitize_option(  "cbcart_contactformsettings",$cbcart_data2);
            if ($cbcart_data2 != "") {
                $cbcart_cf7admin_template_name = $cbcart_data2->cbcart_cf7admin_template_name;
                $cbcart_cf7admin_template_language = $cbcart_data2->cbcart_cf7admin_template_language;
                $cbcart_cf7admin_template_varcount = $cbcart_data2->cbcart_cf7admin_template_varcount;
                $cbcart_cf7customer_template_name = $cbcart_data2->cbcart_cf7customer_template_name;
                $cbcart_cf7customer_template_language = $cbcart_data2->cbcart_cf7customer_template_language;
                $cbcart_cf7customer_template_varcount = $cbcart_data2->cbcart_cf7customer_template_varcount;
            }
            $cbcart_t_name="";
            $cbcart_t_lan="";
            $cbcart_abandond     = cbcart_cart_awaits;
            $cbcart_order = cbcart_order_notify;
            $cbcart_contact =cbcart_contact_form;
            $cbcart_type=array("cbcart_abandoned_1","cbcart_abandoned_2","cbcart_abandoned_3","cbcart_abandoned_4","cbcart_abandoned_5","cbcart_order_admin","cbcart_order_customer","cbcart_cf7_admin","cbcart_cf7_customer");
            foreach ($cbcart_type as $cbcart_msg_type) {
                $cbcart_temp_option_name=$cbcart_msg_type;
                if($cbcart_msg_type==="cbcart_abandoned_1"){
                    $cbcart_t_name=$cbcart_ac_template_name;
                    $cbcart_t_lan=$cbcart_ac_template_lang;
                    $cbcart_t_para_count=$cbcart_ac_template_varcount;
                    $cbcart_t_para_array=array("{{customername}}","{{storename}}","{{storename}}");
                    $cbcart_image_url= esc_url($cbcart_abandond);
                    $cbcart_btn_url="{{checkouturl}}";
                }
                if($cbcart_msg_type==="cbcart_abandoned_2"){
                    $cbcart_t_name=$cbcart_ac_template2_name;
                    $cbcart_t_lan=$cbcart_ac_template2_lang;
                    $cbcart_t_para_count=$cbcart_ac_template2_varcount;
                    $cbcart_t_para_array=array("{{customername}}");
                    $cbcart_image_url= esc_url($cbcart_abandond);
                    $cbcart_btn_url="{{checkouturl}}";
                }
                if($cbcart_msg_type==="cbcart_abandoned_3"){
                    $cbcart_t_name=$cbcart_ac_template3_name;
                    $cbcart_t_lan=$cbcart_ac_template3_lang;
                    $cbcart_t_para_count=$cbcart_ac_template3_varcount;
                    $cbcart_t_para_array=array("{{customername}}","{{storename}}","{{storename}}");
                    $cbcart_image_url= esc_url( $cbcart_abandond);
                    $cbcart_btn_url="{{checkouturl}}";
                }
                if($cbcart_msg_type==="cbcart_abandoned_4"){
                    $cbcart_t_name=$cbcart_ac_template4_name;
                    $cbcart_t_lan=$cbcart_ac_template4_lang;
                    $cbcart_t_para_count=$cbcart_ac_template4_varcount;
                    $cbcart_t_para_array=array("{{customername}}","{{storename}}","{{storeurl}}","{{storename}}");
                    $cbcart_image_url=esc_url($cbcart_abandond);
                    $cbcart_btn_url="{{checkouturl}}";
                }
                if($cbcart_msg_type==="cbcart_abandoned_5"){
                    $cbcart_t_name=$cbcart_ac_template5_name;
                    $cbcart_t_lan=$cbcart_ac_template5_lang;
                    $cbcart_t_para_count=$cbcart_ac_template5_varcount;
                    $cbcart_t_para_array=array("{{customername}}","{{storename}}","{{storename}}");
                    $cbcart_image_url= esc_url($cbcart_abandond);
                    $cbcart_btn_url="{{checkouturl}}";
                }
                if($cbcart_msg_type==="cbcart_order_admin"){
                    $cbcart_t_name=$cbcart_admin_template_name;
                    $cbcart_t_lan=$cbcart_admin_template_lang;
                    $cbcart_t_para_count=$cbcart_admin_template_varcount;
                    $cbcart_t_para_array=array("{{storename}}","{{storeurl}}","{{productname}}","{{amountwithcurrency}}","{{customeremail}}");
                    $cbcart_image_url= esc_url( $cbcart_order);
                    $cbcart_btn_url="{{storeurl}}";
                }
                if($cbcart_msg_type==="cbcart_order_customer"){
                    $cbcart_t_name=$cbcart_customer_template_name;
                    $cbcart_t_lan=$cbcart_customer_template_lang;
                    $cbcart_t_para_count=$cbcart_customer_template_varcount;
                    $cbcart_t_para_array=array("{{storename}}","{{productname}}","{{amountwithcurrency}}");
                    $cbcart_image_url= esc_url( $cbcart_order);
                    $cbcart_btn_url="{{storeurl}}";
                }
                if($cbcart_msg_type==="cbcart_cf7_admin"){
                    $cbcart_t_name=$cbcart_cf7admin_template_name;
                    $cbcart_t_lan=$cbcart_cf7admin_template_language;
                    $cbcart_t_para_count=$cbcart_cf7admin_template_varcount;
                    $cbcart_t_para_array=array("{{customername}}","{{customerdetails}}","{{StoreName}}");
                    $cbcart_image_url= esc_url($cbcart_contact);
                    $cbcart_btn_url="{{storeurl}}";
                }
                if($cbcart_msg_type==="cbcart_cf7_customer"){
                    $cbcart_t_name=$cbcart_cf7customer_template_name;
                    $cbcart_t_lan=$cbcart_cf7customer_template_language;
                    $cbcart_t_para_count=$cbcart_cf7customer_template_varcount;
                    $cbcart_t_para_array=array();
                    $cbcart_image_url= esc_url($cbcart_contact);
                    $cbcart_btn_url="{{storeurl}}";
                }
                if(empty($cbcart_t_name)||empty($cbcart_t_lan)){
                    //do nothing
                }else {
                    $cbcart_get_selected_template_type = cbcart::cbcart_get_template_type($cbcart_t_name, $cbcart_t_lan);
                    $cbcart_st_is_header = $cbcart_get_selected_template_type['cbcart_is_header'];
                    $cbcart_st_header_image = $cbcart_get_selected_template_type['cbcart_header_image'];
                    $cbcart_st_header_text = $cbcart_get_selected_template_type['cbcart_header_text'];
                    $cbcart_st_header_video = $cbcart_get_selected_template_type['cbcart_header_video'];
                    $cbcart_st_header_doc = $cbcart_get_selected_template_type['cbcart_header_doc'];
                    $cbcart_st_is_body = $cbcart_get_selected_template_type['cbcart_is_body'];
                    $cbcart_st_body_text = $cbcart_get_selected_template_type['cbcart_body_text'];
                    $cbcart_st_footer = $cbcart_get_selected_template_type['cbcart_footer'];
                    $cbcart_st_is_buttons = $cbcart_get_selected_template_type['cbcart_is_buttons'];
                    $cbcart_st_is_buttons_with_url = $cbcart_get_selected_template_type['cbcart_is_button_with_url'];
                    $cbcart_para_count = $cbcart_t_para_count;
                    if ($cbcart_st_header_image === "true") {
                        $cbcart_temp_image = $cbcart_image_url;
                    } else {
                        $cbcart_temp_image = "false";
                    }
                    if ($cbcart_st_is_buttons === "true" && $cbcart_st_is_buttons_with_url != "") {
                        $cbcart_temp_btn_url = $cbcart_btn_url;
                        $cbcart_st_btn_count = "1";
                    } else {
                        $cbcart_temp_btn_url = "false";
                        $cbcart_st_btn_count = "0";
                    }
                    if ($cbcart_st_is_header != "true") {
                        $cbcart_st_is_header = "false";
                    }
                    if ($cbcart_st_header_text != "true") {
                        $cbcart_st_header_text = "false";
                    }
                    $cbcart_update_option_arr = array(
                        'cbcart_temp_name' => $cbcart_t_name,
                        'cbcart_temp_language' => $cbcart_t_lan,
                        'cbcart_is_header' => $cbcart_st_is_header,
                        'cbcart_is_header_text' => $cbcart_st_header_text,
                        'cbcart_is_header_image_url' => $cbcart_temp_image,
                        'cbcart_is_body' => $cbcart_st_is_body,
                        'cbcart_body_param_array' => $cbcart_t_para_array,
                        'cbcart_body_param_count' => $cbcart_para_count,
                        'cbcart_is_button_count' => $cbcart_st_btn_count,
                        'cbcart_is_button_url_1' => $cbcart_temp_btn_url,
                    );
                    $cbcart_result1 = update_option($cbcart_temp_option_name, wp_json_encode($cbcart_update_option_arr));
                }
            }
        }


        /**
         * Get account statue for cartbox
         *
         * @since     1.0.0
         * @version   1.0.0
         * @return array cbcart_account_status
         */
        public static function cbcart_check_free_account($cbcart_email) {
            $cbcart_url = "https://whatso.net/svc.asmx/SaveDownloadEmail?emailAddress=".$cbcart_email;
            $cbcart_response = wp_remote_get($cbcart_url);
            $cbcart_response = $cbcart_response['body'];
            $cbcart_response_obj   = json_decode( json_encode( $cbcart_response ), true );
            return $cbcart_response_obj;
        }

        /**
         * Get account statue
         *
         * @since     1.0.0
         * @version   1.0.0
         * @return array cbcart_account_status
         */
        public static function cbcart_check_account_status($cbcart_wabaid,$cbcart_token) {
            $cbcart_url = "https://graph.facebook.com/v14.0/$cbcart_wabaid";
            $cbcart_data = array('access_token' => $cbcart_token,'fields'=>'id,account_review_status,currency,name,timezone_id');
            $cbcart_query_url = $cbcart_url.'?'.http_build_query($cbcart_data);
            $cbcart_response = wp_remote_get($cbcart_query_url);
            return $cbcart_response['body'];
        }
        /**
         * Build component for customise template body
         *
         * @since     1.0.0
         * @version   1.0.0
         * @param     $cbcart_option_name
         * @return    Array cbcart_component.
         */
        public static function cbcart_build_components($cbcart_option_name , $cbcart_body_param_array ,$cbcart_is_button_url_msg) {
            $cbcart_data = get_option($cbcart_option_name);
            $cbcart_data = json_decode($cbcart_data);
            $cbcart_data = sanitize_option($cbcart_option_name, $cbcart_data);
            $cbcart_temp_name = $cbcart_data->cbcart_temp_name;
            $cbcart_temp_language = $cbcart_data->cbcart_temp_language;
            $cbcart_is_header = $cbcart_data->cbcart_is_header;
            $cbcart_is_header_text = $cbcart_data->cbcart_is_header_text;
            $cbcart_is_header_image_url1 = $cbcart_data->cbcart_is_header_image_url;
            $cbcart_is_body = $cbcart_data->cbcart_is_body;
            $cbcart_body_param_count = $cbcart_data->cbcart_body_param_count;
            $cbcart_is_button_count = $cbcart_data->cbcart_is_button_count;
            $cbcart_is_header_image_url = array("link" => $cbcart_is_header_image_url1);
            $cbcart_data = get_option('cbcart_usersettings');
            $cbcart_data = json_decode($cbcart_data);
            $cbcart_data = sanitize_option("cbcart_usersettings", $cbcart_data);
            $cbcart_checkplan = $cbcart_data->cbcart_planid;

            if ($cbcart_checkplan === "2" || $cbcart_checkplan === "4") {

                //check if header is true or not if true than append its component
                if ($cbcart_is_header === "true") {
                    if ($cbcart_is_header_image_url1 != "false") {
                        $cbcart_param2[0] = array("type" => "image", "image" => $cbcart_is_header_image_url);
                        $cbcart_componentheader = array("type" => "header", "parameters" => $cbcart_param2);
                    } else if ($cbcart_is_header_text != "false") {
                        $cbcart_componentheader="";
                    } else {
                        $cbcart_componentheader = "";
                    }
                }
                //check if body is true or not if true than append its component
                if ($cbcart_is_body === "true") {
                    if ($cbcart_body_param_array === 0) {
                        $cbcart_component_body[] = "";
                    } else {
                        $cbcart_i = 0;
                        foreach ($cbcart_body_param_array as $cbcart_item) {
                            $cbcart_param1[$cbcart_i] = array("type" => "text", "text" => $cbcart_item);
                            $cbcart_i++;
                        }
                        $cbcart_component_body = array("type" => "body", "parameters" => $cbcart_param1);
                    }
                }
                //check if button count is one, append its component
                if ($cbcart_is_button_count === "1") {
                    $cbcart_button1[0] = array("type" => "text", "text" => $cbcart_is_button_url_msg);
                    $cbcart_component_button1 = array("type" => "button", "sub_type" => "url", "index" => "0", "parameters" => $cbcart_button1);
                }

                //final build up of component array conatins header,body and button
                $cbcart_i = 0;
                if ($cbcart_is_header === "true") {
                    $cbcart_component1[$cbcart_i] = $cbcart_componentheader;
                    $cbcart_i++;
                }
                if ($cbcart_is_body === "true" && $cbcart_body_param_array > 0) {
                    $cbcart_component1[$cbcart_i] = $cbcart_component_body;
                    $cbcart_i++;
                }
                if ($cbcart_is_button_count === "1") {
                    $cbcart_component1[$cbcart_i] = $cbcart_component_button1;
                    $cbcart_i++;
                }
                $cbcart_result1 = update_option('cbcart_compo_build', $cbcart_component1);

                return $cbcart_component1;
            } else {

                //check if header is true or not if true than append its component
                if ($cbcart_is_header === "true") {
                    if ($cbcart_is_header_image_url1 != "false") {
                        $cbcart_param2[0] = array("type" => "image", "value" => $cbcart_is_header_image_url1);
                        $cbcart_componentheader = array("type" => "header", "parameters" => $cbcart_param2);
                    } else if ($cbcart_is_header_text != "false") {
                        $cbcart_param2[0] = array("type" => "text", "value" => $cbcart_is_header_text);
                        $cbcart_componentheader = array("type" => "header", "parameters" => $cbcart_param2);
                    } else {
                        $cbcart_componentheader = "";
                    }
                }
                //check if body is true or not if true than append its component
                if ($cbcart_is_body === "true") {
                    if ($cbcart_body_param_array === 0) {
                        $cbcart_component_body[] = "";
                    } else {
                        $cbcart_i = 0;
                        foreach ($cbcart_body_param_array as $cbcart_item) {
                            $cbcart_param1[$cbcart_i] = array("type" => "text", "value" => $cbcart_item);
                            $cbcart_i++;
                        }
                        $cbcart_component_body = array("type" => "body", "parameters" => $cbcart_param1);
                    }
                }
                //check if button count is one, append its component
                if ($cbcart_is_button_count === "1") {
                    $cbcart_button1[0] = array("type" => "text", "value" => $cbcart_is_button_url_msg);
                    $cbcart_component_button1 = array("type" => "button", "parameters" => $cbcart_button1, "sub_type" => "url", "index" => "0");
                }

                //final build up of component array conatins header,body and button
                $cbcart_i = 0;
                if ($cbcart_is_header === "true") {
                    $cbcart_component1[$cbcart_i] = $cbcart_componentheader;
                    $cbcart_i++;
                }
                if ($cbcart_is_body === "true" && $cbcart_body_param_array > 0) {
                    $cbcart_component1[$cbcart_i] = $cbcart_component_body;
                    $cbcart_i++;
                }
                if ($cbcart_is_button_count === "1") {
                    $cbcart_component1[$cbcart_i] = $cbcart_component_button1;
                    $cbcart_i++;
                }
                return $cbcart_component1;
            }
        }

        /**
         * If Any order placed on site this function call API and send Message to customer and site owner.
         *
         * @version 3.0.4
         * @since     1.0.0
         * @param cbcart_order_id,cbcart_posted_data,cbcart_order
         * @return    string   The response of API call.
         */
        public function cbcart_order_processed( $cbcart_order_id, $cbcart_posted_data, $cbcart_order ) {

            $execute_flag = true;
            global $wpdb;
            $cbcart_order_table = $wpdb->prefix . 'cbcart_orderdetails';
            if ( is_a( $cbcart_order, 'WC_Order_Refund' ) ) {
                $execute_flag = false;
            }
            if ( $cbcart_order === false ) {
                $execute_flag = false;
            }
            if ( $execute_flag ) {
                $cbcart_data = get_option( 'cbcart_usersettings' );
                $cbcart_data = json_decode( $cbcart_data );
                $cbcart_data = sanitize_option("cbcart_usersettings", $cbcart_data);
                $cbcart_checkplan   = $cbcart_data->cbcart_planid;
                if ( ! empty( get_option( 'cbcart_ordernotificationsettings' ) ) ) {
                    $cbcart_data                  = get_option( 'cbcart_ordernotificationsettings' );
                    $cbcart_data                  = json_decode( $cbcart_data );
                    $cbcart_data         = sanitize_option("cbcart_ordernotificationsettings", $cbcart_data);
                    if ($cbcart_data != "") {
                        $cbcart_admin_mobileno = $cbcart_data->cbcart_admin_mobileno;
                        $cbcart_admin_notification = $cbcart_data->cbcart_admin_notification;
                        $cbcart_customer_notification = $cbcart_data->cbcart_customer_notification;
                    } else {
                        $cbcart_admin_mobileno = "";
                        $cbcart_customer_notification = "";
                        $cbcart_admin_notification ="";
                    }
                    $cbcart_data = get_option('cbcart_adminsettings');
                    $cbcart_data = json_decode($cbcart_data);
                    $cbcart_data         = sanitize_option("cbcart_adminsettings", $cbcart_data);
                    if ($cbcart_data != "") {
                        $cbcart_email = $cbcart_data->cbcart_email;
                        $cbcart_username = $cbcart_data->cbcart_username;
                        $cbcart_password = $cbcart_data->cbcart_password;
                        $cbcart_from_number = $cbcart_data->cbcart_from_number;
                    } else {
                        $cbcart_email = "";
                        $cbcart_username = "";
                        $cbcart_password = "";
                        $cbcart_from_number = "";
                    }
                    $cbcart_store_name            = get_bloginfo( 'name' );
                    $cbcart_billing_email         = $cbcart_order->get_billing_email();
                    $cbcart_order_currency        = $cbcart_order->get_currency();
                    $cbcart_order_amount          = $cbcart_order->get_total();
                    $cbcart_order_date            = $cbcart_order->get_date_created();
                    $cbcart_order_customer        = $cbcart_order->get_billing_first_name();
                    $cbcart_items                 = $cbcart_order->get_items();
                    $cbcart_products_array        = array();

                    $cbcart_data = get_option( 'cbcart_premiumsettings' );
                    $cbcart_data = json_decode( $cbcart_data );
                    $cbcart_data         = sanitize_option("cbcart_premiumsettings", $cbcart_data);

                    $cbcart_bearer_token= $cbcart_data->cbcart_token;
                    $cbcart_phone_noid= $cbcart_data->cbcart_phoneid;

                    $cbcart_data = get_option('cbcart_order_admin');
                    $cbcart_data = json_decode($cbcart_data);
                    $cbcart_data         = sanitize_option("cbcart_order_admin", $cbcart_data);

                    $cbcart_temp_name= $cbcart_data->cbcart_temp_name;
                    $cbcart_temp_language= $cbcart_data->cbcart_temp_language;
                    $cbcart_body_param_count= $cbcart_data->cbcart_body_param_count;
                    $cbcart_body_param_array= $cbcart_data->cbcart_body_param_array;
                    $cbcart_is_button_url_1 =$cbcart_data->cbcart_is_button_url_1;
                    $cbcart_data = get_option('cbcart_order_customer');
                    $cbcart_data = json_decode($cbcart_data);
                    $cbcart_data         = sanitize_option("cbcart_order_customer", $cbcart_data);

                    $cbcart_temp_name2= $cbcart_data->cbcart_temp_name;
                    $cbcart_temp_language2= $cbcart_data->cbcart_temp_language;
                    $cbcart_body_param_count2= $cbcart_data->cbcart_body_param_count;
                    $cbcart_body_param_array2= $cbcart_data->cbcart_body_param_array;
                    $cbcart_is_button_url_2 =$cbcart_data->cbcart_is_button_url_1;


                    foreach ( $cbcart_items as $item ) {
                        $cbcart_product = $item->get_product();
                        $cbcart_product_name = '';
                        if ( ! is_object( $cbcart_product ) ) {
                            $cbcart_product_name = $item->get_name();
                        } else {
                            $cbcart_product_name = $cbcart_product->get_title();
                        }
                        array_push( $cbcart_products_array, $cbcart_product_name );
                    }

                    $cbcart_countryCode = $cbcart_order->get_billing_country();
                    if ( empty( $cbcart_countryCode ) ) {
                        $cbcart_countryCode = $cbcart_order->get_shipping_country();
                    }
                    $cbcart_city = $cbcart_order->get_billing_city();
                    if ( empty( $cbcart_city ) ) {
                        $city = $cbcart_order->get_shipping_city();
                    }
                    $cbcart_stateCode = $cbcart_order->get_billing_state();
                    if ( empty( $stateCode ) ) {
                        $stateCode = $cbcart_order->get_shipping_state();
                    }
                    $cbcart_base_url         = site_url( $path = '', $scheme = null );
                    $cbcart_customernumber       = $cbcart_order->get_billing_phone();
                    $cbcart_exploded_names       = implode( ",", $cbcart_products_array );
                    $cbcart_order_date_formatted = $cbcart_order_date->date( "d M Y H:i" );
                    $cbcart_customernumber       = preg_replace( '/[^0-9]/', '', $cbcart_customernumber );
                    $cbcart_customername_var="{{customername}}";
                    $cbcart_storename_var="{{storename}}";
                    $cbcart_orderdate_var="{{orderdate}}";
                    $cbcart_productname_var="{{productname}}";
                    $cbcart_amountwithcurrency_var="{{amountwithcurrency}}";
                    $cbcart_customeremail_var="{{customeremail}}";
                    $cbcart_billingcity_var="{{billingcity}}";
                    $cbcart_billingstate_var="{{billingstate}}";
                    $cbcart_billingcountry_var="{{billingcountry}}";
                    $cbcart_customernumber_var="{{customernumber}}";
                    $cbcart_storeurl_var="{{storeurl}}";
                    $cbcart_orderid_var="{{orderid}}";
                    // if customer notification is enable
                    if ( $cbcart_admin_notification === '1' ) {
                        $cbcart_is_button_url_1_msg1 = str_replace('{{storeurl}}', $cbcart_base_url, $cbcart_is_button_url_1);

                        $cbcart_body_param_array = array_replace($cbcart_body_param_array,
                            array_fill_keys(
                                array_keys($cbcart_body_param_array, $cbcart_customername_var),
                                $cbcart_order_customer
                            ),
                            array_fill_keys(
                                array_keys($cbcart_body_param_array, $cbcart_storename_var),
                                $cbcart_store_name
                            ),
                            array_fill_keys(
                                array_keys($cbcart_body_param_array, $cbcart_orderdate_var),
                                $cbcart_order_date_formatted
                            ),
                            array_fill_keys(
                                array_keys($cbcart_body_param_array, $cbcart_productname_var),
                                $cbcart_exploded_names
                            ),
                            array_fill_keys(
                                array_keys($cbcart_body_param_array, $cbcart_amountwithcurrency_var),
                                $cbcart_order_amount
                            ),
                            array_fill_keys(
                                array_keys($cbcart_body_param_array, $cbcart_customeremail_var),
                                $cbcart_billing_email
                            ),
                            array_fill_keys(
                                array_keys($cbcart_body_param_array, $cbcart_billingcity_var),
                                $cbcart_city
                            ),
                            array_fill_keys(
                                array_keys($cbcart_body_param_array, $cbcart_billingstate_var),
                                $cbcart_stateCode
                            ),
                            array_fill_keys(
                                array_keys($cbcart_body_param_array, $cbcart_billingcountry_var),
                                $cbcart_countryCode
                            ),
                            array_fill_keys(
                                array_keys($cbcart_body_param_array, $cbcart_customernumber_var),
                                $cbcart_customernumber
                            ),
                            array_fill_keys(
                                array_keys($cbcart_body_param_array, $cbcart_storeurl_var),
                                $cbcart_base_url
                            ),
                            array_fill_keys(
                                array_keys($cbcart_body_param_array, $cbcart_orderid_var),
                                $cbcart_order_id
                            )
                        );
                        if ($cbcart_checkplan === "2" || $cbcart_checkplan === "4") {

                            $cbcart_language = array("code" => $cbcart_temp_language);
                            $cbcart_option_name = "cbcart_order_admin";
                            $cbcart_component = cbcart::cbcart_build_components($cbcart_option_name, $cbcart_body_param_array, $cbcart_is_button_url_1_msg1);

                            $cbcart_template = array(
                                "name" => $cbcart_temp_name,
                                "language" => $cbcart_language,
                                "components" => $cbcart_component
                            );

                            // call api to send test message
                            $cbcart_data_decoded = array(
                                "messaging_product" => 'whatsapp',
                                "to" => $cbcart_admin_mobileno,
                                "type" => 'template',
                                "template" => $cbcart_template,
                            );

                            $cbcart_data = json_encode($cbcart_data_decoded);
                            $cbcart_url = esc_url("https://graph.facebook.com/v13.0/$cbcart_phone_noid/messages",'cartbox-messaging-widgets');
                            $cbcart_response = wp_remote_post(
                                $cbcart_url, array(
                                    'method' => 'POST',
                                    'headers' => array(
                                        'Content-Type' => 'application/json',
                                        'Authorization' => 'Bearer ' . $cbcart_bearer_token,
                                    ),
                                    'body' => $cbcart_data
                                )
                            );
                            if (is_array($cbcart_response) && isset($cbcart_response['response'])) {
                                $cbcart_response1 = $cbcart_response['response'];
                                $cbcart_insert_array = array(
                                    'cbcart_user_type' => 'admin',
                                    'cbcart_message_api_request' => $cbcart_data,
                                    'cbcart_message_api_response' => wp_json_encode($cbcart_response),
                                );
                                $wpdb->insert($cbcart_order_table, $cbcart_insert_array);
                            }
                        }
                    }
                    $cbcart_customernumber = preg_replace( '/[^0-9]/', '', $cbcart_customernumber );
                    $cbcart_country_code   = $cbcart_countryCode;

                    // if customer number is not null
                    if ( $cbcart_customernumber != "" ) {
                        $cbcart_customernumber = $this->cbcart_check_country( $cbcart_country_code, $cbcart_customernumber );
                    }

                    // if customer notification is enable
                    if ( $cbcart_customer_notification === '1' ) {

                        $cbcart_is_button_url_2_msg2 = str_replace( '{{storeurl}}', $cbcart_base_url, $cbcart_is_button_url_2 );

                        $cbcart_body_param_array2 = array_replace($cbcart_body_param_array2,
                            array_fill_keys(
                                array_keys($cbcart_body_param_array2, $cbcart_customername_var),
                                $cbcart_order_customer
                            ),
                            array_fill_keys(
                                array_keys($cbcart_body_param_array2, $cbcart_storename_var),
                                $cbcart_store_name
                            ),
                            array_fill_keys(
                                array_keys($cbcart_body_param_array2, $cbcart_orderdate_var),
                                $cbcart_order_date_formatted
                            ),
                            array_fill_keys(
                                array_keys($cbcart_body_param_array2, $cbcart_productname_var),
                                $cbcart_exploded_names
                            ),
                            array_fill_keys(
                                array_keys($cbcart_body_param_array2, $cbcart_amountwithcurrency_var),
                                $cbcart_order_amount
                            ),
                            array_fill_keys(
                                array_keys($cbcart_body_param_array2, $cbcart_customeremail_var),
                                $cbcart_billing_email
                            ),
                            array_fill_keys(
                                array_keys($cbcart_body_param_array2, $cbcart_billingcity_var),
                                $cbcart_city
                            ),
                            array_fill_keys(
                                array_keys($cbcart_body_param_array2, $cbcart_billingstate_var),
                                $cbcart_stateCode
                            ),
                            array_fill_keys(
                                array_keys($cbcart_body_param_array2, $cbcart_billingcountry_var),
                                $cbcart_countryCode
                            ),
                            array_fill_keys(
                                array_keys($cbcart_body_param_array2, $cbcart_customernumber_var),
                                $cbcart_customernumber
                            ),
                            array_fill_keys(
                                array_keys($cbcart_body_param_array2, $cbcart_storeurl_var),
                                $cbcart_base_url
                            ),
                            array_fill_keys(
                                array_keys($cbcart_body_param_array2, $cbcart_orderid_var),
                                $cbcart_order_id
                            )
                        );


                        if ( $cbcart_checkplan === "2" || $cbcart_checkplan === "4" )  {

                            $cbcart_language    = array( "code" => $cbcart_temp_language2 );
                            $cbcart_option_name ="cbcart_order_customer";
                            $cbcart_component = cbcart::cbcart_build_components($cbcart_option_name,$cbcart_body_param_array2,$cbcart_is_button_url_2_msg2);

                            $cbcart_template    = array(
                                "name"       => $cbcart_temp_name2,
                                "language"   => $cbcart_language,
                                "components" => $cbcart_component
                            );

                            // call api to send test message
                            $cbcart_data_decoded = array(
                                "messaging_product" => 'whatsapp',
                                "to"                => $cbcart_customernumber,
                                "type"              => 'template',
                                "template"          => $cbcart_template,
                            );

                            $cbcart_data         = json_encode( $cbcart_data_decoded );
                            $cbcart_url          = esc_url( "https://graph.facebook.com/v13.0/$cbcart_phone_noid/messages",'cartbox-messaging-widgets' );
                            $cbcart_response     = wp_remote_post(
                                $cbcart_url, array(
                                    'method'  => 'POST',
                                    'headers' => array(
                                        'Content-Type'  => 'application/json',
                                        'Authorization' => 'Bearer ' . $cbcart_bearer_token,
                                    ),
                                    'body'    => $cbcart_data
                                )
                            );

                            if ( is_array( $cbcart_response ) && isset( $cbcart_response['response'] ) ) {
                                $cbcart_response1= $cbcart_response['response'];
                                $cbcart_insert_array = array(
                                    'cbcart_user_type'            => 'customer',
                                    'cbcart_message_api_request'  => $cbcart_data,
                                    'cbcart_message_api_response' => wp_json_encode( $cbcart_response ),
                                );
	                            $wpdb->insert( $cbcart_order_table, $cbcart_insert_array );
                            }
                        }
                    }
                }
            }
        }

        /**
         * Function to send order message on payment complete
         *
         * @since     1.0.0
         * @version   1.0.0
         * @return null
         */
        public function cbcart_payment_complete( $cbcart_order_id ) {

            global $wpdb;
            $cbcart_order = wc_get_order($cbcart_order_id); //getting order Object
            $cbcart_order_table = $wpdb->prefix . 'cbcart_orderdetails';
            $cbcart_data = get_option( 'cbcart_usersettings' );
            $cbcart_data = json_decode( $cbcart_data );
            $cbcart_data         = sanitize_option("cbcart_usersettings", $cbcart_data);

            $cbcart_checkplan   = $cbcart_data->cbcart_planid;
            $cbcart_data                  = get_option( 'cbcart_ordernotificationsettings' );
            $cbcart_data                  = json_decode( $cbcart_data );
            $cbcart_data         = sanitize_option("cbcart_ordernotificationsettings", $cbcart_data);

            if ($cbcart_data != "") {
                $cbcart_admin_mobileno = $cbcart_data->cbcart_admin_mobileno;
                $cbcart_admin_notification = $cbcart_data->cbcart_admin_notification;
                $cbcart_customer_notification = $cbcart_data->cbcart_customer_notification;
            } else {
                $cbcart_admin_mobileno = "";
                $cbcart_customer_notification = "";
                $cbcart_admin_notification ="";
            }
            $cbcart_data = get_option('cbcart_adminsettings');
            $cbcart_data = json_decode($cbcart_data);
            $cbcart_data         = sanitize_option("cbcart_adminsettings", $cbcart_data);

            if ($cbcart_data != "") {
                $cbcart_email = $cbcart_data->cbcart_email;
                $cbcart_username = $cbcart_data->cbcart_username;
                $cbcart_password = $cbcart_data->cbcart_password;
                $cbcart_from_number = $cbcart_data->cbcart_from_number;
            } else {
                $cbcart_email = "";
                $cbcart_username = "";
                $cbcart_password = "";
                $cbcart_from_number = "";
            }
            $cbcart_data = get_option( 'cbcart_premiumsettings' );
            $cbcart_data = json_decode( $cbcart_data );
            $cbcart_data         = sanitize_option("cbcart_premiumsettings", $cbcart_data);
            $cbcart_bearer_token= $cbcart_data->cbcart_token;
            $cbcart_phone_noid= $cbcart_data->cbcart_phoneid;

            $cbcart_data = get_option('cbcart_order_admin');
            $cbcart_data = json_decode($cbcart_data);
            $cbcart_data  = sanitize_option("cbcart_order_admin", $cbcart_data);

            $cbcart_temp_name= $cbcart_data->cbcart_temp_name;
            $cbcart_temp_language= $cbcart_data->cbcart_temp_language;
            $cbcart_body_param_count= $cbcart_data->cbcart_body_param_count;
            $cbcart_body_param_array= $cbcart_data->cbcart_body_param_array;
            $cbcart_is_button_url_1 =$cbcart_data->cbcart_is_button_url_1;
            $cbcart_data = get_option('cbcart_order_customer');
            $cbcart_data = json_decode($cbcart_data);
            $cbcart_data  = sanitize_option("cbcart_order_customer", $cbcart_data);

            $cbcart_temp_name2= $cbcart_data->cbcart_temp_name;
            $cbcart_temp_language2= $cbcart_data->cbcart_temp_language;
            $cbcart_body_param_count2= $cbcart_data->cbcart_body_param_count;
            $cbcart_body_param_array2= $cbcart_data->cbcart_body_param_array;
            $cbcart_is_button_url_2 =$cbcart_data->cbcart_is_button_url_1;

            $cbcart_store_name            = get_bloginfo( 'name' );
            $cbcart_billing_email         = $cbcart_order->get_billing_email();
            $cbcart_order_currency        = $cbcart_order->get_currency();
            $cbcart_order_amount          = $cbcart_order->get_total();
            $cbcart_order_date            = $cbcart_order->get_date_created();
            $cbcart_order_customer        = $cbcart_order->get_billing_first_name();
            $cbcart_items                 = $cbcart_order->get_items();
            $cbcart_products_array        = array();

            foreach ( $cbcart_items as $item ) {
                $cbcart_product = $item->get_product();
                $cbcart_product_name = '';
                if ( ! is_object( $cbcart_product ) ) {
                    $cbcart_product_name = $item->get_name();
                } else {
                    $cbcart_product_name = $cbcart_product->get_title();
                }
                array_push( $cbcart_products_array, $cbcart_product_name );
            }

            $cbcart_countryCode = $cbcart_order->get_billing_country();
            if ( empty( $cbcart_countryCode ) ) {
                $cbcart_countryCode = $cbcart_order->get_shipping_country();
            }
            $cbcart_city = $cbcart_order->get_billing_city();
            if ( empty( $cbcart_city ) ) {
                $city = $cbcart_order->get_shipping_city();
            }
            $cbcart_stateCode = $cbcart_order->get_billing_state();
            if ( empty( $stateCode ) ) {
                $stateCode = $cbcart_order->get_shipping_state();
            }
            $cbcart_base_url         = site_url( $path = '', $scheme = null );
            $cbcart_customernumber       = $cbcart_order->get_billing_phone();
            $cbcart_exploded_names       = implode( ",", $cbcart_products_array );
            $cbcart_order_date_formatted = $cbcart_order_date->date( "d M Y H:i" );
            $cbcart_customernumber       = preg_replace( '/[^0-9]/', '', $cbcart_customernumber );
            $cbcart_customername_var="{{customername}}";
            $cbcart_storename_var="{{storename}}";
            $cbcart_orderdate_var="{{orderdate}}";
            $cbcart_productname_var="{{productname}}";
            $cbcart_amountwithcurrency_var="{{amountwithcurrency}}";
            $cbcart_customeremail_var="{{customeremail}}";
            $cbcart_billingcity_var="{{billingcity}}";
            $cbcart_billingstate_var="{{billingstate}}";
            $cbcart_billingcountry_var="{{billingcountry}}";
            $cbcart_customernumber_var="{{customernumber}}";
            $cbcart_storeurl_var="{{storeurl}}";
            $cbcart_orderid_var="{{orderid}}";

            // if customer notification is enable
            if ( $cbcart_admin_notification === '1' ) {
                $cbcart_is_button_url_1_msg1 = str_replace('{{storeurl}}', $cbcart_base_url, $cbcart_is_button_url_1);

                $cbcart_body_param_array = array_replace($cbcart_body_param_array,
                    array_fill_keys(
                        array_keys($cbcart_body_param_array, $cbcart_customername_var),
                        $cbcart_order_customer
                    ),
                    array_fill_keys(
                        array_keys($cbcart_body_param_array, $cbcart_storename_var),
                        $cbcart_store_name
                    ),
                    array_fill_keys(
                        array_keys($cbcart_body_param_array, $cbcart_orderdate_var),
                        $cbcart_order_date_formatted
                    ),
                    array_fill_keys(
                        array_keys($cbcart_body_param_array, $cbcart_productname_var),
                        $cbcart_exploded_names
                    ),
                    array_fill_keys(
                        array_keys($cbcart_body_param_array, $cbcart_amountwithcurrency_var),
                        $cbcart_order_amount
                    ),
                    array_fill_keys(
                        array_keys($cbcart_body_param_array, $cbcart_customeremail_var),
                        $cbcart_billing_email
                    ),
                    array_fill_keys(
                        array_keys($cbcart_body_param_array, $cbcart_billingcity_var),
                        $cbcart_city
                    ),
                    array_fill_keys(
                        array_keys($cbcart_body_param_array, $cbcart_billingstate_var),
                        $cbcart_stateCode
                    ),
                    array_fill_keys(
                        array_keys($cbcart_body_param_array, $cbcart_billingcountry_var),
                        $cbcart_countryCode
                    ),
                    array_fill_keys(
                        array_keys($cbcart_body_param_array, $cbcart_customernumber_var),
                        $cbcart_customernumber
                    ),
                    array_fill_keys(
                        array_keys($cbcart_body_param_array, $cbcart_storeurl_var),
                        $cbcart_base_url
                    ),
                    array_fill_keys(
                        array_keys($cbcart_body_param_array, $cbcart_orderid_var),
                        $cbcart_order_id
                    )
                );
                if ($cbcart_checkplan === "1" || $cbcart_checkplan === "3") {
                    $cbcart_option_name = "cbcart_order_admin";
                    $cbcart_component = cbcart::cbcart_build_components($cbcart_option_name, $cbcart_body_param_array, $cbcart_is_button_url_1_msg1);
                    $cbcart_language = array("code" => $cbcart_temp_language);
                    $cbcart_template = array(
                        "language" => $cbcart_language,
                        "name" => $cbcart_temp_name,
                        "apicomponents" => $cbcart_component
                    );
                    // call api to send test message
                    $cbcart_data_decoded = array(
                        "username" => $cbcart_username,
                        "password" => $cbcart_password,
                        "from" => $cbcart_from_number,
                        "to" => $cbcart_admin_mobileno,
                        "type" => "template",
                        "template" => $cbcart_template
                    );
                    $cbcart_data = json_encode($cbcart_data_decoded);
                    $cbcart_url = esc_url("https://api.whatso.net/v1/messages",'cartbox-messaging-widgets');
                    $cbcart_response = wp_remote_post(
                        $cbcart_url,
                        array(
                            'method' => 'POST',
                            'headers' => array(
                                'Content-Type' => 'application/json',
                                'WPRequest' => 'abach34h4h2h11h3h'
                            ),
                            'body' => $cbcart_data
                        )
                    );
                    if (is_array($cbcart_response) && isset($cbcart_response['body'])) {
                        $cbcart_response_obj = json_decode($cbcart_response['body']);
                        if (is_object($cbcart_response_obj)) {
                            // code to update cbcart_order_notification
                            $cbcart_insert_array = array(
                                'cbcart_user_type' => 'admin',
                                'cbcart_message_api_request' => $cbcart_data,
                                'cbcart_message_api_response' => wp_json_encode($cbcart_response_obj),
                            );
                            $wpdb->insert($cbcart_order_table, $cbcart_insert_array);

                        }
                    }
                }
                if ($cbcart_checkplan === "2" || $cbcart_checkplan === "4") {

                    $cbcart_language = array("code" => $cbcart_temp_language);
                    $cbcart_option_name = "cbcart_order_admin";
                    $cbcart_component = cbcart::cbcart_build_components($cbcart_option_name, $cbcart_body_param_array, $cbcart_is_button_url_1_msg1);

                    $cbcart_template = array(
                        "name" => $cbcart_temp_name,
                        "language" => $cbcart_language,
                        "components" => $cbcart_component
                    );

                    // call api to send test message
                    $cbcart_data_decoded = array(
                        "messaging_product" => 'whatsapp',
                        "to" => $cbcart_admin_mobileno,
                        "type" => 'template',
                        "template" => $cbcart_template,
                    );

                    $cbcart_data = json_encode($cbcart_data_decoded);
                    $cbcart_url = esc_url("https://graph.facebook.com/v13.0/$cbcart_phone_noid/messages",'cartbox-messaging-widgets');
                    $cbcart_response = wp_remote_post(
                        $cbcart_url, array(
                            'method' => 'POST',
                            'headers' => array(
                                'Content-Type' => 'application/json',
                                'Authorization' => 'Bearer ' . $cbcart_bearer_token,
                            ),
                            'body' => $cbcart_data
                        )
                    );
                    if (is_array($cbcart_response) && isset($cbcart_response['response'])) {
                        $cbcart_response1 = $cbcart_response['response'];
                        $cbcart_insert_array = array(
                            'cbcart_user_type' => 'admin',
                            'cbcart_message_api_request' => $cbcart_data,
                            'cbcart_message_api_response' => wp_json_encode($cbcart_response),
                        );
                        $wpdb->insert($cbcart_order_table, $cbcart_insert_array);
                    }
                }
            }
            $cbcart_customernumber = preg_replace( '/[^0-9]/', '', $cbcart_customernumber );
            $cbcart_country_code   = $cbcart_countryCode;

            // if customer number is not null
            if ( $cbcart_customernumber != "" ) {
                $cbcart_customernumber = $this->cbcart_check_country( $cbcart_country_code, $cbcart_customernumber );
            }

            // if customer notification is enable
            if ( $cbcart_customer_notification === '1' ) {

                $cbcart_is_button_url_2_msg2 = str_replace( '{{storeurl}}', $cbcart_base_url, $cbcart_is_button_url_2 );

                $cbcart_body_param_array2 = array_replace($cbcart_body_param_array2,
                    array_fill_keys(
                        array_keys($cbcart_body_param_array2, $cbcart_customername_var),
                        $cbcart_order_customer
                    ),
                    array_fill_keys(
                        array_keys($cbcart_body_param_array2, $cbcart_storename_var),
                        $cbcart_store_name
                    ),
                    array_fill_keys(
                        array_keys($cbcart_body_param_array2, $cbcart_orderdate_var),
                        $cbcart_order_date_formatted
                    ),
                    array_fill_keys(
                        array_keys($cbcart_body_param_array2, $cbcart_productname_var),
                        $cbcart_exploded_names
                    ),
                    array_fill_keys(
                        array_keys($cbcart_body_param_array2, $cbcart_amountwithcurrency_var),
                        $cbcart_order_amount
                    ),
                    array_fill_keys(
                        array_keys($cbcart_body_param_array2, $cbcart_customeremail_var),
                        $cbcart_billing_email
                    ),
                    array_fill_keys(
                        array_keys($cbcart_body_param_array2, $cbcart_billingcity_var),
                        $cbcart_city
                    ),
                    array_fill_keys(
                        array_keys($cbcart_body_param_array2, $cbcart_billingstate_var),
                        $cbcart_stateCode
                    ),
                    array_fill_keys(
                        array_keys($cbcart_body_param_array2, $cbcart_billingcountry_var),
                        $cbcart_countryCode
                    ),
                    array_fill_keys(
                        array_keys($cbcart_body_param_array2, $cbcart_customernumber_var),
                        $cbcart_customernumber
                    ),
                    array_fill_keys(
                        array_keys($cbcart_body_param_array2, $cbcart_storeurl_var),
                        $cbcart_base_url
                    ),
                    array_fill_keys(
                        array_keys($cbcart_body_param_array, $cbcart_orderid_var),
                        $cbcart_order_id
                    )
                );

                if ($cbcart_checkplan === "1" || $cbcart_checkplan === "3") {
                    $cbcart_option_name ="cbcart_order_customer";
                    $cbcart_component = cbcart::cbcart_build_components($cbcart_option_name,$cbcart_body_param_array2,$cbcart_is_button_url_2_msg2);

                    $cbcart_language = array( "code" => $cbcart_temp_language2 );
                    $cbcart_template = array(
                        "language"   => $cbcart_language,
                        "name"       => $cbcart_temp_name2,
                        "apicomponents" => $cbcart_component
                    );
                    // call api to send test message
                    $cbcart_data_decoded = array(
                        "username"  => $cbcart_username,
                        "password" => $cbcart_password ,
                        "from" => $cbcart_from_number,
                        "to"=> $cbcart_customernumber,
                        "type"=> "template",
                        "template"=>$cbcart_template
                    );
                    $cbcart_data         = json_encode( $cbcart_data_decoded );
                    $cbcart_url          = esc_url( "https://api.whatso.net/v1/messages",'cartbox-messaging-widgets' );
                    $cbcart_response     = wp_remote_post(
                        $cbcart_url,
                        array(
                            'method'  => 'POST',
                            'headers' => array(
                                'Content-Type' => 'application/json',
                                'WPRequest'    => 'abach34h4h2h11h3h'
                            ),
                            'body'    => $cbcart_data
                        )
                    );
                    if ( is_array( $cbcart_response ) and isset( $cbcart_response['body'] ) ) {
                        $cbcart_response_obj = json_decode( $cbcart_response['body'] );
                        if ( is_object( $cbcart_response_obj ) ) {
                            $cbcart_insert_array = array(
                                'cbcart_user_type'            => 'customer',
                                'cbcart_message_api_request'  => $cbcart_data,
                                'cbcart_message_api_response' => wp_json_encode( $cbcart_response_obj ),
                            );
                            $wpdb->insert( $cbcart_order_table, $cbcart_insert_array );
                        }
                    }
                }

                if ( $cbcart_checkplan === "2" || $cbcart_checkplan === "4" )  {

                    $cbcart_language    = array( "code" => $cbcart_temp_language2 );
                    $cbcart_option_name ="cbcart_order_customer";
                    $cbcart_component = cbcart::cbcart_build_components($cbcart_option_name,$cbcart_body_param_array2,$cbcart_is_button_url_2_msg2);

                    $cbcart_template    = array(
                        "name"       => $cbcart_temp_name2,
                        "language"   => $cbcart_language,
                        "components" => $cbcart_component
                    );

                    // call api to send test message
                    $cbcart_data_decoded = array(
                        "messaging_product" => 'whatsapp',
                        "to"                => $cbcart_customernumber,
                        "type"              => 'template',
                        "template"          => $cbcart_template,
                    );

                    $cbcart_data         = json_encode( $cbcart_data_decoded );
                    $cbcart_url          = esc_url( "https://graph.facebook.com/v13.0/$cbcart_phone_noid/messages",'cartbox-messaging-widgets' );
                    $cbcart_response     = wp_remote_post(
                        $cbcart_url, array(
                            'method'  => 'POST',
                            'headers' => array(
                                'Content-Type'  => 'application/json',
                                'Authorization' => 'Bearer ' . $cbcart_bearer_token,
                            ),
                            'body'    => $cbcart_data
                        )
                    );

                    if ( is_array( $cbcart_response ) && isset( $cbcart_response['response'] ) ) {
                        $cbcart_response1= $cbcart_response['response'];
                        $cbcart_insert_array = array(
                            'cbcart_user_type'            => 'customer',
                            'cbcart_message_api_request'  => $cbcart_data,
                            'cbcart_message_api_response' => wp_json_encode( $cbcart_response ),
                        );
                        $wpdb->insert( $cbcart_order_table, $cbcart_insert_array );
                    }
                }
            }

        }

        /**
         * Function to get user plan and update settings
         *
         * @since     1.0.0
         * @version   1.0.0
         * @return null
         */
        public static function cbcart_update_user_settings_plugin() {

            // get user plan from credentials
            if ( ! empty( get_option( 'cbcart_userplan' ) ) ) {
                $cbcart_data                               = get_option( 'cbcart_userplan' );
                $cbcart_data                               = json_decode( $cbcart_data );
                $cbcart_data  = sanitize_option("cbcart_userplan", $cbcart_data);

                if(property_exists($cbcart_data,'response_code')) {
                    $cbcart_response_code = $cbcart_data->response_code;
                } else {
                    $cbcart_response_code ="";
                }
                $cbcart_message                            = $cbcart_data->message;
                $cbcart_loginLink                          = $cbcart_data->loginLink;
                $cbcart_iscartboxDesktopSoftwarePurchased   = $cbcart_data->iscartboxDesktopSoftwarePurchased;
                $cbcart_cartboxDesktopSoftwarePurchasedPlan = $cbcart_data->cartboxDesktopSoftwarePurchasedPlan;
                $cbcart_isAbandonedCartPurchased           = $cbcart_data->isAbandonedCartPurchased;
                $cbcart_abandonedCartPurchasedPlan         = $cbcart_data->abandonedCartPurchasedPlan;
                $cbcart_isAPIPurchased                     = $cbcart_data->isAPIPurchased;
                $cbcart_apiPurchasedPlan                   = $cbcart_data->apiPurchasedPlan;
                $cbcart_isSMSPurchased                     = $cbcart_data->isSMSPurchased;
                $cbcart_smsPurchasedPlan                   = $cbcart_data->smsPurchasedPlan;

                $cbcart_allinoneplan="true";
                if($cbcart_allinoneplan!="true") {
                    if ($cbcart_isAPIPurchased == "true") {
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
                            'cbcart_loginlink' => $cbcart_loginLink,
                            'cbcart_planid' => '3'
                        );
                        $cbcart_result = update_option('cbcart_usersettings', wp_json_encode($cbcart_update_user_settings));
                    } else if ($cbcart_isAbandonedCartPurchased == "true") {
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
                            'cbcart_loginlink' => $cbcart_loginLink,
                            'cbcart_planid' => '2'
                        );
                        $cbcart_result = update_option('cbcart_usersettings', wp_json_encode($cbcart_update_user_settings));
                    } else {
                        $cbcart_update_user_settings = array(
                            'cbcart_isOrderNotificationToAdmin' => "true",
                            'cbcart_isCustomizeMessageToAdmin' => "false",
                            'cbcart_isOrderNotificationToCustomer' => "true",
                            'cbcart_isCustomizMessageToCustomer' => "false",
                            'cbcart_isCustomizMessageOfAbandoned' => "false",
                            'cbcart_multiple_messages' => '5',
                            'cbcart_isMessageFromAdminNumber' => "false",
                            'cbcart_official_number' => '9016243183',
                            'cbcart_isDisplayReport' => "false",
                            'cbcart_loginlink' => $cbcart_loginLink,
                            'cbcart_planid' => '1'
                        );
                        $cbcart_result = update_option('cbcart_usersettings', wp_json_encode($cbcart_update_user_settings));
                    }
                }else{
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
                        'cbcart_loginlink' => $cbcart_loginLink,
                        'cbcart_planid' => '2'
                    );
                    $cbcart_result = update_option('cbcart_usersettings', wp_json_encode($cbcart_update_user_settings));
                }

            }
        }

        /**
         * Check for country code.
         *
         * @version 3.0.4
         * @since     1.0.0
         * @param country code,number
         * @return    string mobile number with country code.
         */
        public function cbcart_check_country( $cbcart_country_code, $cbcart_number ) {

            // check for country code and return mobile number with country code
            if ( $cbcart_country_code == "GB" ) // united kingdom
            {
                $cbcart_number = $this->cbcart_mobile_number_validation( 10, 44, $cbcart_number );
            } elseif ( $cbcart_country_code == "AT" ) // Australia
            {
                $cbcart_number = $this->cbcart_mobile_number_validation( 10, 61, $cbcart_number );
            } elseif ( $cbcart_country_code == "US" ) // United Status
            {
                $cbcart_number = $this->cbcart_mobile_number_validation( 10, 1, $cbcart_number );
            } elseif ( $cbcart_country_code == "RU" ) // Russia
            {
                $cbcart_number = $this->cbcart_mobile_number_validation( 10, 7, $cbcart_number );
            } elseif ( $cbcart_country_code == "IT" ) //Italy
            {
                $cbcart_number = $this->cbcart_mobile_number_validation( 10, 39, $cbcart_number );
            } elseif ( $cbcart_country_code == "IN" ) //India
            {
                $cbcart_number = $this->cbcart_mobile_number_validation( 10, 91, $cbcart_number );
            } elseif ( $cbcart_country_code == "IR" ) // Iran
            {
                $cbcart_number = $this->cbcart_mobile_number_validation( 10, 98, $cbcart_number );
            } elseif ( $cbcart_country_code == "CA" ) // Canada
            {
                $cbcart_number = $this->cbcart_mobile_number_validation( 10, 1, $cbcart_number );
            } elseif ( $cbcart_country_code == "ZA" ) // South Africa
            {
                $cbcart_number = $this->cbcart_mobile_number_validation( 9, 27, $cbcart_number );
            } elseif ( $cbcart_country_code == "BR" ) // Brazil
            {
                $cbcart_number = $this->cbcart_mobile_number_validation( 11, 55, $cbcart_number );
            } elseif ( $cbcart_country_code == "CN" ) // China
            {
                $cbcart_number = $this->cbcart_mobile_number_validation( 11, 86, $cbcart_number );
            } elseif ( $cbcart_country_code == "ID" ) // Indonesia
            {
                $cbcart_number = $this->cbcart_mobile_number_validation( 10, 62, $cbcart_number );
            } elseif ( $cbcart_country_code == "PK" ) // Pakistan
            {
                $cbcart_number = $this->cbcart_mobile_number_validation( 10, 92, $cbcart_number );
            } elseif ( $cbcart_country_code == "NG" ) // Nigeria
            {
                $cbcart_number = $this->cbcart_mobile_number_validation( 8, 234, $cbcart_number );
            } elseif ( $cbcart_country_code == "BD" ) // Bangladesh
            {
                $cbcart_number = $this->cbcart_mobile_number_validation( 10, 880, $cbcart_number );
            } elseif ( $cbcart_country_code == "MX" ) // Mexico
            {
                $cbcart_number = $this->cbcart_mobile_number_validation( 10, 52, $cbcart_number );
            } elseif ( $cbcart_country_code == "JP" ) // japan
            {
                $cbcart_number = $this->cbcart_mobile_number_validation( 10, 81, $cbcart_number );
            } elseif ( $cbcart_country_code == "ET" ) // Ethiopia
            {
                $cbcart_number = $this->cbcart_mobile_number_validation( 9, 251, $cbcart_number );
            } elseif ( $cbcart_country_code == "PH" ) // Phillipines
            {
                $cbcart_number = $this->cbcart_mobile_number_validation( 10, 63, $cbcart_number );
            } elseif ( $cbcart_country_code == "EG" ) // Egypt
            {
                $cbcart_number = $this->cbcart_mobile_number_validation( 10, 20, $cbcart_number );
            } elseif ( $cbcart_country_code == "VN" ) // Vietnam
            {
                $cbcart_number = $this->cbcart_mobile_number_validation( 9, 84, $cbcart_number );
            } elseif ( $cbcart_country_code == "DE" ) // Germany
            {
                $cbcart_number = $this->cbcart_mobile_number_validation( 10, 49, $cbcart_number );
            } elseif ( $cbcart_country_code == "TR" ) // Turkey
            {
                $cbcart_number = $this->cbcart_mobile_number_validation( 11, 90, $cbcart_number );
            } elseif ( $cbcart_country_code == "TH" ) // Thailand
            {
                $cbcart_number = $this->cbcart_mobile_number_validation( 9, 66, $cbcart_number );
            } elseif ( $cbcart_country_code == "FR" ) // France
            {
                $cbcart_number = $this->cbcart_mobile_number_validation( 9, 33, $cbcart_number );
            } elseif ( $cbcart_country_code == "IT" ) // Italy
            {
                $cbcart_number = $this->cbcart_mobile_number_validation( 13, 39, $cbcart_number );
            } elseif ( $cbcart_country_code == "TZ" ) // Tanzania
            {
                $cbcart_number = $this->cbcart_mobile_number_validation( 9, 255, $cbcart_number );
            } elseif ( $cbcart_country_code == "ES" ) // Spain
            {
                $cbcart_number = $this->cbcart_mobile_number_validation( 9, 34, $cbcart_number );
            } elseif ( $cbcart_country_code == "MM" ) // Myanmar
            {
                $cbcart_number = $this->cbcart_mobile_number_validation( 10, 95, $cbcart_number );
            } elseif ( $cbcart_country_code == "KE" ) // kenya
            {
                $cbcart_number = $this->cbcart_mobile_number_validation( 10, 254, $cbcart_number );
            } elseif ( $cbcart_country_code == "UG" ) // Uganda
            {
                $cbcart_number = $this->cbcart_mobile_number_validation( 9, 256, $cbcart_number );
            } elseif ( $cbcart_country_code == "AR" ) // Argentina
            {
                $cbcart_number = $this->cbcart_mobile_number_validation( 9, 54, $cbcart_number );
            } elseif ( $cbcart_country_code == "DZ" ) // Algeria
            {
                $cbcart_number = $this->cbcart_mobile_number_validation( 9, 213, $cbcart_number );
            } elseif ( $cbcart_country_code == "SD" ) // Sudan
            {
                $cbcart_number = $this->cbcart_mobile_number_validation( 9, 249, $cbcart_number );
            } elseif ( $cbcart_country_code == "AF" ) // Afghanistan
            {
                $cbcart_number = $this->cbcart_mobile_number_validation( 9, 93, $cbcart_number );
            } elseif ( $cbcart_country_code == "PL" ) // Poland
            {
                $cbcart_number = $this->cbcart_mobile_number_validation( 9, 48, $cbcart_number );
            } elseif ( $cbcart_country_code == "SA" ) // Saudi Arabia
            {
                $cbcart_number = $this->cbcart_mobile_number_validation( 9, 966, $cbcart_number );
            } elseif ( $cbcart_country_code == "PE" ) // Peru
            {
                $cbcart_number = $this->cbcart_mobile_number_validation( 9, 51, $cbcart_number );
            } elseif ( $cbcart_country_code == "MY" ) // Malaysia
            {
                $cbcart_number = $this->cbcart_mobile_number_validation( 7, 60, $cbcart_number );
            } elseif ( $cbcart_country_code == "MZ" ) // Mozambique
            {
                $cbcart_number = $this->cbcart_mobile_number_validation( 12, 258, $cbcart_number );
            } elseif ( $cbcart_country_code == "GH" ) // Ghana
            {
                $cbcart_number = $this->cbcart_mobile_number_validation( 9, 233, $cbcart_number );
            } elseif ( $cbcart_country_code == "YE" ) // Yemen
            {
                $cbcart_number = $this->cbcart_mobile_number_validation( 9, 967, $cbcart_number );
            } elseif ( $cbcart_country_code == "VE" ) // Venezuela
            {
                $cbcart_number = $this->cbcart_mobile_number_validation( 7, 58, $cbcart_number );
            } else {
                $cbcart_number = $this->cbcart_mobile_number_validation_without_country( $cbcart_number );
            }
            return $cbcart_number;
        }

        /**
         * Check for valid mobile number.
         *
         * @version   1.0.0
         * @since     1.0.0
         * @param     countycodelength,countrycode,customernumber
         * @return    string $cbcart_customernumber.
         */
        public function cbcart_mobile_number_validation( $cbcart_countrynumberlength, $cbcart_countrycode, $cbcart_customernumber ) {

            // check if mobilenumber is equals to country number length
            if ( strlen( $cbcart_customernumber ) === $cbcart_countrynumberlength ) {
                $cbcart_customernumber = $cbcart_countrycode . $cbcart_customernumber;
            } elseif ( strlen( $cbcart_customernumber ) === $cbcart_countrynumberlength - 1 ) {
                $cbcart_customernumber = "";
            } elseif ( strlen( $cbcart_customernumber ) == $cbcart_countrynumberlength + 1 ) {
                $cbcart_result = substr( $cbcart_customernumber, 0, 1 );
                if ( ( $cbcart_result == "0" ) || ( $cbcart_result == $cbcart_countrycode ) ) {
                    $cbcart_customernumber = substr( $cbcart_customernumber, 1, $cbcart_countrynumberlength );
                    $cbcart_customernumber = $cbcart_countrycode . $cbcart_customernumber;
                } else {
                    $cbcart_customernumber = "";
                }
            } elseif ( strlen( $cbcart_customernumber ) == $cbcart_countrynumberlength + 2 ) {
                $cbcart_result = substr( $cbcart_customernumber, 0, 2 );
                if ( strcmp( $cbcart_result, $cbcart_countrycode ) ) {
                    $cbcart_customernumber = "";
                }
            } elseif ( strlen( $cbcart_customernumber ) == $cbcart_countrynumberlength + 3 ) {
                $cbcart_result = substr( $cbcart_customernumber, 0, 3 );

                // compare number
                if ( strcmp( $cbcart_result, $cbcart_countrycode ) ) {
                    $cbcart_customernumber = "";
                }
            } elseif ( strlen( $cbcart_customernumber ) >= $cbcart_countrynumberlength + 4 ) {
                $cbcart_result = substr( $cbcart_customernumber, 0, 4 );

                // compare number
                if ( strcmp( $cbcart_result, $cbcart_countrycode ) ) {
                    $cbcart_customernumber = "";
                }
            }
            $cbcart_data                 = get_option( 'cbcart_adminsettings' );
            $cbcart_data                 = json_decode( $cbcart_data );
            $cbcart_data  = sanitize_option("cbcart_adminsettings", $cbcart_data);

            $cbcart_default_county_code  = $cbcart_data->cbcart_default_country;
            $cbcart_countrynumberlength1 = $cbcart_countrynumberlength + strlen( $cbcart_countrycode );

            if ( strlen( $cbcart_customernumber ) === $cbcart_countrynumberlength1 ) {
                return $cbcart_customernumber;
            } else {
                $cbcart_tempnumber = $cbcart_default_county_code . $cbcart_customernumber;
                if ( strlen( $cbcart_tempnumber ) == $cbcart_countrynumberlength1 ) {
                    $cbcart_customernumber = $cbcart_tempnumber;
                    return $cbcart_customernumber;
                }else{
                    $cbcart_customernumber="";
                }

            }
        }

        /**
         * check from number has no country code.
         *
         * @version   1.0.0
         * @since     1.0.0
         * @return    string $cbcart_customernumber.
         */
        public function cbcart_mobile_number_validation_without_country( $cbcart_customernumber ) {
            $cbcart_data                = get_option( 'cbcart_adminsettings' );
            $cbcart_data                = json_decode( $cbcart_data );
            $cbcart_data  = sanitize_option("cbcart_adminsettings", $cbcart_data);

            $cbcart_default_county_code = $cbcart_data->cbcart_default_country;
            $cbcart_customernumber      = $cbcart_default_county_code . $cbcart_customernumber;
            return $cbcart_customernumber;
        }

        /**
         * create template api and get list of all the templates .
         *
         * @version 3.0.4
         * @since     1.0.0
         * @return    string response.
         */
        public static function cbcart_createtemplates($cbcart_default_link) {

            //get template to check if template already exist
            $cbcart = new cbcart();
            $get_template = $cbcart::cbcart_get_templates();
            $cbcart_default_link = rtrim($cbcart_default_link, '/');
            global $wpdb;
            $table_prefix = $wpdb->prefix;
            $cbcart_table_name = 'cbcart_template';
            $cbcart_template_table = $table_prefix . "$cbcart_table_name";
            $cbcart_abandond     = cbcart_cart_awaits;
            $cbcart_order = cbcart_order_notify;
            $cbcart_contact =cbcart_contact_form;

            //for abandonedcart template 1
            $cbcart_template_name1="";
            $cbcart_template_name = "cbcart_wp_abandoned_cart_new_1";
            $cbcart_temp_data = $wpdb->get_results($wpdb->prepare("SELECT cbcart_template_name,cbcart_template_language FROM $cbcart_template_table WHERE cbcart_template_name  = %s",$cbcart_template_name)); //db call ok; no-cache ok
           if($cbcart_temp_data != null) {
               foreach ($cbcart_temp_data as $cbcart_template_name) {
                   $cbcart_template_name1 = $cbcart_template_name->cbcart_template_name;
                   $cbcart_template_language = $cbcart_template_name->cbcart_template_language;
               }
           }else{
                $cbcart_template_name1="";
                $cbcart_template_language="";
           }
            if ($cbcart_template_name1 == "cbcart_wp_abandoned_cart_new_1" && $cbcart_template_language == "en_US") {
                printf(
                    esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                    esc_html($cbcart_template_name1)
                );

            } else {
                $cbcart_create_template = $cbcart::cbcart_create_wp_abandoned_cart_new_1($cbcart_default_link);
            }
            //for abandonedcart template 2
            $cbcart_template_name = "cbcart_wp_abandoned_cart_new_2";
            $cbcart_temp_data = $wpdb->get_results($wpdb->prepare("SELECT cbcart_template_name,cbcart_template_language FROM $cbcart_template_table WHERE cbcart_template_name  = %s",$cbcart_template_name)); //db call ok; no-cache ok
            if($cbcart_temp_data != null) {
                foreach ($cbcart_temp_data as $cbcart_template_name) {
                    $cbcart_template_name1 = $cbcart_template_name->cbcart_template_name;
                    $cbcart_template_language = $cbcart_template_name->cbcart_template_language;
                }
            }else{
                $cbcart_template_name1="";
                $cbcart_template_language="";
            }
            if ($cbcart_template_name1 == "cbcart_wp_abandoned_cart_new_2" && $cbcart_template_language == "en_US") {
                printf(
                    esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                    esc_html($cbcart_template_name1)
                );

            } else {
                $cbcart_create_template = $cbcart::cbcart_create_wp_abandoned_cart_new_2($cbcart_default_link);
            }
            //for abandonedcart template 3
            $cbcart_template_name = "cbcart_wp_abandoned_cart_new_3";
            $cbcart_temp_data = $wpdb->get_results($wpdb->prepare("SELECT cbcart_template_name,cbcart_template_language FROM $cbcart_template_table WHERE cbcart_template_name  = %s",$cbcart_template_name)); //db call ok; no-cache ok
            if($cbcart_temp_data != null) {
                foreach ($cbcart_temp_data as $cbcart_template_name) {
                    $cbcart_template_name1 = $cbcart_template_name->cbcart_template_name;
                    $cbcart_template_language = $cbcart_template_name->cbcart_template_language;
                }
            }else{
                $cbcart_template_name1="";
                $cbcart_template_language="";
            }
            if ($cbcart_template_name1 == "cbcart_wp_abandoned_cart_new_3" && $cbcart_template_language == "en_US") {

                printf(
                    esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                    esc_html($cbcart_template_name1)
                );

            } else {
                $cbcart_create_template = $cbcart::cbcart_create_wp_abandoned_cart_new_3($cbcart_default_link);
            }
            //for abandonedcart template 4
            $cbcart_template_name = "cbcart_wp_abandoned_cart_new_4";
            $cbcart_temp_data = $wpdb->get_results($wpdb->prepare("SELECT cbcart_template_name,cbcart_template_language FROM $cbcart_template_table WHERE cbcart_template_name  = %s",$cbcart_template_name)); //db call ok; no-cache ok
            if($cbcart_temp_data != null) {
                foreach ($cbcart_temp_data as $cbcart_template_name) {
                    $cbcart_template_name1 = $cbcart_template_name->cbcart_template_name;
                    $cbcart_template_language = $cbcart_template_name->cbcart_template_language;
                }
            }else{
                $cbcart_template_name1="";
                $cbcart_template_language="";
            }
            if ($cbcart_template_name1 == "cbcart_wp_abandoned_cart_new_4" && $cbcart_template_language == "en_US") {
                printf(
                    esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                    esc_html($cbcart_template_name1)
                );

            } else {
                $cbcart_create_template = $cbcart::cbcart_create_wp_abandoned_cart_new_4($cbcart_default_link);
            }
            //for abandonedcart template 5
            $cbcart_template_name = "cbcart_wp_abandoned_cart_new_5";
            $cbcart_temp_data = $wpdb->get_results($wpdb->prepare("SELECT cbcart_template_name,cbcart_template_language FROM $cbcart_template_table WHERE cbcart_template_name  = %s",$cbcart_template_name)); //db call ok; no-cache ok
            if($cbcart_temp_data != null) {
                foreach ($cbcart_temp_data as $cbcart_template_name) {
                    $cbcart_template_name1 = $cbcart_template_name->cbcart_template_name;
                    $cbcart_template_language = $cbcart_template_name->cbcart_template_language;
                }
            }else{
                $cbcart_template_name1="";
                $cbcart_template_language="";
            }
            if ($cbcart_template_name1 == "cbcart_wp_abandoned_cart_new_5" && $cbcart_template_language == "en_US") {

                printf(
                    esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                    esc_html($cbcart_template_name1)
                );

            } else {
                $cbcart_create_template = $cbcart::cbcart_create_wp_abandoned_cart_new_5($cbcart_default_link);
            }
            //for order notification to customer
            $cbcart_template_name = "cbcart_wp_order_notifs_customer_new_1";
            $cbcart_temp_data = $wpdb->get_results($wpdb->prepare("SELECT cbcart_template_name,cbcart_template_language FROM $cbcart_template_table WHERE cbcart_template_name  = %s",$cbcart_template_name)); //db call ok; no-cache ok
            if($cbcart_temp_data != null) {
                foreach ($cbcart_temp_data as $cbcart_template_name) {
                    $cbcart_template_name1 = $cbcart_template_name->cbcart_template_name;
                    $cbcart_template_language = $cbcart_template_name->cbcart_template_language;
                }
            }else{
                $cbcart_template_name1="";
                $cbcart_template_language="";
            }
            if ($cbcart_template_name1 == "cbcart_wp_order_notifs_customer_new_1" && $cbcart_template_language == "en_US") {
                printf(
                    esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                    esc_html($cbcart_template_name1)
                );

            } else {
                $cbcart_create_template = $cbcart::cbcart_create_wp_order_notifs_customer_new_1($cbcart_default_link);
            }
            //for order notification to admin
            $cbcart_template_name = "cbcart_wp_order_notifs_admin_new_1";
            $cbcart_temp_data = $wpdb->get_results($wpdb->prepare("SELECT cbcart_template_name,cbcart_template_language FROM $cbcart_template_table WHERE cbcart_template_name  = %s",$cbcart_template_name)); //db call ok; no-cache ok
            if($cbcart_temp_data != null) {
                foreach ($cbcart_temp_data as $cbcart_template_name) {
                    $cbcart_template_name1 = $cbcart_template_name->cbcart_template_name;
                    $cbcart_template_language = $cbcart_template_name->cbcart_template_language;
                }
            }else{
                $cbcart_template_name1="";
                $cbcart_template_language="";
            }
            if ($cbcart_template_name1 == "cbcart_wp_order_notifs_admin_new_1" && $cbcart_template_language == "en_US") {
                printf(
                    esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                    esc_html($cbcart_template_name1)
                );

            } else {
                $cbcart_create_template = $cbcart::cbcart_create_wp_order_notifs_admin_new_1($cbcart_default_link);
            }
            //for contact form 7 notification
            $cbcart_template_name = "cbcart_wp_cf7_new_1";
            $cbcart_temp_data = $wpdb->get_results($wpdb->prepare("SELECT cbcart_template_name,cbcart_template_language FROM $cbcart_template_table WHERE cbcart_template_name  = %s",$cbcart_template_name)); //db call ok; no-cache ok

            if($cbcart_temp_data != null) {
                foreach ($cbcart_temp_data as $cbcart_template_name) {
                    $cbcart_template_name1 = $cbcart_template_name->cbcart_template_name;
                    $cbcart_template_language = $cbcart_template_name->cbcart_template_language;
                }
            }else{
                $cbcart_template_name1="";
                $cbcart_template_language="";
            }
            if ($cbcart_template_name1 == "cbcart_wp_cf7_new_1" && $cbcart_template_language == "en_US") {
                printf(
                    esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                    esc_html($cbcart_template_name1)
                );

            } else {
                $cbcart_create_template = $cbcart::cbcart_create_wp_cf7_new_1();
            }
            //for contact form 7 notification for customer
            $cbcart_template_name = "cbcart_wp_cf7_new_1";
            $cbcart_temp_data = $wpdb->get_results($wpdb->prepare("SELECT cbcart_template_name,cbcart_template_language FROM $cbcart_template_table WHERE cbcart_template_name  = %s",$cbcart_template_name)); //db call ok; no-cache ok

            if($cbcart_temp_data != null) {
                foreach ($cbcart_temp_data as $cbcart_template_name) {
                    $cbcart_template_name1 = $cbcart_template_name->cbcart_template_name;
                    $cbcart_template_language = $cbcart_template_name->cbcart_template_language;
                }
            }else{
                $cbcart_template_name1="";
                $cbcart_template_language="";
            }
            if ($cbcart_template_name1 == "cbcart_wp_cf7_customer" && $cbcart_template_language == "en_US") {
                printf(
                    esc_html__( ' %s ', 'cartbox-messaging-widgets' ),
                    esc_html($cbcart_template_name1)
                );
            } else {
                $cbcart_create_template = $cbcart::cbcart_create_wp_cf7_customer_new_1();
            }
            $cbcart_update_notifications_arr = array(
                'responsecode'=>"200",
            );
            $cbcart_result       = update_option( 'cbcart_createtemplates', wp_json_encode( $cbcart_update_notifications_arr ) );

            $cbcart_contactform7_text_customer="Thank you for submitting the form!\n\nWe have received your information and will process it shortly.\n\nIf you have any further questions or concerns, please don't hesitate to contact us.\n\nHave a great day!";
            $cbcart_contactform7_text="A new contact form inquiry is received from \r\n\r\nName: {{customername}}.\r\n\r\nThe details of message are: {{customerdetails}}\r\n\r\n{{StoreName}}.";
            $cbcart_abandoned_1="Hi {{customername}},\n\n📢 We noticed you didn't finish your order on {{storename}}.\n\nVisit now to complete your order.\n\n{{storename}}\n\nThanks.\n\n{{checkoutlink}}";
            $cbcart_abandoned_2="Hey {{customername}},\n\nYou left some items in your cart!🛒\n\nWe wanted to make sure you had the chance to get what you needed.\n\n{{checkoutlink}}";
            $cbcart_abandoned_3="Hey {{customername}},\n\nWe see you left a few items in the cart at {{storename}}\n\nYour items are waiting for you! Grab your favorites before they go out of stock.\n\nYour friends from {{storename}}.\n\nThanks.\n\n{{checkoutlink}}";
            $cbcart_abandoned_4="Hi {{customername}},\n\nYour cart is waiting for you at {{storename}}\n\nComplete your purchase before someone else buys them!\n\nClick {{siteurl}} to finish your order now.\n\n{{storename}}\n\nThanks.\n\n{{checkoutlink}}";
            $cbcart_abandoned_5="Hello {{customername}},\n\nDid you forget to complete your order on {{storename}}?\n\nClick the link to finish the order now!\n\nYour friends from {{storename}}.\n\nThanks.\n\n{{checkoutlink}}";
            $cbcart_order_admin="Hi,\n\nAn order is placed on {{storename}} at {{siteurl}}\n\nThe order is for {{productname}}\n\nand the order amount is {{orderamount}}\n\nCustomer details are: {{customeremail}}\n\nThanks.";
            $cbcart_order_customer="Hi {{customername}},\n\nYour {{productname}} order of {{amount}} is placed.\n\nWe will keep you updated about your order status.\n\n{siteurl}";
            $cbcart_abandoned_image= $cbcart_abandond;
            $cbcart_order_image= $cbcart_order;

            $cbcart_update_notifications_arr = array(
                'cbcart_trigger_time'=>"30",
                'cbcart_time1'=>"cbcart_select_minute",
                'cbcart_ac_enable'=>"checked",
                'cbcart_ac_message'    =>  $cbcart_abandoned_1,
                'cbcart_ac_template_name'=> "cbcart_wp_abandoned_cart_new_1",
                'cbcart_ac_template_lang'=> "en_US",
                'cbcart_ac_template_varcount'=> "3",
                'cbcart_ac_message2' => $cbcart_abandoned_2,
                'cbcart_ac_template2_name'=>"cbcart_wp_abandoned_cart_new_2",
                'cbcart_ac_template2_lang'=>   "en_US",
                'cbcart_ac_template2_varcount'=> "1",
                'cbcart_ac_message3'=>  $cbcart_abandoned_3,
                'cbcart_ac_template3_name'=>"cbcart_wp_abandoned_cart_new_3",
                'cbcart_ac_template3_lang'=>  "en_US",
                'cbcart_ac_template3_varcount'=> "3",
                'cbcart_ac_message4' => $cbcart_abandoned_4,
                'cbcart_ac_template4_name'=>"cbcart_wp_abandoned_cart_new_4",
                'cbcart_ac_template4_lang'=>  "en_US",
                'cbcart_ac_template4_varcount'=> "4",
                'cbcart_ac_message5' => $cbcart_abandoned_5,
                'cbcart_ac_template5_name'=>"cbcart_wp_abandoned_cart_new_5",
                'cbcart_ac_template5_lang'=> "en_US",
                'cbcart_ac_template5_varcount'=> "3",
                'cbcart_abandoned_image'=>$cbcart_abandoned_image,
                'cbcart_trigger_time2'         => "",
                'cbcart_time2'                 => "",
                'cbcart_trigger_time3'         => "",
                'cbcart_time3'                 => "",
                'cbcart_trigger_time4'         => "",
                'cbcart_time4'                 => "",
                'cbcart_trigger_time5'         => "",
                'cbcart_time5'                 => "",
                'cbcart_message1_enable'       => "",
                'cbcart_message2_enable'       => "",
                'cbcart_message3_enable'       => "",
                'cbcart_message4_enable'       => "",
                'cbcart_message5_enable'       => "",

            );
            $cbcart_result2 = update_option( 'cbcart_abandonedsettings', wp_json_encode( $cbcart_update_notifications_arr ) );

            $cbcart_update_notifications_arr = array(
                'cbcart_admin_message'    =>  	$cbcart_order_admin,
                'cbcart_admin_template_name'    => "cbcart_wp_order_notifs_admin_new_1",
                'cbcart_admin_template_lang'    => "en_US",
                'cbcart_admin_template_varcount'    => "5",
                'cbcart_customer_message' => $cbcart_order_customer,
                'cbcart_customer_template_name'    => "cbcart_wp_order_notifs_customer_new_1",
                'cbcart_customer_template_lang'    => "en_US",
                'cbcart_customer_template_varcount'    => "3",
                'cbcart_customer_notification' =>'0',
                'cbcart_admin_notification' =>'0',
                'cbcart_order_image'=>$cbcart_order_image,
                'cbcart_admin_mobileno'             => "",
                'cbcart_is_order_completed'         =>"0",
                'cbcart_is_order_processing'         =>"1",
                'cbcart_is_order_payment_done'         =>"0",
            );
            $cbcart_result3 = update_option( 'cbcart_ordernotificationsettings', wp_json_encode( $cbcart_update_notifications_arr ) );

            $cbcart_update_notifications_arr = array(
                'cbcart_cf7admin_mobileno'   =>  "",
                'cbcart_cf7admin_template_name'   =>  "cbcart_wp_cf7_new_1",
                'cbcart_cf7admin_template_language'   =>"en_US",
                'cbcart_cf7admin_template_varcount'   =>"3",
                'cbcart_cf7admin_message'    =>  $cbcart_contactform7_text ,
                'cbcart_cf7enable_notification' => "0",
                'cbcart_cf7customer_template_name'   =>  "cbcart_wp_cf7_customer",
                'cbcart_cf7customer_template_language'   =>"en_US",
                'cbcart_cf7customer_template_varcount'   =>"0",
                'cbcart_cf7customer_message'    =>  $cbcart_contactform7_text_customer ,
                'cbcart_cf7customer_notification' => "0",
            );
            $cbcart_result1 = update_option( 'cbcart_contactformsettings', wp_json_encode( $cbcart_update_notifications_arr ) );

        }

        /**
         * create template for abandoned cart message 1
         *
         * @version 3.0.4
         * @since     1.0.0
         * @return    string response.
         */
        public static function cbcart_create_wp_abandoned_cart_new_1($cbcart_default_link) {
            $cbcart_data = get_option('cbcart_premiumsettings');
            $cbcart_data = json_decode($cbcart_data);
            $cbcart_data  = sanitize_option("cbcart_premiumsettings", $cbcart_data);

            $cbcart_token = $cbcart_data->cbcart_token;
            $cbcart_wabaid = $cbcart_data->cbcart_wabaid;
            $cbcart_store_name            = get_bloginfo( 'name' );

            $body_text[] = array("alexa");
            $cbcart_example = array("body_text" => $body_text, "header_handle" => null);
            $cbcart_component_text = array("type" => "BODY", "text" => "Hi {{1}},\n\n📢 We noticed you didn't finish your order on $cbcart_store_name.\n\nVisit now to complete your order.\n\n$cbcart_default_link\n\nThanks."
            , "format" => null, "example" => $cbcart_example, "buttons" => null);
            $cbcart_button[0] = array("type" => "URL", "text" => "complete your order","example" => $cbcart_default_link, "url" => $cbcart_default_link."/{{1}}");
            $cbcart_component_button = array("type" => "BUTTONS", "text" => null, "format" => null, "example" => null,
                "buttons" => $cbcart_button);
            $cbcart_component2[0] = $cbcart_component_text;
            $cbcart_component2[1] = $cbcart_component_button;
            $cbcart_component2 = wp_json_encode($cbcart_component2);
            $cbcart_url = "https://graph.facebook.com/v14.0/$cbcart_wabaid/message_templates?name=cbcart_wp_abandoned_cart_new_1&language=en_US&category=UTILITY&components=$cbcart_component2&access_token=$cbcart_token";
            $cbcart_response = wp_remote_post($cbcart_url);
            $cbcart_response = json_decode($cbcart_response['body']);
            $cbcart_result2       = update_option( 'cbcart_create_wp_abandoned_cart_new_1',wp_json_encode($cbcart_response));
            return $cbcart_response;
        }
        /**
         * create template for abandoned cart message 2
         *
         * @version 3.0.4
         * @since     1.0.0
         * @return    string response.
         */
        public static function cbcart_create_wp_abandoned_cart_new_2($cbcart_default_link) {
            $cbcart_data = get_option('cbcart_premiumsettings');
            $cbcart_data = json_decode($cbcart_data);
            $cbcart_data  = sanitize_option("cbcart_premiumsettings", $cbcart_data);

            $cbcart_token = $cbcart_data->cbcart_token;
            $cbcart_wabaid = $cbcart_data->cbcart_wabaid;

            //create_template API
            $body_text[] = array("alexa");
            $cbcart_example = array("body_text" => $body_text, "header_handle" => null);
            $cbcart_component_text = array("type" => "BODY", "text" => "Hey {{1}},\n\nYou left some items in your cart!🛒\n\nWe wanted to make sure you had the chance to get what you needed."
            , "format" => null, "example" => $cbcart_example, "buttons" => null);
            $cbcart_button[0] = array("type" => "URL", "text" => "complete your order","example" => $cbcart_default_link, "url" => $cbcart_default_link."/{{1}}");
            $cbcart_component_button = array("type" => "BUTTONS", "text" => null, "format" => null, "example" => null,
                "buttons" => $cbcart_button);
            $cbcart_component2[0] = $cbcart_component_text;
            $cbcart_component2[1] = $cbcart_component_button;
            $cbcart_component2 = wp_json_encode($cbcart_component2);
            $cbcart_url = "https://graph.facebook.com/v14.0/$cbcart_wabaid/message_templates?name=cbcart_wp_abandoned_cart_new_2&language=en_US&category=UTILITY&components=$cbcart_component2&access_token=$cbcart_token";
            $cbcart_response = wp_remote_post($cbcart_url);
            $cbcart_result2       = update_option( 'cbcart_create_wp_abandoned_cart_new_2',wp_json_encode($cbcart_response));
            $cbcart_response = json_decode($cbcart_response['body']);
            return $cbcart_response;
        }
        /**
         * create template for abandoned cart message 3
         *
         * @version 3.0.4
         * @since     1.0.0
         * @return    string response.
         */
        public static function cbcart_create_wp_abandoned_cart_new_3($cbcart_default_link) {
            $cbcart_data = get_option('cbcart_premiumsettings');
            $cbcart_data = json_decode($cbcart_data);
            $cbcart_data  = sanitize_option("cbcart_premiumsettings", $cbcart_data);

            $cbcart_token = $cbcart_data->cbcart_token;
            $cbcart_wabaid = $cbcart_data->cbcart_wabaid;
            $cbcart_store_name            = get_bloginfo( 'name' );
            //create_template API
            $body_text[] = array("alexa","test");
            $cbcart_example = array("body_text" => $body_text, "header_handle" => null);
            $cbcart_component_text = array("type" => "BODY", "text" => "Hey {{1}},\n\nWe see you left a few items in the cart at $cbcart_store_name\n\nYour items are waiting for you! Grab your favorites before they go out of stock.\n\nYour friends from {{2}}.\n\nThanks."
            , "format" => null, "example" => $cbcart_example, "buttons" => null);
            $cbcart_button[0] = array("type" => "URL", "text" => "complete your order", "example" => $cbcart_default_link, "url" => $cbcart_default_link."/{{1}}");
            $cbcart_component_button = array("type" => "BUTTONS", "text" => null, "format" => null, "example" => null,
                "buttons" => $cbcart_button);
            $cbcart_component2[0] = $cbcart_component_text;
            $cbcart_component2[1] = $cbcart_component_button;
            $cbcart_component2 = wp_json_encode($cbcart_component2);
            $cbcart_url = "https://graph.facebook.com/v14.0/$cbcart_wabaid/message_templates?name=cbcart_wp_abandoned_cart_new_3&language=en_US&category=UTILITY&components=$cbcart_component2&access_token=$cbcart_token";
            $cbcart_response = wp_remote_post($cbcart_url);
            $cbcart_result2       = update_option( 'cbcart_create_wp_abandoned_cart_new_3',wp_json_encode($cbcart_response));
            $cbcart_response = json_decode($cbcart_response['body']);
            return $cbcart_response;
        }
        /**
         * create template for abandoned cart message 4
         *
         * @version 3.0.4
         * @since     1.0.0
         * @return    string response.
         */
        public static function cbcart_create_wp_abandoned_cart_new_4($cbcart_default_link) {
            $cbcart_data = get_option('cbcart_premiumsettings');
            $cbcart_data = json_decode($cbcart_data);
            $cbcart_data  = sanitize_option("cbcart_premiumsettings", $cbcart_data);

            $cbcart_token = $cbcart_data->cbcart_token;
            $cbcart_wabaid = $cbcart_data->cbcart_wabaid;
            $cbcart_store_name            = get_bloginfo( 'name' );
            //create_template API
            $body_text[] = array("alexa");
            $cbcart_example = array("body_text" => $body_text, "header_handle" => null);
            $cbcart_component_text = array("type" => "BODY", "text" => "Hi {{1}},\n\nYour cart is waiting for you at $cbcart_store_name\n\nComplete your purchase before someone else buys them!\n\nClick $cbcart_default_link to finish your order now.\n\n$cbcart_store_name\n\nThanks."
            , "format" => null, "example" => $cbcart_example, "buttons" => null);
            $cbcart_button[0] = array("type" => "URL", "text" => "complete your order", "example" => $cbcart_default_link, "url" => $cbcart_default_link."/{{1}}");
            $cbcart_component_button = array("type" => "BUTTONS", "text" => null, "format" => null, "example" => null,
                "buttons" => $cbcart_button);
            $cbcart_component2[0] = $cbcart_component_text;
            $cbcart_component2[1] = $cbcart_component_button;
            $cbcart_component2 = wp_json_encode($cbcart_component2);
            $cbcart_url = "https://graph.facebook.com/v14.0/$cbcart_wabaid/message_templates?name=cbcart_wp_abandoned_cart_new_4&language=en_US&category=UTILITY&components=$cbcart_component2&access_token=$cbcart_token";
            $cbcart_response = wp_remote_post($cbcart_url);
            $cbcart_result2       = update_option( 'cbcart_create_wp_abandoned_cart_new_4',wp_json_encode($cbcart_response));
            $cbcart_response = json_decode($cbcart_response['body']);
            return $cbcart_response;
        }
        /**
         * create template for abandoned cart message 5
         *
         * @version 3.0.4
         * @since     1.0.0
         * @return    string response.
         */
        public static function cbcart_create_wp_abandoned_cart_new_5($cbcart_default_link) {
            $cbcart_data = get_option('cbcart_premiumsettings');
            $cbcart_data = json_decode($cbcart_data);
            $cbcart_data  = sanitize_option("cbcart_premiumsettings", $cbcart_data);

            $cbcart_token = $cbcart_data->cbcart_token;
            $cbcart_wabaid = $cbcart_data->cbcart_wabaid;
            $cbcart_store_name            = get_bloginfo( 'name' );
            //create_template API
            $body_text[] = array("alexa","test");
            $cbcart_example = array("body_text" => $body_text, "header_handle" => null);
            $cbcart_component_text = array("type" => "BODY", "text" => "Hello {{1}},\n\nDid you forget to complete your order on $cbcart_store_name?\n\nClick the link to finish the order now!\n\nYour friends from {{2}}.\n\nThanks."
            , "format" => null, "example" => $cbcart_example, "buttons" => null);
            $cbcart_button[0] = array("type" => "URL", "text" => "complete your order","example" => $cbcart_default_link, "url" => $cbcart_default_link."/{{1}}");
            $cbcart_component_button = array("type" => "BUTTONS", "text" => null, "format" => null, "example" => null,
                "buttons" => $cbcart_button);
            $cbcart_component2[0] = $cbcart_component_text;
            $cbcart_component2[1] = $cbcart_component_button;
            $cbcart_component2 = wp_json_encode($cbcart_component2);
            $cbcart_url = "https://graph.facebook.com/v14.0/$cbcart_wabaid/message_templates?name=cbcart_wp_abandoned_cart_new_5&language=en_US&category=UTILITY&components=$cbcart_component2&access_token=$cbcart_token";
            $cbcart_response = wp_remote_post($cbcart_url);
            $cbcart_result2       = update_option( 'cbcart_create_wp_abandoned_cart_new_5',wp_json_encode($cbcart_response));
            $cbcart_response = json_decode($cbcart_response['body']);
            return $cbcart_response;
        }
        /**
         * create template for order notification for customer
         *
         * @version 3.0.4
         * @since     1.0.0
         * @return    string response.
         */
        public static function cbcart_create_wp_order_notifs_customer_new_1($cbcart_default_link) {
            $cbcart_data = get_option('cbcart_premiumsettings');
            $cbcart_data = json_decode($cbcart_data);
            $cbcart_data  = sanitize_option("cbcart_premiumsettings", $cbcart_data);

            $cbcart_token = $cbcart_data->cbcart_token;
            $cbcart_wabaid = $cbcart_data->cbcart_wabaid;

            //create_template API
            $body_text[] = array("alexa","modern store","test");
            $cbcart_example = array("body_text" => $body_text, "header_handle" => null);
            $cbcart_component_text = array("type" => "BODY", "text" => "Hi {{1}},\n\nYour {{2}} order of {{3}} is placed.\n\nWe will keep you updated about your order status."
            , "format" => null, "example" => $cbcart_example, "buttons" => null);
            $cbcart_button[0] = array("type" => "URL", "text" => "Visit store","example" => $cbcart_default_link, "url" => $cbcart_default_link);
            $cbcart_component_button = array("type" => "BUTTONS", "text" => null, "format" => null, "example" => null,
                "buttons" => $cbcart_button);
            $cbcart_component2[0] = $cbcart_component_text;
            $cbcart_component2[1] = $cbcart_component_button;
            $cbcart_component2 = wp_json_encode($cbcart_component2);
            $cbcart_url = "https://graph.facebook.com/v14.0/$cbcart_wabaid/message_templates?name=cbcart_wp_order_notifs_customer_new_1&language=en_US&category=UTILITY&components=$cbcart_component2&access_token=$cbcart_token";
            $cbcart_response = wp_remote_post($cbcart_url);
            $cbcart_result2       = update_option( 'cbcart_create_wp_order_notifs_customer_new_1',wp_json_encode($cbcart_response));
            $cbcart_response = json_decode($cbcart_response['body']);
            return $cbcart_response;
        }
        /**
         * create template for order notification for admin
         *
         * @version 3.0.4
         * @since     1.0.0
         * @return    string response.
         */
        public static function cbcart_create_wp_order_notifs_admin_new_1($cbcart_default_link) {
            $cbcart_data = get_option('cbcart_premiumsettings');
            $cbcart_data = json_decode($cbcart_data);
            $cbcart_data  = sanitize_option("cbcart_premiumsettings", $cbcart_data);

            $cbcart_token = $cbcart_data->cbcart_token;
            $cbcart_wabaid = $cbcart_data->cbcart_wabaid;
            $cbcart_store_name            = get_bloginfo( 'name' );
            //create_template API
            $cbcart_component_text = array("type" => "BODY", "text" => "Hi,\n\nAn order is placed on $cbcart_store_name at $cbcart_default_link\n\nThe order is for {{1}} and the order amount is {{2}}\n\nCustomer details are: {{3}}\n\nThanks."
            , "format" => null, "example" => null, "buttons" => null);
            $cbcart_component2[0] = $cbcart_component_text;
            $cbcart_component2 = wp_json_encode($cbcart_component2);
            $cbcart_url = "https://graph.facebook.com/v14.0/$cbcart_wabaid/message_templates?name=cbcart_wp_order_notifs_admin_new_1&language=en_US&category=UTILITY&components=$cbcart_component2&access_token=$cbcart_token";
            $cbcart_response = wp_remote_post($cbcart_url);
            $cbcart_result2       = update_option( 'cbcart_create_wp_order_notifs_admin_new_1',wp_json_encode($cbcart_response));
            $cbcart_response = json_decode($cbcart_response['body']);
            return $cbcart_component2;

        }
        /**
         * create template for contact form 7 notification
         *
         * @version 3.0.4
         * @since     1.0.0
         * @return    string response.
         */
        public static function cbcart_create_wp_cf7_new_1() {
            $cbcart_data = get_option('cbcart_premiumsettings');
            $cbcart_data = json_decode($cbcart_data);
            $cbcart_data  = sanitize_option("cbcart_premiumsettings", $cbcart_data);

            $cbcart_token = $cbcart_data->cbcart_token;
            $cbcart_wabaid = $cbcart_data->cbcart_wabaid;
            $cbcart_store_name            = get_bloginfo( 'name' );
            //create_template API
            $cbcart_component_text = array("type" => "BODY", "text" => "A new contact form inquiry is received from \r\n\r\nName: {{1}}.\r\n\r\nThe details of message are: {{2}}\r\n\r\n$cbcart_store_name."
            , "format" => null, "example" => null, "buttons" => null);
            $cbcart_component2[0] = $cbcart_component_text;
            $cbcart_component2 = wp_json_encode($cbcart_component2);
            $cbcart_url = "https://graph.facebook.com/v14.0/$cbcart_wabaid/message_templates?name=cbcart_wp_cf7_new_1&language=en_US&category=UTILITY&components=$cbcart_component2&access_token=$cbcart_token";
            $cbcart_response = wp_remote_post($cbcart_url);
            $cbcart_result2       = update_option( 'cbcart_create_wp_cf7_new_1',wp_json_encode($cbcart_response));
            $cbcart_response = json_decode($cbcart_response['body']);
            return $cbcart_response;

        }
        /**
         * create template for contact form 7 customer notification
         *
         * @version 3.0.4
         * @since     1.0.0
         * @return    string response.
         */
        public static function cbcart_create_wp_cf7_customer_new_1() {
            $cbcart_data = get_option('cbcart_premiumsettings');
            $cbcart_data = json_decode($cbcart_data);
            $cbcart_data  = sanitize_option("cbcart_premiumsettings", $cbcart_data);

            $cbcart_token = $cbcart_data->cbcart_token;
            $cbcart_wabaid = $cbcart_data->cbcart_wabaid;
            $cbcart_store_name            = get_bloginfo( 'name' );
            //create_template API
            $cbcart_component_text = array("type" => "BODY", "text" => "Thank you for submitting the form!\n\nWe have received your information and will process it shortly.\n\nIf you have any further questions or concerns, please don't hesitate to contact us.\n\nHave a great day!"
            , "format" => null, "example" => null, "buttons" => null);
            $cbcart_component2[0] = $cbcart_component_text;
            $cbcart_component2 = wp_json_encode($cbcart_component2);
            $cbcart_url = "https://graph.facebook.com/v14.0/$cbcart_wabaid/message_templates?name=cbcart_wp_cf7_customer&language=en_US&category=UTILITY&components=$cbcart_component2&access_token=$cbcart_token";
            $cbcart_response = wp_remote_post($cbcart_url);
            $cbcart_result2       = update_option( 'cbcart_create_wp_cf7_customer_new_1',wp_json_encode($cbcart_response));
            $cbcart_response = json_decode($cbcart_response['body']);
            return $cbcart_response;
        }
        /**
         * set webhook for inbox
         *
         * @since     1.0.0
         * @version 3.0.4
         * @param
         * @return  $cbcart_response;
         */
        public static function cbcart_set_webhook_for_inbox() {

            //get value of premium settings
            $cbcart_data = get_option( 'cbcart_premiumsettings' );
            $cbcart_data = json_decode( $cbcart_data );
            $cbcart_data  = sanitize_option("cbcart_premiumsettings", $cbcart_data);

            if($cbcart_data != ""){
                $cbcart_bearer_token= $cbcart_data->cbcart_token;
                $cbcart_phone_noid= $cbcart_data->cbcart_phoneid;
                $cbcart_wabaid= $cbcart_data->cbcart_wabaid;
            } else {
                $cbcart_bearer_token= '';
                $cbcart_phone_noid='';
                $cbcart_wabaid='';
            }

            //get value of admin settings
            $cbcart_data = get_option( 'cbcart_adminsettings' );
            $cbcart_data = json_decode( $cbcart_data );
            $cbcart_data  = sanitize_option("cbcart_adminsettings", $cbcart_data);

            if($cbcart_data != "") {
                $cbcart_from_number = $cbcart_data->cbcart_from_number;
            } else{
                $cbcart_from_number='';
            }

            //get value of inbox options
            $cbcart_data = get_option( 'cbcart_inboxmessage' );
            $cbcart_data = json_decode( $cbcart_data );
            $cbcart_data  = sanitize_option("cbcart_inboxmessage", $cbcart_data);
            if($cbcart_data != "") {
                $cbcart_forwardnumber = $cbcart_data->cbcart_forwardnumber;
                $cbcart_email =  $cbcart_data->cbcart_email;
            } else {
                $cbcart_forwardnumber='';
                $cbcart_email='';
            }

            // call api to send test message
            $cbcart_data_decoded = array(
                "phone_number_id" => $cbcart_phone_noid,
                "whatsapp_business_account_id" => $cbcart_wabaid,
                "access_token"              => $cbcart_bearer_token,
                "business_number"          => $cbcart_from_number,
                "forwarding_number"          => $cbcart_forwardnumber,
                "email"          => $cbcart_email,
            );

            $cbcart_data         = json_encode( $cbcart_data_decoded );
            $cbcart_url          = esc_url( "https://api.whatso.net/app/add-waba-details",'cartbox-messaging-widgets' );
            $cbcart_response     = wp_remote_post(
                $cbcart_url,
                array(
                    'method'  => 'POST',
                    'headers' => array(
                        'Content-Type' => 'application/json',
                        'WPRequest'    => 'abach34h4h2h11h3h'
                    ),
                    'body'    => $cbcart_data
                )
            );
            $cbcart_response= $cbcart_response['body'];
            $cbcart_response_obj = json_decode( $cbcart_response);
            if (property_exists($cbcart_response_obj,'responsecode')) {
                $cbcart_response = $cbcart_response_obj->responsecode;
            } else {
                $cbcart_response='';
            }
           return $cbcart_response;
        }

        /**
         * send test message from onboarding screen.
         *
         * @version 3.0.4
         * @since     1.0.0
         * @return    string true,false.
         */
        public static function cbcart_sendtestmessage() {
            if ( ! empty( get_option( 'cbcart_adminsettings' ) ) ) {
                $cbcart_data        = get_option( 'cbcart_adminsettings' );
                $cbcart_data        = json_decode( $cbcart_data );
                $cbcart_data  = sanitize_option("cbcart_adminsettings", $cbcart_data);

                if ($cbcart_data != "") {
                    $cbcart_username    = $cbcart_data->cbcart_username;
                    $cbcart_password    = $cbcart_data->cbcart_password;
                    $cbcart_from_number = $cbcart_data->cbcart_from_number;
                } else {
                    $cbcart_username    = "";
                    $cbcart_password    = "";
                    $cbcart_from_number = "";
                }
            }
            $cbcart_data2                  = get_option( 'cbcart_testmessagesetup' );
            $cbcart_data2                  = json_decode( $cbcart_data2 );
            $cbcart_data2  = sanitize_option("cbcart_testmessagesetup", $cbcart_data2);


            $cbcart_tonumber = $cbcart_data2->cbcart_tonumber;
            $cbcart_message = $cbcart_data2->cbcart_message;
            $cbcart_language_code = $cbcart_data2->cbcart_langcode;
            $cbcart_templatename = $cbcart_data2->cbcart_testmessageid;
            $cbcart_store_name       = get_bloginfo( 'name' );
            $cbcart_base_url         = site_url( $path = '', $scheme = null );
            $cbcart_current_time     = current_time( 'mysql' );
            $cbcart_date             = date_create( $cbcart_current_time );

            $cbcart_tonumber        = preg_replace( '/[^0-9]/', '', $cbcart_tonumber );
            $cbcart_message      = str_replace( '{storename}', $cbcart_store_name, $cbcart_message );
            $cbcart_message      = str_replace( '{siteurl}', $cbcart_base_url, $cbcart_message );
            $cbcart_message      = preg_replace( "/\r\n/", "<br>", $cbcart_message );

            if ( ! empty( get_option( 'cbcart_usersettings' ) ) ) {
                $cbcart_data   = get_option( 'cbcart_usersettings' );
                $cbcart_data   = json_decode( $cbcart_data );
                $cbcart_data  = sanitize_option("cbcart_usersettings", $cbcart_data);
                $cbcart_planid = $cbcart_data->cbcart_planid;
            }
            $cbcart = new cbcart();
            if ($cbcart_planid == '1' ||  $cbcart_planid == '3' ) {
                $send_message = $cbcart::cbcart_send_whatsapp_message(  $cbcart_tonumber, $cbcart_username, $cbcart_password, $cbcart_templatename, $cbcart_from_number );
                return $send_message;
            }
            if ( $cbcart_planid == '2' || $cbcart_planid == "4"  ) {

                $cbcart_data = get_option( 'cbcart_premiumsettings' );
                $cbcart_data = json_decode( $cbcart_data );
                $cbcart_data  = sanitize_option("cbcart_premiumsettings", $cbcart_data);

                $cbcart_bearer_token= $cbcart_data->cbcart_token;
                $cbcart_phone_noid= $cbcart_data->cbcart_phoneid;

                $send_message = $cbcart::cbcart_send_whatsapp_message_cloudapi(  $cbcart_bearer_token, $cbcart_language_code, $cbcart_templatename, $cbcart_phone_noid, $cbcart_tonumber );

                return $send_message;
            }

        }

        /**
         * send message using cloud API
         *
         * @since     1.0.0
         * @version 3.0.4
         * @param  $cbcart_bearer_token, $cbcart_language_code, $cbcart_templatename, $cbcart_phone_noid, $cbcart_tonumber
         * @return  $cbcart_response;
         */
        public static function cbcart_send_whatsapp_message_cloudapi(  $cbcart_bearer_token, $cbcart_language_code, $cbcart_templatename, $cbcart_phone_noid, $cbcart_tonumber ) {
            $cbcart_language    = array( "code" => $cbcart_language_code );
            $cbcart_template    = array( "name"       => $cbcart_templatename,
                "language"   => $cbcart_language,
            );

            // call api to send test message
            $cbcart_data_decoded = array(
                "messaging_product" => 'whatsapp',
                "to"                => $cbcart_tonumber,
                "type"              => 'template',
                "template"          => $cbcart_template,
            );

            $cbcart_data         = json_encode( $cbcart_data_decoded );
            $cbcart_url          = esc_url( "https://graph.facebook.com/v13.0/$cbcart_phone_noid/messages",'cartbox-messaging-widgets' );
            $cbcart_response     = wp_remote_post(
                $cbcart_url, array(
                    'method'  => 'POST',
                    'headers' => array(
                        'Content-Type'  => 'application/json',
                        'Authorization' => 'Bearer ' . $cbcart_bearer_token,
                    ),
                    'body'    => $cbcart_data
                )
            );
            if ( is_array( $cbcart_response ) && isset( $cbcart_response['response'] ) ) {
                $cbcart_response2= $cbcart_response['response'];
                if ( $cbcart_response2['code'] == "200" ) {
                    return $cbcart_results_array = array(
                        'cbcart_response_code'    => $cbcart_response2['code'],
                        'cbcart_response_json' => $cbcart_response['body'],
                    );

                } else {
                    return $cbcart_results_array = array(
                        'cbcart_response_code'    => $cbcart_response2['code'],
                        'cbcart_response_json' =>$cbcart_response['body'],
                    );
                }
            }

        }

        /**
         * send message using v2 API
         *
         * @since     1.0.0
         * @version 3.0.4
         * @param $cbcart_tonumber , $cbcart_username, $cbcart_password, $cbcart_templatename, $cbcart_from_number
         * @return String true,false
         */
        public static function cbcart_send_whatsapp_message( $cbcart_tonumber , $cbcart_username, $cbcart_password, $cbcart_templatename, $cbcart_from_number ) {
            $cbcart_component=[];
            $cbcart_language = array( "code" => "en_US" );
            $cbcart_template = array(
                "language"   => $cbcart_language,
                "name"       => "hello_world",
                "apicomponents" => $cbcart_component
            );
            // call api to send test message
            $cbcart_data_decoded = array(
                "username"  => $cbcart_username,
                "password" => $cbcart_password ,
                "from" => $cbcart_from_number,
                "to"=> $cbcart_tonumber,
                "type"=> "template",
                "template"=>$cbcart_template
            );
            $cbcart_data         = json_encode( $cbcart_data_decoded );

            $cbcart_url          = esc_url( "https://api.whatso.net/v1/messages",'cartbox-messaging-widgets' );
            $cbcart_response     = wp_remote_post(
                $cbcart_url,
                array(
                    'method'  => 'POST',
                    'headers' => array(
                        'Content-Type' => 'application/json',
                        'WPRequest'    => 'abach34h4h2h11h3h'
                    ),
                    'body'    => $cbcart_data
                )
            );

	        if ( is_array( $cbcart_response ) && isset( $cbcart_response['body'] ) ) {
                $cbcart_response_obj = json_decode( $cbcart_response['body'] );
                if (property_exists($cbcart_response_obj,'responsecode')) {
                    return $cbcart_results_array = array(
                        'cbcart_response_code'    => $cbcart_response_obj->responsecode,
                        'cbcart_response_json' => $cbcart_response_obj,
                    );
                } else {
                    return $cbcart_results_array = array(
                        'cbcart_response_code'    => $cbcart_response_obj->responsecode,
                        'cbcart_response_json' => $cbcart_response_obj,
                    );
                }
            }
        }

        /**
         * read cart data
         *
         * @version 3.0.4
         * @since     1.0.0
         * @return    array cart.
         */
        public function cbcart_read_cart() {
            if ( ! WC()->cart ) { // Exit if Woocommerce cart has not been initialized
                return;
            }

            // Retrieving cart total value and currency
            $cbcart_cart_total    = WC()->cart->total;
            $cbcart_cart_currency = get_woocommerce_currency();
            $cbcart_current_time  = current_time( 'mysql', false ); //Retrieving current time
            $cbcart_session_id = WC()->session->get_customer_id();

            // Retrieving cart
            $cbcart_products      = WC()->cart->get_cart_contents();
            $cbcart_product_array = array();

            foreach ( $cbcart_products as $cbcart_product => $cbcart_values ) {
                $cbcart_item = wc_get_product( $cbcart_values['data']->get_id() );
                $cbcart_product_title           = $cbcart_item->get_title();
                $cbcart_product_quantity        = $cbcart_values['quantity'];
                $cbcart_product_variation_price = '';
                $cbcart_product_tax             = '';

                if ( isset( $cbcart_values['line_total'] ) ) {
                    $cbcart_product_variation_price = $cbcart_values['line_total'];
                }
                if ( isset( $cbcart_values['line_tax'] ) ) { // If we have taxes, add them to the price
                    $cbcart_product_tax = $cbcart_values['line_tax'];
                }

                // Handling product variations
                if ( $cbcart_values['variation_id'] ) { // If user has chosen a variation
                    $cbcart_single_variation = new WC_Product_Variation( $cbcart_values['variation_id'] );

                    // Handling variable product title output with attributes
                    $cbcart_product_attributes   = $this->attribute_slug_to_title( $cbcart_single_variation->get_variation_attributes() );
                    $cbcart_product_variation_id = $cbcart_values['variation_id'];
                } else {
                    $cbcart_product_attributes   = false;
                    $cbcart_product_variation_id = '';
                }

                // Inserting Product title, Variation and Quantity into array
                $cbcart_product_array[] = array(
                    'product_title'           => $cbcart_product_title . $cbcart_product_attributes,
                    'quantity'                => $cbcart_product_quantity,
                    'product_id'              => $cbcart_values['product_id'],
                    'product_variation_id'    => $cbcart_product_variation_id,
                    'product_variation_price' => $cbcart_product_variation_price,
                    'product_tax'             => $cbcart_product_tax
                );
            }
            return $cbcart_results_array = array(
                'cart_total'    => $cbcart_cart_total,
                'cart_currency' => $cbcart_cart_currency,
                'current_time'  => $cbcart_current_time,
                'session_id'    => $cbcart_session_id,
                'product_array' => $cbcart_product_array
            );
        }

        /**
         * save abandoned cart data
         *
         * @since     1.0.0
         * @version 3.0.4
         */
        public function cbcart_save_cart_data() {
            global $woocommerce;
            global $wpdb;
            if ( ! WC()->cart ) { //Exit if Woocommerce cart has not been initialized
                return false;
            }
            if ( is_user_logged_in() ) {
                if ( ! WC()->session ) { //If session does not exist, exit function
                    return;
                }
                $cbcart_customer_id   = WC()->session->get_customer_id();
                $cbcart_cart          = $this->cbcart_read_cart();
                $cbcart_get_user_data = $this->cbcart_get_user_data();
                $cbcart_cart_table    = $wpdb->prefix . 'cbcart_abandoneddetails';
                $cbcart_get_sql       = $wpdb->prepare( "SELECT COUNT(cbcart_id) FROM $cbcart_cart_table WHERE cbcart_customer_id = %d AND cbcart_status IN (0,1)", $cbcart_customer_id );
                $cbcart_result_count  = $wpdb->get_var( $cbcart_get_sql );

                // if cartbox result count is greater than 0
                if ( $cbcart_result_count > 0 ) {
                    $cbcart_update_array = array(
                        'cbcart_customer_email'      => $cbcart_get_user_data['email'],
                        'cbcart_customer_mobile_no'  => $cbcart_get_user_data['phone'],
                        'cbcart_customer_first_name' => $cbcart_get_user_data['first_name'],
                        'cbcart_customer_last_name'  => $cbcart_get_user_data['last_name'],
                        'cbcart_cart_json'           => serialize( $cbcart_cart['product_array'] ),
                        'cbcart_cart_total_json'     => '{}',
                        'cbcart_cart_total'          => $cbcart_cart['cart_total'],
                        'cbcart_cart_currency'       => $cbcart_cart['cart_currency'],
                        'cbcart_last_access_time'    => $cbcart_cart['current_time']
                    );
	                  $wpdb->update( $cbcart_cart_table, $cbcart_update_array, array( 'customer_id' => $cbcart_customer_id ) );
				} else {
                    $cbcart_insert_array = array(
                        'cbcart_customer_id'         => $cbcart_customer_id,
                        'cbcart_customer_email'      => $cbcart_get_user_data['email'],
                        'cbcart_customer_mobile_no'  => $cbcart_get_user_data['phone'],
                        'cbcart_customer_first_name' => $cbcart_get_user_data['first_name'],
                        'cbcart_customer_last_name'  => $cbcart_get_user_data['last_name'],
                        'cbcart_customer_type'       => 'REGISTERED',
                        'cbcart_cart_json'           => serialize( $cbcart_cart['product_array'] ),
                        'cbcart_cart_total_json'     => '{}',
                        'cbcart_cart_total'          => $cbcart_cart['cart_total'],
                        'cbcart_cart_currency'       => $cbcart_cart['cart_currency'],
                        'cbcart_last_access_time'    => $cbcart_cart['current_time']
                    );
					$wpdb->insert( $cbcart_cart_table, $cbcart_insert_array );
                }
            }
        }

        /**
         * to get user data from session
         *
         * @since     1.0.0
         * @version 3.0.4
         */
        public function cbcart_get_user_data() {
            $user_data = array();
            if ( is_user_logged_in() ) { //If user has signed in and the request is not triggered by checkout fields or Exit Intent
                $current_user = wp_get_current_user(); //Retrieving users data
                //Looking if a user has previously made an order. If not, using default WordPress assigned data
                ( isset( $current_user->billing_first_name ) ) ? $name = $current_user->billing_first_name : $name = $current_user->user_firstname; //If/Else shorthand (condition) ? True : False
                ( isset( $current_user->billing_last_name ) ) ? $surname = $current_user->billing_last_name : $surname = $current_user->user_lastname;
                ( isset( $current_user->billing_email ) ) ? $email = $current_user->billing_email : $email = $current_user->user_email;
                ( isset( $current_user->billing_phone ) ) ? $phone = $current_user->billing_phone : $phone = '';
                ( isset( $current_user->billing_country ) ) ? $country = $current_user->billing_country : $country = '';
                ( isset( $current_user->billing_city ) ) ? $city = $current_user->billing_city : $city = '';
                ( isset( $current_user->billing_postcode ) ) ? $postcode = $current_user->billing_postcode : $postcode = '';

                if ( $country == '' ) { //Trying to Geolocate user's country in case it was not found
                    $country = WC_Geolocation::geolocate_ip(); //Getting users country from his IP address
                    $country = $country['country'];
                }
                $location = array(
                    'country'  => $country,
                    'city'     => $city,
                    'postcode' => $postcode
                );
                $user_data = array(
                    'first_name'   => $name,
                    'last_name'    => $surname,
                    'email'        => $email,
                    'phone'        => $phone,
                    'location'     => $location,
                    'other_fields' => ''
                );
            }
            return $user_data;
        }

        /**
         * add cron interval to send abandoned cart message
         *
         * @return    string cbcart_interval
         * @version 3.0.4
         * @since     1.0.0
         */
        function cbcart_cron_intervals( $cbcart_intervals ) {


            $cbcart_intervals['cbcart_abandoned_cart_cron_interval'] = array( // Defining cron Interval for sending out email notifications about abandoned carts
                'interval' => 60,
                'display'  => 'Every 1  minutes'
            );

            $cbcart_intervals['clear_tables'] = array( // Defining cron Interval for removing abandoned carts that do not have products
                'interval' => 24 * 60 * 60,
                'display'  => 'Every day'
            );
            $cbcart_intervals['cbcart_get_template_hook'] = array( // Defining cron Interval for sending out email notifications about abandoned carts
                'interval' => 300,
                'display'  => 'Every 5 minutes'
            );
            return $cbcart_intervals;
        }

        /**
         * schedule trigger time for abandoned cart messages
         *
         * @since     1.0.0
         * @version 3.0.4
         */
        public function cbcart_schedulers() {
            $cbcart_data       = get_option( 'cbcart_abandonedsettings' );
            $cbcart_admin_data = get_option( 'cbcart_adminsettings' );
            $cbcart_admin_data = json_decode( $cbcart_admin_data );
            $cbcart_admin_data  = sanitize_option("cbcart_adminsettings", $cbcart_admin_data);


            if ( $cbcart_data ) {
                $cbcart_data       = json_decode( $cbcart_data );
                $cbcart_mobile     = "";
                $cbcart_trigger    = "";
                $cbcart_trigger2   = "";
                $cbcart_trigger3   = "";
                $cbcart_trigger4   = "";
                $cbcart_trigger5   = "";
                $cbcart_is_enabled = "";
                if($cbcart_admin_data != "") {
                if ( isset( $cbcart_admin_data->cbcart_from_number ) ) {
                    $cbcart_mobile = $cbcart_admin_data->cbcart_from_number;
                }
                if ( isset( $cbcart_data->cbcart_trigger_time ) ) {
                    $cbcart_trigger = $cbcart_data->cbcart_trigger_time;
                }
                if ( isset( $cbcart_data->cbcart_trigger_time2 ) ) {
                    $cbcart_trigger2 = $cbcart_data->cbcart_trigger_time2;
                }
                if ( isset( $cbcart_data->cbcart_trigger_time3 ) ) {
                    $cbcart_trigger3 = $cbcart_data->cbcart_trigger_time3;
                }
                if ( isset( $cbcart_data->cbcart_trigger_time4 ) ) {
                    $cbcart_trigger4 = $cbcart_data->cbcart_trigger_time4;
                }
                if ( isset( $cbcart_data->cbcart_trigger_time5 ) ) {
                    $cbcart_trigger5 = $cbcart_data->cbcart_trigger_time5;
                }
                if ( isset( $cbcart_data->cbcart_ac_enable ) ) {
                    $cbcart_is_enabled = $cbcart_data->cbcart_ac_enable;
                }
            }
                if ( $cbcart_is_enabled == 'checked' ) {
                    if ( ! wp_next_scheduled( 'cbcart_send_hook' ) ) {
                        wp_schedule_event( time(), 'cbcart_abandoned_cart_cron_interval', 'cbcart_send_hook' );
                    }
                    if ( ! wp_next_scheduled( 'cbcart_clear_table_hook' ) ) {
                        wp_schedule_event( time(), 'clear_tables_interval', 'cbcart_clear_table_hook' );
                    }
                    if ( ! wp_next_scheduled( 'cbcart_send_hook' ) ) {
                        wp_schedule_event( time(), 'cbcart_get_template_hook', 'cbcart_send_hook' );
                    }
                } else {
                    wp_clear_scheduled_hook( 'cbcart_send_hook' );
                    wp_clear_scheduled_hook( 'cbcart_clear_table_hook' );
                }
            }
        }

        /**
         * clear abandoend cart table after define time
         *
         * @since     1.0.0
         * @version 3.0.4
         */
        public function cbcart_clear_abandoned_carts_table() {
            global $wpdb;
	        try {
				$wpdb->query( $wpdb->prepare( "DELETE FROM " . $wpdb->prefix . "cbcart_abandoneddetails WHERE datediff(now(), cbcart_last_access_time) > 45 AND cbcart_status IN (0,1)" ) );

	        } catch ( Exception $exception ) {
                printf(
                esc_html__( 'Exception message: %s', 'plugin-slug' ),
                esc_html( $exception->getMessage() )
                );
		        return $exception;
	        }
        }

        /**
         * move session data to cartbox abandoned cart table
         *
         * @since     1.0.0
         * @version 3.0.4
         */
        public function cbcart_move_sessions_to_cbcart_abandoned_table() {
            try {
                global $wpdb;
                global $woocommerce;
                $cbcart_product_cart = $this->cbcart_read_cart();
                $cbcart_current_time = current_time( 'mysql', false ); //Retrieving current time
                $cbcart_cart_table   = $wpdb->prefix . 'cbcart_abandoneddetails';

                // to get product title
                $cbcart_table1                    = $wpdb->prefix . "posts";
                $cbcart_woocommerce_session_table = $wpdb->prefix . 'woocommerce_sessions';

                $cbcart_get_sessions_sql = $wpdb->prepare( "SELECT * FROM $cbcart_woocommerce_session_table" );

                $cbcart_get_all_sessions = $wpdb->get_results( $cbcart_get_sessions_sql ); // db call ok; no-cache okdb call ok; no-cache ok

                $cbcart_json_data          = get_option( 'cbcart_abandonedsettings' );
                $cbcart_json_decoded       = json_decode( $cbcart_json_data );
                $cbcart_json_decoded  = sanitize_option("cbcart_abandonedsettings", $cbcart_json_decoded);
                $cbcart_abandoned_interval = $cbcart_json_decoded->cbcart_trigger_time;
                $cbcart_ac_enable          = $cbcart_json_decoded->cbcart_ac_enable;

                $cbcart_trigger_time2 = $cbcart_json_decoded->cbcart_trigger_time2;
                $cbcart_trigger_time3 = $cbcart_json_decoded->cbcart_trigger_time3;
                $cbcart_trigger_time4 = $cbcart_json_decoded->cbcart_trigger_time4;
                $cbcart_trigger_time5 = $cbcart_json_decoded->cbcart_trigger_time5;

                $cbcart_message2_enable = ( isset( $cbcart_json_decoded->cbcart_message2_enable ) ) ? $cbcart_json_decoded->cbcart_message2_enable : '';
                $cbcart_message3_enable = ( isset( $cbcart_json_decoded->cbcart_message3_enable ) ) ? $cbcart_json_decoded->cbcart_message3_enable : '';
                $cbcart_message4_enable = ( isset( $cbcart_json_decoded->cbcart_message4_enable ) ) ? $cbcart_json_decoded->cbcart_message4_enable : '';
                $cbcart_message5_enable = ( isset( $cbcart_json_decoded->cbcart_message5_enable ) ) ? $cbcart_json_decoded->cbcart_message5_enable : '';

                $cbcart_data        = get_option( 'cbcart_adminsettings' );
                $cbcart_data = json_decode($cbcart_data);
                $cbcart_data  = sanitize_option("cbcart_adminsettings", $cbcart_data);

                $cbcart_username = $cbcart_data->cbcart_username;
                $cbcart_password = $cbcart_data->cbcart_password;
                $cbcart_from_number = $cbcart_data->cbcart_from_number;

                $cbcart_data1 = get_option('cbcart_usersettings');
                $cbcart_data1 = json_decode($cbcart_data1);
                $cbcart_data1  = sanitize_option("cbcart_usersettings", $cbcart_data1);

                $cbcart_checkplan = $cbcart_data1->cbcart_planid;

                $cbcart_body_param_array= array();
                $cbcart_body_param_array2= array();

                $cbcart_data = get_option('cbcart_abandoned_1');
                $cbcart_data = json_decode($cbcart_data);
                $cbcart_data  = sanitize_option("cbcart_abandoned_1", $cbcart_data);
                $cbcart_temp_name= $cbcart_data->cbcart_temp_name;
                $cbcart_temp_language= $cbcart_data->cbcart_temp_language;
                $cbcart_body_param_count= $cbcart_data->cbcart_body_param_count;
                $cbcart_body_param_array= $cbcart_data->cbcart_body_param_array;
                $cbcart_is_button_count = $cbcart_data->cbcart_is_button_count;
                $cbcart_is_button_url_1 = $cbcart_data->cbcart_is_button_url_1;

                $cbcart_data = get_option('cbcart_abandoned_2');
                $cbcart_data = json_decode($cbcart_data);
                $cbcart_data  = sanitize_option("cbcart_abandoned_2", $cbcart_data);

                $cbcart_temp_name2= $cbcart_data->cbcart_temp_name;
                $cbcart_temp_language2= $cbcart_data->cbcart_temp_language;
                $cbcart_body_param_count2= $cbcart_data->cbcart_body_param_count;
                $cbcart_body_param_array2= $cbcart_data->cbcart_body_param_array;
                $cbcart_is_button_count2 = $cbcart_data->cbcart_is_button_count;
                $cbcart_is_button_url_2 = $cbcart_data->cbcart_is_button_url_1;

                $cbcart_data = get_option('cbcart_abandoned_3');
                $cbcart_data = json_decode($cbcart_data);
                $cbcart_data  = sanitize_option("cbcart_abandoned_3", $cbcart_data);
                $cbcart_temp_name3= $cbcart_data->cbcart_temp_name;
                $cbcart_temp_language3= $cbcart_data->cbcart_temp_language;
                $cbcart_body_param_count3= $cbcart_data->cbcart_body_param_count;
                $cbcart_body_param_array3= $cbcart_data->cbcart_body_param_array;
                $cbcart_is_button_count3 = $cbcart_data->cbcart_is_button_count;
                $cbcart_is_button_url_3 = $cbcart_data->cbcart_is_button_url_1;

                $cbcart_data = get_option('cbcart_abandoned_4');
                $cbcart_data = json_decode($cbcart_data);
                $cbcart_data  = sanitize_option("cbcart_abandoned_4", $cbcart_data);
                $cbcart_temp_name4= $cbcart_data->cbcart_temp_name;
                $cbcart_temp_language4= $cbcart_data->cbcart_temp_language;
                $cbcart_body_param_count4= $cbcart_data->cbcart_body_param_count;
                $cbcart_body_param_array4= $cbcart_data->cbcart_body_param_array;
                $cbcart_is_button_count4 = $cbcart_data->cbcart_is_button_count;
                $cbcart_is_button_url_4 = $cbcart_data->cbcart_is_button_url_1;

                $cbcart_data = get_option('cbcart_abandoned_5');
                $cbcart_data = json_decode($cbcart_data);
                $cbcart_data  = sanitize_option("cbcart_abandoned_5", $cbcart_data);
                $cbcart_temp_name5= $cbcart_data->cbcart_temp_name;
                $cbcart_temp_language5= $cbcart_data->cbcart_temp_language;
                $cbcart_body_param_count5= $cbcart_data->cbcart_body_param_count;
                $cbcart_body_param_array5= $cbcart_data->cbcart_body_param_array;
                $cbcart_is_button_count5 = $cbcart_data->cbcart_is_button_count;
                $cbcart_is_button_url_5 = $cbcart_data->cbcart_is_button_url_1;


                foreach ( $cbcart_get_all_sessions as $cbcart_row ) {
                    $cbcart_session_id       = $cbcart_row->session_key;
                    $cbcart_session_content  = unserialize( $cbcart_row->session_value );
                    $cbcart_cart             = unserialize( $cbcart_session_content['cart'] );
                    $cbcart_cart_totals      = unserialize( $cbcart_session_content['cart_totals'] );
                    $cbcart_last_access_time = $cbcart_session_content['cbcart_cart_last_access_timestamp'];
                    $cbcart_customer         = unserialize( $cbcart_session_content['customer'] );
                    $cbcart_cart_id_array = json_decode( json_encode( $cbcart_cart ), true );

                    foreach ( $cbcart_cart_id_array as $cbcart_arr2 ) {
                        $cbcart_product_id   = $cbcart_arr2['product_id'];
                        $cbcart_cart_content = $wpdb->get_results( $wpdb->prepare( "SELECT post_title FROM $cbcart_table1 WHERE ID = %d ORDER BY ID DESC", $cbcart_product_id ) ); // db call ok; no-cache ok
                        $cbcart_array1       = json_decode( json_encode( $cbcart_cart_content ), true );
                        $cbcart_cart_data = json_encode( $cbcart_array1 );
                        $cbcart_var            = explode( ",", $cbcart_array1['0']['post_title'] );
                        $cbcart_product_name   = $cbcart_var['0'];
                        $cbcart_products_array = array();
                        array_push( $cbcart_products_array, $cbcart_product_name );
                        $cbcart_exploded_names = implode( ",", $cbcart_products_array );
                    }
                    $cbcart_customer_first_name = '';
                    $cbcart_customer_last_name  = '';
                    $cbcart_customer_email      = '';
                    $cbcart_customer_mobile_no  = '';
                    $cbcart_customer_country    = '';
                    $cbcart_cart_total          = '';

                    $cbcart_param1 =array();
                    $cbcart_param2 =array();
                    $cbcart_component2=array();
                    $cbcart_param3=array();
                    $cbcart_component3=array();
                    $cbcart_param4 =array();
                    $cbcart_component4=array();
                    $cbcart_param5 =array();
                    $cbcart_component5=array();
                    $cbcart_param6 =array();
                    $cbcart_component6=array();

                    $cbcart_customername_var= "";
                    $cbcart_storename_var="";
                    $cbcart_productname_var="";
                    $cbcart_amountwithcurrency_var="";
                    $cbcart_customeremail_var="";
                    $cbcart_customernumber_var="";
                    $cbcart_storeurl_var="";
                    $cbcart_checkouturl_var="";

                    if ( is_array( $cbcart_customer ) and isset( $cbcart_customer['phone'] ) ) {
                        $cbcart_customer_mobile_no = $cbcart_customer['phone'];
                    }
                    if ( is_array( $cbcart_customer ) and isset( $cbcart_customer['first_name'] ) ) {
                        $cbcart_customer_first_name = $cbcart_customer['first_name'];
                    }
                    if ( is_array( $cbcart_customer ) and isset( $cbcart_customer['last_name'] ) ) {
                        $cbcart_customer_last_name = $cbcart_customer['last_name'];
                    }
                    if ( is_array( $cbcart_customer ) and isset( $cbcart_customer['email'] ) ) {
                        $cbcart_customer_email = $cbcart_customer['email'];
                    }
                    if ( is_array( $cbcart_customer ) and isset( $cbcart_customer['country'] ) ) {
                        $cbcart_customer_country = $cbcart_customer['country'];
                    }
                    if ( is_array( $cbcart_cart_totals ) and isset( $cbcart_cart_totals['total'] ) ) {
                        $cbcart_cart_total = $cbcart_cart_totals['total'];
                    }
                    // If nothing found check for billing fields
                    if ( empty( $cbcart_customer_first_name ) ) {
                        if ( isset( $cbcart_session_content['billing_first_name'] ) ) {
                            $cbcart_customer_first_name = $cbcart_session_content['billing_first_name'];
                        }
                    }
                    if ( empty( $cbcart_customer_last_name ) ) {
                        if ( isset( $cbcart_session_content['billing_last_name'] ) ) {
                            $cbcart_customer_last_name = $cbcart_session_content['billing_last_name'];
                        }
                    }
                    if ( empty( $cbcart_customer_email ) ) {
                        if ( isset( $cbcart_session_content['billing_email'] ) ) {
                            $cbcart_customer_email = $cbcart_session_content['billing_email'];
                        }
                    }
                    if ( empty( $cbcart_customer_mobile_no ) ) {
                        if ( isset( $cbcart_session_content['billing_phone'] ) ) {
                            $cbcart_customer_mobile_no = $cbcart_session_content['billing_phone'];
                        }
                    }
                    if ( empty( $cbcart_customer_country ) ) {
                        if ( isset( $cbcart_session_content['billing_country'] ) ) {
                            $cbcart_customer_country = $cbcart_session_content['billing_country'];
                        }
                    }
                    // If nothing found check for cartbox fields
                    if ( empty( $cbcart_customer_first_name ) ) {
                        if ( isset( $cbcart_session_content['cbcart_first_name'] ) ) {
                            $cbcart_customer_first_name = $cbcart_session_content['cbcart_first_name'];
                        }
                    }
                    if ( empty( $cbcart_customer_last_name ) ) {
                        if ( isset( $cbcart_session_content['cbcart_last_name'] ) ) {
                            $cbcart_customer_last_name = $cbcart_session_content['cbcart_last_name'];
                        }
                    }
                    if ( empty( $cbcart_customer_email ) ) {
                        if ( isset( $cbcart_session_content['cbcart_customer_email'] ) ) {
                            $cbcart_customer_email = $cbcart_session_content['cbcart_customer_email'];
                        }
                    }
                    if ( empty( $cbcart_customer_mobile_no ) ) {
                        if ( isset( $cbcart_session_content['cbcart_customer_phone'] ) ) {
                            $cbcart_customer_mobile_no = $cbcart_session_content['cbcart_customer_phone'];
                        }
                    }
                    if ( empty( $cbcart_customer_country ) ) {
                        if ( isset( $cbcart_session_content['cbcart_customer_country'] ) ) {
                            $cbcart_customer_country = $cbcart_session_content['cbcart_customer_country'];
                        }
                    }

                    $cbcart_customernumber = preg_replace( '/[^0-9]/', '', $cbcart_customer_mobile_no );
                    $cbcart_checkout_url = wc_get_checkout_url();
                    $cbcart_key = "P23R45G67J";
                    $cbcart_name         = "wpac_id";
                    $cbcart_num          = "wpac_num";
                    $cbcart_cipher = "aes-128-gcm";
                    if (in_array($cbcart_cipher, openssl_get_cipher_methods())) {
                        $cbcart_ivlen = openssl_cipher_iv_length($cbcart_cipher);
                        $cbcart_iv = openssl_random_pseudo_bytes($cbcart_ivlen);
                        $cbcart_cipher_number = openssl_encrypt($cbcart_customernumber, $cbcart_cipher, $cbcart_key, $cbcart_options=0, $cbcart_iv, $cbcart_tag);
                        $cbcart_original_plaintext = openssl_decrypt($cbcart_cipher_number, $cbcart_cipher, $cbcart_key, $cbcart_options=0, $cbcart_iv, $cbcart_tag);
                    }
                    $cbcart_base_url     = site_url( $path = '', $scheme = null );
                    $cbcart_checkout_url= str_replace( $cbcart_base_url ,"",$cbcart_checkout_url);
                    $cbcart_checkout_url = $cbcart_checkout_url . "?$cbcart_name=$cbcart_session_id" . "&$cbcart_num=$cbcart_cipher_number";
                    $cbcart_store_name   = get_bloginfo( 'name' );
                    $cbcart_customer_id  = $cbcart_session_id;

                    $cbcart_customername_var= "{{customername}}";
                    $cbcart_storename_var="{{storename}}";
                    $cbcart_productname_var="{{productname}}";
                    $cbcart_amountwithcurrency_var="{{amountwithcurrency}}";
                    $cbcart_customeremail_var="{{customeremail}}";
                    $cbcart_customernumber_var="{{customernumber}}";
                    $cbcart_storeurl_var="{{storeurl}}";
                    $cbcart_checkouturl_var="{{checkouturl}}";

                    $cbcart_is_button_url_1_msg1 = str_replace( '{{storename}}', $cbcart_store_name, $cbcart_is_button_url_1 );
                    $cbcart_is_button_url_1_msg1 = str_replace( '{{checkouturl}}', $cbcart_checkout_url, $cbcart_is_button_url_1 );

                    $cbcart_is_button_url_2_msg2 = str_replace( '{{storename}}', $cbcart_store_name, $cbcart_is_button_url_2 );
                    $cbcart_is_button_url_2_msg2 = str_replace( '{{checkouturl}}', $cbcart_checkout_url, $cbcart_is_button_url_2 );

                    $cbcart_is_button_url_3_msg3 = str_replace( '{{storename}}', $cbcart_store_name, $cbcart_is_button_url_3 );
                    $cbcart_is_button_url_3_msg3 = str_replace( '{{checkouturl}}', $cbcart_checkout_url, $cbcart_is_button_url_3 );

                    $cbcart_is_button_url_4_msg4 = str_replace( '{{storename}}', $cbcart_store_name, $cbcart_is_button_url_4 );
                    $cbcart_is_button_url_4_msg4 = str_replace( '{{checkouturl}}', $cbcart_checkout_url, $cbcart_is_button_url_4 );

                    $cbcart_is_button_url_5_msg5 = str_replace( '{{storename}}', $cbcart_store_name, $cbcart_is_button_url_5 );
                    $cbcart_is_button_url_5_msg5 = str_replace( '{{checkouturl}}', $cbcart_checkout_url, $cbcart_is_button_url_5 );

                  if( $cbcart_customer_first_name == ""){
                      $cbcart_customer_first_name ="Customer";

                  }
                  $cbcart_body_param_array_msg1 = array_replace($cbcart_body_param_array,

                        array_fill_keys(
                            array_keys($cbcart_body_param_array, $cbcart_storename_var),
                            $cbcart_store_name
                        ),
                        array_fill_keys(
                            array_keys($cbcart_body_param_array, $cbcart_customername_var),
                            $cbcart_customer_first_name
                        ),
                        array_fill_keys(
                            array_keys($cbcart_body_param_array, $cbcart_checkouturl_var),
                            $cbcart_checkout_url
                        ),
                        array_fill_keys(
                            array_keys($cbcart_body_param_array, $cbcart_productname_var),
                            $cbcart_exploded_names
                        ),
                        array_fill_keys(
                            array_keys($cbcart_body_param_array, $cbcart_amountwithcurrency_var),
                            $cbcart_cart_totals
                        ),
                        array_fill_keys(
                            array_keys($cbcart_body_param_array, $cbcart_customeremail_var),
                            $cbcart_customer_email
                        ),
                        array_fill_keys(
                            array_keys($cbcart_body_param_array, $cbcart_customernumber_var),
                            $cbcart_customernumber
                        ),
                        array_fill_keys(
                            array_keys($cbcart_body_param_array, $cbcart_storeurl_var),
                            $cbcart_base_url
                        )
                    );

                    $cbcart_body_param_array_msg2 = array_replace($cbcart_body_param_array2,
                        array_fill_keys(
                            array_keys($cbcart_body_param_array2, $cbcart_customername_var),
                            $cbcart_customer_first_name
                        ),
                        array_fill_keys(
                            array_keys($cbcart_body_param_array2, $cbcart_storename_var),
                            $cbcart_store_name
                        ),
                        array_fill_keys(
                            array_keys($cbcart_body_param_array2, $cbcart_checkouturl_var),
                            $cbcart_checkout_url
                        ),
                        array_fill_keys(
                            array_keys($cbcart_body_param_array2, $cbcart_productname_var),
                            $cbcart_exploded_names
                        ),
                        array_fill_keys(
                            array_keys($cbcart_body_param_array2, $cbcart_amountwithcurrency_var),
                            $cbcart_cart_totals
                        ),
                        array_fill_keys(
                            array_keys($cbcart_body_param_array2, $cbcart_customeremail_var),
                            $cbcart_customer_email
                        ),
                        array_fill_keys(
                            array_keys($cbcart_body_param_array2, $cbcart_customernumber_var),
                            $cbcart_customernumber
                        ),
                        array_fill_keys(
                            array_keys($cbcart_body_param_array2, $cbcart_storeurl_var),
                            $cbcart_base_url
                        )
                    );

                    $cbcart_body_param_array_msg3 = array_replace($cbcart_body_param_array3,
                        array_fill_keys(
                            array_keys($cbcart_body_param_array3, $cbcart_customername_var),
                            $cbcart_customer_first_name
                        ),
                        array_fill_keys(
                            array_keys($cbcart_body_param_array3, $cbcart_storename_var),
                            $cbcart_store_name
                        ),
                        array_fill_keys(
                            array_keys($cbcart_body_param_array3, $cbcart_checkouturl_var),
                            $cbcart_checkout_url
                        ),
                        array_fill_keys(
                            array_keys($cbcart_body_param_array3, $cbcart_productname_var),
                            $cbcart_exploded_names
                        ),
                        array_fill_keys(
                            array_keys($cbcart_body_param_array3, $cbcart_amountwithcurrency_var),
                            $cbcart_cart_totals
                        ),
                        array_fill_keys(
                            array_keys($cbcart_body_param_array3, $cbcart_customeremail_var),
                            $cbcart_customer_email
                        ),
                        array_fill_keys(
                            array_keys($cbcart_body_param_array3, $cbcart_customernumber_var),
                            $cbcart_customernumber
                        ),
                        array_fill_keys(
                            array_keys($cbcart_body_param_array3, $cbcart_storeurl_var),
                            $cbcart_base_url
                        )
                    );

                    $cbcart_body_param_array_msg4 = array_replace($cbcart_body_param_array4,
                        array_fill_keys(
                            array_keys($cbcart_body_param_array4, $cbcart_customername_var),
                            $cbcart_customer_first_name
                        ),
                        array_fill_keys(
                            array_keys($cbcart_body_param_array4, $cbcart_storename_var),
                            $cbcart_store_name
                        ),
                        array_fill_keys(
                            array_keys($cbcart_body_param_array4, $cbcart_checkouturl_var),
                            $cbcart_checkout_url
                        ),
                        array_fill_keys(
                            array_keys($cbcart_body_param_array4, $cbcart_productname_var),
                            $cbcart_exploded_names
                        ),
                        array_fill_keys(
                            array_keys($cbcart_body_param_array4, $cbcart_amountwithcurrency_var),
                            $cbcart_cart_totals
                        ),
                        array_fill_keys(
                            array_keys($cbcart_body_param_array4, $cbcart_customeremail_var),
                            $cbcart_customer_email
                        ),
                        array_fill_keys(
                            array_keys($cbcart_body_param_array4, $cbcart_customernumber_var),
                            $cbcart_customernumber
                        ),
                        array_fill_keys(
                            array_keys($cbcart_body_param_array4, $cbcart_storeurl_var),
                            $cbcart_base_url
                        )
                    );

                    $cbcart_body_param_array_msg5 = array_replace($cbcart_body_param_array5,
                        array_fill_keys(
                            array_keys($cbcart_body_param_array5, $cbcart_customername_var),
                            $cbcart_customer_first_name
                        ),
                        array_fill_keys(
                            array_keys($cbcart_body_param_array5, $cbcart_storename_var),
                            $cbcart_store_name
                        ),
                        array_fill_keys(
                            array_keys($cbcart_body_param_array5, $cbcart_checkouturl_var),
                            $cbcart_checkout_url
                        ),
                        array_fill_keys(
                            array_keys($cbcart_body_param_array5, $cbcart_productname_var),
                            $cbcart_exploded_names
                        ),
                        array_fill_keys(
                            array_keys($cbcart_body_param_array5, $cbcart_amountwithcurrency_var),
                            $cbcart_cart_totals
                        ),
                        array_fill_keys(
                            array_keys($cbcart_body_param_array5, $cbcart_customeremail_var),
                            $cbcart_customer_email
                        ),
                        array_fill_keys(
                            array_keys($cbcart_body_param_array5, $cbcart_customernumber_var),
                            $cbcart_customernumber
                        ),
                        array_fill_keys(
                            array_keys($cbcart_body_param_array5, $cbcart_storeurl_var),
                            $cbcart_base_url
                        )
                    );

                    $cbcart_option_name ="cbcart_abandoned_1";
                    $cbcart_option2_name ="cbcart_abandoned_2";
                    $cbcart_option3_name ="cbcart_abandoned_3";
                    $cbcart_option4_name ="cbcart_abandoned_4";
                    $cbcart_option5_name ="cbcart_abandoned_5";

                        if ($cbcart_option_name == "cbcart_abandoned_1" && $cbcart_session_id == $cbcart_customer_id) {
                            $cbcart_component2 = cbcart::cbcart_build_components($cbcart_option_name, $cbcart_body_param_array_msg1,$cbcart_is_button_url_1_msg1);
                        }
                        if ($cbcart_option2_name == "cbcart_abandoned_2") {
                            $cbcart_component3 = cbcart::cbcart_build_components($cbcart_option2_name, $cbcart_body_param_array_msg2,$cbcart_is_button_url_2_msg2);
                        }
                        if ($cbcart_option3_name == "cbcart_abandoned_3") {
                            $cbcart_component4 = cbcart::cbcart_build_components($cbcart_option3_name, $cbcart_body_param_array_msg3,$cbcart_is_button_url_3_msg3);
                        }
                        if ($cbcart_option4_name == "cbcart_abandoned_4") {
                            $cbcart_component5 = cbcart::cbcart_build_components($cbcart_option4_name, $cbcart_body_param_array_msg4,$cbcart_is_button_url_4_msg4);
                        }
                        if ($cbcart_option5_name == "cbcart_abandoned_5") {
                            $cbcart_component6 = cbcart::cbcart_build_components($cbcart_option5_name, $cbcart_body_param_array_msg5,$cbcart_is_button_url_5_msg5);
                        }


                    // check if data is available in cart and customer number is not empty and access time is set
                    if ( is_array( $cbcart_cart ) && ! empty( $cbcart_cart ) && ! empty( $cbcart_customer_mobile_no ) && ! empty( $cbcart_last_access_time ) && is_numeric( $cbcart_customer_mobile_no ) ) {
                        $cbcart_get_time_difference = ( strtotime( $cbcart_current_time ) - strtotime( $cbcart_last_access_time ) ) / 60;
                        //check if time difference is greater than interval time
                        if ( $cbcart_get_time_difference >= $cbcart_abandoned_interval ) {
                            $cbcart_get_sql = $wpdb->prepare("SELECT COUNT(cbcart_id) FROM $cbcart_cart_table WHERE cbcart_customer_id = %s AND cbcart_status IN (0,1)", $cbcart_session_id); // db call ok; no-cache ok
                            $cbcart_customer_id = $cbcart_session_id;
                            $cbcart_result_count = $wpdb->get_var($cbcart_get_sql);
                            $cbcart_store_name = get_bloginfo('name');

                            // Remove regular expression from mobile number
                            $cbcart_country_code = $cbcart_customer_country;
                            //if customer number is not null check for country code
                            if ($cbcart_customernumber != "") {
                                $cbcart_customernumber = $this->cbcart_check_country($cbcart_country_code, $cbcart_customernumber);
                            }

                            //if result is not null get customer details
                            if ($cbcart_result_count > 0) {
                                if (!empty($cbcart_customernumber) && is_numeric($cbcart_customernumber)) {

                                    $cbcart_update_array = array(
                                        'cbcart_customer_email' => $cbcart_customer_email,
                                        'cbcart_customer_mobile_no' => $cbcart_customernumber,
                                        'cbcart_customer_first_name' => $cbcart_customer_first_name,
                                        'cbcart_customer_last_name' => $cbcart_customer_last_name,
                                        'cbcart_cart_json' => serialize($cbcart_cart),
                                        'cbcart_cart_total_json' => serialize($cbcart_cart_totals),
                                        'cbcart_abandoned_date_time' => $cbcart_current_time,
                                        'cbcart_cart_total' => $cbcart_cart_total,
                                        'cbcart_cart_currency' => '',
                                        'cbcart_last_access_time' => $cbcart_last_access_time,
                                        'cbcart_status' => 1
                                    );
                                    $wpdb->update($cbcart_cart_table, $cbcart_update_array, array(
                                        'cbcart_customer_id' => $cbcart_customer_id,
                                        'cbcart_status' => 1
                                    )); // db call ok; no-cache ok
                                }
                            }else {
                                if (!empty($cbcart_customernumber) && is_numeric($cbcart_customernumber)) {
                                    $cbcart_insert_array = array(
                                        'cbcart_customer_id' => $cbcart_customer_id,
                                        'cbcart_customer_email' => $cbcart_customer_email,
                                        'cbcart_customer_mobile_no' => $cbcart_customernumber,
                                        'cbcart_customer_first_name' => $cbcart_customer_first_name,
                                        'cbcart_customer_last_name' => $cbcart_customer_last_name,
                                        'cbcart_customer_type' => '',
                                        'cbcart_cart_json' => serialize($cbcart_cart),
                                        'cbcart_cart_total_json' => serialize($cbcart_cart_totals),
                                        'cbcart_abandoned_date_time' => $cbcart_current_time,
                                        'cbcart_cart_total' => $cbcart_cart_total,
                                        'cbcart_cart_currency' => '',
                                        'cbcart_last_access_time' => $cbcart_last_access_time,
                                        'cbcart_status' => 1
                                    );
                                    $wpdb->insert($cbcart_cart_table, $cbcart_insert_array); // db call ok; no-cache ok
                                }
                            }
                                $cbcart_check_dnd_function = $this->cbcart_check_dnd();

                                if ($cbcart_check_dnd_function == "true") {

                                } else {
                                    $this->cbcart_send_abandoned_whatsapp_message_cloud($cbcart_session_id, $cbcart_customer_mobile_no, $cbcart_customer_first_name, $cbcart_customer_email, $cbcart_customernumber, $cbcart_customer_id, $cbcart_current_time, $cbcart_exploded_names, $cbcart_component2, $cbcart_temp_name, $cbcart_temp_language, $cbcart_from_number, 1);
                                }

                                if ($cbcart_message2_enable == 'checked') {
                                    if ($cbcart_get_time_difference >= $cbcart_trigger_time2) {
                                        $cbcart_check_dnd_function = $this->cbcart_check_dnd();
                                        if ($cbcart_check_dnd_function == "true") {
                                        } else {
                                            $this->cbcart_send_abandoned_whatsapp_message_cloud($cbcart_session_id, $cbcart_customer_mobile_no, $cbcart_customer_first_name, $cbcart_customer_email, $cbcart_customernumber, $cbcart_customer_id, $cbcart_current_time, $cbcart_exploded_names, $cbcart_component3, $cbcart_temp_name2, $cbcart_temp_language2, $cbcart_from_number, 2);
                                        }
                                    }
                                }

                                if ($cbcart_message3_enable == 'checked') {
                                    if ($cbcart_get_time_difference >= $cbcart_trigger_time3) {
                                        $cbcart_check_dnd_function = $this->cbcart_check_dnd();
                                        if ($cbcart_check_dnd_function == "true") {
                                        } else {
                                            $this->cbcart_send_abandoned_whatsapp_message_cloud($cbcart_session_id, $cbcart_customer_mobile_no, $cbcart_customer_first_name, $cbcart_customer_email, $cbcart_customernumber, $cbcart_customer_id, $cbcart_current_time, $cbcart_exploded_names, $cbcart_component4, $cbcart_temp_name3, $cbcart_temp_language3, $cbcart_from_number, 3);
                                        }
                                    }
                                }

                                if ($cbcart_message4_enable == 'checked') {
                                    if ($cbcart_get_time_difference >= $cbcart_trigger_time4) {
                                        $cbcart_check_dnd_function = $this->cbcart_check_dnd();
                                        if ($cbcart_check_dnd_function == "true") {
                                        } else {
                                            $this->cbcart_send_abandoned_whatsapp_message_cloud($cbcart_session_id, $cbcart_customer_mobile_no, $cbcart_customer_first_name, $cbcart_customer_email, $cbcart_customernumber, $cbcart_customer_id, $cbcart_current_time, $cbcart_exploded_names, $cbcart_component5, $cbcart_temp_name4, $cbcart_temp_language4, $cbcart_from_number, 4);
                                        }
                                    }
                                }

                                if ($cbcart_message5_enable == 'checked') {
                                    if ($cbcart_get_time_difference >= $cbcart_trigger_time5) {
                                        $cbcart_check_dnd_function = $this->cbcart_check_dnd();
                                        if ($cbcart_check_dnd_function == "true") {
                                        } else {
                                            $this->cbcart_send_abandoned_whatsapp_message_cloud($cbcart_session_id, $cbcart_customer_mobile_no, $cbcart_customer_first_name, $cbcart_customer_email, $cbcart_customernumber, $cbcart_customer_id, $cbcart_current_time, $cbcart_exploded_names, $cbcart_component6, $cbcart_temp_name5, $cbcart_temp_language5, $cbcart_from_number, 5);
                                        }
                                    }
                                }

                        }
                    }
                }
            } catch ( Exception $e ) {

                // we are not adding any log files now
            }
        }

        /**
         * function for setting check dnd time
         *
         * @since     1.0.0
         * @version 3.0.4
         */
        public function cbcart_check_dnd() {
            $cbcart_data          = get_option( 'cbcart_dndsettings' );
            $cbcart_data          = json_decode( $cbcart_data );
            $cbcart_data  = sanitize_option("cbcart_dndsettings", $cbcart_data);

            if($cbcart_data != "") {
                $cbcart_is_dnd_enable = $cbcart_data->cbcart_is_dnd_enable;
                $cbcart_dnd_from      = $cbcart_data->cbcart_dnd_from;
                $cbcart_dnd_to        = $cbcart_data->cbcart_dnd_to;
            } else {
                $cbcart_is_dnd_enable = "";
                $cbcart_dnd_from      = "";
                $cbcart_dnd_to        = "";
            }


            if ( $cbcart_is_dnd_enable == "checked" ) {
                $cbcart_type = 'mysql';
                $cbcart_gmt  = false;
                if ( 'mysql' === $cbcart_type ) {
                    $cbcart_type = 'H:i:s';
                }
                $cbcart_timezone     = $cbcart_gmt ? new DateTimeZone( 'UTC' ) : wp_timezone();
                $cbcart_datetime     = new DateTime( 'now', $cbcart_timezone );
                $cbcart_current_time = $cbcart_datetime->format( $cbcart_type );

                if ( ( $cbcart_current_time > $cbcart_dnd_from ) && ( $cbcart_current_time < $cbcart_dnd_to ) ) {
					return true;
                } else {
					return false;
                }
            } else {
                return false;
            }
        }
        /**
         * send abandoned cart message via cloud API
         *
         * @since     1.0.0
         * @version 3.0.4
         * @param String cbcart_session_id,cbcart_customer_mobile_no,cbcart_customer_first_name,cbcart_customer_email,cbcart_customernumber, cbcart_customer_id,cbcart_current_time,cbcart_exploded_names,cbcart_component2,cbcart_ac_template_name,cbcart_ac_template_lang,cbcart_ac_template_varcount,cbcart_from_number,cbcart_message_sequence
         */

        public function cbcart_send_abandoned_whatsapp_message_cloud( $cbcart_session_id, $cbcart_customer_mobile_no, $cbcart_customer_first_name, $cbcart_customer_email, $cbcart_customernumber, $cbcart_customer_id, $cbcart_current_time, $cbcart_exploded_names,$cbcart_component2, $cbcart_temp_name, $cbcart_temp_language,$cbcart_from_number,$cbcart_message_sequence ) {

	        global $wpdb;
	        $cbcart_cart_table   = $wpdb->prefix . 'cbcart_abandoneddetails';
	        $cbcart_data         = get_option( 'cbcart_premiumsettings' );
	        $cbcart_data         = json_decode( $cbcart_data );
            $cbcart_data  = sanitize_option("cbcart_premiumsettings", $cbcart_data);

            if ($cbcart_data != "") {
                $cbcart_bearer_token = $cbcart_data->cbcart_token;
                $cbcart_phone_noid   = $cbcart_data->cbcart_phoneid;
            } else {
                $cbcart_bearer_token = "";
                $cbcart_phone_noid   =  "";
            }
            $cbcart_sent_status = 0;

	        if ( $cbcart_message_sequence > 0 ) {
		        $cbcart_sent_status = $cbcart_message_sequence - 1;
	        }
            $cbcart_message_sent_obj = $wpdb->get_row(
                $wpdb->prepare(
                    "SELECT COUNT(cbcart_id) as count, cbcart_message_api_response as cbcart_response_array FROM {$cbcart_cart_table} WHERE cbcart_customer_id = %s AND cbcart_message_sent = %d AND cbcart_status IN (0,1)",
                    $cbcart_session_id,
                    $cbcart_sent_status
                )
            ); $cbcart_is_message_sent       = 0;
	        $cbcart_response_object_array = '';

	        if ( is_object( $cbcart_message_sent_obj ) && ! empty( $cbcart_message_sent_obj ) ) {
		        $cbcart_is_message_sent       = $cbcart_message_sent_obj->count;
		        $cbcart_response_object_array = $cbcart_message_sent_obj->response_array;;
	        }

	        if ( $cbcart_is_message_sent > 0 ) {

		        if ( $cbcart_customernumber and is_numeric( $cbcart_customernumber ) ) {

			        $cbcart_language = array( "code" => $cbcart_temp_language );
			        $cbcart_template = array(
				        "name"       => $cbcart_temp_name,
				        "language"   => $cbcart_language,
				        "components" => $cbcart_component2
			        );
			        // call api to send test message
			        $cbcart_data_decoded = array(
				        "messaging_product" => 'whatsapp',
				        "to"                => $cbcart_customernumber,
				        "type"              => 'template',
				        "template"          => $cbcart_template,
			        );
			        $cbcart_data         = json_encode( $cbcart_data_decoded );
			        $cbcart_url          = esc_url( "https://graph.facebook.com/v13.0/$cbcart_phone_noid/messages",'cartbox-messaging-widgets' );
			        $cbcart_response     = wp_remote_post(
				        $cbcart_url, array(
					        'method'  => 'POST',
					        'headers' => array(
						        'Content-Type'  => 'application/json',
						        'Authorization' => 'Bearer ' . $cbcart_bearer_token,
					        ),
					        'body'    => $cbcart_data
				        )
			        );

			        if ( is_array( $cbcart_response ) and isset( $cbcart_response['response'] ) ) {

				        $cbcart_response1 = $cbcart_response['response'];
				        if ( $cbcart_response1['code'] == "200" ) {
                            $cbcart_array_to_insert = array();
					        $cbcart_response_array  = json_decode( $cbcart_response_object_array );
					        if ( is_array( $cbcart_response_array ) ) {
						        $cbcart_array_to_insert = $cbcart_response_array;
					        }
					        array_push( $cbcart_array_to_insert, $cbcart_response1 );

							        $wpdb->update( $cbcart_cart_table, array(
								        "cbcart_message_sent"         => $cbcart_message_sequence,
                                        "cbcart_message_api_request"  => $cbcart_data,
								        "cbcart_message_api_response" => json_encode( $cbcart_response )
							        ), array( 'cbcart_customer_id' => $cbcart_customer_id ) ); // db call ok; no-cache ok
						} else {
                            $wpdb->update( $cbcart_cart_table, array(
                                "cbcart_message_api_request"  => $cbcart_data,
                                "cbcart_message_api_response" => json_encode( $cbcart_response )
                            ), array( 'cbcart_customer_id' => $cbcart_customer_id ) ); // db call ok; no-cache ok

                        }
			        }
		        }
	        }
        }

        /**
         * recover abandoned cart once order is places
         *
         * @since     1.0.0
         * @version 3.0.4
         * @param String cbcart_order_id,cbcart_posted_data,cbcart_order
         */
        public function cbcart_recover_order( $cbcart_order_id, $cbcart_posted_data, $cbcart_order ) {
            global $wpdb;
            $cbcart_execute_flag = true;
            $cbcart_cart_table   = $wpdb->prefix . 'cbcart_abandoneddetails';
            if ( is_a( $cbcart_order, 'WC_Order_Refund' ) ) {
                $cbcart_execute_flag = false;
            }

            if ( $cbcart_execute_flag ) {
                $cbcart_billing_phone  = $cbcart_order->get_billing_phone();
                $cbcart_customernumber = preg_replace( '/[^0-9]/', '', $cbcart_billing_phone );
                $cbcart_country_code   = $cbcart_order->get_billing_country();

                // if customer number is not null
                if ( $cbcart_customernumber != "" ) {
                    $cbcart_customernumber = $this->cbcart_check_country( $cbcart_country_code, $cbcart_customernumber );
                }

                $cbcart_check_abandoned_entry_sql = $wpdb->prepare(
                    "SELECT cbcart_id, cbcart_customer_id FROM $cbcart_cart_table WHERE cbcart_customer_mobile_no LIKE %s AND cbcart_status IN (0,1)",
                    '%' . $wpdb->esc_like($cbcart_customernumber) . '%'
                );
                $cbcart_abandoned_results         = $wpdb->get_results( $cbcart_check_abandoned_entry_sql ); // db call ok; no-cache ok

                if ( is_array( $cbcart_abandoned_results ) && COUNT( $cbcart_abandoned_results ) > 0 ) {
                    foreach ( $cbcart_abandoned_results as $cbcart_result ) {
                        $cbcart_customer_id = $cbcart_result->cbcart_customer_id;

						$wpdb->update( $cbcart_cart_table, array( "cbcart_status" => 2 ), array( 'cbcart_customer_id' => $cbcart_customer_id ) ); // db call ok; no-cache ok

                    }
                }
            }
        }
	}
}

/**
 * Contact form 7 integration
 *
 * @version 3.0.4
 * @since     3.0.0
 * @param contactform,abort,submission
 * @return    string true,false.
 */
function cbcart_wpcf7_before_send_mail_function( $contact_form, $abort, $submission ) {

    $cbcart_data1 = get_option('cbcart_usersettings');
    $cbcart_data1 = json_decode($cbcart_data1);
    $cbcart_data1 = sanitize_option("cbcart_usersettings", $cbcart_data1);

    $cbcart_checkplan = $cbcart_data1->cbcart_planid;
    $cbcart_store_name = get_bloginfo('name');
    global $wpdb;
    $cbcart_detail_table = $wpdb->prefix . 'cbcart_contactformdetails';
    $cbcart_base_url = site_url($path = '', $scheme = null);
    $cbcart_data = (array)$submission->get_posted_data();

    // check for input fields
    if (isset($cbcart_data['your-name'])) {
        $cbcart_firstname = $submission->get_posted_data('your-name');
    } else {
        $cbcart_firstname = "-Not Available-";
    }
    if (isset($cbcart_data['your-email'])) {
        $cbcart_your_email = $submission->get_posted_data('your-email');
    } else {
        $cbcart_your_email = "-Not Available-";
    }
    if (isset($cbcart_data['your-subject'])) {
        $cbcart_your_subject = $submission->get_posted_data('your-subject');
    } else {
        $cbcart_your_subject = "-Not Available-";
    }
    if (isset($cbcart_data['your-message'])) {
        $cbcart_your_message = $submission->get_posted_data('your-message');
    } else {
        $cbcart_your_message = "-Not Available-";
    }
    if (isset($cbcart_data['your-tel'])) {
        $cbcart_telephone = $submission->get_posted_data('your-tel');
    } else if(isset($cbcart_data['telephone'])) {
        $cbcart_telephone = $submission->get_posted_data('telephone');
    }else{
        $cbcart_telephone = "-Not Available-";
    }

    // store data of cf7
    if (empty(get_option('cbcart_testing_cf7')) || !empty(get_option('cbcart_testing_cf7'))) {
        $cbcart_update_notifications_arr = array(
            'firstname' => $cbcart_firstname,
            'your_email' => $cbcart_your_email,
            'your_subject' => $cbcart_your_subject,
            'your_message' => $cbcart_your_message,
            'telephone' => $cbcart_telephone,
        );
        $cbcart_result = update_option('cbcart_testing_cf7', wp_json_encode($cbcart_update_notifications_arr));
    }

    if (preg_match('/(http|ftp|mailto|www|https)/', $cbcart_your_message, $matches)) {
        return false;
    } else {
        if (!empty(get_option('cbcart_adminsettings')) || !empty(get_option('cbcart_contactformsettings'))) {
            $cbcart_data = get_option('cbcart_contactformsettings');
            $cbcart_data = json_decode($cbcart_data);
            $cbcart_data = sanitize_option("cbcart_contactformsettings", $cbcart_data);

            $cbcart_admin_mobileno = $cbcart_data->cbcart_cf7admin_mobileno;
            $cbcart_enable_notification = $cbcart_data->cbcart_cf7enable_notification;
            $cbcart_cf7customer_notification = $cbcart_data->cbcart_cf7customer_notification;

            $cbcart_data = get_option('cbcart_premiumsettings');
            $cbcart_data = json_decode($cbcart_data);
            $cbcart_data = sanitize_option("cbcart_premiumsettings", $cbcart_data);

            $cbcart_bearer_token = $cbcart_data->cbcart_token;
            $cbcart_phone_noid = $cbcart_data->cbcart_phoneid;

            $cbcart_data = get_option('cbcart_cf7_admin');
            $cbcart_data = json_decode($cbcart_data);
            $cbcart_data = sanitize_option("cbcart_cf7_admin", $cbcart_data);

            $cbcart_temp_name = $cbcart_data->cbcart_temp_name;
            $cbcart_temp_language = $cbcart_data->cbcart_temp_language;
            $cbcart_body_param_count = $cbcart_data->cbcart_body_param_count;
            $cbcart_body_param_array = $cbcart_data->cbcart_body_param_array;
            $cbcart_is_button_url_1 = $cbcart_data->cbcart_is_button_url_1;
            $cbcart_data = get_option('cbcart_cf7_customer');
            $cbcart_data = json_decode($cbcart_data);
            $cbcart_data = sanitize_option("cbcart_cf7_customer", $cbcart_data);

            $cbcart_temp_name2 = $cbcart_data->cbcart_temp_name;
            $cbcart_temp_language2 = $cbcart_data->cbcart_temp_language;
            $cbcart_body_param_count2 = $cbcart_data->cbcart_body_param_count;
            $cbcart_body_param_array2 = $cbcart_data->cbcart_body_param_array;
            $cbcart_is_button_url_2 = $cbcart_data->cbcart_is_button_url_1;

            $cbcart_base_url = site_url($path = '', $scheme = null);
            $cbcart_customernumber = preg_replace('/[^0-9]/', '', $cbcart_telephone);

            $cbcart_customername_var = "{{customername}}";
            $cbcart_storename_var = "{{storename}}";
            $cbcart_your_subject_var = "{{customersubject}}";
            $cbcart_your_message_var = "{{customermessage}}";
            $cbcart_your_email_var = "{{customeremail}}";
            $cbcart_telephone_var = "{{customernumber}}";
            $cbcart_base_url_var = "{{storeurl}}";
            $cbcart_customerdetails_var = "{{customerdetails}}";
            $cbcart_customer_details = "Subject:" . $cbcart_your_subject . " " . "Email:" . $cbcart_your_email . " " . "Message:" . $cbcart_your_message . " " . "Site Url:" . $cbcart_base_url;

            if ($cbcart_enable_notification === "1") {

                $cbcart_is_button_url_1_msg1 = str_replace('{{storeurl}}', $cbcart_base_url, $cbcart_is_button_url_1);

                $cbcart_body_param_array = array_replace($cbcart_body_param_array,
                    array_fill_keys(
                        array_keys($cbcart_body_param_array, $cbcart_customername_var),
                        $cbcart_firstname
                    ),
                    array_fill_keys(
                        array_keys($cbcart_body_param_array, $cbcart_storename_var),
                        $cbcart_store_name
                    ),
                    array_fill_keys(
                        array_keys($cbcart_body_param_array, $cbcart_your_subject_var),
                        $cbcart_your_subject
                    ),
                    array_fill_keys(
                        array_keys($cbcart_body_param_array, $cbcart_your_email_var),
                        $cbcart_your_email
                    ),
                    array_fill_keys(
                        array_keys($cbcart_body_param_array, $cbcart_telephone_var),
                        $cbcart_telephone
                    ),
                    array_fill_keys(
                        array_keys($cbcart_body_param_array, $cbcart_base_url_var),
                        $cbcart_base_url
                    ),
                    array_fill_keys(
                        array_keys($cbcart_body_param_array, $cbcart_customerdetails_var),
                        $cbcart_customer_details
                    ),

                );

                $cbcart_language = array("code" => $cbcart_temp_language);
                $cbcart_option_name = "cbcart_cf7_admin";
                $cbcart_component = cbcart::cbcart_build_components($cbcart_option_name, $cbcart_body_param_array, $cbcart_is_button_url_1_msg1);

                $cbcart_template = array(
                    "name" => $cbcart_temp_name,
                    "language" => $cbcart_language,
                    "components" => $cbcart_component
                );

                // call api to send test message
                $cbcart_data_decoded = array(
                    "messaging_product" => 'whatsapp',
                    "to" => $cbcart_admin_mobileno,
                    "type" => 'template',
                    "template" => $cbcart_template,
                );

                $cbcart_data = json_encode($cbcart_data_decoded);
                $cbcart_url = esc_url("https://graph.facebook.com/v13.0/$cbcart_phone_noid/messages",'cartbox-messaging-widgets');
                $cbcart_response = wp_remote_post(
                    $cbcart_url, array(
                        'method' => 'POST',
                        'headers' => array(
                            'Content-Type' => 'application/json',
                            'Authorization' => 'Bearer ' . $cbcart_bearer_token,
                        ),
                        'body' => $cbcart_data
                    )
                );
                if (is_array($cbcart_response) && isset($cbcart_response['body'])) {
                    $cbcart_response_obj = json_decode($cbcart_response['body']);
                    if (is_object($cbcart_response_obj)) {
                        // code to update cbcart_order_notification
                        $cbcart_insert_array = array(
                            'cbcart_user_type' => 'admin',
                            'cbcart_message_api_request' => $cbcart_data,
                            'cbcart_message_api_response' => wp_json_encode($cbcart_response_obj),
                        );
                        $wpdb->insert($cbcart_detail_table, $cbcart_insert_array);

                    }
                }
            }
            if ($cbcart_cf7customer_notification === "1" && is_numeric($cbcart_customernumber)) {

                $cbcart_is_button_url_2_msg2 = str_replace('{{storeurl}}', $cbcart_base_url, $cbcart_is_button_url_2);

                $cbcart_body_param_array2 = array_replace($cbcart_body_param_array2,
                    array_fill_keys(
                        array_keys($cbcart_body_param_array2, $cbcart_customername_var),
                        $cbcart_firstname
                    ),
                    array_fill_keys(
                        array_keys($cbcart_body_param_array2, $cbcart_storename_var),
                        $cbcart_store_name
                    ),
                    array_fill_keys(
                        array_keys($cbcart_body_param_array2, $cbcart_your_subject_var),
                        $cbcart_your_subject
                    ),
                    array_fill_keys(
                        array_keys($cbcart_body_param_array2, $cbcart_your_email_var),
                        $cbcart_your_email
                    ),
                    array_fill_keys(
                        array_keys($cbcart_body_param_array2, $cbcart_telephone_var),
                        $cbcart_telephone
                    ),
                    array_fill_keys(
                        array_keys($cbcart_body_param_array2, $cbcart_base_url_var),
                        $cbcart_base_url
                    ),
                    array_fill_keys(
                        array_keys($cbcart_body_param_array2, $cbcart_customerdetails_var),
                        $cbcart_customer_details
                    ),

                );

                $cbcart_language2 = array("code" => $cbcart_temp_language2);
                $cbcart_option_name = "cbcart_cf7_customer";
                $cbcart_component2 = cbcart::cbcart_build_components($cbcart_option_name, $cbcart_body_param_array2, $cbcart_is_button_url_2_msg2);

                $cbcart_template = array(
                    "name" => $cbcart_temp_name2,
                    "language" => $cbcart_language2,
                    "components" => $cbcart_component2
                );

                // call api to send test message
                $cbcart_data_decoded = array(
                    "messaging_product" => 'whatsapp',
                    "to" => $cbcart_customernumber,
                    "type" => 'template',
                    "template" => $cbcart_template,
                );

                $cbcart_data = json_encode($cbcart_data_decoded);
                $cbcart_url = esc_url("https://graph.facebook.com/v13.0/$cbcart_phone_noid/messages",'cartbox-messaging-widgets');
                $cbcart_response = wp_remote_post(
                    $cbcart_url, array(
                        'method' => 'POST',
                        'headers' => array(
                            'Content-Type' => 'application/json',
                            'Authorization' => 'Bearer ' . $cbcart_bearer_token,
                        ),
                        'body' => $cbcart_data
                    )
                );
                if (is_array($cbcart_response) && isset($cbcart_response['body'])) {
                    $cbcart_response_obj = json_decode($cbcart_response['body']);
                    if (is_object($cbcart_response_obj)) {
                        // code to update cbcart_contactfomr_notification
                        $cbcart_insert_array = array(
                            'cbcart_user_type' => 'customer',
                            'cbcart_message_api_request' => $cbcart_data,
                            'cbcart_message_api_response' => wp_json_encode($cbcart_response_obj),
                        );
                        $wpdb->insert($cbcart_detail_table, $cbcart_insert_array);

                    }
                }

            }

        }

    }
}
add_filter( 'wpcf7_before_send_mail', 'cbcart_wpcf7_before_send_mail_function', 10, 3 );