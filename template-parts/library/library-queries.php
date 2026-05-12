<?php
/**
 * Library Queries
 * Handles all database queries for the library section
 */

require_once get_template_directory() . '/template-parts/library/library-criteria.php';

global $wpdb;

// Get filter parameters
$cat_filter = isset($_GET['categoria']) ? array_map('sanitize_text_field', (array)$_GET['categoria']) : [];
$year_from = isset($_GET['anio_desde']) ? intval($_GET['anio_desde']) : null;
$year_to = isset($_GET['anio_hasta']) ? intval($_GET['anio_hasta']) : null;
$search_term = isset($_GET['busqueda']) ? sanitize_text_field($_GET['busqueda']) : '';
$type_filter = isset($_GET['tipo']) ? sanitize_text_field($_GET['tipo']) : '';
$paged = get_query_var('paged') ? get_query_var('paged') : 1;

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

// Get available categories
$categorias = get_terms([
    'taxonomy'   => 'categoria_documento',
    'hide_empty' => true,
]);

// Get available years from post_date
$years_raw = $wpdb->get_col("
    SELECT DISTINCT YEAR(post_date)
    FROM {$wpdb->posts}
    WHERE post_type = 'documento'
    AND post_status = 'publish'
    ORDER BY YEAR(post_date) DESC
");
$years_available = array_filter($years_raw);

// Get available types
$types_raw = $wpdb->get_col("
    SELECT DISTINCT meta_value
    FROM {$wpdb->postmeta}
    INNER JOIN {$wpdb->posts} ON {$wpdb->posts}.ID = {$wpdb->postmeta}.post_id
    WHERE {$wpdb->postmeta}.meta_key = 'documento_tipo'
    AND {$wpdb->posts}.post_type = 'documento'
    AND {$wpdb->posts}.post_status = 'publish'
    AND meta_value != ''
    ORDER BY meta_value ASC
");
$types_available = array_filter($types_raw);

// Colors for category badges
$cat_colores = [
    'Boletines'      => 'bg-blue-100 text-blue-700 border-blue-200',
    'Informes'       => 'bg-purple-100 text-purple-700 border-purple-200',
    'Reglamentos'    => 'bg-amber-100 text-amber-700 border-amber-200',
    'Investigaciones'=> 'bg-emerald-100 text-emerald-700 border-emerald-200',
];
?>