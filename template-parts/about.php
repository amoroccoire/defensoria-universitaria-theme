<?php
/**
 * Template Part: Sección Conócenos
 * Campos ACF: about_title, about_what_is, about_mission, about_vision, about_history
 */

// Obtener el ID de la página de inicio
$home_id = get_option('page_on_front');

// Leer campos ACF con fallback al texto original
$about_title   = get_field('about_title',   $home_id) ?: 'Conócenos';
$about_what_is = get_field('about_what_is', $home_id) ?: 'La Defensoría Universitaria, es la instancia encargada de la tutela de los derechos de los miembros de la comunidad universitaria y de velar por el mantenimiento del principio de autoridad responsable. Tiene a su cargo la atención de consultas, reclamos y sugerencias.';
$about_mission = get_field('about_mission', $home_id) ?: 'Proteger los derechos de estudiantes, docentes y personal administrativo mediante la conciliación y mediación, fomentando una cultura de paz, respeto y legalidad dentro de la universidad.';
$about_vision  = get_field('about_vision',  $home_id) ?: 'Ser reconocidos como un referente ético y moral en la comunidad universitaria, garantizando una convivencia armónica basada en el diálogo, la justicia y el respeto mutuo.';
$about_history = get_field('about_history', $home_id) ?: '<p>Ingresa aquí la historia de la Defensoría Universitaria.</p>';

$about_content = [
    [
        'id'    => 'what-is',
        'label' => '¿Qué es?',
        'text'  => $about_what_is,
        'html'  => false,
    ],
    [
        'id'    => 'mission',
        'label' => 'Misión',
        'text'  => $about_mission,
        'html'  => false,
    ],
    [
        'id'    => 'vision',
        'label' => 'Visión',
        'text'  => $about_vision,
        'html'  => false,
    ],
    [
        'id'    => 'history',
        'label' => 'Historia',
        'text'  => $about_history,
        'html'  => true, // WYSIWYG — renderiza HTML
    ],
];
?>

<section id="about" class="py-20 bg-[#F2F2F2]">
    <div class="container mx-auto px-4 max-w-6xl">
        <h2 class="text-3xl md:text-4xl font-semibold text-center text-gray-900 mb-12">
            <?php echo esc_html($about_title); ?>
        </h2>

        <!-- Tabs Navigation -->
        <div class="flex flex-wrap justify-center border-b border-gray-200 mb-12">
            <?php foreach ($about_content as $index => $item) : ?>
                <button
                    class="tab-btn px-6 py-3 text-sm md:text-base font-medium text-gray-500 hover:text-blue-600 transition-colors border-b-2 border-transparent focus:outline-none <?php echo $index === 0 ? 'active' : ''; ?>"
                    data-target="tab-<?php echo esc_attr($item['id']); ?>"
                >
                    <?php echo esc_html($item['label']); ?>
                </button>
            <?php endforeach; ?>
        </div>

        <!-- Tabs Content -->
        <div class="relative min-h-[300px]">

            <!-- Tab 1: ¿Qué es? -->
            <div id="tab-what-is" class="tab-content active transition-opacity duration-500">
                <div class="flex flex-col md:flex-row items-center gap-8">
                    <div class="md:w-1/2">
                        <p class="text-lg text-gray-700 leading-relaxed">
                            <?php echo esc_html($about_what_is); ?>
                        </p>
                    </div>
                    <div class="md:w-1/2 flex justify-center">
                        <div class="p-8 bg-blue-50 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-32 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 2: Misión -->
            <div id="tab-mission" class="tab-content hidden transition-opacity duration-500">
                <div class="flex flex-col md:flex-row items-center gap-8">
                    <div class="md:w-1/2 order-2 md:order-1 flex justify-center">
                        <div class="p-8 bg-green-50 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-32 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="md:w-1/2 order-1 md:order-2">
                        <h3 class="text-2xl font-semibold mb-4 text-gray-800">Nuestra Misión</h3>
                        <p class="text-lg text-gray-700 leading-relaxed">
                            <?php echo esc_html($about_mission); ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Tab 3: Visión -->
            <div id="tab-vision" class="tab-content hidden transition-opacity duration-500">
                <div class="flex flex-col md:flex-row items-center gap-8">
                    <div class="md:w-1/2">
                        <h3 class="text-2xl font-semibold mb-4 text-gray-800">Nuestra Visión</h3>
                        <p class="text-lg text-gray-700 leading-relaxed">
                            <?php echo esc_html($about_vision); ?>
                        </p>
                    </div>
                    <div class="md:w-1/2 flex justify-center">
                        <div class="p-8 bg-yellow-50 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-32 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 4: Historia -->
            <div id="tab-history" class="tab-content hidden transition-opacity duration-500">
                <div class="space-y-6 relative border-l-2 border-gray-200 ml-4 pl-8">
                    <?php echo wp_kses_post($about_history); ?>
                </div>
            </div>

        </div>
    </div>
</section>