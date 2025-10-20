<?php
/**
 * Redatudo Checkout: Form de Detalhes de Cobrança (BONITÃO)
 * Coloque em: yourtheme/woocommerce/checkout/form-billing.php
 */
defined('ABSPATH') || exit;
?>

<style>
/* Orbitron, cores, espaçamento Redatudo */
.redatudo-billing-section {
    font-family: 'Orbitron', Arial, sans-serif !important;
}
.redatudo-billing-heading {
    font-family: 'Orbitron', Arial, sans-serif;
    font-size: 1.41rem;
    color: #00ffd0;
    margin: 1.2em 0 1.3em 0;
    letter-spacing: 1.1px;
    text-transform: uppercase;
    font-weight: 700;
}
.redatudo-billing-fields > div {
    margin-bottom: 1.16em !important;
}
.woocommerce form .form-row label,
.woocommerce form .form-group label {
    font-family: 'Orbitron', Arial, sans-serif;
    color: #00ffd0;
    letter-spacing: .8px;
    font-weight: 600;
    margin-bottom: .25em;
    font-size: 1em;
}
.woocommerce input[type="text"],
.woocommerce input[type="email"],
.woocommerce input[type="tel"],
.woocommerce input[type="password"],
.woocommerce select {
    border-radius: 13px !important;
    border: 1.5px solid #28286e !important;
    background: #171727 !important;
    color: #00ffd0 !important;
    box-shadow: 0 1px 11px #00bfff23;
    padding: .75em 1.08em;
    font-size: 1.04em;
    font-family: 'Orbitron', Arial, sans-serif;
    transition: border-color .15s, box-shadow .18s;
}
.woocommerce input[type="text"]:focus,
.woocommerce input[type="email"]:focus,
.woocommerce input[type="tel"]:focus,
.woocommerce input[type="password"]:focus,
.woocommerce select:focus {
    border-color: #00ffd0 !important;
    background: #101022 !important;
    color: #00ffd0 !important;
    box-shadow: 0 2px 13px #00ffd043;
}
.woocommerce .form-row {
    margin-bottom: 1em !important;
}
.woocommerce ::placeholder { color: #b8e6ff; opacity: 1;}
/* Tira margem duplicada de cadastrar conta */
.woocommerce-form__label-for-checkbox {
    margin-top: 1.1em;
}
</style>
<style>
/* Garante inputs de billing ocupando 100%, removendo float-column padrões do WC */
.woocommerce-billing-fields .form-row,
.redatudo-billing-fields .form-row,
.woocommerce-billing-fields .form-row-first,
.woocommerce-billing-fields .form-row-last,
.redatudo-billing-fields .form-row-first,
.redatudo-billing-fields .form-row-last {
    width: 100%!important;
    float: none!important;
    clear: both!important;
    margin-right: 0!important;
    display: block!important;
    box-sizing: border-box;
}
</style>
<div class="redatudo-billing-section">
    <h3 class="redatudo-billing-heading">
        <?php echo (wc_ship_to_billing_address_only() && WC()->cart->needs_shipping())
          ? esc_html__('Dados de cobrança e entrega', 'woocommerce')
          : esc_html__('Dados de cobrança', 'woocommerce');
        ?>
    </h3>

    <?php do_action('woocommerce_before_checkout_billing_form', $checkout); ?>

    <div class="redatudo-billing-fields">
      <?php
        $fields = $checkout->get_checkout_fields('billing');
        unset($fields['billing_company'], $fields['billing_address_1'], $fields['billing_address_2'], $fields['billing_city'], $fields['billing_state'], $fields['billing_postcode'], $fields['billing_country']);
        foreach ($fields as $key => $field) {
            echo '<div>';
            woocommerce_form_field($key, $field, $checkout->get_value($key));
            echo '</div>';
        }
      ?>

      <?php if ( ! is_user_logged_in() && $checkout->is_registration_enabled() ) : ?>
        <?php if ( ! $checkout->is_registration_required() ) : ?>
          <div>
            <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
              <input class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox"
                id="createaccount"
                <?php checked( ( true === $checkout->get_value( 'createaccount' ) || ( true === apply_filters( 'woocommerce_create_account_default_checked', false ) ) ), true ); ?>
                type="checkbox" name="createaccount" value="1" />
              <span><?php esc_html_e('Criar uma conta?', 'woocommerce'); ?></span>
            </label>
          </div>
        <?php endif; ?>

        <?php do_action('woocommerce_before_checkout_registration_form', $checkout); ?>

        <?php if ($checkout->get_checkout_fields('account')) : ?>
          <?php foreach ($checkout->get_checkout_fields('account') as $key => $field) : ?>
            <div>
              <?php woocommerce_form_field($key, $field, $checkout->get_value($key)); ?>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>

        <?php do_action('woocommerce_after_checkout_registration_form', $checkout); ?>
      <?php endif; ?>

      <?php do_action('woocommerce_after_checkout_billing_form', $checkout); ?>
    </div>
</div>