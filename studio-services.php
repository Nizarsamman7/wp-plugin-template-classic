<?php
/**
 * Plugin Name:       Studio Services
 * Description:       Starter plugin with a service post type, a settings screen, and a [studio_services] shortcode.
 * Version:           1.0.0
 * Requires at least: 6.4
 * Requires PHP:      7.4
 * Author:            Studio
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       studio-services
 *
 * @package StudioServices
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'STUDIO_SERVICES_VERSION', '1.0.0' );
define( 'STUDIO_SERVICES_PATH', plugin_dir_path( __FILE__ ) );
define( 'STUDIO_SERVICES_URL', plugin_dir_url( __FILE__ ) );

require_once STUDIO_SERVICES_PATH . 'includes/class-studio-cpt.php';
require_once STUDIO_SERVICES_PATH . 'includes/class-studio-settings.php';
require_once STUDIO_SERVICES_PATH . 'includes/class-studio-shortcode.php';

Studio_Service_CPT::init();
Studio_Service_Settings::init();
Studio_Service_Shortcode::init();

register_activation_hook( __FILE__, array( 'Studio_Service_CPT', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Studio_Service_CPT', 'deactivate' ) );
