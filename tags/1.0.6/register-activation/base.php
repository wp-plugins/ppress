<?php
require_once 'db-structure/base.php';
// require the login themes base
require_once 'logins/base.php';
// require the registration theme base
require_once 'registrations/base.php';
require_once 'password-reset/base.php';
require_once 'general-settings/base.php';

global $wpdb;

define( 'LOGIN_TABLE', $wpdb->base_prefix . 'pp_login_builder' );
define( 'PASSWORD_RESET_TABLE', $wpdb->base_prefix . 'pp_password_reset_builder' );
define( 'REGISTRATION_TABLE', $wpdb->base_prefix . 'pp_registration_builder' );


/**
 * Class ProfilePress_Plugin_Options_On_Activate
 */
class ProfilePress_Plugin_On_Activate {

	/** Class instance */
	public static function instance( $network_wide ) {
		if ( $network_wide ) {
			global $wpdb;

			if ( is_plugin_active_for_network( PROFILEPRESS_SYSTEM_FILE_PATH ) ) {
				self::plugin_settings_activation();
			}
			else {
				$blog_ids = $wpdb->get_col( "SELECT blog_id FROM {$wpdb->blogs}" );
				foreach ( $blog_ids as $blog_id ) {
					switch_to_blog( $blog_id );
					self::plugin_settings_activation();
					restore_current_blog();
				}
			}

			self::db_activation();
		}
		else {
			self::plugin_settings_activation();
			self::db_activation();
		}

		flush_rewrite_rules();

	}

	/** Store the whole database activation code in this function for easy reuse by the @self::instance method */
	public static function db_activation() {

		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		$is_plugin_activated = is_multisite() ? get_blog_option( '', 'pp_plugin_lite_activated' ) : get_option( 'pp_plugin_lite_activated' );

		if ( ! $is_plugin_activated ) {
			db_structure\PP_Db_Schema::instance();

			logins\Logins_Base::instance();
			registrations\Registrations_Base::instance();
			password_reset\Password_Reset_Base::instance();


			/**
			 * Save the plugin state i.e if its been install and activated at first.
			 * It is done to avoid duplicate data insertion on plugin activation
			 * @see http://wordpress.stackexchange.com/q/168448/59917
			 */

			if ( is_multisite() ) {
				add_blog_option( null, 'pp_plugin_lite_activated', 'true' );
			}
			else {
				add_option( 'pp_plugin_lite_activated', 'true' );
			}
		}
	}

	/** Activation for non-database settings */
	public static function plugin_settings_activation() {
		general_settings\General_Settings::instance();
	}

}