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

<section class="relative min-h-screen flex items-center justify-center overflow-hidden bg-gray-900">
    <div class="absolute inset-0 z-0 bg-gray-900">

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
                    if ( $total_images > 2 && $index > 0 ) {
                        echo "animation-delay: " . ($index * 6) . "s;"; 
                    }
                ?>"
            />
        <?php endforeach; ?>
        <div class="absolute inset-0 bg-black/40 z-10"></div>
    </div>

    <!-- Main Content -->
    <div class="relative z-10 container mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-5xl lg:text-[55px] font-[480] text-white mb-16 drop-shadow-lg tracking-wider">
            <?php echo esc_html(get_theme_mod('hero_title', 'DEFENSORÍA UNIVERSITARIA')); ?>
        </h1>
        <p class="text-lg md:text-[30px] text-gray-100 font-normal mb-10 max-w-2xl mx-auto drop-shadow-md tracking-wide">
            <?php echo esc_html(get_theme_mod('hero_subtitle', 'Defender tus derechos nos fortalece')); ?>
        </p>

        <?php 
        
        $show_button = get_theme_mod('hero_show_btn', true);
        $btn_text    = get_theme_mod('hero_btn_text', 'Presentar una queja');

        if ( $show_button && !empty($btn_text) ) : 
        ?>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#contact" 
                class="px-8 py-3 bg-[#b90615] hover:bg-[#8C0712] text-white font-semibold rounded-sm shadow-lg transition-all transform hover:-translate-y-1">
                    <?php echo esc_html($btn_text); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>
