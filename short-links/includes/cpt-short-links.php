<?php
/**
 * Short Links CPT
 *
 * Create a custom post type for short links.
 *
 * @package    Short Links
 */

defined( 'ABSPATH' ) || exit;

add_action( 'init', 'sl_cpt_shortlink' );
/**
 * Register Post Type POST Short Links
 *
 * @return void
 **/
function sl_cpt_shortlink() {
	$labels = array(
		'name'               => __( 'Short Links', 'short-links' ),
		'singular_name'      => __( 'Short Link', 'short-links' ),
		'add_new'            => __( 'Add New Short Link', 'short-links' ),
		'add_new_item'       => __( 'Add New Short Link', 'short-links' ),
		'edit_item'          => __( 'Edit Short Link', 'short-links' ),
		'new_item'           => __( 'New Short Link', 'short-links' ),
		'view_item'          => __( 'View Short Link', 'short-links' ),
		'search_items'       => __( 'Search Short Links', 'short-links' ),
		'not_found'          => __( 'Not found Short Links', 'short-links' ),
		'not_found_in_trash' => __( 'Not found Short Links in trash', 'short-links' ),
	);
	$args   = array(
		'labels'             => $labels,
		'public'             => false,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_rest'       => true, // Adds gutenberg support.
		'query_var'          => true,
		'rewrite'            => array(
			'slug'       => 'sl',
			'with_front' => false,
		),
		'has_archive'        => false,
		'capability_type'    => 'post',
		'hierarchical'       => false,
		'menu_position'      => 5,
		'menu_icon'          => 'dashicons-admin-links', // https://developer.wordpress.org/resource/dashicons/.
		'supports'           => array( 'title' ),
	);
	register_post_type( 'shortlink', $args );
}
