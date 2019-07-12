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
class Post_Type {

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
		if ( 'off' === $options['show_profile_post_type'] ) {
			return;
		}
		add_filter( 'mpp_post_type_args', array( $this, 'post_type_args' ) );
		add_filter( 'manage_mt_pp_posts_columns', array( $this, 'post_type_columns' ) );
		add_action( 'manage_mt_pp_posts_custom_column', array( $this, 'post_type_column_output' ), 10, 2 );
	}

	/**
	 * Modify UPP's Post Type Column Output
	 *
	 * @param string $column  Column name.
	 * @param int    $post_id Post ID.
	 *
	 * @return void
	 */
	public function post_type_column_output( $column, $post_id ) {
		$post = get_post( $post_id );
		switch ( $column ) {
			case 'profile_picture':
				echo get_avatar( $post->post_author );
				break;
			case 'profile_title':
				$user = get_user_by( 'id', $post->post_author );
				echo esc_html( $user->data->display_name );
				break;
		}
	}

	/**
	 * Modify UPP's Post Type Appearance
	 *
	 * @param array $columns Column arguments.
	 *
	 * @return array New Column arguments
	 */
	public function post_type_columns( $columns ) {
		unset( $columns['title'] );
		unset( $columns['date'] );
		$columns['profile_title']   = __( 'User', 'user-profile-picture-enhanced' );
		$columns['profile_picture'] = __( 'Avatar', 'user-profile-picture-enhanced' );
		return $columns;
	}

	/**
	 * Modify UPP's Post Type Args
	 *
	 * @param array $args Post Type arguments.
	 *
	 * @return array New Post Type arguments
	 */
	public function post_type_args( $args ) {
		$labels  = array(
			'name'                  => _x( 'Profile Pictures', 'Post Type General Name', 'user-profile-picture-enhanced' ),
			'singular_name'         => _x( 'Profile Picture', 'Post Type Singular Name', 'user-profile-picture-enhanced' ),
			'menu_name'             => __( 'Profile Pictures', 'user-profile-picture-enhanced' ),
			'name_admin_bar'        => __( 'Profile Picture', 'user-profile-picture-enhanced' ),
			'archives'              => __( 'Profile Picture Archives', 'user-profile-picture-enhanced' ),
			'attributes'            => __( 'Profile Picture Attributes', 'user-profile-picture-enhanced' ),
			'parent_item_colon'     => __( 'Parent Item:', 'user-profile-picture-enhanced' ),
			'all_items'             => __( 'All Profile Pictures', 'user-profile-picture-enhanced' ),
			'add_new_item'          => __( 'Add New Profile Picture', 'user-profile-picture-enhanced' ),
			'add_new'               => __( 'Add New Profile Picture', 'user-profile-picture-enhanced' ),
			'new_item'              => __( 'New Profile Picture', 'user-profile-picture-enhanced' ),
			'edit_item'             => __( 'Edit Profile Picture', 'user-profile-picture-enhanced' ),
			'update_item'           => __( 'Update Profile Picture', 'user-profile-picture-enhanced' ),
			'view_item'             => __( 'View Profile Picture', 'user-profile-picture-enhanced' ),
			'view_items'            => __( 'View Profile Pictures', 'user-profile-picture-enhanced' ),
			'search_items'          => __( 'Search Profile Pictures', 'user-profile-picture-enhanced' ),
			'not_found'             => __( 'Not found', 'user-profile-picture-enhanced' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'user-profile-picture-enhanced' ),
			'featured_image'        => __( 'Featured Image', 'user-profile-picture-enhanced' ),
			'set_featured_image'    => __( 'Set featured image', 'user-profile-picture-enhanced' ),
			'remove_featured_image' => __( 'Remove featured image', 'user-profile-picture-enhanced' ),
			'use_featured_image'    => __( 'Use as featured image', 'user-profile-picture-enhanced' ),
			'insert_into_item'      => __( 'Insert into item', 'user-profile-picture-enhanced' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Profile Picture', 'user-profile-picture-enhanced' ),
			'items_list'            => __( 'Profile Picture List', 'user-profile-picture-enhanced' ),
			'items_list_navigation' => __( 'Profile Picture list navigation', 'user-profile-picture-enhanced' ),
			'filter_items_list'     => __( 'Filter Profile Picture list', 'user-profile-picture-enhanced' ),
		);
		global $mt_pp;
		$options = $mt_pp->get_options();
		if ( 'on' === $options['allow_public_profiles'] ) {
			$rewrite = array(
				'slug'       => 'users',
				'with_front' => true,
				'pages'      => true,
				'feeds'      => false,
			);
		} else {
			$rewrite = false;
		}

		$args = array(
			'label'               => __( 'Profile Picture', 'user-profile-picture-enhanced' ),
			'description'         => __( 'User Profile Picture', 'user-profile-picture-enhanced' ),
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
				'thumbnail',
				'title',
				'excerpt',
			),
			'has_archive'         => 'on' === $options['allow_public_profiles'] ? true : false,
			'exclude_from_search' => true,
			'publicly_queryable'  => 'on' === $options['allow_public_profiles'] ? true : false,
			'rewrite'             => $rewrite,
			'query_var'           => 'uppe_user',
			'capability_type'     => 'page',
			'capabilities'        => array(
				'create_posts' => 'do_not_allow',
			),
			'map_meta_cap'        => true,
			'show_in_rest'        => true,
		);
		return $args;
	}
}
