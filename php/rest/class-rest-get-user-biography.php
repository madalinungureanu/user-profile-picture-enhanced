<?php
/**
 * Set up the REST API for getting an Avatar.
 *
 * @package   User_Profile_Picture_Enhanced
 */

namespace User_Profile_Picture_Enhanced\Rest;

/**
 * Class Admin
 */
class Rest_Get_User_Biography {

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
			'/get_user_biography/',
			array(
				'methods'  => 'POST',
				'callback' => array( $this, 'get_biography' ),
			)
		);
	}

	/**
	 * Retrieves a biogrpahy for a user via the REST API.
	 *
	 * @param array $request Request for the biography.
	 *
	 * @return array biography information.
	 */
	public function get_biography( $request ) {
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

		// Begin to return.
		$return = array(
			'biography' => get_user_meta( $user_id, 'description', true ),
		);
		return $return;
	}
}
