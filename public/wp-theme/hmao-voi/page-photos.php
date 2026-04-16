<?php
/**
 * Template Name: Фотографии
 */
get_header();
?>

<section class="page-hero">
    <div class="container">
        <div class="page-hero__tag">🖼 Фотоархив</div>
        <h1><?php the_title(); ?></h1>
        <p>Фотоальбомы мероприятий и событий организации</p>
    </div>
</section>

<div class="page-content">
<div class="container">

    <?php
    $albums = get_posts([
        'post_type'      => 'voi_photo',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    ]);
    ?>

    <?php if ( empty($albums) ) : ?>
        <div class="voi-card" style="padding:40px; text-align:center; color:#64748B;">
            <div style="font-size:3rem; margin-bottom:16px;">🖼</div>
            <p>Фотоальбомы пока не добавлены.<br>Перейдите в <strong>Фотоальбомы → Добавить</strong> в панели управления.<br><br>
            В редакторе добавляйте фотографии с помощью блока <strong>«Галерея»</strong> Gutenberg.</p>
        </div>
    <?php else : ?>

    <div class="albums-grid">
        <?php foreach ( $albums as $album ) :
            $thumb = get_the_post_thumbnail( $album->ID, 'medium', [
                'class' => 'album-card__thumb',
                'style' => 'height:120px;object-fit:cover;',
                'alt'   => get_the_title($album),
            ]);
            $date  = get_the_date('F Y', $album->ID);
        ?>
        <div class="album-card">
            <?php if ( $thumb ) : ?>
                <?php echo $thumb; ?>
            <?php else : ?>
                <div class="album-card__thumb">🖼</div>
            <?php endif; ?>
            <div class="album-card__info">
                <div class="album-card__title"><?php echo esc_html( get_the_title($album) ); ?></div>
                <div class="album-card__meta">
                    <span><?php echo esc_html($date); ?></span>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Галереи из всех альбомов -->
    <?php foreach ( $albums as $album ) :
        $content = get_post_field('post_content', $album->ID);
        if ( ! $content ) continue;
    ?>
    <div style="margin-bottom:40px;">
        <h3 style="font-family:var(--font-head);color:var(--brand-dark);margin-bottom:16px;">
            <?php echo esc_html( get_the_title($album) ); ?>
        </h3>
        <div class="wp-gallery-wrapper">
            <?php echo apply_filters('the_content', $content); ?>
        </div>
    </div>
    <?php endforeach; ?>

    <?php endif; ?>

    <!-- Редактируемый контент страницы -->
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
        if ( get_the_content() ) : ?>
            <div class="entry-content" style="margin-top:28px;">
                <?php the_content(); ?>
            </div>
        <?php endif;
    endwhile; endif; ?>

</div>
</div>

<?php get_footer(); ?>
