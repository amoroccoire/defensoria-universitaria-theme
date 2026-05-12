<!-- Lista de documentos estilo Google Search -->
<div class="flex-grow">
    <div id="biblioteca-grid" class="flex flex-col divide-y divide-gray-100 mb-10">
        <?php if ($docs_query->have_posts()) : ?>
        <?php while ($docs_query->have_posts()) : $docs_query->the_post(); ?>
            <?php 
                $doc_data = defensoria_get_document_data(get_the_ID());
                
                get_template_part('template-parts/library/library-card', null, ['doc_data' => $doc_data]); 
            ?>
        <?php endwhile; wp_reset_postdata(); ?>
        <?php else : ?>
        <div class="text-center py-20">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <p class="text-gray-500 text-lg">No hay documentos disponibles aún.</p>
        </div>
        <?php endif; ?>
    </div>

    <!-- Paginación -->
    <div id="biblioteca-pagination-container" class="mt-12"> 
        <?php
            echo defensoria_render_pagination($docs_query->max_num_pages, $paged); 
        ?>
    </div>
</div>