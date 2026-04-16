<?php
/**
 * Template Name: О нас
 */
get_header();

if ( have_posts() ) : while ( have_posts() ) : the_post();
?>
<div class="page-hero">
    <div class="container">
        <div class="page-hero__badge">🤝 Общественная организация</div>
        <h1><?php the_title(); ?></h1>
        <p>Ханты-Мансийская региональная организация Всероссийского общества инвалидов</p>
    </div>
</div>

<div class="page-content">
    <div class="container">
        <div class="entry-content">
            <?php the_content(); ?>
        </div>
    </div>
</div>
<?php
endwhile; endif;
get_footer();
?>
