<?php
/**
 * Template Part: Noticias + Eventos
 * CPT noticias: grid 9 elementos con paginación
 * CPT eventos: carrusel con link a red social
 */

$paged = get_query_var('paged') ? get_query_var('paged') : 1;

$noticias_query = new WP_Query([
    'post_type'      => 'noticia',
    'posts_per_page' => 9,
    'paged'          => $paged,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
]);

$eventos_query = new WP_Query([
    'post_type'      => 'evento',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'orderby'        => 'meta_value',
    'meta_key'       => 'evento_fecha',
    'order'          => 'ASC',
]);

$titulo_noticias = get_field('noticia_title') ?: 'Noticias y eventos';
$desc_noticias   = get_field('noticia_description') ?: 'Mantente informado sobre las actividades de la Defensoría Universitaria';

$titulo_eventos  = get_field('eventos_title') ?: 'Eventos destacados';
$desc_eventos    = get_field('descripcion_eventos') ?: 'Participa en nuestras actividades y capacitaciones';
?>

<section id="news" class="py-20 bg-gray-50">
    <div class="container mx-auto px-4 max-w-7xl">

        <h2 class="text-3xl md:text-4xl font-bold text-center text-gray-900 mb-4">
            <?php echo esc_html($titulo_noticias); ?>
        </h2>
        <p class="text-center text-gray-500 mb-12"><?php echo esc_html($desc_noticias); ?></p>

        <?php if ($noticias_query->have_posts()) : ?>

        <!-- Grid de 9 noticias -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2 mb-12">
            <?php while ($noticias_query->have_posts()) : $noticias_query->the_post(); ?>
            <?php
                // Categorías
                $categorias = get_the_terms(get_the_ID(), 'categoria_noticia');
                $categoria  = (!empty($categorias) && !is_wp_error($categorias)) ? $categorias[0]->name : '';

                // Imagen destacada
                $imagen = get_the_post_thumbnail_url(get_the_ID(), 'large');

                // Excerpt — usa el resumen si existe, si no recorta el contenido
                $excerpt = get_the_excerpt();
                if (empty($excerpt)) {
                    $excerpt = wp_trim_words(get_the_content(), 20, '...');
                }
            ?>
            <article class="relative rounded-xs overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col h-[450px] group">
                <!-- Imagen de fondo -->
                <div class="absolute inset-0 w-full h-full">
                    <?php if ($imagen) : ?>
                    <img
                        src="<?php echo esc_url($imagen); ?>"
                        alt="<?php echo esc_attr(get_the_title()); ?>"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                    />
                    <?php else : ?>
                    <div class="w-full h-full bg-gray-800 flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Capa oscura para contraste -->
                <div class="absolute inset-0 bg-linear-to-t from-black/95 via-black/60 to-black/30 pointer-events-none"></div>

                <!-- Enlace que cubre toda la tarjeta -->
                <a href="<?php the_permalink(); ?>" target="_blank" class="absolute inset-0 z-30 block">
                    <span class="sr-only"><?php the_title(); ?></span>
                </a>

                <!-- Contenido encima de la imagen -->
                <div class="relative z-20 flex flex-col h-full p-6 text-left">
                    <!-- Categoría -->
                    <?php if ($categoria) : ?>
                        <div class="mt-4 mb-4">
                            <span class="bg-white text-gray-900 text-[10px] font-black uppercase tracking-widest px-2 py-3 shadow-md rounded-xs">
                                <?php echo esc_html($categoria); ?>
                            </span>
                        </div>
                    <?php else : ?>
                        <div class="mb-auto"></div>
                    <?php endif; ?>

                    <div class="mt-auto">
                        <!-- Fecha -->
                        <div class="flex items-center text-sm text-white mb-4 gap-2">
                            <?php echo get_the_date('d \d\e F, Y'); ?>
                        </div>

                        <!-- Título -->
                        <h4 class="text-xl font-bold text-white mb-6 line-clamp-2">
                            <?php the_title(); ?>
                        </h4>

                        <!-- Descripción -->
                        <p class="text-white text-sm mb-0 line-clamp-2 leading-relaxed mb-4">
                            <?php echo esc_html($excerpt); ?>
                        </p>
                    </div>
                </div>
            </article>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>

        <!-- Paginación -->
        <?php
        $total_pages = $noticias_query->max_num_pages;
        if ($total_pages > 1) :
        ?>
        <div class="flex justify-center items-center mt-4 space-x-2">

            <?php if ($paged > 1) : ?>
            <a href="<?php echo get_pagenum_link($paged - 1); ?>"
                class="inline-flex items-center justify-center w-10 h-10 rounded-xs border border-gray-300 text-gray-500 hover:bg-white hover:border-gray-400 hover:text-gray-700 transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                <?php if ($i === $paged) : ?>
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-xs bg-blue-600 text-white font-medium shadow-sm">
                    <?php echo $i; ?>
                </span>
                <?php elseif ($i === 1 || $i === $total_pages || abs($i - $paged) <= 1) : ?>
                <a href="<?php echo get_pagenum_link($i); ?>"
                    class="inline-flex items-center justify-center w-10 h-10 rounded-lg border border-gray-300 bg-white text-gray-700 hover:border-gray-400 hover:text-blue-600 transition-colors shadow-sm font-medium">
                    <?php echo $i; ?>
                </a>
                <?php elseif (abs($i - $paged) === 2) : ?>
                <span class="inline-flex items-center justify-center w-10 h-10 text-gray-500">...</span>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($paged < $total_pages) : ?>
            <a href="<?php echo get_pagenum_link($paged + 1); ?>"
                class="inline-flex items-center justify-center w-10 h-10 rounded-xs border border-gray-300 text-gray-500 hover:bg-white hover:border-gray-400 hover:text-gray-700 transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
            <?php endif; ?>

        </div>
        <?php endif; ?>

        <?php else : ?>
        <div class="text-center py-20">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 12h6" />
            </svg>
            <p class="text-gray-500 text-lg">No hay noticias publicadas aún.</p>
        </div>
        <?php endif; ?>

    </div>
</section>

<!--Carrusel de eventos-->
<?php if ($eventos_query->have_posts()) : ?>
<section id="eventos" class="pt-32 pb-48 bg-white border-t border-gray-200">
    <div class="container mx-auto px-4 max-w-7xl">
        <div class="relative overflow-hidden rounded-xl">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4"><?php echo esc_html($titulo_eventos); ?></h3>
                    <p class="text-gray-600 mb-2"><?php echo esc_html($desc_eventos); ?></p>
                </div>
                <div class="flex space-x-3 mt-6">
                    <button id="prev-event"
                        class="p-3 rounded-full border border-gray-200 bg-white text-gray-600 hover:bg-blue-50 hover:text-blue-600 hover:border-blue-200 transition-all shadow-sm focus:outline-none">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button id="next-event"
                        class="p-3 rounded-full border border-gray-200 bg-white text-gray-600 hover:bg-blue-50 hover:text-blue-600 hover:border-blue-200 transition-all shadow-sm focus:outline-none">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="relative overflow-hidden rounded-xl">
                <div id="events-carousel" class="flex gap-2 overflow-x-auto snap-x snap-mandatory pb-10 pt-4 px-2 mx-2 hide-scrollbar scroll-smooth">
                    <?php while ($eventos_query->have_posts()) : $eventos_query->the_post(); ?>
                    <?php
                        $evento_url   = get_field('evento_url');
                        $evento_lugar = get_field('evento_lugar') ?: '';
                        $evento_fecha = get_field('evento_fecha') ?: '';
                        $evento_badge = get_field('evento_badge') ?: '';
                        $evento_img   = get_the_post_thumbnail_url(get_the_ID(), 'large');

                        // Formatear fecha desde Date Time Picker (formato Y-m-d H:i:s)
                        $fecha_formateada = '';
                        if ($evento_fecha) {
                            $date_obj = DateTime::createFromFormat('d/m/Y h:i a', $evento_fecha);

                            if ($date_obj) {
                                $timestamp = $date_obj->getTimestamp();
                            } else {
                                $fecha_arreglada = str_replace('/', '-', $evento_fecha);
                                $timestamp = strtotime($fecha_arreglada);
                            }

                            //Generamos la fecha final en español
                            if ($timestamp) {
                                $fecha_formateada = date_i18n('j \d\e F • g:i A', $timestamp);
                            }
                        }

                        // Badge color según texto
                        $badge_colors = [
                            'EN CURSO'              => 'bg-green-100',
                            'PRÓXIMAMENTE'          => 'bg-purple-100',
                            'INSCRIPCIONES ABIERTAS'=> 'bg-red-100',
                            'FINALIZADO'            => 'bg-gray-100',
                        ];
                        $badge_class = $badge_colors[strtoupper($evento_badge)] ?? 'bg-blue-100';

                        // Destino del click
                        $link_href   = $evento_url ?: '#';
                        $link_target = $evento_url ? '_blank' : '_self';
                        $link_rel    = $evento_url ? 'noopener noreferrer' : '';
                    ?>
                    <a
                        href="<?php echo esc_url($link_href); ?>"
                        target="<?php echo esc_attr($link_target); ?>"
                        <?php echo $link_rel ? 'rel="' . esc_attr($link_rel) . '"' : ''; ?>
                        class="flex-shrink-0 w-[320px] md:w-[420px] snap-center relative rounded-xs shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group flex flex-col h-[500px]"
                    >
                        <!-- Imagen de fondo -->
                        <div class="absolute inset-0 w-full h-full">
                            <?php if ($evento_img) : ?>
                            <img
                                src="<?php echo esc_url($evento_img); ?>"
                                alt="<?php echo esc_attr(get_the_title()); ?>"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                            />
                            <?php else : ?>
                            <div class="w-full h-full bg-gray-800 flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <?php endif; ?>
                        </div>

                        <!-- Capa oscura para contraste -->
                        <div class="absolute inset-0 bg-linear-to-t from-black/95 via-black/70 to-black/30 pointer-events-none transition-opacity duration-300 group-hover:opacity-90"></div>

                        <!-- Contenido encima de la imagen -->
                        <div class="relative z-20 flex flex-col h-full p-6 text-left">
                            
                            <!-- Badge Top Right -->
                            <?php if ($evento_badge) : ?>
                            <div class="mt-4 mb-4">
                                <span class="bg-white text-gray-900 text-[10px] font-black uppercase tracking-widest px-2 py-3 shadow-md rounded-xs">
                                    <?php echo esc_html($evento_badge); ?>
                                </span>
                            </div>
                            <?php else : ?>
                            <div class="mb-5"></div>
                            <?php endif; ?>

                            <!-- Contenido Inferior -->
                            <div class="mt-12 mr-8">
                                <h4 class="text-xl font-bold text-white mb-3 leading-tight line-clamp-2">
                                    <?php the_title(); ?>
                                </h4>

                                
                                <div class="flex items-center text-sm text-gray-200 font-medium mb-2 gap-1.5">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <?php echo esc_html($fecha_formateada); ?>
                                </div>
                                

                                <?php if ($evento_lugar) : ?>
                                <div class="flex items-center text-sm text-gray-300 gap-1.5 mb-4">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span class="line-clamp-1"><?php echo esc_html($evento_lugar); ?></span>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Overlay extra e ícono de red social en hover (reemplazando al anterior para centrarlo adecuadamente) -->
                        <?php if ($evento_url) : ?>
                        <div class="absolute inset-0 z-30 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center bg-black/20 pointer-events-none">
                            <span class="bg-blue-600 text-white shadow-lg text-sm font-bold px-5 py-2.5 rounded-full flex items-center gap-2 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                                Ver evento
                            </span>
                        </div>
                        <?php endif; ?>
                    </a>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>