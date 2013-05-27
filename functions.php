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
/*----------------------------*/
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
	    	<p>
				-Combine All Pages  OR<br/>
				-Activate home page as splash page  OR<br/>
				-Normal Setup<br/><br/>
				-upload background image?<br/>
				-header/footer on of switch<br/>
			</p>
	</div>
	<?php
    }
	
    public function page_init(){		
		register_setting('lowermedia-one-page-theme_option_group', 'lowermedia_opt_id', array($this, 'check_ID'));
		register_setting('lowermedia-one-page-theme_name', 'lowermedia_opt_name', array($this, 'check_name'));
		
        add_settings_section(
		    'setting_section_id',
		    'Text Field',
		    array($this, 'print_section_info'),
		    'lowermedia-one-page-theme'
		);	

		add_settings_section(
		    'setting_section_name',
		    'Check Box',
		    array($this, 'print_section_info'),
		    'lowermedia-one-page-theme'
		);	
		
		add_settings_field(
		    'some_id', 
		    'Some ID(Title)', 
		    array($this, 'create_an_id_field'), 
		    'lowermedia-one-page-theme',
		    'setting_section_id'			
		);

		add_settings_field(
		    'some_name', 
		    'Some Name(Name)', 
		    array($this, 'create_a_name_field'), 
		    'lowermedia-one-page-theme',
		    'setting_section_name'			
		);		
    }
	
  //   public function check_ID($input){
  //       if(is_numeric($input['some_id'])){
	 //    	$mid = $input['some_id'];			
		//     if(get_option('test_some_id') === FALSE){
		// 		add_option('test_some_id', $mid);
		//     }else{
		// 		update_option('test_some_id', $mid);
		//     }
		// }else{
		//     $mid = '';
		// }
		// return $mid;
  //   }

     public function check_ID($input){
        if(is_numeric($input['some_id'])){
	    $mid = $input['some_id'];			
	    if(get_option('test_some_id') === FALSE){
		add_option('test_some_id', $mid);
	    }else{
		update_option('test_some_id', $mid);
	    }
	}else{
	    $mid = '';
	}
	return $mid;
    }

    public function check_name($input){
	    if($input['some_name']==1){
		    $mname = 'checked';			
		    if(get_option('test_some_name') === FALSE){
				add_option('test_some_name', $mname);
		    }else{
				update_option('test_some_name', $mname);
		    }
		}else{
		    $mname = '';
		}
		return $mname;
    }
	
    public function print_section_info(){
	print 'Enter your setting below:';
    }
	
    public function create_an_id_field(){
        ?><input type="text" id="input_whatever_unique_id_I_want" name="lowermedia_opt_id[some_id]" value='<?=get_option('test_some_id');?>' /><?php
    }

    public function create_a_name_field(){
        ?><input type="checkbox" id="input_whatever_unique_name_I_want" name="lowermedia_opt_name[some_name]" value="<?=get_option('test_some_name');?>" />
		<!-- <input 
			id="input_whatever_unique_name_I_want"
			name="array_key[some_name]" 
			type="checkbox" 
			value="1" 
			<?php# if ( $input['some_name'] ) echo 'checked="checked"'; ?>
		/> -->
        <?php
    }
}

$lowermedia_one_page_theme_admin_options = new lowermedia_one_page_theme_admin_options();