<?php
/**
 * Template Name: Великие инвалиды планеты
 */
get_header();
?>
<div class="page-hero">
    <div class="container">
        <div class="page-hero__badge">⭐ Вдохновение</div>
        <h1>Великие инвалиды планеты</h1>
        <p>Люди, которые изменили мир, преодолев ограничения здоровья</p>
    </div>
</div>

<div class="famous-section">
<div class="container">
<?php
$persons = get_posts(['post_type'=>'voi_famous','numberposts'=>-1,'orderby'=>'menu_order','order'=>'ASC']);
if ($persons) :
?>
<div class="famous-grid">
<?php foreach ($persons as $p) :
    $years = get_post_meta($p->ID,'_voi_famous_years',true);
    $field = get_post_meta($p->ID,'_voi_famous_field',true);
    $emoji = get_post_meta($p->ID,'_voi_famous_emoji',true) ?: '⭐';
    $thumb = get_the_post_thumbnail($p->ID,'medium');
?>
<div class="famous-card">
    <div class="famous-card__photo"><?php echo $thumb ?: esc_html($emoji); ?></div>
    <div class="famous-card__body">
        <?php if ($years) : ?><div class="famous-card__years"><?php echo esc_html($years); ?></div><?php endif; ?>
        <div class="famous-card__name"><?php echo esc_html($p->post_title); ?></div>
        <?php if ($field) : ?><span class="famous-card__field"><?php echo esc_html($field); ?></span><?php endif; ?>
        <?php if ($p->post_content) : ?>
        <div class="famous-card__text"><?php echo esc_html(wp_trim_words($p->post_content,30)); ?></div>
        <?php endif; ?>
    </div>
</div>
<?php endforeach; wp_reset_postdata(); ?>
</div>
<?php else : ?>
<p style="color:var(--gray-600);padding:2rem 0;">Персоны пока не добавлены. Перейдите в <strong>Великие люди → Добавить</strong> в панели администратора.</p>
<?php endif; ?>
</div>
</div>

<?php get_footer(); ?>
