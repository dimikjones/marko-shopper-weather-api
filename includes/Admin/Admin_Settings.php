<?php
/**
 * Handle admin settings.
 *
 * @class       Admin
 * @version     1.0.0
 * @package     Marko_Shopper_Weather_Api/Classes/
 */

namespace Marko_Shopper_Weather_Api\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Admin main class
 */
final class Admin_Settings {

	/**
	 * Hook in methods.
	 */
	public static function hooks() {
		// Hook to include additional modules before plugin loaded.
		do_action( 'marko_shopper_weather_api_action_before_admin_options_loaded' );

		// Register our settings_init to the admin_init action hook.
		add_action( 'admin_init', array( __CLASS__, 'settings_init' ) );

		// Register our options_page to the admin_menu action hook.
		add_action( 'admin_menu', array( __CLASS__, 'options_page' ) );

		// Hook to include additional modules when plugin loaded.
		do_action( 'marko_shopper_weather_api_action_after_admin_options_loaded' );
	}

	/**
	 * Custom option and settings.
	 */
	public static function settings_init() {
		// Register a new setting for "marko-shopper-weather-api" page.
		register_setting( 'marko-shopper-weather-api', 'marko_shopper_weather_api_options' );

		// Register a new section in the "marko-shopper-weather-api" page.
		add_settings_section(
			'marko_shopper_weather_api_section_first',
			esc_html__( 'Adjust options here.', 'marko-shopper-weather-api' ),
			array( __CLASS__, 'section_first' ),
			'marko-shopper-weather-api'
		);

		// Register a new option fields in the "marko_shopper_weather_api_section_first" section, inside the "marko-shopper-weather-api" page.
		add_settings_field(
			'marko_shopper_weather_api_field_api_key',
			// Use $args' label_for to populate the id inside the callback.
			esc_html__( 'API Key', 'marko-shopper-weather-api' ),
			array( __CLASS__, 'api_key_cb' ),
			'marko-shopper-weather-api',
			'marko_shopper_weather_api_section_first',
			array(
				'label_for' => 'marko-shopper-weather-api-field-api-key',
				'class'     => 'marko-shopper-weather-api-row',
			)
		);

		add_settings_field(
			'marko_shopper_weather_api_field_transient_time',
			// Use $args' label_for to populate the id inside the callback.
			esc_html__( 'Transient Expiration Time', 'marko-shopper-weather-api' ),
			array( __CLASS__, 'transient_time_cb' ),
			'marko-shopper-weather-api',
			'marko_shopper_weather_api_section_first',
			array(
				'label_for' => 'marko-shopper-weather-api-field-transient',
				'class'     => 'marko-shopper-weather-api-row',
				'marko_shopper_weather_api_custom_data' => 'custom',
			)
		);
	}

	/**
	 * First section callback method.
	 *
	 * @param array $args  The settings array, defining title, id, callback.
	 */
	public static function section_first( $args ) {
		?>
		<p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Options for the Shopper Weather Api Plugin.', 'marko-shopper-weather-api' ); ?></p>
		<?php
	}

	/**
	 * API Key field callback method.
	 *
	 * @param array $args
	 */
	public static function api_key_cb( $args ) {
		// Get the value of the setting we've registered with register_setting().
		$options = get_option( 'marko_shopper_weather_api_options' );
		?>
		<input type='text' name="marko_shopper_weather_api_options[<?php echo esc_attr( $args['label_for'] ); ?>]" value='<?php echo isset( $options[ $args['label_for'] ] ) ? esc_attr( $options[ $args['label_for'] ] ) : ( '' ); ?>'>
		<p class="description">
			<?php
			echo sprintf(
			// translators: 1: The WeatherAPI.com link.
				esc_html__( 'Although API Key isn\'t required for local installations, for all public websites you will have to register your own API Key on %s', 'marko-shopper-weather-api' ),
				'<a href="https://www.weatherapi.com/" target="_blank" title="Weather API">WeatherAPI.com</a>'
			);
			?>
		</p>
		<?php
	}

	/**
	 * Transient Expiration Time field callback method.
	 *
	 * @param array $args
	 */
	public static function transient_time_cb( $args ) {
		// Get the value of the setting we've registered with register_setting().
		$options = get_option( 'marko_shopper_weather_api_options' );

		$two_hours   = HOUR_IN_SECONDS * 2;
		$three_hours = HOUR_IN_SECONDS * 3;
		?>
		<select
			id="<?php echo esc_attr( $args['label_for'] ); ?>"
			data-custom="<?php echo esc_attr( $args['marko_shopper_weather_api_custom_data'] ); ?>"
			name="marko_shopper_weather_api_options[<?php echo esc_attr( $args['label_for'] ); ?>]">
			<option value="<?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], '', false ) ) : ( '' ); ?> ">
				<?php esc_html_e( 'None', 'marko-shopper-weather-api' ); ?>
			</option>
			<option value="<?php echo esc_attr( HOUR_IN_SECONDS ); ?>" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], esc_attr( HOUR_IN_SECONDS ), false ) ) : ( '' ); ?>>
				<?php esc_html_e( 'One Hour', 'marko-shopper-weather-api' ); ?>
			</option>
			<option value="<?php echo esc_attr( $two_hours ); ?>" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], esc_attr( $two_hours ), false ) ) : ( '' ); ?>>
				<?php esc_html_e( 'Two Hours', 'marko-shopper-weather-api' ); ?>
			</option>
			<option value="<?php echo esc_attr( $three_hours ); ?>" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], esc_attr( $three_hours ), false ) ) : ( '' ); ?>>
				<?php esc_html_e( 'Three Hours', 'marko-shopper-weather-api' ); ?>
			</option>
			<option value="<?php echo esc_attr( DAY_IN_SECONDS ); ?>" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], esc_attr( DAY_IN_SECONDS ), false ) ) : ( '' ); ?>>
				<?php esc_html_e( 'One Day', 'marko-shopper-weather-api' ); ?>
			</option>
		</select>
		<p class="description">
			<?php esc_html_e( 'For better performance and to reduce API requests it is suggested to set transient expiration time to One Hour.', 'marko-shopper-weather-api' ); ?>
			<br><strong><?php esc_html_e( 'By choosing None transient will be disabled.', 'marko-shopper-weather-api' ); ?></strong>
		</p>
		<?php
	}

	/**
	 * Top level menu callback method.
	 */
	public static function options_page_html() {
		// Check user capabilities.
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		// WPCS: input var ok.
		if ( isset( $_REQUEST['settings-updated'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
			// Add settings saved message with the class of "updated".
			add_settings_error( 'marko_shopper_weather_api_messages', 'marko_shopper_weather_api_message', esc_html__( 'Settings Saved', 'marko-shopper-weather-api' ), 'updated' );
		}

		// Show error/update messages.
		settings_errors( 'marko_shopper_weather_api_messages' );
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Shopper Weather Api Settings Page', 'marko-shopper-weather-api' ); ?></h1>
			<form class="marko-shopper-weather-api-admin-form" action="options.php" method="post">
				<?php
				// Output security fields for the registered setting "marko-shopper-weather-api".
				settings_fields( 'marko-shopper-weather-api' );
				// Output setting sections and their fields.
				// (sections are registered for "marko-shopper-weather-api", each field is registered to a specific section).
				do_settings_sections( 'marko-shopper-weather-api' );
				// output save settings button.
				submit_button( 'Save Settings' );
				?>
			</form>
		</div>
		<?php
	}

	/**
	 * Add the top level menu page.
	 */
	public static function options_page() {
		add_menu_page(
			'marko-shopper-weather-api',
			'Shopper Weather API Options',
			'manage_options',
			'marko-shopper-weather-api',
			array( __CLASS__, 'options_page_html' )
		);
	}
}