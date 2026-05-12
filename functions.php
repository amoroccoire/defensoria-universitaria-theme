<?php
/**
 * functions.php — Defensoría Universitaria UNSA
 */

// =============================================
// 1. Assets: encolar CSS y JS compilados
// =============================================
require_once get_template_directory() . '/template-parts/library/library-helpers.php';

function defensoria_assets() {
    wp_enqueue_style(
        'defensoria-style',
        get_template_directory_uri() . '/assets/css/main.css',
        [],
        '1.0'
    );
    wp_enqueue_script(
        'defensoria-script',
        get_template_directory_uri() . '/assets/js/app.js',
        [],
        '1.0',
        true
    );
}
add_action('wp_enqueue_scripts', 'defensoria_assets');

function defensoria_theme_support() {
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'defensoria_theme_support');


// =============================================
// 2. Registrar menús de navegación
// =============================================
function defensoria_register_menus() {
    register_nav_menus([
        'primary' => 'Menú Principal',
        'footer'  => 'Menú Footer',
    ]);
}
add_action('after_setup_theme', 'defensoria_register_menus');

// =============================================
// 3. Custom Post Types
// =============================================
function defensoria_register_post_types() {

    // --- Noticias ---
    register_post_type('noticia', [
        'labels' => [
            'name'          => 'Noticias',
            'singular_name' => 'Noticia',
            'add_new'       => 'Añadir noticia',
            'add_new_item'  => 'Añadir nueva noticia',
            'edit_item'     => 'Editar noticia',
            'view_item'     => 'Ver noticia',
            'search_items'  => 'Buscar noticias',
            'not_found'     => 'No se encontraron noticias',
        ],
        'public'        => true,
        'show_in_menu'  => true,
        'menu_icon'     => 'dashicons-megaphone',
        'menu_position' => 5,
        'supports'      => ['title', 'editor', 'thumbnail', 'excerpt'],
        'has_archive'   => true,
        'rewrite'       => ['slug' => 'noticias'],
        'show_in_rest'  => false,
    ]);

    // --- Eventos ---
    register_post_type('evento', [
        'labels' => [
            'name'          => 'Eventos',
            'singular_name' => 'Evento',
            'add_new'       => 'Añadir evento',
            'add_new_item'  => 'Añadir nuevo evento',
            'edit_item'     => 'Editar evento',
            'view_item'     => 'Ver evento',
            'search_items'  => 'Buscar eventos',
            'not_found'     => 'No se encontraron eventos',
        ],
        'public'        => true,
        'show_in_menu'  => true,
        'menu_icon'     => 'dashicons-calendar-alt',
        'menu_position' => 6,
        'supports'      => ['title', 'editor', 'thumbnail', 'excerpt'],
        'has_archive'   => true,
        'rewrite'       => ['slug' => 'eventos'],
        'show_in_rest'  => false,
    ]);

    // --- Documentos ---
    register_post_type('documento', [
        'labels' => [
            'name'          => 'Documentos',
            'singular_name' => 'Documento',
            'add_new'       => 'Añadir documento',
            'add_new_item'  => 'Añadir nuevo documento',
            'edit_item'     => 'Editar documento',
            'view_item'     => 'Ver documento',
            'search_items'  => 'Buscar documentos',
            'not_found'     => 'No se encontraron documentos',
        ],
        'public'        => true,
        'show_in_menu'  => true,
        'menu_icon'     => 'dashicons-media-document',
        'menu_position' => 7,
        'supports'      => ['title', 'thumbnail'],
        'has_archive'   => true,
        'rewrite'       => ['slug' => 'documentos'],
        'show_in_rest'  => false,
    ]);

    // --- Equipo ---
    register_post_type('miembro', [
        'labels' => [
            'name'          => 'Equipo',
            'singular_name' => 'Miembro',
            'add_new'       => 'Añadir miembro',
            'add_new_item'  => 'Añadir nuevo miembro',
            'edit_item'     => 'Editar miembro',
            'view_item'     => 'Ver miembro',
            'search_items'  => 'Buscar miembros',
            'not_found'     => 'No se encontraron miembros',
        ],
        'public'        => true,
        'show_in_menu'  => true,
        'menu_icon'     => 'dashicons-groups',
        'menu_position' => 8,
        'supports'      => ['title', 'thumbnail'],
        'has_archive'   => false,
        'rewrite'       => ['slug' => 'equipo'],
        'show_in_rest'  => false,
    ]);
}
add_action('init', 'defensoria_register_post_types');

// =============================================
// 3b. Taxonomía: Categorías de noticias
// =============================================
function defensoria_register_taxonomies() {
    register_taxonomy('categoria_noticia', 'noticia', [
        'labels' => [
            'name'          => 'Categorías',
            'singular_name' => 'Categoría',
            'add_new_item'  => 'Añadir categoría',
            'edit_item'     => 'Editar categoría',
            'search_items'  => 'Buscar categorías',
            'not_found'     => 'No se encontraron categorías',
        ],
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'rewrite'           => ['slug' => 'categoria-noticia'],
        'show_in_rest'      => false,
    ]);

    // Categorías de documentos
    register_taxonomy('categoria_documento', 'documento', [
        'labels' => [
            'name'          => 'Categorías',
            'singular_name' => 'Categoría',
            'add_new_item'  => 'Añadir categoría',
            'edit_item'     => 'Editar categoría',
            'search_items'  => 'Buscar categorías',
            'not_found'     => 'No se encontraron categorías',
        ],
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'rewrite'           => ['slug' => 'categoria-documento'],
        'show_in_rest'      => false,
    ]);
}
add_action('init', 'defensoria_register_taxonomies');


// =============================================
// 4. Flush rewrite rules al activar el tema
//    (necesario para que funcionen los slugs)
// =============================================
function defensoria_rewrite_flush() {
    defensoria_register_post_types();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'defensoria_rewrite_flush');

// 1. Registro del CPT para las tarjetas del Hero
function defensoria_register_hero_cards_cpt() {
    register_post_type('hero_card', [
        'labels' => [
            'name'          => 'Tarjetas del Hero',
            'singular_name' => 'Tarjeta Hero',
            'add_new'       => 'Añadir Nueva Tarjeta',
            'add_new_item'  => 'Añadir Nueva Tarjeta al Hero',
            'edit_item'     => 'Editar Tarjeta',
        ],
        'public'        => true,
        'show_in_menu'  => true,
        'menu_icon'     => 'dashicons-images-alt2',
        'supports'      => ['title', 'thumbnail', 'excerpt'], // Usaremos el extracto para la descripción
        'has_archive'   => false,
    ]);
}
add_action('init', 'defensoria_register_hero_cards_cpt');

// =============================================
// 5. Walker para el nav desktop (header)
//    Genera: <a class="nav-link ...">Texto<span/></a>
//    sin los <li> y <ul> de WordPress
// =============================================
class Oficina_Desktop_Walker extends Walker_Nav_Menu {

    // Abre cada item — omitimos el <li>
    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $url     = $item->url ?? '#';
        $title   = $item->title ?? '';
        $target  = ! empty( $item->target ) ? $item->target : '_self';
        $rel     = $target === '_blank' ? ' rel="noopener noreferrer"' : '';
        $current = in_array( 'current-menu-item', $item->classes ?? [] )
                   ? ' text-gray-400'
                   : '';

        $output .= sprintf(
            '<a href="%s" target="%s"%s class="nav-link px-4 py-2 text-white font-medium hover:text-white/60 rounded-lg transition-colors relative group%s">%s<span class="absolute bottom-0 left-0 w-full h-0.5 bg-gray-400 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span></a>',
            esc_url( $url ),
            esc_attr( $target ),
            $rel,
            $current,
            esc_html( $title )
        );
    }

    // Omitir apertura/cierre de <ul> y <li>
    public function start_lvl( &$output, $depth = 0, $args = null ) {}
    public function end_lvl( &$output, $depth = 0, $args = null ) {}
    public function end_el( &$output, $item, $depth = 0, $args = null ) {}
}


// =============================================
// 6. Walker para el nav mobile (header)
//    Genera: <a class="block px-4 ...">Texto</a>
// =============================================
class Oficina_Mobile_Walker extends Walker_Nav_Menu {

    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $url    = $item->url ?? '#';
        $title  = $item->title ?? '';
        $target = ! empty( $item->target ) ? $item->target : '_self';

        $output .= sprintf(
            '<a href="%s" target="%s" class="block px-4 py-2 text-gray-700 hover:text-gray-900 font-medium rounded-lg">%s</a>',
            esc_url( $url ),
            esc_attr( $target ),
            esc_html( $title )
        );
    }

    public function start_lvl( &$output, $depth = 0, $args = null ) {}
    public function end_lvl( &$output, $depth = 0, $args = null ) {}
    public function end_el( &$output, $item, $depth = 0, $args = null ) {}
}


// =============================================
// 7. Walker para el footer
//    Genera: <li><a class="hover:text-blue-400 ...">Texto</a></li>
// =============================================
class Oficina_Footer_Walker extends Walker_Nav_Menu {

    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $url    = $item->url ?? '#';
        $title  = $item->title ?? '';
        $target = ! empty( $item->target ) ? $item->target : '_self';

        $output .= sprintf(
            '<li><a href="%s" target="%s" class="hover:text-white/60 transition-colors flex items-center group"><svg class="w-3 h-3 mr-2 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>%s</a></li>',
            esc_url( $url ),
            esc_attr( $target ),
            esc_html( $title )
        );
    }

    public function end_el( &$output, $item, $depth = 0, $args = null ) {}
}

function oficina_customize_register( $wp_customize ) {

    // --- IDENTIDAD DEL HEADER Y FOOTER---
    $wp_customize->add_section( 'oficina_header_section' , array(
        'title'      => 'Header y Footer: Logos y textos',
        'priority'   => 30,
    ) );

    // Logo UNSA
    $wp_customize->add_setting( 'logo_unsa' );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'logo_unsa', array(
        'label'    => 'Logo UNSA',
        'section'  => 'oficina_header_section',
    ) ) );

    // Logo oficina
    $wp_customize->add_setting( 'logo_oficina' );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'logo_oficina', array(
        'label'    => 'Logo oficina',
        'section'  => 'oficina_header_section',
    ) ) );

    // Texto al lado del logo (Nombre de la Oficina)
    $wp_customize->add_setting( 'header_oficina_nombre', array('default' => 'Defensoría Universitaria') );
    $wp_customize->add_control( 'header_oficina_nombre', array(
        'label'    => 'Nombre de la Oficina',
        'section'  => 'oficina_header_section',
        'type'     => 'text',
    ) );

    // Color del footer y header
    $wp_customize->add_setting( 'header_footer_color', array(
        'default'           => '#141F40',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_footer_color', array(
        'label'    => 'Color del Header y Footer',
        'section'  => 'oficina_header_section',
        'settings' => 'header_footer_color',
    ) ) );


    // --- CONFIGURACIÓN DEL HERO ---
    $wp_customize->add_section( 'oficina_hero_section' , array(
        'title'      => 'Hero: Imágenes y Contenido',
        'priority'   => 31,
    ) );

    // Imágenes del Hero (Carrusel)
    for ($i = 1; $i <= 5; $i++) {
        $wp_customize->add_setting( "hero_bg_$i" );
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, "hero_bg_$i", array(
            'label'    => "Imagen de Fondo $i",
            'section'  => 'oficina_hero_section',
        ) ) );
    }

    // Título Principal del Hero
    $wp_customize->add_setting( 'hero_title', array('default' => 'DEFENSORÍA UNIVERSITARIA') );
    $wp_customize->add_control( 'hero_title', array(
        'label'    => 'Título del Hero',
        'section'  => 'oficina_hero_section',
        'type'     => 'text',
    ) );

    // Resumen del Hero de la oficina
    $wp_customize->add_setting( 'hero_subtitle', array('default' => 'Defender tus derechos nos fortalece') );
    $wp_customize->add_control( 'hero_subtitle', array(
        'label'    => 'Resumen de la oficina en el Hero',
        'section'  => 'oficina_hero_section',
        'type'     => 'textarea',
    ) );

    $wp_customize->add_setting( 'hero_show_btn', array(
        'default'           => true,
        'sanitize_callback' => 'oficina_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'hero_show_btn', array(
        'label'    => '¿Mostrar botón?',
        'section'  => 'oficina_hero_section',
        'type'     => 'checkbox',
    ) );

    // Texto del Botón
    $wp_customize->add_setting( 'hero_btn_text', array('default' => 'Presentar una queja') );
    $wp_customize->add_control( 'hero_btn_text', array(
        'label'    => 'Texto del Botón',
        'section'  => 'oficina_hero_section',
        'type'     => 'text',
    ) );

    // Color del Botón
    $wp_customize->add_setting( 'hero_btn_color', array(
        'default'           => '#b90615',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'hero_btn_color', array(
        'label'    => 'Color del Botón',
        'section'  => 'oficina_hero_section',
        'settings' => 'hero_btn_color',
    ) ) );

    // Color del hover Botón
    $wp_customize->add_setting( 'hero_hover_btn_color', array(
        'default'           => '#8C0712',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'hero_hover_btn_color', array(
        'label'    => 'Color del Botón (Hover)',
        'section'  => 'oficina_hero_section',
        'settings' => 'hero_hover_btn_color',
    ) ) );

    //Centrar contenido del Hero
    $wp_customize->add_setting('hero_center_content', array(
        'default'   => false,
        'sanitize_callback' => 'oficina_sanitize_checkbox',
    ));

    $wp_customize->add_control('hero_center_content', array(
        'label'    => '¿Centrar contenido del Hero?',
        'section'  => 'oficina_hero_section',
        'type'     => 'checkbox',
    ));
}
add_action( 'customize_register', 'oficina_customize_register' );

function oficina_sanitize_checkbox( $checked ) {
    return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

// =============================================
// AJAX Handler for Library Filtering
// =============================================
function filter_library_ajax_handler() {
    check_ajax_referer('filter_library_nonce', 'nonce');

    // Get filter parameters
    $cat_filter = isset($_POST['categoria']) ? array_map('sanitize_text_field', (array)$_POST['categoria']) : [];
    $year_from = isset($_POST['anio_desde']) ? intval($_POST['anio_desde']) : null;
    $year_to = isset($_POST['anio_hasta']) ? intval($_POST['anio_hasta']) : null;
    $search_term = isset($_POST['busqueda']) ? sanitize_text_field($_POST['busqueda']) : '';
    $type_filter = isset($_POST['tipo']) ? array_map('sanitize_text_field', (array)$_POST['tipo']) : '';
    $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;

    require_once get_template_directory() . '/template-parts/library/library-criteria.php';

    // Build criteria
    $builder = new CriteriaBuilder();

    if (!empty($cat_filter)) {
        $builder->addCriteria(new CategoryCriteria($cat_filter));
    }

    if ($year_from || $year_to) {
        $builder->addCriteria(new DateRangeCriteria($year_from, $year_to));
    }

    if (!empty($search_term)) {
        $builder->addCriteria(new TitleSearchCriteria($search_term));
    }

    if (!empty($type_filter)) {
        $builder->addCriteria(new TypeCriteria($type_filter));
    }

    $query_args = $builder->build();
    $query_args['paged'] = $paged;

    $docs_query = new WP_Query($query_args);

    // Generate HTML for grid
    ob_start();
    $docs_js = [];

    if ($docs_query->have_posts()) {
        while ($docs_query->have_posts()) {
            $docs_query->the_post();
            $doc_data = defensoria_get_document_data(get_the_ID());

            get_template_part('template-parts/library/library-card', null, ['doc_data' => $doc_data]);

            // 3. Guardar para JS
            $docs_js[] = [
                'id'       => $doc_data['id'],
                'title'    => $doc_data['title'],
                'year'     => $doc_data['year'],
                'category' => $doc_data['category'],
                'versions' => $doc_data['versions']
            ];
        }
        wp_reset_postdata();
    } else {
        ?>
        <div class="text-center py-20">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <p class="text-gray-500 text-lg">No hay documentos disponibles.</p>
        </div>
        <?php
    }
    $grid_html = ob_get_clean();

    // Generate pagination HTML
    $pagination_html = '<div id="biblioteca-pagination-container" class="mt-12">';
    $pagination_html .= defensoria_render_pagination($docs_query->max_num_pages, $paged);
    $pagination_html .= '</div>';

    wp_send_json_success([
        'html' => $grid_html,
        'pagination' => $pagination_html,
        'docs' => $docs_js,
    ]);
}
add_action('wp_ajax_filter_library', 'filter_library_ajax_handler');
add_action('wp_ajax_nopriv_filter_library', 'filter_library_ajax_handler');
