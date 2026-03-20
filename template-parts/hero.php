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
        <p class="text-lg md:text-[30px] text-gray-100 font-normal mb-10 max-w-2xl mx-auto drop-shadow-md tracking-wide">
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
</section>
