<?php
/**
 * Title: Post Formats Ensemble
 * Slug: ensemble/post-formats
 * Inserter: no
 *
 * @package /ensemble/patterns
 *
 * @since 1.0.0
 */
?>
<!-- wp:ensemble/post-format-template {"format":"standard"} -->
	<!-- wp:group {"tagName":"section","className":"entry-header","layout":{"inherit":true}} -->
	<section class="wp-block-group entry-header">
		<!-- wp:post-title {"isLink":true,"level":2} /-->
		<!-- wp:pattern {"slug":"ensemble/entry-header"} /-->
		<!-- wp:post-featured-image {"isLink":true} /-->
	</section>
	<!-- /wp:group -->
	<!-- wp:group {"tagName":"section","className":"entry-excerpt","layout":{"inherit":true}} -->
	<section class="wp-block-group entry-excerpt">
		<!-- wp:spacer {"height":"10px"} -->
		<div style="height:10px" aria-hidden="true" class="wp-block-spacer"></div>
		<!-- /wp:spacer -->
		<!-- wp:post-content /-->
	</section>
	<!-- /wp:group -->
	<!-- wp:group {"tagName":"section","className":"entry-footer","layout":{"inherit":true}} -->
	<section class="wp-block-group entry-footer">
		<!-- wp:pattern {"slug":"ensemble/entry-footer"} /-->
	</section>
	<!-- /wp:group -->
	<!-- wp:spacer {"height":"20px"} -->
	<div style="height:20px" aria-hidden="true" class="wp-block-spacer"></div>
	<!-- /wp:spacer -->
<!-- /wp:ensemble/post-format-template -->

<!-- wp:ensemble/post-format-template {"format":"link"} -->
	<!-- wp:group {"tagName":"section","className":"entry-excerpt signet-content","layout":{"inherit":true}} -->
	<section class="wp-block-group entry-excerpt signet-content">
		<!-- wp:spacer {"height":"10px"} -->
		<div style="height:10px" aria-hidden="true" class="wp-block-spacer"></div>
		<!-- /wp:spacer -->
		<!-- wp:post-content /-->
	</section>
	<!-- /wp:group -->
	<!-- wp:group {"tagName":"section","className":"entry-footer signet-footer","layout":{"inherit":true}} -->
	<section class="wp-block-group entry-footer signet-footer">
		<!-- wp:group {"layout":{"type":"flex"}} -->
		<div class="wp-block-group">
			<!-- wp:paragraph -->
			<p><?php echo esc_html_x( 'Publié le', '"Published on" date separator', 'ensemble' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:post-date /-->
		</div>
		<!-- /wp:group -->
	</section>
	<!-- /wp:group -->
	<!-- wp:spacer {"height":"20px"} -->
	<div style="height:20px" aria-hidden="true" class="wp-block-spacer"></div>
	<!-- /wp:spacer -->
<!-- /wp:ensemble/post-format-template -->
