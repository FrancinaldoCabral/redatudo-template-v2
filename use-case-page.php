<?php
/**
* Template Name: Use case model
* Description: Modelo orgânico de casos de uso
*/
?>
<?php require('header.php'); ?>
<!-- <div class="loading">Loading&#8230;</div>
 --><!-- <div id="spinner">
  <img src="https://redatudo.online/wp-content/uploads/2022/12/loading-default.gif"/>
</div> -->
<div class="container-fluid fim-escuro p-4">
  <div class="row align-items-center">
    <div class="col-12 col-lg-8 text-left p-4 ml-4">
        <h1 class="animate__animated animate__fadeInDown">
        <?php
            the_title();
        ?>
        </h1>
        <p class="animate__animated animate__fadeInLeft" style="font-size: larger;">Mais de 50 casos de uso pra TURBINAR sua copy, redação e produção de conteúdo. Economize tempo e dinheiro com REDATUDO.</p>
        <a class="btn btn-primary btn-lg animate__animated animate__fadeInUp mt-4" 
        href="https://redatudo.online/#assine-agora" 
        role="button">Crie copy, imagem e conteúdo autoral agora</a>
    </div>
    <div class="col-12 col-lg-3">
        <img src="https://redatudo.online/wp-content/uploads/2022/12/gerador-conteudo-ia-redatudo-robot.gif" 
        alt="plataforma de produção de conteúdo" 
        class="img-fluid animate__animated animate__fadeInLeft">
    </div>
  </div>
</div>
<?php echo do_shortcode('[use-case slug="anuncios-do-facebook"]'); ?>
<?php require('footer.php'); ?>