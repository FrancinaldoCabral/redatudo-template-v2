<!--
  Redatudo Logout Compartilhado - Template Snippet
  
  Adicione este código no seu footer.php ou header.php
  para ter acesso fácil à função de logout em templates
  
  Use assim:
  <a href="<?php echo esc_url(redatudo_get_logout_url()); ?>">Logout</a>
  ou
  <a href="<?php echo esc_url(redatudo_get_logout_url('https://hub.redatudo.online')); ?>">Logout</a>
-->

<?php
/**
 * Display logout link with optional redirect
 * 
 * @param string $redirect_to Optional URL to redirect after logout
 */
if ( ! function_exists( 'redatudo_logout_link' ) ) {
    function redatudo_logout_link( $redirect_to = null, $link_text = 'Logout' ) {
        if ( ! is_user_logged_in() ) {
            return '';
        }
        
        $logout_url = redatudo_get_logout_url( $redirect_to );
        return '<a href="' . esc_url( $logout_url ) . '" class="redatudo-logout-link">' . esc_html( $link_text ) . '</a>';
    }
}

/**
 * Output logout button
 */
if ( ! function_exists( 'redatudo_logout_button' ) ) {
    function redatudo_logout_button( $redirect_to = null, $button_text = 'Logout' ) {
        if ( ! is_user_logged_in() ) {
            return '';
        }
        
        $logout_url = redatudo_get_logout_url( $redirect_to );
        return '<a href="' . esc_url( $logout_url ) . '" class="redatudo-logout-button button">' . esc_html( $button_text ) . '</a>';
    }
}

/**
 * Render logout link directly
 */
if ( ! function_exists( 'redatudo_the_logout_link' ) ) {
    function redatudo_the_logout_link( $redirect_to = null, $link_text = 'Logout' ) {
        echo redatudo_logout_link( $redirect_to, $link_text );
    }
}

/**
 * Render logout button directly
 */
if ( ! function_exists( 'redatudo_the_logout_button' ) ) {
    function redatudo_the_logout_button( $redirect_to = null, $button_text = 'Logout' ) {
        echo redatudo_logout_button( $redirect_to, $button_text );
    }
}

/**
 * JavaScript para logout automático nos dropdowns
 */
if ( ! function_exists( 'redatudo_add_logout_script' ) ) {
    function redatudo_add_logout_script() {
        if ( is_user_logged_in() ) {
            ?>
            <script>
            (function() {
                // Setup para links com classe redatudo-logout-link
                var logoutLinks = document.querySelectorAll('.redatudo-logout-link, .redatudo-logout-button');
                logoutLinks.forEach(function(link) {
                    link.addEventListener('click', function(e) {
                        // Se já é um link válido, deixa default
                        // Se for um botão, redireciona
                        if (link.tagName === 'BUTTON') {
                            e.preventDefault();
                            window.location.href = link.href;
                        }
                    });
                });
            })();
            </script>
            <?php
        }
    }
}

// Adiciona o script automático
add_action( 'wp_footer', 'redatudo_add_logout_script' );
?>

<!-- 
  EXEMPLOS DE USO NO TEMPLATE
  
  1. Simples Link:
  <?php redatudo_the_logout_link(); ?>
  
  2. Link com redirecionamento pro app:
  <?php redatudo_the_logout_link( 'https://hub.redatudo.online', 'Sair' ); ?>
  
  3. Botão:
  <?php redatudo_the_logout_button(); ?>
  
  4. Botão com redirecionamento:
  <?php redatudo_the_logout_button( 'https://ebook.redatudo.online', 'Fazer logout' ); ?>
  
  5. HTML direto (sem função):
  <a href="<?php echo esc_url(redatudo_get_logout_url()); ?>">Logout</a>
  
  6. HTML com redirecionamento:
  <a href="<?php echo esc_url(redatudo_get_logout_url('https://chat.redatudo.online')); ?>">
    Logout e voltar para Chat
  </a>
  
  7. Em lista de links do dropdown:
  <div class="account-dropdown">
    <a href="/profile">Meu Perfil</a>
    <a href="/settings">Configurações</a>
    <hr>
    <?php redatudo_the_logout_link( null, 'Logout' ); ?>
  </div>
-->
