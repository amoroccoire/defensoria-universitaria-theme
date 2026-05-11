<?php 
$hero_images = [];
for ($i = 1; $i <= 5; $i++) {
    $img = get_theme_mod("hero_bg_$i");
    if ( !empty($img) ) {
        $hero_images[] = $img;
    }
}

if ( empty($hero_images) ) {
    $hero_images[] = get_template_directory_uri() . '/assets/images/du1.webp';
}

$total_images = count($hero_images);
?>

<section class="relative min-h-screen flex items-center justify-center bg-gray-900">
    <div class="absolute inset-0 z-0 bg-gray-900 overflow-hidden">

        <?php foreach ( $hero_images as $index => $url ) : ?>
            <img
                src="<?php echo esc_url($url); ?>"
                alt="Imagen Hero <?php echo $index + 1; ?>"
                class="absolute inset-0 w-full h-full object-cover opacity-90 
                <?php
                    if ( $total_images > 1 && $index > 0 ) {
                        echo 'animate-hero-carousel'; 
                    }
                ?>"
                style="<?php 
                    if ( $total_images > 1 && $index > 0 ) {
                        echo "animation-delay: " . ($index * 6) . "s;"; 
                    }
                ?>"
            />
        <?php endforeach; ?>
        <div class="absolute inset-0 bg-black/40 z-10"></div>
    </div>

    <!-- Main Content -->
    <div class="relative z-10 container mx-auto px-4 text-center -mt-50 md:-mt-18">
        <h1 class="text-start text-[2.5em]/11 md:text-[4em]/16 lg:text-[4em] text-white mb-8 drop-shadow-lg tracking-wide md:tracking-[0.12em] font-poppins font-bold">
            <?php echo esc_html(get_theme_mod('hero_title', 'DEFENSORÍA UNIVERSITARIA')); ?>
        </h1>
        <p class="text-start text-sm md:text-[1.2em] text-gray-200 font-poppins font-normal mb-5 md:mb-10 max-w-6xl drop-shadow-md tracking-wide">
            <?php echo esc_html(get_theme_mod('hero_subtitle', 'Defender tus derechos nos fortalece')); ?>
        </p>

        <?php 
        
        $show_button = get_theme_mod('hero_show_btn', true);
        $btn_text    = get_theme_mod('hero_btn_text', 'Presentar una queja');

        if ( $show_button && !empty($btn_text) ) : 
        ?>
            <div class="flex gap-4 justify-start">
                <a href="#contact" 
                class="px-3 md:px-8 py-3 bg-[#b90615] hover:bg-[#8C0712] text-white font-semibold shadow-lg transition-all transform hover:-translate-y-1 font-poppins text-[0.75rem] md:text-[1em]">
                    <?php echo esc_html($btn_text); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
    <?php
    get_template_part('template-parts/hero-cards');
    ?>
</section>
