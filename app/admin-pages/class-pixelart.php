<?php
/**
 * Google Auth block.
 *
 * @link          https://wpplugbp.com/
 * @since         1.0.0
 *
 * @author        WPPLUGBP (https://wpplugbp.com)
 * @package       WPPLUGBP\PluginTest
 *
 * @copyright (c) 2023, Incsub (http://incsub.com)
 */

namespace WPPLUGBP\PluginTest\App\Admin_Pages;

// Abort if called directly.
defined( 'WPINC' ) || die;

use WPPLUGBP\PluginTest\Base;
use WPPLUGBP\PluginTest\Endpoints\V1\Auth_Confirm;

class PixelArt extends Base {
	/**
	 * The page title.
	 *
	 * @var string
	 */
	private $page_title;

	/**
	 * The page slug.
	 *
	 * @var string
	 */
	private $page_slug = 'wpplugbp_pixelart';

	/**
	 * Google auth credentials.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	private $creds = array();

	/**
	 * Option name.
	 *
	 * @var string
	 */
	private $option_name = 'wpplugbp_plugin_tests_auth';

	/**
	 * Page Assets.
	 *
	 * @var array
	 */
	private $page_scripts = array();

	/**
	 * Assets version.
	 *
	 * @var string
	 */
	private $assets_version = '';

	/**
	 * A unique string id to be used in markup and jsx.
	 *
	 * @var string
	 */
	private $unique_id = '';

	/**
	 * Initializes the page.
	 *
	 * @return void
	 * @since 1.0.0
	 *
	 */
	public function init() {
		$this->page_title     = __( 'Pixel Art', 'wp-plugin-boilerplate' );
		$this->creds          = get_option( $this->option_name, array() );
		$this->assets_version = ! empty( $this->script_data( 'version' ) ) ? $this->script_data( 'version' ) : WPPLUGBP_PLUGINTEST_VERSION;
		$this->unique_id      = "wpplugbp_pixelart_main_wrap-{$this->assets_version}";

		add_action( 'admin_menu', array( $this, 'register_admin_page' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets' ) );
		// Add body class to admin pages.
		add_filter( 'admin_body_class', array( $this, 'admin_body_classes' ) );
	}

	public function register_admin_page() {
		$page = add_menu_page(
			$this->page_title,
			'WP - Pixel Art',
			'manage_options',
			$this->page_slug,
			array( $this, 'callback' ),
			'dashicons-google',
			6
		);

		add_action( 'load-' . $page, array( $this, 'prepare_assets' ) );
	}

	/**
	 * The admin page callback method.
	 *
	 * @return void
	 */
	public function callback() {
		$this->view();
	}

	/**
	 * Prepares assets.
	 *
	 * @return void
	 */
	public function prepare_assets() {
		if ( ! is_array( $this->page_scripts ) ) {
			$this->page_scripts = array();
		}

		$handle       = 'wpplugbp_pixelart';
		$src          = WPPLUGBP_PLUGINTEST_ASSETS_URL . '/js/pixelartpage.min.js';
		$style_src    = WPPLUGBP_PLUGINTEST_ASSETS_URL . '/css/pixelartpage.min.css';
		$dependencies = ! empty( $this->script_data( 'dependencies' ) )
			? $this->script_data( 'dependencies' )
			: array(
				'react',
				'wp-element',
				'wp-i18n',
				'wp-is-shallow-equal',
				'wp-polyfill',
			);

		$this->page_scripts[ $handle ] = array(
			'src'       => $src,
			'style_src' => $style_src,
			'deps'      => $dependencies,
			'ver'       => $this->assets_version,
			'strategy'  => true,
			'localize'  => array(
				'dom_element_id'   		=> $this->unique_id,
				'clientID'         		=> 'clientID',
				'clientSecret'     		=> 'clientSecret',
				'redirectUrl'      		=> 'redirectUrl',
				'restEndpointSettings' 	=> home_url( '/wp-json' ) . '/wp-plugin-boilerplate/v1/settings',
				'restNonce'        		=> wp_create_nonce( 'wp_rest' ),
			),
		);
	}

	/**
	 * Gets assets data for given key.
	 *
	 * @param string $key
	 *
	 * @return string|array
	 */
	protected function script_data( string $key = '' ) {
		$raw_script_data = $this->raw_script_data();

		return ! empty( $key ) && ! empty( $raw_script_data[ $key ] ) ? $raw_script_data[ $key ] : '';
	}

	/**
	 * Gets the script data from assets php file.
	 *
	 * @return array
	 */
	protected function raw_script_data(): array {
		static $script_data = null;

		if ( is_null( $script_data ) && file_exists( WPPLUGBP_PLUGINTEST_DIR . 'assets/js/pixelartpage.min.asset.php' ) ) {
			$script_data = include WPPLUGBP_PLUGINTEST_DIR . 'assets/js/pixelartpage.min.asset.php';
		}

		return (array) $script_data;
	}

	/**
	 * Prepares assets.
	 *
	 * @return void
	 */
	public function enqueue_assets() {
		if ( ! empty( $this->page_scripts ) ) {
			foreach ( $this->page_scripts as $handle => $page_script ) {
				wp_register_script(
					$handle,
					$page_script['src'],
					$page_script['deps'],
					$page_script['ver'],
					$page_script['strategy']
				);

				if ( ! empty( $page_script['localize'] ) ) {
					wp_localize_script( $handle, 'wpplugbpPixelArt', $page_script['localize'] );
				}

				wp_enqueue_script( $handle );

				if ( ! empty( $page_script['style_src'] ) ) {
					wp_enqueue_style( $handle, $page_script['style_src'], array(), $this->assets_version );
				}
			}
		}
	}

	/**
	 * Prints the wrapper element which React will use as root.
	 *
	 * @return void
	 */
	protected function view() {
		echo '<div id="' . esc_attr( $this->unique_id ) . '" class="sui-wrap"></div>';
	}

	/**
	 * Adds the SUI class on markup body.
	 *
	 * @param string $classes
	 *
	 * @return string
	 */
	public function admin_body_classes( $classes = '' ) {
		if ( ! function_exists( 'get_current_screen' ) ) {
			return $classes;
		}

		$current_screen = get_current_screen();

		if ( empty( $current_screen->id ) || ! strpos( $current_screen->id, $this->page_slug ) ) {
			return $classes;
		}

		$classes .= ' sui-' . str_replace( '.', '-', WPPLUGBP_PLUGINTEST_SUI_VERSION ) . ' ';

		return $classes;
	}
}
