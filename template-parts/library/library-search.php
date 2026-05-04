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