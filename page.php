<?php
/**
 * The template for displaying all single posts.
 *
 * @package onetone
 */

get_header(); 


global $onetone_page_meta;
$enable_page_title_bar     = onetone_option('enable_page_title_bar');
$display_title_bar_title   = onetone_option('display_title_bar_title' );

$page_title_position    = onetone_option( 'page_title_position' );
if( $page_title_position == '' )
	$page_title_position = 'left';

$sidebar                   = isset($onetone_page_meta['page_layout'])?$onetone_page_meta['page_layout']:'none';
$left_sidebar              = isset($onetone_page_meta['left_sidebar'])?$onetone_page_meta['left_sidebar']:'';
$right_sidebar             = isset($onetone_page_meta['right_sidebar'])?$onetone_page_meta['right_sidebar']:'';
$full_width                = isset($onetone_page_meta['full_width'])?$onetone_page_meta['full_width']:'no';

$display_title             = isset($onetone_page_meta['display_title'])?$onetone_page_meta['display_title']:'yes';

$enable_page_title_bar     = (isset($onetone_page_meta['display_title_bar']) && $onetone_page_meta['display_title_bar']!='')?$onetone_page_meta['display_title_bar']:$enable_page_title_bar;


if( $full_width  == 'no' )
	$container = 'container';
else
	$container = 'container-fullwidth';
 
$aside = 'no-aside';
if( $sidebar =='left' )
	$aside = 'left-aside';
	
if( $sidebar =='right' )
	$aside = 'right-aside';
	
if(  $sidebar =='both' )
	$aside = 'both-aside';

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">

<?php if( $enable_page_title_bar == 'yes' || $enable_page_title_bar == '1'  ):?>

  <section class="page-title-bar title-<?php echo esc_attr($page_title_position); ?> no-subtitle">
    <div class="container">
    <?php if($display_title_bar_title == 1 ):?>
      <hgroup class="page-title">
        <h1>
          <?php the_title();?>
        </h1>
      </hgroup>
      <?php endif;?>
   <?php onetone_breadcrumbs();?>
      <div class="clearfix"></div>
    </div>
  </section>
 
  <?php endif;?>
  
  <div class="post-wrap">
    <div class="<?php echo $container;?>">
      <div class="post-inner row <?php echo $aside; ?>">
        <div class="col-main">
          <section class="post-main" role="main" id="content">
            <?php while ( have_posts() ) : the_post(); ?>
            <article class="post type-post" role="article">
              <?php if (  has_post_thumbnail() ): ?>
              <div class="feature-img-box">
                <div class="img-box">
                  <?php the_post_thumbnail();?>
                </div>
              </div>
              <?php endif;?>
              <div class="entry-main">
            
                <div class="entry-content">
                  <?php the_content();?>
                  <?php
				wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'onetone' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
				?>
                </div>
                
              </div>
            </article>
            <div class="post-attributes">
              <!--Comments Area-->
              <div class="comments-area text-left">
                <?php
					  // If comments are open or we have at least one comment, load up the comment template
					  if ( comments_open()  ) :
						  comments_template();
					  endif;
				  ?>
              </div>
              <!--Comments End-->
            </div>
            <?php endwhile; // end of the loop. ?>
          </section>
        </div>
        <?php if(  $sidebar =='left' || $sidebar =='both' ):?>
        <div class="col-aside-left">
          <aside class="blog-side left text-left">
            <div class="widget-area">
              <?php get_sidebar('pageleft');?>
            </div>
          </aside>
        </div>
        <?php endif; ?>
        <?php if(  $sidebar =='right' || $sidebar =='both' ):?>
        <div class="col-aside-right">
          <?php get_sidebar('pageright');?>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</article>
<?php get_footer();