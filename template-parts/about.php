<?php
/**
 * Template Part: Sección Conócenos
 * Imagen izquierda · Título + texto derecha · Tabs con indicador activo
 */

$home_id = get_option('page_on_front');

$about_title   = get_field('about_title',   $home_id) ?: 'Conócenos';
$about_what_is = get_field('about_what_is', $home_id) ?: 'La Defensoría Universitaria, es la instancia encargada de la tutela de los derechos de los miembros de la comunidad universitaria y de velar por el mantenimiento del principio de autoridad responsable. Tiene a su cargo la atención de consultas, reclamos y sugerencias.';
$about_mission = get_field('about_mission', $home_id) ?: 'Proteger los derechos de estudiantes, docentes y personal administrativo mediante la conciliación y mediación, fomentando una cultura de paz, respeto y legalidad dentro de la universidad.';
$about_history = get_field('about_history', $home_id) ?: '<p>Ingresa aquí la historia de la Defensoría Universitaria.</p>';

$principio_1 = get_field('about_principio_1', $home_id) ?: 'Justicia';
$principio_2 = get_field('about_principio_2', $home_id) ?: 'Diálogo';
$principio_3 = get_field('about_principio_3', $home_id) ?: 'Respeto';

$img_what_is    = get_field('about_what_is_image',    $home_id);
$img_mission    = get_field('about_mission_image',    $home_id);
$img_principios = get_field('about_principios_image', $home_id);
$img_history    = get_field('about_history_image',    $home_id);

// Helper: imagen o placeholder
function about_render_image( $img, $svg_path, $bg = 'bg-blue-50', $color = 'text-blue-600' ) {
    if ( $img && is_array($img) ) {
        echo '<img
            src="' . esc_url($img['url']) . '"
            alt="' . esc_attr($img['alt']) . '"
            class="w-full h-full object-cover"
        />';
    } else {
        echo '<div class="w-full h-full flex items-center justify-center ' . $bg . '">';
        echo '<svg xmlns="http://www.w3.org/2000/svg" class="h-28 w-28 ' . $color . ' opacity-60" fill="none" viewBox="0 0 24 24" stroke="currentColor">' . $svg_path . '</svg>';
        echo '</div>';
    }
}
?>

<section id="about" class="py-20 bg-[#F2F2F2]">
    <div class="container mx-auto px-4 max-w-8xl">

        <h2 class="text-3xl md:text-4xl font-semibold text-center text-gray-900 mb-12">
            <?php echo esc_html($about_title); ?>
        </h2>

        <!-- ── Tabs Navigation ── -->
        <div class="relative mb-5">
            <!-- Línea base -->
            <div class="absolute bottom-0 left-0 w-full h-px bg-gray-200"></div>

            <div class="flex justify-between">

                <button class="tab-btn group flex-1 flex flex-col items-center gap-2 pb-4 focus:outline-none active" data-target="tab-what-is">
                    <span class="text-sm md:text-base font-semibold text-gray-500 group-[.active]:text-blue-600 transition-colors">
                        ¿Qué es?
                    </span>
                    <span class="w-0 group-[.active]:w-full h-0.5 bg-blue-600 rounded-full transition-all duration-300 absolute bottom-0"></span>
                </button>

                <button class="tab-btn group flex-1 flex flex-col items-center gap-2 pb-4 focus:outline-none" data-target="tab-mission">
                    <span class="text-sm md:text-base font-semibold text-gray-500 group-[.active]:text-blue-600 transition-colors">
                        Misión
                    </span>
                    <span class="w-0 group-[.active]:w-full h-0.5 bg-blue-600 rounded-full transition-all duration-300 absolute bottom-0"></span>
                </button>

                <button class="tab-btn group flex-1 flex flex-col items-center gap-2 pb-4 focus:outline-none" data-target="tab-principios">
                    <span class="text-sm md:text-base font-semibold text-gray-500 group-[.active]:text-blue-600 transition-colors">
                        Principios
                    </span>
                    <span class="w-0 group-[.active]:w-full h-0.5 bg-blue-600 rounded-full transition-all duration-300 absolute bottom-0"></span>
                </button>

                <button class="tab-btn group flex-1 flex flex-col items-center gap-2 pb-4 focus:outline-none" data-target="tab-history">
                    <span class="text-sm md:text-base font-semibold text-gray-500 group-[.active]:text-blue-600 transition-colors">
                        Historia
                    </span>
                    <span class="w-0 group-[.active]:w-full h-0.5 bg-blue-600 rounded-full transition-all duration-300 absolute bottom-0"></span>
                </button>

            </div>
        </div>

        <!-- ── Tabs Content ── -->
        <div class="relative">

            <!-- Tab 1: ¿Qué es? -->
            <div id="tab-what-is" class="tab-content active">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-0 rounded-xs overflow-hidden shadow-sm min-h-[600px]">
                    <!-- Imagen izquierda -->
                    <div class="relative min-h-[280px] md:min-h-full">
                        <?php about_render_image(
                            $img_what_is,
                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />',
                            'bg-blue-50', 'text-blue-400'
                        ); ?>
                    </div>
                    <!-- Texto derecha -->
                    <div class="bg-white p-10 flex flex-col justify-center">
                        <h3 class="text-3xl font-bold text-gray-900 mb-6">¿Qué es la<br>Defensoría Universitaria?</h3>
                        <p class="text-gray-600 leading-relaxed text-base">
                            <?php echo esc_html($about_what_is); ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Tab 2: Misión -->
            <div id="tab-mission" class="tab-content hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-0 rounded-xs overflow-hidden shadow-sm min-h-[600px]">
                    <div class="relative min-h-[280px] md:min-h-full">
                        <?php about_render_image(
                            $img_mission,
                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />',
                            'bg-green-50', 'text-green-400'
                        ); ?>
                    </div>
                    <div class="bg-white p-10 flex flex-col justify-center">
                        <h3 class="text-3xl font-bold text-gray-900 mb-6">Nuestra Misión</h3>
                        <p class="text-gray-600 leading-relaxed text-base">
                            <?php echo esc_html($about_mission); ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Tab 3: Principios -->
            <div id="tab-principios" class="tab-content hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-0 rounded-xs overflow-hidden shadow-sm min-h-[600px]">
                    <div class="relative min-h-[280px] md:min-h-full">
                        <?php about_render_image(
                            $img_principios,
                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />',
                            'bg-yellow-50', 'text-yellow-400'
                        ); ?>
                    </div>
                    <div class="bg-white p-10 flex flex-col justify-center">
                        <h3 class="text-3xl font-bold text-gray-900 mb-8">Nuestros Principios</h3>
                        <div class="flex flex-col gap-6">
                            <?php
                            $principios = [
                                ['valor' => $principio_1, 'color' => 'bg-blue-600',   'num' => '01'],
                                ['valor' => $principio_2, 'color' => 'bg-green-600',  'num' => '02'],
                                ['valor' => $principio_3, 'color' => 'bg-yellow-500', 'num' => '03'],
                            ];
                            foreach ($principios as $p) : ?>
                            <div class="flex items-center gap-5">
                                <span class="bg-[#141F40] text-white text-base font-bold w-18 h-16 rounded-xs flex items-center justify-center flex-shrink-0 shadow-sm">
                                    <?php echo $p['num']; ?>
                                </span>
                                <span class="text-2xl font-bold text-gray-900 tracking-tight">
                                    <?php echo esc_html($p['valor']); ?>
                                </span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 4: Historia -->
            <div id="tab-history" class="tab-content hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-0 rounded-xs overflow-hidden shadow-sm min-h-[600px]">
                    <div class="relative min-h-[280px] md:min-h-full">
                        <?php about_render_image(
                            $img_history,
                            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />',
                            'bg-gray-100', 'text-gray-400'
                        ); ?>
                    </div>
                    <div class="bg-white p-10 flex flex-col justify-center overflow-y-auto h-full">
                        <h3 class="text-3xl font-bold text-gray-900 mb-6">Nuestra Historia</h3>
                        <div class="prose prose-gray prose-base max-w-none">
                            <?php echo wp_kses_post($about_history); ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>