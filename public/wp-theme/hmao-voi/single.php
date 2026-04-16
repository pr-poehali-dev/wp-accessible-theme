<?php
/**
 * Шаблон одиночной записи (новость)
 */
get_header();

if ( have_posts() ) : while ( have_posts() ) : the_post();
?>
<div class="page-hero">
    <div class="container">
        <div class="page-hero__badge">📰 Новость</div>
        <h1><?php the_title(); ?></h1>
        <p><?php echo get_the_date('d F Y'); ?></p>
    </div>
</div>

<div class="page-content">
<div class="container">
    <article class="single-post">
        <?php if ( has_post_thumbnail() ) : ?>
        <div class="single-post__thumb"><?php the_post_thumbnail('large'); ?></div>
        <?php endif; ?>
        <div class="single-post__content entry-content">
            <?php the_content(); ?>
        </div>
        <div style="margin-top:2rem;padding-top:1.5rem;border-top:1px solid var(--gray-200);display:flex;justify-content:space-between;gap:1rem;flex-wrap:wrap;">
            <?php $prev = get_previous_post(); if ($prev) : ?>
                <a href="<?php echo get_permalink($prev); ?>" style="color:var(--brand-accent);font-weight:600;">← <?php echo esc_html(get_the_title($prev)); ?></a>
            <?php endif; ?>
            <?php $next = get_next_post(); if ($next) : ?>
                <a href="<?php echo get_permalink($next); ?>" style="color:var(--brand-accent);font-weight:600;margin-left:auto;"><?php echo esc_html(get_the_title($next)); ?> →</a>
            <?php endif; ?>
        </div>
    </article>
</div>
</div>

<?php endwhile; endif; get_footer(); ?>
