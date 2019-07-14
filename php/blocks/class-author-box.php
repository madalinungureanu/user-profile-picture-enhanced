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
						'default' => '#000000'
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
		if ( is_admin() ) {
			return;
		}

		return 'test';
		// Loading Attributes.
		$align = 'center';
		if ( isset( $attributes['align'] ) ) {
			$align = $attributes['align'];
		}
		$image_url         = $attributes['imgUrl'];
		$alt               = $attributes['alt'];
		$width             = $attributes['width'];
		$height            = $attributes['height'];
		$bg_img_parallax   = $attributes['bgImgParallax'];
		$bg_img_fill       = $attributes['bgImgFill'];
		$bg_img            = $attributes['bgImg'];
		$caption_font_size = $attributes['captionFontSize'];
		$caption_color     = $attributes['captionColor'];
		$caption           = $attributes['caption'];
		$border_radius     = $attributes['borderRadius'];
		$border            = $attributes['border'];
		$border_color      = $attributes['borderColor'];
		$img_bg_color      = $attributes['imgBgColor'];
		$img_padding       = $attributes['imgPadding'];
		$img_border_color  = $attributes['imgBorderColor'];
		$img_border        = $attributes['imgBorder'];
		$padding           = $attributes['padding'];
		$avatar_shape      = $attributes['avatarShape'];
		$background_color  = $attributes['backgroundColor'];

		ob_start();
		?>
		<div
			class="upp-enhanced-avatar <?php echo esc_attr( $avatar_shape ); ?> align<?php echo esc_attr( $align ); ?>"
			style="background-color: <?php echo esc_attr( $background_color ); ?>; padding: <?php echo absint( $padding ); ?>px; border: <?php echo absint( $border ); ?>px solid <?php echo esc_attr( $border_color ); ?>; border-radius: <?php echo absint( $border_radius ); ?>px; <?php echo ( ! empty( $bg_img ) ) ? sprintf( 'background-image: url(%s);', esc_url( $bg_img ) ) : ''; ?> background-size: <?php echo esc_attr( $bg_img_fill ); ?>; background-attachment: <?php echo $bg_img_parallax ? 'fixed' : 'inherit'; ?>"
		>
			<img
			src="<?php echo esc_attr( $image_url ); ?>"
			alt="<?php echo esc_attr( $alt ); ?>"
			width="<?php echo absint( $width ); ?>"
			height="<?php echo absint( $height ); ?>"
			style="background-color: <?php echo esc_attr( $img_bg_color ); ?>; border: <?php echo esc_attr( $img_border ); ?>px solid <?php echo esc_attr( $img_border_color ); ?>; padding: <?php echo esc_attr( $img_padding ); ?>px;"
			/>
			<?php
			if ( ! empty( $caption ) ) {
				?>
				<h2 class="upp-enhanced-avatar-caption" style="color: <?php echo esc_attr( $caption_color ); ?>; font-size: <?php echo esc_attr( $caption_font_size ); ?>px;">
					<?php echo wp_kses_post( $caption ); ?>
				</h2>
				<?php
			}
			?>
		</div>
		<?php
		return ob_get_clean();
	}
}
