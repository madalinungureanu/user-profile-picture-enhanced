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
		add_action( 'mpp_user_profile_admin_settings_after_row', array( $this, 'output_post_type_options' ), 10, 1 );
		add_action( 'mpp_user_profile_admin_settings_after_row', array( $this, 'output_font_awesome_options' ), 11, 1 );
		add_action( 'mpp_user_profile_admin_settings_after_row', array( $this, 'output_author_box_options' ), 12, 1 );
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
}
