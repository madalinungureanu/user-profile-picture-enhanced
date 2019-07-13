<?php
/**
 * Adds a User Title to the profile page.
 *
 * @package   User_Profile_Picture_Enhanced
 */

namespace User_Profile_Picture_Enhanced\Admin;

/**
 * Class Admin
 */
class User_Title {

	/**
	 * Initialize the Admin component.
	 */
	public function init() {

	}

	/**
	 * Register any hooks that this component needs.
	 */
	public function register_hooks() {
		add_action( 'mpp_user_profile_form', array( $this, 'add_title_to_profile_page' ), 9, 1 );

		// User update action.
		add_action( 'edit_user_profile_update', array( $this, 'save_user_profile' ) );
		add_action( 'personal_options_update', array( $this, 'save_user_profile' ) );
	}

	/**
	 * Add a title to the profile page.
	 *
	 * @param int $user_id The User ID.
	 */
	public function add_title_to_profile_page( $user_id ) {
		$user = get_user_by( 'id', $user_id );
		if ( $user ) {
			$title = get_user_meta( $user_id, 'uppe_title', true );
			if ( ! $title ) {
				$title = '';
			}
			?>
			<tr valign="top">
				<th scope="row"><label for="uppe-title"><?php esc_html_e( 'Title', 'user-profile-picture-enhanced' ); ?></label></th>
				<td id="user-profile-picture-enhanced-title">
					<input type="text" class="regular-text" value="<?php echo esc_attr( $title ); ?>" name="uppe_title" id="uppe-title" />
				</td>
			</tr>
			<?php
		}
	}

	/**
	 * Save a title from the user profile page.
	 *
	 * @param int $user_id The User ID.
	 */
	public function save_user_profile( $user_id ) {
		check_admin_referer( 'update-user_' . $user_id );

		$title = filter_input( INPUT_POST, 'uppe_title' );
		$title = sanitize_text_field( $title );
		update_user_meta( $user_id, 'uppe_title', $title );
	}
}
