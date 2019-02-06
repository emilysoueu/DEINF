<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>
<?php
  global  $onetone_page_meta, $onetone_home_sections;
  
  $display_top_bar             = onetone_option('display_top_bar','yes');
  $header_background_parallax  = onetone_option('header_background_parallax');

  $header_background_parallax  = $header_background_parallax=="yes"?"parallax-scrolling":"";
  $top_bar_left_content        = onetone_option('top_bar_left_content','info');
  $top_bar_right_content       = onetone_option('top_bar_right_content','info');
  $header_fullwidth            = onetone_option('header_fullwidth');
  $nav_hover_effect            = absint(onetone_option('nav_hover_effect'));
  $enable_woo_cart             = onetone_option('header_enable_cart');

  $logo               = onetone_option('logo');
  $logo_retina        = onetone_option('logo_retina');
  $logo               = ( $logo == '' ) ? $logo_retina : $logo;

  $sticky_logo        = onetone_option('sticky_logo',$logo);
  $sticky_logo_retina = onetone_option('sticky_logo_retina');
  $sticky_logo        = ( $sticky_logo == '' ) ? $sticky_logo_retina : $sticky_logo;
  $logo_position      = onetone_option('logo_position','left');
  $logo_position      = $logo_position==''?'left':$logo_position;
  $header_overlay     = onetone_option('header_overlay');
  $overlay            = '';
  $overlay_logo       = '';
  
  if( ($header_overlay == 'yes'|| $header_overlay == '1'|| $header_overlay == 'on') )
  {
    $overlay      = 'overlay';
	$overlay_logo = onetone_option('overlay_logo');
	$logo         = ( $overlay_logo == '' ) ? $logo : $overlay_logo;
  }
  
  if (is_numeric($logo)) {
	$image_attributes = wp_get_attachment_image_src($logo, 'full');
	$logo       = $image_attributes[0];
	}
   if (is_numeric($sticky_logo)) {
	$image_attributes = wp_get_attachment_image_src($sticky_logo, 'full');
	$sticky_logo       = $image_attributes[0];
	}
   if (is_numeric($overlay_logo)) {
	$image_attributes = wp_get_attachment_image_src($overlay_logo, 'full');
	$overlay_logo       = $image_attributes[0];
	}
  
  //sticky
  $enable_sticky_header         = onetone_option('enable_sticky_header','yes');
  $enable_sticky_header_tablets = onetone_option('enable_sticky_header_tablets','yes');
  $enable_sticky_header_mobiles = onetone_option('enable_sticky_header_mobiles','yes');
   
 if(isset($onetone_page_meta['nav_menu']) && $onetone_page_meta['nav_menu'] !='')
	$custom_menu = $onetone_page_meta['nav_menu'];
 else
 	$custom_menu = '';
 
 $header_container = 'container';
 
 if( $header_fullwidth == 1)
	 $header_container = 'container-fluid';
 
 $body_class  = '';
 
// if(is_home() || is_front_page() )
 $body_class  = 'page homepage';
 
 $body_class  .= ' onetone';
 $header_image = get_header_image();
 
 $onetone_woo_cart = '';
 ob_start();
 onetone_woo_cart();
 $onetone_woo_cart = ob_get_contents();
 ob_end_clean();
  
 $menu_args = array(
	'theme_location'=>'home_menu',
	'depth'=>0,
	'fallback_cb' =>false,
	'container'=>'',
	'container_class'=>'main-menu',
	'menu_id'=>'menu-main',
	'menu_class'=>'main-nav',
	'link_before' => '<span>',
	'link_after' => '</span>',
	'items_wrap'=> '<ul id="%1$s" class="%2$s">'.$onepage_menu.'%3$s '.$onetone_woo_cart.'</ul>'
   );
   
 $custom_menu = apply_filters('onetone_custom_menu', $custom_menu);
 if( $custom_menu !='' ){
	  if ( is_numeric($custom_menu) ){
		$menu_args['menu'] = $custom_menu;
		$menu_args['theme_location'] = '';
	  }else{
		$menu_args['theme_location'] = $custom_menu; 
		  
		}
	}
?>
<body <?php body_class($body_class); ?>>
	<div class="wrapper">
		<div class="top-wrap">
        <?php if( $header_image ):?>
        <img src="<?php echo $header_image; ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="" />
         <?php endif;?>
            <!--Header-->
            <header class="header-wrap logo-<?php echo $logo_position; ?> home-header <?php echo $overlay; ?>" role="banner">
             <?php if( $display_top_bar == 'yes' ):?>
                <div class="top-bar">
                    <div class="<?php echo $header_container; ?>">
                        <div class="top-bar-left">
                            <?php onetone_get_topbar_content( $top_bar_left_content );?>                      
                        </div>
                        <div class="top-bar-right">
                          <?php onetone_get_topbar_content( $top_bar_right_content );?>
                        </div>
                    </div>
                </div>
                 <?php endif;?>
                
                <div class="main-header <?php echo $header_background_parallax; ?>">
                    <div class="<?php echo $header_container; ?>">
                        <div class="logo-box">
                        <?php if( $logo ):?>
                        
                            <a href="<?php echo esc_url(home_url('/')); ?>">
                            <img class="site-logo normal_logo" alt="<?php bloginfo('name'); ?>" src="<?php echo esc_url($logo); ?>" />
                            </a>
                             <?php
							
					if( $logo_retina ):
					$pixels ="";
					if(is_numeric(onetone_option('retina_logo_width')) && is_numeric(onetone_option('retina_logo_height'))):
					$pixels ="px";
					endif; ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>">
					<img src="<?php echo $logo_retina; ?>" alt="<?php bloginfo('name'); ?>" style="width:<?php echo onetone_option('retina_logo_width').$pixels; ?>;max-height:<?php echo onetone_option('retina_logo_height').$pixels; ?>; height: auto !important" class="site-logo retina_logo" />
					 </a>
                     <?php endif;?>
                     <?php else:?>
                 
                            <div class="name-box" style=" display:block;">
                                <a href="<?php echo esc_url(home_url('/')); ?>"><h1 class="site-name"><?php bloginfo('name'); ?></h1></a>
                                <span class="site-tagline"><?php bloginfo('description'); ?></span>
                            </div>
                             <?php endif;?>
                            
                             
                        </div>
                        
                        <button class="site-nav-toggle">
                            <span class="sr-only"><?php _e( 'Toggle navigation', 'onetone' );?></span>
                            <i class="fa fa-bars fa-2x"></i>
                        </button>
                        <nav class="site-nav style<?php echo $nav_hover_effect;?>" role="navigation">
                            <?php

							  $onepage_menu      = '';
							  $onepage_side_menu = '';
							  
							  $new_homepage_section = array();
							  // order
							  $home_sections = onetone_option('section_order');
							  
							  if( $home_sections !='' && count($home_sections)>0 ){
									  $new_homepage_section = $home_sections;
								}else{
									  $new_homepage_section = $onetone_home_sections;
							  }
												
							  $i = 0 ;
							  foreach( $new_homepage_section as $section ):
	
								  $onetone_section_id = $section['id'];
								  $section_part       = $section['type'];
							  
								  $hide_section  = onetone_option( 'section_hide_'.$onetone_section_id );
								  
								  if( $hide_section != '1' && $hide_section != 'on' ){
								  
									  $section_menu = onetone_option( 'menu_title_'.$onetone_section_id );
									  $section_slug = onetone_option( 'menu_slug_'.$onetone_section_id );
									  $section_slug = $section_slug==''? 'section-'.$onetone_section_id:$section_slug;
									  $section_slug = sanitize_title( $section_slug );
									  if( $section_menu != '' ){
										   $onepage_menu    .= '<li class="onetone-menuitem"><a id="onetone-'.$section_slug.'" class="menu_title_'.$onetone_section_id.'" href="#'.strtolower($section_slug).'" >
										 <span>'.$section_menu.'</span></a></li>';
										 
										   $onepage_side_menu .= '<li class="onetone-menuitem"><a href="#'.strtolower($section_slug).'" ><span>'.$section_menu.'</span></a></li>';
									 
									  }
								 
								  }
								  $i++;
							  endforeach;

							if ( has_nav_menu( "home_menu" ) ) {
							 	wp_nav_menu( $menu_args );
							}else{
								echo '<ul id="menu-main" class="main-nav">'.$onepage_menu.' '.$onetone_woo_cart.'</ul>';
							}
							?>
                        </nav>
                    </div>
                </div>
            
                <div class="fxd-header">
                    <div class="<?php echo $header_container; ?>">
                        <div class="logo-box">
                        <?php if( $sticky_logo ):?>
                            <a href="<?php echo esc_url(home_url('/')); ?>"><img class="site-logo normal_logo" src="<?php echo esc_url($sticky_logo); ?>"></a>
                            
                               <?php
					if( $sticky_logo_retina ):
					$pixels ="";
					if( is_numeric(onetone_option('sticky_logo_width_for_retina_logo')) && is_numeric(onetone_option('sticky_logo_height_for_retina_logo')) ):
					$pixels ="px";
					endif; ?>
					<a href="<?php echo esc_url(home_url('/')); ?>"><img src="<?php echo $sticky_logo_retina; ?>" alt="<?php bloginfo('name'); ?>" style="width:<?php echo onetone_option('sticky_logo_width_for_retina_logo').$pixels; ?>;max-height:<?php echo onetone_option('sticky_logo_height_for_retina_logo').$pixels; ?>; height: auto !important" class="site-logo retina_logo" /></a>
					<?php endif; ?>
                    
                           <?php endif;?>
                            <div class="name-box" style=" display:block;">
                                <a href="<?php echo esc_url(home_url('/')); ?>"><h1 class="site-name"><?php bloginfo('name'); ?></h1></a>
                                <span class="site-tagline"><?php bloginfo('description'); ?></span>
                            </div>
                            
                        </div>
                        <button class="site-nav-toggle">
                            <span class="sr-only"><?php _e( 'Toggle navigation', 'onetone' );?></span>
                            <i class="fa fa-bars fa-2x"></i>
                        </button>
                        <nav class="site-nav style<?php echo $nav_hover_effect;?>" role="navigation">

                          <?php
							
						  if ( has_nav_menu( "home_menu" ) ) { 
						  	wp_nav_menu( $menu_args );
						  }else{
						  	echo '<ul id="menu-main" class="main-nav">'.$onepage_menu.' '.$onetone_woo_cart.'</ul>';
						  }
						  ?>

                        </nav>
                    </div>
                </div>
                
             
            </header>
            <?php 
			$enable_side_nav = onetone_option( 'enable_side_nav' );
			if( $enable_side_nav == '1' || $enable_side_nav == 'on' ):
			?>
            <ul class="onetone-dots main-nav"><?php echo $onepage_side_menu;?></ul>
            <?php endif; ?>
            <div class="slider-wrap"></div>
        </div>