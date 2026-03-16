// =============================================
// Módulo: Team
// Toggle "Leer más / Leer menos" en tarjetas
// =============================================

document.querySelectorAll('.toggle-btn').forEach((btn) => {
    btn.addEventListener('click', () => {
        const mainDiv = btn.parentElement;
        const expandedDiv = mainDiv.nextElementSibling;
        const icon = btn.querySelector('svg');
        const label = btn.querySelector('span');

        if (expandedDiv) {
            expandedDiv.classList.toggle('hidden');
            const isOpen = !expandedDiv.classList.contains('hidden');
            label.textContent = isOpen ? 'Leer menos' : 'Leer más';
            icon?.classList.toggle('rotate-180', isOpen);
        }
    });
});