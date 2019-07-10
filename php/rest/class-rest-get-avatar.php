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
class Rest_Get_Avatar {

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
			'/get_avatar/',
			array(
				'methods'  => 'POST',
				'callback' => array( $this, 'get_avatar' ),
			)
		);
	}

	/**
	 * Retrieves an Avatar for a user via the REST API.
	 *
	 * @param array $request Request for the avatar.
	 *
	 * @return array Avatar information.
	 */
	public function get_avatar( $request ) {
		$user_id = absint( isset( $request['user_id'] ) ? $request['user_id'] : 0 );
		$size    = absint( $request['size'] );

		if ( ! $user_id ) {
			if ( ! isset( $request['post_id'] ) ) {
				return new WP_Error( 'mpp_invalid_params', __( 'You must pass a user_id or post_id to retrieve an Avatar.', 'user-profile-picture-enhanced' ), array( 'status' => 403 ) );
			} else {
				$post = get_post( $request['post_id'] );
				if ( ! $post ) {
					return new WP_Error( 'mpp_invalid_post_id', __( 'Could not find a post for that post id.', 'user-profile-picture-enhanced' ), array( 'status' => 403 ) );
				}
				$user_id = absint( $post->post_author );
			}
		}

		// Get profile data.
		$profile_post_id = absint( get_user_option( 'metronet_post_id', $user_id ) );
		if ( 0 === $profile_post_id || 'mt_pp' !== get_post_type( $profile_post_id ) ) {
			return new WP_Error( 'mpp_no_user', __( 'User not found.', 'user-profile-picture-enhanced' ), array( 'status' => 403 ) );
		}

		// Check the profile image.
		$post_thumbnail_id = get_post_thumbnail_id( $profile_post_id );
		if ( ! $post_thumbnail_id ) {
			return new WP_Error( 'mpp_no_user_profile_image', __( 'User profile picture not found.', 'user-profile-picture-enhanced' ), array( 'status' => 403 ) );
		}

		// Get the ALT tag for the image if available.
		$alt = get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true );

		// Get Image HTML.
		$image_html = mt_profile_img(
			$user_id,
			array(
				'echo' => false,
				'size' => $size,
				'alt'  => $alt,
			)
		);

		// Get Image.
		$image_arr = wp_get_attachment_image_src( $post_thumbnail_id, $size );
		$image_url = $image_arr[0];

		// Begin to return.
		$return = array(
			'html'   => $image_html,
			'alt'    => $alt,
			'src'    => $image_url,
			'width'  => $image_arr[1],
			'height' => $image_arr[2],
		);
		return $return;
	}
}
