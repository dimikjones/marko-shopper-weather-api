<?php
/**
 * Provide a public-facing view for the plugin
 *
 * This file is used for options form on the WooCommerce my-account/weather page.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Marko_WooCommerce_Api_Fetch
 * @subpackage Marko_WooCommerce_Api_Fetch/templates
 */

if ( ! defined( 'ABSPATH' ) ) {
	// Exit if accessed directly.
	exit;
}

$user_id = get_current_user_id();

if ( $user_id <= 0 ) {
	return;
}

// set query.
global $wp;

$url = home_url( add_query_arg( array(), $wp->request ) );
$url = add_query_arg( 'action', 'marko_shopper_weather_api_action', $url );
$url = wp_nonce_url( $url, 'marko_shopper_weather_api_nonce' );

$holder_classes   = array();
$holder_classes[] = 'marko-swa-admin-form-section woocommerce';

$user_weather_location           = get_user_meta( $user_id, 'marko_swa_user_weather_location', true );
$user_weather_temperature_scale  = get_user_meta( $user_id, 'marko_swa_user_weather_temperature_scale', true );
$user_weather_options_to_display = get_user_meta( $user_id, 'marko_swa_user_weather_options_to_display', true );
?>
<div class="<?php echo esc_attr( implode( '', $holder_classes ) ); ?>">
	<form class="marko-swa-admin-form" method="post" action="<?php echo esc_url( $url ); ?>">
		<div class="marko-swa-admin-options-block">
			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="user_weather_location"><?php esc_html_e( 'Weather Location', 'marko-shopper-weather-api' ); ?></label>
				<input type="text" autocomplete="given-name" class="woocommerce-Input woocommerce-Input--text input-text" name="user_weather_location" id="user_weather_location" value="<?php echo esc_attr( $user_weather_location ); ?>" />
				<span><em><?php esc_html_e( 'Enter town/city location for weather forecast (e.g. London, Paris, Belgrade etc.).', 'marko-shopper-weather-api' ); ?></em></span>
			</p>
			<fieldset>
				<legend><?php esc_html_e( 'Temperature Scale', 'marko-shopper-weather-api' ); ?></legend>

				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label>
						<input type="radio" <?php echo ! empty( $user_weather_temperature_scale ) && 'c' === $user_weather_temperature_scale ? esc_attr( 'checked' ) : ''; ?> name="user_weather_temperature_scale" value="<?php echo esc_attr( 'c' ); ?>">
						<?php esc_html_e( 'Celsius', 'marko-shopper-weather-api' ); ?>
					</label>
				</p>
				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label>
						<input type="radio" <?php echo ! empty( $user_weather_temperature_scale ) && 'f' === $user_weather_temperature_scale ? esc_attr( 'checked' ) : ''; ?> name="user_weather_temperature_scale" value="<?php echo esc_attr( 'f' ); ?>">
						<?php esc_html_e( 'Fahrenheit', 'marko-shopper-weather-api' ); ?>
					</label>
				</p>
			</fieldset>
			<fieldset>
				<legend><?php esc_html_e( 'Weather options to display', 'marko-shopper-weather-api' ); ?></legend>
				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label>
						<input type="checkbox" <?php echo is_array( $user_weather_options_to_display ) && in_array( 'country', $user_weather_options_to_display ) ? 'checked' : ''; ?> name="user_weather_options_to_display[]" value="<?php echo esc_attr( 'country' ); ?>">
						<?php esc_html_e( 'Country', 'marko-shopper-weather-api' ); ?>
					</label>
				</p>
				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label>
						<input type="checkbox" <?php echo is_array( $user_weather_options_to_display ) && in_array( 'feelslike', $user_weather_options_to_display ) ? 'checked' : ''; ?> name="user_weather_options_to_display[]" value="<?php echo esc_attr( 'feelslike' ); ?>">
						<?php esc_html_e( 'Feelslike', 'marko-shopper-weather-api' ); ?>
					</label>
				</p>
				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label><input type="checkbox" <?php echo is_array( $user_weather_options_to_display ) && in_array( 'pressure', $user_weather_options_to_display ) ? 'checked' : ''; ?> name="user_weather_options_to_display[]" value="<?php echo esc_attr( 'pressure' ); ?>">
						<?php esc_html_e( 'Pressure', 'marko-shopper-weather-api' ); ?>
					</label>
				</p>
				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label>
						<input type="checkbox" <?php echo is_array( $user_weather_options_to_display ) && in_array( 'humidity', $user_weather_options_to_display ) ? 'checked' : ''; ?> name="user_weather_options_to_display[]" value="<?php echo esc_attr( 'humidity' ); ?>">
						<?php esc_html_e( 'Humidity', 'marko-shopper-weather-api' ); ?>
					</label>
				</p>
			</fieldset>
		</div>
		<div class="marko-swa-admin-submit-block">
			<?php wp_nonce_field( 'marko_shopper_weather_api_action', 'marko_shopper_weather_api_nonce' ); ?>
			<button type="submit" class="marko-swa-admin-submit-button button">
				<?php esc_html_e( 'Save', 'marko-shopper-weather-api' ); ?>
			</button>
			<input type="hidden" name="action" value="marko_shopper_weather_api_action" />
		</div>
	</form>
</div>
