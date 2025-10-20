<?php
/**
 * Customer note email - Redatudo custom
 * Copie para seu-tema/woocommerce/emails/customer-note.php
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
  Adicionamos uma nova mensagem ao seu pedido <strong>#<?php echo $order->get_order_number(); ?></strong> no <strong>Redatudo</strong>:
</p>

<blockquote style="border-left:4px solid #00ffd0;padding-left:14px;background:#1010221a;margin:18px 0 18px 0;">
  <?php echo wpautop( wptexturize( make_clickable( $customer_note ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
</blockquote>

<p>
  <b>Fique tranquilo:</b> você pode acompanhar todo o histórico e status do seu pedido em sua área de cliente.<br>
  <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" style="color:#00bfff;font-weight:bold;">
    Minha Conta Redatudo
  </a>
</p>

<p>
  <span style="color:#b8e6ff;">Abaixo, seguem os detalhes do seu pedido para referência:</span>
</p>

<?php echo $email_improvements_enabled ? '</div>' : ''; ?>

<?php
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

/*
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );