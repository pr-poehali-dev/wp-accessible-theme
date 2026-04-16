<?php
/**
 * Template Name: Мероприятия
 */
get_header();
?>

<section class="page-hero">
    <div class="container">
        <div class="page-hero__tag"><?php echo hmao_icon('calendar'); ?> Предстоящие события</div>
        <h1><?php the_title(); ?></h1>
        <p>Афиша событий ХМАО ВОИ</p>
    </div>
</section>

<div class="page-content">
<div class="container">

    <?php
    $events = get_posts([
        'post_type'      => 'voi_event',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    ]);
    ?>

    <?php if ( empty($events) ) : ?>
        <div class="voi-card" style="padding:40px; text-align:center; color:#64748B;">
            <div style="font-size:3rem; margin-bottom:16px;">📅</div>
            <p>Мероприятия пока не добавлены.<br>Перейдите в <strong>Мероприятия → Добавить</strong> в панели управления.</p>
        </div>
    <?php else : ?>

    <div class="events-list">
        <?php foreach ( $events as $event ) :
            $date  = get_post_meta( $event->ID, '_voi_event_date',  true );
            $time  = get_post_meta( $event->ID, '_voi_event_time',  true );
            $place = get_post_meta( $event->ID, '_voi_event_place', true );
            $type  = get_post_meta( $event->ID, '_voi_event_type',  true );
            $day   = get_post_meta( $event->ID, '_voi_event_day',   true );
            $month = get_post_meta( $event->ID, '_voi_event_month', true );
        ?>
        <div class="event-card">
            <div class="event-card__date-block">
                <div class="event-card__day"><?php echo esc_html( $day ?: '' ); ?></div>
                <div class="event-card__month"><?php echo esc_html( $month ?: '' ); ?></div>
            </div>
            <div class="event-card__body">
                <?php if ( $type ) : ?>
                    <div class="event-card__type"><?php echo esc_html($type); ?><?php if ($time) echo ' · ' . esc_html($time); ?></div>
                <?php endif; ?>
                <div class="event-card__title"><?php echo esc_html( get_the_title($event) ); ?></div>
                <?php if ( $place ) : ?>
                    <div class="event-card__location"><?php echo hmao_icon('map-pin'); ?> <?php echo esc_html($place); ?></div>
                <?php endif; ?>
                <?php
                $content = get_post_field('post_content', $event->ID);
                if ( $content ) : ?>
                    <div class="event-card__desc"><?php echo esc_html( wp_trim_words($content, 30) ); ?></div>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <?php endif; ?>

    <!-- Редактируемый контент страницы -->
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
        if ( get_the_content() ) : ?>
            <div class="entry-content voi-card" style="padding:28px; margin-top:28px;">
                <?php the_content(); ?>
            </div>
        <?php endif;
    endwhile; endif; ?>

</div>
</div>

<?php get_footer(); ?>
