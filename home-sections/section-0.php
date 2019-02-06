<?php
 global $onetone_animated, $onetone_section_id;
 $i                   = $onetone_section_id ;
 $section_title       = onetone_option( 'section_title_'.$i );
 $section_menu        = onetone_option( 'menu_title_'.$i );
 $section_content     = onetone_option( 'section_content_'.$i );
 
 $content_model       = onetone_option( 'section_content_model_'.$i);
 $section_subtitle    = onetone_option( 'section_subtitle_'.$i );
 $btn_text            = onetone_option( 'section_btn_text_'.$i );
 $btn_link            = onetone_option( 'section_btn_link_'.$i );
 $btn_target          = onetone_option( 'section_btn_target_'.$i );
 $icons               = onetone_option( 'section_icons_'.$i );
 $section_icon        = onetone_option( 'section_icon_'.$i );
 
 if( !isset($section_content) || $section_content=="" ) 
 	$section_content = onetone_option( 'sction_content_'.$i );
    
 
		if( $content_model == '0' || $content_model == ''  ):
?>
       <div class="<?php echo $onetone_animated; ?>" data-animationduration="0.9" data-animationtype="bounceInDown" data-imageanimation="no">
        
          <div class="section-title-container">
          <?php if( $section_icon !='' ):?>
           <img class="section-banner-icon" src="<?php echo esc_url($section_icon); ?>" alt="<?php echo esc_attr($section_title);?>" />
          <?php endif; ?>
          <?php if( $section_title != '' || (function_exists('is_customize_preview') && is_customize_preview()) ):?>
            <h2 class="magee-heading heading-border section-title"><span class="heading-inner <?php echo 'section_title_'.$i;?>"><?php echo esc_attr($section_title);?></span></h2>
            <?php endif; ?>
          </div>
          <?php if( $section_subtitle != '' || (function_exists('is_customize_preview') && is_customize_preview()) ):?>
          <div style="margin-top: 50px; " class="section-subtitle <?php echo 'section_subtitle_'.$i;?>"><?php echo do_shortcode(wp_kses_post($section_subtitle));?></div>
          <?php endif; ?>
          <div class="home-section-content">
          <div style="margin-top: 20px;">
            
            <?php if( $btn_text != ''):?>
            <a href="<?php echo esc_url($btn_link);?>" target="<?php echo esc_attr($btn_target);?>" class=" magee-btn-normal banner-scroll btn-lg btn-line btn-light <?php echo 'section_btn_text_'.$i; ?>" style="text-decoration: none;"><?php echo do_shortcode(esc_attr($btn_text));?></a> 
               <?php endif;?>
            </div>
           <?php 
		   $icon_items = '';
		   $section_banner_icons  = onetone_option( 'section_banner_icons_'.$i ); 
			if (is_array($section_banner_icons) && !empty($section_banner_icons) ){
				foreach($section_banner_icons as $item ){
			 
				   $icon       = $item[ "icon" ];
				   $link       = $item[ "icon_link" ];
				   if( $icon !='' )
				   $icon_items .= ' <li><a href="'.esc_url($link).'" target="_blank"><i class="fa fa-2 '.esc_attr($icon).'">&nbsp;</i></a></li>';
					
				}
			}
		   
		   if ($icon_items!=''){
			   echo '<div class="banner-sns section_banner_icons" style="margin-top: 50px;"><ul>'.$icon_items.'</ul></div>';
			   }
		   ?>
          
        </div>
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
        