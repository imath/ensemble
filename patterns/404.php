<?php
/**
 * Title: 404 Ensemble
 * Slug: ensemble/404
 * Inserter: no
 *
 * @package /ensemble/patterns
 *
 * @since 1.0.0
 */
?>
<!-- wp:group {"layout":{"inherit":true}} -->
<div class="wp-block-group">
	<!-- wp:image {"align":"center","sizeSlug":"large"} -->
	<figure class="wp-block-image aligncenter size-large">
		<img src="<?php echo esc_url( get_template_directory_uri() );?>/assets/images/impasse.jpg" alt="<?php esc_attr_e( 'Impasse dans le sous-sol des Invalides', 'ensemble' ); ?>"/>
		<figcaption class="wp-element-caption">
			<?php printf(
				/* Translators: %s is the Unsplash link for the photo. */
				esc_html__( 'Photo d’imath sur %s', 'ensemble' ),
				sprintf(
					'<a href="%s">Unsplash</a>',
					esc_url( 'https://unsplash.com/fr/photos/kb3WdphnXOE' )
				)
			);
			;?>
		</figcaption>
	</figure>
	<!-- /wp:image -->

	<!-- wp:heading {"level":1,"textAlign":"center","className":"wp-block-post-title"} -->
	<h2 class="wp-block-post-title has-text-align-center"><?php esc_html_e( 'Ouch, vous voici dans une impasse !', 'ensemble' ); ?></h2>
	<!-- /wp:heading -->
	<!-- wp:paragraph -->
	<p><?php echo esc_html_x( 'Le site n’a pas trouvé ce que vous recherchez. Utilisez le formulaire ci-dessous pour réssayer avec un texte différent.', 'Message to convey that a webpage could not be found', 'ensemble' ); ?></p>
	<!-- /wp:paragraph -->
	<!-- wp:pattern {"slug":"ensemble/search-form"} /-->
</div>
<!-- /wp:group -->
