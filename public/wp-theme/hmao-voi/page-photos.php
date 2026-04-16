<?php
/**
 * Template Name: Фотографии
 */
get_header();
?>
<div class="page-hero">
    <div class="container">
        <div class="page-hero__badge">📷 Галерея</div>
        <h1>Фотографии</h1>
        <p>Фотоотчёты с мероприятий и событий организации</p>
    </div>
</div>

<div class="photos-section">
<div class="container">
<?php
$albums = get_posts(['post_type'=>'voi_album','numberposts'=>-1,'orderby'=>'menu_order','order'=>'ASC']);
if ($albums) :
?>
<div class="photo-albums-grid">
<?php foreach ($albums as $a) :
    $thumb = get_the_post_thumbnail($a->ID,'medium_large');
?>
<div class="photo-album-card">
    <div class="photo-album-card__thumb"><?php echo $thumb ?: '<div style="height:200px;background:linear-gradient(135deg,var(--brand-dark),var(--brand-mid));display:flex;align-items:center;justify-content:center;font-size:3rem;">📷</div>'; ?></div>
    <div class="photo-album-card__body">
        <div class="photo-album-card__title"><?php echo esc_html($a->post_title); ?></div>
        <?php if ($a->post_content) : ?>
        <div class="photo-album-card__count"><?php echo esc_html(wp_trim_words($a->post_content,10)); ?></div>
        <?php endif; ?>
    </div>
</div>
<?php endforeach; wp_reset_postdata(); ?>
</div>
<?php else : ?>
<p style="color:var(--gray-600);padding:2rem 0;">Альбомы пока не добавлены. Перейдите в <strong>Фотоальбомы → Добавить</strong> в панели администратора.</p>
<?php endif; ?>
</div>
</div>

<?php get_footer(); ?>
