// =============================================
// Módulo: Hero
// =============================================

const closeEventBanner = document.getElementById('close-event-banner');

closeEventBanner?.addEventListener('click', () => {
    closeEventBanner.closest('.animate-fade-in-up')?.remove();
});