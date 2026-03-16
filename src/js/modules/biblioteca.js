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
        const q = e.target.value.toLowerCase();
        document.querySelectorAll('#biblioteca-grid > div[onclick]').forEach(card => {
            const title = card.querySelector('h4')?.textContent.toLowerCase() || '';
            card.style.display = title.includes(q) ? '' : 'none';
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
                <div class="bg-white border border-gray-100 rounded-xl p-4 flex gap-4 hover:border-gray-300 transition-colors">
                    <div class="flex-shrink-0">
                        <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded font-bold text-sm">${v.numero || ''}</span>
                    </div>
                    <div class="flex-grow min-w-0">
                        <p class="text-xs text-gray-500 mb-1">${v.fecha || ''}</p>
                        <p class="text-sm text-gray-700 truncate">${v.notas || '-'}</p>
                    </div>
                    ${v.url ? `
                    <div class="flex-shrink-0 flex items-center">
                        <a href="${v.url}" download target="_blank"
                            class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
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
        setTimeout(() => {
            backdrop.classList.remove('opacity-0');
            panel.classList.remove('translate-x-full');
        }, 10);
    };

    // ── Cerrar panel ─────────────────────────────────────
    function closePanel() {
        panel.classList.add('translate-x-full');
        backdrop.classList.add('opacity-0');
        setTimeout(() => backdrop.classList.add('hidden'), 300);
    }

    document.getElementById('panel-close')?.addEventListener('click', closePanel);
    backdrop.addEventListener('click', closePanel);

    // Cerrar con tecla Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closePanel();
    });
});