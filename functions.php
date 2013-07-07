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

 /**
 * Register with hook 'wp_enqueue_scripts', which can be used for front end CSS and JavaScript
 */
//add_action( 'wp_enqueue_scripts', 'lmsjsm_add_stylesheet' );

/**
 * Enqueue plugin style-file
 */
// function lmsjsm_add_stylesheet() {
//     // Respects SSL, Style.css is relative to the current file
//     //wp_register_style( 'lmsjsm-styles', plugins_url('lmsjsm-styles.css', __FILE__) );
//     //wp_enqueue_style( 'lmsjsm-styles' );
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
		//add_options_page('Settings Admin', 'Settings', 'manage_options', 'test-setting-admin', array($this, 'create_admin_page'));
		add_menu_page( 'One Page Theme Options', 'One Page Theme', 'manage_options', 'lowermedia-one-page-theme', array($this, 'create_admin_page') );
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
    	register_setting('lowermedia-one-page-theme_option_group', 'lowermedia_opt_onepage', array($this, 'check_onepage'));
		register_setting('lowermedia-one-page-theme_option_group', 'lowermedia_opt_numpages', array($this, 'check_numpages')); //only accepts numbers
		//register_setting('lowermedia-one-page-theme_option_group', 'lowermedia_opt_bkgrnd_one', array($this, 'check_bkgrnd_one')); //only accepts numbers

		register_setting('lowermedia-one-page-theme_option_group', 'lowermedia_opt_header', array($this, 'check_header'));
		register_setting('lowermedia-one-page-theme_option_group', 'lowermedia_opt_footer', array($this, 'check_footer'));

		$myvar = get_option('lmopt_numpages_option');
		$lmopt_styles='';;
		
		if ($myvar != 0 ) {

			while ($myvar != 0) {

				//$check_name='check_bkgrnd_'.$myvar;
				$check_name='check_bkgrnd_'.$myvar;
				$func_name='lowermedia_opt_bkgrnd_'.$myvar;
				$setting_name='lmopt_bkgrnd_'.$myvar;
				$form_txt='Background image url for page '.$myvar.':';
				

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

				if(get_option($setting_name.'_option')) {


					//$filename = 'lmopt-styles.css';
					//$style_from_setting = get_option($setting_name.'_option');
					//$lmopt_styles .='#lm-opt-'.$myvar.' { background-image:'.$style_from_setting.' }';
					//echo $myvar.':'.$lmopt_styles.'<br/>';
					// Let's make sure the file exists and is writable first.
					// if (is_writable($filename)) {

					//     // In our example we're opening $filename in append mode.
					//     // The file pointer is at the bottom of the file hence
					//     // that's where $somecontent will go when we fwrite() it.
					//     if (!$handle = fopen($filename, 'a')) {
					//          echo "Cannot open file ($filename)";
					//          exit;
					//     }

					//     // Write $somecontent to our opened file.
					//     if (fwrite($handle, $somecontent) === FALSE) {
					//         echo "Cannot write to file ($filename)";
					//         exit;
					//     }

					//     echo "Success, wrote ($somecontent) to file ($filename)";

					//     fclose($handle);

					// } else {
					//     echo "The file $filename is not writable";
					// }

				 //    	$file = 'lmsjsm-styles.php';
				 //    	//echo $file;
					// 	// Open the file to get existing content
					// 	$current = file_get_contents($file);
					// 	//echo $current;
					// 	// Append a new person to the file
					// 	$current .= get_option($setting_name.'_option');
					// 	//echo 'current:'.$current;
					// 	// Write the contents back to the file
					// 	if (file_put_contents($file, $current))
					// 		{echo 'pass';}
					// 	else{//echo'fail';
					// 		}
					// } else {
					// 	echo '<br/>Failed: failed';
					// 	echo '<br/>Setting Name:'.$setting_name;
					// 	echo '<br/>Get Option:'.get_option($setting_name);
					// // }

					$myvar--;
				}
			}
		}
		
		/*--------------ADD SECTION-------------*/

		add_settings_section(
		    'lowermedia_opt_onepage',
		    '<!-- Check Box -->',
		    array($this, 'print_section_info'),
		    'lowermedia-one-page-theme'
		);	

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
		
		/*--------------ADD FIELD-------------*/


		add_settings_field(
		    'lmopt_onepage', 
		    'One Page Style Output?', 
		    array($this, 'lmopt_onepage'), 
		    'lowermedia-one-page-theme',
		    'lowermedia_opt_onepage'			
		);	

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
    }

    /*---------BACKGROUND FUNCTIONS-----------*/

    

	public function check_bkgrnd_1($input){//only accepts numbers
    	$valid_url = $input['lmopt_bkgrnd_1'];

		if (filter_var($valid_url, FILTER_VALIDATE_URL) === FALSE) {
		    $exists = false;
		    $valid_url = "";
		} else {
			$exists = true;
			$valid_url = esc_attr($valid_url);
		}

	    if(get_option('lmopt_bkgrnd_1_option') === FALSE){
			add_option('lmopt_bkgrnd_1_option', $valid_url);
	    }else{
			update_option('lmopt_bkgrnd_1_option', $valid_url);
	    }
	
		return $valid_url;

	}

	public function lmopt_bkgrnd_1(){
		//echo '<br/>----------lmopt background 1----------';
	    ?>
	    <input 
	        type="text" 
	        id="lmopt_bkgrnd_1" 
	        name="lowermedia_opt_bkgrnd_1[lmopt_bkgrnd_1]" 
	        value='<?=get_option('lmopt_bkgrnd_1_option');?>' 
	        size='20'
	    />
	    <?php
	}

	public function check_bkgrnd_2($input){//only accepts numbers
    	$valid_url = $input['lmopt_bkgrnd_2'];

		if (filter_var($valid_url, FILTER_VALIDATE_URL) === FALSE) {
		    $exists = false;
		} else {
			$exists = true;
			$valid_url = esc_attr($valid_url);
		}

	    if ($exists==true){
		    if(get_option('lmopt_bkgrnd_2_option') === FALSE){
				add_option('lmopt_bkgrnd_2_option', $valid_url);
		    }else{
				update_option('lmopt_bkgrnd_2_option', $valid_url);
		    }
		
			return $valid_url;
		}
	}

	public function check_bkgrnd_3($input){//only accepts numbers
    	$valid_url = $input['lmopt_bkgrnd_3'];

		if (filter_var($valid_url, FILTER_VALIDATE_URL) === FALSE) {
		    $exists = false;
		} else {
			$exists = true;
			$valid_url = esc_attr($valid_url);
		}

	    if ($exists==true){
		    if(get_option('lmopt_bkgrnd_3_option') === FALSE){
				add_option('lmopt_bkgrnd_3_option', $valid_url);
		    }else{
				update_option('lmopt_bkgrnd_3_option', $valid_url);
		    }
		
			return $valid_url;
		}
	}

	public function check_bkgrnd_4($input){//only accepts numbers

    	$valid_url = $input['lmopt_bkgrnd_4'];

		if (filter_var($valid_url, FILTER_VALIDATE_URL) === FALSE) {
		    $exists = false;
		} else {
			$exists = true;
			$valid_url = esc_attr($valid_url);
		}

	    if ($exists==true){
		    if(get_option('lmopt_bkgrnd_4_option') === FALSE){
				add_option('lmopt_bkgrnd_4_option', $valid_url);
		    }else{
				update_option('lmopt_bkgrnd_4_option', $valid_url);
		    }
		
			return $valid_url;
		}
	}



	public function lmopt_bkgrnd_2(){
	    ?>
	    <input 
	        type="text" 
	        id="lmopt_bkgrnd_2" 
	        name="lowermedia_opt_bkgrnd_2[lmopt_bkgrnd_2]" 
	        value='<?=get_option('lmopt_bkgrnd_2_option');?>' 
	        size='20'
	    />
	    <?php
	}

	public function lmopt_bkgrnd_3(){
	    ?>
	    <input 
	        type="text" 
	        id="lmopt_bkgrnd_3" 
	        name="lowermedia_opt_bkgrnd_3[lmopt_bkgrnd_3]" 
	        value='<?=get_option('lmopt_bkgrnd_3_option');?>' 
	        size='20'
	    />
	    <?php
	}

	public function lmopt_bkgrnd_4(){
	    ?>
	    <input 
	        type="text" 
	        id="lmopt_bkgrnd_4" 
	        name="lowermedia_opt_bkgrnd_4[lmopt_bkgrnd_4]" 
	        value='<?=get_option('lmopt_bkgrnd_4_option');?>' 
	        size='20'
	    />
	    <?php
	}


/*--------------------*/

    public function check_numpages($input){//only accepts numbers

	    if(is_numeric($input['lmopt_numpages'])){
		    	$mid = $input['lmopt_numpages'];			
			    if(get_option('lmopt_numpages_option') === FALSE){
					add_option('lmopt_numpages_option', $mid);
			    }else{
					update_option('lmopt_numpages_option', $mid);
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
	        value='<?=get_option('lmopt_numpages_option');?>' 
	        size='1'
        />
        <?php
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


}

$lowermedia_one_page_theme_admin_options = new lowermedia_one_page_theme_admin_options();

/*############################################################################################
#
#   ADD WIDGET AREA OUTPUT TO THE END OF THE WP_HEAD (BEGINING OF BODY TAG)
#   //This function adds to the begining of the body tag
*/	

	function lowermedia_add_opt_styles() {
		//check if enabled option is selected
		
		$myvar = get_option('lmopt_numpages_option');
		$lmopt_styles='<style type="text/css" id="LowerMedia-opt-styles">';
		$setting_name='lmopt_bkgrnd_'.$myvar.'_option';
		
		if ($myvar != 0 ) {

			while ($myvar != 0) {

				if(get_option($setting_name)) {


							//$filename = 'lmopt-styles.css';
							$style_from_setting = get_option($setting_name);
							$lmopt_styles .='
								#lm-opt-'.$myvar.' { background: url("'.$style_from_setting.'") 50% 0 repeat fixed; }
							';
							//echo $myvar.':'.$lmopt_styles.'<br/>';
							$myvar--;

				}
			}
		}
		$lmopt_styles.='</style>';
		echo $lmopt_styles;
		// $output = $lmopt_styles;
		// echo '----'.$output.'-----'.$lmopt_styles;
		// return $output;
	}
	add_action('wp_head', 'lowermedia_add_opt_styles');

/* THE END */