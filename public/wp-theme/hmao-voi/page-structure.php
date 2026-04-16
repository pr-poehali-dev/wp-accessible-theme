<?php
/**
 * Template Name: Структура ХМАО ВОИ
 */
get_header();
?>

<section class="page-hero">
    <div class="container">
        <div class="page-hero__tag">🏛 Организационная структура</div>
        <h1><?php the_title(); ?></h1>
        <p>Региональная организация и местные отделения</p>
    </div>
</section>

<div class="page-content">
<div class="container">

    <!-- Редактируемый контент страницы (основной) -->
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <div class="voi-card" style="padding:32px; margin-bottom:28px;">
        <span class="section-line"></span>
        <div class="entry-content">
            <?php the_content(); ?>
        </div>
    </div>
    <?php endwhile; endif; ?>

    <div class="voi-card" style="padding:24px; background:var(--brand-light); border-radius:var(--radius); text-align:center; color:#64748B;">
        <p>💡 <strong>Совет администратору:</strong> Редактируйте структуру прямо в редакторе этой страницы. Добавляйте блоки, таблицы, схемы, списки — всё через стандартный редактор WordPress.</p>
    </div>

</div>
</div>

<?php get_footer(); ?>
