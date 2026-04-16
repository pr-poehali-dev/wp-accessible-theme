<?php
/**
 * Шаблон главной страницы
 */
get_header();
?>

<!-- HERO -->
<section class="page-hero">
    <div class="container">
        <div class="page-hero__tag">
            <span>🤝</span> Общественная организация
        </div>
        <h1><?php bloginfo('name'); ?></h1>
        <p><?php bloginfo('description'); ?></p>
    </div>
</section>

<!-- БЛОК ДОСТИЖЕНИЙ -->
<section class="achievements">
    <div class="container">
        <span class="section-line"></span>
        <h2 class="section-title">Наши достижения</h2>
        <div class="achievements__grid">
            <?php for ( $i = 1; $i <= 4; $i++ ) :
                $ach = hmao_achievement( $i );
                if ( ! $ach['num'] && ! $ach['label'] ) continue;
            ?>
            <div class="achievement-card">
                <div class="achievement-card__icon">
                    <span style="font-size:1.5rem"><?php echo esc_html( $ach['icon'] ); ?></span>
                </div>
                <div class="achievement-card__number"><?php echo esc_html( $ach['num'] ); ?></div>
                <div class="achievement-card__label"><?php echo esc_html( $ach['label'] ); ?></div>
            </div>
            <?php endfor; ?>
        </div>
    </div>
</section>

<!-- ВВЕДЕНИЕ -->
<section class="home-intro">
    <div class="container">
        <?php
        $about_page = get_page_by_path('about');
        if ( $about_page ) :
            $content = wp_trim_words( get_post_field('post_content', $about_page->ID), 80 );
        ?>
        <div class="home-intro__grid">
            <div class="home-intro__text">
                <span class="section-line"></span>
                <h2 class="section-title">О нашей организации</h2>
                <p><?php echo esc_html( $content ); ?></p>
                <a href="<?php echo get_permalink( $about_page->ID ); ?>" class="btn-primary">
                    Подробнее <?php echo hmao_icon('arrow'); ?>
                </a>
            </div>
            <div class="home-intro__stats">
                <?php
                $stats = [
                    [ hmao_mod('achievement_1_num','30+'),   hmao_mod('achievement_1_label','лет работы') ],
                    [ hmao_mod('achievement_2_num','5000+'), hmao_mod('achievement_2_label','членов') ],
                    [ hmao_mod('achievement_3_num','250+'),  hmao_mod('achievement_3_label','проектов') ],
                    [ hmao_mod('achievement_4_num','50+'),   hmao_mod('achievement_4_label','наград') ],
                ];
                foreach ( $stats as [ $num, $lbl ] ) : ?>
                    <div class="stat-box">
                        <div class="stat-box__num"><?php echo esc_html($num); ?></div>
                        <div class="stat-box__label"><?php echo esc_html($lbl); ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- ПОСЛЕДНИЕ НОВОСТИ -->
<section style="padding:48px 0 56px; background:#F8FAFC; margin-top:40px;">
    <div class="container">
        <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; margin-bottom:24px;">
            <div>
                <span class="section-line"></span>
                <h2 class="section-title" style="margin-bottom:0">Последние новости</h2>
            </div>
            <?php $news_page = get_page_by_path('news'); if ($news_page) : ?>
            <a href="<?php echo get_permalink($news_page->ID); ?>" class="btn-primary">
                Все новости <?php echo hmao_icon('arrow'); ?>
            </a>
            <?php endif; ?>
        </div>
        <div class="news-list">
            <?php
            $posts = get_posts(['numberposts' => 3, 'post_status' => 'publish']);
            foreach ( $posts as $post ) : setup_postdata($post); ?>
            <div class="news-card">
                <div class="news-card__meta">
                    <span class="news-card__cat">Новость</span>
                    <span class="news-card__date"><?php echo hmao_icon('calendar'); ?> <?php echo get_the_date('d F Y'); ?></span>
                </div>
                <h3 class="news-card__title">
                    <a href="<?php the_permalink(); ?>" style="color:inherit;text-decoration:none;">
                        <?php the_title(); ?>
                    </a>
                </h3>
                <p class="news-card__excerpt"><?php the_excerpt(); ?></p>
                <a href="<?php the_permalink(); ?>" class="read-more">Читать далее <?php echo hmao_icon('arrow'); ?></a>
            </div>
            <?php endforeach; wp_reset_postdata(); ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
