<?php
/** List of ProfilePress global helper functions */

/** Plugin DB settings data */
function pp_db_data() {
	return get_option( 'pp_settings_data' );
}


/** Addons options data */
function pp_addon_options() {
	return get_option( 'pp_addons_options' );
}


/**
 * Return the url to redirect to after login authentication
 *
 * @return bool|string
 */
function pp_login_redirect() {
	$data           = pp_db_data();
	$login_redirect = $data['set_login_redirect'];

	if ( $login_redirect == 'dashboard' ) {
		$redirect = esc_url( network_site_url( '/wp-admin' ) );
	} elseif ( ! isset( $login_redirect ) || empty( $login_redirect ) ) {
		$redirect = network_site_url( '/wp-admin' );
	} else {
		$redirect = get_permalink( $login_redirect );
	}

	return apply_filters( 'pp_login_redirect', $redirect );
}

/**
 * Return the url to redirect to after login authentication
 *
 * @return bool|string
 */
function pp_profile_url() {
	$data   = pp_db_data();
	$db_url = $data['set_user_profile_shortcode'];

	if ( ! empty( $db_url ) ) {
		return get_permalink( $db_url );
	} else {
		return admin_url() . 'profile.php';
	}
}


/** @return string blog URL without scheme */
function pp_site_url_without_scheme() {
	$parsed_url = parse_url( home_url() );

	// get url scheme length eg http or https
	$scheme_length = strlen( $parsed_url['scheme'] ) + 3; // 3 was added 'cos of the "://" part

	$url_without_scheme = substr( home_url(), $scheme_length );

	return $url_without_scheme;
}

/**
 * Blog name or domain name if name doesn't exist
 *
 * @return string
 */
function pp_site_title() {
	$blog_name = is_multisite() ? get_blog_option( null, 'blogname' ) : get_option( 'blogname' );

	return ! empty( $blog_name ) ? $blog_name : str_replace( array( 'http://', 'https://' ), '', site_url() );
}


/**
 * Return admin email
 *
 * @return string
 */
function pp_admin_email() {
	return is_multisite() ? get_blog_option( null, 'admin_email' ) : get_option( 'admin_email' );
}

/** Save all login generated WP_Error be it from normal login form or from social login shebang */
global $pp_login_wp_errors;
/**
 * Error handler for social login.
 *
 * @param string $error_key WP_Error key
 * @param string $error_value WP_Error value
 */
function pp_login_wp_errors( $error_key, $error_value ) {
	global $pp_login_wp_errors;
	$pp_login_wp_errors = new WP_Error();
	$pp_login_wp_errors->add( $error_key, $error_value );
}


/**
 * Checks whether the given user ID exists.
 *
 * @param string $user_id ID of user
 *
 * @return null|int The user's ID on success, and null on failure.
 */
function pp_user_id_exist( $user_id ) {
	if ( $user = get_user_by( 'id', $user_id ) ) {
		return $user->ID;
	} else {
		return null;
	}
}

/**
 * Is plugin license valid?
 *
 * @return bool
 */
function pp_is_license_valid() {
	$license = get_option( 'pp_license_status' );
	if ( $license == 'valid' ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Is plugin license invalid?
 * @return bool
 */
function pp_is_license_invalid() {
	$license = get_option( 'pp_license_status' );
	if ( $license == 'invalid' ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Is license empty?
 *
 * @return bool
 */
function pp_is_license_empty() {
	$license = get_option( 'pp_license_key' );
	if ( false == $license || empty( $license ) ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Was license once active?
 */
function pp_license_once_valid() {
	$license = get_option( 'pp_license_once_active' );
	if ( $license == 'true' ) {
		return true;
	} else {
		return false;
	}
}


/**
 * Filter form field attributes for unofficial attributes.
 *
 * @param array $atts supplied shortcode attributes
 *
 * @return string
 */
function pp_other_field_atts( $atts ) {
	$official_atts = array( 'name', 'class', 'id', 'value', 'title', 'required', 'placeholder' );

	$other_atts = array();

	foreach ( $atts as $key => $value ) {
		if ( ! in_array( $key, $official_atts ) ) {
			$other_atts[ $key ] = $value;
		}
	}


	$other_atts_html = '';
	foreach ( $other_atts as $key => $value ) {
		$other_atts_html .= "$key=\"$value\" ";
	}

	return $other_atts_html;
}