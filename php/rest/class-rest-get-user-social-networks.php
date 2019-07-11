<?php
/**
 * Set up the REST API for getting a list of Social Networks.
 *
 * @package   User_Profile_Picture_Enhanced
 */

namespace User_Profile_Picture_Enhanced\Rest;

/**
 * Class Admin
 */
class Rest_Get_User_Social_Networks {

	/**
	 * Initialize the Admin component.
	 */
	public function init() {

	}

	/**
	 * Register any hooks that this component needs.
	 */
	public function register_hooks() {

		// Rest API.
		add_action( 'rest_api_init', array( $this, 'register_rest' ) );
	}

	/**
	 * Registers a REST call for the avatar.
	 */
	public function register_rest() {
		register_rest_route(
			'mpp/v3',
			'/get_social_networks/',
			array(
				'methods'  => 'POST',
				'callback' => array( $this, 'get_networks' ),
			)
		);
	}

	/**
	 * Retrieves a list of social networks for a user via the REST API.
	 *
	 * @param array $request Request for the social networks.
	 *
	 * @return array Social Network icons information.
	 */
	public function get_networks( $request ) {
		$user_id = absint( isset( $request['user_id'] ) ? $request['user_id'] : 0 );

		if ( ! $user_id ) {
			if ( ! isset( $request['post_id'] ) ) {
				return new \WP_Error( 'mpp_invalid_params', __( 'You must pass a user_id or post_id to retrieve an Avatar.', 'user-profile-picture-enhanced' ), array( 'status' => 403 ) );
			} else {
				$post = get_post( $request['post_id'] );
				if ( ! $post ) {
					return new \WP_Error( 'mpp_invalid_post_id', __( 'Could not find a post for that post id.', 'user-profile-picture-enhanced' ), array( 'status' => 403 ) );
				}
				$user_id = absint( $post->post_author );
			}
		}

		// Get profile data.
		$profile_post_id = absint( get_user_option( 'metronet_post_id', $user_id ) );
		if ( 0 === $profile_post_id || 'mt_pp' !== get_post_type( $profile_post_id ) ) {
			return new \WP_Error( 'mpp_no_user', __( 'User not found.', 'user-profile-picture-enhanced' ), array( 'status' => 403 ) );
		}

		// Get social networks for user.
		global $wpdb;
		$tablename = $wpdb->prefix . 'upp_social_networks';
		$results = $wpdb->get_results( $wpdb->prepare( "select * from {$tablename} where user_id = %d ORDER BY item_order ASC", $user_id ) ); // phpcs:ignore

		if ( ! $results ) {
			return new \WP_Error( 'mpp_no_social_networks', __( 'No social networks found for this user.', 'user-profile-picture-enhanced' ), array( 'status' => 403 ) );
		}

		$return = array( 'items' => array() );
		foreach ( $results as $result ) {
			$return['items'][] = array(
				'icon'  => $result->icon,
				'label' => $result->label,
				'url'   => $result->url,
				'slug'  => $result->slug,
			);
		}
		return $return;
	}
}
