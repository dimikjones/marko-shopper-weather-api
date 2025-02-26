=== Marko Shopper Weather Api ===
Tags: woocommerce my-account, weather api
Requires at least: 5.6
Tested up to: 6.7
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Display weather information for current user from weather API according to user preferences in WooCommerce my-account/user-weather/ page.

== Description ==

This is example plugin showcasing API connection to WeatherAPI.com and some WooCommerce modifications to my-account page.
It is done PSR-4: Autoloader, contain transient integration for better performance, some basic admin options and my-account user specific options.

Plugin requires WooCommerce plugin, and it is styled to match Storefront theme.

Admin options for the plugin are API Key and Transient Expiration Time.
Although API Key isn't required for local installations, for all public websites you will have to register your own API Key on WeatherAPI.com
For better performance and to reduce API requests it is suggested to set Transient Expiration Time option to One Hour.
On my-account/user-weather logged in users can configure preferred Location and several checkboxes for the weather forecast for the API call,
and after saving, weather conditions will be displayed according to user settings.

== Installation ==

This section describes how to install the plugin and get it working.

From your WordPress dashboard

1. Go to your WordPress Dashboard -> Plugins -> Add New
2. marko-shopper-weather-api.zip
3. Activate it from your Plugins page.
4. Enjoy :)

== Changelog ==

= 1.0.0 =
* Initial version.
