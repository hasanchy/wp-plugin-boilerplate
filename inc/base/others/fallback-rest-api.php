<?php
defined('ABSPATH') or die('No direct access allowed!'); // Avoid direct file request

/**
 * Show an admin notice to administrators when the minimum WP version
 * could not be reached. The error message is only in english available.
 */
function wpplugbp_skip_rest_admin_notice() {
    if (current_user_can('activate_plugins')) {
        $data = get_plugin_data(WPPLUGBP_FILE, true, false);
        global $wp_version;
        echo '<div class=\'notice notice-error\'>
            <p><strong>' .
            esc_html($data['Name']) .
            '</strong> could not be initialized because you are running WordPress < 4.7 (' .
            esc_html($wp_version) .
            '). If WordPress < 4.7 the plugin needs another plugin <strong>WordPress REST API (Version 2)</strong> to provide needed functionality.
            <a href="' .
            esc_html(admin_url('plugin-install.php?s=WordPress+REST+API+(Version+2)&tab=search&type=term')) .
            '">Show in plugin finder</a> or 
            <a href="' .
            esc_html(admin_url('plugin-install.php?tab=plugin-information&plugin=rest-api&TB_iframe=true')) .
            '">install plugin directly</a>.
        </div>';
    }
}
add_action('admin_notices', 'wpplugbp_skip_rest_admin_notice');
