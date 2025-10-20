<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header( 'shop' );
global $product;

$is_variable     = $product->is_type('variable');
$is_subscription = ( class_exists('WC_Subscriptions_Product') && WC_Subscriptions_Product::is_subscription( $product ) );
$variations      = $is_variable ? $product->get_available_variations() : [];
$image_id        = $product->get_image_id();
$image_url       = $image_id ? wp_get_attachment_url( $image_id ) : wc_placeholder_img_src();
?>

<style>
:root {
  --roxo-ia: #7f00ff;
  --azul-tech: #00bfff;
  --preto-fundo: #0d0d13;
  --azul-glow: #00ffd0;
}
.reda-container {
  max-width: 900px;
  margin: 0 auto;
  padding: 3rem 1.5rem;
}
.redaprod-card {
  background: rgba(17, 17, 38, 0.99);
  border-radius: 24px;
  box-shadow: 0 4px 40px #00bfff30, 0 1px 2px #7f00ff10;
  overflow: hidden;
  display: flex;
  flex-wrap: wrap;
  gap: 0;
  align-items: stretch;
}
.redaprod-imgside {
  flex: 1 1 260px;
  min-width: 230px;
  max-width: 320px;
  background: radial-gradient(ellipse at 45% 30%, #181152 50%, #171727 110%);
  display: flex; flex-direction: column; justify-content: center; align-items: center;
  padding: 2.5rem 1.1rem;
}
.redaprod-imgside img {
  max-width: 180px;
  border-radius: 20px;
  box-shadow: 0 0 40px var(--azul-tech, #00bfff30);
  background: #19152d70;
}
.redaprod-main {
  flex: 3 1 350px;
  padding: 2.3rem 2.5rem 2rem 2rem;
  display: flex;
  flex-direction: column;
  gap: 0.9rem;
  min-width: 270px;
}
.reda-grad-title {
  font-size: 2.1rem;
  font-family: 'Orbitron',Arial,sans-serif;
  font-weight: 700;
  background: linear-gradient(90deg, #00bfff, #7f00ff 70%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}
.redaprod-desc {
  color: #c8e6ff;
  font-size: 1.09rem;
  margin: 0.7rem 0 1.0rem 0;
  line-height: 1.7;
}
.redaprod-price {
  font-family: 'Orbitron', Arial,sans-serif;
  font-size: 1.62rem;
  background: linear-gradient(90deg, #00bfff, #7f00ff 90%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  font-weight: bold;
  margin: 0.2rem 0 0.5rem 0;
}
.redaprod-table {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(180px,1fr));
  gap: 1.4rem;
  margin: 1.5rem 0 1.3rem 0;
}
.redaprod-var-card {
  background: rgba(17, 23, 39, 0.92);
  border-radius: 18px;
  box-shadow: 0 2px 18px #00bfff25;
  border: 2px solid transparent;
  padding: 1.4em 1em 1.2em 1em;
  text-align: center;
  cursor: pointer;
  transition: transform .18s, box-shadow .18s, border .2s;
  position: relative;
}
.redaprod-var-card.selected,
.redaprod-var-card:hover {
  border: 2px solid #00ffd0;
  box-shadow: 0 8px 32px #00ffd033, 0 1px 2px #7f00ff10;
  transform: translateY(-2px) scale(1.04);
}
.reda-var-credits {
  font-family: 'Orbitron',Arial,sans-serif;
  font-size: 1.1em;
  color: #00ffd0;
  letter-spacing: .8px;
  margin-bottom: .35em;
}
.reda-var-price {
  font-family: 'Orbitron',Arial,sans-serif;
  font-size: 1.32em;
  color: #fff;
  margin-bottom: .2em;
}
.reda-var-label {
  color: #b8e6ff;
  font-size: .97em;
  font-family: 'Orbitron',Arial,sans-serif;
}
.redaprod-cta {
  margin-top: 1.1rem;
  display: flex;
  gap: 1.2rem;
  align-items: center;
}
.redaprod-cta .button, .redaprod-cta .single_add_to_cart_button {
  font-family: 'Orbitron', Arial, sans-serif;
  border-radius: 22px;
  font-size: 1.15rem;
  box-shadow: 0 2px 10px #00bfff30;
  background: linear-gradient(90deg, #7f00ff 55%, #00bfff 100%);
  border: none;
  color: #fff;
  padding: .85em 2.2em;
  font-weight: bold;
  transition: all .22s;
}
.redaprod-cta .button:hover, .redaprod-cta .single_add_to_cart_button:hover {
  background: linear-gradient(95deg, #00bfff 60%, #7f00ff 100%);
  transform: translateY(-2px) scale(1.03);
  box-shadow: 0 2px 30px #00ffd084;
}
.redaprod-meta {
  margin-top: 2.1rem;
  padding: 1.2rem 0 0 0;
  color: #b3bddf;
  font-size: 1rem;
  border-top: 1px solid #2e2950;
  opacity: .87;
}
@media (max-width:1000px){
  .redaprod-card{ flex-direction: column; }
  .redaprod-imgside, .redaprod-main { min-width: 0; max-width: 100%; padding: 1.3rem 0.8rem;}
  .redaprod-main{padding-bottom: 1.2rem;}
  .reda-container{padding:1.3rem 0.5rem;}
}

.reda-btn-spinner {
  display:inline-block; vertical-align:middle; margin-right:.7em;
  width:1.3em; height:1.3em; border:3px solid #00bfff44; border-top:3px solid #00ffd0;
  border-radius:50%; animation:reda-spin 0.8s linear infinite;
}
</style>

<div class="reda-container">
<?php do_action( 'woocommerce_before_single_product' );
if ( post_password_required() ) { echo get_the_password_form(); return; }
?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class('redaprod-card', $product ); ?>>

  <!-- LADO IMAGEM -->
  <div class="redaprod-imgside">
    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" />
  </div>

  <!-- CONTEÚDO PRINCIPAL -->
  <div class="redaprod-main">
    <h1 class="reda-grad-title"><?php the_title(); ?></h1>
    <?php woocommerce_template_single_rating(); ?>
    <div class="redaprod-desc"><?php the_excerpt(); ?></div>

    <?php if ($is_variable && !empty($variations)) : ?>
      <form class="cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', get_permalink($product->get_id()) ) ); ?>" method="post" enctype="multipart/form-data">
        <div class="redaprod-table">

          <?php foreach ($variations as $i => $variation) :
              $attr = $variation['attributes'];
              $credit_value = isset($attr['attribute_credits']) ? $attr['attribute_credits'] : '';
              $price = $variation['display_price'];
              $price_html = wc_price($price);
              $is_default = $variation['is_active'] && !empty($variation['is_in_stock']);
              $input_id = "var_{$variation['variation_id']}";
          ?>
            <label for="<?php echo $input_id; ?>" class="redaprod-var-card<?php echo $i===0?' selected':''; ?>" data-varid="<?php echo $variation['variation_id']; ?>">
              <input type="radio" name="variation_id" id="<?php echo $input_id; ?>" value="<?php echo $variation['variation_id']; ?>" style="display:none;" <?php echo $i===0?'checked':''; ?> />
              <div class="reda-var-credits"><?php echo esc_html($credit_value ? $credit_value.' créditos' : $variation['variation_description']); ?></div>
              <div class="reda-var-price"><?php echo $price_html; ?></div>
              <?php if ( $is_subscription && !empty($variation['price_html']) ) : ?>
                <div class="reda-var-label"><?php echo wp_kses_post($variation['price_html']); ?></div>
              <?php endif; ?>
            </label>
          <?php endforeach; ?>

        </div>
        <div class="redaprod-cta">
          <input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" />
          <?php
            // Garante que os atributos sejam enviados para o WC
            foreach($product->get_variation_attributes() as $attr_name => $options) {
              echo '<input type="hidden" name="attribute_' . esc_attr(sanitize_title($attr_name)) . '" value="">';
            }
          ?>
          <button type="submit" class="single_add_to_cart_button button alt"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>
        </div>
      </form>
      <script>
      // Seleção visual e transmissão dos atributos para WooCommerce
      document.querySelectorAll('.redaprod-var-card').forEach(function(card){
        card.addEventListener('click', function(){
          document.querySelectorAll('.redaprod-var-card').forEach(c=>c.classList.remove('selected'));
          this.classList.add('selected');
          let radio = this.querySelector('input[type="radio"]');
          radio.checked = true;
          // Preenche os atributos hidden para o WC
          let vid = this.dataset.varid;
          <?php
          foreach($product->get_variation_attributes() as $attr_name => $options) {
            echo "document.querySelector('input[name=\"attribute_".esc_js($attr_name)."\"]').value = radio.closest('label').querySelector('.reda-var-credits').textContent.replace(' créditos','');";
          }
          ?>
        });
      });
      </script>
    <?php else: // produto simples OU assinatura simples ?>
      <div class="redaprod-price"><?php echo $product->get_price_html(); ?></div>
      <form class="cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', get_permalink($product->get_id()) ) ); ?>" method="post" enctype="multipart/form-data">
        <div class="redaprod-cta">
          <input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" />
          <button type="submit" class="single_add_to_cart_button button alt"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>
        </div>
      </form>
    <?php endif; ?>

    <div class="redaprod-meta">
      <?php do_action( 'woocommerce_product_meta_start' ); ?>
      <?php echo wc_get_product_category_list( $product->get_id(), ', ', '<strong>Categorias: </strong>', '' ); ?>
      <?php do_action( 'woocommerce_product_meta_end' ); ?>
    </div>
  </div>
</div>

<!-- Tabs/descrição longa/avaliações -->
<div class="product-tabs" style="margin-top:2.7rem;">
  <?php woocommerce_output_product_data_tabs(); ?>
  <br><br>
  <?php woocommerce_output_related_products(); ?>
</div>
</div>
<?php do_action( 'woocommerce_after_single_product' ); ?>
<?php get_footer( 'shop' ); ?>

<script>
jQuery(function($){
  // Produto simples ou variação selecionada
  $('form.cart').on('submit', function(e){
    var $btn = $(this).find('.single_add_to_cart_button');
    if($btn.length){
      $btn.prop('disabled',true)
        .html('<span class="reda-btn-spinner"></span>Adicionando...');
    }
    // Não retorna false, deixa Woo processar
  });

  // Após AJAX add (caso AJAX, como em listas)
  $(document.body).on('added_to_cart', function(){
    var $btn = $('.single_add_to_cart_button');
    $btn.prop('disabled',false).html('Usar IA');
  });

  // Previne bug ao navegar (back)
  $(window).on('pageshow', function(){ $('.single_add_to_cart_button').prop('disabled',false).html('Usar IA'); });
});

</script>