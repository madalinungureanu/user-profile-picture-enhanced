<?php
/**
 * Add Author Box to UPP.
 *
 * @package   User_Profile_Picture_Enhanced
 */

namespace User_Profile_Picture_Enhanced\Blocks;

/**
 * Class Admin
 */
class Author_Box {

	/**
	 * Initialize the Admin component.
	 */
	public function init() {
	}

	/**
	 * Register any hooks that this component needs.
	 */
	public function register_hooks() {
		add_action( 'init', array( $this, 'register_block' ) );
	}

	/**
	 * Registers an Avatar Block.
	 */
	public function register_block() {
		if ( ! function_exists( 'register_block_type' ) ) {
			return;
		}
		register_block_type(
			'mpp/user-profile-picture-enhanced-author-box',
			array(
				'attributes'      => array(
					'defaultImg'       => array(
						'type'    => 'string',
						'default' => \Metronet_Profile_Picture::get_plugin_url( '/img/mystery.png' ),
					),
					'aboutHeading'   => array(
						'type'    => 'string',
						'default' => __( 'Connect with the Author', 'user-profile-picture-enhanced' ),
					),
					'aboutHeadingColor' => array(
						'type'    => 'string',
						'default' => '#000000',
					),
					'aboutHeadingFontSize' => array(
						'type'    => 'int',
						'default' => 18,
					),
					'aboutHeadingColor' => array(
						'type'    => 'string',
						'default' => '#000000',
					),
					'aboutHeadingFontSize' => array(
						'type'    => 'int',
						'default' => 18,
					),
					'titleHeadingColor' => array(
						'type'    => 'string',
						'default' => '#000000',
					),
					'titleHeadingFontSize' => array(
						'type'    => 'int',
						'default' => 32,
					),
					'avatarShape'          => array(
						'type'    => 'string',
						'default' => 'round',
					),
					'theme'          => array(
						'type'    => 'string',
						'default' => 'none',
					),
					'backgroundColor' => array(
						'type'    => 'string',
						'default' => '#FFFFFF',
					),
					'padding'         => array(
						'type'    => 'int',
						'default' => 0,
					),
					'border'          => array(
						'type'    => 'int',
						'default' => 0,
					),
					'borderColor'     => array(
						'type'    => 'string',
						'default' => '#000000',
					),
					'borderRadius'    => array(
						'type'    => 'int',
						'default' => 0,
					),
				),
				'render_callback' => array( $this, 'frontend' ),
			)
		);
	}

	/**
	 * Outputs the block content on the front-end
	 *
	 * @param array $attributes Array of attributes.
	 */
	public function frontend( $attributes ) {
		global $mt_pp;
		$options = $mt_pp->get_options();
		if ( is_admin() ) {
			return;
		}
		$about_heading           = $attributes['aboutHeading'];
		$theme                   = $attributes['theme'];
		$about_heading_color     = $attributes['aboutHeadingColor'];
		$about_heading_font_size = $attributes['aboutHeadingFontSize'];
		$title_heading_color     = $attributes['titleHeadingColor'];
		$title_heading_font_size = $attributes['titleHeadingFontSize'];
		$default_image           = $attributes['defaultImg'];
		$border_radius           = $attributes['borderRadius'];
		$border                  = $attributes['border'];
		$border_color            = $attributes['borderColor'];
		$padding                 = $attributes['padding'];
		$avatar_shape            = $attributes['avatarShape'];
		$background_color        = $attributes['backgroundColor'];

		ob_start();
		?>
		<div
			class="upp-enhanced-author-box <?php echo esc_attr( $avatar_shape ); ?> <?php echo esc_attr( $theme ); ?>"
			style="background-color: <?php echo esc_attr( $background_color ); ?>; padding: <?php echo absint( $padding ); ?>px; border: <?php echo absint( $border ); ?>px solid <?php echo esc_attr( $border_color ); ?>; border-radius: <?php echo absint( $border_radius ); ?>px;"
		>
		<div class="author-picture">
				<?php
				global $post;
				global $wp_query;
				// Get profile data.
				$profile_type = ( empty( get_query_var( 'post_type' ) || 'NULL' === get_query_var( 'post_type' ) ) ? 'post' : get_query_var( 'post_type' ) );
				$post_id      = $options[ $profile_type  ];
				$user_id      = $wp_query->queried_object->post_author;
				$profile_img  = mt_profile_img(
					$user_id,
					array(
						'echo' => false,
						'size' => array( '75', '75' ),
					)
				);
				if ( $profile_img ) {
					echo $profile_img; // phpcs:ignore
				} else {
					?>
					<img src="<?php echo esc_url( $default_image ); ?>" width="75" height="75" />
					<?php
				}
				?>
			</div>
			<?php
			$title = get_user_meta( $user_id, 'uppe_title', true ); // phpcs:ignore
			if ( $title && ! empty( $title ) ) {
				?>
				<div class="author-title" style="color: <?php echo esc_attr( $title_heading_color ); ?>; font-size: <?php echo esc_attr( $title_heading_font_size ); ?>px;">
					<?php echo esc_html( $title ); ?>
				</div>
				<?php
			}
			$biography = get_user_meta( $user_id, 'description', true );
			if ( $biography && ! empty( $biography ) ) :
				?>
				<div class="author-biography">
					<?php echo wp_kses_post( $biography ); ?>
				</div>
				<?php
			endif;
			?>
		<div class="column-meta">
			<div class="author-heading">
				<h2 class="upp-enhanced-author-box-title" style="color: <?php echo esc_attr( $about_heading_color ); ?>; font-size: <?php echo esc_attr( $about_heading_font_size ); ?>px;"><?php echo esc_html( $about_heading ); ?></h2>
			</div>
			<div class="author-name">
				<?php
				$user_post  = get_posts(
					array(
						'post_status' => 'publish',
						'post_type'   => 'mt_pp',
						'author'      => $user_id,
					)
				);
				$user_post  = current( $user_post );
				$user       = get_user_by( 'id', $user_post->post_author );
				$maybe_href = $user->user_url;
				if ( ! $maybe_href || empty( $maybe_href ) ) {
					$maybe_href = get_permalink( $user_post->ID );
				}
				?>
				<a href="<?php echo esc_url( $maybe_href ); ?>"><?php echo ( isset( $user_post->post_title ) ? esc_html( $user_post->post_title ) : '' ); ?></a>
				<?php
				global $wpdb;
				$tablename = $wpdb->prefix . 'upp_social_networks';
				$results   = $wpdb->get_results( // phpcs:ignore
					$wpdb->prepare(
						"select * from {$tablename} WHERE user_id = %d ORDER BY item_order ASC", // phpcs:ignore
						$user_id
					)
				);
				if ( $results && ! empty( $results ) ) :
					?>
					<span class="icons upp-enhanced-social-networks brand">
						<?php
						foreach( $results as $result ) {
							printf(
								'<a href="%s"><i class="%s"></i></a>',
								esc_url( $result->url ),
								esc_attr( $result->icon )
							);
						}
						?>
					</span>
					<?php
				endif;
				?>
			</div>
			<?php
			if ( is_user_logged_in() && current_user_can( 'manage_options' ) ) {
				?>
				<a href="<?php echo esc_url( admin_url( "post.php?post={$post->ID}&action=edit" ) ); ?>"><?php echo esc_html__( 'Edit Author Box', 'user-profile-picture-enhanced' ); ?></a>
				<?php
			}
			?>
		</div>
		<?php
		return ob_get_clean();
	}
}
