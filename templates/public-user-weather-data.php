<?php
/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to output user specific weather data information.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Marko_WooCommerce_Api_Fetch
 * @subpackage Marko_WooCommerce_Api_Fetch/templates
 *
 * @var array $response
 * @var string $temperature_scale
 * @var boolean $display_country
 * @var string $display_feelslike
 * @var string $display_pressure
 * @var string $display_humidity
 */

$weather_location = $response['location']['name'];
$weather_country  = $response['location']['country'];
$weather_icon     = $response['current']['condition']['icon'];
$weather_text     = $response['current']['condition']['text'];
$weather_temp     = $response['current']['temp_' . $temperature_scale]; // Celsius or Fahrenheit
$weather_feel     = $response['current']['feelslike_' . $temperature_scale]; // Celsius or Fahrenheit
$weather_pressure = $response['current']['pressure_mb'];
$weather_humidity = $response['current']['humidity'];
?>

<div class="marko-swa-public user-weather-preferences">
	<h3 class='marko-swa-heading'><?php esc_html_e( 'Weather conditions', 'marko-shopper-weather-api' ); ?></h3>
	<h4 class="marko-swa-city"><?php echo esc_html( $weather_location ); ?></h4>

	<?php if ( isset( $display_country ) && $display_country ) : ?>
		<p class="marko-swa-country"><?php echo esc_html( $weather_country ); ?></p>
	<?php endif; ?>

	<div class="marko-swa-conditions">
		<img src="<?php echo esc_url( $weather_icon ); ?>" alt="<?php echo esc_html( $weather_text ); ?>" title="<?php echo esc_html( $weather_text ); ?>">
		<span class="marko-swa-text"><?php echo esc_html( $weather_text ); ?></span>
		<span class="marko-swa-current-temp"><?php echo esc_html( $weather_temp ); ?><span class="marko-swa-scale-symbol"><?php echo esc_html( $temperature_scale ); ?></span></span>

		<?php if ( isset( $display_feelslike ) && $display_feelslike ) : ?>
			<p class="marko-swa-feelslike"><?php esc_html_e( 'Feels like: ', 'marko-shopper-weather-api' ); ?><?php echo esc_html( $weather_feel ); ?><span class="marko-swa-scale-symbol"><?php echo esc_html( $temperature_scale ); ?></span></p>
		<?php endif; ?>
		<?php if ( isset( $display_pressure ) && $display_pressure ) : ?>
			<p class="marko-swa-preasure"><?php esc_html_e( 'Pressure: ', 'marko-shopper-weather-api' ); ?><?php echo esc_html( $weather_pressure ); ?><span class="marko-swa-preasure-symbol"><?php esc_html_e( 'mb', 'marko-shopper-weather-api' ); ?></span></p>
		<?php endif; ?>
		<?php if ( isset( $display_humidity ) && $display_humidity ) : ?>
			<p class="marko-swa-humidity"><?php esc_html_e( 'Humidity: ', 'marko-shopper-weather-api' ); ?><?php echo esc_html( $weather_humidity ); ?><span class="marko-swa-humidity-symbol"><?php esc_html_e( '%', 'marko-shopper-weather-api' ); ?></span></p>
		<?php endif; ?>
	</div>
</div>
