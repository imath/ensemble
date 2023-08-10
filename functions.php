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

		// Use specific post formats.
		add_theme_support( 'post-formats', array( 'link', 'status' ) );

		// Use specific thumbnail size.
		set_post_thumbnail_size( 800, 400, true );

		// Enqueue editor styles.
		add_editor_style( 'style.css' );

		// Translations.
		load_theme_textdomain( 'ensemble', get_theme_file_path( '/languages' ) );
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
	$block_dir   = get_theme_file_path( '/assets/blocks/image-a-la-une' );
	$script_data = require_once trailingslashit( $block_dir ) . 'index.asset.php';

	wp_register_script(
		'ensemble-image-a-la-une',
		get_theme_file_uri( '/assets/blocks/image-a-la-une/index.js' ),
		$script_data['dependencies'],
		$script_data['version'],
		true
	);

	register_block_type_from_metadata(
		$block_dir,
		array(
			'editor_script'   => 'ensemble-image-a-la-une',
			'render_callback' => 'ensemble_render_block_image_a_la_une',
		)
	);
}
add_action( 'init', 'ensemble_register_block_image_a_la_une' );

/**
 * Registers the `ensemble/signet` block on the server.
 *
 * @since 1.0.0
 */
function ensemble_register_block_signet() {
	$block_dir   = get_theme_file_path( '/assets/blocks/signet' );
	$script_data = require_once trailingslashit( $block_dir ) . 'index.asset.php';

	wp_register_script(
		'ensemble-signet',
		get_theme_file_uri( '/assets/blocks/signet/index.js' ),
		$script_data['dependencies'],
		$script_data['version'],
		true
	);

	register_block_type_from_metadata(
		$block_dir,
		array(
			'editor_script' => 'ensemble-signet',
		)
	);
}
add_action( 'init', 'ensemble_register_block_signet' );

/**
 * Renders the `ensemble/post-format-template` block on the server.
 *
 * @since 1.1.0
 *
 * @param array    $attributes Block attributes.
 * @param string   $content    Block default content.
 * @param WP_Block $block      Block instance.
 * @return null|string The post format layout.
 */
function ensemble_render_block_post_format_template( $attributes, $content, $block ) {
	if ( ! isset( $block->context['postId'] ) ) {
		return '';
	}

	$post_id = (int) $block->context['postId'];
	$attrs   = wp_parse_args(
		$attributes,
		array(
			'format' => '',
		)
	);

	$post_format = get_post_format( $post_id );
	if ( $post_format && $post_format !== $attrs['format'] ) {
		return null;
	}

	return $content;
}

/**
 * Registers the `ensemble/post-format-template` block on the server.
 *
 * @since 1.1.0
 */
function ensemble_register_block_post_format_template() {
	$block_dir   = get_theme_file_path( '/assets/blocks/post-format-template' );
	$script_data = require_once trailingslashit( $block_dir ) . 'index.asset.php';

	wp_register_script(
		'ensemble-post-format-template',
		get_theme_file_uri( '/assets/blocks/post-format-template/index.js' ),
		$script_data['dependencies'],
		$script_data['version'],
		true
	);

	register_block_type_from_metadata(
		$block_dir,
		array(
			'editor_script'   => 'ensemble-post-format-template',
			'render_callback' => 'ensemble_render_block_post_format_template',
		)
	);
}
add_action( 'init', 'ensemble_register_block_post_format_template' );

/**
 * Workaround to customize the post content's more link.
 *
 * @todo Check why the `wp:post-content` block does not include an attribute to
 *       customize the post content's more link.
 *
 * @see https://github.com/WordPress/gutenberg/issues/47046
 *
 * @since 1.0.0
 *
 * @return string The customized post content's more link.
 */
function ensemble_content_more_link() {
	return sprintf(
		'<p class="ensemble-more-link">
			<a href="%1$s" class="more-link">%2$s &rarr;</a>
		</p>',
		esc_url( get_the_permalink() ),
		sprintf(
			wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
				__( 'Poursuivre la lecture<span class="screen-reader-text"> de "%s"</span>', 'ensemble' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			esc_html( get_the_title() )
		)
	);
}
add_filter( 'the_content_more_link', 'ensemble_content_more_link', 10, 0 );

/**
 * Workaround to make sure query pagination labels are translated.
 *
 * This function hooks `render_block_context` to transport the `core/query-pagination` block
 * context inside the 'ensemble/pagination' pattern so that the `core/query-pagination-previous`
 * & the `core/query-pagination-next` blocks can use it.
 *
 * @since 1.0.0
 *
 * @param array         $context      Default context.
 * @param array         $parsed_block Block being rendered, filtered by `render_block_data`.
 * @param WP_Block|null $parent_block If this is a nested block, a reference to the parent block.
 * @return string The customized post content's more link.
 */
function ensemble_render_query_pagination_block_context( $context, $parsed_block, $parent_block ) {
	static $pagination_context = array();

	if ( isset( $parsed_block['blockName'], $parsed_block['attrs']['slug'], $parent_block->context ) && 'core/pattern' === $parsed_block['blockName'] && 'ensemble/pagination' === $parsed_block['attrs']['slug'] ) {
		$pagination_context = $parent_block->context;

		if ( isset( $parent_block->attributes['paginationArrow'] ) ) {
			$pagination_context['paginationArrow'] = $parent_block->attributes['paginationArrow'];
		}
	} elseif ( $pagination_context && isset( $parsed_block['blockName'] ) ) {
		if ( 'core/query-pagination-next' === $parsed_block['blockName'] || 'core/query-pagination-previous' === $parsed_block['blockName'] ) {
			$context = $pagination_context;
		} else {
			$pagination_context = array();
		}
	}

	return $context;
}
add_filter( 'render_block_context', 'ensemble_render_query_pagination_block_context', 10, 3 );

/**
 * Make sure post formats are available from the REST API.
 *
 * @since 1.1.0
 *
 * @param array $args The `post_format` taxonomy args.
 * @return array The `post_format` taxonomy args.
 */
function ensemble_show_post_format_in_rest( $args = array() ) {
	$args['show_in_rest'] = true;
	return $args;
}
add_filter( 'register_post_format_taxonomy_args', 'ensemble_show_post_format_in_rest', 10, 1 );
