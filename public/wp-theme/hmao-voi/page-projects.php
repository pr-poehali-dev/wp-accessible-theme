<?php
/**
 * Template Name: Проекты
 */
get_header();
?>
<div class="page-hero">
    <div class="container">
        <div class="page-hero__badge">🚀 Деятельность</div>
        <h1>Проекты</h1>
        <p>Социальные, правозащитные и реабилитационные проекты организации</p>
    </div>
</div>

<div class="projects-section">
<div class="container">
<?php
$projects = get_posts(['post_type'=>'voi_project','numberposts'=>-1,'orderby'=>'menu_order','order'=>'ASC']);
if ($projects) :
?>
<div class="projects-grid">
<?php foreach ($projects as $p) :
    $status = get_post_meta($p->ID,'_voi_project_status',true) ?: 'active';
    $period = get_post_meta($p->ID,'_voi_project_period',true);
    $tags   = get_post_meta($p->ID,'_voi_project_tags',  true);
    $thumb  = get_the_post_thumbnail($p->ID,'medium');
    $status_labels = ['active'=>'Активный','new'=>'Новый','done'=>'Завершён'];
    $slabel = $status_labels[$status] ?? 'Активный';
?>
<div class="project-card">
    <div class="project-card__thumb"><?php echo $thumb ?: '🚀'; ?></div>
    <div class="project-card__body">
        <span class="project-card__status status-<?php echo esc_attr($status); ?>"><?php echo esc_html($slabel); ?></span>
        <div class="project-card__title"><?php echo esc_html($p->post_title); ?></div>
        <div class="project-card__text"><?php echo esc_html(wp_trim_words($p->post_content,25)); ?></div>
    </div>
    <?php if ($period || $tags) : ?>
    <div class="project-card__footer">
        <?php if ($period) : ?><span><?php echo esc_html($period); ?></span><?php endif; ?>
        <?php if ($tags)   : ?><span><?php echo esc_html($tags); ?></span><?php endif; ?>
    </div>
    <?php endif; ?>
</div>
<?php endforeach; wp_reset_postdata(); ?>
</div>
<?php else : ?>
<p style="color:var(--gray-600);padding:2rem 0;">Проекты пока не добавлены. Перейдите в <strong>Проекты → Добавить</strong> в панели администратора.</p>
<?php endif; ?>
</div>
</div>

<?php get_footer(); ?>
