<?php
/**
 * Show a notice to migrate.
 *
 * @package   User_Profile_Picture_Enhanced
 */

namespace User_Profile_Picture_Enhanced\Admin;

/**
 * Class Admin
 */
class Migrate {

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
		$options = $mt_pp->get_options();
		if ( 'off' === $options['migrated'] ) {
			add_action( 'admin_notices', array( $this, 'show_migration_notice' ) );
			add_action( 'admin_menu', array( $this, 'register_admin_page' ) );
			add_action( 'wp_ajax_migrate_upp_data', array( $this, 'ajax_migrate_data' ) );
		}
	}

	/**
	 * Migrates User Profile Data to the new format
	 */
	public function ajax_migrate_data() {
		$post_data = wp_unslash( $_POST );
		if ( ! current_user_can( 'edit_pages' ) || ! wp_verify_nonce( $post_data['nonce'], 'upp-migrate-posts' ) ) {
			die( '' );
		}

		$offset = absint( $post_data['offset'] );

		$post_args = array(
			'posts_per_page' => 10,
			'offset'         => $offset,
			'post_type'      => 'mt_pp',
			'orderby'        => 'date',
			'order'          => 'DESC',
		);
		$posts     = get_posts( $post_args );
		if ( ! empty( $posts ) ) {
			foreach ( $posts as $post ) {
				$user_id = $post->post_author;
				$user    = get_user_by( 'id', $user_id );

				// Update the post title.
				$post->post_title = esc_html( $user->data->display_name );
				$post->post_name  = esc_html( sanitize_title( $post->post_title ) );
				wp_update_post( $post );
				$offset++;
			}
			$return               = array();
			$return['offset']     = $offset;
			$return['more_posts'] = true;
			die( wp_json_encode( $return ) );
		} else {
			$return['offset']     = $offset;
			$return['more_posts'] = false;

			// Update option to show we have migrated.
			global $mt_pp;
			$options             = $mt_pp->get_options();
			$options['migrated'] = 'on';
			$mt_pp->update_options( $options );
			die( wp_json_encode( $return ) );
		}
	}

	/**
	 * Adds a migration notice for new users.
	 */
	public function show_migration_notice() {
		global $pagenow;
		if ( 'tools.php' === $pagenow ) {
			return;
		}
		printf(
			'<div class="error"><p>%s <a class="button button-secondary" href="%s">%s</a></p></div>',
			esc_html__( 'User Profile Picture data needs to be migrated for User Profile Enhanced to function properly.', 'user-profile-picture-enhanced' ),
			esc_url( admin_url( 'tools.php?page=user-profile-picture-enhanced-migrate' ) ),
			esc_html__( 'Migrate Now.', 'user-profile-picture-enhanced' )
		);
	}

	/**
	 * Registers Tools Page for Migrating Data
	 */
	public function register_admin_page() {
		$page_hook = add_management_page(
			__( 'User Profile Picture Migration', 'user-profile-picture-enhanced' ),
			__( 'Migrate User Profile Picture Data', 'user-profile-picture-enhanced' ),
			'edit_pages',
			'user-profile-picture-enhanced-migrate',
			array( $this, 'output_menu_html' )
		);
		add_action( 'admin_print_scripts-' . $page_hook, array( $this, 'print_scripts' ) );
	}

	/**
	 * Outputs the migrate menu item area.
	 */
	public function output_menu_html() {
		?>
		<div class="wrap">
			<h2><?php esc_html_e( 'User Profile Picture Data Migration', 'user-profile-picture-enhanced' ); ?></h2>
			<?php wp_nonce_field( 'upp-migrate-posts', '_upp_migrate_posts' ); ?>
			<p><?php echo esc_html__( 'It looks like we have some data to migrate! Click the migration button below to begin.', 'user-profile-picture-enhanced' ); ?></p>
			<?php submit_button( __( 'Migrate Now', 'user-profile-picture-enhanced' ), 'primary', 'upp-migrate' ); ?>
			<div id="build-status-container"><p><strong id="build-status-container-label"></strong></p></div>
		</div>
		<?php
	}

	/**
	 * Enqueue's the necessary scripts for the tools page.
	 */
	public function print_scripts() {
		wp_enqueue_script(
			'upp-enhanced-migrate',
			USER_PROFILE_PICTURE_ENHANCED_URL . 'js/migrate.js',
			array( 'jquery' ),
			USER_PROFILE_PICTURE_ENHANCED_VERSION,
			true
		);
		wp_localize_script(
			'upp-enhanced-migrate',
			'upp_enhanced',
			array(
				'migrating' => __( 'Migrating...', 'user-profile-picture-enhanced' ),
				'migrated'  => __( 'All Done!', 'user-profile-profile-enhanced' ),
				'upp_page'  => esc_url( admin_url( 'options-general.php?page=mpp' ) ),
			)
		);
	}
}
