<section class="relative min-h-screen flex items-center justify-center overflow-hidden bg-gray-900">

    <!-- Background Images with Overlay -->
    <div class="absolute inset-0 z-0 bg-gray-900">
        <img
            src="<?php echo get_template_directory_uri(); ?>/assets/images/du1.webp"
            alt="Oficina de la Defensoría Universitaria"
            class="absolute inset-0 w-full h-full object-cover opacity-90"
        />
        <img
            src="<?php echo get_template_directory_uri(); ?>/assets/images/conjunto.jpg"
            alt="Instalaciones de la Defensoría Universitaria"
            class="absolute inset-0 w-full h-full object-cover opacity-90 animate-hero-carousel"
        />
        <div class="absolute inset-0 bg-black/40 z-10"></div>
    </div>

    <!-- Main Content -->
    <div class="relative z-10 container mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-5xl lg:text-[55px] font-[480] text-white mb-16 drop-shadow-lg tracking-wider">
            DEFENSORÍA UNIVERSITARIA
        </h1>
        <p class="text-lg md:text-[30px] text-gray-100 font-normal mb-10 max-w-2xl mx-auto drop-shadow-md tracking-wide italic">
            Defender tus derechos nos fortalece
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a
                href="#contact"
                class="px-8 py-3 bg-[#b90615] hover:bg-[#8C0712] text-white font-semibold rounded-sm shadow-lg transition-all transform hover:-translate-y-1"
            >
                Presentar una queja
            </a>
        </div>
    </div>

    <!-- Floating Event Banner -->
     <!--
    <div class="absolute bottom-6 right-6 z-20 hidden md:block w-80 bg-white rounded-sm shadow-xl overflow-hidden animate-fade-in-up">
        <div class="p-4">
            <div class="flex justify-between items-start mb-2">
                <h3 class="font-bold text-gray-800 text-sm uppercase tracking-wide">Próximos eventos</h3>
                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800 animate-pulse">
                    En curso
                </span>
            </div>

            <div class="flex gap-3">
                <div class="w-1/3 shrink-0">
                    <img
                        src="https://images.unsplash.com/photo-1523580494863-6f3031224c94?q=80&w=150&auto=format&fit=crop"
                        alt="Evento"
                        class="w-full h-20 object-cover rounded-sm"
                    />
                </div>
                <div class="w-2/3">
                    <h4 class="font-semibold text-gray-900 text-sm mb-1 leading-tight">
                        Charla: Derechos Estudiantiles
                    </h4>
                    <p class="text-xs text-gray-500 mb-2">Hoy, 4:00 PM - Auditorio Principal</p>
                    <a href="#event-details" class="text-xs font-medium text-blue-600 hover:text-blue-700 flex items-center gap-1">
                        Más información
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        <button id="close-event-banner" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">
            <span class="sr-only">Cerrar</span>
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>-->

</section>