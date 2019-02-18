<?php
/**
 * Services widget
 *
 * @package Talon
 */

class Athemes_Services extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'athemes_services_widget', 'description' => __( 'Show what services you are able to provide.', 'talon') );
        parent::__construct(false, $name = __('Talon: Services', 'talon'), $widget_ops);
		$this->alt_option_name = 'athemes_services_widget';
			
    }
	
	function form($instance) {
		$title     		= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    		= isset( $instance['number'] ) ? intval( $instance['number'] ) : -1;
		$category   	= isset( $instance['category'] ) ? esc_attr( $instance['category'] ) : '';
		$links_title  	= isset( $instance['links_title'] ) ? esc_html( $instance['links_title'] ) : __('Learn more', 'talon');
		$see_all   		= isset( $instance['see_all'] ) ? esc_url( $instance['see_all'] ) : '';		
		$see_all_text  	= isset( $instance['see_all_text'] ) ? esc_html( $instance['see_all_text'] ) : '';
		$two_cols 		= isset( $instance['two_cols'] ) ? (bool) $instance['two_cols'] : false;
	?>

	<p><?php _e('In order to display this widget, you must first add some services from your admin area.', 'talon'); ?></p>
	<p>
	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'talon'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
	</p>
	<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of services to show (-1 shows all of them):', 'talon' ); ?></label>
	<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
    <p><label for="<?php echo $this->get_field_id('see_all'); ?>"><?php _e('The URL for your button [In case you want a button below your services block]', 'talon'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'see_all' ); ?>" name="<?php echo $this->get_field_name( 'see_all' ); ?>" type="text" value="<?php echo $see_all; ?>" size="3" /></p>	
    
    <p><label for="<?php echo $this->get_field_id('links_title'); ?>"><?php _e('Links title (<em>use this to change the read more links titles</em>)', 'talon'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'links_title' ); ?>" name="<?php echo $this->get_field_name( 'links_title' ); ?>" type="text" value="<?php echo $links_title; ?>" size="3" /></p>


    <p><label for="<?php echo $this->get_field_id('see_all_text'); ?>"><?php _e('The text for the button [Defaults to <em>See all our services</em> if left empty]', 'talon'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'see_all_text' ); ?>" name="<?php echo $this->get_field_name( 'see_all_text' ); ?>" type="text" value="<?php echo $see_all_text; ?>" size="3" /></p>
	<p><label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Enter the slug for your category or leave empty to show all services.', 'talon' ); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'category' ); ?>" name="<?php echo $this->get_field_name( 'category' ); ?>" type="text" value="<?php echo $category; ?>" size="3" /></p>
	<p><input class="checkbox" type="checkbox" <?php checked( $two_cols ); ?> id="<?php echo $this->get_field_id( 'two_cols' ); ?>" name="<?php echo $this->get_field_name( 'two_cols' ); ?>" />
	<label for="<?php echo $this->get_field_id( 'two_cols' ); ?>"><?php _e( 'Display services in two columns instead of three?', 'talon' ); ?></label></p>

	<?php
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] 			= sanitize_text_field($new_instance['title']);
		$instance['number'] 		= sanitize_text_field($new_instance['number']);
		$instance['see_all'] 		= esc_url_raw( $new_instance['see_all'] );	
		$instance['see_all_text'] 	= sanitize_text_field($new_instance['see_all_text']);
		$instance['links_title'] 	= sanitize_text_field($new_instance['links_title']);				
		$instance['category'] 		= sanitize_text_field($new_instance['category']);
		$instance['two_cols'] 		= isset( $new_instance['two_cols'] ) ? (bool) $new_instance['two_cols'] : false;  
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
		if ( ! $number )
			$number 	= -1;				
		$category 		= isset( $instance['category'] ) ? esc_attr($instance['category']) : '';
		$two_cols 		= isset( $instance['two_cols'] ) ? $instance['two_cols'] : false;
		if (!$two_cols) {
			$cols = 'three-cols';
		} else {
			$cols = 'two-cols';
		}
		$links_title 	= isset( $instance['links_title'] ) ? esc_html($instance['links_title']) : __('Learn more', 'talon');		

		$services = new WP_Query( array(
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'post_type' 		  => 'services',
			'posts_per_page'	  => $number,
			'category_name'		  => $category			
		) );

		echo $args['before_widget'];

		if ($services->have_posts()) :
?>
			<?php if ( $title ) echo $args['before_title'] . $title . $args['after_title']; ?>

			<div class="services-section <?php echo $cols; ?>">

				<?php while ( $services->have_posts() ) : $services->the_post(); ?>
					<?php $icon = get_post_meta( get_the_ID(), 'wpcf-service-icon', true ); ?>
					<?php $link = get_post_meta( get_the_ID(), 'wpcf-service-link', true ); ?>

					<div class="services-item">
						<?php if ( has_post_thumbnail() ) : ?>
						<div class="services-thumb">
							<?php if ($link) : ?>
								<?php echo '<a href="' . esc_url($link) . '">';
								the_post_thumbnail('talon-home-small');
								echo '</a>'; ?>
							<?php else : ?>
								<?php the_post_thumbnail('talon-home-small'); ?>
							<?php endif; ?>
						</div>
						<?php elseif ($icon) : ?>			
						<div class="services-icon">
							<?php if ($link) : ?>
								<?php echo '<a href="' . esc_url($link) . '"><i class="' . esc_html($icon) . '"></i></a>'; ?>
							<?php else : ?>
								<?php echo '<i class="' . esc_html($icon) . '"></i>'; ?>
							<?php endif; ?>
						</div>
						<?php endif; ?>
						<div class="service-name">
							<h3><?php the_title(); ?></h3>
						</div>
						<div class="service-text general-text">
							<p><?php echo get_the_content(); ?></p>
						</div>
						<?php if ($link) : ?>
						<div class="service-link">
							<a href="<?php echo esc_url($link); ?>"><?php echo $links_title; ?></a>
						</div>
						<?php endif; ?>	
					</div>
				<?php endwhile; ?>

				<?php if ($see_all != '') : ?>
				<a href="<?php echo esc_url($see_all); ?>" class="button section-button">
					<?php if ($see_all_text) : ?>
						<?php echo $see_all_text; ?>
					<?php else : ?>
						<?php echo __('See all our services', 'talon'); ?>
					<?php endif; ?>
				</a>
				<?php endif; ?>	

			</div>			
	<?php
		wp_reset_postdata();
		elseif ( current_user_can('edit_theme_options') ) :
		echo '<div class="no-posts-notice">' . sprintf( _x('Info: you have not created any services. Make sure you have installed the %1$s plugin and then create some services %2$s', 'no posts info', 'talon'),
				'<a href="//wordpress.org/plugins/athemes-toolbox" target="_blank">aThemes Toolbox</a>',
				'<a href="' . esc_url( get_admin_url('', 'edit.php?post_type=services') ) . '">' . __('here', 'talon') . '</a>'
			) . '</div>';
		endif;
		echo $args['after_widget'];

	}
	
}