<?php
/**
 * Skills widget
 *
 * @package Talon
 */

class Athemes_Skills extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'athemes_skills_widget', 'description' => __( 'Show your visitors some of your skills.', 'talon') );
        parent::__construct(false, $name = __('Talon: Skills', 'talon'), $widget_ops);
		$this->alt_option_name = 'athemes_skills_widget';
    }
	
	function form($instance) {
		$title     			= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$skill_one   		= isset( $instance['skill_one'] ) ? esc_html( $instance['skill_one'] ) : '';
		$skill_one_max   	= isset( $instance['skill_one_max'] ) ? absint( $instance['skill_one_max'] ) : '';
		$skill_two   		= isset( $instance['skill_two'] ) ? esc_attr( $instance['skill_two'] ) : '';
		$skill_two_max   	= isset( $instance['skill_two_max'] ) ? absint( $instance['skill_two_max'] ) : '';
		$skill_three   		= isset( $instance['skill_three'] ) ? esc_attr( $instance['skill_three'] ) : '';
		$skill_three_max 	= isset( $instance['skill_three_max'] ) ? absint( $instance['skill_three_max'] ) : '';
		$skill_four   		= isset( $instance['skill_four'] ) ? esc_attr( $instance['skill_four'] ) : '';		
		$skill_four_max  	= isset( $instance['skill_four_max'] ) ? absint( $instance['skill_four_max'] ) : '';
	?>

	<p>
	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'talon'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
	</p>

	<!-- skill one -->
	<p>
	<label for="<?php echo $this->get_field_id('skill_one'); ?>"><?php _e('First skill name', 'talon'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('skill_one'); ?>" name="<?php echo $this->get_field_name('skill_one'); ?>" type="text" value="<?php echo $skill_one; ?>" />
	</p>

	<p>
	<label for="<?php echo $this->get_field_id('skill_one_max'); ?>"><?php _e('First skill value', 'talon'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('skill_one_max'); ?>" name="<?php echo $this->get_field_name('skill_one_max'); ?>" type="text" value="<?php echo $skill_one_max; ?>" />
	</p>

	<!-- skill two -->
	<p>
	<label for="<?php echo $this->get_field_id('skill_two'); ?>"><?php _e('Second skill name', 'talon'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('skill_two'); ?>" name="<?php echo $this->get_field_name('skill_two'); ?>" type="text" value="<?php echo $skill_two; ?>" />
	</p>

	<p>
	<label for="<?php echo $this->get_field_id('skill_two_max'); ?>"><?php _e('Second skill value', 'talon'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('skill_two_max'); ?>" name="<?php echo $this->get_field_name('skill_two_max'); ?>" type="text" value="<?php echo $skill_two_max; ?>" />
	</p>	

	<!-- skill three -->
	<p>
	<label for="<?php echo $this->get_field_id('skill_three'); ?>"><?php _e('Third skill name', 'talon'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('skill_three'); ?>" name="<?php echo $this->get_field_name('skill_three'); ?>" type="text" value="<?php echo $skill_three; ?>" />
	</p>

	<p>
	<label for="<?php echo $this->get_field_id('skill_three_max'); ?>"><?php _e('Third skill value', 'talon'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('skill_three_max'); ?>" name="<?php echo $this->get_field_name('skill_three_max'); ?>" type="text" value="<?php echo $skill_three_max; ?>" />
	</p>

	<!-- skill four -->
	<p>
	<label for="<?php echo $this->get_field_id('skill_four'); ?>"><?php _e('Fourth skill name', 'talon'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('skill_four'); ?>" name="<?php echo $this->get_field_name('skill_four'); ?>" type="text" value="<?php echo $skill_four; ?>" />
	</p>

	<p>
	<label for="<?php echo $this->get_field_id('skill_four_max'); ?>"><?php _e('Fourth skill value', 'talon'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('skill_four_max'); ?>" name="<?php echo $this->get_field_name('skill_four_max'); ?>" type="text" value="<?php echo $skill_four_max; ?>" />
	</p>
							

	<?php
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] 				= sanitize_text_field($new_instance['title']);
		$instance['skill_one'] 			= sanitize_text_field($new_instance['skill_one']);
		$instance['skill_one_max'] 		= absint($new_instance['skill_one_max']);
		$instance['skill_two'] 			= sanitize_text_field($new_instance['skill_two']);
		$instance['skill_two_max'] 		= absint($new_instance['skill_two_max']);
		$instance['skill_three'] 		= sanitize_text_field($new_instance['skill_three']);
		$instance['skill_three_max']	= absint($new_instance['skill_three_max']);
		$instance['skill_four'] 		= sanitize_text_field($new_instance['skill_four']);
		$instance['skill_four_max'] 	= absint($new_instance['skill_four_max']);		  
		return $instance;
	}
	
	function widget($args, $instance) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$title 			= ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
		$skill_one   	= isset( $instance['skill_one'] ) ? esc_html( $instance['skill_one'] ) : '';
		$skill_one_max  = isset( $instance['skill_one_max'] ) ? absint( $instance['skill_one_max'] ) : '';
		$skill_two   	= isset( $instance['skill_two'] ) ? esc_attr( $instance['skill_two'] ) : '';
		$skill_two_max  = isset( $instance['skill_two_max'] ) ? absint( $instance['skill_two_max'] ) : '';
		$skill_three   	= isset( $instance['skill_three'] ) ? esc_attr( $instance['skill_three'] ) : '';
		$skill_three_max= isset( $instance['skill_three_max'] ) ? absint( $instance['skill_three_max'] ) : '';
		$skill_four   	= isset( $instance['skill_four'] ) ? esc_attr( $instance['skill_four'] ) : '';		
		$skill_four_max = isset( $instance['skill_four_max'] ) ? absint( $instance['skill_four_max'] ) : '';

		echo $args['before_widget'];
?>

		<?php if ( $title ) echo $args['before_title'] . $title . $args['after_title']; ?>
				
		<div class="skills-section">

			<?php if ($skill_one !='') : ?>
			<div class="skills-item">
				<div class="skills-progress-bar">
					<div class="skills-progress-inner" style="width: <?php echo absint($skill_one_max) . '%'; ?>;">
						<div class="inner-bar"></div>
						<div class="skills-progress-text">
							<?php echo esc_html($skill_one); ?>&nbsp;<?php echo absint($skill_one_max) . '%'; ?>
						</div>
					</div>
				</div>
			</div>
			<?php endif; ?>
			<?php if ($skill_two !='') : ?>
			<div class="skills-item">
				<div class="skills-progress-bar">
					<div class="skills-progress-inner" style="width: <?php echo absint($skill_two_max) . '%'; ?>;">
						<div class="inner-bar"></div>
						<div class="skills-progress-text">
							<?php echo esc_html($skill_two); ?>&nbsp;<?php echo absint($skill_two_max) . '%'; ?>
						</div>
					</div>
				</div>
			</div>
			<?php endif; ?>
			<?php if ($skill_three !='') : ?>
			<div class="skills-item">
				<div class="skills-progress-bar">
					<div class="skills-progress-inner" style="width: <?php echo absint($skill_three_max) . '%'; ?>;">
						<div class="inner-bar"></div>
						<div class="skills-progress-text">
							<?php echo esc_html($skill_three); ?>&nbsp;<?php echo absint($skill_three_max) . '%'; ?>
						</div>
					</div>
				</div>
			</div>
			<?php endif; ?>			
			<?php if ($skill_four !='') : ?>
			<div class="skills-item">
				<div class="skills-progress-bar">
					<div class="skills-progress-inner" style="width: <?php echo absint($skill_four_max) . '%'; ?>;">
						<div class="inner-bar"></div>
						<div class="skills-progress-text">
							<?php echo esc_html($skill_four); ?>&nbsp;<?php echo absint($skill_four_max) . '%'; ?>
						</div>
					</div>
				</div>
			</div>
			<?php endif; ?>
		</div>

	<?php
		echo $args['after_widget'];

	}
	
}