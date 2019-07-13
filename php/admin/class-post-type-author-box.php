<?php
/**
 * Post Type options for User Profile Picture
 *
 * @package   User_Profile_Picture_Enhanced
 */

namespace User_Profile_Picture_Enhanced\Admin;

/**
 * Class Admin
 */
class Post_Type_Author_Box {

	/**
	 * Initialize the Admin component.
	 */
	public function init() {
		$this->register_post_type();
	}

	/**
	 * Register any hooks that this component needs.
	 */
	public function register_hooks() {
		global $mt_pp;
		$options = $mt_pp->get_options();
		if ( 'off' === $options['author_box_type'] ) {
			return;
		}
		add_filter( 'init', array( $this, 'init' ) );
	}

	/**
	 * Registers the post type for the Author Box.
	 *
	 * @return void
	 */
	private function register_post_type() {
		$labels = array(
			'name'                  => _x( 'Author Box', 'Post Type General Name', 'user-profile-picture-enhanced' ),
			'singular_name'         => _x( 'Author Box', 'Post Type Singular Name', 'user-profile-picture-enhanced' ),
			'menu_name'             => __( 'Author Box', 'user-profile-picture-enhanced' ),
			'name_admin_bar'        => __( 'Author Box', 'user-profile-picture-enhanced' ),
			'archives'              => __( 'Author Box Archives', 'user-profile-picture-enhanced' ),
			'attributes'            => __( 'Author Box Attributes', 'user-profile-picture-enhanced' ),
			'parent_item_colon'     => __( 'Parent Item:', 'user-profile-picture-enhanced' ),
			'all_items'             => __( 'All Author Boxes', 'user-profile-picture-enhanced' ),
			'add_new_item'          => __( 'Add New Author Box', 'user-profile-picture-enhanced' ),
			'add_new'               => __( 'Add New Author Box', 'user-profile-picture-enhanced' ),
			'new_item'              => __( 'New Author Box', 'user-profile-picture-enhanced' ),
			'edit_item'             => __( 'Edit Author Box', 'user-profile-picture-enhanced' ),
			'update_item'           => __( 'Update Author Box', 'user-profile-picture-enhanced' ),
			'view_item'             => __( 'View Author Box', 'user-profile-picture-enhanced' ),
			'view_items'            => __( 'View Author Boxes', 'user-profile-picture-enhanced' ),
			'search_items'          => __( 'Search Author Boxes', 'user-profile-picture-enhanced' ),
			'not_found'             => __( 'Not found', 'user-profile-picture-enhanced' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'user-profile-picture-enhanced' ),
			'featured_image'        => __( 'Featured Image', 'user-profile-picture-enhanced' ),
			'set_featured_image'    => __( 'Set featured image', 'user-profile-picture-enhanced' ),
			'remove_featured_image' => __( 'Remove featured image', 'user-profile-picture-enhanced' ),
			'use_featured_image'    => __( 'Use as featured image', 'user-profile-picture-enhanced' ),
			'insert_into_item'      => __( 'Insert into item', 'user-profile-picture-enhanced' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Author Box', 'user-profile-picture-enhanced' ),
			'items_list'            => __( 'Author Box List', 'user-profile-picture-enhanced' ),
			'items_list_navigation' => __( 'Author Box list navigation', 'user-profile-picture-enhanced' ),
			'filter_items_list'     => __( 'Filter Author Box list', 'user-profile-picture-enhanced' ),
		);

		$args = array(
			'label'               => __( 'Author Box', 'user-profile-picture-enhanced' ),
			'description'         => __( 'Author Boxes for User Profile Picture', 'user-profile-picture-enhanced' ),
			'labels'              => $labels,
			'hierarchical'        => false,
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 100,
			'menu_icon'           => 'dashicons-groups',
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => false,
			'can_export'          => true,
			'supports'            => array(
				'editor',
				'title',
			),
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'rewrite'             => false,
			'query_var'           => 'uppe_author_box',
			'capability_type'     => 'page',
			'show_in_rest'        => true,
		);
		register_post_type( 'uppe_author_box', $args );
	}
}
