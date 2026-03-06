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

const startMetricGraphic = (block) => {

  function createSVGLine(svg, dataArray, maxValue = 100) {
    const svgWidth = 485;
    const svgHeight = 171;
    const padding = 25;
    
    // Limpiar el SVG
    svg.innerHTML = '';
    
    // Filtrar puntos válidos (no null)
    const validPoints = [];
    const positions = [0, 50, 100]; // Posiciones X en porcentaje
    
    dataArray.forEach((value, index) => {
      if (value !== null && value !== undefined) {
        validPoints.push({
            x: positions[index],
            y: value,
            originalIndex: index
        });
      }
    });
    
    if (validPoints.length === 0) {
        // Mostrar mensaje si no hay puntos válidos
        const text = document.createElementNS('http://www.w3.org/2000/svg', 'text');
        text.setAttribute('x', svgWidth / 2);
        text.setAttribute('y', svgHeight / 2);
        text.setAttribute('text-anchor', 'middle');
        text.setAttribute('fill', '#666');
        text.textContent = 'No hay puntos válidos para mostrar';
        svg.appendChild(text);
        return;
    }
    
    // Usar el valor máximo fijo para escalado
    const minY = 0; // Valor mínimo siempre 0
    const maxY = maxValue; // Valor máximo fijo
    
    // Crear función de escalado basada en el valor máximo fijo
    //const scaleX = (x) => (x / 100) * (svgWidth - 2 * padding) + padding;
    const scaleX = (x) => (x / 100) * svgWidth;
    const scaleY = (y) => svgHeight - padding - ((y - minY) / (maxY - minY)) * (svgHeight - 2 * padding);
    
    // Crear puntos escalados
    const scaledPoints = validPoints.map(point => ({
        x: scaleX(point.x),
        y: scaleY(point.y),
        originalValue: point.y,
        originalIndex: point.originalIndex
    }));
    
    // Dibujar línea si hay al menos 2 puntos
    if (scaledPoints.length >= 2) {
      const pathData = scaledPoints.map((point, index) => {
          return (index === 0 ? 'M' : 'L') + ` ${point.x} ${point.y}`;
      }).join(' ');
      
      const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
      path.setAttribute('d', pathData);
      path.setAttribute('stroke', '#332933');
      path.setAttribute('stroke-width', '6');
      path.setAttribute('fill', 'none');
      path.setAttribute('stroke-linecap', 'round');
      path.setAttribute('stroke-linejoin', 'round');
      path.setAttribute('vector-effect', 'non-scaling-stroke');
      svg.appendChild(path);
    }


    const currentYearStr = document.querySelector('.data-interactive-single__year.active').textContent.split(' ').join('').replace(/\n/g, '');
    const isFistYear = document.querySelectorAll('.data-interactive-single__year')[0].textContent.split(' ').join('').replace(/\n/g, '') == currentYearStr;
    
    // Dibujar puntos
    scaledPoints.forEach((point,i) => {
      const circle = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
      circle.setAttribute('cx', point.x);
      circle.setAttribute('cy', point.y);
      circle.setAttribute('r', '25');
      circle.setAttribute('fill', 'transparent');
      circle.setAttribute('stroke', '#C9C0BD');
      circle.setAttribute('stroke-width', '1');
      circle.setAttribute('vector-effect', 'non-scaling-stroke');
      if(isFistYear){
        circle.classList.add('first-year');
      }
      svg.appendChild(circle);

      let txtY = point.y + 50;
      if(Number(point.y) > svgHeight / 2){
        txtY = point.y - 40;
      }

      // Etiqueta con el valor
      const text = document.createElementNS('http://www.w3.org/2000/svg', 'text');
      text.setAttribute('x', point.x);
      text.setAttribute('y', txtY);
      text.setAttribute('text-anchor', 'middle');
      text.setAttribute('fill', '#332933');
      text.setAttribute('font-size', '14');
      text.removeAttribute('font-style', 'bold');
      text.textContent = currentYearStr;
      text.classList.add('font-body-sm');
      if(isFistYear){
        text.classList.add('first-year');
      }
      svg.appendChild(text);
    });
          
  }
  

  const metricGraphic = block.querySelector('.block-overview__metric-graphic');
  if(!!metricGraphic){
    const data = metricGraphic.dataset.value.split(',');
    const svg = metricGraphic.querySelector('svg');
    let dataArray = [];
    let max = Math.max(...data.map(Number));
    let min = Math.min(...data.filter(item => item !== '').map(Number));
    data.forEach(el => {
      if(el == ''){
        dataArray.push(null);
      }else{
        let percent = Math.round(100 / max * ((Number(el)-(min/2))));
        dataArray.push(percent);
      }
    });
    createSVGLine(svg, dataArray, 100);
    const offsetY = dataArray[1]-50;
    //svg.style.transform = `translateY(${offsetY}%)`;
    const point = svg.querySelector('circle:nth-of-type(2)');
  }

  block.querySelectorAll('.block-overview__metric--comparison .component-trend-data__percent').forEach(el => {
    el.textContent = formatThousands(el.textContent);
  });
}

function formatThousands(numberString, separator = ',') {
    let number = parseFloat(numberString.replace(/[^0-9.-]/g, ''));
    if (isNaN(number)) return numberString;
    //
    return number.toLocaleString('de-DE', {
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).replace('.', separator);
}


const startModule = (block) => {
  if (!block) return;
  block.classList.add('loaded');

  block.querySelectorAll('.block-overview__metric--value').forEach((element) => {
    const endValue = parseInt(element.textContent.replace(/,/g, ''), 10); // Eliminar separadores antes de parsear
    if (!isNaN(endValue)) {
      animateCounter(element, 0, endValue, 2000);
    }
  });

  startMetricGraphic(block);

};

export { startModule };
