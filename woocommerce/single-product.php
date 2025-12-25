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

			<p class="text-dark"><strong>Referência:</strong> <?php echo get_post_meta(get_the_ID(), '_sku', true); ?></p>

			<!-- Descrição -->
			<?php if (has_excerpt()) : ?>
				<div class="product-short-description">
					<strong class="d-block mb-1">Descrição</strong>
					<?php the_excerpt(); ?>
				</div>
			<?php endif; ?>

			<style>
				.details-bg {
					background-color: #f8f9fa;
				}

				.product-meta a {
					color: #0d6efd;
					text-decoration: none;
				}

				.product-meta a:hover {
					text-decoration: underline;
				}

				.product-short-description p {
					margin-bottom: 0;
					font-size: 0.95rem;
					line-height: 1.5;
				}
			</style>
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

			<style>
				/* Wrapper da galeria */
				.product-gallery-wrapper {
					display: flex;
					justify-content: center;
				}

				/* Galeria do WooCommerce */
				.woocommerce-product-gallery {
					max-width: 420px;
					width: 100%;
					margin: 0 auto;
				}

				/* Imagem principal */
				.woocommerce-product-gallery__image img {
					border-radius: 8px;
				}

				/* Miniaturas */
				.woocommerce-product-gallery__wrapper ol {
					padding-left: 0;
					margin-top: 10px;
				}

				.woocommerce-product-gallery__wrapper li {
					list-style: none;
					margin-right: 6px;
				}

				/* Miniaturas lado a lado (horizontal) */
				.woocommerce-product-gallery .flex-control-thumbs {
					display: flex;
					gap: 8px;
					justify-content: center;
					padding: 0;
					margin-top: 10px;
				}

				/* Remove estilo de lista */
				.woocommerce-product-gallery .flex-control-thumbs li {
					list-style: none;
					margin: 0;
					width: auto !important;
				}

				/* Imagens das miniaturas */
				.woocommerce-product-gallery .flex-control-thumbs img {
					width: 70px;
					height: auto;
					border-radius: 6px;
					border: 1px solid #dee2e6;
					cursor: pointer;
					opacity: 0.8;
					transition: all .2s ease-in-out;
				}

				/* Hover / ativo */
				.woocommerce-product-gallery .flex-control-thumbs img:hover,
				.woocommerce-product-gallery .flex-control-thumbs img.flex-active {
					opacity: 1;
					border-color: #0d6efd;
				}
			</style>
		</div>

		<!-- Coluna da direita: preço, variações, botão de comprar -->
		<div class="col-md-2 mt-4 ms-md-3">
			<div class="purchase-box details-bg rounded-3 p-3 shadow-sm">
				<!-- Preço -->
				<?php woocommerce_template_single_price(); ?>

				<!-- Formulário de adicionar ao carrinho. Variações / Quantidade / Botão -->
				<?php woocommerce_template_single_add_to_cart(); ?>

				<!-- Info vendedor -->
				<div class="seller-info text-muted small mt-3">
					Vendido e entregue por <?php echo esc_html(get_bloginfo('name')); ?>
				</div>
			</div>

			<style>
				/* Caixa de compra */
				.purchase-box {
					background-color: #ffffff;
				}

				/* Preço */
				.purchase-box .price {
					font-size: 1.8rem;
					font-weight: 700;
					color: #212529;
					margin-bottom: 0;
				}

				/* Botão de compra */
				.purchase-box .single_add_to_cart_button {
					width: 100%;
					padding: 12px;
					font-size: 1rem;
					font-weight: 600;
				}

				/* Quantidade */
				.purchase-box .quantity {
					margin-bottom: 10px;
				}

				/* Produtos agrupados */
				.purchase-box table.group_table {
					width: 100%;
				}

				.purchase-box table.group_table td {
					vertical-align: middle;
					padding: 6px 0;
				}
			</style>
		</div>



		<?php
		get_footer('shop');
		?>
	</div>
</div>

<?php
get_footer('shop');

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
