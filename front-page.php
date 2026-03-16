<?php
/**
 * Template: Página Principal
 * Equivalente a index.astro
 */

get_header();
?>

<main>
    <?php get_template_part('template-parts/hero'); ?>
    <?php get_template_part('template-parts/about'); ?>
    <?php get_template_part('template-parts/services'); ?>
    <?php get_template_part('template-parts/contact'); ?>
</main>

<?php get_footer(); ?>