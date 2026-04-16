<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div class="site-wrapper">

<!-- ===== TOP BAR ===== -->
<div class="top-bar">
    <div class="container">
        <div class="top-bar__inner">

            <!-- Логотип + название -->
            <a href="<?php echo esc_url( home_url('/') ); ?>" class="site-branding">
                <?php if ( has_custom_logo() ) :
                    the_custom_logo();
                else : ?>
                    <div class="site-logo-placeholder">ВОИ</div>
                <?php endif; ?>
                <div>
                    <div class="site-name"><?php bloginfo('name'); ?></div>
                    <div class="site-tagline"><?php bloginfo('description'); ?></div>
                </div>
            </a>

            <!-- Кнопка версии для слабовидящих -->
            <button
                class="vi-toggle"
                id="vi-toggle"
                aria-label="Версия для слабовидящих"
                title="Версия для слабовидящих"
            >
                <?php echo hmao_icon('eye'); ?>
                <span class="vi-toggle__label">Версия для слабовидящих</span>
            </button>

        </div>
    </div>
</div><!-- .top-bar -->

<!-- ===== NAVIGATION ===== -->
<nav class="site-nav" role="navigation" aria-label="Основное меню">
    <div class="container">
        <div class="site-nav__inner">

            <?php wp_nav_menu( [
                'theme_location' => 'primary',
                'menu_class'     => 'main-menu',
                'container'      => false,
                'depth'          => 2,
                'fallback_cb'    => '__return_false',
            ] ); ?>

            <!-- Hamburger для мобильных -->
            <button class="nav-toggle" id="nav-toggle" aria-label="Открыть меню" aria-expanded="false">
                <span></span>
                <span></span>
                <span></span>
            </button>

        </div>
    </div>
</nav><!-- .site-nav -->

<main class="site-main" id="main">
