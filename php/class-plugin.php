<?php
/**
 * Primary plugin file.
 *
 * @package   User_Profile_Picture_Enhanced
 */

namespace User_Profile_Picture_Enhanced;

/**
 * Class Plugin
 */
class Plugin extends Plugin_Abstract {
	/**
	 * Execute this once plugins are loaded.
	 */
	public function plugin_loaded() {

		// Register post type actions and filters.
		$this->post_type = new Admin\Post_Type();
		$this->post_type->register_hooks();

		// Register option defaults.
		$this->admin_options = new Admin\Options();
		$this->admin_options->register_hooks();

		// Show migration interface.
		$this->migrate = new Admin\Migrate();
		$this->migrate->register_hooks();
	}
}
