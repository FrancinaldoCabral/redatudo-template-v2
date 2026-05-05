<?php
/**
 * Edit address form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-address.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

$page_title = ( 'billing' === $load_address ) ? esc_html__( 'Billing address', 'woocommerce' ) : esc_html__( 'Shipping address', 'woocommerce' );

do_action( 'woocommerce_before_edit_account_address_form' ); ?>

<style>
.woocommerce-account-address-edit-wrapper,
.woocommerce-account-address-edit-wrapper .woocommerce,
.woocommerce-account-address-edit-wrapper .woocommerce form,
.woocommerce-account-address-edit-wrapper .woocommerce-MyAccount-content,
.woocommerce-account-address-edit-wrapper .woocommerce-MyAccount-content .container,
.woocommerce-account-address-edit-wrapper .woocommerce-MyAccount-content .container-fluid,
.woocommerce-account-address-edit-wrapper .woocommerce-MyAccount-content .row {
    width: 100% !important;
    max-width: none !important;
}

.woocommerce-account-address-edit {
    background: #1F2937;
    border: 2px solid #374151;
    border-radius: 20px;
    padding: 2.5rem;
    width: 100%;
    max-width: 730px;
    margin: 0 auto;
}

.woocommerce-account-address-edit form {
    background: transparent !important;
    border: none !important;
    padding: 0 !important;
    margin: 0;
    box-shadow: none !important;
}

.woocommerce-account-address-edit h3 {
    font-family: 'Outfit', sans-serif;
    font-size: 1.5rem;
    color: #FFFFFF;
    margin-bottom: 1.5rem;
}

.woocommerce-account-address-edit .woocommerce-address-fields__field-wrapper {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 1.5rem 2rem;
}

.woocommerce-account-address-edit .form-row {
    width: 100%;
}

.woocommerce-account-address-edit .form-row-wide,
.woocommerce-account-address-edit .form-row-first,
.woocommerce-account-address-edit .form-row-last {
    width: 100% !important;
}

.woocommerce-account-address-edit .form-row .input-text,
.woocommerce-account-address-edit .form-row input,
.woocommerce-account-address-edit .form-row select,
.woocommerce-account-address-edit .form-row textarea {
    width: 100% !important;
}

.woocommerce-account-address-edit .woocommerce-address-fields__field-wrapper .form-row:nth-child(odd) {
    grid-column: span 1;
}
    margin: 0 !important;
}

.woocommerce-account-address-edit label {
    color: #E5E7EB;
    font-family: 'Inter', sans-serif;
    font-weight: 600;
    margin-bottom: 0.4rem;
}

.woocommerce-account-address-edit input,
.woocommerce-account-address-edit select,
.woocommerce-account-address-edit textarea {
    background: #161622;
    border: 2px solid #374151;
    border-radius: 10px;
    padding: 0.85rem 1rem;
    color: #FFFFFF;
    width: 100%;
}

.woocommerce-account-address-edit input:focus,
.woocommerce-account-address-edit select:focus,
.woocommerce-account-address-edit textarea:focus {
    border-color: #7C3AED;
    box-shadow: 0 0 0 2px rgba(124, 58, 237, 0.25);
    outline: none;
}

.woocommerce-account-address-edit button[type="submit"] {
    margin-top: 2rem;
    background: linear-gradient(135deg, #7C3AED 0%, #3B82F6 100%);
    border: none;
    color: #FFFFFF;
    font-weight: 600;
    padding: 0.9rem 2rem;
    border-radius: 12px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.woocommerce-account-address-edit button[type="submit"]:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 24px rgba(124, 58, 237, 0.35);
}

@media (max-width: 768px) {
    .woocommerce-account-address-edit {
        padding: 1.5rem;
    }
}
</style>


<div class="woocommerce-account-address-edit-wrapper">
<div class="woocommerce-account-address-edit">
	<?php if ( ! $load_address ) : ?>
		<?php wc_get_template( 'myaccount/my-address.php' ); ?>
	<?php else : ?>

		<form method="post" class="address-edit-form">

			<h3><?php echo apply_filters( 'woocommerce_my_account_edit_address_title', $page_title, $load_address ); ?></h3><?php // @codingStandardsIgnoreLine ?>
			<?php do_action( "woocommerce_before_edit_address_form_{$load_address}" ); ?>
			<?php
				foreach ( $address as $key => $field ) {
					woocommerce_form_field( $key, $field, wc_get_post_data_by_key( $key, $field['value'] ) );
				}
			?>
			<?php do_action( "woocommerce_after_edit_address_form_{$load_address}" ); ?>
			<button type="submit" name="save_address" value="<?php esc_attr_e( 'Save address', 'woocommerce' ); ?>"><?php esc_html_e( 'Save address', 'woocommerce' ); ?></button>
			<?php wp_nonce_field( 'woocommerce-edit_address', 'woocommerce-edit-address-nonce' ); ?>
			<input type="hidden" name="action" value="edit_address" />

		</form>

<?php endif; ?>

	<?php do_action( 'woocommerce_after_edit_account_address_form' ); ?>
    </div>
</div>
</div>
