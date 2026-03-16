<?php
/**
 * Template Part: Sección Servicios
 * Campos ACF: services_title, services_description,
 *             services_1_title, services_1_content,
 *             services_2_title, services_2_content, services_2_extra,
 *             services_3_title, services_3_content
 */

$home_id = get_option('page_on_front');

// Sección
$services_title       = get_field('services_title',       $home_id) ?: 'Servicios';
$services_description = get_field('services_description', $home_id) ?: 'El personal administrativo de la Defensoría Universitaria cuenta con total predisposición para comunicarse y asistir a los y las estudiantes en situación de discapacidad en las necesidades especiales que tengan para su atención.';

// Tarjetas
$services = [
    [
        'title'         => get_field('services_1_title',   $home_id) ?: 'Consultas',
        'content'       => get_field('services_1_content', $home_id) ?: 'Brindamos asesoría sobre trámites administrativos, derechos, deberes y normatividad interna. También atendemos casos de conductas inadecuadas o manifestaciones de violencia, ofreciendo acompañamiento directo a los estudiantes que lo requieran.',
        'extra_content' => '',
        'style'         => 'border border-blue-100',
    ],
    [
        'title'         => get_field('services_2_title',   $home_id) ?: 'Quejas y reclamos',
        'content'       => get_field('services_2_content', $home_id) ?: 'Atendemos quejas por vulneración de derechos individuales o fallas en procesos administrativos.',
        'extra_content' => get_field('services_2_extra',   $home_id) ?: '<strong>Nota:</strong> No se resuelven denuncias sobre derechos colectivos, temas laborales, ni evaluaciones académicas de docentes y alumnos',
        'style'         => 'bg-white shadow-xl',
    ],
    [
        'title'         => get_field('services_3_title',   $home_id) ?: 'Mediación',
        'content'       => get_field('services_3_content', $home_id) ?: 'Facilitamos el diálogo entre las partes en conflicto para llegar a soluciones mutuamente satisfactorias, evitando procesos disciplinarios cuando es posible.',
        'extra_content' => '',
        'style'         => 'bg-gray-50 border border-gray-100',
    ],
];
?>

<section id="services" class="py-20 bg-white">
    <div class="container mx-auto px-4 max-w-6xl">

        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                <?php echo esc_html($services_title); ?>
            </h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                <?php echo esc_html($services_description); ?>
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            <!-- Servicio 1: Consultas -->
            <div class="rounded-sm p-8 transition-transform hover:-translate-y-1 hover:shadow-lg <?php echo esc_attr($services[0]['style']); ?> flex flex-col h-full">
                <h3 class="text-xl font-bold text-gray-900 mb-3">
                    <?php echo esc_html($services[0]['title']); ?>
                </h3>
                <p class="text-gray-700 leading-relaxed flex-grow">
                    <?php echo esc_html($services[0]['content']); ?>
                </p>
            </div>

            <!-- Servicio 2: Quejas y reclamos (destacado) -->
            <div class="rounded-sm p-8 relative transform md:-translate-y-4 flex flex-col h-full z-10 <?php echo esc_attr($services[1]['style']); ?>">
                <h3 class="text-xl font-bold text-gray-900 mb-3">
                    <?php echo esc_html($services[1]['title']); ?>
                </h3>
                <p class="text-gray-700 leading-relaxed mb-4 flex-grow">
                    <?php echo esc_html($services[1]['content']); ?>
                </p>
                <?php if ($services[1]['extra_content']) : ?>
                    <p class="text-gray-700 leading-relaxed mb-6">
                        <?php echo wp_kses_post($services[1]['extra_content']); ?>
                    </p>
                <?php endif; ?>
                <a href="<?php echo home_url('/#contact'); ?>"
                    class="w-full block text-center bg-[#b90615] hover:bg-[#8C0712] text-white font-medium py-3 px-6 rounded-sm transition-colors shadow-md hover:shadow-lg">
                    Presentar queja
                </a>
                <p class="text-center text-xs text-gray-500 mt-3 flex items-center justify-center gap-1">
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    Tus datos están protegidos
                </p>
            </div>

            <!-- Servicio 3: Mediación -->
            <div class="rounded-sm p-8 transition-transform hover:-translate-y-1 hover:shadow-lg <?php echo esc_attr($services[2]['style']); ?> flex flex-col h-full">
                <h3 class="text-xl font-bold text-gray-900 mb-3">
                    <?php echo esc_html($services[2]['title']); ?>
                </h3>
                <p class="text-gray-700 leading-relaxed flex-grow">
                    <?php echo esc_html($services[2]['content']); ?>
                </p>
            </div>

        </div>
    </div>
</section>