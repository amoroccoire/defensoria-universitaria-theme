// =============================================
// Módulo: About
// Tabs de la sección Conócenos
// =============================================

const tabButtons = document.querySelectorAll('.tab-btn');
const tabContents = document.querySelectorAll('.tab-content');

tabButtons.forEach((btn) => {
    btn.addEventListener('click', () => {
        tabButtons.forEach((b) => b.classList.remove('active'));
        btn.classList.add('active');

        tabContents.forEach((c) => {
            c.classList.add('hidden');
            c.classList.remove('active');
        });

        const targetId = btn.getAttribute('data-target');
        if (targetId) {
            const target = document.getElementById(targetId);
            target?.classList.remove('hidden');
            target?.classList.add('active');
        }
    });
});