<?php 
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function token_generate(){
	$user = wp_get_current_user(  );
	//print_r($teste) ;
	//echo JWT_AUTH_SECRET_KEY;
	$secret_key = JWT_AUTH_SECRET_KEY;
	$algorithm = apply_filters( 'jwt_auth_algorithm', 'HS256' );
	$issuedAt  = time();
	$notBefore = apply_filters( 'jwt_auth_not_before', $issuedAt, $issuedAt );
	$expire    = apply_filters( 'jwt_auth_expire', $issuedAt + ( DAY_IN_SECONDS * 7 ), $issuedAt );

	$token = [
		'iss'  => get_bloginfo( 'url' ),
		'iat'  => $issuedAt,
		'nbf'  => $notBefore,
		'exp'  => $expire,
		'data' => [
			'user' => [
				'id' => $user->data->ID,
			],
		],
	];

	$token = JWT::encode(
		apply_filters( 'jwt_auth_token_before_sign', $token, $user ),
		$secret_key,
		$algorithm
	);
	return $token;
}

function clear_token_url(){
    echo '<script>var newURL = location.href.split("?")[0]; window.history.pushState("object", document.title, newURL);</script>';
}

function is_myaccount(){
	$token = $_GET["token"];
	if(isset($token)){
        clear_token_url();
		$autorizaztion = 'Bearer '. $token;
		if(!is_user_logged_in(  )){
			//verify token
			$request = new WP_REST_Request ( 'POST' , '/jwt-auth/v1/token/validate' );
			$request->set_header( 'content-type', 'application/json' );
			$request->set_header( 'Authorization', $autorizaztion );
			//$request->set_body( $json_data );
			$response = rest_do_request( $request );
			$server = rest_get_server();
			$data = $server->response_to_data( $response, false );
			//$valid = wp_json_encode( $data );

			if(isset($data['code']) && $data['code'] == 'jwt_auth_valid_token'){
				$request = new WP_REST_Request ( 'GET' , '/api/v1/me' );
				//$request->set_header( 'content-type', 'application/json' );
				$request->set_header( 'Authorization', $autorizaztion );
				//$request->set_body( $json_data );
				$response = rest_do_request( $request );
				$server = rest_get_server();
				$data = $server->response_to_data( $response, false );
                $decoded = JWT::decode($token, new Key(JWT_AUTH_SECRET_KEY, 'HS256'));
				//$user = wp_json_encode( $data );
				if( isset($decoded->data->id) ) {
                    $user = get_user_by( 'id', $decoded->data->id);
                    wp_set_current_user( $decoded->data->id, $user->user_login );
                    wp_set_auth_cookie( $decoded->data->id );
					//do_action( 'wp_login', $user->user_login );
				}
			}
		}
	}
}

?>
<!DOCTYPE html>
<html lang="br">

<head>
<base href="/" />
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Tema e navegação -->
<meta name="theme-color" content="#0d0d13">
<meta name="color-scheme" content="dark only">
<link rel="icon" href="https://redatudo-pt-storage-pull-zone.b-cdn.net/logotipo-favicon-gerador-de-copy-com-ia-192x192-branco-parcial.ico" type="image/x-icon" sizes="192x192">

<!-- Orbitron + fallback -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700&display=swap" rel="stylesheet">

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<?php is_myaccount(); ?>

<!-- SEO, Schema e avaliações dinâmicas -->
<?php 
    $comments = get_comments( 'post_id=46' );
    $somaRating = 0;
    foreach ( $comments as $comment ){
        $rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );
        $somaRating += $rating;
    }
    $average = $somaRating / max(1, count($comments));
?>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "SoftwareApplication",
    "name": "REDATUDO",
    "operatingSystem": "WEB",
    "applicationCategory": "WebApplication",
    "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "<?php echo round($average, 2); ?>",
    "ratingCount": "<?php echo count($comments); ?>"
    },
    "offers": {
    "@type": "Offer",
    "price": "0",
    "priceCurrency": "BRL"
    }
}
</script>

<!-- Google Ads -->
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9848635946946970"
     crossorigin="anonymous"></script>

<?php wp_head(); ?>

<!-- Estilo visual Redatudo -->
<style>
:root {
  --roxo-ia: #7f00ff;
  --azul-tech: #00bfff;
  --preto-fundo: #0d0d13;
  --azul-glow: #00ffd0;
}
html {
    background: var(--preto-fundo);
    color-scheme: dark;
}
body {
    background: radial-gradient(ellipse at top right, #1c1441 40%, #161234 100%);
    color: #f2f6fa;
    font-family: 'Orbitron', Arial, sans-serif;
    min-height: 100vh;
    /* Suave glow padrão site */
    box-shadow: 0 0 16vw 0 #00bfff20 inset;
}
h1, h2, h3, h4, .navbar-brand, .recursos-title, .casos-title {
    font-family: 'Orbitron', Arial, sans-serif !important;
    letter-spacing: 1.5px;
    text-transform: uppercase;
}
.navbar {
    background: #171727f7 !important;
    box-shadow: 0 2px 24px #7f00ff18 !important;
}
.nav-link, .navbar-nav .nav-link {
    font-family: 'Orbitron', Arial, sans-serif;
    color: #b8e6ff !important;
    text-shadow: 0 1px 3px #0d0d13a6;
    font-weight: 600;
    transition: color .17s, border .22s;
}
.nav-link:hover, .navbar-nav .nav-link.active, .navbar-nav .nav-link:focus {
    color: #00ffd0 !important;
    border-bottom: 2px solid #00ffd0;
}
.btn-primary, .btn-outline-success, .btn {
    font-family: 'Orbitron', Arial, sans-serif;
    border-radius: 22px !important;
    font-size: 1.02rem;
    box-shadow: 0 2px 10px #00bfff30;
    background: linear-gradient(90deg, #7f00ff 55%, #00bfff 100%);
    border: none;
    transition: transform .22s, box-shadow .22s, background .25s;
}
.btn-primary:hover, .btn-outline-success:hover, .btn:active {
    transform: translateY(-2px) scale(1.04);
    box-shadow: 0 2px 30px #00ffd084, 0 1px 2px #7f00ff10;
    background: linear-gradient(95deg, #00bfff 60%, #7f00ff 100%);
}
a, .nav-link, .navbar-brand {
    transition: color .18s, box-shadow .24s;
    text-decoration: none !important;
}
img, svg, .navbar-brand img {
    filter: drop-shadow(0 1px 10px #00bfff44);
    transition: filter .16s;
}
.bg-dark { background-color: #171727 !important; }
::-webkit-scrollbar-thumb { background: linear-gradient(90deg,#7f00ff,#00bfff); }
::-webkit-scrollbar { background: #101022;}
/* Glow decorativo base da identidade */
.recursos-section, .casos-section, .hero-section {
    position: relative;
    z-index: 1;
}
.recursos-section::before, .casos-section::before, .hero-section::before {
    content: '';
    position: absolute;
    top: 10%; left: 50%; width: 70vw; height: 25vw;
    transform: translateX(-50%);
    background: radial-gradient(circle, #00bfff0a 0%, #7f00ff0e 50%, transparent 100%);
    filter: blur(32px);
    z-index: 0;
    opacity: 0.9;
    pointer-events: none;
    animation: pulseGlow 6s infinite alternate;
}
@keyframes pulseGlow {
    0% { opacity: 0.91;}
    100% { opacity: 0.71;}
}

::selection { background: #00bfff44; }

/* BADGES estilo footer para categorias e tags na single */
.single-tags-cats .badge-reda {
  display: inline-block;
  font-family: 'Orbitron', Arial, sans-serif;
  font-size: 0.78rem;
  font-weight: 400;
  text-transform: none;
  background: #161b28;
  color: #a0addd;
  border-radius: 7px;
  padding: 0.12em 0.48em;
  margin: 0.11em 0.14em;
  box-shadow: none;
  border: 1px solid #232948;
  opacity: 0.86;
  cursor: pointer;
  text-decoration: none !important;
  transition: background .18s, color .12s, box-shadow .13s;
  letter-spacing: 0.1px;
}
.single-tags-cats .badge-reda:hover {
  background: #232948;
  color: #00ffd0;
  box-shadow: 0 1px 4px #00ffd013;
}

html, body {
  max-width: 100vw;
  overflow-x: hidden !important;
}



/* Notificações WooCommerce (info, sucesso, erro) — Redatudo, ícone sempre centralizado */
.woocommerce-message, .woocommerce-info, .woocommerce-error {
  border-radius: 14px !important;
  font-family: 'Orbitron', Arial, sans-serif !important;
  font-weight: 600;
  font-size: 1.08em;
  letter-spacing: .2px;
  padding: 1em 1.3em 1em 3em !important;
  margin-bottom: 1.2em !important;
  position: relative;
  box-shadow: 0 2px 16px #00bfff18;
  border: none !important;
}

/* Ícone sempre à esquerda, centralizado vertical */
.woocommerce-info:before,
.woocommerce-message:before,
.woocommerce-error:before {
  position: absolute;
  left: 1em;
  top: 50%;
  transform: translateY(-50%);
  font-size: 1.3em;
  line-height: 1;
}

/* INFO */
.woocommerce-info {
  max-width: 730px; margin: 0 auto; padding: 1.2em 0; font-family: 'Orbitron', Arial, sans-serif;
  background: linear-gradient(90deg,#162447f0,#171727cc 80%);
  color: #00ffd0 !important;
}
.woocommerce-info:before {
  content: "ℹ️";
  color: #00bfff;
}

/* SUCESSO */
.woocommerce-message {
  max-width: 730px; margin: 0 auto; padding: 1.2em 0; font-family: 'Orbitron', Arial, sans-serif;
  background: linear-gradient(90deg,#003f29 60%,#00ffd026 100%);
  color: #1efeb7 !important;
}
.woocommerce-message:before {
  content: "✅";
  color: #00ffd0;
}

/* ERRO */
.woocommerce-error {
  background: linear-gradient(90deg,#3d101ad0,#ff418c25 80%);
  color: #ff418c !important;
}
.woocommerce-error:before {
  content: "❌";
  color: #ff418c;
}
</style>
</head>
<body>
<header>

<?php if (function_exists('is_checkout') && is_checkout()) : ?>
  <style>
    .checkout-mini-toggle-wrap {
      position: fixed;
      top: 22px;
      right: 22px;
      z-index: 2001;
      /* Evita sobrepor popups do gateway */
      user-select: none;
    }
    .checkout-mini-btn {
      background: rgba(16,16,34,0.87);
      border: 1.2px solid #27274a;
      color: #b8e6ff;
      border-radius: 50%;
      width: 42px;
      height: 42px;
      font-size: 1.5rem;
      font-family: 'Orbitron', Arial, sans-serif;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      box-shadow: 0 2px 12px #10102244;
      transition: background .19s, border .17s, color .17s, box-shadow .19s;
      outline: none;
      padding: 0;
    }
    .checkout-mini-btn:hover, .checkout-mini-btn:focus {
      background: #19193a;
      border-color: #00bfff55;
      color: #00ffd0;
      box-shadow: 0 4px 20px #00bfff33;
    }
    .checkout-mini-dropdown {
      display: none;
      position: absolute;
      top: 46px;
      right: 0;
      min-width: 180px;
      background: #18182cfa;
      border: 1.5px solid #232351;
      border-radius: 13px;
      box-shadow: 0 10px 24px #00bfff18;
      font-family: 'Orbitron', Arial, sans-serif;
      padding: 0.5em 0;
      z-index: 3002;
      animation: fadeIn 0.18s;
    }
    .checkout-mini-dropdown a {
      display: block;
      padding: 0.56em 1.2em;
      color: #b8e6ff;
      font-size: 0.99rem;
      font-weight: 500;
      text-decoration: none;
      border-radius: 7px;
      transition: color .13s, background .13s;
    }
    .checkout-mini-dropdown a:hover {
      color: #00ffd0;
      background: #00bfff0d;
    }
    .checkout-mini-dropdown hr {
      margin: 0.4em 0;
      border-color: #00bfff22;
    }
    @media (max-width: 700px){
      .checkout-mini-toggle-wrap { right: 10px; top: 12px;}
      .checkout-mini-dropdown { min-width: 150px;}
    }
    @keyframes fadeIn {
      from { opacity:0; transform: translateY(-10px);}
      to { opacity:1; transform: translateY(0);}
    }
  </style>
  <div class="checkout-mini-toggle-wrap" aria-label="Menu rápido">
    <button class="checkout-mini-btn" id="checkoutMiniBtn" aria-haspopup="true" aria-controls="checkoutMiniDropdown" aria-expanded="false" title="Mais opções">
      &#9776;
    </button>
    <div class="checkout-mini-dropdown" id="checkoutMiniDropdown" role="menu">
      <a href="https://redatudo.online/product/credits/">Credits</a>
      <a href="https://redatudo.online/?post_type=product&p=24795&preview=true">Unlimited</a>
      <hr>
      <a href="https://chat.redatudo.online">← AI Assistant</a>
    </div>
  </div>
  <script>
    const btn = document.getElementById('checkoutMiniBtn');
    const dropdown = document.getElementById('checkoutMiniDropdown');
    btn.onclick = function(e){
      e.stopPropagation();
      const isOpen = dropdown.style.display === 'block';
      dropdown.style.display = isOpen ? 'none' : 'block';
      btn.setAttribute('aria-expanded', !isOpen);
    };
    // Fechar ao clicar fora
    document.addEventListener('click', function(){ dropdown.style.display = 'none'; btn.setAttribute('aria-expanded', false); });
    dropdown.onclick = function(e){ e.stopPropagation(); }
    // Fechar ao esc
    document.addEventListener('keydown', function(e){
      if(e.key === 'Escape') { dropdown.style.display = 'none'; btn.setAttribute('aria-expanded', false);}
    });
  </script>
<?php else : ?>
  
  <!-- SUA NAVBAR NORMAL AQUI -->
  <nav class="navbar navbar-expand-lg fixed-top bg-dark" data-bs-theme="dark" style="backdrop-filter: blur(6px);">
    <div class="container" style="max-width:1100px;">
      <!-- LOGO -->
      <a class="navbar-brand d-flex align-items-center py-0" href="<?php echo get_option('home'); ?>" style="font-family:'Orbitron',sans-serif;letter-spacing:1.5px;font-weight:700;text-shadow:0 1px 16px #7f00ff22;">
        <img src="https://redatudo.online/wp-content/uploads/2025/04/logotipo-redatudo-sem-fundo.png"
             alt="Redatudo - IA para criação de conteúdos"
             width="46" height="46"
             class="img-fluid me-2" style="border-radius:13px;filter:drop-shadow(0 0 9px #00ffd080);" />
        <span class="fw-bold" style="font-size:1.22rem;background:linear-gradient(90deg,#7f00ff,#00bfff 76%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;letter-spacing:2.2px;">
          Redatudo
        </span>
      </a>

      <?php if(is_account_page()):?>
        <div class="d-none d-lg-inline-block ms-2" style="font-family:'Orbitron',sans-serif;font-size:1rem;color:#00ffd0;font-weight:600;">Minha conta</div>
      <?php endif;?>

      <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Menu">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarMain">
        <ul class="navbar-nav me-auto"></ul>
        <ul class="navbar-nav align-items-center">
          <li class="nav-item">
            <a class="nav-link" href="https://redatudo.online/programa-de-afiliados">
              <span style="font-family:'Orbitron',sans-serif;letter-spacing:1px;">Afiliados</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo get_option('home'); ?>#precos">
              <span style="font-family:'Orbitron',sans-serif;letter-spacing:1px;">Preços</span>
            </a>
          </li>
        </ul>

        <!-- LOGIN/USUÁRIO -->
        <div class="ms-lg-4 mt-3 mt-lg-0">
          <?php if(!is_user_logged_in()): ?>
            <a href="https://redatudo.online/minha-conta?login_app=chat" class="btn btn-primary px-4 py-2 fw-bold" id="btnEntrar"
               style="font-family:'Orbitron',sans-serif;font-size:1.1rem;border-radius:22px;box-shadow:0 2px 14px #00bfff40;letter-spacing:1px;">
              Entrar
            </a>
          <?php else: ?>
            <div class="btn-group dropstart d-none d-lg-block me-3">
              <a class="btn btn-outline-success dropdown-toggle px-4 py-2" href="#" role="button" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false"
                style="font-family:'Orbitron',sans-serif;font-weight:600;border-radius:18px;color:#00ffd0;">
                Conectado
              </a>
              <ul class="dropdown-menu" aria-labelledby="dropdownUser">
                <li>
                  <span class="dropdown-item-text" style="color:#00ffd0;">
                    <?php $user = wp_get_current_user(); echo '🟢 '.$user->user_email; ?>
                  </span>
                </li>
                <li><a class="dropdown-item" href="https://chat.redatudo.online/?token=<?php echo token_generate(); ?>">Começar</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="<?php echo wp_logout_url( 'https://redatudo.online/minha-conta?login_login_app=chat' ); ?>">Sair</a></li>
              </ul>
            </div>
            <div class="btn-group d-block d-lg-none">
              <a class="btn btn-outline-success dropdown-toggle px-3 py-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"
                style="font-family:'Orbitron',sans-serif;font-weight:600;border-radius:19px;color:#00ffd0;">
                Conectado
              </a>
              <ul class="dropdown-menu">
                <li>
                  <span class="dropdown-item-text" style="color:#00ffd0;">
                    <?php $user = wp_get_current_user(); echo '🟢 '.$user->user_email; ?>
                  </span>
                </li>
                <li><a class="dropdown-item" href="https://chat.redatudo.online/?token=<?php echo token_generate(); ?>">Começar</a></li>
                <li><a class="dropdown-item" href="<?php echo wp_logout_url( 'https://redatudo.online/minha-conta?login_login_app=chat' ); ?>">Sair</a></li>
              </ul>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </nav>
<?php endif; ?>
 
  <br><br><br><br>
  <script>
    const btnEntrar = document.getElementById("btnEntrar");
    if(btnEntrar) {
      btnEntrar.addEventListener("click", function(e){
        // para Single Page Application não recarregar à toa
        window.location.href = "https://redatudo.online/minha-conta?login_login_app=chat";
      });
    }
  </script>
</header>