<?php
/**
 * Add payment method form form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-add-payment-method.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.3.0
 */

defined( 'ABSPATH' ) || exit;

$available_gateways = WC()->payment_gateways->get_available_payment_gateways();?>

<style>
.reda-payment-card-wrapper,
.reda-payment-card-wrapper .woocommerce,
.reda-payment-card-wrapper .woocommerce form {
    width: 100%;
}

.reda-payment-card-wrapper {
    max-width: 760px;
    margin: 0 auto 2.5rem;
    padding: 0 1rem;
}

.reda-payment-card {
    background: #181733ee;
    border-radius: 22px;
    box-shadow: 0 4px 32px #00bfff1a;
    padding: 2.5em 2.1em 2.2em;
    font-family: 'Orbitron', Arial, sans-serif;
    color: #b8e6ff;
}

.reda-payment-card-title {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    background: linear-gradient(100deg,#00ffd0 60%,#7f00ff 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    text-align: center;
    letter-spacing: 1px;
}

.reda-payment-card .payment_methods {
    list-style: none;
    padding: 0;
    margin: 0 0 1.5rem;
    display: flex;
    flex-direction: column;
    gap: 0.85rem;
}

.reda-payment-card .payment_methods li {
    background: #141225;
    border: 1.5px solid #232948;
    border-radius: 16px;
    padding: 1.1rem 1.25rem;
    text-align: left;
    transition: border-color .2s, box-shadow .2s;
}

.reda-payment-card .payment_methods li.active-method,
.reda-payment-card .payment_methods li:hover {
    border-color: #00ffd0;
    box-shadow: 0 6px 18px #00ffd014;
}

.reda-payment-card .payment_methods label {
    display: flex;
    align-items: center;
    gap: 0.8rem;
    color: #00ffd0;
    font-weight: 600;
    cursor: pointer;
    margin: 0;
}

.reda-payment-card input[type="radio"] {
    accent-color: #00ffd0;
    transform: scale(1.05);
}

.reda-payment-card .woocommerce-PaymentBox {
    margin-top: 1rem;
    background: #0f0f1f;
    border-radius: 16px;
    padding: 1rem 1.1rem;
    border: 1px dashed #2c3560;
}

.reda-payment-card .woocommerce-PaymentBox label {
    color: #00ffd0;
    font-weight: 600;
    letter-spacing: .4px;
}

.reda-payment-card input[type="text"],
.reda-payment-card input[type="email"],
.reda-payment-card input[type="tel"],
.reda-payment-card select {
    border-radius: 14px !important;
    border: 1.5px solid #28286e !important;
    background: #171727 !important;
    color: #eaffee !important;
    padding: 0.85em 1.08em;
    font-size: 1rem;
    font-family: 'Orbitron', Arial, sans-serif;
}

.reda-payment-card .checkbox {
    display: flex;
    align-items: center;
    gap: 0.8rem;
    color: #00ffd0;
    margin-top: 1rem;
}

.reda-payment-card .checkbox input[type="checkbox"] {
    width: 20px;
    height: 20px;
    accent-color: #00ffd0;
}

.reda-payment-card .checkbox label {
    font-family: 'Orbitron', Arial, sans-serif;
    font-size: 1rem;
    color: #b8e6ff;
}

.reda-payment-card .checkbox span.optional {
    color: #7c8ba6;
    font-size: .9rem;
}

.reda-payment-card .checkbox {
    display: flex;
    align-items: center;
    gap: 0.8rem;
    color: #00ffd0;
    margin-top: 1rem;
}

.reda-payment-card .checkbox input[type="checkbox"] {
    width: 20px;
    height: 20px;
    padding: 0;
}

.reda-payment-card .checkbox span.optional {
    color: #7c8ba6;
    font-size: .9rem;
}

.reda-payment-card input[type="text"]:focus,
.reda-payment-card input[type="email"]:focus,
.reda-payment-card input[type="tel"]:focus,
.reda-payment-card select:focus {
    border-color: #00ffd0 !important;
    background: #101022 !important;
    color: #00ffd0 !important;
    box-shadow: 0 2px 13px #00ffd023;
}

.reda-payment-card button.submit-add-method {
    background: linear-gradient(90deg, #7f00ff 50%, #00bfff 100%);
    border: none;
    border-radius: 22px;
    color: #fff;
    font-weight: 700;
    font-size: 1.1rem;
    padding: 0.95em 0;
    width: 100%;
    margin-top: 1.5rem;
    transition: transform .19s, box-shadow .14s;
    box-shadow: 0 2px 16px #00bfff50;
}

.reda-payment-card button.submit-add-method:hover {
    transform: translateY(-2px) scale(1.02);
    box-shadow: 0 8px 22px #00ffd084;
}

.reda-payment-card .p-FieldLabel,
.reda-payment-card .p-PaymentElement label,
.reda-payment-card .p-Field label,
.reda-payment-card .p-Input-input,
.reda-payment-card .p-PaymentElement input,
.reda-payment-card .p-Select-select {
    color: #2D3748 !important;
    font-weight: 600 !important;
}

.reda-payment-card .p-Input-input,
.reda-payment-card .p-PaymentElement input,
.reda-payment-card .p-Select-select {
    color: #1A202C !important;
}

@media (max-width:600px) {
    .reda-payment-card {
        padding: 1.6em 1.1em;
    }
}

#add_payment_method #payment div.payment_box, .woocommerce-cart #payment div.payment_box, .woocommerce-checkout #payment div.payment_box {
    position: relative;
    box-sizing: border-box;
    width: 100%;
    padding: 1em;
    margin: 1em 0;
    font-size: .92em;
    border-radius: 2px;
    line-height: 1.5;
    background-color: #000;
    color: #fff;
}
</style>

<div class="reda-payment-card-wrapper">
	<div class="reda-payment-card">
        <div class="reda-payment-card-title"><?php esc_html_e( 'Adicionar método de pagamento', 'woocommerce' ); ?></div>
		<?php if ( $available_gateways ) : ?>
		<form id="add_payment_method" method="post" class="reda-add-payment-form">
			<div id="payment" class="woocommerce-Payment">
				<ul class="woocommerce-PaymentMethods payment_methods methods">
					<?php
					// Chosen Method.
					if ( count( $available_gateways ) ) {
						current( $available_gateways )->set_current();
					}

					foreach ( $available_gateways as $gateway ) {
						?>
						<li class="woocommerce-PaymentMethod woocommerce-PaymentMethod--<?php echo esc_attr( $gateway->id ); ?> payment_method_<?php echo esc_attr( $gateway->id ); ?> reda-payment-method">
							<input id="payment_method_<?php echo esc_attr( $gateway->id ); ?>" type="radio" class="input-radio" name="payment_method" value="<?php echo esc_attr( $gateway->id ); ?>" <?php checked( $gateway->chosen, true ); ?> />
							<label for="payment_method_<?php echo esc_attr( $gateway->id ); ?>"><?php echo wp_kses_post( $gateway->get_title() ); ?> <?php echo wp_kses_post( $gateway->get_icon() ); ?></label>
							<?php
							if ( $gateway->has_fields() || $gateway->get_description() ) {
								echo '<div class="woocommerce-PaymentBox woocommerce-PaymentBox--' . esc_attr( $gateway->id ) . ' payment_box payment_method_' . esc_attr( $gateway->id ) . '" style="display: none;">';
								$gateway->payment_fields();
								echo '</div>';
							}
							?>
						</li>
						<?php
					}
					?>
				</ul>

				<?php do_action( 'woocommerce_add_payment_method_form_bottom' ); ?>

				<div class="form-group">
					<?php wp_nonce_field( 'woocommerce-add-payment-method', 'woocommerce-add-payment-method-nonce' ); ?>
					<button type="submit" class="submit-add-method" id="place_order" value="<?php esc_attr_e( 'Add payment method', 'woocommerce' ); ?>"><?php esc_html_e( 'Add payment method', 'woocommerce' ); ?></button>
					<input type="hidden" name="woocommerce_add_payment_method" id="woocommerce_add_payment_method" value="1" />
				</div>

			</div>
		</form>
	<?php else : ?>
		<p class="woocommerce-notice woocommerce-notice--info woocommerce-info"><?php esc_html_e( 'New payment methods can only be added during checkout. Please contact us if you require assistance.', 'woocommerce' ); ?></p>
	<?php endif; ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.reda-add-payment-form');
    if (!form) return;

    const radios = form.querySelectorAll('input.input-radio');
    const items = form.querySelectorAll('.reda-payment-method');

    const syncActiveState = () => {
        items.forEach(item => item.classList.remove('active-method'));
        radios.forEach(radio => {
            if (radio.checked && radio.closest('.reda-payment-method')) {
                radio.closest('.reda-payment-method').classList.add('active-method');
            }
        });
    };

    radios.forEach(radio => {
        radio.addEventListener('change', syncActiveState);
    });
    syncActiveState();

    const fixStripeColors = () => {
        const labels = form.querySelectorAll('.p-FieldLabel, .p-PaymentElement label, .p-Field label');
        labels.forEach(label => {
            label.style.color = '#2D3748';
            label.style.fontWeight = '600';
        });
        const inputs = form.querySelectorAll('.p-Input-input, .p-PaymentElement input, .p-Select-select');
        inputs.forEach(input => {
            input.style.color = '#1A202C';
        });
    };

    const paymentSection = document.querySelector('#payment');
    if (paymentSection) {
        const observer = new MutationObserver(fixStripeColors);
        observer.observe(paymentSection, { childList: true, subtree: true });
    }

    setTimeout(fixStripeColors, 500);
    setTimeout(fixStripeColors, 1000);
    setTimeout(fixStripeColors, 1500);
});

(function() {
    const updateCheckbox = () => {
        const checkbox = document.getElementById('wc-stripe-update-subs-payment-method-card');
        if (!checkbox) return;
        checkbox.classList.remove('form-control', 'form-control-lg');
        checkbox.style.width = 'auto';
        checkbox.closest('label').style.display = 'inline-flex';
        checkbox.closest('label').style.alignItems = 'center';
    };

    updateCheckbox();

    const observer = new MutationObserver(function() {
        updateCheckbox();
    });
    observer.observe(document.body, { childList: true, subtree: true });
})();
</script>
