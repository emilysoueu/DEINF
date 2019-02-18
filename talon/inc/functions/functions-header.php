<?php
/**
 * Header functions
 *
 * @package Talon
 */


/**
 * Header type check
 */
function talon_header_check() {
	$front_header = get_theme_mod('front_header_type' ,'has-slider');
	$site_header  = get_theme_mod('site_header_type', 'nothing');

	if ( is_front_page() ) {
		return $front_header;
	} else {
		return $site_header;
	}
}

/**
 * Site title, logo and menu bar
 */
function talon_header_bar() {
	$sticky = get_theme_mod('sticky_menu', 'sticky');
?>
	<header id="header" class="site-header header-<?php echo esc_html($sticky); ?>">
		<div class="main-header">
			<div class="container">
				<div class="row">
					<div class="col-md-4 col-sm-12 col-xs-12 branding-container">
						<div class="menu-btn-toggle">
						<div class="menu-btn">
						  <span></span>
						  <span></span>
						  <span></span>
						</div>
						</div>
						<?php talon_site_branding(); ?>
					</div>
					<div class="col-md-8 menu-container">
						<nav id="site-navigation" class="main-navigation" role="navigation">
							<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
						</nav>
					</div>
				</div>
			</div>
		</div>
	</header>
<?php
}
add_action( 'talon_header', 'talon_header_bar', 9);

/**
 * Mobile menu
 */
function talon_mobile_menu() {
?>
	<div off-canvas="main-menu left shift">			
		<div class="mobile-branding">
			<?php talon_site_branding(); ?>
		</div>			
		<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'mobile-menu', 'menu_class' => 'mobile-menu' ) ); ?>
	</div>
<?php
}

/**
 * Register Polylang strings
 */
if ( function_exists('pll_register_string') && !function_exists('talon_register_strings')) :
function talon_register_strings() {
	for ($c = 1; $c <= 3; $c++) {
		pll_register_string('Main title ' . $c, get_theme_mod('slide_title_' . $c), 'Talon');
		pll_register_string('Subtext ' . $c, get_theme_mod('slide_subtitle_' . $c), 'Talon');
		pll_register_string('Button text' . $c, get_theme_mod('slide_btn_title_' . $c), 'Talon');
	}
}
add_action( 'admin_init', 'talon_register_strings' );
endif;

/**
 * Header hero area
 */
function talon_header_hero() {
	$header_type = talon_header_check();
	$sliderspeed = get_theme_mod('slider_speed', '4000');

	if ( $header_type == 'has-slider' ) {

		echo '<div class="main-slider-box">';
		echo 	'<div class="main-slider" data-sliderspeed="' . absint($sliderspeed) . '">';

			for ($c = 1; $c <= 3; $c++) {
				
				$slide_title 	 = get_theme_mod('slide_title_' . $c);
				$slide_subtitle  = get_theme_mod('slide_subtitle_' . $c);
				$slide_btn_title = get_theme_mod('slide_btn_title_' . $c);
				
				$slide_image 	 = get_theme_mod('slide_image_' . $c, get_template_directory_uri() . '/images/slider_' . $c . '.jpg');
				if ( !function_exists('pll_register_string') ) {
					$slide_title 	 = get_theme_mod('slide_title_' . $c);
					$slide_subtitle  = get_theme_mod('slide_subtitle_' . $c);
					$slide_btn_title = get_theme_mod('slide_btn_title_' . $c);
				} else {
					$slide_title 	 = pll__(get_theme_mod('slide_title_' . $c));
					$slide_subtitle  = pll__(get_theme_mod('slide_subtitle_' . $c));
					$slide_btn_title = pll__(get_theme_mod('slide_btn_title_' . $c));
				}
				$slide_btn_url 	 = get_theme_mod('slide_btn_url_' . $c);

				if ( $slide_image ) { ?>
					<div class="slider-item">
						<?php if ( $c != 1 ) : ?>
						<img data-lazy="<?php echo esc_url($slide_image); ?>">
						<?php else : ?>
						<img src="<?php echo esc_url($slide_image); ?>"/>
						<?php endif; ?>
						<div class="main-slider-caption container">
							<div>
								<h1><?php echo esc_html($slide_title); ?></h1>
								<p><?php echo esc_html($slide_subtitle); ?></p>
								<?php if ( $slide_btn_url ) : ?>
								<div class="header-button">
									<a class="button" href="<?php echo esc_url($slide_btn_url); ?>"><?php echo esc_html($slide_btn_title); ?></a>
								</div>
								<?php endif; ?>
							</div>
						</div>
					</div>
				<?php }
			}
			
		echo 	'</div>';
		echo '</div>';

	} elseif ( $header_type == 'has-image' ) { ?>
		<div class="header-image">
			<img class="header-inner" src="<?php header_image(); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" alt="<?php bloginfo('name'); ?>">
		</div>
	<?php } elseif ( $header_type == 'has-video' ) {
		the_custom_header_markup();
	}

}
add_action( 'talon_after_header', 'talon_header_hero', 9);

/**
 * Site branding
 */
function talon_site_branding() {
	?>
	<div class="site-branding">
	<?php
	if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
		the_custom_logo();
	} else {
		if ( is_front_page() || is_home() ) : ?>
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
		<?php else : ?>
			<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
		<?php
		endif;
		
		$description = get_bloginfo( 'description', 'display' );
		if ( $description || is_customize_preview() ) : ?>
			<p class="site-description"><?php echo $description; ?></p>
		<?php endif;
	}
	?>
	</div>
	<?php
}