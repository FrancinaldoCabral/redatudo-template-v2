<?php
/**
 * Template Name: Página de Afiliados
 * Description: Template moderno para a página de registro de afiliados
 */

get_header();
?>

<style>
:root {
  --roxo-ia: #7f00ff;
  --azul-tech: #00bfff;
  --preto-fundo: #101022;
  --azul-glow: #00ffd0;
}

/* Hero Section */
.affiliate-hero {
  background: linear-gradient(135deg, #101022 0%, #181736 50%, #101022 100%);
  padding: 5rem 0 4rem 0;
  position: relative;
  overflow: hidden;
}

.affiliate-hero::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: 
    radial-gradient(circle at 20% 50%, rgba(127, 0, 255, 0.15) 0%, transparent 50%),
    radial-gradient(circle at 80% 50%, rgba(0, 191, 255, 0.15) 0%, transparent 50%);
  pointer-events: none;
}

.affiliate-hero .container {
  position: relative;
  z-index: 2;
}

.affiliate-hero h1 {
  font-family: 'Orbitron', Arial, sans-serif;
  font-size: 2.8rem;
  font-weight: 800;
  background: linear-gradient(100deg, #00bfff 20%, #7f00ff 70%, #00ffd0 95%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
  margin-bottom: 1.2rem;
  letter-spacing: 1px;
  line-height: 1.2;
}

.affiliate-hero p {
  font-family: 'Inter', Arial, sans-serif;
  font-size: 1.25rem;
  color: #b8e6ff;
  line-height: 1.7;
  margin-bottom: 2rem;
  max-width: 650px;
}

.affiliate-hero .emoji-accent {
  font-size: 2.5rem;
  margin-left: 0.5rem;
  display: inline-block;
  animation: float 3s ease-in-out infinite;
}

@keyframes float {
  0%, 100% { transform: translateY(0px); }
  50% { transform: translateY(-10px); }
}

.btn-affiliate-cta {
  background: linear-gradient(90deg, #7f00ff 0%, #00bfff 100%);
  color: #fff !important;
  border: none;
  font-family: 'Orbitron', Arial, sans-serif;
  font-weight: bold;
  font-size: 1.2rem;
  padding: 1rem 2.5rem;
  border-radius: 16px;
  box-shadow: 0 4px 20px rgba(127, 0, 255, 0.4);
  transition: all 0.3s ease;
  text-transform: uppercase;
  letter-spacing: 1px;
  text-decoration: none;
  display: inline-block;
}

.btn-affiliate-cta:hover {
  background: linear-gradient(90deg, #00bfff 0%, #7f00ff 100%);
  transform: translateY(-3px) scale(1.02);
  box-shadow: 0 8px 32px rgba(0, 255, 208, 0.5);
  color: #00ffd0 !important;
}

/* Benefits Section */
.affiliate-benefits {
  background: linear-gradient(180deg, #15192a 0%, #101022 100%);
  padding: 4rem 0;
}

.affiliate-benefits h2 {
  font-family: 'Orbitron', Arial, sans-serif;
  font-size: 2.2rem;
  font-weight: 700;
  background: linear-gradient(90deg, #00bfff 30%, #00ffd0 90%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  margin-bottom: 2.5rem;
  letter-spacing: 0.5px;
}

.benefit-card {
  background: rgba(24, 23, 54, 0.6);
  border: 1px solid rgba(127, 0, 255, 0.2);
  border-radius: 20px;
  padding: 2rem;
  margin-bottom: 1.5rem;
  transition: all 0.3s ease;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
  position: relative;
  overflow: hidden;
}

.benefit-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(0, 255, 208, 0.1), transparent);
  transition: left 0.5s ease;
}

.benefit-card:hover::before {
  left: 100%;
}

.benefit-card:hover {
  border-color: rgba(0, 255, 208, 0.5);
  box-shadow: 0 8px 30px rgba(127, 0, 255, 0.3);
  transform: translateY(-4px);
}

.benefit-icon {
  font-size: 2.5rem;
  margin-bottom: 1rem;
  display: block;
  filter: drop-shadow(0 0 10px rgba(0, 255, 208, 0.3));
}

.benefit-card h3 {
  font-family: 'Orbitron', Arial, sans-serif;
  color: #00ffd0;
  font-size: 1.3rem;
  font-weight: 600;
  margin-bottom: 0.8rem;
  letter-spacing: 0.5px;
}

.benefit-card p {
  font-family: 'Inter', Arial, sans-serif;
  color: #b8e6ff;
  font-size: 1.05rem;
  line-height: 1.6;
  margin: 0;
}

/* Login Form Section */
.affiliate-form-section {
  background: #15192a;
  border-radius: 24px;
  padding: 2.5rem;
  box-shadow: 
    0 0 40px rgba(127, 0, 255, 0.2),
    inset 0 0 30px rgba(0, 191, 255, 0.05);
  border: 1px solid rgba(0, 255, 208, 0.1);
  position: sticky;
  top: 100px;
}

.affiliate-form-section h3 {
  font-family: 'Orbitron', Arial, sans-serif;
  color: #00ffd0;
  font-size: 1.5rem;
  font-weight: 700;
  margin-bottom: 1.5rem;
  text-align: center;
  letter-spacing: 1px;
}

.already-affiliate {
  text-align: center;
  margin-top: 1.5rem;
  padding-top: 1.5rem;
  border-top: 1px solid rgba(127, 0, 255, 0.2);
  font-family: 'Inter', Arial, sans-serif;
  color: #b8e6ff;
  font-size: 0.95rem;
}

.already-affiliate a {
  color: #00ffd0;
  font-weight: 600;
  text-decoration: none;
  transition: all 0.2s ease;
  font-family: 'Orbitron', Arial, sans-serif;
}

.already-affiliate a:hover {
  color: #7f00ff;
  text-decoration: underline;
}

/* Responsive */
@media (max-width: 768px) {
  .affiliate-hero h1 {
    font-size: 2rem;
  }
  
  .affiliate-hero p {
    font-size: 1.1rem;
  }
  
  .affiliate-benefits h2 {
    font-size: 1.8rem;
  }
  
  .affiliate-form-section {
    position: static;
    margin-top: 3rem;
  }
}

/* Animation on scroll */
.benefit-card {
  opacity: 0;
  transform: translateY(30px);
  animation: fadeInUp 0.6s ease forwards;
}

.benefit-card:nth-child(1) { animation-delay: 0.1s; }
.benefit-card:nth-child(2) { animation-delay: 0.2s; }
.benefit-card:nth-child(3) { animation-delay: 0.3s; }

@keyframes fadeInUp {
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>

<!-- Hero Section -->
<section class="affiliate-hero">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-12 col-lg-7">
        <h1>
          REDATUDO divide o sucesso com você<span class="emoji-accent">💰</span>
        </h1>
        <p>
          O programa de afiliados REDATUDO oferece <strong style="color: #00ffd0;">15% de comissão</strong> sobre os pagamentos dos seus indicados, 
          inclusive sobre a renovação automática das assinaturas. Seja um parceiro REDATUDO agora!
        </p>
        <a class="btn-affiliate-cta" href="#afilie-se">
          Afilie-se Agora
        </a>
      </div>
    </div>
  </div>
</section>

<!-- Benefits & Form Section -->
<section class="affiliate-benefits">
  <div class="container">
    <div class="row">
      <!-- Benefits Column -->
      <div class="col-12 col-lg-7">
        <h2>Construa riqueza com tecnologia de ponta</h2>
        
        <div class="benefit-card">
          <span class="benefit-icon">🤑</span>
          <h3>Comissão Vitalícia de 15%</h3>
          <p>
            Monetize no momento da assinatura, nas renovações e nas compras de créditos. 
            Ganhe 15% vitalício sobre tudo que seu indicado investir.
          </p>
        </div>

        <div class="benefit-card">
          <span class="benefit-icon">😉</span>
          <h3>Cookie Permanente - Lead é Dinheiro</h3>
          <p>
            Com REDATUDO você não perde lead. O cookie de afiliação não expira nunca - 
            desde que o seu clique seja o último, o indicado é seu para sempre.
          </p>
        </div>

        <div class="benefit-card">
          <span class="benefit-icon">🚀</span>
          <h3>Negócio Lucrativo e Duradouro</h3>
          <p>
            Construa um negócio inovador com tecnologia de ponta e IA, 
            o que há de mais moderno no mundo para criação de conteúdo.
          </p>
        </div>
      </div>

      <!-- Form Column -->
      <div class="col-12 col-lg-5">
        <div class="affiliate-form-section" id="afilie-se">
          <h3>Cadastro de Afiliado</h3>
          <?php echo do_shortcode('[AffiliatesLogin]'); ?>
          
          <div class="already-affiliate">
            Já é afiliado? 
            <a href="https://redatudo.online/painel-de-afiliado">Entre no painel</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
get_footer();
?>
