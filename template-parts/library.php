<?php
/**
 * Template Part: Biblioteca Virtual
 * CPT: documento | Taxonomía: categoria_documento
 */

// Include queries
require_once get_template_directory() . '/template-parts/library/library-queries.php';
$titulo_bilioteca = get_field('section_title') ?: 'Documentos';
$section_biblioteca   = get_field('section_description') ?: 'Documentos, reglamentos e informes de la Defensoría Universitaria';
?>

<section id="biblioteca" class="py-20 bg-gray-50">
    <div class="container mx-auto px-4 max-w-7xl">

        <h2 class="text-3xl md:text-4xl font-bold text-center text-gray-900 mt-10 mb-4">
            <?php echo esc_html($titulo_bilioteca); ?>
        </h2>
        <p class="text-center text-gray-500 mb-12">
            <?php echo esc_html($section_biblioteca); ?>
        </p>

        <?php include get_template_directory() . '/template-parts/library/library-search.php'; ?>

        <div class="flex flex-col lg:flex-row gap-8 items-start">

            <?php include get_template_directory() . '/template-parts/library/library-sidebar.php'; ?>
            <?php include get_template_directory() . '/template-parts/library/library-grid.php'; ?>

        </div>
    </div>
</section>

<?php include get_template_directory() . '/template-parts/library/library-modal.php'; ?>

<?php include get_template_directory() . '/template-parts/library/library-js-data.php'; ?>