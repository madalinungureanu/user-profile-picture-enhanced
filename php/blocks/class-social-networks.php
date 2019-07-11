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
			'mpp/user-profile-picture-enhanced-social-networks',
			array(
				'attributes'      => array(
					'icons'           => array(
						'type'    => 'array',
						'default' => array(),
						'items'   => [
							'type' => 'object',
						],
					),
					'iconSize'        => array(
						'type'    => 'int',
						'default' => 24,
					),
					'iconTheme'       => array(
						'type'    => 'string',
						'default' => 'brand',
					),
					'iconColor'       => array(
						'type'    => 'string',
						'default' => '#000000',
					),
					'iconOrientation' => array(
						'type'    => 'string',
						'default' => 'horizontal',
					),
					'align'           => array(
						'type'    => 'string',
						'default' => 'center',
					),
					'backgroundColor' => array(
						'type'    => 'string',
						'default' => '#0073a8',
					),
					'padding'         => array(
						'type'    => 'int',
						'default' => 20,
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
					'bgImg'           => array(
						'type'    => 'string',
						'default' => '',
					),
					'bgImgFill'       => array(
						'type'    => 'string',
						'default' => 'cover',
					),
					'bgImgOpacity'    => array(
						'type'    => 'string',
						'default' => '0.4',
					),
					'bgImgParallax'   => array(
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
		$icon_size        = $attributes['iconSize'];
		$icon_theme       = $attributes['iconTheme'];
		$icon_color       = $attributes['iconColor'];
		$icon_orientation = $attributes['iconOrientation'];
		$bg_img_parallax  = $attributes['bgImgParallax'];
		$bg_img_fill      = $attributes['bgImgFill'];
		$bg_img           = $attributes['bgImg'];
		$border_radius    = $attributes['borderRadius'];
		$border           = $attributes['border'];
		$border_color     = $attributes['borderColor'];
		$padding          = $attributes['padding'];
		$background_color = $attributes['backgroundColor'];

		global $post;
		$user_id = absint( $post->post_author );

		ob_start();
		?>
		<style>
			.upp-enhanced-social-networks .fab:before,
			.upp-enhanced-social-networks .fas:before {
				font-size: <?php echo esc_attr( $icon_size ); ?>px;
			}
			<?php
			if ( 'custom' === $icon_theme ) :
				?>
				.upp-enhanced-social-networks.custom .fas:before,
				.upp-enhanced-social-networks.custom .fab:before {
					color: <?php echo esc_attr( $icon_color ); ?>;
				}
				<?php
			endif;
			?>
		</style>
		<div
			class="upp-enhanced-social-networks <?php echo esc_attr( $icon_theme ); ?> <?php echo esc_attr( $icon_orientation ); ?> align<?php echo esc_attr( $align ); ?>"
			style="background-color: <?php echo esc_attr( $background_color ); ?>; padding: <?php echo absint( $padding ); ?>px; border: <?php echo absint( $border ); ?>px solid <?php echo esc_attr( $border_color ); ?>; border-radius: <?php echo absint( $border_radius ); ?>px; <?php echo ( ! empty( $bg_img ) ) ? sprintf( 'background-image: url(%s);', esc_url( $bg_img ) ) : ''; ?> background-size: <?php echo esc_attr( $bg_img_fill ); ?>; background-attachment: <?php echo $bg_img_parallax ? 'fixed' : 'inherit'; ?>"
		>
		<?php
		global $wpdb;
		$tablename = $wpdb->prefix . 'upp_social_networks';
		$results = $wpdb->get_results( $wpdb->prepare( "select * from {$tablename} where user_id = %d ORDER BY item_order ASC", $user_id ) ); // phpcs:ignore
		echo '<ul>';
		foreach ( $results as $result ) {
			?>
			<li>
				<a href="<?php echo esc_url( $result->url ); ?>" title="<?php echo esc_attr( $result->label ); ?>" aria-label="<?php echo esc_attr( $result->label ); ?>">
					<i class="<?php echo esc_attr( $result->icon ); ?>"></i>
				</a>
			</li>
			<?php
		}
		echo '</ul>';
		?>
		</div>
		<?php
		return ob_get_clean();
	}
}
