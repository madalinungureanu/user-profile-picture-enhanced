<?php
/**
 * Add Settings page to Plugin and to sub-menu
 *
 * @package   User_Profile_Picture_Enhanced
 */

namespace User_Profile_Picture_Enhanced\Admin;

/**
 * Class Admin
 */
class Add_Settings_Page {

	/**
	 * Initialize the Admin component.
	 */
	public function init() {

	}

	/**
	 * Register any hooks that this component needs.
	 */
	public function register_hooks() {
		add_action( 'admin_menu', array( $this, 'register_sub_menu' ), 1 );
	}

	/**
	 * Adds a settings sub-menu to the parent menu
	 */
	public function register_sub_menu() {
		global $mt_pp;
		add_submenu_page(
			'mpp',
			__( 'Settings', 'user-profile-picture-enhanced' ),
			__( 'Settings', 'user-profile-picture-enhanced' ),
			'manage_options',
			'mpp',
			array( $mt_pp, 'admin_page' )
		);
	}
}
