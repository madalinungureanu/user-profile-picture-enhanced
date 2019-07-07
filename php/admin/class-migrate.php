<?php
/**
 * Show a notice to migrate.
 *
 * @package   User_Profile_Picture_Enhanced
 */

namespace User_Profile_Picture_Enhanced\Admin;

/**
 * Class Admin
 */
class Migrate {

	/**
	 * Initialize the Admin component.
	 */
	public function init() {

	}

	/**
	 * Register any hooks that this component needs.
	 */
	public function register_hooks() {
		global $mt_pp;
		$options = $mt_pp->get_options();
		if ( false === $options['migrated'] ) {
			add_action( 'admin_notices', array( $this, 'show_migration_notice' ) );
		}
	}

	/**
	 * Adds a migration notice for new users.
	 */
	public function show_migration_notice() {
		printf(
			'<div class="error"><p>%s <a class="button button-secondary" href="#">%s</a></p></div>',
			esc_html__( 'User Profile Picture data needs to be migrated for User Profile Enhanced to function properly.', 'user-profile-picture-enhanced' ),
			esc_html__( 'Migrate Now.', 'user-profile-picture-enhanced' )
		);
	}
}
