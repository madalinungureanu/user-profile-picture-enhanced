<?php
/**
 * Add options to UPP and its defaults
 *
 * @package   User_Profile_Picture_Enhanced
 */

namespace User_Profile_Picture_Enhanced\Frontend;

/**
 * Class Admin
 */
class Output_Author_Box {
	/**
	 * Initialize the Admin component.
	 */
	public function init() {

	}

	/**
	 * Register any hooks that this component needs.
	 */
	public function register_hooks() {
		add_action( 'the_content', array( $this, 'maybe_add_author_box' ) );
	}

	/**
	 * Override the content and place author box on the bottom
	 *
	 * @param string $content The content to override.
	 *
	 * @return string $content New content with author box attached.
	 */
	public function maybe_add_author_box( $content ) {
		global $post;
		global $mt_pp;
		$options = $mt_pp->get_options();
		if ( is_single() || is_singular() ) {
			$post_type = $post->post_type;
			if ( isset( $options[ $post_type ] ) ) {
				if ( 'none' !== $options[ $post_type ] ) {
					$post_id          = $options[ $post_type ];
					$author_box_query = new \WP_Query ( // phpcs:ignore
						array(
							'post_status' => 'publish',
							'p'           => $post_id,
							'post_type'   => 'uppe_author_box',

						)
					);
					ob_start();
					while ( $author_box_query->have_posts() ) {
						$author_box_query->the_post();
						the_content();
					}
					wp_reset_postdata();
					$content .= ob_get_clean();
				}
			}
		}
		return $content;
	}

}
