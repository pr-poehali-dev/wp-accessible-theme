<?php
/**
 * Template Name: Конвенция ООН
 */
get_header();
?>

<section class="page-hero">
    <div class="container">
        <div class="page-hero__tag"><?php echo hmao_icon('globe'); ?> Международный документ</div>
        <h1><?php the_title(); ?></h1>
        <p>Принята резолюцией 61/106 Генеральной Ассамблеи от 13 декабря 2006 года</p>
    </div>
</section>

<div class="page-content">
<div class="container" style="max-width:900px;">

    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <div class="voi-card" style="padding:36px;">
        <span class="section-line"></span>
        <div class="entry-content">
            <?php the_content(); ?>
        </div>
    </div>
    <?php endwhile; endif; ?>

    <div style="margin-top:24px; background:var(--brand-dark); border-radius:var(--radius); padding:24px; color:#fff; display:flex; gap:16px; align-items:flex-start;">
        <span style="font-size:1.5rem; flex-shrink:0;">ℹ️</span>
        <div>
            <div style="font-weight:700; font-family:var(--font-head); margin-bottom:6px;">Значение для России</div>
            <p style="color:#BFDBFE; font-size:.9rem; line-height:1.6;">
                Россия ратифицировала Конвенцию 25 сентября 2012 года. Это обязывает Российскую Федерацию
                приводить законодательство в соответствие с её положениями и отчитываться перед Комитетом ООН
                о принятых мерах.
            </p>
            <a href="https://www.un.org/ru/documents/decl_conv/conventions/disability.shtml"
               target="_blank" rel="noopener noreferrer"
               class="btn-primary" style="margin-top:14px; display:inline-flex;">
                Полный текст на сайте ООН <?php echo hmao_icon('arrow'); ?>
            </a>
        </div>
    </div>

</div>
</div>

<?php get_footer(); ?>
