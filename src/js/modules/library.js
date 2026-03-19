// =============================================
// Módulo: Biblioteca
// Slide panel con historial de versiones + búsqueda
// Requiere: window.BIBLIOTECA_DOCS y window.CAT_COLORES
// definidos en template-parts/biblioteca.php
// =============================================

document.addEventListener('DOMContentLoaded', () => {

    const panel = document.getElementById('doc-slide-panel');
    const backdrop = document.getElementById('doc-backdrop');
    const searchInput = document.getElementById('biblioteca-search');

    // Si no existe el panel, no estamos en la página de biblioteca
    if (!panel) return;

    const DOCS = window.BIBLIOTECA_DOCS || [];
    const CAT_COLORES = window.CAT_COLORES || {};

    // ── Búsqueda en tiempo real ──────────────────────────
    searchInput?.addEventListener('input', (e) => {
        const q = e.target.value.toLowerCase().trim();

        // Iteramos sobre las tarjetas
        document.querySelectorAll('#biblioteca-grid > div.group').forEach(card => {
            const titleElement = card.querySelector('.js-search-title');
            const title = titleElement ? titleElement.textContent.toLowerCase() : '';

            if (title.includes(q)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    });

    // ── Abrir panel ──────────────────────────────────────
    window.openDocPanel = (id) => {
        const doc = DOCS.find(d => d.id == id);
        if (!doc) return;

        const versions = doc.versions || [];
        const current = versions.length > 0 ? versions[versions.length - 1] : null;
        const history = versions.length > 1 ? versions.slice(0, -1).reverse() : [];

        // Categoría
        const catClase = CAT_COLORES[doc.category] || 'bg-gray-100 text-gray-700 border-gray-200';
        const catEl = document.getElementById('panel-category');
        catEl.className = `inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold border mb-3 ${catClase}`;
        catEl.textContent = doc.category || '';

        document.getElementById('panel-title').textContent = doc.title;
        document.querySelector('#panel-year span').textContent = doc.year;

        // Versión actual
        if (current) {
            document.getElementById('panel-ver-numero').textContent = current.numero || '';
            document.getElementById('panel-ver-fecha').textContent = current.fecha || '';
            document.getElementById('panel-ver-notas').textContent = current.notas || '';

            const dlBtn = document.getElementById('panel-download-btn');
            if (current.url) {
                dlBtn.href = current.url;
                dlBtn.classList.remove('opacity-50', 'pointer-events-none');
            } else {
                dlBtn.href = '#';
                dlBtn.classList.add('opacity-50', 'pointer-events-none');
            }
        }

        // Historial
        const histEl = document.getElementById('panel-history');
        if (history.length === 0) {
            histEl.innerHTML = '<p class="text-sm text-gray-400 italic">No hay versiones anteriores.</p>';
        } else {
            histEl.innerHTML = history.map(v => `
                <div class="bg-white p-4 flex gap-4 transition-colors">
                    <div class="flex flex-col content-center flex-shrink-0">
                        <span class="bg-gray-100 text-gray-700 text-center px-2 py-1 font-bold text-sm">${v.numero || ''}</span>
                        <p class="text-xs text-gray-500 mb-1">${v.fecha || ''}</p>
                    </div>
                    <div class="flex-grow min-w-0">
                        <p class="text-sm text-gray-700 line-clamp-3">${v.notas || '-'}</p>
                    </div>
                    ${v.url ? `
                    <div class="flex-shrink-0 flex items-center">
                        <a href="${v.url}" download target="_blank"
                            class="p-2 text-[#141F40] hover:bg-blue-50 rounded-lg transition-colors"
                            title="Descargar esta versión">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                        </a>
                    </div>` : ''}
                </div>
            `).join('');
        }

        // Animación de apertura
        backdrop.classList.remove('hidden');
        panel.classList.remove('pointer-events-none');
        setTimeout(() => {
            backdrop.classList.remove('opacity-0');
            panel.classList.remove('opacity-0');
            const modalContent = document.getElementById('doc-modal-content');
            if (modalContent) {
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }
        }, 10);
    };

    // ── Cerrar panel ─────────────────────────────────────
    function closePanel() {
        backdrop.classList.add('opacity-0');
        panel.classList.add('opacity-0', 'pointer-events-none');
        const modalContent = document.getElementById('doc-modal-content');
        if (modalContent) {
            modalContent.classList.add('scale-95');
            modalContent.classList.remove('scale-100');
        }
        setTimeout(() => backdrop.classList.add('hidden'), 300);
    }

    document.getElementById('panel-close')?.addEventListener('click', closePanel);
    backdrop.addEventListener('click', closePanel);
    panel.addEventListener('click', (e) => {
        if (e.target === panel) closePanel();
    });

    // Cerrar con tecla Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !panel.classList.contains('pointer-events-none')) closePanel();
    });

    // ── Toggle Mobile Sidebar ────────────────────────────
    const btnMobileFiltros = document.getElementById('btn-mobile-filtros');
    const sidebarFiltros = document.getElementById('sidebar-filtros');
    const sidebarBackdrop = document.getElementById('sidebar-backdrop');
    const btnCloseFiltros = document.getElementById('btn-close-filtros');

    function openSidebar() {
        sidebarFiltros?.classList.remove('-translate-x-full');
        sidebarBackdrop?.classList.remove('hidden');
        setTimeout(() => sidebarBackdrop?.classList.remove('opacity-0'), 10);
    }

    function closeSidebar() {
        sidebarFiltros?.classList.add('-translate-x-full');
        sidebarBackdrop?.classList.add('opacity-0');
        setTimeout(() => sidebarBackdrop?.classList.add('hidden'), 300);
    }

    btnMobileFiltros?.addEventListener('click', openSidebar);
    btnCloseFiltros?.addEventListener('click', closeSidebar);
    sidebarBackdrop?.addEventListener('click', closeSidebar);

});