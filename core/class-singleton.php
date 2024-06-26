<?php
/**
 * Singleton class for all classes.
 *
 * @link    https://wpplugbp.com/
 * @since   1.0.0
 *
 * @author  WPPLUGBP (https://wpplugbp.com)
 * @package WPPLUGBP_Core
 *
 * @copyright (c) 2024, ThemeDyno (http://themedyno.com)
 */

namespace WPPLUGBP\Core;

// Abort if called directly.
defined( 'WPINC' ) || die;

/**
 * Class Singleton
 *
 * @package WPPLUGBP\Core
 */
abstract class Singleton {

	/**
	 * Singleton constructor.
	 *
	 * Protect the class from being initiated multiple times.
	 *
	 * @param array $props Optional properties array.
	 *
	 * @since 1.0.0
	 */
	protected function __construct( $props = array() ) {
		// Protect class from being initiated multiple times.
	}

	/**
	 * Instance obtaining method.
	 *
	 * @return static Called class instance.
	 * @since 1.0.0
	 */
	public static function instance() {
		static $instances = array();

		// @codingStandardsIgnoreLine Plugin-backported
		$called_class_name = get_called_class();

		if ( ! isset( $instances[ $called_class_name ] ) ) {
			$instances[ $called_class_name ] = new $called_class_name();
		}

		return $instances[ $called_class_name ];
	}
}
