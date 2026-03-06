//import {browserZoom,helper,system, utils, ImagePreloader} from './utils.js?v=032';
const startModule = (block)=>{
    const groups = block.querySelectorAll('.block-cards');
    let timeout;
    let n = -1;
    const nextGroup = () => {
        clearTimeout(timeout);
        n++;
        if(n >= groups.length){
            n = 0;
        }
        groups.forEach(el => {
            el.classList.remove('block-cards--visible','loaded');
            el.classList.remove('block-cards--has-card-flipped');
            el.classList.add('block-cards--transition-running');
            el.classList.remove('block-cards--transition-running');
            const cardFlipped = el.querySelector('.card--flipped');
            if(!!cardFlipped){
                cardFlipped.classList.remove('card--flipped');
                el.querySelector('.arrows-wrapper--visible').classList.remove('arrows-wrapper--visible');
            }
        });
        groups[n].classList.add('block-cards--visible');
        timeout = setTimeout(() => {
            groups[n].classList.add('loaded');
        },100);
    };

    const moreCardsBtn = block.querySelector('.more-cards-btn');
    if(!!moreCardsBtn){
        moreCardsBtn.addEventListener('click',e=>{
            nextGroup();
            moreCardsBtn.scrollIntoView();
        });
    }
    //
    nextGroup();
    block.classList.add('loaded');
}
export {startModule};
