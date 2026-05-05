<?php
defined( 'ABSPATH' ) || exit;
do_action( 'woocommerce_before_cart' );
?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap');

.woo-cart-section {
  background: #0F0F1A;
  min-height: 100vh;
  padding: 3rem 0;
}

.woo-cart-container {
  max-width: 1000px;
  margin: 0 auto;
  padding: 0 1rem;
}

.woo-cart-title {
  font-size: clamp(2rem, 4vw, 2.75rem);
  font-family: 'Outfit', sans-serif;
  font-weight: 700;
  text-align: center;
  margin-bottom: 2.5rem;
  letter-spacing: -0.02em;
}

.woo-cart-title .gradient-text {
  background: linear-gradient(135deg, #A78BFA 0%, #60A5FA 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.woo-cart-item {
  background: linear-gradient(145deg, rgba(31, 41, 55, 0.8) 0%, rgba(17, 24, 39, 0.8) 100%);
  border: 2px solid rgba(75, 85, 99, 0.3);
  border-radius: 20px;
  padding: 1.75rem;
  margin-bottom: 1.25rem;
  display: flex;
  align-items: center;
  gap: 1.5rem;
  transition: all 0.3s ease;
}

.woo-cart-item:hover {
  border-color: rgba(124, 58, 237, 0.5);
  box-shadow: 0 8px 24px rgba(124, 58, 237, 0.2);
}

.woo-cart-item-remove {
  flex: 0 0 40px;
  text-align: center;
}

.woo-cart-item-remove a {
  font-size: 2rem;
  color: #F87171;
  text-decoration: none;
  transition: all 0.2s;
  display: inline-block;
  line-height: 1;
}

.woo-cart-item-remove a:hover {
  color: #DC2626;
  transform: scale(1.2);
}

.woo-cart-item-details {
  flex: 3 1 250px;
  min-width: 0;
}

.woo-cart-item-name {
  font-family: 'Outfit', sans-serif;
  font-size: 1.25rem;
  font-weight: 700;
  color: #FFFFFF;
  margin-bottom: 0.5rem;
  line-height: 1.3;
}

.woo-cart-item-name a {
  color: #A78BFA;
  text-decoration: none;
  transition: color 0.2s;
}

.woo-cart-item-name a:hover {
  color: #60A5FA;
}

.woo-cart-item-meta {
  font-family: 'Inter', sans-serif;
  font-size: 0.95rem;
  color: #D1D5DB;
  margin-top: 0.5rem;
}

.woo-cart-item-price {
  flex: 1 0 100px;
  font-family: 'Outfit', sans-serif;
  font-size: 1.25rem;
  font-weight: 700;
  color: #10B981;
  text-align: right;
}

.woo-cart-item-quantity {
  flex: 0 0 100px;
  text-align: center;
}

.woo-cart-item-quantity input[type="number"] {
  width: 80px;
  background: rgba(17, 24, 39, 0.8);
  border: 2px solid rgba(75, 85, 99, 0.3);
  border-radius: 12px;
  padding: 0.625rem 0.5rem;
  font-size: 1.05rem;
  color: #FFFFFF;
  font-family: 'Outfit', sans-serif;
  font-weight: 600;
  text-align: center;
  transition: all 0.3s ease;
}

.woo-cart-item-quantity input[type="number"]:focus {
  outline: none;
  border-color: rgba(124, 58, 237, 0.5);
  box-shadow: 0 4px 12px rgba(124, 58, 237, 0.2);
}

.woo-cart-item-subtotal {
  flex: 1 0 110px;
  font-family: 'Outfit', sans-serif;
  font-size: 1.4rem;
  font-weight: 700;
  background: linear-gradient(135deg, #A78BFA 0%, #60A5FA 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  text-align: right;
}

.woo-cart-actions {
  display: flex;
  gap: 1rem;
  align-items: center;
  margin: 2rem 0;
  padding: 1.5rem;
  background: linear-gradient(145deg, rgba(31, 41, 55, 0.6) 0%, rgba(17, 24, 39, 0.6) 100%);
  border: 2px solid rgba(75, 85, 99, 0.3);
  border-radius: 16px;
  flex-wrap: wrap;
}

.woo-cart-coupon-group {
  display: flex;
  gap: 0.75rem;
  align-items: center;
  flex: 1 1 300px;
}

.woo-cart-coupon-group input[type="text"] {
  flex: 1;
  max-width: 200px;
  background: rgba(17, 24, 39, 0.8);
  border: 2px solid rgba(75, 85, 99, 0.3);
  border-radius: 12px;
  padding: 0.75rem 1rem;
  font-size: 1rem;
  color: #FFFFFF;
  font-family: 'Inter', sans-serif;
  transition: all 0.3s ease;
}

.woo-cart-coupon-group input[type="text"]:focus {
  outline: none;
  border-color: rgba(124, 58, 237, 0.5);
  box-shadow: 0 4px 12px rgba(124, 58, 237, 0.2);
}

.woo-cart-coupon-group button,
.woo-cart-update-btn {
  background: linear-gradient(135deg, #6366F1 0%, #3B82F6 100%);
  color: #FFFFFF;
  border: none;
  padding: 0.75rem 1.75rem;
  border-radius: 12px;
  font-weight: 700;
  font-size: 1rem;
  cursor: pointer;
  transition: all 0.3s ease;
  font-family: 'Inter', sans-serif;
  box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
  white-space: nowrap;
}

.woo-cart-coupon-group button:hover,
.woo-cart-update-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(99, 102, 241, 0.4);
  filter: brightness(1.1);
}

.woo-cart-summary {
  background: linear-gradient(145deg, rgba(31, 41, 55, 0.95) 0%, rgba(17, 24, 39, 0.95) 100%);
  border: 2px solid rgba(124, 58, 237, 0.4);
  border-radius: 24px;
  padding: 2.5rem;
  margin-top: 2.5rem;
  text-align: center;
  box-shadow: 0 12px 32px rgba(124, 58, 237, 0.25);
}

.woo-cart-total {
  font-family: 'Outfit', sans-serif;
  font-size: 1.125rem;
  font-weight: 600;
  color: #D1D5DB;
  margin-bottom: 1rem;
}

.woo-cart-total-amount {
  font-family: 'Outfit', sans-serif;
  font-size: 3rem;
  font-weight: 800;
  background: linear-gradient(135deg, #10B981 0%, #059669 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  margin-bottom: 2rem;
  display: block;
}

.woo-cart-checkout-btn {
  display: inline-block;
  background: linear-gradient(135deg, #10B981 0%, #059669 100%);
  color: #FFFFFF !important;
  border: none;
  padding: 1.25rem 3rem;
  border-radius: 16px;
  font-weight: 700;
  font-size: 1.25rem;
  cursor: pointer;
  transition: all 0.3s ease;
  font-family: 'Inter', sans-serif;
  box-shadow: 0 8px 24px rgba(16, 185, 129, 0.4);
  text-decoration: none !important;
}

.woo-cart-checkout-btn:hover {
  transform: translateY(-3px) scale(1.02);
  box-shadow: 0 12px 32px rgba(16, 185, 129, 0.5);
  color: #FFFFFF !important;
  text-decoration: none !important;
}

.woo-cart-empty {
  text-align: center;
  padding: 4rem 2rem;
  background: linear-gradient(145deg, rgba(31, 41, 55, 0.8) 0%, rgba(17, 24, 39, 0.8) 100%);
  border: 2px solid rgba(75, 85, 99, 0.3);
  border-radius: 24px;
  max-width: 600px;
  margin: 0 auto;
}

.woo-cart-empty-icon {
  font-size: 5rem;
  margin-bottom: 1.5rem;
}

.woo-cart-empty h2 {
  font-family: 'Outfit', sans-serif;
  font-size: 2rem;
  color: #FFFFFF;
  margin-bottom: 1rem;
}

.woo-cart-empty p {
  font-family: 'Inter', sans-serif;
  font-size: 1.125rem;
  color: #D1D5DB;
  margin-bottom: 2rem;
}

.woo-cart-spinner {
  display: inline-block;
  vertical-align: middle;
  margin-right: 0.7rem;
  width: 1.3rem;
  height: 1.3rem;
  border: 3px solid rgba(255, 255, 255, 0.3);
  border-top: 3px solid #FFFFFF;
  border-radius: 50%;
  animation: woo-spin 0.8s linear infinite;
}

@keyframes woo-spin {
  100% {
    transform: rotate(360deg);
  }
}

/* Hide default WooCommerce elements */
.woocommerce-cart .cart-collaterals,
.woocommerce-cart .cart_totals,
.woocommerce-cart .proceed-to-checkout {
  display: none !important;
}

@media (max-width: 768px) {
  .woo-cart-item {
    flex-direction: column;
    align-items: flex-start;
    gap: 1rem;
    padding: 1.25rem;
  }

  .woo-cart-item-price,
  .woo-cart-item-subtotal {
    text-align: left;
  }

  .woo-cart-item-quantity {
    text-align: left;
  }

  .woo-cart-actions {
    flex-direction: column;
    align-items: stretch;
  }

  .woo-cart-coupon-group {
    flex-direction: column;
    align-items: stretch;
  }

  .woo-cart-coupon-group input[type="text"] {
    max-width: 100%;
  }

  .woo-cart-summary {
    padding: 1.75rem 1.25rem;
  }

  .woo-cart-total-amount {
    font-size: 2.25rem;
  }
}
</style>

<div class="woo-cart-section">
  <div class="woo-cart-container">
    <h1 class="woo-cart-title">
      <span class="gradient-text">🛒 Seu Carrinho</span>
    </h1>

    <?php if ( WC()->cart->is_empty() ) : ?>
      <div class="woo-cart-empty">
        <div class="woo-cart-empty-icon">🛒</div>
        <h2>Carrinho Vazio</h2>
        <p>Você ainda não adicionou nenhum item ao carrinho.<br>Explore nossas ferramentas!</p>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="woo-cart-checkout-btn">
          Voltar à Loja
        </a>
      </div>
    <?php else : ?>
      
      <form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
        <?php do_action( 'woocommerce_before_cart_table' ); ?>

        <div>
          <?php do_action( 'woocommerce_before_cart_contents' ); ?>

          <?php
          foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
            $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
            $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

            if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) :
              $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
          ?>
              <div class="woo-cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
                
                <div class="woo-cart-item-remove">
                  <?php
                  echo apply_filters(
                    'woocommerce_cart_item_remove_link',
                    sprintf(
                      '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
                      esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                      esc_html__( 'Remover item', 'woocommerce' ),
                      esc_attr( $product_id ),
                      esc_attr( $_product->get_sku() )
                    ),
                    $cart_item_key
                  );
                  ?>
                </div>

                <div class="woo-cart-item-details">
                  <div class="woo-cart-item-name">
                    <?php
                    if ( ! $product_permalink ) {
                      echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) );
                    } else {
                      echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
                    }
                    do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );
                    ?>
                  </div>
                  
                  <?php
                  $item_data = wc_get_formatted_cart_item_data( $cart_item );
                  if ( $item_data ) {
                    echo '<div class="woo-cart-item-meta">' . $item_data . '</div>';
                  }

                  if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
                    echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification" style="color: #FBBF24; font-size: 0.875rem; margin-top: 0.5rem;">' . esc_html__( 'Disponível em pré-venda', 'woocommerce' ) . '</p>', $product_id ) );
                  }
                  ?>
                </div>

                <div class="woo-cart-item-price">
                  <?php echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); ?>
                </div>

                <div class="woo-cart-item-quantity">
                  <?php
                  if ( $_product->is_sold_individually() ) {
                    $product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
                  } else {
                    $product_quantity = woocommerce_quantity_input(
                      array(
                        'input_name'   => "cart[{$cart_item_key}][qty]",
                        'input_value'  => $cart_item['quantity'],
                        'max_value'    => $_product->get_max_purchase_quantity(),
                        'min_value'    => '0',
                        'product_name' => $_product->get_name(),
                      ),
                      $_product,
                      false
                    );
                  }
                  echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
                  ?>
                </div>

                <div class="woo-cart-item-subtotal">
                  <?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?>
                </div>

              </div>
          <?php
            endif;
          endforeach;
          ?>

          <?php do_action( 'woocommerce_cart_contents' ); ?>
        </div>

        <div class="woo-cart-actions">
          <?php if ( wc_coupons_enabled() ) : ?>
            <div class="woo-cart-coupon-group">
              <input type="text" name="coupon_code" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Código do cupom', 'woocommerce' ); ?>" />
              <button type="submit" name="apply_coupon"><?php esc_html_e( 'Aplicar Cupom', 'woocommerce' ); ?></button>
              <?php do_action( 'woocommerce_cart_coupon' ); ?>
            </div>
          <?php endif; ?>
          
          <button type="submit" class="woo-cart-update-btn" name="update_cart" value="<?php esc_attr_e( 'Atualizar carrinho', 'woocommerce' ); ?>">
            <?php esc_html_e( 'Atualizar Carrinho', 'woocommerce' ); ?>
          </button>
          
          <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
        </div>

        <?php do_action( 'woocommerce_after_cart_contents' ); ?>
      </form>

      <div class="woo-cart-summary">
        <?php do_action( 'woocommerce_before_cart_totals' ); ?>
        
        <div class="woo-cart-total">Total do Carrinho:</div>
        <span class="woo-cart-total-amount"><?php wc_cart_totals_order_total_html(); ?></span>
        
        <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="woo-cart-checkout-btn">
          Finalizar Compra →
        </a>
        
        <?php do_action( 'woocommerce_after_cart_totals' ); ?>
      </div>

    <?php endif; ?>
  </div>
</div>

<script>
jQuery(function($){
  var $btn = $('.woo-cart-checkout-btn');
  $btn.on('click', function(e){
    var _btn = $(this);
    if (!_btn.data('loading')) {
      _btn.data('loading', true);
      var originalText = _btn.html();
      _btn.html('<span class="woo-cart-spinner"></span>Processando...');
      
      setTimeout(function(){
        _btn.html(originalText);
        _btn.data('loading', false);
      }, 5000);
    }
  });
});
</script>

<?php do_action( 'woocommerce_after_cart' ); ?>
