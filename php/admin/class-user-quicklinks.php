<?php
/**
 * Adds quick links to the user profile page.
 *
 * @package   User_Profile_Picture_Enhanced
 */

namespace User_Profile_Picture_Enhanced\Admin;

/**
 * Class Admin
 */
class User_Quicklinks {

	/**
	 * Array of options.
	 *
	 * @var $options
	 */
	private $options = array();

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
		$this->options = $mt_pp->get_options();
		if ( 'off' === $this->options['show_profile_post_type'] ) {
			return;
		}
		add_filter( 'user_row_actions', array( $this, 'insert_user_profile_quicklink' ), 10, 2 );
		add_action( 'mpp_user_profile_form', array( $this, 'add_quicklinks_to_profile_page' ), 20 );
	}

	/**
	 * Add a quick link to the profile page.
	 */
	public function add_quicklinks_to_profile_page() {
		$profile_post_id = absint( get_user_option( 'metronet_post_id', $user->data->ID ) );
		if ( $profile_post_id ) {
			$user_edit_page = add_query_arg(
				array(
					'post'   => $profile_post_id,
					'action' => 'edit',
				),
				admin_url( 'post.php' )
			);
			$permalink      = get_permalink( $profile_post_id );
			if ( $permalink ) {
				?>
				<tr valign="top">
					<th scope="row"><?php esc_html_e( 'Public Profile Page', 'user-profile-picture-enhanced' ); ?></th>
					<td id="user-profile-picture-enhanced-view-profile-page">
						<p>
							<?php echo esc_html__( 'Profile pages for your users are public.' ); ?> | <a href="<?php echo esc_url( $user_edit_page ); ?>" target="_blank"><?php echo esc_html__( 'Edit Profile Page', 'user-profile-picture-enhanced' ); ?></a> | <a href="<?php echo esc_url( $permalink ); ?>" target="_blank"><?php echo esc_html( 'View Profile Page', 'user-profile-picture-enhanced' ); ?></a>
						</p>
					</td>
				</tr>
				<?php
			}
		}
	}

	/**
	 * Insert a quick link for the user in the quick links.
	 *
	 * @param array   $actions  Array of row action options.
	 * @param WP_User $user     User of the row action.
	 *
	 * @return array New Row actions.
	 */
	public function insert_user_profile_quicklink( $actions, $user ) {
		$profile_post_id = absint( get_user_option( 'metronet_post_id', $user->data->ID ) );
		if ( $profile_post_id ) {
			$permalink = add_query_arg(
				array(
					'post'   => $profile_post_id,
					'action' => 'edit',
				),
				admin_url( 'post.php' )
			);
			if ( $permalink ) {
				$actions['uppe_quicklink'] = sprintf( '<a href="%s">%s</a>', esc_url( $permalink ), esc_html__( 'Edit Profile Page', 'user-profile-picture-enhanced' ) );
			}
		}
		return $actions;
	}
}
