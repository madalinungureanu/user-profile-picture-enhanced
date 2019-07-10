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
					'imageSize'       => array(
						'type'    => 'string',
						'default' => 'profile_300',
					),
					'imgUrl'          => array(
						'type'    => 'string',
						'default' => '',
					),
					'align'           => array(
						'type'    => 'string',
						'default' => 'center',
					),
					'alt'             => array(
						'type'    => 'string',
						'default' => '',
					),
					'width'           => array(
						'type'    => 'integer',
						'default' => 300,
					),
					'height'          => array(
						'type'    => 'integer',
						'default' => 300,
					),
					'html'            => array(
						'type'    => 'string',
						'default' => '',
					),
					'backgroundColor' => array(
						'type'    => 'string',
						'default' => '#0073a8',
					),
					'avatarShape'     => array(
						'type'    => 'string',
						'default' => 'square',
					),
					'padding'         => array(
						'type'    => 'int',
						'default' => 20,
					),
					'imgBorder'       => array(
						'type'    => 'int',
						'default' => 0,
					),
					'imgBorderColor'  => array(
						'type'    => 'string',
						'default' => '#FFFFFF',
					),
					'imgPadding'      => array(
						'type'    => 'int',
						'default' => 0,
					),
					'imgBgColor'      => array(
						'type'    => 'string',
						'default' => 'inherit',
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
					'caption'         => array(
						'type'    => 'string',
						'default' => '',
					),
					'captionColor'    => array(
						'type'    => 'string',
						'default' => '#000000',
					),
					'captionFontSize' => array(
						'type'    => 'int',
						'default' => '32',
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
		$html  = '<div class=aligncenter">';
		$html .= $attributes['html'];
		$html .= '</div>';
		return $html;
	}
}
