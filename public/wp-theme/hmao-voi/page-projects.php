<?php
/**
 * Template Name: Проекты
 */
get_header();

$status_labels = [
    'active' => [ 'Активный',  'status-badge--active' ],
    'new'    => [ 'Новый',     'status-badge--new'    ],
    'done'   => [ 'Завершён',  'status-badge--done'   ],
];
?>

<section class="page-hero">
    <div class="container">
        <div class="page-hero__tag">🚀 Наша деятельность</div>
        <h1><?php the_title(); ?></h1>
        <p>Социальные проекты и программы организации</p>
    </div>
</section>

<div class="page-content">
<div class="container">

    <?php
    $projects = get_posts([
        'post_type'      => 'voi_project',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    ]);
    ?>

    <?php if ( empty($projects) ) : ?>
        <div class="voi-card" style="padding:40px; text-align:center; color:#64748B;">
            <div style="font-size:3rem; margin-bottom:16px;">🚀</div>
            <p>Проекты пока не добавлены.<br>Перейдите в <strong>Проекты → Добавить проект</strong> в панели управления.</p>
        </div>
    <?php else : ?>

    <div class="projects-grid">
        <?php foreach ( $projects as $project ) :
            $status = get_post_meta( $project->ID, '_voi_project_status', true ) ?: 'active';
            $period = get_post_meta( $project->ID, '_voi_project_period', true );
            $tags   = get_post_meta( $project->ID, '_voi_project_tags',   true );
            [ $status_label, $status_class ] = $status_labels[ $status ] ?? [ 'Активный', 'status-badge--active' ];
        ?>
        <div class="project-card">
            <div class="project-card__header">
                <div class="project-card__icon">
                    <?php if ( has_post_thumbnail($project->ID) ) :
                        echo get_the_post_thumbnail( $project->ID, [44,44], ['style'=>'width:44px;height:44px;object-fit:cover;border-radius:10px;'] );
                    else : ?>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    <?php endif; ?>
                </div>
                <span class="status-badge <?php echo esc_attr($status_class); ?>"><?php echo esc_html($status_label); ?></span>
            </div>

            <div class="project-card__title"><?php echo esc_html( get_the_title($project) ); ?></div>

            <?php if ( $period ) : ?>
                <div class="project-card__meta">
                    <?php echo hmao_icon('calendar'); ?> <?php echo esc_html($period); ?>
                </div>
            <?php endif; ?>

            <div class="project-card__desc">
                <?php echo esc_html( wp_trim_words( get_post_field('post_content', $project->ID), 30 ) ); ?>
            </div>

            <?php if ( $tags ) : ?>
                <div class="project-card__tags">
                    <?php foreach ( array_map('trim', explode(',', $tags)) as $tag ) : ?>
                        <span class="tag"><?php echo esc_html($tag); ?></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
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
