const startModule = (block) => {

    block.classList.add('loaded');
   
    const btnNext = block.querySelector('.carousel__btn-next');
    const btnPrev = block.querySelector('.carousel__btn-prev');
    const carousel = block.querySelector('.carousel__main-wrapper');
    const imageHolders = block.querySelectorAll('.carousel__image-wrapper .carousel__image-holder');
    const carouselData = JSON.parse(block.getAttribute('data-carousel'));
    const imageHoldersAux = block.querySelectorAll('.carousel__image-wrapper-aux .carousel__image-holder');
    

    let index = 0;
    const delayAfterTransitionEnd = 100; 

    const getCircularIndex = (baseIndex, offset) => {
        const length = carouselData.length;
        return (baseIndex + offset + length) % length;
    }

    const updateCarouselImages = (i) => {
        [0, 1, 2, 3, 4].map((offset, idx) => {
            const imgIndex = getCircularIndex(i, offset - 2);
            imageHolders[idx].innerHTML = `<img src="${carouselData[imgIndex].image}" alt="Image ${imgIndex + 1}"><div class="carousel__image-caption font-body-sm theme__text--secondary">${carouselData[imgIndex].description}</div>`;

        });
    }

    const updateCarouselImagesAux = (i) => {
        [0, 1, 2, 3, 4].map((offset, idx) => {
            const imgIndex = getCircularIndex(i, offset - 2);
            imageHoldersAux[idx].innerHTML = `<img src="${carouselData[imgIndex].image}" alt="Image ${imgIndex + 1}"><div class="carousel__image-caption font-body-sm theme__text--secondary">${carouselData[imgIndex].description}</div>`;
        });
    }

    const removeCarouselImagesAux = () => {
        imageHoldersAux.forEach(holder => {
            holder.innerHTML = '';
        });
    };

    const showCaption = ()=>  {
        const caption = block.querySelector('.carousel__image-wrapper-3 .carousel__image-caption');
        if (caption) {
            caption.classList.add('carousel__image-caption--show');
        }
    }
    

    const handleTransition = (direction) => {
        btnNext.disabled = true;
        btnPrev.disabled = true;
        const transitionClass = `carousel__main-wrapper--transition-${direction}`;
        const wrappers = block.querySelectorAll('.carousel__image-wrapper');
        
        carousel.classList.add(transitionClass);
        
        let transitionsRemaining = wrappers.length;

        wrappers.forEach(wrapper => {
            wrapper.addEventListener('transitionend', function onTransitionEnd(event) {
                transitionsRemaining--;

                
                if (transitionsRemaining === 0) {
                    updateCarouselImagesAux(index); 
                    setTimeout(() => {
                        carousel.classList.remove(transitionClass);
                        updateCarouselImages(index); 

                        setTimeout(() => {
                            removeCarouselImagesAux();
                            btnNext.disabled = false;
                            btnPrev.disabled = false;

                            showCaption();
     
                        }, 100);
                        
                    }, delayAfterTransitionEnd);
                }

                wrapper.removeEventListener('transitionend', onTransitionEnd);
            });
        });
    }

    updateCarouselImages(0);
    showCaption();

    btnNext.addEventListener('click', function() {
        handleTransition('next');
        index = getCircularIndex(index, 1);
    });

    btnPrev.addEventListener('click', function() {
        handleTransition('prev');
        index = getCircularIndex(index, -1);
    });




//// A PARTIR DE AQUI, SE EJECUTA PARA MEDIA QUERY MENOR A 800PX  DE AQUI PARA ARRIBA, TODO ES MAYOR A 800PX, PODEMOS SEPARAR Y VALIDAR ?

let currentIndex = 0;
let slides = document.querySelectorAll('.carousel__responsive-slide');
let dotsContainer = document.querySelector('.navigation');

// Crear dinámicamente los bullet points en función de la cantidad de slides
function createDots() {
    for (let i = 0; i < slides.length; i++) {
        let dot = document.createElement('span');
        dot.classList.add('carousel__responsive-dot');
        dot.setAttribute('data-slide', i);  // Asociamos el índice del slide
        dot.addEventListener('click', function() {
            currentSlide(i + 1);  // Al hacer clic, navegamos al slide correspondiente
        });
        dotsContainer.appendChild(dot);
    }
}

function showSlide(index) {
    // Ocultar todas las diapositivas
    slides.forEach((slide, i) => {
        slide.style.display = 'none';
    });

    // Desactivar todos los bullet points
    let dots = document.querySelectorAll('.carousel__responsive-dot');
    dots.forEach((dot) => {
        dot.classList.remove('active');
    });

    // Mostrar la diapositiva actual
    slides[index].style.display = 'flex';
    dots[index].classList.add('active');
}

// Mover a una diapositiva específica
function currentSlide(n) {
    currentIndex = n - 1;
    showSlide(currentIndex);
}

// Soporte táctil para deslizar
let startX, endX;
document.querySelector('.carousel__responsive').addEventListener('touchstart', (e) => {
    startX = e.touches[0].clientX;
});

document.querySelector('.carousel__responsive').addEventListener('touchmove', (e) => {
    endX = e.touches[0].clientX;
});

document.querySelector('.carousel__responsive').addEventListener('touchend', () => {
    if (startX > endX + 50) {
        nextSlide();
    } else if (startX < endX - 50) {
        prevSlide();
    }
});

function nextSlide() {
    currentIndex = (currentIndex + 1) % slides.length;
    showSlide(currentIndex);
}

function prevSlide() {
    currentIndex = (currentIndex - 1 + slides.length) % slides.length;
    showSlide(currentIndex);
}

// Iniciar el slider
createDots();  // Generar los puntos de navegación dinámicamente
showSlide(0);  // Mostrar el primer slide

function setEqualCaptionHeights() {
    // Obtener todas las leyendas
    const captions = document.querySelectorAll('.carousel__responsive-slide-caption');

    // Reiniciar el alto antes de calcular el más alto (para evitar alturas fijas anteriores)
    captions.forEach(caption => {
        caption.style.height = 'auto';
    });

    // Calcular el mayor alto entre las leyendas
    let maxHeight = 0;
    captions.forEach(caption => {
        const height = caption.offsetHeight;
        if (height > maxHeight) {
            maxHeight = height;
        }
    });

    // Asignar el mayor alto a todas las leyendas
    captions.forEach(caption => {
        caption.style.height = `${maxHeight}px`;
    });
}

// Llamar la función al cargar la página
window.addEventListener('load', setEqualCaptionHeights);

// Llamar la función cada vez que se redimensione la ventana
window.addEventListener('resize', setEqualCaptionHeights);

//// HASTA AQUI

};

export { startModule };
