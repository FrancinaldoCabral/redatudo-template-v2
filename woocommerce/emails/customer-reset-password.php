<?php
/**
 * Customer Reset Password email - Redatudo custom
 * Copie para seu-tema/woocommerce/emails/customer-reset-password.php
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

do_action( 'woocommerce_email_header', $email_heading, $email );
?>

<p style="font-size:1.15em;">
<?php printf( 'Olá %s,', esc_html( $user_login ) ); ?>
</p>

<p>
  Recebemos uma solicitação de redefinição de senha para sua conta no <strong>Redatudo</strong>.<br>
  Se foi você quem pediu, basta clicar no link abaixo para criar uma nova senha.
</p>

<p>
  <strong>Usuário:</strong> <span style="color:#00ffd0;"><?php echo esc_html( $user_login ); ?></span>
</p>

<p style="margin: 30px 0;">
  <a style="background:linear-gradient(90deg,#00bfff,#7f00ff);color:#fff!important;padding:13px 28px;border-radius:22px;font-family:'Orbitron',Arial,sans-serif;font-size:1.11em;text-decoration:none;display:inline-block;" href="<?php echo esc_url( add_query_arg( array( 'key' => $reset_key, 'id' => $user_id ), wc_get_endpoint_url( 'lost-password', '', wc_get_page_permalink( 'myaccount' ) ) ) ); ?>">
    Redefinir minha senha
  </a>
</p>

<p>
  <span style="color:#b8e6ff;">Se você não pediu para redefinir sua senha, apenas ignore este e-mail. Sua senha permanecerá a mesma.</span>
</p>

<?php
if ( $additional_content ) {
	echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
}
do_action( 'woocommerce_email_footer', $email );
?>