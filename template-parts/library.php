<?php
/**
 * Template Part: Biblioteca Virtual
 * CPT: documento | Taxonomía: categoria_documento
 * SCF Repeater: documento_versiones (version_numero, version_fecha, version_notas, version_archivo)
 */

// Include queries
include get_template_directory() . '/template-parts/library/library-queries.php';
?>

<section id="biblioteca" class="py-20 bg-gray-50">
    <div class="container mx-auto px-4 max-w-7xl">

        <h2 class="text-3xl md:text-4xl font-bold text-center text-gray-900 mb-4">
            Documentos
        </h2>
        <p class="text-center text-gray-500 mb-12">
            Documentos, reglamentos e informes de la Defensoría Universitaria
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