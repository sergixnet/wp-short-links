<?php
/**
 * Register Metadata
 *
 * Register Metadata for the short links.
 *
 * @package    Short Links
 */

defined( 'ABSPATH' ) || exit;

add_action( 'init', 'sl_shortlinks_register_meta' );
/**
 * Register Metadata for the short links.
 *
 * @return void
 **/
function sl_shortlinks_register_meta() {

	register_post_meta(
		'shortlink',
		'shortlink_target_url',
		array(
			'single'            => true,
			'show_in_rest'      => true,
			'sanitize_callback' => function ( $value ) {
				return wp_strip_all_tags( $value );
			},
		)
	);

	register_post_meta(
		'shortlink',
		'shortlink_hits',
		array(
			'single'            => true,
			'show_in_rest'      => true,
			'type'              => 'integer',
			'default'           => 0,
			'sanitize_callback' => function ( $value ) {
				return wp_strip_all_tags( $value );
			},
		)
	);
}
