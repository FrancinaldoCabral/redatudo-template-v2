<?php get_header(); ?>

<style>
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap');

.archive-grid-wrap {
    display: grid;
    grid-template-columns: 3fr 1.15fr;
    gap: 2.6vw;
    max-width: 1200px;
    margin: 40px auto 0;
    padding: 0 10px 48px 10px;
}
@media (max-width:991px) {
    .archive-grid-wrap {
        grid-template-columns: 1fr;
        max-width: 98vw;
        gap:0;
    }
}

.archive-main-content {
    background: linear-gradient(145deg, rgba(31, 41, 55, 0.5) 0%, rgba(17, 24, 39, 0.5) 100%);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(75, 85, 99, 0.3);
    border-radius: 24px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    padding: 48px 40px 36px 40px;
    min-width:0;
    overflow:visible;
    position:relative;
    z-index:1;
}
@media (max-width:600px){
    .archive-main-content{
        padding:19px 5vw 26px 5vw;
        border-radius:12px;
    }
}

.archive-main-content>*:not(:last-child){margin-bottom:2.3em;}

.archive-title{
    font-family: 'Outfit', sans-serif;
    font-size: 2.5rem;
    font-weight: 800;
    letter-spacing: -0.02em;
    background: linear-gradient(135deg, #A78BFA 0%, #60A5FA 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: .5em;
    text-align: left;
}

.archive-desc{
    color: #D1D5DB;
    font-size: 1.12rem;
    margin-bottom: 1.2em;
    font-family: 'Inter', sans-serif;
}

.archive-meta{
    color: #E5E7EB;
    font-size: 1rem;
    margin-bottom: 2.2em;
    font-family: 'Inter', sans-serif;
}

/* Banner CTA Modernizado */
.banner-cta-home {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(124, 58, 237, 0.15) 100%);
    border: 2px solid rgba(16, 185, 129, 0.3);
    border-radius: 20px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    display: flex;
    align-items: center;
    gap: 1.5rem;
    backdrop-filter: blur(10px);
    box-shadow: 0 8px 24px rgba(16, 185, 129, 0.2);
}

.banner-cta-home .cta-icon {
    font-size: 2.5rem;
    filter: drop-shadow(0 0 10px rgba(16, 185, 129, 0.6));
}

.banner-cta-home .cta-text {
    flex: 1;
    font-family: 'Inter', sans-serif;
}

.banner-cta-home .cta-text strong {
    font-size: 1.25rem;
    color: #FFFFFF;
    display: block;
    margin-bottom: 0.25rem;
    font-weight: 700;
}

.banner-cta-home .cta-text span {
    color: #D1D5DB;
    font-size: 1rem;
}

.banner-cta-home .cta-link {
    background: linear-gradient(135deg, #10B981 0%, #059669 100%);
    color: #FFFFFF;
    padding: 0.875rem 2rem;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 700;
    font-family: 'Inter', sans-serif;
    transition: all 0.3s;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    white-space: nowrap;
}

.banner-cta-home .cta-link:hover {
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
    color: #FFFFFF;
}

@media (max-width: 768px) {
    .banner-cta-home {
        flex-direction: column;
        text-align: center;
    }
    .banner-cta-home .cta-link {
        width: 100%;
    }
}

.archive-post-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 2.1em 1.7em;
}

@media (max-width:600px){
    .archive-post-grid{
        grid-template-columns: 1fr;
        gap: 1.1em;
    }
}

.archive-post-card {
    background: linear-gradient(145deg, rgba(31, 41, 55, 0.5) 0%, rgba(17, 24, 39, 0.5) 100%);
    border: 1px solid rgba(75, 85, 99, 0.3);
    border-radius: 18px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    overflow: hidden;
    transition: all 0.3s;
    display: flex;
    flex-direction: column;
    padding: 0 0 1.7em 0;
    position: relative;
    justify-content: space-between;
}

.archive-post-card:hover{
    box-shadow: 0 12px 32px rgba(124, 58, 237, 0.3);
    transform: translateY(-4px);
    border-color: rgba(124, 58, 237, 0.5);
}

.archive-post-thumb {
    width: 100%;
    height: 190px;
    object-fit: cover;
    border-radius: 18px 18px 0 0;
    background: #161622 url('https://redatudo-pt-storage-pull-zone.b-cdn.net/thumb-replace-ai.jpg') center center/cover no-repeat;
}

@media(max-width:991px){
    .archive-post-thumb{
        height: 140px;
    }
}

.archive-post-content {
    padding: 1.2em 1.3em .6em 1.3em;
}

.archive-post-title {
    font-family: 'Outfit', sans-serif;
    font-size: 1.22rem;
    color: #FFFFFF;
    margin-bottom: .5em;
    font-weight: 700;
    min-height: 38px;
    letter-spacing: -0.01em;
}

.archive-post-title a {
    color: inherit;
    text-decoration: none;
}

.archive-post-title a:hover {
    color: #60A5FA;
}

.archive-post-meta {
    font-size: .95em;
    color: #D1D5DB;
    margin-bottom: 0.6em;
    display: flex;
    gap: 7px;
    align-items: center;
    flex-wrap: wrap;
    font-family: 'Inter', sans-serif;
}

.archive-post-desc {
    color: #E5E7EB;
    font-size: 1.08em;
    margin-bottom: 1.2em;
    font-family: 'Inter', sans-serif;
    min-height: 44px;
}

.archive-post-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 7px;
    margin-bottom: 0.8em;
}

.archive-post-cat,
.archive-post-tag {
    display: inline-block;
    font-family: 'Inter', sans-serif;
    font-size: 0.78rem;
    font-weight: 500;
    background: rgba(167, 139, 250, 0.15);
    color: #C4B5FD;
    border-radius: 8px;
    padding: 0.25em 0.75em;
    border: 1px solid rgba(167, 139, 250, 0.3);
    text-decoration: none !important;
    transition: all 0.2s;
}

.archive-post-cat:hover,
.archive-post-tag:hover {
    background: rgba(167, 139, 250, 0.25);
    color: #DDD6FE;
    border-color: rgba(167, 139, 250, 0.5);
}

.archive-post-link {
    display: inline-block;
    background: linear-gradient(135deg, #7C3AED 0%, #3B82F6 100%);
    color: #FFFFFF !important;
    font-family: 'Inter', sans-serif;
    font-weight: 700;
    padding: .75em 1.5em;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3);
    font-size: 1.05em;
    transition: all 0.3s;
    text-decoration: none;
}

.archive-post-link:hover {
    background: linear-gradient(135deg, #6D28D9 0%, #2563EB 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(124, 58, 237, 0.4);
    color: #FFFFFF !important;
}

.archive-badge-destaque {
    position: absolute;
    top: 12px;
    right: 12px;
    background: linear-gradient(135deg, #F59E0B 0%, #DC2626 100%);
    color: #FFFFFF;
    font-size: .85em;
    font-weight: 700;
    font-family: 'Inter', sans-serif;
    padding: .5em 1em;
    border-radius: 12px;
    z-index: 8;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.5);
}

/* Newsletter */
.newsletter-box{
    background: linear-gradient(145deg, rgba(31, 41, 55, 0.7) 0%, rgba(17, 24, 39, 0.7) 100%);
    border: 2px solid rgba(16, 185, 129, 0.3);
    margin: 2.2em 0 2em 0;
    padding: 2rem;
    border-radius: 20px;
    text-align: center;
    color: #FFFFFF;
    backdrop-filter: blur(10px);
}

.newsletter-box .headline{
    font-family: 'Outfit', sans-serif;
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
    color: #FFFFFF;
}

.newsletter-box form{
    display: flex;
    justify-content: center;
    gap: 0;
    flex-wrap: wrap;
    max-width: 500px;
    margin: 0 auto;
}

.newsletter-box input[type=email]{
    background: rgba(17, 24, 39, 0.8);
    color: #FFFFFF;
    font-family: 'Inter', sans-serif;
    border-radius: 12px 0 0 12px;
    padding: 1rem 1.5rem;
    border: 2px solid rgba(75, 85, 99, 0.3);
    flex: 1;
    min-width: 250px;
}

.newsletter-box input[type=email]::placeholder {
    color: #9CA3AF;
}

.newsletter-box button{
    background: linear-gradient(135deg, #10B981 0%, #059669 100%);
    color: #FFFFFF;
    font-family: 'Inter', sans-serif;
    border-radius: 0 12px 12px 0;
    padding: 1rem 2rem;
    border: none;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s;
}

.newsletter-box button:hover{
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
    transform: translateY(-2px);
}

.archive-no-posts {
    color: #60A5FA;
    font-size: 1.17em;
    font-family: 'Outfit', sans-serif;
    margin-bottom: 2.7em;
    text-align: center;
}

/* -------- SIDEBAR ----------- */
.sidebar-post-content {
    margin-top: 0;
    margin-bottom: 2vw;
    padding-top: 0;
    position: sticky;
    top: 30px;
    z-index: 2;
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

@media(max-width:991px){
    .sidebar-post-content{
        position: unset;
        top: unset;
        margin-top: 30px;
    }
}

.sidebar-section {
    background: linear-gradient(145deg, rgba(31, 41, 55, 0.5) 0%, rgba(17, 24, 39, 0.5) 100%);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(75, 85, 99, 0.3);
    border-radius: 20px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
    padding: 1.5rem;
    color: #FFFFFF;
    transition: all 0.3s;
}

.sidebar-section:hover {
    border-color: rgba(124, 58, 237, 0.4);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
}

.sidebar-section .sidebar-title{
    font-family: 'Outfit', sans-serif;
    font-size: 1.125rem;
    color: #FFFFFF;
    margin-bottom: 1rem;
    font-weight: 700;
    letter-spacing: -0.01em;
}

.widget-search form{
    display: flex;
    align-items: stretch;
    gap: 0;
}

.widget-search input[type="text"]{
    width: 100%;
    border-radius: 12px 0 0 12px;
    background: rgba(17, 24, 39, 0.8);
    color: #FFFFFF;
    border: 2px solid rgba(75, 85, 99, 0.3);
    padding: 0.75rem 1rem;
    font-size: 1rem;
    font-family: 'Inter', sans-serif;
}

.widget-search input[type="text"]::placeholder {
    color: #9CA3AF;
}

.widget-search button{
    border-radius: 0 12px 12px 0;
    margin-left: 0;
    font-weight: 700;
    cursor: pointer;
    padding: 0.75rem 1.5rem;
    background: linear-gradient(135deg, #7C3AED 0%, #3B82F6 100%);
    color: #FFFFFF;
    font-family: 'Inter', sans-serif;
    transition: all 0.3s;
    border: none;
}

.widget-search button:hover{
    background: linear-gradient(135deg, #6D28D9 0%, #2563EB 100%);
    transform: translateY(-2px);
}

/* Card de Ferramenta Principal */
.tool-highlight-card {
    background: linear-gradient(145deg, rgba(31, 41, 55, 0.7) 0%, rgba(17, 24, 39, 0.7) 100%);
    border: 2px solid rgba(var(--tool-color-rgb), 0.4);
    border-radius: 20px;
    padding: 1.5rem;
    text-align: center;
    position: relative;
    transition: all 0.3s;
    backdrop-filter: blur(10px);
}

.tool-highlight-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 28px rgba(var(--tool-color-rgb), 0.3);
    border-color: rgba(var(--tool-color-rgb), 0.6);
}

.tool-highlight-badge {
    position: absolute;
    top: -12px;
    left: 50%;
    transform: translateX(-50%);
    background: linear-gradient(135deg, #F59E0B 0%, #DC2626 100%);
    color: #FFFFFF;
    padding: 0.5rem 1.25rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 700;
    font-family: 'Inter', sans-serif;
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.5);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.tool-highlight-icon {
    width: 60px;
    height: 60px;
    background: var(--tool-color);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    margin: 0 auto 1rem;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
}

.tool-highlight-title {
    font-family: 'Outfit', sans-serif;
    font-size: 1.25rem;
    font-weight: 700;
    color: #FFFFFF;
    margin-bottom: 0.75rem;
    letter-spacing: -0.01em;
}

.tool-highlight-desc {
    color: #D1D5DB;
    font-size: 0.95rem;
    line-height: 1.6;
    margin-bottom: 1.25rem;
    font-family: 'Inter', sans-serif;
}

.tool-highlight-link {
    display: inline-block;
    width: 100%;
    background: var(--tool-color);
    color: #FFFFFF;
    padding: 0.875rem 1.5rem;
    border-radius: 12px;
    font-weight: 700;
    font-size: 1rem;
    text-decoration: none;
    transition: all 0.3s;
    font-family: 'Inter', sans-serif;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
}

.tool-highlight-link:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
    filter: brightness(1.1);
    color: #FFFFFF;
}

.sidebar-highlights-list {
    list-style: none;
    margin: 0;
    padding: 0;
}

.sidebar-highlights-list li {
    padding: 0.75rem 0;
    border-bottom: 1px solid rgba(75, 85, 99, 0.3);
}

.sidebar-highlights-list li:last-child {
    border-bottom: none;
}

.sidebar-highlights-list a {
    color: #E5E7EB !important;
    font-family: 'Inter', sans-serif;
    font-size: 0.95rem;
    text-decoration: none;
    transition: color 0.2s;
}

.sidebar-highlights-list a:hover {
    color: #60A5FA !important;
}

.sidebar-list-cats,
.sidebar-list-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.sidebar-cat,
.sidebar-tag {
    display: inline-block;
    font-family: 'Inter', sans-serif;
    font-size: 0.85rem;
    font-weight: 500;
    background: rgba(167, 139, 250, 0.15);
    color: #C4B5FD;
    border-radius: 8px;
    padding: 0.4rem 0.875rem;
    border: 1px solid rgba(167, 139, 250, 0.3);
    text-decoration: none !important;
    transition: all 0.2s;
}

.sidebar-cat:hover,
.sidebar-tag:hover {
    background: rgba(167, 139, 250, 0.25);
    color: #DDD6FE;
    border-color: rgba(167, 139, 250, 0.5);
    transform: translateY(-2px);
}

.widget-socials {
    text-align: center;
}

.social-link {
    display: block;
    color: #E5E7EB !important;
    font-family: 'Inter', sans-serif;
    font-size: 1rem;
    padding: 0.5rem 0;
    text-decoration: none;
    transition: color 0.2s;
}

.social-link:hover {
    color: #60A5FA !important;
}

.widget-star-block {
    text-align: center;
    font-family: 'Inter', sans-serif;
}

.widget-star-block .star {
    color: #FBBF24;
    font-size: 1.5rem;
    display: block;
    margin-bottom: 0.5rem;
}

.widget-testimonial {
    font-size: 1rem;
    font-style: italic;
    color: #E5E7EB;
    text-align: center;
    font-family: 'Inter', sans-serif;
    line-height: 1.6;
}

.widget-testimonial .author {
    font-style: normal;
    font-weight: 700;
    color: #10B981;
    margin-top: 0.75rem;
    display: block;
}

.stats-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    margin-top: 1rem;
}

.stat-item {
    text-align: center;
    padding: 1rem;
    background: rgba(17, 24, 39, 0.5);
    border-radius: 12px;
    border: 1px solid rgba(75, 85, 99, 0.3);
}

.stat-number {
    font-family: 'Outfit', sans-serif;
    font-size: 1.75rem;
    font-weight: 700;
    color: #A78BFA;
    display: block;
    margin-bottom: 0.25rem;
}

.stat-label {
    font-family: 'Inter', sans-serif;
    font-size: 0.85rem;
    color: #D1D5DB;
}
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-8 text-center bg-transparent">
            <!-- Banner Afiliado Top -->
            <?php redatudo_amazon_ad('banner-top'); ?>
        </div>
    </div>
</div>

<div class="archive-grid-wrap">
    <!-- CONTEÚDO PRINCIPAL -->
    <main class="archive-main-content">
        <h1 class="archive-title">
            <?php
                if(is_home()) echo 'Blog & Dicas de IA';
                elseif(is_category()) single_cat_title('');
                elseif(is_tag()) single_tag_title('#');
                elseif(is_author()) the_author();
                else echo 'Conteúdos RedaTudo';
            ?>
        </h1>
        <?php if (is_category() && category_description()): ?>
            <div class="archive-desc"><?php echo category_description(); ?></div>
        <?php elseif(is_home()): ?>
            <div class="archive-desc">Tudo sobre IA, criação de conteúdo, marketing digital e produtividade com as 13 ferramentas RedaTudo.</div>
        <?php endif; ?>
        <div class="archive-meta">
            <?php
            global $wp_query;
            echo $wp_query->found_posts . ' artigo' . ($wp_query->found_posts!==1?'s':'') . ' encontrado' . ($wp_query->found_posts!==1?'s':'');
            ?>
        </div>

        <!-- CTA TOP Modernizado -->
        <div class="banner-cta-home">
            <span class="cta-icon">🚀</span>
            <div class="cta-text">
                <strong>13 Ferramentas de IA. 1 Assinatura.</strong>
                <span>Crie ebooks, posts, legendas, TCCs e muito mais em segundos.</span>
            </div>
            <a class="cta-link" href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>?login_app=hub">Começar Grátis</a>
        </div>

        <!-- GRID DE POSTS -->
        <?php if (have_posts()): ?>
        <div class="archive-post-grid">
            <?php $i=0; while (have_posts()): the_post(); $i++; ?>
                <article class="archive-post-card">
                    <?php if($i==1): ?>
                        <span class="archive-badge-destaque">Destaque</span>
                    <?php endif; ?>
                    <?php if(has_post_thumbnail()): ?>
                        <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('medium_large',['class'=>'archive-post-thumb','alt'=>get_the_title()]); ?>
                        </a>
                    <?php else: ?>
                        <a href="<?php the_permalink(); ?>">
                        <div class="archive-post-thumb"></div>
                        </a>
                    <?php endif; ?>
                    <div class="archive-post-content">
                        <div class="archive-post-title">
                            <a href="<?php the_permalink(); ?>"><?= get_the_title(); ?></a>
                        </div>
                        <div class="archive-post-meta">
                            <span>⏱️ <?php
                                $words = str_word_count( strip_tags(strip_shortcodes(get_the_content())));
                                $minutes = ceil($words/220);
                                echo $minutes." min";
                            ?></span>
                            <span>•</span>
                            <span>📅 <?php echo get_the_date(); ?></span>
                        </div>
                        <div class="archive-post-desc"><?php the_excerpt(); ?></div>
                        <div class="archive-post-tags">
                            <?php
                            foreach(get_the_category() as $c) printf('<a class="archive-post-cat" href="%s">%s</a>', esc_url(get_category_link($c->term_id)), esc_html($c->cat_name));
                            $tags = get_the_tags();
                            if($tags) {
                                $tag_count = 0;
                                foreach($tags as $tagx) {
                                    if($tag_count >= 3) break;
                                    printf('<a class="archive-post-tag" href="%s">#%s</a>', esc_url(get_tag_link($tagx->term_id)), esc_html($tagx->name));
                                    $tag_count++;
                                }
                            }
                            ?>
                        </div>
                        <a class="archive-post-link" href="<?php the_permalink(); ?>">Ler Artigo →</a>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>
        <div style="margin-top:2.2em;">
            <?php the_posts_pagination([
                'mid_size'=>2,
                'prev_text'=>__('← Anterior'),
                'next_text'=>__('Próxima →'),
                'screen_reader_text'=>'Paginação'
            ]); ?>
        </div>
        <?php else: ?>
            <div class="archive-no-posts">
                Ainda não há artigos publicados.<br>
                <a href="/" style="color:#60A5FA;">Voltar ao início</a>
            </div>
        <?php endif; ?>

        <!-- Newsletter -->
        <div class="newsletter-box">
            <div class="headline">📬 Receba Dicas de IA Semanalmente</div>
            <form action="#" method="post">
                <input type="email" name="email" placeholder="seu@email.com" required autocomplete="off"/>
                <button type="submit">Assinar Grátis</button>
            </form>
        </div>

        <!-- Afiliado Inline Main -->
        <div style="margin:38px 0;">
            <?php redatudo_amazon_ad('inline'); ?>
        </div>
    </main>

    <!-- SIDEBAR -->
    <aside class="sidebar-post-content">

        <!-- Pesquisa -->
        <div class="sidebar-section widget-search">
            <form role="search" method="get" id="searchform" action="<?php echo home_url('/'); ?>">
                <input type="text" placeholder="Pesquisar artigos..." name="s" value=""/>
                <button type="submit">🔎</button>
            </form>
        </div>

        <!-- Ferramenta em Destaque 1: Gerador de Ebook -->
        <div class="tool-highlight-card" style="--tool-color: #7C3AED; --tool-color-rgb: 124, 58, 237;">
            <span class="tool-highlight-badge">🔥 Mais Usado</span>
            <div class="tool-highlight-icon">📚</div>
            <div class="tool-highlight-title">Gerador de Ebook</div>
            <div class="tool-highlight-desc">Crie ebooks completos em 10 minutos com capítulos e imagens IA</div>
            <a href="<?php echo esc_url(redatudo_get_app_url('ebook')); ?>" class="tool-highlight-link">Criar Ebook Agora →</a>
        </div>

        <!-- Ferramenta em Destaque 2: Instagram -->
        <div class="tool-highlight-card" style="--tool-color: #EC4899; --tool-color-rgb: 236, 72, 153;">
            <span class="tool-highlight-badge">✨ Popular</span>
            <div class="tool-highlight-icon">📸</div>
            <div class="tool-highlight-title">Legendas Instagram</div>
            <div class="tool-highlight-desc">Legendas virais + hashtags estratégicas para bombar</div>
            <a href="<?php echo esc_url(redatudo_get_app_url('hub')); ?>" class="tool-highlight-link">Gerar Legenda →</a>
        </div>

        <!-- Ferramenta em Destaque 3: Humanizador -->
        <div class="tool-highlight-card" style="--tool-color: #06B6D4; --tool-color-rgb: 6, 182, 212;">
            <div class="tool-highlight-icon">✍️</div>
            <div class="tool-highlight-title">Humanizador de Texto</div>
            <div class="tool-highlight-desc">Transforme IA em conteúdo natural e autêntico</div>
            <a href="<?php echo esc_url(redatudo_get_app_url('hub')); ?>" class="tool-highlight-link">Humanizar Agora →</a>
        </div>

        <!-- Afiliado Sidebar -->
        <div class="sidebar-section">
            <?php redatudo_amazon_ad('sidebar'); ?>
        </div>

        <!-- Estatísticas -->
        <div class="sidebar-section">
            <div class="sidebar-title">🎯 RedaTudo em Números</div>
            <div class="stats-grid">
                <div class="stat-item">
                    <span class="stat-number">287k+</span>
                    <span class="stat-label">Conteúdos Criados</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">12.4k</span>
                    <span class="stat-label">Usuários Ativos</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">4.9★</span>
                    <span class="stat-label">Avaliação Média</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">13</span>
                    <span class="stat-label">Ferramentas IA</span>
                </div>
            </div>
        </div>

        <!-- Artigos em Destaque -->
        <div class="sidebar-section">
            <div class="sidebar-title">⭐ Artigos em Destaque</div>
            <ul class="sidebar-highlights-list">
                <?php
                $high = new WP_Query(['posts_per_page'=>4,'ignore_sticky_posts'=>0,'meta_query'=>[['key'=>'_is_ns_featured_post','compare'=>'EXISTS']]]);
                if(!$high->have_posts()){$high=new WP_Query(['posts_per_page'=>4,'tag'=>'destaque']);}
                if($high->have_posts()) {
                    while($high->have_posts()){ 
                        $high->the_post(); ?>
                        <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                    <?php } 
                } else {
                    $high = new WP_Query(['posts_per_page'=>4,'orderby'=>'date','order'=>'DESC']);
                    while($high->have_posts()){ 
                        $high->the_post(); ?>
                        <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                    <?php }
                }
                wp_reset_postdata(); 
                ?>
            </ul>
        </div>

        <!-- Mais Lidos -->
        <div class="sidebar-section">
            <div class="sidebar-title">🔥 Mais Lidos da Semana</div>
            <ul class="sidebar-highlights-list">
                <?php
                $pop = new WP_Query(['posts_per_page'=>4,'orderby'=>'comment_count','order'=>'DESC','ignore_sticky_posts'=>true]);
                if($pop->have_posts()) {
                    while($pop->have_posts()){ 
                        $pop->the_post(); ?>
                        <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                    <?php }
                } else {
                    $pop = new WP_Query(['posts_per_page'=>4,'orderby'=>'date','order'=>'DESC']);
                    while($pop->have_posts()){ 
                        $pop->the_post(); ?>
                        <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                    <?php }
                }
                wp_reset_postdata(); 
                ?>
            </ul>
        </div>

        <!-- Afiliado Sidebar 2 -->
        <div class="sidebar-section">
            <?php redatudo_amazon_ad('sidebar-2'); ?>
        </div>

        <!-- Avaliação -->
        <div class="sidebar-section widget-star-block">
            <span class="star">★★★★★</span>
            <div style="color: #E5E7EB; font-size: 1rem; margin-top: 0.5rem;">
                <strong style="color: #FFFFFF; font-size: 1.25rem; display: block; margin-bottom: 0.25rem;">4.9/5</strong>
                baseado em 12.4k avaliações
            </div>
        </div>

        <!-- Depoimento -->
        <div class="sidebar-section widget-testimonial">
            "Com o RedaTudo economizo <strong style="color: #10B981;">+10 horas por semana</strong>. As 13 ferramentas cobrem tudo que preciso!"
            <span class="author">— Criadora de Conteúdo</span>
        </div>

        <!-- Categorias -->
        <div class="sidebar-section">
            <div class="sidebar-title">📂 Categorias</div>
            <div class="sidebar-list-cats">
            <?php
                $cats = get_terms(['taxonomy'=>'category','hide_empty'=>true,'number'=>12,'orderby'=>'count','order'=>'DESC']);
                if($cats && !is_wp_error($cats)) {
                    foreach($cats as $cat): ?>
                        <a href="<?php echo get_category_link($cat->term_id);?>" class="sidebar-cat">
                            <?php echo $cat->name; ?> <span style="opacity: 0.7;">(<?php echo $cat->count; ?>)</span>
                        </a>
                    <?php endforeach;
                }
            ?>
            </div>
        </div>

        <!-- Tags Populares -->
        <div class="sidebar-section">
            <div class="sidebar-title">#️⃣ Tags Populares</div>
            <div class="sidebar-list-tags">
            <?php
                $tags = get_terms(['taxonomy'=>'post_tag','hide_empty'=>true,'number'=>20,'orderby'=>'count','order'=>'DESC']);
                if($tags && !is_wp_error($tags)) {
                    foreach($tags as $tag): ?>
                        <a href="<?php echo get_tag_link($tag->term_id);?>" class="sidebar-tag">
                            #<?php echo $tag->name; ?>
                        </a>
                    <?php endforeach;
                }
            ?>
            </div>
        </div>

        <!-- Redes Sociais -->
        <div class="sidebar-section widget-socials">
            <div class="sidebar-title">🌐 Siga o RedaTudo</div>
            <a href="https://mastodon.social/@redatudo" class="social-link" title="Mastodon" target="_blank" rel="noopener">
                <i class="bi bi-mastodon"></i> Mastodon
            </a>
            <a href="https://www.linkedin.com/in/naldo-cabral-60377b331/" class="social-link" title="LinkedIn" target="_blank" rel="noopener">
                <i class="bi bi-linkedin"></i> LinkedIn
            </a>
            <a href="https://www.threads.net/@cabral.redatudo" class="social-link" title="Threads" target="_blank" rel="noopener">
                <i class="bi bi-threads"></i> Threads
            </a>
            <a href="https://www.facebook.com/redatudo.oficial/" class="social-link" title="Facebook" target="_blank" rel="noopener">
                <i class="bi bi-facebook"></i> Facebook
            </a>
        </div>

        <!-- CTA Planos -->
        <div class="sidebar-section" style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(124, 58, 237, 0.15) 100%); border: 2px solid rgba(16, 185, 129, 0.3);">
            <div class="sidebar-title" style="color: #10B981;">⚡ Desbloqueie Todo o Poder</div>
            <div style="color: #E5E7EB; margin-bottom: 1.25rem; font-size: 0.95rem; line-height: 1.6;">
                <strong style="color: #FFFFFF; display: block; margin-bottom: 0.5rem;">Gerações Ilimitadas</strong>
                13 ferramentas IA profissionais por apenas <strong style="color: #10B981; font-size: 1.25rem;">R$ 9/mês</strong>
            </div>
            <a href="/#planos" style="display: block; width: 100%; background: linear-gradient(135deg, #10B981 0%, #059669 100%); color: #FFFFFF; padding: 0.875rem 1.5rem; border-radius: 12px; font-weight: 700; text-align: center; text-decoration: none; transition: all 0.3s; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3); font-family: 'Inter', sans-serif;">
                Ver Planos →
            </a>
        </div>

        <!-- Afiliado Final (sticky) -->
        <div style="position: sticky; top: 30px;">
            <?php redatudo_amazon_ad('final'); ?>
        </div>
    </aside>
</div>

<?php get_footer(); ?>
