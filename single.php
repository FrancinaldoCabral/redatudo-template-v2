<?php get_header(); ?>

<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700&display=swap" rel="stylesheet">

<style>
.single-grid-wrap {
    display: grid;
    grid-template-columns: 3fr 1.15fr;
    gap: 2.6vw;
    max-width: 1200px;
    margin: 40px auto 0;
    padding: 0 10px 48px 10px;
}
@media (max-width: 991px) {.single-grid-wrap {grid-template-columns: 1fr;max-width: 98vw;gap: 0;}}

.main-post-content {
    background: rgba(23, 23, 39, 0.98);
    border-radius: 28px;
    box-shadow: 0 4px 50px #00bfff18, 0 1px 3px #7f00ff16;
    padding: 48px 40px 36px 40px;
    min-width: 0;
    overflow: visible;
    position:relative;
    z-index:1;
}
@media (max-width: 600px) { 
    .main-post-content { padding: 19px 5vw 26px 5vw; border-radius:12px;}
}
.main-post-content > *:not(:last-child) { margin-bottom: 2.5em; }

/* SIDEBAR */
.sidebar-post-content {
    margin-top: 0; margin-bottom:2vw;
    padding-top: 0;
    position: sticky; top: 30px; z-index:2;
    display: flex;
    flex-direction: column;
    gap: 0.96em;
}
@media (max-width:991px){
  .sidebar-post-content {position:unset; top:unset; margin-top:30px;}
}
.sidebar-section {
    background: rgba(29, 40, 70, 0.97);
    border-radius: 18px;
    box-shadow: 0 2px 10px #7f00ff14;
    margin-bottom: 0px;
    padding: 1.0em 1.1em 1.32em 1.13em;
    color: #fff;
}
.sidebar-section .sidebar-title {
    font-family: 'Orbitron', Arial, sans-serif; text-transform:uppercase;font-size:1.07em;color:#b8e6ff;margin-bottom:.6em;font-weight:bold;letter-spacing:1.2px;
}
.widget-search form {
    display: flex; align-items: stretch; gap:0;
}
.widget-search input[type="text"] {
    width: 100%;
    border-radius: 9px 0 0 9px;
    background: #161234;
    color: #00ffd0;
    border: none;
    padding: .44em 1em;
    font-size:1em;
}
.widget-search button {
    border-radius: 0 9px 9px 0;
    margin-left: 0;
    font-weight:bold;
    cursor:pointer;
    padding:.41em 1em;
    background: linear-gradient(90deg,#00bfff,#7f00ff 95%);
    color: #fff;
    font-family:'Orbitron';
}
.widget-search button:hover {
    background: linear-gradient(90deg,#7f00ff,#00ffd0 80%);
}
#toc-sidebar, #toc-mobile {margin-bottom:1.8em;}
#toc-sidebar .toc-title, #toc-mobile .toc-title {
    font-family: 'Orbitron', Arial, sans-serif; color: #00ffd0;
    font-size: 1.08em;margin-bottom: 1em;font-weight: bold;letter-spacing: 1px;
}
#toc-sidebar ul, #toc-mobile ul {padding-left: 1.2em; margin: 0;}
#toc-sidebar ul li, #toc-mobile ul li {padding-bottom: .36em; font-size: 1em;}
#toc-sidebar a, #toc-mobile a { color: #00ffd0;text-decoration:none;}
#toc-sidebar a:hover, #toc-mobile a:hover { color: #7f00ff; text-decoration:underline;}
@media(max-width:991px){ #toc-sidebar {display:none;} }
@media(max-width:991px){ #toc-mobile {display:block;} }

/* Product Cards */
.prod-card {background: linear-gradient(104deg, #21213a 70%, #231c56 100%);
    border-radius: 15px;box-shadow: 0 2px 12px #00bfff22;
    color: #b8e6ff;font-family: 'Orbitron', Arial, sans-serif;
    margin-bottom: 16px; padding: 1.11em 1.1em; text-align: center;}
.prod-card .badge-destaque {background: linear-gradient(90deg,#00ffd0,#7f00ff);color: #fff !important; display: inline-block;font-size: .85em;border-radius: 10px;padding: .2em 1em;text-transform: uppercase;font-weight: bold;margin-bottom: 0.5em;letter-spacing: .8px;margin-top: -1.3em;}
.prod-card .prod-icon {font-size: 2.25em;margin-bottom: .2em;}
.prod-card .prod-titulo {font-size: 1.12em;font-weight: bold;color: #00ffd0;margin-bottom: .5em;}
.prod-card .prod-desc {font-size: 0.92em;margin-bottom: 0.9em;}
.prod-card .cta-link {font-size: 0.98em;padding: .36em 1.1em; color:#00ffd0 !important;}
.prod-card .cta-link:hover { color: #fff !important; background: #00ffd030;}
/* Listas tags/categorias */
.sidebar-list-cats, .sidebar-list-tags {display:flex;flex-wrap:wrap;gap:6px 10px;}
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
.sidebar-highlights-card {border-left:5px solid #00ffd0;padding:0 .7em .1em 1em;background:rgba(0,255,208,0.06);border-radius:13px;margin-bottom:1em;}
.sidebar-highlights-card .sidebar-title {color:#00ffd0;margin-bottom:.3em;font-size:1em;}
.sidebar-highlights-list {list-style:none;margin:0;padding:0;}
.sidebar-highlights-list li {margin-bottom:.61em;}
.sidebar-highlights-list a {color:#fff!important;font-family:'Orbitron';font-size:0.97em;}
.sidebar-highlights-list a:hover {color:#00ffd0!important;text-decoration:underline;}
.widget-socials {margin-bottom:16px;}
.social-link {margin-right:.45em;font-size:1.35em; color:#b8e6ff!important;}
.social-link:hover {color:#00ffd0 !important;}
.widget-star-block{margin-bottom: 15px;font-size:.97em;text-align:center;}
.widget-star-block .star{color:gold;font-size:1.15em;}
.widget-testimonial {font-size:.98em;margin-bottom:16px;font-style:italic;color:#b8e6ff;text-align:center;}
.sidebar-section a,
.ad-sticker-fallback a,
a.cta-link {color: #00ffd0 !important;}
/* Sticky Adsense */
.sidebar-sticky-ad {
    position: sticky;
    top: 24px;
    z-index: 99;
    background: none;
    box-shadow: none;
    max-width: 100%;
    margin: 0;
    padding: 0;
}
@media (max-width:991px){
    .sidebar-sticky-ad {max-width:96vw;}
}
/* MAIN TEXT */
.single-title {font-family: 'Orbitron', Arial, sans-serif; font-size: 2.1rem; font-weight: 700; text-transform: uppercase; letter-spacing:1.3px;background: linear-gradient(90deg,#7f00ff,#00bfff 80%);-webkit-background-clip: text; -webkit-text-fill-color: transparent; margin-bottom: .6em;}
.readmeta-box, .single-meta {color: #b8e6ff;font-size: 1.04rem; margin-bottom: 1.1em;display:flex;flex-wrap:wrap;gap:1em;align-items:center;}
.single-tags-cats {display:flex;flex-wrap:wrap;gap:7px 18px;margin-bottom:2.1em;}
.single-cat {background:linear-gradient(90deg,#7f00ff,#00bfff 60%);color:#fff;font-family:'Orbitron';border-radius:13px;padding:.18em .85em;font-size:0.98em;}
.single-tag {background:linear-gradient(90deg,#00ffd0,#7f00ff 60%);color:#181216;font-family:'Orbitron';border-radius:13px;padding:.18em .7em;font-size:0.93em;}
.single-content {color: #eceff9;font-size: 1.15rem;line-height: 1.8;font-family: 'Orbitron', Arial, sans-serif;}
.single-content p,.single-content ul,.single-content ol,.single-content table {margin-bottom: 1.4em !important;}
.single-content h2,.single-content h3,.single-content h4 {font-family: 'Orbitron', Arial, sans-serif; color: #00ffd0; text-transform: uppercase; margin: 2.4em 0 1em 0; letter-spacing: 0.7px;}
.single-content a { color: #00bfff; } .single-content a:hover { color: #7f00ff; }
.single-content img, .main-post-content .single-thumb, .main-post-content .ad-banner, .main-post-content .ad-inline {
    display: block !important;
    margin: 30px auto !important;
    max-width: 100% !important;
    width: auto !important;
    height: auto;
    border-radius: 16px;
    box-shadow: 0 6px 32px #00bfff17;
    box-sizing: border-box;
}
.main-post-content .single-thumb {max-width: 99% !important;}
@media (max-width: 600px) {
    .single-content img, .main-post-content .ad-banner, .main-post-content .ad-inline { margin: 15px auto 15px auto; border-radius: 11px;}
}
.main-post-content .ad-banner,.main-post-content .ad-inline{min-height:62px;}
.newsletter-box {background: rgba(34,39,84,0.95);margin:2.2em 0 2em 0; padding:1.5em 1.2em;border-radius:13px;text-align:center;color:#fff;}
.newsletter-box .headline{font-family:'Orbitron';font-size:1.1em; font-weight:bolder; margin-bottom:1em;}
.newsletter-box form {display:flex;justify-content:center;gap:9px;flex-wrap:wrap;}
.newsletter-box input[type=email]{background:#10122e;color:#00ffd0;font-family:'Orbitron';border-radius:10px 0 0 10px;padding:.55em 1em;border:none;}
.newsletter-box button {background:linear-gradient(90deg,#7f00ff,#00ffd0 60%);color:#fff;font-family:'Orbitron';border-radius:0 10px 10px 0;padding:.53em 2em;border:none;font-weight:bold;}
.newsletter-box button:hover {background:linear-gradient(100deg,#00ffd0,#7f00ff);}
a, a:visited {color:#00ffd0;}


</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-8 text-center bg-transparent">
            <!-- Afiliado Banner Top -->
            <?php redatudo_amazon_ad('banner-top'); ?>
        </div>
    </div>
</div>
<div class="single-grid-wrap">
    <!-- Conteúdo principal -->
    <main class="main-post-content">
        <?php
        // Breadcrumb
        echo '<nav class="breadcrumb" aria-label="breadcrumb" style="margin-bottom:21px;"><a href="'.home_url().'">Início</a> &raquo; ';
        $cat = get_the_category();
        if ($cat) { echo '<a href="'.get_category_link($cat[0]->cat_ID).'">'.$cat[0]->cat_name.'</a> &raquo; '; }
        echo '<span aria-current="page">'.get_the_title().'</span></nav>';
        ?>


        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

        <div class="readmeta-box">
            <span>⏱️ <?php 
                $content = get_post_field('post_content', get_the_ID());
                $words = str_word_count(strip_tags(strip_shortcodes($content)));
                $minutes = ceil($words/220);
                echo $minutes." min de leitura";
            ?></span>
            <span>|</span>
            <span><?php echo $words; ?> palavras</span>
            <span>|</span>
            <span>Por: <?php the_author_posts_link(); ?></span>
            <span>|</span>
            <span>📅 <?php echo get_the_date(); ?></span>
        </div>

        <!-- Banner Destaque: Todas as 13 Ferramentas -->
        <div style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(124, 58, 237, 0.15) 100%); border: 2px solid rgba(16, 185, 129, 0.4); border-radius: 16px; padding: 1.5rem; margin-bottom: 2rem; text-align: center;">
            <div style="font-size: 1.5rem; font-weight: 700; color: #10B981; margin-bottom: 0.5rem; font-family: 'Orbitron', Arial, sans-serif;">🚀 13 Ferramentas de IA Especializadas</div>
            <div style="color: #E5E7EB; margin-bottom: 1rem; font-size: 1.05rem;">Do TCC ao Instagram. Do e-commerce ao ebook. Crie conteúdo profissional em segundos.</div>
            <a href="<?php echo home_url(); ?>/#ferramentas" style="display: inline-block; background: linear-gradient(135deg, #10B981, #059669); color: #FFFFFF; padding: 0.75rem 2rem; border-radius: 12px; text-decoration: none; font-weight: 700; font-size: 1.1rem; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3); transition: all 0.3s;">Ver Todas as Ferramentas →</a>
        </div>

        <h1 class="single-title"><?php the_title(); ?></h1>

        <!-- Categorias e tags -->
        <div class="single-tags-cats">
            <?php foreach(get_the_category() as $c): ?>
                <a href="<?php echo get_category_link($c->term_id); ?>" class="single-cat"><?php echo $c->cat_name;?></a>
            <?php endforeach;?>
            <?php $tags = get_the_tags(); if($tags) foreach($tags as $tag): ?>
                <a href="<?php echo get_tag_link($tag->term_id);?>" class="single-tag"><?php echo "#".$tag->name;?></a>
            <?php endforeach;?>
        </div>

        <!-- Thumbnail -->
        <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('post-thumbnail', ['class' => 'single-thumb', 'alt' => get_the_title()]); ?>
        <?php endif; ?>

        <!-- Afiliado Central -->
        <div class="ad-banner" id="ad-central">
            <?php redatudo_amazon_ad('inline'); ?>
        </div>

        <!-- SUMÁRIO MOBILE -->
        <div id="toc-mobile"></div>

        <div class="single-content" id="single-content">
            <?php the_content(); ?>
        </div>

        <!-- Afiliado Inline -->
        <div class="ad-inline" id="ad-inline-1">
            <?php redatudo_amazon_ad('inline-2'); ?>
        </div>

        <!-- Autor -->
        <div class="post-author-box" style="margin-top:52px;margin-bottom:25px;display:flex;align-items:center;gap:1.1em;background:rgba(40,50,85,.72);padding:1.22em 1em;border-radius:13px;">
            <?php echo get_avatar(get_the_author_meta('ID'), 64, '', 'Foto do autor', ['class' => 'author-avatar']); ?>
            <div class="author-info">
                <div class="author-name" style="font-family:'Orbitron';font-weight:bold;"> <?php the_author(); ?> </div>
                <?php if(get_the_author_meta('description')): ?>
                    <div class="author-desc" style="color:#b6e1fd;"><?php the_author_meta('description'); ?></div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Newsletter -->
        <div class="newsletter-box">
            <div class="headline">Receba dicas e novidades no seu e-mail!</div>
            <form action="#" method="post">
                <input type="email" name="email" placeholder="Seu melhor e-mail" required autocomplete="off"/>
                <button type="submit">Quero receber 🎁</button>
            </form>
        </div>

        <!-- Comentários -->
        <div class="comentarios-section">
            <h3 class="related-title" style="margin-bottom:.3em;">Comentários</h3>
            <?php if (comments_open() || get_comments_number()) :
                comments_template();
            else: ?>
                <div style="color:#b9badf;">Comentários estão fechados para este post.</div>
            <?php endif; ?>
        </div>

        <!-- Afiliado Final -->
        <div class="ad-inline" id="ad-inline-2" style="margin-bottom:0;">
            <?php redatudo_amazon_ad('final'); ?>
        </div>
        <?php endwhile; endif; ?>
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

        <!-- TODAS AS 13 FERRAMENTAS -->
        <div class="sidebar-section" style="background: linear-gradient(145deg, rgba(31, 41, 55, 0.8) 0%, rgba(17, 24, 39, 0.8) 100%); border: 1px solid rgba(16, 185, 129, 0.3);">
            <div class="sidebar-title" style="color: #10B981;">🚀 Nossas 13 Ferramentas</div>
            <div style="display: grid; grid-template-columns: 1fr; gap: 0.5rem;">
                <a href="<?php echo esc_url(redatudo_get_app_url('ebook')); ?>" style="display: flex; align-items: center; gap: 0.5rem; padding: 0.5rem; background: rgba(124, 58, 237, 0.1); border-left: 3px solid #7C3AED; border-radius: 6px; color: #A78BFA !important; text-decoration: none; font-size: 0.9rem; transition: all 0.3s;">
                    <span>📚</span> <span>Gerador de Ebook</span>
                </a>
                <a href="<?php echo esc_url(redatudo_get_app_url('hub')); ?>" style="display: flex; align-items: center; gap: 0.5rem; padding: 0.5rem; background: rgba(139, 92, 246, 0.1); border-left: 3px solid #8B5CF6; border-radius: 6px; color: #C4B5FD !important; text-decoration: none; font-size: 0.9rem; transition: all 0.3s;">
                    <span>💡</span> <span>Gerador de Títulos</span>
                </a>
                <a href="<?php echo esc_url(redatudo_get_app_url('hub')); ?>" style="display: flex; align-items: center; gap: 0.5rem; padding: 0.5rem; background: rgba(236, 72, 153, 0.1); border-left: 3px solid #EC4899; border-radius: 6px; color: #F9A8D4 !important; text-decoration: none; font-size: 0.9rem; transition: all 0.3s;">
                    <span>📸</span> <span>Legendas Instagram</span>
                </a>
                <a href="<?php echo esc_url(redatudo_get_app_url('hub')); ?>" style="display: flex; align-items: center; gap: 0.5rem; padding: 0.5rem; background: rgba(59, 130, 246, 0.1); border-left: 3px solid #3B82F6; border-radius: 6px; color: #93C5FD !important; text-decoration: none; font-size: 0.9rem; transition: all 0.3s;">
                    <span>🎓</span> <span>Gerador de Introdução</span>
                </a>
                <a href="<?php echo esc_url(redatudo_get_app_url('hub')); ?>" style="display: flex; align-items: center; gap: 0.5rem; padding: 0.5rem; background: rgba(6, 182, 212, 0.1); border-left: 3px solid #06B6D4; border-radius: 6px; color: #67E8F9 !important; text-decoration: none; font-size: 0.9rem; transition: all 0.3s;">
                    <span>✍️</span> <span>Humanizador de Texto</span>
                </a>
                <a href="<?php echo esc_url(redatudo_get_app_url('hub')); ?>" style="display: flex; align-items: center; gap: 0.5rem; padding: 0.5rem; background: rgba(16, 185, 129, 0.1); border-left: 3px solid #10B981; border-radius: 6px; color: #6EE7B7 !important; text-decoration: none; font-size: 0.9rem; transition: all 0.3s;">
                    <span>🛍️</span> <span>ShopCopy</span>
                </a>
                <a href="<?php echo esc_url(redatudo_get_app_url('hub')); ?>" style="display: flex; align-items: center; gap: 0.5rem; padding: 0.5rem; background: rgba(59, 130, 246, 0.1); border-left: 3px solid #3B82F6; border-radius: 6px; color: #93C5FD !important; text-decoration: none; font-size: 0.9rem; transition: all 0.3s;">
                    <span>📋</span> <span>Gerador de Temas TCC</span>
                </a>
                <a href="<?php echo esc_url(redatudo_get_app_url('hub')); ?>" style="display: flex; align-items: center; gap: 0.5rem; padding: 0.5rem; background: rgba(99, 102, 241, 0.1); border-left: 3px solid #6366F1; border-radius: 6px; color: #A5B4FC !important; text-decoration: none; font-size: 0.9rem; transition: all 0.3s;">
                    <span>🔄</span> <span>Reformulador</span>
                </a>
                <a href="<?php echo esc_url(redatudo_get_app_url('hub')); ?>" style="display: flex; align-items: center; gap: 0.5rem; padding: 0.5rem; background: rgba(124, 58, 237, 0.1); border-left: 3px solid #7C3AED; border-radius: 6px; color: #A78BFA !important; text-decoration: none; font-size: 0.9rem; transition: all 0.3s;">
                    <span>📝</span> <span>Gerador Copy AIDA</span>
                </a>
                <a href="<?php echo esc_url(redatudo_get_app_url('hub')); ?>" style="display: flex; align-items: center; gap: 0.5rem; padding: 0.5rem; background: rgba(139, 92, 246, 0.1); border-left: 3px solid #8B5CF6; border-radius: 6px; color: #C4B5FD !important; text-decoration: none; font-size: 0.9rem; transition: all 0.3s;">
                    <span>✅</span> <span>Corretor ABNT</span>
                </a>
                <a href="<?php echo esc_url(redatudo_get_app_url('hub')); ?>" style="display: flex; align-items: center; gap: 0.5rem; padding: 0.5rem; background: rgba(245, 158, 11, 0.1); border-left: 3px solid #F59E0B; border-radius: 6px; color: #FCD34D !important; text-decoration: none; font-size: 0.9rem; transition: all 0.3s;">
                    <span>#️⃣</span> <span>Gerador de Hashtags</span>
                </a>
                <a href="<?php echo esc_url(redatudo_get_app_url('hub')); ?>" style="display: flex; align-items: center; gap: 0.5rem; padding: 0.5rem; background: rgba(20, 184, 166, 0.1); border-left: 3px solid #14B8A6; border-radius: 6px; color: #5EEAD4 !important; text-decoration: none; font-size: 0.9rem; transition: all 0.3s;">
                    <span>🏁</span> <span>Gerador de Conclusão</span>
                </a>
                <a href="<?php echo esc_url(redatudo_get_app_url('hub')); ?>" style="display: flex; align-items: center; gap: 0.5rem; padding: 0.5rem; background: rgba(168, 85, 247, 0.1); border-left: 3px solid #A855F7; border-radius: 6px; color: #D8B4FE !important; text-decoration: none; font-size: 0.9rem; transition: all 0.3s;">
                    <span>💬</span> <span>Frases Motivacionais</span>
                </a>
            </div>
            <a href="<?php echo home_url(); ?>/#ferramentas" style="display: block; text-align: center; margin-top: 1rem; padding: 0.75rem; background: linear-gradient(135deg, #10B981, #059669); color: #FFFFFF; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 0.95rem;">Ver Detalhes de Cada Ferramenta →</a>
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
        <!-- Planos e Recursos -->
        <div class="sidebar-section" style="background: linear-gradient(145deg, rgba(16, 185, 129, 0.15) 0%, rgba(124, 58, 237, 0.15) 100%); border: 1px solid rgba(16, 185, 129, 0.3);">
            <div class="sidebar-title" style="color: #10B981;">✨ Desbloqueie Todo Potencial</div>
            <div style="padding: 0.5rem 0;">
                <div style="margin-bottom: 1rem;">
                    <div style="font-weight: 600; color: #FFFFFF; margin-bottom: 0.5rem;">🎯 Plano Pro</div>
                    <div style="font-size: 0.875rem; color: #D1D5DB; margin-bottom: 0.75rem;">Gerações ilimitadas em todas as 13 ferramentas</div>
                    <a href="<?php echo home_url(); ?>/#planos" style="display: inline-block; background: linear-gradient(135deg, #10B981, #059669); color: #FFFFFF; padding: 0.5rem 1rem; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 0.875rem;">Ver Planos →</a>
                </div>
            </div>
        </div>

        <!-- Afiliado Sidebar Sticky -->
        <div class="sidebar-section" style="margin-bottom:10px;">
            <?php redatudo_amazon_ad('sidebar'); ?>
        </div>
    </aside>
</div>

<?php
// ── Mautic audience segmentation trigger ──────────────────────────────────────
if ( is_single() ) {
    $rdtd_segment = get_post_meta( get_the_ID(), '_rdtd_mautic_segment', true );
    if ( $rdtd_segment ) :
?>
<script>
(function() {
    if (typeof window.mt !== 'function') return;
    try {
        window.mt('send', 'pageview', {
            tags: ['<?php echo esc_js( $rdtd_segment ); ?>']
        });
    } catch(e) {}
})();
</script>
<?php
    endif;
}
?>

<?php get_footer(); ?>
