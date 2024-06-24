<?php
namespace WPPLUGBP;

// @codeCoverageIgnoreStart
\defined('ABSPATH') or die('No direct access allowed!');
// Avoid direct file request
// @codeCoverageIgnoreEnd
/**
 * Asset management for frontend scripts and styles.
 */
class Assets
{

    /**
     * Enqueue scripts and styles for admin pages.
     *
     * @param string $hook_suffix The current admin page
     */
    public function admin_enqueue_scripts()
    {
        $this->enqueue_scripts_and_styles();
    }


    public function enqueue_scripts_and_styles()
    {
        
        // Enqueue plugin entry points
        $handle = $this->enqueueScript('wpplugbp-admin', 'admin.js', ['wp-element']);
        $this->enqueueStyle('wpplugbp-admin', 'admin.css');
        // Localize script with server-side variables
        \wp_localize_script($handle, 'appLocalizer', [
            'restUrl' => home_url( '/wp-json' ),
            'restNonce' => wp_create_nonce( 'wp_rest' ),
        ]);

    }

    public function enqueueStyle($handle, $src, $deps = [], $media = 'all', $isLib = \false)
    {
        return $this->enqueue($handle, $src, $deps, $isLib, 'style', null, $media);
    }

    public function enqueueScript($handle, $src, $deps = [], $in_footer = \true, $isLib = \false)
    {
        return $this->enqueue($handle, $src, $deps, $isLib, 'script', $in_footer);
    }

    protected function enqueue($handle, $src, $deps = [], $isLib = \false, $type = 'script', $in_footer = \true, $media = 'all')
    {

        $publicSrc = 'build/' . $src;
        $path = \trailingslashit(WPPLUGBP_PATH) . $publicSrc;
        if (\file_exists($path)) {
            $url = \plugins_url($publicSrc, WPPLUGBP_FILE);
            
            $cachebuster = $this->getCachebusterVersion();
            
            if ($type === 'script') {
                \wp_enqueue_script($handle, $url, $deps, $cachebuster, $in_footer);
            } else {
                \wp_enqueue_style($handle, $url, $deps, $cachebuster, $media);
            }
            return $handle;
        }
        return \false;
    }

    public function getCachebusterVersion()
    {   
        return \wp_rand();
    }

    /**
     * New instance.
     *
     * @codeCoverageIgnore
     */
    public static function instance()
    {
        return new Assets();
    }

}