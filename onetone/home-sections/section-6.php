<?php
 global $onetone_animated, $onetone_section_id;
 $i                   = $onetone_section_id ;
 $section_title       = onetone_option( 'section_title_'.$i );
 $section_menu        = onetone_option( 'menu_title_'.$i );
 $section_content     = onetone_option( 'section_content_'.$i );
 
 $content_model       = onetone_option( 'section_content_model_'.$i);
 $section_subtitle    = onetone_option( 'section_subtitle_'.$i );

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
       <h2 class="section-title <?php echo $section_title_class; ?> <?php echo 'section_title_'.$i;?>"><?php echo wp_kses_post($section_title);?></h2>
        <?php endif;?>
        <?php if( $section_subtitle != '' || (function_exists('is_customize_preview') && is_customize_preview()) ):?>
        <div class="section-subtitle <?php echo 'section_subtitle_'.$i;?>"><?php echo do_shortcode(wp_kses_post($section_subtitle));?></div>
         <?php endif;?>
         <div class="home-section-content" >
  
  <?php
  $counters = '';
  for($c=1;$c<=4;$c++){
		 $title    = onetone_option( "counter_title_".$c."_".$i );
		 $number   = onetone_option( "counter_number_".$c."_".$i );
		 
		 if( $title !='' || $number!='' )
		   $counters .= '<div class="col-md-3">
			  <div class="onetone-counter-box">
				<div class="counter onetone-counter '."counter_number_".$c."_".$i.'"><span class="counter-num js-counter" data-from="0" data-to="'.absint($number).'" data-speed="3000" data-refresh-interval="100">'.absint($number).'</span></div>
				<div class="counter-bottom_title '."counter_title_".$c."_".$i.'"  style="font-size:24px">'.esc_attr($title).'</div>
			  </div>
			</div>';
	
     }
	 if( $counters !='' )
	   echo '<div class="row">'.$counters.'</div>';
	 
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