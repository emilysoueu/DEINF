<?php
/**
 * Separator widget
 *
 * @package Talon
 */

class Athemes_Separator extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'athemes_separator_widget', 'description' => __( 'Separator with custom height.', 'talon') );
        parent::__construct(false, $name = __('Talon: Separator', 'talon'), $widget_ops);
		$this->alt_option_name = 'athemes_separator_widget';
    }
	
	function form($instance) {
		$sep_height = isset( $instance['sep_height'] ) ? absint( $instance['sep_height'] ) : '';
		?>

		<p><label for="<?php echo $this->get_field_id('sep_height'); ?>"><?php _e('Separator height', 'talon'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('sep_height'); ?>" name="<?php echo $this->get_field_name('sep_height'); ?>" type="text" value="<?php echo $sep_height; ?>" /></p>
		
		<?php
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['sep_height'] = sanitize_text_field($new_instance['sep_height']);
		return $instance;
	}
	
	function widget($args, $instance) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$sep_height = isset( $instance['sep_height'] ) ? absint($instance['sep_height']) : '';

		?>
        <div class="talon-separator" style="width:100%;height: <?php echo absint($sep_height); ?>px"></div>
		<?php

	}
	
}