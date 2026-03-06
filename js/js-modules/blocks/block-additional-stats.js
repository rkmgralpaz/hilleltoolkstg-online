const startModule = (block) => {
  if (!block) return;
  block.classList.add('loaded');

  const modal = block.querySelector('.stat-modal');
  const modalTitle = modal?.querySelector('.stat-modal__title');
  const modalBody = modal?.querySelector('.stat-modal__body');
  const modalOverlay = modal?.querySelector('.stat-modal__overlay');
  const modalClose = modal?.querySelector('.stat-modal__close');

  // Mobile functionality (original - unchanged)
  block.querySelectorAll('.stat__more-info').forEach((btn) => {
    btn.addEventListener('click', () => {
      const stat = btn.closest('.stat');
      const tooltipContentEl = stat?.querySelector('.stat__tooltip-content');
      const tooltipContent = tooltipContentEl?.innerHTML || '';

      window.showIncidentsPopUp(tooltipContent, 1120);
    });
  });

  // Focus trap functionality
  const trapFocus = (e) => {
    if (modal?.getAttribute('aria-hidden') !== 'false') return;

    const focusableElements = modal.querySelectorAll(
      'a[href], button:not([disabled]), textarea:not([disabled]), input:not([disabled]), select:not([disabled]), [tabindex]:not([tabindex="-1"])'
    );

    const firstElement = focusableElements[0];
    const lastElement = focusableElements[focusableElements.length - 1];

    // If Tab pressed
    if (e.key === 'Tab') {
      // If Shift+Tab on first element, go to last
      if (e.shiftKey && document.activeElement === firstElement) {
        e.preventDefault();
        lastElement?.focus();
      }
      // If Tab on last element, go to first
      else if (!e.shiftKey && document.activeElement === lastElement) {
        e.preventDefault();
        firstElement?.focus();
      }
    }
  };

  // Desktop modal functionality
  const openDesktopModal = (title, content) => {
    // Only open modal on desktop (1120px and above)
    const isDesktop = window.innerWidth >= 1120;
    if (!modal || !modalBody || !modalTitle || !isDesktop) return;

    modalTitle.textContent = 'About ' + title;
    modalBody.innerHTML = content;
    modal.style.display = 'block';
    modal.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';

    // Focus on close button for accessibility
    setTimeout(() => modalClose?.focus(), 100);
  };

  const closeDesktopModal = () => {
    if (!modal) return;

    modal.style.display = 'none';
    modal.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
    modalTitle.textContent = '';
    modalBody.innerHTML = '';
  };

  // Desktop button clicks
  block.querySelectorAll('.stat__more-info-desktop').forEach((btn) => {
    btn.addEventListener('click', () => {
      const stat = btn.closest('.stat');
      const statTitle = stat?.querySelector('.stat__title')?.textContent || '';
      const tooltipContentEl = stat?.querySelector('.stat__tooltip-content');
      const content = tooltipContentEl?.innerHTML || '';

      openDesktopModal(statTitle, content);
    });
  });

  // Close modal events
  if (modalClose) {
    modalClose.addEventListener('click', closeDesktopModal);
  }

  if (modalOverlay) {
    modalOverlay.addEventListener('click', closeDesktopModal);
  }

  // Close on Escape key and trap focus
  document.addEventListener('keydown', (e) => {
    if (modal?.getAttribute('aria-hidden') === 'false') {
      if (e.key === 'Escape') {
        closeDesktopModal();
      }
      trapFocus(e);
    }
  });

  // Close modal on resize if viewport becomes smaller than 1120px
  window.addEventListener('resize', () => {
    const isDesktop = window.innerWidth >= 1120;
    if (!isDesktop && modal?.getAttribute('aria-hidden') === 'false') {
      closeDesktopModal();
    }
  });

  // Remove old hover/focus functionality
  // (This section is now removed)

  const adjustBarWidths = (block) => {
    if (!block) return;

    const columns = block.querySelectorAll('.stat__bars');
    columns.forEach((column) => {
      const bars = column.querySelectorAll('.stat__bar');
      const values = Array.from(bars).map(bar => parseFloat(bar.style.getPropertyValue('--value')) || 0);
      const maxValue = Math.max(...values);

      bars.forEach((bar) => {
        const originalValue = parseFloat(bar.style.getPropertyValue('--value')) || 0;
        const scaledValue = maxValue > 0 ? (originalValue / maxValue) * 100 : 0;
        bar.style.setProperty('--value', scaledValue);
      });
    });
  };

  const handleExternalValueClass = (block) => {
    if (!block) return;

    const bars = block.querySelectorAll('.stat__bar');

    bars.forEach(bar => {
      const barValue = parseInt(bar.style.getPropertyValue('--value')) || 0;
      const barWidth = bar.offsetWidth;

      // Si el ancho de la barra es menor a un umbral (por ejemplo, 20px),
      // se agrega la clase 'stat__bar--external-value'.
      if (barWidth < 20 && barValue > 0) {
        bar.classList.add('stat__bar--external-value');
      } else {
        bar.classList.remove('stat__bar--external-value');
      }
    });
  };

  adjustBarWidths(block);
  handleExternalValueClass(block);

  window.addEventListener('resize', () => {
    handleExternalValueClass(block);
  });
};


export { startModule };
