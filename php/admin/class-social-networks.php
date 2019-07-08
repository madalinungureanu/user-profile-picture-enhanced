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
	}

	/**
	 * Add Social Networks Admin
	 */
	public function add_social_networks_to_profile_page() {
		?>
		<tr valign="top">
			<th scope="row"><?php esc_html_e( 'Social Networks', 'user-profile-picture-enhanced' ); ?></th>
			<td id="user-profile-picture-enhanced-social-networks">
				<?php
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
				'fa'    => 'fab fab fa-behance',
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
				'fa'    => 'fab fa-dribble',
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
}
