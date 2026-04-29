<?php get_header(); ?>

<main>
    <?php if ( function_exists( 'wc_print_notices' ) ) : ?>
        <div class="woocommerce-notices-wrapper mb-4">
            <?php wc_print_notices(); ?>
        </div>
    <?php endif; ?>

    <?php get_template_part('parts/content', 'category'); ?>
    <?php get_template_part('parts/content', 'product'); ?>
</main>

<?php get_footer(); ?>