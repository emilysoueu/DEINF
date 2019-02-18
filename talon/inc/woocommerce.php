<?php
/**
 * Woocommerce support
 *
 * @package Talon
 */

if ( !class_exists('WooCommerce') )
    return;

/**
 * Declare support
 */
function talon_woocommerce_support() {
    add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'talon_woocommerce_support' );

/**
 * Theme wrappers
 */
function talon_woocommerce_actions() {
    remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
    remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
    add_action('woocommerce_before_main_content', 'talon_wrapper_start', 10);
    add_action('woocommerce_after_main_content', 'talon_wrapper_end', 10);
    add_action('woocommerce_sidebar', 'talon_close_row', 11);
    remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
    add_action( 'woocommerce_before_single_product_summary', 'woocommerce_template_single_title', 8 );
    add_action( 'woocommerce_before_single_product_summary', 'talon_wrap_wc_image_start', 9 );
    add_action( 'woocommerce_before_single_product_summary', 'talon_wrap_wc_image_end', 21 );
}
add_action('init', 'talon_woocommerce_actions');

function talon_wrapper_start() {
    echo '<div class="row">';
    echo 	'<div id="primary" class="content-area col-md-9">';
    echo 		'<main id="main" class="site-main" role="main">';
}
function talon_wrapper_end() {
    echo 		'</div>';    
    echo 	'</main>';
}
function talon_close_row() {
    echo 	'</div>';    
}
function talon_wrap_wc_image_start() {
    echo '<div class="wc-image-wrapper">';
}
function talon_wrap_wc_image_end() {
    echo '</div>';
}



/**
 * Number of columns per row
 */
function talon_shop_columns() {
    return 3;
}
add_filter('loop_shop_columns', 'talon_shop_columns');

/**
 * Number of related products
 */
function talon_related_products_args( $args ) {
    $args['posts_per_page'] = 3;
    $args['columns'] = 3;
    return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'talon_related_products_args' );

/**
 * Hide page title
 */
add_filter( 'woocommerce_show_page_title', '__return_false' );
