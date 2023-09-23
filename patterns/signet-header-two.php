<?php
/**
 * Title: Entête de signet (h2)
 * Slug: ensemble/signet-header-two
 * Inserter: no
 *
 * @package /ensemble/patterns
 *
 * @since 1.1.0
 */
?>
<!-- wp:group {"layout":{"type":"flex"}} -->
<div class="wp-block-group">
	<!-- wp:heading {"className":"wp-block-post-title"} -->
		<h2 class="wp-block-post-title"><?php echo esc_html_x( 'Signet publié le', '"Published on" date separator', 'ensemble' ); ?></h2>
	<!-- /wp:heading -->
	<!-- wp:post-date {"fontSize":"grande","textColor":"black"} /-->
</div>
<!-- /wp:group -->
