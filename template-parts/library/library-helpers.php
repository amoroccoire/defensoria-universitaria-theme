<?php
/**
 * Funciones Helper para la Biblioteca
 * Centraliza la obtención de datos y el renderizado de componentes
 */

// 1. Centralizar la obtención de datos del documento (Para JS y para las tarjetas)
function defensoria_get_document_data( $post_id ) {
    // 1. Datos de la versión actual
    $archivo_obj    = get_field('documento_archivo_actual', $post_id);
    $url_actual_raw = is_array($archivo_obj) ? ($archivo_obj['url'] ?? '') : ($archivo_obj ?: '');
    $url_actual     = wp_http_validate_url($url_actual_raw) ? $url_actual_raw : '#';

    $version_numero = get_field('documento_numero_version', $post_id) ?: 'v1.0.0';
    $autor          = get_field('documento_autor', $post_id) ?: '';
    $tipo           = strtoupper(get_field('documento_tipo', $post_id) ?: '');
    $anio           = get_the_date('Y', $post_id);
    $notas          = wp_kses_post(get_field('documento_notas', $post_id) ?: '');
    $imagen         = get_the_post_thumbnail_url($post_id, 'medium');

    $cats_post = get_the_terms($post_id, 'categoria_documento');
    $cat_name  = (!empty($cats_post) && !is_wp_error($cats_post)) ? sanitize_text_field($cats_post[0]->name) : '';

    $version_actual = [
        'numero' => sanitize_text_field($version_numero),
        'fecha'  => sanitize_text_field(get_the_date('d/m/Y', $post_id)),
        'notas'  => $notas,
        'url'    => $url_actual,
    ];

    // 2. Buscar versiones vinculadas - historial
    $versiones_vinculadas = get_posts([
        'post_type'      => 'documento',
        'posts_per_page' => -1,
        'orderby'        => 'date',
        'order'          => 'ASC',
        'meta_query'     => [[
            'key'   => 'documento_padre',
            'value' => $post_id,
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

    $todas_las_versiones = array_merge($history_js, [$version_actual]);

    // Devolvemos TODO en un array estructurado
    return [
        'id'            => $post_id,
        'title'         => sanitize_text_field(get_the_title($post_id)),
        'excerpt'       => wp_trim_words(get_the_excerpt($post_id) ?: get_post_field('post_content', $post_id), 18, '...'),
        'year'          => sanitize_text_field($anio),
        'category'      => $cat_name,
        'image'         => $imagen,
        'autor'         => $autor,
        'tipo'          => $tipo,
        'url_actual'    => $url_actual,
        'version_num'   => $version_numero,
        'total_vers'    => count($versiones_vinculadas) + 1,
        'tiene_hist'    => count($versiones_vinculadas) > 0,
        'versions'      => $todas_las_versiones,
    ];
}

// 2. Centralizar la Paginación HTML
function defensoria_render_pagination( $total_pages, $paged ) {
    if ( $total_pages <= 1 ) return '';
    ob_start();
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
    <?php
    return ob_get_clean();
}