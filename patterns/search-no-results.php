<?php
/**
 * Title: Search no-results Ensemble
 * Slug: ensemble/search-no-results
 * Inserter: no
 *
 * @package /ensemble/patterns
 *
 * @since 1.0.0
 */
?>
<!-- wp:heading {"level":3} -->
<h3><?php esc_html_e( 'Ouch, rien par ici !', 'ensemble' ); ?></h3>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p><?php echo esc_html_x( 'Le site n’a pas trouvé ce que vous recherchez. Utilisez le formulaire ci-dessous pour réssayer avec un texte différent.', 'Message to convey that a webpage could not be found', 'ensemble' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:pattern {"slug":"ensemble/search-form"} /-->
