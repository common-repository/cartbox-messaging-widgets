<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @link       https://www.cartbox.net/
 * @since      1.0.0
 * @package    cartbox
 * @subpackage cartbox/admin
 * @author     cartbox <hi@cartbox.net>
 */
define('cbcart_FILE_PATH', plugin_dir_url( __FILE__ ));  // Define Plugin Directory URL
if (!class_exists('cbcart_Admin')) {
	class cbcart_Admin {
		/**
		 * The ID of this plugin.
		 *
		 * @since    1.0.0
		 * @version 3.0.4
		 * @access   private
		 * @var      string $plugin_name The ID of this plugin.
		 */
		private $plugin_name;

		/**
		 * The version of this plugin.
		 *
		 * @since    1.0.0
		 * @version 3.0.4
		 * @access   private
		 * @var      string $version The current version of this plugin.
		 */
		private $version;

		/**
		 * Initialize the class and set its properties.
		 *
		 * @param string $plugin_name The name of this plugin.
		 * @param string $version The version of this plugin.
		 *
		 * @since    1.0.0
		 * @version 3.0.4
		 */
		public function __construct( $plugin_name, $version ) {

			$this->plugin_name = $plugin_name;
			$this->version     = $version;
		}
		/**
		 * Register the stylesheets for the admin area.
		 *
		 * @since    1.0.0
		 * @version 3.0.4
		 */
		public function enqueue_styles() {
			$cbcart_valid_pages = array( "cbcart_dashboard", "cbcart_ordernotification", "cbcart_messages_cf", "cbcart_admin_settings_display","cbcart_abandoned_Cart","cbcart_tutorial","cbcart_clicktochat","cbcart_incoming_message" ,"cbcart_early_capture" );
			$cbcart_page        = isset( $_REQUEST['page'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['page'] ) ) : '';
			if ( in_array( $cbcart_page, $cbcart_valid_pages ) ) {
				wp_enqueue_style( $this->plugin_name, cbcart_FILE_PATH. 'css/cbcart-admin.css', array(), 'all' );
                wp_enqueue_style( 'cbcart-bootstrap-min',cbcart_FILE_PATH. 'css/bootstrap.min.css', array() );
				wp_enqueue_style( 'cbcart-datatables-min',cbcart_FILE_PATH. 'css/datatables.min.css', array() );
				wp_enqueue_style( 'cbcart-font-awesome',cbcart_FILE_PATH. 'css/font-awesome.css', array() );
			}
		}

		/**
		 * Register the JavaScript for the admin area.
		 *
		 * @since    1.0.0
		 * @version 3.0.4
		 */
		public function enqueue_scripts() {
			$cbcart_valid_pages = array( "cbcart_dashboard", "cbcart_ordernotification", "cbcart_messages_cf","cbcart_admin_settings_display","cbcart_abandoned_Cart","cbcart_tutorial","cbcart_clicktochat","cbcart_incoming_message", "cbcart_early_capture" );
			$cbcart_page        = isset( $_REQUEST['page'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['page'] ) ) : '';
			if ( in_array( $cbcart_page, $cbcart_valid_pages ) ) {
				wp_enqueue_script( $this->plugin_name, cbcart_FILE_PATH. 'js/cbcart-admin.js', array( 'jquery' ), false );
                wp_enqueue_script( 'cbcart-bootstrap-bundle-min',cbcart_FILE_PATH. 'js/bootstrap.bundle.min.js' );
				wp_enqueue_script( 'cbcart-datatable-min',cbcart_FILE_PATH. 'js/datatables.min.js');
				wp_enqueue_script( 'cbcart-daterangepicker-min',cbcart_FILE_PATH. 'js/daterangepicker.min.js' );
                wp_register_script('cbcart_jquery', includes_url('js/dist/vendor/moment.min.js'), array(), false);
                wp_enqueue_script('cbcart_jquery');
                wp_enqueue_script( 'cbcart-popper-min',cbcart_FILE_PATH. 'js/popper.min.js' );
				wp_enqueue_script( 'cbcart-bootstrap-min',cbcart_FILE_PATH. 'js/bootstrap.min.js' );
				wp_localize_script('cbcart-admin', 'cbcart_ajax_object', array( 'ajax_url' => admin_url('admin-ajax.php') ));
			}
		}

        /**
         * Register cartbox dashboard menu
         *
         * @since    1.0.0
         * @version 3.0.4
         */
        public function cbcart_dashboard_menu() {
            ob_start(); // started buffer
            include_once(CBCART_PATH . "admin/partials/cbcart-admin-dashboard.php");
            $cbcart_view = ob_get_contents(); // reading content
            ob_end_clean(); // closing and cleaning buffer
            echo wp_kses_post( $cbcart_view );
        }

        /**
		 * Register cartbox plugin menu
		 *
		 * @since    1.0.0
		 * @version 3.0.4
		 */
        public function cbcart_plugin_menu() {
            add_menu_page( "Dashboard", "Cartbox", "manage_options", "cbcart_dashboard", array($this, "cbcart_dashboard_menu"), plugin_dir_url(__FILE__) . 'images/cbcart-new-logo.png', "90" );
            add_submenu_page( "cbcart_dashboard", esc_html("Dashboard",'cartbox-messaging-widgets' ), esc_html("Dashboard",'cartbox-messaging-widgets' ), "manage_options", "cbcart_dashboard", array($this, "cbcart_dashboard_menu") );
            add_submenu_page( "cbcart_dashboard", esc_html("Click To Chat",'cartbox-messaging-widgets' ), esc_html("Click To Chat",'cartbox-messaging-widgets' ), "manage_options", "cbcart_clicktochat", array($this, "cbcart_click_to_chat") );
            add_submenu_page( "cbcart_dashboard", esc_html("Order Notification",'cartbox-messaging-widgets' ), esc_html("Order Notification",'cartbox-messaging-widgets' ), "manage_options", "cbcart_ordernotification", array($this, "cbcart_order_notification") );
            add_submenu_page( "cbcart_dashboard", esc_html("Abandoned Cart",'cartbox-messaging-widgets' ),  esc_html("Abandoned Cart",'cartbox-messaging-widgets' ), "manage_options", "cbcart_abandoned_Cart", array($this, "cbcart_abandoned_Cart") );
            add_submenu_page( "cbcart_dashboard", esc_html("Message Notification for CF7",'cartbox-messaging-widgets' ), esc_html("Message Notification for CF7",'cartbox-messaging-widgets' ), "manage_options", "cbcart_messages_cf", array($this, "cbcart_messages_cf7") );
            add_submenu_page( "cbcart_dashboard", esc_html("Incoming Message",'cartbox-messaging-widgets' ),  esc_html("Incoming Message",'cartbox-messaging-widgets' ), "manage_options", "cbcart_incoming_message", array($this,"cbcart_incoming_message") );
            add_submenu_page( "cbcart_dashboard", esc_html("Mobile Capture",'cartbox-messaging-widgets' ),  esc_html("Mobile Capture",'cartbox-messaging-widgets' ), "manage_options", "cbcart_early_capture", array($this,"cbcart_early_capture") );
            add_submenu_page( "cbcart_dashboard", esc_html("CloudAPI Tutorial",'cartbox-messaging-widgets' ),  esc_html("CloudAPI Tutorial",'cartbox-messaging-widgets' ), "manage_options", "cbcart_tutorial", array($this,"cbcart_tutorial") );
            add_submenu_page( "cbcart_dashboard", esc_html("Settings",'cartbox-messaging-widgets' ),  esc_html("Settings",'cartbox-messaging-widgets' ), "manage_options", "cbcart_admin_settings_display", array($this,"cbcart_admin_settings_display") );
        }


        /**
         * function flow
         *
         * @since    1.0.0
         * @version 3.0.4
         */
        public function cbcart_ccflow()
        {
            $cbcart_pagestatus = "notdone";
                $cbcart_data1 = get_option('cbcart_testmessagesetup');
                $cbcart_data1 = json_decode($cbcart_data1);
                $cbcart_data1          = sanitize_option(  "cbcart_testmessagesetup",$cbcart_data1 );

                if ($cbcart_data1 != "") {
                    $cbcart_checktest = $cbcart_data1->cbcart_checktest;
                } else {
                    $cbcart_checktest = "";
                }
                $cbcart_data1 = get_option('cbcart_createtemplates');
                $cbcart_data1 = json_decode($cbcart_data1);
            $cbcart_data1          = sanitize_option(  "cbcart_createtemplates",$cbcart_data1 );
                if ($cbcart_data1 != "") {
                    $cbcart_responsecode = $cbcart_data1->responsecode;
                } else {
                    $cbcart_responsecode = "";
                }
                $cbcart_data1 = get_option('cbcart_success');
                $cbcart_data1 = json_decode($cbcart_data1);
            $cbcart_data1          = sanitize_option(  "cbcart_success",$cbcart_data1 );

                if ($cbcart_data1 != "") {
                    $cbcart_isvisited_success = $cbcart_data1->cbcart_isvisited;
                } else {
                    $cbcart_isvisited_success = "";
                }
                $cbcart_data2 = get_option('cbcart_usersettings');
                $cbcart_data2 = json_decode($cbcart_data2);
                $cbcart_data2          = sanitize_option(  "cbcart_usersettings",$cbcart_data2 );


                if ($cbcart_data2 != "") {
                    $cbcart_plan = $cbcart_data2->cbcart_planid;
                } else {
                    $cbcart_plan = "";
                }
                if ($cbcart_checktest === "") {
                    include_once(CBCART_PATH . "admin/partials/cbcart-admin-test-message.php");
                    $cbcart_pagestatus = "notdone";
                } else if (!get_option('cbcart_templatescreen') && ($cbcart_plan!="1")) {
                        include_once(CBCART_PATH . "admin/partials/cbcart-admin-createtemplates.php");
                        $cbcart_pagestatus = "notdone";
                } else if ($cbcart_isvisited_success === "") {
                    include_once(CBCART_PATH . "admin/partials/cbcart-admin-success.php");
                    $cbcart_pagestatus = "notdone";
                } else {
                    $cbcart_pagestatus = "done";
                }
            return $cbcart_pagestatus;
        }

        /**
		 * Register cartbox display admin setting
		 *
		 * @since    1.0.0
         * @version 3.0.4
		 */
		public function cbcart_admin_settings_display() {
			ob_start();// started buffer
            $cbcart_data2 = get_option('cbcart_usersettings');
            $cbcart_data2 = json_decode($cbcart_data2);
            $cbcart_data2          = sanitize_option(  "cbcart_usersettings",$cbcart_data2 );
            if ($cbcart_data2 != "") {
                $cbcart_plan = $cbcart_data2->cbcart_planid;
            } else {
                $cbcart_plan = "";
            }
            if($cbcart_plan=="4"){
                if (!get_option('cbcart_premiumsettings')) {
                    include_once(CBCART_PATH . "admin/partials/cbcart-admin-setup-toogle.php");
                } else {
                    $cbcart_pagestatus = $this->cbcart_ccflow();
                    if ($cbcart_pagestatus === "done") {
                        include_once(CBCART_PATH . "admin/partials/cbcart-admin-settings.php");
                    }
                }
            }
            elseif($cbcart_plan!="4") {
                if (!get_option('cbcart_adminsettings')) {
                        include_once(CBCART_PATH . "admin/partials/cbcart-admin-setup-email.php");
                } else {
                    if (get_option('cbcart_adminsettings')) {
                        $cbcart_data = get_option('cbcart_adminsettings');
                        $cbcart_data = json_decode($cbcart_data);
                        $cbcart_data          = sanitize_option(  "cbcart_adminsettings",$cbcart_data );
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
                        if (($cbcart_email === "") || ($cbcart_username === "") || ($cbcart_password === "")) {
                            include_once(CBCART_PATH . "admin/partials/cbcart-admin-setup-email.php");
                        } else if (($cbcart_from_number === "")) {
                            if ($cbcart_plan === "1") {
                                include_once(CBCART_PATH . "admin/partials/cbcart-admin-setup-number.php");
                            } elseif ($cbcart_plan === "2" || $cbcart_plan === "3") {
                                include_once(CBCART_PATH . "admin/partials/cbcart-admin-setup-toogle.php");//premium settings
                            } else {
                                include_once(CBCART_PATH . "admin/partials/cbcart-admin-setup-email.php");
                            }
                        }else if($cbcart_plan!="1"){
                            if (!get_option('cbcart_premiumsettings')) {
                                include_once(CBCART_PATH . "admin/partials/cbcart-admin-setup-toogle.php");//premium setting
                            } else {
                                $cbcart_pagestatus = $this->cbcart_ccflow();
                                if ($cbcart_pagestatus === "done") {
                                    include_once(CBCART_PATH . "admin/partials/cbcart-admin-settings.php");
                                }
                            }
                        }
                        else {
                            $cbcart_pagestatus = $this->cbcart_ccflow();
                            if($cbcart_pagestatus==="done"){
                                include_once(CBCART_PATH . "admin/partials/cbcart-admin-settings.php");
                            }
                        }
                    }
                }
            }
			$cbcart_view = ob_get_contents(); // reading content
			ob_end_clean(); // closing and cleaning buffer
			echo wp_kses_post( $cbcart_view );
		}

        /**
         * Register cartbox display click to chat
         *
         * @since    1.0.0
         * @version 3.0.4
         */
        public function cbcart_click_to_chat(){
            ob_start(); // started buffer
            include_once(CBCART_PATH . "admin/partials/cbcart-admin-clicktochat.php");
            $cbcart_view = ob_get_contents(); // reading content
            ob_end_clean(); // closing and cleaning buffer
            echo wp_kses_post( $cbcart_view );
        }
		/**
		 * Register cartbox display order notifications
		 *
		 * @since    1.0.0
		 * @version 3.0.4
		 */
		public function cbcart_order_notification() {
			ob_start(); // started buffer
            $cbcart_data2 = get_option('cbcart_usersettings');
            $cbcart_data2 = json_decode($cbcart_data2);
            $cbcart_data2          = sanitize_option(  "cbcart_usersettings",$cbcart_data2 );
            if ($cbcart_data2 != "") {
                $cbcart_plan = $cbcart_data2->cbcart_planid;
            } else {
                $cbcart_plan = "";
            }
            if($cbcart_plan=="4"){
                if (!get_option('cbcart_premiumsettings')) {
                    include_once(CBCART_PATH . "admin/partials/cbcart-admin-setup-toogle.php");
                } else {
                    $cbcart_pagestatus = $this->cbcart_ccflow();
                    if ($cbcart_pagestatus === "done") {
                        if(get_option('cbcart_customisetemplate')){
                            include_once(CBCART_PATH . "admin/partials/cbcart-admin-customise-template.php");
                        }else {
                            include_once(CBCART_PATH . "admin/partials/cbcart-admin-order-notification.php");
                        }
                    }
                }
            }
            elseif($cbcart_plan!="4") {
                if (!get_option('cbcart_adminsettings')) {
                    include_once(CBCART_PATH . "admin/partials/cbcart-admin-setup-email.php");
                } else {
                    if (get_option('cbcart_adminsettings')) {
                        $cbcart_data = get_option('cbcart_adminsettings');
                        $cbcart_data = json_decode($cbcart_data);
                        $cbcart_data          = sanitize_option(  "cbcart_adminsettings",$cbcart_data );
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
                        if (($cbcart_email === "") || ($cbcart_username === "") || ($cbcart_password === "")) {
                            include_once(CBCART_PATH . "admin/partials/cbcart-admin-setup-email.php");
                        } else if (($cbcart_from_number === "")) {
                            if ($cbcart_plan === "1") {
                                include_once(CBCART_PATH . "admin/partials/cbcart-admin-setup-number.php");
                            } elseif ($cbcart_plan === "2" || $cbcart_plan === "3") {
                                include_once(CBCART_PATH . "admin/partials/cbcart-admin-setup-toogle.php");//premium settings
                            } else {
                                include_once(CBCART_PATH . "admin/partials/cbcart-admin-setup-email.php");
                            }
                        }else if($cbcart_plan!="1"){
                            if (!get_option('cbcart_premiumsettings')) {
                                include_once(CBCART_PATH . "admin/partials/cbcart-admin-setup-toogle.php");//premium setting
                            } else {
                                $cbcart_pagestatus = $this->cbcart_ccflow();
                                if ($cbcart_pagestatus === "done") {
                                    if(get_option('cbcart_customisetemplate')){
                                        include_once(CBCART_PATH . "admin/partials/cbcart-admin-customise-template.php");
                                    }else {
                                        include_once(CBCART_PATH . "admin/partials/cbcart-admin-order-notification.php");
                                    }
                                }
                            }
                        }
                        else {
                            $cbcart_pagestatus = $this->cbcart_ccflow();
                            if($cbcart_pagestatus==="done"){
                                if(get_option('cbcart_customisetemplate')){
                                    include_once(CBCART_PATH . "admin/partials/cbcart-admin-customise-template.php");
                                }else {
                                    include_once(CBCART_PATH . "admin/partials/cbcart-admin-order-notification.php");
                                }
                            }
                        }
                    }
                }
            }

			$cbcart_view = ob_get_contents(); // reading content
			ob_end_clean(); // closing and cleaning buffer
			echo wp_kses_post( $cbcart_view );
		}

		/**
		 * Register cartbox contact form 7 page
		 *
		 * @since    1.0.0
		 * @version 3.0.4
		 */
		public function cbcart_messages_cf7() {
            ob_start();// started buffer
            $cbcart_data2 = get_option('cbcart_usersettings');
            $cbcart_data2 = json_decode($cbcart_data2);
            $cbcart_data2          = sanitize_option(  "cbcart_usersettings",$cbcart_data2 );

            if ($cbcart_data2 != "") {
                $cbcart_plan = $cbcart_data2->cbcart_planid;
            } else {
                $cbcart_plan = "";
            }
            if($cbcart_plan=="4"){
                if (!get_option('cbcart_premiumsettings')) {
                    include_once(CBCART_PATH . "admin/partials/cbcart-admin-setup-toogle.php");
                } else {
                    $cbcart_pagestatus = $this->cbcart_ccflow();
                    if ($cbcart_pagestatus === "done") {
                        if(get_option('cbcart_customisetemplate')){
                            include_once(CBCART_PATH . "admin/partials/cbcart-admin-customise-template.php");
                        }else {
                            include_once(CBCART_PATH . "admin/partials/cbcart-admin-message-cf7.php");
                        }
                    }
                }
            }
            elseif($cbcart_plan!="4") {
                if (!get_option('cbcart_adminsettings')) {
                    include_once(CBCART_PATH . "admin/partials/cbcart-admin-setup-email.php");
                } else {
                    if (get_option('cbcart_adminsettings')) {
                        $cbcart_data = get_option('cbcart_adminsettings');
                        $cbcart_data = json_decode($cbcart_data);
                        $cbcart_data          = sanitize_option(  "cbcart_adminsettings",$cbcart_data );
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
                        if (($cbcart_email === "") || ($cbcart_username === "") || ($cbcart_password === "")) {
                            include_once(CBCART_PATH . "admin/partials/cbcart-admin-setup-email.php");
                        } else if (($cbcart_from_number === "")) {
                            if ($cbcart_plan === "1") {
                                include_once(CBCART_PATH . "admin/partials/cbcart-admin-setup-number.php");
                            } elseif ($cbcart_plan === "2" || $cbcart_plan === "3") {
                                include_once(CBCART_PATH . "admin/partials/cbcart-admin-setup-toogle.php");//premium settings
                            } else {
                                include_once(CBCART_PATH . "admin/partials/cbcart-admin-setup-email.php");
                            }
                        }else if($cbcart_plan!="1"){
                            if (!get_option('cbcart_premiumsettings')) {
                                include_once(CBCART_PATH . "admin/partials/cbcart-admin-setup-toogle.php");//premium setting
                            } else {
                                $cbcart_pagestatus = $this->cbcart_ccflow();
                                if ($cbcart_pagestatus === "done") {
                                    if(get_option('cbcart_customisetemplate')){
                                        include_once(CBCART_PATH . "admin/partials/cbcart-admin-customise-template.php");
                                    }else {
                                        include_once(CBCART_PATH . "admin/partials/cbcart-admin-message-cf7.php");
                                    }
                                }
                            }
                        }
                        else {
                            $cbcart_pagestatus = $this->cbcart_ccflow();
                            if($cbcart_pagestatus==="done"){
                                if(get_option('cbcart_customisetemplate')){
                                    include_once(CBCART_PATH . "admin/partials/cbcart-admin-customise-template.php");
                                }else {
                                    include_once(CBCART_PATH . "admin/partials/cbcart-admin-message-cf7.php");
                                }
                            }
                        }
                    }
                }
            }
            $cbcart_view = ob_get_contents(); // reading content
            ob_end_clean(); // closing and cleaning buffer
            echo wp_kses_post( $cbcart_view );
		}

		/**
		 * Register cartbox display abandoned cart page
		 *
		 * @since    1.0.0
		 * @version 3.0.4
		 */
		public function cbcart_abandoned_Cart() {
        	ob_start(); // started buffer
           $cbcart_data2 = get_option('cbcart_usersettings');
            $cbcart_data2 = json_decode($cbcart_data2);
            $cbcart_data2          = sanitize_option(  "cbcart_usersettings",$cbcart_data2 );
            if ($cbcart_data2 != "") {
                $cbcart_plan = $cbcart_data2->cbcart_planid;
            } else {
                $cbcart_plan = "";
            }
            if (!get_option('cbcart_adminsettings')) {
                include_once(CBCART_PATH . "admin/partials/cbcart-admin-setup-abandonedcart.php");
                // include template file
            }elseif($cbcart_plan=="4"){
                if (!get_option('cbcart_premiumsettings')) {
                    include_once(CBCART_PATH . "admin/partials/cbcart-admin-setup-toogle.php");
                } else {
                    $cbcart_pagestatus = $this->cbcart_ccflow();
                    if ($cbcart_pagestatus === "done") {
                        if (get_option('cbcart_customisetemplate')) {
                            include_once(CBCART_PATH . "admin/partials/cbcart-admin-customise-template.php");
                        } else {
                            include_once(CBCART_PATH . "admin/partials/cbcart-admin-abandonedcart.php");
                        }
                    }
                }
            } elseif($cbcart_plan!="4") {
                if (!get_option('cbcart_adminsettings')) {
                    include_once(CBCART_PATH . "admin/partials/cbcart-admin-setup-email.php");
                } else {
                    if (get_option('cbcart_adminsettings')) {
                        $cbcart_data = get_option('cbcart_adminsettings');
                        $cbcart_data = json_decode($cbcart_data);
                        $cbcart_data          = sanitize_option(  "cbcart_adminsettings",$cbcart_data );
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
                        if (($cbcart_email === "") || ($cbcart_username === "") || ($cbcart_password === "")) {
                            include_once(CBCART_PATH . "admin/partials/cbcart-admin-setup-email.php");
                        } else if (($cbcart_from_number === "")) {
                            if ($cbcart_plan === "1") {
                                include_once(CBCART_PATH . "admin/partials/cbcart-admin-setup-number.php");
                            } elseif ($cbcart_plan === "2" || $cbcart_plan === "3") {
                                include_once(CBCART_PATH . "admin/partials/cbcart-admin-setup-toogle.php");//premium settings
                            } else {
                                include_once(CBCART_PATH . "admin/partials/cbcart-admin-setup-email.php");
                            }
                        }else if($cbcart_plan!="1"){
                            if (!get_option('cbcart_premiumsettings')) {
                                include_once(CBCART_PATH . "admin/partials/cbcart-admin-setup-toogle.php");//premium setting
                            } else {
                                $cbcart_pagestatus = $this->cbcart_ccflow();
                                if ($cbcart_pagestatus === "done") {
                                    if(get_option('cbcart_customisetemplate')){
                                        include_once(CBCART_PATH . "admin/partials/cbcart-admin-customise-template.php");
                                    }else {
                                        include_once(CBCART_PATH . "admin/partials/cbcart-admin-abandonedcart.php");
                                    }
                                }
                            }
                        }
                        else {
                            $cbcart_pagestatus = $this->cbcart_ccflow();
                            if($cbcart_pagestatus==="done"){
                                if(get_option('cbcart_customisetemplate')){
                                    include_once(CBCART_PATH . "admin/partials/cbcart-admin-customise-template.php");
                                }else {
                                    include_once(CBCART_PATH . "admin/partials/cbcart-admin-abandonedcart.php");
                                }
                            }
                        }
                    }
                }
            }
			$cbcart_view = ob_get_contents(); // reading content
			ob_end_clean(); // closing and cleaning buffer
			echo wp_kses_post( $cbcart_view );
		}

        /**
         * Register cartbox display cart tutorial page
         *
         * @since    1.0.0
         * @version 3.0.4
         */
        public function cbcart_tutorial()
        {
            ob_start(); // started buffer
            include_once(CBCART_PATH . "admin/partials/cbcart-admin-startup.php");
            $cbcart_view = ob_get_contents(); // reading content
            ob_end_clean(); // closing and cleaning buffer
            echo wp_kses_post( $cbcart_view );
        }

        /**
         * Register cartbox display incoming message page
         *
         * @since    1.0.0
         * @version 3.0.4
         */
        public function cbcart_incoming_message()
        {
            ob_start(); // started buffer
            $cbcart_data2 = get_option('cbcart_usersettings');
            $cbcart_data2 = json_decode($cbcart_data2);
            $cbcart_data2          = sanitize_option(  "cbcart_usersettings",$cbcart_data2 );
            if ($cbcart_data2 != "") {
                $cbcart_plan = $cbcart_data2->cbcart_planid;
            } else {
                $cbcart_plan = "";
            }
            if($cbcart_plan=="4"){
                if (!get_option('cbcart_premiumsettings')) {
                    include_once(CBCART_PATH . "admin/partials/cbcart-admin-setup-toogle.php");
                } else {
                    $cbcart_pagestatus = $this->cbcart_ccflow();
                    if ($cbcart_pagestatus === "done") {
                        if(get_option('cbcart_customisetemplate')){
                            include_once(CBCART_PATH . "admin/partials/cbcart-admin-customise-template.php");
                        }else {
                            include_once(CBCART_PATH . "admin/partials/cbcart-admin-incoming-message.php");
                        }
                    }
                }
            }
            elseif($cbcart_plan!="4") {
                if (!get_option('cbcart_adminsettings')) {
                    include_once(CBCART_PATH . "admin/partials/cbcart-admin-setup-email.php");
                } else {
                    if (get_option('cbcart_adminsettings')) {
                        $cbcart_data = get_option('cbcart_adminsettings');
                        $cbcart_data = json_decode($cbcart_data);
                        $cbcart_data          = sanitize_option(  "cbcart_adminsettings",$cbcart_data);
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
                        if (($cbcart_email === "") || ($cbcart_username === "") || ($cbcart_password === "")) {
                            include_once(CBCART_PATH . "admin/partials/cbcart-admin-setup-email.php");
                        } else if (($cbcart_from_number === "")) {
                            if ($cbcart_plan === "1") {
                                include_once(CBCART_PATH . "admin/partials/cbcart-admin-setup-number.php");
                            } elseif ($cbcart_plan === "2" || $cbcart_plan === "3") {
                                include_once(CBCART_PATH . "admin/partials/cbcart-admin-setup-toogle.php");//premium settings
                            } else {
                                include_once(CBCART_PATH . "admin/partials/cbcart-admin-setup-email.php");
                            }
                        }else if($cbcart_plan!="1"){
                            if (!get_option('cbcart_premiumsettings')) {
                                include_once(CBCART_PATH . "admin/partials/cbcart-admin-setup-toogle.php");//premium setting
                            } else {
                                $cbcart_pagestatus = $this->cbcart_ccflow();
                                if ($cbcart_pagestatus === "done") {
                                    if(get_option('cbcart_customisetemplate')){
                                        include_once(CBCART_PATH . "admin/partials/cbcart-admin-customise-template.php");
                                    }else {
                                        include_once(CBCART_PATH . "admin/partials/cbcart-admin-incoming-message.php");
                                    }
                                }
                            }
                        }
                        else {
                            $cbcart_pagestatus = $this->cbcart_ccflow();
                            if($cbcart_pagestatus==="done"){
                                if(get_option('cbcart_customisetemplate')){
                                    include_once(CBCART_PATH . "admin/partials/cbcart-admin-customise-template.php");
                                }else {
                                    include_once(CBCART_PATH . "admin/partials/cbcart-admin-incoming-message.php");
                                }
                            }
                        }
                    }
                }
            }

            $cbcart_view = ob_get_contents(); // reading content
            ob_end_clean(); // closing and cleaning buffer
            echo wp_kses_post( $cbcart_view );

        }
        /**
         * Register cartbox display admin setting
         *
         * @since    1.0.0
         * @version 3.0.4
         */
        public function cbcart_early_capture() {
            ob_start(); // started buffer
            include_once(CBCART_PATH . "admin/partials/cbcart-admin-early-capture.php");
            $cbcart_view = ob_get_contents(); // reading content
            ob_end_clean(); // closing and cleaning buffer
            echo wp_kses_post( $cbcart_view );
        }
	}
}

