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

get_header(); 

?>
	
	<div id="primary" class="content-area">

		<div id="content" class="site-content" role="main">

			<?php 
				while ( have_posts() ) : the_post(); 

				    if(get_option('lmopt_onepage_option')) {

				    	$args = array('sort_column' => 'menu_order','number' => get_option('lmopt_numpages_option')); 
						$pages = get_pages($args); 
						$counter = 1;
						$one_page_content='';
						$lmopt_count=0;
						foreach ($pages as $page_data) {
							$lmopt_count++;
						}

						foreach ($pages as $page_data) {
						    $content = apply_filters('the_content', $page_data->post_content); 
						    $lmopt_paralax_img = apply_filters('post_thumbnail', $page_data->post_thumbnail); 
						    $title = $page_data->post_title;
						    $ID = $page_data->ID;
						    $lmopt_paralax_img;
						    $position ='first';
						    //if($counter!=1){$one_page_menu_holder='';}
						    //use modulo operator to add even odd to correct divs
						    if($counter % 2 == 0){$parity='even';}else{$parity='odd';}
						    
						    if($counter  == 1){
						    	$header_image_src = get_header_image();
						    	$header_image_height = get_custom_header()->height;
						    	$header_image_width = get_custom_header()->width;

						    	$custom_header_img = "<br/><img src=".$header_image_src." height=".$header_image_height." width=".$header_image_width." alt='' /><br/>";

								if(get_option('lmopt_menuloca_option')) {
									$primary_menu = wp_nav_menu(array('echo' => false));
									$section_menu_holder ='
									<nav id="site-navigation" class="navigation-main" role="navigation">
									<h1 class="menu-toggle">Menu</h1>
									<div class="screen-reader-text skip-link">
									<a href="#content" title="Skip to content">Skip to content</a>
									</div>'.$primary_menu.'</nav><!-- #site-navigation -->';
								};
						    } else {
						    	$section_menu_holder = '';
						    	$custom_header_img = '';
						    	$position = 'middle';
						    	if ($counter == $lmopt_count){$position = 'last';}
						    }

							$url = wp_get_attachment_url( get_post_thumbnail_id($page_data->ID) );
						   $one_page_content .= "
							    <section id='lm-opt-".$counter."' class='lm-opt-page-wrap parallax-section lm-opt-".$counter." $parity $position ' >
							    	".$custom_header_img."
							    	".$section_menu_holder."
								    <div id='lm-opt-content' class='lm-opt-content $parity $position'>".$content."</div>
								    <div id='lmopt-img' class='lmopt-img photograph ".$parity."' style='background-image:url(".$url.");'></div>
							    </section>"; 
						    $counter++;
						}
						echo $one_page_content;
					} else {
						get_template_part( 'content', 'page' );
					}
				?>

				<div id='lm-opt-comment-wrap' class='lm-opt-page-wrap' >
				
				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() )
						comments_template();
				?>
				
				</div>

			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>
