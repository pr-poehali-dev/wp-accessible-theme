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
   7. АВТОМАТИЧЕСКОЕ СОЗДАНИЕ СТРАНИЦ И МЕНЮ ПРИ АКТИВАЦИИ
   ========================================================= */
function hmao_voi_activate() {
    $pages = [
        'about'      => [ 'О НАС',                          'page-about.php'      ],
        'structure'  => [ 'СТРУКТУРА ХМАО ВОИ',             'page-structure.php'  ],
        'convention' => [ 'КОНВЕНЦИЯ ООН О ПРАВАХ ИНВАЛИДОВ', 'page-convention.php' ],
        'famous'     => [ 'ВЕЛИКИЕ ИНВАЛИДЫ ПЛАНЕТЫ',        'page-famous.php'     ],
        'projects'   => [ 'ПРОЕКТЫ',                         'page-projects.php'   ],
        'news'       => [ 'НОВОСТИ',                         'page-news.php'       ],
        'events'     => [ 'МЕРОПРИЯТИЯ',                     'page-events.php'     ],
        'photos'     => [ 'ФОТОГРАФИИ',                      'page-photos.php'     ],
        'documents'  => [ 'ДОКУМЕНТЫ',                       'page-documents.php'  ],
        'team'       => [ 'КОМАНДА',                         'page-team.php'       ],
    ];

    $page_ids = [];

    foreach ( $pages as $slug => [ $title, $template ] ) {
        $existing = get_page_by_path( $slug );
        if ( ! $existing ) {
            $page_id = wp_insert_post( [
                'post_title'    => $title,
                'post_name'     => $slug,
                'post_status'   => 'publish',
                'post_type'     => 'page',
                'page_template' => $template,
            ] );
            update_post_meta( $page_id, '_wp_page_template', $template );
            $page_ids[ $slug ] = $page_id;
        } else {
            $page_ids[ $slug ] = $existing->ID;
        }
    }

    // Создаём главное меню
    $menu_name = 'Главное меню';
    $menu_id   = wp_create_nav_menu( $menu_name );

    if ( ! is_wp_error( $menu_id ) ) {
        $order = 1;
        foreach ( $pages as $slug => [ $title, ] ) {
            if ( isset( $page_ids[ $slug ] ) ) {
                wp_update_nav_menu_item( $menu_id, 0, [
                    'menu-item-title'     => $title,
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
    return get_theme_mod( $key, $default );
}

/** Данные блока достижений */
function hmao_achievement( $n ) {
    return [
        'num'   => hmao_mod( "achievement_{$n}_num",   '' ),
        'label' => hmao_mod( "achievement_{$n}_label", '' ),
        'icon'  => hmao_mod( "achievement_{$n}_icon",  '' ),
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
