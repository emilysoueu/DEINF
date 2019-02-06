<div class="entry-box-wrap" id="post-<?php the_ID(); ?>">
    <article class="entry-box" role="article">
    <?php if (  has_post_thumbnail() ): ?>
        <div class="feature-img-box">
            <div class="img-box figcaption-middle text-center from-top fade-in">
                <a href="<?php the_permalink();?>">
                    <?php the_post_thumbnail();?>
                    <div class="img-overlay dark">
                        <div class="img-overlay-container">
                            <div class="img-overlay-content">
                                <i class="fa fa-link"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>                                                 
        </div>
        <?php endif;?>
        <div class="entry-main">
            <div class="entry-header">
                <h2 class="entry-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
                <ul class="entry-meta">
                    <li class="entry-date updated"><i class="fa fa-calendar"></i><a href="<?php echo esc_url(get_month_link(get_the_time('Y'), get_the_time('m')));?>"><?php echo get_the_date("M d, Y");?></a></li>
                    <li class="entry-author author vcard"><i class="fa fa-user"></i> <span class="fn"><?php echo get_the_author_link();?></span></li>
                    <li class="entry-catagory"><i class="fa fa-file-o"></i><?php the_category(', '); ?></li>
                    <li class="entry-comments"><i class="fa fa-comment"></i><a href="<?php the_permalink();?>#comments"><?php  comments_popup_link( esc_attr__('No comments yet','onetone'), esc_attr__('1 comment','onetone'), esc_attr__('% comments','onetone'), 'comments-link', '');?></a></li>
                </ul>
            </div>
            <div class="entry-summary">
               <?php echo onetone_get_summary(); ?>
            </div>
            <div class="entry-footer">
                <a href="<?php the_permalink();?>" class="entry-more pull-right"><?php esc_attr_e("Read More","onetone");?> &gt;&gt;</a>
            </div>
        </div>
    </article>
</div>