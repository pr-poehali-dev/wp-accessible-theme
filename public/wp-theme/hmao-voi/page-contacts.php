<?php
/**
 * Template Name: Контакты
 */
get_header();

if ( have_posts() ) : while ( have_posts() ) : the_post();
?>
<div class="page-hero">
    <div class="container">
        <div class="page-hero__badge">📞 Контакты</div>
        <h1><?php the_title(); ?></h1>
        <p>Свяжитесь с нами любым удобным способом</p>
    </div>
</div>

<div class="page-content">
    <div class="container entry-content">
        <?php the_content(); ?>
    </div>
</div>
<?php
endwhile; endif;
get_footer();
?>
