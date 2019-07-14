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
				$post_id     = $post->ID;
				$user_id     = $post->post_author;

				// Get profile data.
				$profile_post_id = absint( get_user_option( 'metronet_post_id', $user_id ) );
				$profile_post    = get_post( $profile_post_id );
				$profile_img     = mt_profile_img(
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
				<a href="#"><?php echo ( isset( $profile_post->post_title ) ? esc_html( $profile_post->post_title ) : ''); ?></a>
				<span class="icons upp-enhanced-social-networks brand">
					<a href="#"><i class="fab fa-facebook-f"></i></a>
					<a href="#"><i class="fab fa-twitter"></i></a>
					<a href="#"><i class="fab fa-instagram"></i></a>
					<a href="#"><i class="fab fa-linkedin"></i></a>
					<a href="#"><i class="fab fa-pinterest"></i></a>
					<a href="#"><i class="fab fa-medium"></i></a>
					<a href="#"><i class="fab fa-wordpress"></i></a>
				</span>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}
