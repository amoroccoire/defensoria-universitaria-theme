<?php
$args = array(
    'post_type'      => 'hero_card',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'order'          => 'ASC',
);
$cards_query = new WP_Query($args);

if ( ! $cards_query->have_posts() ) return;

$total_posts = $cards_query->found_posts;
?>

<style>
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    
    .hero-cards-mask {
        mask-image: linear-gradient(to right, transparent, black 10%, black 100%);
        -webkit-mask-image: linear-gradient(to right, transparent, black 10%, black 100%);
    }
</style>

<div class="absolute bottom-10 right-0 z-30 w-[60rem] max-w-[95vw] md:block flex flex-col items-end hero-cards-container">
    <?php 
    if ($total_posts > 3) : 
    ?>
        <div class="flex gap-4 mr-8 mt-2 z-40 justify-end">
            <button id="hero-prev" class="w-12 h-12 rounded-full bg-white/10 hover:bg-white hover:text-black backdrop-blur-sm flex items-center justify-center text-white transition-all border border-white/20 hover:scale-105">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </button>
            <button id="hero-next" class="w-12 h-12 rounded-full bg-white/10 hover:bg-white hover:text-black backdrop-blur-sm flex items-center justify-center text-white transition-all border border-white/20 hover:scale-105">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>            
        </div>
    <?php endif; ?>

    <?php 
    $container_width = ($total_posts > 3) ? 'w-[13rem] md:w-[46rem]' : 'w-auto';
    $mask_class      = ($total_posts > 3) ? 'hero-cards-mask pl-1' : '';
    $flex_align      = ($total_posts <= 3) ? 'justify-end pr-4' : 'w-max pr-4';
    ?>
        <div class="overflow-x-auto scroll-smooth no-scrollbar <?php echo $container_width . ' ' . $mask_class; ?> md:pl-40 lg:pl-42 lg:ml-45" id="hero-cards-scroll">
        <div class="flex gap-4 py-4 <?php echo $flex_align; ?>">
            <?php

            while ( $cards_query->have_posts() ) : $cards_query->the_post();
                $link = get_field('url_destino') ?: '#';
                $img  = get_the_post_thumbnail_url(get_the_ID(), 'medium_large');

                $safe_link = $link;
                $safe_img  = $img ? esc_url($img) : '';
            ?>
                <a href="<?php echo esc_url($safe_link); ?>"
                target="_blank" rel="noopener noreferrer"
                class="relative flex-none w-[8rem] md:w-[10rem] aspect-[3/4] shrink-0 rounded-2xl overflow-hidden group transition-transform duration-500 hover:-translate-y-2 shadow-2xl">

                    <?php if ($safe_img) : ?>
                    <img src="<?php echo $safe_img; ?>"
                        class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                        alt="<?php echo esc_attr(get_the_title()); ?>">
                    <?php endif; ?>

                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-transparent to-transparent opacity-80 group-hover:opacity-0 transition-opacity duration-300"></div>

                    <div class="absolute inset-0 bg-black/60 flex flex-col justify-end p-6 translate-y-full group-hover:translate-y-0 transition-transform duration-300 ease-out">
                        <p class="text-white text-sm leading-snug mb-2 opacity-0 group-hover:opacity-100 transition-opacity delay-100">
                            <?php echo esc_html(get_the_excerpt()); ?>
                        </p>
                        <span class="text-xs text-blue-300 font-bold tracking-widest uppercase">Ver más →</span>
                    </div>

                    <div class="absolute bottom-6 left-6 right-6 group-hover:opacity-0 transition-opacity duration-200">
                        <h3 class="text-white text-xl font-bold leading-tight drop-shadow-lg">
                            <?php echo esc_html(get_the_title()); ?>
                        </h3>
                    </div>

                </a>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
     </div>
</div>

<?php
if ($total_posts > 3) : 
?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const scrollContainer = document.getElementById('hero-cards-scroll');
    const btnPrev = document.getElementById('hero-prev');
    const btnNext = document.getElementById('hero-next');
    
    if (btnPrev && btnNext && scrollContainer) {
        
        const getScrollAmount = () => {
            const firstCard = scrollContainer.querySelector('a');
            if (!firstCard) return 0;
            
            // 1. Obtenemos el tamaño del font-size raíz del navegador (usualmente 16)
            const rootFontSize = parseFloat(getComputedStyle(document.documentElement).fontSize);
            
            // 2. Calculamos el gap dinámicamente (gap-6 en Tailwind = 1.5rem)
            const gapInPixels = 1 * rootFontSize; 
            
            // 3. Retornamos el ancho real de la tarjeta + el gap
            return firstCard.offsetWidth + gapInPixels; 
        };

        btnPrev.addEventListener('click', () => {
            scrollContainer.scrollBy({ left: -getScrollAmount(), behavior: 'smooth' });
        });

        btnNext.addEventListener('click', () => {
            scrollContainer.scrollBy({ left: getScrollAmount(), behavior: 'smooth' });
        });
    }
});
</script>
<?php endif; ?>