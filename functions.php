<?php
/**
 * lowermedia_one_page_theme functions and definitions
 *
 * @package lowermedia_one_page_theme
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

/*
 * Load Jetpack compatibility file.
 */
require( get_template_directory() . '/inc/jetpack.php' );

if ( ! function_exists( 'lowermedia_one_page_theme_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function lowermedia_one_page_theme_setup() {

	/**
	 * Custom template tags for this theme.
	 */
	require( get_template_directory() . '/inc/template-tags.php' );

	/**
	 * Custom functions that act independently of the theme templates
	 */
	require( get_template_directory() . '/inc/extras.php' );

	/**
	 * Customizer additions
	 */
	require( get_template_directory() . '/inc/customizer.php' );

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on lowermedia_one_page_theme, use a find and replace
	 * to change 'lowermedia_one_page_theme' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'lowermedia_one_page_theme', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails on posts and pages
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	//add_theme_support( 'post-thumbnails' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'lowermedia_one_page_theme' ),
	) );

	/**
	 * Enable support for Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );
}
endif; // lowermedia_one_page_theme_setup
add_action( 'after_setup_theme', 'lowermedia_one_page_theme_setup' );

/**
 * Setup the WordPress core custom background feature.
 *
 * Use add_theme_support to register support for WordPress 3.4+
 * as well as provide backward compatibility for WordPress 3.3
 * using feature detection of wp_get_theme() which was introduced
 * in WordPress 3.4.
 *
 * @todo Remove the 3.3 support when WordPress 3.6 is released.
 *
 * Hooks into the after_setup_theme action.
 */
function lowermedia_one_page_theme_register_custom_background() {
	$args = array(
		'default-color' => 'ffffff',
		'default-image' => '',
	);

	$args = apply_filters( 'lowermedia_one_page_theme_custom_background_args', $args );

	if ( function_exists( 'wp_get_theme' ) ) {
		add_theme_support( 'custom-background', $args );
	} else {
		define( 'BACKGROUND_COLOR', $args['default-color'] );
		if ( ! empty( $args['default-image'] ) )
			define( 'BACKGROUND_IMAGE', $args['default-image'] );
		add_custom_background();
	}
}
add_action( 'after_setup_theme', 'lowermedia_one_page_theme_register_custom_background' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function lowermedia_one_page_theme_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'lowermedia_one_page_theme' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'lowermedia_one_page_theme_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function lowermedia_one_page_theme_scripts() {
	wp_enqueue_style( 'lowermedia_one_page_theme-style', get_stylesheet_uri() );

	wp_enqueue_script( 'lowermedia_one_page_theme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'lowermedia_one_page_theme-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'lowermedia_one_page_theme-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
}
add_action( 'wp_enqueue_scripts', 'lowermedia_one_page_theme_scripts' );

function lowermedia_add_styles()  
{ 
  // Register the style like this for a theme:  
  // (First the unique name for the style (custom-style) then the src, 
  // then dependencies and ver no. and media type)
  wp_register_style( 'sass-screen-styles', get_template_directory_uri() . '/stylesheets/screen.css',  array(), '20130715', 'all' );
  //----wp_register_style( 'user-generated-styles', get_template_directory_uri() . '/user-generated-styles.php',  array(), '20130715', 'all' );
  // enqueing:
  wp_enqueue_style( 'sass-screen-styles' );
  //----wp_enqueue_style( 'user-generated-styles' );
}
add_action('wp_enqueue_scripts', 'lowermedia_add_styles', 100);

 /**
 * Register with hook 'wp_enqueue_scripts', which can be used for front end CSS and JavaScript
 */
//add_action( 'wp_enqueue_scripts', 'lowermedia_add_stylesheet' );

/**
 * Enqueue plugin style-file
 */
// function lowermedia_add_stylesheet() {
//     // Respects SSL, Style.css is relative to the current file
//     //wp_register_style( 'lowermedia-styles', plugins_url('lowermedia-styles.css', __FILE__) );
//     //wp_enqueue_style( 'lowermedia-styles' );
// }					

/**
 * Implement the Custom Header feature
 */
//require( get_template_directory() . '/inc/custom-header.php' );


/** Step 1. */
// function lowermedia_one_page_theme_menu() {
// 	add_menu_page( 'One Page Theme Options', 'One Page Theme', 'manage_options', 'lowermedia-one-page-theme', 'lowermedia_one_page_theme_options' );
// }
/** Step 2 (from codex). */
//add_action( 'admin_menu', 'lowermedia_one_page_theme_menu' );

/** Step 3. */
// function lowermedia_one_page_theme_options() {
// 	if ( !current_user_can( 'manage_options' ) )  {
// 		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
// 	}
// 	echo "<div class='wrap'>
// 	<h2>LowerMedia One Page Theme Options</h2>
// 	<p>
// 	-Combine All Pages  OR<br/>
// 	-Activate home page as splash page  OR<br/>
// 	-Normal Setup

// 	<form method='post' action='options.php'> ";
// 	settings_fields( 'lowermedia_one_page_theme_options' );
// 	do_settings_fields( 'lowermedia_one_page_theme_options' );
// 	submit_button();
// 	echo "</form>
// 	</p>
// 	<p>
// 	-upload background image?
//  -header/footer on of switch
//
// 	</p>
// 	</div>";
// }


/*------------------------------------------------------------------------------------------------*/
class lowermedia_one_page_theme_admin_options{
    public function __construct(){
        if(is_admin()){
		    add_action('admin_menu', array($this, 'lowermedia_one_page_theme_menu'));
		    add_action('admin_init', array($this, 'page_init'));
		}
    }
	
    public function lowermedia_one_page_theme_menu(){
	    // This page will be under "Settings"
		add_theme_page( 'One Page Theme Options', 'One Page Theme', 'manage_options', 'lowermedia-one-page-theme', array($this, 'create_admin_page') );
    }

    public function create_admin_page(){
        ?>
	<div class="wrap">
	    <?php screen_icon(); ?>
	    <h2>LowerMedia One Page Theme Options</h2>			
	    <form method="post" action="options.php">
	        <?php
            // This prints out all hidden setting fields
		    settings_fields('lowermedia-one-page-theme_option_group');	
		    do_settings_sections('lowermedia-one-page-theme');
		?>
	        <?php submit_button(); ?>
	    </form>
	</div>
	<?php
    }
	
    public function page_init(){	

    	/*REGISTER DEFAULT OPTION*/	
    	register_setting('lowermedia-one-page-theme_option_group', 'lowermedia_opt_onepage', array($this, 'check_onepage'));

    	add_settings_section(
		    'lowermedia_opt_onepage',
		    '<!-- Check Box -->',
		    array($this, 'print_section_info'),
		    'lowermedia-one-page-theme'
		);	

		add_settings_field(
		    'lmopt_onepage', 
		    'One Page Style Output?', 
		    array($this, 'lmopt_onepage'), 
		    'lowermedia-one-page-theme',
		    'lowermedia_opt_onepage'			
		);	

		//if the one page option is checked and not set to zero
		if (get_option('lmopt_onepage_option') && get_option('lmopt_onepage_option') != 0) { 
			register_setting('lowermedia-one-page-theme_option_group', 'lowermedia_opt_numpages', array($this, 'check_numpages')); //only accepts numbers
			register_setting('lowermedia-one-page-theme_option_group', 'lowermedia_opt_header', array($this, 'check_header'));
			register_setting('lowermedia-one-page-theme_option_group', 'lowermedia_opt_footer', array($this, 'check_footer'));
			register_setting('lowermedia-one-page-theme_option_group', 'lowermedia_opt_menuloca', array($this, 'check_menuloca'));
			register_setting('lowermedia-one-page-theme_option_group', 'lowermedia_opt_customstyles', array($this, 'check_customstyles'));

			/*--------------ADD SECTION-------------*/

			add_settings_section(
			    'lowermedia_opt_numpages',
			    '<!-- Text Field -->',
			    array($this, 'print_section_info'),
			    'lowermedia-one-page-theme'
			);

			add_settings_section(
			    'lowermedia_opt_header',
			    '<!-- Check Box -->',
			    array($this, 'print_section_info'),
			    'lowermedia-one-page-theme'
			);	

			add_settings_section(
			    'lowermedia_opt_footer',
			    '<!-- Check Box -->',
			    array($this, 'print_section_info'),
			    'lowermedia-one-page-theme'
			);

			add_settings_section(
			    'lowermedia_opt_menuloca',
			    '<!-- Check Box -->',
			    array($this, 'print_section_info'),
			    'lowermedia-one-page-theme'
			);	

			add_settings_section(
			    'lowermedia_opt_customstyles',
			    '<!-- Text Field -->',
			    array($this, 'print_section_info'),
			    'lowermedia-one-page-theme'
			);
			
			/*--------------ADD FIELD-------------*/

			add_settings_field(
			    'lmopt_numpages', 
			    'Number of Pages to Combine:', 
			    array($this, 'lmopt_numpages'), 
			    'lowermedia-one-page-theme',
			    'lowermedia_opt_numpages'			
			);

			add_settings_field(
			    'lmopt_header', 
			    'Hide Header?', 
			    array($this, 'lmopt_header'), 
			    'lowermedia-one-page-theme',
			    'lowermedia_opt_header'			
			);	

			add_settings_field(
			    'lmopt_footer', 
			    'Hide Footer?', 
			    array($this, 'lmopt_footer'), 
			    'lowermedia-one-page-theme',
			    'lowermedia_opt_footer'			
			);	

			add_settings_field(
			    'lmopt_menuloca', 
			    'Show Primary Menu in First Parallax Section? (Default is in header)', 
			    array($this, 'lmopt_menuloca'), 
			    'lowermedia-one-page-theme',
			    'lowermedia_opt_menuloca'			
			);	

			add_settings_field(
			    'lmopt_customstyles', 
			    'Add Custom CSS Styles Here:', 
			    array($this, 'lmopt_customstyles'), 
			    'lowermedia-one-page-theme',
			    'lowermedia_opt_customstyles'			
			);

			//If the numpages option in the database is set and not set to 0, we add the styles to the head
			if (get_option('lmopt_numpages_option') && get_option('lmopt_numpages_option') != 0) {
				//set numpages variable with number of pages making up one page theme
				$numpages = get_option('lmopt_numpages_option');

				while ($numpages != 0) {
					//$check_name='check_bkgrnd_'.$bkgrnd_style;
					//$check_name='check_bkgrnd_'.$numpages;
					//$check_name=check_bkgrnd_url($numpages);
					$check_name='check_bkgrnd_url';
					$func_name='lowermedia_opt_bkgrnd_'.$numpages;
					$setting_name='lmopt_bkgrnd_'.$numpages;
					$form_txt='Background image url for page '.$numpages.':';
					//register db option holding style into the options group
					register_setting('lowermedia-one-page-theme_option_group', $func_name, array($this, $check_name)); //only accepts numbers

					/*--------------ADD SECTION-------------*/
					add_settings_section(
					    $func_name,
					    '<!-- Text Field -->',
					    array($this, 'print_section_info'),
					    'lowermedia-one-page-theme'
					);

					add_settings_field(
					    $setting_name, 
					    $form_txt, 
					    array($this, $setting_name), 
					    'lowermedia-one-page-theme',
					    $func_name			
					);
					$numpages--;
				}
			}	
		}	
    }

    /*---------BACKGROUND FUNCTIONS-----------*/

  //   public function lowermedia_validate_url($input){
  //   	$valid_url = $input;
		// if (filter_var($valid_url, FILTER_VALIDATE_URL) === FALSE) {
		//     $valid_url = "";
		// } else {
		// 	$valid_url = esc_attr($valid_url);
		// }

		// return $valid_url;
  //   }
    /* #1 background funcs */

    //public function check_bkgrnd_1_OLD($input){
 //    	$valid_url = $input['lmopt_bkgrnd_1'];
	// 	if (filter_var($valid_url, FILTER_VALIDATE_URL) === FALSE) {
	// 	    $valid_url = "";
	// 	} else {
	// 		$valid_url = esc_attr($valid_url);
	// 	}
	//     if(get_option('lmopt_bkgrnd_1_option') === FALSE){
	// 		add_option('lmopt_bkgrnd_1_option', $valid_url);
	//     }else{
	// 		update_option('lmopt_bkgrnd_1_option', $valid_url);
	//     }
	// 	return $valid_url;
	// }

    public function check_bkgrnd_url($input){
		//echo var_dump(array_keys($input));
		$array_key = array_keys($input);
		//echo $array_key[0];
		$get_op_txt = $array_key[0];
		$get_op_txt_op = $array_key[0].'_option';

    	$valid_url = $input[$get_op_txt];
		if (filter_var($valid_url, FILTER_VALIDATE_URL) === FALSE) {
		    $valid_url = "ENTER URL: LAST URL WAS INVALID";
		} else {
			$valid_url = esc_attr($valid_url);
		}
	    if(get_option($get_op_txt_op) === FALSE){
			add_option($get_op_txt_op, $valid_url);
	    }else{
			update_option($get_op_txt_op, $valid_url);
	    }
		return $valid_url;
	}

	// 
	public function lmopt_bkgrnd_1($input){
		//echo '<br/>----------lmopt background 1----------';
		//echo var_dump($input);
		//echo '-----------'.$counter;
		$value_holder = get_option('lmopt_bkgrnd_1_option');
	    ?>
	    <input 
	        type="text" 
	        id="lmopt_bkgrnd_1" 
	        name="lowermedia_opt_bkgrnd_1[lmopt_bkgrnd_1]" 
	        value="<?php echo $value_holder; ?>" 
	        size='20'
	    />
	    <?php
	    if(get_option('lmopt_bkgrnd_1_option')){echo"<img src='".get_option('lmopt_bkgrnd_1_option')."' height=150px width=150px class='lm-opt-preview-img'/>";}
	}


	/* #2 background funcs */
	public function lmopt_bkgrnd_2(){
		$value_holder = get_option('lmopt_bkgrnd_2_option');
	    ?>
	    <input 
	        type="text" 
	        id="lmopt_bkgrnd_2" 
	        name="lowermedia_opt_bkgrnd_2[lmopt_bkgrnd_2]" 
	        value='<?php echo $value_holder; ?>' 
	        size='20'
	    />
	    <?php
	     if(get_option('lmopt_bkgrnd_2_option')){echo"<img src='".get_option('lmopt_bkgrnd_2_option')."' height=150px width=150px class='lm-opt-preview-img'/>";}
	}
	/* #3 background funcs */

	public function lmopt_bkgrnd_3(){
		$value_holder = get_option('lmopt_bkgrnd_3_option');
	    ?>
	    <input 
	        type="text" 
	        id="lmopt_bkgrnd_3" 
	        name="lowermedia_opt_bkgrnd_3[lmopt_bkgrnd_3]" 
	        value='<?php echo $value_holder; ?>' 
	        size='20'
	    />
	    <?php
	    if(get_option('lmopt_bkgrnd_3_option')){echo"<img src='".get_option('lmopt_bkgrnd_3_option')."' height=150px width=150px class='lm-opt-preview-img'/>";}
	}

	/* #4 background funcs */

	public function lmopt_bkgrnd_4(){
		$value_holder = get_option('lmopt_bkgrnd_4_option');
	    ?>
	    <input 
	        type="text" 
	        id="lmopt_bkgrnd_4" 
	        name="lowermedia_opt_bkgrnd_4[lmopt_bkgrnd_4]" 
	        value='<?php echo $value_holder; ?>' 
	        size='20'
	    />
	    <?php
	   if(get_option('lmopt_bkgrnd_4_option')){echo"<img src='".get_option('lmopt_bkgrnd_4_option')."' height=150px width=150px class='lm-opt-preview-img'/>";}
	}

	/* #5 background funcs */

	public function lmopt_bkgrnd_5(){
		//echo '<br/>----------lmopt background 1----------';
	    ?>
	    <input 
	        type="text" 
	        id="lmopt_bkgrnd_5" 
	        name="lowermedia_opt_bkgrnd_5[lmopt_bkgrnd_5]" 
	        value='<?php get_option('lmopt_bkgrnd_5_option');?>' 
	        size='20'
	    />
	    <?php
	   if(get_option('lmopt_bkgrnd_5_option')){echo"<img src='".get_option('lmopt_bkgrnd_5_option')."' height=150px width=150px class='lm-opt-preview-img'/>";}
	}

	/* #6 background funcs */
	public function lmopt_bkgrnd_6(){
	    ?>
	    <input 
	        type="text" 
	        id="lmopt_bkgrnd_6" 
	        name="lowermedia_opt_bkgrnd_6[lmopt_bkgrnd_6]" 
	        value='<?php get_option('lmopt_bkgrnd_6_option');?>' 
	        size='20'
	    />
	    <?php
	    if(get_option('lmopt_bkgrnd_6_option')){echo"<img src='".get_option('lmopt_bkgrnd_6_option')."' height=150px width=150px class='lm-opt-preview-img'/>";}
	}

	/* #7 background funcs */
	public function lmopt_bkgrnd_7(){
	    ?>
	    <input 
	        type="text" 
	        id="lmopt_bkgrnd_7" 
	        name="lowermedia_opt_bkgrnd_7[lmopt_bkgrnd_7]" 
	        value='<?php get_option('lmopt_bkgrnd_7_option');?>' 
	        size='20'
	    />
	    <?php
	    if(get_option('lmopt_bkgrnd_7_option')){echo"<img src='".get_option('lmopt_bkgrnd_7_option')."' height=150px width=150px class='lm-opt-preview-img'/>";}
	}

	/* #8 background funcs */
	public function lmopt_bkgrnd_8(){
	    ?>
	    <input 
	        type="text" 
	        id="lmopt_bkgrnd_8" 
	        name="lowermedia_opt_bkgrnd_8[lmopt_bkgrnd_8]" 
	        value='<?php get_option('lmopt_bkgrnd_8_option');?>' 
	        size='20'
	    />
	    <?php
	    if(get_option('lmopt_bkgrnd_8_option')){echo"<img src='".get_option('lmopt_bkgrnd_8_option')."' height=150px width=150px class='lm-opt-preview-img'/>";}
	}

/*--------------------*/

    public function check_numpages($input){//only accepts numbers
		$pages = get_pages($input); 
		$counter = 0;
		foreach ($pages as $page_data) {$counter++;}
	    if(is_numeric($input['lmopt_numpages'])){
		    	$mid = $input['lmopt_numpages'];
		    	//check to make sure there are enough pages created to support the number of pages making up the one page, if there isn't wp will break
		    	if ($mid <= $counter) {		
				    if(get_option('lmopt_numpages_option') === FALSE){
						add_option('lmopt_numpages_option', $mid);
				    }else{
						update_option('lmopt_numpages_option', $mid);
				    }
				}else{
					$lmerrmsg = "Please Enter a number equal to or lower than the number of pages created in the page's section of wordpress
					your site has ".$counter." pages, you can not add more 'Number of Pages to Combine' than this";
					//On page 1

					$_POST['lmerrmsg'] = $lmerrmsg;
				}
			}else{
			    $mid = '';
		}
		return $mid;
    }

    public function lmopt_numpages(){
        ?>
        <input 
	        type="text" 
	        id="lmopt_numpages" 
	        name="lowermedia_opt_numpages[lmopt_numpages]" 
	        value='<?php get_option('lmopt_numpages_option');?>' 
	        size='1'
        />
        <?php 
        echo'*must be less than or equal to number of pages';
    }

 	public function check_onepage($input){

 		$output = $input['lmopt_onepage'];

 		//check if the checkbox was checked
 		//if it was add or update the option
    	if(isset($input['lmopt_onepage'])) {
		    if(get_option('lmopt_onepage_option') === FALSE){
				add_option('lmopt_onepage_option', $output);
		    }else{
				update_option('lmopt_onepage_option', $output);
		    }
		}else{//if it wasn't delete the option
				delete_option('lmopt_onepage_option');
		}
		return $output;
    }

    public function check_header($input){

 		$output = $input['lmopt_header'];

 		//check if the checkbox was checked
 		//if it was add or update the option
    	if(isset($input['lmopt_header'])) {
		    if(get_option('lmopt_header_option') === FALSE){
				add_option('lmopt_header_option', $output);
		    }else{
				update_option('lmopt_header_option', $output);
		    }
		}else{//if it wasn't delete the option
				delete_option('lmopt_header_option');
		}
		return $output;
    }

    public function check_footer($input){

 		$output = $input['lmopt_footer'];

 		//check if the checkbox was checked
 		//if it was add or update the option
    	if(isset($input['lmopt_footer'])) {
		    if(get_option('lmopt_footer_option') === FALSE){
				add_option('lmopt_footer_option', $output);
		    }else{
				update_option('lmopt_footer_option', $output);
		    }
		}else{//if it wasn't delete the option
				delete_option('lmopt_footer_option');
		}
		return $output;
    }

    public function check_menuloca($input){

 		$output = $input['lmopt_menuloca'];

 		//check if the checkbox was checked
 		//if it was add or update the option
    	if(isset($input['lmopt_menuloca'])) {
		    if(get_option('lmopt_menuloca_option') === FALSE){
				add_option('lmopt_menuloca_option', $output);
		    }else{
				update_option('lmopt_menuloca_option', $output);
		    }
		}else{//if it wasn't delete the option
				delete_option('lmopt_menuloca_option');
		}
		return $output;
    }
	
    public function print_section_info(){//CALLBACK FUNCTION
		print '<!-- Enter your setting below:-->';
    }

    public function lmopt_onepage(){
        ?>
	        <input 
		        type="checkbox" 
		        id="lmopt_onepage" 
		        name="lowermedia_opt_onepage[lmopt_onepage]" 
		        value="1" 
		        <?php 
		        if ( get_option('lmopt_onepage_option') ) {echo 'checked="checked"'; }
	        ?> 
        />

        <?php
    }

    public function lmopt_header(){
        ?>
	        <input 
		        type="checkbox" 
		        id="lmopt_header" 
		        name="lowermedia_opt_header[lmopt_header]" 
		        value="1" 
		        <?php 
		        if ( get_option('lmopt_header_option') ) {echo 'checked="checked"'; }
	        ?> 
        />

        <?php
    }

    public function lmopt_footer(){
        ?>
	        <input 
		        type="checkbox" 
		        id="lmopt_footer" 
		        name="lowermedia_opt_footer[lmopt_footer]" 
		        value="1" 
		        <?php 
		        if ( get_option('lmopt_footer_option') ) {echo 'checked="checked"'; }
	        ?> 
        />

        <?php
    }

    public function lmopt_menuloca(){
        ?>
	        <input 
		        type="checkbox" 
		        id="lmopt_menuloca" 
		        name="lowermedia_opt_menuloca[lmopt_menuloca]" 
		        value="1" 
		        <?php 
		        if ( get_option('lmopt_menuloca_option') ) {echo 'checked="checked"'; }
	        ?> 
        />

        <?php
    }

	public function check_customstyles($input){

		$custom_styles = $input['lmopt_customstyles'];

		$search = array(
		'@<script[^>]*?>.*?</script>@si',   // Strip out javascript
		'@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
		'@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
		'@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
		);

		$custom_styles = preg_replace($search, '', $custom_styles);
		//return $output;

		if(get_option('lmopt_customstyles_option') === FALSE){
		add_option('lmopt_customstyles_option', $custom_styles);
		}else{
		update_option('lmopt_customstyles_option', $custom_styles);
		}

		return $custom_styles;

	}
	public function lmopt_customstyles(){
	    ?>

	    <TEXTAREA type="text" 
	        id="lmopt_customstyles" 
	        name="lowermedia_opt_customstyles[lmopt_customstyles]" 
	        value='' 
	        ROWS=3 COLS=30 
	    ><?php get_option('lmopt_customstyles_option');?>
	    </TEXTAREA>
	    <?php
	    //if(get_option('lmopt_customstyles_option')){echo"<img src='".get_option('lmopt_bkgrnd_8_option')."' height=150px width=150px class='lm-opt-preview-img'/>";}
	}


}

$lowermedia_one_page_theme_admin_options = new lowermedia_one_page_theme_admin_options();

/*############################################################################################
#
#   ADD WIDGET AREA OUTPUT TO THE END OF THE WP_HEAD (BEGINING OF BODY TAG)
#   //This function adds to the begining of the body tag
*/	

function lowermedia_add_opt_styles() {
	//check if enabled option is selected
	if (get_option('lmopt_numpages_option')) {
		$numpages = get_option('lmopt_numpages_option');
		$lmopt_styles='<style type="text/css" id="LowerMedia-opt-styles">';
		
		if ($numpages != 0 ) {

			while ($numpages != 0) {
				$setting_name='lmopt_bkgrnd_'.$numpages.'_option';
				$setting_data=get_option($setting_name);
				if(get_option($setting_name) && $setting_data != NULL) {
					$style_from_setting = $setting_data;
					$lmopt_styles .='
						#lm-opt-'.$numpages.' { background: url("'.$style_from_setting.'") 50% 0 repeat fixed; }
					';
					//echo $numpages.':'.$lmopt_styles.'<br/>';
				} 
				$numpages--;
			}

			if (get_option('lmopt_customstyles_option')){
				$lmopt_styles .= get_option('lmopt_customstyles_option');
			}
		}
		$lmopt_styles.='</style>';
		echo $lmopt_styles;
		// $output = $lmopt_styles;
		// echo '----'.$output.'-----'.$lmopt_styles;
		// return $output;
	} else {echo'';}
}
add_action('wp_head', 'lowermedia_add_opt_styles');

/*############################################################################################
#
#   ADD MENUS
#   //
*/	

function register_my_menus() {
  register_nav_menus(
    array(
      //'lmopt-top-menu' => __( 'OnePageTheme Top Menu' ),
      //'lmopt-section-menu' => __( 'OnePageTheme Section One Menu' )
    )
  );
}

add_action( 'init', 'register_my_menus' );

/*############################################################################################
#
#   ADD FEATURED IMAGE TO PAGES
#   //
*/	
add_theme_support( 'post-thumbnails', array( 'page' ) );          // Pages only
/*############################################################################################
#
#   ADD CUSTOM HEADER IMAGE CAPABILITY
#   //
*/	
$args = array(
	'flex-width'    => true,
	'width'         => 980,
	'flex-height'    => true,
	'height'        => 200,
	'default-image' => get_template_directory_uri() . '/images/header.jpg',
);
add_theme_support( 'custom-header', $args );

/*############################################################################################
#
#   Function to add admin link to front end if is admin
#   //
*/

function lowermedia_add_admin_menu_link($link, $name){
	if ( current_user_can( 'manage_options' ) ) {
    	/* A user with admin privileges */
    	return '<a class="admin-class edit-menu-link" href="'.$link.'">EDIT '.$name.'</a>';
	} 
}