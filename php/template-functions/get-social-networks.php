<?php
/**
 * Template function for retrieving social media icons for a user.
 *
 * @package   User_Profile_Picture_Enhanced
 */

/**
 * Get a list of social networks for the user
 *
 * @param int    $user_id The User ID to retrieve the social networks for.
 * @param string $context The context for the user output. Context can be raw or output.
 *
 * @return mixed Array or string depending on the context.
 */
function uppe_get_social_networks( $user_id, $context = 'output' ) {

	// Make sure user is sanitized.
	$user_id = absint( $user_id );

	// Get social networks for user.
	global $wpdb;
	$tablename = $wpdb->prefix . 'upp_social_networks';
	$results = $wpdb->get_results( $wpdb->prepare( "select * from {$tablename} where user_id = %d ORDER BY item_order ASC", $user_id ) ); // phpcs:ignore

	if ( 'raw' === $context ) {
		return $results;
	} else {
		$html = '';
		if ( empty( $results ) ) {
			return $html;
		}
		$html = '<ul>';
		foreach ( $results as $result ) {
			$html .= sprintf(
				'<li><a href="%s" aria-label="%s" title="%s"><i class="%s"></i></a></li>',
				esc_url( $result->url ),
				esc_html( $result->label ),
				esc_html( $result->label ),
				esc_attr( $result->icon )
			);
		}
		$html .= '</ul>';
		return $html;
	}
	return '';
}
