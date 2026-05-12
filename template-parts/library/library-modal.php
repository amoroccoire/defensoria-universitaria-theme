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
                        <span id="panel-ver-numero" class="bg-[#141F40] text-white px-2.5 py-1 rounded-xs text-sm font-bold">gaa</span>
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