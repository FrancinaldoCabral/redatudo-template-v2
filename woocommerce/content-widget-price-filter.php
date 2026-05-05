<?php
/**
 * The template for displaying product price filter widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-widget-price-filter.php
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.7.1
 */

defined( 'ABSPATH' ) || exit;

?>

<style>
.woo-price-filter-widget {
  background: linear-gradient(145deg, rgba(31, 41, 55, 0.8) 0%, rgba(17, 24, 39, 0.8) 100%);
  border: 2px solid rgba(75, 85, 99, 0.3);
  border-radius: 16px;
  padding: 1.5rem;
}

.woo-price-filter-wrapper {
  margin-bottom: 1.5rem;
}

.woo-price-slider {
  margin-bottom: 1.5rem;
}

.woo-price-inputs {
  display: flex;
  gap: 1rem;
  margin-bottom: 1.5rem;
}

.woo-price-input-group {
  flex: 1;
}

.woo-price-input-group label {
  display: block;
  font-family: 'Inter', sans-serif;
  font-size: 0.875rem;
  font-weight: 600;
  color: #D1D5DB;
  margin-bottom: 0.5rem;
}

.woo-price-input-group input {
  width: 100%;
  background: rgba(17, 24, 39, 0.8);
  border: 2px solid rgba(75, 85, 99, 0.3);
  border-radius: 10px;
  padding: 0.75rem;
  font-size: 1rem;
  color: #FFFFFF;
  font-family: 'Inter', sans-serif;
  transition: all 0.3s ease;
}

.woo-price-input-group input:focus {
  outline: none;
  border-color: rgba(124, 58, 237, 0.5);
  box-shadow: 0 4px 12px rgba(124, 58, 237, 0.2);
}

.woo-price-filter-button {
  width: 100%;
  background: linear-gradient(135deg, #7C3AED 0%, #3B82F6 100%);
  color: #FFFFFF;
  border: none;
  padding: 0.875rem 1.5rem;
  border-radius: 10px;
  font-weight: 700;
  font-size: 1rem;
  cursor: pointer;
  transition: all 0.3s ease;
  font-family: 'Inter', sans-serif;
  box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3);
}

.woo-price-filter-button:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(124, 58, 237, 0.4);
  filter: brightness(1.1);
}

.woo-price-label {
  text-align: center;
  font-family: 'Outfit', sans-serif;
  font-size: 1.125rem;
  font-weight: 600;
  color: #A78BFA;
  margin-bottom: 1rem;
}

.woo-price-label .from,
.woo-price-label .to {
  color: #FFFFFF;
  font-weight: 700;
}
</style>

<?php do_action( 'woocommerce_widget_price_filter_start', $args ); ?>

<div class="woo-price-filter-widget">
  <form method="get" action="<?php echo esc_url( $form_action ); ?>">
    <div class="woo-price-filter-wrapper price_slider_wrapper">
      <div class="woo-price-slider price_slider" style="display:none;"></div>
      
      <div class="woo-price-inputs price_slider_amount" data-step="<?php echo esc_attr( $step ); ?>">
        
        <div class="woo-price-label price_label">
          <span>Preço: </span>
          <span class="from"></span>
          <span> — </span>
          <span class="to"></span>
        </div>
        
        <div class="woo-price-inputs">
          <div class="woo-price-input-group">
            <label for="min_price">Preço Mínimo</label>
            <input 
              type="text" 
              id="min_price" 
              name="min_price" 
              value="<?php echo esc_attr( $current_min_price ); ?>" 
              data-min="<?php echo esc_attr( $min_price ); ?>" 
              placeholder="<?php echo esc_attr__( 'R$ Min', 'woocommerce' ); ?>" 
            />
          </div>
          
          <div class="woo-price-input-group">
            <label for="max_price">Preço Máximo</label>
            <input 
              type="text" 
              id="max_price" 
              name="max_price" 
              value="<?php echo esc_attr( $current_max_price ); ?>" 
              data-max="<?php echo esc_attr( $max_price ); ?>" 
              placeholder="<?php echo esc_attr__( 'R$ Max', 'woocommerce' ); ?>" 
            />
          </div>
        </div>
        
        <?php echo wc_query_string_form_fields( null, array( 'min_price', 'max_price', 'paged' ), '', true ); ?>
        
        <button type="submit" class="woo-price-filter-button button">
          <?php echo esc_html__( 'Filtrar Preços', 'woocommerce' ); ?>
        </button>
        
        <div class="clear"></div>
      </div>
    </div>
  </form>
</div>

<?php do_action( 'woocommerce_widget_price_filter_end', $args ); ?>
