<?php
/**
 * Button widget
 *
 * @package Talon
 */

class Athemes_Button extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'athemes_button_widget', 'description' => __( 'Display a button.', 'talon') );
        parent::__construct(false, $name = __('Talon: Button', 'talon'), $widget_ops);
		$this->alt_option_name = 'athemes_button_widget';
    }
	
	function form($instance) {
		$title     	= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';		
		$btn_link_1 = isset( $instance['btn_link_1'] ) ? esc_url( $instance['btn_link_1'] ) : '';
		$btn_text_1 = isset( $instance['btn_text_1'] ) ? esc_html( $instance['btn_text_1'] ) : '';
		$btn_link_2 = isset( $instance['btn_link_2'] ) ? esc_url( $instance['btn_link_2'] ) : '';
		$btn_text_2 = isset( $instance['btn_text_2'] ) ? esc_html( $instance['btn_text_2'] ) : '';		
		$newtab 	= isset( $instance['newtab'] ) ? (bool) $instance['newtab'] : false;
		$alignment  = isset( $instance['alignment'] ) ? esc_attr( $instance['alignment'] ) : '';
		?>
		<p><em><?php _e('With this widget you can create one or two side-by-side buttons', 'talon'); ?></em></p>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'talon'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>
		<p><label for="<?php echo $this->get_field_id('btn_link_1'); ?>"><?php _e('Link for the first button', 'talon'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('btn_link_1'); ?>" name="<?php echo $this->get_field_name('btn_link_1'); ?>" type="text" value="<?php echo $btn_link_1; ?>" /></p>
		<p><label for="<?php echo $this->get_field_id('btn_text_1'); ?>"><?php _e('Title for the first button', 'talon'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('btn_text_1'); ?>" name="<?php echo $this->get_field_name('btn_text_1'); ?>" type="text" value="<?php echo $btn_text_1; ?>" /></p>
		<hr>
		<p><label for="<?php echo $this->get_field_id('btn_link_2'); ?>"><?php _e('Link for the second button', 'talon'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('btn_link_2'); ?>" name="<?php echo $this->get_field_name('btn_link_2'); ?>" type="text" value="<?php echo $btn_link_2; ?>" /></p>
		<p><label for="<?php echo $this->get_field_id('btn_text_2'); ?>"><?php _e('Title for the second button', 'talon'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('btn_text_2'); ?>" name="<?php echo $this->get_field_name('btn_text_2'); ?>" type="text" value="<?php echo $btn_text_2; ?>" /></p>		
		<hr>
		<p><input class="checkbox" type="checkbox" <?php checked( $newtab ); ?> id="<?php echo $this->get_field_id( 'newtab' ); ?>" name="<?php echo $this->get_field_name( 'newtab' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'newtab' ); ?>"><?php _e( 'Open the link in a new tab?', 'talon' ); ?></label></p>
		<hr>
		<p><label for="<?php echo $this->get_field_id('alignment'); ?>"><?php _e('Buttons alignment', 'talon'); ?></label>
        <select name="<?php echo $this->get_field_name('alignment'); ?>" id="<?php echo $this->get_field_id('alignment'); ?>" class="widefat">		
			<option value="left" <?php if ( 'left' == $alignment ) echo 'selected="selected"'; ?>><?php echo __('Left', 'talon'); ?></option>
			<option value="center" <?php if ( 'center' == $alignment ) echo 'selected="selected"'; ?>><?php echo __('Center', 'talon'); ?></option>
			<option value="right" <?php if ( 'right' == $alignment ) echo 'selected="selected"'; ?>><?php echo __('Right', 'talon'); ?></option>
       	</select>
        </p>             
		<?php
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] 	  = sanitize_text_field($new_instance['title']);
		$instance['btn_link_1'] = esc_url_raw($new_instance['btn_link_1']);
		$instance['btn_text_1'] = sanitize_text_field($new_instance['btn_text_1']);
		$instance['btn_link_2'] = esc_url_raw($new_instance['btn_link_2']);
		$instance['btn_text_2'] = sanitize_text_field($new_instance['btn_text_2']);
		$instance['newtab']   = isset( $new_instance['newtab'] ) ? (bool) $new_instance['newtab'] : false;
		$instance['alignment'] = sanitize_text_field($new_instance['alignment']);
	  
		return $instance;
	}
	
	function widget($args, $instance) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$title 	  = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
		$btn_link_1 = isset( $instance['btn_link_1'] ) ? esc_url($instance['btn_link_1']) : '';
		$btn_text_1 = isset( $instance['btn_text_1'] ) ? esc_html($instance['btn_text_1']) : '';
		$btn_link_2 = isset( $instance['btn_link_2'] ) ? esc_url($instance['btn_link_2']) : '';
		$btn_text_2 = isset( $instance['btn_text_2'] ) ? esc_html($instance['btn_text_2']) : '';		
		$newtab   = isset( $instance['newtab'] ) ? (bool) $instance['newtab'] : false;
		if ($newtab == 1) {
			$target = '_blank';
		} else {
			$target = '_self';
		}
		$alignment = isset( $instance['alignment'] ) ? esc_html($instance['alignment']) : '';		

		echo $args['before_widget'];

		if ( $title ) echo $args['before_title'] . $title . $args['after_title'];
		?>
        <div class="button-wrapper" style="text-align:<?php echo $alignment; ?>;">
			<a target="<?php echo $target; ?>" href="<?php echo esc_url($btn_link_1); ?>" class="button"><?php echo esc_html($btn_text_1); ?></a>
			<?php if ($btn_link_2) : ?>
			<a target="<?php echo $target; ?>" href="<?php echo esc_url($btn_link_2); ?>" class="button white-btn"><?php echo esc_html($btn_text_2); ?></a>
			<?php endif; ?>
        </div>
		<?php

		echo $args['after_widget'];

	}
	
}