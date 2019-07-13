<?php
/**
 * Class UPP_Enhanced
 *
 * @package User_Profile_Picture_Enhanced
 */

/**
 * Sample test case.
 */
class UPP_Enhanced_Rest extends WP_UnitTestCase {

	/**
	 * Test REST Server
	 *
	 * @var WP_REST_Server
	 */
	protected $server;

	protected $namespaced_route = 'User_Profile_Picture_Enhanced\Rest';

	public function setUp() {
		parent::setUp();
		/** @var WP_REST_Server $wp_rest_server */
		global $wp_rest_server;
		$this->server = $wp_rest_server = new \WP_REST_Server;
		do_action( 'rest_api_init' );

	}

	/**
	 * A test for getting the social networks for a user.
	 */
	public function test_get_social_networks() {
		// Test social network results

		$this->assertEquals( array(), uppe_get_social_networks( 0, 'raw' ) );
		$this->assertEquals( '', uppe_get_social_networks( 0, 'output' ) );
	}

}
