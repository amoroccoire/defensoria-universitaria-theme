<?php
include get_template_directory() . '/includes/contact-data.php';
global $contact_address, $contact_phone, $contact_email, $contact_hours, $social_links, $social_icons;
?>

<footer class="bg-[#141F40] text-gray-300 py-12 border-t border-gray-800">
    <?php 
    $logo_unsa = get_theme_mod('logo_unsa', get_template_directory_uri() . '/assets/images/unsa-oficinas.png');
    $logo_oficina = get_theme_mod('logo_oficina', get_template_directory_uri() . '/assets/images/imagotipo_du_black.png');
    $office_name = get_theme_mod('header_oficina_nombre', 'Defensoría Universitaria');
    ?>

    <div class="container mx-auto px-4 max-w-7xl">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12 mb-12">

            <!-- Columna 1: Info institucional -->
            <div>
                <div class="flex items-center space-x-3 mb-6">
                    <img
                        src="<?php echo esc_url($logo_unsa); ?>"
                        alt="Logo UNSA"
                        class="h-12 w-auto opacity-90"
                    />
                    <img
                        src="<?php echo esc_url($logo_oficina); ?>"
                        alt="Logo Defensoría Universitaria"
                        class="h-16 w-auto opacity-90"
                    />
                    <div class="hidden md:flex flex-col">
                        <span class="font-bold text-white text-lg leading-tight"><?php echo esc_html($office_name); ?></span>
                        <span class="text-xs text-gray-400 font-medium tracking-wide">UNSA</span>
                    </div>
                </div>
                <p class="text-sm leading-relaxed text-gray-400">
                    La Defensoría Universitaria es el órgano encargado de la tutela de los derechos
                    de los miembros de la comunidad universitaria.
                </p>
            </div>

            <!-- Columna 2: Enlaces rápidos -->
            <div class="lg:pl-10">
                <h3 class="text-white font-bold text-lg mb-6 relative inline-block">
                    Enlaces rápidos
                    <span class="absolute -bottom-2 left-0 w-10 h-1 bg-blue-600 rounded-full"></span>
                </h3>
                <ul class="space-y-3 text-sm mt-2">
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'footer',
                        'container'      => false,
                        'items_wrap'     => '%3$s',
                        'walker'         => new Oficina_Footer_Walker(),
                        'fallback_cb'    => 'defensoria_footer_fallback',
                    ]);
                    ?>
                </ul>
            </div>

            <div>
                <h3 class="text-white font-bold text-lg mb-6 relative inline-block">
                    Contacto
                    <span class="absolute -bottom-2 left-0 w-10 h-1 bg-blue-600 rounded-full"></span>
                </h3>
                <ul class="space-y-4 text-sm mt-2">

                    <!-- Dirección -->
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-white mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span><?php echo nl2br(esc_html($contact_address)); ?></span>
                    </li>

                    <!-- Teléfono -->
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-white flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <?php echo nl2br(esc_html($contact_phone)); ?>
                    </li>

                    <!-- Email -->
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-white flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <a href="mailto:<?php echo esc_attr($contact_email); ?>" target="_blank">
                            <?php echo esc_html($contact_email); ?>
                        </a>
                    </li>

                    <!-- Horario -->
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-white flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span><?php echo esc_html($contact_hours); ?></span>
                    </li>

                </ul>

                <!-- Redes sociales sincronizadas -->
                <?php if (!empty($social_links)) : ?>
                <div class="mt-6 flex items-center gap-3">
                    <?php foreach ($social_links as $red => $url) :
                        if (!isset($social_icons[$red])) continue;
                        $icon = $social_icons[$red];
                    ?>
                    <a
                        href="<?php echo esc_url($url); ?>"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="w-9 h-9 rounded-full bg-white flex items-center justify-center hover:opacity-80 transition-opacity"
                        title="<?php echo esc_attr($icon['label']); ?>"
                    >
                        <span class="sr-only"><?php echo esc_html($icon['label']); ?></span>
                        <svg class="w-4 h-4" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <?php echo $icon['svg']; ?>
                        </svg>
                    </a>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

        </div>

        <!-- Copyright -->
        <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center text-xs text-gray-500">
            <p>&copy; <?php echo date('Y'); ?> Defensoría Universitaria - UNSA. Todos los derechos reservados.</p>
        </div>

    </div>
</footer>

<?php
function defensoria_footer_fallback() {
    $links = [
        'Inicio'    => home_url('/'),
        'Conócenos' => home_url('/#about'),
        'Servicios' => home_url('/#services'),
        'Equipo'    => home_url('/equipo'),
        'Recursos'  => home_url('/recursos'),
        'Noticias'  => home_url('/noticias'),
        'Contacto'  => home_url('/#contact'),
    ];
    foreach ($links as $name => $url) {
        printf(
            '<li><a href="%s" class="hover:text-blue-400 transition-colors flex items-center group"><svg class="w-3 h-3 mr-2 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>%s</a></li>',
            esc_url($url),
            esc_html($name)
        );
    }
}
?>

<?php wp_footer(); ?>
</body>
</html>