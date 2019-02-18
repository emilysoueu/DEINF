<?php

class Athemes_Video extends WP_Widget {

    public function __construct() {
		$widget_ops = array('classname' => 'athemes_video_widget', 'description' => __( 'Display a video from Youtube, Vimeo etc.', 'talon') );
        parent::__construct(false, $name = __('Talon: Video', 'talon'), $widget_ops);
		$this->alt_option_name = 'athemes_video_widget';	
    }
	
	public function form($instance) {
		$title     	= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$url    	= isset( $instance['url'] ) ? esc_url( $instance['url'] ) : '';
		$width    	= isset( $instance['width'] ) ? absint( $instance['width'] ) : '800';

	?>

	<p>
	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'talon'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
	</p>

	<p><label for="<?php echo $this->get_field_id( 'url' ); ?>"><?php _e( 'Paste the URL of the video (only from a network that supports oEmbed, like Youtube, Vimeo etc.):', 'talon' ); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'url' ); ?>" name="<?php echo $this->get_field_name( 'url' ); ?>" type="text" value="<?php echo $url; ?>" size="3" /></p>

	<p><label for="<?php echo $this->get_field_id( 'width' ); ?>"><?php _e( 'Max. width for the video [px]', 'talon' ); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'width' ); ?>" name="<?php echo $this->get_field_name( 'width' ); ?>" type="text" value="<?php echo $width; ?>" size="3" /></p>
	<?php
	}

	public function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] 	= sanitize_text_field($new_instance['title']);
		$instance['url'] 	= esc_url_raw($new_instance['url']);
		$instance['width'] 	= absint($new_instance['width']);
		  
		return $instance;
	}
	
	public function widget($args, $instance) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}


		$title 		= ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
		$title 		= apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$url   		= isset( $instance['url'] ) ? esc_url( $instance['url'] ) : '';
		$width   	= isset( $instance['width'] ) ? absint( $instance['width'] ) : '800';

		echo $args['before_widget'];
		
		if ( $title ) echo $args['before_title'] . $title . $args['after_title'];

		if( ($url) ) {
			echo '<div class="video-container" style="max-width:' . $width . 'px;margin:0 auto;">';
			echo wp_oembed_get($url);
			echo '</div>';
		}
		
		echo $args['after_widget'];

	}
	
}	