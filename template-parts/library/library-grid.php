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