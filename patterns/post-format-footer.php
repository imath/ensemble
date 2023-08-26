<?php
/**
 * Title: Post Format Footer Ensemble
 * Slug: ensemble/post-format-footer
 * Inserter: no
 *
 * @package /ensemble/patterns
 *
 * @since 1.1.0
 */
?>
<!-- wp:group {"layout":{"type":"flex"}} -->
<div class="wp-block-group">
	<!-- wp:paragraph -->
	<p><?php echo esc_html_x( 'Publié le', '"Published on" date separator', 'ensemble' ); ?></p>
	<!-- /wp:paragraph -->
	<!-- wp:post-date /-->
</div>
<!-- /wp:group -->
