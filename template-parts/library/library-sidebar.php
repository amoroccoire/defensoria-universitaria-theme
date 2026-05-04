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