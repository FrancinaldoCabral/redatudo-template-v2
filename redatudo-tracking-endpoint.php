<?php
/**
 * Tracking endpoint — proxy entre apps/n8n e Mautic
 * URL: POST /wp-json/rdtd/v1/track
 *
 * Adicione no wp-config.php ANTES do "/* That's all, stop editing":
 *
 *   define('RDTD_MAUTIC_URL',         'https://conteudo.redatudo.online');
 *   define('RDTD_MAUTIC_USER',        'admin');
 *   define('RDTD_MAUTIC_PASS',        'sua-senha-do-mautic');
 *   define('RDTD_TRACK_SECRET',       'chave-aleatoria-longa-e-segura');
 *   define('RDTD_EVOLUTION_URL',      'https://SEU_EVOLUTION_URL');
 *   define('RDTD_EVOLUTION_INSTANCE', 'nome-da-instancia');
 *   define('RDTD_EVOLUTION_KEY',      'sua-evolution-apikey');
 */

defined('ABSPATH') || exit;

// =============================================
// REST ROUTE
// =============================================

add_action('rest_api_init', 'rdtd_register_tracking_routes');

function rdtd_register_tracking_routes() {
    register_rest_route('rdtd/v1', '/track', [
        'methods'             => WP_REST_Server::CREATABLE,
        'callback'            => 'rdtd_track_event_handler',
        'permission_callback' => 'rdtd_check_track_secret',
    ]);
}

function rdtd_check_track_secret(WP_REST_Request $request) {
    if (!defined('RDTD_TRACK_SECRET')) return false;
    $header = (string) $request->get_header('x-rdtd-secret');
    return hash_equals(RDTD_TRACK_SECRET, $header);
}

function rdtd_track_event_handler(WP_REST_Request $request) {
    $data = $request->get_json_params();
    if (empty($data) || empty($data['event'])) {
        return new WP_REST_Response(['ok' => false, 'error' => 'missing_event'], 400);
    }

    $event      = sanitize_text_field($data['event']);
    $email      = isset($data['email'])      ? sanitize_email($data['email'])             : '';
    $name       = isset($data['name'])       ? sanitize_text_field($data['name'])          : '';
    $source     = isset($data['source'])     ? sanitize_text_field($data['source'])        : 'unknown';
    $wp_user_id = isset($data['wp_user_id']) ? intval($data['wp_user_id'])                 : 0;
    $props      = isset($data['properties']) && is_array($data['properties']) ? $data['properties'] : [];

    // Resolve email via WordPress se só vier wp_user_id
    if (!$email && $wp_user_id > 0) {
        $wp_user = get_userdata($wp_user_id);
        if ($wp_user) {
            $email = $wp_user->user_email;
            if (!$name) $name = $wp_user->display_name;
        }
    }

    if (!$email) {
        return new WP_REST_Response(['ok' => false, 'error' => 'no_email'], 400);
    }

    // Monta tags (prefixo rdtd_ para não colidir com tags manuais)
    $tags = [
        'rdtd_app_' . $source,
        'rdtd_event_' . $event,
    ];

    switch ($event) {
        case 'user_registered':
            $tags[] = 'rdtd_new_user';
            break;
        case 'project_created':
            if (!empty($props['mode']))  $tags[] = 'rdtd_mode_'  . sanitize_text_field($props['mode']);
            if (!empty($props['genre'])) $tags[] = 'rdtd_genre_' . sanitize_text_field($props['genre']);
            break;
        case 'export_completed':
            if (!empty($props['format'])) $tags[] = 'rdtd_export_' . sanitize_text_field($props['format']);
            break;
        case 'credits_low':
        case 'limit_reached':
            $tags[] = 'rdtd_needs_upgrade';
            break;
        case 'upgrade_clicked':
            $tags[] = 'rdtd_upgrade_intent';
            break;
        case 'credits_purchased':
            // Remove flag de upgrade quando comprar
            $tags[] = 'rdtd_paid_user';
            break;
    }

    // Busca ou cria contato no Mautic (retorna array completo do contato)
    $contact = rdtd_mautic_get_or_create($email, $name);

    if (!$contact) {
        return new WP_REST_Response(['ok' => false, 'error' => 'mautic_error'], 500);
    }

    $contact_id = (int) $contact['id'];
    rdtd_mautic_add_tags($contact_id, $tags);

    // WhatsApp para eventos de alta urgência (só se tiver telefone no Mautic)
    if (in_array($event, ['credits_low', 'limit_reached', 'upgrade_clicked'], true)) {
        $phone     = $contact['fields']['core']['phone']['value']     ?? '';
        $firstname = $contact['fields']['core']['firstname']['value'] ?? 'você';
        $msg       = rdtd_build_wa_message($event, $firstname, $props);
        if ($phone && $msg) {
            rdtd_send_whatsapp($phone, $msg);
        }
    }

    return new WP_REST_Response([
        'ok'         => true,
        'contact_id' => $contact_id,
        'tags'       => $tags,
    ], 200);
}

// =============================================
// MAUTIC HELPERS
// =============================================

function rdtd_mautic_request($method, $path, $body = []) {
    if (!defined('RDTD_MAUTIC_URL') || !defined('RDTD_MAUTIC_USER') || !defined('RDTD_MAUTIC_PASS')) {
        return null;
    }

    $args = [
        'method'  => strtoupper($method),
        'headers' => [
            'Authorization' => 'Basic ' . base64_encode(RDTD_MAUTIC_USER . ':' . RDTD_MAUTIC_PASS),
            'Content-Type'  => 'application/json',
        ],
        'timeout'  => 10,
        'blocking' => true,
    ];

    if (!empty($body)) {
        $args['body'] = wp_json_encode($body);
    }

    $url      = rtrim(RDTD_MAUTIC_URL, '/') . $path;
    $response = wp_remote_request($url, $args);

    if (is_wp_error($response)) {
        return null;
    }

    $decoded = json_decode(wp_remote_retrieve_body($response), true);
    return is_array($decoded) ? $decoded : null;
}

/**
 * Busca contato por email ou cria novo.
 * Retorna o array do contato do Mautic (com 'id', 'fields', etc.) ou null.
 */
function rdtd_mautic_get_or_create($email, $name = '') {
    // Busca pelo email
    $res = rdtd_mautic_request('GET', '/api/contacts?search=' . urlencode('email:' . $email) . '&limit=1');
    if (!empty($res['contacts'])) {
        $contact = reset($res['contacts']);
        if (!empty($contact['id'])) {
            return $contact;
        }
    }

    // Cria novo contato
    $parts   = $name ? explode(' ', trim($name), 2) : [];
    $payload = array_filter([
        'email'     => $email,
        'firstname' => isset($parts[0]) ? $parts[0] : '',
        'lastname'  => isset($parts[1]) ? $parts[1] : '',
    ]);

    $created = rdtd_mautic_request('POST', '/api/contacts/new', $payload);
    return !empty($created['contact']['id']) ? $created['contact'] : null;
}

function rdtd_mautic_add_tags($contact_id, $tags) {
    if (empty($tags) || !$contact_id) return;
    rdtd_mautic_request('POST', '/api/contacts/' . intval($contact_id) . '/tags/add', ['tags' => array_values($tags)]);
}

// =============================================
// WHATSAPP HELPERS
// =============================================

function rdtd_build_wa_message($event, $firstname, $props) {
    $name = $firstname ? $firstname : 'você';

    if ($event === 'credits_low') {
        $balance = intval(isset($props['balance']) ? $props['balance'] : 0);
        return "Oi, {$name}! Seus créditos no EbookFlow estão acabando ({$balance} restantes). Recarregue agora: https://redatudo.online/planos";
    }

    if ($event === 'limit_reached') {
        return "Oi, {$name}! Você atingiu o limite do seu plano no EbookFlow. Faça upgrade para criar sem limites: https://redatudo.online/planos";
    }

    if ($event === 'upgrade_clicked') {
        return "Oi, {$name}! Vi que você está pensando em fazer upgrade no EbookFlow. Posso te ajudar a escolher o melhor plano: https://redatudo.online/planos";
    }

    return '';
}

function rdtd_send_whatsapp($phone, $message) {
    if (!defined('RDTD_EVOLUTION_URL') || !defined('RDTD_EVOLUTION_INSTANCE') || !defined('RDTD_EVOLUTION_KEY')) return;

    $url = rtrim(RDTD_EVOLUTION_URL, '/') . '/message/sendText/' . RDTD_EVOLUTION_INSTANCE;

    wp_remote_post($url, [
        'headers'  => [
            'apikey'       => RDTD_EVOLUTION_KEY,
            'Content-Type' => 'application/json',
        ],
        'body'     => wp_json_encode(['number' => $phone, 'text'   => $message]),
        'blocking' => false,
        'timeout'  => 2,
    ]);
}
