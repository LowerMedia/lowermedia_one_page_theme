<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package lowermedia_one_page_theme
 */
?>
	</div><!-- #main -->
		<footer id="colophon" class="site-footer" role="contentinfo" <?php if(get_option('lmopt_footer_option')) { echo "style='position: absolute;top: -9999px;left: -9999px;'";} ?>>
			<div class="site-info">
				<?php do_action( 'lowermedia_one_page_theme_credits' ); ?>
				<a href="http://wordpress.org/" title="<?php esc_attr_e( 'A Semantic Personal Publishing Platform', 'lowermedia_one_page_theme' ); ?>" rel="generator"><?php printf( __( 'Proudly powered by %s', 'lowermedia_one_page_theme' ), 'WordPress' ); ?></a>
				<span class="sep"> | </span>
				<?php printf( __( 'Theme: %1$s by %2$s.', 'lowermedia_one_page_theme' ), 'lowermedia_one_page_theme', '<a href="http://underscores.me/" rel="designer">Underscores.me</a>' ); ?>
			</div><!-- .site-info -->
		</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>