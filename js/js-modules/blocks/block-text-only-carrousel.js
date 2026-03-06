const startModule = (block)=>{
	block.classList.add('loaded');

    let clases;

    const slides = block.querySelectorAll('.carrousel-only-text__slide');
    const prevButton = block.querySelector('.carrousel-only-text__btn-prev');
    const nextButton = block.querySelector('.carrousel-only-text__btn-next');
    const pagination = block.querySelectorAll('.carrousel-only-text__slide-pagination');
    const totalSlides = slides.length;
    let currentIndex = 0;
    let autoplayInterval;
    const autoplay = true;
    const autoplaySpeed = 6000;

    const innerElement = block.querySelector('.block-text-only-carrousel__inner');

    const hasClassMulticolor = Array.from(innerElement.classList).some(clase => clase.startsWith('theme--multicolor'));

    if (hasClassMulticolor) {
        
        clases = ['theme--multicolor-mode-green', 'theme--multicolor-mode-blue', 'theme--multicolor-mode-pink'];
    } else {
        clases = ['theme--mode-light', 'theme--mode-bright', 'theme--mode-dark'];
    }

    if (totalSlides > 1) {
        prevButton.style.display = 'block';
        nextButton.style.display = 'block';
        pagination.forEach(info => info.style.display = 'block');
    }

    function setMaxHeight() {
        const container = block.querySelector('.carrousel-only-text__slides');
        if (slides.length === 0 || !container) return;

        slides.forEach(slide => slide.style.height = 'auto');

        const maxHeight = Math.max(...Array.from(slides).map(slide => slide.offsetHeight));
        slides.forEach(slide => slide.style.height = `${maxHeight}px`);
        container.style.height = `${maxHeight}px`;
    }

    setMaxHeight();
    window.addEventListener('resize', setMaxHeight);

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.style.opacity = i === index ? '1' : '0';
            slide.style.zIndex = i === index ? '1' : '-1';
            slide.setAttribute('aria-hidden', i !== index);
            slide.setAttribute('tabindex', i === index ? '0' : '-1');

            if (i === index) {
                slide.classList.add('carrousel-only-text__slide--active');
            } else {
                slide.classList.remove('carrousel-only-text__slide--active');
            }
        });

        innerElement.classList.remove(...clases);
        innerElement.classList.add(clases[index % clases.length]);

        currentIndex = index;
    }

    function handleSingleSlide() {
        slides[0].style.opacity = '1';
        slides[0].style.zIndex = '1';
        slides[0].setAttribute('aria-hidden', 'false');
        slides[0].setAttribute('tabindex', '0');
        slides[0].classList.add('carrousel-only-text__slide--active');
    }

    function nextSlide() {
        showSlide((currentIndex + 1) % totalSlides);
    }

    function prevSlide() {
        showSlide((currentIndex - 1 + totalSlides) % totalSlides);
    }

    function startAutoplay() {
        if (autoplay && totalSlides > 1) {
            autoplayInterval = setInterval(nextSlide, autoplaySpeed);
        }
    }

    function stopAutoplay() {
        if (autoplayInterval) clearInterval(autoplayInterval);
    }

    nextButton.addEventListener('click', () => {
        nextSlide();
        stopAutoplay();
    });

    prevButton.addEventListener('click', () => {
        prevSlide();
        stopAutoplay();
    });

    block.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowRight') {
            nextSlide();
            stopAutoplay();
        } else if (e.key === 'ArrowLeft') {
            prevSlide();
            stopAutoplay();
        }
    });

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                if (totalSlides <= 1) {
                    handleSingleSlide();
                } else {
                    showSlide(0);
                    startAutoplay();
                }
            } else {
                stopAutoplay();
            }
        });
    }, {
        threshold: 0.1
    });

    observer.observe(block);

}

export {startModule};