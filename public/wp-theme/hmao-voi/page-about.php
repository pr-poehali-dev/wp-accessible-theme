<?php
/**
 * Template Name: О нас
 */
get_header();
?>

<section class="page-hero">
    <div class="container">
        <div class="page-hero__tag">🤝 Общественная организация</div>
        <h1><?php the_title(); ?></h1>
        <p>Ханты-Мансийская региональная организация Всероссийского общества инвалидов</p>
    </div>
</section>

<div class="page-content">
<div class="container">

    <div class="about-layout">

        <!-- Основной контент (редактируется в WordPress) -->
        <div>
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <div class="voi-card" style="padding:32px;">
                <span class="section-line"></span>
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </div>
            <?php endwhile; endif; ?>
        </div>

        <!-- Боковая панель -->
        <aside>
            <!-- Статистика -->
            <div class="about-sidebar__card" style="margin-bottom:16px;">
                <div class="section-title" style="font-size:1rem; margin-bottom:16px;">Организация в цифрах</div>
                <?php
                $stats = [
                    [ hmao_mod('achievement_1_num','30+'),   hmao_mod('achievement_1_label','лет работы'),      '🏛' ],
                    [ hmao_mod('achievement_2_num','5000+'), hmao_mod('achievement_2_label','членов'),           '👥' ],
                    [ hmao_mod('achievement_3_num','250+'),  hmao_mod('achievement_3_label','проектов'),         '🚀' ],
                    [ hmao_mod('achievement_4_num','50+'),   hmao_mod('achievement_4_label','наград'),           '🏆' ],
                ];
                foreach ( $stats as [$num, $lbl, $icon] ) : ?>
                <div style="display:flex; align-items:center; gap:12px; padding:10px 0; border-bottom:1px solid #F1F5F9;">
                    <span style="font-size:1.4rem;"><?php echo esc_html($icon); ?></span>
                    <div>
                        <div style="font-weight:800; font-family:var(--font-head); color:var(--brand-dark); font-size:1.1rem;"><?php echo esc_html($num); ?></div>
                        <div style="font-size:.8rem; color:#64748B;"><?php echo esc_html($lbl); ?></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Контакты -->
            <div class="about-sidebar__card">
                <div class="section-title" style="font-size:1rem; margin-bottom:12px;">Контакты</div>
                <ul class="contacts-list">
                    <?php if ($v = hmao_mod('contact_address')) : ?>
                        <li><?php echo hmao_icon('map-pin'); ?> <?php echo esc_html($v); ?></li>
                    <?php endif; ?>
                    <?php if ($v = hmao_mod('contact_phone')) : ?>
                        <li><?php echo hmao_icon('phone'); ?> <a href="tel:<?php echo esc_attr(preg_replace('/[^+\d]/','', $v)); ?>"><?php echo esc_html($v); ?></a></li>
                    <?php endif; ?>
                    <?php if ($v = hmao_mod('contact_email')) : ?>
                        <li><?php echo hmao_icon('mail'); ?> <a href="mailto:<?php echo esc_attr($v); ?>"><?php echo esc_html($v); ?></a></li>
                    <?php endif; ?>
                    <?php if ($v = hmao_mod('contact_hours')) : ?>
                        <li>🕐 <?php echo esc_html($v); ?></li>
                    <?php endif; ?>
                </ul>
            </div>
        </aside>

    </div>
</div>
</div>

<?php get_footer(); ?>
