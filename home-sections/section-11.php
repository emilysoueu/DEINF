<?php
 global $onetone_animated, $onetone_section_id;
 $i                   = $onetone_section_id ;
 $section_title       = onetone_option( 'section_title_'.$i );
 $section_menu        = onetone_option( 'menu_title_'.$i );
 $section_content     = onetone_option( 'section_content_'.$i );
 
 $content_model       = onetone_option( 'section_content_model_'.$i);
 $section_subtitle    = onetone_option( 'section_subtitle_'.$i );
 $side_menu_color     = onetone_option( 'side_menu_color_'.$i );
 $columns             = onetone_option( 'section_columns_'.$i );
 $posts_num           = onetone_option( 'section_posts_num_'.$i );
 $category            = onetone_option( 'section_category_'.$i );
 $col                 = $columns>0?12/$columns:4;

	
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
         <div class="home-section-content">
         <div class="<?php echo $onetone_animated;?>" data-animationduration="0.9" data-animationtype="fadeIn" data-imageanimation="no">
<?php
	$defaults = array(
		'num' 	                     => $posts_num,
		'category'                 	 => $category,
		'column'                     => $columns,
		'style'                      => '1',
		'id'                         =>'',
		'class'                      =>'',
		'page_nav'                   =>'no',
		'offset'                     => '0',
		'exclude_category'           => '',
		'display_image'              => 'yes',
		'display_title'              => 'yes',
		'display_meta'               => 'yes',
		'display_excerpt'            => 'yes',
		'excerpt_length'             => '',
		'strip'                      => 'yes'
	);

	extract( $defaults );
		 
	$class_column = 'col-md-4'; 
	switch( $column ){
		case "1":
		$class_column = 'col-md-12';
		break;
		case "2":
		$class_column = 'col-md-6';
		break;
		case "3":
		$class_column = 'col-md-4';
		break;
		case "4":
		$class_column = 'col-md-3';
		break;
		}
		if( !is_numeric($column) || $column<=0 )
		$column = 3;
	
    if( intval($offset) || intval($offset)>0):
		$offset = intval($offset);
    else:
   		$offset = 0;
	endif;
	
	$style = absint($style);
		 
    $html = '<div id="'.esc_attr($id).'" class="shortcode-blog-list-wrap magee-shortcode magee-blog  '.esc_attr($class).'">';
    $page =(get_query_var('paged'))? absint(get_query_var('paged')): 1;
    $wp_query = new WP_Query();
	$exclude_id = array();
	$exclude_categories = explode(',',$exclude_category);
	foreach($exclude_categories as $exclude_category ){
		$exclude_id_obj = get_category_by_slug( $exclude_category );
		if ( $exclude_id_obj ) {
			 $exclude_id[] = '-'.$exclude_id_obj->term_id;
		}
	}
	$exclude_ids = implode(',',$exclude_id);

	if( absint($offset) >0 ):
		$wp_query -> query('showposts='.$num.'&cat='.$category.'&paged='.$page.'&offset='.$offset.'&category__not_in= '.$exclude_ids."&post_status=publish&ignore_sticky_posts=1"); 
	else:
		$wp_query -> query('showposts='.$num.'&cat='.$category.'&paged='.$page.'&category__not_in= '.$exclude_ids."&post_status=publish&ignore_sticky_posts=1"); 
	endif;
	$i = 1 ;
	$html_item = '';
	
	if( $style == '4'  ):			 
		$html .= '<div class="blog-timeline-wrap">
				<div class="blog-timeline-icon">
					<i class="fa fa-comments"></i>
				</div>
				<div class="blog-timeline-inner">
					<div class="blog-timeline-line"></div>
					<div class="blog-list-wrap blog-timeline clearfix">';
										
	endif;
	
	
	if ($wp_query -> have_posts()) :
    while ( $wp_query -> have_posts() ) : $wp_query -> the_post();
	
	$featured_image = '';
	if( has_post_thumbnail() ){
	    
		$thumbnail_id     = get_post_thumbnail_id(get_the_ID());
		$image_attributes = wp_get_attachment_image_src( $thumbnail_id, "related-post" );
		
		$imageInfo     = get_post($thumbnail_id);
		$image_title   = get_the_title();
		if( isset( $imageInfo->post_title) )
			$image_title   = $imageInfo->post_title;
		
		if( $display_image == 'yes'):
			$featured_image = '<div class="feature-img-box"><div class="img-box figcaption-middle text-center from-top fade-in">
								  <a href="'.get_permalink().'" >
									  <img src="'.esc_url($image_attributes[0]).'" alt="'.esc_attr($image_title).'" class="feature-img">
									  <div class="img-overlay dark">
										  <div class="img-overlay-container">
											  <div class="img-overlay-content">
												  <i class="fa fa-link"></i>
											  </div>
										  </div>                                                        
									  </div>
								  </a>
							  </div>
						</div>';
		endif;													
		}
	    
	if( $style == '1' ):
	
	$html_item .= '<div class="'.$class_column.'">
					<div class="entry-box-wrap">
						<article class="entry-box" role="article">
							   '.$featured_image.'                                             
							<div class="entry-main">
								<div class="entry-header">' ;
								
									if( $display_title == 'yes')  
									$html_item .= '<a href="'.get_permalink().'"><h2 class="entry-title">'.get_the_title().'</h2></a>' ;
									
									if( $display_meta == 'yes')
									$html_item .= '<ul class="entry-meta" >
										<li class="entry-date"><i class="fa fa-calendar"></i><a href="'.get_month_link(get_the_time('Y'), get_the_time('m')).'">'.get_the_date( ).'</a></li>
										<li class="entry-comments pull-right">'.onetone_get_comments_popup_link('', __( '<i class="fa fa-comment"></i> 1 ', 'onetone'), __( '<i class="fa fa-comment"></i> % ', 'onetone'), 'read-comments', '').'</li>
									</ul>';
									
								$html_item .= '</div>';
								
									if( $display_excerpt == 'yes'):
										$html_item .= '<div class="entry-summary" >';
											if( $strip == 'yes'):
												if(intval($excerpt_length) || intval($excerpt_length)>0):
													 $html_item .= strip_tags(onetone_get_excerpt($excerpt_length)) ;
												else:
													 $html_item .= strip_tags(onetone_get_excerpt()) ;
												endif;
											else:
												if(intval($excerpt_length) || intval($excerpt_length)>0):
													 $html_item .= onetone_get_excerpt($excerpt_length);
												else:
													 $html_item .= onetone_get_excerpt() ;
												endif;
											endif;	 
										$html_item .= '</div>';
									else:
										$html_item .= '<div class="entry-summary" ></div>';        
									endif;
						   $html_item .=  '</div> 
						</article>
					</div>
				</div>';
	if( $i%$column == 0 ):
		$html .= '<div class="row">'.$html_item.'</div>';
		$html_item = '';
	endif;					
											
	endif;	
	if( $style == '2' ):
		$col_image   = '';
		$col_content = 'col-md-12';
		if($featured_image){
			$col_image   = 'col-md-4';
			$col_content = 'col-md-8';
		}
		$html_item .= '<div class="'.$class_column.'">
						  <div class="entry-box-wrap">
							  <article class="entry-box row" role="article">
								  <div class="entry-aside '.$col_image.'">
									  '.$featured_image.'
								  </div>
								  <div class="entry-main '.$col_content.'">
									  <div class="entry-header">';
									  
										  if($display_title == 'yes')
										  	$html_item .= '<a href="'.esc_url(get_permalink()).'"><h2 class="entry-title">'.get_the_title().'</h2></a>' ;
										  
										  if($display_meta == 'yes')
										  	$html_item .= ' <ul class="entry-meta">
											  <li class="entry-date"><i class="fa fa-calendar"></i><a href="'.esc_url(get_month_link(get_the_time('Y'), get_the_time('m'))).'">'.get_the_date( $date_format ).'</a></li>
											  <li class="entry-comments pull-right">'.onetone_get_comments_popup_link('', __( '<i class="fa fa-comment"></i> 1 ', 'onetone'), __( '<i class="fa fa-comment"></i> % ', 'onetone'), 'read-comments', '').'</li>
										  </ul>';
										  
							$html_item .= '</div>' ;
							
									  if( $display_excerpt == 'yes'){
										$html_item .= '<div class="entry-summary" style="display:block;">';
											if( $strip == 'yes'):
												if(is_int($excerpt_length) || $excerpt_length>0):
													$html_item .= strip_tags(onetone_get_excerpt($excerpt_length)) ;
												else:
													$html_item .= strip_tags(onetone_get_excerpt()) ;
												endif;
											else:
												if(is_int($excerpt_length) || $excerpt_length>0):
													$html_item .= onetone_get_excerpt($excerpt_length) ;
												else:
													$html_item .= onetone_get_excerpt() ;
												endif;
											endif;	
										$html_item .= '</div>';
									  }
								$html_item .= '</div>
							  </article>
						  </div>
					  </div>';
								
		if( $i%$column == 0 ){
			$html .= '<div class="row">'.$html_item.'</div>';
			$html_item = '';
			}
											
	endif;
	
	if( $style == '3' ):
	
		$col_image   = '';
		$col_content = 'col-md-12';
		if($featured_image){
			$col_image   = 'col-md-4';
			$col_content = 'col-md-8';
		}
		
		$html_item .= '<div class="'.$class_column.'">
						  <div class="entry-box-wrap">
							  <article class="entry-box row">
								  <div class="entry-aside '.$col_image.'">
									  '.$featured_image.'
								  </div>
								  <div class="entry-main '.$col_content.'">
									  <div class="entry-header">';
							if( $display_title == 'yes')
								$html_item .= '<a href="'.get_permalink().'"><h2 class="entry-title">'.get_the_title().'</h2></a>' ;
							if( $display_meta == 'yes')
								$html_item .=  onetone_posted_on(false);
							$html_item .= '</div>' ;
							  
							if( $display_excerpt == 'yes'){
								$html_item .= '<div class="entry-summary">';
								if( $strip == 'yes'):
									if(is_int($excerpt_length) || $excerpt_length>0):
										$html_item .= strip_tags(substr(onetone_get_excerpt(),0,$excerpt_length)) ;
									else:
											$html_item .= strip_tags(onetone_get_excerpt()) ;
									endif;
								else:
									if(is_int($excerpt_length) || $excerpt_length>0):
										$html_item .= onetone_get_excerpt().substring(0,$excerpt_length) ;
									else:
										$html_item .= onetone_get_excerpt() ;
									endif;
							endif;
						  $html_item .= '</div>';
						  }
						  
						  $html_item .= '<div class="entry-footer"><a href="'.esc_url(get_permalink()).'" class="pull-right">'. __('Read More', 'onetone').' &gt;&gt;</a></div></div></article></div></div>';
								
		if( $i%$column == 0 ):
			$html .= '<div class="row">'.$html_item.'</div>';
			$html_item = '';
		endif;
	  
	endif;
	
	if( $style == '4' ):
	
	  if( $i % 2 == 0 )
		  $position = 'left';
	  else
		  $position = 'right';
	  
	  $html .= '<div class="entry-box-wrap timeline-'.$position.'">
					  <article class="entry-box" role="article">
						   '.$featured_image.'
						  <div class="entry-main">
							  <div class="entry-header">';
							  
							  if( $display_title == 'yes') 
								  $html .= '<a href="'.esc_url(get_permalink()).'" style="display:block;"><h2 class="entry-title">'.get_the_title().'</h2></a>';
								  
							  if( $display_meta == 'yes')
								  $html .=  onetone_posted_on(false);
								  
							  $html .= '</div>';
							  
							  if( $display_excerpt == 'yes'){
								  $html .= '<div class="entry-summary">';
								  
								   if( $strip == 'yes'):
									   if(is_int($excerpt_length) || $excerpt_length>0):
									   $html .= strip_tags(substr(onetone_get_excerpt(),0,$excerpt_length)) ;
									   else:
									   $html .= strip_tags(onetone_get_excerpt()) ;
									   endif;
								   else:
									   if(is_int($excerpt_length) || $excerpt_length>0):
									   $html .= onetone_get_excerpt().substring(0,$excerpt_length) ;
									   else:
									   $html .= onetone_get_excerpt() ;
									   endif;
								   endif;		 
							  $html .= '</div>';
							  }
						  $html .= '</div>
					  </article>
				  </div>';		
	
	endif;

	$i++;
	endwhile;
	endif;
	
	if( $html_item != '' && $style != '4' )
		$html .= '<div class="row">'.$html_item.'</div>';
	
	if($style == '4'){
		$html .= '</div></div></div>';
	}
	
	if( $page_nav == 'yes')
		$html .= '<div class="row"><div class="list-pagition text-center">'.get_the_posts_pagination( array(
											 'mid_size' => 3,
												'prev_text' => '<i class="fa fa-angle-double-left"></i><span class="screen-reader-text">' . __( 'Previous page', 'onetone' ) . '</span>',
												'next_text' => '<span class="screen-reader-text">' . __( 'Next page', 'onetone' ) . '</span><i class="fa fa-angle-double-right"></i>' ,
												'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'onetone' ) . ' </span>',
											) ).'</div></div>';
	$html .= '</div>';
	wp_reset_postdata();
	echo $html;
?>      
         </div>
          </div>
<?php else: ?>
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