<?php
/**
 * Template Part: Biblioteca Virtual
 * CPT: documento | Taxonomía: categoria_documento
 * SCF Repeater: documento_versiones (version_numero, version_fecha, version_notas, version_archivo)
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
        ];
    }
    wp_reset_postdata();
    $docs_query->rewind_posts();
}
?>

<section id="biblioteca" class="py-20 bg-gray-50">
    <div class="container mx-auto px-4 max-w-7xl">

        <h2 class="text-3xl md:text-4xl font-bold text-center text-gray-900 mb-4">
            Biblioteca Virtual
        </h2>
        <p class="text-center text-gray-500 mb-12">
            Documentos, reglamentos e informes de la Defensoría Universitaria
        </p>

        <!-- Buscador -->
        <div class="max-w-2xl mx-auto mb-10 relative">
            <input
                type="text"
                id="biblioteca-search"
                placeholder="Buscar documentos por título..."
                class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none shadow-sm transition-shadow"
            />
            <svg class="w-6 h-6 text-gray-400 absolute left-4 top-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">

            <!-- Sidebar categorías -->
            <aside class="w-full lg:w-64 flex-shrink-0">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 sticky top-24">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-gray-900">Categorías</h3>
                        <?php if ($cat_filter) : ?>
                        <a href="<?php echo esc_url(get_permalink()); ?>" class="text-xs text-blue-600 hover:underline">Limpiar</a>
                        <?php endif; ?>
                    </div>
                    <?php if (!empty($categorias) && !is_wp_error($categorias)) : ?>
                    <ul class="space-y-1">
                        <li>
                            <a href="<?php echo esc_url(remove_query_arg('categoria', get_permalink())); ?>"
                                class="flex items-center justify-between text-sm py-1.5 px-2 rounded-lg transition-colors <?php echo !$cat_filter ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-600 hover:bg-gray-50'; ?>">
                                <span>Todas</span>
                            </a>
                        </li>
                        <?php foreach ($categorias as $cat) : ?>
                        <li>
                            <a href="<?php echo esc_url(add_query_arg('categoria', $cat->slug, remove_query_arg('anio', get_permalink()))); ?>"
                                class="flex items-center justify-between text-sm py-1.5 px-2 rounded-lg transition-colors <?php echo $cat_filter === $cat->slug ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-600 hover:bg-gray-50'; ?>">
                                <span><?php echo esc_html($cat->name); ?></span>
                                <span class="text-xs text-gray-400"><?php echo $cat->count; ?></span>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php else : ?>
                    <p class="text-sm text-gray-500">No hay categorías aún.</p>
                    <?php endif; ?>

                    <!-- Filtro por año -->
                    <?php if (!empty($years_available)) : ?>
                    <div class="mt-6 pt-6 border-t border-gray-100">
                        <div class="flex justify-between items-center mb-3">
                            <h4 class="font-bold text-gray-900 text-sm">Año</h4>
                            <?php if ($year_filter) : ?>
                            <a href="<?php echo esc_url(remove_query_arg('anio', get_permalink())); ?>" class="text-xs text-blue-600 hover:underline">Limpiar</a>
                            <?php endif; ?>
                        </div>
                        <ul class="space-y-1">
                            <?php foreach ($years_available as $year) : ?>
                            <li>
                                <a href="<?php echo esc_url(add_query_arg('anio', $year, remove_query_arg('paged', get_permalink()))); ?>"
                                    class="flex items-center justify-between text-sm py-1.5 px-2 rounded-lg transition-colors <?php echo $year_filter === intval($year) ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-600 hover:bg-gray-50'; ?>">
                                    <span><?php echo esc_html($year); ?></span>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                </div>
            </aside>

            <!-- Grid de documentos -->
            <div class="flex-grow">
                <div id="biblioteca-grid" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-10">
                    <?php if ($docs_query->have_posts()) : ?>
                    <?php while ($docs_query->have_posts()) : $docs_query->the_post(); ?>
                    <?php
                        $id         = get_the_ID();
                        $versiones  = get_field('documento_versiones', $id) ?: [];
                        $imagen     = get_the_post_thumbnail_url($id, 'medium');
                        $cats_post  = get_the_terms($id, 'categoria_documento');
                        $cat_name   = (!empty($cats_post) && !is_wp_error($cats_post)) ? $cats_post[0]->name : '';
                        $cat_clase  = $cat_colores[$cat_name] ?? 'bg-gray-100 text-gray-700 border-gray-200';
                        $total_vers = count($versiones);
                        $ver_actual = $total_vers > 0 ? $versiones[$total_vers - 1] : null;
                        $ver_numero = $ver_actual ? ($ver_actual['version_numero'] ?: 'v1.0.0') : '';
                        $tiene_hist = $total_vers > 1;
                        $anio       = get_field('documento_anio', $id) ?: get_the_date('Y');
                    ?>
                    <div
                        class="bg-white p-5 rounded-2xl shadow-sm border <?php echo $tiene_hist ? 'border-blue-200 ring-1 ring-blue-100/50' : 'border-gray-100'; ?> hover:shadow-md transition-all group flex flex-col cursor-pointer"
                        onclick="openDocPanel(<?php echo $id; ?>)"
                    >
                        <?php if ($imagen) : ?>
                        <div class="h-36 bg-gray-100 rounded-lg mb-4 overflow-hidden">
                            <img src="<?php echo esc_url($imagen); ?>" alt="<?php echo esc_attr(get_the_title()); ?>"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                        </div>
                        <?php endif; ?>

                        <div class="flex justify-between items-start mb-3">
                            <?php if ($cat_name) : ?>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold border <?php echo esc_attr($cat_clase); ?>">
                                <?php echo esc_html($cat_name); ?>
                            </span>
                            <?php else : ?>
                            <span></span>
                            <?php endif; ?>
                            <?php if ($ver_numero) : ?>
                            <span class="text-xs font-bold px-2 py-1 rounded-md <?php echo $tiene_hist ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700'; ?>">
                                <?php echo esc_html($ver_numero); ?>
                            </span>
                            <?php endif; ?>
                        </div>

                        <h4 class="font-bold text-gray-900 mb-2 leading-snug group-hover:text-blue-600 transition-colors line-clamp-2">
                            <?php the_title(); ?>
                        </h4>

                        <p class="text-sm text-gray-500 mt-auto flex items-center justify-between border-t border-gray-50 pt-3">
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <?php echo esc_html($anio); ?>
                            </span>
                            <span class="font-medium text-xs bg-gray-100 px-2 py-1 rounded-full text-gray-600">
                                <?php echo $total_vers; ?> versión<?php echo $total_vers !== 1 ? 'es' : ''; ?>
                            </span>
                        </p>
                    </div>
                    <?php endwhile; wp_reset_postdata(); ?>
                    <?php else : ?>
                    <div class="col-span-3 text-center py-20">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="text-gray-500 text-lg">No hay documentos disponibles aún.</p>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Paginación -->
                <?php
                $total_pages = $docs_query->max_num_pages;
                if ($total_pages > 1) :
                ?>
                <div class="flex justify-center items-center space-x-2">
                    <?php if ($paged > 1) : ?>
                    <a href="<?php echo get_pagenum_link($paged - 1); ?>" class="inline-flex items-center justify-center w-10 h-10 rounded-lg border border-gray-300 text-gray-500 hover:bg-white hover:text-gray-700 transition-colors shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </a>
                    <?php endif; ?>
                    <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                        <?php if ($i === $paged) : ?>
                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-blue-600 text-white font-medium shadow-sm"><?php echo $i; ?></span>
                        <?php elseif ($i === 1 || $i === $total_pages || abs($i - $paged) <= 1) : ?>
                        <a href="<?php echo get_pagenum_link($i); ?>" class="inline-flex items-center justify-center w-10 h-10 rounded-lg border border-gray-300 bg-white text-gray-700 hover:text-blue-600 transition-colors shadow-sm font-medium"><?php echo $i; ?></a>
                        <?php elseif (abs($i - $paged) === 2) : ?>
                        <span class="inline-flex items-center justify-center w-10 h-10 text-gray-500">...</span>
                        <?php endif; ?>
                    <?php endfor; ?>
                    <?php if ($paged < $total_pages) : ?>
                    <a href="<?php echo get_pagenum_link($paged + 1); ?>" class="inline-flex items-center justify-center w-10 h-10 rounded-lg border border-gray-300 text-gray-500 hover:bg-white hover:text-gray-700 transition-colors shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- ===================== -->
<!-- SLIDE PANEL           -->
<!-- ===================== -->
<div id="doc-slide-panel" class="fixed inset-y-0 right-0 w-full md:w-[450px] bg-white shadow-2xl transform translate-x-full transition-transform duration-300 z-[60] border-l border-gray-200 flex flex-col">

    <!-- Header del panel -->
    <div class="p-6 border-b border-gray-100 flex justify-between items-start bg-gray-50/50 flex-shrink-0">
        <div class="pr-4">
            <span id="panel-category" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold border mb-3 bg-gray-100 text-gray-700 border-gray-200"></span>
            <h2 id="panel-title" class="text-xl font-bold text-gray-900 leading-tight"></h2>
            <p id="panel-year" class="text-sm text-gray-500 mt-2 flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span></span>
            </p>
        </div>
        <button id="panel-close" class="p-2 text-gray-400 hover:text-gray-900 hover:bg-gray-200 rounded-full transition-colors flex-shrink-0">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <!-- Contenido del panel -->
    <div class="flex-grow overflow-y-auto p-6">

        <!-- Versión actual -->
        <div class="mb-8">
            <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-green-500"></span>
                Versión Actual
            </h3>
            <div id="panel-current-version" class="bg-gray-50 border border-gray-200 rounded-xl p-5 shadow-sm">
                <div class="flex justify-between items-start mb-3">
                    <span id="panel-ver-numero" class="bg-gray-900 text-white px-2.5 py-1 rounded text-sm font-bold"></span>
                    <span class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded-full border border-green-200">Vigente</span>
                </div>
                <p id="panel-ver-fecha" class="text-xs text-gray-500 mb-2"></p>
                <p id="panel-ver-notas" class="text-sm text-gray-700"></p>
            </div>
            <div class="mt-4">
                <a id="panel-download-btn" href="#" download target="_blank"
                    class="flex items-center justify-center gap-2 w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Descargar versión actual
                </a>
            </div>
        </div>

        <!-- Historial de versiones -->
        <div>
            <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-gray-300"></span>
                Versiones Anteriores
            </h3>
            <div id="panel-history" class="space-y-4">
                <p class="text-sm text-gray-400 italic">No hay versiones anteriores.</p>
            </div>
        </div>

    </div>
</div>

<!-- Backdrop -->
<div id="doc-backdrop" class="fixed inset-0 bg-black/20 backdrop-blur-sm z-50 hidden opacity-0 transition-opacity"></div>

<!-- Datos para el módulo biblioteca.js -->
<script>
window.BIBLIOTECA_DOCS = <?php echo json_encode($docs_js, JSON_UNESCAPED_UNICODE); ?>;
window.CAT_COLORES = {
    'Boletines':       'bg-blue-100 text-blue-700 border-blue-200',
    'Informes':        'bg-purple-100 text-purple-700 border-purple-200',
    'Reglamentos':     'bg-amber-100 text-amber-700 border-amber-200',
    'Investigaciones': 'bg-emerald-100 text-emerald-700 border-emerald-200',
};
</script>