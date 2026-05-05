<?php
/**
 * RedaTudo - Script de limpeza de tags e categorias WordPress
 *
 * Uso via WP-CLI (no diretório raiz do WordPress):
 *   wp eval-file wp-content/themes/redatudo-template-v2/cleanup-terms.php
 *     → modo simulação (mostra o que seria feito, não altera nada)
 *
 *   wp eval-file wp-content/themes/redatudo-template-v2/cleanup-terms.php -- --apply
 *     → execução real (apaga termos, reassiina posts, registra redirects)
 *
 * O que faz:
 *   1. Mantém APENAS as tags e categorias da lista aprovada abaixo
 *   2. Reatribui posts de termos excluídos ao termo aprovado semanticamente mais próximo
 *   3. Registra redirecionamentos 301 via plugin Redirection (se instalado)
 *   4. Exporta regras .htaccess para termos sem Redirection plugin
 *   5. Exclui os termos obsoletos
 *   6. Exibe relatório completo
 */

// ─── CONFIGURAÇÃO ─────────────────────────────────────────────────────────────

// Apenas estas categorias serão mantidas (nomes exatos do WP)
$approved_categories = [
    'Tecnologia & IA',
    'Marketing Digital & SEO',
    'Redes Sociais',
    'Negócios & Startups',
    'Tendências de Conteúdo',
    'Ciência & Inovação',
    'Economia Criativa',
    'Segurança & Privacidade',
];

// Apenas estas tags serão mantidas (nomes exatos do WP)
$approved_tags = [
    'Google', 'Instagram', 'TikTok', 'ChatGPT', 'OpenAI', 'Midjourney',
    'SEO', 'Algoritmo', 'IA Generativa', 'Automação', 'Vídeos',
    'Copywriting', 'Notícia', 'Análise', 'Tutorial', 'Case de Sucesso',
    'Lista', 'Startups', 'Criadores de Conteúdo', 'Marketing', 'Programação',
];

// Palavras-chave no nome do termo → tag aprovada de destino (para reatribuição de posts)
$tag_keyword_map = [
    'instagram'    => 'Instagram',
    'tiktok'       => 'TikTok',
    'reels'        => 'Vídeos',
    'shorts'       => 'Vídeos',
    'youtube'      => 'Vídeos',
    'vídeo'        => 'Vídeos',
    'video'        => 'Vídeos',
    'google'       => 'Google',
    'chatgpt'      => 'ChatGPT',
    'openai'       => 'OpenAI',
    'gpt'          => 'ChatGPT',
    'midjourney'   => 'Midjourney',
    'dall-e'       => 'Midjourney',
    'stable diff'  => 'Midjourney',
    'seo'          => 'SEO',
    'algoritmo'    => 'Algoritmo',
    'inteligência' => 'IA Generativa',
    ' ia '         => 'IA Generativa',
    'ia '          => 'IA Generativa',
    ' ia'          => 'IA Generativa',
    'automação'    => 'Automação',
    'automac'      => 'Automação',
    'n8n'          => 'Automação',
    'zapier'       => 'Automação',
    'copy'         => 'Copywriting',
    'escrita'      => 'Copywriting',
    'redação'      => 'Copywriting',
    'notícia'      => 'Notícia',
    'noticia'      => 'Notícia',
    'análise'      => 'Análise',
    'analise'      => 'Análise',
    'tutorial'     => 'Tutorial',
    'como '        => 'Tutorial',
    'guia'         => 'Tutorial',
    'passo'        => 'Tutorial',
    'startup'      => 'Startups',
    'empreend'     => 'Startups',
    'negócio'      => 'Startups',
    'marketing'    => 'Marketing',
    'tráfego'      => 'Marketing',
    'trafego'      => 'Marketing',
    'ads'          => 'Marketing',
    'programação'  => 'Programação',
    'código'       => 'Programação',
    'python'       => 'Programação',
    'javascript'   => 'Programação',
    'criador'      => 'Criadores de Conteúdo',
    'creator'      => 'Criadores de Conteúdo',
    'influenc'     => 'Criadores de Conteúdo',
    'lista'        => 'Lista',
    'ranking'      => 'Lista',
    'melhores'     => 'Lista',
    'case'         => 'Case de Sucesso',
    'sucesso'      => 'Case de Sucesso',
];

// Palavras-chave no nome da categoria → categoria aprovada de destino
$cat_keyword_map = [
    'tecnologia'   => 'Tecnologia & IA',
    'tech'         => 'Tecnologia & IA',
    'inteligência' => 'Tecnologia & IA',
    ' ia'          => 'Tecnologia & IA',
    'ia '          => 'Tecnologia & IA',
    'marketing'    => 'Marketing Digital & SEO',
    'seo'          => 'Marketing Digital & SEO',
    'digital'      => 'Marketing Digital & SEO',
    'social'       => 'Redes Sociais',
    'redes'        => 'Redes Sociais',
    'instagram'    => 'Redes Sociais',
    'tiktok'       => 'Redes Sociais',
    'negócio'      => 'Negócios & Startups',
    'negocio'      => 'Negócios & Startups',
    'startup'      => 'Negócios & Startups',
    'empreend'     => 'Negócios & Startups',
    'ciência'      => 'Ciência & Inovação',
    'inovação'     => 'Ciência & Inovação',
    'economia'     => 'Economia Criativa',
    'criativa'     => 'Economia Criativa',
    'segurança'    => 'Segurança & Privacidade',
    'privacidade'  => 'Segurança & Privacidade',
    'tendência'    => 'Tendências de Conteúdo',
    'conteúdo'     => 'Tendências de Conteúdo',
    'conteudo'     => 'Tendências de Conteúdo',
    'blog'         => 'Tendências de Conteúdo',
    'uncategorized' => 'Tecnologia & IA',
    'sem categoria' => 'Tecnologia & IA',
    'geral'        => 'Tecnologia & IA',
];

// URL base para fallback de redirects
$fallback_redirect = '/blog/';

// ─── INICIALIZAÇÃO ────────────────────────────────────────────────────────────

$dry_run = ! in_array( '--apply', $args ?? [] );
$htaccess_rules = [];
$stats = [
    'cats_kept'     => 0,
    'cats_deleted'  => 0,
    'tags_kept'     => 0,
    'tags_deleted'  => 0,
    'posts_moved'   => 0,
    'redirects'     => 0,
];

$mode = $dry_run ? '🔍 SIMULAÇÃO (dry-run)' : '⚡ EXECUÇÃO REAL';
WP_CLI::line( '' );
WP_CLI::line( "═══════════════════════════════════════════════════════" );
WP_CLI::line( "  RedaTudo — Limpeza de Termos  |  {$mode}" );
WP_CLI::line( "═══════════════════════════════════════════════════════" );
if ( $dry_run ) {
    WP_CLI::line( '  Para aplicar, rode com: -- --apply' );
    WP_CLI::line( '' );
}

// ─── FUNÇÕES AUXILIARES ───────────────────────────────────────────────────────

/**
 * Encontra o termo aprovado mais próximo usando mapa de palavras-chave.
 */
function rdtd_find_best_match( $term_name, array $keyword_map, array $approved_names ) : ?string {
    $lower = mb_strtolower( $term_name );
    foreach ( $keyword_map as $keyword => $target ) {
        if ( str_contains( $lower, $keyword ) ) {
            return $target;
        }
    }
    return null;
}

/**
 * Registra redirect 301 via plugin Redirection, se disponível.
 * Caso contrário, acumula regra .htaccess.
 */
function rdtd_add_redirect( string $from, string $to, bool $dry_run, array &$htaccess_rules, array &$stats ) : void {
    if ( $dry_run ) {
        WP_CLI::line( "    ↳ [redirect] {$from} → {$to}" );
        $stats['redirects']++;
        return;
    }

    // Tenta via plugin Redirection
    if ( class_exists( 'Red_Item' ) ) {
        \Red_Item::create( [
            'url'        => $from,
            'action_data' => [ 'url' => $to ],
            'action_type' => 'url',
            'action_code' => 301,
            'match_type'  => 'url',
            'status'      => 'enabled',
            'group_id'    => 1,
        ] );
        $stats['redirects']++;
    } else {
        // Acumula para .htaccess
        $from_escaped = preg_quote( $from, '/' );
        $htaccess_rules[] = "Redirect 301 {$from} {$to}";
        $stats['redirects']++;
    }
}

// ─── CATEGORIAS ───────────────────────────────────────────────────────────────

WP_CLI::line( '' );
WP_CLI::line( '┌─ CATEGORIAS ──────────────────────────────────────────' );

$approved_cats_lower = array_map( 'mb_strtolower', $approved_categories );

// Garante que as categorias aprovadas existem (cria se necessário)
$approved_cat_ids = [];
foreach ( $approved_categories as $cat_name ) {
    $existing = get_term_by( 'name', $cat_name, 'category' );
    if ( $existing ) {
        $approved_cat_ids[ $cat_name ] = $existing->term_id;
    } elseif ( ! $dry_run ) {
        $new = wp_insert_term( $cat_name, 'category' );
        if ( ! is_wp_error( $new ) ) {
            $approved_cat_ids[ $cat_name ] = $new['term_id'];
            WP_CLI::line( "  ✚ Criada categoria: {$cat_name}" );
        }
    } else {
        $approved_cat_ids[ $cat_name ] = 0; // placeholder para dry-run
    }
}

// Obtém todas as categorias existentes
$all_cats = get_terms( [
    'taxonomy'   => 'category',
    'hide_empty' => false,
    'number'     => 0,
] );

$cats_to_delete = [];
foreach ( $all_cats as $cat ) {
    if ( in_array( mb_strtolower( $cat->name ), $approved_cats_lower, true ) ) {
        WP_CLI::line( "  ✓ Mantida: {$cat->name} ({$cat->count} posts)" );
        $stats['cats_kept']++;
        continue;
    }

    $best_match = rdtd_find_best_match( $cat->name, $cat_keyword_map, $approved_categories );
    $target_name = $best_match ?? 'Tecnologia & IA'; // fallback
    $target_slug = get_term_by( 'name', $target_name, 'category' ) ?
        get_term_by( 'name', $target_name, 'category' )->slug : 'tecnologia-ia';

    $from_url  = '/category/' . $cat->slug . '/';
    $to_url    = '/category/' . $target_slug . '/';

    WP_CLI::line( "  ✗ Excluir: \"{$cat->name}\" ({$cat->count} posts) → reassinar para \"{$target_name}\"" );
    rdtd_add_redirect( $from_url, $to_url, $dry_run, $htaccess_rules, $stats );
    $cats_to_delete[] = [ 'term' => $cat, 'target' => $target_name ];
    $stats['cats_deleted']++;
}

// Executa reatribuição e deleção de categorias
if ( ! $dry_run ) {
    foreach ( $cats_to_delete as $item ) {
        $cat        = $item['term'];
        $target_id  = $approved_cat_ids[ $item['target'] ] ?? null;

        if ( $cat->count > 0 && $target_id ) {
            $posts = get_posts( [
                'post_type'      => 'post',
                'posts_per_page' => -1,
                'tax_query'      => [ [ 'taxonomy' => 'category', 'terms' => $cat->term_id ] ],
                'fields'         => 'ids',
            ] );
            foreach ( $posts as $post_id ) {
                wp_set_post_terms( $post_id, [ $target_id ], 'category', true );
                $stats['posts_moved']++;
            }
        }

        wp_delete_term( $cat->term_id, 'category' );
    }
}

// ─── TAGS ─────────────────────────────────────────────────────────────────────

WP_CLI::line( '' );
WP_CLI::line( '┌─ TAGS ────────────────────────────────────────────────' );

$approved_tags_lower = array_map( 'mb_strtolower', $approved_tags );

// Garante que as tags aprovadas existem
$approved_tag_ids = [];
foreach ( $approved_tags as $tag_name ) {
    $existing = get_term_by( 'name', $tag_name, 'post_tag' );
    if ( $existing ) {
        $approved_tag_ids[ $tag_name ] = $existing->term_id;
    } elseif ( ! $dry_run ) {
        $new = wp_insert_term( $tag_name, 'post_tag' );
        if ( ! is_wp_error( $new ) ) {
            $approved_tag_ids[ $tag_name ] = $new['term_id'];
            WP_CLI::line( "  ✚ Criada tag: {$tag_name}" );
        }
    } else {
        $approved_tag_ids[ $tag_name ] = 0;
    }
}

// Obtém todas as tags em lotes de 500 (performance com 4K+ tags)
$offset     = 0;
$batch_size = 500;
$tags_to_delete = [];

do {
    $batch = get_terms( [
        'taxonomy'   => 'post_tag',
        'hide_empty' => false,
        'number'     => $batch_size,
        'offset'     => $offset,
        'orderby'    => 'id',
    ] );

    if ( is_wp_error( $batch ) || empty( $batch ) ) break;

    foreach ( $batch as $tag ) {
        if ( in_array( mb_strtolower( $tag->name ), $approved_tags_lower, true ) ) {
            $stats['tags_kept']++;
            continue;
        }

        $best_match = rdtd_find_best_match( $tag->name, $tag_keyword_map, $approved_tags );

        // Só cria redirect de URL se a tag tinha posts (SEO relevante)
        if ( $tag->count > 0 ) {
            if ( $best_match ) {
                $target_tag     = get_term_by( 'name', $best_match, 'post_tag' );
                $target_slug    = $target_tag ? $target_tag->slug : sanitize_title( $best_match );
                $to_url         = '/tag/' . $target_slug . '/';
            } else {
                $to_url = $fallback_redirect;
            }
            rdtd_add_redirect( '/tag/' . $tag->slug . '/', $to_url, $dry_run, $htaccess_rules, $stats );
        }

        $tags_to_delete[] = [ 'term' => $tag, 'target' => $best_match ];
        $stats['tags_deleted']++;
    }

    $offset += $batch_size;

} while ( count( $batch ) === $batch_size );

WP_CLI::line( "  Total de tags a excluir: {$stats['tags_deleted']} (batches de {$batch_size})" );

// Executa reatribuição e deleção de tags (em lotes para não estourar memória)
if ( ! $dry_run ) {
    WP_CLI::line( '  Excluindo tags...' );
    $deleted = 0;
    foreach ( $tags_to_delete as $item ) {
        $tag       = $item['term'];
        $target    = $item['target'];
        $target_id = $target ? ( $approved_tag_ids[ $target ] ?? null ) : null;

        if ( $tag->count > 0 && $target_id ) {
            $posts = get_posts( [
                'post_type'      => 'post',
                'posts_per_page' => -1,
                'tax_query'      => [ [ 'taxonomy' => 'post_tag', 'terms' => $tag->term_id ] ],
                'fields'         => 'ids',
            ] );
            foreach ( $posts as $post_id ) {
                wp_set_post_terms( $post_id, [ $target_id ], 'post_tag', true );
                $stats['posts_moved']++;
            }
        }

        wp_delete_term( $tag->term_id, 'post_tag' );
        $deleted++;

        if ( $deleted % 100 === 0 ) {
            WP_CLI::line( "    ...{$deleted} tags excluídas" );
        }
    }
}

// ─── ARQUIVO .HTACCESS (fallback) ─────────────────────────────────────────────

if ( ! empty( $htaccess_rules ) ) {
    $htaccess_output  = "# RedaTudo - Redirects de termos excluídos (" . date('Y-m-d') . ")\n";
    $htaccess_output .= "# Adicione ao seu .htaccess ANTES da regra do WordPress\n";
    $htaccess_output .= implode( "\n", $htaccess_rules ) . "\n";

    if ( $dry_run ) {
        $export_path = __DIR__ . '/redirects-preview.htaccess';
    } else {
        $export_path = __DIR__ . '/redirects-new.htaccess';
    }

    file_put_contents( $export_path, $htaccess_output );
    WP_CLI::line( '' );
    WP_CLI::warning( "Plugin Redirection não detectado. Regras exportadas para:" );
    WP_CLI::line( "  {$export_path}" );
    WP_CLI::line( "  Copie o conteúdo para o .htaccess da raiz do WordPress," );
    WP_CLI::line( "  antes do bloco # BEGIN WordPress" );
}

// ─── RELATÓRIO FINAL ──────────────────────────────────────────────────────────

WP_CLI::line( '' );
WP_CLI::line( '═══════════════════════════════════════════════════════' );
WP_CLI::line( '  RELATÓRIO FINAL' );
WP_CLI::line( '═══════════════════════════════════════════════════════' );
WP_CLI::line( "  Categorias mantidas  : {$stats['cats_kept']}" );
WP_CLI::line( "  Categorias excluídas : {$stats['cats_deleted']}" );
WP_CLI::line( "  Tags mantidas        : {$stats['tags_kept']}" );
WP_CLI::line( "  Tags excluídas       : {$stats['tags_deleted']}" );
WP_CLI::line( "  Posts reatribuídos   : {$stats['posts_moved']}" );
WP_CLI::line( "  Redirects 301        : {$stats['redirects']}" );
WP_CLI::line( '' );

if ( $dry_run ) {
    WP_CLI::warning( 'SIMULAÇÃO concluída — nenhuma alteração foi feita.' );
    WP_CLI::line( 'Para aplicar: wp eval-file wp-content/themes/redatudo-template-v2/cleanup-terms.php -- --apply' );
} else {
    WP_CLI::success( 'Limpeza concluída.' );
    WP_CLI::line( 'Recomendado após execução:' );
    WP_CLI::line( '  1. wp cache flush' );
    WP_CLI::line( '  2. wp rewrite flush' );
    WP_CLI::line( '  3. Enviar novo sitemap no Google Search Console' );
}
WP_CLI::line( '═══════════════════════════════════════════════════════' );
