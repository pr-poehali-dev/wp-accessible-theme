<?php
/**
 * ХМАО ВОИ — functions.php v2.0
 * Gutenberg-блоки, CPT, AJAX-форма, демо-данные при активации
 */
if ( ! defined('ABSPATH') ) exit;

/* =========================================================
   1. ПОДДЕРЖКА ТЕМЫ
   ========================================================= */
function hmao_setup() {
    load_theme_textdomain( 'hmao-voi', get_template_directory() . '/languages' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'align-wide' );
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'editor-styles' );
    add_theme_support( 'html5', ['search-form','comment-form','comment-list','gallery','caption','script','style'] );
    add_theme_support( 'custom-logo', ['height'=>80,'width'=>80,'flex-width'=>true,'flex-height'=>true] );
    add_image_size( 'team-thumb', 300, 300, true );
    add_image_size( 'news-thumb', 800, 450, true );
    register_nav_menus([
        'primary' => 'Основное меню',
        'footer'  => 'Меню подвала',
    ]);
}
add_action( 'after_setup_theme', 'hmao_setup' );

/* =========================================================
   2. СТИЛИ И СКРИПТЫ
   ========================================================= */
function hmao_enqueue() {
    wp_enqueue_style( 'google-fonts',
        'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&family=Inter:wght@400;500;600&display=swap',
        [], null );
    wp_enqueue_style( 'hmao-style', get_stylesheet_uri(), ['google-fonts'], '2.0.0' );
    wp_enqueue_script( 'hmao-main', get_template_directory_uri() . '/assets/js/main.js', [], '2.0.0', true );
    wp_localize_script( 'hmao-main', 'hmaoAjax', [
        'url'   => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('hmao_contact_form'),
    ]);
}
add_action( 'wp_enqueue_scripts', 'hmao_enqueue' );

/* editor styles */
function hmao_editor_styles() {
    wp_enqueue_style( 'google-fonts-editor',
        'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&family=Inter:wght@400;500;600&display=swap',
        [], null );
}
add_action( 'enqueue_block_editor_assets', 'hmao_editor_styles' );

/* =========================================================
   3. КАСТОМНЫЕ ТИПЫ ЗАПИСЕЙ (CPT)
   ========================================================= */
function hmao_register_cpts() {

    $cpts = [
        'voi_team' => [
            'labels'   => ['name'=>'Команда','singular_name'=>'Сотрудник','add_new_item'=>'Добавить сотрудника','edit_item'=>'Редактировать сотрудника','all_items'=>'Все сотрудники'],
            'icon'     => 'dashicons-groups',
            'supports' => ['title','thumbnail','page-attributes'],
            'archive'  => false,
        ],
        'voi_document' => [
            'labels'   => ['name'=>'Документы','singular_name'=>'Документ','add_new_item'=>'Добавить документ','edit_item'=>'Редактировать документ','all_items'=>'Все документы'],
            'icon'     => 'dashicons-media-document',
            'supports' => ['title','page-attributes'],
            'archive'  => false,
        ],
        'voi_project' => [
            'labels'   => ['name'=>'Проекты','singular_name'=>'Проект','add_new_item'=>'Добавить проект','edit_item'=>'Редактировать проект','all_items'=>'Все проекты'],
            'icon'     => 'dashicons-portfolio',
            'supports' => ['title','editor','thumbnail','page-attributes'],
            'archive'  => true,
        ],
        'voi_event' => [
            'labels'   => ['name'=>'Мероприятия','singular_name'=>'Мероприятие','add_new_item'=>'Добавить мероприятие','edit_item'=>'Редактировать мероприятие','all_items'=>'Все мероприятия'],
            'icon'     => 'dashicons-calendar-alt',
            'supports' => ['title','editor','thumbnail','page-attributes'],
            'archive'  => true,
        ],
        'voi_famous' => [
            'labels'   => ['name'=>'Великие люди','singular_name'=>'Персона','add_new_item'=>'Добавить персону','edit_item'=>'Редактировать персону','all_items'=>'Все персоны'],
            'icon'     => 'dashicons-star-filled',
            'supports' => ['title','editor','thumbnail','page-attributes'],
            'archive'  => false,
        ],
        'voi_album' => [
            'labels'   => ['name'=>'Фотоальбомы','singular_name'=>'Альбом','add_new_item'=>'Добавить альбом','edit_item'=>'Редактировать альбом','all_items'=>'Все альбомы'],
            'icon'     => 'dashicons-format-gallery',
            'supports' => ['title','editor','thumbnail','page-attributes'],
            'archive'  => false,
        ],
    ];

    foreach ( $cpts as $slug => $cfg ) {
        $labels = array_merge([
            'menu_name'   => $cfg['labels']['name'],
            'name_admin_bar' => $cfg['labels']['singular_name'],
        ], $cfg['labels']);

        register_post_type( $slug, [
            'labels'             => $labels,
            'public'             => true,
            'show_in_rest'       => true,
            'menu_icon'          => $cfg['icon'],
            'supports'           => $cfg['supports'],
            'has_archive'        => $cfg['archive'],
            'rewrite'            => ['slug' => str_replace('voi_', '', $slug)],
            'show_in_menu'       => true,
        ]);
    }
}
add_action( 'init', 'hmao_register_cpts' );

/* =========================================================
   4. МЕТА-БОКСЫ ДЛЯ CPT
   ========================================================= */
function hmao_add_meta_boxes() {
    /* КОМАНДА */
    add_meta_box( 'voi_team_meta', 'Данные сотрудника', 'hmao_team_meta_cb', 'voi_team', 'normal', 'high' );
    /* ДОКУМЕНТЫ */
    add_meta_box( 'voi_doc_meta',  'Файл документа',    'hmao_doc_meta_cb',  'voi_document', 'normal', 'high' );
    /* ПРОЕКТЫ */
    add_meta_box( 'voi_proj_meta', 'Данные проекта',    'hmao_proj_meta_cb', 'voi_project', 'side', 'default' );
    /* МЕРОПРИЯТИЯ */
    add_meta_box( 'voi_event_meta','Данные мероприятия','hmao_event_meta_cb','voi_event',   'side', 'default' );
    /* ВЕЛИКИЕ ЛЮДИ */
    add_meta_box( 'voi_famous_meta','Данные персоны',   'hmao_famous_meta_cb','voi_famous', 'side', 'default' );
}
add_action( 'add_meta_boxes', 'hmao_add_meta_boxes' );

function hmao_field( $label, $key, $value, $type = 'text', $ph = '' ) {
    $k = esc_attr($key); $v = esc_attr($value); $p = esc_attr($ph);
    echo "<p><label for='{$k}'><strong>{$label}</strong></label><br/>";
    if ( $type === 'textarea' )
        echo "<textarea name='{$k}' id='{$k}' rows='3' style='width:100%'>" . esc_textarea($value) . "</textarea>";
    elseif ( $type === 'select_status' ) {
        echo "<select name='{$k}' id='{$k}' style='width:100%'>";
        foreach (['active'=>'Активный','new'=>'Новый','done'=>'Завершён'] as $opt => $lbl)
            echo "<option value='{$opt}'" . selected($value,$opt,false) . ">{$lbl}</option>";
        echo "</select>";
    } else
        echo "<input type='{$type}' name='{$k}' id='{$k}' value='{$v}' placeholder='{$p}' style='width:100%'/>";
    echo "</p>";
}

function hmao_team_meta_cb( $post ) {
    wp_nonce_field('hmao_team_save','hmao_team_nonce');
    hmao_field('Должность','_voi_position', get_post_meta($post->ID,'_voi_position',true),'text','Председатель');
    hmao_field('Email',    '_voi_email',    get_post_meta($post->ID,'_voi_email',   true),'email');
    hmao_field('Телефон',  '_voi_phone',    get_post_meta($post->ID,'_voi_phone',   true),'text','+7 000 000-00-00');
    echo '<p><small>Фото — миниатюра записи. Порядок — атрибут «Порядок» справа.</small></p>';
}

function hmao_doc_meta_cb( $post ) {
    wp_nonce_field('hmao_doc_save','hmao_doc_nonce');
    $url  = get_post_meta($post->ID,'_voi_file_url', true);
    $size = get_post_meta($post->ID,'_voi_file_size',true);
    $type = get_post_meta($post->ID,'_voi_file_type',true);
    $cat  = get_post_meta($post->ID,'_voi_doc_category',true);
    $date = get_post_meta($post->ID,'_voi_doc_date',true);
    ?>
    <p><label><strong>URL файла</strong></label><br/>
    <input type="url" name="_voi_file_url" id="_voi_file_url" value="<?php echo esc_attr($url); ?>" placeholder="https://..." style="width:78%"/>
    <button type="button" class="button" id="voi_upload_btn" style="margin-left:6px">Выбрать файл</button></p>
    <?php
    hmao_field('Размер (напр. 2.4 МБ)','_voi_file_size',$size,'text','1.2 МБ');
    echo '<p><label><strong>Тип файла</strong></label><br/><select name="_voi_file_type" style="width:100%">';
    foreach (['PDF','DOCX','XLSX','DOC','XLS','ZIP','Другое'] as $t)
        echo "<option value='{$t}'" . selected($type,$t,false) . ">{$t}</option>";
    echo '</select></p>';
    hmao_field('Категория','_voi_doc_category',$cat,'text','Учредительные документы');
    hmao_field('Дата документа','_voi_doc_date',$date,'text','дд.мм.гггг');
    ?>
    <script>
    jQuery(function($){
        $('#voi_upload_btn').on('click',function(){
            var f=wp.media({title:'Выберите файл',button:{text:'Использовать'},multiple:false});
            f.on('select',function(){
                var a=f.state().get('selection').first().toJSON();
                $('#_voi_file_url').val(a.url);
                if(a.filesizeHumanReadable) $('#_voi_file_size').val(a.filesizeHumanReadable);
                var e=a.url.split('.').pop().toUpperCase();
                if(['PDF','DOCX','XLSX','DOC','XLS','ZIP'].indexOf(e)!==-1) $('[name=_voi_file_type]').val(e);
            });
            f.open();
        });
    });
    </script>
    <?php
}

function hmao_proj_meta_cb( $post ) {
    wp_nonce_field('hmao_proj_save','hmao_proj_nonce');
    hmao_field('Статус','_voi_project_status',get_post_meta($post->ID,'_voi_project_status',true),'select_status');
    hmao_field('Период','_voi_project_period',get_post_meta($post->ID,'_voi_project_period',true),'text','2024–2025');
    hmao_field('Теги (через запятую)','_voi_project_tags',get_post_meta($post->ID,'_voi_project_tags',true),'text','Инфраструктура, Доступность');
}

function hmao_event_meta_cb( $post ) {
    wp_nonce_field('hmao_event_save','hmao_event_nonce');
    hmao_field('Дата',   '_voi_event_date', get_post_meta($post->ID,'_voi_event_date', true),'text','25 апреля 2026');
    hmao_field('Время',  '_voi_event_time', get_post_meta($post->ID,'_voi_event_time', true),'text','10:00');
    hmao_field('Место',  '_voi_event_place',get_post_meta($post->ID,'_voi_event_place',true),'text','г. Ханты-Мансийск');
    hmao_field('Тип',    '_voi_event_type', get_post_meta($post->ID,'_voi_event_type', true),'text','Конференция');
    hmao_field('День (число)','_voi_event_day',  get_post_meta($post->ID,'_voi_event_day',  true),'text','25');
    hmao_field('Месяц (сокр.)','_voi_event_month',get_post_meta($post->ID,'_voi_event_month',true),'text','апр');
}

function hmao_famous_meta_cb( $post ) {
    wp_nonce_field('hmao_famous_save','hmao_famous_nonce');
    hmao_field('Годы жизни','_voi_famous_years',get_post_meta($post->ID,'_voi_famous_years',true),'text','1770–1827');
    hmao_field('Сфера деятельности','_voi_famous_field',get_post_meta($post->ID,'_voi_famous_field',true),'text','Композитор');
    hmao_field('Эмодзи-иконка','_voi_famous_emoji',get_post_meta($post->ID,'_voi_famous_emoji',true),'text','🎵');
}

/* --- Сохранение мета --- */
function hmao_save_meta( $post_id ) {
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
    if ( ! current_user_can('edit_post', $post_id) ) return;

    $map = [
        'voi_team'     => ['nonce'=>'hmao_team_nonce',  'action'=>'hmao_team_save',  'fields'=>['_voi_position','_voi_email','_voi_phone']],
        'voi_document' => ['nonce'=>'hmao_doc_nonce',   'action'=>'hmao_doc_save',   'fields'=>['_voi_file_url','_voi_file_size','_voi_file_type','_voi_doc_category','_voi_doc_date']],
        'voi_project'  => ['nonce'=>'hmao_proj_nonce',  'action'=>'hmao_proj_save',  'fields'=>['_voi_project_status','_voi_project_period','_voi_project_tags']],
        'voi_event'    => ['nonce'=>'hmao_event_nonce', 'action'=>'hmao_event_save', 'fields'=>['_voi_event_date','_voi_event_time','_voi_event_place','_voi_event_type','_voi_event_day','_voi_event_month']],
        'voi_famous'   => ['nonce'=>'hmao_famous_nonce','action'=>'hmao_famous_save','fields'=>['_voi_famous_years','_voi_famous_field','_voi_famous_emoji']],
    ];

    $type = get_post_type($post_id);
    if ( ! isset($map[$type]) ) return;
    $cfg = $map[$type];
    if ( ! isset($_POST[$cfg['nonce']]) || ! wp_verify_nonce($_POST[$cfg['nonce']], $cfg['action']) ) return;

    foreach ( $cfg['fields'] as $f ) {
        if ( isset($_POST[$f]) )
            update_post_meta( $post_id, $f, sanitize_text_field($_POST[$f]) );
    }
}
add_action( 'save_post', 'hmao_save_meta' );

/* =========================================================
   5. РЕГИСТРАЦИЯ КАСТОМНЫХ GUTENBERG-БЛОКОВ
   ========================================================= */
function hmao_register_blocks() {
    $blocks = [
        'hmao-hero'           => 'hmao_render_hero',
        'hmao-text-section'   => 'hmao_render_text_section',
        'hmao-stats'          => 'hmao_render_stats',
        'hmao-achievements'   => 'hmao_render_achievements',
        'hmao-contacts-block' => 'hmao_render_contacts_block',
        'hmao-map-block'      => 'hmao_render_map_block',
        'hmao-form-block'     => 'hmao_render_form_block',
    ];

    foreach ( $blocks as $name => $cb ) {
        register_block_type( 'hmao/' . str_replace('hmao-','',$name), [
            'render_callback' => $cb,
            'attributes'      => hmao_block_attrs( $name ),
        ]);
    }
}
add_action( 'init', 'hmao_register_blocks' );

function hmao_block_attrs( $name ) {
    $base = ['align'=>['type'=>'string','default'=>'']];
    switch ( $name ) {
        case 'hmao-hero':
            return array_merge($base,[
                'badge'      => ['type'=>'string','default'=>'Общественная организация'],
                'heading'    => ['type'=>'string','default'=>'Ханты-Мансийская региональная организация ВОИ'],
                'desc'       => ['type'=>'string','default'=>'Объединяем людей с ограниченными возможностями здоровья для полноценной жизни в обществе'],
                'btnText'    => ['type'=>'string','default'=>'Узнать больше о нас'],
                'btnUrl'     => ['type'=>'string','default'=>'/about'],
            ]);
        case 'hmao-text-section':
            return array_merge($base,[
                'label'      => ['type'=>'string','default'=>'О нас'],
                'heading'    => ['type'=>'string','default'=>'Кто мы'],
                'body'       => ['type'=>'string','default'=>'Ханты-Мансийская региональная организация Всероссийского общества инвалидов (ХМАО ВОИ) — одна из крупнейших общественных организаций округа.'],
                'altBg'      => ['type'=>'boolean','default'=>false],
            ]);
        case 'hmao-stats':
            return array_merge($base,[
                'title'      => ['type'=>'string','default'=>'Организация в цифрах'],
                'cards'      => ['type'=>'array','default'=>[
                    ['icon'=>'🏛','num'=>'30+',   'label'=>'лет работы'],
                    ['icon'=>'👥','num'=>'5000+', 'label'=>'членов организации'],
                    ['icon'=>'🚀','num'=>'250+',  'label'=>'реализованных проектов'],
                    ['icon'=>'🏆','num'=>'50+',   'label'=>'наград и грамот'],
                ],'items'=>['type'=>'object']],
            ]);
        case 'hmao-achievements':
            return array_merge($base,[
                'title'      => ['type'=>'string','default'=>'Наши достижения'],
                'subtitle'   => ['type'=>'string','default'=>'Результаты многолетней работы'],
                'cards'      => ['type'=>'array','default'=>[
                    ['icon'=>'♿','title'=>'Доступная среда','text'=>'Помогаем создавать безбарьерную среду в городах округа'],
                    ['icon'=>'⚖️','title'=>'Правозащитная деятельность','text'=>'Защищаем права инвалидов в судах и органах власти'],
                    ['icon'=>'🎭','title'=>'Культура и спорт','text'=>'Организуем адаптивные спортивные и культурные мероприятия'],
                    ['icon'=>'🤝','title'=>'Социальная поддержка','text'=>'Оказываем помощь людям с ограниченными возможностями'],
                ],'items'=>['type'=>'object']],
            ]);
        case 'hmao-contacts-block':
            return array_merge($base,[
                'address' => ['type'=>'string','default'=>'г. Ханты-Мансийск, ул. Примерная, д. 1'],
                'phone'   => ['type'=>'string','default'=>'8 (3467) 00-00-00'],
                'email'   => ['type'=>'string','default'=>'info@hmao-voi.ru'],
                'hours'   => ['type'=>'string','default'=>'Пн–Пт: 9:00–18:00'],
                'vk'      => ['type'=>'string','default'=>''],
                'tg'      => ['type'=>'string','default'=>''],
                'ok'      => ['type'=>'string','default'=>''],
            ]);
        case 'hmao-map-block':
            return array_merge($base,[
                'lat'  => ['type'=>'string','default'=>'61.003333'],
                'lon'  => ['type'=>'string','default'=>'69.019444'],
                'zoom' => ['type'=>'string','default'=>'14'],
            ]);
        case 'hmao-form-block':
            return array_merge($base,[
                'title'    => ['type'=>'string','default'=>'Напишите нам'],
                'subtitle' => ['type'=>'string','default'=>'Ответим в течение рабочего дня'],
            ]);
        default:
            return $base;
    }
}

/* =========================================================
   6. RENDER-ФУНКЦИИ GUTENBERG-БЛОКОВ
   ========================================================= */

function hmao_render_hero( $attrs ) {
    $badge   = esc_html( $attrs['badge']   ?? 'Общественная организация' );
    $heading = esc_html( $attrs['heading'] ?? 'ХМАО ВОИ' );
    $desc    = esc_html( $attrs['desc']    ?? '' );
    $btn_t   = esc_html( $attrs['btnText'] ?? 'Узнать больше' );
    $btn_u   = esc_url(  $attrs['btnUrl']  ?? '#' );
    ob_start(); ?>
    <section class="block-hero">
        <div class="container">
            <?php if ($badge) : ?><span class="hero-badge">🤝 <?php echo $badge; ?></span><?php endif; ?>
            <h1><?php echo $heading; ?></h1>
            <?php if ($desc) : ?><p class="hero-desc"><?php echo $desc; ?></p><?php endif; ?>
            <?php if ($btn_t) : ?><a href="<?php echo $btn_u; ?>" class="hero-btn"><?php echo $btn_t; ?></a><?php endif; ?>
        </div>
    </section>
    <?php return ob_get_clean();
}

function hmao_render_text_section( $attrs ) {
    $label   = esc_html( $attrs['label']   ?? '' );
    $heading = esc_html( $attrs['heading'] ?? '' );
    $body    = wp_kses_post( $attrs['body'] ?? '' );
    $alt     = ! empty( $attrs['altBg'] );
    ob_start(); ?>
    <section class="block-text-section<?php echo $alt ? ' block-text-section--alt' : ''; ?>">
        <div class="container">
            <?php if ($label) : ?><span class="section-label"><?php echo $label; ?></span><?php endif; ?>
            <?php if ($heading) : ?><h2><?php echo $heading; ?></h2><?php endif; ?>
            <?php if ($body) : ?><div class="section-body"><?php echo $body; ?></div><?php endif; ?>
        </div>
    </section>
    <?php return ob_get_clean();
}

function hmao_render_stats( $attrs ) {
    $title = esc_html( $attrs['title'] ?? 'Организация в цифрах' );
    $cards = $attrs['cards'] ?? [];
    ob_start(); ?>
    <section class="block-stats">
        <div class="container">
            <?php if ($title) : ?><h2 class="section-title"><?php echo $title; ?></h2><?php endif; ?>
            <div class="stats-grid">
                <?php foreach ($cards as $c) : ?>
                <div class="stat-card">
                    <div class="stat-card__icon"><?php echo esc_html($c['icon'] ?? '📊'); ?></div>
                    <div class="stat-card__num"><?php echo esc_html($c['num'] ?? ''); ?></div>
                    <div class="stat-card__label"><?php echo esc_html($c['label'] ?? ''); ?></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php return ob_get_clean();
}

function hmao_render_achievements( $attrs ) {
    $title    = esc_html( $attrs['title']    ?? 'Наши достижения' );
    $subtitle = esc_html( $attrs['subtitle'] ?? '' );
    $cards    = $attrs['cards'] ?? [];
    ob_start(); ?>
    <section class="block-achievements">
        <div class="container">
            <div class="section-header">
                <h2><?php echo $title; ?></h2>
                <?php if ($subtitle) : ?><p><?php echo $subtitle; ?></p><?php endif; ?>
            </div>
            <div class="achievements-grid">
                <?php foreach ($cards as $c) : ?>
                <div class="achievement-card">
                    <div class="achievement-card__icon"><?php echo esc_html($c['icon'] ?? '🏆'); ?></div>
                    <div class="achievement-card__title"><?php echo esc_html($c['title'] ?? ''); ?></div>
                    <div class="achievement-card__text"><?php echo esc_html($c['text'] ?? ''); ?></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php return ob_get_clean();
}

function hmao_render_contacts_block( $attrs ) {
    $addr  = esc_html( $attrs['address'] ?? '' );
    $phone = esc_html( $attrs['phone']   ?? '' );
    $email = esc_attr( $attrs['email']   ?? '' );
    $hours = esc_html( $attrs['hours']   ?? '' );
    $vk    = esc_url(  $attrs['vk']      ?? '' );
    $tg    = esc_url(  $attrs['tg']      ?? '' );
    $ok    = esc_url(  $attrs['ok']      ?? '' );
    $phone_href = preg_replace('/[^+\d]/','',$phone);
    ob_start(); ?>
    <section class="block-contacts">
        <div class="container">
            <div class="section-header"><h2>Контактная информация</h2></div>
            <div class="contacts-layout">
                <div class="contact-info-card">
                    <h3>Как с нами связаться</h3>
                    <?php if ($addr) : ?>
                    <div class="contact-item">
                        <div class="contact-item__icon">📍</div>
                        <div><div class="contact-item__label">Адрес</div><div class="contact-item__value"><?php echo $addr; ?></div></div>
                    </div>
                    <?php endif; if ($phone) : ?>
                    <div class="contact-item">
                        <div class="contact-item__icon">📞</div>
                        <div><div class="contact-item__label">Телефон</div><div class="contact-item__value"><a href="tel:<?php echo $phone_href; ?>"><?php echo $phone; ?></a></div></div>
                    </div>
                    <?php endif; if ($email) : ?>
                    <div class="contact-item">
                        <div class="contact-item__icon">✉️</div>
                        <div><div class="contact-item__label">Email</div><div class="contact-item__value"><a href="mailto:<?php echo $email; ?>"><?php echo esc_html($attrs['email']); ?></a></div></div>
                    </div>
                    <?php endif; if ($hours) : ?>
                    <div class="contact-item">
                        <div class="contact-item__icon">🕐</div>
                        <div><div class="contact-item__label">Режим работы</div><div class="contact-item__value"><?php echo $hours; ?></div></div>
                    </div>
                    <?php endif; ?>
                    <?php if ($vk || $tg || $ok) : ?>
                    <div class="contact-social">
                        <h4>Мы в социальных сетях</h4>
                        <div class="social-links">
                            <?php if ($vk) echo "<a href='{$vk}' class='social-link' target='_blank' rel='noopener'>ВКонтакте</a>"; ?>
                            <?php if ($tg) echo "<a href='{$tg}' class='social-link' target='_blank' rel='noopener'>Telegram</a>"; ?>
                            <?php if ($ok) echo "<a href='{$ok}' class='social-link' target='_blank' rel='noopener'>Одноклассники</a>"; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                <div id="contacts-map-placeholder" style="background:var(--gray-100);border-radius:var(--radius-lg);min-height:300px;display:flex;align-items:center;justify-content:center;color:var(--gray-600);">
                    <span>Добавьте блок «Карта» ниже для отображения карты</span>
                </div>
            </div>
        </div>
    </section>
    <?php return ob_get_clean();
}

function hmao_render_map_block( $attrs ) {
    $lat  = floatval( $attrs['lat']  ?? 61.003333 );
    $lon  = floatval( $attrs['lon']  ?? 69.019444 );
    $zoom = intval(   $attrs['zoom'] ?? 14 );
    $src  = "https://maps.google.com/maps?q={$lat},{$lon}&z={$zoom}&output=embed";
    ob_start(); ?>
    <section class="block-map">
        <div class="container">
            <iframe src="<?php echo esc_url($src); ?>" allowfullscreen loading="lazy" title="Карта"></iframe>
        </div>
    </section>
    <?php return ob_get_clean();
}

function hmao_render_form_block( $attrs ) {
    $title    = esc_html( $attrs['title']    ?? 'Напишите нам' );
    $subtitle = esc_html( $attrs['subtitle'] ?? '' );
    ob_start(); ?>
    <section class="block-contact-form">
        <div class="container">
            <div class="section-header">
                <h2><?php echo $title; ?></h2>
                <?php if ($subtitle) : ?><p><?php echo $subtitle; ?></p><?php endif; ?>
            </div>
            <form class="cf-form" id="hmao-contact-form" novalidate>
                <?php wp_nonce_field('hmao_contact_form','cf_nonce'); ?>
                <div class="cf-row">
                    <div class="cf-field">
                        <label for="cf_name">Ваше имя <span style="color:#b91c1c">*</span></label>
                        <input type="text" id="cf_name" name="cf_name" required placeholder="Иван Иванов">
                    </div>
                    <div class="cf-field">
                        <label for="cf_email">Email <span style="color:#b91c1c">*</span></label>
                        <input type="email" id="cf_email" name="cf_email" required placeholder="mail@example.ru">
                    </div>
                </div>
                <div class="cf-field">
                    <label for="cf_phone">Телефон</label>
                    <input type="tel" id="cf_phone" name="cf_phone" placeholder="+7 000 000-00-00">
                </div>
                <div class="cf-field">
                    <label for="cf_message">Сообщение <span style="color:#b91c1c">*</span></label>
                    <textarea id="cf_message" name="cf_message" required placeholder="Ваш вопрос или сообщение..."></textarea>
                </div>
                <button type="submit" class="cf-submit">Отправить сообщение</button>
                <div class="cf-message cf-message--success" id="cf-success">✓ Спасибо! Ваше сообщение отправлено. Мы ответим в течение рабочего дня.</div>
                <div class="cf-message cf-message--error"   id="cf-error">Пожалуйста, заполните все обязательные поля.</div>
            </form>
        </div>
    </section>
    <?php return ob_get_clean();
}

/* =========================================================
   7. AJAX-ФОРМА ОБРАТНОЙ СВЯЗИ
   ========================================================= */

/* Сохранение обращений в БД */
function hmao_create_messages_table() {
    global $wpdb;
    $table = $wpdb->prefix . 'contact_messages';
    if ( $wpdb->get_var("SHOW TABLES LIKE '{$table}'") !== $table ) {
        $charset = $wpdb->get_charset_collate();
        $wpdb->query("CREATE TABLE {$table} (
            id        BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            name      VARCHAR(200)  NOT NULL DEFAULT '',
            email     VARCHAR(200)  NOT NULL DEFAULT '',
            phone     VARCHAR(50)   NOT NULL DEFAULT '',
            message   TEXT          NOT NULL,
            created   DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) {$charset}");
    }
}
add_action( 'after_switch_theme', 'hmao_create_messages_table' );
add_action( 'init', 'hmao_create_messages_table' );

function hmao_handle_contact_form() {
    check_ajax_referer('hmao_contact_form','nonce');

    $name    = sanitize_text_field($_POST['name']    ?? '');
    $email   = sanitize_email(     $_POST['email']   ?? '');
    $phone   = sanitize_text_field($_POST['phone']   ?? '');
    $message = sanitize_textarea_field($_POST['message'] ?? '');

    if ( ! $name || ! is_email($email) || ! $message ) {
        wp_send_json_error(['msg'=>'Заполните обязательные поля']);
    }

    global $wpdb;
    $wpdb->insert( $wpdb->prefix . 'contact_messages', compact('name','email','phone','message') );

    $to      = get_option('admin_email');
    $subject = 'Новое обращение с сайта: ' . $name;
    $body    = "Имя: {$name}\nEmail: {$email}\nТелефон: {$phone}\n\nСообщение:\n{$message}";
    wp_mail($to, $subject, $body);

    wp_send_json_success(['msg'=>'Сообщение отправлено']);
}
add_action('wp_ajax_hmao_contact',       'hmao_handle_contact_form');
add_action('wp_ajax_nopriv_hmao_contact','hmao_handle_contact_form');

/* Страница сообщений в админке */
function hmao_admin_messages_menu() {
    add_menu_page('Обращения','Обращения','manage_options','hmao-messages','hmao_messages_page','dashicons-email-alt',25);
}
add_action('admin_menu','hmao_admin_messages_menu');

function hmao_messages_page() {
    global $wpdb;
    $rows = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}contact_messages ORDER BY created DESC");
    echo '<div class="wrap"><h1>Обращения с сайта</h1>';
    if (!$rows) { echo '<p>Обращений пока нет.</p></div>'; return; }
    echo '<table class="widefat striped"><thead><tr><th>Имя</th><th>Email</th><th>Телефон</th><th>Сообщение</th><th>Дата</th></tr></thead><tbody>';
    foreach ($rows as $r) {
        echo '<tr>';
        echo '<td>' . esc_html($r->name)    . '</td>';
        echo '<td><a href="mailto:' . esc_attr($r->email) . '">' . esc_html($r->email) . '</a></td>';
        echo '<td>' . esc_html($r->phone)   . '</td>';
        echo '<td>' . nl2br(esc_html($r->message)) . '</td>';
        echo '<td>' . esc_html($r->created) . '</td>';
        echo '</tr>';
    }
    echo '</tbody></table></div>';
}

/* =========================================================
   8. ВСПОМОГАТЕЛЬНЫЕ ФУНКЦИИ
   ========================================================= */
function hmao_admin_scripts( $hook ) {
    if ( in_array($hook,['post.php','post-new.php'],true) ) wp_enqueue_media();
}
add_action('admin_enqueue_scripts','hmao_admin_scripts');

/* =========================================================
   9. ГЕНЕРАТОР GUTENBERG JSON-БЛОКОВ
   ========================================================= */

/**
 * Строит сериализованный Gutenberg-контент для страницы
 * Формат: <!-- wp:block/name {attrs} --> ... <!-- /wp:block/name -->
 */
function hmao_gb( $name, $attrs = [], $inner = '' ) {
    $attrs_json = empty($attrs) ? '' : ' ' . wp_json_encode($attrs, JSON_UNESCAPED_UNICODE);
    if ( $inner === '' ) {
        return "<!-- wp:{$name}{$attrs_json} /-->\n";
    }
    return "<!-- wp:{$name}{$attrs_json} -->\n{$inner}\n<!-- /wp:{$name} -->\n";
}

function hmao_gb_heading( $text, $level = 2 ) {
    $tag = "h{$level}";
    return hmao_gb("heading", ['level'=>$level,'content'=>$text], "<{$tag} class=\"wp-block-heading\">{$text}</{$tag}>");
}

function hmao_gb_paragraph( $text ) {
    return hmao_gb("paragraph", ['content'=>$text], "<p>{$text}</p>");
}

function hmao_gb_list( $items ) {
    $li = implode('', array_map(fn($i) => "<li>{$i}</li>", $items));
    return hmao_gb("list", ['ordered'=>false], "<ul class=\"wp-block-list\">{$li}</ul>");
}

/* =========================================================
   10. АКТИВАЦИЯ ТЕМЫ — ДЕМО-ДАННЫЕ
   ========================================================= */
function hmao_activate() {
    hmao_create_messages_table();

    /* ---- СТРАНИЦЫ ---- */
    $pages_cfg = [
        'front-home'  => [
            'title'    => 'Главная',
            'template' => '',
            'content'  => hmao_home_content(),
        ],
        'about' => [
            'title'    => 'О НАС',
            'template' => 'page-about.php',
            'content'  => hmao_about_content(),
        ],
        'structure' => [
            'title'    => 'СТРУКТУРА ХМАО ВОИ',
            'template' => 'page-structure.php',
            'content'  => hmao_structure_content(),
        ],
        'convention' => [
            'title'    => 'КОНВЕНЦИЯ ООН О ПРАВАХ ИНВАЛИДОВ',
            'template' => 'page-convention.php',
            'content'  => hmao_convention_content(),
        ],
        'famous'     => ['title'=>'ВЕЛИКИЕ ИНВАЛИДЫ ПЛАНЕТЫ',   'template'=>'page-famous.php',     'content'=>''],
        'projects'   => ['title'=>'ПРОЕКТЫ',                     'template'=>'page-projects.php',   'content'=>''],
        'news'       => ['title'=>'НОВОСТИ',                     'template'=>'page-news.php',       'content'=>''],
        'events'     => ['title'=>'МЕРОПРИЯТИЯ',                 'template'=>'page-events.php',     'content'=>''],
        'photos'     => ['title'=>'ФОТОГРАФИИ',                  'template'=>'page-photos.php',     'content'=>''],
        'documents'  => ['title'=>'ДОКУМЕНТЫ',                   'template'=>'page-documents.php',  'content'=>''],
        'team'       => ['title'=>'КОМАНДА',                     'template'=>'page-team.php',       'content'=>''],
        'contacts'   => ['title'=>'КОНТАКТЫ',                    'template'=>'page-contacts.php',   'content'=>hmao_contacts_content()],
    ];

    $page_ids = [];
    foreach ( $pages_cfg as $slug => $cfg ) {
        $existing = get_page_by_path($slug);
        if ( ! $existing ) {
            $id = wp_insert_post([
                'post_title'    => $cfg['title'],
                'post_name'     => $slug,
                'post_status'   => 'publish',
                'post_type'     => 'page',
                'post_content'  => $cfg['content'],
            ]);
            if ( $cfg['template'] ) update_post_meta($id,'_wp_page_template',$cfg['template']);
            $page_ids[$slug] = $id;
        } else {
            $page_ids[$slug] = $existing->ID;
        }
    }

    /* Главная страница */
    if ( isset($page_ids['front-home']) ) {
        update_option('show_on_front','page');
        update_option('page_on_front', $page_ids['front-home']);
    }

    /* ---- МЕНЮ ---- */
    $menu_name = 'Главное меню';
    $existing_menu = wp_get_nav_menu_object($menu_name);
    $menu_id = $existing_menu ? $existing_menu->term_id : wp_create_nav_menu($menu_name);

    if ( ! is_wp_error($menu_id) ) {
        $old = wp_get_nav_menu_items($menu_id);
        if ($old) foreach ($old as $item) wp_delete_post($item->ID, true);

        $menu_pages = [
            'about'      => 'О НАС',
            'structure'  => 'СТРУКТУРА ХМАО ВОИ',
            'convention' => 'КОНВЕНЦИЯ ООН',
            'famous'     => 'ВЕЛИКИЕ ИНВАЛИДЫ',
            'projects'   => 'ПРОЕКТЫ',
            'news'       => 'НОВОСТИ',
            'events'     => 'МЕРОПРИЯТИЯ',
            'photos'     => 'ФОТОГРАФИИ',
            'documents'  => 'ДОКУМЕНТЫ',
            'team'       => 'КОМАНДА',
            'contacts'   => 'КОНТАКТЫ',
        ];
        $ord = 1;
        foreach ($menu_pages as $slug => $title) {
            if ( isset($page_ids[$slug]) ) {
                wp_update_nav_menu_item($menu_id, 0, [
                    'menu-item-title'     => $title,
                    'menu-item-object'    => 'page',
                    'menu-item-object-id' => $page_ids[$slug],
                    'menu-item-type'      => 'post_type',
                    'menu-item-status'    => 'publish',
                    'menu-item-position'  => $ord++,
                ]);
            }
        }
        $locs = get_theme_mod('nav_menu_locations', []);
        $locs['primary'] = $menu_id;
        set_theme_mod('nav_menu_locations', $locs);
    }

    /* ---- КОМАНДА (5 человек) ---- */
    if ( empty(get_posts(['post_type'=>'voi_team','numberposts'=>1])) ) {
        $team = [
            ['name'=>'Иванова Мария Ивановна',     'position'=>'Председатель ХМАО ВОИ',              'phone'=>'8 (3467) 00-00-01','email'=>'chair@hmao-voi.ru'],
            ['name'=>'Петров Александр Николаевич','position'=>'Заместитель председателя',             'phone'=>'8 (3467) 00-00-02','email'=>'deputy@hmao-voi.ru'],
            ['name'=>'Сидорова Елена Фёдоровна',   'position'=>'Ответственный секретарь',              'phone'=>'8 (3467) 00-00-03','email'=>''],
            ['name'=>'Кузнецов Виктор Павлович',   'position'=>'Юрисконсульт',                        'phone'=>'','email'=>''],
            ['name'=>'Смирнова Ольга Викторовна',  'position'=>'Специалист по социальной работе',      'phone'=>'','email'=>''],
        ];
        foreach ($team as $i => $m) {
            $id = wp_insert_post(['post_title'=>$m['name'],'post_status'=>'publish','post_type'=>'voi_team','menu_order'=>$i]);
            update_post_meta($id,'_voi_position',$m['position']);
            update_post_meta($id,'_voi_phone',$m['phone']);
            update_post_meta($id,'_voi_email',$m['email']);
        }
    }

    /* ---- ДОКУМЕНТЫ (3 штуки) ---- */
    if ( empty(get_posts(['post_type'=>'voi_document','numberposts'=>1])) ) {
        $docs = [
            ['title'=>'Устав ХМАО ВОИ (редакция 2022)','cat'=>'Учредительные документы','type'=>'PDF','size'=>'2.1 МБ','date'=>'15.03.2022','url'=>''],
            ['title'=>'Годовой отчёт о деятельности за 2025 год','cat'=>'Отчёты и планы','type'=>'PDF','size'=>'3.8 МБ','date'=>'31.01.2026','url'=>''],
            ['title'=>'Памятка по получению технических средств реабилитации','cat'=>'Методические материалы','type'=>'PDF','size'=>'0.6 МБ','date'=>'01.03.2025','url'=>''],
        ];
        foreach ($docs as $i => $d) {
            $id = wp_insert_post(['post_title'=>$d['title'],'post_status'=>'publish','post_type'=>'voi_document','menu_order'=>$i]);
            update_post_meta($id,'_voi_doc_category',$d['cat']);
            update_post_meta($id,'_voi_file_type',$d['type']);
            update_post_meta($id,'_voi_file_size',$d['size']);
            update_post_meta($id,'_voi_doc_date',$d['date']);
            update_post_meta($id,'_voi_file_url',$d['url']);
        }
    }

    /* ---- ПРОЕКТЫ (3 штуки) ---- */
    if ( empty(get_posts(['post_type'=>'voi_project','numberposts'=>1])) ) {
        $projects = [
            ['title'=>'Доступная среда','content'=>'Обследование объектов инфраструктуры на предмет доступности для маломобильных граждан.','status'=>'active','period'=>'2023–2024','tags'=>'Доступность, Инфраструктура'],
            ['title'=>'Спорт без границ','content'=>'Организация адаптивных спортивных секций и участие в паралимпийских соревнованиях.','status'=>'active','period'=>'2022–2024','tags'=>'Спорт, Реабилитация'],
            ['title'=>'Цифровая грамотность','content'=>'Бесплатные курсы компьютерной грамотности для людей с инвалидностью.','status'=>'new','period'=>'2024','tags'=>'Образование, Технологии'],
        ];
        foreach ($projects as $i => $p) {
            $id = wp_insert_post(['post_title'=>$p['title'],'post_content'=>$p['content'],'post_status'=>'publish','post_type'=>'voi_project','menu_order'=>$i]);
            update_post_meta($id,'_voi_project_status',$p['status']);
            update_post_meta($id,'_voi_project_period',$p['period']);
            update_post_meta($id,'_voi_project_tags',$p['tags']);
        }
    }

    /* ---- МЕРОПРИЯТИЯ (3 штуки) ---- */
    if ( empty(get_posts(['post_type'=>'voi_event','numberposts'=>1])) ) {
        $events = [
            ['title'=>'Отчётно-выборная конференция ХМАО ВОИ','content'=>'Ежегодная конференция организации. Подведение итогов и выборы руководящих органов.','date'=>'25 апреля 2026','time'=>'10:00','place'=>'г. Ханты-Мансийск, Дом народного творчества','type'=>'Конференция','day'=>'25','month'=>'апр'],
            ['title'=>'Семинар: Социальные права инвалидов',   'content'=>'Практический семинар с участием юристов по новым льготам и изменениям в законодательстве.','date'=>'20 мая 2026','time'=>'14:00','place'=>'г. Ханты-Мансийск, пр. Ленина, 3','type'=>'Семинар','day'=>'20','month'=>'май'],
            ['title'=>'Чемпионат по адаптивному теннису',      'content'=>'Ежегодный региональный чемпионат по адаптивному настольному теннису.','date'=>'15 мая 2026','time'=>'09:00','place'=>'г. Сургут, спорткомплекс «Олимпия»','type'=>'Спортивное','day'=>'15','month'=>'май'],
        ];
        foreach ($events as $i => $e) {
            $id = wp_insert_post(['post_title'=>$e['title'],'post_content'=>$e['content'],'post_status'=>'publish','post_type'=>'voi_event','menu_order'=>$i]);
            foreach (['date','time','place','type','day','month'] as $f)
                update_post_meta($id,'_voi_event_'.$f,$e[$f]);
        }
    }

    /* ---- ВЕЛИКИЕ ЛЮДИ (3 штуки) ---- */
    if ( empty(get_posts(['post_type'=>'voi_famous','numberposts'=>1])) ) {
        $famous = [
            ['name'=>'Людвиг ван Бетховен','content'=>'Один из величайших композиторов всех времён. Несмотря на полную глухоту, написал свои лучшие произведения, включая Девятую симфонию.','years'=>'1770–1827','field'=>'Музыкант, композитор','emoji'=>'🎵'],
            ['name'=>'Стивен Хокинг','content'=>'Выдающийся физик-теоретик, болел боковым амиотрофическим склерозом с 21 года, но продолжал работать до конца жизни.','years'=>'1942–2018','field'=>'Физик-теоретик','emoji'=>'🔭'],
            ['name'=>'Франклин Рузвельт','content'=>'Единственный президент США, переизбиравшийся четыре раза. После полиомиелита большую часть жизни провёл в инвалидной коляске.','years'=>'1882–1945','field'=>'32-й президент США','emoji'=>'🏛'],
        ];
        foreach ($famous as $i => $f) {
            $id = wp_insert_post(['post_title'=>$f['name'],'post_content'=>$f['content'],'post_status'=>'publish','post_type'=>'voi_famous','menu_order'=>$i]);
            update_post_meta($id,'_voi_famous_years',$f['years']);
            update_post_meta($id,'_voi_famous_field',$f['field']);
            update_post_meta($id,'_voi_famous_emoji',$f['emoji']);
        }
    }

    /* ---- НОВОСТИ (3 штуки) ---- */
    if ( ! get_posts(['post_type'=>'post','numberposts'=>1,'post_status'=>'publish']) ) {
        $news = [
            ['title'=>'ХМАО ВОИ провела конференцию по правам инвалидов','content'=>'<!-- wp:paragraph --><p>В Ханты-Мансийске прошла ежегодная конференция ХМАО ВОИ. В мероприятии приняли участие представители всех местных отделений округа.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>На конференции обсудили изменения в федеральном законодательстве о социальной защите инвалидов, а также итоги реализации региональных программ за 2025 год.</p><!-- /wp:paragraph -->'],
            ['title'=>'Открытие нового реабилитационного центра в Сургуте','content'=>'<!-- wp:paragraph --><p>При поддержке ХМАО ВОИ в Сургуте открылся новый центр комплексной реабилитации для людей с инвалидностью.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Центр оснащён современным оборудованием и принимает жителей всего округа. Запись ведётся по телефону горячей линии.</p><!-- /wp:paragraph -->'],
            ['title'=>'Победа на региональных паралимпийских играх','content'=>'<!-- wp:paragraph --><p>Спортсмены ХМАО ВОИ завоевали 12 медалей на региональных паралимпийских играх — 5 золотых, 4 серебряных и 3 бронзовых.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Поздравляем наших спортсменов и тренеров с блестящим выступлением!</p><!-- /wp:paragraph -->'],
        ];
        foreach ($news as $i => $n) {
            wp_insert_post(['post_title'=>$n['title'],'post_content'=>$n['content'],'post_status'=>'publish','post_author'=>1]);
        }
    }

    /* ---- ФОТОАЛЬБОМ (1 штука) ---- */
    if ( empty(get_posts(['post_type'=>'voi_album','numberposts'=>1])) ) {
        $content = '<!-- wp:paragraph --><p>Добавьте фотографии в этот альбом через блок «Галерея» в редакторе.</p><!-- /wp:paragraph -->';
        wp_insert_post(['post_title'=>'Конференция ХМАО ВОИ 2025','post_content'=>$content,'post_status'=>'publish','post_type'=>'voi_album']);
    }

    /* ---- Название сайта ---- */
    update_option('blogname', 'ХМАО ВОИ');
    update_option('blogdescription', 'Ханты-Мансийская региональная организация инвалидов');
    update_option('footer_copy_text', '© ' . date('Y') . ' ХМАО ВОИ. Все права защищены.');

    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'hmao_activate' );
add_action( 'after_switch_theme', 'hmao_activate' );

/* =========================================================
   11. КОНТЕНТ СТРАНИЦ (GUTENBERG-БЛОКИ)
   ========================================================= */

function hmao_home_content() {
    $h = hmao_gb('hmao/hero', [
        'badge'   => 'Общественная организация',
        'heading' => 'Ханты-Мансийская региональная организация Всероссийского общества инвалидов',
        'desc'    => 'Объединяем людей с ограниченными возможностями здоровья для равноправной и полноценной жизни в обществе',
        'btnText' => 'Узнать больше о нас',
        'btnUrl'  => '/about',
    ]);
    $s1 = hmao_gb('hmao/text-section', [
        'label'   => 'Кто мы',
        'heading' => 'О нашей организации',
        'body'    => 'ХМАО ВОИ — одна из крупнейших общественных организаций Ханты-Мансийского автономного округа. Мы объединяем более 5000 человек с ограниченными возможностями здоровья и работаем для того, чтобы каждый из них мог жить полноценной жизнью. Организация основана на принципах гуманизма, добровольности и равноправия.',
        'altBg'   => false,
    ]);
    $s2 = hmao_gb('hmao/text-section', [
        'label'   => 'Наша миссия',
        'heading' => 'Мы работаем для равных возможностей',
        'body'    => 'Наша миссия — содействие реализации конституционных прав и законных интересов инвалидов, вовлечение их в общественную жизнь через социальные, правозащитные, культурные и спортивные проекты. Мы верим, что каждый человек заслуживает уважения и равных возможностей.',
        'altBg'   => true,
    ]);
    $stats = hmao_gb('hmao/stats', [
        'title' => 'Организация в цифрах',
        'cards' => [
            ['icon'=>'🏛','num'=>'30+',   'label'=>'лет работы'],
            ['icon'=>'👥','num'=>'5000+', 'label'=>'членов организации'],
            ['icon'=>'🚀','num'=>'250+',  'label'=>'реализованных проектов'],
            ['icon'=>'🏆','num'=>'50+',   'label'=>'наград и грамот'],
        ],
    ]);
    $ach = hmao_gb('hmao/achievements', [
        'title'    => 'Наши достижения',
        'subtitle' => 'Результаты многолетней работы',
        'cards'    => [
            ['icon'=>'♿','title'=>'Доступная среда',         'text'=>'Помогаем создавать безбарьерную среду в городах и районах округа'],
            ['icon'=>'⚖️','title'=>'Правозащитная работа',   'text'=>'Защищаем права инвалидов в судах и органах государственной власти'],
            ['icon'=>'🎭','title'=>'Культура и спорт',        'text'=>'Организуем адаптивные спортивные и культурные мероприятия'],
            ['icon'=>'🤝','title'=>'Социальная поддержка',    'text'=>'Оказываем помощь и консультации людям с ограниченными возможностями'],
        ],
    ]);
    return $h . $s1 . $s2 . $stats . $ach;
}

function hmao_about_content() {
    return
        hmao_gb_heading('О нашей организации') .
        hmao_gb_paragraph('Ханты-Мансийская региональная организация Всероссийского общества инвалидов (ХМАО ВОИ) — одна из крупнейших общественных организаций Ханты-Мансийского автономного округа. Мы объединяем более 5 000 человек с ограниченными возможностями здоровья.') .
        hmao_gb_heading('Наша миссия') .
        hmao_gb_paragraph('Содействие реализации конституционных прав и законных интересов инвалидов, вовлечение их в общественную жизнь, интеграция в общество через реализацию социальных, правозащитных, культурных и спортивных проектов.') .
        hmao_gb_heading('Основные направления деятельности') .
        hmao_gb_list([
            'Правовая защита и представительство интересов инвалидов',
            'Реабилитация и социальная адаптация',
            'Содействие в трудоустройстве людей с инвалидностью',
            'Организация спортивных и культурных мероприятий',
            'Работа с молодёжью с ограниченными возможностями',
            'Взаимодействие с государственными органами власти',
        ]) .
        hmao_gb_heading('История организации') .
        hmao_gb_paragraph('Организация была основана более 30 лет назад и прошла долгий путь развития. За эти годы мы реализовали более 250 проектов и программ, направленных на улучшение качества жизни людей с инвалидностью в Ханты-Мансийском автономном округе.');
}

function hmao_structure_content() {
    return
        hmao_gb_heading('Руководство организации') .
        hmao_gb_paragraph('Председатель региональной организации ХМАО ВОИ — [Фамилия Имя Отчество]. Заместитель председателя — [Фамилия Имя Отчество]. Ответственный секретарь — [Фамилия Имя Отчество].') .
        hmao_gb_heading('Органы управления') .
        hmao_gb_paragraph('<strong>Конференция</strong> — высший руководящий орган организации. Собирается не реже одного раза в 5 лет.') .
        hmao_gb_paragraph('<strong>Правление</strong> — руководящий орган в период между конференциями. Избирается на 5 лет.') .
        hmao_gb_paragraph('<strong>Ревизионная комиссия</strong> — контрольный орган. Проводит ревизии финансово-хозяйственной деятельности.') .
        hmao_gb_heading('Местные отделения') .
        hmao_gb_paragraph('ХМАО ВОИ объединяет 22 местных отделения во всех городах и районах округа:') .
        hmao_gb_list([
            'Ханты-Мансийское городское отделение',
            'Сургутское городское отделение',
            'Нижневартовское городское отделение',
            'Нефтеюганское городское отделение',
            'Когалымское городское отделение',
            'Лангепасское городское отделение',
            'Советское районное отделение',
            'Берёзовское районное отделение',
        ]);
}

function hmao_convention_content() {
    return
        hmao_gb_heading('О документе') .
        hmao_gb_paragraph('Конвенция ООН о правах инвалидов принята резолюцией 61/106 Генеральной Ассамблеи от 13 декабря 2006 года. Россия ратифицировала Конвенцию 25 сентября 2012 года.') .
        hmao_gb_paragraph('Конвенция определяет права людей с ограниченными возможностями и обязательства государств по обеспечению и защите этих прав. Документ состоит из 50 статей.') .
        hmao_gb_heading('Статья 1 — Цели') .
        hmao_gb_paragraph('Цель Конвенции — поощрение, защита и обеспечение полного и равного осуществления всеми инвалидами всех прав человека и основных свобод, а также поощрение уважения присущего им достоинства.') .
        hmao_gb_heading('Статья 3 — Общие принципы') .
        hmao_gb_list([
            'Уважение присущего человеку достоинства и личной самостоятельности',
            'Недискриминация',
            'Полное и эффективное вовлечение в общество',
            'Равенство возможностей',
            'Доступность',
        ]) .
        hmao_gb_heading('Статья 9 — Доступность') .
        hmao_gb_paragraph('Государства обеспечивают инвалидам доступ наравне с другими к физическому окружению, транспорту, информации и связи, включая информационно-коммуникационные технологии.') .
        hmao_gb_heading('Статья 24 — Образование') .
        hmao_gb_paragraph('Инвалиды имеют право на образование на основе инклюзии и равенства возможностей на всех уровнях — от дошкольного до высшего.') .
        hmao_gb_heading('Статья 27 — Труд и занятость') .
        hmao_gb_paragraph('Инвалиды имеют право на труд наравне с другими, включая право зарабатывать на жизнь трудом по свободному выбору или согласию.');
}

function hmao_contacts_content() {
    $contacts = hmao_gb('hmao/contacts-block', [
        'address' => 'г. Ханты-Мансийск, ул. Примерная, д. 1',
        'phone'   => '8 (3467) 00-00-00',
        'email'   => 'info@hmao-voi.ru',
        'hours'   => 'Пн–Пт: 9:00–18:00',
        'vk'      => '',
        'tg'      => '',
        'ok'      => '',
    ]);
    $map = hmao_gb('hmao/map-block', [
        'lat'  => '61.003333',
        'lon'  => '69.019444',
        'zoom' => '14',
    ]);
    $form = hmao_gb('hmao/form-block', [
        'title'    => 'Напишите нам',
        'subtitle' => 'Ответим в течение рабочего дня',
    ]);
    return $contacts . $map . $form;
}
