<?php
/**
 * Template Name: Структура ХМАО ВОИ
 */
get_header();

if ( have_posts() ) : while ( have_posts() ) : the_post();
?>
<div class="page-hero">
    <div class="container">
        <div class="page-hero__badge">🏛 Организация</div>
        <h1><?php the_title(); ?></h1>
        <p>Органы управления и местные отделения</p>
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
