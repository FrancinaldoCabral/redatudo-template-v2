<?php
/**
 * Template Name: Blog Redatudo
 * Description: Template moderno para página de blog
 */

get_header(); 
?>

<style>
/* Hero do Blog */
.blog-hero {
    background: #0F0F1A;
    min-height: 40vh;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    padding: 4rem 0;
}

.blog-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 50%;
    width: 600px;
    height: 600px;
    background: radial-gradient(circle, rgba(124,58,237,0.15) 0%, rgba(59,130,246,0.08) 40%, transparent 70%);
    transform: translateX(-50%);
    filter: blur(80px);
    animation: pulseGlow 6s infinite alternate;
}

.blog-hero-content {
    position: relative;
    z-index: 2;
    text-align: center;
}

.blog-hero-title {
    font-family: 'Outfit', sans-serif;
    font-size: clamp(2.5rem, 5vw, 4rem);
    font-weight: 800;
    color: #fff;
    margin-bottom: 1rem;
    letter-spacing: -0.02em;
}

.blog-hero-subtitle {
    font-family: 'Inter', sans-serif;
    font-size: clamp(1.1rem, 2vw, 1.35rem);
    color: #9CA3AF;
    max-width: 700px;
    margin: 0 auto 2rem;
}

/* Grid de Posts */
.blog-posts-section {
    background: #161622;
    padding: 4rem 0;
    min-height: 60vh;
}

.blog-posts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 2rem;
    margin-bottom: 3rem;
}

.blog-post-card {
    background: #1F2937;
    border: 2px solid #374151;
    border-radius: 20px;
    overflow: hidden;
    transition: all 0.3s;
    display: flex;
    flex-direction: column;
}

.blog-post-card:hover {
    transform: translateY(-4px);
    border-color: #7C3AED;
    box-shadow: 0 12px 32px rgba(124, 58, 237, 0.3);
    background: #252F3F;
}

.blog-post-thumbnail {
    width: 100%;
    height: 220px;
    object-fit: cover;
    background: linear-gradient(135deg, #7C3AED 0%, #3B82F6 100%);
}

.blog-post-content {
    padding: 2rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.blog-post-meta {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
    font-family: 'Inter', sans-serif;
    font-size: 0.875rem;
    color: #9CA3AF;
}

.blog-post-title {
    font-family: 'Outfit', sans-serif;
    font-size: 1.5rem;
    font-weight: 700;
    color: #FFFFFF;
    margin-bottom: 1rem;
    line-height: 1.3;
}

.blog-post-title a {
    color: #FFFFFF;
    text-decoration: none;
    transition: color 0.2s;
}

.blog-post-title a:hover {
    color: #7C3AED;
}

.blog-post-excerpt {
    font-family: 'Inter', sans-serif;
    color: #D1D5DB;
    line-height: 1.6;
    margin-bottom: 1.5rem;
    flex: 1;
}

.blog-post-readmore {
    background: linear-gradient(135deg, #7C3AED 0%, #3B82F6 100%);
    color: #FFFFFF;
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-family: 'Inter', sans-serif;
    font-weight: 600;
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s;
    align-self: flex-start;
}

.blog-post-readmore:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(124, 58, 237, 0.4);
    color: #FFFFFF;
    text-decoration: none;
}

/* Paginação */
.blog-pagination {
    display: flex;
    justify-content: center;
    gap: 1rem;
    margin-top: 3rem;
}

.blog-pagination a,
.blog-pagination span {
    background: #1F2937;
    color: #FFFFFF;
    padding: 0.75rem 1.25rem;
    border-radius: 10px;
    font-family: 'Inter', sans-serif;
    font-weight: 600;
    text-decoration: none;
    border: 2px solid #374151;
    transition: all 0.3s;
}

.blog-pagination a:hover {
    border-color: #7C3AED;
    background: #7C3AED;
    transform: translateY(-2px);
}

.blog-pagination .current {
    background: linear-gradient(135deg, #7C3AED 0%, #3B82F6 100%);
    border-color: #7C3AED;
}

@media (max-width: 768px) {
    .blog-posts-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
}
</style>

<!-- Hero Section -->
<section class="blog-hero">
    <div class="container">
        <div class="blog-hero-content">
            <h1 class="blog-hero-title">
                <span class="gradient-text">Blog</span> Redatudo
            </h1>
            <p class="blog-hero-subtitle">
                Dicas, tutoriais e novidades sobre criação de conteúdo com IA.<br>
                Aprenda a usar a inteligência artificial a seu favor.
            </p>
        </div>
    </div>
</section>

<!-- Posts Section -->
<section class="blog-posts-section">
    <div class="container">
        <!-- Banner Destaque: Todas as 13 Ferramentas -->
        <div style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(124, 58, 237, 0.15) 100%); border: 2px solid rgba(16, 185, 129, 0.4); border-radius: 16px; padding: 1.5rem; margin-bottom: 3rem; text-align: center;">
            <div style="font-size: 1.5rem; font-weight: 700; color: #10B981; margin-bottom: 0.5rem; font-family: 'Outfit', sans-serif;">🚀 13 Ferramentas de IA Especializadas</div>
            <div style="color: #E5E7EB; margin-bottom: 1rem; font-size: 1.05rem; font-family: 'Inter', sans-serif;">Do TCC ao Instagram. Do e-commerce ao ebook. Crie conteúdo profissional em segundos.</div>
            <a href="<?php echo home_url(); ?>/#ferramentas" style="display: inline-block; background: linear-gradient(135deg, #10B981, #059669); color: #FFFFFF; padding: 0.75rem 2rem; border-radius: 12px; text-decoration: none; font-weight: 700; font-size: 1.1rem; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3); transition: all 0.3s; font-family: 'Inter', sans-serif;">Ver Todas as Ferramentas →</a>
        </div>

        <div class="blog-posts-grid">
            <?php
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => 12,
                'paged' => $paged,
                'post_status' => 'publish'
            );
            
            $blog_query = new WP_Query($args);
            
            if ($blog_query->have_posts()) :
                while ($blog_query->have_posts()) : $blog_query->the_post();
            ?>
                <article class="blog-post-card">
                    <?php if (has_post_thumbnail()) : ?>
                        <img src="<?php the_post_thumbnail_url('medium_large'); ?>" 
                             alt="<?php the_title_attribute(); ?>" 
                             class="blog-post-thumbnail">
                    <?php else : ?>
                        <div class="blog-post-thumbnail"></div>
                    <?php endif; ?>
                    
                    <div class="blog-post-content">
                        <div class="blog-post-meta">
                            <span>📅 <?php echo get_the_date(); ?></span>
                            <span>⏱️ <?php echo ceil(str_word_count(strip_tags(get_the_content())) / 220); ?> min</span>
                        </div>
                        
                        <h2 class="blog-post-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        
                        <div class="blog-post-excerpt">
                            <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                        </div>
                        
                        <a href="<?php the_permalink(); ?>" class="blog-post-readmore">
                            Ler artigo →
                        </a>
                    </div>
                </article>
            <?php
                endwhile;
                
                // Paginação
                if ($blog_query->max_num_pages > 1) :
            ?>
                <div class="blog-pagination" style="grid-column: 1 / -1;">
                    <?php
                    echo paginate_links(array(
                        'total' => $blog_query->max_num_pages,
                        'current' => $paged,
                        'prev_text' => '← Anterior',
                        'next_text' => 'Próximo →',
                    ));
                    ?>
                </div>
            <?php
                endif;
                wp_reset_postdata();
            else :
            ?>
                <div style="grid-column: 1 / -1; text-align: center; padding: 4rem;">
                    <p style="color: #9CA3AF; font-size: 1.25rem; font-family: 'Inter', sans-serif;">
                        Nenhum post encontrado.
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
