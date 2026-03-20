// =============================================
// Módulo: Team
// Animación de aparición suave con IntersectionObserver
// =============================================

const revealItems = document.querySelectorAll('.reveal-item');

if (revealItems.length > 0) {
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    const el = entry.target;
                    const delay = el.style.getPropertyValue('--reveal-delay') || '0ms';

                    setTimeout(() => {
                        el.classList.add('revealed');
                    }, parseInt(delay));

                    observer.unobserve(el);
                }
            });
        },
        {
            threshold: 0.1,
            rootMargin: '0px 0px -40px 0px',
        }
    );

    revealItems.forEach((item) => observer.observe(item));
}