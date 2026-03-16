<?php
/**
 * Template Part: Sección Contacto
 * Campos ACF: contact_intro, contact_address, contact_phone,
 *             contact_email, contact_hours, contact_facebook, contact_map_url
 */

$home_id = get_option('page_on_front');

$contact_intro    = get_field('contact_intro',    $home_id) ?: 'Estamos aquí para escucharte. Puedes visitarnos en nuestras oficinas, llamarnos o enviarnos un mensaje a través del formulario.';
$contact_address  = get_field('contact_address',  $home_id) ?: 'Av. Virgen del Pilar s/n, Área de Sociales de la UNSA. Referencia: al costado del Comedor Universitario';
$contact_phone    = get_field('contact_phone',    $home_id) ?: '+51 932 907 594';
$contact_email    = get_field('contact_email',    $home_id) ?: 'defensoria@unsa.edu.pe';
$contact_hours    = get_field('contact_hours',    $home_id) ?: 'Lunes a Viernes: 8:30 AM - 3:40 PM';
$contact_facebook = get_field('contact_facebook', $home_id) ?: 'https://www.facebook.com/DefUnsa/';
$contact_map_url  = get_field('contact_map_url',  $home_id) ?: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d956.8418514942298!2d-71.52196753434885!3d-16.40615648432324!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91424b4ab43c09f1%3A0x76543ca3cba745d!2sDefensoria%20Universitaria%20-%20UNSA!5e0!3m2!1ses!2spe!4v1771854708866!5m2!1ses!2spe';
?>

<section id="contact" class="py-20 bg-gray-50">
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
                            <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $contact_phone)); ?>" class="hover:text-blue-600 transition-colors">
                                <?php echo esc_html($contact_phone); ?>
                            </a>
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
                        <p class="text-gray-600">
                            <a href="mailto:<?php echo esc_attr($contact_email); ?>" class="hover:text-blue-600 transition-colors">
                                <?php echo esc_html($contact_email); ?>
                            </a>
                        </p>
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
                <?php if ($contact_facebook) : ?>
                <div class="pt-6">
                    <h4 class="font-bold text-gray-900 mb-4">Síguenos</h4>
                    <div class="flex space-x-4">
                        <a href="<?php echo esc_url($contact_facebook); ?>" target="_blank" rel="noopener noreferrer"
                            class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center hover:bg-blue-700 transition-colors">
                            <span class="sr-only">Facebook</span>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                        </a>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Columna del mapa embebido -->
            <div class="bg-gray-200 rounded-sm shadow-xl overflow-hidden border border-gray-100 min-h-[400px] w-full h-full lg:h-auto">
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