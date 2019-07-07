<?php
/**
 * Replyable WooCommerce
 *
 * @package   User_Profile_Picture_Enhanced
 * @copyright Copyright(c) 2019, MediaRon LLC
 * @license http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2 (GPL-2.0)
 *
 * Plugin Name: User Profile Picture Enhanced
 * Plugin URI: https://replyable.com/downloads/user-profile-picture-enhanced/
 * Description: An add-on for User Profile Picture.
 * Version: 1.0.0
 * Author: MediaRon LLC
 * Author URI: https://mediaron.com
 * License: GPL2
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: user-profile-picture-enhanced
 * Domain Path: languages
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! defined( 'USER_PROFILE_PICTURE_ENHANCED' ) ) {
	define( 'USER_PROFILE_PICTURE_ENHANCED', true );
}
define( 'USER_PROFILE_PICTURE_ENHANCED_VERSION', '1.0.0' );
define( 'USER_PROFILE_PICTURE_ENHANCED_PLUGIN_NAME', 'User Profile Picture Enhanced' );
define( 'USER_PROFILE_PICTURE_ENHANCED_DIR', plugin_dir_path( __FILE__ ) );
define( 'USER_PROFILE_PICTURE_ENHANCED_URL', plugins_url( '/', __FILE__ ) );
define( 'USER_PROFILE_PICTURE_ENHANCED_SLUG', plugin_basename( __FILE__ ) );
define( 'USER_PROFILE_PICTURE_ENHANCED_FILE', __FILE__ );

// Setup the plugin auto loader.
require_once 'php/autoloader.php';

/**
 * Admin notice for incompatible versions of PHP.
 */
function user_profile_picture_enhanced_php_version_error() {
	printf( '<div class="error"><p>%s</p></div>', esc_html( user_profile_picture_php_version_text() ) );
}

/**
 * Admin notice if User Profile Picture isn't installed.
 */
function user_profile_picture_enhanced_dependency_error() {
	printf(
		'<div class="error"><p>%s</p></div>',
		esc_html__( 'User Profile Picture must be installed to use User Profile Picture Enhanced', 'user-profile-picture-enhanced' )
	);
}
/**
 * String describing the minimum PHP version.
 *
 * "Namespace" is a PHP 5.3 introduced feature. This is a hard requirement
 * for the plugin structure.
 *
 * @return string
 */
function user_profile_picture_php_version_text() {
	return __( 'User Profile Picture Enhanced plugin error: Your version of PHP is too old to run this plugin. You must be running PHP 5.4 or higher.', 'user-profile-picture-enhanced' );
}

// If the PHP version is too low, show warning and return.
if ( version_compare( phpversion(), '5.4', '<' ) ) {
	add_action( 'admin_notices', 'user_profile_picture_enhanced_php_version_error' );
	return;
}

if ( ! defined( 'METRONET_PROFILE_PICTURE_VERSION' ) ) {
	add_action( 'admin_notices', 'user_profile_picture_enhanced_dependency_error' );
	return;
}

/**
 * Get the plugin object.
 *
 * @return \User_Profile_Picture_Enhanced\Plugin
 */
function user_profile_picture_enhanced() {
	static $instance;

	if ( null === $instance ) {
		$instance = new \User_Profile_Picture_Enhanced\Plugin();
	}

	return $instance;
}

/**
 * Setup the plugin instance.
 */
user_profile_picture_enhanced()
	->set_basename( plugin_basename( __FILE__ ) )
	->set_directory( plugin_dir_path( __FILE__ ) )
	->set_file( __FILE__ )
	->set_slug( 'user-profile-picture-enhanced' )
	->set_url( plugin_dir_url( __FILE__ ) )
	->set_version( __FILE__ );

/**
 * Sometimes we need to do some things after the plugin is loaded, so call the Plugin_Interface::plugin_loaded().
 */
add_action( 'plugins_loaded', array( user_profile_picture_enhanced(), 'plugin_loaded' ) );
add_action( 'init', 'user_profile_picture_enhanced_add_i18n' );

/**
 * Add i18n to Replyable WooCommerce
 */
function user_profile_picture_enhanced_add_i18n() {
	load_plugin_textdomain( 'user-profile-picture-enhanced', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
