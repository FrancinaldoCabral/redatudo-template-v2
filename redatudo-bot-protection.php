<?php
/**
 * RedaTudo — Bot Protection
 *
 * Proteções implementadas:
 *   1. Rate limit de login: 5 tentativas / 10 min por IP → bloqueia por 60 min
 *   2. Rate limit de registro: 3 contas / hora por IP
 *   3. Honeypot invisível no formulário de registro WooCommerce
 *   4. Bloqueio de domínios de email descartáveis
 *
 * Não afeta:
 *   - Login via token JWT (redatudo-auth.php)
 *   - Usuários já autenticados
 *   - Requests do wp-cron
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ─── CONSTANTES ───────────────────────────────────────────────────────────────

define( 'RDTD_LOGIN_MAX_ATTEMPTS',  5  );   // tentativas antes de bloquear
define( 'RDTD_LOGIN_WINDOW',        600 );  // janela de contagem (seg) = 10 min
define( 'RDTD_LOGIN_LOCKOUT',       3600 ); // tempo de bloqueio (seg) = 60 min
define( 'RDTD_REGISTER_MAX',        3  );   // registros por janela
define( 'RDTD_REGISTER_WINDOW',     3600 ); // janela de registro (seg) = 1 hora

// ─── HELPERS ──────────────────────────────────────────────────────────────────

/**
 * Retorna IP real do visitante de forma segura.
 * Em produção com Cloudflare, o IP real vem de HTTP_CF_CONNECTING_IP.
 */
function rdtd_get_ip() {
    $headers = [
        'HTTP_CF_CONNECTING_IP', // Cloudflare — mais confiável quando ativo
        'HTTP_X_REAL_IP',
        'REMOTE_ADDR',
    ];
    foreach ( $headers as $h ) {
        if ( ! empty( $_SERVER[ $h ] ) ) {
            $ip = sanitize_text_field( wp_unslash( $_SERVER[ $h ] ) );
            // Pega o primeiro IP se vier lista separada por vírgula
            $ip = trim( explode( ',', $ip )[0] );
            if ( filter_var( $ip, FILTER_VALIDATE_IP ) ) {
                return $ip;
            }
        }
    }
    return '0.0.0.0';
}

/**
 * Converte IP em chave de transient segura (sem caracteres especiais).
 */
function rdtd_ip_key( $prefix, $ip ) {
    return $prefix . '_' . md5( $ip );
}

// ─── RATE LIMIT DE LOGIN ──────────────────────────────────────────────────────

/**
 * Incrementa contador de tentativas de login falhas por IP.
 * Disparado apenas em falha (hook wp_login_failed).
 */
add_action( 'wp_login_failed', function( $username ) {
    $ip      = rdtd_get_ip();
    $key     = rdtd_ip_key( 'rdtd_lf', $ip );
    $lockkey = rdtd_ip_key( 'rdtd_lk', $ip );

    // Se já está bloqueado, não precisa fazer nada
    if ( get_transient( $lockkey ) ) {
        return;
    }

    $attempts = (int) get_transient( $key );
    $attempts++;

    if ( $attempts >= RDTD_LOGIN_MAX_ATTEMPTS ) {
        // Bloqueia o IP
        set_transient( $lockkey, 1, RDTD_LOGIN_LOCKOUT );
        delete_transient( $key );
    } else {
        set_transient( $key, $attempts, RDTD_LOGIN_WINDOW );
    }
} );

/**
 * Verifica bloqueio antes de processar o login.
 * Retorna erro WP_Error se bloqueado — interrompe o login sem derrubar nada.
 */
add_filter( 'authenticate', function( $user, $username, $password ) {
    // Só age quando há tentativa real de autenticação
    if ( empty( $username ) || empty( $password ) ) {
        return $user;
    }

    $ip      = rdtd_get_ip();
    $lockkey = rdtd_ip_key( 'rdtd_lk', $ip );

    if ( get_transient( $lockkey ) ) {
        $minutes = round( RDTD_LOGIN_LOCKOUT / 60 );
        return new WP_Error(
            'rdtd_too_many_attempts',
            sprintf(
                __( 'Muitas tentativas de login. Tente novamente em %d minutos.', 'redatudo' ),
                $minutes
            )
        );
    }

    return $user;
}, 30, 3 ); // prioridade 30 — depois dos filtros do WooCommerce (20)

/**
 * Limpa o contador de tentativas em login bem-sucedido.
 */
add_action( 'wp_login', function( $user_login, $user ) {
    $ip = rdtd_get_ip();
    delete_transient( rdtd_ip_key( 'rdtd_lf', $ip ) );
    delete_transient( rdtd_ip_key( 'rdtd_lk', $ip ) );
}, 10, 2 );

// ─── RATE LIMIT DE REGISTRO ───────────────────────────────────────────────────

/**
 * Bloqueia registro se o IP já criou muitas contas na janela de tempo.
 * Hook: woocommerce_register_post (antes de criar o usuário).
 */
add_action( 'woocommerce_register_post', function( $username, $email, $validation_errors ) {
    $ip  = rdtd_get_ip();
    $key = rdtd_ip_key( 'rdtd_rc', $ip );
    $count = (int) get_transient( $key );

    if ( $count >= RDTD_REGISTER_MAX ) {
        $validation_errors->add(
            'rdtd_register_limit',
            __( 'Muitos cadastros realizados. Tente novamente mais tarde.', 'redatudo' )
        );
    }
}, 10, 3 );

/**
 * Incrementa contador de registros após criação bem-sucedida.
 */
add_action( 'woocommerce_created_customer', function( $customer_id ) {
    $ip  = rdtd_get_ip();
    $key = rdtd_ip_key( 'rdtd_rc', $ip );
    $count = (int) get_transient( $key );
    set_transient( $key, $count + 1, RDTD_REGISTER_WINDOW );
} );

// ─── HONEYPOT NO FORMULÁRIO DE REGISTRO ──────────────────────────────────────

/**
 * Adiciona campo invisível ao formulário de registro WooCommerce.
 * Bots de formulário preenchem todos os campos — incluindo os ocultos.
 */
add_action( 'woocommerce_register_form', function() {
    $nonce = wp_create_nonce( 'rdtd_honeypot' );
    ?>
    <div style="position:absolute;left:-9999px;top:-9999px;width:1px;height:1px;overflow:hidden;" aria-hidden="true">
        <label for="rdtd_company">Company</label>
        <input type="text" name="rdtd_company" id="rdtd_company" value="" tabindex="-1" autocomplete="off">
        <input type="hidden" name="rdtd_hp_nonce" value="<?php echo esc_attr( $nonce ); ?>">
    </div>
    <?php
} );

/**
 * Valida honeypot na submissão do registro.
 * Se o campo oculto foi preenchido ou o nonce é inválido → rejeita.
 */
add_action( 'woocommerce_register_post', function( $username, $email, $validation_errors ) {
    // Verifica nonce do honeypot
    if ( empty( $_POST['rdtd_hp_nonce'] ) ||
         ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['rdtd_hp_nonce'] ) ), 'rdtd_honeypot' ) ) {
        $validation_errors->add( 'rdtd_honeypot_fail', __( 'Erro de validação do formulário.', 'redatudo' ) );
        return;
    }

    // Verifica se o campo honeypot foi preenchido
    if ( ! empty( $_POST['rdtd_company'] ) ) {
        $validation_errors->add( 'rdtd_bot_detected', __( 'Erro de validação do formulário.', 'redatudo' ) );
    }
}, 10, 3 );

// ─── BLOQUEIO DE EMAILS DESCARTÁVEIS ─────────────────────────────────────────

/**
 * Lista de domínios de email descartáveis mais usados para criar contas falsas.
 * Atualizar conforme necessário.
 */
function rdtd_get_disposable_domains() {
    return [
        'mailinator.com', 'guerrillamail.com', 'tempmail.com', 'throwam.com',
        'trashmail.com', 'sharklasers.com', 'guerrillamailblock.com', 'grr.la',
        'guerrillamail.info', 'guerrillamail.biz', 'guerrillamail.de', 'guerrillamail.net',
        'guerrillamail.org', 'spam4.me', 'yopmail.com', 'yopmail.fr', 'cool.fr.nf',
        'jetable.fr.nf', 'nospam.ze.tc', 'nomail.xl.cx', 'mega.zik.dj', 'speed.1s.fr',
        'courriel.fr.nf', 'moncourrier.fr.nf', 'monemail.fr.nf', 'monmail.fr.nf',
        'dispostable.com', 'mailnesia.com', 'mailnull.com', 'spamgourmet.com',
        'spamgourmet.net', 'spamgourmet.org', 'spamspot.com', 'spamthis.co.uk',
        'fakeinbox.com', 'mailexpire.com', 'mailfreeonline.com', 'mailguard.me',
        'mailme.lv', 'mailme24.com', 'mailmetrash.com', 'mailmoat.com', 'mailnew.com',
        'mailnull.com', 'mailsiphon.com', 'mailslite.com', 'mailzilla.org',
        'mbx.cc', 'mega.zik.dj', 'mt2009.com', 'mt2014.com', 'mytempemail.com',
        'mytempmail.com', 'neomailbox.com', 'nobulk.com', 'noclickemail.com',
        'nomail.pw', 'nomail.xl.cx', 'nomailer.in', 'nospamfor.us', 'nowmymail.com',
        'objectmail.com', 'obobbo.com', 'odaymail.com', 'oneoffemail.com',
        'onewaymail.com', 'oopi.org', 'opayq.com', 'ordinaryamerican.net',
        'otherinbox.com', 'ovpn.to', 'owlpic.com', 'pecinan.com', 'pecinan.net',
        'pecinan.org', 'pepbot.com', 'pfui.ru', 'photo-impact.eu', 'pimpedupmyspace.com',
        'pjjkp.com', 'plexolan.de', 'poczta.onet.pl', 'politikerclub.de',
        'poofy.org', 'pookmail.com', 'privacy0.com', 'proxymail.eu', 'prtnx.com',
        'prtz.eu', 'punkass.com', 'put2.net', 'putthisinyourspamdatabase.com',
        'pwrby.com', 'qq.com', 'quickinbox.com', 'rcpt.at', 'recode.me',
        'recursor.net', 'reliable-mail.com', 'rejectmail.com', 'reliable-mail.com',
        'rhyta.com', 'rmqkr.net', 'royal.net', 'rppkn.com', 'rtrtr.com',
        's0ny.net', 'safe-mail.net', 'safersignup.de', 'sast.ro', 'sb.rr.com',
        'schiffswerk.de', 'schrott-email.de', 'secretemail.de', 'secure-mail.biz',
        'selfdestructingmail.com', 'senseless-entertainment.com', 'sent.as',
        'sharedmailbox.org', 'sharklasers.com', 'shieldemail.com', 'shiftmail.com',
        'shitmail.me', 'shitware.nl', 'shmeriously.com', 'shootmail.com',
        'shortmail.net', 'sibmail.com', 'sinnlos-mail.de', 'skeefmail.com',
        'slapsfromlastnight.com', 'slaskpost.se', 'slave-auctions.net', 'slopsbox.com',
        'slushmail.com', 'smapfree24.com', 'smapfree24.de', 'smapfree24.eu',
        'smapfree24.info', 'smapfree24.org', 'smellfear.com', 'smellrear.com',
        'smwg.info', 'snode.org', 'snkmail.com', 'sofimail.com', 'sofort-mail.de',
        'sogetthis.com', 'soodonims.com', 'spam.la', 'spamavert.com', 'spamcero.com',
        'spamcon.org', 'spamcorptastic.com', 'spamcowboy.com', 'spamcowboy.net',
        'spamcowboy.org', 'spamday.com', 'spamex.com', 'spamfree.eu', 'spamfree24.de',
        'spamfree24.eu', 'spamfree24.info', 'spamfree24.net', 'spamfree24.org',
        'spamgoes.in', 'spamgourmet.com', 'spamgourmet.net', 'spamgourmet.org',
        'spamherelots.com', 'spamhereplease.com', 'spamhole.com', 'spamify.com',
        'spaminator.de', 'spamkill.info', 'spaml.com', 'spaml.de', 'spammotel.com',
        'spamobox.com', 'spamoff.de', 'spamslicer.com', 'spamspot.com', 'spamstack.net',
        'spamthis.co.uk', 'spamthisplease.com', 'spamtroll.net', 'speed.1s.fr',
        'spoofmail.de', 'stuffmail.de', 'super-auswahl.de', 'supergreatmail.com',
        'supermailer.jp', 'superrito.com', 'superstachel.de', 'suremail.info',
        'tafmail.com', 'tagyourself.com', 'talkinator.com', 'tapchicuoihoi.com',
        'tarrn.com', 'temp-mail.org', 'temp-mail.ru', 'temp.emeraldwebmail.com',
        'tempalias.com', 'tempinbox.co.uk', 'tempinbox.com', 'tempmail.eu',
        'tempomail.fr', 'temporaryemail.net', 'temporaryemail.us', 'temporaryforwarding.com',
        'temporaryinbox.com', 'temporarymailaddress.com', 'tempthe.net',
        'thanksnospam.info', 'thankyou2010.com', 'thc.st', 'thelimestones.com',
        'thisisnotmyrealemail.com', 'throwam.com', 'throwaway.email', 'throwemail.com',
        'tilien.com', 'tittbit.in', 'tizi.com', 'tmailinator.com', 'toomail.biz',
        'topranklist.de', 'tradermail.info', 'trash-amil.com', 'trash-mail.at',
        'trash-mail.com', 'trash-mail.de', 'trash-mail.ga', 'trash-mail.io',
        'trash-mail.ml', 'trash-mail.tk', 'trashdevil.com', 'trashdevil.de',
        'trashemail.de', 'trashmail.at', 'trashmail.com', 'trashmail.de',
        'trashmail.io', 'trashmail.me', 'trashmail.net', 'trashmail.org',
        'trashmailer.com', 'trashme.at', 'trashymail.com', 'trbvm.com',
        'trickmail.net', 'trillianpro.com', 'tryalert.com', 'turual.com',
        'twinmail.de', 'tyldd.com', 'uggsrock.com', 'umail.net', 'unamed.com',
        'unmail.ru', 'uroid.com', 'us.af', 'username.e4ward.com', 'veryrealemail.com',
        'vidchart.com', 'viditag.com', 'viewcastmedia.com', 'viewcastmedia.net',
        'viewcastmedia.org', 'vkcode.ru', 'vomoto.com', 'vpn.st', 'vsimcard.com',
        'vubby.com', 'walala.org', 'walkmail.net', 'walkmail.ru', 'webemail.me',
        'webm4il.info', 'wegwerfadresse.de', 'wegwerfemail.com', 'wegwerfemail.de',
        'wegwerfemails.de', 'wegwerfmail.de', 'wegwerfmail.info', 'wegwerfmail.net',
        'wegwerfmail.org', 'wetrainbayarea.com', 'wetrainbayarea.org',
        'wh4f.org', 'whatpaas.com', 'whiffles.com', 'whyspam.me',
        'willhackforfood.biz', 'willselfdestruct.com', 'winemaven.info',
        'wronghead.com', 'wuzupmail.net', 'www.e4ward.com', 'wwwnew.eu',
        'x.ip6.li', 'xagloo.co', 'xagloo.com', 'xemaps.com', 'xents.com',
        'xmaily.com', 'xoxy.net', 'xsmail.com', 'xww.ro', 'xyz.am',
        'ya.ru', 'yapped.net', 'yeah.net', 'yep.it', 'yhoo.it', 'yomail.info',
        'yopmail.fr', 'yopmail.gq', 'yopmail.net', 'yopmail.pp.ua',
        'youmail.ga', 'youmailr.com', 'yourspamgoesto.com', 'yuurok.com',
        'z1p.biz', 'za.com', 'zehnminuten.de', 'zehnminutenmail.de',
        'zippymail.info', 'zoaxe.com', 'zoemail.net', 'zoemail.org',
        'zomg.info', 'zxcv.com', 'zxcvbnm.com', 'zzz.com',
    ];
}

/**
 * Bloqueia emails descartáveis no registro WooCommerce.
 */
add_action( 'woocommerce_register_post', function( $username, $email, $validation_errors ) {
    $email = strtolower( sanitize_email( $email ) );
    $parts = explode( '@', $email );
    if ( count( $parts ) !== 2 ) {
        return;
    }
    $domain = $parts[1];

    if ( in_array( $domain, rdtd_get_disposable_domains(), true ) ) {
        $validation_errors->add(
            'rdtd_disposable_email',
            __( 'Por favor, use um endereço de email permanente para se cadastrar.', 'redatudo' )
        );
    }
}, 10, 3 );

// ─── FIM ─────────────────────────────────────────────────────────────────────
