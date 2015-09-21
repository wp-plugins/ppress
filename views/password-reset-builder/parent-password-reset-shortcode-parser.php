<?php
require_once CLASSES . '/class.password-reset.php';

require_once VIEWS . '/password-reset-builder/password-reset-builder-settings-page.php';

require_once VIEWS . '/password-reset-builder/password-reset-builder-shortcode-parser.php';


class PP_Parent_Password_Reset_Shortcode_Parser extends ProfilePress_Password_Reset {

	/** Constructor */
	public function __construct() {

		add_shortcode( 'profilepress-password-reset', array( $this, 'profilepress_password_reset_parser' ) );
	}

	/**
	 * Parse the password reset shortcode
	 *
	 * @param $atts
	 *
	 * @return string
	 */
	function profilepress_password_reset_parser( $atts ) {

		// get password reset builder id
		$id = absint( $atts['id'] );

		$password_reset_status = ProfilePress_Password_Reset::validate_password_reset_form($id);

		$attribution = '<!-- Custom "Password reset page" built with the ProfilePress WordPress plugin - http://profilepress.net -->' . "\r\n";

		$password_reset_css = self::get_password_reset_css( $id );

		// call the password reset structure/design
		return $attribution . $password_reset_css . $password_reset_status . $this->get_password_reset_structure( $id );

	}


	/**
	 * Get the password reset structure from the database
	 *
	 * @param int $id
	 *
	 * @return string
	 */
	function get_password_reset_structure( $id ) {

		$password_reset_structure = PROFILEPRESS_sql::get_a_builder_structure( 'password_reset', $id );

		$form_tag = '<form method="post" action="' . esc_url( $_SERVER['REQUEST_URI'] ) . '">';

		return $form_tag . do_shortcode( $password_reset_structure ) . '</form>';
	}


	/**
	 * Get the CSS stylesheet for the ID password reset
	 *
	 * @return mixed
	 */

	public static function get_password_reset_css( $password_reset_builder_id ) {

		// if no id is set return
		if ( !isset( $password_reset_builder_id ) ) {
			return;
		}

		$password_reset_css = PROFILEPRESS_sql::get_a_builder_css( 'password_reset', $password_reset_builder_id );

		return "<style type=\"text/css\">\r\n $password_reset_css \r\n</style>";
	}


	/** Singleton poop */
	static function get_instance() {
		static $instance = false;

		if ( !$instance ) {
			$instance = new self;
		}

		return $instance;
	}

}


PP_Parent_Password_Reset_Shortcode_Parser::get_instance();