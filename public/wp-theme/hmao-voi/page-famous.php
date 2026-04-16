<?php
/**
 * Template Name: Великие инвалиды планеты
 */
get_header();
?>

<section class="page-hero">
    <div class="container">
        <div class="page-hero__tag">⭐ Вдохновляющие истории</div>
        <h1><?php the_title(); ?></h1>
        <p>Люди, преодолевшие ограничения и изменившие мир — своим трудом, талантом и силой духа</p>
    </div>
</section>

<div class="page-content">
<div class="container">

    <?php
    $people = get_posts([
        'post_type'      => 'voi_famous',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    ]);
    ?>

    <?php if ( empty($people) ) : ?>
        <div class="voi-card" style="padding:40px; text-align:center; color:#64748B;">
            <div style="font-size:3rem; margin-bottom:16px;">⭐</div>
            <p>Записи пока не добавлены.<br>Перейдите в <strong>Великие инвалиды → Добавить</strong> в панели управления.</p>
        </div>
    <?php else : ?>

    <div class="people-grid">
        <?php foreach ( $people as $person ) :
            $years = get_post_meta( $person->ID, '_voi_famous_years', true );
            $field = get_post_meta( $person->ID, '_voi_famous_field', true );
            $emoji = get_post_meta( $person->ID, '_voi_famous_emoji', true );
            $thumb = get_the_post_thumbnail( $person->ID, 'person-thumb', [
                'class' => 'person-card__photo',
                'alt'   => get_the_title($person),
            ]);
        ?>
        <div class="person-card">
            <?php if ( $thumb ) : ?>
                <?php echo $thumb; ?>
            <?php else : ?>
                <div class="person-card__photo-placeholder"><?php echo esc_html( $emoji ?: '🌟' ); ?></div>
            <?php endif; ?>

            <div class="person-card__name"><?php echo esc_html( get_the_title($person) ); ?></div>
            <?php if ( $years ) : ?><div class="person-card__years"><?php echo esc_html($years); ?></div><?php endif; ?>
            <?php if ( $field ) : ?><div class="person-card__field"><?php echo esc_html($field); ?></div><?php endif; ?>

            <?php $content = get_post_field('post_content', $person->ID);
            if ( $content ) : ?>
                <div class="person-card__desc"><?php echo wp_kses_post( wpautop( $content ) ); ?></div>
            <?php else : ?>
                <div class="person-card__desc"><?php echo esc_html( get_the_excerpt_by_id($person->ID) ); ?></div>
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
