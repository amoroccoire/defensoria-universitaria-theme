<!-- Datos para el módulo biblioteca.js -->
<?php
$docs_js = [];

if ( $docs_query->have_posts() ) {
    while ( $docs_query->have_posts() ) {
        $docs_query->the_post();
        $id = get_the_ID();

        $archivo_obj    = get_field( 'documento_archivo_actual', $id );
        $url_actual_raw = is_array( $archivo_obj ) ? ( $archivo_obj['url'] ?? '' ) : ( $archivo_obj ?: '' );
        $url_actual     = wp_http_validate_url( $url_actual_raw ) ? $url_actual_raw : '';
 
        $version_actual = [
            'numero' => sanitize_text_field( get_field( 'documento_numero_version', $id ) ?: 'v1.0.0' ),
            'fecha'  => sanitize_text_field( get_the_date( 'd/m/Y', $id ) ),
            'notas'  => wp_kses_post( get_field( 'documento_notas_version', $id ) ?: '' ),
            'url'    => $url_actual,
        ];

        $versiones_vinculadas = get_posts( [
            'post_type'      => 'documento',
            'posts_per_page' => -1,
            'orderby'        => 'date',
            'order'          => 'ASC',
            'meta_query'     => [ [
                'key'   => 'documento_padre',
                'value' => $id,
            ] ],
        ] );
 
        $history_js = [];
        foreach ( $versiones_vinculadas as $v ) {
            $v_archivo_obj = get_field( 'documento_archivo_actual', $v->ID );
            $v_url_raw     = is_array( $v_archivo_obj ) ? ( $v_archivo_obj['url'] ?? '' ) : ( $v_archivo_obj ?: '' );
            $v_url         = wp_http_validate_url( $v_url_raw ) ? $v_url_raw : '';
 
            $history_js[] = [
                'numero' => sanitize_text_field( get_field( 'documento_numero_version', $v->ID ) ?: 'v1.0.0' ),
                'fecha'  => sanitize_text_field( get_the_date( 'd/m/Y', $v->ID ) ),
                'notas'  => wp_kses_post( get_field( 'documento_notas_version', $v->ID ) ?: '' ),
                'url'    => $v_url,
            ];
        }

        $todas_las_versiones = array_merge( $history_js, [ $version_actual ] );
 
        // ── Categoria
        $cats_post = get_the_terms( $id, 'categoria_documento' );
        $cat_name  = ( ! empty( $cats_post ) && ! is_wp_error( $cats_post ) )
            ? sanitize_text_field( $cats_post[0]->name )
            : '';
 
        $docs_js[] = [
            'id'       => $id,
            'title'    => sanitize_text_field( get_the_title( $id ) ),
            'year'     => sanitize_text_field( get_the_date( 'Y', $id ) ),
            'category' => $cat_name,
            'versions' => $todas_las_versiones,
        ];
    }
    wp_reset_postdata();
}
 
$flags = JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP;
?>
<script>
window.BIBLIOTECA_DOCS        = <?php echo wp_json_encode( $docs_js, $flags ); ?>;
window.BIBLIOTECA_AJAX_URL    = "<?php echo esc_js( admin_url( 'admin-ajax.php' ) ); ?>";
window.BIBLIOTECA_NONCE       = "<?php echo esc_js( wp_create_nonce( 'load_more_docs_nonce' ) ); ?>";
window.BIBLIOTECA_CURRENT_PAGE = <?php echo intval( $paged ); ?>;
window.BIBLIOTECA_MAX_PAGES   = <?php echo intval( $docs_query->max_num_pages ); ?>;
window.BIBLIOTECA_CAT_FILTER  = "<?php echo esc_js( $cat_filter ); ?>";
window.BIBLIOTECA_YEAR_FILTER = <?php echo intval( $year_filter ); ?>;
window.CAT_COLORES = {
    'Boletines':       'bg-blue-100 text-blue-700 border-blue-200',
    'Informes':        'bg-purple-100 text-purple-700 border-purple-200',
    'Reglamentos':     'bg-amber-100 text-amber-700 border-amber-200',
    'Investigaciones': 'bg-emerald-100 text-emerald-700 border-emerald-200',
};
</script>