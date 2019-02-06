<?php
global $onetone_animated, $onetone_section_id;
 $i                   = $onetone_section_id ;
 $section_title       = onetone_option( 'section_title_'.$i );
 $section_menu        = onetone_option( 'menu_title_'.$i );
 $section_content     = onetone_option( 'section_content_'.$i ); 
 $content_model       = onetone_option( 'section_content_model_'.$i);
 $section_subtitle    = onetone_option( 'section_subtitle_'.$i );
 $btn_text            = onetone_option( 'section_btn_text_'.$i );
 $email               = onetone_option( 'section_email_'.$i );
 $checkbox            = onetone_option( 'section_checkbox_'.$i );
 $checkbox_description = onetone_option( 'section_checkbox_description_'.$i );
 $checkbox_prompt     = onetone_option( 'section_checkbox_prompt_'.$i );
 
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
         <div class="contact-area <?php echo 'section_btn_text_'.$i;?>">
		  <?php 
		  $notice = sprintf( __("Please install the latest version of the <a href='https://wordpress.org/plugins/onetone-companion/' target='_blank'><strong>%s</strong></a> plugin.", 'onetone'),'Oneone Companion');
		  
		  if ( function_exists('is_plugin_active') && file_exists( ABSPATH . 'wp-content/plugins/magee-shortcodes-pro/Magee.php' ) && is_plugin_active('magee-shortcodes-pro/Magee.php') ) {?>
                 <?php echo do_shortcode('[ms_contact receiver="'.esc_attr($email).'" button_text="'.esc_attr($btn_text).'" style="normal" color=""  terms="no" class=""][/ms_contact]');?>
          <?php }elseif( function_exists('is_plugin_active') && file_exists( ABSPATH . 'wp-content/plugins/onetone-companion/onetone-companion.php' ) && is_plugin_active('onetone-companion/onetone-companion.php') ){?>
          		<?php 
				$plugin_data  = get_plugin_data( WP_PLUGIN_DIR.'/onetone-companion/onetone-companion.php', false, false );
				if (version_compare($plugin_data['Version'], '1.0.3' , '>=') ) {
				?>
           		<?php echo do_shortcode('[oc_contact checkbox="'.absint($checkbox).'" checkbox_prompt="'.wp_kses_post($checkbox_prompt).'" receiver="'.sanitize_email($email).'" button_text="'.esc_attr($btn_text).'" ]'.wp_kses_post($checkbox_description).'[/oc_contact]');?>
                <?php }else{
			  if( current_user_can('editor')) {
			  ?>
          		<?php echo $notice;?>
           <?php }
		   }?>
          <?php }else{
			  if( current_user_can('editor')) {
			  ?>
          		<?php echo $notice;?>
           <?php }
		   }?>
            </div>
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