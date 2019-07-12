<?php
/**
 * Add Social Networks to User Profile Screen and load associated JS and Ajax calls.
 *
 * @package   User_Profile_Picture_Enhanced
 */

namespace User_Profile_Picture_Enhanced\Admin;

/**
 * Class Admin
 */
class Social_Networks {

	/**
	 * Initialize the Admin component.
	 */
	public function init() {

	}

	/**
	 * Register any hooks that this component needs.
	 */
	public function register_hooks() {
		add_action( 'mpp_user_profile_form', array( $this, 'add_social_networks_to_profile_page' ) );
		$this->create_table();

		// Ajax Calls.
		add_action( 'wp_ajax_add_upp_social', array( $this, 'ajax_add_user_social_network' ) );
		add_action( 'wp_ajax_remove_upp_social', array( $this, 'ajax_remove_social_network' ) );
		add_action( 'wp_ajax_save_upp_social', array( $this, 'ajax_save_social_network' ) );
		add_action( 'wp_ajax_sort_upp_social', array( $this, 'ajax_sort_social_networks' ) );

		// Load profile page CSS.
		add_action( 'admin_enqueue_scripts', array( $this, 'load_styles' ), 10, 1 );
	}

	/**
	 * Load CSS on the user profile page.
	 *
	 * @param string $hook The current page in the admin.
	 */
	public function load_styles( $hook ) {
		if ( 'profile.php' !== $hook ) {
			return;
		}
		wp_enqueue_style(
			'user-profile-picture-enhanced-profile',
			USER_PROFILE_PICTURE_ENHANCED_URL . 'css/user-profile-enhanced-profile-admin.css',
			array(),
			USER_PROFILE_PICTURE_ENHANCED_VERSION,
			'all'
		);
	}

	/**
	 * Sort the social networks.
	 */
	public function ajax_sort_social_networks() {
		$post_data = wp_unslash( $_POST );
		if ( ! current_user_can( 'edit_pages' ) || ! wp_verify_nonce( $post_data['nonce'], 'add-social-networks' ) ) {
			die( '' );
		}
		$items = $post_data['data'];
		global $wpdb;
		$tablename = $wpdb->prefix . 'upp_social_networks';
		foreach ( $items as $key => $item ) {
			$wpdb->update( // phpcs:ignore
				$tablename,
				array(
					'item_order' => absint( $item['order'] ),
				),
				array(
					'id' => absint( $item['id'] ),
				),
				array( '%d' )
			);
		}
		die( '' );
	}

	/**
	 * Saves a social network URL.
	 */
	public function ajax_save_social_network() {
		$post_data = wp_unslash( $_POST );
		if ( ! current_user_can( 'edit_pages' ) || ! wp_verify_nonce( $post_data['nonce'], 'add-social-networks' ) ) {
			die( '' );
		}

		$profile_id = absint( $post_data['id'] );
		$url        = esc_url( $post_data['url'] );

		global $wpdb;
		$tablename = $wpdb->prefix . 'upp_social_networks';
		$wpdb->update( // phpcs:ignore
			$tablename,
			array(
				'url' => $url,
			),
			array(
				'id' => $profile_id,
			),
			array( '%s' )
		);
		die( '' );
	}

	/**
	 * Removes a social media item.
	 */
	public function ajax_remove_social_network() {
		$post_data = wp_unslash( $_POST );
		if ( ! current_user_can( 'edit_pages' ) || ! wp_verify_nonce( $post_data['nonce'], 'add-social-networks' ) ) {
			die( '' );
		}
		$profile_id = absint( $post_data['id'] );
		global $wpdb;
		$tablename = $wpdb->prefix . 'upp_social_networks';
		$wpdb->delete( // phpcs:ignore
			$tablename,
			array( 'id' => $profile_id ),
			array( '%d' )
		);
		die( '' );
	}

	/**
	 * Adds a social network for a user. Returns HTML markup.
	 */
	public function ajax_add_user_social_network() {
		$post_data = wp_unslash( $_POST );
		if ( ! current_user_can( 'edit_pages' ) || ! wp_verify_nonce( $post_data['nonce'], 'add-social-networks' ) ) {
			die( '' );
		}

		// Save the profile data to the custom table.
		global $wpdb;
		$tablename = $wpdb->prefix . 'upp_social_networks';
		$wpdb->insert( // phpcs:ignore
			$tablename,
			array(
				'user_id'    => absint( $post_data['user_id'] ),
				'slug'       => sanitize_text_field( $post_data['slug'] ),
				'label'      => sanitize_text_field( $post_data['label'] ),
				'icon'       => sanitize_text_field( $post_data['icon'] ),
				'url'        => '',
				'date'       => current_time( 'mysql' ),
				'item_order' => absint( $post_data['order'] ),
			),
			array(
				'%d',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
			)
		);

		// Return HTML.
		$profile_id = $wpdb->insert_id;
		die( $this->get_profile_html( $profile_id, $post_data['order'], $post_data['icon'], '' ) ); // phpcs:ignore
	}

	/**
	 * Retrieves the profile picture HTML.
	 *
	 * @param int    $profile_id The social profile ID for the user.
	 * @param int    $order      The order of the social profile.
	 * @param string $icon       The FA icon for the social profile.
	 * @param string $url        The URL of the social network.
	 *
	 * @return string HTML.
	 */
	private function get_profile_html( $profile_id, $order, $icon, $url ) {
		$html = '<li><div class="user-profile-enhanced-social-item" data-id="' . absint( $profile_id ) . '" data-order="' . absint( $order ) . '" data-icon="' . esc_attr( $icon ) . '"><i class="' . esc_attr( $icon ) . '"></i> <input class="user-profile-enhanced-url regular-text" type="text" value="' . esc_attr( $url ) . '" placeholder="https://" /> <a class="user-profile-enhanced-social-item-save button button-secondary" href="#" class="button button-secondary">' . esc_html__( 'Save', 'user-profile-picture-enhanced' ) . '</a> <a class="user-profile-enhanced-social-item-remove button button-secondary button-link-delete" href="#" class="button button-secondary">' . esc_html__( 'Remove', 'user-profile-picture-enhanced' ) . '</a></div></li>';
		return $html;
	}

	/**
	 * Get a list of social networks for the user sorted by order.
	 *
	 * @param int $user_id The user ID to get the social networks for.
	 *
	 * @return string HTML for the user profile social networks
	 */
	private function get_social_networks_for_user( $user_id ) {
		global $wpdb;
		$tablename = $wpdb->prefix . 'upp_social_networks';
		$results   = $wpdb->get_results( // phpcs:ignore
			$wpdb->prepare(
				"select * from {$tablename} WHERE user_id = %d ORDER BY item_order ASC", // phpcs:ignore
				$user_id
			)
		);
		if ( 0 === count( $results ) ) {
			return '';
		}

		// Loop through results and get HTML.
		$html = '';
		foreach ( $results as $result ) {
			$html .= $this->get_profile_html( $result->id, $result->item_order, $result->icon, $result->url );
		}
		return $html;
	}

	/**
	 * Add Social Networks Admin
	 */
	public function add_social_networks_to_profile_page() {
		global $mt_pp;
		$options = $mt_pp->get_options();

		wp_enqueue_script(
			'upp-sortable-init',
			USER_PROFILE_PICTURE_ENHANCED_URL . 'js/sortable-init.js',
			array( 'jquery', 'jquery-ui-sortable' ),
			USER_PROFILE_PICTURE_ENHANCED_VERSION,
			true
		);
		wp_enqueue_script(
			'upp-enhanced-social',
			USER_PROFILE_PICTURE_ENHANCED_URL . 'js/social-networks.js',
			array( 'upp-sortable-init' ),
			USER_PROFILE_PICTURE_ENHANCED_VERSION,
			true
		);
		wp_localize_script(
			'upp-enhanced-social',
			'upp_enhanced',
			array(
				'remove'      => __( 'Remove', 'user-profile-picture-enhanced' ),
				'removing'    => __( 'Removing...', 'user-profile-picture-enhanced' ),
				'saved'       => __( 'Saved', 'user-profile-picture-enhanced' ),
				'save'        => __( 'Save', 'user-profile-picture-enhanced' ),
				'saving'      => __( 'Saving...', 'user-profile-picture-enhanced' ),
				'placeholder' => 'https://',
			)
		);
		if ( 'on' === $options['font_awesome_admin'] ) {
			wp_enqueue_script(
				'font-awesome',
				'https://kit.fontawesome.com/9869399772.js',
				array(),
				USER_PROFILE_PICTURE_ENHANCED_VERSION,
				true
			);
		}
		?>
		<tr valign="top">
			<th scope="row"><?php esc_html_e( 'Social Networks', 'user-profile-picture-enhanced' ); ?></th>
			<td id="user-profile-picture-enhanced-social-networks">
				<?php
				wp_nonce_field( 'add-social-networks', 'upp_add_social_network' );
				$social_networks = $this->get_social_networks();
				?>
				<select id="user-profile-enhanced-social-options">
					<?php
					foreach ( $social_networks as $value => $network ) {
						printf(
							'<option value="%s" data-icon="%s">%s</option>',
							esc_attr( $value ),
							esc_attr( $network['fa'] ),
							esc_html( $network['label'] )
						);
					}
					?>
				</select>
				<a href="#" id="user-profile-enhanced-social-add" class="button button-secondary"><?php esc_html_e( 'Add Social Network', 'user-profile-picture-enhanced' ); ?></a>
				<div id="user-profile-enhanced-spinner" style="display: none;"><?php printf( '<img class="mpp-loading" width="40" height="40" alt="Loading" src="%s" />', esc_url( $mt_pp::get_plugin_url( '/img/loading.gif' ) ) ); ?></div>
				<div>
					<ul id="user-profile-picture-enhanced-sortable">
					<?php
					$user_id = $mt_pp->get_user_id();
					echo $this->get_social_networks_for_user( $user_id ); // phpcs:ignore
					?>
					</ul>
				</div>
			</td>
		</tr>
		<?php
	}

	/**
	 * Get a list of social networks
	 *
	 * @return array List of supported social networks.
	 */
	private function get_social_networks() {
		$social_networks = array(
			'amazon'      => array(
				'label' => 'Amazon',
				'fa'    => 'fab fa-amazon',
			),
			'behance'     => array(
				'label' => 'Behance',
				'fa'    => 'fab fa-behance',
			),
			'blogger'     => array(
				'label' => 'Blogger',
				'fa'    => 'fab fa-blogger',
			),
			'codepen'     => array(
				'label' => 'Codepen',
				'fa'    => 'fab fa-codepen',
			),
			'dribble'     => array(
				'label' => 'Dribble',
				'fa'    => 'fab fa-dribbble',
			),
			'dropbox'     => array(
				'label' => 'Dropbox',
				'fa'    => 'fab fa-dropbox',
			),
			'facebook'    => array(
				'label' => 'Facebook',
				'fa'    => 'fab fa-facebook-f',
			),
			'flickr'      => array(
				'label' => 'Flickr',
				'fa'    => 'fab fa-flickr',
			),
			'feed'        => array(
				'label' => 'Feed',
				'fa'    => 'fas fa-rss',
			),
			'fourquare'   => array(
				'label' => 'Fourquare',
				'fa'    => 'fab fa-foursquare',
			),
			'ghost'       => array(
				'label' => 'Ghost',
				'fa'    => 'fas fa-goast',
			),
			'github'      => array(
				'label' => 'GitHub',
				'fa'    => 'fab fa-github',
			),
			'google'      => array(
				'label' => 'Google',
				'fa'    => 'fab fa-google',
			),
			'instagram'   => array(
				'label' => 'Instagram',
				'fa'    => 'fab fa-instagram',
			),
			'linkedin'    => array(
				'label' => 'LinkedIn',
				'fa'    => 'fab fa-linkedin',
			),
			'medium'      => array(
				'label' => 'Medium',
				'fa'    => 'fab fa-medium-m',
			),
			'pinterest'   => array(
				'label' => 'Pinterest',
				'fa'    => 'fab fa-pinterest-p',
			),
			'pocket'      => array(
				'label' => 'Pocket',
				'fa'    => 'fab fa-get-pocket',
			),
			'reddit'      => array(
				'label' => 'Reddit',
				'fa'    => 'fab fa-reddit-alien',
			),
			'skype'       => array(
				'label' => 'Skype',
				'fa'    => 'fab fa-skype',
			),
			'spotify'     => array(
				'label' => 'Spotify',
				'fa'    => 'fab fa-spotify',
			),
			'squarespace' => array(
				'label' => 'Squarespace',
				'fa'    => 'fab fa-squarespace',
			),
			'stumbleupon' => array(
				'label' => 'Stumbleupon',
				'fa'    => 'fab fa-stumbleupon',
			),
			'telegram'    => array(
				'label' => 'Telegram',
				'fa'    => 'fab fa-telegram-plane',
			),
			'tumblr'      => array(
				'label' => 'Tumblr',
				'fa'    => 'fab fa-tumblr',
			),
			'twitch'      => array(
				'label' => 'Twitch',
				'fa'    => 'fab fa-twitch',
			),
			'twitter'     => array(
				'label' => 'Twitter',
				'fa'    => 'fab fa-twitter',
			),
			'vimeo'       => array(
				'label' => 'Vimeo',
				'fa'    => 'fab fa-vimeo-v',
			),
			'wordpress'   => array(
				'label' => 'WordPress',
				'fa'    => 'fab fa-wordpress',
			),
			'youtube'     => array(
				'label' => 'YouTube',
				'fa'    => 'fab fa-youtube',
			),
		);
		return $social_networks;
	}

	/**
	 * Create comments table
	 *
	 * @since 1.0.0
	 * @access private
	 * @return void
	 */
	private function create_table() {
		global $wpdb;
		$tablename = $wpdb->prefix . 'upp_social_networks';

		$version = get_option( 'upp_enhanced_table_version', '0' );
		if ( version_compare( $version, USER_PROFILE_PICTURE_ENHANCED_TABLE_VERSION ) < 0 ) {
			$charset_collate = '';
			if ( ! empty( $wpdb->charset ) ) {
				$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
			}
			if ( ! empty( $wpdb->collate ) ) {
				$charset_collate .= " COLLATE $wpdb->collate";
			}
			$sql = "CREATE TABLE {$tablename} (
							id BIGINT(20) NOT NULL AUTO_INCREMENT,
							user_id BIGINT(20) NOT NULL DEFAULT 0,
							slug text NOT NULL,
							label text NOT NULL,
							icon text NOT NULL,
							url text NOT NULL,
							date DATETIME NOT NULL,
							item_order BIGINT(20) NOT NULL DEFAULT 0,
							PRIMARY KEY  (id)
							) {$charset_collate};";
			require_once ABSPATH . 'wp-admin/includes/upgrade.php';
			dbDelta( $sql );

			update_option( 'upp_enhanced_table_version', USER_PROFILE_PICTURE_ENHANCED_TABLE_VERSION );
		}
	}

	/**
	 * Drop comments table
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
	public function drop() {
		global $wpdb;
		$tablename = $wpdb->prefix . 'upp_social_networks';
		$sql       = "drop table if exists $tablename";
		$wpdb->query( $sql ); // phpcs:ignore
		delete_option( 'upp_enhanced_table_version' );
	}
}
