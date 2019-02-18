<?php
/**
 * Blog widget
 *
 * @package Talon
 */

class Athemes_Blog extends WP_Widget {

	public function __construct() {
		$widget_ops = array('classname' => 'athemes_blog_widget', 'description' => __( 'Show the latest news from your blog.', 'talon') );
        parent::__construct(false, $name = __('Talon: Blog', 'talon'), $widget_ops);
		$this->alt_option_name = 'athemes_blog_widget';
		
    }
	
	function form($instance) {
		$title     		= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$category  		= isset( $instance['category'] ) ? esc_attr( $instance['category'] ) : '';
		$see_all_text  	= isset( $instance['see_all_text'] ) ? esc_html( $instance['see_all_text'] ) : '';
		$number   		= isset( $instance['number'] ) ? absint( $instance['number'] ) : 3;										
	?>

	<p>
	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'talon'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
	</p>

	<p><label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Enter the slug for your category or leave empty to show posts from all categories.', 'talon' ); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'category' ); ?>" name="<?php echo $this->get_field_name( 'category' ); ?>" type="text" value="<?php echo $category; ?>" size="3" /></p>	

    <p><label for="<?php echo $this->get_field_id('see_all_text'); ?>"><?php _e('Add the text for the button here if you want to change the default <em>See all our news</em>', 'talon'); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'see_all_text' ); ?>" name="<?php echo $this->get_field_name( 'see_all_text' ); ?>" type="text" value="<?php echo $see_all_text; ?>" size="3" /></p>		

	<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:', 'talon' ); ?></label>
	<input class="tiny-text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" /></p>

	<?php
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] 			= sanitize_text_field($new_instance['title']);
		$instance['category'] 		= sanitize_text_field($new_instance['category']);
		$instance['see_all_text'] 	= sanitize_text_field($new_instance['see_all_text']);
		$instance['number'] 		= (int) $new_instance['number'];		  
		return $instance;
	}
		
	function widget($args, $instance) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
		$category = isset( $instance['category'] ) ? esc_attr($instance['category']) : '';
		$see_all_text = isset( $instance['see_all_text'] ) ? esc_html($instance['see_all_text']) : __( 'See all our news', 'talon' );
		if ($see_all_text == '') {
			$see_all_text = __( 'See all our news', 'talon' );
		}
		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 3;
		if ( ! $number )
			$number = 3;

		$r = new WP_Query( array(
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'posts_per_page'	  => $number,
			'category_name'		  => $category,
			'ignore_sticky_posts' => true
		) );

		echo $args['before_widget'];

		if ($r->have_posts()) :
		?>

			<div class="home-blog-section">
			<?php if ( $title ) echo $args['before_title'] . $title . $args['after_title']; ?>
			<div class="clearfix">
				<?php while ( $r->have_posts() ) : $r->the_post(); ?>
				<div class="col-sm-4">
					<div class="home-blog-item">
						<?php if ( has_post_thumbnail() ) : ?>
						<div class="home-blog-img">
							<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
								<?php the_post_thumbnail('talon-home-large'); ?>
							</a>			
						</div>	
						<?php endif; ?>	
						<div class="entry-meta meta-home">
							<p><?php talon_posted_on(); ?></p>
						</div>
						<div class="home-post-title">
							<?php the_title( '<h3><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' ); ?>
						</div>
					</div>
				</div>
				<?php endwhile; ?>
				</div>
			<?php $cat = get_term_by('slug', $category, 'category') ?>
			<?php if ($category) : //Link to the category page instead of blog page if a category is selected ?>
				<div class="blog-button"><a href="<?php echo esc_url( get_category_link( get_cat_ID( $cat -> name ) ) ); ?>">+ <?php echo $see_all_text; ?></a></div>
			<?php else : ?>
				<div class="blog-button"><a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>">+ <?php echo $see_all_text; ?></a></div>
			<?php endif; ?>		
			<?php
			wp_reset_postdata(); ?>
			</div>
			<?php

		endif;

		echo $args['after_widget'];
	}
	
}