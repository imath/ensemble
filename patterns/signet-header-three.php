<?php
/**
 * Title: Entête de signet (h3)
 * Slug: ensemble/signet-header-three
 * Inserter: no
 *
 * @package /ensemble/patterns
 *
 * @since 1.1.0
 */
?>
<!-- wp:group {"layout":{"type":"flex"}} -->
<div class="wp-block-group">
	<!-- wp:heading {"level":3,"className":"wp-block-post-title"} -->
		<h3 class="wp-block-post-title"><?php echo esc_html_x( 'Signet publié le', '"Published on" date separator', 'ensemble' ); ?></h3>
	<!-- /wp:heading -->
	<!-- wp:post-date {"fontSize":"grande","textColor":"black"} /-->
</div>
<!-- /wp:group -->
