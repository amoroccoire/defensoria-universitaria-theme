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
            'autor'    => get_field('documento_autor', $id) ?: '',
            'tipo'     => strtoupper(get_field('documento_tipo', $id) ?: '')
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
        <div class="flex items-center gap-2 max-w-2xl mx-auto mb-10">
            <!-- Botón Filtros Mobile -->
            <button id="btn-mobile-filtros" class="lg:hidden flex items-center gap-2 bg-transparent px-1 py-1 rounded-xs text-gray-700 font-medium hover:bg-gray-50 transition-colors whitespace-nowrap">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
            </button>
            <div class="relative flex-grow">
                <input
                    type="text"
                    id="biblioteca-search"
                    placeholder="Buscar documentos por título..."
                    class="w-full pl-12 pr-4 py-3 rounded-xs border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none shadow-sm transition-shadow"
                />
                <svg class="w-6 h-6 text-gray-400 absolute left-4 top-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8 items-start">

            <!-- Sidebar categorías -->
            <aside id="sidebar-filtros" class="fixed inset-y-0 left-0 z-[70] w-72 bg-white shadow-2xl transform -translate-x-full transition-transform duration-300 lg:relative lg:translate-x-0 lg:w-64 lg:shadow-none lg:bg-transparent lg:z-0 flex-shrink-0 overflow-y-auto h-full lg:h-auto overflow-x-hidden">
                <div class="bg-white px-2 py-4 rounded-xs lg:shadow-sm lg:border lg:border-gray-200 lg:sticky lg:top-24 p-4 lg:p-0 min-h-full lg:min-h-0">
                    
                    <!-- Header Mobile Sidebar -->
                    <div class="flex items-center justify-between mb-6 lg:hidden px-3 pt-2">
                        <h3 class="font-bold text-gray-900 text-xl">Filtros</h3>
                        <button id="btn-close-filtros" class="p-2 text-gray-400 hover:text-gray-900 bg-gray-100 hover:bg-gray-200 rounded-full transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="flex justify-between items-center mb-4 py-4">
                        <h3 class="font-bold px-3 text-gray-900">Categorías</h3>
                        <?php if ($cat_filter) : ?>
                        <a href="<?php echo esc_url(get_permalink()); ?>" class="text-xs mr-3 text-blue-600 hover:underline">Limpiar</a>
                        <?php endif; ?>
                    </div>
                    <?php if (!empty($categorias) && !is_wp_error($categorias)) : ?>
                    <ul class="space-y-1">
                        <li>
                            <a href="<?php echo esc_url(remove_query_arg('categoria', get_permalink())); ?>"
                                class="flex items-center justify-between text-sm py-1.5 px-2 rounded-xs transition-colors <?php echo !$cat_filter ? 'bg-[#141F40] text-white font-semibold' : 'text-gray-600 hover:bg-gray-50'; ?>">
                                <span>Todas</span>
                            </a>
                        </li>
                        <?php foreach ($categorias as $cat) : ?>
                        <li>
                            <a href="<?php echo esc_url(add_query_arg('categoria', $cat->slug, remove_query_arg('anio', get_permalink()))); ?>"
                                class="flex items-center justify-between text-sm py-1.5 px-2 rounded-xs transition-colors <?php echo $cat_filter === $cat->slug ? 'bg-[#141F40] text-white font-semibold' : 'text-gray-600 hover:bg-gray-50'; ?>">
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
                            <h4 class="font-bold text-gray-900 text-sm px-3">Año</h4>
                            <?php if ($year_filter) : ?>
                            <a href="<?php echo esc_url(remove_query_arg('anio', get_permalink())); ?>" class="text-xs text-blue-600 mr-3 hover:underline">Limpiar</a>
                            <?php endif; ?>
                        </div>
                        <ul class="space-y-1">
                            <?php foreach ($years_available as $year) : ?>
                            <li>
                                <a href="<?php echo esc_url(add_query_arg('anio', $year, remove_query_arg('paged', get_permalink()))); ?>"
                                    class="flex items-center justify-between text-sm py-1.5 px-2 rounded-xs transition-colors <?php echo $year_filter === intval($year) ? 'bg-[#141F40] text-white font-semibold' : 'text-gray-600 hover:bg-gray-50'; ?>">
                                    <span><?php echo esc_html($year); ?></span>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                </div>
            </aside>

            <!-- Lista de documentos estilo Google Search -->
            <div class="flex-grow">
                <div id="biblioteca-grid" class="flex flex-col divide-y divide-gray-100 mb-10">
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
                        $archivo_actual = $ver_actual ? $ver_actual['version_archivo'] : null;
                        $url_actual = is_array($archivo_actual) ? $archivo_actual['url'] : ($archivo_actual ?: '#');
                        $tiene_hist = $total_vers > 1;
                        $anio       = get_field('documento_anio', $id) ?: get_the_date('Y');
                        $autor      = get_field('documento_autor', $id) ?: '';
                        $tipo       = strtoupper(get_field('documento_tipo', $id) ?: '');
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

                            <!-- Breadcrumb estilo Google -->
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
                            <a href="<?php echo esc_url($url_actual); ?>" target="_blank" class="block w-fit">
                                <h4 class="js-search-title text-lg font-medium text-blue-700 hover:underline leading-snug mb-1 line-clamp-3">
                                    <?php the_title(); ?>
                                </h4>
                            </a>

                            <!-- Meta info -->
                            <div class="inline-flex items-center gap-2 flex-wrap mb-1.5 cursor-pointer hover:scale-[1.02] transition-transform origin-left" onclick="openDocPanel(<?php echo $id; ?>)" title="Ver historial de versiones">
                                <?php if ($tipo) : ?>
                                <span class="text-xs font-bold px-1.5 py-0.5 rounded-xs bg-gray-100 text-gray-600 border border-gray-200">
                                    <?php echo esc_html($tipo); ?>
                                </span>
                                <?php endif; ?>
                                <?php if ($ver_numero) : ?>
                                <span class="text-xs font-semibold px-1.5 py-0.5 rounded-xs <?php echo $tiene_hist ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-600'; ?>">
                                    <?php echo esc_html($ver_numero); ?>
                                </span>
                                <?php endif; ?>
                                <?php if ($tiene_hist) : ?>
                                <span class="text-xs text-blue-500">
                                    <?php echo $total_vers; ?> versiones disponibles
                                </span>
                                <?php endif; ?>
                            </div>

                            <!-- Descripción estilo snippet -->
                            <p class="text-sm text-gray-600 line-clamp-2 leading-relaxed">
                                <?php if ($autor) echo esc_html($autor) . ' · '; ?>
                                <?php echo esc_html(wp_trim_words(get_the_excerpt() ?: get_post_field('post_content', $id), 18, '...')); ?>
                            </p>

                        </div>
                    </div>
                    <?php endwhile; wp_reset_postdata(); ?>
                    <?php else : ?>
                    <div class="text-center py-20">
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
                    <a href="<?php echo get_pagenum_link($paged - 1); ?>" class="inline-flex items-center justify-center w-5 h-5 rounded-xs text-gray-500 hover:bg-white hover:text-gray-700 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </a>
                    <?php endif; ?>
                    <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                        <?php if ($i === $paged) : ?>
                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-xs bg-blue-600 text-white font-medium shadow-sm"><?php echo $i; ?></span>
                        <?php elseif ($i === 1 || $i === $total_pages || abs($i - $paged) <= 1) : ?>
                        <a href="<?php echo get_pagenum_link($i); ?>" class="inline-flex items-center justify-center w-10 h-10 rounded-xs border border-gray-300 bg-white text-gray-700 hover:text-blue-600 transition-colors shadow-sm font-medium"><?php echo $i; ?></a>
                        <?php elseif (abs($i - $paged) === 2) : ?>
                        <span class="inline-flex items-center justify-center w-10 h-10 text-gray-500">...</span>
                        <?php endif; ?>
                    <?php endfor; ?>
                    <?php if ($paged < $total_pages) : ?>
                    <a href="<?php echo get_pagenum_link($paged + 1); ?>" class="inline-flex items-center justify-center w-5 h-5 rounded-xs text-gray-500 hover:bg-white hover:text-gray-700 transition-colors">
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
<!-- MODAL PANEL           -->
<!-- ===================== -->
<div id="doc-slide-panel" class="fixed inset-0 z-[60] flex items-center justify-center p-4 sm:p-6 opacity-0 pointer-events-none transition-opacity duration-300">
    <div id="doc-modal-content" class="bg-white rounded-xs shadow-2xl w-full max-w-2xl max-h-[95vh] flex flex-col overflow-hidden transform scale-95 transition-transform duration-300">
        <!-- Header del panel -->
    <div class="p-6 border-b border-gray-100 flex justify-between items-start bg-gray-50/50 flex-shrink-0">
        <div class="pr-4">
            <span id="panel-category" class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold border mb-3 bg-gray-100 text-gray-700 border-gray-200"></span>
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
                <span class="w-2 h-2 rounded-full bg-[#141F40]"></span>
                Versión Actual
            </h3>
            <div id="panel-current-version" class="flex flex-row p-3">
                <div class="flex flex-col mr-3">
                    <div class="flex justify-center items-center mb-3">
                        <span id="panel-ver-numero" class="bg-[#141F40] text-white px-2.5 py-1 rounded-xs text-sm font-bold"></span>
                    </div>
                    <p id="panel-ver-fecha" class="text-xs text-gray-500 mb-2"></p>
                </div>
                <p id="panel-ver-notas" class="text-sm text-gray-700"></p>
            </div>
            <div class="mt-4">
                <a id="panel-download-btn" href="#" download target="_blank"
                    class="flex items-center justify-center gap-2 w-full bg-[#141F40] hover:bg-[#041d68] text-white px-4 py-2.5 rounded-xs text-sm font-medium transition-colors shadow-sm">
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
</div>

<!-- Backdrop Documentos -->
<div id="doc-backdrop" class="fixed inset-0 bg-black/20 backdrop-blur-sm z-50 hidden opacity-0 transition-opacity"></div>

<!-- Backdrop Sidebar Mobile -->
<div id="sidebar-backdrop" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[65] hidden opacity-0 transition-opacity lg:hidden"></div>

<!-- Datos para el módulo biblioteca.js -->
<script>
window.BIBLIOTECA_DOCS = <?php echo json_encode($docs_js, JSON_UNESCAPED_UNICODE); ?>;
window.BIBLIOTECA_AJAX_URL = "<?php echo admin_url('admin-ajax.php'); ?>";
window.BIBLIOTECA_NONCE = "<?php echo wp_create_nonce('load_more_docs_nonce'); ?>";
window.BIBLIOTECA_CURRENT_PAGE = <?php echo $paged; ?>;
window.BIBLIOTECA_MAX_PAGES = <?php echo $docs_query->max_num_pages; ?>;
window.BIBLIOTECA_CAT_FILTER = "<?php echo esc_js($cat_filter); ?>";
window.BIBLIOTECA_YEAR_FILTER = <?php echo intval($year_filter); ?>;
window.CAT_COLORES = {
    'Boletines':       'bg-blue-100 text-blue-700 border-blue-200',
    'Informes':        'bg-purple-100 text-purple-700 border-purple-200',
    'Reglamentos':     'bg-amber-100 text-amber-700 border-amber-200',
    'Investigaciones': 'bg-emerald-100 text-emerald-700 border-emerald-200',
};
</script>