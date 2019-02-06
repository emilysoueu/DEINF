<?php
/**
* The archive template file.
*
*/
get_header(); 

$left_sidebar   = onetone_option('left_sidebar_blog_archive');
$right_sidebar  = onetone_option('right_sidebar_blog_archive');
$page_title_position    = onetone_option( 'page_title_position' );
if( $page_title_position == '' )
	$page_title_position = 'left';
	
$aside          = 'no-aside';
if( $left_sidebar !='' )
$aside          = 'left-aside';
if( $right_sidebar !='' )
$aside          = 'right-aside';
if(  $left_sidebar !='' && $right_sidebar !='' )
$aside          = 'both-aside';

?>

  <section class="page-title-bar title-<?php echo esc_attr($page_title_position); ?> no-subtitle">
    <div class="container">
      <hgroup class="page-title">
        <h1>
        <?php single_cat_title();?>
        </h1>
      </hgroup>
      
   <?php onetone_breadcrumbs();?>
      <div class="clearfix"></div>
    </div>
  </section>

<div class="post-wrap">
            <div class="container">
                <div class="post-inner row <?php echo $aside; ?>">
                    <div class="col-main">
                        <section class="post-main" role="main" id="content">                        
                            <article class="page type-page" role="article">
                            <?php if (have_posts()) :?>
                                <!--blog list begin-->
                                <div class="blog-list-wrap">
                                
                                <?php while ( have_posts() ) : the_post();?>
                                <?php get_template_part("content",get_post_format()); ?>
                                <?php endwhile;?>
                                </div>
                                <?php endif;?>
                                <!--blog list end-->
                                <!--list pagination begin-->
                                <nav class="post-list-pagination" role="navigation">
                                    <?php
											 the_posts_pagination( array(
											 'mid_size' => 3,
												'prev_text' => '<i class="fa fa-angle-double-left"></i><span class="screen-reader-text">' . __( 'Previous page', 'onetone' ) . '</span>',
												'next_text' => '<span class="screen-reader-text">' . __( 'Next page', 'onetone' ) . '</span><i class="fa fa-angle-double-right"></i>' ,
												'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'onetone' ) . ' </span>',
											) );
										
									?>
                                </nav>
                                <!--list pagination end-->
                            </article>
                            
                            
                            <div class="post-attributes"></div>
                        </section>
                    </div>
                    <?php if( $left_sidebar !='' ):?>
                    <div class="col-aside-left">
                        <aside class="blog-side left text-left">
                            <div class="widget-area">
                                <?php get_sidebar('archiveleft');?> 
                            </div>
                        </aside>
                    </div>
                    <?php endif; ?>
                    <?php if( $right_sidebar !='' ):?>
                    <div class="col-aside-right">
                       <?php get_sidebar('archiveright');?>
                    </div>
                    <?php endif; ?>
                    
                </div>
            </div>  
        </div>
        
 <?php get_footer();