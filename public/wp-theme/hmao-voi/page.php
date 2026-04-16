<?php
/**
 * Шаблон обычной страницы — с баннером и Gutenberg-редактором
 */
get_header();

if ( have_posts() ) : while ( have_posts() ) : the_post();
?>
<div class="page-hero">
    <div class="container">
        <div class="page-hero__badge">📄 Страница</div>
        <h1><?php the_title(); ?></h1>
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
