<?php
/**
 * Template Name: Noticias y Eventos
 */

// Pasar la variable paged al query global para que funcione la paginación
if (get_query_var('paged')) {
    $paged = get_query_var('paged');
} elseif (get_query_var('page')) {
    $paged = get_query_var('page');
} else {
    $paged = 1;
}
set_query_var('paged', $paged);

get_header();
?>
<main>
    <?php get_template_part('template-parts/news'); ?>
</main>
<?php get_footer(); ?>