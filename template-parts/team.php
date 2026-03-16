<?php
/**
 * Template Part: Sección Equipo
 * CPT: miembro
 * Campos ACF: miembro_cargo, miembro_bio_short, miembro_bio_long,
 *             miembro_email, miembro_es_principal
 * Imagen: imagen destacada del post (set_post_thumbnail)
 */

// Consultar todos los miembros
$miembros = new WP_Query([
    'post_type'      => 'miembro',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
]);

// Separar principal del resto
$principal  = null;
$secundarios = [];

if ($miembros->have_posts()) {
    while ($miembros->have_posts()) {
        $miembros->the_post();
        $es_principal = get_field('miembro_es_principal');
        if ($es_principal && $principal === null) {
            $principal = [
                'id'        => get_the_ID(),
                'name'      => get_the_title(),
                'cargo'     => get_field('miembro_cargo')     ?: '',
                'bio_short' => get_field('miembro_bio_short') ?: '',
                'bio_long'  => get_field('miembro_bio_long')  ?: '',
                'email'     => get_field('miembro_email')     ?: '',
                'image'     => get_the_post_thumbnail_url(get_the_ID(), 'medium') ?: '',
            ];
        } else {
            $secundarios[] = [
                'id'        => get_the_ID(),
                'name'      => get_the_title(),
                'cargo'     => get_field('miembro_cargo')     ?: '',
                'bio_short' => get_field('miembro_bio_short') ?: '',
                'bio_long'  => get_field('miembro_bio_long')  ?: '',
                'email'     => get_field('miembro_email')     ?: '',
                'image'     => get_the_post_thumbnail_url(get_the_ID(), 'medium') ?: '',
            ];
        }
    }
    wp_reset_postdata();
}
?>

<section id="team" class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl md:text-4xl font-bold text-center text-gray-900 mb-16">
            Nuestro equipo
        </h2>

        <?php if (!$principal && empty($secundarios)) : ?>
            <p class="text-center text-gray-500">No hay miembros del equipo publicados aún.</p>
        <?php else : ?>

        <div class="flex flex-col items-center space-y-12">

            <?php if ($principal) : ?>
            <!-- Tarjeta principal -->
            <div class="w-full max-w-lg bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 transform hover:shadow-2xl transition-all duration-300">
                <div class="p-8 flex flex-col items-center text-center">
                    <?php if ($principal['image']) : ?>
                    <div class="w-48 h-48 rounded-full overflow-hidden mb-6 border-4 border-blue-600 shadow-sm">
                        <img
                            src="<?php echo esc_url($principal['image']); ?>"
                            alt="<?php echo esc_attr($principal['name']); ?>"
                            class="w-full h-full object-cover"
                        />
                    </div>
                    <?php endif; ?>
                    <h3 class="text-2xl font-bold text-gray-900 mb-1">
                        <?php echo esc_html($principal['name']); ?>
                    </h3>
                    <p class="text-blue-600 font-semibold text-lg mb-4">
                        <?php echo esc_html($principal['cargo']); ?>
                    </p>
                    <?php if ($principal['bio_short']) : ?>
                    <p class="text-gray-600 mb-6">
                        <?php echo esc_html($principal['bio_short']); ?>
                    </p>
                    <?php endif; ?>

                    <?php if ($principal['bio_long'] || $principal['email']) : ?>
                    <button class="toggle-btn text-blue-600 hover:text-blue-700 font-medium flex items-center transition-colors focus:outline-none">
                        <span>Leer más</span>
                        <svg class="w-4 h-4 ml-1 transform transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    </div>
                    <!-- Contenido expandible -->
                    <div class="hidden bg-gray-50 px-8 pb-8 pt-2 border-t border-gray-100">
                        <div class="space-y-4 text-sm text-gray-700 text-left">
                            <?php if ($principal['bio_long']) : ?>
                            <div>
                                <h4 class="font-bold text-gray-900 mb-1">Trayectoria</h4>
                                <p><?php echo esc_html($principal['bio_long']); ?></p>
                            </div>
                            <?php endif; ?>
                            <?php if ($principal['email']) : ?>
                            <div>
                                <h4 class="font-bold text-gray-900 mb-1">Contacto</h4>
                                <a href="mailto:<?php echo esc_attr($principal['email']); ?>" class="hover:text-blue-600 transition-colors">
                                    <?php echo esc_html($principal['email']); ?>
                                </a>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php else : ?>
                    </div>
                    <?php endif; ?>
            </div>
            <?php endif; ?>

            <?php if (!empty($secundarios)) : ?>
            <!-- Grid de miembros secundarios -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 w-full max-w-6xl">
                <?php foreach ($secundarios as $miembro) : ?>
                <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow overflow-hidden border border-gray-100">
                    <div class="p-6 flex flex-col items-center text-center">
                        <?php if ($miembro['image']) : ?>
                        <div class="w-32 h-32 rounded-full overflow-hidden mb-4 border-2 border-teal-500/50">
                            <img
                                src="<?php echo esc_url($miembro['image']); ?>"
                                alt="<?php echo esc_attr($miembro['name']); ?>"
                                class="w-full h-full object-cover"
                            />
                        </div>
                        <?php endif; ?>
                        <h4 class="text-xl font-bold text-gray-900">
                            <?php echo esc_html($miembro['name']); ?>
                        </h4>
                        <p class="text-teal-600 font-medium text-sm mb-3">
                            <?php echo esc_html($miembro['cargo']); ?>
                        </p>
                        <?php if ($miembro['bio_short']) : ?>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                            <?php echo esc_html($miembro['bio_short']); ?>
                        </p>
                        <?php endif; ?>

                        <?php if ($miembro['bio_long'] || $miembro['email']) : ?>
                        <button class="toggle-btn text-teal-600 hover:text-teal-700 text-sm font-medium flex items-center transition-colors focus:outline-none">
                            <span>Leer más</span>
                            <svg class="w-4 h-4 ml-1 transform transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        </div>
                        <!-- Contenido expandible -->
                        <div class="hidden bg-gray-50 px-6 pb-6 pt-2 border-t border-gray-100 text-sm text-left">
                            <?php if ($miembro['bio_long']) : ?>
                            <p class="text-gray-700 mb-2"><?php echo esc_html($miembro['bio_long']); ?></p>
                            <?php endif; ?>
                            <?php if ($miembro['email']) : ?>
                            <a href="mailto:<?php echo esc_attr($miembro['email']); ?>" class="font-semibold hover:text-blue-600 transition-colors">
                                <?php echo esc_html($miembro['email']); ?>
                            </a>
                            <?php endif; ?>
                        </div>
                        <?php else : ?>
                        </div>
                        <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

        </div>
        <?php endif; ?>

    </div>
</section>