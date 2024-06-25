<?php

namespace WPPLUGBP\view;

\defined( 'ABSPATH' ) or die( 'No direct access allowed!' );
// Avoid direct file request
/**
 * Add an option page to "Products".
 */
class ConfigPage {

	const COMPONENT_ID = WPPLUGBP_SLUG . '-component';

	/**
	 * Constructor.
	 */
	private function __construct() {
		// Silence is golden.
	}
	/**
	 * Add new menu page.
	 */
	public function admin_menu() {
		\add_menu_page( 'WP Plugin Boilerplate', 'WP Plugin Boilerplate', 'manage_options', 'wp-plugin-boilerplate', array( $this, 'render_component_library' ), 'dashicons-grid-view', 100 );
	}

	/**
	 * Show a "Settings" link in plugins list.
	 *
	 * @param string[] $actions
	 * @return string[]
	 */
	public function plugin_action_links( $actions ) {
		$actions[] = \sprintf( '<a href="%s">%s</a>', $this->getUrl(), \__( 'Pixel Arts' ) );
		return $actions;
	}

	/**
	 * Render the content of the menu page.
	 */
	public function render_component_library() {
		echo '<div id="' . esc_html( self::COMPONENT_ID ) . '" class="wrap"></div>';
	}

	/**
	 * Get the URL of this page.
	 */
	public function getUrl() {
		return \admin_url( 'admin.php?page=' . WPPLUGBP_SLUG );
	}

	/**
	 * New instance.
	 */
	public static function instance() {
		return new \WPPLUGBP\view\ConfigPage();
	}

	public function create_pixel_art_block_init() {
		register_block_type(
			WPPLUGBP_PATH . '/build',
			array(
				'render_callback' => array( $this, 'theHTML' ),
			)
		);
	}

	public function theHTML( $attributes ) {
		$wpplugbp_pixel_data = get_option( 'wpplugbp_pixel_data' );
		$pixel_data          = ( $wpplugbp_pixel_data ) ? unserialize( $wpplugbp_pixel_data ) : array();
		$aspect_ratio        = 320;
		$grid_size           = $aspect_ratio / 16;
		$rect                = '';
		$x                   = 0;
		$y                   = 0;
		for ( $i = 0; $i < count( $pixel_data ); $i++ ) {
			$rect .= '<rect width="' . $grid_size . '" height="' . $grid_size . '" x="' . $x . '" y="' . $y . '" fill="' . $pixel_data[ $i ] . '" />';

			if ( ( $i + 1 ) % 16 === 0 ) {
				$x  = 0;
				$y += $grid_size;
			} else {
				$x += $grid_size;
			}
		}
		$svg = '<svg width="' . $aspect_ratio . '" height="' . $aspect_ratio . '" xmlns="http://www.w3.org/2000/svg">
        ' . $rect . '
            Sorry, your browser does not support inline SVG.  
        </svg>';

		return sprintf(
			'<div>%s</div>',
			$svg
		);
	}
}
