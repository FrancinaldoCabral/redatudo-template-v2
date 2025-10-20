<?php
defined( 'ABSPATH' ) || exit;
?>

<style>
#redatudo-thankyou-wrap {
  max-width: 600px;
  margin: 4rem auto 2.5rem auto;
  font-family: 'Orbitron', Arial, sans-serif;
}
.redathank-glass {
  background: rgba(17,23,39,0.98);
  border-radius: 28px;
  box-shadow: 0 6px 38px #00bfff33, 0 1px 2px #7f00ff10;
  padding: 2.6em 2em 1.6em 2em;
  text-align: center;
  position: relative;
}
.redathank-check {
  width: 64px; height: 64px; display: inline-block;
  border-radius: 50%; background: linear-gradient(90deg,#00bfff 60%,#7f00ff 100%);
  box-shadow: 0 2px 18px #00ffd038;
  margin-bottom: 1.4em; position: relative;
  animation: popCheck .7s cubic-bezier(.55,1.5,.55,1.1);
}
@keyframes popCheck {
  0% { transform: scale(0);}
  60% { transform: scale(1.15);}
  100% {transform:scale(1);}
}
.redathank-check svg {
  display: block; margin: 0 auto; margin-top: 11px;
}
.redathank-title {
  font-size: 2rem;
  font-weight: 700;
  background: linear-gradient(90deg,#00bfff,#7f00ff 70%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  margin-bottom: .32em;
  letter-spacing: 1.7px;
}
.redathank-msg {
  color: #b8e6ff;
  font-size: 1.07em;
  margin-bottom: 1.7em;
  line-height: 1.6;
}
.redathank-btn {
  margin-top: .4em;
  margin-bottom: 1.9em;
  font-family: 'Orbitron', Arial, sans-serif;
  font-size: 1.13em;
  font-weight: bold;
  border-radius: 22px;
  background: linear-gradient(90deg, #7f00ff 55%, #00bfff 100%);
  color: #fff !important;
  padding: .85em 2.2em;
  border: none;
  box-shadow: 0 2px 16px #00bfff30;
  transition: transform .21s, box-shadow .22s, background .21s;
  text-decoration: none !important;
  display: inline-block;
}
.redathank-btn:hover {
  background: linear-gradient(92deg, #00bfff 60%, #7f00ff 100%);
  transform: translateY(-2px) scale(1.03);
  box-shadow: 0 8px 22px #00ffd084;
}
.redathank-order {
  background: rgba(0,255,208,0.06);
  border-radius: 16px;
  margin: 2.1em 0 0 0;
  display: flex; flex-direction: column; gap: .7em;
  align-items: flex-start;
  padding: 1.1em 1.3em;
  font-size: 1.01em;
  color: #b8e6ff;
  text-align: left;
}
.redathank-order strong {
  color: #00ffd0;
  font-weight: 700;
}
@media(max-width:600px){
  #redatudo-thankyou-wrap{padding: 0.6em;}
  .redathank-glass{padding:1.1em 0.8em;}
  .redathank-title{font-size:1.2rem;}
}


#redatudo-finish-transition {
  position: fixed;
  inset: 0;
  background: linear-gradient(120deg, #0d0d13 60%, #7f00ff 100%);
  z-index: 999999;
  display: flex;
  align-items: center;
  justify-content: center;
  animation: reda-slide-in 0.75s cubic-bezier(.8,.2,.4,1);
  transition: opacity 0.55s cubic-bezier(.6,0,.4,1), transform 0.55s;
}
#redatudo-finish-transition.fadeout {
  opacity: 0;
  pointer-events: none;
  transform: translateY(-90px) scale(1.05) skewX(-10deg);
  transition: opacity 0.55s, transform 0.9s cubic-bezier(.36,1.2,.56,1.1);
}
@keyframes reda-slide-in {
  0%   { opacity:0; transform:translateY(70px) scale(.97) skewX(10deg);}
  80%  { opacity:1; transform:translateY(-12px) scale(1.08) skewX(-7deg);}
  100% { opacity:1; transform:none;}
}
.redatudo-finish-inner {
  display:flex; flex-direction:column; align-items:center; gap:1.3em;
  animation: reda-finish-pop 1.1s cubic-bezier(.5,1.5,.5,1.1);
}
@keyframes reda-finish-pop {
  0%   { transform:scale(0.82);}
  75%  { transform:scale(1.11);}
  100% { transform:scale(1);}
}
#redatudo-finish-transition img {
  width: 80px; height: 80px;
  filter: drop-shadow(0 0 32px #00ffd0cc) drop-shadow(0 0 10px #7f00ff60);
  animation: reda-pulse 1.2s infinite cubic-bezier(.5,0,.5,1);
}
.reda-finish-msg {
  font-family: 'Orbitron', Arial, sans-serif;
  color: #00ffd0;
  font-size: 1.32em;
  font-weight: 700;
  letter-spacing: 1.6px;
  text-shadow: 0 0 18px #7f00ff50;
  margin-top:.7em;
}
body.redatudo-finish-block { overflow: hidden !important; }
</style>

<!-- Overlay de Transição Mercado Livre Style -->
<div id="redatudo-finish-transition">
  <div class="redatudo-finish-inner">
    <img src="https://redatudo.online/wp-content/uploads/2025/04/logotipo-redatudo-sem-fundo.png" alt="Concluído Redatudo" />
    <div class="reda-finish-msg">Pedido confirmado!</div>
  </div>
</div>
<audio id="reda-success-audio" preload="auto" style="display:none">
  <source src="https://redatudo.online/wp-content/uploads/2025/05/success-payment-sound-redatudo.wav" type="audio/mpeg">
  <!-- Use um SFX curto de sucesso. Pode ser esse https://cdn.pixabay.com/audio/2022/03/15/audio_115b9b4b44.mp3 -->
</audio>
<div id="reda-thankyou-content" style="opacity:0; transition:opacity .7s cubic-bezier(.55,.2,.6,1);">
  
<div id="redatudo-thankyou-wrap">
<?php if ( $order ) : do_action( 'woocommerce_before_thankyou', $order->get_id() ); ?>

  <div class="redathank-glass">

    <div class="redathank-check">
      <!-- Animated checkmark SVG -->
      <svg width="42" height="42" viewBox="0 0 42 42">
        <circle cx="21" cy="21" r="20" fill="none"/>
        <polyline points="13,23 19,29 29,16" fill="none" stroke="#fff" stroke-width="3.2" stroke-linecap="round" stroke-linejoin="round" />
      </svg>
    </div>

    <div class="redathank-title">
      <?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Pedido confirmado! 🚀', 'woocommerce' ), $order ); ?>
    </div>

    <div class="redathank-msg">
      Sua compra foi processada com sucesso.<br>
      <strong>Agora é só acessar o seu Dashboard de IA Redatudo e começar a criar conteúdos!</strong>
    </div>

    <a href="https://chat.redatudo.online/?token=<?php echo token_generate();?>" class="redathank-btn" target="_blank" rel="noopener">
      Acessar Dashboard IA
    </a>

    <div class="redathank-order">
      <div><?php esc_html_e( 'Pedido nº:', 'woocommerce' ); ?> <strong><?php echo $order->get_order_number(); ?></strong></div>
      <div><?php esc_html_e( 'Data:', 'woocommerce' ); ?> <strong><?php echo wc_format_datetime( $order->get_date_created() ); ?></strong></div>
      <?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
      <div><?php esc_html_e( 'Email:', 'woocommerce' ); ?> <strong><?php echo $order->get_billing_email(); ?></strong></div>
      <?php endif; ?>
      <div><?php esc_html_e( 'Valor total:', 'woocommerce' ); ?> <strong><?php echo $order->get_formatted_order_total(); ?></strong></div>
      <?php if ( $order->get_payment_method_title() ) : ?>
      <div><?php esc_html_e( 'Pagamento:', 'woocommerce' ); ?> <strong><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong></div>
      <?php endif; ?>
    </div>

    <?php // do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
    <?php // do_action( 'woocommerce_thankyou', $order->get_id() ); ?>

  </div>

	<?php else : ?>
	<div class="redathank-glass">
		<div class="redathank-check">
		<svg width="42" height="42" viewBox="0 0 42 42">
			<circle cx="21" cy="21" r="20" fill="none"/>
			<polyline points="13,23 19,29 29,16" fill="none" stroke="#fff" stroke-width="3.2" stroke-linecap="round" stroke-linejoin="round" />
		</svg>
		</div>
		<div class="redathank-title">
		<?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Pedido recebido!', 'woocommerce' ), null ); ?>
		</div>
		<div class="redathank-msg">
		Obrigado pela sua compra.<br>
		Em alguns instantes, seu acesso será liberado.
		</div>
	</div>
	<?php endif; ?>
</div>
</div>

<script>
jQuery(function($){
  // Bloqueia scroll enquanto overlay
  $('body').addClass('redatudo-finish-block');
  let redaAudio = document.getElementById('reda-success-audio');
  if (redaAudio) {
    redaAudio.volume = 0.65;
    redaAudio.play().catch(function(){});
  }
  // Espera, faz fade out do overlay
  setTimeout(function(){
    $('#redatudo-finish-transition').addClass('fadeout');
    setTimeout(function(){
      $('#redatudo-finish-transition').remove();
      $('body').removeClass('redatudo-finish-block');
      // Agora faz fade-in no conteúdo
      $('#reda-thankyou-content').css('opacity',1);
    }, 700);
  }, 1200);
});
</script>