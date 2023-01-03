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
	<!-- wp:paragraph -->
	<p><?php echo esc_html_x( 'Publié dans', '"Published in" catgory separator', 'ensemble' ); ?></p>
	<!-- /wp:paragraph -->
	<!-- wp:post-terms {"term":"category"} /-->
	<!-- wp:paragraph -->
	<p><?php echo esc_html_x( 'étiquetté', '"Tagged" tags separator', 'ensemble' ); ?></p>
	<!-- /wp:paragraph -->
	<!-- wp:post-terms {"term":"post_tag"} /-->
</div>
<!-- /wp:group -->
