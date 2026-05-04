<?php
/**
 * Template Part: Sección Contacto
 */

require_once get_template_directory() . '/includes/contact-data.php';
?>

<section id="contact" class="py-20 bg-[#F2F2F2]">
    <div class="container mx-auto px-4 max-w-6xl">

        <h2 class="text-3xl md:text-4xl font-bold text-center text-gray-900 mb-16">
            Contáctanos
        </h2>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">

            <!-- Columna de información -->
            <div class="space-y-8">
                <p class="text-lg text-gray-600 mb-8">
                    <?php echo esc_html($contact_intro); ?>
                </p>

                <!-- Dirección -->
                <div class="flex items-start space-x-2">
                    <div class="text-blue-600 p-3 rounded-lg flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 text-lg">Dirección</h4>
                        <p class="text-gray-600"><?php echo nl2br(esc_html($contact_address)); ?></p>
                    </div>
                </div>

                <!-- Teléfono -->
                <div class="flex items-start space-x-2">
                    <div class="text-blue-600 p-3 rounded-lg flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 text-lg">Teléfono</h4>
                        <p class="text-gray-600">
                            <?php echo nl2br(esc_html($contact_phone)); ?>
                        </p>
                    </div>
                </div>

                <!-- Email -->
                <div class="flex items-start space-x-2">
                    <div class="text-blue-600 p-3 rounded-lg flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 text-lg">Email</h4>
                        <a href="mailto:<?php echo esc_attr($contact_email); ?>" target="_blank" class="text-gray-600 hover:text-blue-600 transition-colors">
                            <?php echo esc_html($contact_email); ?>
                        </a>
                    </div>
                </div>

                <!-- Horario -->
                <div class="flex items-start space-x-2">
                    <div class="text-blue-600 p-3 rounded-lg flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 text-lg">Horario de atención</h4>
                        <p class="text-gray-600"><?php echo esc_html($contact_hours); ?></p>
                    </div>
                </div>

                <!-- Redes sociales -->
                <?php if (!empty($social_links)) : ?>
                <div class="pt-2">
                    <h4 class="font-bold text-gray-900 mb-4">Síguenos</h4>
                    <div class="flex items-center gap-3">
                        <?php foreach ($social_links as $red => $url) :
                            if (!isset($social_icons[$red])) continue;
                            $icon = $social_icons[$red];
                        ?>
                        <a
                            href="<?php echo esc_url($url); ?>"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="w-10 h-10 rounded-full bg-white border border-gray-200 flex items-center justify-center hover:border-[#141F40] hover:shadow-md transition-all"
                            title="<?php echo esc_attr($icon['label']); ?>"
                        >
                            <span class="sr-only"><?php echo esc_html($icon['label']); ?></span>
                            <svg class="w-5 h-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <?php echo $icon['svg']; ?>
                            </svg>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Columna del mapa -->
            <div class="bg-gray-200 rounded-sm shadow-xl overflow-hidden border border-gray-100 min-h-[400px]">
                <?php if ($contact_map_url) : ?>
                <iframe
                    src="<?php echo esc_url($contact_map_url); ?>"
                    title="Oficina de la Defensoría Universitaria"
                    class="w-full h-full min-h-[400px]"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
                <?php else : ?>
                <div class="w-full h-full flex flex-col items-center justify-center text-gray-400 min-h-[400px]">
                    <svg class="w-16 h-16 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span>Mapa no disponible</span>
                </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</section>