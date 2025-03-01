<?php
/**
 * Utility methods
 *
 * @class       Utils
 * @version     1.0.0
 * @package     Marko_Shopper_Weather_Api/Classes/
 */

namespace Marko_Shopper_Weather_Api;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Utils class
 */
final class Utils {

	/**
	 * What type of request is this?
	 *
	 * @param  string $type admin, ajax, cron or frontend.
	 * @return bool
	 */
	public static function is_request( $type ) {

		switch ( $type ) {
			case 'admin':
				return is_admin();
			case 'ajax':
				return defined( 'DOING_AJAX' ) && DOING_AJAX;
			case 'cron':
				return defined( 'DOING_CRON' ) && DOING_CRON;
			case 'frontend':
				return ( ! is_admin() || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) && ( ! defined( 'DOING_CRON' ) || ! DOING_CRON );
		}
	}


	/**
	 * Get the plugin url.
	 *
	 * @return string
	 */
	public static function plugin_url() {
		return untrailingslashit( plugins_url( '/', PLUGIN_FILE ) );
	}


	/**
	 * Get the plugin path.
	 *
	 * @return string
	 */
	public static function plugin_path() {
		return untrailingslashit( plugin_dir_path( PLUGIN_FILE ) );
	}


	/**
	 * Get the template path.
	 *
	 * @return string
	 */
	public static function template_path() {
		// Allow 3rd party plugin filter template path from their plugin.
		return apply_filters( 'marko_shopper_weather_api_template_path', 'marko-shopper-weather-api/' );
	}


	/**
	 * Get Ajax URL.
	 *
	 * @return string
	 */
	public static function ajax_url() {
		return admin_url( 'admin-ajax.php', 'relative' );
	}

	/**
	 * Check if it is local installation?
	 *
	 * @return boolean
	 */
	public static function is_local_setup() {
		return in_array( getenv( 'REMOTE_ADDR' ), array( '127.0.0.1', '::1' ), true ) ? true : false;
	}
}
