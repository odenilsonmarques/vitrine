<?php
/**
 * Template Name: Página Checkout
 */

get_header();
?>

<main class="checkout-page-clean" style="padding: 20px; max-width: 1200px; margin: 0 auto;">

    <?php
    while ( have_posts() ) : the_post();
        the_content();
    endwhile;
    ?>

</main>

<?php
get_footer();