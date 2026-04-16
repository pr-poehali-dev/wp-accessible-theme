<?php
/**
 * Резервный шаблон / Архив записей
 */
get_header();
?>

<div class="page-hero">
    <div class="container">
        <h1><?php
            if ( is_home() )         bloginfo('name');
            elseif ( is_category() ) single_cat_title();
            elseif ( is_tag() )      single_tag_title();
            elseif ( is_archive() )  post_type_archive_title();
            elseif ( is_search() )   echo 'Поиск: ' . esc_html(get_search_query());
            elseif ( is_404() )      echo 'Страница не найдена';
            else                     the_title();
        ?></h1>
    </div>
</div>

<div class="page-content">
<div class="container">
<?php if ( is_404() ) : ?>
    <div style="text-align:center;padding:60px 0;">
        <div style="font-size:4rem;margin-bottom:16px;">🔍</div>
        <h2>Страница не найдена</h2>
        <p style="color:var(--gray-600);margin:12px 0 24px;">Запрашиваемая страница не существует.</p>
        <a href="<?php echo esc_url(home_url('/')); ?>" style="background:var(--brand-dark);color:#fff;padding:.75rem 2rem;border-radius:8px;font-weight:700;text-decoration:none;">← На главную</a>
    </div>
<?php elseif ( have_posts() ) : ?>
    <div class="news-grid">
    <?php while ( have_posts() ) : the_post(); ?>
        <div class="news-card">
            <?php if ( has_post_thumbnail() ) : ?>
            <div class="news-card__thumb"><?php the_post_thumbnail('news-thumb'); ?></div>
            <?php endif; ?>
            <div class="news-card__body">
                <div class="news-card__date"><?php echo get_the_date('d F Y'); ?></div>
                <div class="news-card__title"><a href="<?php the_permalink(); ?>" style="color:inherit;text-decoration:none;"><?php the_title(); ?></a></div>
                <div class="news-card__excerpt"><?php the_excerpt(); ?></div>
                <a href="<?php the_permalink(); ?>" class="news-card__link">Читать далее →</a>
            </div>
        </div>
    <?php endwhile; ?>
    </div>
    <div class="pagination"><?php the_posts_pagination(['prev_text'=>'←','next_text'=>'→']); ?></div>
<?php else : ?>
    <p style="color:var(--gray-600);padding:40px 0;">Записи не найдены.</p>
<?php endif; ?>
</div>
</div>

<?php get_footer(); ?>
