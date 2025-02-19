<?php
/**
 * Handle common hooks.
 *
 * @class       Common
 * @version     1.0.0
 * @package     Marko_Shopper_Weather_Api/Classes/
 */

namespace Marko_Shopper_Weather_Api\Common;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Common main class
 */
final class Main {

	/**
	 * Initialize hooks
	 *
	 * @return void
	 */
	public static function hooks() {
		Api::hooks();
	}
}
