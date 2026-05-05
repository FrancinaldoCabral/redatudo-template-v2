<?php
/**
 * The template for displaying product search form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/product-searchform.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<style>
.woo-search-form {
  position: relative;
  max-width: 600px;
  margin: 0 auto;
}

.woo-search-wrapper {
  position: relative;
  display: flex;
  align-items: center;
  background: linear-gradient(145deg, rgba(31, 41, 55, 0.8) 0%, rgba(17, 24, 39, 0.8) 100%);
  border: 2px solid rgba(75, 85, 99, 0.3);
  border-radius: 16px;
  padding: 0.5rem;
  transition: all 0.3s ease;
  backdrop-filter: blur(20px);
}

.woo-search-wrapper:focus-within {
  border-color: rgba(124, 58, 237, 0.5);
  box-shadow: 0 8px 24px rgba(124, 58, 237, 0.2);
  background: linear-gradient(145deg, rgba(31, 41, 55, 0.95) 0%, rgba(17, 24, 39, 0.95) 100%);
}

.woo-search-icon {
  position: absolute;
  left: 1.25rem;
  color: #9CA3AF;
  font-size: 1.25rem;
  pointer-events: none;
  z-index: 1;
}

.woo-search-field {
  flex: 1;
  background: transparent;
  border: none;
  padding: 1rem 1rem 1rem 3.5rem;
  font-size: 1.05rem;
  color: #FFFFFF;
  font-family: 'Inter', sans-serif;
  outline: none;
  width: 100%;
}

.woo-search-field::placeholder {
  color: #9CA3AF;
}

.woo-search-button {
  background: linear-gradient(135deg, #7C3AED 0%, #3B82F6 100%);
  color: #FFFFFF;
  border: none;
  padding: 0.875rem 2rem;
  border-radius: 12px;
  font-weight: 700;
  font-size: 1rem;
  cursor: pointer;
  transition: all 0.3s ease;
  font-family: 'Inter', sans-serif;
  box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3);
  white-space: nowrap;
}

.woo-search-button:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(124, 58, 237, 0.4);
  filter: brightness(1.1);
}

.woo-search-button:active {
  transform: translateY(0);
}

@media (max-width: 768px) {
  .woo-search-field {
    font-size: 0.95rem;
    padding: 0.875rem 0.875rem 0.875rem 3rem;
  }
  
  .woo-search-button {
    padding: 0.875rem 1.25rem;
    font-size: 0.9rem;
  }
  
  .woo-search-icon {
    left: 1rem;
    font-size: 1.1rem;
  }
}
</style>

<form role="search" method="get" class="woo-search-form woocommerce-product-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
  <label class="screen-reader-text" for="woocommerce-product-search-field-<?php echo isset( $index ) ? absint( $index ) : 0; ?>">
    <?php esc_html_e( 'Search for:', 'woocommerce' ); ?>
  </label>
  
  <div class="woo-search-wrapper">
    <span class="woo-search-icon">🔍</span>
    
    <input 
      type="search" 
      id="woocommerce-product-search-field-<?php echo isset( $index ) ? absint( $index ) : 0; ?>" 
      class="woo-search-field search-field" 
      placeholder="<?php echo esc_attr__( 'Buscar planos e créditos...', 'woocommerce' ); ?>" 
      value="<?php echo get_search_query(); ?>" 
      name="s" 
      autocomplete="off"
    />
    
    <button type="submit" class="woo-search-button" value="<?php echo esc_attr_x( 'Search', 'submit button', 'woocommerce' ); ?>">
      <?php echo esc_html_x( 'Buscar', 'submit button', 'woocommerce' ); ?>
    </button>
    
    <input type="hidden" name="post_type" value="product" />
  </div>
</form>
