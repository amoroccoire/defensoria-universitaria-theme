<?php
/**
 * Header del tema Defensoría Universitaria - UNSA
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body class="font-sans antialiased <?php body_class(); ?>">
<?php wp_body_open(); ?>

<header
    class="bg-[#141F40] backdrop-blur-md shadow-md fixed w-full top-0 z-50 transition-all duration-300"
    id="main-header"
>
    <?php 
    $logo_unsa = get_theme_mod('logo_unsa', get_template_directory_uri() . '/assets/images/unsa-oficinas.png');
    $logo_oficina = get_theme_mod('logo_oficina', get_template_directory_uri() . '/assets/images/imagotipo_du_black.png');
    $office_name = get_theme_mod('header_oficina_nombre', 'Defensoría Universitaria');
    ?>

    <div class="container mx-auto px-4 lg:px-1 lg:py-4 flex justify-between items-center h-20 max-w-[1400px]">

        <!-- Logo & Brand -->
        <div class="flex items-center space-x-4">
            <a href="https://www.unsa.edu.pe/" target="_blank" rel="noopener noreferrer" class="flex items-center space-x-3 group">
                <img
                    src="<?php echo esc_url($logo_unsa); ?>"
                    alt="Logo UNSA"
                    class="h-18 w-auto object-contain transition-transform transform group-hover:scale-105"
                />
            </a>
            <a href="<?php echo home_url('/'); ?>" class="flex items-center space-x-3 group">
                <img
                    src="<?php echo esc_url($logo_oficina); ?>"
                    alt="Logo Defensoría UNSA"
                    class="h-16 w-auto object-contain transition-transform transform group-hover:scale-105"
                />
                <div class="hidden md:flex flex-col">
                    <span class="font-semibold text-white text-lg leading-tight group-hover:text-gray-400 transition-colors">
                        <?php echo esc_html($office_name); ?>
                    </span>
                    <span class="text-xs text-white font-light tracking-wide">UNSA</span>
                </div>
            </a>
        </div>

        <!-- Navigation & Mobile Menu Button -->
        <div class="flex items-center">
            <!-- Desktop Navigation -->
            <nav class="hidden lg:flex items-center space-x-1">
                <?php
                wp_nav_menu([
                    'theme_location' => 'primary',
                    'container'      => false,
                    'items_wrap'     => '%3$s',
                    'walker'         => new Oficina_Desktop_Walker(),
                    'fallback_cb'    => 'defensoria_nav_fallback',
                ]);
                ?>
            </nav>

            <!-- Mobile Menu Button -->
            <button id="mobile-menu-btn" class="lg:hidden p-2 text-white hover:text-gray-400 focus:outline-none ml-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div id="mobile-menu" class="hidden lg:hidden bg-white border-t border-gray-100 absolute w-full left-0 shadow-lg">
        <div class="container mx-auto px-4 py-4 flex flex-col space-y-2">
            <?php
            wp_nav_menu([
                'theme_location' => 'primary',
                'container'      => false,
                'items_wrap'     => '%3$s',
                'walker'         => new Oficina_Mobile_Walker(),
                'fallback_cb'    => false,
            ]);
            ?>
        </div>
    </div>
</header>

<?php
/**
 * Fallback: si aún no hay menú asignado en el admin,
 * muestra links básicos para que el sitio no quede vacío.
 */
function defensoria_nav_fallback() {
    $links = [
        'InicioTest'    => home_url('/'),
        'ConócenosTest' => home_url('/#about'),
        'ServiciosTest' => home_url('/#services'),
        'EquipoTest'    => home_url('/equipo'),
        'RecursosTest'  => home_url('/recursos'),
        'NoticiasTest'  => home_url('/noticias'),
        'ContactoTest'  => home_url('/#contact'),
    ];
    foreach ( $links as $name => $url ) {
        printf(
            '<a href="%s" class="nav-link px-4 py-2 text-white font-medium hover:text-gray-400 rounded-lg transition-colors relative group">%s<span class="absolute bottom-0 left-0 w-full h-0.5 bg-gray-400 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left"></span></a>',
            esc_url( $url ),
            esc_html( $name )
        );
    }
}
?>