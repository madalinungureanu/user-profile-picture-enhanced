<?php
/**
 * Add Settings page to Plugin and to sub-menu
 *
 * @package   User_Profile_Picture_Enhanced
 */

namespace User_Profile_Picture_Enhanced\Admin;

/**
 * Class Admin
 */
class EDD_License_Settings {

	/**
	 * Initialize the Admin component.
	 */
	public function init() {

	}

	/**
	 * Register any hooks that this component needs.
	 */
	public function register_hooks() {
		add_action( 'init', array( $this, 'register_edd' ) );
	}

	/**
	 * Reister new updater.
	 */
	public function register_edd() {
		require_once 'EDD_SL_Plugin_Updater.php';
		$license = get_site_option( 'uppe_license', false );
		if ( false !== $license ) {

			// setup the updater.
			$edd_updater = new \UPPE_EDD_SL_Plugin_Updater(
				'https://mediaron.com',
				USER_PROFILE_PICTURE_ENHANCED_FILE,
				array(
					'version' => USER_PROFILE_PICTURE_ENHANCED_VERSION,
					'license' => $license,
					'item_id' => 5596,
					'author'  => 'Ronald Huereca',
					'beta'    => false,
					'url'     => home_url(),
				)
			);
		}
		add_action( 'after_plugin_row_' . USER_PROFILE_PICTURE_ENHANCED_SLUG, array( $this, 'after_plugin_row' ), 10, 3 );
	}

	/**
	 * Adds license information
	 *
	 * @since 1.0.0.
	 * @access public
	 * @param string $plugin_file Plugin file.
	 * @param array  $plugin_data Array of plugin data.
	 * @param string $status      If plugin is active or not.
	 *
	 * @return void HTML Settings.
	 */
	public function after_plugin_row( $plugin_file, $plugin_data, $status ) {
		$license        = get_site_option( 'uppe_license', '' );
		$license_status = get_site_option( 'uppe_license_status', false );
		$options_url    = add_query_arg( array( 'page' => 'mpp' ), admin_url( 'admin.php' ) );
		if ( empty( $license ) || false === $license_status ) {
			echo sprintf( '<tr class="active"><td colspan="3">%s <a href="%s">%s</a></td></tr>', esc_html__( 'Please enter a license to receive automatic updates.', 'user-profile-picture-enhanced' ), esc_url( $options_url ), esc_html__( 'Enter License.', 'user-profile-picture-enhanced' ) );
		}
	}
}
