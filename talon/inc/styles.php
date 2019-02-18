<?php
/**
 * @package Talon
 */

//Converts hex colors to rgba for the menu background color
function talon_hex2rgba($color, $opacity = false) {

        if ($color[0] == '#' ) {
        	$color = substr( $color, 1 );
        }
        $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        $rgb =  array_map('hexdec', $hex);
        $opacity = 0.54;
        $output = 'rgba('.implode(",",$rgb).','.$opacity.')';

        return $output;
}

function talon_custom_styles($custom) {

	$defaults 	= talon_customizer_defaults();

	//Get the options
	$headings_font 			= get_theme_mod('headings_font_family', $defaults['headings_font_family']);
	$body_font 				= get_theme_mod('body_font_family', $defaults['body_font_family']);
	$primary_color			= get_theme_mod('primary_color', $defaults['primary_color']);
	$site_title_color		= get_theme_mod('site_title_color', $defaults['site_title_color']);
	$site_desc_color		= get_theme_mod('site_desc_color', $defaults['site_desc_color']);
	$site_header_color		= get_theme_mod('site_header_color', $defaults['site_header_color']);
	$menu_items_color		= get_theme_mod('menu_items_color', $defaults['menu_items_color']);
	$header_text_color		= get_theme_mod('header_text_color', $defaults['header_text_color']);
	$header_subtext_color	= get_theme_mod('header_subtext_color', $defaults['header_subtext_color']);
	$footer_bg_color		= get_theme_mod('footer_bg_color', $defaults['footer_bg_color']);
	$footer_color			= get_theme_mod('footer_color', $defaults['footer_color']);
	$body_color				= get_theme_mod('body_color', $defaults['body_color']);
	$menu_style				= get_theme_mod('menu_style', $defaults['menu_style']);
    $site_title_size 		= get_theme_mod( 'site_title_size', $defaults['site_title_size'] );
    $site_desc_size 		= get_theme_mod( 'site_desc_size', $defaults['site_desc_size'] );
    $menu_items 			= get_theme_mod( 'menu_items', $defaults['menu_items'] );
    $body_size 				= get_theme_mod( 'body_size', $defaults['body_size'] );
    $so_widgets_title 		= get_theme_mod( 'so_widgets_title', $defaults['so_widgets_title'] );
    $index_post_title 		= get_theme_mod( 'index_post_title', $defaults['index_post_title'] );
    $single_post_title 		= get_theme_mod( 'single_post_title', $defaults['single_post_title'] );
    $sidebar_widgets_title 	= get_theme_mod( 'sidebar_widgets_title', $defaults['sidebar_widgets_title'] );

	//Build CSS
	$custom 	= '';

	if ( $menu_style == 'centered') {
		$custom 	.= ".main-header .row { display: block;}"."\n";
		$custom 	.= ".branding-container { width: 100%;text-align:center;margin-bottom:15px;padding-bottom:15px;border-bottom:1px solid rgba(0,0,0,0.05);}"."\n";
		$custom 	.= ".menu-container { width: 100%;}"."\n";
		$custom 	.= ".main-navigation { text-align:center;}"."\n";
	}

	$custom 	.= ".inner-bar,.lists-box ul li:before,.testimonials-box .slick-dots li.slick-active button::before,.woocommerce-cart .wc-proceed-to-checkout a.checkout-button:hover,.woocommerce #respond input#submit:hover,.woocommerce a.button:hover,.woocommerce button.button:hover,.woocommerce input.button:hover,.woocommerce input.button.alt:hover,.woocommerce-cart .wc-proceed-to-checkout a.checkout-button,.woocommerce #respond input#submit,.woocommerce a.button,.woocommerce button.button,.woocommerce input.button,.woocommerce input.button.alt,.woocommerce span.onsale,.woocommerce ul.products li.product .onsale,.check-box-active .checkbox-inner,.tags-links a:hover,.button,button,input[type=\"button\"],input[type=\"reset\"],input[type=\"submit\"],.woocommerce button.single_add_to_cart_button.button,.button:hover,button:hover,input[type=\"button\"]:hover,input[type=\"reset\"]:hover,input[type=\"submit\"]:hover,.woocommerce button.single_add_to_cart_button.button:hover	{ background-color:" . esc_attr($primary_color) . ";}"."\n";
	$custom 	.= ".team-social a:hover,.portfolio-item h4 a:hover,.woocommerce-message:before { color:" . esc_attr($primary_color) . ";}"."\n";
	$custom 	.= ".woocommerce div.product .woocommerce-tabs ul.tabs li.active,.portfolio-filter ul .active a,.woocommerce-message { border-color:" . esc_attr($primary_color) . ";}"."\n";


	$box_shadow = talon_hex2rgba($primary_color, 0.54);
	
	$custom 	.= ".button:hover, button:hover, input[type=\"button\"]:hover, input[type=\"reset\"]:hover, input[type=\"submit\"]:hover, .woocommerce button.single_add_to_cart_button.button:hover,.woocommerce-cart .wc-proceed-to-checkout a.checkout-button:hover,.woocommerce #respond input#submit:hover,.woocommerce a.button:hover,.woocommerce button.button:hover,.woocommerce input.button:hover,.woocommerce input.button.alt:hover 
					{ -webkit-box-shadow: 0px 0px 40px 0px " . esc_attr($box_shadow) . ";
					  -moz-box-shadow:  0px 0px 40px 0px " . esc_attr($box_shadow) . ";
					  box-shadow: 0px 0px 40px 0px " . esc_attr($box_shadow) . ";}"."\n";

	$custom 	.= ".site-title a,.site-title a:hover { color:" . esc_attr($site_title_color) . ";}"."\n";
	$custom 	.= ".site-description { color:" . esc_attr($site_desc_color) . ";}"."\n";
	$custom 	.= ".site-header { background-color:" . esc_attr($site_header_color) . ";}"."\n";
	$custom 	.= ".main-navigation li a { color:" . esc_attr($menu_items_color) . ";}"."\n";
	$custom 	.= ".main-slider-caption h1 { color:" . esc_attr($header_text_color) . ";}"."\n";
	$custom 	.= ".main-slider-caption p { color:" . esc_attr($header_subtext_color) . ";}"."\n";
	$custom 	.= ".site-footer { background-color:" . esc_attr($footer_bg_color) . ";}"."\n";
	$custom 	.= ".site-footer, .site-footer a { color:" . esc_attr($footer_color) . ";}"."\n";
	$custom 	.= "body { color:" . esc_attr($body_color) . ";}"."\n";
	$custom 	.= "body { font-family:" . esc_attr(ucwords(strtolower($body_font))) . ";}"."\n";
	$custom 	.= "h1,h2,h3,h4,h5,h6,.site-title { font-family:" . esc_attr(ucwords(strtolower($headings_font))) . ";}"."\n";
    $custom 	.= ".site-title { font-size:" . intval($site_title_size) . "px; }"."\n";
    $custom 	.= ".site-description { font-size:" . intval($site_desc_size) . "px; }"."\n";
    $custom 	.= "body { font-size:" . intval($body_size) . "px; }"."\n";
    $custom 	.= ".main-navigation li { font-size:" . intval($menu_items) . "px; }"."\n";
    $custom 	.= ".so-panel .widget-title { font-size:" . intval($so_widgets_title) . "px; }"."\n";
    $custom 	.= ".post-item .post-content .entry-title { font-size:" . intval($index_post_title) . "px; }"."\n";
    $custom 	.= ".single .entry-header .entry-title { font-size:" . intval($single_post_title) . "px; }"."\n";
    $custom 	.= ".widget-area .widget-title span { font-size:" . intval($sidebar_widgets_title) . "px; }"."\n";

    if ( class_exists('WooCommerce') && ( is_cart() || is_checkout() ) ) {
		$custom 	.= ".content-area { width: 100%;}"."\n";
		$custom 	.= ".widget-area { display:none;}"."\n";
    }

	//Output all the styles
	wp_add_inline_style( 'talon-style', $custom );	
}
add_action( 'wp_enqueue_scripts', 'talon_custom_styles' );