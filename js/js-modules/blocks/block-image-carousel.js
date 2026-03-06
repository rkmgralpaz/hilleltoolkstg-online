const startModule = (block) => {

    block.classList.add('loaded');

    const handleDesktopSlider = () => {
        const btnNext = block.querySelector('.carousel__btn-next');
        const btnPrev = block.querySelector('.carousel__btn-prev');
        const carousel = block.querySelector('.carousel__main-wrapper');
        const imageHolders = block.querySelectorAll('.carousel__image-wrapper .carousel__image-holder');
        const imageHoldersAux = block.querySelectorAll('.carousel__image-wrapper-aux .carousel__image-holder');
        const carouselData = JSON.parse(block.getAttribute('data-carousel'));
        const wrappers = block.querySelectorAll('.carousel__image-wrapper');

        let index = 0;
        const delayAfterTransitionEnd = 100;
        let isTransitioning = false;

        const getCircularIndex = (baseIndex, offset) => {
            const length = carouselData.length;
            return (baseIndex + offset + length) % length;
        }

        // Nueva función que maneja tanto los contenedores principales como los auxiliares
        const updateCarouselImages = (i, holders) => {
            [0, 1, 2, 3, 4].forEach((offset, idx) => {
                const imgIndex = getCircularIndex(i, offset - 2);
                holders[idx].innerHTML = `<img src="${carouselData[imgIndex].image}" alt="Image ${imgIndex + 1}"><div class="carousel__image-caption font-body-sm theme__text--secondary">${carouselData[imgIndex].description}</div>`;
            });
        }

        const removeCarouselImagesAux = () => {
            imageHoldersAux.forEach(holder => {
                holder.innerHTML = '';
            });
        };

        const showCaption = () => {
            const caption = block.querySelector('.carousel__image-wrapper-3 .carousel__image-caption');
            if (caption) {
                caption.classList.add('carousel__image-caption--show');
            }
        }

        const handleTransition = (direction) => {
            if (isTransitioning) return false;

            isTransitioning = true;

            const transitionClass = `carousel__main-wrapper--transition-${direction}`;
            carousel.classList.add(transitionClass);

            let transitionsRemaining = wrappers.length;

            wrappers.forEach(wrapper => {
                wrapper.addEventListener('transitionend', function onTransitionEnd(event) {
                    transitionsRemaining--;

                    if (transitionsRemaining === 0) {
                        updateCarouselImages(index, imageHoldersAux);
                        setTimeout(() => {
                            carousel.classList.remove(transitionClass);
                            updateCarouselImages(index, imageHolders);

                            setTimeout(() => {
                                removeCarouselImagesAux();
                                btnNext.disabled = false;
                                btnPrev.disabled = false;
                                showCaption();
                            }, 100);

                            isTransitioning = false;
                        }, delayAfterTransitionEnd);
                    }

                    wrapper.removeEventListener('transitionend', onTransitionEnd);
                });
            });
        }

        updateCarouselImages(0, imageHolders);
        showCaption();

        btnNext.addEventListener('click', function () {
            if (handleTransition('next') === false) return;
            index = getCircularIndex(index, 1);
        });

        btnPrev.addEventListener('click', function () {
            if (handleTransition('prev') === false) return;
            index = getCircularIndex(index, -1);
        });
    };

    const handleMobileSlider = () => {
        let currentIndex = 0;
        let slides = document.querySelectorAll('.carousel__responsive-slide');
        let dotsContainer = document.querySelector('.navigation');

        function createDots() {
            dotsContainer.innerHTML = '';
            for (let i = 0; i < slides.length; i++) {
                let dot = document.createElement('span');
                dot.classList.add('carousel__responsive-dot');
                dot.setAttribute('data-slide', i);
                dot.addEventListener('click', function () {
                    currentSlide(i + 1);
                });
                dotsContainer.appendChild(dot);
            }
        }

        function showSlide(index) {
            slides.forEach((slide) => {
                slide.style.display = 'none';
            });

            let dots = document.querySelectorAll('.carousel__responsive-dot');
            dots.forEach((dot) => {
                dot.classList.remove('active');
            });

            slides[index].style.display = 'flex';
            dots[index].classList.add('active');
        }

        function currentSlide(n) {
            currentIndex = n - 1;
            showSlide(currentIndex);
        }

        let startX, endX;
        block.querySelector('.carousel__responsive').addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
        });

        block.querySelector('.carousel__responsive').addEventListener('touchmove', (e) => {
            endX = e.touches[0].clientX;
        });

        block.querySelector('.carousel__responsive').addEventListener('touchend', () => {
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

        createDots();
        showSlide(0);

        function setEqualCaptionHeights() {
            const captions = block.querySelectorAll('.carousel__responsive-slide-caption');

            captions.forEach(caption => {
                caption.style.height = 'auto';
            });

            let maxHeight = 0;
            captions.forEach(caption => {
                const height = caption.offsetHeight;
                if (height > maxHeight) {
                    maxHeight = height;
                }
            });

            captions.forEach(caption => {
                caption.style.height = `${maxHeight}px`;
            });
        }

        window.addEventListener('load', setEqualCaptionHeights);
        window.addEventListener('resize', setEqualCaptionHeights);
    };

    const checkWindowSize = () => {
        if (window.innerWidth > 1119) {
            handleDesktopSlider();
        } else {
            handleMobileSlider();
        }
    };

    checkWindowSize();
    window.addEventListener('resize', checkWindowSize);
};

export { startModule };
