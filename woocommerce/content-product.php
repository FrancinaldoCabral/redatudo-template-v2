<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

$is_featured = $product->is_featured();
$is_on_sale = $product->is_on_sale();
?>

<style>
.woo-product-card {
  background: linear-gradient(145deg, rgba(31, 41, 55, 0.5) 0%, rgba(17, 24, 39, 0.5) 100%);
  backdrop-filter: blur(20px);
  border: 1px solid rgba(75, 85, 99, 0.3);
  border-radius: 24px;
  padding: 2rem;
  position: relative;
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  cursor: pointer;
  text-decoration: none;
  display: flex;
  flex-direction: column;
  height: 100%;
}

.woo-product-card::before {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(135deg, 
    rgba(124, 58, 237, 0.08) 0%, 
    rgba(59, 130, 246, 0.02) 50%,
    transparent 100%
  );
  opacity: 0;
  transition: opacity 0.4s ease;
  border-radius: 24px;
  pointer-events: none;
  z-index: 0;
}

.woo-product-card:hover::before {
  opacity: 1;
}

.woo-product-card:hover {
  border-color: rgba(124, 58, 237, 0.5);
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4), 0 0 0 1px rgba(124, 58, 237, 0.3);
  transform: translateY(-8px);
  text-decoration: none;
  background: linear-gradient(145deg, rgba(31, 41, 55, 0.8) 0%, rgba(17, 24, 39, 0.8) 100%);
}

.woo-product-badge {
  position: absolute;
  top: 1rem;
  right: 1rem;
  padding: 0.5rem 1rem;
  border-radius: 20px;
  font-size: 0.75rem;
  font-weight: 700;
  z-index: 10;
  font-family: 'Inter', sans-serif;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.woo-badge-sale {
  background: linear-gradient(135deg, #F59E0B 0%, #DC2626 100%);
  color: #FFFFFF;
}

.woo-badge-featured {
  background: linear-gradient(135deg, #3B82F6 0%, #1D4ED8 100%);
  color: #FFFFFF;
}

.woo-product-inner {
  position: relative;
  z-index: 1;
  flex: 1;
  display: flex;
  flex-direction: column;
}

.woo-product-image {
  width: 100%;
  aspect-ratio: 1;
  border-radius: 16px;
  overflow: hidden;
  margin-bottom: 1.5rem;
  background: rgba(17, 24, 39, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
}

.woo-product-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.3s ease;
}

.woo-product-card:hover .woo-product-image img {
  transform: scale(1.05);
}

.woo-product-title {
  font-size: 1.5rem;
  font-weight: 700;
  color: #FFFFFF;
  margin-bottom: 0.75rem;
  font-family: 'Outfit', sans-serif;
  letter-spacing: -0.01em;
  line-height: 1.2;
}

.woo-product-title a {
  color: #FFFFFF;
  text-decoration: none;
  transition: color 0.2s;
}

.woo-product-title a:hover {
  color: #A78BFA;
}

.woo-product-description {
  color: #D1D5DB;
  font-size: 1rem;
  line-height: 1.6;
  margin-bottom: 1.5rem;
  font-family: 'Inter', sans-serif;
  flex: 1;
}

.woo-product-price {
  font-family: 'Outfit', sans-serif;
  font-size: 2rem;
  font-weight: 700;
  margin-bottom: 1.5rem;
}

.woo-product-price .amount {
  background: linear-gradient(135deg, #A78BFA 0%, #60A5FA 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.woo-product-price del {
  color: #9CA3AF;
  font-size: 1.25rem;
  margin-right: 0.5rem;
  font-weight: 400;
}

.woo-product-rating {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  margin-bottom: 1rem;
  font-family: 'Inter', sans-serif;
}

.woo-product-rating .star-rating {
  color: #FBBF24;
}

.woo-product-rating .rating-count {
  color: #9CA3AF;
  font-size: 0.875rem;
}

.woo-product-button {
  width: 100%;
  padding: 1rem 1.5rem;
  background: linear-gradient(135deg, #7C3AED 0%, #3B82F6 100%);
  color: #FFFFFF;
  border: none;
  border-radius: 12px;
  font-weight: 700;
  font-size: 1.05rem;
  cursor: pointer;
  transition: all 0.3s ease;
  font-family: 'Inter', sans-serif;
  text-decoration: none;
  display: block;
  text-align: center;
  box-shadow: 0 4px 16px rgba(124, 58, 237, 0.3);
}

.woo-product-button:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(124, 58, 237, 0.4);
  color: #FFFFFF;
  text-decoration: none;
  filter: brightness(1.1);
}

.woo-product-categories {
  display: flex;
  flex-wrap: wrap;
  gap: 0.5rem;
  margin-bottom: 1rem;
}

.woo-product-category {
  background: rgba(124, 58, 237, 0.15);
  color: #C4B5FD;
  padding: 0.25rem 0.75rem;
  border-radius: 12px;
  font-size: 0.75rem;
  font-weight: 600;
  font-family: 'Inter', sans-serif;
  border: 1px solid rgba(124, 58, 237, 0.3);
}
</style>

<div class="woo-product-card">
  <?php if ( $is_on_sale ) : ?>
    <span class="woo-product-badge woo-badge-sale">🔥 Promoção</span>
  <?php elseif ( $is_featured ) : ?>
    <span class="woo-product-badge woo-badge-featured">⭐ Destaque</span>
  <?php endif; ?>

  <div class="woo-product-inner">
    <?php
    /**
     * Hook: woocommerce_before_shop_loop_item.
     *
     * @hooked woocommerce_template_loop_product_link_open - 10
     */
    do_action( 'woocommerce_before_shop_loop_item' );
    ?>

    <div class="woo-product-image">
      <?php
      /**
       * Hook: woocommerce_before_shop_loop_item_title.
       *
       * @hooked woocommerce_show_product_loop_sale_flash - 10
       * @hooked woocommerce_template_loop_product_thumbnail - 10
       */
      do_action( 'woocommerce_before_shop_loop_item_title' );
      ?>
    </div>

    <h3 class="woo-product-title">
      <?php
      /**
       * Hook: woocommerce_shop_loop_item_title.
       *
       * @hooked woocommerce_template_loop_product_title - 10
       */
      do_action( 'woocommerce_shop_loop_item_title' );
      ?>
    </h3>

    <?php if ( $product->get_short_description() ) : ?>
      <div class="woo-product-description">
        <?php echo wp_trim_words( $product->get_short_description(), 20, '...' ); ?>
      </div>
    <?php endif; ?>

    <?php
    $categories = get_the_terms( $product->get_id(), 'product_cat' );
    if ( $categories && ! is_wp_error( $categories ) ) :
    ?>
      <div class="woo-product-categories">
        <?php foreach ( array_slice( $categories, 0, 2 ) as $category ) : ?>
          <span class="woo-product-category"><?php echo esc_html( $category->name ); ?></span>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <?php
    /**
     * Hook: woocommerce_after_shop_loop_item_title.
     *
     * @hooked woocommerce_template_loop_rating - 5
     * @hooked woocommerce_template_loop_price - 10
     */
    ?>
    <div class="woo-product-rating">
      <?php woocommerce_template_loop_rating(); ?>
    </div>

    <div class="woo-product-price">
      <?php woocommerce_template_loop_price(); ?>
    </div>

    <?php
    /**
     * Hook: woocommerce_after_shop_loop_item.
     *
     * @hooked woocommerce_template_loop_product_link_close - 5
     * @hooked woocommerce_template_loop_add_to_cart - 10
     */
    do_action( 'woocommerce_after_shop_loop_item' );
    ?>
  </div>
</div>
