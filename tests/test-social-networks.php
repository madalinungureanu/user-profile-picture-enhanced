<?php
/**
 * Class UPP_Enhanced
 *
 * @package User_Profile_Picture_Enhanced
 */

/**
 * Sample test case.
 */
class UPP_Enhanced_Social_Networks extends WP_UnitTestCase {

	/**
	 * A test for getting the social networks for a user.
	 */
	public function test_get_social_networks() {
		// Test social network results

		$this->assertEquals( array(), uppe_get_social_networks( 0, 'raw' ) );
		$this->assertEquals( '', uppe_get_social_networks( 0, 'output' ) );
	}
}
