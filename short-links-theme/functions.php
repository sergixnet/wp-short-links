<?php
/**
 * Functions
 *
 * Theme functions main file.
 *
 * @package    Short Link Theme
 * @author     Sergio Peña
 * @version    1.0
 */

defined( 'ABSPATH' ) || exit;

add_action( 'wp_enqueue_scripts', 'sl_add_theme_scripts' );

/**
 * Register scripts and styles.
 */
function sl_add_theme_scripts() {

	wp_register_style( 'bulma', 'https://cdn.jsdelivr.net/npm/bulma@0.9.1/css/bulma.min.css', array(), '0.9.1' );
	wp_register_style( 'style', get_template_directory_uri() . '/style.css', array( 'bulma' ), '1.0' );

	wp_register_script( 'vue', 'https://cdn.jsdelivr.net/npm/vue@2.6.12', array(), '2.6.12', true );
	wp_register_script( 'mainjs', get_template_directory_uri() . '/assets/js/main.js', array( 'vue' ), '1.0', true );

	wp_enqueue_style( 'bulma' );
	wp_enqueue_style( 'style' );
	wp_enqueue_script( 'mainjs' );

}
