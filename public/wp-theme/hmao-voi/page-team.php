<?php
/**
 * Template Name: Команда
 */
get_header();
?>
<div class="page-hero">
    <div class="container">
        <div class="page-hero__badge">👥 Организация</div>
        <h1>Команда</h1>
        <p>Сотрудники и руководство ХМАО ВОИ</p>
    </div>
</div>

<div class="team-section">
<div class="container">
<?php
$members = get_posts(['post_type'=>'voi_team','numberposts'=>-1,'orderby'=>'menu_order','order'=>'ASC']);
if ( $members ) : ?>
<div class="team-grid">
<?php foreach ( $members as $m ) :
    $pos   = get_post_meta($m->ID,'_voi_position',true);
    $phone = get_post_meta($m->ID,'_voi_phone',   true);
    $email = get_post_meta($m->ID,'_voi_email',   true);
    $thumb = get_the_post_thumbnail($m->ID,'team-thumb');
?>
<div class="team-card">
    <div class="team-card__photo"><?php echo $thumb ?: '👤'; ?></div>
    <div class="team-card__body">
        <div class="team-card__name"><?php echo esc_html($m->post_title); ?></div>
        <?php if ($pos) : ?><div class="team-card__position"><?php echo esc_html($pos); ?></div><?php endif; ?>
        <div class="team-card__contacts">
            <?php if ($phone) : ?><a href="tel:<?php echo esc_attr(preg_replace('/[^+\d]/','', $phone)); ?>"><?php echo esc_html($phone); ?></a><?php endif; ?>
            <?php if ($email) : ?><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a><?php endif; ?>
        </div>
    </div>
</div>
<?php endforeach; wp_reset_postdata(); ?>
</div>
<?php else : ?>
<p style="color:var(--gray-600);padding:2rem 0;">Сотрудники пока не добавлены. Перейдите в <strong>Команда → Добавить</strong> в панели администратора.</p>
<?php endif; ?>
</div>
</div>

<?php get_footer(); ?>