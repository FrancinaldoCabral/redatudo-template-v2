<?php
/**
 * Customer completed order email - Redatudo custom
 * Copie para seu-tema/woocommerce/emails/customer-completed-order.php
 */

use Automattic\WooCommerce\Utilities\FeaturesUtil;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$email_improvements_enabled = FeaturesUtil::feature_is_enabled( 'email_improvements' );

/*
 * @hooked WC_Emails::email_header() Output the email header
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
  Seu pagamento foi aprovado e seu pedido <strong>#<?php echo $order->get_order_number(); ?></strong> no <strong>Redatudo</strong> está pronto para uso!<br>
  Agora você já pode aproveitar todos os recursos liberados do seu plano ou créditos.
</p>

<p>
  <b>Resumo do pedido:</b>
</p>
<ul style="color:#b8e6ff;font-size:1.05em;">
  <?php foreach ( $order->get_items() as $item ) : ?>
    <li><b>Produto:</b> <?php echo esc_html( $item->get_name() ); ?></li>
  <?php endforeach; ?>
  <li><b>Valor:</b> <?php echo $order->get_formatted_order_total(); ?></li>
  <li><b>Status:</b> <?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?></li>
</ul>

<p>
  Para acessar recursos, créditos ou configurar sua conta:<br>
  <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" style="color:#00bfff;font-weight:bold;">
    Minha Conta Redatudo
  </a>
</p>

<hr style="border:0;border-top:1px solid #222;margin:30px 0;">

<p>
  Precisa de ajuda? Responda este e-mail ou acesse a <a href="<?php echo esc_url( home_url('/ajuda') ); ?>" style="color:#00ffd0;">Central de Ajuda</a>.
</p>

<?php echo $email_improvements_enabled ? '</div>' : ''; ?>

<?php
/**
 * Mantém a tabela padrão de detalhes do pedido, caso deseje.
 */
do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );
do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );
do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

/**
 * Mostra conteúdo adicional (opcional, configurável via admin Woo).
 */
if ( $additional_content ) {
	echo $email_improvements_enabled ? '<table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td class="email-additional-content">' : '';
	echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
	echo $email_improvements_enabled ? '</td></tr></table>' : '';
}

/*
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );