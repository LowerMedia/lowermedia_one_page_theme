<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package lowermedia_one_page_theme
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php
				
				
			    if(get_option('test_some_name')) {
					
			    	$args = array('sort_column' => 'menu_order'); 
					$pages = get_pages($args); 

					foreach ($pages as $page_data) {
					    $content = apply_filters('the_content', $page_data->post_content); 
					    $title = $page_data->post_title;
					    $ID = $page_data->ID;
					    echo "<div id='lm-opt-".$ID."' class='lm-opt-page-wrap' >".$content."</div>"; 
					}

				} else {
					get_template_part( 'content', 'page' ); 
				}
				
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() )
					comments_template();
					
				?>

			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>
