<?php
 $display_footer_widgets    = onetone_option('enable_footer_widget_area'); 
 $footer_columns            = onetone_option('footer_columns','4'); 
 $copyright_text            = onetone_option('copyright',''); 
 $display_copyright_bar     = onetone_option('display_copyright_bar','yes'); 
 
?>
<!--Footer-->

<footer>
  <?php if( $display_footer_widgets == '1' ):?>
  <div class="footer-widget-area">
    <div class="container">
      <div class="row">
        <?php 
			for( $i=1;$i<=$footer_columns; $i++ ){
		?>
        <div class="col-md-<?php echo 12/$footer_columns; ?>">
          <?php
				if(is_active_sidebar("footer_widget_".$i)){
	               dynamic_sidebar("footer_widget_".$i);
                 }
			?>
        </div>
        <?php }?>
      </div>
    </div>
  </div>
  <?php endif; ?>
  <?php if( $display_copyright_bar == 'yes' ||  $display_copyright_bar == '1' ):?>
  <div class="footer-info-area" role="contentinfo">
    <div class="container">
      <div class="site-info pull-left"> <?php echo do_shortcode($copyright_text); ?> &nbsp;&nbsp; &nbsp;&nbsp;
        
        <?php
                      if( is_home() || is_front_page()){
                        printf(__('Designed by <a href="%s">MageeWP Themes</a>.','onetone'),esc_url('https://www.mageewp.com/'));
                      }else{
						 printf(__('Designed by MageeWP Themes.','onetone')); 
						  }
		 ?>
</div>
      <div class="site-social pull-right">
        <?php echo onetone_get_social( 'footer_social_icons', 'top'); ?>
      </div>
    </div>
  </div>
  <?php endif; ?>
</footer>
</div>
<?php wp_footer();?>
</body></html>