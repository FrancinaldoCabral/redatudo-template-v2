<?php
/**
 * My Account page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;
?>

<style>
/* Minha Conta - Visual Moderno */
.woocommerce-account {
    background: #0F0F1A;
}

/* Menu de navegação discreto */
.redatudo-myaccount-nav-wrap {
    background: #1F2937;
    border-radius: 10px;
    padding: 1rem;
    margin-bottom: 1rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    width: 100%;
}

.woocommerce-MyAccount-content,
.woocommerce-MyAccount-content .container,
.woocommerce-MyAccount-content .container-fluid,
.woocommerce-MyAccount-content .row,
.redatudo-myaccount-nav-wrap {
    max-width: 100% !important;
}

.redatudo-account-nav-link {
    background: transparent;
    border: 1px solid #374151;
    font-size: 1rem;
    padding: 0.5rem 1rem;
    min-width: auto;
}

.woocommerce-account .container,
.woocommerce-account .container-fluid,
.woocommerce-account .row,
.woocommerce-account .container-lg,
.woocommerce-account .container-xl,
.woocommerce-account .container-xxl {
    width: 100% !important;
    max-width: none !important;
    margin: 0 !important;
    padding-left: 0 !important;
    padding-right: 0 !important;
}

.woocommerce-account .row {
    --bs-gutter-x: 0 !important;
}

.woocommerce-MyAccount-navigation {
    background: #1F2937;
}

.woocommerce-MyAccount-navigation ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.woocommerce-MyAccount-navigation li {
    margin-bottom: 0.5rem;
}

.woocommerce-MyAccount-navigation a {
    display: block;
    padding: 0.75rem 1.25rem;
    color: #D1D5DB;
    text-decoration: none;
    border-radius: 10px;
    font-family: 'Inter', sans-serif;
    font-weight: 500;
    transition: all 0.3s;
    border: 2px solid transparent;
}

.woocommerce-MyAccount-navigation a:hover {
    background: rgba(124, 58, 237, 0.1);
    color: #7C3AED;
    border-color: #7C3AED;
}

.woocommerce-MyAccount-navigation li.is-active a {
    background: linear-gradient(135deg, #7C3AED 0%, #3B82F6 100%);
    color: #FFFFFF;
    font-weight: 600;
}

.woocommerce-MyAccount-content {
    background: #1F2937;
    border: 2px solid #374151;
    border-radius: 20px;
    width: 100%;
    max-width: none;
}

.woocommerce-MyAccount-content .container,
.woocommerce-MyAccount-content .container-fluid,
.woocommerce-MyAccount-content .row {
    width: 100%;
    max-width: none;
    margin: 0;
    padding: 0;
}

.woocommerce-MyAccount-content h2,
.woocommerce-MyAccount-content h3 {
    font-family: 'Outfit', sans-serif;
    color: #FFFFFF;
    margin-bottom: 1.5rem;
}

.woocommerce table {
    background: transparent;
    color: #D1D5DB;
}

.woocommerce table th {
    background: rgba(124, 58, 237, 0.1);
    color: #FFFFFF;
    font-family: 'Inter', sans-serif;
    font-weight: 600;
    padding: 1rem;
}

.woocommerce table td {
    padding: 1rem;
    border-bottom: 1px solid #374151;
}

.woocommerce-button,
.woocommerce input[type="submit"],
.button {
    background: linear-gradient(135deg, #7C3AED 0%, #3B82F6 100%) !important;
    color: #FFFFFF !important;
    border: none !important;
    padding: 0.75rem 1.5rem !important;
    border-radius: 10px !important;
    font-family: 'Inter', sans-serif !important;
    font-weight: 600 !important;
    transition: all 0.3s !important;
}

.woocommerce-button:hover,
.woocommerce input[type="submit"]:hover,
.button:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(124, 58, 237, 0.4);
}

.woocommerce-form-row input {
    background: #161622;
    border: 2px solid #374151;
    color: #FFFFFF;
    padding: 0.75rem 1rem;
    border-radius: 10px;
    font-family: 'Inter', sans-serif;
}

.woocommerce-form-row input:focus {
    border-color: #7C3AED;
    outline: none;
}


</style>

<div class="woocommerce-account">
    <div class="container-fluid pt-4 mt-4">
        <div class="d-block">
            <div class="mb-3">
                <?php do_action( 'woocommerce_account_navigation' ); ?>
            </div>
            <div>
                <div class="woocommerce-MyAccount-content w-100">
                    <?php
                    if ( get_query_var('logout') == '1' ) {
                        echo '<script>window.localStorage.removeItem("user")</script>';
                    }
                    do_action( 'woocommerce_account_content' );
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
