<?php

/**
 * Fired during plugin activation
 *
 * @link       https://letowp.dev
 * @since      1.0.0
 *
 * @package    Advanced_Search_Disabler
 * @subpackage Advanced_Search_Disabler/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Advanced_Search_Disabler
 * @subpackage Advanced_Search_Disabler/includes
 * @author     LetoWPDev <info@letowp.dev>
 */
class Advanced_Search_Disabler_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate(): void {
		Advanced_Search_Disabler_Settings::install_default_settings();
	}
}
