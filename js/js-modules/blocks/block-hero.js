import { ImagePreloader } from '../utils.js';

const startModule = (block) => {
    block.classList.add('loaded');

    const imageContainers = block.querySelectorAll('.block-hero__image');

    imageContainers.forEach(container => {
        const images = container.querySelectorAll('.block-hero__image-bg');

        if (images.length === 0) return;

        let firstImageLoaded = false;

        // Precargar todas las imágenes
        images.forEach((element, index) => {
            new ImagePreloader(element.dataset.src, {
                onComplete: (data) => {
                    element.style.backgroundImage = `url('${data.src}')`;

                    if (index === 0 && !firstImageLoaded) {
                        firstImageLoaded = true;
                        element.classList.add('loaded');

                        // Esperar que la imagen se renderice completamente
                        setTimeout(() => {
                            container.classList.add('fade-in-initial');
                        }, 150);
                    }
                }
            });
        });

        // Si hay más de una imagen, iniciar slideshow automático
        if (images.length > 1) {
            let currentIndex = 0;
            // Obtener duración desde data attribute (en segundos) o usar 5 segundos por defecto
            const transitionDuration = (parseInt(container.dataset.transitionDuration) || 5) * 1000;

            setInterval(() => {
                // Calcular siguiente índice
                const nextIndex = (currentIndex + 1) % images.length;

                // Remover active de todas las imágenes excepto la actual
                images.forEach((img, idx) => {
                    if (idx !== currentIndex && idx !== nextIndex) {
                        img.classList.remove('active', 'loaded');
                    }
                });

                // Mostrar siguiente imagen por encima
                images[nextIndex].classList.add('active', 'loaded');

                // Después de la transición, ocultar la imagen anterior
                setTimeout(() => {
                    images[currentIndex].classList.remove('active', 'loaded');
                    currentIndex = nextIndex;
                }, 1000); // Esperar a que termine la transición (1s)
            }, transitionDuration);
        }
    });
};

export { startModule };