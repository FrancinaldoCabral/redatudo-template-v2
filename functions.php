<?php
// Include the custom auth plugin
include_once get_template_directory() . '/redatudo-auth.php';
// Bot protection (rate limiting, honeypot, disposable email blocking)
include_once get_template_directory() . '/redatudo-bot-protection.php';

// Generate JWT token function (fallback if plugin not loaded)
if (!function_exists('redatudo_generate_token')) {
    function redatudo_generate_token() {
        if (!class_exists('Firebase\JWT\JWT')) {
            return '';
        }
        $user = wp_get_current_user();
        if (!$user->ID) {
            return '';
        }
        $secret_key = defined('JWT_AUTH_SECRET_KEY') ? JWT_AUTH_SECRET_KEY : 'your-secret-key';
        $algorithm = 'HS256';
        $issued_at = time();
        $not_before = $issued_at;
        $expire = $issued_at + (DAY_IN_SECONDS * 7);
        $token = [
            'iss' => get_bloginfo('url'),
            'iat' => $issued_at,
            'nbf' => $not_before,
            'exp' => $expire,
            'data' => [
                'user' => [
                    'id' => $user->ID,
                ],
            ],
        ];
        return \Firebase\JWT\JWT::encode($token, $secret_key, $algorithm);
    }
}

/**
 * Get app URL with authentication handling
 * Centralizes all app links in the system
 * 
 * @param string $app_id App identifier (chat, ebook, titles, etc)
 * @return string URL to the app with token if logged in, or login redirect if not
 */
if (!function_exists('redatudo_get_app_url')) {
    function redatudo_get_app_url($app_id = 'chat') {
        // App URL configuration
        $app_urls = [
            'ebook' => 'https://ebook.redatudo.online',
            'chat' => 'https://chat.redatudo.online',
            'hub' => 'https://hub.redatudo.online',
            // Default fallback for any app not specifically mapped
            'default' => 'https://hub.redatudo.online',
        ];

        // Allow filtering the app URLs configuration
        $app_urls = apply_filters('redatudo_app_urls', $app_urls);

        // Get the appropriate URL for this app
        $base_url = isset($app_urls[$app_id]) ? $app_urls[$app_id] : $app_urls['default'];

        // If user is logged in, add token
        if (is_user_logged_in()) {
            $token = redatudo_generate_token();
            return $base_url . '?token=' . esc_attr($token);
        }

        // If not logged in, redirect to login page with app parameter
        $login_page_url = get_permalink(get_option('woocommerce_myaccount_page_id'));
        return add_query_arg('login_app', $app_id, $login_page_url);
    }
}
/**
 * Renderiza uma lista de indicações Amazon no estilo "anúncio de texto".
 *
 * ── COMO ADICIONAR SEUS LINKS ─────────────────────────────────────────────────
 *  1. Acesse https://associados.amazon.com.br → "Ferramentas de link"
 *  2. Encontre o produto e copie o "Link Curto" (ex.: https://amzn.to/XXXXX)
 *     ou a URL do produto + ?tag=SUA-TAG-20 no final
 *  3. Cole no campo 'url' do item correspondente no $catalog abaixo
 *  4. Se quiser adicionar mais produtos, duplique um bloco e escolha uma
 *     chave nova (ex.: 'seo-tecnico')
 *
 * ── ONDE APARECEM OS ANÚNCIOS ────────────────────────────────────────────────
 *  Cada placement define qual grupo de produtos exibir:
 *    hero / banner-top → grupo 'ia'    (artigos de IA)
 *    inline / sidebar  → grupo 'copy'  (copywriting + marketing)
 *    sidebar-2 / final → grupo 'prod'  (produtividade + ferramentas)
 *  Para forçar um grupo: redatudo_amazon_ad('inline', ['group' => 'ia'])
 *  Para forçar produto único: redatudo_amazon_ad('inline', ['product' => 'copywriting'])
 *
 * @param string $placement  Slot: banner-top | inline | sidebar | sidebar-2 | final | hero
 * @param array  $args       ['group' => string] ou ['product' => string]
 */
if ( ! function_exists( 'redatudo_amazon_ad' ) ) {
    function redatudo_amazon_ad( $placement = 'default', $args = [] ) {

        // ═══════════════════════════════════════════════════════════════════
        // CATÁLOGO — edite os 'url' com seus links de afiliado da Amazon
        // ═══════════════════════════════════════════════════════════════════
        $catalog = apply_filters( 'redatudo_amazon_catalog', [

            // ── Grupo: IA & Tecnologia ─────────────────────────────────────
            // Fonte: Mais Vendidos Amazon BR — Computação, mai/2026
            'cointeligencia' => [
                'url'   => 'https://amzn.to/4dkIqCJ', // ← COLE SEU LINK (+?tag=)
                'title' => 'Cointeligência — A vida e o trabalho com IA',
                'desc'  => 'O guia definitivo para trabalhar COM a IA — não ser substituído por ela. Best-seller em Computação, ★4.7.',
                'cat'   => 'IA & Trabalho',
                'group' => 'ia',
            ],
            'proxima-onda' => [
                'url'   => 'https://amzn.to/4urU704', // ← COLE SEU LINK (+?tag=)
                'title' => 'A Próxima Onda — IA, poder e o maior dilema do século',
                'desc'  => 'Escrito pelo cofundador do DeepMind: como a IA vai transformar tudo. 1.100 avaliações ★4.6.',
                'cat'   => 'IA & Futuro',
                'group' => 'ia',
            ],
            'nexus' => [
                'url'   => 'https://amzn.to/4usxh8y', // ← COLE SEU LINK (+?tag=)
                'title' => 'Nexus — Yuval Noah Harari',
                'desc'  => 'Do autor de Sapiens: como as redes de informação moldaram a história — e o que a IA muda nisso. 3.800 avaliações ★4.7.',
                'cat'   => 'IA & Sociedade',
                'group' => 'ia',
            ],
            'maquina-pensa' => [
                'url'   => 'https://amzn.to/4d2CgFZ', // ← COLE SEU LINK (+?tag=)
                'title' => 'A Máquina que Pensa — Jensen Huang e a Nvidia',
                'desc'  => 'A história real do chip mais cobiçado do mundo e da corrida pela IA. Best-seller em alta ★4.8.',
                'cat'   => 'IA & Tecnologia',
                'group' => 'ia',
            ],
            'singularidade' => [
                'url'   => 'https://amzn.to/4weTQQ0', // ← COLE SEU LINK (+?tag=) — Kindle
                'title' => 'A Singularidade está mais Próxima — Ray Kurzweil',
                'desc'  => 'A previsão mais ousada sobre a fusão entre humanos e IA para a próxima década. ★4.7.',
                'cat'   => 'IA & Futuro',
                'group' => 'ia',
            ],

            // ── Grupo: Copywriting & Marketing ────────────────────────────
            // Fonte: Mais Vendidos Amazon BR — Computação + Marketing e Vendas, mai/2026
            'gatilhos-mentais' => [
                'url'   => 'https://amzn.to/4cPPd7l', // ← COLE SEU LINK (+?tag=)
                'title' => 'Gatilhos Mentais — Gustavo Ferreira',
                'desc'  => 'Estratégias de persuasão aplicadas a negócios e comunicação. 18.000+ avaliações ★4.6.',
                'cat'   => 'Copywriting',
                'group' => 'copy',
            ],
            'brevidade-inteligente' => [
                'url'   => 'https://www.amazon.com.br/dp/6555646659', // ← COLE SEU LINK (+?tag=)
                'title' => 'Brevidade Inteligente — Dizer muito com poucas palavras',
                'desc'  => 'O método dos fundadores do Axios para escrever textos que as pessoas realmente leem. ★4.6.',
                'cat'   => 'Escrita & Conteúdo',
                'group' => 'copy',
            ],
            'marketing60' => [
                'url'   => 'https://amzn.to/4d4g2U9', // ← COLE SEU LINK (+?tag=)
                'title' => 'Marketing 6.0 — O futuro é imersivo',
                'desc'  => 'Kotler sobre metaverso, Web3 e IA no marketing. Como eliminar fronteiras entre físico e digital. 580 avaliações ★4.8.',
                'cat'   => 'Marketing Digital',
                'group' => 'copy',
            ],
            'marketing50' => [
                'url'   => 'https://amzn.to/3QO3ZmA', // ← COLE SEU LINK (+?tag=)
                'title' => 'Marketing 5.0 — Tecnologia para a humanidade',
                'desc'  => 'Como usar IA, dados e automação para criar experiências de marketing irresistíveis. 2.700 avaliações ★4.8.',
                'cat'   => 'Marketing Digital',
                'group' => 'copy',
            ],
            'logica-consumo' => [
                'url'   => 'https://amzn.to/4d62UxW', // ← COLE SEU LINK (+?tag=)
                'title' => 'A Lógica do Consumo — Martin Lindstrom',
                'desc'  => 'Por que compramos o que compramos? Neurociência e neuromarketing aplicados ao conteúdo. 2.400 avaliações ★4.6.',
                'cat'   => 'Neuromarketing',
                'group' => 'copy',
            ],

            // ── Grupo: Produtividade & Mentalidade ────────────────────────
            // Fonte: Mais Vendidos Amazon BR — Administração e Negócios, mai/2026
            'habitos-atomicos' => [
                'url'   => 'https://amzn.to/4u1HvNt', // ← COLE SEU LINK (+?tag=)
                'title' => 'Hábitos Atômicos — James Clear',
                'desc'  => 'O método mais vendido do mundo para criar bons hábitos de uma vez por todas. 27.000 avaliações ★4.8.',
                'cat'   => 'Produtividade',
                'group' => 'prod',
            ],
            'essencialismo' => [
                'url'   => 'https://amzn.to/4eZn52S', // ← COLE SEU LINK (+?tag=)
                'title' => 'Essencialismo — A disciplinada busca por menos',
                'desc'  => 'Faça menos, mas muito melhor. O sistema definitivo para focar no que importa. 34.000 avaliações ★4.8.',
                'cat'   => 'Foco & Método',
                'group' => 'prod',
            ],
            'poder-habito' => [
                'url'   => 'https://amzn.to/42MAiES', // ← COLE SEU LINK (+?tag=)
                'title' => 'O Poder do Hábito — Charles Duhigg',
                'desc'  => 'Por que fazemos o que fazemos — e como mudar. Um clássico com 24.000 avaliações ★4.8.',
                'cat'   => 'Hábitos & Comportamento',
                'group' => 'prod',
            ],
            'mindset' => [
                'url'   => 'https://amzn.to/4cPQ0Fl', // ← COLE SEU LINK (+?tag=)
                'title' => 'Mindset — A nova psicologia do sucesso',
                'desc'  => 'Carol Dweck explica por que a mentalidade de crescimento é o diferencial que separa quem avança dos que estacionam. 37.000 avaliações ★4.7.',
                'cat'   => 'Mentalidade & Crescimento',
                'group' => 'prod',
            ],
            'nada-pode-ferir' => [
                'url'   => 'https://amzn.to/3QNZAQs', // ← COLE SEU LINK (+?tag=)
                'title' => 'Nada Pode Me Ferir — David Goggins',
                'desc'  => 'A história brutal e inspiradora de como superar limites que você pensava que não existiam. 11.700 avaliações ★4.8.',
                'cat'   => 'Alta Performance',
                'group' => 'prod',
            ],
            'ego-inimigo' => [
                'url'   => 'https://amzn.to/4d0aYQx', // ← COLE SEU LINK (+?tag=)
                'title' => 'O Ego é Seu Inimigo — Ryan Holiday',
                'desc'  => 'Como o ego sabota quem está começando, quem está crescendo e quem chegou lá. 8.900 avaliações ★4.7.',
                'cat'   => 'Mentalidade & Estoicismo',
                'group' => 'prod',
            ],

            // ── Grupo: TCC & Trabalhos Acadêmicos ─────────────────────────
            // Fonte: Mais Vendidos Amazon BR — Computação, mai/2026
            'entendendo-algoritmos' => [
                'url'   => 'https://amzn.to/4tdNxJw', // ← COLE SEU LINK (+?tag=)
                'title' => 'Entendendo Algoritmos — Guia Ilustrado',
                'desc'  => '#1 em Computação. O livro de algoritmos mais amado do Brasil. Indispensável para TCC de TI. 6.000 avaliações ★4.8.',
                'cat'   => 'Algoritmos & TCC',
                'group' => 'tcc',
            ],
            'maos-obra-ml' => [
                'url'   => 'https://amzn.to/4w9JKQ9', // ← COLE SEU LINK (+?tag=)
                'title' => 'Mãos à Obra: Machine Learning com Scikit-Learn & TensorFlow',
                'desc'  => 'O manual prático de ML em português. Do zero ao projeto de TCC com dados reais.',
                'cat'   => 'Machine Learning',
                'group' => 'tcc',
            ],
            'codigo-limpo' => [
                'url'   => 'https://amzn.to/4w5ECwJ', // ← COLE SEU LINK (+?tag=)
                'title' => 'Código Limpo — Robert C. Martin (Uncle Bob)',
                'desc'  => 'A bíblia da programação profissional. 7.800 avaliações ★4.9. Citado em todo TCC de eng. de software.',
                'cat'   => 'Engenharia de Software',
                'group' => 'tcc',
            ],
            'intro-sql' => [
                'url'   => 'https://amzn.to/4n8JQU9', // ← COLE SEU LINK (+?tag=)
                'title' => 'Introdução à Linguagem SQL — Thomas Nield',
                'desc'  => 'A abordagem mais acessível para iniciantes que precisam de banco de dados no TCC. 1.900 avaliações ★4.8.',
                'cat'   => 'Banco de Dados & SQL',
                'group' => 'tcc',
            ],
            'pense-python' => [
                'url'   => 'https://amzn.to/4ncniCb', // ← COLE SEU LINK (+?tag=)
                'title' => 'Pense em Python — Allen Downey',
                'desc'  => 'Do iniciante ao desenvolvedor: o guia mais didático de Python em português para projetos e TCC.',
                'cat'   => 'Programação & Python',
                'group' => 'tcc',
            ],

            // ── Grupo: Finanças Pessoais ───────────────────────────────────
            // Fonte: Mais Vendidos Amazon BR — Finanças Pessoais + Negócios, mai/2026
            'psicologia-financeira' => [
                'url'   => 'https://amzn.to/4d6yD1K', // ← COLE SEU LINK (+?tag=)
                'title' => 'A Psicologia Financeira — Morgan Housel',
                'desc'  => 'Lições atemporais sobre fortuna, ganância e felicidade. #1 em Finanças, 27.000 avaliações ★4.8.',
                'cat'   => 'Finanças Pessoais',
                'group' => 'financa',
            ],
            'homem-rico-babilonia' => [
                'url'   => 'https://amzn.to/3QFHS1D', // ← COLE SEU LINK (+?tag=)
                'title' => 'O Homem Mais Rico da Babilônia',
                'desc'  => 'O clássico das finanças pessoais com 48.000 avaliações ★4.9. Por apenas R$19,65. Leitura obrigatória.',
                'cat'   => 'Finanças & Clássicos',
                'group' => 'financa',
            ],
            'pai-rico' => [
                'url'   => 'https://amzn.to/4dpxV0U', // ← COLE SEU LINK (+?tag=)
                'title' => 'Pai Rico, Pai Pobre — Edição de 20 anos',
                'desc'  => 'O livro que mudou a forma como milhões de pessoas pensam sobre dinheiro. 34.000 avaliações ★4.9.',
                'cat'   => 'Educação Financeira',
                'group' => 'financa',
            ],
            'arte-gastar' => [
                'url'   => 'https://amzn.to/4esYfbv', // ← COLE SEU LINK (+?tag=)
                'title' => 'A Arte de Gastar Dinheiro — Morgan Housel',
                'desc'  => 'Do autor de A Psicologia Financeira: escolhas simples para uma vida equilibrada. 1.800 avaliações ★4.8.',
                'cat'   => 'Finanças Pessoais',
                'group' => 'financa',
            ],
            'almanaque-naval' => [
                'url'   => 'https://amzn.to/4tdNUUq', // ← COLE SEU LINK (+?tag=)
                'title' => 'O Almanaque de Naval Ravikant',
                'desc'  => 'Um guia para a riqueza e a felicidade do investidor e filósofo do Vale do Silício. 3.000 avaliações ★4.7.',
                'cat'   => 'Riqueza & Mentalidade',
                'group' => 'financa',
            ],

            // ── Grupo: Carreira & Liderança ────────────────────────────────
            // Fonte: Mais Vendidos Amazon BR — Carreiras + Negócios, mai/2026
            'como-fazer-amigos' => [
                'url'   => 'https://amzn.to/4exZSVz', // ← COLE SEU LINK (+?tag=)
                'title' => 'Como Fazer Amigos e Influenciar Pessoas — Dale Carnegie',
                'desc'  => 'O guia de comunicação e relacionamento mais vendido de todos os tempos. 24.000 avaliações ★4.8.',
                'cat'   => 'Comunicação & Carreira',
                'group' => 'carreira',
            ],
            'negocie-fbi' => [
                'url'   => 'https://amzn.to/42MrQ8D', // ← COLE SEU LINK (+?tag=)
                'title' => 'Negocie como se sua Vida Dependesse Disso — Chris Voss',
                'desc'  => 'Técnicas reais do FBI para negociar qualquer coisa — clientes, salário, parcerias. 5.000 avaliações ★4.8.',
                'cat'   => 'Negociação & Carreira',
                'group' => 'carreira',
            ],
            'meditacoes-marco' => [
                'url'   => 'https://amzn.to/4ukKlNa', // ← COLE SEU LINK (+?tag=)
                'title' => 'Meditações de Marco Aurélio — Edição com postais',
                'desc'  => 'A filosofia estoica aplicada à vida real e ao trabalho. 10.600 avaliações ★4.8.',
                'cat'   => 'Estoicismo & Carreira',
                'group' => 'carreira',
            ],
            'roube-artista' => [
                'url'   => 'https://amzn.to/3QO4ZqQ', // ← COLE SEU LINK (+?tag=) — Kindle
                'title' => 'Roube como um Artista — Austin Kleon',
                'desc'  => 'Como criar seu próprio trabalho com base nas influências certas. 25.000 avaliações ★4.7.',
                'cat'   => 'Criatividade & Carreira',
                'group' => 'carreira',
            ],
            'rapido-devagar' => [
                'url'   => 'https://amzn.to/4emChqG', // ← COLE SEU LINK (+?tag=)
                'title' => 'Rápido e Devagar — Daniel Kahneman',
                'desc'  => 'Como o cérebro toma decisões — e como tomar decisões melhores na carreira e nos negócios. 19.800 avaliações ★4.7.',
                'cat'   => 'Decisão & Carreira',
                'group' => 'carreira',
            ],
        ] );

        // ── Placement → grupo padrão ─────────────────────────────────────────
        $placement_groups = [
            'hero'        => 'ia',
            'banner-top'  => 'ia',
            'inline'      => 'copy',
            'inline-2'    => 'copy',
            'sidebar'     => 'copy',
            'sidebar-2'   => 'prod',
            'final'       => 'prod',
            'tcc'         => 'tcc',      // uso explícito: redatudo_amazon_ad('tcc')
            'financa'     => 'financa',  // uso explícito: redatudo_amazon_ad('financa')
            'carreira'    => 'carreira', // uso explícito: redatudo_amazon_ad('carreira')
            'default'     => 'ia',
        ];

        // Produto único forçado (compatibilidade retroativa)
        if ( isset( $args['product'] ) ) {
            $key     = $args['product'];
            $product = isset( $catalog[ $key ] ) ? $catalog[ $key ] : reset( $catalog );
            $items   = [ $product ];
        } else {
            // Grupo a exibir
            $group = isset( $args['group'] )
                ? $args['group']
                : ( $placement_groups[ $placement ] ?? 'ia' );

            $items = array_values( array_filter( $catalog, fn( $p ) => ( $p['group'] ?? '' ) === $group ) );
            if ( empty( $items ) ) {
                $items = array_values( $catalog );
            }
            // Embaralha para variar os anúncios a cada carregamento
            shuffle( $items );
            // Máximo de 2 itens por bloco
            $items = array_slice( $items, 0, 2 );
        }

        // ── Render: lista estilo anúncio de texto ────────────────────────────
        $uid = 'amz-' . esc_attr( $placement ) . '-' . substr( md5( $placement . ( $args['product'] ?? $group ?? 'x' ) ), 0, 6 );

        echo '<div class="rdtd-textad" id="' . $uid . '"'
            . ' data-ga4="affiliate_impression"'
            . ' data-ga4-placement="' . esc_attr( $placement ) . '">';

        echo '<div class="rdtd-textad-label">📚 Livros recomendados</div>';
        echo '<div class="rdtd-textad-list">';

        foreach ( $items as $i => $product ) {
            $url   = esc_url( $product['url'] );
            $title = esc_html( $product['title'] );
            $desc  = esc_html( $product['desc'] );
            $cat   = esc_html( $product['cat'] );
            $pkey  = array_search( $product, $catalog ) ?: 'item-' . $i;

            echo '<div class="rdtd-textad-item">';
            echo '<a href="' . $url . '"'
                . ' class="rdtd-textad-title"'
                . ' target="_blank"'
                . ' rel="noopener sponsored"'
                . ' data-ga4="affiliate_click"'
                . ' data-ga4-placement="' . esc_attr( $placement ) . '"'
                . ' data-ga4-product="' . esc_attr( $pkey ) . '">'
                . $title . '</a>';
            echo '<div class="rdtd-textad-meta">'
                . '<span class="rdtd-textad-domain">amazon.com.br</span>'
                . ' &middot; '
                . '<span class="rdtd-textad-cat">' . $cat . '</span>'
                . '</div>';
            echo '<div class="rdtd-textad-desc">' . $desc . '</div>';
            echo '</div>';
        }

        echo '</div></div>';
    }
}

/**
 * Theme functions and definitions.
 */

if ( is_readable( __DIR__ . '/vendor/autoload.php' ) ) {
    require __DIR__ . '/vendor/autoload.php';
}
use Firebase\JWT\JWT;
require('setup.php');
//require('rd-coupon.php');
//require('util-switch.php');
function nuvemTagsShortcode(){
    $tags = get_tags();
    $html = '<div class="post_tags">';
    foreach ( $tags as $tag ) {
        $tag_link = get_tag_link( $tag->term_id );
                
        $html .= "<a href='{$tag_link}' title='{$tag->name} Tag' class='{$tag->slug}'>";
        $html .= "{$tag->name}</a>";
    }
    $html .= '</div>';
    echo $html;
}



function woo_rd_template($attr, $content=null){
    return woocommerce_content();
}


add_shortcode( 'ga4_sign_up_event', function(){
    $html = '<script>';
    $html .= 'gtag("event", "sign_up", { method: "Site" });';
    $html .= '</script>';
    echo $html;
} );

add_shortcode( 'countdown', function($attrs, $content = null){
    $html = '<script>';
    $html .= 'var countDownDate = new Date("Ago 30, 2022 00:00:00").getTime();';
    $html .= 'var x = setInterval(function() {';
    $html .= 'var now = new Date().getTime();';
    $html .= 'var distance = countDownDate - now;';
    $html .= 'var days = Math.floor(distance / (1000 * 60 * 60 * 24));';
    $html .= 'var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));';
    $html .= 'var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));';
    $html .= 'var seconds = Math.floor((distance % (1000 * 60)) / 1000);';
    $html .= 'document.getElementById("countdown").innerHTML = "Preços expiram em " + days + " dias " + hours + ":" + minutes + ":" + seconds + "";';
    $html .= 'if (distance < 0) {';
    $html .= 'clearInterval(x);';
    $html .= 'document.getElementById("countdown").innerHTML = "Preço expirado.";';
    $html .= '}';
    $html .= '}, 1000);';
    $html .= '</script>';
    $html .= '<p><span id="countdown" class="badge bg-danger"></span></p>';
    return $html;
} );


function starGeneraton($set_star){
  $star .= '';
  for ($i=0; $i < 5; $i++) { 
    if($i<$set_star){
        $star .='<i class="fa fa-star u-color"></i>';
    }else{
        $star .='<i class="fa fa-star-o u-color"></i>';
    }
  }
  return $star;
}

function cmp($a, $b)
{   
    $ratingA = intval( get_comment_meta( $a->comment_ID, 'rating', true ) );
    $ratingB = intval( get_comment_meta( $b->comment_ID, 'rating', true ) );
    if ($ratingA == $ratingB) {
    return 0;
    }
    return ($ratingA > $ratingB) ? -1 : 1;
}

function filterCommentsByLenght($comment){
 return strlen($comment->comment_content)>0;
}

function remove_duplicate_models( $comments ) {
    $models = array_map( function( $comment ) {
        return $comment->comment_content;
    }, $comments );

    $unique_models = array_unique( $models );

    return array_values( array_intersect_key( $comments, $unique_models ) );
}

function rd_reviews_products( $atts ) {
    // --- Ajuste dos parâmetros e segurança ---
    if ( empty( $atts ) || ! isset( $atts['id'] ) ) return '';

    $comments = get_comments( 'post_id=' . $atts['id'] );
    $count_comments = count($comments);
    if ( ! $comments ) return '';

    // Ordenações e filtros customizados, mantenha suas funções!
    usort($comments, 'cmp');
    $array_unique = remove_duplicate_models($comments);
    $comments_filtered = array_filter($array_unique, 'filterCommentsByLenght');

    // --- Estatísticas principais para badge média ---
    $somaRating = 0;
    foreach ( $comments as $comment ){
        $rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );
        $somaRating += $rating;
    }
    $average = $count_comments ? ($somaRating / $count_comments) : 0;

    // --- Início do HTML ---
    $html = '';
    $html .= '
    <style>
    .avaliacao-hero-titulo {
      font-family: "Orbitron", Arial, sans-serif;
      font-weight: bold;
      font-size: 2rem;
      margin-bottom: .4em;
      letter-spacing:1.2px;
      background: linear-gradient(90deg,#00ffd0,#7f00ff 80%);
      -webkit-background-clip:text;
      -webkit-text-fill-color:transparent;
      text-transform: uppercase;
    }
    .avaliacao-hero-desc {
      color: #b8e6ff;
      font-size: 1.06em;
      font-family: Orbitron,sans-serif;
      margin-bottom: 2.1em;
    }
    .badge.review-badge-glow {
      background: linear-gradient(90deg,#00bfff,#7f00ff);
      color:#fff;
      font-family:\'Orbitron\',sans-serif;
      font-size:1.09em;
      font-weight:700;
      border-radius:18px;
      padding:.51em 1.8em;
      box-shadow:0 6px 23px #00ffd0cc;
      text-transform:uppercase;
      letter-spacing:1.2px;
      display:inline-flex;
      align-items:center;
      gap:6px;
      animation: pulseGlow 4s infinite alternate;
    }
    @keyframes pulseGlow {
      0% { box-shadow:0 6px 38px #00ffd040,0 1px 2px #7f00ff13;}
      100% { box-shadow:0 10px 64px #00ffd07c,0 1px 18px #7f00ff11;}
    }
    .reviews-row-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(290px,1fr));
      gap: 2rem;
      margin-top: 1em;
      margin-bottom: 1em;
    }
    .avaliacao-card-glow {
      background: rgba(23,23,39,0.98);
      border-radius: 22px;
      box-shadow: 0 6px 38px #00ffd049;
      border: 1.5px solid #00bfff30;
      transition: transform .18s, box-shadow .16s;
      min-height:210px;
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
    }
    .avaliacao-card-glow:hover {
      transform: translateY(-8px) scale(1.03);
      box-shadow: 0 16px 44px 0 #00ffd08f, 0 1px 2px #7f00ff23;
    }
    .avaliacao-avatar-hero {
      width:48px;height:48px;
      border-radius:50%;
      background:linear-gradient(135deg,#7f00ff 60%,#00bfff 100%);
      display:inline-flex;align-items:center;justify-content:center;
      color:#fff;font-size:1.27em;font-weight:bold;
      box-shadow:0 2px 8px #00ffd052;border:2px solid #191940;
      margin-right:10px;
      transition: box-shadow .18s;
    }
    .avaliacao-card-glow .fa-quote-left {
      font-size: 1.2rem;
      color: #00ffd0;
      margin-right: 7px;
      opacity: 0.87;
    }
    .avaliacao-autor-label {
      font-family:\'Orbitron\',Arial,sans-serif;
      font-size:1.06em;
      color:#00ffd0;
      font-weight:700;
      margin-bottom:0;
      display:block;
      line-height:1.2;
    }
    .avaliacao-txt {
      color: #e8f5ff;
      font-size: 1.11rem;
      line-height:1.5;
      flex:1;
      margin-bottom:10px;
    }
    .avaliacao-stars {
      color: #00ffd0;
      font-size: 1.04em;
    }
    @media (max-width: 768px) {
      .reviews-row-grid { grid-template-columns: 1fr; gap: 1.15rem;}
      .avaliacao-hero-titulo { font-size:1.19rem;}
    }
    </style>
    ';

    // Hero/copy inicial (coloque só na página principal de avaliações)
    if(empty($atts['nohero'])) {
    $html .= '
    <div class="col-12 text-center pb-2">
      <div style="font-size:2.1em;">✨</div>
      <div class="avaliacao-hero-titulo">Histórias que Inspiram</div>
      <p class="avaliacao-hero-desc mx-auto" style="max-width:540px;">
        Veja como <strong style="color:#00ffd0;">Redatudo</strong> está mudando o jogo para criadores, professores, agências e empreendedores.<br>
        <span style="color:#bbeff2;">Experimente uma nova era de produtividade com a força da IA e surpreenda-se com os resultados reais.</span>
      </p>
    </div>';
    }

    // Badge de avaliação média
    $html .= '
    <div class="col-12 mb-4 text-center">
      Nota média <b>'.round($average,2).'</b>
      <span style="font-weight:500;margin-left:1em;">('.$count_comments.' avaliações)</span> <br>
      <span class="badge review-badge-glow">
        '.starGeneraton(round($average)).'
      </span>
    </div>
    ';

    // Lista de avaliações com visual high-end
    $limit_comment = 0;
    $html .= '<div class="reviews-row-grid">';
    foreach ( $comments_filtered as $comment ) {
        $rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );
        $user_initial = strtoupper(mb_substr(get_comment_author($comment),0,1,"UTF-8"));
        $html .= '
        <div class="avaliacao-card-glow p-4 d-flex flex-column">
          <div class="d-flex align-items-center mb-3">
            <div class="avaliacao-avatar-hero">'.$user_initial.'</div>
            <div>
                <span class="avaliacao-autor-label">'.get_comment_author($comment).'</span>
                <span class="avaliacao-stars">'.starGeneraton($rating).'</span>
            </div>
          </div>
          <div class="avaliacao-txt">
            <i class="fa fa-quote-left"></i>
            '.esc_html($comment->comment_content).'
          </div>
        </div>
        ';
        $limit_comment += 1;
        if( !is_null($atts['limit']) && $limit_comment==$atts['limit']){
            break;
        }
    }
    $html .= '</div>';

    if(!is_null($atts['limit']))
        $html .='<div class="col-12 mt-3 mb-2 text-center"><a href="https://redatudo.online/avaliacoes" style="color:#00bfff;font-family:\'Orbitron\';font-weight:bold;">Veja todas as avaliações &raquo;</a></div>';

    return $html;
}

function post_recente( $atts, $content = null ) 
{
    $html = '<h6 class="mt-4">Postagens recentes:</h6>';
    $recent = get_posts(array(
        'orderby'        => 'date',
		'order'          => 'DESC',
		'posts_per_page' => 3,
		'offset'         => 1
	)); 
    
    if( !$recent )
        return 'Não há posts recentes';
        
    foreach( $recent as $post )
    {
        $html .= sprintf(
            '<p><a href="%s">%s</a></p>',
            get_permalink( $post->ID ),
            $post->post_title
            );
    }
    
    
    return $html;
}

/* function has_woocommerce_subscription($the_user_id, $the_product_id, $the_status) {
	$current_user = wp_get_current_user();
	if (empty($the_user_id)) {
		$the_user_id = $current_user->ID;
	}
	if (WC_Subscriptions_Manager::user_has_subscription( $the_user_id, $the_product_id, $the_status)) {
		return true;
	}
} */

function rd_categories($atts, $content = null){
    $html = '<h6 class="mt-4">Categorias:</h6>';
    $categories = get_categories( array(
        'orderby' => 'name',
        'order'   => 'ASC'
    ) );
    
    if( !$categories )
        return 'Não há categorias';
        
    foreach( $categories as $category )
    {
        $category_link = sprintf( 
            '<a href="%1$s" alt="%2$s">%3$s</a>',
            esc_url( get_category_link( $category->term_id ) ),
            esc_attr( sprintf( __( 'View all posts in %s', 'textdomain' ), $category->name ) ),
            esc_html( $category->name )
        );
        
        $html .= '<p>' . sprintf( esc_html__( '%s', 'textdomain' ), $category_link ) . '</p>';
    }
    return $html;
}


function wc_form_field_args($args, $key, $value) {
  if(preg_match('/billing_address_1/', $key ) || preg_match('/password/', $key ) 
  || preg_match('/billing_persontype/', $key ) || preg_match('/billing_cpf/', $key )){
    $args['class'] = array( 'form-group ml-4' );
    $args['input_class'] = array( 'form-control form-control-lg' );  
  }else {
    $args['class'] = array( 'form-group ml-4 col-lg-6' );
    $args['input_class'] = array( 'form-control form-control-lg' ); 
  }
  return $args;
}


function modelByTitle($slug){
    try {
        $hg = file_get_contents("https://hidden-crag-82241.herokuapp.com/api/public-models?offset=0&limit=1000");
        $json = json_decode($hg);
        $results = $json->results;
        $model = array_filter($results, function ($it) { return strcmp($it->slug, $slug)==0; }); 

        return $model[0];
        //return $results;
    }catch (\Exception $error){
        return $error;
    }
}

add_shortcode( 'use-case-2', function($attrs){
    $slug = $attrs['slug'];
    $model = modelByTitle($slug);
	//var_dump($model);
    get_template_part('use-case', '', array( 
     'data'  => $model
     ) );
} );

function page_title_sc( ){
    return get_the_title();
}
add_shortcode( 'page_title', 'page_title_sc' );
add_shortcode('banner', function($attr){
    require('banner.php');
});

//Início do código ----------------------------------------------------------

//Adicionando campos no registro do usuário

function wooc_extra_register_fields() {?>
    <div class="form-group row">
        <p class="form-group col-6">
            <label for="reg_billing_first_name"><?php _e( 'First name', 'woocommerce' ); ?>*</label>
            <input placeholder="Digite seu nome" type="text" class="form-control form-control-sm" name="billing_first_name" id="reg_billing_first_name" value="<?php if ( ! empty( $_POST['billing_first_name'] ) ) esc_attr_e( $_POST['billing_first_name'] ); ?>" />
        </p>
        <p class="form-group col-6">
            <label for="reg_billing_last_name"><?php _e( 'Last name', 'woocommerce' ); ?>*</label>
            <input placeholder="Digite seu sobrenome" type="text" class="form-control form-control-sm" name="billing_last_name" id="reg_billing_last_name" value="<?php if ( ! empty( $_POST['billing_last_name'] ) ) esc_attr_e( $_POST['billing_last_name'] ); ?>" />
        </p>
    </div>
    <p class="form-group">
        <label for="reg_billing_phone"><?php _e( 'Phone', 'woocommerce' ); ?>*</label>
        <input type="text" class="form-control form-control-sm phone" name="billing_phone" id="reg_billing_phone" value="<?php esc_attr_e( $_POST['billing_phone'] ); ?>" />
    </p>
    <div class="clear"></div>
    
    <?php
}
add_action( 'woocommerce_register_form_start', 'wooc_extra_register_fields' );
//Validando os campos obrigatórios preenchidos
function wooc_validate_extra_register_fields( $username, $email, $validation_errors ) {
   if ( isset( $_POST['billing_first_name'] ) && empty( $_POST['billing_first_name'] ) ) {
          $validation_errors->add( 'billing_first_name_error', __( 'O campo <strong>Nome</strong> é obrigatório!', 'woocommerce' ) );
   }
   if ( isset( $_POST['billing_last_name'] ) && empty( $_POST['billing_last_name'] ) ) {
          $validation_errors->add( 'billing_last_name_error', __( 'O campo <strong>Sobrenome</strong> é obrigatório!', 'woocommerce' ) );
   }
  if ( isset( $_POST['billing_phone'] ) && empty( $_POST['billing_phone'] ) ) {
          $validation_errors->add( 'billing_phone_error', __( 'O campo <strong>Telefone</strong> é obrigatório!', 'woocommerce' ) );
   }
      return $validation_errors;
}
add_action( 'woocommerce_register_post', 'wooc_validate_extra_register_fields', 10, 3 );
//Salvando os campos
function wooc_save_extra_register_fields( $customer_id ) {
   if ( isset( $_POST['billing_first_name'] ) ) {
          //Primeiro nome - campo padrão
          update_user_meta( $customer_id, 'first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
          // Primeiro nome - campo do WooCommerce
          update_user_meta( $customer_id, 'billing_first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
   }
   if ( isset( $_POST['billing_last_name'] ) ) {
          //Último nome - campo padrão
          update_user_meta( $customer_id, 'last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
          //Último nome - campo do WooCommerce
          update_user_meta( $customer_id, 'billing_last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
   }
  if ( isset( $_POST['billing_phone'] ) ) {
              //Telefone - campo do WooCommerce
              update_user_meta( $customer_id, 'billing_phone', sanitize_text_field( $_POST['billing_phone'] ) );
   }
}
add_action( 'woocommerce_created_customer', 'wooc_save_extra_register_fields' );
add_action(
    'wp_logout',
    function() {
        $login_app = isset( $_GET['login_app'] ) ? sanitize_text_field( $_GET['login_app'] ) : 'hub';

        $login_url = function_exists( 'wc_get_page_permalink' )
            ? wc_get_page_permalink( 'myaccount' )
            : get_permalink( get_option( 'woocommerce_myaccount_page_id' ) );

        $redirect_url = add_query_arg(
            [
                'login_app' => $login_app,
                'logout' => 1,
            ],
            $login_url
        );

        wp_redirect( $redirect_url );
        exit;
    }
);


// Adicione este código ao seu tema functions.php ou plugin personalizado

function redatudo_posts_recentes_shortcode($atts) {
    $atts = shortcode_atts(
        array(
            'quantidade' => 4,
            'categoria'  => '', // slug ou vazio para todas
        ), $atts, 'redatudo_artigos_recentes'
    );

    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => intval($atts['quantidade']),
        'post_status'    => 'publish',
    );
    if (!empty($atts['categoria'])) {
        $args['category_name'] = $atts['categoria'];
    }
    $query = new WP_Query($args);

    ob_start();
    if ($query->have_posts()) : ?>
        <div class="redatudo-recentes-grid">
        <?php
        $count = 0;
        while ($query->have_posts()) : $query->the_post();
            $count++;
            // Destaque para o 1º post (caixa maior)
            $is_featured = $count === 1;
            ?>
            <article class="redatudo-artigo-card <?php if($is_featured){echo 'redatudo-destaque';} ?>">
                <?php if ($is_featured): ?>
                    <span class="redatudo-artigo-badge">Destaque</span>
                <?php endif; ?>
                <?php if (has_post_thumbnail()): ?>
                    <a href="<?php the_permalink(); ?>">
                        <img class="redatudo-artigo-img" src="<?php the_post_thumbnail_url($is_featured ? 'medium_large' : 'medium'); ?>" alt="<?php the_title_attribute(); ?>">
                    </a>
                <?php else: ?>
                    <a href="<?php the_permalink(); ?>">
                        <div class="redatudo-artigo-img redatudo-img-placeholder"></div>
                    </a>
                <?php endif; ?>
                <a href="<?php the_permalink(); ?>">
                    <h3 class="redatudo-artigo-title"><?php the_title(); ?></h3>
                </a>
                <p class="redatudo-artigo-exc">
                    <?php
                        $exc = get_the_excerpt();
                        echo wp_trim_words($exc, $is_featured ? 28 : 14, '...');
                    ?>
                </p>
                <a class="redatudo-artigo-lermais" href="<?php the_permalink(); ?>">
                    Ler mais &rarr;
                </a>
            </article>
        <?php endwhile; ?>
        </div>
    <?php
    wp_reset_postdata();
    else:
        echo '<p style="color:#b8e6ff">Sem artigos recentes no momento.</p>';
    endif;
    return ob_get_clean();
}
add_shortcode('redatudo_artigos_recentes', 'redatudo_posts_recentes_shortcode');


// CSS inline para facilitar (ajuste ou coloque no seu customizer/arquivo)
add_action('wp_head', function(){
    ?>
    <style>
    .redatudo-recentes-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        margin-bottom: 2.3em;
    }
    @media(max-width:800px){
        .redatudo-recentes-grid { grid-template-columns: 1fr;}
    }
    .redatudo-artigo-card {
        background: rgba(23,20,56,0.98);
        border-radius: 22px;
        box-shadow: 0 2px 32px #7f00ff16;
        overflow: visible;
        position: relative;
        padding: 1.4rem 1.2rem 1.2rem 1.2rem;
        border:1.8px solid rgba(0,191,255,0.11);
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        transition: box-shadow .20s,transform .19s;
    }
    .redatudo-artigo-card:hover {
        box-shadow: 0 10px 38px #7f00ff55,0 1px 2px #00ffd0cc;
        transform: translateY(-5px) scale(1.028);
    }
    .redatudo-artigo-img {
        display: block;
        width: 100%;
        max-height: 180px;
        min-height: 110px;
        border-radius: 14px;
        object-fit: cover;
        box-shadow: 0 2px 16px #00bfff44;
        margin-bottom: 1em;
        background: linear-gradient(90deg,#221841 60%,#00bfff10 100%);
        transition: box-shadow .13s;
    }
    .redatudo-img-placeholder {
        background: linear-gradient(90deg,#7f00ff 40%,#00bfff 100%);
        height: 110px;
        box-shadow: 0 2px 8px #00ffd040;
    }
    .redatudo-artigo-title {
        font-family: 'Orbitron', Arial, sans-serif;
        font-weight: bold;
        font-size: 1.18rem;
        margin-bottom: .6em;
        color: #fff;
        letter-spacing: .3px;
    }
    .redatudo-artigo-exc {
        color: #b8e6ff;
        font-size: 1.01em;
        min-height:36px;
        margin-bottom: .8em;
    }
    .redatudo-artigo-lermais {
        font-family: 'Orbitron', Arial, sans-serif;
        background: linear-gradient(90deg,#7f00ff 50%,#00bfff 100%);
        color: #fff;
        padding: 0.41em 1.16em;
        border-radius: 15px;
        font-size: 0.93em;
        font-weight: 600;
        letter-spacing: .9px;
        box-shadow:0 1px 8px #00bfff33;
        text-decoration: none !important;
        transition: transform .16s, box-shadow .17s;
        display: inline-block;
    }
    .redatudo-artigo-lermais:hover {
        background: linear-gradient(95deg,#00bfff 60%,#7f00ff 100%);
        box-shadow:0 3px 18px #00ffd044;
        transform: translateY(-1px) scale(1.04);
        color:#fff;
    }
    .redatudo-artigo-badge {
        position: absolute;
        top: -16px; left: 16px;
        background: linear-gradient(90deg,#00ffd0 55%,#00bfff 100%);
        color: #181733;
        font-family: 'Orbitron', Arial, sans-serif;
        font-size: .95rem;
        font-weight: bold;
        border-radius: 16px;
        padding: 0.24em 1em;
        letter-spacing: 1px;
        box-shadow: 0 2px 16px #00ffd085;
        z-index:100;
    }
    .redatudo-destaque {
        border:2.2px solid #00ffd0;
        background: linear-gradient(98deg, #221841 90%,#00ffd00f 100%);
        box-shadow:0 6px 24px #00ffd048,0 1px 2px #7f00ff10;
    }
    </style>
    <?php
});

function redatudo_blog_overflow( $atts ) {
    // Parâmetros aceitos
    $atts = shortcode_atts( array(
        'id'        => '',
        'category'  => '',
        'btntext'   => 'Leia no Blog',
        'btnurl'    => '',
    ), $atts );

    // Monta query: prioridade ao ID, senão pega último da categoria
    if( $atts['id'] ) {
        $query = new WP_Query( array( 'p' => intval($atts['id']) ) );
    } elseif( $atts['category'] ) {
        $query = new WP_Query( array(
            'posts_per_page' => 1,
            'category_name'  => sanitize_text_field($atts['category']),
            'post_status'    => 'publish'
        ));
    } else {
        $query = new WP_Query( array( 'posts_per_page' => 1, 'post_status' => 'publish' ));
    }

    if( !$query->have_posts() )
        return '';

    ob_start();

    while( $query->have_posts() ) : $query->the_post();
        $thumb = get_the_post_thumbnail_url(get_the_ID(), 'large');
        if(!$thumb) $thumb = 'https://redatudo-pt-storage-pull-zone.b-cdn.net/capa-blog-redatudo-default.png';

        $categories = get_the_category();
        $cat_name = $categories ? esc_html( $categories[0]->name ) : '';
        $cat_link = $categories ? get_category_link( $categories[0]->term_id ) : '';
        $excerpt = get_the_excerpt();
        if(strlen($excerpt) > 130) $excerpt = mb_substr($excerpt, 0, 127).'…';

        $post_url = get_permalink();
        $btn_text = esc_html($atts['btntext']);
        $btn_url  = $atts['btnurl'] ? esc_url($atts['btnurl']) : $post_url;
        ?>
        <style>
        .redatudo-blog-overflow {
            position: relative;
            width: 100%;
            height: 320px;
            border-radius: 24px;
            background: #141125;
            box-shadow: 0 6px 38px #00bfff33, 0 1px 2px #7f00ff18;
            margin-bottom: 2.2rem;
            overflow: hidden;
            transition: box-shadow .19s,transform .22s;
            min-height: 230px;
        }
        .redatudo-blog-overflow__bg {
            position: absolute;
            inset: 0;
            width: 100%; height: 100%;
            object-fit: cover;
            object-position: center;
            filter: brightness(0.74) blur(1.5px) saturate(1.4);
            z-index: 1;
            transition: filter .21s;
        }
        .redatudo-blog-overflow:hover .redatudo-blog-overflow__bg {
            filter: brightness(0.89) blur(0.5px) saturate(1.13);
        }
        .redatudo-blog-overflow__overlay {
            position: absolute;
            inset:0; z-index: 2;
            background: linear-gradient(0deg, #101022cc 66%, #10102330 99%, transparent 100%);
        }
        .redatudo-blog-overflow__content {
            position: absolute;
            left: 0; right: 0; bottom: 0;
            z-index: 3;
            padding: 2.1rem 1.7rem 1.3rem 2.1rem;
            color: #fff;
            max-width: 75vw;
        }
        .redatudo-blog-overflow .cat-badge {
            display: inline-block;
            font-family: 'Orbitron', Arial, sans-serif;
            font-size: 0.98rem;
            font-weight: 600;
            background: linear-gradient(87deg, #00ffd0 40%, #7f00ff 110%);
            color: #fff;
            border-radius: 14px;
            padding: 0.14em 0.7em;
            margin-bottom: 0.6em;
            letter-spacing: 1.1px;
            text-transform: uppercase;
            box-shadow: 0 2px 12px #00ffd050;
        }
        .redatudo-blog-overflow__title {
            font-family: 'Orbitron', Arial, sans-serif;
            font-size: 1.45rem;
            font-weight: 700;
            letter-spacing: 0.7px;
            margin-bottom: 0.66em;
            color: #fff;
            text-shadow: 0 6px 18px #101025ce;
            line-height: 1.18;
        }
        .redatudo-blog-overflow__desc {
            font-size: 1rem;
            color: #b8e6ff;
            max-width: 520px;
            margin-bottom: 1.1em;
            text-shadow: 0 2px 12px #0023a880;
        }
        .redatudo-blog-overflow__cta {
            background: linear-gradient(90deg, #7f00ff, #00bfff 90%);
            color: #fff!important;
            border-radius: 18px;
            border: none;
            padding: 0.53em 1.25em;
            font-size: 1.06rem;
            font-family: 'Orbitron', Arial, sans-serif;
            font-weight: 600;
            letter-spacing: 1.1px;
            box-shadow: 0 2px 12px #00bfff51;
            transition: background .19s, transform .15s, box-shadow .18s;
            display: inline-block;
            text-decoration: none !important;
        }
        .redatudo-blog-overflow__cta:hover {
            background: linear-gradient(95deg, #00bfff 80%, #7f00ff 100%);
            box-shadow: 0 6px 24px #00ffd099;
            transform: translateY(-2px) scale(1.04);
        }
        @media (max-width: 600px){
            .redatudo-blog-overflow {
                height: 210px !important;
                border-radius: 16px;
            }
            .redatudo-blog-overflow__content {
                padding: 1.3rem 0.6rem 0.9rem 1.05rem;
                font-size: 0.97rem;
                max-width: 97vw;
            }
            .redatudo-blog-overflow__title { font-size:1.01rem; }
            .redatudo-blog-overflow__desc { font-size:0.95rem;}
        }
        </style>
        <div class="redatudo-blog-overflow">
            <img class="redatudo-blog-overflow__bg" src="<?php echo esc_url($thumb); ?>" alt="<?php the_title_attribute(); ?>" />
            <span class="redatudo-blog-overflow__overlay"></span>
            <div class="redatudo-blog-overflow__content">
                <?php if($cat_name): ?>
                    <a href="<?php echo esc_url($cat_link); ?>" class="cat-badge"><?php echo $cat_name; ?></a>
                <?php endif; ?>
                <div class="redatudo-blog-overflow__title"><?php the_title(); ?></div>
                <div class="redatudo-blog-overflow__desc"><?php echo esc_html($excerpt); ?></div>
                <a href="<?php echo esc_url($btn_url); ?>" class="redatudo-blog-overflow__cta"><?php echo $btn_text; ?></a>
            </div>
        </div>
        <?php
    endwhile;
    wp_reset_postdata();

    return ob_get_clean();
}
add_shortcode('redatudo_overflow_blog', 'redatudo_blog_overflow');


function redatudo_sharelike_shortcode($atts) {
    ob_start();
    ?>
  
  <div class="redatudo-sharelike-wrapper" style="width:100%;display:flex;justify-content:center;">
  <div id="redatudo-share-like-widget-<?php echo uniqid(); ?>" style="width:100%;max-width:330px;">
    <style>
      .redatudo-sharelike-container {
        background: #171727;
        border-radius: 18px;
        box-shadow: 0 2px 17px #00bfff14;
        padding: 1em 0.7em 1em 0.7em;
        margin: 0.7em 0 1em 0;
        width:100%;
      }
      .redatudo-badge-custom {
        background: linear-gradient(90deg, #00bfff, #7f00ff 70%);
        color: #fff;
        text-transform: uppercase;
        font-family: 'Orbitron', Arial, sans-serif;
        letter-spacing: .9px;
        font-size: 0.98rem;
        font-weight: 700;
        border-radius: 11px;
        padding: 0.14em 0.7em;
        margin-bottom: .7em;
        box-shadow: 0 3px 9px #00ffd028;
        display: inline-block;
      }
      .redatudo-like-row {
        display: flex;
        align-items: center;
        gap: 0.6em;
        margin: .6em 0 0.4em 0.03em;
      }
      .redatudo-like-btn {
        background: linear-gradient(93deg, #00bfff 58%, #7f00ff 110%);
        color: #fff;
        font-family: 'Orbitron',Arial,sans-serif;
        font-weight: 600;
        border-radius: 13px;
        min-width: 36px;
        min-height: 28px;
        font-size: 0.97rem;
        padding: 0.27em 0.85em;
        display: flex;
        align-items: center;
        border: none;
        cursor: pointer;
        box-shadow: 0 1px 6px #00ffd032;
        transition: background .17s, color .12s, box-shadow .19s, transform .13s;
        text-shadow: 0 1px 3px #10102270;
        outline: none;
        position: relative;
      }
      .redatudo-like-btn.liked {
        background: linear-gradient(88deg, #7f00ff 42%, #00ffd0 100%);
        color: #00ffd0 !important;
        box-shadow: 0 2px 11px #00ffd063 !important;
      }
      .redatudo-like-btn:hover {
        background: linear-gradient(90deg, #7f00ff 20%, #00ffd0 100%);
        color: #00ffd0;
        transform: translateY(-1px) scale(1.03);
        box-shadow: 0 2px 14px #00ffd052;
      }
      .redatudo-like-icon {
        font-size: 1.09em;
        margin-right: 0.32em;
        color: #00ffd0;
        filter: drop-shadow(0 2px 7px #00bfff8e);
        transition: color .15s;
      }
      .redatudo-like-count {
        color: #00ffd0;
        font-family: 'Orbitron', Arial, sans-serif;
        font-weight: 700;
        font-size: .97em;
        margin-left: 0.19em;
        text-shadow: 0 2px 7px #00bfff20;
        line-height: 1.0;
      }
      .redatudo-like-label {
        color:#b8e6ff;
        font-size:0.91em;
        font-family:'Orbitron',Arial,sans-serif;
      }
  
      .redatudo-share-row {
        display: flex;
        flex-wrap: wrap;
        gap: 0.33em;
        align-items: center;
        margin-top: 0.53em;
        justify-content: center;
      }
      .redatudo-share-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 11px;
        padding: 0.2em 0.82em;
        font-family: 'Orbitron', Arial, sans-serif;
        font-weight: 700;
        font-size: 0.92rem;
        color: #fff;
        cursor: pointer;
        border: none;
        background: linear-gradient(92deg, #7f00ff 60%, #00bfff 100%);
        box-shadow: 0 1px 4px #00ffd01a;
        letter-spacing: 0.4px;
        text-decoration: none !important;
        transition: background .15s, color .11s, box-shadow .14s, transform .13s;
        min-width: 82px;
        min-height: 30px;
        margin-right: 0;
      }
      .redatudo-share-btn:hover {
        background: linear-gradient(99deg,#00ffd0 25%, #7f00ff 100%);
        color: #171727;
        box-shadow: 0 2px 8px #00ffd035;
        transform: translateY(-1px) scale(1.03);
      }
      .redatudo-share-btn .redatudo-share-ico {
        font-size: 1.08em;
        margin-right: 0.28em;
        filter: drop-shadow(0 2px 6px #00bfff55);
      }
      .redatudo-share-btn.fb .redatudo-share-ico { color: #00bfff; }
      .redatudo-share-btn.tw .redatudo-share-ico { color: #1da1f2; }
      .redatudo-share-btn.wa .redatudo-share-ico { color: #1efeb7; }
      .redatudo-share-btn.in .redatudo-share-ico { color: #7f00ff; }
      .redatudo-share-btn.ig .redatudo-share-ico { color: #ea3a74; }
      .redatudo-share-btn.cp .redatudo-share-ico { color: #00ffd0; }
      @media (max-width:600px){
        .redatudo-sharelike-container{padding:0.6em 0.13em;}
        .redatudo-share-row{gap:0.16em;}
        .redatudo-share-btn{font-size:0.88rem;min-width:65px;padding:0.12em 0.41em;}
        .redatudo-like-btn{font-size:0.89rem;min-width:28px;min-height:22px;}
        .redatudo-badge-custom{font-size:0.89rem;padding:0.11em 0.44em;}
      }
    </style>
    
    <div class="redatudo-sharelike-container text-center">
  
      <div class="redatudo-badge-custom">Curtir & Compartilhar</div>
      
      <!-- Botão Curtir -->
      <div class="redatudo-like-row justify-content-center" style="justify-content:center;">
        <button class="redatudo-like-btn" id="redatudo-like-btn-<?php echo uniqid(); ?>" aria-label="Curtir">
          <span class="redatudo-like-icon">💜</span>
          Curtir
          <span class="redatudo-like-count" id="redatudo-like-count-<?php echo uniqid(); ?>">0</span>
        </button>
        <span class="redatudo-like-label"></span>
      </div>
      
      <!-- Botões Compartilhar -->
      <div class="redatudo-share-row justify-content-center" style="justify-content:center;">
        <a class="redatudo-share-btn fb" target="_blank" rel="noopener" href="#" id="share-facebook-<?php echo uniqid(); ?>">
          <span class="redatudo-share-ico">📘</span>
          FB
        </a>
        <a class="redatudo-share-btn tw" target="_blank" rel="noopener" href="#" id="share-twitter-<?php echo uniqid(); ?>">
          <span class="redatudo-share-ico">🐦</span>
          Tw
        </a>
        <a class="redatudo-share-btn wa" target="_blank" rel="noopener" href="#" id="share-whatsapp-<?php echo uniqid(); ?>">
          <span class="redatudo-share-ico">💬</span>
          Whats
        </a>
        <a class="redatudo-share-btn in" target="_blank" rel="noopener" href="#" id="share-linkedin-<?php echo uniqid(); ?>">
          <span class="redatudo-share-ico">💼</span>
          In
        </a>
        <button class="redatudo-share-btn cp" id="redatudo-share-copy-<?php echo uniqid(); ?>" aria-label="Copiar link">
          <span class="redatudo-share-ico">🔗</span>Copiar
        </button>
      </div>
    </div>
  
    <script>
        // Variação compacta UID
        (function(){
          var container = document.currentScript.previousElementSibling;
          var uids = [];
          container.querySelectorAll('[id^="redatudo-like-btn"],[id^="redatudo-like-count"],[id^="share-facebook"],[id^="share-twitter"],[id^="share-whatsapp"],[id^="share-linkedin"],[id^="redatudo-share-copy"]').forEach(function(el,i){
              var id = el.id.split('-').slice(-1)[0];
              uids.push(id);
          });
          var attUid = uids[0] || Math.floor(Math.random()*1000000);
          var likeBtn   = container.querySelector('[id^="redatudo-like-btn"]');
          var likeCount = container.querySelector('[id^="redatudo-like-count"]');
          var likeLabel = container.querySelector('.redatudo-like-label');
          var fbBtn     = container.querySelector('[id^="share-facebook"]');
          var twBtn     = container.querySelector('[id^="share-twitter"]');
          var waBtn     = container.querySelector('[id^="share-whatsapp"]');
          var inBtn     = container.querySelector('[id^="share-linkedin"]');
          var cpBtn     = container.querySelector('[id^="redatudo-share-copy"]');
  
          // LIKE LOCALSTORAGE
          var likeKey = 'redatudo_like_' + attUid + '_' + window.location.pathname;
          var countKey = likeKey + '_count';
          var initialCount = localStorage.getItem(countKey) ? parseInt(localStorage.getItem(countKey)) : 0;
          var liked = !!localStorage.getItem(likeKey);
          likeCount.textContent = initialCount;
          if(liked){
              likeBtn.classList.add('liked');
              likeLabel.innerText = 'Você já curtiu.';
          } else {
              likeLabel.innerText = '';
          }
          likeBtn.onclick = function(){
            if(liked) {
              if(initialCount>0) initialCount--;
              likeBtn.classList.remove('liked');
              localStorage.removeItem(likeKey);
              likeLabel.innerText = '';
            } else {
              initialCount++;
              likeBtn.classList.add('liked');
              localStorage.setItem(likeKey, 'y');
              likeLabel.innerText = 'Obrigado por curtir!';
            }
            likeCount.textContent = initialCount;
            liked = !liked;
            localStorage.setItem(countKey, initialCount);
            return false;
          };
  
          // COMPARTILHAR
          var pageUrl = encodeURIComponent(window.location.href);
          var pageTitle = encodeURIComponent(document.title);
          fbBtn.href = 'https://www.facebook.com/sharer/sharer.php?u='+pageUrl;
          twBtn.href = 'https://twitter.com/intent/tweet?url='+pageUrl+'&text='+pageTitle;
          waBtn.href = 'https://wa.me/?text='+pageTitle+'%20'+pageUrl;
          inBtn.href = 'https://www.linkedin.com/sharing/share-offsite/?url='+pageUrl;
          // Copiar link
          cpBtn.onclick = function(){
            navigator.clipboard.writeText(window.location.href)
            .then(()=>{
                cpBtn.innerHTML='<span class="redatudo-share-ico">✅</span>Copiado!';
                setTimeout(()=>cpBtn.innerHTML='<span class="redatudo-share-ico">🔗</span>Copiar', 1500);
            });
          };
        })();
    </script>
  </div>
  </div>
  
    <?php
    return ob_get_clean();
  }
  add_shortcode('redatudo_sharelike','redatudo_sharelike_shortcode');

// Customiza aparência dos campos Stripe Elements no WooCommerce para dark
add_filter( 'wc_stripe_elements_options', function( $elements_options ) {
    $elements_options['style'] = [
        'base' => [
            'color' => '#f2f6fa',
            'fontFamily' => 'Orbitron, Arial, sans-serif',
            'fontSmoothing' => 'antialiased',
            'fontSize' => '18px',
            '::placeholder' => [ 'color' => '#b8e6ff' ],
            'backgroundColor' => '#171727', // para plugins que suportam bg
        ],
        'invalid' => [
            'color' => '#ff007f',
        ]
    ];
    $elements_options['classes'] = [
        'base' => 'stripeRedatudoDark'
    ];
    return $elements_options;
} );

add_filter('woocommerce_product_single_add_to_cart_text', function($text) { 
  return 'Usar Agora';
});
add_filter('woocommerce_product_add_to_cart_text', function($text) { 
  return 'Adicionar ao Redatudo';
});

add_action('init', function() {
  if (
      isset($_POST['register']) &&
      isset($_POST['email']) &&
      wp_verify_nonce($_POST['woocommerce-register-nonce'], 'woocommerce-register')
  ) {
      $email    = sanitize_email($_POST['email']);
      $username = isset($_POST['username']) ? sanitize_user($_POST['username']) : '';
      $password = isset($_POST['password']) ? $_POST['password'] : '';

      // Auto-gera username se não existir campo
      if(empty($username)) {
          $username = strstr($email, '@', true);
      }

      if(email_exists($email)) {
          wc_add_notice( 'Este e-mail já está cadastrado.', 'error' );
          return;
      }

      if(username_exists($username)) {
          wc_add_notice( 'Este nome de usuário já existe.', 'error' );
          return;
      }

      $user_id = wc_create_new_customer($email, $username, $password);

      if (is_wp_error($user_id)) {
          wc_add_notice( $user_id->get_error_message(), 'error' );
          return;
      }

      // Loga o usuário automaticamente
      wp_set_current_user($user_id);
      wp_set_auth_cookie($user_id);

      // Captura o valor de login_app da query string
    $login_app = isset($_GET['login_app']) ? sanitize_text_field($_GET['login_app']) : 'hub';
      $redirect_url = 'https://redatudo.online/minha-conta?login_app=' . urlencode($login_app);

      wp_redirect($redirect_url);
      exit;
  }
});

/**
 * ========================================
 * REBRANDING 2.0 - ENQUEUE DE ASSETS
 * ========================================
 */

function redatudo_enqueue_rebranding_assets() {
    // Sistema de Design Global - Redatudo 2.0
    wp_enqueue_style(
        'redatudo-global',
        get_template_directory_uri() . '/assets/css/redatudo-global.css',
        array(),
        '2.0.1'
    );
    
    // CSS Variables do sistema de design
    wp_enqueue_style(
        'redatudo-variables',
        get_template_directory_uri() . '/assets/css/variables.css',
        array('redatudo-global'),
        '2.0.0'
    );
    
    // Google Fonts - Outfit e Inter (já incluído no global, mas mantendo por compatibilidade)
    wp_enqueue_style(
        'redatudo-fonts',
        'https://fonts.googleapis.com/css2?family=Outfit:wght@600;700;800&family=Inter:wght@400;500;600&display=swap',
        array(),
        null
    );
    
    // Componentes de UI
    wp_enqueue_style(
        'redatudo-components',
        get_template_directory_uri() . '/assets/css/components.css',
        array('redatudo-global', 'redatudo-variables'),
        '2.0.0'
    );
    
    // WooCommerce Styles - Apenas em páginas WooCommerce
    if (class_exists('WooCommerce')) {
        wp_enqueue_style(
            'redatudo-woocommerce',
            get_template_directory_uri() . '/assets/css/woocommerce-redatudo.css',
            array('redatudo-global'),
            '2.0.1'
        );
    }
    
    // JavaScript para interações
    wp_enqueue_script(
        'redatudo-interactions',
        get_template_directory_uri() . '/assets/js/interactions.js',
        array('jquery'),
        '2.0.0',
        true
    );
    
    // Localizar script para AJAX se necessário
    wp_localize_script('redatudo-interactions', 'redatudoData', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('redatudo_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'redatudo_enqueue_rebranding_assets', 20);

/**
 * ========================================
 * SHORTCODES DO REBRANDING 2.0
 * ========================================
 */

/**
 * Shortcode: Social Proof Toast
 * Uso: [social_proof]
 */
function redatudo_social_proof_shortcode($atts) {
    $atts = shortcode_atts(array(
        'interval' => '8000', // Intervalo entre mensagens em ms
    ), $atts);
    
    ob_start();
    ?>
    <div class="social-proof-toast" id="social-proof-container"></div>
    <script>
    (function() {
        const messages = [
            { user: "João M.", action: "gerou 12 títulos", time: "3s" },
            { user: "Maria S.", action: "humanizou 850 palavras", time: "12s" },
            { user: "Carlos P.", action: "criou descrição para loja", time: "28s" },
            { user: "Ana R.", action: "gerou 5 temas para TCC", time: "45s" },
            { user: "Pedro L.", action: "reformulou introdução", time: "1m" },
            { user: "Julia F.", action: "criou 3 posts para Instagram", time: "2m" },
            { user: "Roberto K.", action: "gerou 30 hashtags", time: "3m" },
            { user: "Camila B.", action: "criou nome para livro", time: "4m" }
        ];
        
        function showProof() {
            const toast = document.getElementById('social-proof-container');
            if (!toast) return;
            
            const msg = messages[Math.floor(Math.random() * messages.length)];
            const initials = msg.user.substring(0, 2).toUpperCase();
            
            toast.innerHTML = `
                <div class="avatar">${initials}</div>
                <div class="content">
                    <strong>${msg.user}</strong> ${msg.action}
                    <span class="time">há ${msg.time}</span>
                </div>
            `;
            
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 5000);
        }
        
        setInterval(showProof, <?php echo intval($atts['interval']); ?>);
        setTimeout(showProof, 2000); // Primeira aparição
    })();
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('social_proof', 'redatudo_social_proof_shortcode');

/**
 * Shortcode: Countdown Timer Renovável
 * Uso: [countdown_timer message="Promoção termina em:"]
 */
function redatudo_countdown_timer_shortcode($atts) {
    $atts = shortcode_atts(array(
        'message' => 'Promoção termina em:',
        'renew' => 'daily', // daily, weekly, monthly
    ), $atts);
    
    $unique_id = 'countdown-' . uniqid();
    
    ob_start();
    ?>
    <div class="countdown-timer" id="<?php echo esc_attr($unique_id); ?>">
        <span class="countdown-message"><?php echo esc_html($atts['message']); ?></span>
        <div class="countdown-display">
            <span><strong class="hours">23</strong>h</span>
            <span><strong class="minutes">59</strong>m</span>
            <span><strong class="seconds">59</strong>s</span>
        </div>
    </div>
    <script>
    (function() {
        const container = document.getElementById('<?php echo esc_js($unique_id); ?>');
        if (!container) return;
        
        function updateCountdown() {
            const now = new Date();
            const end = new Date();
            end.setHours(23, 59, 59, 999);
            
            const diff = end - now;
            if (diff < 0) return;
            
            const hours = Math.floor(diff / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);
            
            container.querySelector('.hours').textContent = hours;
            container.querySelector('.minutes').textContent = minutes;
            container.querySelector('.seconds').textContent = seconds;
        }
        
        updateCountdown();
        setInterval(updateCountdown, 1000);
    })();
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('countdown_timer', 'redatudo_countdown_timer_shortcode');

/**
 * Shortcode: Stats Display
 * Uso: [stats_display users="287.432" rating="4.9" active="12.4k"]
 */
function redatudo_stats_display_shortcode($atts) {
    $atts = shortcode_atts(array(
        'users' => '287.432',
        'rating' => '4.9',
        'active' => '12.4k',
    ), $atts);
    
    ob_start();
    ?>
    <div class="hero-stats">
        <div class="stat">
            <strong><?php echo esc_html($atts['users']); ?></strong>
            <span>conteúdos criados</span>
        </div>
        <div class="stat">
            <strong><?php echo esc_html($atts['rating']); ?>★</strong>
            <span>avaliação média</span>
        </div>
        <div class="stat">
            <strong><?php echo esc_html($atts['active']); ?></strong>
            <span>criadores ativos</span>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('stats_display', 'redatudo_stats_display_shortcode');

/**
 * Shortcode: Tool Card
 * Uso: [tool_card name="Gerador de Títulos" description="..." icon="💡" color="#8B5CF6" badge="hot" url="/ferramenta"]
 */
function redatudo_tool_card_shortcode($atts) {
    $atts = shortcode_atts(array(
        'name' => '',
        'description' => '',
        'icon' => '✨',
        'color' => '#7C3AED',
        'badge' => '', // hot, new, trending
        'stats' => '12.4k gerações',
        'rating' => '4.9',
        'url' => '#',
    ), $atts);
    
    if (empty($atts['name'])) return '';
    
    $badge_html = '';
    if ($atts['badge']) {
        $badge_class = 'badge-' . $atts['badge'];
        $badge_text = '';
        switch($atts['badge']) {
            case 'hot':
                $badge_text = '🔥 Mais usado';
                break;
            case 'new':
                $badge_text = '✨ Novo';
                break;
            case 'trending':
                $badge_text = '📈 Em alta';
                break;
        }
        $badge_html = '<span class="badge ' . esc_attr($badge_class) . '">' . $badge_text . '</span>';
    }
    
    ob_start();
    ?>
    <a href="<?php echo esc_url($atts['url']); ?>" class="tool-card" style="--tool-color: <?php echo esc_attr($atts['color']); ?>;">
        <?php echo $badge_html; ?>
        <div class="tool-icon"><?php echo esc_html($atts['icon']); ?></div>
        <h3><?php echo esc_html($atts['name']); ?></h3>
        <p><?php echo esc_html($atts['description']); ?></p>
        <div class="tool-stats">
            <span><?php echo esc_html($atts['stats']); ?></span>
            <span>⭐ <?php echo esc_html($atts['rating']); ?></span>
        </div>
        <button class="btn-tool">Experimentar grátis →</button>
    </a>
    <?php
    return ob_get_clean();
}
add_shortcode('tool_card', 'redatudo_tool_card_shortcode');

/**
 * Shortcode: Tools Grid Container
 * Uso: [tools_grid][tool_card ...][tool_card ...][/tools_grid]
 */
function redatudo_tools_grid_shortcode($atts, $content = null) {
    if (empty($content)) return '';
    
    return '<div class="tools-grid">' . do_shortcode($content) . '</div>';
}
add_shortcode('tools_grid', 'redatudo_tools_grid_shortcode');


// === Altera o background dos boxes de métodos de pagamento ===
add_action( 'wp_footer', function() {
    if ( is_checkout() ) : ?>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
          // Função que muda o background dos boxes de pagamento
          function atualizarBackgroundPagamento() {
            const boxes = document.querySelectorAll(
              '#add_payment_method #payment div.payment_box, .woocommerce-cart #payment div.payment_box, .woocommerce-checkout #payment div.payment_box'
            );

            boxes.forEach(box => {
              box.style.backgroundColor = 'black';
              box.style.color = 'white'; // opcional, melhora contraste do texto
              box.style.transition = 'background-color 0.5s ease';
            });
          }

          // Executa 2 segundos após o carregamento inicial
          setTimeout(atualizarBackgroundPagamento, 2000);

          // Observa mudanças no checkout (ex: troca de método)
          const checkoutContainer = document.querySelector('form.checkout, #payment');
          if (checkoutContainer) {
            const observer = new MutationObserver(() => {
              setTimeout(atualizarBackgroundPagamento, 2000);
            });
            observer.observe(checkoutContainer, { childList: true, subtree: true });
          }
        });
        </script>
    <?php
    endif;
});

/**
 * ========================================
 * HOOKS E FILTROS EXISTENTES
 * ========================================
 */

add_filter('woocommerce_form_field_args', 'wc_form_field_args',10,3);
add_filter( 'widget_text', 'do_shortcode' );
add_shortcode( 'recentes', 'post_recente' );
add_shortcode( 'list_categories', 'rd_categories' );
add_shortcode( 'product_reviews', 'rd_reviews_products' );
add_shortcode('woo_rd', 'woo_rd_template');
add_shortcode( 'nuvem_tags', 'nuvemTagsShortcode');
add_action('after_setup_theme', 'bs_after_setup_theme');

/**
 * ========================================
 * SOLUÇÃO: CHECKOUT DIRETO COM ?add_to_cart
 * ========================================
 * 
 * Processa o parâmetro ?add_to_cart=xxx no checkout.
 * Usuários vindos de apps externos (chat.redatudo.online, zap-agent.redatudo.online)
 * são direcionados DIRETAMENTE para /checkout/?add_to_cart=xxx
 * sem passar por páginas de produto ou carrinho.
 * 
 * CASOS TRATADOS:
 * 1. Usuário já tem ESTA assinatura específica ativa → redireciona para minha conta
 * 2. Carrinho tem outros produtos → limpa antes de adicionar subscription
 * 3. Produto já no carrinho → prossegue normalmente
 */
// add_action( 'wp', 'redatudo_checkout_add_to_cart_handler', 0 );
function redatudo_checkout_add_to_cart_handler() {
    // Só processa se estiver na página de checkout E tiver o parâmetro add_to_cart
    if ( ! is_checkout() || ! isset( $_GET['add_to_cart'] ) ) {
        return;
    }
    
    $product_id = absint( $_GET['add_to_cart'] );
    $product = wc_get_product( $product_id );
    
    // Valida se o produto existe
    if ( ! $product_id || ! $product ) {
        return;
    }
    
    // Verifica se é subscription
    $is_subscription = function_exists( 'wcs_is_subscription' ) && wcs_is_subscription( $product );
    
    // CASO 1: Se o usuário JÁ TEM ESTA assinatura específica ativa, redireciona para minha conta
    if ( $is_subscription && is_user_logged_in() ) {
        $product_to_check = $product->is_type( 'variation' ) ? $product->get_parent_id() : $product_id;
        if ( redatudo_user_has_subscription_for_product( $product_to_check ) || redatudo_user_has_subscription_for_product( $product_id ) ) {
            wc_add_notice( 'Você já possui esta assinatura ativa. Gerencie sua assinatura em Minha Conta.', 'notice' );
            $redirect_url = $product->is_type( 'variation' )
                ? get_permalink( $product->get_parent_id() )
                : get_permalink( $product->get_id() );
            wp_redirect( $redirect_url );
            exit;
        }
    }
    
    // CASO 2: Se for subscription e o carrinho NÃO está vazio, limpa antes (subscriptions não podem ter outros produtos)
    if ( $is_subscription && ! WC()->cart->is_empty() ) {
        WC()->cart->empty_cart();
    }
    
    // Verifica se o produto específico já está no carrinho
    $cart_item_key = WC()->cart->find_product_in_cart( WC()->cart->generate_cart_id( $product_id ) );
    
    if ( $cart_item_key ) {
        // Produto já está no carrinho, redireciona sem parâmetros
        $checkout_url = remove_query_arg( array( 'add_to_cart', 'quantity' ), wc_get_checkout_url() );
        wp_safe_redirect( $checkout_url );
        exit;
    }
    
    // Adiciona o produto ao carrinho
    $quantity = isset( $_GET['quantity'] ) ? absint( $_GET['quantity'] ) : 1;
    $added = WC()->cart->add_to_cart( $product_id, $quantity );
    
    if ( $added ) {
        // Remove o parâmetro da URL para evitar re-adição ao recarregar
        $checkout_url = remove_query_arg( array( 'add_to_cart', 'quantity' ), wc_get_checkout_url() );
        wp_safe_redirect( $checkout_url );
        exit;
    } else {
        // Se falhou ao adicionar (por alguma validação do WooCommerce), redireciona para conta
        wc_add_notice( 'Não foi possível adicionar este produto ao carrinho. Verifique sua conta.', 'error' );
        wp_redirect( wc_get_page_permalink( 'myaccount' ) );
        exit;
    }
}

/**
 * TESTE ULTIMO: Sempre redirecionar logados para página do produto PAI
 * Com parâmetro de query para mostrar modal de planos
 */
//add_action( 'wp', 'redatudo_last_test_redirect_logged_users', 1 );
function redatudo_last_test_redirect_logged_users() {
    if ( ! is_checkout() || ! isset( $_GET['add_to_cart'] ) ) {
        return;
    }

    if ( ! is_user_logged_in() ) {
        return; // Só testar se logado
    }

    $product_id = absint( $_GET['add_to_cart'] );
    $product = wc_get_product( $product_id );

    // Se for variação, redirecionar para produto pai
    if ( $product && $product->is_type( 'variation' ) ) {
        $parent_url = get_permalink( $product->get_parent_id() );
        wp_redirect( $parent_url );
        exit;
    }

    wp_redirect( wc_get_page_permalink( 'myaccount' ) );
    exit;
}

/**
 * Permite subscriptions serem adicionadas ao carrinho mesmo com restrições
 */
add_filter( 'woocommerce_add_to_cart_validation', 'redatudo_force_subscription_add_to_cart', 999, 3 );
function redatudo_force_subscription_add_to_cart( $passed, $product_id, $quantity ) {
    $product = wc_get_product( $product_id );

    // Se for subscription e vier do parâmetro add_to_cart no checkout, força permissão
    if ( $product && function_exists( 'wcs_is_subscription' ) && wcs_is_subscription( $product ) ) {
        if ( is_checkout() && isset( $_GET['add_to_cart'] ) ) {
            return true;
        }
    }

    return $passed;
}

/**
 * Verifica se a variação no carrinho corresponde à assinatura ativa do usuário
 *
 * @param bool $debug Se true, exibe debug info (apenas para desenvolvimento)
 * @return array Retorna array com 'match' (bool), 'checkout_variation', 'active_variation', 'is_same'
 */
function redatudo_compare_checkout_subscription($debug = false) {
    // Padrão de retorno
    $result = array(
        'match' => false,
        'checkout_variation' => null,
        'active_variation' => null,
        'is_same' => false
    );

    // Só executa se logado
    if (!is_user_logged_in()) {
        return $result;
    }

    // PEGAR A VARIAÇÃO DO PRODUTO NO CARRINHO
    foreach (WC()->cart->get_cart() as $cart_item) {
        if (isset($cart_item['variation_id']) && $cart_item['variation_id'] > 0) {
            $result['checkout_variation'] = $cart_item['variation_id'];
            break; // Pega só a primeira variação encontrada
        }
    }

    // PEGAR ASSINATURA ATIVA DO USUÁRIO
    $active_sub_ids = wcs_get_users_subscriptions(get_current_user_id());
    foreach ($active_sub_ids as $sub) {
        if ($sub->has_status('active')) {
            foreach ($sub->get_items() as $item) {
                $result['active_variation'] = $item->get_variation_id();
                break; // Pega a primeira inscrição ativa encontrada
            }
        }
    }

    // COMPARAR ASSINATURA ATUAL vs CHECKOUT
    $result['is_same'] = (
        $result['checkout_variation'] &&
        $result['active_variation'] &&
        $result['checkout_variation'] == $result['active_variation']
    );

    $result['match'] = $result['is_same'];

    // DEBUG OPCIONAL (só se solicitado)
    if ($debug) {
        echo "<div style='background:#000;color:#00ffd0;padding:10px;border:1px solid #7f00ff;margin:10px 0;'>";
        echo "<strong>DEBUG - Redatudo Checkout Subscription Check:</strong><br>";
        echo "Variação no checkout: " . $result['checkout_variation'] . "<br>";
        echo "Variação da assinatura ativa: " . $result['active_variation'] . "<br>";
        echo "É a mesma? " . ($result['is_same'] ? 'Sim' : 'Não');
        echo "</div>";
    }

    return $result;
}

/**
 * Hook para interceptar adição ao carrinho de assinaturas já ativas
 */
add_filter('woocommerce_add_to_cart_validation', 'redatudo_prevent_duplicate_subscription_cart', 10, 3);
function redatudo_prevent_duplicate_subscription_cart($passed, $product_id, $quantity) {
    if (!is_user_logged_in()) {
        return $passed;
    }

    $product = wc_get_product($product_id);
    if (!$product || !function_exists('wcs_is_subscription') || !wcs_is_subscription($product)) {
        return $passed;
    }

    // PERMITIR TROCA se parâmetros de switch estiverem presentes
    if (isset($_GET['switch-subscription'])) {
        return $passed; // Permite adicionar
    }

    // Se estiver tentando adicionar uma variação, verificar se já tem assinatura ativa
    if ($product->is_type('variation')) {
        $parent_id = $product->get_parent_id();
        if (redatudo_user_has_subscription_for_product($parent_id) || redatudo_user_has_subscription_for_product($product_id)) {
            // Não mostra notificação - redirecionamento implícito
            return false;
        }
    }

    return $passed;
}

/**
 * Hook para redirecionar usuários do checkout quando tentam acessar com assinatura já ativa
 */
add_action('woocommerce_before_checkout_form', 'redatudo_checkout_subscription_redirect', 1);
function redatudo_checkout_subscription_redirect() {
    if (!is_user_logged_in()) {
        return;
    }

    $subscription_check = redatudo_compare_checkout_subscription(false);

    if ($subscription_check['match']) {
        // Tentar encontrar o produto para redirecionar
        $product_id = null;
        foreach (WC()->cart->get_cart() as $cart_item) {
            if (isset($cart_item['variation_id']) && $cart_item['variation_id'] > 0) {
                $product_id = $cart_item['variation_id'];
                break;
            } elseif (isset($cart_item['product_id'])) {
                $product_id = $cart_item['product_id'];
                break;
            }
        }

        if ($product_id) {
            $product = wc_get_product($product_id);
            if ($product && $product->is_type('variation')) {
                $redirect_url = get_permalink($product->get_parent_id());
            } else {
                $redirect_url = get_permalink($product_id);
            }

            if ($redirect_url) {
                wp_redirect($redirect_url);
                exit;
            }
        }

        // Fallback para minha conta
        wp_redirect(wc_get_page_permalink('myaccount'));
        exit;
    }
}

/**
 * Redireciona página de carrinho vazio diretamente para minha conta
 * Evita que usuários vejam a "página de carrinho feia e vazia"
 */
add_action( 'template_redirect', 'redatudo_redirect_empty_cart', 10 );
function redatudo_redirect_empty_cart() {
    if ( is_cart() && WC()->cart->is_empty() && ! isset( $_GET['emptied'] ) ) {
        wp_redirect( wc_get_page_permalink( 'myaccount' ) );
        exit;
    }
}


// Força o total inicial a ser igual ao total recorrente
add_action('woocommerce_cart_calculate_fees', function($cart) {
    if (is_admin() && !defined('DOING_AJAX')) return;
    
    foreach ($cart->get_cart() as $cart_item) {
        if (isset($cart_item['subscription_switch'])) {
            // Adiciona uma taxa com o valor recorrente
            if (!empty($cart->recurring_carts)) {
                foreach ($cart->recurring_carts as $recurring_cart) {
                    $recurring_total = $recurring_cart->get_subtotal();
                    if ($recurring_total > 0 && $cart->get_subtotal() == 0) {
                        $cart->add_fee('Pagamento do novo plano', $recurring_total);
                    }
                }
            }
        }
    }
}, 100);

// =============================================
// TRACKING: endpoint + Mautic proxy
// =============================================
require_once get_template_directory() . '/redatudo-tracking-endpoint.php';

// user_register → Mautic direto (PHP server-side, sem CORS)
add_action('user_register', function($user_id) {
    $user = get_userdata($user_id);
    if (!$user) return;
    $contact = rdtd_mautic_get_or_create($user->user_email, $user->display_name);
    if ($contact) {
        rdtd_mautic_add_tags((int) $contact['id'], ['rdtd_new_user', 'rdtd_app_wordpress', 'rdtd_event_user_registered']);
    }
}, 10, 1);

// =============================================
// TRACKING: GA4 user_id for logged-in users
// =============================================
add_action('wp_head', function() {
    if (is_user_logged_in()) {
        $user_id = get_current_user_id();
        echo '<script>if(typeof gtag!=="undefined"){gtag("set",{"user_id":' . intval($user_id) . '});}window._rdtd_uid=' . intval($user_id) . ';</script>' . "\n";
    }
}, 100);
