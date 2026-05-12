<?php
/**
 * functions.php — Defensoría Universitaria UNSA
 */

// =============================================
// 1. Assets: encolar CSS y JS compilados
// =============================================
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
            'name'          => 'Tarjetas Hero',
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
            '<a href="%s" target="%s"%s class="nav-link px-4 py-2 text-white font-medium hover:text-gray-400 rounded-lg transition-colors relative group%s">%s<span class="absolute bottom-0 left-0 w-full h-0.5 bg-gray-400 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span></a>',
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
            '<a href="%s" target="%s" class="block px-4 py-2 text-gray-700 font-medium hover:text-blue-600 hover:bg-gray-50 rounded-lg">%s</a>',
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
            '<li><a href="%s" target="%s" class="hover:text-blue-400 transition-colors flex items-center group"><svg class="w-3 h-3 mr-2 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>%s</a></li>',
            esc_url( $url ),
            esc_attr( $target ),
            esc_html( $title )
        );
    }

    public function end_el( &$output, $item, $depth = 0, $args = null ) {}
}

function oficina_customize_register( $wp_customize ) {

    // --- IDENTIDAD DEL HEADER ---
    $wp_customize->add_section( 'oficina_header_section' , array(
        'title'      => 'Header: Logos y textos',
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

    // Subtítulo del Hero
    $wp_customize->add_setting( 'hero_subtitle', array('default' => 'Defender tus derechos nos fortalece') );
    $wp_customize->add_control( 'hero_subtitle', array(
        'label'    => 'Subtítulo del Hero',
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
    $type_filter = isset($_POST['tipo']) ? sanitize_text_field($_POST['tipo']) : '';
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
    if ($docs_query->have_posts()) {
        while ($docs_query->have_posts()) {
            $docs_query->the_post();
            $id = get_the_ID();
            $imagen = get_the_post_thumbnail_url($id, 'medium');
            $cats_post = get_the_terms($id, 'categoria_documento');
            $cat_name = (!empty($cats_post) && !is_wp_error($cats_post)) ? $cats_post[0]->name : '';

            $archivo_obj = get_field('documento_archivo_actual', $id);
            $url_actual_raw = is_array($archivo_obj) ? ($archivo_obj['url'] ?? '') : ($archivo_obj ?: '');
            $url_actual = wp_http_validate_url($url_actual_raw) ? $url_actual_raw : '#';

            $version_numero = get_field('documento_numero_version', $id) ?: 'v1.0.0';
            $autor = get_field('documento_autor', $id) ?: '';
            $tipo = strtoupper(get_field('documento_tipo', $id) ?: '');
            $anio = get_the_date('Y', $id);

            $args_historial = [
                'post_type' => 'documento',
                'posts_per_page' => -1,
                'meta_query' => [
                    [
                        'key' => 'documento_padre',
                        'value' => $id,
                    ]
                ]
            ];
            $versiones_vinculadas = get_posts($args_historial);
            $total_vers = count($versiones_vinculadas) + 1;
            $tiene_hist = $total_vers > 1;
            ?>
            <div class="flex items-start gap-10 py-5 group hover:bg-gray-50/60 rounded-xl px-3 -mx-3 transition-colors relative">
                <!-- Miniatura izquierda -->
                <a href="<?php echo esc_url($url_actual); ?>" target="_blank" class="hidden sm:block flex-shrink-0 w-20 h-20 rounded-xs overflow-hidden bg-gray-100 border border-gray-200 hover:opacity-90 transition-opacity flex items-center justify-center">
                    <?php if ($imagen) : ?>
                    <img
                        src="<?php echo esc_url($imagen); ?>"
                        alt="<?php echo esc_attr(get_the_title()); ?>"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                    />
                    <?php else : ?>
                    <div class="w-full h-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <?php endif; ?>
                </a>

                <!-- Contenido derecha -->
                <div class="flex-grow min-w-0">

                    <!-- Breadcrumb -->
                    <div class="flex items-center gap-1.5 text-xs text-gray-500 mb-1 flex-wrap">
                        <span class="text-green-700 font-medium">biblioteca</span>
                        <?php if ($cat_name) : ?>
                        <span>›</span>
                        <span><?php echo esc_html($cat_name); ?></span>
                        <?php endif; ?>
                        <?php if ($anio) : ?>
                        <span>›</span>
                        <span><?php echo esc_html($anio); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Título estilo resultado de búsqueda -->
                    <a href="<?php echo esc_url($url_actual); ?>" target="_blank" rel="noopener noreferrer" class="block w-fit">
                        <h4 class="js-search-title text-lg font-medium text-blue-700 hover:underline leading-snug mb-1 line-clamp-3">
                            <?php the_title(); ?>
                        </h4>
                    </a>

                    <!-- Meta info -->
                    <div class="inline-flex items-center gap-2 flex-wrap mb-1.5 cursor-pointer hover:scale-[1.02] transition-transform origin-left" 
                    onclick="openDocPanel(<?php echo intval($id); ?>)"
                    title="Ver historial de versiones"
                    role="button"
                    tabindex="0"
                    onkeydown="if(event.key==='Enter'||event.key===' ')openDocPanel(<?php echo intval($id); ?>)">
                        <?php if ($tipo) : ?>
                        <span class="text-xs font-bold px-1.5 py-0.5 rounded-xs bg-gray-100 text-gray-600 border border-gray-200">
                            <?php echo esc_html($tipo); ?>
                        </span>
                        <?php endif; ?>
                        <?php if ($version_numero) : ?>
                        <span class="text-xs font-semibold px-1.5 py-0.5 rounded-xs <?php echo $tiene_hist ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-600'; ?>">
                            <?php echo esc_html($version_numero); ?>
                        </span>
                        <?php endif; ?>
                        <?php if ($tiene_hist) : ?>
                        <span class="text-xs text-blue-500">
                            <?php echo $total_vers; ?> Documentos vinculados
                        </span>
                        <?php endif; ?>
                    </div>

                    <!-- Descripción -->
                    <p class="text-sm text-gray-600 line-clamp-2 leading-relaxed">
                        <?php if ($autor) echo esc_html($autor) . ' · '; ?>
                        <?php echo esc_html(wp_trim_words(get_the_excerpt() ?: get_post_field('post_content', $id), 18, '...')); ?>
                    </p>
                </div>
            </div>
            <?php
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
    ob_start();
    $total_pages = $docs_query->max_num_pages;
    if ($total_pages > 1) :
    ?>
    <div class="flex justify-center items-center space-x-2">
        <?php if ($paged > 1) : ?>
        <a href="#" data-page="<?php echo $paged - 1; ?>" class="pagination-link inline-flex items-center justify-center w-5 h-5 rounded-xs text-gray-500 hover:bg-white hover:text-gray-700 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
            <?php if ($i === $paged) : ?>
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-xs bg-blue-600 text-white font-medium shadow-sm">
                <?php echo intval($i); ?>
            </span>
            <?php elseif ($i === 1 || $i === $total_pages || abs($i - $paged) <= 1) : ?>
            <a href="#" data-page="<?php echo $i; ?>" class="pagination-link inline-flex items-center justify-center w-10 h-10 rounded-xs border border-gray-300 bg-white text-gray-700 hover:text-blue-600 transition-colors shadow-sm font-medium">
                <?php echo intval($i); ?>
            </a>
            <?php elseif (abs($i - $paged) === 2) : ?>
            <span class="inline-flex items-center justify-center w-10 h-10 text-gray-500">...</span>
            <?php endif; ?>
        <?php endfor; ?>
        <?php if ($paged < $total_pages) : ?>
        <a href="#" data-page="<?php echo $paged + 1; ?>" class="pagination-link inline-flex items-center justify-center w-5 h-5 rounded-xs text-gray-500 hover:bg-white hover:text-gray-700 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
        <?php endif; ?>
    </div>
    <?php endif;
    $pagination_html = ob_get_clean();

    // Build docs array for JS
    if ($docs_query->have_posts()) {
        $temp_query = clone $docs_query;
        $temp_query->rewind_posts();
        
        while ($temp_query->have_posts()) {
            $temp_query->the_post();
            $id = get_the_ID();

            // 1. Obtener datos de la versión actual
            $archivo_obj    = get_field('documento_archivo_actual', $id);
            $url_actual_raw = is_array($archivo_obj) ? ($archivo_obj['url'] ?? '') : ($archivo_obj ?: '');
            $url_actual     = wp_http_validate_url($url_actual_raw) ? $url_actual_raw : '';

            $version_actual = [
                'numero' => sanitize_text_field(get_field('documento_numero_version', $id) ?: 'v1.0.0'),
                'fecha'  => sanitize_text_field(get_the_date('d/m/Y', $id)),
                'notas'  => wp_kses_post(get_field('documento_notas', $id) ?: ''),
                'url'    => $url_actual,
            ];

            // 2. Buscar versiones vinculadas (Opción B)
            $versiones_vinculadas = get_posts([
                'post_type'      => 'documento',
                'posts_per_page' => -1,
                'orderby'        => 'date',
                'order'          => 'ASC',
                'meta_query'     => [[
                    'key'   => 'documento_padre',
                    'value' => $id,
                ]],
            ]);

            $history_js = [];
            foreach ($versiones_vinculadas as $v) {
                $v_archivo_obj = get_field('documento_archivo_actual', $v->ID);
                $v_url_raw     = is_array($v_archivo_obj) ? ($v_archivo_obj['url'] ?? '') : ($v_archivo_obj ?: '');
                $v_url         = wp_http_validate_url($v_url_raw) ? $v_url_raw : '';

                $history_js[] = [
                    'id'     => $v->ID,
                    'title'  => sanitize_text_field(get_the_title($v->ID)),
                    'numero' => sanitize_text_field(get_field('documento_numero_version', $v->ID) ?: 'v1.0.0'),
                    'fecha'  => sanitize_text_field(get_the_date('d/m/Y', $v->ID)),
                    'notas'  => wp_kses_post(get_field('documento_notas', $v->ID) ?: ''),
                    'url'    => $v_url,
                ];
            }

            // 3. Unir historial con la versión actual
            $todas_las_versiones = array_merge($history_js, [$version_actual]);

            // 4. Obtener categoría
            $cats_post = get_the_terms($id, 'categoria_documento');
            $cat_name  = (!empty($cats_post) && !is_wp_error($cats_post)) ? sanitize_text_field($cats_post[0]->name) : '';

            // 5. Ensamblar array final para JS
            $docs_js[] = [
                'id'       => $id,
                'title'    => sanitize_text_field(get_the_title($id)),
                'year'     => sanitize_text_field(get_the_date('Y', $id)),
                'category' => $cat_name,
                'versions' => $todas_las_versiones,
            ];
        }
        wp_reset_postdata();
        $docs_query->rewind_posts();
    }

    wp_send_json_success([
        'html' => $grid_html,
        'pagination' => $pagination_html,
        'docs' => $docs_js,
    ]);
}
add_action('wp_ajax_filter_library', 'filter_library_ajax_handler');
add_action('wp_ajax_nopriv_filter_library', 'filter_library_ajax_handler');
