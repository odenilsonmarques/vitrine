<?php

// Função para enfileirar os estilos do tema pai e do tema filho
function vitrine_enqueue_styles()
{
    // carrega o style do tema pai (Storefront)
    wp_enqueue_style('storefront-style', get_template_directory_uri() . '/style.css');

    //carrega o css do bootstrap
    wp_enqueue_style('bootstrap-min-css', get_stylesheet_directory_uri() . '/assets/css/bootstrap.min.css', array(), '5.0.2');

    // carrega o style do tema filho depois. O argumento array('storefront-style') garante que o estilo do tema pai seja carregado primeiro
    wp_enqueue_style('vitrine-style', get_stylesheet_directory_uri(), array('storefront-style'), '1.0');

    //carrega o script do bootstrap
    wp_enqueue_script('bootstrap-min-js', get_stylesheet_directory_uri() . '/assets/js/bootstrap.bundle.min.js', array(), '5.0.2', true);

    //carrega o script para filtrar produtos por categoria
    wp_enqueue_script('filter-products', get_stylesheet_directory_uri() . '/assets/js/filter-products.js', array(), '1.0', true);

    //carrega o script para calcular o total do produto agrupado
    // wp_enqueue_script('product-total', get_stylesheet_directory_uri() . '/assets/js/product-total.js', array(), '1.5', true);

    //carrega o script para busca em tempo real (live search)
    wp_enqueue_script('live-search', get_stylesheet_directory_uri() . '/assets/js/live-search.js', array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'vitrine_enqueue_styles');


register_nav_menus(array(
    //top_menu é o identificador do menu, passado no header.php
    //Top Menu é o nome que aparecerá no painel do WordPress
    //vitrine é o text domain do tema(nome do tema)
    'top_menu' => __('Top Menu', 'vitrine'),
));











// Hooks AJAX do WordPress para a funcionalidade de busca em tempo real (live search)
//
// wp_ajax_live_search:
//   Executa a função live_search para usuários autenticados (logados)
//
// wp_ajax_nopriv_live_search:
//   Executa a função live_search para usuários não autenticados (visitantes)
//
// Ambos são necessários para garantir que a busca funcione para qualquer usuário no frontend
add_action('wp_ajax_live_search', 'live_search');
add_action('wp_ajax_nopriv_live_search', 'live_search');

function live_search()
{
    $term = sanitize_text_field($_GET['term']);

    if (empty($term)) {
        wp_send_json([]);
    }

    $args = [
        'post_type' => 'product',
        'posts_per_page' => 5,
        's' => $term
    ];

    $query = new WP_Query($args);

    $results = [];

    while ($query->have_posts()) {
        $query->the_post();

        $results[] = [
            'title' => get_the_title(),
            'link' => get_permalink(),
            'image' => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail')
        ];
    }

    wp_reset_postdata();

    wp_send_json($results);
}
