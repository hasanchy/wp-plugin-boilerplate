<?php
defined( 'ABSPATH' ) or die( 'No direct access allowed!' ); // Avoid direct file request

/**
 * Show an admin notice to administrators when the minimum PHP version
 * could not be reached. The error message is only in english available.
 */
function wpplugbp_skip_php_admin_notice() {
	if ( current_user_can( 'activate_plugins' ) ) {
		$data = get_plugin_data( WPPLUGBP_FILE, true, false );
		echo '<div class=\'notice notice-error\'>
            <p><strong>' .
			esc_html( $data['Name'] ) .
			'</strong> could not be initialized because you need minimum PHP version ' .
			esc_html( WPPLUGBP_MIN_PHP ) .
			' ... you are running: ' .
			esc_html( phpversion() ) .
			'.
        </div>';
	}
}

add_action( 'admin_notices', 'wpplugbp_skip_php_admin_notice' );
