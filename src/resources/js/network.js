document.addEventListener('DOMContentLoaded', () => {
    // Unificação de seletores para maior flexibilidade
    const photoTriggers = document.querySelectorAll('.btn-photo-trigger, #btn-photo-trigger');
    const uploadComponent = document.getElementById('upload-component');

    if (uploadComponent) {
        photoTriggers.forEach(trigger => {
            trigger.addEventListener('click', (e) => {
                e.preventDefault();
                // Alterna a classe d-none para mostrar/esconder o upload-component
                uploadComponent.classList.toggle('d-none');
            });
        });
    }
});