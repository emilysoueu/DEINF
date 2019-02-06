<?php
/**
 * Display single product reviews (comments)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product-reviews.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.2.0
 */
global $product;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! comments_open() ) {
	return;
}

?>


<div id="reviews" class="row">
    <div id="comments" class="col-md-6">
        <h3><?php
			if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' && ( $count = $product->get_review_count() ) )
				printf( esc_html( _n( '%1$s review for %2$s', '%1$s reviews for %2$s', $count, 'onetone' ) ), esc_html( $count ), '<span>' . get_the_title() . '</span>' );
			else
				_e( 'Reviews', 'onetone' );
		?></h3>
        <?php if ( have_comments() ) : ?>
        <ol class="commentlist">
           <?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); ?>
        </ol>
        <?php else : ?>

			<p class="woocommerce-noreviews"><?php _e( 'There are no reviews yet.', 'onetone' ); ?></p>

		<?php endif; ?>
    </div>
    <?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>
    <div id="review_form_wrapper" class="col-md-6">
        <div id="review_form">
            <?php
					$commenter = wp_get_current_commenter();

					$comment_form = array(
						'title_reply'          => have_comments() ? __( 'Add a review', 'onetone' ) : __( 'Be the first to review', 'onetone' ) . ' &ldquo;' . get_the_title() . '&rdquo;',
						'title_reply_to'       => __( 'Leave a Reply to %s', 'onetone' ),
						'comment_notes_before' => '',
						'comment_notes_after'  => '',
						'fields'               => array(
							'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name', 'onetone' ) . ' <span class="required">*</span></label> ' .
							            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true" /></p>',
							'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email', 'onetone' ) . ' <span class="required">*</span></label> ' .
							            '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-required="true" /></p>',
						),
						'label_submit'  => __( 'Submit', 'onetone' ),
						'logged_in_as'  => '',
						'comment_field' => ''
					);

					if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
						$comment_form['comment_field'] = '<p class="comment-form-rating"><label for="rating">' . __( 'Your Rating', 'onetone' ) .'</label><select name="rating" id="rating">
							<option value="">' . __( 'Rate&hellip;', 'onetone' ) . '</option>
							<option value="5">' . __( 'Perfect', 'onetone' ) . '</option>
							<option value="4">' . __( 'Good', 'onetone' ) . '</option>
							<option value="3">' . __( 'Average', 'onetone' ) . '</option>
							<option value="2">' . __( 'Not that bad', 'onetone' ) . '</option>
							<option value="1">' . __( 'Very Poor', 'onetone' ) . '</option>
						</select></p>';
					}

					$comment_form['comment_field'] .= '<p class="comment-form-comment"><label for="comment">' . __( 'Your Review', 'onetone' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>';

					comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
				?><!-- #respond -->
        </div>
    </div>
    <?php else : ?>

		<p class="woocommerce-verification-required"><?php _e( 'Only logged in customers who have purchased this product may leave a review.', 'onetone' ); ?></p>

	<?php endif; ?>

    <div class="clearfix"></div>
</div>