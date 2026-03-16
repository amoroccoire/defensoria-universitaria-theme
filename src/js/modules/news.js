// =============================================
// Módulo: News
// Carrusel de eventos con scroll dinámico
// =============================================

const carousel = document.getElementById('events-carousel');
const prevBtn = document.getElementById('prev-event');
const nextBtn = document.getElementById('next-event');

if (carousel && prevBtn && nextBtn) {
    const getScrollAmount = () => {
        const item = carousel.querySelector('div, a');
        if (item) {
            const gap = parseInt(window.getComputedStyle(carousel).gap) || 24;
            return item.offsetWidth + gap;
        }
        return 350;
    };

    prevBtn.addEventListener('click', () => {
        carousel.scrollBy({ left: -getScrollAmount(), behavior: 'smooth' });
    });

    nextBtn.addEventListener('click', () => {
        carousel.scrollBy({ left: getScrollAmount(), behavior: 'smooth' });
    });
}