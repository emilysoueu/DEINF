<?php
// Section gallery
 global $onetone_animated, $onetone_section_id;
 $i                   = $onetone_section_id ;
 $section_title       = onetone_option( 'section_title_'.$i );
 $section_menu        = onetone_option( 'menu_title_'.$i );
 $section_content     = onetone_option( 'section_content_'.$i );
	
 $content_model       = onetone_option( 'section_content_model_'.$i);
 $section_subtitle    = onetone_option( 'section_subtitle_'.$i );
 
 if( !isset($section_content) || $section_content=="" ) 
 	$section_content = onetone_option( 'sction_content_'.$i );
  
?>
         <?php
		if( $content_model == '0' || $content_model == ''  ):
		?>
        
         <?php if( $section_title != '' || (function_exists('is_customize_preview') && is_customize_preview()) ):?>
       <?php  
		   $section_title_class = '';
		   if( $section_subtitle == '' && !(function_exists('is_customize_preview') && is_customize_preview()))
		   $section_title_class = 'no-subtitle';
		?>
       <h2 class="section-title <?php echo esc_attr($section_title_class); ?> <?php echo 'section_title_'.$i;?>"><?php echo wp_kses_post($section_title);?></h2>
        <?php endif;?>
        <?php if( $section_subtitle != '' || (function_exists('is_customize_preview') && is_customize_preview()) ):?>
        <div class="section-subtitle <?php echo 'section_subtitle_'.$i;?>"><?php echo do_shortcode(wp_kses_post($section_subtitle))?></div>
         <?php endif;?>
         <div class="home-section-content section-gallery">
		 <?php
		$items = '';
		$item  = '';
		$j     = 0;
		$c     = 0;
		$animationtype = array('fadeInLeft','fadeInDown','fadeInRight','fadeInLeft','fadeInUp','fadeInRight','fadeInUp','fadeInUp','fadeInUp','fadeInUp','fadeInUp','fadeInUp');
		$section_gallery  = onetone_option( 'section_gallery_'.$i ); 
		if (is_array($section_gallery) && !empty($section_gallery) ){
			foreach($section_gallery as $gallery_item ){
				 $image  = $gallery_item[ "image" ];
				 $link   = esc_url($gallery_item[ "link" ]);
				 $target = esc_attr($gallery_item[ "target" ]);
				 
				 $title = '';
				 if (is_numeric($image)) {
					$image_attributes = wp_get_attachment_image_src($image, 'full');
					$title = get_post($image)->post_title;
					$image       = $image_attributes[0];
				  }
				 
				 if($image !=''){
					 if( $link == "" )
						 $img_wrap = '<a href="'.esc_url($image).'" class="onetone-portfolio-image" title="'.esc_attr($title).'"><img src="'.esc_url($image).'" alt="'.esc_attr($title).'"  class="feature-img "><div class="img-overlay dark">
																						<div class="img-overlay-container">
																							<div class="img-overlay-content">
																								<i class="fa fa-search"></i>
																							</div>
																						</div>
																					</div></a>';
					 else
						 $img_wrap = '<a href="'.$link.'" target="'.$target.'" title="'.esc_attr($title).'"><img src="'.esc_url($image).'" alt="'.esc_attr($title).'" class="feature-img "><div class="img-overlay dark">
																						<div class="img-overlay-container">
																							<div class="img-overlay-content">
																								<i class="fa fa-link"></i>
																							</div>
																						</div>
																					</div></a>';
				  
					
						
				$item .= '<div class="col-md-4">
				<div class="'.$onetone_animated.'" data-animationduration="0.9" data-animationtype="'.$animationtype[$c].'" data-imageanimation="no">
			  <div class="magee-feature-box style1" data-os-animation="fadeOut">
				<div class="img-frame"><div class="img-box figcaption-middle text-center fade-in">'.$img_wrap.'</div></div>
			</div></div></div>';
				 if( ($j+1) % 3 == 0){
					 $items .= '<div class="row no-padding no-margin">'.$item.'</div>';
					 $item = '';
					 }
					 $j++;
				}
				$c++;
			}
		}
		if( $item != '' ){ $items .= '<div class="row no-padding no-margin">'.$item.'</div>';}
		echo $items;
		?>
        </div>
         <?php
		else:
		?>
        <?php if( $section_title != '' || (function_exists('is_customize_preview') && is_customize_preview()) ):?>
        <div class="section-title <?php echo 'section_title_'.$i;?>"><?php echo esc_attr($section_title);?></div>
        <?php endif;?>
          
            <div class="home-section-content <?php echo 'section_content_'.$i;?>">
            <?php 
			if(function_exists('Form_maker_fornt_end_main'))
             {
                 $section_content = Form_maker_fornt_end_main($section_content);
              }
			 echo do_shortcode(wp_kses_post($section_content));
			?>
            </div>
            <?php 
		endif;
		?>