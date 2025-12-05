<section class="category">
    <div class="container">
        <div class="categories-section text-center mt-2">
            <h3 class="category-title mb-4 mt-5 mb-4">Categorias</h3>
            <div class="category-container text-center mb-5 d-none d-md-flex justify-content-center flex-wrap">
                <!-- Exibe a opção "Todos" -->
                <div class="category-card filter-btn active" data-category="">
                    <div class="category-img">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/default.png" alt="Todos">
                    </div>
                    <p>Todos</p>
                </div>

                <?php
                $categories = get_terms(array(
                    'taxonomy'   => 'product_cat',
                    'hide_empty' => true,
                ));

                foreach ($categories as $category) {
                    // Tenta pegar a imagem da categoria
                    $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
                    $image_url = wp_get_attachment_url($thumbnail_id);

                    // Se não tiver imagem, define uma padrão
                    if (!$image_url) {
                        $image_url = get_stylesheet_directory_uri() . '/assets/img/default.png';
                    }
                    echo '
                        <div class="category-card filter-btn" data-category="' . $category->term_id . '">
                            <div class="category-img">
                                <img src="' . esc_url($image_url) . '" alt="' . esc_attr($category->name) . '">
                            </div>
                            <p>' . esc_html($category->name) . '</p>
                        </div>';
                }
                ?>
            </div>
        </div>
    </div>
</section>