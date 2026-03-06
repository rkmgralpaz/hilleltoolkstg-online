/**
 * Block: Related Media Horizontal
 * 
 * Slider horizontal de recursos relacionados con navegación.
 * Consolida la funcionalidad que estaba duplicada en:
 * - globals.js (initRelatedMediaSliders)
 * - page-cards-single-v2.js (setupRelatedMediaSlider)
 * 
 * @param {HTMLElement} block - El elemento del módulo con clase .block-related-media-horizontal
 */
const setupRelatedMediaSlider = (block) => {
    const container = block.querySelector('.block-related-media-horizontal__resources');

    if (!container) {
        return;
    }

    const items = Array.from(container.querySelectorAll('.resource__card'));

    // Remover atributos de animación de las cards
    items.forEach(card => {
        card.removeAttribute('data-animate');
        card.removeAttribute('data-animate-delay');
        card.removeAttribute('data-animate-mode');
    });

    // Referencias a los elementos de navegación
    const prevBtn = block.querySelector('.block-related-media-horizontal__nav-btn--prev');
    const nextBtn = block.querySelector('.block-related-media-horizontal__nav-btn--next');
    const nav = block.querySelector('.block-related-media-horizontal__nav');
    const totalItems = items.length;

    /**
     * Determina cuántos items son visibles según el ancho de pantalla
     * @returns {number}
     */
    const getVisibleCount = () => {
        const width = window.innerWidth;
        let desired = 2;

        if (width <= 700) {
            desired = 1;
        } else if (width >= 1321) {
            desired = 3;
        }

        return Math.min(totalItems, desired);
    };

    /**
     * Calcula el máximo scroll horizontal disponible
     * @returns {number}
     */
    const getMaxScroll = () => Math.max(0, container.scrollWidth - container.clientWidth);

    /**
     * Actualiza la visibilidad de la navegación
     */
    const updateNavVisibility = () => {
        if (!nav) {
            return;
        }

        const noScroll = getMaxScroll() <= 1;
        nav.hidden = noScroll;

        if (noScroll) {
            nav.setAttribute('aria-hidden', 'true');
            nav.classList.add('block-related-media-horizontal__nav--hidden');
        } else {
            nav.removeAttribute('aria-hidden');
            nav.classList.remove('block-related-media-horizontal__nav--hidden');
        }
    };

    // Métricas calculadas
    let itemWidth = 0;
    let gap = 0;

    /**
     * Calcula las métricas de tamaño y gap
     */
    const computeMetrics = () => {
        if (!items.length) {
            itemWidth = 0;
            gap = 0;
            return;
        }

        const firstItem = items[0];
        itemWidth = firstItem.getBoundingClientRect().width;

        const styles = window.getComputedStyle(container);
        const gapValue = styles.columnGap || styles.gap || '0';
        gap = parseFloat(gapValue) || 0;
    };

    /**
     * Obtiene el tamaño de un "paso" (item + gap)
     * @returns {number}
     */
    const getStep = () => itemWidth + gap;

    /**
     * Limita un índice dentro de los límites válidos
     * @param {number} index
     * @returns {number}
     */
    const clampIndex = (index) => Math.max(0, Math.min(index, Math.max(0, totalItems - getVisibleCount())));

    /**
     * Obtiene el índice del primer item visible actualmente
     * @returns {number}
     */
    const getCurrentStart = () => {
        const step = getStep();
        if (!step) {
            return 0;
        }

        const visible = getVisibleCount();
        const pairSpan = step * visible;

        if (!pairSpan) {
            return 0;
        }

        const approxPair = container.scrollLeft / pairSpan;
        const pairIndex = Math.round(approxPair);

        return clampIndex(pairIndex * visible);
    };

    /**
     * Actualiza el estado (disabled) de los botones de navegación
     */
    const updateButtons = () => {
        const maxScroll = getMaxScroll();
        const noScroll = maxScroll <= 1;
        const atStart = container.scrollLeft <= 1;
        const atEnd = container.scrollLeft >= maxScroll - 1;

        if (prevBtn) {
            prevBtn.disabled = noScroll || atStart;
        }

        if (nextBtn) {
            const start = getCurrentStart();
            const visible = getVisibleCount();
            const reachedEndByIndex = start >= totalItems - visible;
            nextBtn.disabled = noScroll || atEnd || reachedEndByIndex;
        }
    };

    /**
     * Hace scroll a un índice específico
     * @param {number} index
     * @param {Object} options
     */
    const scrollToIndex = (index, { smooth = true } = {}) => {
        const step = getStep();
        if (!step) {
            return;
        }

        container.scrollTo({
            left: index * step,
            behavior: smooth ? 'smooth' : 'auto',
        });

        window.requestAnimationFrame(updateButtons);
    };

    /**
     * Handler del botón "Anterior"
     */
    const handlePrev = () => {
        computeMetrics();
        const currentStart = getCurrentStart();
        const targetIndex = clampIndex(currentStart - getVisibleCount());
        scrollToIndex(targetIndex);
    };

    /**
     * Handler del botón "Siguiente"
     */
    const handleNext = () => {
        computeMetrics();
        const currentStart = getCurrentStart();
        const targetIndex = clampIndex(currentStart + getVisibleCount());
        scrollToIndex(targetIndex);
    };

    // Inicialización
    computeMetrics();
    updateButtons();
    updateNavVisibility();

    // Event listener para scroll
    let scrollRaf = null;
    container.addEventListener('scroll', () => {
        if (scrollRaf) {
            return;
        }

        scrollRaf = window.requestAnimationFrame(() => {
            updateButtons();
            updateNavVisibility();
            scrollRaf = null;
        });
    });

    // Event listeners para los botones
    if (prevBtn) {
        prevBtn.addEventListener('click', handlePrev);
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', handleNext);
    }

    // Event listener para resize
    const handleResize = () => {
        computeMetrics();
        updateButtons();
        updateNavVisibility();
        const adjustedStart = clampIndex(getCurrentStart());
        scrollToIndex(adjustedStart, { smooth: false });
    };

    window.addEventListener('resize', handleResize);
};

/**
 * Inicializa el módulo (llamado automáticamente por main.js)
 * @param {HTMLElement} block - El elemento del bloque con clase .block-related-media-horizontal
 */
const startModule = (block) => {
    block.classList.add('loaded');
    setupRelatedMediaSlider(block);
};

export { startModule, setupRelatedMediaSlider };
