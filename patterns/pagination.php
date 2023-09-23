<?php
/**
 * Title: Pagination
 * Slug: ensemble/pagination
 * Inserter: no
 *
 * NB: although this is the right way to do it to make sure to translate strings,
 * it looks like patterns are not getting the block context. As a result, this pattern
 * is not used for now.
 *
 * @package /ensemble/patterns
 *
 * @since 1.0.0
 */

printf( '<!-- wp:query-pagination-previous {"label":"%s"} /-->', esc_html__( 'Publications plus récentes', 'ensemble' ) );
printf( '<!-- wp:query-pagination-next {"label":"%s"} /-->', esc_html__( 'Publications plus anciennes', 'ensemble' ) );
