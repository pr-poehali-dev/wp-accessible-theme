<?php
/**
 * Template Name: Документы
 * Страница со списком документов для скачивания
 */
get_header();
?>

<section class="page-hero">
    <div class="container">
        <div class="page-hero__tag">📄 Документы организации</div>
        <h1><?php the_title(); ?></h1>
        <p>Документы для скачивания — учредительные, отчётные, нормативные и методические материалы</p>
    </div>
</section>

<div class="page-content">
<div class="container">

    <?php
    // Получаем все документы, группируем по категориям
    $documents = get_posts([
        'post_type'      => 'voi_document',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    ]);

    // Группируем по категории
    $grouped = [];
    foreach ( $documents as $doc ) {
        $cat = get_post_meta( $doc->ID, '_voi_doc_category', true ) ?: 'Документы';
        $grouped[ $cat ][] = $doc;
    }
    ?>

    <?php if ( empty($grouped) ) : ?>
        <div class="voi-card" style="padding:40px; text-align:center; color:#64748B;">
            <div style="font-size:3rem; margin-bottom:16px;">📄</div>
            <p>Документы пока не добавлены. <br>Перейдите в <strong>Документы → Добавить документ</strong> в панели управления.</p>
        </div>
    <?php else : ?>

    <?php foreach ( $grouped as $category => $docs ) : ?>
    <div class="docs-section">
        <div class="docs-section__title"><?php echo esc_html( $category ); ?></div>
        <div class="docs-list">
            <?php foreach ( $docs as $doc ) :
                $file_url  = get_post_meta( $doc->ID, '_voi_file_url',  true );
                $file_size = get_post_meta( $doc->ID, '_voi_file_size', true );
                $file_type = get_post_meta( $doc->ID, '_voi_file_type', true ) ?: 'PDF';
                $doc_date  = get_post_meta( $doc->ID, '_voi_doc_date',  true );

                // Определяем CSS-класс для бейджа типа файла
                $ext_class = 'ext-badge--other';
                if ( $file_type === 'PDF' )        $ext_class = 'ext-badge--pdf';
                elseif ( in_array( $file_type, ['DOCX','DOC'] ) ) $ext_class = 'ext-badge--docx';
                elseif ( in_array( $file_type, ['XLSX','XLS'] ) ) $ext_class = 'ext-badge--xlsx';
            ?>
            <div class="doc-item">

                <div class="doc-item__icon">
                    <?php echo hmao_icon('file'); ?>
                </div>

                <div class="doc-item__body">
                    <div class="doc-item__name">
                        <?php if ( $file_url ) : ?>
                            <a href="<?php echo esc_url($file_url); ?>"
                               download="<?php echo esc_attr( basename( parse_url($file_url, PHP_URL_PATH) ) ); ?>"
                               style="color:inherit; text-decoration:none;"
                               rel="nofollow">
                                <?php echo esc_html( get_the_title($doc) ); ?>
                            </a>
                        <?php else : ?>
                            <?php echo esc_html( get_the_title($doc) ); ?>
                        <?php endif; ?>
                    </div>
                    <div class="doc-item__meta">
                        <?php if ( $file_size ) : ?>
                            <span><?php echo esc_html( $file_size ); ?></span>
                        <?php endif; ?>
                        <?php if ( $doc_date ) : ?>
                            <span><?php echo hmao_icon('calendar'); ?> <?php echo esc_html( $doc_date ); ?></span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="doc-item__actions">
                    <span class="ext-badge <?php echo esc_attr($ext_class); ?>">
                        <?php echo esc_html( $file_type ); ?>
                    </span>

                    <?php if ( $file_url ) :
                        $filename = basename( parse_url( $file_url, PHP_URL_PATH ) );
                    ?>
                    <!-- ===== РАБОЧАЯ КНОПКА СКАЧИВАНИЯ ===== -->
                    <a href="<?php echo esc_url( $file_url ); ?>"
                       download="<?php echo esc_attr( $filename ); ?>"
                       class="btn-download"
                       rel="nofollow"
                       title="Скачать: <?php echo esc_attr( get_the_title($doc) ); ?>">
                        <?php echo hmao_icon('download'); ?>
                        Скачать
                    </a>
                    <?php else : ?>
                    <span class="btn-download" style="opacity:.4; cursor:not-allowed;">
                        <?php echo hmao_icon('download'); ?> Нет файла
                    </span>
                    <?php endif; ?>
                </div>

            </div><!-- .doc-item -->
            <?php endforeach; ?>
        </div><!-- .docs-list -->
    </div><!-- .docs-section -->
    <?php endforeach; ?>

    <?php endif; ?>

    <!-- Редактируемый контент страницы -->
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
        if ( get_the_content() ) : ?>
            <div class="entry-content voi-card" style="padding:28px; margin-top:24px;">
                <?php the_content(); ?>
            </div>
        <?php endif;
    endwhile; endif; ?>

</div>
</div>

<?php get_footer(); ?>
