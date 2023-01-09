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

		// Use specific thumbnail size.
		set_post_thumbnail_size( 800, 400, true );

		// Enqueue editor styles.
		add_editor_style( 'style.css' );
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

/**
 * Renders the `ensemble/image-a-la-une` block on the server.
 *
 * @since 1.0.0
 *
 * @param array    $attributes Block attributes.
 * @param string   $content    Block default content.
 * @param WP_Block $block      Block instance.
 * @return string Returns the featured image for the current post.
 */
function ensemble_render_block_image_a_la_une( $attributes, $content, $block ) {
	if ( ! isset( $block->context['postId'] ) ) {
		return '';
	}

	$post_id   = (int) $block->context['postId'];
	$is_link   = isset( $attributes['isLink'] ) && $attributes['isLink'];
	$size_slug = isset( $attributes['sizeSlug'] ) ? $attributes['sizeSlug'] : 'post-thumbnail';

	$featured_image_post_id = get_post_thumbnail_id( $post_id );
	$html_featured_image    = wp_get_attachment_image( $featured_image_post_id, $size_slug, false );

	if ( ! $html_featured_image ) {
		return '';
	}

	if ( $is_link ) {
		$link_target         = $attributes['linkTarget'];
		$rel                 = ! empty( $attributes['rel'] ) ? 'rel="' . esc_attr( $attributes['rel'] ) . '"' : '';
		$html_featured_image = sprintf(
			'<a href="%1$s" target="%2$s" %3$s>%4$s</a>',
			get_the_permalink( $post_id ),
			esc_attr( $link_target ),
			$rel,
			$html_featured_image
		);
	}

	$caption      = get_post_field( 'post_content', $featured_image_post_id );
	$html_caption = '';

	if ( $caption ) {
		$html_caption = sprintf(
			'<figcaption class="wp-element-caption">%s</figcaption>',
			wp_kses(
				$caption,
				array(
					'strong' => true,
					'span'   => true,
					'a'      => array(
						'href'   => true,
						'target' => true,
					)
				)
			)
		);
	}

	return sprintf(
		'<figure %1$s>
			%2$s
			%3$s
		</figure>',
		get_block_wrapper_attributes( array( 'class' => 'wp-block-post-featured-image' ) ),
		$html_featured_image,
		$html_caption
	);
}

/**
 * Registers the `ensemble/image-a-la-une` block on the server.
 *
 * @since 1.0.0
 */
function ensemble_register_block_image_a_la_une() {
	register_block_type_from_metadata(
		get_theme_file_path( '/assets/blocks/image-a-la-une' ),
		array(
			'render_callback' => 'ensemble_render_block_image_a_la_une',
		)
	);
}
add_action( 'init', 'ensemble_register_block_image_a_la_une' );
