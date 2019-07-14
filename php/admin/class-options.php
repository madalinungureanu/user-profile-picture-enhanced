<?php
/**
 * Add options to UPP and its defaults
 *
 * @package   User_Profile_Picture_Enhanced
 */

namespace User_Profile_Picture_Enhanced\Admin;

/**
 * Class Admin
 */
class Options {

	/**
	 * Initialize the Admin component.
	 */
	public function init() {

	}

	/**
	 * Register any hooks that this component needs.
	 */
	public function register_hooks() {
		add_filter( 'mpp_options_defaults', array( $this, 'option_defaults' ), 10, 1 );
		add_action( 'mpp_user_profile_admin_settings_after_row', array( $this, 'output_license_setting' ), 8, 1 );
		add_action( 'mpp_user_profile_admin_settings_after_row', array( $this, 'output_post_type_options' ), 10, 1 );
		add_action( 'mpp_user_profile_admin_settings_after_row', array( $this, 'output_font_awesome_options' ), 11, 1 );
		add_action( 'mpp_user_profile_admin_settings_after_row', array( $this, 'output_author_box_options' ), 12, 1 );
		add_action( 'mpp_user_profile_admin_settings_after_row', array( $this, 'output_author_box_select' ), 13, 1 );
	}

	/**
	 * Provide default options this plugin needs for User Profile Picture.
	 *
	 * @param array $defaults The default options for User Profile Picture.
	 *
	 * @return array New Defaults.
	 */
	public function option_defaults( $defaults ) {
		$defaults['migrated']               = 'off';
		$defaults['show_profile_post_type'] = 'off';
		$defaults['allow_public_profiles']  = 'off';
		$defaults['font_awesome_admin']     = 'on';
		$defaults['font_awesome_frontend']  = 'off';
		$defaults['author_box_type']        = 'off';
		return $defaults;
	}

	/**
	 * Output the Post Type Options for this plugin.
	 *
	 * @param array $options Options for the plugin.
	 */
	public function output_post_type_options( $options ) {
		?>
		<tr>
			<th scope="row"><?php esc_html_e( 'Post Type Options', 'user-profile-picture-enhanced' ); ?></th>
			<td>
				<input type="hidden" name="options[migrated]" value="<?php echo esc_attr( $options['migrated'] ); ?>" />
				<input type="hidden" name="options[show_profile_post_type]" value="off" />
				<input id="show-profile-picture-post-type" type="checkbox" value="on" name="options[show_profile_post_type]" <?php checked( 'on', $options['show_profile_post_type'] ); ?> /> <label for="show-profile-picture-post-type"><?php esc_html_e( 'Show the User Profile Picture Post Type', 'user-profile-picture-enhanced' ); ?></label>
				<p class="description"><?php esc_html_e( 'User Profile Picture has a hidden post type. Select this option to be able to edit the post type and its profile pictures that are attached.', 'user-profile-picture-enhanced' ); ?></p>

				<input type="hidden" name="options[allow_public_profiles]" value="off" />
				<input id="allow-public-profiles" type="checkbox" value="on" name="options[allow_public_profiles]" <?php checked( 'on', $options['allow_public_profiles'] ); ?> /> <label for="allow-public-profiles"><?php esc_html_e( 'Allow users to have public profiles.', 'user-profile-picture-enhanced' ); ?></label>
				<p class="description"><?php esc_html_e( 'Allow the post type to be viewable by users on the front-end of the site.', 'user-profile-picture-enhanced' ); ?></p>
			</td>
		</tr>
		<?php
	}
	/**
	 * Output the Font Awesome options for this plugin.
	 *
	 * @param array $options Options for the plugin.
	 */
	public function output_font_awesome_options( $options ) {
		?>
		<tr>
			<th scope="row"><?php esc_html_e( 'Font Awesome Options', 'user-profile-picture-enhanced' ); ?></th>
			<td>
				<input type="hidden" name="options[font_awesome_admin]" value="off" />
				<input id="font-awesome-admin" type="checkbox" value="on" name="options[font_awesome_admin]" <?php checked( 'on', $options['font_awesome_admin'] ); ?> /> <label for="font-awesome-admin"><?php esc_html_e( 'Allow Font Awesome 5 in the Admin Area?', 'user-profile-picture-enhanced' ); ?></label>
				<p class="description"><?php esc_html_e( 'Uncheck this box if you already have Font Awesome 5 running in the admin area of your site.', 'user-profile-picture-enhanced' ); ?></p>

				<input type="hidden" name="options[font_awesome_frontend]" value="off" />
				<input id="font-awesome-front-end" type="checkbox" value="on" name="options[font_awesome_frontend]" <?php checked( 'on', $options['font_awesome_frontend'] ); ?> /> <label for="font-awesome-front-end"><?php esc_html_e( 'Allow Font Awesome 5 on the front-end of your site?', 'user-profile-picture-enhanced' ); ?></label>
				<p class="description"><?php esc_html_e( 'Uncheck this box if you already have Font Awesome 5 running on the front-end of your site.', 'user-profile-picture-enhanced' ); ?></p>
			</td>
		</tr>
		<?php
	}

	/**
	 * Output the Author Box options for this plugin.
	 *
	 * @param array $options Options for the plugin.
	 */
	public function output_author_box_options( $options ) {
		?>
		<tr>
			<th scope="row"><?php esc_html_e( 'Author Box Options', 'user-profile-picture-enhanced' ); ?></th>
			<td>
				<input type="hidden" name="options[author_box_type]" value="off" />
				<input id="author-box-post-type" type="checkbox" value="on" name="options[author_box_type]" <?php checked( 'on', $options['author_box_type'] ); ?> /> <label for="author-box-post-type"><?php esc_html_e( 'Enable Author Boxes?', 'user-profile-picture-enhanced' ); ?></label>
				<p class="description"><?php esc_html_e( 'Check this box to enable an Author Box post type. This will allow you to insert an Author Box below the content area of your site.', 'user-profile-picture-enhanced' ); ?></p>
			</td>
		</tr>
		<?php
	}

	/**
	 * Output the Author Box options for post types.
	 *
	 * @param array $options Options for the plugin.
	 */
	public function output_author_box_select( $options ) {
		if ( 'off' === $options['author_box_type'] ) {
			return;
		}
		?>
		<tr>
			<th scope="row"><?php esc_html_e( 'Author Box Select', 'user-profile-picture-enhanced' ); ?></th>
			<td>
				<p class="description"><?php esc_html_e( 'Select an Author Box to show up for each post type. Select none for no author box for that post type.', 'user-profile-picture-enhanced' ); ?></p>
			</td>
		</tr>
		<?php
	}

	/**
	 * Output the Font Awesome options for this plugin.
	 *
	 * @param array $options Options for the plugin.
	 */
	public function output_license_setting( $options ) {
		if ( isset( $_POST['submit'] ) && isset( $_POST['options'] ) ) { // phpcs:ignore

			// Check for valid license.
			$store_url  = 'https://bbvapormodules.com';
			$api_params = array(
				'edd_action' => 'activate_license',
				'license'    => $_POST['options']['license'], // phpcs:ignore
				'item_name'  => urlencode( 'User Profile Picture Enhanced' ), // phpcs:ignore
				'url'        => home_url(),
			);
			// Call the custom API.
			$response = wp_remote_post(
				$store_url,
				array(
					'timeout'   => 15,
					'sslverify' => false,
					'body'      => $api_params,
				)
			);

			// make sure the response came back okay.
			if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {

				if ( is_wp_error( $response ) ) {
					$license_message = $response->get_error_message();
				} else {
					$license_message = __( 'An error occurred, please try again.', 'user-profile-picture-enhanced' );
				}
			} else {

				$license_data = json_decode( wp_remote_retrieve_body( $response ) );

				if ( false === $license_data->success ) {
					delete_site_option( 'uppe_license_status' );
					switch ( $license_data->error ) {

						case 'expired':
							$license_message = sprintf(
								__( 'Your license key expired on %s.', 'user-profile-picture-enhanced' ), /* phpcs:ignore */
								date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires, current_time( 'timestamp' ) ) )
							);
							break;

						case 'disabled':
						case 'revoked':
							$license_message = __( 'Your license key has been disabled.', 'user-profile-picture-enhanced' );
							break;

						case 'missing':
							$license_message = __( 'Invalid license.', 'user-profile-picture-enhanced' );
							break;

						case 'invalid':
						case 'site_inactive':
							$license_message = __( 'Your license is not active for this URL.', 'user-profile-picture-enhanced' );
							break;
						case 'item_name_mismatch':
							$license_message = sprintf( __( 'This appears to be an invalid license key for %s.', 'user-profile-picture-enhanced' ), 'User Profile Picture Enhanced' ); // phpcs:ignore
							break;
						case 'no_activations_left':
							$license_message = __( 'Your license key has reached its activation limit.', 'user-profile-picture-enhanced' );
							break;

						default:
							$license_message = __( 'An error occurred, please try again.', 'user-profile-picture-enhanced' );
							break;
					}
				}
				if ( empty( $license_message ) ) {
					update_site_option( 'uppe_license_status', $license_data->license );
					update_site_option( 'uppe_license', sanitize_text_field( $_POST['options']['license'] ) ); // phpcs:ignore
				}
			}
		}
		$license_status = get_site_option( 'uppe_license_status', false );
		$license        = get_site_option( 'uppe_license', '' );
		?>
		<tr>
			<th scope="row"><label for="uppe-license"><?php esc_html_e( 'Enter Your License', 'user-profile-picture-enhanced' ); ?></label></th>
			<td>
				<input id="uppe-license" class="regular-text" type="text" value="<?php echo esc_attr( $license ); ?>" name="options[license]" /><br />
				<?php
				if( false === $license || empty( $license ) ) {
					printf( '<p>%s</p>', esc_html__( 'Please enter your license key.', 'user-profile-picture-enhanced' ) );
				} else {
					printf( '<p>%s</p>', esc_html__( 'Your license is valid and you will now receive update notifications.', 'user-profile-picture-enhanced' ) );
				}
				?>
				<?php
				if ( ! empty( $license_message ) ) {
					printf( '<div class="updated error"><p><strong>%s</p></strong></div>', esc_html( $license_message ) );
				}
				?>
			</td>
		</tr>
		<?php
	}
}
