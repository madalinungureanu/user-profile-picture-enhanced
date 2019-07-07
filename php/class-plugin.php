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
		$this->post_type = new Admin\Post_Type();
		$this->post_type->register_hooks();
	}
}
