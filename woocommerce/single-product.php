<?php

/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

get_header('shop'); ?>

<div class="container mt-5 mb-3">
	<div class="row">
		<!-- esta funcao é responsavel por mostrar mensagens de erro ou sucesso do woocommerce  -->
		<p class="mt-0"><?php wc_print_notices(); ?></p>

		<!-- coluna da esquerda:titulo, referencia, avaliação, detalhes -->
		<div class="col-md-3 mt-4 details-bg rounded-3 p-3">

			<!-- Título -->
			<h1 class="product_title fw-bold fs-3 mb-2">
				<?php the_title(); ?>
			</h1>

			<!-- Meta -->
			<div class="product-meta text-muted small mb-3">
				<div>
					<strong>Categoria:</strong>
					<?php echo wc_get_product_category_list(get_the_ID()); ?>
				</div>
			</div>

			<p class="text-dark mb-2">
				<strong>Referência:</strong> <?php echo get_post_meta(get_the_ID(), '_sku', true); ?>
			</p>

			<!-- Descrição -->
			<?php if (has_excerpt()) : ?>
				<div class="product-short-description">
					<span class="description-label">Detalhes do produto</span>
					<?php the_excerpt(); ?>
				</div>
			<?php endif; ?>
		</div>

		<!-- Coluna do meio: imagem principal e galeria -->
		<div class="col-md-6 mt-4">
			<?php
			global $product;
			if (! is_a($product, 'WC_Product')) {
				$product = wc_get_product(get_the_ID());
			}
			woocommerce_template_single_rating();
			?>

			<div class="product-gallery-wrapper bg-light border rounded-3 p-3 shadow-sm">
				<?php woocommerce_show_product_images(); ?>
			</div>
		</div>

		<!-- Coluna da direita: preço, variações, botão de comprar -->
		<div class="col-md-3 mt-4">
			<div class="purchase-box details-bg rounded-3 p-3 shadow-sm">
				<!-- Preço -->
				<div class="product-price mb-2">
					<span class="price-label">A partir de</span>
					<?php woocommerce_template_single_price(); ?>
				</div>

				<!-- Exibe o valor total dos produtos agrupados -->
				<div class="grouped-total mt-3 mb-3">
					<span class="total-label">Total:</span>
					<span class="total-price">R$ 0,00</span>
				</div>

				<!-- Produtos agrupados / Botão -->
				<div class="grouped-products">
					<?php woocommerce_template_single_add_to_cart(); ?>
				</div>

				<!-- Info vendedor -->
				<div class="seller-info text-muted small mt-3">
					Vendido e entregue por <?php echo esc_html(get_bloginfo('name')); ?>
				</div>
			</div>
		</div>
	</div>

	<!-- PRODUTOS RELACIONADOS -->
	<div class="row mt-5">
		<div class="col-12">

			<?php
			woocommerce_output_related_products(array(
				'posts_per_page' => 4,
				'columns'        => 4,
			));
			?>

		</div>
	</div>


</div>

<?php
get_footer('shop');
