<?php
 // Section service
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
       <h2 class="section-title <?php echo esc_attr($section_title_class); ?> <?php echo 'section_title_'.$i;?>"><?php echo wp_kses_post($section_title);?></h2>
        <?php endif;?>
        <?php if( $section_subtitle != '' || (function_exists('is_customize_preview') && is_customize_preview()) ):?>
        <div class="section-subtitle <?php echo 'section_subtitle_'.$i;?>"><?php echo do_shortcode(wp_kses_post($section_subtitle))?></div>
         <?php endif;?>
        <div class="home-section-content"> 
        <?php
		$services = '';
		$service  = '';
		$d        = 0;
		$section_service  = onetone_option( 'section_service_'.$i ); 

		if (is_array($section_service) && !empty($section_service) ){
			foreach($section_service as $item ){
				 $image  = $item[ "image" ];
				 $icon   = esc_attr($item[ "icon" ]);
				 $title_ = esc_attr($item[ "title" ]);
				 $desc   = wp_kses_post($item[ "description" ]);
				 $link   = esc_url($item[ "link" ]);
				 $target = esc_attr($item[ "target" ]);
				 if (is_numeric($image)) {
					$image_attributes = wp_get_attachment_image_src($image, 'full');
					$image       = $image_attributes[0];
				  }
				 
				 $icon = str_replace('fa-','',$icon);
				 $icon = str_replace('fa ','',$icon);
				 
				 if( !($icon =='' && $title_=='' && $desc=='') ):
				 if( $link == "" )
					$title = $title_;
				 else
					 $title = '<a href="'.$link.'" target="'.$target.'">'.$title_.'</a>';
			  
				 if( $image !='' )
					$service_icon = '<img src="'.esc_url($image).'" alt="'.esc_attr($title_).'" />';
				 else
					 $service_icon = '<div class="icon-box" data-animation=""> <i class="feature-box-icon fa fa-'.esc_attr($icon).'"></i></div>';
				 
				 if( $link != "" )
					$service_icon = '<a href="'.$link.'" target="'.$target.'">'.$service_icon.'</a>';
					
			$service .= '<div class="col-md-4">
			<div class="'.$onetone_animated.'" data-animationduration="0.9" data-animationtype="zoomIn" data-imageanimation="no">
		  <div class="magee-feature-box style1" data-os-animation="fadeOut">
			'.$service_icon.'
			<h3 class="section_service_'.$i.'_title_'.$d.'">'.$title.'</h3>
			<div class="feature-content">
			  <p class="section_description_'.$i.'_title_'.$d.'">'.do_shortcode($desc).'</p>
			  <a href="" target="_blank" class="feature-link"></a></div>
		  </div></div>
		</div>';
			 if( ($d+1) % 3 == 0){
				 $services .= '<div class="row">'.$service.'</div>';
				 $service = '';
				 }
				 
				 $d++;
				 endif;
			 
			}
		}
		if( $service != '' ){ $services .= '<div class="row">'.$service.'</div>';}
		echo $services;
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