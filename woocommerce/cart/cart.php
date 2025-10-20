<?php
defined( 'ABSPATH' ) || exit;
do_action( 'woocommerce_before_cart' );
?>
<style>
:root {
  --roxo-ia: #7f00ff;
  --azul-tech: #00bfff;
  --preto-fundo: #0d0d13;
  --azul-glow: #00ffd0;
}
#redatudo-cart-main {
  max-width: 900px;
  margin: 0 auto;
  padding: 2.5rem 1rem 3.5rem 1rem;
  font-family: 'Orbitron', Arial, sans-serif;
}
.reda-grad-title {
  font-size:2rem;
  font-family: 'Orbitron',Arial,sans-serif;
  font-weight: 700;
  background: linear-gradient(90deg, #00bfff, #7f00ff 70%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  text-align:center;
  margin-bottom:.9em;
}
.redacart-row {
  background: rgba(17,23,39,0.96);
  border-radius: 18px;
  box-shadow: 0 3px 24px #00bfff16, 0 1px 2px #7f00ff10;
  margin: 1.1em 0;
  display: flex;
  align-items: center;
  padding: 1.2em .9em 1.2em 1.2em;
  position: relative;
  gap: 1.4em;
}
.redacart-row .product-remove {
  flex: 0 0 38px; text-align: center; font-size: 1.6em; color: #00ffd0;
}
.redacart-row .product-name {
  flex: 3 1 200px;
  font-size: 1.09em; color: #fff; font-weight: 600;
}
.redacart-row .product-meta {
  color: #b8e6ff; font-size: .99em; margin-top: .2em;
}
.redacart-row .product-price,
.redacart-row .product-quantity,
.redacart-row .product-subtotal {
  flex: 1 0 90px;
  font-size: 1.10em;
  color: #00ffd0;
  text-align: right;
}
.redacart-row .product-quantity input[type="number"] {
  width: 60px; border-radius: 10px; border: 1px solid #22285e; text-align: center; background: #1a1f3f; color:#00ffd0;
  font-family: 'Orbitron', Arial, sans-serif; font-size: 1em; padding: .4em .2em;
}
.redacart-coupon {
  display: flex; gap: .7em; align-items: center; margin: 0.8em 0 2em 0;
  background: rgba(0,255,208,0.06); border-radius: 13px; padding: .7em 1em;
  justify-content: flex-start;
}
.redacart-coupon input[type="text"] {
  border-radius: 13px; border: 1.5px solid #28286e; background: #171727;
  color: #00ffd0; font-family: 'Orbitron', Arial, sans-serif; font-size: 1em;
  padding: .5em 1.1em; width: 130px;
}
.redacart-coupon button, .redacart-update {
  font-family: 'Orbitron', Arial, sans-serif;
  border-radius: 17px;
  font-size: .99rem;
  background: linear-gradient(90deg, #7f00ff 55%, #00bfff 100%);
  border: none; color: #fff; font-weight: bold; padding: .48em 1.6em;
  box-shadow: 0 2px 10px #00bfff30;
  transition: all .16s;
}
.redacart-coupon button:hover, .redacart-update:hover {
  background: linear-gradient(95deg, #00bfff 60%, #7f00ff 100%);
  transform: translateY(-1px) scale(1.02);
}
.redacart-summary {
  background: rgba(23,20,56,0.98);
  border-radius: 18px;
  box-shadow: 0 2px 18px #00bfff24;
  margin: 2.4em 0 0 0;
  padding: 1.7em 1.5em 2.2em 1.5em;
  font-size: 1.09em;
  color: #b8e6ff;
  text-align: center;
  position: relative;
}
.redacart-summary .cart-total {
  font-size: 1.32em;
  font-family: 'Orbitron', Arial, sans-serif;
  color: #00ffd0;
  font-weight: bold;
  margin-bottom: 1.5em;
  display: block;
}
.redacart-summary .checkout-btn {
  display: inline-block;
  background: linear-gradient(90deg, #7f00ff 57%, #00bfff 100%);
  color: #fff !important;
  border-radius: 22px;
  font-family: 'Orbitron', Arial, sans-serif;
  font-weight: bold;
  font-size: 1.16em;
  padding: 1em 2.2em;
  margin-top: 0;
  border: none;
  box-shadow: 0 2px 16px #00bfff50;
  transition: all .19s;
  text-align: center;
  text-decoration: none !important;
}
.redacart-summary .checkout-btn:hover {
  background: linear-gradient(92deg, #00bfff 60%, #7f00ff 100%);
  transform: translateY(-2px) scale(1.03);
  box-shadow: 0 8px 22px #00ffd084;
}
.woocommerce-cart .cart-collaterals, .woocommerce-cart .cart_totals, .woocommerce-cart .proceed-to-checkout {
  display: none !important;
}
@media (max-width: 700px) {
  .redacart-row { flex-direction: column; align-items: flex-start; gap: .5em; padding: 1.1em .6em;}
  .redacart-row .product-remove, .redacart-row .product-price, .redacart-row .product-quantity, .redacart-row .product-subtotal {text-align:left;}
  .redacart-summary{padding:1.3em 0.6em 1.7em 0.6em;}
}
</style>

<div id="redatudo-cart-main">
  <h1 class="reda-grad-title">🛒 Carrinho</h1>
  <form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
    <?php do_action( 'woocommerce_before_cart_table' ); ?>

    <div>
      <?php do_action( 'woocommerce_before_cart_contents' ); ?>

      <?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
        $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
        $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
        if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) :
          $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
      ?>
      <div class="redacart-row woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
        <div class="product-remove">
          <?php
            echo apply_filters(
              'woocommerce_cart_item_remove_link',
              sprintf(
                '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s" style="color:#00ffd0;">&times;</a>',
                esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                esc_html__( 'Remove this item', 'woocommerce' ),
                esc_attr( $product_id ),
                esc_attr( $_product->get_sku() )
              ),
              $cart_item_key
            );
          ?>
        </div>
        <div class="product-name">
          <?php
            if ( ! $product_permalink ) {
              echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) );
            } else {
              echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s" style="color:#00ffd0">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
            }
            do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );
            // Meta
            $item_data = wc_get_formatted_cart_item_data( $cart_item );
            if($item_data) {
              echo '<div class="product-meta">'.$item_data.'</div>';
            }
            // Backorder
            if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
              echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
            }
          ?>
        </div>
        <div class="product-price">
          <?php echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); ?>
        </div>
        <div class="product-quantity">
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
        <div class="product-subtotal">
          <?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?>
        </div>
      </div>
      <?php endif; endforeach; ?>

      <?php do_action( 'woocommerce_cart_contents' ); ?>
    </div>

    <!-- Cupom e atualizar carrinho -->
    <div class="redacart-coupon">
      <?php if ( wc_coupons_enabled() ) : ?>
        <input type="text" name="coupon_code" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Cupom', 'woocommerce' ); ?>" />
        <button type="submit" name="apply_coupon"><?php esc_attr_e( 'Aplicar', 'woocommerce' ); ?></button>
        <?php do_action( 'woocommerce_cart_coupon' ); ?>
      <?php endif; ?>
      <button type="submit" class="redacart-update" name="update_cart" value="<?php esc_attr_e( 'Atualizar', 'woocommerce' ); ?>"><?php esc_html_e( 'Atualizar', 'woocommerce' ); ?></button>
      <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
    </div>
    <?php do_action( 'woocommerce_after_cart_contents' ); ?>

  </form>

  <!-- Total/checkout único -->
  <div class="redacart-summary">
    <?php do_action( 'woocommerce_before_cart_totals' ); ?>
    <div class="cart-total">
      <?php esc_html_e( 'Total:', 'woocommerce' ); ?>
      <?php wc_cart_totals_order_total_html(); ?>
    </div>
    <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="checkout-btn">
      Finalizar compra <span style="font-size:1.2em;">→</span>
    </a>
    <?php do_action( 'woocommerce_after_cart_totals' ); ?>
  </div>
  <!-- Remove duplicidade de resumo e botão -->
  <style>
    .woocommerce-cart .cart-collaterals, .woocommerce-cart .cart_totals, .woocommerce-cart .proceed-to-checkout {
      display: none !important;
    }
  </style>
  <?php do_action( 'woocommerce_after_cart' ); ?>
</div>

<script>
jQuery(function($){
  var $btn = $('.redacart-summary .checkout-btn');
  $btn.on('click', function(e){
    var _btn = $(this);
    // Feedback visual imediato
    _btn.html('<span class="reda-btn-spinner" style="margin-right:.7em"></span>Redirecionando...');
    setTimeout(function(){
      _btn.html('Finalizar compra <span style="font-size:1.2em;">→</span>');
    }, 5000); // fallback se o redirect falhar
  });
});
</script>
<style>
.reda-btn-spinner {
  display:inline-block; vertical-align:middle; margin-right:.7em;
  width:1.3em; height:1.3em; border:3px solid #00bfff44; border-top:3px solid #00ffd0;
  border-radius:50%; animation:reda-spin 0.8s linear infinite;
}
@keyframes reda-spin { 100% { transform: rotate(360deg); } }
</style>