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
class Author_Box_Two {

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
			'mpp/user-profile-picture-enhanced-author-box-2',
			array(
				'attributes'      => array(
					'defaultImg'              => array(
						'type'    => 'string',
						'default' => \Metronet_Profile_Picture::get_plugin_url( '/img/mystery.png' ),
					),
					'aboutHeading'            => array(
						'type'    => 'string',
						'default' => __( 'Connect with the Author', 'user-profile-picture-enhanced' ),
					),
					'aboutHeadingColor'       => array(
						'type'    => 'string',
						'default' => '#000000',
					),
					'aboutHeadingFontSize'    => array(
						'type'    => 'int',
						'default' => 18,
					),
					'aboutHeadingColor'       => array(
						'type'    => 'string',
						'default' => '#000000',
					),
					'aboutHeadingFontSize'    => array(
						'type'    => 'int',
						'default' => 18,
					),
					'titleHeadingColor'       => array(
						'type'    => 'string',
						'default' => '#000000',
					),
					'titleHeadingFontSize'    => array(
						'type'    => 'int',
						'default' => 32,
					),
					'postListHeadingColor'    => array(
						'type'    => 'string',
						'default' => '#000000',
					),
					'postListHeadingFontSize' => array(
						'type'    => 'int',
						'default' => 32,
					),
					'avatarShape'             => array(
						'type'    => 'string',
						'default' => 'round',
					),
					'theme'                   => array(
						'type'    => 'string',
						'default' => 'none',
					),
					'textColor'               => array(
						'type'    => 'string',
						'default' => '#000000',
					),
					'backgroundColor'         => array(
						'type'    => 'string',
						'default' => '#FFFFFF',
					),
					'padding'                 => array(
						'type'    => 'int',
						'default' => 0,
					),
					'border'                  => array(
						'type'    => 'int',
						'default' => 0,
					),
					'borderColor'             => array(
						'type'    => 'string',
						'default' => '#000000',
					),
					'borderRadius'            => array(
						'type'    => 'int',
						'default' => 0,
					),
					'showSocial'              => array(
						'type'    => 'boolean',
						'default' => true,
					),
					'showTitle'               => array(
						'type'    => 'boolean',
						'default' => true,
					),
					'showBio'                 => array(
						'type'    => 'boolean',
						'default' => true,
					),
					'showPosts'               => array(
						'type'    => 'boolean',
						'default' => true,
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

		ob_start();
		// Check for co-authors plus multi-authors.
		$post_id = get_queried_object_id();
		$terms   = get_terms(
			'author',
			array(
				'hide_empty' => false,
				'object_ids' => $post_id,
			)
		);
		if ( ! empty( $terms && ! is_wp_error( $terms ) ) ) {
			foreach ( $terms as $term ) {
				$user = get_user_by( 'slug', $term->name );
				if ( $user ) {
					$this->get_author_box_html( $attributes, $user->ID );
				}
			}
		} else {
			$this->get_author_box_html( $attributes );
		}
		return ob_get_clean();
	}

	/**
	 * Get HTML output for the author box.
	 *
	 * @param array $attributes The block attributes.
	 * @param int   $user_id    The user ID to retrieve the profile for.
	 */
	private function get_author_box_html( $attributes, $user_id = 0 ) {
		global $mt_pp;
		$options = $mt_pp->get_options();
		global $post;
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
		$text_color              = $attributes['textColor'];
		$show_title              = filter_var( $attributes['showTitle'], FILTER_VALIDATE_BOOLEAN );
		$show_bio                = filter_var( $attributes['showBio'], FILTER_VALIDATE_BOOLEAN );
		$show_social             = filter_var( $attributes['showSocial'], FILTER_VALIDATE_BOOLEAN );
		$show_posts              = filter_var( $attributes['showPosts'], FILTER_VALIDATE_BOOLEAN );
		$post_list_heading_color = $attributes['postListHeadingColor'];
		$post_list_font_size     = $attributes['postListHeadingFontSize'];

		global $wp_query;
		$user_id = 0 !== $user_id ? $user_id : $wp_query->queried_object->post_author;
		?>
		<div
			class="upp-enhanced-author-box-two <?php echo esc_attr( $avatar_shape ); ?> <?php echo esc_attr( $theme ); ?>"
			style="background-color: <?php echo esc_attr( $background_color ); ?>; padding: <?php echo absint( $padding ); ?>px; border: <?php echo absint( $border ); ?>px solid <?php echo esc_attr( $border_color ); ?>; border-radius: <?php echo absint( $border_radius ); ?>px;"
		>
		<div class="column-meta">
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
				if ( $results && ! empty( $results ) && $show_social ) :
					?>
					<span class="icons upp-enhanced-social-networks brand">
						<?php
						foreach ( $results as $result ) {
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
		</div>
		<div class="author-picture" style="color: <?php echo esc_attr( $text_color ); ?>;">
				<?php
				$profile_img = mt_profile_img(
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
			if ( $title && ! empty( $title ) && $show_title ) {
				?>
				<div class="author-title" style="color: <?php echo esc_attr( $title_heading_color ); ?>; font-size: <?php echo esc_attr( $title_heading_font_size ); ?>px;">
					<?php echo esc_html( $title ); ?>
				</div>
				<?php
			}
			$biography = get_user_meta( $user_id, 'description', true );
			if ( $biography && ! empty( $biography ) && $show_bio ) :
				?>
				<div class="author-biography">
					<?php echo wp_kses_post( $biography ); ?>
				</div>
				<?php
			endif;
			?>
		<?php
		$args  = array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'author'         => $user_id,
			'orderby'        => 'date',
			'order'          => 'DESC',
			'posts_per_page' => 5,
		);
		$posts = get_posts( $args );
		if ( $show_posts && $posts ) {
			?>
			<div class="author-post-list">
				<div class="author-post-list-heading" style="color: <?php echo esc_html( $post_list_heading_color ); ?>; font-size: <?php echo absint( $post_list_font_size ); ?>px;">
					<?php echo esc_html__( 'Posts by ', 'user-profile-picture-enhanced' ); ?> <?php echo esc_html( $user->data->display_name ); ?>
				</div>
				<ul>
				<?php
				foreach ( $posts as $uppe_post ) {
					printf( "<li><a href='%s'>%s</a></li>", esc_url( get_permalink( $uppe_post->ID ) ), esc_html( $uppe_post->post_title ) );
				}
				?>
				</ul>
			</div>
			<?php
		}
		if ( is_user_logged_in() && current_user_can( 'manage_options' ) ) {
			?>
			<a href="<?php echo esc_url( admin_url( "post.php?post={$post->ID}&action=edit" ) ); ?>"><?php echo esc_html__( 'Edit Author Box', 'user-profile-picture-enhanced' ); ?></a>
			<?php
		}
		?>
		</div>
		<?php
	}
}
