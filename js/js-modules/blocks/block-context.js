const startModule = (block) => {
    block.classList.add('loaded');

    const AUTOPLAY_DELAY = 5000;
    const AUTOPLAY_ENABLED_ON_INIT = true;
    const PAUSE_ON_HOVER = true;
    const PAUSE_ON_MANUAL_INTERACTION = true;

    const totalItems = parseInt(block.dataset.totalItems) || 0;

    if (totalItems <= 1) {
        return;
    }

    const images = block.querySelectorAll('.block-context__image');
    const captions = block.querySelectorAll('.block-context__image-caption');
    const details = block.querySelectorAll('.block-context__detail-item');
    const detailsContainer = block.querySelector('.block-context__details');
    const dots = block.querySelectorAll('.block-context__dot');
    const prevBtn = block.querySelector('.block-context__prev');
    const nextBtn = block.querySelector('.block-context__next');
    const playPauseBtn = block.querySelector('.block-context__play-pause');

    // Calculate and set the height of details container based on tallest item
    const setDetailsHeight = () => {
        if (!detailsContainer || details.length === 0) return;

        // Remove min-height temporarily to get natural heights
        detailsContainer.style.minHeight = '';

        let maxHeight = 0;
        details.forEach(item => {
            // Temporarily make visible to measure
            const wasActive = item.classList.contains('is-active');
            if (!wasActive) {
                item.style.position = 'static';
                item.style.opacity = '0';
                item.style.visibility = 'hidden';
            }

            const height = item.offsetHeight;
            if (height > maxHeight) {
                maxHeight = height;
            }

            // Restore original state
            if (!wasActive) {
                item.style.position = '';
                item.style.opacity = '';
                item.style.visibility = '';
            }
        });

        // Set the container height
        if (maxHeight > 0) {
            detailsContainer.style.minHeight = maxHeight + 'px';
        }
    };

    // Call on init
    setDetailsHeight();

    // Recalculate on window resize
    let resizeTimeout;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(setDetailsHeight, 250);
    });

    // State
    let currentIndex = 0;
    let autoplayInterval = null;
    let isPlaying = AUTOPLAY_ENABLED_ON_INIT;

    // Go to specific slide
    const goToSlide = (index) => {
        // Remove active class from all
        images.forEach(img => img.classList.remove('is-active'));
        captions.forEach(cap => cap.classList.remove('is-active'));
        details.forEach(det => det.classList.remove('is-active'));
        dots.forEach(dot => dot.classList.remove('is-active'));

        // Add active class to current
        if (images[index]) images[index].classList.add('is-active');
        if (captions[index]) captions[index].classList.add('is-active');
        if (details[index]) details[index].classList.add('is-active');
        if (dots[index]) dots[index].classList.add('is-active');

        currentIndex = index;
    };

    // Next slide
    const nextSlide = () => {
        const next = (currentIndex + 1) % totalItems;
        goToSlide(next);
    };

    // Previous slide
    const prevSlide = () => {
        const prev = (currentIndex - 1 + totalItems) % totalItems;
        goToSlide(prev);
    };

    // Start autoplay
    const startAutoplay = () => {
        if (!isPlaying) return;
        stopAutoplay(); // Clear any existing interval
        autoplayInterval = setInterval(nextSlide, AUTOPLAY_DELAY);
    };

    // Stop autoplay
    const stopAutoplay = () => {
        if (autoplayInterval) {
            clearInterval(autoplayInterval);
            autoplayInterval = null;
        }
    };

    // Toggle play/pause
    const togglePlayPause = () => {
        isPlaying = !isPlaying;
        playPauseBtn.classList.toggle('is-paused', !isPlaying);

        if (isPlaying) {
            startAutoplay();
        } else {
            stopAutoplay();
        }
    };

    // Event listeners
    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            nextSlide();
            if (PAUSE_ON_MANUAL_INTERACTION) {
                stopAutoplay();
                isPlaying = false;
                playPauseBtn.classList.add('is-paused');
            }
        });
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            prevSlide();
            if (PAUSE_ON_MANUAL_INTERACTION) {
                stopAutoplay();
                isPlaying = false;
                playPauseBtn.classList.add('is-paused');
            }
        });
    }

    if (playPauseBtn) {
        playPauseBtn.addEventListener('click', togglePlayPause);
    }

    // Dots navigation
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            goToSlide(index);
            if (PAUSE_ON_MANUAL_INTERACTION) {
                stopAutoplay();
                isPlaying = false;
                playPauseBtn.classList.add('is-paused');
            }
        });
    });

    // Pause on hover (if enabled)
    if (PAUSE_ON_HOVER) {
        block.addEventListener('mouseenter', stopAutoplay);
        block.addEventListener('mouseleave', () => {
            if (isPlaying) startAutoplay();
        });
    }

    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (!block.classList.contains('loaded')) return;

        if (e.key === 'ArrowLeft') {
            prevSlide();
            if (PAUSE_ON_MANUAL_INTERACTION) {
                stopAutoplay();
                isPlaying = false;
                playPauseBtn.classList.add('is-paused');
            }
        } else if (e.key === 'ArrowRight') {
            nextSlide();
            if (PAUSE_ON_MANUAL_INTERACTION) {
                stopAutoplay();
                isPlaying = false;
                playPauseBtn.classList.add('is-paused');
            }
        }
    });

    // Start autoplay if enabled
    if (AUTOPLAY_ENABLED_ON_INIT) {
        startAutoplay();
    } else {
        playPauseBtn.classList.add('is-paused');
    }

    // Cleanup function for pause module
    block.pauseModule = () => {
        stopAutoplay();
    };

    // Resume function for play module
    block.playModule = () => {
        if (isPlaying) startAutoplay();
    };
};

export { startModule };
