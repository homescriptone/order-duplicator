<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              #
 * @since             1.0.0
 * @package           Hs_Od
 *
 * @wordpress-plugin
 * Plugin Name:       Order Duplicator for WooCommerce
 * Plugin URI:        #
 * Description:       Ce plugin sert à dupliquer facilement une commande WooCommerce.
 * Version:           1.0.0
 * Author:            HomeScript
 * Author URI:        #
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       hs-od
 * Domain Path:       /languages
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
define( 'HS_OD_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-hs-od-activator.php
 */
function activate_hs_od() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-hs-od-activator.php';
	Hs_Od_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-hs-od-deactivator.php
 */
function deactivate_hs_od() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-hs-od-deactivator.php';
	Hs_Od_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_hs_od' );
register_deactivation_hook( __FILE__, 'deactivate_hs_od' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-hs-od.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_hs_od() {

	$plugin = new Hs_Od();
	$plugin->run();

}
run_hs_od();
