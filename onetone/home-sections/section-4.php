<?php
// section team
 global $onetone_animated, $onetone_section_id;
 $i                   = $onetone_section_id ;
 $section_title       = onetone_option( 'section_title_'.$i );
 $section_menu        = onetone_option( 'menu_title_'.$i );
 $section_content     = onetone_option( 'section_content_'.$i );
 
 $content_model       = onetone_option( 'section_content_model_'.$i);
 $section_subtitle    = onetone_option( 'section_subtitle_'.$i );
 $columns             = absint(onetone_option('section_team_columns_'.$i));
 $col                 = $columns>0?12/$columns:3;
 $columns             = ($columns == 0)?4:$columns;
 $style               = absint(onetone_option('section_team_style_'.$i));

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
      <h2 class="section-title <?php echo esc_attr($section_title_class); ?>  <?php echo 'section_title_'.$i;?>"><?php echo wp_kses_post($section_title);?></h2>
      <?php endif;?>
      <?php if( $section_subtitle != '' || (function_exists('is_customize_preview') && is_customize_preview()) ):?>
      <div class="section-subtitle  <?php echo 'section_subtitle_'.$i;?>"><?php echo do_shortcode(wp_kses_post($section_subtitle))?></div>
      <?php endif;?>
      <div class="home-section-content section_team_<?php echo $i; ?>">
      <div class="onetone-owl-carousel-wrap <?php echo $onetone_animated;?>" data-animationduration="0.9" data-animationtype="fadeInDown" data-imageanimation="no">
      <?php 
	  $str = array_merge(range(0,9),range('a','z')); 
      shuffle($str); 
	  $str = implode('',array_slice($str,0,5)); 
	  $carousel_id = "onetone-carousel-".$str;
	  ?>
        <div id="onetone-team-carousel" class="onetone-owl-carousel owl-carousel owl-theme <?php echo $carousel_id;?>">
          <?php
	 $team_item = '';
	 $section_team  = onetone_option( 'section_team_'.$i ); 
		if (is_array($section_team) && !empty($section_team) ){
			foreach($section_team as $person ){

				$avatar      =  $person['avatar'];
				$link        =  $person['link'];
				$name        =  esc_attr($person['name']);
				$byline      =  esc_attr($person['byline']);
				$target      =  isset($person['target'])?esc_attr($person['target']):'_blank';
				$description =  wp_kses_post(do_shortcode($person['description']));
				if (is_numeric($avatar)) {
					$image_attributes = wp_get_attachment_image_src($avatar, 'full');
					$avatar       = $image_attributes[0];
				  }
			   
				

					if( $link!='' )
						$image = '<a href="'.esc_url($link).'" target="'.$target.'"><img src="'.esc_url($avatar).'" alt="'.$name.'" style="border-radius: 0; display: inline-block;border-style: solid;" />
					<div class="img-overlay primary">
					  <div class="img-overlay-container">
						<div class="img-overlay-content"><i class="fa fa-link"></i></div>
					  </div>
					</div>
					</a>';
					else
					$image = '<img src="'.esc_url($avatar).'" alt="'.$name.'" />';
					
				 $icons = '';
				for( $k=0;$k<4;$k++){
					$icon = str_replace('fa-','',esc_attr($person['icon_'.$k]));
					$link = esc_url($person['icon_link_'.$k]);
					if( $icon != '' ){
					$icons .= '<li><a href="'.$link.'" target="'.$target.'"><i class="fa fa-'.$icon.'"></i></a></li>';
					}
				}
				
				  $team_item .= '<div class="onetone-carousel-item">
									<div class="magee-person-box">
									  <div class="person-img-box">
										<div class="img-box figcaption-middle text-center fade-in">'.$image.'</div>
									  </div>
									  <div class="person-vcard text-center">
										<h3 class="person-name" style="text-transform: uppercase;">'.$name.'</h3>
										<h4 class="person-title" style="text-transform: uppercase;">'.$byline.'</h4>
										<p class="person-desc">'.do_shortcode($description).'</p>
										<ul class="person-social">
										 '.$icons.'
										</ul>
									  </div>
									</div>
								</div>';
				 
			   }
	}

	 echo $team_item;
	?>
        </div>
      </div>
    </div>
    <script>
jQuery(document).ready(function($){
	$(".<?php echo $carousel_id;?>").owlCarousel({
		items:<?php echo absint($columns);?>,
		nav:false,
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
       <h2 class="section-title <?php echo esc_attr($section_title_class); ?> <?php echo 'section_title_'.$i;?>"><?php echo wp_kses_post($section_title);?></h2>
        <?php endif;?>
        <?php if( $section_subtitle != '' || (function_exists('is_customize_preview') && is_customize_preview()) ):?>
        <div class="section-subtitle <?php echo 'section_subtitle_'.$i;?>"><?php echo do_shortcode(wp_kses_post($section_subtitle))?></div>
         <?php endif;?>
        <div class="home-section-content section_team_<?php echo $i; ?>">
        <?php
	 $team_item = '';
	 $team_str  = '';
	 $j         = 0;
	 $section_team  = onetone_option( 'section_team_'.$i ); 
	 
		if (is_array($section_team) && !empty($section_team) ){
			foreach($section_team as $person ){
	   
	 			$avatar      =  $person['avatar'];
				$link        =  $person['link'];
				$name        =  esc_attr($person['name']);
				$byline      =  esc_attr($person['byline']);
				$target      =  isset($person['target'])?esc_attr($person['target']):'_blank';
				$description =  wp_kses_post(do_shortcode($person['description']));
				
				if (is_numeric($avatar)) {
					$image_attributes = wp_get_attachment_image_src($avatar, 'full');
					$avatar       = $image_attributes[0];
				  }
	 
	  
	
					if( $link!='' )
						$image = '<a href="'.esc_url($link).'" target="'.$target.'"><img src="'.esc_url($avatar).'" alt="'.$name.'" style="border-radius: 0; display: inline-block;border-style: solid;" />
								  <div class="img-overlay primary">
									<div class="img-overlay-container">
									  <div class="img-overlay-content"><i class="fa fa-link"></i></div>
									</div>
								  </div>
								  </a>';
				  else
				  	$image = '<img src="'.esc_url($avatar).'" alt="'.$name.'" />';
				  
			  $icons = '';
			  for( $k=0;$k<4;$k++){
					$icon = str_replace('fa-','',esc_attr($person['icon_'.$k]));
					$link = esc_url($person['icon_link_'.$k]);
					if( $icon != '' ){
					$icons .= '<li><a href="'.$link.'" target="'.$target.'"><i class="fa fa-'.$icon.'"></i></a></li>';
					}
				}
			  
				$team_item .= '<div class="col-md-'.$col.'">
				<div class="'.$onetone_animated.'" data-animationduration="0.9" data-animationtype="fadeInDown" data-imageanimation="no">
								  <div class="magee-person-box" id="">
									<div class="person-img-box">
									  <div class="img-box figcaption-middle text-center fade-in">'.$image.'</div>
									</div>
									<div class="person-vcard text-center">
									  <h3 class="person-name" style="text-transform: uppercase;">'.$name.'</h3>
									  <h4 class="person-title" style="text-transform: uppercase;">'.$byline.'</h4>
									  <p class="person-desc">'.do_shortcode($description).'</p>
									  <ul class="person-social">
									   '.$icons.'
									  </ul>
									</div>
								  </div>
								  </div>
								</div>';
				$m = $j+1;
				if( $m % $columns == 0 ){
					  $team_str .= '<div class="row">'.$team_item.'</div>';
					  $team_item = '';
				 }

				 $j++;
			}
	 }
	 if( $team_item != '' ){
		    $team_str .= '<div class="row">'.$team_item.'</div>';
	      
		   }
		
	 echo $team_str;
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
    <div class="home-section-content">
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