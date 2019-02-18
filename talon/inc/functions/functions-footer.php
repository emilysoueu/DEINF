<?php
/**
 * Footer functions
 *
 * @package Talon
 */

/**
 * Footer sidebar
 */
function talon_footer_sidebar() {
	if ( is_active_sidebar( 'footer-1' ) ) {
		get_sidebar('footer');		
	}
}
add_action('talon_footer', 'talon_footer_sidebar', 7);

/**
 * Footer credits ***************************** COMENTEI***********************
 */
/*
function talon_footer_credits() {
	
	?>
		<div class="site-info col-md-6">
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'talon' ) ); ?>" rel="nofollow"><?php printf( esc_html__( 'Powered by %s', 'talon' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( esc_html__( 'Theme: %2$s by %1$s.', 'talon' ), 'aThemes', '<a href="//athemes.com/theme/talon" rel="designer">Talon</a>' ); ?>
		</div><!-- .site-info -->
	<?php
	
}
*/
// add_action('talon_footer', 'talon_footer_credits', 8);

/**
 * Footer menu
 */
/*
function talon_footer_menu() {
	
	?>
		<nav id="footer-navigation" class="footer-navigation col-md-6" role="navigation">
			<?php wp_nav_menu( array( 'theme_location' => 'footer', 'menu_id' => 'footer-menu', 'depth' => 1 ) ); ?>
		</nav>
	<?php
}
add_action('talon_footer', 'talon_footer_menu', 9);*/
