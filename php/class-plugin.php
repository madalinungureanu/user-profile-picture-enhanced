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

		// Show social networks screen.
		$this->social_networks = new Admin\Social_Networks();
		$this->social_networks->register_hooks();

		// Enqueue block assets.
		$this->block_enqueue = new Blocks\Enqueue();
		$this->block_enqueue->register_hooks();

		// Avatar block.
		$this->avatar_block = new Blocks\Avatar();
		$this->avatar_block->register_hooks();

		// Biography block.
		$this->biography_block = new Blocks\Biography();
		$this->biography_block->register_hooks();

		// Load Rest API for Biography.
		$this->rest_get_user_biography = new Rest\Rest_Get_User_Biography();
		$this->rest_get_user_biography->register_hooks();

		// Load Rest API for Avatar.
		$this->rest_get_avatar = new Rest\Rest_Get_Avatar();
		$this->rest_get_avatar->register_hooks();
	}
}
