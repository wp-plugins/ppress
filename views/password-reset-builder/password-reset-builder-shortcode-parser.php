<?php

class Password_Reset_Builder_Shortcode_Parser {

	/**
	 * define all registration builder sub shortcode.
	 */
	function __construct() {
		add_shortcode( 'user-login', array( $this, 'profilepress_user_login' ) );
		add_shortcode( 'reset-submit', array( $this, 'profilepress_submit_button' ) );
	}


	/**
	 * parse the [user-login] shortcode
	 *
	 * @param array $atts
	 *
	 * @return string
	 */
	function profilepress_user_login( $atts ) {
		$atts = shortcode_atts(
			array(
				'class' => '',
				'id' => '',
				'value' => '',
				'title' => 'Username or Email',
				'placeholder' => 'Username or Email'
			),
			$atts
		);

		$class       = 'class="' . $atts['class'] . '"';
		$placeholder = 'placeholder="' . $atts['placeholder'] . '"';
		$id          = 'id="' . $atts['id'] . '"';
		$value       = isset( $_POST['user_login'] ) ? 'value="' . esc_attr( $_POST['user_login'] ) . '"' : 'value=""';

		$title       = 'title="' . $atts['title'] . '"';

		$html = "<input name=\"user_login\" type='text' $title $value $class $id $placeholder required='required'/>";

		return $html;
	}


	/**
	 * @param $atts array shortcode param
	 *
	 * @return string HTML submit button
	 */
	function profilepress_submit_button( $atts ) {
		$atts = shortcode_atts(
			array(
				'class' => '',
				'id' => '',
				'value' => 'Reset',
				'title' => '',
				'name' => 'password_reset_submit'
			),
			$atts
		);

		$name    = 'name="' . $atts['name'] . '"';
		$class = 'class="' . $atts['class'] . '"';
		$value = 'value="' . $atts['value'] . '"';
		$id    = !empty( $atts['id'] ) ? 'id="' . $atts['id'] . '"' : '';

		$title       = 'title="' . $atts['title'] . '"';

		$html  = "<input type='submit' $name $title $value $id $class  />";

		return $html;
	}


	/** Singleton poop */
	static function get_instance() {
		static $instance = false;
		if ( ! $instance ) {
			$instance = new self;
		}
		return $instance;
	}
}

Password_Reset_Builder_Shortcode_Parser::get_instance();
