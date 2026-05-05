<?php
/**
 * Redatudo - WooCommerce My Account Dashboard
 * Layout e UX Redatudo para WooCommerce Dashboard
 *
 * @version 2024.06
 * @author Redatudo Webdesign (GPT)
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Filtros de segurança para wp_kses
$allowed_html = [
	'a' => [ 'href' => [], 'target'=>[], 'rel'=>[] ],
	'strong'=>[], 'br'=>[]
];

// Removed old functions: redatudo_is_social_linked_registration, redatudo_is_local_registration_verified, redatudo_is_login_app
// Now handled by redatudo-auth.php plugin via hooks

// Removed redatudo_has_active_subscription() - now in redatudo-auth.php plugin
?>

<style>
    /* Estilo visual Redatudo MyAccount */
    .myaccount-hero {
        background: linear-gradient(100deg,#181733 65%,#212162 100%);
        border-radius: 22px;
        padding: 2.5em 2em 2em 2em;
        margin-bottom: 2.8em;
        box-shadow: 0 3px 38px #00bfff21, 0 1px 2px #7f00ff31;
        font-family: 'Orbitron', Arial, sans-serif;
        color: #b8e6ff;
    }
    .myaccount-hero h1 {
        font-size: 2.1rem; font-weight: 800; letter-spacing:1.3px;
        background: linear-gradient(90deg,#00ffd0,#7f00ff 80%);
        -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin-bottom: .5em;
    }
    .myaccount-info-box {
        background: #15142b;
        border-radius: 18px;
        box-shadow: 0 2px 20px #00ffd019;
        padding: 1.4em 1.2em 1.5em 1.2em;
        margin-bottom: 2.1em;
    }
    .myaccount-info-box h3 {
        color:#00ffd0; font-weight:700; letter-spacing:1.4px; margin-top:0;margin-bottom:0.6em;font-size:1.18em;
    }
    .myaccount-action-btn {
        background: linear-gradient(90deg,#00bfff,#7f00ff);
        color: #fff !important;
        font-family: 'Orbitron', Arial, sans-serif;
        font-weight: bold;
        border-radius: 22px;
        padding: 0.83em 1.9em;
        font-size: 1.15em;
        box-shadow: 0 2px 12px #00bfff61;
        transition: .19s;
        display:inline-block;
        margin-top:.6em;
    }
    .myaccount-action-btn:hover { background:linear-gradient(98deg,#00ffd0 40%,#7f00ff 100%); color:#181733 !important; }
    .badge-premium { background:linear-gradient(90deg,#00ffd0,#7f00ff);color:#222;font-size:.92em;border-radius:13px;padding:0.19em 0.9em; font-family:Orbitron;font-weight:bold;margin-left:.3em;}
    .affiliate-box { background: #181733; border-radius:14px; box-shadow:0 2px 12px #7f00ff19; padding:1em 1.1em 1.2em 1.1em; margin-bottom: 2.2em;}
    .affiliate-box strong { color:#00ffd0;}
    .affiliate-box a { color:#00ffd0;}
    .affiliate-btn { margin-top:0.7em; }
</style>

<div class="container-fluid myaccount-hero">

    <h1>🎉 Bem-vindo a Redatudo</h1>
    <p>
        <?php
        $current_user = wp_get_current_user();
        $name = $current_user->first_name ?: $current_user->display_name;
        printf(
            wp_kses( 'Olá %1$s <span style="font-size:.9em;opacity:.75;">(não é você? <a href="%2$s" rel="nofollow">Sair</a>)</span>', $allowed_html),
            '<strong>' . esc_html($name) . '</strong>',
            esc_url( wc_logout_url() )
        );
        ?>
    </p>

    <p style="color:#b8e6ff;">
        Olá, você está no dashboard da sua conta Redatudo!
        <br>Gerencie assinaturas, créditos, sua conta, <strong>acesso instantâneo ao Hub</strong> e até seu link de afiliado Recorrente.
    </p>
</div>

<!-- Banner Destaque: Todas as 13 Ferramentas -->
<div style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(124, 58, 237, 0.15) 100%); border: 2px solid rgba(16, 185, 129, 0.4); border-radius: 16px; padding: 1.5rem; margin-bottom: 2.5rem; text-align: center;">
    <div style="font-size: 1.5rem; font-weight: 700; color: #10B981; margin-bottom: 0.5rem; font-family: 'Orbitron', Arial, sans-serif;">🚀 13 Ferramentas de IA Especializadas</div>
    <div style="color: #E5E7EB; margin-bottom: 1rem; font-size: 1.05rem; font-family: 'Inter', sans-serif;">Do TCC ao Instagram. Do e-commerce ao ebook. Crie conteúdo profissional em segundos.</div>
    <a href="<?php echo home_url(); ?>/#ferramentas" style="display: inline-block; background: linear-gradient(135deg, #10B981, #059669); color: #FFFFFF; padding: 0.75rem 2rem; border-radius: 12px; text-decoration: none; font-weight: 700; font-size: 1.1rem; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3); transition: all 0.3s; font-family: 'Inter', sans-serif;">Ver Todas as Ferramentas →</a>
</div>

<div class="row">

    <!-- Minha conta - lado esquerdo -->
    <div class="col-12">

        <div class="myaccount-info-box">
            <h3>Conta & Navegação</h3>
            <p>
                <?php
                $desc = 'No painel, você pode ver <a href="%1$s">suas compras</a>, gerenciar <a href="%2$s">endereços</a>, alterar <a href="%3$s">dados ou senha</a>.';
                if (wc_shipping_enabled()) $desc = 'No painel, veja <a href="%1$s">pedidos</a>, gerencie <a href="%2$s">endereços</a> e altere <a href="%3$s">dados/senha</a>.';
                printf(
                    wp_kses($desc, $allowed_html),
                    esc_url( wc_get_endpoint_url( 'orders' ) ),
                    esc_url( wc_get_endpoint_url( 'edit-address' ) ),
                    esc_url( wc_get_endpoint_url( 'edit-account' ) )
                );
                ?>
            </p>

            <p>
                <span class="d-block mb-2" style="font-weight:600;">🚀 Seu Hub está online:</span>
                <button type="button" class="myaccount-action-btn" id="acessar-ia-btn">Abrir Hub</button>
            </p>
        </div>

        <!-- Assinatura ativa -->
        <?php if (redatudo_has_active_subscription()): ?>
            <?php
            $user = wp_get_current_user();
            $users_subscriptions = function_exists('wcs_get_users_subscriptions') ? wcs_get_users_subscriptions($user->ID) : [];
            $subscription_id = null;
            foreach ($users_subscriptions as $sub) {
                if ($sub->status === 'active') $subscription_id = $sub->id;
            }
            ?>
            <div class="myaccount-info-box">
                <h3>Assinatura Premium<span class="badge-premium">premium</span></h3>
                <p><?php echo do_shortcode('[account-info]'); ?></p>
                <p><strong>Total usado:</strong> <?php echo do_shortcode('[account-consumo]'); ?> /
                    <strong>Limite:</strong> <?php echo do_shortcode('[account-limite]'); ?></p>
                <div>
                    <a href="https://redatudo.online/minha-conta/view-subscription/<?php echo $subscription_id; ?>/"
                       class="myaccount-action-btn">Gerenciar Assinatura</a>
                    <a href="https://redatudo.online/recargas" class="myaccount-action-btn">Recarregar Créditos</a>
                </div>
            </div>
        <?php endif; ?>

    </div>

    <!-- Afiliados e programas à direita -->
    <div class="col-12 col-lg-6">

        <?php
        // Verifica ID programa de afiliado direto My Account
        global $wpdb;
        $table = $wpdb->prefix . 'wpam_affiliates';
        $query = $wpdb->prepare( "SELECT affiliateId FROM {$table} WHERE email = %s", $user->user_email );
        $results = $wpdb->get_results( $query );
        $affiliate = $results[0] ?? null;
        if ( $affiliate && isset( $affiliate->affiliateId ) ) {
            $oneUrl = 'https://redatudo.online?wpam_id=' . intval( $affiliate->affiliateId );
            $twoUrl = 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode( $oneUrl );
        }
        ?>
        <div class="affiliate-box">
            <h3>💰 Programa de Afiliados</h3>
            <p>
                <strong>Ganhe 15% de comissão recorrente</strong> em toda venda ou assinatura vinda do seu link.<br>
                Indique amigos e clientes, acompanhe ganhos e tenha renda passiva real no mundo AI.
            </p>
            <?php if ($affiliate && isset($affiliate->affiliateId)): ?>
                <p><a href="https://redatudo.online/painel-de-afiliado/">Acesse seu painel de afiliado</a></p>
                <p>
                    Use seu link: <a href="<?php echo esc_url($oneUrl); ?>"><?php echo esc_html($oneUrl); ?></a>
                    <span class="badge-premium">premium</span>
                </p>
                <a href="<?php echo esc_url($twoUrl); ?>" target="_blank" rel="noopener" class="myaccount-action-btn affiliate-btn">
                    Compartilhar meu link 🚀
                </a>
            <?php else: ?>
                <p><a href="https://redatudo.online/programa-de-afiliados" class="myaccount-action-btn">Ativar programa de afiliados</a></p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
document.getElementById('acessar-ia-btn').onclick = function() {
    window.location = "<?php echo esc_url(redatudo_get_app_url('hub')); ?>";
};
</script>

<?php
/**
 * WooCommerce ações padrão
 */
do_action( 'woocommerce_account_dashboard' );
do_action( 'woocommerce_before_my_account' );
do_action( 'woocommerce_after_my_account' );
