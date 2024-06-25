<?php
namespace WPPLUGBP\rest;

use WP_Error;
use WP_REST_Response;

\defined( 'ABSPATH' ) or die( 'No direct access allowed!' );

/**
 * Create an example REST Settings.
 */

class Settings {

	private function __construct() {
		// Silence is golden.
	}

	/**
	 * Register endpoints.
	 */
	public function rest_api_init() {
		// \register_rest_route( 'pixel-data/v1', '/settings', [
		//     'methods' => 'GET',
		//     'callback' => [ $this, 'get_settings' ],
		//     'permission_callback' => [ $this, 'permission_callback' ]
		// ] );

		// \register_rest_route( 'pixel-data/v1', '/settings', [
		//     'methods' => 'POST',
		//     'callback' => [ $this, 'save_settings' ],
		//     'permission_callback' => [ $this, 'permission_callback' ]
		// ] );
	}

	public function get_settings() {
		$wpplugbp_pixel_data = get_option( 'wpplugbp_pixel_data' );

		$response = array(
			'wpplugbp_pixel_data' => ( $wpplugbp_pixel_data ) ? unserialize( $wpplugbp_pixel_data ) : null,
		);

		return rest_ensure_response( $response );
	}

	public function save_settings( $req ) {

		if ( isset( $req['data'] ) ) {
			$wpplugbp_pixel_data = serialize( $req['data'] );
			update_option( 'wpplugbp_pixel_data', $wpplugbp_pixel_data );
		} else {
			return new WP_Error( 'rest_wpplugbp_api_settings', 'Pixel data is required', array( 'status' => 400 ) );
		}

		$response = array(
			'Success' => 'Settings saved successfully',
		);

		return new WP_REST_Response( $response );
	}

	/**
	 * Check if user is allowed to call this service requests.
	 */
	public function permission_callback() {
		$permit = self::permit();
		return $permit === null ? \true : $permit;
	}

	/**
	 * Checks if the current user has a given capability and throws an error if not.
	 *
	 * @param string $cap The capability
	 * @throws \WP_Error
	 */
	public static function permit( $cap = 'publish_posts' ) {
		if ( ! \current_user_can( $cap ) ) {
			return new WP_Error( 'rest_wpplugbp_forbidden', \__( 'Forbidden' ), array( 'status' => 403 ) );
		}
		return null;
	}

	/**
	 * New instance.
	 */
	public static function instance() {
		return new \WPPLUGBP\rest\Settings();
	}
}
