<?php
/**
 * Add options to UPP and its defaults
 *
 * @package   User_Profile_Picture_Enhanced
 */

namespace User_Profile_Picture_Enhanced\Admin;

/**
 * Class Admin
 */
class Options {

	/**
	 * Initialize the Admin component.
	 */
	public function init() {

	}

	/**
	 * Register any hooks that this component needs.
	 */
	public function register_hooks() {
		add_filter( 'mpp_options_defaults', array( $this, 'option_defaults' ), 10, 1 );
	}

	/**
	 * Provide default options this plugin needs for User Profile Picture.
	 *
	 * @param array $defaults The default options for User Profile Picture.
	 *
	 * @return array New Defaults.
	 */
	public function option_defaults( $defaults ) {
		$defaults['migrated'] = false;
		return $defaults;
	}
}
