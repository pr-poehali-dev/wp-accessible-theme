<?php
/**
 * Резервный шаблон
 */
get_header();
?>

<section class="page-hero">
    <div class="container">
        <h1><?php
        if ( is_home() )           { bloginfo('name'); }
        elseif ( is_category() )   { single_cat_title(); }
        elseif ( is_tag() )        { single_tag_title(); }
        elseif ( is_archive() )    { post_type_archive_title(); }
        elseif ( is_search() )     { echo 'Поиск: ' . get_search_query(); }
        elseif ( is_404() )        { echo 'Страница не найдена'; }
        else                        { the_title(); }
        ?></h1>
    </div>
</section>

<div class="page-content">
<div class="container">

    <?php if ( is_404() ) : ?>
        <div class="voi-card" style="padding:48px; text-align:center;">
            <div style="font-size:4rem; margin-bottom:16px;">🔍</div>
            <h2 style="margin-bottom:12px;">Страница не найдена</h2>
            <p style="color:#64748B; margin-bottom:20px;">Запрашиваемая страница была удалена или не существует.</p>
            <a href="<?php echo esc_url(home_url('/')); ?>" class="btn-primary">← На главную</a>
        </div>
    <?php elseif ( have_posts() ) : ?>
        <div class="news-list">
        <?php while ( have_posts() ) : the_post(); ?>
            <div class="news-card">
                <div class="news-card__meta">
                    <span class="news-card__date"><?php echo hmao_icon('calendar'); ?> <?php echo get_the_date('d F Y'); ?></span>
                </div>
                <h3 class="news-card__title">
                    <a href="<?php the_permalink(); ?>" style="color:inherit;text-decoration:none;"><?php the_title(); ?></a>
                </h3>
                <div class="news-card__excerpt"><?php the_excerpt(); ?></div>
                <a href="<?php the_permalink(); ?>" class="read-more">Читать далее <?php echo hmao_icon('arrow'); ?></a>
            </div>
        <?php endwhile; ?>
        </div>
        <div style="margin-top:24px;"><?php the_posts_pagination(); ?></div>
    <?php else : ?>
        <div class="voi-card" style="padding:40px; text-align:center; color:#64748B;">
            <p>Записи не найдены.</p>
        </div>
    <?php endif; ?>

</div>
</div>

<?php get_footer(); ?>
