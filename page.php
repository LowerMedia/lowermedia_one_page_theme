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
			<?php while ( have_posts() ) : the_post(); ?>
				<div class='navigation-main story-nav'>
					<?php
						$defaults = array(
								'theme_location'  => 'lmopt-top-menu',
								'menu'            => '',
								'container'       => 'nav',
								'container_class' => 'navigation-main',
								'container_id'    => 'site-navigation',
								'menu_class'      => 'menu',
								'menu_id'         => '',
								'echo'            => true,
								'fallback_cb'     => 'wp_page_menu',
								'before'          => '',
								'after'           => '',
								'link_before'     => '',
								'link_after'      => '',
								'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
								'depth'           => 0,
								'walker'          => ''
							);
							echo wp_nav_menu( $defaults );
					?>
				</div>
				<?php
				    if(get_option('lmopt_onepage_option')) {

				    	$args = array('sort_column' => 'menu_order','number' => get_option('lmopt_numpages_option')); 
						$pages = get_pages($args); 
						$counter = 1;
						$one_page_content;

						foreach ($pages as $page_data) {
						    $content = apply_filters('the_content', $page_data->post_content); 
						    $lmopt_paralax_img = apply_filters('post_thumbnail', $page_data->post_thumbnail); 
						    $title = $page_data->post_title;
						    $ID = $page_data->ID;
						    $lmopt_paralax_img;
						    //if ( has_post_thumbnail() ) { the_post_thumbnail();}	
						    //echo "<div id='lm-opt-".$ID."' class='lm-opt-page-wrap' >".$content."</div>"; 
						    //preg_match_all('#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#', get_the_post_thumbnail(), $match);
						    //echo '------'.var_dump($match).'----';
						    //echo $match[2][1];

						    // The Regular Expression filter
							// $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";

							// // The Text you want to filter for urls
							// $text = get_the_post_thumbnail();
							// $thumbnail_url;
							// // Check if there is a url in the text
							// if(preg_match($reg_exUrl, $text, $url)) {

							//        // make the urls hyper links
							//        //$thumbnail_url = preg_replace($reg_exUrl, '<a href="'.$url[0].'" rel="nofollow">'.$url[0].'</a>', $text);
							//        $thumbnail_url = preg_replace($reg_exUrl, $url[0], $text);

							// } else {

							//        // if no urls in the text just return the text
							//        $thumbnail_url = '';

							// }
							$url = wp_get_attachment_url( get_post_thumbnail_id($page_data->ID) );
						    $one_page_content .= "
							    <section id='lm-opt-".$counter."' class='lm-opt-page-wrap story' >
								    <div id='lm-opt-content' class=''>".$content."</div>
								    <div id='lmopt-img' class='photograph' style='background-image:url(".$url.");'></div>
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
