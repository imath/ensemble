<?php
/**
 * Title: Entête de signet
 * Slug: ensemble/signet-header
 * Inserter: no
 *
 * @package /ensemble/patterns
 *
 * @since 1.1.0
 */
?>
<!-- wp:group {"layout":{"type":"flex"}} -->
<div class="wp-block-group">
	<?php if ( is_archive() ) : ?>
		<!-- wp:heading {"level":3,"className":"wp-block-post-title"} -->
		<h3 class="wp-block-post-title"><?php echo esc_html_x( 'Signet publié le', '"Published on" date separator', 'ensemble' ); ?></h3>
		<!-- /wp:heading -->
	<?php else : ?>
		<!-- wp:heading {"className":"wp-block-post-title"} -->
		<h2 class="wp-block-post-title"><?php echo esc_html_x( 'Signet publié le', '"Published on" date separator', 'ensemble' ); ?></h2>
		<!-- /wp:heading -->
	<?php endif;  ?>
	<!-- wp:post-date {"fontSize":"grande","textColor":"black"} /-->
</div>
<!-- /wp:group -->
