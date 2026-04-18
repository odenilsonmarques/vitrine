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

            <!-- Carrossel mobile com as primeiras categorias e botão Ver Todas -->
            <div class="category-container-mobile mb-5 d-flex d-md-none align-items-start">
                <div class="category-card filter-btn active" data-category="">
                    <div class="category-img">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/default.png" alt="Todos">
                    </div>
                    <p>Todos</p>
                </div>

                <?php
                $mobile_categories = array_slice($categories, 0, 5);
                foreach ($mobile_categories as $category) {
                    $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
                    $image_url = wp_get_attachment_url($thumbnail_id);

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

                <div class="category-card category-see-all" data-bs-toggle="modal" data-bs-target="#allCategoriesModal">
                    <div class="category-img">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/default.png" alt="Ver todas">
                    </div>
                    <p>Ver todas</p>
                </div>
            </div>

            <!-- Modal com todas as categorias -->
            <div class="modal fade" id="allCategoriesModal" tabindex="-1" aria-labelledby="allCategoriesModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="allCategoriesModalLabel">Todas as categorias</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                        </div>
                        <div class="modal-body">
                            <div class="all-categories-list d-flex flex-wrap justify-content-start gap-3">
                                <?php
                                foreach ($categories as $category) {
                                    $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
                                    $image_url = wp_get_attachment_url($thumbnail_id);
                                    if (!$image_url) {
                                        $image_url = get_stylesheet_directory_uri() . '/assets/img/default.png';
                                    }
                                    $category_link = get_term_link($category);
                                    echo '<a href="' . esc_url($category_link) . '" class="category-card category-card-modal">
                                            <div class="category-img">
                                                <img src="' . esc_url($image_url) . '" alt="' . esc_attr($category->name) . '">
                                            </div>
                                            <p>' . esc_html($category->name) . '</p>
                                        </a>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>