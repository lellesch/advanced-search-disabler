<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://letowp.dev
 * @since      1.0.0
 *
 * @package    Advanced_Search_Disabler
 * @subpackage Advanced_Search_Disabler/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Advanced_Search_Disabler
 * @subpackage Advanced_Search_Disabler/includes
 * @author     LetoWPDev <info@letowp.dev>
 */
class Advanced_Search_Disabler_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain(): void {

		load_plugin_textdomain(
			'advanced-search-disabler',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);
	}
}
