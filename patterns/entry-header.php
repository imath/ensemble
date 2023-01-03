<?php
/**
 * Title: Entry Header Ensemble
 * Slug: ensemble/entry-header
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
	<p><?php echo esc_html_x( 'Publié le', '"Published on" date separator', 'ensemble' ); ?></p>
	<!-- /wp:paragraph -->
	<!-- wp:post-date /-->
	<!-- wp:paragraph -->
	<p><?php echo esc_html_x( 'par', '"By" Author separator', 'ensemble' ); ?></p>
	<!-- /wp:paragraph -->
	<!-- wp:post-author {"showAvatar":false} /-->
</div>
<!-- /wp:group -->
