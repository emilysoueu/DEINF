<?php
 global $onetone_section_part;
 $video_background_section  = onetone_option( 'video_background_section' );
 $i                         = $video_background_section-1 ;
 $video_controls            = onetone_option( 'video_controls' );
 $section_background_video  = onetone_option( 'section_background_video_0' );
 $youtube_bg_type           = onetone_option("youtube_bg_type");
 $youtube_bg_type           = is_numeric($youtube_bg_type)?$youtube_bg_type:"1";
 $display_video_mobile      = onetone_option("display_video_mobile","no");
 $start_play                = onetone_option("section_youtube_start",0);
 $stop_play                 = onetone_option("section_youtube_stop",0);

 $youtube_autoplay          = onetone_option("youtube_autoplay");
 $youtube_loop              = onetone_option("youtube_loop");
 $youtube_mute              = onetone_option("youtube_mute");
 $youtube_anchor            = onetone_option("youtube_anchor");
 $youtube_quality           = onetone_option("youtube_quality");
 $youtube_opacity           = onetone_option("youtube_opacity");
 $full_width                = onetone_option( 'full_width_'.$i );
 
 $container_class = "container";
 if( $full_width == "yes" ){
	 $container_class = "";
 }
 
 if( $youtube_autoplay == '1' )
   $youtube_autoplay = 'true';
 else
   $youtube_autoplay = 'false';
 
 if( $youtube_loop == '1' )
   $youtube_loop = 'true';
 else
   $youtube_loop = 'false';
 
 if( $youtube_mute == '1' )
   $youtube_mute = 'true';
 else
   $youtube_mute = 'false';
  
  $containment = '.onetone-youtube-section';
  
  if( $youtube_bg_type == '1')
    $containment = 'body';
	
?>
<section class="section home-section-<?php echo $i;?>  fullheight verticalmiddle onetone-youtube-section video-section">
<div id="onetone-youtube-video" class="onetone-player" data-property="{videoURL: '<?php echo esc_attr($section_background_video);?>', containment: '<?php echo $containment;?>', showControls: false, autoPlay: <?php echo $youtube_autoplay;?>, loop: <?php echo $youtube_loop;?>, mute: <?php echo $youtube_mute;?>, startAt: <?php echo absint($start_play);?>, stopAt: <?php echo absint($stop_play);?>, opacity: <?php echo esc_attr($youtube_opacity);?>, addRaster: true, anchor: '<?php echo esc_attr($youtube_anchor);?>', quality: '<?php echo esc_attr($youtube_quality);?>', fadeOnStartTime: 1}"></div>
<div class="section-content">
<div class="home-container <?php echo esc_attr($container_class);?> page_container">
<?php get_template_part('home-sections/section',intval($onetone_section_part));?>
    
  <div class="clear"></div>
 </div>
 </div>
   <?php 
		 
	  if( $youtube_autoplay == 'true' )
		$play_btn_icon = 'pause';
	  else
		$play_btn_icon = 'play';
	  
	  if( $youtube_mute == 'true' )
		$mute_btn_icon = 'volume-off';
	  else
		$mute_btn_icon = 'volume-up';
			  
	  echo '<script>
	  function changeLabel(state){
		    if( state == 1 )
			 jQuery("#togglePlay i").removeClass("fa-play").addClass("fa-pause");
			else
			jQuery("#togglePlay i").removeClass("fa-pause").addClass("fa-play");
            
        }
		
		function toggleVolume(){
			var volume =jQuery(\'#onetone-youtube-video\').YTPToggleVolume();
			if( volume == true )
			jQuery(".youtube-volume i").removeClass("fa-volume-off").addClass("fa-volume-up");
			else
			jQuery(".youtube-volume i").removeClass("fa-volume-up").addClass("fa-volume-off");
			
		}
		
		</script>';
		
	if(  $video_controls == 1  ){
		echo '<p class="black-65" id="video-controls">
		  <a class="youtube-pause command" id="togglePlay" href="javascript:;" onclick="jQuery(\'#onetone-youtube-video\').YTPTogglePlay(changeLabel)"><i class="fa fa-'.$play_btn_icon.'"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
		  <a class="youtube-volume" href="javascript:;" onclick="toggleVolume();"><i class="fa fa-'.$mute_btn_icon.' "></i></a>
	  </p>';
	 }
  
	 ?>
</section>