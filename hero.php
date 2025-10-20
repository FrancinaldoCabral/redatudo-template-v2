<div class="container p-4 text-white">
  <div class="row align-items-center justify-content-center">
    <div class="col-12 col-md-8 col-lg-8 p-4 ml-4">
      <p class="d-block d-md-none d-lg-none mt-4 pt-4">
          <ins class="adsbygoogle"
                  style="display:block"
                  data-ad-format="autorelaxed"
                  data-ad-client="ca-pub-9848635946946970"
                  data-ad-slot="5751994556"></ins>
          <script>
              (adsbygoogle = window.adsbygoogle || []).push({});
          </script>                        
      </p>
    </div>
    <div class="col-12 col-md-8 col-lg-8 p-4 ml-4">
        <h1 class="animate__animated animate__fadeInDown">
        <?php
            the_title();
        ?>
        </h1>
        <p class="animate__animated animate__fadeInLeft" style="font-size: larger;">
            <?php 
            if(is_single( )){
              echo get_the_excerpt(); 
            }else{
              echo 'Nossa plataforma intuitiva foi projetada para atender freelancers, empresários, estudantes e criadores de conteúdo, proporcionando uma experiência tudo-em-um que facilita a criação, pesquisa e gerenciamento do seu conteúdo. <strong>Descomplique sua jornada com ferramentas integradas que potencializam sua criatividade!</strong>';
            }
              
            ?>
        </p>
        <a class="btn btn-primary btn-lg animate__animated animate__fadeInUp mt-4" 
        href="https://redatudo.online/minha-conta?login_app=chat" 
        role="button">Crie Conteúdo do Zero com IA</a>
    </div>
    <div class="col-12 col-md-4 col-lg-4">
        <img src="https://redatudo.online/wp-content/uploads/2025/04/banner-redatudo-1.png" 
        alt="plataforma de produção de conteúdo" 
        class="img-fluid animate__animated animate__fadeInLeft">
    </div>
  </div>
</div>