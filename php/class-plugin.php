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
		$this->post_type_upp = new Admin\Post_Type_UPP();
		$this->post_type_upp->register_hooks();

		// Register license and settings.
		$this->license_admin = new Admin\EDD_License_Settings();
		$this->license_admin->register_hooks();

		// Register post type for author box.
		$this->post_type_author_box = new Admin\Post_Type_Author_Box();
		$this->post_type_author_box->register_hooks();

		// Add quick links to the user profile pages.
		$this->user_quicklinks = new Admin\User_Quicklinks();
		$this->user_quicklinks->register_hooks();

		// Add quick links to the user profile pages.
		$this->user_title = new Admin\User_Title();
		$this->user_title->register_hooks();

		// Register option defaults.
		$this->admin_options = new Admin\Options();
		$this->admin_options->register_hooks();

		// Show migration interface.
		$this->migrate = new Admin\Migrate();
		$this->migrate->register_hooks();

		// Add submenu to parent User Profile Picture options.
		$this->settings_menu = new Admin\Add_Settings_Page();
		$this->settings_menu->register_hooks();

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

		// Social Networks block.
		$this->social_networks_block = new Blocks\Social_Networks();
		$this->social_networks_block->register_hooks();

		// Recent Posts block.
		$this->recent_posts_block = new Blocks\Recent_Posts();
		$this->recent_posts_block->register_hooks();

		// Author Box block.
		$this->author_box_block = new Blocks\Author_Box();
		$this->author_box_block->register_hooks();

		// Load Rest API for Biography.
		$this->rest_get_user_biography = new Rest\Rest_Get_User_Biography();
		$this->rest_get_user_biography->register_hooks();

		// Load Rest API for Changing a Profile Picture.
		$this->rest_change_profile_picture = new Rest\Rest_Change_Profile_Image();
		$this->rest_change_profile_picture->register_hooks();

		// Load Rest API for Avatar.
		$this->rest_get_avatar = new Rest\Rest_Get_Avatar();
		$this->rest_get_avatar->register_hooks();

		// Load Rest API for Social Networks.
		$this->rest_get_social_networks = new Rest\Rest_Get_User_Social_Networks();
		$this->rest_get_social_networks->register_hooks();

		// Load Rest API for Recent Posts.
		$this->rest_get_recent_posts = new Rest\Rest_Get_Recent_Posts();
		$this->rest_get_recent_posts->register_hooks();
	}
}
