<?php
/**
 * Handle WooCommerce my-account settings.
 *
 * @class       Woo_My_Account_Settings
 * @version     1.0.0
 * @package     Marko_Shopper_Weather_Api/Classes/
 */

namespace Marko_Shopper_Weather_Api\Front;

use Marko_Shopper_Weather_Api\Template;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Admin Woo_My_Account_Settings class
 */
final class Woo_My_Account_Settings {

	public static $endpoint = 'user-weather';

	/**
	 * Hook in methods.
	 */
	public static function hooks() {
		add_action( 'init', array( __CLASS__, 'add_endpoint' ) );
		add_filter( 'woocommerce_get_query_vars', array( __CLASS__, 'query_vars' ), 0 );
		add_filter( 'woocommerce_account_menu_items', array( __CLASS__, 'add_user_weather_link_to_my_account_tabs' ) );
		add_action( 'woocommerce_account_' . self::$endpoint . '_endpoint', array( __CLASS__, 'user_weather_tab_content' ) );
		add_filter( 'woocommerce_account_menu_items', array( __CLASS__, 'reorder_my_account_menu' ) );
		add_action( 'template_redirect', array( __CLASS__, 'save_account_details' ) );
		add_action( 'plugins_loaded', array( __CLASS__, 'flush_rewrite_rules' ), 20 );
	}

	// Register new endpoint for My Account page.
	public static function add_endpoint() {
		add_rewrite_endpoint( self::$endpoint, EP_ROOT | EP_PAGES );
	}

	// Add new query var.
	public static function query_vars( $vars ) {
		$vars[ self::$endpoint ] = self::$endpoint;

		return $vars;
	}

	// Insert the new endpoint into the My Account menu.
	public static function add_user_weather_link_to_my_account_tabs( $items ) {
		$items[self::$endpoint] = 'Weather';
		return $items;
	}

	// Add content to the new tab.
	// Note: add_action must follow 'woocommerce_account_{your-endpoint-slug}_endpoint' format.
	public static function user_weather_tab_content() {
		printf( '<h3>%s</h3>', esc_html__( 'User Specific Weather', 'marko-shopper-weather-api' ) );
		Template::get_part( 'public', 'my-account-user-weather-form' );

		// TODO: Api module integration.
		echo 'test';
	}

	// Flush permalinks once on plugin activation.
	public static function flush_rewrite_rules() {
		flush_rewrite_rules();
	}

	// Rename, re-order my account menu items.
	public static function reorder_my_account_menu() {

		$new_order = array(
			'dashboard'       => __( 'Dashboard', 'marko-shopper-weather-api' ),
			'orders'          => __( 'Orders', 'marko-shopper-weather-api' ),
			'downloads'       => __( 'Downloads', 'marko-shopper-weather-api' ),
			'edit-address'    => _n( 'Address', 'Addresses', ( 1 + (int) wc_shipping_enabled() ), 'marko-shopper-weather-api' ),
			'payment-methods' => __( 'Payment methods', 'marko-shopper-weather-api' ),
			'edit-account'    => __( 'Account details', 'marko-shopper-weather-api' ),
			self::$endpoint   => __( 'User Weather', 'marko-shopper-weather-api' ),
			'customer-logout' => __( 'Log out', 'marko-shopper-weather-api' ),
		);
		return $new_order;
	}

	/**
	 * Save user preferences in my-account/user-weather tab.
	 */
	public static function save_account_details() {

		$nonce_value = isset( $_REQUEST['marko_shopper_weather_api_nonce'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['marko_shopper_weather_api_nonce'] ) ) : '';

		if ( ! wp_verify_nonce( $nonce_value, 'marko_shopper_weather_api_action' ) ) {
			return;
		}

		if ( empty( $_POST['action'] ) || 'marko_shopper_weather_api_action' !== $_POST['action'] ) {
			return;
		}

		$recipient_name = ! empty( $_POST['user_weather_location'] ) ? sanitize_text_field( wp_unslash( $_POST['user_weather_location'] ) ) : '';
		$pizza_size     = ! empty( $_POST['user_weather_temperature_scale'] ) ? sanitize_text_field( wp_unslash( $_POST['user_weather_temperature_scale'] ) ) : '';
		$pizza_topping  = ! empty( $_POST['user_weather_options_to_display'] ) ? map_deep( wp_unslash( $_POST['user_weather_options_to_display'] ), 'sanitize_text_field' ) : array();

		wc_nocache_headers();

		$user_id = get_current_user_id();

		if ( $user_id <= 0 ) {
			return;
		}

		// Update user meta value.
		update_user_meta( $user_id, 'marko_swa_user_weather_location', $recipient_name );
		update_user_meta( $user_id, 'marko_swa_user_weather_temperature_scale', $pizza_size );
		update_user_meta( $user_id, 'marko_swa_user_weather_options_to_display', $pizza_topping );
	}
}
