<?php
/**
 * Шаблон одиночной записи (новости)
 */
get_header();
?>

<section class="page-hero">
    <div class="container">
        <div class="page-hero__tag">📰 Новость</div>
        <h1><?php the_title(); ?></h1>
    </div>
</section>

<div class="page-content">
<div class="container">

    <?php hmao_breadcrumbs(); ?>

    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

    <article class="voi-card single-post" style="padding:36px; max-width:820px;">

        <div class="post-meta">
            <span><?php echo hmao_icon('calendar'); ?> <?php echo get_the_date('d F Y'); ?></span>
            <?php $cats = get_the_category(); if ($cats) : ?>
                <span><?php echo esc_html($cats[0]->name); ?></span>
            <?php endif; ?>
            <?php if ($author = get_the_author()) : ?>
                <span><?php echo hmao_icon('user'); ?> <?php echo esc_html($author); ?></span>
            <?php endif; ?>
        </div>

        <?php if ( has_post_thumbnail() ) : ?>
            <div class="post-thumbnail">
                <?php the_post_thumbnail('large', ['style' => 'width:100%;height:340px;object-fit:cover;']); ?>
            </div>
        <?php endif; ?>

        <div class="post-content entry-content" style="margin-top:24px;">
            <?php the_content(); ?>
        </div>

        <!-- Навигация -->
        <div style="display:flex; justify-content:space-between; margin-top:32px; padding-top:20px; border-top:1px solid #F1F5F9; gap:16px; flex-wrap:wrap;">
            <?php $prev = get_previous_post(); if ($prev) : ?>
                <a href="<?php echo get_permalink($prev); ?>" class="btn-primary" style="font-size:.85rem;">
                    ← <?php echo esc_html(get_the_title($prev)); ?>
                </a>
            <?php endif; ?>
            <?php $next = get_next_post(); if ($next) : ?>
                <a href="<?php echo get_permalink($next); ?>" class="btn-primary" style="font-size:.85rem; margin-left:auto;">
                    <?php echo esc_html(get_the_title($next)); ?> →
                </a>
            <?php endif; ?>
        </div>

    </article>

    <?php endwhile; endif; ?>

</div>
</div>

<?php get_footer(); ?>
