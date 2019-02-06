<?php
 global $onetone_animated, $onetone_section_id;
 $i                   = $onetone_section_id ;
 $section_title       = onetone_option( 'section_title_'.$i );
 $section_menu        = onetone_option( 'menu_title_'.$i );
 $section_content     = onetone_option( 'section_content_'.$i );
 $content_model       = onetone_option( 'section_content_model_'.$i);
 $section_subtitle    = onetone_option( 'section_subtitle_'.$i );
 $left_content        = onetone_option( 'section_left_content_'.$i );
 $right_content       = onetone_option( 'section_right_content_'.$i );

 if( !isset($section_content) || $section_content=="" ) 
 	$section_content = onetone_option( 'sction_content_'.$i );


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
        <div class="section-subtitle <?php echo 'section_subtitle_'.$i;?>"><?php echo do_shortcode(wp_kses_post($section_subtitle));?></div>
         <?php endif;?>
         <div class="home-section-content">
         <div class="row">
         <div class="col-md-8"><div class="<?php echo $onetone_animated;?> <?php echo 'section_left_content_'.$i;?>" data-animationduration="0.9" data-animationtype="fadeInLeft" data-imageanimation="no"><?php echo do_shortcode(wp_kses_post($left_content));?></div></div>
         <div class="col-md-4"><div class="<?php echo $onetone_animated;?> <?php echo 'section_right_content_'.$i;?>" data-animationduration="0.9" data-animationtype="fadeInRight" data-imageanimation="no"><?php echo do_shortcode(wp_kses_post($right_content));?></div></div>
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