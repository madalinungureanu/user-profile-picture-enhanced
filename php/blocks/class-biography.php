<?php
/**
 * Add options to UPP and its defaults
 *
 * @package   User_Profile_Picture_Enhanced
 */

namespace User_Profile_Picture_Enhanced\Blocks;

/**
 * Class Admin
 */
class Biography {

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
			'mpp/user-profile-picture-enhanced-biography',
			array(
				'attributes'      => array(
					'align'            => array(
						'type'    => 'string',
						'default' => 'center',
					),
					'biography'        => array(
						'type'    => 'string',
						'default' => '',
					),
					'biographyHeading' => array(
						'type'    => 'string',
						'default' => '',
					),
					'backgroundColor'  => array(
						'type'    => 'string',
						'default' => '#ffffff',
					),
					'padding'          => array(
						'type'    => 'int',
						'default' => 20,
					),
					'border'           => array(
						'type'    => 'int',
						'default' => 0,
					),
					'borderColor'      => array(
						'type'    => 'string',
						'default' => '#000000',
					),
					'borderRadius'     => array(
						'type'    => 'int',
						'default' => 0,
					),
					'headingColor'     => array(
						'type'    => 'string',
						'default' => '#000000',
					),
					'headingFontSize'  => array(
						'type'    => 'int',
						'default' => '32',
					),
					'biographyColor'   => array(
						'type'    => 'string',
						'default' => '#000000',
					),
					'bgImg'            => array(
						'type'    => 'string',
						'default' => '',
					),
					'bgImgFill'        => array(
						'type'    => 'string',
						'default' => 'cover',
					),
					'bgImgOpacity'     => array(
						'type'    => 'string',
						'default' => '0.4',
					),
					'bgImgParallax'    => array(
						'type'    => 'boolean',
						'default' => false,
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
		// Loading Attributes.
		$align = 'center';
		if ( isset( $attributes['align'] ) ) {
			$align = $attributes['align'];
		}
		$biography         = $attributes['biography'];
		$biography_heading = $attributes['biographyHeading'];
		$bg_img_parallax   = $attributes['bgImgParallax'];
		$bg_img_fill       = $attributes['bgImgFill'];
		$bg_img            = $attributes['bgImg'];
		$heading_font_size = $attributes['headingFontSize'];
		$heading_color     = $attributes['headingColor'];
		$biography_color   = $attributes['biographyColor'];
		$border_radius     = $attributes['borderRadius'];
		$border            = $attributes['border'];
		$border_color      = $attributes['borderColor'];
		$padding           = $attributes['padding'];
		$background_color  = $attributes['backgroundColor'];

		ob_start();
		?>
		<div
			class="upp-enhanced-biography align<?php echo esc_attr( $align ); ?>"
			style="background-color: <?php echo esc_attr( $background_color ); ?>; padding: <?php echo absint( $padding ); ?>px; border: <?php echo absint( $border ); ?>px solid <?php echo esc_attr( $border_color ); ?>; border-radius: <?php echo absint( $border_radius ); ?>px; <?php echo ( ! empty( $bg_img ) ) ? sprintf( 'background-image: url(%s);', esc_url( $bg_img ) ) : ''; ?> background-size: <?php echo esc_attr( $bg_img_fill ); ?>; background-attachment: <?php echo $bg_img_parallax ? 'fixed' : 'inherit'; ?>"
		>
			<h2
				class="upp-enhanced-biography-heading"
				style="color: <?php echo esc_attr( $heading_color ); ?>; font-size: <?php echo esc_attr( $heading_font_size ); ?>px;"
			>
				<?php echo wp_kses_post( $biography_heading ); ?>
			</h2>
			<div
				style="color: <?php echo esc_attr( $biography_color ); ?>;"
			>
				<?php echo wp_kses_post( $biography ); ?>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}
