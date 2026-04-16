<?php
/**
 * Template Name: Новости
 */
get_header();
?>

<section class="page-hero">
    <div class="container">
        <div class="page-hero__tag">📰 Актуальные события</div>
        <h1><?php the_title(); ?></h1>
        <p>Последние новости организации</p>
    </div>
</section>

<div class="page-content">
<div class="container">

    <?php
    $paged = get_query_var('paged') ?: 1;
    $query = new WP_Query([
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => 10,
        'paged'          => $paged,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ]);
    ?>

    <?php if ( ! $query->have_posts() ) : ?>
        <div class="voi-card" style="padding:40px; text-align:center; color:#64748B;">
            <div style="font-size:3rem; margin-bottom:16px;">📰</div>
            <p>Новости пока не добавлены.<br>Перейдите в <strong>Записи → Добавить</strong> в панели управления.</p>
        </div>
    <?php else : ?>

    <div class="news-list">
        <?php while ( $query->have_posts() ) : $query->the_post(); ?>
        <div class="news-card">
            <?php if ( has_post_thumbnail() ) : ?>
                <div class="post-thumbnail" style="margin-bottom:16px;">
                    <?php the_post_thumbnail('news-thumb', ['style'=>'width:100%;height:200px;object-fit:cover;border-radius:8px;']); ?>
                </div>
            <?php endif; ?>
            <div class="news-card__meta">
                <?php $cats = get_the_category(); if ($cats) : ?>
                    <span class="news-card__cat"><?php echo esc_html( $cats[0]->name ); ?></span>
                <?php endif; ?>
                <span class="news-card__date"><?php echo hmao_icon('calendar'); ?> <?php echo get_the_date('d F Y'); ?></span>
            </div>
            <h3 class="news-card__title">
                <a href="<?php the_permalink(); ?>" style="color:inherit;text-decoration:none;">
                    <?php the_title(); ?>
                </a>
            </h3>
            <div class="news-card__excerpt"><?php the_excerpt(); ?></div>
            <a href="<?php the_permalink(); ?>" class="read-more">
                Читать далее <?php echo hmao_icon('arrow'); ?>
            </a>
        </div>
        <?php endwhile; wp_reset_postdata(); ?>
    </div>

    <!-- Пагинация -->
    <?php if ( $query->max_num_pages > 1 ) : ?>
    <div style="margin-top:32px; display:flex; justify-content:center; gap:8px; flex-wrap:wrap;">
        <?php echo paginate_links([
            'total'   => $query->max_num_pages,
            'current' => $paged,
            'prev_text' => '← Назад',
            'next_text' => 'Вперёд →',
            'type'    => 'array',
        ]) ? implode('', array_map(fn($l) => "<div style='padding:6px 12px;border-radius:6px;background:#fff;box-shadow:var(--shadow-sm);'>$l</div>", paginate_links(['total'=>$query->max_num_pages,'current'=>$paged,'type'=>'array','prev_text'=>'← Назад','next_text'=>'Вперёд →']))) : ''; ?>
    </div>
    <?php endif; ?>

    <?php endif; ?>

</div>
</div>

<?php get_footer(); ?>
