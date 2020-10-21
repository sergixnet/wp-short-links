<?php
/**
 * Short Links Redirect
 *
 * Handle redirections for the shor link.
 *
 * @package    Short Links
 */

defined( 'ABSPATH' ) || exit;

add_action( 'template_redirect', 'sl_handle_redirects' );

/**
 * Handle redirects
 */
function sl_handle_redirects() {

	$post = get_post();

	if ( $post && 'shortlink' === $post->post_type ) {
		$target_url = get_post_meta( $post->ID, 'shortlink_target_url', true );
		$hits       = get_post_meta( $post->ID, 'shortlink_hits', true );

		update_post_meta( $post->ID, 'shortlink_hits', $hits + 1 );

		wp_redirect( $target_url );
		exit();
	}
}
