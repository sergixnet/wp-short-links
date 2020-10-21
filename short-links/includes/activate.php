<?php
/**
 * Plugin activation
 *
 * Register pugin activation hook and generate sample shortlinks.
 *
 * @package    Short Links
 */

defined( 'ABSPATH' ) || exit;

register_activation_hook( SL_MAIN_FILE, 'sl_plugin_activate' );
/**
 * Generate sample shortlinks when activating the plugin.
 */
function sl_plugin_activate() {
	$query = new WP_Query( array( 'post_type' => 'shortlink' ) );

	if ( $query->have_posts() ) {
		return;
	}

	global $short_links;
	foreach ( $short_links as $link ) {
		wp_insert_post( $link );
	}
}
