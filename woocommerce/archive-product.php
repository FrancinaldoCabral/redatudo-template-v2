<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );
?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap');

.woo-archive-section {
  background: #0F0F1A;
  min-height: 100vh;
  padding: 3rem 0;
}

.woo-archive-header {
  text-align: center;
  margin-bottom: 3rem;
  padding: 0 1rem;
}

.woo-archive-title {
  font-size: clamp(2rem, 4vw, 3rem);
  font-family: 'Outfit', sans-serif;
  font-weight: 700;
  color: #FFFFFF;
  margin-bottom: 1rem;
  letter-spacing: -0.02em;
}

.woo-archive-title .gradient-text {
  background: linear-gradient(135deg, #A78BFA 0%, #60A5FA 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.woo-archive-subtitle {
  font-size: 1.125rem;
  color: #D1D5DB;
  font-family: 'Inter', sans-serif;
  max-width: 700px;
  margin: 0 auto;
}

.woo-products-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 2rem;
  padding: 0 1rem;
  max-width: 1400px;
  margin: 0 auto;
}

.woo-no-products {
  background: linear-gradient(145deg, #1F2937 0%, #111827 100%);
  border: 2px solid #374151;
  border-radius: 24px;
  padding: 4rem 2rem;
  text-align: center;
  max-width: 600px;
  margin: 0 auto;
}

.woo-no-products h2 {
  font-family: 'Outfit', sans-serif;
  font-size: 2rem;
  color: #FFFFFF;
  margin-bottom: 1rem;
}

.woo-no-products p {
  font-family: 'Inter', sans-serif;
  font-size: 1.125rem;
  color: #D1D5DB;
  margin-bottom: 2rem;
}

.woo-no-products .btn-back {
  display: inline-block;
  background: linear-gradient(135deg, #10B981 0%, #059669 100%);
  color: #FFFFFF;
  padding: 1rem 2.5rem;
  font-weight: 700;
  border-radius: 12px;
  text-decoration: none;
  font-size: 1.125rem;
  font-family: 'Inter', sans-serif;
  transition: all 0.3s;
  box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

.woo-no-products .btn-back:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
  text-decoration: none;
  color: #FFFFFF;
}

@media (max-width: 768px) {
  .woo-products-grid {
    grid-template-columns: 1fr;
    gap: 1.5rem;
  }
}
</style>

<section class="woo-archive-section">
  <div class="container">
    <div class="woo-archive-header">
      <?php if ( is_shop() ) : ?>
        <h1 class="woo-archive-title">
          <span class="gradient-text">Planos e Créditos</span><br>
          Potencialize Sua Criação
        </h1>
        <p class="woo-archive-subtitle">
          Escolha o plano ideal para suas necessidades e comece a criar conteúdo profissional com IA
        </p>
      <?php else : ?>
        <h1 class="woo-archive-title">
          <?php woocommerce_page_title(); ?>
        </h1>
      <?php endif; ?>
    </div>

    <?php if ( woocommerce_product_loop() ) : ?>
      <?php woocommerce_product_loop_start(); ?>
      
      <div class="woo-products-grid">
        <?php
        if ( wc_get_loop_prop( 'total' ) ) {
          while ( have_posts() ) {
            the_post();
            do_action( 'woocommerce_shop_loop' );
            wc_get_template_part( 'content', 'product' );
          }
        }
        ?>
      </div>

      <?php woocommerce_product_loop_end(); ?>
      
      <?php do_action( 'woocommerce_after_shop_loop' ); ?>
      
    <?php else : ?>
      
      <div class="woo-no-products">
        <h2>🔍 Nenhum produto encontrado</h2>
        <p>Não encontramos produtos correspondentes à sua busca.<br>Que tal explorar nossas ferramentas?</p>
        <a href="<?php echo home_url('/'); ?>" class="btn-back">
          Voltar à Home
        </a>
      </div>
      
    <?php endif; ?>
  </div>
</section>

<?php
get_footer( 'shop' );
