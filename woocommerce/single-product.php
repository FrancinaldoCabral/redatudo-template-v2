<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header( 'shop' );
global $product;

$is_variable     = $product->is_type('variable');
$is_subscription = ( class_exists('WC_Subscriptions_Product') && WC_Subscriptions_Product::is_subscription( $product ) );
$variations      = $is_variable ? $product->get_available_variations() : [];
$image_id        = $product->get_image_id();
$image_url       = $image_id ? wp_get_attachment_url( $image_id ) : wc_placeholder_img_src();

// ============================================
// PRODUTOS VARIÁVEIS → PÁGINA ELEGANTE DE PLANOS
// ============================================
if ( $is_variable && !empty( $variations ) ) :
  
  // Pega IDs das variações com assinaturas ativas do usuário
  $user_active_variations = [];
  if ( is_user_logged_in() && function_exists('wcs_get_users_subscriptions') ) {
    $user = wp_get_current_user();
    $subscriptions = wcs_get_users_subscriptions( $user->ID );
    foreach ( $subscriptions as $subscription ) {
      if ( $subscription->has_status('active') ) {
        foreach ( $subscription->get_items() as $item ) {
          $variation_id = $item->get_variation_id();
          if ( $variation_id ) {
            $user_active_variations[] = $variation_id;
          }
        }
      }
    }
  }
  
  // PARÂMETROS DE COMPATIBILIDADE - redireciona Migração (se veio com ?show_plans_modal=1)
  if ( isset($_GET['show_plans_modal']) && $_GET['show_plans_modal'] == '1' ) {
    // Remove o parâmetro da URL e recarrega a página
    wp_redirect( remove_query_arg('show_plans_modal') );
    exit;
  }

  $redirect_param = null;
  if ( isset($_GET['add-to-cart']) ) {
    $redirect_param = intval($_GET['add-to-cart']);
  } elseif ( isset($_GET['add-to-cart']) ) {
    $redirect_param = intval($_GET['add-to-cart']);
  }

  // Se veio com add_to_cart/add-to-cart=VARIATION_ID, decide se vai direto ao checkout
  if ( $redirect_param ) {
    $requested_variation   = $redirect_param;
    $matched_variation_id  = null;
    $matched_parent_id     = null;

    // Verifica se essa variação existe no produto
    $variation_exists = false;
    foreach ( $variations as $variation ) {
      $variation_id    = isset( $variation['variation_id'] ) ? intval( $variation['variation_id'] ) : 0;
      $parent_id       = isset( $variation['variation_parent_id'] ) ? intval( $variation['variation_parent_id'] ) : 0;

      if ( $variation_id === $requested_variation || $parent_id === $requested_variation ) {
        $variation_exists      = true;
        $matched_variation_id  = $variation_id;
        $matched_parent_id     = $parent_id;
        break;
      }
    }

    if ( $variation_exists ) {
      if ( $matched_variation_id && in_array( $matched_variation_id, $user_active_variations ) ) {
        // Usuário já tem este plano → remove item duplicado do carrinho (se houver)
        if ( function_exists( 'WC' ) && WC()->cart ) {
          foreach ( WC()->cart->get_cart() as $cart_key => $cart_item ) {
            $cart_product_id   = isset( $cart_item['product_id'] ) ? intval( $cart_item['product_id'] ) : 0;
            $cart_variation_id = isset( $cart_item['variation_id'] ) ? intval( $cart_item['variation_id'] ) : 0;
            if ( $cart_variation_id === $matched_variation_id ) {
              WC()->cart->remove_cart_item( $cart_key );
            }
          }
        }

        // Redireciona para a página limpa do produto (sem parâmetros)
        $clean_url = get_permalink( $product->get_id() );
        wp_safe_redirect( $clean_url );
        exit;
      }

      // Usuário não tem este plano → segue direto para o checkout
      $checkout_url = add_query_arg(
        array(
          'add-to-cart' => $requested_variation,
          'quantity'    => 1,
        ),
        wc_get_checkout_url()
      );
      wp_safe_redirect( $checkout_url );
      exit;
    }
    // Se variação não existe, apenas cai no layout elegante
  }

?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap');

/* PÁGINA DE PRODUTO - DESIGN MODERNO E FOCADO EM CONVERSÃO */
.reda-container {
  max-width: 100%;
  padding: 0;
}

.redatudo-plans-content {
  min-height: 100vh;
  background: #0F0F1A;
  background-image: 
    radial-gradient(ellipse at 20% 10%, rgba(124, 58, 237, 0.15) 0%, transparent 50%),
    radial-gradient(ellipse at 80% 90%, rgba(16, 185, 129, 0.1) 0%, transparent 50%);
  position: relative;
  overflow: hidden;
}

.redatudo-plans-container {
  position: relative;
  z-index: 1;
  max-width: 1280px;
  margin: 0 auto;
  padding: 3rem 1.5rem 4rem;
}

.redatudo-plans-header {
  text-align: center;
  margin-bottom: 3.5rem;
}

.redatudo-plans-header h1 {
  font-family: 'Outfit', sans-serif;
  font-size: clamp(2rem, 5vw, 3.2rem);
  font-weight: 800;
  letter-spacing: -0.02em;
  background: linear-gradient(135deg, #A78BFA 0%, #60A5FA 50%, #10B981 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  margin-bottom: 1rem;
  line-height: 1.2;
}

.redatudo-plans-subheader {
  font-family: 'Inter', sans-serif;
  font-size: clamp(1rem, 2vw, 1.2rem);
  color: #D1D5DB;
  max-width: 700px;
  margin: 0 auto 2.5rem;
  line-height: 1.6;
  font-weight: 400;
}

/* Seção Explicativa - Como Funcionam os Créditos */
.credits-explainer {
  background: linear-gradient(145deg, rgba(31, 41, 55, 0.5) 0%, rgba(17, 24, 39, 0.5) 100%);
  backdrop-filter: blur(20px);
  border: 1px solid rgba(75, 85, 99, 0.3);
  border-radius: 20px;
  padding: 2rem;
  margin-bottom: 3rem;
  text-align: center;
}

.credits-explainer h3 {
  font-family: 'Outfit', sans-serif;
  font-size: 1.4rem;
  font-weight: 700;
  color: #FFFFFF;
  margin-bottom: 1rem;
}

.credits-explainer p {
  font-family: 'Inter', sans-serif;
  font-size: 1.05rem;
  color: #E5E7EB;
  margin-bottom: 1.5rem;
  line-height: 1.6;
}

.credits-examples {
  display: flex;
  justify-content: center;
  gap: 2rem;
  flex-wrap: wrap;
  margin-top: 1.5rem;
}

.credits-cost-table {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 1.5rem;
  margin: 2rem 0;
  max-width: 820px;
  margin-left: auto;
  margin-right: auto;
}

.cost-row {
  display: flex;
  align-items: flex-start;
  gap: 1.5rem;
  background: rgba(124, 58, 237, 0.08);
  border: 1px solid rgba(124, 58, 237, 0.2);
  border-radius: 14px;
  padding: 1.25rem;
  transition: all 0.3s ease;
}

.cost-row:hover {
  background: rgba(124, 58, 237, 0.12);
  border-color: rgba(124, 58, 237, 0.4);
}

.cost-icon {
  font-size: 2rem;
  min-width: 2.5rem;
  text-align: center;
}

.cost-info {
  flex: 1;
}

.cost-title {
  font-family: 'Outfit', sans-serif;
  font-size: 1.05rem;
  font-weight: 700;
  color: #FFFFFF;
  margin-bottom: 0.35rem;
}

.cost-desc {
  font-family: 'Inter', sans-serif;
  font-size: 0.9rem;
  color: #D1D5DB;
  line-height: 1.5;
}

.cost-desc span {
  color: #A78BFA;
  font-weight: 600;
}

.credits-note {
  background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(16, 185, 129, 0.05) 100%);
  border: 1px solid rgba(16, 185, 129, 0.3);
  border-radius: 14px;
  padding: 1.25rem;
  margin-top: 1.5rem;
  font-family: 'Inter', sans-serif;
  font-size: 0.95rem;
  color: #E5E7EB;
  line-height: 1.6;
}

.credits-note strong {
  color: #34D399;
}

/* Seção Por Que Créditos */
.why-credits-section {
  background: linear-gradient(145deg, rgba(31, 41, 55, 0.5) 0%, rgba(17, 24, 39, 0.5) 100%);
  backdrop-filter: blur(20px);
  border: 1px solid rgba(75, 85, 99, 0.3);
  border-radius: 20px;
  padding: 2.5rem 2rem;
  margin: 3rem 0;
}

.why-credits-section h3 {
  font-family: 'Outfit', sans-serif;
  font-size: 1.5rem;
  font-weight: 700;
  color: #FFFFFF;
  text-align: center;
  margin-bottom: 2rem;
}

.why-benefits {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
  gap: 1.5rem;
}

.why-benefit {
  background: rgba(124, 58, 237, 0.08);
  border: 1px solid rgba(124, 58, 237, 0.2);
  border-radius: 14px;
  padding: 1.5rem;
  transition: all 0.3s ease;
  display: flex;
  gap: 1rem;
}

.why-benefit:hover {
  background: rgba(124, 58, 237, 0.12);
  border-color: rgba(124, 58, 237, 0.4);
  transform: translateY(-2px);
}

.why-icon {
  font-size: 1.8rem;
  min-width: 2rem;
  text-align: center;
  line-height: 1;
}

.why-content strong {
  font-family: 'Outfit', sans-serif;
  font-size: 1.05rem;
  color: #FFFFFF;
  display: block;
  margin-bottom: 0.5rem;
}

.why-content p {
  font-family: 'Inter', sans-serif;
  font-size: 0.9rem;
  color: #D1D5DB;
  line-height: 1.5;
  margin: 0;
}

@media (max-width: 768px) {
  .why-credits-section {
    padding: 2rem 1.5rem;
  }
  .why-benefits {
    grid-template-columns: 1fr;
  }
}

.redatudo-plans-back {
  display: inline-flex;
  align-items: center;
  color: #10B981;
  text-decoration: none;
  font-family: 'Inter', sans-serif;
  font-size: 1rem;
  font-weight: 600;
  transition: all 0.3s ease;
  margin-bottom: 2rem;
}

.redatudo-plans-back:hover {
  color: #34D399;
  transform: translateX(-5px);
}

.redatudo-plans-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 2rem;
  margin-bottom: 3rem;
  align-items: stretch;
}

.redatudo-plan-card {
  background: linear-gradient(145deg, rgba(31, 41, 55, 0.5) 0%, rgba(17, 24, 39, 0.5) 100%);
  backdrop-filter: blur(20px);
  border-radius: 24px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
  border: 2px solid rgba(75, 85, 99, 0.3);
  padding: 2rem 1.75rem;
  text-align: center;
  transition: all 0.3s cubic-bezier(0.23, 1, 0.320, 1);
  position: relative;
  overflow: visible;
  cursor: pointer;
  display: flex;
  flex-direction: column;
}

.redatudo-plan-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 12px 32px rgba(124, 58, 237, 0.3);
  border-color: rgba(124, 58, 237, 0.5);
}

/* Plano em Destaque */
.redatudo-plan-featured {
  border-color: rgba(16, 185, 129, 0.6);
  background: linear-gradient(145deg, rgba(31, 41, 55, 0.7) 0%, rgba(17, 24, 39, 0.7) 100%);
  box-shadow: 0 8px 40px rgba(16, 185, 129, 0.25);
  transform: scale(1.05);
}

.redatudo-plan-featured:hover {
  transform: scale(1.05) translateY(-6px);
  box-shadow: 0 16px 50px rgba(16, 185, 129, 0.35);
}

/* Badge Superior */
.redatudo-plan-badge {
  position: absolute;
  top: -14px;
  left: 50%;
  transform: translateX(-50%);
  background: linear-gradient(135deg, #F59E0B 0%, #DC2626 100%);
  color: #FFFFFF;
  padding: 0.5rem 1.25rem;
  border-radius: 20px;
  font-family: 'Inter', sans-serif;
  font-size: 0.8rem;
  font-weight: 700;
  letter-spacing: 0.5px;
  box-shadow: 0 4px 12px rgba(245, 158, 11, 0.5);
  text-transform: uppercase;
  z-index: 10;
  white-space: nowrap;
}

/* Badge de Economia */
.redatudo-plan-savings {
  position: absolute;
  top: 1rem;
  right: 1rem;
  background: rgba(16, 185, 129, 0.2);
  border: 1px solid rgba(16, 185, 129, 0.4);
  color: #34D399;
  padding: 0.4rem 0.8rem;
  border-radius: 12px;
  font-family: 'Inter', sans-serif;
  font-size: 0.75rem;
  font-weight: 600;
  z-index: 5;
}

.redatudo-plan-title {
  font-family: 'Outfit', sans-serif;
  font-size: 1.4rem;
  font-weight: 700;
  color: #FFFFFF;
  margin-bottom: 0.5rem;
  margin-top: 0.5rem;
}

.redatudo-plan-subtitle {
  font-family: 'Inter', sans-serif;
  font-size: 0.95rem;
  color: #9CA3AF;
  margin-bottom: 1.5rem;
}

.redatudo-plan-price {
  font-family: 'Outfit', sans-serif;
  font-size: 3rem;
  font-weight: 700;
  color: #FFFFFF;
  margin-bottom: 0.25rem;
  line-height: 1;
}

.redatudo-plan-period {
  font-family: 'Inter', sans-serif;
  font-size: 1rem;
  color: #9CA3AF;
  margin-bottom: 0.5rem;
}

.redatudo-plan-per-credit {
  font-family: 'Inter', sans-serif;
  font-size: 0.85rem;
  color: #6B7280;
  margin-bottom: 1.5rem;
}

.redatudo-plan-features {
  list-style: none;
  padding: 0;
  margin: 1.5rem 0;
  text-align: left;
  flex-grow: 1;
}

.redatudo-plan-features li {
  font-family: 'Inter', sans-serif;
  color: #E5E7EB;
  margin-bottom: 0.75rem;
  font-size: 0.95rem;
  line-height: 1.5;
  padding-left: 1.75rem;
  position: relative;
}

.redatudo-plan-features li::before {
  content: '✓';
  position: absolute;
  left: 0;
  color: #10B981;
  font-weight: 700;
  font-size: 1.1rem;
}

.redatudo-plan-button {
  background: linear-gradient(135deg, #10B981 0%, #059669 100%);
  color: #FFFFFF;
  border: none;
  border-radius: 12px;
  padding: 1rem 2rem;
  font-family: 'Inter', sans-serif;
  font-weight: 700;
  font-size: 1.05rem;
  cursor: pointer;
  transition: all 0.3s ease;
  margin-top: auto;
  width: 100%;
  box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
  text-decoration: none;
  display: inline-block;
  position: relative;
  overflow: hidden;
}

.redatudo-plan-button:hover {
  background: linear-gradient(135deg, #059669 0%, #047857 100%);
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
  text-decoration: none;
  color: #FFFFFF;
}

.redatudo-plan-button .btn-subtext {
  display: block;
  font-size: 0.8rem;
  font-weight: 400;
  margin-top: 0.25rem;
  opacity: 0.9;
}

.redatudo-plan-button.disabled {
  background: #374151;
  cursor: not-allowed;
  box-shadow: none;
  opacity: 0.7;
}

.redatudo-plan-button.disabled:hover {
  background: #374151;
  transform: none;
  box-shadow: none;
}

/* Garantias e Footer */
.redatudo-plans-guarantees {
  background: linear-gradient(145deg, rgba(31, 41, 55, 0.5) 0%, rgba(17, 24, 39, 0.5) 100%);
  backdrop-filter: blur(20px);
  border: 1px solid rgba(75, 85, 99, 0.3);
  border-radius: 20px;
  padding: 2.5rem 2rem;
  margin-bottom: 2rem;
}

.guarantees-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 2rem;
  text-align: center;
}

.guarantee-item {
  padding: 1rem;
}

.guarantee-icon {
  font-size: 2.5rem;
  margin-bottom: 0.75rem;
  display: block;
}

.guarantee-title {
  font-family: 'Outfit', sans-serif;
  font-size: 1.1rem;
  font-weight: 700;
  color: #FFFFFF;
  margin-bottom: 0.5rem;
}

.guarantee-desc {
  font-family: 'Inter', sans-serif;
  font-size: 0.9rem;
  color: #D1D5DB;
  line-height: 1.5;
}

.redatudo-plans-footer {
  text-align: center;
  margin-top: 2rem;
  padding-top: 2rem;
  border-top: 1px solid rgba(75, 85, 99, 0.3);
}

.redatudo-plans-footer p {
  font-family: 'Inter', sans-serif;
  color: #9CA3AF;
  font-size: 0.95rem;
}

@media (max-width: 1024px) {
  .redatudo-plans-grid { 
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); 
    gap: 1.5rem; 
  }
  .redatudo-plan-featured {
    transform: scale(1);
  }
  .redatudo-plan-featured:hover {
    transform: translateY(-6px);
  }
}

@media (max-width: 768px) {
  .redatudo-plans-container { padding: 2rem 1rem 3rem; }
  .redatudo-plans-grid { grid-template-columns: 1fr; }
  .redatudo-plan-card { padding: 1.75rem 1.5rem; }
  .redatudo-plan-price { font-size: 2.5rem; }
  .credits-cost-table { grid-template-columns: 1fr; gap: 1rem; }
  .credits-examples { flex-direction: column; gap: 1rem; }
  .credit-example { min-width: 100%; }
}

@media (max-width: 480px) {
  .redatudo-plan-card { padding: 1.5rem 1.25rem; }
  .redatudo-plan-price { font-size: 2.2rem; }
  .redatudo-plan-button { padding: 0.875rem 1.5rem; font-size: 1rem; }
}

/* Prova Social */
.social-proof-section {
  margin-top: 4rem;
  text-align: center;
}

.social-proof-section h3 {
  font-family: 'Outfit', sans-serif;
  font-size: 2rem;
  font-weight: 700;
  color: #FFFFFF;
  margin-bottom: 2rem;
}

.social-proof-stats {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
  gap: 2rem;
  margin-bottom: 3rem;
  max-width: 600px;
  margin-left: auto;
  margin-right: auto;
}

.stat-number {
  font-family: 'Outfit', sans-serif;
  font-size: 2.5rem;
  font-weight: 700;
  background: linear-gradient(135deg, #A78BFA 0%, #60A5FA 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  margin-bottom: 0.5rem;
}

.stat-label {
  font-family: 'Inter', sans-serif;
  font-size: 0.95rem;
  color: #D1D5DB;
}

.testimonials-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 2rem;
  margin-top: 2rem;
}

.testimonial-card {
  background: linear-gradient(145deg, rgba(31, 41, 55, 0.5) 0%, rgba(17, 24, 39, 0.5) 100%);
  border: 1px solid rgba(75, 85, 99, 0.3);
  border-radius: 16px;
  padding: 1.75rem;
  text-align: left;
  transition: all 0.3s ease;
}

.testimonial-card:hover {
  transform: translateY(-4px);
  border-color: rgba(124, 58, 237, 0.3);
}

.testimonial-stars {
  color: #F59E0B;
  font-size: 1.1rem;
  margin-bottom: 0.75rem;
}

.testimonial-text {
  font-family: 'Inter', sans-serif;
  font-size: 0.95rem;
  color: #E5E7EB;
  line-height: 1.6;
  margin-bottom: 1.25rem;
  font-style: italic;
}

.testimonial-author {
  font-family: 'Outfit', sans-serif;
  font-size: 1rem;
  font-weight: 700;
  color: #FFFFFF;
  margin-bottom: 0.25rem;
}

.testimonial-role {
  font-family: 'Inter', sans-serif;
  font-size: 0.85rem;
  color: #9CA3AF;
}
</style>

<div class="reda-container">
<div class="redatudo-plans-content">
  <div class="redatudo-plans-container">

    <div class="redatudo-plans-header">
      <?php
      // Link para voltar ao hub se usuário estiver logado
      if ( is_user_logged_in() && function_exists('redatudo_get_app_url') ) {
        $hub_url = redatudo_get_app_url('hub');
        if ( $hub_url ) {
          echo '<div style="margin-bottom: 2rem; text-align: center;">
            <a href="' . esc_url($hub_url) . '" 
               class="redatudo-plans-back">
              ← Voltar para o Hub de Soluções
            </a>
          </div>';
        }
      }
      ?>
      <h1>🚀 Escolha Seu Pacote de Créditos</h1>
      <div class="redatudo-plans-subheader">
        Potencialize sua criação de conteúdo com IA. Escolha o pacote ideal e tenha acesso ilimitado às nossas ferramentas de inteligência artificial.
      </div>
    </div>

    <!-- Seção Explicativa -->
    <div class="credits-explainer">
      <h3>💡 Como Funcionam os Créditos?</h3>
      <p>Nossos créditos são <strong>flexíveis e adaptáveis</strong>. O custo varia conforme o tipo de conteúdo que você quer criar - você paga apenas pelo que usa, sem desperdício.</p>
      
      <div class="credits-cost-table">
        <div class="cost-row">
          <div class="cost-icon">📝</div>
          <div class="cost-info">
            <div class="cost-title">Conteúdo Texto</div>
            <div class="cost-desc">Posts, legendas, artigos: <span>~1-3 créditos</span></div>
          </div>
        </div>
        <div class="cost-row">
          <div class="cost-icon">🖼️</div>
          <div class="cost-info">
            <div class="cost-title">Imagens com IA</div>
            <div class="cost-desc">Geração de imagem: <span>5 créditos por imagem</span></div>
          </div>
        </div>
        <div class="cost-row">
          <div class="cost-icon">📚</div>
          <div class="cost-info">
            <div class="cost-title">Livros & eBooks</div>
            <div class="cost-desc">Varia conforme tamanho: <span>~1-5+ créditos/capítulo</span></div>
          </div>
        </div>
        <div class="cost-row">
          <div class="cost-icon">🎓</div>
          <div class="cost-info">
            <div class="cost-title">TCCs & Pesquisas</div>
            <div class="cost-desc">Conteúdo aprofundado: <span>~2-4 créditos/seção</span></div>
          </div>
        </div>
      </div>

      <div class="credits-note">
        <strong>ℹ️ Dica:</strong> Deixamos você <strong>estimar os créditos</strong> antes de usar. Utilize seus créditos gratuitos para estimar custos.
      </div>
    </div>

    <!-- Por que Créditos? -->
    <div class="why-credits-section">
      <h3>✨ Por Que Créditos?</h3>
      <div class="why-benefits">
        <div class="why-benefit">
          <div class="why-icon">✌️</div>
          <div class="why-content">
            <strong>Pague Apenas Pelo Que Usa</strong>
            <p>Sem surpresas. Créditos não vencerão e você só gasta quando de fato criar conteúdo.</p>
          </div>
        </div>
        <div class="why-benefit">
          <div class="why-icon">🚀</div>
          <div class="why-content">
            <strong>Flexibilidade Máxima</strong>
            <p>Crie um post ou um livro inteiro. O custo é justo para cada tipo de conteúdo.</p>
          </div>
        </div>
        <div class="why-benefit">
          <div class="why-icon">🎯</div>
          <div class="why-content">
            <strong>Sem Desperdício</strong>
            <p>Use seus créditos quando quiser. Nada de cotas mensais que expiram.</p>
          </div>
        </div>
      </div>
    </div>


    <div class="redatudo-plans-grid">
      <?php 
      $total_variations = count($variations);
      foreach ( $variations as $i => $variation ) :
        $variation_id = $variation['variation_id'];
        $price = $variation['display_price'];
        $price_html = wc_price( $price );
        $attr = $variation['attributes'];
        
        // Pega o PRIMEIRO atributo (seja qual for o nome)
        $credit_value = '';
        if ( !empty($attr) ) {
          $credit_value = reset($attr);
          $credit_value = trim( str_replace( array('Créditos', 'credito', 'credit'), '', $credit_value ) );
        }
        
        // Determina qual é o plano em destaque (geralmente o do meio)
        $featured_class = ($i === 1 || ($i === floor($total_variations / 2))) ? ' redatudo-plan-featured' : '';
        $popular_badge = ($i === 1 || ($i === floor($total_variations / 2))) ? '<div class="redatudo-plan-badge">⭐ Mais Escolhido</div>' : '';
        
        // Badge de economia para o maior pacote
        $savings_badge = ($i === $total_variations - 1 && $total_variations > 1) ? '<div class="redatudo-plan-savings">💰 Melhor Custo-Benefício</div>' : '';

        $variation_obj = wc_get_product( $variation_id );
        $variation_description = $variation_obj ? $variation_obj->get_description() : '';
        $default_features = array(
          'Acesso a 13 ferramentas de IA',
          'Geração ilimitada de conteúdo',
          'Atualizações automáticas',
          'Sem mensalidades',
          'Sem taxa de cancelamento'
        );
        
        if ( ! empty( $variation_description ) ) {
          $features_from_desc = array_filter(explode( "\n", trim( $variation_description ) ));
          if ( ! empty( $features_from_desc ) ) {
            $default_features = $features_from_desc;
          }
        }
      ?>
        <div class="redatudo-plan-card<?php echo $featured_class; ?>">
          <?php echo $popular_badge; ?>
          <?php echo $savings_badge; ?>

          <div class="redatudo-plan-title">
            <?php echo esc_html( $credit_value ? $credit_value . ' Créditos' : $variation['variation_description'] ); ?>
          </div>
          
          <div class="redatudo-plan-subtitle">
            Perfeito para <?php 
              if ($i === 0) echo 'iniciantes';
              elseif ($i === 1) echo 'criadores regulares';
              else echo 'equipes e produtores';
            ?>
          </div>

          <div class="redatudo-plan-price"><?php echo $price_html; ?></div>
          <div class="redatudo-plan-period">por mês</div>

          <ul class="redatudo-plan-features">
            <?php foreach ($default_features as $feature) : ?>
              <li><?php echo esc_html( trim( $feature ) ); ?></li>
            <?php endforeach; ?>
          </ul>

          <?php if ( in_array( $variation_id, $user_active_variations ) ) : ?>
            <button class="redatudo-plan-button disabled" disabled>
              ✓ Seu Plano Atual
            </button>
          <?php else : ?>
            <?php
            $checkout_url = '/checkout/?add-to-cart=' . esc_js($variation_id);
            if (isset($_GET['switch-subscription'])) {
              $checkout_url .= '&switch-subscription=' . urlencode($_GET['switch-subscription']);
            }
            if (isset($_GET['item'])) {
              $checkout_url .= '&item=' . urlencode($_GET['item']);
            }
            if (isset($_GET['_wcsnonce'])) {
              $checkout_url .= '&_wcsnonce=' . urlencode($_GET['_wcsnonce']);
            }
            ?>
            <button class="redatudo-plan-button" onclick="window.location.href='<?php echo $checkout_url; ?>'">
              Adquirir Créditos
              <span class="btn-subtext">Ative em segundos</span>
            </button>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Garantias -->
    <div class="redatudo-plans-guarantees">
      <div class="guarantees-grid">
        <div class="guarantee-item">
          <span class="guarantee-icon">🔒</span>
          <div class="guarantee-title">Pagamento Seguro</div>
          <div class="guarantee-desc">Transação 100% protegida e criptografada</div>
        </div>
        <div class="guarantee-item">
          <span class="guarantee-icon">💳</span>
          <div class="guarantee-title">Todas as Formas</div>
          <div class="guarantee-desc">Cartão, Pix, Boleto - Você escolhe</div>
        </div>
        <div class="guarantee-item">
          <span class="guarantee-icon">⚡</span>
          <div class="guarantee-title">Ativação Instantânea</div>
          <div class="guarantee-desc">Créditos liberados em segundos</div>
        </div>
        <div class="guarantee-item">
          <span class="guarantee-icon">🎯</span>
          <div class="guarantee-title">Suporte Prioritário</div>
          <div class="guarantee-desc">Tire dúvidas a qualquer momento</div>
        </div>
      </div>
    </div>

        <!-- Prova Social -->
    <div class="social-proof-section">
      <h3>O que Dizem +12 mil Criadores</h3>
      
      <div class="social-proof-stats">
        <div class="stat-item">
          <div class="stat-number">287k+</div>
          <div class="stat-label">Conteúdos Criados</div>
        </div>
        <div class="stat-item">
          <div class="stat-number">12.4k</div>
          <div class="stat-label">Usuários Ativos</div>
        </div>
        <div class="stat-item">
          <div class="stat-number">4.9★</div>
          <div class="stat-label">Avaliação Média</div>
        </div>
      </div>

      <div class="testimonials-grid">
        <div class="testimonial-card">
          <div class="testimonial-stars">★★★★★</div>
          <p class="testimonial-text">"Gerava 1 post por semana. Agora gero 7 em 30 minutos. O gerador de hashtags sozinho já vale a assinatura. Meu engajamento subiu 340%!"</p>
          <div class="testimonial-author">Carolina Santos</div>
          <div class="testimonial-role">Criadora de Conteúdo</div>
        </div>
        
        <div class="testimonial-card">
          <div class="testimonial-stars">★★★★★</div>
          <p class="testimonial-text">"Criei meu primeiro ebook em 2 horas. Vendi 47 cópias na primeira semana. O RedaTudo pagou a assinatura anual no primeiro dia!"</p>
          <div class="testimonial-author">Marcos Oliveira</div>
          <div class="testimonial-role">Infoprodutor</div>
        </div>
        
        <div class="testimonial-card">
          <div class="testimonial-stars">★★★★★</div>
          <p class="testimonial-text">"O corretor ABNT salvou meu TCC. Formatou 80 páginas em minutos. Minha orientadora aprovou de primeira. Indispensável para universitários!"</p>
          <div class="testimonial-author">Ana Paula</div>
          <div class="testimonial-role">Estudante de Direito</div>
        </div>
        
        <div class="testimonial-card">
          <div class="testimonial-stars">★★★★★</div>
          <p class="testimonial-text">"Uso o ShopCopy para descrever +200 produtos. Antes demorava 2h por descrição. Agora são 3 minutos. Minhas conversões subiram 28%."</p>
          <div class="testimonial-author">Roberto Alves</div>
          <div class="testimonial-role">E-commerce Moda</div>
        </div>
        
        <div class="testimonial-card">
          <div class="testimonial-stars">★★★★★</div>
          <p class="testimonial-text">"Como redatora freelancer, o humanizador e reformulador são meus melhores amigos. Entrego 3x mais projetos sem perder qualidade."</p>
          <div class="testimonial-author">Juliana Costa</div>
          <div class="testimonial-role">Redatora Freelancer</div>
        </div>
        
        <div class="testimonial-card">
          <div class="testimonial-stars">★★★★★</div>
          <p class="testimonial-text">"Produzo vídeos educacionais e preciso de roteiros constantemente. O gerador de ideias + títulos acelerou minha produção em 500%."</p>
          <div class="testimonial-author">Lucas Ferreira</div>
          <div class="testimonial-role">YouTuber Educacional</div>
        </div>
      </div>
    </div>

  </div>
</div>
</div>

<?php
  do_action( 'woocommerce_after_single_product' );
  get_footer( 'shop' );
  return;

// ============================================
// PRODUTOS SIMPLES → LAYOUT PADRÃO WOOCOMMERCE
// ============================================
else : ?>

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
</style>

<div class="reda-container">
<?php do_action( 'woocommerce_before_single_product' );
if ( post_password_required() ) { echo get_the_password_form(); return; }
?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class('redaprod-card', $product ); ?>>

  <div class="redaprod-imgside">
    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" />
  </div>

  <div class="redaprod-main">
    <h1 class="reda-grad-title"><?php the_title(); ?></h1>
    <?php woocommerce_template_single_rating(); ?>
    <div class="redaprod-desc"><?php the_excerpt(); ?></div>
    
    <div class="redaprod-price"><?php echo $product->get_price_html(); ?></div>
    
    <form class="cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', get_permalink($product->get_id()) ) ); ?>" method="post" enctype="multipart/form-data">
      <div class="redaprod-cta">
        <input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" />
        <button type="submit" class="single_add_to_cart_button button alt"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>
      </div>
    </form>

    <div class="redaprod-meta">
      <?php do_action( 'woocommerce_product_meta_start' ); ?>
      <?php echo wc_get_product_category_list( $product->get_id(), ', ', '<strong>Categorias: </strong>', '' ); ?>
      <?php do_action( 'woocommerce_product_meta_end' ); ?>
    </div>
  </div>
</div>

<div class="product-tabs" style="margin-top:2.7rem;">
  <?php woocommerce_output_product_data_tabs(); ?>
  <br><br>
  <?php woocommerce_output_related_products(); ?>
</div>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
<?php get_footer( 'shop' ); ?>

<?php endif; ?>
