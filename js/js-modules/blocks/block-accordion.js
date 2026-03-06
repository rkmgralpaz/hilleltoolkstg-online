import { Accordion } from '../globals/accordion.js';
const startModule = (block) => {
    block.classList.add('loaded');
    const easing = 'ease-in-out';
    block.classList.add('readed')
    let transitionTime = getComputedStyle( block).getPropertyValue('--accordion-transition-time') || '0.3s';
    transitionTime = transitionTime.indexOf('ms') !== -1 ? Math.max(parseInt(transitionTime),parseFloat(transitionTime)) : Math.max(parseInt(transitionTime),parseFloat(transitionTime)) * 1000;
        block.querySelectorAll('details').forEach((el) => {
        new Accordion(el,{animDuration: transitionTime, animEasing: easing});
    });

};

export { startModule };

