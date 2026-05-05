<?php
/**
 * REDATUDO - App Links Configuration Helper
 * 
 * Este arquivo centraliza e gerencia todos os links para os aplicativos.
 * Use em seu tema ou plugin para facilitar manutenção.
 * 
 * IMPLEMENTAÇÃO:
 * 
 * 1. Para criar um link com autenticação automática usando a função helper:
 * 
 *    // Para chat (padrão)
 *    $url = redatudo_get_app_url('hub');
 *    
 *    // Para ebook
 *    $url = redatudo_get_app_url('ebook');
 *    
 *    // Para hub (outros apps)
 *    $url = redatudo_get_app_url('hub');
 *    echo '<a href="' . esc_url($url) . '">Acessar</a>';
 * 
 * 2. Shortcode helper (adicione ao seu template/plugin):
 * 
 *    [app_link app="chat"]Entrar no Chat[/app_link]
 *    [app_link app="ebook"]Gerar Ebook[/app_link]
 * 
 * 3. Se precisar um app custom não mapeado, use o filtro:
 * 
 *    add_filter('redatudo_app_urls', function($apps) {
 *        $apps['custom_app'] = 'https://custom.redatudo.online';
 *        return $apps;
 *    });
 * 
 * ARQUIVOS ATUALIZADOS:
 * - header.php (dropdown de apps)
 * - footer.php (links no footer)
 * - woocommerce/checkout/thankyou.php (lista de ferramentas)
 * - woocommerce/single-product.php (links de volta ao hub)
 * - home.php (CTA para começar)
 * - single.php (sidebar)
 * - taxonomy.php (sidebar)
 * 
 */

// Adicione shortcode para app links
if (!function_exists('redatudo_app_link_shortcode')) {
    function redatudo_app_link_shortcode($atts, $content = '') {
        $atts = shortcode_atts([
            'app' => 'chat',
            'class' => '',
            'target' => '_blank',
        ], $atts);

        $url = redatudo_get_app_url($atts['app']);
        $class = !empty($atts['class']) ? ' class="' . esc_attr($atts['class']) . '"' : '';
        $target = in_array($atts['target'], ['_blank', '_self', '_parent', '_top']) ? $atts['target'] : '_blank';

        return '<a href="' . esc_url($url) . '" target="' . esc_attr($target) . '"' . $class . '>' . esc_html($content) . '</a>';
    }
    add_shortcode('app_link', 'redatudo_app_link_shortcode');
}

// Adicione função helper para renderizar um grid de apps
if (!function_exists('redatudo_render_apps_grid')) {
    function redatudo_render_apps_grid($apps = [], $columns = 2, $class = '') {
        $default_apps = [
            [
                'id' => 'ebook',
                'name' => 'Gerador de Ebook',
                'icon' => '📚',
                'description' => 'Crie ebooks profissionais com IA'
            ],
            [
                'id' => 'chat',
                'name' => 'Hub',
                'icon' => '💬',
                'description' => 'Chat inteligente para suas dúvidas'
            ],
            [
                'id' => 'hub',
                'name' => 'Hub de Ferramentas',
                'icon' => '🚀',
                'description' => 'Acesse todas as 13 ferramentas'
            ],
        ];

        $apps = !empty($apps) ? $apps : $default_apps;
        $grid_class = 'redatudo-apps-grid redatudo-apps-grid--col-' . intval($columns);
        if (!empty($class)) {
            $grid_class .= ' ' . esc_attr($class);
        }

        $html = '<div class="' . $grid_class . '">';
        foreach ($apps as $app) {
            $url = redatudo_get_app_url($app['id']);
            $html .= '
            <div class="app-card">
                <a href="' . esc_url($url) . '" target="_blank" class="app-card-link">
                    <div class="app-icon">' . $app['icon'] . '</div>
                    <h3 class="app-name">' . esc_html($app['name']) . '</h3>
                    <p class="app-desc">' . esc_html($app['description']) . '</p>
                    <span class="app-arrow">→</span>
                </a>
            </div>';
        }
        $html .= '</div>';

        return $html;
    }
}
