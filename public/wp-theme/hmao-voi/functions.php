<?php
/**
 * ХМАО ВОИ — functions.php
 * Версия: 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/* =========================================================
   1. ПОДДЕРЖКА ТЕМЫ
   ========================================================= */
function hmao_voi_setup() {
    load_theme_textdomain( 'hmao-voi', get_template_directory() . '/languages' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', [ 'search-form','comment-form','comment-list','gallery','caption','script','style' ] );
    add_theme_support( 'custom-logo', [
        'height'      => 80,
        'width'       => 80,
        'flex-width'  => true,
        'flex-height' => true,
    ] );
    add_theme_support( 'customize-selective-refresh-widgets' );
    add_image_size( 'team-thumb',     300, 300, true );
    add_image_size( 'person-thumb',   300, 300, true );
    add_image_size( 'news-thumb',     800, 400, true );

    register_nav_menus( [
        'primary' => __( 'Основное меню', 'hmao-voi' ),
        'footer'  => __( 'Меню в подвале', 'hmao-voi' ),
    ] );
}
add_action( 'after_setup_theme', 'hmao_voi_setup' );

/* =========================================================
   2. СТИЛИ И СКРИПТЫ
   ========================================================= */
function hmao_voi_enqueue() {
    wp_enqueue_style(
        'google-fonts',
        'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Golos+Text:wght@400;500;600;700&display=swap',
        [],
        null
    );
    wp_enqueue_style(
        'hmao-voi-style',
        get_stylesheet_uri(),
        [ 'google-fonts' ],
        '1.0.0'
    );
    wp_enqueue_script(
        'hmao-voi-main',
        get_template_directory_uri() . '/assets/js/main.js',
        [],
        '1.0.0',
        true
    );

    // Передаём настройки Customizer в JS для версии слабовидящих
    $vi_settings = [
        'vi_bg'        => get_theme_mod( 'vi_bg',        '#000000' ),
        'vi_text'      => get_theme_mod( 'vi_text',      '#FFFF00' ),
        'vi_link'      => get_theme_mod( 'vi_link',      '#00FFFF' ),
        'vi_font_size' => get_theme_mod( 'vi_font_size', '120' ),
    ];
    wp_localize_script( 'hmao-voi-main', 'hmaoVI', $vi_settings );
}
add_action( 'wp_enqueue_scripts', 'hmao_voi_enqueue' );

/* =========================================================
   3. КАСТОМНЫЕ ТИПЫ ЗАПИСЕЙ (CPT)
   ========================================================= */

/**
 * Регистрация всех CPT одной функцией
 */
function hmao_voi_register_post_types() {

    $cpts = [
        'voi_team' => [
            'label'       => 'Сотрудники',
            'singular'    => 'Сотрудник',
            'menu_icon'   => 'dashicons-groups',
            'supports'    => [ 'title', 'thumbnail', 'page-attributes' ],
            'has_archive' => false,
        ],
        'voi_document' => [
            'label'       => 'Документы',
            'singular'    => 'Документ',
            'menu_icon'   => 'dashicons-media-document',
            'supports'    => [ 'title', 'page-attributes' ],
            'has_archive' => false,
        ],
        'voi_project' => [
            'label'       => 'Проекты',
            'singular'    => 'Проект',
            'menu_icon'   => 'dashicons-portfolio',
            'supports'    => [ 'title', 'editor', 'thumbnail', 'page-attributes' ],
            'has_archive' => true,
        ],
        'voi_event' => [
            'label'       => 'Мероприятия',
            'singular'    => 'Мероприятие',
            'menu_icon'   => 'dashicons-calendar-alt',
            'supports'    => [ 'title', 'editor', 'thumbnail', 'page-attributes' ],
            'has_archive' => true,
        ],
        'voi_famous' => [
            'label'       => 'Великие инвалиды',
            'singular'    => 'Великий человек',
            'menu_icon'   => 'dashicons-star-filled',
            'supports'    => [ 'title', 'editor', 'thumbnail', 'page-attributes' ],
            'has_archive' => false,
        ],
        'voi_photo' => [
            'label'       => 'Фотоальбомы',
            'singular'    => 'Фотоальбом',
            'menu_icon'   => 'dashicons-format-gallery',
            'supports'    => [ 'title', 'editor', 'thumbnail', 'page-attributes' ],
            'has_archive' => false,
        ],
    ];

    foreach ( $cpts as $post_type => $cfg ) {
        $singular = $cfg['singular'];
        $label    = $cfg['label'];

        register_post_type( $post_type, [
            'labels' => [
                'name'               => $label,
                'singular_name'      => $singular,
                'add_new'            => 'Добавить',
                'add_new_item'       => "Добавить $singular",
                'edit_item'          => "Редактировать $singular",
                'new_item'           => "Новый $singular",
                'view_item'          => "Просмотреть $singular",
                'search_items'       => "Найти в $label",
                'not_found'          => 'Не найдено',
                'not_found_in_trash' => 'В корзине пусто',
                'all_items'          => "Все — $label",
            ],
            'public'      => true,
            'show_in_rest' => true,
            'menu_position' => 5,
            'menu_icon'   => $cfg['menu_icon'],
            'has_archive' => $cfg['has_archive'],
            'supports'    => $cfg['supports'],
            'rewrite'     => [ 'slug' => $post_type ],
        ] );
    }
}
add_action( 'init', 'hmao_voi_register_post_types' );

/* =========================================================
   4. МЕТА-ПОЛЯ (Meta Boxes)
   ========================================================= */
function hmao_voi_add_meta_boxes() {

    // --- КОМАНДА ---
    add_meta_box(
        'voi_team_meta',
        'Данные сотрудника',
        'hmao_voi_team_meta_box',
        'voi_team', 'normal', 'high'
    );

    // --- ДОКУМЕНТЫ ---
    add_meta_box(
        'voi_document_meta',
        'Файл документа',
        'hmao_voi_document_meta_box',
        'voi_document', 'normal', 'high'
    );

    // --- ПРОЕКТЫ ---
    add_meta_box(
        'voi_project_meta',
        'Детали проекта',
        'hmao_voi_project_meta_box',
        'voi_project', 'normal', 'high'
    );

    // --- МЕРОПРИЯТИЯ ---
    add_meta_box(
        'voi_event_meta',
        'Детали мероприятия',
        'hmao_voi_event_meta_box',
        'voi_event', 'normal', 'high'
    );

    // --- ВЕЛИКИЕ ИНВАЛИДЫ ---
    add_meta_box(
        'voi_famous_meta',
        'Информация о человеке',
        'hmao_voi_famous_meta_box',
        'voi_famous', 'normal', 'high'
    );
}
add_action( 'add_meta_boxes', 'hmao_voi_add_meta_boxes' );

/* Общая функция вывода поля */
function hmao_voi_field( $label, $key, $value, $type = 'text', $placeholder = '' ) {
    $esc_key   = esc_attr( $key );
    $esc_val   = esc_attr( $value );
    $esc_ph    = esc_attr( $placeholder );
    echo "<p><label for='{$esc_key}'><strong>{$label}</strong></label><br/>";
    if ( $type === 'textarea' ) {
        echo "<textarea name='{$esc_key}' id='{$esc_key}' rows='3' style='width:100%'>" . esc_textarea( $value ) . "</textarea>";
    } else {
        echo "<input type='{$type}' name='{$esc_key}' id='{$esc_key}' value='{$esc_val}' placeholder='{$esc_ph}' style='width:100%' />";
    }
    echo "</p>";
}

/* --- КОМАНДА мета-бокс --- */
function hmao_voi_team_meta_box( $post ) {
    wp_nonce_field( 'voi_team_save', 'voi_team_nonce' );
    hmao_voi_field( 'Должность', '_voi_position', get_post_meta( $post->ID, '_voi_position', true ), 'text', 'Председатель' );
    hmao_voi_field( 'Email', '_voi_email', get_post_meta( $post->ID, '_voi_email', true ), 'email' );
    hmao_voi_field( 'Телефон', '_voi_phone', get_post_meta( $post->ID, '_voi_phone', true ), 'text', '+7 000 000-00-00' );
    echo '<p><small>Фото — миниатюра записи (Изображение записи справа).<br>Порядок — Порядок атрибутов страницы справа.</small></p>';
}

/* --- ДОКУМЕНТЫ мета-бокс --- */
function hmao_voi_document_meta_box( $post ) {
    wp_nonce_field( 'voi_document_save', 'voi_document_nonce' );
    $file_url  = get_post_meta( $post->ID, '_voi_file_url',  true );
    $file_size = get_post_meta( $post->ID, '_voi_file_size', true );
    $file_type = get_post_meta( $post->ID, '_voi_file_type', true );
    $category  = get_post_meta( $post->ID, '_voi_doc_category', true );
    ?>
    <p>
        <label for="_voi_file_url"><strong>URL файла</strong></label><br/>
        <input type="url" name="_voi_file_url" id="_voi_file_url"
               value="<?php echo esc_attr( $file_url ); ?>"
               placeholder="https://..." style="width:80%" />
        <button type="button" class="button" id="voi_upload_btn" style="margin-left:8px">
            Выбрать файл
        </button>
    </p>
    <?php
    hmao_voi_field( 'Размер файла (напр. 2.4 МБ)', '_voi_file_size', $file_size, 'text', '1.2 МБ' );
    ?>
    <p>
        <label for="_voi_file_type"><strong>Тип файла</strong></label><br/>
        <select name="_voi_file_type" id="_voi_file_type" style="width:100%">
            <?php foreach ( [ 'PDF', 'DOCX', 'XLSX', 'DOC', 'XLS', 'ZIP', 'Другое' ] as $t ) {
                $sel = selected( $file_type, $t, false );
                echo "<option value='{$t}' {$sel}>{$t}</option>";
            } ?>
        </select>
    </p>
    <?php
    hmao_voi_field( 'Категория (напр. Учредительные документы)', '_voi_doc_category', $category, 'text' );
    hmao_voi_field( 'Дата документа', '_voi_doc_date', get_post_meta( $post->ID, '_voi_doc_date', true ), 'text', 'дд.мм.гггг' );

    // JS для медиабиблиотеки
    ?>
    <script>
    jQuery(function($){
        $('#voi_upload_btn').on('click', function(){
            var frame = wp.media({
                title: 'Выберите файл',
                button: { text: 'Использовать файл' },
                multiple: false
            });
            frame.on('select', function(){
                var att = frame.state().get('selection').first().toJSON();
                $('#_voi_file_url').val( att.url );
                if ( att.filesizeHumanReadable ) {
                    $('#_voi_file_size').val( att.filesizeHumanReadable );
                }
                var ext = att.url.split('.').pop().toUpperCase();
                if ( ['PDF','DOCX','XLSX','DOC','XLS','ZIP'].indexOf(ext) !== -1 ) {
                    $('#_voi_file_type').val(ext);
                }
            });
            frame.open();
        });
    });
    </script>
    <?php
}

/* --- ПРОЕКТЫ мета-бокс --- */
function hmao_voi_project_meta_box( $post ) {
    wp_nonce_field( 'voi_project_save', 'voi_project_nonce' );
    $statuses = [ 'active' => 'Активный', 'new' => 'Новый', 'done' => 'Завершён' ];
    $cur = get_post_meta( $post->ID, '_voi_project_status', true );
    echo '<p><label><strong>Статус</strong></label><br/><select name="_voi_project_status" style="width:100%">';
    foreach ( $statuses as $val => $lbl ) {
        $sel = selected( $cur, $val, false );
        echo "<option value='{$val}' {$sel}>{$lbl}</option>";
    }
    echo '</select></p>';
    hmao_voi_field( 'Период (напр. 2023–2024)', '_voi_project_period', get_post_meta( $post->ID, '_voi_project_period', true ), 'text' );
    hmao_voi_field( 'Теги (через запятую)', '_voi_project_tags', get_post_meta( $post->ID, '_voi_project_tags', true ), 'text', 'Доступность, Инфраструктура' );
}

/* --- МЕРОПРИЯТИЯ мета-бокс --- */
function hmao_voi_event_meta_box( $post ) {
    wp_nonce_field( 'voi_event_save', 'voi_event_nonce' );
    hmao_voi_field( 'Дата (напр. 25 апреля 2026)', '_voi_event_date', get_post_meta( $post->ID, '_voi_event_date', true ), 'text' );
    hmao_voi_field( 'Время (напр. 10:00)', '_voi_event_time', get_post_meta( $post->ID, '_voi_event_time', true ), 'text', '10:00' );
    hmao_voi_field( 'Место', '_voi_event_place', get_post_meta( $post->ID, '_voi_event_place', true ), 'text', 'г. Ханты-Мансийск, ...' );
    hmao_voi_field( 'Тип мероприятия', '_voi_event_type', get_post_meta( $post->ID, '_voi_event_type', true ), 'text', 'Конференция' );
    hmao_voi_field( 'День (цифра для карточки)', '_voi_event_day', get_post_meta( $post->ID, '_voi_event_day', true ), 'text', '25' );
    hmao_voi_field( 'Месяц (для карточки)', '_voi_event_month', get_post_meta( $post->ID, '_voi_event_month', true ), 'text', 'апр' );
}

/* --- ВЕЛИКИЕ ИНВАЛИДЫ мета-бокс --- */
function hmao_voi_famous_meta_box( $post ) {
    wp_nonce_field( 'voi_famous_save', 'voi_famous_nonce' );
    hmao_voi_field( 'Годы жизни (напр. 1770–1827)', '_voi_famous_years', get_post_meta( $post->ID, '_voi_famous_years', true ), 'text' );
    hmao_voi_field( 'Сфера деятельности', '_voi_famous_field', get_post_meta( $post->ID, '_voi_famous_field', true ), 'text', 'Музыкант, композитор' );
    hmao_voi_field( 'Эмодзи (иконка)', '_voi_famous_emoji', get_post_meta( $post->ID, '_voi_famous_emoji', true ), 'text', '🎵' );
    echo '<p><small>Фото — миниатюра записи. Описание — в редакторе ниже.</small></p>';
}

/* =========================================================
   5. СОХРАНЕНИЕ МЕТА-ПОЛЕЙ
   ========================================================= */
function hmao_voi_save_meta( $post_id ) {
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    $post_type = get_post_type( $post_id );

    $nonce_map = [
        'voi_team'     => [ 'voi_team_nonce',     'voi_team_save'     ],
        'voi_document' => [ 'voi_document_nonce',  'voi_document_save' ],
        'voi_project'  => [ 'voi_project_nonce',   'voi_project_save'  ],
        'voi_event'    => [ 'voi_event_nonce',      'voi_event_save'    ],
        'voi_famous'   => [ 'voi_famous_nonce',     'voi_famous_save'   ],
    ];

    if ( ! isset( $nonce_map[ $post_type ] ) ) return;
    [ $nonce_field, $nonce_action ] = $nonce_map[ $post_type ];
    if ( ! isset( $_POST[ $nonce_field ] ) || ! wp_verify_nonce( $_POST[ $nonce_field ], $nonce_action ) ) return;

    $fields_map = [
        'voi_team'     => [ '_voi_position', '_voi_email', '_voi_phone' ],
        'voi_document' => [ '_voi_file_url', '_voi_file_size', '_voi_file_type', '_voi_doc_category', '_voi_doc_date' ],
        'voi_project'  => [ '_voi_project_status', '_voi_project_period', '_voi_project_tags' ],
        'voi_event'    => [ '_voi_event_date', '_voi_event_time', '_voi_event_place', '_voi_event_type', '_voi_event_day', '_voi_event_month' ],
        'voi_famous'   => [ '_voi_famous_years', '_voi_famous_field', '_voi_famous_emoji' ],
    ];

    foreach ( $fields_map[ $post_type ] as $key ) {
        if ( isset( $_POST[ $key ] ) ) {
            update_post_meta( $post_id, $key, sanitize_text_field( $_POST[ $key ] ) );
        }
    }

    // URL документа — сохраняем как URL
    if ( $post_type === 'voi_document' && isset( $_POST['_voi_file_url'] ) ) {
        update_post_meta( $post_id, '_voi_file_url', esc_url_raw( $_POST['_voi_file_url'] ) );
    }
}
add_action( 'save_post', 'hmao_voi_save_meta' );

/* =========================================================
   6. CUSTOMIZER — НАСТРОЙКИ САЙТА
   ========================================================= */
function hmao_voi_customizer( WP_Customize_Manager $wp_customize ) {

    /* === ДОСТИЖЕНИЯ (главная) === */
    $wp_customize->add_panel( 'hmao_achievements', [
        'title'    => 'Блок «Достижения»',
        'priority' => 30,
    ] );

    $achievements = [
        1 => [ 'num' => '30+',   'label' => 'лет работы на базе региона',       'icon' => '🏛' ],
        2 => [ 'num' => '5000+', 'label' => 'членов организации в 32 отраслях', 'icon' => '👥' ],
        3 => [ 'num' => '250+',  'label' => 'реализованных проектов',            'icon' => '🚀' ],
        4 => [ 'num' => '50+',   'label' => 'наград и грамот',                  'icon' => '🏆' ],
    ];

    for ( $i = 1; $i <= 4; $i++ ) {
        $section_id = "hmao_achievement_{$i}";
        $wp_customize->add_section( $section_id, [
            'title' => "Достижение #{$i}",
            'panel' => 'hmao_achievements',
        ] );

        foreach ( [ 'num' => 'Число/цифра', 'label' => 'Описание', 'icon' => 'Эмодзи иконка' ] as $key => $lbl ) {
            $setting_id = "achievement_{$i}_{$key}";
            $wp_customize->add_setting( $setting_id, [
                'default'   => $achievements[ $i ][ $key ],
                'transport' => 'refresh',
                'sanitize_callback' => 'sanitize_text_field',
            ] );
            $wp_customize->add_control( $setting_id, [
                'label'   => $lbl,
                'section' => $section_id,
                'type'    => 'text',
            ] );
        }
    }

    /* === ВЕРСИЯ ДЛЯ СЛАБОВИДЯЩИХ === */
    $wp_customize->add_section( 'hmao_vi', [
        'title'    => 'Версия для слабовидящих',
        'priority' => 35,
    ] );

    $vi_fields = [
        'vi_bg'        => [ 'Цвет фона',             '#000000', 'color' ],
        'vi_text'      => [ 'Цвет текста',            '#FFFF00', 'color' ],
        'vi_link'      => [ 'Цвет ссылок',            '#00FFFF', 'color' ],
        'vi_font_size' => [ 'Размер шрифта (%, напр. 120)', '120', 'text' ],
    ];

    foreach ( $vi_fields as $id => [ $label, $default, $type ] ) {
        $wp_customize->add_setting( $id, [
            'default'   => $default,
            'transport' => 'refresh',
            'sanitize_callback' => ( $type === 'color' ) ? 'sanitize_hex_color' : 'sanitize_text_field',
        ] );
        $wp_customize->add_control(
            ( $type === 'color' ) ? new WP_Customize_Color_Control( $wp_customize, $id, [
                'label'   => $label,
                'section' => 'hmao_vi',
            ] ) : new WP_Customize_Control( $wp_customize, $id, [
                'label'   => $label,
                'section' => 'hmao_vi',
                'type'    => 'text',
            ] )
        );
    }

    /* === КОНТАКТЫ В ШАПКЕ === */
    $wp_customize->add_section( 'hmao_contacts', [
        'title'    => 'Контакты организации',
        'priority' => 40,
    ] );

    $contacts = [
        'contact_address' => [ 'Адрес',    'г. Ханты-Мансийск, ул. Примерная, д. 1' ],
        'contact_phone'   => [ 'Телефон',  '8 (3467) 00-00-00' ],
        'contact_email'   => [ 'Email',    'info@hmao-voi.ru' ],
        'contact_hours'   => [ 'Часы работы', 'Пн–Пт: 9:00–18:00' ],
    ];

    foreach ( $contacts as $id => [ $label, $default ] ) {
        $wp_customize->add_setting( $id, [ 'default' => $default, 'transport' => 'refresh', 'sanitize_callback' => 'sanitize_text_field' ] );
        $wp_customize->add_control( $id, [ 'label' => $label, 'section' => 'hmao_contacts', 'type' => 'text' ] );
    }

    /* === ТЕКСТ ПОДВАЛА === */
    $wp_customize->add_section( 'hmao_footer', [
        'title'    => 'Подвал сайта',
        'priority' => 50,
    ] );
    $wp_customize->add_setting( 'footer_copy', [
        'default'           => '© ' . date('Y') . ' ХМАО ВОИ. Все права защищены.',
        'transport'         => 'refresh',
        'sanitize_callback' => 'wp_kses_post',
    ] );
    $wp_customize->add_control( 'footer_copy', [ 'label' => 'Копирайт', 'section' => 'hmao_footer', 'type' => 'text' ] );
}
add_action( 'customize_register', 'hmao_voi_customizer' );

/* =========================================================
   7. АВТОМАТИЧЕСКОЕ СОЗДАНИЕ СТРАНИЦ, МЕНЮ И ДЕМО-КОНТЕНТА
   ========================================================= */
function hmao_voi_activate() {

    /* --- Страницы с контентом --- */
    $pages = [
        'about' => [
            'title'    => 'О НАС',
            'template' => 'page-about.php',
            'content'  => '<h2>Кто мы</h2>
<p>Ханты-Мансийская региональная организация Всероссийского общества инвалидов (ХМАО ВОИ) — одна из крупнейших общественных организаций Ханты-Мансийского автономного округа, объединяющая людей с ограниченными возможностями здоровья.</p>
<p>Наша организация основана на принципах гуманизма, добровольности и равноправия. Мы работаем для того, чтобы каждый человек с инвалидностью имел равные возможности в обществе, получал необходимую поддержку и жил полноценной жизнью.</p>
<h2>Наша миссия</h2>
<p>Содействие реализации конституционных прав и законных интересов инвалидов, вовлечение их в общественную жизнь, интеграция в общество через реализацию социальных, правозащитных, культурных и спортивных проектов.</p>
<h2>Основные направления деятельности</h2>
<ul>
<li>Правовая защита и представительство интересов инвалидов</li>
<li>Реабилитация и социальная адаптация</li>
<li>Содействие в трудоустройстве</li>
<li>Спортивные и культурные мероприятия</li>
<li>Работа с молодёжью с ограниченными возможностями</li>
<li>Взаимодействие с государственными органами власти</li>
</ul>',
        ],
        'structure' => [
            'title'    => 'СТРУКТУРА ХМАО ВОИ',
            'template' => 'page-structure.php',
            'content'  => '<h2>Руководство региональной организации</h2>
<p>Председатель региональной организации ХМАО ВОИ — [Фамилия Имя Отчество]</p>
<p>Заместитель председателя — [Фамилия Имя Отчество]</p>
<p>Ответственный секретарь — [Фамилия Имя Отчество]</p>
<h2>Органы управления</h2>
<p><strong>Конференция</strong> — высший руководящий орган организации. Собирается не реже одного раза в 5 лет.</p>
<p><strong>Правление</strong> — руководящий орган в период между конференциями. Избирается на 5 лет.</p>
<p><strong>Ревизионная комиссия</strong> — контрольный орган. Проводит ревизии финансово-хозяйственной деятельности.</p>
<h2>Местные отделения</h2>
<p>ХМАО ВОИ объединяет 22 местных отделения во всех городах и районах Ханты-Мансийского автономного округа:</p>
<ul>
<li>Ханты-Мансийское городское отделение</li>
<li>Сургутское городское отделение</li>
<li>Нижневартовское городское отделение</li>
<li>Нефтеюганское городское отделение</li>
<li>Когалымское городское отделение</li>
<li>Лангепасское городское отделение</li>
<li>Советское районное отделение</li>
<li>Берёзовское районное отделение</li>
</ul>',
        ],
        'convention' => [
            'title'    => 'КОНВЕНЦИЯ ООН О ПРАВАХ ИНВАЛИДОВ',
            'template' => 'page-convention.php',
            'content'  => '<h2>О документе</h2>
<p>Конвенция ООН о правах инвалидов принята резолюцией 61/106 Генеральной Ассамблеи от 13 декабря 2006 года. Россия ратифицировала Конвенцию 25 сентября 2012 года.</p>
<p>Конвенция определяет права людей с ограниченными возможностями здоровья и обязательства государств по обеспечению и защите этих прав. Документ состоит из 50 статей и охватывает такие сферы, как доступность, право на жизнь, свободу выражения мнений, право на образование, здоровье и труд.</p>
<h2>Статья 1 — Цели</h2>
<p>Цель настоящей Конвенции заключается в поощрении, защите и обеспечении полного и равного осуществления всеми инвалидами всех прав человека и основных свобод, а также в поощрении уважения присущего им достоинства.</p>
<h2>Статья 3 — Общие принципы</h2>
<p>Уважение присущего человеку достоинства, его личной самостоятельности, включая свободу делать свой собственный выбор. Недискриминация. Полное и эффективное вовлечение и включение в общество.</p>
<h2>Статья 9 — Доступность</h2>
<p>Принятие надлежащих мер для обеспечения инвалидам доступа наравне с другими к физическому окружению, транспорту, информации и связи, включая информационно-коммуникационные технологии и системы.</p>
<h2>Статья 24 — Образование</h2>
<p>Инвалиды имеют право на образование. В целях реализации этого права без дискриминации и на основе равенства возможностей государства-участники обеспечивают инклюзивное образование на всех уровнях.</p>
<h2>Статья 27 — Труд и занятость</h2>
<p>Инвалиды имеют право на труд наравне с другими; это включает право на получение возможности зарабатывать себе на жизнь трудом, который инвалид свободно выбирает или на который он свободно соглашается.</p>',
        ],
        'famous'     => [ 'title' => 'ВЕЛИКИЕ ИНВАЛИДЫ ПЛАНЕТЫ', 'template' => 'page-famous.php',     'content' => '' ],
        'projects'   => [ 'title' => 'ПРОЕКТЫ',                   'template' => 'page-projects.php',   'content' => '' ],
        'news'       => [ 'title' => 'НОВОСТИ',                   'template' => 'page-news.php',       'content' => '' ],
        'events'     => [ 'title' => 'МЕРОПРИЯТИЯ',               'template' => 'page-events.php',     'content' => '' ],
        'photos'     => [ 'title' => 'ФОТОГРАФИИ',                'template' => 'page-photos.php',     'content' => '' ],
        'documents'  => [ 'title' => 'ДОКУМЕНТЫ',                 'template' => 'page-documents.php',  'content' => '' ],
        'team'       => [ 'title' => 'КОМАНДА',                   'template' => 'page-team.php',       'content' => '' ],
    ];

    $page_ids = [];

    foreach ( $pages as $slug => $cfg ) {
        $existing = get_page_by_path( $slug );
        if ( ! $existing ) {
            $page_id = wp_insert_post( [
                'post_title'    => $cfg['title'],
                'post_name'     => $slug,
                'post_status'   => 'publish',
                'post_type'     => 'page',
                'post_content'  => $cfg['content'],
                'page_template' => $cfg['template'],
            ] );
            update_post_meta( $page_id, '_wp_page_template', $cfg['template'] );
            $page_ids[ $slug ] = $page_id;
        } else {
            $page_ids[ $slug ] = $existing->ID;
        }
    }

    /* --- Настройки Customizer по умолчанию --- */
    $defaults = [
        'achievement_1_num'   => '30+',
        'achievement_1_label' => 'лет работы на базе региона',
        'achievement_1_icon'  => '🏛',
        'achievement_2_num'   => '5000+',
        'achievement_2_label' => 'членов организации в 32 отраслях',
        'achievement_2_icon'  => '👥',
        'achievement_3_num'   => '250+',
        'achievement_3_label' => 'реализованных проектов',
        'achievement_3_icon'  => '🚀',
        'achievement_4_num'   => '50+',
        'achievement_4_label' => 'наград и грамот',
        'achievement_4_icon'  => '🏆',
        'contact_address'     => 'г. Ханты-Мансийск, ул. Примерная, д. 1',
        'contact_phone'       => '8 (3467) 00-00-00',
        'contact_email'       => 'info@hmao-voi.ru',
        'contact_hours'       => 'Пн–Пт: 9:00–18:00',
        'footer_copy'         => '© ' . date('Y') . ' ХМАО ВОИ. Все права защищены.',
    ];
    foreach ( $defaults as $key => $val ) {
        if ( get_theme_mod( $key ) === '' || get_theme_mod( $key ) === false ) {
            set_theme_mod( $key, $val );
        }
    }

    /* --- Демо-новость --- */
    if ( ! get_posts(['post_type'=>'post','numberposts'=>1]) ) {
        wp_insert_post([
            'post_title'   => 'Добро пожаловать на сайт ХМАО ВОИ!',
            'post_content' => '<p>Ханты-Мансийская региональная организация Всероссийского общества инвалидов рада приветствовать вас на нашем обновлённом сайте.</p><p>Здесь вы найдёте информацию о деятельности организации, актуальные новости, расписание мероприятий и многое другое.</p><p>Следите за обновлениями!</p>',
            'post_status'  => 'publish',
            'post_author'  => 1,
        ]);
    }

    /* --- Демо-проекты --- */
    $demo_projects = [
        [
            'title'   => 'Доступная среда',
            'content' => 'Обследование объектов социальной инфраструктуры на предмет доступности для маломобильных граждан. Разработка рекомендаций по адаптации зданий и территорий.',
            'status'  => 'active',
            'period'  => '2023–2024',
            'tags'    => 'Доступность, Инфраструктура',
        ],
        [
            'title'   => 'Спорт без границ',
            'content' => 'Организация адаптивных спортивных секций для людей с различными видами инвалидности. Участие в региональных и федеральных паралимпийских соревнованиях.',
            'status'  => 'active',
            'period'  => '2022–2024',
            'tags'    => 'Спорт, Реабилитация',
        ],
        [
            'title'   => 'Цифровая грамотность',
            'content' => 'Бесплатные курсы компьютерной грамотности для людей с инвалидностью. Обучение работе с государственными порталами и дистанционными сервисами.',
            'status'  => 'new',
            'period'  => '2024',
            'tags'    => 'Образование, Технологии',
        ],
        [
            'title'   => 'Правовая помощь',
            'content' => 'Бесплатные юридические консультации для инвалидов по вопросам получения льгот, защиты прав, оформления документов.',
            'status'  => 'active',
            'period'  => '2020–2024',
            'tags'    => 'Право, Консультации',
        ],
    ];
    $existing_projects = get_posts(['post_type'=>'voi_project','numberposts'=>1]);
    if ( empty($existing_projects) ) {
        foreach ( $demo_projects as $order => $p ) {
            $pid = wp_insert_post([
                'post_title'   => $p['title'],
                'post_content' => $p['content'],
                'post_status'  => 'publish',
                'post_type'    => 'voi_project',
                'menu_order'   => $order,
            ]);
            update_post_meta( $pid, '_voi_project_status', $p['status'] );
            update_post_meta( $pid, '_voi_project_period', $p['period'] );
            update_post_meta( $pid, '_voi_project_tags',   $p['tags'] );
        }
    }

    /* --- Демо-мероприятия --- */
    $demo_events = [
        [
            'title'   => 'Отчётно-выборная конференция ХМАО ВОИ',
            'content' => 'Ежегодная отчётно-выборная конференция региональной организации. Подведение итогов работы, избрание руководящих органов на новый срок.',
            'date'    => '25 апреля 2026',
            'time'    => '10:00',
            'place'   => 'г. Ханты-Мансийск, ул. Мира, 5 — Дом народного творчества',
            'type'    => 'Конференция',
            'day'     => '25',
            'month'   => 'апр',
        ],
        [
            'title'   => 'Семинар: Социальные права инвалидов',
            'content' => 'Практический семинар с участием юристов и социальных работников. Темы: новые льготы, изменения в законодательстве, порядок получения ТСР.',
            'date'    => '20 мая 2026',
            'time'    => '14:00',
            'place'   => 'г. Ханты-Мансийск, пр. Ленина, 3',
            'type'    => 'Семинар',
            'day'     => '20',
            'month'   => 'май',
        ],
        [
            'title'   => 'Региональный чемпионат по адаптивному теннису',
            'content' => 'Ежегодный чемпионат по адаптивному настольному теннису. Принимают участие спортсмены из всех местных отделений ХМАО ВОИ.',
            'date'    => '15 мая 2026',
            'time'    => '09:00',
            'place'   => 'г. Сургут, спорткомплекс «Олимпия»',
            'type'    => 'Спортивное',
            'day'     => '15',
            'month'   => 'май',
        ],
    ];
    $existing_events = get_posts(['post_type'=>'voi_event','numberposts'=>1]);
    if ( empty($existing_events) ) {
        foreach ( $demo_events as $order => $e ) {
            $eid = wp_insert_post([
                'post_title'   => $e['title'],
                'post_content' => $e['content'],
                'post_status'  => 'publish',
                'post_type'    => 'voi_event',
                'menu_order'   => $order,
            ]);
            update_post_meta( $eid, '_voi_event_date',  $e['date'] );
            update_post_meta( $eid, '_voi_event_time',  $e['time'] );
            update_post_meta( $eid, '_voi_event_place', $e['place'] );
            update_post_meta( $eid, '_voi_event_type',  $e['type'] );
            update_post_meta( $eid, '_voi_event_day',   $e['day'] );
            update_post_meta( $eid, '_voi_event_month', $e['month'] );
        }
    }

    /* --- Демо-документы --- */
    $demo_docs = [
        [
            'title'    => 'Устав ХМАО ВОИ (редакция 2022)',
            'category' => 'Учредительные документы',
            'type'     => 'PDF',
            'size'     => '2.1 МБ',
            'date'     => '15.03.2022',
            'url'      => '',
        ],
        [
            'title'    => 'Годовой отчёт о деятельности за 2025 год',
            'category' => 'Отчёты и планы',
            'type'     => 'PDF',
            'size'     => '3.8 МБ',
            'date'     => '31.01.2026',
            'url'      => '',
        ],
        [
            'title'    => 'Памятка по получению технических средств реабилитации',
            'category' => 'Методические материалы',
            'type'     => 'PDF',
            'size'     => '0.6 МБ',
            'date'     => '01.03.2025',
            'url'      => '',
        ],
        [
            'title'    => 'Льготы и выплаты инвалидам в 2026 году',
            'category' => 'Методические материалы',
            'type'     => 'DOCX',
            'size'     => '0.7 МБ',
            'date'     => '05.01.2026',
            'url'      => '',
        ],
    ];
    $existing_docs = get_posts(['post_type'=>'voi_document','numberposts'=>1]);
    if ( empty($existing_docs) ) {
        foreach ( $demo_docs as $order => $d ) {
            $did = wp_insert_post([
                'post_title'  => $d['title'],
                'post_status' => 'publish',
                'post_type'   => 'voi_document',
                'menu_order'  => $order,
            ]);
            update_post_meta( $did, '_voi_doc_category', $d['category'] );
            update_post_meta( $did, '_voi_file_type',    $d['type'] );
            update_post_meta( $did, '_voi_file_size',    $d['size'] );
            update_post_meta( $did, '_voi_doc_date',     $d['date'] );
            update_post_meta( $did, '_voi_file_url',     $d['url'] );
        }
    }

    /* --- Демо-команда --- */
    $demo_team = [
        [ 'name' => 'Иванова Мария Ивановна',    'position' => 'Председатель ХМАО ВОИ',                 'phone' => '8 (3467) 00-00-01', 'email' => '' ],
        [ 'name' => 'Петров Александр Николаевич','position' => 'Заместитель председателя',              'phone' => '8 (3467) 00-00-02', 'email' => '' ],
        [ 'name' => 'Сидорова Елена Фёдоровна',  'position' => 'Ответственный секретарь',                'phone' => '8 (3467) 00-00-03', 'email' => '' ],
        [ 'name' => 'Кузнецов Виктор Павлович',  'position' => 'Юрисконсульт',                          'phone' => '', 'email' => '' ],
        [ 'name' => 'Смирнова Ольга Викторовна', 'position' => 'Специалист по социальной работе',        'phone' => '', 'email' => '' ],
        [ 'name' => 'Фёдоров Игорь Семёнович',  'position' => 'Специалист по проектной деятельности',   'phone' => '', 'email' => '' ],
    ];
    $existing_team = get_posts(['post_type'=>'voi_team','numberposts'=>1]);
    if ( empty($existing_team) ) {
        foreach ( $demo_team as $order => $m ) {
            $tid = wp_insert_post([
                'post_title'  => $m['name'],
                'post_status' => 'publish',
                'post_type'   => 'voi_team',
                'menu_order'  => $order,
            ]);
            update_post_meta( $tid, '_voi_position', $m['position'] );
            update_post_meta( $tid, '_voi_phone',    $m['phone'] );
            update_post_meta( $tid, '_voi_email',    $m['email'] );
        }
    }

    /* --- Демо-великие люди --- */
    $demo_famous = [
        [
            'name'    => 'Людвиг ван Бетховен',
            'content' => 'Один из величайших композиторов всех времён. Несмотря на полную глухоту, написал свои лучшие произведения, в том числе знаменитую Девятую симфонию.',
            'years'   => '1770–1827',
            'field'   => 'Музыкант, композитор',
            'emoji'   => '🎵',
        ],
        [
            'name'    => 'Стивен Хокинг',
            'content' => 'Выдающийся физик-теоретик, автор теорий о чёрных дырах и космологии. Болел боковым амиотрофическим склерозом с 21 года, но продолжал работать до конца жизни.',
            'years'   => '1942–2018',
            'field'   => 'Физик-теоретик',
            'emoji'   => '🔭',
        ],
        [
            'name'    => 'Франклин Рузвельт',
            'content' => 'Единственный президент США, переизбиравшийся четыре раза. Перенёс полиомиелит в 1921 году, большую часть жизни провёл в инвалидной коляске.',
            'years'   => '1882–1945',
            'field'   => 'Политик, 32-й президент США',
            'emoji'   => '🏛',
        ],
        [
            'name'    => 'Алексей Маресьев',
            'content' => 'Советский военный лётчик, после ампутации обеих ног вернулся в строй и совершил ещё 86 боевых вылетов. Герой Советского Союза.',
            'years'   => '1916–2001',
            'field'   => 'Лётчик-ас, Герой СССР',
            'emoji'   => '✈️',
        ],
    ];
    $existing_famous = get_posts(['post_type'=>'voi_famous','numberposts'=>1]);
    if ( empty($existing_famous) ) {
        foreach ( $demo_famous as $order => $f ) {
            $fid = wp_insert_post([
                'post_title'   => $f['name'],
                'post_content' => $f['content'],
                'post_status'  => 'publish',
                'post_type'    => 'voi_famous',
                'menu_order'   => $order,
            ]);
            update_post_meta( $fid, '_voi_famous_years', $f['years'] );
            update_post_meta( $fid, '_voi_famous_field', $f['field'] );
            update_post_meta( $fid, '_voi_famous_emoji', $f['emoji'] );
        }
    }

    /* --- Главное меню --- */
    $menu_name = 'Главное меню';
    $existing_menu = wp_get_nav_menu_object( $menu_name );
    $menu_id = $existing_menu ? $existing_menu->term_id : wp_create_nav_menu( $menu_name );

    if ( ! is_wp_error( $menu_id ) ) {
        // Очищаем старые пункты если переактивация
        $old_items = wp_get_nav_menu_items( $menu_id );
        if ( $old_items ) {
            foreach ( $old_items as $item ) {
                wp_delete_post( $item->ID, true );
            }
        }

        $order = 1;
        foreach ( $pages as $slug => $cfg ) {
            if ( isset( $page_ids[ $slug ] ) ) {
                wp_update_nav_menu_item( $menu_id, 0, [
                    'menu-item-title'     => $cfg['title'],
                    'menu-item-object'    => 'page',
                    'menu-item-object-id' => $page_ids[ $slug ],
                    'menu-item-type'      => 'post_type',
                    'menu-item-status'    => 'publish',
                    'menu-item-position'  => $order++,
                ] );
            }
        }

        $locations = get_theme_mod( 'nav_menu_locations', [] );
        $locations['primary'] = $menu_id;
        set_theme_mod( 'nav_menu_locations', $locations );
    }

    /* --- Главная страница --- */
    $front = get_page_by_path('front-home');
    if ( ! $front ) {
        $front_id = wp_insert_post([
            'post_title'    => 'Главная',
            'post_name'     => 'front-home',
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'page_template' => 'front-page.php',
        ]);
        update_post_meta( $front_id, '_wp_page_template', 'front-page.php' );
        update_option( 'show_on_front', 'page' );
        update_option( 'page_on_front', $front_id );
    }

    /* --- Название и описание сайта --- */
    if ( get_option('blogname') === 'Just another WordPress site' || get_option('blogname') === '' ) {
        update_option( 'blogname', 'ХМАО ВОИ' );
    }
    if ( get_option('blogdescription') === '' ) {
        update_option( 'blogdescription', 'Ханты-Мансийская региональная организация инвалидов' );
    }

    flush_rewrite_rules();
}
register_activation_hook( get_template_directory() . '/functions.php', 'hmao_voi_activate' );

// Запускаем и при переключении темы
add_action( 'after_switch_theme', 'hmao_voi_activate' );

/* =========================================================
   8. МЕДИАБИБЛИОТЕКА В CPT ДОКУМЕНТЫ
   ========================================================= */
function hmao_voi_enqueue_admin_scripts( $hook ) {
    if ( in_array( $hook, [ 'post.php', 'post-new.php' ], true ) ) {
        wp_enqueue_media();
    }
}
add_action( 'admin_enqueue_scripts', 'hmao_voi_enqueue_admin_scripts' );

/* =========================================================
   9. ХЕЛПЕРЫ ШАБЛОНОВ
   ========================================================= */

/** Вернуть значение Customizer или дефолт */
function hmao_mod( $key, $default = '' ) {
    $builtin_defaults = [
        'contact_address' => 'г. Ханты-Мансийск, ул. Примерная, д. 1',
        'contact_phone'   => '8 (3467) 00-00-00',
        'contact_email'   => 'info@hmao-voi.ru',
        'contact_hours'   => 'Пн–Пт: 9:00–18:00',
        'footer_copy'     => '© ' . date('Y') . ' ХМАО ВОИ. Все права защищены.',
    ];
    $fallback = $default !== '' ? $default : ( $builtin_defaults[ $key ] ?? '' );
    return get_theme_mod( $key, $fallback );
}

/** Данные блока достижений (с fallback-значениями) */
function hmao_achievement( $n ) {
    $fallbacks = [
        1 => [ 'num' => '30+',   'label' => 'лет работы на базе региона',       'icon' => '🏛' ],
        2 => [ 'num' => '5000+', 'label' => 'членов организации в 32 отраслях', 'icon' => '👥' ],
        3 => [ 'num' => '250+',  'label' => 'реализованных проектов',            'icon' => '🚀' ],
        4 => [ 'num' => '50+',   'label' => 'наград и грамот',                  'icon' => '🏆' ],
    ];
    $fb = $fallbacks[ $n ] ?? [ 'num' => '', 'label' => '', 'icon' => '' ];
    return [
        'num'   => hmao_mod( "achievement_{$n}_num",   $fb['num']   ),
        'label' => hmao_mod( "achievement_{$n}_label", $fb['label'] ),
        'icon'  => hmao_mod( "achievement_{$n}_icon",  $fb['icon']  ),
    ];
}

/** SVG иконки (встроенные) */
function hmao_icon( $name, $cls = '' ) {
    $icons = [
        'eye'      => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg>',
        'download' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>',
        'file'     => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>',
        'calendar' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>',
        'map-pin'  => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>',
        'phone'    => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>',
        'mail'     => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>',
        'user'     => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>',
        'arrow'    => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>',
        'menu'     => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>',
        'close'    => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>',
        'globe'    => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/></svg>',
    ];
    $icon = $icons[ $name ] ?? '';
    if ( $cls ) {
        $icon = str_replace( '<svg ', "<svg class=\"{$cls}\" ", $icon );
    }
    return $icon;
}

/* =========================================================
   10. ФОРМАТИРОВАНИЕ КНОПКИ СКАЧИВАНИЯ
   ========================================================= */
function hmao_download_button( $url, $filename = '' ) {
    if ( empty( $url ) ) return '';
    if ( ! $filename ) {
        $filename = basename( parse_url( $url, PHP_URL_PATH ) );
    }
    $esc_url  = esc_url( $url );
    $esc_name = esc_attr( $filename );
    return sprintf(
        '<a href="%s" download="%s" class="btn-download" rel="nofollow">%s Скачать</a>',
        $esc_url,
        $esc_name,
        hmao_icon('download')
    );
}

/* =========================================================
   11. BREADCRUMBS
   ========================================================= */
function hmao_breadcrumbs() {
    echo '<nav class="breadcrumbs" aria-label="Хлебные крошки">';
    echo '<a href="' . esc_url( home_url('/') ) . '">Главная</a>';
    if ( is_singular() ) {
        echo ' / ';
        the_title( '<span>', '</span>' );
    } elseif ( is_archive() ) {
        echo ' / ';
        echo esc_html( post_type_archive_title( '', false ) );
    }
    echo '</nav>';
}

/* =========================================================
   12. EXCERPT
   ========================================================= */
function hmao_excerpt_length( $length ) { return 25; }
add_filter( 'excerpt_length', 'hmao_excerpt_length' );

function hmao_excerpt_more( $more ) { return '…'; }
add_filter( 'excerpt_more', 'hmao_excerpt_more' );