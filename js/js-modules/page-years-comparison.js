import { ImagePreloader } from './utils.js?v=032';

const startModule = (block) => {
    block.classList.add('loaded');
    let selectFocused = false;

    //

    
    // Restaurar posición al cargar
    const savedScroll = sessionStorage.getItem('scrollPositionComparisonYears');
    if (savedScroll !== null) {
        window.scrollTo({
            top: parseInt(savedScroll, 10),
            behavior: 'auto'
        });
    }
    
    // Guardar posición antes de salir o recargar
    window.addEventListener('beforeunload', () => {
        sessionStorage.setItem('scrollPositionComparisonYears', window.scrollY);
    });

    block.querySelectorAll('.page-years-comparison__graphs-desktop-year').forEach((el,i) => {
        let othersTotal = 0;
        let top__num = el.querySelector('.top__num');
        let totalGlobal = !!top__num ? Number(top__num.dataset.default) : 0;
        if(!!top__num){
            top__num.textContent = formatThousands(top__num.textContent,',');
        }
        el.querySelectorAll('.graphs-desktop-year__bar').forEach(elem => {
            let total = Number(elem.dataset.total);
            //
            if(elem.dataset.name == 'others'){
                elem.dataset.total = totalGlobal - othersTotal;
                if(el.classList.contains('page-years-comparison__graphs-desktop-y1')){
                    block.querySelector('.page-years-comparison__graphs-mobile-y1 .graphs-mobile-year__bar[data-name="others"] .graphs-mobile-year__bar-num').textContent = totalGlobal - othersTotal;
                    block.querySelector('.page-years-comparison__graphs-mobile-y1 .graphs-mobile-year__bar[data-name="others"]').style.width = (100/totalGlobal*elem.dataset.total)+'%';
                }else if(el.classList.contains('page-years-comparison__graphs-desktop-y2')){
                    block.querySelector('.page-years-comparison__graphs-mobile-y2 .graphs-mobile-year__bar[data-name="others"] .graphs-mobile-year__bar-num').textContent = totalGlobal - othersTotal;
                    block.querySelector('.page-years-comparison__graphs-mobile-y2 .graphs-mobile-year__bar[data-name="others"]').style.width = (100/totalGlobal*elem.dataset.total)+'%';
                }else if(el.classList.contains('page-years-comparison__graphs-desktop-y3')){
                    block.querySelector('.page-years-comparison__graphs-mobile-y3 .graphs-mobile-year__bar[data-name="others"] .graphs-mobile-year__bar-num').textContent = totalGlobal - othersTotal;
                    block.querySelector('.page-years-comparison__graphs-mobile-y3 .graphs-mobile-year__bar[data-name="others"]').style.width = (100/totalGlobal*elem.dataset.total)+'%';
                }
                elem.style.height = (100/totalGlobal*elem.dataset.total)+'%';
            }else{
                othersTotal += isNaN(total) ? 0 : total;
            }
        });
    });

    //
    block.querySelectorAll('.page-comparison-years__select').forEach(select => {
        const targetParam = select.dataset.targetParam;
        select.dataset.prevValue = select.value;
        select.addEventListener('change', e => {
            const value = select.value.split('none').join('');
            if(value == ''){
                select.value = select.dataset.prevValue;
                return false;
            }
            select.dataset.prevValue = select.value;
            const currentYear = select.parentNode.dataset.currentYear ?? null;
            updateUrlParamAndReload(targetParam, value, currentYear);
        });
        select.addEventListener('mousedown', e => {
            selectFocused = true;
            select.classList.add('clicked');
        });
    });
    const subtypeBars = block.querySelectorAll('.graphs-desktop-year__bar--subtype');
    subtypeBars.forEach(el => {
        el.addEventListener('mouseenter', e => {
            const index = el.dataset.index;
            subtypeBars.forEach(elem => {
                if(elem.dataset.index == index){
                    elem.classList.remove('graphs-desktop-year__bar--off');
                }else{
                    elem.classList.add('graphs-desktop-year__bar--off');
                }
            });
            showSubtypeNumData(block, index);
        });
        el.addEventListener('mouseleave', e => {
            subtypeBars.forEach(elem => {
                elem.classList.remove('graphs-desktop-year__bar--off');
            });
            hideSubtypeNumData(block);
        });
    });
    block.querySelectorAll('.graphs-mobile-year__middle span').forEach(el => {
        el.textContent = formatThousands(el.textContent,',');
    });
}

function showSubtypeNumData(block, index) {
    block.querySelectorAll('.page-years-comparison__graphs-desktop-year').forEach(year => {
        const text = year.querySelector('.top__text');
        const num = year.querySelector('.top__num');
        const bars = year.querySelectorAll('.graphs-desktop-year__bar');
        if(!!text && !!num && !!bars[index]){
            text.textContent = bars[index].dataset.title;
            num.textContent = formatThousands(bars[index].dataset.total,',');
            text.classList.add('top__text--opacity-0');
            num.classList.add('top__num--opacity-0');
            setTimeout(() => {
                text.classList.remove('top__text--opacity-0');
                num.classList.remove('top__num--opacity-0');
            }, 50);
        }
    });
}
function hideSubtypeNumData(block) {
    block.querySelectorAll('.page-years-comparison__graphs-desktop-year').forEach(year => {
        const text = year.querySelector('.top__text');
        const num = year.querySelector('.top__num');
        if(!!text && !!num){
            text.textContent = text.dataset.default;
            num.textContent = formatThousands(num.dataset.default,',');
            text.classList.add('top__text--opacity-0');
            num.classList.add('top__num--opacity-0');
            setTimeout(() => {
                text.classList.remove('top__text--opacity-0');
                num.classList.remove('top__num--opacity-0');
            }, 50);
        }
    });
}

function updateUrlParamAndReload(param, value, currentYear) {

    if (!value) return false;

    let url = new URL(window.location.href);
    const currentValue = url.searchParams.get(param);
    if (currentYear) {
        url.searchParams.set(param, currentValue.split(currentYear).join(value));   
    }else{
        const years = currentValue ? currentValue.split(',') : [];
        years.push(value);
        url.searchParams.set(param, [...new Set(years)].join(','));
    }

    window.location.href = decodeURIComponent(url.toString());
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

/* function updateUrlParamAndReload(param, value) {
    // Tomamos la URL actual
    let url = new URL(window.location.href);

    // Cambiamos o agregamos el parámetro
    url.searchParams.set(param, value);

    // Recargamos con la nueva URL
    window.location.href = url.toString();
} */

export { startModule };
