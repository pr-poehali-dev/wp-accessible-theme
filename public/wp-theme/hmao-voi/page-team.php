<?php
/**
 * Template Name: Команда
 * Страница с карточками сотрудников
 */
get_header();
?>

<section class="page-hero">
    <div class="container">
        <div class="page-hero__tag">👥 Наша команда</div>
        <h1><?php the_title(); ?></h1>
        <p>Сотрудники и руководство организации</p>
    </div>
</section>

<div class="page-content">
<div class="container">

    <?php
    $team = get_posts([
        'post_type'      => 'voi_team',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    ]);
    ?>

    <?php if ( empty($team) ) : ?>
        <div class="voi-card" style="padding:40px; text-align:center; color:#64748B;">
            <div style="font-size:3rem; margin-bottom:16px;">👥</div>
            <p>Сотрудники пока не добавлены. <br>Перейдите в <strong>Сотрудники → Добавить сотрудника</strong> в панели управления.</p>
        </div>
    <?php else : ?>

    <div class="team-grid">
        <?php foreach ( $team as $member ) :
            $position = get_post_meta( $member->ID, '_voi_position', true );
            $email    = get_post_meta( $member->ID, '_voi_email',    true );
            $phone    = get_post_meta( $member->ID, '_voi_phone',    true );
            $thumb    = get_the_post_thumbnail( $member->ID, 'team-thumb', [ 'class' => 'team-card__photo', 'alt' => get_the_title($member) ] );
        ?>
        <div class="team-card">
            <?php if ( $thumb ) : ?>
                <?php echo $thumb; ?>
            <?php else : ?>
                <div class="team-card__photo-placeholder">👤</div>
            <?php endif; ?>
            <div class="team-card__info">
                <div class="team-card__name"><?php echo esc_html( get_the_title($member) ); ?></div>
                <?php if ( $position ) : ?>
                    <div class="team-card__position"><?php echo esc_html( $position ); ?></div>
                <?php endif; ?>
                <?php if ( $phone || $email ) : ?>
                    <div style="margin-top:10px; font-size:.8rem; color:#64748B; display:flex; flex-direction:column; gap:4px;">
                        <?php if ($phone) : ?>
                            <span><?php echo hmao_icon('phone'); ?> <?php echo esc_html($phone); ?></span>
                        <?php endif; ?>
                        <?php if ($email) : ?>
                            <a href="mailto:<?php echo esc_attr($email); ?>" style="color:var(--brand-accent);">
                                <?php echo hmao_icon('mail'); ?> <?php echo esc_html($email); ?>
                            </a>
                        <?php endif; ?>
                    </div>
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
