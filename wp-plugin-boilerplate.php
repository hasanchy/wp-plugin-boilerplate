<?php
/**
 * Main file for WordPress.
 *
 * @wordpress-plugin
 * Plugin Name:     WP Plugin Boilerplate
 * Description:     A WordPress plugin that allows users to draw and display pixel art on their website.
 * Author:          Hasan Chowdhury
 * Author URI:      https://github.com/hasanchy
 * Version:         1.0.0
 * Text Domain:     wp-plugin-boilerplate
 * Domain Path:     /languages
 *
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

defined( 'ABSPATH' ) or die( 'No direct access allowed!' ); // Avoid direct file request

define( 'WPPLUGBP_FILE', __FILE__ );
define( 'WPPLUGBP_PATH', dirname( WPPLUGBP_FILE ) );

// Support for site-level autoloading.
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
}

// Plugin version.
if ( ! defined( 'WPPLUGBP_VERSION' ) ) {
	define( 'WPPLUGBP_VERSION', '1.0.0' );
}

// Define WPPLUGBP_PLUGIN_FILE.
if ( ! defined( 'WPPLUGBP_PLUGIN_FILE' ) ) {
	define( 'WPPLUGBP_PLUGIN_FILE', __FILE__ );
}

// Plugin directory.
if ( ! defined( 'WPPLUGBP_DIR' ) ) {
	define( 'WPPLUGBP_DIR', plugin_dir_path( __FILE__ ) );
}

// Languages directory.
if ( ! defined( 'WPPLUGBP_LANGUAGES_DIR' ) ) {
	define( 'WPPLUGBP_LANGUAGES_DIR', WPPLUGBP_DIR . '/languages' );
}

// Plugin url.
if ( ! defined( 'WPPLUGBP_URL' ) ) {
	define( 'WPPLUGBP_URL', plugin_dir_url( __FILE__ ) );
}

// Assets url.
if ( ! defined( 'WPPLUGBP_ASSETS_URL' ) ) {
	define( 'WPPLUGBP_ASSETS_URL', WPPLUGBP_URL . '/assets' );
}


/**
 * WPPLUGBP_PluginTest class.
 */
class WPPLUGBP_WPPluginBoilerplate {

	/**
	 * Holds the class instance.
	 *
	 * @var WPPLUGBP_PluginTest $instance
	 */
	private static $instance = null;

	/**
	 * Return an instance of the class
	 *
	 * Return an instance of the WPPLUGBP_PluginTest Class.
	 *
	 * @return WPPLUGBP_PluginTest class instance.
	 * @since 1.0.0
	 *
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Class initializer.
	 */
	public function load() {
		load_plugin_textdomain(
			'wp-plugin-boilerplate',
			false,
			dirname( plugin_basename( __FILE__ ) ) . '/languages'
		);

		WPPLUGBP\Core\Loader::instance();
	}
}

// Init the plugin and load the plugin instance for the first time.
add_action(
	'plugins_loaded',
	function () {
		WPPLUGBP_WPPluginBoilerplate::get_instance()->load();
	}
);
