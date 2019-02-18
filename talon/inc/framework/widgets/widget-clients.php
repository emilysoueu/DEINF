<?php
/**
 * Clients widget
 *
 * @package Talon
 */

class Athemes_Clients extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'athemes_clients_widget', 'description' => __( 'Display your clients list.', 'talon') );
        parent::__construct(false, $name = __('Talon: Clients', 'talon'), $widget_ops);
		$this->alt_option_name = 'athemes_clients_widget';
    }
	
	function form($instance) {
		$title     		= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    		= isset( $instance['number'] ) ? absint( $instance['number'] ) : -1;
		$category   	= isset( $instance['category'] ) ? esc_attr( $instance['category'] ) : '';
		$see_all   		= isset( $instance['see_all'] ) ? esc_url( $instance['see_all'] ) : '';
		$see_all_text  	= isset( $instance['see_all_text'] ) ? esc_html( $instance['see_all_text'] ) : '';
		$newtab			= isset( $instance['newtab'] ) ? (bool) $instance['newtab'] : false;					
				
	?>

	<p><?php _e('In order to display this widget, you must first add some clients from your admin area. Set your client logos as featured images.', 'talon'); ?></p>
	<p>
	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'talon'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
	</p>
	<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of clients to show (-1 shows all of them):', 'talon' ); ?></label>
	<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
    <p><label for="<?php echo $this->get_field_id('see_all'); ?>"><?php _e('The URL for your button [In case you want a button below your clients block]', 'talon'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'see_all' ); ?>" name="<?php echo $this->get_field_name( 'see_all' ); ?>" type="text" value="<?php echo $see_all; ?>" size="3" /></p>	
    <p><label for="<?php echo $this->get_field_id('see_all_text'); ?>"><?php _e('The text for the button [Defaults to <em>See all our clients</em> if left empty]', 'talon'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'see_all_text' ); ?>" name="<?php echo $this->get_field_name( 'see_all_text' ); ?>" type="text" value="<?php echo $see_all_text; ?>" size="3" /></p>		
	<p><label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Enter the slug for your category or leave empty to show all clients.', 'talon' ); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'category' ); ?>" name="<?php echo $this->get_field_name( 'category' ); ?>" type="text" value="<?php echo $category; ?>" size="3" /></p>
	<p><input class="checkbox" type="checkbox" <?php checked( $newtab ); ?> id="<?php echo $this->get_field_id( 'newtab' ); ?>" name="<?php echo $this->get_field_name( 'newtab' ); ?>" />
	<label for="<?php echo $this->get_field_id( 'newtab' ); ?>"><?php _e( 'Open clients links in a new tab?', 'talon' ); ?></label></p>
			
	<?php
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] 			= sanitize_text_field($new_instance['title']);
		$instance['number'] 		= sanitize_text_field($new_instance['number']);
		$instance['see_all'] 		= esc_url_raw( $new_instance['see_all'] );	
		$instance['see_all_text'] 	= sanitize_text_field($new_instance['see_all_text']);
		$instance['category'] 		= sanitize_text_field($new_instance['category']);		
		$instance['newtab'] 		= isset( $new_instance['newtab'] ) ? (bool) $new_instance['newtab'] : false;		  
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
		if ( ! $number ) {
			$number = -1;
		}			
		$category 		= isset( $instance['category'] ) ? esc_attr($instance['category']) : '';
		$newtab			= isset( $instance['newtab'] ) ? $instance['newtab'] : false;

		if ( $newtab ) {
			$target = "_blank";
		} else {
			$target = "_self";
		}
		
		$clients = new WP_Query( array(
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'post_type' 		  => 'clients',
			'posts_per_page'	  => $number,
			'category_name'		  => $category
		) );
		
		echo $args['before_widget'];

		if ($clients->have_posts()) :
		?>
		<div class="featured-section clearfix">

			<?php if ( $title ) echo '<div class="features-title-item">' . $args['before_title'] . $title . $args['after_title'] . '</div>'; ?>
				
			<?php while ( $clients->have_posts() ) : $clients->the_post(); ?>
				<?php $link = get_post_meta( get_the_ID(), 'wpcf-client-link', true ); ?>
					
				<?php if ( has_post_thumbnail() ) : ?>
				<div class="featured-item">
					<div class="featured-img">
					<?php if ($link) : ?>
						<a target="<?php echo $target; ?>" href="<?php echo esc_url($link); ?>"><?php the_post_thumbnail('talon-home-small'); ?></a>
					<?php else : ?>
						<?php the_post_thumbnail('talon-home-small'); ?>
					<?php endif; ?>
					</div>
					<div class="featured-text">
						<h5><?php the_title(); ?></h5>
					</div>
				</div>
				<?php endif; ?>

			<?php endwhile; ?>

			<?php if ($see_all != '') : ?>
			<a href="<?php echo esc_url($see_all); ?>" class="button section-button">
				<?php if ($see_all_text) : ?>
					<?php echo $see_all_text; ?>
				<?php else : ?>
					<?php echo __('See all our clients', 'talon'); ?>
				<?php endif; ?>
			</a>
			<?php endif; ?>	

		</div>
		<?php
	
		wp_reset_postdata();
		elseif ( current_user_can('edit_theme_options') ) :
		echo '<div class="no-posts-notice">' . sprintf( _x('Info: you have not created any clients. Make sure you have installed the %1$s plugin and then create some clients %2$s', 'no posts info', 'talon'),
				'<a href="//wordpress.org/plugins/athemes-toolbox" target="_blank">aThemes Toolbox</a>',
				'<a href="' . esc_url( get_admin_url('', 'edit.php?post_type=clients') ) . '">' . __('here', 'talon') . '</a>'
			) . '</div>';
		endif;

		echo $args['after_widget'];

	}
	
}