<?php
/**
 * Plugin Name: Redatudo Auth
 * Description: Custom authentication and redirection logic for Redatudo.
 * Version: 1.0
 * Author: Redatudo
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Check dependencies first
if ( ! class_exists( 'Firebase\JWT\JWT' ) || ! defined( 'JWT_AUTH_SECRET_KEY' ) ) {
    add_action( 'admin_notices', 'redatudo_auth_missing_dependencies_notice' );
    return; // Exit if JWT library or secret key is not available
}

// Add admin menu
add_action( 'admin_menu', 'redatudo_auth_admin_menu' );
add_action( 'admin_init', 'redatudo_auth_settings_init' );
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// Hook into WordPress init to handle token-based login
add_action( 'init', 'redatudo_handle_token_login' );

// Hook into user login for redirections
add_action( 'wp_login', 'redatudo_handle_login_redirections', 10, 2 );

// Hook into init for app login check
add_action( 'init', 'redatudo_check_app_login_on_init' );

// Hook into init for logout request handling
add_action( 'init', 'redatudo_handle_logout_request', 5 );

// Force WooCommerce login/register redirects to app when login_app is present
add_filter( 'woocommerce_login_redirect', 'redatudo_woocommerce_login_redirect', 10, 2 );
add_filter( 'woocommerce_registration_redirect', 'redatudo_woocommerce_registration_redirect', 10, 1 );

// Background action for legacy user structure check
add_action( 'redatudo_handle_legacy_structure_check', 'redatudo_do_legacy_structure_check' );

/**
 * Notice for missing dependencies
 */
function redatudo_auth_missing_dependencies_notice() {
    ?>
    <div class="notice notice-error">
        <p>Redatudo Auth: JWT Auth plugin is not active or JWT_AUTH_SECRET_KEY is not defined. Please activate the JWT Auth plugin.</p>
    </div>
    <?php
}

/**
 * Handle token-based login from GET parameter
 */
function redatudo_handle_token_login() {
    $options = get_option( 'redatudo_auth_options' );
    if ( isset( $options['disable_plugin'] ) && $options['disable_plugin'] == 1 ) {
        return; // Plugin disabled
    }

    if ( ! isset( $_GET['token'] ) || is_user_logged_in() ) {
        return;
    }

    $token = sanitize_text_field( $_GET['token'] );
    if ( empty( $token ) ) {
        return;
    }

    // Clear the token from URL
    redatudo_clear_token_url();

    // Validate and decode the token
    $decoded = redatudo_validate_jwt_token( $token );
    if ( ! $decoded ) {
        return;
    }

    // Set user as logged in
    $user = get_user_by( 'id', $decoded->data->user->id );
    if ( $user ) {
        wp_set_current_user( $user->ID, $user->user_login );
        wp_set_auth_cookie( $user->ID );
        do_action( 'wp_login', $user->user_login, $user );
    }
}

/**
 * Validate JWT token
 */
function redatudo_validate_jwt_token( $token ) {
    try {
        $decoded = JWT::decode( $token, new Key( JWT_AUTH_SECRET_KEY, 'HS256' ) );

        // Check expiration
        if ( isset( $decoded->exp ) && $decoded->exp < time() ) {
            return false;
        }

        // Check not before
        if ( isset( $decoded->nbf ) && $decoded->nbf > time() ) {
            return false;
        }

        // Check if token was revoked after logout
        $user = get_user_by( 'id', $decoded->data->user->id );
        if ( $user ) {
            $revoked_at = get_user_meta( $user->ID, 'redatudo_revoked_at', true );
            if ( $revoked_at && $decoded->iat < $revoked_at ) {
                return false; // Token was issued before logout
            }
        }

        return $decoded;
    } catch ( Exception $e ) {
        return false;
    }
}

/**
 * Clear token from URL using JavaScript
 */
function redatudo_clear_token_url() {
    ?>
    <script>
        if ( typeof window !== 'undefined' ) {
            var newURL = location.href.split( "?" )[0];
            window.history.pushState( "object", document.title, newURL );
        }
    </script>
    <?php
}

/**
 * Handle login redirections based on context
 */
function redatudo_handle_login_redirections( $user_login, $user ) {
    $options = get_option( 'redatudo_auth_options' );
    if ( isset( $options['disable_plugin'] ) && $options['disable_plugin'] == 1 ) {
        return; // Plugin disabled
    }

    // Schedule async background check for legacy user structure
    wp_schedule_single_event( time(), 'redatudo_handle_legacy_structure_check', [ $user->ID ] );

    // Check for social login activation
    redatudo_check_social_activation( $user );

    // Check for email verification
    redatudo_check_email_verification();

    // Check for app login
    redatudo_check_app_login();
}

/**
 * Fire async POST to n8n webhook to ensure legacy user has required structure.
 */
function redatudo_do_legacy_structure_check( $user_id ) {
    wp_remote_post(
        'https://n8n.redatudo.online/webhook/have-structure',
        [
            'headers'  => [ 'Content-Type' => 'application/json' ],
            'body'     => wp_json_encode( [ 'userId' => (string) $user_id ] ),
            'timeout'  => 5,
            'blocking' => false,
        ]
    );
}

/**
 * Check and handle social login activation
 */
function redatudo_check_social_activation( $user ) {
    $options = get_option( 'redatudo_auth_options' );
    if ( ! isset( $options['enable_social_redirect'] ) || $options['enable_social_redirect'] != 1 ) {
        return;
    }

    global $wpdb;
    $table = $wpdb->prefix . 'mo_openid_linked_user';
    $query = $wpdb->prepare( "SELECT * FROM {$table} WHERE user_id = %d", $user->ID );
    $results = $wpdb->get_results( $query );

    $is_activate = get_user_meta( $user->ID, 'alg_wc_ev_is_activated', true );

    if ( count( $results ) > 0 && $is_activate == 0 ) {
        update_user_meta( $user->ID, 'alg_wc_ev_is_activated', 1 );
        $redirect_url = isset( $options['social_redirect_url'] ) ? $options['social_redirect_url'] : 'https://chat.redatudo.online/';
        wp_redirect( $redirect_url . '?token=' . redatudo_generate_token() );
        exit;
    }
}

/**
 * Check and handle email verification
 */
function redatudo_check_email_verification() {
    $options = get_option( 'redatudo_auth_options' );
    if ( ! isset( $options['enable_email_redirect'] ) || $options['enable_email_redirect'] != 1 ) {
        return;
    }

    if ( ! empty( $_GET['alg_wc_ev_success_activation_message'] ) ) {
        $redirect_url = isset( $options['email_redirect_url'] ) ? $options['email_redirect_url'] : 'https://chat.redatudo.online/';
        wp_redirect( $redirect_url . '?token=' . redatudo_generate_token() );
        exit;
    }
}

/**
 * Get app URL mapping (same as functions.php)
 */
function redatudo_get_app_url_map() {
    $app_urls = [
        'ebook' => 'https://ebook.redatudo.online',
        'chat' => 'https://chat.redatudo.online',
        'hub' => 'https://hub.redatudo.online',
    ];
    return apply_filters( 'redatudo_app_urls', $app_urls );
}

/**
 * Resolve requested app from GET/POST/cookie
 */
function redatudo_get_requested_login_app() {
    if ( isset( $_GET['login_app'] ) ) {
        return sanitize_text_field( $_GET['login_app'] );
    }

    if ( isset( $_POST['login_app'] ) ) {
        return sanitize_text_field( $_POST['login_app'] );
    }

    if ( isset( $_COOKIE['redatudo_login_app'] ) ) {
        return sanitize_text_field( $_COOKIE['redatudo_login_app'] );
    }

    return null;
}

/**
 * Build app redirect URL with token
 */
function redatudo_build_app_redirect_url( $login_app ) {
    if ( ! $login_app || ! is_user_logged_in() ) {
        return null;
    }

    $url_map = redatudo_get_app_url_map();
    $app_url = isset( $url_map[ $login_app ] ) ? $url_map[ $login_app ] : $url_map['hub'];
    $token = redatudo_generate_token();

    if ( empty( $token ) ) {
        return null;
    }

    return $app_url . '?token=' . $token;
}

/**
 * WooCommerce login redirect filter
 */
function redatudo_woocommerce_login_redirect( $redirect, $user ) {
    if ( is_wp_error( $user ) ) {
        return $redirect;
    }

    $login_app = redatudo_get_requested_login_app();
    if ( ! $login_app ) {
        return $redirect;
    }

    $app_redirect = redatudo_build_app_redirect_url( $login_app );
    if ( ! $app_redirect ) {
        return $redirect;
    }

    setcookie( 'redatudo_login_app', '', time() - 3600, '/', '', is_ssl(), true );
    return $app_redirect;
}

/**
 * WooCommerce registration redirect filter
 */
function redatudo_woocommerce_registration_redirect( $redirect ) {
    $login_app = redatudo_get_requested_login_app();
    if ( ! $login_app ) {
        return $redirect;
    }

    $app_redirect = redatudo_build_app_redirect_url( $login_app );
    if ( ! $app_redirect ) {
        return add_query_arg( 'login_app', $login_app, $redirect );
    }

    setcookie( 'redatudo_login_app', '', time() - 3600, '/', '', is_ssl(), true );
    return $app_redirect;
}

/**
 * Check and handle app login on init
 */
function redatudo_check_app_login_on_init() {
    $options = get_option( 'redatudo_auth_options' );
    if ( isset( $options['disable_plugin'] ) && $options['disable_plugin'] == 1 ) {
        return; // Plugin disabled
    }

    $login_app = isset( $_GET['login_app'] ) ? sanitize_text_field( $_GET['login_app'] ) : null;
    if ( ! $login_app ) {
        return;
    }

    // Get app URLs
    $url_map = redatudo_get_app_url_map();
    
    // Use hub as fallback
    $app_url = isset( $url_map[ $login_app ] ) ? $url_map[ $login_app ] : $url_map['hub'];

    if ( is_user_logged_in() ) {
        // Usuário JÁ está logado: redireciona IMEDIATAMENTE
        $token = redatudo_generate_token();
        $redirect_url = $app_url . '?token=' . $token;
        wp_redirect( $redirect_url );
        exit;
    } else {
        // Usuário NÃO está logado: salva o destino e evita loop de redirecionamento
        setcookie( 'redatudo_login_app', $login_app, time() + 600, '/', '', is_ssl(), true );

        // URL da página de login/minha-conta
        $login_url = function_exists( 'wc_get_page_permalink' )
            ? wc_get_page_permalink( 'myaccount' )
            : get_permalink( get_option( 'woocommerce_myaccount_page_id' ) );

        // Se já está na página de conta, não redireciona novamente (evita ERR_TOO_MANY_REDIRECTS)
        $current_path = isset( $_SERVER['REQUEST_URI'] ) ? wp_parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ) : '';
        $login_path = wp_parse_url( $login_url, PHP_URL_PATH );
        if ( untrailingslashit( (string) $current_path ) === untrailingslashit( (string) $login_path ) ) {
            return;
        }

        // Se não está na conta, manda uma vez para a conta com login_app
        $redirect_url = add_query_arg( 'login_app', $login_app, $login_url );
        wp_redirect( $redirect_url );
        exit;
    }
}

/**
 * Check and handle app login (for after login)
 */
function redatudo_check_app_login() {
    if ( ! is_user_logged_in() ) {
        return;
    }

    // Tenta pegar login_app de GET, POST ou COOKIE
    $login_app = redatudo_get_requested_login_app();

    if ( ! $login_app ) {
        return;
    }

    $redirect_url = redatudo_build_app_redirect_url( $login_app );
    if ( ! $redirect_url ) {
        return;
    }

    // Limpa o cookie antes de redirecionar
    setcookie( 'redatudo_login_app', '', time() - 3600, '/', '', is_ssl(), true );

    wp_redirect( $redirect_url );
    exit;
}

/**
 * Parse app URLs from textarea
 */
function redatudo_parse_app_urls( $app_urls ) {
    $url_map = [];
    $lines = explode( "\n", $app_urls );
    foreach ( $lines as $line ) {
        $line = trim( $line );
        if ( strpos( $line, ':' ) !== false ) {
            list( $key, $url ) = explode( ':', $line, 2 );
            $url_map[ trim( $key ) ] = trim( $url );
        }
    }
    return $url_map;
}

/**
 * Generate JWT token
 */
function redatudo_generate_token() {
    $user = wp_get_current_user();
    if ( ! $user->ID ) {
        return '';
    }

    $secret_key = JWT_AUTH_SECRET_KEY;
    $algorithm = apply_filters( 'jwt_auth_algorithm', 'HS256' );
    $issued_at = time();
    $not_before = apply_filters( 'jwt_auth_not_before', $issued_at, $issued_at );
    $expire = apply_filters( 'jwt_auth_expire', $issued_at + ( DAY_IN_SECONDS * 7 ), $issued_at );

    $token = [
        'iss' => get_bloginfo( 'url' ),
        'iat' => $issued_at,
        'nbf' => $not_before,
        'exp' => $expire,
        'data' => [
            'user' => [
                'id' => $user->ID,
            ],
        ],
    ];

    return JWT::encode( apply_filters( 'jwt_auth_token_before_sign', $token, $user ), $secret_key, $algorithm );
}

/**
 * Check if user has active subscription
 */
function redatudo_has_active_subscription( $user_id = null ) {
    if ( $user_id === null && is_user_logged_in() ) {
        $user_id = get_current_user_id();
    }
    if ( ! $user_id ) {
        return false;
    }

    $subs = get_posts( [
        'numberposts' => 1,
        'meta_key' => '_customer_user',
        'meta_value' => $user_id,
        'post_type' => 'shop_subscription',
        'post_status' => 'wc-active',
        'fields' => 'ids',
    ] );

    return ! empty( $subs );
}

/**
 * Handle logout request from apps
 */
function redatudo_handle_logout_request() {
    // Check if logout is requested
    if ( ! isset( $_GET['do_logout'] ) ) {
        return;
    }

    // Only process if user is logged in
    if ( ! is_user_logged_in() ) {
        return;
    }

    // Mark all tokens as revoked for this user
    $user_id = get_current_user_id();
    update_user_meta( $user_id, 'redatudo_revoked_at', time() );

    // Perform the logout
    wp_logout();

    // Get login_app if provided (to preserve it in login page)
    $login_app = isset( $_GET['login_app'] ) ? sanitize_text_field( $_GET['login_app'] ) : null;

    // Redirect to login page (minha-conta)
    $login_url = function_exists( 'wc_get_page_permalink' )
        ? wc_get_page_permalink( 'myaccount' )
        : get_permalink( get_option( 'woocommerce_myaccount_page_id' ) );

    // Add login_app to URL if provided
    if ( $login_app ) {
        $login_url = add_query_arg( 'login_app', $login_app, $login_url );
    }

    wp_redirect( $login_url );
    exit;
}

// Remove the old functions from header.php and dashboard.php by commenting or deleting them
// For now, add hooks to integrate with existing code
add_action( 'wp_head', 'redatudo_add_token_script' );

function redatudo_add_token_script() {
    if ( is_user_logged_in() ) {
        ?>
        <script>
            // Function to generate token on client side if needed
            function getToken() {
                return '<?php echo esc_js( redatudo_generate_token() ); ?>';
            }
        </script>
        <?php
    }
}

/**
 * Add admin menu for Redatudo Auth settings
 */
function redatudo_auth_admin_menu() {
    add_options_page(
        'Redatudo Auth Settings',
        'Redatudo Auth',
        'manage_options',
        'redatudo-auth-settings',
        'redatudo_auth_settings_page'
    );
}

/**
 * Initialize settings
 */
function redatudo_auth_settings_init() {
    register_setting( 'redatudo_auth_group', 'redatudo_auth_options' );

    add_settings_section(
        'redatudo_auth_section',
        'Configurações de Redirecionamento',
        'redatudo_auth_section_callback',
        'redatudo_auth_group'
    );

    add_settings_field(
        'enable_social_redirect',
        'Habilitar Redirecionamento para Social Login',
        'redatudo_auth_enable_social_callback',
        'redatudo_auth_group',
        'redatudo_auth_section'
    );

    add_settings_field(
        'social_redirect_url',
        'URL de Redirecionamento para Social Login',
        'redatudo_auth_social_url_callback',
        'redatudo_auth_group',
        'redatudo_auth_section'
    );

    add_settings_field(
        'enable_email_redirect',
        'Habilitar Redirecionamento para Verificação de Email',
        'redatudo_auth_enable_email_callback',
        'redatudo_auth_group',
        'redatudo_auth_section'
    );

    add_settings_field(
        'email_redirect_url',
        'URL de Redirecionamento para Verificação de Email',
        'redatudo_auth_email_url_callback',
        'redatudo_auth_group',
        'redatudo_auth_section'
    );

    add_settings_field(
        'app_redirect_urls',
        'URLs de Redirecionamento para Apps',
        'redatudo_auth_app_urls_callback',
        'redatudo_auth_group',
        'redatudo_auth_section'
    );

    add_settings_field(
        'disable_plugin',
        'Desabilitar Plugin',
        'redatudo_auth_disable_callback',
        'redatudo_auth_group',
        'redatudo_auth_section'
    );
}

/**
 * Section callback
 */
function redatudo_auth_section_callback() {
    echo 'Configure os redirecionamentos para diferentes tipos de login.';
}

/**
 * Field callbacks
 */
function redatudo_auth_enable_social_callback() {
    $options = get_option( 'redatudo_auth_options' );
    $checked = isset( $options['enable_social_redirect'] ) ? checked( $options['enable_social_redirect'], 1 ) : '';
    echo '<input type="checkbox" name="redatudo_auth_options[enable_social_redirect]" value="1" ' . $checked . ' />';
}

function redatudo_auth_social_url_callback() {
    $options = get_option( 'redatudo_auth_options' );
    $value = isset( $options['social_redirect_url'] ) ? $options['social_redirect_url'] : 'https://chat.redatudo.online/';
    echo '<input type="url" name="redatudo_auth_options[social_redirect_url]" value="' . esc_attr( $value ) . '" style="width: 100%;" />';
}

function redatudo_auth_enable_email_callback() {
    $options = get_option( 'redatudo_auth_options' );
    $checked = isset( $options['enable_email_redirect'] ) ? checked( $options['enable_email_redirect'], 1 ) : '';
    echo '<input type="checkbox" name="redatudo_auth_options[enable_email_redirect]" value="1" ' . $checked . ' />';
}

function redatudo_auth_email_url_callback() {
    $options = get_option( 'redatudo_auth_options' );
    $value = isset( $options['email_redirect_url'] ) ? $options['email_redirect_url'] : 'https://chat.redatudo.online/';
    echo '<input type="url" name="redatudo_auth_options[email_redirect_url]" value="' . esc_attr( $value ) . '" style="width: 100%;" />';
}

function redatudo_auth_app_urls_callback() {
    $options = get_option( 'redatudo_auth_options' );
    $value = isset( $options['app_redirect_urls'] ) ? $options['app_redirect_urls'] : "1: https://chat.redatudo.online/\nchat: https://chat.redatudo.online/\nzap-agent: https://zap-agent.redatudo.online/\ntestIChat321: http://localhost:4200/";
    echo '<textarea name="redatudo_auth_options[app_redirect_urls]" rows="5" style="width: 100%;">' . esc_textarea( $value ) . '</textarea>';
    echo '<p>Formato: chave: url (uma por linha)</p>';
}

function redatudo_auth_disable_callback() {
    $options = get_option( 'redatudo_auth_options' );
    $checked = isset( $options['disable_plugin'] ) ? checked( $options['disable_plugin'], 1 ) : '';
    echo '<input type="checkbox" name="redatudo_auth_options[disable_plugin]" value="1" ' . $checked . ' /> Desabilita todos os redirecionamentos e funcionalidades do plugin.';
}

/**
 * Settings page
 */
function redatudo_auth_settings_page() {
    ?>
    <div class="wrap">
        <h1>Redatudo Auth Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields( 'redatudo_auth_group' );
            do_settings_sections( 'redatudo_auth_group' );
            submit_button();
            ?>
        </form>
    </div>
    <?php
}
