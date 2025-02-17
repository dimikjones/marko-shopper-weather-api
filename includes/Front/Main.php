<?php
/**
 * Handle front hooks.
 *
 * @class       Front
 * @version     1.0.0
 * @package     Marko_Shopper_Weather_Api/Classes/
 */

namespace Marko_Shopper_Weather_Api\Front;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Front main class
 */
final class Main {

	/**
	 * Initialize hooks
	 *
	 * @return void
	 */
	public static function hooks() {
		Assets::hooks();

		Woo_My_Account_Settings::hooks();
	}
}
