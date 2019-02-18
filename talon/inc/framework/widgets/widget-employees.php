<?php
/**
 * Employees widget
 *
 * @package Talon
 */

class Athemes_Employees extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'athemes_employees_widget', 'description' => __( 'Display your team members in a stylish way.', 'talon') );
        parent::__construct(false, $name = __('Talon: Employees', 'talon'), $widget_ops);
		$this->alt_option_name = 'athemes_employees_widget';

    }

	function form($instance) {
		$title     		= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    		= isset( $instance['number'] ) ? absint( $instance['number'] ) : -1;
		$category  		= isset( $instance['category'] ) ? esc_attr( $instance['category'] ) : '';
		$see_all   		= isset( $instance['see_all'] ) ? esc_url( $instance['see_all'] ) : '';	
		$see_all_text  	= isset( $instance['see_all_text'] ) ? esc_html( $instance['see_all_text'] ) : '';		
	?>

	<p><?php _e('In order to display this widget, you must first add some employees from the dashboard. Add as many as you want and the theme will automatically display them all.', 'talon'); ?></p>
	<p>
	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'talon'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
	</p>
	<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of employees to show (-1 shows all of them):', 'talon' ); ?></label>
	<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
    <p><label for="<?php echo $this->get_field_id('see_all'); ?>"><?php _e('Enter an URL here if you want to section to link somewhere.', 'talon'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'see_all' ); ?>" name="<?php echo $this->get_field_name( 'see_all' ); ?>" type="text" value="<?php echo $see_all; ?>" size="3" /></p>	
    <p><label for="<?php echo $this->get_field_id('see_all_text'); ?>"><?php _e('The text for the button [Defaults to <em>See all our employees</em> if left empty]', 'talon'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'see_all_text' ); ?>" name="<?php echo $this->get_field_name( 'see_all_text' ); ?>" type="text" value="<?php echo $see_all_text; ?>" size="3" /></p>			
	<p><label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Enter the slug for your category or leave empty to show all employees.', 'talon' ); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'category' ); ?>" name="<?php echo $this->get_field_name( 'category' ); ?>" type="text" value="<?php echo $category; ?>" size="3" /></p>
	
	<?php
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] 			= sanitize_text_field($new_instance['title']);
		$instance['number'] 		= sanitize_text_field($new_instance['number']);		
		$instance['see_all'] 		= esc_url_raw( $new_instance['see_all'] );
		$instance['see_all_text'] 	= sanitize_text_field($new_instance['see_all_text']);			
		$instance['category'] 		= sanitize_text_field($new_instance['category']);
		return $instance;
	}

	function widget($args, $instance) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$title 			= ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
		$see_all 		= isset( $instance['see_all'] ) ? esc_url($instance['see_all']) : '';
		$see_all_text 	= isset( $instance['see_all_text'] ) ? esc_html($instance['see_all_text']) : '';		
		$number 		= ( ! empty( $instance['number'] ) ) ? intval( $instance['number'] ) : -1;
		if ( ! $number )
			$number = -1;			
		$category 		= isset( $instance['category'] ) ? esc_attr($instance['category']) : '';

		$employees = new WP_Query(array(
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'post_type' 		  => 'employees',
			'posts_per_page'	  => $number,
			'category_name'		  => $category			
		) );

		echo $args['before_widget'];

		if ($employees->have_posts()) :
?>

		<?php if ( $title ) echo $args['before_title'] . $title . $args['after_title']; ?>

		<div class="team-section">
			<?php while ( $employees->have_posts() ) : $employees->the_post(); ?>
				<?php
					$position = get_post_meta( get_the_ID(), 'wpcf-position', true );
					$facebook = get_post_meta( get_the_ID(), 'wpcf-facebook', true );
					$twitter  = get_post_meta( get_the_ID(), 'wpcf-twitter', true );
					$linkedin   = get_post_meta( get_the_ID(), 'wpcf-linkedin', true );
					$link     = get_post_meta( get_the_ID(), 'wpcf-custom-link', true );
				?>
				<div class="team-item">
					<?php if ( has_post_thumbnail() ) : ?>
					<div class="team-item-img">
						<?php the_post_thumbnail('talon-home-small'); ?>
					</div>
					<?php endif; ?>			
					<div class="team-item-name">
						<h3>
						<?php if ($link == '') : ?>
							<?php the_title(); ?>
						<?php else : ?>
							<a href="<?php echo esc_url($link); ?>"><?php the_title(); ?></a>
						<?php endif; ?>
						</h3>
						<p><?php echo esc_html($position); ?></p>
					</div>
					<div class="team-social">
					<?php if ($facebook != '') : ?>
						<a class="facebook" href="<?php echo esc_url($facebook); ?>" target="_blank"><i class="icon-facebook"></i></a>
					<?php endif; ?>
					<?php if ($twitter != '') : ?>
						<a class="twitter" href="<?php echo esc_url($twitter); ?>" target="_blank"><i class="icon-twitter"></i></a></li>
					<?php endif; ?>
					<?php if ($linkedin != '') : ?>
						<a class="linkedin" href="<?php echo esc_url($linkedin); ?>" target="_blank"><i class="icon-linkedin"></i></a>
					<?php endif; ?>
					</div>					
				</div>
			<?php endwhile; ?>
		</div>

		<?php if ($see_all != '') : ?>
		<a href="<?php echo esc_url($see_all); ?>" class="button section-button">
			<?php if ($see_all_text) : ?>
				<?php echo $see_all_text; ?>
			<?php else : ?>
				<?php echo __('See all our employees', 'talon'); ?>
			<?php endif; ?>
		</a>
		<?php endif; ?>	
	
	<?php wp_reset_postdata();?>

	<?php
		elseif ( current_user_can('edit_theme_options') ) :
		echo '<div class="no-posts-notice">' . sprintf( _x('Info: you have not created any employees. Make sure you have installed the %1$s plugin and then create some employees %2$s', 'no posts info', 'talon'),
				'<a href="//wordpress.org/plugins/athemes-toolbox" target="_blank">aThemes Toolbox</a>',
				'<a href="' . esc_url( get_admin_url('', 'edit.php?post_type=employees') ) . '">' . __('here', 'talon') . '</a>'
			) . '</div>';
		endif;

		echo $args['after_widget'];

	}
	
}