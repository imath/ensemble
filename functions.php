<?php
/**
 * Ensemble functions and definitions
 *
 * @package /ensemble
 *
 * @since  1.0.0
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
