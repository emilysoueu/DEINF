<?php

function onetone_setup(){

  global $content_width, $onetone_options, $onetone_options_default, $onetone_options_db;
  
  // optoions stored in database
  $option_name     = onetone_option_name();
  $onetone_options = get_option($option_name);
  $onetone_options_db = $onetone_options;
  
  $default_options = onetone_get_default_options();
  if($onetone_options)
  	$onetone_options = array_merge($default_options,$onetone_options);
  else
  	$onetone_options = $default_options;
	
	$lang = get_template_directory(). '/languages';
	load_theme_textdomain('onetone',$lang);
	add_theme_support( 'post-thumbnails' ); 
	$args = array();
	$header_args = array( 
	    'default-image'          => '',
		 'default-repeat' => 'repeat',
        'default-text-color'     => '333333',
        'width'                  => 1120,
        'height'                 => 80,
        'flex-height'            => true
     );

	// Enable support for Post Formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio' ) );
	add_theme_support( 'custom-background', $args );
	add_theme_support( 'custom-header', $header_args );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support('nav_menus');
	add_theme_support( "title-tag" );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'onetone' ),
		'home_menu' => __( 'Home Page Header Menu', 'onetone' ),
		'top_bar_menu' => __( 'Top Bar Menu', 'onetone' ),
		'custom_menu_1' => __( 'Custom Menu 1', 'onetone' ),
		'custom_menu_2' => __( 'Custom Menu 2', 'onetone' ),
		'custom_menu_3' => __( 'Custom Menu 3', 'onetone' ),
		'custom_menu_4' => __( 'Custom Menu 4', 'onetone' ),
		'custom_menu_5' => __( 'Custom Menu 5', 'onetone' ),
		'custom_menu_6' => __( 'Custom Menu 6', 'onetone' ),
											  
	));
	
	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'gallery',
		'caption',
	) );

	// Woocommerce Support
	add_theme_support( 'woocommerce' );

	add_editor_style("editor-style.css");
	if ( ! isset( $content_width ) ) $content_width = 1120;
	
}

add_action( 'after_setup_theme', 'onetone_setup' );

/**
 * Enqueue frontend scripts and styles.
 */
function onetone_custom_scripts(){
	
	global $onetone_page_meta,$post,$shop_style, $onetone_home_sections, $onetone_options;
	
	if($post){
		$onetone_page_meta = get_post_meta( $post->ID ,'_onetone_post_meta');
	}	
	$onetone_home_sections = onetone_section_templates();
	
	if( isset($onetone_page_meta[0]) && $onetone_page_meta[0]!='' )
		$onetone_page_meta = json_decode( $onetone_page_meta[0],true );
	
	$theme_info = wp_get_theme();	
	
	$google_fonts = onetone_option('google_fonts');
   
	if( trim($google_fonts) !='' ){
		$google_fonts = str_replace(' ','+',trim($google_fonts));
		wp_enqueue_style('onetone-google-fonts', esc_url('//fonts.googleapis.com/css?family='.$google_fonts), false, '', false );
	}
	
	wp_enqueue_style('font-awesome',  get_template_directory_uri() .'/plugins/font-awesome/css/font-awesome.min.css', false, '4.3.0', false);
	wp_enqueue_style('bootstrap',  get_template_directory_uri() .'/plugins/bootstrap/css/bootstrap.min.css', false, '3.3.4', false);
	wp_enqueue_style( 'owl-carousel',  get_template_directory_uri() .'/plugins/owl-carousel/assets/owl.carousel.css', false, '2.2.0', false );
	wp_enqueue_style('magnific-popup',  get_template_directory_uri() .'/plugins/magnific-popup/magnific-popup.css', false, '3.1.5', false);
	
	if( !onetone_is_plugin_active('magee-shortcodes/Magee.php') ){
	wp_enqueue_style('onetone-shortcodes',  get_template_directory_uri() .'/css/shortcode.css', false, $theme_info->get( 'Version' ), false);
    }
	wp_enqueue_style('onetone-animate',  get_template_directory_uri() .'/css/animate.css', false, '3.5.1', false);
	
	wp_enqueue_style( 'onetone-main', get_stylesheet_uri(), array(), $theme_info->get( 'Version' ) );
	wp_enqueue_style('onetone-onetone',  get_template_directory_uri() .'/css/onetone.css', false, $theme_info->get( 'Version' ), false);
	if ( class_exists( 'WooCommerce' ) ) {
		wp_enqueue_style('onetone-woocommerce',  get_template_directory_uri() .'/css/woo.css', false, $theme_info->get( 'Version' ), false);
	}


	wp_enqueue_style('onetone-ms',  get_template_directory_uri() .'/css/onetone-ms.css', false, $theme_info->get( 'Version' ), false);
	wp_enqueue_style('onetone-home',  get_template_directory_uri() .'/css/home.css', false, $theme_info->get( 'Version' ), false);
	
	$is_rtl = false;
	if ( is_rtl() ) {
       wp_enqueue_style('onetone-rtl',  get_template_directory_uri() .'/rtl.css', false, $theme_info->get( 'Version' ), false);
	   $is_rtl = true;
     }
	
	$header_image       = get_header_image();
	$onetone_custom_css = "";

	if (isset($header_image) && ! empty( $header_image )) {
		$onetone_custom_css .= ".home-header{background:url(".esc_url($header_image). ") repeat;}\n";
	}
	if ( 'blank' != get_header_textcolor() && '' != get_header_textcolor() ){
		$header_color        =  ' color:#' . sanitize_hex_color(get_header_textcolor()) . ';';
		$onetone_custom_css .=  'header .site-name,header .site-description,header .site-tagline{'.$header_color.'}';
	}else{
		$onetone_custom_css .=  'header .site-name,header .site-description,header .site-tagline{display:none;}';	
	}
		
	$custom_css  =  onetone_option("custom_css");
	$links_color = onetone_option( 'links_color','#37cadd');
	
	//scheme
	$primary_color = sanitize_hex_color(onetone_option('primary_color',$links_color));	
	
	$links_color   = onetone_option( 'links_color');
	
	if($links_color )
		$onetone_custom_css  .=  '.entry-content a,.home-section-content a{color:'.sanitize_hex_color($links_color).' ;}';

	$top_menu_font_color = onetone_option( 'font_color');
	
	if($top_menu_font_color !="" && $top_menu_font_color!=null){
		$onetone_custom_css  .=  'header .site-nav > ul > li > a {color:'.sanitize_hex_color($top_menu_font_color).'}';
	}
		
	// header
	$sticky_header_background_color    = esc_attr(onetone_option('sticky_header_background_color',''));
    $sticky_header_background_opacity  = esc_attr(onetone_option('sticky_header_background_opacity','1')); 
	$header_border_color               = esc_attr(onetone_option('header_border_color','')); 
	$page_title_bar_background_color   = esc_attr(onetone_option('page_title_bar_background_color','')); 
	$page_title_bar_borders_color      = esc_attr(onetone_option('page_title_bar_borders_color','')); 
	$top_bar_social_icons_color        = esc_attr(onetone_option('top_bar_social_icons_color')); 
	
	// top bar icon color
	if($top_bar_social_icons_color){
		$onetone_custom_css .= ".top-bar-sns li i{color: ".$top_bar_social_icons_color.";}";}
		
	// sticky header background
	if($sticky_header_background_color){
		$rgb = onetone_hex2rgb( $sticky_header_background_color );
	    $onetone_custom_css .= ".fxd-header {background-color: rgba(".$rgb[0].",".$rgb[1].",".$rgb[2].",".esc_attr($sticky_header_background_opacity).");}";
	}
	
	// sticky header
	$sticky_header_opacity               =  onetone_option('sticky_header_background_opacity','1');
	$sticky_header_menu_item_padding     =  onetone_option('sticky_header_menu_item_padding','');
	$sticky_header_navigation_font_size  =  onetone_option('sticky_header_navigation_font_size','');
	$sticky_header_logo_width            =  onetone_option('sticky_header_logo_width','');
	$logo_left_margin                    =  onetone_option('logo_left_margin','');
	$logo_right_margin                   =  onetone_option('logo_right_margin','');
	$logo_top_margin                     =  onetone_option('logo_top_margin','');
	$logo_bottom_margin                  =  onetone_option('logo_bottom_margin','');
		
	if( $sticky_header_background_color ){
		$rgb = onetone_hex2rgb( $sticky_header_background_color );
	    $onetone_custom_css .= ".fxd-header{background-color: rgba(".$rgb[0].",".$rgb[1].",".$rgb[2].",".esc_attr($sticky_header_opacity).");}";
	}
	
    if( $sticky_header_menu_item_padding )
		$onetone_custom_css .= ".fxd-header .site-nav > ul > li > a {padding:".absint($sticky_header_menu_item_padding)."px;}";
	  
	if( $sticky_header_navigation_font_size )
		$onetone_custom_css .= ".fxd-header .site-nav > ul > li > a {font-size:".absint($sticky_header_navigation_font_size)."px;}";
	  
	if( $sticky_header_logo_width )
		$onetone_custom_css .= ".fxd-header img.site-logo{ width:".absint($sticky_header_logo_width)."px;}";
	
	if( $logo_left_margin )
		$onetone_custom_css .= "img.site-logo{ margin-left:".absint($logo_left_margin)."px;}";
	  
	if( $logo_right_margin )
		$onetone_custom_css .= "img.site-logo{ margin-right:".absint($logo_right_margin)."px;}";
	  
	if( $logo_top_margin )
		$onetone_custom_css .= "img.site-logo{ margin-top:".absint($logo_top_margin)."px;}";
	  
	if( $logo_bottom_margin )
		$onetone_custom_css .= "img.site-logo{ margin-bottom:".absint($logo_bottom_margin)."px;}";
	
	// top bar
	$display_top_bar             = onetone_option('display_top_bar','yes');
	$top_bar_background_color    = onetone_option('top_bar_background_color','');
	$top_bar_info_color          = onetone_option('top_bar_info_color','');
	$top_bar_menu_color          = onetone_option('top_bar_menu_color','');
	
	if( $top_bar_background_color )
		$onetone_custom_css .= ".top-bar{background-color:".sanitize_hex_color($top_bar_background_color).";}";
	
	if( $display_top_bar == 'yes' )
		$onetone_custom_css .= ".top-bar{display:block;}";
	
	if( $top_bar_info_color  )
		$onetone_custom_css .= ".top-bar-info{color:".sanitize_hex_color($top_bar_info_color).";}";
	
	if( $top_bar_menu_color  )
		$onetone_custom_css .= ".top-bar ul li a{color:".sanitize_hex_color($top_bar_menu_color).";}";
	
	// Header background
	$header_background_parallax  = onetone_option('header_background_parallax','');
	$header_background           = '';
	
	if( $header_background_parallax ){
		$header_background  .= "header .main-header{";
		$header_background  .= "background-attachment: fixed;background-position:top center;background-repeat: no-repeat;";
		$header_background  .= "}";	
	}
	
	$onetone_custom_css .= $header_background;
	
	// Header  Padding
	$header_top_padding     = onetone_option('header_top_padding','');
	$header_bottom_padding  = onetone_option('header_bottom_padding','');
	
	if( $header_top_padding )
		$onetone_custom_css .= ".site-nav > ul > li > a{padding-top:".esc_attr($header_top_padding)."}";
	
	if( $header_bottom_padding )
		$onetone_custom_css .= ".site-nav > ul > li > a{padding-bottom:".esc_attr($header_bottom_padding)."}";
	

	// page title bar

	$page_title_bar_top_padding           = esc_attr(onetone_option('page_title_bar_top_padding'));
	$page_title_bar_bottom_padding        = esc_attr(onetone_option('page_title_bar_bottom_padding'));
	$page_title_bar_mobile_top_padding    = esc_attr(onetone_option('page_title_bar_mobile_top_padding'));
	$page_title_bar_mobile_bottom_padding = esc_attr(onetone_option('page_title_bar_mobile_bottom_padding'));
	$page_title_bg_parallax               = esc_attr(onetone_option('page_title_bg_parallax'));
		
	$page_title_bar_background  = '';
	
	if( $page_title_bg_parallax  == 'yes' || $page_title_bg_parallax  == '1' ){
	     $page_title_bar_background  .= ".page-title-bar,.page-title-bar-retina{background-attachment: fixed;background-position:top center;background-repeat: no-repeat;";
								
        $page_title_bar_background  .= "}";	
	}
	
	$onetone_custom_css .=  $page_title_bar_background ;
	
	
	$onetone_custom_css .= ".page-title-bar{padding-top:".$page_title_bar_top_padding .";padding-bottom:".$page_title_bar_bottom_padding .";}";
			
	$onetone_custom_css .= "@media (max-width: 719px) {.page-title-bar{padding-top:".$page_title_bar_mobile_top_padding .";padding-bottom:".$page_title_bar_mobile_bottom_padding .";}}";


	$content_background_color          = sanitize_hex_color(onetone_option('content_background_color',''));
	$sidebar_background_color          = sanitize_hex_color(onetone_option('sidebar_background_color',''));
	$footer_background_color           = sanitize_hex_color(onetone_option('footer_background_color',''));
	$copyright_background_color        = sanitize_hex_color(onetone_option('copyright_background_color',''));
		
	// content backgroud color
		
	if( $content_background_color )
		$onetone_custom_css  .= ".col-main {background-color:".$content_background_color.";}";
	 
	if( $sidebar_background_color )
		$onetone_custom_css  .= ".col-aside-left,.col-aside-right {background-color:".$sidebar_background_color.";}";
	
	//footer background
	if( $footer_background_color )
		$onetone_custom_css  .= "footer .footer-widget-area{background-color:".$footer_background_color.";}";
	 
	if( $copyright_background_color )
		$onetone_custom_css  .= "footer .footer-info-area{background-color:".$copyright_background_color."}";
	 
	// Element Colors
	
	$form_background_color = sanitize_hex_color(onetone_option('form_background_color',''));
	$form_text_color       = sanitize_hex_color(onetone_option('form_text_color',''));
	$form_border_color     = sanitize_hex_color(onetone_option('form_border_color',''));
	
	if( $form_background_color )
		$onetone_custom_css  .= "footer input,footer textarea{background-color:".$form_background_color.";}";
	
	if( $form_text_color )
		$onetone_custom_css  .= "footer input,footer textarea{color:".$form_text_color.";}";
	
	if( $form_border_color )
		$onetone_custom_css  .= "footer input,footer textarea{border-color:".$form_border_color.";}";

	//Layout Options
	
	$page_content_top_padding          = esc_attr(onetone_option('page_content_top_padding',''));
	$page_content_bottom_padding       = esc_attr(onetone_option('page_content_bottom_padding',''));
	$hundredp_padding                  = esc_attr(onetone_option('hundredp_padding',''));
	$sidebar_padding                   = esc_attr(onetone_option('sidebar_padding',''));
	$column_top_margin                 = esc_attr(onetone_option('column_top_margin',''));
	$column_bottom_margin              = esc_attr(onetone_option('column_bottom_margin',''));
	
	if( $page_content_top_padding )
		$onetone_custom_css  .= ".post-inner,.page-inner{padding-top:".$page_content_top_padding.";}";
	
	if( $page_content_bottom_padding )
		$onetone_custom_css  .= ".post-inner,.page-inner{padding-bottom:".$page_content_bottom_padding.";}";
	
	if( isset($onetone_page_meta['padding_top']) && $onetone_page_meta['padding_top'] !='' )
		$onetone_custom_css  .= ".post-inner,.page-inner{padding-top:".esc_attr($onetone_page_meta['padding_top']).";}";
	
	if( isset($onetone_page_meta['padding_bottom']) && $onetone_page_meta['padding_bottom'] !='' )
		$onetone_custom_css  .= ".post-inner,.page-inner{padding-bottom:".esc_attr($onetone_page_meta['padding_bottom']).";}";
		
	if( $sidebar_padding )
		$onetone_custom_css  .= ".col-aside-left,.col-aside-right{padding:".$sidebar_padding.";}";
	
	if( $column_top_margin )
		$onetone_custom_css  .= ".col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9{margin-top:".$column_top_margin.";}";
	
	if( $column_bottom_margin )
		$onetone_custom_css  .= ".col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9{margin-bottom:".$column_bottom_margin.";}";
	
	//fonts color
	
	$fixed_header_text_color           = sanitize_hex_color(onetone_option('fixed_header_text_color'));
	$overlay_header_text_color         = sanitize_hex_color(onetone_option('overlay_header_text_color'));
	$page_title_color                  = sanitize_hex_color(onetone_option('page_title_color',''));
	$h1_color                          = sanitize_hex_color(onetone_option('h1_color',''));
	$h2_color                          = sanitize_hex_color(onetone_option('h2_color',''));
	$h3_color                          = sanitize_hex_color(onetone_option('h3_color',''));
	$h4_color                          = sanitize_hex_color(onetone_option('h4_color',''));
	$h5_color                          = sanitize_hex_color(onetone_option('h5_color',''));
	$h6_color                          = sanitize_hex_color(onetone_option('h6_color',''));
	$body_text_color                   = sanitize_hex_color(onetone_option('body_text_color',''));
	$link_color                        = sanitize_hex_color(onetone_option('link_color',''));
	$breadcrumbs_text_color            = sanitize_hex_color(onetone_option('breadcrumbs_text_color',''));
	$sidebar_widget_headings_color     = sanitize_hex_color(onetone_option('sidebar_widget_headings_color',''));
	$footer_headings_color             = sanitize_hex_color(onetone_option('footer_headings_color',''));
	$footer_text_color                 = sanitize_hex_color(onetone_option('footer_text_color'));
	$footer_link_color                 = sanitize_hex_color(onetone_option('footer_link_color'));
	
	if( $fixed_header_text_color )
		$onetone_custom_css  .= ".fxd-header .site-tagline,.fxd-header .site-name{color:".$fixed_header_text_color.";}";
	
	if( $overlay_header_text_color )
		$onetone_custom_css  .= "header.overlay .main-header .site-tagline,header.overlay .main-header .site-name{color:".$overlay_header_text_color.";}";
	
	if( $page_title_color )
		$onetone_custom_css  .= ".page-title h1{color:".$page_title_color.";}";
	if( $h1_color )
		$onetone_custom_css  .= "h1{color:".$h1_color.";}";
	if( $h2_color )
		$onetone_custom_css  .= "h2{color:".$h2_color.";}";
	if( $h3_color )
		$onetone_custom_css  .= "h3{color:".$h3_color.";}";
	if( $h4_color )
		$onetone_custom_css  .= "h4{color:".$h4_color.";}";
	if( $h5_color )
		$onetone_custom_css  .= "h5{color:".$h5_color.";}";
	if( $h6_color )
		$onetone_custom_css  .= "h6{color:".$h6_color.";}";
	
	if( $body_text_color )
		$onetone_custom_css  .= ".entry-content,.entry-content p{color:".$body_text_color.";}";
	
	if( $link_color )
		$onetone_custom_css  .= ".entry-summary a, .entry-content a{color:".$link_color.";}";
	
	if( $breadcrumbs_text_color )
		$onetone_custom_css  .= ".breadcrumb-nav span,.breadcrumb-nav a{color:".$breadcrumbs_text_color.";}";
	
	if( $sidebar_widget_headings_color )
		$onetone_custom_css  .= ".col-aside-left .widget-title,.col-aside-right .widget-title{color:".$sidebar_widget_headings_color.";}";
	
	if( $footer_headings_color )
		$onetone_custom_css  .= ".footer-widget-area .widget-title{color:".$footer_headings_color.";}";
	
	if( $footer_text_color )
		$onetone_custom_css  .= "footer,footer p,footer span,footer div{color:".$footer_text_color.";}";
	
	if( $footer_link_color )
		$onetone_custom_css  .= "footer a{color:".$footer_link_color.";}";
	
	//Main Menu Colors 
	$menu_toggle_color              = sanitize_hex_color(onetone_option('menu_toggle_color'));
	$main_menu_background_color_1   = sanitize_hex_color(onetone_option('main_menu_background_color_1',''));
	$main_menu_font_color_1         = sanitize_hex_color(onetone_option('main_menu_font_color_1',''));
	$main_menu_overlay_font_color_1 = sanitize_hex_color(onetone_option('main_menu_overlay_font_color_1',''));
	$main_menu_font_hover_color_1   = sanitize_hex_color(onetone_option('main_menu_font_hover_color_1',''));
	$main_menu_background_color_2   = sanitize_hex_color(onetone_option('main_menu_background_color_2',''));
	$main_menu_font_color_2         = sanitize_hex_color(onetone_option('main_menu_font_color_2',''));
	$main_menu_font_hover_color_2   = sanitize_hex_color(onetone_option('main_menu_font_hover_color_2',''));
	$main_menu_separator_color_2    = sanitize_hex_color(onetone_option('main_menu_separator_color_2',''));
	$woo_cart_menu_background_color = sanitize_hex_color(onetone_option('woo_cart_menu_background_color',''));
	$side_menu_color                = sanitize_hex_color(onetone_option('side_menu_color'));
	
	
	if( $menu_toggle_color )
		$onetone_custom_css  .= ".main-header .site-nav-toggle i{ color:".$menu_toggle_color.";}";
	
	if( $main_menu_background_color_1 )
		$onetone_custom_css  .= ".main-header .site-nav{ background-color:".$main_menu_background_color_1.";}";
	
	if( $main_menu_font_color_1 )
		$onetone_custom_css  .= "#menu-main > li > a {color:".$main_menu_font_color_1.";}";
	
	if( $main_menu_overlay_font_color_1 )
		$onetone_custom_css  .= "header.overlay .main-header #menu-main > li > a {color:".$main_menu_overlay_font_color_1.";}";
	
	if( $main_menu_font_hover_color_1 )
		$onetone_custom_css  .= "#menu-main > li > a:hover,#menu-main > li.current > a{color:".$main_menu_font_hover_color_1.";}";
	
	if( $main_menu_background_color_2 )
		$onetone_custom_css  .= ".main-header .sub-menu{background-color:".$main_menu_background_color_2.";}";
		$onetone_custom_css  .= ".fxd-header .sub-menu{background-color:".$main_menu_background_color_2.";}";
	
	if( $main_menu_font_color_2 )
		$onetone_custom_css  .= "#menu-main  li li a{color:".$main_menu_font_color_2.";}";
	if( $main_menu_font_hover_color_2 )
		$onetone_custom_css  .= "#menu-main  li li a:hover{color:".$main_menu_font_hover_color_2.";}";
	if( $main_menu_separator_color_2 )
		$onetone_custom_css  .= ".site-nav  ul li li a{border-color:".$main_menu_separator_color_2." !important;}";
	
	if( $side_menu_color )
		$onetone_custom_css  .= "@media screen and (min-width: 920px) {.onetone-dots li a {border: 2px solid ".$side_menu_color.";}		.onetone-dots li.active a,.onetone-dots li.current a,.onetone-dots li a:hover {background-color: ".$side_menu_color.";}}";
		
	$onetone_custom_css  .= "@media screen and (max-width: 920px) {.site-nav ul{ background-color:".$main_menu_background_color_2.";}#menu-main  li a,header.overlay .main-header #menu-main > li > a {color:".$main_menu_font_color_2.";}.site-nav  ul li a{border-color:".$main_menu_separator_color_2." !important;}}";


	// home page sections
	$section_title_css   = '';
	$section_content_css = '';

    /*header background*/
	$section_css        = '';
	$header_background  = onetone_option( 'header_background' );
	if(!empty($header_background) && is_array($header_background)){
	  foreach( $header_background as $key => $value ){
		  if($key == 'background-image')
		  	$value = "url(".esc_url($value).")";
		  $section_css .= esc_attr($key).":".esc_attr($value).";";
		  }
	}
	$section_content_css .=  "header .main-header{".$section_css."}";
	
	/*page title bar background*/
	$section_css        = '';
	$page_title_bar_background1  = onetone_option( 'page_title_bar_background1' );
	if(!empty($page_title_bar_background1) && is_array($page_title_bar_background1)){
	  foreach( $page_title_bar_background1 as $key => $value ){
		  if($key == 'background-image')
		  	$value = "url(".esc_url($value).")";
		  	$section_css .= esc_attr($key).":".esc_attr($value).";";
		  }
	}
	$section_content_css .=  ".page-title-bar{".$section_css."}";
	
	/*page title bar retina background*/
	$section_css        = '';
	$page_title_bar_retina_background1  = onetone_option( 'page_title_bar_retina_background1' );
	if(!empty($page_title_bar_retina_background1) && is_array($page_title_bar_retina_background1)){
	  foreach( $page_title_bar_retina_background1 as $key => $value ){
		  if($key == 'background-image')
		  	$value = "url(".esc_url($value).")";
		  $section_css .= esc_attr($key).":".esc_attr($value).";";
		  }
	}
	$section_content_css .=  ".page-title-bar-retina{".$section_css."}";
	
	/* body font typography*/
	$site_body_font  = onetone_option( 'site_body_font' );
	$section_css     = '';

	if(!empty($site_body_font) && is_array($site_body_font)){
	  foreach( $site_body_font as $key => $value ){
		  
		  if($key == 'subsets'){
			if ( is_array( $value ) ) {
				$section_css .= esc_attr($key).":".esc_attr(implode( ', ', $value )).";";
			} else {
				$section_css .= esc_attr($key).":".esc_attr($value).";";
			}
		}
		else
		  $section_css .= $key.":".htmlspecialchars_decode(rtrim($value, ', '),ENT_QUOTES).";";
		  }
	}
	$section_content_css .=  "body,button,input,select,textarea{".$section_css."}";
	
	/* site menu typography*/
	$site_body_font  = onetone_option( 'site_menu_font' );
	$section_css     = '';
	if(!empty($site_menu_font) && is_array($site_menu_font)){
	  foreach( $site_menu_font as $key => $value ){
		  if($key == 'subsets'){
			if ( is_array( $value ) ) {
				$section_css .= esc_attr($key).":".esc_attr(implode( ', ', $value )).";";
			} else {
				$section_css .= esc_attr($key).":".esc_attr($value).";";
			}
		}
		else
		  $section_css .= esc_attr($key).":".htmlspecialchars_decode(rtrim($value, ', '),ENT_QUOTES).";";
		  }
	}
	$section_content_css .=  "#menu-main li a span{".$section_css."}";
	
	/* site headings font*/
	$site_headings_font  = onetone_option( 'site_headings_font' );
	$section_css         = '';
	if(!empty($site_headings_font) && is_array($site_headings_font)){
	  foreach( $site_headings_font as $key => $value ){
		  if($key == 'subsets'){
			if ( is_array( $value ) ) {
				$section_css .= esc_attr($key).":".esc_attr(implode( ', ', $value )).";";
			} else {
				$section_css .= esc_attr($key).":".htmlspecialchars_decode(rtrim($value, ', '),ENT_QUOTES).";";
			}
		}
		else
		  $section_css .= esc_attr($key).":".esc_attr($value).";";
		  }
	}
	
	$section_content_css .=  "h1,h2,h3,h4,h5,h6{".$section_css."}";
	
	/* site footer headings font*/
	$site_footer_headings_font  = onetone_option( 'site_footer_headings_font' );
	$section_css        = '';
	if(!empty($site_footer_headings_font) && is_array($site_footer_headings_font)){
	  foreach( $site_footer_headings_font as $key => $value ){
		  if($key == 'subsets'){
			if ( is_array( $value ) ) {
				$section_css .= esc_attr($key).":".esc_attr(implode( ', ', $value )).";";
			} else {
				$section_css .= esc_attr($key).":".esc_attr($value).";";
			}
		}
		else
		  $section_css .= esc_attr($key).":".htmlspecialchars_decode(rtrim($value, ', '),ENT_QUOTES).";";
		  }
	}
	$section_content_css .=  "footer h1,footer h2,footer h3,footer h4,footer h5,footer h6{".$section_css."}";
	
	/* site button font*/
	$site_button_font  = onetone_option( 'site_button_font' );
	$section_css        = '';
	if(!empty($site_button_font) && is_array($site_button_font)){
	  foreach( $site_button_font as $key => $value ){
		  if($key == 'subsets'){
			if ( is_array( $value ) ) {
				$section_css .= esc_attr($key).":".esc_attr(implode( ', ', $value )).";";
			} else {
				$section_css .= esc_attr($key).":".esc_attr($value).";";
			}
		}
		else
		  $section_css .= esc_attr($key).":".htmlspecialchars_decode(rtrim($value, ', '),ENT_QUOTES).";";
		  }
	}
	$section_content_css .=  "a.btn-normal{".$section_css."}";
	
	/*footer background*/
	$section_css        = '';
	$footer_background  = onetone_option( 'footer_background' );
	if(!empty($footer_background) && is_array($footer_background)){
	  foreach( $footer_background as $key => $value ){
		  if($key == 'background-image')
		  	$value = "url(".esc_url($value).")";
		  	$section_css .= esc_attr($key).":".esc_attr($value).";";
		  }
	}
	
	$section_content_css .=  ".footer-widget-area{".$section_css."}";
	
	$video_background_section  = onetone_option( 'video_background_section' );
	$home_sections             = onetone_option('section_order');
			
	if( $home_sections !='' && count($home_sections)>0 ){
		$onetone_home_sections = $home_sections;
	}
	
	if ( is_page_template('template-home.php') ){
		foreach( $onetone_home_sections as $k => $v ){
		
	$i = $v['id'];
	$title_typography    = onetone_option( 'section_title_typography1_'.$i );
	$subtitle_typography = onetone_option( 'section_subtitle_typography1_'.$i );
	$content_typography  = onetone_option( 'section_content_typography1_'.$i );
	$section_background  = onetone_option( 'section_background1_'.$i );
	
	$section_css         = '';
	
	$section_padding     = onetone_option( 'section_padding_'.$i );
	$parallax_scrolling  = onetone_option( 'parallax_scrolling_'.$i );
	
	if( $section_padding == '' )
		$section_padding = '50px 0';
	
	if( $parallax_scrolling == "yes" || $parallax_scrolling == "1" || $parallax_scrolling == "on" ){
		$section_css .= "background-attachment:fixed;background-position:50% 0;background-repeat:repeat;";
	 }
	 
	if( $section_padding ){
	    $section_css .= "padding:".esc_attr($section_padding).";";
	}
	
	if(!empty($section_background) && is_array($section_background)){
	  foreach( $section_background as $key => $value ){
		  if($key == 'background-image')
		  	$value = "url(".esc_url($value).")";
		  $section_css .= esc_attr($key).":".esc_attr($value).";";
		  }
	}
	$section_content_css .=  "section.home-section-".$i." {".$section_css."}";	
	
	/* section title typography*/
	$section_css         = '';
	if(!empty($title_typography) && is_array($title_typography)){
	  foreach( $title_typography as $key => $value ){
		  if($key == 'subsets'){
			if ( is_array( $value ) ) {
				$section_css .= esc_attr($key).":".esc_attr(implode( ', ', $value )).";";
			} else {
				$section_css .= esc_attr($key).":".esc_attr($value).";";
			}
		}
		else
		  $section_css .= esc_attr($key).":".esc_attr($value).";";
		  }
	}
	$section_content_css .=  "section.home-section-".$i." .section-title{".$section_css."}";
	
	/* section subtitle typography*/
	$section_css         = '';
	if(!empty($subtitle_typography) && is_array($subtitle_typography)){
	  foreach( $subtitle_typography as $key => $value ){
		  if($key == 'subsets'){
			if ( is_array( $value ) ) {
				$section_css .= esc_attr($key).":".esc_attr(implode( ', ', $value )).";";
			} else {
				$section_css .= esc_attr($key).":".esc_attr($value).";";
			}
		}
		else
		  $section_css .= $key.":".$value.";";
		  }
	}
	$section_content_css .=  "section.home-section-".$i." .section-subtitle{".$section_css."}";
	
	/* section conteont typography*/
	$section_css        = '';
	if(!empty($content_typography) && is_array($content_typography)){
	  foreach( $content_typography as $key => $value ){
		  if($key == 'subsets'){
			if ( is_array( $value ) ) {
				$section_css .= esc_attr($key).":".esc_attr(implode( ', ', $value )).";";
			} else {
				$section_css .= esc_attr($key).":".esc_attr($value).";";
			}
		}
		else
		  $section_css .= esc_attr($key).":".esc_attr($value).";";
		  }
	}
	$section_content_css .=  "section.home-section-".$i." .home-section-content,section.home-section-".$i." p{".$section_css."}";
	
	/*service*/
	$service_icon_color   = onetone_option( 'section_service_icon_color_'.$i );
	$section_content_css .=  ".section_service_".$i." i{color:".sanitize_hex_color($service_icon_color)."}";
	

	$content_nosize_typography = '';
	if ( isset( $content_typography['font-family'] ) )
		$content_nosize_typography .= "font-family:".esc_attr($content_typography['font-family']).";";

	if ( isset( $content_typography['variant'] ) )
		$content_nosize_typography .= "font-variant:".esc_attr($content_typography['variant']).";";

	if ( isset( $content_typography['letter-spacing'] ) ) 
		$content_nosize_typography .= "letter-spacing:".esc_attr($content_typography['letter-spacing']).";";
		
	if ( isset( $content_typography['color'] ) ) {
		$content_nosize_typography .= "color:".sanitize_hex_color($content_typography['color']).";";
		$rgb = onetone_hex2rgb($content_typography['color']);
		$section_content_css .= "section.home-section-".$i." .home-section-content .person-social i,section.home-section-".$i." .banner-sns li a i,section.home-section-".$i." input,section.home-section-".$i." select,section.home-section-".$i." textarea,section.home-section-".$i." .home-section-content h1,section.home-section-".$i." .home-section-content h2,section.home-section-".$i." .home-section-content h3, section.home-section-".$i." .home-section-content h4, section.home-section-".$i." .home-section-content h5, section.home-section-".$i." .home-section-content h6{color:".sanitize_hex_color($content_typography['color']).";}";
		
		$section_content_css .= "section.home-section-".$i." input, section.home-section-".$i." select, section.home-section-".$i." textarea{border-color:".sanitize_hex_color($content_typography['color']).";}";
		
		$section_content_css .= ".onetone section.home-section-".$i." .magee-btn-normal.btn-line{color: ".sanitize_hex_color($content_typography['color']).";border-color: ".sanitize_hex_color($content_typography['color']).";}";
		$section_content_css .= ".onetone section.home-section-".$i." .magee-btn-normal.btn-line:hover, .onetone section.home-section-".$i." .magee-btn-normal.btn-line:active, .onetone section.home-section-".$i." .magee-btn-normal.btn-line:focus {background-color: rgba(".$rgb[0].",".$rgb[1].",".$rgb[2].",.3) !important;}";

		if($v['type']==11){
			$section_content_css .= "section.home-section-".$i." .entry-meta i,section.home-section-".$i." .entry-meta a,section.home-section-".$i." img{color:".sanitize_hex_color($content_typography['color'])."}";
		}
	
	}
	if ( isset( $title_typography['color'] ) ) {
		$section_content_css .= "section.home-section-".$i." .heading-inner{border-color:".sanitize_hex_color($title_typography['color'])."}";
	}
	

	if($v['type']==11){
		$section_content_css .= "section.home-section-".$i." .home-section-content p{".$content_nosize_typography."}"; 
	}else{
		$section_content_css .= "section.home-section-".$i." .home-section-content p, section.home-section-".$i." .home-section-content h1, section.home-section-".$i." .home-section-content h2, section.home-section-".$i." .home-section-content h3, section.home-section-".$i." .home-section-content h4, section.home-section-".$i." .home-section-content h5, section.home-section-".$i." .home-section-content h6{".$content_nosize_typography."}"; 
		}
		
	}
	}

	// footer
	
	$footer_background_image          = onetone_option('footer_background_image',''); 
	$footer_bg_full                   = onetone_option('footer_bg_full','yes'); 
	$footer_background_repeat         = onetone_option('footer_background_repeat',''); 
	$footer_background_position       = onetone_option('footer_background_position',''); 
	$footer_top_padding               = onetone_option('footer_top_padding',''); 
	$footer_bottom_padding            = onetone_option('footer_bottom_padding',''); 
	
	$copyright_top_padding            = onetone_option('copyright_top_padding'); 
	$copyright_bottom_padding         = onetone_option('copyright_bottom_padding'); 
	
	$footer_background = "";
	
	if( $footer_background_image ){
		$footer_background  .= ".footer-widget-area{";
	    $footer_background  .= "background-image: url(".esc_url($footer_background_image).");";
	if( $footer_bg_full == 'yes' )
		  $footer_background  .= "-webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover;";
		
	 $footer_background  .=  "background-repeat:".esc_attr($footer_background_repeat).";";
	 $footer_background  .=  "background-position:".esc_attr($footer_background_position).";";
     $footer_background  .= "}";	
	}
	
	$onetone_custom_css      .= $footer_background ;
	
	$onetone_custom_css      .= ".footer-widget-area{ padding-top:".esc_attr($footer_top_padding)."; padding-bottom:".esc_attr($footer_bottom_padding).";  }" ;
	$onetone_custom_css      .= ".footer-info-area{ padding-top:".esc_attr($copyright_top_padding)."; padding-bottom:".esc_attr($copyright_bottom_padding)."; }" ;	
	
	$onetone_custom_css  .=  $section_title_css;
	$onetone_custom_css  .=  $section_content_css;
	$onetone_custom_css  .=  $custom_css;
	
	if ($primary_color!=''){
		$rgb = onetone_hex2rgb($primary_color);
		$onetone_custom_css .= ".text-primary { color: ".$primary_color."; } .text-muted { color: #777; } .text-light { color: #fff; } a { color: ".$primary_color.";}a:active,a:hover,.onetone a:active, .onetone a:hover { color: ".$primary_color."; } h1 strong, h2 strong, h3 strong, h4 strong, h5 strong, h6 strong { color: ".$primary_color."; } mark, ins { background: ".$primary_color.";}::selection {background: ".$primary_color.";}::-moz-selection {background: ".$primary_color.";}.site-nav > ul > li.current > a {color: ".$primary_color.";}@media screen and (min-width: 920px) {.site-nav > ul > li:hover > a {color: ".$primary_color.";}.overlay .main-header .site-nav > ul > li:hover > a {border-color: #fff;}.side-header .site-nav > ul > li:hover > a {border-right-color: ".$primary_color.";}.side-header-right .site-nav > ul > li:hover > a {border-left-color: ".$primary_color.";}}.blog-list-wrap .entry-header:after {background-color: ".$primary_color.";}.entry-meta a:hover,.entry-footer a:hover {color: ".$primary_color.";}.entry-footer li a:hover {border-color: ".$primary_color.";}.post-attributes h3:after {background-color: ".$primary_color.";}.post-pagination li a:hover {border-color: ".$primary_color.";color: ".$primary_color.";}.form-control:focus,select:focus,input:focus,textarea:focus,input[type=\"text\"]:focus,input[type=\"password\"]:focus,input[type=\"subject\"]:focus,input[type=\"datetime\"]:focus,input[type=\"datetime-local\"]:focus,input[type=\"date\"]:focus,input[type=\"month\"]:focus,input[type=\"time\"]:focus,input[type=\"week\"]:focus,input[type=\"number\"]:focus,input[type=\"email\"]:focus,input[type=\"url\"]:focus,		input[type=\"search\"]:focus,input[type=\"tel\"]:focus,input[type=\"color\"]:focus,.uneditable-input:focus {border-color: inherit;}a .entry-title:hover {color: ".$primary_color.";}.widget-title:after {background-color: ".$primary_color.";}.widget_nav_menu li.current-menu-item a {border-right-color: ".$primary_color.";}.breadcrumb-nav a:hover {color: ".$primary_color.";}.entry-meta a:hover {color: ".$primary_color.";}.widget-box a:hover {color: ".$primary_color.";}.post-attributes a:hover {color: ".$primary_color.";}.post-pagination a:hover,.post-list-pagination a:hover {color: ".$primary_color.";}/*Onetone Shortcode*/.portfolio-box:hover .portfolio-box-title {background-color: ".$primary_color.";}/*Shortcode*/.onetone .text-primary {color: ".$primary_color.";}.onetone .magee-dropcap {color: ".$primary_color.";}.onetone .dropcap-boxed {background-color: ".$primary_color.";color: #fff;}.onetone .magee-highlight {background-color: ".$primary_color.";}.onetone .comment-reply-link {color: ".$primary_color.";}.onetone .btn-normal,.onetone a.btn-normal,.onetone .magee-btn-normal,.onetone a.magee-btn-normal,.onetone .mpl-btn-normal {background-color: ".$primary_color.";color: #fff;}.onetone .btn-normal:hover,.onetone .magee-btn-normal:hover,.onetone .btn-normal:active,.onetone .magee-btn-normal:active,.onetone .comment-reply-link:active,.onetone .btn-normal:focus,.onetone .magee-btn-normal:focus,.onetone .comment-reply-link:focus,.onetone .onetone .mpl-btn-normal:focus,.onetone .onetone .mpl-btn-normal:hover,.onetone .mpl-btn-normal:active {background-color: rgba(".$rgb[0].",".$rgb[1].",".$rgb[2].",.6) !important;color: #fff !important;}.onetone .magee-btn-normal.btn-line {background-color: transparent;color: ".$primary_color.";border-color: ".$primary_color.";}.onetone .magee-btn-normal.btn-line:hover,.onetone .magee-btn-normal.btn-line:active,.onetone .magee-btn-normal.btn-line:focus {background-color: rgba(255,255,255,.1);}.onetone .magee-btn-normal.btn-3d {box-shadow: 0 3px 0 0 rgba(".$rgb[0].",".$rgb[1].",".$rgb[2].",.8);}.onetone .icon-box.primary {color: ".$primary_color.";}.onetone .portfolio-list-filter li a:hover,.onetone .portfolio-list-filter li.active a,.onetone .portfolio-list-filter li span.active a {background-color: ".$primary_color.";color: #fff;}.onetone .magee-tab-box.tab-line ul > li.active > a {border-bottom-color: ".$primary_color.";}.onetone .panel-primary {border-color: ".$primary_color.";}.onetone .panel-primary .panel-heading {background-color: ".$primary_color.";border-color: ".$primary_color.";}.onetone .mpl-pricing-table.style1 .mpl-pricing-box.mpl-featured .mpl-pricing-title,.onetone .mpl-pricing-table.style1 .mpl-pricing-box.mpl-featured .mpl-pricing-box.mpl-featured .mpl-pricing-tag {color: ".$primary_color.";}.onetone .pricing-top-icon,.onetone .mpl-pricing-table.style2 .mpl-pricing-top-icon {color: ".$primary_color.";}.onetone .magee-pricing-box.featured .panel-heading,.onetone .mpl-pricing-table.style2 .mpl-pricing-box.mpl-featured .mpl-pricing-title {background-color: ".$primary_color.";}.onetone .pricing-tag .currency,.onetone .mpl-pricing-table.style2 .mpl-pricing-tag .currency {color: ".$primary_color.";}.onetone .pricing-tag .price,.onetone .mpl-pricing-table.style2 .mpl-pricing-tag .price {color: ".$primary_color.";}.onetone .pricing-box-flat.featured {background-color: ".$primary_color.";color: #fff;}.onetone .person-vcard .person-title:after {background-color: ".$primary_color.";}.onetone .person-social li a:hover {color: ".$primary_color.";}.onetone .person-social.boxed li a:hover {color: #fff;background-color: ".$primary_color.";}.onetone .magee-progress-box .progress-bar {background-color: ".$primary_color.";}.onetone .counter-top-icon {color: ".$primary_color.";}.onetone .counter:after {background-color: ".$primary_color.";}.onetone .timeline-year {background-color: ".$primary_color.";}.onetone .timeline-year:after {border-top-color: ".$primary_color.";}@media (min-width: 992px) {.onetone .magee-timeline:before {background-color: ".$primary_color.";}.onetone .magee-timeline > ul > li:before {background-color: ".$primary_color.";}.onetone .magee-timeline > ul > li:last-child:before {background-image: -moz-linear-gradient(left, ".$primary_color." 0%, ".$primary_color." 70%, #fff 100%); background-image: -webkit-gradient(linear, left top, right top, from(".$primary_color."), color-stop(0.7, ".$primary_color."), to(#fff)); background-image: -webkit-linear-gradient(left, ".$primary_color." 0%, ".$primary_color." 70%, #fff 100%); background-image: -o-linear-gradient(left, ".$primary_color." 0%, ".$primary_color." 70%, #fff 100%);}}.onetone .icon-list-primary li i{color: ".$primary_color.";}.onetone .icon-list-primary.icon-list-circle li i {background-color: ".$primary_color.";color: #fff;}.onetone .divider-border .divider-inner.primary {border-color: ".$primary_color.";}.onetone .img-box .img-overlay.primary {background-color: rgba(".$rgb[0].",".$rgb[1].",".$rgb[2].",.7);}.img-box .img-overlay-icons i,.onetone .img-box .img-overlay-icons i {background-color: ".$primary_color.";}.onetone .portfolio-img-box {background-color: ".$primary_color.";}.onetone .tooltip-text {color: ".$primary_color.";}.onetone .star-rating span:before {color: ".$primary_color.";}.onetone .woocommerce p.stars a:before {color: ".$primary_color.";}@media screen and (min-width: 920px) {.site-nav.style1 > ul > li.current > a > span,.site-nav.style1 > ul > li > a:hover > span {background-color: ".$primary_color.";}.site-nav.style2 > ul > li.current > a > span,.site-nav.style2 > ul > li > a:hover > span {border-color: ".$primary_color.";}.site-nav.style3 > ul > li.current > a > span,.site-nav.style3 > ul > li > a:hover > span {border-bottom-color: ".$primary_color.";}}/*Woocommerce*/.star-rating span:before {color: ".$primary_color.";}.woocommerce p.stars a:before {color: ".$primary_color.";}.woocommerce span.onsale {background-color: ".$primary_color.";}.woocommerce span.onsale:before {border-top-color: ".$primary_color.";border-bottom-color: ".$primary_color.";}.woocommerce div.product p.price,.woocommerce div.product span.price,.woocommerce ul.products li.product .price {color: ".$primary_color.";}.woocommerce #respond input#submit,.woocommerce a.button,.woocommerce button.button,.woocommerce input.button,.woocommerce #respond input#submit.alt,.woocommerce a.button.alt,.woocommerce button.button.alt,.woocommerce input.button.alt {background-color: ".$primary_color.";}.woocommerce #respond input#submit:hover,.woocommerce a.button:hover,.woocommerce button.button:hover,.woocommerce input.button:hover,.woocommerce #respond input#submit.alt:hover,.woocommerce a.button.alt:hover,.woocommerce button.button.alt:hover,.woocommerce input.button.alt:hover {background-color:  rgba(".$rgb[0].",".$rgb[1].",".$rgb[2].",.7);}p.woocommerce.product ins,.woocommerce p.product ins,p.woocommerce.product .amount,.woocommerce p.product .amount,.woocommerce .product_list_widget ins,.woocommerce .product_list_widget .amount,.woocommerce .product-price ins,.woocommerce .product-price .amount,.product-price .amount,.product-price ins {color: ".$primary_color.";}.woocommerce .widget_price_filter .ui-slider .ui-slider-range {background-color: ".$primary_color.";}.woocommerce .widget_price_filter .ui-slider .ui-slider-handle {background-color: ".$primary_color.";}.woocommerce.style2 .widget_price_filter .ui-slider .ui-slider-range {background-color: #222;}.woocommerce.style2 .widget_price_filter .ui-slider .ui-slider-handle {background-color: #222;}.woocommerce p.stars a:before {color: ".$primary_color.";}.onetone .mpl-portfolio-list-filter li.active a,.onetone .mpl-portfolio-list-filter li a:hover {color: ".$primary_color.";}";
	}
	
	$enable_sticky_header         = onetone_option('enable_sticky_header');
	$enable_sticky_header_tablets = onetone_option('enable_sticky_header_tablets');
    $enable_sticky_header_mobiles = onetone_option('enable_sticky_header_mobiles');
	
	
	if ( $enable_sticky_header =='yes' || $enable_sticky_header =='1' ){
		
		if($enable_sticky_header_tablets !='yes' && $enable_sticky_header_tablets != '1' ){
			$onetone_custom_css .= "@media (min-width: 720px) and (max-width: 1024px) {.fxd-header{display:none!important;}}";
			}
		if($enable_sticky_header_mobiles !='yes' && $enable_sticky_header_mobiles != '1' ){
			$onetone_custom_css .= "@media (max-width: 719px) {.fxd-header{display:none !important;}}";
			}
		
		}else{
			$onetone_custom_css .= ".fxd-header{display:none!important;}";
			}
	
	$breadcrumbs_on_mobile = esc_attr(onetone_option('breadcrumbs_on_mobile_devices'));
	if ( $breadcrumbs_on_mobile !='yes' && $breadcrumbs_on_mobile !='1' ){
		$onetone_custom_css .= "@media (max-width: 719px) {.breadcrumb-nav{display:none !important;}}";
		}

	$onetone_custom_css = wp_filter_nohtml_kses($onetone_custom_css);
	$onetone_custom_css = stripslashes(str_replace('&gt;','>',$onetone_custom_css));
	
	wp_add_inline_style( 'onetone-main', $onetone_custom_css );
		
	wp_enqueue_style( 'jquery-mb-ytplayer', get_template_directory_uri().'/plugins/YTPlayer/css/jquery.mb.YTPlayer.min.css','', '', true );
	wp_enqueue_script( 'jquery-mb-ytplayer', get_template_directory_uri().'/plugins/YTPlayer/jquery.mb.YTPlayer.js', array( 'jquery' ), '', true );
	
	wp_enqueue_script( 'bootstrap', get_template_directory_uri().'/plugins/bootstrap/js/bootstrap.min.js', array( 'jquery' ), '3.3.4', true );
	wp_enqueue_script( 'jquery-nav', get_template_directory_uri().'/plugins/jquery.nav.js', array( 'jquery' ), '1.4.14 ', true );
	wp_enqueue_script( 'jquery-scrollto', get_template_directory_uri().'/plugins/jquery.scrollTo.js', array( 'jquery' ), '1.4.14', true );
	wp_enqueue_script( 'jquery-parallax', get_template_directory_uri().'/plugins/jquery.parallax-1.1.3.js', array( 'jquery' ), '1.1.3', true );
	wp_enqueue_script( 'respond', get_template_directory_uri().'/plugins/respond.min.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'jquery-magnific-popup', get_template_directory_uri().'/plugins/magnific-popup/jquery.magnific-popup.min.js', array( 'jquery' ), '3.1.5', true );
	wp_enqueue_script('masonry');
	wp_register_script( 'okvideo', get_template_directory_uri().'/plugins/okvideo.js', array( 'jquery' ), '', false );

	wp_enqueue_script( 'jquery-waypoints', get_template_directory_uri() . '/plugins/jquery.waypoints.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'jquery-counterup', get_template_directory_uri() . '/plugins/jquery.counterup.js', array( 'jquery','jquery-waypoints'), '2.1.0', true );
	wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/plugins/owl-carousel/owl.carousel.js', array( 'jquery' ), '2.2.0', true );


	wp_enqueue_script( 'onetone-default', get_template_directory_uri().'/js/onetone.js', array( 'jquery' ),$theme_info->get( 'Version' ), true );
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ){wp_enqueue_script( 'comment-reply' );}
	
	$slide_autoplay    = onetone_option("slide_autoplay",1);
	$slide_time        = onetone_option("slide_time");
	$slider_control    = onetone_option("slider_control",1);
	$slider_pagination = onetone_option("slider_pagination",1);
	$slide_fullheight  = onetone_option("slide_fullheight");
	
	if ($slide_autoplay == 'on' )
		$slide_autoplay = 1;
	if ($slider_control == 'on' )
		$slider_control = 1;
	if ($slide_fullheight  == 'on' )
		$slide_fullheight  = 1;
	
	$slide_time = is_numeric($slide_time)?$slide_time:"5000";
	
	$sticky_header         = esc_attr(onetone_option('enable_sticky_header','yes'));
	$enable_image_lightbox = absint(onetone_option('enable_image_lightbox'));
	

	wp_localize_script( 'onetone-default', 'onetone_params', array(
			'ajaxurl' => esc_url(admin_url('admin-ajax.php')),
			'themeurl' => esc_url(get_template_directory_uri()),
			'slide_autoplay'  => absint($slide_autoplay),
			'slideSpeed'  => absint($slide_time),
			'slider_control'  => absint($slider_control),
			'slider_pagination'  => absint($slider_pagination),
			'slide_fullheight'  => absint($slide_fullheight),
			'sticky_header' => esc_attr($sticky_header),

			'primary_color' => $primary_color,
			'is_rtl' => $is_rtl,
			'enable_image_lightbox' => $enable_image_lightbox,
			
		)  );	
	}

/**
 * Enqueue admin scripts and styles.
 */	
function onetone_admin_scripts(){
		
	global $pagenow , $onetone_options_saved;
	$theme_info = wp_get_theme();
		
	wp_enqueue_style( 'onetone-admin', get_template_directory_uri().'/css/admin.css', false, $theme_info->get( 'Version' ), false);
		
	wp_enqueue_script( 'onetone-admin', get_template_directory_uri().'/js/admin.js', array( 'jquery' ), $theme_info->get( 'Version' ), true );
	
	if( isset($_GET['page']) && $_GET['page'] == 'onetone-welcome'){
		wp_enqueue_script( 'onetone-admin-menu-settings', get_template_directory_uri().'/js/admin-menu-settings.js', array( 'jquery', 'wp-util', 'updates' ), '', true );
		}
	
	wp_localize_script( 'onetone-admin-menu-settings', 'onetone', array(
			'btnActivating' => esc_html__( 'Activating Required Plugin ', 'onetone' ) . '&hellip;',
			'ajaxurl' => admin_url('admin-ajax.php'),
			'onetone_welcome_url' => admin_url('admin.php?page=onetone-companion'),
		)  );
		
	wp_localize_script( 'onetone-admin', 'onetone_params', array(
		'ajaxurl'        => esc_url(admin_url('admin-ajax.php')),
		'themeurl'       => esc_url(get_template_directory_uri()),
		'options_saved'  => $onetone_options_saved,
		'option_name' => onetone_option_name(),
		'l18n_01' => __( 'Are you sure you want to do this?', 'onetone'),
	)  );
		
	}

/**
 * Enqueue customizer preview scripts and styles.
 */
function onetone_customizer_live_preview() {
		wp_enqueue_script( 'customizer-preview', get_template_directory_uri() . '/js/customizer-preview.js', array( 'jquery', 'customize-preview' ), '', true );
	}

  add_action( 'wp_enqueue_scripts', 'onetone_custom_scripts' );
  add_action( 'admin_enqueue_scripts', 'onetone_admin_scripts' );
  add_action( 'customize_preview_init', 'onetone_customizer_live_preview');

/**
 * Enqueue customizer control scripts and styles.
 */
function onetone_customize_control_js() {
	global $onetone_homepage_actived;

	$loading         = __('Updating','onetone');
	$complete        = __('Complete','onetone');
	$error           = __('Error','onetone');
	$import_options  = __('Restore Defaults','onetone');
	$confirm         = __( 'Click OK to reset. Any onetone options will be restored!', 'onetone' );
	$confirm_import  = __( 'Click OK to import. Any onetone options will be overwritten!', 'onetone' );
	

    wp_enqueue_script( 'onetone_customizer_control', get_template_directory_uri() . '/js/customizer-control.js', array( 'customize-controls', 'jquery' ), null, true );
	wp_enqueue_style( 'onetone_customizer_control', get_template_directory_uri().'/css/customizer-control.css', false, '', false);
	wp_localize_script( 'onetone_customizer_control', 'onetone_customize_params', array(
			'ajaxurl' => esc_url(admin_url('admin-ajax.php')),
			'themeurl' => get_template_directory_uri(),
			'loading' => $loading,
			'complete' => $complete,
			'error' => $error,
			'import_options' =>$import_options,
			'confirm' =>$confirm,
			'confirm_import' =>$confirm_import,
			'i18n01' => __( 'Onetone: Home Page Sections', 'onetone' ),
			'i18n02' => __( 'This section only works when the Onetone custom front page is ready.', 'onetone' ),
			'i18n03' => __( 'Setup Onetone Front Page', 'onetone' ),
			'onetone_homepage_actived' =>$onetone_homepage_actived,
		)  );
}
add_action( 'customize_controls_enqueue_scripts', 'onetone_customize_control_js' );

  
function onetone_title( $title ) {
	if ( $title == '' ) {
		if( function_exists('is_shop') && is_shop() ){
				return __( 'Shop', 'onetone');
			}else{
				return __( 'Untitled', 'onetone');
			}
	} else {
		return $title;
	}
}
add_filter( 'the_title', 'onetone_title' );
