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

/**
 * Plugin constants. This file is procedural coding style for initialization of
 * the plugin core and definition of plugin configuration.
 */
if ( defined( 'WPPLUGBP_PATH' ) ) {
	require_once __DIR__ . '/inc/base/others/fallback-already.php';
	return;
}

define( 'WPPLUGBP_FILE', __FILE__ );
define( 'WPPLUGBP_PATH', dirname( WPPLUGBP_FILE ) );
define( 'WPPLUGBP_SLUG', basename( WPPLUGBP_PATH ) );
define( 'WPPLUGBP_INC', WPPLUGBP_PATH . '/inc/' );
define( 'WPPLUGBP_MIN_PHP', '7.2.0' ); // Minimum of PHP 7.2 required for autoloading and namespacing
define( 'WPPLUGBP_MIN_WP', '5.2.0' ); // Minimum of WordPress 5.0 required
define( 'WPPLUGBP_NS', 'WPPLUGBP' );

// Check PHP Version and print notice if minimum not reached, otherwise start the plugin core
// require_once WPPLUGBP_INC .
//     'base/others/' .
//     (version_compare(phpversion(), WPPLUGBP_MIN_PHP, '>=') ? 'start.php' : 'fallback-php-version.php');







// Support for site-level autoloading.
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
}


// Plugin version.
if ( ! defined( 'WPPLUGBP_PLUGINTEST_VERSION' ) ) {
	define( 'WPPLUGBP_PLUGINTEST_VERSION', '1.0.0' );
}

// Define WPPLUGBP_PLUGINTEST_PLUGIN_FILE.
if ( ! defined( 'WPPLUGBP_PLUGINTEST_PLUGIN_FILE' ) ) {
	define( 'WPPLUGBP_PLUGINTEST_PLUGIN_FILE', __FILE__ );
}

// Plugin directory.
if ( ! defined( 'WPPLUGBP_PLUGINTEST_DIR' ) ) {
	define( 'WPPLUGBP_PLUGINTEST_DIR', plugin_dir_path( __FILE__ ) );
}

// Plugin url.
if ( ! defined( 'WPPLUGBP_PLUGINTEST_URL' ) ) {
	define( 'WPPLUGBP_PLUGINTEST_URL', plugin_dir_url( __FILE__ ) );
}

// Assets url.
if ( ! defined( 'WPPLUGBP_PLUGINTEST_ASSETS_URL' ) ) {
	define( 'WPPLUGBP_PLUGINTEST_ASSETS_URL', WPPLUGBP_PLUGINTEST_URL . '/assets' );
}

// Shared UI Version.
if ( ! defined( 'WPPLUGBP_PLUGINTEST_SUI_VERSION' ) ) {
	define( 'WPPLUGBP_PLUGINTEST_SUI_VERSION', '2.12.23' );
}


/**
 * WPPLUGBP_PluginTest class.
 */
class WPPLUGBP_PluginTest {

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

		WPPLUGBP\PluginTest\Loader::instance();
	}
}

// Init the plugin and load the plugin instance for the first time.
add_action(
	'plugins_loaded',
	function () {
		WPPLUGBP_PluginTest::get_instance()->load();
	}
);
