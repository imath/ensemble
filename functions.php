<?php
/**
 * Ensemble functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package /ensemble
 *
 * @since 1.0.0
 */

if ( ! function_exists( 'ensemble_setup' ) ) {
	/**
	 * Set-up Ensemble theme support.
	 *
	 * @since 1.0.0
	 */
	function ensemble_setup() {
		add_theme_support( 'wp-block-styles' );
	}
}
add_action( 'after_setup_theme', 'ensemble_setup' );

/**
 * Enqueue the style.css file.
 *
 * @since 1.0.0
 */
function ensemble_enqueue_styles() {
	wp_enqueue_style(
		'ensemble',
		get_stylesheet_uri(),
		array(),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'ensemble_enqueue_styles' );
