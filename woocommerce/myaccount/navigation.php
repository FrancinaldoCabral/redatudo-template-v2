<?php
/**
 * My Account Navigation (Redatudo Style)
 * Personalizado para dar visual tech/futurista, inspirado no layout principal Redatudo
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Atalhos/menu
$items = wc_get_account_menu_items();
global $wp;
$current_endpoint = '';
foreach ($items as $endpoint => $label) {
    if ( isset( $wp->query_vars[ $endpoint ] ) ) {
        $current_endpoint = $endpoint;
        break;
    }
}
if (!$current_endpoint) $current_endpoint = 'dashboard';

// Ícones símbolos para cada endpoint
$icons = [
    'dashboard'        => '🤖',
    'orders'           => '📦',
    'downloads'        => '⬇️',
    'edit-address'     => '🏠',
    'payment-methods'  => '💳',
    'edit-account'     => '🧑‍💻',
    'customer-logout'  => '🚪',
    'subscriptions'    => '🔄',
    'affiliates'       => '💸',
    'recargas'         => '⚡',
];

// Classes extras de destaque para item ativo
function is_active_account_item( $endpoint, $current ) {
    return $endpoint === $current ? 'active-account-item' : '';
}
?>

<style>
.redatudo-myaccount-nav-wrap {
    background: linear-gradient(90deg, #181733 70%, #212148 100%);
    border-radius: 20px;
    box-shadow: 0 2px 26px #00bfff19, 0 1px 2px #7f00ff21;
    padding: 1.7em 1.2em 1.4em 1.2em;
    margin: 0 0 2.6em 0;
}

.redatudo-account-nav-list {
    display: flex;
    flex-wrap: wrap;
    gap: 0.6em 1.05em;
    justify-content: flex-start;
    list-style: none;
    margin: 0; padding: 0;
}
.redatudo-account-nav-link {
    display: flex;
    align-items: center;
    gap: 0.63em;
    font-family: 'Orbitron', Arial, sans-serif;
    font-size: 1.08em;
    font-weight: 600;
    color: #fff;
    background: rgba(16,19,38,0.90);
    border-radius: 14px;
    box-shadow: 0 2px 12px #00bfff14;
    padding: .63em 1.3em .59em 1.1em;
    border: 2.5px solid transparent;
    text-decoration: none !important;
    transition: all .19s;
    min-width: 120px;
    letter-spacing: 0.5px;
    position: relative;
    z-index: 2;
}
.redatudo-account-nav-link:hover, .redatudo-account-nav-link:focus {
    color: #00ffd0;
    border-color: #00bfff;
    background: linear-gradient(90deg, #212148 70%, #3030a0 100%);
    box-shadow: 0 4px 24px #00ffd069;
    text-decoration: none !important;
}
.active-account-item .redatudo-account-nav-link {
    border-color: #00ffd0;
    background: linear-gradient(90deg, #00bfff 85%, #7f00ff 100%);
    color: #101022 !important;
    font-weight: bold;
    box-shadow: 0 6px 40px #00ffd044;
}
.redatudo-nav-icon {
    font-size: 1.4em;
    background: linear-gradient(90deg,#00bfff,#7f00ff 80%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    filter: drop-shadow(0 0 8px #7f00ff70);
    transition: .19s;
    margin-right: .15em;
}
@media (max-width:700px){
    .redatudo-myaccount-nav-wrap {padding: 1em 0.2em 0.2em 0.2em;}
    .redatudo-account-nav-list {gap:0.32em 0.4em;}
    .redatudo-account-nav-link {font-size:.99em;min-width:90px;padding:.5em .6em;}
}
</style>

<div class="redatudo-myaccount-nav-wrap">
    <nav aria-label="Menu área da conta">
        <ul class="redatudo-account-nav-list" role="menu">
            <?php foreach ( $items as $endpoint => $label ) : ?>
                <?php
                    $is_active = is_active_account_item($endpoint, $current_endpoint);
                    $icon = isset($icons[$endpoint]) ? '<span class="redatudo-nav-icon">'.$icons[$endpoint].'</span>' : '';
                ?>
                <li class="<?php echo esc_attr($is_active); ?>" role="none">
                    <a
                        href="<?php echo esc_url( wc_get_account_endpoint_url($endpoint) ); ?>"
                        class="redatudo-account-nav-link <?php echo $is_active ? 'selected' : ''; ?>"
                        <?php if ($is_active) echo 'aria-current="page"'; ?>
                        role="menuitem"
                        tabindex="0"
                    >
                        <?php echo $icon; ?>
                        <?php echo esc_html($label); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
</div>