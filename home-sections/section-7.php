<?php
// section testimonial
global $onetone_animated, $onetone_section_id;
 $i                   = $onetone_section_id ;
 $section_title       = onetone_option( 'section_title_'.$i );
 $section_menu        = onetone_option( 'menu_title_'.$i );
 $section_content     = onetone_option( 'section_content_'.$i ); 
 $content_model       = onetone_option( 'section_content_model_'.$i);
 $section_subtitle    = onetone_option( 'section_subtitle_'.$i );
 $columns             = absint(onetone_option('section_testimonial_columns_'.$i,3));
 $col                 = $columns>0?12/$columns:4;
 $columns             = ($columns == 0)?3:$columns;
 $style               = absint(onetone_option('section_testimonial_style_'.$i));

 if( !isset($section_content) || $section_content=="" ) 
 	$section_content = onetone_option( 'sction_content_'.$i );

		if( $content_model == '0' || $content_model == ''  ):
		
		if( $style == 1 ){ // carousel style
		?>
        
         <?php if( $section_title != '' || (function_exists('is_customize_preview') && is_customize_preview()) ):?>
       <?php  
		   $section_title_class = '';
		   if( $section_subtitle == '' && !(function_exists('is_customize_preview') && is_customize_preview()))
		   $section_title_class = 'no-subtitle';
		?>
       <h2 class="section-title <?php echo $section_title_class; ?>"><?php echo wp_kses_post($section_title);?></h2>
        <?php endif;?>
        <?php if( $section_subtitle != '' || (function_exists('is_customize_preview') && is_customize_preview()) ):?>
        <div class="section-subtitle"><?php echo do_shortcode(wp_kses_post($section_subtitle));?></div>
         <?php endif;?>
         <div class="home-section-content">
         <div class="onetone-owl-carousel-wrap">
  <div id="onetone-testimonial-carousel" class="onetone-owl-carousel owl-carousel owl-theme">
         
     <?php
	 $testimonial_item = '';
	 $m                = 0;
	 $section_testimonial  = onetone_option( 'section_testimonial_'.$i ); 

	 if (is_array($section_testimonial) && !empty($section_testimonial) ){
		foreach($section_testimonial as $client ){
	   
		  $avatar      =  $client['avatar'];
		  $name        =  esc_attr($client['name']);
		  $byline      =  esc_attr($client['byline']);
		  $description =  wp_kses_post(do_shortcode($client['description']));
		  if (is_numeric($avatar)) {
					$image_attributes = wp_get_attachment_image_src($avatar, 'full');
					$avatar       = $image_attributes[0];
				  }
	  
	      if( $avatar != '' )
	        $avatar = '<img src="'.esc_url($avatar).'" alt="'.$name.'" class="img-circle">';
    
		  $testimonial_item .= '<div class="onetone-carousel-item">
		  <div class="'.$onetone_animated.'" data-animationduration="0.9" data-animationtype="fadeInUp" data-imageanimation="no">
		 <div class="magee-testimonial-box">
		<div class="testimonial-content">
		  <div class="testimonial-quote">'.do_shortcode($description).'</div>
		</div>
		<div class="testimonial-vcard style1">
		  <div class="testimonial-avatar">'.$avatar.'</div>
		  <div class="testimonial-author">
			<h4 class="name" style="text-transform: uppercase;">'.$name.'</h4>
			<div class="title">'.$byline.'</div>
		  </div>
		</div>
	  </div>
	</div>
	</div>';
	  $m++;
	 }
	 }
		
	 echo $testimonial_item;
	?>
    </div>
    
    </div>
    </div>
    
    <script>
jQuery(document).ready(function($){
$("#onetone-testimonial-carousel").owlCarousel({
  items:<?php echo absint($columns);?>,
  nav:true,
  responsiveClass:true,
  loop: false,
  responsive:{
			  0:{
				items:1,
				dots:true
			  },
			  768:{
				items:2,
				dots:true
			  },
			  992:{
				items:3,
				dots:true
			  },
			   1200:{
				items:<?php echo absint($columns);?>,
				dots:true
			  },
		
			}
});
});  
    
</script>

<?php
 }else{ 
 // normal style 
?>


         <?php if( $section_title != '' || (function_exists('is_customize_preview') && is_customize_preview()) ):?>
       <?php  
		   $section_title_class = '';
		   if( $section_subtitle == '' && !(function_exists('is_customize_preview') && is_customize_preview()))
		   $section_title_class = 'no-subtitle';
		?>
       <h2 class="section-title <?php echo $section_title_class; ?>"><?php echo wp_kses_post($section_title);?></h2>
        <?php endif;?>
        <?php if( $section_subtitle != '' || (function_exists('is_customize_preview') && is_customize_preview()) ):?>
        <div class="section-subtitle"><?php echo do_shortcode(wp_kses_post($section_subtitle));?></div>
         <?php endif;?>
         <div class="home-section-content section_testimonial_<?php echo $i; ?>">
             <?php
	 $testimonial_item = '';
	 $testimonial_str  = '';
	 $m                = 0;
	  $section_testimonial  = onetone_option( 'section_testimonial_'.$i ); 

	 if (is_array($section_testimonial) && !empty($section_testimonial) ){
		foreach($section_testimonial as $client ){
	   
		  $avatar      =  $client['avatar'];
		  $name        =  esc_attr($client['name']);
		  $byline      =  esc_attr($client['byline']);
		  $description =  wp_kses_post(do_shortcode($client['description']));
		  if (is_numeric($avatar)) {
					$image_attributes = wp_get_attachment_image_src($avatar, 'full');
					$avatar       = $image_attributes[0];
				  }

	 	  if( $avatar != '' )
			  $avatar = '<img src="'.esc_url($avatar).'" alt="'.$name.'" class="img-circle">';
			
			  $testimonial_item .= '<div class="col-md-'.$col.'">
			  <div class="'.$onetone_animated.'" data-animationduration="0.9" data-animationtype="fadeInUp" data-imageanimation="no">
								  <div class="magee-testimonial-box">
			<div class="testimonial-content">
			  <div class="testimonial-quote">'.do_shortcode($description).'</div>
			</div>
			<div class="testimonial-vcard style1">
			  <div class="testimonial-avatar">'.$avatar.'</div>
			  <div class="testimonial-author">
				<h4 class="name" style="text-transform: uppercase;">'.$name.'</h4>
				<div class="title">'.$byline.'</div>
			  </div>
			</div>
		  </div>
		</div>
		</div>';
	  $m++;
	  
	  if( $m % $columns == 0 && $m>0 ){
	        $testimonial_str .= '<div class="row">'.$testimonial_item.'</div>';
	        $testimonial_item = '';
	   }

		}
	 }
	 if( $testimonial_item != '' ){
		    $testimonial_str .= '<div class="row">'.$testimonial_item.'</div>';
	      
		   }
		
	 echo $testimonial_str;
	?>
    </div>
<?php
		}
		//end
?>
<?php
		else:
		?>
        <?php if( $section_title != '' || (function_exists('is_customize_preview') && is_customize_preview()) ):?>
        <div class="section-title"><?php echo esc_attr($section_title);?></div>
        <?php endif;?>
           
            <div class="home-section-content  <?php echo 'section_content_'.$i;?>">
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