<?php
/**
 * Шаблон для обычных страниц
 */
get_header();
?>

<section class="page-hero">
    <div class="container">
        <h1><?php the_title(); ?></h1>
    </div>
</section>

<div class="page-content">
<div class="container">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <div class="voi-card single-post" style="padding:36px;">
        <?php if ( has_post_thumbnail() ) : ?>
            <div class="post-thumbnail"><?php the_post_thumbnail('large'); ?></div>
        <?php endif; ?>
        <div class="entry-content">
            <?php the_content(); ?>
        </div>
    </div>
    <?php endwhile; endif; ?>
</div>
</div>

<?php get_footer(); ?>
