<?php
/**
 * API Routes
 *
 * Register new API routes to get shortlinks.
 *
 * @package    Short Links
 */

defined( 'ABSPATH' ) || exit;

// Register custom rest api routes.
add_action(
	'rest_api_init',
	function () {

		register_rest_route(
			'sl/v1',
			'shortlinks',
			array(
				'methods'  => 'GET',
				'callback' => 'sl_shortlinks_cb',
			)
		);

	}
);

/**
 * Return all the shortlinks in the API REST.
 */
function sl_shortlinks_cb() {

	$args = array(
		'numberposts' => -1,
		'post_type'   => 'shortlink',
	);

	$posts = get_posts( $args );

	$data = array();

	$i = 0;

	foreach ( $posts as $post ) {

		$data[ $i ]['id']         = $post->ID;
		$data[ $i ]['title']      = $post->post_title;
		$data[ $i ]['slug']       = $post->post_name;
		$data[ $i ]['date']       = $post->post_date;
		$data[ $i ]['permalink']  = get_post_permalink( $post->ID );
		$data[ $i ]['target_url'] = get_post_meta( $post->ID, 'shortlink_target_url', true );
		$data[ $i ]['hits']       = (int) get_post_meta( $post->ID, 'shortlink_hits', true );

		$i++;

	}

	return $data;

}
