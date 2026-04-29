<?php
/**
 * Template Name: Página Carrinho
 */

get_header();
?>

<main class="cart-page-clean">

    <?php
    while ( have_posts() ) : the_post();
        the_content();
    endwhile;
    ?>

</main>

<?php
get_footer();