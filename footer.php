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
        <a class="footer-link" href="<?php echo esc_url(redatudo_get_app_url('hub')); ?>">Entrar</a> <br>
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

<!-- ── GA4 Semantic Event Tracking ── -->
<script>
(function () {
  'use strict';

  // Wrapper seguro para GA4 via Site Kit
  // Não usa send_to: evita descartar eventos por ID inválido
  // Usa dataLayer como fallback se gtag ainda não estiver pronto
  function rdGA4(eventName, params) {
    var p = Object.assign({}, params || {});
    if (typeof window.gtag === 'function') {
      window.gtag('event', eventName, p);
    } else {
      // Site Kit ainda carregando: empurra via dataLayer
      window.dataLayer = window.dataLayer || [];
      window.dataLayer.push(Object.assign({ event: eventName }, p));
    }
  }

  // ── Helpers ────────────────────────────────────────────────────────────
  function getPlacement(el) {
    if (el.closest('header, .navbar, nav')) return 'header';
    if (el.closest('.hero, .banner-cta-home, [class*="hero"]')) return 'hero';
    if (el.closest('.sidebar-post-content, aside')) return 'sidebar';
    if (el.closest('footer, .site-footer')) return 'footer';
    if (el.closest('.tool-highlight-card')) return 'sidebar_tool_card';
    if (el.closest('.rdtd-affiliate-ad')) return 'affiliate_ad';
    return 'main';
  }

  function getPageType() {
    var b = document.body;
    if (b.classList.contains('single-post')) return 'post';
    if (b.classList.contains('category') || b.classList.contains('tag')) return 'archive';
    if (b.classList.contains('home') || b.classList.contains('blog')) return 'home';
    if (b.classList.contains('page')) return 'page';
    return 'other';
  }

  var PAGE_TYPE = getPageType();

  // ── 1. Handler genérico via data-ga4 ───────────────────────────────────
  // Qualquer elemento com data-ga4="nome_do_evento" dispara automaticamente.
  // Parâmetros extras em data-ga4-* (ex: data-ga4-placement="sidebar")
  document.addEventListener('click', function (e) {
    var el = e.target.closest('[data-ga4]');
    if (!el) return;
    var eventName = el.getAttribute('data-ga4');
    if (eventName === 'affiliate_impression') return; // impressão é por IntersectionObserver
    var params = { page_type: PAGE_TYPE };
    for (var i = 0; i < el.attributes.length; i++) {
      var attr = el.attributes[i];
      if (attr.name.startsWith('data-ga4-')) {
        var key = attr.name.slice(9).replace(/-/g, '_');
        params[key] = attr.value;
      }
    }
    if (eventName === 'affiliate_click') params.outbound = true;
    rdGA4(eventName, params);
  });

  // ── 2. Clicks em links de apps Redatudo ────────────────────────────────
  // Detecta qualquer href para *.redatudo.online e dispara app_link_click
  // com app_name, tool_name e placement.
  document.addEventListener('click', function (e) {
    var link = e.target.closest('a[href]');
    if (!link) return;
    var href = link.getAttribute('href') || '';
    if (!href.includes('.redatudo.online')) return;
    if (link.hasAttribute('data-ga4')) return; // já tratado acima

    var m = href.match(/https?:\/\/([^.]+)\.redatudo\.online/);
    var appName = m ? m[1] : 'unknown';
    var toolText = (link.textContent || '').replace(/[^\w\sÀ-ÿ]/gu, '').trim().slice(0, 60);

    rdGA4('app_link_click', {
      app_name:  appName,
      tool_name: toolText || appName,
      placement: getPlacement(link),
      page_type: PAGE_TYPE,
    });
  });

  // ── 3. Clicks em CTAs principais ───────────────────────────────────────
  document.addEventListener('click', function (e) {
    var btn = e.target.closest('.btn-primary, .cta-link, .tool-highlight-link');
    if (!btn) return;
    if (btn.hasAttribute('data-ga4')) return;
    if ((btn.getAttribute('href') || '').includes('.redatudo.online')) return; // já coberto acima
    rdGA4('cta_click', {
      cta_text:  (btn.textContent || '').trim().slice(0, 60),
      placement: getPlacement(btn),
      page_type: PAGE_TYPE,
    });
  });

  // ── 4. Botão de login / Entrar ─────────────────────────────────────────
  var loginBtn = document.getElementById('btnEntrar');
  if (loginBtn) {
    loginBtn.addEventListener('click', function () {
      rdGA4('login_intent', {
        source_path: window.location.pathname,
        page_type:   PAGE_TYPE,
      });
    });
  }

  // ── 5. Busca interna ───────────────────────────────────────────────────
  document.querySelectorAll('#searchform, form[role="search"]').forEach(function (form) {
    form.addEventListener('submit', function () {
      var q = form.querySelector('input[name="s"]');
      rdGA4('search', {
        search_term: q ? q.value.trim().slice(0, 100) : '',
        source:      'site_search',
        page_type:   PAGE_TYPE,
      });
    });
  });

  // ── 6. Links sociais ───────────────────────────────────────────────────
  document.addEventListener('click', function (e) {
    var link = e.target.closest('a.social-link, .widget-socials a');
    if (!link) return;
    var h = link.getAttribute('href') || '';
    var network = h.includes('linkedin') ? 'linkedin'
      : h.includes('facebook')  ? 'facebook'
      : h.includes('instagram') ? 'instagram'
      : h.includes('mastodon')  ? 'mastodon'
      : h.includes('threads')   ? 'threads'
      : (h.includes('twitter') || h.includes('x.com')) ? 'twitter'
      : 'other';
    rdGA4('social_click', { social_network: network, page_type: PAGE_TYPE });
  });

  // ── 7. Impressão de cards afiliados (IntersectionObserver) ─────────────
  if ('IntersectionObserver' in window) {
    var seen = new Set();
    var observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        var el  = entry.target;
        var uid = el.id || el.getAttribute('data-ga4-placement') || Math.random();
        if (seen.has(uid)) return;
        seen.add(uid);
        rdGA4('affiliate_impression', {
          ad_placement: el.getAttribute('data-ga4-placement') || '',
          ad_product:   el.getAttribute('data-ga4-product')   || '',
          page_type:    PAGE_TYPE,
        });
        observer.unobserve(el);
      });
    }, { threshold: 0.5 });

    document.querySelectorAll('[data-ga4="affiliate_impression"]').forEach(function (ad) {
      observer.observe(ad);
    });
  }

  // ── 8. Profundidade de scroll ──────────────────────────────────────────
  var scrollMilestones = [25, 50, 75, 90];
  var scrollFired = {};
  window.addEventListener('scroll', function () {
    var scrolled = Math.round(
      (window.scrollY / (document.body.scrollHeight - window.innerHeight)) * 100
    );
    scrollMilestones.forEach(function (pct) {
      if (!scrollFired[pct] && scrolled >= pct) {
        scrollFired[pct] = true;
        rdGA4('scroll_depth', { percent: pct, page_type: PAGE_TYPE });
      }
    });
  }, { passive: true });

})();
</script>

<!-- ── RDTD Behavioral Tracking → MongoDB ──────────────────────────────────
     Espelha eventos do WordPress para o mesmo MongoDB usado pelos apps.
     visitor_id atravessa domínios via query param ?_rdtd_vid=
     para conectar: post lido → CTA clicado → app aberto → compra.
     ──────────────────────────────────────────────────────────────────── -->
<script>
(function () {
  'use strict';

  var TRACK_URL = 'https://api.redatudo.online/api/track';

  // ── Identity ──────────────────────────────────────────────────────────
  // wp_user_id injetado pelo PHP (wp_head) se estiver logado
  var uid = window._rdtd_uid || null;

  // visitor_id persistente no localStorage — sobrevive a saída/entrada
  // Se veio de um app via ?_rdtd_vid=, herda o mesmo ID (fecha o círculo)
  var incomingVid = new URLSearchParams(window.location.search).get('_rdtd_vid');
  var vid = incomingVid || localStorage.getItem('_rdtd_vid');
  if (!vid) {
    vid = (typeof crypto !== 'undefined' && crypto.randomUUID)
      ? crypto.randomUUID()
      : Math.random().toString(36).slice(2) + Date.now();
  }
  localStorage.setItem('_rdtd_vid', vid);

  // session_id por aba — reseta a cada novo contexto de navegação
  var sid = sessionStorage.getItem('_rdtd_sid');
  if (!sid) {
    sid = (typeof crypto !== 'undefined' && crypto.randomUUID)
      ? crypto.randomUUID()
      : Math.random().toString(36).slice(2) + Date.now();
    sessionStorage.setItem('_rdtd_sid', sid);
  }

  // UTMs da URL atual
  function getUTMs() {
    var p   = new URLSearchParams(window.location.search);
    var out = {};
    ['utm_source', 'utm_medium', 'utm_campaign', 'utm_content', 'utm_term'].forEach(function (k) {
      var v = p.get(k);
      if (v) out[k] = v;
    });
    return out;
  }

  function getPageType() {
    var b = document.body;
    if (b.classList.contains('single-post'))          return 'post';
    if (b.classList.contains('single-product'))       return 'product';
    if (b.classList.contains('category'))             return 'category';
    if (b.classList.contains('tag'))                  return 'tag';
    if (b.classList.contains('home'))                 return 'home';
    if (b.classList.contains('blog'))                 return 'blog';
    if (b.classList.contains('woocommerce-checkout')) return 'checkout';
    if (b.classList.contains('woocommerce-cart'))     return 'cart';
    if (b.classList.contains('page'))                 return 'page';
    return 'other';
  }

  function getPlacement(el) {
    if (el.closest('header, .navbar, nav'))                     return 'header';
    if (el.closest('.hero, .banner-cta-home, [class*="hero"]')) return 'hero';
    if (el.closest('.sidebar-post-content, aside'))             return 'sidebar';
    if (el.closest('footer, .redatudo-footer'))                 return 'footer';
    return 'content';
  }

  // Fire-and-forget — keepalive garante envio mesmo no pagehide/saída
  function rdTrack(event, props) {
    var payload = {
      event:      event,
      wp_user_id: uid,
      source:     'wordpress',
      session_id: sid,
      properties: Object.assign(
        {
          visitor_id: vid,
          url:        window.location.pathname,
          referrer:   document.referrer || '',
          page_type:  PAGE_TYPE,
        },
        getUTMs(),
        props || {}
      ),
    };
    fetch(TRACK_URL, {
      method:    'POST',
      headers:   { 'Content-Type': 'application/json' },
      body:      JSON.stringify(payload),
      keepalive: true,
    }).catch(function () {});
  }

  // Expõe para outros scripts do tema usarem
  window.rdTrack = rdTrack;

  var PAGE_TYPE = getPageType();
  var startTime = Date.now();

  // ── 1. page_view — todas as páginas (blog, home, landing, página estática)
  rdTrack('page_view', {
    title:     document.title.slice(0, 120),
    page_type: PAGE_TYPE,
  });

  // ── 2. post_read — post lido de verdade (75% de scroll)
  //    Dado estratégico: qual conteúdo converte em usuário de app
  if (PAGE_TYPE === 'post') {
    var readFired = false;
    var h1El      = document.querySelector('h1.entry-title, h1');
    var postTitle = h1El ? h1El.textContent.trim().slice(0, 120) : document.title.slice(0, 80);
    var catEl     = document.querySelector('.cat-links a, .entry-categories a, .post-categories a');
    var postCat   = catEl ? catEl.textContent.trim() : '';

    window.addEventListener('scroll', function () {
      if (readFired) return;
      var scrollable = document.body.scrollHeight - window.innerHeight;
      if (scrollable <= 0) return;
      if ((window.scrollY / scrollable) * 100 >= 75) {
        readFired = true;
        rdTrack('post_read', {
          post_title:     postTitle,
          category:       postCat,
          time_to_read_s: Math.round((Date.now() - startTime) / 1000),
        });
      }
    }, { passive: true });
  }

  // ── 3. cta_click — cliques em links para os apps redatudo
  //    IMPORTANTE: appenda ?_rdtd_vid= ao href para o app herdar o visitor_id
  //    Isso fecha o círculo: post lido → CTA → app → compra = mesma pessoa
  document.addEventListener('click', function (e) {
    var link = e.target.closest('a[href]');
    if (!link) return;
    var href = link.getAttribute('href') || '';

    var isAppLink = href.includes('hub.redatudo.online') ||
                    href.includes('app.redatudo.online') ||
                    href.includes('ebook.redatudo.online') ||
                    href.includes('ia.redatudo.online');

    if (isAppLink) {
      // Injeta visitor_id na URL para o app herdar a sessão
      try {
        var url = new URL(href, window.location.origin);
        url.searchParams.set('_rdtd_vid', vid);
        link.setAttribute('href', url.toString());
      } catch (_) {}

      var m       = href.match(/https?:\/\/([^./]+)\.redatudo\.online/);
      var appName = m ? m[1] : 'app';
      rdTrack('cta_click', {
        cta_text:  (link.textContent || '').trim().slice(0, 80),
        app_name:  appName,
        placement: getPlacement(link),
      });
    }
  });

  // ── 4. affiliate_click — saída para link de afiliado externo
  //    Quem clicou + de qual post + qual link = qual parceiro converte mais
  document.addEventListener('click', function (e) {
    var link = e.target.closest('a[href]');
    if (!link) return;
    var href = link.getAttribute('href') || '';

    var isExternal = href.startsWith('http') &&
                     !href.includes('redatudo.online') &&
                     !href.startsWith(window.location.origin);
    var isAffiliate = link.hasAttribute('data-ga4') &&
                      link.getAttribute('data-ga4') === 'affiliate_click';
    // Também captura qualquer link externo mesmo sem data-ga4
    if (!isExternal && !isAffiliate) return;

    rdTrack('affiliate_click', {
      destination:   href.slice(0, 200),
      link_text:     (link.textContent || '').trim().slice(0, 80),
      placement:     getPlacement(link),
      post_title:    PAGE_TYPE === 'post'
        ? (document.querySelector('h1') || {}).textContent || ''
        : '',
    });
  });

  // ── 5. site_search — o que as pessoas buscam no site
  document.querySelectorAll('#searchform, form[role="search"]').forEach(function (form) {
    form.addEventListener('submit', function () {
      var q = form.querySelector('input[name="s"]');
      rdTrack('site_search', {
        search_term: q ? q.value.trim().slice(0, 100) : '',
      });
    });
  });

  // ── 6. time_on_page — ao sair (keepalive garante o envio)
  //    Junto com page_type: "post" indica qual conteúdo tem engajamento real
  window.addEventListener('pagehide', function () {
    var seconds = Math.round((Date.now() - startTime) / 1000);
    if (seconds < 5) return;
    rdTrack('time_on_page', {
      seconds: seconds,
      title:   document.title.slice(0, 80),
    });
  });

  // ── 7. return_visit — visitante recorrente (não logado)
  //    Alta intenção de compra: voltou sem ter comprado ainda
  var visitCount = parseInt(localStorage.getItem('_rdtd_visits') || '0', 10) + 1;
  localStorage.setItem('_rdtd_visits', visitCount);
  if (visitCount === 2) {
    rdTrack('return_visit', { visit_number: visitCount });
  } else if (visitCount > 2 && visitCount % 5 === 0) {
    rdTrack('frequent_visitor', { visit_number: visitCount });
  }

})();
</script>

<?php wp_footer(); ?>

<?php if ( is_single() ) : ?>
<script>
(function(w,d,t,u,n,a,m){w['MauticTrackingObject']=n;
w[n]=w[n]||function(){(w[n].q=w[n].q||[]).push(arguments)},
a=d.createElement(t),m=d.getElementsByTagName(t)[0];
a.async=1;a.src=u;m.parentNode.insertBefore(a,m)
})(window,document,'script','https://conteudo.redatudo.online/mtc.js','mt');
mt('send', 'pageview');
</script>
<?php endif; ?>
</body>
</html>