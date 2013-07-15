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
					<?php
							// Get the nav menu based on $menu_name (same as 'theme_location' or 'menu' arg to wp_nav_menu)
						    // This code based on wp_nav_menu's code to get Menu ID from menu slug

							function lowermedia_return_menu($input){//$input is the menu name
								$menu_name = $input;//'lmopt-top-menu';
							    //var_dump(get_nav_menu_locations());
							    //echo $menus_holder["lmopt-top-menu"];

							    if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) 
								    {
								    		$menus_holder=(get_nav_menu_locations());
								    		//check to make sure the menu spot is not empty
								    		if ($menus_holder[$menu_name]!=0) {
												$menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
				
												$menu_items = wp_get_nav_menu_items($menu->term_id);
				
												$menu_list = '<div id="site-navigation" class="navigation-main story-nav"><ul id="menu-' . $menu_name . '" class="menu">';
				
												foreach ( (array) $menu_items as $key => $menu_item ) {
												    $title = $menu_item->title;
												    $url = $menu_item->url;
												    $menu_list .= '<li><a href="' . $url . '">' . $title . '</a></li>';
												}
												$menu_list .= '</ul></div>';
											} else {
												$menu_list = '';
											}
								    } 
							    else 
								    {
										$menu_list = '<div style="display:none;"><ul><li>Menu "' . $menu_name . '" not defined.</li></ul></div>';
								    }
							    return $menu_list;
							}

							echo lowermedia_return_menu("lmopt-top-menu");
							
						   //  $menu_name = 'lmopt-top-menu';
						   //  //var_dump(get_nav_menu_locations());
						   //  //echo $menus_holder["lmopt-top-menu"];

						   //  if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) 
							  //   {
							  //   		$menus_holder=(get_nav_menu_locations());
							  //   		//check to make sure the menu spot is not empty
							  //   		if ($menus_holder["lmopt-top-menu"]!=0) {
									// 		$menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
			
									// 		$menu_items = wp_get_nav_menu_items($menu->term_id);
			
									// 		$menu_list = '<div id="site-navigation" class="navigation-main story-nav"><ul id="menu-' . $menu_name . '" class="menu">';
			
									// 		foreach ( (array) $menu_items as $key => $menu_item ) {
									// 		    $title = $menu_item->title;
									// 		    $url = $menu_item->url;
									// 		    $menu_list .= '<li><a href="' . $url . '">' . $title . '</a></li>';
									// 		}
									// 		$menu_list .= '</ul></div>';
									// 	} else {
									// 		$menu_list = '';
									// 	}
							  //   } 
						   //  else 
							  //   {
									// $menu_list = '<div style="display:none;"><ul><li>Menu "' . $menu_name . '" not defined.</li></ul></div>';
							  //   }
						   //  echo $menu_list;

						   //  $section_menu_name = 'lmopt-section-menu';
						   //  if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $section_menu_name ] ) ) 
							  //   {
							  //   		$section_menus_holder=(get_nav_menu_locations());
							  //   		//check to make sure the menu spot is not empty
							  //   		if ($section_menus_holder["lmopt-top-menu"]!=0) {
									// 		$section_menu = wp_get_nav_menu_object( $locations[ $section_menu_name ] );
			
									// 		$section_menu_items = wp_get_nav_menu_items($section_menu->term_id);
			
									// 		$section_menu_list = '<div id="site-navigation" class="navigation-main story-nav"><ul id="menu-' . $section_menu_name . '" class="menu">';
			
									// 		foreach ( (array) $section_menu_items as $key => $section_menu_item ) {
									// 		    $title = $section_menu_item->title;
									// 		    $url = $section_menu_item->url;
									// 		    $section_menu_list .= '<li><a href="' . $url . '">' . $title . '</a></li>';
									// 		}
									// 		$section_menu_list .= '</ul></div>';
									// 	} else {
									// 		$section_menu_list = '';
									// 	}
							  //   } 
							  //  echo $section_menu_list;
					?>
				
				<?php
				    if(get_option('lmopt_onepage_option')) {

				    	$args = array('sort_column' => 'menu_order','number' => get_option('lmopt_numpages_option')); 
						$pages = get_pages($args); 
						$counter = 1;
						$one_page_content='';

						foreach ($pages as $page_data) {
						    $content = apply_filters('the_content', $page_data->post_content); 
						    $lmopt_paralax_img = apply_filters('post_thumbnail', $page_data->post_thumbnail); 
						    $title = $page_data->post_title;
						    $ID = $page_data->ID;
						    $lmopt_paralax_img;
						    //if($counter!=1){$one_page_menu_holder='';}
						    //use modulo operator to add even odd to correct divs
						    if($counter % 2 == 0){$parity='even-photo';}else{$parity='odd-photo';}
						    if($counter  == 1){$section_menu_holder=lowermedia_return_menu("lmopt-section-menu");}else{$section_menu_holder='';}
							$url = wp_get_attachment_url( get_post_thumbnail_id($page_data->ID) );
						   $one_page_content .= "
							    <section id='lm-opt-".$counter."' class='lm-opt-page-wrap story' >
							    	".$section_menu_holder."
								    <div id='lm-opt-content' class=''>".$content."</div>
								    <div id='lmopt-img' class='photograph ".$parity."' style='background-image:url(".$url.");'></div>
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
