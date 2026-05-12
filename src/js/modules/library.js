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

    function safeUrl(url) {
        if (!url || typeof url !== 'string') return '';
        try {
            const parsed = new URL(url);
            return (parsed.protocol === 'https:' || parsed.protocol === 'http:') ? url : '';
        } catch {
            return '';
        }
    }

    function el(tag, className, text) {
        const node = document.createElement(tag);
        if (className) node.className = className;
        if (text !== undefined) node.textContent = text;
        return node;
    }

    searchInput?.addEventListener('input', (e) => {
        const q = e.target.value.toLowerCase().trim();
        handleSearchInput();
    });

    const handleSearchInput = debounce(() => {
        const filters = getCurrentFilters();
        filterDocuments(filters);
    }, 300);

    // Filter checkboxes and radios
    document.querySelectorAll('.filter-checkbox, .filter-radio').forEach(input => {
        input.addEventListener('change', () => {
            const filters = getCurrentFilters();
            filterDocuments(filters);
        });
    });

    // Year filter apply button
    document.getElementById('apply-year-filter')?.addEventListener('click', () => {
        const filters = getCurrentFilters();
        filterDocuments(filters);
    });

    // Clear buttons
    document.getElementById('clear-categories')?.addEventListener('click', () => {
        document.querySelectorAll('.filter-checkbox').forEach(cb => cb.checked = false);
        const filters = getCurrentFilters();
        filterDocuments(filters);
    });

    document.getElementById('clear-type')?.addEventListener('click', () => {
        document.querySelectorAll('.filter-radio[name="tipo"]').forEach(rb => rb.checked = rb.value === '');
        const filters = getCurrentFilters();
        filterDocuments(filters);
    });

    document.getElementById('clear-years')?.addEventListener('click', () => {
        document.getElementById('year-from').value = '';
        document.getElementById('year-to').value = '';
        const filters = getCurrentFilters();
        filterDocuments(filters);
    });

    function getCurrentFilters() {
        const categories = Array.from(document.querySelectorAll('.filter-checkbox:checked')).map(cb => cb.value);
        const type = document.querySelector('.filter-radio[name="tipo"]:checked')?.value || '';
        const yearFrom = document.getElementById('year-from')?.value || '';
        const yearTo = document.getElementById('year-to')?.value || '';
        const busqueda = document.getElementById('biblioteca-search')?.value || '';

        return {
            categoria: categories,
            tipo: type,
            anio_desde: yearFrom,
            anio_hasta: yearTo,
            busqueda: busqueda
        };
    }

    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    function filterDocuments(filters) {
        const formData = new FormData();
        formData.append('action', 'filter_library');
        formData.append('nonce', window.BIBLIOTECA_NONCE);

        Object.keys(filters).forEach(key => {
            if (Array.isArray(filters[key])) {
                filters[key].forEach(value => formData.append(key + '[]', value));
            } else {
                formData.append(key, filters[key]);
            }
        });

        fetch(window.BIBLIOTECA_AJAX_URL, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateDocumentGrid(data.data.html);
                updatePagination(data.data.pagination);
                // Update global DOCS for modal
                window.BIBLIOTECA_DOCS = data.data.docs;
            }
        })
        .catch(error => console.error('Error filtering documents:', error));
    }

    function updateDocumentGrid(html) {
        const grid = document.getElementById('biblioteca-grid');
        if (grid) {
            grid.innerHTML = html;
        }
    }

    function updatePagination(paginationHtml) {
        // Assuming pagination is after the grid
        const grid = document.getElementById('biblioteca-grid');
        if (grid && grid.nextElementSibling) {
            grid.nextElementSibling.outerHTML = paginationHtml;
            // Re-attach pagination listeners
            attachPaginationListeners();
        }
    }

    function attachPaginationListeners() {
        document.querySelectorAll('.pagination-link').forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const page = link.getAttribute('data-page');
                const filters = getCurrentFilters();
                filters.page = page;
                filterDocuments(filters);
            });
        });
    }

    // Attach initial pagination listeners
    attachPaginationListeners();

    // ── Abrir panel ──────────────────────────────────────
    window.openDocPanel = (id) => {
        const doc = DOCS.find(d => d.id == id);
        if (!doc) return;

        const versions = Array.isArray(doc.versions) ? doc.versions : [];
        const current  = versions.length > 0 ? versions[versions.length - 1] : null;
        const history  = versions.length > 1 ? versions.slice(0, -1).reverse() : [];

        // Categoria
        const catClase = CAT_COLORES[doc.category] || 'bg-gray-100 text-gray-700 border-gray-200';
        const catEl = document.getElementById('panel-category');
        catEl.className = `inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold border mb-3 ${catClase}`;
        catEl.textContent = doc.category || '';

        document.getElementById('panel-title').textContent = doc.title;
        document.querySelector('#panel-year span').textContent = doc.year;

        // Version actual
        if (current) {
            document.getElementById('panel-ver-numero').textContent = current.numero || '';
            document.getElementById('panel-ver-fecha').textContent = current.fecha || '';
            document.getElementById('panel-ver-notas').textContent = current.notas || '';

            const dlBtn = document.getElementById('panel-download-btn');
            const url   = safeUrl(current.url);

            if (url) {
                dlBtn.href = url;
                dlBtn.classList.remove('opacity-50', 'pointer-events-none');
            } else {
                dlBtn.href = '#';
                dlBtn.classList.add('opacity-50', 'pointer-events-none');
            }
        }

        // Historial
        const histEl = document.getElementById('panel-history');
        histEl.innerHTML = '';

        if (history.length === 0) {
            histEl.appendChild(el('p', 'text-sm text-gray-400 italic', 'No hay versiones anteriores.'));
        } else {
            history.forEach(v => {
                // Contenedor principal
                const row = el('div', 'bg-white p-4 flex gap-4 transition-colors');

                // ── Columna izquierda: versión + fecha ──────────────────────
                const colLeft = el('div', 'flex flex-col content-center flex-shrink-0');
                colLeft.appendChild(el('span', 'bg-gray-100 text-gray-700 text-center px-2 py-1 font-bold text-sm', v.numero || ''));
                colLeft.appendChild(el('p',    'text-xs text-gray-500 mb-1', v.fecha || ''));
                row.appendChild(colLeft);

                // ── Columna central: título + notas ──────────────────────────────────
                const colCenter = el('div', 'flex-grow min-w-0');
                if (v.title) {
                    colCenter.appendChild(el('h4', 'text-sm font-semibold text-gray-900 mb-1', v.title));
                }
                colCenter.appendChild(el('p', 'text-sm text-gray-700 line-clamp-3', v.notas || '-'));
                row.appendChild(colCenter);

                // ── Columna derecha: botón de descarga (sólo si URL válida) ─
                const url = safeUrl(v.url);
                if (url) {
                    const colRight = el('div', 'flex-shrink-0 flex items-center');
                    const a = document.createElement('a');
                    a.href      = url;
                    a.download  = '';
                    a.target    = '_blank';
                    a.rel       = 'noopener noreferrer';
                    a.className = 'p-2 text-[#141F40] hover:bg-blue-50 rounded-lg transition-colors';
                    a.title     = 'Descargar esta versión';
                    a.setAttribute('aria-label', `Descargar versión ${v.numero || ''}`);
                    // SVG creado con DOM — sin innerHTML
                    const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
                    svg.setAttribute('class', 'w-5 h-5');
                    svg.setAttribute('fill', 'none');
                    svg.setAttribute('viewBox', '0 0 24 24');
                    svg.setAttribute('stroke', 'currentColor');
                    const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
                    path.setAttribute('stroke-linecap', 'round');
                    path.setAttribute('stroke-linejoin', 'round');
                    path.setAttribute('stroke-width', '2');
                    path.setAttribute('d', 'M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4');
                    svg.appendChild(path);
                    a.appendChild(svg);
                    colRight.appendChild(a);
                    row.appendChild(colRight);
                }

                histEl.appendChild(row);
            });
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
    panel.addEventListener('click', (e) => { if (e.target === panel) closePanel(); });


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