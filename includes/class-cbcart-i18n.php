<?php
/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    cartbox
 * @subpackage cartbox/includes
 * @author     cartbox <hi@cartbox.net>
 */
if ( ! class_exists('cbcart_i18n') ) {
class cbcart_i18n {

		public function load_plugin_textdomain() {
			load_plugin_textdomain(
				'cartbox',
				false,
				dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
			);
		}
	}
}
