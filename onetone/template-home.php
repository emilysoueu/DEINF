<?php
/**
 * Template Name: Front Page
 *
 * @package Onetone
 */
get_header('home'); 
global $onetone_customizer_section;
?>
<div class="post-wrap">
  <div class="container-fullwidth">
    <div class="page-inner row no-aside" style="padding-top: 0; padding-bottom: 0;">
      <div class="col-main">
        <section class="post-main" role="main" id="content">
<?php if($onetone_customizer_section == '1'): ?>
<article class="page type-page homepage" role="article">
			<?php
			global $onetone_animated,$onetone_home_sections;
			 
			$video_background_section  = absint(onetone_option( 'video_background_section' ));
			$video_background_type     = onetone_option( 'video_background_type' );
			$video_background_type     = $video_background_type == ""?"youtube":$video_background_type;
			$section_1_content         = onetone_option( 'section_1_content' );
			$animated                  = onetone_option( 'home_animated');
			$section_1_content         = $section_1_content == 'slider'?1:$section_1_content;
			
			if( $animated == '1' || $animated == 'on' )
				$onetone_animated = 'onetone-animated';
			
			$new_homepage_section = array();
			// order
			$home_sections = onetone_option('section_order');
			
			if( is_array($home_sections) && !empty($home_sections) ){
					$new_homepage_section = $home_sections;
			  }else{
					$new_homepage_section = $onetone_home_sections;
			}
			
			if( !is_array($home_sections) || empty($home_sections) ){
				$new_homepage_section = onetone_section_templates();
			}
			
			$i = 0 ;
			global $onetone_section_id, $onetone_section_part;
			foreach( $new_homepage_section as $section ):
			$section_css_class  = '';
			$onetone_section_id = $section['id'];
			$section_part       = $section['type'];
			$onetone_section_part = $section_part;
			
			$hide_section  = onetone_option( 'section_hide_'.$onetone_section_id );
						
			if( ($hide_section != '1' && $hide_section != 'on') || ( function_exists('is_customize_preview') && is_customize_preview() )){
				
				$content_model       = onetone_option( 'section_content_model_'.$onetone_section_id);
				$section_css_class   = onetone_option( 'section_css_class_'.$onetone_section_id );
				$parallax_scrolling  = onetone_option( 'parallax_scrolling_'.$onetone_section_id );
				$full_width          = onetone_option( 'full_width_'.$onetone_section_id );
				$section_id          = sanitize_title( onetone_option( 'menu_slug_'.$onetone_section_id ) );
  
				if( $section_id == '' )
					$section_id = 'section-'.$onetone_section_id;
				 
				$section_id  = strtolower( $section_id );
				
				$container_class = "container";
				if( $full_width == "yes" ){
					$container_class = "";
				}
				
				 
				$section_css_class .= ' section home-section-'.$onetone_section_id;
				if($onetone_section_id == 0){
					$section_css_class .= ' home-banner';
					
				}
					
				if( ($parallax_scrolling == "yes" || $parallax_scrolling == "1" || $parallax_scrolling == "on") ){
					$section_css_class  .= ' onetone-parallax';
				}
				
				if( ($hide_section == '1' || $hide_section == 'on') && function_exists('is_customize_preview') && is_customize_preview() )
					$section_css_class .= ' hide';
				
				if( $onetone_section_id == 0 && ($section_1_content == '1' || $section_1_content == 'on' )){
		
					get_template_part('home-sections/section','slider');
					
					}else{
		  
							  echo '<section id="'.esc_attr($section_id).'" class="'.esc_attr($section_css_class).'">';
						  if( ($video_background_section-1) == $onetone_section_id  ){
							  get_template_part('home-sections/section',$video_background_type.'-video');
						  }
						  else{

							  echo '<div class="section-content">';
							  echo '<div class="home-container '.esc_attr($container_class).' page_container">';
							  get_template_part('home-sections/section',intval($section_part));
							  echo '</div>';
							  echo '<div class="clear"></div>';
							  echo '</div>';
							  
						  }
						echo '</section>';
				
				}
			
			}
			$i++;
			endforeach;
			?>
            <div class="clear"></div>
          </article>
          <?php else: ?>
           <?php
				while ( have_posts() ) : the_post();

					the_content();

				endwhile;
			?>
          <?php endif;?>
        </section>
      </div>
    </div>
  </div>
</div>
<?php get_footer();