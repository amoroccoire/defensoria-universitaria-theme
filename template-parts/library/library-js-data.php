<!-- Datos para el módulo biblioteca.js -->
<script>
window.BIBLIOTECA_DOCS = <?php echo json_encode($docs_js, JSON_UNESCAPED_UNICODE); ?>;
window.BIBLIOTECA_AJAX_URL = "<?php echo admin_url('admin-ajax.php'); ?>";
window.BIBLIOTECA_NONCE = "<?php echo wp_create_nonce('load_more_docs_nonce'); ?>";
window.BIBLIOTECA_CURRENT_PAGE = <?php echo $paged; ?>;
window.BIBLIOTECA_MAX_PAGES = <?php echo $docs_query->max_num_pages; ?>;
window.BIBLIOTECA_CAT_FILTER = "<?php echo esc_js($cat_filter); ?>";
window.BIBLIOTECA_YEAR_FILTER = <?php echo intval($year_filter); ?>;
window.CAT_COLORES = {
    'Boletines':       'bg-blue-100 text-blue-700 border-blue-200',
    'Informes':        'bg-purple-100 text-purple-700 border-purple-200',
    'Reglamentos':     'bg-amber-100 text-amber-700 border-amber-200',
    'Investigaciones': 'bg-emerald-100 text-emerald-700 border-emerald-200',
};
</script>