<?php
/**
 * Title: Search form Ensemble
 * Slug: ensemble/search-form
 * Inserter: no
 *
 * @package /ensemble/patterns
 *
 * @since 1.0.0
 */
?>
<!-- wp:paragraph -->
<p><?php echo esc_html_x( 'Le site n’a pas trouvé ce que vous recherchez. Utilisez le formulaire ci-dessous pour réssayer avec un texte différent.', 'Message to convey that a webpage could not be found', 'ensemble' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:search {"label":"<?php echo esc_html_x( 'Rechercher', 'label', 'ensemble' ); ?>","placeholder":"<?php echo esc_attr_x( 'Texte recherché...', 'placeholder for search field', 'ensemble' ); ?>","showLabel":false,"width":100,"widthUnit":"%","buttonText":"<?php esc_attr_e( 'Ok', 'ensemble' ); ?>","buttonUseIcon":true,"align":"center"} /-->
