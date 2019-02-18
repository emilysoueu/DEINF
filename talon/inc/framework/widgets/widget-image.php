<?php
/**
 * Button widget
 *
 * @package Talon
 */

class Athemes_Image extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'athemes_image_widget', 'description' => __( 'Add an image', 'talon') );
        parent::__construct(false, $name = __('Talon: Image', 'talon'), $widget_ops);
		$this->alt_option_name = 'athemes_image_widget';
    }
	
	function form($instance) {
		$title     	= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';		
		$image_uri 	= isset( $instance['image_uri'] ) ? esc_url( $instance['image_uri'] ) : '';		
		$link 		= isset( $instance['link'] ) ? esc_url( $instance['link'] ) : '';		

		?>

		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'talon'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
	    <p><label for="<?php echo $this->get_field_id('image_uri'); ?>"><?php _e('Upload your image', 'talon'); ?></label></p> 		
		<p><input class="widefat custom_media_url" id="<?php echo $this->get_field_id( 'image_uri' ); ?>" name="<?php echo $this->get_field_name( 'image_uri' ); ?>" type="text" value="<?php echo $image_uri; ?>" size="3" /></p>	
	    <p><input type="button" class="button button-primary custom_media_button" id="custom_media_button" value="<?php echo esc_attr__('Upload Image', 'talon'); ?>" /></p>	    
	    <p><label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('Enter an URL here if you want to link your image somewhere', 'talon'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" type="text" value="<?php echo $link; ?>" size="3" /></p>	
	   
		<?php
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] 	  	= sanitize_text_field($new_instance['title']);
	    $instance['image_uri'] 	= esc_url_raw( $new_instance['image_uri'] );
	    $instance['link'] 		= esc_url_raw( $new_instance['link'] );  
		return $instance;
	}
	
	function widget($args, $instance) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$title 	  	= ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
		$image_uri 	= isset( $instance['image_uri'] ) ? esc_url($instance['image_uri']) : '';		
		$link 		= isset( $instance['link'] ) ? esc_url($instance['link']) : '';		

		echo $args['before_widget'];

		if ( $title ) echo $args['before_title'] . $title . $args['after_title'];
		?>
        <div class="image-widget">
			<?php if ( $link == '' ) : ?>
				<img src="<?php echo $image_uri; ?>"/>
			<?php else : ?>
				<a href="<?php echo $link; ?>"><img src="<?php echo $image_uri; ?>"/></a>
			<?php endif; ?>
        </div>
		<?php

		echo $args['after_widget'];

	}
	
}