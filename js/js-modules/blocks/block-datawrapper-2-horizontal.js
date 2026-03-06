const startModule = (block) => {

    block.classList.add('loaded');

    const ratio = parseFloat(block.dataset.ratio);

    function updateCircleSize() {
        const viewportWidth = window.innerWidth;

        let baseSize;
        if (viewportWidth >= 1728) {
            baseSize = 300; // in pixels
        } else if (viewportWidth >= 700) {
            baseSize = 236; // in pixels
        } else {
            baseSize = 164; // in pixels
        }

        const calculatedSize = Math.sqrt(Math.pow(baseSize, 2) * ratio);
        const sizeInPixels = `${calculatedSize*2}px`;

        const calculatedBaseSize = baseSize;
        const calculatedCalculatedSize = calculatedSize;

        const circleElement = block.querySelector('.block-datawrapper-2__item-circle');
        if (circleElement) {
            circleElement.style.width = sizeInPixels;
            circleElement.style.height = sizeInPixels;
        }
    }

    updateCircleSize();

    window.addEventListener('resize', updateCircleSize);
};

export { startModule };
