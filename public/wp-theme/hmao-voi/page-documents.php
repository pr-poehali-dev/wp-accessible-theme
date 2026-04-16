<?php
/**
 * Template Name: Документы
 */
get_header();
?>
<div class="page-hero">
    <div class="container">
        <div class="page-hero__badge">📄 Документы</div>
        <h1>Документы</h1>
        <p>Учредительные, отчётные, нормативные и методические материалы</p>
    </div>
</div>

<div class="documents-section">
<div class="container">
<?php
$docs = get_posts(['post_type'=>'voi_document','numberposts'=>-1,'orderby'=>'menu_order','order'=>'ASC']);
$grouped = [];
foreach ($docs as $doc) {
    $cat = get_post_meta($doc->ID,'_voi_doc_category',true) ?: 'Документы';
    $grouped[$cat][] = $doc;
}
if ($grouped) :
    foreach ($grouped as $cat => $items) :
?>
<h2 style="font-size:1.2rem;font-family:var(--font-head);color:var(--brand-dark);margin:2rem 0 1rem;padding-bottom:.5rem;border-bottom:2px solid var(--brand-light);"><?php echo esc_html($cat); ?></h2>
<div class="documents-grid">
<?php foreach ($items as $d) :
    $url  = get_post_meta($d->ID,'_voi_file_url', true);
    $size = get_post_meta($d->ID,'_voi_file_size',true);
    $type = get_post_meta($d->ID,'_voi_file_type',true) ?: 'PDF';
    $date = get_post_meta($d->ID,'_voi_doc_date', true);
    $t = strtolower($type);
    $icon_class = ($t==='pdf') ? 'doc-card__icon--pdf' : (in_array($t,['docx','doc']) ? 'doc-card__icon--docx' : (in_array($t,['xlsx','xls']) ? 'doc-card__icon--xlsx' : 'doc-card__icon--other'));
?>
<div class="doc-card">
    <div class="doc-card__icon <?php echo $icon_class; ?>"><?php echo esc_html($type); ?></div>
    <div class="doc-card__info">
        <div class="doc-card__title"><?php echo esc_html($d->post_title); ?></div>
        <div class="doc-card__meta">
            <?php if ($type) echo esc_html($type); ?>
            <?php if ($size) echo ' · ' . esc_html($size); ?>
            <?php if ($date) echo ' · ' . esc_html($date); ?>
        </div>
    </div>
    <?php if ($url) : $fn = basename(parse_url($url,PHP_URL_PATH)); ?>
    <a href="<?php echo esc_url($url); ?>" download="<?php echo esc_attr($fn); ?>" class="doc-card__download" rel="nofollow">⬇ Скачать</a>
    <?php else : ?>
    <span class="doc-card__download doc-card__download--disabled">Нет файла</span>
    <?php endif; ?>
</div>
<?php endforeach; ?>
</div>
<?php endforeach; else : ?>
<p style="color:var(--gray-600);padding:2rem 0;">Документы пока не добавлены. Перейдите в <strong>Документы → Добавить</strong> в панели администратора.</p>
<?php endif; ?>
</div>
</div>

<?php get_footer(); ?>
