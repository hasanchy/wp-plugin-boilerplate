<?php
/**
 * Google Auth Shortcode.
 *
 * @link          https://wpplugbp.com/
 * @since         1.0.0
 *
 * @author        WPPLUGBP (https://wpplugbp.com)
 * @package       WPPLUGBP\PluginTest
 *
 * @copyright (c) 2023, ThemeDyno (http://themedyno.com)
 */

namespace WPPLUGBP\PluginTest\Endpoints\V1;

// Abort if called directly.
defined( 'WPINC' ) || die;

use WPPLUGBP\PluginTest\Endpoint;
use WP_REST_Server;

class Settings extends Endpoint {
	/**
	 * API endpoint for the current endpoint.
	 *
	 * @since 1.0.0
	 *
	 * @var string $endpoint
	 */
	protected $endpoint = 'settings';

	/**
	 * Register the routes for handling auth functionality.
	 *
	 * @return void
	 * @since 1.0.0
	 *
	 */
	public function register_routes() {
		// TODO
		// Add a new Route to logout.

		// Route to get auth url.
		register_rest_route(
			$this->get_namespace(),
			$this->get_endpoint(),
			array(
				array(
					'methods'             => 'GET',
					'callback'            => array(
						$this,
						'get_settings',
					),
					'permission_callback' => array(
						$this,
						'edit_permission',
					),
				),
				array(
					'methods'             => 'POST',
					'args'                => array(
						'data' => array(
							'required'    => true,
							'description' => __( 'The client ID from Google API project.', 'wpmudev-plugin-test' ),
							'type'        => 'object',
						),
					),
					'callback'            => array(
						$this,
						'save_settings',
					),
					'permission_callback' => array(
						$this,
						'edit_permission',
					),
				),
			)
		);
	}

	/**
	 * Save the client id and secret.
	 *
	 *
	 * @since 1.0.0
	 */
	public function get_settings( \WP_REST_Request $request ) {
		$nonce = $request->get_header( 'X-WP-NONCE' );
		if ( ! wp_verify_nonce( $nonce, 'wp_rest' ) ) {
			return new WP_REST_Response( 'Invalid nonce', 403 );
		}

		$wpplugbp_pixel_data = get_option( 'wpplugbp_pixel_data' );

		$response_data = array(
			'wpplugbp_pixel_data' => ( $wpplugbp_pixel_data ) ? unserialize( $wpplugbp_pixel_data ) : null,
		);

		return new \WP_REST_Response( $response_data, 200 );
	}

	/**
	 * Save the client id and secret.
	 *
	 *
	 * @since 1.0.0
	 */
	public function save_settings( \WP_REST_Request $request ) {
		$nonce = $request->get_header( 'X-WP-NONCE' );
		if ( ! wp_verify_nonce( $nonce, 'wp_rest' ) ) {
			return new WP_REST_Response( 'Invalid nonce', 403 );
		}

		$wpplugbp_pixel_data = serialize( $request['data'] );
		update_option( 'wpplugbp_pixel_data', $wpplugbp_pixel_data );

		return new \WP_REST_Response( $response_data, 200 );
	}
}
