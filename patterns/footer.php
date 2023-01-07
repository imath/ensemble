<?php
/**
 * Title: Footer Ensemble
 * Slug: ensemble/footer
 * Inserter: no
 *
 * @package /ensemble/patterns
 *
 * @since 1.0.0
 */
?>
<!-- wp:group {"layout":{"inherit":true}} -->
<div class="wp-block-group">
	<!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"var:preset|spacing|40"}}},"layout":{"type":"flex","justifyContent":"space-between"}} -->
	<div class="wp-block-group alignwide" style="padding-top:var(--wp--preset--spacing--40)">
		<!-- wp:social-links -->
		<ul class="wp-block-social-links">
		<?php
		printf(
			__( '<!-- wp:social-link {"url":"%s","service":"feed"} /-->' ),
			esc_url( get_bloginfo( 'rss2_url' ) )
		);
		?>
		<!-- wp:social-link {"url":"https://profiles.wordpress.org/imath/","service":"wordpress"} /-->
		<!-- wp:social-link {"url":"https://github.com/imath/","service":"github"} /-->
		<!-- wp:social-link {"url":"https://twitter.com/imath/","service":"twitter"} /-->
		<li class="wp-social-link wp-social-link-paypal wp-block-social-link">
			<a href="https://www.paypal.me/imath/" class="wp-block-social-link-anchor">
				<?php echo file_get_contents( get_template_directory_uri() . '/assets/images/paypal.svg' ); ?>
				<span class="wp-block-social-link-label screen-reader-text">Paypal</span>
			</a>
		</li>
		</ul>
		<!-- /wp:social-links -->
		<p class="has-text-align-right">
		<?php
		printf(
			/* Translators: WordPress link. */
			esc_html__( 'Fièrement propulsé par %s', 'ensemble' ),
			'<a href="' . esc_url( __( 'https://fr.wordpress.org/', 'ensemble' ) ) . '" rel="nofollow">WordPress</a>'
		);
		?>
		<span class="sep"> | </span>
		<?php
		printf(
			/* translators: 1: Theme name, 2: Theme author. */
			esc_html__( 'Thème: %1$s de %2$s.', 'ensemble' ),
			'<i><a href="' . esc_url( 'https://github.com/imath/ensemble' ) .'">Ensemble</a></i>',
			'<a href="' . esc_url( 'https://imathi.eu/' ) .'">imath</a>'
		);

		if ( function_exists( 'the_privacy_policy_link' ) ) {
			the_privacy_policy_link( '<span class="sep"> | </span>', '' );
		}
		?>
		</p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
