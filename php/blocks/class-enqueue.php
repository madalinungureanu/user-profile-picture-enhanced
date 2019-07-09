<?php
/**
 * Enqueue necessary scripts and styles.
 *
 * @package   User_Profile_Picture_Enhanced
 */

namespace User_Profile_Picture_Enhanced\Blocks;

/**
 * Class Admin
 */
class Enqueue {

	/**
	 * Initialize the Admin component.
	 */
	public function init() {

	}

	/**
	 * Register any hooks that this component needs.
	 */
	public function register_hooks() {
		add_action( 'enqueue_block_assets', array( $this, 'frontend_css' ) );
		add_action( 'enqueue_block_editor_assets', array( $this, 'block_js' ) );
	}

	/**
	 * Enqueue the block JS.
	 */
	public function block_js() {
		// Scripts.
		wp_enqueue_script(
			'user-profile-picture-enhanced-js',
			USER_PROFILE_PICTURE_ENHANCED_URL . 'dist/blocks.build.js',
			array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ),
			USER_PROFILE_PICTURE_ENHANCED_VERSION,
			true
		);
		wp_localize_script(
			'user-profile-picture-enhanced-js',
			'upp_enhanced',
			array(
				'rest_url'   => get_rest_url(),
				'rest_nonce' => wp_create_nonce( 'wp_rest' ),
			)
		);

		wp_set_script_translations( 'user-profile-picture-enhanced-js', 'user-profile-picture-enhanced' );

		// Styles.
		wp_enqueue_style(
			'user-profile-picture-enhanced-editor', // Handle.
			USER_PROFILE_PICTURE_ENHANCED_URL . 'dist/blocks.editor.build.css',
			array( 'wp-edit-blocks' ),
			USER_PROFILE_PICTURE_ENHANCED_VERSION,
			'all'
		);
	}

	/**
	 * Enqueue the front-end CSS.
	 */
	public function frontend_css() {
		wp_enqueue_style(
			'user-profile-picture-enhanced-block-css', // Handle.
			USER_PROFILE_PICTURE_ENHANCED_URL . 'dist/blocks.style.build.css',
			array( 'wp-editor' ),
			USER_PROFILE_PICTURE_ENHANCED_VERSION,
			'all'
		);
	}
}
