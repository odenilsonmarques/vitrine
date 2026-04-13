<?php
defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

// Estrutura principal do WooCommerce (NÃO remover)
do_action( 'woocommerce_before_main_content' );
?>

<div class="container my-4">

    <?php if ( is_search() ) : ?>
        <h2 class="mb-4 text-center">
            Resultados para: "<strong><?php echo get_search_query(); ?></strong>"
        </h2>
    <?php endif; ?>

    <?php if ( woocommerce_product_loop() ) : ?>

        <?php
        // Mantém notificações (ex: produto adicionado ao carrinho)
        do_action( 'woocommerce_before_shop_loop' );
        ?>

        <div class="row">
            <?php
            while ( have_posts() ) :
                the_post();

                // Mantém compatibilidade com Woo
                do_action( 'woocommerce_shop_loop' );

                wc_get_template_part( 'content', 'product' );

            endwhile;
            ?>
        </div>

        <?php
        // Paginação
        // do_action( 'woocommerce_after_shop_loop' );
        ?>

    <?php else : ?>

        <div class="text-center my-5">
            <h4>Nenhum produto encontrado 😕</h4>
            <p>Tente outro termo ou veja nossos produtos.</p>

            <a href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ); ?>" 
               class="btn btn-primary mt-3">
                Ver todos os produtos
            </a>
        </div>

    <?php endif; ?>

</div>

<?php
// Fecha estrutura principal
do_action( 'woocommerce_after_main_content' );

// Sidebar (opcional - pode remover se não usa)
do_action( 'woocommerce_sidebar' );

get_footer( 'shop' );