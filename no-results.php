<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package lowermedia_one_page_theme
 */
?>

<article id="post-0" class="post no-results not-found">
	<header class="entry-header">
		<h1 class="entry-title"><?php _e( 'LowerMedia One Page Theme', 'lowermedia_one_page_theme' ); ?></h1>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( __( 'Pick your homepage to make the One Page Theme work. <a href="wp-admin/options-reading.php">Pick here</a>.', 'lowermedia_one_page_theme' ) ); ?></p>

		<?php elseif ( is_search() ) : ?>

			<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'lowermedia_one_page_theme' ); ?></p>
			<?php //get_search_form(); ?>

		<?php else : ?>

			<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'lowermedia_one_page_theme' ); ?></p>
			<?php //get_search_form(); ?>

		<?php endif; ?>
	</div><!-- .entry-content -->
</article><!-- #post-0 .post .no-results .not-found -->
