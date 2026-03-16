// =============================================
// Módulo: Hero
// Cerrar banner flotante de eventos
// =============================================

const closeEventBanner = document.getElementById('close-event-banner');

closeEventBanner?.addEventListener('click', () => {
    closeEventBanner.closest('.animate-fade-in-up')?.remove();
});