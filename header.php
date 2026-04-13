<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php wp_head(); ?>
</head>


<body <?php body_class(); ?>>
    <header>
        <nav class="main-menu navbar navbar-expand-lg navbar-light py-2 fixed-top">
            <div class="container d-flex justify-content-between align-items-center flex-wrap gap-3">
                <!-- LOGO À ESQUERDA -->
                <a class="navbar-brand me-3 fw-bold" href="<?php echo home_url(); ?>">Vibe Fit
                    <!-- <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo.webp" alt="Logo" height="40" class="d-inline-block align-text-top"> -->
                </a>

                <!-- Botão de abertura do offcanvas -->
                <button class="btn d-md-none ms-auto me-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Abrir menu">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-list text-white" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1.5 12.5a.5.5 0 0 1 0-1h13a.5.5 0 0 1 0 1h-13zm0-4a.5.5 0 0 1 0-1h13a.5.5 0 0 1 0 1h-13zm0-4a.5.5 0 0 1 0-1h13a.5.5 0 0 1 0 1h-13z" />
                    </svg>
                </button>


                <!-- FORMULÁRIO DE BUSCA -->
                <form role="search" method="get" class="d-flex flex-grow-1 mx-3 pt-3" action="<?php echo esc_url(home_url('/')); ?>">
                    <div class="search-wrapper">
                        <div class="input-group">
                            <input type="search" class="form-control custom-busca-borda" id="live-search" placeholder="Digite aqui o nome do produto ..." value="<?php echo get_search_query(); ?>" name="s" />

                            <button class="btn btn-outline-secondary btn-custom-buscar" type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.397h-.001l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85zm-5.242 1.156a5 5 0 1 1 0-10 5 5 0 0 1 0 10z" />
                                </svg>
                            </button>
                        </div>
                        <!-- div para exibir o resultado da busca -->
                        <div id="live-search-results"></div>
                    </div>
                    <!-- este campo força a busca ser feita apenas em post_type = product,sem isso a busca iria ocorrer em posts, páginas, produto -->
                    <input type="hidden" name="post_type" value="product" />
                </form>

                <!-- MENU À DIREITA -->
                <div class="collapse navbar-collapse flex-grow-0 " id="navbarNav">
                    <ul class="navbar-nav main-menu d-flex align-items-center">
                        <?php
                        wp_nav_menu(array(
                            'theme_location'  => 'top_menu',
                            'container'       => false,
                            'menu_class'      => 'navbar-nav',
                            'fallback_cb'     => '__return_false',
                            'items_wrap'      => '%3$s',
                        ));
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- essas tag estao sendo fechadas no footer.php -->
    <main class="container mt-5 pt-5">
        <div class="row">