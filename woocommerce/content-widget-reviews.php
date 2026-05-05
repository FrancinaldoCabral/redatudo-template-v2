<?php
/**
 * The template for displaying product widget entries.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-widget-reviews.php
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;
?>

<style>
.woo-widget-review {
  display: flex;
  gap: 1rem;
  padding: 1rem;
  background: linear-gradient(145deg, rgba(31, 41, 55, 0.6) 0%, rgba(17, 24, 39, 0.6) 100%);
  border: 1px solid rgba(75, 85, 99, 0.3);
  border-radius: 12px;
  margin-bottom: 0.75rem;
  transition: all 0.3s ease;
  text-decoration: none;
}

.woo-widget-review:hover {
  border-color: rgba(124, 58, 237, 0.5);
  box-shadow: 0 4px 12px rgba(124, 58, 237, 0.2);
  transform: translateX(4px);
  text-decoration: none;
}

.woo-widget-review-image {
  flex-shrink: 0;
  width: 50px;
  height: 50px;
  border-radius: 8px;
  overflow: hidden;
  background: rgba(17, 24, 39, 0.8);
}

.woo-widget-review-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.woo-widget-review-info {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 0.35rem;
}

.woo-widget-review-title {
  font-family: 'Inter', sans-serif;
  font-size: 0.9rem;
  font-weight: 600;
  color: #FFFFFF;
  line-height: 1.3;
  margin: 0;
}

.woo-widget-review-rating {
  font-size: 0.875rem;
  color: #FBBF24;
}

.woo-widget-review-author {
  font-family: 'Inter', sans-serif;
  font-size: 0.8rem;
  color: #9CA3AF;
}
</style>

<li>
  <?php do_action( 'woocommerce_widget_product_review_item_start', $args ); ?>

  <?php
  // phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
  ?>

  <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>" class="woo-widget-review">
    <div class="woo-widget-review-image">
      <?php echo $product->get_image(); ?>
    </div>
    
    <div class="woo-widget-review-info">
      <span class="woo-widget-review-title"><?php echo wp_kses_post( $product->get_name() ); ?></span>
      
      <div class="woo-widget-review-rating">
        <?php echo wc_get_rating_html( intval( get_comment_meta( $comment->comment_ID, 'rating', true ) ) ); ?>
      </div>

      <span class="woo-widget-review-author">
        <?php
        /* translators: %s: Comment author. */
        echo sprintf( esc_html__( 'por %s', 'woocommerce' ), get_comment_author( $comment->comment_ID ) );
        ?>
      </span>
    </div>
  </a>

  <?php
  // phpcs:enable WordPress.Security.EscapeOutput.OutputNotEscaped
  ?>

  <?php do_action( 'woocommerce_widget_product_review_item_end', $args ); ?>
</li>
