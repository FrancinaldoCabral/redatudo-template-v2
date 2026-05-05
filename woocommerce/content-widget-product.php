<?php
/**
 * The template for displaying product widget entries.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-widget-product.php.
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.5
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

if ( ! is_a( $product, 'WC_Product' ) ) {
	return;
}

?>

<style>
.woo-widget-product {
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

.woo-widget-product:hover {
  border-color: rgba(124, 58, 237, 0.5);
  box-shadow: 0 4px 12px rgba(124, 58, 237, 0.2);
  transform: translateX(4px);
  text-decoration: none;
}

.woo-widget-product-image {
  flex-shrink: 0;
  width: 60px;
  height: 60px;
  border-radius: 8px;
  overflow: hidden;
  background: rgba(17, 24, 39, 0.8);
}

.woo-widget-product-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.woo-widget-product-info {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 0.25rem;
}

.woo-widget-product-title {
  font-family: 'Inter', sans-serif;
  font-size: 0.95rem;
  font-weight: 600;
  color: #FFFFFF;
  line-height: 1.3;
  margin: 0;
}

.woo-widget-product-price {
  font-family: 'Outfit', sans-serif;
  font-size: 1rem;
  font-weight: 700;
  color: #A78BFA;
}

.woo-widget-product-rating {
  font-size: 0.75rem;
  color: #FBBF24;
}
</style>

<li>
  <?php do_action( 'woocommerce_widget_product_item_start', $args ); ?>

  <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="woo-widget-product">
    <div class="woo-widget-product-image">
      <?php echo $product->get_image(); // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
    </div>
    
    <div class="woo-widget-product-info">
      <span class="woo-widget-product-title"><?php echo wp_kses_post( $product->get_name() ); ?></span>
      
      <?php if ( ! empty( $show_rating ) ) : ?>
        <div class="woo-widget-product-rating">
          <?php echo wc_get_rating_html( $product->get_average_rating() ); // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        </div>
      <?php endif; ?>
      
      <div class="woo-widget-product-price">
        <?php echo $product->get_price_html(); // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
      </div>
    </div>
  </a>

  <?php do_action( 'woocommerce_widget_product_item_end', $args ); ?>
</li>
