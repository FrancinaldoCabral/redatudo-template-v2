<footer class="redatudo-footer py-4 mt-5">
  <style>
    .redatudo-footer {
      background: linear-gradient(92deg,#171727 87%,#101022 100%);
      box-shadow: 0 0 42px 5px #00bfff14;
      color: #b8e6ff;
      font-family: 'Orbitron', Arial, sans-serif;
      letter-spacing: 1px;
    }
    .redatudo-footer .footer-title {
      font-family: 'Orbitron', Arial, sans-serif;
      background: linear-gradient(93deg,#7f00ff,#00bfff 90%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      font-size: 1.32rem;
      font-weight: 700;
      margin-bottom: 1.6rem;
      text-transform: uppercase;
      letter-spacing: 2px;
    }
    .redatudo-footer .badge-reda {
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
/* Hover mais discreto */
.redatudo-footer .badge-reda:hover {
  background: #232948;
  color: #00ffd0;
  box-shadow: 0 1px 4px #00ffd013;
}
    .redatudo-footer .footer-link:hover {
      background: linear-gradient(100deg,#00ffd0 65%, #7f00ff 100%);
      color: #0d0d13;
    }
    .redatudo-footer .footer-link {
      font-family: 'Orbitron', Arial, sans-serif;
      color: #00ffd0;
      font-weight: 600;
      text-decoration: none;
      transition: color .17s;
      font-size: 1.01rem;
      display: inline-block;
      margin: 0.3em 0;
    }
    .redatudo-footer .footer-link:active {
      color: #b8e6ff;
    }
    .redatudo-footer small,
    .redatudo-footer .footer-copy {
      color: #b9badf;
      font-size: 0.98rem;
      display: block;
      margin-top: 0.8em;
      letter-spacing: .8px;
    }
    .redatudo-footer hr {
      border-top: 1.5px solid #00bfff66;
      opacity: 0.35;
      margin: 1.4rem auto 1.2rem;
      width: 85%;
    }
    @media (max-width:768px) {
      .redatudo-footer .footer-actions {
        margin-top: 1.9rem;
      }
      .redatudo-footer .footer-title { font-size: 1.07rem }
    }
  </style>
  <div class="container">

    <div class="row justify-content-center pb-3">
      <div class="col-12 text-center">
        <h3 class="footer-title">Termos mais pesquisados</h3>
        <?php
        $tags = [
            "Gerar ebook gratuito com IA",
            "Criar ebook profissional usando inteligência artificial",
            "Ferramenta online para produção de ebooks automatizados",
            "Escrever ebook automaticamente com IA",
            "Plataforma de criação de livros digitais com IA",
            "Gerador de conteúdo para ebooks",
            "Criar ebook a partir de texto com IA",
            "Ferramenta de autoria de ebooks assistida por IA",
            "Produzir ebook rápido com inteligência artificial",
            "Escrever livro digital automaticamente",
            "Gerador de introduções para trabalhos acadêmicos",
            "Criar prefácio automático para TCC",
            "Ferramenta de escrita de introduções para textos",
            "Gerar abertura para artigos e monografias",
            "Escrever início de trabalhos automaticamente",
            "Criar textos para redes sociais com IA",
            "Gerador de postagens para Instagram",
            "Ferramenta de copywriting para mídias sociais",
            "Produzir conteúdo automático para Instagram",
            "Escrever legendas para redes sociais",
            "Criar descrições para lojas online",
            "Gerar textos para e-commerce",
            "Ferramenta de descrição de produtos",
            "Escrever conteúdo para vitrines virtuais",
            "Produzir textos comerciais automaticamente",
            "Reescrever textos com outras palavras",
            "Ferramenta de paráfrase online",
            "Modificar texto mantendo o sentido original",
            "Alterar redação sem mudar significado",
            "Repaginar conteúdo textual automaticamente",
            "Corrigir textos automaticamente",
            "Ferramenta de revisão gramatical",
            "Melhorar qualidade de textos online",
            "Otimizar escrita com inteligência artificial",
            "Ajustar ortografia e gramática automaticamente",
            "Gerar títulos criativos para textos",
            "Criar headlines atraentes automaticamente",
            "Ferramenta de sugestão de títulos",
            "Produzir chamadas eficazes para conteúdo",
            "Escrever manchetes impactantes",
            "Criar conteúdo acadêmico com IA",
            "Ferramenta para auxílio em trabalhos científicos",
            "Gerar textos para TCC e monografias",
            "Escrever artigos acadêmicos automaticamente",
            "Produzir material de pesquisa automatizado",
            "Gerar copywriting profissional",
            "Criar textos persuasivos de vendas",
            "Ferramenta de redação publicitária",
            "Produzir conteúdo comercial eficaz",
            "Escrever textos que convertem em vendas"
        ];

        $html = '';
        foreach ($tags as $tag) {
            // Cria um link de pesquisa para o termo no WordPress
            $search_url = home_url('/') . '?s=' . urlencode($tag);
            $html .= "<a href='{$search_url}' title='Pesquisar por {$tag}' class='badge-reda'>";
            $html .= "{$tag}</a>";
        }
        echo $html;
        ?>
      </div>
    </div>
    <hr>
    <div class="row justify-content-center align-items-center text-center">
      <div class="col-12 col-md-4 my-2">
        <span class="footer-copy">
          2021-2025 Soluções com Inteligência Artificial <br>
          Redatudo &copy; Todos os direitos reservados.
        </span>
      </div>
      <div class="col-12 col-md-4 my-2 footer-actions">
        <a class="footer-link" href="https://redatudo.online/minha-conta?login_app=chat">Entrar</a> <br>
        <a class="footer-link" href="https://redatudo.online/programa-de-afiliados">Afiliados</a>
      </div>
    </div>
    <!-- LOGO EM OFF (adicione se quiser): 
    <div class="row">
      <div class="col text-center py-2">
        <img src="https://redatudo.online/wp-content/uploads/2024/08/logotype2.png" alt="logo Redatudo" width="56" height="56" style="filter:drop-shadow(0 3px 24px #00bfff44); border-radius:18px;opacity:.87;">
      </div>
    </div>
    -->
  </div>
</footer>
<script src="https://kit.fontawesome.com/60a0b1cd18.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  var applePayButton = document.getElementById('apple-pay-button');
  if (applePayButton) {
    applePayButton.setAttribute('buttonstyle', 'white'); // muda de black para white
  }
});


document.addEventListener('DOMContentLoaded', function() {
    // Versão otimizada e testada
    function handleCountryChange() {
        const country = jQuery('#billing_country').val();
        const cpfField = jQuery('#billing_cpf_field');
        const cpfInput = jQuery('#billing_cpf');
        
        if (!cpfField || !cpfInput) return;

        if (country === 'BR') {
            cpfField.slideDown(200);
            cpfInput.prop('required', true)
                   .attr('data-required', 'true');
        } else {
            cpfField.stop(true, true).slideUp(200, function() {
                jQuery(this).css('display', 'none'); // Garante display:none após animação
            });
            cpfInput.prop('required', false)
                   .removeAttr('data-required')
                   .val('');
        }
    }

    // 1. Evento nativo do WooCommerce
    jQuery(document.body).on('country_to_state_changed', handleCountryChange);

    // 2. Observer para o elemento visual
    const countryDisplay = document.querySelector('#select2-billing_country-container');
    if (countryDisplay) {
        new MutationObserver(handleCountryChange).observe(countryDisplay, {
            childList: true,
            subtree: true
        });
    }

    // 3. Disparador manual como fallback
    jQuery(document).ajaxComplete(function() {
        setTimeout(handleCountryChange, 100);
    });

    // Executa imediatamente
    handleCountryChange();
});


// Evita que links âncora redirecionem para a raiz
document.addEventListener('click', function(e) {
  if (e.target.tagName === 'A' && e.target.getAttribute('href').startsWith('#')) {
    e.preventDefault();
    const targetId = e.target.getAttribute('href');
    const targetElement = document.querySelector(targetId);
    if (targetElement) {
      targetElement.scrollIntoView({ behavior: 'smooth' });
    }
  }
});
</script>

<?php wp_footer(); ?>
</body>
</html>