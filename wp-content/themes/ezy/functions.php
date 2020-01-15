<?php
/**
 * ezy functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ezy
 */
if ( ! function_exists( 'ezy_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function ezy_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on ezy, use a find and replace
	 * to change 'ezy' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'ezy' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	add_image_size( 'ezy-promo-post', 360, 261, array( 'top', 'bottom' ) ); //300 pixels wide (and unlimited height)

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Main Menu', 'ezy' ),
		'social'  => esc_html__( 'Social Menu', 'ezy' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );
	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'status',
		'audio',
		'chat',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'ezy_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'ezy_setup' );


/*
	 * Custom Logo implemeted from WordPress Core
	 */

	add_theme_support( 'custom-logo', array(
            'height'      => 70,
            'width'       => 290,
            'flex-height' => true,
            'flex-width' => true
        ) );


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function ezy_content_width() {
	
	$GLOBALS['content_width'] = apply_filters( 'ezy_content_width', 640 );
}
add_action( 'after_setup_theme', 'ezy_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function ezy_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'ezy' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'ezy' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer 1', 'ezy' ),
		'id'            => 'footer-1',
		'description'   => esc_html__( 'Add widgets here', 'ezy' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer 2', 'ezy' ),
		'id'            => 'footer-2',
		'description'   => esc_html__( 'Add widgets here', 'ezy' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer 3', 'ezy' ),
		'id'            => 'footer-3',
		'description'   => esc_html__( 'Add widgets here', 'ezy' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer 4', 'ezy' ),
		'id'            => 'footer-4',
		'description'   => esc_html__( 'Add widgets here', 'ezy' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title"><span>',
		'after_title'   => '</span></h2>',
	) );
}
add_action( 'widgets_init', 'ezy_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function ezy_scripts() {
	/*google font  */
	global $ezy_theme_options;
	
	$font_family_url = esc_url($ezy_theme_options['ezy-font-family-url']);
	if(!empty($font_family_url)):
	wp_enqueue_style( 'ezy-googleapis', $font_family_url, array(), null, false, 'all' );
    endif;

	/*Font-Awesome-master*/
    wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/framework/Font-Awesome/css/font-awesome.min.css', array(), '4.5.0' );
	
	/*Bootstrap CSS*/
    wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/framework/bootstrap/css/bootstrap.min.css', array(), '4.5.0' );
	
	/*Owl CSS*/
    wp_enqueue_style( 'owl-carousel', get_template_directory_uri() . '/assets/framework/owl-carousel/owl.carousel.css', array(), '4.5.0' );
   
    wp_enqueue_style( 'owl-transitions', get_template_directory_uri() . '/assets/framework/owl-carousel/owl.transitions.css', array(), '4.5.0' );
	
	/*Fancybox CSS*/
    wp_enqueue_style( 'fancybox', get_template_directory_uri() . '/assets/framework/fancybox/css/jquery.fancybox.css', array(), '4.5.0' );
  
	/*Style CSS*/
	wp_enqueue_style( 'ezy-style', get_stylesheet_uri() );

	
    /*Bootstrap JS*/
    wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/framework/bootstrap/js/bootstrap.min.js', array('jquery'), '4.5.0' );
	
	
	/*navigation JS*/
	wp_enqueue_script( 'ezy-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array('jquery'), '20151215', true );

	/*owl*/
    wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/assets/framework/owl-carousel/owl.carousel.min.js', array('jquery'), '4.5.0' );
	
	/*Fancybox*/
    wp_enqueue_script( 'fancybox', get_template_directory_uri() . '/assets/framework/fancybox/js/jquery.fancybox.pack.js', array('jquery'), '4.5.0' );

  
	/*Sticky Sidebar*/
	 global $ezy_theme_options;
	 $ezy_theme_options    = ezy_get_theme_options();
     $ezy_sticky_sidebar = $ezy_theme_options['ezy-sticky-sidebar-option'];
	
	if( $ezy_sticky_sidebar == 1 ){
	 
	 wp_enqueue_script( 'theia-sticky-sidebar', get_template_directory_uri() . '/assets/framework/sticky-sidebar/theia-sticky-sidebar.js', array('jquery'), '4.5.0' );

      /*Custom Sticky Sidebar JS*/
	  wp_enqueue_script( 'ezy-custom-sticky-sidebar', get_template_directory_uri() . '/assets/js/custom-sticky-sidebar.js', array('jquery'), '1.0.0' );
	
	} 

	/*Custom JS*/
	wp_enqueue_script( 'ezy-scripts', get_template_directory_uri() . '/assets/js/scripts.js', array('jquery'), '4.5.0' );


	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ezy_scripts' );


/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';


/**
 * Load theme-function  file.
 */
require get_template_directory() . '/inc/theme-function.php';

/**
 * Load Custom widget File.
 */
require get_template_directory() . '/inc/custom-widget/ct-author-widget.php';
require get_template_directory() . '/inc/custom-widget/ct-social-widget.php';
require get_template_directory() . '/inc/custom-widget/ct-featured-post-widget.php';

/**
 * Load hooks files
*/
require get_template_directory() . '/inc/hooks/header.php';

/**
 * Load hooks files
*/
require get_template_directory() . '/inc/hooks/footer.php';

/**
 * Load hooks files
*/
require get_template_directory() . '/inc/hooks/related-posts.php';