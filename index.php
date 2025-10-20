<?php require('header.php'); ?>
<?php 
if ( is_front_page() ) {
  // This is the blog posts index
  require('hero.php');  
  
}
?>
<?php the_content(); ?>
<?php require('footer.php'); ?>