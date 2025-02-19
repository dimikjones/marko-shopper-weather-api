<?php
/**
 * Register common api.
 *
 * @class       CommonApi
 * @version     1.0.0
 * @package     Marko_Shopper_Weather_Api/Classes/
 */

namespace Marko_Shopper_Weather_Api\Common;
use Marko_Shopper_Weather_Api\Utils;
use Marko_Shopper_Weather_Api\Template;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Common api class
 */
final class Api {

	/**
	 * Hook in methods.
	 */
	public static function hooks() {
		add_action( 'updated_user_meta', array( __CLASS__, 'when_update_any_user_meta' ) );
	}

	/**
	 * Get the post response after making a request to the receiver.
	 *
	 * @return    mixed | void    $html    The modified content included the post information.
	 */
	public static function get_post_response() {
		// Request variable $api_url.
		$api_url = 'http://api.weatherapi.com/v1/current.json';

		$user_id = get_current_user_id();

		$get_plugin_options = get_option( 'marko_shopper_weather_api_options' );

		// Request variable $api_key.
		$api_key = '';

		if ( ! empty( $get_plugin_options['marko-shopper-weather-api-field-api-key'] ) ) {
			$api_key = $get_plugin_options['marko-shopper-weather-api-field-api-key'];
		} elseif ( Utils::is_local_setup() ) {
			$api_key = '9c4bd03fb0e645e2ada152600251402';
		}

		$api_url = add_query_arg(
			array(
				'key' => $api_key,
			),
			$api_url
		);

		$transient_option = maybe_unserialize( $get_plugin_options['marko-shopper-weather-api-field-transient'] );
		$transient_option = isset( $transient_option ) && ! empty( $transient_option ) ? $transient_option : 0;

		if ( 0 !== $transient_option && get_transient( 'marko_shopper_weather_api_transient_id_' . $user_id ) ) {
			$html = get_transient( 'marko_shopper_weather_api_transient_id_' . $user_id );
		} else {

			if ( $user_id <= 0 ) {
				return;
			}

			$user_weather_location = get_user_meta( $user_id, 'marko_swa_user_weather_location', true );

			if ( empty( $user_weather_location ) ) {
				return;
			}

			$api_url = add_query_arg(
				array(
					'q' => $user_weather_location,
				),
				$api_url
			);

			// Make the remote request and retrieve the response.
			$response = wp_remote_get( $api_url );

			// If there's an error, display a message.
			if ( is_wp_error( $response ) ) {
				$html = '<div id="post-error">';
				$html .= esc_html__( 'There was a problem retrieving the response from the server.', 'marko-shopper-weather-api' );
				$html .= '</div>';
			} else {

				$html = json_decode( $response['body'], true );

				set_transient( 'marko_shopper_weather_api_transient_id_' . $user_id, $html, intval( $transient_option ) );
			}
		}

		return $html;
	}

	public static function include_weather_template() {
		$user_id = get_current_user_id();

		$template_args = array();

		$template_args['response'] = self::get_post_response();

		$user_weather_temperature_scale  = get_user_meta( $user_id, 'marko_swa_user_weather_temperature_scale', true );
		$user_weather_options_to_display = get_user_meta( $user_id, 'marko_swa_user_weather_options_to_display', true );

		// User specified options.
		$template_args['temperature_scale'] = ! empty( $user_weather_temperature_scale ) ? $user_weather_temperature_scale : 'c';
		$template_args['display_country']   = in_array( 'country', $user_weather_options_to_display );
		$template_args['display_feelslike'] = in_array( 'feelslike', $user_weather_options_to_display );
		$template_args['display_pressure']  = in_array( 'pressure', $user_weather_options_to_display );
		$template_args['display_humidity']  = in_array( 'humidity', $user_weather_options_to_display );

		Template::get( 'public-user-weather-data.php', $template_args, Utils::plugin_path() . "/templates/" );
	}

	// When user meta gets updated delete transient.
	public static function when_update_any_user_meta() {
		$user_id = get_current_user_id();

		delete_transient( 'marko_shopper_weather_api_transient_id_' . $user_id );
	}
}
