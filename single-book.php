<?php
/**
 * Template Name: Single Book
 * Template Post Type: book
 */


?>
<html>
<?php

    while (have_posts()) : the_post();
        // Pega os metadados customizados se existirem
        
        echo str_replace(the_content(), "“`", "");

    endwhile;
?>



</html>