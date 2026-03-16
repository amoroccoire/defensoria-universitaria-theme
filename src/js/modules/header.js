// =============================================
// Módulo: Header
// Mobile menu + Accesibilidad (contraste y fuente)
// =============================================

// --- Mobile Menu ---
const mobileMenuBtn = document.getElementById('mobile-menu-btn');
const mobileMenu = document.getElementById('mobile-menu');

mobileMenuBtn?.addEventListener('click', () => {
    mobileMenu?.classList.toggle('hidden');
});

// Cerrar el menú mobile al hacer click fuera
document.addEventListener('click', (e) => {
    if (
        mobileMenu &&
        !mobileMenu.classList.contains('hidden') &&
        !mobileMenu.contains(e.target) &&
        !mobileMenuBtn?.contains(e.target)
    ) {
        mobileMenu.classList.add('hidden');
    }
});

// --- Accesibilidad: Contraste alto ---
const htmlElement = document.documentElement;
const btnContrast = document.getElementById('btn-contrast');

btnContrast?.addEventListener('click', () => {
    htmlElement.classList.toggle('high-contrast');
    const isActive = htmlElement.classList.contains('high-contrast');
    localStorage.setItem('high-contrast', isActive ? 'true' : 'false');
});

// --- Accesibilidad: Tamaño de fuente ---
const fontSizes = ['', 'font-large', 'font-xl'];
let currentFontIndex = 0;
const btnFontSize = document.getElementById('btn-font-size');

btnFontSize?.addEventListener('click', () => {
    htmlElement.classList.remove(fontSizes[currentFontIndex] || 'dummy');
    currentFontIndex = (currentFontIndex + 1) % fontSizes.length;
    if (fontSizes[currentFontIndex]) {
        htmlElement.classList.add(fontSizes[currentFontIndex]);
    }
    localStorage.setItem('font-size', fontSizes[currentFontIndex]);
});

// --- Cargar preferencias guardadas ---
if (localStorage.getItem('high-contrast') === 'true') {
    htmlElement.classList.add('high-contrast');
}

const savedFontSize = localStorage.getItem('font-size');
if (savedFontSize && fontSizes.includes(savedFontSize)) {
    htmlElement.classList.add(savedFontSize);
    currentFontIndex = fontSizes.indexOf(savedFontSize);
}