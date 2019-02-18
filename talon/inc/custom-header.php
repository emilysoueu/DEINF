<?php
/**
 * Sample implementation of the Custom Header feature.
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php if ( get_header_image() ) : ?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
		<img src="<?php header_image(); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="">
	</a>
	<?php endif; // End header image check. ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package Talon
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses talon_header_style()
 */
function talon_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'talon_custom_header_args', array(
		'default-image'          => '',
		'header-text'            => false,
		'width'                  => 1920,
		'height'                 => 1080,
		'video'					 => true,
		'video-active-callback'  => '',		
		'flex-height'            => true,
	) ) );
}
add_action( 'after_setup_theme', 'talon_custom_header_setup' );

/**
 * Video header settings
 */
function talon_video_settings( $settings ) {
	$settings['minWidth'] 		= '100';
	$settings['minHeight'] 		= '100';	
	
	return $settings;
}
add_filter( 'header_video_settings', 'talon_video_settings' );