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


// =============================================
// 5. Walker para el nav desktop (header)
//    Genera: <a class="nav-link ...">Texto<span/></a>
//    sin los <li> y <ul> de WordPress
// =============================================
class Defensoria_Desktop_Walker extends Walker_Nav_Menu {

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
class Defensoria_Mobile_Walker extends Walker_Nav_Menu {

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
class Defensoria_Footer_Walker extends Walker_Nav_Menu {

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
