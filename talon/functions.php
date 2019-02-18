<?php
/**
 * Talon functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Talon
 */

if ( ! function_exists( 'talon_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function talon_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Talon, use a find and replace
	 * to change 'talon' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'talon', get_template_directory() . '/languages' );

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
	add_image_size( 'talon-home-small', 200);
	add_image_size( 'talon-home-large', 280, 280, true );
	add_image_size( 'talon-blog-image', 690 );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'talon' ),
		//************** COMENTEI AQUI **************/
		//'footer'  => esc_html__( 'Footer', 'talon' ),		
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

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'talon_custom_background_args', array(
		'default-color' => 'fafbff',
		'default-image' => '',
	) ) );

	//Logo support
	add_theme_support( 'custom-logo', array(
		'height'      => 80,
		'width'       => 200,
		'flex-height' => true,
	) );	

	//aThemes Toolbox support
	add_theme_support( 'athemes-toolbox-post-types', array( 'clients', 'services', 'employees', 'projects', 'testimonials' ) );

}
endif;
add_action( 'after_setup_theme', 'talon_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function talon_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'talon_content_width', 1170 );
}
add_action( 'after_setup_theme', 'talon_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function talon_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'talon' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'talon' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="widget-title"><span>',
		'after_title'   => '</span></h3>',
	) );

	//Footer widget areas
	$widget_areas = get_theme_mod('footer_widget_areas', '3');
	for ($i=1; $i<=$widget_areas; $i++) {
		register_sidebar( array(
			'name'          => __( 'Footer ', 'talon' ) . $i,
			'id'            => 'footer-' . $i,
			'description'   => '',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
	}	
	
	//Register widgets
	register_widget( 'Athemes_Blog' );
	register_widget( 'Athemes_Clients' );
	register_widget( 'Athemes_Employees' );
	register_widget( 'Athemes_Portfolio' );
	register_widget( 'Athemes_Services' );
	register_widget( 'Athemes_Testimonials' );
	register_widget( 'Athemes_Button' );	
	register_widget( 'Athemes_Facts' );	
	register_widget( 'Athemes_Skills' );	
	register_widget( 'Athemes_Video' );	
	register_widget( 'Athemes_Separator' );	
	register_widget( 'Athemes_Image' );	
}
add_action( 'widgets_init', 'talon_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function talon_scripts() {
	wp_enqueue_style( 'talon-style', get_stylesheet_uri() );

	wp_enqueue_style( 'talon-fonts', esc_url( talon_fonts_url() ), array(), null );

	wp_enqueue_style( 'talon-icons', get_template_directory_uri() . '/icons/icons.min.css', array(), true );

	wp_enqueue_script( 'talon-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	wp_enqueue_script( 'talon-scripts', get_template_directory_uri() . '/js/scripts.min.js', array('jquery'), '', true );

	wp_enqueue_script( 'talon-main', get_template_directory_uri() . '/js/main.js', array('jquery'), '', true );
	
	wp_enqueue_script('masonry');

	wp_enqueue_script( 'talon-html5shiv', get_template_directory_uri() . '/js/html5shiv.js', array(), '', true );
    wp_script_add_data( 'talon-html5shiv', 'conditional', 'lt IE 9' );	

	$icons = get_theme_mod('icons_url');
	if ( $icons ) {
		wp_enqueue_style( 'talon-custom-icons', esc_url($icons), array(), true );
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'talon_scripts' );

/**
 * Enqueue Bootstrap
 */
function talon_enqueue_bootstrap() {
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap/bootstrap.min.css', array(), true );
}
add_action( 'wp_enqueue_scripts', 'talon_enqueue_bootstrap', 9 );

/**
 * Google Fonts - adapted from TwentySixteen
 *
 * Lets you load Google Fonts by adding only the name
 */
if ( ! function_exists( 'talon_fonts_url' ) ) :
function talon_fonts_url() {

	$fonts_url 		= '';
	$subsets   		= 'latin,latin-ext,cyrillic'; //Fallback for browsers with no unicode-range support
	$weights 		= get_theme_mod('font_weights', array( '400', '400italic', '600', '600italic' ));
	$weights 		= implode(',', $weights);
	$body_font 		= get_theme_mod('body_font_family', 'Open Sans');
	$headings_font 	= get_theme_mod('headings_font_family', 'Noto Sans');
	$fonts     		= array();
	$fonts[] 		= esc_attr($body_font) . ':' . esc_attr($weights);
	$fonts[] 		= esc_attr($headings_font) . ':' . esc_attr($weights);

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), 'https://fonts.googleapis.com/css' );
	}

	return $fonts_url;
}
endif;

/**
 * Customizer defaults
 */
if ( !function_exists('talon_customizer_defaults') ) :
function talon_customizer_defaults() {
	$defaults = array(
		//Colors
		'primary_color' 		=> '#7261ee',
		'site_title_color' 		=> '#2d3142',
		'site_desc_color' 		=> '#515d77',
		'site_header_color' 	=> '#ffffff',
		'menu_items_color'		=> '#4f5d75',
		'header_text_color'		=> '#ffffff',
		'header_subtext_color'	=> '#ffffff',
		'footer_bg_color'		=> '#2d3142',
		'footer_color'			=> '#4f5d75',
		'body_color'			=> '#4f5d75',
		//Slider
		'slider_speed'			=> '4000',
		'slide_image_1'			=> get_template_directory_uri() . '/images/slider_1.jpg',
		'slide_image_2'			=> get_template_directory_uri() . '/images/slider_2.jpg',
		'slide_image_3'			=> get_template_directory_uri() . '/images/slider_3.jpg',
		//Menu
		'sticky_menu'			=> 'sticky',
		'menu_style'			=> 'inline',
		//Header type
		'front_header_type'		=> 'has-slider',
		'site_header_type'		=> 'nothing',
		//Fonts
		'body_font_family'		=> 'Open Sans',
		'headings_font_family'	=> 'Noto Sans',
		'font_weights'			=> array( '400', '400italic', '600', '600italic' ),
		'exc_length'			=> '20',
		'site_title_size'		=> '36',
		'site_desc_size'		=> '16',
		'menu_items'			=> '13',
		'body_size'				=> '16',
		'so_widgets_title'		=> '30',
		'index_post_title'		=> '18',
		'single_post_title'		=> '36',
		'sidebar_widgets_title' => '18',
	);
	return $defaults;
}
endif;

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

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
 * aThemes Framework
 */
require get_template_directory() . '/inc/framework/widgets/loader.php';
require get_template_directory() . '/inc/framework/builder/page-builder.php';

/**
 * Styles
 */
require get_template_directory() . '/inc/styles.php';

/**
 * Functions
 */
require get_template_directory() . '/inc/functions/loader.php';

/**
 * Woocommerce
 */
require get_template_directory() . '/inc/woocommerce.php';

/**
 * Demo content
 */
require_once dirname( __FILE__ ) . '/inc/demo-content/setup.php';

/**
 * Recommended plugins
 */
require get_template_directory() . '/inc/class-tgm-plugin-activation.php';

function talon_register_required_plugins() {

	$plugins = array(

		array(
			'name'      => 'aThemes Toolbox',
			'slug'      => 'athemes-toolbox',
			'required'  => false,
		),
		array(
			'name'      => 'Page Builder',
			'slug'      => 'siteorigin-panels',
			'required'  => false,
		),		
	);

	$config = array(
		'id'           => 'talon',
		'default_path' => '',
		'menu'         => 'tgmpa-install-plugins',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => false,
		'message'      => '',
		'strings'      => array(
			'notice_can_install_recommended'  => _n_noop(
				/* translators: 1: plugin name(s). */
				'You need to install and activate the following plugin to use Talon as a business theme: %1$s.',
				'You need to install and activate the following plugins to use Talon as a business theme: %1$s.',
				'talon'
			),
		),
	);

	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'talon_register_required_plugins' );