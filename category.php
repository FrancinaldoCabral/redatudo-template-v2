<?php get_header(); ?>

<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700&display=swap" rel="stylesheet">

<style>
/* ------ GRID TAG / CATEGORY ------ */

.tag-grid-wrap {
    display: grid;
    grid-template-columns: 3fr 1.15fr;
    gap: 2.6vw;
    max-width: 1200px;
    margin: 40px auto 0;
    padding: 0 10px 48px 10px;
}
@media (max-width: 991px) {
    .tag-grid-wrap { grid-template-columns: 1fr; max-width: 98vw; gap: 0; }
}

/* ------ MAIN CONTENT ------ */

.tag-main-content {
    background: rgba(23, 23, 39, 0.98);
    border-radius: 28px;
    box-shadow: 0 4px 50px #00bfff18, 0 1px 3px #7f00ff16;
    padding: 48px 40px 36px 40px;
    min-width: 0;
    overflow: visible;
    position: relative;
    z-index: 1;
}
@media (max-width: 600px) {
    .tag-main-content { padding: 19px 5vw 26px 5vw; border-radius: 12px; }
}
.tag-main-content > *:not(:last-child) { margin-bottom: 2.4em; }

/* ------ TÍTULOS, METADADOS E BREADCRUMB ------ */

.tag-title {
    font-family: 'Orbitron', Arial, sans-serif;
    font-size: 2rem; font-weight: 800;
    text-transform: uppercase; letter-spacing:1.3px;
    background: linear-gradient(90deg,#00ffd0,#7f00ff 80%);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    margin-bottom: .5em;
    text-align: left;
}
.tag-description {
    color: #b8e6ff; font-size: 1.12rem;
    margin-bottom: 1.2em;
    font-family: 'Orbitron', Arial, sans-serif;
}
.tag-meta {
    color: #b8e6ff;
    font-size: 1rem;
    margin-bottom: 2.2em;
    font-family: 'Orbitron', Arial, sans-serif;
}
.tag-breadcrumb {
    font-size: 0.94em;
    color: #b8e6ff;
    margin-bottom: 22px;
    font-family: 'Orbitron', Arial, sans-serif;
}
.tag-breadcrumb a { color:#00ffd0; }
.tag-breadcrumb span { color:#fff; }

/* ------ CTA destacado/banner ------ */
.banner-cta-home {
    background:linear-gradient(100deg,#7f00ff 60%,#00bfff 98%);
    color:#fff; border-radius: 20px; box-shadow: 0 4px 22px #00bfff23, 0 2px 6px #7f00ff21;
    display:flex; align-items:center; gap:1.05em; font-size:1.13em;
    font-family: 'Orbitron', Arial, sans-serif;
    padding:1.18em 1em; margin-bottom:2.1em; justify-content:center;
}
.banner-cta-home .cta-link {
    background:#101022; color:#00ffd0; font-size:1.1em;
    padding:.8em 2em; margin-left:1.1em; border-radius:13px; text-decoration:none;
    transition: background .15s;
}
.banner-cta-home .cta-link:hover { background: #1efeb7; color: #181733; }

/* ------ LISTA GRID DE POSTS ------ */

.tag-post-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px,1fr));
    gap: 2.1em 1.7em;
}
@media (max-width:600px){ .tag-post-grid {grid-template-columns:1fr;} }

/* ------ CARD DE POST NO GRID ------ */

.tag-post-card {
    background: linear-gradient(102deg, #21213a 80%, #191239 100%);
    border-radius: 18px;
    box-shadow: 0 2px 18px #7f00ff16;
    overflow: hidden;
    transition: box-shadow .20s, transform .20s;
    display: flex; flex-direction: column;
    padding: 0 0 1.7em 0;
    position:relative;
    justify-content: space-between;
}
.tag-post-card:hover {
    box-shadow: 0 8px 34px #00bfff33, 0 1px 4px #7f00ff28;
    transform: translateY(-7px) scale(1.022);
}
.tag-post-thumb {
    width: 100%; height: 190px;
    object-fit: cover;
    border-radius: 18px 18px 0 0;
    box-shadow: 0 3px 16px #7f00ff23;
    background: #101022 url('https://redatudo-pt-storage-pull-zone.b-cdn.net/thumb-replace-ai.jpg') center center/cover no-repeat;
}
@media(max-width:991px){.tag-post-thumb{height:140px;}}

.tag-post-content { padding: 1.2em 1.3em .6em 1.3em; }
.tag-post-title {
    font-family: 'Orbitron', Arial, sans-serif;
    font-size: 1.22rem;
    color: #00ffd0;
    margin-bottom: 0.5em;
    font-weight: bold;
    min-height: 38px;
    letter-spacing:.4px;
}
.tag-post-title a { color:inherit; text-decoration:none; }
.tag-post-meta {
    font-size: .95em; color:#b8e6ff;
    margin-bottom: 0.6em;
    display:flex; gap:7px; align-items: center; flex-wrap:wrap;
}
.tag-post-desc {
    color: #ebefff; font-size: 1.08em;
    margin-bottom: 1.2em; font-family: Arial, sans-serif;
    min-height: 44px;
}
.tag-post-tags {
    display: flex; flex-wrap: wrap; gap:7px;
    margin-bottom: 0.8em;
}
.tag-post-cat{
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
.tag-post-tag{
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

.tag-post-link {
    display: inline-block;
    background: linear-gradient(90deg,#00bfff,#7f00ff 90%);
    color:#fff !important;
    font-family:'Orbitron'; font-weight:bold;
    padding: .57em 1.4em 0.53em 1.4em;
    border-radius:12px;
    margin-bottom: 0.16em;
    box-shadow: 0 2px 13px #00ffd030;
    font-size: 1.08em;
    transition: transform .14s, box-shadow .17s;
    text-decoration: none;
}
.tag-post-link:hover {
    background: linear-gradient(90deg,#00ffd0,#7f00ff 90%);
    color: #222 !important;
    transform: scale(1.06) translateY(-2px);
}

/* Badge destaque do card */
.tag-badge-destaque {
    position:absolute;top:8px; right:14px;
    background: linear-gradient(90deg,#00ffd0,#7f00ff);
    color: #222; font-size: .89em; font-weight: bold;
    font-family: 'Orbitron', Arial, sans-serif;
    padding:.23em .86em; border-radius:10px;
    z-index:8; text-transform:uppercase;
    letter-spacing:.88px;
}
.tag-no-posts {
    color: #00ffd0;
    font-size: 1.17em;
    font-family: 'Orbitron', Arial, sans-serif;
    margin-bottom: 2.7em; text-align:center;
}

/* ------ NEWSLETTER ------ */
.newsletter-box {
    background: rgba(34,39,84,0.95);
    margin:2.2em 0 2em 0;
    padding:1.5em 1.2em;
    border-radius:13px;
    text-align:center;
    color:#fff;
}
.newsletter-box .headline{
    font-family:'Orbitron'; font-size:1.1em; font-weight:bolder; margin-bottom:1em;
}
.newsletter-box form {
    display:flex;justify-content:center;gap:9px;flex-wrap:wrap;
}
.newsletter-box input[type=email]{
    background:#10122e; color:#00ffd0; font-family:'Orbitron';
    border-radius:10px 0 0 10px; padding:.55em 1em; border:none;
}
.newsletter-box button {
    background:linear-gradient(90deg,#7f00ff,#00ffd0 60%);
    color:#fff; font-family:'Orbitron';
    border-radius:0 10px 10px 0; padding:.53em 2em; border:none; font-weight:bold;
    transition: background .17s;
}
.newsletter-box button:hover {
    background:linear-gradient(100deg,#00ffd0,#7f00ff);
}

/* ------ SIDEBAR ------ */
.sidebar-post-content {
    margin-top: 0; margin-bottom:2vw;
    padding-top: 0;
    position: sticky; top: 30px; z-index:2;
    display: flex; flex-direction: column; gap: 0.96em;
}
@media (max-width:991px){
    .sidebar-post-content { position:unset; top:unset; margin-top:30px; }
}

/* Blocos */
.sidebar-section {
    background: rgba(29, 40, 70, 0.97);
    border-radius: 18px;
    box-shadow: 0 2px 10px #7f00ff14;
    margin-bottom: 0px;
    padding: 1em 1.1em 1.32em 1.13em;
    color: #fff;
}
.sidebar-section .sidebar-title {
    font-family: 'Orbitron', Arial, sans-serif;
    text-transform:uppercase;
    font-size:1.07em; color:#b8e6ff; margin-bottom:.6em;
    font-weight:bold; letter-spacing:1.2px;
}

/* Busca */
.widget-search form { display: flex; align-items: stretch; gap:0; }
.widget-search input[type="text"] {
    width: 100%; border-radius: 9px 0 0 9px; background: #161234;
    color: #00ffd0; border: none; padding: .44em 1em; font-size:1em;
}
.widget-search button {
    border-radius: 0 9px 9px 0; margin-left: 0; font-weight:bold; cursor:pointer;
    padding: .41em 1em; background: linear-gradient(90deg,#00bfff,#7f00ff 95%);
    color: #fff; font-family:'Orbitron';
    transition: background .15s;
}
.widget-search button:hover { background: linear-gradient(90deg,#7f00ff,#00ffd0 80%); }

/* Destacado: cards-produto */
.prod-card {
    background: linear-gradient(104deg, #21213a 70%, #231c56 100%);
    border-radius: 15px; box-shadow: 0 2px 12px #00bfff22;
    color: #b8e6ff; font-family: 'Orbitron', Arial, sans-serif;
    margin-bottom: 16px; padding: 1.11em 1.1em; text-align: center;
}
.prod-card .badge-destaque {
    background: linear-gradient(90deg,#00ffd0,#7f00ff); color: #fff !important;
    font-size: .85em; border-radius: 10px; padding: .2em 1em;
    text-transform: uppercase; font-weight: bold; margin-bottom: 0.5em;
    letter-spacing: .8px; margin-top: -1.3em; display: inline-block;
}
.prod-card .prod-icon { font-size: 2.25em; margin-bottom: .2em; }
.prod-card .prod-titulo { font-size: 1.12em; font-weight: bold; color: #00ffd0; margin-bottom: .5em; }
.prod-card .prod-desc { font-size: 0.92em; margin-bottom: 0.9em; }
.prod-card .cta-link { font-size: 0.98em; padding: .36em 1.1em; color:#00ffd0 !important; }
.prod-card .cta-link:hover { color: #fff !important; background: #00ffd030; }

/* LISTAS de categorias/tags no sidebar */
.sidebar-list-cats, .sidebar-list-tags {display:flex;flex-wrap:wrap;gap:6px 10px;}
.sidebar-cat, .sidebar-tag {
    display:inline-block; border-radius:11px; padding:.21em .75em; margin-bottom:.2em;
    font-family:'Orbitron'; font-size:0.91em; text-decoration:none; transition:background .17s;
}
.sidebar-cat { background:linear-gradient(90deg,#7f00ff90,#00bfff90 80%); color:#fff!important; }
.sidebar-cat,.sidebar-tag {  display: inline-block;
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
  letter-spacing: 0.1px;}

.sidebar-cat:hover,.sidebar-tag:hover {  background: #232948;
  color: #00ffd0;
  box-shadow: 0 1px 4px #00ffd013;}
/* Destaques do sidebar (posts importantes) */
.sidebar-highlights-card {
    border-left:5px solid #00ffd0; padding:0 .7em .1em 1em;
    background:rgba(0,255,208,0.06); border-radius:13px; margin-bottom:1em;
}
.sidebar-highlights-card .sidebar-title { color:#00ffd0; margin-bottom:.3em; font-size:1em; }
.sidebar-highlights-list { list-style:none; margin:0; padding:0; }
.sidebar-highlights-list li { margin-bottom:.61em; }
.sidebar-highlights-list a { color:#fff!important; font-family:'Orbitron'; font-size:0.97em; }
.sidebar-highlights-list a:hover { color:#00ffd0!important; text-decoration:underline; }

/* Social widget */
.widget-socials { margin-bottom:16px; text-align:center; }
.social-link { margin-right:.45em; font-size:1.35em; color:#b8e6ff!important; }
.social-link:hover { color:#00ffd0 !important; }

/* Widgets stars, testimonials, sticky ad */
.widget-star-block{margin-bottom: 15px;font-size:.97em;text-align:center;}
.widget-star-block .star{color:gold;font-size:1.15em;}
.widget-testimonial {font-size:.98em;margin-bottom:16px;font-style:italic;color:#b8e6ff;text-align:center;}
.sidebar-sticky-ad {
    position: sticky; top: 24px; z-index: 99; background: none; box-shadow: none;
    max-width: 100%; margin: 0; padding: 0;
}
@media(max-width:991px){ .sidebar-sticky-ad {max-width:96vw;} }

/* ------ SUMÁRIO (TOC) ------ */
#toc-sidebar { margin-bottom:1.8em; }
#toc-sidebar .toc-title {
    font-family: 'Orbitron', Arial, sans-serif; color: #00ffd0;
    font-size: 1.08em; margin-bottom: 1em;
    font-weight: bold; letter-spacing: 1px;
}
#toc-sidebar ul { padding-left: 1.2em; margin: 0; }
#toc-sidebar ul li { padding-bottom: .36em; font-size: 1em; }
#toc-sidebar a { color: #00ffd0; text-decoration:none; }
#toc-sidebar a:hover { color: #7f00ff; text-decoration:underline; }
@media(max-width:991px){ #toc-sidebar {display:none;} }

a, a:visited { color:#00ffd0; text-decoration: none; }
a:hover { color:#7f00ff; }


</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-8 text-center bg-transparent">
            <ins class="adsbygoogle"
                style="display:block; max-height:80px; max-width: 800px"
                data-ad-client="ca-pub-9848635946946970"
                data-ad-slot="6614303361"
                data-ad-format="horizontal"
                data-full-width-responsive="true"></ins>
            <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
        </div>
    </div>
</div>

<div class="tag-grid-wrap">
    <main class="tag-main-content">

        <!-- Breadcrumb -->
        <nav class="tag-breadcrumb" aria-label="breadcrumb">
            <a href="<?php echo esc_url(home_url()); ?>">Início</a> &raquo; <span><?php single_tag_title(); ?></span>
        </nav>

        <h1 class="tag-title"><?php single_tag_title('#'); ?></h1>
        <?php if (tag_description()): ?>
            <div class="tag-description"><?php echo tag_description(); ?></div>
        <?php endif; ?>
        <div class="tag-meta">
            <?php
            $tag = get_queried_object();
            $count = $tag && isset($tag->count) ? intval($tag->count) : 0;
            echo $count . ' artigo' . ($count!=1?'s':'') . ' encontrados';
            ?>
        </div>

        <!-- Banner/CTA destacado -->
        <div class="banner-cta-home" style="background:linear-gradient(100deg,#7f00ff 60%,#00bfff 98%);
                color:#fff; border-radius: 20px; box-shadow: 0 4px 22px #00bfff23, 0 2px 6px #7f00ff21;
                display:flex; align-items:center; gap:1.05em; font-size:1.13em; font-family: 'Orbitron', Arial, sans-serif;
                padding:1.18em 1em; margin-bottom:2.1em;justify-content:center;">
            <span style="font-size:1.44em;">🚀</span>
            <span><b>Redatudo: todo poder da IA em conteúdo & ebooks!</b><br>Clique para explorar recursos AI que viralizam seu conteúdo.</span>
            <a class="cta-link" href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>?login_app=chat" style="background:#101022;color:#00ffd0;font-size:1.1em;padding:.8em 2em;margin-left:1.1em;border-radius:13px;text-decoration:none;">Testar Grátis</a>
        </div>

        <!-- Listagem dos posts da tag -->
        <?php if (have_posts()): ?>
        <div class="tag-post-grid">
            <?php $i=0; while (have_posts()): the_post(); $i++; ?>
                <article class="tag-post-card">
                    <?php if(has_post_thumbnail()): ?>
                        <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('medium_large', ['class'=>'tag-post-thumb','alt'=>get_the_title()]); ?>
                        </a>
                    <?php else: ?>
                        <a href="<?php the_permalink(); ?>">
                        <div class="tag-post-thumb"></div>
                        </a>
                    <?php endif; ?>
                    <div class="tag-post-content">
                        <!-- Badge Destaque (Exemplo: primeira ou sticky ou destaque do loop) -->
                        <?php if($i==1): ?>
                            <span class="tag-badge-destaque">DESTAQUE</span>
                        <?php endif; ?>
                        <div class="tag-post-title">
                            <a href="<?php the_permalink(); ?>" style="color:inherit;"><?= get_the_title(); ?></a>
                        </div>
                        <div class="tag-post-meta">
                            <span>⏱️ 
                                <?php
                                    $words = str_word_count(strip_tags(strip_shortcodes(get_the_content())));
                                    $minutes = ceil($words/220);
                                    echo $minutes." min";
                                ?>
                            </span>
                            <span>|</span>
                            <span>📅 <?php echo get_the_date(); ?></span>
                            <span>|</span>
                            <span>Por: <?php the_author(); ?></span>
                        </div>
                        <div class="tag-post-desc">
                            <?php the_excerpt(); ?>
                        </div>
                        <div class="tag-post-tags">
                            <?php
                            foreach (get_the_category() as $c) {
                                printf('<a class="tag-post-cat" href="%s">%s</a>', esc_url(get_category_link($c->term_id)), esc_html($c->cat_name));
                            }
                            $tags = get_the_tags();
                            if($tags) foreach($tags as $tagx) {
                                printf('<a class="tag-post-tag" href="%s">#%s</a>', esc_url(get_tag_link($tagx->term_id)), esc_html($tagx->name));
                            }
                            ?>
                        </div>
                        <a class="tag-post-link" href="<?php the_permalink(); ?>">Ler artigo &raquo;</a>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>

        <div style="margin-top:2.2em;">
            <?php the_posts_pagination( array(
                'mid_size' => 2,
                'prev_text' => __('&laquo; Anterior'),
                'next_text' => __('Próxima &raquo;'),
                'screen_reader_text'=> 'Paginação'
            ) ); ?>
        </div>
        <?php else: ?>
            <div class="tag-no-posts">Ainda não há artigos com esta tag.<br>
                <a href="<?php echo esc_url( home_url('/blog/') ); ?>" style="color:#00ffd0;">Ver todos os artigos</a>
            </div>
        <?php endif; ?>

        <!-- Newsletter -->
        <div class="newsletter-box">
            <div class="headline">Receba dicas, guias e novidades AI!</div>
            <form action="#" method="post">
                <input type="email" name="email" placeholder="Seu melhor e-mail" required autocomplete="off"/>
                <button type="submit">Assinar grátis</button>
            </form>
        </div>

        <!-- AdSense -->
        <div style="margin:38px 0;">
            <ins class="adsbygoogle"
                style="display:block"
                data-ad-format="fluid"
                data-ad-layout-key="-6t+ed+2i-1n-4w"
                data-ad-client="ca-pub-9848635946946970"
                data-ad-slot="3634946494"></ins>
            <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
        </div>
    </main>

    <!-- SIDEBAR -->
    <aside class="sidebar-post-content">

        <!-- Pesquisa -->
        <div class="sidebar-section widget-search">
            <form role="search" method="get" id="searchform" action="<?php echo home_url('/'); ?>">
                <input type="text" placeholder="Pesquisar..." name="s" value=""/>
                <button type="submit">🔎</button>
            </form>
        </div>

        <!-- SUMÁRIO -->
        <section id="toc-sidebar" class="sidebar-section" style="display:none;">
            <div class="toc-title">Neste artigo</div>
            <div id="toc-list"></div>
        </section>

        <div class="sidebar-section">
            <!-- in article -->
            <ins class="adsbygoogle"
                style="display:block; text-align:center;"
                data-ad-layout="in-article"
                data-ad-format="fluid"
                data-ad-client="ca-pub-9848635946946970"
                data-ad-slot="9129211091"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>

        <!-- PRODUTOS PRINCIPAIS -->
        <div class="prod-card">
            <div class="badge-destaque">LANÇAMENTO</div>
            <div class="prod-icon">💬</div>
            <div class="prod-titulo">Agente WhatsApp</div>
            <div class="prod-desc">Atendimento automatizado e geração de conteúdo IA via WhatsApp.</div>
            <a href="<?php echo home_url(); ?>" class="cta-link">Quero testar 🚀</a>
        </div>
        <div class="prod-card">
            <div class="prod-icon">🤖</div>
            <div class="prod-titulo">AI Assistant</div>
            <div class="prod-desc">Crie textos, ebooks, imagens, vídeos e voz com IA top de linha.</div>
            <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>?login_app=chat" class="cta-link">Testar Grátis</a>
        </div>
        <div class="prod-card">
            <div class="prod-icon">📘</div>
            <div class="prod-titulo">Gerador de Ebook</div>
            <div class="prod-desc">Gere ebooks completos a partir de um tema, pronto para publicar!</div>
            <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>?login_app=chat" class="cta-link">Gerar ebook</a>
        </div>
        <!-- Destaques -->
        <div class="sidebar-highlights-card">
            <div class="sidebar-title">Destaques Redatudo</div>
            <ul class="sidebar-highlights-list">
                <?php
                $high = new WP_Query([
                    'posts_per_page'=>3,'ignore_sticky_posts'=>0,
                    'meta_query'=>[['key'=>'_is_ns_featured_post','compare'=>'EXISTS']]
                ]);
                if(!$high->have_posts()){$high=new WP_Query(['posts_per_page'=>3,'tag'=>'destaque']);}
                if($high->have_posts()) while($high->have_posts()){ $high->the_post(); ?>
                <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                <?php } wp_reset_postdata(); ?>
            </ul>
        </div>
        <!-- Posts mais lidos -->
        <div class="sidebar-section">
            <div class="sidebar-title">Mais Lidos</div>
            <ul class="sidebar-highlights-list">
                <?php
                $pop = new WP_Query(['posts_per_page'=>3, 'orderby'=>'comment_count','order'=>'DESC','ignore_sticky_posts'=>true]);
                while($pop->have_posts()){ $pop->the_post(); ?>
                <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                <?php } wp_reset_postdata(); ?>
            </ul>
        </div>
        <div class="sidebar-section" style="margin-bottom:10px;">
            <!-- novo_layout - display - quadrado 01 -->
            <ins class="adsbygoogle"
                style="display:block"
                data-ad-client="ca-pub-9848635946946970"
                data-ad-slot="1391926533"
                data-ad-format="square"
                data-full-width-responsive="true"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>
        <!-- Posts recentes -->
        <div class="sidebar-section">
            <div class="sidebar-title">Recentes</div>
            <ul class="sidebar-highlights-list">
                <?php
                $recent = new WP_Query(['posts_per_page'=>3, 'orderby'=>'date','order'=>'DESC','ignore_sticky_posts'=>true]);
                while($recent->have_posts()){ $recent->the_post(); ?>
                <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                <?php } wp_reset_postdata(); ?>
            </ul>
        </div>
        <!-- Últimos comentários -->
        <div class="sidebar-section">
            <div class="sidebar-title">Novos Comentários</div>
            <ul class="sidebar-highlights-list">
                <?php
                $comments = get_comments(['number'=>3,'status'=>'approve']);
                foreach($comments as $com){ ?>
                <li>
                    <span style="color:#00ffd0;font-size:.97em;">“</span>
                    <?php echo esc_html(wp_trim_words($com->comment_content,10)); ?>...
                    <a href="<?php echo get_comment_link($com); ?>" style="color:#00bfff;">ver</a>
                </li>
                <?php } ?>
            </ul>
        </div>
        <div class="sidebar-section" style="margin-bottom:10px;">
            <!-- novo layout - infeed só texto - lateral -->
            <ins class="adsbygoogle"
                style="display:block"
                data-ad-format="fluid"
                data-ad-layout-key="-gw-3+1f-3d+2z"
                data-ad-client="ca-pub-9848635946946970"
                data-ad-slot="2459860964"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>
        <!-- Socials -->
        <div class="sidebar-section widget-socials" style="text-align:center;">
            <div class="sidebar-title">Redes Redatudo</div>
            <a href="https://mastodon.social/@redatudo" class="social-link" title="Mastodon"><span style="font-size:medium;"> <i class="bi bi-mastodon"></i>Mastodon</span></a> <br>
            <a href="https://www.linkedin.com/in/naldo-cabral-60377b331/" class="social-link" title="Linkedin"><span style="font-size:medium;"> <i class="bi bi-linkedin"></i>LinkedIn</span></a> <br>
            <a href="https://www.threads.net/@cabral.redatudo" class="social-link" title="Threads"><span style="font-size:medium;"> <i class="bi bi-threads"></i>Threads</span></a> <br>
            <a href="https://www.facebook.com/redatudo.oficial/#" class="social-link" title="Facebook"><span style="font-size:medium;"> <i class="bi bi-facebook"></i>Facebook</span></a> <br>
        </div>
        <!-- Widget estrela -->
        <div class="sidebar-section widget-star-block">
            <span class="star">★ ★ ★ ★ ★</span>
            <div>4.9/5 baseado em avaliações dos usuários</div>
        </div>
        <!-- Widget depoimento -->
        <div class="sidebar-section widget-testimonial">
            “Com o Redatudo economizei mais de 10 horas por semana!”
            <div style="font-style:normal;font-weight:bold;color:#00ffd0;">— Cliente Entusiasmado</div>
        </div>
        <!-- Categorias -->
        <div class="sidebar-section">
            <div class="sidebar-title">Categorias</div>
            <div class="sidebar-list-cats">
            <?php
                $cats = get_terms(['taxonomy'=>'category','hide_empty'=>false,'number'=>10,'orderby'=>'count','order'=>'DESC']);
                foreach($cats as $cat): ?>
                <a href="<?php echo get_category_link($cat->term_id);?>" class="sidebar-cat"><?php echo $cat->name;?></a>
            <?php endforeach;?>
            </div>
        </div>
        <!-- Tags -->
        <div class="sidebar-section">
            <div class="sidebar-title">Tags</div>
            <div class="sidebar-list-tags">
            <?php
                $tags = get_terms(['taxonomy'=>'post_tag','hide_empty'=>false,'number'=>18]);
                foreach($tags as $tag): ?>
                <a href="<?php echo get_tag_link($tag->term_id);?>" class="sidebar-tag"><?php echo "#".$tag->name;?></a>
            <?php endforeach;?>
            </div>
        </div>
        <!-- Banner premium/recursos -->
        <div class="sidebar-section" style="margin-bottom:10px;">
            <div class="sidebar-title">Acesso Premium & Recursos</div>
            <div class="ad-sticker-fallback" style="margin-bottom:8px;color:#fff;">
                <b>✨ Liberte o poder da IA:</b> <br>
                <a href="<?php echo home_url(); ?>/#precos" style="color:#00ffd0 !important;font-weight:bold;">Conheça os planos Pro &raquo;</a>
            </div>
        </div>
        <!-- AdSense sticky final da sidebar -->
        <div class="sidebar-sticky-ad">
            <!-- novo layout - display vertical 01 -->
            <ins class="adsbygoogle"
                style="display:block"
                data-ad-client="ca-pub-9848635946946970"
                data-ad-slot="1373175853"
                data-ad-format="vertical"
                data-full-width-responsive="true"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>
    </aside>
</div>

<!-- SUMÁRIO/TOC: Se houver posts longos (Headers) -->
<script>
document.addEventListener("DOMContentLoaded",function(){
    var grid = document.querySelector('.tag-post-grid');
    // adaptar se quiser gerar um TOC por post do loop, mas não inclui em grid.
    // Sugere-se TOC apenas no conteúdo de single e posts de destaque, não em grid aqui
});
</script>

<?php get_footer(); ?>