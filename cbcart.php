<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 *
 * @link              https://www.cartbox.net
 * @since             1.0.0
 * @package           cartbox
 *
 * @wordpress-plugin
 * Plugin Name:       cartbox messaging widgets
 * Description:       Cartbox - All-in-one plugin for Abandoned Cart, Click to-chat, Message Notifications, Marketing on WhatsApp for WooCommerce Stores.
 * Version:           3.0.4
 * Author:            CartBox
 * Author URI:        https://www.cartbox.net
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.x
 * Text Domain:       cartbox-messaging-widgets
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    wp_die();
}

define('CBCART_VERSION', '3.0.4'); // Define Version
define('CBCART_FILE', __FILE__); // Define Plugin FILE
define('CBCART_URL', plugins_url('/', __FILE__));  // Define Plugin URL
define('CBCART_PATH', plugin_dir_path(__FILE__));  // Define Plugin Directory Path
define('CBCART_DIR', plugin_dir_url(__DIR__));  // Define Plugin Directory URL
define('CBCART_DOMAIN', 'cartbox-messaging-widgets' ); // Define Text Domain
if ( ! defined( 'CBCART_ABSPATH' ) ) {
    define( 'CBCART_ABSPATH', dirname( __FILE__ ) . '/' ); // Define absolute path with prefix
}
if (! defined('CBCART_PLUGIN_BOOTSTRAP_FILE') ) {
    define('CBCART_PLUGIN_BOOTSTRAP_FILE', __FILE__); // Define bootstrap file path
}
if (! defined('CBCART_PLUGIN_URL') ) {
    define('CBCART_PLUGIN_URL', plugin_dir_url(__FILE__)); // Define plugin directory URL
}
if (! defined('CBCART_PLUGIN_URL') ) {
	define('CBCART_PLUGIN_URL', plugin_dir_url(__FILE__)); // Define plugin directory URL
}

define('cbcart_iscc',"false"); // Define chekpoint
define('cbcart_video_url',esc_url('https://www.cartbox.net/blog/useful-video-tutorials-for-cloud-api/')); // Define chekpoint
define('cbcart_site',esc_url('https://www.cartbox.net'));
define('cbcart_whatsapp_link',esc_url('https://api.whatsapp.com/send?phone=+919106393472&text=hi'));
define('cbcart_product_page_url',esc_url('https://www.cartbox.net'));
define('cbcart_logonew_black',CBCART_DIR . CBCART_DOMAIN .esc_url('/admin/images/cbcart-LogoNew-black.png')); // Define cartbox basic logo
define('cbcart_globicon',CBCART_DIR . CBCART_DOMAIN .esc_url('/admin/images/cbcart-Globeicon.png')); // Define global logo
define('cbcart_chat_icon',CBCART_DIR . CBCART_DOMAIN .esc_url('/admin/images/cbcart-chatsupport.png')); // Define chat icon
define('cbcart_cloudsetup_img',CBCART_DIR . CBCART_DOMAIN .esc_url('/admin/images/cbcart-cloudsetup.jpg'));
define('cbcart_p_token_img',CBCART_DIR . CBCART_DOMAIN .esc_url('/admin/images/cbcart-ptoken.jpg'));
define('cbcart_template_img',CBCART_DIR . CBCART_DOMAIN .esc_url('/admin/images/cbcart-how-to-create-template.jpg'));
define('cbcart_site_pricing',esc_url('https://www.cartbox.net/pricing'));
define('cbcart_cart_awaits',CBCART_DIR . CBCART_DOMAIN .esc_url('/admin/images/cart-awaits.png'));
define('cbcart_order_notify',CBCART_DIR . CBCART_DOMAIN .esc_url('/admin/images/OrderImage.png'));
define('cbcart_contact_form',CBCART_DIR . CBCART_DOMAIN .esc_url('/admin/images/contactform_customer.png'));

$cbcart_country_codes='
                                           <option value="91" name="cbcart_default_country" id="cbcart_default_time_in"
                                                    class="input-line"
                                                    selected>' . esc_html("India +91",'cartbox-messaging-widgets') . '  </option>
                                           <option value="213" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Algeria +213", 'cartbox-messaging-widgets') . '</option>
                                           <option value="376" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Andorra +376", 'cartbox-messaging-widgets') . '</option>
                                           <option value="244" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Angola +244", 'cartbox-messaging-widgets') . '</option>
                                            <option value="1264" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Anguilla +1264", 'cartbox-messaging-widgets') . '</option>
                                            <option value="1268" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Antigua &amp; Barbuda +1268", 'cartbox-messaging-widgets') . '</option>
                                            <option value="54" name="cbcart_default_country" id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Argentina +54", 'cartbox-messaging-widgets') . '</option>
                                            <option value="374" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Armenia +374", 'cartbox-messaging-widgets') . '</option>
                                            <option value="297" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Aruba +297", 'cartbox-messaging-widgets') . '</option>
                                            <option value="61" name="cbcart_default_country" id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Australia +61", 'cartbox-messaging-widgets') . '</option>
                                            <option value="43" name="cbcart_default_country" id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Austria +43", 'cartbox-messaging-widgets') . '</option>
                                            <option value="994" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Azerbaijan +994", 'cartbox-messaging-widgets') . '</option>
                                            <option value="1242" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Bahamas +1242", 'cartbox-messaging-widgets') . '</option>
                                            <option value="973" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Bahrain +973", 'cartbox-messaging-widgets') . '</option>
                                            <option value="880" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Bangladesh +880", 'cartbox-messaging-widgets') . '</option>
                                            <option value="1246" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Barbados +1246", 'cartbox-messaging-widgets') . '</option>
                                            <option value="375" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Belarus +375", 'cartbox-messaging-widgets') . '</option>
                                            <option value="32" name="cbcart_default_country" id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Belgium +32", 'cartbox-messaging-widgets') . '</option>
                                            <option value="501" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Belize +501", 'cartbox-messaging-widgets') . '</option>
                                            <option value="229" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Benin +229", 'cartbox-messaging-widgets') . '</option>
                                            <option value="1441" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Bermuda +1441", 'cartbox-messaging-widgets') . '</option>
                                            <option value="975" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Bhutan +975", 'cartbox-messaging-widgets') . '</option>
                                            <option value="591" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Bolivia +591", 'cartbox-messaging-widgets') . '</option>
                                            <option value="387" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Bosnia Herzegovina +387", 'cartbox-messaging-widgets') . '</option>
                                            <option value="267" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Botswana +267", 'cartbox-messaging-widgets') . '</option>
                                            <option value="55" name="cbcart_default_country" id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Brazil +55", 'cartbox-messaging-widgets') . '</option>
                                            <option value="673" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Brunei +673", 'cartbox-messaging-widgets') . '</option>
                                            <option value="359" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Bulgaria +359", 'cartbox-messaging-widgets') . '</option>
                                            <option value="226" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Burkina Faso +226", 'cartbox-messaging-widgets') . '</option>
                                            <option value="257" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Burundi +257", 'cartbox-messaging-widgets') . '</option>
                                            <option value="855" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Cambodia +855", 'cartbox-messaging-widgets') . '</option>
                                            <option value="237" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Cameroon +237", 'cartbox-messaging-widgets') . '</option>
                                            <option value="1" name="cbcart_default_country" id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Canada +1", 'cartbox-messaging-widgets') . '</option>
                                            <option value="238" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Cape Verde Islands +238", 'cartbox-messaging-widgets') . '</option>
                                            <option value="1345" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Cayman Islands +1345", 'cartbox-messaging-widgets') . '</option>
                                            <option value="236" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Central African Republic +236", 'cartbox-messaging-widgets') . '</option>
                                            <option value="56" name="cbcart_default_country" id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Chile +56", 'cartbox-messaging-widgets') . '</option>
                                            <option value="86" name="cbcart_default_country" id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("China +86", 'cartbox-messaging-widgets') . '</option>
                                            <option value="57" name="cbcart_default_country" id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Colombia +57", 'cartbox-messaging-widgets') . '</option>
                                            <option value="269" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Comoros +269", 'cartbox-messaging-widgets') . '</option>
                                            <option value="242" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Congo +242", 'cartbox-messaging-widgets') . '</option>
                                            <option value="682" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Cook Islands +682", 'cartbox-messaging-widgets') . '</option>
                                            <option value="506" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Costa Rica +506", 'cartbox-messaging-widgets') . '</option>
                                            <option value="385" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Croatia +385", 'cartbox-messaging-widgets') . '</option>
                                            <option value="53" name="cbcart_default_country" id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Cuba +53", 'cartbox-messaging-widgets') . '</option>
                                            <option value="90392" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Cyprus North +90392", 'cartbox-messaging-widgets') . '</option>
                                            <option value="357" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Cyprus South +357", 'cartbox-messaging-widgets') . '</option>
                                            <option value="42" name="cbcart_default_country" id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Czech Republic +42", 'cartbox-messaging-widgets') . '</option>
                                            <option value="45" name="cbcart_default_country" id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Denmark +45", 'cartbox-messaging-widgets') . '</option>
                                            <option value="253" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Djibouti +253", 'cartbox-messaging-widgets') . '</option>
                                            <option value="1809" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Dominica +1809", 'cartbox-messaging-widgets') . '</option>
                                            <option value="1809" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Dominican Republic +1809", 'cartbox-messaging-widgets') . '</option>
                                            <option value="593" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Ecuador +593", 'cartbox-messaging-widgets') . '</option>
                                            <option value="20" name="cbcart_default_country" id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Egypt +20", 'cartbox-messaging-widgets') . '</option>
                                            <option value="503" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("El Salvador +503", 'cartbox-messaging-widgets') . '</option>
                                            <option value="240" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Equatorial Guinea +240", 'cartbox-messaging-widgets') . '</option>
                                            <option value="291" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Eritrea +291", 'cartbox-messaging-widgets') . '</option>
                                            <option value="372" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Estonia +372", 'cartbox-messaging-widgets') . '</option>
                                            <option value="251" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Ethiopia +251", 'cartbox-messaging-widgets') . '</option>
                                            <option value="500" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Falkland Islands +500", 'cartbox-messaging-widgets') . '</option>
                                            <option value="298" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Faroe Islands +298", 'cartbox-messaging-widgets') . '</option>
                                            <option value="679" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Fiji +679", 'cartbox-messaging-widgets') . '</option>
                                            <option value="358" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Finland +358", 'cartbox-messaging-widgets') . '</option>
                                            <option value="33" name="cbcart_default_country" id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("France +33", 'cartbox-messaging-widgets') . '</option>
                                            <option value="594" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("French Guiana +594", 'cartbox-messaging-widgets') . '</option>
                                            <option value="689" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("French Polynesia +689",'cartbox-messaging-widgets') . '</option>
                                            <option value="241" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Gabon +241",'cartbox-messaging-widgets') . '</option>
                                            <option value="220" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Gambia +220",'cartbox-messaging-widgets') . '</option>
                                            <option value="7880" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Georgia +7880",'cartbox-messaging-widgets') . '</option>
                                            <option value="49" name="cbcart_default_country" id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Germany +49",'cartbox-messaging-widgets') . '</option>
                                            <option value="233" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Ghana +233",'cartbox-messaging-widgets') . '</option>
                                            <option value="350" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Gibraltar +350",'cartbox-messaging-widgets') . '</option>
                                            <option value="30" name="cbcart_default_country" id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Greece +30",'cartbox-messaging-widgets') . '</option>
                                            <option value="299" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Greenland +299",'cartbox-messaging-widgets') . '</option>
                                            <option value="1473" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Grenada +1473",'cartbox-messaging-widgets') . '</option>
                                            <option value="590" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Guadeloupe +590",'cartbox-messaging-widgets') . '</option>
                                            <option value="671" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Guam +671",'cartbox-messaging-widgets') . '</option>
                                            <option value="502" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Guatemala +502",'cartbox-messaging-widgets') . '</option>
                                            <option value="224" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Guinea +224",'cartbox-messaging-widgets') . '</option>
                                            <option value="245" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Guinea - Bissau +245",'cartbox-messaging-widgets') . '</option>
                                            <option value="592" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Guyana +592",'cartbox-messaging-widgets') . '</option>
                                            <option value="509" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Haiti +509",'cartbox-messaging-widgets') . '</option>
                                            <option value="504" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Honduras +504",'cartbox-messaging-widgets') . '</option>
                                            <option value="852" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Hong Kong +852",'cartbox-messaging-widgets') . '</option>
                                            <option value="36" name="cbcart_default_country" id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Hungary +36",'cartbox-messaging-widgets') . '</option>
                                            <option value="354" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Iceland +354",'cartbox-messaging-widgets') . '</option>
                                            <option value="91" name="cbcart_default_country" id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("India +91",'cartbox-messaging-widgets') . '</option>
                                            <option value="62" name="cbcart_default_country" id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Indonesia +62",'cartbox-messaging-widgets') . '</option>
                                            <option value="98" name="cbcart_default_country" id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Iran +98",'cartbox-messaging-widgets') . '</option>
                                            <option value="964" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Iraq +964",'cartbox-messaging-widgets') . '</option>
                                            <option value="353" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Ireland +353",'cartbox-messaging-widgets') . '</option>
                                            <option value="972" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Israel +972",'cartbox-messaging-widgets') . '</option>
                                            <option value="39" name="cbcart_default_country" id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Italy +39",'cartbox-messaging-widgets') . '</option>
                                            <option value="1876" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Jamaica +1876",'cartbox-messaging-widgets') . '</option>
                                            <option value="81" name="cbcart_default_country" id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Japan +81",'cartbox-messaging-widgets') . '</option>
                                            <option value="962" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Jordan +962",'cartbox-messaging-widgets') . '</option>
                                            <option value="7" name="cbcart_default_country" id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Kazakhstan +7",'cartbox-messaging-widgets') . '</option>
                                            <option value="254" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Kenya +254",'cartbox-messaging-widgets') . '</option>
                                            <option value="686" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Kiribati +686",'cartbox-messaging-widgets') . '</option>
                                            <option value="850" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Korea North +850",'cartbox-messaging-widgets') . '</option>
                                            <option value="82" name="cbcart_default_country" id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Korea South +82",'cartbox-messaging-widgets') . '</option>
                                            <option value="965" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Kuwait +965",'cartbox-messaging-widgets') . '</option>
                                            <option value="996" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Kyrgyzstan +996",'cartbox-messaging-widgets') . '</option>
                                            <option value="856" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Laos +856",'cartbox-messaging-widgets') . '</option>
                                            <option value="371" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Latvia +371",'cartbox-messaging-widgets') . '</option>
                                            <option value="961" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Lebanon +961",'cartbox-messaging-widgets') . '</option>
                                            <option value="266" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Lesotho +266",'cartbox-messaging-widgets') . '</option>
                                            <option value="231" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Liberia +231",'cartbox-messaging-widgets') . '</option>
                                            <option value="218" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Libya +218",'cartbox-messaging-widgets') . '</option>
                                            <option value="417" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Liechtenstein +417",'cartbox-messaging-widgets') . '</option>
                                            <option value="370" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Lithuania +370",'cartbox-messaging-widgets') . '</option>
                                            <option value="352" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Luxembourg +352",'cartbox-messaging-widgets') . '</option>
                                            <option value="853" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Macao +853",'cartbox-messaging-widgets') . '</option>
                                            <option value="389" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Macedonia +389",'cartbox-messaging-widgets') . '</option>
                                            <option value="261" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Madagascar +261",'cartbox-messaging-widgets') . '</option>
                                            <option value="265" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Malawi +265",'cartbox-messaging-widgets') . '</option>
                                            <option value="60" name="cbcart_default_country" id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Malaysia +60",'cartbox-messaging-widgets') . '</option>
                                            <option value="960" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Maldives +960",'cartbox-messaging-widgets') . '</option>
                                            <option value="223" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Mali +223",'cartbox-messaging-widgets') . '</option>
                                            <option value="356" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Malta +356",'cartbox-messaging-widgets') . '</option>
                                            <option value="692" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Marshall Islands +692",'cartbox-messaging-widgets') . '</option>
                                            <option value="596" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Martinique +596",'cartbox-messaging-widgets') . '</option>
                                            <option value="222" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Mauritania +222",'cartbox-messaging-widgets') . '</option>
                                            <option value="269" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Mayotte +269",'cartbox-messaging-widgets') . '</option>
                                            <option value="52" name="cbcart_default_country" id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Mexico +52",'cartbox-messaging-widgets') . '</option>
                                            <option value="691" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Micronesia +691",'cartbox-messaging-widgets') . '</option>
                                            <option value="373" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Moldova +373",'cartbox-messaging-widgets') . '</option>
                                            <option value="377" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Monaco +377",'cartbox-messaging-widgets') . '</option>
                                            <option value="976" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Mongolia +976",'cartbox-messaging-widgets') . '</option>
                                            <option value="1664" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Montserrat +1664",'cartbox-messaging-widgets') . '</option>
                                            <option value="212" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Morocco +212",'cartbox-messaging-widgets') . '</option>
                                            <option value="258" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Mozambique +258",'cartbox-messaging-widgets') . '</option>
                                            <option value="95" name="cbcart_default_country" id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Myanmar +95",'cartbox-messaging-widgets') . '</option>
                                            <option value="264" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Namibia +264",'cartbox-messaging-widgets') . '</option>
                                            <option value="674" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Nauru +674",'cartbox-messaging-widgets') . '</option>
                                            <option value="977" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Nepal +977",'cartbox-messaging-widgets') . '</option>
                                            <option value="31" name="cbcart_default_country" id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Netherlands +31",'cartbox-messaging-widgets') . '</option>
                                            <option value="687" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("New Caledonia +687",'cartbox-messaging-widgets') . '</option>
                                            <option value="64" name="cbcart_default_country" id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("New Zealand +64",'cartbox-messaging-widgets') . '</option>
                                            <option value="505" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Nicaragua +505",'cartbox-messaging-widgets') . '</option>
                                            <option value="227" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Niger +227",'cartbox-messaging-widgets') . '</option>
                                            <option value="234" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Nigeria +234",'cartbox-messaging-widgets') . '</option>
                                            <option value="683" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Niue +683",'cartbox-messaging-widgets') . '</option>
                                            <option value="672" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Norfolk Islands +672",'cartbox-messaging-widgets') . '</option>
                                            <option value="670" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Northern Marianas +670",'cartbox-messaging-widgets') . '</option>
                                            <option value="47" name="cbcart_default_country" id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Norway +47",'cartbox-messaging-widgets') . '</option>
                                            <option value="968" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Oman +968",'cartbox-messaging-widgets') . '</option>
                                            <option value="680" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Palau +680",'cartbox-messaging-widgets') . '</option>
                                            <option value="507" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Panama +507",'cartbox-messaging-widgets') . '</option>
                                            <option value="675" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Papua New Guinea +675",'cartbox-messaging-widgets') . '</option>
                                            <option value="595" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Paraguay +595",'cartbox-messaging-widgets') . '</option>
                                            <option value="92" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Pakistan +92",'cartbox-messaging-widgets') . '</option>
                                            <option value="51" name="cbcart_default_country" id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Peru +51",'cartbox-messaging-widgets') . '</option>
                                            <option value="63" name="cbcart_default_country" id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Philippines +63",'cartbox-messaging-widgets') . '</option>
                                            <option value="48" name="cbcart_default_country" id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Poland +48",'cartbox-messaging-widgets') . '</option>
                                            <option value="351" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Portugal +351",'cartbox-messaging-widgets') . '</option>
                                            <option value="1787" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Puerto Rico +1787",'cartbox-messaging-widgets') . '</option>
                                            <option value="974" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Qatar +974",'cartbox-messaging-widgets') . '</option>
                                            <option value="262" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Reunion +262",'cartbox-messaging-widgets') . '</option>
                                            <option value="40" name="cbcart_default_country" id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Romania +40",'cartbox-messaging-widgets') . '</option>
                                            <option value="7" name="cbcart_default_country" id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Russia +7",'cartbox-messaging-widgets') . '</option>
                                            <option value="250" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Rwanda +250",'cartbox-messaging-widgets') . '</option>
                                            <option value="378" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("San Marino +378",'cartbox-messaging-widgets') . '</option>
                                            <option value="239" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Sao Tome &amp; Principe +239",'cartbox-messaging-widgets') . '</option>
                                            <option value="966" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Saudi Arabia +966",'cartbox-messaging-widgets') . '</option>
                                            <option value="221" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Senegal +221",'cartbox-messaging-widgets') . '</option>
                                            <option value="381" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Serbia +381",'cartbox-messaging-widgets') . '</option>
                                            <option value="248" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Seychelles +248",'cartbox-messaging-widgets') . '</option>
                                            <option value="232" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Sierra Leone +232",'cartbox-messaging-widgets') . '</option>
                                            <option value="65" name="cbcart_default_country" id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Singapore +65",'cartbox-messaging-widgets') . '</option>
                                            <option value="421" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Slovak Republic +421",'cartbox-messaging-widgets') . '</option>
                                            <option value="386" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Slovenia +386",'cartbox-messaging-widgets') . '</option>
                                            <option value="677" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Solomon Islands +677",'cartbox-messaging-widgets') . '</option>
                                            <option value="252" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Somalia +252",'cartbox-messaging-widgets') . '</option>
                                            <option value="27" name="cbcart_default_country" id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("South Africa +27",'cartbox-messaging-widgets') . '</option>
                                            <option value="34" name="cbcart_default_country" id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Spain +34",'cartbox-messaging-widgets') . '</option>
                                            <option value="94" name="cbcart_default_country" id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Sri Lanka +94",'cartbox-messaging-widgets') . '</option>
                                            <option value="290" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("St. Helena +290",'cartbox-messaging-widgets') . '</option>
                                            <option value="1869" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("St. Kitts +1869",'cartbox-messaging-widgets') . '</option>
                                            <option value="1758" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("St. Lucia +1758",'cartbox-messaging-widgets') . '</option>
                                            <option value="249" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Sudan +249",'cartbox-messaging-widgets') . '</option>
                                            <option value="597" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Suriname +597",'cartbox-messaging-widgets') . '</option>
                                            <option value="268" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Swaziland +268",'cartbox-messaging-widgets') . '</option>
                                            <option value="46" name="cbcart_default_country" id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Sweden +46",'cartbox-messaging-widgets') . '</option>
                                            <option value="41" name="cbcart_default_country" id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Switzerland +41",'cartbox-messaging-widgets') . '</option>
                                            <option value="963" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Syria +963",'cartbox-messaging-widgets') . '</option>
                                            <option value="886" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Taiwan +886",'cartbox-messaging-widgets') . '</option>
                                            <option value="7" name="cbcart_default_country" id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Tajikstan +7",'cartbox-messaging-widgets') . '</option>
                                            <option value="66" name="cbcart_default_country" id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Thailand +66",'cartbox-messaging-widgets') . '</option>
                                            <option value="228" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Togo +228",'cartbox-messaging-widgets') . '</option>
                                            <option value="676" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Tonga +676",'cartbox-messaging-widgets') . '</option>
                                            <option value="1868" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Trinidad &amp; Tobago +1868",'cartbox-messaging-widgets') . '</option>
                                            <option value="216" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Tunisia +216",'cartbox-messaging-widgets') . '</option>
                                            <option value="90" name="cbcart_default_country" id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Turkey +90",'cartbox-messaging-widgets') . '</option>
                                            <option value="7" name="cbcart_default_country" id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Turkmenistan +7",'cartbox-messaging-widgets') . '</option>
                                            <option value="993" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Turkmenistan +993",'cartbox-messaging-widgets') . '</option>
                                            <option value="1649" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Turks &amp; Caicos Islands +1649",'cartbox-messaging-widgets') . '</option>
                                            <option value="688" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Tuvalu +688",'cartbox-messaging-widgets') . '</option>
                                            <option value="1" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("United States of America +1",'cartbox-messaging-widgets') . '</option>
                                           <option value="256" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Uganda +256",'cartbox-messaging-widgets') . '</option>
                                            <option value="380" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Ukraine +380",'cartbox-messaging-widgets') . '</option>
                                            <option value="971" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("United Arab Emirates +971",'cartbox-messaging-widgets') . '</option>
                                           <option value="44" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("United Kingdom +44",'cartbox-messaging-widgets') . '</option>
                                            <option value="598" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Uruguay +598",'cartbox-messaging-widgets') . '</option>                                          
                                            <option value="7" name="cbcart_default_country" id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Uzbekistan +7",'cartbox-messaging-widgets') . '</option>
                                            <option value="678" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Vanuatu +678",'cartbox-messaging-widgets') . '</option>
                                            <option value="379" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Vatican City +379",'cartbox-messaging-widgets') . '</option>
                                            <option value="58" name="cbcart_default_country" id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Venezuela +58",'cartbox-messaging-widgets') . '</option>
                                            <option value="84" name="cbcart_default_country" id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Vietnam +84",'cartbox-messaging-widgets') . '</option>
                                            <option value="84" name="cbcart_default_country" id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Virgin Islands - British +1284",'cartbox-messaging-widgets') . '</option>
                                            <option value="84" name="cbcart_default_country" id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Virgin Islands - US +1340",'cartbox-messaging-widgets') . '</option>
                                            <option value="681" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Wallis &amp; Futuna +681",'cartbox-messaging-widgets') . '</option>
                                            <option value="969" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Yemen (North)+969",'cartbox-messaging-widgets') . '</option>
                                            <option value="967" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Yemen (South)+967",'cartbox-messaging-widgets') . '</option>
                                            <option value="260" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Zambia +260",'cartbox-messaging-widgets') . '</option>
                                            <option value="263" name="cbcart_default_country"
                                                    id="cbcart_default_time_in"
                                                    class="input-line">' . esc_html("Zimbabwe +263",'cartbox-messaging-widgets') . '</option>';

define('cbcart_country_code',$cbcart_country_codes);
global $allowedposttags;
$allowed_atts = array('align' => array(),'target'=>array(), 'class' => array(), 'id' => array(),'disabled'=>array(), 'dir' => array(), 'lang' => array(), 'style' => array(), 'xml:lang' => array(), 'src' => array(), 'alt' => array(), 'name' => array(), 'value' => array(), 'type' => array(),'height'=>array(), 'for' => array(), 'form' => array(), 'readonly' => array(),'rows'=>array(), 'required' => array(),'onclick' => array(), 'autocomplete' => array(),'oninput'=>array(), 'placeholder' => array(), 'maxlength' => array(), 'method' => array(),'selected'=>array(), 'action' => array(),'title'=>array(),'data-toggle'=>array(), 'checked' => array(),'href'=>array());

$allowedposttags['strong'] = $allowed_atts;
$allowedposttags['small'] = $allowed_atts;
$allowedposttags['span'] = $allowed_atts;
$allowedposttags['abbr'] = $allowed_atts;
$allowedposttags['sup'] = $allowed_atts;
$allowedposttags['form'] = $allowed_atts;
$allowedposttags['button'] = $allowed_atts;
$allowedposttags['label'] = $allowed_atts;
$allowedposttags['div'] = $allowed_atts;
$allowedposttags['img'] = $allowed_atts;
$allowedposttags['input'] = $allowed_atts;
$allowedposttags['textarea'] = $allowed_atts;
$allowedposttags['h1'] = $allowed_atts;
$allowedposttags['h2'] = $allowed_atts;
$allowedposttags['h3'] = $allowed_atts;
$allowedposttags['h4'] = $allowed_atts;
$allowedposttags['h5'] = $allowed_atts;
$allowedposttags['h6'] = $allowed_atts;
$allowedposttags['ol'] = $allowed_atts;
$allowedposttags['ul'] = $allowed_atts;
$allowedposttags['li'] = $allowed_atts;
$allowedposttags['em'] = $allowed_atts;
$allowedposttags['p'] = $allowed_atts;
$allowedposttags['a'] = $allowed_atts;
$allowedposttags['script'] = $allowed_atts;
$allowedposttags['b'] = $allowed_atts;
$allowedposttags['u'] = $allowed_atts;
$allowedposttags['table'] = $allowed_atts;
$allowedposttags['select'] = $allowed_atts;
$allowedposttags['option'] = $allowed_atts;

add_action('wp_footer', function(){
    wp_enqueue_script(CBCART_PATH.'public/js/cbcart-public-chat.js');
});


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-cbcart-activator.php
 *
 * @since   1.0.0
 * @version 3.0.4
 */
if (!function_exists('cbcart_activate')) {
    function cbcart_activate()
    {
        require_once CBCART_PATH . 'includes/class-cbcart-activator.php';
        cbcart_Activator::activate();
    }
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-cbcart-deactivator.php
 *
 * @since   1.0.0
 * @version 3.0.4
 */
if (!function_exists('cbcart_deactivate')) {
    function cbcart_deactivate()
    {
        require_once CBCART_PATH . 'includes/class-cbcart-deactivator.php';
        cbcart_Deactivator::deactivate();
    }
}
register_activation_hook(CBCART_FILE, 'cbcart_activate');
register_deactivation_hook(CBCART_FILE, 'cbcart_deactivate');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require CBCART_PATH . 'includes/class-cbcart.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 * @version 3.0.4
 */
function cbcart_run() {

    $plugin = new cbcart();
    $plugin->run();

}
cbcart_run();
