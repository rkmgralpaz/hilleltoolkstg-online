import { system,ImagePreloader,helper, utils, recurringTabKey } from '../utils.js?v=032';
//
function preventOrphansHTML(html, options = {}) {
    const { allowLongWord = false, longWordMinLength = 12 } = options;

    // Extraer texto plano (sin etiquetas) para analizar palabras
    const temp = document.createElement("div");
    temp.innerHTML = html;
    const plainText = temp.textContent.trim().replace(/\s+/g, " ");
    const words = plainText.split(" ");
    
    if (words.length <= 2) return html; // 1 o 2 palabras no hace nada
    
    const lastWord = words[words.length - 1];
    // Permitir huérfana larga
    if (allowLongWord && lastWord.length >= longWordMinLength) {
        return html;
    }
    
    // Reemplazar último espacio fuera de etiquetas por non-breaking space
    return html.replace(/\s+([^\s<>]+)(\s*<\/[^>]+>\s*)*$/u, "\u00A0$1$2");
}
function preventOrphans(selector, options = {}) {
    const elements = !!selector ? [selector] : document.querySelectorAll(selector);
    elements.forEach(el => {
        el.innerHTML = preventOrphansHTML(el.dataset.originalHtml, options);
    });
}
const startMainGraphs = (block) => {
    //
    setTimeout(() => {
        //convierto a numéricos lo valores que viene como String desde php y a Null lo que vienen como "-"
        window.mainGraphsData.forEach(obj => {
            Object.keys(obj).forEach(key => {
                if (key === 'year') return; // omitimos year
                //
                if (obj[key] === '-') {
                    obj[key] = null;
                } else if (/^\d+$/.test(obj[key])) { // solo dígitos
                    obj[key] = Number(obj[key]);
                }
            });
        });
        startGraphIncidents(block);
        startGraphIncidentsSubtypes(block);
    }, 50);
    //
    block.querySelectorAll('.main-graphs__tabs').forEach(tabsParent => {
        const tabs = tabsParent.querySelectorAll('.main-graphs__tab');
        const toolTip = block.querySelector('.main-graphs__tabs-tooltip');
        let toolTipTimeout;
        //
        if(tabs.length){
            tabs.forEach(el => {
                el.addEventListener('mouseenter', e => {
                    showToolTip(e.target);
                });
                el.addEventListener('mouseleave', e => {
                    hideToolTip();
                });
                el.addEventListener('click', e => {
                    const target = document.getElementById(e.target.dataset.target);
                    tabs.forEach(elem => {
                        const graph = document.getElementById(elem.dataset.target);
                        elem.classList.remove('main-graphs__tab--selected');
                        graph.style.display = 'none';
                    });
                    target.style.display = 'block';
                    el.classList.add('main-graphs__tab--selected');
                    hideToolTip();
                    window.dispatchEvent(new Event('resize'));
                });
            });
            //
            function showToolTip(target){
                hideToolTip(target);
                //
                const tabsBCR = tabsParent.getBoundingClientRect();
                const targetBCR = target.getBoundingClientRect();
                toolTip.style.left = (targetBCR.left + targetBCR.width / 2 - tabsBCR.left)+'px';
                //
                toolTipTimeout = setTimeout(() => {
                    toolTip.classList.add('main-graphs__tabs-tooltip--visible');
                    toolTip.innerHTML = target.getAttribute('aria-label');
                }, 50);
            }
            function hideToolTip(){
                clearTimeout(toolTipTimeout);
                toolTip.innerHTML = '';
                toolTip.classList.remove('main-graphs__tabs-tooltip--visible');
                toolTip.style.left = 0;
            }
            //
            window.addEventListener('resize',hideToolTip);
            //
            tabs[0].click();
        }
    });
}
const startGraphIncidents = (block) => {
    block.querySelectorAll('.graph-incidents').forEach(graphIncidents => {

        const scroller = graphIncidents.querySelector('.graph-incidents__scroller');
        const svg = graphIncidents.querySelector('.graph-incidents__svg');
        const timelineLabels = graphIncidents.querySelector('.graph-incidents__timeline-labels');
        const progressBar = graphIncidents.querySelector('.graph-incidents__progress-bar');

        const data = window.mainGraphsData;

        data.forEach((el, i) => {
            if(i > 0){
                const prevNum = data[i-1].total;
                if(data[i-1].total == data[i].total){
                    el.percentFromPrevYear = 0;
                }else{
                    //el.percentFromPrevYear = Math.round((el.total / prevNum - 1) * 100);
                    let percentFromPrevYear = (el.total / prevNum - 1) * 100;
                    if(percentFromPrevYear % 1 === 0){
                        percentFromPrevYear = parseInt(percentFromPrevYear);
                    }else{
                        percentFromPrevYear = percentFromPrevYear.toFixed(1);
                    }
                    el.percentFromPrevYear = percentFromPrevYear;
                }
                //el.percentFromPrevYear = Math.round((el.total / prevNum - 1) * 100);
                //
                let othersValue = 0;
                //data[i].social_media_email - data[i].hate_speech - data[i].vandalism_graffiti - data[i].physical_harassment - data[i].assault;
                window.subtypeData.forEach((elem) => {
                    if(elem['name'] != 'others' && elem['name'] != 'all' && elem['name'] != 'total'){
                        othersValue += data[i][elem['name']];
                    }
                });
                data[i].others = data[i].total - othersValue;
                //
            }else{
                el.percentFromPrevYear = null;
                data[i].others = null;
            }
        });

        const width = 700;
        const height = 300;
        const paddingTB = 14;
        const paddingLR = 26;
        const segmentTransitionDuration = 600;
        const segmentIntervalDuration = 1500;
        const maxValue = Math.max(...data.map(d => d.total));

        let baselinePathEl, animPathEl;
        let currentSegment = 0;
        let isPlaying = false;
        let timeoutId;
        let animationFrameId;
        let segmentTransitionTime = 1;
        let segmentIntervalTime = 0;
        let usingKayboard = false;

        function mapX(index) {
            const step = (width - paddingLR * 2) / (data.length - 1);
            return paddingLR + index * step;
        }

        function mapY(value) {
            const usableHeight = height - paddingTB * 2;
            return paddingTB + usableHeight * (1 - value / maxValue);
        }

        function buildPath(points) {
            return points.map((pt, i) => `${i === 0 ? 'M' : 'L'}${pt.x},${pt.y}`).join(' ');
        }

        function createGraph() {
            const points = data.map((d, i) => ({ x: mapX(i), y: mapY(d.total), label: d.year }));

            // BASELINE
            const baselinePath = buildPath(points);
            baselinePathEl = document.createElementNS('http://www.w3.org/2000/svg', 'path');
            baselinePathEl.setAttribute('d', baselinePath);
            baselinePathEl.classList.add('graph-incidents__baseline');
            svg.appendChild(baselinePathEl);
            baselinePathEl.setAttribute("stroke-linecap", "round"); // <-- Esto redondea los extremos

            // ANIMATED LINE (starts at first point)
            animPathEl = document.createElementNS('http://www.w3.org/2000/svg', 'path');
            animPathEl.setAttribute('d', `M${points[0].x},${points[0].y}`);
            animPathEl.classList.add('graph-incidents__anim-line');
            animPathEl.setAttribute("stroke-linecap", "round"); // <-- Esto redondea los extremos
            svg.appendChild(animPathEl);

            // DOTS (keyboard accessible)
            points.forEach((pt, i) => {
                const circle = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
                circle.setAttribute('cx', pt.x);
                circle.setAttribute('cy', pt.y);
                circle.setAttribute('r', Math.min(700 * 6 / svg.clientWidth),6);
                circle.setAttribute('tabindex', '0');
                circle.setAttribute('aria-label', `${pt.label}: ${data[i].total}`);
                circle.classList.add('graph-incidents__dot');
                circle.dataset.index = i;
                //
                progressBar.insertAdjacentHTML('beforeend','<div class="graph-incidents__progress-bar-dot"></div>');
                //
                circle.addEventListener('click', e => {
                    //alert(`Click en ${pt.label}`);
                    showToolTip(e.target);
                    showToolTipMobile(e.target);
                    e.stopPropagation();
                });
                circle.addEventListener('mouseenter', e => {
                    showToolTip(e.target);
                });
                circle.addEventListener('mouseleave', e => {
                    hideToolTip();
                });
                circle.addEventListener('keydown', e => {
                    if (e.key === 'Enter' || e.key === ' ') {
                        showToolTip(e.target);
                        e.preventDefault();
                    }
                });
                circle.addEventListener('focus', e => {
                    showToolTip(e.target);
                });
                circle.addEventListener('blur', e => {
                    hideToolTip();
                });
                svg.appendChild(circle);
            });
            window.addEventListener('resize', e => {
                const value = Math.min(700 * 6 / svg.clientWidth, 6);
                hideToolTip(true);
                svg.querySelectorAll('circle').forEach(el => {
                    el.setAttribute('r', value);
                });
                labelsPositionX();
                scroller.scrollLeft = 2000;
            });

            // Timeline Labels aligned to dots
            timelineLabels.innerHTML = '';
            points.forEach((pt, i) => {
                const label = document.createElement('span');
                label.textContent = pt.label;
                //label.style.left = ( graphBCR.left + pt.x)+'px';
                label.addEventListener('click', e => {
                    const dots = graphIncidents.querySelectorAll('.graph-incidents__dot');
                    if(!!dots[i]){
                        const dotClick = new Event('click'); 
                        dots[i].dispatchEvent(dotClick);
                    }
                    e.stopPropagation();
                });
                label.addEventListener('mouseenter', e => {
                    const dots = graphIncidents.querySelectorAll('.graph-incidents__dot');
                    if(!!dots[i]){
                        const dotMouseenter = new Event('mouseenter'); 
                        dots[i].dispatchEvent(dotMouseenter);
                    }
                });
                label.addEventListener('mouseleave', e => {
                    const dots = graphIncidents.querySelectorAll('.graph-incidents__dot');
                    if(!!dots[i]){
                        const dotMouseleave = new Event('mouseleave'); 
                        dots[i].dispatchEvent(dotMouseleave);
                    }
                });
                timelineLabels.appendChild(label);
            });
            labelsPositionX();
        }

        function labelsPositionX(){
            const graphBCR = graphIncidents.getBoundingClientRect();
            const dots = svg.querySelectorAll('.graph-incidents__dot');
            const labels = graphIncidents.querySelectorAll('.graph-incidents__timeline-labels span');
            dots.forEach((el,i) => {
                const targetBCR = el.getBoundingClientRect();
                const half = labels[i].clientWidth / 2;
                let left = (targetBCR.left - graphBCR.left + targetBCR.width / 2);
                left += scroller.scrollLeft;
                if(i == 0 && left-half < 0){
                    left = half;
                }
                /* if(i == dots.length-1 && left+half > graphBCR.width){
                    left = Math.max(graphBCR.width-half, 800-half);
                } */
                /* if(i == dots.length-1 && left+half >  svg.clientWidth - half){
                    left = svg.clientWidth - half;
                } */
                //left += 'px';
                labels[i].style.left = left+'px';
                if(labels[i].textContent == '2022-2023'){
                    graphIncidents.querySelector('.graph-incidents__dotted-line').style.left = (left+12)+'px';
                }
                if(i == currentSegment){
                    pulse.style.left = (targetBCR.left - graphBCR.left + targetBCR.width / 2)+'px';
                    pulse.style.top = (targetBCR.top - graphBCR.top + targetBCR.height / 2)+'px';    
                }
            });
        }

        const pulse = graphIncidents.querySelector('.graph-incidents__pulse');

        function animateSegment(fromPt, toPt, duration, easingFunc, onComplete) {
            const startTime = performance.now();

            function animateFrame(now) {
                const elapsed = now - startTime;
                const t = Math.min(elapsed / duration, 1);
                const easedT = easingFunc(t);

                const currentX = fromPt.x + (toPt.x - fromPt.x) * easedT;
                const currentY = fromPt.y + (toPt.y - fromPt.y) * easedT;

                const existingD = animPathEl.getAttribute('d');
                const newD = existingD + ` L${currentX},${currentY}`;
                animPathEl.setAttribute('d', newD);

                if (t < 1) {
                    animationFrameId = requestAnimationFrame(animateFrame);
                    pulse.style.opacity = 0;
                } else {
                    if (onComplete) onComplete();
                    pulse.style.opacity = 1;
                }
            }
            animationFrameId = requestAnimationFrame(animateFrame);
        }

        function getEasingFunction(type) {
            switch (type) {
                case 'linear':
                    return t => t;
                case 'ease':
                case 'easeInOut':
                    // EaseInOut cubic (equivalente a CSS ease)
                    return t => t < 0.5
                        ? 4 * t * t * t
                        : 1 - Math.pow(-2 * t + 2, 3) / 2;
                case 'easeIn':
                    // EaseIn cubic
                    return t => t * t * t;
                case 'easeOut':
                    // EaseOut cubic
                    return t => 1 - Math.pow(1 - t, 3);
                default:
                    console.warn(`Easing type "${type}" not recognized. Falling back to linear.`);
                    return t => t;
            }
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

        function animateNumber(element, start, end, duration, extras = {}) {
            const startTime = performance.now();
            //
            function update(currentTime) {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1); // Va de 0 a 1

                const currentValue = (Number(start) + (Number(end) - Number(start)) * progress).toFixed(1);
                const appendChars = extras.appendChars ?? '';
                let textContent;
                if(extras.thousandsSeparator){
                    textContent = formatThousands(String(currentValue), extras.thousandsSeparator) + appendChars;
                }else{
                    textContent = currentValue + appendChars;
                }
                if(textContent == '0%' || textContent == '0.0%'){
                    textContent = textContent.split('0.0%').join('same').split('0%').join('same');
                }else if(textContent.indexOf('.0%') !== -1){
                    textContent = textContent.split('.0%').join('%');
                }

                element.textContent = textContent;

                if (progress < 1) {
                    requestAnimationFrame(update);
                }
            }
            //
            requestAnimationFrame(update);
        }

        function animateSegmentBySegment() {
            const fromPt = { x: mapX(currentSegment), y: mapY(data[currentSegment].total) };
            const toPt = { x: mapX(currentSegment + 1), y: mapY(data[currentSegment + 1].total) };
            //
            const dots = svg.querySelectorAll('.graph-incidents__dot');
            dots[0].classList.add('graph-incidents__dot--complete');
            controlsProgressBar(currentSegment + 1);
            //
            animateSegment(fromPt, toPt, segmentTransitionTime, getEasingFunction('easeOut'), () => {
                currentSegment++;
                dots[currentSegment].classList.add('graph-incidents__dot--complete');
                const graphBCR = graphIncidents.getBoundingClientRect();
                const targetBCR = dots[currentSegment].getBoundingClientRect();
                pulse.style.left = (targetBCR.left - graphBCR.left + targetBCR.width / 2)+'px';
                pulse.style.top = (targetBCR.top - graphBCR.top + targetBCR.height / 2)+'px';
                if (currentSegment < data.length - 1) {
                    timeoutId = setTimeout(animateSegmentBySegment, segmentIntervalTime);
                } else {
                    isPlaying = false;
                    pauseBtn.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M3.33398 3.32642C3.33398 2.67898 3.33398 2.35526 3.46898 2.17681C3.58658 2.02135 3.76633 1.92515 3.96092 1.91353C4.18427 1.9002 4.45363 2.07977 4.99233 2.4389L12.0027 7.11248C12.4478 7.40923 12.6704 7.55761 12.7479 7.74462C12.8158 7.90813 12.8158 8.09188 12.7479 8.25538C12.6704 8.4424 12.4478 8.59077 12.0027 8.88752L4.99233 13.5611C4.45363 13.9202 4.18427 14.0998 3.96092 14.0865C3.76633 14.0749 3.58658 13.9787 3.46898 13.8232C3.33398 13.6447 3.33398 13.321 3.33398 12.6736V3.32642Z" stroke="#121F41" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    `;
                }
            });
            let percentText = graphIncidents.querySelector('.graph-incidents__details-percent-text');
            let percentHolder = graphIncidents.querySelector('.graph-incidents__details-percent');
            percentHolder.classList.remove('graph-incidents__details-percent--hide');
            const numberElement = block.querySelector('.graph-incidents__details-number');
            animateNumber(numberElement, data[currentSegment].total ?? 0, data[currentSegment + 1].total, segmentTransitionTime, {thousandsSeparator:','});
            const percentNum = percentHolder.querySelector('.graph-incidents__details-percent-num');
            const percentElement = percentHolder.querySelector('.graph-incidents__details-percent-num-txt');
            animateNumber(percentElement, data[currentSegment].percentFromPrevYear ?? 0, data[currentSegment + 1].percentFromPrevYear, segmentTransitionTime, {appendChars:'%'});
            if(data[currentSegment + 1].percentFromPrevYear < 0){
                percentNum.classList.add('graph-incidents__details-percent-num--negative');
                percentNum.classList.remove('graph-incidents__details-percent-num--equal');
                percentText.classList.remove('graph-incidents__details-percent-text--equal');
            }else if(data[currentSegment + 1].percentFromPrevYear == 0){
                percentNum.classList.add('graph-incidents__details-percent-num--equal');
                percentNum.classList.remove('graph-incidents__details-percent-num--negative');
                percentText.classList.add('graph-incidents__details-percent-text--equal');
            }else{
                percentNum.classList.remove('graph-incidents__details-percent-num--negative');
                percentNum.classList.remove('graph-incidents__details-percent-num--equal');
                percentText.classList.remove('graph-incidents__details-percent-text--equal');
            }
            //console.log(percentNum)
            const period = graphIncidents.querySelector('.graph-incidents__details-period span');
            period.innerHTML = data[currentSegment + 1].year;
        }
            
        function controlsProgressBar(num){
            const selectedDot = graphIncidents.querySelector('.graph-incidents__progress-bar-dot--selected');
            if(!!selectedDot){
                selectedDot.classList.remove('graph-incidents__progress-bar-dot--selected');
            }
            const dots = graphIncidents.querySelectorAll('.graph-incidents__progress-bar-dot');
            if(!!dots[num]){
                dots[num].classList.add('graph-incidents__progress-bar-dot--selected');
            }
        }
        

        //Tooltip
        const toolTip = graphIncidents.querySelector('.graph-incidents__tooltip');
        const toolTipHolder = toolTip.querySelector('.graph-incidents__tooltip-holder');
        const toolTipBtn = toolTip.querySelector('.graph-incidents__tooltip-btn');
        let toolTipTarget;
        let toolTipTimeout;
        toolTip.addEventListener('mouseenter', e => {
            if(!!toolTipTarget){
                showToolTip(toolTipTarget);
            }
        });
        toolTip.addEventListener('mouseleave', e => {
            hideToolTip();
        });
        toolTip.addEventListener('click', e => {
            e.stopPropagation();
        });
        function showToolTip(target){
            if(!!toolTip){
                clearTimeout(toolTipTimeout);
                if(!!toolTipTarget && toolTipTarget != target){
                    hideToolTip(true);
                }
                toolTipTarget = target;
                toolTip.classList.remove('graph-incidents__tooltip--bottom');
                const prevHover = svg.querySelector('.graph-incidents__dot.hover');
                const graphBCR = graphIncidents.getBoundingClientRect();
                const targetBCR = target.getBoundingClientRect();
                let left = (targetBCR.left - graphBCR.left + targetBCR.width / 2);
                let width = toolTipHolder.clientWidth / 2;
                if(left - width < 0){
                    toolTipHolder.style.marginLeft = (width - targetBCR.left)+'px';
                }else if(left + width + graphBCR.left > window.innerWidth){
                    toolTipHolder.style.marginLeft = (window.innerWidth - width - left - graphBCR.left)+'px';
                }else{
                    toolTipHolder.style.marginLeft = 0;
                }
                toolTip.style.left = left+'px';
                toolTip.style.top = (targetBCR.top - graphBCR.top - 8)+'px';

                const holderBCR = toolTipHolder.getBoundingClientRect();
                if(holderBCR.top < 0){
                    toolTip.style.top = (targetBCR.top - graphBCR.top + 20)+'px';
                    toolTip.classList.add('graph-incidents__tooltip--bottom');
                }

                toolTip.classList.add('graph-incidents__tooltip--visible');
                toolTipTarget.classList.add('hover');
                if(!!prevHover && prevHover != toolTipTarget){
                    prevHover.classList.remove('hover');
                }
                const index = target.dataset.index;
                toolTip.querySelector('.graph-incidents__tooltip-period span').innerHTML = data[index].year;
                toolTip.querySelector('.graph-incidents__tooltip-number').innerHTML = formatThousands(String(data[index].total),',');
                toolTip.querySelector('.graph-incidents__tooltip-btn').setAttribute('href', String(window.location)+data[index].year+'/');
                const percentNum = toolTip.querySelector('.graph-incidents__tooltip-percent-num');
                if(data[index].percentFromPrevYear == null){
                    percentNum.classList.add('graph-incidents__tooltip-percent-num--hide');
                }else if(data[index].percentFromPrevYear < 0){
                    percentNum.classList.add('graph-incidents__tooltip-percent-num--negative');
                    percentNum.classList.remove('graph-incidents__tooltip-percent-num--equal');
                    percentNum.classList.remove('graph-incidents__tooltip-percent-num--hide');
                }else if(data[index].percentFromPrevYear == 0){
                    percentNum.classList.remove('graph-incidents__tooltip-percent-num--negative');
                    percentNum.classList.add('graph-incidents__tooltip-percent-num--equal');
                    percentNum.classList.remove('graph-incidents__tooltip-percent-num--hide');
                }else{
                    percentNum.classList.remove('graph-incidents__tooltip-percent-num--negative');
                    percentNum.classList.remove('graph-incidents__tooltip-percent-num--equal');
                    percentNum.classList.remove('graph-incidents__tooltip-percent-num--hide');
                }
                if(data[index].percentFromPrevYear == 0){
                    toolTip.querySelector('.graph-incidents__tooltip-percent-num-txt').innerHTML = '<span>same</span> as previous year';
                }else{
                    let percentFromPrevYear = String(data[index].percentFromPrevYear).split('.0').join('');
                    toolTip.querySelector('.graph-incidents__tooltip-percent-num-txt').innerHTML = '<span>'+percentFromPrevYear+'%</span> from previous year';
                }
            }
        }
        function hideToolTip(notDelay){
            if(!!toolTip && !!toolTipTarget && notDelay){
                toolTip.classList.remove('graph-incidents__tooltip--visible');
                toolTipTarget.classList.remove('hover');
                toolTip.classList.remove('graph-incidents__tooltip--bottom');
                toolTipTarget = null;
            }else if(!!toolTip && !!toolTipTarget){
                toolTipTimeout = setTimeout(() => {
                    toolTip.classList.remove('graph-incidents__tooltip--visible');
                    toolTipTarget.classList.remove('hover');
                    toolTip.classList.remove('graph-incidents__tooltip--bottom');
                    toolTipTarget = null;
                }, 1500);
            }
        }
        document.addEventListener('click', e => {
            hideToolTip(true);
        });
        document.addEventListener('mousedown', e => {
            document.body.classList.remove('using-tab')
        });
        document.addEventListener('keyup', e => {
            if(e.key == 'Tab'){
                document.body.classList.add('using-tab');
            }
        });

        function showToolTipMobile(target){
            //alert(data[target.dataset.index].total);
            const html = `
            <div class='graph-incidents__tooltip-holder font-body-md'>
            ${toolTipHolder.innerHTML}
            </div>
            `;
            window.showIncidentsPopUp(html);
        }

        //Controls

        function play() {
            if (isPlaying) return;
            svg.classList.add('graph-incidents__svg--started');
            if (currentSegment >= data.length - 1) {
                reset();
            }else{
                isPlaying = true;
                animateSegmentBySegment();
                if(!!pauseBtn){
                    pauseBtn.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M4.44531 2L4.44531 14.0001" stroke="#332933" stroke-width="1.5" stroke-linecap="round"/>
                        <path d="M11.5547 2L11.5547 14.0001" stroke="#332933" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                    `;
                }
            }
        }

        function pause() {
            isPlaying = false;
            clearTimeout(timeoutId);
            cancelAnimationFrame(animationFrameId);
            clearTimeout(resetTimeout);
            if(!!pauseBtn){
                pauseBtn.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <path d="M3.33398 3.32642C3.33398 2.67898 3.33398 2.35526 3.46898 2.17681C3.58658 2.02135 3.76633 1.92515 3.96092 1.91353C4.18427 1.9002 4.45363 2.07977 4.99233 2.4389L12.0027 7.11248C12.4478 7.40923 12.6704 7.55761 12.7479 7.74462C12.8158 7.90813 12.8158 8.09188 12.7479 8.25538C12.6704 8.4424 12.4478 8.59077 12.0027 8.88752L4.99233 13.5611C4.45363 13.9202 4.18427 14.0998 3.96092 14.0865C3.76633 14.0749 3.58658 13.9787 3.46898 13.8232C3.33398 13.6447 3.33398 13.321 3.33398 12.6736V3.32642Z" stroke="#121F41" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                `;
            }
        }

        let resetTimeout;
        function reset() {
            clearTimeout(resetTimeout);
            segmentTransitionTime = segmentTransitionDuration;
            segmentIntervalTime = segmentIntervalDuration;
            pause();
            currentSegment = 0;
            svg.querySelectorAll('.graph-incidents__dot').forEach(el => {
                el.classList.remove('graph-incidents__dot--complete');
            });
            animPathEl.setAttribute('d', `M${mapX(0)},${mapY(data[0].total)}`);
            //
            /* const graphBCR = graphIncidents.getBoundingClientRect();
            const dots = svg.querySelectorAll('.graph-incidents__dot');
            const targetBCR = dots[0].getBoundingClientRect();
            pulse.style.left = (targetBCR.left - graphBCR.left + targetBCR.width / 2)+'px';
            pulse.style.top = (targetBCR.top - graphBCR.top + targetBCR.height / 2)+'px';    
            pulse.style.opacity = 1; */
            setFirstNode();
        }
        const resetBtn = graphIncidents.querySelector('.reset-btn');
        if(!!resetBtn){
            resetBtn.addEventListener('click', reset);
        }

        function setFirstNode(){
            play();
            currentSegment = 0;
            const dots = svg.querySelectorAll('.graph-incidents__dot');
            dots[0].classList.add('graph-incidents__dot--complete');
            controlsProgressBar(currentSegment);
            const numberElement = graphIncidents.querySelector('.graph-incidents__details-number');
            animateNumber(numberElement, data[currentSegment].total ?? 0, data[currentSegment].total, segmentTransitionTime, {thousandsSeparator:','});
            const period = graphIncidents.querySelector('.graph-incidents__details-period span');
            period.innerHTML = data[currentSegment].year;

            const percentElement = graphIncidents.querySelector('.graph-incidents__details-percent-num-txt');
            graphIncidents.querySelector('.graph-incidents__details-percent').classList.add('graph-incidents__details-percent--hide');
            animateNumber(percentElement, 0, 0, segmentTransitionTime, {appendChars:'%'});
            pulse.style.opacity = 1;
            const graphBCR = graphIncidents.getBoundingClientRect();
            const targetBCR = dots[currentSegment].getBoundingClientRect();
            pulse.style.left = (targetBCR.left - graphBCR.left + targetBCR.width / 2)+'px';
            pulse.style.top = (targetBCR.top - graphBCR.top + targetBCR.height / 2)+'px';

            clearTimeout(timeoutId);
            cancelAnimationFrame(animationFrameId);
            resetTimeout = setTimeout(() => {
                isPlaying = true;
                animateSegmentBySegment();
            }, segmentIntervalDuration);
        }

        function setLastNode(){

            currentSegment = data.length - 1;
            const dots = svg.querySelectorAll('.graph-incidents__dot');
            const progressBarDots = progressBar.querySelectorAll('.graph-incidents__progress-bar-dot');
            progressBarDots[progressBarDots.length-1].classList.add('graph-incidents__progress-bar-dot--selected');
            dots.forEach((el, i) => {
                el.classList.add('graph-incidents__dot--complete');
            });
            isPlaying = false;
            const graphBCR = graphIncidents.getBoundingClientRect();
            const targetBCR = dots[currentSegment].getBoundingClientRect();
            pulse.style.left = (targetBCR.left - graphBCR.left + targetBCR.width / 2)+'px';
            pulse.style.top = (targetBCR.top - graphBCR.top + targetBCR.height / 2)+'px';
            pulse.style.opacity = 1;
            const numberElement = block.querySelector('.graph-incidents__details-number');
            animateNumber(numberElement, data[currentSegment].total ?? 0, data[currentSegment].total, segmentTransitionTime, {thousandsSeparator:','});
            const percentElement = block.querySelector('.graph-incidents__details-percent-num-txt');
            const percentText = block.querySelector('.graph-incidents__details-percent-text');
            animateNumber(percentElement, data[currentSegment].percentFromPrevYear ?? 0, data[currentSegment].percentFromPrevYear, segmentTransitionTime, {appendChars:'%'});
            if(data[currentSegment].percentFromPrevYear < 0){
                percentElement.parentNode.classList.add('graph-incidents__details-percent-num--negative');
                percentElement.parentNode.classList.remove('graph-incidents__details-percent-num--equal');
                percentText.classList.remove('graph-incidents__details-percent-text--equal');
            }else if(data[currentSegment].percentFromPrevYear == 0){
                percentElement.parentNode.classList.remove('graph-incidents__details-percent-num--negative');
                percentElement.parentNode.classList.add('graph-incidents__details-percent-num--equal');
                percentText.classList.add('graph-incidents__details-percent-text--equal');
            }else{
                percentElement.parentNode.classList.remove('graph-incidents__details-percent-num--negative');
                percentElement.parentNode.classList.remove('graph-incidents__details-percent-num--equal');
                percentText.classList.remove('graph-incidents__details-percent-text--equal');
            }
            const period = graphIncidents.querySelector('.graph-incidents__details-period span');
            period.innerHTML = data[currentSegment].year;
        }

        const pauseBtn = graphIncidents.querySelector('.pause-btn');
        if(!!pauseBtn){
            pauseBtn.addEventListener('click', e => {
                if(isPlaying){
                    pause();
                }else{
                    play();
                }
            });
        }

        // Init
        createGraph();
        setLastNode();//solo para desktop
        scroller.scrollLeft = 2000;//solo para movil (mueve el scroll al final del gráfico)
        setTimeout(() => {
            scroller.before(graphIncidents.querySelector('.graph-incidents__details-wrapper'));
        },200)        
    });
}

const startGraphIncidentsSubtypes = (block) => {
    block.querySelectorAll('.graph-incidents-subtypes').forEach(graphSubtypes => {

        const scroller = graphSubtypes.querySelector('.graph-incidents-subtypes__scroller');
        const svg = graphSubtypes.querySelector('.graph-incidents-subtypes__svg');
        const timelineLabels = graphSubtypes.querySelector('.graph-incidents-subtypes__timeline-labels');
        const solidLine = graphSubtypes.querySelector('.graph-incidents-subtypes__solid-line');
        const dottedLine = graphSubtypes.querySelector('.graph-incidents-subtypes__dotted-line');
        const detailsInfo = graphSubtypes.querySelector('.graph-incidents-subtypes__details-info');
        const toolTip = graphSubtypes.querySelector('.graph-incidents-subtypes__tooltip');
        const toolTipHolder = toolTip.querySelector('.graph-incidents-subtypes__tooltip-holder');
        const toolTipBtn = toolTip.querySelector('.graph-incidents-subtypes__tooltip-btn').outerHTML;
        const toolTipPercent = toolTip.querySelector('.graph-incidents-subtypes__tooltip-percent-num').outerHTML;
        let toolTipTimeout;
        
        const idx = window.mainGraphsData.findIndex(el => el.year == graphSubtypes.dataset.subtypesStartYear);
        const data = structuredClone(idx === -1 ? window.mainGraphsData : window.mainGraphsData.slice(idx));
        

        //calculo el máximo valor de subtypes
        data.forEach(el => {
            el.max_subtype = Math.max(el.social_media_email,el.article_publication,el.article_publication,el.hate_speech,el.vandalism_graffiti, el.physical_harassment, el.assault, el.others);
            el.total_backup = el.total;
            el.total = el.max_subtype ?? 0;
        });

        window.subtypeData.forEach((el,i) => {
            if(el['name'] == 'others'){
                //window.subtypeData.splice(i, 1);
            }
        });
        const subtypeGraphData = window.subtypeData;


        console.log(window.mainGraphsData);
        console.log(window.subtypeData);


        /* const subtypeGraphData = [
            {name: 'all', 'title': 'All', blurb: '', points:[]},
            {name: 'hate_speech', 'title': 'Hate Speech', blurb: '', points:[]},
            {name: 'social_media_mail', 'title': 'Social Media/Email', blurb: '', points:[]},
            {name: 'vandalism_graffiti', 'title': 'Vandalism/Graffiti', blurb: '', points:[]},
            {name: 'physical_harassmentl', 'title': 'Physical Harassment', blurb: '', points:[]},
            {name: 'assault', 'title': 'Assault', blurb: '', points:[]},
            {name: 'article_publications', 'title': 'Article/Publication', blurb: '', points:[]},
        ];  */   
        
        const subtypesStartYear = Number(String(graphSubtypes.dataset.subtypesStartYear).split('-')[0]);

        data.forEach((el, i) => {
            if(i > 0){
                const prevNum = data[i-1].total;
                //el.percentFromPrevYear = Math.round((el.total / prevNum - 1) * 100);
                let percentFromPrevYear = (el.total / prevNum - 1) * 100;
                if(percentFromPrevYear % 1 === 0){
                    percentFromPrevYear = parseInt(percentFromPrevYear);
                }else{
                    percentFromPrevYear = percentFromPrevYear.toFixed(1);
                }
                el.percentFromPrevYear = percentFromPrevYear;
                //exclude subtype data before subtypesStartYear
                const year = Number(String(el.year).split('-')[0]);
                if(year < subtypesStartYear){
                    subtypeGraphData.forEach((elem, i) => {    
                        el[elem.name] = null;
                    });
                }
            }else{
                el.percentFromPrevYear = null;
            }
        });

        const width = 700;
        const height = 300;
        const paddingTB = 14;
        const paddingLR = 26;
        const maxValue = Math.max(...data.map(d => d.total));

        let baselinePathEl, articlePathEl, animPathEl;
        let currentSegment = 0;


        function mapX(index) {
            const step = (width - paddingLR * 2) / (data.length - 1);
            return paddingLR + index * step;
        }

        function mapY(value) {
            const usableHeight = height - paddingTB * 2;
            return paddingTB + usableHeight * (1 - value / maxValue);
        }

        function buildPath(points) {
            return points.map((pt, i) => `${i === 0 ? 'M' : 'L'}${pt.x},${pt.y}`).join(' ');
        }

        function createGraph() {
            const points = data.map((d, i) => ({ x: mapX(i), y: mapY(d.total), label: d.year }));

            subtypeGraphData.forEach((subtype,i) => {
                const isAll = subtype.name == 'all';
                const colorNum = i+1;
                //const subtypesStartYear = Number(String(graphSubtypes.dataset.subtypesStartYear).split('-')[0]);
                data.forEach((d, n) => {
                    /* const year = Number(String(d.year).split('-')[0]);
                    if ((d[subtype.name] !== null && subtypesStartYear <= year) || isAll) { */
                    if (d[subtype.name] !== null || isAll) {
                        subtype.points.push({
                            x: mapX(n), // usamos el índice original
                            y: mapY(d[subtype.name.split('all').join('total')]),
                            label: d.year,
                            year: d.year,
                        });
                    }
                });
                const articlePath = buildPath(subtype.points);
                articlePathEl = document.createElementNS('http://www.w3.org/2000/svg', 'path');
                articlePathEl.setAttribute('d', articlePath);
                articlePathEl.classList.add('graph-incidents-subtypes__baseline','graph-incidents-subtypes__path--color-'+colorNum);
                svg.appendChild(articlePathEl);
                //articlePathEl.setAttribute("stroke-linecap", "round"); // <-- Esto redondea los extremos

                //
                subtype.points.forEach((pt, n) => {
                    const circle = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
                    circle.setAttribute('cx', pt.x);
                    circle.setAttribute('cy', pt.y);
                    circle.setAttribute('r', Math.min(700 * 3 / svg.clientWidth, 3));
                    //circle.setAttribute('tabindex', '0');
                    //circle.setAttribute('aria-label', `${pt.label}: ${data[i].total}`);
                    let circleClasses;
                    if(isAll){
                        circle.classList.add('graph-incidents-subtypes__dot','graph-incidents-subtypes__dot--color-1');
                    }else{
                        circle.classList.add('graph-incidents-subtypes__dot-subtype','graph-incidents-subtypes__dot--color-'+colorNum);
                    }
                    circle.dataset.year = pt.year;
                    circle.dataset.index = n;
                    //
                    circle.addEventListener('mouseenter', e => {
                        const labels = graphSubtypes.querySelectorAll('.graph-incidents-subtypes__timeline-labels button');
                        labels.forEach(label => {
                            if(label.dataset.year == pt.year){
                                label.dispatchEvent(new Event('mouseenter'));
                            }
                        });
                    });
                    circle.addEventListener('mouseleave', e => {
                        const labels = graphSubtypes.querySelectorAll('.graph-incidents-subtypes__timeline-labels button');
                        labels.forEach(label => {
                            if(label.dataset.year == pt.year){
                                label.dispatchEvent(new Event('mouseleave'));
                            }
                        });
                    });
                    circle.addEventListener('click', e => {
                        const labels = graphSubtypes.querySelectorAll('.graph-incidents-subtypes__timeline-labels button');
                        labels.forEach(label => {
                            if(label.dataset.year == pt.year){
                                label.dispatchEvent(new Event('click'));
                            }
                        });
                    });
                    //
                    svg.appendChild(circle);
                });
            });

            /* // ANIMATED LINE (starts at first point)
            animPathEl = document.createElementNS('http://www.w3.org/2000/svg', 'path');
            animPathEl.setAttribute('d', `M${points[0].x},${points[0].y}`);
            animPathEl.classList.add('graph-incidents-subtypes__anim-line');
            animPathEl.setAttribute("stroke-linecap", "round"); // <-- Esto redondea los extremos
            svg.appendChild(animPathEl); */

            window.addEventListener('resize', e => {
                const value = Math.min(700 * 3 / svg.clientWidth, 3);
                svg.querySelectorAll('circle').forEach(circle => {
                    circle.setAttribute('r', value);
                });
                solidLine.classList.remove('graph-incidents-subtypes__solid-line--visible');
                solidLine.style.left = 0;
                labelsPositionX();
                scroller.scrollLeft = 2000;
            });

            // Timeline Labels aligned to dots
            timelineLabels.innerHTML = '';

            function formatThousands(numberString, separator = ',') {
                let number = parseFloat(numberString.replace(/[^0-9.-]/g, ''));
                if (isNaN(number)) return numberString;
                //
                return number.toLocaleString('de-DE', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }).replace('.', separator);
            }
            
            subtypeGraphData[0].points.forEach((pt, i) => {
                const label = document.createElement('button');
                label.textContent = pt.label;
                label.dataset.year = pt.label;
                timelineLabels.appendChild(label);
                //
                let toolTipInnerHTML = '';
                mainGraphsData.forEach(row => {
                    if(row.year == pt.label){
                        let toolTipBtnHTML = toolTipBtn.split('href="#"').join('href="'+String(window.location)+row.year+'/"');
                        let toolTipPercentHTML = toolTipPercent;
                        let html = '';
                        let totalIncidents = '';
                        subtypeGraphData.forEach(subRow => {
                            let name = subRow.name.split('all').join('total');
                            let rowName = formatThousands(String(row[name]),',');
                            if(name == 'total'){
                                totalIncidents = rowName;
                                html += `<li style="visibility:hidden;"></li>`;
                            }else if(row[name] != null){
                                html += `<li data-name="${subRow.name}">${subRow.title}: ${rowName}</li>`;
                            }else{
                                html += `<li style="visibility:hidden;"></li>`;
                            }
                        });
                        toolTipInnerHTML = `
                        <div>
                        Incidents ${pt.label}<br>
                        Total: ${totalIncidents}
                        </div>
                        <ul>
                            ${html}
                        </ul>
                        ${toolTipPercentHTML}
                        ${toolTipBtnHTML}
                        `;
                    }
                });
                //
                label.addEventListener('click', e => {
                    if(window.innerWidth < 1024){
                        //alert('click mobile:'+toolTipInnerHTML);
                        //toolTipHolder.innerHTML = toolTipInnerHTML;
                        window.showIncidentsPopUp(`
                            <div class="graph-incidents-subtypes__tooltip-holder font-body-sm">
                            ${toolTipHolder.innerHTML}
                            </div>
                        `);
                    }
                });
                label.addEventListener('mouseenter', e => {
                    //
                    clearTimeout(toolTipTimeout);
                    //
                    const graphBCR = graphSubtypes.getBoundingClientRect();
                    let targetBCR;
                    //
                    svg.querySelectorAll('circle').forEach(circle => {
                        if(circle.dataset.year == pt.label){
                            if(targetBCR == undefined){
                                targetBCR = circle.getBoundingClientRect();
                            }
                            //circle.classList.add('graph-incidents-subtypes__dot--visible');
                            circle.classList.remove('graph-incidents-subtypes__dot--hide');
                        }else{
                            //circle.classList.remove('graph-incidents-subtypes__dot--visible');
                            circle.classList.add('graph-incidents-subtypes__dot--hide');
                        }
                    });
                    //
                    let left = (targetBCR.left - graphBCR.left + targetBCR.width / 2) - 0.5 + scroller.scrollLeft;
                    solidLine.style.left = left+'px';
                    solidLine.classList.add('graph-incidents-subtypes__solid-line--visible');
                    /* if(pt.label == '2022-2023'){
                        dottedLine.classList.add('graph-incidents-subtypes__dotted-line--hide');
                    }else{
                        dottedLine.classList.remove('graph-incidents-subtypes__dotted-line--hide');
                    } */
                    //
                    if(left > graphBCR.width / 2){
                        toolTip.classList.add('graph-incidents-subtypes__tooltip--left');
                    }else{
                        toolTip.classList.remove('graph-incidents-subtypes__tooltip--left');
                    }
                    //
                    toolTipHolder.innerHTML = toolTipInnerHTML;
                    const filter = graphSubtypes.querySelector('.graph-incidents-subtypes__filter-btn--selected');
                    const percentNum = toolTipHolder.querySelector('.graph-incidents-subtypes__tooltip-percent-num');
                    const qwerty = idx;
                    if(!!filter && Number(filter.dataset.index) > 0){
                        const name = subtypeGraphData[Number(filter.dataset.index)].name;
                        const tootipLi = toolTipHolder.querySelectorAll('li');
                        let hasSubtypes = 0;
                        tootipLi.forEach((li,j) => {
                            if(j == 0 || (name && name == li.dataset.name)){
                                li.style.display = 'block';
                                if(j > 0){
                                    hasSubtypes = 1;
                                }
                            }else{
                                li.style.display = 'none';
                            }
                        });
                        const index = i + qwerty;
                        if(window.mainGraphsData[index-1][name] && hasSubtypes){
                            const percentTxt = percentNum.querySelector('.graph-incidents-subtypes__tooltip-percent-num-txt');
                            
                            let percentValue = ((Number(window.mainGraphsData[index][name]) / Number(window.mainGraphsData[index-1][name]) - 1) * 100).toFixed(1);
                            if(parseInt(percentValue) == 0){
                                percentTxt.innerHTML = '<span>same</span> as prevous year';
                                percentNum.classList.remove('graph-incidents-subtypes__tooltip-percent-num--negative');
                                percentNum.classList.add('graph-incidents-subtypes__tooltip-percent-num--equal');
                            }else if(percentValue < 0){
                                percentTxt.innerHTML = '<span>'+String(percentValue).split('.0').join('')+'%</span> from previous year';
                                percentNum.classList.add('graph-incidents-subtypes__tooltip-percent-num--negative');
                                percentNum.classList.remove('graph-incidents-subtypes__tooltip-percent-num--equal');
                            }else{
                                percentTxt.innerHTML = '<span>'+String(percentValue).split('.0').join('')+'%</span> from previous year';
                                percentNum.classList.remove('graph-incidents-subtypes__tooltip-percent-num--negative','graph-incidents-subtypes__tooltip-percent-num--equal');
                            }
                            //console.log(window.mainGraphsData[i][name]);
                            percentNum.style.display = 'flex';
                        }else{
                            percentNum.style.display = 'none';
                        }
                    }else{
                        const tootipLi = toolTipHolder.querySelectorAll('li');
                        tootipLi.forEach(li => {
                            li.style.display = 'block';
                        });
                        percentNum.style.display = 'none';
                    }
                });
                label.addEventListener('mouseleave', e => {
                    hideToolTipAndsolidLine();
                });
            });
            labelsPositionX();
        }

        function hideToolTipAndsolidLine(interval = 1500){
            clearTimeout(toolTipTimeout);
            toolTipTimeout = setTimeout(() => {
                svg.querySelectorAll('circle').forEach(circle => {
                    circle.classList.remove('graph-incidents-subtypes__dot--hide');
                });
                solidLine.classList.remove('graph-incidents-subtypes__solid-line--visible');
                dottedLine.classList.remove('graph-incidents-subtypes__dotted-line--hide');
            }, interval);
        }

        toolTip.addEventListener('mouseenter', () => {
            clearTimeout(toolTipTimeout);
        });
        toolTip.addEventListener('mouseleave', () => {
            hideToolTipAndsolidLine(0);
        });
        toolTipHolder.addEventListener('click', e => {
            e.stopPropagation();
        });
        document.addEventListener('click', e => {
            hideToolTipAndsolidLine(0);
        });

        function labelsPositionX(){
            const graphBCR = graphSubtypes.getBoundingClientRect();
            const dots = svg.querySelectorAll('.graph-incidents-subtypes__dot');
            const labels = graphSubtypes.querySelectorAll('.graph-incidents-subtypes__timeline-labels button');
            dots.forEach((el,i) => {
                const targetBCR = el.getBoundingClientRect();
                const half = labels[i].clientWidth / 2;
                let left = (targetBCR.left - graphBCR.left + targetBCR.width / 2);
                left += scroller.scrollLeft;
                if(i == 0 && left-half < 0){
                    left = half;
                }
                /* if(i == dots.length-1 && left+half >  svg.clientWidth - half){
                    left = svg.clientWidth - half;
                } */
                //left += 'px';
                labels[i].style.left = left+'px';
                if(labels[i].textContent == '2022-2023'){
                    dottedLine.style.left = (left+12)+'px';
                }
            });
        }

        const filterButtons = graphSubtypes.querySelectorAll('.graph-incidents-subtypes__filter-btn');
        const isTouch = system.iphone || system.ipad || system.android ? 'touch' : 'desktop';
        filterButtons.forEach(elem => {
            elem.classList.add(isTouch);
            elem.addEventListener('click', e => {
                const index = Number(elem.dataset.index);
                const circles = svg.querySelectorAll('circle');
                const colorNum = index+1;
                const selectedBtn = graphSubtypes.querySelector('.graph-incidents-subtypes__filter-btn--selected');
                if(!!selectedBtn){
                    selectedBtn.classList.remove('graph-incidents-subtypes__filter-btn--selected');
                }
                elem.classList.add('graph-incidents-subtypes__filter-btn--selected');
                //
                detailsInfo.classList.remove('graph-incidents-subtypes__details-info--fade-in');
                let text = preventOrphansHTML(subtypeGraphData[index].text);
                if(subtypeGraphData[index].subtitle){
                    detailsInfo.innerHTML = `<p class="graph-incidents-subtypes__details-title">${subtypeGraphData[index].subtitle}</p>${text.split('Hover over').join('<span class="desktop-visible">Hover over</span><span class="mobile-visible">Click on</span>')}`;
                }else{
                    detailsInfo.innerHTML = text.split('Hover over').join('<span class="desktop-visible">Hover over</span><span class="mobile-visible">Click on</span>');
                }
                setTimeout(() => {
                    detailsInfo.classList.add('graph-incidents-subtypes__details-info--fade-in');
                },50);
                //
                if(index == 0){
                    svg.querySelectorAll('path').forEach((path, i) => {
                        path.classList.remove('off');
                    });
                    circles.forEach(circle => {
                        circle.classList.remove('off');
                    });
                }else{
                    svg.querySelectorAll('path').forEach((path, i) => {
                        if(i > 0 && i != index){
                            path.classList.add('off'); 
                        }else{
                            path.classList.remove('off');
                        }
                    });
                    circles.forEach(circle => {
                        if(index == 0 || circle.classList.contains('graph-incidents-subtypes__dot--color-'+colorNum) || circle.classList.contains('graph-incidents-subtypes__dot--color-1')){
                            circle.classList.remove('off');
                        }else{
                            circle.classList.add('off');
                        }
                    });
                }
            });
        });

        // Init
        createGraph();
        scroller.scrollLeft = 2000;//solo para movil (mueve el scroll al final del gráfico)
        filterButtons[0].click();
        setTimeout(() => {
            scroller.before(graphSubtypes.querySelector('.graph-incidents-subtypes__details-wrapper'));
        },200);
    });
}
const startModule = (block) =>{
    startMainGraphs(block);
}
export {startModule};

