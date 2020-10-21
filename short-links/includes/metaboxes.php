<?php
/**
 * Create metaboxes
 *
 * Create metaboxes for the shortlinks.
 *
 * @package    Short Links
 */

defined( 'ABSPATH' ) || exit;

add_action( 'admin_menu', 'sl_add_metabox' );

/**
 * Short link add metabox,
 */
function sl_add_metabox() {

	add_meta_box(
		'sl_metabox',
		__( 'Short Link Metabox', 'short-link' ),
		'sl_metabox_callback',
		'shortlink',
		'normal',
		'default'
	);
}

/**
 * Short link add metabox callback.
 *
 * @param object $post The current post.
 */
function sl_metabox_callback( $post ) {

	$slug         = $post->post_name;
	$target_url   = get_post_meta( $post->ID, 'shortlink_target_url', true );
	$hits         = get_post_meta( $post->ID, 'shortlink_hits', true );
	$example_link = get_site_url() . '/sl/' . ( $slug ? $slug : 'myslug' );

	wp_nonce_field( 'sl_nonce_field', '_slnonce' );

	echo '<table class="form-table">
		<tbody>
			<tr>
				<th><label for="slug">' . esc_html( __( 'Slug', 'short-links' ) ) . '</label></th>
				<td>
				<input type="text" id="slug" name="slug" value="' . esc_attr( $slug ) . '" class="regular-text" required>
				<p><em>' . esc_html( __( 'Add a slug for the short link', 'short-links' ) ) . '.</em></p>
				<p><em>' . esc_html( __( 'The short link will be like:', 'short-links' ) ) . ' ' . esc_html( $example_link ) . '</em></p>
				</td>
			</tr>
			<tr>
				<th><label for="shortlink_target_url">' . esc_html( __( 'Target URL', 'short-links' ) ) . '</label></th>
				<td>
				<input type="url" id="shortlink_target_url" name="shortlink_target_url" value="' . esc_attr( $target_url ) . '" class="regular-text" required>
				<p><em>' . esc_html( __( 'Add the URL to be redirected and shortened', 'short-links' ) ) . '.</em></p>
				</td>
			</tr>
			<tr>
				<th><label for="shortlink_hits">' . esc_html( __( 'Hits', 'short-links' ) ) . '</label></th>
				<td>
				<input type="number" id="shortlink_hits" name="shortlink_hits" value="' . esc_attr( $hits ) . '" class="regular-text" readonly>
				<p><em>' . esc_html( __( 'How many times this link was visited', 'short-links' ) ) . '.</em></p>
				</td>
			</tr>
		</tbody>
	</table>';

}

/**
 * Saving the Short Link post type
 */
add_action( 'save_post', 'sl_save_meta', 10, 2 );

/**
 * Saves metadata for the Short Link post type,
 *
 * @param integer $post_id The ID of the current post.
 * @param object  $post The current post.
 */
function sl_save_meta( $post_id, $post ) {

	if ( ! isset( $_POST['_slnonce'] ) || ! wp_verify_nonce( $_POST['_slnonce'], 'sl_nonce_field' ) ) {
		return $post_id;
	}

	$post_type = get_post_type_object( $post->post_type );

	if ( ! current_user_can( $post_type->cap->edit_post, $post_id ) ) {
		return $post_id;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return $post_id;
	}

	if ( 'shortlink' !== $post->post_type ) {
		return $post_id;
	}

	if ( isset( $_POST['slug'] ) ) {

		remove_action( 'save_post', 'sl_save_meta' );

		wp_update_post(
			array(
				'ID'        => $post_id,
				'post_name' => sanitize_text_field( $_POST['slug'] ),
			)
		);

		add_action( 'save_post', 'sl_save_meta', 10, 2 );
	}

	if ( isset( $_POST['shortlink_target_url'] ) ) {
		update_post_meta( $post_id, 'shortlink_target_url', sanitize_text_field( $_POST['shortlink_target_url'] ) );
	} else {
		delete_post_meta( $post_id, 'shortlink_target_url' );
	}

	if ( isset( $_POST['shortlink_hits'] ) ) {
		update_post_meta( $post_id, 'shortlink_hits', sanitize_text_field( $_POST['shortlink_hits'] ) );
	} else {
		delete_post_meta( $post_id, 'shortlink_hits' );
	}

	return $post_id;
}
