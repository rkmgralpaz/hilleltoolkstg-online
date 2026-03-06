const startModule = (block) => {
    block.classList.add('loaded');


    const customSelectButton = block.querySelector('.custom-select-button-responsive');
    const selectElement = block.querySelector('#orderby');



    if (customSelectButton && selectElement) {
        // Evento para abrir el <select> al hacer clic en el botón
        customSelectButton.addEventListener('click', () => {
            selectElement.focus(); // Enfoca el <select>
            selectElement.click(); // Simula un clic para abrir el menú
        });

        // Redirigir al cambiar el valor del <select>
        selectElement.addEventListener('change', () => {
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            const targetUrl = selectedOption.getAttribute('data-url'); // Obtener la URL del atributo data-url

            if (targetUrl) {
                // Redirigir a la URL especificada
                window.location.href = targetUrl;
            }
        });
    }
};

export { startModule };


