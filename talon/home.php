<?php
/**
 * The home template file.
 *
 * @package Talon
 */

get_header(); ?>

<div class="row">
	<div id="primary" class="content-area col-md-8 <?php echo esc_attr(talon_blog_layout()); ?>">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<div class="posts-layout">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'template-parts/content', get_post_format() ); ?>
				<?php endwhile; ?>
			</div>

			<?php the_posts_navigation(); ?>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php 
	if ( talon_blog_layout() == 'list' ) {
		get_sidebar();
	}
?>
</div>
<?php get_footer(); ?>
