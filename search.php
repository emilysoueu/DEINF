<?php

get_header(); 
$left_sidebar    = onetone_option('left_sidebar_search');
$right_sidebar   = onetone_option('right_sidebar_search');

$page_title_position    = onetone_option( 'page_title_position' );
if( $page_title_position == '' )
	$page_title_position = 'left';
	
$sidebar         = 'none';

if( $left_sidebar )
$sidebar    = 'left';
if( $right_sidebar )
$sidebar    = 'right';
if( $left_sidebar && $right_sidebar )
$sidebar    = 'both';
$container  = 'container';

?>
<!--Main Area-->

<section class="page-title-bar title-<?php echo esc_attr($page_title_position); ?> no-subtitle" style="">
  <div class="container">
    <?php onetone_breadcrumbs();?>
    <div class="clearfix"></div>
  </div>
</section>
<div class="page-wrap">
  <div class="<?php echo $container;?>">
    <div class="page-inner row <?php echo onetone_get_content_class($sidebar);?>">
      <div class="col-main">
        <section class="page-main" role="main" id="content">
          <div class="page-content">
            <!--blog list begin-->
            <div class="blog-list-wrap">
              <?php if ( have_posts() ) : ?>
              <?php /* Start the Loop */ ?>
              <?php while ( have_posts() ) : the_post(); ?>
              <?php get_template_part( 'content', 'sitesearch'); ?>
              <?php endwhile; ?>
              <?php 
			  the_posts_pagination( array(
											 'mid_size' => 3,
												'prev_text' => '<i class="fa fa-angle-double-left"></i><span class="screen-reader-text">' . __( 'Previous page', 'onetone' ) . '</span>',
												'next_text' => '<span class="screen-reader-text">' . __( 'Next page', 'onetone' ) . '</span><i class="fa fa-angle-double-right"></i>' ,
												'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'onetone' ) . ' </span>',
											) );
			  ?>
              <?php else : ?>
              <?php get_template_part( 'content', 'none' ); ?>
              <?php endif; ?>
            </div>
            <!-- #blog-list-wrap -->
          </div>
          <!-- #page-content -->
          <div class="post-attributes"></div>
        </section>
        <!-- #page-main -->
      </div>
      <!-- #col-main -->
      <?php if( $sidebar == 'left' || $sidebar == 'both'  ): ?>
      <div class="col-aside-left">
        <aside class="blog-side left text-left">
          <div class="widget-area">
            <?php get_sidebar('searchleft');?>
          </div>
        </aside>
      </div>
      <?php endif; ?>
      <?php if( $sidebar == 'right' || $sidebar == 'both'  ): ?>
      <div class="col-aside-right">
        <div class="widget-area">
          <?php get_sidebar('searchright');?>
        </div>
      </div>
      <?php endif; ?>
      <!-- #col-side -->
    </div>
    <!-- #page-inner -->
  </div>
  <!-- #container -->
</div>
<!-- #page-wrap -->
<?php get_footer(); ?>
