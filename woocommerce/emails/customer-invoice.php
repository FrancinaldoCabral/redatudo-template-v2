<?php
/**
 * Customer invoice email - Redatudo custom
 * Copie para seu-tema/woocommerce/emails/customer-invoice.php
 */

use Automattic\WooCommerce\Enums\OrderStatus;
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

<?php if ( $order->needs_payment() ) { ?>
    <?php if ( $order->has_status( OrderStatus::FAILED ) ) { ?>
        <p>
	        Seu pedido <strong>#<?php echo $order->get_order_number(); ?></strong> não foi concluído devido a um problema no pagamento.<br>
	        Para garantir seus créditos ou plano no <strong>Redatudo</strong>, você pode tentar novamente agora:
	    </p>
	    <p>
	        <a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" style="color:#00bfff;font-weight:bold;">
	            Pagar esta fatura
	        </a>
	    </p>
    <?php } else { ?>
        <p>
	        Geramos sua fatura do <strong>Redatudo</strong>. Para liberar seus créditos, recursos ou plano, realize o pagamento quando estiver pronto:
	    </p>
	    <p>
	        <a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" style="color:#00ffd0;font-weight:bold;">
	            Pagar agora
	        </a>
	    </p>
    <?php } ?>
<?php } else { ?>
	<p>
	    <b>Resumo do seu pedido realizado em <?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?>:</b>
	</p>
<?php } ?>

<?php echo $email_improvements_enabled ? '</div>' : ''; ?>

<?php
/**
 * Tabela padrão de detalhes do pedido
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