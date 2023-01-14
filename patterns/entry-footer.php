<?php
/**
 * Title: Entry Footer Ensemble
 * Slug: ensemble/entry-footer
 * Inserter: no
 *
 * @package /ensemble/patterns
 *
 * @since 1.0.0
 */
?>
<!-- wp:group {"layout":{"type":"flex"}} -->
<div class="wp-block-group">
	<?php
	printf( '<!-- wp:post-terms {"term":"category","prefix":"%s ","suffix":","} /-->', esc_html_x( 'Publié dans', '"Published in" catgory separator', 'ensemble' ) );
	printf( '<!-- wp:post-terms {"term":"post_tag","prefix":"%s ","suffix":"."} /-->', esc_html_x( 'étiquetté', '"Tagged" tags separator', 'ensemble' ) );
	?>
</div>
<!-- /wp:group -->
