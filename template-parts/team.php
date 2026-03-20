<?php
/**
 * Template Part: Sección Equipo
 * CPT: miembro
 * Campos SCF: miembro_cargo, miembro_bio_short, miembro_orden,
 *             miembro_es_principal, miembro_es_exmiembro
 * Imagen: imagen destacada del post
 */

$miembros_query = new WP_Query([
    'post_type'      => 'miembro',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'orderby'        => 'menu_order title',
    'order'          => 'ASC',
]);

$principal   = null;
$secundarios = [];
$exmiembros  = [];

if ($miembros_query->have_posts()) {
    while ($miembros_query->have_posts()) {
        $miembros_query->the_post();

        $es_principal  = get_field('miembro_es_principal');
        $es_exmiembro  = get_field('miembro_es_exmiembro');

        if ($es_exmiembro) {
            $exmiembros[] = [
                'name'  => get_the_title(),
                'cargo' => get_field('miembro_cargo') ?: '',
            ];
        } elseif ($es_principal && $principal === null) {
            $principal = [
                'id'        => get_the_ID(),
                'name'      => get_the_title(),
                'cargo'     => get_field('miembro_cargo')     ?: '',
                'bio_short' => get_field('miembro_bio_short') ?: '',
                'image'     => get_the_post_thumbnail_url(get_the_ID(), 'large') ?: '',
            ];
        } else {
            $orden = get_field('miembro_orden') ?: 99;
            $secundarios[] = [
                'id'        => get_the_ID(),
                'name'      => get_the_title(),
                'cargo'     => get_field('miembro_cargo')     ?: '',
                'bio_short' => get_field('miembro_bio_short') ?: '',
                'orden'     => $orden,
                'image'     => get_the_post_thumbnail_url(get_the_ID(), 'medium') ?: '',
            ];
        }
    }
    wp_reset_postdata();
}

// Ordenar secundarios por campo miembro_orden
usort($secundarios, fn($a, $b) => $a['orden'] - $b['orden']);
?>

<section id="team" class="py-20 bg-white">
    <div class="container mx-auto px-4 max-w-6xl">

        <h2 class="text-3xl md:text-4xl font-bold text-center text-gray-900 mb-16">
            Nuestro equipo
        </h2>

        <?php if (!$principal && empty($secundarios) && empty($exmiembros)) : ?>
        <p class="text-center text-gray-500">No hay miembros del equipo publicados aún.</p>
        <?php else : ?>

        <div class="flex flex-col items-center space-y-16">

            <!-- ── Miembro principal ── -->
            <?php if ($principal) : ?>
            <div class="reveal-item w-full max-w-lg bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 hover:shadow-2xl transition-all duration-300">
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
                    <p class="text-gray-600">
                        <?php echo esc_html($principal['bio_short']); ?>
                    </p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- ── Miembros secundarios ── -->
            <?php if (!empty($secundarios)) : ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 w-full">
                <?php foreach ($secundarios as $i => $miembro) : ?>
                <div
                    class="reveal-item bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow overflow-hidden border border-gray-100"
                    style="--reveal-delay: <?php echo $i * 80; ?>ms"
                >
                    <div class="p-6 flex flex-col items-center text-center">

                        <!-- Número de orden -->
                        <!--<div class="self-start mb-3">
                            <span class="text-xs font-bold text-gray-300 tracking-widest">
                                /*<?php echo str_pad($miembro['orden'], 2, '0', STR_PAD_LEFT); ?>*/
                            </span>
                        </div>-->

                        <?php if ($miembro['image']) : ?>
                        <div class="w-28 h-28 rounded-full overflow-hidden mb-4 border-2 border-gray-200">
                            <img
                                src="<?php echo esc_url($miembro['image']); ?>"
                                alt="<?php echo esc_attr($miembro['name']); ?>"
                                class="w-full h-full object-cover"
                            />
                        </div>
                        <?php endif; ?>

                        <h4 class="text-lg font-bold text-gray-900">
                            <?php echo esc_html($miembro['name']); ?>
                        </h4>
                        <p class="text-blue-600 font-medium text-sm mb-3">
                            <?php echo esc_html($miembro['cargo']); ?>
                        </p>
                        <?php if ($miembro['bio_short']) : ?>
                        <p class="text-gray-500 text-sm line-clamp-2 leading-relaxed">
                            <?php echo esc_html($miembro['bio_short']); ?>
                        </p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- ── Extrabajadores ── -->
            <?php if (!empty($exmiembros)) : ?>
            <div class="reveal-item w-full">
                <div class="flex items-center gap-4 mb-8">
                    <div class="flex-grow h-px bg-gray-200"></div>
                    <h3 class="text-lg font-semibold text-gray-400 whitespace-nowrap">Anteriores colaboradores</h3>
                    <div class="flex-grow h-px bg-gray-200"></div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <?php foreach ($exmiembros as $ex) : ?>
                    <div class="flex flex-col items-center text-center p-4 rounded-xl hover:bg-gray-50 transition-colors">
                        <!-- Avatar placeholder con iniciales -->
                        <div class="w-12 h-12 rounded-full bg-gray-100 border border-gray-200 flex items-center justify-center mb-3 flex-shrink-0">
                            <span class="text-sm font-bold text-gray-400">
                                <?php
                                $words    = explode(' ', trim($ex['name']));
                                $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                                echo esc_html($initials);
                                ?>
                            </span>
                        </div>
                        <p class="text-sm font-semibold text-gray-600 leading-tight">
                            <?php echo esc_html($ex['name']); ?>
                        </p>
                        <p class="text-xs text-gray-400 mt-0.5">
                            <?php echo esc_html($ex['cargo']); ?>
                        </p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

        </div>
        <?php endif; ?>

    </div>
</section>