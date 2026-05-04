<?php
/**
 * Template: Vista individual de una Noticia
 * Archivo: single-noticia.php
 */

get_header();

if (have_posts()) :
    while (have_posts()) : the_post();

    // Datos del post
    $categorias = get_the_terms(get_the_ID(), 'categoria_noticia');
    $categoria  = (!empty($categorias) && !is_wp_error($categorias)) ? $categorias[0] : null;
    $imagen     = get_the_post_thumbnail_url(get_the_ID(), 'full');
?>

<main class="pt-24 pb-20 bg-white">
    <article class="max-w-3xl mx-auto px-4">

        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-sm text-gray-500 mb-8">
            <a href="<?php echo home_url('/'); ?>" class="hover:text-blue-600 transition-colors">Inicio</a>
            <span>/</span>
            <a href="<?php echo home_url('/noticias-y-eventos'); ?>" class="hover:text-blue-600 transition-colors">Noticias</a>
            <span>/</span>
            <span class="text-gray-700"><?php the_title(); ?></span>
        </nav>

        <!-- Fecha -->
        <div class="flex items-center gap-3 mb-4">
            <span class="text-sm text-gray-500 flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <?php echo get_the_date('d \d\e F, Y'); ?>
            </span>
        </div>

        <!-- Título -->
        <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 leading-tight mb-6">
            <?php the_title(); ?>
        </h1>

        <!-- Categoria -->
        <div class="flex items-center gap-3 mb-4">
            <?php if ($categoria) : ?>
                <span class="bg-blue-100 text-blue-800 text-xs font-bold px-3 py-1.5 rounded-xs">
                    <?php echo esc_html($categoria->name); ?>
                </span>
            <?php endif; ?>
        </div>

        <!-- Imagen destacada -->
        <?php if ($imagen) : ?>
        <figure class="mb-10 rounded-xs overflow-hidden shadow-lg">
            <img
                src="<?php echo esc_url($imagen); ?>"
                alt="<?php echo esc_attr(get_the_title()); ?>"
                class="w-full h-auto object-cover"
            />
        </figure>
        <?php endif; ?>

        <!-- Separador -->
        <div class="border-b border-gray-200 mb-10"></div>

        <!-- Contenido del artículo -->
        <div class="prose prose-lg prose-gray max-w-none
            prose-headings:font-bold prose-headings:text-gray-900
            prose-p:text-gray-700 prose-p:leading-relaxed
            prose-a:text-blue-600 prose-a:no-underline hover:prose-a:underline
            prose-img:rounded-xl prose-img:shadow-md prose-img:mx-auto
            prose-strong:text-gray-900
            prose-blockquote:border-blue-500 prose-blockquote:bg-blue-50 prose-blockquote:rounded-r-lg prose-blockquote:py-1">

            <?php the_content(); ?>
        </div>

        <!-- Separador inferior -->
        <div class="border-t border-gray-200 mt-12 pt-8">
            <a href="<?php echo home_url('/noticias-y-eventos'); ?>"
                class="inline-flex items-center text-blue-600 font-semibold hover:text-blue-800 transition-colors group">
                <svg class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                </svg>
                Volver
            </a>
        </div>

    </article>
</main>

<?php
    endwhile;
endif;

get_footer();
?>