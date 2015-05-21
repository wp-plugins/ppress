<?php

/**
 * Class Custom_Profile_Fields_Sql - sql query to get custom fields
 */
class PROFILEPRESS_sql {

	/** Retrieve login builder record from DB */
	static function sql_wp_list_table_login_builder() {
		global $wpdb;
		$current_blog_id = get_current_blog_id();

		if ( is_multisite() ) {
			$sql = "SELECT id, title, structure, css, date FROM {$wpdb->base_prefix}pp_login_builder WHERE blog_id = 0 OR blog_id = $current_blog_id";
		}
		else {
			$sql = "SELECT id, title, structure, css, date FROM {$wpdb->base_prefix}pp_login_builder";
		}
		$result = $wpdb->get_results(
			$sql,
			'ARRAY_A'
		);

		return $result;
	}


	/**
	 * Delete a login builder reference with ID
	 *
	 * @param $id int login builder ID
	 *
	 * @return mixed
	 */
	static function sql_delete_login_builder( $id ) {
		global $wpdb;

		$delete_sql = $wpdb->delete(
			"{$wpdb->base_prefix}pp_login_builder",
			array(
				'id' => $id
			),
			array( '%d' )
		);

		return $delete_sql;
	}

	/**
	 * Retrieve list of login builder for editing
	 *
	 * @param int $id
	 *
	 * @return array
	 */
	static function sql_edit_login_builder( $id ) {
		global $wpdb;

		// get the profile fields row for the id and save as array
		$sql = $wpdb->get_row( "SELECT * FROM {$wpdb->base_prefix}pp_login_builder WHERE id = $id", 'ARRAY_A' );

		return $sql;
	}


	/**
	 * Update login builder
	 *
	 * @param $id
	 * @param $title
	 * @param $structure
	 * @param $css
	 * @param $date
	 */
	static function sql_update_login_builder( $id, $title, $structure, $css, $date ) {
		global $wpdb;

		if ( is_multisite() ) {
			$wpdb->update(
				"{$wpdb->base_prefix}pp_login_builder",
				array(
					'title'     => $title,
					'structure' => $structure,
					'css'       => $css,
					'date'      => $date,
					'blog_id'   => get_current_blog_id()
				),
				array( 'id' => $id ),
				array(
					'%s',
					'%s',
					'%s',
					'%s',
					'%d'
				)
			);
		}
		else {
			$wpdb->update(
				"{$wpdb->base_prefix}pp_login_builder",
				array(
					'title'     => $title,
					'structure' => $structure,
					'css'       => $css,
					'date'      => $date
				),
				array( 'id' => $id ),
				array(
					'%s',
					'%s',
					'%s',
					'%s'
				)
			);
		}

	}

	/**
	 * Insert data to login builder
	 *
	 * @param $title
	 * @param $structure
	 * @param $css
	 * @param $date
	 *
	 * @return bool|int
	 */
	static public function sql_insert_login_builder( $title, $structure, $css, $date ) {
		global $wpdb;

		if ( is_multisite() ) {
			$insert = $wpdb->insert(
				"{$wpdb->base_prefix}pp_login_builder",
				array(
					'title'     => $title,
					'structure' => $structure,
					'css'       => $css,
					'date'      => $date,
					'blog_id'   => get_current_blog_id()
				),
				array(
					'%s',
					'%s',
					'%s',
					'%s',
					'%d'
				)
			);
		}
		else {

			$insert = $wpdb->insert(
				"{$wpdb->base_prefix}pp_login_builder",
				array(
					'title'     => $title,
					'structure' => $structure,
					'css'       => $css,
					'date'      => $date
				),
				array(
					'%s',
					'%s',
					'%s',
					'%s',
				)
			);
		}

		// if insert is false (fail to insert to DB), return ID number
		return ! $insert ? false : $wpdb->insert_id;

	}

	/**
	 * Returns the login CSS of a builder
	 *
	 * @param $id int login builder ID
	 *
	 * @return string login builder css
	 */
	static public function get_login_builder_css( $id ) {
		global $wpdb;
		$current_blog = get_current_blog_id();

		if ( is_multisite() ) {
			$sql = "SELECT css FROM {$wpdb->base_prefix}pp_login_builder WHERE id = $id AND (blog_id = 0 OR blog_id = $current_blog)";
		}
		else {
			$sql = "SELECT css FROM {$wpdb->base_prefix}pp_login_builder WHERE id = $id";
		}

		return $wpdb->get_var( $sql );
	}


	/**
	 * Return the login structure of a builder
	 *
	 * @param $id int builder ID
	 *
	 * @return string login structure
	 */
	static public function get_login_structure( $id ) {
		global $wpdb;

		$sql = $wpdb->get_var( "SELECT structure FROM {$wpdb->base_prefix}pp_login_builder WHERE id = $id" );

		return $sql;

	}

	/**
	 * Retrieve the registration DB data
	 *
	 * @return mixed
	 */
	static function sql_wp_list_table_registration_builder() {
		global $wpdb;

		if ( is_multisite() ) {
			$current_blog_id = get_current_blog_id();
			$sql             = "SELECT id, title, structure, css, date FROM {$wpdb->base_prefix}pp_registration_builder WHERE blog_id = 0 OR blog_id = $current_blog_id";
		}
		else {
			$sql = "SELECT id, title, structure, css, date FROM {$wpdb->base_prefix}pp_registration_builder";
		}

		return $wpdb->get_results( $sql, 'ARRAY_A' );
	}

	/**
	 * Delete an entry from registration builder
	 *
	 * @param $id
	 *
	 * @return mixed
	 */
	static function sql_delete_registration_builder( $id ) {
		global $wpdb;

		$delete_sql = $wpdb->delete(
			"{$wpdb->base_prefix}pp_registration_builder",
			array(
				'id' => $id
			),
			array( '%d' )
		);

		return $delete_sql;
	}

	/**
	 * retrieve the profile field row for an id for editing
	 *
	 * @param int $id
	 *
	 * @return array
	 */
	static function sql_edit_registration_builder( $id ) {
		global $wpdb;

		// get the profile fields row for the id and save as array
		$sql = $wpdb->get_row( "SELECT * FROM {$wpdb->base_prefix}pp_registration_builder WHERE id = $id", 'ARRAY_A' );

		return $sql;
	}


	/**
	 * Update login builder
	 *
	 * @param $id
	 * @param $title
	 * @param $structure
	 * @param $css
	 * @param $date
	 */
	static function sql_update_registration_builder( $id, $title, $structure, $css, $success_registration, $date ) {
		global $wpdb;

		if ( is_multisite() ) {


			$wpdb->update(
				"{$wpdb->base_prefix}pp_registration_builder",
				array(
					'title'                => $title,
					'structure'            => $structure,
					'css'                  => $css,
					'success_registration' => $success_registration,
					'date'                 => $date,
					'blog_id'              => get_current_blog_id()
				),
				array( 'id' => $id ),
				array(
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%d',
				)
			);
		}
		else {
			$wpdb->update(
				"{$wpdb->base_prefix}pp_registration_builder",
				array(
					'title'                => $title,
					'structure'            => $structure,
					'css'                  => $css,
					'success_registration' => $success_registration,
					'date'                 => $date
				),
				array( 'id' => $id ),
				array(
					'%s',
					'%s',
					'%s',
					'%s',
				)
			);
		}

	}


	/**
	 * Insert new registration builder to DB
	 *
	 * @param $title
	 * @param $structure
	 * @param $css
	 * @param $success_registration
	 * @param $date
	 */
	static function sql_insert_registration_builder( $title, $structure, $css, $success_registration, $date ) {
		global $wpdb;

		if ( is_multisite() ) {

			$wpdb->insert(
				"{$wpdb->base_prefix}pp_registration_builder",
				array(
					'title'                => $title,
					'structure'            => $structure,
					'css'                  => $css,
					'success_registration' => $success_registration,
					'date'                 => $date,
					'blog_id'              => get_current_blog_id()
				),
				array(
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%d',
				)
			);
		}
		else {

			$wpdb->insert(
				"{$wpdb->base_prefix}pp_registration_builder",
				array(
					'title'                => $title,
					'structure'            => $structure,
					'css'                  => $css,
					'success_registration' => $success_registration,
					'date'                 => $date
				),
				array(
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
				)
			);
		}

		// return inserted form ID number
		return $wpdb->insert_id;
	}


	/**
	 * Get successful message on registration completion
	 *
	 * @param $id
	 *
	 * @return mixed
	 */
	static function get_db_success_registration( $id ) {
		global $wpdb;
		$sql = $wpdb->get_var( "SELECT success_registration FROM {$wpdb->base_prefix}pp_registration_builder WHERE id = $id" );

		return $sql;
	}


	/**
	 * Retrieve the password reset DB builder data
	 *
	 * @return mixed
	 */
	static function sql_wp_list_table_password_reset_builder() {
		global $wpdb;

		if ( is_multisite() ) {
			$current_blog = get_current_blog_id();
			$sql          = "SELECT id, title, structure, css, date FROM {$wpdb->base_prefix}pp_password_reset_builder WHERE blog_id = 0 OR blog_id = $current_blog";
		}
		else {
			$sql = "SELECT id, title, structure, css, date FROM {$wpdb->base_prefix}pp_password_reset_builder";
		}

		return $wpdb->get_results( $sql, 'ARRAY_A' );
	}

	/**
	 * Delete an entry from password-reset builder
	 *
	 * @param $id
	 *
	 * @return mixed
	 */
	static function sql_delete_password_reset_builder( $id ) {
		global $wpdb;

		$delete_sql = $wpdb->delete(
			"{$wpdb->base_prefix}pp_password_reset_builder",
			array(
				'id' => $id
			),
			array( '%d' )
		);

		return $delete_sql;
	}


	/**
	 * Retrieve the password reset field row for an id for editing
	 *
	 * @param int $id
	 *
	 * @return array
	 */
	static function sql_edit_password_reset_builder( $id ) {
		global $wpdb;

		// get the profile fields row for the id and save as array
		$sql = $wpdb->get_row( "SELECT * FROM {$wpdb->base_prefix}pp_password_reset_builder WHERE id = $id", 'ARRAY_A' );

		return $sql;
	}


	/**
	 * Insert new registration builder to DB
	 *
	 * @param $title
	 * @param $structure
	 * @param $css
	 * @param $success_registration
	 * @param $date
	 */
	static function sql_insert_password_reset_builder( $title, $structure, $css, $success_password_reset, $date ) {
		global $wpdb;

		if ( is_multisite() ) {

			$insert = $wpdb->insert(
				"{$wpdb->base_prefix}pp_password_reset_builder",
				array(
					'title'                  => $title,
					'structure'              => $structure,
					'css'                    => $css,
					'success_password_reset' => $success_password_reset,
					'date'                   => $date,
					'blog_id'                => get_current_blog_id()
				),
				array(
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%d',
				)
			);
		}
		else {
			$insert = $wpdb->insert(
				"{$wpdb->base_prefix}pp_password_reset_builder",
				array(
					'title'                  => $title,
					'structure'              => $structure,
					'css'                    => $css,
					'success_password_reset' => $success_password_reset,
					'date'                   => $date
				),
				array(
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
				)
			);
		}

		// return ID number
		return $wpdb->insert_id;
	}


	/**
	 * Update password reset builder
	 *
	 * @param $id
	 * @param $title
	 * @param $structure
	 * @param $css
	 * @param $success_password_reset
	 * @param $date
	 */
	static function sql_update_password_reset_builder( $id, $title, $structure, $css, $success_password_reset, $date ) {
		global $wpdb;

		if ( is_multisite() ) {


			$wpdb->update(
				"{$wpdb->base_prefix}pp_password_reset_builder",
				array(
					'title'                  => $title,
					'structure'              => $structure,
					'css'                    => $css,
					'success_password_reset' => $success_password_reset,
					'date'                   => $date,
					'blog_id'                => get_current_blog_id()
				),
				array( 'id' => $id ),
				array(
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%d',
				)
			);
		}
		else {
			$wpdb->update(
				"{$wpdb->base_prefix}pp_password_reset_builder",
				array(
					'title'                  => $title,
					'structure'              => $structure,
					'css'                    => $css,
					'success_password_reset' => $success_password_reset,
					'date'                   => $date
				),
				array( 'id' => $id ),
				array(
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
				)
			);
		}

	}

	/**
	 * Get successful message on password reset
	 *
	 * @param $id
	 *
	 * @return mixed
	 */
	static function get_db_success_password_reset( $id ) {
		global $wpdb;

		$sql = $wpdb->get_var( "SELECT success_password_reset FROM {$wpdb->base_prefix}pp_password_reset_builder WHERE id = $id" );

		return $sql;
	}


	/**
	 * Get the title of a builder
	 *
	 * @param $builder_type string builder type
	 * @param $id int  builder_type row ID
	 *
	 * @return string title of builder
	 */
	static public function get_a_builder_title( $builder_type, $id ) {
		global $wpdb;

		if ( $builder_type == 'login' ) {
			$title = $wpdb->get_var( "SELECT title FROM {$wpdb->base_prefix}pp_login_builder WHERE id = $id" );
		}
		elseif ( $builder_type == 'registration' ) {
			$title = $wpdb->get_var( "SELECT title FROM {$wpdb->base_prefix}pp_registration_builder WHERE id = $id" );
		}
		elseif ( $builder_type == 'password_reset' ) {
			$title = $wpdb->get_var( "SELECT title FROM {$wpdb->base_prefix}pp_password_reset_builder WHERE id = $id" );
		}

		return $title;
	}


	/**
	 * Get the structure of a builder
	 *
	 * @param $builder_type string builder type
	 * @param $id int row ID of a builder_type
	 *
	 * @return string
	 */
	static public function get_a_builder_structure( $builder_type, $id ) {

		global $wpdb;
		$current_blog_id = get_current_blog_id();
		if ( $builder_type == 'login' ) {
			if ( is_multisite() ) {
				$sql = "SELECT structure FROM {$wpdb->base_prefix}pp_login_builder WHERE id = $id AND (blog_id = 0 OR blog_id = $current_blog_id)";
			}
			else {
				$sql = "SELECT structure FROM {$wpdb->base_prefix}pp_login_builder WHERE id = $id";
			}
		}

		elseif ( $builder_type == 'registration' ) {
			if ( is_multisite() ) {
				$sql = "SELECT structure FROM {$wpdb->base_prefix}pp_registration_builder WHERE id = $id AND (blog_id = 0 OR blog_id = $current_blog_id)";
			}
			else {
				$sql = "SELECT structure FROM {$wpdb->base_prefix}pp_registration_builder WHERE id = $id";
			}
		}

		elseif ( $builder_type == 'password_reset' ) {
			if ( is_multisite() ) {
				$sql = "SELECT structure FROM {$wpdb->base_prefix}pp_password_reset_builder WHERE id = $id AND (blog_id = 0 OR blog_id = $current_blog_id)";
			}
			else {
				$sql = "SELECT structure FROM {$wpdb->base_prefix}pp_password_reset_builder WHERE id = $id";
			}
		}

		return $wpdb->get_var( $sql );
	}


	/**
	 * Return the CSS stylesheet of a builder
	 *
	 * @param $builder_type string builder type
	 * @param $id int row ID of a builder_type
	 *
	 * @return mixed
	 */
	static public function get_a_builder_css( $builder_type, $id ) {

		global $wpdb;
		$current_blog_id = get_current_blog_id();

		if ( $builder_type == 'login' ) {
			if ( is_multisite() ) {
				$sql = "SELECT css FROM {$wpdb->base_prefix}pp_login_builder WHERE id = $id AND (blog_id = 0 OR blog_id = $current_blog_id)";
			}
			else {
				$sql = "SELECT css FROM {$wpdb->base_prefix}pp_login_builder WHERE id = $id";
			}
		}

		elseif ( $builder_type == 'registration' ) {
			if ( is_multisite() ) {
				$sql = "SELECT css FROM {$wpdb->base_prefix}pp_registration_builder WHERE id = $id AND (blog_id = 0 OR blog_id = $current_blog_id)";
			}
			else {
				$sql = "SELECT css FROM {$wpdb->base_prefix}pp_registration_builder WHERE id = $id";
			}
		}

		elseif ( $builder_type == 'password_reset' ) {
			if ( is_multisite() ) {
				$sql = "SELECT css FROM {$wpdb->base_prefix}pp_password_reset_builder WHERE id = $id AND (blog_id = 0 OR blog_id = $current_blog_id)";
			}
			else {
				$sql = "SELECT css FROM {$wpdb->base_prefix}pp_password_reset_builder WHERE id = $id";
			}
		}

		return $wpdb->get_var( $sql );
	}


	/**
	 * Return the message/test displayed when a builder action is done.
	 *
	 *  eg, when a user successfully register an account
	 * when a user successfully edited his profile.
	 *
	 * @param $builder_type
	 * @param $id
	 *
	 * @return mixed
	 */
	static public function get_a_builder_message_after_action( $builder_type, $id ) {

		global $wpdb;

		if ( $builder_type == 'registration' ) {
			$sql = "SELECT success_registration FROM {$wpdb->base_prefix}pp_registration_builder WHERE id = $id";
		}

		elseif ( $builder_type == 'password_reset' ) {
			$sql = "SELECT success_password_reset FROM {$wpdb->base_prefix}pp_password_reset_builder WHERE id = $id";
		}

		return $wpdb->get_var( $sql );
	}


	/**
	 * Return an array of a list of IDs of a builder.
	 *
	 * @param $builder_type string the builder type
	 *
	 * @return array list of a builder id
	 */
	static public function get_a_builder_ids( $builder_type ) {
		global $wpdb;
		$current_blog_id = get_current_blog_id();
		if ( $builder_type == 'login' ) {
			if ( is_multisite() ) {
				$sql = "SELECT id FROM {$wpdb->base_prefix}pp_login_builder WHERE blog_id = 0 OR blog_id = $current_blog_id";
			}
			else {
				$sql = "SELECT id FROM {$wpdb->base_prefix}pp_login_builder";
			}
		}
		elseif ( $builder_type == 'registration' ) {
			if ( is_multisite() ) {
				$sql = "SELECT id FROM {$wpdb->base_prefix}pp_registration_builder WHERE blog_id = 0 OR blog_id = $current_blog_id";
			}
			else {
				$sql = "SELECT id FROM {$wpdb->base_prefix}pp_registration_builder";
			}
		}
		elseif ( $builder_type == 'password_reset' ) {
			if ( is_multisite() ) {
				$sql = "SELECT id FROM {$wpdb->base_prefix}pp_password_reset_builder WHERE blog_id = 0 OR blog_id = $current_blog_id";
			}
			else {
				$sql = "SELECT id FROM {$wpdb->base_prefix}pp_password_reset_builder";
			}
		}

		return $wpdb->get_col( $sql );
	}

}
