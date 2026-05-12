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
            <?php if (!empty($cat_filter)) : ?>
            <button id="clear-categories" class="text-xs mr-3 text-blue-600 hover:underline">Limpiar</button>
            <?php endif; ?>
        </div>
        <?php if (!empty($categorias) && !is_wp_error($categorias)) : ?>
        <ul class="space-y-2 px-3">
            <?php foreach ($categorias as $cat) : ?>
            <li>
                <label class="flex items-center text-sm py-1.5 px-2 rounded-xs transition-colors hover:bg-gray-50 cursor-pointer">
                    <input
                        type="checkbox"
                        name="categoria[]"
                        value="<?php echo esc_attr($cat->slug); ?>"
                        class="filter-checkbox mr-2 text-blue-600 focus:ring-blue-500"
                        <?php echo in_array($cat->slug, $cat_filter) ? 'checked' : ''; ?>
                    />
                    <span><?php echo esc_html($cat->name); ?></span>
                    <span class="text-xs text-gray-400 ml-auto"><?php echo $cat->count; ?></span>
                </label>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php else : ?>
        <p class="text-sm text-gray-500 px-3">No hay categorías aún.</p>
        <?php endif; ?>

        <!-- Filtro por tipo de documento -->
        <?php if (!empty($types_available)) : ?>
        <div class="mt-6 pt-6 border-t border-gray-100">
            <div class="flex justify-between items-center mb-3">
                <h4 class="font-bold text-gray-900 text-sm px-3">Tipo de Documento</h4>
                <?php if ($type_filter) : ?>
                <button id="clear-type" class="text-xs text-blue-600 mr-3 hover:underline">Limpiar</button>
                <?php endif; ?>
            </div>
            <ul class="space-y-1 px-3">
                <li>
                    <label class="flex items-center text-sm py-1.5 px-2 rounded-xs transition-colors hover:bg-gray-50 cursor-pointer">
                        <input
                            type="radio"
                            name="tipo"
                            value=""
                            class="filter-radio mr-2 text-blue-600 focus:ring-blue-500"
                            <?php echo empty($type_filter) ? 'checked' : ''; ?>
                        />
                        <span>Todos</span>
                    </label>
                </li>
                <?php foreach ($types_available as $type) : ?>
                <li>
                    <label class="flex items-center text-sm py-1.5 px-2 rounded-xs transition-colors hover:bg-gray-50 cursor-pointer">
                        <input
                            type="radio"
                            name="tipo"
                            value="<?php echo esc_attr($type); ?>"
                            class="filter-radio mr-2 text-blue-600 focus:ring-blue-500"
                            <?php echo $type_filter === $type ? 'checked' : ''; ?>
                        />
                        <span><?php echo esc_html(strtoupper($type)); ?></span>
                    </label>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>

        <!-- Filtro por rango de años -->
        <?php if (!empty($years_available)) : ?>
        <div class="mt-6 pt-6 border-t border-gray-100">
            <div class="flex justify-between items-center mb-3">
                <h4 class="font-bold text-gray-900 text-sm px-3">Rango de Años</h4>
                <?php if ($year_from || $year_to) : ?>
                <button id="clear-years" class="text-xs text-blue-600 mr-3 hover:underline">Limpiar</button>
                <?php endif; ?>
            </div>
            <div class="px-3 space-y-3">
                <div>
                    <label class="block text-xs text-gray-600 mb-1">Desde</label>
                    <select id="year-from" class="w-full px-3 py-2 border border-gray-300 rounded-xs focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                        <option value="">Seleccionar</option>
                        <?php foreach ($years_available as $year) : ?>
                        <option value="<?php echo esc_attr($year); ?>" <?php echo $year_from == $year ? 'selected' : ''; ?>><?php echo esc_html($year); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-xs text-gray-600 mb-1">Hasta</label>
                    <select id="year-to" class="w-full px-3 py-2 border border-gray-300 rounded-xs focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                        <option value="">Seleccionar</option>
                        <?php foreach ($years_available as $year) : ?>
                        <option value="<?php echo esc_attr($year); ?>" <?php echo $year_to == $year ? 'selected' : ''; ?>><?php echo esc_html($year); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button id="apply-year-filter" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xs text-sm font-medium transition-colors">
                    Aplicar
                </button>
            </div>
        </div>
        <?php endif; ?>
    </div>
</aside>