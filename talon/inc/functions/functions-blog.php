<?php
/**
 * @package Talon
 */


/**
 * Excerpt length
 */
function talon_excerpt_length( $length ) {
  $excerpt = get_theme_mod('exc_length', '20');
  return $excerpt;
}
add_filter( 'excerpt_length', 'talon_excerpt_length', 999 );

/**
 * Excerpt read more
 */
function talon_custom_excerpt( $more ) {
	$more = get_theme_mod('custom_read_more');
  if ($more == '') {
    return '&nbsp;[&hellip;]';
	} else {
		return ' <a class="read-more" href="' . get_permalink( get_the_ID() ) . '">' . esc_html($more) . '</a>';
	}
}
add_filter( 'excerpt_more', 'talon_custom_excerpt' );

/**
 * Remove archive labels
 */
function talon_archive_labels($title) {
    if ( is_category() ) {
        $title = single_cat_title( '', false );
    } elseif ( is_tag() ) {
        $title = single_tag_title( '', false );
    } elseif ( is_author() ) {
        $title = '<span class="vcard">' . get_the_author() . '</span>' ;
	}
    return $title;
}
add_filter( 'get_the_archive_title', 'talon_archive_labels');

/**
 * Blog layout
 */
function talon_blog_layout() {
  $layout = get_theme_mod('blog_layout','list');
  return $layout;
}

/**
 * Single posts
 */
function talon_fullwidth_singles($classes) {
  if ( function_exists('is_woocommerce') ) {
    $woocommerce = is_woocommerce();
  } else {
    $woocommerce = false;
  }

  $single_layout = get_theme_mod('fullwidth_single', 0);
  if ( is_single() && !$woocommerce && $single_layout ) {
    $classes[] = 'fullwidth-single';
  }
  return $classes;
}
add_filter('body_class', 'talon_fullwidth_singles');