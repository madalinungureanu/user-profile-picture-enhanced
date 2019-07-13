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

	protected $namespaced_route = '/mpp/v3';

	/**
	 * Set up the REST server and init actions.
	 */
	public function setUp() {
		parent::setUp();
		/** @var WP_REST_Server $wp_rest_server */
		global $wp_rest_server;
		$this->server = $wp_rest_server = new \WP_REST_Server;
		do_action( 'rest_api_init' );
	}

	/**
	 * Test for route creation.
	 */
	public function test_register_routes() {
		$routes = $this->server->get_routes();
		$this->assertArrayHasKey( $this->namespaced_route, $routes );
	}

	/**
	 * Test for REST callbacks.
	 */
	public function test_endpoints() {
		$the_route = $this->namespaced_route;
		$routes = $this->server->get_routes();
		foreach( $routes as $route => $route_config ) {
			if( 0 === strpos( $the_route, $route ) ) {
				$this->assertTrue( is_array( $route_config ) );
				foreach( $route_config as $i => $endpoint ) {
					$this->assertArrayHasKey( 'callback', $endpoint );
					$this->assertArrayHasKey( 0, $endpoint[ 'callback' ], get_class( $this ) );
					$this->assertArrayHasKey( 1, $endpoint[ 'callback' ], get_class( $this ) );
					$this->assertTrue( is_callable( array( $endpoint[ 'callback' ][0], $endpoint[ 'callback' ][1] ) ) );
				}
			}
		}
	}
}
