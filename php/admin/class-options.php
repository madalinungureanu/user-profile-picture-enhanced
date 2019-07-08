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
		add_action( 'mpp_user_profile_admin_settings_after_row', array( $this, 'output_options' ) );
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
		return $defaults;
	}

	/**
	 * Output the Options for this plugin.
	 *
	 * @param array $options Options for the plugin.
	 */
	public function output_options( $options ) {
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
}
