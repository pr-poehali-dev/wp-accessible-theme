<?php
/**
 * Template Name: Мероприятия
 */
get_header();
?>
<div class="page-hero">
    <div class="container">
        <div class="page-hero__badge">📅 Анонсы</div>
        <h1>Мероприятия</h1>
        <p>Конференции, семинары, спортивные и культурные события</p>
    </div>
</div>

<div class="events-section">
<div class="container">
<?php
$events = get_posts(['post_type'=>'voi_event','numberposts'=>-1,'orderby'=>'menu_order','order'=>'ASC']);
if ($events) :
?>
<div class="events-list">
<?php foreach ($events as $e) :
    $date  = get_post_meta($e->ID,'_voi_event_date', true);
    $time  = get_post_meta($e->ID,'_voi_event_time', true);
    $place = get_post_meta($e->ID,'_voi_event_place',true);
    $type  = get_post_meta($e->ID,'_voi_event_type', true);
    $day   = get_post_meta($e->ID,'_voi_event_day',  true) ?: substr($date,0,2);
    $month = get_post_meta($e->ID,'_voi_event_month',true) ?: '';
?>
<div class="event-card">
    <div class="event-card__date">
        <div class="event-card__day"><?php echo esc_html($day); ?></div>
        <div class="event-card__month"><?php echo esc_html($month); ?></div>
    </div>
    <div class="event-card__body">
        <?php if ($type) : ?><div class="event-card__type"><?php echo esc_html($type); ?></div><?php endif; ?>
        <div class="event-card__title"><?php echo esc_html($e->post_title); ?></div>
        <div class="event-card__meta">
            <?php if ($date) echo '<span>' . esc_html($date) . '</span>'; ?>
            <?php if ($time) echo '<span>' . esc_html($time) . '</span>'; ?>
            <?php if ($place) echo '<span>📍 ' . esc_html($place) . '</span>'; ?>
        </div>
        <?php if ($e->post_content) : ?>
        <p style="margin-top:.75rem;font-size:.88rem;color:var(--gray-600);"><?php echo esc_html(wp_trim_words($e->post_content,20)); ?></p>
        <?php endif; ?>
    </div>
</div>
<?php endforeach; wp_reset_postdata(); ?>
</div>
<?php else : ?>
<p style="color:var(--gray-600);padding:2rem 0;">Мероприятия пока не добавлены. Перейдите в <strong>Мероприятия → Добавить</strong> в панели администратора.</p>
<?php endif; ?>
</div>
</div>

<?php get_footer(); ?>
