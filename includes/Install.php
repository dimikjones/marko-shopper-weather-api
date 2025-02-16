<?php
/**
 * Handle plugin's install actions.
 *
 * @class       Install
 * @version     1.0.0
 * @package     Marko_Shopper_Weather_Api/Classes/
 */

namespace Marko_Shopper_Weather_Api;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Install class
 */
final class Install {

	/**
	 * Install action.
	 */
	public static function install( $sitewide = false ) {

		// Perform install actions here.

		// Trigger action.
		do_action( 'marko_shopper_weather_api_installed', $sitewide );
	}
}
