<?php
/**
 * Portfolio widget
 *
 * @package Talon
 */

class Athemes_Portfolio extends WP_Widget {

  public function __construct() {
    $widget_ops = array('classname' => 'athemes_portfolio_widget', 'description' => __( 'Display your projects in a grid.', 'talon') );
       parent::__construct(false, $name = __('Talon: Portfolio', 'talon'), $widget_ops);
    $this->alt_option_name = 'athemes_portfolio_widget';
  }

  public function widget( $args, $instance ) {

    $title         = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';
    $number        = ( ! empty( $instance['number'] ) ) ? intval( $instance['number'] ) : -1;
    if ( ! $number ) {
      $number = -1;
    } 
    $includes            = isset($instance['includes']) ? esc_html( $instance['includes'] ) : 0;
    $show_filter         = isset( $instance['show_filter'] ) ? (bool) $instance['show_filter'] : false;
    $show_all_text       = isset( $instance['show_all_text'] ) ? esc_html( $instance['show_all_text'] ) : '';

    $options = array(
     'filter'        => $show_filter,
     'show_all_text' => ! empty( $show_all_text ) ? $show_all_text : __('Show all', 'talon')
    );
    
    $r = new WP_Query( array(
      'no_found_rows'   => true,
      'post_status'     => 'publish',
      'post_type'       => 'projects',
      'posts_per_page'  => $number,
      'category_name'   => $includes
    ) );    

    echo $args['before_widget'];

    if ( ! empty( $title ) ) { echo $args['before_title'] . $title . $args['after_title']; }

    if ($r->have_posts()) :

    ?>

    <div class="portfolio-section">
      <?php
      if ($includes && $show_filter == 1) :
         $included_terms = explode( ',', $includes );
         $included_ids = array();

         foreach( $included_terms as $term ) {
             $term_obj = get_term_by( 'slug', $term, 'category');
             if (is_object($term_obj)) {
                $term_id  = $term_obj->term_id;
                $included_ids[] = $term_id;
             }
         }

         $id_string = implode( ',', $included_ids );
         $terms = get_terms( 'category', array( 'include' => $id_string ) );
      ?>
      <div class="portfolio-filter">
        <ul class="portfolio-filter">
          <li class="active"><a href="#" data-filter="*"><?php echo $options['show_all_text']; ?></a></li>
          <?php $count = count($terms);
              if ( $count > 0 ){
                foreach ( $terms as $term ) { ?>
                <li><a href='#' data-filter=".<?php echo $term->slug; ?>"><?php echo $term->name; ?></a></li>
              <?php }
          } ?>
        </ul>
      </div>
      <?php endif; ?>


      <div class="projects-container">
      <?php

      while ( $r->have_posts() ):
         $r->the_post();
         global $post;
         $id = $post->ID;
         $termsArray = get_the_terms( $id, 'category' );
         $termsString = "";

         if ( $termsArray) {
             foreach ( $termsArray as $term ) {
                 $termsString .= $term->slug.' ';
             }
         }

         if ( has_post_thumbnail() ) {
             $project_url = get_post_meta( get_the_ID(), 'wpcf-project-link', true );
             if ( $project_url ) {
             $url = $project_url;
             } else {
             $url = get_the_permalink();
             } ?>

            <div class="portfolio-item <?php echo $termsString; ?>">
              <a href="<?php echo esc_url($url); ?>"><?php the_post_thumbnail('talon-home-large'); ?></a>
              <div class="portfolio-content">
              <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
              </div>
            </div>
         <?php
         }
      endwhile;
      wp_reset_postdata(); ?>
      </div>
    </div>

    <?php
    elseif ( current_user_can('edit_theme_options') ) :
    echo '<div class="no-posts-notice">' . sprintf( _x('Info: you have not created any projects. Make sure you have installed the %1$s plugin and then create some projects %2$s', 'no posts info', 'talon'),
        '<a href="//wordpress.org/plugins/athemes-toolbox" target="_blank">aThemes Toolbox</a>',
        '<a href="' . esc_url( get_admin_url('', 'edit.php?post_type=projects') ) . '">' . __('here', 'talon') . '</a>'
      ) . '</div>';
    endif;
    echo $args['after_widget'];

  }


  function update($new_instance, $old_instance) {
      $instance = $old_instance;
      $instance['title']              = sanitize_text_field($new_instance['title']);
      $instance['number']             = intval($new_instance['number']);
      $instance['includes']           = sanitize_text_field($new_instance['includes']);
      $instance['show_filter']        = isset( $new_instance['show_filter'] ) ? (bool) $new_instance['show_filter'] : false;
      $instance['show_all_text']      = sanitize_text_field($new_instance['show_all_text']);
      return $instance;
  }

 function form($instance) {
      $title               = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
      $number              = isset( $instance['number'] ) ? intval( $instance['number'] ) : -1;
      $includes            = isset( $instance['includes'] ) ? esc_attr($instance['includes']) : '';
      $show_filter         = isset( $instance['show_filter'] ) ? (bool) $instance['show_filter'] : true;
      $show_all_text       = isset( $instance['show_all_text'] )  ? esc_html($instance['show_all_text']) : __('Show all', 'talon');

  ?>

   <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'talon'); ?></label>
   <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
   <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of projects to show (-1 shows all of them):', 'talon' ); ?></label>
   <input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>
   <p><label for="<?php echo $this->get_field_id('includes'); ?>"><?php _e('Enter the slugs (comma separated) for your categories or leave empty to show all projects.', 'talon'); ?></label>
   <input class="widefat" id="<?php echo $this->get_field_id('includes'); ?>" name="<?php echo $this->get_field_name('includes'); ?>" type="text" value="<?php echo $includes; ?>" /></p>
   <p><input class="checkbox" type="checkbox" <?php checked( $show_filter ); ?> id="<?php echo $this->get_field_id( 'show_filter' ); ?>" name="<?php echo $this->get_field_name( 'show_filter' ); ?>" />
   <label for="<?php echo $this->get_field_id( 'show_filter' ); ?>"><?php _e( 'Show navigation filter? (Category slugs must be specified).', 'talon' ); ?></label></p>
   <p><label for="<?php echo $this->get_field_id('show_all_text'); ?>"><?php _e('"Show all" text:', 'talon'); ?></label>
   <input class="widefat" id="<?php echo $this->get_field_id('show_all_text'); ?>" name="<?php echo $this->get_field_name('show_all_text'); ?>" type="text" value="<?php echo esc_attr($show_all_text); ?>" /></p>

   <?php

 }
}