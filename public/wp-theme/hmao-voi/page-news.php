<?php
/**
 * Template Name: Новости
 */
get_header();
?>
<div class="page-hero">
    <div class="container">
        <div class="page-hero__badge">📰 Пресс-центр</div>
        <h1>Новости</h1>
        <p>Актуальные события и новости организации</p>
    </div>
</div>

<div class="news-section">
<div class="container">
<?php
$paged = get_query_var('paged') ?: 1;
$q = new WP_Query(['post_type'=>'post','posts_per_page'=>9,'paged'=>$paged,'post_status'=>'publish']);
if ($q->have_posts()) :
?>
<div class="news-grid">
<?php while ($q->have_posts()) : $q->the_post(); ?>
<div class="news-card">
    <?php if (has_post_thumbnail()) : ?>
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
<div class="pagination"><?php echo paginate_links(['total'=>$q->max_num_pages,'prev_text'=>'←','next_text'=>'→']); ?></div>
<?php wp_reset_postdata(); else : ?>
<p style="color:var(--gray-600);padding:2rem 0;">Новостей пока нет. Перейдите в <strong>Записи → Добавить</strong> в панели администратора.</p>
<?php endif; ?>
</div>
</div>

<?php get_footer(); ?>
