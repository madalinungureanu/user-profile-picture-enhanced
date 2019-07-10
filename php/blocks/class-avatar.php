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
class Avatar {

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
			'mpp/user-profile-picture-enhanced-avatar',
			array(
				'attributes'      => array(
					'imageSize' => array(
						'type'    => 'string',
						'default' => 'profile_300',
					),
					'imgUrl'    => array(
						'type'    => 'string',
						'default' => '',
					),
					'alt'       => array(
						'type'    => 'string',
						'default' => '',
					),
					'width'     => array(
						'type'    => 'integer',
						'default' => 300,
					),
					'height'    => array(
						'type'    => 'integer',
						'default' => 300,
					),
					'html'      => array(
						'type'    => 'string',
						'default' => '',
					),
					'backgroundColor' => array(
						'type'    => 'string',
						'default' => 'inherit',
					),
					'avatarShape'     => array(
						'type'    => 'string',
						'default' => 'square',
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
		$html  = '<div class=aligncenter">';
		$html .= $attributes['html'];
		$html .= '</div>';
		return $html;
	}
}
