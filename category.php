<?php
/**
 * Archive Template - Categorias, Tags, etc
 */

get_header(); 
?>

<style>
/* Hero de Arquivo */
.archive-hero {
    background: #0F0F1A;
    min-height: 35vh;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    padding: 3rem 0;
}

.archive-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 50%;
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, rgba(124,58,237,0.12) 0%, rgba(59,130,246,0.06) 40%, transparent 70%);
    transform: translateX(-50%);
    filter: blur(60px);
}

.archive-hero-content {
    position: relative;
    z-index: 2;
    text-align: center;
}

.archive-title {
    font-family: 'Outfit', sans-serif;
    font-size: clamp(2rem, 4vw, 3.5rem);
    font-weight: 800;
    color: #fff;
    margin-bottom: 0.5rem;
    letter-spacing: -0.02em;
}

.archive-description {
    font-family: 'Inter', sans-serif;
    font-size: 1.125rem;
    color: #D1D5DB;
    max-width: 600px;
    margin: 0 auto;
}

.archive-badge {
    display: inline-block;
    background: rgba(124, 58, 237, 0.15);
    color: #A78BFA;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
    margin-bottom: 1rem;
    border: 1px solid rgba(124, 58, 237, 0.4);
    font-family: 'Inter', sans-serif;
}

/* Posts Grid */
.archive-posts-section {
    background: #161622;
    padding: 4rem 0;
    min-height: 50vh;
}

.posts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 2rem;
    margin-bottom: 3rem;
}

.post-card {
    background: #1F2937;
    border: 2px solid #374151;
    border-radius: 20px;
    overflow: hidden;
    transition: all 0.3s;
    display: flex;
    flex-direction: column;
    text-decoration: none;
}

.post-card:hover {
    transform: translateY(-4px);
    border-color: #7C3AED;
    box-shadow: 0 12px 32px rgba(124, 58, 237, 0.3);
    background: #252F3F;
    text-decoration: none;
}

.post-thumbnail {
    width: 100%;
    height: 200px;
    object-fit: cover;
    background: linear-gradient(135deg, #7C3AED 0%, #3B82F6 100%);
}

.post-card-content {
    padding: 1.5rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.post-meta {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
    font-family: 'Inter', sans-serif;
    font-size: 0.8rem;
    color: #9CA3AF;
}

.post-card-title {
    font-family: 'Outfit', sans-serif;
    font-size: 1.35rem;
    font-weight: 700;
    color: #FFFFFF;
    margin-bottom: 0.75rem;
    line-height: 1.3;
}

.post-excerpt {
    font-family: 'Inter', sans-serif;
    color: #D1D5DB;
    font-size: 0.95rem;
    line-height: 1.6;
    margin-bottom: 1rem;
    flex: 1;
}

.post-readmore {
    background: linear-gradient(135deg, #7C3AED 0%, #3B82F6 100%);
    color: #FFFFFF;
    padding: 0.6rem 1.25rem;
    border-radius: 8px;
    font-family: 'Inter', sans-serif;
    font-weight: 600;
    font-size: 0.9rem;
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s;
    align-self: flex-start;
}

.post-readmore:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(124, 58, 237, 0.4);
    color: #FFFFFF;
}

/* Paginação */
.pagination-wrapper {
    display: flex;
    justify-content: center;
    gap: 0.75rem;
    margin-top: 3rem;
}

.pagination-wrapper a,
.pagination-wrapper span {
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

.pagination-wrapper a:hover {
    border-color: #7C3AED;
    background: #7C3AED;
    transform: translateY(-2px);
}

.pagination-wrapper .current {
    background: linear-gradient(135deg, #7C3AED 0%, #3B82F6 100%);
    border-color: #7C3AED;
}

@media (max-width: 768px) {
    .posts-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
}
</style>

<!-- Hero Section -->
<section class="archive-hero">
    <div class="container">
        <div class="archive-hero-content">
            <?php if (is_category()) : ?>
                <span class="archive-badge">📂 CATEGORIA</span>
                <h1 class="archive-title">
                    <span class="gradient-text"><?php single_cat_title(); ?></span>
                </h1>
                <?php if (category_description()) : ?>
                    <p class="archive-description"><?php echo category_description(); ?></p>
                <?php endif; ?>
            <?php elseif (is_tag()) : ?>
                <span class="archive-badge">🏷️ TAG</span>
                <h1 class="archive-title">
                    <span class="gradient-text"><?php single_tag_title(); ?></span>
                </h1>
                <?php if (tag_description()) : ?>
                    <p class="archive-description"><?php echo tag_description(); ?></p>
                <?php endif; ?>
            <?php elseif (is_author()) : ?>
                <span class="archive-badge">✍️ AUTOR</span>
                <h1 class="archive-title">
                    <span class="gradient-text"><?php the_author(); ?></span>
                </h1>
            <?php elseif (is_date()) : ?>
                <span class="archive-badge">📅 ARQUIVO</span>
                <h1 class="archive-title">
                    <span class="gradient-text"><?php the_archive_title(); ?></span>
                </h1>
            <?php else : ?>
                <h1 class="archive-title">
                    <span class="gradient-text">Arquivo</span>
                </h1>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Posts Section -->
<section class="archive-posts-section">
    <div class="container">
        <div class="posts-grid">
            <?php
            if (have_posts()) :
                while (have_posts()) : the_post();
            ?>
                <article class="post-card">
                    <?php if (has_post_thumbnail()) : ?>
                        <img src="<?php the_post_thumbnail_url('medium'); ?>" 
                             alt="<?php the_title_attribute(); ?>" 
                             class="post-thumbnail">
                    <?php else : ?>
                        <div class="post-thumbnail"></div>
                    <?php endif; ?>
                    
                    <div class="post-card-content">
                        <div class="post-meta">
                            <span>📅 <?php echo get_the_date(); ?></span>
                            <span>⏱️ <?php echo ceil(str_word_count(strip_tags(get_the_content())) / 220); ?> min</span>
                        </div>
                        
                        <h2 class="post-card-title">
                            <?php the_title(); ?>
                        </h2>
                        
                        <div class="post-excerpt">
                            <?php echo wp_trim_words(get_the_excerpt(), 15); ?>
                        </div>
                        
                        <a href="<?php the_permalink(); ?>" class="post-readmore">
                            Ler mais →
                        </a>
                    </div>
                </article>
            <?php
                endwhile;
                
                // Paginação
                if (paginate_links()) :
            ?>
                <div class="pagination-wrapper" style="grid-column: 1 / -1;">
                    <?php
                    echo paginate_links(array(
                        'prev_text' => '← Anterior',
                        'next_text' => 'Próximo →',
                    ));
                    ?>
                </div>
            <?php
                endif;
            else :
            ?>
                <div style="grid-column: 1 / -1; text-align: center; padding: 4rem;">
                    <p style="color: #9CA3AF; font-size: 1.25rem; font-family: 'Inter', sans-serif;">
                        Nenhum post encontrado nesta categoria.
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
