const startModule = (block) => {
  const isDesktop = window.innerWidth >= 1260;

  block.classList.add('loaded');

  block.querySelectorAll('.color-key__item').forEach((item) => {
    item.addEventListener('click', () => {
      const index = item.dataset.index;
      const segments = block.querySelectorAll('.block-incidents-by-type__bar-segment');
      const segment = segments[index];
      if (!segment) return;

      const tooltip = segment.querySelector('.block-incidents-by-type__tooltip--responsive');
      if (tooltip) {
        window.showIncidentsPopUp(tooltip.innerHTML, 1260);
      }
    });

    item.addEventListener('keydown', (e) => {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        item.click();
      }
    });
  });

  block.querySelectorAll('.block-incidents-by-type__bar-segment').forEach((segment) => {
    segment.addEventListener('focus', () => {
      segment.classList.add('is-focused');
    });

    segment.addEventListener('blur', () => {
      segment.classList.remove('is-focused');
    });
  });

  // Toggle percent visibility based on segment width (< 65px hides)
  const updatePercentVisibility = (block) => {
    const THRESHOLD = 65; // px
    const segments = block.querySelectorAll('.block-incidents-by-type__bar-segment');
    segments.forEach((segment) => {
      const percentEl = segment.querySelector('.block-incidents-by-type__bar-percent');
      if (!percentEl) return;

      const segWidth = segment.getBoundingClientRect().width;
      if (segWidth < THRESHOLD) {
        percentEl.classList.add('block-incidents-by-type__bar-percent--hidden');
      } else {
        percentEl.classList.remove('block-incidents-by-type__bar-percent--hidden');
      }
    });
  };

  const updateSegmentAccessibility = (block) => {
    const segments = block.querySelectorAll('.block-incidents-by-type__bar-segment');
    const isDesktop = window.innerWidth > 1260;

    segments.forEach((segment) => {
      if (isDesktop) {
        segment.setAttribute('tabindex', '0');
      } else {
        segment.removeAttribute('tabindex');
      }
    });
  };

  const updateColorKeyAccessibility = (block) => {
    const colorKeys = block.querySelectorAll('.color-key__item');
    const isMobile = window.innerWidth <= 1260;

    colorKeys.forEach((key) => {
      if (isMobile) {
        key.setAttribute('tabindex', '0');
      } else {
        key.removeAttribute('tabindex');
      }
    });
  };

  updateSegmentAccessibility(block);
  updateColorKeyAccessibility(block);
  updatePercentVisibility(block);

  // Resize handler (debounced) to recalc behaviors
  let resizeRaf;
  window.addEventListener('resize', () => {
    if (resizeRaf) cancelAnimationFrame(resizeRaf);
    resizeRaf = requestAnimationFrame(() => {
      updateSegmentAccessibility(block);
      updateColorKeyAccessibility(block);
      updatePercentVisibility(block);
    });
  });
};

export { startModule };
