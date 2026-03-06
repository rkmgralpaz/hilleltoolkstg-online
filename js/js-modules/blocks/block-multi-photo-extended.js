
const startModule = (block) => {

    block.classList.add('loaded');

    const TOTAL_SLOTS = 7;
    const imageList = [];
    const imagesForPreload = block.querySelectorAll('.image-for-preload');
    const images = Array.from(block.querySelectorAll('.images__image'));

    // ── PREPARAR LISTA DE IMÁGENES ─────────────────────────────────────────
    block.querySelector('.images-for-preload').remove();
    imagesForPreload.forEach(el => imageList.push(el.dataset.src));

    // ── PRECARGAR IMÁGENES ──────────────────────────────────────────────────
    images.forEach((slotEl, i) => {
        const innerEl = slotEl.querySelector('.image__img');
        const src = imageList[i];
        if (!src) return;

        const img = new Image();
        img.onload = () => {
            innerEl.style.backgroundImage = `url(${src})`;
            innerEl.classList.add('image__img--loaded');
        };
        img.src = src;
    });

    const revealOrder = [0, 2, 4, 1, 3, 6, 5];
    const INITIAL_DELAY = 500;
    const STAGGER = 300;

    revealOrder.forEach((slotIndex, step) => {
        const slotEl = images[slotIndex];
        if (!slotEl) return;
        setTimeout(() => {
            slotEl.classList.add('images__image--visible');
        }, INITIAL_DELAY + step * STAGGER);
    });
};

export { startModule };
