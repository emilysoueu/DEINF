<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Talon
 */


if ( ! function_exists( 'talon_home_post_data' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function talon_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);
	
	$byline =  '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>';
	echo '<span class="byline">' . $byline . '<span class="meta-dash">&ndash;</span></span>';		
	$categories_list = get_the_category_list( esc_html__( ', ', 'talon' ) );
	if ( $categories_list ) {
		printf( '<span class="cat-links">' . esc_html__( '%1$s', 'talon' ) . '</span>', $categories_list );
	}
	echo '<span class="meta-dash">&ndash;</span><span class="posted-on">' . $time_string . '</span>'; 

}
endif;

if ( ! function_exists( 'talon_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function talon_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ' ', 'talon' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( 'Tags %1$s', 'talon' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'talon' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link">',
		'</span>'
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function talon_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'talon_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'talon_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so talon_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so talon_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in talon_categorized_blog.
 */
function talon_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'talon_categories' );
}
add_action( 'edit_category', 'talon_category_transient_flusher' );
add_action( 'save_post',     'talon_category_transient_flusher' );
