<?php

 /**
 * Get theme option name
 */
function onetone_option_name() {
	
	return 'onetone';
}

/**
 * Get option 
 */
function onetone_option( $name, $default='' ){
	
	global $onetone_options_db, $onetone_options_default;
	
	if(function_exists('is_customize_preview') && is_customize_preview()){
		$option_name = onetone_option_name();
		$options = get_option($option_name);
		if(isset($options[$name])){
			return $options[$name];
		}
	}

	if( !isset($onetone_options_db[$name]) ){
		
		$options = $onetone_options_default;
		
		if(isset($options[$name]['default'])){
			return $options[$name]['default'];
			}
		else
			return $default;
	}
	
	return $onetone_options_db[$name];
  }
  
/*	
*	get single option 
*	---------------------------------------------------------------------
*/
function onetone_option_saved($name,$default=''){
	
	global $onetone_options_db;

	if( !$onetone_options_db){
		$option_name  = onetone_option_name();
		$onetone_options_db = get_option($option_name);
	}
	if ( isset($onetone_options_db[$name]) ) {
		return $onetone_options_db[$name];
	}else{
		return $default;
	}
  }


/**
* Custom comments list
*/   
function onetone_comment($comment, $args, $depth) {
?>
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ;?>">
     <div id="comment-<?php comment_ID(); ?>">
     
     <div class="comment media-comment media">
        <div class="media-avatar media-left">
           <?php echo get_avatar($comment,'52','' ); ?>
        </div>
        <div class="media-body">
            <div class="media-inner">
                <h4 class="media-heading clearfix">
                    <?php echo get_comment_author_link();?> - <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ;?>">
<?php printf(__('%1$s at %2$s','onetone'), get_comment_date(), get_comment_time()) ;?></a>
                    <?php edit_comment_link(__('(Edit)','onetone'),'  ','') ;?>
                    <?php comment_reply_link(array_merge( $args, array('reply_text' => '<i class="fa fa-reply"></i> '. __('Reply','onetone'), 'depth' => $depth, 'max_depth' => $args['max_depth']))) ;?>
                </h4>
                
                <?php if ($comment->comment_approved == '0') : ?>
<em><?php _e('Your comment is awaiting moderation.','onetone') ;?></em>
<br />
<?php endif; ?>
               <?php comment_text() ;?>
            </div>
        </div>
    </div>
<div class="clear"></div>
</div>
<?php
}

/**
* Get homepage slider
*/
 	
function onetone_get_default_slider(){
	
	$sanitize_title = "home";
	$section_menu   = onetone_option( 'menu_title_0' );
	$section_slug   = onetone_option( 'menu_slug_0' );
	
	if( $section_menu  != "" ){
		
			$sanitize_title = sanitize_title($section_menu );
		
		if( trim($section_slug) !="" ){
			
			$sanitize_title = sanitize_title($section_slug); 
		   
		 }
 }	
	 
	$return = '<section id="'.$sanitize_title.'" class="section homepage-slider onetone-'.$sanitize_title.'"><div id="onetone-owl-slider" class="owl-carousel">';
	
	$section_slider  = onetone_option( 'onetone_slider' );
	$i = 1;
	if (is_array($section_slider) && !empty($section_slider) ){
		
		foreach($section_slider as $slide ){

		 $active     = '';
		 $text       = $slide['text'];
		 $image      = $slide['image'];
		 $btn_txt    = $slide['btn_txt'];
		 $btn_link   = $slide['btn_link'];
		 $btn_target = $slide['btn_target'];
		 if (is_numeric($image)) {
					$image_attributes = wp_get_attachment_image_src($image, 'full');
					$image       = $image_attributes[0];
				  }
		 
		 $btn_str    = '';
		 
		 if( $btn_txt != '' ){
			 
			 $btn_str    = '<br/><a class="btn" target="'.esc_attr($btn_target).'" href="'.esc_url($btn_link).'">'.do_shortcode(wp_kses_post($btn_txt)).'</a>';
			 
			 }
		
		 if( trim($image) != "" ){
			  $return .= '<div class="item"><img src="'.esc_url($image).'" alt="Slide image '.$i.'"><div class="inner"><div class="caption"><div class="caption-inner">'. do_shortcode(wp_kses_post($text)) .$btn_str.'</div></div></div></div>';
			  $i++;
	       }

	}
			}
	
		$return .= '</div></section>';

        return $return;
		
   }

/**
* Back to top
*/
 
function onetone_back_to_top(){
	
	$back_to_top_btn = onetone_option("back_to_top_btn");
	if( $back_to_top_btn != "hide" ){
		echo '<a href="javascript:;">
        	<div id="back-to-top">
        		<span class="fa fa-arrow-up"></span>
            	<span>'.__( 'TOP', 'onetone' ).'</span>
        	</div>
        </a>';
	}
}
        
add_action( 'wp_footer', 'onetone_back_to_top' );

/**
* Get social icon
*/
function onetone_get_social( $option_name = '',$placement = 'top'){
	
   $social_icons = onetone_option($option_name);
   $return       = '';
   
   if(is_array($social_icons) && !empty($social_icons)):
	   $return .= '<ul class="top-bar-sns">';
	   $i = 1;
	   foreach($social_icons as $social_icon ){ 
		  if( isset($social_icon['icon']) && $social_icon['icon'] !="" ){
			  $icon = str_replace('fa-','',$social_icon['icon']);
			  $icon = str_replace('fa ','',$social_icon['icon']);
			  $return .= '<li><a target="_blank" href="'.esc_url($social_icon['link']).'" data-placement="'.esc_attr($placement).'" data-toggle="tooltip" title="'.esc_attr( $social_icon['title'] ).'"><i class="fa fa-'.esc_attr( $icon ).'"></i></a></li>';
		  } 
		  $i++;
		} 
		$return .= '</ul>';
	endif;
	return $return ;
}
	

/**
* Get top bar content
*/
function onetone_get_topbar_content( $type =''){

	 switch( $type ){
		 case "info":
		    echo '<div class="top-bar-info">';
		    echo onetone_option('top_bar_info_content');
		    echo '</div>';
		 break;
		 case "sns":
		   echo onetone_get_social('header_social_icons','bottom');
		 break;
		 case "menu":
		   echo '<nav class="top-bar-menu">';
		   wp_nav_menu(array('theme_location'=>'top_bar_menu','depth'=>1,'fallback_cb' =>false,'container'=>'','container_class'=>'','menu_id'=>'','menu_class'=>'','link_before' => '<span>', 'link_after' => '</span>','items_wrap'=> '<ul id="%1$s" class="%2$s">%3$s</ul>'));
		   echo '</nav>';
		 break;
		 case "none":
		
		 break;
		 }
	 }
	 
/**
 * Convert Hex Code to RGB
 * @param  string $hex Color Hex Code
 * @return array       RGB values
 */
 
function onetone_hex2rgb( $hex ) {
	if ( strpos( $hex,'rgb' ) !== FALSE ) {

		$rgb_part = strstr( $hex, '(' );
		$rgb_part = trim($rgb_part, '(' );
		$rgb_part = rtrim($rgb_part, ')' );
		$rgb_part = explode( ',', $rgb_part );

		$rgb = array($rgb_part[0], $rgb_part[1], $rgb_part[2], $rgb_part[3]);

	} elseif( $hex == 'transparent' ) {
		$rgb = array( '255', '255', '255', '0' );
	} else {

		$hex = str_replace( '#', '', $hex );
		
		
		if( strlen( $hex ) == 3 ) {
			$r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
			$g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
			$b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
		} else {
			$r = hexdec( substr( $hex, 0, 2 ) );
			$g = hexdec( substr( $hex, 2, 2 ) );
			$b = hexdec( substr( $hex, 4, 2 ) );
		}
		$rgb = array( $r, $g, $b );
	}

	return $rgb;
}
	
/**
* Get related posts
*/ 
function onetone_get_related_posts($post_id, $number_posts = -1,$post_type = 'post',$taxonomies='category') {

	$categories = array();

	$terms = wp_get_object_terms( $post_id,  $taxonomies );
	  if ( ! empty( $terms ) ) {
		  if ( ! is_wp_error( $terms ) ) {
				  foreach( $terms as $term ) {
					  $categories[] = $term->term_id; 
				  }
		  }
	  }
   if( $post_type == 'post' )
    	$args = array('category__in' => $categories);
	else
		$args = array('tax_query' => array(
      	  array(
            'taxonomy' => $taxonomies,
            'field'    => 'term_id',
            'terms'    => $categories,
        	),
    ),);
	
	if($number_posts == 0) {
		$query = new WP_Query();
		return $query;
	}

	$args = wp_parse_args($args, array(
		'posts_per_page' => $number_posts,
		'post__not_in' => array($post_id),
		'ignore_sticky_posts' => 0,
        'meta_key' => '_thumbnail_id',
		'post_type' =>$post_type,
		'operator'  => 'IN'
	));

	$query = new WP_Query($args);
    wp_reset_postdata(); 
  	return $query;
}

/**
 * Display navigation to next/previous post when applicable.
 */
function onetone_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
    <nav class="post-pagination" role="navigation">
      <ul class="clearfix">
      <?php
          previous_post_link( '<li class="pull-left">%link</li>', '%title' );
          next_post_link(     '<li class="pull-right">%link</li>', '%title' );
      ?>
      </ul>
  </nav>  
                                    
	<!-- .navigation -->
	<?php
}

/**
 * Get post content css class
 */
function onetone_get_content_class( $sidebar = '' ){
	
	if( $sidebar == 'left' ) return 'left-aside';
	if( $sidebar == 'right' ) return 'right-aside';
	if( $sidebar == 'both' ) return 'both-aside';
	if( $sidebar == 'none' ) return 'no-aside';
	
	return 'no-aside';
}

/**
 * Remove woocommerce page title
 */
function onetone_woocommerce_show_page_title(){
	return false;
}
add_filter('woocommerce_show_page_title','onetone_woocommerce_show_page_title');



/*
*  Get post summary
*/
function onetone_get_summary(){
	 
	$excerpt_or_content = onetone_option('archive_content','excerpt');
	
	if( $excerpt_or_content == 'content' ){
		$output = get_the_content();
	}else{
		$output = get_the_excerpt();
	}
	return  $output;
}

/*
*  Change excerpt length
*/ 

function onetone_excerpt_length( $length ) {
	
	$excerpt_length = onetone_option('excerpt_length','55');
	$excerpt_length = absint($excerpt_length);
	return absint($excerpt_length);
	
}
add_filter( 'excerpt_length', 'onetone_excerpt_length', 999 );

// get excerpt

function onetone_get_excerpt( $excerpt_length = false,$excerpt_or_content=false ){
	 
	$output = get_the_excerpt();
	if( is_numeric($excerpt_length) && $excerpt_length !=0  )
		$output = onetone_get_content_length($output, $excerpt_length );
	return  $output;
}
	 
function onetone_get_content_length($content, $limit) {
	$excerpt = explode(' ', $content, $limit);
    if (count($excerpt)>=$limit) {
		array_pop($excerpt);
        $excerpt = implode(" ",$excerpt).'...';
      } else {
        $excerpt = implode(" ",$excerpt);
      } 
    $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
    return $excerpt;
    }

/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function onetone_posted_on($echo = true) {
	
	$return = '';
	$display_post_meta = onetone_option('display_post_meta');
		
	if( $display_post_meta == 'yes' || $display_post_meta == '1' ){
		
	  $display_meta_author     = onetone_option('display_meta_author');
	  $display_meta_date       = onetone_option('display_meta_date');
	  $display_meta_categories = onetone_option('display_meta_categories');
	  $display_meta_comments   = onetone_option('display_meta_comments');

		
	   $return .=  '<ul class="entry-meta">';
	  if( $display_meta_date == 'yes' || $display_meta_date == '1'  )
		$return .=  '<li class="entry-date"><i class="fa fa-calendar"></i>'. get_the_date(  ).'</li>';
	  if( $display_meta_author == 'yes' || $display_meta_author == '1' )
		$return .=  '<li class="entry-author"><i class="fa fa-user"></i>'.get_the_author_link().'</li>';
	  if( $display_meta_categories == 'yes' || $display_meta_categories == '1' )		
		$return .=  '<li class="entry-catagory"><i class="fa fa-file-o"></i>'.get_the_category_list(', ').'</li>';
	  if( $display_meta_comments == 'yes'  || $display_meta_comments == '1' )	
		$return .=  '<li class="entry-comments pull-right">'.onetone_get_comments_popup_link('', __( '<i class="fa fa-comment"></i> 1 ', 'onetone'), __( '<i class="fa fa-comment"></i> % ', 'onetone'), 'read-comments', '').'</li>';
        $return .=  '</ul>';
	}
	if($echo == true)
		echo $return;
	else
		return $return;

}

/**
 * Modifies WordPress's built-in comments_popup_link() function to return a string instead of echo comment results
 */
function onetone_get_comments_popup_link( $zero = false, $one = false, $more = false, $css_class = '', $none = false ) {
	
    global $wpcommentspopupfile, $wpcommentsjavascript;
 
    $id = get_the_ID();
 
    if ( false === $zero ) $zero = __( 'No Comments', 'onetone');
    if ( false === $one ) $one = __( '1 Comment', 'onetone');
    if ( false === $more ) $more = __( '% Comments', 'onetone');
    if ( false === $none ) $none = __( 'Comments Off', 'onetone');
 
    $number = get_comments_number( $id );
    $str = '';
 
    if ( 0 == $number && !comments_open() && !pings_open() ) {
        $str = '<span' . ((!empty($css_class)) ? ' class="' . esc_attr( $css_class ) . '"' : '') . '>' . $none . '</span>';
        return $str;
    }
 
    if ( post_password_required() ) {
     
        return '';
    }
	
    $str = '<a href="';
    if ( $wpcommentsjavascript ) {
        if ( empty( $wpcommentspopupfile ) )
            $home = home_url();
        else
            $home = get_option('siteurl');
        $str .= $home . '/' . $wpcommentspopupfile . '?comments_popup=' . $id;
        $str .= '" onclick="wpopen(this.href); return false"';
    } else { // if comments_popup_script() is not in the template, display simple comment link
        if ( 0 == $number )
            $str .= get_permalink() . '#respond';
        else
            $str .= get_comments_link();
        $str .= '"';
    }
 
    if ( !empty( $css_class ) ) {
        $str .= ' class="'.$css_class.'" ';
    }
    $title = the_title_attribute( array('echo' => 0 ) );
 
    $str .= apply_filters( 'comments_popup_link_attributes', '' );
 
    $str .= ' title="' . esc_attr( sprintf( __('Comment on %s', 'onetone'), $title ) ) . '">';
    $str .= onetone_get_comments_number_str( $zero, $one, $more );
    $str .= '</a>';
     
    return $str;
}

/**
 * Modifies WordPress's built-in comments_number() function to return string instead of echo
 */
function onetone_get_comments_number_str( $zero = false, $one = false, $more = false, $deprecated = '' ) {
	
    if ( !empty( $deprecated ) )
        _deprecated_argument( __FUNCTION__, '1.3' );
 
    $number = get_comments_number();
 
    if ( $number > 1 )
        $output = str_replace('%', number_format_i18n($number), ( false === $more ) ? __('% Comments', 'onetone') : $more);
    elseif ( $number == 0 )
        $output = ( false === $zero ) ? __('No Comments', 'onetone') : $zero;
    else // must be one
        $output = ( false === $one ) ? __('1 Comment', 'onetone') : $one;
 
    return apply_filters('comments_number', $output, $number);
}

function onetone_array_sort($array,$keys,$type='asc'){
	
	if(!isset($array) || !is_array($array) || empty($array)){
		return '';
	}
	if(!isset($keys) || trim($keys)==''){
		return '';
	}
	if(!isset($type) || $type=='' || !in_array(strtolower($type),array('asc','desc'))){
		return '';
	}
	$keysvalue=array();
	  
	foreach($array as $key=>$val){
		$val[$keys] = str_replace('-','',$val[$keys]);
	  	$val[$keys] = str_replace(' ','',$val[$keys]);
	  	$val[$keys] = str_replace(':','',$val[$keys]);
	 	$keysvalue[] =$val[$keys];
	}
	asort($keysvalue); 
	reset($keysvalue); 
	  
	foreach($keysvalue as $key=>$vals) {
		$keysort[] = $key;
	}
	$keysvalue = array();
	$count=count($keysort);
	if(strtolower($type) != 'asc'){
		for($i=$count-1; $i>=0; $i--) {
	 		$keysvalue[] = $array[$keysort[$i]];
		}
	}else{
		for($i=0; $i<$count; $i++){
			if(isset($array[$keysort[$i]]))
				$keysvalue[] = $array[$keysort[$i]];
	 	 }
	  }
	return $keysvalue;
}

/**
 * Change the Shop archive page title.
 * @param  string $title
 * @return string
 */
 
function onetone_custom_shop_archive_title( $title ) {
	
	if ( function_exists('is_shop') && function_exists('woocommerce_page_title') &&  is_shop() ) {
		return str_replace( __( 'Products', 'onetone' ), woocommerce_page_title(false), $title );
    }
    return $title;
}
add_filter( 'wp_title', 'onetone_custom_shop_archive_title' );

/**
* Check plugin status
*/

function onetone_is_plugin_active( $plugin ) {
    return in_array( $plugin, (array) get_option( 'active_plugins', array() ) );
}
 

/**
 * Load woocommerce cart on header 
 */
function onetone_woo_cart(){
	
	$enable_woo_cart = onetone_option('header_enable_cart');
	if( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ) && $enable_woo_cart == '1'):
		global $woocommerce;
		if ( ! is_cart() && ! is_checkout() ):
		?>
			<li class="">
				<a class="" href="<?php echo wc_get_cart_url();?>" title="View your shopping cart">
				<i class="fa fa-shopping-cart"></i> (<span class="amount"><?php echo $woocommerce->cart->get_cart_total();?></span>)
				</a>
				<ul class="site-header-cart sub-menu">
					<li><?php the_widget( 'WC_Widget_Cart' );?></li>
				</ul>  
			</li> 
         <?php endif; 
     endif; 	
 }


/**
* handle editor view
*/

function onetone_handle_editor_view_js() {
	
	$current_screen = get_current_screen();
	if ( ! isset( $current_screen->id ) || $current_screen->base !== 'appearance_page_onetone-options' ) {
		return;
	}

	add_action( 'admin_print_footer_scripts',  'onetone_editor_view_js_templates' );

	wp_enqueue_style( 'grunion-editor-ui', get_template_directory_uri() .'/jetpack/css/editor-ui.css' );
	wp_style_add_data( 'grunion-editor-ui', 'rtl', 'replace' );
	wp_enqueue_script( 'grunion-editor-view', get_template_directory_uri(). '/jetpack/js/editor-view.js', array( 'wp-util', 'jquery', 'quicktags' ), false, true );
	
	wp_localize_script( 'grunion-editor-view', 'grunionEditorView', array(
			'inline_editing_style' => get_template_directory_uri(). '/jetpack/css/editor-inline-editing-style.css', 
			'inline_editing_style_rtl' => get_template_directory_uri(). '/jetpack/css/editor-inline-editing-style-rtl.css', 
			'dashicons_css_url' => includes_url( 'css/dashicons.css' ),
			'default_form'  => '[contact-field label="' . esc_html__( 'Name', 'onetone' ) . '" type="name"  required="true" /]' .
								'[contact-field label="' . esc_html__( 'Email', 'onetone' )   . '" type="email" required="true" /]' .
								'[contact-field label="' . esc_html__( 'Website', 'onetone' ) . '" type="url" /]' .
								'[contact-field label="' . esc_html__( 'Message', 'onetone' ) . '" type="textarea" /]',
			'labels'      => array(
				'submit_button_text'  => __( 'Submit', 'onetone' ),
				/** This filter is documented in modules/contact-form/grunion-contact-form.php */
				'required_field_text' => apply_filters( 'jetpack_required_field_text', __( '(required)', 'onetone' ) ),
				'edit_close_ays'      => __( 'Are you sure you\'d like to stop editing this form without saving your changes?', 'onetone' ),
				'quicktags_label'     => __( 'contact form', 'onetone' ),
				'tinymce_label'       => __( 'Add contact form', 'onetone' ),
			)
		) );

	add_editor_style( get_template_directory_uri(). '/jetpack/css/editor-style.css' );
}

/**
* Sanitize checkbox
*/
function onetone_customizer_sanitize_checkbox( $input ){
	
	if ( $input === true || $input === '1' ) {
		return '1';
	}
	
	return '';
}

/**
* JS Templates.
*/
function onetone_editor_view_js_templates() {
?>
	<script type="text/html" id="tmpl-grunion-contact-form">
        <form class="card" action='#' method='post' class='contact-form commentsblock' onsubmit="return false;">
            {{{ data.body }}}
            <p class='contact-submit'>
                <input type='submit' value='{{ data.submit_button_text }}' class='pushbutton-wide'/>
            </p>
        </form>
    </script>
    
    <script type="text/html" id="tmpl-grunion-field-email">
        <div>
            <label for='{{ data.id }}' class='grunion-field-label email'>{{ data.label }}<# if ( data.required ) print( " <span>" + data.required + "</span>" ) #></label>
            <input type='email' name='{{ data.id }}' id='{{ data.id }}' value='{{ data.value }}' class='{{ data.class }}' placeholder='{{ data.placeholder }}' />
        </div>
    </script>
    
    <script type="text/html" id="tmpl-grunion-field-telephone">
        <div>
            <label for='{{ data.id }}' class='grunion-field-label telephone'>{{ data.label }}<# if ( data.required ) print( " <span>" + data.required + "</span>" ) #></label>
            <input type='tel' name='{{ data.id }}' id='{{ data.id }}' value='{{ data.value }}' class='{{ data.class }}' placeholder='{{ data.placeholder }}' />
        </div>
    </script>
    
    <script type="text/html" id="tmpl-grunion-field-textarea">
        <div>
            <label for='contact-form-comment-{{ data.id }}' class='grunion-field-label textarea'>{{ data.label }}<# if ( data.required ) print( " <span>" + data.required + "</span>" ) #></label>
            <textarea name='{{ data.id }}' id='contact-form-comment-{{ data.id }}' rows='20' class='{{ data.class }}' placeholder='{{ data.placeholder }}'>{{ data.value }}</textarea>
        </div>
    </script>
    
    <script type="text/html" id="tmpl-grunion-field-radio">
        <div>
            <label class='grunion-field-label'>{{ data.label }}<# if ( data.required ) print( " <span>" + data.required + "</span>" ) #></label>
            <# _.each( data.options, function( option ) { #>
                <label class='grunion-radio-label radio'>
                    <input type='radio' name='{{ data.id }}' value='{{ option }}' class="{{ data.class }}" <# if ( option === data.value ) print( "checked='checked'" ) #> />
                    <span>{{ option }}</span>
                </label>
            <# }); #>
            <div class='clear-form'></div>
        </div>
    </script>
    
    <script type="text/html" id="tmpl-grunion-field-checkbox">
        <div>
            <label class='grunion-field-label checkbox'>
                <input type='checkbox' name='{{ data.id }}' value='<?php esc_attr__( 'Yes', 'onetone' ); ?>' class="{{ data.class }}" <# if ( data.value ) print( 'checked="checked"' ) #> />
                    <span>{{ data.label }}</span><# if ( data.required ) print( " <span>" + data.required + "</span>" ) #>
            </label>
            <div class='clear-form'></div>
        </div>
    </script>
    
    <script type="text/html" id="tmpl-grunion-field-checkbox-multiple">
        <div>
            <label class='grunion-field-label'>{{ data.label }}<# if ( data.required ) print( " <span>" + data.required + "</span>" ) #></label>
            <# _.each( data.options, function( option ) { #>
                <label class='grunion-checkbox-multiple-label checkbox-multiple'>
                    <input type='checkbox' name='{{ data.id }}[]' value='{{ option }}' class="{{ data.class }}" <# if ( option === data.value || _.contains( data.value, option ) ) print( "checked='checked'" ) #> />
                    <span>{{ option }}</span>
                </label>
            <# }); #>
            <div class='clear-form'></div>
        </div>
    </script>
    
    <script type="text/html" id="tmpl-grunion-field-select">
        <div>
            <label for='{{ data.id }}' class='grunion-field-label select'>{{ data.label }}<# if ( data.required ) print( " <span>" + data.required + "</span>" ) #></label>
            <select name='{{ data.id }}' id='{{ data.id }}' class="{{ data.class }}">
                <# _.each( data.options, function( option ) { #>
                    <option <# if ( option === data.value ) print( "selected='selected'" ) #>>{{ option }}</option>
                <# }); #>
            </select>
        </div>
    </script>
    
    <script type="text/html" id="tmpl-grunion-field-date">
        <div>
            <label for='{{ data.id }}' class='grunion-field-label {{ data.type }}'>{{ data.label }}<# if ( data.required ) print( " <span>" + data.required + "</span>" ) #></label>
            <input type='date' name='{{ data.id }}' id='{{ data.id }}' value='{{ data.value }}' class="{{ data.class }}" />
        </div>
    </script>
    
    <script type="text/html" id="tmpl-grunion-field-text">
        <div>
            <label for='{{ data.id }}' class='grunion-field-label {{ data.type }}'>{{ data.label }}<# if ( data.required ) print( " <span>" + data.required + "</span>" ) #></label>
            <input type='text' name='{{ data.id }}' id='{{ data.id }}' value='{{ data.value }}' class='{{ data.class }}' placeholder='{{ data.placeholder }}' />
        </div>
    </script>
    
    
    <script type="text/html" id="tmpl-grunion-field-edit">
        <div class="card is-compact grunion-field-edit grunion-field-{{ data.type }}" aria-label="<?php esc_attr_e( 'Form Field', 'onetone' ); ?>">
            <label class="grunion-name">
                <span><?php esc_html_e( 'Field Label', 'onetone' ); ?></span>
                <input type="text" name="label" placeholder="<?php esc_attr_e( 'Label', 'onetone' ); ?>" value="{{ data.label }}"/>
            </label>
    
            <?php
            $grunion_field_types = array(
                'text'              => __( 'Text', 'onetone' ),
                'name'              => __( 'Name', 'onetone' ),
                'email'             => __( 'Email', 'onetone' ),
                'url'               => __( 'Website', 'onetone' ),
                'textarea'          => __( 'Textarea', 'onetone' ),
                'checkbox'          => __( 'Checkbox', 'onetone' ),
                'checkbox-multiple' => __( 'Checkbox with Multiple Items', 'onetone' ),
                'select'            => __( 'Drop down', 'onetone' ),
                'radio'             => __( 'Radio', 'onetone' ),
            );
            ?>
            <div class="grunion-type-options">
                <label class="grunion-type">
                    <?php esc_html_e( 'Field Type', 'onetone' ); ?>
                    <select name="type">
                        <?php foreach ( $grunion_field_types as $type => $label ) : ?>
                        <option <# if ( '<?php echo esc_js( $type ); ?>' === data.type ) print( "selected='selected'" ) #> value="<?php echo esc_attr( $type ); ?>">
                            <?php echo esc_html( $label ); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </label>
    
                <label class="grunion-required">
                    <input type="checkbox" name="required" value="1" <# if ( data.required ) print( 'checked="checked"' ) #> />
                    <span><?php esc_html_e( 'Required?', 'onetone' ); ?></span>
                </label>
            </div>
    
            <label class="grunion-options">
                <?php esc_html_e( 'Options', 'onetone' ); ?>
                <ol>
                    <# if ( data.options ) { #>
                        <# _.each( data.options, function( option ) { #>
                            <li><input type="text" name="option" value="{{ option }}" /> <a class="delete-option" href="javascript:;"><span class="screen-reader-text"><?php esc_html_e( 'Delete Option', 'onetone' ); ?></span></a></li>
                        <# }); #>
                    <# } else { #>
                        <li><input type="text" name="option" /> <a class="delete-option" href="javascript:;"><span class="screen-reader-text"><?php esc_html_e( 'Delete Option', 'onetone' ); ?></span></a></li>
                        <li><input type="text" name="option" /> <a class="delete-option" href="javascript:;"><span class="screen-reader-text"><?php esc_html_e( 'Delete Option', 'onetone' ); ?></span></a></li>
                        <li><input type="text" name="option" /> <a class="delete-option" href="javascript:;"><span class="screen-reader-text"><?php esc_html_e( 'Delete Option', 'onetone' ); ?></span></a></li>
                    <# } #>
                    <li><a class="add-option" href="javascript:;"><?php esc_html_e( 'Add new option...', 'onetone' ); ?></a></li>
                </ol>
            </label>
    
            <a href="javascript:;" class="delete-field"><span class="screen-reader-text"><?php esc_html_e( 'Delete Field', 'onetone' ); ?></span></a>
        </div>
    </script>
    
    <script type="text/html" id="tmpl-grunion-field-edit-option">
        <li><input type="text" name="option" /> <a class="delete-option" href="javascript:;"><span class="screen-reader-text"><?php esc_html_e( 'Delete Option', 'onetone' ); ?></span></a></li>
    </script>
    
    <script type="text/html" id="tmpl-grunion-editor-inline">
                <h1 id="form-settings-header" class="grunion-section-header"><?php esc_html_e( 'Contact form information', 'onetone' ); ?></h1>
                <section class="card grunion-form-settings" aria-labelledby="form-settings-header">
                    <label><?php esc_html_e( 'What would you like the subject of the email to be?', 'onetone' ); ?>
                        <input type="text" name="subject" value="{{ data.subject }}" />
                    </label>
                    <label><?php esc_html_e( 'Which email address should we send the submissions to?', 'onetone' ); ?>
                        <input type="text" name="to" value="{{ data.to }}" />
                    </label>
                </section>
                <h1 id="form-fields-header" class="grunion-section-header"><?php esc_html_e( 'Contact form fields', 'onetone' ); ?></h1>
                <section class="grunion-fields" aria-labelledby="form-fields-header">
                    {{{ data.fields }}}
                </section>
                <section class="grunion-controls">
                    <?php submit_button( esc_html__( 'Add Field', 'onetone' ), 'secondary', 'add-field', false ); ?>
    
                    <div class="grunion-update-controls">
                        <?php submit_button( esc_html__( 'Cancel', 'onetone' ), 'delete', 'cancel', false ); ?>
                        <?php submit_button( esc_html__( 'Update Form', 'onetone' ), 'primary', 'submit', false ); ?>
                    </div>
                </section>
    </script>
    
    </div>
	<?php
	}
	
if(class_exists('Jetpack'))
	add_action( 'admin_notices',  'onetone_handle_editor_view_js' );

/**
* Standard fonts
*/
function onetone_standard_fonts(){
	$standard_fonts = array(
			
			'open-sans' => array(
				'label' => 'Open Sans',
				'stack' => 'Open Sans, sans-serif',
			),
			'arial' => array(
				'label' => 'Arial',
				'stack' => 'Arial, sans-serif',
			),
			'cambria' => array(
				'label'  => 'Cambria',
				'stack'  => 'Cambria, Georgia, serif',
			),
			'calibri' => array(
				'label' => 'Calibri',
				'stack' => 'Calibri,sans-serif',
			),
			'copse' => array(
				'label' => 'Copse',
				'stack' => 'Copse, sans-serif',
			),
			'garamond' => array(
				'label' => 'Garamond',
				'stack' => "Garamond, 'Hoefler Text', Times New Roman, Times, serif",
			),
			'georgia' => array(
				'label' => 'Georgia',
				'stack' => 'Georgia, serif',
			),
			'helvetica-neue' => array(
				'label' => 'Helvetica Neue',
				'stack' => "'Helvetica Neue', Helvetica, sans-serif",
			),
			'tahoma' => array(
				'label' => 'Tahoma',
				'stack' => 'Tahoma, Geneva, sans-serif',
			),
			'lustria' => array(
				'label' => 'Lustria',
				'stack' => 'Lustria,serif',
			),
		);
	return $standard_fonts;	
	}
		
add_filter( 'kirki/fonts/standard_fonts', 'onetone_standard_fonts' );

/**
* Get section default name
*/
function onetone_get_section_tpl_name($id){
	$onetone_home_sections = onetone_section_templates();
	foreach( $onetone_home_sections as $section ){
		if ($section['id'] == $id )
			return $section['name'];
		}
	return '';
}

/**
* Get section name
*/
function onetone_get_section_name($id){
	$onetone_home_sections = onetone_option_saved('section_order');
	if($onetone_home_sections){
	  foreach( $onetone_home_sections as $section ){
		  if ($section['id'] == $id )
			  return $section['name'];
		  }
	}
	return '';
}

/**
* Default section_templates
*/
function onetone_section_templates(){
	
	$sections = array(
		array('id'=>'0','type'=>'0','name'=> __('Section 1 - Banner', 'onetone' )),
		array('id'=>'1','type'=>'1','name'=> __('Section 2 - Slogan', 'onetone' )),
		array('id'=>'2','type'=>'2','name'=> __('Section 3 - Service', 'onetone' )),
		array('id'=>'3','type'=>'3','name'=> __('Section 4 - Gallery', 'onetone' )),
		array('id'=>'4','type'=>'4','name'=> __('Section 5 - Team', 'onetone' )),
		array('id'=>'5','type'=>'5','name'=> __('Section 6 - About', 'onetone' )),
		array('id'=>'6','type'=>'6','name'=> __('Section 7 - Counter', 'onetone' )),
		array('id'=>'7','type'=>'7','name'=> __('Section 8 - Testimonial', 'onetone' )),
		array('id'=>'8','type'=>'8','name'=> __('Section 9 - Contact', 'onetone' )),
		array('id'=>'9','type'=>'9','name'=> __('Section 10 - Portfolio', 'onetone' )),
		array('id'=>'10','type'=>'10','name'=> __('Section 11 - Pricing', 'onetone' )),
		array('id'=>'11','type'=>'11','name'=> __('Section 12 - Blog', 'onetone' )),
		array('id'=>'12','type'=>'12','name'=> sprintf(__('Section %s - Custom', 'onetone'),13)),
		array('id'=>'13','type'=>'13','name'=> sprintf(__('Section %s - Custom', 'onetone'),14)),
		array('id'=>'14','type'=>'14','name'=> sprintf(__('Section %s - Custom', 'onetone'),15)),
	);
	
	$return = apply_filters('onetone_sections',$sections);
	return $return ;
}

/**
* Get portfolio terms
*/
function onetone_get_portfolio_terms(){
	global $onetone_portfolio_terms;
	
	if(class_exists('Magee_Core')  && method_exists('Magee_Core','magee_shortcodes_categories')){
		$magee = new Magee_Core;
		$onetone_portfolio_terms = $magee->magee_shortcodes_categories('portfolio-category');
		}
	}
add_action('init', 'onetone_get_portfolio_terms' );

/**
* Get section options by template
*/
function onetone_get_section_options( $id, $type='' ){
	
	global $onetone_option_args, $onetone_portfolio_terms;
	$hide_section = '';
	$content_model = '0';
	
	$imagepath = get_template_directory_uri().'/images/';
	
	// Pull all the categories into an array
	$options_categories = array();
	$options_categories_obj = get_categories();
	$options_categories[''] = __( 'All', 'onetone' );
	
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}
	
	$portfolio_terms = array();
	if($onetone_portfolio_terms){
	  foreach ($onetone_portfolio_terms as $k=>$v) {
		  $portfolio_terms[$k] = $v;
	  }
	}
	extract($onetone_option_args);
	
	$section_title[intval($id)]      = isset($section_title[intval($type)]) ?$section_title[intval($type)]:'';
	$section_subtitle[intval($id)]   = isset($section_subtitle[intval($type)]) ?$section_subtitle[intval($type)]:'';
	$section_color[intval($id)]      = isset($section_color[intval($type)]) ?$section_color[intval($type)]:'';
	$section_menu[intval($id)]       = isset($section_menu[intval($type)]) ?$section_menu[intval($type)]:'';
	$section_title[intval($id)]      = isset($section_title[intval($type)]) ?$section_title[intval($type)]:'';
	$background_size[intval($id)]    = isset($background_size[intval($type)]) ?$background_size[intval($type)]:'';
	$parallax_scrolling[intval($id)] = isset($parallax_scrolling[intval($type)]) ?$parallax_scrolling[intval($type)]:'';
	$full_width[intval($id)]         = isset($full_width[intval($type)]) ?$full_width[intval($type)]:'';
	$section_css_class[intval($id)]  = isset($section_css_class[intval($type)]) ?$section_css_class[intval($type)]:'';
	$section_content[intval($id)]    = isset($section_content[intval($type)]) ?$section_content[intval($type)]:'';
	$section_slug[intval($id)]       = isset($section_slug[intval($type)]) ?$section_slug[intval($type)]:'';
	$text_align[intval($id)]         = isset($text_align[intval($type)]) ?$text_align[intval($type)]:'';
	$section_padding[intval($id)]    = isset($section_padding[intval($type)]) ?$section_padding[intval($type)]:'';
	$section_color                   = isset($section_color[intval($type)]) ?$section_color[intval($type)]:'';
	
	if(onetone_option_saved('section_title_typography_'.$id)){
		
		$typography = onetone_option_saved('section_title_typography_'.$id);
		if(isset($typography['color']) && $typography['color'] !='')
			$section_title_typography_defaults[intval($id)]['color'] = $typography['color'];
		if($section_color != '' )
			$section_title_typography_defaults[intval($id)]['color'] = $section_color ;
		if(isset($typography['face']) && $typography['face'] !='')
			$section_title_typography_defaults[intval($id)]['font-family'] = $typography['face'];
		if(isset($typography['size']) && $typography['size'] !='')
			$section_title_typography_defaults[intval($id)]['font-size'] = $typography['size'];
	}
	
	if(onetone_option_saved('section_subtitle_typography_'.$id)){
		
		$typography = onetone_option_saved('section_subtitle_typography_'.$id);
		if(isset($typography['color']) && $typography['color'] !='')
			$section_subtitle_typography_defaults[intval($id)]['color'] = $typography['color'];
		if($section_color != '' )
			$section_subtitle_typography_defaults[intval($id)]['color'] = $section_color ;
		if(isset($typography['face']) && $typography['face'] !='')
			$section_subtitle_typography_defaults[intval($id)]['font-family'] = $typography['face'];
		if(isset($typography['size']) && $typography['size'] !='')
			$section_subtitle_typography_defaults[intval($id)]['font-size'] = $typography['size'];
	}
	
	if(onetone_option_saved('section_content_typography_'.$id)){
		
		$typography = onetone_option_saved('section_content_typography_'.$id);
		if(isset($typography['color']) && $typography['color'] !='' )
			$section_content_typography_defaults[intval($id)]['color'] = $typography['color'];
		if($section_color != '' )
			$section_content_typography_defaults[intval($id)]['color'] = $section_color ;
		if(isset($typography['face']) && $typography['face'] !='' )	
			$section_content_typography_defaults[intval($id)]['font-family'] = $typography['face'];
		if(isset($typography['size']) && $typography['size'] !='' )	
			$section_content_typography_defaults[intval($id)]['font-size'] = $typography['size'];
	}
	
	if(!(isset($section_title_typography_defaults[$id]))) $section_title_typography_defaults[$id] = array();
	if(!(isset($section_subtitle_typography_defaults[$id]))) $section_subtitle_typography_defaults[$id] = array();
	if(!(isset($section_content_typography_defaults[$id]))) $section_content_typography_defaults[$id] = array();
	
	if($section_color == '' )
		$section_color = '#666666';
		
	$section_title_typography_defaults[$id] = array_merge(
		array(
		'font-family'    => 'Open Sans, sans-serif',
		'variant'        => '700',
		'font-size'      => '36px',
		'line-height'    => '1.1',
		'letter-spacing' => '0',
		'subsets'        => array( 'latin-ext' ),
		'color'          => $section_color,
		'text-transform' => 'none',
		'text-align'     => 'center'
		),
		$section_title_typography_defaults[$id]
	);
	
	$section_subtitle_typography_defaults[$id] = array_merge(
		array(
		'font-family'    => 'Open Sans, sans-serif',
		'variant'        => 'regular',
		'font-size'      => '14px',
		'line-height'    => '1.8',
		'letter-spacing' => '0',
		'subsets'        => array( 'latin-ext' ),
		'color'          => $section_color,
		'text-transform' => 'none',
		'text-align'     => 'center'
		),
		$section_subtitle_typography_defaults[$id]
	);

	$section_content_typography_defaults[$id] = array_merge(
		array(
		'font-family'    => 'Open Sans, sans-serif',
		'variant'        => 'regular',
		'font-size'      => '14px',
		'line-height'    => '1.8',
		'letter-spacing' => '0',
		'subsets'        => array( 'latin-ext' ),
		'color'          => $section_color,
		'text-transform' => 'none',
		'text-align'     => 'left'
		),
		$section_content_typography_defaults[$id]
	);
	
	$section_background[intval($id)] = (isset($section_background[intval($type)]) && !empty($section_background[intval($type)] ) ) ?$section_background[intval($type)]:array('background-color' => '#ffffff','background-image' => '','background-repeat' => 'repeat','background-position' => 'top-left','background-attachment'=>'scroll' );
	
	$o_section_background = onetone_option_saved('section_background_'.$id);
	$n_section_background = onetone_option_saved('section_background1_'.$id);
	
	if ( $o_section_background  !='' && !$n_section_background ){
		
		$o_section_background = array_merge(
		  array('color'=>'#ffffff','image'=>'','repeat'=>'repeat','position'=>'top-left','attachment'=>'scroll'),
		  $o_section_background
		  );
		
		$section_background[intval($id)] = array('background-color' => $o_section_background['color'],'background-image' => $o_section_background['image'],'background-repeat' => $o_section_background['repeat'],'background-position' => $o_section_background['position'],'background-attachment'=>$o_section_background['attachment'] );
		
	}
	
	$section_name = onetone_get_section_name($id);
	
	if(!$section_name){
		
		$section_name = onetone_option_saved( 'section_title_'.$id );
		$menu_title   = onetone_option_saved( 'menu_title_'.$id );
		$section_name = $section_name?$section_name:$menu_title;
		$section_name = $section_name? ' ('.$section_name.')':'';
		
		$default_section_name = onetone_get_section_tpl_name(intval($id));
		$section_name = $default_section_name .' '. $section_name;
		
	}
	
	if( $id>=9 && $id<=14){
		$hide_section  = '1';
	}
	
	if( $id>=12 && $id<=14){
		$content_model  = 1;
	}

	$options[] = array(
		'slug'		=> 'sections_'.$id,
		'label'		=> $section_name,
		'panel' 	=> 'onetone_homepage_sections',
		'priority'	=> 2,
		'type' 		=> 'section'
		);
	
	$options[] = array(
		'label' => __('Hide Section', 'onetone'),
		'default' => $hide_section,
		'slug' => 'section_hide_'.$id,
		'type' => 'checkbox',
		'description'=> __('Hide this section on front page.', 'onetone'),
		'section' => 'sections_'.$id,
		);
	
	$options[] = array(
		'label' => __('Section Title', 'onetone'),
		'slug' => 'section_title_'.$id.'',
		'type' => 'textarea',
		'default' => $section_title[intval($id)],
		'description' => __('Insert title for this section. It would appear at the top of the section.', 'onetone'),
		'transport' => 'postMessage',
		'section' => 'sections_'.$id,
		'js_vars'   => array(
			array(
				'element'  => '.section_title_'.$id.'',
				'function' => 'html',
				)
			),	
		);
	
	$options[] = array(
		'label' => __('Menu Title', 'onetone'),
		'slug' => 'menu_title_'.$id.'',
		'type' => 'text',
		'default'=> $section_menu[intval($id)],
		'description'=> __('Insert menu title for this section. This title would appear in the header menu. If leave it as blank, the link of this section would not be displayed in header menu.', 'onetone'),
		'transport' => 'postMessage',
		'section' => 'sections_'.$id,
		'js_vars'   => array(
			array(
				'element'  => '.menu_title_'.$id.' span',
				'function' => 'html',
				)
			),
		);
	
	$options[] = array(
		'label' => __('Menu Slug', 'onetone'),
		'slug' => 'menu_slug_'.$id.'',
		'type' => 'text',
		'default'=> $section_slug[intval($id)],
		'description'=> __('Attention! The "slug" is the URL-friendly version of menu title. It is usually all lowercase and contains only letters, numbers, and hyphens. If the menu title contains non-eng characters, you need to fill this form.', 'onetone'),
		'section' => 'sections_'.$id,
		);

	$options[] = array(
		'slug'          => 'side_menu_color_'.$id.'',
		'label'       => __( 'Side Navigation Color', 'onetone' ),
		'description'        => '',
		'type'        => 'color',
		'section' => 'sections_'.$id,
		);
		
	$options[] = array(
		'label' => __('Section Background', 'onetone'),
		'slug' => 'section_background1_'.$id.'',
		'type' => 'background',
		'description' => '',
		'default'=> $section_background[intval($id)],
		'section' => 'sections_'.$id,
		'output' => array(
							array(
								'element' => 'section.home-section-'.$id,
							),
						),
		'transport' => 'postMessage',
		'js_vars'   => array(
			array(
				'element'  => 'section.home-section-'.$id,
				'function' => 'css',
				'property' => 'background',
				)
			),
			
		);
	
	$options[] = array(
		'label' => __('Parallax Scrolling Background Image', 'onetone'),
		'default' => '0',
		'slug' => 'parallax_scrolling_'.$id.'',
		'type' => 'checkbox',
		'description' => __('Choose to apply parallax scrolling effect for background image.', 'onetone'),
		'section' => 'sections_'.$id,
		);

	$options[] = array(
		'label' => __('Full Width', 'onetone'),
		'default' => '',
		'slug' => 'full_width_'.$id.'',
		'type' => 'checkbox',
		'description' => __('Choose to set width of section content as 100%', 'onetone'),
		'section' => 'sections_'.$id,
						  
		);
	
	$options[] = array(
		'label' => __('Section Css Class', 'onetone'),
		'slug' => 'section_css_class_'.$id.'',
		'type' => 'text',
		'transport' => 'postMessage',
		'default'=>$section_css_class[intval($id)],
		'description' => __('Set an aditional css class of this section.', 'onetone'),
		'section' => 'sections_'.$id,
		);
		
	$options[] = array(
		'label' => __('Section Padding', 'onetone'),
		'slug' => 'section_padding_'.$id.'',
		'type' => 'text',
		'default'=>$section_padding[intval($id)],
		'description' => __('Set padding for this section. In pixels (px), eg: 10px 20px 30px 0. These four numbers represent padding top/right/bottom/left.', 'onetone'),
		'transport' => 'postMessage',
		'section' => 'sections_'.$id,
		'js_vars'   => array(
			array(
				'element'  => 'section.home-section-'.$id.'',
				'function' => 'css',
				'property' => 'padding',
				)
			),
		);
	
	$options[] = array(
		'label' => __('Section Title Typography', 'onetone'),
		'slug'   => "section_title_typography1_".$id,
		'default'  => $section_title_typography_defaults[$id],
		'type' => 'typography',
		'section' => 'sections_'.$id,
		'output' => array(
							array(
								'element' => 'section.home-section-'.$id.' .section-title',
							),
						),
		);
	
	$options[] = array(
		'label' => __('Section Subtitle Typography', 'onetone'),
		'slug'   => "section_subtitle_typography1_".$id,
		'default'  => $section_subtitle_typography_defaults[$id],
		'section' => 'sections_'.$id,
		'type' => 'typography',
		'output' => array(
							array(
								'element' => 'section.home-section-'.$id.' .section-subtitle',
							),
						),
		);
	
	if($type == 3)
		$section_content_typography_defaults[intval($id)]['color'] = '#ffffff';
		
	$options[] = array(
		'label' => __('Section Content Typography', 'onetone'),
		'slug'   => "section_content_typography1_".$id,
		'default'  => $section_content_typography_defaults[$id],
		'type' => 'typography',
		'section' => 'sections_'.$id,
		'output' => array(
							array(
								'element' => 'section.home-section-'.$id.' .home-section-content,section.home-section-'.$id.' p',
							),
						),
		
		);
		
	$options[] = array(
		'label' =>  __('Section Content Model', 'onetone'),
		'slug' =>'section_content_model_'.$id,
		'default' => $content_model,
		'transport' => 'refresh',
		'type' => 'radio-buttonset',
		'choices'=>array('0'=> __('Default', 'onetone'),'1'=>__('Custom', 'onetone')),
		'section' => 'sections_'.$id,
		);
		
	// Fixed content
	$options[] = array(
		'label' => __('Section Subtitle', 'onetone'),
		'slug' => 'section_subtitle_'.$id.'',
		'type' => 'textarea',
		'sanitize_callback' => 'wp_kses_post',
		'default'=> $section_subtitle[intval($id)],
		'description'=> __('Insert sub-title for this section. It would appear at the bottom of the section title.', 'onetone'),
		'section' => 'sections_'.$id,
		'active_callback' => array(
								array(
									'setting'  => $option_name.'[section_content_model_'.$id.']',
									'operator' => '===',
									'value'    => '0',
								),),
		'transport' => 'postMessage',
		'js_vars'   => array(
			array(
				'element'  => '.section_subtitle_'.$id.'',
				'function' => 'html',
				)
			),	
		);
		
	switch( intval($type) ){
			case "0": // section banner
			
			$options[] = array(
						  'label' => __('Icon', 'onetone'),
						  'slug'   => "section_icon_".$id,
						  'default'  => '',
						  'description' => __( 'The image will display above the section title.', 'onetone' ),
						  'type' => 'upload',
						  'section' => 'sections_'.$id,
						  'active_callback' => array(
								array(
									'setting'  => $option_name.'[section_content_model_'.$id.']',
									'operator' => '===',
									'value'    => '0',
								),)
						  );
						
		     $options[] = array(
						  'label' => __('Button Text', 'onetone'),
						  'slug'   => "section_btn_text_".$id,
						  'default'  => 'Click Me',
						  'type' => 'text',
						  'description' => __('Insert text for the button', 'onetone'),
						  'section' => 'sections_'.$id,
						  'active_callback' => array(
								array(
									'setting'  => $option_name.'[section_content_model_'.$id.']',
									'operator' => '===',
									'value'    => '0',
								),),
							'transport' => 'postMessage',
							'js_vars'   => array(
								array(
									'element'  => '.section_btn_text_'.$id,
									'function' => 'html',
									)
								),
						  );
			  $options[] = array(
						  'label' => __('Button Link', 'onetone'),
						  'slug'   => "section_btn_link_".$id,
						  'default'  => '#',
						  'description' => __('Insert link for the button, begin with http:// or https://', 'onetone'),
						  'type' => 'text',
						  'transport' => 'postMessage',
						  'section' => 'sections_'.$id,
						  'active_callback' => array(
								array(
									'setting'  => $option_name.'[section_content_model_'.$id.']',
									'operator' => '===',
									'value'    => '0',
								),)
						  );
			  $options[] = array(
						  'label' => __('Button Target', 'onetone'),
						  'slug'   => "section_btn_target_".$id,
						  'default'  => '_self',
						  'description' => __('Self: open in the same window; blank: open in a new window', 'onetone'),
						  'type' => 'select',
						  'transport' => 'postMessage',
						  'choices'     => $target,
						  'section' => 'sections_'.$id,
						  'active_callback' => array(
								array(
									'setting'  => $option_name.'[section_content_model_'.$id.']',
									'operator' => '===',
									'value'    => '0',
								),)
						  );
			  
			 
			  
			  $banner_icons = array();
			  for( $s=0;$s<6;$s++ ):
			  	$icon = onetone_option_saved("section_social_icon_".$id."_".$s);
				$link = onetone_option_saved("section_icon_link_".$id."_".$s);
				if( $icon !='' || $link!='' ){
			  		$banner_icons[$s]['icon'] = esc_attr($icon);
					$banner_icons[$s]['icon_link'] =  esc_url($link);
				}
			  endfor;
			  
			  if(empty($banner_icons))
			  	 $banner_icons = array(
					array('icon'=>'fa-facebook','icon_link'=>'#'),
					array('icon'=>'fa-skype','icon_link'=>'#'),
					array('icon'=>'fa-twitter','icon_link'=>'#'),
					array('icon'=>'fa-linkedin','icon_link'=>'#'),
					array('icon'=>'fa-google-plus','icon_link'=>'#'),
					array('icon'=>'fa-rss','icon_link'=>'#'),
			  );
			  
			  $options[] =  array(
			   'slug'        => 'section_banner_icons_'.$id,
			   'label'       => __( 'Social Icons', 'onetone' ),
			   'description' => '',
			   'type'        => 'repeater',
			   'section' => 'sections_'.$id,
			   'row_label' => array(
					'type' => 'field',
					'value' => esc_attr__('Icons', 'onetone' ),
					'field' => 'icon',),
			   'default'     => $banner_icons,
			   'fields' => array(
		
				  'icon' => array(
					  'type'        => 'text',
					  'label'       => __('Insert Fontawsome icon code', 'onetone'),
					  'description' => '',
					  'default'     => '',
				  ),
				  'icon_link' => array(
					  'type'        => 'url',
					  'label'       => esc_attr__( 'Link', 'onetone' ),
					  'description' =>  __('Insert link for the icon', 'onetone'),
					  'default'     => '',
				  ),
				 ),
				 'active_callback' => array(
								array(
									'setting'  => $option_name.'[section_content_model_'.$id.']',
									'operator' => '===',
									'value'    => '0',
								),)
			  );

			break;
			case "1": // Section Slogan
			 $options[] = array(
						  'label' => __('Button Text', 'onetone'),
						  'slug'   => "section_btn_text_".$id,
						  'default'  => 'Click Me',
						  'description' => __('Insert text for the button', 'onetone'),
						  'type' => 'text',
						  'section' => 'sections_'.$id,
						  'active_callback' => array(
								array(
									'setting'  => $option_name.'[section_content_model_'.$id.']',
									'operator' => '===',
									'value'    => '0',
								),),
						 'transport' => 'postMessage',
						 'js_vars'   => array(
							  array(
								  'element'  => '.section_btn_text_'.$id.'',
								  'function' => 'html',
								  )
							  ),
						  );
						  
			  $options[] = array(
						  'label'       => __('Button Link', 'onetone'),
						  'slug'        => "section_btn_link_".$id,
						  'default'     => '#',
						  'description' => __('Insert link for the button, begin with http:// or https://', 'onetone'),
						  'type' => 'text',
						  'section' => 'sections_'.$id,
						  'transport' => 'postMessage',
						  'active_callback' => array(
								array(
									'setting'  => $option_name.'[section_content_model_'.$id.']',
									'operator' => '===',
									'value'    => '0',
								),)
						  );
						  
			  $options[] = array(
						  'label'       => __('Button Target', 'onetone'),
						  'slug'        => "section_btn_target_".$id,
						  'default'     => '_self',
						  'description' => __('Self: open in the same window; blank: open in a new window', 'onetone'),
						  'type' => 'select',
						  'transport' => 'postMessage',
						  'choices' => $target,
						  'section' => 'sections_'.$id,
						  'active_callback' => array(
								array(
									'setting'  => $option_name.'[section_content_model_'.$id.']',
									'operator' => '===',
									'value'    => '0',
								),)
						  );
			  
				$options[] = array(
						  'label'       => __('Description', 'onetone'),
						  'description' => '',
						  'slug'        => 'section_desc_'.$id,
						  'default'     => '<h4>Morbi rutrum, elit ac fermentum egestas, tortor ante vestibulum est, eget scelerisque nisl velit eget tellus.</h4>',
						  'description' => __('Insert content for the banner, html tags allowed', 'onetone'),
						  'type' => 'textarea',
						  'section' => 'sections_'.$id,
						  'active_callback' => array(
								array(
									'setting'  => $option_name.'[section_content_model_'.$id.']',
									'operator' => '===',
									'value'    => '0',
								),),
						 'transport' => 'postMessage',
						 'js_vars'   => array(
							  array(
								  'element'  => '.section_desc_'.$id.' h4',
								  'function' => 'html',
								  )
							  ),
							  
						  );
			
			break;
			case "2": // Section Service
			$icons   = array('fa-leaf','fa-hourglass-end','fa-signal','fa-heart','fa-camera','fa-tag');
			$images  = array(
							 $imagepath.'frontpage/Icon_1.png',
							 $imagepath.'frontpage/Icon_2.png',
							 $imagepath.'frontpage/Icon_3.png',
							 $imagepath.'frontpage/Icon_4.png',
							 $imagepath.'frontpage/Icon_5.png',
							 $imagepath.'frontpage/Icon_6.png',
							 );
			
			$options[] = array(
						  'slug'        => 'section_service_icon_color_'.$id.'',
						  'label'       => __( 'Icon Color', 'onetone' ),
						  'description' => __( 'Set service icon color.', 'onetone' ),
						  'default'     => '#666666',
						  'type'        => 'color',
						  'section' => 'sections_'.$id,
						  'active_callback' => array(
								array(
									'setting'  => $option_name.'[section_content_model_'.$id.']',
									'operator' => '===',
									'value'    => '0',
								),),
						'output' => array(
								  array(
									  'element'  => 'section.home-section-'.$id.' i',
									  'property' => 'color',
								  ),
							  
							  ),
						'transport' => 'postMessage',
						 'js_vars'   => array(
							  array(
								  'element'  => 'section.home-section-'.$id.' i',
								  'function' => 'css',
								  'property' => 'color',
								  )
							  ),
						);
	
	// service items
	
	$default_services = array();
	$j = 0;
	for($c=0;$c<6;$c++){
		$icon   = onetone_option_saved( "section_icon_".$id."_".$c);
		$image  = onetone_option_saved( "section_image_".$id."_".$c);
		$title  = onetone_option_saved( "section_title_".$id."_".$c);
		$desc   = onetone_option_saved( "section_desc_".$id."_".$c);
		if($icon!=''||$image!=''||$title!=''||$desc!=''){
			$link   = onetone_option_saved( "section_link_".$id."_".$c);
			$target = onetone_option_saved( "section_target_".$id."_".$c);
			$default_services[$j] = array('icon'=>$icon,'image'=>$image,'title'=>$title,'link'=>$link,'target'=>$target,'description'=>$desc);
	  }
	  $j++;
	}
	
	if(empty($default_services)){
		for($c=0;$c<6;$c++){
			$default_services[$c] = array('icon'=>$icons[$c],'image'=>$images[$c],'title'=>'FREE PSD TEMPLATE','link'=>'','target'=>'_blank','description'=>'Integer pulvinar elementum est, suscipit ornare ante finibus ac. Praesent vel ex dignissim, rhoncus eros luctus, dignissim arcu.' );
		}
	}
		
	$options[] =  array(
       'slug'        => 'section_service_'.$id,
       'label'       => __( 'Service', 'onetone' ),
       'description' => '',
       'type'        => 'repeater',	   
	   'row_label' => array(
	   		'type' => 'field',
            'value' => esc_attr__('Service', 'onetone' ),
            'field' => 'title'
			),
	   'default'     => $default_services,
	   'section' => 'sections_'.$id,
	   'fields' => array(

		  'icon' => array(
			  'type'        => 'text',
			  'label'       => esc_attr__( 'Icon', 'onetone' ),
			  'description' => __('Insert Fontawsome icon code', 'onetone'),
			  'default'     => '',
		  ),
		  'image' => array(
			  'type'        => 'image',
			  'label'       => esc_attr__( 'Image', 'onetone' ),
			  'description' => __('Or choose to upload icon image', 'onetone'),
			  'default'     => '',
		  ),
		  'title' => array(
			  'type'        => 'text',
			  'label'       => esc_attr__( 'Title', 'onetone' ),
			  'description' =>  __('Set title for service item', 'onetone'),
			  'default'     => '',
			  
		  ),
		  'link' => array(
			  'type'        => 'url',
			  'label'       => esc_attr__( 'Link', 'onetone' ),
			  'description' => __('Insert link for service item', 'onetone'),
			  'transport' => 'postMessage',
			  'default'     => '',
		  ),
		  'target' => array(
			  'type'        => 'select',
			  'label'       => esc_attr__( 'Link', 'onetone' ),
			  'description' => __('Self: open in the same window; blank: open in a new window', 'onetone'),
			  'default'     => '_blank',
			  'choices'=>$target,
			  
		  ),
		  'description' => array(
			  'type'        => 'textarea',
			  'label'       => esc_attr__( 'Description', 'onetone' ),
			  'description' => __('Insert content for the banner, html tags allowed', 'onetone'),
			  'default'     => '',
		  ),

	  ),
	  'active_callback' => array(
								array(
									'setting'  => $option_name.'[section_content_model_'.$id.']',
									'operator' => '===',
									'value'    => '0',
								),)
      );
	  
	
			
	break;
			
	case "3": // Section Gallery
			
	$default_images = array(
							$imagepath.'frontpage/gallery.png',
							$imagepath.'frontpage/gallery.png',
							$imagepath.'frontpage/gallery.png',
							$imagepath.'frontpage/gallery.png',
							$imagepath.'frontpage/gallery.png',
							$imagepath.'frontpage/gallery.png',
						);
			
			
	// Gallery items
	
	$default_gallery = array();
	$j = 0;
	for($c=0;$c<12;$c++){
	  $image = onetone_option_saved( "section_image_".$id."_".$c); 
	  $link   = onetone_option_saved( "section_link_".$id."_".$c);
	  if($image!='' || $link!=''){
		$target = onetone_option_saved( "section_target_".$id."_".$c);
	  	$default_gallery[$j] = array('image'=>esc_url($image),'link'=>esc_url($link),'target'=>esc_attr($target));
	  }
	  $j++;
	}
	
	if(empty($default_gallery)){
		$c = 0;
		foreach($default_images as $default_image){
			$default_gallery[$c] = array('image'=>$default_images[$c],'link'=>'','target'=>'_blank');
			$c++;
		}
	}
	
	$options[] =  array(
       'slug'        => 'section_gallery_'.$id,
       'label'       => __( 'Gallery', 'onetone' ),
       'description' => '',
       'type'        => 'repeater',
	   'row_label' => array(
	   		'type' => 'field',
            'value' => esc_attr__('Item', 'onetone' ),
            'field' => 'title',),
	   'default'     => $default_gallery,
	   'section' => 'sections_'.$id,
	   'fields' => array(
		  
		  'image' => array(
			  'type'        => 'image',
			  'label'       => esc_attr__( 'Image', 'onetone' ),
			  'description' => __('Upload image', 'onetone'),
			  'default'     => '',
		  ),
		  'link' => array(
			  'type'        => 'url',
			  'label'       => esc_attr__( 'Link', 'onetone' ),
			  'description' => __('Insert link for gallery item', 'onetone'),
			  'default'     => '',
		  ),
		  'target' => array(
			  'type'        => 'select',
			  'label'       => esc_attr__( 'Link', 'onetone' ),
			  'description' => __('Self: open in the same window; blank: open in a new window', 'onetone'),
			  'default'     => '_blank',
			  'choices'=>$target,
		  ),
		  
	  ),
	  'active_callback' => array(
								array(
									'setting'  => $option_name.'[section_content_model_'.$id.']',
									'operator' => '===',
									'value'    => '0',
								),)
      );
	  
			
			break;
			case "4": // Section Team
			$social_icon = array('instagram','facebook','google-plus','envelope');
			$avatars     = array(
							$imagepath.'frontpage/person.jpg',
							$imagepath.'frontpage/person.jpg',
							$imagepath.'frontpage/person.jpg',
							$imagepath.'frontpage/person.jpg',
							);
			
			$columns = onetone_option_saved( "section_team_columns" );
			$style   = onetone_option_saved( "section_team_style" );
			if(!is_numeric($columns))
				$columns = 4;
			if(!is_numeric($style))
				$style = 1;
				
			$options[] = array(
						  'slug' => "section_team_columns_".$id,
						  'label' => __( 'Columns', 'onetone' ),
						  'description' => __( 'Set columns for portfolio module', 'onetone' ),
						  'type'    => 'select',
						  'choices' => array(1=>1,2=>2,3=>3,4=>4),
						  'default' => $columns,
						  'section' => 'sections_'.$id,
						  'active_callback' => array(
								array(
									'setting'  => $option_name.'[section_content_model_'.$id.']',
									'operator' => '===',
									'value'    => '0',
								),)
					  );
			
			$options[] = array(
						  'slug' => "section_team_style_".$id,
						  'label' => __( 'Style', 'onetone' ),
						  'description' => '',
						  'type'    => 'select',
						  'choices' => array(0=> __('Normal', 'onetone'),1=>__('Carousel', 'onetone') ),
						  'default' => $style,
						  'section' => 'sections_'.$id,
						  'active_callback' => array(
								array(
									'setting'  => $option_name.'[section_content_model_'.$id.']',
									'operator' => '===',
									'value'    => '0',
								),)
					  );
			
			// Team items
						
			$default_team = array();
			
			$j = 0;
			for($c=0;$c<8;$c++){
				$avatar      = onetone_option_saved( "section_avatar_".$id."_".$c);
				$name        = onetone_option_saved( "section_name_".$id."_".$c);
				$byline      = onetone_option_saved( "section_byline_".$id."_".$c);
				$description = onetone_option_saved( "section_desc_".$id."_".$c);
			   
			if($avatar!='' || $name !='' || $byline !='' || $description !='' ){
				$link        = onetone_option_saved( "section_link_".$id."_".$c);
				$icon_0      = onetone_option_saved( 'section_icon_'.$id.'_'.$c.'_0');
				$icon_link_0 = onetone_option_saved( 'section_icon_link_'.$id.'_'.$c.'_0');
				$icon_1      = onetone_option_saved( 'section_icon_'.$id.'_'.$c.'_1');
				$icon_link_1 = onetone_option_saved( 'section_icon_link_'.$id.'_'.$c.'_1');
				$icon_2      = onetone_option_saved( 'section_icon_'.$id.'_'.$c.'_2');
				$icon_link_2 = onetone_option_saved( 'section_icon_link_'.$id.'_'.$c.'_2');
				$icon_3      = onetone_option_saved( 'section_icon_'.$id.'_'.$c.'_3');
				$icon_link_3 = onetone_option_saved( 'section_icon_link_'.$id.'_'.$c.'_3');
				
				$default_team[$j] = array(
					'avatar'=> esc_url($avatar),
					'link'=>esc_url($link),
					'name'=>esc_attr($name),
					'byline' => esc_attr($byline),
					'description' => esc_attr($description),
					'icon_0'=>esc_attr($icon_0),
					'icon_link_0'=>esc_url($icon_link_0),
					'icon_1'=>esc_attr($icon_1),
					'icon_link_1'=>esc_url($icon_link_1),
					'icon_2'=>esc_attr($icon_2),
					'icon_link_2'=>esc_url($icon_link_2),
					'icon_3'=>esc_attr($icon_3),
					'icon_link_3'=>esc_url($icon_link_3),

					);
			  }
			  $j++;
			}
			
			if(empty($default_team)){
				
				$c = 0;
				for($c = 0;$c<4;$c++){
					$default_team[$c] = array(
						'avatar' => $avatars[$c],
						'link' => '',
						'name' => 'KEVIN PERRY',
						'byline' => 'SOFTWARE DEVELOPER',
						'description' => 'Vivamus congue justo eget diam interdum scelerisque. In hac habitasse platea dictumst.',
						'icon_0'=> esc_attr($social_icon[0]),
						'icon_link_0'=> '',
						'icon_1'=> esc_attr($social_icon[1]),
						'icon_link_1'=> '',
						'icon_2'=> esc_attr($social_icon[2]),
						'icon_link_2'=> '',
						'icon_3'=> esc_attr($social_icon[3]),
						'icon_link_3'=> '',
						);
						
				}
				
				}
				
		   $options[] =  array(
			   'slug'        => 'section_team_'.$id,
			   'label'       => __( 'Team', 'onetone' ),
			   'description' => '',
			   'type'        => 'repeater',
			   'row_label' => array(
					'type' => 'field',
					'value' => esc_attr__('Person', 'onetone' ),
					'field' => 'name',),
			   'default'     => $default_team,
			   'section' => 'sections_'.$id,
			   'fields' => array(
		
				  'avatar' => array(
					  'type'        => 'image',
					  'label'       => esc_attr__( 'Avatar', 'onetone' ),
					  'description' => __( 'Choose to upload image for the person avatar', 'onetone' ),
					  'default'     => '',
				  ),
				  'link' => array(
					  'type'        => 'url',
					  'label'       => esc_attr__( 'Link', 'onetone' ),
					  'description' =>  __( 'Set link for the person', 'onetone' ),
					  'default'     => '',
				  ),
				  'target' => array(
					  'type'        => 'select',
					  'label'       => esc_attr__( 'Link Target', 'onetone' ),
					  'description' =>  '',
					  'default'     => '_blank',
					  'choices'     => $target
				  ),
				  'name' => array(
					  'type'        => 'text',
					  'label'       => esc_attr__( 'Name', 'onetone' ),
					  'description' => __( 'Set name for the person', 'onetone' ),
					  'default'     => '',
				  ),
				  'byline' => array(
					  'type'        => 'text',
					  'label'       => esc_attr__( 'Byline', 'onetone' ),
					  'description' => __( 'Set byline for the person', 'onetone' ),
					  'default'     => '',
				  ),
				  'description' => array(
					  'type'        => 'textarea',
					  'label'       => esc_attr__( 'Description', 'onetone' ),
					  'description' => __( 'Insert description for the person', 'onetone' ),
					  'default'     => '',
				  ),
				   'icon_0' => array(
					  'type'        => 'text',
					  'label'       => sprintf(esc_attr__( 'Social Icon %s', 'onetone' ),1),
					  'description' => __( 'Choose social icon', 'onetone' ),
					  'default'     => '',
				  ),
				  'icon_link_0' => array(
					  'type'        => 'url',
					  'label'       => sprintf(esc_attr__( 'Social Icon Link %s', 'onetone' ),1),
					  'description' => __( 'Insert link for the icon', 'onetone' ),
					  'default'     => '',
				  ),
				  'icon_1' => array(
					  'type'        => 'text',
					  'label'       => sprintf(esc_attr__( 'Social Icon %s', 'onetone' ),2),
					  'description' => __( 'Choose social icon', 'onetone' ),
					  'default'     => '',
				  ),
				  'icon_link_1' => array(
					  'type'        => 'url',
					  'label'       => sprintf(esc_attr__( 'Social Icon Link %s', 'onetone' ),2),
					  'description' => __( 'Insert link for the icon', 'onetone' ),
					  'default'     => '',
				  ),
				  'icon_2' => array(
					  'type'        => 'text',
					  'label'       => sprintf(esc_attr__( 'Social Icon %s', 'onetone' ),3),
					  'description' => __( 'Choose social icon', 'onetone' ),
					  'default'     => '',
				  ),
				  'icon_link_2' => array(
					  'type'        => 'url',
					  'label'       => sprintf(esc_attr__( 'Social Icon Link %s', 'onetone' ),3),
					  'description' => __( 'Insert link for the icon', 'onetone' ),
					  'default'     => '',
				  ),
				  'icon_3' => array(
					  'type'        => 'text',
					  'label'       => sprintf(esc_attr__( 'Social Icon %s', 'onetone' ),4),
					  'description' => __( 'Choose social icon', 'onetone' ),
					  'default'     => '',
				  ),
				  'icon_link_3' => array(
					  'type'        => 'url',
					  'label'       => sprintf(esc_attr__( 'Social Icon Link %s', 'onetone' ),4),
					  'description' => __( 'Insert link for the icon', 'onetone' ),
					  'default'     => '',
				  ),
				 
			  ),
			  'active_callback' => array(
										array(
											'setting'  => $option_name.'[section_content_model_'.$id.']',
											'operator' => '===',
											'value'    => '0',
										),)
			  );
			
			break;
			case "5": // Section About
			
			$options[] = array(
						  'label' => __('Left Content', 'onetone'),
						  'slug'   => "section_left_content_".$id,
						  'default'  => '<h3>Biography</h3>
<p>Morbi rutrum, elit ac fermentum egestas, tortor ante vestibulum est, eget scelerisque nisl velit eget tellus. Fusce porta facilisis luctus. Integer neque dolor, rhoncus nec euismod eget, pharetra et tortor. Nulla id pulvinar nunc. Vestibulum auctor nisl vel lectus ullamcorper sed pellentesque dolor eleifend. Praesent lobortis magna vel diam mattis sagittis.Mauris porta odio eu risus scelerisque id facilisis ipsum dictum vitae volutpat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed pulvinar neque eu purus sollicitudin et sollicitudin dui ultricies. Maecenas cursus auctor tellus sit amet blandit. Maecenas a erat ac nibh molestie interdum. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Sed lorem enim, ultricies sed sodales id, convallis molestie ipsum. Morbi eget dolor ligula. Vivamus accumsan rutrum nisi nec elementum. Pellentesque at nunc risus. Phasellus ullamcorper bibendum varius. Quisque quis ligula sit amet felis ornare porta. Aenean viverra lacus et mi elementum mollis. Praesent eu justo elit.</p>',
						  'description' => __( 'Insert content for the left column, html tags allowed', 'onetone' ),
						  'type' => 'textarea',
						  'section' => 'sections_'.$id,
						  'active_callback' => array(
								array(
									'setting'  => $option_name.'[section_content_model_'.$id.']',
									'operator' => '===',
									'value'    => '0',
								),),
						 'transport' => 'postMessage',
						 'js_vars'   => array(
							  array(
								  'element'  => '.section_left_content_'.$id.'',
								  'function' => 'html',
								  )
							  ),
						  );
			
			$options[] = array(
						  'label' => __('Right Content', 'onetone'),
						  'slug'   => "section_right_content_".$id,
						  'default'  => '<h3>Personal Info</h3>
  <div>
    <ul class="magee-icon-list">
      <li><i class="fa fa-phone">&nbsp;</i> +1123 2456 689</li>
    </ul>
    <ul class="magee-icon-list">
      <li><i class="fa fa-map-marker">&nbsp;</i> 3301 Lorem Ipsum, Dolor Sit St</li>
    </ul>
    <ul class="magee-icon-list">
      <li><i class="fa fa-envelope-o">&nbsp;</i> admin@domain.com</a>.</li>
    </ul>
    <ul class="magee-icon-list">
      <li><i class="fa fa-internet-explorer">&nbsp;</i> <a href="#">Mageewp.com</a></li>
    </ul>
  </div>',
						  'description' => __( 'Insert content for the right column, html tags allowed', 'onetone' ),
						  'type' => 'textarea',
						  'section' => 'sections_'.$id,
						  'active_callback' => array(
								array(
									'setting'  => $option_name.'[section_content_model_'.$id.']',
									'operator' => '===',
									'value'    => '0',
								),),
						 'transport' => 'postMessage',
						 'js_vars'   => array(
							  array(
								  'element'  => '.section_right_content_'.$id.'',
								  'function' => 'html',
								  )
							  ),
						  );
			
			break;
			case "6": // Section Counter
			
	         $options[] = array(
						  'label' => __('Counter Title 1', 'onetone'),
						  'slug'   => "counter_title_1_".$id,
						  'default'  => $onetone_old_version?'':'Themes',
						  'description' => '',
						  'type' => 'text',
						  'section' => 'sections_'.$id,
						  'active_callback' => array(
								array(
									'setting'  => $option_name.'[section_content_model_'.$id.']',
									'operator' => '===',
									'value'    => '0',
								),),
						 'transport' => 'postMessage',
						 'js_vars'   => array(
							  array(
								  'element'  => '.counter_title_1_'.$id.'',
								  'function' => 'html',
								  )
							  ),
						  );
			 $options[] = array(
						  'label' => __('Counter Number 1', 'onetone'),
						  'slug'   => "counter_number_1_".$id,
						  'default'  => $onetone_old_version?'':'200',
						  'description' => '',
						  'type' => 'text',
						  'section' => 'sections_'.$id,
						  'active_callback' => array(
								array(
									'setting'  => $option_name.'[section_content_model_'.$id.']',
									'operator' => '===',
									'value'    => '0',
								),),
						  'transport' => 'postMessage',
						 'js_vars'   => array(
							  array(
								  'element'  => '.counter_number_1_'.$id.' span',
								  'function' => 'html',
								  )
							  ),
						  );
			 
			 $options[] = array(
						  'label' => __('Counter Title 2', 'onetone'),
						  'slug'   => "counter_title_2_".$id,
						  'default'  => $onetone_old_version?'':'Supporters',
						  'description' => '',
						  'type' => 'text',
						  'section' => 'sections_'.$id,
						  'active_callback' => array(
								array(
									'setting'  => $option_name.'[section_content_model_'.$id.']',
									'operator' => '===',
									'value'    => '0',
								),),
						  'transport' => 'postMessage',
						 'js_vars'   => array(
							  array(
								  'element'  => '.counter_title_2_'.$id.'',
								  'function' => 'html',
								  )
							  ),
						  );
			 $options[] = array(
						  'label' => __('Counter Number 2', 'onetone'),
						  'slug'   => "counter_number_2_".$id,
						  'default'  => $onetone_old_version?'':'98',
						  'description' => '',
						  'type' => 'text',
						  'section' => 'sections_'.$id,
						  'active_callback' => array(
								array(
									'setting'  => $option_name.'[section_content_model_'.$id.']',
									'operator' => '===',
									'value'    => '0',
								),),
							'transport' => 'postMessage',
						 'js_vars'   => array(
							  array(
								  'element'  => '.counter_number_2_'.$id.' span',
								  'function' => 'html',
								  )
							  ),
						  );
			 
			 
			 $options[] = array(
						  'label' => __('Counter Title 3', 'onetone'),
						  'slug'   => "counter_title_3_".$id,
						  'default'  => $onetone_old_version?'':'Projuects',
						  'description' => '',
						  'type' => 'text',
						  'section' => 'sections_'.$id,
						  'active_callback' => array(
								array(
									'setting'  => $option_name.'[section_content_model_'.$id.']',
									'operator' => '===',
									'value'    => '0',
								),),
						 'transport' => 'postMessage',
						 'js_vars'   => array(
							  array(
								  'element'  => '.counter_title_3_'.$id.'',
								  'function' => 'html',
								  )
							  ),
						  );
			 $options[] = array(
						  'label' => __('Counter Number 3', 'onetone'),
						  'slug'   => "counter_number_3_".$id,
						  'default'  => $onetone_old_version?'':'1360',
						  'description' => '',
						  'type' => 'text',
						  'section' => 'sections_'.$id,
						  'active_callback' => array(
								array(
									'setting'  => $option_name.'[section_content_model_'.$id.']',
									'operator' => '===',
									'value'    => '0',
								),),
							'transport' => 'postMessage',
							'js_vars'   => array(
							  array(
								  'element'  => '.counter_number_3_'.$id.' span',
								  'function' => 'html',
								  )
							  ),
						  );
			 
			 $options[] = array(
						  'label' => __('Counter Title 4', 'onetone'),
						  'slug'   => "counter_title_4_".$id,
						  'default'  => $onetone_old_version?'':'Customers',
						  'description' => '',
						  'type' => 'text',
						  'section' => 'sections_'.$id,
						  'active_callback' => array(
								array(
									'setting'  => $option_name.'[section_content_model_'.$id.']',
									'operator' => '===',
									'value'    => '0',
								),),
						'transport' => 'postMessage',
						 'js_vars'   => array(
							  array(
								  'element'  => '.counter_title_4_'.$id.'',
								  'function' => 'html',
								  )
							  ),
						  );
			 $options[] = array(
						  'label' => __('Counter Number 4', 'onetone'),
						  'slug'   => "counter_number_4_".$id,
						  'default'  => $onetone_old_version?'':'8000',
						  'description' => '',
						  'type' => 'text',
						  'section' => 'sections_'.$id,
						  'active_callback' => array(
								array(
									'setting'  => $option_name.'[section_content_model_'.$id.']',
									'operator' => '===',
									'value'    => '0',
								),),
							'transport' => 'postMessage',
							'js_vars'   => array(
							  array(
								  'element'  => '.counter_number_4_'.$id.' span',
								  'function' => 'html',
								  )
							  ),
						  );
			 
			break;
			case "7": // Section  Testimonial
			
			$avatars = array(
							$imagepath.'frontpage/person.jpg',
							$imagepath.'frontpage/person.jpg',
							$imagepath.'frontpage/person.jpg',
							);
			
			$options[] = array(
						  'slug' => "section_testimonial_columns_".$id,
						  'label' => __( 'Columns', 'onetone' ),
						  'description' => __( 'Set columns for testimonial module', 'onetone' ),
						  'type'    => 'select',
						  'choices' => array(1=>1,2=>2,3=>3,4=>4),
						  'default' => '3',
						  'section' => 'sections_'.$id,
						  'active_callback' => array(
								array(
									'setting'  => $option_name.'[section_content_model_'.$id.']',
									'operator' => '===',
									'value'    => '0',
								),)
					  );
			
			$options[] = array(
						  'slug' => "section_testimonial_style_".$id,
						  'label' => __( 'Style', 'onetone' ),
						  'description' => '',
						  'type'    => 'select',
						  'choices' => array(0=> __('Normal', 'onetone'),1=>__('Carousel', 'onetone') ),
						  'default' => '4',
						  'section' => 'sections_'.$id,
						  'active_callback' => array(
								array(
									'setting'  => $option_name.'[section_content_model_'.$id.']',
									'operator' => '===',
									'value'    => '0',
								),)
					  );
			
			
			// testimonial items
			
			
			$default_testimonial = array();
			$j = 0;
			for($c=0;$c<8;$c++){
				$avatar      = onetone_option_saved( "section_avatar_".$id."_".$c);
				$name        = onetone_option_saved( "section_name_".$id."_".$c);
				$byline      = onetone_option_saved( "section_byline_".$id."_".$c);
				$description = onetone_option_saved( "section_desc_".$id."_".$c);
				if($avatar!='' || $name!='' || $byline!='' || $description !=''  ){				
					$default_testimonial[$j] = array(
						'avatar'=> esc_url($avatar),
						'name'=> esc_attr($name),
						'byline' => esc_attr($byline),
						'description' => esc_attr($description),

					);
			  }
			  $j++;
			}
			
			if(empty($default_testimonial)){
				$c = 0;
				for($c = 0;$c<3;$c++){
					$default_testimonial[$c] = array(
						'avatar' => $avatars[$c],
						'name' => 'KEVIN PERRY',
						'byline' => 'Web Developer',
						'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris consequat non ex quis consectetur. Aliquam iaculis dolor erat, ut ornare dui vulputate nec. Cras a sem mattis, tincidunt urna nec, iaculis nisl. Nam congue ultricies dui.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris consequat non ex quis consectetur. Aliquam iaculis dolor erat, ut ornare dui vulputate nec. Cras a sem mattis, tincidunt urna nec, iaculis nisl. Nam congue ultricies dui.',
						);
						
				}
			}
				
		   $options[] =  array(
			   'slug'        => 'section_testimonial_'.$id,
			   'label'       => __( 'Testimonial', 'onetone' ),
			   'description' => '',
			   'type'        => 'repeater',
			   'row_label' => array(
					'type' => 'field',
					'value' => esc_attr__('Client', 'onetone' ),
					'field' => 'name',),
			   'default'     => $default_testimonial,
			   'section' => 'sections_'.$id,
			   'fields' => array(
		
				  'avatar' => array(
					  'type'        => 'image',
					  'label'       => esc_attr__( 'Avatar', 'onetone' ),
					  'description' => __( 'Choose to upload image for the client avatar', 'onetone' ),
					  'default'     => '',
				  ),
				  'name' => array(
					  'type'        => 'text',
					  'label'       => esc_attr__( 'Name', 'onetone' ),
					  'description' => __( 'Set name for the client', 'onetone' ),
					  'default'     => '',
				  ),
				  'byline' => array(
					  'type'        => 'text',
					  'label'       => esc_attr__( 'Byline', 'onetone' ),
					  'description' => __( 'Set byline for the client', 'onetone' ),
					  'default'     => '',
				  ),
				  'description' => array(
					  'type'        => 'textarea',
					  'label'       => esc_attr__( 'Description', 'onetone' ),
					  'description' => __( 'Insert description for the client', 'onetone' ),
					  'default'     => '',
				  ),
				 
			  ),
			  'active_callback' => array(
										array(
											'setting'  => $option_name.'[section_content_model_'.$id.']',
											'operator' => '===',
											'value'    => '0',
										),)
			  );

			
			break;
			case "8": // Section Contact
			$emailTo = get_option('admin_email');
			$options[] = array(
						  'label' => __('Your E-mail', 'onetone'),
						  'slug'   => "section_email_".$id,
						  'default'  => $emailTo,
						  'description' => __( 'Set email address to receive mails from contact form', 'onetone' ),
						  'type' => 'text',
						  'section' => 'sections_'.$id,
						  'active_callback' => array(
								array(
									'setting'  => $option_name.'[section_content_model_'.$id.']',
									'operator' => '===',
									'value'    => '0',
								),),
						'transport' => 'postMessage',
						  );
						  
			$options[] = array(
						  'label' => __('Display Checkbox', 'onetone'),
						  'slug'   => "section_checkbox_".$id,
						  'default'  => '',
						  'description' =>'',
						  'type' => 'checkbox',
						  'section' => 'sections_'.$id,
						  'active_callback' => array(
								array(
									'setting'  => $option_name.'[section_content_model_'.$id.']',
									'operator' => '===',
									'value'    => '0',
								),),
						//'transport' => 'postMessage',
						  );
						  
			$options[] = array(
						  'label' => __('Checkbox Description', 'onetone'),
						  'slug'   => "section_checkbox_description_".$id,
						  'default'  => __('I have read and fully agreed the <a href="#">terms</a> and <a href="#">conditions</a> of this program.', 'onetone'),
						  'description' =>'',
						  'type' => 'textarea',
						  'section' => 'sections_'.$id,
						  'active_callback' => array(
								array(
									'setting'  => $option_name.'[section_content_model_'.$id.']',
									'operator' => '===',
									'value'    => '0',
								),),
						//'transport' => 'postMessage',
						  );
			
			$options[] = array(
						  'label' => __('Checkbox Verification Tips', 'onetone'),
						  'slug'   => "section_checkbox_prompt_".$id,
						  'default'  => __('Please check the checkbox.', 'onetone'),
						  'description' =>'',
						  'type' => 'textarea',
						  'section' => 'sections_'.$id,
						  'active_callback' => array(
								array(
									'setting'  => $option_name.'[section_content_model_'.$id.']',
									'operator' => '===',
									'value'    => '0',
								),),
						//'transport' => 'postMessage',
						  );
			
			$options[] = array(
						  'label' => __('Button Text', 'onetone'),
						  'slug'   => "section_btn_text_".$id,
						  'default'  => 'Post',
						  'description' => __('Insert text for the button', 'onetone'),
						  'type' => 'text',
						  'section' => 'sections_'.$id,
						  'active_callback' => array(
								array(
									'setting'  => $option_name.'[section_content_model_'.$id.']',
									'operator' => '===',
									'value'    => '0',
								),),
							'transport' => 'postMessage',
							'js_vars'   => array(
							  array(
								  'element'  => '.section_btn_text_'.$id.' #submit',
								  'function' => 'val',
								  )
							  ),
						  );
			
			
			break;
	case "11":  // Section Blog
	
	$options[] = array(
		'slug' => 'section_category_'.$id,
		'label' => __( 'Category', 'onetone' ),
		'description' => __('Select post category.', 'onetone'),
		'type'    => 'select',
		'choices' => $options_categories,
		'default' => '',
		'section' => 'sections_'.$id,
		'active_callback' => array(
								array(
									'setting'  => $option_name.'[section_content_model_'.$id.']',
									'operator' => '===',
									'value'    => '0',
								),)
		);
	$options[] = array(
		'slug' => 'section_columns_'.$id,
		'label' => __( 'Columns', 'onetone' ),
		'description' => __('Set columns for posts module', 'onetone'),
		'type'    => 'select',
		'choices' => array(2=>2,3=>3,4=>4),
		'default' => '3',
		'section' => 'sections_'.$id,
		'active_callback' => array(
								array(
									'setting'  => $option_name.'[section_content_model_'.$id.']',
									'operator' => '===',
									'value'    => '0',
								),)
		);
		  
	$options[] = array(
		  'slug' => 'section_posts_num_'.$id,
		  'label' => __( 'Posts Num', 'onetone' ),
		  'description'   => __('Set number of posts display in this section', 'onetone' ),
		  'type'    => 'select',
		  'choices' => array(2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8,9=>9,10=>10),
		  'default' => '3',
		  'section' => 'sections_'.$id,
		  'active_callback' => array(
								array(
									'setting'  => $option_name.'[section_content_model_'.$id.']',
									'operator' => '===',
									'value'    => '0',
								),)
		  );
		  
	break;


	case 9:
	case 10:
	case 11:
	$options[] = array(
		'slug' => 'onetone_get_pro_'.$id,
		'label' => '',
		'description' => sprintf(__('<span style="padding-left:20px;">Get the <a href="%s" target="_blank">Pro version</a> of Onetone to acquire this feature.</span>', 'onetone' ),esc_url('https://www.mageewp.com/onetone-theme.html')),
		'default' => '',
		'type' => 'custom',
		'section' => 'sections_'.$id,
		'active_callback' => array(
								array(
									'setting'  => $option_name.'[section_content_model_'.$id.']',
									'operator' => '===',
									'value'    => '0',
								),)
		);
	break;

			
}
	
	$options[] = array(
		'label' => __('Section Content', 'onetone'),
		'slug' => 'section_content_'.$id,
		'default' => '',
		'type' => 'editor',
		'active_callback' => array(
								array(
									'setting'  => $option_name.'[section_content_model_'.$id.']',
									'operator' => '===',
									'value'    => '1',
								),),
		'transport' => 'postMessage',
		'section' => 'sections_'.$id,
		'js_vars'   => array(
		  array(
			  'element'  => '.section_content_'.$id.'',
			  'function' => 'html',
			  )
		  ),
		);
	
	return $options;

	}

/**
* Customizer options
*/
function onetone_theme_options(){
	
	global
	$onetone_options_saved,
	$onetone_home_sections,
	$onetone_option_args,
	$onetone_old_version,
	$onetone_options_db,
	$onetone_backup_options;

	$onetone_sidebars = array(
		''  => __( 'No Sidebar', 'onetone' ),
		'default_sidebar'  => __( 'Default Sidebar', 'onetone' ),
		'post'  => __( 'Post Sidebar', 'onetone' ),
		'post_category'  => __( 'Post Category Sidebar', 'onetone' ),
		'portfolio'  => __( 'Portfolio Sidebar', 'onetone' ),
		'portfolio_category'  => __( 'Portfolio Category Sidebar', 'onetone' ),
		'shop'  => __( 'Shop Sidebar', 'onetone' ),
		'sidebar-1'  => __( 'Sidebar 1', 'onetone' ),
		'sidebar-2'  => __( 'Sidebar 2', 'onetone' ),
		'sidebar-3'  => __( 'Sidebar 3', 'onetone' ),
		'sidebar-4'  => __( 'Sidebar 4', 'onetone' ),
		'sidebar-5'  => __( 'Sidebar 5', 'onetone' ),
		'sidebar-5'  => __( 'Sidebar 5', 'onetone' ),
		'sidebar-6'  => __( 'Sidebar 6', 'onetone' ),
		'sidebar-7'  => __( 'Sidebar 7', 'onetone' ),
		'sidebar-8'  => __( 'Sidebar 8', 'onetone' ),
	);
	
	$repeat = array( 
		'repeat'     => __( 'Repeat', 'onetone' ),
		'repeat-x'   => __( 'Repeat X', 'onetone' ),
		'repeat-y'   => __( 'Repeat Y', 'onetone' ),
		'no-repeat'  => __( 'No Repeat', 'onetone' )
		);
		
	$position =  array( 
		'top left'      => __( 'Top Left', 'onetone' ),
		'top center'    => __( 'Top Center', 'onetone' ),
		'top right'     => __( 'Top Right', 'onetone' ),
		'center left'   => __( 'Center Left', 'onetone' ),
		'center center' => __( 'Center Center', 'onetone' ),
		'center right'  => __( 'Center Right', 'onetone' ),
		'bottom left'   => __( 'Bottom Left', 'onetone' ),
		'bottom center' => __( 'Bottom Center', 'onetone' ),
		'bottom right'  => __( 'Bottom Right', 'onetone' )
	);
	
	$attachment = array( 
		'scroll'     => __( 'Scroll Normally', 'onetone' ),
		'fixed'   => __( 'Fixed in Place', 'onetone' ),
		);
	
	$choices =  array( 
		'yes' => __( 'Yes', 'onetone' ),
		'no'  => __( 'No', 'onetone' )
    );
	
	$target = array(
		'_blank' => __( 'Blank', 'onetone' ),
		'_self'  => __( 'Self', 'onetone' )
	);
	
	$align =  array( 
        ''        => __( 'Default', 'onetone' ),
        'left'    => __( 'Left', 'onetone' ),
        'right'   => __( 'Right', 'onetone' ),
        'center'  => __( 'Center', 'onetone' )         
    );
	
	$onetone_option_args['onetone_old_version'] =  $onetone_old_version;
	$onetone_option_args['repeat'] =  $repeat;
	$onetone_option_args['position'] =  $position;
	$onetone_option_args['attachment'] =  $attachment;
	$onetone_option_args['choices'] =  $choices;
	$onetone_option_args['target'] =  $target;
	$onetone_option_args['align'] =  $align;
	$onetone_option_args['option_name'] =  onetone_option_name();
	$onetone_option_args['onetone_options'] =  $onetone_options_db;
	$imagepath = get_template_directory_uri().'/images/';
	
	$opacity         = array_combine(range(0,1,0.1), range(0,1,0.1));
    $font_size       = array_combine(range(0,100,1), range(0,100,1));
	
	$section_menu        = array("Home","","Services","Gallery","Team","About","Testimonials","","Contact","Portfolio","Pricing","Blog");
	$section_slug        = array('home','','services','gallery','team','about','testimonials','','contact','portfolio',"pricing","blog");
	$section_padding     = array('','30px 0','50px 0','50px 0','50px 0','50px 0','50px 0 30px','50px 0','50px 0','50px 0','50px 0','50px 0','50px 0','50px 0','50px 0');
	$text_align          = array('center','left','center','center','center','left','center','left','center');
	
	$section_title       = array("POWERFUL ONE PAGE THEME","","","GALLERY","OUR TEAM","ABOUT","","","CONTACT","PORTFOLIO","PRICING","BLOG","","");
	$section_color       = array("#ffffff","#555555","#555555","#555555","#555555","#666666","#ffffff","#555555","#555555","#555555","#555555","#555555","#555555","#555555","#555555");
	$section_subtitle    = array(
								 "BASED ON BOOTSTRAP FRAMEWORK AND SHORTCODES, QUICK SET AND EASY BUILD, SHINES ONE PAGE SMALL BUSINESS WEBSITE.",
								 "",
								 "",
								 "Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere c.<br/>Etiam ut dui eu nisi lobortis rhoncus ac quis nunc.",
								 "Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere c.<br/>Etiam ut dui eu nisi lobortis rhoncus ac quis nunc.",
								 "",
								 "",
								 "",
								 "Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere c.<br/>Etiam ut dui eu nisi lobortis rhoncus ac quis nunc.",
								 "Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere c.<br/>Etiam ut dui eu nisi lobortis rhoncus ac quis nunc.",
								 "Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere c.<br/>Etiam ut dui eu nisi lobortis rhoncus ac quis nunc.",
								 );
	
	for($i=0;$i<15;$i++){
		
		if(isset($onetone_options_db['section_menu_'.$i])){
			$section_menu[$i] = $onetone_options_db['section_menu_'.$i];
		}
		if(isset($onetone_options_db['section_title_'.$i])){
			$section_title[$i] = $onetone_options_db['section_title_'.$i];
		}
		if(isset($onetone_options_db['section_padding_'.$i])){
			$section_padding[$i] = $onetone_options_db['section_padding_'.$i];
		}
		if(isset($onetone_options_db['text_align_'.$i])){
			$text_align[$i] = $onetone_options_db['text_align_'.$i];
		}
		if(isset($onetone_options_db['section_color_'.$i])){
			$section_color[$i] = $onetone_options_db['section_color_'.$i];
		}
		if(isset($onetone_options_db['section_subtitle_'.$i])){
			$section_subtitle[$i] = $onetone_options_db['section_subtitle_'.$i];
		}	
	}
	
	$section_css_class  = array("section-banner","","","","","","","","");
	$section_hide       = array("","","","","","","","","","","1","1","1","1","1");
	$section_model      = array("0","0","0","0","0","0","0","0","0","0","0","0","1","1","1");
	
	$section_background = array(
	     array(
			'background-color' => '#333333',
			'background-image' => get_template_directory_uri().'/images/home-bg01.jpg',
			'background-repeat' => 'repeat',
			'background-position' => 'center-center',
			'background-attachment'=>'scroll' 
		  ),
		 array(
			'background-color' => '#eeeeee',
			'background-image' => '',
			'background-repeat' => 'repeat',
			'background-position' => 'top-left',
			'background-attachment'=>'scroll' 
		),
		 array(
			'background-color' => '#ffffff',
			'background-image' => '',
			'background-repeat' => 'repeat',
			'background-position' => 'top-left',
			'background-attachment'=>'scroll' 
		),
		 array(
			'background-color' => '#eeeeee',
			'background-image' => '',
			'background-repeat' => 'repeat',
			'background-position' => 'top-left',
			'background-attachment'=>'scroll' 
		),
		 ##  section 5
		 array(
			'background-color' => '#ffffff',
			'background-image' => '',
			'background-repeat' => 'repeat',
			'background-position' => 'top-left',
			'background-attachment'=>'scroll' 
		),
		 array(
			'background-color' => '',
			'background-image' => $imagepath.'frontpage/bg1.jpg',
			'background-repeat' => 'repeat',
			'background-position' => 'center-center',
			'background-attachment'=>'fixed' 
		),
		 array(
			'background-color' => '#37cadd',
			'background-image' => '',
			'background-repeat' => 'no-repeat',
			'background-position' => 'bottom-center',
			'background-attachment'=>'scroll'
		),
		 array(
			'background-color' => '#ffffff',
			'background-image' => '',
			'background-repeat' => 'repeat',
			'background-position' => 'top left',
			'background-attachment'=>'scroll'
		),
		 
		 array(
			'background-color' => '',
			'background-image' => $imagepath.'frontpage/bg1.jpg',
			'background-repeat' => 'repeat',
			'background-position' => 'top-left',
			'background-attachment'=>'scroll'
		  ),
		 array(
			'background-color' => '#ffffff',
			'background-image' => '',
			'background-repeat' => 'repeat',
			'background-position' => 'top-left',
			'background-attachment'=>'scroll' 
		  ),
		 array(
			'background-color' => '#eeeeee',
			'background-image' => '',
			'background-repeat' => 'repeat',
			'background-position' => 'top-left',
			'background-attachment'=>'scroll'
		   ),
		array(
			'background-color' => '#ffffff',
			'background-image' => '',
			'background-repeat' => 'repeat',
			'background-position' => 'top-left',
			'background-attachment'=>'scroll' 
		  ),
		 		 
		);
	
	$section_title_typography_defaults = array(
		array('font-size'  => '64px','font-family'  => 'Lustria,serif','variant' => '700','color' => '#ffffff','text-align' => 'center'  ),
		array('font-size'  => '48px','font-family'  => 'Open Sans, sans-serif','variant' => '700','color' => '#666666','text-align' => 'center' ),
		array('font-size'  => '48px','font-family'  => 'Open Sans, sans-serif','variant' => '700','color' => '#666666','text-align' => 'center'  ),
		array('font-size'  => '36px','font-family'  => 'Open Sans, sans-serif','variant' => '700','color' => '#666666','text-align' => 'center'  ),
		array('font-size'  => '36px','font-family'  => 'Open Sans, sans-serif','variant' => '700','color' => '#666666','text-align' => 'center'  ),
		array('font-size'  => '36px','font-family'  => 'Open Sans, sans-serif','variant' => '700','color' => '#666666','text-align' => 'center'  ),
		array('font-size'  => '36px','font-family'  => 'Open Sans, sans-serif','variant' => '700','color' => '#ffffff','text-align' => 'center'  ),
		array('font-size'  => '36px','font-family'  => 'Open Sans, sans-serif','variant' => '700','color' => '#666666','text-align' => 'center'  ),
		array('font-size'  => '36px','font-family'  => 'Open Sans, sans-serif','variant' => '700','color' => '#666666','text-align' => 'center'  ),
		array('font-size'  => '36px','font-family'  => 'Open Sans, sans-serif','variant' => '700','color' => '#666666','text-align' => 'center'  ),
		array('font-size'  => '36px','font-family'  => 'Open Sans, sans-serif','variant' => '700','color' => '#666666','text-align' => 'center'  ),
		array('font-size'  => '36px','font-family'  => 'Open Sans, sans-serif','variant' => '700','color' => '#666666','text-align' => 'center'  ),
		array('font-size'  => '36px','font-family'  => 'Open Sans, sans-serif','variant' => '700','color' => '#666666','text-align' => 'center'  ),
		array('font-size'  => '36px','font-family'  => 'Open Sans, sans-serif','variant' => '700','color' => '#666666','text-align' => 'center'  ),
		array('font-size'  => '36px','font-family'  => 'Open Sans, sans-serif','variant' => '700','color' => '#666666','text-align' => 'center'  ),
							
         );
		 
	$section_subtitle_typography_defaults = array(
		array('font-size'  => '18px','font-family'  => 'Lustria,serif','variant' => 'normal','color' => '#ffffff','text-align' => 'center' ),
		array('font-size'  => '14px','font-family'  => 'Open Sans, sans-serif','variant' => 'normal','color' => '#555555','text-align' => 'center' ),
		array('font-size'  => '14px','font-family'  => 'Open Sans, sans-serif','variant' => 'normal','color' => '#555555','text-align' => 'center' ),
		array('font-size'  => '14px','font-family'  => 'Open Sans, sans-serif','variant' => 'normal','color' => '#555555','text-align' => 'center' ),
		array('font-size'  => '14px','font-family'  => 'Open Sans, sans-serif','variant' => 'normal','color' => '#555555','text-align' => 'center' ),
		array('font-size'  => '14px','font-family'  => 'Open Sans, sans-serif','variant' => 'normal','color' => '#666666','text-align' => 'center' ),
		array('font-size'  => '14px','font-family'  => 'Open Sans, sans-serif','variant' => 'normal','color' => '#ffffff','text-align' => 'center' ),
		array('font-size'  => '14px','font-family'  => 'Open Sans, sans-serif','variant' => 'normal','color' => '#555555','text-align' => 'center' ),
		array('font-size'  => '14px','font-family'  => 'Open Sans, sans-serif','variant' => 'normal','color' => '#555555','text-align' => 'center' ),
		array('font-size'  => '14px','font-family'  => 'Open Sans, sans-serif','variant' => 'normal','color' => '#666666' ,'text-align' => 'center'),
		array('font-size'  => '14px','font-family'  => 'Open Sans, sans-serif','variant' => 'normal','color' => '#666666','text-align' => 'center' ),
		array('font-size'  => '14px','font-family'  => 'Open Sans, sans-serif','variant' => 'normal','color' => '#666666','text-align' => 'center' ),
		array('font-size'  => '14px','font-family'  => 'Open Sans, sans-serif','variant' => 'normal','color' => '#666666','text-align' => 'center' ),
		array('font-size'  => '14px','font-family'  => 'Open Sans, sans-serif','variant' => 'normal','color' => '#666666','text-align' => 'center' ),
		array('font-size'  => '14px','font-family'  => 'Open Sans, sans-serif','variant' => 'normal','color' => '#666666','text-align' => 'center' ),
		array('font-size'  => '14px','font-family'  => 'Open Sans, sans-serif','variant' => 'normal','color' => '#666666','text-align' => 'center' ),
      );
	  
	$section_content_typography_defaults = array(
		array('font-size'  => '14px','font-family'  => 'Open Sans, sans-serif','variant' => 'normal','color' => '#ffffff','text-align' => 'center' ),
		array('font-size'  => '14px','font-family'  => 'Open Sans, sans-serif','variant' => 'normal','color' => '#666666','text-align' => 'left' ),
		array('font-size'  => '14px','font-family'  => 'Open Sans, sans-serif','variant' => 'normal','color' => '#666666','text-align' => 'center' ),
		array('font-size'  => '14px','font-family'  => 'Open Sans, sans-serif','variant' => 'normal','color' => '#ffffff','text-align' => 'center' ),
		array('font-size'  => '14px','font-family'  => 'Open Sans, sans-serif','variant' => 'normal','color' => '#666666','text-align' => 'center' ),
		array('font-size'  => '14px','font-family'  => 'Open Sans, sans-serif','variant' => 'normal','color' => '#555555','text-align' => 'left' ),
		array('font-size'  => '14px','font-family'  => 'Open Sans, sans-serif','variant' => 'normal','color' => '#ffffff','text-align' => 'center' ),
		array('font-size'  => '14px','font-family'  => 'Open Sans, sans-serif','variant' => 'normal','color' => '#666666','text-align' => 'left' ),
		array('font-size'  => '14px','font-family'  => 'Open Sans, sans-serif','variant' => 'normal','color' => '#666666','text-align' => 'center' ),
		array('font-size'  => '14px','font-family'  => 'Open Sans, sans-serif','variant' => 'normal','color' => '#ffffff','text-align' => 'left' ),
		array('font-size'  => '14px','font-family'  => 'Open Sans, sans-serif','variant' => 'normal','color' => '#666666','text-align' => 'left' ),
		array('font-size'  => '14px','font-family'  => 'Open Sans, sans-serif','variant' => 'normal','color' => '#666666','text-align' => 'left' ),
		array('font-size'  => '14px','font-family'  => 'Open Sans, sans-serif','variant' => 'normal','color' => '#666666','text-align' => 'left' ),
		array('font-size'  => '14px','font-family'  => 'Open Sans, sans-serif','variant' => 'normal','color' => '#666666','text-align' => 'left' ),
		array('font-size'  => '14px','font-family'  => 'Open Sans, sans-serif','variant' => 'normal','color' => '#666666','text-align' => 'left' ),
		array('font-size'  => '14px','font-family'  => 'Open Sans, sans-serif','variant' => 'normal','color' => '#666666','text-align' => 'left' ),
													 
          );
	
	$onetone_option_args['section_hide']    =  $section_hide;
	$onetone_option_args['section_model']   =  $section_model;
	$onetone_option_args['section_menu']    =  $section_menu;
	$onetone_option_args['section_slug']    =  $section_slug;
	$onetone_option_args['section_padding'] =  $section_padding;
	$onetone_option_args['text_align']      =  $text_align;
	$onetone_option_args['section_title']   =  $section_title;
	$onetone_option_args['section_color']   =  $section_color;
	$onetone_option_args['section_subtitle'] =  $section_subtitle;
	$onetone_option_args['section_css_class'] =  $section_css_class;
	$onetone_option_args['section_background'] =  $section_background;
	$onetone_option_args['section_color'] =  $section_color;
	$onetone_option_args['section_title_typography_defaults'] =  $section_title_typography_defaults;
	$onetone_option_args['section_subtitle_typography_defaults'] =  $section_subtitle_typography_defaults;
	$onetone_option_args['section_content_typography_defaults'] =  $section_content_typography_defaults;
	
	// options
	$options[] = array(
		'slug'		=> 'onetone_homepage_sections',
		'label'		=> __( 'Onetone: Home Page Sections', 'onetone' ),
		'priority'	=> 1,
		'type' 		=> 'panel'
	);

	$default_sections        = onetone_section_templates();
	$default_sections_option = array();
	$default_order           = array();
	$n                       = 0;
	foreach(  $default_sections as $k => $v ){
			$default_sections_option[$v['id']] = $v['name'];
			$default_order[$n] = array(
				'name' => $v['name'],
				'id' => $v['id'],
				'type' => $v['type'],
			);
			$n++;
		}

		
	// Sections Order
	$options[] = array(
		'slug'		=> 'onetone_sections_order',
		'label'		=> __( 'Add & Order Sections', 'onetone' ),
		'panel' 	=> 'onetone_homepage_sections',
		'priority'	=> 2,
		'type' 		=> 'section'
		);

	$options[] = array(
		'label' => '',
		'description' => sprintf(__('<span style="padding-left:20px;">Get the <a href="%s" target="_blank">Pro version</a> of Onetone to acquire this feature.</span>', 'onetone' ),esc_url('https://www.mageewp.com/onetone-theme.html')),
		'slug' => 'onetone_get_pro',
		'default' => '',
		'type' => 'custom',
		'section'    => 'onetone_sections_order',
	);
	

	//HOME SECTION OPTIONS
	
	$section_options = array();
	$onetone_section_order = onetone_option_saved('section_order');
	
	if( is_array($onetone_section_order) ){
	  $i = 0;
	  foreach ( $onetone_section_order as $home_section ){
			$section_options[]         = onetone_get_section_options($home_section['id'],$home_section['type']);
			$onetone_home_sections[$i] = array('id'=>$home_section['id'],'type'=>$home_section['type'],'name'=>onetone_get_section_tpl_name($home_section['type']));
			$i++;
	  }
	}else{
		foreach ( $default_order as $home_section ){
			$section_options[] = onetone_get_section_options($home_section['id'],$home_section['type']);
	  	}
		$onetone_home_sections = $default_order;
	}
	
	if (is_array($section_options) && !empty($section_options)){
	  foreach( $section_options as $k => $v ){
		  foreach( $v as $o ){
			  $options[] = $o;
		  }
	  }
	}
	
	$onetone_option_args['onetone_home_sections'] = $onetone_home_sections;
	
	//  Onetone: Home Page Options
	$options[] = array(
		'slug'		=> 'onetone_homepage_options',
		'label'		=> __( 'Onetone: Home Page Options', 'onetone' ),
		'priority'	=> 1,
		'type' 		=> 'panel'
	);
	
	// General Options
	$options[] = array(
		'slug'		=> 'onetone_homepage_options_general',
		'label'		=> __( 'General Options', 'onetone' ),
		'panel' 	=> 'onetone_homepage_options',
		'priority'	=> 1,
		'type' 		=> 'section'
		);
	
	$options[] = array(
		'slug'        => 'header_overlay',
		'label'       => __( 'Home Page Header Overlay', 'onetone' ),
		'description' => __( 'Choose to set home page header as overlay style.', 'onetone' ),
		'default'     => 1,
		'type'        => 'checkbox',
		'section'     => 'onetone_homepage_options_general',
		);
		
	$options[] = array(
		'slug'        => 'enable_side_nav',
		'label'       => __( 'Enable Side Navigation', 'onetone' ),
		'description' => __( 'Enable side dot navigation.', 'onetone' ),
		'default'     => '',
		'type'        => 'checkbox',
		'section'     => 'onetone_homepage_options_general',
	);
	
	$video_types = array( 'html5'=> __('HTML5 Video', 'onetone'),'youtube'=> __('YouTube Video', 'onetone'),'vimeo'=> __('Vimeo Video', 'onetone') );
	$options[] = array(	
		'label' => __('Video Background Type', 'onetone'),
		'slug' => 'video_background_type',
		'default' => 'youtube',
		'description' => __('Choose type of video background', 'onetone'),
		'choices' => $video_types,
		'type' => 'select',
		'section'     => 'onetone_homepage_options_general',
	);
	
	$video_background_section = array(""=>__('No video background','onetone'));
	
	foreach( $onetone_home_sections as $section ){
		$video_background_section[$section['id']+1] = $section['name'];
	}
			
	$options[] = array(
		'label' => __('Video Background Section', 'onetone'),
		'default' => '1',
		'slug' => 'video_background_section',
		'type' => 'select',
		'choices' => $video_background_section,
		'description' => __('Choose a section to set the video as background for', 'onetone'),
		'section'     => 'onetone_homepage_options_general',
		);
		
	$options[] = array(
		'label' => __('Display slider instead in section 1', 'onetone'),
		'default' => '0',
		'slug' => 'section_1_content',
		'sanitize_callback'	=> 'onetone_customizer_sanitize_checkbox',
		'type' => 'checkbox',
		'description' =>  __('Choose to display default slider instead of section contents here. Go to Customize > Onetone: Slideshow to set the slider.', 'onetone'),
		'section'     => 'onetone_homepage_options_general',
		);
		
	$options[] = array(
		'label' => __('Enable Animation', 'onetone'),
		'description'=>__('Enable animation for default section content.', 'onetone'),
		'default' => '1',
		'slug' => 'home_animated',
		'type' => 'checkbox',
		'section'     => 'onetone_homepage_options_general',
		);
		

	// YouTube Video Background Options
	$options[] = array(
		'slug'		=> 'youtube_video_bg_options',
		'label'		=> __( 'YouTube Video Background Options', 'onetone' ),
		'panel' 	=> 'onetone_homepage_options',
		'priority'	=> 2,
		'type' 		=> 'section'
		);
		
	$options[] = array(
		'label' => __('YouTube ID for Video Background', 'onetone'),
		'default' => 'XDLmLYXuIDM',
		'description' => __('Insert the eleven-letter id here, not url.', 'onetone'),
		'slug' => 'section_background_video_0',
		'type' => 'text',
		'section' => 'youtube_video_bg_options',
		);
		
	$options[] = array(
		'label' => __('Start Time', 'onetone'),
		'default' => '0',
		'description' => __('Choose time to start to play, in seconds', 'onetone'),
		'slug' => 'section_youtube_start',
		'type' => 'text',
		'section' => 'youtube_video_bg_options',
		);
	
	$options[] = array(
		'label' => __('Stop Time', 'onetone'),
		'default' => '0',
		'description' => __('Choose time to stop to play, in seconds', 'onetone'),
		'slug' => 'section_youtube_stop',
		'type' => 'text',
		'section' => 'youtube_video_bg_options',
		);
		
	$options[] = array(
		'label' => __('Display Video Control Buttons.', 'onetone'),
		'description' => __('Choose to display video controls at bottom of the section with video background.', 'onetone'),
		'slug' => 'video_controls',
		'default' => '1',
		'type' => 'checkbox',
		'section' => 'youtube_video_bg_options',
		);
		
	$options[] = array(
		'label' => __('Mute', 'onetone'),
		'description' => __('Choose to set the video mute', 'onetone'),
		'slug' => 'youtube_mute',
		'default' => '',
		'type' => 'checkbox',
		'section' => 'youtube_video_bg_options',
		);
		
	$options[] = array(
		'label' => __('AutoPlay', 'onetone'),
		'description' => __('Choose to set the video autoplay', 'onetone'),
		'slug' => 'youtube_autoplay',
		'default' => '1',
		'type' => 'checkbox',
		'section' => 'youtube_video_bg_options',
		);
		
	$options[] = array(
		'label' => __('Loop', 'onetone'),
		'description' => __('Choose to set the video loop', 'onetone'),
		'slug' => 'youtube_loop',
		'default' => '1',
		'type' => 'checkbox',
		'section' => 'youtube_video_bg_options',
		);
	
	$options[] = array(
		'label' => __('Anchor', 'onetone'),
		'description' => __('Define how the video will behave once the window is resized; possible value are: "top,bottom,left,right,center"; it accept a pair of value comma separated (ex: "top,right" or "bottom,left").', 'onetone'),
		'slug' => 'youtube_anchor',
		'default' => 'ceter,center',
		'type' => 'text',
		'section' => 'youtube_video_bg_options',
		);
		
	$options[] = array(
		'label' => __('Quality', 'onetone'),
		'description' => __('Choose to set the video quality.', 'onetone'),
		'slug' => 'youtube_quality',
		'default' => 'default',
		'choices' => array( 'default'=>__('Default', 'onetone'),
							'small'=>__('Small', 'onetone'),
							'medium'=>__('Medium', 'onetone'),
							'large'=>__('Large', 'onetone'),
							'hd720'=>__('HD720', 'onetone'),
							'hd1080'=>__('HD1080', 'onetone'),
							'highres'=>__('Highres', 'onetone'),
							
							),
		'type' => 'select',
		'section' => 'youtube_video_bg_options',
		);
	$options[] = array(
		'label' => __('Opacity', 'onetone'),
		'description' => __('Choose to set the video opacity.', 'onetone'),
		'slug' => 'youtube_opacity',
		'default' => '1',
		'choices' => $opacity,
		'type' => 'select',
		'section' => 'youtube_video_bg_options',
		);
		
		
	$options[] = array(
		'label' => __('Background Type', 'onetone'),
		'description' => __('Choose to set the video as background of the whole site or just one section', 'onetone'),
		'slug' => 'youtube_bg_type',
		'default' => '1',
		'choices' => array('1'=>__('Body Background', 'onetone'),'0'=>__('Section Background', 'onetone')),
		'type' => 'select',
		'section' => 'youtube_video_bg_options',
		);
	
	// Vimeo Video Background Options
	$options[] = array(
		'slug'		=> 'vimeo_video_bg_options',
		'label'		=> __( 'Vimeo Video Background Options', 'onetone' ),
		'panel' 	=> 'onetone_homepage_options',
		'priority'	=> 2,
		'type' 		=> 'section'
		);
		
	$options[] = array(
		'label' => __('Vimeo URL for Video Background', 'onetone'),
		'default' => '',
		'description' => __('Insert the vimeo video URL here, e.g. https://vimeo.com/193338881', 'onetone'),
		'slug' => 'section_background_video_vimeo',
		'type' => 'text',
		'section' => 'vimeo_video_bg_options',
		);
		
	$options[] = array(
		'label' => __('Start Time', 'onetone'),
		'default' => '1',
		'description' => __('Choose time to start to play, in seconds', 'onetone'),
		'slug' => 'section_vimeo_start',
		'type' => 'text',
		'section' => 'vimeo_video_bg_options',
		);
		
	$options[] = array(
		'label' => __('Display Video Control Buttons.', 'onetone'),
		'description' => __('Choose to display video controls at bottom of the section with video background.', 'onetone'),
		'slug' => 'vimeo_video_controls',
		'default' => '1',
		'type' => 'checkbox',
		'section' => 'vimeo_video_bg_options',
		);
		
	$options[] = array(
		'label' => __('Mute', 'onetone'),
		'description' => __('Choose to set the video mute', 'onetone'),
		'slug' => 'vimeo_mute',
		'default' => '1',
		'type' => 'checkbox',
		'section' => 'vimeo_video_bg_options',
		);
		
	$options[] = array(
		'label' => __('AutoPlay', 'onetone'),
		'description' => __('Choose to set the video autoplay', 'onetone'),
		'slug' => 'vimeo_autoplay',
		'default' => '1',
		'type' => 'checkbox',
		'section' => 'vimeo_video_bg_options',
		);
		
	$options[] = array(
		'label' => __('Loop', 'onetone'),
		'description' => __('Choose to set the video loop', 'onetone'),
		'slug' => 'vimeo_loop',
		'default' => '1',
		'type' => 'checkbox',
		'section' => 'vimeo_video_bg_options',
		);
		
	$options[] = array(
		'label' => __('Quality', 'onetone'),
		'description' => __('Choose to set the video quality.', 'onetone'),
		'slug' => 'vimeo_quality',
		'default' => 'default',
		'choices' => array( 'default'=>__('Default', 'onetone'),
							'small'=>__('Small', 'onetone'),
							'medium'=>__('Medium', 'onetone'),
							'large'=>__('Large', 'onetone'),
							'hd720'=>__('HD720', 'onetone'),
							'hd1080'=>__('HD1080', 'onetone'),
							'highres'=>__('Highres', 'onetone'),
							
							),
		'type' => 'select',
		'section' => 'vimeo_video_bg_options',
		);
		
	$options[] = array(
		'label' => __('Background Type', 'onetone'),
		'description' => __('Choose to set the video as background of the whole site or just one section', 'onetone'),
		'slug' => 'vimeo_bg_type',
		'default' => '0',
		'choices' => array('1'=>__('Body Background', 'onetone'),'0'=>__('Section Background', 'onetone')),
		'type' => 'select',
		'section' => 'vimeo_video_bg_options',
		);
	
	// Slideshow Options
	$options[] = array(
		'slug'		=> 'onetone_slider_options',
		'label'		=> __( 'Slideshow Options', 'onetone' ),
		'panel' 	=> 'onetone_homepage_options',
		'priority'	=> 3,
		'type' 		=> 'section'
		);
	
	$default_slides = array();
	$j = 0;
	for($i=1;$i<=10;$i++){
	  
		$image = onetone_option_saved( 'onetone_slide_image_'.$i); 
		if($image!=''){
			$text        = onetone_option_saved( 'onetone_slide_text_'.$i); 
			$btn_txt     = onetone_option_saved( 'onetone_slide_btn_txt_'.$i); 
			$btn_link    = onetone_option_saved( 'onetone_slide_btn_link_'.$i); 
			$btn_target  = onetone_option_saved( 'onetone_slide_btn_target_'.$i); 
			$default_slides[$j] = array('image'=>$image,'text'=>$text,'btn_txt'=>$btn_txt,'btn_link'=>$btn_link,'btn_target'=>$btn_target);
			$j++;
		}
	}
	
	if(empty($default_slides)){
		
		$default_slides = array(
		array(
			'image'=>get_template_directory_uri().'/images/banner.jpg',
			'text'=>'<h1>The jQuery slider that just slides.</h1><p>No fancy effects or unnecessary markup.</p>',
			'btn_txt'=>__('Click Me', 'onetone'),
			'btn_link'=>'#',
			'btn_target'=>'_self'
			),
		array(
			'image'=>get_template_directory_uri().'/images/banner.jpg',
			'text'=> '<h1>Fluid, flexible, fantastically minimal.</h1><p>Use any HTML in your slides, extend with CSS. You have full control.</p>',
			'btn_txt'=>__('Click Me', 'onetone'),
			'btn_link'=>'#',
			'btn_target'=>'_self'
			),
		array(
			'image'=>get_template_directory_uri().'/images/banner.jpg',
			'text'=> '<h1>Open-source.</h1><p> Vestibulum auctor nisl vel lectus ullamcorper sed pellentesque dolor eleifend.</p>',
			'btn_txt'=>__('Click Me', 'onetone'),
			'btn_link'=>'#',
			'btn_target'=>'_self'
			),
		array(
			'image'=>get_template_directory_uri().'/images/banner.jpg',
			'text'=> '<h1>Uh, that\'s about it.</h1><p>I just wanted to show you another slide.</p>',
			'btn_txt'=>__('Click Me', 'onetone'),
			'btn_link'=>'#',
			'btn_target'=>'_self'
			),
	);
		
	}
		
   $options[] =  array(
       'slug'        => 'onetone_slider',
       'label'       => __( 'Slider', 'onetone' ),
       'description' => '',
       'type'        => 'repeater',
       'section'     => 'onetone_slider_options',   
	   'row_label' => array(
	   		'type' => 'text',
            'value' => esc_attr__('Slide', 'onetone' ),
            'field' => '',),
	   'default'     => $default_slides,
	   'fields' => array(

		  'image' => array(
			  'type'        => 'image',
			  'label'       => esc_attr__( 'Image', 'onetone' ),
			  'description' => '',
			  'default'     => '',
		  ),
		  'text' => array(
			  'type'        => 'textarea',
			  'label'       => esc_attr__( 'Text', 'onetone' ),
			  'description' => '',
			  'default'     => '',
		  ),
		  'btn_txt' => array(
			  'type'        => 'text',
			  'label'       => esc_attr__( 'Button Text', 'onetone' ),
			  'description' => '',
			  'default'     => '',
		  ),
		  'btn_link' => array(
			  'type'        => 'url',
			  'label'       => esc_attr__( 'Button Link', 'onetone' ),
			  'description' => '',
			  'default'     => '',
		  ),
		  'btn_target' => array(
			  'type'        => 'select',
			  'label'       => esc_attr__( 'Button Target', 'onetone' ),
			  'description' => '',
			  'default'     => '_self',
			  'choices'     => $target,
		  ),
	  ),     
      );
		
	$options[] =  array(
		'slug'        => 'slide_autoplay',
		'label'       => __( 'Autoplay', 'onetone' ),
		'description' => __('Enable slider autoplay.', 'onetone' ),
		'default'     => '1',
		'type'        => 'checkbox',
		'section'     => 'onetone_slider_options',
		);
	
	$options[] = array(
		'slug' => 'slide_time',
		'label' => __('Autoplay Timeout', 'onetone'),
		'default' => '5000',
		'description'=>__('Milliseconds between the end of the sliding effect and the start of the nex one.','onetone'),
		'type' => 'text',
		'section'     => 'onetone_slider_options',
		);	
  
	$options[] =  array(
		'slug'        => 'slider_control',
		'label'       => __( 'Display Control', 'onetone' ),
		'description' => __( 'Display control.', 'onetone' ),
		'default'     => '1',
		'type'        => 'checkbox',
		'section'     => 'onetone_slider_options',
		);
  
	$options[] =  array(
		'slug'        => 'slider_pagination',
		'label'       => __( 'Display Pagination', 'onetone' ),
		'description' => __( 'Display pagination.', 'onetone' ),
		'default'     => '1',
		'type'        => 'checkbox',
		'section'     => 'onetone_slider_options',
		);
  
	$options[] =  array(
		'slug'        => 'slide_fullheight',
		'label'       => __( 'Full Height', 'onetone' ),
		'description' => __( 'Full screen height for desktop.', 'onetone' ),
		'default'     => '',
		'type'        => 'checkbox',
		'section'     => 'onetone_slider_options',
		);
		
	// Onetone: General Options
	
	$options[] = array(
		'slug'		=> 'onetone_general_option',
		'label'		=> __( 'Onetone: General Options', 'onetone' ),
		'priority'	=> 1,
		'type' 		=> 'panel'
	);
	
	 // 404
	$options[] = array(
		'slug'		=> 'onetone_404_page',
		'label'		=> __( '404 page', 'onetone' ),
		'panel' 	=> 'onetone_general_option',
		'priority'	=> 3,
		'type' 		=> 'section'
		);
 
	$options[] = array(
		'label' => __('404 page content', 'onetone'),
		'description' => '',
		'slug' => 'content_404',
		'default' => '<h2>WHOOPS!</h2><p>THERE IS NOTHING HERE.<br>PERHAPS YOU WERE GIVEN THE WRONG URL?</p>',
		'type' => 'textarea',
		'section'     => 'onetone_404_page',
	);
  
	// Layout
	$options[] = array(
		'slug'		=> 'onetone_layout_options',
		'label'		=> __( 'Layout Options', 'onetone' ),
		'panel' 	=> 'onetone_general_option',
		'priority'	=> 5,
		'type' 		=> 'section'
		);
  
	$options[] =  array(
		'slug'          => 'page_content_top_padding',
		'label'       => __( 'Page Content Top Padding', 'onetone' ),
		'description'        => __( 'In pixels or percentage, ex: 10px or 10%.', 'onetone' ),
		'default'         => '55px',
		'type'        => 'text',
		'section'     => 'onetone_layout_options',
	);
	
	$options[] =  array(
		'slug'        => 'page_content_bottom_padding',
		'label'       => __( 'Page Content Bottom Padding', 'onetone' ),
		'description' => __( 'In pixels or percentage, ex: 10px or 10%.', 'onetone' ),
		'default'     => '40px',
		'type'        => 'text',
		'section'     => 'onetone_layout_options',
	);
	
	$options[] =  array(
		'slug'        => 'hundredp_padding',
		'label'       => __( '100% Width Left/Right Padding ###', 'onetone' ),
		'description' => __( 'This option controls the left/right padding for page content when using 100% site width or 100% width page template. In pixels or percentage, ex: 10px or 10%.', 'onetone' ),
		'default'     => '20px',
		'type'        => 'text',
		'section'     => 'onetone_layout_options',
	);
	
	$options[] =  array(
		'slug'        => 'sidebar_padding',
		'label'       => __( 'Sidebar Padding', 'onetone' ),
		'description' => __( 'Enter a pixel or percentage based value, ex: 5px or 5%', 'onetone' ),
		'default'     => '0',
		'type'        => 'text',
		'section'     => 'onetone_layout_options',
	);
	$options[] =  array(
		  'slug'          => 'column_top_margin',
		  'label'       => __( 'Column Top Margin', 'onetone' ),
		  'description'        => __( 'Controls the top margin for all column sizes. In pixels or percentage, ex: 10px or 10%.', 'onetone' ),
		  'default'         => '0px',
		  'type'        => 'text',
		  'section'     => 'onetone_layout_options',
	);
	$options[] =  array(
		  'slug'          => 'column_bottom_margin',
		  'label'       => __( 'Column Bottom Margin', 'onetone' ),
		  'description'        => __( 'Controls the bottom margin for all column sizes. In pixels or percentage, ex: 10px or 10%.', 'onetone' ),
		  'default'         => '20px',
		  'type'        => 'text',
		  'section'     => 'onetone_layout_options',
	);

	// Additional
	$options[] = array(
		'slug'		=> 'onetone_general_options',
		'label'		=> __( 'Additional', 'onetone' ),
		'panel' 	=> 'onetone_general_option',
		'priority'	=> 6,
		'type' 		=> 'section'
		);
	
	$options[] = array( 
		'slug'		=> 'back_to_top_btn', 
		'default'	=> 'show', 
		'priority'	=> 1, 
		'label'		=> __( 'Back to Top Button', 'onetone' ),
		'section'	=> 'onetone_general_options',
		'description' => '',
		'property'	=> '',
		'type' 		=> 'select',
		'choices'  =>array("show"=> __('Show', 'onetone'),"hide"=>__('Hide', 'onetone')),
		);
		
	$options[] =  array(
		'slug'        => 'enable_image_lightbox',
		'label'       => __( 'Enable Image Lightbox?', 'onetone' ),
		'description' => '',
		'default'     => '1',
		'type'        => 'checkbox',
		'section'     => 'onetone_general_options',
		);
	
	$options[] = array(
		'label' => __('Custom CSS', 'onetone'),
		'priority'	=> 2, 
		'description' => __('The following css code will add to the header before the closing &lt;/head&gt; tag.', 'onetone'),
		'slug'   => 'custom_css',
		'default'  => 'body{margin:0px;}',
		'type' => 'code',
		'section'	=> 'onetone_general_options',
		);
	
	$options[] = array(
		'slug'		=> 'onetone_header',
		'label'		=> __( 'Onetone: Header', 'onetone' ),
		'priority'	=> 2,
		'type' 		=> 'panel'
	);
	
	// Top Bar Options 
	
	$options[] = array(
		'slug'		=> 'onetone_top_bar_options',
		'label'		=> __( 'Top Bar Options', 'onetone' ),
		'panel' 	=> 'onetone_header',
		'priority'	=> 1,
		'type' 		=> 'section'
		);
	
	$options[] = array(
        'slug'          => 'display_top_bar',
        'label'        => __( 'Display Top Bar', 'onetone' ),
        'description'        => __( 'Choose to display top bar above the header', 'onetone' ),
        'default'         => 'no',
        'type'        => 'select',
        'section'     => 'onetone_top_bar_options',
        'choices'     => $choices
      );
	  
	$options[] = array(

        'slug'          => 'top_bar_background_color',
        'label'        => __( 'Background Color', 'onetone' ),
        'description'        => __( 'Set background color for top bar', 'onetone' ),
        'default'         => '#eee',
        'type'        => 'color',
        'section'     => 'onetone_top_bar_options',
        
      );
	
	$options[] =  array(
        'slug'          => 'top_bar_left_content',
        'label'        => __( 'Left Content', 'onetone' ),
        'description'        => __( 'Choose content in left side', 'onetone' ),
        'default'         => 'info',
        'type'        => 'select',
        'section'     => 'onetone_top_bar_options',
        'choices'     => array( 
			'info'      => __( 'Info', 'onetone' ),
			'sns'       => __( 'SNS', 'onetone' ),
			'menu'      => __( 'Menu', 'onetone' ),
			'none'      => __( 'None', 'onetone' ),
        )
      );
	
	$options[] = array(
        'slug'          => 'top_bar_right_content',
        'label'        => __( 'Right Content', 'onetone' ),
        'description'        => __( 'Choose content in right side', 'onetone' ),
        'default'         => 'none',
        'type'        => 'select',
        'section'     => 'onetone_top_bar_options',
        'choices'     => array( 
			'info'      => __( 'Info', 'onetone' ),
			'sns'       => __( 'SNS', 'onetone' ),
			'menu'      => __( 'Menu', 'onetone' ),
			'none'      => __( 'None', 'onetone' ),
        ),
	
      );	
	
	$options[] = array(
        'slug'          => 'top_bar_info_color',
        'label'        => __( 'Info Color', 'onetone' ),
        'description'        => __( 'Set color for info in top bar', 'onetone' ),
        'default'         => '#555',
        'type'        => 'color',
        'section'     => 'onetone_top_bar_options',
      );
	  
	$options[] = 	array(
        'slug'          => 'top_bar_info_content',
        'label'        => __( 'Info Content', 'onetone' ),
        'description'        => __( 'Insert content for info in top bar', 'onetone' ),
        'default'         => 'Tel: 123456789',
        'type'        => 'textarea',
        'section'     => 'onetone_top_bar_options',
      );
	
	$options[] = array(
        'slug'          => 'top_bar_menu_color',
        'label'        => __( 'Menu Color', 'onetone' ),
        'description'        => __( 'Set color for menu in top bar', 'onetone' ),
        'default'         => '#555',
        'type'        => 'color',
        'section'     => 'onetone_top_bar_options',
      );
			
	$options[] =  array(
        'slug'          => 'top_bar_social_icons_color',
        'label'       => __( 'Social Icons Color', 'onetone' ),
        'description'        => '',
        'default'         => '',
        'type'        => 'color',
        'section'     => 'onetone_top_bar_options',
      );
	$options[] = array(
		'slug'          => 'top_bar_social_icons_tooltip_position',
		'label'       => __( 'Social Icon Tooltip Position', 'onetone' ),
		'description'        => '',
		'default'         => 'bottom',
		'type'        => 'select',
		'section'     => 'onetone_top_bar_options',
		'choices'     => array( 
			'left'     => __( 'left', 'onetone' ),
			'right'     => __( 'right', 'onetone' ),
			'bottom'     => __( 'bottom', 'onetone' ),
		),
	);
	
  $default_header_icons = array();
  $j = 0;
  for($i=1;$i<=9;$i++){
	  
	  $icon = onetone_option_saved( 'footer_social_icon_'.$i); 
	  if($icon!=''){
		$title = onetone_option_saved( 'footer_social_title_'.$i); 
		$link  = onetone_option_saved( 'footer_social_link_'.$i); 
	  	$default_header_icons[$j] = array('icon'=>$icon,'title'=>$title,'link'=>$link);
		$j++;
	  }
 }
		
   $options[] =  array(
   
       'slug'        => 'header_social_icons',
       'label'       => __( 'Social Icons', 'onetone' ),
       'description' => '',
       'type'        => 'repeater',
       'section'     => 'onetone_top_bar_options',   
	   'row_label' => array(
	   		'type' => 'field',
            'value' => esc_attr__('Icon', 'onetone' ),
            'field' => 'icon',),
	   'default'     => $default_header_icons,
	   'fields' => array(

		  'icon' => array(
			  'type'        => 'text',
			  'label'       => esc_attr__( 'Icon', 'onetone' ),
			  'description' => 'FontAwesome Icon, e.g. facebook. Get more icons name from https://fontawesome.com/v4.7.0/icons/',
			  'default'     => '',
		  ),
		  'title' => array(
			  'type'        => 'text',
			  'label'       => esc_attr__( 'Title', 'onetone' ),
			  'description' => '',
			  'default'     => '',
		  ),
		  'link' => array(
			  'type'        => 'url',
			  'label'       => esc_attr__( 'Link', 'onetone' ),
			  'description' => '',
			  'default'     => '',
		  ),
	  ),     
      );
	  
	 // Logo
	$options[] = array(
		'slug'		=> 'onetone_logo',
		'label'		=> __( 'Logo', 'onetone' ),
		'panel' 	=> 'onetone_header',
		'priority'	=> 3,
		'type' 		=> 'section'
		);
	  
	$options[] = array(
		'slug'          => 'logo',
		'label'       => __( 'Upload Logo', 'onetone' ),
		'description'        => __( 'Select an image file for your logo.', 'onetone' ),
		'default'         => get_template_directory_uri().'/images/logo.png',
		'type'        => 'image',
		'section'     => 'onetone_logo',
		);
  
	$options[] = array(
        'slug'          => 'overlay_logo',
        'label'       => __( 'Upload Overlay Header Logo', 'onetone' ),
        'description'        => __( 'Select an image file for your logo.', 'onetone' ),
        'default'         => get_template_directory_uri().'/images/overlay-logo.png',
        'type'        => 'image',
        'section'     => 'onetone_logo',
      );
	  
	$options[] =  array(
		'slug'          => 'logo_retina',
		'label'       => __( 'Upload Logo (Retina Version @2x)', 'onetone' ),
		'description'        => __( 'Select an image file for the retina version of the logo. It should be exactly 2x the size of main logo.', 'onetone' ),
		'default'         => '',
		'type'        => 'image',
		'section'     => 'onetone_logo',
		);
	$options[] = array(
		'slug'          => 'retina_logo_width',
		'label'       => __( 'Standard Logo Width for Retina Logo', 'onetone' ),
		'description'        => __( 'If retina logo is uploaded, enter the standard logo (1x) version width, do not enter the retina logo width. Use a number without \'px\', ex: 40', 'onetone' ),
		'default'         => '',
		'type'        => 'text',
		'section'     => 'onetone_logo',
		
		);
  
	$options[] =  array(
		'slug'          => 'retina_logo_height',
		'label'       => __( 'Standard Logo Height for Retina Logo', 'onetone' ),
		'description'        => __( 'If retina logo is uploaded, enter the standard logo (1x) version height, do not enter the retina logo height. Use a number without \'px\', ex: 40', 'onetone' ),
		'default'         => '',
		'type'        => 'text',
		'section'     => 'onetone_logo',
		
		);
	
$options[] = array(
		'slug'          => 'sticky_logo',
		'label'       => __( 'Upload Sticky Header Logo', 'onetone' ),
		'description'        => __( 'Select an image file for your logo.', 'onetone' ),
		'default'         => get_template_directory_uri().'/images/logo.png',
		'type'        => 'image',
		'section'     => 'onetone_logo',
		
		);
	  
	$options[] =  array(
		'slug'          => 'sticky_logo_retina',
		'label'       => __( 'Upload Sticky Header Logo (Retina Version @2x)', 'onetone' ),
		'description'        => __( 'Select an image file for the retina version of the logo. It should be exactly 2x the size of main logo.', 'onetone' ),
		'default'         => '',
		'type'        => 'image',
		'section'     => 'onetone_logo',
		);
	
	$options[] = array(
		'slug'          => 'sticky_logo_width_for_retina_logo',
		'label'       => __( 'Sticky Logo Width for Retina Logo', 'onetone' ),
		'description'        => __( 'If retina logo is uploaded, enter the standard logo (1x) version width, do not enter the retina logo width. Use a number without \'px\', ex: 40', 'onetone' ),
		'default'         => '',
		'type'        => 'text',
		'section'     => 'onetone_logo',
		);
	
	$options[] = array(
		'slug'          => 'sticky_logo_height_for_retina_logo',
		'label'       => __( 'Sticky Logo Height for Retina Logo', 'onetone' ),
		'description'        => __( 'If retina logo is uploaded, enter the standard logo (1x) version height, do not enter the retina logo height. Use a number without \'px\', ex: 40', 'onetone' ),
		'default'         => '',
		'type'        => 'text',
		'section'     => 'onetone_logo',
		);
  
   // Logo Options
	$options[] = array(
		'slug'		=> 'onetone_logo_options',
		'label'		=> __( 'Logo Options', 'onetone' ),
		'panel' 	=> 'onetone_header',
		'priority'	=> 5,
		'type' 		=> 'section'
		);
	
	$options[] =  array(
		  'slug'          => 'logo_position',
		  'label'       => __( 'Logo Position', 'onetone' ),
		  'description'       => __( 'Set position for logo in header', 'onetone' ),
		  'default'         => 'left',
		  'type'        => 'select',
		  'section'     => 'onetone_logo_options',
		  'choices'     => $align
		);
  
	$options[] =  array(
		  'slug'          => 'logo_left_margin',
		  'label'       => __( 'Logo Left Margin', 'onetone' ),
		  'description'        => __( 'Use a number without \'px\', ex: 40', 'onetone' ),
		  'default'         => '0',
		  'type'        => 'text',
		  'section'     => 'onetone_logo_options',
		  
		);
		
	$options[] = array(
		  'slug'          => 'logo_right_margin',
		  'label'       => __( 'Logo Right Margin', 'onetone' ),
		  'description'        => __( 'Use a number without \'px\', ex: 40', 'onetone' ),
		  'default'         => '10',
		  'type'        => 'text',
		  'section'     => 'onetone_logo_options',
		  
		);
	$options[] = array(
		  'slug'          => 'logo_top_margin',
		  'label'       => __( 'Logo Top Margin', 'onetone' ),
		  'description'        => __( 'Use a number without \'px\', ex: 40', 'onetone' ),
		  'default'         => '10',
		  'type'        => 'text',
		  'section'     => 'onetone_logo_options',
		  
		);
		
	$options[] = array(
		  'slug'          => 'logo_bottom_margin',
		  'label'       => __( 'Logo Bottom Margin', 'onetone' ),
		  'description'        => __( 'Use a number without \'px\', ex: 40', 'onetone' ),
		  'default'         => '10',
		  'type'        => 'text',
		  'section'     => 'onetone_logo_options',
		  
		);
	 
	 // Header Options 
	$options[] = array(
		'slug'		=> 'onetone_header_option',
		'label'		=> __( 'Header Options', 'onetone' ),
		'panel' 	=> 'onetone_header',
		'priority'	=> 6,
		'type' 		=> 'section'
		);
		
	
	
	$options[] = array(
        'slug'        => 'header_fullwidth',
        'label'       => __( 'Full Width Header', 'onetone' ),
        'description' => __( 'Enable header full width.', 'onetone' ),
        'default'     => '',
        'type'        => 'checkbox',
        'section'     => 'onetone_header_option',
        
        );

	$options[] = array(
        'slug'        => 'header_enable_cart',
        'label'       => __( 'Woocommerce Cart', 'onetone' ),
        'description' => __( 'Enable woocommerce cart on header.', 'onetone' ),
        'default'     => '',
        'type'        => 'checkbox',
        'section'     => 'onetone_header_option',
        
        );

	$options[] = array(
        'slug'        => 'nav_hover_effect',
        'label'       => __( 'Nav Hover Effect', 'onetone' ),
        'description' => '',
        'default'     => '3',
        'type'        => 'radio-image',
        'section'     => 'onetone_header_option',
        'choices'     => array(
							 '0'=> get_template_directory_uri().'/images/nav-style0.gif',
							 '1'=> get_template_directory_uri().'/images/nav-style1.gif',
							 '2'=> get_template_directory_uri().'/images/nav-style2.gif',
							 '3'=> get_template_directory_uri().'/images/nav-style3.gif',
							 )
      );
	
	// Header Background
	
	$options[] = array(
        'slug'        => 'header_background_parallax',
        'label'       => __( 'Parallax Background Image', 'onetone' ),
        'description' => __( 'Turn on to enable parallax scrolling on the background image for header top positions.', 'onetone' ),
        'default'     => 'no',
        'type'        => 'select',
        'section'     => 'onetone_header_option',
		'choices'     => $choices
      );
	
	$options[] =  array(
        'slug'        => 'header_top_padding',
        'label'       => __( 'Header Top Padding', 'onetone' ),
        'description' => __( 'In pixels or percentage, ex: 10px or 10%.', 'onetone' ),
        'default'     => '0px',
        'type'        => 'text',
        'section'     => 'onetone_header_option',
        
      );
	$options[] = array(
        'slug'        => 'header_bottom_padding',
        'label'       => __( 'Header Bottom Padding', 'onetone' ),
        'description' => __( 'In pixels or percentage, ex: 10px or 10%.', 'onetone' ),
        'default'     => '0px',
        'type'        => 'text',
        'section'     => 'onetone_header_option',
        
      );
	
	 //Sticky Header Options 

	$options[] = array(
		'slug'		=> 'onetone_sticky_header',
		'label'		=> __( 'Sticky Header', 'onetone' ),
		'panel' 	=> 'onetone_header',
		'priority'	=> 7,
		'type' 		=> 'section'
		);
	
	$options[] =  array(
		'slug'        => 'enable_sticky_header',
		'label'       => __( 'Enable Sticky Header', 'onetone' ),
		'description' => __( 'Choose to enable sticky header', 'onetone' ),
		'default'     => 'yes',
		'type'        => 'select',
		'section'     => 'onetone_sticky_header',
		'choices'     => $choices
		);
	$options[] = array(
		'slug'        => 'enable_sticky_header_tablets',
		'label'       => __( 'Enable Sticky Header on Tablets', 'onetone' ),
		'description' => __( 'Choose to enable sticky header on tablets', 'onetone' ),
		'default'     => 'no',
		'type'        => 'select',
		'section'     => 'onetone_sticky_header',
		'choices'     => $choices
		);
	$options[] = array(
		'slug'        => 'enable_sticky_header_mobiles',
		'label'       => __( 'Enable Sticky Header on Mobiles', 'onetone' ),
		'description' => __( 'Choose to enable sticky header on mobiles', 'onetone' ),
		'default'     => 'no',
		'type'        => 'select',
		'section'     => 'onetone_sticky_header',
		'choices'     => $choices
		);
  
	$options[] = array(
		'slug'        => 'sticky_header_menu_item_padding',
		'label'       => __( 'Sticky Header Menu Item Padding', 'onetone' ),
		'description' => __( 'Controls the space between each menu item in the sticky header. Use a number without \'px\', default is 0. ex: 10', 'onetone' ),
		'default'     => '0',
		'type'        => 'text',
		'section'     => 'onetone_sticky_header',
		
		);
	$options[] = array(
		'slug'        => 'sticky_header_navigation_font_size',
		'label'       => __( 'Sticky Header Navigation Font Size', 'onetone' ),
		'description' => __( 'Controls the font size of the menu items in the sticky header. Use a number without \'px\', default is 14. ex: 14', 'onetone' ),
		'default'     => '13',
		'type'        => 'text',
		'section'     => 'onetone_sticky_header',
		
		);
	$options[] = array(
		'slug'        => 'sticky_header_logo_width',
		'label'       => __( 'Sticky Header Logo Width', 'onetone' ),
		'description' => __( 'Controls the logo width in the sticky header. Use a number without \'px\'.', 'onetone' ),
		'default'     => '',
		'type'        => 'text',
		'section'     => 'onetone_sticky_header',
		
		);

// Blog
	
	$options[] = array(
		'slug'		=> 'onetone_blog_panel',
		'label'		=> __( 'Onetone: Pages & Posts', 'onetone' ),
		'panel' 	=> '',
		'priority'	=> 8,
		'type' 		=> 'panel'
		);
		
	// Page Title Bar
	$options[] = array(
		'slug'		=> 'onetone_page_title_bar_options',
		'label'		=> __( 'Page Title Bar', 'onetone' ),
		'panel' 	=> 'onetone_blog_panel',
		'priority'	=> 1,
		'type' 		=> 'section'
		);
	// page title bar options
 
	$options[] =  array(
		  'slug'          => 'enable_page_title_bar',
		 'label'       => __( 'Enable Page Title Bar', 'onetone' ),
		  'description'       => __( 'Choose to enable page title bar in pages & posts', 'onetone' ),
		  'default'         => '1',
		  'type'        => 'checkbox',
		  'section'     => 'onetone_page_title_bar_options',
		);
  
	$options[] =  array(
		  'slug'          => 'display_title_bar_title',
		 'label'       => __( 'Display Title?', 'onetone' ),
		  'description'        => __( 'Display title in title bar.', 'onetone' ),
		  'default'         => '1',
		  'type'        => 'checkbox',
		  'section'     => 'onetone_page_title_bar_options',
		  
		);
	
	 $options[] =  array(
		  'slug'        => 'page_title_position',
		 'label'        => __( 'Title Position', 'onetone' ),
		  'description' => '',
		  'default'     => 'left',
		  'type'        => 'radio',
		  'section'     => 'onetone_page_title_bar_options',
		  'choices'     => array( 'left' => __( 'Left', 'onetone' ), 'right' => __( 'Right', 'onetone' ), 'center' => __( 'Center', 'onetone' ) ),
	  
		);
	 
	$options[] =  array(
		  'slug'          => 'page_title_bar_top_padding',
		 'label'       => __( 'Page Title Bar Top Padding', 'onetone' ),
		  'description'        => __( 'In pixels, ex: 40px', 'onetone' ),
		  'default'         => '40px',
		  'type'        => 'text',
		  'section'     => 'onetone_page_title_bar_options',
	);
	 
	$options[] =  array(
		  'slug'          => 'page_title_bar_bottom_padding',
		 'label'       => __( 'Page Title Bar Bottom Padding', 'onetone' ),
		  'description'        => __( 'In pixels, ex: 40px', 'onetone' ),
		  'default'         => '40px',
		  'type'        => 'text',
		  'section'     => 'onetone_page_title_bar_options',
	);
	$options[] =  array(
		  'slug'          => 'page_title_bar_mobile_top_padding',
		 'label'       => __( 'Page Title Bar Mobile Top Padding', 'onetone' ),
		  'description'        => __( 'In pixels, ex: 10px', 'onetone' ),
		  'default'         => '10px',
		  'type'        => 'text',
		  'section'     => 'onetone_page_title_bar_options',
	);
	 
	$options[] =  array(
		  'slug'          => 'page_title_bar_mobile_bottom_padding',
		 'label'       => __( 'Page Title Bar Mobile Bottom Padding', 'onetone' ),
		  'description'        => __( 'In pixels, ex: 10px', 'onetone' ),
		  'default'         => '10px',
		  'type'        => 'text',
		  'section'     => 'onetone_page_title_bar_options',
	);
  	
	$page_title_bar_background = onetone_option_saved('page_title_bar_background');
		
	$options[] = array(
		  'label' => __('Page Title Bar Background', 'onetone'),
		  'slug' => 'page_title_bar_background1',
		  'type' => 'background',
		  'description' => '',
		  'section'     => 'onetone_page_title_bar_options',
		  'default'=>array('background-color' => '',
			  'background-image' => esc_url( $page_title_bar_background ),
			  'background-repeat'     => '',
			  'background-position'   => 'top-left',
			  'background-size'       =>onetone_option_saved('page_title_bg_full')=="yes"?'cover':'',
			  'background-attachment' => ''
			  ),
			  'output'      => array(
							  array(
								  'element' => '.page-title-bar',
							  ),
						  ),
		  );
	
	$page_title_bar_background = onetone_option_saved('page_title_bar_retina_background');
	if( $page_title_bar_background != '' )
		$page_title_bar_background = esc_url( $page_title_bar_background );
		
	$options[] = array(
		  'label' => __('Page Title Bar Retina Background', 'onetone'),
		  'slug' => 'page_title_bar_retina_background1',
		  'type' => 'background',
		  'section'     => 'onetone_page_title_bar_options',
		  'description' => '',
		  'default'=>array('background-color' => '',
			  'background-image' => $page_title_bar_background,
			  'background-repeat'     => '',
			  'background-position'   => 'top-left',
			  'background-size'       =>onetone_option_saved('page_title_bg_full')=="yes"?'cover':'',
			  'background-attachment' => ''
			  ),
			  'output'      => array(
							  array(
								  'element' => '.page-title-bar-retina',
							  ),
						  ),
		  );
		  

  $options[] = array(
		  'slug'          => 'page_title_bg_parallax',
		 'label'       => __( 'Parallax Background Image', 'onetone' ),
		  'description'        => __( 'Select yes to enable parallax background image when scrolling.', 'onetone' ),
		  'default'         => '',
		  'type'        => 'checkbox',
		  'section'     => 'onetone_page_title_bar_options',
		);
  
  $options[] = array(
		'slug'		=> 'onetone_breadcrumb_options',
		'label'		=> __( 'Breadcrumb', 'onetone' ),
		'panel' 	=> 'onetone_blog_panel',
		'priority'	=> 2,
		'type' 		=> 'section'
		);
   
   $options[] =  array(
		  'slug'        => 'display_breadcrumb',
		 'label'        => __( 'Display breadcrumb', 'onetone' ),
		  'description' => '',
		  'default'     => '1',
		  'type'        => 'checkbox',
		  'section'     => 'onetone_breadcrumb_options',

		);
	$options[] =  array(
		  'slug'          => 'breadcrumbs_on_mobile_devices',
		 'label'       => __( 'Breadcrumbs on Mobile Devices', 'onetone' ),
		  'description'        => __( 'Check to display breadcrumbs on mobile devices.', 'onetone' ),
		  'default'         => '',
		  'type'        => 'checkbox',
		  'section'     => 'onetone_breadcrumb_options',
		);
	$options[] =  array(
		  'slug'          => 'breadcrumb_menu_prefix',
		 'label'       => __( 'Breadcrumb Menu Prefix', 'onetone' ),
		  'description'        => __( 'The text before the breadcrumb menu.', 'onetone' ),
		  'default'         => '',
		  'type'        => 'text',
		  'section'     => 'onetone_breadcrumb_options',
	);
	$options[] =  array(
		  'slug'          => 'breadcrumb_menu_separator',
		 'label'       => __( 'Breadcrumb Menu Separator', 'onetone' ),
		  'description'        => __( 'Choose a separator between the single breadcrumbs.', 'onetone' ),
		  'default'         => '/',
		  'type'        => 'text',
		  'section'     => 'onetone_breadcrumb_options',
	);


	$options[] = array(
		'slug'		=> 'onetone_blog',
		'label'		=> __( 'Blog', 'onetone' ),
		'panel' 	=> 'onetone_blog_panel',
		'priority'	=> 8,
		'type' 		=> 'section'
		);


	$options[] =  array(
		'slug'          => 'archive_content',
		'label'       => __( 'Blog Archive List Content', 'onetone' ),
		'description'        => __('Choose to display full content or excerpt in blog archive pages', 'onetone'),
		'default'         => 'excerpt',
		'type'        => 'select',
		'section'     => 'onetone_blog',
		'choices'     => array(
			'content' =>  __( 'Content', 'onetone' ),
			'excerpt' =>  __( 'Excerpt', 'onetone' ),
			)
		);
	
	$options[] =  array(
		  'slug'          => 'excerpt_length',
		 'label'       => __( 'Excerpt Length', 'onetone' ),
		  'description'        => '',
		  'default'         => '55',
		  'type'        => 'text',
		  'section'     => 'onetone_blog',
	);
  
	$options[] =  array(
		'slug'        => 'display_author_info',
		'label'       => __( 'Display Author Info?', 'onetone' ),
		'description' => __('Display author info on single page.', 'onetone'),
		'default'     => '1',
		'type'        => 'checkbox',
		'section'     => 'onetone_blog',
		);
	
	$options[] =  array(
		'slug'        => 'display_related_posts',
		'label'       => __( 'Display Related Posts?', 'onetone' ),
		'description' => __('Display related posts on single page.', 'onetone'),
		'default'     => '1',
		'type'        => 'checkbox',
		'section'     => 'onetone_blog',		  
		);
		
		$options[] =  array(
		'slug'        => 'display_post_meta',
		'label'       => __( 'Display Post Meta?', 'onetone' ),
		'description' => '',
		'default'     => '1',
		'type'        => 'checkbox',
		'section'     => 'onetone_blog',		  
		);
		$options[] =  array(
		'slug'        => 'display_meta_author',
		'label'       => __( 'Display Meta Author?', 'onetone' ),
		'description' => '',
		'default'     => '1',
		'type'        => 'checkbox',
		'section'     => 'onetone_blog',		  
		);
		
		$options[] =  array(
		'slug'        => 'display_meta_date',
		'label'       => __( 'Display Meta Date?', 'onetone' ),
		'description' => '',
		'default'     => '1',
		'type'        => 'checkbox',
		'section'     => 'onetone_blog',		  
		);
		
		$options[] =  array(
		'slug'        => 'display_meta_categories',
		'label'       => __( 'Display Meta Categories?', 'onetone' ),
		'description' => '',
		'default'     => '1',
		'type'        => 'checkbox',
		'section'     => 'onetone_blog',		  
		);
		
		$options[] =  array(
		'slug'        => 'display_meta_comments',
		'label'       => __( 'Display Meta Comments?', 'onetone' ),
		'description' => '',
		'default'     => '1',
		'type'        => 'checkbox',
		'section'     => 'onetone_blog',		  
		);
		
		$options[] =  array(
		  'slug'          => 'blog_header_title',
		 'label'       => __( 'Blog Header Title', 'onetone' ),
		  'description'        => '',
		  'default'         => __( 'Blog', 'onetone' ),
		  'type'        => 'text',
		  'section'     => 'onetone_blog',
		);
		
		$options[] =  array(
		  'slug'          => 'blog_header_subtitle',
		 'label'       => __( 'Blog Header Subtitle', 'onetone' ),
		  'description' => '',
		  'default'     => '',
		  'type'        => 'textarea',
		  'section'     => 'onetone_blog',
		);


// sidebar

	$options[] = array(
		'slug'		=> 'onetone_sidebar',
		'label'		=> __( 'Onetone: Sidebar', 'onetone' ),
		'priority'	=> 8,
		'type' 		=> 'panel'
	);

	$options[] = array(
		'slug'		=> 'onetone_sidebar_blog_posts',
		'label'		=> __( 'Single Post', 'onetone' ),
		'panel' 	=> 'onetone_sidebar',
		'priority'	=> 1,
		'type' 		=> 'section'
		);
   
  $options[] =  array(
		  'slug'        => 'left_sidebar_blog_posts',
		 'label'        => __( 'Left Sidebar', 'onetone' ),
		  'description' => __( 'Choose left sidebar for blog posts', 'onetone' ),
		  'default'     => '',
		  'type'        => 'select',
		  'section'     => 'onetone_sidebar_blog_posts',
		  'choices'     => $onetone_sidebars,
	  
		);
  $options[] =  array(
		  'slug'        => 'right_sidebar_blog_posts',
		 'label'        => __( 'Right Sidebar', 'onetone' ),
		  'description' => __( 'Choose right sidebar for blog posts', 'onetone' ),
		  'default'     => 'default_sidebar',
		  'type'        => 'select',
		  'section'     => 'onetone_sidebar_blog_posts',
		  'choices'     => $onetone_sidebars,
	  
		);
  

	$options[] = array(
		'slug'		=> 'onetone_sidebar_blog_archive',
		'label'		=> __( 'Blog Archive / Category Pages', 'onetone' ),
		'panel' 	=> 'onetone_sidebar',
		'priority'	=> 2,
		'type' 		=> 'section'
		);
  
  $options[] =  array(
		  'slug'        => 'left_sidebar_blog_archive',
		 'label'        => __( 'Left Sidebar', 'onetone' ),
		  'description' => __( 'Choose left sidebar for blog archive page', 'onetone' ),
		  'default'     => '',
		  'type'        => 'select',
		  'section'     => 'onetone_sidebar_blog_archive',
		  'choices'     => $onetone_sidebars,
	  
		);
  $options[] =  array(
		  'slug'        => 'right_sidebar_blog_archive',
		 'label'        => __( 'Right Sidebar', 'onetone' ),
		  'description' => __( 'Choose right sidebar for blog archive page', 'onetone' ),
		  'default'     => 'default_sidebar',
		  'type'        => 'select',
		  'section'     => 'onetone_sidebar_blog_archive',
		  'choices'     => $onetone_sidebars,
	  
		);

  $options[] = array(
		'slug'		=> 'onetone_sidebar_woo_products',
		'label'		=> __( 'Woocommerce Products', 'onetone' ),
		'panel' 	=> 'onetone_sidebar',
		'priority'	=> 2,
		'type' 		=> 'section'
		);
  
   $options[] =  array(
		  'slug'        => 'left_sidebar_woo_products',
		 'label'        => __( 'Left Sidebar', 'onetone' ),
		  'description' => __( 'Choose left sidebar for woocommerce product post', 'onetone' ),
		  'default'     => '',
		  'type'        => 'select',
		  'section'     => 'onetone_sidebar_woo_products',
		  'choices'     => $onetone_sidebars,
		);
		
  $options[] =  array(
		  'slug'        => 'right_sidebar_woo_products',
		 'label'        => __( 'Right Sidebar', 'onetone' ),
		  'description' => __( 'Choose right sidebar for woocommerce product post', 'onetone' ),
		  'default'     => '',
		  'type'        => 'select',
		  'section'     => 'onetone_sidebar_woo_products',
		  'choices'     => $onetone_sidebars,
		);
  
  $options[] = array(
		'slug'		=> 'onetone_sidebar_woo_archive',
		'label'		=> __( 'Woocommerce Archive', 'onetone' ),
		'panel' 	=> 'onetone_sidebar',
		'priority'	=> 3,
		'type' 		=> 'section'
		);
  
  $options[] =  array(
		'slug'          => 'left_sidebar_woo_archive',
	   'label'       => __( 'Left Sidebar', 'onetone' ),
		'description'       => __( 'Choose left sidebar for woocommerce archive page', 'onetone' ),
		'default'         => '',
		'type'        => 'select',
		'section'     => 'onetone_sidebar_woo_archive',
		'choices'     => $onetone_sidebars,
	  );
  $options[] =  array(
		'slug'          => 'right_sidebar_woo_archive',
	    'label'       => __( 'Right Sidebar', 'onetone' ),
		'description'       => __( 'Choose right sidebar for woocommerce archive page', 'onetone' ),
		'default'         => '',
		'type'        => 'select',
		'section'     => 'onetone_sidebar_woo_archive',
		'choices'     => $onetone_sidebars,
	  );
	
  $options[] = array(
	  'slug'		=> 'onetone_sidebar_portfolio_posts',
	  'label'		=> __( 'Portfolio Posts', 'onetone' ),
	  'panel' 	=> 'onetone_sidebar',
	  'priority'	=> 4,
	  'type' 		=> 'section'
	  );
  
  $options[] =  array(
	  'slug'          => 'left_sidebar_portfolio_posts',
	 'label'       => __( 'Left Sidebar', 'onetone' ),
	  'description'       => __( 'Choose left sidebar for portfolio post', 'onetone' ),
	  'default'         => '',
	  'type'        => 'select',
	  'section'     => 'onetone_sidebar_portfolio_posts',
	  'choices'     => $onetone_sidebars,
	);
	
  $options[] =  array(
	  'slug'          => 'right_sidebar_portfolio_posts',
	  'label'       => __( 'Right Sidebar', 'onetone' ),
	  'description'       => __( 'Choose right sidebar for portfolio post', 'onetone' ),
	  'default'         => '',
	  'type'        => 'select',
	  'section'     => 'onetone_sidebar_portfolio_posts',
	  'choices'     => $onetone_sidebars,
	);

  // portfolio archives
  
  $options[] = array(
	  'slug'		=> 'onetone_sidebar_portfolio_archive',
	  'label'		=> __( 'Portfolio Archive', 'onetone' ),
	  'panel' 	=> 'onetone_sidebar',
	  'priority'	=> 6,
	  'type' 		=> 'section'
	  );
  
  $options[] =  array(
	  'slug'          => 'left_sidebar_portfolio_archive',
	  'label'       => __( 'Left Sidebar', 'onetone' ),
	  'description'       => __( 'Choose left sidebar for portfolio archive page', 'onetone' ),
	  'default'         => '',
	  'type'        => 'select',
	  'section'     => 'onetone_sidebar_portfolio_archive',
	  'choices'     => $onetone_sidebars,
	);
		
  $options[] =  array(
	  'slug'          => 'right_sidebar_portfolio_archive',
	 'label'       => __( 'Right Sidebar', 'onetone' ),
	  'description'       => __( 'Choose left sidebar for portfolio archive page', 'onetone' ),
	  'default'         => '',
	  'type'        => 'select',
	  'section'     => 'onetone_sidebar_portfolio_archive',
	  'choices'     => $onetone_sidebars,
	);

 //Sidebar search
 $options[] = array(
		'slug'		=> 'onetone_sidebar_search',
		'label'		=> __( 'Search Page', 'onetone' ),
		'panel' 	=> 'onetone_sidebar',
		'priority'	=> 7,
		'type' 		=> 'section'
		);
 
  $options[] =  array(
		  'slug'          => 'left_sidebar_search',
		 'label'       => __( 'Left Sidebar', 'onetone' ),
		  'description'       => __( 'Choose left sidebar for blog search result page', 'onetone' ),
		  'default'         => '',
		  'type'        => 'select',
		  'section'     => 'onetone_sidebar_search',
		  'choices'     => $onetone_sidebars,
	  
		);
  $options[] =  array(
		  'slug'          => 'right_sidebar_search',
		 'label'       => __( 'Right Sidebar', 'onetone' ),
		  'description'       => __( 'Choose right sidebar for blog search result page', 'onetone' ),
		  'default'         => '',
		  'type'        => 'select',
		  'section'     => 'onetone_sidebar_search',
		  'choices'     => $onetone_sidebars,
	  
		);
  
  $options[] = array(
		'slug'		=> 'onetone_sidebar_404',
		'label'		=> __( '404 Page', 'onetone' ),
		'panel' 	=> 'onetone_sidebar',
		'priority'	=> 8,
		'type' 		=> 'section'
		);
  
  $options[] =  array(
		  'slug'          => 'left_sidebar_404',
		 'label'       => __( 'Left Sidebar', 'onetone' ),
		  'description'       => __( 'Choose left sidebar for 404 page', 'onetone' ),
		  'default'         => '',
		  'type'        => 'select',
		  'section'     => 'onetone_sidebar_404',
		  'choices'     => $onetone_sidebars,
	  
		);
  $options[] =  array(
		  'slug'          => 'right_sidebar_404',
		  'label'       => __( 'Right Sidebar', 'onetone' ),
		  'description'       => __( 'Choose left sidebar for 404 page', 'onetone' ),
		  'default'         => '',
		  'type'        => 'select',
		  'section'     => 'onetone_sidebar_404',
		  'choices'     => $onetone_sidebars,
	  
		);
	
  // FOOTER
  $options[] = array(
		'slug'		=> 'onetone_footer',
		'label'		=> __( 'Onetone: Footer', 'onetone' ),
		'priority'	=> 9,
		'type' 		=> 'panel'
	);

	$options[] = array(
		'slug'		=> 'onetone_footer_widgets_area_options',
		'label'		=> __( 'Footer Widgets Area Options', 'onetone' ),
		'panel' 	=> 'onetone_footer',
		'priority'	=> 1,
		'type' 		=> 'section'
		);

  $options[] =  array(
		  'slug'          => 'enable_footer_widget_area',
		 'label'       => __( 'Display footer widgets?', 'onetone' ),
		  'description'        => __('Choose to display footer widgets', 'onetone'),
		  'default'         => '',
		  'type'        => 'checkbox',
		  'section'     => 'onetone_footer_widgets_area_options',
		  
	  
		);
  
  $options[] =  array(
		  'slug'          => 'footer_columns',
		 'label'       => __( 'Number of Footer Columns', 'onetone' ),
		  'description'        => __('Set column number for footer widget area', 'onetone'),
		  'default'         => '4',
		  'type'        => 'select',
		  'section'     => 'onetone_footer_widgets_area_options',
		  'choices'     => array( 
			'1'     => '1',
			'2'     => '2',
			'3'     => '3',
			'4'     => '4',
		  ),
	  
		);
		
  
  $options[] = array(
		  'label' => __('Footer Background', 'onetone'),
		  'slug' => 'footer_background',
		  'type' => 'background',
		  'description' => '',
		  'section'     => 'onetone_footer_widgets_area_options',
		  'default'=>array('background-color' => '',
			  'background-image' => esc_url(onetone_option_saved('footer_background_image')),
			  'background-repeat'     => onetone_option_saved('footer_background_repeat'),
			  'background-position'   => onetone_option_saved('footer_background_position')!=''?str_replace(' ','-',onetone_option_saved('footer_background_position')):'',
			  'background-size'       => onetone_option_saved('footer_bg_full')=="yes"?'cover':'',
			  'background-attachment' => ''
			  ),
			  'output'      => array(
							  array(
								  'element' => '.footer-widget-area',
							  ),
						  ),
		  );


  $options[] =  array(
		  'slug'          => 'footer_parallax_background',
		 'label'       => __( 'Parallax Background Image', 'onetone' ),
		  'description'       => __( 'Choose to set parallax background effect for footer', 'onetone' ),
		  'default'         => 'no',
		  'type'        => 'select',
		  'section'     => 'onetone_footer_widgets_area_options',
		  'choices'     => $choices
		);

  $options[] =  array(
		  'slug'          => 'footer_top_padding',
		 'label'       => __( 'Footer Top Padding', 'onetone' ),
		  'description'        => __( 'In pixels or percentage, ex: 10px or 10%.', 'onetone' ),
		  'default'         => '60px',
		  'type'        => 'text',
		  'section'     => 'onetone_footer_widgets_area_options',
);
  $options[] =  array(
		  'slug'          => 'footer_bottom_padding',
		 'label'       => __( 'Footer Bottom Padding', 'onetone' ),
		  'description'        => __( 'In pixels or percentage, ex: 10px or 10%.', 'onetone' ),
		  'default'         => '40px',
		  'type'        => 'text',
		  'section'     => 'onetone_footer_widgets_area_options',
);
  
  $options[] = array(
		'slug'		=> 'onetone_copyright_options',
		'label'		=> __( 'Copyright Options', 'onetone' ),
		'panel' 	=> 'onetone_footer',
		'priority'	=> 2,
		'type' 		=> 'section'
		);
  
  $options[] =  array(
		  'slug'          => 'display_copyright_bar',
		 'label'       => __( 'Display Copyright Bar', 'onetone' ),
		  'description'       => __( 'Choose to display copyright bar', 'onetone' ),
		  'default'         => 'yes',
		  'type'        => 'select',
		  'section'     => 'onetone_copyright_options',
		  'choices'     => $choices
		);
  $options[] =  array(
		  'slug'          => 'copyright',
		 'label'       => __( 'Copyright Text', 'onetone' ),
		  'description'        => __( 'Enter the text that displays in the copyright bar. HTML markup can be used.', 'onetone' ),
		  'default'         => 'Copyright &copy; '.date('Y').'.',
		  'type'        => 'textarea',
		  'section'     => 'onetone_copyright_options',
  
		);
  $options[] =  array(
		  'slug'          => 'copyright_top_padding',
		 'label'       => __( 'Copyright Top Padding', 'onetone' ),
		  'description'        => __( 'In pixels or percentage, ex: 10px or 10%.', 'onetone' ),
		  'default'         => '20px',
		  'type'        => 'text',
		  'section'     => 'onetone_copyright_options',
);
  $options[] =  array(
		  'slug'          => 'copyright_bottom_padding',
		 'label'       => __( 'Copyright Bottom Padding', 'onetone' ),
		  'description'        => __( 'In pixels or percentage, ex: 10px or 10%.', 'onetone' ),
		  'default'         => '20px',
		  'type'        => 'text',
		  'section'     => 'onetone_copyright_options',
);
  
  
  $options[] = array(
		'slug'		=> 'onetone_footer_social_icons',
		'label'		=> __( 'Footer Social Icons', 'onetone' ),
		'panel' 	=> 'onetone_footer',
		'priority'	=> 3,
		'type' 		=> 'section'
		);
  
  $default_footer_icons = array();
  $j = 0;
  for($i=1;$i<=9;$i++){
	  
	  $icon = onetone_option_saved( 'footer_social_icon_'.$i); 
	  if($icon!=''){
		$title = onetone_option_saved( 'footer_social_title_'.$i); 
		$link  = onetone_option_saved( 'footer_social_link_'.$i); 
	  	$default_footer_icons[$j] = array('icon'=>$icon,'title'=>$title,'link'=>$link);
		$j++;
	  }
	  
	  }

  $options[] =  array(
       'slug'        => 'footer_social_icons',
       'label'       => __( 'Social Icons', 'onetone' ),
       'description' => '',
       'type'        => 'repeater',
       'section'     => 'onetone_footer_social_icons',   
	   'row_label' => array(
	   		'type' => 'field',
            'value' => esc_attr__('Icon', 'onetone' ),
            'field' => 'icon',),
	   'default'     => $default_footer_icons,
	   'fields' => array(

		  'icon' => array(
			  'type'        => 'text',
			  'label'       => esc_attr__( 'Icon', 'onetone' ),
			  'description' => 'FontAwesome Icon, e.g. facebook. Get more icons name from https://fontawesome.com/v4.7.0/icons/',
			  'default'     => '',
		  ),
		  'title' => array(
			  'type'        => 'text',
			  'label'       => esc_attr__( 'Title', 'onetone' ),
			  'description' => '',
			  'default'     => '',
		  ),
		  'link' => array(
			  'type'        => 'url',
			  'label'       => esc_attr__( 'Link', 'onetone' ),
			  'description' => '',
			  'default'     => '',
		  ),

	  ),     
      );
	  
	  // styling
 
	$options[] = array(
		'slug'		=> 'onetone_styling',
		'label'		=> __( 'Onetone: Styling', 'onetone' ),
		'priority'	=> 8,
		'type' 		=> 'panel'
	);

	$options[] = array(
		'slug'		=> 'onetone_styling_general',
		'label'		=> __( 'Primary Color', 'onetone' ),
		'panel' 	=> 'onetone_styling',
		'priority'	=> 1,
		'type' 		=> 'section'
		);
	
	$options[] =  array(
		  'slug'          => 'primary_color',
		 'label'       => __( 'Primary Color', 'onetone' ),
		  'description'       => __( 'Set primary color for the theme', 'onetone' ),
		  'default'         => '#37cadd',
		  'type'        => 'color',
		  'section'     => 'onetone_styling_general',
		  
		);
    
	$options[] = array(
		'slug'		=> 'onetone_background_colors',
		'label'		=> __( 'Background', 'onetone' ),
		'panel' 	=> 'onetone_styling',
		'priority'	=> 2,
		'type' 		=> 'section'
		);
		
	$options[] = array(
		'label' => __('Header Background', 'onetone'),
		'slug' => 'header_background',
		'type' => 'background',
		'description' => '',
		'section'     => 'onetone_background_colors',
		'default'=>array('background-color' => onetone_option_saved('header_background_color')==''?'#ffffff':onetone_option_saved('header_background_color'),
			'background-image' => esc_url( onetone_option_saved('header_background_image')),
			'background-repeat' => esc_attr( onetone_option_saved('header_background_repeat') ),
			'background-position'   => 'top-left',
			'background-size'       => ( onetone_option_saved('header_background_full') =='yes' ) ? 'cover' : '',
			'background-attachment' => ''
		),
		
		'output' => array(
							array(
								'element' => 'header .main-header',
							),
						),
		);
	$options[] =  array(
		  'slug'          => 'sticky_header_background_color',
		 'label'       => __( 'Sticky Header Background Color', 'onetone' ),
		  'description'       => __( 'Set background color for sticky header', 'onetone' ),
		  'default'         => '#ffffff',
		  'type'        => 'color',
		  'section'     => 'onetone_background_colors',
	);
	
	$options[] = array(
		  'slug'          => 'sticky_header_background_opacity',
		 'label'       => __( 'Sticky Header Background Opacity', 'onetone' ),
		  'description'        => __( 'Opacity only works with header top position and ranges between 0 (transparent) and 1.', 'onetone' ),
		  'default'         => '0.7',
		  'type'        => 'select',
		  'section'     => 'onetone_background_colors',
		  'choices'     => $opacity,
	);

	$options[] = array(
		  'slug'          => 'content_background_color',
		 'label'       => __( 'Content Background Color', 'onetone' ),
		  'description'       => __( 'Set background color for site content', 'onetone' ),
		  'default'         => '#ffffff',
		  'type'        => 'color',
		  'section'     => 'onetone_background_colors',
		  
		);
  
	$options[] = array(
		  'slug'          => 'sidebar_background_color',
		 'label'       => __( 'Sidebar Background Color', 'onetone' ),
		  'description'       => __( 'Set background color for sidebar', 'onetone' ),
		  'default'         => '#ffffff',
		  'type'        => 'color',
		  'section'     => 'onetone_background_colors',
	);
	$options[] = array(
		  'slug'          => 'footer_background_color',
		 'label'       => __( 'Footer Background Color', 'onetone' ),
		  'description'       => __( 'Set background color for the footer', 'onetone' ),
		  'default'         => '#555555',
		  'type'        => 'color',
		  'section'     => 'onetone_background_colors',
	);
  
	$options[] = array(
		  'slug'          => 'copyright_background_color',
		 'label'       => __( 'Copyright Background Color', 'onetone' ),
		  'description'       => __( 'Set background color for the copyright area in footer', 'onetone' ),
		  'default'         => '#000000',
		  'type'        => 'color',
		  'section'     => 'onetone_background_colors',
	);
  
	$options[] = array(
		'slug'		=> 'onetone_element_colors',
		'label'		=> __( 'Element Colors', 'onetone' ),
		'panel' 	=> 'onetone_styling',
		'priority'	=> 3,
		'type' 		=> 'section'
	);
  
	$options[] =  array(
		  'slug'          => 'form_background_color',
		 'label'       => __( 'Form Background Color', 'onetone' ),
		  'description'        => __( 'Controls the background color of form fields', 'onetone' ),
		  'default'         => '',
		  'type'        => 'color',
		  'section'     => 'onetone_element_colors',
	);
	
	$options[] =  array(
		  'slug'          => 'form_text_color',
		 'label'       => __( 'Form Text Color', 'onetone' ),
		  'description'        => __( 'Controls the text color for forms', 'onetone' ),
		  'default'         => '#666666',
		  'type'        => 'color',
		  'section'     => 'onetone_element_colors',
	);
	
	$options[] =  array(
		  'slug'          => 'form_border_color',
		 'label'       => __( 'Form Border Color', 'onetone' ),
		  'description'        => __( 'Controls the border color for forms', 'onetone' ),
		  'default'         => '#666666',
		  'type'        => 'color',
		  'section'     => 'onetone_element_colors',
	);    
	
  $options[] = array(
		'slug'		=> 'onetone_font_colors',
		'label'		=> __( 'Font Colors', 'onetone' ),
		'panel' 	=> 'onetone_styling',
		'priority'	=> 4,
		'type' 		=> 'section'
		);
  
  $options[] =  array(
        'slug'          => 'fixed_header_text_color',
       'label'       => __( 'Sticky Header Text Color', 'onetone' ),
        'description'       => __( 'Set color for tagline in fixed header', 'onetone' ),
        'default'         => '#333333',
        'type'        => 'color',
        'section'     => 'onetone_font_colors',
        
      );
	  
 $options[] =  array(
        'slug'          => 'overlay_header_text_color',
       'label'       => __( 'Overlay Header Text Color', 'onetone' ),
        'description'       => __( 'Set color for tagline in overlay header', 'onetone' ),
        'default'         => '#ffffff',
        'type'        => 'color',
        'section'     => 'onetone_font_colors',
        
      );
 
  $options[] =  array(
		  'slug'          => 'page_title_color',
		 'label'       => __( 'Page Title', 'onetone' ),
		  'description'       => __( 'Set color for page title', 'onetone' ),
		  'default'         => '#555555',
		 'type'        => 'color',
		  'section'     => 'onetone_font_colors',

		);
  
  $options[] =  array(
		  'slug'          => 'h1_color',
		 'label'       => __( 'Heading 1 (H1) Font Color', 'onetone' ),
		  'description'       => __( 'Choose color for H1 headings', 'onetone' ),
		  'default'         => '#555555',
		  'type'        => 'color',
		  'section'     => 'onetone_font_colors',
);
  
  $options[] =  array(
		  'slug'          => 'h2_color',
		 'label'       => __( 'Heading 2 (H2) Font Color', 'onetone' ),
		  'description'       => __( 'Choose color for H2 headings', 'onetone' ),
		  'default'         => '#555555',
		  'type'        => 'color',
		  'section'     => 'onetone_font_colors',
);

  $options[] =  array(
		  'slug'          => 'h3_color',
		 'label'       => __( 'Heading 3 (H3) Font Color', 'onetone' ),
		  'description'       => __( 'Choose color for H3 headings', 'onetone' ),
		  'default'         => '#555555',
		  'type'        => 'color',
		  'section'     => 'onetone_font_colors',
);
  
  $options[] =  array(
		  'slug'          => 'h4_color',
		 'label'       => __( 'Heading 4 (H4) Font Color', 'onetone' ),
		  'description'       => __( 'Choose color for H4 headings', 'onetone' ),
		  'default'         => '#555555',
		  'type'        => 'color',
		  'section'     => 'onetone_font_colors',
);
  
  $options[] =  array(
		  'slug'          => 'h5_color',
		 'label'       => __( 'Heading 5 (H5) Font Color', 'onetone' ),
		  'description'       => __( 'Choose color for H5 headings', 'onetone' ),
		  'default'         => '#555555',
		  'type'        => 'color',
		  'section'     => 'onetone_font_colors',
);
  
  $options[] =  array(
		  'slug'          => 'h6_color',
		 'label'       => __( 'Heading 6 (H6) Font Color', 'onetone' ),
		  'description'       => __( 'Choose color for H6 headings', 'onetone' ),
		  'default'         => '#555555',
		  'type'        => 'color',
		  'section'     => 'onetone_font_colors',
);
   
  $options[] =  array(
		'slug'        => 'body_text_color',
		'label'       => __( 'Body Text Color', 'onetone' ),
		'description' => __( 'Choose color for body text', 'onetone' ),
		'default'     => '#333333',
		'type'        => 'color',
		'section'     => 'onetone_font_colors',
);
  
  $options[] =  array(
		'slug'        => 'links_color',
		'label'       => __( 'Links Color', 'onetone' ),
		'description' => __( 'Choose color for links', 'onetone' ),
		'default'     => '#37cadd',
		'type'        => 'color',
		'section'     => 'onetone_font_colors',
);
  
  $options[] =  array(
		'slug'        => 'breadcrumbs_text_color',
		'label'       => __( 'Breadcrumbs Text Color', 'onetone' ),
		'description' => __( 'Choose color for breadcrumbs', 'onetone' ),
		'default'     => '#555555',
		'type'        => 'color',
		'section'     => 'onetone_font_colors',
);
  
  $options[] =  array(
		'slug'        => 'sidebar_widget_headings_color',
		'label'       => __( 'Sidebar Widget Headings Color', 'onetone' ),
		'description' => __( 'Choose color for Sidebar widget headings', 'onetone' ),
		'default'     => '#333333',
		'type'        => 'color',
		'section'     => 'onetone_font_colors',
);
  
  $options[] = array(
		'slug'        => 'footer_headings_color',
		'label'       => __( 'Footer Headings Color', 'onetone' ),
		'description' => __( 'Choose color for footer headings', 'onetone' ),
		'default'     => '#ffffff',
		'type'        => 'color',
		'section'     => 'onetone_font_colors',
);
  
  $options[] = array(
		'slug'        => 'footer_text_color',
		'label'       => __( 'Footer Text Color', 'onetone' ),
		'description' => __( 'Choose color for footer text', 'onetone' ),
		'default'     => '#ffffff',
		'type'        => 'color',
		'section'     => 'onetone_font_colors',
		);
  
  $options[] = array(
		'slug'        => 'footer_link_color',
		'label'       => __( 'Footer Link Color', 'onetone' ),
		'description' => __( 'Choose color for links in footer', 'onetone' ),
		'default'     => '#a0a0a0',
		'type'        => 'color',
		'section'     => 'onetone_font_colors',
);
  
  $options[] = array(
		'slug'		=> 'onetone_main_menu_colors',
		'label'		=> __( 'Main Menu Colors', 'onetone' ),
		'panel' 	=> 'onetone_styling',
		'priority'	=> 5,
		'type' 		=> 'section'
		);
		
	$options[] =  array(
		  'slug'        => 'menu_toggle_color',
		 'label'        => __( 'Menu Toggle Color', 'onetone' ),
		  'description' => '',
		  'default'     => '',
		  'type'        => 'color',
		  'section'     => 'onetone_main_menu_colors',
	);
 
  $options[] =  array(
		  'slug'        => 'main_menu_background_color_1',
		 'label'        => __( 'Main Menu Background Color', 'onetone' ),
		  'description' => __( 'Choose background color for main menu', 'onetone' ),
		  'default'     => '',
		  'type'        => 'color',
		  'section'     => 'onetone_main_menu_colors',
);
  
  $options[] =  array(
		  'slug'        => 'main_menu_font_color_1',
		 'label'        => __( 'Main Menu Font Color ( First Level )', 'onetone' ),
		  'description' => __( 'Choose font color for first level of main menu', 'onetone' ),
		  'default'     => '#3d3d3d',
		  'type'        => 'color',
		  'section'     => 'onetone_main_menu_colors',
);
  
  $options[] =  array(
        'slug'        => 'main_menu_overlay_font_color_1',
       'label'        => __( 'Main Menu Font Color of Overlay Header ( First Level )', 'onetone' ),
        'description' => __( 'Choose font color for first level of main menu', 'onetone' ),
        'default'     => '#ffffff',
        'type'        => 'color',
        'section'     => 'onetone_main_menu_colors',
 );
  
  $options[] =  array(
		'slug'        => 'main_menu_font_hover_color_1',
		'label'        => __( 'Main Menu Font Hover Color ( First Level )', 'onetone' ),
		'description' => __( 'Choose hover color for first level of main menu', 'onetone' ),
		'default'     => '#3d3d3d',
		'type'        => 'color',
		'section'     => 'onetone_main_menu_colors',		
		);
  
  $options[] =  array(
		  'slug'        => 'main_menu_background_color_2',
		 'label'        => __( 'Main Menu Background Color ( Sub Level )', 'onetone' ),
		  'description' => __( 'Choose background color for sub level of main menu', 'onetone' ),
		  'default'     => '#ffffff',
		  'type'        => 'color',
		  'section'     => 'onetone_main_menu_colors',
);
	 
  $options[] =  array(
		  'slug'        => 'main_menu_font_color_2',
		 'label'        => __( 'Main Menu Font Color ( Sub Level )', 'onetone' ),
		  'description' => __( 'Choose font color for sub level of main menu', 'onetone' ),
		  'default'     => '#3d3d3d',
		  'type'        => 'color',
		  'section'     => 'onetone_main_menu_colors',
);
  
  $options[] =  array(
		  'slug'        => 'main_menu_font_hover_color_2',
		 'label'        => __( 'Main Menu Font Hover Color ( Sub Level )', 'onetone' ),
		  'description' => __( 'Choose hover color for sub level of main menu', 'onetone' ),
		  'default'     => '#222222',
		  'type'        => 'color',
		  'section'     => 'onetone_main_menu_colors',
);
  
  $options[] =  array(
		  'slug'        => 'main_menu_separator_color_2',
		 'label'        => __( 'Main Menu Separator Color ( Sub Levels )', 'onetone' ),
		  'description' => __( 'Choose separator color for sub level of main menu', 'onetone' ),
		  'default'     => '#000000',
		  'type'        => 'color',
		  'section'     => 'onetone_main_menu_colors',
);
  
  
  $options[] = array(
		'slug'		=> 'onetone_side_menu_colors',
		'label'		=> __( 'Front Page Side Navigation Color', 'onetone' ),
		'panel' 	=> 'onetone_styling',
		'priority'	=> 5,
		'type' 		=> 'section'
		);
  
  $options[] =  array(
		  'slug'        => 'side_menu_color',
		 'label'        => __( 'Side Navigation Color', 'onetone' ),
		  'description' => __( 'Choose color for side navigation of front page.', 'onetone' ),
		  'default'     => '#37cadd',
		  'type'        => 'color',
		  'section'     => 'onetone_side_menu_colors',
);

// Custom Fonts
	$options[] = array(
		'slug'		=> 'onetone_upload_custom_fonts',
		'label'		=> __( 'Upload Custom Fonts', 'onetone' ),
		'panel' 	=> 'onetone_styling',
		'priority'	=> 6,
		'type' 		=> 'section'
		);
	
	$options[] =  array(
			   'slug'        => 'custom_fonts',
			   'label'       => __( 'Upload Custom Fonts', 'onetone' ),
			   'description' => __( 'This feature is only available in pro version.', 'onetone' ),
			   'type'        => 'repeater',
			   'row_label' => array(
					'type' => 'field',
					'value' => esc_attr__('Name', 'onetone' ),
					'field' => 'name',),
			   'default'     => '',
			   'section' => 'onetone_upload_custom_fonts',
			   'fields' => array(
					'name' => array(
					  'type'        => 'text',
					  'label'       => esc_attr__( 'Font Family Name', 'onetone' ),
					  'description' => '',
					  'default'     => '',
				  ),
				  
				  	'eot' => array(
					 	'type'        => 'upload',
					 	'label'       => esc_attr__( '.EOT File', 'onetone' ),
						'description' => '',
					 	'default'     => '',
				 	 ),
					 'woff' => array(
					 	'type'        => 'upload',
					 	'label'       => esc_attr__( '.WOFF File', 'onetone' ),
						'description' => '',
					 	'default'     => '',
				 	 ),
					 'ttf' => array(
					 	'type'        => 'upload',
					 	'label'       => esc_attr__( '.TTF File', 'onetone' ),
						'description' => '',
					 	'default'     => '',
				 	 ),
					 'svg' => array(
					 	'type'        => 'upload',
					 	'label'       => esc_attr__( '.SVG File', 'onetone' ),
						'description' => '',
					 	'default'     => '',
				 	 ),
				  
				 
				 
			  ),
			  );
  
 $options[] = array(
		'slug'		=> 'onetone_fonts',
		'label'		=> __( 'Fonts', 'onetone' ),
		'panel' 	=> 'onetone_styling',
		'priority'	=> 6,
		'type' 		=> 'section'
		);
 
 $body_font        = onetone_option_saved('standard_body_font');
 $google_body_font = onetone_option_saved('body_font');
 $default_font     = 'Open Sans, sans-serif';
 
 if ( $google_body_font!= '' )
 	$body_font = $google_body_font;
 if( $body_font == '' )
 	$body_font = $default_font;
 
 $options[] =  array(
		  'slug'         => 'site_body_font',
		  'label'        => __( 'Select Body Font Family', 'onetone' ),
		  'description'  => '',
		  'default'      => array(
									'font-family'    => $body_font,
									'variant'        => '',
								),
		  'type'        => 'typography',
		  'section'     => 'onetone_fonts',
		  'output'      => array(
							  array(
								  'element' => 'body',
							  ),
						  ),
        );
  
 $menu_font        = onetone_option_saved('standard_menu_font');
 $google_menu_font = onetone_option_saved('menu_font');
 
 if ( $google_menu_font!= '' )
 	$menu_font = $google_menu_font;
 if( $menu_font == '' )
 	$menu_font = $default_font;
	
  $options[] =  array(
		  'slug'        => 'site_menu_font',
		 'label'        => __( 'Select Menu Font Family', 'onetone' ),
		  'description' => '',
		  'default'     => array(
								'font-family'    => $menu_font,
							),
		  'type'        => 'typography',
		  'section'     => 'onetone_fonts',
		  'output'      => array(
							array(
									'element' => '#menu-main li a span',
							),
						),
        );
		
 $headings_font        = onetone_option_saved('standard_headings_font');
 $google_headings_font = onetone_option_saved('headings_font');
 
 if ( $google_headings_font != '' )
 	$headings_font = $google_headings_font;
 if( $headings_font == '' )
 	$headings_font = $default_font;
	
  $options[] =  array(
		  'slug'        => 'site_headings_font',
		  'label'       => __( 'Select Headings Font Family', 'onetone' ),
		  'description' => '',
		  'default'     => array(
								'font-family' => $headings_font,									  
								),
		  'type'        => 'typography',
		  'section'     => 'onetone_fonts',
		  'output'      => array(
							array(
								'element' => 'h1,h2,h3,h4,h5,h6',
							),
						),
        );
  
 $footer_headings_font        = onetone_option_saved('standard_footer_headings_font');
 $google_footer_headings_font = onetone_option_saved('footer_headings_font');
 
 if ( $google_footer_headings_font!= '' )
 	$footer_headings_font = $google_footer_headings_font;
 if( $footer_headings_font == '' )
 	$footer_headings_font = $default_font;
	
  $options[] =  array(
		  'slug'        => 'site_footer_headings_font',
		 'label'        => __( 'Select Footer Headings Font Family', 'onetone' ),
		  'description' => '',
		  'default'     => array(
								'font-family' => $footer_headings_font,
							),
		  'type'        => 'typography',
		  'section'     => 'onetone_fonts',
		  'output'      => array(
							array(
								'element' => 'footer h1,footer h2,footer h3,footer h4,footer h5,footer h6',
							),
						),
        );
  
 $button_font        = onetone_option_saved('standard_button_font');
 $google_button_font = onetone_option_saved('button_font');
 
 if ( $google_button_font!= '' )
 	$button_font = $google_button_font;
 if( $button_font == '' )
 	$button_font = 'Open Sans, sans-serif';
	
  $options[] =  array(
		  'slug'         => 'site_button_font',
		 'label'         => __( 'Select Buttons Font Family', 'onetone' ),
		  'description'  => '',
		  'default'      => array(
									  'font-family' => $button_font,
									  
									  ),
		  'type'        => 'typography',
		  'section'     => 'onetone_fonts',
		  'output'      => array(
							array(
								'element' => 'a.btn-normal',
							),
						),
        );
  
  $options[] = array(
		'slug'		=> 'onetone_load_google_fonts',
		'label'		=> __( 'Load Google Fonts', 'onetone' ),
		'panel' 	=> 'onetone_styling',
		'priority'	=> 8,
		'type' 		=> 'section'
		);
  
  $options[] =  array(
		  'slug'        => 'google_fonts',
		 'label'        => __( 'Load Google Fonts', 'onetone' ),
		  'description' => __( 'For Example: Open+Sans:300,400,700|Yanone+Kaffeesatz', 'onetone' ),
		  'default'     => 'Open+Sans:300,400,700|Yanone+Kaffeesatz',
		  'type'        => 'text',
		  'section'     => 'onetone_load_google_fonts',
);
	  
	 // Options Export & Import
	$options[] = array(
		'slug'		=> 'onetone_export_import',
		'label'		=> __( 'Onetone: Export & Import', 'onetone' ),
		'priority'	=> 9,
		'type' 		=> 'panel'
	);
	// Export
	$options[] = array(
		'slug'		=> 'onetone_options_export',
		'label'		=> __( 'Options Export', 'onetone' ),
		'panel' 	=> 'onetone_export_import',
		'priority'	=> 7,
		'type' 		=> 'section'
		);
	
	$options[] =  array(
		'slug'        => 'options_export',
		'label'       => __( 'Options Export', 'onetone' ),
		'description' => 'Copy & paste this character string into notepad and save it. Once you need to import the configuration, go to Onetone: Export & Import > Options Import, paste this string into the textarea and import.',
		'default'     => '<textarea id="onetone_options_export" rows="10" readonly="readonly" style="width:100%;"></textarea>',
		'type'        => 'custom',
		'section'     => 'onetone_options_export',
	);
	
	// Import
	$options[] = array(
		'slug'		=> 'onetone_options_import',
		'label'		=> __( 'Options Import', 'onetone' ),
		'panel' 	=> 'onetone_export_import',
		'priority'	=> 7,
		'type' 		=> 'section'
		);
	
	$options[] =  array(
		'slug'        => 'options_import',
		'label'       => __( 'Options Import', 'onetone' ),
		'description' => '',
		'default'     => '<textarea id="onetone_options_import" rows="10" style="width:100%;"></textarea><a class="button options-import button-primary">'.__( 'Import', 'onetone' ).'</a><p style="margin-top:10px; color:red;" class="options-import-result"></p>',
		'type'        => 'custom',
		'section'     => 'onetone_options_import',
	);
	
	$options = apply_filters( 'onetone_theme_options', $options );
	 $new_options = array();
	foreach($options as $option){
		if(isset($option['id']))
			$option['settings'] = $option['id'];
		if(isset($option['slug']) && !isset($option['id'])){
			$option['id'] = $option['slug'];
			$option['settings'] = $option['slug'];
		}
		$new_options[$option['settings']] = $option;
		}
	return $new_options;
}

// get default options
function onetone_get_default_options(){
	global $onetone_options_default;
	$options = $onetone_options_default;
	
	$output  = array();
	foreach ( (array) $options as $option ) {
		if ( ! isset( $option['slug'] ) ) {
			continue;
		}
		if ( ! isset( $option['default'] ) ) {
			continue;
		}
		if ( ! isset( $option['type'] ) ) {
			continue;
		}
			$output[$option['slug']] = $option['default'];
	}
	
	return 	$output;
	
}

// get num string
function onetone_CountTail($number)  
  {  
	 $nstring = (string) $number;  
	 $pointer = strlen($nstring) - 1;  
	 $digit   = $nstring[$pointer];  
	 $suffix  = "th";  
	
	 if ($pointer == 0 ||  
		($pointer > 0 && $nstring[$pointer - 1] != 1))  
	 {  
		switch ($nstring[$pointer])  
		{  
		   case 1: $suffix = "st"; break;  
		   case 2: $suffix = "nd"; break;  
		   case 3: $suffix = "rd"; break;  
		}  
	 }  
	   
	 return $number . $suffix;  
  }  
  
/**
 * Selective Refresh
 */
function onetone_register_blogname_partials( WP_Customize_Manager $wp_customize ) {
	global $onetone_options_default;
	$theme_options = $onetone_options_default;
	$option_name   = onetone_option_name();
	if (is_array($theme_options) && !empty($theme_options) ){
    	foreach( $theme_options as $option ){
			if(isset($option['type']) && ($option['type'] == 'text' || $option['type'] == 'textarea' || $option['type'] == 'editor' || $option['type'] == 'image' || $option['type'] == 'repeater' ) ){

					$wp_customize->selective_refresh->add_partial( $option['slug'].'_selective', array(
						'selector' => '.'.$option['slug'],
						'settings' => array( $option_name.'['.$option['slug'].']' ),
						'fallback_refresh' => false,
						/*'render_callback' => function() {
							return false;
							},*/
						) );
			}
		}
	}
	
	$wp_customize->selective_refresh->add_partial( 'onetone[section_service_2]', array(
    'selector' => '.section_service_2',
    'settings' => array( 'icon',
                         'image',
                         'title',
                         'link',
                         'target',
                         'description',
                         ),
    'render_callback' => '',
    'fallback_refresh' => false
) );
	
	$wp_customize->selective_refresh->add_partial( 'header_site_title', array(
		'selector' => '.site-name',
		'settings' => array( 'blogname' ),
	) );
	
	$wp_customize->selective_refresh->add_partial( 'header_site_description', array(
		'selector' => '.site-tagline',
		'settings' => array( 'blogdescription' ),
	) );
	
}
add_action( 'customize_register', 'onetone_register_blogname_partials' );

/**
 * Admin page
 *
 */
add_action('admin_menu', 'onetone_about_theme');

function onetone_about_theme() {
    add_theme_page(
        esc_attr__('About OneTone', 'onetone' ),
        esc_attr__('About OneTone', 'onetone' ),
        'manage_options',
        'onetone-welcome',
        'onetone_about_theme_callback' );
}
 
function onetone_about_theme_callback() {
	
	$theme_info = wp_get_theme();
	
    echo '<div class="wrap"><div id="icon-tools" class="icon32"></div>';
        echo '<h2>'.esc_attr__('About OneTone', 'onetone' ).'</h2>';
	
	echo '<div class="onetone-info-wrap">
	<h1>'.sprintf(esc_attr__('Welcome to %1$s Version %2$s', 'onetone'),$theme_info->get( 'Name' ), $theme_info->get( 'Version' ) ).'</h1>
	<p>'.$theme_info->get( 'Name' ).' is a super responsive one-page WordPress theme developed on the powerful Bootstrap framework along with the flexible HTML5 and CSS3. Coming with a modern, clean, and professional layout, this theme is exclusively crafted for the needs of modern business and creative startups with the maximum customization in the simplest way. Most noteworthy, OneTone seamlessly supports page builder Elementor which lets you custom everything without touching a line of code really. Therefore, you can custom or rebuild every section such as Services, About, Gallery, Clients, and options like backgrounds with video or parallax scrolling, Font Awesome Icons, custom CSS. Thanks to its awesome OneTone Companion, you can install all templates with just one click. Beyond that, OneTone is an SEO optimized and retina ready theme that compatible with massive premium plugins such as bbPress, Polylang, and Contact Form 7. Further, it offers a perfect WooCommerce compatibility. You can build all sort of online stores to establish the reputation of professionalism and reliability for your brand.</p>';
	
	if ( file_exists( WP_PLUGIN_DIR . '/onetone-companion/onetone-companion.php' ) && is_plugin_inactive( 'onetone-companion/onetone-companion.php' ) ) {
							
							echo '<h3>'.esc_html__( 'Activate Plugin', 'onetone' ).'</h3>
							<p>'.sprintf(esc_html__( 'Activate plugin %s to import page templates.', 'onetone' ), '<strong>OneTone Companion</strong>').'</p>';

							$class       = 'button button-primary onetone-companion-inactive';
							$button_text = esc_html__( 'Activate Required Plugin', 'onetone' );
							$data_slug   = 'onetone-companion';
							$data_init   = '/onetone-companion/onetone-companion.php';

						} elseif ( ! file_exists( WP_PLUGIN_DIR . '/onetone-companion/onetone-companion.php' ) ) {
							echo '<h3>'.esc_html__( 'Install Plugin', 'onetone' ).'</h3>
							<p>'.sprintf(esc_html__( 'Install plugin %s to import page templates.', 'onetone' ), '<strong>OneTone Companion</strong>').'</p>';
							
							$class       = 'button button-primary onetone-companion-notinstalled';
							$button_text = esc_html__( 'Install Required Plugin', 'onetone' );
							$data_slug   = 'onetone-companion';
							$data_init   = '/onetone-companion/onetone-companion.php';

						}  else {
							$class       = 'active';
							$button_text = '';
							$link        = '';
							echo '<div class="onetone-message blue">
	'.esc_attr__('Go to OneTone Companion to import page templates.', 'onetone' ).'
	<p><a class="button" href="'.esc_url(admin_url('admin.php?page=onetone-companion')).'"> '.esc_attr__('OneTone Companion', 'onetone' ).' </a></p>
	</div>';
							 do_action( 'onetone_admin_page_button' );
						}

						printf(
							'<a class="%1$s" %2$s %3$s %4$s> %5$s </a>',
							esc_attr( $class ),
							isset( $link ) ? 'href="' . esc_url( $link ) . '"' : '',
							isset( $data_slug ) ? 'data-slug="' . esc_attr( $data_slug ) . '"' : '',
							isset( $data_init ) ? 'data-init="' . esc_attr( $data_init ) . '"' : '',
							esc_html( $button_text )
						);
	
	echo '
	<div class="onetone-message blue">
	'.esc_attr__('You can just go to OneTone Companion to customize everything in your site.', 'onetone' ).'
	<p><a class="button" href="'.esc_url(admin_url('customize.php')).'"> '.esc_attr__('Customize', 'onetone' ).' </a></p>
	</div>
	
	<div class="onetone-message">
	'.esc_attr__('More info could be found at the manual.', 'onetone' ).'
	<p><a class="button" target="_blank" href="'.esc_url('https://mageewp.com/manuals/theme-guide-onetone.html').'"> '.esc_attr__('Step-by-step Manual', 'onetone' ).' </a></p>
	</div>
	
	<div class="onetone-message">
	'.esc_attr__('How to Create One Page Business Site Using OneTone Theme?', 'onetone' ).'
	<p><a class="button" target="_blank" href="'.esc_url('https://www.youtube.com/watch?v=GkyguwNTGHI').'"> '.esc_attr__('Video Manual', 'onetone' ).' </a></p>
	</div>
	
	<div class="onetone-message green">
	'.esc_attr__('If you have checked the documentation and still having an issue, please post in the support thread.', 'onetone' ).'
	<p><a class="button" target="_blank" href="'.esc_url('https://mageewp.com/forums/onetone/').'"> '.esc_attr__('Support Thread', 'onetone' ).' </a></p>
	</div>
	
	<div class="onetone-message blue">
	<h2>'.esc_attr__('Review OneTone on WordPress', 'onetone').'</h2>
	
	<p>We are grateful that you have chose our theme. If you like OneTone, please take 1 minitue to post your review on Wordpress. Few words of appreciation also motivates the development team.</p>
	<p><a class="button" target="_blank" href="'.esc_url('https://wordpress.org/support/theme/onetone/reviews/#new-post').'"> '.esc_attr__('Post Your Review', 'onetone' ).' </a></p>
	</div>
	
	
	</div>';
		
    echo '</div>';
	
}


/*
*  options export
*
*/
function onetone_options_export(){
  global $onetone_options_db,$onetone_options_default;
  
  $onetone_backup_options = (array)$onetone_options_db;
  foreach( $onetone_options_default as $key => $value ){
	  
	  if( isset($value['type']) && $value['type'] == 'repeater'){
		  
			if ( isset($value['fields']) && is_array($value['fields']) ){
				foreach ($value['fields'] as $k => $v ){
					if ( isset($v['type']) && $v['type']=='image' && isset($onetone_backup_options[$key]) ){
						foreach ($onetone_backup_options[$key] as $index => $backup_option){
							
							if ( isset($backup_option[$k]) && is_numeric($backup_option[$k]) ){
	
								$image_attributes = wp_get_attachment_image_src( $backup_option[$k],'full' );
								if ( $image_attributes ) : 
									$onetone_backup_options[$key][$index][$k] = $image_attributes[0];
								 endif; 
								}
							
							}
						}
					}
				}
		  
		}else{
		  if ( isset($value['type']) && $value['type'] == 'image' ){
				if ( isset($onetone_options_db[$key]) && is_numeric($onetone_options_db[$key]) ){
					
					$image_attributes = wp_get_attachment_image_src( $onetone_options_db[$key] );
					if ( $image_attributes ) : 
						 $onetone_backup_options[$key] = $image_attributes[0];
					endif; 
					
					}
			  }
	  }
    }
  echo json_encode($onetone_backup_options);
  exit(0);
}
add_action('wp_ajax_onetone_options_export', 'onetone_options_export');
add_action('wp_ajax_nopriv_onetone_options_export', 'onetone_options_export');

/*
*  options import
*
*/
function onetone_options_import(){
	$option_name = onetone_option_name();
	if(isset($_POST['options'])){
		$options = stripslashes($_POST['options']);
		$new_options = json_decode($options, true);
		
		if(is_array($new_options) && $new_options != NULL ){

			update_option($option_name,$new_options);
			_e( 'Import successful.', 'onetone');
			exit(0);
			}
		}
	_e( 'Import failed.', 'onetone');
	exit(0);
}
add_action('wp_ajax_onetone_options_import', 'onetone_options_import');
add_action('wp_ajax_nopriv_onetone_options_import', 'onetone_options_import');

/*
*  restore default
*
*/

function onetone_otpions_restore(){
  global $onetone_options_default;
  $option_name = onetone_option_name();
  add_option($option_name.'_backup_'.time(),get_option($option_name));
  delete_option($option_name);	
  echo 'done';
  exit(0);
}
add_action( 'wp_ajax_onetone_otpions_restore', 'onetone_otpions_restore' );
add_action( 'wp_ajax_nopriv_onetone_otpions_restore', 'onetone_otpions_restore' );

/*
*  Setup front page
*
*/
function onetone_create_frontpage(){
	
  $homepage_title = 'Onetone Front Page';
  // Set reading options
  $homepage   = get_page_by_title( $homepage_title );
  
  if( !isset($homepage->ID) || (isset($homepage->post_status) && $homepage->post_status 
  != 'publish' ) ){
	  
	  $post_data = array(
			'post_title' => $homepage_title,
			'post_content' => '',
			'post_status'   => 'publish',
			'post_type' => 'page',
		);  
	  $homepage_id = wp_insert_post( $post_data );
	  
  }else{
	  
	  $homepage_id = $homepage->ID;
	  }
  
  if( $homepage_id ) {
	  update_option('show_on_front', 'page');
	  update_option('page_on_front', $homepage_id); // Front Page
	  update_post_meta( $homepage_id, '_wp_page_template', 'template-home.php' );
  }
			
  echo 'done';
  exit(0);
  
	}
add_action( 'wp_ajax_onetone_create_frontpage', 'onetone_create_frontpage' );
add_action( 'wp_ajax_nopriv_onetone_create_frontpage', 'onetone_create_frontpage' );

function onetone_control_types( $control_types ) {
	$control_types['onetone-editor'] = 'Onetone_Customize_Editor_Control';
    return $control_types;
}
add_filter( 'kirki/control_types', 'onetone_control_types', 20 );


/**
 * Allow Custom Font Upload
 **/
 add_filter('upload_mimes', 'onetone_add_custom_upload_mimes');
 function onetone_add_custom_upload_mimes($existing_mimes) {
  	$existing_mimes['otf'] = 'application/x-font-otf';
  	$existing_mimes['woff'] = 'application/octet-stream';
  	$existing_mimes['ttf'] = 'application/x-font-ttf';
  	$existing_mimes['svg'] = 'image/svg+xml';
  	$existing_mimes['eot'] = 'application/vnd.ms-fontobject';
  	return $existing_mimes;
  }
  
 /**
 * Returns breadcrumbs.
 */
function onetone_breadcrumbs( $delimiter = '/',$prefix = '<i class="fa fa-home"></i>' ) {
	global $onetone_page_meta;
	$display_breadcrumb = 1;

    $display_breadcrumb = (isset($onetone_page_meta['display_breadcrumb'] ) && $onetone_page_meta['display_breadcrumb'] !='') ?$onetone_page_meta['display_breadcrumb']:$display_breadcrumb;
	if( $display_breadcrumb != 'yes' &&  $display_breadcrumb != '1' ){
		return '';
	}
	$delimiter = esc_attr($delimiter);
	$prefix = wp_kses_post($prefix);
	
	$before = '<span class="current">';
	$after = '</span>';
	if ( !is_home() && !is_front_page() || is_paged() ) {
		echo '<div class="breadcrumb-nav breadcrumbs" itemprop="breadcrumb">';
		echo '<div itemscope itemtype="http://schema.org/WebPage" id="crumbs">'.$prefix;
		global $post;
		$homeLink = esc_url(home_url());
		echo ' <a itemprop="breadcrumb" href="' . $homeLink . '">' . __( 'Home' , 'onetone' ) . '</a> ' . $delimiter . ' ';
		if ( is_category() ) {
			global $wp_query;
			$cat_obj = $wp_query->get_queried_object();
			$thisCat = $cat_obj->term_id;
			$thisCat = get_category($thisCat);
			$parentCat = get_category($thisCat->parent);
			if ($thisCat->parent != 0){
				$cat_code = get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' ');
				echo $cat_code = str_replace ('<a','<a itemprop="breadcrumb"', $cat_code );
			}
			echo $before . '' . single_cat_title('', false) . '' . $after;
		} elseif ( is_day() ) {
			echo '<a itemprop="breadcrumb" href="' . esc_url(get_year_link(get_the_time('Y'))) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
			echo '<a itemprop="breadcrumb"  href="' . esc_url(get_month_link(get_the_time('Y'),get_the_time('m'))) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
			echo $before . get_the_time('d') . $after;
		} elseif ( is_month() ) {
			echo '<a itemprop="breadcrumb" href="' . esc_url(get_year_link(get_the_time('Y'))) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
			echo $before . get_the_time('F') . $after;
		} elseif ( is_year() ) {
			echo $before . get_the_time('Y') . $after;
		} elseif ( is_single() && !is_attachment() ) {
			if ( get_post_type() != 'post' ) {
				$post_type = get_post_type_object(get_post_type());
				$slug = $post_type->rewrite;
				echo '<a itemprop="breadcrumb" href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a> ' . $delimiter . ' ';
				echo $before . get_the_title() . $after;
			} else {
				$cat = get_the_category(); $cat = $cat[0];
				$cat_code = get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
				echo $cat_code = str_replace ('<a','<a itemprop="breadcrumb"', $cat_code );
				echo $before . get_the_title() . $after;
			}
		} elseif ( !is_single() && !is_page() && get_post_type() != 'post' ) {
			$post_type = get_post_type_object(get_post_type());
			if ($post_type)
			echo $before . $post_type->labels->singular_name . $after;
		} elseif ( is_attachment() ) {
			$parent = get_post($post->post_parent);
			$cat = get_the_category($parent->ID); $cat = isset($cat[0])?$cat[0]:'';
			echo '<a itemprop="breadcrumb" href="' . esc_url(get_permalink($parent)) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
			echo $before . get_the_title() . $after;
		} elseif ( is_page() && !$post->post_parent ) {
			echo $before . get_the_title() . $after;
		} elseif ( is_page() && $post->post_parent ) {
			$parent_id  = $post->post_parent;
			$breadcrumbs = array();
			while ($parent_id) {
				$page = get_page($parent_id);
				$breadcrumbs[] = '<a itemprop="breadcrumb" href="' .esc_url( get_permalink($page->ID)) . '">' . get_the_title($page->ID) . '</a>';
				$parent_id  = $page->post_parent;
			}
			$breadcrumbs = array_reverse($breadcrumbs);
			foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
			echo $before . get_the_title() . $after;
		} elseif ( is_search() ) {
			echo $before ;
			printf( __( 'Search Results for: %s', 'onetone' ),  get_search_query() );
			echo  $after;
		} elseif ( is_tag() ) {
			echo $before ;
			printf( __( 'Tag Archives: %s', 'onetone' ), single_tag_title( '', false ) );
			echo  $after;
		} elseif ( is_author() ) {
			global $author;
			$userdata = get_userdata($author);
			echo $before ;
			printf( __( 'Author Archives: %s', 'onetone' ),  $userdata->display_name );
			echo  $after;
		} elseif ( is_404() ) {
			echo $before;
			_e( 'Not Found', 'onetone' );
			echo  $after;
		}
		if ( get_query_var('paged') ) {
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() )
				echo sprintf( __( '( Page %s )', 'onetone' ), absint(get_query_var('paged')) );
		}
		echo '</div>';
		echo '</div>';
	}
}

/**
 * Returns an array of system fonts
 */
 
function onetone_options_typography_get_os_fonts() {
    // OS Font Defaults
	$os_faces = array(
		'Arial, sans-serif' => __('Arial','onetone' ),
		'Cambria, Georgia, serif' => __('Cambria','onetone' ),
		'Calibri,sans-serif' => __('Calibri','onetone' ),
		'Copse, sans-serif' => __('Copse','onetone' ),
		'Garamond, "Hoefler Text", Times New Roman, Times, serif' => __('Garamond','onetone' ),
		'Georgia, serif' => __('Georgia','onetone' ),
		'"Helvetica Neue", Helvetica, sans-serif' => __('Helvetica Neue','onetone' ),
		'Tahoma, Geneva, sans-serif' => __('Tahoma','onetone' ),
		'Lustria,serif' => __('Lustria','onetone' ),
	);
	return $os_faces;
}

/* Get default sidebar*/

function onetone_get_default_sidebar(){
	?>
	<div id="search-form-2" class="widget widget-box widget_search">
<?php get_search_form(); ?>
</div>
<div id="recent-posts-2" class="widget widget-box widget_onetone_recent_posts">
<h2 class="widget-title">
          <?php _e( 'Recent Posts','onetone' ); ?>
        </h2>
         
<?php $onetonequery = new WP_Query( 'posts_per_page=6' ); ?>
<ul>
 
<?php while($onetonequery->have_posts()) : $onetonequery->the_post(); ?>
 
 <li>
    <?php 
   if ( has_post_thumbnail() ) {
         $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
		 $source = get_site_url();
		 if($featured_image[0] !=""){
			$thumb = $featured_image[0]; 
			echo '<a href="'.esc_url(get_permalink()).'" class="widget-img"><img src="'.esc_url($thumb).'" alt="'.esc_attr(get_the_title()).'" /></a>';
			 }
		} 
			?>
    <a class="widget-post-title" href="<?php the_permalink();?>">
    <?php the_title();?>
    </a><br>
    <?php echo get_the_date();?>
    </li>
    
<?php endwhile;
    wp_reset_postdata();
?>
        </ul>

		<span class="seperator extralight-border"></span>
        
        </div>
        
  <div id="recent-comments-2" class="widget widget-box widget_comments">
<h2 class="widget-title">
          <?php _e( 'Recent Comments','onetone' ); ?>
        </h2>   
      <ul class="list-unstyled rs-recent-comments">
	<?php
		$comment_args = array(
			'status' => 'approve',
			'number' => 6,
		);

		// The Query
		$comments_query = new WP_Comment_Query;
		$comments 		= $comments_query->query( $comment_args );

		// Comment Loop
		if ( $comments ) {
			foreach ( $comments as $comment ) {

				?>
					<li class="ml-0">
						<div class="list-right">
								<a href="<?php echo esc_url( $comment->comment_author_url ); ?>">
									<?php echo $comment->comment_author; ?>
								</a>
								<span>on</span>
								
								<a href="<?php echo esc_url( get_permalink( $comment->comment_post_ID ) ); ?>">
									<?php echo $comment->post_name; ?>
								</a>
	
						</div>
					
					</li>
				<?php
			}
		} else {

			_e( '<p>No comments added yet.</p>', 'onetone' );

		}
	?>
</ul>
		<span class="seperator extralight-border"></span>
 </div>

<div id="archives-2" class="widget widget-box widget_archives">
<h2 class="widget-title">
          <?php _e('Archives','onetone' ); ?>
        </h2>
        <ul>
         <?php wp_get_archives('type=monthly'); ?>
        </ul>

		<span class="seperator extralight-border"></span>
        
        </div>
   <div id="meta-2" class="widget widget-box widget_meta">
<h2 class="widget-title">
          <?php _e('Meta','onetone' ); ?>
        </h2>
        <ul>
          <?php wp_register(); ?>
          <li>
            <?php wp_loginout(); ?>
          </li>
          <?php wp_meta(); ?>
        </ul>

		<span class="seperator extralight-border"></span>
        
        </div>
<?php	
	}
	
	/**
		 * Required Plugin Activate
		 */
		 function required_plugin_activate() {

			if ( ! current_user_can( 'install_plugins' ) || ! isset( $_POST['init'] ) || ! $_POST['init'] ) {
				wp_send_json_error(
					array(
						'success' => false,
						'message' => __( 'No plugin specified', 'onetone' ),
					)
				);
			}

			$plugin_init = ( isset( $_POST['init'] ) ) ? esc_attr( $_POST['init'] ) : '';

			$activate = activate_plugin( $plugin_init, '', false, true );

			if ( is_wp_error( $activate ) ) {
				wp_send_json_error(
					array(
						'success' => false,
						'message' => $activate->get_error_message(),
					)
				);
			}

			wp_send_json_success(
				array(
					'success' => true,
					'message' => __( 'Plugin Successfully Activated', 'onetone' ),
				)
			);

		}
	add_action( 'wp_ajax_onetone-companion-plugin-activate', 'required_plugin_activate' );