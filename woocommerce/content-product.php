<?php
defined( 'ABSPATH' ) || exit;

global $product;

// Validação obrigatória
if ( ! is_a( $product, WC_Product::class ) || ! $product->is_visible() ) {
	return;
}
?>

<li <?php wc_product_class( 'col-md-3 col-sm-6 mb-4 list-unstyled', $product ); ?>>

    <div class="card h-100 border-0 shadow-sm">

        <a href="<?php the_permalink(); ?>" class="text-decoration-none text-dark">

            <div class="card-img-top text-center p-3">
                <?php woocommerce_template_loop_product_thumbnail(); ?>
            </div>

            <div class="card-body text-center">

                <h6 class="card-title">
                    <?php the_title(); ?>
                </h6>

                <div class="price mb-2">
                    <?php woocommerce_template_loop_price(); ?>
                </div>

            </div>

        </a>

        <div class="card-footer bg-transparent border-0 text-center pb-3">
            <?php woocommerce_template_loop_add_to_cart(); ?>
        </div>

    </div>

</li>