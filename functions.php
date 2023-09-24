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
		'ensemble-signet-script',
		get_theme_file_uri( '/assets/blocks/signet/index.js' ),
		$script_data['dependencies'],
		$script_data['version'],
		true
	);

	wp_register_style(
		'ensemble-signet-style',
		get_theme_file_uri( '/assets/blocks/signet/style-index.css' ),
		array(),
		$script_data['version']
	);

	register_block_type_from_metadata(
		$block_dir,
		array(
			'editor_script' => 'ensemble-signet-script',
			'style'         => 'ensemble-signet-style',
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
	if ( ! $post_format ) {
		$post_format = 'standard';
	}

	if ( $post_format !== $attrs['format'] ) {
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
 * Adds a single template to the single template hierarchy.
 *
 * @since 1.1.0
 *
 * @param array $templates The list of possible template to view a post.
 * @return array           The same list with possibly a specific template for post using a post format.
 */
function ensemble_set_single_post_format_templates( $templates = array() ) {
	$post        = get_queried_object();
	$post_format = get_post_format( $post );

	if ( $post_format ) {
		$primary_template = array_shift( $templates );
		array_unshift( $templates, $primary_template, "single-post-format-{$post_format}.php" );
	}

	return $templates;
}
add_filter( 'single_template_hierarchy', 'ensemble_set_single_post_format_templates' );

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

/**
 * Workaround to use french slugs for supported post formats.
 *
 * @since 1.1.0
 *
 * @param string $slug The french slug.
 * @return string The real post format slug.
 */
function ensemble_get_post_format_real_slug( $slug ) {
	$real_slug    = '';
	$custom_slugs = array(
		'articles' => 'standard',
		'signets'  => 'link',
		'breves'   => 'status',
	);

	if ( isset( $custom_slugs[ $slug ] ) ) {
		$real_slug = $custom_slugs[ $slug ];
	}

	return $real_slug;
}

/**
 * Get the Post Format Archive title.
 *
 * @since 1.1.0
 *
 * @param string $post_format The Post format slug.
 * @return string The Post Format Archive title.
 */
function ensemble_get_post_format_name( $post_format = '' ) {
	$name              = '';
	$post_format_names = array(
		'post-format-link'     => __( 'Signets', 'ensemble' ),
		'post-format-standard' => __( 'Articles', 'ensemble' ),
		'post-format-status'   => __( 'Brèves', 'ensemble' ),
	);

	if ( isset( $post_format_names[ $post_format ] ) ) {
		$name = $post_format_names[ $post_format ];
	}

	return $name;
}

/**
 * Callback function to prefix post format slugs.
 *
 * @since 1.1.0
 *
 * @param string $slug The post format slug.
 * @return string The post format slug prefixed with `post-format-` text.
 */
function ensemble_post_format_prefix_terms( $slug ) {
	return 'post-format-' . $slug;
}

/**
 * Edit query string just before `_post_format_request` to translate french
 * post formats & eventually only show "standard" posts.
 *
 * @since 1.1.0
 *
 * @param array $qs The list of query vars.
 * @return array The list of query vars.
 */
function ensemble_post_format_request( $qs = array() ) {
	if ( ! isset( $qs['post_format'] ) ) {
		return $qs;
	}

	$slug = ensemble_get_post_format_real_slug( $qs['post_format'] );
	if ( ! $slug ) {
		return $qs;
	}

	if ( 'standard' === $slug ) {
		$post_formats = get_post_format_slugs();
		unset( $post_formats['standard'], $qs['post_format'] );

		$qs['post_type'] = 'post';
		$qs['tax_query'] = array(
			array(
				'taxonomy' => 'post_format',
				'terms'    => array_map( 'ensemble_post_format_prefix_terms', array_values( $post_formats ) ),
				'field'    => 'slug',
				'operator' => 'NOT IN',
			)
		);

		// Override the query to adjust Post format data.
		add_filter( 'parse_query', 'ensemble_post_format_query', 9 );
	} else {
		$qs['post_format'] = $slug;
	}

	// Filter the document title to improve it with custom post format names.
	add_filter( 'document_title_parts', 'ensemble_document_title_parts', 10, 1 );

	return $qs;
}
add_filter( 'request', 'ensemble_post_format_request', 9 );

/**
 * Overrides the query to really use Standard post format archive template.
 *
 * @since 1.1.0
 *
 * @param WP_Query $posts_query The WP Query.
 */
function ensemble_post_format_query( $posts_query ) {
	remove_filter( 'parse_query', 'ensemble_post_format_query', 9 );

	if ( ! $posts_query->is_feed ) {
		$posts_query->is_home    = false;
		$posts_query->is_archive = true;
		$posts_query->is_tax     = true;

		$slug                        = 'post-format-standard';
		$posts_query->queried_object = (object) array(
			'term_id'          => 0,
			'name'             => ensemble_get_post_format_name( $slug ),
			'slug'             => $slug,
			'term_group'       => 0,
			'term_taxonomy_id' => 0,
			'taxonomy'         => 'post_format',
			'description'      => '',
			'parent'           => 0,
			'count'            => 1,
			'filter'           => 'raw',
		);

		$posts_query->queried_object_id = 0;
	}
}

/**
 * Edit the document title for Post formats.
 *
 * @since 1.1.0
 *
 * @param array $parts The document title parts.
 * @return array Edited document title parts.
 */
function ensemble_document_title_parts( $parts = array() ) {
	remove_filter( 'document_title_parts', 'ensemble_document_title_parts', 10, 1 );

	$queried_object = get_queried_object();
	if ( isset( $queried_object->taxonomy, $queried_object->slug ) && 'post_format' === $queried_object->taxonomy ) {
		$post_format_title = ensemble_get_post_format_name( $queried_object->slug );

		if ( $post_format_title ) {
			$parts = array_merge(
				$parts,
				array(
					'title' => $post_format_title,
				)
			);
		}
	}

	return $parts;
}

/**
 * Add an RSS link to Post Format Archive title.
 *
 * @since 1.1.0
 *
 * @param string $title The Archive title.
 * @return string HTML Output.
 */
function ensemble_prefix_post_format_rss_link( $title = '' ) {
	if ( ! is_tax( 'post_format' ) ) {
		return $title;
	}

	$term = get_queried_object();
	$url  = '';
	$icon = block_core_social_link_get_icon( 'feed' );

	if ( $term && isset( $term->term_id, $term->slug, $term->taxonomy ) ) {
		if ( 0 === $term->term_id && 'post-format-standard' === $term->slug ) {
			$url = home_url( 'type/articles/feed/' );
		} else {
			$url = get_term_feed_link( $term->term_id, $term->taxonomy );
		}

		$title = ensemble_get_post_format_name( $term->slug );
	}

	return sprintf(
		'<a href="%1$s" title="%2$s">%3$s</a> %4$s',
		esc_url( $url ),
		esc_html__( 'S’abonner au flux de ce type de publication', 'ensemble' ),
		$icon,
		esc_html( $title )
	);
}
add_filter( 'get_the_archive_title', 'ensemble_prefix_post_format_rss_link', 10, 1 );
