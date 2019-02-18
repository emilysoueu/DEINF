<?php
/**
 * Testimonials widget
 *
 * @package Talon
 */

class Athemes_Testimonials extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'athemes_testimonials_widget', 'description' => __( 'Display your testimonials in a slider.', 'talon') );
        parent::__construct(false, $name = __('Talon: Testimonials', 'talon'), $widget_ops);
		$this->alt_option_name = 'athemes_testimonials_widget';
    }
	
	function form($instance) {
		$title     		= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    		= isset( $instance['number'] ) ? intval( $instance['number'] ) : -1;
		$category   	= isset( $instance['category'] ) ? esc_attr( $instance['category'] ) : '';
		$see_all   		= isset( $instance['see_all'] ) ? esc_url( $instance['see_all'] ) : '';
		$see_all_text  	= isset( $instance['see_all_text'] ) ? esc_html( $instance['see_all_text'] ) : '';	
		$autoplay    	= isset( $instance['autoplay'] ) ? intval( $instance['autoplay'] ) : 5000;	
	?>

	<p><?php _e('In order to display this widget, you must first add some testimonials from your admin area.', 'talon'); ?></p>
	<p>
	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'talon'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
	</p>
	<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of testimonials to show (-1 shows all of them):', 'talon' ); ?></label>
	<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
    <p><label for="<?php echo $this->get_field_id('see_all'); ?>"><?php _e('The URL for your button [In case you want a button below your testimonials block]', 'talon'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'see_all' ); ?>" name="<?php echo $this->get_field_name( 'see_all' ); ?>" type="text" value="<?php echo $see_all; ?>" size="3" /></p>	
    <p><label for="<?php echo $this->get_field_id('see_all_text'); ?>"><?php _e('The text for the button [Defaults to <em>See all our testimonials</em> if left empty]', 'talon'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'see_all_text' ); ?>" name="<?php echo $this->get_field_name( 'see_all_text' ); ?>" type="text" value="<?php echo $see_all_text; ?>" size="3" /></p>		
	<p><label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Enter the slug for your category or leave empty to show all testimonials.', 'talon' ); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'category' ); ?>" name="<?php echo $this->get_field_name( 'category' ); ?>" type="text" value="<?php echo $category; ?>" size="3" /></p>
	<p><label for="<?php echo $this->get_field_id( 'autoplay' ); ?>"><?php _e( 'Autoplay time [ms]', 'talon' ); ?></label>
	<input id="<?php echo $this->get_field_id( 'autoplay' ); ?>" name="<?php echo $this->get_field_name( 'autoplay' ); ?>" type="text" value="<?php echo $autoplay; ?>" size="3" /></p>
    		
	<?php
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] 			= sanitize_text_field($new_instance['title']);
		$instance['number'] 		= sanitize_text_field($new_instance['number']);
		$instance['see_all'] 		= esc_url_raw( $new_instance['see_all'] );	
		$instance['see_all_text'] 	= sanitize_text_field($new_instance['see_all_text']);
		$instance['category'] 		= sanitize_text_field($new_instance['category']);
		$instance['autoplay'] 		= absint($new_instance['autoplay']);		  
		return $instance;
	}

	function widget($args, $instance) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$title 			= ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
		$title 			= apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$see_all 		= isset( $instance['see_all'] ) ? esc_url($instance['see_all']) : '';
		$see_all_text 	= isset( $instance['see_all_text'] ) ? esc_html($instance['see_all_text']) : '';
		$number 		= ( ! empty( $instance['number'] ) ) ? intval( $instance['number'] ) : -1;
		if ( ! $number ) {
			$number = -1;
		}			
		$category 		= isset( $instance['category'] ) ? esc_attr($instance['category']) : '';
		$autoplay 		= ( ! empty( $instance['autoplay'] ) ) ? intval( $instance['autoplay'] ) : 5000;

		$testimonials = new WP_Query( array(
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'post_type' 		  => 'testimonials',
			'posts_per_page'	  => $number,
			'category_name'		  => $category
		) );
		
		echo $args['before_widget'];

		if ($testimonials->have_posts()) :
			global $post;
?>
			<?php if ( $title ) echo $args['before_title'] . $title . $args['after_title']; ?>

			<div class="testimonials-box">
				<div class="testimonials-slider" data-speed="<?php echo $autoplay; ?>">
				<?php while ( $testimonials->have_posts() ) : $testimonials->the_post(); ?>
				<?php $function = get_post_meta( get_the_ID(), 'wpcf-client-function', true ); ?>
				<div class="testimonials-slider-item">
					<div class="testimonials-text">
						<p><?php echo get_the_content(); ?></p>
					</div>
					<div class="testimonials-user-info clearfix">
						<?php if ( has_post_thumbnail() ) : ?>
						<div class="user-img">
							<?php echo get_the_post_thumbnail( $post -> ID, array( 36, 36) ); ?>
						</div>
						<?php endif; ?>  
						<div class="name-user">
							<p><?php the_title(); ?> <span><?php echo esc_html($function); ?></span></p>
						</div>
					</div>
				</div>
				<?php endwhile; ?>
				</div>
			</div>

			<?php if ($see_all != '') : ?>
			<a href="<?php echo esc_url($see_all); ?>" class="button section-button">
				<?php if ($see_all_text) : ?>
					<?php echo $see_all_text; ?>
				<?php else : ?>
					<?php echo __('See all our testimonials', 'talon'); ?>
				<?php endif; ?>
			</a>
			<?php endif; ?>	

	<?php
		wp_reset_postdata();
		elseif ( current_user_can('edit_theme_options') ) :
		echo '<div class="no-posts-notice">' . sprintf( _x('Info: you have not created any testimonials. Make sure you have installed the %1$s plugin and then create some testimonials %2$s', 'no posts info', 'talon'),
				'<a href="//wordpress.org/plugins/athemes-toolbox" target="_blank">aThemes Toolbox</a>',
				'<a href="' . esc_url( get_admin_url('', 'edit.php?post_type=testimonials') ) . '">' . __('here', 'talon') . '</a>'
			) . '</div>';
		endif;
		echo $args['after_widget'];
	}
	
}

