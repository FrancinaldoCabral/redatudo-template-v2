<?php
/**
 * Customer failed order email - Redatudo custom
 * Copie para seu-tema/woocommerce/emails/customer-failed-order.php
 */

use Automattic\WooCommerce\Utilities\FeaturesUtil;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$email_improvements_enabled = FeaturesUtil::feature_is_enabled( 'email_improvements' );

/**
 * Header
 */
do_action( 'woocommerce_email_header', $email_heading, $email );
?>

<?php echo $email_improvements_enabled ? '<div class="email-introduction">' : ''; ?>

<p style="font-size:1.15em;">
<?php
if ( ! empty( $order->get_billing_first_name() ) ) {
	printf( 'Olá %s,', esc_html( $order->get_billing_first_name() ) );
} else {
	printf( 'Olá,');
}
?>
</p>

<p>
  Infelizmente não foi possível concluir seu pedido <strong>#<?php echo $order->get_order_number(); ?></strong> no <strong>Redatudo</strong> devido a um problema no pagamento.<br>
  Não se preocupe, você pode tentar novamente e garantir seus créditos ou acesso ao plano desejado.
</p>

<p>
  <b>O que fazer agora?</b><br>
  - Verifique se seus dados de pagamento estão corretos.<br>
  - Tente um cartão ou método diferente.<br>
  - Se precisar de ajuda, nosso suporte está disponível para você.
</p>

<p>
  <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" style="color:#00bfff;font-weight:bold;">
    Refazer Pedido
  </a> &nbsp;|&nbsp;
  <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" style="color:#00ffd0;font-weight:bold;">
    Minha Conta
  </a>
</p>

<hr style="border:0;border-top:1px solid #222;margin:30px 0;">

<p>
  Dúvidas? Responda este e-mail ou acesse nossa <a href="<?php echo esc_url( home_url('/ajuda') ); ?>" style="color:#00ffd0;">Central de Ajuda</a>.
</p>

<?php echo $email_improvements_enabled ? '</div>' : ''; ?>

<?php
/**
 * Detalhes padrão do pedido (tabela Woo)
 */
do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );
do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );
do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

/**
 * Conteúdo adicional (opcional)
 */
if ( $additional_content ) {
	echo $email_improvements_enabled ? '<table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td class="email-additional-content">' : '';
	echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
	echo $email_improvements_enabled ? '</td></tr></table>' : '';
}

/**
 * Footer
 */
do_action( 'woocommerce_email_footer', $email );