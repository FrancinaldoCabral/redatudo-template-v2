<?php get_header(); ?>

<style>
  .search-section {
    background: #101022;
    min-height: 100vh;
    padding-top: 4.5rem;
    padding-bottom: 2rem;
    position: relative;
    z-index: 1;
  }
  .search-title {
    font-family: 'Orbitron', Arial, sans-serif;
    font-weight: 700;
    text-transform: uppercase;
    font-size: 2.0rem;
    letter-spacing: 1.5px;
    background: linear-gradient(90deg, #00bfff, #7f00ff);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: 1.6rem;
    text-align: center;
  }
  .search-form-inner {
    max-width: 560px;
    margin: 0 auto 2.6rem auto;
    background: rgba(23,23,39,0.6);
    border-radius: 20px;
    padding: 1rem 2rem;
    box-shadow: 0 2px 20px #00bfff26;
    display: flex;
  }
  .search-form-inner input[type="search"] {
    flex:1;
    border:none;
    background:linear-gradient(90deg,#0d0d13 73%,#171727 100%);
    color:#f2f6fa;
    font-family:'Orbitron', Arial, sans-serif;
    padding: .75rem 1rem;
    font-size:1.11rem;
    border-radius: 18px 0 0 18px;
    outline: none;
  }
  .search-form-inner .btn {
    border-radius: 0 18px 18px 0;
    padding: .78rem 1.3rem;
    font-size:1.08rem;
    font-family: 'Orbitron', sans-serif;
    background: linear-gradient(90deg, #7f00ff, #00bfff 90%);
    border: none;
    color: #fff;
    box-shadow: 0 2px 10px #00bfff30;
    cursor: pointer;
    transition: transform .19s, box-shadow .20s;
  }
  .search-form-inner .btn:hover {
    transform: translateY(-2px) scale(1.04);
    background: linear-gradient(95deg, #00bfff 60%, #7f00ff 100%);
    box-shadow: 0 2px 16px #00ffd080;
  }
  .search-results-list {
    max-width: 800px;
    margin: 0 auto;
    display: grid;
    gap: 1.6rem;
  }
  .search-result-card {
    background: rgba(34,24,65,0.98);
    border-radius:22px;
    box-shadow: 0 5px 19px #00bfff13;
    padding:1.3rem 1.5rem 1.33rem 1.4rem;
    border:1.5px solid #00bfff22;
    transition: box-shadow .15s, transform .18s;
  }
  .search-result-card:hover {
    box-shadow: 0 14px 48px #00ffd044, 0 1px 2px #7f00ff09;
    transform:translateY(-4px) scale(1.017);
  }
  .search-result-title {
    font-family: 'Orbitron', Arial, sans-serif;
    color:#00ffd0;
    font-weight:600;
    font-size: 1.14rem;
    text-decoration:none;
    letter-spacing: .1px;
    margin-bottom: .33rem;
    display:block;
    transition: color .2s;
  }
  .search-result-title:hover { color:#7f00ff; }
  .search-result-excerpt {
    color:#b8e6ff;
    font-size:1rem;
    line-height:1.7;
    margin-bottom:.2rem;
  }
  .search-nada {
    color:#b8e6ff;
    text-align:center;
    padding:2.2rem 0 1.8rem 0;
    font-size:1.13rem;
    background: rgba(23,23,39,0.30);
    border-radius: 24px;
    margin: 0 auto 2.5rem auto;
    max-width: 390px;
  }
</style>

<section class="search-section">
  <div class="container">
    <h1 class="search-title">
      Resultado da Pesquisa <?php if( get_search_query() ) echo ": ". esc_html( get_search_query() ); ?>
    </h1>
    <form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="search-form-inner mb-3">
      <input type="search" name="s" placeholder="O que você procura?" value="<?php the_search_query(); ?>" aria-label="Pesquisa" required>
      <button class="btn" type="submit">🔎 Buscar</button>
    </form>

    <div class="search-results-list">
      <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <div class="search-result-card">
          <a href="<?php the_permalink(); ?>" class="search-result-title"><?php the_title(); ?></a>
          <div class="search-result-excerpt"><?php echo get_the_excerpt(); ?></div>
        </div>
      <?php endwhile; else: ?>
        <div class="search-nada">
          Nenhum resultado encontrado.<br> Tente outros termos!
        </div>
      <?php endif; ?>
    </div>
    <div class="mt-4">
      <?php
        // paginação se houver muitos resultados
        the_posts_pagination(array(
          'prev_text' => '&laquo; Anterior',
          'next_text' => 'Próxima &raquo;',
          'mid_size'  => 2,
        ));
      ?>
    </div>
  </div>
</section>

<?php get_footer(); ?>