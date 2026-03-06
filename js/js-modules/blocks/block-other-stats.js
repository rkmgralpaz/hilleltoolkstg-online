const animateCounter = (element, start, end, duration) => {
  let startTime = null;

  const step = (timestamp) => {
    if (!startTime) startTime = timestamp;
    const progress = Math.min((timestamp - startTime) / duration, 1);
    const value = Math.floor(progress * (end - start) + start);
    element.textContent = value.toLocaleString(); // Formatear con separadores de miles
    if (progress < 1) {
      window.requestAnimationFrame(step);
    }
  };

  window.requestAnimationFrame(step);
};

const startModule = (block) => {
  if (!block) return;
  block.classList.add('loaded');

  block.querySelectorAll('.other-stats__item').forEach((item) => {

    item.setAttribute('tabindex', '0');

    if (!item.classList.contains('no-description')) {
      const showTooltip = () => {
        const tooltip = item.querySelector('.stat__tooltip');
        if (tooltip) {
          tooltip.style.visibility = 'visible';
        }
      };

      const hideTooltip = () => {
        const tooltip = item.querySelector('.stat__tooltip');
        if (tooltip) {
          tooltip.style.visibility = 'hidden';
        }
      };

      const showPopup = () => {
        const tooltipContentEl = item.querySelector('.stat__tooltip-content');
        const tooltipContent = tooltipContentEl?.innerHTML || '';

        window.showIncidentsPopUp(`<div class='font-body-xs'>${tooltipContent}</div>`, 1120);
      };


      item.addEventListener('focus', () => {
        if (window.innerWidth > 1120) {
          showTooltip();
        }
      });

      item.addEventListener('blur', () => {
        if (window.innerWidth > 1120) {
          hideTooltip();
        }
      });

      item.addEventListener('keydown', (event) => {
        if (event.key === 'Enter' && window.innerWidth <= 1120) {
          event.preventDefault();
          showPopup();
        }
      });

      // Abrir popup al hacer clic en pantallas menores a 1120px
      item.addEventListener('click', () => {
        if (window.innerWidth < 1120) {
          showPopup();
        }
      });
    }
  });

  // Animar valores en other-stats__item-value
  block.querySelectorAll('.other-stats__item-value').forEach((element) => {
    const endValue = parseInt(element.textContent.replace(/,/g, ''), 10); // Eliminar separadores antes de parsear
    if (!isNaN(endValue)) {
      animateCounter(element, 0, endValue, 2000);
    }
  });
};

export { startModule };
