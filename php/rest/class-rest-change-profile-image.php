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
class Rest_Change_Profile_Image {

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
			'/change_profile_image/',
			array(
				'methods'  => 'POST',
				'callback' => array( $this, 'change_avatar' ),
			)
		);
	}

	/**
	 * Changes an avatar for a user via the REST API.
	 *
	 * @param array $request Request for the avatar.
	 *
	 * @return array Avatar information.
	 */
	public function change_avatar( $request ) {
		$user_id  = absint( isset( $request['user_id'] ) ? $request['user_id'] : 0 );
		$media_id = absint( $request['media_id'] );
		if ( ! current_user_can( 'upload_files' ) ) {
			return new \WP_Error( 'mpp_invalid_permissions', __( 'You must have upload privileges to change an Avatar for a user.', 'user-profile-picture-enhanced' ), array( 'status' => 403 ) );
		}

		if ( ! $user_id ) {
			if ( ! isset( $request['post_id'] ) ) {
				return new \WP_Error( 'mpp_invalid_params', __( 'You must pass a user_id or post_id to change an Avatar.', 'user-profile-picture-enhanced' ), array( 'status' => 403 ) );
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

		// Save user meta.
		update_user_option( $user_id, 'metronet_post_id', $profile_post_id );
		update_user_option( $user_id, 'metronet_image_id', $media_id );
		set_post_thumbnail( $profile_post_id, $media_id );

		// Prepare return.
		$attachment_url = wp_get_attachment_url( $media_id );

		return array(
			'24'        => wp_get_attachment_image_url( $media_id, 'profile_24', false, '' ),
			'48'        => wp_get_attachment_image_url( $media_id, 'profile_48', false, '' ),
			'96'        => wp_get_attachment_image_url( $media_id, 'profile_96', false, '' ),
			'150'       => wp_get_attachment_image_url( $media_id, 'profile_150', false, '' ),
			'300'       => wp_get_attachment_image_url( $media_id, 'profile_300', false, '' ),
			'thumbnail' => wp_get_attachment_image_url( $media_id, 'thumbnail', false, '' ),
			'full'      => $attachment_url,
		);
	}
}
