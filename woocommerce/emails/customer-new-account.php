<?php
/**
 * Customer new account email - Redatudo custom
 * Copie este arquivo para seu-tema/woocommerce/emails/customer-new-account.php
 */
defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_email_header', $email_heading, $email );
?>

<p style="font-size:1.15em;">
  Olá <?php echo esc_html( $user_login ); ?>,
</p>

<p>
  Seja bem-vindo(a) ao <strong>Redatudo</strong>! Sua conta foi criada com sucesso e agora você pode explorar todo o poder da nossa plataforma de IA para gerar conteúdos, criar ebooks e muito mais.
</p>

<p>
  <strong>Seu usuário:</strong> <span style="color:#00ffd0;"><?php echo esc_html( $user_login ); ?></span>
</p>

<p>
  Acesse sua área de conta para acompanhar seus créditos, gerenciar assinaturas e acessar todos os recursos:<br>
  <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" style="color: #00bfff; font-weight:bold;">
    Minha Conta Redatudo
  </a>
</p>

<?php if ( 'yes' === get_option( 'woocommerce_registration_generate_password' ) && $password_generated && $set_password_url ) : ?>
  <p>
    <a href="<?php echo esc_attr( $set_password_url ); ?>" style="color:#7f00ff;font-weight:bold;">
      Clique aqui para definir sua senha de acesso.
    </a>
  </p>
<?php endif; ?>

<hr style="border:0;border-top:1px solid #222;margin:30px 0;">
<p>
  Dúvidas? Responda este e-mail ou acesse nossa <a href="<?php echo esc_url( home_url('/ajuda') ); ?>" style="color:#00ffd0;">Central de Ajuda</a>.
</p>

<?php
if ( $additional_content ) {
	echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
}
do_action( 'woocommerce_email_footer', $email );
?>