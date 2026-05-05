<!-- Checkout Redatudo Clean-Inspired -->

<?php
if ( ! defined( 'ABSPATH' ) ) exit;
do_action( 'woocommerce_before_checkout_form', $checkout );
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
  echo '<div class="alert alert-warning text-center" style="font-family:Orbitron,Arial; color:#00ffd0;background:#181733;">' . esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'Você precisa estar logado para finalizar a compra.', 'woocommerce' ) ) ) . '</div>'; return;
}


?>

<style>
/* Estrutura inspirada no Stripe/MercadoLivre */
body.woocommerce-checkout { background: #0d0d13; }
#checkout-core-redatudo {
  max-width: 730px; margin: 0 auto; padding: 1.2em 0; font-family: 'Orbitron', Arial, sans-serif;
}
.checkout-card {
  background: #181733ee;
  border-radius: 22px;
  box-shadow: 0 4px 32px #00bfff1a;
  padding: 2.5em 2em 2em 2em;
  margin-bottom: 1.3em;
  position: relative;
}
#checkout-logo-bar {
  display: flex; align-items: center; justify-content: center;
  gap: .8em;
  margin-bottom: 2em;
}
#checkout-logo-bar img {
  height: 2.4em;
  filter: drop-shadow(0 2px 12px #00bfff60);
}
.checkout-progress-bar {
  flex:1;
  height: 6px;
  border-radius: 5px;
  background: linear-gradient(90deg,#00ffd0 70%,#7f00ff 100%);
  margin-left: 1.1em;
  box-shadow: 0 2px 12px #00bfff45 inset;
}
.checkout-product-summary {
  border: 1px solid #00bfff33;
  background: #161234f0;
  border-radius: 16px;
  padding: 1.06em 1.2em;
  margin-bottom: 1.4em;
  display: flex; align-items:center; gap:1em;
  font-family:'Orbitron',Arial,sans-serif;
}
.checkout-product-summary .prod-icon { font-size:2.2em; }
.checkout-product-summary .prod-title { font-size:1.09em;font-weight:600;color:#fff; }
.checkout-product-summary .prod-preco { color:#00ffd0; font-size:1.18em;font-weight:700;margin-left:auto; }
.checkout-aviso-seguro {
  background: #00353d80;
  color: #00ffd0;
  border-radius: 13px;
  font-size: .97em;
  padding: .8em 1em .8em 2em;
  margin-bottom: .8em;
  position: relative;
  font-weight:600;
}
.checkout-aviso-seguro:before {
  content: "🔒";
  position: absolute; left:.8em; top:.7em; font-size:1.1em;
}
.woocommerce form .form-row {
  margin-bottom: 1.1em !important;
}
.woocommerce form .form-row label {
  color: #00ffd0; font-weight: 700;
  font-size: 1em; letter-spacing: .4px; margin-bottom:.22em;
}
.woocommerce input[type="text"], .woocommerce input[type="email"], .woocommerce input[type="tel"], .woocommerce input[type="password"], .woocommerce select {
  border-radius: 14px !important;
  border: 1.5px solid #28286e !important;
  background: #171727 !important;
  color: #eaffee !important;
  box-shadow: 0 1px 8px #00bfff23;
  padding: .85em 1.08em;
  font-size: 1.07em;
  font-family: 'Orbitron', Arial, sans-serif;
  transition: border-color .11s, box-shadow .16s;
}
.woocommerce input[type="text"]:focus,.woocommerce input[type="email"]:focus,.woocommerce input[type="tel"]:focus,.woocommerce select:focus {
  border-color: #00ffd0 !important; background: #101022 !important; color:#00ffd0 !important;
  box-shadow: 0 2px 13px #00ffd023;
}

/* NÃO aplica verde nos labels do Stripe */
#payment .woocommerce-billing-fields label,
#payment .redatudo-billing-fields label {
  color: #00ffd0 !important;
}
#order_review_heading { display:none; }
#order_review {
  padding:0; background:none; border:none; box-shadow:none;
}
#place_order, .checkout-cta-main {
  background: linear-gradient(90deg, #7f00ff 50%, #00bfff 100%);
  color: #fff !important; border:none; border-radius: 22px;
  font-family: 'Orbitron', Arial, sans-serif;
  font-weight: bold; font-size: 1.23em;
  width: 100%; padding: 0.95em 0;
  margin-top:1.7em;margin-bottom:.6em;
  transition:transform .19s, box-shadow .14s, background .22s;
  box-shadow: 0 2px 16px #00bfff50;
}
#place_order:hover, .checkout-cta-main:hover {
  background: linear-gradient(92deg, #00bfff 60%, #7f00ff 100%);
  transform: translateY(-2px) scale(1.04);
  box-shadow: 0 8px 22px #00ffd084;
}

/* Sobrescreve cores do Stripe para melhor legibilidade - MAIS ESPECÍFICO */
.p-PaymentElement .p-FieldLabel,
.p-PaymentElement label.p-FieldLabel,
.p-PaymentElement .Label,
.p-Field .p-FieldLabel,
#payment .p-PaymentElement label,
#order_review .p-FieldLabel,
.woocommerce-checkout-payment .p-FieldLabel {
  color: #2D3748 !important;
  font-weight: 600 !important;
}
.p-PaymentElement .p-Input-input,
.p-PaymentElement input,
.p-PaymentElement .p-Select-select,
.p-PaymentElement select,
#payment .p-Input-input {
  color: #1A202C !important;
}
.checkout-footer-trust {
  display: flex; align-items: center; gap: .7em;
  margin-top: 1.2em; justify-content:center;
  color:#b8e6ff; opacity:.82;
}
@media (max-width:600px) {
  #checkout-core-redatudo { padding: 0.8em 0.2em;}
  .checkout-card {padding: 1.1em 0.7em;}
  .checkout-product-summary {flex-direction:column;align-items:flex-start;}
}



</style>

<div id="checkout-core-redatudo">

  <!-- Logo e progresso -->
  <div id="checkout-logo-bar">
    <img src="https://redatudo.online/wp-content/uploads/2025/04/logotipo-redatudo-sem-fundo.png" alt="Redatudo" />
    <span class="checkout-progress-bar"></span>
  </div>

  <!-- Produto resumido -->
  <div class="checkout-product-summary">
    <span class="prod-icon">✨</span>
    <span class="prod-title">
      <?php
      $prod = WC()->cart->get_cart_contents_count() > 0 ? WC()->cart->get_cart()[ array_key_first(WC()->cart->get_cart()) ]['data']->get_name() : 'Produto Redatudo';
      echo esc_html($prod);
      ?>
    </span>
    <span class="prod-preco">
      <?php wc_cart_totals_order_total_html(); ?>
    </span>
  </div>

  <div class="checkout-card">

    <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data" novalidate autocomplete="on">
      <div class="checkout-aviso-seguro">Pagamento 100% seguro. Seus dados são protegidos com criptografia avançada.</div>
      <?php if ( $checkout->get_checkout_fields() ) : ?>
        <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
        <?php do_action( 'woocommerce_checkout_billing' ); ?>
        <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
      <?php endif; ?>

      <!-- Forma de pagamento (módulo normal WC) -->
      <div id="order_review" class="woocommerce-checkout-review-order">
        <?php do_action( 'woocommerce_checkout_order_review' ); ?>
      </div>
      
    </form>

    <div class="checkout-footer-trust" style="font-size: smaller;">
      <span>✓ Satisfação garantida&nbsp;&nbsp;|&nbsp;&nbsp;Checkout seguro 🛡️</span>
      <span style="font-size:1.18em">|</span>
      <span>Stripe, cartões crédito/débito</span>
    </div>
    <div class="checkout-footer-trust" style="font-size:.91em;margin-top:.31em;">
      <span>Mais de 4.000 clientes felizes 😃</span>
    </div>
    <div class="checkout-footer-trust text-center p-2" style="font-size:.91em;margin-top:.31em;">
      <a href="https://stripe.com" target="_blank">
      <img width="20%" height="20%" class="img-fluid" src="https://redatudo.online/wp-content/uploads/2025/05/Powered-by-Stripe-white.webp" />
      </a>
    </div>

  </div>

  <!-- Avaliações DEPOIS do checkout, não no fluxo -->
  <div style="max-width:500px;margin:0 auto;margin-top:2em;">
    <!-- se quiser, avaliações em slider só depois do cartão, nunca misturado -->
    <?php // echo do_shortcode('[product_reviews id="46" limit="10"]'); ?>
  </div>
</div>

<style>
  #redatudo-global-loader {
  position: fixed;
  inset: 0;
  z-index: 999999;
  background: radial-gradient(ellipse at 50% 40%, #181152 45%, #171727 100%);
  display: flex;
  align-items: center;
  justify-content: center;
  transition: opacity .28s;
}
.redatudo-global-loader-center {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 1.8em;
}
.redatudo-loader-logo {
  width: 74px;
  height: 74px;
  filter: drop-shadow(0 0 36px #00ffd0cc) drop-shadow(0 0 12px #7f00ff60);
  animation: reda-pulse 1.3s infinite cubic-bezier(.5,0,.5,1);
}
@keyframes reda-pulse {
  0%   { transform: scale(1);   filter: drop-shadow(0 0 36px #00ffd0cc); }
  65%  { transform: scale(1.13); filter: drop-shadow(0 0 60px #7f00ffbb);}
  100% { transform: scale(1);   filter: drop-shadow(0 0 36px #00ffd0cc);}
}
.redatudo-loader-txt {
  font-family: 'Orbitron', Arial, sans-serif;
  color: #00ffd0;
  font-size: 1.25em;
  font-weight: 700;
  letter-spacing: 1.5px;
  text-shadow: 0 0 16px #7f00ff60;
  margin-top: .3em;
}
body.redatudo-loading {
  overflow: hidden !important;
}
</style>

<!-- Overlay Loading Redatudo -->
<div id="redatudo-global-loader" style="display:none;">
  <div class="redatudo-global-loader-center">
    <img src="https://redatudo.online/wp-content/uploads/2025/04/logotipo-redatudo-sem-fundo.png" alt="Carregando Redatudo" class="redatudo-loader-logo"/>
    <div class="redatudo-loader-txt">Wait...</div>
  </div>
</div>

<script>
jQuery(function($){
  // Ativa overlay no submit do checkout
  $('form.checkout').on('submit', function(e){
    $('#redatudo-global-loader').fadeIn(120);
    $('body').addClass('redatudo-loading');
  });

  // Esconde overlay se houver erro de validação/AJAX
  $(document.body).on('checkout_error updated_checkout', function(){
    $('#redatudo-global-loader').fadeOut(120);
    $('body').removeClass('redatudo-loading');
  });

  // Garante overlay sumindo ao retornar pro checkout
  $(window).on('pageshow', function(){ 
    $('#redatudo-global-loader').hide();
    $('body').removeClass('redatudo-loading');
  });

  // Força cor dos labels do Stripe para cinza escuro
  function fixStripeColors() {
    // Labels do Stripe
    $('.p-FieldLabel, .p-PaymentElement label, .p-Field label').each(function(){
      $(this).css({
        'color': '#2D3748',
        'font-weight': '600'
      });
    });
    // Inputs do Stripe
    $('.p-Input-input, .p-PaymentElement input, .p-Select-select').each(function(){
      $(this).css('color', '#1A202C');
    });
  }

  // Executa quando a página carregar
  setTimeout(fixStripeColors, 500);
  setTimeout(fixStripeColors, 1000);
  setTimeout(fixStripeColors, 2000);

  // Observa mudanças no DOM para quando o Stripe carregar
  var observer = new MutationObserver(function(mutations) {
    fixStripeColors();
  });
  
  if (document.querySelector('#payment')) {
    observer.observe(document.querySelector('#payment'), {
      childList: true,
      subtree: true
    });
  }
});
</script>
