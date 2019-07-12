<?php
/**
 * Add options to UPP and its defaults
 *
 * @package   User_Profile_Picture_Enhanced
 */

namespace User_Profile_Picture_Enhanced\Blocks;

/**
 * Class Recent_Posts
 */
class Recent_Posts {

	/**
	 * Initialize the Recent_Posts component.
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
			'mpp/user-profile-picture-enhanced-recent-posts',
			array(
				'attributes'      => array(
					'posts'           => array(
						'type'    => 'array',
						'default' => array(),
						'items'   => [
							'type' => 'object',
						],
					),
					'theme'           => array(
						'type'    => 'string',
						'default' => 'light',
					),
					'backgroundColor' => array(
						'type'    => 'string',
						'default' => '#FFFFFF',
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
		global $post;
		$user_id = $post->post_author;

		$args  = array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'author'         => $user_id,
			'orderby'        => 'date',
			'order'          => 'DESC',
			'posts_per_page' => 5,
		);
		$posts = get_posts( $args );
		if ( empty( $posts ) ) {
			return;
		}

		// Loading Attributes.
		$align = 'center';
		if ( isset( $attributes['align'] ) ) {
			$align = $attributes['align'];
		}
		$theme            = $attributes['theme'];
		$bg_img_parallax  = $attributes['bgImgParallax'];
		$bg_img_fill      = $attributes['bgImgFill'];
		$bg_img           = $attributes['bgImg'];
		$border_radius    = $attributes['borderRadius'];
		$border           = $attributes['border'];
		$border_color     = $attributes['borderColor'];
		$padding          = $attributes['padding'];
		$background_color = $attributes['backgroundColor'];

		ob_start();
		?>
		<div
			class="upp-enhanced-recent-posts <?php echo esc_attr( $theme ); ?> align<?php echo esc_attr( $align ); ?>"
			style="background-color: <?php echo esc_attr( $background_color ); ?>; padding: <?php echo absint( $padding ); ?>px; border: <?php echo absint( $border ); ?>px solid <?php echo esc_attr( $border_color ); ?>; border-radius: <?php echo absint( $border_radius ); ?>px; <?php echo ( ! empty( $bg_img ) ) ? sprintf( 'background-image: url(%s);', esc_url( $bg_img ) ) : ''; ?> background-size: <?php echo esc_attr( $bg_img_fill ); ?>; background-attachment: <?php echo $bg_img_parallax ? 'fixed' : 'inherit'; ?>"
		>
			<ul>
				<?php
				foreach ( $posts as $upp_post ) {
					printf(
						'<li><a href="%s">%s</a></li>',
						esc_url( get_permalink( $upp_post->ID ) ),
						esc_html( get_the_title( $upp_post->ID ) )
					);
				}
				?>
			</ul>
		</div>
		<?php
		return ob_get_clean();
	}
}
