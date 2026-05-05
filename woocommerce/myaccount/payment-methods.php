<?php
/**
 * Payment methods
 *
 * Shows customer payment methods on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/payment-methods.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.6.0
 */

defined( 'ABSPATH' ) || exit;

$saved_methods = wc_get_customer_saved_methods_list( get_current_user_id() );
$has_methods   = (bool) $saved_methods;
$types         = wc_get_account_payment_methods_types();

do_action( 'woocommerce_before_account_payment_methods', $has_methods ); ?>

<style>
.reda-payment-methods-card {
    background: #181733ee;
    border-radius: 22px;
    box-shadow: 0 4px 32px #00bfff1a;
    padding: 2.3em 2em;
    margin-bottom: 2rem;
    font-family: 'Orbitron', Arial, sans-serif;
    color: #b8e6ff;
}

.reda-payment-methods-card h3 {
    font-size: 1.4rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    background: linear-gradient(100deg,#00ffd0 60%,#7f00ff 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    text-align: center;
}

.reda-payment-methods-card table {
    width: 100%;
    border-collapse: collapse;
    border-radius: 18px;
    overflow: hidden;
}

.reda-payment-methods-card thead {
    background: #121225;
}

.reda-payment-methods-card th,
.reda-payment-methods-card td {
    padding: 1rem 1.2rem;
    text-align: left;
    border-bottom: 1px solid #232948;
    color: #e5edff;
}

.reda-payment-methods-card tr:last-child td {
    border-bottom: none;
}

.reda-payment-methods-card tr.default-payment-method {
    border-left: 4px solid #00ffd0;
    background: #141225;
}

.reda-payment-methods-card a.button {
    background: linear-gradient(90deg, #7f00ff 50%, #00bfff 100%);
    border: none;
    border-radius: 16px;
    color: #fff !important;
    font-weight: 600;
    padding: 0.5rem 1.2rem;
    text-decoration: none;
    transition: transform .15s, box-shadow .15s;
}

.reda-payment-methods-card a.button:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px #00ffd023;
}

.reda-payment-methods-card .woocommerce-info {
    background: #0f1a27;
    border-color: #00bfff55;
}

.reda-payment-methods-card .add-payment-btn {
    display: inline-block;
    margin-top: 1.5rem;
    background: linear-gradient(90deg, #7f00ff 50%, #00bfff 100%);
    border: none;
    border-radius: 22px;
    color: #fff;
    font-weight: 700;
    padding: 0.9rem 2rem;
    text-decoration: none;
    transition: transform .19s, box-shadow .14s;
}

.reda-payment-methods-card .add-payment-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 26px #00ffd084;
}
</style>

<?php if ( $has_methods ) : ?>

	<table class="woocommerce-MyAccount-paymentMethods shop_table shop_table_responsive account-payment-methods-table">
		<thead>
			<tr>
				<?php foreach ( wc_get_account_payment_methods_columns() as $column_id => $column_name ) : ?>
					<th class="woocommerce-PaymentMethod woocommerce-PaymentMethod--<?php echo esc_attr( $column_id ); ?> payment-method-<?php echo esc_attr( $column_id ); ?>"><span class="nobr"><?php echo esc_html( $column_name ); ?></span></th>
				<?php endforeach; ?>
			</tr>
		</thead>
		<?php foreach ( $saved_methods as $type => $methods ) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited ?>
			<?php foreach ( $methods as $method ) : ?>
				<tr class="payment-method<?php echo ! empty( $method['is_default'] ) ? ' default-payment-method' : ''; ?>">
					<?php foreach ( wc_get_account_payment_methods_columns() as $column_id => $column_name ) : ?>
						<td class="woocommerce-PaymentMethod woocommerce-PaymentMethod--<?php echo esc_attr( $column_id ); ?> payment-method-<?php echo esc_attr( $column_id ); ?>" data-title="<?php echo esc_attr( $column_name ); ?>">
							<?php
							if ( has_action( 'woocommerce_account_payment_methods_column_' . $column_id ) ) {
								do_action( 'woocommerce_account_payment_methods_column_' . $column_id, $method );
							} elseif ( 'method' === $column_id ) {
								if ( ! empty( $method['method']['last4'] ) ) {
									/* translators: 1: credit card type 2: last 4 digits */
									echo sprintf( esc_html__( '%1$s ending in %2$s', 'woocommerce' ), esc_html( wc_get_credit_card_type_label( $method['method']['brand'] ) ), esc_html( $method['method']['last4'] ) );
								} else {
									echo esc_html( wc_get_credit_card_type_label( $method['method']['brand'] ) );
								}
							} elseif ( 'expires' === $column_id ) {
								echo esc_html( $method['expires'] );
							} elseif ( 'actions' === $column_id ) {
								foreach ( $method['actions'] as $key => $action ) { // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
									echo '<a href="' . esc_url( $action['url'] ) . '" class="button ' . sanitize_html_class( $key ) . '">' . esc_html( $action['name'] ) . '</a>&nbsp;';
								}
							}
							?>
						</td>
					<?php endforeach; ?>
				</tr>
			<?php endforeach; ?>
		<?php endforeach; ?>
	</table>

<?php else : ?>

	<p class="woocommerce-Message woocommerce-Message--info woocommerce-info"><?php esc_html_e( 'No saved methods found.', 'woocommerce' ); ?></p>

<?php endif; ?>

<?php do_action( 'woocommerce_after_account_payment_methods', $has_methods ); ?>

<?php if ( WC()->payment_gateways->get_available_payment_gateways() ) : ?>
	<a class="add-payment-btn" href="<?php echo esc_url( wc_get_endpoint_url( 'add-payment-method' ) ); ?>"><?php esc_html_e( 'Add payment method', 'woocommerce' ); ?></a>
<?php endif; ?>
</div>
