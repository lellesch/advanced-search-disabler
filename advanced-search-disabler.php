<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://letowp.dev
 * @since             1.0.0
 * @package           Advanced_Search_Disabler
 *
 * @wordpress-plugin
 * Plugin Name:       Advanced Search Disabler
 * Plugin URI:        https://letowp.dev
 * Description:       Advanced Search Disabler allows you to specifically deactivate the search function on your WordPress website.
 * Version:           1.0.3
 * Author:            LetoWPDev
 * Author URI:        https://letowp.dev/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       advanced-search-disabler
 * Domain Path:       /languages
 * Requires PHP:      8.1.0
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'ADVANCED_SEARCH_DISABLER_VERSION', '1.0.3' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-advanced-search-disabler-activator.php
 */
function leto_activate_advanced_search_disabler(): void {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-advanced-search-disabler-activator.php';
	Advanced_Search_Disabler_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-advanced-search-disabler-deactivator.php
 */
function leto_deactivate_advanced_search_disabler(): void {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-advanced-search-disabler-deactivator.php';
	Advanced_Search_Disabler_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'leto_activate_advanced_search_disabler' );
register_deactivation_hook( __FILE__, 'leto_deactivate_advanced_search_disabler' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-advanced-search-disabler.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function leto_run_advanced_search_disabler(): void {

	$plugin = new Advanced_Search_Disabler();
	$plugin->run();

}

leto_run_advanced_search_disabler();
