<?php
/**
 * Custom admin columns
 *
 * Create custom admin columns for the shortlink list pannel.
 *
 * @package    Short Links
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'manage_shortlink_posts_columns', 'sl_shortlink_columns' );

/**
 * Define columns in the shortlink list.
 *
 * @param array $columns Columns array.
 */
function sl_shortlink_columns( $columns ) {

	$columns = array(
		'cb'     => $columns['cb'],
		'title'  => __( 'Title', 'short-links' ),
		'url'    => __( 'URL', 'short-links' ),
		'target' => __( 'Target', 'short-links' ),
		'hits'   => __( 'Hits', 'short-links' ),
		'date'   => __( 'Date', 'short-links' ),
	);

	return $columns;
}


add_action( 'manage_shortlink_posts_custom_column', 'sl_shortlink_column', 10, 2 );

/**
 * Customize the columns.
 *
 * @param array $column The column.
 * @param int   $post_id The post ID.
 */
function sl_shortlink_column( $column, $post_id ) {

	// URL column.
	if ( 'url' === $column ) {
		$url = get_permalink( $post_id );
		echo '<a href="' . esc_attr( $url ) . '" target="_blank" rel="noopener noreferrer">' . esc_html( $url ) . '</a>';
	}

	// Target column.
	if ( 'target' === $column ) {
		$target = get_post_meta( $post_id, 'shortlink_target_url', true );
		echo '<a href="' . esc_attr( $target ) . '" target="_blank" rel="noopener noreferrer">' . esc_html( $target ) . '</a>';
	}

	// Hits column.
	if ( 'hits' === $column ) {
		$hits = get_post_meta( $post_id, 'shortlink_hits', true );
		echo esc_html( $hits );
	}
}

add_filter( 'manage_edit-shortlink_sortable_columns', 'sl_shortlink_sortable_columns' );

/**
 * Make hits column sortable.
 *
 * @param array $columns The columns.
 */
function sl_shortlink_sortable_columns( $columns ) {
	$columns['hits'] = 'shortlink_hits';
	return $columns;
}


add_action( 'pre_get_posts', 'sl_shortlink_orderby' );
/**
 * Sorting hits column.
 *
 * @param array $query The query to order the shortlinks.
 */
function sl_shortlink_orderby( $query ) {
	if ( ! is_admin() || ! $query->is_main_query() ) {
		return;
	}

	if ( 'shortlink_hits' === $query->get( 'orderby' ) ) {
		$query->set( 'orderby', 'meta_value_num' );
		$query->set( 'meta_key', 'shortlink_hits' );
	}
}



