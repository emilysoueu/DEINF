<?php
/**
 * Facts widget
 *
 * @package Talon
 */

class Athemes_Facts extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'athemes_facts_widget', 'description' => __( 'Show your visitors some facts about your company.', 'talon') );
        parent::__construct(false, $name = __('Talon: Facts', 'talon'), $widget_ops);
		$this->alt_option_name = 'athemes_facts_widget';
    }
	
	function form($instance) {
		$title     			= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$fact_one   		= isset( $instance['fact_one'] ) ? esc_html( $instance['fact_one'] ) : '';
		$fact_one_max   	= isset( $instance['fact_one_max'] ) ? absint( $instance['fact_one_max'] ) : '';
		$fact_one_icon  	= isset( $instance['fact_one_icon'] ) ? esc_html( $instance['fact_one_icon'] ) : '';		
		$fact_two   		= isset( $instance['fact_two'] ) ? esc_attr( $instance['fact_two'] ) : '';
		$fact_two_max   	= isset( $instance['fact_two_max'] ) ? absint( $instance['fact_two_max'] ) : '';
		$fact_two_icon  	= isset( $instance['fact_two_icon'] ) ? esc_html( $instance['fact_two_icon'] ) : '';
		$fact_three   		= isset( $instance['fact_three'] ) ? esc_attr( $instance['fact_three'] ) : '';
		$fact_three_max 	= isset( $instance['fact_three_max'] ) ? absint( $instance['fact_three_max'] ) : '';
		$fact_three_icon  	= isset( $instance['fact_three_icon'] ) ? esc_html( $instance['fact_three_icon'] ) : '';
		$fact_four   		= isset( $instance['fact_four'] ) ? esc_attr( $instance['fact_four'] ) : '';		
		$fact_four_max  	= isset( $instance['fact_four_max'] ) ? absint( $instance['fact_four_max'] ) : '';
		$fact_four_icon  	= isset( $instance['fact_four_icon'] ) ? esc_html( $instance['fact_four_icon'] ) : '';	
	?>
	<p><?php _e('You can find a list of the available icons ', 'talon'); ?><a href="//athemes.com/documentation/et-icons/" target="_blank"><?php _e('here.', 'talon'); ?></a>&nbsp;<?php _e('Usage example: <strong>icon-mobile</strong>', 'talon'); ?></p>
	<p>
	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'talon'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
	</p>

	<h4><?php _e('FACT ONE', 'talon'); ?></h4>
	<p style="display:inline-block;width:31%;margin:0 1%;">
	<label for="<?php echo $this->get_field_id('fact_one'); ?>"><?php _e('Fact name', 'talon'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('fact_one'); ?>" name="<?php echo $this->get_field_name('fact_one'); ?>" type="text" value="<?php echo $fact_one; ?>" />
	</p>

	<p style="display:inline-block;width:31%;margin:0 1%;">
	<label for="<?php echo $this->get_field_id('fact_one_max'); ?>"><?php _e('Fact value', 'talon'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('fact_one_max'); ?>" name="<?php echo $this->get_field_name('fact_one_max'); ?>" type="text" value="<?php echo $fact_one_max; ?>" />
	</p>

	<p style="display:inline-block;width:31%;margin:0 1%;">
	<label for="<?php echo $this->get_field_id('fact_one_icon'); ?>"><?php _e('Fact icon', 'talon'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('fact_one_icon'); ?>" name="<?php echo $this->get_field_name('fact_one_icon'); ?>" type="text" value="<?php echo $fact_one_icon; ?>" />
	</p>

	<h4><?php _e('FACT TWO', 'talon'); ?></h4>
	<p style="display:inline-block;width:31%;margin:0 1%;">
	<label for="<?php echo $this->get_field_id('fact_two'); ?>"><?php _e('Fact name', 'talon'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('fact_two'); ?>" name="<?php echo $this->get_field_name('fact_two'); ?>" type="text" value="<?php echo $fact_two; ?>" />
	</p>

	<p style="display:inline-block;width:31%;margin:0 1%;">
	<label for="<?php echo $this->get_field_id('fact_two_max'); ?>"><?php _e('Fact value', 'talon'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('fact_two_max'); ?>" name="<?php echo $this->get_field_name('fact_two_max'); ?>" type="text" value="<?php echo $fact_two_max; ?>" />
	</p>

	<p style="display:inline-block;width:31%;margin:0 1%;">
	<label for="<?php echo $this->get_field_id('fact_two_icon'); ?>"><?php _e('Fact icon', 'talon'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('fact_two_icon'); ?>" name="<?php echo $this->get_field_name('fact_two_icon'); ?>" type="text" value="<?php echo $fact_two_icon; ?>" />
	</p>	

	<h4><?php _e('FACT THREE', 'talon'); ?></h4>
	<p style="display:inline-block;width:31%;margin:0 1%;">
	<label for="<?php echo $this->get_field_id('fact_three'); ?>"><?php _e('Fact name', 'talon'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('fact_three'); ?>" name="<?php echo $this->get_field_name('fact_three'); ?>" type="text" value="<?php echo $fact_three; ?>" />
	</p>

	<p style="display:inline-block;width:31%;margin:0 1%;">
	<label for="<?php echo $this->get_field_id('fact_three_max'); ?>"><?php _e('Fact value', 'talon'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('fact_three_max'); ?>" name="<?php echo $this->get_field_name('fact_three_max'); ?>" type="text" value="<?php echo $fact_three_max; ?>" />
	</p>

	<p style="display:inline-block;width:31%;margin:0 1%;">
	<label for="<?php echo $this->get_field_id('fact_three_icon'); ?>"><?php _e('Fact icon', 'talon'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('fact_three_icon'); ?>" name="<?php echo $this->get_field_name('fact_three_icon'); ?>" type="text" value="<?php echo $fact_three_icon; ?>" />
	</p>

	<h4><?php _e('FACT FOUR', 'talon'); ?></h4>
	<p style="display:inline-block;width:31%;margin:0 1%;">
	<label for="<?php echo $this->get_field_id('fact_four'); ?>"><?php _e('Fact name', 'talon'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('fact_four'); ?>" name="<?php echo $this->get_field_name('fact_four'); ?>" type="text" value="<?php echo $fact_four; ?>" />
	</p>

	<p style="display:inline-block;width:31%;margin:0 1%;">
	<label for="<?php echo $this->get_field_id('fact_four_max'); ?>"><?php _e('Fact value', 'talon'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('fact_four_max'); ?>" name="<?php echo $this->get_field_name('fact_four_max'); ?>" type="text" value="<?php echo $fact_four_max; ?>" />
	</p>

	<p style="display:inline-block;width:31%;margin:0 1%;">
	<label for="<?php echo $this->get_field_id('fact_four_icon'); ?>"><?php _e('Fact icon', 'talon'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('fact_four_icon'); ?>" name="<?php echo $this->get_field_name('fact_four_icon'); ?>" type="text" value="<?php echo $fact_four_icon; ?>" />
	</p>							

	<?php
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] 			= sanitize_text_field($new_instance['title']);
		$instance['fact_one'] 		= sanitize_text_field($new_instance['fact_one']);
		$instance['fact_one_max'] 	= sanitize_text_field($new_instance['fact_one_max']);
		$instance['fact_one_icon'] 	= sanitize_text_field($new_instance['fact_one_icon']);
		$instance['fact_two'] 		= sanitize_text_field($new_instance['fact_two']);
		$instance['fact_two_max'] 	= sanitize_text_field($new_instance['fact_two_max']);
		$instance['fact_two_icon'] 	= sanitize_text_field($new_instance['fact_two_icon']);
		$instance['fact_three'] 	= sanitize_text_field($new_instance['fact_three']);
		$instance['fact_three_max']	= sanitize_text_field($new_instance['fact_three_max']);
		$instance['fact_three_icon']= sanitize_text_field($new_instance['fact_three_icon']);
		$instance['fact_four'] 		= sanitize_text_field($new_instance['fact_four']);
		$instance['fact_four_max'] 	= sanitize_text_field($new_instance['fact_four_max']);
		$instance['fact_four_icon'] = sanitize_text_field($new_instance['fact_four_icon']);
		return $instance;
	}
		
	function widget($args, $instance) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$title 			= ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
		$fact_one   	= isset( $instance['fact_one'] ) ? esc_html( $instance['fact_one'] ) : '';
		$fact_one_max  	= isset( $instance['fact_one_max'] ) ? esc_html( $instance['fact_one_max'] ) : '';
		$fact_one_icon  = isset( $instance['fact_one_icon'] ) ? esc_html( $instance['fact_one_icon'] ) : '';
		$fact_two   	= isset( $instance['fact_two'] ) ? esc_attr( $instance['fact_two'] ) : '';
		$fact_two_max  	= isset( $instance['fact_two_max'] ) ? esc_html( $instance['fact_two_max'] ) : '';
		$fact_two_icon  = isset( $instance['fact_two_icon'] ) ? esc_html( $instance['fact_two_icon'] ) : '';
		$fact_three   	= isset( $instance['fact_three'] ) ? esc_attr( $instance['fact_three'] ) : '';
		$fact_three_max	= isset( $instance['fact_three_max'] ) ? esc_html( $instance['fact_three_max'] ) : '';
		$fact_three_icon= isset( $instance['fact_three_icon'] ) ? esc_html( $instance['fact_three_icon'] ) : '';
		$fact_four   	= isset( $instance['fact_four'] ) ? esc_attr( $instance['fact_four'] ) : '';		
		$fact_four_max 	= isset( $instance['fact_four_max'] ) ? esc_html( $instance['fact_four_max'] ) : '';
		$fact_four_icon = isset( $instance['fact_four_icon'] ) ? esc_html( $instance['fact_four_icon'] ) : '';

		echo $args['before_widget'];
?>

		<?php if ( $title ) echo $args['before_title'] . $title . $args['after_title']; ?>
		
		<div class="facts-section">
			<?php if ($fact_one !='') : ?>
			<div class="facts-item">
				<div class="facts-icon">
					<i class="<?php echo $fact_one_icon; ?>"></i>
				</div>
				<div class="facts-text">
					<span><?php echo $fact_one_max; ?></span>
					<p><?php echo $fact_one; ?></p>
				</div>
			</div>
			<?php endif; ?>
			<?php if ($fact_two !='') : ?>
			<div class="facts-item">
				<div class="facts-icon">
					<i class="<?php echo $fact_two_icon; ?>"></i>
				</div>
				<div class="facts-text">
					<span><?php echo $fact_two_max; ?></span>
					<p><?php echo $fact_two; ?></p>
				</div>
			</div>
			<?php endif; ?>
			<?php if ($fact_three !='') : ?>
			<div class="facts-item">
				<div class="facts-icon">
					<i class="<?php echo $fact_three_icon; ?>"></i>
				</div>
				<div class="facts-text">
					<span><?php echo $fact_three_max; ?></span>
					<p><?php echo $fact_three; ?></p>
				</div>
			</div>
			<?php endif; ?>								
			<?php if ($fact_four !='') : ?>
			<div class="facts-item">
				<div class="facts-icon">
					<i class="<?php echo $fact_four_icon; ?>"></i>
				</div>
				<div class="facts-text">
					<span><?php echo $fact_four_max; ?></span>
					<p><?php echo $fact_four; ?></p>
				</div>
			</div>
			<?php endif; ?>
		</div>

	<?php
		echo $args['after_widget'];
	}
	
}