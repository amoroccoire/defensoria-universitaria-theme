<?php
/**
 * Library Queries
 * Handles all database queries for the library section
 */

global $wpdb;

$cat_filter  = isset($_GET['categoria']) ? sanitize_text_field($_GET['categoria']) : '';
$year_filter = isset($_GET['anio'])      ? intval($_GET['anio'])                   : 0;
$paged       = get_query_var('paged') ? get_query_var('paged') : 1;

$tax_query  = [];
$meta_query = [];

if ($cat_filter) {
    $tax_query = [[
        'taxonomy' => 'categoria_documento',
        'field'    => 'slug',
        'terms'    => $cat_filter,
    ]];
}

if ($year_filter) {
    $meta_query = [[
        'key'     => 'documento_anio',
        'value'   => $year_filter,
        'compare' => '=',
        'type'    => 'NUMERIC',
    ]];
}

$docs_query = new WP_Query([
    'post_type'      => 'documento',
    'posts_per_page' => 9,
    'paged'          => $paged,
    'post_status'    => 'publish',
    'orderby'        => 'meta_value_num',
    'meta_key'       => 'documento_anio',
    'order'          => 'DESC',
    'tax_query'      => $tax_query,
    'meta_query'     => $meta_query,
]);

$categorias = get_terms([
    'taxonomy'   => 'categoria_documento',
    'hide_empty' => true,
]);

// Obtener años disponibles desde el campo SCF documento_anio
$years_raw = $wpdb->get_col("
    SELECT DISTINCT meta_value
    FROM {$wpdb->postmeta}
    INNER JOIN {$wpdb->posts} ON {$wpdb->posts}.ID = {$wpdb->postmeta}.post_id
    WHERE {$wpdb->postmeta}.meta_key = 'documento_anio'
    AND {$wpdb->posts}.post_type = 'documento'
    AND {$wpdb->posts}.post_status = 'publish'
    AND meta_value != ''
    ORDER BY meta_value DESC
");
$years_available = array_filter($years_raw);

// Colores por tipo de badge de categoría
$cat_colores = [
    'Boletines'      => 'bg-blue-100 text-blue-700 border-blue-200',
    'Informes'       => 'bg-purple-100 text-purple-700 border-purple-200',
    'Reglamentos'    => 'bg-amber-100 text-amber-700 border-amber-200',
    'Investigaciones'=> 'bg-emerald-100 text-emerald-700 border-emerald-200',
];

// Construir array de documentos para el JS
$docs_js = [];
if ($docs_query->have_posts()) {
    $temp_query = clone $docs_query;
    $temp_query->rewind_posts();
    while ($temp_query->have_posts()) {
        $temp_query->the_post();
        $id         = get_the_ID();
        $versiones  = get_field('documento_versiones', $id) ?: [];
        $imagen     = get_the_post_thumbnail_url($id, 'medium') ?: '';
        $categorias_post = get_the_terms($id, 'categoria_documento');
        $cat_name   = (!empty($categorias_post) && !is_wp_error($categorias_post)) ? $categorias_post[0]->name : '';

        $versions_data = [];
        foreach ($versiones as $v) {
            $archivo = $v['version_archivo'];
            $versions_data[] = [
                'numero'  => $v['version_numero'] ?: '',
                'fecha'   => $v['version_fecha']  ?: '',
                'notas'   => $v['version_notas']  ?: '',
                'url'     => is_array($archivo) ? $archivo['url'] : ($archivo ?: ''),
                'nombre'  => is_array($archivo) ? $archivo['filename'] : '',
                'size'    => is_array($archivo) ? size_format($archivo['filesize']) : '',
            ];
        }

        $docs_js[] = [
            'id'       => $id,
            'title'    => get_the_title(),
            'category' => $cat_name,
            'year'     => get_field('documento_anio', $id) ?: get_the_date('Y'),
            'image'    => $imagen,
            'versions' => $versions_data,
            'autor'    => get_field('documento_autor', $id) ?: '',
            'tipo'     => strtoupper(get_field('documento_tipo', $id) ?: '')
        ];
    }
    wp_reset_postdata();
    $docs_query->rewind_posts();
}
?>